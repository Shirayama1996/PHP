<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Http\Requests;
use Session;
use Illuminate\Support\Facades\Redirect;
session_start();
use App\Models\Introduction;
use App\Models\Slider;
class IntroductionController extends Controller
{
    public function introduction(){
        $introduction = Introduction::where('introduction_id','1')->first();
        $slider = Slider::orderBy('slider_id','DESC')->where('slider_status','1')->take(3)->get();
        $product_category = DB::table('tbl_product_category')->where('category_status','0')->orderby('category_id','desc')->get();
        $product_manufacturer = DB::table('tbl_manufacturer')->where('manufacturer_status','0')->orderby('manufacturer_id','desc')->get();
        return view('pages.introduction.introduction')->with('category',$product_category)->with('manufacturer',$product_manufacturer)->with('slider',$slider)->with('introduction',$introduction);
    }
    
    public function edit_introduction(){
        $this->AuthLogin();
        $introduction = Introduction::where('introduction_id','1')->first();
        return view('admin.introduction.introduction')->with('introduction',$introduction);
    }

    public function AuthLogin(){
        $admin_id = Session::get('admin_id');
        if($admin_id){
            return Redirect::to('dashboard');
        }
        else{
            return Redirect::to('admin')->send();
        }
    }

    public function update_introduction(Request $request){
        $this->AuthLogin();
        $data = array();
        $data['introduction_information'] = $request->introduction_information;
        $get_image = $request->file('introduction_image');

        if($get_image){
            $get_name_image = $get_image->getClientOriginalName();
            $name_image = current(explode('.',$get_name_image));
            $new_image = $name_image.rand(0,99).'.'.$get_image->getClientOriginalExtension();
            $get_image->move('public/upload/introduction',$new_image);
            $data['introduction_image'] = $new_image;
        }
        
        DB::table('tbl_introduction')->where('introduction_id','1')->update($data);
        Session::put('update-introduction-message','Update introduction successfully');
        return Redirect::to('edit-introduction');

    }
}
