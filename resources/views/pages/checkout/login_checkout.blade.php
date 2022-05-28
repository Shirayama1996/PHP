@extends('layout')
@section('content')
<section id="form"><!--form-->
		<div class="container">
			<div class="row">
				<div class="col-sm-9 col-sm-offset-1">
					<div class="login-form"><!--login form-->
						<h2 style="text-align: center; font-weight: bold;">Login to your account</h2>
						<form action="{{URL::to('/login-customer')}}" method="POST">
							{{csrf_field()}}
							<input class="form-control" id="emailCustomer" type="text" name="email_account" placeholder="Email">
							<input class="form-control" type="password" name="password_account" placeholder="Password" id="password-field">
							<span toggle="#password-field" class="fa fa-fw fa-eye field-icon toggle-password"></span>
							<span>
								<input type="checkbox" class="checkbox" value="lsRememberCustomer" id="rememberCustomer"> 
								Keep me signed in
							</span>
							<button type="submit" class="btn btn-primary login" onclick="lsRememberCustomer()">Login</button>
							<a href="{{url('/login-google')}}">
   								<img class="google" alt="Google login" src="{{('public/frontend/images/Google.png')}}"/>
  							</a>
  							<?php 
							$message = Session::get('message');
							if($message){
								echo '<span class="text-alert"><h5 class="message-text-align">'.$message.'</h5></span>';
								Session::put('message',null);
							}
							?>
						</form>
  						<h5 class="signup-login-alert">If you don't have an account, please click here for <a href="{{url('/signup')}}">signup<a></h5>
					</div><!--/login form-->
				</div>
			</div>
		</div>
	</section><!--/form-->
@endsection