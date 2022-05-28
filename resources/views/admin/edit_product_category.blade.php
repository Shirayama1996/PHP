@extends('admin_layout')
@section('admin_content')
<div class="row">
            <div class="col-lg-12">
                    <section class="panel">
                        <header class="panel-heading">
                            Update product category
                        </header>
                        <?php
                        $message = Session::get('message');
                        if($message){
                            echo '<span class="text-alert">'.$message.'</span>';
                            Session::put('message',null);
                        }
                        ?>
                        <div class="panel-body">
                        @foreach($edit_product_category as $key => $edit_value)
                            <div class="position-center">
                                <form role="form" action="{{URL::to('/update-product-category/'.$edit_value->category_id)}}" method="post">
                                {{ csrf_field() }}
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Category name</label>
                                    <input type="text" data-validation="required" data-validation-error-msg="Please input at least one letter" value="{{$edit_value->category_name}}" class="form-control" name="product_category_name" id="exampleInputEmail1" placeholder="Category name">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Category Description</label>
                                    <textarea style="resize: none" rows="8" class="form-control" name="product_category_desc" id="exampleInputPassword1">{{$edit_value->category_desc}}</textarea>
                                </div>
                                <button type="submit" class="btn btn-info" name="update_product_category">Update Category</button>
                            </form>
                            </div>
                        @endforeach
                        </div>
                    </section>

            </div>
@endsection