@extends('layouts.admin.master-draftsman')
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
		<h4 class="page-title mb-0">Services And Requests</h4>
		<ol class="breadcrumb">
			<li class="breadcrumb-item"><a href="#"><i class="fe fe-layout mr-2 fs-14"></i>Services And Requests</a></li>
			<li class="breadcrumb-item active" aria-current="page"><a href="#">Invoice</a></li>
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
                <a href="{{URL('/draftsman/create_invoice')}}/{{$survey_id}}" class="btn btn-primary">Create Invoice</a>
				<!-- <a href="#" class="modal-effect btn btn-danger" data-effect="effect-scale" data-target="#modaldemo2" data-toggle="modal" href="">Reject</a> -->
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
								Field study report and ETA received
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
						<li><a href="#tab-8" data-toggle="tab" class="fs-14">Timeline</a></li>
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
							<div class="card-title font-weight-bold">Basic info:</div>
							<div class="row">
								<div class="col-sm-4 col-md-4">
									<div class="form-group">
										<div class="media-body">
											<div class="font-weight-normal1">
												Date And Time Of Inspection
											</div>
										</div>
										<label class="form-label">{{date('d/m/Y H:i:s',strtotime($field_study->datetime_inspection))}}</label>
									</div>
								</div>
								<div class="col-sm-8 col-md-8">
									<div class="form-group">
										<div class="media-body">
											<div class="font-weight-normal1">
												Name Of Department / Firm With Which Reconnaissance Survey Is Conducted
											</div>
										</div>
										<label class="form-label">{{$field_study->survey_department_name}}</label>
									</div>
								</div>
								<div class="col-sm-4 col-md-4">
									<div class="form-group">
										<div class="media-body">
											<div class="font-weight-normal1">
												From Hydrographic Survey Wing
											</div>
										</div>
										<label class="form-label">{{$field_study->from_hsw}}</label>
									</div>
								</div>
								<div class="col-sm-4 col-md-4">
									<div class="form-group">
										<div class="media-body">
											<div class="font-weight-normal1">
												Name Of Officers Participating In Field Inspection
											</div>
										</div>
										<label class="form-label">{{$field_study->officer_participating_field_inspection}}</label>
									</div>
								</div>
								<div class="col-sm-4 col-md-4">
									<div class="form-group">
										<div class="media-body">
											<div class="font-weight-normal1">
												Location
											</div>
										</div>
										<label class="form-label">{{$field_study->location}}</label>
									</div>
								</div>
								<div class="col-sm-4 col-md-4">
									<div class="form-group">
										<div class="media-body">
											<div class="font-weight-normal1">
												Type Of Water Body
											</div>
										</div>
										<label class="form-label">{{$field_study->type_of_waterbody}}</label>
									</div>
								</div>
								<div class="col-sm-4 col-md-4">
									<div class="form-group">
										<div class="media-body">
											<div class="font-weight-normal1">
												Limit Of Survey Area
											</div>
										</div>
										<label class="form-label">{{$field_study->limit_of_survey_area}}</label>
									</div>
								</div>
							</div>
							<hr />
							<div class="card-title font-weight-bold mt-5">ETA</div>
							<div class="row">
								<div class="col-sm-4 col-md-4">
									<div class="form-group">
										<div class="media-body">
											<div class="font-weight-normal1">
												General Area
											</div>
										</div>
										<label class="form-label">{{$field_study_eta->general_area}}</label>
									</div>
								</div>
								<div class="col-sm-4 col-md-4">
									<div class="form-group">
										<div class="media-body">
											<div class="font-weight-normal1">
												Location
											</div>
										</div>
										<label class="form-label">{{$field_study_eta->location}}</label>
									</div>
								</div>
								<div class="col-sm-4 col-md-4">
									<div class="form-group">
										<div class="media-body">
											<div class="font-weight-normal1">
												No. Of Days Required
											</div>
										</div>
										<label class="form-label">{{$field_study_eta->no_of_days_required}}</label>
									</div>
								</div>
								<div class="col-sm-4 col-md-4">
									<div class="form-group">
										<div class="media-body">
											<div class="font-weight-normal1">
												Scale Of Survey Recommended
											</div>
										</div>
										<label class="form-label">{{$field_study_eta->scale_of_survey_recomended}}</label>
									</div>
								</div>
								<div class="col-sm-4 col-md-4">
									<div class="form-group">
										<div class="media-body">
											<div class="font-weight-normal1">
												Type Of Survey
											</div>
										</div>
										<label class="form-label">{{$field_study_eta->type_of_survey}}</label>
									</div>
								</div>
								<div class="col-sm-4 col-md-4">
									<div class="form-group">
										<div class="media-body">
											<div class="font-weight-normal1">
												Charges
											</div>
										</div>
										<label class="form-label">{{$field_study_eta->charges}}</label>
									</div>
								</div>
							</div>
							<hr />
							<div class="row">
								<div class="col-sm-12 col-md-12">
									<div class="form-group">
										<div class="media-body">
											<div class="font-weight-normal1">
												Upload Images
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
								</div>
								<div class="col-sm-12 col-md-12">
									<div class="form-group">
										<div class="media-body">
											<div class="font-weight-normal1">
												Remarks
											</div>
										</div>
										<textarea class="form-control mb-4" placeholder="Textarea" rows="3">{{$field_study->remarks}}</textarea>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="tab-pane" id="tab-8">
					<div class="card p-5">
						<ul class="timelineleft pb-5 mt-5">
							@if($survey_datas && count($survey_datas) > 0)
								@foreach($survey_datas as $survey_data)
									<li> <i class="fa fa-clock-o bg-pink"></i>
										<div class="timelineleft-item">
											<span class="time"><i class="fa fa-clock-o text-danger"></i> {{date('d/m/Y',strtotime($survey_data->log_date))}}</span>
											<h3 class="timelineleft-header">{{$survey_data->status_name}}</h3>
										</div>
									</li>
								@endforeach
							@endif
						</ul>
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


