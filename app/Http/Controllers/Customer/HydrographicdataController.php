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
use App\Models\Hydrographic_chart;
use App\Models\Services;
use App\Models\Survey_requests;
use App\Models\Survey_request_logs;
use App\Models\AdminNotification;
use App\Rules\Name;
use Validator;
use App\Models\OrganisationType;
class HydrographicdataController extends Controller
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
        $data['title']        =  'Hydrographic chart';
        $data['menu']         =  'Hydrographic chart';

        return view('customer.hydrographic_data.hydrographic_data',$data);
    }

    public function create()
    { 
        $data['title']        =  'Hydrographic chart';
        $data['menu']         =  'Hydrofraphic chart';
        $data['services']     =  Services::where('is_deleted',0)->orderby('id','ASC')->get();
        $data['countries']    =  Country::where('is_deleted',0)->orderby('sortname','ASC')->get();
        $data['states']       =  State::where('is_deleted',0)->get();
        $data['cities']       =  City::where('is_deleted',0)->get();
        $data['org_types']    = OrganisationType::selectOption();
        // dd($data);
        return view('customer.hydrographic_data.hydrographicdata_form',$data);
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
            'survey_area' => ['required'],
            'type_of_waterbody' => ['required'],
            'year_of_survey_chart' => ['required'],
            'copies_required' => ['required'],
            'copy_type' => ['required'],
        ]);

        if($validator->passes())
        {
            $hydrographic_data = [];

            $hydrographic_data['cust_id'] = $cust_id;
            $hydrographic_data['fname'] = $input['fname'];
            $hydrographic_data['designation'] = $input['designation'];
            $hydrographic_data['sector'] = $input['sector'];
            $hydrographic_data['department'] = $input['department'];
            $hydrographic_data['firm'] = $input['firm'];
            $hydrographic_data['others'] = $input['others'];
            $hydrographic_data['purpose'] = $input['purpose'];
            $hydrographic_data['service'] = $input['service'];
            $hydrographic_data['description'] = $input['description'];
            $hydrographic_data['state'] = $input['state'];
            $hydrographic_data['district'] = $input['district'];
            $hydrographic_data['place'] = $input['place'];
            $hydrographic_data['survey_area_location'] = $input['survey_area'];
            $hydrographic_data['water_bodies'] = $input['type_of_waterbody'];
            $hydrographic_data['year_of_survey_chart'] = $input['year_of_survey_chart'];
            $hydrographic_data['copies_required'] = $input['copies_required'];
            $hydrographic_data['copy_type'] = $input['copy_type'];
                        $hydrographic_data['lattitude'] = $input['lattitude'];
            $hydrographic_data['longitude'] = $input['longitude'];
            $hydrographic_data['x_coordinates'] = $input['x_coordinates'];
            $hydrographic_data['y_coordinates'] = $input['y_coordinates'];
            $hydrographic_data['is_active'] = 1;
            $hydrographic_data['is_deleted'] = 0;
            $hydrographic_data['created_by'] = auth()->user()->id;
            $hydrographic_data['updated_by'] = auth()->user()->id;
            $hydrographic_data['created_at'] = date('Y-m-d H:i:s');
            $hydrographic_data['updated_at'] = date('Y-m-d H:i:s');

            $hydrographic_data_id = Hydrographic_chart::create($hydrographic_data)->id;

            $survey_request = [];

            $survey_request['cust_id'] = $cust_id;
            $survey_request['service_id'] = $input['service'];
            $survey_request['service_request_id'] = $hydrographic_data_id;
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

            if(isset($hydrographic_data_id) && isset($survey_request_id))
            {   
                Session::flash('message', ['text'=>'Survey Requested Submitted Successfully !','type'=>'success']);  
            }
            else
            {
                Session::flash('message', ['text'=>'Survey Requested Not Submitted !','type'=>'danger']);
            }

            return redirect(route('customer.hydrographic_data'));
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
