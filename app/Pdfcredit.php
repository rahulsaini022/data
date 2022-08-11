<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pdfcredit extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'number_of_credits', 'purchase_price', 'discount', 'created_at', 'updated_at'
    ];
}
