<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Userloginreport extends Model
{
    public $timestamps = false;
    protected $fillable = ['user_id','last_login','last_failed_login'];
}
