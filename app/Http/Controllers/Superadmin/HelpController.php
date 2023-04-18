<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Mail;
use Session;
use DB;
use App\Models\Services;
use App\Models\Country;
use App\Models\State;
use App\Models\Admin;
use App\Models\City;
use App\Models\customer\CustomerMaster;
use App\Models\customer\CustomerInfo;
use App\Models\UserVisit;
use App\Models\SupportRequests;
use App\Models\SupportRequestLogs;
use App\Models\Survey_requests;
use App\Models\Survey_request_logs;
use App\Models\AdminNotification;
use App\Rules\Name;
use Validator;
use App\Models\OrganisationType;
use App\Models\DataCollectionEquipment;


class HelpController extends Controller
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

    public function help()
    {
        $data['title']        =  'Support Management';
        $data['menu']         =  'Support Management';

        $data['help_requests'] = SupportRequests::where('is_active',1)->where('is_deleted',0)->orderby('id','DESC')->get();

        // dd($data);

        return view('superadmin.support.support_list',$data);
    }

    public function help_detail($id)
    {
        $data['title']        =  'Support Management';
        $data['menu']         =  'Support Management';

        $data['help_request_detail'] = SupportRequests::where('id',$id)->first();
        $data['help_request_logs'] = SupportRequestLogs::where('support_id',$id)->get();

        // dd($data);

        return view('superadmin.support.support_detail',$data);
    }

    public function sendReply(Request $request)
    {
        $input = $request->all();

        $validator = Validator::make($request->all(), [
            'support_id'=>['required'],
            'remarks'=>['required','regex:/^[a-zA-Z0-9\s.,@&*()]*$/']
        ]);

        if($validator->passes())
        {
            $support_log_arr['support_id'] = $input['support_id'];
            $support_log_arr['from_role_id'] = 1;
            $support_log_arr['to_role_id'] = 6;
            $support_log_arr['user_id'] = auth()->user()->id;
            $support_log_arr['to_user_id'] = $input['to_user_id'];
            $support_log_arr['comment'] = $input['remarks'];
            $support_log_arr['is_active'] = 1;
            $support_log_arr['is_deleted'] = 0;
            $support_log_arr['created_by'] = auth()->user()->id;
            $support_log_arr['updated_by'] = auth()->user()->id;
            $support_log_arr['created_at'] = date('Y-m-d H:i:s');
            $support_log_arr['updated_at'] = date('Y-m-d H:i:s');

            $support_log_id = SupportRequestLogs::create($support_log_arr)->id;

            if(isset($support_log_id))
            {   
                Session::flash('message', ['text'=>'Support Reply Submitted Successfully !','type'=>'success']);  
            }
            else
            {
                Session::flash('message', ['text'=>'Support Reply Not Submitted !','type'=>'danger']);
            }

            return redirect('superadmin/help');
        }
        else
        {
            foreach($validator->messages()->getMessages() as $k=>$row)
            {
                $error[$k] = $row[0];
                Session::flash('message', ['text'=>$row[0],'type'=>'danger']);
            }
                
            return back()->withErrors($validator)->withInput($request->all());
        }
    }
 
}
