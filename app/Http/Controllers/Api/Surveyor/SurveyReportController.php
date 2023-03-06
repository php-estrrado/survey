<?php

namespace App\Http\Controllers\Api\Surveyor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Session;
use DB;
use App\Models\Modules;
use App\Models\UserRoles;
use App\Models\Admin;
use App\Models\UserRole;

use App\Models\Survey_requests;
use App\Models\Survey_study_report;
use App\Models\Field_study_report;
use App\Models\Survey_status;
use App\Models\Survey_request_logs;
use Carbon\Carbon;
use App\Rules\Name;
use Validator;

use App\Models\crm\{CrmAssortmentMaster, CrmChildProductsMaster, CrmCustomerType,CrmPartAssortmentDetails,
CrmPartAssortmentMaster,CrmProduct,CrmSalesPriceList,CrmSalesPriceType,CrmSize,CrmBranch};

class SurveyReportController extends Controller
{
   
   public function survey_store(Request $request)
    {  

        $login=0;
        $user_id=null;
        $user = [];
        


        $validator=  Validator::make($request->all(),[
            'survey_request_id' => ['required'],
            'cust_id' => ['required'],
            'service_id' => ['required'],
            'service_request_id' => ['required'],
            'datetime_inspection' => ['required','date_format:Y-m-d H:i:s'],
            'survey_department_name' => ['required'],
            'officer_participating_field_inspection' => ['required'],
            'from_hsw' => ['required'],
            'location' => ['required'],
            'type_of_waterbody' => ['required'],
            'lattitude' => ['required'],
            'longitude' => ['required'],
            'x_coordinates' => ['required'],
            'y_coordinates' => ['required'],
            'whether_topographic_survey_required' => ['required'],
            'methods_to_be_adopted_for_topographic_survey' => ['required'],
            'instruments_to_be_used_for_topographic_survey' => ['required'],
            'availability_of_previous_shoreline_data' => ['required'],
            'availability_of_shoreline' => ['required'],
            'nature_of_shore' => ['required'],
            'bathymetric_area' => ['required'],
            'scale_of_survey_planned' => ['required'],
            'method_adopted_for_bathymetric_survey' => ['required'],
            'is_manual_survey_required' => ['required'],
            'line_interval_planned_for_survey' => ['required'],
            'type_of_survey_vessel_used_for_bathymetric_survey' => ['required'],
            'estimated_period_of_survey_days' => ['required'],
            'instruments_to_be_used_for_bathymetric_survey' => ['required'],
            'nearest_available_benchmark_detail' => ['required'],
            'is_local_benchmark_needs_to_be_established' => ['required'],
            'detailed_report_of_the_officer' => ['required'],
            'remarks' => ['required'],
            'presence_and_nature_of_obstructions_in_survey' => ['required'],
            'details_location_for_setting_tide_pole' => ['required'],
            
            'access_token' => ['required']
        ]);
        if ($validator->fails()) 
            {    
              return ['httpcode'=>400,'status'=>'error','message'=>'invalid','data'=>['errors'=>$validator->messages()]];
            }
            
            
        
        if($request->post('access_token')){
            if(!$user = validateToken($request->post('access_token'))){ return invalidToken(); }
            $login=1;
            $user_id = $user['user_id'];
            
        }
        
        $ins = Survey_study_report::create($request->only([
                'survey_request_id','service_id','service_request_id','cust_id','datetime_inspection','survey_department_name','officer_participating_field_inspection','from_hsw','location','type_of_waterbody','limit_of_survey_area','lattitude','longitude','x_coordinates','y_coordinates','whether_topographic_survey_required','methods_to_be_adopted_for_topographic_survey','instruments_to_be_used_for_topographic_survey','availability_of_previous_shoreline_data','availability_of_shoreline','nature_of_shore','bathymetric_area','scale_of_survey_planned','method_adopted_for_bathymetric_survey','is_manual_survey_required','line_interval_planned_for_survey','type_of_survey_vessel_used_for_bathymetric_survey','estimated_period_of_survey_days','instruments_to_be_used_for_bathymetric_survey','nearest_available_benchmark_detail','is_local_benchmark_needs_to_be_established','detailed_report_of_the_officer','remarks','presence_and_nature_of_obstructions_in_survey','details_location_for_setting_tide_pole'
            ]))->id;

        if(isset($request->upload_photos_of_study_area) && count($request->upload_photos_of_study_area)>0)
        {

            Survey_study_report::where("id",$ins)->update(["upload_photos_of_study_area"=>json_encode($request->upload_photos_of_study_area)]);
        }

        Survey_requests::where("id",$request->survey_request_id)->update(["request_status"=>19]);
        $assignment_requests = Survey_requests::where("id",$request->survey_request_id)->first();
        $req_logs = [];
        $req_logs['survey_request_id'] = $request->survey_request_id;
        $req_logs['cust_id'] = $request->cust_id;
        $req_logs['survey_status'] =19;
        $req_logs['is_active'] = 1;
        $req_logs['created_by'] = $user_id;


        Survey_request_logs::create($req_logs);

        $from       = $user_id; 
        $utype      = 2;
        $to         = $assignment_requests->assigned_user; 
        $ntype      = 'survey_study_report';
        $title      = 'Survey Study Report Submitted';
        $desc       = 'Survey Study Report Submitted. Request ID: HSW'.$request->survey_request_id;
        $refId      = $request->survey_request_id;
        $reflink    = 'admin';
        $notify     = 'admin';
        $notify_from_role_id = 3;
        addNotification($from,$utype,$to,$ntype,$title,$desc,$refId,$reflink,$notify,$notify_from_role_id); 
              
        return ['httpcode'=>200,'status'=>'success','page'=>'Home','message'=>'Success','data'=>['survey_study_report_id'=>$ins]];
    }

