@extends('layouts.admin.master-admin')
@section('css')
<!-- Data table css -->
<link href="{{URL::asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet" />
<link href="{{URL::asset('assets/plugins/datatable/css/buttons.bootstrap4.min.css')}}" rel="stylesheet">
<link href="{{URL::asset('assets/plugins/datatable/responsive.bootstrap4.min.css')}}" rel="stylesheet" />
<!-- Slect2 css -->
<link href="{{URL::asset('assets/plugins/select2/select2.min.css')}}" rel="stylesheet" />
<!-- INTERNAL Gallery css -->
<link href="{{URL::asset('assets/plugins/gallery/gallery.css')}}" rel="stylesheet">

@endsection
@section('page-header')
<!--Page header-->
<div class="page-header">
	<div class="page-leftheader">
		<h4 class="page-title mb-0">Requested Services</h4>
		<ol class="breadcrumb">
			<li class="breadcrumb-item"><a href="#"><i class="fe fe-layout mr-2 fs-14"></i>Services And Requests</a></li>
			<li class="breadcrumb-item active" aria-current="page"><a href="#">Requested Services</a></li>
		</ol>
	</div>
</div>
<!--End Page header-->
@endsection
@section('content')

<!--/app header-->
<div class="main-proifle">
	<div class="row">
		<div class="col-lg-6">
			<div class="box-widget widget-user">
				<div class="widget-user-image1 d-sm-flex">
					<div class="mt-1">
						<h4 class="pro-user-username mb-3 font-weight-bold">File Number</h4>
						<ul class="mb-0 pro-details">
							<li><span class="h6 mt-3">Name: {{$request_data->fname}}</span></li>
							<li><span class="h6 mt-3">Name of the firm: {{$request_data->firm}}</span></li>
							<li><span class="h6 mt-3">Type of firm: {{$request_data->sector}}</span></li>
							<li><span class="h6 mt-3">Email ID: {{$cust_email}}</span></li>
							<li><span class="h6 mt-3">Mobile No.: {{$cust_phone}}</span></li>
							<li><span class="h6 mt-3">Valid ID Proof: {{$cust_info->valid_id}}</span></li>
						</ul>
					</div>
				</div>
			</div>
		</div>
		<div class="col-lg-6 col-md-auto">
			<div class="text-lg-right btn-list mt-4 mt-lg-0">
				<!-- <a href="#" class="modal-effect btn btn-primary" data-effect="effect-scale" data-target="#modaldemo1" data-toggle="modal" href="">Assign</a>
				<a href="#" class="modal-effect btn btn-danger" data-effect="effect-scale" data-target="#modaldemo2" data-toggle="modal" href="">Reject</a> -->
				<br />
			</div>
			<div class="mt-5">
				<div class="main-profile-contact-list row">
					<div class="media col-sm-3">
						<div class="media-icon bg-primary text-white mr-3 mt-1">
							<i class="fa fa-comments fs-18"></i>
						</div>
						<div class="media-body">
							<small class="text-muted">Date</small>
							<div class="font-weight-normal1">
								{{date('d/m/Y',strtotime($request_data->created_at))}}
							</div>
						</div>
					</div>
					<div class="media col-sm-4">
						<div class="media-icon bg-secondary text-white mr-3 mt-1">
							<i class="fa fa-users fs-18"></i>
						</div>
						<div class="media-body">
							<small class="text-muted">Requested Service</small>
							<div class="font-weight-normal1">
								{{$service}}
							</div>
						</div>
					</div>
					<div class="media col-sm-5">
						<div class="media-icon bg-info text-white mr-3 mt-1">
							<i class="fa fa-feed fs-18"></i>
						</div>
						<div class="media-body">
							<small class="text-muted">Status</small>
							<div class="font-weight-normal1">
								{{$survey_status}}
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="profile-cover">
		<div class="wideget-user-tab">
			<div class="tab-menu-heading p-0">
				<div class="tabs-menu1 px-3">
					<ul class="nav">
						<li><a href="#tab-7" class="active fs-14" data-toggle="tab">Basic</a></li>
						<li><a href="#tab-9" data-toggle="tab" class="fs-14">Submitted Form</a></li>
					</ul>
				</div>
			</div>
		</div>
	</div><!-- /.profile-cover -->
