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
		<h4 class="page-title mb-0">Head And Sub Offices</h4>
		<ol class="breadcrumb">
			<li class="breadcrumb-item"><a href="#"><i class="fe fe-layout mr-2 fs-14"></i>Dashboard</a></li>
			<li class="breadcrumb-item active" aria-current="page"><a href="#">Head And Sub Offices</a></li>
		</ol>
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
				<div class="card-title">Head And Sub Offices</div>
			</div>
			<div class="card-body">
                <div class="row">
                    @if(isset($users) && count($users))
                        @foreach($users as $user)
							<div class="col-xl-4 col-lg-6">
								<div class="card border p-0 shadow-none">
									<div class="d-flex align-items-center p-4">
										@if($user->avatar != '')
											<div class="avatar avatar-lg brround d-block cover-image" data-image-src="{{$user->avatar}}"></div>
										@else
											<div class="avatar avatar-lg brround d-block cover-image" data-image-src="{{URL::asset('admin/assets/images/image2.png')}}"></div>
										@endif
										<div class="wrapper ml-3">
											<p class="mb-0 mt-1 text-dark font-weight-semibold">{{$user->fullname}}</p>
											<small class="text-muted">{{$user->designation}}</small>
										</div>
									</div>
									<div class="card-body border-top">
										<ul class="mb-0 user-details">
											<li class="mb-3"><span class="user-icon"><i class="fe fe-mail "></i></span><span class="h6">{{$user->email}}</span></li>
											<li><span class="user-icon"><i class="fe fe-phone-call"></i></span><span class="h6">{{$user->phone}}</span></li>
										</ul>
									</div>
								</div>
							</div>
                        @endforeach
                    @endif
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
	jQuery(".addoffice").click(function(){
		jQuery("#modaldemo1 .modal-title").text("Create Office");
		jQuery("#office_form #institution_id").val(0);
		$("#office_form").trigger("reset");
	});

	jQuery(".editoffice").click(function(){

		jQuery("#modaldemo1 .modal-title").text("Edit Office");

		var institution_field_id = jQuery(this).parents("tr").find("#institution_field_id").data("value");
		var institution_field_name = jQuery(this).parents("tr").find("#institution_field_name").data("value");

		jQuery("#office_form #institution_id").val(institution_field_id);
		jQuery("#office_form #institution_name").val(institution_field_name);
	});
</script>
@endsection