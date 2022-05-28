@extends('admin_layout')
@section('admin_content')
<div class="container-fluid">
			<style type="text/css">
				p.title_thongke {
				    text-align: center;
				    font-size: 20px;
				    font-weight: bold;
				}
			</style>
<div class="row">
		<p class="title_thongke">Statistic Of Order Revenue</p>

		<form autocomplete="off">
			@csrf

			<div class="col-md-2">
				<p>From: <input type="text" id="datepicker" class="form-control"></p>

				<input type="button" id="btn-dashboard-filter" class="btn btn-primary btn-sm" value="Sort"></p>

			</div>

			<div class="col-md-2">
				<p>To: <input type="text" id="datepicker2" class="form-control"></p>
			
			</div>

			<div class="col-md-2">
				<p>
					Sort by: 
					<select class="dashboard-filter form-control" >
						<option>--Choose--</option>
						<option value="7ngay">From 7 days ago</option>
						<option value="thangtruoc">Last month</option>
						<option value="thangnay">This month</option>
						<option value="365ngayqua">From last year</option>
					</select>
				</p>
			</div>

		</form>

		<div class="col-md-12">
			<div id="chart" class="morris-bar-chart" style="height: 250px;"></div>
			<style type="text/css">
					.morris-bar-chart text {
					  fill: black;
					}
			</style>
		</div>

</div>
<div class="row">

	<div class="col-md-12 col-xs-12">
		<p class="title_thongke">Statistic Of COP</p>
		<div id="donut"></div>	
	</div>	
</div>


</div>

@endsection
