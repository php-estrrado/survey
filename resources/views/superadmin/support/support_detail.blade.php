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
		<h4 class="page-title mb-0">Support Management</h4>
		<ol class="breadcrumb">
			<li class="breadcrumb-item"><a href="#"><i class="fe fe-layout mr-2 fs-14"></i>Dashboard</a></li>
			<li class="breadcrumb-item active" aria-current="page"><a href="#">Support Management</a></li>
		</ol>
	</div>
</div>
<!--End Page header-->
@endsection
@section('content')
<!-- Row -->
<div class="row flex-lg-nowrap">
	<div class="col-12">
		<div class="row flex-lg-nowrap">
			<div class="col-12 mb-3">
				<div class="e-panel card">
					<div class="card-body pb-2">
						<div class="row">
							<div class="col-6 col-auto">
								<div class="form-group">
									<div class="input-icon">
										<span class="input-icon-addon">
											<i class="fe fe-search"></i>
										</span>
										<!-- <input type="text" class="form-control" placeholder="Search"> -->
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-xl-12 col-lg-12">
								<div class="card border p-0 shadow-none">
									<div class="row">
										<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="padding: 25px;">
											<div class="wrapper ml-3">
												<h6 class="mb-0 mt-1 text-dark font-weight-semibold">Token - {{$help_request_detail->id}}<span style="float: right;">11/12/2022</span></h6>
												<small class="text-muted">
													{{$help_request_detail->description}}
												</small>
												<hr>
												@if(isset($help_request_logs) && count($help_request_logs) > 0)
													@foreach($help_request_logs as $help_request)
														<p>
															{{$help_request->comment}}
														</p>
													@endforeach
												@endif
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
								<form action="{{url('/superadmin/sendReply')}}" method="post">
									@csrf
									<input type="hidden" name="support_id" id="support_id" value="{{$help_request_detail->id}}">
									<input type="hidden" name="to_user_id" id="to_user_id" value="{{$help_request_detail->from_id}}">
									<div class="form-group">
										<div class="media-body">
											<div class="font-weight-normal1 mb-2">
												Remarks
											</div>
										</div>
										<textarea class="form-control mb-4" placeholder="Type Here..." rows="3" name="remarks"></textarea>
									</div>
									<div class="row">
										<div class="col-12">
											<div class="btn-list d-flex justify-content-end">
												<button class="btn btn-primary">Send</button>
											</div>
										</div>
									</div>
								</form>
							</div>
						</div>
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