<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DocumentTable extends Model
{

    protected $table = 'document_table';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [];
}
