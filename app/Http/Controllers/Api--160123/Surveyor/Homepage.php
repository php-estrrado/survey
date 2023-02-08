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

class Homepage extends Controller
{
    public function index(Request $request)
    {  
		//dd($request->post);
        // $lang_id=$request->lang_id;
        $login=0;
        $user_id=null;
        $user = [];
        
        $validator=  Validator::make($request->all(),[
            'device_id' => ['required'],
            'access_token' => ['required'],
            'os_type'=> ['required','string','min:3','max:3'],
            'page_url'=>['required']
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
        
        $dashboard_data = [];
        $dashboard_data['assignment_requests'] = Survey_requests::where('assigned_surveyor',$user_id)->count();
        $dashboard_data['accepted_assignments'] = Survey_requests::where('assigned_surveyor',$user_id)->where('request_status',40)->count();
        $dashboard_data['accepted_reassignments'] = 12;

        return ['httpcode'=>200,'status'=>'success','page'=>'Home','message'=>'Success','data'=>['user_data'=>$user,'dashboard_data'=>$dashboard_data]];
    }

   public function accepted_assignments(Request $request)
    {  

        $login=0;
        $user_id=null;
        $user = [];
        
        $validator=  Validator::make($request->all(),[
            'device_id' => ['required'],
            'type' => ['required', Rule::in(['survey', 'field_study'])],
            'access_token' => ['required'],
            'os_type'=> ['required','string','min:3','max:3'],
            'page_url'=>['required']
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
                $a_list['cust_id'] = $av->cust_id;
                $a_list['service_id'] = $av->service_id;
                $a_list['service_request_id'] = $av->service_request_id;
                $assignments_list[] = $a_list;
            }
        }

        return ['httpcode'=>200,'status'=>'success','page'=>'Home','message'=>'Success','data'=>['assignments_list'=>$assignments_list]];
    }

   
}
