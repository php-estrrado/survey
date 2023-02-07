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
		<h4 class="page-title mb-0">Service Master</h4>
		<ol class="breadcrumb">
			<li class="breadcrumb-item"><a href="#"><i class="fe fe-layout mr-2 fs-14"></i>Dashboard</a></li>
			<li class="breadcrumb-item active" aria-current="page"><a href="#">Service Master</a></li>
		</ol>
	</div>
	<div class="page-rightheader">
		<div class="btn btn-list">
			<a href="#" class="btn btn-info"><i class="fe fe-plus mr-1"></i> Add </a>
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
				<div class="card-title">Roles List</div>
			</div>
			<div class="card-body">
				<div class="table-responsive">
					<table class="table table-bordered text-nowrap" id="example2">
						<thead>
							<tr>
								<th class="wd-15p border-bottom-0">SL. NO</th>
								<th class="wd-15p border-bottom-0">Name</th>
								<th class="wd-20p border-bottom-0">Date</th>
							
								<th class="wd-10p border-bottom-0">Actions</th>
							</tr>
						</thead>
						<tbody>
                        	@if($service_master && count($service_master) > 0)
	                    		@foreach($service_master as $row)
									<tr>
										<td>{{ $row->id }}</td>
										<td>{{ $row->service_name }}</td>
										<td>{{  date('d/m/Y', strtotime($row->created_at)); }}</td>
										<td>
											<div class="btn-list actn">
												<a href="#" class="modal-effect btn btn-success" data-effect="effect-scale" data-target="#modaldemo1" data-toggle="modal" href="" onclick="getId({{$row->id}})">Edit</a>
												<!-- <a href="#" class="btn btn-danger">Delete</a> -->
											</div>
										</td>
									</tr>							
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

<div class="modal" id="modaldemo1">
	<div class="modal-dialog" role="document">
		<div class="modal-content modal-content-demo">
			<form action="{{url('/superadmin/edit_service_rate')}}" method="post">
				@csrf
				<input type="hidden" value="" name="service_id" id="service_id">
				<div class="modal-header">
					<h6 class="modal-title">Edit Service Rate</h6><button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
				</div>
				<div class="modal-body">
					<div class="col-md-12">
						<div class="form-group">
							<label class="form-label" for="service_rate">Service Rate <span class="text-red">*</span></label>
							<input class="form-control" type="text" name="service_rate" id="service_rate">
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button class="btn btn-primary" type="submit">Submit</button> <button class="btn btn-secondary" data-dismiss="modal" type="button">Close</button>
				</div>
			</form>
		</div>
	</div>
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

<script>
	function getId($id)
	{
		$('#service_id').val($id);
	}
</script>

<!-- INTERNAL Select2 js -->
<script src="{{URL::asset('assets/plugins/select2/select2.full.min.js')}}"></script>
@endsection