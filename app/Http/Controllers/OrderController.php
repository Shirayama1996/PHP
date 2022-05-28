<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Http\Requests;
use Session;
use Illuminate\Support\Facades\Redirect;
session_start();
use App\Models\Shipfee;
use App\Models\Order;
use App\Models\OrderDetails;
use App\Models\Shipping;
use App\Models\Customer;
use App\Models\Coupon;
use App\Models\Product;
use App\Models\Slider;
use App\Models\Statistic;
use PDF;
use Carbon\Carbon;
class OrderController extends Controller
{
    public function AuthLogin(){
        $admin_id = Session::get('admin_id');
        if($admin_id){
            return Redirect::to('dashboard');
        }
        else{
            return Redirect::to('admin')->send();
        }
    }

    public function manage_order(){
        $this->AuthLogin();
        $order = Order::orderby('created_at','DESC')->paginate(6);
        return view('admin.manage_order')->with(compact('order'));
    }

    public function view_order($order_code){
        $order_details = OrderDetails::with('product')->where('order_code',$order_code)->get();
        $order = Order::where('order_code',$order_code)->get();
        foreach($order as $key => $ord){
            $customer_id = $ord->customer_id;
            $shipping_id = $ord->shipping_id;
            $order_status = $ord->order_status;
        }
        $customer = Customer::where('customer_id',$customer_id)->first();
        $shipping = Shipping::where('shipping_id',$shipping_id)->first();

        $order_details_product = OrderDetails::with('product')->where('order_code', $order_code)->get();
        foreach($order_details_product as $key => $order_d){

            $product_coupon = $order_d->product_coupon;
        }
        if($product_coupon != 'no'){
            $coupon = Coupon::where('coupon_code',$product_coupon)->first();
            $coupon_condition = $coupon->coupon_condition;
            $coupon_discount = $coupon->coupon_discount;
        }else{
            $coupon_condition = 2;
            $coupon_discount = 0;
        }

        return view('admin.view_order')->with(compact('order_details','customer','shipping','coupon_condition','coupon_discount','order','order_status'));
    }

    public function print_order($checkout_code) {
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($this->print_order_convert($checkout_code));
        
        return $pdf->stream();
    }

    public function print_order_convert($checkout_code){
        $order_details = OrderDetails::where('order_code',$checkout_code)->get();
        $order = Order::where('order_code',$checkout_code)->get();
        foreach($order as $key => $ord){
            $customer_id = $ord->customer_id;
            $shipping_id = $ord->shipping_id;
        }
        $customer = Customer::where('customer_id',$customer_id)->first();
        $shipping = Shipping::where('shipping_id',$shipping_id)->first();

        $order_details_product = OrderDetails::with('product')->where('order_code', $checkout_code)->get();

        foreach($order_details_product as $key => $order_d){

            $product_coupon = $order_d->product_coupon;
        }
        if($product_coupon != 'no'){
            $coupon = Coupon::where('coupon_code',$product_coupon)->first();

            $coupon_condition = $coupon->coupon_condition;
            $coupon_discount = $coupon->coupon_discount;

            if($coupon_condition==1){
                $coupon_echo = $coupon_discount.'%';
            }elseif($coupon_condition==2){
                $coupon_echo = number_format($coupon_discount,0,',','.').' USD';
            }
        }else{
            $coupon_condition = 2;
            $coupon_discount = 0;

            $coupon_echo = '0';
        
        }

        $output = '';

        $output.='<style>body{
            font-family: DejaVu Sans;
        }
        .table-styling{
            border:1px solid #000;
        }
        .table-styling tbody tr td{
            border:1px solid #000;
        }
        </style>
        <h1><center>Board Game World</center></h1>
        <h4><center>Order Information</center></h4>
        <p>Ordered person</p>
        <table class="table-styling">
                <thead>
                    <tr>
                        <th>Customer name</th>
                        <th>Phone</th>
                        <th>Email</th>
                    </tr>
                </thead>
                <tbody>';
                
