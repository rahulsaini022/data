<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DrMonthlyDebtPayments extends Model
{
	protected $table = 'dr_MonthlyDebtPayments';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [];
}
