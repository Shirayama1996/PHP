@extends('layout')
@section('content')
<div class="features_items"><!--features_items-->
        <h2 class="title text-center">CONTACT INFORMATION</h2>
        <div class="row">
            <div class="col-md-12" style="padding-left: 100px; font-size: 20px">
                <p><i>Address:</i> <b>{{$contact->contact_address}}</b></p>
                <p><i>Email:</i> <b>{{$contact->contact_email}}</b></p>
                <p><i>Phone:</i> <b>{{$contact->contact_phone}}</b></p>
                <p><i>Socail page:</i> <a href="{{$contact->contact_page}}">{{$contact->contact_page}}</a></p>
                <p><i>Working time:</i> <b>{{$contact->working_time}}</b></p>
                <p><i>Position:</i> <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3919.1378196360074!2d106.65107391477154!3d10.80075479230501!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31752937dbd12377%3A0xd3dd183e3fe37fcf!2zMjAgQ-G7mW5nIEjDsmEsIFBoxrDhu51uZyA0LCBUw6JuIELDrG5oLCBUaMOgbmggcGjhu5EgSOG7kyBDaMOtIE1pbmgsIOi2iuWNlw!5e0!3m2!1szh-TW!2s!4v1631036536011!5m2!1szh-TW!2s" width="700px" height="450" style="border:0; margin-top: 20px" allowfullscreen="" loading="lazy"></iframe> </p>
            </div>
        </div>
</div><!--features_items-->
                   
@endsection