<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Http\Requests;
use Session;
use Illuminate\Support\Facades\Redirect;
session_start();
use App\Models\Slider;
use App\Models\Product;
use App\Models\Manufacturer;
class ManufacturerProduct extends Controller
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

    public function add_product_manufacturer(){
        $this->AuthLogin();
        return view('admin.add_product_manufacturer');
    }

    public function all_product_manufacturer(){
        $this->AuthLogin();
        $all_product_manufacturer = DB::table('tbl_manufacturer')->paginate(6);
        $manager_product_manufacturer = view('admin.all_product_manufacturer')->with('all_product_manufacturer',$all_product_manufacturer);
        return view('admin_layout')->with('admin.all_product_manufacturer',$manager_product_manufacturer);
    }

    public function save_product_manufacturer(Request $request){
        $this->AuthLogin();
        $data = array();
        $data['manufacturer_name'] = $request->product_manufacturer_name;
        $data['manufacturer_desc'] = $request->product_manufacturer_desc;
        $data['manufacturer_status'] = $request->product_manufacturer_status;

        DB::table('tbl_manufacturer')->insert($data);
        Session::put('message','Add product manufacturer successfully');
        return Redirect::to('add-product-manufacturer');
    }

    public function unactive_product_manufacturer($product_manufacturer_id){
        $this->AuthLogin();
        DB::table('tbl_manufacturer')->where('manufacturer_id',$product_manufacturer_id)->update(['manufacturer_status'=>1]);
        Session::put('message','Unctivate product manufacturer successfully');
        return Redirect::to('all-product-manufacturer');
    }

    public function active_product_manufacturer($product_manufacturer_id){
        $this->AuthLogin();
        DB::table('tbl_manufacturer')->where('manufacturer_id',$product_manufacturer_id)->update(['manufacturer_status'=>0]);
        Session::put('message','Activate product manufacturer successfully');
        return Redirect::to('all-product-manufacturer');
    }

    public function edit_product_manufacturer($product_manufacturer_id){
        $this->AuthLogin();
        $edit_product_manufacturer = DB::table('tbl_manufacturer')->where('manufacturer_id',$product_manufacturer_id)->get();
        $manager_product_manufacturer = view('admin.edit_product_manufacturer')->with('edit_product_manufacturer',$edit_product_manufacturer);
        return view('admin_layout')->with('admin.edit_product_manufacturer',$manager_product_manufacturer);
    }

    public function update_product_manufacturer(Request $request,$product_manufacturer_id){
        $this->AuthLogin();
        $data = array();
        $data['manufacturer_name'] = $request->product_manufacturer_name;
        $data['manufacturer_desc'] = $request->product_manufacturer_desc;
        DB::table('tbl_manufacturer')->where('manufacturer_id',$product_manufacturer_id)->update($data);
        Session::put('message','Update product manufacturer successfully');
        return Redirect::to('all-product-manufacturer');

    }

    public function delete_product_manufacturer($product_manufacturer_id){
        $this->AuthLogin();
        DB::table('tbl_manufacturer')->where('manufacturer_id',$product_manufacturer_id)->delete();
        Session::put('message','Delete product manufacturer successfully');
        return Redirect::to('all-product-manufacturer');
    }

    public function search_product_manufacturer(Request $request){
        $keywords = $request->keywords_submit;
        $search_product_manufacturer = DB::table('tbl_manufacturer')->where('manufacturer_name','like','%'.$keywords.'%')->get();
        return view('admin.search_product_manufacturer')->with('search_product_manufacturer',$search_product_manufacturer);
    }
    //end function admin page
    public function show_manufacturer_home($manufacturer_id){
        $slider = Slider::orderBy('slider_id','DESC')->where('slider_status','1')->take(3)->get();
        $product_category = DB::table('tbl_product_category')->where('category_status','0')->orderby('category_id','desc')->get();
        $product_manufacturer = DB::table('tbl_manufacturer')->where('manufacturer_status','0')->orderby('manufacturer_id','desc')->get();
        $manufacturer_by_id = DB::table('tbl_product')->join('tbl_manufacturer','tbl_product.manufacturer_id','=','tbl_manufacturer.manufacturer_id')->where('tbl_product.manufacturer_id',$manufacturer_id)->orderby(DB::raw('RAND()'))->paginate(6);
        $manufacturer_name = DB::table('tbl_manufacturer')->where('tbl_manufacturer.manufacturer_id',$manufacturer_id)->limit(1)->get();
        return view('pages.manufacturer.show_manufacturer')->with('category',$product_category)->with('manufacturer',$product_manufacturer)->with('manufacturer_by_id',$manufacturer_by_id)->with('manufacturer_name',$manufacturer_name)->with('slider',$slider);
    }
}
