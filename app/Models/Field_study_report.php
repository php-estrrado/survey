<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Field_study_report extends Model{
    use HasFactory;
    public $table = 'field_study_report';
    protected $fillable = ['survey_request_id','service_id','service_request_id','cust_id','datetime_inspection','survey_department_name','officer_participating_field_inspection','from_hsw','location','type_of_waterbody','limit_of_survey_area','whether_topographic_survey_required','methods_to_be_adopted_for_topographic_survey','instruments_to_be_used_for_topographic_survey','availability_of_previous_shoreline_data','availability_of_shoreline','nature_of_shore','bathymetric_area','scale_of_survey_planned','method_adopted_for_bathymetric_survey','is_manual_survey_required','line_interval_planned_for_survey','type_of_survey_vessel_used_for_bathymetric_survey','estimated_period_of_survey_days','instruments_to_be_used_for_bathymetric_survey','nearest_available_benchmark_detail','is_local_benchmark_needs_to_be_established','detailed_report_of_the_officer','remarks','presence_and_nature_of_obstructions_in_survey','details_location_for_setting_tide_pole','upload_photos_of_study_area','is_active','is_deleted','created_by','updated_by','created_at','updated_at','lattitude','longitude','x_coordinates','y_coordinates','is_submitted','submitted_at'];
}