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


use App\Models\UserNotification;
use App\Models\Survey_requests;
use App\Models\Survey_request_logs;
use App\Models\Survey_study_report;
use App\Models\Field_study_report;

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
            
            $admin_user =Admin::where('id',$user['user_id'])->first();
            if($admin_user && isset($admin_user->role))
            {
                $user['user_role'] = $admin_user->role->usr_role_name;
            }
            else{
                $user['user_role'] = "Surveyor";
            }
            
        }
        
        $dashboard_data = [];
        $dashboard_data['field']['assignment_requests'] = Survey_requests::where('assigned_surveyor',$user_id)->whereIn('request_status',[41])->count();
        $dashboard_data['field']['accepted_assignments'] = Survey_requests::where('assigned_surveyor',$user_id)->whereIn('request_status',[42])->count();
        $dashboard_data['field']['accepted_reassignments'] = Survey_requests::where('assigned_surveyor',$user_id)->whereIn('request_status',[60])->count();
        $dashboard_data['survey']['assignment_requests'] = Survey_requests::where('assigned_surveyor_survey',$user_id)->whereIn('request_status',[43])->count();
        $dashboard_data['survey']['accepted_assignments'] = Survey_requests::where('assigned_surveyor_survey',$user_id)->whereIn('request_status',[40])->count();
        $dashboard_data['survey']['accepted_reassignments'] = Survey_requests::where('assigned_surveyor_survey',$user_id)->whereIn('request_status',[59])->count();
        return ['httpcode'=>200,'status'=>'success','page'=>'Home','message'=>'Success','data'=>['user_data'=>$user,'dashboard_data'=>$dashboard_data]];
    }

     public function notifications(Request $request)
    {  

        $login=0;
        $user_id=null;
        $user = [];
        
        $validator=  Validator::make($request->all(),[

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
            
            $admin_user =Admin::where('id',$user['user_id'])->first();
            if($admin_user && isset($admin_user->role))
            {
                $user['user_role'] = $admin_user->role->usr_role_name;
            }
            else{
                $user['user_role'] = "Surveyor";
            }
            
        }
        
        $dashboard_data = [];
        $notifications = UserNotification::where('notify_to',$user_id)->where('role_id',3)->whereNull('deleted_at')->orderBy('created_at', 'DESC')->get();

        $grouped = $notifications->groupBy(function ($item) {
        return $item->created_at->format('d-M-y');
        });

         $days_notify = []; $c=0;
        foreach($grouped as $days_row)
            {   
                $notification_date = ""; $all = []; //dd($grouped);
                foreach($days_row as $row)
                {
                    if(date('Ymd') == date('Ymd', strtotime($row->created_at)))
                    {
                        $notification_date =  "Today";
                    }else if(date('Ymd', strtotime('-1 day')) == date('Ymd', strtotime($row->created_at))){
                        $notification_date =  "Yesterday";
                    }else{
                        $notification_date =  date('d/m/Y', strtotime($row->created_at));
                    }



                   $msgs['title']       = $row->title;
                   $msgs['description'] = $row->description;
                   $msgs['icon']      = $row->icon;
                   $msgs['ref_id']    = $row->ref_id;
                   $msgs['ref_link']    = $row->ref_link;
                   $msgs['viewed']      = $row->viewed;
                   $msgs['created_at'] = date('Y-m-d H:i:s', strtotime($row->created_at));

                   
                   $all[]              = $msgs;
                   
               }

               $days_notify[$c]['day'] = $notification_date;
                   $days_notify[$c]['notifications'] = $all;
              $c++;
            }
 
         if(isset($days_notify) && count($days_notify)>0)
            {
                return ['httpcode'=>200,'status'=>'success','message'=>'Success','data'=>['user_data'=>$user,'notifications'=>$days_notify]]; 
            }else{
                 return ['httpcode'=>400,'status'=>'error','message'=>'Notifications not found','data'=>['user_data'=>$user,'notifications'=>$days_notify]];
            }
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
            $accepted_assignments = Survey_requests::where('assigned_surveyor',$user_id)->where('request_status',42)->get();  
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

    public function assignments_requests(Request $request)
    {  

        $login=0;
        $user_id=null;
        $user = [];
        
        $validator=  Validator::make($request->all(),[
            'device_id' => ['required'],
            'type' => ['required', Rule::in(['survey', 'field_study','reassignment'])],
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
            $assignment_requests = Survey_requests::where('assigned_surveyor_survey',$user_id)->where('request_status',43)->get();
        }else if($req_type =="reassignment")
        {
            $assignment_requests = Survey_requests::where('assigned_surveyor_survey',$user_id)->orWhere('assigned_surveyor',$user_id)->whereIn('request_status',[20,30,32,33,36,37])->get();
        }else{
            $assignment_requests = Survey_requests::where('assigned_surveyor',$user_id)->where('request_status',41)->get();  
        }
        
        if($assignment_requests)
        {   
            $assignments_list = [];
            foreach ($assignment_requests as $ak => $av) {
               
                $a_list['id'] = $av->id;
                $a_list['file_no'] = "HSW".$av->id;
                $a_list['date_of_survey'] = date("d-m-Y",strtotime($av->created_at));
                $a_list['customer_name'] = $av->CustomerInfo->name;
                $a_list['cust_id'] = $av->cust_id;
                $a_list['service_id'] = $av->service_id;
                if($av->service_info)
                {
                    // dd($av->service_info);
                   $a_list['description'] = $av->service_info->description; 
                }else{
                    $a_list['description'] = ""; 
                }
                $a_list['service_request_id'] = $av->service_request_id;
                $assignments_list[] = $a_list;
            }
        }

        return ['httpcode'=>200,'status'=>'success','page'=>'Home','message'=>'Success','data'=>['assignments_list'=>$assignments_list]];
    }

    public function assignments_requests_status(Request $request)
    {  

        $login=0;
        $user_id=null;
        $user = [];
        
        $validator=  Validator::make($request->all(),[
            'device_id' => ['required'],
            'type' => ['required', Rule::in(['survey', 'field_study','reassignment'])],
            'access_token' => ['required'],
            'action' => ['required', Rule::in(['accept', 'reject'])],
            'request_id' => ['required'],
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
        $request_id = $request->request_id;
        $req_action = $request->action;
        if($req_type =="survey")
        {
            $assignment_requests = Survey_requests::where('assigned_surveyor_survey',$user_id)->where("id",$request_id)->where('request_status',43)->first();
        }else if($req_type =="reassignment")
        {
            $assignment_requests = Survey_requests::where('assigned_surveyor_survey',$user_id)->orWhere('assigned_surveyor',$user_id)->whereIn('request_status',[20,30,32,33,36,37])->where("id",$request_id)->first();
        }else{
            $assignment_requests = Survey_requests::where('assigned_surveyor',$user_id)->where("id",$request_id)->where('request_status',41)->first();  
        }
        
        if($assignment_requests)
        {   
            if($req_type =="survey")
            {
                if($req_action == "accept") { $request_status = 40;  $remarks =""; }else{ $request_status = 44;  $remarks = $request->remarks; }
            Survey_requests::where("id",$assignment_requests->id)->update(["request_status"=>$request_status,"remarks"=>$remarks]);
            // $assignment_requests = Survey_requests::where('assigned_surveyor_survey',$user_id)->where("id",$request_id)->where('request_status',43)->first();
            
            $req_logs = [];
            $req_logs['survey_request_id'] = $request_id;
            $req_logs['cust_id'] = $assignment_requests->cust_id;
            $req_logs['survey_status'] =$request_status;
            $req_logs['is_active'] = 1;
            $req_logs['created_by'] = $user_id;

                if($req_action == "accept") {
                $from       = $user_id; 
                $utype      = 6;
                $to         = $assignment_requests->cust_id; 
                $ntype      = 'survey_study_accepted';
                $title      = 'Survey Study Accepted';
                $desc       = 'Survey Study Request Accepted. Request ID: HSW'.$request_id;
                $refId      = $request_id;
                $reflink    = 'customer';
                $notify     = 'customer';
                $notify_from_role_id = 3;
                addNotification($from,$utype,$to,$ntype,$title,$desc,$refId,$reflink,$notify,$notify_from_role_id);
                }

        
            }else if($req_type =="reassignment")
            {
                if(in_array($assignment_requests->request_status,[30,32,33]))
                {
                    $request_status = 60;
                }else{
                    $request_status = 59;
                }
                
            Survey_requests::where("id",$assignment_requests->id)->update(["request_status"=>$request_status]);
            
            $req_logs = [];
            $req_logs['survey_request_id'] = $request_id;
            $req_logs['cust_id'] = $assignment_requests->cust_id;
            $req_logs['survey_status'] =$request_status;
            $req_logs['is_active'] = 1;
            $req_logs['created_by'] = $user_id;


            if($req_action == "accept") {

                if($request_status ==60)
                {
                    $from       = $user_id; 
                    $utype      = 6;
                    $to         = $assignment_requests->cust_id; 
                    $ntype      = 'field_study_accepted';
                    $title      = 'Field Study Accepted';
                    $desc       = 'Field Study Request Accepted. Request ID: HSW'.$request_id;
                    $refId      = $request_id;
                    $reflink    = 'customer';
                    $notify     = 'customer';
                    $notify_from_role_id = 3;
                    addNotification($from,$utype,$to,$ntype,$title,$desc,$refId,$reflink,$notify,$notify_from_role_id); 
                }else{
                    $from       = $user_id; 
                    $utype      = 6;
                    $to         = $assignment_requests->cust_id; 
                    $ntype      = 'survey_study_accepted';
                    $title      = 'Survey Study Accepted';
                    $desc       = 'Survey Study Request Accepted. Request ID: HSW'.$request_id;
                    $refId      = $request_id;
                    $reflink    = 'customer';
                    $notify     = 'customer';
                    $notify_from_role_id = 3;
                    addNotification($from,$utype,$to,$ntype,$title,$desc,$refId,$reflink,$notify,$notify_from_role_id);  
                }

                }
        
            }else{
                if($req_action == "accept") { $request_status = 42; $remarks =""; }else{ $request_status = 45; $remarks = $request->remarks; }
                Survey_requests::where("id",$assignment_requests->id)->update(["request_status"=>$request_status,"remarks"=>$remarks]);
                // $assignment_requests = Survey_requests::where('assigned_surveyor',$user_id)->where("id",$request_id)->where('request_status',41)->first();
                
                            $req_logs = [];
            $req_logs['survey_request_id'] = $request_id;
            $req_logs['cust_id'] = $assignment_requests->cust_id;
            $req_logs['survey_status'] =$request_status;
            $req_logs['is_active'] = 1;
            $req_logs['created_by'] = $user_id;
            
            if($req_action == "accept") {
                    $from       = $user_id; 
                    $utype      = 6;
                    $to         = $assignment_requests->cust_id; 
                    $ntype      = 'field_study_accepted';
                    $title      = 'Field Study Accepted';
                    $desc       = 'Field Study Request Accepted. Request ID: HSW'.$request_id;
                    $refId      = $request_id;
                    $reflink    = 'customer';
                    $notify     = 'customer';
                    $notify_from_role_id = 3;
                    addNotification($from,$utype,$to,$ntype,$title,$desc,$refId,$reflink,$notify,$notify_from_role_id); 
                }
            
            }
            Survey_request_logs::create($req_logs);

                
                
            return ['httpcode'=>200,'status'=>'success','message'=>'Status Updated Successfully','data'=>['assignment_request'=>$assignment_requests]];

        }else{

           return ['httpcode'=>400,'status'=>'error','message'=>'Invalid Request Status or Request Not Found']; 
        }

        
    }


     public function accepted_reassignments(Request $request)
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
            $accepted_assignments = Survey_requests::where('assigned_surveyor_survey',$user_id)->where('request_status',59)->get();
        }else{
            $accepted_assignments = Survey_requests::where('assigned_surveyor',$user_id)->where('request_status',60)->get();  
        }
        
        if($accepted_assignments)
        {   
            $assignments_list = [];
            foreach ($accepted_assignments as $ak => $av) {
                
                $remarks = ""; $form_id = 0;
                if($req_type =="survey")
                {
                $remark = Survey_request_logs::where('survey_request_id',$av->id)->whereIn('survey_status',[20,36,37])->orderBy('created_at', 'desc')->first();
                $form_id = Survey_study_report::where("survey_request_id",$av->id)->first();    
                }else{
                 $remark = Survey_request_logs::where('survey_request_id',$av->id)->whereIn('survey_status',[30,32,33])->orderBy('created_at', 'desc')->first();  
                 $form_id = Field_study_report::where("survey_request_id",$av->id)->first();
                }
                if($remark){ $remarks = $remark->remarks; }
                if($form_id){ $form_id = $form_id->id; }
                $a_list['id'] = $av->id;
                $a_list['file_no'] = "HSW".$av->id;
                $a_list['date_of_survey'] = date("d-m-Y",strtotime($av->created_at));
                $a_list['customer_name'] = $av->CustomerInfo->name;
                $a_list['cust_id'] = $av->cust_id;
                $a_list['service_id'] = $av->service_id;
                $a_list['service_request_id'] = $av->service_request_id;
                $a_list['remark'] = $remarks;
                $a_list['request_type'] = $req_type;
                $a_list['form_id'] = $form_id;
                $assignments_list[] = $a_list;
            }
        }

        return ['httpcode'=>200,'status'=>'success','page'=>'Home','message'=>'Success','data'=>['assignments_list'=>$assignments_list]];
    }

   
}
