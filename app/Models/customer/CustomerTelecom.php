<?php

namespace App\Models\Customer;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerTelecom extends Model
{
    use HasFactory;
    protected $table = 'cust_telecom';
    protected $fillable = ['cust_id', 'telecom_type','cust_telecom_value','is_active','is_deleted','created_by','updated_by','created_at','updated_at'];
}
