@extends('layouts.admin.master-accountant')
@section('css')
<!-- Data table css -->
<link href="{{URL::asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet" />
<link href="{{URL::asset('assets/plugins/datatable/css/buttons.bootstrap4.min.css')}}" rel="stylesheet">
<link href="{{URL::asset('assets/plugins/datatable/responsive.bootstrap4.min.css')}}" rel="stylesheet" />
<!-- Slect2 css -->
<link href="{{URL::asset('assets/plugins/select2/select2.min.css')}}" rel="stylesheet" />
<!-- INTERNAL Gallery css -->
<link href="{{URL::asset('assets/plugins/gallery/gallery.css')}}" rel="stylesheet">

@endsection
@section('page-header')
<!--Page header-->
<div class="page-header">
	<div class="page-leftheader">
		<h4 class="page-title mb-0">Services And Requests</h4>
		<ol class="breadcrumb">
			<li class="breadcrumb-item"><a href="#"><i class="fe fe-layout mr-2 fs-14"></i>Services And Requests</a></li>
			<li class="breadcrumb-item active" aria-current="page"><a href="#">Invoice</a></li>
		</ol>
	</div>
</div>
<!--End Page header-->
@endsection
@section('content')

<!--/app header-->
<div class="main-proifle">
	<div class="row">
		<div class="col-lg-6">
			<div class="box-widget widget-user">
				<div class="widget-user-image1 d-sm-flex">
					<div class="mt-1">
						<h4 class="pro-user-username mb-3 font-weight-bold">@if(isset($survey_id)){{ "HSW".$survey_id }}@endif</h4>
						<ul class="mb-0 pro-details">
							<li><span class="h6 mt-3">Name: {{$cust_info->name}}</span></li>
							<li><span class="h6 mt-3">Name of the firm: {{$cust_info->firm}}</span></li>
							<li><span class="h6 mt-3">Type of firm: {{$cust_info->firm_type}}</span></li>
							<li><span class="h6 mt-3">Email ID: {{$cust_email}}</span></li>
							<li><span class="h6 mt-3">Mobile No.: {{$cust_phone}}</span></li>
							<li><span class="h6 mt-3">Valid ID Proof: {{$cust_info->valid_id}}</span></li>
							<li><span class="h6 mt-3">Amount to be paid: Rs {{$survey_invoice->total_invoice_amount}}</span></li>
							<li><span class="h6 mt-3">Amount paid: Rs {{$survey_invoice->total_invoice_amount}}</span></li>
						</ul>
					</div>
				</div>
			</div>
		</div>
		<div class="col-lg-6 col-md-auto">
			<div class="text-lg-right btn-list mt-4 mt-lg-0">
				<a href="#" class="modal-effect btn btn-primary" data-effect="effect-scale" data-target="#modaldemo1" data-toggle="modal" href="">Verify</a>
				<a href="#" class="modal-effect btn btn-danger" data-effect="effect-scale" data-target="#modaldemo2" data-toggle="modal" href="">Reject</a>
			</div>
			<div class="mt-5">
				<div class="main-profile-contact-list row">
					<div class="media col-sm-3">
						<div class="media-icon bg-primary text-white mr-3 mt-1">
							<i class="fa fa-comments fs-18"></i>
						</div>
						<div class="media-body">
							<small class="text-muted">Date</small>
							<div class="font-weight-normal1">
								{{date('d/m/Y',strtotime($survey_request_data->created_at))}}
							</div>
						</div>
					</div>
					<div class="media col-sm-4">
						<div class="media-icon bg-secondary text-white mr-3 mt-1">
							<i class="fa fa-users fs-18"></i>
						</div>
						<div class="media-body">
							<small class="text-muted">Requested Service</small>
							<div class="font-weight-normal1">
								{{$service}}
							</div>
						</div>
					</div>
					<div class="media col-sm-5">
						<div class="media-icon bg-info text-white mr-3 mt-1">
							<i class="fa fa-feed fs-18"></i>
						</div>
						<div class="media-body">
							<small class="text-muted">Status</small>
							<div class="font-weight-normal1">
								@if(isset($survey_request_data->RequestStatus))	{{ $survey_request_data->RequestStatus->status_name }} @endif
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="profile-cover">
		<div class="wideget-user-tab">
			<div class="tab-menu-heading p-0">
			</div>
		</div>
	</div><!-- /.profile-cover -->
</div>


