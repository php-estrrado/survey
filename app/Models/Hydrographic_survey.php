<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hydrographic_survey extends Model{
    use HasFactory;
    public $table = 'hydrographic_survey';
    protected $fillable = ['cust_id','fname','designation','sector','department','firm','others','purpose','service','description','state','district','place','survey_area_location','type_of_waterbody','area_of_survey','scale_of_survey','service_to_be_conducted','interim_surveys_needed_infuture','benchmark_chart_datum','is_active','is_deleted','created_by','updated_by','created_at','updated_at','lattitude','longitude','x_coordinates','y_coordinates','additional_services','data_collection_equipments'];
}
