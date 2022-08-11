<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class County extends Model
{
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'state_id', 'state_abbreviation', 'county_name', 'county_designation', 'county_active', 'created_at', 'updated_at'
    ];
    public function users()
    {
        return $this->belongsToMany('App\User');
    }
}
