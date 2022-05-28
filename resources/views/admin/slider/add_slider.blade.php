@extends('admin_layout')
@section('admin_content')
<div class="row">
            <div class="col-lg-12">
                    <section class="panel">
                        <header class="panel-heading">
                            Add Slider
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
                                <form role="form" action="{{URL::to('/insert-slider')}}" method="post" enctype="multipart/form-data">
                                {{ csrf_field() }}
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Slider name</label>
                                    <input type="text" data-validation="required" data-validation-error-msg="Please input at least one letter" class="form-control" name="slider_name" id="exampleInputEmail1">
                                </div>
                                 <div class="form-group">
                                    <label for="exampleInputEmail1">Image</label>
                                    <input type="file" data-validation="required" data-validation-error-msg="Please upload an image for the slider" class="form-control" name="slider_image" id="exampleInputEmail1">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Slider Description</label>
                                    <textarea style="resize: none" rows="8" class="form-control" name="slider_desc" id="exampleInputPassword1" placeholder="Category Description"></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Display</label>
                                    <select class="form-control input-lg m-bot15" name="slider_status">
                                        <option value="1">Show</option>
                                        <option value="0">Hide</option>
                                    </select>
                                </div>
                                
                                <button type="submit" class="btn btn-info" name="add_slider">Add Slider</button>
                            </form>
                            </div>

                        </div>
                    </section>

            </div>
@endsection