@extends('layout')
@section('content')
<div class="features_items"><!--features_items-->
        <h2 class="title text-center">ABOUT US</h2>
        <div class="row">
            <div class="col-md-6">
                <p style="line-height: 30px;">{{$introduction->introduction_information}}</p>
            </div>
            <div class="col-md-6">
                <img src="{{URL::to('public/upload/introduction/'.$introduction->introduction_image)}}" height="600px" width="95%">
            </div>
        </div>
</div><!--features_items-->
                   
@endsection