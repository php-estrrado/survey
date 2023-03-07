<?php

namespace App\Http\Controllers\Superadmin;

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
use App\Models\Institution;
use App\Models\UserManagement;
use App\Models\UserRole;
use App\Models\UserLogin;
use App\Models\SalesOrder;
use App\Models\Product;
use App\Models\AdminNotification;
use App\Models\customer\CustomerMaster;
use App\Models\SellerInfo;
use App\Models\UserVisit;
use App\Models\Survey_requests;
use App\Models\Services;
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
        $data['title']              =   'User';
        $data['menu']               =   'admin-list';

        $data['ongoing_surveys'] = Survey_requests::where('is_deleted',0)->where('is_active',1)->where(function ($query) { $query->where('request_status','!=',1)->Where('request_status','!=',3)->Where('request_status','!=',4);})->count();        
        $data['pending_surveys'] = Survey_requests::where('is_deleted',0)->where('is_active',1)->where('request_status',1)->count();
        $data['rejected_surveys'] = Survey_requests::where('is_deleted',0)->where('is_active',1)->where(function ($query) { $query->where('request_status',3)->orWhere('request_status',4);})->count();
        $data['pending_signature'] = Survey_requests::where('is_deleted',0)->where('is_active',1)->where('request_status',23)->count();

        /* graph data starts */

        $completed_surveys = [];
        $pending_surveys = [];
            for ($i = 0; $i < 6; $i++) {
            $mo =  date('m', strtotime("-$i month"));
            $year =  date('Y', strtotime("-$i month"));
            $day =  "01";


            $js_date = date('Y/m/d', strtotime("$year/$mo/$day 00:00:00"));
            $completed_surveys[$i] = array('date'=>$js_date,'count'=>Survey_requests::where('is_deleted',0)->where('is_active',1)->whereMonth('created_at', $mo)->whereYear('survey_requests.created_at', $year)->where('request_status',29)->count());
            $pending_surveys[$i] = array('date'=>$js_date,'count'=>Survey_requests::where('is_deleted',0)->where('is_active',1)->whereMonth('created_at', $mo)->whereYear('survey_requests.created_at', $year)->where('request_status',1)->count());


            }

        $data['completed_surveys_grp'] = $completed_surveys;
        $data['pending_surveys_grp'] = $pending_surveys;

        $all_services = Services::where('is_active',1)->where('is_deleted',0)->get();
        $category_requests = []; 
        if($all_services)
        {
        foreach($all_services as $ak=>$av)
        {
        $cat_count = 0;
        $cat_count = Survey_requests::where('service_id',$av->id)->where('is_deleted',0)->where('is_active',1)->where('request_status',1)->count();
        $category_requests[$av->id] = array('name'=>$av->service_name,'count'=>$cat_count);
        }
        }
        $data['completed_surveys'] = $category_requests;

        $total_surveys = Survey_requests::where('is_deleted',0)->where('is_active',1)->count();
        $accepted_surveys = Survey_requests::where('is_deleted',0)->where('is_active',1)->whereNotIn('request_status',[3])->count();

        $data['accepted_surveys_percentage'] = round((($accepted_surveys/$total_surveys)*100), 0);

          /* graph data ends */


        $data['total_surveys'] = Survey_requests::where('is_deleted',0)->where('is_active',1)->count();  
        $data['completed_surveys'] = Survey_requests::where('is_deleted',0)->where('is_active',1)->where('request_status',29)->count(); 
        $data['pending_services'] = Survey_requests::where('is_deleted',0)->where('is_active',1)->whereNotIn('request_status',[29])->count();  
        $data['payment_pending'] = Survey_requests::where('is_deleted',0)->where('is_active',1)->whereNotIn('id',function($query) {
   $query->select('survey_request_id')->from('survey_request_logs')->where('survey_status',58);})->count();  


        //filter data

        $data['filter_institutions'] = Institution::where('is_active',1)->where(function ($query) { $query->where('is_deleted', '=', NULL)->orWhere('is_deleted', '=', 0);})->get();

        $data['filter_services'] =  Services::where('is_active',1)->where('is_deleted',0)->get();
        $data['filter_ams'] =  Admin::where('role_id',3)->where('is_active',1)->where('is_deleted',0)->get();


        $data['view_type']          =   'view';
        $data['requested_services']  =  DB::table('survey_requests')
                                        ->leftjoin('services', 'survey_requests.service_id', '=', 'services.id')
                                        ->leftjoin('survey_status', 'survey_requests.request_status', '=', 'survey_status.id')
                                        ->leftjoin('cust_info', 'survey_requests.cust_id', '=', 'cust_info.cust_id')
                                        ->leftjoin('cust_mst', 'survey_requests.cust_id', '=', 'cust_mst.id')
                                        ->where('survey_requests.is_active',1)->where('survey_requests.is_deleted',0)
                                        ->where('services.is_active',1)->where('services.is_deleted',0)
                                        ->select('survey_requests.id AS survey_id','survey_requests.created_at AS survey_date','survey_requests.*','services.*','cust_info.*','cust_mst.*','survey_status.status_name AS current_status')
                                        ->orderBy('survey_requests.id','DESC')
                                        ->get();

        // dd($data);
        return view('superadmin.index',$data);
    }

    public function search(Request $request)
    {
        $return_data = 0; $type = $id = 0;
        $search = $request->search_val;
        if (str_contains($search, 'hsw') || str_contains($search, 'HSW')) { 
                        $search = strtolower($search);
                        $search = explode("hsw", $search);
                        $search = $search[1];
                        $find = Survey_requests::where('id',$search)->first();
                        if($find)
                        {
                            $current_status = $find->request_status;
                            if($current_status ==1)
                            {
                                $type = "new";
                                $id = $find->id; 
                            }else{
                                $type = $current_status;
                                $id = $id = $find->id;
                            }
                        }
                        }
        return json_encode(array("type"=>$type,"id"=>$id));
        
    }

    public function services(Request $request)
    {
        $data['title']              =   'Dashboard Services';
        $data['menuGroup']          =   'dashboard';
        $data['menu']               =   'dashboard'; 
        $data['view_type']          =   'ajax';
        

        $dashboard_services = DB::table('survey_requests')
                                        ->leftjoin('services', 'survey_requests.service_id', '=', 'services.id')
                                        ->leftjoin('survey_status', 'survey_requests.request_status', '=', 'survey_status.id')
                                        ->leftjoin('cust_info', 'survey_requests.cust_id', '=', 'cust_info.cust_id')
                                        ->leftjoin('cust_mst', 'survey_requests.cust_id', '=', 'cust_mst.id')
                                        ->where('survey_requests.is_active',1)->where('survey_requests.is_deleted',0)
                                        ->where('services.is_active',1)->where('services.is_deleted',0)
                                        ->select('survey_requests.id AS survey_id','survey_requests.created_at AS survey_date','survey_requests.*','services.*','cust_info.name','cust_mst.username','survey_status.status_name AS current_status');

        if($request->filter_institutions)
        {
            $dashboard_services->where('survey_requests.assigned_institution', $request->filter_institutions);
        }
        if($request->filter_services)
        {
            $dashboard_services->where('survey_requests.service_id', $request->filter_services);
        }
        if($request->filter_ams)
        {
            $filter_ams = $request->filter_ams;
            $dashboard_services->where(function ($query) use($filter_ams) { $query->where('survey_requests.assigned_surveyor', '=', $filter_ams)->orWhere('survey_requests.assigned_surveyor_survey', '=', $filter_ams);});

          
        }
        if($request->from_date && $request->to_date)
        {
            $start = $request->from_date; $end = $request->to_date; 
                $dashboard_services->whereBetween('survey_requests.created_at', [$start, $end]);
        }






         $post                       =   (object)$request->post();
         $res = [];
        if(isset($post->vType)       ==  'ajax'){ 
           $search                  =   (isset($post->search['value']))? $post->search['value'] : ''; 
           $start                   =   (isset($post->start))? $post->start : 0; 
           $length                  =   (isset($post->length))? $post->length : 10; 
           $draw                    =   (isset($post->draw))? $post->draw : ''; 
            $totCount                =   $dashboard_services->count(); $filtCount  =  $dashboard_services->count();
           if($search != ''){
                $dashboard_services            =   $dashboard_services->where(function($qry) use ($search){

                        if (str_contains($search, 'hsw') || str_contains($search, 'HSW')) { 
                        $search = strtolower($search);
                        $search = explode("hsw", $search);
                        $search = $search[1];
                        $qry->where('survey_requests.id', 'like', '%'.$search.'%');
                        }else{
                                             $qry->where('service_name', 'like', '%'.$search.'%');
                                            $qry->orwhere('cust_info.name', 'like', '%'.$search.'%');
                                            $qry->orwhere('username', 'like', '%'.$search.'%');                           
                        }

                                  
                                        });
                $filtCount          =   $dashboard_services->count();
           }
           if($length > 0){$dashboard_services =   $dashboard_services->offset($start)->limit($length); }
           $activities              =   $dashboard_services->get(); $i=0;
           if($activities){ foreach (   $activities as $row){ $i++;
               if($row->is_active   ==  1){ $checked    = 'checked="checked"'; $act = 'Active'; }else{ $checked = '';  $act = 'Inactive'; }
             
               // $val['id']           =   $row->id;       
               $val['i']      =   $i;       
               $val['name']      =   $row->name; 
               $val['file_no']      =   '<a href="'.URL('/customer/request_service_detail').'/'.$row->survey_id.'/'.$row->request_status.'">HSW'.$row->survey_id.'</a>'; 
               $val['sub_office']      =   findSubOffice($row->id); 
               $val['email']      =   $row->username; 
               $val['requested_service']      =   $row->service_name; 
               $val['status']      =   $row->current_status;
                $val['progress']      =   ' <div class="progress-bar-cust position" data-percent='. request_progress($row->survey_id) .' data-color="#ccc,#4aa4d9" ></div>'; 

               $action ='';
               $val['action']       =   $action; $res[] = $val;  
           } }
           $returnData = array(
            "draw"            => $draw,   
            "recordsTotal"    => $totCount,  
            "recordsFiltered" => $filtCount,
            "data"            => $res   // total data array
            );
            return $returnData;
        }

        return view('superadmin.dashboard-service-list',$data);
    }
    
    public function profile()
    {
        $admin_id = auth()->user()->id;
        $email = auth()->user()->email;
        $role_id = 1;

        $data['role'] = UserRole::where('id',$role_id)->first()->usr_role_name;
        $data['admin'] = Admin::where('id',$admin_id)->first();
        $data['user'] = UserManagement::where('admin_id',$admin_id)->first();

        $data['institutions'] = Institution::where('is_active',1)->where(function ($query) { $query->where('is_deleted', '=', NULL)->orWhere('is_deleted', '=', 0);})->get();

        // dd($data);
        
        return view('superadmin.profile',$data);
    }

    public function edit_profile(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name'=>['required','regex:/^[a-zA-Z\s]*$/'],
            'phone'=>['required','numeric','digits:10'],
            'email' => ['required','email','max:255',Rule::unique('usr_management','email')->ignore($request->admin_id)],
            'designation'=>['required','regex:/^[a-zA-Z\s]*$/'],
            'pen'=>['required','regex:/^[a-zA-Z0-9\s]*$/'],
            'avatar' => ['nullable','max:10000'],
            'institution' =>['nullable','confirmed','min:6']
        ]);

        if($validator->passes())
        {
            $input = $request->all();

            $admin_arr = [];
            $admin_arr['fname'] = $input['name'];
            $admin_arr['email'] = $input['email'];
            $admin_arr['phone'] = $input['phone'];
            $admin_arr['is_active'] = 1;
            $admin_arr['is_deleted'] = 0;
            $admin_arr['updated_by'] = auth()->user()->id;
            $admin_arr['updated_at'] = date("Y-m-d H:s:i");

            Admin::where('id',$input['admin_id'])->update($admin_arr);

            $usr_arr = [];
            $usr_arr['fullname'] = $input['name'];
            $usr_arr['email'] = $input['email'];
            $usr_arr['phone'] = $input['phone'];
            $usr_arr['designation'] = $input['designation'];
            $usr_arr['pen'] = $input['pen'];
            $usr_arr['institution'] = $input['institution'];
            $usr_arr['is_active'] = 1;
            $usr_arr['is_deleted'] = 0;
            $usr_arr['updated_by'] = auth()->user()->id;
            $usr_arr['updated_at'] = date("Y-m-d H:s:i");

            UserManagement::where('admin_id',$input['admin_id'])->update($usr_arr);

            if($request->hasfile('avatar'))
            {
                $file = $request->avatar;
                $folder_name = "uploads/profile_images/";

                $upload_path = base_path() . '/public/' . $folder_name;

                $extension = strtolower($file->getClientOriginalExtension());

                $filename = "profile" . '_' . time() . '.' . $extension;

                $file->move($upload_path, $filename);

                $file_path = config('app.url') . "/public/$folder_name/$filename";

                Admin::where('id',$input['admin_id'])->update([
                    'avatar' => $file_path,
                    'updated_by'=>auth()->user()->id,
                    'updated_at'=>date("Y-m-d H:i:s")
                ]);
                
                UserManagement::where('admin_id',$input['admin_id'])->update([
                    'avatar' => $file_path,
                    'updated_by'=>auth()->user()->id,
                    'updated_at'=>date("Y-m-d H:i:s")
                ]);
            }

            return redirect(route('superadmin.profile'));
        }
        else
        {
            return redirect()->back()->withErrors($validator)->withInput($request->all());
        }
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
        Auth::logout(); return redirect('superadmin/login')->header('Cache-Control', 'no-store, no-cache, must-revalidate, post-check=0, pre-check=0, max-age=0');
    }
    
    
    
        
    
        
        //admins list
    public function admins()
    { 
        $data['title']              =   'User';
        $data['menu']               =   'admin-list';
        $data['admins']              =   Admin::where(function ($query) {
            $query->where('is_deleted', '=', NULL)->orWhere('is_deleted', '=', 0)->where('role_id','!=',6);})->orderBy('id', 'DESC')->get();
        $data['users'] = UserManagement::where(function ($query) {
            $query->where('is_deleted', '=', NULL)->orWhere('is_deleted', '=', 0)->where('role','!=',6);})->orderBy('id', 'DESC')->get();

        // dd($data);
        
        return view('superadmin.users',$data);
    }
    
    public function createAdmin()
    { 
        $data['title']    =   'Create User';
        $data['menu']     =   'create-admin';
        $data['modules']  =   Admin::where('is_active',1)->where(function ($query) { $query->where('is_deleted', '=', NULL)->orWhere('is_deleted', '=', 0)->where('role_id','!=',6);})->get();
        $data['roles']    =   UserRole::where('is_active',1)->where(function ($query) { $query->where('is_deleted', '=', NULL)->orWhere('is_deleted', '=', 0);})->get();
        $data['institutions'] = Institution::where('is_active',1)->where(function ($query) { $query->where('is_deleted', '=', NULL)->orWhere('is_deleted', '=', 0);})->get();
        // $data['c_code']   =   getDropdownData(Country::where('is_deleted',0)->get(),'id','phonecode');

        // dd($data);
        return view('superadmin.add-users',$data);
    }

    public function editAdmin($admin_id)
    { 
        $data['title']    =   'Edit User';
        $data['menu']     =   'edit-admin';
        $data['admin']    =   Admin::where('id',$admin_id)->first();
        $data['users']    =   UserManagement::where('admin_id',$admin_id)->first();
        $data['roles']    =   UserRole::where('is_active',1)->where(function ($query) { $query->where('is_deleted', '=', NULL)->orWhere('is_deleted', '=', 0);})->get();
        $data['institutions'] = Institution::where('is_active',1)->where(function ($query) { $query->where('is_deleted', '=', NULL)->orWhere('is_deleted', '=', 0);})->get();
        // $data['c_code']              =   getDropdownData(Country::where('is_deleted',0)->get(),'id','phonecode');
        // dd($data);
        return view('superadmin.edit-users',$data);
    }
    
    public function viewAdmin($role_id)
    { 
        $data['title']              =   'View User';
        $data['menu']               =   'view-admin';
        $data['admin']              =   Admin::where('id',$role_id)->first();

        return view('admin.admins.view',$data);
    }

    public function adminSave(Request $request)
    {
        $input = $request->all();

        if($input['id'] > 0)
        {
            $validator = $request->validate([
                'name'           =>  ['required','max:100'],
                'email'          =>  ['required',Rule::unique('admins')->ignore($input['id'])->where('is_deleted',0),'email','max:100'],
                'phone'          =>  ['required','numeric',Rule::unique('admins')->ignore($input['id'])->where('is_deleted',0)],
                'designation'    =>  ['required','max:100'],
                'role_id'        =>  ['required'],
                'pen'            =>  ['required'],
                'institution'    =>  ['required'],
            ],
            [],
            [
                'name' => 'User Name',
                'email' => 'User Email',
                'phone' => 'User Phone',
                'designation' => 'User Designation',
                'role_id' => 'User Role',
                'pen' => 'PEN Number',
                'institution' => 'User Institution',
            ]);
            // if ($validator->fails()) 
            // {
            //     foreach($validator->messages()->getMessages() as $k=>$row)
            //     {
            //         $error[$k] = $row[0];
            //         Session::flash('message', ['text'=>$row[0],'type'=>'danger']);
            //     }
    
            //     return back()->withErrors($validator)->withInput($request->all());
            // }

            if($input['role_id'] == 3)
            {
                $token1   =   $input['id'].substr(str_shuffle('0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ'),0,12);
                $token2   =   $input['id'].substr(str_shuffle('0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ'),0,12);

                $admin_arr = [];
                $admin_arr['fname'] = $input['name'];
                $admin_arr['email'] = $input['email'];
                $admin_arr['phone'] = $input['phone'];
                $admin_arr['password'] = Hash::make('123456');
                $admin_arr['role_id'] = $input['role_id'];
                $admin_arr['is_active'] = 1;
                $admin_arr['is_deleted'] = 0;
                $admin_arr['created_by'] = 1;
                $admin_arr['updated_by'] = 1;
                $admin_arr['created_at'] = date("Y-m-d H:s:i");
                $admin_arr['updated_at'] = date("Y-m-d H:s:i");

                Admin::where('id',$input['id'])->update($admin_arr);

                $usr_arr = [];
                $usr_arr['fullname'] = $input['name'];
                $usr_arr['email'] = $input['email'];
                $usr_arr['phone'] = $input['phone'];
                $usr_arr['designation'] = $input['designation'];
                $usr_arr['role'] = $input['role_id'];
                $usr_arr['pen'] = $input['pen'];
                $usr_arr['institution'] = $input['institution'];
                $usr_arr['userparent'] = $input['parent_id'];
                $usr_arr['is_active'] = 1;
                $usr_arr['is_deleted'] = 0;
                $usr_arr['created_by'] = 1;
                $usr_arr['updated_by'] = 1;
                $usr_arr['created_at'] = date("Y-m-d H:s:i");
                $usr_arr['updated_at'] = date("Y-m-d H:s:i");

                UserManagement::where('admin_id',$input['id'])->update($usr_arr);

                $usr_log_arr = [];

                $usr_log_arr['device_id'] = 1234;
                $usr_log_arr['access_token'] = $token1;
                $usr_log_arr['device_token'] = $token2;
                $usr_log_arr['updated_at'] = date("Y-m-d H:s:i");

                UserLogin::where('user_id',$input['id'])->update($usr_log_arr);
            }
            else
            {
                $admin_arr = [];
                $admin_arr['fname'] = $input['name'];
                $admin_arr['email'] = $input['email'];
                $admin_arr['phone'] = $input['phone'];
                $admin_arr['password'] = Hash::make('123456');
                $admin_arr['role_id'] = $input['role_id'];
                $admin_arr['is_active'] = 1;
                $admin_arr['is_deleted'] = 0;
                $admin_arr['created_by'] = 1;
                $admin_arr['updated_by'] = 1;
                $admin_arr['created_at'] = date("Y-m-d H:s:i");
                $admin_arr['updated_at'] = date("Y-m-d H:s:i");

                Admin::where('id',$input['id'])->update($admin_arr);

                $usr_arr = [];
                $usr_arr['fullname'] = $input['name'];
                $usr_arr['email'] = $input['email'];
                $usr_arr['phone'] = $input['phone'];
                $usr_arr['designation'] = $input['designation'];
                $usr_arr['role'] = $input['role_id'];
                $usr_arr['pen'] = $input['pen'];
                $usr_arr['institution'] = $input['institution'];
                $usr_arr['userparent'] = $input['parent_id'];
                $usr_arr['is_active'] = 1;
                $usr_arr['is_deleted'] = 0;
                $usr_arr['created_by'] = 1;
                $usr_arr['updated_by'] = 1;
                $usr_arr['created_at'] = date("Y-m-d H:s:i");
                $usr_arr['updated_at'] = date("Y-m-d H:s:i");

                UserManagement::where('admin_id',$input['id'])->update($usr_arr);
            }
            
            $msg    =   'Admin details added successfully!';

            $admin_id      =  $input['id']; 
            $msg        =   'Admin details updated successfully!';        
        }
        else
        {
            $validator = $request->validate([
                'name'           =>  ['required','max:100'],
                'email'          =>  ['required','unique:admins,email','email','max:100'],
                'phone'          =>  ['required','numeric','unique:admins'],
                'designation'    =>  ['required','max:100'],
                'role_id'        =>  ['required'],
                'pen'            =>  ['required'],
                'institution'    =>  ['required'],
            ],
            [],
            [
                'name' => 'User Name',
                'email' => 'User Email',
                'phone' => 'User Phone',
                'designation' => 'User Designation',
                'role_id' => 'User Role',
                'pen' => 'PEN Number',
                'institution' => 'User Institution',
            ]);
            // if ($validator->fails()) 
            // {
            //     foreach($validator->messages()->getMessages() as $k=>$row)
            //     {
            //         $error[$k] = $row[0];
            //         Session::flash('message', ['text'=>$row[0],'type'=>'danger']);
            //     }
    
            //     return back()->withErrors($validator)->withInput($request->all());
            // }

            // echo 'Validator passed';
            // exit;
            if($input['role_id'] == 3)
            {
                $token1   =   $input['id'].substr(str_shuffle('0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ'),0,12);
                $token2   =   $input['id'].substr(str_shuffle('0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ'),0,12);

                $admin_arr = [];
                $admin_arr['fname'] = $input['name'];
                $admin_arr['email'] = $input['email'];
                $admin_arr['phone'] = $input['phone'];
                $admin_arr['password'] = Hash::make('123456');
                $admin_arr['role_id'] = $input['role_id'];
                $admin_arr['is_active'] = 1;
                $admin_arr['is_deleted'] = 0;
                $admin_arr['created_by'] = auth()->user()->id;
                $admin_arr['updated_by'] = auth()->user()->id;
                $admin_arr['created_at'] = date("Y-m-d H:s:i");
                $admin_arr['updated_at'] = date("Y-m-d H:s:i");

                $admin_id = Admin::create($admin_arr)->id;

                $usr_arr = [];
                $usr_arr['fullname'] = $input['name'];
                $usr_arr['admin_id'] = $admin_id;
                $usr_arr['email'] = $input['email'];
                $usr_arr['phone'] = $input['phone'];
                $usr_arr['designation'] = $input['designation'];
                $usr_arr['role'] = $input['role_id'];
                $usr_arr['pen'] = $input['pen'];
                $usr_arr['institution'] = $input['institution'];
                $usr_arr['userparent'] = $input['parent_id'];
                $usr_arr['is_active'] = 1;
                $usr_arr['is_deleted'] = 0;
                $usr_arr['created_by'] = auth()->user()->id;
                $usr_arr['updated_by'] = auth()->user()->id;
                $usr_arr['created_at'] = date("Y-m-d H:s:i");
                $usr_arr['updated_at'] = date("Y-m-d H:s:i");

                $user_id = UserManagement::create($usr_arr)->id;

                $usr_log_arr = [];
                $usr_log_arr['user_id'] = $admin_id;
                $usr_log_arr['device_id'] = 1234;
                $usr_log_arr['access_token'] = $token1;
                $usr_log_arr['device_token'] = $token2;
                $usr_log_arr['created_at'] = date("Y-m-d H:s:i");
                $usr_log_arr['updated_at'] = date("Y-m-d H:s:i");

                UserLogin::create($usr_log_arr);
            }
            else
            {
                $admin_arr = [];
                $admin_arr['fname'] = $input['name'];
                $admin_arr['email'] = $input['email'];
                $admin_arr['phone'] = $input['phone'];
                $admin_arr['password'] = Hash::make('123456');
                $admin_arr['role_id'] = $input['role_id'];
                $admin_arr['is_active'] = 1;
                $admin_arr['is_deleted'] = 0;
                $admin_arr['created_by'] = auth()->user()->id;
                $admin_arr['updated_by'] = auth()->user()->id;
                $admin_arr['created_at'] = date("Y-m-d H:s:i");
                $admin_arr['updated_at'] = date("Y-m-d H:s:i");

                $admin_id = Admin::create($admin_arr)->id;

                $usr_arr = [];
                $usr_arr['fullname'] = $input['name'];
                $usr_arr['admin_id'] = $admin_id;
                $usr_arr['email'] = $input['email'];
                $usr_arr['phone'] = $input['phone'];
                $usr_arr['designation'] = $input['designation'];
                $usr_arr['role'] = $input['role_id'];
                $usr_arr['pen'] = $input['pen'];
                $usr_arr['institution'] = $input['institution'];
                $usr_arr['userparent'] = $input['parent_id'];
                $usr_arr['is_active'] = 1;
                $usr_arr['is_deleted'] = 0;
                $usr_arr['created_by'] = auth()->user()->id;
                $usr_arr['updated_by'] = auth()->user()->id;
                $usr_arr['created_at'] = date("Y-m-d H:s:i");
                $usr_arr['updated_at'] = date("Y-m-d H:s:i");

                $user_id = UserManagement::create($usr_arr)->id;
            }

            $msg    =   'User details added successfully!';
        }
        if($admin_id)
        {
            if($request->file('avatar') && $request->file('avatar') != '')
            {
                $image = $request->file('avatar');
                $input['imagename'] = rand(100,999).'avatar.'.$image->extension();
                $path               =   '/app/public/user/'.$admin_id;
                $destinationPath = storage_path($path.'/thumbnail');
                $img = Image::make($image->path());
                if (!file_exists($destinationPath)) { mkdir($destinationPath, 755, true);}
                $img->resize(150, 150, function ($constraint) {
                    $constraint->aspectRatio();
                })->save($destinationPath.'/'.$input['imagename']);
                $destinationPath = storage_path($path);
                $image->move($destinationPath, $input['imagename']);
                // $imgUpload          =   uploadFile($path,$input['imagename']);
                Admin::where('id',$admin_id)->update(['avatar'=>$path.'/'.$input['imagename']]);
                UserManagement::where('admin_id',$admin_id)->update(['avatar'=>$path.'/'.$input['imagename']]);
            }
            $data['title']              =   'User';
            $data['menu']               =   'admin-list';
            $data['admins']              =   Admin::where('role_id',2)->where(function ($query) {
                $query->where('is_deleted', '=', NULL)->orWhere('is_deleted', '=', 0);})->get();
            // dd($data);
            Session::flash('message', ['text'=>$msg,'type'=>'success']);
            return redirect(route('superadmin.admins'));
        }
        else
        {
            Session::flash('message', ['text'=>"Failed to save details.",'type'=>'danger']);
        
            return redirect(route('superadmin.admins'));
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
                $admin_delete =  Admin::where('id',$input['id'])->update(array('is_deleted'=>1,'is_active'=>0));
                $user_delete  =  UserManagement::where('admin_id',$input['id'])->update(array('is_deleted'=>1,'is_active'=>0));

                Session::flash('message', ['text'=>'User deleted successfully.','type'=>'success']);

                return true;
            }
            else
            {
                Session::flash('message', ['text'=>'User failed to delete.','type'=>'danger']);
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

        public function notifications()
        {
            $data['title']           =   'Notifications';
            $data['menu']            =   'notifications';
            $data['notifications']   =   AdminNotification::where('role_id',1)->orderby('id','DESC')->get();

            return view('superadmin.notification',$data);
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
    
}
