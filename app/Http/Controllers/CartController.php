<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use DB;
use App\Http\Requests;
use Session;
use Illuminate\Support\Facades\Redirect;
session_start();
use Cart;
use App\Models\Coupon;
use App\Models\Slider;
class CartController extends Controller
{
    public function show_cart(){
        $cart = count(Session::get('cart'));
        $output = '';
        $output.='<span class="lucky">'.$cart.'</span>';
        echo $output;
    }

    public function delete_to_cart($rowId){
        Cart::update($rowId,0);
        return Redirect::to('show-cart');
    }

    public function update_cart_quantity(Request $request){
        $rowId = $request->rowId_cart;
        $qty = $request->cart_quantity;
        Cart::update($rowId,$qty);
        return Redirect::to('show-cart');
    }

    public function add_cart_ajax(Request $request){
        $data = $request->all();
        $session_id = substr(md5(microtime()),rand(0,26),5);
        $cart = Session::get('cart');
        if($cart==null){
            Session::forget('coupon');
        }
        if($cart==true){
            $is_available = 0;
            foreach($cart as $key => $val){
                if($val['product_id']==$data['cart_product_id']){
                    $is_available++;
                }
            }
            if($is_available == 0){
                 $cart[] = array(
                'session_id' => $session_id,
                'product_name' => $data['cart_product_name'],
                'product_id' => $data['cart_product_id'],
                'product_image' => $data['cart_product_image'],
                'product_quantity' => $data['cart_product_quantity'],
                'product_qty' => $data['cart_product_qty'],
                'product_price' => $data['cart_product_price'],
            );

                 Session::put('cart',$cart);
            }

        }
        else{
            $cart[] = array(
                'session_id' => $session_id,
                'product_name' => $data['cart_product_name'],
                'product_id' => $data['cart_product_id'],
                'product_image' => $data['cart_product_image'],
                'product_quantity' => $data['cart_product_quantity'],
                'product_qty' => $data['cart_product_qty'],
                'product_price' => $data['cart_product_price'],
            );
            Session::put('cart',$cart);
        }
        
        Session::save();
    }

    public function show_cart_ajax(Request $request){
        $slider = Slider::orderBy('slider_id','DESC')->where('slider_status','1')->take(3)->get();
        $product_category = DB::table('tbl_product_category')->where('category_status','0')->orderby('category_id','desc')->get();
        $product_manufacturer = DB::table('tbl_manufacturer')->where('manufacturer_status','0')->orderby('manufacturer_id','desc')->get();
         return view('pages.cart.cart_ajax')->with('category',$product_category)->with('manufacturer',$product_manufacturer)->with('slider',$slider);
    }

    public function delete_product_ajax($session_id){
        $cart = Session::get('cart');
        // echo '<pre>';
        // print_r($cart);
        // echo '</pre>';
        if($cart==true){
            foreach($cart as $key => $val){
                if($val['session_id']==$session_id){
                    unset($cart[$key]);
                }
            }
            Session::put('cart',$cart);
            return redirect()->back()->with('message','Delete product successfully');

        }else{
            return redirect()->back()->with('message','Delete product fail');
        }
    }

    public function update_cart(Request $request){
        $data = $request->all();
        $cart = Session::get('cart');
        if($cart==true){
            $information = '';
            foreach($data['cart_qty'] as $key => $qty){
                $i = 0;
                foreach($cart as $session => $val){
                    $i++;
                    if($val['session_id']==$key && $qty<=$cart[$session]['product_quantity']){
                        $cart[$session]['product_qty'] = $qty;
                        $information.='<p style="color:green">Update quantity of '.$cart[$session]['product_name'].' successfully</p>';

                    }
                    elseif($val['session_id']==$key && $qty>$cart[$session]['product_quantity']){
                        $information.='<p style="color:red">Update quantity of '.$cart[$session]['product_name'].' fail, we only have '.$cart[$session]['product_quantity'].'</p>';
                    }
                }
            }
            Session::put('cart',$cart);
            return redirect()->back()->with('information',$information);
        }else{
            return redirect()->back()->with('information','Update quantity fail');
        }
    }

    public function check_coupon(Request $request){
        $data = $request->all();
        $coupon = Coupon::where('coupon_code',$data['coupon'])->first();
        if($coupon){
            $count_coupon = $coupon->count();
            if($count_coupon>0){
                $coupon_session = Session::get('coupon');
                if($coupon_session==true){
                    $is_avaiable = 0;
                    if($is_avaiable==0){
                        $cou[] = array(
                            'coupon_code' => $coupon->coupon_code,
                            'coupon_condition' => $coupon->coupon_condition,
                            'coupon_discount' => $coupon->coupon_discount,

                        );
                        Session::put('coupon',$cou);
                    }
                }else{
                    $cou[] = array(
                            'coupon_code' => $coupon->coupon_code,
                            'coupon_condition' => $coupon->coupon_condition,
                            'coupon_discount' => $coupon->coupon_discount,

                        );
                    Session::put('coupon',$cou);
                }
                Session::save();
                return redirect()->back()->with('message','Coupon is applied');
            }

        }else{
            return redirect()->back()->with('error','Coupon does not exist');
        }
    }
}
