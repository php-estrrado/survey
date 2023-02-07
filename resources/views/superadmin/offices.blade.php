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
	<div class="page-rightheader">
		<div class="btn btn-list">
			<a href="#" class="btn btn-info addoffice" data-target="#modaldemo1" data-toggle="modal" href=""><i class="fe fe-plus mr-1"></i> Add </a>
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
				<div class="card-title">Institution List</div>
			</div>
			<div class="card-body">
				<div class="table-responsive">
					<table class="table table-bordered text-nowrap" id="example2">
						<thead>
							<tr>
								<th class="wd-15p border-bottom-0">SL. NO</th>
								<th class="wd-15p border-bottom-0">Institution</th>
								<th class="wd-20p border-bottom-0">Created On</th>
								<th class="wd-10p border-bottom-0">Actions</th>
							</tr>
						</thead>
						<tbody>
							@if($active_offices && count($active_offices) > 0)
								@php $i=1; @endphp
								@foreach($active_offices as $row)
									<tr>
										<td class="align-middle select-checkbox" id="institution_field_id" data-value="{{$row['id']}}" data-parent="0">
											<label class="custom-control custom-checkbox">
												{{$i}}
											</label>
										</td>
										<td class="align-middle" id="institution_field_name" data-value="{{$row['institution_name']}}">
											<div class="d-flex">
												<h6 class=" font-weight-bold">{{$row['institution_name']}}</h6>
											</div>
										</td>
										<td class="align-middle" id="institution_field_created" data-value="{{$row['created_at']}}">
											<div class="d-flex">
												<h6 class=" font-weight-bold">@php echo date('d/m/Y', strtotime($row['created_at'])); @endphp</h6>
											</div>
										</td>
										<td>
											<div class="btn-list actn">
												<a href="#" class="btn btn-success editoffice" data-toggle="modal" data-target="#modaldemo1">Edit</a>
											</div>
										</td>
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


<div class="modal" id="modaldemo1">
	<div class="modal-dialog" role="document">
		<div class="modal-content modal-content-demo">
			<form action="{{url('/superadmin/offices/save')}}" method="post" id="office_form">
				@csrf
				{{Form::hidden('id',0,['id'=>'institution_id'])}}
				<div class="modal-header">
					<h6 class="modal-title">Add Institution</h6><button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
				</div>
				<div class="modal-body">
					<div class="col-md-12">
						<div class="form-group">
							<label class="form-label" for="institution_name">Institution Name <span class="text-red">*</span></label>
							<input class="form-control mb-4" placeholder="Institution Name" type="text" name="institution_name" id="institution_name">
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button class="btn btn-primary" type="submit">Save</button> <button class="btn btn-secondary" data-dismiss="modal" type="button">Close</button>
				</div>
			</form>
		</div>
	</div>
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