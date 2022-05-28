@extends('layout')
@section('content')
<h1 style="text-align: center;">Track Order</h1>
<div class="table-agile-info">
  <div class="panel panel-default">    
    <div class="table-responsive">
    <?php
    $message = Session::get('message');
    if($message){
        echo '<span class="text-success">'.$message.'</span>';
        Session::put('message',null);
    }
    ?>
      <table class="table">
        <thead style="background-color: orange;">
          <tr>
            <th></th>
            <th>Order code</th>
            <th>Order date</th>
            <th>Estimated delivery</th>
            <th>Order status</th>  
            <th style="width: 70px"></th>
            <th style="width: 30px"></th>
          </tr>
        </thead>
        <tbody>
        @php
        $i = 0;
        @endphp
        @foreach($order as $key => $ord)
          @php
          $i++
          @endphp
          <tr>
            <td><i>{{$i}}</i></label></td>
            <td>{{$ord->order_code}}</td>
            <td>{{$ord->created_at}}</td>
            <td>{{$ord->delivery_date}}</td>
            <td>@if($ord->order_status==1)
                    <span>Processing</span>
                @elseif($ord->order_status==2)
                    <span class="text text-success">Packed</span>
                @elseif($ord->order_status==3)
                    <span class="text text-success">Delivering</span>
                @elseif($ord->order_status==4)
                    <span class="text text-success">Delivered</span>
                @else
                    <span class="text text-danger">Cancelled</span>
                @endif
            </td>
            <td>
              <form action="{{URL::to('/view-history'.$ord->order_code)}}">
                <input type="submit" class="btn btn-primary" value="View Order">
              </form>
            </td>
            <td>
               @if($ord->order_status==1)
              <form action="{{URL::to('/cancel-order/'.$ord->order_code)}}" method="GET">
                <button type="submit" onclick="return confirm('Are you sure you want to cancel?')" class="btn btn-danger">Cancel Order</button>
              </form>
              @endif
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
    <footer class="panel-footer" style="background-color: orange;">
      <div class="row">
         <div class="col-sm-12 text-right text-center-xs">                
            <ul class="pagination pagination-sm m-t-none m-b-none">
            {!!$order->links()!!}
            </ul>
        </div>
      </div>
    </footer>
  </div>
</div>
@endsection