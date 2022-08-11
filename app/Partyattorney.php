<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Partyattorney extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'case_id','party_id','attorney_id', 'trial_attorney', 'customer_attorney', 'created_at', 'updated_at'
    ];
}
