<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Http\Requests;
use Session;
use Cart;
use Illuminate\Support\Facades\Redirect;
session_start();
use App\Models\Customer;
use App\Models\SocialCustomer;
use Socialite;
use Validator;
use App\Models\City;
use App\Models\District;
use App\Models\Ward;
use App\Models\Shipfee;
use App\Models\Order;
use App\Models\OrderDetails;
use App\Models\Shipping;
use App\Models\Slider;
use Carbon\Carbon;
class CheckoutController extends Controller
{   
    public function AuthLogin(){
        $customer_id = Session::get('customer_id');
        if($customer_id){
            return Redirect::to('checkout');
        }
        else{
            return Redirect::to('login-checkout')->send();
        }
    }

    public function login_checkout(){
        $slider = Slider::orderBy('slider_id','DESC')->where('slider_status','1')->take(3)->get();
        $product_category = DB::table('tbl_product_category')->where('category_status','0')->orderby('category_id','desc')->get();
        $product_manufacturer = DB::table('tbl_manufacturer')->where('manufacturer_status','0')->orderby('manufacturer_id','desc')->get();
        $all_product = DB::table('tbl_product')->where('product_status','0')->orderby(DB::raw('RAND()'))->paginate(6);
        $customer_id = Session::get('customer_id');
        if($customer_id){
            return view('pages.home')->with('category',$product_category)->with('manufacturer',$product_manufacturer)->with('slider',$slider)->with('all_product',$all_product);
        }
        if($customer_id==null){
            return view('pages.checkout.login_checkout')->with('category',$product_category)->with('manufacturer',$product_manufacturer)->with('slider',$slider);
        }
        
    }

    public function add_customer(Request $request){
        $verification = $request->customer_email;
        $result = DB::table('tbl_customer')->where('customer_email',$verification)->first();
        if($result){
            Session::put('verification','This email already exists, please try another email');
            return Redirect('signup');
        }
        else{
            $data = array();
            $data['customer_name'] = $request->customer_name;
            $data['customer_phone'] = $request->customer_phone;
            $data['customer_email'] = $request->customer_email;
            $data['customer_password'] = md5($request->customer_password);
            $customer_id = DB::table('tbl_customer')->insert($data);
            Session::put('registration','Register successfully, now you can login with your account');
            return Redirect('signup');
        }    
    }

    public function checkout($customer_id){
        if(!Session::get('customer_id')){
            return redirect('login-checkout')->with('message','Please login before checkout');
        }
        $slider = Slider::orderBy('slider_id','DESC')->where('slider_status','1')->take(3)->get();
        $product_category = DB::table('tbl_product_category')->where('category_status','0')->orderby('category_id','desc')->get();
        $product_manufacturer = DB::table('tbl_manufacturer')->where('manufacturer_status','0')->orderby('manufacturer_id','desc')->get();
        $city = City::orderby('matp','ASC')->get();
        $customer_information = Customer::where('customer_id',$customer_id)->get();
        return view('pages.checkout.show_checkout')->with('category',$product_category)->with('manufacturer',$product_manufacturer)->with('city',$city)->with('slider',$slider)->with('customer_information',$customer_information);
    }

    public function checkout_without_account(){
        if(!Session::get('customer_id')){
            return redirect('login-checkout')->with('message','Please login before checkout');
        }
        $slider = Slider::orderBy('slider_id','DESC')->where('slider_status','1')->take(3)->get();
        $product_category = DB::table('tbl_product_category')->where('category_status','0')->orderby('category_id','desc')->get();
        $product_manufacturer = DB::table('tbl_manufacturer')->where('manufacturer_status','0')->orderby('manufacturer_id','desc')->get();
        $city = City::orderby('matp','ASC')->get();
        return view('pages.checkout.show_checkout')->with('category',$product_category)->with('manufacturer',$product_manufacturer)->with('city',$city)->with('slider',$slider);
    }

    public function save_checkout_customer(Request $request){
        $data = array();
        $data['shipping_name'] = $request->shipping_name;
        $data['shipping_phone'] = $request->shipping_phone;
        $data['shipping_email'] = $request->shipping_email;
        $data['shipping_note'] = $request->shipping_note;
        $data['shipping_address'] = $request->shipping_address;

        $shipping_id = DB::table('tbl_shipping')->insertGetId($data);
        Session::put('shipping_id',$shipping_id);
        return Redirect('payment');
    }

