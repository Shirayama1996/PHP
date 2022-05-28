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
use App\Models\ProductCategory;
class CategoryProduct extends Controller
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

    public function add_product_category(){
        $this->AuthLogin();
        return view('admin.add_product_category');
    }

    public function all_product_category(){
        $this->AuthLogin();
        $all_product_category = DB::table('tbl_product_category')->paginate(6);
        $manager_product_category = view('admin.all_product_category')->with('all_product_category',$all_product_category);
        return view('admin_layout')->with('admin.all_product_category',$manager_product_category);
    }

    public function save_product_category(Request $request){
        $this->AuthLogin();
        $data = array();
        $data['category_name'] = $request->product_category_name;
        $data['category_desc'] = $request->product_category_desc;
        $data['category_status'] = $request->product_category_status;

        DB::table('tbl_product_category')->insert($data);
        Session::put('message','Add product category successfully');
        return Redirect::to('add-product-category');
    }

    public function unactive_product_category($product_category_id){
        $this->AuthLogin();
        DB::table('tbl_product_category')->where('category_id',$product_category_id)->update(['category_status'=>1]);
        Session::put('message','Unactivate product category successfully');
        return Redirect::to('all-product-category');
    }

    public function active_product_category($product_category_id){
        $this->AuthLogin();
        DB::table('tbl_product_category')->where('category_id',$product_category_id)->update(['category_status'=>0]);
        Session::put('message','Activate product category successfully');
        return Redirect::to('all-product-category');
    }

    public function edit_product_category($product_category_id){
        $this->AuthLogin();
        $edit_product_category = DB::table('tbl_product_category')->where('category_id',$product_category_id)->get();
        $manager_product_category = view('admin.edit_product_category')->with('edit_product_category',$edit_product_category);
        return view('admin_layout')->with('admin.edit_product_category',$manager_product_category);
    }

    public function update_product_category(Request $request,$product_category_id){
        $this->AuthLogin();
        $data = array();
        $data['category_name'] = $request->product_category_name;
        $data['category_desc'] = $request->product_category_desc;
        DB::table('tbl_product_category')->where('category_id',$product_category_id)->update($data);
        Session::put('message','Update product category successfully');
        return Redirect::to('all-product-category');

    }

    public function delete_product_category($product_category_id){
        $this->AuthLogin();
        DB::table('tbl_product_category')->where('category_id',$product_category_id)->delete();
        Session::put('message','Delete product category successfully');
        return Redirect::to('all-product-category');
    }

    public function search_product_category(Request $request){
        $keywords = $request->keywords_submit;
        $search_product_category = DB::table('tbl_product_category')->where('category_name','like','%'.$keywords.'%')->get();
        return view('admin.search_product_category')->with('search_product_category',$search_product_category);
    }

    //end function admin page
    public function show_category_home($category_id){
        $slider = Slider::orderBy('slider_id','DESC')->where('slider_status','1')->take(3)->get();
        $product_category = DB::table('tbl_product_category')->where('category_status','0')->orderby('category_id','desc')->get();
        $product_manufacturer = DB::table('tbl_manufacturer')->where('manufacturer_status','0')->orderby('manufacturer_id','desc')->get();
        $category_by_id = DB::table('tbl_product')->join('tbl_product_category','tbl_product.category_id','=','tbl_product_category.category_id')->where('tbl_product.category_id',$category_id)->orderby(DB::raw('RAND()'))->paginate(6);
        $category_name = DB::table('tbl_product_category')->where('tbl_product_category.category_id',$category_id)->limit(1)->get();
        return view('pages.category.show_category')->with('category',$product_category)->with('manufacturer',$product_manufacturer)->with('category_by_id',$category_by_id)->with('category_name',$category_name)->with('slider',$slider);
    }


}
