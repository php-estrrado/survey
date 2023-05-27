<?php

namespace App\Http\Controllers\Surveyor;

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
use App\Models\Cust_receipt;
use App\Models\customer\CustomerMaster;
use App\Models\customer\CustomerInfo;
use App\Models\customer\CustomerTelecom;
use App\Models\Institution;
use App\Models\Services;
use App\Models\UserRole;
use App\Models\Survey_status;
use App\Models\Survey_requests;
use App\Models\Survey_request_logs;
use App\Models\Field_study_report;
use App\Models\Survey_study_report;
use App\Models\Fieldstudy_eta;
use App\Models\Survey_invoice;
use App\Models\Survey_performa_invoice;

use App\Rules\Name;
use Svg\Tag\Rect;
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

        // $status_in               =   array(41,42,7,62,60,30,32,33,43,40,19,65,59,20,36,37);
        $status_in                  =   array(41,42,62,60,30,32,33,43,40,65,59,20,36,37);

        $data['survey_requests']    =   DB::table('survey_requests')
                                        ->leftjoin('cust_mst', 'survey_requests.cust_id', '=', 'cust_mst.id')
                                        ->leftjoin('cust_info', 'survey_requests.cust_id', '=', 'cust_info.cust_id')
                                        ->leftjoin('cust_telecom', 'survey_requests.cust_id', '=', 'cust_telecom.cust_id')
                                        ->leftjoin('services', 'survey_requests.service_id', '=', 'services.id')
                                        ->leftjoin('institution', 'survey_requests.assigned_institution', '=', 'institution.id')
                                        ->leftjoin('survey_status', 'survey_requests.request_status', '=', 'survey_status.id')
                                        ->whereIn('survey_requests.request_status',$status_in)->where('survey_requests.request_status','!=',NULL)->Where('survey_requests.is_deleted',0)
                                        ->where(function ($query) { $query->where('survey_requests.assigned_surveyor',auth()->user()->id)->orWhere('survey_requests.assigned_surveyor_survey',auth()->user()->id);})                                        
                                        ->where('cust_mst.is_deleted',0)
                                        ->where('cust_telecom.is_deleted',0)->where('cust_telecom.telecom_type',2)
                                        ->select('survey_requests.id AS survey_id','survey_requests.created_at AS survey_date','survey_requests.*','cust_mst.*','cust_info.*', 'cust_telecom.*','services.*','institution.*','survey_status.status_name AS current_status')
                                        ->orderBy('survey_requests.id','DESC')
                                        ->get();

        return view('surveyor.requested_services.services_requests',$data);
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

        $data['survey_datas'] = DB::table('survey_request_logs')
                                ->leftjoin('survey_status', 'survey_request_logs.survey_status', '=', 'survey_status.id')
                                ->where('survey_request_logs.cust_id',$cust_id)->where('survey_request_logs.survey_request_id',$id)->where('survey_request_logs.is_active',1)->where('survey_request_logs.is_deleted',0)
                                ->select('survey_request_logs.created_at AS log_date','survey_request_logs.*','survey_status.*')
                                ->orderBy('survey_request_logs.id','DESC')
                                ->get();
        
        $data['survey_status'] = Survey_status::where('id',$datas->request_status)->first()->status_name;

        if($datas->request_status != $status)
        {
            return redirect('/surveyor/requested_service_detail/'.$id.'/'.$datas->request_status);
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
        }
        else
        {
             $data['additional_services'] ="";
        }

        if(isset($data['request_data']->data_collection_equipments))
        {
           $data['data_collection'] = $datas->datacollection_selected($data['request_data']->data_collection_equipments);
        }
        else
        {
             $data['data_collection'] ="";
        }

        $data['state_name'] = State::where('id',$data['request_data']['state'])->first()->state_name;
        $data['district_name'] = City::where('id',$data['request_data']['district'])->first()->city_name;

        $field_study_data = Field_study_report::where('survey_request_id',$id)->first();
        if($field_study_data)
        {
            $data['field_study'] = Field_study_report::where('survey_request_id',$id)->first();
        }
        else
        {
            $data['field_study'] = '';
        }
        
        // $data['field_study_eta'] = Fieldstudy_eta::where('survey_request_id',$id)->first();

        $survey_study_data = Survey_study_report::where('survey_request_id',$id)->first();
        if($survey_study_data)
        {
            $data['survey_study'] = Survey_study_report::where('survey_request_id',$id)->first();
        }
        else
        {
            $data['survey_study'] = '';
        }

        $field_array = array(42,62,60,30,32,33);
        $survey_array = array(40,65,59,20,36,37);
        if(in_array($status,$field_array))
        {
            return view('surveyor.requested_services.field_study_upload',$data);    
        }
        elseif(in_array($status,$survey_array))
        {
            return view('surveyor.requested_services.survey_study_upload',$data);    
        }
        else
        {
            return view('surveyor.requested_services.requested_services_details',$data);
        }        
    }

    public function upload_fieldstudy(Request $request)
    {
        $input = $request->all();

        $validator = Validator::make($request->all(),[
            'filenames'           =>  ['required'],
            'filenames.*'          =>  ['required','max:20480']
            
        ],['filenames.required' => 'File is required.']);

        if($validator->passes())
        {
            $field_study_data = Field_study_report::where('survey_request_id',$input['id'])->first();

            if($field_study_data)
            {
                $files = [];

                $drawings = Field_study_report::where('survey_request_id',$input['id'])->first()->upload_photos_of_study_area;

                $drawing = json_decode($drawings,true);

                $files = $drawing;

                if($request->hasfile('filenames'))
                {
                    foreach($request->file('filenames') as $file)
                    {
                        $folder_name = "uploads/study_report/" . date("Ym", time()) . '/'.date("d", time()).'/';

                        $upload_path = base_path() . '/public/' . $folder_name;

                        $extension = strtolower($file->getClientOriginalExtension());

                        $filename = "survey" . '_' . time() .rand(1,1000).'.' . $extension;

                        $file->move($upload_path, $filename);

                        $files[] = config('app.url') . "/public/$folder_name/$filename";
                    }
                }

                Field_study_report::where('survey_request_id',$input['id'])->update(['upload_photos_of_study_area'=>$files,'is_submitted'=>1,'submitted_at'=>date('Y-m-d H:i:s')]);
                Survey_requests::where('id',$input['id'])->update(['request_status'=>7]);

                Session::flash('message', ['text'=>'Field Study Files Uploaded Successfully !','type'=>'success']);

                return redirect('surveyor/service_requests');
            }
            else
            {
                Session::flash('message', ['text'=>'Field Study data Not available !','type'=>'error']);

                return redirect()->back();
            }
        }
        else
        {
            return redirect()->back()->withErrors($validator)->withInput($request->all());
        }
    }

    public function upload_surveystudy(Request $request)
    {
        $input = $request->all();

        $validator = Validator::make($request->all(),[
            'filenames'           =>  ['required'],
            'filenames.*'          =>  ['required','max:20480']
            
        ],['filenames.required' => 'File is required.']);

        if($validator->passes())
        {
            $survey_study_data = Survey_study_report::where('survey_request_id',$input['id'])->first();

            if($survey_study_data)
            {
                $files = [];

                $drawings = Survey_study_report::where('survey_request_id',$input['id'])->first()->upload_photos_of_study_area;

                $drawing = json_decode($drawings,true);

                $files = $drawing;

                if($request->hasfile('filenames'))
                {
                    foreach($request->file('filenames') as $file)
                    {
                        $folder_name = "uploads/study_report/" . date("Ym", time()) . '/'.date("d", time()).'/';

                        $upload_path = base_path() . '/public/' . $folder_name;

                        $extension = strtolower($file->getClientOriginalExtension());

                        $filename = "survey" . '_' . time() .rand(1,1000).'.' . $extension;

                        $file->move($upload_path, $filename);

                        $files[] = config('app.url') . "/public/$folder_name/$filename";
                    }
                }

                Survey_study_report::where('survey_request_id',$input['id'])->update(['upload_photos_of_study_area'=>$files,'is_submitted'=>1,'submitted_at'=>date('Y-m-d H:i:s')]);
                Survey_requests::where('id',$input['id'])->update(['request_status'=>19]);

                Session::flash('message', ['text'=>'Survey Study Files Uploaded Successfully !','type'=>'success']);

                return redirect('surveyor/service_requests');
            }
            else
            {
                Session::flash('message', ['text'=>'Survey Study data Not available !','type'=>'error']);

                return redirect()->back();
            }
        }
        else
        {
            return redirect()->back()->withErrors($validator)->withInput($request->all());
        }
    }

    function upload(Request $request)
    {
        $image = $request->file('file');

        $imageName = time() . '.' . $image->extension();

        $image->move(public_path('images'), $imageName);

        return response()->json(['success' => $imageName]);
    }

    function fetch()
    {
        $images = \File::allFiles(public_path('images'));
        $output = '<div class="row">';
        foreach($images as $image)
        {
            $output .= '
                <div class="col-md-2" style="margin-bottom:16px;" align="center">
                    <img src="'.asset('images/' . $image->getFilename()).'" class="img-thumbnail" width="175" height="175" style="height:175px;" />
                    <button type="button" class="btn btn-link remove_image" id="'.$image->getFilename().'">Remove</button>
                </div>
            ';
        }
        $output .= '</div>';
        echo $output;
    }

    function delete(Request $request)
    {
        if($request->get('name'))
        {
            \File::delete(public_path('images/' . $request->get('name')));
        }
    }
}