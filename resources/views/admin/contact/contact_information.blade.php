@extends('admin_layout')
@section('admin_content')
<div class="row">
            <div class="col-lg-12">
                    <section class="panel">
                        <header class="panel-heading">
                            Contact Management
                        </header>
                        <?php
                        $message = Session::get('update-contact-message');
                        if($message){
                            echo '<span class="text-success">'.$message.'</span>';
                            Session::put('update-contact-message',null);
                        }
                        ?>
                        <div class="panel-body">
                            <div class="position-center">
                                <form role="form" action="{{URL::to('/update-contact')}}" method="post">
                                 @csrf
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Address:</label>
                                    <input type="text" data-validation="required" data-validation-error-msg="Cannot keep blank for this field" class="form-control" name="contact_address" id="exampleInputEmail1" value="{{$contact->contact_address}}">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Email:</label>
                                    <input type="text" data-validation="email" data-validation-error-msg="Email is invalid or cannot keep blank" class="form-control" name="contact_email" id="exampleInputEmail1" value="{{$contact->contact_email}}">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Phone:</label>
                                    <input type="text" data-validation="number" data-validation-error-msg="Please input number" class="form-control" name="contact_phone" id="exampleInputEmail1" value="{{$contact->contact_phone}}">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Social page:</label>
                                    <input type="text" class="form-control" name="contact_page" id="exampleInputEmail1" value="{{$contact->contact_page}}">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Working time:</label>
                                    <input type="text" class="form-control" name="working_time" id="exampleInputEmail1" value="{{$contact->working_time}}">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Position:</label>
                                    <textarea style="resize: none" rows="8" class="form-control" name="contact_map" id="exampleInputPassword1">{{$contact->contact_map}}</textarea>
                                </div>
                                <button type="submit" class="btn btn-info" name="add_contact">Update Contact</button>
                            </form>
                            </div>

                        </div>
                    </section>

            </div>
@endsection