@extends('layouts.admin.master')
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
		<h4 class="page-title mb-0">New Service Request</h4>
		<ol class="breadcrumb">
			<li class="breadcrumb-item"><a href="#"><i class="fe fe-layout mr-2 fs-14"></i>Services And Requests</a></li>
			<li class="breadcrumb-item active" aria-current="page"><a href="#">New Service Request</a></li>
		</ol>
	</div>
</div>
<!--End Page header-->
@endsection
@section('content')
<!-- Row -->
<div class="row">
	<div class="col-12">

		<!--div-->
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
												Additional service needed
											</div>
										</div>
										<label class="form-label">{{$additional_services}}</label>
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
									Name of waterbody
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
					@if($request_data->data_required)
					<div class="col-md-12">
									<div class="form-group">
										<div class="media-body">
											<div class="font-weight-normal1">
												Data Required
											</div>
										</div>
										<label class="form-label">
											<?php $exp = explode(",", $request_data->data_required);
												$data_arr = array('sounding' => "Sounding",'current_meter_survey' => "Current meter survey",
												'bottom_profile' => "Bottom profile",'velocity' => "Velocity",'bottom_sample_collection' => "Bottom sample collection",'tide_data' => "Tide data");
											if($exp){
												foreach ($exp as $ek => $ev) {
													echo $data_arr[$ev].",";
												}
											}
											 ?>
											
											</label>
									</div>
								</div>
								@endif
								@if($data_collection)

								<div class="col-md-12">
									<div class="form-group">
										<div class="media-body">
											<div class="font-weight-normal1">
												Method/Equipment for Data Collection
											</div>
										</div>
										<label class="form-label">{{$data_collection}}</label>
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
					@if($request_data->start_date)
									<div class="col-sm-4 col-md-4">
										<div class="form-group">
											<div class="media-body">
												<div class="font-weight-normal1">
													Period of observation Start Date
												</div>
											</div>
											<label class="form-label">{{$request_data->start_date}}</label>
										</div>
									</div>
								@endif
								@if($request_data->end_date)
									<div class="col-sm-4 col-md-4">
										<div class="form-group">
											<div class="media-body">
												<div class="font-weight-normal1">
													Period of observation End Date
												</div>
											</div>
											<label class="form-label">{{$request_data->end_date}}</label>
										</div>
									</div>
								@endif
								@if($request_data->duration)
									<div class="col-sm-4 col-md-4">
										<div class="form-group">
											<div class="media-body">
												<div class="font-weight-normal1">
													Duration (Years, Weeks, Days, Hours)
												</div>
											</div>
											<label class="form-label">{{$request_data->duration}}</label>
										</div>
									</div>
								@endif
								
								@if($request_data->method_of_observation)
									<div class="col-sm-4 col-md-4">
										<div class="form-group">
											<div class="media-body">
												<div class="font-weight-normal1">
													Method of observation
												</div>
											</div>
											<label class="form-label">{{ ucfirst($request_data->method_of_observation) }}</label>
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
													Interval (in kms)
												</div>
											</div>
											<label class="form-label">{{$request_data->quantity_of_samples}}</label>
										</div>
									</div>
								@endif
								@if($request_data->quantity_bottom_sample)
									<div class="col-sm-4 col-md-4">
										<div class="form-group">
											<div class="media-body">
												<div class="font-weight-normal1">
													Quantity (kg)
												</div>
											</div>
											<label class="form-label">{{$request_data->quantity_bottom_sample}}</label>
										</div>
									</div>
								@endif
								@if($request_data->method_of_sampling)
									<div class="col-sm-4 col-md-4">
										<div class="form-group">
											<div class="media-body">
												<div class="font-weight-normal1">
													Method of sampling
												</div>
											</div>
											<label class="form-label">{{$request_data->method_of_sampling}}</label>
										</div>
									</div>
								@endif
								@if($request_data->description_of_requirement)
									<div class="col-sm-4 col-md-4">
										<div class="form-group">
											<div class="media-body">
												<div class="font-weight-normal1">
													Description of Requirement
												</div>
											</div>
											<label class="form-label">{{$request_data->description_of_requirement}}</label>
										</div>
									</div>
								@endif
								@if($request_data->file_upload)
									<div class="col-sm-4 col-md-4">
										<div class="form-group">
											<div class="media-body">
												<div class="font-weight-normal1">
													Bottom Sample File upload
												</div>
											</div>
											<label class="form-label">
												<a href="{{ url('/').'/storage/'.$request_data->file_upload}}" target="_blank">View</a>
												</label>
										</div>
									</div>
								@endif
								@if($request_data->interval_bottom_sample)
									<div class="col-sm-4 col-md-4">
										<div class="form-group">
											<div class="media-body">
												<div class="font-weight-normal1">
													Quantity of sample to be collected in each location
												</div>
											</div>
											<label class="form-label">{{$request_data->interval_bottom_sample}}</label>
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
					@if($request_data->description_of_benchmark)
									<div class="col-sm-4 col-md-4">
										<div class="form-group">
											<div class="media-body">
												<div class="font-weight-normal1">
													Description of Benchmark
												</div>
											</div>
											<label class="form-label">{{$request_data->description_of_benchmark}}</label>
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
		<!--/div-->

		<div class="btn-list d-flex justify-content-end">
			<a href="#" class="modal-effect btn btn-primary" data-effect="effect-scale" data-target="#modaldemo1" data-toggle="modal" href="">Accept</a>
			<a href="#" class="modal-effect btn btn-secondary" data-effect="effect-scale" data-target="#modaldemo2" data-toggle="modal" href="">Reject Open</a>
			<a href="#" class="modal-effect btn btn-danger" data-effect="effect-scale" data-target="#modaldemo3" data-toggle="modal" href="">Reject Close</a>
		</div>

	</div>
