<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Download extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'attorney_id', 'obligee_name', 'obligor_name', 'type', 'file_name', 'created_at', 'updated_at'
    ];
}
