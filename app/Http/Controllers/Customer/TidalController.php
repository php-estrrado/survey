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
use App\Models\Services;
use App\Models\Country;
use App\Models\State;
use App\Models\Admin;
use App\Models\City;
use App\Models\customer\CustomerMaster;
use App\Models\customer\CustomerInfo;
use App\Models\UserVisit;
use App\Models\Tidal_observation;
use App\Models\Survey_requests;
use App\Models\Survey_request_logs;
use App\Models\AdminNotification;
use App\Rules\Name;
use Validator;
use App\Models\OrganisationType;
class TidalController extends Controller
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
        $data['title']        =  'Tidal observation';
        $data['menu']         =  'Tidal observation';

        return view('customer.tidal_observation.tidal_observation',$data);
    }
    public function create()
    { 
        $data['title']        =  'Tidal observation';
        $data['menu']         =  'Tidal observation';
        $service              = 2; 
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
        return view('customer.tidal_observation.tidalobservation_form',$data);
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
            'service' => ['required'],
            'description' => ['required'],
            'state' => ['required'],
            'district' => ['required'],
            'place' => ['required'],
            'tidal_area' => ['required'],
            // 'period_of_observation' => ['required'],
            'benchmark_chart_datum' => ['required']
        ]);

        if($validator->passes())
        {
            $tidal_observation = [];

            $tidal_observation['cust_id'] = $cust_id;
            $tidal_observation['fname'] = $input['fname'];
            $tidal_observation['designation'] = $input['designation'];
            $tidal_observation['sector'] = $input['sector'];
            $tidal_observation['department'] = $input['department'];
            $tidal_observation['firm'] = $input['firm'];
            $tidal_observation['others'] = $input['others'];
            $tidal_observation['purpose'] = $input['purpose'];
            $tidal_observation['service'] = $input['service'];
            $tidal_observation['description'] = $input['description'];
            $tidal_observation['state'] = $input['state'];
            $tidal_observation['district'] = $input['district'];
            $tidal_observation['place'] = $input['place'];
            $tidal_observation['tidal_area_location'] = $input['tidal_area'];
            // $tidal_observation['period_of_observation'] = $input['period_of_observation'];
            $tidal_observation['benchmark_chart_datum'] = $input['benchmark_chart_datum'];
                        $tidal_observation['lattitude'] = $input['lattitude'];
            $tidal_observation['longitude'] = $input['longitude'];
            $tidal_observation['x_coordinates'] = $input['x_coordinates'];
            $tidal_observation['y_coordinates'] = $input['y_coordinates'];
            $tidal_observation['start_date'] = $input['start_date'];
            $tidal_observation['end_date'] = $input['end_date'];
            $tidal_observation['duration'] = $input['duration'];
            $tidal_observation['duration_weeks'] = $input['duration_weeks'];
            $tidal_observation['duration_days'] = $input['duration_days'];
            $tidal_observation['duration_hours'] = $input['duration_hours'];
            $tidal_observation['description_of_benchmark'] = $input['description_of_benchmark'];
            $tidal_observation['method_of_observation'] = $input['method_of_observation'];
            $tidal_observation['is_active'] = 1;
            $tidal_observation['is_deleted'] = 0;
            $tidal_observation['created_by'] = auth()->user()->id;
            $tidal_observation['updated_by'] = auth()->user()->id;
            $tidal_observation['created_at'] = date('Y-m-d H:i:s');
            $tidal_observation['updated_at'] = date('Y-m-d H:i:s');
            // dd($input);
             if($input['additional_services'])
            {
                
               $tidal_observation['additional_services'] = implode(",", $input['additional_services']); 
            }else{
                $tidal_observation['additional_services'] = "";
            }

            $tidal_observation_id = Tidal_observation::create($tidal_observation)->id;

            $survey_request = [];

            $survey_request['cust_id'] = $cust_id;
            $survey_request['service_id'] = $input['service'];
            $survey_request['service_request_id'] = $tidal_observation_id;
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
            
            if(isset($tidal_observation_id) && isset($survey_request_id))
            {   
                Session::flash('message', ['text'=>'Survey Requested Submitted Successfully !','type'=>'success']);  
            }
            else
            {
                Session::flash('message', ['text'=>'Survey Requested Not Submitted !','type'=>'danger']);
            }

            return redirect(route('customer.tidal_observation'));
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