    public function field_store(Request $request)
    {  

        $login=0;
        $user_id=null;
        $user = [];
        


        $validator=  Validator::make($request->all(),[
            'survey_request_id' => ['required'],
            'cust_id' => ['required'],
            'service_id' => ['required'],
            'service_request_id' => ['required'],
            'datetime_inspection' => ['required','date_format:Y-m-d H:i:s'],
            'survey_department_name' => ['required'],
            'officer_participating_field_inspection' => ['required'],
            'from_hsw' => ['required'],
            'location' => ['required'],
            'type_of_waterbody' => ['required'],
            'lattitude' => ['required'],
            'longitude' => ['required'],
            'x_coordinates' => ['required'],
            'y_coordinates' => ['required'],
            'whether_topographic_survey_required' => ['required'],
            'methods_to_be_adopted_for_topographic_survey' => ['required'],
            'instruments_to_be_used_for_topographic_survey' => ['required'],
            'availability_of_previous_shoreline_data' => ['required'],
            'availability_of_shoreline' => ['required'],
            'nature_of_shore' => ['required'],
            'bathymetric_area' => ['required'],
            'scale_of_survey_planned' => ['required'],
            'method_adopted_for_bathymetric_survey' => ['required'],
            'is_manual_survey_required' => ['required'],
            'line_interval_planned_for_survey' => ['required'],
            'type_of_survey_vessel_used_for_bathymetric_survey' => ['required'],
            'estimated_period_of_survey_days' => ['required'],
            'instruments_to_be_used_for_bathymetric_survey' => ['required'],
            'nearest_available_benchmark_detail' => ['required'],
            'is_local_benchmark_needs_to_be_established' => ['required'],
            'detailed_report_of_the_officer' => ['required'],
            'remarks' => ['required'],
            'presence_and_nature_of_obstructions_in_survey' => ['required'],
            'details_location_for_setting_tide_pole' => ['required'],
            
            'access_token' => ['required']
        ]);
        if ($validator->fails()) 
            {    
              return ['httpcode'=>400,'status'=>'error','message'=>'invalid','data'=>['errors'=>$validator->messages()]];
            }
            
            
        
        if($request->post('access_token')){
            if(!$user = validateToken($request->post('access_token'))){ return invalidToken(); }
            $login=1;
            $user_id = $user['user_id'];
            
        }
        
        $ins = Field_study_report::create($request->only([
                'survey_request_id','service_id','service_request_id','cust_id','datetime_inspection','survey_department_name','officer_participating_field_inspection','from_hsw','location','type_of_waterbody','limit_of_survey_area','lattitude','longitude','x_coordinates','y_coordinates','whether_topographic_survey_required','methods_to_be_adopted_for_topographic_survey','instruments_to_be_used_for_topographic_survey','availability_of_previous_shoreline_data','availability_of_shoreline','nature_of_shore','bathymetric_area','scale_of_survey_planned','method_adopted_for_bathymetric_survey','is_manual_survey_required','line_interval_planned_for_survey','type_of_survey_vessel_used_for_bathymetric_survey','estimated_period_of_survey_days','instruments_to_be_used_for_bathymetric_survey','nearest_available_benchmark_detail','is_local_benchmark_needs_to_be_established','detailed_report_of_the_officer','remarks','presence_and_nature_of_obstructions_in_survey','details_location_for_setting_tide_pole'
            ]))->id;

        if(isset($request->upload_photos_of_study_area) && count($request->upload_photos_of_study_area)>0)
        {

            Field_study_report::where("id",$ins)->update(["upload_photos_of_study_area"=>json_encode($request->upload_photos_of_study_area)]);
        }
        Survey_requests::where("id",$request->survey_request_id)->update(["request_status"=>7]);
        $assignment_requests = Survey_requests::where("id",$request->survey_request_id)->first();
                $req_logs = [];
        $req_logs['survey_request_id'] = $request->survey_request_id;
        $req_logs['cust_id'] = $request->cust_id;
        $req_logs['survey_status'] =7;
        $req_logs['is_active'] = 1;
        $req_logs['created_by'] = $user_id;


        Survey_request_logs::create($req_logs);


        $from       = $user_id; 
        $utype      = 2;
        $to         = $assignment_requests->assigned_user; 
        $ntype      = 'field_study_report';
        $title      = 'Field Study Report Submitted';
        $desc       = 'Field Study Report Submitted. Request ID: HSW'.$request->survey_request_id;
        $refId      = $request->survey_request_id;
        $reflink    = 'admin';
        $notify     = 'admin';
        $notify_from_role_id = 3;
        addNotification($from,$utype,$to,$ntype,$title,$desc,$refId,$reflink,$notify,$notify_from_role_id); 

        return ['httpcode'=>200,'status'=>'success','page'=>'Home','message'=>'Success','data'=>['field_study_report_id'=>$ins]];
    }
     public function file_upload(Request $request)
    {  

        $login=0;
        $user_id=null;
        $user = [];
        
        $validator=  Validator::make($request->all(),[
            'file' => ['required','max:100000','mimes:doc,docx,jpg,jpeg,png,bmp,tiff,pdf'],
            'access_token' => ['required']
        ]);
        if ($validator->fails()) 
            {    
              return ['httpcode'=>400,'status'=>'error','message'=>'invalid','data'=>['errors'=>$validator->messages()]];
            }
            
        if($request->post('access_token')){
            if(!$user = validateToken($request->post('access_token'))){ return invalidToken(); }
            $login=1;
            $user_id = $user['user_id'];
            
        }
        
        $file = $request->file;
        $folder_name = "uploads/study_report/" . date("Ym", time()) . '/'.date("d", time()).'/';

        $upload_path = base_path() . '/public/' . $folder_name;

        $extension = strtolower($file->getClientOriginalExtension());

        $filename = "study_report" . '_' . time() . '.' . $extension;

        $file->move($upload_path, $filename);

        $file_path = config('app.url') . "/public/$folder_name/$filename";

        return ['httpcode'=>200,'status'=>'success','message'=>'Success','data'=>['path'=>$file_path]];
    }

