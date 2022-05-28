@extends('admin_layout')
@section('admin_content')
<div class="table-agile-info">
  <div class="panel panel-default">
    <div class="panel-heading">
      Coupon List    
    </div>
    <div class="row w3-res-tb">
      <div class="col-sm-12">
        <form action="{{URL::to('/search-coupon')}}" method="POST">
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
            <th></th>
            <th>Coupon name</th>
            <th>Coupon code</th>
             <th>Coupon characteristic</th> 
            <th>Discount amount</th>   
          </tr>
        </thead>
        <tbody>
        <?php
            $stt = 0;
            foreach($coupon as $key => $cou):
            $stt++;
        ?>
          <tr>
            <td>{{$stt}}</td>
            <td>{{$cou->coupon_name}}</td>
            <td>{{$cou->coupon_code}}</td>
            <td><span class="text-ellipsis">
                <?php
                if($cou->coupon_condition==1){
                ?>
                    By %
                <?php
                }
                else{
                ?>
                    By number
                <?php
                }
                ?>
            </span>
            </td>
            <td><span class="text-ellipsis">
                <?php
                if($cou->coupon_condition==1){
                ?>
                    discount {{$cou->coupon_discount}} %
                <?php
                }
                else{
                ?>
                    discount {{$cou->coupon_discount}} USD
                <?php
                }
                ?>
            </span>
            </td>
            
            <td>
              <a onclick="return confirm('Are you sure to delete?')" href="{{URL::to('/delete-coupon/'.$cou->coupon_id)}}" class="active styling-edit" ui-toggle-class=""><i class="fa fa-times text-danger text"></i></a>
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
            {!!$coupon->links()!!}
          </ul>
        </div>
      </div>
    </footer>
  </div>
</div>
@endsection