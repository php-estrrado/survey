@extends('layouts.admin.master-admin')
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
		<h4 class="page-title mb-0">Customers</h4>
		<ol class="breadcrumb">
			<li class="breadcrumb-item"><a href="{{url('/admin/customers')}}"><i class="fe fe-layout mr-2 fs-14"></i>Customers</a></li>
			<li class="breadcrumb-item active" aria-current="page"><a href="{{url('/admin/customers/create')}}">Add Customers</a></li>
		</ol>
	</div>
</div>
<!--End Page header-->
@endsection
@section('content')
<!-- Row -->
<div class="row">
	<div class="col-12">
		<form method="POST" id="customerLogin" action="{{ url('/admin/customers/customerSave') }}" class="theme-form" enctype="multipart/form-data" autocomplete="off">
			@csrf
			<input type="hidden" name="id" id="id" value="0">
			<!--div-->
			<div class="card">
				<div class="card-body">
					<div class="row">
						<div class="col-sm-6 col-md-6">
							<div class="form-group">
								<label class="form-label" for="full_name">Full Name <span class="text-red">*</span></label>
								<input type="text" class="form-control" name="full_name" id="full_name" placeholder="Full Name" value="{{ old('full_name') }}">
								<div id="full_name_error"></div>
								@error('full_name')
									<p style="color: red">{{ $message }}</p>
								@enderror
							</div>
						</div>
						<div class="col-sm-6 col-md-6">
							<div class="form-group">
								<label class="form-label" for="firm">Name Of Organization <span class="text-red">*</span></label>
								<input type="text" class="form-control" name="firm" id="firm" placeholder="Name Of Organization" value="{{ old('firm') }}">
								<div id="firm_error"></div>
								@error('firm')
									<p style="color: red">{{ $message }}</p>
								@enderror
							</div>
						</div>
						<!-- <div class="col-sm-6 col-md-6">
							<div class="form-group">
								<label class="form-label" for="firm">Name Of Firm <span class="text-red">*</span></label>
								<input type="text" class="form-control" name="firm" id="firm" placeholder="Name Of Firm" value="{{ old('firm') }}">
								<div id="firm_error"></div>
								@error('firm')
									<p style="color: red">{{ $message }}</p>
								@enderror
							</div>
						</div> -->
						<!-- <div class="col-sm-6 col-md-6">
							<div class="form-group">
								<label class="form-label" for="country">Country <span class="text-red">*</span></label>
								<select class="form-control select2" name="country" id="country">
									@if($countries && count($countries) > 0)
										@foreach($countries as $country)
											<option value="$country['id']">{{$country['country_name']}}</option>
										@endforeach
									@endif
								</select>
							</div>
						</div> -->
						<div class="col-sm-6 col-md-6">
							<div class="form-group">
								<label class="form-label" for="firm_type">Type of Organization <span class="text-red">*</span></label>
								<select id="menu-type" class="form-control select2" name="firm_type">
									<option value="">Select</option>
									<option value="1" {{ old('firm_type') == 1 ? 'selected' : '' }}>Government</option>
									<option value="2" {{ old('firm_type') == 2 ? 'selected' : '' }}>Private</option>
									<option value="3" {{ old('firm_type') == 3 ? 'selected' : '' }}>Individual</option>
									<option value="4" {{ old('firm_type') == 4 ? 'selected' : '' }}>Quasi Government</option>
									<option value="5" {{ old('firm_type') == 5 ? 'selected' : '' }}>Research Organisation</option>
									<option value="6" {{ old('firm_type') == 6 ? 'selected' : '' }}>State Government</option>
									<option value="7" {{ old('firm_type') == 7 ? 'selected' : '' }}>Central Government</option>
								</select>
								<div id="firm_type_error"></div>
								@error('firm_type')
									<p style="color: red">{{ $message }}</p>
								@enderror
							</div>
						</div>
						<!-- <div class="col-sm-6 col-md-6">
							<div class="form-group">
								<label class="form-label" for="firm_type">Type of Firm <span class="text-red">*</span></label>
								<select id="menu-type" class="form-control select2" name="firm_type">
									<option value="">Select</option>
									<option value="1" {{ old('firm_type') == 1 ? 'selected' : '' }}>Government</option>
									<option value="2" {{ old('firm_type') == 2 ? 'selected' : '' }}>Private</option>
									<option value="3" {{ old('firm_type') == 3 ? 'selected' : '' }}>Individual</option>
									<option value="4" {{ old('firm_type') == 4 ? 'selected' : '' }}>Quasi Government</option>
									<option value="5" {{ old('firm_type') == 5 ? 'selected' : '' }}>Research Organisation</option>
									<option value="6" {{ old('firm_type') == 6 ? 'selected' : '' }}>State Government</option>
									<option value="7" {{ old('firm_type') == 7 ? 'selected' : '' }}>Central Government</option>
								</select>
								<div id="firm_type_error"></div>
								@error('firm_type')
									<p style="color: red">{{ $message }}</p>
								@enderror
							</div>
						</div> -->
						<div class="col-sm-6 col-md-6">
							<div class="form-group">
								<label class="form-label" for="email">Email ID <span class="text-red">*</span></label>
								<input type="text" class="form-control" name="email" id="email" placeholder="Email ID" value="{{ old('email') }}" autocomplete="off">
								<div id="email_error"></div>
								@error('email')
									<p style="color: red">{{ $message }}</p>
								@enderror
							</div>
						</div>
						<div class="col-sm-6 col-md-6">
							<div class="form-group">
								<label class="form-label" for="mobile">Mobile Number <span class="text-red">*</span></label>
								<input type="number" class="form-control" name="mobile" id="mobile" placeholder="Mobile Number" value="{{ old('mobile') }}">
								<div id="mobile_error"></div>
								@error('mobile')
									<p style="color: red">{{ $message }}</p>
								@enderror
							</div>
						</div>
						<div class="col-sm-6 col-md-6">
							<div class="form-group">
								<label class="form-label" for="valid_id">Valid Proof <span class="text-red">*</span></label>
								<input type="text" class="form-control" name="valid_id" id="valid_id" placeholder="Valid Proof" value="{{ old('valid_id') }}">
								<div id="valid_id_error"></div>
								@error('valid_id')
									<p style="color: red">{{ $message }}</p>
								@enderror
							</div>
						</div>
						<div class="col-sm-6 col-md-6">
							<div class="form-group">
								<label class="form-label" for="id_file_front">Upload ID Proof * <span class="text-red" style="color: #ff0000;">(format:- .pdf, Maximum size: 10mb)</span></label>
								<input class="form-control" type="file" name="id_file_front" id="id_file_front" placeholder="Choose Valid ID" value="{{ old('id_file_front') }}">
								<div id="id_file_front_error"></div>
								@error('id_file_front')
									<p style="color: red">{{ $message }}</p>
								@enderror
							</div>
						</div>

						<div class="col-sm-6 col-md-6">
							<div class="form-group">
								<label class="form-label" for="id_file_back">Authorisation letter, if any <span class="text-red" style="color: #ff0000;">(format:- .pdf, Maximum size: 10mb) </span></label>
								<input class="form-control" type="file" name="id_file_back" id="id_file_back" placeholder="Choose Valid ID" value="{{ old('id_file_back') }}">
								<div id="id_file_back_error"></div>
								@error('id_file_back')
									<p style="color: red">{{ $message }}</p>
								@enderror
							</div>
						</div>
						<div class="col-sm-6 col-md-6">
							<div class="form-group">
								<label class="form-label" for="password">Password <span class="text-red">*</span></label>
								<input type="text" class="form-control" name="password" id="password" placeholder="Password" value="{{ old('password') }}" onfocus="this.setAttribute('type', 'password')">
								<div id="password_error"></div>
								@error('password')
									<p style="color: red">{{ $message }}</p>
								@enderror
							</div>
						</div>
						<div class="col-sm-6 col-md-6">
							<div class="form-group">
								<label class="form-label" for="password_confirmation">Confirm Password <span class="text-red">*</span></label>
								<input type="text" class="form-control" name="password_confirmation" id="password_confirmation" placeholder="Confirm Password" value="{{ old('password_confirmation') }}" onfocus="this.setAttribute('type', 'password')">
								<div id="password_confirmation_error"></div>
								@error('password_confirmation')
									<p style="color: red">{{ $message }}</p>
								@enderror
							</div>
						</div>
					</div>
				</div>
			</div>
			<!--/div-->

			<div class="btn-list d-flex justify-content-end">
				<button class="btn btn-info" type="submit" value="submit">Save</button>
				<a href="{{url('/admin/customers')}}" class="btn btn-danger">Cancel</a>
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
	$( document ).ready(function()
	{
    	$('input').attr('autocomplete','off');
	});
</script>
@endsection