<?php

namespace App\Http\Controllers\Api\Surveyor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Session;
use DB;
use Mail;
use App\Models\Admin;
use App\Models\UserLogin;
use App\Models\Email;
use App\Models\RegisterationToken;
use App\Rules\Name;
use Validator;
use Illuminate\Support\Facades\Hash;
use Twilio\Rest\Client;

class SurveyorAuth_Api extends Controller
{
    
   
    function generateOtp($user){
        $otp = rand(1000, 9999);    $otp = 1234;
        CustomerTelecom::where('id',$user->phone)->update(['otp'=>$otp,'otp_sent_at'=>date('Y-m-d H:i:s')]); 
        CustomerTelecom::where('id',$user->email)->update(['otp'=>$otp,'otp_sent_at'=>date('Y-m-d H:i:s')]); 
        return $otp;
    }
    
  
    
    function validateOtp($user,$otp){
        if(CustomerTelecom::where('user_id',$user->id)->where('otp',$otp)->where('otp','!=',NULL)->count() > 0){
            CustomerTelecom::where('user_id',$user->id)->where('otp',$otp)->update(['otp'=>NULL,'otp_verified_at'=>date('Y-m-d H:i:s')]); return true;
        }else{ return false; }
    }
    
    
 
    
    function authenticateUser($user,$post){
        $token                 =   $user->id.substr(str_shuffle('0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ'),0,12);
        if(isset($post->deviceName)){   $deviceName = $post->deviceName; }else{ $deviceName = NULL; }
        if(!isset($post->os))   {   $post->os = 'web'; }
        
         
        $existing = UserLogin::where('user_id',$user->id)->where('device_id',"!=",$post->deviceId)->where('is_login',1)->where('is_deleted',0);
        if($existing->exists()){
        $existing->update(['is_login'=>0]);
        }
        
        //    $update                 =    User::where('id',$user->id)->update(['is_login'=>1,'otp'=>NULL,'access_token'=>$token,'deviceToken'=>$post->deviceToken,'os'=>$post->os]);
        $loginData              =   ['user_id'=>$user->id,'device_id'=>$post->deviceId,'device_name'=>$deviceName,'access_token'=>$token,'is_login'=>1,'device_token'=>$post->deviceToken,'os'=>$post->os,'login_at'=>date('Y-m-d H:i:s'),
        'os_type'=>$post->os_type,
        'os_version'=>$post->os_version,
        'app_version'=>$post->app_version,
        'latitude'=>$post->latitude,
        'longitude'=>$post->longitude,
    ];
         $loginUser             =   UserLogin::where('device_id',$post->deviceId)->where('is_deleted',0);
         
         if($loginUser->exists()){//  dd($loginUser->first());
         $loginData['last_login']    =   $loginUser->first()->login_at; 
             UserLogin::where('device_id',$post->deviceId)->where('is_deleted',0)->update($loginData);
             
         }else{ UserLogin::create($loginData); }
        if($user){
            $mst                =   Admin::where('id',$user->id)->first();
            $data['user_id']    =   $user->id;                 $data['fname']          =   $user->first_name;
            $data['lname']      =   $user->last_name;               $data['phone']          =  $user->phone;       
            $data['email']      =   $user->email;
            return ['httpcode'=>200,'status'=>'success','message'=>'Login successfull!','data'=>array('access_token'=>$token,'user_details'=>$data)];
        }else{ return array('httpcode'=>400,'status'=>'error','message'=>'Somthing went wrong','data'=>['errors' =>(object)['error_msg'=>'Somthing went wrong']]); }
    }
    
    function getUser($userId){ 
        $query                  =   CustomerInfo::where('user_id',$userId)->where('is_deleted',0)->first();
        if($query->exists)  {       return $query; }else{ return false; }
    }
    

    
    ///LOGIN EMAIL OTP
    public function loginSendotpemail(Request $request)
    {
        $formData   =   $request->all(); 
        $rules      =   array();
        $rules['email']    = 'required|email';
        $validator  =   Validator::make($request->all(), $rules);
        if ($validator->fails()) 
            {
                foreach($validator->messages()->getMessages() as $k=>$row){ $error[$k] = $row[0]; $errorMag[] = $row[0]; }  
                return array('httpcode'=>'400','status'=>'error','message'=>$errorMag[0],'data'=>array('errors' =>(object)$error));
            }
        else
            { 
              $regexist = Admin::where('email',$request->email)->where('role_id',3)->where('is_deleted',0);
              if($regexist->count() > 0)
              {
                $otp = rand(1000, 9999); $otp = 1234;
                Admin::where('email',$request->email)->update(['otp'=>$otp,'otp_sent_at'=>date('Y-m-d H:i:s')]);

                  $req_email = $request->email;
                        $data['data'] = array("content"=>"Test",'otp'=>$otp);
                        $var = Mail::send('emails.get_otp', $data, function($message) use($data,$req_email) {
                        $message->from("sujeesh@estrrado.com",'Survey');    
                        $message->to($req_email);
                        $message->subject('OTP Verification');
                        });
            

                return ['httpcode'=>200,'status'=>'success','message'=>'OTP has been sent to email','data'=>['otp' =>$otp,'email'=>$request->email]];
              }
              else
              {
                return array('httpcode'=>'400','status'=>'error','message'=>'Email does not exist','data'=>['message' =>'Email does not exist!']);
              }
              
            }
    }
    
    public function loginVerifyotpemail(Request $request)
    {
        $formData   =   $request->all(); 
        $post       =   (object)$request->post();
        $rules      =   array();
        $rules['email']    = 'required|email';
        $rules['otp']             = 'required|numeric';
        $rules['deviceToken']     = 'required|string|max:200';
        $rules['os']              = 'required|string|max:20';
        $rules['deviceId']        = 'required|string|max:200';
        $validator  =   Validator::make($request->all(), $rules);
        if ($validator->fails()) 
            {
                foreach($validator->messages()->getMessages() as $k=>$row){ $error[$k] = $row[0]; $errorMag[] = $row[0]; }  
                return array('httpcode'=>'400','status'=>'error','message'=>$errorMag[0],'data'=>array('errors' =>(object)$error));
            }
        else
            { 
                $exisit = Admin::where('email',$request->email)->where('is_deleted',0)->first();
                if($exisit)
                {
                    if($exisit->is_active == 0)
                    {
                         return array('httpcode'=>'400','status'=>'error','message'=>'Account Disabled','data'=>['message' =>'This account has been disabled. Please contact Admin!']);
                    }
                    else
                    {
                        $ext = Admin::where('email',$request->email)->where('otp',$request->otp)->where('is_deleted',0)->where('is_active',1);
                         if($ext->count() > 0)
                         {
                              $user = $ext->first();
                              return $this->authenticateUser($user,$post);
                         }
                         else
                         {
                             return array('httpcode'=>'400','status'=>'error','message'=>'Invalid OTP','data'=>['message' =>'Entered OTP is Invalid!']);
                         }
                    }
                  
                    
                }
                else
                {
                   return array('httpcode'=>'400','status'=>'error','message'=>'Email does not exist','data'=>['message' =>'Email does not exist!']);
                }
              
            }
    }


}
