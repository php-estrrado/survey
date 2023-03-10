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
        <form action="{{URL('/admin/add_eta')}}" method="post">
            @csrf
            <input type="hidden" value="{{$id}}" id="id" name="id">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-6 col-md-6">
                            <div class="form-group">
                                <label class="form-label">General Area <span class="text-red">*</span></label>
                                <select class="form-control custom-select select2" name="general_area" id="general_area">
                                    <option value="">--Select--</option>
                                    <option value="area1" {{ old('general_area') == 'area1' ? 'selected' : '' }}>Area 1</option>
                                    <option value="area2" {{ old('general_area') == 'area2' ? 'selected' : '' }}>Area 2</option>
                                    <option value="area3" {{ old('general_area') == 'area3' ? 'selected' : '' }}>Area 3</option>
                                    <option value="area4" {{ old('general_area') == 'area4' ? 'selected' : '' }}>Area 4</option>
                                </select>
                                <div id="general_area_error"></div>
								@error('general_area')
									<p style="color: red">{{ $message }}</p>
								@enderror
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-6">
                            <div class="form-group">
                                <label class="form-label">Location <span class="text-red">*</span></label>
                                <input type="text" class="form-control" placeholder="Location" name="location" id="location" value="{{ old('location') }}">
                                <div id="location_error"></div>
								@error('location')
									<p style="color: red">{{ $message }}</p>
								@enderror
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-6">
                            <div class="form-group">
                                <label class="form-label">Scale of Survey Recommended <span class="text-red">*</span></label>
                                <input type="text" class="form-control" placeholder="Scale of Survey Recommended" name="scale_of_survey_recomended" id="scale_of_survey_recomended" value="{{ old('scale_of_survey_recomended') }}">
                                <div id="scale_of_survey_recomended_error"></div>
								@error('scale_of_survey_recomended')
									<p style="color: red">{{ $message }}</p>
								@enderror
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-6">
                            <div class="form-group">
                                <label class="form-label">Type Of Survey <span class="text-red">*</span></label>
                                <select class="form-control custom-select select2" name="type_of_survey" id="type_of_survey">
                                    <option value="">--Select--</option>
                                    <option value="type1" {{ old('type_of_survey') == 'type1' ? 'selected' : '' }}>Type 1</option>
                                    <option value="type2" {{ old('type_of_survey') == 'type2' ? 'selected' : '' }}>Type 2</option>
                                    <option value="type3" {{ old('type_of_survey') == 'type3' ? 'selected' : '' }}>Type 3</option>
                                    <option value="type4" {{ old('type_of_survey') == 'type4' ? 'selected' : '' }}>Type 4</option>
                                </select>
                                <div id="type_of_survey_error"></div>
								@error('type_of_survey')
									<p style="color: red">{{ $message }}</p>
								@enderror
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-6">
                            <div class="form-group">
                                <label class="form-label">Number Of Days Required <span class="text-red">*</span></label>
                                <input type="text" class="form-control" placeholder="Number Of Days Required" name="no_of_days_required" id="no_of_days_required" value="{{ old('no_of_days_required') }}">
                                <div id="no_of_days_required_error"></div>
								@error('no_of_days_required')
									<p style="color: red">{{ $message }}</p>
								@enderror
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-6">
                            <div class="form-group">
                                <label class="form-label">Charges <span class="text-red">*</span></label>
                                <input type="text" class="form-control" placeholder="Charges" name="charges" id="charges" value="{{ old('charges') }}">
                                <div id="charges_error"></div>
								@error('charges')
									<p style="color: red">{{ $message }}</p>
								@enderror
                            </div>
                        </div>
                    </div>
                    <hr>
                    <h4>Send To</h4>
                    <div class="row">
                        <div class="col-sm-6 col-md-6">
                            <div class="form-group">
                                <label class="form-label">Recipient <span class="text-red">*</span></label>
                                <select class="form-control custom-select select2" name="recipient" id="recipient">
                                    <option value="">--Select--</option>
                                    @if($recipients && count($recipients)>0)
                                        @foreach($recipients as $recipient)
                                            <option value="{{$recipient['id']}}" {{ old('recipient') == $recipient['id'] ? 'selected' : '' }}>{{$recipient['fname']}}</option>
                                        @endforeach
                                    @endif
                                </select>
                                <div id="recipient_error"></div>
								@error('recipient')
									<p style="color: red">{{ $message }}</p>
								@enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary" type="submit">Send</button>
                <a href="{{url('/admin/requested_service_detail')}}/{{$id}}/7" class="btn btn-danger">Cancel</a>
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