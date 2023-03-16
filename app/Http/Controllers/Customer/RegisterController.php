<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\Admin;
use App\Models\PasswordReset;
use App\Models\Email;
use App\Models\customer\CustomerMaster;
use App\Models\customer\CustomerSecurity;
use App\Models\RegisterationToken;
use App\Models\customer\CustomerInfo;
use App\Models\customer\CustomerTelecom;
use Mail;
use Validator;
use Session;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
   // protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
      //  $this->middleware('guest:admin')->except('logout');
    }
    public function index()
    {
        return view('customer.customer_register');
    }
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'=>['required','regex:/^[a-zA-Z\s]*$/'],
            'firm'=>['required','regex:/^[a-zA-Z\s]*$/'],
            'firm_type'=>['required','numeric'],
            'email' => ['required','email','max:255','unique:cust_mst,username'],
            'mobile'=>['required','numeric','digits:10'],
            'otp'=> ['nullable','max:255'],
            'valid_id'=>['required','regex:/^[a-zA-Z0-9\s]*$/'],
            'id_file_front' => ['required','max:10000'],
            'id_file_back' => ['required','max:10000'],
            'password' =>['required','confirmed','min:6','max:20'],
            'password_confirmation' =>['required','min:6','max:20'],
            'g-recaptcha-response' => function ($attribute, $value, $fail) {
                $data = array('secret' => config('services.recaptcha.secret'),'response' => $value,'remoteip' => $_SERVER['REMOTE_ADDR']);
  
                $verify = curl_init();
                curl_setopt($verify, CURLOPT_URL, "https://www.google.com/recaptcha/api/siteverify");
                curl_setopt($verify, CURLOPT_POST, true);
                curl_setopt($verify, CURLOPT_POSTFIELDS, http_build_query($data));
                curl_setopt($verify, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($verify, CURLOPT_RETURNTRANSFER, true);
                $response = curl_exec($verify);
                $response = json_decode($response);
                
                if(!$response->success)
                {
                    Session::flash('message', ['text'=>'Please check reCAptcha !','type'=>'danger']);
                    $fail($attribute.'google reCaptcha failed');
                }
            },
        ]);
        $input = $request->all();

        if($validator->passes())
        {
            $master = CustomerMaster::create([
                'username' => $request->email,
                'is_active'=>1,
                'is_deleted'=>0,
                'created_by'=>1,
                'updated_by'=>1,
                'created_at'=>date("Y-m-d H:i:s"),
                'updated_at'=>date("Y-m-d H:i:s")
            ]);
            $masterId = $master->id;

            $info_id = CustomerInfo::create([
                'cust_id' => $masterId,
                'name' => $request->name,
                'valid_id' => $request->valid_id,
                'is_active'=>1,
                'is_deleted'=>0,
                'created_by'=>1,
                'updated_by'=>1,
                'created_at'=>date("Y-m-d H:i:s"),
                'updated_at'=>date("Y-m-d H:i:s")
            ])->id;

            $security = CustomerSecurity::create([
                'cust_id' => $masterId,
                'password' => Hash::make($request->password),
                'is_active'=>1,
                'is_deleted'=>0,
                'created_by'=>1,
                'updated_by'=>1,
                'created_at'=>date("Y-m-d H:i:s"),
                'updated_at'=>date("Y-m-d H:i:s")
            ]);

            $telecom_email = CustomerTelecom::create([
                'cust_id' => $masterId,
                'telecom_type' =>1,
                'cust_telecom_value' => $request->email,
                'is_active'=>1,
                'is_deleted'=>0,
                'created_by'=>1,
                'updated_by'=>1,
                'created_at'=>date("Y-m-d H:i:s"),
                'updated_at'=>date("Y-m-d H:i:s")
            ]);
            $tele_email_id = $telecom_email->id;

            $telecom_mobile = CustomerTelecom::create([
                'cust_id' => $masterId,
                'telecom_type' =>2,
                'cust_telecom_value' => $request->mobile,
                'is_active'=>1,
                'is_deleted'=>0,
                'created_by'=>1,
                'updated_by'=>1,
                'created_at'=>date("Y-m-d H:i:s"),
                'updated_at'=>date("Y-m-d H:i:s")
            ]);
            $tele_mobile_id = $telecom_mobile->id;

            CustomerMaster::where('id',$masterId)->update([
                'email'=>$tele_email_id,
                'phone'=>$tele_mobile_id
            ]);

            Admin::create([
                'fname' => $request->name,
                'email' =>$request->email,
                'phone' => $request->mobile,
                'password' => Hash::make($request->password),
                'role_id' => 6,
                'is_active'=>1,
                'is_deleted'=>0,
                'created_by'=>1,
                'updated_by'=>1,
                'created_at'=>date("Y-m-d H:i:s"),
                'updated_at'=>date("Y-m-d H:i:s")
            ]);

            if($request->hasfile('id_file_front'))
            {
                $file = $request->id_file_front;
                $folder_name = "uploads/customer_document/" . date("Ym", time()) . '/'.date("d", time()).'/';

                $upload_path = base_path() . '/public/' . $folder_name;

                $extension = strtolower($file->getClientOriginalExtension());

                $filename = "customer_id_front" . '_' . time() . '.' . $extension;

                $file->move($upload_path, $filename);

                $file_path = config('app.url') . "/public/$folder_name/$filename";

                CustomerInfo::where('id',$info_id)->update([
                    'id_file_front' => $file_path,
                    'updated_by'=>1,
                    'updated_at'=>date("Y-m-d H:i:s")
                ]);
            }
            if($request->hasfile('id_file_back'))
            {
                $file = $request->id_file_back;
                $folder_name = "uploads/customer_document/" . date("Ym", time()) . '/'.date("d", time()).'/';

                $upload_path = base_path() . '/public/' . $folder_name;

                $extension = strtolower($file->getClientOriginalExtension());

                $filename = "customer_id_back" . '_' . time() . '.' . $extension;

                $file->move($upload_path, $filename);

                $file_path = config('app.url') . "/public/$folder_name/$filename";

                CustomerInfo::where('id',$info_id)->update([
                    'id_file_back' => $file_path,
                    'updated_by'=>1,
                    'updated_at'=>date("Y-m-d H:i:s")
                ]);
            }

            if($masterId)
            {   
                Session::flash('message', ['text'=>'Customer Created Successfully !','type'=>'success']);  
            }
            else
            {
                Session::flash('message', ['text'=>'Customer Not Created Successfully !','type'=>'danger']);
            }

            return redirect('customer/register');
        }
        else
        {
            return redirect()->back()->withErrors($validator)->withInput($request->all());
        }
    }

}