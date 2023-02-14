<?php

namespace App\Http\Controllers\Draftsman;

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
use App\Models\Fieldstudy_eta;
use App\Models\Survey_invoice;
use App\Models\Survey_performa_invoice;
use App\Models\Survey_study_report;
use App\Models\Survey_status;

use PDF;
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

    public function requested_services()
    { 
        $data['title']              =   'Requested Services';
        $data['menu']               =   'requested-services';

        $status_in                  =   array(10,12,34,35,46,48,52,53,23,28,38,39);

        $data['survey_requests']    =   DB::table('survey_requests')
                                        ->leftjoin('cust_mst', 'survey_requests.cust_id', '=', 'cust_mst.id')
                                        ->leftjoin('cust_info', 'survey_requests.cust_id', '=', 'cust_info.cust_id')
                                        ->leftjoin('cust_telecom', 'survey_requests.cust_id', '=', 'cust_telecom.cust_id')
                                        ->leftjoin('services', 'survey_requests.service_id', '=', 'services.id')
                                        ->leftjoin('institution', 'survey_requests.assigned_institution', '=', 'institution.id')
                                        ->leftjoin('survey_status', 'survey_requests.request_status', '=', 'survey_status.id')
                                        ->whereIn('survey_requests.request_status',$status_in)->where('survey_requests.request_status','!=',NULL)->Where('survey_requests.is_deleted',0)
                                        ->where(function ($query) { $query->where('survey_requests.assigned_draftsman',auth()->user()->id)->orWhere('survey_requests.assigned_draftsman_final',auth()->user()->id);})                                        
                                        ->where('cust_mst.is_deleted',0)
                                        ->where('cust_telecom.is_deleted',0)->where('cust_telecom.telecom_type',2)
                                        ->select('survey_requests.id AS survey_id','survey_requests.created_at AS survey_date','survey_requests.*','cust_mst.*','cust_info.*', 'cust_telecom.*','services.*','institution.*','survey_status.status_name AS current_status')
                                        ->orderBy('survey_requests.id','DESC')
                                        ->get();
                                        

        return view('draftsman.requested_services.services_requests',$data);
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

        $data['field_study'] = Field_study_report::where('survey_request_id',$id)->first();
        $data['field_study_eta'] = Fieldstudy_eta::where('survey_request_id',$id)->first();

        $data['survey_study'] = Survey_study_report::where('survey_request_id',$id)->first();
        
        // dd($data);

        if($status == 23 || $status == 28 || $status == 38 || $status == 39)
        {
            return view('draftsman.requested_services.survey_report',$data);
        }
        elseif($status == 46)
        {
            $data['survey_remarks'] = Survey_request_logs::where('survey_request_id',$id)->where('survey_status',46)->first()->remarks;

            return view('draftsman.requested_services.assigned_draftsman_invoice',$data);
        }
        elseif($status == 10)
        {
            $data['survey_remarks'] = Survey_request_logs::where('survey_request_id',$id)->where('survey_status',10)->first()->remarks;
            
            return view('draftsman.requested_services.invoice',$data);
        }
    }

    public function create_performa_invoice($id)
    {
        $data['title'] = 'Create Performa Invoice';
        $data['survey_id'] = $id;

        $performa_invoice = Survey_performa_invoice::where('is_active',1)->where('is_deleted',0)->orderBy('id','DESC')->get();

        if($performa_invoice && count($performa_invoice)>0)
        {
            $last_invoice = DB::table('survey_performa_invoice')->where('is_active',1)->where('is_deleted',0)->orderBy('id', 'DESC')->first()->bill_invoice_no;

            if(isset($last_invoice) && $last_invoice > 0)
            {
                $data['bill_invoice_no'] = $last_invoice + 1;
            }
        }
        else
        {
            $data['bill_invoice_no'] = 1;
        }

        // dd($data);
        
        return view('draftsman.requested_services.create_performa_invoice',$data);
    }

    public function save_performa_invoice(Request $request)
    {
        $input = $request->all();

        // dd($input);

        $validator = Validator::make($request->all(), [
            'id'=>['required'],
            'bill_invoice_no'=>['required'],
            'invoice_date'=>['required'],
            'name_of_work'=>['required'],
            'work_orderno_date' => ['required'],
            'service_code'=>['required'],
            'service_description'=>['required'],
            'organization_name' =>['required'],
            'payment_mode' =>['required'],
            'receiver_name' =>['required'],
            'receiver_address' =>['required'],
            'state_code' =>['required'],
            'gstin_unique_id' =>['required'],
            'survey_charges' =>['required'],
            'cgst_percentage' =>['required'],
            'sgst_percentage' =>['required'],
            'cgst_amount' =>['required'],
            'sgst_amount' =>['required'],
            'total_tax_amount' =>['required'],
            'total_tax_amount_words' =>['required'],
            'total_invoice_amount' =>['required'],
            'total_invoice_amount_words' => ['required'],
            'remarks'=>['nullable']
        ]);

        if($validator->passes())
        {
            $cust_id = survey_requests::where('id',$input['id'])->first()->cust_id;
            
            Survey_performa_invoice::create([
                'survey_request_id' => $request->id,
                'bill_invoice_no' => $request->bill_invoice_no,
                'invoice_date' => date('Y-m-d',strtotime($request->invoice_date)),
                'name_of_work' => $request->name_of_work,
                'work_orderno_date' => $request->work_orderno_date,
                'service_code' => $request->service_code,
                'service_description' => $request->service_description,
                'organization_name' => $request->organization_name,
                'payment_mode' => $request->payment_mode,
                'receiver_name' => $request->receiver_name,
                'receiver_address' => $request->receiver_address,
                'state_code' => $request->state_code,
                'gstin_unique_id' => $request->gstin_unique_id,
                'survey_charges' => $request->survey_charges,
                'survey_charges_words' => $request->survey_charges_words,
                'cgst_percentage' => $request->cgst_percentage,
                'sgst_percentage' => $request->sgst_percentage,
                'cgst_amount' => $request->cgst_amount,
                'sgst_amount' => $request->sgst_amount,
                'total_tax_amount' => $request->total_tax_amount,
                'total_tax_amount_words' => $request->total_tax_amount_words,
                'total_invoice_amount' => $request->total_invoice_amount,
                'total_invoice_amount_words' => $request->total_invoice_amount_words,
                'is_active'=>1,
                'is_deleted'=>0,
                'created_by'=>auth()->user()->id,
                'updated_by'=>auth()->user()->id,
                'created_at'=>date("Y-m-d H:i:s"),
                'updated_at'=>date("Y-m-d H:i:s")
            ]);

            Survey_requests::where('id',$request->id)->update([
                'request_status' => 11,
                'updated_by' => auth()->user()->id,
                'updated_at'=>date("Y-m-d H:i:s")
            ]);

            $survey_request_logs = [];

            $survey_request_logs['survey_request_id'] = $input['id'];
            $survey_request_logs['cust_id'] = $cust_id;
            $survey_request_logs['survey_status'] = 11;
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
                Session::flash('message', ['text'=>'Performa Invoice Created Successfully !','type'=>'success']);  
            }
            else
            {
                Session::flash('message', ['text'=>'Performa Invoice Not Created Successfully !','type'=>'danger']);
            }

            return redirect('/draftsman/service_requests');
        }
        else
        {
            return redirect()->back()->withErrors($validator)->withInput($request->all());
        }
    }

    public function create_invoice($id)
    {
        $data['title'] = 'Create Invoice';
        $data['survey_id'] = $id;

        $performa_invoice = Survey_invoice::where('is_active',1)->where('is_deleted',0)->orderBy('id','DESC')->get();

        if($performa_invoice && count($performa_invoice)>0)
        {
            $last_invoice = DB::table('survey_invoice')->where('is_active',1)->where('is_deleted',0)->orderBy('id', 'DESC')->first()->bill_invoice_no;

            if(isset($last_invoice) && $last_invoice > 0)
            {
                $data['bill_invoice_no'] = $last_invoice + 1;
            }
        }
        else
        {
            $data['bill_invoice_no'] = 1;
        }

        // dd($data);
        
        return view('draftsman.requested_services.create_invoice',$data);
    }

    public function save_invoice(Request $request)
    {
        $input = $request->all();

        // dd($input);

        $validator = Validator::make($request->all(), [
            'id'=>['required'],
            'bill_invoice_no'=>['required'],
            'invoice_date'=>['required'],
            'name_of_work'=>['required'],
            'work_orderno_date' => ['required'],
            'service_code'=>['required'],
            'service_description'=>['required'],
            'organization_name' =>['required'],
            'payment_mode' =>['required'],
            'receiver_name' =>['required'],
            'receiver_address' =>['required'],
            'state_code' =>['required'],
            'gstin_unique_id' =>['required'],
            'survey_charges' =>['required'],
            'cgst_percentage' =>['required'],
            'sgst_percentage' =>['required'],
            'cgst_amount' =>['required'],
            'sgst_amount' =>['required'],
            'total_tax_amount' =>['required'],
            'total_tax_amount_words' =>['required'],
            'total_invoice_amount' =>['required'],
            'total_invoice_amount_words' => ['required'],
            'remarks' => ['nullable']
        ]);

        if($validator->passes())
        {
            $cust_id = survey_requests::where('id',$input['id'])->first()->cust_id;
            
            Survey_invoice::create([
                'survey_request_id' => $request->id,
                'bill_invoice_no' => $request->bill_invoice_no,
                'invoice_date' => date('Y-m-d',strtotime($request->invoice_date)),
                'name_of_work' => $request->name_of_work,
                'work_orderno_date' => $request->work_orderno_date,
                'service_code' => $request->service_code,
                'service_description' => $request->service_description,
                'organization_name' => $request->organization_name,
                'payment_mode' => $request->payment_mode,
                'receiver_name' => $request->receiver_name,
                'receiver_address' => $request->receiver_address,
                'state_code' => $request->state_code,
                'gstin_unique_id' => $request->gstin_unique_id,
                'survey_charges' => $request->survey_charges,
                'survey_charges_words' => $request->survey_charges_words,
                'cgst_percentage' => $request->cgst_percentage,
                'sgst_percentage' => $request->sgst_percentage,
                'cgst_amount' => $request->cgst_amount,
                'sgst_amount' => $request->sgst_amount,
                'total_tax_amount' => $request->total_tax_amount,
                'total_tax_amount_words' => $request->total_tax_amount_words,
                'total_invoice_amount' => $request->total_invoice_amount,
                'total_invoice_amount_words' => $request->total_invoice_amount_words,
                'is_active'=>1,
                'is_deleted'=>0,
                'created_by'=>auth()->user()->id,
                'updated_by'=>auth()->user()->id,
                'created_at'=>date("Y-m-d H:i:s"),
                'updated_at'=>date("Y-m-d H:i:s")
            ]);

            Survey_requests::where('id',$request->id)->update([
                'request_status' => 47,
                'updated_by' => auth()->user()->id,
                'updated_at'=>date("Y-m-d H:i:s")
            ]);

            $survey_request_logs = [];

            $survey_request_logs['survey_request_id'] = $input['id'];
            $survey_request_logs['cust_id'] = $cust_id;
            $survey_request_logs['survey_status'] = 47;
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
                Session::flash('message', ['text'=>'Invoice Created Successfully !','type'=>'success']);  
            }
            else
            {
                Session::flash('message', ['text'=>'Invoice Not Created Successfully !','type'=>'danger']);
            }

            return redirect('/draftsman/service_requests');
        }
        else
        {
            return redirect()->back()->withErrors($validator)->withInput($request->all());
        }
    }    

    public function download_report($id)
    {
        $data['survey_study'] = Survey_study_report::where('survey_request_id',$id)->first();

        // return view('draftsman.requested_services.download_report',$data);

        $pdf = PDF::loadView('draftsman.requested_services.download_report',$data);
        return $pdf->download('survey_report.pdf');
    }

    public function upload_final_report(Request $request)
    {
        $input = $request->all();

        $validator = Validator::make($request->all(), [
            'upload_report' => ['required','max:10000'],
            'remarks' => ['nullable']
        ]);

        if($validator->passes())
        {
            $cust_id = survey_requests::where('id',$input['id'])->first()->cust_id;

            if($request->hasfile('upload_report'))
            {
                $file = $request->upload_report;
                $folder_name = "uploads/final_report/" . date("Ym", time()) . '/'.date("d", time()).'/';

                $upload_path = base_path() . '/public/' . $folder_name;

                $extension = strtolower($file->getClientOriginalExtension());

                $filename = "final_report" . '_' . time() . '.' . $extension;

                $file->move($upload_path, $filename);

                $file_path = config('app.url') . "/public/$folder_name/$filename";

                Survey_requests::where('id',$input['id'])->update([
                    'request_status' => 24,
                    'final_report' => $file_path,
                    'updated_by'=>auth()->user()->id,
                    'updated_at'=>date("Y-m-d H:i:s")
                ]);

                $survey_request_logs = [];

                $survey_request_logs['survey_request_id'] = $input['id'];
                $survey_request_logs['cust_id'] = $cust_id;
                $survey_request_logs['survey_status'] = 24;
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
                    Session::flash('message', ['text'=>'Final Report Submitted Successfully !','type'=>'success']);  
                }
                else
                {
                    Session::flash('message', ['text'=>'Final Report Not Submitted Successfully !','type'=>'danger']);
                }
            }
            return redirect('/draftsman/service_requests');
        }
        else
        {
            return redirect()->back()->withErrors($validator)->withInput($request->all());
        }       
    }
}