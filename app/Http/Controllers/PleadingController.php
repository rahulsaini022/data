<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Pleading;
use App\Pleadingparty;
use App\Courtcase;
use App\Caseuser;
use App\User;
use Auth;
use Session;
use App\DrPersonalInfo;
use App\DrChildren;
use App\DrTemporaryOrders;
use App\DrInsurance;
use App\DrMonthlyHousingExpenses;
use App\DrMonthlyHealthCareExpenses;
use App\DrMonthlyEducationExpenses;
use App\DrGiftInheritance;
use App\DrMonthlyLivingExpenses;
use App\DrMonthlyDebtPayments;
use App\DrMarriageInfo;
use App\DrSpousalSupportThisMarriage;
use App\DrMonthlyExpensesChildrenOfThisMarriage;
use App\DrFundsOnDeposit;
use App\DrStocksInvestments;
use App\DrRealEstate;
use App\DrRetirementAccts;
use App\DrVehicles;
use App\DrPension;
use App\State;
use App\County;
use App\AuxTable;
use App\Partyattorney;
use App\PleadingSendersInfo;
use App\PleadingSendersAttorneysInfo1;
use App\PleadingSendersAttorneysInfo2;
use App\PleadingReceiversInfo;
use App\PleadingReceiversAttorneysInfo1;
use App\PleadingReceiversAttorneysInfo2;
use App\Setting;

class PleadingController extends Controller

{
    // to show pleadings options for each case
    public function getCasePleadings($case_id)
    {
        Session::forget('has_third_party'); Session::forget('redirect_to'); Session::forget('pleading_id'); Session::forget('complete_initial_interview');

        $case_data=Courtcase::find($case_id);
        if(isset($case_data) && $case_data->attorney_id==Auth::user()->id && $case_data->payment_status=='1'){
            $user_ids_top=Caseuser::where([['case_id', $case_id],['party_group', 'top']])->get()->pluck('user_id')->all();

            $top_party_data=array();
            $i=0;
            if($user_ids_top){
                $case_data['total_top_parties']=count($user_ids_top);
                foreach($user_ids_top as $user_id){
                    $top_party_data[$i]=User::where('id', $user_id)->get()->first();
                    $caseuser=Caseuser::where([
                        ['case_id', $case_id],
                        ['attorney_id', Auth::user()->id],
                        ['user_id', $user_id]
                    ])->get()
                    ->first();
                    if(isset($caseuser->party_entity) && $caseuser->party_entity=='organization_company') {
                        $top_party_data[$i]['name']=$caseuser->org_comp_name;
                    } else {
                        if(isset($caseuser->mname) && $caseuser->mname !='') {
                            $mname=$caseuser->mname;
                            $namearray = explode(' ', $top_party_data[$i]['name'], 2);
                            if(count($namearray) > 1) {
                                $top_party_data[$i]['name']=$namearray[0].' '.$mname.' '.$namearray[1];
                            } else {
                                $top_party_data[$i]['name']=$top_party_data[$i]['name'].' '.$mname;
                            }
                        }
                    }

                    ++$i;
                }
            }
            $pleadings = Pleading::where([['case_id', $case_id],['parent_pleading_id', '0']])->get();
            $already_has_complaint_pleading=false;
            if(isset($pleadings)){
                foreach($pleadings as $pleading){
                    $k=0;        
                    foreach($pleading->pleadingparties as $pleadingparty){
                        $name=User::where('id', $pleadingparty['party_id'])->get()->pluck('name')->first();
                        $caseuser=Caseuser::where([
                                        ['case_id', $case_id],
                                        ['attorney_id', Auth::user()->id],
                                        ['user_id', $pleadingparty['party_id']]
                                    ])->get()
                                    ->first();
                        if(isset($caseuser->party_entity) && $caseuser->party_entity=='organization_company') {
                            $pleading->pleadingparties[$k]['name']=$caseuser->org_comp_name;
                        } else {
                            if(isset($caseuser->mname) && $caseuser->mname !='') {
                                $mname=$caseuser->mname;
                                $namearray = explode(' ', $name, 2);
                                if(count($namearray) > 1) {
                                    $fullname=$namearray[0].' '.$mname.' '.$namearray[1];
                                } else {
                                    $fullname=$name.' '.$mname;
                                }
                            } else {
                                $fullname=$name;
                            }
                            $pleading->pleadingparties[$k]['name']=$fullname;
                        }
                        // $pleading->pleadingparties[$k]['name']=$name;
                        if(isset($caseuser->type) && $caseuser->type !=''){
                            $pleading->pleadingparties[$k]['type']=$caseuser->type;
                        } else {
                            $pleading->pleadingparties[$k]['type']='';
                        }
                        if(isset($caseuser->party_group) && $caseuser->party_group !=''){
                            $party_group=$caseuser->party_group;
                        } else {
                            $party_group='';
                        }
                        $pleading->pleadingparties[$k]['party_main_group']=$party_group;
                        if(isset($case_data->top_party_type) && $case_data->top_party_type !=''){
                            if($party_group=='top' || $party_group=='bottom'){
                                $pleading->pleadingparties[$k]['party_group']=$case_data[''.$party_group.'_party_type'];
                            }
                            if($party_group=='top_third'){
                                $party_group='top';
                                $pleading->pleadingparties[$k]['party_group']='Third-Party '.$case_data[''.$party_group.'_party_type'];
                            } else if($party_group=='bottom_third'){
                                $party_group='bottom';
                                $pleading->pleadingparties[$k]['party_group']='Third-Party '.$case_data[''.$party_group.'_party_type'];
                            }
                        } else {
                            if($party_group=='top' || $party_group=='bottom'){
                                $pleading->pleadingparties[$k]['party_group']=$case_data['original_'.$party_group.'_party_type'];
                            }
                            if($party_group=='top_third'){
                                $party_group='top';
                                $pleading->pleadingparties[$k]['party_group']='Third-Party '.$case_data['original_'.$party_group.'_party_type'];
                            } else if($party_group=='bottom_third'){
                                $party_group='bottom';
                                $pleading->pleadingparties[$k]['party_group']='Third-Party '.$case_data['original_'.$party_group.'_party_type'];
                            }
                        }

                        //$pleading->pleadingparties[$k]['party_group']=$case_data[''.$party_group.'_party_type'];
                        ++$k;
                    }
                    if($pleading->pleading_type_id == '1'){
                        $already_has_complaint_pleading=true;
                    }

                }
            } else {
                $pleading=NULL;
            }

            // to check if family law interview is completed or not
            $casefamlawdata=true;
            $personalinfo=DrPersonalInfo::where('case_id',$case_id)->get()->pluck('case_id');
            if(isset($personalinfo['0'])){
            } else {
                $casefamlawdata=false;
            }
            $childreninfo=DrChildren::where('case_id',$case_id)->get()->pluck('case_id');
            if(isset($childreninfo['0'])){
            } else {
                $casefamlawdata=false;
            }
            $nsuranceinfo=DrInsurance::where('case_id',$case_id)->get()->pluck('case_id');
            if(isset($nsuranceinfo['0'])){
            } else {
                $casefamlawdata=false;
            }
            $temporaryordersinfo=DrTemporaryOrders::where('case_id',$case_id)->get()->pluck('case_id');
            if(isset($temporaryordersinfo['0'])){
            } else {
                $casefamlawdata=false;
            }
            $monthlyhousingexpensesinfo=DrMonthlyHousingExpenses::where('case_id',$case_id)->get()->pluck('case_id');
            if(isset($monthlyhousingexpensesinfo['0'])){
            } else {
                $casefamlawdata=false;
            }
            $monthlyhealthcareexpensesinfo=DrMonthlyHealthCareExpenses::where('case_id',$case_id)->get()->pluck('case_id');
            if(isset($monthlyhealthcareexpensesinfo['0'])){
            } else {
                $casefamlawdata=false;
            }
            $monthlyeducationexpensesinfo=DrMonthlyEducationExpenses::where('case_id',$case_id)->get()->pluck('case_id');
            if(isset($monthlyeducationexpensesinfo['0'])){
            } else {
                $casefamlawdata=false;
            }
            $giftinheritanceinfo=DrGiftInheritance::where('case_id',$case_id)->get()->pluck('case_id');
            if(isset($giftinheritanceinfo['0'])){
            } else {
                $casefamlawdata=false;
            }
            $monthlylivingexpensesinfo=DrMonthlyLivingExpenses::where('case_id',$case_id)->get()->pluck('case_id');
            if(isset($monthlylivingexpensesinfo['0'])){
            } else {
                $casefamlawdata=false;
            }
            $monthlydebtpaymentsinfo=DrMonthlyDebtPayments::where('case_id',$case_id)->get()->pluck('case_id');
            if(isset($monthlydebtpaymentsinfo['0'])){
            } else {
                $casefamlawdata=false;
            }
            $marriageinfo=DrMarriageInfo::where('case_id',$case_id)->get()->pluck('case_id');
            if(isset($marriageinfo['0'])){
            } else {
                $casefamlawdata=false;
            }
            $spousalsupportthismarriage=DrSpousalSupportThisMarriage::where('case_id',$case_id)->get()->pluck('case_id');
            if(isset($spousalsupportthismarriage['0'])){
            } else {
                $casefamlawdata=false;
            }
            $Num_MinorDependant_Children_of_this_Marriage=DrMarriageInfo::where('case_id',$case_id)->get()->pluck('Num_MinorDependant_Children_of_this_Marriage')->first();
            if(isset($Num_MinorDependant_Children_of_this_Marriage)){
                $monthlyexpenseschildrenofthismarriage=DrMonthlyExpensesChildrenOfThisMarriage::where('case_id',$case_id)->get()->pluck('case_id');
                if(isset($monthlyexpenseschildrenofthismarriage['0'])){
                } else {
                    $casefamlawdata=false;
                }
            } else {
                $casefamlawdata=false;
            }
            $fundsondeposit=DrFundsOnDeposit::where('case_id',$case_id)->get()->pluck('case_id');
            if(isset($fundsondeposit['0'])){
            } else {
                $casefamlawdata=false;
            }
            $stocksinvestments=DrStocksInvestments::where('case_id',$case_id)->get()->pluck('case_id');
            if(isset($stocksinvestments['0'])){
            } else {
                $casefamlawdata=false;
            }
            $realestate=DrRealEstate::where('case_id',$case_id)->get()->pluck('case_id');
            if(isset($realestate['0'])){
            } else {
                $casefamlawdata=false;
            }
            $retirementaccts=DrRetirementAccts::where('case_id',$case_id)->get()->pluck('case_id');
            if(isset($retirementaccts['0'])){
            } else {
                $casefamlawdata=false;
            }
            $vehicles=DrVehicles::where('case_id',$case_id)->get()->pluck('case_id');
            if(isset($vehicles['0'])){
            } else {
                $casefamlawdata=false;
            }
            $pension=DrPension::where('case_id',$case_id)->get()->pluck('case_id');
            if(isset($pension['0'])){
            } else {
                $casefamlawdata=false;
            }
            $user_ids_bottom=Caseuser::where([['case_id', $case_id],['party_group', 'bottom']])->get()->all();
           

            // to get Case Practice Aids Dropdown
          $case_practice_aids_FamLaw=DB::table('document_package_table')->select('package_name')->where('dropdown_name', 'Case_Practice_Aids')->where('num_clients_limit',"=>",count($user_ids_top))->where('num_ops_limit','=>',count($user_ids_bottom))->groupBy('package_name')->orderBy('dropdown_priority', 'ASC')->orderBy('hash_id', 'ASC')->get();
            foreach($case_practice_aids_FamLaw as $key => $val){
                 $doctypecc = DB::table('document_table')->where('doc_disp_name',$val->package_name)->pluck('document_out_format')->first();

                    $val->document_out_format = $doctypecc;
            }

            /* $DraftNewMotion=DB::table('document_package_table')->select('package_name')->where('dropdown_name', 'motions')->where('num_clients_limit',"=>",count($user_ids_top))->where('num_ops_limit','=>',count($user_ids_bottom))->groupBy('package_name')->orderBy('dropdown_priority', 'ASC')->orderBy('hash_id', 'ASC')->get();

            foreach($DraftNewMotion as $key => $val){
                 $doctypecc = DB::table('document_table')->where('doc_disp_name',$val->package_name)->pluck('document_out_format')->first();

                    $val->document_out_format = $doctypecc;
            }*/

             $DraftNewMotion=DB::table('document_table')->select('document_out_format')->where('doc_type', 'motions')->where('num_clients_limit',"=>",count($user_ids_top))->where('num_ops_limit','=>',count($user_ids_bottom))->orderBy('doc_number', 'ASC')->get();

           /* foreach($DraftNewMotion as $key => $val){
                 $doctypecc = DB::table('document_table')->where('doc_disp_name',$val->package_name)->pluck('document_out_format')->first();

                    $val->document_out_format = $doctypecc;
            }*/
            $DraftNewPleading=DB::table('document_table')->select('document_out_format')->where('doc_type', 'Pleadings')->where('num_clients_limit',"=>",count($user_ids_top))->where('num_ops_limit','=>',count($user_ids_bottom))->orderBy('doc_number', 'ASC')->get();

            $Notices=DB::table('document_table')->select('document_out_format')->where('doc_type', 'Notices')->where('num_clients_limit',"=>",count($user_ids_top))->where('num_ops_limit','=>',count($user_ids_bottom))->orderBy('doc_number', 'ASC')->get();
            $case_practice_aids_NFL=DB::table('document_package_table')->select('package_name')->where('dropdown_name', 'Case_Practice_Aids')->groupBy('package_name')->orderBy('dropdown_priority', 'ASC')->orderBy('hash_id', 'ASC')->get();

             foreach($case_practice_aids_NFL as $key => $val){
                 $doctypecc = DB::table('document_table')->where('doc_disp_name',$val->package_name)->pluck('document_out_format')->first();

                    $val->document_out_format = $doctypecc;
            }

            $case_complaints_Not_FamLaw=DB::table('document_package_table')->select('package_name')->where('dropdown_name', 'Complaints_Not_FamLaw')->groupBy('package_name')->orderBy('dropdown_priority', 'ASC')->orderBy('hash_id', 'ASC')->get();
            foreach($case_complaints_Not_FamLaw as $key => $val){
                 $doctypecc = DB::table('document_table')->where('doc_disp_name',$val->package_name)->pluck('document_out_format')->first();

                    $val->document_out_format = $doctypecc;
            }
            $case_complaints_FamLaw=DB::table('document_package_table')->select('package_name')->where('dropdown_name', 'Complaints_FamLaw')->groupBy('package_name')->orderBy('dropdown_priority', 'ASC')->orderBy('hash_id', 'ASC')->get();
            foreach($case_complaints_FamLaw as $key => $val){
                 $doctypecc = DB::table('document_table')->where('doc_disp_name',$val->package_name)->pluck('document_out_format')->first();

                    $val->document_out_format = $doctypecc;
            }
            $PostComplaintPleadings_NOT_FamLaw=DB::table('document_package_table')->select('package_name')->where('dropdown_name', 'PostComplaintPleadings_NOT_FamLaw')->groupBy('package_name')->orderBy('dropdown_priority', 'ASC')->orderBy('hash_id', 'ASC')->get();
             foreach($PostComplaintPleadings_NOT_FamLaw as $key => $val){
                 $doctypecc = DB::table('document_table')->where('doc_disp_name',$val->package_name)->pluck('document_out_format')->first();

                    $val->document_out_format = $doctypecc;
            }
            $PostComplaintPleadings_FamLaw=DB::table('document_package_table')->select('package_name')->where('dropdown_name', 'PostComplaintPleadings_FamLaw')->groupBy('package_name')->orderBy('dropdown_priority', 'ASC')->orderBy('hash_id', 'ASC')->get();
            foreach($PostComplaintPleadings_FamLaw as $key => $val){
                 $doctypecc = DB::table('document_table')->where('doc_disp_name',$val->package_name)->pluck('document_out_format')->first();

                    $val->document_out_format = $doctypecc;
            }
            $PostDecreeMotions_FamLaw=DB::table('document_package_table')->select('package_name')->where('dropdown_name', 'PostDecreeMotions_FamLaw')->groupBy('package_name')->orderBy('dropdown_priority', 'ASC')->orderBy('hash_id', 'ASC')->get();

            $TP_Complaints=DB::table('document_package_table')->select('package_name')->where('dropdown_name', 'TP_Complaints')->groupBy('package_name')->orderBy('dropdown_priority', 'ASC')->orderBy('hash_id', 'ASC')->get();
            $Resp_Complaints=DB::table('document_package_table')->select('package_name')->where('dropdown_name', 'Resp_Complaints')->groupBy('package_name')->orderBy('dropdown_priority', 'ASC')->orderBy('hash_id', 'ASC')->get();
            $TP_Answer=DB::table('document_package_table')->select('package_name')->where('dropdown_name', 'TP_Answer')->groupBy('package_name')->orderBy('dropdown_priority', 'ASC')->orderBy('hash_id', 'ASC')->get();
            $Resp_Answer=DB::table('document_package_table')->select('package_name')->where('dropdown_name', 'Resp_Answer')->groupBy('package_name')->orderBy('dropdown_priority', 'ASC')->orderBy('hash_id', 'ASC')->get();
            $TP_Answer_CC=DB::table('document_package_table')->select('package_name')->where('dropdown_name', 'TP_Answer_CC')->groupBy('package_name')->orderBy('dropdown_priority', 'ASC')->orderBy('hash_id', 'ASC')->get();
            $Resp_Answer_CC=DB::table('document_package_table')->select('package_name')->where('dropdown_name', 'Resp_Answer_CC')->groupBy('package_name')->orderBy('dropdown_priority', 'ASC')->orderBy('hash_id', 'ASC')->get();
            $TP_Answer_3P=DB::table('document_package_table')->select('package_name')->where('dropdown_name', 'TP_Answer_3P')->groupBy('package_name')->orderBy('dropdown_priority', 'ASC')->orderBy('hash_id', 'ASC')->get();
            $Resp_Answer_3P=DB::table('document_package_table')->select('package_name')->where('dropdown_name', 'Resp_Answer_3P')->groupBy('package_name')->orderBy('dropdown_priority', 'ASC')->orderBy('hash_id', 'ASC')->get();
            $TP_Answer_CC_3p=DB::table('document_package_table')->select('package_name')->where('dropdown_name', 'TP_Answer_CC_3p')->groupBy('package_name')->orderBy('dropdown_priority', 'ASC')->orderBy('hash_id', 'ASC')->get();
            $Resp_Answer_CC_3p=DB::table('document_package_table')->select('package_name')->where('dropdown_name', 'Resp_Answer_CC_3p')->groupBy('package_name')->orderBy('dropdown_priority', 'ASC')->orderBy('hash_id', 'ASC')->get();
            $TP_Answer_to_CC=DB::table('document_package_table')->select('package_name')->where('dropdown_name', 'TP_Answer_to_CC')->groupBy('package_name')->orderBy('dropdown_priority', 'ASC')->orderBy('hash_id', 'ASC')->get();
            $Resp_Answer_to_CC=DB::table('document_package_table')->select('package_name')->where('dropdown_name', 'Resp_Answer_to_CC')->groupBy('package_name')->orderBy('dropdown_priority', 'ASC')->orderBy('hash_id', 'ASC')->get();
            $TP_Answer_to_3P=DB::table('document_package_table')->select('package_name')->where('dropdown_name', 'TP_Answer_to_3P')->groupBy('package_name')->orderBy('dropdown_priority', 'ASC')->orderBy('hash_id', 'ASC')->get();
            $Resp_Answer_to_3P=DB::table('document_package_table')->select('package_name')->where('dropdown_name', 'Resp_Answer_to_3P')->groupBy('package_name')->orderBy('dropdown_priority', 'ASC')->orderBy('hash_id', 'ASC')->get();
            $TP_Answer_to_3P_CC=DB::table('document_package_table')->select('package_name')->where('dropdown_name', 'TP_Answer_to_3P_CC')->groupBy('package_name')->orderBy('dropdown_priority', 'ASC')->orderBy('hash_id', 'ASC')->get();
            $Resp_Answer_to_3P_CC=DB::table('document_package_table')->select('package_name')->where('dropdown_name', 'Resp_Answer_to_3P_CC')->groupBy('package_name')->orderBy('dropdown_priority', 'ASC')->orderBy('hash_id', 'ASC')->get();
            $TP_Answer_to_3PCC=DB::table('document_package_table')->select('package_name')->where('dropdown_name', 'TP_Answer_to_3PCC')->groupBy('package_name')->orderBy('dropdown_priority', 'ASC')->orderBy('hash_id', 'ASC')->get();
            $Resp_Answer_to_3PCC=DB::table('document_package_table')->select('package_name')->where('dropdown_name', 'Resp_Answer_to_3PCC')->groupBy('package_name')->orderBy('dropdown_priority', 'ASC')->orderBy('hash_id', 'ASC')->get();
            $TP_Complaint1_FamLaw=DB::table('document_package_table')->select('package_name')->where('dropdown_name', 'TP_Complaint1_FamLaw')->groupBy('package_name')->orderBy('dropdown_priority', 'ASC')->orderBy('hash_id', 'ASC')->get();
            $Resp_Complaint1_FamLaw=DB::table('document_package_table')->select('package_name')->where('dropdown_name', 'Resp_Complaint1_FamLaw')->groupBy('package_name')->orderBy('dropdown_priority', 'ASC')->orderBy('hash_id', 'ASC')->get();
            $TP_Complaint2_FamLaw=DB::table('document_package_table')->select('package_name')->where('dropdown_name', 'TP_Complaint2_FamLaw')->groupBy('package_name')->orderBy('dropdown_priority', 'ASC')->orderBy('hash_id', 'ASC')->get();
            $Resp_Complaint2_FamLaw=DB::table('document_package_table')->select('package_name')->where('dropdown_name', 'Resp_Complaint2_FamLaw')->groupBy('package_name')->orderBy('dropdown_priority', 'ASC')->orderBy('hash_id', 'ASC')->get();
            $TP_Complaint3_FamLaw=DB::table('document_package_table')->select('package_name')->where('dropdown_name', 'TP_Complaint3_FamLaw')->groupBy('package_name')->orderBy('dropdown_priority', 'ASC')->orderBy('hash_id', 'ASC')->get();
            $Resp_Complaint3_FamLaw=DB::table('document_package_table')->select('package_name')->where('dropdown_name', 'Resp_Complaint3_FamLaw')->groupBy('package_name')->orderBy('dropdown_priority', 'ASC')->orderBy('hash_id', 'ASC')->get();
            $TP_Petition1_FamLaw=DB::table('document_package_table')->select('package_name')->where('dropdown_name', 'TP_Petition1_FamLaw')->groupBy('package_name')->orderBy('dropdown_priority', 'ASC')->orderBy('hash_id', 'ASC')->get();
            $Resp_Petition1_FamLaw=DB::table('document_package_table')->select('package_name')->where('dropdown_name', 'Resp_Petition1_FamLaw')->groupBy('package_name')->orderBy('dropdown_priority', 'ASC')->orderBy('hash_id', 'ASC')->get();
            
            $select_action_data=array(
                'TP_Complaints' => $TP_Complaints,
                'Resp_Complaints' => $Resp_Complaints,
                'TP_Answer' => $TP_Answer,
                'Resp_Answer' => $Resp_Answer,
                'TP_Answer_CC' => $TP_Answer_CC,
                'Resp_Answer_CC' => $Resp_Answer_CC,
                'TP_Answer_3P' => $TP_Answer_3P,
                'Resp_Answer_3P' => $Resp_Answer_3P,
                'TP_Answer_CC_3p' => $TP_Answer_CC_3p,
                'Resp_Answer_CC_3p' => $Resp_Answer_CC_3p,
                'TP_Answer_to_CC' => $TP_Answer_to_CC,
                'Resp_Answer_to_CC' => $Resp_Answer_to_CC,
                'TP_Answer_to_3P' => $TP_Answer_to_3P,
                'Resp_Answer_to_3P' => $Resp_Answer_to_3P,
                'TP_Answer_to_3P_CC' => $TP_Answer_to_3P_CC,
                'Resp_Answer_to_3P_CC' => $Resp_Answer_to_3P_CC,
                'TP_Answer_to_3PCC' => $TP_Answer_to_3PCC,
                'Resp_Answer_to_3PCC' => $Resp_Answer_to_3PCC,
                'TP_Complaint1_FamLaw' => $TP_Complaint1_FamLaw,
                'Resp_Complaint1_FamLaw' => $Resp_Complaint1_FamLaw,
                'TP_Complaint2_FamLaw' => $TP_Complaint2_FamLaw,
                'Resp_Complaint2_FamLaw' => $Resp_Complaint2_FamLaw,
                'TP_Complaint3_FamLaw' => $TP_Complaint3_FamLaw,
                'Resp_Complaint3_FamLaw' => $Resp_Complaint3_FamLaw,
                'TP_Petition1_FamLaw' => $TP_Petition1_FamLaw,
                'Resp_Petition1_FamLaw' => $Resp_Petition1_FamLaw,
            );

            // dd($subordinatepleadings);
            return view('pleadings.index',compact('case_data', 'pleadings', 'top_party_data', 'casefamlawdata', 'case_practice_aids_FamLaw', 'case_practice_aids_NFL', 'already_has_complaint_pleading', 'case_complaints_Not_FamLaw', 'case_complaints_FamLaw', 'PostComplaintPleadings_NOT_FamLaw', 'PostComplaintPleadings_FamLaw', 'PostDecreeMotions_FamLaw', 'select_action_data','DraftNewMotion','DraftNewPleading','Notices'));
        } else {
            // return view('pleadings.index',['case_id' => $case_id]);
            return redirect()->route('cases.index');

        }

    }

