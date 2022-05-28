@extends('admin_layout')
@section('admin_content')
<div class="row">
            <div class="col-lg-12">
                    <section class="panel">
                        <header class="panel-heading">
                            Update product manufacturer
                        </header>
                        <?php
                        $message = Session::get('message');
                        if($message){
                            echo '<span class="text-alert">'.$message.'</span>';
                            Session::put('message',null);
                        }
                        ?>
                        <div class="panel-body">
                        @foreach($edit_product_manufacturer as $key => $edit_value)
                            <div class="position-center">
                                <form role="form" action="{{URL::to('/update-product-manufacturer/'.$edit_value->manufacturer_id)}}" method="post">
                                {{ csrf_field() }}
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Manufacturer name</label>
                                    <input type="text" data-validation="required" data-validation-error-msg="Please input at least one letter" value="{{$edit_value->manufacturer_name}}" class="form-control" name="product_manufacturer_name" id="exampleInputEmail1" placeholder="Manufacturer name">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Manufacturer Description</label>
                                    <textarea style="resize: none" rows="8" class="form-control" name="product_manufacturer_desc" id="exampleInputPassword1">{{$edit_value->manufacturer_desc}}</textarea>
                                </div>
                                <button type="submit" class="btn btn-info" name="update_product_manufacturer">Update Manufacturer</button>
                            </form>
                            </div>
                        @endforeach
                        </div>
                    </section>

            </div>
@endsection