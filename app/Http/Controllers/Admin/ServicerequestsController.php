<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\Facades\Image;
use Session;
use DB;
use Response;
use App\Models\Modules;
// use App\Models\UserRoles;
use App\Models\Admin;
use App\Models\State;
use App\Models\City;
use App\Models\customer\CustomerMaster;
use App\Models\customer\CustomerInfo;
use App\Models\customer\CustomerTelecom;
use App\Models\Institution;
use App\Models\Services;
use App\Models\UserRole;
use App\Models\Survey_requests;
use App\Models\Survey_request_logs;
use App\Models\Field_study_report;
use App\Models\Survey_study_report;
use App\Models\Fieldstudy_eta;
use App\Models\Survey_invoice;
use App\Models\Survey_performa_invoice;
use App\Models\Survey_status;
use App\Models\AdminNotification;
use App\Models\UserNotification;
use App\Models\SurveyType;

use App\Rules\Name;
use Validator;

class ServicerequestsController extends Controller
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
   
    
    // user roles and modules
    
    public function new_service_requests()
    { 
        $data['title']              =   'New Service Request';
        $data['menu']               =   'new-service-request';
        
        $status_in  = array(2,6,16);
        $data['survey_requests']    =   DB::table('survey_requests')
                                        ->leftjoin('cust_mst', 'survey_requests.cust_id', '=', 'cust_mst.id')
                                        ->leftjoin('cust_info', 'survey_requests.cust_id', '=', 'cust_info.cust_id')
                                        ->leftjoin('cust_telecom', 'survey_requests.cust_id', '=', 'cust_telecom.cust_id')
                                        ->leftjoin('services', 'survey_requests.service_id', '=', 'services.id')
                                        ->whereIn('survey_requests.request_status',$status_in)->where('assigned_user',auth()->user()->id)->Where('survey_requests.is_deleted',0)
                                        ->where('cust_mst.is_deleted',0)
                                        ->where('cust_telecom.is_deleted',0)->where('cust_telecom.telecom_type',2)
                                        ->select('survey_requests.id AS survey_id','survey_requests.created_at AS survey_date','survey_requests.*','cust_mst.*','cust_info.*', 'cust_telecom.*','services.*')
                                        ->orderBy('survey_requests.id','DESC')
                                        ->get();

        // dd($data);

        return view('admin.new_service_requests',$data);
    }


     public function services_repository(Request $request)
    { 
        $data['title']              =   'Repository Management';
        $data['menu']               =   'repository-management';
        
        $status_not                 =   array(1,2,3,4);
        $data['survey_requests']    =   DB::table('survey_requests')
                                        ->leftjoin('cust_mst', 'survey_requests.cust_id', '=', 'cust_mst.id')
                                        ->leftjoin('cust_info', 'survey_requests.cust_id', '=', 'cust_info.cust_id')
                                        ->leftjoin('cust_telecom', 'survey_requests.cust_id', '=', 'cust_telecom.cust_id')
                                        ->leftjoin('services', 'survey_requests.service_id', '=', 'services.id')
                                        ->leftjoin('institution', 'survey_requests.assigned_institution', '=', 'institution.id')
                                        ->leftjoin('survey_status', 'survey_requests.request_status', '=', 'survey_status.id')
                                        ->whereIn('survey_requests.request_status',[27])->where('survey_requests.request_status','!=',NULL)->Where('survey_requests.is_deleted',0)
                                        ->where('cust_mst.is_deleted',0)
                                        
                                        ->where('cust_telecom.is_deleted',0)->where('cust_telecom.telecom_type',2)
                                        ->select('survey_requests.id AS survey_id','survey_requests.created_at AS survey_date','survey_requests.*','cust_mst.*','cust_info.*', 'cust_telecom.*','services.*','institution.*','survey_status.status_name AS current_status')

                                        ->orderBy('survey_requests.id','DESC')
                                        ->get();

        // dd($data);

        return view('admin.repository',$data);
    }

    public function new_service_request_detail($id,$status)
    {
        $data['title']              =   'Requested Services';
        $data['menu']               =   'requested-services';

        $datas = Survey_requests::where('id',$id)->first();
        
        $cust_id = $datas->cust_id;
        $data['cust_info'] = CustomerInfo::where('cust_id',$cust_id)->where('is_deleted',0)->first();
        $data['cust_phone'] = CustomerTelecom::where('cust_id',$cust_id)->where('telecom_type',2)->where('is_deleted',0)->first()->cust_telecom_value;
        $data['cust_email'] = CustomerTelecom::where('cust_id',$cust_id)->where('telecom_type',1)->where('is_deleted',0)->first()->cust_telecom_value;

        $data['service'] = Services::where('id',$datas->service_id)->first()->service_name;
        $data['survey_id'] = $id;
        $data['institutions'] = Institution::where('is_deleted',0)->where('is_active',1) ->get();
        $data['surveyors'] = Admin::where('role_id',3)->get();

        if($datas->service_id == 1)
        {
            $data['request_data'] = $datas->Hydrographic_survey->first();
        }
        elseif($datas->service_id == 2)
        {
            $data['request_data'] = $datas->Tidal_observation->first();
        }
        elseif($datas->service_id == 3)
        {
            $data['request_data'] = $datas->Bottom_sample_collection->first();
        }
        elseif($datas->service_id == 4)
        {
            $data['request_data'] = $datas->Dredging_survey->first();
        }
        elseif($datas->service_id == 5)
        {
            $data['request_data'] = $datas->Hydrographic_chart->first();
        }
        elseif($datas->service_id == 6)
        {
            $data['request_data'] = $datas->Underwater_videography->first();
        }
        elseif($datas->service_id == 7)
        {
            $data['request_data'] = $datas->Currentmeter_observation->first();
        }
        elseif($datas->service_id == 8)
        {
            $data['request_data'] = $datas->Sidescansonar->first();
        }
        elseif($datas->service_id == 9)
        {
            $data['request_data'] = $datas->Topographic_survey->first();
        }
        elseif($datas->service_id == 10)
        {
            $data['request_data'] = $datas->Subbottom_profilling->first();
        }
        elseif($datas->service_id == 11)
        {
            $data['request_data'] = $datas->Bathymetry_survey->first();
        }

        if(isset($data['request_data']->additional_services))
        {
           $data['additional_services'] = $datas->services_selected($data['request_data']->additional_services);
        }else{
             $data['additional_services'] ="";
        }

        if(isset($data['request_data']->data_collection_equipments))
        {
           $data['data_collection'] = $datas->datacollection_selected($data['request_data']->data_collection_equipments);
        }else{
             $data['data_collection'] ="";
        }


        $data['state_name'] = State::where('id',$data['request_data']['state'])->first()->state_name;
        $data['district_name'] = City::where('id',$data['request_data']['district'])->first()->city_name;

        // dd($status);

        if($status == 6)
        {
            return view('admin.service_request_reject_detail',$data);
        }
        else
        {
            return view('admin.new_service_request_detail',$data);
        }
    }

    public function assign_surveyor(Request $request)
    {
        $input = $request->all();

        $validator = Validator::make($request->all(), [
            'id'=>['required'],
            'assign_surveyor'=>['required'],
            'field_study'=>['required'],
            'remarks'=>['nullable'],
        ]);

        if($validator->passes())
        {
            $cust_id = survey_requests::where('id',$input['id'])->first()->cust_id;

            $assign_arr['request_status'] = 41;
            $assign_arr['assigned_surveyor'] = $input['assign_surveyor'];
            $assign_arr['field_study'] = date('Y-m-d',strtotime($input['field_study']));
            $assign_arr['updated_by'] = auth()->user()->id;
            $assign_arr['updated_at'] = date('Y-m-d H:i:s');

            Survey_requests::where('id',$input['id'])->update($assign_arr);

            $from       = auth()->user()->id; 
            $utype      = 3;
            $to         = $input['assign_surveyor']; 
            $ntype      = 'field_study_assigned';
            $title      = 'New Field Study Request';
            $desc       = 'New Field Study Request. Request ID:HSW'.$input['id'];
            $refId      = $input['id'];
            $reflink    = 'field_study_request';
            $notify     = 'surveyor';
            $notify_from_role_id = 2;
            addNotification($from,$utype,$to,$ntype,$title,$desc,$refId,$reflink,$notify,$notify_from_role_id);

            // notify customer
            $from       = auth()->user()->id; 
            $utype      = 6;
            $to         = $cust_id; 
            $ntype      = 'field_study_assigned';
            $title      = 'Field Study Request Created';
            $desc       = 'Field Study Request Created To Surveyor. Request ID:HSW'.$input['id'];
            $refId      = $input['id'];
            $reflink = '/customer/request_service_detail/'.$input['id'].'/41/';
            $notify     = 'customer';
            $notify_from_role_id = 2;
            addNotification($from,$utype,$to,$ntype,$title,$desc,$refId,$reflink,$notify,$notify_from_role_id);

            $survey_request_logs = [];

            $survey_request_logs['survey_request_id'] = $input['id'];
            $survey_request_logs['cust_id'] = $cust_id;
            $survey_request_logs['survey_status'] = 41;
            $survey_request_logs['remarks'] = $input['remarks'];
            $survey_request_logs['is_active'] = 1;
            $survey_request_logs['is_deleted'] = 0;
            $survey_request_logs['created_by'] = auth()->user()->id;
            $survey_request_logs['updated_by'] = auth()->user()->id;
            $survey_request_logs['created_at'] = date('Y-m-d H:i:s');
            $survey_request_logs['updated_at'] = date('Y-m-d H:i:s');

            $survey_request_log_id = Survey_request_logs::create($survey_request_logs)->id;

            if(isset($survey_request_log_id))
            {   
                Session::flash('message', ['text'=>'Successfully Assigned to Surveyor for Field Study !','type'=>'success']);  
            }
            else
            {
                Session::flash('message', ['text'=>'Assigning Surveyor for Field Study is not Successfull !','type'=>'danger']);
            }

            return redirect('/admin/new_service_requests');
        }
        else
        {
            return redirect()->back()->withErrors($validator)->withInput($request->all());
        }
    }

    public function reschedule_field_surveyor(Request $request)
    {
        $input = $request->all();

        $validator = Validator::make($request->all(), [
            'id'=>['required'],
            'field_study'=>['required'],
            'remarks'=>['nullable'],
        ]);

        if($validator->passes())
        {
            $cust_id = survey_requests::where('id',$input['id'])->first()->cust_id;
            $assigned_surveyor = survey_requests::where('id',$input['id'])->first()->assigned_surveyor;

            $assign_arr['request_status'] = 62;
            $assign_arr['field_study'] = date('Y-m-d',strtotime($input['field_study']));
            $assign_arr['updated_by'] = auth()->user()->id;
            $assign_arr['updated_at'] = date('Y-m-d H:i:s');

            Survey_requests::where('id',$input['id'])->update($assign_arr);

            $survey_request_logs = [];

            $survey_request_logs['survey_request_id'] = $input['id'];
            $survey_request_logs['cust_id'] = $cust_id;
            $survey_request_logs['survey_status'] = 62;
            $survey_request_logs['remarks'] = $input['remarks'];
            $survey_request_logs['is_active'] = 1;
            $survey_request_logs['is_deleted'] = 0;
            $survey_request_logs['created_by'] = auth()->user()->id;
            $survey_request_logs['updated_by'] = auth()->user()->id;
            $survey_request_logs['created_at'] = date('Y-m-d H:i:s');
            $survey_request_logs['updated_at'] = date('Y-m-d H:i:s');

            $survey_request_log_id = Survey_request_logs::create($survey_request_logs)->id;

            $from       = auth()->user()->id; 
            $utype      = 3;
            $to         = $assigned_surveyor; 
            $ntype      = 'field_study_rescheduled';
            $title      = 'Field Study Rescheduled';
            $desc       = 'Field Study Rescheduled. Request ID:HSW'.$input['id'];
            $refId      = $input['id'];
            $reflink    = 'field_study_rescheduled';
            $notify     = 'surveyor';
            $notify_from_role_id = 2;
            addNotification($from,$utype,$to,$ntype,$title,$desc,$refId,$reflink,$notify,$notify_from_role_id);

            // // notify customer
            // $from       = auth()->user()->id; 
            // $utype      = 6;
            // $to         = $input['assign_surveyor']; 
            // $ntype      = 'field_study_rescheduled';
            // $title      = 'Field Study Rescheduled';
            // $desc       = 'Field Study Rescheduled By Surveyor. Request ID:HSW'.$input['id'];
            // $refId      = $input['id'];
            // $reflink    = 'field_study_rescheduled';
            // $notify     = 'customer';
            // $notify_from_role_id = 2;
            // addNotification($from,$utype,$to,$ntype,$title,$desc,$refId,$reflink,$notify,$notify_from_role_id);

            $usr_noti = [];

            $usr_noti['notify_from'] = auth()->user()->id;
            $usr_noti['notify_to'] = $cust_id;
            $usr_noti['role_id'] = 6;
            $usr_noti['notify_from_role_id'] = 2;
            $usr_noti['notify_type'] = 0;
            $usr_noti['title'] = 'Field Study Rescheduled';
            $usr_noti['ref_id'] = auth()->user()->id;
            $usr_noti['ref_link'] = '#';
            $usr_noti['viewed'] = 0;
            $usr_noti['created_at'] = date('Y-m-d H:i:s');
            $usr_noti['updated_at'] = date('Y-m-d H:i:s');
            $usr_noti['deleted_at'] = date('Y-m-d H:i:s');

            UserNotification::create($usr_noti);

            if(isset($survey_request_log_id))
            {   
                Session::flash('message', ['text'=>'Successfully Approved Surveyor Reschedule Request !','type'=>'success']);  
            }
            else
            {
                Session::flash('message', ['text'=>'Approving Surveyor Reschedule Request is Not Successfull !','type'=>'danger']);
            }

            return redirect('/admin/requested_services');
        }
        else
        {
            return redirect()->back()->withErrors($validator)->withInput($request->all());
        }
    }
    
    public function assign_surveyor_survey(Request $request)
    {
        $input = $request->all();

        $validator = Validator::make($request->all(), [
            'id'=>['required'],
            'assign_surveyor'=>['required'],
            'survey_study'=>['required'],
            'remarks' => ['nullable']
        ]);

        if($validator->passes())
        {
            $cust_id = survey_requests::where('id',$input['id'])->first()->cust_id;

            $assign_arr['request_status'] = 43;
            $assign_arr['assigned_surveyor_survey'] = $input['assign_surveyor'];
            $assign_arr['survey_study'] = date('Y-m-d',strtotime($input['survey_study']));
            $assign_arr['updated_by'] = auth()->user()->id;
            $assign_arr['updated_at'] = date('Y-m-d H:i:s');

            Survey_requests::where('id',$input['id'])->update($assign_arr);

            $from       = auth()->user()->id; 
            $utype      = 3;
            $to         = $input['assign_surveyor']; 
            $ntype      = 'survey_study_assigned';
            $title      = 'New Survey Study Request';
            $desc       = 'New Survey Study Request. Request ID:HSW'.$input['id'];
            $refId      = $input['id'];
            $reflink    = 'survey_study_request';
            $notify     = 'surveyor';
            $notify_from_role_id = 2;
            addNotification($from,$utype,$to,$ntype,$title,$desc,$refId,$reflink,$notify,$notify_from_role_id);

            // notify customer
            $from       = auth()->user()->id; 
            $utype      = 6;
            $to         = $cust_id; 
            $ntype      = 'survey_study_assigned';
            $title      = 'Survey Study Request Created';
            $desc       = 'Survey Study Request Created To Surveyor. Request ID:HSW'.$input['id'];
            $refId      = $input['id'];
             $reflink = '/customer/request_service_detail/'.$input['id'].'/43/';
            $notify     = 'customer';
            $notify_from_role_id = 2;
            addNotification($from,$utype,$to,$ntype,$title,$desc,$refId,$reflink,$notify,$notify_from_role_id);


            $survey_request_logs = [];

            $survey_request_logs['survey_request_id'] = $input['id'];
            $survey_request_logs['cust_id'] = $cust_id;
            $survey_request_logs['survey_status'] = 43;
            $survey_request_logs['remarks'] = $input['remarks'];
            $survey_request_logs['is_active'] = 1;
            $survey_request_logs['is_deleted'] = 0;
            $survey_request_logs['created_by'] = auth()->user()->id;
            $survey_request_logs['updated_by'] = auth()->user()->id;
            $survey_request_logs['created_at'] = date('Y-m-d H:i:s');
            $survey_request_logs['updated_at'] = date('Y-m-d H:i:s');

            $survey_request_log_id = Survey_request_logs::create($survey_request_logs)->id;

            if(isset($survey_request_log_id))
            {   
                Session::flash('message', ['text'=>'Successfully Assigned to Surveyor for Survey Study !','type'=>'success']);  
            }
            else
            {
                Session::flash('message', ['text'=>'Assigning Surveyor for Survey Study is not Successfull !','type'=>'danger']);
            }

            return redirect('/admin/requested_services');
        }
        else
        {
            return redirect()->back()->withErrors($validator)->withInput($request->all());
        }
    }

    public function reschedule_surveyor_survey(Request $request)
    {
        $input = $request->all();

        $validator = Validator::make($request->all(), [
            'id'=>['required'],
            'survey_study'=>['required'],
            'remarks' => ['nullable']
        ]);

        if($validator->passes())
        {
            $cust_id = survey_requests::where('id',$input['id'])->first()->cust_id;
            $assigned_surveyor = survey_requests::where('id',$input['id'])->first()->assigned_surveyor_survey;

            $assign_arr['request_status'] = 65;
            $assign_arr['survey_study'] = date('Y-m-d',strtotime($input['survey_study']));
            $assign_arr['updated_by'] = auth()->user()->id;
            $assign_arr['updated_at'] = date('Y-m-d H:i:s');

            Survey_requests::where('id',$input['id'])->update($assign_arr);

            $survey_request_logs = [];

            $survey_request_logs['survey_request_id'] = $input['id'];
            $survey_request_logs['cust_id'] = $cust_id;
            $survey_request_logs['survey_status'] = 65;
            $survey_request_logs['remarks'] = $input['remarks'];
            $survey_request_logs['is_active'] = 1;
            $survey_request_logs['is_deleted'] = 0;
            $survey_request_logs['created_by'] = auth()->user()->id;
            $survey_request_logs['updated_by'] = auth()->user()->id;
            $survey_request_logs['created_at'] = date('Y-m-d H:i:s');
            $survey_request_logs['updated_at'] = date('Y-m-d H:i:s');

            $survey_request_log_id = Survey_request_logs::create($survey_request_logs)->id;

            $from       = auth()->user()->id; 
            $utype      = 3;
            $to         = $assigned_surveyor; 
            $ntype      = 'survey_study_rescheduled';
            $title      = 'Survey Study Rescheduled';
            $desc       = 'Survey Study Rescheduled. Request ID:HSW'.$input['id'];
            $refId      = $input['id'];
            $reflink    = 'survey_study_rescheduled';
            $notify     = 'surveyor';
            $notify_from_role_id = 2;
            addNotification($from,$utype,$to,$ntype,$title,$desc,$refId,$reflink,$notify,$notify_from_role_id);

            // // notify customer
            // $from       = auth()->user()->id; 
            // $utype      = 6;
            // $to         = $input['assign_surveyor']; 
            // $ntype      = 'survey_study_rescheduled';
            // $title      = 'Survey Study Rescheduled';
            // $desc       = 'Survey Study Rescheduled By Surveyor. Request ID:HSW'.$input['id'];
            // $refId      = $input['id'];
            // $reflink    = 'survey_study_rescheduled';
            // $notify     = 'customer';
            // $notify_from_role_id = 2;
            // addNotification($from,$utype,$to,$ntype,$title,$desc,$refId,$reflink,$notify,$notify_from_role_id);


            $usr_noti = [];

            $usr_noti['notify_from'] = auth()->user()->id;
            $usr_noti['notify_to'] = $cust_id;
            $usr_noti['role_id'] = 6;
            $usr_noti['notify_from_role_id'] = 2;
            $usr_noti['notify_type'] = 0;
            $usr_noti['title'] = 'Survey Study Rescheduled';
            $usr_noti['ref_id'] = auth()->user()->id;
            $usr_noti['ref_link'] = '#';
            $usr_noti['viewed'] = 0;
            $usr_noti['created_at'] = date('Y-m-d H:i:s');
            $usr_noti['updated_at'] = date('Y-m-d H:i:s');
            $usr_noti['deleted_at'] = date('Y-m-d H:i:s');

            UserNotification::create($usr_noti);

            if(isset($survey_request_log_id))
            {   
                Session::flash('message', ['text'=>'Successfully Approved Surveyor Reschedule Request !','type'=>'success']);  
            }
            else
            {
                Session::flash('message', ['text'=>'Approving Surveyor Reschedule Request is Not Successfull !','type'=>'danger']);
            }

            return redirect('/admin/requested_services');
        }
        else
        {
            return redirect()->back()->withErrors($validator)->withInput($request->all());
        }
    }

    public function reject_fieldstudy_reschedule(Request $request)
    {
        $input = $request->all();

        $validator = Validator::make($request->all(), [
            'id'=>['required'],
            'remarks'=>['required'],
        ]);

        if($validator->passes())
        {
            $cust_id = survey_requests::where('id',$input['id'])->first()->cust_id;
            $assigned_surveyor = survey_requests::where('id',$input['id'])->first()->assigned_surveyor;

            $assign_arr['request_status'] = 63;
            $assign_arr['updated_by'] = auth()->user()->id;
            $assign_arr['updated_at'] = date('Y-m-d H:i:s');

            Survey_requests::where('id',$input['id'])->update($assign_arr);

            $survey_request_logs = [];

            $survey_request_logs['survey_request_id'] = $input['id'];
            $survey_request_logs['cust_id'] = $cust_id;
            $survey_request_logs['survey_status'] = 63;
            $survey_request_logs['remarks'] = $input['remarks'];
            $survey_request_logs['is_active'] = 1;
            $survey_request_logs['is_deleted'] = 0;
            $survey_request_logs['created_by'] = auth()->user()->id;
            $survey_request_logs['updated_by'] = auth()->user()->id;
            $survey_request_logs['created_at'] = date('Y-m-d H:i:s');
            $survey_request_logs['updated_at'] = date('Y-m-d H:i:s');

            $survey_request_log_id = Survey_request_logs::create($survey_request_logs)->id;

            $from       = auth()->user()->id; 
            $utype      = 3;
            $to         = $assigned_surveyor; 
            $ntype      = 'field_study_reschedule_rejected';
            $title      = 'Field Study Reschedule Rejected';
            $desc       = 'Field Study Reschedule Rejected. Request ID:HSW'.$input['id'];
            $refId      = $input['id'];
            $reflink    = 'field_study_reschedule_rejected';
            $notify     = 'surveyor';
            $notify_from_role_id = 2;
            addNotification($from,$utype,$to,$ntype,$title,$desc,$refId,$reflink,$notify,$notify_from_role_id);

            if(isset($survey_request_log_id))
            {   
                Session::flash('message', ['text'=>'Field Study Reschedule Request Rejected Successfully !','type'=>'success']);  
            }
            else
            {
                Session::flash('message', ['text'=>'Field Study Reschedule Request Not Rejected Successfully !','type'=>'danger']);
            }

            return redirect('/admin/requested_services');
        }
        else
        {
            return redirect()->back()->withErrors($validator)->withInput($request->all());
        }
    }

    public function reject_survey_reschedule(Request $request)
    {
        $input = $request->all();

        $validator = Validator::make($request->all(), [
            'id'=>['required'],
            'remarks'=>['required'],
        ]);

        if($validator->passes())
        {
            $cust_id = survey_requests::where('id',$input['id'])->first()->cust_id;
            $assigned_surveyor = survey_requests::where('id',$input['id'])->first()->assigned_surveyor_survey;

            $assign_arr['request_status'] = 66;
            $assign_arr['updated_by'] = auth()->user()->id;
            $assign_arr['updated_at'] = date('Y-m-d H:i:s');

            Survey_requests::where('id',$input['id'])->update($assign_arr);

            $survey_request_logs = [];

            $survey_request_logs['survey_request_id'] = $input['id'];
            $survey_request_logs['cust_id'] = $cust_id;
            $survey_request_logs['survey_status'] = 66;
            $survey_request_logs['remarks'] = $input['remarks'];
            $survey_request_logs['is_active'] = 1;
            $survey_request_logs['is_deleted'] = 0;
            $survey_request_logs['created_by'] = auth()->user()->id;
            $survey_request_logs['updated_by'] = auth()->user()->id;
            $survey_request_logs['created_at'] = date('Y-m-d H:i:s');
            $survey_request_logs['updated_at'] = date('Y-m-d H:i:s');

            $survey_request_log_id = Survey_request_logs::create($survey_request_logs)->id;

            $from       = auth()->user()->id; 
            $utype      = 3;
            $to         = $assigned_surveyor; 
            $ntype      = 'survey_study_reschedule_rejected';
            $title      = 'Survey Study Reschedule Rejected';
            $desc       = 'Survey Study Reschedule Rejected. Request ID:HSW'.$input['id'];
            $refId      = $input['id'];
            $reflink    = 'survey_study_reschedule_rejected';
            $notify     = 'surveyor';
            $notify_from_role_id = 2;
            addNotification($from,$utype,$to,$ntype,$title,$desc,$refId,$reflink,$notify,$notify_from_role_id);            

            if(isset($survey_request_log_id))
            {   
                Session::flash('message', ['text'=>'Survey Study Reschedule Request Rejected Successfully !','type'=>'success']);  
            }
            else
            {
                Session::flash('message', ['text'=>'Survey Study Reschedule Request Not Rejected Successfully !','type'=>'danger']);
            }

            return redirect('/admin/requested_services');
        }
        else
        {
            return redirect()->back()->withErrors($validator)->withInput($request->all());
        }
    }

    public function reject_fieldstudy(Request $request)
    {
        $input = $request->all();

        $validator = Validator::make($request->all(), [
            'id'=>['required'],
            'remarks'=>['required'],
        ]);

        if($validator->passes())
        {
            $cust_id = survey_requests::where('id',$input['id'])->first()->cust_id;
            $assigned_surveyor = survey_requests::where('id',$input['id'])->first()->assigned_surveyor;

            $assign_arr['request_status'] = 30;
            $assign_arr['updated_by'] = auth()->user()->id;
            $assign_arr['updated_at'] = date('Y-m-d H:i:s');

            Survey_requests::where('id',$input['id'])->update($assign_arr);

            $survey_request_logs = [];

            $survey_request_logs['survey_request_id'] = $input['id'];
            $survey_request_logs['cust_id'] = $cust_id;
            $survey_request_logs['survey_status'] = 30;
            $survey_request_logs['remarks'] = $input['remarks'];
            $survey_request_logs['is_active'] = 1;
            $survey_request_logs['is_deleted'] = 0;
            $survey_request_logs['created_by'] = auth()->user()->id;
            $survey_request_logs['updated_by'] = auth()->user()->id;
            $survey_request_logs['created_at'] = date('Y-m-d H:i:s');
            $survey_request_logs['updated_at'] = date('Y-m-d H:i:s');

            $survey_request_log_id = Survey_request_logs::create($survey_request_logs)->id;

            $from       = auth()->user()->id; 
            $utype      = 3;
            $to         = $assigned_surveyor; 
            $ntype      = 'field_study_rejected';
            $title      = 'Field Study Report Rejected';
            $desc       = 'Field Study Report Rejected. Request ID:HSW'.$input['id'];
            $refId      = $input['id'];
            $reflink    = 'field_study_rejected';
            $notify     = 'surveyor';
            $notify_from_role_id = 2;
            addNotification($from,$utype,$to,$ntype,$title,$desc,$refId,$reflink,$notify,$notify_from_role_id);

            if(isset($survey_request_log_id))
            {   
                Session::flash('message', ['text'=>'Field Study Report Rejected Successfully !','type'=>'success']);  
            }
            else
            {
                Session::flash('message', ['text'=>'Field Study Report Not Rejected Successfully !','type'=>'danger']);
            }

            return redirect('/admin/requested_services');
        }
        else
        {
            return redirect()->back()->withErrors($validator)->withInput($request->all());
        }
    }

    public function reject_surveystudy(Request $request)
    {
        $input = $request->all();

        $validator = Validator::make($request->all(), [
            'id'=>['required'],
            'remarks'=>['required'],
        ]);

        if($validator->passes())
        {
            $cust_id = survey_requests::where('id',$input['id'])->first()->cust_id;
            $assigned_surveyor = survey_requests::where('id',$input['id'])->first()->assigned_surveyor_survey;

            $assign_arr['request_status'] = 20;
            $assign_arr['updated_by'] = auth()->user()->id;
            $assign_arr['updated_at'] = date('Y-m-d H:i:s');

            Survey_requests::where('id',$input['id'])->update($assign_arr);

            $survey_request_logs = [];

            $survey_request_logs['survey_request_id'] = $input['id'];
            $survey_request_logs['cust_id'] = $cust_id;
            $survey_request_logs['survey_status'] = 20;
            $survey_request_logs['remarks'] = $input['remarks'];
            $survey_request_logs['is_active'] = 1;
            $survey_request_logs['is_deleted'] = 0;
            $survey_request_logs['created_by'] = auth()->user()->id;
            $survey_request_logs['updated_by'] = auth()->user()->id;
            $survey_request_logs['created_at'] = date('Y-m-d H:i:s');
            $survey_request_logs['updated_at'] = date('Y-m-d H:i:s');

            $survey_request_log_id = Survey_request_logs::create($survey_request_logs)->id;

            $from       = auth()->user()->id; 
            $utype      = 3;
            $to         = $assigned_surveyor; 
            $ntype      = 'survey_study_rejected';
            $title      = 'Survey Study Report Rejected';
            $desc       = 'Survey Study Report Rejected. Request ID:HSW'.$input['id'];
            $refId      = $input['id'];
            $reflink    = 'survey_study_rejected';
            $notify     = 'surveyor';
            $notify_from_role_id = 2;
            addNotification($from,$utype,$to,$ntype,$title,$desc,$refId,$reflink,$notify,$notify_from_role_id);

            if(isset($survey_request_log_id))
            {   
                Session::flash('message', ['text'=>'Survey Study Report Rejected Successfully !','type'=>'success']);  
            }
            else
            {
                Session::flash('message', ['text'=>'Survey Study Report Not Rejected Successfully !','type'=>'danger']);
            }

            return redirect('/admin/requested_services');
        }
        else
        {
            return redirect()->back()->withErrors($validator)->withInput($request->all());
        }
    }

    public function reject_final_report(Request $request)
    {
        $input = $request->all();

        $validator = Validator::make($request->all(), [
            'id'=>['required'],
            'remarks'=>['required'],
        ]);

        if($validator->passes())
        {
            $cust_id = survey_requests::where('id',$input['id'])->first()->cust_id;
            $assigned_draftsman_final = survey_requests::where('id',$input['id'])->first()->assigned_draftsman_final;

            $assign_arr['request_status'] = 28;
            $assign_arr['updated_by'] = auth()->user()->id;
            $assign_arr['updated_at'] = date('Y-m-d H:i:s');

            Survey_requests::where('id',$input['id'])->update($assign_arr);

            $survey_request_logs = [];

            $survey_request_logs['survey_request_id'] = $input['id'];
            $survey_request_logs['cust_id'] = $cust_id;
            $survey_request_logs['survey_status'] = 28;
            $survey_request_logs['remarks'] = $input['remarks'];
            $survey_request_logs['is_active'] = 1;
            $survey_request_logs['is_deleted'] = 0;
            $survey_request_logs['created_by'] = auth()->user()->id;
            $survey_request_logs['updated_by'] = auth()->user()->id;
            $survey_request_logs['created_at'] = date('Y-m-d H:i:s');
            $survey_request_logs['updated_at'] = date('Y-m-d H:i:s');

            $survey_request_log_id = Survey_request_logs::create($survey_request_logs)->id;

                $from       = auth()->user()->id;
                $utype      = 4;
                $to         = $assigned_draftsman_final; 
                $ntype      = 'final_report_rejected';
                $title      = 'Final Report Rejected by Admin';
                $desc       = 'Final Report Rejected by Admin. Request ID: HSW'.$input['id'];
                $refId      = $input['id'];
                $reflink    = '/draftsman/service_requests_detail/'.$input['id'].'/28/';
                $notify     = 'draftsman';
                $notify_from_role_id = 2;
                addNotification($from,$utype,$to,$ntype,$title,$desc,$refId,$reflink,$notify,$notify_from_role_id); 


            if(isset($survey_request_log_id))
            {   
                Session::flash('message', ['text'=>'Final Survey Report Rejected Successfully !','type'=>'success']);  
            }
            else
            {
                Session::flash('message', ['text'=>'Final Survey Report Not Rejected Successfully !','type'=>'danger']);
            }

            return redirect('/admin/requested_services');
        }
        else
        {
            return redirect()->back()->withErrors($validator)->withInput($request->all());
        }
    }

    public function requested_services()
    { 
        $data['title']              =   'Requested Services';
        $data['menu']               =   'requested-services';

        $status_not                 =   array(1,2,3,4);
        $data['survey_requests']    =   DB::table('survey_requests')
                                        ->leftjoin('cust_mst', 'survey_requests.cust_id', '=', 'cust_mst.id')
                                        ->leftjoin('cust_info', 'survey_requests.cust_id', '=', 'cust_info.cust_id')
                                        ->leftjoin('cust_telecom', 'survey_requests.cust_id', '=', 'cust_telecom.cust_id')
                                        ->leftjoin('services', 'survey_requests.service_id', '=', 'services.id')
                                        ->leftjoin('institution', 'survey_requests.assigned_institution', '=', 'institution.id')
                                        ->leftjoin('survey_status', 'survey_requests.request_status', '=', 'survey_status.id')
                                        ->whereNotIn('survey_requests.request_status',$status_not)->where('survey_requests.request_status','!=',NULL)->Where('survey_requests.is_deleted',0)
                                        ->where('cust_mst.is_deleted',0)
                                        ->where('cust_telecom.is_deleted',0)->where('cust_telecom.telecom_type',2)
                                        ->select('survey_requests.id AS survey_id','survey_requests.created_at AS survey_date','survey_requests.*','cust_mst.*','cust_info.*', 'cust_telecom.*','services.*','institution.*','survey_status.status_name AS current_status')
                                        ->orderBy('survey_requests.id','DESC')
                                        ->get();

        // dd($data);

        return view('admin.requested_services',$data);
    }

    public function requested_service_detail($id,$status)
    {
        $data['title']              =   'Requested Services';
        $data['menu']               =   'requested-services';

        $datas = Survey_requests::where('id',$id)->first();
        
        $cust_id = $datas->cust_id;
        $data['cust_info'] = CustomerInfo::where('cust_id',$cust_id)->where('is_deleted',0)->first();
        $data['cust_phone'] = CustomerTelecom::where('cust_id',$cust_id)->where('telecom_type',2)->where('is_deleted',0)->first()->cust_telecom_value;
        $data['cust_email'] = CustomerTelecom::where('cust_id',$cust_id)->where('telecom_type',1)->where('is_deleted',0)->first()->cust_telecom_value;

        $data['service'] = Services::where('id',$datas->service_id)->first()->service_name;
        $data['survey_id'] = $id;
        $data['institutions'] = Institution::where('is_deleted',0)->where('is_active',1) ->get();
        $data['admins'] = Admin::where('role_id',2)->get();

        $data['survey_status'] = Survey_status::where('id',$datas->request_status)->first()->status_name;

        $data['survey_datas'] = DB::table('survey_request_logs')
                                ->leftjoin('survey_status', 'survey_request_logs.survey_status', '=', 'survey_status.id')
                                ->where('survey_request_logs.cust_id',$cust_id)->where('survey_request_logs.survey_request_id',$id)->where('survey_request_logs.is_active',1)->where('survey_request_logs.is_deleted',0)
                                ->select('survey_request_logs.created_at AS log_date','survey_request_logs.*','survey_status.*')
                                ->orderBy('survey_request_logs.id','DESC')
                                ->get();
                                
        $data['recipients'] = Admin::where('role_id',1)->where('id','!=',1)->get();
        $data['surveyors'] = Admin::where('role_id',3)->get();
        
        $data['status'] = $status;

        // if($datas->request_status != $status)
        // {
        //     return redirect('admin/requested_service_detail/'.$id.'/'.$datas->request_status);
        // }

        if($datas->service_id == 1)
        {
            $data['request_data'] = $datas->Hydrographic_survey->first();
        }
        elseif($datas->service_id == 2)
        {
            $data['request_data'] = $datas->Tidal_observation->first();
        }
        elseif($datas->service_id == 3)
        {
            $data['request_data'] = $datas->Bottom_sample_collection->first();
        }
        elseif($datas->service_id == 4)
        {
            $data['request_data'] = $datas->Dredging_survey->first();
        }
        elseif($datas->service_id == 5)
        {
            $data['request_data'] = $datas->Hydrographic_chart->first();
        }
        elseif($datas->service_id == 6)
        {
            $data['request_data'] = $datas->Underwater_videography->first();
        }
        elseif($datas->service_id == 7)
        {
            $data['request_data'] = $datas->Currentmeter_observation->first();
        }
        elseif($datas->service_id == 8)
        {
            $data['request_data'] = $datas->Sidescansonar->first();
        }
        elseif($datas->service_id == 9)
        {
            $data['request_data'] = $datas->Topographic_survey->first();
        }
        elseif($datas->service_id == 10)
        {
            $data['request_data'] = $datas->Subbottom_profilling->first();
        }
        elseif($datas->service_id == 11)
        {
            $data['request_data'] = $datas->Bathymetry_survey->first();
        }

        $data['state_name'] = State::where('id',$data['request_data']['state'])->first()->state_name;
        $data['district_name'] = City::where('id',$data['request_data']['district'])->first()->city_name;

        if($status == 24)
        {
            $data['final_report'] = Survey_requests::where('id',$id)->first()->final_report;

            // dd($data);

            return view('admin.requested_services.draftsman_submitted_final_report',$data);
        }
        elseif($status == 19)
        {
            $data['survey_study'] = Survey_study_report::where('survey_request_id',$id)->first();
            $data['survey_invoice'] = Survey_invoice::where('survey_request_id',$id)->first();

            return view('admin.survey_study_report',$data);
        }
        elseif($status == 64)
        {
            $data['surveyor_remarks'] = Survey_request_logs::where('survey_request_id',$id)->where('survey_status',64)->first()->remarks;
            $data['survey_study_reschedule'] = Survey_requests::where('id',$id)->first()->survey_study_reschedule;

            return view('admin.requested_services.surveryor_rescheduled_surveystudy',$data);
        }
        elseif($status == 44)
        {
            $data['surveyor_remarks'] = Survey_request_logs::where('survey_request_id',$id)->where('survey_status',44)->orderby('id','DESC')->get();

            // dd($data);
            return view('admin.requested_services.surveryor_rejected_surveystudy',$data);
        }
        elseif($status == 18)
        {
            $data['field_study'] = Field_study_report::where('survey_request_id',$id)->first();
            $data['survey_invoice'] = Survey_invoice::where('survey_request_id',$id)->first();

            return view('admin.requested_services.assign_survey_study',$data);
        }
        elseif($status == 47 || $status == 69)
        {
            $data['field_study'] = Field_study_report::where('survey_request_id',$id)->first();
            $data['survey_invoice'] = Survey_invoice::where('survey_request_id',$id)->first();

            return view('admin.requested_services.invoice_submitted',$data);
        }
        elseif($status == 11 || $status == 68)
        {
            $data['field_study'] = Field_study_report::where('survey_request_id',$id)->first();
            $data['survey_invoice'] = Survey_performa_invoice::where('survey_request_id',$id)->first();
            
            return view('admin.requested_services.performa_invoice_submitted',$data);
        }
        elseif($status == 67)
        {
            $data['field_study'] = Field_study_report::where('survey_request_id',$id)->first();

            return view('admin.requested_services.eta_rejected',$data);
        }
        elseif($status == 7)
        {
            $data['field_study'] = Field_study_report::where('survey_request_id',$id)->first();

            return view('admin.submitted-by-sur',$data);
        }
        elseif($status == 61)
        {
            $data['surveyor_remarks'] = Survey_request_logs::where('survey_request_id',$id)->where('survey_status',61)->first()->remarks;
            $data['field_study_reschedule'] = Survey_requests::where('id',$id)->first()->field_study_reschedule;
            // dd($data);
            return view('admin.requested_services.surveryor_rescheduled_fieldstudy',$data);
        }
        elseif($status == 45)
        {
            $data['surveyor_remarks'] = Survey_request_logs::where('survey_request_id',$id)->where('survey_status',45)->orderby('id','desc')->get();

            // dd($data);

            return view('admin.requested_services.surveryor_rejected_fieldstudy',$data);
        }
        else
        {
            // if($status > 7)
            // {
            //     $data['field_study'] = Field_study_report::where('survey_request_id',$id)->first();
    
            //     return view('admin.submitted-by-sur',$data);
            // }
            // dd($data);
            return view('admin.requested_services_details',$data);
        }
    }

