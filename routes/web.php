<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//customer
Route::get('/','App\Http\Controllers\HomeController@index');
Route::get('home','App\Http\Controllers\HomeController@index');
Route::post('search','App\Http\Controllers\HomeController@search');
Route::get('like','App\Http\Controllers\HomeController@like');
Route::get('404','App\Http\Controllers\HomeController@error_page');
Route::get('profile-customer{customer_id}','App\Http\Controllers\HomeController@profile_customer');
Route::post('update-customer-profile{customer_id}','App\Http\Controllers\HomeController@update_customer_profile');

//product category customer
Route::get('product-category{category_id}','App\Http\Controllers\CategoryProduct@show_category_home');
Route::get('product-manufacturer{manufacturer_id}','App\Http\Controllers\ManufacturerProduct@show_manufacturer_home');
Route::get('product-detail{product_id}','App\Http\Controllers\ProductController@product_detail');


//admin
Route::get('admin','App\Http\Controllers\AdminController@index');
Route::get('dashboard','App\Http\Controllers\AdminController@show_dashboard');
Route::post('admin-dashboard','App\Http\Controllers\AdminController@dashboard');
Route::get('logout','App\Http\Controllers\AdminController@logout');
Route::post('filter-by-date','App\Http\Controllers\AdminController@filter_by_date');
Route::post('dashboard-filter','App\Http\Controllers\AdminController@dashboard_filter');
Route::post('days-order','App\Http\Controllers\AdminController@days_order');

//product category admin
Route::get('add-product-category','App\Http\Controllers\CategoryProduct@add_product_category');
Route::get('edit-product-category{product_category_id}','App\Http\Controllers\CategoryProduct@edit_product_category');
Route::get('delete-product-category/{product_category_id}','App\Http\Controllers\CategoryProduct@delete_product_category');
Route::get('all-product-category','App\Http\Controllers\CategoryProduct@all_product_category');

Route::get('unactive-product-category/{product_category_id}','App\Http\Controllers\CategoryProduct@unactive_product_category');
Route::get('active-product-category/{product_category_id}','App\Http\Controllers\CategoryProduct@active_product_category');
Route::post('search-product-category','App\Http\Controllers\CategoryProduct@search_product_category');
Route::post('save-product-category','App\Http\Controllers\CategoryProduct@save_product_category');
Route::post('update-product-category/{product_category_id}','App\Http\Controllers\CategoryProduct@update_product_category');


//Login  google
Route::get('/login-google','App\Http\Controllers\CheckoutController@login_google');
Route::get('/google/callback','App\Http\Controllers\CheckoutController@callback_google');


//product manufacturer
Route::get('add-product-manufacturer','App\Http\Controllers\ManufacturerProduct@add_product_manufacturer');
Route::get('edit-product-manufacturer{product_manufacturer_id}','App\Http\Controllers\ManufacturerProduct@edit_product_manufacturer');
Route::get('delete-product-manufacturer/{product_manufacturer_id}','App\Http\Controllers\ManufacturerProduct@delete_product_manufacturer');
Route::get('all-product-manufacturer','App\Http\Controllers\ManufacturerProduct@all_product_manufacturer');

Route::get('unactive-product-manufacturer/{product_manufacturer_id}','App\Http\Controllers\ManufacturerProduct@unactive_product_manufacturer');
Route::get('active-product-manufacturer/{product_manufacturer_id}','App\Http\Controllers\ManufacturerProduct@active_product_manufacturer');
Route::post('search-product-manufacturer','App\Http\Controllers\ManufacturerProduct@search_product_manufacturer');
Route::post('save-product-manufacturer','App\Http\Controllers\ManufacturerProduct@save_product_manufacturer');
Route::post('update-product-manufacturer/{product_manufacturer_id}','App\Http\Controllers\ManufacturerProduct@update_product_manufacturer');

//product 
Route::get('add-product','App\Http\Controllers\ProductController@add_product');
Route::get('edit-product{product_id}','App\Http\Controllers\ProductController@edit_product');
Route::get('delete-product/{product_id}','App\Http\Controllers\ProductController@delete_product');
Route::get('all-product','App\Http\Controllers\ProductController@all_product');
Route::post('search-product','App\Http\Controllers\ProductController@search_product');
Route::get('unactive-product/{product_id}','App\Http\Controllers\ProductController@unactive_product');
Route::get('active-product/{product_id}','App\Http\Controllers\ProductController@active_product');

Route::post('save-product','App\Http\Controllers\ProductController@save_product');
Route::post('update-product/{product_id}','App\Http\Controllers\ProductController@update_product');

//coupon
Route::post('check-coupon','App\Http\Controllers\CartController@check_coupon');
Route::get('insert-coupon','App\Http\Controllers\CouponController@insert_coupon');
Route::get('unset-coupon','App\Http\Controllers\CouponController@unset_coupon');
Route::get('coupon-list','App\Http\Controllers\CouponController@coupon_list');
Route::get('delete-coupon/{coupon_id}','App\Http\Controllers\CouponController@delete_coupon');
Route::post('add-coupon','App\Http\Controllers\CouponController@add_coupon');
Route::post('search-coupon','App\Http\Controllers\CouponController@search_coupon');

