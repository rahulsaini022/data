<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Motionparty extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'motion_id', 'party_id', 'party_type', 'party_class', 'response_deadline', 'designation1', 'designation2', 'designation3', 'designation4', 'designation5','created_at', 'updated_at'
    ];
    public function motion()
    {
        return $this->belongsTo(Motion::class);
    }
}
