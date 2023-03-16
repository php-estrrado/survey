<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Survey_requests extends Model{
    use HasFactory;
    public $table = 'survey_requests';
    protected $fillable = ['cust_id','service_id','service_request_id','request_status','assigned_institution','assigned_user','assigned_surveyor','assigned_draftsman','field_study','receipt_image','assigned_survey_institution','assigned_survey_user','assigned_surveyor_survey','survey_study','assigned_draftsman_final','final_report','remarks','field_study_reschedule','survey_study_reschedule','is_active','is_deleted','created_by','updated_by','created_at','updated_at'];

    public function Hydrographic_survey()
    {
        return $this->hasMany(Hydrographic_survey::class,'id','service_request_id');
    }

    public function Tidal_observation()
    {
        return $this->hasMany(Tidal_observation::class,'id','service_request_id');
    }

    public function Bottom_sample_collection()
    {
        return $this->hasMany(Bottom_sample_collection::class,'id','service_request_id');
    }

    public function Dredging_survey()
    {
        return $this->hasMany(Dredging_survey::class,'id','service_request_id');
    }

    public function Underwater_videography()
    {
        return $this->hasMany(Underwater_videography::class,'id','service_request_id');
    }

    public function Currentmeter_observation()
    {
        return $this->hasMany(Currentmeter_observation::class,'id','service_request_id');
    }

    public function Subbottom_profilling()
    {
        return $this->hasMany(Subbottom_profilling::class,'id','service_request_id');
    }

    public function Topographic_survey()
    {
        return $this->hasMany(Topographic_survey::class,'id','service_request_id');
    }

    public function Sidescansonar()
    {
        return $this->hasMany(Sidescansonar::class,'id','service_request_id');
    }
    
    public function Hydrographic_chart()
    {
        return $this->hasMany(Hydrographic_chart::class,'id','service_request_id');
    }
    public function Bathymetry_survey()
    {
        return $this->hasMany(Bathymetry_survey::class,'id','service_request_id');
    }
    
      public function service_info()
    {
        // dd($this->service_request_id);
         switch ($this->service_id) {
            case 1:

                return $this->belongsTo(Hydrographic_survey::class,'service_request_id');
                break;
            case 2:
                return $this->belongsTo(Tidal_observation::class,'service_request_id');
                break;
            case 3:
                return $this->belongsTo(Bottom_sample_collection::class,'service_request_id');
                break;
            case 4:
                return $this->belongsTo(Dredging_survey::class,'service_request_id');
                break;
             case 5:
                return $this->belongsTo(Hydrographic_chart::class,'service_request_id');
                break; 

             case 6:
                return $this->belongsTo(Underwater_videography::class,'service_request_id');
                break; 
            case 7:
                return $this->belongsTo(Currentmeter_observation::class,'service_request_id');
                break;           

              case 8:
                return $this->belongsTo(Sidescansonar::class,'service_request_id');
                break;   
             case 9:
                return $this->belongsTo(Topographic_survey::class,'service_request_id');
                break; 
               case 10:
                return $this->belongsTo(Subbottom_profilling::class,'service_request_id');
                break; 
                case 11:
                return $this->belongsTo(Bathymetry_survey::class,'service_request_id');
                break; 
                  
            default:
                return NULL;
            }
    }

    public function services_selected($id)
    {
        $services_list = "";
        if($id)
        {
            $exp = explode(",", $id);
            if($exp)
            {
                foreach ($exp as $ek => $ev) {
                    $service = Services::where('id',$ev)->first();
                    if($service)
                    {
                        if($services_list)
                        {
                            $services_list .= ", ".$service->service_name;
                        }else{
                            $services_list .= $service->service_name;
                        }
                        
                    }
                }
            }
        }
        return $services_list;
    }

    public function datacollection_selected($id)
    {
        $datacollection = "";
        if($id)
        {
            $exp = explode(",", $id);
            if($exp)
            {
                foreach ($exp as $ek => $ev) {
                    $service = DataCollectionEquipment::where('id',$ev)->first();
                    if($service)
                    {
                        if($datacollection)
                        {
                            $datacollection .= ", ".$service->title;
                        }else{
                            $datacollection .= $service->title;
                        }
                        
                    }
                }
            }
        }
        return $datacollection;
    }
    public function Customer(){ return $this->belongsTo(CustomerMaster::class); } 
    public function CustomerInfo(){ return $this->belongsTo(CustomerInfo::class, 'cust_id', 'cust_id'); } 
    public function Service_data(){ return $this->belongsTo(Services::class,'service_id','id'); }
    public function RequestStatus(){ return $this->belongsTo(Survey_status::class,'request_status','id'); }  
}

