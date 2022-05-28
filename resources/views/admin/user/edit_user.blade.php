@extends('admin_layout')
@section('admin_content')
<?php
    $role = Session::get('user_role');
    $admin_id = Session::get('admin_id');
    if($role==1){
?>
<div class="row">
            <div class="col-lg-12">
                    <section class="panel">
                        <header class="panel-heading">
                            User Information
                        </header>
                        <?php
                        $message = Session::get('message');
                        if($message){
                            echo '<span class="text-alert">'.$message.'</span>';
                            Session::put('message',null);
                        }
                        ?>
                        <div class="panel-body">
                        @foreach($edit_user as $key => $user)
                            <div class="position-center">
                                <form role="form" action="{{URL::to('/update-user/'.$user->admin_id)}}" method="post">
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
                                <div class="form-group">
                                    
                                    <?php
                                    if($user->admin_id!=$admin_id){
                                    ?>  
                                        <label for="exampleInputPassword1">Role</label>
                                        <select class="form-control input-lg m-bot15" name="user_role">
                                            <option value="1" <?=$user->user_role==1 ? 'selected': ''?>>Admin</option>
                                            <option value="2" <?=$user->user_role==2 ? 'selected': ''?>>Manager</option>
                                        </select>
                                    <?php
                                    }
                                    elseif($user->admin_id==$admin_id){
                                    ?>
                                        <input type="hidden" value="{{$user->user_role}}" class="form-control" name="user_role" id="exampleInputEmail1">
                                    <?php
                                    }
                                    ?>
                                </div>
                                <button type="submit" class="btn btn-info" name="update_user">Update User</button>
                            </form>
                            </div>
                        @endforeach
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