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
		<h4 class="page-title mb-0">Roles</h4>
		<ol class="breadcrumb">
			<li class="breadcrumb-item"><a href="#"><i class="fe fe-layout mr-2 fs-14"></i>User Role Management</a></li>
			<li class="breadcrumb-item active" aria-current="page"><a href="#">Roles</a></li>
		</ol>
	</div>
	<div class="page-rightheader">
		<div class="btn btn-list">
			<a href="{{ url('/superadmin/user-roles/create')}}" class="btn btn-info"><i class="fe fe-plus mr-1"></i> Add </a>
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
								<th class="wd-15p border-bottom-0">Role</th>
								<th class="wd-15p border-bottom-0">Status</th>
								<th class="wd-10p border-bottom-0">Actions</th>
							</tr>
						</thead>
						<tbody>
							@if($userroles && count($userroles) > 0)
								@php $i=1; @endphp
								@foreach($userroles as $row)
									<tr>
										<td>{{$i}}</td>
										<td class="align-middle" >
											<div class="d-flex">
												<h6 class=" font-weight-bold">{{$row['usr_role_name']}}</h6>
											</div>
										</td>
										<td>
											<div class="form-group mb-0">
												<label class="custom-switch" for="status-{{$row['id']}}">
													<input class="custom-switch-input status-btn ser_status" data-selid="{{$row['id']}}"  id="status-{{$row['id']}}"  type="checkbox" @if($row['id'] ==1) {{ "checked disabled" }}   @endif  @if($row['is_active'] ==1) {{ "checked" }} @endif >
													<span class="custom-switch-indicator"></span>
												</label>
											</div>
										</td>
										<td>
											<div class="btn-list actn">
												<button class="btn btn-success" type="button"><a href="{{ url('superadmin/user-roles/edit/') }}/{{$row['id']}}">Edit</a></button>
												<button class="btn btn-danger" type="button" onclick="deleteuser_roles({{$row['id']}})">Delete</button>
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
    function deleteuser_roles(id){
        console.log(id);
        $.ajax({
            type: "POST",
            url: '{{url("/superadmin/user-roles/delete")}}',
            data: { "_token": "{{csrf_token()}}", id: id},
            success: function (data) {
                // alert(data);
                if(data ==1){
                    location.reload();
                }
            }
        });
    }
</script>
@endsection