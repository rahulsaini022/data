<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Judge extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'adjudicator', 'adjudicator_lname', 'adj_title', 'adj_phone', 'adj_fax', 'adj_court', 'adj_address1', 'adj_address2', 'adj_city', 'adj_state', 'adj_zip', 'last_update', 'last_updatevalue', 'created_at', 'updated_at',
    ];
}
