<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class OrganisationType extends Model
{
    use HasFactory;

    
    protected $table = 'organisation_type';
    protected $guarded = [];  


    public static function selectOption()
    {
        return OrganisationType::where('is_active',1)->where('is_deleted',0)->get()->pluck('type', 'id');
    }

}
