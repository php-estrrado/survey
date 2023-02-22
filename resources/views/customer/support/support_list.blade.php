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
							<div class="card-header  card-header--2 package-card">
								<div>
									<h5>Help</h5>
								</div>
								<div class="d-inline-flex">
									<a href="#" class="modal-effect btn btn-primary" data-effect="effect-scale" data-bs-target="#modaldemo1" data-bs-toggle="modal" href=""> Create New </a>
								</div>
							</div>
							<div class="card-body pb-2">
								<div class="row">
									<div class="col-xl-12 col-lg-12">
										@if($help_requests && count($help_requests))
											@foreach($help_requests as $help_request)
												<div class="card border p-0 shadow-none">
													<div class="d-flex align-items-center p-4">
														<div class="wrapper ml-3">
															<h6 class="mb-0 mt-1 text-dark font-weight-semibold">Token - {{$help_request->id}}<span style="float: right;">{{date('d/m/Y',strtotime($help_request->created_at))}}</span></h6>
															<small class="text-muted">{{$help_request->description}}
															</small>
															<p><a href="{{ url('/customer/help_detail/')}}/{{$help_request->id}}" style="float: right;">Reply</a></p>
														</div>
													</div>
												</div>
											@endforeach
										@endif
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="container-fluid">
    	<!-- footer start-->
    	<footer class="footer">
			<div class="row">
				<div class="col-md-12 footer-copyright text-center">
					<p class="mb-0">Copyright 2022 © HSW </p>
				</div>
			</div>
    	</footer>
	</div>
</div>
<div class="modal" id="modaldemo2">
	<div class="modal-dialog" role="document">
		<div class="modal-content modal-content-demo">
			<form action="{{url('/customer/get_help')}}" method="post">
				@csrf
				<input type="hidden" value="" name="id" id="id">
				<div class="modal-header">
					<h6 class="modal-title">Send Performa Invoice</h6><button aria-label="Close" class="close" data-bs-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
				</div>
				<div class="modal-body">
					<div class="col-md-12">
						<div class="form-group">
							<label class="form-label" for="remarks">Remarks</label>
							<textarea class="form-control" name="remarks" id="remarks" rows="3" placeholder="Type Here..."></textarea>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button class="btn btn-primary" type="submit">Submit</button> <button class="btn btn-secondary" data-bs-dismiss="modal" type="button">Close</button>
				</div>
			</form>
		</div>
	</div>
</div>
<div class="modal" tabindex="-1" id="modaldemo1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Help</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="{{url('/customer/saveHelp')}}" method="post">
		@csrf
		<div class="modal-body">
			<div class="col-md-12">
				<div class="form-group">
					<label class="form-label" for="title">File No <span class="text-red">*</span></label>
					<input class="form-control" type="text" name="title" id="title">
				</div>
			</div>
			<div class="col-md-12">
				<div class="form-group">
					<label class="form-label" for="description">Description <span class="text-red">*</span></label>
					<textarea class="form-control mb-4" name="description" id="description" placeholder="Type Here..." rows="3"></textarea>
				</div>
			</div>
		</div>
		<div class="modal-footer">
			<button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
			<button type="submit" class="btn btn-primary">Save</button>
		</div>
	  </form>
    </div>
  </div>
</div>
@endsection