    /* Show Create Case Pleading Form */
    public function createCasePleadings($case_id)
    {
        Session::forget('has_third_party'); Session::forget('redirect_to'); Session::forget('pleading_id');

        $case_data=Courtcase::find($case_id);
        if(isset($case_data) && $case_data->attorney_id==Auth::user()->id && $case_data->payment_status=='1'){
            $user_ids_top=Caseuser::where([['case_id', $case_id],['party_group', 'top']])->get()->pluck('user_id')->all();
            $user_ids_bottom=Caseuser::where([['case_id', $case_id],['party_group', 'bottom']])->get()->pluck('user_id')->all();
            $top_party_data=array();
            $i=0;
            if($user_ids_top){
                $case_data['total_top_parties']=count($user_ids_top);
                foreach($user_ids_top as $user_id){
                    $top_party_data[$i]=User::where('id', $user_id)->get()->first();
                    $caseuser=Caseuser::where([
                        ['case_id', $case_id],
                        ['attorney_id', Auth::user()->id],
                        ['user_id', $user_id]
                    ])->get()
                    ->first();
                    if(isset($caseuser->party_entity) && $caseuser->party_entity=='organization_company') {
                        $top_party_data[$i]['name']=$caseuser->org_comp_name;
                    } else {
                        if(isset($caseuser->mname) && $caseuser->mname !='') {
                            $mname=$caseuser->mname;
                            $namearray = explode(' ', $top_party_data[$i]['name'], 2);
                            if(count($namearray) > 1) {
                                $top_party_data[$i]['name']=$namearray[0].' '.$mname.' '.$namearray[1];
                            } else {
                                $top_party_data[$i]['name']=$top_party_data[$i]['name'].' '.$mname;
                            }
                        }
                    }

                    ++$i;
                }
            }
            $bottom_party_data=array();
            $i=0;
            if($user_ids_bottom){
                $case_data['total_bottom_parties']=count($user_ids_bottom);
                foreach($user_ids_bottom as $user_id){
                    $bottom_party_data[$i]=User::where('id', $user_id)->get()->first();
                    $caseuser=Caseuser::where([
                        ['case_id', $case_id],
                        ['attorney_id', Auth::user()->id],
                        ['user_id', $user_id]
                    ])->get()
                    ->first();
                    if(isset($caseuser->party_entity) && $caseuser->party_entity=='organization_company') {
                        $bottom_party_data[$i]['name']=$caseuser->org_comp_name;
                    } else {
                        if(isset($caseuser->mname) && $caseuser->mname !='') {
                            $mname=$caseuser->mname;
                            $namearray = explode(' ', $bottom_party_data[$i]['name'], 2);
                            if(count($namearray) > 1) {
                                $bottom_party_data[$i]['name']=$namearray[0].' '.$mname.' '.$namearray[1];
                            } else {
                                $bottom_party_data[$i]['name']=$bottom_party_data[$i]['name'].' '.$mname;
                            }
                        }
                    }

                    ++$i;
                }
            }

            // for third parties
            $user_ids_top_third=Caseuser::where([['case_id', $case_id],['party_group', 'top_third']])->get()->pluck('user_id')->all();
            $user_ids_bottom_third=Caseuser::where([['case_id', $case_id],['party_group', 'bottom_third']])->get()->pluck('user_id')->all();
            $top_third_party_data=array();
            $i=0;
            if($user_ids_top_third){
                $case_data['total_top_third_parties']=count($user_ids_top_third);
                foreach($user_ids_top_third as $user_id){
                    $top_third_party_data[$i]=User::where('id', $user_id)->get()->first();
                    $caseuser=Caseuser::where([
                        ['case_id', $case_id],
                        ['attorney_id', Auth::user()->id],
                        ['user_id', $user_id]
                    ])->get()
                    ->first();
                    if(isset($caseuser->party_entity) && $caseuser->party_entity=='organization_company') {
                        $top_third_party_data[$i]['name']=$caseuser->org_comp_name;
                    } else {
                        if(isset($caseuser->mname) && $caseuser->mname !='') {
                            $mname=$caseuser->mname;
                            $namearray = explode(' ', $top_third_party_data[$i]['name'], 2);
                            if(count($namearray) > 1) {
                                $top_third_party_data[$i]['name']=$namearray[0].' '.$mname.' '.$namearray[1];
                            } else {
                                $top_third_party_data[$i]['name']=$top_third_party_data[$i]['name'].' '.$mname;
                            }
                        }
                    }

                    ++$i;
                }
            }
            $bottom_third_party_data=array();
            $i=0;
            if($user_ids_bottom_third){
                $case_data['total_bottom_third_parties']=count($user_ids_bottom_third);
                foreach($user_ids_bottom_third as $user_id){
                    $bottom_third_party_data[$i]=User::where('id', $user_id)->get()->first();
                    $caseuser=Caseuser::where([
                        ['case_id', $case_id],
                        ['attorney_id', Auth::user()->id],
                        ['user_id', $user_id]
                    ])->get()
                    ->first();
                    if(isset($caseuser->party_entity) && $caseuser->party_entity=='organization_company') {
                        $bottom_third_party_data[$i]['name']=$caseuser->org_comp_name;
                    } else {
                        if(isset($caseuser->mname) && $caseuser->mname !='') {
                            $mname=$caseuser->mname;
                            $namearray = explode(' ', $bottom_third_party_data[$i]['name'], 2);
                            if(count($namearray) > 1) {
                                $bottom_third_party_data[$i]['name']=$namearray[0].' '.$mname.' '.$namearray[1];
                            } else {
                                $bottom_third_party_data[$i]['name']=$bottom_third_party_data[$i]['name'].' '.$mname;
                            }
                        }
                    }

                    ++$i;
                }
            }

            // user ids of top and bottom parties
            
            $user_ids_top_string=implode(" ", $user_ids_top);
            $user_ids_bottom_string=implode(" ", $user_ids_bottom);

            $pleading_types=DB::table('pleading_types')->get()->all();
            $pleadings = Pleading::where([['case_id', $case_id],['parent_pleading_id', '0']])->get();
            $pleading_level=count($pleadings)+1;
            
            $already_has_complaint_pleading = Pleading::where([['case_id', $case_id],['parent_pleading_id', '0'],['pleading_type_id', '1']])->get();

            return view('pleadings.create',['case_id' => $case_id, 'top_party_data' => $top_party_data, 'bottom_party_data' => $bottom_party_data, 'top_third_party_data' => $top_third_party_data, 'bottom_third_party_data' => $bottom_third_party_data, 'case_data' => $case_data, 'pleading_types' => $pleading_types, 'pleading_level' => $pleading_level, 'user_ids_top_string' => $user_ids_top_string, 'user_ids_bottom_string' => $user_ids_bottom_string, 'already_has_complaint_pleading' => $already_has_complaint_pleading]);    
        } else {
            // return view('pleadings.index',['case_id' => $case_id]);
            return redirect()->route('cases.index');

        }

    }

    /* Store Case Pleading Info */
    public function storeCasePleadings(Request $request)
    {
        $result = $request->except('submit');
        $case_id=$request->case_id;

        $user_ids_top_string=$request->user_ids_top_string;
        $user_ids_bottom_string=$request->user_ids_bottom_string;
        $user_ids_top_string=explode(" ", $user_ids_top_string);
        $user_ids_bottom_string=explode(" ", $user_ids_bottom_string);
        $pleading_caption='';
        foreach($user_ids_top_string as $user_id){
            $user_data=User::where('id', $user_id)->get()->first();
            $caseuser=Caseuser::where([
                ['case_id', $case_id],
                ['attorney_id', Auth::user()->id],
                ['user_id', $user_id]
            ])->get()
            ->first();
            $user_name=$user_data['name'];

            if(isset($caseuser->party_entity) && $caseuser->party_entity=='organization_company') {
                $user_name=$caseuser->org_comp_name;
            } else {
                if(isset($caseuser->mname) && $caseuser->mname!='') {
                    $mname=$caseuser->mname;
                }
                if(isset($mname) && $mname !='') {
                    $namearray = explode(' ', $user_data['name'], 2);
                    if(count($namearray) > 1) {
                        $user_name=$namearray[0].' '.$mname.' '.$namearray[1];
                    } else {
                        $user_name=$user_data['name'].' '.$mname;
                    }
                }
            }
            $street_address=$caseuser->street_address;
            $user_city=$caseuser->user_city;
            if(isset($caseuser->state_id) && $caseuser->state_id !=''){
                $state_name=State::find($caseuser->state_id)->state;
            } else {
                $state_name='';
            }
            $user_zipcode=$caseuser->user_zipcode;
            if($pleading_caption==''){
                if(isset($street_address) && isset($user_city) && isset($caseuser->state_id) && isset($user_zipcode)){
                    $pleading_caption=$pleading_caption.$user_name.' '.$street_address.' '.$user_city.', '.$state_name.', '.$user_zipcode;
                } else {
                    $pleading_caption=$pleading_caption.$user_name;
                }
            } else {
                if(isset($street_address) && isset($user_city) && isset($caseuser->state_id) && isset($user_zipcode)){
                    $pleading_caption=$pleading_caption.' and '.$user_name.' '.$street_address.' '.$user_city.', '.$state_name.', '.$user_zipcode;
                } else {
                    $pleading_caption=$pleading_caption.' and '.$user_name;
                }
            }
        }
        $pleading_caption=$pleading_caption.' '.strtoupper($request->top_party_type).'S vs. ';
        $test='';
        foreach($user_ids_bottom_string as $user_id){
            $user_data=User::where('id', $user_id)->get()->first();
            $caseuser=Caseuser::where([
                ['case_id', $case_id],
                ['attorney_id', Auth::user()->id],
                ['user_id', $user_id]
            ])->get()
            ->first();
            $user_name=$user_data['name'];

            if(isset($caseuser->party_entity) && $caseuser->party_entity=='organization_company') {
                $user_name=$caseuser->org_comp_name;
            } else {
                if(isset($caseuser->mname) && $caseuser->mname!='') {
                    $mname=$caseuser->mname;
                }
                if(isset($mname) && $mname !='') {
                    $namearray = explode(' ', $user_data['name'], 2);
                    if(count($namearray) > 1) {
                        $user_name=$namearray[0].' '.$mname.' '.$namearray[1];
                    } else {
                        $user_name=$user_data['name'].' '.$mname;
                    }
                }
            }
            $street_address=$caseuser->street_address;
            $user_city=$caseuser->user_city;
            if(isset($caseuser->state_id) && $caseuser->state_id !=''){
                $state_name= State::find($caseuser->state_id)->state;
            } else {
                $state_name='';
            }
            $user_zipcode=$caseuser->user_zipcode;
            if($test==''){
                if(isset($street_address) && isset($user_city) && isset($caseuser->state_id) && isset($user_zipcode)){
                    $pleading_caption=$pleading_caption.$user_name.' '.$street_address.' '.$user_city.', '.$state_name.', '.$user_zipcode;
                } else {
                    $pleading_caption=$pleading_caption.$user_name;
                }
            } else {
                if(isset($street_address) && isset($user_city) && isset($caseuser->state_id) && isset($user_zipcode)){
                    $pleading_caption=$pleading_caption.' and '.$user_name.' '.$street_address.' '.$user_city.', '.$state_name.', '.$user_zipcode;
                } else {
                    $pleading_caption=$pleading_caption.' and '.$user_name;
                }
            }
            $test='test';
        }
        $pleading_caption=$pleading_caption.' '.strtoupper($request->bottom_party_type).'S';

        $filings=$request->filings;
        if($request->responsibles){
            $responsibles=$request->responsibles;
        } else {
            $responsibles=[];
        }

        if($request->date_filed){
            $date_filed=date("Y-m-d",strtotime($request->date_filed));
        } else {
            $date_filed=NULL;
        }
        $data=array(
            'case_id'=>$request->case_id,
            'pleading_caption'=>$pleading_caption,
            'pleading_name'=>$request->pleading_name,
            'date_filed'=>$date_filed,
            'pleading_type_id'=>$request->pleading_type_id,
            'pleading_category'=>'New Core Pleading',
            'parent_pleading_id'=>'0',
            'pleading_has_new_third_parties'=>$request->pleading_has_new_third_parties,
            'pleading_includes_claims'=>$request->pleading_includes_claims,
            'pleading_level' => $request->pleading_level,
        );
        $pleading = Pleading::create($data);
        $totalsenders=0;$totalreceivers=0;$totalobservers=0;
        $data2=array();
        if($filings){
            $num=1;
            foreach ($filings as $filing) {
                $party_type="filing";
                $party_class="S".$num++;
                $data2[] = $data = array(
                    'pleading_id' => $pleading->id,
                    'party_id' => $filing,
                    'party_type' => $party_type,
                    'party_class' => $party_class,
                    'service_date' => NULL,
                    'initial_deadline' => NULL,
                    'current_deadline' => NULL,
                    'created_at'=>now(),
                    'updated_at'=>now(),
                );
                $pleadingparty = Pleadingparty::create($data);
                ++$totalsenders;
            }
        }
        if($responsibles && (isset($request->pleading_includes_claims) && $request->pleading_includes_claims=='Yes')){
            $num=1;
            foreach ($responsibles as $responsible) {
                $service_date=$initial_deadline=$current_deadline=NULL;
                if(isset($result['service_date_'.$responsible.'']) && $result['service_date_'.$responsible.''] !='') 
                {
                    $service_date=date("Y-m-d",strtotime($result['service_date_'.$responsible.'']));
                }
                if(isset($result['initial_deadline_'.$responsible.'']) && $result['initial_deadline_'.$responsible.''] !='') 
                {
                    $initial_deadline=date("Y-m-d",strtotime($result['initial_deadline_'.$responsible.'']));
                }
                if(isset($result['current_deadline_'.$responsible.'']) && $result['current_deadline_'.$responsible.''] !='') 
                {
                    $current_deadline=date("Y-m-d",strtotime($result['current_deadline_'.$responsible.'']));
                }

                $party_type="responsible";
                $party_class="R".$num++;
                $data2[] = $data = array(
                    'pleading_id' => $pleading->id,
                    'party_id' => $responsible,
                    'party_type' => $party_type,
                    'party_class' => $party_class,
                    'service_date' => $service_date,
                    'initial_deadline' => $initial_deadline,
                    'current_deadline' => $current_deadline,
                    'created_at'=>now(),
                    'updated_at'=>now(),
                );
                $pleadingparty = Pleadingparty::create($data);
                ++$totalreceivers;
            }
        }
        // for observers
        $pleading_checked_parties=array_unique(array_merge($filings,$responsibles));
        $pleading_all_parties=Caseuser::where([['case_id', $case_id],['attorney_id', Auth::user()->id]])->get()->pluck('user_id')->all();
        $observers=array_diff($pleading_all_parties,$pleading_checked_parties);

        $num=1;
        foreach ($observers as $observer) {            
            $party_type="NA";
            $party_class="O".$num++;
            $data2[] = $data = array(
                'pleading_id' => $pleading->id,
                'party_id' => $observer,
                'party_type' => $party_type,
                'party_class' => $party_class,
                'service_date' => NULL,
                'initial_deadline' => NULL,
                'current_deadline' => NULL,
                'created_at'=>now(),
                'updated_at'=>now(),
            );
            $pleadingparty = Pleadingparty::create($data);
            ++$totalobservers;
        }
        // $pleadingparty = Pleadingparty::insert($data2);
        // update pleading table
        $pleadingtoupdate = Pleading::find($pleading->id);
        $pleadingtoupdate->num_s = $totalsenders;
        $pleadingtoupdate->num_r = $totalreceivers;
        $pleadingtoupdate->num_o = $totalobservers;

        $pleadingtoupdate->save();
        // dd($pleadingtoupdate);

        // dd($data2);

        // to update senders and receivers info
        $pleading_id=$pleading->id;
        $pleading=Pleading::find($pleading_id);
        $case_id=$pleading->case_id;
        $pleadingparties=$pleading->pleadingparties;
        // for updating sender info
        $num=0;
        $numsenders=0;
        $pleading_parties_info=array(
                            'pleading_id'=>$pleading_id,
                        );
        foreach ($pleadingparties as $pleadingparty)
        {
            if($numsenders < $pleading->num_s){
                $userinfo=User::find($pleadingparty->party_id);
                $name=$userinfo->name;
                $fullname=$userinfo->name;
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
                    if(isset($caseuser->suffix)){
                        if($caseuser->suffix=='I' || $caseuser->suffix=='II' || $caseuser->suffix=='III' || $caseuser->suffix=='IV'){
                            $fullname=$fullname.' '.$caseuser->suffix;
                        } else {
                            $fullname=$fullname.', '.$caseuser->suffix;
                        }
                    }
                }
                if(isset($caseuser->state_id) && $caseuser->state_id !=''){
                    $state_name=State::find($caseuser->state_id)->state;
                } else {
                    $state_name='';
                }
                if(isset($caseuser->county_id) && $caseuser->county_id !=''){
                    $county_name=County::find($caseuser->county_id)->county_name;
                } else {
                    $county_name='';
                }
                if(isset($caseuser->user_city) && $caseuser->user_city !=''){
                    $city_name=$caseuser->user_city;
                } else {
                    $city_name='';
                }
                if(isset($caseuser->user_zipcode) && $caseuser->user_zipcode !=''){
                    $user_zipcode=$caseuser->user_zipcode;
                } else {
                    $user_zipcode='';
                }
                if(isset($caseuser->state_id) && isset($caseuser->user_zipcode) && isset($caseuser->user_city)){
                    $citystatezip=$city_name.', '.$state_name.' '.$caseuser->user_zipcode;
                } else {
                    $citystatezip=NULL;
                }
                
                
                $num_attys=0;
                $attorney_ids=Partyattorney::where([['party_id', $pleadingparty->party_id],['case_id', $case_id]])->get();
                if($attorney_ids){
                    $num_attys=count($attorney_ids);
                }

                $num++;

                $pleading_parties_info['fullnameS'.$num.'']=$fullname;
                $pleading_parties_info['fnameS'.$num.'']=$caseuser->fname;
                $pleading_parties_info['mnameS'.$num.'']=$caseuser->mname;
                $pleading_parties_info['lnameS'.$num.'']=$caseuser->lname;
                $pleading_parties_info['shortnameS'.$num.'']=$caseuser->short_name;
                $pleading_parties_info['genderS'.$num.'']=$caseuser->gender;
                $pleading_parties_info['streetadS'.$num.'']=$caseuser->street_address;
                $pleading_parties_info['unitS'.$num.'']=$caseuser->unit;
                $pleading_parties_info['poboxS'.$num.'']=$caseuser->pobox;
                $pleading_parties_info['citystatezipS'.$num.'']=$citystatezip;
                $pleading_parties_info['telephoneS'.$num.'']=$caseuser->telephone;
                $pleading_parties_info['faxS'.$num.'']=$caseuser->fax;
                $pleading_parties_info['emailS'.$num.'']=$userinfo->email;
                $pleading_parties_info['nameunknownS'.$num.'']=$caseuser->name_unknown;
                $pleading_parties_info['addressunknownS'.$num.'']=$caseuser->address_unknown;
                $pleading_parties_info['gendescS'.$num.'']=$caseuser->gen_desc;
                $pleading_parties_info['ismultidescS'.$num.'']=$caseuser->is_multi_desc;
                $pleading_parties_info['moregendescS'.$num.'']=$caseuser->more_gen_desc;
                $pleading_parties_info['pauperisS'.$num.'']=$caseuser->pauperis;

                // for updating party attornies info
                if($num <= 9)
                {
                    $attorney_ids=Partyattorney::where([['party_id', $pleadingparty->party_id],['case_id', $case_id]])->get()->all();
                    $attorney=array('pleading_id'=>$pleading_id);
                    $num1=0;
                    $totalattornies=count($attorney_ids);
                    foreach($attorney_ids as $attorney_user_id){
                        $attorneyuserinfo=User::find($attorney_user_id->attorney_id);
                        $attorneyname=$attorneyuserinfo->name;
                        $attorneyemail=$attorneyuserinfo->email;
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

                        $attorneycitystatezip=$party_attorney->firm_city.', '.$party_attorney->state.' '.$party_attorney->firm_zipcode;

                        $num1++;
                        $attorney['signnameS'.$num.'A'.$num1.'']=$party_attorney->document_sign_name;
                        $attorney['firmS'.$num.'A'.$num1.'']=$party_attorney->firm_name;
                        $attorney['streetadS'.$num.'A'.$num1.'']=$party_attorney->firm_street_address;
                        $attorney['unitS'.$num.'A'.$num1.'']=$party_attorney->firm_suite_unit_mailcode;
                        $attorney['poboxS'.$num.'A'.$num1.'']=$party_attorney->po_box;
                        $attorney['citystatezipS'.$num.'A'.$num1.'']=$attorneycitystatezip;
                        $attorney['telephoneS'.$num.'A'.$num1.'']=$party_attorney->firm_telephone;
                        $attorney['faxS'.$num.'A'.$num1.'']=$party_attorney->firm_fax;
                        $attorney['emailS'.$num.'A'.$num1.'']=$attorneyemail;
                        
                    }
                    $limit=$num1+1;
                    for($j=$limit; $j<=3; $j++){
                        $attorney['signnameS'.$num.'A'.$j.'']=NULL;
                        $attorney['firmS'.$num.'A'.$j.'']=NULL;
                        $attorney['streetadS'.$num.'A'.$j.'']=NULL;
                        $attorney['unitS'.$num.'A'.$j.'']=NULL;
                        $attorney['poboxS'.$num.'A'.$j.'']=NULL;
                        $attorney['citystatezipS'.$num.'A'.$j.'']=NULL;
                        $attorney['telephoneS'.$num.'A'.$j.'']=NULL;
                        $attorney['faxS'.$num.'A'.$j.'']=NULL;
                        $attorney['emailS'.$num.'A'.$j.'']=NULL;
                    }

                    $partytypeattorneyinfoprev=PleadingSendersAttorneysInfo1::where('pleading_id', $pleading_id)->get()->first();
                    if($partytypeattorneyinfoprev){
                    // dd($attorney);
                        $partytypeattorneyinfo=$partytypeattorneyinfoprev->fill($attorney)->save();
                    } else {
                        $partytypeattorneyinfo=PleadingSendersAttorneysInfo1::create($attorney);
                    }
                }

                if($num > 9)
                {
                    $attorney_ids=Partyattorney::where([['party_id', $pleadingparty->party_id],['case_id', $case_id]])->get()->all();
                    $attorney=array('pleading_id'=>$pleading_id);
                    $num1=0;
                    $totalattornies=count($attorney_ids);
                    foreach($attorney_ids as $attorney_user_id){
                        $attorneyuserinfo=User::where($attorney_user_id->attorney_id);
                        $attorneyname=$attorneyuserinfo->name;
                        $attorneyemail=$attorneyuserinfo->email;
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

                        $attorneycitystatezip=$party_attorney->firm_city.', '.$party_attorney->state.' '.$party_attorney->firm_zipcode;

                        $num1++;
                        $attorney['signnameS'.$num.'A'.$num1.'']=$party_attorney->document_sign_name;
                        $attorney['firmS'.$num.'A'.$num1.'']=$party_attorney->firm_name;
                        $attorney['streetadS'.$num.'A'.$num1.'']=$party_attorney->firm_street_address;
                        $attorney['unitS'.$num.'A'.$num1.'']=$party_attorney->firm_suite_unit_mailcode;
                        $attorney['poboxS'.$num.'A'.$num1.'']=$party_attorney->po_box;
                        $attorney['citystatezipS'.$num.'A'.$num1.'']=$attorneycitystatezip;
                        $attorney['telephoneS'.$num.'A'.$num1.'']=$party_attorney->firm_telephone;
                        $attorney['faxS'.$num.'A'.$num1.'']=$party_attorney->firm_fax;
                        $attorney['emailS'.$num.'A'.$num1.'']=$attorneyemail;
                        
                    }
                    $limit=$num1+1;
                    for($j=$limit; $j<=3; $j++){
                        $attorney['signnameS'.$num.'A'.$j.'']=NULL;
                        $attorney['firmS'.$num.'A'.$j.'']=NULL;
                        $attorney['streetadS'.$num.'A'.$j.'']=NULL;
                        $attorney['unitS'.$num.'A'.$j.'']=NULL;
                        $attorney['poboxS'.$num.'A'.$j.'']=NULL;
                        $attorney['citystatezipS'.$num.'A'.$j.'']=NULL;
                        $attorney['telephoneS'.$num.'A'.$j.'']=NULL;
                        $attorney['faxS'.$num.'A'.$j.'']=NULL;
                        $attorney['emailS'.$num.'A'.$j.'']=NULL;
                    }

                    $partytypeattorneyinfoprev=PleadingSendersAttorneysInfo2::where('pleading_id', $pleading_id)->get()->first();
                    if($partytypeattorneyinfoprev){
                        $partytypeattorneyinfo=$partytypeattorneyinfoprev->fill($attorney)->save();
                    } else {
                        $partytypeattorneyinfo=PleadingSendersAttorneysInfo2::create($attorney);
                    }
                } else {
                    $attorney2=array('pleading_id'=>$pleading_id);
                    $partytypeattorneyinfoprev=PleadingSendersAttorneysInfo2::where('pleading_id', $pleading_id)->get()->first();
                    if($partytypeattorneyinfoprev){
                        $partytypeattorneyinfo=$partytypeattorneyinfoprev->fill($attorney2)->save();
                    } else {
                        $partytypeattorneyinfo=PleadingSendersAttorneysInfo2::create($attorney2);
                    }
                }
            }

            ++$numsenders; 
            // end for updating party attornies info
        }
        $partytypeinfoprev=PleadingSendersInfo::where('pleading_id', $pleading_id)->get()->first();
        if($partytypeinfoprev){
            $partytypeinfo=$partytypeinfoprev->fill($pleading_parties_info)->save();
        } else {
            $partytypeinfo=PleadingSendersInfo::create($pleading_parties_info);
        }
        // end for updating sender info