//cart
Route::post('update-cart-quantity','App\Http\Controllers\CartController@update_cart_quantity');
Route::post('update-cart','App\Http\Controllers\CartController@update_cart');
Route::post('add-cart-ajax','App\Http\Controllers\CartController@add_cart_ajax');
Route::get('show-cart-ajax','App\Http\Controllers\CartController@show_cart_ajax');
Route::get('delete-to-cart/{rowId}','App\Http\Controllers\CartController@delete_to_cart');
Route::get('delete-product-ajax/{session_id}','App\Http\Controllers\CartController@delete_product_ajax');
Route::get('show-cart','App\Http\Controllers\CartController@show_cart');

//checkout
Route::get('login-checkout','App\Http\Controllers\CheckoutController@login_checkout');
Route::get('logout-checkout','App\Http\Controllers\CheckoutController@logout_checkout');
Route::get('signup','App\Http\Controllers\CheckoutController@signup');
Route::post('add-customer','App\Http\Controllers\CheckoutController@add_customer');
Route::post('order-place','App\Http\Controllers\CheckoutController@order_place');
Route::post('login-customer','App\Http\Controllers\CheckoutController@login_customer');
Route::get('checkout{customer_id}','App\Http\Controllers\CheckoutController@checkout');
Route::get('checkout-without-account','App\Http\Controllers\CheckoutController@checkout_without_account');
Route::get('payment','App\Http\Controllers\CheckoutController@payment');
Route::post('save-checkout-customer','App\Http\Controllers\CheckoutController@save_checkout_customer');
Route::post('select-delivery-home','App\Http\Controllers\CheckoutController@select_delivery_home');
Route::post('calculate-fee','App\Http\Controllers\CheckoutController@calculate_fee');
Route::get('del-fee','App\Http\Controllers\CheckoutController@del_fee');
Route::post('confirm-order','App\Http\Controllers\CheckoutController@confirm_order');

//order
Route::get('view-history{order_code}','App\Http\Controllers\OrderController@view_history');
Route::get('history','App\Http\Controllers\OrderController@history');
Route::get('manage-order','App\Http\Controllers\OrderController@manage_order');
Route::get('view-order{order_code}','App\Http\Controllers\OrderController@view_order');
Route::get('print-order{checkout_code}','App\Http\Controllers\OrderController@print_order');
Route::post('update-order-qty','App\Http\Controllers\OrderController@update_order_qty');
Route::post('update-qty','App\Http\Controllers\OrderController@update_qty');
Route::get('cancel-order/{order_code}','App\Http\Controllers\OrderController@cancel_order');
Route::post('search-order','App\Http\Controllers\OrderController@search_order');

//delivery
Route::get('delivery','App\Http\Controllers\DeliveryController@delivery');
Route::post('select-delivery','App\Http\Controllers\DeliveryController@select_delivery');
Route::post('insert-delivery','App\Http\Controllers\DeliveryController@insert_delivery');
Route::post('select-shipfee','App\Http\Controllers\DeliveryController@select_shipfee');
Route::post('update-delivery','App\Http\Controllers\DeliveryController@update_delivery');

//slider
Route::get('manage-slider','App\Http\Controllers\SliderController@manage_slider');
Route::get('add-slider','App\Http\Controllers\SliderController@add_slider');
Route::post('insert-slider','App\Http\Controllers\SliderController@insert_slider');
Route::get('/unactive-slider/{slider_id}','App\Http\Controllers\SliderController@unactive_slider');
Route::get('/active-slider/{slider_id}','App\Http\Controllers\SliderController@active_slider');
Route::get('/delete-slider/{slider_id}','App\Http\Controllers\SliderController@delete_slider');
Route::post('search-slider','App\Http\Controllers\SliderController@search_slider');

//user
Route::get('add-user','App\Http\Controllers\UserController@add_user');
Route::get('all-user','App\Http\Controllers\UserController@all_user');
Route::post('save-user','App\Http\Controllers\UserController@save_user');
Route::get('edit-user{user_id}','App\Http\Controllers\UserController@edit_user');
Route::post('update-user/{user_id}','App\Http\Controllers\UserController@update_user');
Route::post('search-user','App\Http\Controllers\UserController@search_user');
Route::get('profile-user{user_id}','App\Http\Controllers\UserController@profile_user');
Route::post('update-profile{user_id}','App\Http\Controllers\UserController@update_profile');
Route::get('/unactive-user/{admin_id}','App\Http\Controllers\UserController@unactive_user');
Route::get('/active-user/{admin_id}','App\Http\Controllers\UserController@active_user');

//comment
Route::post('load-comment','App\Http\Controllers\CommentController@load_comment');
Route::post('send-comment','App\Http\Controllers\CommentController@send_comment');
Route::get('comment','App\Http\Controllers\CommentController@comment');
Route::get('delete-comment/{comment_id}','App\Http\Controllers\CommentController@delete_comment');
Route::post('search-comment','App\Http\Controllers\CommentController@search_comment');

//contact
Route::get('contact','App\Http\Controllers\ContactController@contact');
Route::get('contact-information','App\Http\Controllers\ContactController@contact_information');
Route::post('update-contact','App\Http\Controllers\ContactController@update_contact');

//about us
Route::get('introduction','App\Http\Controllers\IntroductionController@introduction');
Route::get('edit-introduction','App\Http\Controllers\IntroductionController@edit_introduction');
Route::post('update-introduction','App\Http\Controllers\IntroductionController@update_introduction');

