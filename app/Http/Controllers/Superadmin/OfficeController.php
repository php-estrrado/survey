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
use App\Models\Institution;
use App\Models\Modules;
use App\Models\UserManagement;
use App\Models\UserVisit;
use App\Rules\Name;
use Validator;

class OfficeController extends Controller
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
    public function office()
    { 
        $data['title']             =   'Head And Sub Offices';
        $data['menu']              =   'Head And Sub Offices';
        $data['active_offices']    =   Institution::where('is_deleted',0)->where('is_active',1)->get();
        
        // dd($data);
        return view('superadmin.offices',$data);
    }

    function officeSave(Request $request)
    {
        $input = $request->all();
        // dd($input);         
        if($input['id'] > 0) 
        {
            $validator= $request->validate([
                'institution_name' => ['required','max:255',Rule::unique('institution')->ignore($input['id']),'regex:/^[a-zA-Z0-9\s]*$/']
            ],
            [],
            [
                'institution_name' => 'Institution Name'
            ]);

            
            $input = $request->except('_token','submit');
            $offices = Institution::where('id',$input['id'])->update($input);

            $msg = 'Office Updated successfully!';   
        
            if($offices)
            {   
                Session::flash('message', ['text'=>$msg,'type'=>'success']);  
            }
            else
            {
                Session::flash('message', ['text'=>'Office Updation failed','type'=>'danger']);
            }
        }
        else
        {
            $validator= $request->validate([
                'institution_name' => ['required','max:255',Rule::unique('institution'),'regex:/^[a-zA-Z0-9\s]*$/']
            ],
            [],
            [
                'institution_name' => 'Institution Name'
            ]);

            $input['is_active'] = 1;
            $input['is_deleted'] = 0;
            $input['created_by'] = 1;
            $input['updated_by'] = 1;
            $input['created_at'] = date("Y-m-d H:i:s");
            $input['updated_at'] = date("Y-m-d H:i:s");

            $institution_id = Institution::create($input)->id;

            $msg = 'Institution added successfully!';   
        
            if($institution_id)
            {   
                Session::flash('message', ['text'=>$msg,'type'=>'success']);  
            }
            else
            {
                Session::flash('message', ['text'=>'Institution creation failed','type'=>'danger']);
            }
        }

        return redirect(route('superadmin.offices'));
    }

    public function suboffice($id)
    {
        $data['title']    =   'Sub Office';
        $data['menu']     =   'Sub Office';
        $data['users']    =   UserManagement::where('is_deleted',0)->where('institution',$id)->where('is_active',1)->get();
        
        // dd($data);

        return view('superadmin.suboffice',$data);
    }
}