function get_remote_file_info($url) {
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_HEADER, TRUE);
    curl_setopt($ch, CURLOPT_NOBODY, TRUE);
    $data = curl_exec($ch);
    $fileSize = curl_getinfo($ch, CURLINFO_CONTENT_LENGTH_DOWNLOAD);
    $httpResponseCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    return [
        'fileExists' => (int) $httpResponseCode == 200,
        'fileSize' => (int) $fileSize
    ];
}

 public function services_repository_detail($id,$status)
    {
        $data['title']              =   'Requested Services';
        $data['menu']               =   'requested-services';

        $datas = Survey_requests::where('id',$id)->first();
        
        $data['file_name'] =  ""; $data['file_size'] = 0; $data['final_report'] =  "";
        if(isset($datas->final_report))
        {
            $data['final_report'] =  $datas->final_report;
            $data['file_id'] =  $id;
            $data['file_name'] = basename($datas->final_report);
            $filesize = $this->get_remote_file_info($datas->final_report);
            if(isset($filesize))
            {
              $data['file_size'] = round($filesize['fileSize'] / 1024, 2);  
            }
                       
        }

        

        $cust_id = $datas->cust_id;
        $data['cust_info'] = CustomerInfo::where('cust_id',$cust_id)->where('is_deleted',0)->first();
        $data['cust_phone'] = CustomerTelecom::where('cust_id',$cust_id)->where('telecom_type',2)->where('is_deleted',0)->first()->cust_telecom_value;
        $data['cust_email'] = CustomerTelecom::where('cust_id',$cust_id)->where('telecom_type',1)->where('is_deleted',0)->first()->cust_telecom_value;

        $data['service'] = Services::where('id',$datas->service_id)->first()->service_name;
        $data['survey_id'] = $id;
        $data['institutions'] = Institution::where('is_deleted',0)->where('is_active',1) ->get();
        $data['admins'] = Admin::where('role_id',2)->get();

        $data['survey_status'] = Survey_status::where('id',$datas->request_status)->first()->status_name;

        // $data['survey_datas'] = DB::table('survey_request_logs')
        //                         ->leftjoin('survey_status', 'survey_request_logs.survey_status', '=', 'survey_status.id')
        //                         ->where('survey_request_logs.cust_id',$cust_id)->where('survey_request_logs.survey_request_id',$id)->where('survey_request_logs.is_active',1)->where('survey_request_logs.is_deleted',0)
        //                         ->select('survey_request_logs.created_at AS log_date','survey_request_logs.*','survey_status.*')
        //                         ->orderBy('survey_request_logs.id','DESC')
        //                         ->get();
                                
        $data['recipients'] = Admin::where('role_id',1)->where('id','!=',1)->get();
        $data['surveyors'] = Admin::where('role_id',3)->get();
        
        $data['status'] = $status;

        if($datas->request_status != $status)
        {
            return redirect('admin/requested_services');
        }

        if($datas->service_id == 1)
        {
            $data['request_data'] = $datas->Hydrographic_survey->first();
        }
        elseif($datas->service_id == 2)
        {
            $data['request_data'] = $datas->Tidal_observation->first();
        }
        elseif($datas->service_id == 3)
        {
            $data['request_data'] = $datas->Bottom_sample_collection->first();
        }
        elseif($datas->service_id == 4)
        {
            $data['request_data'] = $datas->Dredging_survey->first();
        }
        elseif($datas->service_id == 5)
        {
            $data['request_data'] = $datas->Hydrographic_chart->first();
        }
        elseif($datas->service_id == 6)
        {
            $data['request_data'] = $datas->Underwater_videography->first();
        }
        elseif($datas->service_id == 7)
        {
            $data['request_data'] = $datas->Currentmeter_observation->first();
        }
        elseif($datas->service_id == 8)
        {
            $data['request_data'] = $datas->Sidescansonar->first();
        }
        elseif($datas->service_id == 9)
        {
            $data['request_data'] = $datas->Topographic_survey->first();
        }
        elseif($datas->service_id == 10)
        {
            $data['request_data'] = $datas->Subbottom_profilling->first();
        }
        elseif($datas->service_id == 11)
        {
            $data['request_data'] = $datas->Bathymetry_survey->first();
        }

        $data['state_name'] = State::where('id',$data['request_data']['state'])->first()->state_name;
        $data['district_name'] = City::where('id',$data['request_data']['district'])->first()->city_name;

        $data['survey_datas'] = DB::table('survey_request_logs')
                                ->leftjoin('survey_status', 'survey_request_logs.survey_status', '=', 'survey_status.id')
                                ->leftjoin('survey_requests', 'survey_request_logs.survey_request_id', '=', 'survey_requests.id')
                                ->where('survey_request_logs.cust_id',$cust_id)->where('survey_request_logs.survey_request_id',$id)->where('survey_request_logs.is_active',1)->where('survey_request_logs.is_deleted',0)
                                ->select('survey_request_logs.created_at AS log_date','survey_request_logs.*','survey_status.*','survey_requests.*')
                                ->orderBy('survey_request_logs.id','DESC')
                                ->get();



            // dd($data);
            return view('admin.repository-detail',$data);
     
    }

    public function repository_file_download($id){
       $datas = Survey_requests::where('id',$id)->first(); 
        if(isset($datas->final_report))
        {
            $exp = explode("public", $datas->final_report);

            $file_path = public_path() .$exp[1];
            // dd($file_path);
            $file_name = basename($datas->final_report);
            if (file_exists($file_path))
            {
            // Send Download
            return Response::download($file_path, $file_name, [
            'Content-Length: '. filesize($file_path)
            ]);
            }
            else
            {
            // Error
            exit('Requested file does not exist on our server!');
            }     
        }

      
    }


    public function createETA($id)
    {
        $data['title']      = 'Create ETA';
        $data['menu']       = 'create-eta';

        $data['id']         = $id;
        $data['recipients'] = Admin::where('role_id',1)->get();
        $data['cities'] = City::where('is_deleted',0)->get();
        $data['survey_type'] = SurveyType::where('is_deleted',0)->get();

        // dd($data);

        return view('admin.requested_services.create_eta',$data);
    }

    public function add_eta(Request $request)
    {
        $input = $request->all();
        
        $validator = Validator::make($request->all(), [
            'id'=>['required'],
            'general_area'=>['required'],
            'location'=>['required','alpha_num'],
            'scale_of_survey_recomended'=>['required','alpha_num'],
            'type_of_survey'=>['required'],
            'no_of_days_required'=>['required'],
            'charges'=>['required'],
            'recipient'=>['required'],
            'remarks'=>['nullable'],
        ]);

        if($validator->passes())
        {
            $cust_id = survey_requests::where('id',$input['id'])->first()->cust_id;

            $eta_arr['survey_request_id'] = $input['id'];
            $eta_arr['general_area'] = $input['general_area'];
            $eta_arr['location'] = $input['location'];
            $eta_arr['scale_of_survey_recomended'] = $input['scale_of_survey_recomended'];
            $eta_arr['type_of_survey'] = $input['type_of_survey'];
            $eta_arr['no_of_days_required'] = $input['no_of_days_required'];
            $eta_arr['charges'] = $input['charges'];
            $eta_arr['recipient'] = $input['recipient'];
            $eta_arr['is_active'] = 1;
            $eta_arr['is_deleted'] = 0;
            $eta_arr['created_by'] = auth()->user()->id;
            $eta_arr['updated_by'] = auth()->user()->id;
            $eta_arr['created_at'] = date('Y-m-d H:i:s');
            $eta_arr['updated_at'] = date('Y-m-d H:i:s');

            Fieldstudy_eta::create($eta_arr);

            $survey_req_arr['request_status'] = 8;
            $survey_req_arr['updated_by'] = auth()->user()->id;
            $survey_req_arr['updated_at'] = date('Y-m-d H:i:s');

            Survey_requests::where('id',$input['id'])->update($survey_req_arr);

            $survey_request_logs = [];

            $survey_request_logs['survey_request_id'] = $input['id'];
            $survey_request_logs['cust_id'] = $cust_id;
            $survey_request_logs['survey_status'] = 8;
            $survey_request_logs['remarks'] = $input['remarks'];
            $survey_request_logs['is_active'] = 1;
            $survey_request_logs['is_deleted'] = 0;
            $survey_request_logs['created_by'] = auth()->user()->id;
            $survey_request_logs['updated_by'] = auth()->user()->id;
            $survey_request_logs['created_at'] = date('Y-m-d H:i:s');
            $survey_request_logs['updated_at'] = date('Y-m-d H:i:s');

            $survey_request_log_id = Survey_request_logs::create($survey_request_logs)->id;


                $from       = auth()->user()->id; 
                $utype      = 1;
                $to         = 1; 
                $ntype      = 'added_eta';
                $title      = 'ETA Added';
                $desc       = 'ETA Added. Request ID: HSW'.$input['id'];
                $refId      = $input['id'];
                $reflink    = '/superadmin/requested_service_detail/'.$input['id'].'/8/';
                $notify     = 'superadmin';
                $notify_from_role_id = 2;
                addNotification($from,$utype,$to,$ntype,$title,$desc,$refId,$reflink,$notify,$notify_from_role_id); 

            if(isset($survey_request_log_id))
            {   
                Session::flash('message', ['text'=>'Field Study ETA added Successfully !','type'=>'success']);  
            }
            else
            {
                Session::flash('message', ['text'=>'Field Study ETA not added Successfully !','type'=>'danger']);
            }

            return redirect('/admin/requested_services');
        }
        else
        {
            return redirect()->back()->withErrors($validator)->withInput($request->all());
        }
    }

    public function editETA($id)
    {
        $data['title']      = 'Edit ETA';
        $data['menu']       = 'edit-eta';

        $data['survey_id']  = $id;
        $data['recipients'] = Admin::where('role_id',1)->get();
        $data['cities'] = City::where('is_deleted',0)->get();
        $data['survey_type'] = SurveyType::where('is_deleted',0)->get();

        $data['fieldstudy_eta'] = Fieldstudy_eta::where('survey_request_id',$id)->first();
        $data['remarks'] = Survey_request_logs::where('survey_request_id',$id)->where('survey_status',67)->first()->remarks;
        
        // dd($data);

        return view('admin.requested_services.edit_eta',$data);
    }

    public function update_eta(Request $request)
    {
        $input = $request->all();
        
        $validator = Validator::make($request->all(), [
            'survey_id'=>['required'],
            'eta_id'=>['required'],
            'general_area'=>['required'],
            'location'=>['required','alpha_num'],
            'scale_of_survey_recomended'=>['required','alpha_num'],
            'type_of_survey'=>['required'],
            'no_of_days_required'=>['required'],
            'charges'=>['required'],
            'recipient'=>['required'],
            'remarks'=>['nullable'],
        ]);

        if($validator->passes())
        {
            $cust_id = survey_requests::where('id',$input['survey_id'])->first()->cust_id;

            $eta_arr['survey_request_id'] = $input['survey_id'];
            $eta_arr['general_area'] = $input['general_area'];
            $eta_arr['location'] = $input['location'];
            $eta_arr['scale_of_survey_recomended'] = $input['scale_of_survey_recomended'];
            $eta_arr['type_of_survey'] = $input['type_of_survey'];
            $eta_arr['no_of_days_required'] = $input['no_of_days_required'];
            $eta_arr['charges'] = $input['charges'];
            $eta_arr['recipient'] = $input['recipient'];
            $eta_arr['is_active'] = 1;
            $eta_arr['is_deleted'] = 0;
            $eta_arr['created_by'] = auth()->user()->id;
            $eta_arr['updated_by'] = auth()->user()->id;
            $eta_arr['created_at'] = date('Y-m-d H:i:s');
            $eta_arr['updated_at'] = date('Y-m-d H:i:s');

            Fieldstudy_eta::where('id',$input['eta_id'])->update($eta_arr);

            $survey_req_arr['request_status'] = 8;
            $survey_req_arr['updated_by'] = auth()->user()->id;
            $survey_req_arr['updated_at'] = date('Y-m-d H:i:s');

            Survey_requests::where('id',$input['survey_id'])->update($survey_req_arr);

            $survey_request_logs = [];

            $survey_request_logs['survey_request_id'] = $input['survey_id'];
            $survey_request_logs['cust_id'] = $cust_id;
            $survey_request_logs['survey_status'] = 8;
            $survey_request_logs['remarks'] = $input['remarks'];
            $survey_request_logs['is_active'] = 1;
            $survey_request_logs['is_deleted'] = 0;
            $survey_request_logs['created_by'] = auth()->user()->id;
            $survey_request_logs['updated_by'] = auth()->user()->id;
            $survey_request_logs['created_at'] = date('Y-m-d H:i:s');
            $survey_request_logs['updated_at'] = date('Y-m-d H:i:s');

            $survey_request_log_id = Survey_request_logs::create($survey_request_logs)->id;


                $from       = auth()->user()->id; 
                $utype      = 1;
                $to         = 1; 
                $ntype      = 'added_eta';
                $title      = 'ETA Added';
                $desc       = 'ETA Added. Request ID: HSW'.$input['survey_id'];
                $refId      = $input['survey_id'];
                $reflink    = '/superadmin/requested_service_detail/'.$input['survey_id'].'/8/';
                $notify     = 'superadmin';
                $notify_from_role_id = 2;
                addNotification($from,$utype,$to,$ntype,$title,$desc,$refId,$reflink,$notify,$notify_from_role_id); 

            if(isset($survey_request_log_id))
            {   
                Session::flash('message', ['text'=>'Field Study ETA added Successfully !','type'=>'success']);  
            }
            else
            {
                Session::flash('message', ['text'=>'Field Study ETA not added Successfully !','type'=>'danger']);
            }

            return redirect('/admin/requested_services');
        }
        else
        {
            return redirect()->back()->withErrors($validator)->withInput($request->all());
        }
    }

    public function verify_performa_invoice(Request $request)
    {
        $id = $request->id;

        Survey_requests::where('id',$id)->update(['request_status'=>13]);

        $cust_id = survey_requests::where('id',$id)->first()->cust_id;

        $survey_request_logs = [];

        $survey_request_logs['survey_request_id'] = $id;
        $survey_request_logs['cust_id'] = $cust_id;
        $survey_request_logs['survey_status'] = 13;
        $survey_request_logs['remarks'] = $request->remarks;
        $survey_request_logs['is_active'] = 1;
        $survey_request_logs['is_deleted'] = 0;
        $survey_request_logs['created_by'] = auth()->user()->id;
        $survey_request_logs['updated_by'] = auth()->user()->id;
        $survey_request_logs['created_at'] = date('Y-m-d H:i:s');
        $survey_request_logs['updated_at'] = date('Y-m-d H:i:s');

        $survey_request_log_id = Survey_request_logs::create($survey_request_logs)->id;

            $from       = auth()->user()->id; 
            $utype      = 1;
            $to         = 1; 
            $ntype      = 'performa_invoice_verified';
            $title      = 'Performa Invoice Verified';
            $desc       = 'Performa Invoice Verified. Request ID:HSW'. $id;
            $refId      = $id;
            $reflink    = '/superadmin/requested_service_detail/'.$id.'/13/';
            $notify     = 'superadmin';
            $notify_from_role_id = 2;
            addNotification($from,$utype,$to,$ntype,$title,$desc,$refId,$reflink,$notify,$notify_from_role_id);

        if(isset($survey_request_log_id))
        {   
            Session::flash('message', ['text'=>'Performa Invoice Verified Successfully !','type'=>'success']);  
        }
        else
        {
            Session::flash('message', ['text'=>'Performa Invoice Not Verified Successfully !','type'=>'danger']);
        }

        return redirect('admin/requested_services');
    }

    public function verify_invoice(Request $request)
    {
        $input = $request->all();
        $id = $request->id;

        Survey_requests::where('id',$id)->update(['request_status'=>49]);

        $cust_id = survey_requests::where('id',$id)->first()->cust_id;

        $survey_request_logs = [];

        $survey_request_logs['survey_request_id'] = $id;
        $survey_request_logs['cust_id'] = $cust_id;
        $survey_request_logs['survey_status'] = 49;
        $survey_request_logs['remarks'] = $request->remarks;
        $survey_request_logs['is_active'] = 1;
        $survey_request_logs['is_deleted'] = 0;
        $survey_request_logs['created_by'] = auth()->user()->id;
        $survey_request_logs['updated_by'] = auth()->user()->id;
        $survey_request_logs['created_at'] = date('Y-m-d H:i:s');
        $survey_request_logs['updated_at'] = date('Y-m-d H:i:s');

        $survey_request_log_id = Survey_request_logs::create($survey_request_logs)->id;

            $from       = auth()->user()->id; 
            $utype      = 1;
            $to         = 1; 
            $ntype      = 'invoice_verified_by_admin';
            $title      = 'Invoice Verified by Admin';
            $desc       = 'Invoice Verified by Admin. Request ID: HSW'.$id;
            $refId      = $id;
            $reflink    = '/superadmin/requested_service_detail/'.$id.'/49/';
            $notify     = 'superadmin';
            $notify_from_role_id = 2;
            addNotification($from,$utype,$to,$ntype,$title,$desc,$refId,$reflink,$notify,$notify_from_role_id); 

        if(isset($survey_request_log_id))
        {   
            Session::flash('message', ['text'=>'Invoice Verified Successfully !','type'=>'success']);  
        }
        else
        {
            Session::flash('message', ['text'=>'Invoice Not Verified Successfully !','type'=>'danger']);
        }

        return redirect('admin/requested_services');
    }

    public function reject_performa_invoice(Request $request)
    {
        $input = $request->all();

        $validator = Validator::make($request->all(), [
            'id'=>['required'],
            'remarks'=>['required'],
        ]);

        if($validator->passes())
        {
            $cust_id = survey_requests::where('id',$input['id'])->first()->cust_id;

            $assign_arr['request_status'] = 12;
            $assign_arr['updated_by'] = auth()->user()->id;
            $assign_arr['updated_at'] = date('Y-m-d H:i:s');

            Survey_requests::where('id',$input['id'])->update($assign_arr);

            $survey_request_logs = [];

            $survey_request_logs['survey_request_id'] = $input['id'];
            $survey_request_logs['cust_id'] = $cust_id;
            $survey_request_logs['survey_status'] = 12;
            $survey_request_logs['remarks'] = $input['remarks'];
            $survey_request_logs['is_active'] = 1;
            $survey_request_logs['is_deleted'] = 0;
            $survey_request_logs['created_by'] = auth()->user()->id;
            $survey_request_logs['updated_by'] = auth()->user()->id;
            $survey_request_logs['created_at'] = date('Y-m-d H:i:s');
            $survey_request_logs['updated_at'] = date('Y-m-d H:i:s');

            $survey_request_log_id = Survey_request_logs::create($survey_request_logs)->id;

            $from       = auth()->user()->id; 
            $utype      = 4;
            $to         = survey_requests::where('id',$input['id'])->first()->assigned_draftsman;
            $ntype      = 'performa_invoice_rejected';
            $title      = 'Performa Invoice Rejected by Admin';
            $desc       = 'Performa Invoice Rejected by Admin. Request ID:HSW'.$input['id'];
            $refId      =$input['id'];
            $reflink    = '/draftsman/service_requests_detail/'.$input['id'].'/12/';
            $notify     = 'draftsman';
            $notify_from_role_id = 2;
            addNotification($from,$utype,$to,$ntype,$title,$desc,$refId,$reflink,$notify,$notify_from_role_id);

            if(isset($survey_request_log_id))
            {   
                Session::flash('message', ['text'=>'Performa Invoice Rejected Successfully !','type'=>'success']);  
            }
            else
            {
                Session::flash('message', ['text'=>'Performa Invoice Not Rejected Successfully !','type'=>'danger']);
            }

            return redirect('/admin/requested_services');
        }
        else
        {
            return redirect()->back()->withErrors($validator)->withInput($request->all());
        }
    }

    public function reject_invoice(Request $request)
    {
        $input = $request->all();

        $validator = Validator::make($request->all(), [
            'id'=>['required'],
            'remarks'=>['required'],
        ]);

        if($validator->passes())
        {
            $cust_id = survey_requests::where('id',$input['id'])->first()->cust_id;

            $assign_arr['request_status'] = 48;
            $assign_arr['updated_by'] = auth()->user()->id;
            $assign_arr['updated_at'] = date('Y-m-d H:i:s');

            Survey_requests::where('id',$input['id'])->update($assign_arr);

            $survey_request_logs = [];

            $survey_request_logs['survey_request_id'] = $input['id'];
            $survey_request_logs['cust_id'] = $cust_id;
            $survey_request_logs['survey_status'] = 48;
            $survey_request_logs['remarks'] = $input['remarks'];
            $survey_request_logs['is_active'] = 1;
            $survey_request_logs['is_deleted'] = 0;
            $survey_request_logs['created_by'] = auth()->user()->id;
            $survey_request_logs['updated_by'] = auth()->user()->id;
            $survey_request_logs['created_at'] = date('Y-m-d H:i:s');
            $survey_request_logs['updated_at'] = date('Y-m-d H:i:s');

            $survey_request_log_id = Survey_request_logs::create($survey_request_logs)->id;

            $from       = auth()->user()->id; 
            $utype      = 4;
            $to         = survey_requests::where('id',$input['id'])->first()->assigned_draftsman;
            $ntype      = 'invoice_rejected';
            $title      = 'Invoice Rejected by Admin';
            $desc       = 'Invoice Rejected by Admin. Request ID:HSW'.$input['id'];
            $refId      =$input['id'];
            $reflink    = '/draftsman/service_requests_detail/'.$input['id'].'/48/';
            $notify     = 'draftsman';
            $notify_from_role_id = 2;
            addNotification($from,$utype,$to,$ntype,$title,$desc,$refId,$reflink,$notify,$notify_from_role_id);

            if(isset($survey_request_log_id))
            {   
                Session::flash('message', ['text'=>'Invoice Rejected Successfully !','type'=>'success']);  
            }
            else
            {
                Session::flash('message', ['text'=>'Invoice Not Rejected Successfully !','type'=>'danger']);
            }

            return redirect('/admin/requested_services');
        }
        else
        {
            return redirect()->back()->withErrors($validator)->withInput($request->all());
        }
    }

    public function verify_survey_study(Request $request)
    {
        $id = $request->id;

        Survey_requests::where('id',$id)->update(['request_status'=>21]);

        $cust_id = survey_requests::where('id',$id)->first()->cust_id;

        $survey_request_logs = [];

        $survey_request_logs['survey_request_id'] = $id;
        $survey_request_logs['cust_id'] = $cust_id;
        $survey_request_logs['survey_status'] = 21;
        $survey_request_logs['remarks'] = $request->remarks;
        $survey_request_logs['is_active'] = 1;
        $survey_request_logs['is_deleted'] = 0;
        $survey_request_logs['created_by'] = auth()->user()->id;
        $survey_request_logs['updated_by'] = auth()->user()->id;
        $survey_request_logs['created_at'] = date('Y-m-d H:i:s');
        $survey_request_logs['updated_at'] = date('Y-m-d H:i:s');

        $survey_request_log_id = Survey_request_logs::create($survey_request_logs)->id;

            $from       = auth()->user()->id; 
            $utype      = 1;
            $to         = 1; 
            $ntype      = 'survey_study_verified';
            $title      = 'Survey Study Report Verified By Admin';
            $desc       = 'Survey Study Report Verified By Admin. Request ID:HSW'.$id;
            $refId      = $id;
            $reflink    = '/superadmin/requested_service_detail/'.$id.'/21/';
            $notify     = 'superadmin';
            $notify_from_role_id = 2;
            addNotification($from,$utype,$to,$ntype,$title,$desc,$refId,$reflink,$notify,$notify_from_role_id);

        if(isset($survey_request_log_id))
        {   
            Session::flash('message', ['text'=>'Survey Study Verified Successfully !','type'=>'success']);  
        }
        else
        {
            Session::flash('message', ['text'=>'Survey Study Not Verified Successfully !','type'=>'danger']);
        }

        return redirect('admin/requested_services');
    }

    public function verify_final_report(Request $request)
    {
        $id = $request->id;

        Survey_requests::where('id',$id)->update(['request_status'=>25]);

        $cust_id = survey_requests::where('id',$id)->first()->cust_id;

        $survey_request_logs = [];

        $survey_request_logs['survey_request_id'] = $id;
        $survey_request_logs['cust_id'] = $cust_id;
        $survey_request_logs['survey_status'] = 25;
        $survey_request_logs['remarks'] = $request->remarks;
        $survey_request_logs['is_active'] = 1;
        $survey_request_logs['is_deleted'] = 0;
        $survey_request_logs['created_by'] = auth()->user()->id;
        $survey_request_logs['updated_by'] = auth()->user()->id;
        $survey_request_logs['created_at'] = date('Y-m-d H:i:s');
        $survey_request_logs['updated_at'] = date('Y-m-d H:i:s');

        $survey_request_log_id = Survey_request_logs::create($survey_request_logs)->id;

            $from       = auth()->user()->id; 
            $utype      = 1;
            $to         = 1; 
            $ntype      = 'final_report_verified';
            $title      = 'Final Report Verified By Admin';
            $desc       = 'Final Report Verified By Admin. Request ID:HSW'.$id;
            $refId      = $id;
            $reflink    = '/superadmin/requested_service_detail/'.$id.'/25/';
            $notify     = 'superadmin';
            $notify_from_role_id = 2;
            addNotification($from,$utype,$to,$ntype,$title,$desc,$refId,$reflink,$notify,$notify_from_role_id);

        if(isset($survey_request_log_id))
        {   
            Session::flash('message', ['text'=>'Final Report Verified Successfully !','type'=>'success']);  
        }
        else
        {
            Session::flash('message', ['text'=>'Final Report Not Verified Successfully !','type'=>'danger']);
        }

        return redirect('admin/requested_services');
    }
    
}