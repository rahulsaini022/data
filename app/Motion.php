<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Motion extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'case_id', 'motion_name', 'motion_category', 'motion_action_type', 'parent_motion_id', 'motion_type_id', 'motion_status', 'motion_level', 'response_deadline', 'file_date', 'agreed_entry', 'stay_motion', 'doc_num_trigger', 'num_s', 'num_r', 'num_o', 'created_at', 'updated_at'
    ];

    public function motionparties()
    {
        return $this->hasMany(Motionparty::class);
    }

    public function submotions(){
        return $this->hasMany('App\Motion', 'parent_motion_id', 'id');
    }
}
