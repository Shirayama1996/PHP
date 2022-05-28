@extends('admin_layout')
@section('admin_content')
<div class="table-agile-info">
  <div class="panel panel-default">
    <div class="panel-heading">
      Customer Information    
    </div>
  
    <div class="table-responsive">
    <?php
    $message = Session::get('message');
    if($message){
        echo '<span class="text-success">'.$message.'</span>';
        Session::put('message',null);
    }
    ?>
      <table class="table table-striped b-t b-light">
        <thead>
          <tr>
            
            <th>Customer name</th>
            <th>Phone</th>  
            <th>Email</th> 
          </tr>
        </thead>
        <tbody>
       
          <tr>
            <td>{{$customer->customer_name}}</td>
            <td>{{$customer->customer_phone}}</td>
            <td>{{$customer->customer_email}}</td>    
            
          </tr>
      
        </tbody>
      </table>
    </div>
    
  </div>
</div>
<br>
<div class="table-agile-info">
  <div class="panel panel-default">
    <div class="panel-heading">
      Shipping Information    
    </div>
  
    <div class="table-responsive">
    <?php
    $message = Session::get('message');
    if($message){
        echo '<span class="text-alert">'.$message.'</span>';
        Session::put('message',null);
    }
    ?>
      <table class="table table-striped b-t b-light">
        <thead>
          <tr>
            
            <th>Receiver name</th>
            <th>Address</th> 
            <th>Phone</th> 
            <th>Email</th>
            <th>Note</th> 
            <th>Payment method</th>   
        
          </tr>
        </thead>
        <tbody>
       
          <tr>
            
            <td>{{$shipping->shipping_name}}</td>
            <td>{{$shipping->shipping_address}}</td>
            <td>{{$shipping->shipping_phone}}</td>
            <td>{{$shipping->shipping_email}}</td>
            <td>{{$shipping->shipping_note}}</td>
            <td>@if($shipping->shipping_method==0) PayPal @else Cash on delivery @endif</td>
            
          </tr>
      
        </tbody>
      </table>
    </div>
    
  </div>
</div>
<br><br>
<div class="table-agile-info">
  <div class="panel panel-default">
    <div class="panel-heading">
      Order Detail    
    </div>
    
    <div class="table-responsive">
    <?php
    $message = Session::get('message');
    if($message){
        echo '<span class="text-alert">'.$message.'</span>';
        Session::put('message',null);
    }
    ?>
      <table class="table table-striped b-t b-light">
        <thead>
          <tr>
            <th>Product name</th>
            <th>Coupon code</th>
            <th>Quantity</th>  
            <th>Product price</th> 
            <th>Total price</th> 
          </tr>
        </thead>
        <tbody>
        @php
        $total = 0;
        @endphp
        @foreach($order_details as $key => $details)
        @php
        $subtotal = $details->product_price*$details->product_sale_quantity;
        $total += $subtotal;
        @endphp
          <tr class="color_qty_{{$details->product_id}}">
            <td>{{$details->product_name}}</td>
            <input type="hidden" value="{{$details->product->product_quantity}}">
            <td>@if($details->product_coupon!='no')
                    {{$details->product_coupon}}
                @else
                    No coupon
                @endif
            </td>
            <td>
              {{$details->product_sale_quantity}}
              <input type="hidden" class="order_qty_{{$details->product_id}}" value="{{$details->product_sale_quantity}}" name="product_sale_quantity">
              <input type="hidden" name="order_qty_storage" class="order_qty_storage_{{$details->product_id}}" value="{{$details->product->product_quantity}}">
              <input type="hidden" name="order_code" class="order_code" value="{{$details->order_code}}">
              <input type="hidden" name="order_product_id" class="order_product_id" value="{{$details->product_id}}">
            </td>
            <td>{{number_format($details->product_price,0,',','.')}} USD</td>
            <td>{{number_format($subtotal,0,',','.')}} USD</td>
          </tr>
        @endforeach
          <tr>
            <td colspan="6">  
            @php 
                $total_coupon = 0;
              @endphp
              @if($coupon_condition==1)
                  @php
                  $total_after_coupon = ($total*$coupon_discount)/100;
                  echo 'Discount :'.number_format($total_after_coupon,0,',','.').' USD'.'</br>';
                  $total_coupon = $total + $details->product_shipfee - $total_after_coupon ;
                  @endphp
              @else 
                  @php
                  echo 'Discount :'.number_format($coupon_discount,0,',','.').' USD'.'</br>';
                  $total_coupon = $total + $details->product_shipfee - $coupon_discount ;

                  @endphp
              @endif

              Shipping fee : {{number_format($details->product_shipfee,0,',','.')}} USD</br> 
              Payment: {{number_format($total_coupon,0,',','.')}} USD 
            </td>
          </tr>
          <tr>
            <td colspan="6">
             @foreach($order as $key => $or)
                @if($or->order_status==1)
                <form>
                   @csrf
                  <select class="form-control order_details">
                    <option value="">----Choose order status-----</option>
                    <option id="{{$or->order_id}}" selected value="1">Waiting for processing</option>
                    <option id="{{$or->order_id}}" value="2">Packed</option>
                  </select>
                </form>
                @elseif($or->order_status==2)
                <form>
                  @csrf
                  <select class="form-control order_details">
                    <option value="">----Choose order status-----</option>
                    <option disabled id="{{$or->order_id}}" value="1">Waiting for processing</option>
                    <option id="{{$or->order_id}}" selected value="2">Packed</option>
                    <option id="{{$or->order_id}}" value="3">Delivering</option>
                    <option id="{{$or->order_id}}" value="4">Delivered</option>
                  </select>
                </form>
                 @elseif($or->order_status==3)
                <form>
                  @csrf
                  <select class="form-control order_details">
                    <option value="">----Choose order status-----</option>
                    <option disabled id="{{$or->order_id}}" value="1">Waiting for processing</option>
                    <option disabled id="{{$or->order_id}}" value="2">Packed</option>
                    <option id="{{$or->order_id}}" selected value="3">Delivering</option>
                    <option id="{{$or->order_id}}" value="4">Delivered</option>
                  </select>
                </form>
                @elseif($or->order_status==4)
                <form>
                  @csrf
                  <select class="form-control order_details">
                    <option value="">----Choose order status-----</option>
                    <option disabled id="{{$or->order_id}}" value="1">Waiting for processing</option>
                    <option disabled id="{{$or->order_id}}" value="2">Packed</option>
                    <option disabled id="{{$or->order_id}}" value="3">Delivering</option>
                    <option id="{{$or->order_id}}" selected value="4">Delivered</option>
                  </select>
                </form>
                @endif
                @endforeach
               <a target="_blank" href="{{url('/print-order'.$details->order_code)}}" class="pull-right" style="margin-top: 10px">Print order</a>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</div>
@endsection