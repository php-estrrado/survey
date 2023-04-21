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
use App\Models\Subbottom_profilling;
use App\Models\Services;
use App\Models\Survey_requests;
use App\Models\Survey_request_logs;
use App\Models\AdminNotification;
use App\Rules\Name;
use Validator;
use App\Models\OrganisationType;
class SubbottomprofillingController extends Controller
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
        $data['title']        =  'Sub bottom profilling';
        $data['menu']         =  'Sub bottom profilling';

        return view('customer.subbottom_profilling.subbottom_profilling',$data);
    }

    public function create()
    { 
        $data['title']        =  'Sub bottom profilling';
        $data['menu']         =  'Sub bottom profilling';
        $service              = 10; 
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
        return view('customer.subbottom_profilling.subbottomprofilling_form',$data);
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
                'fname'=>['required','regex:/^[a-zA-Z\s]*$/'],
                'designation'=>['required','regex:/^[a-zA-Z\s]*$/'],
                'sector'=>['required'],
                'department' => ['required','regex:/^[a-zA-Z\s]*$/'],
                'firm' => ['required'],
                'others' => ['nullable','regex:/^[a-zA-Z\s]*$/'],
                'purpose' => ['required','regex:/^[a-zA-Z\s]*$/'],
                'description' => ['required','regex:/^[a-zA-Z\s.,\-@&*()]*$/'],
                'state' => ['required'],
                'district' => ['required'],
                'place' => ['required','regex:/^[a-zA-Z\s]*$/'],
                'survey_area_location' => ['required','regex:/^[a-zA-Z\s]*$/'],
                'lattitude' => ['nullable','regex:/^[a-zA-Z0-9\s.,]*$/'],
                'longitude' => ['nullable','regex:/^[a-zA-Z0-9\s.,]*$/'],
                'x_coordinates' => ['nullable','regex:/^[a-zA-Z0-9\s.,]*$/'],
                'y_coordinates' => ['nullable','regex:/^[a-zA-Z0-9\s.,]*$/'],
                'area_to_scan' => ['required','regex:/^[0-9]*$/'],
                'depth_of_area' => ['required','regex:/^[0-9]*$/'],
                'interval' => ['required','regex:/^[0-9]*$/']
            ]);
    
            if($validator->passes())
            {
                $bottom_profilling = [];
    
                $bottom_profilling['cust_id'] = $cust_id;
                $bottom_profilling['fname'] = $input['fname'];
                $bottom_profilling['designation'] = $input['designation'];
                $bottom_profilling['sector'] = $input['sector'];
                $bottom_profilling['department'] = $input['department'];
                $bottom_profilling['firm'] = $input['firm'];
                $bottom_profilling['others'] = $input['others'];
                $bottom_profilling['purpose'] = $input['purpose'];
                $bottom_profilling['service'] = $input['service'];
                $bottom_profilling['description'] = $input['description'];
                $bottom_profilling['state'] = $input['state'];
                $bottom_profilling['district'] = $input['district'];
                $bottom_profilling['place'] = $input['place'];
                $bottom_profilling['location'] = $input['survey_area_location'];
                $bottom_profilling['area_to_scan'] = $input['area_to_scan'];
                $bottom_profilling['depth_of_area'] = $input['depth_of_area'];
                $bottom_profilling['interval'] = $input['interval'];
                $bottom_profilling['lattitude'] = $input['lattitude'];
                $bottom_profilling['longitude'] = $input['longitude'];
                $bottom_profilling['x_coordinates'] = $input['x_coordinates'];
                $bottom_profilling['y_coordinates'] = $input['y_coordinates'];
                $bottom_profilling['is_active'] = 1;
                $bottom_profilling['is_deleted'] = 0;
                $bottom_profilling['created_by'] = auth()->user()->id;
                $bottom_profilling['updated_by'] = auth()->user()->id;
                $bottom_profilling['created_at'] = date('Y-m-d H:i:s');
                $bottom_profilling['updated_at'] = date('Y-m-d H:i:s');
    
                if(isset($input['additional_services']))
                {
                    
                   $bottom_profilling['additional_services'] = implode(",", $input['additional_services']); 
                }else{
                    $bottom_profilling['additional_services'] = "";
                }
    
                Subbottom_profilling::where('id',$input['id'])->update($bottom_profilling);
    
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
                $admin_noti['title'] = 'Survey Request Re-Submitted';
                $admin_noti['description'] = 'Survey Request Re-Submitted - HSW'.$input['survey_request_id'];
                $admin_noti['ref_id'] = $cust_id;
                $admin_noti['ref_link'] = '/superadmin/new_service_request_detail/'.$input['survey_request_id'];
                $admin_noti['viewed'] = 0;
                $admin_noti['created_at'] = date('Y-m-d H:i:s');
                $admin_noti['updated_at'] = date('Y-m-d H:i:s');
                $admin_noti['deleted_at'] = date('Y-m-d H:i:s');
    
                AdminNotification::create($admin_noti);
    
                Session::flash('message', ['text'=>'Survey Requested Updated Successfully !','type'=>'success']);
    
                return redirect(route('customer.subbottom_profilling'));
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
                'fname'=>['required','regex:/^[a-zA-Z\s]*$/'],
                'designation'=>['required','regex:/^[a-zA-Z\s]*$/'],
                'sector'=>['required'],
                'department' => ['required','regex:/^[a-zA-Z\s]*$/'],
                'firm' => ['required'],
                'others' => ['nullable','regex:/^[a-zA-Z\s]*$/'],
                'purpose' => ['required','regex:/^[a-zA-Z\s]*$/'],
                'description' => ['required','regex:/^[a-zA-Z\s.,\-@&*()]*$/'],
                'state' => ['required'],
                'district' => ['required'],
                'place' => ['required','regex:/^[a-zA-Z\s]*$/'],
                'survey_area_location' => ['required','regex:/^[a-zA-Z\s]*$/'],
                'lattitude' => ['nullable','regex:/^[a-zA-Z0-9\s.,]*$/'],
                'longitude' => ['nullable','regex:/^[a-zA-Z0-9\s.,]*$/'],
                'x_coordinates' => ['nullable','regex:/^[a-zA-Z0-9\s.,]*$/'],
                'y_coordinates' => ['nullable','regex:/^[a-zA-Z0-9\s.,]*$/'],
                'area_to_scan' => ['required','regex:/^[0-9]*$/'],
                'depth_of_area' => ['required','regex:/^[0-9]*$/'],
                'interval' => ['required','regex:/^[0-9]*$/']
            ]);
    
            if($validator->passes())
            {
                $bottom_profilling = [];
    
                $bottom_profilling['cust_id'] = $cust_id;
                $bottom_profilling['fname'] = $input['fname'];
                $bottom_profilling['designation'] = $input['designation'];
                $bottom_profilling['sector'] = $input['sector'];
                $bottom_profilling['department'] = $input['department'];
                $bottom_profilling['firm'] = $input['firm'];
                $bottom_profilling['others'] = $input['others'];
                $bottom_profilling['purpose'] = $input['purpose'];
                $bottom_profilling['service'] = $input['service'];
                $bottom_profilling['description'] = $input['description'];
                $bottom_profilling['state'] = $input['state'];
                $bottom_profilling['district'] = $input['district'];
                $bottom_profilling['place'] = $input['place'];
                $bottom_profilling['location'] = $input['survey_area_location'];
                $bottom_profilling['area_to_scan'] = $input['area_to_scan'];
                $bottom_profilling['depth_of_area'] = $input['depth_of_area'];
                $bottom_profilling['interval'] = $input['interval'];
                $bottom_profilling['lattitude'] = $input['lattitude'];
                $bottom_profilling['longitude'] = $input['longitude'];
                $bottom_profilling['x_coordinates'] = $input['x_coordinates'];
                $bottom_profilling['y_coordinates'] = $input['y_coordinates'];
                $bottom_profilling['is_active'] = 1;
                $bottom_profilling['is_deleted'] = 0;
                $bottom_profilling['created_by'] = auth()->user()->id;
                $bottom_profilling['updated_by'] = auth()->user()->id;
                $bottom_profilling['created_at'] = date('Y-m-d H:i:s');
                $bottom_profilling['updated_at'] = date('Y-m-d H:i:s');
    
                if(isset($input['additional_services']))
                {
                    
                   $bottom_profilling['additional_services'] = implode(",", $input['additional_services']); 
                }else{
                    $bottom_profilling['additional_services'] = "";
                }
    
                $bottom_profilling_id = Subbottom_profilling::create($bottom_profilling)->id;
    
                $survey_request = [];
    
                $survey_request['cust_id'] = $cust_id;
                $survey_request['service_id'] = $input['service'];
                $survey_request['service_request_id'] = $bottom_profilling_id;
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
                $admin_noti['title'] = 'Survey Request Submitted';
                $admin_noti['description'] = 'Survey Request Submitted - HSW'.$survey_request_id;
                $admin_noti['ref_id'] = $cust_id;
                $admin_noti['ref_link'] = '/superadmin/new_service_request_detail/'.$survey_request_id;
                $admin_noti['viewed'] = 0;
                $admin_noti['created_at'] = date('Y-m-d H:i:s');
                $admin_noti['updated_at'] = date('Y-m-d H:i:s');
                $admin_noti['deleted_at'] = date('Y-m-d H:i:s');
    
                AdminNotification::create($admin_noti);
    
                if(isset($bottom_profilling_id) && isset($survey_request_id))
                {   
                    Session::flash('message', ['text'=>'Survey Requested Submitted Successfully !','type'=>'success']);  
                }
                else
                {
                    Session::flash('message', ['text'=>'Survey Requested Not Submitted !','type'=>'danger']);
                }
    
                return redirect(route('customer.subbottom_profilling'));
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