        // for updating receiver info

        $num=0;
        $numreceivers=0;
        $pleading_parties_info1=array(
                            'pleading_id'=>$pleading_id,
                        );
        foreach ($pleadingparties as $pleadingparty)
        {
            if($numreceivers >= $pleading->num_s){
            // if($numreceivers < $pleading->num_r){
                $userinfo=User::find($pleadingparty->party_id);
                $name=$userinfo->name;
                $fullname=$userinfo->name;
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
                    if(isset($caseuser->suffix)){
                        if($caseuser->suffix=='I' || $caseuser->suffix=='II' || $caseuser->suffix=='III' || $caseuser->suffix=='IV'){
                            $fullname=$fullname.' '.$caseuser->suffix;
                        } else {
                            $fullname=$fullname.', '.$caseuser->suffix;
                        }
                    }
                }

                if(isset($caseuser->state_id) && $caseuser->state_id !=''){
                    $state_name=State::find($caseuser->state_id)->state;
                } else {
                    $state_name='';
                }
                if(isset($caseuser->county_id) && $caseuser->county_id !=''){
                    $county_name=County::find($caseuser->county_id)->county_name;
                } else {
                    $county_name='';
                }
                if(isset($caseuser->user_city) && $caseuser->user_city !=''){
                    $city_name=$caseuser->user_city;
                } else {
                    $city_name='';
                }
                if(isset($caseuser->user_zipcode) && $caseuser->user_zipcode !=''){
                    $user_zipcode=$caseuser->user_zipcode;
                } else {
                    $user_zipcode='';
                }
                if(isset($caseuser->state_id) && isset($caseuser->user_zipcode) && isset($caseuser->user_city)){
                    $citystatezip=$city_name.', '.$state_name.' '.$caseuser->user_zipcode;
                } else {
                    $citystatezip=NULL;
                }
                $num_attys=0;
                $attorney_ids=Partyattorney::where([['party_id', $pleadingparty->party_id],['case_id', $case_id]])->get();
                if($attorney_ids){
                    $num_attys=count($attorney_ids);
                }

                $num++;

                $pleading_parties_info1['fullnameR'.$num.'']=$fullname;
                $pleading_parties_info1['fnameR'.$num.'']=$caseuser->fname;
                $pleading_parties_info1['mnameR'.$num.'']=$caseuser->mname;
                $pleading_parties_info1['lnameR'.$num.'']=$caseuser->lname;
                $pleading_parties_info1['shortnameR'.$num.'']=$caseuser->short_name;
                $pleading_parties_info1['genderR'.$num.'']=$caseuser->gender;
                $pleading_parties_info1['streetadR'.$num.'']=$caseuser->street_address;
                $pleading_parties_info1['unitR'.$num.'']=$caseuser->unit;
                $pleading_parties_info1['poboxR'.$num.'']=$caseuser->pobox;
                $pleading_parties_info1['citystatezipR'.$num.'']=$citystatezip;
                $pleading_parties_info1['telephoneR'.$num.'']=$caseuser->telephone;
                $pleading_parties_info1['faxR'.$num.'']=$caseuser->fax;
                $pleading_parties_info1['emailR'.$num.'']=$userinfo->email;
                $pleading_parties_info1['nameunknownR'.$num.'']=$caseuser->name_unknown;
                $pleading_parties_info1['addressunknownR'.$num.'']=$caseuser->address_unknown;
                $pleading_parties_info1['gendescR'.$num.'']=$caseuser->gen_desc;
                $pleading_parties_info1['ismultidescR'.$num.'']=$caseuser->is_multi_desc;
                $pleading_parties_info1['moregendescR'.$num.'']=$caseuser->more_gen_desc;
                $pleading_parties_info1['pauperisR'.$num.'']=$caseuser->pauperis;

                // for updating party attornies info
                if($num <= 9)
                {
                    $attorney_ids=Partyattorney::where([['party_id', $pleadingparty->party_id],['case_id', $case_id]])->get()->all();
                    $attorney=array('pleading_id'=>$pleading_id);
                    $num1=0;
                    $totalattornies=count($attorney_ids);
                    foreach($attorney_ids as $attorney_user_id){
                       $attorneyuserinfo=User::find($attorney_user_id->attorney_id);
                        $attorneyname=$attorneyuserinfo->name;
                        $attorneyemail=$attorneyuserinfo->email;
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

                        $attorneycitystatezip=$party_attorney->firm_city.', '.$party_attorney->state.' '.$party_attorney->firm_zipcode;

                        $num1++;
                        $attorney['signnameR'.$num.'A'.$num1.'']=$party_attorney->document_sign_name;
                        $attorney['firmR'.$num.'A'.$num1.'']=$party_attorney->firm_name;
                        $attorney['streetadR'.$num.'A'.$num1.'']=$party_attorney->firm_street_address;
                        $attorney['unitR'.$num.'A'.$num1.'']=$party_attorney->firm_suite_unit_mailcode;
                        $attorney['poboxR'.$num.'A'.$num1.'']=$party_attorney->po_box;
                        $attorney['citystatezipR'.$num.'A'.$num1.'']=$attorneycitystatezip;
                        $attorney['telephoneR'.$num.'A'.$num1.'']=$party_attorney->firm_telephone;
                        $attorney['faxR'.$num.'A'.$num1.'']=$party_attorney->firm_fax;
                        $attorney['emailR'.$num.'A'.$num1.'']=$attorneyemail;
                        
                    }
                    $limit=$num1+1;
                    for($j=$limit; $j<=3; $j++){
                        $attorney['signnameR'.$num.'A'.$j.'']=NULL;
                        $attorney['firmR'.$num.'A'.$j.'']=NULL;
                        $attorney['streetadR'.$num.'A'.$j.'']=NULL;
                        $attorney['unitR'.$num.'A'.$j.'']=NULL;
                        $attorney['poboxR'.$num.'A'.$j.'']=NULL;
                        $attorney['citystatezipR'.$num.'A'.$j.'']=NULL;
                        $attorney['telephoneR'.$num.'A'.$j.'']=NULL;
                        $attorney['faxR'.$num.'A'.$j.'']=NULL;
                        $attorney['emailR'.$num.'A'.$j.'']=NULL;
                    }

                    $partytypeattorneyinfoprev=PleadingReceiversAttorneysInfo1::where('pleading_id', $pleading_id)->get()->first();
                    if($partytypeattorneyinfoprev){
                    // dd($attorney);
                        $partytypeattorneyinfo=$partytypeattorneyinfoprev->fill($attorney)->save();
                    } else {
                        $partytypeattorneyinfo=PleadingReceiversAttorneysInfo1::create($attorney);
                    }
                }

                if($num > 9)
                {
                    $attorney_ids=Partyattorney::where([['party_id', $pleadingparty->party_id],['case_id', $case_id]])->get()->all();
                    $attorney=array('pleading_id'=>$pleading_id);
                    $num1=0;
                    $totalattornies=count($attorney_ids);
                    foreach($attorney_ids as $attorney_user_id){
                       $attorneyuserinfo=User::find($attorney_user_id->attorney_id);
                        $attorneyname=$attorneyuserinfo->name;
                        $attorneyemail=$attorneyuserinfo->email;
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

                        $attorneycitystatezip=$party_attorney->firm_city.', '.$party_attorney->state.' '.$party_attorney->firm_zipcode;

                        $num1++;
                        $attorney['signnameR'.$num.'A'.$num1.'']=$party_attorney->document_sign_name;
                        $attorney['firmR'.$num.'A'.$num1.'']=$party_attorney->firm_name;
                        $attorney['streetadR'.$num.'A'.$num1.'']=$party_attorney->firm_street_address;
                        $attorney['unitR'.$num.'A'.$num1.'']=$party_attorney->firm_suite_unit_mailcode;
                        $attorney['poboxR'.$num.'A'.$num1.'']=$party_attorney->po_box;
                        $attorney['citystatezipR'.$num.'A'.$num1.'']=$attorneycitystatezip;
                        $attorney['telephoneR'.$num.'A'.$num1.'']=$party_attorney->firm_telephone;
                        $attorney['faxR'.$num.'A'.$num1.'']=$party_attorney->firm_fax;
                        $attorney['emailR'.$num.'A'.$num1.'']=$attorneyemail;
                        
                    }
                    $limit=$num1+1;
                    for($j=$limit; $j<=3; $j++){
                        $attorney['signnameR'.$num.'A'.$j.'']=NULL;
                        $attorney['firmR'.$num.'A'.$j.'']=NULL;
                        $attorney['streetadR'.$num.'A'.$j.'']=NULL;
                        $attorney['unitR'.$num.'A'.$j.'']=NULL;
                        $attorney['poboxR'.$num.'A'.$j.'']=NULL;
                        $attorney['citystatezipR'.$num.'A'.$j.'']=NULL;
                        $attorney['telephoneR'.$num.'A'.$j.'']=NULL;
                        $attorney['faxR'.$num.'A'.$j.'']=NULL;
                        $attorney['emailR'.$num.'A'.$j.'']=NULL;
                    }

                    $partytypeattorneyinfoprev=PleadingReceiversAttorneysInfo2::where('pleading_id', $pleading_id)->get()->first();
                    if($partytypeattorneyinfoprev){
                        $partytypeattorneyinfo=$partytypeattorneyinfoprev->fill($attorney)->save();
                    } else {
                        $partytypeattorneyinfo=PleadingReceiversAttorneysInfo2::create($attorney);
                    }
                } else {
                    $attorney2=array('pleading_id'=>$pleading_id);
                    $partytypeattorneyinfoprev=PleadingReceiversAttorneysInfo2::where('pleading_id', $pleading_id)->get()->first();
                    if($partytypeattorneyinfoprev){
                        $partytypeattorneyinfo=$partytypeattorneyinfoprev->fill($attorney2)->save();
                    } else {
                        $partytypeattorneyinfo=PleadingReceiversAttorneysInfo2::create($attorney2);
                    }
                }
            }

