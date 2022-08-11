<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Caseuser extends Model
{
    protected $fillable = ['user_id','attorney_id','case_id','party_group','party_entity','org_comp_name','type','care_of','prefix','fname','mname','lname','suffix','prefname','short_name','telephone','gender','social_sec_number','employer_identification','date_of_birth','user_zipcode','street_address','user_city','state_id','county_id','fax','primary_language','req_lang_trans','hearing_impaired','req_sign_lang', 'unit', 'pobox', 'designation1','designation2','designation3','designation4','designation5', 'name_unknown', 'address_unknown','gen_desc','is_multi_desc','more_gen_desc','pauperis','created_at','updated_at','relation'
	];
	
	// public function user()
 //    {
 //        return $this->belongsTo('App\User');
 //    }
}
