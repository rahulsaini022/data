<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Court extends Model
{
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public $timestamps = false;
    protected $guarded = [];
}
