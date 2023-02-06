<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UsrNotification extends Model
{
    use HasFactory;
    public $table = 'usr_notifications';
    protected $fillable = ['notify_from','notify_to','role_id','notify_from_role_id','notify_type','title','description','icon','ref_id','ref_link','viewed','created_at','updated_at','deleted_at'];
}