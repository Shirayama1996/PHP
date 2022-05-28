@extends('admin_layout')
@section('admin_content')
<div class="table-agile-info">
  <div class="panel panel-default">
    <div class="panel-heading">
      Order List    
    </div>
    <div class="row w3-res-tb">
    <div class="col-sm-12">
      <form action="{{URL::to('/search-order')}}" method="POST">
          @csrf
        <div class="input-group pull-right">
            <input type="text" name="keywords_submit" class="form-control" style="width: 250px">
            <input type="submit" name="search_items" class="btn btn-primary" value="Search">
        </div>
      </form>
      </div>
    </div>
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
            
            <th></th>
            <th>Order code</th>
            <th>Order date</th>
            <th>Estimated delivery</th>
            <th>Order status</th>  
            <th style="width:30px;"></th>
          </tr>
        </thead>
        <tbody>
        @php
        $i = 0;
        @endphp
        @foreach($search_order as $key => $ord)
          @php
          $i++
          @endphp
          <tr>
            <td><i>{{$i}}</i></label></td>
            <td>{{$ord->order_code}}</td>
            <td>{{$ord->created_at}}</td>
            <td>{{$ord->delivery_date}}</td>
            <td>@if($ord->order_status==1)
                    <span class="text text-primary">New order</span>
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
              <a href="{{URL::to('/view-order'.$ord->order_code)}}" class="active styling-edit" ui-toggle-class=""><i class="fa fa-eye text-success text-active"></i></a>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
</div>
@endsection