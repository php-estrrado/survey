<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Survey_status extends Model{
    use HasFactory;
    public $table = 'survey_status';
    protected $fillable = ['status_name','is_active','is_deleted','created_by','updated_by','created_at','updated_at'];
}