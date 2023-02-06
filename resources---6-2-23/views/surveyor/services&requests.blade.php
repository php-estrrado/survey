@extends('layouts.master-surveyor')
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
		<h4 class="page-title mb-0">Services And Requests</h4>
		<!-- <ol class="breadcrumb">
			<li class="breadcrumb-item"><a href="#"><i class="fe fe-layout mr-2 fs-14"></i>Service And Requests</a></li>
			<li class="breadcrumb-item active" aria-current="page"><a href="#">Requested Services</a></li>
		</ol> -->
	</div>
	<!-- <div class="page-rightheader">
		<div class="btn btn-list">
			<a href="#" class="btn btn-info"><i class="fe fe-plus mr-1"></i> Add </a>
		</div>
	</div> -->
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
				<div class="card-title fifty">Services And Request Table</div>
				<div class="card-title fifty">
					<div class="panel panel-default block">
						<div class="panel-body p-0" style="float:right;">
							<!-- <div class="btn-group mt-2 mb-2">
								<button type="button" class="btn btn-light dropdown-toggle" data-toggle="dropdown">
									All Sub Offices <span class="caret"></span>
								</button>
								<ul class="dropdown-menu" role="menu">
									<li><a href="#">Action</a></li>
									<li><a href="#">Another action</a></li>
									<li><a href="#">Something else here</a></li>
								</ul>
							</div>
							<div class="btn-group mt-2 mb-2">
								<button type="button" class="btn btn-light dropdown-toggle" data-toggle="dropdown">
									This Month <span class="caret"></span>
								</button>
								<ul class="dropdown-menu" role="menu">
									<li><a href="#">Action</a></li>
									<li><a href="#">Another action</a></li>
									<li><a href="#">Something else here</a></li>
								</ul>
							</div> -->
						</div>
					</div>

				</div>
			</div>
			<div class="card-body">
				<div class="table-responsive">
					<table class="table table-bordered text-nowrap" id="example2">
						<thead>
							<tr>
								<th class="wd-15p border-bottom-0">SL. NO</th>
								<th class="wd-15p border-bottom-0">Date</th>
								<th class="wd-15p border-bottom-0">Name</th>
								<th class="wd-15p border-bottom-0">File Number</th>
								<!-- <th class="wd-15p border-bottom-0">Sub Office</th> -->
								<th class="wd-15p border-bottom-0">Email ID</th>
								<th class="wd-10p border-bottom-0">Requested Service</th>
								<th class="wd-20p border-bottom-0">Status</th>
							</tr>
						</thead>
						<tbody>

							<tr>
								<td>1</td>
								<td>12/11/2022</td>
								<td>John</td>
								<td><a href="{{ url('/surveyor/pending')}}" style="color:#2b8fca; font-weight:bold;">ADF1234</a></td>
								<!-- <td>Kollam</td> -->
								<td>xyz@gmail.com</td>
								<td>Hydrographic Chart</td>
								<td>Pending</td>
							</tr>
							<tr>
								<td>2</td>
								<td>12/11/2022</td>
								<td>John</td>
								<td><a href="{{ url('/surveyor/invoice-submitted-by-draftman')}}" style="color:#2b8fca; font-weight:bold;">ADF1234</a></td>
								<!-- <td>Kollam</td> -->
								<td>xyz@gmail.com</td>
								<td>Hydrographic Chart</td>
								<td>Invoice submitted by draftman (name)</td>
							</tr>
							<tr>
								<td>3</td>
								<td>12/11/2022</td>
								<td>John</td>
								<td><a href="{{ url('/surveyor/completed')}}" style="color:#2b8fca; font-weight:bold;">ADF1234</a></td>
								<!-- <td>Kollam</td> -->
								<td>xyz@gmail.com</td>
								<td>Hydrographic Chart</td>
								<td>Completed</td>
							</tr>
							<tr>
								<td>4</td>
								<td>12/11/2022</td>
								<td>John</td>
								<td><a href="{{ url('/surveyor/pending')}}" style="color:#2b8fca; font-weight:bold;">ADF1234</a></td>
								<!-- <td>Kollam</td> -->
								<td>xyz@gmail.com</td>
								<td>Hydrographic Chart</td>
								<td>Pending</td>
							</tr>
							<tr>
								<td>5</td>
								<td>12/11/2022</td>
								<td>John</td>
								<td><a href="{{ url('/surveyor/completed')}}" style="color:#2b8fca; font-weight:bold;">ADF1234</a></td>
								<!-- <td>Kollam</td> -->
								<td>xyz@gmail.com</td>
								<td>Hydrographic Chart</td>
								<td>Completed</td>
							</tr>
							<tr>
								<td>6</td>
								<td>12/11/2022</td>
								<td>John</td>
								<td><a href="{{ url('/surveyor/pending')}}" style="color:#2b8fca; font-weight:bold;">ADF1234</a></td>
								<!-- <td>Kollam</td> -->
								<td>xyz@gmail.com</td>
								<td>Hydrographic Chart</td>
								<td>Pending</td>
							</tr>
							<tr>
								<td>7</td>
								<td>12/11/2022</td>
								<td>John</td>
								<td><a href="{{ url('/surveyor/completed')}}" style="color:#2b8fca; font-weight:bold;">ADF1234</a></td>
								<!-- <td>Kollam</td> -->
								<td>xyz@gmail.com</td>
								<td>Hydrographic Chart</td>
								<td>Completed</td>
							</tr>

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