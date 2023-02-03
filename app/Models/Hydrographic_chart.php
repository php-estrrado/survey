<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hydrographic_chart extends Model{
    use HasFactory;
    public $table = 'hydrographic_chart';
    protected $fillable = ['cust_id','fname','designation','sector','department','firm','others','purpose','service','description','state','district','place','survey_area_location','water_bodies','year_of_survey_chart','copies_required','copy_type','is_active','is_deleted','created_by','updated_by','created_at','updated_at','lattitude','longitude','x_coordinates','y_coordinates'];
}
