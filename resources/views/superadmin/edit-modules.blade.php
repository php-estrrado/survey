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
		<h4 class="page-title mb-0">Modules</h4>
		<ol class="breadcrumb">
			<li class="breadcrumb-item"><a href="#"><i class="fe fe-layout mr-2 fs-14"></i>Modules Management</a></li>
			<li class="breadcrumb-item active" aria-current="page"><a href="#">Modules</a></li>
		</ol>
	</div>
</div>
<!--End Page header-->
@endsection
@section('content')
<!-- Row -->
<div class="row">
	<div class="col-12">
        <form method="POST" id="saveModule" action="{{ url('/superadmin/modules/save') }}" class="theme-form">
            @csrf
            {{Form::hidden('id',$module_details['id'],['id'=>'moduleid'])}}
			{{Form::hidden('parent',$module_details['parent'],['id'=>'parent'])}}
            <!--div-->
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-6 col-md-6">
                            <div class="form-group">
                                <label class="form-label" for="module_name">Modules <span class="text-red">*</span></label>
                                <input type="text" class="form-control" name="module_name" id="module_name" value="{{$module_details['module_name']}}" placeholder="Module name">
                                <div id="module_name_error"></div>
								@error('module_name')
									<p style="color: red">{{ $message }}</p>
								@enderror
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-6">
                            <div class="form-group">
                                <label class="form-label" for="class">Class <span class="text-red">*</span></label>
                                <input type="text" class="form-control" name="class" id="class" value="{{$module_details['class']}}" placeholder="Class name">
                                <div id="class_error"></div>
								@error('class')
									<p style="color: red">{{ $message }}</p>
								@enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6 col-md-6">
                            <div class="form-group">
                                <label class="form-label" for="link">Slug <span class="text-red">*</span></label>
                                <input type="text" class="form-control" name="link" id="link" value="{{$module_details['link']}}" placeholder="Slug">
                                <div id="link_error"></div>
								@error('link')
									<p style="color: red">{{ $message }}</p>
								@enderror
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-6">
                            <div class="form-group">
                                <label class="form-label" for="menu_icon">Menu Icon </label>
                                <input type="text" class="form-control" name="menu_icon" id="menu_icon" value="{{$module_details['menu_icon']}}" placeholder="Menu name">
                                <div id="menu_icon_error"></div>
								@error('menu_icon')
									<p style="color: red">{{ $message }}</p>
								@enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6 col-md-6">
                            <div class="form-group">
                                <label class="form-label" for="parent">Parent </label>
                                <select class="form-control select2" name="parent" id="parent">
                                    <option value="0">None</option>
                                    @if($active_modules && count($active_modules) > 0)
                                        @foreach($active_modules as $row)
                                            @php  $pt = $row['parent'];   @endphp
                                            <option value="{{ $pt['id'] }}" @if($module_details['parent'] == $pt['id']){{"selected"}}  @endif>{{ $pt['name'] }}</option>
                                        @endforeach
                                    @endif
                                </select>
                                <div id="parent_error"></div>
								@error('parent')
									<p style="color: red">{{ $message }}</p>
								@enderror
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-6">
                            <div class="form-group">
                                <label class="form-label" for="is_active">Status <span class="text-red">*</span></label>
                                <select class="form-control select2" name="is_active" id="is_active">
                                    <option value='1' @if($module_details['is_active'] == 1){{"selected"}} @endif>Active</option>
                                    <option value='0' @if($module_details['is_active'] == 0){{"selected"}} @endif>Inactive</option>
                                </select>
                                <div id="is_active_error"></div>
								@error('is_active')
									<p style="color: red">{{ $message }}</p>
								@enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="btn-list d-flex justify-content-end">
                <button class="btn btn-info" name="submit" type="submit" value="submit">Save</button>
                <a href="{{url('/superadmin/modules')}}" class="btn btn-danger">Cancel</a>
            </div>
            <!--/div-->
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