<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Survey_request_logs extends Model{
    use HasFactory;
    public $table = 'survey_request_logs';
    protected $fillable = ['survey_request_id','cust_id','survey_status','remarks','is_active','is_deleted','created_by','updated_by','created_at','updated_at'];
}