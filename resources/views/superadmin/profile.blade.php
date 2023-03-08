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
		<h4 class="page-title mb-0">Profile</h4>
		<ol class="breadcrumb">
			<li class="breadcrumb-item"><a href="#"><i class="fe fe-layout mr-2 fs-14"></i>Dashboad</a></li>
			<li class="breadcrumb-item active" aria-current="page"><a href="#">Profile</a></li>
		</ol>
	</div>
</div>
<!--End Page header-->
@endsection
@section('content')

<!-- Row -->
<div class="row">
	<div class="col-xl-3 col-lg-3 col-md-12">
		<div class="card box-widget widget-user">
			<div class="widget-user-image mx-auto mt-5"><img alt="User Avatar" class="rounded-circle" src="{{url($admin->avatar)}}"></div>
			<div class="card-body text-center">
				<div class="pro-user">
					<h4 class="pro-user-username text-dark mb-1 font-weight-bold">{{ $admin->fname }}</h4>
					<h6 class="pro-user-desc text-muted">{{$role}}</h6>
				</div>
			</div>
		</div>
	</div>
	<div class="col-xl-9 col-lg-9 col-md-12">
		<form action="{{url('/superadmin/edit_profile')}}" method="post" enctype="multipart/form-data">
			@csrf
			<input type="hidden" name="admin_id" value="{{$admin->id}}">
			<div class="main-content-body main-content-body-profile card">
				<div class="main-profile-body">
					<div class="card-body">
						<div class="row">
							<div class="col-sm-6 col-md-6">
								<div class="form-group">
									<label class="form-label" for="name">Full Name <span class="text-red">*</span></label>
									<input type="text" class="form-control" name="name" id="name" placeholder="Full Name" value="{{ $admin->fname }}">
									<div id="name_error"></div>
									@error('name')
										<p style="color: red">{{ $message }}</p>
									@enderror
								</div>
							</div>
							<div class="col-sm-6 col-md-6">
								<div class="form-group">
									<label class="form-label" for="phone">Phone Number <span class="text-red">*</span></label>
									<input type="number" minlength="10" maxlength="10" class="form-control" name="phone" id="phone" placeholder="Phone Number" value="{{ $admin->phone }}">
									<div id="phone_error"></div>
									@error('phone')
										<p style="color: red">{{ $message }}</p>
									@enderror
								</div>
							</div>
							<div class="col-sm-6 col-md-6">
								<div class="form-group">
									<label class="form-label" for="email">Email ID <span class="text-red">*</span></label>
									<input type="text" class="form-control" name="email" id="email" placeholder="Email ID" value="{{ $admin->email }}">
									<div id="email_error"></div>
									@error('email')
										<p style="color: red">{{ $message }}</p>
									@enderror
								</div>
							</div>
							<div class="col-sm-6 col-md-6">
								<div class="form-group">
									<label class="form-label" for="designation">Designation <span class="text-red">*</span></label>
									<input type="text" class="form-control" name="designation" id="designation" placeholder="Designation" value="{{ $user->designation }}">
									<div id="designation_error"></div>
									@error('designation')
										<p style="color: red">{{ $message }}</p>
									@enderror
								</div>
							</div>
							<div class="col-sm-6 col-md-6">
								<div class="form-group">
									<label class="form-label" for="pen">PEN Number <span class="text-red">*</span></label>
									<input type="text" class="form-control" name="pen" id="pen" placeholder="PEN Number" value="{{ $user->pen }}">
									<div id="pen_error"></div>
									@error('pen')
										<p style="color: red">{{ $message }}</p>
									@enderror
								</div>
							</div>
							<div class="col-sm-6 col-md-6">
								<div class="form-group">
									<label class="form-label" for="avatar">Profile Pic</label>
									<div class="custom-file">
										<input type="file" class="custom-file-input" name="avatar" id="avatar" >
										<label class="custom-file-label"></label>
									</div>
									<div id="avatar_error"></div>
									@error('avatar')
										<p style="color: red">{{ $message }}</p>
									@enderror
								</div>
								<div class="col-md-6 mb-3">
									<img id="avatar_img" src="{{url('public/admin/assets/images/image2.png')}}" alt="avatar" style="height: 120px;" />
								</div>
							</div>
							<div class="col-sm-6 col-md-6">
								<div class="form-group">
									<label class="form-label" for="institution">Institution <span class="text-red">*</span></label>
									<select class="form-control select2" name="institution" id="institution"> 
										@if($institutions && count($institutions) > 0)
											@foreach($institutions as $institution)
												<option value="{{$institution['id']}}" {{ $user->institution == $institution['id'] ? 'selected' : '' }}>{{$institution['institution_name']}}</option>
											@endforeach
										@endif
									</select>
									<div id="institution_error"></div>
									@error('institution')
										<p style="color: red">{{ $message }}</p>
									@enderror
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="btn-list d-flex justify-content-end">
				<button class="btn btn-info" type="submit">Save</button>
				<a class="btn btn-danger" onclick="history.back()">Cancel</a>
			</div>
		</form>
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