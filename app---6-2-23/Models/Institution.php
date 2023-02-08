<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use DB;
class Institution extends Authenticatable
{
    use HasFactory, Notifiable;
    protected $table = 'institution';

    protected $fillable = ['institution_name', 'is_active','is_deleted','created_by','updated_by','created_at','updated_at'];
      
}
