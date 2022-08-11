<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Cashier\Billable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use Notifiable;
    use Billable;
    use HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'username', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function attorney()
    {
        return $this->hasOne('App\Attorney');
    }

    public function advertiser()
    {
        return $this->hasOne('App\Advertisers');
    }
    public function attorney_county()
    {
        return $this->belongsToMany('App\County', 'attorneys','','','','','county_name');
    }
    public function advertiser_county()
    {
        return $this->belongsToMany('App\County', 'advertisers', '', 'county');
    }
}
