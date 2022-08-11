<?php

namespace App\Observers;

use Illuminate\Http\Request;
use App\Pleading;
use App\PleadingParty;
use Illuminate\Support\Facades\DB;
use App\User;
use App\State;
use App\County;
use App\Court;
use App\Division;
use App\Attorney;
use App\Courtcase;
use App\Caseuser;
use App\Partyattorney;
use Auth;
use App\PleadingPartyInfo;
use App\PleadingPartyAttorneyInfo1;
use App\PleadingPartyAttorneyInfo2;

class PleadingPartyObserver
{
    /**
     * Handle the pleading party "created" event.
     *
     * @param  \App\PleadingParty  $pleadingParty
     * @return void
     */
    public function created(PleadingParty $pleadingParty)
    {
        // dd($pleadingParty);
        $pleading_id=$pleadingParty->pleading_id;
        $pleading=Pleading::find($pleading_id);
        $case_id=$pleading->case_id;
        $pleadingparties=$pleading->pleadingparties;
        $num=0;
        $pleading_parties_info=array(
                            'pleading_id'=>$pleading_id,
                        );
        foreach ($pleadingparties as $pleadingparty)
        {
            $name=User::where('id', $pleadingparty->party_id)->get()->pluck('name')->first();
            $fullname=$name;
            $caseuser=Caseuser::where([['case_id', $case_id],['attorney_id', Auth::user()->id],['user_id', $pleadingparty->party_id]])->get()->first();
            if(isset($caseuser->party_entity) && $caseuser->party_entity=='organization_company') {
                $fullname=$caseuser->org_comp_name;
            } else {
                $mname=$caseuser->mname;
                if(isset($mname) && $mname !='') {
                    $namearray = explode(' ', $name, 2);
                    if(count($namearray) > 1) {
                        $fullname=$namearray[0].' '.$mname.' '.$namearray[1];
                    } else {
                        $fullname=$name.' '.$mname;
                    }
                } else {
                    $fullname=$name;
                }
            }

            $state_name=State::find($caseuser->state_id)->state;
            $county_name=State::find($caseuser->state_id)->county_name;
            $num_attys=0;
            $attorney_ids=Partyattorney::where([['party_id', $pleadingparty->party_id],['case_id', $case_id]])->get();
            if($attorney_ids){
                $num_attys=count($attorney_ids);
            }

            $num++;

            $pleading_parties_info['p'.$num.'_user_id']=$pleadingparty->party_id;
            $pleading_parties_info['p'.$num.'_name']=$fullname;
            $pleading_parties_info['p'.$num.'_party_group']=$caseuser->party_group;
            $pleading_parties_info['p'.$num.'_org_comp_name']=$caseuser->org_comp_name;
            $pleading_parties_info['p'.$num.'_type']=$caseuser->type;
            $pleading_parties_info['p'.$num.'_care_of']=$caseuser->care_of;
            $pleading_parties_info['p'.$num.'_prefix']=$caseuser->prefix;
            $pleading_parties_info['p'.$num.'_mname']=$caseuser->mname;
            $pleading_parties_info['p'.$num.'_suffix']=$caseuser->suffix;
            $pleading_parties_info['p'.$num.'_prefname']=$caseuser->prefname;
            $pleading_parties_info['p'.$num.'_short_name']=$caseuser->short_name;
            $pleading_parties_info['p'.$num.'_gender']=$caseuser->gender;
            $pleading_parties_info['p'.$num.'_social_sec_number']=$caseuser->social_sec_number;
            $pleading_parties_info['p'.$num.'_employer_identification']=$caseuser->employer_identification;
            $pleading_parties_info['p'.$num.'_date_of_birth']=$caseuser->date_of_birth;
            $pleading_parties_info['p'.$num.'_zipcode']=$caseuser->user_zipcode;
            $pleading_parties_info['p'.$num.'_street_address']=$caseuser->street_address;
            $pleading_parties_info['p'.$num.'_city_name']=$caseuser->user_city;
            $pleading_parties_info['p'.$num.'_state_name']=$state_name;
            $pleading_parties_info['p'.$num.'_county_name']=$county_name;
            $pleading_parties_info['p'.$num.'_phone']=$caseuser->telephone;
            $pleading_parties_info['p'.$num.'_fax']=$caseuser->fax;
            $pleading_parties_info['p'.$num.'_primary_language']=$caseuser->primary_language;
            $pleading_parties_info['p'.$num.'_req_lang_trans']=$caseuser->req_lang_trans;
            $pleading_parties_info['p'.$num.'_hearing_impaired']=$caseuser->hearing_impaired;
            $pleading_parties_info['p'.$num.'_req_sign_lang']=$caseuser->req_sign_lang;
            $pleading_parties_info['p'.$num.'_num_attys']=$num_attys;

            // for updating party attornies info
            if($num <= 9)
            {
                $attorney_ids=Partyattorney::where([['party_id', $pleadingparty->party_id],['case_id', $case_id]])->get()->all();
                $attorney=array('pleading_id'=>$pleading_id);
                $num1=0;
                $totalattornies=count($attorney_ids);
                foreach($attorney_ids as $attorney_user_id){
                    $attorneyname=User::where('id', $attorney_user_id->attorney_id)->get()->pluck('name')->first();
                    $party_attorney = DB::table('attorneys')
                        ->join('states', 'attorneys.state_id', '=', 'states.id')
                        ->join('counties', [['attorneys.county_id', '=', 'counties.id'],['attorneys.state_id', '=', 'counties.state_id']])
                        ->where('user_id', $attorney_user_id->attorney_id)
                        ->select('attorneys.*','states.state', 'counties.id','counties.county_name')
                        ->get()->first();
                    $caseattytitle='Co-Counsel';
                    if(count($attorney_ids)==1 && $attorney_user_id->trial_attorney=='Yes'){
                        $caseattytitle='Trial Attorney and Counsel';
                    }
                    if(count($attorney_ids)>1 && $attorney_user_id->trial_attorney=='Yes'){
                        $caseattytitle='Trial Attorney and Co-Counsel';
                    }
                    $num1++;
                    $attorney['p'.$num.'_attorney'.$num1.'_user_id']=$attorney_user_id->attorney_id;
                    $attorney['p'.$num.'_attorney'.$num1.'_name']=$attorneyname;
                    $attorney['p'.$num.'_attorney'.$num1.'_document_sign_name']=$party_attorney->document_sign_name;
                    $attorney['p'.$num.'_attorney'.$num1.'_special_practice']=$party_attorney->special_practice;
                    $attorney['p'.$num.'_attorney'.$num1.'_special_practice_text']=$party_attorney->special_practice_text;
                    $attorney['p'.$num.'_attorney'.$num1.'_firm_name']=$party_attorney->firm_name;
                    $attorney['p'.$num.'_attorney'.$num1.'_firm_street_address']=$party_attorney->firm_street_address;
                    $attorney['p'.$num.'_attorney'.$num1.'_firm_suite_unit_mailcode']=$party_attorney->firm_suite_unit_mailcode;
                    $attorney['p'.$num.'_attorney'.$num1.'_po_box']=$party_attorney->po_box;
                    $attorney['p'.$num.'_attorney'.$num1.'_firm_city']=$party_attorney->firm_city;
                    $attorney['p'.$num.'_attorney'.$num1.'_firm_state']=$party_attorney->state;
                    $attorney['p'.$num.'_attorney'.$num1.'_firm_county']=$party_attorney->county_name;
                    $attorney['p'.$num.'_attorney'.$num1.'_firm_zipcode']=$party_attorney->firm_zipcode;
                    $attorney['p'.$num.'_attorney'.$num1.'_firm_telephone']=$party_attorney->firm_telephone;
                    $attorney['p'.$num.'_attorney'.$num1.'_firm_fax']=$party_attorney->firm_fax;
                    $attorney['p'.$num.'_attorney'.$num1.'_reg_1_num']=$party_attorney->attorney_reg_1_num;
                    $attorney['p'.$num.'_attorney'.$num1.'_trial_attorney']=$attorney_user_id->trial_attorney;
                    $attorney['p'.$num.'_attorney'.$num1.'_caseattytitle']=$caseattytitle;
                    
                }
                $limit=$num1+1;
                for($j=$limit; $j<=3; $j++){
                    $attorney['p'.$num.'_attorney'.$j.'_user_id']=NULL;
                    $attorney['p'.$num.'_attorney'.$j.'_name']=NULL;
                    $attorney['p'.$num.'_attorney'.$j.'_document_sign_name']=NULL;
                    $attorney['p'.$num.'_attorney'.$j.'_special_practice']=NULL;
                    $attorney['p'.$num.'_attorney'.$j.'_special_practice_text']=NULL;
                    $attorney['p'.$num.'_attorney'.$j.'_firm_name']=NULL;
                    $attorney['p'.$num.'_attorney'.$j.'_firm_street_address']=NULL;
                    $attorney['p'.$num.'_attorney'.$j.'_firm_suite_unit_mailcode']=NULL;
                    $attorney['p'.$num.'_attorney'.$j.'_po_box']=NULL;
                    $attorney['p'.$num.'_attorney'.$j.'_firm_city']=NULL;
                    $attorney['p'.$num.'_attorney'.$j.'_firm_state']=NULL;
                    $attorney['p'.$num.'_attorney'.$j.'_firm_county']=NULL;
                    $attorney['p'.$num.'_attorney'.$j.'_firm_zipcode']=NULL;
                    $attorney['p'.$num.'_attorney'.$j.'_firm_telephone']=NULL;
                    $attorney['p'.$num.'_attorney'.$j.'_firm_fax']=NULL;
                    $attorney['p'.$num.'_attorney'.$j.'_reg_1_num']=NULL;
                    $attorney['p'.$num.'_attorney'.$j.'_trial_attorney']=NULL;
                    $attorney['p'.$num.'_attorney'.$j.'_caseattytitle']=NULL;
                }

                $partytypeattorneyinfoprev=PleadingPartyAttorneyInfo1::where('pleading_id', $pleading_id)->get()->first();
                if($partytypeattorneyinfoprev){
                // dd($attorney);
                    $partytypeattorneyinfo=$partytypeattorneyinfoprev->fill($attorney)->save();
                } else {
                    $partytypeattorneyinfo=PleadingPartyAttorneyInfo1::create($attorney);
                }
            }

            if($num > 9)
            {
                $attorney_ids=Partyattorney::where([['party_id', $pleadingparty->party_id],['case_id', $case_id]])->get()->all();
                $attorney=array('pleading_id'=>$pleading_id);
                $num1=0;
                $totalattornies=count($attorney_ids);
                foreach($attorney_ids as $attorney_user_id){
                    $attorneyname=User::where('id', $attorney_user_id->attorney_id)->get()->pluck('name')->first();
                    $party_attorney = DB::table('attorneys')
                        ->join('states', 'attorneys.state_id', '=', 'states.id')
                        ->join('counties', [['attorneys.county_id', '=', 'counties.id'],['attorneys.state_id', '=', 'counties.state_id']])
                        ->where('user_id', $attorney_user_id->attorney_id)
                        ->select('attorneys.*','states.state', 'counties.id','counties.county_name')
                        ->get()->first();
                    $caseattytitle='Co-Counsel';
                    if(count($attorney_ids)==1 && $attorney_user_id->trial_attorney=='Yes'){
                        $caseattytitle='Trial Attorney and Counsel';
                    }
                    if(count($attorney_ids)>1 && $attorney_user_id->trial_attorney=='Yes'){
                        $caseattytitle='Trial Attorney and Co-Counsel';
                    }
                    $num1++;
                    $attorney['p'.$num.'_attorney'.$num1.'_user_id']=$attorney_user_id->attorney_id;
                    $attorney['p'.$num.'_attorney'.$num1.'_name']=$attorneyname;
                    $attorney['p'.$num.'_attorney'.$num1.'_document_sign_name']=$party_attorney->document_sign_name;
                    $attorney['p'.$num.'_attorney'.$num1.'_special_practice']=$party_attorney->special_practice;
                    $attorney['p'.$num.'_attorney'.$num1.'_special_practice_text']=$party_attorney->special_practice_text;
                    $attorney['p'.$num.'_attorney'.$num1.'_firm_name']=$party_attorney->firm_name;
                    $attorney['p'.$num.'_attorney'.$num1.'_firm_street_address']=$party_attorney->firm_street_address;
                    $attorney['p'.$num.'_attorney'.$num1.'_firm_suite_unit_mailcode']=$party_attorney->firm_suite_unit_mailcode;
                    $attorney['p'.$num.'_attorney'.$num1.'_po_box']=$party_attorney->po_box;
                    $attorney['p'.$num.'_attorney'.$num1.'_firm_city']=$party_attorney->firm_city;
                    $attorney['p'.$num.'_attorney'.$num1.'_firm_state']=$party_attorney->state;
                    $attorney['p'.$num.'_attorney'.$num1.'_firm_county']=$party_attorney->county_name;
                    $attorney['p'.$num.'_attorney'.$num1.'_firm_zipcode']=$party_attorney->firm_zipcode;
                    $attorney['p'.$num.'_attorney'.$num1.'_firm_telephone']=$party_attorney->firm_telephone;
                    $attorney['p'.$num.'_attorney'.$num1.'_firm_fax']=$party_attorney->firm_fax;
                    $attorney['p'.$num.'_attorney'.$num1.'_reg_1_num']=$party_attorney->attorney_reg_1_num;
                    $attorney['p'.$num.'_attorney'.$num1.'_trial_attorney']=$attorney_user_id->trial_attorney;
                    $attorney['p'.$num.'_attorney'.$num1.'_caseattytitle']=$caseattytitle;
                    
                }
                $limit=$num1+1;
                for($j=$limit; $j<=3; $j++){
                    $attorney['p'.$num.'_attorney'.$j.'_user_id']=NULL;
                    $attorney['p'.$num.'_attorney'.$j.'_name']=NULL;
                    $attorney['p'.$num.'_attorney'.$j.'_document_sign_name']=NULL;
                    $attorney['p'.$num.'_attorney'.$j.'_special_practice']=NULL;
                    $attorney['p'.$num.'_attorney'.$j.'_special_practice_text']=NULL;
                    $attorney['p'.$num.'_attorney'.$j.'_firm_name']=NULL;
                    $attorney['p'.$num.'_attorney'.$j.'_firm_street_address']=NULL;
                    $attorney['p'.$num.'_attorney'.$j.'_firm_suite_unit_mailcode']=NULL;
                    $attorney['p'.$num.'_attorney'.$j.'_po_box']=NULL;
                    $attorney['p'.$num.'_attorney'.$j.'_firm_city']=NULL;
                    $attorney['p'.$num.'_attorney'.$j.'_firm_state']=NULL;
                    $attorney['p'.$num.'_attorney'.$j.'_firm_county']=NULL;
                    $attorney['p'.$num.'_attorney'.$j.'_firm_zipcode']=NULL;
                    $attorney['p'.$num.'_attorney'.$j.'_firm_telephone']=NULL;
                    $attorney['p'.$num.'_attorney'.$j.'_firm_fax']=NULL;
                    $attorney['p'.$num.'_attorney'.$j.'_reg_1_num']=NULL;
                    $attorney['p'.$num.'_attorney'.$j.'_trial_attorney']=NULL;
                    $attorney['p'.$num.'_attorney'.$j.'_caseattytitle']=NULL;
                }

                $partytypeattorneyinfoprev=PleadingPartyAttorneyInfo2::where('pleading_id', $pleading_id)->get()->first();
                if($partytypeattorneyinfoprev){
                    $partytypeattorneyinfo=$partytypeattorneyinfoprev->fill($attorney)->save();
                } else {
                    $partytypeattorneyinfo=PleadingPartyAttorneyInfo2::create($attorney);
                }
            } else {
                $attorney2=array('pleading_id'=>$pleading_id);
                $partytypeattorneyinfoprev=PleadingPartyAttorneyInfo2::where('pleading_id', $pleading_id)->get()->first();
                if($partytypeattorneyinfoprev){
                    $partytypeattorneyinfo=$partytypeattorneyinfoprev->fill($attorney2)->save();
                } else {
                    $partytypeattorneyinfo=PleadingPartyAttorneyInfo2::create($attorney2);
                }
            }
            // end for updating party attornies info

        }
        $partytypeinfoprev=PleadingPartyInfo::where('pleading_id', $pleading_id)->get()->first();
        if($partytypeinfoprev){
            $partytypeinfo=$partytypeinfoprev->fill($pleading_parties_info)->save();
        } else {
            $partytypeinfo=PleadingPartyInfo::create($pleading_parties_info);
        }
        
    }

    /**
     * Handle the pleading party "updated" event.
     *
     * @param  \App\PleadingParty  $pleadingParty
     * @return void
     */
    public function updated(PleadingParty $pleadingParty)
    {
        dd($pleadingParty);
    }

    /**
     * Handle the pleading party "deleted" event.
     *
     * @param  \App\PleadingParty  $pleadingParty
     * @return void
     */
    public function deleted(PleadingParty $pleadingParty)
    {
        //
    }

    /**
     * Handle the pleading party "restored" event.
     *
     * @param  \App\PleadingParty  $pleadingParty
     * @return void
     */
    public function restored(PleadingParty $pleadingParty)
    {
        //
    }

    /**
     * Handle the pleading party "force deleted" event.
     *
     * @param  \App\PleadingParty  $pleadingParty
     * @return void
     */
    public function forceDeleted(PleadingParty $pleadingParty)
    {
        //
    }
}
