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
use App\Models\City;
use App\Models\customer\CustomerMaster;
use App\Models\UserVisit;
use App\Models\Bottom_sample_collection;
use App\Models\Services;
use App\Models\Survey_requests;
use App\Models\Survey_request_logs;
use App\Models\Cust_receipt;

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
                                        ->where('survey_requests.cust_id',$cust_id)->where('survey_requests.is_active',1)->where('survey_requests.is_deleted',0)
                                        ->where('services.is_active',1)->where('services.is_deleted',0)
                                        ->select('survey_requests.id AS survey_id','survey_requests.created_at AS survey_date','survey_requests.*','services.*')
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
                                ->where('survey_request_logs.cust_id',$cust_id)->where('survey_request_logs.survey_request_id',$id)->where('survey_request_logs.is_active',1)->where('survey_request_logs.is_deleted',0)
                                ->select('survey_request_logs.created_at AS log_date','survey_request_logs.*','survey_status.*')
                                ->orderBy('survey_request_logs.id','DESC')
                                ->get();

        $data['status'] = $status;

        // dd($data);
        
        if($status == 3)
        {
            return view('/customer/reject_closed',$data);
        }
        elseif($status == 4)
        {
            return view('/customer/reject_open',$data);
        }
        else
        {
            return view('customer.requested_service.request_service_detail',$data);
        }        
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

        return view('customer.requested_service.request_service_invoice',$data);
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

        $pdf = PDF::loadView('customer.requested_service.customer_invoice_pdf',$data);
        return $pdf->download('invoice.pdf');
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
            if($request->file('receipt') && $request->file('receipt') != '')
            {
                $image = $request->file('receipt');
                $input['imagename'] = rand(100,999).'receipt.'.$image->extension();
                $path               =   '/app/public/receipts/'.$survey_id;
                $destinationPath = storage_path($path.'/thumbnail');
                $img = Image::make($image->path());
                if (!file_exists($destinationPath)) { mkdir($destinationPath, 755, true);}
                $img->resize(150, 150, function ($constraint) {
                    $constraint->aspectRatio();
                })->save($destinationPath.'/'.$input['imagename']);
                $destinationPath = storage_path($path);
                $image->move($destinationPath, $input['imagename']);
                // $imgUpload          =   uploadFile($path,$input['imagename']);

                $cust_arr = [];

                $cust_arr['survey_request_id'] = $input['id'];
                $cust_arr['receipt_image'] = $path.'/'.$input['imagename'];
                $cust_arr['is_active'] = 1;
                $cust_arr['is_deleted'] = 0;
                $cust_arr['created_by'] = auth()->user()->id;
                $cust_arr['updated_by'] = auth()->user()->id;
                $cust_arr['created_at'] = date('Y-m-d H:i:s');
                $cust_arr['updated_at'] = date('Y-m-d H:i:s');

                Cust_receipt::create($cust_arr);

                return redirect('/customer/requested_services');
            }
        }
        else
        {
            return redirect()->back()->withErrors($validator)->withInput($request->all());
        }
    }
}