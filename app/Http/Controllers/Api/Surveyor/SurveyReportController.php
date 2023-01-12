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
            'limit_of_survey_area' => ['required'],
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
            'upload_photos_of_study_area' => ['mimes:jpeg,jpg,png,gif|required'],
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
        
        $req_type = $request->type;
        if($req_type =="survey")
        {
            $accepted_assignments = Survey_requests::where('assigned_surveyor',$user_id)->where('request_status',40)->get();
        }else{
            $accepted_assignments = Survey_requests::where('assigned_surveyor',$user_id)->where('request_status',41)->get();  
        }
        
        if($accepted_assignments)
        {   
            $assignments_list = [];
            foreach ($accepted_assignments as $ak => $av) {
                
                $a_list['id'] = $av->id;
                $a_list['file_no'] = "HSW".$av->id;
                $a_list['date_of_survey'] = date("d-m-Y",strtotime($av->created_at));
                $a_list['customer_name'] = $av->CustomerInfo->name;
                $assignments_list[] = $a_list;
            }
        }

        return ['httpcode'=>200,'status'=>'success','page'=>'Home','message'=>'Success','data'=>['assignments_list'=>$assignments_list]];
    }

   
}
