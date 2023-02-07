<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cust_receipt extends Model{
    use HasFactory;
    public $table = 'cust_receipt';
    protected $fillable = ['survey_request_id','service_id','service_request_id','cust_id','receipt_image','is_active','is_deleted','created_by','updated_by','created_at','updated_at'];
}