            ++$numreceivers; 
            // end for updating party attornies info
        }
        $partytypeinfoprev=PleadingReceiversInfo::where('pleading_id', $pleading_id)->get()->first();
        if($partytypeinfoprev){
            $partytypeinfo=$partytypeinfoprev->fill($pleading_parties_info1)->save();
        } else {
            $partytypeinfo=PleadingReceiversInfo::create($pleading_parties_info1);
        }
        // end for updating receiver info
        return redirect()->route('cases.pleadings',['case_id' => $request->case_id])->with('success', 'Pleading Created Successfully!');

    }

    /* Store Edit Case Pleading Info Form */
    public function editCasePleadings($case_id, $pleading_id)
    {
        Session::forget('has_third_party'); Session::forget('redirect_to'); Session::forget('pleading_id');

        $case_data=Courtcase::find($case_id);
        if(isset($case_data) && $case_data->attorney_id==Auth::user()->id && $case_data->payment_status=='1'){
            $user_ids_top=Caseuser::where([['case_id', $case_id],['party_group', 'top']])->get()->pluck('user_id')->all();
            $user_ids_bottom=Caseuser::where([['case_id', $case_id],['party_group', 'bottom']])->get()->pluck('user_id')->all();
            $top_party_data=array();
            $i=0;
            if($user_ids_top){
                $case_data['total_top_parties']=count($user_ids_top);
                foreach($user_ids_top as $user_id){
                    $top_party_data[$i]=User::where('id', $user_id)->get()->first();
                    $caseuser=Caseuser::where([
                        ['case_id', $case_id],
                        ['attorney_id', Auth::user()->id],
                        ['user_id', $user_id]
                    ])->get()
                    ->first();
                    if(isset($caseuser->party_entity) && $caseuser->party_entity=='organization_company') {
                        $top_party_data[$i]['name']=$caseuser->org_comp_name;
                    } else {
                        if(isset($caseuser->mname) && $caseuser->mname !='') {
                            $mname=$caseuser->mname;
                            $namearray = explode(' ', $top_party_data[$i]['name'], 2);
                            if(count($namearray) > 1) {
                                $top_party_data[$i]['name']=$namearray[0].' '.$mname.' '.$namearray[1];
                            } else {
                                $top_party_data[$i]['name']=$top_party_data[$i]['name'].' '.$mname;
                            }
                        }
                    }

                    ++$i;
                }
            }
            $bottom_party_data=array();
            $i=0;
            if($user_ids_bottom){
                $case_data['total_bottom_parties']=count($user_ids_bottom);
                foreach($user_ids_bottom as $user_id){
                    $bottom_party_data[$i]=User::where('id', $user_id)->get()->first();
                    $caseuser=Caseuser::where([
                        ['case_id', $case_id],
                        ['attorney_id', Auth::user()->id],
                        ['user_id', $user_id]
                    ])->get()
                    ->first();
                    if(isset($caseuser->party_entity) && $caseuser->party_entity=='organization_company') {
                        $bottom_party_data[$i]['name']=$caseuser->org_comp_name;
                    } else {
                        if(isset($caseuser->mname) && $caseuser->mname !='') {
                            $mname=$caseuser->mname;
                            $namearray = explode(' ', $bottom_party_data[$i]['name'], 2);
                            if(count($namearray) > 1) {
                                $bottom_party_data[$i]['name']=$namearray[0].' '.$mname.' '.$namearray[1];
                            } else {
                                $bottom_party_data[$i]['name']=$bottom_party_data[$i]['name'].' '.$mname;
                            }
                        }
                    }

                    ++$i;
                }
            }

            // for third parties
            $user_ids_top_third=Caseuser::where([['case_id', $case_id],['party_group', 'top_third']])->get()->pluck('user_id')->all();
            $user_ids_bottom_third=Caseuser::where([['case_id', $case_id],['party_group', 'bottom_third']])->get()->pluck('user_id')->all();
            $top_third_party_data=array();
            $i=0;
            if($user_ids_top_third){
                $case_data['total_top_third_parties']=count($user_ids_top_third);
                foreach($user_ids_top_third as $user_id){
                    $top_third_party_data[$i]=User::where('id', $user_id)->get()->first();
                    $caseuser=Caseuser::where([
                        ['case_id', $case_id],
                        ['attorney_id', Auth::user()->id],
                        ['user_id', $user_id]
                    ])->get()
                    ->first();
                    if(isset($caseuser->party_entity) && $caseuser->party_entity=='organization_company') {
                        $top_third_party_data[$i]['name']=$caseuser->org_comp_name;
                    } else {
                        if(isset($caseuser->mname) && $caseuser->mname !='') {
                            $mname=$caseuser->mname;
                            $namearray = explode(' ', $top_third_party_data[$i]['name'], 2);
                            if(count($namearray) > 1) {
                                $top_third_party_data[$i]['name']=$namearray[0].' '.$mname.' '.$namearray[1];
                            } else {
                                $top_third_party_data[$i]['name']=$top_third_party_data[$i]['name'].' '.$mname;
                            }
                        }
                    }

                    ++$i;
                }
            }
            $bottom_third_party_data=array();
            $i=0;
            if($user_ids_bottom_third){
                $case_data['total_bottom_third_parties']=count($user_ids_bottom_third);
                foreach($user_ids_bottom_third as $user_id){
                    $bottom_third_party_data[$i]=User::where('id', $user_id)->get()->first();
                    $caseuser=Caseuser::where([
                        ['case_id', $case_id],
                        ['attorney_id', Auth::user()->id],
                        ['user_id', $user_id]
                    ])->get()
                    ->first();
                    if(isset($caseuser->party_entity) && $caseuser->party_entity=='organization_company') {
                        $bottom_third_party_data[$i]['name']=$caseuser->org_comp_name;
                    } else {
                        if(isset($caseuser->mname) && $caseuser->mname !='') {
                            $mname=$caseuser->mname;
                            $namearray = explode(' ', $bottom_third_party_data[$i]['name'], 2);
                            if(count($namearray) > 1) {
                                $bottom_third_party_data[$i]['name']=$namearray[0].' '.$mname.' '.$namearray[1];
                            } else {
                                $bottom_third_party_data[$i]['name']=$bottom_third_party_data[$i]['name'].' '.$mname;
                            }
                        }
                    }

                    ++$i;
                }
            }

            $pleading_types=DB::table('pleading_types')->get()->all();
            $pleading = Pleading::find($pleading_id);
            if($pleading){
                $pleadingparties=$pleading->pleadingparties;
                $filingparties=array();
                $responsibleparties=array();
                $responsiblepartiesdeadlines=array();
                foreach ($pleadingparties as $pleadingparty) {
                    if($pleadingparty && $pleadingparty->party_type=='filing'){
                        $filingparties[]=$pleadingparty->party_id;

                    } elseif ($pleadingparty && $pleadingparty->party_type=='responsible') {
                        $responsibleparties[]=$pleadingparty->party_id;

                        $responsiblepartiesdeadlines[$pleadingparty->party_id]['service_date']=$pleadingparty->service_date;
                        $responsiblepartiesdeadlines[$pleadingparty->party_id]['initial_deadline']=$pleadingparty->initial_deadline;
                        $responsiblepartiesdeadlines[$pleadingparty->party_id]['current_deadline']=$pleadingparty->current_deadline;

                    }
                }

                // user ids of top and bottom parties
            
                $user_ids_top_string=implode(" ", $user_ids_top);
                $user_ids_bottom_string=implode(" ", $user_ids_bottom);

                return view('pleadings.edit',['case_id' => $case_id, 'top_party_data' => $top_party_data, 'bottom_party_data' => $bottom_party_data, 'top_third_party_data' => $top_third_party_data, 'bottom_third_party_data' => $bottom_third_party_data, 'case_data' => $case_data, 'pleading_types' => $pleading_types, 'pleading' => $pleading, 'filingparties' => $filingparties, 'responsibleparties' => $responsibleparties, 'responsiblepartiesdeadlines' => $responsiblepartiesdeadlines, 'user_ids_top_string' => $user_ids_top_string, 'user_ids_bottom_string' => $user_ids_bottom_string]); 
            } else{
                return redirect()->route('cases.index');
            } 
        } else {
            // return view('pleadings.index',['case_id' => $case_id]);
            return redirect()->route('cases.index');

        }

    }

    /* Update Case Pleading Info */
    public function updateCasePleadings(Request $request)
    {
        $result = $request->except('submit');
        $case_id=$request->case_id;
        $user_ids_top_string=$request->user_ids_top_string;
        $user_ids_bottom_string=$request->user_ids_bottom_string;
        $user_ids_top_string=explode(" ", $user_ids_top_string);
        $user_ids_bottom_string=explode(" ", $user_ids_bottom_string);
        $pleading_caption='';
        foreach($user_ids_top_string as $user_id){
            $user_data=User::where('id', $user_id)->get()->first();
            $caseuser=Caseuser::where([
                ['case_id', $case_id],
                ['attorney_id', Auth::user()->id],
                ['user_id', $user_id]
            ])->get()
            ->first();
            $user_name=$user_data['name'];

            if(isset($caseuser->party_entity) && $caseuser->party_entity=='organization_company') {
                $user_name=$caseuser->org_comp_name;
            } else {
                if(isset($caseuser->mname) && $caseuser->mname!='') {
                    $mname=$caseuser->mname;
                }
                if(isset($mname) && $mname !='') {
                    $namearray = explode(' ', $user_data['name'], 2);
                    if(count($namearray) > 1) {
                        $user_name=$namearray[0].' '.$mname.' '.$namearray[1];
                    } else {
                        $user_name=$user_data['name'].' '.$mname;
                    }
                }
            }
            $street_address=$caseuser->street_address;
            $user_city=$caseuser->user_city;
            if(isset($caseuser->state_id) && $caseuser->state_id !=''){
                $state_name= State::find($caseuser->state_id)->state;
            } else {
                $state_name='';
            }
            $user_zipcode=$caseuser->user_zipcode;
            if($pleading_caption==''){
                if(isset($street_address) && isset($user_city) && isset($caseuser->state_id) && isset($user_zipcode)){
                    $pleading_caption=$pleading_caption.$user_name.' '.$street_address.' '.$user_city.', '.$state_name.', '.$user_zipcode;
                } else {
                    $pleading_caption=$pleading_caption.$user_name;
                }
            } else {
                if(isset($street_address) && isset($user_city) && isset($caseuser->state_id) && isset($user_zipcode)){
                    $pleading_caption=$pleading_caption.' and '.$user_name.' '.$street_address.' '.$user_city.', '.$state_name.', '.$user_zipcode;
                } else {
                    $pleading_caption=$pleading_caption.' and '.$user_name;
                }
            }
        }
        $pleading_caption=$pleading_caption.' '.strtoupper($request->top_party_type).'S vs. ';
        $test='';
        foreach($user_ids_bottom_string as $user_id){
            $user_data=User::where('id', $user_id)->get()->first();
            $caseuser=Caseuser::where([
                ['case_id', $case_id],
                ['attorney_id', Auth::user()->id],
                ['user_id', $user_id]
            ])->get()
            ->first();
            $user_name=$user_data['name'];

            if(isset($caseuser->party_entity) && $caseuser->party_entity=='organization_company') {
                $user_name=$caseuser->org_comp_name;
            } else {
                if(isset($caseuser->mname) && $caseuser->mname!='') {
                    $mname=$caseuser->mname;
                }
                if(isset($mname) && $mname !='') {
                    $namearray = explode(' ', $user_data['name'], 2);
                    if(count($namearray) > 1) {
                        $user_name=$namearray[0].' '.$mname.' '.$namearray[1];
                    } else {
                        $user_name=$user_data['name'].' '.$mname;
                    }
                }
            }
            $street_address=$caseuser->street_address;
            $user_city=$caseuser->user_city;
            if(isset($caseuser->state_id) && $caseuser->state_id !=''){
                $state_name= State::find($caseuser->state_id)->state;
            } else {
                $state_name='';
            }
            $user_zipcode=$caseuser->user_zipcode;
            if($test==''){
                if(isset($street_address) && isset($user_city) && isset($caseuser->state_id) && isset($user_zipcode)){
                    $pleading_caption=$pleading_caption.$user_name.' '.$street_address.' '.$user_city.', '.$state_name.', '.$user_zipcode;
                } else {
                    $pleading_caption=$pleading_caption.$user_name;
                }
            } else {
                if(isset($street_address) && isset($user_city) && isset($caseuser->state_id) && isset($user_zipcode)){
                    $pleading_caption=$pleading_caption.' and '.$user_name.' '.$street_address.' '.$user_city.', '.$state_name.', '.$user_zipcode;
                } else {
                    $pleading_caption=$pleading_caption.' and '.$user_name;
                }
            }
            $test='test';
        }
        $pleading_caption=$pleading_caption.' '.strtoupper($request->bottom_party_type).'S';

        $filings=$request->filings;
        if($request->responsibles){
            $responsibles=$request->responsibles;
        } else {
            $responsibles=[];
        }
        if($request->date_filed){
            $date_filed=date("Y-m-d",strtotime($request->date_filed));
        } else {
            $date_filed=NULL;
        }
        
        $data=array(
            'case_id'=>$request->case_id,
            'pleading_caption'=>$pleading_caption,
            'pleading_name'=>$request->pleading_name,
            'date_filed'=>$date_filed,
            'pleading_type_id'=>$request->pleading_type_id,
            'pleading_has_new_third_parties'=>$request->pleading_has_new_third_parties,
            'pleading_includes_claims'=>$request->pleading_includes_claims,
        );
        $pleading = Pleading::find($request->pleading_id);
        $pleadingparties=$pleading->pleadingparties;
        if(isset($pleadingparties) && $pleadingparties->count() >0){
            Pleadingparty::where('pleading_id',$request->pleading_id)->delete();
        }
        $pleadingdata=$pleading->update($data);
        $data2=array();
        $totalsenders=0;$totalreceivers=0;$totalobservers=0;
        if($filings){
            $num=1;
            foreach ($filings as $filing) {
                $party_type="filing";
                $party_class="S".$num++;
                $data2[] = $data = array(
                    'pleading_id' => $pleading->id,
                    'party_id' => $filing,
                    'party_type' => $party_type,
                    'party_class' => $party_class,
                    'service_date' => NULL,
                    'initial_deadline' => NULL,
                    'current_deadline' => NULL,
                    'created_at'=>now(),
                    'updated_at'=>now(),
                );
                $pleadingparty = Pleadingparty::create($data);
                ++$totalsenders;
            }
        }
        if($responsibles && (isset($request->pleading_includes_claims) && $request->pleading_includes_claims=='Yes')){
            $num=1;
            foreach ($responsibles as $responsible) {
                $service_date=$initial_deadline=$current_deadline=NULL;
                if(isset($result['service_date_'.$responsible.'']) && $result['service_date_'.$responsible.''] !='') 
                {
                    $service_date=date("Y-m-d",strtotime($result['service_date_'.$responsible.'']));
                }
                if(isset($result['initial_deadline_'.$responsible.'']) && $result['initial_deadline_'.$responsible.''] !='') 
                {
                    $initial_deadline=date("Y-m-d",strtotime($result['initial_deadline_'.$responsible.'']));
                }
                if(isset($result['current_deadline_'.$responsible.'']) && $result['current_deadline_'.$responsible.''] !='') 
                {
                    $current_deadline=date("Y-m-d",strtotime($result['current_deadline_'.$responsible.'']));
                }

                $party_type="responsible";
                $party_class="R".$num++;
                $data2[] = $data = array(
                    'pleading_id' => $pleading->id,
                    'party_id' => $responsible,
                    'party_type' => $party_type,
                    'party_class' => $party_class,
                    'service_date' => $service_date,
                    'initial_deadline' => $initial_deadline,
                    'current_deadline' => $current_deadline,
                    'created_at'=>now(),
                    'updated_at'=>now(),
                );
                $pleadingparty = Pleadingparty::create($data);
                ++$totalreceivers;
            }
        }
        // for observers
        $pleading_checked_parties=array_unique(array_merge($filings,$responsibles));
        $pleading_all_parties=Caseuser::where([['case_id', $case_id],['attorney_id', Auth::user()->id]])->get()->pluck('user_id')->all();
        $observers=array_diff($pleading_all_parties,$pleading_checked_parties);

        $num=1;
        foreach ($observers as $observer) {            
            $party_type="NA";
            $party_class="O".$num++;
            $data2[] = $data = array(
                'pleading_id' => $pleading->id,
                'party_id' => $observer,
                'party_type' => $party_type,
                'party_class' => $party_class,
                'service_date' => NULL,
                'initial_deadline' => NULL,
                'current_deadline' => NULL,
                'created_at'=>now(),
                'updated_at'=>now(),
            );
            $pleadingparty = Pleadingparty::create($data);
            ++$totalobservers;
        }

        // if(isset($pleadingparties) && $pleadingparties->count() >0){
        //     //Pleadingparty::where('pleading_id',$request->pleading_id)->delete();
        //     $pleadingparty = Pleadingparty::insert($data2);
        // } else{
        //     $pleadingparty = Pleadingparty::insert($data2);
        // }
        // update pleading table
        $pleadingtoupdate = Pleading::find($pleading->id);

        $pleadingtoupdate->num_s = $totalsenders;
        $pleadingtoupdate->num_r = $totalreceivers;
        $pleadingtoupdate->num_o = $totalobservers;

        $pleadingtoupdate->save();
        // dd($data2);
        // to update senders and receivers info
        $pleading_id=$pleading->id;
        $pleading=Pleading::find($pleading_id);
        $case_id=$pleading->case_id;
        $pleadingparties=$pleading->pleadingparties;
        // for updating sender info
        $num=0;
        $numsenders=0;
        $pleading_parties_info=array(
                            'pleading_id'=>$pleading_id,
                        );
        foreach ($pleadingparties as $pleadingparty)
        {
            if($numsenders < $pleading->num_s){
                $userinfo=User::find($pleadingparty->party_id);
                $name=$userinfo->name;
                $fullname=$userinfo->name;
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
                    if(isset($caseuser->suffix)){
                        if($caseuser->suffix=='I' || $caseuser->suffix=='II' || $caseuser->suffix=='III' || $caseuser->suffix=='IV'){
                            $fullname=$fullname.' '.$caseuser->suffix;
                        } else {
                            $fullname=$fullname.', '.$caseuser->suffix;
                        }
                    }
                }
                if(isset($caseuser->state_id) && $caseuser->state_id !=''){
                    $state_name=State::find($caseuser->state_id)->state;
                } else {
                    $state_name='';
                }
                if(isset($caseuser->county_id) && $caseuser->county_id !=''){
                    $county_name=County::find($caseuser->county_id)->county_name;
                } else {
                    $county_name='';
                }
                if(isset($caseuser->user_city) && $caseuser->user_city !=''){
                    $city_name=$caseuser->user_city;
                } else {
                    $city_name='';
                }
                if(isset($caseuser->user_zipcode) && $caseuser->user_zipcode !=''){
                    $user_zipcode=$caseuser->user_zipcode;
                } else {
                    $user_zipcode='';
                }
                if(isset($caseuser->state_id) && isset($caseuser->user_zipcode) && isset($caseuser->user_city)){
                    $citystatezip=$city_name.', '.$state_name.' '.$caseuser->user_zipcode;
                } else {
                    $citystatezip=NULL;
                }
                
                
                $num_attys=0;
                $attorney_ids=Partyattorney::where([['party_id', $pleadingparty->party_id],['case_id', $case_id]])->get();
                if($attorney_ids){
                    $num_attys=count($attorney_ids);
                }

                $num++;

                $pleading_parties_info['fullnameS'.$num.'']=$fullname;
                $pleading_parties_info['fnameS'.$num.'']=$caseuser->fname;
                $pleading_parties_info['mnameS'.$num.'']=$caseuser->mname;
                $pleading_parties_info['lnameS'.$num.'']=$caseuser->lname;
                $pleading_parties_info['shortnameS'.$num.'']=$caseuser->short_name;
                $pleading_parties_info['genderS'.$num.'']=$caseuser->gender;
                $pleading_parties_info['streetadS'.$num.'']=$caseuser->street_address;
                $pleading_parties_info['unitS'.$num.'']=$caseuser->unit;
                $pleading_parties_info['poboxS'.$num.'']=$caseuser->pobox;
                $pleading_parties_info['citystatezipS'.$num.'']=$citystatezip;
                $pleading_parties_info['telephoneS'.$num.'']=$caseuser->telephone;
                $pleading_parties_info['faxS'.$num.'']=$caseuser->fax;
                $pleading_parties_info['emailS'.$num.'']=$userinfo->email;
                $pleading_parties_info['nameunknownS'.$num.'']=$caseuser->name_unknown;
                $pleading_parties_info['addressunknownS'.$num.'']=$caseuser->address_unknown;
                $pleading_parties_info['gendescS'.$num.'']=$caseuser->gen_desc;
                $pleading_parties_info['ismultidescS'.$num.'']=$caseuser->is_multi_desc;
                $pleading_parties_info['moregendescS'.$num.'']=$caseuser->more_gen_desc;
                $pleading_parties_info['pauperisS'.$num.'']=$caseuser->pauperis;

                // for updating party attornies info
                if($num <= 9)
                {
                    $attorney_ids=Partyattorney::where([['party_id', $pleadingparty->party_id],['case_id', $case_id]])->get()->all();
                    $attorney=array('pleading_id'=>$pleading_id);
                    $num1=0;
                    $totalattornies=count($attorney_ids);
                    foreach($attorney_ids as $attorney_user_id){
                        $attorneyuserinfo=User::find($attorney_user_id->attorney_id);
                        $attorneyname=$attorneyuserinfo->name;
                        $attorneyemail=$attorneyuserinfo->email;
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

                        $attorneycitystatezip=$party_attorney->firm_city.', '.$party_attorney->state.' '.$party_attorney->firm_zipcode;

                        $num1++;
                        $attorney['signnameS'.$num.'A'.$num1.'']=$party_attorney->document_sign_name;
                        $attorney['firmS'.$num.'A'.$num1.'']=$party_attorney->firm_name;
                        $attorney['streetadS'.$num.'A'.$num1.'']=$party_attorney->firm_street_address;
                        $attorney['unitS'.$num.'A'.$num1.'']=$party_attorney->firm_suite_unit_mailcode;
                        $attorney['poboxS'.$num.'A'.$num1.'']=$party_attorney->po_box;
                        $attorney['citystatezipS'.$num.'A'.$num1.'']=$attorneycitystatezip;
                        $attorney['telephoneS'.$num.'A'.$num1.'']=$party_attorney->firm_telephone;
                        $attorney['faxS'.$num.'A'.$num1.'']=$party_attorney->firm_fax;
                        $attorney['emailS'.$num.'A'.$num1.'']=$attorneyemail;
                        
                    }
                    $limit=$num1+1;
                    for($j=$limit; $j<=3; $j++){
                        $attorney['signnameS'.$num.'A'.$j.'']=NULL;
                        $attorney['firmS'.$num.'A'.$j.'']=NULL;
                        $attorney['streetadS'.$num.'A'.$j.'']=NULL;
                        $attorney['unitS'.$num.'A'.$j.'']=NULL;
                        $attorney['poboxS'.$num.'A'.$j.'']=NULL;
                        $attorney['citystatezipS'.$num.'A'.$j.'']=NULL;
                        $attorney['telephoneS'.$num.'A'.$j.'']=NULL;
                        $attorney['faxS'.$num.'A'.$j.'']=NULL;
                        $attorney['emailS'.$num.'A'.$j.'']=NULL;
                    }

                    $partytypeattorneyinfoprev=PleadingSendersAttorneysInfo1::where('pleading_id', $pleading_id)->get()->first();
                    if($partytypeattorneyinfoprev){
                    // dd($attorney);
                        $partytypeattorneyinfo=$partytypeattorneyinfoprev->fill($attorney)->save();
                    } else {
                        $partytypeattorneyinfo=PleadingSendersAttorneysInfo1::create($attorney);
                    }
                }

                if($num > 9)
                {
                    $attorney_ids=Partyattorney::where([['party_id', $pleadingparty->party_id],['case_id', $case_id]])->get()->all();
                    $attorney=array('pleading_id'=>$pleading_id);
                    $num1=0;
                    $totalattornies=count($attorney_ids);
                    foreach($attorney_ids as $attorney_user_id){
                        $attorneyuserinfo=User::where($attorney_user_id->attorney_id);
                        $attorneyname=$attorneyuserinfo->name;
                        $attorneyemail=$attorneyuserinfo->email;
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

                        $attorneycitystatezip=$party_attorney->firm_city.', '.$party_attorney->state.' '.$party_attorney->firm_zipcode;

                        $num1++;
                        $attorney['signnameS'.$num.'A'.$num1.'']=$party_attorney->document_sign_name;
                        $attorney['firmS'.$num.'A'.$num1.'']=$party_attorney->firm_name;
                        $attorney['streetadS'.$num.'A'.$num1.'']=$party_attorney->firm_street_address;
                        $attorney['unitS'.$num.'A'.$num1.'']=$party_attorney->firm_suite_unit_mailcode;
                        $attorney['poboxS'.$num.'A'.$num1.'']=$party_attorney->po_box;
                        $attorney['citystatezipS'.$num.'A'.$num1.'']=$attorneycitystatezip;
                        $attorney['telephoneS'.$num.'A'.$num1.'']=$party_attorney->firm_telephone;
                        $attorney['faxS'.$num.'A'.$num1.'']=$party_attorney->firm_fax;
                        $attorney['emailS'.$num.'A'.$num1.'']=$attorneyemail;
                        
                    }
                    $limit=$num1+1;
                    for($j=$limit; $j<=3; $j++){
                        $attorney['signnameS'.$num.'A'.$j.'']=NULL;
                        $attorney['firmS'.$num.'A'.$j.'']=NULL;
                        $attorney['streetadS'.$num.'A'.$j.'']=NULL;
                        $attorney['unitS'.$num.'A'.$j.'']=NULL;
                        $attorney['poboxS'.$num.'A'.$j.'']=NULL;
                        $attorney['citystatezipS'.$num.'A'.$j.'']=NULL;
                        $attorney['telephoneS'.$num.'A'.$j.'']=NULL;
                        $attorney['faxS'.$num.'A'.$j.'']=NULL;
                        $attorney['emailS'.$num.'A'.$j.'']=NULL;
                    }

                    $partytypeattorneyinfoprev=PleadingSendersAttorneysInfo2::where('pleading_id', $pleading_id)->get()->first();
                    if($partytypeattorneyinfoprev){
                        $partytypeattorneyinfo=$partytypeattorneyinfoprev->fill($attorney)->save();
                    } else {
                        $partytypeattorneyinfo=PleadingSendersAttorneysInfo2::create($attorney);
                    }
                } else {
                    $attorney2=array('pleading_id'=>$pleading_id);
                    $partytypeattorneyinfoprev=PleadingSendersAttorneysInfo2::where('pleading_id', $pleading_id)->get()->first();
                    if($partytypeattorneyinfoprev){
                        $partytypeattorneyinfo=$partytypeattorneyinfoprev->fill($attorney2)->save();
                    } else {
                        $partytypeattorneyinfo=PleadingSendersAttorneysInfo2::create($attorney2);
                    }
                }
            }

            ++$numsenders; 
            // end for updating party attornies info
        }
        $partytypeinfoprev=PleadingSendersInfo::where('pleading_id', $pleading_id)->get()->first();
        if($partytypeinfoprev){
            $partytypeinfo=$partytypeinfoprev->fill($pleading_parties_info)->save();
        } else {
            $partytypeinfo=PleadingSendersInfo::create($pleading_parties_info);
        }
        // end for updating sender info

        // for updating receiver info

        $num=0;
        $numreceivers=0;
        $pleading_parties_info1=array(
                            'pleading_id'=>$pleading_id,
                        );
        foreach ($pleadingparties as $pleadingparty)
        {
            if($numreceivers >= $pleading->num_s){
            // if($numreceivers < $pleading->num_r){
                $userinfo=User::find($pleadingparty->party_id);
                $name=$userinfo->name;
                $fullname=$userinfo->name;
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
                    if(isset($caseuser->suffix)){
                        if($caseuser->suffix=='I' || $caseuser->suffix=='II' || $caseuser->suffix=='III' || $caseuser->suffix=='IV'){
                            $fullname=$fullname.' '.$caseuser->suffix;
                        } else {
                            $fullname=$fullname.', '.$caseuser->suffix;
                        }
                    }
                }

                if(isset($caseuser->state_id) && $caseuser->state_id !=''){
                    $state_name=State::find($caseuser->state_id)->state;
                } else {
                    $state_name='';
                }
                if(isset($caseuser->county_id) && $caseuser->county_id !=''){
                    $county_name=County::find($caseuser->county_id)->county_name;
                } else {
                    $county_name='';
                }
                if(isset($caseuser->user_city) && $caseuser->user_city !=''){
                    $city_name=$caseuser->user_city;
                } else {
                    $city_name='';
                }
                if(isset($caseuser->user_zipcode) && $caseuser->user_zipcode !=''){
                    $user_zipcode=$caseuser->user_zipcode;
                } else {
                    $user_zipcode='';
                }
                if(isset($caseuser->state_id) && isset($caseuser->user_zipcode) && isset($caseuser->user_city)){
                    $citystatezip=$city_name.', '.$state_name.' '.$caseuser->user_zipcode;
                } else {
                    $citystatezip=NULL;
                }
                $num_attys=0;
                $attorney_ids=Partyattorney::where([['party_id', $pleadingparty->party_id],['case_id', $case_id]])->get();
                if($attorney_ids){
                    $num_attys=count($attorney_ids);
                }

                $num++;

                $pleading_parties_info1['fullnameR'.$num.'']=$fullname;
                $pleading_parties_info1['fnameR'.$num.'']=$caseuser->fname;
                $pleading_parties_info1['mnameR'.$num.'']=$caseuser->mname;
                $pleading_parties_info1['lnameR'.$num.'']=$caseuser->lname;
                $pleading_parties_info1['shortnameR'.$num.'']=$caseuser->short_name;
                $pleading_parties_info1['genderR'.$num.'']=$caseuser->gender;
                $pleading_parties_info1['streetadR'.$num.'']=$caseuser->street_address;
                $pleading_parties_info1['unitR'.$num.'']=$caseuser->unit;
                $pleading_parties_info1['poboxR'.$num.'']=$caseuser->pobox;
                $pleading_parties_info1['citystatezipR'.$num.'']=$citystatezip;
                $pleading_parties_info1['telephoneR'.$num.'']=$caseuser->telephone;
                $pleading_parties_info1['faxR'.$num.'']=$caseuser->fax;
                $pleading_parties_info1['emailR'.$num.'']=$userinfo->email;
                $pleading_parties_info1['nameunknownR'.$num.'']=$caseuser->name_unknown;
                $pleading_parties_info1['addressunknownR'.$num.'']=$caseuser->address_unknown;
                $pleading_parties_info1['gendescR'.$num.'']=$caseuser->gen_desc;
                $pleading_parties_info1['ismultidescR'.$num.'']=$caseuser->is_multi_desc;
                $pleading_parties_info1['moregendescR'.$num.'']=$caseuser->more_gen_desc;
                $pleading_parties_info1['pauperisR'.$num.'']=$caseuser->pauperis;

                // for updating party attornies info
                if($num <= 9)
                {
                    $attorney_ids=Partyattorney::where([['party_id', $pleadingparty->party_id],['case_id', $case_id]])->get()->all();
                    $attorney=array('pleading_id'=>$pleading_id);
                    $num1=0;
                    $totalattornies=count($attorney_ids);
                    foreach($attorney_ids as $attorney_user_id){
                       $attorneyuserinfo=User::find($attorney_user_id->attorney_id);
                        $attorneyname=$attorneyuserinfo->name;
                        $attorneyemail=$attorneyuserinfo->email;
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

                        $attorneycitystatezip=$party_attorney->firm_city.', '.$party_attorney->state.' '.$party_attorney->firm_zipcode;

                        $num1++;
                        $attorney['signnameR'.$num.'A'.$num1.'']=$party_attorney->document_sign_name;
                        $attorney['firmR'.$num.'A'.$num1.'']=$party_attorney->firm_name;
                        $attorney['streetadR'.$num.'A'.$num1.'']=$party_attorney->firm_street_address;
                        $attorney['unitR'.$num.'A'.$num1.'']=$party_attorney->firm_suite_unit_mailcode;
                        $attorney['poboxR'.$num.'A'.$num1.'']=$party_attorney->po_box;
                        $attorney['citystatezipR'.$num.'A'.$num1.'']=$attorneycitystatezip;
                        $attorney['telephoneR'.$num.'A'.$num1.'']=$party_attorney->firm_telephone;
                        $attorney['faxR'.$num.'A'.$num1.'']=$party_attorney->firm_fax;
                        $attorney['emailR'.$num.'A'.$num1.'']=$attorneyemail;
                        
                    }
                    $limit=$num1+1;
                    for($j=$limit; $j<=3; $j++){
                        $attorney['signnameR'.$num.'A'.$j.'']=NULL;
                        $attorney['firmR'.$num.'A'.$j.'']=NULL;
                        $attorney['streetadR'.$num.'A'.$j.'']=NULL;
                        $attorney['unitR'.$num.'A'.$j.'']=NULL;
                        $attorney['poboxR'.$num.'A'.$j.'']=NULL;
                        $attorney['citystatezipR'.$num.'A'.$j.'']=NULL;
                        $attorney['telephoneR'.$num.'A'.$j.'']=NULL;
                        $attorney['faxR'.$num.'A'.$j.'']=NULL;
                        $attorney['emailR'.$num.'A'.$j.'']=NULL;
                    }

                    $partytypeattorneyinfoprev=PleadingReceiversAttorneysInfo1::where('pleading_id', $pleading_id)->get()->first();
                    if($partytypeattorneyinfoprev){
                    // dd($attorney);
                        $partytypeattorneyinfo=$partytypeattorneyinfoprev->fill($attorney)->save();
                    } else {
                        $partytypeattorneyinfo=PleadingReceiversAttorneysInfo1::create($attorney);
                    }
                }

                if($num > 9)
                {
                    $attorney_ids=Partyattorney::where([['party_id', $pleadingparty->party_id],['case_id', $case_id]])->get()->all();
                    $attorney=array('pleading_id'=>$pleading_id);
                    $num1=0;
                    $totalattornies=count($attorney_ids);
                    foreach($attorney_ids as $attorney_user_id){
                       $attorneyuserinfo=User::find($attorney_user_id->attorney_id);
                        $attorneyname=$attorneyuserinfo->name;
                        $attorneyemail=$attorneyuserinfo->email;
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

                        $attorneycitystatezip=$party_attorney->firm_city.', '.$party_attorney->state.' '.$party_attorney->firm_zipcode;

                        $num1++;
                        $attorney['signnameR'.$num.'A'.$num1.'']=$party_attorney->document_sign_name;
                        $attorney['firmR'.$num.'A'.$num1.'']=$party_attorney->firm_name;
                        $attorney['streetadR'.$num.'A'.$num1.'']=$party_attorney->firm_street_address;
                        $attorney['unitR'.$num.'A'.$num1.'']=$party_attorney->firm_suite_unit_mailcode;
                        $attorney['poboxR'.$num.'A'.$num1.'']=$party_attorney->po_box;
                        $attorney['citystatezipR'.$num.'A'.$num1.'']=$attorneycitystatezip;
                        $attorney['telephoneR'.$num.'A'.$num1.'']=$party_attorney->firm_telephone;
                        $attorney['faxR'.$num.'A'.$num1.'']=$party_attorney->firm_fax;
                        $attorney['emailR'.$num.'A'.$num1.'']=$attorneyemail;
                        
                    }
                    $limit=$num1+1;
                    for($j=$limit; $j<=3; $j++){
                        $attorney['signnameR'.$num.'A'.$j.'']=NULL;
                        $attorney['firmR'.$num.'A'.$j.'']=NULL;
                        $attorney['streetadR'.$num.'A'.$j.'']=NULL;
                        $attorney['unitR'.$num.'A'.$j.'']=NULL;
                        $attorney['poboxR'.$num.'A'.$j.'']=NULL;
                        $attorney['citystatezipR'.$num.'A'.$j.'']=NULL;
                        $attorney['telephoneR'.$num.'A'.$j.'']=NULL;
                        $attorney['faxR'.$num.'A'.$j.'']=NULL;
                        $attorney['emailR'.$num.'A'.$j.'']=NULL;
                    }

                    $partytypeattorneyinfoprev=PleadingReceiversAttorneysInfo2::where('pleading_id', $pleading_id)->get()->first();
                    if($partytypeattorneyinfoprev){
                        $partytypeattorneyinfo=$partytypeattorneyinfoprev->fill($attorney)->save();
                    } else {
                        $partytypeattorneyinfo=PleadingReceiversAttorneysInfo2::create($attorney);
                    }
                } else {
                    $attorney2=array('pleading_id'=>$pleading_id);
                    $partytypeattorneyinfoprev=PleadingReceiversAttorneysInfo2::where('pleading_id', $pleading_id)->get()->first();
                    if($partytypeattorneyinfoprev){
                        $partytypeattorneyinfo=$partytypeattorneyinfoprev->fill($attorney2)->save();
                    } else {
                        $partytypeattorneyinfo=PleadingReceiversAttorneysInfo2::create($attorney2);
                    }
                }
            }

            ++$numreceivers; 
            // end for updating party attornies info
        }
        $partytypeinfoprev=PleadingReceiversInfo::where('pleading_id', $pleading_id)->get()->first();
        if($partytypeinfoprev){
            $partytypeinfo=$partytypeinfoprev->fill($pleading_parties_info1)->save();
        } else {
            $partytypeinfo=PleadingReceiversInfo::create($pleading_parties_info1);
        }
        // end for updating receiver info
        return redirect()->route('cases.pleadings',['case_id' => $request->case_id])->with('success', 'Pleading Updated Successfully!');

    }

    function pleadingHasNewThirdparties($case_id, $action, $pleading_id){
        if(isset($action) && $action=='create'){
            Session::put('has_third_party', TRUE); Session::put('redirect_to', 'pleading_create'); Session::put('pleading_id', $pleading_id);
        } 
        if(isset($action) && $action=='edit'){
            Session::put('has_third_party', TRUE); Session::put('redirect_to', 'pleading_edit'); Session::put('pleading_id', $pleading_id);
        }
        if(isset($action) && $action=='sub_create'){
            Session::put('has_third_party', TRUE); Session::put('redirect_to', 'sub_pleading_create'); Session::put('pleading_id', $pleading_id);
        } 
        if(isset($action) && $action=='sub_edit'){
            Session::put('has_third_party', TRUE); Session::put('redirect_to', 'sub_pleading_edit'); Session::put('pleading_id', $pleading_id);
        }
        return redirect()->route('cases.show_party_reg_form',['case_id' => $case_id]);
    }

    function pleadingHasAddedThirdparties($case_id){
        $action=Session::get('redirect_to') ;
        $pleading_id=Session::get('pleading_id');
        Session::forget('has_third_party'); Session::forget('redirect_to'); Session::forget('pleading_id');
        if(isset($action) && $action=='pleading_edit' && isset($pleading_id)){
            return redirect()->route('cases.pleadings.edit',['case_id' => $case_id, 'pleading_id' => $pleading_id]);
        } 

        if(isset($action) && $action=='pleading_create' && isset($pleading_id) && $pleading_id == 'new'){
            return redirect()->route('cases.pleadings.create',['case_id' => $case_id]);
        }

        if(isset($action) && $action=='sub_pleading_create' && isset($pleading_id) && $pleading_id == 'sub_new'){
            return redirect()->route('cases.pleadings',$case_id);
        }

        if(isset($action) && $action=='sub_pleading_edit' && isset($pleading_id)){
            return redirect()->route('cases.pleadings',$case_id);
        } 
    }

    /* Show Create Subordinate Case Pleading Info Form */
    public function createSubordinateCasePleading(Request $request)
    {
        $case_id=$request->case_id;
        $pleading_id=$request->pleading_id;
        $select_party_id=$request->select_party_id;
        Session::forget('has_third_party'); Session::forget('redirect_to'); Session::forget('pleading_id');

        $case_data=Courtcase::find($case_id);
        if(isset($case_data) && $case_data->attorney_id==Auth::user()->id && $case_data->payment_status=='1'){
            $user_ids_top=Caseuser::where([['case_id', $case_id],['party_group', 'top']])->get()->pluck('user_id')->all();
            $user_ids_bottom=Caseuser::where([['case_id', $case_id],['party_group', 'bottom']])->get()->pluck('user_id')->all();
            $top_party_data=array();
            $i=0;
            if($user_ids_top){
                $case_data['total_top_parties']=count($user_ids_top);
                foreach($user_ids_top as $user_id){
                    $top_party_data[$i]=User::where('id', $user_id)->get()->first();
                    $caseuser=Caseuser::where([
                        ['case_id', $case_id],
                        ['attorney_id', Auth::user()->id],
                        ['user_id', $user_id]
                    ])->get()
                    ->first();
                    if(isset($caseuser->party_entity) && $caseuser->party_entity=='organization_company') {
                        $top_party_data[$i]['name']=$caseuser->org_comp_name;
                    } else {
                        if(isset($caseuser->mname) && $caseuser->mname !='') {
                            $mname=$caseuser->mname;
                            $namearray = explode(' ', $top_party_data[$i]['name'], 2);
                            if(count($namearray) > 1) {
                                $top_party_data[$i]['name']=$namearray[0].' '.$mname.' '.$namearray[1];
                            } else {
                                $top_party_data[$i]['name']=$top_party_data[$i]['name'].' '.$mname;
                            }
                        }
                    }

                    ++$i;
                }
            }
            $bottom_party_data=array();
            $i=0;
            if($user_ids_bottom){
                $case_data['total_bottom_parties']=count($user_ids_bottom);
                foreach($user_ids_bottom as $user_id){
                    $bottom_party_data[$i]=User::where('id', $user_id)->get()->first();
                    $caseuser=Caseuser::where([
                        ['case_id', $case_id],
                        ['attorney_id', Auth::user()->id],
                        ['user_id', $user_id]
                    ])->get()
                    ->first();
                    if(isset($caseuser->party_entity) && $caseuser->party_entity=='organization_company') {
                        $bottom_party_data[$i]['name']=$caseuser->org_comp_name;
                    } else {
                        if(isset($caseuser->mname) && $caseuser->mname !='') {
                            $mname=$caseuser->mname;
                            $namearray = explode(' ', $bottom_party_data[$i]['name'], 2);
                            if(count($namearray) > 1) {
                                $bottom_party_data[$i]['name']=$namearray[0].' '.$mname.' '.$namearray[1];
                            } else {
                                $bottom_party_data[$i]['name']=$bottom_party_data[$i]['name'].' '.$mname;
                            }
                        }
                    }

                    ++$i;
                }
            }

            // for third parties
            $user_ids_top_third=Caseuser::where([['case_id', $case_id],['party_group', 'top_third']])->get()->pluck('user_id')->all();
            $user_ids_bottom_third=Caseuser::where([['case_id', $case_id],['party_group', 'bottom_third']])->get()->pluck('user_id')->all();
            $top_third_party_data=array();
            $i=0;
            if($user_ids_top_third){
                $case_data['total_top_third_parties']=count($user_ids_top_third);
                foreach($user_ids_top_third as $user_id){
                    $top_third_party_data[$i]=User::where('id', $user_id)->get()->first();
                    $caseuser=Caseuser::where([
                        ['case_id', $case_id],
                        ['attorney_id', Auth::user()->id],
                        ['user_id', $user_id]
                    ])->get()
                    ->first();
                    if(isset($caseuser->party_entity) && $caseuser->party_entity=='organization_company') {
                        $top_third_party_data[$i]['name']=$caseuser->org_comp_name;
                    } else {
                        if(isset($caseuser->mname) && $caseuser->mname !='') {
                            $mname=$caseuser->mname;
                            $namearray = explode(' ', $top_third_party_data[$i]['name'], 2);
                            if(count($namearray) > 1) {
                                $top_third_party_data[$i]['name']=$namearray[0].' '.$mname.' '.$namearray[1];
                            } else {
                                $top_third_party_data[$i]['name']=$top_third_party_data[$i]['name'].' '.$mname;
                            }
                        }
                    }

                    ++$i;
                }
            }
            $bottom_third_party_data=array();
            $i=0;
            if($user_ids_bottom_third){
                $case_data['total_bottom_third_parties']=count($user_ids_bottom_third);
                foreach($user_ids_bottom_third as $user_id){
                    $bottom_third_party_data[$i]=User::where('id', $user_id)->get()->first();
                    $caseuser=Caseuser::where([
                        ['case_id', $case_id],
                        ['attorney_id', Auth::user()->id],
                        ['user_id', $user_id]
                    ])->get()
                    ->first();
                    if(isset($caseuser->party_entity) && $caseuser->party_entity=='organization_company') {
                        $bottom_third_party_data[$i]['name']=$caseuser->org_comp_name;
                    } else {
                        if(isset($caseuser->mname) && $caseuser->mname !='') {
                            $mname=$caseuser->mname;
                            $namearray = explode(' ', $bottom_third_party_data[$i]['name'], 2);
                            if(count($namearray) > 1) {
                                $bottom_third_party_data[$i]['name']=$namearray[0].' '.$mname.' '.$namearray[1];
                            } else {
                                $bottom_third_party_data[$i]['name']=$bottom_third_party_data[$i]['name'].' '.$mname;
                            }
                        }
                    }

                    ++$i;
                }
            }

            $pleading_types=DB::table('pleading_types')->get()->all();
            $pleading = Pleading::find($pleading_id);
            if($pleading){

                // for level
                $pleading_level=$pleading->pleading_level;
                $last_sub_pleadings = Pleading::where([['case_id', $case_id],['parent_pleading_id', $pleading_id]])->latest('id')->first();
                if($last_sub_pleadings){
                    $pleading_level_last=$last_sub_pleadings->pleading_level;
                    $has_child=true;
                } else {
                    $pleading_level_last=$pleading_level;
                    $has_child=false;
                }
                if($has_child){
                    $last_num = substr($pleading_level_last, -1);
                    $pleading_level_last=substr($pleading_level_last, 0, -1);
                    $last_num++;
                    $new_pleading_level = $pleading_level_last."".$last_num;
                } else {
                    $new_pleading_level=$pleading_level_last.'.1';
                }                
                // end for level

                $pleadingparties=$pleading->pleadingparties;
                $filingparties=array();
                $responsibleparties=array();
                foreach ($pleadingparties as $pleadingparty) {
                    if($pleadingparty && $pleadingparty->party_type=='filing'){
                        $filingparties[]=$pleadingparty->party_id;
                    } elseif ($pleadingparty && $pleadingparty->party_type=='responsible') {
                       $responsibleparties[]=$pleadingparty->party_id;                        
                    }
                }

                // user ids of top and bottom parties
                
                $user_ids_top_string=$user_ids_top[0];
                $user_ids_bottom_string=($user_ids_bottom) ? $user_ids_bottom[0]:'';
                $already_has_complaint_pleading = Pleading::where([['case_id', $case_id],['parent_pleading_id', '0'],['pleading_type_id', '1']])->get();
                return view('pleadings.subordinate_create',['case_id' => $case_id, 'top_party_data' => $top_party_data, 'bottom_party_data' => $bottom_party_data, 'top_third_party_data' => $top_third_party_data, 'bottom_third_party_data' => $bottom_third_party_data, 'case_data' => $case_data, 'pleading_types' => $pleading_types, 'pleading' => $pleading, 'filingparties' => $filingparties, 'responsibleparties' => $responsibleparties, 'pleading_action_type' => $request->pleading_action_type, 'select_party_id' => $select_party_id, 'pleading_level'=> $new_pleading_level, 'user_ids_top_string' => $user_ids_top_string, 'user_ids_bottom_string' => $user_ids_bottom_string, 'already_has_complaint_pleading' => $already_has_complaint_pleading]);
            } else{
                return redirect()->route('cases.index');
            }   
        } else {
            // return view('pleadings.index',['case_id' => $case_id]);
            return redirect()->route('cases.index');

        }
    }

    /* Store Create Subordinate Case Pleading Info */
    public function storeSubordinateCasePleading(Request $request){
        $result = $request->except('submit');
        $case_id=$request->case_id;

        $user_ids_top_string=$request->user_ids_top_string;
        $user_ids_bottom_string=$request->user_ids_bottom_string;
        $user_ids_top_string=explode(" ", $user_ids_top_string);
        $user_ids_bottom_string=explode(" ", $user_ids_bottom_string);
        $pleading_caption='';
        foreach($user_ids_top_string as $user_id){
            $user_data=User::where('id', $user_id)->get()->first();
            $caseuser=Caseuser::where([
                ['case_id', $case_id],
                ['attorney_id', Auth::user()->id],
                ['user_id', $user_id]
            ])->get()
            ->first();
            $user_name=$user_data['name'];

            if(isset($caseuser->party_entity) && $caseuser->party_entity=='organization_company') {
                $user_name=$caseuser->org_comp_name;
            } else {
                if(isset($caseuser->mname) && $caseuser->mname!='') {
                    $mname=$caseuser->mname;
                }
                if(isset($mname) && $mname !='') {
                    $namearray = explode(' ', $user_data['name'], 2);
                    if(count($namearray) > 1) {
                        $user_name=$namearray[0].' '.$mname.' '.$namearray[1];
                    } else {
                        $user_name=$user_data['name'].' '.$mname;
                    }
                }
            }
            // $street_address=$caseuser->street_address;
            // $user_city=$caseuser->user_city;
            // $state_name= State::find($caseuser->state_id)->state;
            // $user_zipcode=$caseuser->user_zipcode;
            if($pleading_caption==''){
                $pleading_caption=$pleading_caption.$user_name;
            }
        }
        $pleading_caption=$pleading_caption.', et al. '.strtoupper($request->top_party_type).'S vs. ';
        $test='';
        foreach($user_ids_bottom_string as $user_id){
            $user_data=User::where('id', $user_id)->get()->first();
            $caseuser=Caseuser::where([
                ['case_id', $case_id],
                ['attorney_id', Auth::user()->id],
                ['user_id', $user_id]
            ])->get()
            ->first();
            $user_name=$user_data['name'];

            if(isset($caseuser->party_entity) && $caseuser->party_entity=='organization_company') {
                $user_name=$caseuser->org_comp_name;
            } else {
                if(isset($caseuser->mname) && $caseuser->mname!='') {
                    $mname=$caseuser->mname;
                }
                if(isset($mname) && $mname !='') {
                    $namearray = explode(' ', $user_data['name'], 2);
                    if(count($namearray) > 1) {
                        $user_name=$namearray[0].' '.$mname.' '.$namearray[1];
                    } else {
                        $user_name=$user_data['name'].' '.$mname;
                    }
                }
            }
            if($test==''){
                $pleading_caption=$pleading_caption.$user_name;
            }
            $test='test';
        }
        $pleading_caption=$pleading_caption.', et al. '.strtoupper($request->bottom_party_type).'S';
        
        $filings=$request->filings;
        if($request->responsibles){
            $responsibles=$request->responsibles;
        } else {
            $responsibles=[];
        }

        if($request->date_filed){
            $date_filed=date("Y-m-d",strtotime($request->date_filed));
        } else {
            $date_filed=NULL;
        }
        $data=array(
            'case_id'=>$request->case_id,
            'pleading_caption'=>$pleading_caption,
            'pleading_name'=>$request->pleading_name,
            'date_filed'=>$date_filed,
            'pleading_type_id'=>$request->pleading_type_id,
            'pleading_category'=>'New Subordinate Pleading',
            'parent_pleading_id'=>$request->parent_pleading_id,
            'pleading_has_new_third_parties'=>$request->pleading_has_new_third_parties,
            'pleading_includes_claims'=>$request->pleading_includes_claims,
            'pleading_level' => $request->pleading_level,
        );
        $pleading = Pleading::create($data);
        $data2=array();
        $totalsenders=0;$totalreceivers=0;$totalobservers=0;
        if($filings){
            $num=1;
            foreach ($filings as $filing) {
                $party_type="filing";
                $party_class="S".$num++;
                $data2[] = $data = array(
                    'pleading_id' => $pleading->id,
                    'party_id' => $filing,
                    'party_type' => $party_type,
                    'party_class' => $party_class,
                    'service_date' => NULL,
                    'initial_deadline' => NULL,
                    'current_deadline' => NULL,
                    'created_at'=>now(),
                    'updated_at'=>now(),
                );
                $pleadingparty = Pleadingparty::create($data);
                ++$totalsenders;
            }
        }
        if($responsibles && (isset($request->pleading_includes_claims) && $request->pleading_includes_claims=='Yes')){
            $num=1;
            foreach ($responsibles as $responsible) {
                $service_date=$initial_deadline=$current_deadline=NULL;
                if(isset($result['service_date_'.$responsible.'']) && $result['service_date_'.$responsible.''] !='') 
                {
                    $service_date=date("Y-m-d",strtotime($result['service_date_'.$responsible.'']));
                }
                if(isset($result['initial_deadline_'.$responsible.'']) && $result['initial_deadline_'.$responsible.''] !='') 
                {
                    $initial_deadline=date("Y-m-d",strtotime($result['initial_deadline_'.$responsible.'']));
                }
                if(isset($result['current_deadline_'.$responsible.'']) && $result['current_deadline_'.$responsible.''] !='') 
                {
                    $current_deadline=date("Y-m-d",strtotime($result['current_deadline_'.$responsible.'']));
                }

                $party_type="responsible";
                $party_class="R".$num++;
                $data2[] = $data = array(
                    'pleading_id' => $pleading->id,
                    'party_id' => $responsible,
                    'party_type' => $party_type,
                    'party_class' => $party_class,
                    'service_date' => $service_date,
                    'initial_deadline' => $initial_deadline,
                    'current_deadline' => $current_deadline,
                    'created_at'=>now(),
                    'updated_at'=>now(),
                );
                $pleadingparty = Pleadingparty::create($data);
                ++$totalreceivers;
            }
        }
        // for observers
        $pleading_checked_parties=array_unique(array_merge($filings,$responsibles));
        $pleading_all_parties=Caseuser::where([['case_id', $case_id],['attorney_id', Auth::user()->id]])->get()->pluck('user_id')->all();
        $observers=array_diff($pleading_all_parties,$pleading_checked_parties);

        $num=1;
        foreach ($observers as $observer) {            
            $party_type="NA";
            $party_class="O".$num++;
            $data2[] = $data = array(
                'pleading_id' => $pleading->id,
                'party_id' => $observer,
                'party_type' => $party_type,
                'party_class' => $party_class,
                'service_date' => NULL,
                'initial_deadline' => NULL,
                'current_deadline' => NULL,
                'created_at'=>now(),
                'updated_at'=>now(),
            );
            $pleadingparty = Pleadingparty::create($data);
            ++$totalobservers;
        }
        // $pleadingparty = Pleadingparty::insert($data2);
        // update pleading table
        $pleadingtoupdate = Pleading::find($pleading->id);

        $pleadingtoupdate->num_s = $totalsenders;
        $pleadingtoupdate->num_r = $totalreceivers;
        $pleadingtoupdate->num_o = $totalobservers;

        $pleadingtoupdate->save();
        // dd($data2);
        // to update senders and receivers info
        $pleading_id=$pleading->id;
        $pleading=Pleading::find($pleading_id);
        $case_id=$pleading->case_id;
        $pleadingparties=$pleading->pleadingparties;
        // for updating sender info
        $num=0;
        $numsenders=0;
        $pleading_parties_info=array(
                            'pleading_id'=>$pleading_id,
                        );
        foreach ($pleadingparties as $pleadingparty)
        {
            if($numsenders < $pleading->num_s){
                $userinfo=User::find($pleadingparty->party_id);
                $name=$userinfo->name;
                $fullname=$userinfo->name;
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
                    if(isset($caseuser->suffix)){
                        if($caseuser->suffix=='I' || $caseuser->suffix=='II' || $caseuser->suffix=='III' || $caseuser->suffix=='IV'){
                            $fullname=$fullname.' '.$caseuser->suffix;
                        } else {
                            $fullname=$fullname.', '.$caseuser->suffix;
                        }
                    }
                }
                if(isset($caseuser->state_id) && $caseuser->state_id !=''){
                    $state_name=State::find($caseuser->state_id)->state;
                } else {
                    $state_name='';
                }
                if(isset($caseuser->county_id) && $caseuser->county_id !=''){
                    $county_name=County::find($caseuser->county_id)->county_name;
                } else {
                    $county_name='';
                }
                if(isset($caseuser->user_city) && $caseuser->user_city !=''){
                    $city_name=$caseuser->user_city;
                } else {
                    $city_name='';
                }
                if(isset($caseuser->user_zipcode) && $caseuser->user_zipcode !=''){
                    $user_zipcode=$caseuser->user_zipcode;
                } else {
                    $user_zipcode='';
                }
                if(isset($caseuser->state_id) && isset($caseuser->user_zipcode) && isset($caseuser->user_city)){
                    $citystatezip=$city_name.', '.$state_name.' '.$caseuser->user_zipcode;
                } else {
                    $citystatezip=NULL;
                }
                
                
                $num_attys=0;
                $attorney_ids=Partyattorney::where([['party_id', $pleadingparty->party_id],['case_id', $case_id]])->get();
                if($attorney_ids){
                    $num_attys=count($attorney_ids);
                }

                $num++;

                $pleading_parties_info['fullnameS'.$num.'']=$fullname;
                $pleading_parties_info['fnameS'.$num.'']=$caseuser->fname;
                $pleading_parties_info['mnameS'.$num.'']=$caseuser->mname;
                $pleading_parties_info['lnameS'.$num.'']=$caseuser->lname;
                $pleading_parties_info['shortnameS'.$num.'']=$caseuser->short_name;
                $pleading_parties_info['genderS'.$num.'']=$caseuser->gender;
                $pleading_parties_info['streetadS'.$num.'']=$caseuser->street_address;
                $pleading_parties_info['unitS'.$num.'']=$caseuser->unit;
                $pleading_parties_info['poboxS'.$num.'']=$caseuser->pobox;
                $pleading_parties_info['citystatezipS'.$num.'']=$citystatezip;
                $pleading_parties_info['telephoneS'.$num.'']=$caseuser->telephone;
                $pleading_parties_info['faxS'.$num.'']=$caseuser->fax;
                $pleading_parties_info['emailS'.$num.'']=$userinfo->email;
                $pleading_parties_info['nameunknownS'.$num.'']=$caseuser->name_unknown;
                $pleading_parties_info['addressunknownS'.$num.'']=$caseuser->address_unknown;
                $pleading_parties_info['gendescS'.$num.'']=$caseuser->gen_desc;
                $pleading_parties_info['ismultidescS'.$num.'']=$caseuser->is_multi_desc;
                $pleading_parties_info['moregendescS'.$num.'']=$caseuser->more_gen_desc;
                $pleading_parties_info['pauperisS'.$num.'']=$caseuser->pauperis;

                // for updating party attornies info
                if($num <= 9)
                {
                    $attorney_ids=Partyattorney::where([['party_id', $pleadingparty->party_id],['case_id', $case_id]])->get()->all();
                    $attorney=array('pleading_id'=>$pleading_id);
                    $num1=0;
                    $totalattornies=count($attorney_ids);
                    foreach($attorney_ids as $attorney_user_id){
                        $attorneyuserinfo=User::find($attorney_user_id->attorney_id);
                        $attorneyname=$attorneyuserinfo->name;
                        $attorneyemail=$attorneyuserinfo->email;
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

                        $attorneycitystatezip=$party_attorney->firm_city.', '.$party_attorney->state.' '.$party_attorney->firm_zipcode;

                        $num1++;
                        $attorney['signnameS'.$num.'A'.$num1.'']=$party_attorney->document_sign_name;
                        $attorney['firmS'.$num.'A'.$num1.'']=$party_attorney->firm_name;
                        $attorney['streetadS'.$num.'A'.$num1.'']=$party_attorney->firm_street_address;
                        $attorney['unitS'.$num.'A'.$num1.'']=$party_attorney->firm_suite_unit_mailcode;
                        $attorney['poboxS'.$num.'A'.$num1.'']=$party_attorney->po_box;
                        $attorney['citystatezipS'.$num.'A'.$num1.'']=$attorneycitystatezip;
                        $attorney['telephoneS'.$num.'A'.$num1.'']=$party_attorney->firm_telephone;
                        $attorney['faxS'.$num.'A'.$num1.'']=$party_attorney->firm_fax;
                        $attorney['emailS'.$num.'A'.$num1.'']=$attorneyemail;
                        
                    }
                    $limit=$num1+1;
                    for($j=$limit; $j<=3; $j++){
                        $attorney['signnameS'.$num.'A'.$j.'']=NULL;
                        $attorney['firmS'.$num.'A'.$j.'']=NULL;
                        $attorney['streetadS'.$num.'A'.$j.'']=NULL;
                        $attorney['unitS'.$num.'A'.$j.'']=NULL;
                        $attorney['poboxS'.$num.'A'.$j.'']=NULL;
                        $attorney['citystatezipS'.$num.'A'.$j.'']=NULL;
                        $attorney['telephoneS'.$num.'A'.$j.'']=NULL;
                        $attorney['faxS'.$num.'A'.$j.'']=NULL;
                        $attorney['emailS'.$num.'A'.$j.'']=NULL;
                    }

                    $partytypeattorneyinfoprev=PleadingSendersAttorneysInfo1::where('pleading_id', $pleading_id)->get()->first();
                    if($partytypeattorneyinfoprev){
                    // dd($attorney);
                        $partytypeattorneyinfo=$partytypeattorneyinfoprev->fill($attorney)->save();
                    } else {
                        $partytypeattorneyinfo=PleadingSendersAttorneysInfo1::create($attorney);
                    }
                }

                if($num > 9)
                {
                    $attorney_ids=Partyattorney::where([['party_id', $pleadingparty->party_id],['case_id', $case_id]])->get()->all();
                    $attorney=array('pleading_id'=>$pleading_id);
                    $num1=0;
                    $totalattornies=count($attorney_ids);
                    foreach($attorney_ids as $attorney_user_id){
                        $attorneyuserinfo=User::where($attorney_user_id->attorney_id);
                        $attorneyname=$attorneyuserinfo->name;
                        $attorneyemail=$attorneyuserinfo->email;
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

                        $attorneycitystatezip=$party_attorney->firm_city.', '.$party_attorney->state.' '.$party_attorney->firm_zipcode;

                        $num1++;
                        $attorney['signnameS'.$num.'A'.$num1.'']=$party_attorney->document_sign_name;
                        $attorney['firmS'.$num.'A'.$num1.'']=$party_attorney->firm_name;
                        $attorney['streetadS'.$num.'A'.$num1.'']=$party_attorney->firm_street_address;
                        $attorney['unitS'.$num.'A'.$num1.'']=$party_attorney->firm_suite_unit_mailcode;
                        $attorney['poboxS'.$num.'A'.$num1.'']=$party_attorney->po_box;
                        $attorney['citystatezipS'.$num.'A'.$num1.'']=$attorneycitystatezip;
                        $attorney['telephoneS'.$num.'A'.$num1.'']=$party_attorney->firm_telephone;
                        $attorney['faxS'.$num.'A'.$num1.'']=$party_attorney->firm_fax;
                        $attorney['emailS'.$num.'A'.$num1.'']=$attorneyemail;
                        
                    }
                    $limit=$num1+1;
                    for($j=$limit; $j<=3; $j++){
                        $attorney['signnameS'.$num.'A'.$j.'']=NULL;
                        $attorney['firmS'.$num.'A'.$j.'']=NULL;
                        $attorney['streetadS'.$num.'A'.$j.'']=NULL;
                        $attorney['unitS'.$num.'A'.$j.'']=NULL;
                        $attorney['poboxS'.$num.'A'.$j.'']=NULL;
                        $attorney['citystatezipS'.$num.'A'.$j.'']=NULL;
                        $attorney['telephoneS'.$num.'A'.$j.'']=NULL;
                        $attorney['faxS'.$num.'A'.$j.'']=NULL;
                        $attorney['emailS'.$num.'A'.$j.'']=NULL;
                    }

                    $partytypeattorneyinfoprev=PleadingSendersAttorneysInfo2::where('pleading_id', $pleading_id)->get()->first();
                    if($partytypeattorneyinfoprev){
                        $partytypeattorneyinfo=$partytypeattorneyinfoprev->fill($attorney)->save();
                    } else {
                        $partytypeattorneyinfo=PleadingSendersAttorneysInfo2::create($attorney);
                    }
                } else {
                    $attorney2=array('pleading_id'=>$pleading_id);
                    $partytypeattorneyinfoprev=PleadingSendersAttorneysInfo2::where('pleading_id', $pleading_id)->get()->first();
                    if($partytypeattorneyinfoprev){
                        $partytypeattorneyinfo=$partytypeattorneyinfoprev->fill($attorney2)->save();
                    } else {
                        $partytypeattorneyinfo=PleadingSendersAttorneysInfo2::create($attorney2);
                    }
                }
            }

            ++$numsenders; 
            // end for updating party attornies info
        }
        $partytypeinfoprev=PleadingSendersInfo::where('pleading_id', $pleading_id)->get()->first();
        if($partytypeinfoprev){
            $partytypeinfo=$partytypeinfoprev->fill($pleading_parties_info)->save();
        } else {
            $partytypeinfo=PleadingSendersInfo::create($pleading_parties_info);
        }
        // end for updating sender info

        // for updating receiver info

        $num=0;
        $numreceivers=0;
        $pleading_parties_info1=array(
                            'pleading_id'=>$pleading_id,
                        );
        foreach ($pleadingparties as $pleadingparty)
        {
            if($numreceivers >= $pleading->num_s){
            // if($numreceivers < $pleading->num_r){
                $userinfo=User::find($pleadingparty->party_id);
                $name=$userinfo->name;
                $fullname=$userinfo->name;
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
                    if(isset($caseuser->suffix)){
                        if($caseuser->suffix=='I' || $caseuser->suffix=='II' || $caseuser->suffix=='III' || $caseuser->suffix=='IV'){
                            $fullname=$fullname.' '.$caseuser->suffix;
                        } else {
                            $fullname=$fullname.', '.$caseuser->suffix;
                        }
                    }
                }

                if(isset($caseuser->state_id) && $caseuser->state_id !=''){
                    $state_name=State::find($caseuser->state_id)->state;
                } else {
                    $state_name='';
                }
                if(isset($caseuser->county_id) && $caseuser->county_id !=''){
                    $county_name=County::find($caseuser->county_id)->county_name;
                } else {
                    $county_name='';
                }
                if(isset($caseuser->user_city) && $caseuser->user_city !=''){
                    $city_name=$caseuser->user_city;
                } else {
                    $city_name='';
                }
                if(isset($caseuser->user_zipcode) && $caseuser->user_zipcode !=''){
                    $user_zipcode=$caseuser->user_zipcode;
                } else {
                    $user_zipcode='';
                }
                if(isset($caseuser->state_id) && isset($caseuser->user_zipcode) && isset($caseuser->user_city)){
                    $citystatezip=$city_name.', '.$state_name.' '.$caseuser->user_zipcode;
                } else {
                    $citystatezip=NULL;
                }
                $num_attys=0;
                $attorney_ids=Partyattorney::where([['party_id', $pleadingparty->party_id],['case_id', $case_id]])->get();
                if($attorney_ids){
                    $num_attys=count($attorney_ids);
                }

                $num++;

                $pleading_parties_info1['fullnameR'.$num.'']=$fullname;
                $pleading_parties_info1['fnameR'.$num.'']=$caseuser->fname;
                $pleading_parties_info1['mnameR'.$num.'']=$caseuser->mname;
                $pleading_parties_info1['lnameR'.$num.'']=$caseuser->lname;
                $pleading_parties_info1['shortnameR'.$num.'']=$caseuser->short_name;
                $pleading_parties_info1['genderR'.$num.'']=$caseuser->gender;
                $pleading_parties_info1['streetadR'.$num.'']=$caseuser->street_address;
                $pleading_parties_info1['unitR'.$num.'']=$caseuser->unit;
                $pleading_parties_info1['poboxR'.$num.'']=$caseuser->pobox;
                $pleading_parties_info1['citystatezipR'.$num.'']=$citystatezip;
                $pleading_parties_info1['telephoneR'.$num.'']=$caseuser->telephone;
                $pleading_parties_info1['faxR'.$num.'']=$caseuser->fax;
                $pleading_parties_info1['emailR'.$num.'']=$userinfo->email;
                $pleading_parties_info1['nameunknownR'.$num.'']=$caseuser->name_unknown;
                $pleading_parties_info1['addressunknownR'.$num.'']=$caseuser->address_unknown;
                $pleading_parties_info1['gendescR'.$num.'']=$caseuser->gen_desc;
                $pleading_parties_info1['ismultidescR'.$num.'']=$caseuser->is_multi_desc;
                $pleading_parties_info1['moregendescR'.$num.'']=$caseuser->more_gen_desc;
                $pleading_parties_info1['pauperisR'.$num.'']=$caseuser->pauperis;

                // for updating party attornies info
                if($num <= 9)
                {
                    $attorney_ids=Partyattorney::where([['party_id', $pleadingparty->party_id],['case_id', $case_id]])->get()->all();
                    $attorney=array('pleading_id'=>$pleading_id);
                    $num1=0;
                    $totalattornies=count($attorney_ids);
                    foreach($attorney_ids as $attorney_user_id){
                       $attorneyuserinfo=User::find($attorney_user_id->attorney_id);
                        $attorneyname=$attorneyuserinfo->name;
                        $attorneyemail=$attorneyuserinfo->email;
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

                        $attorneycitystatezip=$party_attorney->firm_city.', '.$party_attorney->state.' '.$party_attorney->firm_zipcode;

                        $num1++;
                        $attorney['signnameR'.$num.'A'.$num1.'']=$party_attorney->document_sign_name;
                        $attorney['firmR'.$num.'A'.$num1.'']=$party_attorney->firm_name;
                        $attorney['streetadR'.$num.'A'.$num1.'']=$party_attorney->firm_street_address;
                        $attorney['unitR'.$num.'A'.$num1.'']=$party_attorney->firm_suite_unit_mailcode;
                        $attorney['poboxR'.$num.'A'.$num1.'']=$party_attorney->po_box;
                        $attorney['citystatezipR'.$num.'A'.$num1.'']=$attorneycitystatezip;
                        $attorney['telephoneR'.$num.'A'.$num1.'']=$party_attorney->firm_telephone;
                        $attorney['faxR'.$num.'A'.$num1.'']=$party_attorney->firm_fax;
                        $attorney['emailR'.$num.'A'.$num1.'']=$attorneyemail;
                        
                    }
                    $limit=$num1+1;
                    for($j=$limit; $j<=3; $j++){
                        $attorney['signnameR'.$num.'A'.$j.'']=NULL;
                        $attorney['firmR'.$num.'A'.$j.'']=NULL;
                        $attorney['streetadR'.$num.'A'.$j.'']=NULL;
                        $attorney['unitR'.$num.'A'.$j.'']=NULL;
                        $attorney['poboxR'.$num.'A'.$j.'']=NULL;
                        $attorney['citystatezipR'.$num.'A'.$j.'']=NULL;
                        $attorney['telephoneR'.$num.'A'.$j.'']=NULL;
                        $attorney['faxR'.$num.'A'.$j.'']=NULL;
                        $attorney['emailR'.$num.'A'.$j.'']=NULL;
                    }

                    $partytypeattorneyinfoprev=PleadingReceiversAttorneysInfo1::where('pleading_id', $pleading_id)->get()->first();
                    if($partytypeattorneyinfoprev){
                    // dd($attorney);
                        $partytypeattorneyinfo=$partytypeattorneyinfoprev->fill($attorney)->save();
                    } else {
                        $partytypeattorneyinfo=PleadingReceiversAttorneysInfo1::create($attorney);
                    }
                }

                if($num > 9)
                {
                    $attorney_ids=Partyattorney::where([['party_id', $pleadingparty->party_id],['case_id', $case_id]])->get()->all();
                    $attorney=array('pleading_id'=>$pleading_id);
                    $num1=0;
                    $totalattornies=count($attorney_ids);
                    foreach($attorney_ids as $attorney_user_id){
                       $attorneyuserinfo=User::find($attorney_user_id->attorney_id);
                        $attorneyname=$attorneyuserinfo->name;
                        $attorneyemail=$attorneyuserinfo->email;
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

                        $attorneycitystatezip=$party_attorney->firm_city.', '.$party_attorney->state.' '.$party_attorney->firm_zipcode;

                        $num1++;
                        $attorney['signnameR'.$num.'A'.$num1.'']=$party_attorney->document_sign_name;
                        $attorney['firmR'.$num.'A'.$num1.'']=$party_attorney->firm_name;
                        $attorney['streetadR'.$num.'A'.$num1.'']=$party_attorney->firm_street_address;
                        $attorney['unitR'.$num.'A'.$num1.'']=$party_attorney->firm_suite_unit_mailcode;
                        $attorney['poboxR'.$num.'A'.$num1.'']=$party_attorney->po_box;
                        $attorney['citystatezipR'.$num.'A'.$num1.'']=$attorneycitystatezip;
                        $attorney['telephoneR'.$num.'A'.$num1.'']=$party_attorney->firm_telephone;
                        $attorney['faxR'.$num.'A'.$num1.'']=$party_attorney->firm_fax;
                        $attorney['emailR'.$num.'A'.$num1.'']=$attorneyemail;
                        
                    }
                    $limit=$num1+1;
                    for($j=$limit; $j<=3; $j++){
                        $attorney['signnameR'.$num.'A'.$j.'']=NULL;
                        $attorney['firmR'.$num.'A'.$j.'']=NULL;
                        $attorney['streetadR'.$num.'A'.$j.'']=NULL;
                        $attorney['unitR'.$num.'A'.$j.'']=NULL;
                        $attorney['poboxR'.$num.'A'.$j.'']=NULL;
                        $attorney['citystatezipR'.$num.'A'.$j.'']=NULL;
                        $attorney['telephoneR'.$num.'A'.$j.'']=NULL;
                        $attorney['faxR'.$num.'A'.$j.'']=NULL;
                        $attorney['emailR'.$num.'A'.$j.'']=NULL;
                    }

                    $partytypeattorneyinfoprev=PleadingReceiversAttorneysInfo2::where('pleading_id', $pleading_id)->get()->first();
                    if($partytypeattorneyinfoprev){
                        $partytypeattorneyinfo=$partytypeattorneyinfoprev->fill($attorney)->save();
                    } else {
                        $partytypeattorneyinfo=PleadingReceiversAttorneysInfo2::create($attorney);
                    }
                } else {
                    $attorney2=array('pleading_id'=>$pleading_id);
                    $partytypeattorneyinfoprev=PleadingReceiversAttorneysInfo2::where('pleading_id', $pleading_id)->get()->first();
                    if($partytypeattorneyinfoprev){
                        $partytypeattorneyinfo=$partytypeattorneyinfoprev->fill($attorney2)->save();
                    } else {
                        $partytypeattorneyinfo=PleadingReceiversAttorneysInfo2::create($attorney2);
                    }
                }
            }

            ++$numreceivers; 
            // end for updating party attornies info
        }
        $partytypeinfoprev=PleadingReceiversInfo::where('pleading_id', $pleading_id)->get()->first();
        if($partytypeinfoprev){
            $partytypeinfo=$partytypeinfoprev->fill($pleading_parties_info1)->save();
        } else {
            $partytypeinfo=PleadingReceiversInfo::create($pleading_parties_info1);
        }
        // end for updating receiver info
        return redirect()->route('cases.pleadings',['case_id' => $request->case_id])->with('success', 'Subordinate Pleading Created Successfully!');
    }

    /* Show Edit Subordinate Case Pleading Info Form */
    public function editSubordinateCasePleading($case_id, $pleading_id)
    {
        Session::forget('has_third_party'); Session::forget('redirect_to'); Session::forget('pleading_id');

        $case_data=Courtcase::find($case_id);
        if(isset($case_data) && $case_data->attorney_id==Auth::user()->id && $case_data->payment_status=='1'){
            $user_ids_top=Caseuser::where([['case_id', $case_id],['party_group', 'top']])->get()->pluck('user_id')->all();
            $user_ids_bottom=Caseuser::where([['case_id', $case_id],['party_group', 'bottom']])->get()->pluck('user_id')->all();
            $top_party_data=array();
            $i=0;
            if($user_ids_top){
                $case_data['total_top_parties']=count($user_ids_top);
                foreach($user_ids_top as $user_id){
                    $top_party_data[$i]=User::where('id', $user_id)->get()->first();
                    $caseuser=Caseuser::where([
                        ['case_id', $case_id],
                        ['attorney_id', Auth::user()->id],
                        ['user_id', $user_id]
                    ])->get()
                    ->first();
                    if(isset($caseuser->party_entity) && $caseuser->party_entity=='organization_company') {
                        $top_party_data[$i]['name']=$caseuser->org_comp_name;
                    } else {
                        if(isset($caseuser->mname) && $caseuser->mname !='') {
                            $mname=$caseuser->mname;
                            $namearray = explode(' ', $top_party_data[$i]['name'], 2);
                            if(count($namearray) > 1) {
                                $top_party_data[$i]['name']=$namearray[0].' '.$mname.' '.$namearray[1];
                            } else {
                                $top_party_data[$i]['name']=$top_party_data[$i]['name'].' '.$mname;
                            }
                        }
                    }

                    ++$i;
                }
            }
            $bottom_party_data=array();
            $i=0;
            if($user_ids_bottom){
                $case_data['total_bottom_parties']=count($user_ids_bottom);
                foreach($user_ids_bottom as $user_id){
                    $bottom_party_data[$i]=User::where('id', $user_id)->get()->first();
                    $caseuser=Caseuser::where([
                        ['case_id', $case_id],
                        ['attorney_id', Auth::user()->id],
                        ['user_id', $user_id]
                    ])->get()
                    ->first();
                    if(isset($caseuser->party_entity) && $caseuser->party_entity=='organization_company') {
                        $bottom_party_data[$i]['name']=$caseuser->org_comp_name;
                    } else {
                        if(isset($caseuser->mname) && $caseuser->mname !='') {
                            $mname=$caseuser->mname;
                            $namearray = explode(' ', $bottom_party_data[$i]['name'], 2);
                            if(count($namearray) > 1) {
                                $bottom_party_data[$i]['name']=$namearray[0].' '.$mname.' '.$namearray[1];
                            } else {
                                $bottom_party_data[$i]['name']=$bottom_party_data[$i]['name'].' '.$mname;
                            }
                        }
                    }

                    ++$i;
                }
            }

            // for third parties
            $user_ids_top_third=Caseuser::where([['case_id', $case_id],['party_group', 'top_third']])->get()->pluck('user_id')->all();
            $user_ids_bottom_third=Caseuser::where([['case_id', $case_id],['party_group', 'bottom_third']])->get()->pluck('user_id')->all();
            $top_third_party_data=array();
            $i=0;
            if($user_ids_top_third){
                $case_data['total_top_third_parties']=count($user_ids_top_third);
                foreach($user_ids_top_third as $user_id){
                    $top_third_party_data[$i]=User::where('id', $user_id)->get()->first();
                    $caseuser=Caseuser::where([
                        ['case_id', $case_id],
                        ['attorney_id', Auth::user()->id],
                        ['user_id', $user_id]
                    ])->get()
                    ->first();
                    if(isset($caseuser->party_entity) && $caseuser->party_entity=='organization_company') {
                        $top_third_party_data[$i]['name']=$caseuser->org_comp_name;
                    } else {
                        if(isset($caseuser->mname) && $caseuser->mname !='') {
                            $mname=$caseuser->mname;
                            $namearray = explode(' ', $top_third_party_data[$i]['name'], 2);
                            if(count($namearray) > 1) {
                                $top_third_party_data[$i]['name']=$namearray[0].' '.$mname.' '.$namearray[1];
                            } else {
                                $top_third_party_data[$i]['name']=$top_third_party_data[$i]['name'].' '.$mname;
                            }
                        }
                    }

                    ++$i;
                }
            }
            $bottom_third_party_data=array();
            $i=0;
            if($user_ids_bottom_third){
                $case_data['total_bottom_third_parties']=count($user_ids_bottom_third);
                foreach($user_ids_bottom_third as $user_id){
                    $bottom_third_party_data[$i]=User::where('id', $user_id)->get()->first();
                    $caseuser=Caseuser::where([
                        ['case_id', $case_id],
                        ['attorney_id', Auth::user()->id],
                        ['user_id', $user_id]
                    ])->get()
                    ->first();
                    if(isset($caseuser->party_entity) && $caseuser->party_entity=='organization_company') {
                        $bottom_third_party_data[$i]['name']=$caseuser->org_comp_name;
                    } else {
                        if(isset($caseuser->mname) && $caseuser->mname !='') {
                            $mname=$caseuser->mname;
                            $namearray = explode(' ', $bottom_third_party_data[$i]['name'], 2);
                            if(count($namearray) > 1) {
                                $bottom_third_party_data[$i]['name']=$namearray[0].' '.$mname.' '.$namearray[1];
                            } else {
                                $bottom_third_party_data[$i]['name']=$bottom_third_party_data[$i]['name'].' '.$mname;
                            }
                        }
                    }

                    ++$i;
                }
            }

            $pleading_types=DB::table('pleading_types')->get()->all();
            $pleading = Pleading::find($pleading_id);
            if($pleading){
                $parentpleading = Pleading::find($pleading->parent_pleading_id)->first();
                $pleadingparties=$pleading->pleadingparties;
                $filingparties=array();
                $responsibleparties=array();
                $responsiblepartiesdeadlines=array();
                foreach ($pleadingparties as $pleadingparty) {
                    if($pleadingparty && $pleadingparty->party_type=='filing'){
                        $filingparties[]=$pleadingparty->party_id;

                    } elseif ($pleadingparty && $pleadingparty->party_type=='responsible') {
                        $responsibleparties[]=$pleadingparty->party_id;

                        $responsiblepartiesdeadlines[$pleadingparty->party_id]['service_date']=$pleadingparty->service_date;
                        $responsiblepartiesdeadlines[$pleadingparty->party_id]['initial_deadline']=$pleadingparty->initial_deadline;
                        $responsiblepartiesdeadlines[$pleadingparty->party_id]['current_deadline']=$pleadingparty->current_deadline;

                    }
                }

                // user ids of top and bottom parties
            
                $user_ids_top_string=$user_ids_top[0];
                $user_ids_bottom_string=$user_ids_bottom[0];

                return view('pleadings.subordinate_edit',['case_id' => $case_id, 'top_party_data' => $top_party_data, 'bottom_party_data' => $bottom_party_data, 'top_third_party_data' => $top_third_party_data, 'bottom_third_party_data' => $bottom_third_party_data, 'case_data' => $case_data, 'pleading_types' => $pleading_types, 'pleading' => $pleading, 'filingparties' => $filingparties, 'responsibleparties' => $responsibleparties, 'responsiblepartiesdeadlines' => $responsiblepartiesdeadlines, 'user_ids_top_string' => $user_ids_top_string, 'user_ids_bottom_string' => $user_ids_bottom_string]); 
            } else{
                return redirect()->route('cases.index');
            } 
        } else {
            // return view('pleadings.index',['case_id' => $case_id]);
            return redirect()->route('cases.index');

        }

    }

    /* Update Create Subordinate Case Pleading Info */
    public function updateSubordinateCasePleading(Request $request)
    {
        $result = $request->except('submit');
        $case_id=$request->case_id;

                $user_ids_top_string=$request->user_ids_top_string;
        $user_ids_bottom_string=$request->user_ids_bottom_string;
        $user_ids_top_string=explode(" ", $user_ids_top_string);
        $user_ids_bottom_string=explode(" ", $user_ids_bottom_string);
        $pleading_caption='';
        foreach($user_ids_top_string as $user_id){
            $user_data=User::where('id', $user_id)->get()->first();
            $caseuser=Caseuser::where([
                ['case_id', $case_id],
                ['attorney_id', Auth::user()->id],
                ['user_id', $user_id]
            ])->get()
            ->first();
            $user_name=$user_data['name'];

            if(isset($caseuser->party_entity) && $caseuser->party_entity=='organization_company') {
                $user_name=$caseuser->org_comp_name;
            } else {
                if(isset($caseuser->mname) && $caseuser->mname!='') {
                    $mname=$caseuser->mname;
                }
                if(isset($mname) && $mname !='') {
                    $namearray = explode(' ', $user_data['name'], 2);
                    if(count($namearray) > 1) {
                        $user_name=$namearray[0].' '.$mname.' '.$namearray[1];
                    } else {
                        $user_name=$user_data['name'].' '.$mname;
                    }
                }
            }
            // $street_address=$caseuser->street_address;
            // $user_city=$caseuser->user_city;
            // $state_name= State::find($caseuser->state_id)->state;
            // $user_zipcode=$caseuser->user_zipcode;
            if($pleading_caption==''){
                $pleading_caption=$pleading_caption.$user_name;
            }
        }
        $pleading_caption=$pleading_caption.', et al. '.strtoupper($request->top_party_type).'S vs. ';
        $test='';
        foreach($user_ids_bottom_string as $user_id){
            $user_data=User::where('id', $user_id)->get()->first();
            $caseuser=Caseuser::where([
                ['case_id', $case_id],
                ['attorney_id', Auth::user()->id],
                ['user_id', $user_id]
            ])->get()
            ->first();
            $user_name=$user_data['name'];

            if(isset($caseuser->party_entity) && $caseuser->party_entity=='organization_company') {
                $user_name=$caseuser->org_comp_name;
            } else {
                if(isset($caseuser->mname) && $caseuser->mname!='') {
                    $mname=$caseuser->mname;
                }
                if(isset($mname) && $mname !='') {
                    $namearray = explode(' ', $user_data['name'], 2);
                    if(count($namearray) > 1) {
                        $user_name=$namearray[0].' '.$mname.' '.$namearray[1];
                    } else {
                        $user_name=$user_data['name'].' '.$mname;
                    }
                }
            }
            if($test==''){
                $pleading_caption=$pleading_caption.$user_name;
            }
            $test='test';
        }
        $pleading_caption=$pleading_caption.', et al. '.strtoupper($request->bottom_party_type).'S';

        $filings=$request->filings;
        if($request->responsibles){
            $responsibles=$request->responsibles;
        } else {
            $responsibles=[];
        }
        if($request->date_filed){
            $date_filed=date("Y-m-d",strtotime($request->date_filed));
        } else {
            $date_filed=NULL;
        }
        
        $data=array(
            'case_id'=>$request->case_id,
            'pleading_name'=>$request->pleading_name,
            'pleading_caption'=>$pleading_caption,
            'date_filed'=>$date_filed,
            'pleading_type_id'=>$request->pleading_type_id,
            'parent_pleading_id'=>$request->parent_pleading_id,
            'pleading_has_new_third_parties'=>$request->pleading_has_new_third_parties,
            'pleading_includes_claims'=>$request->pleading_includes_claims,
        );
        $pleading = Pleading::find($request->pleading_id);
        $pleadingparties=$pleading->pleadingparties;
        $pleadingdata=$pleading->update($data);
        if(isset($pleadingparties) && $pleadingparties->count() >0){
            Pleadingparty::where('pleading_id',$request->pleading_id)->delete();
        }
        $totalsenders=0;$totalreceivers=0;$totalobservers=0;
        $data2=array();
        if($filings){
            $num=1;
            foreach ($filings as $filing) {
                $party_type="filing";
                $party_class="S".$num++;
                $data2[] = $data = array(
                    'pleading_id' => $pleading->id,
                    'party_id' => $filing,
                    'party_type' => $party_type,
                    'party_class' => $party_class,
                    'service_date' => NULL,
                    'initial_deadline' => NULL,
                    'current_deadline' => NULL,
                    'created_at'=>now(),
                    'updated_at'=>now(),
                );
                $pleadingparty = Pleadingparty::create($data);
                ++$totalsenders;
            }
        }
        if($responsibles && (isset($request->pleading_includes_claims) && $request->pleading_includes_claims=='Yes')){
            $num=1;
            foreach ($responsibles as $responsible) {
                $service_date=$initial_deadline=$current_deadline=NULL;
                if(isset($result['service_date_'.$responsible.'']) && $result['service_date_'.$responsible.''] !='') 
                {
                    $service_date=date("Y-m-d",strtotime($result['service_date_'.$responsible.'']));
                }
                if(isset($result['initial_deadline_'.$responsible.'']) && $result['initial_deadline_'.$responsible.''] !='') 
                {
                    $initial_deadline=date("Y-m-d",strtotime($result['initial_deadline_'.$responsible.'']));
                }
                if(isset($result['current_deadline_'.$responsible.'']) && $result['current_deadline_'.$responsible.''] !='') 
                {
                    $current_deadline=date("Y-m-d",strtotime($result['current_deadline_'.$responsible.'']));
                }

                $party_type="responsible";
                $party_class="R".$num++;
                $data2[] = $data = array(
                    'pleading_id' => $pleading->id,
                    'party_id' => $responsible,
                    'party_type' => $party_type,
                    'party_class' => $party_class,
                    'service_date' => $service_date,
                    'initial_deadline' => $initial_deadline,
                    'current_deadline' => $current_deadline,
                    'created_at'=>now(),
                    'updated_at'=>now(),
                );
                $pleadingparty = Pleadingparty::create($data);
                ++$totalreceivers;
            }
        }
        // for observers
        $pleading_checked_parties=array_unique(array_merge($filings,$responsibles));
        $pleading_all_parties=Caseuser::where([['case_id', $case_id],['attorney_id', Auth::user()->id]])->get()->pluck('user_id')->all();
        $observers=array_diff($pleading_all_parties,$pleading_checked_parties);

        $num=1;
        foreach ($observers as $observer) {            
            $party_type="NA";
            $party_class="O".$num++;
            $data2[] = $data = array(
                'pleading_id' => $pleading->id,
                'party_id' => $observer,
                'party_type' => $party_type,
                'party_class' => $party_class,
                'service_date' => NULL,
                'initial_deadline' => NULL,
                'current_deadline' => NULL,
                'created_at'=>now(),
                'updated_at'=>now(),
            );
            $pleadingparty = Pleadingparty::create($data);
            ++$totalobservers;
        }

        // if(isset($pleadingparties) && $pleadingparties->count() >0){
        //     Pleadingparty::where('pleading_id',$request->pleading_id)->delete();
        //     $pleadingparty = Pleadingparty::insert($data2);
        // } else{
        //     $pleadingparty = Pleadingparty::insert($data2);
        // }
        // update pleading table
        $pleadingtoupdate = Pleading::find($pleading->id);

        $pleadingtoupdate->num_s = $totalsenders;
        $pleadingtoupdate->num_r = $totalreceivers;
        $pleadingtoupdate->num_o = $totalobservers;

        $pleadingtoupdate->save();
        // dd($data2);
        // to update senders and receivers info
        $pleading_id=$pleading->id;
        $pleading=Pleading::find($pleading_id);
        $case_id=$pleading->case_id;
        $pleadingparties=$pleading->pleadingparties;
        // for updating sender info
        $num=0;
        $numsenders=0;
        $pleading_parties_info=array(
                            'pleading_id'=>$pleading_id,
                        );
        foreach ($pleadingparties as $pleadingparty)
        {
            if($numsenders < $pleading->num_s){
                $userinfo=User::find($pleadingparty->party_id);
                $name=$userinfo->name;
                $fullname=$userinfo->name;
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
                    if(isset($caseuser->suffix)){
                        if($caseuser->suffix=='I' || $caseuser->suffix=='II' || $caseuser->suffix=='III' || $caseuser->suffix=='IV'){
                            $fullname=$fullname.' '.$caseuser->suffix;
                        } else {
                            $fullname=$fullname.', '.$caseuser->suffix;
                        }
                    }
                }
                if(isset($caseuser->state_id) && $caseuser->state_id !=''){
                    $state_name=State::find($caseuser->state_id)->state;
                } else {
                    $state_name='';
                }
                if(isset($caseuser->county_id) && $caseuser->county_id !=''){
                    $county_name=County::find($caseuser->county_id)->county_name;
                } else {
                    $county_name='';
                }
                if(isset($caseuser->user_city) && $caseuser->user_city !=''){
                    $city_name=$caseuser->user_city;
                } else {
                    $city_name='';
                }
                if(isset($caseuser->user_zipcode) && $caseuser->user_zipcode !=''){
                    $user_zipcode=$caseuser->user_zipcode;
                } else {
                    $user_zipcode='';
                }
                if(isset($caseuser->state_id) && isset($caseuser->user_zipcode) && isset($caseuser->user_city)){
                    $citystatezip=$city_name.', '.$state_name.' '.$caseuser->user_zipcode;
                } else {
                    $citystatezip=NULL;
                }
                
                
                $num_attys=0;
                $attorney_ids=Partyattorney::where([['party_id', $pleadingparty->party_id],['case_id', $case_id]])->get();
                if($attorney_ids){
                    $num_attys=count($attorney_ids);
                }

                $num++;

                $pleading_parties_info['fullnameS'.$num.'']=$fullname;
                $pleading_parties_info['fnameS'.$num.'']=$caseuser->fname;
                $pleading_parties_info['mnameS'.$num.'']=$caseuser->mname;
                $pleading_parties_info['lnameS'.$num.'']=$caseuser->lname;
                $pleading_parties_info['shortnameS'.$num.'']=$caseuser->short_name;
                $pleading_parties_info['genderS'.$num.'']=$caseuser->gender;
                $pleading_parties_info['streetadS'.$num.'']=$caseuser->street_address;
                $pleading_parties_info['unitS'.$num.'']=$caseuser->unit;
                $pleading_parties_info['poboxS'.$num.'']=$caseuser->pobox;
                $pleading_parties_info['citystatezipS'.$num.'']=$citystatezip;
                $pleading_parties_info['telephoneS'.$num.'']=$caseuser->telephone;
                $pleading_parties_info['faxS'.$num.'']=$caseuser->fax;
                $pleading_parties_info['emailS'.$num.'']=$userinfo->email;
                $pleading_parties_info['nameunknownS'.$num.'']=$caseuser->name_unknown;
                $pleading_parties_info['addressunknownS'.$num.'']=$caseuser->address_unknown;
                $pleading_parties_info['gendescS'.$num.'']=$caseuser->gen_desc;
                $pleading_parties_info['ismultidescS'.$num.'']=$caseuser->is_multi_desc;
                $pleading_parties_info['moregendescS'.$num.'']=$caseuser->more_gen_desc;
                $pleading_parties_info['pauperisS'.$num.'']=$caseuser->pauperis;

                // for updating party attornies info
                if($num <= 9)
                {
                    $attorney_ids=Partyattorney::where([['party_id', $pleadingparty->party_id],['case_id', $case_id]])->get()->all();
                    $attorney=array('pleading_id'=>$pleading_id);
                    $num1=0;
                    $totalattornies=count($attorney_ids);
                    foreach($attorney_ids as $attorney_user_id){
                        $attorneyuserinfo=User::find($attorney_user_id->attorney_id);
                        $attorneyname=$attorneyuserinfo->name;
                        $attorneyemail=$attorneyuserinfo->email;
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

                        $attorneycitystatezip=$party_attorney->firm_city.', '.$party_attorney->state.' '.$party_attorney->firm_zipcode;

                        $num1++;
                        $attorney['signnameS'.$num.'A'.$num1.'']=$party_attorney->document_sign_name;
                        $attorney['firmS'.$num.'A'.$num1.'']=$party_attorney->firm_name;
                        $attorney['streetadS'.$num.'A'.$num1.'']=$party_attorney->firm_street_address;
                        $attorney['unitS'.$num.'A'.$num1.'']=$party_attorney->firm_suite_unit_mailcode;
                        $attorney['poboxS'.$num.'A'.$num1.'']=$party_attorney->po_box;
                        $attorney['citystatezipS'.$num.'A'.$num1.'']=$attorneycitystatezip;
                        $attorney['telephoneS'.$num.'A'.$num1.'']=$party_attorney->firm_telephone;
                        $attorney['faxS'.$num.'A'.$num1.'']=$party_attorney->firm_fax;
                        $attorney['emailS'.$num.'A'.$num1.'']=$attorneyemail;
                        
                    }
                    $limit=$num1+1;
                    for($j=$limit; $j<=3; $j++){
                        $attorney['signnameS'.$num.'A'.$j.'']=NULL;
                        $attorney['firmS'.$num.'A'.$j.'']=NULL;
                        $attorney['streetadS'.$num.'A'.$j.'']=NULL;
                        $attorney['unitS'.$num.'A'.$j.'']=NULL;
                        $attorney['poboxS'.$num.'A'.$j.'']=NULL;
                        $attorney['citystatezipS'.$num.'A'.$j.'']=NULL;
                        $attorney['telephoneS'.$num.'A'.$j.'']=NULL;
                        $attorney['faxS'.$num.'A'.$j.'']=NULL;
                        $attorney['emailS'.$num.'A'.$j.'']=NULL;
                    }

                    $partytypeattorneyinfoprev=PleadingSendersAttorneysInfo1::where('pleading_id', $pleading_id)->get()->first();
                    if($partytypeattorneyinfoprev){
                    // dd($attorney);
                        $partytypeattorneyinfo=$partytypeattorneyinfoprev->fill($attorney)->save();
                    } else {
                        $partytypeattorneyinfo=PleadingSendersAttorneysInfo1::create($attorney);
                    }
                }

                if($num > 9)
                {
                    $attorney_ids=Partyattorney::where([['party_id', $pleadingparty->party_id],['case_id', $case_id]])->get()->all();
                    $attorney=array('pleading_id'=>$pleading_id);
                    $num1=0;
                    $totalattornies=count($attorney_ids);
                    foreach($attorney_ids as $attorney_user_id){
                        $attorneyuserinfo=User::where($attorney_user_id->attorney_id);
                        $attorneyname=$attorneyuserinfo->name;
                        $attorneyemail=$attorneyuserinfo->email;
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

                        $attorneycitystatezip=$party_attorney->firm_city.', '.$party_attorney->state.' '.$party_attorney->firm_zipcode;

                        $num1++;
                        $attorney['signnameS'.$num.'A'.$num1.'']=$party_attorney->document_sign_name;
                        $attorney['firmS'.$num.'A'.$num1.'']=$party_attorney->firm_name;
                        $attorney['streetadS'.$num.'A'.$num1.'']=$party_attorney->firm_street_address;
                        $attorney['unitS'.$num.'A'.$num1.'']=$party_attorney->firm_suite_unit_mailcode;
                        $attorney['poboxS'.$num.'A'.$num1.'']=$party_attorney->po_box;
                        $attorney['citystatezipS'.$num.'A'.$num1.'']=$attorneycitystatezip;
                        $attorney['telephoneS'.$num.'A'.$num1.'']=$party_attorney->firm_telephone;
                        $attorney['faxS'.$num.'A'.$num1.'']=$party_attorney->firm_fax;
                        $attorney['emailS'.$num.'A'.$num1.'']=$attorneyemail;
                        
                    }
                    $limit=$num1+1;
                    for($j=$limit; $j<=3; $j++){
                        $attorney['signnameS'.$num.'A'.$j.'']=NULL;
                        $attorney['firmS'.$num.'A'.$j.'']=NULL;
                        $attorney['streetadS'.$num.'A'.$j.'']=NULL;
                        $attorney['unitS'.$num.'A'.$j.'']=NULL;
                        $attorney['poboxS'.$num.'A'.$j.'']=NULL;
                        $attorney['citystatezipS'.$num.'A'.$j.'']=NULL;
                        $attorney['telephoneS'.$num.'A'.$j.'']=NULL;
                        $attorney['faxS'.$num.'A'.$j.'']=NULL;
                        $attorney['emailS'.$num.'A'.$j.'']=NULL;
                    }

                    $partytypeattorneyinfoprev=PleadingSendersAttorneysInfo2::where('pleading_id', $pleading_id)->get()->first();
                    if($partytypeattorneyinfoprev){
                        $partytypeattorneyinfo=$partytypeattorneyinfoprev->fill($attorney)->save();
                    } else {
                        $partytypeattorneyinfo=PleadingSendersAttorneysInfo2::create($attorney);
                    }
                } else {
                    $attorney2=array('pleading_id'=>$pleading_id);
                    $partytypeattorneyinfoprev=PleadingSendersAttorneysInfo2::where('pleading_id', $pleading_id)->get()->first();
                    if($partytypeattorneyinfoprev){
                        $partytypeattorneyinfo=$partytypeattorneyinfoprev->fill($attorney2)->save();
                    } else {
                        $partytypeattorneyinfo=PleadingSendersAttorneysInfo2::create($attorney2);
                    }
                }
            }

            ++$numsenders; 
            // end for updating party attornies info
        }
        $partytypeinfoprev=PleadingSendersInfo::where('pleading_id', $pleading_id)->get()->first();
        if($partytypeinfoprev){
            $partytypeinfo=$partytypeinfoprev->fill($pleading_parties_info)->save();
        } else {
            $partytypeinfo=PleadingSendersInfo::create($pleading_parties_info);
        }
        // end for updating sender info

        // for updating receiver info

        $num=0;
        $numreceivers=0;
        $pleading_parties_info1=array(
                            'pleading_id'=>$pleading_id,
                        );
        foreach ($pleadingparties as $pleadingparty)
        {
            if($numreceivers >= $pleading->num_s){
            // if($numreceivers < $pleading->num_r){
                $userinfo=User::find($pleadingparty->party_id);
                $name=$userinfo->name;
                $fullname=$userinfo->name;
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
                    if(isset($caseuser->suffix)){
                        if($caseuser->suffix=='I' || $caseuser->suffix=='II' || $caseuser->suffix=='III' || $caseuser->suffix=='IV'){
                            $fullname=$fullname.' '.$caseuser->suffix;
                        } else {
                            $fullname=$fullname.', '.$caseuser->suffix;
                        }
                    }
                }

                if(isset($caseuser->state_id) && $caseuser->state_id !=''){
                    $state_name=State::find($caseuser->state_id)->state;
                } else {
                    $state_name='';
                }
                if(isset($caseuser->county_id) && $caseuser->county_id !=''){
                    $county_name=County::find($caseuser->county_id)->county_name;
                } else {
                    $county_name='';
                }
                if(isset($caseuser->user_city) && $caseuser->user_city !=''){
                    $city_name=$caseuser->user_city;
                } else {
                    $city_name='';
                }
                if(isset($caseuser->user_zipcode) && $caseuser->user_zipcode !=''){
                    $user_zipcode=$caseuser->user_zipcode;
                } else {
                    $user_zipcode='';
                }
                if(isset($caseuser->state_id) && isset($caseuser->user_zipcode) && isset($caseuser->user_city)){
                    $citystatezip=$city_name.', '.$state_name.' '.$caseuser->user_zipcode;
                } else {
                    $citystatezip=NULL;
                }
                $num_attys=0;
                $attorney_ids=Partyattorney::where([['party_id', $pleadingparty->party_id],['case_id', $case_id]])->get();
                if($attorney_ids){
                    $num_attys=count($attorney_ids);
                }

                $num++;

                $pleading_parties_info1['fullnameR'.$num.'']=$fullname;
                $pleading_parties_info1['fnameR'.$num.'']=$caseuser->fname;
                $pleading_parties_info1['mnameR'.$num.'']=$caseuser->mname;
                $pleading_parties_info1['lnameR'.$num.'']=$caseuser->lname;
                $pleading_parties_info1['shortnameR'.$num.'']=$caseuser->short_name;
                $pleading_parties_info1['genderR'.$num.'']=$caseuser->gender;
                $pleading_parties_info1['streetadR'.$num.'']=$caseuser->street_address;
                $pleading_parties_info1['unitR'.$num.'']=$caseuser->unit;
                $pleading_parties_info1['poboxR'.$num.'']=$caseuser->pobox;
                $pleading_parties_info1['citystatezipR'.$num.'']=$citystatezip;
                $pleading_parties_info1['telephoneR'.$num.'']=$caseuser->telephone;
                $pleading_parties_info1['faxR'.$num.'']=$caseuser->fax;
                $pleading_parties_info1['emailR'.$num.'']=$userinfo->email;
                $pleading_parties_info1['nameunknownR'.$num.'']=$caseuser->name_unknown;
                $pleading_parties_info1['addressunknownR'.$num.'']=$caseuser->address_unknown;
                $pleading_parties_info1['gendescR'.$num.'']=$caseuser->gen_desc;
                $pleading_parties_info1['ismultidescR'.$num.'']=$caseuser->is_multi_desc;
                $pleading_parties_info1['moregendescR'.$num.'']=$caseuser->more_gen_desc;
                $pleading_parties_info1['pauperisR'.$num.'']=$caseuser->pauperis;

                // for updating party attornies info
                if($num <= 9)
                {
                    $attorney_ids=Partyattorney::where([['party_id', $pleadingparty->party_id],['case_id', $case_id]])->get()->all();
                    $attorney=array('pleading_id'=>$pleading_id);
                    $num1=0;
                    $totalattornies=count($attorney_ids);
                    foreach($attorney_ids as $attorney_user_id){
                       $attorneyuserinfo=User::find($attorney_user_id->attorney_id);
                        $attorneyname=$attorneyuserinfo->name;
                        $attorneyemail=$attorneyuserinfo->email;
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

                        $attorneycitystatezip=$party_attorney->firm_city.', '.$party_attorney->state.' '.$party_attorney->firm_zipcode;

                        $num1++;
                        $attorney['signnameR'.$num.'A'.$num1.'']=$party_attorney->document_sign_name;
                        $attorney['firmR'.$num.'A'.$num1.'']=$party_attorney->firm_name;
                        $attorney['streetadR'.$num.'A'.$num1.'']=$party_attorney->firm_street_address;
                        $attorney['unitR'.$num.'A'.$num1.'']=$party_attorney->firm_suite_unit_mailcode;
                        $attorney['poboxR'.$num.'A'.$num1.'']=$party_attorney->po_box;
                        $attorney['citystatezipR'.$num.'A'.$num1.'']=$attorneycitystatezip;
                        $attorney['telephoneR'.$num.'A'.$num1.'']=$party_attorney->firm_telephone;
                        $attorney['faxR'.$num.'A'.$num1.'']=$party_attorney->firm_fax;
                        $attorney['emailR'.$num.'A'.$num1.'']=$attorneyemail;
                        
                    }
                    $limit=$num1+1;
                    for($j=$limit; $j<=3; $j++){
                        $attorney['signnameR'.$num.'A'.$j.'']=NULL;
                        $attorney['firmR'.$num.'A'.$j.'']=NULL;
                        $attorney['streetadR'.$num.'A'.$j.'']=NULL;
                        $attorney['unitR'.$num.'A'.$j.'']=NULL;
                        $attorney['poboxR'.$num.'A'.$j.'']=NULL;
                        $attorney['citystatezipR'.$num.'A'.$j.'']=NULL;
                        $attorney['telephoneR'.$num.'A'.$j.'']=NULL;
                        $attorney['faxR'.$num.'A'.$j.'']=NULL;
                        $attorney['emailR'.$num.'A'.$j.'']=NULL;
                    }

                    $partytypeattorneyinfoprev=PleadingReceiversAttorneysInfo1::where('pleading_id', $pleading_id)->get()->first();
                    if($partytypeattorneyinfoprev){
                    // dd($attorney);
                        $partytypeattorneyinfo=$partytypeattorneyinfoprev->fill($attorney)->save();
                    } else {
                        $partytypeattorneyinfo=PleadingReceiversAttorneysInfo1::create($attorney);
                    }
                }

                if($num > 9)
                {
                    $attorney_ids=Partyattorney::where([['party_id', $pleadingparty->party_id],['case_id', $case_id]])->get()->all();
                    $attorney=array('pleading_id'=>$pleading_id);
                    $num1=0;
                    $totalattornies=count($attorney_ids);
                    foreach($attorney_ids as $attorney_user_id){
                       $attorneyuserinfo=User::find($attorney_user_id->attorney_id);
                        $attorneyname=$attorneyuserinfo->name;
                        $attorneyemail=$attorneyuserinfo->email;
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

                        $attorneycitystatezip=$party_attorney->firm_city.', '.$party_attorney->state.' '.$party_attorney->firm_zipcode;

                        $num1++;
                        $attorney['signnameR'.$num.'A'.$num1.'']=$party_attorney->document_sign_name;
                        $attorney['firmR'.$num.'A'.$num1.'']=$party_attorney->firm_name;
                        $attorney['streetadR'.$num.'A'.$num1.'']=$party_attorney->firm_street_address;
                        $attorney['unitR'.$num.'A'.$num1.'']=$party_attorney->firm_suite_unit_mailcode;
                        $attorney['poboxR'.$num.'A'.$num1.'']=$party_attorney->po_box;
                        $attorney['citystatezipR'.$num.'A'.$num1.'']=$attorneycitystatezip;
                        $attorney['telephoneR'.$num.'A'.$num1.'']=$party_attorney->firm_telephone;
                        $attorney['faxR'.$num.'A'.$num1.'']=$party_attorney->firm_fax;
                        $attorney['emailR'.$num.'A'.$num1.'']=$attorneyemail;
                        
                    }
                    $limit=$num1+1;
                    for($j=$limit; $j<=3; $j++){
                        $attorney['signnameR'.$num.'A'.$j.'']=NULL;
                        $attorney['firmR'.$num.'A'.$j.'']=NULL;
                        $attorney['streetadR'.$num.'A'.$j.'']=NULL;
                        $attorney['unitR'.$num.'A'.$j.'']=NULL;
                        $attorney['poboxR'.$num.'A'.$j.'']=NULL;
                        $attorney['citystatezipR'.$num.'A'.$j.'']=NULL;
                        $attorney['telephoneR'.$num.'A'.$j.'']=NULL;
                        $attorney['faxR'.$num.'A'.$j.'']=NULL;
                        $attorney['emailR'.$num.'A'.$j.'']=NULL;
                    }

                    $partytypeattorneyinfoprev=PleadingReceiversAttorneysInfo2::where('pleading_id', $pleading_id)->get()->first();
                    if($partytypeattorneyinfoprev){
                        $partytypeattorneyinfo=$partytypeattorneyinfoprev->fill($attorney)->save();
                    } else {
                        $partytypeattorneyinfo=PleadingReceiversAttorneysInfo2::create($attorney);
                    }
                } else {
                    $attorney2=array('pleading_id'=>$pleading_id);
                    $partytypeattorneyinfoprev=PleadingReceiversAttorneysInfo2::where('pleading_id', $pleading_id)->get()->first();
                    if($partytypeattorneyinfoprev){
                        $partytypeattorneyinfo=$partytypeattorneyinfoprev->fill($attorney2)->save();
                    } else {
                        $partytypeattorneyinfo=PleadingReceiversAttorneysInfo2::create($attorney2);
                    }
                }
            }

            ++$numreceivers; 
            // end for updating party attornies info
        }
        $partytypeinfoprev=PleadingReceiversInfo::where('pleading_id', $pleading_id)->get()->first();
        if($partytypeinfoprev){
            $partytypeinfo=$partytypeinfoprev->fill($pleading_parties_info1)->save();
        } else {
            $partytypeinfo=PleadingReceiversInfo::create($pleading_parties_info1);
        }
        // end for updating receiver info
        return redirect()->route('cases.pleadings',['case_id' => $request->case_id])->with('success', 'Subordinate Pleading Updated Successfully!');

    }

    /* Redirect to Case Interview Tabs Page */
    public function redirectToCompleteInItialInterview($case_id){
        Session::put('complete_initial_interview', TRUE);
        return redirect()->route('cases.family_law_interview_tabs',['case_id' => $case_id]);
    }

    // for Case Practice Aids
    public function draftCasePracticeAids(Request $request)
    {
        $doc_number=$request->select_case_practice_aid;
        $admin_email=Setting::where('setting_key', 'admin_email')->pluck('setting_value')->first();
        $case_id = $request->case_id;
       // $doctype = $request->doctype;
        if(!$admin_email){
          $admin_email=env('APP_EMAIL');
        }
        $user_ids_top=Caseuser::where([['case_id', $case_id],['party_group', 'top']])->count();
        
        $user_ids_bottom=Caseuser::where([['case_id', $case_id],['party_group', 'bottom']])->count();
       /* $triggers_attorneyself=DB::table('triggers_all')->insert(
            ['attorney_self_id' => Auth::user()->id,'case_id' => $request->case_id, 'trig_package' => $doc_number]
        );*/

         //if($doc_number == "BigCasePATest Package"){

             /* Fetch all the documents that need to be generated against the selected package. 
            $package_data = DB::table('document_package_table')->join('document_table', 'document_table.doc_number', '=', 'document_package_table.doc_id')->where('document_package_table.package_name',$doc_number) ->select('document_package_table.*', 'document_table.*')->get();*/

             /* Initiating the package record to start the document generation */
            $triggers_all_packages = DB::table('triggers_all_packages')->insertGetId(
                 ['attorney_self_id' => Auth::user()->id, 'trig_package' => $doc_number,'package_select'=> 1,'case_id'=>$case_id]);

            /*foreach($package_data as $key=>$val){
             $triggers_attorneyself=DB::table('triggers_all_documents')->insert(
                ['attorney_self_id' => Auth::user()->id, 'doc_disp_name' => $val->doc_disp_name,'queryview'=>$val->queryview,'doc_number'=>$val->doc_number,'vote_dir'=>$val->vote_dir,'trig_package'=>$doc_number,'trig'=>1,'case_id'=>$case_id,'p_id'=>$triggers_all_packages]
            );
         }*/
              $user_id = Auth::user()->id;
              $maxid = max($user_ids_top,$user_ids_bottom);
              if($maxid == 0){
                $maxid = 1;
              }
            /* call the procedure to update the package_select 0 */ 
            DB::select("CALL packages2docs(?,?)",[$user_id,$maxid]);

            $votes=DB::table('FDD_triggers_all_documents_Votes')->get();
            $success_macros=0;
            $failed_macros=0;
            foreach($votes as $vote){
                exec('touch '.$vote->vote_dir.'', $output, $return);
                //sleep(1);
                // Return will return non-zero upon an error
                if (!$return)
                {
                  ++$success_macros;
                      // sleep(3);
                      
                      // return redirect()->route('get_practice_aids_downloads');                  

                } else {
                      // $response= "PDF not created";
                      ++$failed_macros;
                }
            }
        
        // }
         //else
         //{
            /* Fetch all the documents that need to be generated against the selected package. 
            $package_data = DB::table('document_package_table')->join('document_table', 'document_table.doc_number', '=', 'document_package_table.doc_id')->where('document_package_table.package_name',$doc_number) ->select('document_package_table.*', 'document_table.*')->first();

            $triggers_all_packages = DB::table('triggers_all_packages')->insertGetId(
                 ['attorney_self_id' => Auth::user()->id, 'trig_package' => $doc_number,'package_select'=> 1,'case_id'=>$case_id]
          );
          
            
            if(isset($request->case_practice_aid_type) && $request->case_practice_aid_type == 'fam_law'){
                //$votes=DB::table('FDD_View_CoreCase_FamLaw_Votes')->get(); 
                $votes=DB::table('FDD_triggers_all_documents_Votes')->get();
               
            } else {
                //$votes=DB::table('FDD_View_CoreCase_Votes')->get();
                $votes=DB::table('FDD_triggers_all_documents_Votes')->get();
              }
                $user_id = Auth::user()->id;*/
                /* call the procedure to update the package_select 0  
                DB::select("CALL packages2docs(?)",[$user_id]);
                $success_macros=0;
                $failed_macros=0;*/
                /*foreach($votes as $vote){
                    exec('touch '.$vote->vote_dir.'', $output, $return);
                    sleep(1);
                    // Return will return non-zero upon an error
                    if (!$return)
                    {
                      ++$success_macros;
                          // sleep(3);
                          
                          // return redirect()->route('get_practice_aids_downloads');                  

                    } else {
                          // $response= "PDF not created";
                          ++$failed_macros;
                    }
                }*/
        //}

        return redirect()->route('attorney.downloads')->with('success', 'Your drafts will be available in your download directory soon. If you do not see your file here after a few seconds then please try again or Email Us.');
    }

    // for drafting Compalint Package

    public function draftComplaintPackage(Request $request){
        // if(isset($request->select_complaint_type)){
        //     $triggers_attorneyself=DB::table('triggers_all')->insert(
        //         ['attorney_self_id' => Auth::user()->id, 'trig_package' => $doc_number]
        //     );

        //     $votes=DB::table('FDD_View_Attorney_Self_Votes')->get();
        //     $success_macros=0;
        //     $failed_macros=0;
        //     foreach($votes as $vote){
        //         exec('touch '.$vote->vote_dir.'', $output, $return);
        //         sleep(1);
        //         // Return will return non-zero upon an error
        //         if (!$return)
        //         {
        //           ++$success_macros;                

        //         } else {
        //               ++$failed_macros;
        //         }
        //     }
        // }
        $complaint_doc_table_data = DB::table('document_table')->where('doc_type', 'Complaint')->get()->first();
        if($complaint_doc_table_data){
            $aux_table_data=array(
                'document_id' => $complaint_doc_table_data->doc_number,
                'case_id' => $request->case_id, 
                'aux_int1' => $request->number_of_exhibits, 
                'aux_txt1' => $request->verified_complaint
            );
            $aux_table_updated=AuxTable::create($aux_table_data);
            if($aux_table_updated){
                // return redirect()->route('cases.pleadings.create',['case_id' => $request->case_id]);
                $case_id=$request->case_id;
                $case_data=Courtcase::find($case_id);
                if(isset($case_data) && $case_data->attorney_id==Auth::user()->id && $case_data->payment_status=='1'){
                    $user_ids_top=Caseuser::where([['case_id', $case_id],['party_group', 'top']])->get()->pluck('user_id')->all();
                    $user_ids_bottom=Caseuser::where([['case_id', $case_id],['party_group', 'bottom']])->get()->pluck('user_id')->all();
                    $top_party_data=array();
                    $i=0;
                    if($user_ids_top){
                        $case_data['total_top_parties']=count($user_ids_top);
                        foreach($user_ids_top as $user_id){
                            $top_party_data[$i]=User::where('id', $user_id)->get()->first();
                            $caseuser=Caseuser::where([
                                ['case_id', $case_id],
                                ['attorney_id', Auth::user()->id],
                                ['user_id', $user_id]
                            ])->get()
                            ->first();
                            if(isset($caseuser->party_entity) && $caseuser->party_entity=='organization_company') {
                                $top_party_data[$i]['name']=$caseuser->org_comp_name;
                            } else {
                                if(isset($caseuser->mname) && $caseuser->mname !='') {
                                    $mname=$caseuser->mname;
                                    $namearray = explode(' ', $top_party_data[$i]['name'], 2);
                                    if(count($namearray) > 1) {
                                        $top_party_data[$i]['name']=$namearray[0].' '.$mname.' '.$namearray[1];
                                    } else {
                                        $top_party_data[$i]['name']=$top_party_data[$i]['name'].' '.$mname;
                                    }
                                }
                            }

                            ++$i;
                        }
                    }
                    $bottom_party_data=array();
                    $i=0;
                    if($user_ids_bottom){
                        $case_data['total_bottom_parties']=count($user_ids_bottom);
                        foreach($user_ids_bottom as $user_id){
                            $bottom_party_data[$i]=User::where('id', $user_id)->get()->first();
                            $caseuser=Caseuser::where([
                                ['case_id', $case_id],
                                ['attorney_id', Auth::user()->id],
                                ['user_id', $user_id]
                            ])->get()
                            ->first();
                            if(isset($caseuser->party_entity) && $caseuser->party_entity=='organization_company') {
                                $bottom_party_data[$i]['name']=$caseuser->org_comp_name;
                            } else {
                                if(isset($caseuser->mname) && $caseuser->mname !='') {
                                    $mname=$caseuser->mname;
                                    $namearray = explode(' ', $bottom_party_data[$i]['name'], 2);
                                    if(count($namearray) > 1) {
                                        $bottom_party_data[$i]['name']=$namearray[0].' '.$mname.' '.$namearray[1];
                                    } else {
                                        $bottom_party_data[$i]['name']=$bottom_party_data[$i]['name'].' '.$mname;
                                    }
                                }
                            }

                            ++$i;
                        }
                    }

                    // for third parties
                    $user_ids_top_third=Caseuser::where([['case_id', $case_id],['party_group', 'top_third']])->get()->pluck('user_id')->all();
                    $user_ids_bottom_third=Caseuser::where([['case_id', $case_id],['party_group', 'bottom_third']])->get()->pluck('user_id')->all();
                    $top_third_party_data=array();
                    $i=0;
                    if($user_ids_top_third){
                        $case_data['total_top_third_parties']=count($user_ids_top_third);
                        foreach($user_ids_top_third as $user_id){
                            $top_third_party_data[$i]=User::where('id', $user_id)->get()->first();
                            $caseuser=Caseuser::where([
                                ['case_id', $case_id],
                                ['attorney_id', Auth::user()->id],
                                ['user_id', $user_id]
                            ])->get()
                            ->first();
                            if(isset($caseuser->party_entity) && $caseuser->party_entity=='organization_company') {
                                $top_third_party_data[$i]['name']=$caseuser->org_comp_name;
                            } else {
                                if(isset($caseuser->mname) && $caseuser->mname !='') {
                                    $mname=$caseuser->mname;
                                    $namearray = explode(' ', $top_third_party_data[$i]['name'], 2);
                                    if(count($namearray) > 1) {
                                        $top_third_party_data[$i]['name']=$namearray[0].' '.$mname.' '.$namearray[1];
                                    } else {
                                        $top_third_party_data[$i]['name']=$top_third_party_data[$i]['name'].' '.$mname;
                                    }
                                }
                            }

                            ++$i;
                        }
                    }
                    $bottom_third_party_data=array();
                    $i=0;
                    if($user_ids_bottom_third){
                        $case_data['total_bottom_third_parties']=count($user_ids_bottom_third);
                        foreach($user_ids_bottom_third as $user_id){
                            $bottom_third_party_data[$i]=User::where('id', $user_id)->get()->first();
                            $caseuser=Caseuser::where([
                                ['case_id', $case_id],
                                ['attorney_id', Auth::user()->id],
                                ['user_id', $user_id]
                            ])->get()
                            ->first();
                            if(isset($caseuser->party_entity) && $caseuser->party_entity=='organization_company') {
                                $bottom_third_party_data[$i]['name']=$caseuser->org_comp_name;
                            } else {
                                if(isset($caseuser->mname) && $caseuser->mname !='') {
                                    $mname=$caseuser->mname;
                                    $namearray = explode(' ', $bottom_third_party_data[$i]['name'], 2);
                                    if(count($namearray) > 1) {
                                        $bottom_third_party_data[$i]['name']=$namearray[0].' '.$mname.' '.$namearray[1];
                                    } else {
                                        $bottom_third_party_data[$i]['name']=$bottom_third_party_data[$i]['name'].' '.$mname;
                                    }
                                }
                            }

                            ++$i;
                        }
                    }

                    // user ids of top and bottom parties
                    
                    $user_ids_top_string=implode(" ", $user_ids_top);
                    $user_ids_bottom_string=implode(" ", $user_ids_bottom);

                    $pleading_types=DB::table('pleading_types')->get()->all();
                    $pleadings = Pleading::where([['case_id', $case_id],['parent_pleading_id', '0']])->get();
                    $pleading_level=count($pleadings)+1;
                    return view('pleadings.complaint_package_create',['case_id' => $case_id, 'top_party_data' => $top_party_data, 'bottom_party_data' => $bottom_party_data, 'top_third_party_data' => $top_third_party_data, 'bottom_third_party_data' => $bottom_third_party_data, 'case_data' => $case_data, 'pleading_types' => $pleading_types, 'pleading_level' => $pleading_level, 'user_ids_top_string' => $user_ids_top_string, 'user_ids_bottom_string' => $user_ids_bottom_string]);    
                } else {
                    // return view('pleadings.index',['case_id' => $case_id]);
                    return redirect()->route('cases.index');

                }

            } else {
                return redirect()->route('cases.pleadings',['case_id' => $request->case_id])->with('error', 'Something went wrong!');
            }
        } else {
            return redirect()->route('cases.pleadings',['case_id' => $request->case_id])->with('error', 'Complaint Package does not exist.');
        }
    }

}