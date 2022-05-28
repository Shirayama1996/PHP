<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Board Game World</title>
    <link href="{{asset('public/frontend/css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('public/frontend/css/font-awesome.min.css')}}" rel="stylesheet">
    <link href="{{asset('public/frontend/css/prettyPhoto.css')}}" rel="stylesheet">
    <link href="{{asset('public/frontend/css/price-range.css')}}" rel="stylesheet">
    <link href="{{asset('public/frontend/css/animate.css')}}" rel="stylesheet">
    <link href="{{asset('public/frontend/css/main.css')}}" rel="stylesheet">
    <link href="{{asset('public/frontend/css/responsive.css')}}" rel="stylesheet">
    <link href="{{asset('public/frontend/css/sweetalert.css')}}" rel="stylesheet">
    <!--[if lt IE 9]>
    <script src="js/html5shiv.js"></script>
    <script src="js/respond.min.js"></script>
    <![endif]-->       
    <link rel="shortcut icon" href="{{('public/frontend/images/ico/favicon.ico')}}">
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="images/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="images/ico/apple-touch-icon-114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="images/ico/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="images/ico/apple-touch-icon-57-precomposed.png">
</head><!--/head-->

<body>
    <header id="header"><!--header-->
        <div class="header_top"><!--header_top-->
            <div class="container">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="social-icons pull-left">
                            <ul class="nav navbar-nav">
                                <li><a href="https://www.facebook.com/luan.le.9216778/"><i class="fa fa-facebook"></i></a></li>
                                <li><a href="https://www.instagram.com/luan.le.9216778/"><i class="fa fa-instagram"></i></a></li>
                                <li><a href="https://mail.google.com/"><i class="fa fa-google-plus"></i></a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="pull-right shop-menu">
                            <ul class="nav navbar-nav">
                                <?php
                                    $customer_id = Session::get('customer_id');
                                    if($customer_id!=NULL){
                                ?>
                                    <li><a href="{{URL::to('history')}}"><i class="fa fa-list-alt"></i> ORDER HISTORY</a></li>
                                <?php
                                }
                                ?>
                                <li><a href="{{URL::to('/signup')}}"><i class="fa fa-plus"></i> SIGNUP</a></li>
                                <?php
                                    $customer_id = Session::get('customer_id');
                                    if($customer_id!=NULL){
                                ?>
                                    <li class="dropdown">
                                        <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                                            <i class="fa fa-user"></i>
                                            <span class="username">
                                                <?php
                                                $name = Session::get('customer_name');
                                                if($name){
                                                    echo $name;
                                                }
                                                ?>
                                            </span>
                                            <b class="caret"></b>
                                        </a>
                                        <ul class="dropdown-menu extended logout">
                                            <li><a href="{{URL::to('/profile-customer'.$customer_id)}}"><i class=" fa fa-suitcase"></i> Profile</a></li>
                                            <li><a href="{{URL::to('/logout-checkout')}}"><i class="fa fa-key"></i> Log Out</a></li>
                                        </ul>
                                    </li>
                                <?php
                                }
                                else{
                                ?>
                                    <li><a href="{{URL::to('/login-checkout')}}"><i class="fa fa-lock"></i> LOGIN</a></li>
                                <?php
                                }
                                ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div><!--/header_top-->
        
        <div class="header-middle"><!--header-middle-->
            <div class="container">
                <div class="row">
                    <div class="col-sm-7">
                        <div class="logo pull-left logo-center">
                            <a href="{{URL::to('/home')}}"><img src="{{('public/frontend/images/logo.png')}}" alt="" /></a>
                        </div>
                    </div>
                    <div class="col-sm-15">
                        <form action="{{URL::to('/search')}}" method="POST">
                            {{csrf_field()}}
                        <div class="pull-right">
                            <input type="text" name="keywords_submit" class="form-control search-box" placeholder="Search product">
                            <input type="submit" name="search_items" class="btn btn-primary search-button" value="Search"/>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div><!--/header-middle-->
        <nav class="navbar navbar-default desktop-menu" id="navbar">
            <div class="container">
                <ul class="nav navbar-nav">
                    <li class="nav-me"><a class="nav-word" href="{{URL::to('/home')}}"><i class="fa fa-home"></i> HOME</a></li>
                    <li class="nav-me"><a class="nav-word" href="{{URL::to('/introduction')}}"><i class="fa fa-users"></i> ABOUT US</a></li>
                    <li class="nav-me"><a class="nav-word" href="{{URL::to('/like')}}"><i class="fa fa-heart"></i> WISHLIST</a></li>
                    <?php
                        if($customer_id!=NULL){
                    ?>
                            <li class="nav-me"><a class="nav-word" href="{{URL::to('/checkout'.$customer_id)}}"><i class="fa fa-money"></i> CHECKOUT</a></li>
                    <?php
                        }
                        elseif($customer_id==NULL){
                    ?>
                            <li class="nav-me"><a class="nav-word" href="{{URL::to('/checkout-without-account')}}"><i class="fa fa-money"></i> CHECKOUT</a></li>
                    <?php
                        }
                    ?>
                    <li class="nav-me"><a class="nav-word" href="{{URL::to('/contact')}}"><i class="fa fa-phone"></i> CONTACT</a></li>
                    <li class="nav-me"><a class="nav-word" href="{{URL::to('/show-cart-ajax')}}"><i class="fa fa-shopping-cart"></i> CART<span id="show-cart"></span></a></li>
                </ul>
            </div>
        </nav>
    </header><!--/header-->
    
    <section id="slider"><!--slider-->
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <div id="slider-carousel" class="carousel slide" data-ride="carousel">
                        <ol class="carousel-indicators">
                            <li data-target="#slider-carousel" data-slide-to="0" class="active"></li>
                            <li data-target="#slider-carousel" data-slide-to="1"></li>
                            <li data-target="#slider-carousel" data-slide-to="2"></li>
                        </ol>
                        
                        <div class="carousel-inner">
                        @php
                            $i = 0;
                        @endphp
                        @foreach($slider as $key => $sli)
                            @php
                                $i++;
                            @endphp
                            <div class="item {{$i==1 ? 'active' : ''}}">
                                <div class="col-sm-12">
                                    <img src="public/upload/slider/{{$sli->slider_image}}" class="girl img-responsive" alt="" />
                                </div>
                            </div>
                        @endforeach
                        </div>
                        
                        <a href="#slider-carousel" class="left control-carousel hidden-xs" data-slide="prev">
                            <i class="fa fa-angle-left"></i>
                        </a>
                        <a href="#slider-carousel" class="right control-carousel hidden-xs" data-slide="next">
                            <i class="fa fa-angle-right"></i>
                        </a>
                    </div>
                    
                </div>
            </div>
        </div>
    </section><!--/slider-->
    
    <section>
        <div class="container">
            <div class="row">
                <div class="col-sm-3">
                    <div class="left-sidebar">
                        <h2>Product Category</h2>
                        <div class="panel-group category-products" id="accordian"><!--category-productsr-->
                        @foreach($category as $key => $cate)
                            
                            
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h4 class="panel-title"><a href="{{URL::to('/product-category'.$cate->category_id)}}">{{$cate->category_name}}</a></h4>
                                </div>
                            </div>
                        @endforeach    
                        </div><!--/category-products-->
                    
                        <div class="brands_products">
                            <h2>Product Manufacturer</h2>
                            <div class="brands-name">
                                <ul class="nav nav-pills nav-stacked">
                                    @foreach($manufacturer as $key => $manu)
                                        <li><h4 style="margin-top: 15px"><a href="{{URL::to('/product-manufacturer'.$manu->manufacturer_id)}}"> <span class="pull-right"></span>{{$manu->manufacturer_name}}</a></h4></li>
                                    @endforeach   
                                </ul>
                            </div>
                        </div><!--/brands_products-->        
                    </div>
                </div>
                
                <div class="col-sm-9 padding-right">
                    @yield('content')
                    
                </div>
            </div>
        </div>
    </section>
    
    <footer id="footer"><!--Footer-->
        <div class="footer-top">
            <div class="container">
                <div class="row">
                    <div class="col-sm-2">
                        <div class="companyinfo">
                            <h2><span>Board Game World</span></h2>
                            <p>Trust us, and we will bring the best service for you</p>
                        </div>
                    </div>
                    <div class="col-sm-10">
                        <div class="col-sm-3">
                            <div class="video-gallery text-center">
                                <a href="#">
                                    <div class="iframe-img">
                                        <img src="{{('public/frontend/images/logo1.jpg')}}" alt="" />
                                    </div>
                                    <div class="overlay-icon">
                                        <i class="fa fa-play-circle-o"></i>
                                    </div>
                                </a>
                                <p>Dice</p>
                            </div>
                        </div>
                        
                        <div class="col-sm-3">
                            <div class="video-gallery text-center">
                                <a href="#">
                                    <div class="iframe-img">
                                        <img src="{{('public/frontend/images/logo2.png')}}" alt="" />
                                    </div>
                                    <div class="overlay-icon">
                                        <i class="fa fa-play-circle-o"></i>
                                    </div>
                                </a>
                                <p>Cards</p>
                            </div>
                        </div>
                        
                        <div class="col-sm-3">
                            <div class="video-gallery text-center">
                                <a href="#">
                                    <div class="iframe-img">
                                        <img src="{{('public/frontend/images/logo3.jpg')}}" alt="" />
                                    </div>
                                    <div class="overlay-icon">
                                        <i class="fa fa-play-circle-o"></i>
                                    </div>
                                </a>
                                <p>Money</p>
                            </div>
                        </div>
                        
                        <div class="col-sm-3">
                            <div class="video-gallery text-center">
                                <a href="#">
                                    <div class="iframe-img">
                                        <img src="{{('public/frontend/images/logo4.jpg')}}" alt="" />
                                    </div>
                                    <div class="overlay-icon">
                                        <i class="fa fa-play-circle-o"></i>
                                    </div>
                                </a>
                                <p>Token</p>
                            </div>
                        </div>
                    </div>
                   
                </div>
            </div>
        </div>
        
        <div class="footer-widget">
            <div class="container">
                <div class="row">
                    <div class="col-sm-2">
                        <div class="single-widget">
                            <h2>Service</h2>
                            <ul class="nav nav-pills nav-stacked">
                                <li><a href="#">Online Help</a></li>
                                <li><a href="#">Contact Us</a></li>
                                <li><a href="#">Order Status</a></li>
                                <li><a href="#">Change Location</a></li>
                                <li><a href="#">FAQ’s</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <div class="single-widget">
                            <h2>Quick Shop</h2>
                            <ul class="nav nav-pills nav-stacked">
                                <li><a href="#">Humor</a></li>
                                <li><a href="#">Adventure</a></li>
                                <li><a href="#">Horror</a></li>
                                <li><a href="#">Detective</a></li>
                                <li><a href="#">Cooperation</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <div class="single-widget">
                            <h2>Policies</h2>
                            <ul class="nav nav-pills nav-stacked">
                                <li><a href="#">Terms of Use</a></li>
                                <li><a href="#">Privecy Policy</a></li>
                                <li><a href="#">Refund Policy</a></li>
                                <li><a href="#">Billing System</a></li>
                                <li><a href="#">Ticket System</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <div class="single-widget">
                            <h2>About Us</h2>
                            <ul class="nav nav-pills nav-stacked">
                                <li><a href="#">Company Information</a></li>
                                <li><a href="#">Careers</a></li>
                                <li><a href="#">Store Location</a></li>
                                <li><a href="#">Affillate Program</a></li>
                                <li><a href="#">Copyright</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div>
                            <img src="{{('public/frontend/images/welcome.png')}}" alt="" height="200px" width="380px"/>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
        
        <div class="footer-bottom">
            <div class="container">
                <div class="row">
                    <p class="pull-right">Designed by <span><a target="_blank">Lê Luân</a></span></p>
                </div>
            </div>
        </div>
    </footer><!--/Footer-->
    

  
    <script src="{{asset('public/frontend/js/jquery.js')}}"></script>
    <script src="{{asset('public/frontend/js/bootstrap.min.js')}}"></script>
    <script src="{{asset('public/frontend/js/jquery.scrollUp.min.js')}}"></script>
    <script src="{{asset('public/frontend/js/price-range.js')}}"></script>
    <script src="{{asset('public/frontend/js/jquery.prettyPhoto.js')}}"></script>
    <script src="{{asset('public/frontend/js/main.js')}}"></script>
    <script src="{{asset('public/frontend/js/js.js')}}"></script>
    <script src="{{asset('public/frontend/js/sweetalert.min.js')}}"></script>
    <script src="{{asset('public/backend/js/jquery.form-validator.min.js')}}"></script>
    <div class="zalo-chat-widget" data-oaid="844117219773198443" data-welcome-message="What can I help you?" data-autopopup="1000" data-width="" data-height=""></div>
    <script src="https://sp.zalo.me/plugins/sdk.js"></script>
    <script src="https://www.paypalobjects.com/api/checkout.js"></script>

    <script type="text/javascript">

     function view(){
        

         if(localStorage.getItem('data')!=null){

             var data = JSON.parse(localStorage.getItem('data'));

             data.reverse();

             document.getElementById('row_wishlist').style.overflow = 'scroll';
             document.getElementById('row_wishlist').style.height = '600px';
            
             for(i=0;i<data.length;i++){

                var name = data[i].name;
                var price = data[i].price;
                var image = data[i].image;
                var url = data[i].url;

                $('#row_wishlist').append('<div class="row" style="margin:10px 0"><div class="col-md-4"><img width="100%" height="200px" src="'+image+'"></div><div class="col-md-4 info_wishlist"><p>'+name+'</p><p style="color:#FE980F">'+price+' USD</p><a href="'+url+'">Order</a></div><div class="col-md-4" style="font-size: 5rem;"><i class="fa fa-heart fa-lg" id="big-heart"></i></div></div>');
            }

        }

    }

    view();
   

   function add_wishlist(clicked_id){
       
        var id = clicked_id;
        var name = document.getElementById('wishlist_productname'+id).value;
        var price = document.getElementById('wishlist_productprice'+id).value;
        var image = document.getElementById('wishlist_productimage'+id).src;
        var url = document.getElementById('wishlist_producturl'+id).href;

        var newItem = {
            'url':url,
            'id' :id,
            'name': name,
            'price': price,
            'image': image
        }

        if(localStorage.getItem('data')==null){
           localStorage.setItem('data', '[]');
        }

        var old_data = JSON.parse(localStorage.getItem('data'));

        var matches = $.grep(old_data, function(obj){
            return obj.id == id;
        })

        if(matches.length){
            alert('It is already on the list');

        }else{

            old_data.push(newItem);

           $('#row_wishlist').append('<div class="row" style="margin:10px 0"><div class="col-md-4"><img width="100%" height="200px" src="'+newItem.image+'"></div><div class="col-md-4 info_wishlist"><p>'+newItem.name+'</p><p style="color:#FE980F">'+newItem.price+' USD</p><a href="'+newItem.url+'">Order</a></div><div class="col-md-4" style="font-size: 5rem;"><i class="fa fa-heart fa-lg" id="big-heart"></i></div></div>');

        }
       
        localStorage.setItem('data', JSON.stringify(old_data));

       
   }
