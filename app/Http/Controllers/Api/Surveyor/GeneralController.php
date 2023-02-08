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


use App\Models\UserNotification;
use App\Models\Survey_requests;
use App\Models\Survey_request_logs;
use App\Models\Survey_study_report;
use App\Models\DataCollectionEquipment;

class GeneralController extends Controller
{
    public function language_list(Request $request)
    {
        $language=[];
        //LANGUAGE
            $lang=DB::table('glo_lang_lk')->where('is_active', 1)->get();
            foreach($lang as $key)
            {
                $lan['id']=$key->id;
                $lan['name']=$key->glo_lang_name;
                $lan['code']=$key->glo_lang_code;
                $language[]=$lan;
            }

          return ['httpcode'=>200,'status'=>'success','message'=>'Language List','data'=>['language'=>$language]];  
    }

    public function label_list(Request $request)
    {
        
        $validator=  Validator::make($request->all(),[
            'type'=>['required','in:web,app'],
            'lang_id'=>['nullable','numeric']
        ]);
        $lang=$request->lang_id;
        $label =[];
        if ($validator->fails()) 
        {    
          return ['httpcode'=>400,'status'=>'error','message'=>'Invalid parameters','data'=>['errors'=>$validator->messages()]];
        }
        else
        {
        $lbl = Label::where('is_active',1)->where('is_deleted',0)->where('label_for',$request->type)->get();
       // dd(count($lbl));
            foreach($lbl as $row)
            {
               $list['label_id']  = $row->id;
               $list['identifier']= $row->identifier;
               $list['label']     = $this->get_content($row->label_cid,$lang);
               $label[] = $list;
            }
            return ['httpcode'=>200,'status'=>'success','message'=>'Label List','data'=>['label'=>$label]]; 
        }
    }

    function get_content($field_id,$lang){ 
     
        if($lang=='')
        { 
        $language =DB::table('glo_lang_lk')->where('is_active', 1)->first();
        $language_id=$language->id;
        }
        else
        {
            $language_id=$lang;
        }
        $content_table=DB::table('cms_content')->where('cnt_id', $field_id)->where('lang_id', $language_id)->first();
        if(!empty($content_table)){ 
        $return_cont = $content_table->content;
        return $return_cont;
        }
        else
            { return false; }
        }

        public function get_bathymeteric_ins(Request $request)
    {
        $instruments=[];
        //instruments
            $lang=DataCollectionEquipment::where('is_active', 1)->get();
            foreach($lang as $key)
            {
                $lan['id']=$key->id;
                $lan['title']=$key->title;
                $instruments[]=$lan;
            }

          return ['httpcode'=>200,'status'=>'success','message'=>'Instruments List','data'=>['instruments'=>$instruments]];  
    }
}
