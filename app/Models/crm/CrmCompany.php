<?php

namespace App\Models\crm;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;
use App\Models\customer\CustomerAddressType;
use App\Models\SalesOrderAddress;
class CrmCompany extends Model
{
    use HasFactory;
    protected $table = 'crm_company';
    protected $guarded=[];
    
    
           
}
