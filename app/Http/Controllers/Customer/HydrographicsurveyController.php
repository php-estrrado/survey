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
use App\Models\Hydrographic_survey;
use App\Models\Survey_requests;
use App\Models\Survey_request_logs;
use App\Models\AdminNotification;
use App\Rules\Name;
use Validator;
use App\Models\OrganisationType;
use App\Models\SurveyScale;
use App\Models\DataCollectionEquipment;

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
        $service              = 1; 
        $data['service']         =  $service;
        $data['services']     =  Services::where('is_deleted',0)->whereNotIn('id',[$service])->orderby('id','ASC')->get();
        $data['countries']    =  Country::where('is_deleted',0)->orderby('sortname','ASC')->get();
        $data['states']       =  State::where('is_deleted',0)->get();
        $data['cities']       =  City::where('is_deleted',0)->get();
        $data['org_types']    =  OrganisationType::selectOption();
        $data['scales']       =  SurveyScale::selectOption();
        $data['data_collection']    = DataCollectionEquipment::selectOption();
        $cust_email = Admin::where('id',auth()->user()->id)->first()->email;
        $cust_id = CustomerMaster::where('username',$cust_email)->first()->id;
        $cust_info = CustomerInfo::where('cust_id',$cust_id)->first();
        $data['cust_info']    = $cust_info;
        // dd($data);
        return view('customer.hydrographic_survey.hydrographicsurvey_form',$data);
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
                'fname'=>['required','max:255','regex:/^[a-zA-Z\s]*$/'],
                'designation'=>['required','max:255','regex:/^[a-zA-Z\s]*$/'],
                'sector'=>['required'],
                'department' => ['required','regex:/^[a-zA-Z\s]*$/'],
                'firm' => ['required'],
                'others' => ['nullable','regex:/^[a-zA-Z\s]*$/'],
                'purpose' => ['required','regex:/^[a-zA-Z\s]*$/'],
                'description' => ['required','regex:/^[a-zA-Z\s.,\-@&*()]*$/'],
                'state' => ['required'],
                'district' => ['required'],
                'place' => ['required','regex:/^[a-zA-Z\s]*$/'],
                'survey_area' => ['required','regex:/^[a-zA-Z\s]*$/'],
                'lattitude' => ['nullable','regex:/^[a-zA-Z0-9\s.,]*$/'],
                'longitude' => ['nullable','regex:/^[a-zA-Z0-9\s.,]*$/'],
                'x_coordinates' => ['nullable','regex:/^[a-zA-Z0-9\s.,]*$/'],
                'y_coordinates' => ['nullable','regex:/^[a-zA-Z0-9\s.,]*$/'],
                'type_of_waterbody' => ['required'],
                'area_of_survey' => ['required','regex:/^[a-zA-Z\s]*$/'],
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
                
                $hydrographic_survey['lattitude'] = $input['lattitude'];
                $hydrographic_survey['longitude'] = $input['longitude'];
                $hydrographic_survey['x_coordinates'] = $input['x_coordinates'];
                $hydrographic_survey['y_coordinates'] = $input['y_coordinates'];
                $hydrographic_survey['is_active'] = 1;
                $hydrographic_survey['is_deleted'] = 0;
                $hydrographic_survey['created_by'] = auth()->user()->id;
                $hydrographic_survey['updated_by'] = auth()->user()->id;
                $hydrographic_survey['created_at'] = date('Y-m-d H:i:s');
                $hydrographic_survey['updated_at'] = date('Y-m-d H:i:s');
    
                if(isset($input['additional_services']))
                {
                    
                   $hydrographic_survey['additional_services'] = implode(",", $input['additional_services']); 
                }else{
                    $hydrographic_survey['additional_services'] = "";
                }
    
                 if(isset($input['data_collection_equipments']))
                {
                    
                   $hydrographic_survey['data_collection_equipments'] = implode(",", $input['data_collection_equipments']); 
                }else{
                    $hydrographic_survey['data_collection_equipments'] = "";
                }

                $drawings = Hydrographic_survey::where('id',$input['id'])->first()->drawing_maps;

                $drawing = json_decode($drawings,true);

                $files = $drawing;

                if($request->hasfile('filenames'))
                {
                    foreach($request->file('filenames') as $file)
                    {
                        $folder_name = "uploads/survey_requests/" . date("Ym", time()) . '/'.date("d", time()).'/';

                        $upload_path = base_path() . '/public/' . $folder_name;

                        $extension = strtolower($file->getClientOriginalExtension());

                        $filename = "survey" . '_' . time() .rand(1,1000).'.' . $extension;

                        $file->move($upload_path, $filename);

                        $files[] = "/public/$folder_name/$filename";
                    }
                }

                $hydrographic_survey['drawing_maps'] = json_encode($files);
    
                Hydrographic_survey::where('id',$input['id'])->update($hydrographic_survey);
    
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
    
                return redirect(route('customer.requested_services'));
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
                'fname'=>['required','max:255','regex:/^[a-zA-Z\s]*$/'],
                'designation'=>['required','max:255','regex:/^[a-zA-Z\s]*$/'],
                'sector'=>['required'],
                'department' => ['required','regex:/^[a-zA-Z\s]*$/'],
                'firm' => ['required'],
                'others' => ['nullable','regex:/^[a-zA-Z\s]*$/'],
                'purpose' => ['required','regex:/^[a-zA-Z\s]*$/'],
                'description' => ['required','regex:/^[a-zA-Z\s.,\-@&*()]*$/'],
                'state' => ['required'],
                'district' => ['required'],
                'place' => ['required','regex:/^[a-zA-Z\s]*$/'],
                'survey_area' => ['required','regex:/^[a-zA-Z\s]*$/'],
                'lattitude' => ['nullable','regex:/^[a-zA-Z0-9\s.,]*$/'],
                'longitude' => ['nullable','regex:/^[a-zA-Z0-9\s.,]*$/'],
                'x_coordinates' => ['nullable','regex:/^[a-zA-Z0-9\s.,]*$/'],
                'y_coordinates' => ['nullable','regex:/^[a-zA-Z0-9\s.,]*$/'],
                'type_of_waterbody' => ['required'],
                'area_of_survey' => ['required','regex:/^[a-zA-Z\s]*$/'],
                'scale_of_survey' => ['required','regex:/^[a-zA-Z0-9\s]*$/'],
                'service_to_be_conducted' => ['required'],
                'interim_surveys_needed_infuture' => ['required'],
                'benchmark_chart_datum' => ['required']
            ]);
    
            if($validator->passes())
            {

                $input = $request->all();

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
                
                $hydrographic_survey['lattitude'] = $input['lattitude'];
                $hydrographic_survey['longitude'] = $input['longitude'];
                $hydrographic_survey['x_coordinates'] = $input['x_coordinates'];
                $hydrographic_survey['y_coordinates'] = $input['y_coordinates'];
                $hydrographic_survey['is_active'] = 1;
                $hydrographic_survey['is_deleted'] = 0;
                $hydrographic_survey['created_by'] = auth()->user()->id;
                $hydrographic_survey['updated_by'] = auth()->user()->id;
                $hydrographic_survey['created_at'] = date('Y-m-d H:i:s');
                $hydrographic_survey['updated_at'] = date('Y-m-d H:i:s');
    
                if(isset($input['additional_services']))
                {
                    
                   $hydrographic_survey['additional_services'] = implode(",", $input['additional_services']); 
                }else{
                    $hydrographic_survey['additional_services'] = "";
                }
    
                 if(isset($input['data_collection_equipments']))
                {
                    
                   $hydrographic_survey['data_collection_equipments'] = implode(",", $input['data_collection_equipments']); 
                }else{
                    $hydrographic_survey['data_collection_equipments'] = "";
                }

                $files = [];

                if($request->hasfile('filenames'))
                {
                    foreach($request->file('filenames') as $file)
                    {
                        $folder_name = "uploads/survey_requests/" . date("Ym", time()) . '/'.date("d", time()).'/';

                        $upload_path = base_path() . '/public/' . $folder_name;

                        $extension = strtolower($file->getClientOriginalExtension());

                        $filename = "survey" . '_' . time() .rand(1,1000).'.' . $extension;

                        $file->move($upload_path, $filename);

                        $files[] = "/public/$folder_name/$filename";
                    }
                }

                $hydrographic_survey['drawing_maps'] = json_encode($files);
    
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
    
                if(isset($hydrographic_survey_id) && isset($survey_request_id))
                {   
                    Session::flash('message', ['text'=>'Survey Requested Submitted Successfully !','type'=>'success']);  
                }
                else
                {
                    Session::flash('message', ['text'=>'Survey Requested Not Submitted !','type'=>'danger']);
                }
    
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
}
