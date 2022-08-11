<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CasePaymentTransactionHistory extends Model
{
	protected $table = 'case_payment_transaction_history';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [];
}
