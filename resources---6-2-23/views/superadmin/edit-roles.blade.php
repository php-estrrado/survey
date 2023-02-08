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
</div>
<!--End Page header-->
@endsection
@section('content')
<!-- Row -->
<form method="POST" id="saveRole" action="{{ url('/superadmin/user-roles/save') }}" class="theme-form">
	@csrf
	{{Form::hidden('id',$userrole['id'],['id'=>'roleid'])}}											
	{{Form::hidden('is_selected',0,['is_selected'=>'is_selected'])}}
    <input type="hidden" name="module_changed" id="module_changed" value="0">
	<div class="row">
		<div class="col-12">
			<!--div-->
			<div class="card">
				<div class="card-body">
					<div class="row">
						<div class="col-sm-6 col-md-6">
							<div class="form-group">
								<label class="form-label" for="usr_role_name">Role <span class="text-red">*</span></label>
								<input type="text" class="form-control" name="usr_role_name" placeholder="First name" value="{{ $userrole->usr_role_name }}">
							</div>
						</div>
					</div>
				</div>
			</div>
			<!--/div-->
		</div>
	</div>
	<!-- /Row -->

	<!-- Row -->
	<div class="row">
		<div class="col-md-12 col-lg-12">
			<div class="card">
				<div class="card-header">
					<h3 class="card-title">Permissions</h3>
				</div>
				<div class="table-responsive">
					<table class="table card-table table-vcenter text-nowrap">
						<thead>
							<tr>
								<th>Modules</th>
								<th>View</th>
								<th>Edit</th>
								<th>Delete</th>
							</tr>
						</thead>
						<tbody>
							@if($modules && count($modules) > 0)
								@foreach($modules as $row)
									@php $pt = $row['parent'];  $child = $row['child']; @endphp
                                    @php $trows =  DB::table('usr_role_action')->where('usr_role_id',$userrole->id)->where('module_id',$pt['id'])->where('is_deleted',0)->where('is_active',1)->first();  @endphp
									<tr>
										<th>
											{{$pt['name']}}
										</th>
										<td>
											<div class="form-group mb-0">
												<label class="custom-switch" for="view-{{$pt['id']}}">
													<input class="custom-switch-input status-btn ser_status" name="modules[{{$pt['id']}}]['view']" data-selid="{{$pt['id']}}" id="view-{{$pt['id']}}" value="1"  type="checkbox" @if($trows) @if($trows->view ==1) {{ "checked" }} @endif @endif />
													<span class="custom-switch-indicator"></span>
												</label>
											</div>
										</td>
										<td>
											<div class="form-group mb-0">
												<label class="custom-switch" for="edit-{{$pt['id']}}">
													<input class="custom-switch-input status-btn ser_status" name="modules[{{$pt['id']}}]['edit']" id="edit-{{$pt['id']}}" data-selid="{{$pt['id']}}" value="1"  type="checkbox"  @if($trows) @if($trows->edit ==1) {{ "checked" }} @endif @endif />
													<span class="custom-switch-indicator"></span>
												</label>
											</div>
										</td>
										<td>
											<div class="form-group mb-0">
												<label class="custom-switch" for="delete-{{$pt['id']}}">
													<input class="custom-switch-input status-btn ser_status" name="modules[{{$pt['id']}}]['delete']" id="delete-{{$pt['id']}}" data-selid="{{$pt['id']}}" value="1"  type="checkbox" @if($trows) @if($trows->delete ==1) {{ "checked" }} @endif @endif />
													<span class="custom-switch-indicator"></span>
												</label>
											</div>
										</td>
									</tr>	
									@if($child && count($child) > 0) 
										@php $nrow = 'odd'; @endphp
										@foreach($child as $ch)
                                            @php $ctrows =  DB::table('usr_role_action')->where('usr_role_id',$userrole->id)->where('module_id',$ch['id'])->where('is_deleted',0)->where('is_active',1)->first();  @endphp
											<tr>
												<td>{{$ch['name']}}</td>
												<td>
													<div class="form-group mb-0">
														<label class="custom-switch" for="ch-view-{{$ch['id']}}">
															<input class="custom-switch-input status-btn ser_status" name="modules[{{$ch['id']}}]['view']" id="ch-view-{{$ch['id']}}" data-selid="{{$ch['id']}}" value="1"  type="checkbox"  @if($ctrows) @if($ctrows->view ==1) {{ "checked" }} @endif @endif />
															<span class="custom-switch-indicator"></span>
														</label>
													</div>
												</td>
												<td>
													<div class="form-group mb-0">
														<label class="custom-switch" for="ch-edit-{{$ch['id']}}">
															<input class="custom-switch-input status-btn ser_status" name="modules[{{$ch['id']}}]['edit']" data-selid="{{$ch['id']}}" id="ch-edit-{{$ch['id']}}" value="1"  type="checkbox" @if($ctrows) @if($ctrows->edit ==1) {{ "checked" }} @endif @endif />
															<span class="custom-switch-indicator"></span>
														</label>
													</div>
												</td>
												<td>
													<div class="form-group mb-0">
														<label class="custom-switch" for="ch-delete-{{$ch['id']}}">
															<input class="custom-switch-input status-btn ser_status" name="modules[{{$ch['id']}}]['delete']" id="ch-delete-{{$ch['id']}}" data-selid="{{$ch['id']}}" value="1"  type="checkbox" @if($ctrows) @if($ctrows->delete ==1) {{ "checked" }} @endif @endif />
															<span class="custom-switch-indicator"></span>
														</label>
													</div>
												</td>
											</tr>
											@php if($nrow == 'odd'){ $nrow = 'even'; }else{ $nrow = 'odd'; } @endphp
										@endforeach 
									@else
										<div class="row"><div class="col-12 br-line-wh"></div></div>
									@endif
								@endforeach
							@endif
						</tbody>
					</table>
				</div>
				<!-- table-responsive -->
			</div>
			<div class="btn-list d-flex justify-content-end">
				<button class="btn btn-info" type="submit" name="submit">Save</button>
				<a href="{{url('/superadmin/user-roles')}}" class="btn btn-danger">Cancel</a>
			</div>
		</div>
	</div>
	<!-- End Row -->
</form>

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
    $(".ser_status").change(function(){
        $("#module_changed").val(1);
    });
</script>
@endsection