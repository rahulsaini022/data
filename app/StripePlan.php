<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StripePlan extends Model
{
	protected $table = 'stripe_plans';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [];
}