</div>


<!-- Row -->
<div class="row">
	<div class="col-xl-12 col-lg-12 col-md-12">
		<div class="border-0">
			<div class="tab-content">
				<div class="tab-pane active" id="tab-7">
					<div class="card newser">
						<div class="card-body">
							<form action="{{url('surveyor/upload_surveystudy')}}" method="POST" id="assign_surveyor" enctype="multipart/form-data">
								@csrf
								<input type="hidden" value="{{$survey_id}}" id="id" name="id">
								<div class="card-title font-weight-bold">Basic info:</div>
								<div class="row">
									<div class="col-md-12">
                                    	<div class="form-group">
                                      		<label class="form-label-title mt-3" for="filenames">File upload (jpg, pdf)</label>
                                      		<input type="file" class="dropify" data-height="180" name="filenames[]" id="filenames" data-allowed-file-extensions='["jpg", "pdf", "jpeg"]' multiple/>
                                    	</div>
                                  	</div>
									<div class="col-sm-12 col-md-12">
										<div class="form-group">
											<label class="form-label" for="remarks">Remarks</label>
											<textarea class="form-control" name="remarks" id="remarks" placeholder="Type Here..."></textarea>
										</div>
									</div>
								</div>
								<hr />
								<div class="btn-list d-flex justify-content-end">
									<button class="btn btn-info" type="submit" value="submit">Save</button>
									<a href="{{url('admin/new_service_requests')}}" class="btn btn-danger">Cancel</a>
								</div>
							</form>
						</div>
					</div>
					<div class="card newser">
						<div class="card-body">
							<div class="card-title font-weight-bold">Uploaded Files:</div>
							<div class="row">
								@php
									$file_name = json_decode($survey_study->upload_photos_of_study_area,true);
								@endphp
								@if($file_name && count($file_name) > 0)
									@foreach($file_name as $file)
										<div class="col-md-3 col-sm-3">
											<img src="{{$file}}" alt="" width="100px">
										</div>
									@endforeach
								@endif
							</div>
						</div>
					</div>
				</div>
				<div class="tab-pane" id="tab-9">
					<div class="card newser">
						<div class="card-body">
							<div class="card-title font-weight-bold">Basic info:</div>
							<div class="row">
								<div class="col-sm-4 col-md-4">
									<div class="form-group">
										<div class="media-body">
											<div class="font-weight-normal1">
												Name
											</div>
										</div>
										<label class="form-label">{{$request_data->fname}}</label>
									</div>
								</div>
								<div class="col-sm-4 col-md-4">
									<div class="form-group">
										<div class="media-body">
											<div class="font-weight-normal1">
												Designation
											</div>
										</div>
										<label class="form-label">{{$request_data->designation}}</label>
									</div>
								</div>
								<div class="col-sm-4 col-md-4">
									<div class="form-group">
										<div class="media-body">
											<div class="font-weight-normal1">
												Name Of Department
											</div>
										</div>
										<label class="form-label">{{$request_data->department}}</label>
									</div>
								</div>
								<div class="col-sm-4 col-md-4">
									<div class="form-group">
										<div class="media-body">
											<div class="font-weight-normal1">
												Name Of Firm
											</div>
										</div>
										<label class="form-label">{{$request_data->firm}}</label>
									</div>
								</div>
								<div class="col-sm-4 col-md-4">
									<div class="form-group">
										<div class="media-body">
											<div class="font-weight-normal1">
												Type Of Organization
											</div>
										</div>
										<label class="form-label">{{$request_data->sector}}</label>
									</div>
								</div>
								<div class="col-md-12">
									<div class="form-group">
										<div class="media-body">
											<div class="font-weight-normal1">
												Purpose
											</div>
										</div>
										<label class="form-label">{{$request_data->purpose}}. </label>
									</div>
								</div>
								<div class="col-md-12">
									<div class="form-group">
										<div class="media-body">
											<div class="font-weight-normal1">
												Brief Description Of Type Of Work
											</div>
										</div>
										<label class="form-label">{{$request_data->description}}. </label>
									</div>
								</div>
								<div class="col-md-12">
									<div class="form-group">
										<div class="media-body">
											<div class="font-weight-normal1">
												Required Service From HSW
											</div>
										</div>
										<label class="form-label">{{$service}}</label>
									</div>
								</div>
							</div>
							<hr />
							<div class="card-title font-weight-bold mt-5">Location</div>
							<div class="row">
								<div class="col-sm-4 col-md-4">
									<div class="form-group">
										<div class="media-body">
											<div class="font-weight-normal1">
												State
											</div>
										</div>
										<label class="form-label">{{$state_name}}</label>
									</div>
								</div>
								<div class="col-sm-4 col-md-4">
									<div class="form-group">
										<div class="media-body">
											<div class="font-weight-normal1">
												District
											</div>
										</div>
										<label class="form-label">{{$district_name}}</label>
									</div>
								</div>
								<div class="col-sm-4 col-md-4">
									<div class="form-group">
										<div class="media-body">
											<div class="font-weight-normal1">
												Name Of Place
											</div>
										</div>
										<label class="form-label">{{$request_data->place}}</label>
									</div>
								</div>
								@if($request_data->survey_area_location)
									<div class="col-sm-4 col-md-4">
										<div class="form-group">
											<div class="media-body">
												<div class="font-weight-normal1">
													Survey Area Location
												</div>
											</div>
											<label class="form-label">{{$request_data->survey_area_location}}</label>
										</div>
									</div>
								@endif
								@if($request_data->tidal_area_location)
									<div class="col-sm-4 col-md-4">
										<div class="form-group">
											<div class="media-body">
												<div class="font-weight-normal1">
													Tidal area location
												</div>
											</div>
											<label class="form-label">{{$request_data->tidal_area_location}}</label>
										</div>
									</div>
								@endif
								@if($request_data->depth_at_saples_collected)
									<div class="col-sm-4 col-md-4">
										<div class="form-group">
											<div class="media-body">
												<div class="font-weight-normal1">
													Depth at which samples to be collected
												</div>
											</div>
											<label class="form-label">{{$request_data->depth_at_saples_collected}}</label>
										</div>
									</div>
								@endif
								@if($request_data->location)
									<div class="col-sm-4 col-md-4">
										<div class="form-group">
											<div class="media-body">
												<div class="font-weight-normal1">
													Survey Area Location
												</div>
											</div>
											<label class="form-label">{{$request_data->location}}</label>
										</div>
									</div>
								@endif
							</div>
							<hr />
							<div class="card-title font-weight-bold mt-5">Details</div>
							<div class="row">
								@if($request_data->type_of_waterbody)
									<div class="col-sm-4 col-md-4">
										<div class="form-group">
											<div class="media-body">
												<div class="font-weight-normal1">
													Type Of Waterbody
												</div>
											</div>
											<label class="form-label">{{$request_data->type_of_waterbody}}</label>
										</div>
									</div>
								@endif
								@if($request_data->period_of_observation)
									<div class="col-sm-4 col-md-4">
										<div class="form-group">
											<div class="media-body">
												<div class="font-weight-normal1">
													Period of observation
												</div>
											</div>
											<label class="form-label">{{$request_data->period_of_observation}}</label>
										</div>
									</div>
								@endif
								@if($request_data->number_of_locations)
									<div class="col-sm-4 col-md-4">
										<div class="form-group">
											<div class="media-body">
												<div class="font-weight-normal1">
													No. of locations from which samples to be collected
												</div>
											</div>
											<label class="form-label">{{$request_data->number_of_locations}}</label>
										</div>
									</div>
								@endif
								@if($request_data->quantity_of_samples)
									<div class="col-sm-4 col-md-4">
										<div class="form-group">
											<div class="media-body">
												<div class="font-weight-normal1">
													Quantity of sample to be collected in each location
												</div>
											</div>
											<label class="form-label">{{$request_data->quantity_of_samples}}</label>
										</div>
									</div>
								@endif
								@if($request_data->area_of_survey)
									<div class="col-sm-4 col-md-4">
										<div class="form-group">
											<div class="media-body">
												<div class="font-weight-normal1">
													Area Of Survey
												</div>
											</div>
											<label class="form-label">{{$request_data->area_of_survey}}</label>
										</div>
									</div>
								@endif
								@if($request_data->scale_of_survey)
									<div class="col-sm-4 col-md-4">
										<div class="form-group">
											<div class="media-body">
												<div class="font-weight-normal1">
													Scale Of Survey
												</div>
											</div>
											<label class="form-label">{{$request_data->scale_of_survey}}</label>
										</div>
									</div>
								@endif
								@if($request_data->service_to_be_conducted)
									<div class="col-sm-4 col-md-4">
										<div class="form-group">
											<div class="media-body">
												<div class="font-weight-normal1">
													When Service To Be Conducted
												</div>
											</div>
											<label class="form-label">@php echo date('d/m/Y',strtotime($request_data->service_to_be_conducted)); @endphp</label>
										</div>
									</div>
								@endif
								@if($request_data->interim_surveys_needed_infuture)
									<div class="col-sm-4 col-md-4">
										<div class="form-group">
											<div class="media-body">
												<div class="font-weight-normal1">
													Whether Interim Surveys Are Needed In Future
												</div>
											</div>
											<label class="form-label">{{$request_data->interim_surveys_needed_infuture}}</label>
										</div>
									</div>
								@endif
								@if($request_data->benchmark_chart_datum)
									<div class="col-sm-4 col-md-4">
										<div class="form-group">
											<div class="media-body">
												<div class="font-weight-normal1">
													Whether Benchmark / Chart Datum Available In The Area
												</div>
											</div>
											<label class="form-label">{{$request_data->benchmark_chart_datum}}</label>
										</div>
									</div>
								@endif
								@if($request_data->detailed_description_area)
									<div class="col-sm-4 col-md-4">
										<div class="form-group">
											<div class="media-body">
												<div class="font-weight-normal1">
													Detailed description of area
												</div>
											</div>
											<label class="form-label">{{$request_data->detailed_description_area}}</label>
										</div>
									</div>
								@endif
								@if($request_data->dredging_survey_method)
									<div class="col-sm-4 col-md-4">
										<div class="form-group">
											<div class="media-body">
												<div class="font-weight-normal1">
													Whether pre/post dredging survey required or both
												</div>
											</div>
											<label class="form-label">{{$request_data->dredging_survey_method}}</label>
										</div>
									</div>
								@endif
								@if($request_data->interim_survey)
									<div class="col-sm-4 col-md-4">
										<div class="form-group">
											<div class="media-body">
												<div class="font-weight-normal1">
													Whether interim surveys are needed in future
												</div>
											</div>
											<label class="form-label">{{$request_data->interim_survey}}</label>
										</div>
									</div>
								@endif
								@if($request_data->dredging_quantity_calculation)
									<div class="col-sm-4 col-md-4">
										<div class="form-group">
											<div class="media-body">
												<div class="font-weight-normal1">
													Whether dredging quantity calculation required
												</div>
											</div>
											<label class="form-label">{{$request_data->dredging_quantity_calculation}}</label>
										</div>
									</div>
								@endif
								@if($request_data->method_volume_calculation)
									<div class="col-sm-4 col-md-4">
										<div class="form-group">
											<div class="media-body">
												<div class="font-weight-normal1">
													Method to be adopted for volume calculation
												</div>
											</div>
											<label class="form-label">{{$request_data->method_volume_calculation}}</label>
										</div>
									</div>
								@endif
								@if($request_data->length)
									<div class="col-sm-4 col-md-4">
										<div class="form-group">
											<div class="media-body">
												<div class="font-weight-normal1">
													Length for Survey Calculation
												</div>
											</div>
											<label class="form-label">{{$request_data->length}}</label>
										</div>
									</div>
								@endif
								@if($request_data->width)
									<div class="col-sm-4 col-md-4">
										<div class="form-group">
											<div class="media-body">
												<div class="font-weight-normal1">
													Width for Survey Calculation
												</div>
											</div>
											<label class="form-label">{{$request_data->width}}</label>
										</div>
									</div>
								@endif
								@if($request_data->depth)
									<div class="col-sm-4 col-md-4">
										<div class="form-group">
											<div class="media-body">
												<div class="font-weight-normal1">
													Depth for Survey Calculation
												</div>
											</div>
											<label class="form-label">{{$request_data->depth}}</label>
										</div>
									</div>
								@endif
								@if($request_data->water_bodies)
									<div class="col-sm-4 col-md-4">
										<div class="form-group">
											<div class="media-body">
												<div class="font-weight-normal1">
													Type of Waterbody
												</div>
											</div>
											<label class="form-label">{{$request_data->water_bodies}}</label>
										</div>
									</div>
								@endif
								@if($request_data->year_of_survey_chart)
									<div class="col-sm-4 col-md-4">
										<div class="form-group">
											<div class="media-body">
												<div class="font-weight-normal1">
													Year of survey chart required
												</div>
											</div>
											<label class="form-label">{{$request_data->year_of_survey_chart}}</label>
										</div>
									</div>
								@endif
								@if($request_data->copies_required)
									<div class="col-sm-4 col-md-4">
										<div class="form-group">
											<div class="media-body">
												<div class="font-weight-normal1">
													No. of copies required
												</div>
											</div>
											<label class="form-label">{{$request_data->copies_required}}</label>
										</div>
									</div>
								@endif
								@if($request_data->copy_type)
									<div class="col-sm-4 col-md-4">
										<div class="form-group">
											<div class="media-body">
												<div class="font-weight-normal1">
													Whether print/soft copy required or both
												</div>
											</div>
											<label class="form-label">{{$request_data->copy_type}}</label>
										</div>
									</div>
								@endif
								@if($request_data->observation_start_date)
									<div class="col-sm-4 col-md-4">
										<div class="form-group">
											<div class="media-body">
												<div class="font-weight-normal1">
													Period of observation Start Date
												</div>
											</div>
											<label class="form-label">@php echo date('d/m/Y',strtotime($request_data->observation_start_date)); @endphp</label>
										</div>
									</div>
								@endif
								@if($request_data->observation_end_date)
									<div class="col-sm-4 col-md-4">
										<div class="form-group">
											<div class="media-body">
												<div class="font-weight-normal1">
													Period of observation End Date
												</div>
											</div>
											<label class="form-label">@php echo date('d/m/Y',strtotime($request_data->observation_end_date)); @endphp</label>
										</div>
									</div>
								@endif
								@if($request_data->area_to_scan)
									<div class="col-sm-4 col-md-4">
										<div class="form-group">
											<div class="media-body">
												<div class="font-weight-normal1">
													Area to be scanned
												</div>
											</div>
											<label class="form-label">{{$request_data->area_to_scan}}</label>
										</div>
									</div>
								@endif
								@if($request_data->depth_of_area)
									<div class="col-sm-4 col-md-4">
										<div class="form-group">
											<div class="media-body">
												<div class="font-weight-normal1">
													Depth of the area
												</div>
											</div>
											<label class="form-label">{{$request_data->depth_of_area}}</label>
										</div>
									</div>
								@endif
								@if($request_data->interval)
									<div class="col-sm-4 col-md-4">
										<div class="form-group">
											<div class="media-body">
												<div class="font-weight-normal1">
													Line / scanning interval
												</div>
											</div>
											<label class="form-label">{{$request_data->interval}}</label>
										</div>
									</div>
								@endif
								@if($request_data->area_to_survey)
									<div class="col-sm-4 col-md-4">
										<div class="form-group">
											<div class="media-body">
												<div class="font-weight-normal1">
													Area to be scanned
												</div>
											</div>
											<label class="form-label">{{$request_data->area_to_survey}}</label>
										</div>
									</div>
								@endif
								<!-- <div class="col-sm-12 col-md-12">
									<div class="form-group">
										<div class="media-body">
											<div class="font-weight-normal1">
												Existing Drawings / Maps Showing The Location
											</div>
										</div>
										<ul id="lightgallery" class="list-unstyled row">
											<li class="col-xs-6 col-sm-4 col-md-3" data-responsive="{{URL::asset('assets/images/photos/1.jpg')}}" data-src="{{URL::asset('assets/images/photos/1.jpg')}}" data-sub-html="<h4>Gallery Image 1</h4><p> Many desktop publishing packages and web page editors now use Lorem Ipsum</p>">
												<a href="">
													<img class="img-responsive" src="{{URL::asset('assets/images/photos/1.jpg')}}" alt="Thumb-1">
												</a>
											</li>
											<li class="col-xs-6 col-sm-4 col-md-3" data-responsive="{{URL::asset('assets/images/photos/2.jpg')}}" data-src="{{URL::asset('assets/images/photos/2.jpg')}}" data-sub-html="<h4>Gallery Image 2</h4><p> Many desktop publishing packages and web page editors now use Lorem Ipsum</p>">
												<a href="">
													<img class="img-responsive" src="{{URL::asset('assets/images/photos/2.jpg')}}" alt="Thumb-2">
												</a>
											</li>
											<li class="col-xs-6 col-sm-4 col-md-3" data-responsive="{{URL::asset('assets/images/photos/3.jpg')}}" data-src="{{URL::asset('assets/images/photos/3.jpg')}}" data-sub-html="<h4>Gallery Image 3</h4><p> Many desktop publishing packages and web page editors now use Lorem Ipsum</p>">
												<a href="">
													<img class="img-responsive" src="{{URL::asset('assets/images/photos/3.jpg')}}" alt="Thumb-1">
												</a>
											</li>
											<li class="col-xs-6 col-sm-4 col-md-3" data-responsive="{{URL::asset('assets/images/photos/4.jpg')}}" data-src="{{URL::asset('assets/images/photos/4.jpg')}}" data-sub-html=" <h4>Gallery Image 4</h4><p> Many desktop publishing packages and web page editors now use Lorem Ipsum</p>">
												<a href="">
													<img class="img-responsive" src="{{URL::asset('assets/images/photos/4.jpg')}}" alt="Thumb-2">
												</a>
											</li>
										</ul>
									</div>
								</div> -->
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>


