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
use App\Models\Subbottom_profilling;
use App\Models\Services;
use App\Models\Survey_requests;
use App\Models\Survey_request_logs;
use App\Rules\Name;
use Validator;

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
        $data['services']     =  Services::where('is_deleted',0)->orderby('id','ASC')->get();
        $data['countries']    =  Country::where('is_deleted',0)->orderby('sortname','ASC')->get();
        $data['states']       =  State::where('is_deleted',0)->get();
        $data['cities']       =  City::where('is_deleted',0)->get();

        // dd($data);
        return view('customer.subbottom_profilling.subbottomprofilling_form',$data);
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
            'survey_area_location' => ['required'],
            'area_to_scan' => ['required'],
            'depth_of_area' => ['required'],
            'interval' => ['required']
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
            $bottom_profilling['is_active'] = 1;
            $bottom_profilling['is_deleted'] = 0;
            $bottom_profilling['created_by'] = auth()->user()->id;
            $bottom_profilling['updated_by'] = auth()->user()->id;
            $bottom_profilling['created_at'] = date('Y-m-d H:i:s');
            $bottom_profilling['updated_at'] = date('Y-m-d H:i:s');

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
