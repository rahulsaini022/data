<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Price extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'full_price', 'adjudicator_price', 'law_clinic_price', 'legal_aid_price', 'discount', 'created_at', 'updated_at'
    ];
}
