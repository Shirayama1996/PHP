@extends('admin_layout')
@section('admin_content')
<div class="row">
            <div class="col-lg-12">
                    <section class="panel">
                        <header class="panel-heading">
                            Add delivery
                        </header>
                        <div class="panel-body">
                            <div class="position-center">
                                <form>
                                  @csrf
                               
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Choose city</label>
                                    <select class="form-control input-lg m-bot15 choose city" name="city" id="city">
                                        <option value="">--Choose city--</option>
                                    @foreach($city as $key => $ci)
                                        <option value="{{$ci->matp}}">{{$ci->city_name}}</option>
                                    @endforeach
                                    </select>
                                </div>
                                 <div class="form-group">
                                    <label for="exampleInputPassword1">Choose district</label>
                                    <select class="form-control input-lg m-bot15 choose district" name="district" id="district">
                                        <option value="">--Choose district--</option>
                                       
                                    </select>
                                </div>
                                 <div class="form-group">
                                    <label for="exampleInputPassword1">Choose ward</label>
                                    <select class="form-control input-lg m-bot15 ward" name="ward" id="ward">
                                        <option value="">--Choose ward--</option>
                                      
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Delivery fee</label>
                                    <input type="text" data-validation="number" data-validation-error-msg="Please input the number" class="form-control ship_fee" name="ship_fee" id="exampleInputEmail1" placeholder="Delivery fee">
                                </div>
                                
                                <button type="button" class="btn btn-info add_delivery" name="add_delivery">Add delivery fee</button>
                            </form>
                            </div>
                            <div id="load_delivery">


                            </div>
                        </div>
                    </section>

            </div>
@endsection