<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Http\Requests;
use Session;
use Illuminate\Support\Facades\Redirect;
session_start();
use App\Models\Contact;
use App\Models\Slider;

class ContactController extends Controller
{
    public function contact(){
        $contact = Contact::where('contact_id','1')->first();
        $slider = Slider::orderBy('slider_id','DESC')->where('slider_status','1')->take(3)->get();
        $product_category = DB::table('tbl_product_category')->where('category_status','0')->orderby('category_id','desc')->get();
        $product_manufacturer = DB::table('tbl_manufacturer')->where('manufacturer_status','0')->orderby('manufacturer_id','desc')->get();
        return view('pages.contact.contact')->with('category',$product_category)->with('manufacturer',$product_manufacturer)->with('slider',$slider)->with('contact',$contact);
    }
    
    public function contact_information(){
        $this->AuthLogin();
        $contact = Contact::where('contact_id','1')->first();
        return view('admin.contact.contact_information')->with('contact',$contact);
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

    public function update_contact(Request $request){
        $this->AuthLogin();
        $data = array();
        $data['contact_address'] = $request->contact_address;
        $data['contact_email'] = $request->contact_email;
        $data['contact_phone'] = $request->contact_phone;
        $data['contact_map'] = $request->contact_map;
        $data['working_time'] = $request->working_time;
        $data['contact_page'] = $request->contact_page;
     
        Contact::where('contact_id','1')->update($data);
        Session::put('update-contact-message','Update contact information successfully');
        return Redirect::to('contact-information');

    }
}
