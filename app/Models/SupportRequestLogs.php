<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupportRequestLogs extends Model{
    use HasFactory;
    public $table = 'support_request_logs';
    protected $fillable = ['support_id','from_role_id','to_role_id','user_id','to_user_id','comment','is_active','is_deleted','created_by','updated_by','created_at','updated_at'];
}
