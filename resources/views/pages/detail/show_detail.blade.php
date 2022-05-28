@extends('layout')
@section('content')
@foreach($product_detail as $key => $value)
<div class="product-details"><!--product-details-->
						<div class="col-sm-5">
							<div class="view-product">
								<img src="{{URL::to('/public/upload/product/'.$value->product_image)}}" alt="" />
							</div>
						</div>
						<div class="col-sm-7">
							<div class="product-information"><!--/product-information-->
								<img src="images/product-details/new.jpg" class="newarrival" alt="" />
								<h2>{{$value->product_name}}</h2>
								<p>Product ID: {{$value->product_id}}</p>
								<img src="images/product-details/rating.png" alt="" />
								<form method="POST">
									@csrf
									<input type="hidden" value="{{$value->product_id}}" class="cart_product_id_{{$value->product_id}}">

                                    <input type="hidden" value="{{$value->product_name}}" class="cart_product_name_{{$value->product_id}}">

                                    <input type="hidden" value="{{$value->product_image}}" class="cart_product_image_{{$value->product_id}}">

                                    <input type="hidden" value="{{$value->product_quantity}}" class="cart_product_quantity_{{$value->product_id}}">

                                    <input type="hidden" value="{{$value->product_price}}" class="cart_product_price_{{$value->product_id}}">
								<span>
									<span>{{number_format($value->product_price).' '.'USD'}}</span>
									<label>Quantity:</label>
									<input name="qty" type="number" min="1" class="cart_product_qty_{{$value->product_id}}" value="1" />
									<input name="productid_hidden" type="hidden" value="{{$value->product_id}}" />
								</span>
								<?php
                                    $product_quantity = $value->product_quantity ;
                                    if($product_quantity==0){
                                ?>
                                        <button type="button" class="btn btn-default add-to-cart" name="add-to-cart" style="margin-top: 18px; background-color: grey"><i class="fa fa-shopping-cart"></i>SOLD OUT</button>
                                <?php
                                    }
                                    elseif($product_quantity!=0){
                                ?>
                                        <button type="button" class="btn btn-default add-to-cart" data-id_product="{{$value->product_id}}" name="add-to-cart" id="add-to-cart"><i class="fa fa-shopping-cart"></i>Add to cart</button>
                                <?php
                                    }
                                ?>  
								
								
								</form> 
								<?php
									if($product_quantity==0){
								?>	
										<p><b>Status:</b> Sold out</p>
								<?php
									}
									elseif($product_quantity!=0){
								?>
										<p><b>Status:</b> In Stock</p>
										<p><b>Condition:</b> New 100%</p>
								<?php
									}
								?>
								<p><b>Manufacturer:</b> {{$value->manufacturer_name}}</p>
								<p><b>Category:</b> {{$value->category_name}}</p>
								<a href=""><img src="images/product-details/share.png" class="share img-responsive"  alt="" /></a>
							</div><!--/product-information-->
						</div>
					</div><!--/product-details-->

					<div class="category-tab shop-details-tab"><!--category-tab-->
						<div class="col-sm-12">
							<ul class="nav nav-tabs">
								<li><a href="#details" data-toggle="tab">Description</a></li>
								<li><a href="#companyprofile" data-toggle="tab">Product Detail</a></li>
								<li class="active"><a href="#reviews" data-toggle="tab">Reviews</a></li>
							</ul>
						</div>
						<div class="tab-content">
							<div class="tab-pane fade" id="details" >
								<p>{{$value->product_content}}</p>
								
							</div>
							
							<div class="tab-pane fade" id="companyprofile" >
								
								<p>{{$value->product_desc}}</p>
							</div>
							
							
							<div class="tab-pane fade active in" id="reviews" >
								<div class="col-sm-12">
									<style type="text/css">
										.style_comment {
											border: 1px solid #ddd;
											border-radius: 10px;
											background-color: #F0F0E9;
										}
									</style>
									<form>
									@csrf
									<input type="hidden" name="comment_product_id" class="comment_product_id" value="{{$value->product_id}}">
									<div id="comment_show"></div>							
									</form>
									<p><b>Write Your Review</b></p>
									
									<form action="#">
										<span>
											<input style="width:50%; margin-left: 0" type="text" class="commenter" placeholder="Write your name"/>
										</span>
										<textarea name="comment_content" class="comment_content" placeholder="Comment content"></textarea>
										<div id="notify_comment"></div>
										<button type="button" class="btn btn-primary pull-right send-comment">
											Submit
										</button>

									</form>
								</div>
							</div>
							
						</div>
					</div><!--/category-tab-->
@endforeach
					<div class="recommended_items"><!--recommended_items-->
						<h2 class="title text-center">Recommended Items</h2>
						
						<div id="recommended-item-carousel" class="carousel slide" data-ride="carousel">
							<div class="carousel-inner">
								<div class="item active">
								@foreach($relate as $key => $r)
									<div class="col-sm-4">
										<div class="product-image-wrapper">
											<div class="single-products">
                                        		<div class="productinfo text-center">
                                        		<form>
                                            	@csrf
		                                        <input type="hidden" value="{{$r->product_id}}" class="cart_product_id_{{$r->product_id}}">
		                                        <input type="hidden" value="{{$r->product_name}}" class="cart_product_name_{{$r->product_id}}">
		                                        <input type="hidden" value="{{$r->product_quantity}}" class="cart_product_quantity_{{$r->product_id}}">
		                                        <input type="hidden" value="{{$r->product_image}}" class="cart_product_image_{{$r->product_id}}">
		                                        <input type="hidden" value="{{$r->product_price}}" class="cart_product_price_{{$r->product_id}}">
		                                        <input type="hidden" value="1" class="cart_product_qty_{{$r->product_id}}">
                                        			<a href="{{URL::to('/product-detail'.$r->product_id)}}">
                                            		<img src="{{URL::to('public/upload/product/'.$r->product_image)}}" alt="" height="200px"/>
                                            		<h2>{{number_format($r->product_price).' '.'USD'}}</h2>
                                            		<p>{{$r->product_name}}</p>
                                            		</a>
                                            		<?php
			                                            $product_quantity = $r->product_quantity ;
			                                            if($product_quantity==0){
			                                        ?>
			                                                <button type="button" class="btn btn-default add-to-cart" name="add-to-cart" style="background-color: grey"><i class="fa fa-shopping-cart"></i>SOLD OUT</button>
			                                        <?php
			                                            }
			                                            elseif($product_quantity!=0){
			                                        ?>
			                                                <button type="button" class="btn btn-default add-to-cart" data-id_product="{{$r->product_id}}" name="add-to-cart"><i class="fa fa-shopping-cart"></i>Add to cart</button>
			                                        <?php
			                                            }
			                                        ?>   
			                                    <form>    
                                        		</div>
                                       
                                			</div>
										</div>
									</div>
								@endforeach

									
								</div>
								
								
							</div>
							 <a class="left recommended-item-control" href="#recommended-item-carousel" data-slide="prev">
								<i class="fa fa-angle-left"></i>
							  </a>
							  <a class="right recommended-item-control" href="#recommended-item-carousel" data-slide="next">
								<i class="fa fa-angle-right"></i>
							  </a>			
						</div>
					</div><!--/recommended_items-->
@endsection