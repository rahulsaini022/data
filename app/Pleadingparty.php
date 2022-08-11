<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pleadingparty extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'pleading_id', 'party_id', 'party_type', 'party_class', 'service_date', 'initial_deadline', 'current_deadline', 'created_at', 'updated_at'
    ];
    public function pleading()
    {
        return $this->belongsTo(Pleading::class);
    }
}
