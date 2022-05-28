<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use Illuminate\Http\Request;
use Session;
use Illuminate\Support\Facades\Redirect;
session_start();
use DB;
class CouponController extends Controller
{
    public function insert_coupon(){
        return view('admin.coupon.insert_coupon');
    }

    public function coupon_list(){
        $coupon = Coupon::orderby('coupon_id','desc')->paginate(6);
        return view('admin.coupon.coupon_list')->with(compact('coupon'));
    }

    public function add_coupon(Request $request){
        $data = $request->all();

        $coupon = new Coupon;
        $coupon->coupon_name = $data['coupon_name'];
        $coupon->coupon_code = $data['coupon_code'];
        $coupon->coupon_condition = $data['coupon_condition'];
        $coupon->coupon_discount = $data['coupon_discount'];
        $coupon->save();

        Session::put('message','Add coupon successfully');
        return Redirect::to('insert-coupon');
    }

    public function delete_coupon($coupon_id){
        $coupon = Coupon::find($coupon_id);
        $coupon->delete();
        Session::put('message','Delete coupon successfully');
        return Redirect::to('coupon-list');
    }

    public function unset_coupon(){
        $coupon = Session::get('coupon');
        if($coupon==true){
          
            Session::forget('coupon');
            return redirect()->back()->with('message','Remove coupon successfully');
        }
    }

    public function search_coupon(Request $request){
        $keywords = $request->keywords_submit;
        $search_coupon = DB::table('tbl_coupon')->where('coupon_name','like','%'.$keywords.'%')->get();
        return view('admin.coupon.search_coupon')->with('search_coupon',$search_coupon);
      
    }
}