    public function payment(){
        $slider = Slider::orderBy('slider_id','DESC')->where('slider_status','1')->take(3)->get();
        $product_category = DB::table('tbl_product_category')->where('category_status','0')->orderby('category_id','desc')->get();
        $product_manufacturer = DB::table('tbl_manufacturer')->where('manufacturer_status','0')->orderby('manufacturer_id','desc')->get();
        return view('pages.checkout.payment')->with('category',$product_category)->with('manufacturer',$product_manufacturer)->with('slider',$slider);
    }

    public function order_place(Request $request){
        $data = array();
        $data['payment_method'] = $request->payment_option;
        $data['payment_status'] = 'Waiting for processing';
        $payment_id = DB::table('tbl_payment')->insertGetId($data);


        $order_data = array();
        $order_data['customer_id'] = Session::get('customer_id');
        $order_data['shipping_id'] = Session::get('shipping_id');
        $order_data['payment_id'] = $payment_id;
        $order_data['order_total'] = Cart::total();
        $order_data['order_status'] = 'Waiting for processing';
        $order_id = DB::table('tbl_order')->insertGetId($order_data);
        
        $content = Cart::content();
        foreach($content as $c){
            $order_d_data['order_id'] = $order_id;
            $order_d_data['product_id'] = $c->id;
            $order_d_data['product_name'] = $c->name;
            $order_d_data['product_price'] = $c->price;
            $order_d_data['product_sale_quantity'] = $c->qty;
            DB::table('tbl_order_details')->insert($order_d_data);
        }
        if($data['payment_method']==1){
            echo 'ATM';
        }
        else{
            Cart::destroy();
            $slider = Slider::orderBy('slider_id','DESC')->where('slider_status','1')->take(3)->get();
            $product_category = DB::table('tbl_product_category')->where('category_status','0')->orderby('category_id','desc')->get();
            $product_manufacturer = DB::table('tbl_manufacturer')->where('manufacturer_status','0')->orderby('manufacturer_id','desc')->get();
            return view('pages.checkout.handcash')->with('category',$product_category)->with('manufacturer',$product_manufacturer)->with('slider',$slider);
        }
    }

    public function logout_checkout(){
        Session::flush();
        return Redirect('login-checkout');
    }

    public function login_customer(Request $request){
        $email = $request->email_account;
        $password = md5($request->password_account);
        $cart = Session::get('cart');
        $result = DB::table('tbl_customer')->where('customer_email',$email)->where('customer_password',$password)->first();

        if($result && $cart==null){
            Session::put('customer_id',$result->customer_id);
            Session::put('customer_name',$result->customer_name);
            return Redirect('home');
        }
        elseif($result && $cart!=null){
            Session::put('customer_id',$result->customer_id);
            Session::put('customer_name',$result->customer_name);
            return Redirect('show-cart-ajax');
        }
        else{
            Session::put('message','Incorrect email or password');
            return Redirect('login-checkout');
        }
    }

    public function login_google(){
        return Socialite::driver('google')->redirect();
    }
    public function callback_google(){
        $users = Socialite::driver('google')->stateless()->user(); 

        $authUser = $this->findOrCreateCustomer($users, 'google');

        if($authUser){
            $account_name = Customer::where('customer_id',$authUser->user)->first();
            Session::put('customer_id',$account_name->customer_id);
            Session::put('customer_name',$account_name->customer_name);

        }elseif($customer_new){
            $account_name = Customer::where('customer_id',$authUser->user)->first();
            Session::put('customer_id',$account_name->customer_id);
            Session::put('customer_name',$account_name->customer_name);
        }

        return redirect('home')->with('message', 'Login with Google <span style="color:red">'.$account_name->customer_email.'</span> successfully');  
    }
    public function findOrCreateCustomer($users, $provider){
        $authUser = SocialCustomer::where('provider_user_id', $users->id)->first();
        if($authUser){
            return $authUser;
        }else{
            $customer_new = new SocialCustomer([
                'provider_user_id' => $users->id,
                'provider' => strtoupper($provider)
            ]);

            $customer = Customer::where('customer_email',$users->email)->first();

            if(!$customer){

                $customer = Customer::create([
                    'customer_name' => $users->name,
                    'customer_email' => $users->email,
                    'customer_password' => '',
                    'customer_phone' => ''
                ]);
            }

            $customer_new->customer()->associate($customer);

            $customer_new->save();
            return $customer_new;
        }           

    }