    public function get_field_study(Request $request)
    {
         $login=0;
        $user_id=null;
        $user = [];
        
        $validator=  Validator::make($request->all(),[
            'form_id' => ['required'],
            'access_token' => ['required']
        ]);
        if ($validator->fails()) 
            {    
              return ['httpcode'=>400,'status'=>'error','message'=>'invalid','data'=>['errors'=>$validator->messages()]];
            }
            
        if($request->post('access_token')){
            if(!$user = validateToken($request->post('access_token'))){ return invalidToken(); }
            $login=1;
            $user_id = $user['user_id'];
            
        }

        $form_id = $request->form_id;
        $formData = Field_study_report::where("id",$form_id)->first();
        
        if($formData->upload_photos_of_study_area)
        {
          $formData->upload_photos_of_study_area = json_decode($formData->upload_photos_of_study_area);  
        }

        if($formData)
        {
            return ['httpcode'=>200,'status'=>'success','message'=>'Success','data'=>['form'=>$formData]];
        }else{
            return ['httpcode'=>400,'status'=>'error','message'=>'Invalid Form'];
        }
       
        
    }

     public function get_survey_study(Request $request)
    {
         $login=0;
        $user_id=null;
        $user = [];
        
        $validator=  Validator::make($request->all(),[
            'form_id' => ['required'],
            'access_token' => ['required']
        ]);
        if ($validator->fails()) 
            {    
              return ['httpcode'=>400,'status'=>'error','message'=>'invalid','data'=>['errors'=>$validator->messages()]];
            }
            
        if($request->post('access_token')){
            if(!$user = validateToken($request->post('access_token'))){ return invalidToken(); }
            $login=1;
            $user_id = $user['user_id'];
            
        }

        $form_id = $request->form_id;
        $formData = Survey_study_report::where("id",$form_id)->first();
        
        if($formData->upload_photos_of_study_area)
        {
          $formData->upload_photos_of_study_area = json_decode($formData->upload_photos_of_study_area);  
        }
        if($formData)
        {
            return ['httpcode'=>200,'status'=>'success','message'=>'Success','data'=>['form'=>$formData]];
        }else{
            return ['httpcode'=>400,'status'=>'error','message'=>'Invalid Form'];
        }
       
        
    }

