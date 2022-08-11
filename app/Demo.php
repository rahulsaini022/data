<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Demo extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'state_of_registration', 'attorney_registration_number', 'name', 'email', 'created_at', 'updated_at'
    ];
}
