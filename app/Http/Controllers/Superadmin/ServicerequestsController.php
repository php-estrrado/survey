<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\Facades\Image;
use Session;
use DB;
use App\Models\Modules;
// use App\Models\UserRoles;
use App\Models\Admin;
use App\Models\AdminNotification;
use App\Models\UserNotification;
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
use App\Models\SurveyType;
use App\Models\UserManagement;
use App\Rules\Name;
use Svg\Tag\Rect;
use Twilio\TwiML\Voice\Reject;
use Validator;
use Illuminate\Support\Facades\Mail;

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
    
    public function new_service_requests(Request $request)
    { 
        $data['title']              =   'New Service Request';
        $data['menu']               =   'new-service-request';
        $data['ins']               =  $request->ins; 
        $data['date_val']               =  $request->date_val; 
        $data['sub_offices']               =   Institution::where('is_active',1)->where('is_deleted',0)->get();
        $query =   DB::table('survey_requests')
                                        ->leftjoin('cust_mst', 'survey_requests.cust_id', '=', 'cust_mst.id')
                                        ->leftjoin('cust_info', 'survey_requests.cust_id', '=', 'cust_info.cust_id')
                                        ->leftjoin('cust_telecom', 'survey_requests.cust_id', '=', 'cust_telecom.cust_id')
                                        ->leftjoin('services', 'survey_requests.service_id', '=', 'services.id')
                                        ->where('survey_requests.request_status',1)->Where('survey_requests.is_deleted',0)
                                        ->where('cust_mst.is_deleted',0)
                                        ->where('cust_telecom.is_deleted',0)->where('cust_telecom.telecom_type',2)
                                        ->select('survey_requests.id AS survey_id','survey_requests.created_at AS survey_date','survey_requests.*','cust_mst.*','cust_info.*', 'cust_telecom.*','services.*')
                                        ->orderBy('survey_requests.id','DESC');

            if($request->ins >0){
            $query->where('survey_requests.assigned_institution', $request->ins);
            } 

            if($request->date_val !=""){

            if($request->date_val == "today")
            {
            $start = date('Y-m-d 00:00:00'); $end = date('Y-m-d H:i:s',strtotime(now())); 
            $query->whereBetween('survey_requests.created_at', [$start, $end]);
            }else if($request->date_val == "week")
            {
            $start = date('Y-m-d 00:00:00', strtotime('monday this week')); $end = date('Y-m-d H:i:s',strtotime(now())); 

            $query->whereBetween('survey_requests.created_at', [$start, $end]);
            }
            else if($request->date_val == "month")
            {
            $start = date('Y-m-01 00:00:00'); $end = date('Y-m-d H:i:s',strtotime(now())); 

            $query->whereBetween('survey_requests.created_at', [$start, $end]);
            }else
            {
            $query->whereYear('survey_requests.created_at', $request->date_val);
            }

            } 

          $data['survey_requests']    =     $query->get();  

        return view('superadmin.requested_services.new_service_requests',$data);
    }
    
    public function service_master()
    {
        
        $data['title']              =   'Service Master';
        $data['menu']               =   'service-master';
        $data['service_master']    = Services::where('is_active',1)->where('is_deleted',0)->get();
    
       return view('superadmin.service-master',$data); 
    }

    public function new_service_request_detail($id)
    {
        $data['title']       =   'New Service Request';
        $data['menu']        =   'new-service-request';

        $datas = Survey_requests::where('id',$id)->first();

        $data['service'] = Services::where('id',$datas->service_id)->first()->service_name;

        $data['survey_id'] = $id;

        $data['institutions'] = Institution::where('is_deleted',0)->where('is_active',1) ->get();

        // $data['admins'] = Admin::where('role_id',2)->get();

        if($datas->request_status != 1)
        {
            return redirect('superadmin/new_service_requests');
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

        if(isset($data['request_data']->additional_services))
        {
           $data['additional_services'] = $datas->services_selected($data['request_data']->additional_services);
        }
        else
        {
             $data['additional_services'] ="";
        }

        if(isset($data['request_data']->data_collection_equipments))
        {
           $data['data_collection'] = $datas->datacollection_selected($data['request_data']->data_collection_equipments);
        }else
        {
             $data['data_collection'] ="";
        }
        

        // $data['survey_requests']    =   DB::table('survey_requests')
        //                                 ->join('cust_mst', 'survey_requests.cust_id', '=', 'cust_mst.id')
        //                                 ->join('cust_info', 'survey_requests.cust_id', '=', 'cust_info.cust_id')
        //                                 ->join('cust_telecom', 'survey_requests.cust_id', '=', 'cust_telecom.cust_id')
        //                                 ->join('services', 'survey_requests.service_id', '=', 'services.id')
        //                                 ->where('survey_requests.is_deleted',NULL)->orWhere('survey_requests.is_deleted',0)
        //                                 ->where('cust_mst.is_deleted',NULL)->orWhere('cust_mst.is_deleted',0)
        //                                 ->where('cust_telecom.is_deleted',NULL)->orWhere('cust_telecom.is_deleted',0)->where('cust_telecom.telecom_type',2)
        //                                 ->select('survey_requests.id AS survey_id','survey_requests.created_at AS survey_date','survey_requests.*','cust_mst.*','cust_info.*', 'cust_telecom.*','services.*')
        //                                 ->orderBy('survey_requests.id','DESC')
        //                                 ->get();

        // dd($data);

        return view('superadmin.requested_services.new_service_request_detail',$data);
    }

    public function assign_survey(Request $request)
    {
        $input = $request->all();

        $validator = Validator::make($request->all(), [
            'id'=>['required'],
            'assigned_institution'=>['required'],
            'assigned_user'=>['required'],
            'assign_survey_remarks'=>['nullable','regex:/^[a-zA-Z0-9\s.,@#&*()_\-\/=]*$/'],
        ]);

        if($validator->passes())
        {
            $cust_id = survey_requests::where('id',$input['id'])->first()->cust_id;
            $cust_email = CustomerMaster::where('id',$cust_id)->first()->username;

            $assign_arr['request_status'] = 2;
            $assign_arr['assigned_institution'] = $input['assigned_institution'];
            $assign_arr['assigned_user'] = $input['assigned_user'];
            $assign_arr['updated_by'] = auth()->user()->id;
            $assign_arr['updated_at'] = date('Y-m-d H:i:s');

            Survey_requests::where('id',$input['id'])->update($assign_arr);


            $from       = auth()->user()->id; 
            $utype      = 2;
            $to         = $input['assigned_user']; 
            $ntype      = 'field_study_assigned';
            $title      = 'New Field Study Request';
            $desc       = 'New Field Study Request. Request ID:HSW'.$input['id'];
            $refId      = $input['id'];
            $reflink = '/admin/new_service_request_detail/'.$input['id'].'/2/';
            $notify     = 'admin';
            $notify_from_role_id = 1;
            addNotification($from,$utype,$to,$ntype,$title,$desc,$refId,$reflink,$notify,$notify_from_role_id);

            $from       = auth()->user()->id; 
            $utype      = 6;
            $to         = $cust_id; 
            $ntype      = 'field_study_assigned';
            $title      = 'Service Request Accepted';
            $desc       = 'Service Request Accepted by CH. Request ID:HSW'.$input['id'];
            $refId      = $input['id'];
            $reflink = '/customer/request_service_detail/'.$input['id'].'/2/';
            $notify     = 'customer';
            $notify_from_role_id = 1;
            addNotification($from,$utype,$to,$ntype,$title,$desc,$refId,$reflink,$notify,$notify_from_role_id);
            
            $from       = auth()->user()->id; 
            $utype      = 6;
            $to         = $cust_id; 
            $ntype      = 'field_study_assigned';
            $title      = 'Field Study Request Assigned to Admin';
            $desc       = 'Field Study Request Assigned to Admin. Request ID:HSW'.$input['id'];
            $refId      = $input['id'];
            $reflink = '/customer/request_service_detail/'.$input['id'].'/2/';
            $notify     = 'customer';
            $notify_from_role_id = 1;
            addNotification($from,$utype,$to,$ntype,$title,$desc,$refId,$reflink,$notify,$notify_from_role_id);

            $survey_request_logs = [];

            $survey_request_logs['survey_request_id'] = $input['id'];
            $survey_request_logs['cust_id'] = $cust_id;
            $survey_request_logs['survey_status'] = 2;
            $survey_request_logs['remarks'] = $input['assign_survey_remarks'];
            $survey_request_logs['is_active'] = 1;
            $survey_request_logs['is_deleted'] = 0;
            $survey_request_logs['created_by'] = auth()->user()->id;
            $survey_request_logs['updated_by'] = auth()->user()->id;
            $survey_request_logs['created_at'] = date('Y-m-d H:i:s');
            $survey_request_logs['updated_at'] = date('Y-m-d H:i:s');

            $survey_request_log_id = Survey_request_logs::create($survey_request_logs)->id;

            $data['id'] = $input['id'];
            
            // $var = Mail::send('emails.accept_survey', $data, function($message) use($data,$cust_email) {
            //     $message->from(getadmin_mail(),'HSW');    
            //     $message->to($cust_email);
            //     $message->subject('Survey Request Accepted by CH');
            // });

            if(isset($survey_request_log_id))
            {   
                Session::flash('message', ['text'=>'Successfully Assigned Marine Surveyor for Field Study !','type'=>'success']);  
            }
            else
            {
                Session::flash('message', ['text'=>'Assigning Marine Surveyor for Field Study is Not Successfull !','type'=>'danger']);
            }

            return redirect('/superadmin/new_service_requests');
        }
        else
        {
            return redirect()->back()->withErrors($validator)->withInput($request->all());
        }
    }

    public function requested_services(Request $request)
    { 
        $data['title']              =   'Requested Services';
        $data['menu']               =   'requested-services';
        $data['ins']               =  $request->ins; 
        $data['date_val']               =  $request->date_val; 
        $data['sub_offices']               =   Institution::where('is_active',1)->where('is_deleted',0)->get();
         $query =   DB::table('survey_requests')
                                        ->leftjoin('cust_mst', 'survey_requests.cust_id', '=', 'cust_mst.id')
                                        ->leftjoin('cust_info', 'survey_requests.cust_id', '=', 'cust_info.cust_id')
                                        ->leftjoin('cust_telecom', 'survey_requests.cust_id', '=', 'cust_telecom.cust_id')
                                        ->leftjoin('services', 'survey_requests.service_id', '=', 'services.id')
                                        ->leftjoin('institution', 'survey_requests.assigned_institution', '=', 'institution.id')
                                        ->leftjoin('survey_status', 'survey_requests.request_status', '=', 'survey_status.id')
                                        ->where('survey_requests.request_status','!=',1)->where('survey_requests.request_status','!=',NULL)->Where('survey_requests.is_deleted',0)
                                        ->where('survey_requests.cartographer_request','=',0)
                                        ->where('cust_mst.is_deleted',0)
                                        ->where('cust_telecom.is_deleted',0)->where('cust_telecom.telecom_type',2)
                                        
                                        ->select('survey_requests.id AS survey_id','survey_requests.created_at AS survey_date','survey_requests.*','cust_mst.*','cust_info.*', 'cust_telecom.*','services.*','institution.*','survey_status.status_name AS current_status')
                                        ->orderBy('survey_requests.id','DESC');
          if($request->ins >0){
            $query->where('survey_requests.assigned_institution', $request->ins);
          } 

          if($request->date_val !=""){

            if($request->date_val == "today")
            {
                $start = date('Y-m-d 00:00:00'); $end = date('Y-m-d H:i:s',strtotime(now())); 
                $query->whereBetween('survey_requests.created_at', [$start, $end]);
            }else if($request->date_val == "week")
            {
                $start = date('Y-m-d 00:00:00', strtotime('monday this week')); $end = date('Y-m-d H:i:s',strtotime(now())); 
                
                $query->whereBetween('survey_requests.created_at', [$start, $end]);
            }
            else if($request->date_val == "month")
            {
                $start = date('Y-m-1 00:00:00'); $end = date('Y-m-d H:i:s',strtotime(now())); 
                
                $query->whereBetween('survey_requests.created_at', [$start, $end]);
            }else
            {
                $query->whereYear('survey_requests.created_at', $request->date_val);
            }
            
          } 

          $data['survey_requests']    =     $query->get();                         
                                        // dd($data);
        return view('superadmin.requested_services.requested_services',$data);
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

        if($datas->request_status != $status)
        {
            return redirect('superadmin/requested_service_detail/'.$id.'/'.$datas->request_status);
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

        if(isset($data['request_data']->additional_services))
        {
           $data['additional_services'] = $datas->services_selected($data['request_data']->additional_services);
        }else
        {
             $data['additional_services'] ="";
        }

        if(isset($data['request_data']->data_collection_equipments))
        {
           $data['data_collection'] = $datas->datacollection_selected($data['request_data']->data_collection_equipments);
        }else
        {
             $data['data_collection'] ="";
        }
        

        $data['state_name'] = State::where('id',$data['request_data']['state'])->first()->state_name;
        $data['district_name'] = City::where('id',$data['request_data']['district'])->first()->city_name;
        
        $data['survey_datas'] = DB::table('survey_request_logs')
                                ->leftjoin('survey_status', 'survey_request_logs.survey_status', '=', 'survey_status.id')
                                ->where('survey_request_logs.cust_id',$cust_id)->where('survey_request_logs.survey_request_id',$id)->where('survey_request_logs.is_active',1)->where('survey_request_logs.is_deleted',0)
                                ->select('survey_request_logs.created_at AS log_date','survey_request_logs.*','survey_status.*')
                                ->orderBy('survey_request_logs.id','DESC')
                                ->get();

        if($status == 25 || $status == 26)
        {
            $data['final_report'] = Survey_requests::where('id',$id)->first()->final_report;
            $data['ms_remarks'] = Survey_request_logs::where('survey_request_id',$id)->where('survey_status',25)->orderBy('id','desc')->first()->remarks;

            // dd($data);

            return view('superadmin.requested_services.dh_final_report',$data);
        }
        elseif($status == 21 || $status == 22)
        {
            $data['draftmans'] = Admin::where('role_id',4)->get();
            $data['survey_study'] = Survey_study_report::where('survey_request_id',$id)->first();
            $data['remarks'] = Survey_request_logs::where('survey_request_id',$id)->where('survey_status',21)->orderBy('id','desc')->first()->remarks;

            // dd($data);

            return view('superadmin.requested_services.dh_verified_survey_study',$data);
        }
        elseif($status == 17)
        {
            $data['field_study'] = Field_study_report::where('survey_request_id',$id)->first();
            $data['survey_invoice'] = Survey_invoice::where('survey_request_id',$id)->first();
            $data['fieldstudy_eta'] = Fieldstudy_eta::where('survey_request_id',$id)->first();
            $data['ao_remarks'] = Survey_request_logs::where('survey_request_id',$id)->where('survey_status',17)->orderBy('id','desc')->first()->remarks;
            $data['survey_request_data'] = Survey_requests::where('id',$id)->first();

            // dd($data);

            return view('superadmin.requested_services.customer_payment_rejected',$data);
        }
        elseif($status == 16)
        {
            $data['field_study'] = Field_study_report::where('survey_request_id',$id)->first();
            $data['survey_invoice'] = Survey_invoice::where('survey_request_id',$id)->first();
            $data['fieldstudy_eta'] = Fieldstudy_eta::where('survey_request_id',$id)->first();
            $data['ao_remarks'] = Survey_request_logs::where('survey_request_id',$id)->where('survey_status',16)->orderBy('id','desc')->first()->remarks;
            $data['survey_request_data'] = Survey_requests::where('id',$id)->first();

            return view('superadmin.requested_services.customer_payment_verified',$data);
        }
        elseif($status == 54)
        {
            $data['draftmans'] = Admin::where('role_id',4)->get();
            $data['field_study'] = Field_study_report::where('survey_request_id',$id)->first();
            $data['survey_performa_invoice'] = Survey_performa_invoice::where('survey_request_id',$id)->first();
            $data['survey_remarks'] = Survey_request_logs::where('survey_request_id',$id)->where('survey_status',54)->orderBy('id','desc')->first()->remarks;

            return view('superadmin.requested_services.customer_accepted_performa',$data);
        }
        elseif($status == 49 || $status == 50)
        {
            $data['field_study'] = Field_study_report::where('survey_request_id',$id)->first();
            $data['survey_invoice'] = Survey_invoice::where('survey_request_id',$id)->first();
            $data['ms_remarks'] = Survey_request_logs::where('survey_request_id',$id)->where('survey_status',49)->orderBy('id','desc')->first()->remarks;

            return view('superadmin.requested_services.dh_verified_invoice',$data);
        }
        elseif($status == 13 || $status == 14)
        {
            $data['field_study'] = Field_study_report::where('survey_request_id',$id)->first();
            $data['survey_invoice'] = Survey_performa_invoice::where('survey_request_id',$id)->first();
            $data['ms_remarks'] = Survey_request_logs::where('survey_request_id',$id)->where('survey_status',13)->orderBy('id','desc')->first()->remarks;

            return view('superadmin.requested_services.dh_verified_performa_invoice',$data);
        }
        elseif($status == 8 || $status == 9)
        {
            $data['draftmans'] = Admin::where('role_id',4)->get();
            $data['field_study'] = Field_study_report::where('survey_request_id',$id)->first();
            $data['field_study_eta'] = Fieldstudy_eta::where('survey_request_id',$id)->first();
            $data['cities'] = City::where('is_deleted',0)->get();
            $data['survey_type'] = SurveyType::where('is_deleted',0)->get();
            $data['eta_remarks'] = Survey_request_logs::where('survey_request_id',$id)->where('survey_status',8)->orderBy('id','desc')->first()->remarks;

            return view('superadmin.requested_services.eta_received',$data);            
        }
        elseif($status == 7)
        {
            $data['field_study'] = Field_study_report::where('survey_request_id',$id)->first();
            $data['draftmans'] = Admin::where('role_id',4)->get();

            return view('superadmin.requested_services.surveyor_submitted_field_study',$data);
        }
        else
        {
            // dd($data);
            return view('superadmin.requested_services.requested_services_details',$data);
        }
    }

    public function verify_field_study($id)
    {
        Survey_requests::where('id',$id)->update(['request_status'=>9]);

        $cust_id = survey_requests::where('id',$id)->first()->cust_id;

        $survey_request_logs = [];

        $survey_request_logs['survey_request_id'] = $id;
        $survey_request_logs['cust_id'] = $cust_id;
        $survey_request_logs['survey_status'] = 9;
        $survey_request_logs['is_active'] = 1;
        $survey_request_logs['is_deleted'] = 0;
        $survey_request_logs['created_by'] = auth()->user()->id;
        $survey_request_logs['updated_by'] = auth()->user()->id;
        $survey_request_logs['created_at'] = date('Y-m-d H:i:s');
        $survey_request_logs['updated_at'] = date('Y-m-d H:i:s');

        $survey_request_log_id = Survey_request_logs::create($survey_request_logs)->id;

        if(isset($survey_request_log_id))
        {   
            Session::flash('message', ['text'=>'Verified Field Study Successfully !','type'=>'success']);  
        }
        else
        {
            Session::flash('message', ['text'=>'Field Study Verification is Not Successfull !','type'=>'danger']);
        }

        return redirect('superadmin/requested_services');
    }

    public function assign_draftsman(Request $request)
    {
        $input = $request->all();

        $validator = Validator::make($request->all(), [
            'id'=>['required'],
            'draftsman'=>['required'],
            'remarks'=>['nullable','regex:/^[a-zA-Z0-9\s.,@#&*()_\-\/=]*$/']
        ]);

        if($validator->passes())
        {
            $cust_id = survey_requests::where('id',$input['id'])->first()->cust_id;
            $assigned_draftsman = survey_requests::where('id',$input['id'])->first()->assigned_draftsman;
            $assign_arr['request_status'] = 10;
            $assign_arr['assigned_draftsman'] = $input['draftsman'];
            $assign_arr['updated_by'] = auth()->user()->id;
            $assign_arr['updated_at'] = date('Y-m-d H:i:s');

            Survey_requests::where('id',$input['id'])->update($assign_arr);

            $survey_request_logs = [];

            $survey_request_logs['survey_request_id'] = $input['id'];
            $survey_request_logs['cust_id'] = $cust_id;
            $survey_request_logs['survey_status'] = 10;
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
                $to         = $input['draftsman'];
                $ntype      = 'request_assigned';
                $title      = 'Request Assigned';
                $desc       = 'Request Assigned. Request ID: HSW'.$input['id'];
                $refId      = $input['id'];
                $reflink    = '/draftsman/service_requests_detail/'.$input['id'].'/10/';
                $notify     = 'draftsman';
                $notify_from_role_id = 1;
                addNotification($from,$utype,$to,$ntype,$title,$desc,$refId,$reflink,$notify,$notify_from_role_id); 

            if(isset($survey_request_log_id))
            {   
                Session::flash('message', ['text'=>'Successfully Assigned Draftsman for Performa Invoice Preparation !','type'=>'success']);  
            }
            else
            {
                Session::flash('message', ['text'=>'Assign Draftsman for Performa Invoice Preparation is Not Successfull !','type'=>'danger']);
            }

            return redirect('/superadmin/requested_services');
        }
        else
        {
            return redirect()->back()->withErrors($validator)->withInput($request->all());
        }
    }

    public function assign_draftsman_invoice(Request $request)
    {
        $input = $request->all();

        $validator = Validator::make($request->all(), [
            'id'=>['required'],
            'draftsman'=>['required'],
            'invoice_remarks'=>['nullable','regex:/^[a-zA-Z0-9\s.,@#&*()_\-\/=]*$/']
        ]);

        if($validator->passes())
        {
            $cust_id = survey_requests::where('id',$input['id'])->first()->cust_id;
            $assigned_draftsman_final = survey_requests::where('id',$input['id'])->first()->assigned_draftsman_final;
            $assigned_draftsman = survey_requests::where('id',$input['id'])->first()->assigned_draftsman;
            
            $assign_arr['request_status'] = 46;
            $assign_arr['updated_by'] = auth()->user()->id;
            $assign_arr['updated_at'] = date('Y-m-d H:i:s');

            Survey_requests::where('id',$input['id'])->update($assign_arr);

            $survey_request_logs = [];

            $survey_request_logs['survey_request_id'] = $input['id'];
            $survey_request_logs['cust_id'] = $cust_id;
            $survey_request_logs['survey_status'] = 46;
            $survey_request_logs['remarks'] = $input['invoice_remarks'];
            $survey_request_logs['is_active'] = 1;
            $survey_request_logs['is_deleted'] = 0;
            $survey_request_logs['created_by'] = auth()->user()->id;
            $survey_request_logs['updated_by'] = auth()->user()->id;
            $survey_request_logs['created_at'] = date('Y-m-d H:i:s');
            $survey_request_logs['updated_at'] = date('Y-m-d H:i:s');

            $survey_request_log_id = Survey_request_logs::create($survey_request_logs)->id;

                $from       = auth()->user()->id;
                $utype      = 4;
                $to         = $assigned_draftsman; 
                $ntype      = 'request_assigned_for_invoice';
                $title      = 'Request Assigned for Invoice';
                $desc       = 'Request Assigned for Invoice. Request ID: HSW'.$input['id'];
                $refId      = $input['id'];
                $reflink    = '/draftsman/service_requests_detail/'.$input['id'].'/46/';
                $notify     = 'draftsman';
                $notify_from_role_id = 1;
                addNotification($from,$utype,$to,$ntype,$title,$desc,$refId,$reflink,$notify,$notify_from_role_id); 

            if(isset($survey_request_log_id))
            {   
                Session::flash('message', ['text'=>'Successfully Assigned Draftsman for Invoice Preparation !','type'=>'success']);  
            }
            else
            {
                Session::flash('message', ['text'=>'Assigning Draftsman for Invoice Preparation is Not Successfull !','type'=>'danger']);
            }

            return redirect('/superadmin/requested_services');
        }
        else
        {
            return redirect()->back()->withErrors($validator)->withInput($request->all());
        }
    }

    public function assign_survey_study(Request $request)
    {
        $input = $request->all();

        $validator = Validator::make($request->all(), [
            'id'=>['required'],
            'assigned_survey_institution'=>['required'],
            'assigned_survey_user'=>['required'],
            'remarks' => ['nullable','regex:/^[a-zA-Z0-9\s.,@#&*()_\-\/=]*$/']
        ]);

        if($validator->passes())
        {
            $cust_id = survey_requests::where('id',$input['id'])->first()->cust_id;

            $assign_arr['request_status'] = 18;
            $assign_arr['assigned_survey_institution'] = $input['assigned_survey_institution'];
            $assign_arr['assigned_survey_user'] = $input['assigned_survey_user'];
            $assign_arr['updated_by'] = auth()->user()->id;
            $assign_arr['updated_at'] = date('Y-m-d H:i:s');

            Survey_requests::where('id',$input['id'])->update($assign_arr);

            $from       = auth()->user()->id; 
            $utype      = 3;
            $to         = $input['assigned_survey_user']; 
            $ntype      = 'survey_study_assigned';
            $title      = 'New Survey Study Request';
            $desc       = 'New Survey Study Request. Request ID:HSW'.$input['id'];
            $refId      = $input['id'];
            $reflink    = 'survey_study_request';
            $notify     = 'surveyor';
            $notify_from_role_id = 1;
            addNotification($from,$utype,$to,$ntype,$title,$desc,$refId,$reflink,$notify,$notify_from_role_id);

            $survey_request_logs = [];

            $survey_request_logs['survey_request_id'] = $input['id'];
            $survey_request_logs['cust_id'] = $cust_id;
            $survey_request_logs['survey_status'] = 18;
            $survey_request_logs['remarks'] = $input['remarks'];
            $survey_request_logs['is_active'] = 1;
            $survey_request_logs['is_deleted'] = 0;
            $survey_request_logs['created_by'] = auth()->user()->id;
            $survey_request_logs['updated_by'] = auth()->user()->id;
            $survey_request_logs['created_at'] = date('Y-m-d H:i:s');
            $survey_request_logs['updated_at'] = date('Y-m-d H:i:s');


            $from       = auth()->user()->id; 
            $utype      = 6;
            $to         = $cust_id; 
            $ntype      = 'survey_study_assigned';
            $title      = 'New Survey Study Request';
            $desc       = 'New Survey Study Request. Request ID:HSW'.$input['id'];
            $refId      = $input['id'];
            $reflink    = 'customer/request_service_detail/'.$input['id'].'/18/';
            $notify     = 'customer';
            $notify_from_role_id = 1;
            addNotification($from,$utype,$to,$ntype,$title,$desc,$refId,$reflink,$notify,$notify_from_role_id);

            $from       = auth()->user()->id; 
            $utype      = 2;
            $to         =  $input['assigned_survey_user'];
            $ntype      = 'survey_study_assigned';
            $title      = 'New Survey Study Request';
            $desc       = 'New Survey Study Request. Request ID:HSW'.$input['id'];
            $refId      = $input['id'];
            $reflink    = 'admin/requested_service_detail/'.$input['id'].'/18/';
            $notify     = 'admin';
            $notify_from_role_id = 1;
            addNotification($from,$utype,$to,$ntype,$title,$desc,$refId,$reflink,$notify,$notify_from_role_id);            

            // $from       = auth()->user()->id; 
            // $utype      = 5;
            // $to         = 5; 
            // $ntype      = 'survey_study_assigned';
            // $title      = 'New Survey Study Request';
            // $desc       = 'New Survey Study Request. Request ID:HSW'.$input['id'];
            // $refId      = $input['id'];
            // $reflink    = 'accountant/receipt_received/'.$input['id'];
            // $notify     = 'accounts';
            // $notify_from_role_id = 1;
            // addNotification($from,$utype,$to,$ntype,$title,$desc,$refId,$reflink,$notify,$notify_from_role_id);

            $survey_request_log_id = Survey_request_logs::create($survey_request_logs)->id;

            if(isset($survey_request_log_id))
            {   
                Session::flash('message', ['text'=>'Successfully Assigned Marine Surveyor for Survey Study !','type'=>'success']);  
            }
            else
            {
                Session::flash('message', ['text'=>'Assigning Marine Surveyor for Survey Study is Not Successfull !','type'=>'danger']);
            }

            return redirect('/superadmin/requested_services');
        }
        else
        {
            return redirect()->back()->withErrors($validator)->withInput($request->all());
        }
    }

    public function send_performa_invoice_customer(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'send_remarks' => ['nullable','regex:/^[a-zA-Z0-9\s.,@#&*()_\-\/=]*$/']
        ]);

        if($validator->passes())
        {
            $id = $request->id;

            $cust_id = survey_requests::where('id',$id)->first()->cust_id;
            $cust_email = CustomerMaster::where('id',$cust_id)->first()->username;

            Survey_requests::where('id',$id)->update(['request_status'=>15]);


                        // // notify customer
            $from       = auth()->user()->id; 
            $utype      = 6;
            $to         = $cust_id; 
            $ntype      = 'peforma_invoice_verified';
            $title      = 'Performa Invoice Verified by CH';
            $desc       = 'Performa Invoice Verified by CH. Request ID:HSW'.$id;
            $refId      = $id;
            $reflink    = 'customer/request_service_detail/'.$id.'/15/';
            $notify     = 'customer';
            $notify_from_role_id = 1;
            addNotification($from,$utype,$to,$ntype,$title,$desc,$refId,$reflink,$notify,$notify_from_role_id);

            $survey_request_logs = [];

            $survey_request_logs['survey_request_id'] = $id;
            $survey_request_logs['cust_id'] = $cust_id;
            $survey_request_logs['survey_status'] = 15;
            $survey_request_logs['remarks'] = $request->send_remarks;
            $survey_request_logs['is_active'] = 1;
            $survey_request_logs['is_deleted'] = 0;
            $survey_request_logs['created_by'] = auth()->user()->id;
            $survey_request_logs['updated_by'] = auth()->user()->id;
            $survey_request_logs['created_at'] = date('Y-m-d H:i:s');
            $survey_request_logs['updated_at'] = date('Y-m-d H:i:s');

            $survey_request_log_id = Survey_request_logs::create($survey_request_logs)->id;

                        // // notify customer
            $from       = auth()->user()->id; 
            $utype      = 6;
            $to         = $cust_id; 
            $ntype      = 'peforma_invoice_sent';
            $title      = 'Performa Invoice Sent To Customer by CH';
            $desc       = 'Performa Invoice Sent To Customer by CH. Request ID:HSW'.$id;
            $refId      = $id;
            $reflink    = 'customer/request_service_detail/'.$id.'/15/';
            $notify     = 'customer';
            $notify_from_role_id = 1;
            addNotification($from,$utype,$to,$ntype,$title,$desc,$refId,$reflink,$notify,$notify_from_role_id);

            $data['id'] = $id;

            // $var = Mail::send('emails.performa_invoice_received', $data, function($message) use($data,$cust_email) {
            //     $message->from(getadmin_mail(),'HSW');    
            //     $message->to($cust_email);
            //     $message->subject('Performa Invoice Generated');
            // });


            if(isset($survey_request_log_id))
            {   
                Session::flash('message', ['text'=>'Performa Invoice Send to Customer Successfully !','type'=>'success']);  
            }
            else
            {
                Session::flash('message', ['text'=>'Performa Invoice Send to Customer is not Successfull !','type'=>'danger']);
            }

            return redirect('superadmin/requested_services');
        }
        else
        {
            return redirect()->back()->withErrors($validator)->withInput($request->all());
        }
    }

    public function send_invoice_customer(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'send_remarks' => ['nullable','regex:/^[a-zA-Z0-9\s.,@#&*()_\-\/=]*$/']
        ]);

        if($validator->passes())
        {
            $id = $request->id;

            $cust_id = survey_requests::where('id',$id)->first()->cust_id;
            $cust_email = CustomerMaster::where('id',$cust_id)->first()->username;

            Survey_requests::where('id',$id)->update(['request_status'=>51]);

                        // // notify customer
            $from       = auth()->user()->id; 
            $utype      = 6;
            $to         = $cust_id; 
            $ntype      = 'invoice_verified_by_ch';
            $title      = 'Invoice Verified by CH';
            $desc       = 'Invoice Verified by CH. Request ID:HSW'.$id;
            $refId      = $id;
            $reflink    = 'customer/request_service_detail/'.$id.'/51/';
            $notify     = 'customer';
            $notify_from_role_id = 1;
            addNotification($from,$utype,$to,$ntype,$title,$desc,$refId,$reflink,$notify,$notify_from_role_id);

            $survey_request_logs = [];

            $survey_request_logs['survey_request_id'] = $id;
            $survey_request_logs['cust_id'] = $cust_id;
            $survey_request_logs['survey_status'] = 51;
            $survey_request_logs['remarks'] = $request->send_remarks;
            $survey_request_logs['is_active'] = 1;
            $survey_request_logs['is_deleted'] = 0;
            $survey_request_logs['created_by'] = auth()->user()->id;
            $survey_request_logs['updated_by'] = auth()->user()->id;
            $survey_request_logs['created_at'] = date('Y-m-d H:i:s');
            $survey_request_logs['updated_at'] = date('Y-m-d H:i:s');

            $survey_request_log_id = Survey_request_logs::create($survey_request_logs)->id;

                        // // notify customer
            $from       = auth()->user()->id; 
            $utype      = 6;
            $to         = $cust_id; 
            $ntype      = 'invoice_sent';
            $title      = 'Invoice Sent To Customer by CH';
            $desc       = 'Invoice Sent To Customer by CH. Request ID:HSW'.$id;
            $refId      = $id;
            $reflink    = 'customer/request_service_detail/'.$id.'/51/';
            $notify     = 'customer';
            $notify_from_role_id = 1;
            addNotification($from,$utype,$to,$ntype,$title,$desc,$refId,$reflink,$notify,$notify_from_role_id);

            $data['id'] = $id;
            $data['link'] = url('/customer/customer_invoice_download/'.$id);

            // $var = Mail::send('emails.invoice_received', $data, function($message) use($data,$cust_email) {
            //     $message->from(getadmin_mail(),'HSW');    
            //     $message->to($cust_email);
            //     $message->subject('Invoice Generated');
            // });

            if(isset($survey_request_log_id))
            {   
                Session::flash('message', ['text'=>'Invoice Send to Customer Successfully !','type'=>'success']);  
            }
            else
            {
                Session::flash('message', ['text'=>'Invoice Send to Customer is not Successfull !','type'=>'danger']);
            }

            return redirect('superadmin/requested_services');
        }
        else
        {
            return redirect()->back()->withErrors($validator)->withInput($request->all());
        }
    }

    public function send_rejected_receipt_customer(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'remarks' => ['nullable','regex:/^[a-zA-Z0-9\s.,@#&*()_\-\/=]*$/']
        ]);

        if($validator->passes())
        {
            $id = $request->id;

            // dd($id);

            $cust_id = survey_requests::where('id',$id)->first()->cust_id;

            Survey_requests::where('id',$id)->update(['request_status'=>70]);

            $survey_request_logs = [];

            $survey_request_logs['survey_request_id'] = $id;
            $survey_request_logs['cust_id'] = $cust_id;
            $survey_request_logs['survey_status'] = 70;
            $survey_request_logs['remarks'] = $request->remarks;
            $survey_request_logs['is_active'] = 1;
            $survey_request_logs['is_deleted'] = 0;
            $survey_request_logs['created_by'] = auth()->user()->id;
            $survey_request_logs['updated_by'] = auth()->user()->id;
            $survey_request_logs['created_at'] = date('Y-m-d H:i:s');
            $survey_request_logs['updated_at'] = date('Y-m-d H:i:s');

            $survey_request_log_id = Survey_request_logs::create($survey_request_logs)->id;

            $usr_noti = [];

            $usr_noti['notify_from'] = auth()->user()->id;
            $usr_noti['notify_to'] = $cust_id;
            $usr_noti['role_id'] = 6;
            $usr_noti['notify_from_role_id'] = 1;
            $usr_noti['notify_type'] = 0;
            $usr_noti['title'] = 'Payment Rejected';
            $usr_noti['description'] = 'Payment Rejected by Accounts Officer for Request ID HSW'.$id;
            $usr_noti['ref_id'] = auth()->user()->id;
            $usr_noti['ref_link'] = '/customer/receipt_rejected/'.$id.'/70';
            $usr_noti['viewed'] = 0;
            $usr_noti['created_at'] = date('Y-m-d H:i:s');
            $usr_noti['updated_at'] = date('Y-m-d H:i:s');
            $usr_noti['deleted_at'] = date('Y-m-d H:i:s');

            $user_noti_id = UserNotification::create($usr_noti)->id;

            if(isset($user_noti_id))
            {   
                Session::flash('message', ['text'=>'Rejected receipt Send to Customer Successfully !','type'=>'success']);  
            }
            else
            {
                Session::flash('message', ['text'=>'Rejected receipt Send to Customer is not Successfull !','type'=>'danger']);
            }

            return redirect('superadmin/requested_services');
        }
        else
        {
            return redirect()->back()->withErrors($validator)->withInput($request->all());
        }
    }

    public function assign_draftsman_final(Request $request)
    {
        $input = $request->all();

        $validator = Validator::make($request->all(), [
            'id'=>['required'],
            'final_draftsman'=>['required'],
            'assign_remarks' => ['nullable','regex:/^[a-zA-Z0-9\s.,@#&*()_\-\/=]*$/']
        ]);

        if($validator->passes())
        {
            $cust_id = survey_requests::where('id',$input['id'])->first()->cust_id;

            $assign_arr['request_status'] = 23;
            $assign_arr['assigned_draftsman_final'] = $input['final_draftsman'];
            $assign_arr['updated_by'] = auth()->user()->id;
            $assign_arr['updated_at'] = date('Y-m-d H:i:s');

            Survey_requests::where('id',$input['id'])->update($assign_arr);

            $survey_request_logs = [];

            $survey_request_logs['survey_request_id'] = $input['id'];
            $survey_request_logs['cust_id'] = $cust_id;
            $survey_request_logs['survey_status'] = 23;
            $survey_request_logs['remarks'] = $input['assign_remarks'];
            $survey_request_logs['is_active'] = 1;
            $survey_request_logs['is_deleted'] = 0;
            $survey_request_logs['created_by'] = auth()->user()->id;
            $survey_request_logs['updated_by'] = auth()->user()->id;
            $survey_request_logs['created_at'] = date('Y-m-d H:i:s');
            $survey_request_logs['updated_at'] = date('Y-m-d H:i:s');

            $survey_request_log_id = Survey_request_logs::create($survey_request_logs)->id;

            $from       = auth()->user()->id; 
            $utype      = 4;
            $to         = $input['final_draftsman'];
            $ntype      = 'assigned_for_final_report';
            $title      = 'Assigned for Final Report by CH';
            $desc       = 'Assigned for Final Report by CH. Request ID:HSW'.$input['id'];
            $refId      =$input['id'];
            $reflink    = '/draftsman/service_requests_detail/'.$input['id'].'/23/';
            $notify     = 'draftsman';
            $notify_from_role_id = 1;
            addNotification($from,$utype,$to,$ntype,$title,$desc,$refId,$reflink,$notify,$notify_from_role_id);

            if(isset($survey_request_log_id))
            {   
                Session::flash('message', ['text'=>'Successfully Assigned Draftsman for Final Report Preparation !','type'=>'success']);  
            }
            else
            {
                Session::flash('message', ['text'=>'Assigning Draftsman for Final Report Preparation is not Successfull !','type'=>'danger']);
            }

            return redirect('/superadmin/requested_services');
        }
        else
        {
            return redirect()->back()->withErrors($validator)->withInput($request->all());
        }
    }

    public function edit_service_rate(Request $request)
    {
        $input = $request->all();

        $validator = Validator::make($request->all(), [
            'service_id'=>['required'],
            'service_rate'=>['required','regex:/^[0-9]*$/'],
        ]);

        if($validator->passes())
        {
            $service_arr['service_rate'] = $input['service_rate'];
            $service_arr['updated_by'] = auth()->user()->id;
            $service_arr['updated_at'] = date('Y-m-d H:i:s');

            Services::where('id',$input['service_id'])->update($service_arr);

            Session::flash('message', ['text'=>'Service Rate Updated Successfully !','type'=>'success']);
            
            return redirect('/superadmin/service-master');
        }
        else
        {
            return redirect()->back()->withErrors($validator)->withInput($request->all());
        }
    }

    public function verify_final_report(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'verify_remarks' => ['nullable','regex:/^[a-zA-Z0-9\s.,@#&*()_\-\/=]*$/']
        ]);

        if($validator->passes())
        {
            $id = $request->id;

            Survey_requests::where('id',$id)->update(['request_status'=>27]);

            $cust_id = survey_requests::where('id',$id)->first()->cust_id;

            $survey_request_logs = [];

            $survey_request_logs['survey_request_id'] = $id;
            $survey_request_logs['cust_id'] = $cust_id;
            $survey_request_logs['survey_status'] = 27;
            $survey_request_logs['remarks'] = $request->verify_remarks;
            $survey_request_logs['is_active'] = 1;
            $survey_request_logs['is_deleted'] = 0;
            $survey_request_logs['created_by'] = auth()->user()->id;
            $survey_request_logs['updated_by'] = auth()->user()->id;
            $survey_request_logs['created_at'] = date('Y-m-d H:i:s');
            $survey_request_logs['updated_at'] = date('Y-m-d H:i:s');

            $survey_request_log_id = Survey_request_logs::create($survey_request_logs)->id;

            $usr_noti = [];

            $usr_noti['notify_from'] = auth()->user()->id;
            $usr_noti['notify_to'] = $cust_id;
            $usr_noti['role_id'] = 6;
            $usr_noti['notify_from_role_id'] = 1;
            $usr_noti['notify_type'] = 0;
            $usr_noti['title'] = 'Final Report Received';
            $usr_noti['description'] = 'Final Report Received for Request ID HSW'.$id;
            $usr_noti['ref_id'] = auth()->user()->id;
            $usr_noti['ref_link'] = '/customer/survey_report/'.$id.'/27';
            $usr_noti['viewed'] = 0;
            $usr_noti['created_at'] = date('Y-m-d H:i:s');
            $usr_noti['updated_at'] = date('Y-m-d H:i:s');
            $usr_noti['deleted_at'] = date('Y-m-d H:i:s');

            UserNotification::create($usr_noti);

            $from       = auth()->user()->id; 
            $utype      = 7;
            $to         = Admin::where('role_id',7)->where('is_deleted',0)->where('is_active',1)->first()->id;
            $ntype      = 'final_report_verified_by_ch';
            $title      = 'CH Verified Final Report';
            $desc       = 'Final Report Verified by CH. Request ID:HSW'.$id;
            $refId      = $id;
            $reflink    = '/admin/repository-management-detail/'.$id.'/27/';
            $notify     = 'admin';
            $notify_from_role_id = 1;
            addNotification($from,$utype,$to,$ntype,$title,$desc,$refId,$reflink,$notify,$notify_from_role_id);

            $data['id'] = $id;
            $data['link'] = url('/customer/survey_report/'.$id.'/27');

            // $var = Mail::send('emails.report_received', $data, function($message) use($data,$cust_email) {
            //     $message->from(getadmin_mail(),'HSW');    
            //     $message->to($cust_email);
            //     $message->subject('Report Generated');
            // });

            if(isset($survey_request_log_id))
            {   
                Session::flash('message', ['text'=>'Final Report Verified Successfully !','type'=>'success']);  
            }
            else
            {
                Session::flash('message', ['text'=>'Final Report Not Verified Successfully !','type'=>'danger']);
            }

            return redirect('superadmin/requested_services');
        }
        else
        {
            return redirect()->back()->withErrors($validator)->withInput($request->all());
        }
    }

    public function reject_close(Request $request)    
    {
        $validator = Validator::make($request->all(), [
            'id'=>['required'],
            'reject_close_remarks'=>['required','regex:/^[a-zA-Z0-9\s.,@#&*()_\-\/=]*$/'],
        ]);

        if($validator->passes())
        {
            $id = $request->id;

            Survey_requests::where('id',$id)->update(['request_status'=>3]);

            $cust_id = survey_requests::where('id',$id)->first()->cust_id;
            $cust_email = CustomerMaster::where('id',$cust_id)->first()->username;

            $survey_request_logs = [];

            $survey_request_logs['survey_request_id'] = $id;
            $survey_request_logs['cust_id'] = $cust_id;
            $survey_request_logs['survey_status'] = 3;
            $survey_request_logs['remarks'] = $request->reject_close_remarks;
            $survey_request_logs['is_active'] = 1;
            $survey_request_logs['is_deleted'] = 0;
            $survey_request_logs['created_by'] = auth()->user()->id;
            $survey_request_logs['updated_by'] = auth()->user()->id;
            $survey_request_logs['created_at'] = date('Y-m-d H:i:s');
            $survey_request_logs['updated_at'] = date('Y-m-d H:i:s');

            $survey_request_log_id = Survey_request_logs::create($survey_request_logs)->id;

            $usr_noti = [];

            $usr_noti['notify_from'] = auth()->user()->id;
            $usr_noti['notify_to'] = $cust_id;
            $usr_noti['role_id'] = 6;
            $usr_noti['notify_from_role_id'] = 1;
            $usr_noti['notify_type'] = 0;
            $usr_noti['title'] = 'Request Rejected';
            $usr_noti['description'] = 'Survey Request Rejected for Request ID HSW'.$id;
            $usr_noti['ref_id'] = auth()->user()->id;
            $usr_noti['ref_link'] = '/customer/request_service_detail/'.$id.'/3';
            $usr_noti['viewed'] = 0;
            $usr_noti['created_at'] = date('Y-m-d H:i:s');
            $usr_noti['updated_at'] = date('Y-m-d H:i:s');
            $usr_noti['deleted_at'] = date('Y-m-d H:i:s');

            UserNotification::create($usr_noti);

            $data['id'] = $id;
            $data['remarks'] = $request->reject_close_remarks;
            
            // $var = Mail::send('emails.reject_closed', $data, function($message) use($data,$cust_email) {
            //     $message->from(getadmin_mail(),'HSW');    
            //     $message->to($cust_email);
            //     $message->subject('Request Reject Closed');
            // });

            if(isset($survey_request_log_id))
            {   
                Session::flash('message', ['text'=>'Survey Request Rejected Successfully !','type'=>'success']);  
            }
            else
            {
                Session::flash('message', ['text'=>'Survey Request Not Rejected Successfully !','type'=>'danger']);
            }

            return redirect('superadmin/new_service_requests');            
        }
        else
        {
            return redirect()->back()->withErrors($validator)->withInput($request->all());
        }
    }

    public function reject_open(Request $request)    
    {
        $validator = Validator::make($request->all(), [
            'id'=>['required'],
            'reject_open_remarks'=>['required','regex:/^[a-zA-Z0-9\s.,@#&*()_\-\/=]*$/'],
        ]);

        if($validator->passes())
        {
            $id = $request->id;

            Survey_requests::where('id',$id)->update(['request_status'=>4]);

            $cust_id = survey_requests::where('id',$id)->first()->cust_id;
            $cust_email = CustomerMaster::where('id',$cust_id)->first()->username;

            $survey_request_logs = [];

            $survey_request_logs['survey_request_id'] = $id;
            $survey_request_logs['cust_id'] = $cust_id;
            $survey_request_logs['survey_status'] = 4;
            $survey_request_logs['remarks'] = $request->reject_open_remarks;
            $survey_request_logs['is_active'] = 1;
            $survey_request_logs['is_deleted'] = 0;
            $survey_request_logs['created_by'] = auth()->user()->id;
            $survey_request_logs['updated_by'] = auth()->user()->id;
            $survey_request_logs['created_at'] = date('Y-m-d H:i:s');
            $survey_request_logs['updated_at'] = date('Y-m-d H:i:s');

            $survey_request_log_id = Survey_request_logs::create($survey_request_logs)->id;

            $usr_noti = [];

            $usr_noti['notify_from'] = auth()->user()->id;
            $usr_noti['notify_to'] = $cust_id;
            $usr_noti['role_id'] = 6;
            $usr_noti['notify_from_role_id'] = 1;
            $usr_noti['notify_type'] = 0;
            $usr_noti['title'] = 'Request Reject Open';
            $usr_noti['description'] = 'Survey Request Reject Open for Request ID HSW'.$id;
            $usr_noti['ref_id'] = auth()->user()->id;
            $usr_noti['ref_link'] = '/customer/request_service_detail/'.$id.'/4';
            $usr_noti['viewed'] = 0;
            $usr_noti['created_at'] = date('Y-m-d H:i:s');
            $usr_noti['updated_at'] = date('Y-m-d H:i:s');
            $usr_noti['deleted_at'] = date('Y-m-d H:i:s');

            UserNotification::create($usr_noti);

            $data['id'] = $id;
            $data['remarks'] = $request->reject_open_remarks;
            $data['link'] = url('/customer/requested_services');
            
            // $var = Mail::send('emails.reject_open', $data, function($message) use($data,$cust_email) {
            //     $message->from(getadmin_mail(),'HSW');    
            //     $message->to($cust_email);
            //     $message->subject('Request Reject Open');
            // });

            if(isset($survey_request_log_id))
            {   
                Session::flash('message', ['text'=>'Survey Request Rejected Successfully !','type'=>'success']);  
            }
            else
            {
                Session::flash('message', ['text'=>'Survey Request Not Rejected Successfully !','type'=>'danger']);
            }

            return redirect('superadmin/new_service_requests');            
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
            'reject_field_remarks'=>['required','regex:/^[a-zA-Z0-9\s.,@#&*()_\-\/=]*$/'],
        ]);

        if($validator->passes())
        {           
            $cust_id = survey_requests::where('id',$input['id'])->first()->cust_id;
            $assigned_surveyor = survey_requests::where('id',$input['id'])->first()->assigned_surveyor;
            $assigned_user = survey_requests::where('id',$input['id'])->first()->assigned_user;

            if(isset($input['report']) && isset($input['eta']) && $input['report'] == 1 && $input['eta'] == 1)
            {
                $assign_arr['request_status'] = 33;
                $assign_arr['updated_by'] = auth()->user()->id;
                $assign_arr['updated_at'] = date('Y-m-d H:i:s');

                Survey_requests::where('id',$input['id'])->update($assign_arr);

                $survey_request_logs = [];

                $survey_request_logs['survey_request_id'] = $input['id'];
                $survey_request_logs['cust_id'] = $cust_id;
                $survey_request_logs['survey_status'] = 33;
                $survey_request_logs['remarks'] = $input['remarks'];
                $survey_request_logs['is_active'] = 1;
                $survey_request_logs['is_deleted'] = 0;
                $survey_request_logs['created_by'] = auth()->user()->id;
                $survey_request_logs['updated_by'] = auth()->user()->id;
                $survey_request_logs['created_at'] = date('Y-m-d H:i:s');
                $survey_request_logs['updated_at'] = date('Y-m-d H:i:s');

                $survey_request_log_id = Survey_request_logs::create($survey_request_logs)->id;

                $survey_request_logs['survey_request_id'] = $input['id'];
                $survey_request_logs['cust_id'] = $cust_id;
                $survey_request_logs['survey_status'] = 67;
                $survey_request_logs['remarks'] = $input['reject_field_remarks'];
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
                $notify_from_role_id = 1;
                addNotification($from,$utype,$to,$ntype,$title,$desc,$refId,$reflink,$notify,$notify_from_role_id);

                if(isset($survey_request_log_id))
                {   
                    Session::flash('message', ['text'=>'Field Study Report Rejected Successfully !','type'=>'success']);  
                }
                else
                {
                    Session::flash('message', ['text'=>'Field Study Report Not Rejected Successfully !','type'=>'danger']);
                }

                return redirect('/superadmin/requested_services');

            }
            elseif(isset($input['report']) && $input['report'] == 1)
            {
                $assign_arr['request_status'] = 33;
                $assign_arr['updated_by'] = auth()->user()->id;
                $assign_arr['updated_at'] = date('Y-m-d H:i:s');

                Survey_requests::where('id',$input['id'])->update($assign_arr);

                $survey_request_logs = [];

                $survey_request_logs['survey_request_id'] = $input['id'];
                $survey_request_logs['cust_id'] = $cust_id;
                $survey_request_logs['survey_status'] = 33;
                $survey_request_logs['remarks'] = $input['reject_field_remarks'];
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
                $notify_from_role_id = 1;
                addNotification($from,$utype,$to,$ntype,$title,$desc,$refId,$reflink,$notify,$notify_from_role_id);

                if(isset($survey_request_log_id))
                {   
                    Session::flash('message', ['text'=>'Field Study Report Rejected Successfully !','type'=>'success']);  
                }
                else
                {
                    Session::flash('message', ['text'=>'Field Study Report Not Rejected Successfully !','type'=>'danger']);
                }

                return redirect('/superadmin/requested_services');
            }
            elseif(isset($input['eta']) && $input['eta'] == 1)
            {
                $assign_arr['request_status'] = 67;
                $assign_arr['updated_by'] = auth()->user()->id;
                $assign_arr['updated_at'] = date('Y-m-d H:i:s');

                Survey_requests::where('id',$input['id'])->update($assign_arr);

                $survey_request_logs = [];

                $survey_request_logs['survey_request_id'] = $input['id'];
                $survey_request_logs['cust_id'] = $cust_id;
                $survey_request_logs['survey_status'] = 67;
                $survey_request_logs['remarks'] = $input['reject_field_remarks'];
                $survey_request_logs['is_active'] = 1;
                $survey_request_logs['is_deleted'] = 0;
                $survey_request_logs['created_by'] = auth()->user()->id;
                $survey_request_logs['updated_by'] = auth()->user()->id;
                $survey_request_logs['created_at'] = date('Y-m-d H:i:s');
                $survey_request_logs['updated_at'] = date('Y-m-d H:i:s');

                $survey_request_log_id = Survey_request_logs::create($survey_request_logs)->id;

                $from       = auth()->user()->id;
                $utype      = 2;
                $to         = $assigned_user; 
                $ntype      = 'rejected_eta';
                $title      = 'ETA Rejected';
                $desc       = 'ETA Rejected. Request ID: HSW'.$input['id'];
                $refId      = $input['id'];
                $reflink    = '/admin/requested_service_detail/'.$input['id'].'/67/';
                $notify     = 'admin';
                $notify_from_role_id = 1;
                addNotification($from,$utype,$to,$ntype,$title,$desc,$refId,$reflink,$notify,$notify_from_role_id); 



                if(isset($survey_request_log_id))
                {   
                    Session::flash('message', ['text'=>'Field Study ETA Rejected Successfully !','type'=>'success']);  
                }
                else
                {
                    Session::flash('message', ['text'=>'Field Study ETA Not Rejected Successfully !','type'=>'danger']);
                }

                return redirect('/superadmin/requested_services');
            }
            else
            {
                Session::flash('message', ['text'=>'Select Checkbox to Reject !','type'=>'danger']);

                return redirect('/superadmin/requested_services');
            }
            
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
            'reject_remarks'=>['required','regex:/^[a-zA-Z0-9\s.,@#&*()_\-\/=]*$/'],
        ]);

        if($validator->passes())
        {
            $cust_id = survey_requests::where('id',$input['id'])->first()->cust_id;
            $assigned_surveyor = survey_requests::where('id',$input['id'])->first()->assigned_surveyor_survey;

            $assign_arr['request_status'] = 37;
            $assign_arr['updated_by'] = auth()->user()->id;
            $assign_arr['updated_at'] = date('Y-m-d H:i:s');

            Survey_requests::where('id',$input['id'])->update($assign_arr);

            $survey_request_logs = [];

            $survey_request_logs['survey_request_id'] = $input['id'];
            $survey_request_logs['cust_id'] = $cust_id;
            $survey_request_logs['survey_status'] = 37;
            $survey_request_logs['remarks'] = $input['reject_remarks'];
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
            $notify_from_role_id = 1;
            addNotification($from,$utype,$to,$ntype,$title,$desc,$refId,$reflink,$notify,$notify_from_role_id);

            if(isset($survey_request_log_id))
            {   
                Session::flash('message', ['text'=>'Survey Study Report Rejected Successfully !','type'=>'success']);  
            }
            else
            {
                Session::flash('message', ['text'=>'Survey Study Report Not Rejected Successfully !','type'=>'danger']);
            }

            return redirect('/superadmin/requested_services');
        }
        else
        {
            return redirect()->back()->withErrors($validator)->withInput($request->all());
        }
    }

    public function reject_performa_invoice(Request $request)
    {
        $input = $request->all();

        $validator = Validator::make($request->all(), [
            'id'=>['required'],
            'reject_remarks'=>['required','regex:/^[a-zA-Z0-9\s.,@#&*()_\-\/=]*$/'],
        ]);

        if($validator->passes())
        {
            $cust_id = survey_requests::where('id',$input['id'])->first()->cust_id;

            $assign_arr['request_status'] = 35;
            $assign_arr['updated_by'] = auth()->user()->id;
            $assign_arr['updated_at'] = date('Y-m-d H:i:s');

            Survey_requests::where('id',$input['id'])->update($assign_arr);

            $survey_request_logs = [];

            $survey_request_logs['survey_request_id'] = $input['id'];
            $survey_request_logs['cust_id'] = $cust_id;
            $survey_request_logs['survey_status'] = 35;
            $survey_request_logs['remarks'] = $input['reject_remarks'];
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
            $title      = 'Performa Invoice Rejected by CH';
            $desc       = 'Performa Invoice Rejected by CH. Request ID:HSW'.$input['id'];
            $refId      =$input['id'];
            $reflink    = '/draftsman/service_requests_detail/'.$input['id'].'/35/';
            $notify     = 'draftsman';
            $notify_from_role_id = 1;
            addNotification($from,$utype,$to,$ntype,$title,$desc,$refId,$reflink,$notify,$notify_from_role_id);

            if(isset($survey_request_log_id))
            {   
                Session::flash('message', ['text'=>'Performa Invoice Rejected Successfully !','type'=>'success']);  
            }
            else
            {
                Session::flash('message', ['text'=>'Performa Invoice Not Rejected Successfully !','type'=>'danger']);
            }

            return redirect('/superadmin/requested_services');
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
            'reject_remarks'=>['required','regex:/^[a-zA-Z0-9\s.,@#&*()_\-\/=]*$/'],
        ]);

        if($validator->passes())
        {
            $cust_id = survey_requests::where('id',$input['id'])->first()->cust_id;

            $assign_arr['request_status'] = 53;
            $assign_arr['updated_by'] = auth()->user()->id;
            $assign_arr['updated_at'] = date('Y-m-d H:i:s');

            Survey_requests::where('id',$input['id'])->update($assign_arr);

            $survey_request_logs = [];

            $survey_request_logs['survey_request_id'] = $input['id'];
            $survey_request_logs['cust_id'] = $cust_id;
            $survey_request_logs['survey_status'] = 53;
            $survey_request_logs['remarks'] = $input['reject_remarks'];
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
            $title      = 'Invoice Rejected by CH';
            $desc       = 'Invoice Rejected by CH. Request ID:HSW'.$input['id'];
            $refId      =$input['id'];
            $reflink    = '/draftsman/service_requests_detail/'.$input['id'].'/53/';
            $notify     = 'draftsman';
            $notify_from_role_id = 1;
            addNotification($from,$utype,$to,$ntype,$title,$desc,$refId,$reflink,$notify,$notify_from_role_id);

            if(isset($survey_request_log_id))
            {   
                Session::flash('message', ['text'=>'Invoice Rejected Successfully !','type'=>'success']);  
            }
            else
            {
                Session::flash('message', ['text'=>'Invoice Not Rejected Successfully !','type'=>'danger']);
            }

            return redirect('/superadmin/requested_services');
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
            'reject_remarks'=>['required','regex:/^[a-zA-Z0-9\s.,@#&*()_\-\/=]*$/'],
        ]);

        if($validator->passes())
        {
            $cust_id = survey_requests::where('id',$input['id'])->first()->cust_id;
             $assigned_user = survey_requests::where('id',$input['id'])->first()->assigned_user;
             $assigned_draftsman_final = survey_requests::where('id',$input['id'])->first()->assigned_draftsman_final;
            $assign_arr['request_status'] = 39;
            $assign_arr['updated_by'] = auth()->user()->id;
            $assign_arr['updated_at'] = date('Y-m-d H:i:s');

            Survey_requests::where('id',$input['id'])->update($assign_arr);

            $survey_request_logs = [];

            $survey_request_logs['survey_request_id'] = $input['id'];
            $survey_request_logs['cust_id'] = $cust_id;
            $survey_request_logs['survey_status'] = 39;
            $survey_request_logs['remarks'] = $input['reject_remarks'];
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
                $title      = 'Final Report Rejected by CH';
                $desc       = 'Final Report Rejected by CH. Request ID: HSW'.$input['id'];
                $refId      = $input['id'];
                $reflink    = '/draftsman/service_requests_detail/'.$input['id'].'/39/';
                $notify     = 'draftsman';
                $notify_from_role_id = 1;
                addNotification($from,$utype,$to,$ntype,$title,$desc,$refId,$reflink,$notify,$notify_from_role_id); 


                $from       = auth()->user()->id;
                $utype      = 2;
                $to         = $assigned_user;
                $ntype      = 'final_report_rejected';
                $title      = 'Final Report Rejected by CH';
                $desc       = 'Final Report Rejected by CH. Request ID: HSW'.$input['id'];
                $refId      = $input['id'];
                $reflink    = '/admin/requested_service_detail/'.$input['id'].'/39/';
                $notify     = 'admin';
                $notify_from_role_id = 1;
                addNotification($from,$utype,$to,$ntype,$title,$desc,$refId,$reflink,$notify,$notify_from_role_id); 

            if(isset($survey_request_log_id))
            {   
                Session::flash('message', ['text'=>'Final Survey Report Rejected Successfully !','type'=>'success']);  
            }
            else
            {
                Session::flash('message', ['text'=>'Final Survey Report Not Rejected Successfully !','type'=>'danger']);
            }

            return redirect('/superadmin/requested_services');
        }
        else
        {
            return redirect()->back()->withErrors($validator)->withInput($request->all());
        }
    }

    public function getAdmin(Request $request)
    {
        $input = $request->all();

        $data['admins'] = UserManagement::where('institution',$input['institution_id'])->where('role',2)->where('is_deleted',0)->where('is_active',1)->get();

        // dd($data);
        return view('superadmin.admins',$data);
    }
}