</div>
<!-- /Row -->


</div>
</div><!-- end app-content-->
</div>

<div class="modal" id="modaldemo1">
	<div class="modal-dialog" role="document">
		<div class="modal-content modal-content-demo">
			<form action="{{url('/superadmin/assign_survey')}}" method="POST" id="assign_institution">
				@csrf
				<input type="hidden" value="{{$survey_id}}" id="id" name="id">
				<div class="modal-header">
					<h6 class="modal-title">Assign</h6><button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
				</div>
				<div class="modal-body">
					<div class="col-md-12">
						<div class="form-group">
							<label class="form-label" for="assigned_institution">Assign Institution <span class="text-red">*</span></label>
							<select class="form-control custom-select select2" id="assigned_institution" name="assigned_institution">
								<option value="0">--Select--</option>
								@if($institutions && count($institutions)>0)
									@foreach($institutions as $institution)
										<option value="{{$institution->id}}">{{$institution->institution_name}}</option>
									@endforeach
								@endif
							</select>
							@error('assigned_institution')
								<p style="color: red">{{ $message }}</p>
							@enderror
						</div>
						<div class="form-group">
							<label class="form-label" for="assigned_user">Assign User <span class="text-red">*</span></label>
							<select class="form-control custom-select select2" id="assigned_user" name="assigned_user">
								<option value="0">--Select--</option>
								@if($admins && count($admins)>0)
									@foreach($admins as $admin)
										<option value="{{$admin->id}}">{{$admin->email}}</option>
									@endforeach
								@endif								
							</select>
							@error('assigned_user')
								<p style="color: red">{{ $message }}</p>
							@enderror
						</div>
						<div class="form-group">
							<label class="form-label" for="remarks">Remarks <span class="text-red">*</span></label>
							<textarea class="form-control" name="remarks" id="remarks" rows="3"></textarea>
							@error('remarks')
								<p style="color: red">{{ $message }}</p>
							@enderror
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button class="btn btn-primary" type="submit" value="submit">Assign</button> <button class="btn btn-secondary" data-dismiss="modal" type="button">Close</button>
				</div>
			</form>
		</div>
	</div>
</div>

<div class="modal" id="modaldemo2">
	<div class="modal-dialog" role="document">
		<div class="modal-content modal-content-demo">
			<div class="modal-header">
				<h6 class="modal-title">Reject Open</h6><button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
			</div>
			<div class="modal-body">
				<div class="col-md-12">
					<div class="form-group">
						<label class="form-label">Remark <span class="text-red">*</span></label>
						<textarea class="form-control" rows="3">Type Here...</textarea>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button class="btn btn-primary" type="button">Send Notification</button> <button class="btn btn-secondary" data-dismiss="modal" type="button">Close</button>
			</div>
		</div>
	</div>
</div>

<div class="modal" id="modaldemo3">
	<div class="modal-dialog" role="document">
		<div class="modal-content modal-content-demo">
			<div class="modal-header">
				<h6 class="modal-title">Reject Closed</h6><button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
			</div>
			<div class="modal-body">
				<div class="col-md-12">
					<div class="form-group">
						<label class="form-label">Remark <span class="text-red">*</span></label>
						<textarea class="form-control" rows="3">Type Here...</textarea>
					</div>
					<p class="text-center">Your request has been rejected with closed file. You will not be able to resubmit this request.</p>
				</div>
			</div>
			<div class="modal-footer">
				<button class="btn btn-primary" type="button">Send</button> <button class="btn btn-secondary" data-dismiss="modal" type="button">Close</button>
			</div>
		</div>
	</div>
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
@endsection