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
use App\Models\customer\CustomerInfo;
use App\Models\UserVisit;
use App\Models\Underwater_videography;
use App\Models\Services;
use App\Models\Survey_requests;
use App\Models\Survey_request_logs;
use App\Models\AdminNotification;
use App\Rules\Name;
use Validator;
use App\Models\OrganisationType;
class UnderwatervideographyController extends Controller
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
        $data['title']        =  'Underwater videography service';
        $data['menu']         =  'Underwater videography service';

        return view('customer.underwater_videography.underwater_videography_survey',$data);
    }

    public function create()
    { 
        $data['title']        =  'Underwater videography service';
        $data['menu']         =  'Underwater videography service';
        $service              = 6; 
        $data['service']         =  $service;
        $data['services']     =  Services::where('is_deleted',0)->whereNotIn('id',[$service])->orderby('id','ASC')->get();
        $data['countries']    =  Country::where('is_deleted',0)->orderby('sortname','ASC')->get();
        $data['states']       =  State::where('is_deleted',0)->get();
        $data['cities']       =  City::where('is_deleted',0)->get();
$data['org_types']    = OrganisationType::selectOption();
        $cust_email = Admin::where('id',auth()->user()->id)->first()->email;
        $cust_id = CustomerMaster::where('username',$cust_email)->first()->id;
        $cust_info = CustomerInfo::where('cust_id',$cust_id)->first();  
        $data['cust_info']    = $cust_info;  
        // dd($data);
        return view('customer.underwater_videography.underwatervideographysurvey_form',$data);
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
            'description' => ['required'],
            'state' => ['required'],
            'district' => ['required'],
            'place' => ['required'],
            'survey_area_location' => ['required'],
            'type_of_waterbody' => ['required']
        ]);

        if($validator->passes())
        {
            $underwater_videography = [];

            $underwater_videography['cust_id'] = $cust_id;
            $underwater_videography['fname'] = $input['fname'];
            $underwater_videography['designation'] = $input['designation'];
            $underwater_videography['sector'] = $input['sector'];
            $underwater_videography['department'] = $input['department'];
            $underwater_videography['firm'] = $input['firm'];
            $underwater_videography['others'] = $input['others'];
            $underwater_videography['purpose'] = $input['purpose'];
            $underwater_videography['service'] = $input['service'];
            $underwater_videography['description'] = $input['description'];
            $underwater_videography['state'] = $input['state'];
            $underwater_videography['district'] = $input['district'];
            $underwater_videography['place'] = $input['place'];
            $underwater_videography['survey_area_location'] = $input['survey_area_location'];
            $underwater_videography['type_of_waterbody'] = $input['type_of_waterbody'];
                        $underwater_videography['lattitude'] = $input['lattitude'];
            $underwater_videography['longitude'] = $input['longitude'];
            $underwater_videography['x_coordinates'] = $input['x_coordinates'];
            $underwater_videography['y_coordinates'] = $input['y_coordinates'];
            $underwater_videography['is_active'] = 1;
            $underwater_videography['is_deleted'] = 0;
            $underwater_videography['created_by'] = auth()->user()->id;
            $underwater_videography['updated_by'] = auth()->user()->id;
            $underwater_videography['created_at'] = date('Y-m-d H:i:s');
            $underwater_videography['updated_at'] = date('Y-m-d H:i:s');

            if($input['additional_services'])
            {
                
               $underwater_videography['additional_services'] = implode(",", $input['additional_services']); 
            }else{
                $underwater_videography['additional_services'] = "";
            }

            $underwater_videography_id = Underwater_videography::create($underwater_videography)->id;

            $survey_request = [];

            $survey_request['cust_id'] = $cust_id;
            $survey_request['service_id'] = $input['service'];
            $survey_request['service_request_id'] = $underwater_videography_id;
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

            if(isset($underwater_videography_id) && isset($survey_request_id))
            {   
                Session::flash('message', ['text'=>'Survey Requested Submitted Successfully !','type'=>'success']);  
            }
            else
            {
                Session::flash('message', ['text'=>'Survey Requested Not Submitted !','type'=>'danger']);
            }

            return redirect(route('customer.underwater_videography'));
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
