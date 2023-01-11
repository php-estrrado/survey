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
use App\Models\UserVisit;
use App\Models\Hydrographic_survey;
use App\Models\Survey_requests;
use App\Models\Survey_request_logs;
use App\Rules\Name;
use Validator;

class HydrographicsurveyController extends Controller
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
        $data['title']        =  'Hydrofraphic Survey';
        $data['menu']         =  'Hydrofraphic Survey';

        return view('customer.hydrographic_survey.hydrographic_survey',$data);
    }

    public function create()
    { 
        $data['title']        =  'Hydrofraphic Survey';
        $data['menu']         =  'Hydrofraphic Survey';
        $data['services']     =  Services::where('is_deleted',0)->orderby('id','ASC')->get();
        $data['countries']    =  Country::where('is_deleted',0)->orderby('sortname','ASC')->get();
        $data['states']       =  State::where('is_deleted',0)->get();
        $data['cities']       =  City::where('is_deleted',0)->get();

        // dd($data);
        return view('customer.hydrographic_survey.hydrographicsurvey_form',$data);
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
            'area_of_survey' => ['required'],
            'scale_of_survey' => ['required'],
            'service_to_be_conducted' => ['required'],
            'interim_surveys_needed_infuture' => ['required'],
            'benchmark_chart_datum' => ['required']
        ]);

        if($validator->passes())
        {
            $hydrographic_survey = [];

            $hydrographic_survey['cust_id'] = $cust_id;
            $hydrographic_survey['fname'] = $input['fname'];
            $hydrographic_survey['designation'] = $input['designation'];
            $hydrographic_survey['sector'] = $input['sector'];
            $hydrographic_survey['department'] = $input['department'];
            $hydrographic_survey['firm'] = $input['firm'];
            $hydrographic_survey['others'] = $input['others'];
            $hydrographic_survey['purpose'] = $input['purpose'];
            $hydrographic_survey['service'] = $input['service'];
            $hydrographic_survey['description'] = $input['description'];
            $hydrographic_survey['state'] = $input['state'];
            $hydrographic_survey['district'] = $input['district'];
            $hydrographic_survey['place'] = $input['place'];
            $hydrographic_survey['survey_area_location'] = $input['survey_area'];
            $hydrographic_survey['type_of_waterbody'] = $input['type_of_waterbody'];
            $hydrographic_survey['area_of_survey'] = $input['area_of_survey'];
            $hydrographic_survey['scale_of_survey'] = $input['scale_of_survey'];
            $hydrographic_survey['service_to_be_conducted'] = date('Y-m-d',strtotime($input['service_to_be_conducted']));
            $hydrographic_survey['interim_surveys_needed_infuture'] = $input['interim_surveys_needed_infuture'];
            $hydrographic_survey['benchmark_chart_datum'] = $input['benchmark_chart_datum'];
            $hydrographic_survey['is_active'] = 1;
            $hydrographic_survey['is_deleted'] = 0;
            $hydrographic_survey['created_by'] = auth()->user()->id;
            $hydrographic_survey['updated_by'] = auth()->user()->id;
            $hydrographic_survey['created_at'] = date('Y-m-d H:i:s');
            $hydrographic_survey['updated_at'] = date('Y-m-d H:i:s');

            $hydrographic_survey_id = Hydrographic_survey::create($hydrographic_survey)->id;

            $survey_request = [];

            $survey_request['cust_id'] = $cust_id;
            $survey_request['service_id'] = $input['service'];
            $survey_request['service_request_id'] = $hydrographic_survey_id;
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

            return redirect(route('customer.hydrographic_survey'));
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
