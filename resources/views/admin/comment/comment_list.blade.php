@extends('admin_layout')
@section('admin_content')
<div class="table-agile-info">
  <div class="panel panel-default">
    <div class="panel-heading">
      Comment List    
    </div>
    <div class="row w3-res-tb">
      <div class="col-sm-12">
        <form action="{{URL::to('/search-comment')}}" method="POST">
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
            <th>Product name</th>
            <th>Commenter</th>
            <th>Comment content</th>  
            <th>Comment time</th>
            <th style="width:30px;"></th>
          </tr>
        </thead>
        <tbody>
        <?php
            $stt = 0;
            foreach($all_comment as $key => $comment):
            $stt++;
        ?>
          <tr>
            <td>{{$stt}}</td>
            <td>{{$comment->product_name}}</td>
            <td>{{$comment->commenter}}</td>
            <td>{{$comment->comment_content}}</td>
            <td>{{$comment->comment_date}}</td>
            <td> 
              <a onclick="return confirm('Are you sure to delete?')" href="{{URL::to('/delete-comment/'.$comment->comment_id)}}" class="active styling-edit" ui-toggle-class=""><i class="fa fa-times text-danger text"></i></a>
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
            {!!$all_comment->links()!!}
          </ul>
        </div>
      </div>
    </footer>
  </div>
</div>
@endsection