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
use App\Models\Survey_invoice;
use App\Models\Survey_status;
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
        $data['survey_requests']    =   DB::table('survey_requests')
                                        ->leftjoin('cust_mst', 'survey_requests.cust_id', '=', 'cust_mst.id')
                                        ->leftjoin('cust_info', 'survey_requests.cust_id', '=', 'cust_info.cust_id')
                                        ->leftjoin('cust_telecom', 'survey_requests.cust_id', '=', 'cust_telecom.cust_id')
                                        ->leftjoin('services', 'survey_requests.service_id', '=', 'services.id')
                                        ->where('survey_requests.request_status',1)->Where('survey_requests.is_deleted',0)
                                        ->where('cust_mst.is_deleted',0)
                                        ->where('cust_telecom.is_deleted',0)->where('cust_telecom.telecom_type',2)
                                        ->select('survey_requests.id AS survey_id','survey_requests.created_at AS survey_date','survey_requests.*','cust_mst.*','cust_info.*', 'cust_telecom.*','services.*')
                                        ->orderBy('survey_requests.id','DESC')
                                        ->get();

        return view('superadmin.requested_services.new_service_requests',$data);
    }

    public function new_service_request_detail($id)
    {
        $data['title']       =   'New Service Request';
        $data['menu']        =   'new-service-request';

        $datas = Survey_requests::where('id',$id)->first();

        $data['service'] = Services::where('id',$datas->service_id)->first()->service_name;

        $data['survey_id'] = $id;

        $data['institutions'] = Institution::where('is_deleted',0)->where('is_active',1) ->get();

        $data['admins'] = Admin::where('role_id',2)->get();

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

        $data['state_name'] = State::where('id',$data['request_data']['state'])->first()->state_name;
        $data['district_name'] = City::where('id',$data['request_data']['district'])->first()->city_name;

        // dd($data);

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

        return view('superadmin.requested_services.new_service_request_detail',$data);
    }

    public function assign_survey(Request $request)
    {
        $input = $request->all();

        $validator = Validator::make($request->all(), [
            'id'=>['required'],
            'assigned_institution'=>['required'],
            'assigned_user'=>['required'],
        ]);

        if($validator->passes())
        {
            $cust_id = survey_requests::where('id',$input['id'])->first()->cust_id;

            $assign_arr['request_status'] = 2;
            $assign_arr['assigned_institution'] = $input['assigned_institution'];
            $assign_arr['assigned_user'] = $input['assigned_user'];
            $assign_arr['updated_by'] = auth()->user()->id;
            $assign_arr['updated_at'] = date('Y-m-d H:i:s');

            Survey_requests::where('id',$input['id'])->update($assign_arr);

            $survey_request_logs = [];

            $survey_request_logs['survey_request_id'] = $input['id'];
            $survey_request_logs['cust_id'] = $cust_id;
            $survey_request_logs['survey_status'] = 2;
            $survey_request_logs['is_active'] = 1;
            $survey_request_logs['is_deleted'] = 0;
            $survey_request_logs['created_by'] = auth()->user()->id;
            $survey_request_logs['updated_by'] = auth()->user()->id;
            $survey_request_logs['created_at'] = date('Y-m-d H:i:s');
            $survey_request_logs['updated_at'] = date('Y-m-d H:i:s');

            Survey_request_logs::create($survey_request_logs);

            return redirect('/superadmin/new_service_requests');
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
        $data['survey_requests']    =   DB::table('survey_requests')
                                        ->leftjoin('cust_mst', 'survey_requests.cust_id', '=', 'cust_mst.id')
                                        ->leftjoin('cust_info', 'survey_requests.cust_id', '=', 'cust_info.cust_id')
                                        ->leftjoin('cust_telecom', 'survey_requests.cust_id', '=', 'cust_telecom.cust_id')
                                        ->leftjoin('services', 'survey_requests.service_id', '=', 'services.id')
                                        ->leftjoin('institution', 'survey_requests.assigned_institution', '=', 'institution.id')
                                        ->leftjoin('survey_status', 'survey_requests.request_status', '=', 'survey_status.id')
                                        ->where('survey_requests.request_status','!=',1)->where('survey_requests.request_status','!=',NULL)->Where('survey_requests.is_deleted',0)
                                        ->where('cust_mst.is_deleted',0)
                                        ->where('cust_telecom.is_deleted',0)->where('cust_telecom.telecom_type',2)
                                        ->select('survey_requests.id AS survey_id','survey_requests.created_at AS survey_date','survey_requests.*','cust_mst.*','cust_info.*', 'cust_telecom.*','services.*','institution.*','survey_status.status_name AS current_status')
                                        ->orderBy('survey_requests.id','DESC')
                                        ->get();

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

        $data['state_name'] = State::where('id',$data['request_data']['state'])->first()->state_name;
        $data['district_name'] = City::where('id',$data['request_data']['district'])->first()->city_name;

        // dd($data);

        if($status == 17)
        {
            $data['draftmans'] = Admin::where('role_id',4)->get();
            $data['field_study'] = Field_study_report::where('survey_request_id',$id)->first();

            // dd($data);
            return view('superadmin.requested_services.dh_verified_survey_study',$data);
        }
        elseif($status == 14)
        {
            $data['field_study'] = Field_study_report::where('survey_request_id',$id)->first();
            $data['survey_invoice'] = Survey_invoice::where('survey_request_id',$id)->first();

            // dd($data);
            return view('superadmin.requested_services.customer_payment_verified',$data);
        }
        elseif($status == 12)
        {
            $data['field_study'] = Field_study_report::where('survey_request_id',$id)->first();
            $data['survey_invoice'] = Survey_invoice::where('survey_request_id',$id)->first();

            // dd($data);
            return view('superadmin.requested_services.dh_verified_invoice',$data);
        }
        elseif($status == 8)
        {
            $data['draftmans'] = Admin::where('role_id',4)->get();
            $data['field_study'] = Field_study_report::where('survey_request_id',$id)->first();

            return view('superadmin.requested_services.dh_verified_field_study',$data);
        }
        elseif($status == 7)
        {
            $data['field_study'] = Field_study_report::where('survey_request_id',$id)->first();
            
            return view('superadmin.requested_services.eta_received',$data);
        }
        else
        {
            // dd($data);
            return view('superadmin.requested_services.requested_services_details',$data);
        }
    }

    public function verify_field_study($id)
    {
        Survey_requests::where('id',$id)->update(['request_status'=>8]);

        $cust_id = survey_requests::where('id',$id)->first()->cust_id;

        $survey_request_logs = [];

        $survey_request_logs['survey_request_id'] = $id;
        $survey_request_logs['cust_id'] = $cust_id;
        $survey_request_logs['survey_status'] = 13;
        $survey_request_logs['is_active'] = 1;
        $survey_request_logs['is_deleted'] = 0;
        $survey_request_logs['created_by'] = auth()->user()->id;
        $survey_request_logs['updated_by'] = auth()->user()->id;
        $survey_request_logs['created_at'] = date('Y-m-d H:i:s');
        $survey_request_logs['updated_at'] = date('Y-m-d H:i:s');

        Survey_request_logs::create($survey_request_logs);

        return redirect('superadmin/requested_services');
    }

    public function assign_draftsman(Request $request)
    {
        $input = $request->all();

        // dd($input);

        $validator = Validator::make($request->all(), [
            'id'=>['required'],
            'draftsman'=>['required']
        ]);

        if($validator->passes())
        {
            $cust_id = survey_requests::where('id',$input['id'])->first()->cust_id;

            $assign_arr['request_status'] = 9;
            $assign_arr['assigned_draftsman'] = $input['draftsman'];
            $assign_arr['updated_by'] = auth()->user()->id;
            $assign_arr['updated_at'] = date('Y-m-d H:i:s');

            Survey_requests::where('id',$input['id'])->update($assign_arr);

            $survey_request_logs = [];

            $survey_request_logs['survey_request_id'] = $input['id'];
            $survey_request_logs['cust_id'] = $cust_id;
            $survey_request_logs['survey_status'] = 9;
            $survey_request_logs['is_active'] = 1;
            $survey_request_logs['is_deleted'] = 0;
            $survey_request_logs['created_by'] = auth()->user()->id;
            $survey_request_logs['updated_by'] = auth()->user()->id;
            $survey_request_logs['created_at'] = date('Y-m-d H:i:s');
            $survey_request_logs['updated_at'] = date('Y-m-d H:i:s');

            Survey_request_logs::create($survey_request_logs);

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

        // dd($input);

        $validator = Validator::make($request->all(), [
            'id'=>['required'],
            'assigned_survey_institution'=>['required'],
            'assigned_survey_user'=>['required'],
        ]);

        if($validator->passes())
        {
            $cust_id = survey_requests::where('id',$input['id'])->first()->cust_id;

            $assign_arr['request_status'] = 16;
            $assign_arr['assigned_survey_institution'] = $input['assigned_survey_institution'];
            $assign_arr['assigned_survey_user'] = $input['assigned_survey_user'];
            $assign_arr['updated_by'] = auth()->user()->id;
            $assign_arr['updated_at'] = date('Y-m-d H:i:s');

            Survey_requests::where('id',$input['id'])->update($assign_arr);

            $survey_request_logs = [];

            $survey_request_logs['survey_request_id'] = $input['id'];
            $survey_request_logs['cust_id'] = $cust_id;
            $survey_request_logs['survey_status'] = 16;
            $survey_request_logs['is_active'] = 1;
            $survey_request_logs['is_deleted'] = 0;
            $survey_request_logs['created_by'] = auth()->user()->id;
            $survey_request_logs['updated_by'] = auth()->user()->id;
            $survey_request_logs['created_at'] = date('Y-m-d H:i:s');
            $survey_request_logs['updated_at'] = date('Y-m-d H:i:s');

            Survey_request_logs::create($survey_request_logs);

            return redirect('/superadmin/requested_services');
        }
        else
        {
            return redirect()->back()->withErrors($validator)->withInput($request->all());
        }
    }

    public function send_invoice_customer($id)
    {
        $cust_id = survey_requests::where('id',$id)->first()->cust_id;

        Survey_requests::where('id',$id)->update(['request_status'=>13]);

        $survey_request_logs = [];

        $survey_request_logs['survey_request_id'] = $id;
        $survey_request_logs['cust_id'] = $cust_id;
        $survey_request_logs['survey_status'] = 13;
        $survey_request_logs['is_active'] = 1;
        $survey_request_logs['is_deleted'] = 0;
        $survey_request_logs['created_by'] = auth()->user()->id;
        $survey_request_logs['updated_by'] = auth()->user()->id;
        $survey_request_logs['created_at'] = date('Y-m-d H:i:s');
        $survey_request_logs['updated_at'] = date('Y-m-d H:i:s');

        Survey_request_logs::create($survey_request_logs);

        return redirect('superadmin/requested_services');
    }

    public function assign_draftsman_final(Request $request)
    {
        $input = $request->all();

        // dd($input);

        $validator = Validator::make($request->all(), [
            'id'=>['required'],
            'final_draftsman'=>['required']
        ]);

        if($validator->passes())
        {
            $cust_id = survey_requests::where('id',$input['id'])->first()->cust_id;

            $assign_arr['request_status'] = 18;
            $assign_arr['assigned_draftsman_final'] = $input['final_draftsman'];
            $assign_arr['updated_by'] = auth()->user()->id;
            $assign_arr['updated_at'] = date('Y-m-d H:i:s');

            Survey_requests::where('id',$input['id'])->update($assign_arr);

            $survey_request_logs = [];

            $survey_request_logs['survey_request_id'] = $input['id'];
            $survey_request_logs['cust_id'] = $cust_id;
            $survey_request_logs['survey_status'] = 18;
            $survey_request_logs['is_active'] = 1;
            $survey_request_logs['is_deleted'] = 0;
            $survey_request_logs['created_by'] = auth()->user()->id;
            $survey_request_logs['updated_by'] = auth()->user()->id;
            $survey_request_logs['created_at'] = date('Y-m-d H:i:s');
            $survey_request_logs['updated_at'] = date('Y-m-d H:i:s');

            Survey_request_logs::create($survey_request_logs);

            return redirect('/superadmin/requested_services');
        }
        else
        {
            return redirect()->back()->withErrors($validator)->withInput($request->all());
        }
    }
    
}