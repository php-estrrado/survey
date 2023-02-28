@extends('layouts.admin.master-admin')
@section('page-header')
	<!--Page header-->
	<div class="page-header">
		<div class="page-leftheader">
			<h4 class="page-title mb-0">Hi! Welcome Back</h4>
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="{{url('/' . $page='#')}}"><i class="fe fe-home mr-2 fs-14"></i>Home</a></li>
				<li class="breadcrumb-item active" aria-current="page"><a href="{{url('/admin/dashboard')}}">Dashboard</a></li>
			</ol>
		</div>
	</div>
	<!--End Page header-->
@endsection
@section('content')
	<!-- Row-1 -->
	<div class="row">
		<div class="col-md-12 col-xl-3 col-lg-6">
			<div class="card text-center">
				<div class="card-body"> <span>No. Of Total Cancelled Service</span>
					<h1 class=" mb-1 mt-1 font-weight-bold">0</h1>
				</div>
			</div>
		</div>
	</div>
	<!-- End Row-1 -->

	<!-- Row-2 -->
	<div class="row">
		<div class="col-xl-6 col-lg-6 col-md-12">
			<div class="card">
				<div class="card-header">
					<div class="card-title">No. Of Service Request For Each Category</div>
				</div>
				<div class="card-body">
					<div class="h-300" id="flotBar2"></div>
				</div>
			</div>
		</div>

		<div class="col-xl-6 col-md-12">
			<div class="card">
				<div class="card-header">
					<div class="card-title">Total Request Received v/s Total Accepted Requests</div>
				</div>
				<div class="card-body">
					<div class="chartjs-wrapper-demo">
						<div id="chart8" class="h-300 mh-300"></div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- End Row-2 -->

</div>
</div>
<!-- End app-content-->
</div>
@endsection
@section('js')

<!--INTERNAL Peitychart js-->
<script src="{{URL::asset('assets/plugins/peitychart/jquery.peity.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/peitychart/peitychart.init.js')}}"></script>

<!--INTERNAL Apexchart js-->
<script src="{{URL::asset('assets/js/apexcharts.js')}}"></script>

<!--INTERNAL ECharts js-->
<script src="{{URL::asset('assets/plugins/echarts/echarts.js')}}"></script>

<!--INTERNAL Chart js -->
<script src="{{URL::asset('assets/plugins/chart/chart.bundle.js')}}"></script>
<script src="{{URL::asset('assets/plugins/chart/utils.js')}}"></script>

<!-- INTERNAL Select2 js -->
<script src="{{URL::asset('assets/plugins/select2/select2.full.min.js')}}"></script>
<script src="{{URL::asset('assets/js/select2.js')}}"></script>

<!--INTERNAL Moment js-->
<script src="{{URL::asset('assets/plugins/moment/moment.js')}}"></script>

<!--INTERNAL Chart js -->
<script src="{{URL::asset('assets/js/apexcharts.js')}}"></script>
<script src="{{URL::asset('assets/js/apexchart-custom.js')}}"></script>

<!--INTERNAL Flot Charts js-->
<script src="{{URL::asset('assets/plugins/flot/jquery.flot.js')}}"></script>
<script src="{{URL::asset('assets/plugins/flot/jquery.flot.fillbetween.js')}}"></script>
<script src="{{URL::asset('assets/plugins/flot/jquery.flot.pie.js')}}"></script>
<script src="{{URL::asset('assets/js/flot.js')}}"></script>

<!--INTERNAL Index js-->
<script src="{{URL::asset('assets/js/index1.js')}}"></script>

@endsection