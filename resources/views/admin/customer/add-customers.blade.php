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
			<li class="breadcrumb-item"><a href="#"><i class="fe fe-layout mr-2 fs-14"></i>Customers</a></li>
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
		<form method="POST" id="customerLogin" action="{{ url('/admin/customers/customerSave') }}" class="theme-form">
			@csrf
			<input type="hidden" name="id" id="id" value="0">
			<!--div-->
			<div class="card">
				<div class="card-body">
					<div class="row">
						<div class="col-sm-6 col-md-6">
							<div class="form-group">
								<label class="form-label" for="full_name">Full Name <span class="text-red">*</span></label>
								<input type="text" class="form-control" name="full_name" id="full_name" placeholder="Full Name">
							</div>
							<div id="full_name"></div>
							@error('full_name')
								<p style="color: red">{{ $message }}</p>
							@enderror
						</div>
						<div class="col-sm-6 col-md-6">
							<div class="form-group">
								<label class="form-label" for="firm">Name Of Firm <span class="text-red">*</span></label>
								<input type="text" class="form-control" name="firm" id="firm" placeholder="Name Of Firm">
							</div>
							<div id="firm"></div>
							@error('firm')
								<p style="color: red">{{ $message }}</p>
							@enderror
						</div>
						<div class="col-sm-6 col-md-6">
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
							<div id="country"></div>
							@error('country')
								<p style="color: red">{{ $message }}</p>
							@enderror
						</div>
						<div class="col-sm-6 col-md-6">
							<div class="form-group">
								<label class="form-label" for="email">Email ID <span class="text-red">*</span></label>
								<input type="text" class="form-control" name="email" id="email" placeholder="Email ID">
							</div>
							<div id="email"></div>
							@error('email')
								<p style="color: red">{{ $message }}</p>
							@enderror
						</div>
						<div class="col-sm-6 col-md-6">
							<div class="form-group">
								<label class="form-label" for="mobile">Mobile Number <span class="text-red">*</span></label>
								<input type="text" class="form-control" name="mobile" id="mobile" placeholder="Mobile Number">
							</div>
							<div id="mobile"></div>
							@error('mobile')
								<p style="color: red">{{ $message }}</p>
							@enderror
						</div>
						<div class="col-sm-6 col-md-6">
							<div class="form-group">
								<label class="form-label" for="valid_id">Valid Proof <span class="text-red">*</span></label>
								<input type="text" class="form-control" name="valid_id" id="valid_id" placeholder="Valid Proof">
							</div>
							<div id="valid_id"></div>
							@error('valid_id')
								<p style="color: red">{{ $message }}</p>
							@enderror
						</div>
						<div class="col-sm-6 col-md-6">
							<div class="form-group">
								<label class="form-label" for="password">Password <span class="text-red">*</span></label>
								<input type="password" class="form-control" name="password" id="password" placeholder="Password">
							</div>
							<div id="password"></div>
							@error('password')
								<p style="color: red">{{ $message }}</p>
							@enderror
						</div>
						<div class="col-sm-6 col-md-6">
							<div class="form-group">
								<label class="form-label" for="password_confirmation">Confirm Password <span class="text-red">*</span></label>
								<input type="password" class="form-control" name="password_confirmation" id="password_confirmation" placeholder="Confirm Password">
							</div>
							<div id="password_confirmation"></div>
							@error('password_confirmation')
								<p style="color: red">{{ $message }}</p>
							@enderror
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
@endsection