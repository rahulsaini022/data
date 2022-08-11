<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PleadingPartyInfo extends Model
{
	protected $table = 'pleading_parties_info';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [];
}
