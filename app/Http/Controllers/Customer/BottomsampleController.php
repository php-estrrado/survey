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
use App\Models\Bottom_sample_collection;
use App\Models\Services;
use App\Models\Survey_requests;
use App\Models\Survey_request_logs;
use App\Rules\Name;
use Validator;

class BottomsampleController extends Controller
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
        $data['title']        =  'Bottom sample collection';
        $data['menu']         =  'Bottom sample collection';

        return view('customer.bottomsample.bottom_sample',$data);
    }
    public function create()
    { 
        $data['title']        =  'Bottom sample collection';
        $data['menu']         =  'Bottom sample collection';
        $data['services']     =  Services::where('is_deleted',0)->orderby('id','ASC')->get();
        $data['countries']    =  Country::where('is_deleted',0)->orderby('sortname','ASC')->get();
        $data['states']       =  State::where('is_deleted',0)->get();
        $data['cities']       =  City::where('is_deleted',0)->get();

        // dd($data);
        return view('customer.bottomsample.bottomsample_form',$data);
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
            'depth_at_saples_collected' => ['required'],
            'number_of_locations' => ['required'],
            'quantity_of_samples' => ['required'],
        ]);

        if($validator->passes())
        {
            $bottomsample = [];

            $bottomsample['cust_id'] = $cust_id;
            $bottomsample['fname'] = $input['fname'];
            $bottomsample['designation'] = $input['designation'];
            $bottomsample['sector'] = $input['sector'];
            $bottomsample['department'] = $input['department'];
            $bottomsample['firm'] = $input['firm'];
            $bottomsample['others'] = $input['others'];
            $bottomsample['purpose'] = $input['purpose'];
            $bottomsample['service'] = $input['service'];
            $bottomsample['description'] = $input['description'];
            $bottomsample['state'] = $input['state'];
            $bottomsample['district'] = $input['district'];
            $bottomsample['place'] = $input['place'];
            $bottomsample['depth_at_saples_collected'] = $input['depth_at_saples_collected'];
            $bottomsample['number_of_locations'] = $input['number_of_locations'];
            $bottomsample['quantity_of_samples'] = $input['quantity_of_samples'];
            $bottomsample['is_active'] = 1;
            $bottomsample['is_deleted'] = 0;
            $bottomsample['created_by'] = auth()->user()->id;
            $bottomsample['updated_by'] = auth()->user()->id;
            $bottomsample['created_at'] = date('Y-m-d H:i:s');
            $bottomsample['updated_at'] = date('Y-m-d H:i:s');

            $bottomsample_id = Bottom_sample_collection::create($bottomsample)->id;

            $survey_request = [];

            $survey_request['cust_id'] = $cust_id;
            $survey_request['service_id'] = $input['service'];
            $survey_request['service_request_id'] = $bottomsample_id;
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

            return redirect(route('customer.bottomsample'));
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