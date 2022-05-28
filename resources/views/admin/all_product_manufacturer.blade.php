@extends('admin_layout')
@section('admin_content')
<div class="table-agile-info">
  <div class="panel panel-default">
    <div class="panel-heading">
      Product Manufacturer List    
    </div>
    <div class="row w3-res-tb">
      <div class="col-sm-12">
        <form action="{{URL::to('/search-product-manufacturer')}}" method="POST">
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
            <th style="width:40px;">
             
            </th>
            <th>Manufacturer name</th>
            <th>Display</th>  
            <th style="width:30px;"></th>
          </tr>
        </thead>
        <tbody>
        <?php
            $stt = 0;
            foreach($all_product_manufacturer as $key => $pm):
            $stt++;
        ?>
          <tr>
            <td>{{$stt}}</td>
            <td>{{$pm->manufacturer_name}}</td>
            <td><span class="text-ellipsis">
                <?php
                if($pm->manufacturer_status==0){
                ?>
                    <a href="{{URL::to('/unactive-product-manufacturer/'.$pm->manufacturer_id)}}"><span class="fa-icon-styling icon-smile"></span></a>
                    <?php
                }
                else{
                ?>
                    <a href="{{URL::to('/active-product-manufacturer/'.$pm->manufacturer_id)}}"><span class="fa-icon-styling fa fa-frown-o"></span></a>
                    <?php
                }
                ?>
            </span></td>
            
            <td>
              <a href="{{URL::to('/edit-product-manufacturer'.$pm->manufacturer_id)}}" class="active styling-edit" ui-toggle-class=""><i class="fa fa-pencil-square-o text-success text-active"></i></a>
              <a onclick="return confirm('Are you sure to delete?')" href="{{URL::to('/delete-product-manufacturer/'.$pm->manufacturer_id)}}" class="active styling-edit" ui-toggle-class=""><i class="fa fa-times text-danger text"></i></a>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
    <footer class="panel-footer">
      <div class="row">
        <div class="col-sm-12 text-right text-center-xs">                
          <ul class="pagination pagination-sm m-t-none m-b-none">
            {!!$all_product_manufacturer->links()!!}
          </ul>
        </div>
      </div>
    </footer>
  </div>
</div>
@endsection