<div class="row">
	<div class="col-12">
		<div class="btn-list d-flex justify-content-end">
			<a href="{{URL('/draftsman/create_invoice')}}/{{$survey_id}}" class="btn btn-primary">Create Invoice</a>
			<!-- <a href="#" class="modal-effect btn btn-danger" data-effect="effect-scale" data-target="#modaldemo2" data-toggle="modal" href="">Reject</a> -->
		</div>
	</div>
</div>


</div>
</div><!-- end app-content-->
</div>

<!-- <div class="modal" id="modaldemo1">
	<div class="modal-dialog" role="document">
		<div class="modal-content modal-content-demo">
			<div class="modal-header">
				<h6 class="modal-title">Assign</h6><button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
			</div>
			<div class="modal-body">
				<div class="col-md-12">
					<div class="form-group">
						<label class="form-label">Recipient <span class="text-red">*</span></label>
						<select class="form-control custom-select select2">
							<option value="0">--Select--</option>
							<option value="1">Germany</option>
							<option value="2">Canada</option>
							<option value="3">Usa</option>
							<option value="4">Aus</option>
						</select>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button class="btn btn-primary" type="button">Assign</button> <button class="btn btn-secondary" data-dismiss="modal" type="button">Close</button>
			</div>
		</div>
	</div>
</div> -->

<div class="modal" id="modaldemo2">
	<div class="modal-dialog" role="document">
		<div class="modal-content modal-content-demo">
			<!-- <div class="modal-header">
				<h6 class="modal-title">Reject</h6><button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
			</div> -->
			<div class="modal-body">
				<div class="col-md-12">
					<div class="form-group">
						<label class="form-label">Select which are needs to be rejected <span class="text-red">*</span></label>
						<div class="custom-controls-stacked">
							<label class="custom-control custom-checkbox d-inline-block mr-3">
								<input type="checkbox" class="custom-control-input" name="example-checkbox1" value="option1">
								<span class="custom-control-label">Report</span>
							</label>
							<label class="custom-control custom-checkbox d-inline-block">
								<input type="checkbox" class="custom-control-input" name="example-checkbox1" value="option1">
								<span class="custom-control-label">ETA</span>
							</label>
						</div>
					</div>
				</div>
				<div class="col-md-12">
					<div class="form-group">
						<label class="form-label">Remark <span class="text-red">*</span></label>
						<textarea class="form-control" rows="3">Type Here...</textarea>
					</div>
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