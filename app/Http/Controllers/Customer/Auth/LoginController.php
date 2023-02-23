<?php

namespace App\Http\Controllers\Customer\Auth;

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
use App\Models\CustomerInfo;
use Error;
use Mail;
use Session;
use Validator;


class LoginController extends Controller
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
    public function showAdminLoginForm(){  
        return view('customer.auth.login');
    }
    public function adminLogin(Request $request)
    {
        $input = $request->all();

        $validator = Validator::make($request->all(), [
            'email'   => ['required','string','email'],
            'password' => ['required','string','min:6'],
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
        if($validator->passes())
        {
            if (Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password], $request->get('remember'))) 
            {
                if(Admin::where('id', Auth::guard('admin')->user()->id)->where('role_id',6)->first())
                {
                    if(Admin::where('id', Auth::guard('admin')->user()->id)->where('role_id',6)->first()->is_active == 1)
                    {
                        return redirect()->intended('/customer/dashboard');
                    }
                    else
                    {
                        Auth::guard('admin')->logout(); $request->session()->flush(); $request->session()->regenerate();
                        
                        return back()->withInput($request->only('email', 'remember'))->withErrors('error',' This account is inactive.');
                    }
                }
                else
                {
                    Auth::guard('admin')->logout(); $request->session()->flush(); $request->session()->regenerate();
                    
                    return back()->withInput($request->only('email', 'remember'))->withErrors('error',' This account is inactive.');
                }
            }
            else
            {
                return back()->withInput($request->only('email', 'remember'))->withErrors(['error'=>'These credentials do not match our records.']);
            }
        }
        else
        {
            return back()->withInput($request->only('email', 'remember'))->withErrors(['error'=>'These credentials do not match our records.']);
        }
        
    }

    public function forgotPassword()
    {
        return view('customer.forgot_password');
    }

    public function send_otp(Request $request)
    {
        $formData   =   $request->all();

        $rules      =   array();
        $rules['email']    = 'required|email';
        $validator  =   Validator::make($request->all(), $rules);
        if ($validator->fails()) 
        {
            foreach($validator->messages()->getMessages() as $k=>$row){ $error[$k] = $row[0]; $errorMag[] = $row[0]; }  
            return back()->withInput($request->only('email', 'remember'))->with('message',' These credentials do not match our records. ');
        }
        else
        {
            $regexist = Admin::where('email',$request->email)->where('is_active',1)->where('is_deleted',0)->where('role_id',6)->first();

            if($regexist)
            {
                $otp = rand(1000, 9999); 
                $otp = 1234;

                // dd($otp);

                // $req_email = $request->email;
                // $data['otp'] = $otp;
                
                // $var = Mail::send('emails.otp', $data, function($message) use($data,$req_email) {
                //     $message->from(getadmin_mail(),'HSW');    
                //     $message->to($req_email);
                //     $message->subject('OTP Verification');
                // });

                Admin::where('email',$request->email)->update(['otp'=>$otp,'otp_sent_at'=>date('Y-m-d H:i:s')]);

                Session::flash('message', ['text'=>'OTP Sent to E-mail !','type'=>'success']);  

                return back()->withInput($request->only('email', 'remember'))->with('message',' OTP Sent to mail.');
            }
            else
            {
                Session::flash('message', ['text'=>'E-mail does not exist !','type'=>'danger']);

                return back()->withInput($request->only('email', 'remember'))->with('message',' Email does not exist!.');
            }
            
        }
    }

    public function verify_otp(Request $request)
    {
        $formData   =   $request->all(); 
        $rules      =   array();
        $rules['email']           = 'required|email';
        $rules['otp']             = 'required|numeric';
        $validator  =   Validator::make($request->all(), $rules);
        if ($validator->fails()) 
        {
            foreach($validator->messages()->getMessages() as $k=>$row){ $error[$k] = $row[0]; $errorMag[] = $row[0]; }  
            return back()->withInput($request->only('email', 'remember'))->with('message',['text'=>' This account is inactive !','type'=>'success']);
        }
        else
        { 
            $exisit = Admin::where('email',$request->email)->where('is_active',1)->where('is_deleted',0)->where('role_id',6)->first();
            if($exisit)
            {
                $exist = Admin::where('email',$request->email)->where('otp',$request->otp)->where('is_active',1)->where('is_deleted',0)->where('role_id',6)->first();
                if($exist)
                {
                    return back()->withInput($request->all())->with('message',['text'=>'OTP Verified Successfully !','type'=>'success']);
                }
                else
                {
                    Session::flash('message', ['text'=>'Invalid OTP !','type'=>'danger']);
                    return back()->withInput($request->only('email', 'remember'))->with('message',' Invalid OTP.');
                }
            }
            else
            {
                return back()->withInput($request->only('email', 'remember'))->with('message',' Invalid Email.');
            }
        }
    }

    public function update_password(Request $request)
    {
        $formData   =   $request->all(); 
        $rules      =   array();
        $rules['email']           = 'required|email';
        $rules['otp']             = 'required|numeric';
        $rules['password'] = 'required|confirmed|min:6';
        $rules['password_confirmation'] = 'required|min:6';

        $validator  =   Validator::make($request->all(), $rules);
        if ($validator->fails()) 
        {
            foreach($validator->messages()->getMessages() as $k=>$row){ $error[$k] = $row[0]; $errorMag[] = $row[0]; }  
            
            return redirect()->back()->withErrors($validator)->withInput($request->all());
        }
        else
        { 
            $exisit = Admin::where('email',$request->email)->where('is_active',1)->where('is_deleted',0)->where('role_id',6)->first();
            if($exisit)
            {
                $exist = Admin::where('email',$request->email)->where('otp',$request->otp)->where('is_active',1)->where('is_deleted',0)->where('role_id',6)->first();
                if($exist)
                {
                    $cust_id = CustomerMaster::where('username',$request->email)->first()->id;

                    Admin::where('email',$request->email)->update([
                        'password' => Hash::make($request->password),
                        'updated_by'=>1,
                        'updated_at'=>date("Y-m-d H:i:s")
                    ]);

                    CustomerSecurity::where('cust_id',$cust_id)->update([
                        'password' => Hash::make($request->password),
                        'updated_by'=>1,
                        'updated_at'=>date("Y-m-d H:i:s")
                    ]);
  
                    Session::flash('message', ['text'=>'Password Changed Successfully !','type'=>'success']);  

                    return redirect('customer/login');
                }
                else
                {
                    Session::flash('message', ['text'=>'Invalid OTP !','type'=>'danger']);
                    return back()->withInput($request->only('email', 'remember'));
                }
            }
            else
            {
                Session::flash('message', ['text'=>'Invalid Email !','type'=>'danger']);
                return back()->withInput($request->only('email', 'remember'));
            }
        }
    }

    function forgotPassword1(Request $request){
        $post = (object)$request->post();
        $user           =   Admin::where('email',$post->email)->first();
        if($user){        
            if ($user) {
                if ($user->is_active == 0 || $user->is_deleted == 1) {
                    return redirect('/password/reset')->with('message', 'This account not activated or disabled')->withInput();
                }else{
                    $resetLink = base64_encode(rand(100000, 999999) . 'resetpassword' . time() . '1');
                    $resetLink = urlencode($resetLink);
                    $currTime = date('Y-m-d H:i:s');
                    $data = array('active_link' => $resetLink, 'email_verified_at' => $currTime);
                    $msg = '<h4>Hi, ' . $user->fname . ' </h4>';
                    $msg .= 'You can reset password of ' . ucfirst(geSiteName()) . ' admin portal through this <a href="' . url('/reset/password/' . $resetLink) . '">Reset Password</a> link.';
                    $update = PasswordReset::create(['user_id'=>$user->id,'user_type'=>'admin','email'=>$post->email,'token'=>$resetLink]);
                    // dd($msg);
                    if ($update) Email::sendEmail(geAdminEmail(), $post->email, 'Reset Password', $msg);
                    
                    return redirect('/password/reset')->with('success', "Reset password link sent to your registered email!");
                }
            }
        }
        return redirect('/password/reset')->with('message', "We can't find a user with that e-mail address.")->withInput();
    }
    
    public function resetPassword($token)
    {
        $reset = PasswordReset::where('token',$token)->where('is_deleted',0)->first();
        if ($reset)
        { 
            if(date('YmdHi',strtotime($reset->created_at)) > date('YmdHi', strtotime('-20 minutes', strtotime(date('Y-m-d H:i:s'))))){
                return view('auth.passwords.reset', compact('reset')); 
            }
            else
            { 
                if($reset->user_type         ==  'customer')
                {
                    return view('admin.auth.registeration_error', compact('reset'));
                }
                else
                {
                    return redirect('/login')->with('error', 'Expired authentication link.'); 
                }
                
            }
        }
        else
            { 
                if($reset->user_type         ==  'customer')
                {
                    return view('admin.auth.registeration_invalid', compact('reset'));
                }
                else
                {

                return redirect('/login')->with('error', 'Invalid authentication link.'); 
                }
            }
    }

    public function updatePassword(Request $request){ 
        $post               =   (object)$request->post();
        $reset              =   PasswordReset::where('token',$post->token)->where('is_deleted',0)->first();
        if($reset) {
            $update         =   $this->updateUserPassword($reset,$post);
            if($reset->user_type         ==  'customer')
                {
                     return view('admin.auth.forgotpass_success', compact('reset')); 
                }
                else
                {
                    return redirect('/login')->with('success', 'Password reset successfully');
                }
            
        }else{ if($reset->user_type         ==  'customer')
                {
                     return view('admin.auth.registeration_invalid', compact('reset'));
                }
                else
                {

                return redirect('/login')->with('error', 'Invalid authentication link.'); 
                } 
            }
    }
    
    function updateUserPassword($data,$post){
        $password                   =   Hash::make($post->password);
        if($data->user_type         ==  'admin'){       return  Admin::where('id',$data->user_id)->update(['password'=>$password]); }
        else if($data->user_type    ==  'seller'){      return  SellerSecurity::where('seller_id',$data->user_id)->update(['password_hash'=>$password]); }
        else if($data->user_type    ==  'customer'){    return  CustomerSecurity::where('user_id',$data->user_id)->update(['password_hash'=>$password]); }
    }
    
    public function customerVerification($token)
    { 
        $reset = RegisterationToken::where('token',$token)->where('is_deleted',0)->first();
        if ($reset)
        { 

            if(date('YmdHi',strtotime($reset->created_at)) > date('YmdHi', strtotime('-20 minutes', strtotime(date('Y-m-d H:i:s'))))){ 
                $update = CustomerInfo::where('user_id',$reset->user_id)->update(['is_active'=>1]);
                $cust_info  = CustomerInfo::where('user_id',$reset->user_id)->first();
                $user_name  = $cust_info->first_name." ".$cust_info->last_name;
                $telecom = CustomerTelecom::where('user_id',$reset->user_id)->where('usr_telecom_typ_id',1)->where('is_active',1)->where('is_deleted',0)->first();
             //   $msg = Email::get_account_success_message($user_name); 
            
                // if ($update) Email::sendEmail(geAdminEmail(), $post->email, 'Reset Password', $msg);
                $email = $telecom->usr_telecom_value;
                  $data['data'] = array("content"=>"Test",'user_name'=>$user_name);
                        $var = Mail::send('emails.account_success_msg', $data, function($message) use($data,$email) {
                        $message->from(getadmin_mail(),'MJS');    
                        $message->to($email);
                        $message->subject('Registration Success');
                        });
                return view('admin.auth.registeration_success', compact('reset')); 
            }
            else
            { 
               return view('admin.auth.registeration_error', compact('reset')); 
                
            }
        }
        else
            { 
                return view('admin.auth.registeration_invalid', compact('reset')); 
            }
    }
}
