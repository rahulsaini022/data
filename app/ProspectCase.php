<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProspectCase extends Model
{
	protected $table = 'prospect_cases';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [];
}
