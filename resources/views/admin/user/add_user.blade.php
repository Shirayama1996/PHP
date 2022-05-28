@extends('admin_layout')
@section('admin_content')
<?php
    $role = Session::get('user_role');
    if($role==1){
?>
    <div class="row">
            <div class="col-lg-12">
                    <section class="panel">
                        <header class="panel-heading">
                           Add user
                        </header>
                         <?php
                            $message = Session::get('message');
                            $verification_user = Session::get('verification-user');
                            if($message){
                                echo '<span class="text-success">'.$message.'</span>';
                                Session::put('message',null);
                            }
                            elseif($verification_user){
                                echo '<span class="text-alert">'.$verification_user.'</span>';
                                Session::put('verification-user',null);
                            }
                        ?>
                        <div class="panel-body">

                            <div class="position-center">
                                <form action="{{URL::to('save-user')}}" method="post">
                                    @csrf
                                <div class="form-group">
                                    <label for="exampleInputEmail1">User name</label>
                                    <input type="text" name="admin_name" class="form-control" id="exampleInputEmail1" data-validation="required" data-validation-error-msg="User name cannot be blank" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Email</label>
                                    <input type="text" name="admin_email" class="form-control" id="exampleInputEmail1" data-validation="email" data-validation-error-msg="This email is invalid or cannot be blank">
                                </div>
                                 <div class="form-group">
                                    <label for="exampleInputEmail1">Phone</label>
                                    <input type="text" name="admin_phone" class="form-control" id="exampleInputEmail1">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Password</label>
                                    <input type="password" name="admin_password" class="form-control" id="password-field" data-validation="required" data-validation-error-msg="Password cannot be blank">
                                    <span toggle="#password-field" class="fa fa-fw fa-eye field-icon toggle-password"></span>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Address</label>
                                    <input type="text" name="admin_address" class="form-control" id="exampleInputEmail1">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Sex</label>
                                    <select class="form-control input-lg m-bot15" name="admin_sex">
                                        <option value="Male">Male</option>
                                        <option value="Female">Female</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Date of birth</label>
                                    <input type="date" name="admin_birthday" class="form-control" id="exampleInputEmail1">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Role</label>
                                    <select class="form-control input-lg m-bot15" name="user_role">
                                        <option value="1">Admin</option>
                                        <option value="2">Manager</option>
                                    </select>
                                </div>
                             
                                <button type="submit" name="add_category_product" class="btn btn-info">Add user</button>
                                </form>
                            </div>

                        </div>
                    </section>

            </div>
<?php
     }
     else{
?>        
        <span class="text-alert">You don't have this authority</span>
<?php
     }
                 
?>
@endsection