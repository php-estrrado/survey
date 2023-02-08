@extends('layouts.master')
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
		<h4 class="page-title mb-0">Employees</h4>
		<ol class="breadcrumb">
			<li class="breadcrumb-item"><a href="#"><i class="fe fe-layout mr-2 fs-14"></i>Institution</a></li>
			<li class="breadcrumb-item active" aria-current="page"><a href="#">Employees</a></li>
		</ol>
	</div>
</div>
<!--End Page header-->
@endsection
@section('content')
<!-- Row -->
<div class="row flex-lg-nowrap">
	<div class="col-12">
		<div class="row flex-lg-nowrap">
			<div class="col-12 mb-3">
				<div class="e-panel card">
					<div class="card-body pb-2">
						<div class="row">
							<div class="col-6 mb-4">
								<div class="btn-group mt-2 mb-2">
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
										All Employees <span class="caret"></span>
									</button>
									<ul class="dropdown-menu" role="menu">
										<li><a href="#">Action</a></li>
										<li><a href="#">Another action</a></li>
										<li><a href="#">Something else here</a></li>
									</ul>
								</div>
							</div>
							<div class="col-6 col-auto">
								<div class="form-group">
									<div class="input-icon">
										<span class="input-icon-addon">
											<i class="fe fe-search"></i>
										</span>
										<input type="text" class="form-control" placeholder="Search User">
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-xl-4 col-lg-6">
								<div class="card border p-0 shadow-none">
									<div class="d-flex align-items-center p-4">
										<div class="avatar avatar-lg brround d-block cover-image" data-image-src="{{URL::asset('assets/images/users/7.jpg')}}">
										</div>
										<div class="wrapper ml-3">
											<p class="mb-0 mt-1 text-dark font-weight-semibold">Denis Rosenblum</p>
											<small class="text-muted">Project Manager</small>
										</div>
									</div>
									<div class="card-body border-top">
										<ul class="mb-0 user-details">
											<li class="mb-3"><span class="user-icon"><i class="fe fe-mail "></i></span><span class="h6">denisrosenblum@gmail.com</span></li>
											<li><span class="user-icon"><i class="fe fe-phone-call"></i></span><span class="h6">+345 657 567</span></li>
										</ul>
									</div>
								</div>
							</div>
							<div class="col-xl-4 col-lg-6">
								<div class="card border p-0 shadow-none">
									<div class="d-flex align-items-center p-4">
										<div class="avatar avatar-lg brround d-block cover-image" data-image-src="{{URL::asset('assets/images/users/6.jpg')}}">
										</div>
										<div class="wrapper ml-3">
											<p class="mb-0 mt-1 text-dark font-weight-semibold">Harvey Mattos</p>
											<small class="text-muted">Develpoer</small>
										</div>
									</div>
									<div class="card-body border-top">
										<ul class="mb-0 user-details">
											<li class="mb-3"><span class="user-icon"><i class="fe fe-mail "></i></span><span class="h6">harveymattos@gmail.com</span></li>
											<li><span class="user-icon"><i class="fe fe-phone-call"></i></span><span class="h6">+345 657 567</span></li>
										</ul>
									</div>
								</div>
							</div>
							<div class="col-xl-4 col-lg-6">
								<div class="card border p-0 shadow-none">
									<div class="d-flex align-items-center p-4">
										<div class="avatar avatar-lg brround d-block cover-image" data-image-src="{{URL::asset('assets/images/users/5.jpg')}}">
										</div>
										<div class="wrapper ml-3">
											<p class="mb-0 mt-1 text-dark font-weight-semibold">Catrice Doshier</p>
											<small class="text-muted">Assistant Manager</small>
										</div>
									</div>
									<div class="card-body border-top">
										<ul class="mb-0 user-details">
											<li class="mb-3"><span class="user-icon"><i class="fe fe-mail "></i></span><span class="h6">catricedoshier@gmail.com</span></li>
											<li><span class="user-icon"><i class="fe fe-phone-call"></i></span><span class="h6">+345 657 567</span></li>
										</ul>
									</div>
								</div>
							</div>
							<div class="col-xl-4 col-lg-6">
								<div class="card border p-0 shadow-none">
									<div class="d-flex align-items-center p-4">
										<div class="avatar avatar-lg brround d-block cover-image" data-image-src="{{URL::asset('assets/images/users/1.jpg')}}">
										</div>
										<div class="wrapper ml-3">
											<p class="mb-0 mt-1 text-dark font-weight-semibold">Catherina Bamber</p>
											<small class="text-muted">Company Manager</small>
										</div>
									</div>
									<div class="card-body border-top">
										<ul class="mb-0 user-details">
											<li class="mb-3"><span class="user-icon"><i class="fe fe-mail "></i></span><span class="h6">catherinabamber@gmail.com</span></li>
											<li><span class="user-icon"><i class="fe fe-phone-call"></i></span><span class="h6">+345 657 567</span></li>
										</ul>
									</div>
								</div>
							</div>
							<div class="col-xl-4 col-lg-6">
								<div class="card border p-0 shadow-none">
									<div class="d-flex align-items-center p-4">
										<div class="avatar avatar-lg brround d-block cover-image" data-image-src="{{URL::asset('assets/images/users/8.jpg')}}">
										</div>
										<div class="wrapper ml-3">
											<p class="mb-0 mt-1 text-dark font-weight-semibold">Margie Fitts</p>
											<small class="text-muted">It Manager</small>
										</div>
									</div>
									<div class="card-body border-top">
										<ul class="mb-0 user-details">
											<li class="mb-3"><span class="user-icon"><i class="fe fe-mail "></i></span><span class="h6">margiefitts@gmail.com</span></li>
											<li><span class="user-icon"><i class="fe fe-phone-call"></i></span><span class="h6">+345 657 567</span></li>
										</ul>
									</div>
								</div>
							</div>
							<div class="col-xl-4 col-lg-6">
								<div class="card border p-0 shadow-none">
									<div class="d-flex align-items-center p-4">
										<div class="avatar avatar-lg brround d-block cover-image" data-image-src="{{URL::asset('assets/images/users/5.jpg')}}">
										</div>
										<div class="wrapper ml-3">
											<p class="mb-0 mt-1 text-dark font-weight-semibold">Dana Lott</p>
											<small class="text-muted">Hr Manager</small>
										</div>
									</div>
									<div class="card-body border-top">
										<ul class="mb-0 user-details">
											<li class="mb-3"><span class="user-icon"><i class="fe fe-mail "></i></span><span class="h6">danalott@gmail.com</span></li>
											<li><span class="user-icon"><i class="fe fe-phone-call"></i></span><span class="h6">+345 657 567</span></li>
										</ul>
									</div>
								</div>
							</div>
							<div class="col-xl-4 col-lg-6">
								<div class="card border p-0 shadow-none">
									<div class="d-flex align-items-center p-4">
										<div class="avatar avatar-lg brround d-block cover-image" data-image-src="{{URL::asset('assets/images/users/6.jpg')}}">
										</div>
										<div class="wrapper ml-3">
											<p class="mb-0 mt-1 text-dark font-weight-semibold">Benedict Vallone</p>
											<small class="text-muted">Hr Recriuter</small>
										</div>
									</div>
									<div class="card-body border-top">
										<ul class="mb-0 user-details">
											<li class="mb-3"><span class="user-icon"><i class="fe fe-mail "></i></span><span class="h6">benedictballone@gmail.com</span></li>
											<li><span class="user-icon"><i class="fe fe-phone-call"></i></span><span class="h6">+345 657 567</span></li>
										</ul>
									</div>
								</div>
							</div>
							<div class="col-xl-4 col-lg-6">
								<div class="card border p-0 shadow-none">
									<div class="d-flex align-items-center p-4">
										<div class="avatar avatar-lg brround d-block cover-image" data-image-src="{{URL::asset('assets/images/users/8.jpg')}}">
										</div>
										<div class="wrapper ml-3">
											<p class="mb-0 mt-1 text-dark font-weight-semibold">Robbie Ruder</p>
											<small class="text-muted">Ceo</small>
										</div>
									</div>
									<div class="card-body border-top">
										<ul class="mb-0 user-details">
											<li class="mb-3"><span class="user-icon"><i class="fe fe-mail "></i></span><span class="h6">robbieruder@gmail.com</span></li>
											<li><span class="user-icon"><i class="fe fe-phone-call"></i></span><span class="h6">+345 657 567</span></li>
										</ul>
									</div>
								</div>
							</div>
							<div class="col-xl-4 col-lg-6">
								<div class="card border p-0 shadow-none">
									<div class="d-flex align-items-center p-4">
										<div class="avatar avatar-lg brround d-block cover-image" data-image-src="{{URL::asset('assets/images/users/3.jpg')}}">
										</div>
										<div class="wrapper ml-3">
											<p class="mb-0 mt-1 text-dark font-weight-semibold">Micaela Aultman</p>
											<small class="text-muted">Php developer</small>
										</div>
									</div>
									<div class="card-body border-top">
										<ul class="mb-0 user-details">
											<li class="mb-3"><span class="user-icon"><i class="fe fe-mail "></i></span><span class="h6">micaelaaultman@gmail.com</span></li>
											<li><span class="user-icon"><i class="fe fe-phone-call"></i></span><span class="h6">+345 657 567</span></li>
										</ul>
									</div>
								</div>
							</div>
							<div class="col-xl-4 col-lg-6">
								<div class="card border p-0 shadow-none">
									<div class="d-flex align-items-center p-4">
										<div class="avatar avatar-lg brround d-block cover-image" data-image-src="{{URL::asset('assets/images/users/4.jpg')}}">
										</div>
										<div class="wrapper ml-3">
											<p class="mb-0 mt-1 text-dark font-weight-semibold">Jacquelynn Sapienza</p>
											<small class="text-muted">Web developer</small>
										</div>
									</div>
									<div class="card-body border-top">
										<ul class="mb-0 user-details">
											<li class="mb-3"><span class="user-icon"><i class="fe fe-mail "></i></span><span class="h6">jacquelynnsapienza@gmail.com</span></li>
											<li><span class="user-icon"><i class="fe fe-phone-call"></i></span><span class="h6">+345 657 567</span></li>
										</ul>
									</div>
								</div>
							</div>
							<div class="col-xl-4 col-lg-6">
								<div class="card border p-0 shadow-none">
									<div class="d-flex align-items-center p-4">
										<div class="avatar avatar-lg brround d-block cover-image" data-image-src="{{URL::asset('assets/images/users/9.jpg')}}">
										</div>
										<div class="wrapper ml-3">
											<p class="mb-0 mt-1 text-dark font-weight-semibold">Elida Distefano</p>
											<small class="text-muted">Hr Manager</small>
										</div>
									</div>
									<div class="card-body border-top">
										<ul class="mb-0 user-details">
											<li class="mb-3"><span class="user-icon"><i class="fe fe-mail "></i></span><span class="h6">elidadistefano@gmail.com</span></li>
											<li><span class="user-icon"><i class="fe fe-phone-call"></i></span><span class="h6">+345 657 567</span></li>
										</ul>
									</div>
								</div>
							</div>
							<div class="col-xl-4 col-lg-6">
								<div class="card border p-0 shadow-none">
									<div class="d-flex align-items-center p-4">
										<div class="avatar avatar-lg brround d-block cover-image" data-image-src="{{URL::asset('assets/images/users/7.jpg')}}">
										</div>
										<div class="wrapper ml-3">
											<p class="mb-0 mt-1 text-dark font-weight-semibold">Collin Bridgman</p>
											<small class="text-muted">web designer</small>
										</div>

									</div>
									<div class="card-body border-top">
										<ul class="mb-0 user-details">
											<li class="mb-3"><span class="user-icon"><i class="fe fe-mail "></i></span><span class="h6">collinbridgman@gmail.com</span></li>
											<li><span class="user-icon"><i class="fe fe-phone-call"></i></span><span class="h6">+345 657 567</span></li>
										</ul>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
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