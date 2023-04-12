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
		<h4 class="page-title mb-0">Repository Management</h4>
		<ol class="breadcrumb">
			<li class="breadcrumb-item"><a href="#"><i class="fe fe-layout mr-2 fs-14"></i>Dashboard</a></li>
			<li class="breadcrumb-item active" aria-current="page"><a href="#">Repository Management</a></li>
		</ol>
	</div>
</div>
<!--End Page header-->
@endsection
@section('content')
<!-- Row -->
<div class="row">
	<div class="col-12">
		{{ Form::open(array('url' => "/admin/repository-management/save", 'id' => 'adminForm', 'name' => 'adminForm', 'class' => '','files'=>'true')) }}
			@csrf
			{{Form::hidden('id',0,['id'=>'id'])}}
			<!--div-->
			<div class="card">
				<div class="card-body">
					<div class="row">
						<div class="col-sm-6 col-md-6">
							<div class="form-group">
								<label class="form-label" for="date_of_survey">Date of Survey <span class="text-red">*</span></label>
								<input type="date" class="form-control" name="date_of_survey" max="{{ date('Y-m-d') }}" id="date_of_survey" value="{{ old('date_of_survey') }}"  placeholder="Date">
							</div>
							@error('date_of_survey')
							<p style="color: red">{{ $message }}</p>
							@enderror
						</div>
						<div class="col-sm-6 col-md-6">
							<div class="form-group">
								<label class="form-label" for="first_name">Customer Name <span class="text-red">*</span></label>
								<input type="text" class="form-control" name="first_name" id="first_name" value="{{ old('first_name') }}" placeholder="Customer Name">
							</div>
							@error('first_name')
							<p style="color: red">{{ $message }}</p>
							@enderror
						</div>
						<div class="col-sm-6 col-md-6">
							<div class="form-group">
								<label class="form-label" for="department_name">Department Name <span class="text-red">*</span></label>
								<input type="text" class="form-control" name="department_name" id="department_name" value="{{ old('department_name') }}" placeholder="Department Name">
							</div>
							@error('department_name')
							<p style="color: red">{{ $message }}</p>
							@enderror
						</div>
						<div class="col-sm-6 col-md-6">
							<div class="form-group">
								<label class="form-label" for="file_number">File Number <span class="text-red">*</span></label>
								<input type="text" class="form-control" name="file_number" id="file_number" value="{{ old('file_number') }}" placeholder="File Number">
							</div>
							@error('file_number')
							<p style="color: red">{{ $message }}</p>
							@enderror
						</div>
						<div class="col-sm-6 col-md-6">
							<div class="form-group">
								<label class="form-label" for="service_id">Type of Survey <span class="text-red">*</span></label>
								<select name="service_id" id="service_id" class="form-control">
									<option value="">Select</option>
									@if(count($services) > 0)
										@foreach($services as $service)
											<option value="{{$service->id}}" {{ (collect(old('service_id'))->contains($service->id)) ? 'selected':'' }}>{{$service->service_name}}</option>
										@endforeach
									@endif
								</select>
							</div>
							@error('service_id')
							<p style="color: red">{{ $message }}</p>
							@enderror
						</div>
						<div class="col-sm-6 col-md-6">
							<div class="form-group">
								<label class="form-label" for="district">District <span class="text-red">*</span></label>
								<select name="district" id="district" class="form-control">
									<option value="">Select</option>
									@if(count($services) > 0)
										@foreach($cities as $city)
											<option value="{{$city->id}}" {{ (collect(old('district'))->contains($city->id)) ? 'selected':'' }}>{{$city->city_name}}</option>
										@endforeach
									@endif
								</select>
							</div>
							@error('district')
							<p style="color: red">{{ $message }}</p>
							@enderror
						</div>
						<div class="col-md-12">
							<div class="form-group">
								<label class="form-label" for="final_report">Final Report <span class="text-red">*</span></label>
								<input type="file" class="dropify" data-max-file-size="100M" data-height="180" name="final_report" id="final_report" data-allowed-file-extensions='["pdf"]' multiple/>
								@error('final_report')
									<p style="color: red">{{ $message }}</p>
								@enderror
							</div>
						</div>
					</div>
				</div>
			</div>
			<!--/div-->

			<div class="btn-list d-flex justify-content-end">
				<button class="btn btn-info" type="submit" name="submit">Save</button>
				<a href="{{url('/admin/repository-management')}}" class="btn btn-danger">Cancel</a>
			</div>
		{{Form::close()}}
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
	if (window.File && window.FileList && window.FileReader)
	{
    	$("#avatar").on("change", function(e) {
        	$(".pip1").remove();
      		var files = e.target.files,
        	filesLength = files.length;
      		for (var i = 0; i < filesLength; i++)
			{
        		var f = files[i]
        		var fileReader = new FileReader();
        		fileReader.onload = (function(e) {
          			var file = e.target;
          			// $("<span class=\"pip1\">" +
          			//   "<input type=\"file\" id=\"havefil\" hidden name=\"havefil[]\" value=\"" + e.target.result + "\"/>"+
          			//   "<img class=\"imageThumb1\" src=\"" + e.target.result + "\" title=\"" + file.name + "\"/>" +
          			//   "<br/>" +
					//   "</span>").insertAfter("#avatar");
          			// $(".remove").click(function(){
          			//   $(this).parent(".pip").remove();
          			// });

          			$("#avatar_img").attr("src",e.target.result);

          			// <span class=\"remove\">Remove image</span>Old code here
          			/*$("<img></img>", {
            			class: "imageThumb",
            			src: e.target.result,
            			title: file.name + " | Click to remove"
          			}).insertAfter("#avatar").click(function(){$(this).remove();});*/
        		});
        		fileReader.readAsDataURL(f);
      		}
    	});
  	}
	else
	{
    	alert("Your browser doesn't support to File API")
  	}
</script>
@endsection