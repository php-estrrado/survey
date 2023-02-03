<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Topographic_survey extends Model{
    use HasFactory;
    public $table = 'topographic_survey';
    protected $fillable = ['cust_id','fname','designation','sector','department','firm','others','purpose','service','description','state','district','place','location','area_to_survey','scale_of_survey','is_active','is_deleted','created_by','updated_by','created_at','updated_at','lattitude','longitude','x_coordinates','y_coordinates'];
}
