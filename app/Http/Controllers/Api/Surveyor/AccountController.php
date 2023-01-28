<?php

namespace App\Http\Controllers\Api\Surveyor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Session;
use DB;
use App\Models\Modules;
use App\Models\UserRoles;
use App\Models\Admin;
use App\Models\UserRole;



use App\Models\Survey_requests;

use Carbon\Carbon;
use App\Rules\Name;
use Validator;

use App\Models\crm\{CrmAssortmentMaster, CrmChildProductsMaster, CrmCustomerType,CrmPartAssortmentDetails,
CrmPartAssortmentMaster,CrmProduct,CrmSalesPriceList,CrmSalesPriceType,CrmSize,CrmBranch};

class AccountController extends Controller
{
    public function profile(Request $request)
    {  

        $login=0;
        $user_id=null;
        $user = [];
        
        $validator=  Validator::make($request->all(),[
            'access_token' => ['required'],
        ]);
        if ($validator->fails()) 
            {    
              return ['httpcode'=>400,'status'=>'error','message'=>'invalid','data'=>['errors'=>$validator->messages()]];
            }
            
            
        
        if($request->post('access_token')){
            if(!$user = validateToken($request->post('access_token'))){ return invalidToken(); }
            $login=1;
            $user_id = $user['user_id'];
            
        }

        if($user)
        {
        	$admin_user =Admin::where('id',$user['user_id'])->first();
        	if($admin_user && isset($admin_user->role))
        	{
        		$user['user_role'] = $admin_user->role->usr_role_name;
        	}
        	else{
        		$user['user_role'] = "Surveyor";
        	}
        	

        }else{
        	return ['httpcode'=>400,'status'=>'error','message'=>'Invalid User'];
        }
        return ['httpcode'=>200,'status'=>'success','page'=>'Home','message'=>'Success','data'=>['user_data'=>$user]];
    }

  
   
}
