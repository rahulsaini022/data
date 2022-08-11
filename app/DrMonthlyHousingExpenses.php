<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DrMonthlyHousingExpenses extends Model
{
	protected $table = 'dr_MonthlyHousingExpenses';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [];
}
