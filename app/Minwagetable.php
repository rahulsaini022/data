<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Minwagetable extends Model
{
    protected $table = 'min_wage_table';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'effective_date', 'hourly_minimum_wage',  'created_at', 'updated_at'
    ];
}
