<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Session;
use App\Models\Login;
session_start();
use Illuminate\Support\Facades\Redirect;
class UserController extends Controller
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
    public function add_user(){
        $this->AuthLogin();
        return view('admin.user.add_user');
    }

    public function all_user(){
        $this->AuthLogin();
        $all_user = DB::table('tbl_admin')->paginate(6);
        $manager_user = view('admin.user.all_user')->with('all_user',$all_user);
        return view('admin_layout')->with('admin.user.all_user',$manager_user);
    }

    public function save_user(Request $request){
        $this->AuthLogin();
        $verification_user = $request->admin_email;
        $result = DB::table('tbl_admin')->where('admin_email',$verification_user)->first();
        if($result){
            Session::put('verification-user','This email already exists, please try another email');
            return Redirect('add-user');
        }
        else{
            $data = array();
            $data['admin_name'] = $request->admin_name;
            $data['admin_email'] = $request->admin_email;
            $data['admin_phone'] = $request->admin_phone;
            $data['admin_password'] = md5($request->admin_password);
            $data['user_role'] = $request->user_role;
            $data['admin_sex'] = $request->admin_sex;
            $data['admin_address'] = $request->admin_address;
            $data['admin_birthday'] = $request->admin_birthday;

            DB::table('tbl_admin')->insert($data);
            Session::put('message','User is created successfully');
            return Redirect::to('add-user');
        }
    }

    public function edit_user($user_id){
        $this->AuthLogin();
        $edit_user = DB::table('tbl_admin')->where('admin_id',$user_id)->get();
        $manager_user = view('admin.user.edit_user')->with('edit_user',$edit_user);
        return view('admin_layout')->with('admin.user.edit_user',$manager_user);
    }

    public function update_user(Request $request,$user_id){
        $this->AuthLogin();
        $data = array();
        $data['admin_name'] = $request->admin_name;
        $data['admin_email'] = $request->admin_email;
        $data['admin_phone'] = $request->admin_phone;
        $data['user_role'] = $request->user_role;
        $data['admin_sex'] = $request->admin_sex;
        $data['admin_address'] = $request->admin_address;
        $data['admin_birthday'] = $request->admin_birthday;
     
        DB::table('tbl_admin')->where('admin_id',$user_id)->update($data);
        Session::put('update-message','Update user information successfully');
        return Redirect::to('all-user');

    }

    public function search_user(Request $request){
        $keywords = $request->keywords_submit;
        $search_user = DB::table('tbl_admin')->where('admin_name','like','%'.$keywords.'%')->get();
        return view('admin.user.search_user')->with('search_user',$search_user);
      
    }

    public function profile_user($user_id){
        $this->AuthLogin();
        $profile_user = DB::table('tbl_admin')->where('admin_id',$user_id)->get();
        $manager_user = view('admin.user.profile_user')->with('profile_user',$profile_user);
        Session::put('alert-profile','This profile does not belong to you');
        return view('admin_layout')->with('admin.user.profile_user',$manager_user);
    }

    public function update_profile(Request $request,$user_id){
        $this->AuthLogin();
        $data = array();
        $data['admin_name'] = $request->admin_name;
        $data['admin_email'] = $request->admin_email;
        $data['admin_phone'] = $request->admin_phone;
        $data['user_role'] = $request->user_role;
        $data['admin_sex'] = $request->admin_sex;
        $data['admin_address'] = $request->admin_address;
        $data['admin_birthday'] = $request->admin_birthday;
        DB::table('tbl_admin')->where('admin_id',$user_id)->update($data);
        $profile_user = DB::table('tbl_admin')->where('admin_id',$user_id)->get();
        $manager_user = view('admin.user.profile_user')->with('profile_user',$profile_user);
        Session::put('profile-message','Update profile successfully');
        return view('admin_layout')->with('admin.user.profile_user',$manager_user);

    }

    public function unactive_user($admin_id){
        $this->AuthLogin();
        DB::table('tbl_admin')->where('admin_id',$admin_id)->update(['user_status'=>2]);
        Session::put('status-message','Unactivate user successfully');
        return Redirect::to('all-user');

    }
    public function active_user($admin_id){
        $this->AuthLogin();
        DB::table('tbl_admin')->where('admin_id',$admin_id)->update(['user_status'=>1]);
        Session::put('status-message','activate user successfully');
        return Redirect::to('all-user');

    }
}
