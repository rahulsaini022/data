<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Magistrate extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'mag_name', 'mag_last_name', 'mag_title', 'mag_court_name', 'mag_div', 'court_id', 'mag_jurisdiction', 'mag_phone', 'mag_fax', 'last_update', 'last_updatevalue', 'created_at', 'updated_at',
    ];
}
