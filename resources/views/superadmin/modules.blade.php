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
	<div class="page-rightheader">
		<div class="btn btn-list">
			<a href="{{ url('/superadmin/modules/create')}}" class="btn btn-info"><i class="fe fe-plus mr-1"></i> Add </a>
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
				<div class="card-title">Modules List</div>
			</div>
			<div class="card-body">
				<div class="table-responsive">
					<table class="table table-bordered text-nowrap modulestable" id="modulestable">
						<thead>
							<tr>
								<th class="wd-15p border-bottom-0">SL. NO</th>
								<th class="wd-15p border-bottom-0">Modules</th>
								<th class="wd-20p border-bottom-0">Link</th>
								<th class="wd-15p border-bottom-0">Status</th>
								<th class="wd-10p border-bottom-0">Actions</th>
							</tr>
						</thead>
						<tbody>
							@if($modules && count($modules) > 0)
                                @php $i=1; @endphp
                                @foreach($modules as $row)
                                    @php  $pt = $row['parent'];  $child = $row['child']; @endphp
                                    <tr>
                                        <td>{{$i}}</td>
                                        <td class="align-middle" id="module_name" data-value="{{$pt['module_name']}}">
                                            <div class="d-flex">
                                                <h6 class=" font-weight-bold"><a class="viewmodule" data-toggle="modal" data-target="#view-module" style="cursor: pointer;">{{$pt['module_name']}}</a></h6>
                                            </div>
                                        </td>
                                        <td class="text-nowrap align-middle" id="module_link" data-value="{{$pt['link']}}">
                                            <p>{{$pt['link']}}</p>
                                        </td>
                                        <td>
                                            <div class="form-group mb-0">
                                                <label class="custom-switch">
                                                    <input type="checkbox" name="custom-switch-checkbox" class="custom-switch-input" @if($pt['is_active'] ==1) {{ "checked" }} @endif>
                                                    <span class="custom-switch-indicator"></span>
                                                </label>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="btn-list actn">                                                
                                                <a href="{{url('/superadmin/modules/edit')}}/{{ $pt['id'] }}"><button class="btn btn-success" type="button">Edit</button></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                <a href=""><button class="btn btn-danger" type="button" onclick="return confirm('Are you sure you want to delete this role?')?deletemodule({{$pt['id']}}):'';">Delete</button></a>
                                            </div>
                                        </td>
                                    </tr>

                                    @if($child && count($child) > 0) 
                                        @php $nrow = 'odd'; @endphp
                                        @foreach($child as $ch) 
                                            <tr>
                                                <td class="align-middle select-checkbox" id="moduleid" data-value="{{$ch['id']}}" data-parent="{{$ch['parent']}}">
                                                    <label class="custom-control custom-checkbox">
                                                        <!--{{$ch['parent'].".".$loop->iteration }} -->
                                                    </label>
                                                </td>
                                                <td class="align-middle" id="module_name" data-value="{{$ch['module_name']}}">
                                                    <div class="d-flex">
                                                        <h6 class=" font-weight-normal viewmodule" class="" data-toggle="modal" data-target="#view-module" style="cursor: pointer;" >{{ $loop->iteration.". " }}{{$ch['module_name']}}</h6>
                                                    </div>
                                                </td>
                                                <td class="text-nowrap align-middle" id="module_link" data-value="{{$ch['link']}}">
                                                    <p>{{$ch['link']}}</p>
                                                </td>
                                                <td>
                                                    <div class="form-group mb-0">
                                                        <label class="custom-switch">
                                                            <input type="checkbox" name="custom-switch-checkbox" class="custom-switch-input" @if($ch['is_active'] ==1) {{ "checked" }} @endif>
                                                            <span class="custom-switch-indicator"></span>
                                                        </label>
                                                    </div>
                                                </td>
                                                <td class="align-middle">
                                                    <div class="btn-list actn">
                                                        <a href="{{url('/superadmin/modules/edit')}}/{{ $ch['id'] }}"><button class="btn btn-success" type="button">Edit</button></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                        <a href=""><button class="btn btn-danger" type="button" onclick="return confirm('Are you sure you want to delete this role?')?deletemodule({{$ch['id']}}):'';">Delete</button></a>
                                                    </div>
                                                </td>
                                            </tr>
                                            @php if($nrow == 'odd'){ $nrow = 'even'; }else{ $nrow = 'odd'; } @endphp
                                        @endforeach 
                                    @else
                                        <div class="row"><div class="col-12 br-line-wh"></div></div>
                                    @endif
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
    function deletemodule(id){
        console.log(id);
        $.ajax({
            type: "POST",
            url: '{{url("/superadmin/modules/delete")}}',
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