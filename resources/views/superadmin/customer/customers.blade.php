@extends('layouts.admin.master')
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
		<h4 class="page-title mb-0">Customers</h4>
		<!-- <ol class="breadcrumb">
			<li class="breadcrumb-item"><a href="#"><i class="fe fe-layout mr-2 fs-14"></i>Customers</a></li>
			<li class="breadcrumb-item active" aria-current="page"><a href="#">Customers</a></li>
		</ol> -->
	</div>
	<div class="page-rightheader">
		<div class="btn btn-list">
			<a href="{{ url('/superadmin/customers/create')}}" class="btn btn-info"><i class="fe fe-plus mr-1"></i> Add </a>
		</div>
	</div>
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
				<div class="card-title">Customers Table</div>
			</div>
			<div class="card-body">
				<div class="table-responsive">
					<table class="table table-bordered text-nowrap" id="example2" width="100%">
						<thead>
							<tr>
								<th class="wd-15p border-bottom-0">SL. NO</th>
								<th class="wd-15p border-bottom-0">Date</th>
								<th class="wd-15p border-bottom-0">Name</th>
								<th class="wd-20p border-bottom-0">Mobile No.</th>
								<th class="wd-15p border-bottom-0">Email ID</th>
								<th class="wd-10p border-bottom-0">Type Of Firm</th>
								<th class="wd-10p border-bottom-0">Service Requested</th>
							</tr>
						</thead>
						<tbody>
							@if($customers && count($customers)>0)
								@php $i=1; @endphp
								@foreach($customers as $customer)
									<tr>
										<td>{{$i}}</td>
										<td>@php echo date('d/m/Y', strtotime($customer->created_at)); @endphp</td>
										<td><a href="{{URL('/superadmin/customers/view')}}/{{$customer->cust_id}}" style="color:#2b8fca; font-weight:bold;">{{$customer->name}}</a></td>
										<td>+91 {{$customer->cust_telecom_value}}</td>
										<td>{{$customer->username}}</td>
										<td>{{$customer->firm}}</td>
										<td>{{latest_customer_req($customer->cust_id)}}</td>
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

<!-- INTERNAL Select2 js -->
<script src="{{URL::asset('admin/assets/plugins/select2/select2.full.min.js')}}"></script>
@endsection