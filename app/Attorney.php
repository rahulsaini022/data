<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Attorney extends Model
{
 //    protected $fillable = ['user_id','mname','document_sign_name','special_practice','special_practice_text','firm_name','firm_street_address','firm_suite_unit_mailcode','po_box','firm_city','state_id','county_id','firm_zipcode','firm_telephone','firm_fax','attorney_reg_1_state_id','attorney_reg_2_state_id','attorney_reg_3_state_id','attorney_reg_1_num','attorney_reg_2_num','attorney_reg_3_num','pro_vice_hac_num','created_at','updated_at',
	// ];

	protected $guarded = [];
	
	public function user()
    {
        return $this->belongsTo('App\User');
    }
}
