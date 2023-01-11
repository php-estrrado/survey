<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Survey_requests extends Model{
    use HasFactory;
    public $table = 'survey_requests';
    protected $fillable = ['cust_id','service_id','service_request_id','request_status','assigned_institution','assigned_user','assigned_surveyor','assigned_draftsman','field_study','assigned_survey_institution','assigned_survey_user','assigned_draftsman_final','is_active','is_deleted','created_by','updated_by','created_at','updated_at'];

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
}

