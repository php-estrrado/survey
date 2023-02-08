<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Currentmeter_observation extends Model{
    use HasFactory;
    public $table = 'current_meter_observation';
    protected $fillable = ['cust_id','fname','designation','sector','department','firm','others','purpose','service','description','state','district','place','survey_area_location','type_of_waterbody','observation_start_date','observation_end_date','is_active','is_deleted','created_by','updated_by','created_at','updated_at','lattitude','longitude','x_coordinates','y_coordinates','additional_services'];
}
