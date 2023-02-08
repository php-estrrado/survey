<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Session;
use DB;
use Mail;
use App\Models\Country;
use App\Models\Modules;
use App\Models\UserRoles;
use App\Models\Admin;
use App\Models\UserRole;
use App\Models\SaleOrder;
use App\Models\SaleorderItems;
use App\Models\SellerTelecom;
use App\Models\SellerAddress;
use App\Models\customer\CustomerMaster;
use App\Models\customer\CustomerInfo;
use App\Models\customer\CustomerSecurity;
use App\Models\customer\CustomerTelecom;
use App\Models\customer\CustomerAddress;
use App\Models\customer\CustomerPoints;
use App\Rules\Name;
use App\Models\Reward;
use App\Models\CustomerWallet_Model;
use Validator;
use Illuminate\Support\Facades\Hash;
use GuzzleHttp\Client;

class CustomerController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }


    public function index($type=NULL)
    {
        $data['title']              =   'Customer';
        $data['menu']               =   'Customer List';
        $data['role']               =    UserRole::where('is_deleted',NULL)->orWhere('is_deleted',0)->where('usr_role_name','Customer')->where('is_active',1)->get();
        if(isset($type) && $type=='today')
        {
            // $data['customer']           =    CustomerMaster::where('is_deleted',NULL)->orWhere('is_deleted',0)->whereDate('created_at', '=', date('Y-m-d'))->orderBy('id','DESC')->get();    
        }
        else
        {
            $data['customers'] = DB::table('cust_mst')
                ->join('cust_info', 'cust_mst.id', '=', 'cust_info.cust_id')
                ->join('cust_telecom', 'cust_mst.id', '=', 'cust_telecom.cust_id')
                ->where('cust_mst.is_deleted',NULL)->orWhere('cust_mst.is_deleted',0)
                ->where('cust_telecom.is_deleted',NULL)->orWhere('cust_telecom.is_deleted',0)->where('cust_telecom.telecom_type',2)
                ->select('cust_mst.*','cust_info.*', 'cust_telecom.*')
                ->orderBy('cust_mst.id','DESC')
                ->get();
        
            // dd($data);
        
            // $data['customer']           =    CustomerMaster::where('is_deleted',NULL)->orWhere('is_deleted',0)->orderBy('id','DESC')->get();
        }
        
        // $data['countries']          =    Country::all();
        return view('superadmin.customers', $data);
    }

    public function createCustomers()
    {
        $data['countries'] = Country::where('is_deleted',0)->get();

        // dd($data);
        return view('superadmin.add-customers',$data);
    }

    public function customerSave(Request $request)
    {
        $input = $request->all();
        // dd($input);

        $validator = Validator::make($request->all(), [
            'full_name'=>['required','max:255'],
            'firm'=>['required','max:255'],
            'country'=>['required'],
            'email' => ['required','email','max:255','unique:cust_mst,username'],
            'mobile'=>['required','max:255'],
            'valid_id'=>['nullable','max:255'],
            'password' =>['required','confirmed','min:6']
        ]);

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
                'name' => $request->full_name,
                'valid_id' => $request->valid_id,
                'firm' => $request->firm,
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
                'fname' => $request->full_name,
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

            return redirect('/superadmin/customers');
        }
        else
        {
            return redirect()->back()->withErrors($validator)->withInput($request->all());
        }
        
    }

    public function view_customer($user_id)
    {
        $data['title']              =   'Customer Info';
        $data['menu']               =   'Customer Details';
        $data['role']               =    UserRole::where('is_deleted',NULL)->orWhere('is_deleted',0)->where('usr_role_name','Customer')->where('is_active',1)->get();
        $data['customer_mst']       =    CustomerMaster::where('is_deleted',0)->where('id',$user_id)->first();
        $data['telecom']            =    CustomerTelecom::where('user_id',$user_id)->where('is_deleted',0)->get();
        $data['customer_addr']       =    CustomerAddress::where('is_deleted',0)->where('user_id',$user_id)->get();
        $data['info']               =    CustomerInfo::where('user_id',$user_id)->where('is_deleted',0)->first();
        $data['wallet']             =    DB::table("usr_cust_wallet")->select(DB::raw("SUM(credit)-SUM(debit) as wallet"))->where("is_deleted",0)->where("user_id",$user_id)->first();
        $data['order']              =    SaleOrder::whereNotIn('order_status',['initiated'])->where('cust_id',$user_id)->get();
        $data['tot_order']          =    SaleOrder::whereNotIn('order_status',['initiated'])->where('cust_id',$user_id)->count();
        $data['sale_amt']           =    SaleOrder::whereNotIn('order_status',['initiated'])->where('cust_id',$user_id)->sum('g_total'); 
        $data['order_cancel']       =    SaleOrder::where('cust_id',$user_id)->where('order_status','cancelled')->count();
        $data['order_refund']       =    SaleOrder::where('cust_id',$user_id)->where('order_status','refund')->count();
        $data['customer_points']    =    CustomerPoints::where('user_id',$user_id)->where('is_deleted','0')->selectRaw('SUM(credit) - SUM(debit) as bal')->first()->bal;
        // dd($data);
        return view('admin.customer.view_customer', $data);
    }

    public function update_profile(Request $request,$user_id)
    {  
        
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|max:255',
            'last_name' => 'required|max:255',
            'email' => 'required',
            'number'=>'required',
            'status'=>'required',
            'number'=>'required|min:10'
        ]);

        if ($validator->passes()) {
            
            if($request->hasFile('profile_img'))
            {
            $file=$request->file('profile_img');
            $extention=$file->getClientOriginalExtension();
            $filename=time().'.'.$extention;
            $file->move(('storage/app/public/customer_profile/'),$filename);
            
            CustomerInfo::where('user_id',$user_id)->where('is_active',1)->update([
                'profile_image'=>$filename,
                'updated_by'=>auth()->user()->id,
                'updated_at'=>date("Y-m-d H:i:s")]);
           // dd($filename);
            }

            CustomerMaster::where('id',$user_id)->update([
                'is_active' => $request->status,
                'updated_by'=>auth()->user()->id,
                'updated_at'=>date("Y-m-d H:i:s")]);

            CustomerInfo::where('user_id',$user_id)->update([
                'first_name' => $request->first_name,
                'last_name' =>$request->last_name,
                'is_active'=>$request->status,
                'updated_by'=>auth()->user()->id,
                'updated_at'=>date("Y-m-d H:i:s")]);

            CustomerTelecom::where('user_id',$user_id)->where('is_active',1)->where('usr_telecom_typ_id',1)->update([
                    'usr_telecom_value' => $request->email,
                    'updated_by'=>auth()->user()->id,
                    'updated_at'=>date("Y-m-d H:i:s")]);  
             
            $teledata=CustomerTelecom::where('user_id',$user_id)->where('is_active',1)->where('usr_telecom_typ_id',2)->first();
            if(is_null($teledata)){
                CustomerTelecom::create(['org_id' => 1,
           'user_id' => $user_id,
           'usr_telecom_typ_id'=>2,
           'usr_telecom_value'=>$request->number,
           'is_active'=>$request->status,
           'is_deleted'=>0,
           'created_by'=>auth()->user()->id,
           'updated_by'=>auth()->user()->id,
           'created_at'=>date("Y-m-d H:i:s"),
           'updated_at'=>date("Y-m-d H:i:s")]);  
            
            }
            else
            {
             CustomerTelecom::where('user_id',$user_id)->where('is_active',1)->where('usr_telecom_typ_id',2)->update([
                        'usr_telecom_typ_id'=>2,
                        'usr_telecom_value' => $request->number,
                        'is_active'=>1,
                        'updated_by'=>auth()->user()->id,
                        'updated_at'=>date("Y-m-d H:i:s")]); 
            }
            
            //CRM UPDATE
            $crmMaster = CustomerMaster::where('id',$user_id)->first()->crm_unique_id;
            if($crmMaster>0)
            {
                $crmMasterID=$crmMaster;
            }
            else
            {
                $crmMasterID=0;
            }
            $headers[] = 'Content-Type: application/json';
           $datapass = json_encode(array(
            //'unique_id'=>$masterId,
            'Customer_Id'=>$crmMasterID,
            'CustomerName' => $request->first_name.' '.$request->last_name,
            'emailid' => $request->email,
           // 'MobileNo'=> $request->phone_number,
            'CustomerStatus'=>true,
            'GSTNomber'=>'',
            'CustomerPOCName'=>$request->first_name,
            'DivisionId'=>config('crm.divId'),
            'Street'=>'NULL',
            'City'=>'NULL',
            'Country'=>'NULL',
            'State'=>'NULL',
            'Customer_Type_Id'=>'',
            'CustomerCode'=>'',
            'IsNDPApplicable'=>true,
            'AuthorityApproval'=>false,
            'ActiveFlag'=>'',
            'BranchId'=>0,
            'UserId'=>config('crm.userID'),
            'OrganisationId'=>config('crm.orgId'),
            'IndustryID'=>'',
            'SourceID'=>'',
            'HowToJoin'=>'',
            'HowToServeUrself'=>'',
            'Typology'=>'',
            'HowIsStoreFront'=>'',
            'StoreInterior'=>'',
            'Ambience'=>'',
            'MainNeeds'=>'',
            'Competitors'=>'',
            'BusinessType'=>'',
            'NoOfSeats'=>'',
            'TurnOver'=>'',
            'StoreFile'=>'',
            'CRFile'=>'',
            'VATFile'=>'',
            'MenuFile'=>'',
            'crno'=>'',
            'vatno'=>'',
            'mobileno1'=>$request->number,
            'mobileno2'=>'',
            'landline'=>'',
            'Need'=>'',
            //'Quantity'=>'',
            'PinCode'=>'',
            'DistrictName'=>'',
            'Latitude'=>'',
            'Longitude'=>'',
        ));
           // $url_cust_reg = config('crm.customer_api');
           // // $ch = curl_init();
           // //  curl_setopt($ch, CURLOPT_URL,$url_cust_reg);
           // //  curl_setopt($ch, CURLOPT_POST, 1);
           // //  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
           // //  curl_setopt($ch, CURLOPT_POSTFIELDS, $datapass);           
           // // // curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
           // //  $response = curl_exec($ch);
           // //  $err = curl_error($ch);
           // //  $statusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            
           // //  curl_close($ch);
           // //  return $err;die;
           // //  $return_response = json_decode($response);
            
            
            CustomerMaster::where('id',$user_id)->update(['crm_unique_id'=>$return_response->data->Customer_Id,'customer_code'=>$return_response->data->CustomerCode]);
            //**end CRM
            
             Session::flash('message', ['text'=>'Customer updated successfully.','type'=>'success']);
                        
                        return redirect(url('admin/customer/view/'.$user_id));           
        }

    }
    
     public function invoice($id)
    {
        $data['title']              =   'Invoice';
        $data['menu']               =   'Invoice';
        $data['order']              =    SaleOrder::where('id',$id)->first();
        $user_id = $data['order']->cust_id; 
        $data['user_id']               =   $user_id;
        
        $data['customer_mst']       =    CustomerMaster::where('is_deleted',0)->where('id',$user_id)->first();
        $data['telecom']            =    CustomerTelecom::where('user_id',$user_id)->where('is_active',1)->where('is_deleted',0)->get();
        $data['info']               =    CustomerInfo::where('user_id',$user_id)->where('is_active',1)->where('is_deleted',0)->first();
        $data['wallet']             =    DB::table("usr_cust_wallet")->select(DB::raw("SUM(credit)-SUM(debit) as wallet"))->where("is_deleted",0)->where("user_id",$user_id)->first();
        
       $data['seller_address']  = SellerAddress::where('seller_id',auth()->user()->id)->where('is_deleted',0)->first();
       if($data['seller_address']) {
        $data['seller_address_city']  = getCities($data['seller_address']->city_id);
       }
        $data['order_items']             = SaleorderItems::where('sales_id',$id)->get();
       
        // dd($data);
        return view('admin.customer.invoice', $data);
    }

    //CUSTOMER REQUEST

    public function request_index()
    {
        $data['title']              =   'New Customers Request List';
        $data['menu']               =   'customer-request';
        // $data['role']               =    UserRole::where('is_deleted',NULL)->orWhere('is_deleted',0)->where('usr_role_name','Customer')->where('is_active',1)->get();
        $data['customer']           =    CustomerMaster::whereIn('is_approved',[0,2])->where('is_deleted',0)->orderBy('id','DESC')->get();
        return view('admin.customer.request.page', $data);
    }

    public function request_cust_view(Request $request,$user_id)
    {
        $data['title']              =   'New Customers Request List';
        $data['menu']               =   'customer-request';
        // $data['role']               =    UserRole::where('is_deleted',NULL)->orWhere('is_deleted',0)->where('usr_role_name','Customer')->where('is_active',1)->get();
        $data['customer']           =    CustomerMaster::where('id',$user_id)->first();
        return view('admin.customer.request.view', $data);
    }

    
    function base64_encode_html_image($img_file, $alt = null, $cache = false, $ext = null)
    {
      if (!is_file($img_file)) {
        return false;
      }
    
      $b64_file = "{$img_file}.b64";
      if ($cache && is_file($b64_file)) {
        $b64 = file_get_contents($b64_file);
      } else {
        $bin = file_get_contents($img_file);
        $b64 = base64_encode($bin);
    
        if ($cache) {
          file_put_contents($b64_file, $b64);
        }
      }
    
      if (!$ext) {
        $ext = pathinfo($img_file, PATHINFO_EXTENSION);
      }
    
      return "{$b64}";
    }

     public function updateStatus(Request $request)
    { 
        $post = (object)$request->post();
        //return $post;
        if($post->field=='is_approved'){

        $update = CustomerMaster::where('id',$post->id)->update(['is_approved'=>$post->value]);
        if($post->value==1)
        {


           // $headers[] = 'Content-Type: application/json';
           //  if(authenticateOdoo()){
           //    $headers[] = 'Cookie: '.authenticateOdoo();  
           //  }
            
           //  $cust_mst =CustomerMaster::where('id',$post->id)->first();
           //  $customer_email=$cust_mst->custEmail($cust_mst->email);

           //  if($cust_mst->info->profile_image !="")
           //  {
           //      $prof_img = storage_path('/app/public/customer_profile/'.$cust_mst->info->profile_image);
           //      $base64_img = $this->base64_encode_html_image($prof_img, '1x1');

           //  }else{
           //      $base64_img = "";
           //  }

           //  // dd($base64_img);

           //  $datapass = json_encode(array(
           //  'jsonrpc'=>"2.0",
           //  'method'=>"call",
           //  'params'=>array(
           //  'model'=>"res.partner",
           //  'method'=>"create_customer",
           //  'args'=>[[]],
           //  'kwargs'=>array(
           //      'vals'=>array(
           //          'first_name'=>$cust_mst->info->first_name,
           //          'last_name'=>$cust_mst->info->last_name,
           //          'email'=>$customer_email,
           //          'phone'=>$cust_mst->custPhonecode($cust_mst->phone)." ".$cust_mst->custPhone($cust_mst->phone),
           //          'ref_no'=>'#Test',
           //          'contact_type'=>'customer',
           //          'bb_partner_id'=>$post->id,
           //          'image'=>$base64_img,
           //      )
           //  ),
           //  ),
           //  )); 


           // $url_cust_reg = "http://3.109.84.120:7054/web/dataset/call_kw";
           // $handle = curl_init($url_cust_reg);
           //  curl_setopt($handle, CURLOPT_POST, true);
           //  curl_setopt($handle, CURLOPT_POSTFIELDS, $datapass);
           //  curl_setopt($handle, CURLOPT_HTTPHEADER, $headers); 
           //  curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
           //  curl_setopt($handle, CURLOPT_SSL_VERIFYPEER, false);
           //  $response = curl_exec($handle);
            
           //  if (curl_errno($handle)) {
           //  $error_msg = curl_error($handle);
           //  // dd($error_msg);
           //  }
           //  curl_close($handle);
           //  $return_response = json_decode($response,true);
           //  // dd($return_response);
           //  if(isset($return_response) && isset($return_response['result'])){
           //  CustomerMaster::where('id',$post->id)->update(['odoo_id'=>$return_response['result']['partner_id']]);
           // // print_r($msg); die();
           //  // if ($update) Email::sendEmail(geAdminEmail(), $post->email, 'Reset Password', $msg);
           // }


            $cust_mst =CustomerMaster::where('id',$post->id)->first();
            $customer_email=$cust_mst->custEmail($cust_mst->email);
           $data['data'] = array("customer_name"=>$cust_mst->info->first_name,'phone'=>$cust_mst->custPhonecode($cust_mst->phone).$cust_mst->custPhone($cust_mst->phone),'title'=>'Account Activated','message'=>'Your account has been activated.You can access your account using your mobile number: +'.$cust_mst->custPhonecode($cust_mst->phone)." ".$cust_mst->custPhone($cust_mst->phone),'customer_id'=>$cust_mst->id);
                                    $var = Mail::send('emails.customer_activate', $data, function($message) use($data,$customer_email) {
                                    $message->from(getadmin_mail(),'Bigbasket');    
                                    $message->to($customer_email);
                                   // $message->cc(['aleenaantony1020@gmail.com']); //myjewelleryshopper@gmail.com
                                    $message->subject('Account Activated');
                                    });
        }
        }
        // return 'success';
        
    }

}
