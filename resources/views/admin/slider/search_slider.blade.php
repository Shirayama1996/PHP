@extends('admin_layout')
@section('admin_content')
<div class="table-agile-info">
  <div class="panel panel-default">
    <div class="panel-heading">
      Slider List    
    </div>
    <div class="row w3-res-tb">
      <div class="col-sm-12">
        <form action="{{URL::to('/search-slider')}}" method="POST">
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
            <th style="width:20px;">
              
            </th>
            <th>Slider name</th>
            <th>Image</th>
            <th>Description</th>
            <th>Status</th>  
            <th style="width:30px;"></th>
          </tr>
        </thead>
        <tbody>
        <?php
            $stt = 0;
            foreach($search_slider as $key => $slider):
            $stt++;
        ?>
          <tr>
            <td>{{$stt}}</td>
            <td>{{$slider->slider_name}}</td>
            <td><img src="public/upload/slider/{{$slider->slider_image}}" height="120" width="400"></td>
            <td>{{$slider->slider_desc}}</td>
            <td><span class="text-ellipsis">
                <?php
                if($slider->slider_status==1){
                ?>
                    <a href="{{URL::to('/unactive-slider/'.$slider->slider_id)}}"><span class="fa-thumb-styling fa fa-thumbs-up"></span></a>
                    <?php
                }
                else{
                ?>
                    <a href="{{URL::to('/active-slider/'.$slider->slider_id)}}"><span class="fa-thumb-styling fa fa-thumbs-down"></span></a>
                    <?php
                }
                ?>
            </span></td>
            
            <td>
              
              <a onclick="return confirm('Are you sure to delete?')" href="{{URL::to('/delete-slider/'.$slider->slider_id)}}" class="active styling-edit" ui-toggle-class=""><i class="fa fa-times text-danger text"></i></a>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
</div>
@endsection