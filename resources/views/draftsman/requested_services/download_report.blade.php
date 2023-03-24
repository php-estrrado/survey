<!doctype html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>Survey Report</title>
		<style>
			body{
				font-size: 14px;
			}
			.table{
				border-collapse: collapse;
			}
			.table thead, .table tbody, .table tfoot, .table tr, .table td, .table th {
				padding: 0.25rem 0.25rem 0.25rem 0rem;
			}
			.table-bordered thead, .table-bordered tbody, .table-bordered tfoot, .table-bordered tr, .table-bordered td, .table-bordered th {
				border-color: #f2f4ff;
				border: 1px solid rgba(153, 153, 153, 0.3);
				padding: 0.35rem;
			}
			.tearhere{
				position: relative;
				height: 15px;
			}
			.tear {
				border:0;
				border-top: 2px solid #d9d9d9;
				background-color: transparent;
				opacity: 1;
			}
			.scis {
				position: relative;
				margin: 0 auto;
				display: block;
				z-index: 1;
				width: 170px;
				text-align: center;
				top: 20px;
				background: #fff;
			}
			.space{
				height: 20px;
				display: block;
			}
		</style>
	</head>
	<body>
		<table class="table" width="100%" border="0" cellspacing="1" cellpadding="1">
			<tbody>
				<tr>
					<td colspan="2"><b>Basic Info</b></td>
				</tr>
				<tr>
					<td width="50%">Date And Time Of Inspectione</td>
					<td width="50%"></td>
				</tr>
				<tr>
					<td>{{date('d/m/Y H:i:s',strtotime($survey_study->datetime_inspection))}}</td>
					<td></td>
				</tr>
				<tr>
					<td>Name Of Department / Firm With Which Reconnaissance Survey Is Conducted</td>
					<td>From Hydrographic Survey Wing</td>
				</tr>
				<tr>
					<td>{{$survey_study->survey_department_name}}</td>
					<td>{{$survey_study->from_hsw}}</td>
				</tr>
				<tr>
					<td>Name Of Officers Participating In Field Inspection</td>
					<td>Location</td>
				</tr>
				<tr>
					<td>{{$survey_study->officer_participating_field_inspection}}</td>
					<td>{{$survey_study->location}}</td>
				</tr>
				<tr>
					<td>Type Of Water Body</td>
					<td></td>
				</tr>
				<tr>
					<td>{{$survey_study->type_of_waterbody}}</td>
					<td></td>
				</tr>
			</tbody>
		</table>
		
		<div class="tearhere">
			<hr class="tear">
		</div>
		
		<table class="table" width="100%" border="0" cellspacing="1" cellpadding="1">
			<tbody>
				<tr>
					<td colspan="2"><b>Limit of Survey</b></td>
				</tr>
				<tr>
					<td width="50%">Latitude</td>
					<td width="50%">Longitude</td>
				</tr>
				<tr>
					<td>{{$survey_study->lattitude}}</td>
					<td>{{$survey_study->longitude}}</td>
				</tr>
				<tr>
					<td>X Coordinates</td>
					<td>Y Coordinates</td>
				</tr>
				<tr>
					<td>{{$survey_study->x_coordinates}}</td>
					<td>{{$survey_study->y_coordinates}}</td>
				</tr>
			</tbody>
		</table>	
		
		<div class="tearhere">
			<hr class="tear">
		</div>
		
		<table class="table" width="100%" border="0" cellspacing="1" cellpadding="1">
			<tbody>
				<tr>
					<td width="50%">Whether Topographic survey required</td>
					<td width="50%">Method to be adopted for Topographic survey</td>
				</tr>
				<tr>
					<td>{{$survey_study->whether_topographic_survey_required}}</td>
					<td>{{$survey_study->methods_to_be_adopted_for_topographic_survey}}</td>
				</tr>
				<tr>
					<td>Instruments to be used for Topographic survey</td>
					<td>Availability of previous shoreline data</td>
				</tr>
				<tr>
					<td>{{$survey_study->instruments_to_be_used_for_topographic_survey}}</td>
					<td>{{$survey_study->availability_of_previous_shoreline_data}}</td>
				</tr>
				<tr>
					<td>Accessibility of shoreline</td>
					<td>Nature of shore</td>
				</tr>
				<tr>
					<td>{{$survey_study->availability_of_shoreline}}</td>
					<td>{{$survey_study->nature_of_shore}}</td>
				</tr>
				<tr>
					<td>Bathymetric Area</td>
					<td>Scale of Survey planned</td>
				</tr>
				<tr>
					<td>{{$survey_study->bathymetric_area}}</td>
					<td>{{$survey_study->scale_of_survey_planned}}</td>
				</tr>
				<tr>
					<td>Method adopted for bathymetric survey</td>
					<td>Is manual Survey require</td>
				</tr>
				<tr>
					<td>{{$survey_study->method_adopted_for_bathymetric_survey}}</td>
					<td>{{$survey_study->is_manual_survey_required}}</td>
				</tr>
			</tbody>
		</table>
		
		<div class="tearhere">
			<hr class="tear">
		</div>
		
		<table class="table" width="100%" border="0" cellspacing="1" cellpadding="1">
			<tbody>
				<tr>
					<td width="50%">Line interval planned for survey</td>
					<td width="50%">Type of Survey vessel that can be used for bathymetric survey</td>
				</tr>
				<tr>
					<td>{{$survey_study->line_interval_planned_for_survey}}</td>
					<td>{{$survey_study->type_of_survey_vessel_used_for_bathymetric_survey}}</td>
				</tr>
				<tr>
					<td>Estimated period of survey work in days</td>
					<td>Instruments to be used for bathymetric survey</td>
				</tr>
				<tr>
					<td>{{$survey_study->estimated_period_of_survey_days}}</td>
					<td>{{$survey_study->instruments_to_be_used_for_bathymetric_survey}}</td>
				</tr>
				<tr>
					<td>Nearest available Benchmark detail</td>
					<td>Is Local Benchmark needs to be established</td>
				</tr>
				<tr>
					<td>{{$survey_study->nearest_available_benchmark_detail}}</td>
					<td>{{$survey_study->is_local_benchmark_needs_to_be_established}}</td>
				</tr>
				<tr>
					<td>Detailed report of the officer</td>
					<td>Presence and nature of obstructions in the survey area</td>
				</tr>
				<tr>
					<td>{{$survey_study->detailed_report_of_the_officer}}</td>
					<td>{{$survey_study->presence_and_nature_of_obstructions_in_survey}}</td>
				</tr>
				<tr>
					<td colspan="2">Details of location for setting tide pole</td>
				</tr>
				<tr>
					<td colspan="2">{{$survey_study->details_location_for_setting_tide_pole}}</td>
				</tr>
			</tbody>
		</table>	
		
		<div class="space">	</div>
		
	</body>
</html>