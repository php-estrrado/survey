<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tidal_observation extends Model{
    use HasFactory;
    public $table = 'tidal_observation';
    protected $fillable = ['cust_id','fname','designation','sector','department','firm','others','purpose','service','description','state','district','place','tidal_area_location','period_of_observation','benchmark_chart_datum','is_active','is_deleted','created_by','updated_by','created_at','updated_at','lattitude','longitude','x_coordinates','y_coordinates'];
}
