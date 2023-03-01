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
		<h4 class="page-title mb-0">Edit ETA</h4>
		<ol class="breadcrumb">
			<li class="breadcrumb-item"><a href="#"><i class="fe fe-layout mr-2 fs-14"></i>Dashboard</a></li>
			<li class="breadcrumb-item active" aria-current="page"><a href="#">Edit ETA</a></li>
		</ol>
	</div>
</div>
<!--End Page header-->
@endsection
@section('content')
<!-- Row -->
<div class="row">
	<div class="col-12">
        <form action="{{URL('/admin/update_eta')}}" method="post">
            @csrf
            <input type="hidden" value="{{$survey_id}}" id="id" name="survey_id">
            <input type="hidden" value="{{$fieldstudy_eta->id}}" id="id" name="eta_id">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-6 col-md-6">
                            <div class="form-group">
                                <label class="form-label">General Area <span class="text-red">*</span></label>
                                <select class="form-control custom-select select2" name="general_area" id="general_area">
                                    <option value="">--Select--</option>
                                    @if($cities && count($cities)>0)
                                        @foreach($cities as $city)
                                            <option name="general_area" id="general_area" value="{{$city->id}}" {{ $fieldstudy_eta->general_area == $city->id ? 'selected' : '' }}>{{$city->city_name}}</option>        
                                        @endforeach 
                                    @endif
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
                                <input type="text" class="form-control" placeholder="Location" name="location" id="location" value="{{ $fieldstudy_eta->location }}">
                                <div id="location_error"></div>
								@error('location')
									<p style="color: red">{{ $message }}</p>
								@enderror
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-6">
                            <div class="form-group">
                                <label class="form-label">Scale of Survey Recommended <span class="text-red">*</span></label>
                                <input type="text" class="form-control" placeholder="Scale of Survey Recommended" name="scale_of_survey_recomended" id="scale_of_survey_recomended" value="{{ $fieldstudy_eta->scale_of_survey_recomended }}">
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
                                    @if($survey_type && count($survey_type)>0)
                                        @foreach($survey_type as $type)
                                            <option name="type_of_survey" id="type_of_survey" value="{{$type->id}}" {{ $fieldstudy_eta->type_of_survey == $type->id ? 'selected' : '' }}>{{$type->type}}</option>        
                                        @endforeach 
                                    @endif
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
                                <input type="text" class="form-control" placeholder="Number Of Days Required" name="no_of_days_required" id="no_of_days_required" value="{{ $fieldstudy_eta->no_of_days_required }}">
                                <div id="no_of_days_required_error"></div>
								@error('no_of_days_required')
									<p style="color: red">{{ $message }}</p>
								@enderror
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-6">
                            <div class="form-group">
                                <label class="form-label">Charges <span class="text-red">*</span></label>
                                <input type="text" class="form-control" placeholder="Charges" name="charges" id="charges" value="{{ $fieldstudy_eta->charges }}">
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
                                            <option value="{{$recipient['id']}}" {{ $fieldstudy_eta->recipient == $recipient['id'] ? 'selected' : '' }}>{{$recipient['fname']}}</option>
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
                    <div class="row">
                        <div class="col-sm-12 col-md-12">
                            <div class="form-group">
                                <label class="form-label" for="remarks">Remarks</label>
                                <textarea class="form-control" name="remarks" id="remarks" rows="3" placeholder="Type Here..."></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary" type="submit">Send</button>
                <a href="{{url('/admin/requested_service_detail')}}/{{$survey_id}}/67" class="btn btn-danger">Cancel</a>
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