@extends('layout')
@section('content')
<section id="form"><!--form-->
		<div class="container">
			<div class="row">
				<div class="col-sm-9">
					<div class="signup-form"><!--sign up form-->
						<h2 id="signup">Signup now!</h2>
						<?php 
							$verification = Session::get('verification');
							if($verification){
								echo '<span class="text-alert"><h5 class="message-text-align">'.$verification.'</h5></span>';
								Session::put('verification',null);
							}
						?>
						<?php 
							$registration = Session::get('registration');
							if($registration){
								echo '<span class="text-success"><h5 class="message-text-align">'.$registration.'</h5></span>';
								Session::put('registration',null);
							}
						?>
						<form action="{{URL::to('/add-customer')}}" method="POST">
							{{ csrf_field() }}
							<div><input type="text" data-validation="required" class="form-control" data-validation-error-msg="Please input your name" name="customer_name" placeholder="Name"/></div>
							<div><input type="text" data-validation="email" data-validation-error-msg="Your email is invalid or cannot be blank" name="customer_email" class="form-control" placeholder="Email Address"/></div>
							<div><input type="password" data-validation="required" data-validation-error-msg="Please input your password" name="customer_password" class="form-control" placeholder="Password"/></div>
							<div><input type="text" data-validation="number" class="form-control" data-validation-error-msg="Phone cannot be blank and must be number" name="customer_phone" placeholder="Phone"/></div>
							<button type="submit" class="btn btn-primary signup">Signup</button>
						
						<h5 class="signup-login-alert">Already have an account? Please click here for <a href="{{url('/login-checkout')}}">login<a></h5>
						</form>
					</div><!--/sign up form-->
				</div>
			</div>
		</div>
	</section><!--/form-->
@endsection