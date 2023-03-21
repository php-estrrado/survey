<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Survey Report</title>
		<!--Bootstrap css -->
		<link href="{{URL::asset('assets/plugins/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">

		<!-- Style css -->
		<link href="{{URL::asset('assets/css/style.css')}}" rel="stylesheet" />
    </head>
    <body>
        <div class="card newser">
            <div class="card-body">
                <div id="invoice_div">
                    <center><div class="card-title font-weight-bold">Survey Report</div></center>
                    <div class="card newser">
						<div class="card-body">
							<div class="card-title font-weight-bold">Basic info:</div>
							<div class="row">
								<div class="col-sm-12 col-md-12">
									<div class="form-group">
										<div class="media-body">
											<div class="font-weight-normal1">
												Date And Time Of Inspection
											</div>
										</div>
										<label class="form-label">{{date('d/m/Y H:i:s',strtotime($survey_study->datetime_inspection))}}</label>
									</div>
								</div>
								<div class="col-sm-6 col-md-6">
									<div class="form-group">
										<div class="media-body">
											<div class="font-weight-normal1">
												Name Of Department / Firm With Which Reconnaissance Survey Is Conducted
											</div>
										</div>
										<label class="form-label">{{$survey_study->survey_department_name}}</label>
									</div>
								</div>
								<div class="col-sm-6 col-md-6">
									<div class="form-group">
										<div class="media-body">
											<div class="font-weight-normal1">
												From Hydrographic Survey Wing
											</div>
										</div>
										<label class="form-label">{{$survey_study->from_hsw}}</label>
									</div>
								</div>
								<div class="col-sm-6 col-md-6">
									<div class="form-group">
										<div class="media-body">
											<div class="font-weight-normal1">
												Name Of Officers Participating In Field Inspection
											</div>
										</div>
										<label class="form-label">{{$survey_study->officer_participating_field_inspection}}</label>
									</div>
								</div>
								<div class="col-sm-6 col-md-6">
									<div class="form-group">
										<div class="media-body">
											<div class="font-weight-normal1">
												Location
											</div>
										</div>
										<label class="form-label">{{$survey_study->location}}</label>
									</div>
								</div>
								<div class="col-sm-6 col-md-6">
									<div class="form-group">
										<div class="media-body">
											<div class="font-weight-normal1">
												Type Of Water Body
											</div>
										</div>
										<label class="form-label">{{$survey_study->type_of_waterbody}}</label>
									</div>
								</div>
							</div>
							<hr />
							<div class="row">
								<div class="col-sm-12 col-md-12">
									<div class="form-group">
										<div class="media-body">
											<div class="font-weight-normal1">
												<h6>Limit of Survey</h6>
											</div>
										</div>
									</div>
								</div>
								<div class="col-sm-6 col-md-6">
									<div class="form-group">
										<div class="media-body">
											<div class="font-weight-normal1">
												Latitude
											</div>
										</div>
										<label class="form-label">{{$survey_study->lattitude}}</label>
									</div>
								</div>
								<div class="col-sm-6 col-md-6">
									<div class="form-group">
										<div class="media-body">
											<div class="font-weight-normal1">
												Longitude
											</div>
										</div>
										<label class="form-label">{{$survey_study->longitude}}</label>
									</div>
								</div>
								<div class="col-sm-6 col-md-6">
									<div class="form-group">
										<div class="media-body">
											<div class="font-weight-normal1">
												X Coordinates
											</div>
										</div>
										<label class="form-label">{{$survey_study->x_coordinates}}</label>
									</div>
								</div>
								<div class="col-sm-6 col-md-6">
									<div class="form-group">
										<div class="media-body">
											<div class="font-weight-normal1">
												Y Coordinates
											</div>
										</div>
										<label class="form-label">{{$survey_study->y_coordinates}}</label>
									</div>
								</div>
							</div>
							<hr/>
							<div class="row">
								<div class="col-sm-6 col-md-6">
									<div class="form-group">
										<div class="media-body">
											<div class="font-weight-normal1">
                                                Whether Topographic survey required
											</div>
										</div>
										<label class="form-label">{{$survey_study->whether_topographic_survey_required}}</label>
									</div>
								</div>
								<div class="col-sm-4 col-md-4">
									<div class="form-group">
										<div class="media-body">
											<div class="font-weight-normal1">
                                                Method to be adopted for Topographic survey
											</div>
										</div>
										<label class="form-label">{{$survey_study->methods_to_be_adopted_for_topographic_survey}}</label>
									</div>
								</div>
								<div class="col-sm-6 col-md-6">
									<div class="form-group">
										<div class="media-body">
											<div class="font-weight-normal1">
                                                Instruments to be used for Topographic survey
											</div>
										</div>
										<label class="form-label">{{$survey_study->instruments_to_be_used_for_topographic_survey}}</label>
									</div>
								</div>
								<div class="col-sm-6 col-md-6">
									<div class="form-group">
										<div class="media-body">
											<div class="font-weight-normal1">
                                                Availability of previous shoreline data
											</div>
										</div>
										<label class="form-label">{{$survey_study->availability_of_previous_shoreline_data}}</label>
									</div>
								</div>
								<div class="col-sm-6 col-md-6">
									<div class="form-group">
										<div class="media-body">
											<div class="font-weight-normal1">
                                                Accessibility of shoreline
											</div>
										</div>
										<label class="form-label">{{$survey_study->availability_of_shoreline}}</label>
									</div>
								</div>
								<div class="col-sm-6 col-md-6">
									<div class="form-group">
										<div class="media-body">
											<div class="font-weight-normal1">
                                                Nature of shore
											</div>
										</div>
										<label class="form-label">{{$survey_study->nature_of_shore}}</label>
									</div>
								</div>
                                <div class="col-sm-6 col-md-6">
									<div class="form-group">
										<div class="media-body">
											<div class="font-weight-normal1">
                                                Bathymetric Area
											</div>
										</div>
										<label class="form-label">{{$survey_study->bathymetric_area}}</label>
									</div>
								</div>
                                <div class="col-sm-6 col-md-6">
									<div class="form-group">
										<div class="media-body">
											<div class="font-weight-normal1">
                                                Scale of Survey planned
											</div>
										</div>
										<label class="form-label">{{$survey_study->scale_of_survey_planned}}</label>
									</div>
								</div>
                                <div class="col-sm-6 col-md-6">
									<div class="form-group">
										<div class="media-body">
											<div class="font-weight-normal1">
                                                Method adopted for bathymetric survey
											</div>
										</div>
										<label class="form-label">{{$survey_study->method_adopted_for_bathymetric_survey}}</label>
									</div>
								</div>
                                <div class="col-sm-6 col-md-6">
									<div class="form-group">
										<div class="media-body">
											<div class="font-weight-normal1">
                                                Is manual Survey require
											</div>
										</div>
										<label class="form-label">{{$survey_study->is_manual_survey_required}}</label>
									</div>
								</div>
							</div>
							<hr />
                            <div class="row">
								<div class="col-sm-6 col-md-6">
									<div class="form-group">
										<div class="media-body">
											<div class="font-weight-normal1">
                                                Line interval planned for survey
											</div>
										</div>
										<label class="form-label">{{$survey_study->line_interval_planned_for_survey}}</label>
									</div>
								</div>
								<div class="col-sm-6 col-md-6">
									<div class="form-group">
										<div class="media-body">
											<div class="font-weight-normal1">
                                                Type of Survey vessel that can be used for bathymetric survey
											</div>
										</div>
										<label class="form-label">{{$survey_study->type_of_survey_vessel_used_for_bathymetric_survey}}</label>
									</div>
								</div>
								<div class="col-sm-6 col-md-6">
									<div class="form-group">
										<div class="media-body">
											<div class="font-weight-normal1">
                                                Estimated period of survey work in days
											</div>
										</div>
										<label class="form-label">{{$survey_study->estimated_period_of_survey_days}}</label>
									</div>
								</div>
								<div class="col-sm-6 col-md-6">
									<div class="form-group">
										<div class="media-body">
											<div class="font-weight-normal1">
                                                Instruments to be used for bathymetric survey
											</div>
										</div>
										<label class="form-label">{{$survey_study->instruments_to_be_used_for_bathymetric_survey}}</label>
									</div>
								</div>
								<!-- <div class="col-sm-6 col-md-6">
									<div class="form-group">
										<div class="media-body">
											<div class="font-weight-normal1">
                                                Availability of previous shoreline data
											</div>
										</div>
										<label class="form-label">{{$survey_study->availability_of_previous_shoreline_data}}</label>
									</div>
								</div>
								<div class="col-sm-6 col-md-6">
									<div class="form-group">
										<div class="media-body">
											<div class="font-weight-normal1">
                                                Accessibility of shoreline
											</div>
										</div>
										<label class="form-label">{{$survey_study->availability_of_shoreline}}</label>
									</div>
								</div> -->
								<div class="col-sm-6 col-md-6">
									<div class="form-group">
										<div class="media-body">
											<div class="font-weight-normal1">
                                                Nearest available Benchmark detai
											</div>
										</div>
										<label class="form-label">{{$survey_study->nearest_available_benchmark_detail}}</label>
									</div>
								</div>
                                <div class="col-sm-6 col-md-6">
									<div class="form-group">
										<div class="media-body">
											<div class="font-weight-normal1">
                                                is Local Benchmark needs to be established
											</div>
										</div>
										<label class="form-label">{{$survey_study->is_local_benchmark_needs_to_be_established}}</label>
									</div>
								</div>
                                <div class="col-sm-6 col-md-6">
									<div class="form-group">
										<div class="media-body">
											<div class="font-weight-normal1">
                                                Detailed report of the officer
											</div>
										</div>
										<label class="form-label">{{$survey_study->detailed_report_of_the_officer}}</label>
									</div>
								</div>
                                <div class="col-sm-6 col-md-6">
									<div class="form-group">
										<div class="media-body">
											<div class="font-weight-normal1">
                                                Presence and nature of obstructions in the survey area
											</div>
										</div>
										<label class="form-label">{{$survey_study->presence_and_nature_of_obstructions_in_survey}}</label>
									</div>
								</div>
								<div class="col-sm-6 col-md-6">
									<div class="form-group">
										<div class="media-body">
											<div class="font-weight-normal1">
                                                Details of location for setting tide pole
											</div>
										</div>
										<label class="form-label">{{$survey_study->details_location_for_setting_tide_pole}}</label>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-sm-12 col-md-12">
									<div class="form-group">
										<div class="media-body">
											<div class="font-weight-normal1">
                                                Remarks
											</div>
										</div>
										<label class="form-label">{{$survey_study->remarks}}</label>
									</div>
								</div>
								<div class="col-sm-12 col-md-12">
									<div class="form-group">
										<div class="media-body">
											<div class="font-weight-normal1">
												Uploaded Images
											</div>
										</div>
										<ul id="lightgallery" class="list-unstyled row">
											@php
												$uploaded_images = json_decode($survey_study->upload_photos_of_study_area,true);
											@endphp
											@if($uploaded_images && count($uploaded_images) > 0)
												@foreach($uploaded_images as $images)
													<li class="col-xs-4 col-sm-3 col-md-3" data-responsive="{{$images}}" data-src="{{$images}}">
														<a href="{{$images}}" target="_blank">
															<img class="img-responsive" src="{{$images}}" alt="Thumb-1" width="100px">
														</a>
													</li>
												@endforeach
											@endif
										</ul>
									</div>
								</div>
							</div>
						</div>
					</div>
                </div>
            </div>
        </div>
    </body>
</html>