<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pleading extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'case_id', 'pleading_caption', 'pleading_name', 'date_filed', 'pleading_type_id', 'pleading_category', 'parent_pleading_id', 'pleading_has_new_third_parties', 'pleading_includes_claims', 'pleading_level', 'doc_num_trigger', 'num_s', 'num_r', 'num_o', 'created_at', 'updated_at'
    ];

    public function pleadingparties()
    {
        return $this->hasMany(Pleadingparty::class);
    }

    public function subpleadings(){
        return $this->hasMany('App\Pleading', 'parent_pleading_id', 'id');
    }
}
