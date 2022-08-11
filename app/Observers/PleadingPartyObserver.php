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
use App\PleadingSendersInfo;
use App\PleadingSendersAttorneysInfo1;
use App\PleadingSendersAttorneysInfo2;
use App\PleadingReceiversInfo;
use App\PleadingReceiversAttorneysInfo1;
use App\PleadingReceiversAttorneysInfo2;

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
        // $pleading_id=$pleadingParty->pleading_id;
        // $pleading=Pleading::find($pleading_id);
        // $case_id=$pleading->case_id;
        // $pleadingparties=$pleading->pleadingparties;
        // // for updating sender info
        // $num=0;
        // $numsenders=0;
        // $pleading_parties_info=array(
        //                     'pleading_id'=>$pleading_id,
        //                 );
        // foreach ($pleadingparties as $pleadingparty)
        // {
        //     if($numsenders < $pleading->num_s){
        //         $userinfo=User::find($pleadingparty->party_id);
        //         $name=$userinfo->name;
        //         $fullname=$userinfo->name;
        //         $caseuser=Caseuser::where([['case_id', $case_id],['attorney_id', Auth::user()->id],['user_id', $pleadingparty->party_id]])->get()->first();
        //         if(isset($caseuser->party_entity) && $caseuser->party_entity=='organization_company') {
        //             $fullname=$caseuser->org_comp_name;
        //         } else {
        //             $mname=$caseuser->mname;
        //             if(isset($mname) && $mname !='') {
        //                 $namearray = explode(' ', $name, 2);
        //                 if(count($namearray) > 1) {
        //                     $fullname=$namearray[0].' '.$mname.' '.$namearray[1];
        //                 } else {
        //                     $fullname=$name.' '.$mname;
        //                 }
        //             } else {
        //                 $fullname=$name;
        //             }
        //             if(isset($caseuser->suffix)){
        //                 if($caseuser->suffix=='I' || $caseuser->suffix=='II' || $caseuser->suffix=='III' || $caseuser->suffix=='IV'){
        //                     $fullname=$fullname.' '.$caseuser->suffix;
        //                 } else {
        //                     $fullname=$fullname.', '.$caseuser->suffix;
        //                 }
        //             }
        //         }
        //         if(isset($caseuser->state_id) && $caseuser->state_id !=''){
        //             $state_name=State::find($caseuser->state_id)->state;
        //         } else {
        //             $state_name='';
        //         }
        //         if(isset($caseuser->county_id) && $caseuser->county_id !=''){
        //             $county_name=County::find($caseuser->county_id)->county_name;
        //         } else {
        //             $county_name='';
        //         }
        //         if(isset($caseuser->user_city) && $caseuser->user_city !=''){
        //             $city_name=$caseuser->user_city;
        //         } else {
        //             $city_name='';
        //         }
        //         if(isset($caseuser->user_zipcode) && $caseuser->user_zipcode !=''){
        //             $user_zipcode=$caseuser->user_zipcode;
        //         } else {
        //             $user_zipcode='';
        //         }
        //         if(isset($caseuser->state_id) && isset($caseuser->user_zipcode) && isset($caseuser->user_city)){
        //             $citystatezip=$city_name.', '.$state_name.' '.$caseuser->user_zipcode;
        //         } else {
        //             $citystatezip=NULL;
        //         }
                
                
        //         $num_attys=0;
        //         $attorney_ids=Partyattorney::where([['party_id', $pleadingparty->party_id],['case_id', $case_id]])->get();
        //         if($attorney_ids){
        //             $num_attys=count($attorney_ids);
        //         }

        //         $num++;

        //         $pleading_parties_info['fullnameS'.$num.'']=$fullname;
        //         $pleading_parties_info['shortnameS'.$num.'']=$caseuser->short_name;
        //         $pleading_parties_info['genderS'.$num.'']=$caseuser->gender;
        //         $pleading_parties_info['streetadS'.$num.'']=$caseuser->street_address;
        //         $pleading_parties_info['unitS'.$num.'']=$caseuser->unit;
        //         $pleading_parties_info['poboxS'.$num.'']=$caseuser->pobox;
        //         $pleading_parties_info['citystatezipS'.$num.'']=$citystatezip;
        //         $pleading_parties_info['telephoneS'.$num.'']=$caseuser->telephone;
        //         $pleading_parties_info['faxS'.$num.'']=$caseuser->fax;
        //         $pleading_parties_info['emailS'.$num.'']=$userinfo->email;
        //         $pleading_parties_info['nameunknownS'.$num.'']=$caseuser->name_unknown;
        //         $pleading_parties_info['addressunknownS'.$num.'']=$caseuser->address_unknown;
        //         $pleading_parties_info['gendescS'.$num.'']=$caseuser->gen_desc;
        //         $pleading_parties_info['ismultidescS'.$num.'']=$caseuser->is_multi_desc;
        //         $pleading_parties_info['moregendescS'.$num.'']=$caseuser->more_gen_desc;
        //         $pleading_parties_info['pauperisS'.$num.'']=$caseuser->pauperis;

        //         // for updating party attornies info
        //         if($num <= 9)
        //         {
        //             $attorney_ids=Partyattorney::where([['party_id', $pleadingparty->party_id],['case_id', $case_id]])->get()->all();
        //             $attorney=array('pleading_id'=>$pleading_id);
        //             $num1=0;
        //             $totalattornies=count($attorney_ids);
        //             foreach($attorney_ids as $attorney_user_id){
        //                 $attorneyuserinfo=User::find($attorney_user_id->attorney_id);
        //                 $attorneyname=$attorneyuserinfo->name;
        //                 $attorneyemail=$attorneyuserinfo->email;
        //                 $party_attorney = DB::table('attorneys')
        //                     ->join('states', 'attorneys.state_id', '=', 'states.id')
        //                     ->join('counties', [['attorneys.county_id', '=', 'counties.id'],['attorneys.state_id', '=', 'counties.state_id']])
        //                     ->where('user_id', $attorney_user_id->attorney_id)
        //                     ->select('attorneys.*','states.state', 'counties.id','counties.county_name')
        //                     ->get()->first();
        //                 $caseattytitle='Co-Counsel';
        //                 if(count($attorney_ids)==1 && $attorney_user_id->trial_attorney=='Yes'){
        //                     $caseattytitle='Trial Attorney and Counsel';
        //                 }
        //                 if(count($attorney_ids)>1 && $attorney_user_id->trial_attorney=='Yes'){
        //                     $caseattytitle='Trial Attorney and Co-Counsel';
        //                 }

        //                 $attorneycitystatezip=$party_attorney->firm_city.', '.$party_attorney->state.' '.$party_attorney->firm_zipcode;

        //                 $num1++;
        //                 $attorney['signnameS'.$num.'A'.$num1.'']=$party_attorney->document_sign_name;
        //                 $attorney['firmS'.$num.'A'.$num1.'']=$party_attorney->firm_name;
        //                 $attorney['streetadS'.$num.'A'.$num1.'']=$party_attorney->firm_street_address;
        //                 $attorney['unitS'.$num.'A'.$num1.'']=$party_attorney->firm_suite_unit_mailcode;
        //                 $attorney['poboxS'.$num.'A'.$num1.'']=$party_attorney->po_box;
        //                 $attorney['citystatezipS'.$num.'A'.$num1.'']=$attorneycitystatezip;
        //                 $attorney['telephoneS'.$num.'A'.$num1.'']=$party_attorney->firm_telephone;
        //                 $attorney['faxS'.$num.'A'.$num1.'']=$party_attorney->firm_fax;
        //                 $attorney['emailS'.$num.'A'.$num1.'']=$attorneyemail;
                        
        //             }
        //             $limit=$num1+1;
        //             for($j=$limit; $j<=3; $j++){
        //                 $attorney['signnameS'.$num.'A'.$j.'']=NULL;
        //                 $attorney['firmS'.$num.'A'.$j.'']=NULL;
        //                 $attorney['streetadS'.$num.'A'.$j.'']=NULL;
        //                 $attorney['unitS'.$num.'A'.$j.'']=NULL;
        //                 $attorney['poboxS'.$num.'A'.$j.'']=NULL;
        //                 $attorney['citystatezipS'.$num.'A'.$j.'']=NULL;
        //                 $attorney['telephoneS'.$num.'A'.$j.'']=NULL;
        //                 $attorney['faxS'.$num.'A'.$j.'']=NULL;
        //                 $attorney['emailS'.$num.'A'.$j.'']=NULL;
        //             }

        //             $partytypeattorneyinfoprev=PleadingSendersAttorneysInfo1::where('pleading_id', $pleading_id)->get()->first();
        //             if($partytypeattorneyinfoprev){
        //             // dd($attorney);
        //                 $partytypeattorneyinfo=$partytypeattorneyinfoprev->fill($attorney)->save();
        //             } else {
        //                 $partytypeattorneyinfo=PleadingSendersAttorneysInfo1::create($attorney);
        //             }
        //         }

        //         if($num > 9)
        //         {
        //             $attorney_ids=Partyattorney::where([['party_id', $pleadingparty->party_id],['case_id', $case_id]])->get()->all();
        //             $attorney=array('pleading_id'=>$pleading_id);
        //             $num1=0;
        //             $totalattornies=count($attorney_ids);
        //             foreach($attorney_ids as $attorney_user_id){
        //                 $attorneyuserinfo=User::where($attorney_user_id->attorney_id);
        //                 $attorneyname=$attorneyuserinfo->name;
        //                 $attorneyemail=$attorneyuserinfo->email;
        //                 $party_attorney = DB::table('attorneys')
        //                     ->join('states', 'attorneys.state_id', '=', 'states.id')
        //                     ->join('counties', [['attorneys.county_id', '=', 'counties.id'],['attorneys.state_id', '=', 'counties.state_id']])
        //                     ->where('user_id', $attorney_user_id->attorney_id)
        //                     ->select('attorneys.*','states.state', 'counties.id','counties.county_name')
        //                     ->get()->first();
        //                 $caseattytitle='Co-Counsel';
        //                 if(count($attorney_ids)==1 && $attorney_user_id->trial_attorney=='Yes'){
        //                     $caseattytitle='Trial Attorney and Counsel';
        //                 }
        //                 if(count($attorney_ids)>1 && $attorney_user_id->trial_attorney=='Yes'){
        //                     $caseattytitle='Trial Attorney and Co-Counsel';
        //                 }

        //                 $attorneycitystatezip=$party_attorney->firm_city.', '.$party_attorney->state.' '.$party_attorney->firm_zipcode;

        //                 $num1++;
        //                 $attorney['signnameS'.$num.'A'.$num1.'']=$party_attorney->document_sign_name;
        //                 $attorney['firmS'.$num.'A'.$num1.'']=$party_attorney->firm_name;
        //                 $attorney['streetadS'.$num.'A'.$num1.'']=$party_attorney->firm_street_address;
        //                 $attorney['unitS'.$num.'A'.$num1.'']=$party_attorney->firm_suite_unit_mailcode;
        //                 $attorney['poboxS'.$num.'A'.$num1.'']=$party_attorney->po_box;
        //                 $attorney['citystatezipS'.$num.'A'.$num1.'']=$attorneycitystatezip;
        //                 $attorney['telephoneS'.$num.'A'.$num1.'']=$party_attorney->firm_telephone;
        //                 $attorney['faxS'.$num.'A'.$num1.'']=$party_attorney->firm_fax;
        //                 $attorney['emailS'.$num.'A'.$num1.'']=$attorneyemail;
                        
        //             }
        //             $limit=$num1+1;
        //             for($j=$limit; $j<=3; $j++){
        //                 $attorney['signnameS'.$num.'A'.$j.'']=NULL;
        //                 $attorney['firmS'.$num.'A'.$j.'']=NULL;
        //                 $attorney['streetadS'.$num.'A'.$j.'']=NULL;
        //                 $attorney['unitS'.$num.'A'.$j.'']=NULL;
        //                 $attorney['poboxS'.$num.'A'.$j.'']=NULL;
        //                 $attorney['citystatezipS'.$num.'A'.$j.'']=NULL;
        //                 $attorney['telephoneS'.$num.'A'.$j.'']=NULL;
        //                 $attorney['faxS'.$num.'A'.$j.'']=NULL;
        //                 $attorney['emailS'.$num.'A'.$j.'']=NULL;
        //             }

        //             $partytypeattorneyinfoprev=PleadingSendersAttorneysInfo2::where('pleading_id', $pleading_id)->get()->first();
        //             if($partytypeattorneyinfoprev){
        //                 $partytypeattorneyinfo=$partytypeattorneyinfoprev->fill($attorney)->save();
        //             } else {
        //                 $partytypeattorneyinfo=PleadingSendersAttorneysInfo2::create($attorney);
        //             }
        //         } else {
        //             $attorney2=array('pleading_id'=>$pleading_id);
        //             $partytypeattorneyinfoprev=PleadingSendersAttorneysInfo2::where('pleading_id', $pleading_id)->get()->first();
        //             if($partytypeattorneyinfoprev){
        //                 $partytypeattorneyinfo=$partytypeattorneyinfoprev->fill($attorney2)->save();
        //             } else {
        //                 $partytypeattorneyinfo=PleadingSendersAttorneysInfo2::create($attorney2);
        //             }
        //         }
        //     }

        //     ++$numsenders; 
        //     // end for updating party attornies info
        // }
        // $partytypeinfoprev=PleadingSendersInfo::where('pleading_id', $pleading_id)->get()->first();
        // if($partytypeinfoprev){
        //     $partytypeinfo=$partytypeinfoprev->fill($pleading_parties_info)->save();
        // } else {
        //     $partytypeinfo=PleadingSendersInfo::create($pleading_parties_info);
        // }
        // // end for updating sender info

        // // for updating receiver info

        // $num=0;
        // $numreceivers=0;
        // $pleading_parties_info1=array(
        //                     'pleading_id'=>$pleading_id,
        //                 );
        // foreach ($pleadingparties as $pleadingparty)
        // {
        //     // if($numreceivers >= $pleading->num_s){
        //     if($numreceivers < $pleading->num_r){
        //         $userinfo=User::find($pleadingparty->party_id);
        //         $name=$userinfo->name;
        //         $fullname=$userinfo->name;
        //         $caseuser=Caseuser::where([['case_id', $case_id],['attorney_id', Auth::user()->id],['user_id', $pleadingparty->party_id]])->get()->first();
        //         if(isset($caseuser->party_entity) && $caseuser->party_entity=='organization_company') {
        //             $fullname=$caseuser->org_comp_name;
        //         } else {
        //             $mname=$caseuser->mname;
        //             if(isset($mname) && $mname !='') {
        //                 $namearray = explode(' ', $name, 2);
        //                 if(count($namearray) > 1) {
        //                     $fullname=$namearray[0].' '.$mname.' '.$namearray[1];
        //                 } else {
        //                     $fullname=$name.' '.$mname;
        //                 }
        //             } else {
        //                 $fullname=$name;
        //             }
        //             if(isset($caseuser->suffix)){
        //                 if($caseuser->suffix=='I' || $caseuser->suffix=='II' || $caseuser->suffix=='III' || $caseuser->suffix=='IV'){
        //                     $fullname=$fullname.' '.$caseuser->suffix;
        //                 } else {
        //                     $fullname=$fullname.', '.$caseuser->suffix;
        //                 }
        //             }
        //         }

        //         if(isset($caseuser->state_id) && $caseuser->state_id !=''){
        //             $state_name=State::find($caseuser->state_id)->state;
        //         } else {
        //             $state_name='';
        //         }
        //         if(isset($caseuser->county_id) && $caseuser->county_id !=''){
        //             $county_name=County::find($caseuser->county_id)->county_name;
        //         } else {
        //             $county_name='';
        //         }
        //         if(isset($caseuser->user_city) && $caseuser->user_city !=''){
        //             $city_name=$caseuser->user_city;
        //         } else {
        //             $city_name='';
        //         }
        //         if(isset($caseuser->user_zipcode) && $caseuser->user_zipcode !=''){
        //             $user_zipcode=$caseuser->user_zipcode;
        //         } else {
        //             $user_zipcode='';
        //         }
        //         if(isset($caseuser->state_id) && isset($caseuser->user_zipcode) && isset($caseuser->user_city)){
        //             $citystatezip=$city_name.', '.$state_name.' '.$caseuser->user_zipcode;
        //         } else {
        //             $citystatezip=NULL;
        //         }
        //         $num_attys=0;
        //         $attorney_ids=Partyattorney::where([['party_id', $pleadingparty->party_id],['case_id', $case_id]])->get();
        //         if($attorney_ids){
        //             $num_attys=count($attorney_ids);
        //         }

        //         $num++;

        //         $pleading_parties_info1['fullnameR'.$num.'']=$fullname;
        //         $pleading_parties_info1['shortnameR'.$num.'']=$caseuser->short_name;
        //         $pleading_parties_info1['genderR'.$num.'']=$caseuser->gender;
        //         $pleading_parties_info1['streetadR'.$num.'']=$caseuser->street_address;
        //         $pleading_parties_info1['unitR'.$num.'']=$caseuser->unit;
        //         $pleading_parties_info1['poboxR'.$num.'']=$caseuser->pobox;
        //         $pleading_parties_info1['citystatezipR'.$num.'']=$citystatezip;
        //         $pleading_parties_info1['telephoneR'.$num.'']=$caseuser->telephone;
        //         $pleading_parties_info1['faxR'.$num.'']=$caseuser->fax;
        //         $pleading_parties_info1['emailR'.$num.'']=$userinfo->email;
        //         $pleading_parties_info1['nameunknownR'.$num.'']=$caseuser->name_unknown;
        //         $pleading_parties_info1['addressunknownR'.$num.'']=$caseuser->address_unknown;
        //         $pleading_parties_info1['gendescR'.$num.'']=$caseuser->gen_desc;
        //         $pleading_parties_info1['ismultidescR'.$num.'']=$caseuser->is_multi_desc;
        //         $pleading_parties_info1['moregendescR'.$num.'']=$caseuser->more_gen_desc;
        //         $pleading_parties_info1['pauperisR'.$num.'']=$caseuser->pauperis;

        //         // for updating party attornies info
        //         if($num <= 9)
        //         {
        //             $attorney_ids=Partyattorney::where([['party_id', $pleadingparty->party_id],['case_id', $case_id]])->get()->all();
        //             $attorney=array('pleading_id'=>$pleading_id);
        //             $num1=0;
        //             $totalattornies=count($attorney_ids);
        //             foreach($attorney_ids as $attorney_user_id){
        //                $attorneyuserinfo=User::find($attorney_user_id->attorney_id);
        //                 $attorneyname=$attorneyuserinfo->name;
        //                 $attorneyemail=$attorneyuserinfo->email;
        //                 $party_attorney = DB::table('attorneys')
        //                     ->join('states', 'attorneys.state_id', '=', 'states.id')
        //                     ->join('counties', [['attorneys.county_id', '=', 'counties.id'],['attorneys.state_id', '=', 'counties.state_id']])
        //                     ->where('user_id', $attorney_user_id->attorney_id)
        //                     ->select('attorneys.*','states.state', 'counties.id','counties.county_name')
        //                     ->get()->first();
        //                 $caseattytitle='Co-Counsel';
        //                 if(count($attorney_ids)==1 && $attorney_user_id->trial_attorney=='Yes'){
        //                     $caseattytitle='Trial Attorney and Counsel';
        //                 }
        //                 if(count($attorney_ids)>1 && $attorney_user_id->trial_attorney=='Yes'){
        //                     $caseattytitle='Trial Attorney and Co-Counsel';
        //                 }

        //                 $attorneycitystatezip=$party_attorney->firm_city.', '.$party_attorney->state.' '.$party_attorney->firm_zipcode;

        //                 $num1++;
        //                 $attorney['signnameR'.$num.'A'.$num1.'']=$party_attorney->document_sign_name;
        //                 $attorney['firmR'.$num.'A'.$num1.'']=$party_attorney->firm_name;
        //                 $attorney['streetadR'.$num.'A'.$num1.'']=$party_attorney->firm_street_address;
        //                 $attorney['unitR'.$num.'A'.$num1.'']=$party_attorney->firm_suite_unit_mailcode;
        //                 $attorney['poboxR'.$num.'A'.$num1.'']=$party_attorney->po_box;
        //                 $attorney['citystatezipR'.$num.'A'.$num1.'']=$attorneycitystatezip;
        //                 $attorney['telephoneR'.$num.'A'.$num1.'']=$party_attorney->firm_telephone;
        //                 $attorney['faxR'.$num.'A'.$num1.'']=$party_attorney->firm_fax;
        //                 $attorney['emailR'.$num.'A'.$num1.'']=$attorneyemail;
                        
        //             }
        //             $limit=$num1+1;
        //             for($j=$limit; $j<=3; $j++){
        //                 $attorney['signnameR'.$num.'A'.$j.'']=NULL;
        //                 $attorney['firmR'.$num.'A'.$j.'']=NULL;
        //                 $attorney['streetadR'.$num.'A'.$j.'']=NULL;
        //                 $attorney['unitR'.$num.'A'.$j.'']=NULL;
        //                 $attorney['poboxR'.$num.'A'.$j.'']=NULL;
        //                 $attorney['citystatezipR'.$num.'A'.$j.'']=NULL;
        //                 $attorney['telephoneR'.$num.'A'.$j.'']=NULL;
        //                 $attorney['faxR'.$num.'A'.$j.'']=NULL;
        //                 $attorney['emailR'.$num.'A'.$j.'']=NULL;
        //             }

        //             $partytypeattorneyinfoprev=PleadingReceiversAttorneysInfo1::where('pleading_id', $pleading_id)->get()->first();
        //             if($partytypeattorneyinfoprev){
        //             // dd($attorney);
        //                 $partytypeattorneyinfo=$partytypeattorneyinfoprev->fill($attorney)->save();
        //             } else {
        //                 $partytypeattorneyinfo=PleadingReceiversAttorneysInfo1::create($attorney);
        //             }
        //         }

        //         if($num > 9)
        //         {
        //             $attorney_ids=Partyattorney::where([['party_id', $pleadingparty->party_id],['case_id', $case_id]])->get()->all();
        //             $attorney=array('pleading_id'=>$pleading_id);
        //             $num1=0;
        //             $totalattornies=count($attorney_ids);
        //             foreach($attorney_ids as $attorney_user_id){
        //                $attorneyuserinfo=User::find($attorney_user_id->attorney_id);
        //                 $attorneyname=$attorneyuserinfo->name;
        //                 $attorneyemail=$attorneyuserinfo->email;
        //                 $party_attorney = DB::table('attorneys')
        //                     ->join('states', 'attorneys.state_id', '=', 'states.id')
        //                     ->join('counties', [['attorneys.county_id', '=', 'counties.id'],['attorneys.state_id', '=', 'counties.state_id']])
        //                     ->where('user_id', $attorney_user_id->attorney_id)
        //                     ->select('attorneys.*','states.state', 'counties.id','counties.county_name')
        //                     ->get()->first();
        //                 $caseattytitle='Co-Counsel';
        //                 if(count($attorney_ids)==1 && $attorney_user_id->trial_attorney=='Yes'){
        //                     $caseattytitle='Trial Attorney and Counsel';
        //                 }
        //                 if(count($attorney_ids)>1 && $attorney_user_id->trial_attorney=='Yes'){
        //                     $caseattytitle='Trial Attorney and Co-Counsel';
        //                 }

        //                 $attorneycitystatezip=$party_attorney->firm_city.', '.$party_attorney->state.' '.$party_attorney->firm_zipcode;

        //                 $num1++;
        //                 $attorney['signnameR'.$num.'A'.$num1.'']=$party_attorney->document_sign_name;
        //                 $attorney['firmR'.$num.'A'.$num1.'']=$party_attorney->firm_name;
        //                 $attorney['streetadR'.$num.'A'.$num1.'']=$party_attorney->firm_street_address;
        //                 $attorney['unitR'.$num.'A'.$num1.'']=$party_attorney->firm_suite_unit_mailcode;
        //                 $attorney['poboxR'.$num.'A'.$num1.'']=$party_attorney->po_box;
        //                 $attorney['citystatezipR'.$num.'A'.$num1.'']=$attorneycitystatezip;
        //                 $attorney['telephoneR'.$num.'A'.$num1.'']=$party_attorney->firm_telephone;
        //                 $attorney['faxR'.$num.'A'.$num1.'']=$party_attorney->firm_fax;
        //                 $attorney['emailR'.$num.'A'.$num1.'']=$attorneyemail;
                        
        //             }
        //             $limit=$num1+1;
        //             for($j=$limit; $j<=3; $j++){
        //                 $attorney['signnameR'.$num.'A'.$j.'']=NULL;
        //                 $attorney['firmR'.$num.'A'.$j.'']=NULL;
        //                 $attorney['streetadR'.$num.'A'.$j.'']=NULL;
        //                 $attorney['unitR'.$num.'A'.$j.'']=NULL;
        //                 $attorney['poboxR'.$num.'A'.$j.'']=NULL;
        //                 $attorney['citystatezipR'.$num.'A'.$j.'']=NULL;
        //                 $attorney['telephoneR'.$num.'A'.$j.'']=NULL;
        //                 $attorney['faxR'.$num.'A'.$j.'']=NULL;
        //                 $attorney['emailR'.$num.'A'.$j.'']=NULL;
        //             }

        //             $partytypeattorneyinfoprev=PleadingReceiversAttorneysInfo2::where('pleading_id', $pleading_id)->get()->first();
        //             if($partytypeattorneyinfoprev){
        //                 $partytypeattorneyinfo=$partytypeattorneyinfoprev->fill($attorney)->save();
        //             } else {
        //                 $partytypeattorneyinfo=PleadingReceiversAttorneysInfo2::create($attorney);
        //             }
        //         } else {
        //             $attorney2=array('pleading_id'=>$pleading_id);
        //             $partytypeattorneyinfoprev=PleadingReceiversAttorneysInfo2::where('pleading_id', $pleading_id)->get()->first();
        //             if($partytypeattorneyinfoprev){
        //                 $partytypeattorneyinfo=$partytypeattorneyinfoprev->fill($attorney2)->save();
        //             } else {
        //                 $partytypeattorneyinfo=PleadingReceiversAttorneysInfo2::create($attorney2);
        //             }
        //         }
        //     }

        //     ++$numreceivers; 
        //     // end for updating party attornies info
        // }
        // $partytypeinfoprev=PleadingReceiversInfo::where('pleading_id', $pleading_id)->get()->first();
        // if($partytypeinfoprev){
        //     $partytypeinfo=$partytypeinfoprev->fill($pleading_parties_info1)->save();
        // } else {
        //     $partytypeinfo=PleadingReceiversInfo::create($pleading_parties_info1);
        // }
        // // end for updating receiver info

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
