<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subbottom_profilling extends Model{
    use HasFactory;
    public $table = 'sub_bottom_profilling';
    protected $fillable = ['cust_id','fname','designation','sector','department','firm','others','purpose','service','description','state','district','place','location','area_to_scan','depth_of_area','interval','is_active','is_deleted','created_by','updated_by','created_at','updated_at','lattitude','longitude','x_coordinates','y_coordinates'];
}
