<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\ImageManagerStatic as Image;
use Mail;
use Session;
use DB;
use App\Models\Country;
use App\Models\State;
use App\Models\Admin;
use App\Models\Bathymetry_survey;
use App\Models\City;
use App\Models\customer\CustomerMaster;
use App\Models\UserVisit;
use App\Models\Bottom_sample_collection;
use App\Models\Currentmeter_observation;
use App\Models\Services;
use App\Models\Survey_requests;
use App\Models\Survey_request_logs;
use App\Models\Cust_receipt;
use App\Models\Dredging_survey;
use App\Models\Hydrographic_chart;
use App\Models\Hydrographic_survey;
use App\Models\Survey_status;
use App\Models\OrganisationType;
use App\Models\Sidescansonar;
use App\Models\Subbottom_profilling;
use App\Models\Tidal_observation;
use App\Models\Topographic_survey;
use App\Models\Underwater_videography;
use App\Models\DataCollectionEquipment;
use App\Rules\Name;
use PDF;
use Validator;

class RequestedServicesController extends Controller
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
        $data['title']        =  'Requested Services';
        $data['menu']         =  'Requested Services';

        $cust_email = Admin::where('id',auth()->user()->id)->first()->email;
        $cust_id = CustomerMaster::where('username',$cust_email)->first()->id;

        $data['requested_services']  =  DB::table('survey_requests')
                                        ->leftjoin('services', 'survey_requests.service_id', '=', 'services.id')
                                        ->leftjoin('survey_status', 'survey_requests.request_status', '=', 'survey_status.id')
                                        ->where('survey_requests.cust_id',$cust_id)->where('survey_requests.is_active',1)->where('survey_requests.is_deleted',0)
                                        ->where('services.is_active',1)->where('services.is_deleted',0)
                                        ->select('survey_requests.id AS survey_id','survey_requests.created_at AS survey_date','survey_requests.*','services.*','survey_status.status_name AS current_status')
                                        ->orderBy('survey_requests.id','DESC')
                                        ->get();

        // dd($data);

        return view('customer.requested_service.request_service_list',$data);
    }

    public function request_service_detail($id,$status)
    {
        $data['title']        =  'Requested Service Details';
        $data['menu']         =  'Requested Services Details';

        $request_not = array(1,2);

        $cust_email = Admin::where('id',auth()->user()->id)->first()->email;
        $cust_id = CustomerMaster::where('username',$cust_email)->first()->id;

        $data['survey_datas'] = DB::table('survey_request_logs')
                                ->leftjoin('survey_status', 'survey_request_logs.survey_status', '=', 'survey_status.id')
                                ->leftjoin('survey_requests', 'survey_request_logs.survey_request_id', '=', 'survey_requests.id')
                                ->where('survey_request_logs.cust_id',$cust_id)->where('survey_request_logs.survey_request_id',$id)->where('survey_request_logs.is_active',1)->where('survey_request_logs.is_deleted',0)
                                ->select('survey_request_logs.created_at AS log_date','survey_request_logs.*','survey_status.*','survey_requests.*')
                                ->orderBy('survey_request_logs.id','DESC')
                                ->get();

        $service_id = Survey_requests::where('id',$id)->first()->service_id;

        $service_request_id = Survey_requests::where('id',$id)->first()->service_request_id;

        $data['service'] = Services::where('id',$service_id)->first()->service_name;
        
        $data['id'] = $id;
        $data['status'] = Survey_status::where('id',$status)->first()->status_name;

        $data['service_id'] = $service_id;
        $data['service_request_id'] = $service_request_id;
        
        if($status == 3)
        {
            $data['remarks'] = Survey_request_logs::where('survey_request_id',$id)->where('survey_status',$status)->first()->remarks;

            return view('customer.requested_service.request_rejected',$data);
        }
        elseif($status == 4)
        {
            $data['remarks'] = Survey_request_logs::where('survey_request_id',$id)->where('survey_status',$status)->first()->remarks;

            // dd($data);

            return view('customer.requested_service.request_rejected_open',$data);
        }
        else
        {
            return view('customer.requested_service.request_service_detail',$data);
        }        
    }

    public function request_service_performa_invoice($id)
    {
        $data['title']        =  'Requested Service Performa Invoice';
        $data['menu']         =  'requested-service-performa-invoice';

        $data['survey_data']    =   DB::table('survey_requests')
                                    ->leftjoin('cust_mst', 'survey_requests.cust_id', '=', 'cust_mst.id')
                                    ->leftjoin('cust_info', 'survey_requests.cust_id', '=', 'cust_info.cust_id')
                                    ->leftjoin('cust_telecom', 'survey_requests.cust_id', '=', 'cust_telecom.cust_id')
                                    ->leftjoin('services', 'survey_requests.service_id', '=', 'services.id')
                                    ->leftjoin('survey_performa_invoice', 'survey_requests.id', '=', 'survey_performa_invoice.survey_request_id')
                                    ->where('survey_requests.id',$id)->Where('survey_requests.is_deleted',0)
                                    ->where('cust_mst.is_deleted',0)
                                    ->where('cust_telecom.is_deleted',0)->where('cust_telecom.telecom_type',2)
                                    ->select('survey_requests.id AS survey_id','survey_requests.created_at AS survey_date','survey_requests.*','cust_mst.*','cust_info.*', 'cust_telecom.*','services.*','survey_performa_invoice.*')
                                    ->orderBy('survey_requests.id','DESC')
                                    ->first();

        // dd($data);

        return view('customer.requested_service.performa_invoice_received',$data);
        // return view('customer.requested_service.request_service_invoice',$data);
    }

    public function performa_invoice_remarks(Request $request)
    {
        $id = $request->id;
        Survey_requests::where('id',$id)->update(['request_status'=>54]);

        $cust_id = survey_requests::where('id',$id)->first()->cust_id;

        $survey_request_logs = [];

        $survey_request_logs['survey_request_id'] = $id;
        $survey_request_logs['cust_id'] = $cust_id;
        $survey_request_logs['survey_status'] = 54;
        $survey_request_logs['remarks'] = $request->performa_remarks;
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
            $ntype      = 'performa_invice_accepted';
            $title      = 'Customer Accepted Performa Invoice';
            $desc       = 'Customer Accepted Performa Invoice. Request ID:HSW'.$id;
            $refId      = $id;
            $reflink    =  '/superadmin/requested_service_detail/'.$id.'/54/';
            $notify     = 'superadmin';
            $notify_from_role_id = 6;
            addNotification($from,$utype,$to,$ntype,$title,$desc,$refId,$reflink,$notify,$notify_from_role_id);


        if(isset($survey_request_log_id))
        {   
            Session::flash('message', ['text'=>'Performa Invoice Accepted Successfully !','type'=>'success']);  
        }
        else
        {
            Session::flash('message', ['text'=>'Performa Invoice Not Accepted Successfully !','type'=>'danger']);
        }

        return redirect('customer/requested_services');
    }

    public function performa_invoice_reject(Request $request)
    {
        $input = $request->all();

        $id = $request->id;
        Survey_requests::where('id',$id)->update(['request_status'=>29]);

        $cust_id = survey_requests::where('id',$id)->first()->cust_id;

        $survey_request_logs = [];

        $survey_request_logs['survey_request_id'] = $id;
        $survey_request_logs['cust_id'] = $cust_id;
        $survey_request_logs['survey_status'] = 55;
        $survey_request_logs['remarks'] = $request->performa_remarks;
        $survey_request_logs['is_active'] = 1;
        $survey_request_logs['is_deleted'] = 0;
        $survey_request_logs['created_by'] = auth()->user()->id;
        $survey_request_logs['updated_by'] = auth()->user()->id;
        $survey_request_logs['created_at'] = date('Y-m-d H:i:s');
        $survey_request_logs['updated_at'] = date('Y-m-d H:i:s');

        $survey_request_log_id = Survey_request_logs::create($survey_request_logs)->id;

        $survey_request_logs['survey_request_id'] = $id;
        $survey_request_logs['cust_id'] = $cust_id;
        $survey_request_logs['survey_status'] = 29;
        $survey_request_logs['remarks'] = $request->performa_remarks;
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
            $ntype      = 'performa_invice_accepted';
            $title      = 'Customer Rejected Performa Invoice';
            $desc       = 'Customer Rejected Performa Invoice. Request ID:HSW'.$id;
            $refId      = $id;
            $reflink    =  '/superadmin/requested_service_detail/'.$id.'/55/';
            $notify     = 'superadmin';
            $notify_from_role_id = 6;
            addNotification($from,$utype,$to,$ntype,$title,$desc,$refId,$reflink,$notify,$notify_from_role_id);


        if(isset($survey_request_log_id))
        {   
            Session::flash('message', ['text'=>'Performa Invoice Rejected Successfully !','type'=>'success']);  
        }
        else
        {
            Session::flash('message', ['text'=>'Performa Invoice Not Rejected Successfully !','type'=>'danger']);
        }

        return redirect('customer/requested_services');
    }

    public function request_service_invoice($id)
    {
        $data['title']        =  'Requested Service Invoice';
        $data['menu']         =  'requested-service-invoice';

        $data['survey_data']    =   DB::table('survey_requests')
                                    ->leftjoin('cust_mst', 'survey_requests.cust_id', '=', 'cust_mst.id')
                                    ->leftjoin('cust_info', 'survey_requests.cust_id', '=', 'cust_info.cust_id')
                                    ->leftjoin('cust_telecom', 'survey_requests.cust_id', '=', 'cust_telecom.cust_id')
                                    ->leftjoin('services', 'survey_requests.service_id', '=', 'services.id')
                                    ->leftjoin('survey_invoice', 'survey_requests.id', '=', 'survey_invoice.survey_request_id')
                                    ->where('survey_requests.id',$id)->Where('survey_requests.is_deleted',0)
                                    ->where('cust_mst.is_deleted',0)
                                    ->where('cust_telecom.is_deleted',0)->where('cust_telecom.telecom_type',2)
                                    ->select('survey_requests.id AS survey_id','survey_requests.created_at AS survey_date','survey_requests.*','cust_mst.*','cust_info.*', 'cust_telecom.*','services.*','survey_invoice.*')
                                    ->orderBy('survey_requests.id','DESC')
                                    ->first();

        // dd($data);

        return view('customer.requested_service.invoice_received',$data);
    }

    public function customer_invoice_download($id)
    {
        $data['survey_data']    =   DB::table('survey_requests')
                                    ->leftjoin('cust_mst', 'survey_requests.cust_id', '=', 'cust_mst.id')
                                    ->leftjoin('cust_info', 'survey_requests.cust_id', '=', 'cust_info.cust_id')
                                    ->leftjoin('cust_telecom', 'survey_requests.cust_id', '=', 'cust_telecom.cust_id')
                                    ->leftjoin('services', 'survey_requests.service_id', '=', 'services.id')
                                    ->leftjoin('survey_invoice', 'survey_requests.id', '=', 'survey_invoice.survey_request_id')
                                    ->where('survey_requests.id',$id)->Where('survey_requests.is_deleted',0)
                                    ->where('cust_mst.is_deleted',0)
                                    ->where('cust_telecom.is_deleted',0)->where('cust_telecom.telecom_type',2)
                                    ->select('survey_requests.id AS survey_id','survey_requests.created_at AS survey_date','survey_requests.*','cust_mst.*','cust_info.*', 'cust_telecom.*','services.*','survey_invoice.*')
                                    ->orderBy('survey_requests.id','DESC')
                                    ->first();

        // $pdf = PDF::loadView('customer.requested_service.customer_invoice_pdf',$data);
        // return $pdf->download('invoice.pdf');

        return view('customer.requested_service.customer_invoice_pdf',$data);
    }

    public function customer_receipt_upload(Request $request)
    {
        $input = $request->all();
        // dd($input);

        $validator = Validator::make($request->all(), [
            'id'=>['required'],
            'receipt'=>['required'],
        ]);
        $survey_id      =  $input['id'];

        if($validator->passes())
        {
            if($request->hasfile('receipt'))
            {
                $file = $request->receipt;
                $folder_name = "uploads/payment_receipt/" . date("Ym", time()) . '/'.date("d", time()).'/';

                $upload_path = base_path() . '/public/' . $folder_name;

                $extension = strtolower($file->getClientOriginalExtension());

                $filename = "payment_receipt" . '_' . time() . '.' . $extension;

                $file->move($upload_path, $filename);

                $file_path = config('app.url') . "/public/$folder_name/$filename";

                Survey_requests::where('id',$survey_id)->update(['receipt_image'=>$file_path,'request_status'=>58]);

                $cust_id = survey_requests::where('id',$survey_id)->first()->cust_id;

                $survey_request_logs = [];

                $survey_request_logs['survey_request_id'] = $survey_id;
                $survey_request_logs['cust_id'] = $cust_id;
                $survey_request_logs['survey_status'] = 58;
                $survey_request_logs['is_active'] = 1;
                $survey_request_logs['is_deleted'] = 0;
                $survey_request_logs['created_by'] = auth()->user()->id;
                $survey_request_logs['updated_by'] = auth()->user()->id;
                $survey_request_logs['created_at'] = date('Y-m-d H:i:s');
                $survey_request_logs['updated_at'] = date('Y-m-d H:i:s');

                $survey_request_log_id = Survey_request_logs::create($survey_request_logs)->id;

            $from       = auth()->user()->id; 
            $utype      = 5;
            $to         = 5; 
            $ntype      = 'payment_receipt_submitted';
            $title      = 'Payment Receipt Submitted';
            $desc       = 'Payment Receipt Submitted. Request ID:HSW'.$survey_id;
            $refId      = $survey_id;
            $reflink    = '/accountant/receipt_received/'.$survey_id;
            $notify     = 'accounts';
            $notify_from_role_id = 6;
            addNotification($from,$utype,$to,$ntype,$title,$desc,$refId,$reflink,$notify,$notify_from_role_id);

                if(isset($survey_request_log_id))
                {   
                    Session::flash('message', ['text'=>'Payment Receipt Submitted Successfully !','type'=>'success']);  
                }
                else
                {
                    Session::flash('message', ['text'=>'Payment Receipt Not Submitted Successfully !','type'=>'danger']);
                }

                return redirect('/customer/requested_services');
            }
        }
        else
        {
            return redirect()->back()->withErrors($validator)->withInput($request->all());
        }
    }

    public function receipt_rejected($survey_id)
    {
        $datas = Survey_requests::where('id',$survey_id)->first();
        // dd($datas);
        $data['id'] = $survey_id;
        $data['service_name'] = Services::where('id',$datas->service_id)->first()->service_name;
        $data['status_name'] = Survey_status::where('id',$datas->request_status)->first()->status_name;
        $data['remarks'] = Survey_request_logs::where('survey_request_id',$survey_id)->where('survey_status',$datas->request_status)->first()->remarks;

        // dd($data);

        return view('customer.requested_service.receipt_rejected',$data);
    }

    public function edit_survey_request($survey_id,$service_id,$service_request_id)
    {
        $data['title']        =  'Edit Requested Service';
        $data['menu']         =  'edit-requested-service';

        $data['service']      =  $service_id;
        $data['services']     =  Services::where('is_deleted',0)->whereNotIn('id',[$service_id])->orderby('id','ASC')->get();
        $data['countries']    =  Country::where('is_deleted',0)->orderby('sortname','ASC')->get();
        $data['states']       =  State::where('is_deleted',0)->get();
        $data['cities']       =  City::where('is_deleted',0)->get();
        $data['org_types']    =  OrganisationType::selectOption();
        $data['data_collection']    = DataCollectionEquipment::selectOption();

        $data['survey_id']           =  $survey_id;
        $data['service_id']          =  $service_id;
        $data['service_request_id']  =  $service_request_id;

        if($service_id == 1)
        {
            $data['survey_data'] = Hydrographic_survey::where('id',$service_request_id)->first();

            // dd($data);
            return view('customer.hydrographic_survey.hydrographicsurvey_edit_form',$data);
        }
        elseif($service_id == 2)
        {
            $data['survey_data'] = Tidal_observation::where('id',$service_request_id)->first();
            return view('customer.tidal_observation.tidalobservation_edit_form',$data);
        }
        elseif($service_id == 3)
        {
            $data['survey_data'] = Bottom_sample_collection::where('id',$service_request_id)->first();

            // dd($data);

            return view('customer.bottomsample.bottomsample_edit_form',$data);
        }
        elseif($service_id == 4)
        {
            $data['survey_data'] = Dredging_survey::where('id',$service_request_id)->first();

            return view('customer.dredging.dredgingsurvey_edit_form',$data);
        }
        elseif($service_id == 5)
        {
            $data['survey_data'] = Hydrographic_chart::where('id',$service_request_id)->first();
            return view('customer.hydrographic_data.hydrographicdata_edit_form',$data);
        }
        elseif($service_id == 6)
        {
            $data['survey_data'] = Underwater_videography::where('id',$service_request_id)->first();

            // dd($data);

            return view('customer.underwater_videography.underwatervideographysurvey_edit_form',$data);
        }
        elseif($service_id == 7)
        {
            $data['survey_data'] = Currentmeter_observation::where('id',$service_request_id)->first();
            return view('customer.currentmeter_observation.currentmeterobservation_edit_form',$data);
        }
        elseif($service_id == 8)
        {
            $data['survey_data'] = Sidescansonar::where('id',$service_request_id)->first();
            return view('customer.sidesonarscan.sidesonarscan_edit_form',$data);
        }
        elseif($service_id == 9)
        {
            $data['survey_data'] = Topographic_survey::where('id',$service_request_id)->first();
            return view('customer.topographic_survey.topographicsurvey_edit_form',$data);
        }
        elseif($service_id == 10)
        {
            $data['survey_data'] = Subbottom_profilling::where('id',$service_request_id)->first();
            return view('customer.subbottom_profilling.subbottomprofilling_edit_form',$data);
        }
        elseif($service_id == 11)
        {
            $data['survey_data'] = Bathymetry_survey::where('id',$service_request_id)->first();

            return view('customer.bathymetry_survey.bathymetry_survey_edit_form',$data);
        }
    }

    public function survey_report($survey_id)
    {
        $datas = Survey_requests::where('id',$survey_id)->first();
        $data['id'] = $survey_id;
        $data['service_name'] = Services::where('id',$datas->service_id)->first()->service_name;
        $data['final_report'] = $datas->final_report;

        // dd($data);

        return view('customer.requested_service.survey_report',$data);
    }
}