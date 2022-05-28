@extends('layout')
@section('content')
<section id="cart_items">
		<div class="container">
			<div class="shopper-informations">
				<div class="row">
					
					<div class="col-sm-12 clearfix">
						<div class="bill-to">
							<div class="form-one">
								<div class="row">
									<h1 style="text-align: center;"><b>Shipping Information</b></h1>
									<div class="col-sm-6" style="padding-top: 30px;">
									<i>Note: please add shipping fee before moving to filling the form</i>
									<br>
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
                                
                                <input type="button" value="Add shipping fee" name="calculate_order" class="btn btn-primary btn-sm calculate_delivery" style="margin-left: 125px; width: 35%; margin-bottom: 20px;">
                            	</form>
                            		</div>
                            	<div class="col-sm-6" style="padding-top: 25px;"> 
                            	@foreach($customer_information as $key => $customer)
								<form method="POST">
									@csrf
									<div class="shipping-info-margin"><input type="text" value="{{$customer->customer_email}}" data-validation="email" data-validation-error-msg="Email is invalid or cannot be blank" class="form-control shipping_email" name="shipping_email" placeholder="Email"></div>
									<div class="shipping-info-margin"><input type="text" value="{{$customer->customer_name}}" data-validation="required" data-validation-error-msg="Please input your name" class="form-control shipping_name" name="shipping_name" placeholder="Name"></div>
									<div class="shipping-info-margin"><input type="text" data-validation="required" data-validation-error-msg="Please input your address" class="form-control shipping_address" class="form-control" name="shipping_address" placeholder="Address"></div>
									<div class="shipping-info-margin"><input type="text" class="form-control shipping_phone" data-validation="number" data-validation-error-msg="Phone cannot be blank and must be number" name="shipping_phone" placeholder="Phone"></div>
									<textarea name="shipping_note" class="form-control text-note shipping_note" placeholder="Notes about your order" rows="6"></textarea>
									@if(Session::get('fee'))
										<input type="hidden" name="order_fee" class="order_fee" value="{{Session::get('fee')}}">
									@else 
										<input type="hidden" name="order_fee" class="order_fee" value="10">
									@endif

									@if(Session::get('coupon'))
										@foreach(Session::get('coupon') as $key => $cou)
											<input type="hidden" name="order_coupon" class="order_coupon" value="{{$cou['coupon_code']}}">
										@endforeach
									@else 
										<input type="hidden" name="order_coupon" class="order_coupon" value="no">
									@endif
									<i>Note: make sure to fill the form before making payment</i>
								</form>
								@endforeach
								</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-sm-12 clearfix">
					@if(session()->has('message'))
                    <div class="alert alert-success width-alert">
                        {!! session()->get('message') !!}
                    </div>
                	@elseif(session()->has('error'))
                     <div class="alert alert-danger width-alert">
                        {!! session()->get('error') !!}
                    </div>
                	@endif
						<div class="table-responsive cart_info">
							<form action="{{url('/update-cart')}}" method="POST">
								@csrf
							<table class="table table-condensed" style="margin-bottom: 0">
								<thead>
									<tr class="cart_menu">
										<td class="image">Image</td>
										<td class="description">Description</td>
										<td class="price">Price</td>
										<td class="quantity">Quantity</td>
										<td class="total">Total</td>
									</tr>
								</thead>
								<tbody>
									@if(Session::get('cart')==true)
									@php
										$total = 0;
									@endphp
									@foreach(Session::get('cart') as $key => $cart)
										@php
											$subtotal = $cart['product_price']*$cart['product_qty'];
											$total+=$subtotal;
										@endphp
									<tr>
										<td class="cart_product">
											<img src="{{asset('public/upload/product/'.$cart['product_image'])}}" width="90" alt="" />
										</td>
										<td class="cart_description">
											<p style="font-size: 18px">{{$cart['product_name']}}</p>
										</td>
										<td class="cart_price">
											<p>{{number_format($cart['product_price'],0,',','.')}} USD</p>
										</td>
										<td class="cart_quantity">
											<div class="cart_quantity_button">
												
												
												<input class="cart_quantity_input form-control" type="number" min="1" name="cart_qty[{{$cart['session_id']}}]" value="{{$cart['product_qty']}}" disabled>
												
												
												
											</div>
										</td>
										<td class="cart_total">
											<p class="cart_total_price">
												{{number_format($subtotal,0,',','.')}} USD
											</p>
										</td>
									</tr>
									@endforeach
									<tr>
										<td colspan="2">
											Cart sub total: <span><b>{{number_format($total,0,',','.')}} USD</b></span>
											@if(Session::get('coupon'))
												<br>
											
												@foreach(Session::get('coupon') as $key => $cou)
													@if($cou['coupon_condition']==1)
														Coupon characteristic: <b>{{$cou['coupon_discount']}} % </b>
														
															@php 
															$total_coupon = ($total*$cou['coupon_discount'])/100;
															@endphp
														
														
														@php 
															$total_after_coupon = $total-$total_coupon;
														@endphp
														
													@elseif($cou['coupon_condition']==2)
														Coupon characteristic: <b>{{number_format($cou['coupon_discount'],0,',','.')}} USD </b>
														
															@php 
															$total_coupon = $total - $cou['coupon_discount'];
											
															@endphp
														
														@php 
															$total_after_coupon = $total_coupon;
														@endphp
													@endif
												@endforeach
											


											
											@endif 


										@if(Session::get('fee'))
											<br>
											Shipping Cost: <span><b>{{number_format(Session::get('fee'),0,',','.')}} USD</b></span>
											<a class="cart_quantity_delete" href="{{url('/del-fee')}}"><i class="fa fa-times" style="color: red"></i></a>
										
											<?php $total_after_fee = $total + Session::get('fee'); ?>
										@endif 
										<br>
											Total including shipping fee: <b>
										@php 
											if(Session::get('fee') && !Session::get('coupon')){
												$total_after = $total_after_fee;
												echo number_format($total_after,0,',','.').' USD';
											}elseif(!Session::get('fee') && Session::get('coupon')){
												$total_after = $total_after_coupon;
												echo number_format($total_after,0,',','.').' USD';
											}elseif(Session::get('fee') && Session::get('coupon')){
												$total_after = $total_after_coupon;
												$total_after = $total_after + Session::get('fee');
												echo number_format($total_after,0,',','.').' USD';
											}elseif(!Session::get('fee') && !Session::get('coupon')){
												$total_after = $total;
												echo number_format($total_after,0,',','.').' USD';
											}

										@endphp
										</b>
										<div class="row">
											<div class="col-md-5">
												<div id="paypal-button"></div>
												<input type="hidden" id="total_after" value="{{$total_after}}">
											</div>
											<div class="col-md-7">
												<input type="button" value="Cash On Delivery" name="send_order" class="btn btn-primary btn-sm send_order" style="width: 60%; border-radius: 25px;">
											</div>
										</div>
			                            </td>
									</tr>
									@else
									<tr>
										<td colspan="5"><center>
										@php
											echo 'Please add products to cart';
										@endphp
										</center></td>
									</tr>
									@endif
								</tbody>
								</form>
							</table>
						</div>
					</div>			
				</div>
			</div>
		</div>
	</section> <!--/#cart_items-->


@endsection