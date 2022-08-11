<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ADlistingImage extends Model
{
    protected $table = "advertiser_listing_images";
    protected $fillable = [
        'advertiser_listing_id','image'
    ];

}
