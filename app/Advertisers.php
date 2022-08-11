<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Advertisers extends Model
{
    public $timestamps = false;
    
    protected $table = "advertisers";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'listing_county', 'full_name', 'contact_full_name', 'email', 'telephone', 'street_address','Suite_Unit','City','county','state','ZIP_Code','website'
    ];


    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
