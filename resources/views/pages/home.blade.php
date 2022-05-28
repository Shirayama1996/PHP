@extends('layout')
@section('content')
<div class="features_items"><!--features_items-->
                        <h2 class="title text-center">New Products</h2>
                        <div class="row">
                            <div class="col-md-4">
                                    <form>
                                        @csrf
                                    <select name="sort" id="sort" class="form-control" style="margin-left: 15px; width: 70%; margin-bottom: 10px;">
                                        <option value="{{Request::url()}}?sort_by=none">--Sort by--</option>
                                        <option value="{{Request::url()}}?sort_by=asc">--Ascending price--</option>
                                        <option value="{{Request::url()}}?sort_by=desc">--Descending price--</option>
                                        <option value="{{Request::url()}}?sort_by=az">--A to Z--</option>
                                        <option value="{{Request::url()}}?sort_by=za">--Z to A--</option>
                                    </select>

                                    </form>
                               
                            </div>
                        </div>
                        @foreach($all_product as $key => $product)
                        
                        <div class="col-sm-4">
                            <div class="product-image-wrapper">
                                <div class="single-products">
                                        <div class="productinfo text-center">
                                        <form>
                                            @csrf
                                        <input type="hidden" value="{{$product->product_id}}" class="cart_product_id_{{$product->product_id}}">
                                        <input type="hidden" id="wishlist_productname{{$product->product_id}}" value="{{$product->product_name}}" class="cart_product_name_{{$product->product_id}}">
                                        <input type="hidden" value="{{$product->product_quantity}}" class="cart_product_quantity_{{$product->product_id}}">
                                        <input type="hidden" value="{{$product->product_image}}" class="cart_product_image_{{$product->product_id}}">
                                        <input type="hidden" id="wishlist_productprice{{$product->product_id}}" value="{{$product->product_price}}" class="cart_product_price_{{$product->product_id}}">
                                        <input type="hidden" value="1" class="cart_product_qty_{{$product->product_id}}">
                                        <a id="wishlist_producturl{{$product->product_id}}" href="{{URL::to('/product-detail'.$product->product_id)}}">
                                            <img id="wishlist_productimage{{$product->product_id}}" src="{{URL::to('public/upload/product/'.$product->product_image)}}" alt="" height="200px"/>
                                            <h2>{{number_format($product->product_price).' '.'USD'}}</h2>
                                            <p>{{$product->product_name}}</p>
                                        </a>
                                        <?php
                                            $product_quantity = $product->product_quantity ;
                                            if($product_quantity==0){
                                        ?>
                                                <button type="button" class="btn btn-default add-to-cart" name="add-to-cart" style="background-color: grey"><i class="fa fa-shopping-cart"></i>SOLD OUT</button>
                                        <?php
                                            }
                                            elseif($product_quantity!=0){
                                        ?>
                                                <button type="button" class="btn btn-default add-to-cart" data-id_product="{{$product->product_id}}" name="add-to-cart"><i class="fa fa-shopping-cart"></i>Add to cart</button>
                                        <?php
                                            }
                                        ?>   
                                        </form>
                                        </div>
                                       
                                </div>
                                <div class="choose">
                                    <ul class="nav nav-pills nav-justified">
                                        <li><i class="fa fa-heart" id="heart"></i><button class="button_wishlist" id="{{$product->product_id}}" onclick="add_wishlist(this.id);"><span>Like</span></button></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div><!--features_items-->
                    <ul class="pagination pagination-sm m-t-none m-b-none" style="margin-left:360px">
                       {!!$all_product->links()!!}
                    </ul>
@endsection