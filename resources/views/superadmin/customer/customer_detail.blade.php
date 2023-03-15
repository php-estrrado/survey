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
		<h4 class="page-title mb-0">Customers</h4>
		<ol class="breadcrumb">
			<li class="breadcrumb-item"><a href="{{url('superadmin/customers')}}"><i class="fe fe-layout mr-2 fs-14"></i>Customers</a></li>
			<li class="breadcrumb-item active" aria-current="page"><a href="#">Customer Detail</a></li>
		</ol>
	</div>
</div>
<!--End Page header-->
@endsection
@section('content')

<!-- Row -->
<div class="row">
	<div class="col-xl-4 col-lg-4 col-md-12">

		<div class="card">
			<div class="card-body">
				<h4 class="card-title">Personal Details</h4>
				<div class="table-responsive">
					<table class="table mb-0">
						<tbody>
							<tr>
								<td class="py-2 px-0">
									<span class="font-weight-semibold w-50">Name </span>
								</td>
								<td class="py-2 px-0">{{$info->name}}</td>
							</tr>
							<tr>
								<td class="py-2 px-0">
									<span class="font-weight-semibold w-50">Name Of The Firm </span>
								</td>
								<td class="py-2 px-0">{{$info->firm}}</td>
							</tr>
							<tr>
								<td class="py-2 px-0">
									<span class="font-weight-semibold w-50">Type Of Firm </span>
								</td>
								<?php
									$sector_name = array(1=>"Government",2=>'Private',3=>'Individual',4=>'Quasi Government',5=>'Research Organisation',6=>'State Government',7=>'Central Government');                             
								?>	
								<td class="py-2 px-0">@if(isset($sector_name[$info->firm_type])) {{ $sector_name[$info->firm_type]}} @else {{ $info->firm_type }} @endif</td>
							</tr>
							<tr>
								<td class="py-2 px-0">
									<span class="font-weight-semibold w-50">Email </span>
								</td>
								<td class="py-2 px-0">{{$customer_mst->username}}</td>
							</tr>
							<tr>
								<td class="py-2 px-0">
									<span class="font-weight-semibold w-50">Phone </span>
								</td>
								<td class="py-2 px-0">{{$telecom->cust_telecom_value}}</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
	<div class="col-xl-8 col-lg-8 col-md-12">
		<div class="main-content-body main-content-body-profile card">
			<div class="main-profile-body">
				<div class="card-body">
					<div class="table-responsive">
						<table class="table table-bordered text-nowrap" id="example2">
							<thead>
								<tr>
									<th class="wd-15p border-bottom-0">SL. NO</th>
									<th class="wd-15p border-bottom-0">Date</th>
									<th class="wd-15p border-bottom-0">File Number</th>
									<th class="wd-15p border-bottom-0">Requested Service</th>
									<th class="wd-10p border-bottom-0">Status</th>
								</tr>
							</thead>
							<tbody>
								@if($requested_services && count($requested_services)>0)
									@php $i=1; @endphp
									@foreach($requested_services as $requested_service)
										<tr>
											<td>{{$i}}</td>
											<td>{{date('d/m/Y', strtotime($requested_service->survey_date))}}</td>
											<td>HSW{{$requested_service->survey_id}}</td>
											<td>{{$requested_service->service_name}}</td>
											<td>{{$requested_service->current_status}}</td>
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
</div>
<!-- /Row -->

</div>
</div><!-- end app-content-->
</div>
@endsection
@section('js')
<!-- INTERNAL Data tables -->
<script src="{{URL::asset('assets/plugins/datatable/js/jquery.dataTables.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.bootstrap4.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.buttons.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/buttons.bootstrap4.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/jszip.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/pdfmake.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/vfs_fonts.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/buttons.html5.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/buttons.print.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/buttons.colVis.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/dataTables.responsive.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/responsive.bootstrap4.min.js')}}"></script>
<script src="{{URL::asset('assets/js/datatables.js')}}"></script>

<!-- INTERNAL Select2 js -->
<script src="{{URL::asset('assets/plugins/select2/select2.full.min.js')}}"></script>
@endsection