    public function signup() {
        $slider = Slider::orderBy('slider_id','DESC')->where('slider_status','1')->take(3)->get();
        $product_category = DB::table('tbl_product_category')->where('category_status','0')->orderby('category_id','desc')->get();
        $product_manufacturer = DB::table('tbl_manufacturer')->where('manufacturer_status','0')->orderby('manufacturer_id','desc')->get();
        return view('pages.checkout.signup')->with('category',$product_category)->with('manufacturer',$product_manufacturer)->with('slider',$slider);
    }

    public function select_delivery_home(Request $request) {
        $data = $request->all();
        if($data['action']){
            $output = '';
            if($data['action']=="city"){
                $select_district = District::where('matp',$data['ma_id'])->orderby('maqh','ASC')->get();
                $output.='<option>---Choose district---</option>';
                foreach($select_district as $key => $district){
                    $output.='<option value="'.$district->maqh.'">'.$district->district_name.'</option>';
                }
            }
            else{
                $select_ward = Ward::where('maqh',$data['ma_id'])->orderby('xaid','ASC')->get();
                $output.='<option>---Choose ward---</option>';
                foreach($select_ward as $key => $ward){
                    $output.='<option value="'.$ward->xaid.'">'.$ward->ward_name.'</option>';
                }
            }
            echo $output;
        }
    }

    public function calculate_fee(Request $request){
        $data = $request->all();
        if($data['matp']){
            $shipfee = Shipfee::where('fee_matp',$data['matp'])->where('fee_maqh',$data['maqh'])->where('fee_xaid',$data['xaid'])->get();
            if($shipfee){
                $count_shipfee = $shipfee->count();
                if($count_shipfee>0){
                     foreach($shipfee as $key => $fee){
                        Session::put('fee',$fee->fee_shipfee);
                        Session::save();
                    }
                }else{ 
                    Session::put('fee',10);
                    Session::save();
                }
            }
           
        }
    }

    public function del_fee(){
        Session::forget('fee');
        return redirect()->back();
    }
    public function confirm_order(Request $request){
         $data = $request->all();

         $shipping = new Shipping();
         $shipping->shipping_name = $data['shipping_name'];
         $shipping->shipping_email = $data['shipping_email'];
         $shipping->shipping_phone = $data['shipping_phone'];
         $shipping->shipping_address = $data['shipping_address'];
         $shipping->shipping_note = $data['shipping_note'];
         $shipping->shipping_method = $data['shipping_method'];
         $shipping->save();
         $shipping_id = $shipping->shipping_id;

         $checkout_code = substr(md5(microtime()),rand(0,26),5);

  
         $order = new Order;
         $order->customer_id = Session::get('customer_id');
         $order->shipping_id = $shipping_id;
         $order->order_status = 1;
         $order->order_code = $checkout_code;

         date_default_timezone_set('Asia/Ho_Chi_Minh');
         $order_date = Carbon::now('Asia/Ho_Chi_Minh')->format('Y-m-d');
         $order->created_at = now();
         $order->order_date = $order_date;
         $order->delivery_date = date("Y-m-d", strtotime("+3 days"));
         $order->save();

         if(Session::get('cart')==true){
            foreach(Session::get('cart') as $key => $cart){
                $order_details = new OrderDetails;
                $order_details->order_code = $checkout_code;
                $order_details->product_id = $cart['product_id'];
                $order_details->product_name = $cart['product_name'];
                $order_details->product_price = $cart['product_price'];
                $order_details->product_sale_quantity = $cart['product_qty'];
                $order_details->product_coupon =  $data['order_coupon'];
                $order_details->product_shipfee = $data['order_fee'];
                $order_details->save();
            }
         }
         Session::forget('coupon');
         Session::forget('fee');
         Session::forget('cart');
    }
}
