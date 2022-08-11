<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\DB;

class AdvertiserService extends Model
{
    protected $table='advertiser_services';
    protected $fillable=[
        'name',
        'description',
        'service_list_fee',
        'advertise_category_id',
        'parent_id',
        'has_child',
        'service_list_term'



    ];
 
  
   

}
