<?php

namespace App\Models\customer;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\customer\CustomerAddress;
use App\Models\customer\CustomerAddressType;
use App\Models\Survey_requests;

class CustomerMaster extends Model
{
    use HasFactory;
    protected $table = 'cust_mst';
    protected $fillable = ['username', 'email', 'phone','is_active','is_deleted','created_by','updated_by','created_at','updated_at'];
    public function telecom_ph($user_id){ return CustomerTelecom::where('user_id',$user_id)->where('usr_telecom_typ_id',2)->where('is_active',1)->where('is_deleted',0)->first(); }
    public function telecom_email($user_id){ return CustomerTelecom::where('user_id',$user_id)->where('usr_telecom_typ_id',1)->where('is_active',1)->where('is_deleted',0)->first(); }

    public function info(){
    return $this->hasOne(CustomerInfo::class, 'user_id', 'id');
}

    public function user_address($user_id,$default=''){ 
        
    $addr = CustomerAddress::getUserAddress($user_id,$default);
    return $addr;
    }
    
    public function user_address_sale($user_id,$sale=''){ 
        
    $addr = CustomerAddress::getUserAddress_sale($user_id,$sale);
    return $addr;
    }

    public function customer_request()
    {
        return $this->hasMany(Survey_requests::class,'cust_id','id')->first();
    }
}
