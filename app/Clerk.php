<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Clerk extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'clerkname', 'clerktitle', 'last_update', 'last_updatevalue', 'created_at', 'updated_at',
    ];
}
