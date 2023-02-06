<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dredging_survey extends Model{
    use HasFactory;
    public $table = 'dredging_survey';
    protected $fillable = ['cust_id','fname','designation','sector','department','firm','others','purpose','service','description','state','district','place','survey_area_location','detailed_description_area	','dredging_survey_method','interim_survey','dredging_quantity_calculation','method_volume_calculation','length','width','depth','is_active','is_deleted','created_by','updated_by','created_at','updated_at','lattitude','longitude','x_coordinates','y_coordinates','additional_services'];
}
