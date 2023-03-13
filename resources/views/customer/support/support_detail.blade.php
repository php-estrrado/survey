@extends('layouts.customer_layout')
@section('css')
    <link href="{{URL::asset('admin/assets/traffic/web-traffic.css')}}" rel="stylesheet" type="text/css">
    		<link href="{{URL::asset('admin/assets/css/daterangepicker.css')}}" rel="stylesheet" />
<style>
.card-options {
	margin-left: 50%;
}
</style>
@endsection
@section('content')
<div class="page-body">
	<div class="container-fluid">
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
												<input type="text" class="form-control" placeholder="Search">
											</div>
										</div>
									</div>
								</div>
								<div class="row" style="margin-top: 15px;">
									<div class="col-xl-12 col-lg-12">
										<div class="card border p-0 shadow-none">
											<div class="row">
												<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="padding: 25px;">
													<div class="wrapper ml-3">
														<h6 class="mb-0 mt-1 text-dark font-weight-semibold">Token - {{$help_request_detail->id}}<span style="float: right;">{{date('d/m/Y',strtotime($help_request_detail->created_at))}}</span></h6>
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
								<form action="{{url('/customer/sendReply')}}" method="post">
									@csrf
									<input type="hidden" name="support_id" id="support_id" value="{{$help_request_detail->id}}">
									<div class="row">
										<div class="form-group">
											<div class="media-body">
												<div class="font-weight-normal1 mb-2">
													Remarks
												</div>
											</div>
											<textarea class="form-control mb-4" placeholder="Type Here..." rows="3" name="remarks"></textarea>
										</div>
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
	@include('includes.customer_footer')
</div>
@endsection