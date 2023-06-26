<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class SurveyScale extends Model
{
    use HasFactory;

    
    protected $table = 'scale_of_survey';
    protected $guarded = [];  


    public static function selectOption()
    {
        return SurveyScale::where('is_active',1)->where('is_deleted',0)->get()->pluck('scale', 'id');
    }

}
