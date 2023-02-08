<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class DataCollectionEquipment extends Model
{
    use HasFactory;

    
    protected $table = 'data_collection_equipments';
    protected $guarded = [];  


    public static function selectOption()
    {
        return DataCollectionEquipment::where('is_active',1)->where('is_deleted',0)->get();
    }

}
