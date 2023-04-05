@extends('layouts.admin.master-admin')
@section('css')
<!-- Data table css -->
<link href="{{URL::asset('admin/assets/plugins/datatable/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet" />
<link href="{{URL::asset('admin/assets/plugins/datatable/css/buttons.bootstrap4.min.css')}}" rel="stylesheet">
<link href="{{URL::asset('admin/assets/plugins/datatable/responsive.bootstrap4.min.css')}}" rel="stylesheet" />
<!-- Slect2 css -->
<link href="{{URL::asset('admin/assets/plugins/select2/select2.min.css')}}" rel="stylesheet" />

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
		<div class="col-md-4 col-sm-4 col-xs-12" style="float:right">
			<div class="profile-cover">
				<div class="wideget-user-tab">
					<div class="tab-menu-heading p-0">
						<div class="tabs-menu1 px-3" style="float:right">
							<ul class="nav">
								<li><a href="#tab-7" class="active fs-14 btn btn-primary" data-toggle="tab">Field Study</a></li>
								<li><a href="#tab-8" data-toggle="tab" class="fs-14 btn btn-primary">Survey Study</a></li>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!--div-->
		<div class="tab-content">
			<div class="tab-pane active" id="tab-7">
				<div class="card">
					<div class="card-header">
						<div class="card-title fifty">New Service Requests Table</div>
					</div>
					<div class="card-body">
						<div class="table-responsive">
							<table class="table table-bordered text-nowrap" id="example2" style="width:100%">
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
												<td><a href="{{url('/admin/new_service_request_detail/')}}/{{$request->survey_id}}/{{$request->request_status}}" style="color:#2b8fca; font-weight:bold;">HSW{{$request->survey_id}}</a></td>
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
			</div>
			<div class="tab-pane" id="tab-8">
				<div class="card">
					<div class="card-header">
						<div class="card-title fifty">New Service Requests Table</div>
					</div>
					<div class="card-body">
						<div class="table-responsive">
							<table class="table table-bordered text-nowrap" id="example3" style="width:100%">
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
									@if($survey_study_requests && count($survey_study_requests)>0)
										@php $i=1; @endphp
										@foreach($survey_study_requests as $survey_study_request)
											<tr>
												<td>{{$i}}</td>
												<td>@php echo date('d/m/Y',strtotime($survey_study_request->survey_date)) @endphp</td>
												<td>{{$survey_study_request->name}}</td>
												<td><a href="{{url('/admin/requested_service_detail/')}}/{{$survey_study_request->survey_id}}/{{$survey_study_request->request_status}}" style="color:#2b8fca; font-weight:bold;">HSW{{$survey_study_request->survey_id}}</a></td>
												<td>{{$survey_study_request->cust_telecom_value}}</td>
												<td>{{$survey_study_request->username}}</td>
												<td>{{$survey_study_request->service_name}}</td>
											</tr>
											@php $i++; @endphp
										@endforeach
									@endif

								</tbody>
							</table>
						</div>
					</div>
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

<!-- INTERNAL Select2 js -->
<script src="{{URL::asset('admin/assets/plugins/select2/select2.full.min.js')}}"></script>
<script>
	$(document).ready(function(){
		$('#example3').DataTable({
			responsive: true,
			language: {
				searchPlaceholder: 'Search...',
				sSearch: '',
				lengthMenu: '_MENU_',
			},
			aLengthMenu: [
				[6, 10, 25, 50, 100, 200, -1],
				[6, 10, 25, 50, 100, 200, "All"]
			]
		});	
	});
</script>
@endsection