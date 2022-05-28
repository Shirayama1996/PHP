@extends('layout')
@section('content')
<div class="row">
            <div class="col-lg-12">
                    <section class="panel profile">
                        <header class="panel-heading">
                            <h1 style="text-align: center">CUSTOMER PROFILE</h1>
                        </header>
                        <h4 style="text-align: center">
                        <?php
                        $message = Session::get('profile-message');
                        if($message){
                            echo '<span class="text-success">'.$message.'</span>';
                            Session::put('profile-message',null);
                        }
                        ?>
                        </h4>
                        <div class="panel-body">
                        @foreach($profile_customer as $key => $customer)
                        <?php
                            $customer_id = Session::get('customer_id');
                            if($customer->customer_id == $customer_id){
                        ?>  
                            <div class="position-center">
                                <form role="form" action="{{URL::to('/update-customer-profile'.$customer->customer_id)}}" method="post">
                                {{ csrf_field() }}
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Customer name</label>
                                    <input type="text" value="{{$customer->customer_name}}" class="form-control" name="customer_name" id="exampleInputEmail1" data-validation="required" data-validation-error-msg="Customer name cannot be blank">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Customer email</label>
                                    <input type="text" value="{{$customer->customer_email}}" class="form-control" name="customer_email" id="exampleInputEmail1" disabled>
                                    <input type="hidden" value="{{$customer->customer_email}}" class="form-control" name="customer_email" id="exampleInputEmail1">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Customer phone</label>
                                    <input type="text" data-validation="number" data-validation-error-msg="Please input your number" value="{{$customer->customer_phone}}" class="form-control" name="customer_phone" id="exampleInputEmail1">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Date of birth</label>
                                    <input type="date" value="{{$customer->customer_birthday}}" class="form-control" name="customer_birthday" id="exampleInputEmail1">
                                </div>
                                 <div class="form-group">
                                    <label for="exampleInputPassword1">Sex</label>
                                    <select class="form-control input-lg m-bot15" name="customer_sex">
                                        <option value="Male" <?=$customer->customer_sex=="Male" ? 'selected': ''?>>Male</option>
                                        <option value="Female" <?=$customer->customer_sex=="Female" ? 'selected': ''?>>Female</option>
                                    </select>
                                </div>
                                 <div class="form-group">
                                    <label for="exampleInputEmail1">Address</label>
                                    <input type="text" value="{{$customer->customer_address}}" class="form-control" name="customer_address" id="exampleInputEmail1">
                                </div>
                                <button type="submit" class="btn btn-info" name="update_user" style="margin-left: 175px">Update Profile</button>
                            </form>
                            </div>
                        <?php 
                            }
                            else{
                                $alert_profile = Session::get('alert-profile');
                                if($alert_profile){
                                    echo '<span style="margin-left: 125px;" class="text-danger">'.$alert_profile.'</span>';
                                    Session::put('alert-profile',null);
                                }
                            }
                        ?>   
                        @endforeach
                        </div>
                    </section>

            </div>

@endsection