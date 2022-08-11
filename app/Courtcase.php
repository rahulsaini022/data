<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Courtcase extends Model
{
 //    protected $fillable = ['attorney_id','state_id','county_id','court_id','division_id','judge_id','magistrate_id','case_type_ids','case_type_titles','other_case_type','judge_fullname','magistrate_fullname','jury_demand','sets','initial_service_types','payment_status','is_approved','filing_type','top_party_type','bottom_party_type','number_top_party_type','number_bottom_party_type', 'if_there_is_third_party_complaint', 'number_top_third_parties', 'number_bottom_third_parties', 'case_number','date_filed','date_served','final_hearing_date','original_top_party_type','original_bottom_party_type','original_number_top_party_type','original_number_bottom_party_type','original_state_id','original_county_id','original_court_id','original_division_id','original_judge_id','original_magistrate_id','original_case_number','original_date_filed','original_date_served','original_final_hearing_date','original_journalization_date','original_judge_fullname','original_magistrate_fullname','short_caption','case_payment_package_id','created_at','updated_at',
	// ];
	
	protected $guarded = [];

	
	// public function user()
 //    {
 //        return $this->belongsTo('App\User');
 //    }
}
