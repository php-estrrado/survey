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
use App\Models\Sidescansonar;
use App\Models\Services;
use App\Models\Survey_requests;
use App\Models\Survey_request_logs;
use App\Models\AdminNotification;
use App\Rules\Name;
use Validator;
use App\Models\OrganisationType;
class SidescansonarsurveyController extends Controller
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
        $data['title']        =  'Side scanning sonar';
        $data['menu']         =  'Side scanning sonar';

        return view('customer.sidesonarscan.sidesonarscan',$data);
    }

    public function create()
    { 
        $data['title']        =  'Side scanning sonar';
        $data['menu']         =  'Side scanning sonar';
        $service              = 8; 
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
        return view('customer.sidesonarscan.sidesonarscan_form',$data);
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
                'survey_area_location' => ['nullable','regex:/^[a-zA-Z\s]*$/'],
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
                $sidescansonar = [];
    
                $sidescansonar['cust_id'] = $cust_id;
                $sidescansonar['fname'] = $input['fname'];
                $sidescansonar['designation'] = $input['designation'];
                $sidescansonar['sector'] = $input['sector'];
                $sidescansonar['department'] = $input['department'];
                $sidescansonar['firm'] = $input['firm'];
                $sidescansonar['others'] = $input['others'];
                $sidescansonar['purpose'] = $input['purpose'];
                $sidescansonar['service'] = $input['service'];
                $sidescansonar['description'] = $input['description'];
                $sidescansonar['state'] = $input['state'];
                $sidescansonar['district'] = $input['district'];
                $sidescansonar['place'] = $input['place'];
                $sidescansonar['location'] = $input['survey_area_location'];
                $sidescansonar['area_to_scan'] = $input['area_to_scan'];
                $sidescansonar['depth_of_area'] = $input['depth_of_area'];
                $sidescansonar['interval'] = $input['interval'];
                $sidescansonar['lattitude'] = $input['lattitude'];
                $sidescansonar['longitude'] = $input['longitude'];
                $sidescansonar['x_coordinates'] = $input['x_coordinates'];
                $sidescansonar['y_coordinates'] = $input['y_coordinates'];
                $sidescansonar['is_active'] = 1;
                $sidescansonar['is_deleted'] = 0;
                $sidescansonar['created_by'] = auth()->user()->id;
                $sidescansonar['updated_by'] = auth()->user()->id;
                $sidescansonar['created_at'] = date('Y-m-d H:i:s');
                $sidescansonar['updated_at'] = date('Y-m-d H:i:s');
    
                if(isset($input['additional_services']))
                {
                    
                   $sidescansonar['additional_services'] = implode(",", $input['additional_services']); 
                }else{
                    $sidescansonar['additional_services'] = "";
                }
    
    
                Sidescansonar::where('id',$input['id'])->update($sidescansonar);
    
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
    
                return redirect(route('customer.sidescanningsonar_survey'));
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
                'survey_area_location' => ['nullable','regex:/^[a-zA-Z\s]*$/'],
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
                $sidescansonar = [];
    
                $sidescansonar['cust_id'] = $cust_id;
                $sidescansonar['fname'] = $input['fname'];
                $sidescansonar['designation'] = $input['designation'];
                $sidescansonar['sector'] = $input['sector'];
                $sidescansonar['department'] = $input['department'];
                $sidescansonar['firm'] = $input['firm'];
                $sidescansonar['others'] = $input['others'];
                $sidescansonar['purpose'] = $input['purpose'];
                $sidescansonar['service'] = $input['service'];
                $sidescansonar['description'] = $input['description'];
                $sidescansonar['state'] = $input['state'];
                $sidescansonar['district'] = $input['district'];
                $sidescansonar['place'] = $input['place'];
                $sidescansonar['location'] = $input['survey_area_location'];
                $sidescansonar['area_to_scan'] = $input['area_to_scan'];
                $sidescansonar['depth_of_area'] = $input['depth_of_area'];
                $sidescansonar['interval'] = $input['interval'];
                $sidescansonar['lattitude'] = $input['lattitude'];
                $sidescansonar['longitude'] = $input['longitude'];
                $sidescansonar['x_coordinates'] = $input['x_coordinates'];
                $sidescansonar['y_coordinates'] = $input['y_coordinates'];
                $sidescansonar['is_active'] = 1;
                $sidescansonar['is_deleted'] = 0;
                $sidescansonar['created_by'] = auth()->user()->id;
                $sidescansonar['updated_by'] = auth()->user()->id;
                $sidescansonar['created_at'] = date('Y-m-d H:i:s');
                $sidescansonar['updated_at'] = date('Y-m-d H:i:s');
    
                if(isset($input['additional_services']))
                {
                    
                   $sidescansonar['additional_services'] = implode(",", $input['additional_services']); 
                }else{
                    $sidescansonar['additional_services'] = "";
                }
    
    
                $sidescansonar_id = Sidescansonar::create($sidescansonar)->id;
    
                $survey_request = [];
    
                $survey_request['cust_id'] = $cust_id;
                $survey_request['service_id'] = $input['service'];
                $survey_request['service_request_id'] = $sidescansonar_id;
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
    
                if(isset($sidescansonar_id) && isset($survey_request_id))
                {   
                    Session::flash('message', ['text'=>'Survey Requested Submitted Successfully !','type'=>'success']);  
                }
                else
                {
                    Session::flash('message', ['text'=>'Survey Requested Not Submitted !','type'=>'danger']);
                }
    
                return redirect(route('customer.sidescanningsonar_survey'));
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
