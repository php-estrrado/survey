<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Services extends Model{
    use HasFactory;
    public $table = 'services';
    protected $fillable = ['service_name','service_description','service_terms','image','is_active','is_deleted','created_by','updated_by','created_at','updated_at'];
}