    public function update_survey_study(Request $request)
    {  

        $login=0;
        $user_id=null;
        $user = [];
        


        $validator=  Validator::make($request->all(),[
             'form_id' => ['required'],
            'survey_request_id' => ['required'],
            'cust_id' => ['required'],
            'service_id' => ['required'],
            'service_request_id' => ['required'],
            'datetime_inspection' => ['required','date_format:Y-m-d H:i:s'],
            'survey_department_name' => ['required'],
            'officer_participating_field_inspection' => ['required'],
            'from_hsw' => ['required'],
            'location' => ['required'],
            'type_of_waterbody' => ['required'],
                        'lattitude' => ['required'],
            'longitude' => ['required'],
            'x_coordinates' => ['required'],
            'y_coordinates' => ['required'],
            'whether_topographic_survey_required' => ['required'],
            'methods_to_be_adopted_for_topographic_survey' => ['required'],
            'instruments_to_be_used_for_topographic_survey' => ['required'],
            'availability_of_previous_shoreline_data' => ['required'],
            'availability_of_shoreline' => ['required'],
            'nature_of_shore' => ['required'],
            'bathymetric_area' => ['required'],
            'scale_of_survey_planned' => ['required'],
            'method_adopted_for_bathymetric_survey' => ['required'],
            'is_manual_survey_required' => ['required'],
            'line_interval_planned_for_survey' => ['required'],
            'type_of_survey_vessel_used_for_bathymetric_survey' => ['required'],
            'estimated_period_of_survey_days' => ['required'],
            'instruments_to_be_used_for_bathymetric_survey' => ['required'],
            'nearest_available_benchmark_detail' => ['required'],
            'is_local_benchmark_needs_to_be_established' => ['required'],
            'detailed_report_of_the_officer' => ['required'],
            'remarks' => ['required'],
            'presence_and_nature_of_obstructions_in_survey' => ['required'],
            'details_location_for_setting_tide_pole' => ['required'],
            
            'access_token' => ['required']
        ]);
        if ($validator->fails()) 
            {    
              return ['httpcode'=>400,'status'=>'error','message'=>'invalid','data'=>['errors'=>$validator->messages()]];
            }
            
            
        
        if($request->post('access_token')){
            if(!$user = validateToken($request->post('access_token'))){ return invalidToken(); }
            $login=1;
            $user_id = $user['user_id'];
            
        }
        
        $ins = Survey_study_report::where("id",$request->form_id)->update($request->only([
                'survey_request_id','service_id','service_request_id','cust_id','datetime_inspection','survey_department_name','officer_participating_field_inspection','from_hsw','location','type_of_waterbody','limit_of_survey_area','lattitude','longitude','x_coordinates','y_coordinates','whether_topographic_survey_required','methods_to_be_adopted_for_topographic_survey','instruments_to_be_used_for_topographic_survey','availability_of_previous_shoreline_data','availability_of_shoreline','nature_of_shore','bathymetric_area','scale_of_survey_planned','method_adopted_for_bathymetric_survey','is_manual_survey_required','line_interval_planned_for_survey','type_of_survey_vessel_used_for_bathymetric_survey','estimated_period_of_survey_days','instruments_to_be_used_for_bathymetric_survey','nearest_available_benchmark_detail','is_local_benchmark_needs_to_be_established','detailed_report_of_the_officer','remarks','presence_and_nature_of_obstructions_in_survey','details_location_for_setting_tide_pole'
            ]));

        if($request->upload_photos_of_study_area)
        {

            Survey_study_report::where("id",$request->form_id)->update(["upload_photos_of_study_area"=>json_encode($request->upload_photos_of_study_area)]);
        }

        Survey_requests::where("id",$request->survey_request_id)->update(["request_status"=>19]);

        // $req_logs = [];
        // $req_logs['survey_request_id'] = $request->survey_request_id;
        // $req_logs['cust_id'] = $request->cust_id;
        // $req_logs['survey_status'] =19;
        // $req_logs['is_active'] = 1;
        // $req_logs['created_by'] = $user_id;


        // Survey_request_logs::create($req_logs);
        return ['httpcode'=>200,'status'=>'success','page'=>'Home','message'=>'Success','data'=>['survey_study_report_id'=>$request->form_id]];
    }


