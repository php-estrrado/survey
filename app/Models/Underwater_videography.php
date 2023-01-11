<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Underwater_videography extends Model{
    use HasFactory;
    public $table = 'underwater_videography';
    protected $fillable = ['cust_id','fname','designation','sector','department','firm','others','purpose','service','description','state','district','place','survey_area_location','type_of_waterbody','is_active','is_deleted','created_by','updated_by','created_at','updated_at'];
}
