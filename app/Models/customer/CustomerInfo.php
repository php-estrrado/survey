<?php

namespace App\Models\customer;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerInfo extends Model
{
    use HasFactory;
    protected $table = 'cust_info';
    protected $fillable = ['cust_id','name','firm','firm_type','valid_id','id_file_front','id_file_back','is_active','is_deleted','created_by','updated_by','created_at','updated_at'];
}
