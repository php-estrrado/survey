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
		<h4 class="page-title mb-0">Users</h4>
		<ol class="breadcrumb">
			<li class="breadcrumb-item"><a href="#"><i class="fe fe-layout mr-2 fs-14"></i>User Role Management</a></li>
			<li class="breadcrumb-item active" aria-current="page"><a href="#">Users</a></li>
		</ol>
	</div>
</div>
<!--End Page header-->
@endsection
@section('content')
<!-- Row -->
<div class="row">
	<div class="col-12">
		{{ Form::open(array('url' => "/superadmin/admins-list/save", 'id' => 'adminForm', 'name' => 'adminForm', 'class' => '','files'=>'true')) }}
			@csrf
			{{Form::hidden('id',$admin['id'],['id'=>'id'])}}
			<!--div-->
			<div class="card">
				<div class="card-body">
					<div class="row">
						<div class="col-lg-12 mb-3">
							<div class="box-widget widget-user">
								<div class="widget-user-image1 d-sm-flex">
									<img alt="User Avatar" class="rounded-circle border p-0" src="https://laravel.spruko.com/admitro/Vertical-IconSidedar-Light/assets/images/users/2.jpg">
								</div>
							</div>
						</div>
						<div class="col-sm-6 col-md-6">
							<div class="form-group">
								<label class="form-label" for="name">Full Name <span class="text-red">*</span></label>
								<input type="text" class="form-control" name="name" id="name" value="{{$users['fullname']}}" placeholder="Full Name">
							</div>
						</div>
						<div class="col-sm-6 col-md-6">
							<div class="form-group">
								<label class="form-label" for="phone">Phone Number <span class="text-red">*</span></label>
								<input type="text" class="form-control" name="phone" id="phone" value="{{$users['phone']}}" placeholder="Phone Number">
							</div>
						</div>
						<div class="col-sm-6 col-md-6">
							<div class="form-group">
								<label class="form-label" for="email">Email ID <span class="text-red">*</span></label>
								<input type="text" class="form-control" name="email" id="email" value="{{$users['email']}}" placeholder="Email ID">
							</div>
						</div>
						<div class="col-sm-6 col-md-6">
							<div class="form-group">
								<label class="form-label" for="designation">Designation <span class="text-red">*</span></label>
								<input type="text" class="form-control" name="designation" id="designation" value="{{$users['designation']}}" placeholder="Designation">
							</div>
						</div>
						<div class="col-sm-6 col-md-6">
							<div class="form-group">
								<label class="form-label" for="role_id">Choose Role <span class="text-red">*</span></label>
								<select class="form-control select2" name="role_id" id="role_id"> 
									@if($roles && count($roles) > 0)
										@foreach($roles as $role)
											<option value="{{$role['id']}}" @if($role['id'] == $users['role']){{"selected"}} @endif>{{$role['usr_role_name']}}</option>
										@endforeach
									@endif
								</select>
							</div>
						</div>
						<div class="col-sm-6 col-md-6">
							<div class="form-group">
								<label class="form-label" for="pen">PEN Number <span class="text-red">*</span></label>
								<input type="text" class="form-control" name="pen" id="pen" placeholder="PEN Number" value="{{$users['pen']}}"">
								<div id="pen_error"></div>
								@error('pen')
									<p style="color: red">{{ $message }}</p>
								@enderror
							</div>
						</div>
						<div class="col-sm-6 col-md-6">
							<div class="form-group">
								<label class="form-label" for="avatar">Profile Pic <span class="text-red">*</span></label>
								<div class="custom-file">
									<input type="file" class="custom-file-input" name="avatar" id="avatar">
									<label class="custom-file-label"></label>
								</div>
							</div>
							<div class="col-md-6 mb-3">
                                @if($admin->avatar !="" ) 
                	                <img id="avatar_img" src="{{ url('storage'.$admin->avatar) }}" alt="avatar" style="height: 120px;" />
                	            @else
                                    <img id="avatar_img" src="{{url('public/admin/assets/images/image2.png')}}" alt="avatar" style="height: 120px;" />
                                @endif
                			</div>
						</div>
						<div class="col-sm-6 col-md-6">
							<div class="form-group">
								<label class="form-label" for="institution">Institution <span class="text-red">*</span></label>
								<select class="form-control select2" name="institution" id="institution"> 
									@if($institutions && count($institutions) > 0)
										@foreach($institutions as $institution)
											<option value="{{$institution['id']}}" @if($institution['id'] == $users['institution']){{"selected"}} @endif>{{$institution['institution_name']}}</option>
										@endforeach
									@endif
								</select>
							</div>
						</div>
						<div class="col-sm-6 col-md-6">
							<div class="form-group">
								<label class="form-label" for="parent_id">User Parent <span class="text-red">*</span></label>
								<select class="form-control select2" name="parent_id" id="parent_id">
									<option value="">None</option>
									<option value="1" @if($users['userparent'] == 1){{"selected"}} @endif>Parent 1</option>
									<option value="2" @if($users['userparent'] == 2){{"selected"}} @endif>Parent 2</option>
									<option value="3" @if($users['userparent'] == 3){{"selected"}} @endif>Parent 3</option>
								</select>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!--/div-->

			<div class="btn-list d-flex justify-content-end">
				<button class="btn btn-info" type="submit" name="submit">Save</button>
				<a href="{{url('/superadmin/admins-list')}}" class="btn btn-danger">Cancel</a>
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