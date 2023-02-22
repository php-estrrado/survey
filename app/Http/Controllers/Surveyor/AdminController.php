<?php

namespace App\Http\Controllers\Surveyor;

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
use App\Models\AdminNotification;
use App\Models\Institution;
use App\Models\UserManagement;
use App\Models\UserRole;
use App\Models\SalesOrder;
use App\Models\Product;
use App\Models\customer\CustomerMaster;
use App\Models\SellerInfo;
use App\Models\UserVisit;
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
        
        return view('surveyor.index');
    }
    
    public function profile()
    {
        $admin_id = auth()->user()->id;
        $email = auth()->user()->email;
        $role_id = auth()->user()->role_id;

        $data['role'] = UserRole::where('id',$role_id)->first()->usr_role_name;
        $data['admin'] = Admin::where('id',$admin_id)->first();
        $data['user'] = UserManagement::where('admin_id',$admin_id)->first();

        $data['institutions'] = Institution::where('is_active',1)->where(function ($query) { $query->where('is_deleted', '=', NULL)->orWhere('is_deleted', '=', 0);})->get();

        // dd($data);
        
        return view('surveyor.profile',$data);
    }

    public function edit_profile(Request $request)
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

        return redirect(route('surveyor.profile'));
    }
    
    function saveProfile(Request $request)
    {
        $profile                =   Admin::where('id',auth()->user()->id)->update($request->post('profile'));
        if($request->file('avatar') && $request->file('avatar') != '')
        {
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
        Auth::logout(); return redirect('surveyor/login')->header('Cache-Control', 'no-store, no-cache, must-revalidate, post-check=0, pre-check=0, max-age=0');
    }

    public function notifications()
    {
        $data['title']           =   'Notifications';
        $data['menu']            =   'notifications';
        $data['notifications']   =   AdminNotification::where('role_id',3)->where('notify_to',auth()->user()->id)->orderby('id','DESC')->get();

        return view('surveyor.notification',$data);
    }
		
    public function sendmail()
    {
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
