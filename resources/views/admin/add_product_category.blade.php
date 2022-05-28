@extends('admin_layout')
@section('admin_content')
<div class="row">
            <div class="col-lg-12">
                    <section class="panel">
                        <header class="panel-heading">
                            Add product category
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
                                <form role="form" action="{{URL::to('/save-product-category')}}" method="post">
                                {{ csrf_field() }}
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Category name</label>
                                    <input type="text" data-validation="required" data-validation-error-msg="Please input at least one letter" class="form-control" name="product_category_name" id="exampleInputEmail1" placeholder="Category name">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Category Description</label>
                                    <textarea style="resize: none" rows="8" class="form-control" name="product_category_desc" id="exampleInputPassword1" placeholder="Category Description"></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Display</label>
                                    <select class="form-control input-lg m-bot15" name="product_category_status">
                                        <option value="0">Show</option>
                                        <option value="1">Hide</option>
                                    </select>
                                </div>
                                
                                <button type="submit" class="btn btn-info" name="add_product_category">Add Category</button>
                            </form>
                            </div>

                        </div>
                    </section>

            </div>
@endsection