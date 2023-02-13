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
use App\Models\Currentmeter_observation;
use App\Models\Services;
use App\Models\Survey_requests;
use App\Models\Survey_request_logs;
use App\Models\AdminNotification;
use App\Rules\Name;
use Validator;
use App\Models\OrganisationType;
class CurrentmeterobservationController extends Controller
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
        $data['title']        =  'Current meter observation';
        $data['menu']         =  'Current meter observation';

        return view('customer.currentmeter_observation.currentmeter_observation',$data);
    }

    public function create()
    { 
        $data['title']        =  'Current meter observation';
        $data['menu']         =  'Current meter observation';
        $service              = 7; 
        $data['service']         =  $service;
        $data['services']     =  Services::where('is_deleted',0)->whereNotIn('id',[$service])->orderby('id','ASC')->get();
        $data['countries']    =  Country::where('is_deleted',0)->orderby('sortname','ASC')->get();
        $data['states']       =  State::where('is_deleted',0)->get();
        $data['cities']       =  City::where('is_deleted',0)->get();
        $data['org_types']    = OrganisationType::selectOption();
        // dd($data);
        return view('customer.currentmeter_observation.currentmeterobservation_form',$data);
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
                'type_of_waterbody' => ['required'],
                'observation_start_date' => ['required'],
                'observation_end_date' => ['required']
            ]);
    
            if($validator->passes())
            {
                $currentmeter_observation = [];
    
                $currentmeter_observation['cust_id'] = $cust_id;
                $currentmeter_observation['fname'] = $input['fname'];
                $currentmeter_observation['designation'] = $input['designation'];
                $currentmeter_observation['sector'] = $input['sector'];
                $currentmeter_observation['department'] = $input['department'];
                $currentmeter_observation['firm'] = $input['firm'];
                $currentmeter_observation['others'] = $input['others'];
                $currentmeter_observation['purpose'] = $input['purpose'];
                $currentmeter_observation['service'] = $input['service'];
                $currentmeter_observation['description'] = $input['description'];
                $currentmeter_observation['state'] = $input['state'];
                $currentmeter_observation['district'] = $input['district'];
                $currentmeter_observation['place'] = $input['place'];
                $currentmeter_observation['survey_area_location'] = $input['survey_area_location'];
                $currentmeter_observation['type_of_waterbody'] = $input['type_of_waterbody'];
                $currentmeter_observation['observation_start_date'] = date('Y-m-d',strtotime($input['observation_start_date']));
                $currentmeter_observation['observation_end_date'] = date('Y-m-d',strtotime($input['observation_end_date']));
                $currentmeter_observation['lattitude'] = $input['lattitude'];
                $currentmeter_observation['longitude'] = $input['longitude'];
                $currentmeter_observation['x_coordinates'] = $input['x_coordinates'];
                $currentmeter_observation['y_coordinates'] = $input['y_coordinates'];
                $currentmeter_observation['is_active'] = 1;
                $currentmeter_observation['is_deleted'] = 0;
                $currentmeter_observation['created_by'] = auth()->user()->id;
                $currentmeter_observation['updated_by'] = auth()->user()->id;
                $currentmeter_observation['created_at'] = date('Y-m-d H:i:s');
                $currentmeter_observation['updated_at'] = date('Y-m-d H:i:s');
    
                if($input['additional_services'])
                {
                    
                   $currentmeter_observation['additional_services'] = implode(",", $input['additional_services']); 
                }else{
                    $currentmeter_observation['additional_services'] = "";
                }
    
                Currentmeter_observation::where('id',$input['id'])->update($currentmeter_observation);
    
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
                $admin_noti['notify_type'] = 0;
                $admin_noti['title'] = 'Survey Request Re-Submitted';
                $admin_noti['ref_id'] = $cust_id;
                $admin_noti['ref_link'] = '/superadmin/new_service_request_detail/'.$input['survey_request_id'];
                $admin_noti['viewed'] = 0;
                $admin_noti['created_at'] = date('Y-m-d H:i:s');
                $admin_noti['updated_at'] = date('Y-m-d H:i:s');
                $admin_noti['deleted_at'] = date('Y-m-d H:i:s');
    
                AdminNotification::create($admin_noti);
    
                Session::flash('message', ['text'=>'Survey Requested Updated Successfully !','type'=>'success']);
    
                return redirect(route('customer.currentmeter_observation'));
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
                'type_of_waterbody' => ['required'],
                'observation_start_date' => ['required'],
                'observation_end_date' => ['required']
            ]);
    
            if($validator->passes())
            {
                $currentmeter_observation = [];
    
                $currentmeter_observation['cust_id'] = $cust_id;
                $currentmeter_observation['fname'] = $input['fname'];
                $currentmeter_observation['designation'] = $input['designation'];
                $currentmeter_observation['sector'] = $input['sector'];
                $currentmeter_observation['department'] = $input['department'];
                $currentmeter_observation['firm'] = $input['firm'];
                $currentmeter_observation['others'] = $input['others'];
                $currentmeter_observation['purpose'] = $input['purpose'];
                $currentmeter_observation['service'] = $input['service'];
                $currentmeter_observation['description'] = $input['description'];
                $currentmeter_observation['state'] = $input['state'];
                $currentmeter_observation['district'] = $input['district'];
                $currentmeter_observation['place'] = $input['place'];
                $currentmeter_observation['survey_area_location'] = $input['survey_area_location'];
                $currentmeter_observation['type_of_waterbody'] = $input['type_of_waterbody'];
                $currentmeter_observation['observation_start_date'] = date('Y-m-d',strtotime($input['observation_start_date']));
                $currentmeter_observation['observation_end_date'] = date('Y-m-d',strtotime($input['observation_end_date']));
                $currentmeter_observation['lattitude'] = $input['lattitude'];
                $currentmeter_observation['longitude'] = $input['longitude'];
                $currentmeter_observation['x_coordinates'] = $input['x_coordinates'];
                $currentmeter_observation['y_coordinates'] = $input['y_coordinates'];
                $currentmeter_observation['is_active'] = 1;
                $currentmeter_observation['is_deleted'] = 0;
                $currentmeter_observation['created_by'] = auth()->user()->id;
                $currentmeter_observation['updated_by'] = auth()->user()->id;
                $currentmeter_observation['created_at'] = date('Y-m-d H:i:s');
                $currentmeter_observation['updated_at'] = date('Y-m-d H:i:s');
    
                if($input['additional_services'])
                {
                    
                   $currentmeter_observation['additional_services'] = implode(",", $input['additional_services']); 
                }else{
                    $currentmeter_observation['additional_services'] = "";
                }
    
                $currentmeter_observation_id = Currentmeter_observation::create($currentmeter_observation)->id;
    
                $survey_request = [];
    
                $survey_request['cust_id'] = $cust_id;
                $survey_request['service_id'] = $input['service'];
                $survey_request['service_request_id'] = $currentmeter_observation_id;
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
    
                if(isset($currentmeter_observation_id) && isset($survey_request_id))
                {   
                    Session::flash('message', ['text'=>'Survey Requested Submitted Successfully !','type'=>'success']);  
                }
                else
                {
                    Session::flash('message', ['text'=>'Survey Requested Not Submitted !','type'=>'danger']);
                }
    
                return redirect(route('customer.currentmeter_observation'));
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
