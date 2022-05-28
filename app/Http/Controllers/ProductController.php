<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Http\Requests;
use Session;
use App\Models\Comment;
use Illuminate\Support\Facades\Redirect;
session_start();
use App\Models\Slider;
class ProductController extends Controller
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

    public function add_product(){
        $this->AuthLogin();
        $product_category = DB::table('tbl_product_category')->orderby('category_id','desc')->get();
        $product_manufacturer = DB::table('tbl_manufacturer')->orderby('manufacturer_id','desc')->get();
        return view('admin.add_product')->with('product_category',$product_category)->with('product_manufacturer',$product_manufacturer);
    }

    public function all_product(){
        $this->AuthLogin();
        $all_product = DB::table('tbl_product')
        ->join('tbl_product_category','tbl_product_category.category_id','=','tbl_product.category_id')
        ->join('tbl_manufacturer','tbl_manufacturer.manufacturer_id','=','tbl_product.manufacturer_id')
        ->orderby('tbl_product.product_id','desc')->paginate(6);
        $manager_product = view('admin.all_product')->with('all_product',$all_product);
        return view('admin_layout')->with('admin.all_product',$manager_product);
    }

    public function save_product(Request $request){
        $this->AuthLogin();
        $data = array();
        $data['product_name'] = $request->product_name;
        $data['product_quantity'] = $request->product_quantity;
        $data['product_price'] = $request->product_price;
        $data['product_desc'] = $request->product_desc;
        $data['product_content'] = $request->product_content;
        $data['category_id'] = $request->product_category;
        $data['manufacturer_id'] = $request->product_manufacturer;
        $data['product_status'] = $request->product_status;
        $data['product_image'] = $request->product_image;
        $get_image = $request->file('product_image');
        if($get_image){
            $get_name_image = $get_image->getClientOriginalName();
            $name_image = current(explode('.',$get_name_image));
            $new_image = $name_image.rand(0,99).'.'.$get_image->getClientOriginalExtension();
            $get_image->move('public/upload/product',$new_image);
            $data['product_image'] = $new_image;
            DB::table('tbl_product')->insert($data);
            Session::put('message','Add product successfully');
            return Redirect::to('add-product');
        }
        $data['product_image'] = '';
        DB::table('tbl_product')->insert($data);
        Session::put('message','Add product successfully');
        return Redirect::to('all-product');
    }

    public function unactive_product($product_id){
        $this->AuthLogin();
        DB::table('tbl_product')->where('product_id',$product_id)->update(['product_status'=>1]);
        Session::put('message','Unactivate product successfully');
        return Redirect::to('all-product');
    }

    public function active_product($product_id){
        $this->AuthLogin();
        DB::table('tbl_product')->where('product_id',$product_id)->update(['product_status'=>0]);
        Session::put('message','Activate product successfully');
        return Redirect::to('all-product');
    }

    public function edit_product($product_id){
        $this->AuthLogin();
        $product_category = DB::table('tbl_product_category')->orderby('category_id','desc')->get();
        $product_manufacturer = DB::table('tbl_manufacturer')->orderby('manufacturer_id','desc')->get();
        $edit_product = DB::table('tbl_product')->where('product_id',$product_id)->get();
        $manager_product = view('admin.edit_product')->with('edit_product',$edit_product)->with('product_category',$product_category)->with('product_manufacturer',$product_manufacturer);
        return view('admin_layout')->with('admin.edit_product',$manager_product);
    }

    public function update_product(Request $request,$product_id){
        $this->AuthLogin();
        $data = array();
        $data['product_name'] = $request->product_name;
        $data['product_quantity'] = $request->product_quantity;
        $data['product_price'] = $request->product_price;
        $data['product_desc'] = $request->product_desc;
        $data['product_content'] = $request->product_content;
        $data['category_id'] = $request->product_category;
        $data['manufacturer_id'] = $request->product_manufacturer;
        $data['product_status'] = $request->product_status;
        $get_image = $request->file('product_image');

        if($get_image){
            $get_name_image = $get_image->getClientOriginalName();
            $name_image = current(explode('.',$get_name_image));
            $new_image = $name_image.rand(0,99).'.'.$get_image->getClientOriginalExtension();
            $get_image->move('public/upload/product',$new_image);
            $data['product_image'] = $new_image;
            DB::table('tbl_product')->where('product_id',$product_id)->update($data);
            Session::put('message','Update product successfully');
            return Redirect::to('all-product');
        }
        DB::table('tbl_product')->where('product_id',$product_id)->update($data);
        Session::put('message','Update product successfully');
        return Redirect::to('all-product');

    }

    public function delete_product($product_id){
        $this->AuthLogin();
        DB::table('tbl_product')->where('product_id',$product_id)->delete();
        Session::put('message','Delete product successfully');
        return Redirect::to('all-product');
    }

    //end admin page
    public function product_detail($product_id){
        $slider = Slider::orderBy('slider_id','DESC')->where('slider_status','1')->take(3)->get();
        $product_category = DB::table('tbl_product_category')->where('category_status','0')->orderby('category_id','desc')->get();
        $product_manufacturer = DB::table('tbl_manufacturer')->where('manufacturer_status','0')->orderby('manufacturer_id','desc')->get();
        $product_detail = DB::table('tbl_product')
        ->join('tbl_product_category','tbl_product_category.category_id','=','tbl_product.category_id')
        ->join('tbl_manufacturer','tbl_manufacturer.manufacturer_id','=','tbl_product.manufacturer_id')
        ->where('tbl_product.product_id',$product_id)->get();

        foreach($product_detail as $key => $value){
            $category_id = $value->category_id;
        }
        

        $related_product = DB::table('tbl_product')
        ->join('tbl_product_category','tbl_product_category.category_id','=','tbl_product.category_id')
        ->join('tbl_manufacturer','tbl_manufacturer.manufacturer_id','=','tbl_product.manufacturer_id')
        ->where('tbl_product_category.category_id',$category_id)->whereNotIn('tbl_product.product_id',[$product_id])->get();

        return view('pages.detail.show_detail')->with('category',$product_category)->with('manufacturer',$product_manufacturer)->with('product_detail',$product_detail)->with('relate',$related_product)->with('slider',$slider);

    }

    public function search_product(Request $request){
        $keywords = $request->keywords_submit;
        $search_product = DB::table('tbl_product')->where('product_name','like','%'.$keywords.'%')->join('tbl_product_category','tbl_product_category.category_id','=','tbl_product.category_id')->join('tbl_manufacturer','tbl_manufacturer.manufacturer_id','=','tbl_product.manufacturer_id')->orderby('tbl_product.product_id','desc')->get();
        return view('admin.search_product')->with('search_product',$search_product);
      
    }

}
