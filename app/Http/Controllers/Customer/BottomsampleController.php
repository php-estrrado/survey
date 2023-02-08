<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Mail;
use Session;
use DB;
use App\Models\Country;
use App\Models\State;
use App\Models\Admin;
use App\Models\City;
use App\Models\customer\CustomerMaster;
use App\Models\UserVisit;
use App\Models\Bottom_sample_collection;
use App\Models\Services;
use App\Models\Survey_requests;
use App\Models\Survey_request_logs;
use App\Models\AdminNotification;
use App\Rules\Name;
use Validator;
use App\Models\OrganisationType;
class BottomsampleController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index()
    {
        $data['title']        =  'Bottom sample collection';
        $data['menu']         =  'Bottom sample collection';

        return view('customer.bottomsample.bottom_sample',$data);
    }
    public function create()
    { 
        $data['title']        =  'Bottom sample collection';
        $data['menu']         =  'Bottom sample collection';
        $service              = 3; 
        $data['service']         =  $service;
        $data['services']     =  Services::where('is_deleted',0)->whereNotIn('id',[$service])->orderby('id','ASC')->get();
        $data['countries']    =  Country::where('is_deleted',0)->orderby('sortname','ASC')->get();
        $data['states']       =  State::where('is_deleted',0)->get();
        $data['cities']       =  City::where('is_deleted',0)->get();
        $data['org_types']    = OrganisationType::selectOption();
        // dd($data);
        return view('customer.bottomsample.bottomsample_form',$data);
    }

    public function saveSurvey(Request $request)
    {
        $input = $request->all();
        
        // dd($input);

        $cust_email = Admin::where('id',auth()->user()->id)->first()->email;
        $cust_id = CustomerMaster::where('username',$cust_email)->first()->id;

        $validator = Validator::make($request->all(), [
            'fname'=>['required','max:255'],
            'designation'=>['required','max:255'],
            'sector'=>['required'],
            'department' => ['required'],
            'firm' => ['required'],
            'purpose' => ['required'],
            'service_id' => ['required'],
            'description' => ['required'],
            'state' => ['required'],
            'district' => ['required'],
            'place' => ['required'],
            // 'depth_at_saples_collected' => ['required'],
            'number_of_locations' => ['required'],
            'quantity_of_samples' => ['required'],
        ]);

        if($validator->passes())
        {
            $bottomsample = [];

            $bottomsample['cust_id'] = $cust_id;
            $bottomsample['fname'] = $input['fname'];
            $bottomsample['designation'] = $input['designation'];
            $bottomsample['sector'] = $input['sector'];
            $bottomsample['department'] = $input['department'];
            $bottomsample['firm'] = $input['firm'];
            $bottomsample['others'] = $input['others'];
            $bottomsample['purpose'] = $input['purpose'];
            $bottomsample['service'] = $input['service_id'];
            $bottomsample['description'] = $input['description'];
            $bottomsample['state'] = $input['state'];
            $bottomsample['district'] = $input['district'];
            $bottomsample['place'] = $input['place'];
            // $bottomsample['depth_at_saples_collected'] = $input['depth_at_saples_collected'];
            $bottomsample['number_of_locations'] = $input['number_of_locations'];
            $bottomsample['quantity_of_samples'] = $input['quantity_of_samples'];
            $bottomsample['lattitude'] = $input['lattitude'];
            $bottomsample['longitude'] = $input['longitude'];
            $bottomsample['x_coordinates'] = $input['x_coordinates'];
            $bottomsample['y_coordinates'] = $input['y_coordinates'];
            $bottomsample['is_active'] = 1;
            $bottomsample['is_deleted'] = 0;
            $bottomsample['created_by'] = auth()->user()->id;
            $bottomsample['updated_by'] = auth()->user()->id;
            $bottomsample['created_at'] = date('Y-m-d H:i:s');
            $bottomsample['updated_at'] = date('Y-m-d H:i:s');

             if($input['additional_services'])
            {
                
               $bottomsample['additional_services'] = implode(",", $input['additional_services']); 
            }else{
                $bottomsample['additional_services'] = "";
            }

            $bottomsample['interval_bottom_sample'] = $input['interval_bottom_sample'];
            $bottomsample['quantity_bottom_sample'] = $input['quantity_bottom_sample'];
            $bottomsample['method_of_sampling'] = $input['method_of_sampling'];
            $bottomsample['description_of_requirement'] = $input['description_of_requirement'];

            $file_upload               =   $request->file('file_upload');
             if($file_upload){ 
            $fileName            =  'bottom_sample_'.time().'.'.$file_upload->getClientOriginalExtension();
            $sheetTitle = $file_upload->getClientOriginalName();
            
            $file_path = '/app/public/uploads/bottom_sample/'.$fileName;
            $destinationPath    =   storage_path('/app/public/uploads/bottom_sample/');
            $file_upload->move($destinationPath, $fileName);
             }else{
                $file_path = "";
             }

            $bottomsample['file_upload'] = $file_path;

            $bottomsample_id = Bottom_sample_collection::create($bottomsample)->id;

            $survey_request = [];

            $survey_request['cust_id'] = $cust_id;
            $survey_request['service_id'] = $input['service_id'];
            $survey_request['service_request_id'] = $bottomsample_id;
            $survey_request['request_status'] = 1;
            $survey_request['is_active'] = 1;
            $survey_request['is_deleted'] = 0;
            $survey_request['created_by'] = auth()->user()->id;
            $survey_request['updated_by'] = auth()->user()->id;
            $survey_request['created_at'] = date('Y-m-d H:i:s');
            $survey_request['updated_at'] = date('Y-m-d H:i:s');

            $survey_request_id = Survey_requests::create($survey_request)->id;

            $survey_request_logs = [];

            $survey_request_logs['survey_request_id'] = $survey_request_id;
            $survey_request_logs['cust_id'] = $cust_id;
            $survey_request_logs['survey_status'] = 1;
            $survey_request_logs['is_active'] = 1;
            $survey_request_logs['is_deleted'] = 0;
            $survey_request_logs['created_by'] = auth()->user()->id;
            $survey_request_logs['updated_by'] = auth()->user()->id;
            $survey_request_logs['created_at'] = date('Y-m-d H:i:s');
            $survey_request_logs['updated_at'] = date('Y-m-d H:i:s');

            Survey_request_logs::create($survey_request_logs);

            $admin_noti = [];

            $admin_noti['notify_from'] = $cust_id;
            $admin_noti['notify_to'] = 1;
            $admin_noti['role_id'] = 1;
            $admin_noti['notify_from_role_id'] = 6;
            $admin_noti['notify_type'] = 0;
            $admin_noti['title'] = 'Survey Request Submitted';
            $admin_noti['ref_id'] = $cust_id;
            $admin_noti['ref_link'] = '/superadmin/new_service_request_detail/'.$survey_request_id;
            $admin_noti['viewed'] = 0;
            $admin_noti['created_at'] = date('Y-m-d H:i:s');
            $admin_noti['updated_at'] = date('Y-m-d H:i:s');
            $admin_noti['deleted_at'] = date('Y-m-d H:i:s');

            AdminNotification::create($admin_noti);

            if(isset($bottomsample_id) && isset($survey_request_id))
            {   
                Session::flash('message', ['text'=>'Survey Requested Submitted Successfully !','type'=>'success']);  
            }
            else
            {
                Session::flash('message', ['text'=>'Survey Requested Not Submitted !','type'=>'danger']);
            }

            return redirect(route('customer.bottomsample'));
        }
        else
        {
            foreach($validator->messages()->getMessages() as $k=>$row)
            {
                $error[$k] = $row[0];
                Session::flash('message', ['text'=>$row[0],'type'=>'danger']);
            }
                
            return back()->withErrors($validator)->withInput($request->all());
        }
    }    
}