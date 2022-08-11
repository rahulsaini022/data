<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AuxTable extends Model
{
    protected $table = 'aux_table';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [];
}