</script>
    <script type="text/javascript">
            window.onscroll = function() {
                sticky_navbar()
            };
            
            var navbar = document.getElementById("navbar");

            
            var sticky = navbar.offsetTop;

            
            function sticky_navbar() {
              if (window.pageYOffset >= sticky) {
                navbar.classList.add("sticky")
              } else {
                navbar.classList.remove("sticky");
              }
            }

    </script>
    <script>
        var money = document.getElementById("total_after").value;
      paypal.Button.render({
        // Configure environment
        env: 'sandbox',
        client: {
          sandbox: 'ATSUmeJSc_x67wt0qiZBuwh-duo14of-vGaT2eoVNW-wdaE_cWhIww0SF1oh4P27XVGLgMisjV4WnGUs',
          production: 'demo_production_client_id'
        },
        // Customize button (optional)
        locale: 'en_US',
        style: {
          size: 'small',
          color: 'gold',
          shape: 'pill',
        },

        // Enable Pay Now checkout flow (optional)
        commit: true,

        // Set up a payment
        payment: function(data, actions) {
          return actions.payment.create({
            transactions: [{
              amount: {
                total: `${money}`,
                currency: 'USD'
              }
            }]
          });
        },
        // Execute the payment
        onAuthorize: function(data, actions) {
          return actions.payment.execute().then(function() {
            // Show a confirmation message to the buyer
            var shipping_email = $('.shipping_email').val();
            var shipping_name = $('.shipping_name').val();
            var shipping_address = $('.shipping_address').val();
            var shipping_phone = $('.shipping_phone').val();
            var shipping_note = $('.shipping_note').val();
            var shipping_method = 0;
            var order_fee = $('.order_fee').val();
            var order_coupon = $('.order_coupon').val();
            var _token = $('input[name="_token"]').val();
            $.ajax({
                url: '{{url('/confirm-order')}}',
                method: 'POST',
                data:{shipping_email:shipping_email,shipping_name:shipping_name,shipping_address:shipping_address,shipping_phone:shipping_phone,shipping_note:shipping_note,_token:_token,order_fee:order_fee,order_coupon:order_coupon,shipping_method:shipping_method},
                success:function(){
                    swal("Paypal", "Make payment successfully", "success");
                }
            });

            window.setTimeout(function(){ 
                window.location.href = "{{url('/checkout'.$customer_id)}}";
            } ,2500);

          });
        }
      }, '#paypal-button');