</div>
</div><!-- end app-content-->
</div>

@endsection
@section('js')
<!-- INTERNAL Data tables -->
<!-- <script src="{{URL::asset('assets/plugins/datatable/js/jquery.dataTables.js')}}"></script>
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
<script src="{{URL::asset('assets/js/datatables.js')}}"></script> -->
<!-- INTERNAL Gallery js -->
<script src="{{URL::asset('assets/plugins/gallery/picturefill.js')}}"></script>
<script src="{{URL::asset('assets/plugins/gallery/lightgallery.js')}}"></script>
<script src="{{URL::asset('assets/plugins/gallery/lg-pager.js')}}"></script>
<script src="{{URL::asset('assets/plugins/gallery/lg-autoplay.js')}}"></script>
<script src="{{URL::asset('assets/plugins/gallery/lg-fullscreen.js')}}"></script>
<script src="{{URL::asset('assets/plugins/gallery/lg-zoom.js')}}"></script>
<script src="{{URL::asset('assets/plugins/gallery/lg-hash.js')}}"></script>
<script src="{{URL::asset('assets/js/gallery.js')}}"></script>

<!-- INTERNAL Select2 js -->
<script src="{{URL::asset('assets/plugins/select2/select2.full.min.js')}}"></script>
<script type="text/javascript">
	$(document).ready(function(){
      $('#survey_study').datepicker({
        format: 'dd-mm-yyyy',
        todayHighlight: true,
        startDate: '0',
        autoclose: true
      });
    });
</script>
@endsection