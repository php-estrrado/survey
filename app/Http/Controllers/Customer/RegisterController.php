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
use App\Models\Customer\CustomerMaster;
use App\Models\Customer\CustomerSecurity;
use App\Models\RegisterationToken;
use App\Models\Customer\CustomerInfo;
use App\Models\Customer\CustomerTelecom;
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
    public function index(){  
        return view('customer.customer_register');
    }
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'=>['required','max:255'],
            'firm'=>['required','max:255'],
            'firm_type'=>['required','numeric'],
            'email' => ['required','email','max:255','unique:cust_mst,username'],
            'mobile'=>['required','max:255'],
            'otp'=> ['nullable','max:255'],
            'valid_id'=>['nullable','max:255'],
            'password' =>['required','confirmed','min:6']
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

            $info = CustomerInfo::create([
                'cust_id' => $masterId,
                'name' => $request->name,
                'valid_id' => $request->valid_id,
                'is_active'=>1,
                'is_deleted'=>0,
                'created_by'=>1,
                'updated_by'=>1,
                'created_at'=>date("Y-m-d H:i:s"),
                'updated_at'=>date("Y-m-d H:i:s")
            ]);

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
