<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AttorneyTableActiveBeforeEdit extends Model
{
	protected $table = 'attorney_table_active_before_edit';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [];
}
