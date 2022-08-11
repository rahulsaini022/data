<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AttorneyTableActive extends Model
{
	protected $table = 'attorney_table_active';
	public $timestamps = false;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [];
}