</script>

    <script type="text/javascript">
        $(document).ready(function(){
            $('#sort').on('change',function(){
                var url = $(this).val();
                if(url){
                    window.location = url;
                }
                return false;
            });
        });
    </script>
    <script type="text/javascript">
        $(document).ready(function(){
            load_comment();
            function load_comment(){
                var product_id = $('.comment_product_id').val();
                var _token = $('input[name="_token"]').val();
                $.ajax({
                    url: '{{url('/load-comment')}}',
                    method: 'POST',
                    data:{product_id:product_id,_token:_token},
                    success:function(data){
                        $('#comment_show').html(data);
                    }
                });
            }
            $('.send-comment').click(function(){
                var product_id = $('.comment_product_id').val();
                var commenter = $('.commenter').val();
                var comment_content = $('.comment_content').val();
                var _token = $('input[name="_token"]').val();
                $.ajax({
                    url: '{{url('/send-comment')}}',
                    method: 'POST',
                    data:{product_id:product_id,commenter:commenter,comment_content:comment_content,_token:_token},
                    success:function(data){
                        $('#notify_comment').html('<span class="text text-success">Comment successfully</span>');
                        load_comment();
                        $('#notify_comment').fadeOut(3000);
                        $('.commenter').val('');
                        $('.comment_content').val('');
                    }
                });
            });
        });
    </script>
     <script type="text/javascript">
           const currentLocation = location.href;
           const menuItem = document.querySelectorAll('a');
           const menuLength = menuItem.length
           for (let i = 0; i<menuLength; i++){
               if(menuItem[i].href === currentLocation){
                  menuItem[i].className = "active"
               }
           }
     </script>
    <script>
        $.validate({

        });
    </script>
     <script type="text/javascript">

          $(document).ready(function(){
            $('.send_order').click(function(){
                swal({
                  title: "Confirm Order",
                  text: "Are you sure you want to order?",
                  type: "warning",
                  showCancelButton: true,
                  confirmButtonClass: "btn-danger",
                  confirmButtonText: "Thank you for your order",

                    cancelButtonText: "Close, not yet",
                    closeOnConfirm: false,
                    closeOnCancel: false
                },
                function(isConfirm){
                     if (isConfirm) {
                        var shipping_email = $('.shipping_email').val();
                        var shipping_name = $('.shipping_name').val();
                        var shipping_address = $('.shipping_address').val();
                        var shipping_phone = $('.shipping_phone').val();
                        var shipping_note = $('.shipping_note').val();
                        var shipping_method = 1;
                        var order_fee = $('.order_fee').val();
                        var order_coupon = $('.order_coupon').val();
                        var _token = $('input[name="_token"]').val();

                        $.ajax({
                            url: '{{url('/confirm-order')}}',
                            method: 'POST',
                            data:{shipping_email:shipping_email,shipping_name:shipping_name,shipping_address:shipping_address,shipping_phone:shipping_phone,shipping_note:shipping_note,_token:_token,order_fee:order_fee,order_coupon:order_coupon,shipping_method:shipping_method},
                            success:function(){
                               swal("Order", "You order successfully", "success");
                            }
                        });

                        window.setTimeout(function(){ 
                            window.location.href = "{{url('/checkout'.$customer_id)}}";
                        } ,2500);

                      } else {
                        swal("Close", "Please recheck your order before order", "error");

                      }
              
                });

               
            });
        });
    </script>
    <script type="text/javascript">
        $(document).ready(function(){
            show_cart();
            function show_cart(){
                $.ajax({
                    url:'{{url('/show-cart')}}',
                    method:"GET",
                    success:function(data){
                        $('#show-cart').html(data);
                    }
                });
            }
            $('.add-to-cart').click(function(){
                var id=$(this).data('id_product');
                var cart_product_id = $('.cart_product_id_' + id).val();
                var cart_product_name = $('.cart_product_name_' + id).val();
                var cart_product_image = $('.cart_product_image_' + id).val();
                var cart_product_quantity = $('.cart_product_quantity_' + id).val();
                var cart_product_price = $('.cart_product_price_' + id).val();
                var cart_product_qty = $('.cart_product_qty_' + id).val();
                var _token = $('input[name="_token"]').val();

                if(parseInt(cart_product_qty)>parseInt(cart_product_quantity)){
                    alert('We are going to out of product, please order fewer than ' + cart_product_quantity);
                }
                else{
                    $.ajax({
                    url: '{{url('/add-cart-ajax')}}',
                    method: 'POST',
                    data:{cart_product_id:cart_product_id,cart_product_name:cart_product_name,cart_product_image:cart_product_image,cart_product_price:cart_product_price,cart_product_qty:cart_product_qty,_token:_token,cart_product_quantity:cart_product_quantity},
                    success:function(){
                        swal({
                            title: "The product is added to cart",
                            text: "You can keep browsing or go to cart and make payment",
                            showCancelButton: true,
                            cancelButtonText: "Keep browsing",
                            confirmButtonClass: "btn-success",
                            confirmButtonText: "Go to cart",
                            closeOnConfirm: false
                            },
                            function(){
                                window.location.href = "{{url('/show-cart-ajax')}}";
                            });
                        show_cart();  
                    }
                });
                }
                
            });
        });
    </script>
    <script type="text/javascript">
    $(document).ready(function(){
        $('.choose').on('change',function(){
            var action = $(this).attr('id');
            var ma_id = $(this).val();
            var _token = $('input[name="_token"]').val();
            var $result = '';
            if(action=='city'){
                result = 'district';
            }
            else{
                result = 'ward';
            }
            $.ajax({
                url : '{{url('select-delivery-home')}}',
                method: 'POST',
                data:{action:action,ma_id:ma_id,_token:_token},
                success:function(data){
                    $('#'+result).html(data);
                }
            });
        });
    });

    </script>
    <script type="text/javascript">
        $(document).ready(function(){
            $('.calculate_delivery').click(function(){
                var matp = $('.city').val();
                var maqh = $('.district').val();
                var xaid = $('.ward').val();
                var _token = $('input[name="_token"]').val();
                if(matp == '' && maqh =='' && xaid ==''){
                    alert('Please choose your area for shipping');
                }
                else{
                    $.ajax({
                    url : '{{url('/calculate-fee')}}',
                    method: 'POST',
                    data:{matp:matp,maqh:maqh,xaid:xaid,_token:_token},
                    success:function(){
                       location.reload(); 
                    }
                    });
                } 
        });
    });
    </script>
</body>
</html>