@extends('layouts.admin.master')
@section('css')
<!-- Data table css -->
<link href="{{URL::asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet" />
<link href="{{URL::asset('assets/plugins/datatable/css/buttons.bootstrap4.min.css')}}" rel="stylesheet">
<link href="{{URL::asset('assets/plugins/datatable/responsive.bootstrap4.min.css')}}" rel="stylesheet" />
<!-- Slect2 css -->
<link href="{{URL::asset('assets/plugins/select2/select2.min.css')}}" rel="stylesheet" />

@endsection
@section('page-header')
<!--Page header-->
<div class="page-header">
	<div class="page-leftheader">
		<h4 class="page-title mb-0">New Service Request</h4>
		<ol class="breadcrumb">
			<li class="breadcrumb-item"><a href="#"><i class="fe fe-layout mr-2 fs-14"></i>Service And Requests</a></li>
			<li class="breadcrumb-item active" aria-current="page"><a href="#">New Service Request</a></li>
		</ol>
	</div>
	<!-- <div class="page-rightheader">
		<div class="btn btn-list">
			<a href="#" class="btn btn-info"><i class="fe fe-plus mr-1"></i> Add </a>
		</div>
	</div> -->
</div>
<!--End Page header-->
@endsection
@section('content')
<!-- Row -->
<div class="row">
	<div class="col-12">

		<!--div-->
		<div class="card">
			<div class="card-header">
				<div class="card-title fifty">New Service Requests List</div>
				<div class="card-title fifty">
					<div class="panel panel-default block">
						<div class="panel-body p-0" style="float:right;">
							<!-- <div class="btn-group mt-2 mb-2">
								<select class="form-control" id="institution_filter">
									<option value="">All</option>
									<?php if($sub_offices){ 
										foreach ($sub_offices as $sk => $sv) {
										
										?>
										<option value="{{ $sv->id }}" <?php if($ins ==$sv->id ){ echo 'selected'; } ?>> {{ $sv->institution_name }} </option>
									<?php } } ?>
								</select>
							</div> -->
							<div class="btn-group mt-2 mb-2">
								<select class="form-control" id="date_filter">
									<?php $year =date('Y'); $year_1 =date("Y",strtotime("-1 year")); $year_2 = date("Y",strtotime("-2 year"));   ?>
									<option value="">All</option>
									<option value="today" <?php if($date_val =="today" ){ echo 'selected'; } ?> >Today</option>
									<option value="week" <?php if($date_val =="week" ){ echo 'selected'; } ?> >This Week</option>
									<option value="month" <?php if($date_val =="month" ){ echo 'selected'; } ?> >This Month</option>
									<option value="{{ date('Y') }}"  <?php if($date_val ==$year ){ echo 'selected'; } ?> >This Year</option>
									<option value='{{ date("Y",strtotime("-1 year")); }}' <?php if($date_val ==$year_1 ){ echo 'selected'; } ?> >{{ date("Y",strtotime("-1 year")); }}</option>
									<option value='{{ date("Y",strtotime("-2 year"));}}' <?php if($date_val ==$year_2 ){ echo 'selected'; } ?> >{{ date("Y",strtotime("-2 year"));}}</option>
								</select>
							</div>
						</div>
					</div>

				</div>
			</div>
			<div class="card-body">
				<div class="table-responsive">
					<table class="table table-bordered text-nowrap" id="example2">
						<thead>
							<tr>
								<th class="wd-15p border-bottom-0">SL. NO</th>
								<th class="wd-15p border-bottom-0">Date</th>
								<th class="wd-15p border-bottom-0">Name</th>
								<th class="wd-15p border-bottom-0">File Number</th>
								<th class="wd-20p border-bottom-0">Mobile No.</th>
								<th class="wd-15p border-bottom-0">Email ID</th>
								<th class="wd-10p border-bottom-0">Requested Service</th>
							</tr>
						</thead>
						<tbody>
							@if($survey_requests && count($survey_requests)>0)
								@php $i=1; @endphp
								@foreach($survey_requests as $request)
									<tr>
										<td>{{$i}}</td>
										<td>@php echo date('d/m/Y',strtotime($request->survey_date)) @endphp</td>
										<td>{{$request->name}}</td>
										<td><a href="{{url('/superadmin/new_service_request_detail/')}}/{{$request->survey_id}}" style="color:#2b8fca; font-weight:bold;">HSW{{$request->survey_id}}</a></td>
										<td>{{$request->cust_telecom_value}}</td>
										<td>{{$request->username}}</td>
										<td>{{$request->service_name}}</td>
									</tr>
									@php $i++; @endphp
								@endforeach
							@endif

						</tbody>
					</table>
				</div>
			</div>
		</div>
		<!--/div-->

	</div>
</div>
<!-- /Row -->

</div>
</div><!-- end app-content-->
</div>
@endsection
@section('js')
<!-- INTERNAL Data tables -->
<script src="{{URL::asset('admin/assets/plugins/datatable/js/jquery.dataTables.js')}}"></script>
<script src="{{URL::asset('admin/assets/plugins/datatable/js/dataTables.bootstrap4.js')}}"></script>
<script src="{{URL::asset('admin/assets/plugins/datatable/js/dataTables.buttons.min.js')}}"></script>
<script src="{{URL::asset('admin/assets/plugins/datatable/js/buttons.bootstrap4.min.js')}}"></script>
<script src="{{URL::asset('admin/assets/plugins/datatable/js/jszip.min.js')}}"></script>
<script src="{{URL::asset('admin/assets/plugins/datatable/js/pdfmake.min.js')}}"></script>
<script src="{{URL::asset('admin/assets/plugins/datatable/js/vfs_fonts.js')}}"></script>
<script src="{{URL::asset('admin/assets/plugins/datatable/js/buttons.html5.min.js')}}"></script>
<script src="{{URL::asset('admin/assets/plugins/datatable/js/buttons.print.min.js')}}"></script>
<script src="{{URL::asset('admin/assets/plugins/datatable/js/buttons.colVis.min.js')}}"></script>
<script src="{{URL::asset('admin/assets/plugins/datatable/dataTables.responsive.min.js')}}"></script>
<script src="{{URL::asset('admin/assets/plugins/datatable/responsive.bootstrap4.min.js')}}"></script>
<script src="{{URL::asset('admin/assets/js/datatables.js')}}"></script>

<script type="text/javascript">
	$(document).ready(function(){
		$("#institution_filter").change(function(){
			var ins = $(this).val();
			var date_val = $('#date_filter').val();
				var ret_url = "{{ url('/superadmin/new_service_requests/') }}?ins="+ins+"&date_val="+date_val;
				window.location.replace(ret_url);
		});

		$("#date_filter").change(function(){
			var date_val = $(this).val();
			var ins = $('#institution_filter').val();
				var ret_url = "{{ url('/superadmin/new_service_requests/') }}?ins="+ins+"&date_val="+date_val;
				window.location.replace(ret_url);
		});

	});
</script>

<!-- INTERNAL Select2 js -->
<script src="{{URL::asset('assets/plugins/select2/select2.full.min.js')}}"></script>
@endsection