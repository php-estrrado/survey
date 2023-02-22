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
                            <div class="col-md-4">
                                <div class="card">
                                    <div class="card-body">
                                        <p>
                                            <strong>Name</strong> : {{$user->fullname}}
                                            <br />
                                            <span>{{$user->designation}}</span>
                                        </p>
                                        <p><strong>Email</strong> : {{$user->email}}</p>
                                        <p><strong>Phone</strong> : {{$user->phone}}</p>
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