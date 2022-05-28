@extends('layout')
@section('content')
<section id="cart_items">
		<div class="container">
			<h2 class="title" style="margin-left: 350px; margin-bottom: 70px;">YOUR CART</h2>
			  @if(session()->has('message'))
                    <div class="alert alert-success width-alert">
                        {!! session()->get('message') !!}
                    </div>
                @elseif(session()->has('error'))
                     <div class="alert alert-danger width-alert">
                        {!! session()->get('error') !!}
                    </div>
                @elseif(session()->has('information'))
                     <div class="alert alert-info width-alert">
                        {!! session()->get('information') !!}
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
							<td></td>
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
									
									
									<input class="cart_quantity_input form-control" type="number" min="1" name="cart_qty[{{$cart['session_id']}}]" value="{{$cart['product_qty']}}">
									
									
									
								</div>
							</td>
							<td class="cart_total">
								<p class="cart_total_price">
									{{number_format($subtotal,0,',','.')}} USD
								</p>
							</td>
							<td>
								<a class="cart_quantity_delete" href="{{url('/delete-product-ajax/'.$cart['session_id'])}}"><i class="fa fa-times" style="color: red"></i></a>
							</td>
						</tr>
						@endforeach
						<tr>
							<td><input type="submit" value="Update cart" name="update_qty" class="btn btn-primary"></td>
							<td colspan="3">
								Cart sub total: <span><b>{{number_format($total,0,',','.')}} USD</b></span><br>
								@if(Session::get('coupon'))
								
								
									@foreach(Session::get('coupon') as $key => $cou)
										@if($cou['coupon_condition']==1)
											Coupon characteristic: <b>{{$cou['coupon_discount']}} %</b>
				                          			<a class="cart_quantity_delete" href="{{url('/unset-coupon')}}"><i class="fa fa-times" style="color: red"></i></a>
												@php 
												$total_coupon = ($total*$cou['coupon_discount'])/100;
												@endphp
											
											<p>Total after applying coupon: <b>{{number_format($total-$total_coupon,0,',','.')}} USD</b></p>
										@elseif($cou['coupon_condition']==2)
											Coupon characteristic: <b>{{number_format($cou['coupon_discount'],0,',','.')}} USD</b>
													<a class="cart_quantity_delete" href="{{url('/unset-coupon')}}"><i class="fa fa-times" style="color: red"></i></a>
												@php 
												$total_coupon = $total - $cou['coupon_discount'];
								
												@endphp
											
											<p>Total after applying coupon: <b>{{number_format($total_coupon,0,',','.')}} USD</b></p>
										@endif
									@endforeach
								


								
								@endif 
							{{--	<li>Tax <span></span></li>
								<li>Shipping Cost <span>Free</span></li>--}}
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
					@if(Session::get('cart'))
					<tr>
						<td colspan="4">
                       		<form method="POST" action="{{url('/check-coupon')}}">
                       			@csrf
                            		<input type="text" class="form-control coupon-code" name="coupon" placeholder="Input coupon">
                            		<input type="submit" class="btn btn-primary check_coupon" name="check_coupon" value="Apply">
                        		</form>         
                   			</td>
                   			 <td>
								<?php
                                    $customer_id = Session::get('customer_id');
                                    if($customer_id!=NULL){
                                ?>
	                          			<a class="btn btn-primary" href="{{url('/checkout'.$customer_id)}}">Order</a>
	                          	<?php
	                          		}
	                          		elseif($customer_id==NULL){
	                          	?>
	                          			<a class="btn btn-primary" href="{{url('/login-checkout')}}">Order</a>
	                          	<?php
	                          		}
	                          	?>
							</td>
                   		</tr>
                   		@endif
				</table>
			</div>
		</div>
	</section> <!--/#cart_items-->
{{--<section id="do_action">
		<div class="container">
			<div class="row">
			
				<div class="col-sm-6">
					<div class="total_area">
						<ul>
							<li>Cart Sub Total <span>{{number_format($total,0,',','.')}} USD</span></li>
							<li>Tax <span></span></li>
							<li>Shipping Cost <span>Free</span></li>
							<li>Total <span></span></li>
						</ul>
							
                                <a class="btn btn-default check_out" href="">Checkout</a>
                            	<a class="btn btn-default check_out" href="">Coupon</a>
					</div>
				</div>
			</div>
		</div>
	</section><!--/#do_action-->--}}

@endsection