        $output.='      
                    <tr>
                        <td>'.$customer->customer_name.'</td>
                        <td>'.$customer->customer_phone.'</td>
                        <td>'.$customer->customer_email.'</td>
                        
                    </tr>';
                

        $output.='              
                </tbody>
            
        </table>

        <p>Deliver to</p>
            <table class="table-styling">
                <thead>
                    <tr>
                        <th>Receiver</th>
                        <th>Address</th>
                        <th>Phone</th>
                        <th>Email</th>
                        <th>Note</th>
                    </tr>
                </thead>
                <tbody>';
                
        $output.='      
                    <tr>
                        <td>'.$shipping->shipping_name.'</td>
                        <td>'.$shipping->shipping_address.'</td>
                        <td>'.$shipping->shipping_phone.'</td>
                        <td>'.$shipping->shipping_email.'</td>
                        <td>'.$shipping->shipping_note.'</td>
                        
                    </tr>';
                

        $output.='              
                </tbody>
            
        </table>

        <p>Ordered items</p>
            <table class="table-styling">
                <thead>
                    <tr>
                        <th>Product name</th>
                        <th>Coupon code</th>
                        <th>Quantity</th>
                        <th>Product price</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>';
            
                $total = 0;

                foreach($order_details_product as $key => $product){

                    $subtotal = $product->product_price*$product->product_sale_quantity;
                    $total+=$subtotal;

                    if($product->product_coupon!='no'){
                        $product_coupon = $product->product_coupon;
                    }else{
                        $product_coupon = 'No coupon';
                    }       

        $output.='      
                    <tr>
                        <td>'.$product->product_name.'</td>
                        <td>'.$product_coupon.'</td>
                        <td><center>'.$product->product_sale_quantity.'</center></td>
                        <td>'.number_format($product->product_price,0,',','.').' USD'.'</td>
                        <td>'.number_format($subtotal,0,',','.').' USD'.'</td>
                        
                    </tr>';
                }

                if($coupon_condition==1){
                    $total_after_coupon = ($total*$coupon_discount)/100;
                    $total_coupon = $total - $total_after_coupon;
                }else{
                    $total_coupon = $total - $coupon_discount;
                }

        $output.= '<tr>
                <td colspan="2">
                    <p>Discount: '.$coupon_echo.'</p>
                    <p>Shipping fee: '.number_format($product->product_shipfee,0,',','.').' USD'.'</p>
                    <p>Payment: '.number_format($total_coupon + $product->product_shipfee,0,',','.').' USD'.'</p>
                </td>
        </tr>';
        $output.='              
                </tbody>
            
        </table>

        
            <table>
                <thead>
                    <tr>
                        <th width="200px">Ordered creator</th>
                        <th width="800px">Receiver</th>
                        
                    </tr>
                    <tr>
                        <th><u><i>Please sign here</i></u></th>
                        <th><u><i>Please sign here</i></u></th>
                        
                    </tr>
                </thead>
                <tbody>';
                        
        $output.='              
                </tbody>
            
        </table>

        ';


