@extends('admin_layout')
@section('admin_content')
<div class="row">
            <div class="col-lg-12">
                    <section class="panel">
                        <header class="panel-heading">
                            Add product 
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
                                <form role="form" action="{{URL::to('/save-product')}}" method="post" enctype="multipart/form-data">
                                {{ csrf_field() }}
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Product name</label>
                                    <input type="text" data-validation="required" data-validation-error-msg="Please input at least one letter" class="form-control" name="product_name" id="exampleInputEmail1" placeholder="Product name">
                                </div>
                                 <div class="form-group">
                                    <label for="exampleInputEmail1">Product quantity</label>
                                    <input type="text" data-validation="number" data-validation-error-msg="Please input the number" class="form-control" name="product_quantity" id="exampleInputEmail1" placeholder="Product quantity">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Product price</label>
                                    <input type="text" data-validation="number" data-validation-error-msg="Please input the number" class="form-control" name="product_price" id="exampleInputEmail1" placeholder="Product price">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Product image</label>
                                    <input type="file" data-validation="required" data-validation-error-msg="Please upload an image for the product" class="form-control" class="form-control" name="product_image" id="exampleInputEmail1">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Product Description</label>
                                    <textarea style="resize: none" rows="8" class="form-control" name="product_desc" id="ckeditor1" placeholder="Product Description"></textarea>
                                </div>
                                 <div class="form-group">
                                    <label for="exampleInputPassword1">Product Content</label>
                                    <textarea style="resize: none" rows="8" class="form-control" name="product_content" id="ckeditor2" placeholder="Product Content"></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Category</label>
                                    <select class="form-control input-lg m-bot15" name="product_category">
                                    @foreach($product_category as $key => $cate)
                                        <option value="{{$cate->category_id}}">{{$cate->category_name}}</option>
                                    @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Manufacturer</label>
                                    <select class="form-control input-lg m-bot15" name="product_manufacturer">
                                    @foreach($product_manufacturer as $key => $manu)
                                        <option value="{{$manu->manufacturer_id}}">{{$manu->manufacturer_name}}</option>
                                    @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Display</label>
                                    <select class="form-control input-lg m-bot15" name="product_status">
                                        <option value="0">Show</option>
                                        <option value="1">Hide</option>
                                    </select>
                                </div>
                                
                                <button type="submit" class="btn btn-info" name="add_product">Add Product</button>
                            </form>
                            </div>

                        </div>
                    </section>

            </div>
@endsection