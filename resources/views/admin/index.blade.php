@extends('layouts.admin.master-admin')
@section('page-header')
	<!--Page header-->
	<div class="page-header">
		<div class="page-leftheader">
			<h4 class="page-title mb-0">Dashboard</h4>
			<!-- <ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="{{url('/' . $page='#')}}"><i class="fe fe-home mr-2 fs-14"></i>Home</a></li>
				<li class="breadcrumb-item active" aria-current="page"><a href="{{url('/admin/dashboard')}}">Dashboard</a></li>
			</ol> -->
		</div>
	</div>
	<!--End Page header-->
@endsection
@section('content')
	@php
		if(auth()->user()->role_id == 2)
		{
	@endphp
			<!-- Row-1 -->
				<div class="row">
					<div class="col-md-12 col-xl-3 col-lg-6">
						<div class="card text-center">
							<div class="card-body"> <span>No. Of Total Cancelled Service</span>
								<h1 class=" mb-1 mt-1 font-weight-bold">{{$rejected_surveys}}</h1>
							</div>
						</div>
					</div>
				</div>
			<!-- End Row-1 -->
	@php
		}
		else if(auth()->user()->role_id == 7)
		{
	@endphp
			<!-- Row-1 -->
				<div class="row">
					<div class="col-md-12 col-xl-3 col-lg-6">
						<div class="card text-center">
							<div class="card-body"> <span>No. Of Total Completed Service</span>
								<h1 class=" mb-1 mt-1 font-weight-bold">{{$surveys_completed}}</h1>
							</div>
						</div>
					</div>
				</div>
			<!-- End Row-1 -->
	@php
		}
		if(auth()->user()->role_id == 2)
		{
	@endphp
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
	@php
		}
	@endphp

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


<!-- <script type="text/javascript">



// completed vs pending


var options1 = {
	series: [{
		name: 'Completed',
		data: [{{ $completed_surveys_grp[0]['count'] }}, {{ $completed_surveys_grp[1]['count'] }}, {{ $completed_surveys_grp[2]['count'] }}, {{ $completed_surveys_grp[3]['count'] }}, {{ $completed_surveys_grp[4]['count'] }}, {{ $completed_surveys_grp[5]['count'] }}]
	}, {
		name: 'Pending',
		data: [{{ $pending_surveys_grp[0]['count'] }}, {{ $pending_surveys_grp[1]['count'] }}, {{ $pending_surveys_grp[2]['count'] }}, {{ $pending_surveys_grp[3]['count'] }}, {{ $pending_surveys_grp[4]['count'] }}, {{ $pending_surveys_grp[5]['count'] }}]
	}],
	colors: ['#705ec8','#fa057a'],
	chart: {
		height: 300,
		type: 'area'
	},
	dataLabels: {
		enabled: false
	},
	stroke: {
		curve: 'smooth'
	},
	xaxis: {
		type: 'datetime',
		categories: [new Date("//{{  $completed_surveys_grp[0]['date']; }}").toISOString(), new Date("// {{ $completed_surveys_grp[1]['date']; }}").toISOString(), new Date("{{  $completed_surveys_grp[2]['date']; }}").toISOString(), new Date("{{  $completed_surveys_grp[3]['date']; }}").toISOString(), new Date("{{   $completed_surveys_grp[4]['date']; }}").toISOString(), new Date("{{   $completed_surveys_grp[5]['date']; }}").toISOString()]
	},
	tooltip: {
		x: {
			format: 'm'
		},
	},
	legend: {
		show: false,
	}
};
var chart1 = new ApexCharts(document.querySelector("#chart"), options1);
chart1.render();

// each category chart	
var cat_data = [];
var cat_list = [];
@php if($completed_surveys){
	foreach($completed_surveys as $ck=>$cv)
	{ @endphp
cat_data.push( "{{ $cv['count'] }}" ); 
cat_list.push( "{{ $cv['name'] }}" ); 

	@php }
} @endphp


var options2 = {
	series: [{
		data: cat_data
	}],
	colors: ['#705ec8','#fa057a'],
	chart: {
		type: 'bar',
		height: 300,
	},
	plotOptions: {
		bar: {
			horizontal: false,
		}
	},
	dataLabels: {
		enabled: false
	},
	xaxis: {
		categories: cat_list,
	},
	legend: {
		show: false,
	}
};
var chart2 = new ApexCharts(document.querySelector("#chart2"), options2);
chart2.render();


// accepted vs pending


var options8 = {
	series: [{{ $accepted_surveys_percentage }}],
	chart: {
		height: 200,
		type: 'radialBar',
	},
	plotOptions: {
		radialBar: {
			hollow: {
				size: '70%',
			}
		},
	},
	labels: ['Accepted'],
	colors: ['#4454c3'],
	responsive: [{
		options: {
			legend: {
				show: false,
			}
		}
	}]
};
var chart8 = new ApexCharts(document.querySelector("#chart8"), options8);
chart8.render();


</script> -->

@endsection