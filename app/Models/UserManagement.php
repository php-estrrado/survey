<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use DB;
class UserManagement extends Authenticatable
{
    use HasFactory, Notifiable;
    protected $table = 'usr_management';

    protected $fillable = ['fullname', 'admin_id', 'phone', 'email', 'designation', 'role', 'pen', 'avatar', 'institution', 'userparent', 'is_active', 'is_deleted', 'created_by', 'updated_by', 'created_at', 'updated_at'];
      
}
