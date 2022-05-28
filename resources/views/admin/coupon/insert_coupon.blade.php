@extends('admin_layout')
@section('admin_content')
<div class="row">
            <div class="col-lg-12">
                    <section class="panel">
                        <header class="panel-heading">
                            Add coupon
                        </header>
                        <?php
                        $message = Session::get('message');
                        if($message){
                            echo '<span class="text-success">'.$message.'</span>';
                            Session::put('message',null);
                        }
                        ?>
                        <div class="panel-body">
                            <div class="position-center">
                                <form role="form" action="{{URL::to('/add-coupon')}}" method="post">
                                @csrf
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Coupon name</label>
                                    <input type="text" data-validation="required" data-validation-error-msg="Please input at least one letter" class="form-control" name="coupon_name" id="exampleInputEmail1">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Coupon code</label>
                                    <input type="text" data-validation="length" data-validation-length="min8" data-validation-error-msg="Please input at least 8 including letter and number" class="form-control" name="coupon_code" id="exampleInputEmail1">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Coupon characteristic</label>
                                    <select class="form-control input-lg m-bot15" name="coupon_condition">
                                        <option value="1">By %</option>
                                        <option value="2">By number</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Discount amount</label>
                                    <input type="text" data-validation="number" data-validation-error-msg="Please input a number" class="form-control" name="coupon_discount" id="exampleInputEmail1">
                                </div> 
                                <button type="submit" class="btn btn-info" name="add_coupon">Add Coupon</button>
                            </form>
                            </div>

                        </div>
                    </section>

            </div>
@endsection