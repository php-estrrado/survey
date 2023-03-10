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
use App\Models\Topographic_survey;
use App\Models\Services;
use App\Models\Survey_requests;
use App\Models\Survey_request_logs;
use App\Models\AdminNotification;
use App\Rules\Name;
use Validator;
use App\Models\OrganisationType;
class TopographicsurveyController extends Controller
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
        $data['title']        =  'Topographic survey';
        $data['menu']         =  'Topographic survey';

        return view('customer.topographic_survey.topographic_survey',$data);
    }

    public function create()
    { 
        $data['title']        =  'Topographic survey';
        $data['menu']         =  'Topographic survey';
        $service              = 9; 
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
        return view('customer.topographic_survey.topographicsurvey_form',$data);
    }

    public function saveSurvey(Request $request)
    {
        $input = $request->all();
        // dd($input);

        $cust_email = Admin::where('id',auth()->user()->id)->first()->email;
        $cust_id = CustomerMaster::where('username',$cust_email)->first()->id;

        if($input['id'] > 0)
        {
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
                'area_to_survey' => ['required'],
                'scale_of_survey' => ['required']
            ]);
    
            if($validator->passes())
            {
                $topographic_survey = [];
    
                $topographic_survey['cust_id'] = $cust_id;
                $topographic_survey['fname'] = $input['fname'];
                $topographic_survey['designation'] = $input['designation'];
                $topographic_survey['sector'] = $input['sector'];
                $topographic_survey['department'] = $input['department'];
                $topographic_survey['firm'] = $input['firm'];
                $topographic_survey['others'] = $input['others'];
                $topographic_survey['purpose'] = $input['purpose'];
                $topographic_survey['service'] = $input['service'];
                $topographic_survey['description'] = $input['description'];
                $topographic_survey['state'] = $input['state'];
                $topographic_survey['district'] = $input['district'];
                $topographic_survey['place'] = $input['place'];
                $topographic_survey['location'] = $input['survey_area_location'];
                $topographic_survey['area_to_survey'] = $input['area_to_survey'];
                $topographic_survey['scale_of_survey'] = $input['scale_of_survey'];
                $topographic_survey['lattitude'] = $input['lattitude'];
                $topographic_survey['longitude'] = $input['longitude'];
                $topographic_survey['x_coordinates'] = $input['x_coordinates'];
                $topographic_survey['y_coordinates'] = $input['y_coordinates'];
                $topographic_survey['is_active'] = 1;
                $topographic_survey['is_deleted'] = 0;
                $topographic_survey['created_by'] = auth()->user()->id;
                $topographic_survey['updated_by'] = auth()->user()->id;
                $topographic_survey['created_at'] = date('Y-m-d H:i:s');
                $topographic_survey['updated_at'] = date('Y-m-d H:i:s');
    
                if(isset($input['additional_services']))
                {
                    
                   $topographic_survey['additional_services'] = implode(",", $input['additional_services']); 
                }else{
                    $topographic_survey['additional_services'] = "";
                }
    
    
                Topographic_survey::where('id',$input['id'])->update($topographic_survey);
    
                $survey_request = [];
    
                $survey_request['cust_id'] = $cust_id;
                $survey_request['service_id'] = $input['service'];
                $survey_request['service_request_id'] = $input['id'];
                $survey_request['request_status'] = 1;
                $survey_request['is_active'] = 1;
                $survey_request['is_deleted'] = 0;
                $survey_request['created_by'] = auth()->user()->id;
                $survey_request['updated_by'] = auth()->user()->id;
                $survey_request['created_at'] = date('Y-m-d H:i:s');
                $survey_request['updated_at'] = date('Y-m-d H:i:s');
    
                Survey_requests::where('id',$input['survey_request_id'])->update($survey_request);
    
                $admin_noti = [];
    
                $admin_noti['notify_from'] = $cust_id;
                $admin_noti['notify_to'] = 1;
                $admin_noti['role_id'] = 1;
                $admin_noti['notify_from_role_id'] = 6;
                $admin_noti['notify_type'] = 'survey_resubmit';
                $admin_noti['title'] = 'Survey Request Re-Submitted - HSW'.$input['survey_request_id'];
                $admin_noti['description'] = 'Survey Request Re-Submitted - HSW'.$input['survey_request_id'];
                $admin_noti['ref_id'] = $cust_id;
                $admin_noti['ref_link'] = '/superadmin/new_service_request_detail/'.$input['survey_request_id'];
                $admin_noti['viewed'] = 0;
                $admin_noti['created_at'] = date('Y-m-d H:i:s');
                $admin_noti['updated_at'] = date('Y-m-d H:i:s');
                $admin_noti['deleted_at'] = date('Y-m-d H:i:s');
    
                AdminNotification::create($admin_noti);

                Session::flash('message', ['text'=>'Survey Requested Updated Successfully !','type'=>'success']);
    
                return redirect(route('customer.topographic_survey'));
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
        else
        {
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
                'area_to_survey' => ['required'],
                'scale_of_survey' => ['required']
            ]);
    
            if($validator->passes())
            {
                $topographic_survey = [];
    
                $topographic_survey['cust_id'] = $cust_id;
                $topographic_survey['fname'] = $input['fname'];
                $topographic_survey['designation'] = $input['designation'];
                $topographic_survey['sector'] = $input['sector'];
                $topographic_survey['department'] = $input['department'];
                $topographic_survey['firm'] = $input['firm'];
                $topographic_survey['others'] = $input['others'];
                $topographic_survey['purpose'] = $input['purpose'];
                $topographic_survey['service'] = $input['service'];
                $topographic_survey['description'] = $input['description'];
                $topographic_survey['state'] = $input['state'];
                $topographic_survey['district'] = $input['district'];
                $topographic_survey['place'] = $input['place'];
                $topographic_survey['location'] = $input['survey_area_location'];
                $topographic_survey['area_to_survey'] = $input['area_to_survey'];
                $topographic_survey['scale_of_survey'] = $input['scale_of_survey'];
                $topographic_survey['lattitude'] = $input['lattitude'];
                $topographic_survey['longitude'] = $input['longitude'];
                $topographic_survey['x_coordinates'] = $input['x_coordinates'];
                $topographic_survey['y_coordinates'] = $input['y_coordinates'];
                $topographic_survey['is_active'] = 1;
                $topographic_survey['is_deleted'] = 0;
                $topographic_survey['created_by'] = auth()->user()->id;
                $topographic_survey['updated_by'] = auth()->user()->id;
                $topographic_survey['created_at'] = date('Y-m-d H:i:s');
                $topographic_survey['updated_at'] = date('Y-m-d H:i:s');
    
                if(isset($input['additional_services']))
                {
                    
                   $topographic_survey['additional_services'] = implode(",", $input['additional_services']); 
                }else{
                    $topographic_survey['additional_services'] = "";
                }
    
    
                $topographic_survey_id = Topographic_survey::create($topographic_survey)->id;
    
                $survey_request = [];
    
                $survey_request['cust_id'] = $cust_id;
                $survey_request['service_id'] = $input['service'];
                $survey_request['service_request_id'] = $topographic_survey_id;
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
                $admin_noti['notify_type'] = 'survey_request';
                $admin_noti['title'] = 'Survey Request Submitted - HSW'.$survey_request_id;
                $admin_noti['description'] = 'Survey Request Submitted - HSW'.$survey_request_id;
                $admin_noti['ref_id'] = $cust_id;
                $admin_noti['ref_link'] = '/superadmin/new_service_request_detail/'.$survey_request_id;
                $admin_noti['viewed'] = 0;
                $admin_noti['created_at'] = date('Y-m-d H:i:s');
                $admin_noti['updated_at'] = date('Y-m-d H:i:s');
                $admin_noti['deleted_at'] = date('Y-m-d H:i:s');
    
                AdminNotification::create($admin_noti);
    
                if(isset($topographic_survey_id) && isset($survey_request_id))
                {   
                    Session::flash('message', ['text'=>'Survey Requested Submitted Successfully !','type'=>'success']);  
                }
                else
                {
                    Session::flash('message', ['text'=>'Survey Requested Not Submitted !','type'=>'danger']);
                }
    
                return redirect(route('customer.topographic_survey'));
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
}
