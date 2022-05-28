@extends('admin_layout')
@section('admin_content')
<div class="row">
            <div class="col-lg-12">
                    <section class="panel">
                        <header class="panel-heading">
                            About Us Introduction
                        </header>
                        <?php
                        $message = Session::get('update-introduction-message');
                        if($message){
                            echo '<span class="text-success">'.$message.'</span>';
                            Session::put('update-introduction-message',null);
                        }
                        ?>
                        <div class="panel-body">
                            <div class="position-center">
                                <form role="form" action="{{URL::to('/update-introduction')}}" method="post" enctype="multipart/form-data">
                                 @csrf
                                <div class="form-group">
                                    <label for="exampleInputPassword1">About us:</label>
                                    <textarea style="resize: none" rows="13" class="form-control" name="introduction_information" id="exampleInputPassword1">{{$introduction->introduction_information}}</textarea>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Store image</label>
                                    <input type="file" class="form-control" name="introduction_image" id="exampleInputEmail1">
                                    <img src="{{URL::to('public/upload/introduction/'.$introduction->introduction_image)}}" height="500px" width="100%">
                                </div>
                                <button type="submit" class="btn btn-info" name="add_introduction">Update Introduction</button>
                            </form>
                            </div>

                        </div>
                    </section>

            </div>
@endsection