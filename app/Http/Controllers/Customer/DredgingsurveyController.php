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
use App\Rules\Name;
use Validator;

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
        $data['services']     =  Services::where('is_deleted',0)->orderby('id','ASC')->get();
        $data['countries']    =  Country::where('is_deleted',0)->orderby('sortname','ASC')->get();
        $data['states']       =  State::where('is_deleted',0)->get();
        $data['cities']       =  City::where('is_deleted',0)->get();

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
            'service' => ['required'],
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
            $dredging['is_active'] = 1;
            $dredging['is_deleted'] = 0;
            $dredging['created_by'] = auth()->user()->id;
            $dredging['updated_by'] = auth()->user()->id;
            $dredging['created_at'] = date('Y-m-d H:i:s');
            $dredging['updated_at'] = date('Y-m-d H:i:s');

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
