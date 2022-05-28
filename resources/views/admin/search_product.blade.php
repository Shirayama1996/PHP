@extends('admin_layout')
@section('admin_content')
<div class="table-agile-info">
  <div class="panel panel-default">
    <div class="panel-heading">
      Product List    
    </div>
    <div class="row w3-res-tb">
      <div class="col-sm-12">
        <form action="{{URL::to('/search-product')}}" method="POST">
          @csrf
        <div class="input-group pull-right">
            <input type="text" name="keywords_submit" class="form-control" style="width: 250px">
            <input type="submit" name="search_items" class="btn btn-primary" value="Search">
        </div>
      </form>
      </div>
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
            <th>
              
            </th>
            <th>Name</th>
            <th>Quantity</th>
            <th>Price</th>
            <th>Image</th>  
            <th>Category</th>
            <th>Manufacturer</th>  
             
            <th>Display</th>  
            <th style="width:30px;"></th>
          </tr>
        </thead>
        <tbody>
        <?php
            $stt = 0;
            foreach($search_product as $key => $pro):
            $stt++;
        ?>
          <tr>
            <td>{{$stt}}</td>
            <td>{{$pro->product_name}}</td>
            <td>{{$pro->product_quantity}}</td>
            <td>{{$pro->product_price}}</td>
            <td><img src="public/upload/product/{{$pro->product_image}}" height="100" width="100"></td>
            <td>{{$pro->category_name}}</td>
            <td>{{$pro->manufacturer_name}}</td>

            <td>
                <?php
                if($pro->product_status==0){
                ?>
                    <a href="{{URL::to('/unactive-product/'.$pro->product_id)}}"><span class="fa-thumb-styling fa fa-thumbs-up"></span></a>
                    <?php
                }
                else{
                ?>
                    <a href="{{URL::to('/active-product/'.$pro->product_id)}}"><span class="fa-thumb-styling fa fa-thumbs-down"></span></a>
                    <?php
                }
                ?>
            </td>
            
            <td>
              <a href="{{URL::to('/edit-product'.$pro->product_id)}}" class="active styling-edit" ui-toggle-class=""><i class="fa fa-pencil-square-o text-success text-active"></i></a>
              <a onclick="return confirm('Are you sure to delete?')" href="{{URL::to('/delete-product/'.$pro->product_id)}}" class="active styling-edit" ui-toggle-class=""><i class="fa fa-times text-danger text"></i></a>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
</div>
@endsection