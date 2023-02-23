<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fieldstudy_eta extends Model{
    use HasFactory;
    public $table = 'fieldstudy_eta';
    protected $fillable = ['survey_request_id','general_area','location','no_of_days_required','scale_of_survey_recomended','type_of_survey','charges','recipient','is_active','is_deleted','created_by','updated_by','created_at','updated_at'];

    public function generalarea_name()
    {
        return $this->belongsTo(City::class,'general_area','id');
    }
}