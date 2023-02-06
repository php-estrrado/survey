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
								<div class="col-sm-6 col-md-6">
									<div class="form-group">
										<div class="media-body">
											<div class="font-weight-normal1">
												Limit Of Survey Area
											</div>
										</div>
										<label class="form-label">{{$survey_study->limit_of_survey_area}}</label>
									</div>
								</div>
							</div>
							<hr />
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
                                                Type of Survey vessel that can be used for bathymetric survey
											</div>
										</div>
										<label class="form-label">{{$survey_study->type_of_survey_vessel_used_for_bathymetric_survey}}</label>
									</div>
								</div>
								<div class="col-sm-4 col-md-4">
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
                                                Remarks
											</div>
										</div>
										<label class="form-label">{{$survey_study->remarks}}</label>
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
							</div>
						</div>
					</div>
                </div>
            </div>
        </div>
    </body>
</html>