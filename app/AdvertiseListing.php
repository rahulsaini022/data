<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AdvertiseListing extends Model
{
    protected $table = 'advertiser_listings';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [];
}
