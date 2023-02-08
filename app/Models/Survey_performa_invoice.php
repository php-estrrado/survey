<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Survey_performa_invoice extends Model{
    use HasFactory;
    public $table = 'survey_performa_invoice';
    protected $fillable = ['survey_request_id','service_id','service_request_id','cust_id','bill_invoice_no','invoice_date','name_of_work','work_orderno_date','service_code','service_description','organization_name','payment_mode','survey_charges','survey_charges_words','receiver_name','receiver_address','state_code','gstin_unique_id','cgst_percentage','sgst_percentage','igst_percentage','cgst_amount','sgst_amount','igst_amount','total_tax_amount','total_tax_amount_words','total_invoice_amount','total_invoice_amount_words','is_active','is_deleted','created_by','updated_by','created_at','updated_at'];
}