        return $output;
    }

    public function update_order_qty(Request $request){
        //update order
        $data = $request->all();
        $order = Order::find($data['order_id']);
        $order->order_status = $data['order_status'];
        $order->save();

        $order_date = $order->order_date;
        $statistic = Statistic::where('order_date',$order_date)->get();
        if($statistic){
            $statistic_count = $statistic->count();
        }
        else{
            $statistic_count = 0;
        }
        if($order->order_status==2){
            $total_order = 0;
            $sales = 0;
            $profit = 0;
            $quantity = 0;
            foreach($data['order_product_id'] as $key => $product_id){
                $product = Product::find($product_id);
                $product_quantity = $product->product_quantity;
                $product_sold = $product->product_sold;
                $product_price = $product->product_price;
                $now = Carbon::now('Asia/Ho_Chi_Minh')->toDateString();
                foreach($data['quantity'] as $key2 => $qty){
                        if($key==$key2){
                                $pro_remain = $product_quantity - $qty;
                                $product->product_quantity = $pro_remain;
                                $product->product_sold = $product_sold + $qty;
                                $product->save();
                                $quantity+=$qty;
                                $sales+=$product_price*$qty;
                                $profit = $sales/2;
                        }
                }
            }
            $total_order+=1;
            if($statistic_count>0){
                $statistic_update = Statistic::where('order_date',$order_date)->first();
                $statistic_update->sales = $statistic_update->sales + $sales;
                $statistic_update->profit =  $statistic_update->profit + $profit;
                $statistic_update->quantity =  $statistic_update->quantity + $quantity;
                $statistic_update->total_order = $statistic_update->total_order + $total_order;
                $statistic_update->save();

            }else{

                $statistic_new = new Statistic();
                $statistic_new->order_date = $order_date;
                $statistic_new->sales = $sales;
                $statistic_new->profit =  $profit;
                $statistic_new->quantity =  $quantity;
                $statistic_new->total_order = $total_order;
                $statistic_new->save();
            }
        }
        
    }

    public function history(){
        if(!Session::get('customer_id')){
            return redirect('login-checkout')->with('message','Please login before viewing order history');
        }
        else{
            $order = Order::where('customer_id',Session::get('customer_id'))->orderby('order_id','DESC')->paginate(10);
            $slider = Slider::orderBy('slider_id','DESC')->where('slider_status','1')->take(3)->get();
            $product_category = DB::table('tbl_product_category')->where('category_status','0')->orderby('category_id','desc')->get();
            $product_manufacturer = DB::table('tbl_manufacturer')->where('manufacturer_status','0')->orderby('manufacturer_id','desc')->get();
            return view('pages.history.history')->with('category',$product_category)->with('manufacturer',$product_manufacturer)->with('slider',$slider)->with('order',$order);
        }
    }

    public function view_history($order_code){
        if(!Session::get('customer_id')){
            return redirect('login-checkout')->with('message','Please login before viewing order history');
        }
        else{
            $order = Order::where('customer_id',Session::get('customer_id'))->orderby('order_id','DESC')->paginate(10);
            $slider = Slider::orderBy('slider_id','DESC')->where('slider_status','1')->take(3)->get();
            $product_category = DB::table('tbl_product_category')->where('category_status','0')->orderby('category_id','desc')->get();
            $product_manufacturer = DB::table('tbl_manufacturer')->where('manufacturer_status','0')->orderby('manufacturer_id','desc')->get();
            $order_details = OrderDetails::with('product')->where('order_code',$order_code)->get();
            $order = Order::where('order_code',$order_code)->first();
            $customer_id = $order->customer_id;
            $shipping_id = $order->shipping_id;
            $order_status = $order->order_status;
            $customer = Customer::where('customer_id',$customer_id)->first();
            $shipping = Shipping::where('shipping_id',$shipping_id)->first();

            $order_details_product = OrderDetails::with('product')->where('order_code', $order_code)->get();
            foreach($order_details_product as $key => $order_d){

                $product_coupon = $order_d->product_coupon;
            }
            if($product_coupon != 'no'){
                $coupon = Coupon::where('coupon_code',$product_coupon)->first();
                $coupon_condition = $coupon->coupon_condition;
                $coupon_discount = $coupon->coupon_discount;
            }else{
                $coupon_condition = 2;
                $coupon_discount = 0;
            }
            return view('pages.history.view_history')->with('category',$product_category)->with('manufacturer',$product_manufacturer)->with('slider',$slider)->with('order',$order)->with('order_details',$order_details)->with('customer',$customer)->with('shipping',$shipping)->with('coupon_condition',$coupon_condition)->with('coupon_discount',$coupon_discount)->with('order',$order)->with('order_status',$order_status);
        }
    }

    public function cancel_order($order_code){
        DB::table('tbl_order')->where('order_code',$order_code)->update(['order_status'=>5]);
        return Redirect::to('history');
    }

    public function search_order(Request $request){
        $keywords = $request->keywords_submit;
        $search_order = DB::table('tbl_order')->where('order_code','like','%'.$keywords.'%')->get();
        return view('admin.search_order')->with('search_order',$search_order);
    }
}
