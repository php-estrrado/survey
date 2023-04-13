<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
// use Intervention\Image\Facades\Image;
use Intervention\Image\ImageManagerStatic as Image;
use Mail;
use Session;
use DB;
use App\Models\Modules;
// use App\Models\UserRoles;
use App\Models\Country;
use App\Models\Admin;
use App\Models\UserRole;
use App\Models\SalesOrder;
use App\Models\Product;
use App\Models\customer\CustomerMaster;
use App\Models\customer\CustomerSecurity;
use App\Models\RegisterationToken;
use App\Models\customer\CustomerInfo;
use App\Models\customer\CustomerTelecom;
use App\Models\Survey_requests;
use App\Models\SellerInfo;
use App\Models\Services;
use App\Models\UserVisit;
use App\Models\UsrNotification;
use App\Rules\Name;
use Validator;

class AdminController extends Controller
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
        $data['title']              =   'Customer';
        $data['menu']               =   'Customers';
        
        $cust_email = Admin::where('id',auth()->user()->id)->first()->email;
        $cust_id = CustomerMaster::where('username',$cust_email)->first()->id;

        $data['ongoing_surveys'] = Survey_requests::where('cust_id',$cust_id)->where('is_deleted',0)->where('cartographer_request','=',0)->where('is_active',1)->where(function ($query) { $query->where('request_status','!=',1)->Where('request_status','!=',3)->Where('request_status','!=',4);})->count();        
        $data['pending_surveys'] = Survey_requests::where('cust_id',$cust_id)->where('is_deleted',0)->where('cartographer_request','=',0)->where('is_active',1)->where('request_status',1)->count();
        $data['rejected_surveys'] = Survey_requests::where('cust_id',$cust_id)->where('is_deleted',0)->where('cartographer_request','=',0)->where('is_active',1)->where(function ($query) { $query->where('request_status',3)->orWhere('request_status',4);})->count();
        $data['invoice_recieved'] = Survey_requests::where('cust_id',$cust_id)->where('is_deleted',0)->where('cartographer_request','=',0)->where('is_active',1)->whereIn('id',function($query) {
      $query->select('survey_request_id')->from('survey_request_logs')->where('survey_status',51)->groupBy('survey_request_id');})->count();

        
        // dd($data);
        // dd(auth()->user()->id);
        return view('customer.dashboard',$data);
    }

    public function marknotifications(Request $request)
        {
            $notify = UsrNotification::where('role_id',6)->where('id',$request->not_id)->first();
            
            if($notify)
            {
                UsrNotification::where('role_id',6)->where('id',$request->not_id)->update(['viewed'=>1]);
                return true;
            }
            else
            {
                return false;
            }
        }

        function sale_ord_cnt($date){
            $cnt = 0;
            $orders = SalesOrder::where('org_id',1)->where('order_status', '!=', "cancelled")->where('order_status', '!=', "initiated")->whereDate('created_at', '=', date('Y-m-d',strtotime($date)))->sum('g_total');
            if($orders){
                $cnt = $orders;
            }
            return $cnt;
        }
    
        function getDatesFromRange($sStartDate, $sEndDate, $format = 'Y-m-d') {
     $sStartDate = gmdate("Y-m-d H:i:s", strtotime($sStartDate));  
      $sEndDate = gmdate("Y-m-d H:i:s", strtotime($sEndDate));  
 
     $aDays[] = $sStartDate;  
 
     $sCurrentDate = $sStartDate;  

     while($sCurrentDate < $sEndDate){  
       $sCurrentDate = gmdate("Y-m-d H:i:s", strtotime("+1 hour", strtotime($sCurrentDate)));  

       $aDays[] = $sCurrentDate;  
     }  
     return $aDays; 
   
    }
    
    function profile()
    {
        $id = auth()->user()->id;
        $email = auth()->user()->email;

        $cust_id = CustomerMaster::where('username',$email)->first()->id;

        $data['id'] = $id;
        $data['cust_id'] = $cust_id;
        $data['username'] = $email;
        $data['cust_info'] = CustomerInfo::where('cust_id',$cust_id)->first();
        $data['cust_sec'] = CustomerSecurity::where('cust_id',$cust_id)->first();
        $data['cust_mobile'] = CustomerTelecom::where('cust_id',$cust_id)->where('telecom_type',2)->first()->cust_telecom_value;

        // dd($data);

        return view('customer.profile',$data);
    }

    public function edit_profile(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'=>['required','regex:/^[a-zA-Z\s]*$/'],
            'firm'=>['required','regex:/^[a-zA-Z\s]*$/'],
            'firm_type'=>['required','numeric'],
            'email' => ['required','email','max:255',Rule::unique('admins','email')->ignore(auth()->user()->id)],
            'mobile'=>['required','numeric','digits:10'],
            'otp'=> ['nullable','max:255'],
            'valid_id'=>['required','regex:/^[a-zA-Z0-9\s]*$/'],
            'id_file_front' => ['nullable','max:10000'],
            'id_file_back' => ['nullable','max:10000'],
            'password' =>['nullable','confirmed','min:6','max:20'],
            'password_confirmation' =>['nullable','min:6','max:20'],
        ]);
        $input = $request->all();

        // dd($input);

        if($validator->passes())
        {
            $master = CustomerMaster::where('id',$input['cust_id'])->update([
                'username' => $request->email,
                'is_active'=>1,
                'is_deleted'=>0,
                'created_by'=>1,
                'updated_by'=>1,
                'updated_at'=>date("Y-m-d H:i:s")
            ]);

            $info_id = CustomerInfo::where('cust_id',$input['cust_id'])->update([
                'name' => $request->name,
                'firm' => $request->firm,
                'firm_type' => $request->firm_type,
                'valid_id' => $request->valid_id,
                'is_active'=>1,
                'is_deleted'=>0,
                'created_by'=>1,
                'updated_by'=>1,
                'updated_at'=>date("Y-m-d H:i:s")
            ]);

            if(isset($input['password']) && !empty($input['password']))
            {
                $security = CustomerSecurity::where('cust_id',$input['cust_id'])->update([
                    'password' => Hash::make($request->password),
                    'is_active'=>1,
                    'is_deleted'=>0,
                    'created_by'=>1,
                    'updated_by'=>1,
                    'updated_at'=>date("Y-m-d H:i:s")
                ]);
            }

            $telecom_email = CustomerTelecom::where('cust_id',$input['cust_id'])->where('telecom_type',1)->update([
                'cust_telecom_value' => $request->email,
                'is_active'=>1,
                'is_deleted'=>0,
                'created_by'=>1,
                'updated_by'=>1,
                'updated_at'=>date("Y-m-d H:i:s")
            ]);

            $telecom_mobile = CustomerTelecom::where('cust_id',$input['cust_id'])->where('telecom_type',2)->update([
                'cust_telecom_value' => $request->mobile,
                'is_active'=>1,
                'is_deleted'=>0,
                'updated_by'=>1,
                'updated_at'=>date("Y-m-d H:i:s")
            ]);

            if(isset($input['password']) && !empty($input['password']))
            {
                Admin::where('id',$input['id'])->update([
                    'fname' => $request->name,
                    'email' =>$request->email,
                    'phone' => $request->mobile,
                    'password' => Hash::make($request->password),
                    'role_id' => 6,
                    'is_active'=>1,
                    'is_deleted'=>0,
                    'updated_by'=>1,
                    'updated_at'=>date("Y-m-d H:i:s")
                ]);
            }
            else
            {
                Admin::where('id',$input['id'])->update([
                    'fname' => $request->name,
                    'email' =>$request->email,
                    'phone' => $request->mobile,
                    'role_id' => 6,
                    'is_active'=>1,
                    'is_deleted'=>0,
                    'updated_by'=>1,
                    'updated_at'=>date("Y-m-d H:i:s")
                ]);
            }

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

            Session::flash('message', ['text'=>'Profile Updated Successfully !','type'=>'success']);  

            return redirect('customer/profile');
        }
        else
        {
            Session::flash('message', ['text'=>'Profile Not Updated Successfully !','type'=>'danger']);
            return redirect()->back()->withErrors($validator)->withInput($request->all());
        }
    }

    public function search(Request $request)
    {
        $cust_email = Admin::where('id',auth()->user()->id)->first()->email;
        $cust_id = CustomerMaster::where('username',$cust_email)->first()->id;

        $return_data = 0; $type = $id = 0;
        $search = $request->search_val;

        
        if(str_contains($search, 'hsw') || str_contains($search, 'HSW'))
        {
            $search = strtolower($search);
            $search = explode("hsw", $search);
            $search = $search[1];
            $data['results'] = Survey_requests::where('id','LIKE','%'.$search.'%')->where('cust_id',$cust_id)->get();
            $data['type'] = 'survey_request';
        }
        else
        {
            $data['results'] = Services::where('service_name', 'like', '%'. $search .'%')->get();
            $data['type'] = 'service';
        }
        

        return view('customer.search_result',$data);
        
    }

    function validateUser(Request $request){
        $profile                =   $request->post('profile');
        $rules                  =   [
                                        'fname'                 =>  ['required', 'string','max:100', new Name],
                                        'email'                 =>  'required|string|email|max:100',
                                        'phone'                 =>  'required|numeric|digits_between:7,12',
                                    ];
        if($profile['lname']   !=  ''){ $rules['lname']        =   ['required', 'string','max:100', new Name]; }
        $validator              =   Validator::make($profile,$rules);
        $validEmail             =   Admin::ValidateUnique('email',(object)$profile,auth()->user()->id);
        $validPhone             =   Admin::ValidatePhone('phone',(object)$profile,auth()->user()->id);
        if ($validator->fails()) {
           foreach($validator->messages()->getMessages() as $k=>$row){ $error[$k] = $row[0]; }
        }
        if($validEmail){ $error['email']    =   $validEmail; }
        if($validPhone){ $error['phone']    =   $validPhone; }
        if(isset($error)) { return $error; }else{ return 'success'; }
    }
    
    function saveProfile(Request $request){
        $profile                =   Admin::where('id',auth()->user()->id)->update($request->post('profile'));
        if($request->file('avatar') && $request->file('avatar') != ''){
            $image = $request->file('avatar');
            $input['imagename'] = 'avatar.'.$image->extension();
            $path               =   '/app/public/user/'.auth()->user()->id;
            $destinationPath = storage_path($path.'/thumbnail');
            $img = Image::make($image->path());
            if (!file_exists($destinationPath)) { mkdir($destinationPath, 755, true);}
            $img->resize(150, 150, function ($constraint) {
            $constraint->aspectRatio();
            })->save($destinationPath.'/'.$input['imagename']);
            $destinationPath = storage_path($path);
            $image->move($destinationPath, $input['imagename']);
            $imgUpload          =   uploadFile($path,$input['imagename']);
            Admin::where('id',auth()->user()->id)->update(['avatar'=>$path.'/'.$input['imagename']]); 
            }
        if($profile){   return      back()->with('success',' Profile updated successfully! '); }else{ return back(); }
    }
    
    function validatePassword(Request $request){
        $post                   =   (object)$request->post();
        $validator              =   Validator::make($request->post(),['curr_password' => 'required|string|regex:/^\S*$/u','password' => 'required|string|min:6|regex:/^\S*$/u|confirmed']);
        $user                   =   Admin::where('id',auth()->user()->id)->first();
        if ($validator->fails()) {
           foreach($validator->messages()->getMessages() as $k=>$row){ $error[$k] = $row[0]; }
        }
        if (Hash::check($request->curr_password, $user->getOriginal('password'))) {
        }else{ $error['curr_password'] = 'Invalid current password'; }
        if(isset($error)) { return $error; }else{ return 'success';  }
    }
    
    function savePassword(Request $request){
        $res        =   Admin::where('id',auth()->user()->id)->update(['password' => Hash::make($request->post('password'))]);
        if($res){ return 'success'; }else{ return 'error'; }
    }
    
    function adminLogout(){ 
        Auth::logout(); return redirect('customer/login')->header('Cache-Control', 'no-store, no-cache, must-revalidate, post-check=0, pre-check=0, max-age=0');
    }
    
    
    
        
    
        
        //admins list
        public function admins()
        { 
        $data['title']              =   'User';
        $data['menu']               =   'admin-list';
        $data['admins']              =   Admin::where(function ($query) {
    $query->where('is_deleted', '=', NULL)
          ->orWhere('is_deleted', '=', 0);})->orderBy('id', 'DESC')->get();
        // dd($data);
        return view('admin.admins.list',$data);
        }
  public function createAdmin()
        { 
        $data['title']              =   'Create User';
        $data['menu']               =   'create-admin';
        $permanent = array(1,3,4,5,7);
        $data['modules']              =   Admin::where('is_active',1)->where(function ($query) { $query->where('is_deleted', '=', NULL)->orWhere('is_deleted', '=', 0);})->get();
        $data['roles']              =   UserRole::where('is_active',1)->whereNotIn('id', $permanent)->where(function ($query) { $query->where('is_deleted', '=', NULL)->orWhere('is_deleted', '=', 0);})->get();
        $data['c_code']              =   getDropdownData(Country::where('is_deleted',0)->get(),'id','phonecode');
        return view('admin.admins.create',$data);
        }

        public function editAdmin($role_id)
        { 
        $data['title']              =   'Edit User';
        $data['menu']               =   'edit-admin';
        $data['admin']              =   Admin::where('id',$role_id)->first();
        $permanent = array(1,3,4,5,7);
        $data['roles']              =   UserRole::where('is_active',1)->whereNotIn('id', $permanent)->where(function ($query) { $query->where('is_deleted', '=', NULL)->orWhere('is_deleted', '=', 0);})->get();
        $data['c_code']              =   getDropdownData(Country::where('is_deleted',0)->get(),'id','phonecode');
        // dd($data);
        return view('admin.admins.edit',$data);
        }
    
        public function viewAdmin($role_id)
        { 
        $data['title']              =   'View User';
        $data['menu']               =   'view-admin';
        $data['admin']              =   Admin::where('id',$role_id)->first();

        return view('admin.admins.view',$data);
        }

        public function adminSave(Request $request){
        $post           =   (object)$request->post();
        // dd($post);
        $user           =   $post->user; 
        if($post->id    >   0){

           $rules                  =   [
        
        'email'                 =>  'unique:admins,email,' .$post->id,
        'phone'                 =>  'unique:admins,phone,' .$post->id,
        'role_id'                 =>  'required',
        ];
        $validator              =   Validator::make($user,$rules);
        if ($validator->fails()) {
        foreach($validator->messages()->getMessages() as $k=>$row){  $error[$k] = $row[0];
        Session::flash('message', ['text'=>$row[0],'type'=>'danger']); }
        
       return back()->withErrors($validator)->withInput($request->all());
        }

        if($post->user['password']      ==  ''){ unset($post->user['password']); }
        else{ $post->user['password']   =   Hash::make($post->user['password']); }
        $post->user['updated_at']       =   date('Y-m-d H:i:s');
        $insId      =   $post->id; Admin::where('id',$post->id)->update($post->user);   
        $msg        =   'Admin details updated successfully!';
        
        }else{
        
        $rules                  =   [
        
        'email'                 =>  'required|unique:admins,email|email|max:100',
        'phone'                 =>  'required|numeric|unique:admins',
        'role_id'                 =>  'required',
        ];
        $validator              =   Validator::make($user,$rules);
        if ($validator->fails()) {
        foreach($validator->messages()->getMessages() as $k=>$row){  $error[$k] = $row[0];
        Session::flash('message', ['text'=>$row[0],'type'=>'danger']); }
        
       return back()->withErrors($validator)->withInput($request->all());
        }
        
        $post->user['password']         =   Hash::make($post->user['password']);
        $post->user['created_at']       =   date('Y-m-d H:i:s');
        $insId      =   Admin::create($post->user)->id;
        $msg        =   'Admin details added successfully!';
        }
        if($insId){
        
        if($request->file('avatar') && $request->file('avatar') != ''){
        $image = $request->file('avatar');
        $input['imagename'] = rand(100,999).'avatar.'.$image->extension();
        $path               =   '/app/public/user/'.$insId;
        $destinationPath = storage_path($path.'/thumbnail');
        $img = Image::make($image->path());
        if (!file_exists($destinationPath)) { mkdir($destinationPath, 755, true);}
        $img->resize(150, 150, function ($constraint) {
        $constraint->aspectRatio();
        })->save($destinationPath.'/'.$input['imagename']);
        $destinationPath = storage_path($path);
        $image->move($destinationPath, $input['imagename']);
        $imgUpload          =   uploadFile($path,$input['imagename']);
        Admin::where('id',$insId)->update(['avatar'=>$path.'/'.$input['imagename']]); 
        }
        $data['title']              =   'User';
        $data['menu']               =   'admin-list';
        $data['admins']              =   Admin::where('role_id',2)->where(function ($query) {
        $query->where('is_deleted', '=', NULL)
        ->orWhere('is_deleted', '=', 0);})->get();
        // dd($data);
        Session::flash('message', ['text'=>$msg,'type'=>'success']);
        return redirect(route('admin.admins'));
        
        }else{ 
        
        Session::flash('message', ['text'=>"Failed to save details.",'type'=>'danger']);
        
        return redirect(route('admin.admins'));
        }
        }
    
         
        public function adminStatus(Request $request)
        {
        $input = $request->all();
        
        if($input['id']>0) {
        $deleted =  Admin::where('id',$input['id'])->update(array('is_active'=>$input['status']));
        
        return '1';
        }else {
        
        return '0';
        }
        
        }
        
          public function adminDelete(Request $request)
        {
        $input = $request->all();

        if($input['id']>0) {
        $deleted =  Admin::where('id',$input['id'])->update(array('is_deleted'=>1,'is_active'=>0));
        Session::flash('message', ['text'=>'Admin deleted successfully.','type'=>'success']);
        return true;
        }else {
        Session::flash('message', ['text'=>'Admin failed to delete.','type'=>'danger']);
        return false;
        }

        }
        
        public function visitlog(Request $request)
        {
        $input = $request->all();
        $visit_start_date = date('Y-m-d 00:00:00',strtotime($input['startDate']));
        $visit_end_date = date('Y-m-d 11:59:00',strtotime($input['endDate']));
        $web_traffic = UserVisit::where('org_id',1)->whereBetween('visited_on', [$visit_start_date, $visit_end_date])->orderBy('id','desc')->get(); 
        $web_traffic_init = UserVisit::where('org_id',1)->orderBy('visited_on','asc')->first()->visited_on; 
        $web_traffic_till = UserVisit::where('org_id',1)->orderBy('visited_on','desc')->first()->visited_on; 
        $data['web_traffic_init'] = $web_traffic_init;
        $data['web_traffic_till'] = $web_traffic_till;
        $traffic_arr = array(); $tosend_arr = array();
        foreach($web_traffic as $row){
        if(! in_array(strtotime($row->visited_on),$tosend_arr)){
        // $traffic_arr[] = array(strtotime($row->visited_on),UserVisit::getCount($row->visited_on));
        $ret_cnt = 0;
        $cnt             =   UserVisit::where('visited_on',$row->visited_on)->get(); 
        if(count($cnt) >0) {
        $ret_cnt = count($cnt);   
        }
        $timekey = (strtotime($row->visited_on) * 1000);
        $traffic_arr[] = array($timekey,$ret_cnt);
        $tosend_arr[] =strtotime($row->visited_on);
        }
        }

        return json_encode($traffic_arr);

        }

        public function salelog(Request $request)
        {
        $input = $request->all();
        $sale_start_date = date('Y-m-d 00:00:00',strtotime($input['startDate']));
        $sale_end_date = date('Y-m-d 23:59:00',strtotime($input['endDate']));
        $sales_graph = SalesOrder::where('org_id',1)->whereBetween('created_at', [$sale_start_date, $sale_end_date])->where('order_status', '!=', "cancelled")->where('order_status', '!=', "initiated")->orderBy('id','desc')->get(); 
        $sales_arr = array(); $sales_arr_c = array();
       
        foreach($sales_graph as $row){
        if($row->created_at) {
        if(! in_array(strtotime($row->created_at),$sales_arr_c)){
        // $sales_arr[date('Y-m-d',strtotime($row->created_at))] =$this->sale_ord_cnt($row->created_at);

        $sale_timekey = (strtotime(date('Y-m-d',strtotime($row->created_at))) * 1000);
        // $traffic_arr[strtotime($row->visited_on)* 1000] =$ret_cnt;
        $sales_arr[] = array($sale_timekey,$this->sale_ord_cnt($row->created_at));

        $sales_arr_c[] =strtotime($row->created_at);
        }
        }
        }
        

        return json_encode($sales_arr);

        }
		
        
        public function sendmail(){
        $data = array("content"=>"Test");
        echo $mail= mail("sujeesh@estrrado.com","Test","Testing");
        echo $mail= mail("s.sujeesh1993@yahoo.com","Test","Testing");
        echo $var = Mail::send('emails.seller_approved', $data, function($message) use($data) {
        $message->to('s.sujeesh1993@yahoo.com');
        $message->sender('myjewelleryshopper@gmail.com',ucfirst(geSiteName()));
        $message->subject('New email!!!');
        });
        dd($var);
        }

        public function notifications()
        {
            $data['title']           =   'Notifications';
            $data['menu']            =   'notifications';
            $data['notifications']   =   UsrNotification::where('role_id',6)->where('notify_to',auth()->user()->id)->orderby('id','DESC')->get();

            return view('customer.notification',$data);
        }
    
}