<!-- Row -->
<div class="row">
	<div class="col-12">

		<!--div-->
		<div class="card newser">
			<div class="card-body">
				<div class="row">
					<div class="col-sm-12 col-md-12">
						<!-- <div style="float: right;"><a href="">View</a></div> -->
						<div class="form-group">
							<div class="card border-0 p-0 shadow-none">
								<div class="card-body pt-0 text-center">
									<div class="file-manger-icon">
										<a href="{{$survey_request_data->receipt_image}}" target="_blank"><img src="{{url('admin/assets/images/file_image.png')}}" alt="img" class="br-7"><br />View</a>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!--/div-->

	</div>
</div>


<!-- <div class="row">
	<div class="col-12">
		<div class="btn-list d-flex justify-content-end">
			<a href="#" class="modal-effect btn btn-primary">Assign</a>
			<a href="#" class="modal-effect btn btn-danger" data-effect="effect-scale" data-target="#modaldemo2" data-toggle="modal" href="">Reject</a>
		</div>
	</div>
</div> -->


</div>
</div><!-- end app-content-->
</div>

<div class="modal" id="modaldemo1">
	<div class="modal-dialog" role="document">
		<div class="modal-content modal-content-demo">
			<form action="{{url('/accountant/verify_customer_receipt')}}" method="post" id="verifyform">
				@csrf
				<input type="hidden" value="{{$survey_id}}" name="id" id="id">
				<div class="modal-header">
					<h6 class="modal-title">Verify Receipt</h6><button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
				</div>
				<div class="modal-body">
					<div class="col-md-12">
						<div class="form-group">
							<label class="form-label" for="remarks">Remarks</label>
							<textarea class="form-control verifyremarks" name="remarks" id="remarks" rows="3" placeholder="Type Here..."></textarea>
							<p style="color: red; display: none;" id="remarksverify"></p>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button class="btn btn-primary"  type="button" id="verifybutton">Submit</button> <button class="btn btn-secondary" data-dismiss="modal" type="button">Close</button>
				</div>
			</form>
		</div>
	</div>
</div>

<div class="modal" id="modaldemo2">
	<div class="modal-dialog" role="document">
		<div class="modal-content modal-content-demo">
			<form action="{{url('/accountant/reject_customer_receipt')}}" method="post" id="rejectform">
				@csrf
				<input type="hidden" value="{{$survey_id}}" name="id" id="id">
				<div class="modal-header">
					<h6 class="modal-title">Reject</h6><button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
				</div>
				<div class="modal-body">
					<div class="col-md-12">
						<div class="form-group">
							<label class="form-label" for="remarks">Remarks <span class="text-red">*</span></label>
							<textarea class="form-control rejectremark" rows="3" placeholder="Type Here..." name="remarks" id="remarks"></textarea>
							<p style="color: red; display: none;" id="remarksreject"></p>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button class="btn btn-primary" id="rejectbutton" type="button">Reject</button> <button class="btn btn-secondary" data-dismiss="modal" type="button">Close</button>
				</div>
			</form>
		</div>
	</div>
</div>


@endsection
@section('js')
<!-- INTERNAL Data tables -->
<!-- <script src="{{URL::asset('assets/plugins/datatable/js/jquery.dataTables.js')}}"></script>
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
<script src="{{URL::asset('assets/js/datatables.js')}}"></script> -->
<!-- INTERNAL Gallery js -->
<script src="{{URL::asset('assets/plugins/gallery/picturefill.js')}}"></script>
<script src="{{URL::asset('assets/plugins/gallery/lightgallery.js')}}"></script>
<script src="{{URL::asset('assets/plugins/gallery/lg-pager.js')}}"></script>
<script src="{{URL::asset('assets/plugins/gallery/lg-autoplay.js')}}"></script>
<script src="{{URL::asset('assets/plugins/gallery/lg-fullscreen.js')}}"></script>
<script src="{{URL::asset('assets/plugins/gallery/lg-zoom.js')}}"></script>
<script src="{{URL::asset('assets/plugins/gallery/lg-hash.js')}}"></script>
<script src="{{URL::asset('assets/js/gallery.js')}}"></script>

<script type="text/javascript">
	$(document).ready(function(){

$("#rejectbutton").click(function(){
	
$("#remarksreject").hide();
if($.trim($('.rejectremark').val()) == '') {
   $("#remarksreject").text("Please type remarks.");
   $("#remarksreject").show();
}else{
	$("#rejectform").submit();
}

});



$("#verifybutton").click(function(){
	
$("#remarksverify").hide();
if($.trim($('.verifyremarks').val()) == '') {
   $("#remarksverify").text("Please type remarks.");
   $("#remarksverify").show();
}else{
	$("#verifyform").submit();
}

});

	});
</script>
<!-- INTERNAL Select2 js -->
<script src="{{URL::asset('assets/plugins/select2/select2.full.min.js')}}"></script>
@endsection