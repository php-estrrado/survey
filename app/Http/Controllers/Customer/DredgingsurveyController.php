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
use App\Models\Dredging_survey;
use App\Models\Services;
use App\Models\Survey_requests;
use App\Models\Survey_request_logs;
use App\Models\AdminNotification;
use App\Rules\Name;
use Validator;
use App\Models\OrganisationType;
class DredgingsurveyController extends Controller
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
        $data['title']        =  'Dredging survey';
        $data['menu']         =  'Dredging survey';

        return view('customer.dredging.dredging_survey',$data);
    }

    public function create()
    { 
        $data['title']        =  'Dredging survey';
        $data['menu']         =  'Dredging survey';
        $service              = 4; 
        $data['service']         =  $service;
        $data['services']     =  Services::where('is_deleted',0)->whereNotIn('id',[$service])->orderby('id','ASC')->get();
        $data['countries']    =  Country::where('is_deleted',0)->orderby('sortname','ASC')->get();
        $data['states']       =  State::where('is_deleted',0)->get();
        $data['cities']       =  City::where('is_deleted',0)->get();
        $data['org_types']    = OrganisationType::selectOption();
        // dd($data);
        return view('customer.dredging.dredgingsurvey_form',$data);
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
            'survey_area' => ['required'],
            'detailed_description_area' => ['required'],
            'dredging_survey_method' => ['required'],
            'interim_surveys_needed_infuture' => ['required'],
            'dredging_quantity_calculation' => ['required'],
            'method_volume_calculation' => ['required'],
            'length' => ['required'],
            'width' => ['required'],
            'depth' => ['required']
        ]);

        if($validator->passes())
        {
            $dredging = [];

            $dredging['cust_id'] = $cust_id;
            $dredging['fname'] = $input['fname'];
            $dredging['designation'] = $input['designation'];
            $dredging['sector'] = $input['sector'];
            $dredging['department'] = $input['department'];
            $dredging['firm'] = $input['firm'];
            $dredging['others'] = $input['others'];
            $dredging['purpose'] = $input['purpose'];
            $dredging['service'] = $input['service'];
            $dredging['description'] = $input['description'];
            $dredging['state'] = $input['state'];
            $dredging['district'] = $input['district'];
            $dredging['place'] = $input['place'];
            $dredging['survey_area_location'] = $input['survey_area'];
            $dredging['detailed_description_area'] = $input['detailed_description_area'];
            $dredging['dredging_survey_method'] = $input['dredging_survey_method'];
            $dredging['interim_survey'] = $input['interim_surveys_needed_infuture'];
            $dredging['dredging_quantity_calculation'] = $input['dredging_quantity_calculation'];
            $dredging['method_volume_calculation'] = $input['method_volume_calculation'];
            $dredging['length'] = $input['length'];
            $dredging['width'] = $input['width'];
            $dredging['depth'] = $input['depth'];
            $dredging['lattitude'] = $input['lattitude'];
            $dredging['longitude'] = $input['longitude'];
            $dredging['x_coordinates'] = $input['x_coordinates'];
            $dredging['y_coordinates'] = $input['y_coordinates'];
            $dredging['lattitude2'] = $input['lattitude2'];
            $dredging['longitude2'] = $input['longitude2'];
            $dredging['x_coordinates2'] = $input['x_coordinates2'];
            $dredging['y_coordinates2'] = $input['y_coordinates2'];            
            $dredging['level_upto'] = $input['level_upto'];
            $dredging['no_of_surveys'] = $input['no_of_surveys'];
            $dredging['is_active'] = 1;
            $dredging['is_deleted'] = 0;
            $dredging['created_by'] = auth()->user()->id;
            $dredging['updated_by'] = auth()->user()->id;
            $dredging['created_at'] = date('Y-m-d H:i:s');
            $dredging['updated_at'] = date('Y-m-d H:i:s');

            if($input['additional_services'])
            {
                
               $dredging['additional_services'] = implode(",", $input['additional_services']); 
            }else{
                $dredging['additional_services'] = "";
            }

            if($input['dredging_survey_method'])
            {
                
               $dredging['dredging_survey_method'] = implode(",", $input['dredging_survey_method']); 
            }else{
                $dredging['dredging_survey_method'] = "";
            }
            
            $dredging_id = Dredging_survey::create($dredging)->id;

            $survey_request = [];

            $survey_request['cust_id'] = $cust_id;
            $survey_request['service_id'] = $input['service'];
            $survey_request['service_request_id'] = $dredging_id;
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

            if(isset($dredging_id) && isset($survey_request_id))
            {   
                Session::flash('message', ['text'=>'Survey Requested Submitted Successfully !','type'=>'success']);  
            }
            else
            {
                Session::flash('message', ['text'=>'Survey Requested Not Submitted !','type'=>'danger']);
            }

            return redirect(route('customer.dredging_survey'));
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
