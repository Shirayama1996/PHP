@extends('admin_layout')
@section('admin_content')
            <div class="row">
            <div class="col-lg-12">
                    <section class="panel">
                        <header class="panel-heading">
                            Your Profile
                        </header>
                        <?php
                        $message = Session::get('profile-message');
                        if($message){
                            echo '<span class="text-success">'.$message.'</span>';
                            Session::put('profile-message',null);
                        }
                        ?>
                        <div class="panel-body">
                        @foreach($profile_user as $key => $user) 
                        <?php
                            $admin_id = Session::get('admin_id');
                            if($user->admin_id == $admin_id){
                        ?>      
                                <div class="position-center">
                                <form role="form" action="{{URL::to('/update-profile'.$user->admin_id)}}" method="post">
                                {{ csrf_field() }}
                                <div class="form-group">
                                    <label for="exampleInputEmail1">User name</label>
                                    <input type="text" value="{{$user->admin_name}}" class="form-control" name="admin_name" id="exampleInputEmail1" data-validation="required" data-validation-error-msg="User name cannot be blank">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">User email</label>
                                    <input type="text" value="{{$user->admin_email}}" class="form-control" name="admin_email" id="exampleInputEmail1" disabled>
                                    <input type="hidden" value="{{$user->admin_email}}" class="form-control" name="admin_email" id="exampleInputEmail1">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">User phone</label>
                                    <input type="text" value="{{$user->admin_phone}}" class="form-control" name="admin_phone" id="exampleInputEmail1">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Date of birth</label>
                                    <input type="date" value="{{$user->admin_birthday}}" class="form-control" name="admin_birthday" id="exampleInputEmail1">
                                </div>
                                 <div class="form-group">
                                    <label for="exampleInputPassword1">Sex</label>
                                    <select class="form-control input-lg m-bot15" name="admin_sex">
                                        <option value="Male" <?=$user->admin_sex=="Male" ? 'selected': ''?>>Male</option>
                                        <option value="Female" <?=$user->admin_sex=="Female" ? 'selected': ''?>>Female</option>
                                    </select>
                                </div>
                                 <div class="form-group">
                                    <label for="exampleInputEmail1">Address</label>
                                    <input type="text" value="{{$user->admin_address}}" class="form-control" name="admin_address" id="exampleInputEmail1">
                                </div>
                                <input type="hidden" value="{{$user->user_role}}" class="form-control" name="user_role" id="exampleInputEmail1">
                                <button type="submit" class="btn btn-info" name="update_user">Update User</button>
                            </form>
                            </div>
                        <?php 
                            }
                            elseif($user->admin_id != $admin_id){
                                $alert_profile = Session::get('alert-profile');
                                echo '<span class="text-danger">'.$alert_profile.'</span>';
                                Session::put('alert-profile',null);
                            }
                        ?>   
                                
                        @endforeach
                        </div>
                    </section>
            </div>
@endsection