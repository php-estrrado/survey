<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupportRequests extends Model{
    use HasFactory;
    public $table = 'support_requests';
    protected $fillable = ['from_id','to_id','title','description','is_active','is_deleted','created_by','updated_by','created_at','updated_at'];
}
