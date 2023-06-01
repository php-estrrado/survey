<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Session;
use DB;
use Mail;
use App\Models\Country;
use App\Models\Modules;
use App\Models\UserRoles;
use App\Models\Admin;
use App\Models\UserRole;
use App\Models\customer\CustomerMaster;
use App\Models\customer\CustomerInfo;
use App\Models\customer\CustomerSecurity;
use App\Models\customer\CustomerTelecom;
use App\Models\customer\CustomerAddress;
use App\Models\customer\CustomerPoints;
use App\Models\Survey_requests;
use App\Rules\Name;
use App\Models\Reward;
use App\Models\CustomerWallet_Model;
use Validator;
use Illuminate\Support\Facades\Hash;
use GuzzleHttp\Client;

class CustomerController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }


    public function index($type=NULL)
    {
        $data['title']              =   'Customer';
        $data['menu']               =   'Customer List';
        $data['role']               =    UserRole::where('is_deleted',NULL)->orWhere('is_deleted',0)->where('usr_role_name','Customer')->where('is_active',1)->get();
        if(isset($type) && $type=='today')
        {
            // $data['customer']           =    CustomerMaster::where('is_deleted',NULL)->orWhere('is_deleted',0)->whereDate('created_at', '=', date('Y-m-d'))->orderBy('id','DESC')->get();    
        }
        else
        {
            $data['customers'] = DB::table('cust_mst')
                ->join('cust_info', 'cust_mst.id', '=', 'cust_info.cust_id')
                ->join('cust_telecom', 'cust_mst.id', '=', 'cust_telecom.cust_id')
                ->where('cust_mst.is_deleted',NULL)->orWhere('cust_mst.is_deleted',0)
                ->where('cust_telecom.is_deleted',NULL)->orWhere('cust_telecom.is_deleted',0)->where('cust_telecom.telecom_type',2)
                ->select('cust_mst.*','cust_info.*', 'cust_telecom.*')
                ->orderBy('cust_mst.id','DESC')
                ->get();
        
            // dd($data);
        
            // $data['customer']           =    CustomerMaster::where('is_deleted',NULL)->orWhere('is_deleted',0)->orderBy('id','DESC')->get();
        }
        
        // $data['countries']          =    Country::all();
        return view('admin.customer.customers', $data);
    }

    public function createCustomers()
    {
        $data['title']      =   'Add Customer';
        $data['menu']       =   'add-customer';
        $data['countries']  =   Country::where('is_deleted',0)->get();

        // dd($data);
        return view('admin.customer.add-customers',$data);
    }

    public function customerSave(Request $request)
    {
        $input = $request->all();
        // dd($input);

        $validator = Validator::make($request->all(), [
            'full_name'=>['required','regex:/^[a-zA-Z\s]*$/'],
            'firm'=>['required','max:255','regex:/^[a-zA-Z\s]*$/'],
            'firm_type'=>['required'],
            'email' => ['required','email','max:255','unique:admins,email'],
            'mobile'=>['required','numeric','digits:10'],
            'valid_id'=>['required','regex:/^[a-zA-Z0-9\s]*$/'],
            'id_file_front' => ['required','max:10000','mimes:jpeg,png,jpg,jiff,pdf'],
            'id_file_back' => ['required','max:10000','mimes:jpeg,png,jpg,jiff,pdf'],
            'password' =>['required','confirmed','min:6','max:20','regex:/^[a-zA-Z0-9\s.,@&*()]*$/'],
            'password_confirmation' =>['required','min:6','max:20','regex:/^[a-zA-Z0-9\s.,@&*()]*$/']
        ]);

        if($validator->passes())
        {
            $master = CustomerMaster::create([
                'username' => $request->email,
                'is_active'=>1,
                'is_deleted'=>0,
                'created_by'=>auth()->user()->id,
                'updated_by'=>auth()->user()->id,
                'created_at'=>date("Y-m-d H:i:s"),
                'updated_at'=>date("Y-m-d H:i:s")
            ]);
            $masterId = $master->id;

            $info_id = CustomerInfo::create([
                'cust_id' => $masterId,
                'name' => $request->full_name,
                'valid_id' => $request->valid_id,
                'firm' => $request->firm,
                'firm_type' => $request->firm_type,
                'is_active'=>1,
                'is_deleted'=>0,
                'created_by'=>auth()->user()->id,
                'updated_by'=>auth()->user()->id,
                'created_at'=>date("Y-m-d H:i:s"),
                'updated_at'=>date("Y-m-d H:i:s")
            ])->id;

            $security = CustomerSecurity::create([
                'cust_id' => $masterId,
                'password' => Hash::make($request->password),
                'is_active'=>1,
                'is_deleted'=>0,
                'created_by'=>auth()->user()->id,
                'updated_by'=>auth()->user()->id,
                'created_at'=>date("Y-m-d H:i:s"),
                'updated_at'=>date("Y-m-d H:i:s")
            ]);

            $telecom_email = CustomerTelecom::create([
                'cust_id' => $masterId,
                'telecom_type' =>1,
                'cust_telecom_value' => $request->email,
                'is_active'=>1,
                'is_deleted'=>0,
                'created_by'=>auth()->user()->id,
                'updated_by'=>auth()->user()->id,
                'created_at'=>date("Y-m-d H:i:s"),
                'updated_at'=>date("Y-m-d H:i:s")
            ]);
            $tele_email_id = $telecom_email->id;

            $telecom_mobile = CustomerTelecom::create([
                'cust_id' => $masterId,
                'telecom_type' =>2,
                'cust_telecom_value' => $request->mobile,
                'is_active'=>1,
                'is_deleted'=>0,
                'created_by'=>auth()->user()->id,
                'updated_by'=>auth()->user()->id,
                'created_at'=>date("Y-m-d H:i:s"),
                'updated_at'=>date("Y-m-d H:i:s")
            ]);
            $tele_mobile_id = $telecom_mobile->id;

            CustomerMaster::where('id',$masterId)->update([
                'email'=>$tele_email_id,
                'phone'=>$tele_mobile_id
            ]);

            Admin::create([
                'fname' => $request->full_name,
                'email' =>$request->email,
                'phone' => $request->mobile,
                'password' => Hash::make($request->password),
                'role_id' => 6,
                'is_active'=>1,
                'is_deleted'=>0,
                'created_by'=>auth()->user()->id,
                'updated_by'=>auth()->user()->id,
                'created_at'=>date("Y-m-d H:i:s"),
                'updated_at'=>date("Y-m-d H:i:s")
            ]);
            if($request->hasfile('id_file_front'))
            {
                $file = $request->id_file_front;
                $folder_name = "uploads/customer_document/" . date("Ym", time()) . '/'.date("d", time()).'/';

                $upload_path = base_path() . '/public/' . $folder_name;

                $extension = strtolower($file->getClientOriginalExtension());

                $filename = "customer_id_front" . '_' . time() . '.' . $extension;

                $file->move($upload_path, $filename);

                $file_path = "/public/$folder_name/$filename";

                CustomerInfo::where('id',$info_id)->update([
                    'id_file_front' => $file_path,
                    'updated_by'=>auth()->user()->id,
                    'updated_at'=>date("Y-m-d H:i:s")
                ]);
            }
            if($request->hasfile('id_file_back'))
            {
                $file = $request->id_file_back;
                $folder_name = "uploads/customer_document/" . date("Ym", time()) . '/'.date("d", time()).'/';

                $upload_path = base_path() . '/public/' . $folder_name;

                $extension = strtolower($file->getClientOriginalExtension());

                $filename = "customer_id_back" . '_' . time() . '.' . $extension;

                $file->move($upload_path, $filename);

                $file_path = "/public/$folder_name/$filename";

                CustomerInfo::where('id',$info_id)->update([
                    'id_file_back' => $file_path,
                    'updated_by'=>auth()->user()->id,
                    'updated_at'=>date("Y-m-d H:i:s")
                ]);
            }

            if($masterId)
            {   
                Session::flash('message', ['text'=>'Customer Created Successfully !','type'=>'success']);  
            }
            else
            {
                Session::flash('message', ['text'=>'Customer Not Created Successfully !','type'=>'danger']);
            }

            return redirect('/admin/customers');
        }
        else
        {
            return redirect()->back()->withErrors($validator)->withInput($request->all());
        }
        
    }

    public function viewCustomer($id)
    {
        $data['title']              =   'Customer Info';
        $data['menu']               =   'Customer Details';
        $data['customer_mst']       =    CustomerMaster::where('is_deleted',0)->where('id',$id)->first();
        $data['telecom']            =    CustomerTelecom::where('cust_id',$id)->where('is_deleted',0)->where('telecom_type',2)->first();
        $data['info']               =    CustomerInfo::where('cust_id',$id)->where('is_deleted',0)->first();

        $data['requested_services']  =  DB::table('survey_requests')
                                        ->leftjoin('services', 'survey_requests.service_id', '=', 'services.id')
                                        ->leftjoin('survey_status', 'survey_requests.request_status', '=', 'survey_status.id')
                                        ->where('survey_requests.cust_id',$id)->where('survey_requests.is_active',1)->where('survey_requests.is_deleted',0)
                                        ->where('services.is_active',1)->where('services.is_deleted',0)
                                        ->select('survey_requests.id AS survey_id','survey_requests.created_at AS survey_date','survey_requests.*','services.*','survey_status.status_name AS current_status')
                                        ->orderBy('survey_requests.id','DESC')
                                        ->get();
        
        // dd($data);

        return view('admin.customer.customer_details', $data);
    }
}
