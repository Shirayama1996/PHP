<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Slider;
use Session;
use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;
use DB;
class SliderController extends Controller
{
    public function AuthLogin(){
        $admin_id = Session::get('admin_id');
        if($admin_id){
            return Redirect::to('dashboard');
        }else{
            return Redirect::to('admin')->send();
        }
    }

    public function manage_slider(){
        $all_slider = Slider::orderBy('slider_id','DESC')->paginate(6);
        return view('admin.slider.list_slider')->with(compact('all_slider'));
    }

    public function add_slider(){
        return view('admin.slider.add_slider');
    }

    public function unactive_slider($slider_id){
        $this->AuthLogin();
        DB::table('tbl_slider')->where('slider_id',$slider_id)->update(['slider_status'=>0]);
        Session::put('message','Unactivate slider successfully');
        return Redirect::to('manage-slider');

    }
    public function active_slider($slider_id){
        $this->AuthLogin();
        DB::table('tbl_slider')->where('slider_id',$slider_id)->update(['slider_status'=>1]);
        Session::put('message','activate slider successfully');
        return Redirect::to('manage-slider');

    }

    public function insert_slider(Request $request){
        
        $this->AuthLogin();

        $data = $request->all();
        $get_image = request('slider_image');
      
        if($get_image){
            $get_name_image = $get_image->getClientOriginalName();
            $name_image = current(explode('.',$get_name_image));
            $new_image =  $name_image.rand(0,99).'.'.$get_image->getClientOriginalExtension();
            $get_image->move('public/upload/slider', $new_image);

            $slider = new Slider();
            $slider->slider_name = $data['slider_name'];
            $slider->slider_image = $new_image;
            $slider->slider_status = $data['slider_status'];
            $slider->slider_desc = $data['slider_desc'];
            $slider->save();
            Session::put('message','Add slider successfully');
            return Redirect::to('add-slider');
        }else{
            Session::put('message','Please add image');
            return Redirect::to('add-slider');
        }
        
    }

    public function delete_slider(Request $request, $slider_id){
        $slider = Slider::find($slider_id);
        $slider->delete();
        Session::put('message','Delete slider successfully');
        return redirect()->back();
    }

    public function search_slider(Request $request){
        $keywords = $request->keywords_submit;
        $search_slider = DB::table('tbl_slider')->where('slider_name','like','%'.$keywords.'%')->get();
        return view('admin.slider.search_slider')->with('search_slider',$search_slider);
      
    }
}
