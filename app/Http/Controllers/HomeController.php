<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Http\Requests;
use Session;
use Illuminate\Support\Facades\Redirect;
session_start();
use App\Models\CatePost;
use App\Models\Slider;
use App\Models\Product;
class HomeController extends Controller
{
    public function index(Request $request){
        $slider = Slider::orderBy('slider_id','DESC')->where('slider_status','1')->take(3)->get();

        $product_category = DB::table('tbl_product_category')->where('category_status','0')->orderby('category_id','desc')->get();
        $product_manufacturer = DB::table('tbl_manufacturer')->where('manufacturer_status','0')->orderby('manufacturer_id','desc')->get();
        if(isset($_GET['sort_by'])){

            $sort_by = $_GET['sort_by'];

            if($sort_by=='desc'){

                $all_product = Product::where('product_status','0')->orderBy('product_price','DESC')->paginate(6)->appends(request()->query());

            }elseif($sort_by=='asc'){

                $all_product = Product::where('product_status','0')->orderBy('product_price','ASC')->paginate(6)->appends(request()->query());

            }elseif($sort_by=='za'){

                $all_product = Product::where('product_status','0')->orderBy('product_name','DESC')->paginate(6)->appends(request()->query());

            }elseif($sort_by=='az'){

                $all_product = Product::where('product_status','0')->orderBy('product_name','ASC')->paginate(6)->appends(request()->query());
            }
        }
        else{
            $all_product = Product::where('product_status','0')->orderBy('product_id','DESC')->paginate(6);
        }
     
        return view('pages.home')->with('category',$product_category)->with('manufacturer',$product_manufacturer)->with('all_product',$all_product)->with('slider',$slider);
    }

    public function search(Request $request){
        $slider = Slider::orderBy('slider_id','DESC')->where('slider_status','1')->take(3)->get();
        $keywords = $request->keywords_submit;
        $product_category = DB::table('tbl_product_category')->where('category_status','0')->orderby('category_id','desc')->get();
        $product_manufacturer = DB::table('tbl_manufacturer')->where('manufacturer_status','0')->orderby('manufacturer_id','desc')->get();
        $search_product = DB::table('tbl_product')->where('product_name','like','%'.$keywords.'%')->get();
       
        return view('pages.detail.search')->with('category',$product_category)->with('manufacturer',$product_manufacturer)->with('search_product',$search_product)->with('slider',$slider);
      
    }

    public function like(Request $request){
        $slider = Slider::orderBy('slider_id','DESC')->where('slider_status','1')->take(3)->get();
        $product_category = DB::table('tbl_product_category')->where('category_status','0')->orderby('category_id','desc')->get();
        $product_manufacturer = DB::table('tbl_manufacturer')->where('manufacturer_status','0')->orderby('manufacturer_id','desc')->get();
        return view('pages.preference.preference')->with('category',$product_category)->with('manufacturer',$product_manufacturer)->with('slider',$slider);
    }

    public function error_page(){
        return view('errors.404');
    }

    public function profile_customer($customer_id){
        $slider = Slider::orderBy('slider_id','DESC')->where('slider_status','1')->take(3)->get();
        $product_category = DB::table('tbl_product_category')->where('category_status','0')->orderby('category_id','desc')->get();
        $product_manufacturer = DB::table('tbl_manufacturer')->where('manufacturer_status','0')->orderby('manufacturer_id','desc')->get();
        $profile_customer = DB::table('tbl_customer')->where('customer_id',$customer_id)->get();
        Session::put('alert-profile','This profile does not belong to you');
        return view('pages.profile.profile')->with('profile_customer',$profile_customer)
        ->with('category',$product_category)->with('manufacturer',$product_manufacturer)->with('slider',$slider);
    }

    public function update_customer_profile(Request $request,$customer_id){
        $data = array();
        $data['customer_name'] = $request->customer_name;
        $data['customer_email'] = $request->customer_email;
        $data['customer_phone'] = $request->customer_phone;
        $data['customer_sex'] = $request->customer_sex;
        $data['customer_address'] = $request->customer_address;
        $data['customer_birthday'] = $request->customer_birthday;
        DB::table('tbl_customer')->where('customer_id',$customer_id)->update($data);
        $profile_customer = DB::table('tbl_customer')->where('customer_id',$customer_id)->get();
        $slider = Slider::orderBy('slider_id','DESC')->where('slider_status','1')->take(3)->get();
        $product_category = DB::table('tbl_product_category')->where('category_status','0')->orderby('category_id','desc')->get();
        $product_manufacturer = DB::table('tbl_manufacturer')->where('manufacturer_status','0')->orderby('manufacturer_id','desc')->get();
        Session::put('profile-message','Update profile successfully');
        return view('pages.profile.profile')->with('profile_customer',$profile_customer)
        ->with('category',$product_category)->with('manufacturer',$product_manufacturer)->with('slider',$slider);

    }
}
