@extends('admin_layout')
@section('admin_content')
<?php
    $role = Session::get('user_role');
    $admin_id = Session::get('admin_id');
    if($role==1){
?>
<div class="table-agile-info">
  <div class="panel panel-default">
    <div class="panel-heading">
      User list
    </div>
    <div class="row w3-res-tb">
      <div class="col-sm-12">
      <form action="{{URL::to('/search-user')}}" method="POST">
          @csrf
        <div class="input-group pull-right">
            <input type="text" name="keywords_submit" class="form-control" placeholder="Search product" style="width: 250px">
            <input type="submit" name="search_items" class="btn btn-primary" value="Search"/>
        </div>
      </form>
      </div>
    </div>
    <div class="table-responsive">
      <table class="table table-striped b-t b-light">
        <thead>
          <tr>
            <th>
             
            </th>
          
            <th>User name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Date of birth</th>
            <th>Role</th>
            <th>Status</th>
         
            <th style="width:30px;"></th>
          </tr>
        </thead>
        <tbody>
          <?php
                $stt = 0;
                foreach($search_user as $key => $user):
                $stt++;
          ?>
              <tr>  
                <td>{{$stt}}</td>
                <td>{{ $user->admin_name }}</td>
                <td>{{ $user->admin_email }}</td>
                <td>{{ $user->admin_phone }}</td>
                <td>{{ $user->admin_birthday }}</td>
              <?php
                 if($user->user_role==1){
              ?>
                <td><b style="color:black">Admin<b></td>
              <?php
                 }
                elseif($user->user_role==2){
              ?>
                <td>Manager</td>
              <?php
                 }
              ?>
              <td>
                  <span class="text-ellipsis">
                  <?php
                  if($user->admin_id != $admin_id){
                  if($user->user_status==1){
                  ?>
                      <a href="{{URL::to('/unactive-user/'.$user->admin_id)}}"><span class="fa-icon-styling icon-smile"></span></a>
                      <?php
                  }
                  else{
                  ?>
                      <a href="{{URL::to('/active-user/'.$user->admin_id)}}"><span class="fa-icon-styling fa fa-frown-o"></span></a>
                      <?php
                  }
                  }
                  ?>
                  </span>
                </td>
              <td>
                <a href="{{URL::to('/edit-user'.$user->admin_id)}}" class="active styling-edit" ui-toggle-class=""><i class="fa fa-pencil-square-o text-success text-active"></i></a>
              </td>
              </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
</div>
<?php
     }
     else{
?>        
        <span class="text-alert">You don't have this authority</span>
<?php
     }
                 
?>
@endsection