    public function update_field_study(Request $request)
    {  

        $login=0;
        $user_id=null;
        $user = [];
        


        $validator=  Validator::make($request->all(),[
            'form_id' => ['required'],
            'survey_request_id' => ['required'],
            'cust_id' => ['required'],
            'service_id' => ['required'],
            'service_request_id' => ['required'],
            'datetime_inspection' => ['required','date_format:Y-m-d H:i:s'],
            'survey_department_name' => ['required'],
            'officer_participating_field_inspection' => ['required'],
            'from_hsw' => ['required'],
            'location' => ['required'],
            'type_of_waterbody' => ['required'],
                        'lattitude' => ['required'],
            'longitude' => ['required'],
            'x_coordinates' => ['required'],
            'y_coordinates' => ['required'],
            'whether_topographic_survey_required' => ['required'],
            'methods_to_be_adopted_for_topographic_survey' => ['required'],
            'instruments_to_be_used_for_topographic_survey' => ['required'],
            'availability_of_previous_shoreline_data' => ['required'],
            'availability_of_shoreline' => ['required'],
            'nature_of_shore' => ['required'],
            'bathymetric_area' => ['required'],
            'scale_of_survey_planned' => ['required'],
            'method_adopted_for_bathymetric_survey' => ['required'],
            'is_manual_survey_required' => ['required'],
            'line_interval_planned_for_survey' => ['required'],
            'type_of_survey_vessel_used_for_bathymetric_survey' => ['required'],
            'estimated_period_of_survey_days' => ['required'],
            'instruments_to_be_used_for_bathymetric_survey' => ['required'],
            'nearest_available_benchmark_detail' => ['required'],
            'is_local_benchmark_needs_to_be_established' => ['required'],
            'detailed_report_of_the_officer' => ['required'],
            'remarks' => ['required'],
            'presence_and_nature_of_obstructions_in_survey' => ['required'],
            'details_location_for_setting_tide_pole' => ['required'],
            
            'access_token' => ['required']
        ]);
        if ($validator->fails()) 
            {    
              return ['httpcode'=>400,'status'=>'error','message'=>'invalid','data'=>['errors'=>$validator->messages()]];
            }
            
            
        
        if($request->post('access_token')){
            if(!$user = validateToken($request->post('access_token'))){ return invalidToken(); }
            $login=1;
            $user_id = $user['user_id'];
            
        }
        
        $ins = Field_study_report::where("id",$request->form_id)->update($request->only([
                'survey_request_id','service_id','service_request_id','cust_id','datetime_inspection','survey_department_name','officer_participating_field_inspection','from_hsw','location','type_of_waterbody','limit_of_survey_area','lattitude','longitude','x_coordinates','y_coordinates','whether_topographic_survey_required','methods_to_be_adopted_for_topographic_survey','instruments_to_be_used_for_topographic_survey','availability_of_previous_shoreline_data','availability_of_shoreline','nature_of_shore','bathymetric_area','scale_of_survey_planned','method_adopted_for_bathymetric_survey','is_manual_survey_required','line_interval_planned_for_survey','type_of_survey_vessel_used_for_bathymetric_survey','estimated_period_of_survey_days','instruments_to_be_used_for_bathymetric_survey','nearest_available_benchmark_detail','is_local_benchmark_needs_to_be_established','detailed_report_of_the_officer','remarks','presence_and_nature_of_obstructions_in_survey','details_location_for_setting_tide_pole'
            ]));

        if($request->upload_photos_of_study_area)
        {

            Field_study_report::where("id",$request->form_id)->update(["upload_photos_of_study_area"=>json_encode($request->upload_photos_of_study_area)]);
        }
        Survey_requests::where("id",$request->survey_request_id)->update(["request_status"=>7]);

        //         $req_logs = [];
        // $req_logs['survey_request_id'] = $request->survey_request_id;
        // $req_logs['cust_id'] = $request->cust_id;
        // $req_logs['survey_status'] =7;
        // $req_logs['is_active'] = 1;
        // $req_logs['created_by'] = $user_id;


        // Survey_request_logs::create($req_logs);

        return ['httpcode'=>200,'status'=>'success','page'=>'Home','message'=>'Success','data'=>['field_study_report_id'=>$request->form_id]];
    }
   
}
