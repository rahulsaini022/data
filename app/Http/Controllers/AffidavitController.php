<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\User;
use App\Attorney;
use App\Download;
use App\Setting;
use App\State;
use App\County;
use App\Court;
use App\Division;
use App\Judge;
use App\Magistrate;
use Redirect;
use Auth;
use File;
use Carbon\Carbon;

class AffidavitController extends Controller

{

    public function showAffidavitOfBasicInformationSheetForm(Request $request){

        $postData=$request->all();
        $selected_state_info=State::find($postData['state_id']);
        $ohMinimumWageData=DB::select(DB::raw("select getOHMinimumWage2018(0) AS tmpResult"));
        $OH_Minimum_Wage = $ohMinimumWageData[0]->tmpResult;
        $postData['OH_Minimum_Wage']=$OH_Minimum_Wage;

        if(isset($postData['prefill_selected_affidavit']) && $postData['prefill_selected_affidavit'] !=''){
            $affidavit_sheet_submissions_data = DB::table('affidavit_sheet_submissions')
                                ->where('id', $postData['prefill_selected_affidavit'])
                                ->get()->first();

            $prefill_data = DB::table('affidavit_attorney_submissions')
                        ->where([
                          ['id', '=', $affidavit_sheet_submissions_data->affidavit_attorney_submissions_id],
                        ])
                        ->get()->pluck('form_text');
            if(isset($prefill_data[0])){
                $postData=unserialize($prefill_data[0]);
                $postData['OH_Minimum_Wage']=$OH_Minimum_Wage;
                $postData['state_id']=$selected_state_info->id;
                
                $postData['update_id']=$affidavit_sheet_submissions_data->id;
                $postData['update_id_serialize']=$affidavit_sheet_submissions_data->affidavit_attorney_submissions_id;

                return view('fdd_tools.fdd_quick_affidavit_of_basic_information_sheet',['chk_prefill'=>$request->chk_prefill, 'postData'=>$postData, 'selected_state_info' => $selected_state_info ]);

            }
        }

        if((isset($request->submit) && $request->submit=='Calculate') || (isset($request->submit_print) && $request->submit_print=='Print') || (isset($request->save_download_sheet) && $request->save_download_sheet=='Save Data') || (isset($request->open_cs_sheet) && $request->open_cs_sheet=='Open FDD Quick Child Support Worksheet') ||  (isset($request->download_sheet) && $request->download_sheet=='Download Affidavit') )
        {
            $postData = $request->all();
            $postData['OH_Minimum_Wage']=$OH_Minimum_Wage;

            // to calculate Average yearly overtime, commissions, and/or bonuses over last three years
            $tp_ave_OT_comms_bonuses=0.00;
            if(isset($postData['tp_yearly_OT_comms_bonuses_3ya']) && $postData['tp_yearly_OT_comms_bonuses_3ya'] !=''){
                $tp_ave_OT_comms_bonuses +=$postData['tp_yearly_OT_comms_bonuses_3ya'];
            }
            if(isset($postData['tp_yearly_OT_comms_bonuses_2ya']) && $postData['tp_yearly_OT_comms_bonuses_2ya'] !=''){
                $tp_ave_OT_comms_bonuses +=$postData['tp_yearly_OT_comms_bonuses_2ya'];
            }
            if(isset($postData['tp_yearly_OT_comms_bonuses_1ya']) && $postData['tp_yearly_OT_comms_bonuses_1ya'] !=''){
                $tp_ave_OT_comms_bonuses +=$postData['tp_yearly_OT_comms_bonuses_1ya'];
            }
            $bp_ave_OT_comms_bonuses=0.00;
            if(isset($postData['bp_yearly_OT_comms_bonuses_3ya']) && $postData['bp_yearly_OT_comms_bonuses_3ya'] !=''){
                $bp_ave_OT_comms_bonuses +=$postData['bp_yearly_OT_comms_bonuses_3ya'];
            }
            if(isset($postData['bp_yearly_OT_comms_bonuses_2ya']) && $postData['bp_yearly_OT_comms_bonuses_2ya'] !=''){
                $bp_ave_OT_comms_bonuses +=$postData['bp_yearly_OT_comms_bonuses_2ya'];
            }
            if(isset($postData['bp_yearly_OT_comms_bonuses_1ya']) && $postData['bp_yearly_OT_comms_bonuses_1ya'] !=''){
                $bp_ave_OT_comms_bonuses +=$postData['bp_yearly_OT_comms_bonuses_1ya'];
            }
            $postData['tp_ave_OT_comms_bonuses']=$tp_ave_OT_comms_bonuses/3;
            $postData['bp_ave_OT_comms_bonuses']=$bp_ave_OT_comms_bonuses/3;

            // to calculate section (II. INCOME) TOTAL YEARLY INCOME 
            $tp_total_yearly_inc=0.00;
            $bp_total_yearly_inc=0.00;

            if(isset($postData['tp_base_yearly_income_current']) && $postData['tp_base_yearly_income_current'] !=''){
                $tp_total_yearly_inc +=$postData['tp_base_yearly_income_current'];
            }
            if(isset($postData['bp_base_yearly_income_current']) && $postData['bp_base_yearly_income_current'] !=''){
                $bp_total_yearly_inc +=$postData['bp_base_yearly_income_current'];
            }

            $tp_total_yearly_inc +=$postData['tp_ave_OT_comms_bonuses'];
            $bp_total_yearly_inc +=$postData['bp_ave_OT_comms_bonuses'];

            if(isset($postData['tp_unemp_comp']) && $postData['tp_unemp_comp'] !=''){
                $tp_total_yearly_inc +=$postData['tp_unemp_comp'];
            }
            if(isset($postData['bp_unemp_comp']) && $postData['bp_unemp_comp'] !=''){
                $bp_total_yearly_inc +=$postData['bp_unemp_comp'];
            }

            if(isset($postData['tp_workers_comp']) && $postData['tp_workers_comp'] !=''){
                $tp_total_yearly_inc +=$postData['tp_workers_comp'];
            }
            if(isset($postData['bp_workers_comp']) && $postData['bp_workers_comp'] !=''){
                $bp_total_yearly_inc +=$postData['bp_workers_comp'];
            }

            if(isset($postData['tp_ss_disability']) && $postData['tp_ss_disability'] !=''){
                $tp_total_yearly_inc +=$postData['tp_ss_disability'];
            }
            if(isset($postData['bp_ss_disability']) && $postData['bp_ss_disability'] !=''){
                $bp_total_yearly_inc +=$postData['bp_ss_disability'];
            }

            if(isset($postData['tp_other_disability']) && $postData['tp_other_disability'] !=''){
                $tp_total_yearly_inc +=$postData['tp_other_disability'];
            }
            if(isset($postData['bp_other_disability']) && $postData['bp_other_disability'] !=''){
                $bp_total_yearly_inc +=$postData['bp_other_disability'];
            }

            if(isset($postData['tp_retirement_ss']) && $postData['tp_retirement_ss'] !=''){
                $tp_total_yearly_inc +=$postData['tp_retirement_ss'];
            }
            if(isset($postData['bp_retirement_ss']) && $postData['bp_retirement_ss'] !=''){
                $bp_total_yearly_inc +=$postData['bp_retirement_ss'];
            }

            if(isset($postData['tp_retirement_other']) && $postData['tp_retirement_other'] !=''){
                $tp_total_yearly_inc +=$postData['tp_retirement_other'];
            }
            if(isset($postData['bp_retirement_other']) && $postData['bp_retirement_other'] !=''){
                $bp_total_yearly_inc +=$postData['bp_retirement_other'];
            }

            if(isset($postData['tp_spousal_support_recvd']) && $postData['tp_spousal_support_recvd'] !=''){
                $tp_total_yearly_inc +=$postData['tp_spousal_support_recvd'];
            }
            if(isset($postData['bp_spousal_support_recvd']) && $postData['bp_spousal_support_recvd'] !=''){
                $bp_total_yearly_inc +=$postData['bp_spousal_support_recvd'];
            }

            if(isset($postData['tp_int_and_div']) && $postData['tp_int_and_div'] !=''){
                $tp_total_yearly_inc +=$postData['tp_int_and_div'];
            }
            if(isset($postData['bp_int_and_div']) && $postData['bp_int_and_div'] !=''){
                $bp_total_yearly_inc +=$postData['bp_int_and_div'];
            }

            if(isset($postData['tp_other_inc']) && $postData['tp_other_inc'] !=''){
                $tp_total_yearly_inc +=$postData['tp_other_inc'];
            }
            if(isset($postData['bp_other_inc']) && $postData['bp_other_inc'] !=''){
                $bp_total_yearly_inc +=$postData['bp_other_inc'];
            }
            $postData['tp_total_yearly_inc']=$tp_total_yearly_inc;
            $postData['bp_total_yearly_inc']=$bp_total_yearly_inc;

            // to calculate section (IV. EXPENSES) Part A. Monthly Housing Expenses TOTAL MONTHLY
            $total_monthly_housing=0.00;
            if(isset($postData['monthly_housing_rent_first_mortgage_inc_tax_ins']) && $postData['monthly_housing_rent_first_mortgage_inc_tax_ins'] !=''){
                $total_monthly_housing +=$postData['monthly_housing_rent_first_mortgage_inc_tax_ins'];
            }
            if(isset($postData['monthly_housing_second_mort_heloc']) && $postData['monthly_housing_second_mort_heloc'] !=''){
                $total_monthly_housing +=$postData['monthly_housing_second_mort_heloc'];
            }
            if(isset($postData['monthly_housing_re_taxes']) && $postData['monthly_housing_re_taxes'] !=''){
                $total_monthly_housing +=$postData['monthly_housing_re_taxes'];
            }
            if(isset($postData['monthly_housing_renter_homeowner_insurance']) && $postData['monthly_housing_renter_homeowner_insurance'] !=''){
                $total_monthly_housing +=$postData['monthly_housing_renter_homeowner_insurance'];
            }
            if(isset($postData['monthly_housing_hoa_fee']) && $postData['monthly_housing_hoa_fee'] !=''){
                $total_monthly_housing +=$postData['monthly_housing_hoa_fee'];
            }
            if(isset($postData['monthly_housing_electric']) && $postData['monthly_housing_electric'] !=''){
                $total_monthly_housing +=$postData['monthly_housing_electric'];
            }
            if(isset($postData['monthly_housing_gas_fueloil_propane']) && $postData['monthly_housing_gas_fueloil_propane'] !=''){
                $total_monthly_housing +=$postData['monthly_housing_gas_fueloil_propane'];
            }
            if(isset($postData['monthly_housing_water_sewer']) && $postData['monthly_housing_water_sewer'] !=''){
                $total_monthly_housing +=$postData['monthly_housing_water_sewer'];
            }
            if(isset($postData['monthly_housing_telephone_cellphone']) && $postData['monthly_housing_telephone_cellphone'] !=''){
                $total_monthly_housing +=$postData['monthly_housing_telephone_cellphone'];
            }
            if(isset($postData['monthly_housing_trash']) && $postData['monthly_housing_trash'] !=''){
                $total_monthly_housing +=$postData['monthly_housing_trash'];
            }
            if(isset($postData['monthly_housing_cable_satellite_tv']) && $postData['monthly_housing_cable_satellite_tv'] !=''){
                $total_monthly_housing +=$postData['monthly_housing_cable_satellite_tv'];
            }
            if(isset($postData['monthly_housing_internet']) && $postData['monthly_housing_internet'] !=''){
                $total_monthly_housing +=$postData['monthly_housing_internet'];
            }
            if(isset($postData['monthly_housing_cleaning']) && $postData['monthly_housing_cleaning'] !=''){
                $total_monthly_housing +=$postData['monthly_housing_cleaning'];
            }
            if(isset($postData['monthly_housing_lawn_snow']) && $postData['monthly_housing_lawn_snow'] !=''){
                $total_monthly_housing +=$postData['monthly_housing_lawn_snow'];
            }
            if(isset($postData['monthly_housing_other1']) && $postData['monthly_housing_other1'] !=''){
                $total_monthly_housing +=$postData['monthly_housing_other1'];
            }
            if(isset($postData['monthly_housing_other2']) && $postData['monthly_housing_other2'] !=''){
                $total_monthly_housing +=$postData['monthly_housing_other2'];
            }
            $postData['total_monthly_housing']=$total_monthly_housing;

            // to calculate section (IV. EXPENSES) Part B. Other Monthly Living Expenses TOTAL MONTHLY
            $total_monthly_living=0.00;
            if(isset($postData['monthly_living_groceries']) && $postData['monthly_living_groceries'] !=''){
                $total_monthly_living +=$postData['monthly_living_groceries'];
            }
            if(isset($postData['monthly_living_restaurant']) && $postData['monthly_living_restaurant'] !=''){
                $total_monthly_living +=$postData['monthly_living_restaurant'];
            }
            if(isset($postData['monthly_living_vehicle_loan_lease']) && $postData['monthly_living_vehicle_loan_lease'] !=''){
                $total_monthly_living +=$postData['monthly_living_vehicle_loan_lease'];
            }
            if(isset($postData['monthly_living_vehicle_maintenance']) && $postData['monthly_living_vehicle_maintenance'] !=''){
                $total_monthly_living +=$postData['monthly_living_vehicle_maintenance'];
            }
            if(isset($postData['monthly_living_vehicle_gasoline']) && $postData['monthly_living_vehicle_gasoline'] !=''){
                $total_monthly_living +=$postData['monthly_living_vehicle_gasoline'];
            }
            if(isset($postData['monthly_living_vehicle_parking_pub_transportation']) && $postData['monthly_living_vehicle_parking_pub_transportation'] !=''){
                $total_monthly_living +=$postData['monthly_living_vehicle_parking_pub_transportation'];
            }
            if(isset($postData['monthly_living_clothes']) && $postData['monthly_living_clothes'] !=''){
                $total_monthly_living +=$postData['monthly_living_clothes'];
            }
            if(isset($postData['monthly_living_dry_cleaning_laundry']) && $postData['monthly_living_dry_cleaning_laundry'] !=''){
                $total_monthly_living +=$postData['monthly_living_dry_cleaning_laundry'];
            }
            if(isset($postData['monthly_living_hair_nail']) && $postData['monthly_living_hair_nail'] !=''){
                $total_monthly_living +=$postData['monthly_living_hair_nail'];
            }
            if(isset($postData['monthly_living_grooming_other']) && $postData['monthly_living_grooming_other'] !=''){
                $total_monthly_living +=$postData['monthly_living_grooming_other'];
            }
            if(isset($postData['monthly_living_other']) && $postData['monthly_living_other'] !=''){
                $total_monthly_living +=$postData['monthly_living_other'];
            }
            $postData['total_monthly_living']=$total_monthly_living;
            
            // to calculate section (IV. EXPENSES) Part C. Monthly Minor Child-Related Expenses TOTAL MONTHLY
            $total_monthly_minor=0.00;
            if(isset($postData['monthly_minor_work_ed_child_care']) && $postData['monthly_minor_work_ed_child_care'] !=''){
                $total_monthly_minor +=$postData['monthly_minor_work_ed_child_care'];
            }
            if(isset($postData['monthly_minor_other_child_care']) && $postData['monthly_minor_other_child_care'] !=''){
                $total_monthly_minor +=$postData['monthly_minor_other_child_care'];
            }
            if(isset($postData['monthly_minor_extra_travel_cost']) && $postData['monthly_minor_extra_travel_cost'] !=''){
                $total_monthly_minor +=$postData['monthly_minor_extra_travel_cost'];
            }
            if(isset($postData['monthly_minor_school_tuition']) && $postData['monthly_minor_school_tuition'] !=''){
                $total_monthly_minor +=$postData['monthly_minor_school_tuition'];
            }
            if(isset($postData['monthly_minor_school_lunches']) && $postData['monthly_minor_school_lunches'] !=''){
                $total_monthly_minor +=$postData['monthly_minor_school_lunches'];
            }
            if(isset($postData['monthly_minor_school_supplies']) && $postData['monthly_minor_school_supplies'] !=''){
                $total_monthly_minor +=$postData['monthly_minor_school_supplies'];
            }
            if(isset($postData['monthly_minor_extracurriculars']) && $postData['monthly_minor_extracurriculars'] !=''){
                $total_monthly_minor +=$postData['monthly_minor_extracurriculars'];
            }
            if(isset($postData['monthly_minor_clothing']) && $postData['monthly_minor_clothing'] !=''){
                $total_monthly_minor +=$postData['monthly_minor_clothing'];
            }
            if(isset($postData['monthly_minor_allowance']) && $postData['monthly_minor_allowance'] !=''){
                $total_monthly_minor +=$postData['monthly_minor_allowance'];
            }
            if(isset($postData['monthly_minor_spec_extra_needs']) && $postData['monthly_minor_spec_extra_needs'] !=''){
                $total_monthly_minor +=$postData['monthly_minor_spec_extra_needs'];
            }
            if(isset($postData['monthly_minor_other']) && $postData['monthly_minor_other'] !=''){
                $total_monthly_minor +=$postData['monthly_minor_other'];
            }
            $postData['total_monthly_minor']=$total_monthly_minor;
            
            // to calculate section (IV. EXPENSES) Part D. Monthly Insurance Premiums TOTAL MONTHLY
            $total_monthly_ins=0.00;
            if(isset($postData['monthly_ins_life']) && $postData['monthly_ins_life'] !=''){
                $total_monthly_ins +=$postData['monthly_ins_life'];
            }
            if(isset($postData['monthly_ins_auto']) && $postData['monthly_ins_auto'] !=''){
                $total_monthly_ins +=$postData['monthly_ins_auto'];
            }
            if(isset($postData['monthly_ins_health']) && $postData['monthly_ins_health'] !=''){
                $total_monthly_ins +=$postData['monthly_ins_health'];
            }
            if(isset($postData['monthly_ins_disability']) && $postData['monthly_ins_disability'] !=''){
                $total_monthly_ins +=$postData['monthly_ins_disability'];
            }
            if(isset($postData['monthly_ins_other']) && $postData['monthly_ins_other'] !=''){
                $total_monthly_ins +=$postData['monthly_ins_other'];
            }
            $postData['total_monthly_ins']=$total_monthly_ins;

            // to calculate section (IV. EXPENSES) Part E. Monthly Work and Education Expenses For Self TOTAL MONTHLY
            $total_monthly_self=0.00;
            if(isset($postData['monthly_self_mandatory_work_expenses']) && $postData['monthly_self_mandatory_work_expenses'] !=''){
                $total_monthly_self +=$postData['monthly_self_mandatory_work_expenses'];
            }
            if(isset($postData['monthly_self_addtional_inc_taxes_paid']) && $postData['monthly_self_addtional_inc_taxes_paid'] !=''){
                $total_monthly_self +=$postData['monthly_self_addtional_inc_taxes_paid'];
            }
            if(isset($postData['monthly_self_tuition']) && $postData['monthly_self_tuition'] !=''){
                $total_monthly_self +=$postData['monthly_self_tuition'];
            }
            if(isset($postData['monthly_self_books_fees_other']) && $postData['monthly_self_books_fees_other'] !=''){
                $total_monthly_self +=$postData['monthly_self_books_fees_other'];
            }
            if(isset($postData['monthly_self_college_loan']) && $postData['monthly_self_college_loan'] !=''){
                $total_monthly_self +=$postData['monthly_self_college_loan'];
            }
            if(isset($postData['monthly_self_other1']) && $postData['monthly_self_other1'] !=''){
                $total_monthly_self +=$postData['monthly_self_other1'];
            }
            if(isset($postData['monthly_self_other2']) && $postData['monthly_self_other2'] !=''){
                $total_monthly_self +=$postData['monthly_self_other2'];
            }
            $postData['total_monthly_self']=$total_monthly_self;
            
            // to calculate section (IV. EXPENSES) Part F. Monthly Health Care Expenses TOTAL MONTHLY
            $total_monthly_health=0.00;
            if(isset($postData['monthly_health_physicians']) && $postData['monthly_health_physicians'] !=''){
                $total_monthly_health +=$postData['monthly_health_physicians'];
            }
            if(isset($postData['monthly_health_dentists_orthodontists']) && $postData['monthly_health_dentists_orthodontists'] !=''){
                $total_monthly_health +=$postData['monthly_health_dentists_orthodontists'];
            }
            if(isset($postData['monthly_health_optometrists_opticians']) && $postData['monthly_health_optometrists_opticians'] !=''){
                $total_monthly_health +=$postData['monthly_health_optometrists_opticians'];
            }
            if(isset($postData['monthly_health_prescriptions']) && $postData['monthly_health_prescriptions'] !=''){
                $total_monthly_health +=$postData['monthly_health_prescriptions'];
            }
            if(isset($postData['monthly_health_other']) && $postData['monthly_health_other'] !=''){
                $total_monthly_health +=$postData['monthly_health_other'];
            }
            $postData['total_monthly_health']=$total_monthly_health;

            // to calculate section (IV. EXPENSES) Part G. Miscellaneous Monthly Expenses TOTAL MONTHLY
            $total_monthly_misc=0.00;
            if(isset($postData['monthly_misc_extra_ob_minor_children_NoM']) && $postData['monthly_misc_extra_ob_minor_children_NoM'] !=''){
                $total_monthly_misc +=$postData['monthly_misc_extra_ob_minor_children_NoM'];
            }
            if(isset($postData['monthly_misc_child_support_paid_children_NoM']) && $postData['monthly_misc_child_support_paid_children_NoM'] !=''){
                $total_monthly_misc +=$postData['monthly_misc_child_support_paid_children_NoM'];
            }
            if(isset($postData['monthly_misc_exp_adult_children_NoM']) && $postData['monthly_misc_exp_adult_children_NoM'] !=''){
                $total_monthly_misc +=$postData['monthly_misc_exp_adult_children_NoM'];
            }
            if(isset($postData['monthly_misc_spousal_support_paid']) && $postData['monthly_misc_spousal_support_paid'] !=''){
                $total_monthly_misc +=$postData['monthly_misc_spousal_support_paid'];
            }
            if(isset($postData['monthly_misc_subscriptions_books']) && $postData['monthly_misc_subscriptions_books'] !=''){
                $total_monthly_misc +=$postData['monthly_misc_subscriptions_books'];
            }
            if(isset($postData['monthly_misc_charity']) && $postData['monthly_misc_charity'] !=''){
                $total_monthly_misc +=$postData['monthly_misc_charity'];
            }
            if(isset($postData['monthly_misc_assoc_club_membership']) && $postData['monthly_misc_assoc_club_membership'] !=''){
                $total_monthly_misc +=$postData['monthly_misc_assoc_club_membership'];
            }
            if(isset($postData['monthly_misc_travel_vacations']) && $postData['monthly_misc_travel_vacations'] !=''){
                $total_monthly_misc +=$postData['monthly_misc_travel_vacations'];
            }
            if(isset($postData['monthly_misc_pets']) && $postData['monthly_misc_pets'] !=''){
                $total_monthly_misc +=$postData['monthly_misc_pets'];
            }
            if(isset($postData['monthly_misc_gifts']) && $postData['monthly_misc_gifts'] !=''){
                $total_monthly_misc +=$postData['monthly_misc_gifts'];
            }
            if(isset($postData['monthly_misc_atty_fees']) && $postData['monthly_misc_atty_fees'] !=''){
                $total_monthly_misc +=$postData['monthly_misc_atty_fees'];
            }
            if(isset($postData['monthly_misc_other1']) && $postData['monthly_misc_other1'] !=''){
                $total_monthly_misc +=$postData['monthly_misc_other1'];
            }
            if(isset($postData['monthly_misc_other2']) && $postData['monthly_misc_other2'] !=''){
                $total_monthly_misc +=$postData['monthly_misc_other2'];
            }

            $postData['total_monthly_misc']=$total_monthly_misc;
            
            // to calculate section (IV. EXPENSES) Part H. Monthly Installment Payments Including Bankruptcy Payments TOTAL MONTHLY
            $total_monthly_installment_payments=0.00;
            for ($i=1; $i <= 13 ; $i++) { 
                if(isset($postData['monthly_installment_payment'.$i.'']) && $postData['monthly_installment_payment'.$i.''] !=''){
                    $total_monthly_installment_payments +=$postData['monthly_installment_payment'.$i.''];
                }

                if(isset($postData['monthly_installment_purpose'.$i.'']) && $postData['monthly_installment_purpose'.$i.''] =='Other'){
                    $postData['monthly_installment_purpose'.$i.'']=$postData['monthly_installment_purpose'.$i.'_text'];
                }
            }
            $postData['total_monthly_installment_payments']=$total_monthly_installment_payments;
            

            $postData['grand_total_monthly_expenses']=$postData['total_monthly_installment_payments']+$postData['total_monthly_misc']+$postData['total_monthly_health']+$postData['total_monthly_self']+$postData['total_monthly_ins']+$postData['total_monthly_minor']+$postData['total_monthly_living']+$postData['total_monthly_housing'];
            if(isset($postData['notary_name_radio']) && $postData['notary_name_radio'] =='other'){
            } else {
                $postData['notary_name']= Auth::user()->attorney->document_sign_name;
            }
            
            if((isset($request->submit) && $request->submit=='Calculate'))
            {
                return view('fdd_tools.fdd_quick_affidavit_of_basic_information_sheet',['chk_prefill'=>$request->chk_prefill, 'postData'=>$postData, 'selected_state_info' => $selected_state_info ]);
            }
            
            if((isset($request->save_download_sheet) && $request->save_download_sheet=='Save Data') || (isset($request->open_cs_sheet) && $request->open_cs_sheet=='Open FDD Quick Child Support Worksheet') || (isset($request->download_sheet) && $request->download_sheet=='Download Affidavit'))
            {
                if(isset($postData['marriage_date']) && $postData['marriage_date'] !=''){
                    $postData['marriage_date']=date("Y-m-d", strtotime($postData['marriage_date']));
                }
                if(isset($postData['separation_date']) && $postData['separation_date'] !=''){
                    $postData['separation_date']=date("Y-m-d", strtotime($postData['separation_date']));
                }
                if(isset($postData['tp_birthdate']) && $postData['tp_birthdate'] !=''){
                    $postData['tp_birthdate']=date("Y-m-d", strtotime($postData['tp_birthdate']));
                }
                if(isset($postData['bp_birthdate']) && $postData['bp_birthdate'] !=''){
                    $postData['bp_birthdate']=date("Y-m-d", strtotime($postData['bp_birthdate']));
                }
                if(isset($postData['tp_date_employed']) && $postData['tp_date_employed'] !=''){
                    $postData['tp_date_employed']=date("Y-m-d", strtotime($postData['tp_date_employed']));
                }
                if(isset($postData['bp_date_employed']) && $postData['bp_date_employed'] !=''){
                    $postData['bp_date_employed']=date("Y-m-d", strtotime($postData['bp_date_employed']));
                }
                if(isset($postData['tp_datepick']) && $postData['tp_datepick'] !=''){
                    $postData['tp_datepick']=date("Y-m-d", strtotime($postData['tp_datepick']));
                }
                if(isset($postData['bp_datepick']) && $postData['bp_datepick'] !=''){
                    $postData['bp_datepick']=date("Y-m-d", strtotime($postData['bp_datepick']));
                }

                for ($i=1; $i <= 8 ; $i++) { 
                    if(isset($postData['minordependent_birth_date'.$i.'']) && $postData['minordependent_birth_date'.$i.''] !=''){
                        $postData['minordependent_birth_date'.$i.'']=date("Y-m-d", strtotime($postData['minordependent_birth_date'.$i.'']));
                    }
                    if(isset($postData['minordependent_livingwith'.$i.'']) && $postData['minordependent_livingwith'.$i.''] !=''){
                    } else {
                        $postData['minordependent_livingwith'.$i.'']=NULL;
                    }
                }

                $array=array(
                    "user_id"=>Auth::user()->id,
                    "form_text"=>serialize($postData),
                    'form_state'=>$request->state_id,
                    "active"=>'1',
                    'updated_at'=>now(),
                );
                
                $insert_se_array=$array;
                $insert_se_array['created_at']=now();

                if(isset($postData['update_id_serialize']) && $postData['update_id_serialize'] !=''){
                    DB::table('affidavit_attorney_submissions')->where('id', $postData['update_id_serialize'])->update($array);

                } else {
                    $postData['update_id_serialize']=DB::table('affidavit_attorney_submissions')->insertGetId($insert_se_array);
                }
                
                $county_name=NULL;
                $court_name=NULL;
                $division_name=NULL;
                $judge_name=NULL;
                $magistrate_name=NULL;
                if(isset($postData['county_id']) && $postData['county_id'] !=''){
                    $county_name= County::find($postData['county_id'])->county_name;
                }
                if(isset($postData['court_id']) && $postData['court_id'] !=''){
                    $court_name= Court::find($postData['court_id'])->name;
                }
                if(isset($postData['division_id']) && $postData['division_id'] !=''){
                    $division_name= Division::find($postData['division_id'])->name;
                }
                if(isset($postData['judge_id']) && $postData['judge_id'] !=''){
                    $judge_name= Judge::find($postData['judge_id'])->adjudicator;
                }
                if(isset($postData['magistrate_id']) && $postData['magistrate_id'] !=''){
                    $magistrate_name= Magistrate::find($postData['magistrate_id'])->mag_name;
                }
                if(isset($postData['aff_party']) && $postData['aff_party'] =='top'){
                    $aff_party_name= $postData['topparty_name'];
                } else if(isset($postData['aff_party']) && $postData['aff_party'] =='bottom'){
                    $aff_party_name= $postData['bottomparty_name'];
                } else {
                    $aff_party_name=NULL;
                }

                $tp_payroll_state=NULL;
                $bp_payroll_state=NULL;
                if(isset($postData['tp_payroll_state_id']) && $postData['tp_payroll_state_id'] !=''){
                    $tp_payroll_state= State::find($postData['tp_payroll_state_id'])->state;
                }
                if(isset($postData['bp_payroll_state_id']) && $postData['bp_payroll_state_id'] !=''){
                    $bp_payroll_state= State::find($postData['bp_payroll_state_id'])->state;
                }

                $array2=array(
                    "user_id"=>Auth::user()->id,
                    "state_id"=>$postData['state_id'],
                    "state"=>$selected_state_info->state,
                    'county_id'=>$postData['county_id'],
                    'county'=>$county_name,
                    'court_id'=>$postData['court_id'],
                    'court'=>$court_name,
                    'division_id'=>$postData['division_id'],
                    'division'=>$division_name,
                    'judge_id'=>$postData['judge_id'],
                    'judge'=>$judge_name,
                    'magistrate_id'=>$postData['magistrate_id'],
                    'magistrate'=>$magistrate_name,
                    'case_number'=>$postData['case_number'],
                    'topparty_role'=>$postData['topparty_role'],
                    'topparty_name'=>$postData['topparty_name'],
                    'bottomparty_role'=>$postData['bottomparty_role'],
                    'bottomparty_name'=>$postData['bottomparty_name'],
                    'aff_party'=>$postData['aff_party'],
                    'aff_party_name'=>$aff_party_name,
                    'marriage_date'=>$postData['marriage_date'],
                    'separation_date'=>$postData['separation_date'],
                    'tp_birthdate'=>$postData['tp_birthdate'],
                    'bp_birthdate'=>$postData['bp_birthdate'],
                    'tp_ssn'=>$postData['tp_ssn'],
                    'bp_ssn'=>$postData['bp_ssn'],
                    'tp_phone'=>$postData['tp_phone'],
                    'bp_phone'=>$postData['bp_phone'],
                    'tp_health'=>$postData['tp_health'],
                    'bp_health'=>$postData['bp_health'],
                    'tp_health_explain'=>$postData['tp_health_explain'],
                    'bp_health_explain'=>$postData['bp_health_explain'],
                    'tp_high_ed'=>$postData['tp_high_ed'],
                    'bp_high_ed'=>$postData['bp_high_ed'],
                    'tp_other_tech_certs'=>$postData['tp_other_tech_certs'],
                    'bp_other_tech_certs'=>$postData['bp_other_tech_certs'],
                    'tp_active_mil'=>$postData['tp_active_mil'],
                    'bp_active_mil'=>$postData['bp_active_mil'],
                    'tp_employed'=>$postData['tp_employed'],
                    'tp_employer_name'=>$postData['tp_employer_name'],
                    'bp_employed'=>$postData['bp_employed'],
                    'bp_employer_name'=>$postData['bp_employer_name'],
                    'tp_date_employed'=>$postData['tp_date_employed'],
                    'bp_date_employed'=>$postData['bp_date_employed'],
                    'tp_payroll_street_ad'=>$postData['tp_payroll_street_ad'],
                    'bp_payroll_street_ad'=>$postData['bp_payroll_street_ad'],
                    'tp_payroll_city'=>$postData['tp_payroll_city'],
                    'bp_payroll_city'=>$postData['bp_payroll_city'],
                    'tp_payroll_state_id'=>$postData['tp_payroll_state_id'],
                    'tp_payroll_state'=>$tp_payroll_state,
                    'bp_payroll_state_id'=>$postData['bp_payroll_state_id'],
                    'bp_payroll_state'=>$bp_payroll_state,
                    'tp_payroll_zip'=>$postData['tp_payroll_zip'],
                    'bp_payroll_zip'=>$postData['bp_payroll_zip'],
                    'tp_yearly_pay_periods'=>$postData['tp_yearly_pay_periods'],
                    'bp_yearly_pay_periods'=>$postData['bp_yearly_pay_periods'],
                    'tp_base_yearly_income_3ya'=>$postData['tp_base_yearly_income_3ya'],
                    'tp_base_yearly_income_2ya'=>$postData['tp_base_yearly_income_2ya'],
                    'tp_base_yearly_income_1ya'=>$postData['tp_base_yearly_income_1ya'],
                    'bp_base_yearly_income_3ya'=>$postData['bp_base_yearly_income_3ya'],
                    'bp_base_yearly_income_2ya'=>$postData['bp_base_yearly_income_2ya'],
                    'bp_base_yearly_income_1ya'=>$postData['bp_base_yearly_income_1ya'],
                    'tp_yearly_OT_comms_bonuses_3ya'=>$postData['tp_yearly_OT_comms_bonuses_3ya'],
                    'tp_yearly_OT_comms_bonuses_2ya'=>$postData['tp_yearly_OT_comms_bonuses_2ya'],
                    'tp_yearly_OT_comms_bonuses_1ya'=>$postData['tp_yearly_OT_comms_bonuses_1ya'],
                    'bp_yearly_OT_comms_bonuses_3ya'=>$postData['bp_yearly_OT_comms_bonuses_3ya'],
                    'bp_yearly_OT_comms_bonuses_2ya'=>$postData['bp_yearly_OT_comms_bonuses_2ya'],
                    'bp_yearly_OT_comms_bonuses_1ya'=>$postData['bp_yearly_OT_comms_bonuses_1ya'],
                    'tp_inc_radio_dial'=>$postData['tp_inc_radio_dial'],
                    'tp_input_year'=>$postData['tp_input_year'],
                    'tp_dropdown'=>$postData['tp_dropdown'],
                    'tp_input_ytd'=>$postData['tp_input_ytd'],
                    'tp_datepick'=>$postData['tp_datepick'],
                    'bp_inc_radio_dial'=>$postData['bp_inc_radio_dial'],
                    'bp_input_year'=>$postData['bp_input_year'],
                    'bp_dropdown'=>$postData['bp_dropdown'],
                    'bp_input_ytd'=>$postData['bp_input_ytd'],
                    'bp_datepick'=>$postData['bp_datepick'],
                    'tp_base_yearly_income_current'=>$postData['tp_base_yearly_income_current'],
                    'bp_base_yearly_income_current'=>$postData['bp_base_yearly_income_current'],
                    'tp_ave_OT_comms_bonuses'=>$postData['tp_ave_OT_comms_bonuses'],
                    'bp_ave_OT_comms_bonuses'=>$postData['bp_ave_OT_comms_bonuses'],
                    'tp_unemp_comp'=>$postData['tp_unemp_comp'],
                    'bp_unemp_comp'=>$postData['bp_unemp_comp'],
                    'tp_workers_comp'=>$postData['tp_workers_comp'],
                    'bp_workers_comp'=>$postData['bp_workers_comp'],
                    'tp_ss_disability'=>$postData['tp_ss_disability'],
                    'bp_ss_disability'=>$postData['bp_ss_disability'],
                    'tp_other_disability_type'=>$postData['tp_other_disability_type'],
                    'tp_other_disability'=>$postData['tp_other_disability'],
                    'bp_other_disability_type'=>$postData['bp_other_disability_type'],
                    'bp_other_disability'=>$postData['bp_other_disability'],
                    'tp_retirement_ss'=>$postData['tp_retirement_ss'],
                    'bp_retirement_ss'=>$postData['bp_retirement_ss'],
                    'tp_retirement_other_type'=>$postData['tp_retirement_other_type'],
                    'tp_retirement_other'=>$postData['tp_retirement_other'],
                    'bp_retirement_other_type'=>$postData['bp_retirement_other_type'],
                    'bp_retirement_other'=>$postData['bp_retirement_other'],
                    'tp_spousal_support_recvd'=>$postData['tp_spousal_support_recvd'],
                    'bp_spousal_support_recvd'=>$postData['bp_spousal_support_recvd'],
                    'tp_int_div_source'=>$postData['tp_int_div_source'],
                    'tp_int_and_div'=>$postData['tp_int_and_div'],
                    'bp_int_div_source'=>$postData['bp_int_div_source'],
                    'bp_int_and_div'=>$postData['bp_int_and_div'],
                    'tp_other_inc_source'=>$postData['tp_other_inc_source'],
                    'tp_other_inc'=>$postData['tp_other_inc'],
                    'bp_other_inc_source'=>$postData['bp_other_inc_source'],
                    'bp_other_inc'=>$postData['bp_other_inc'],
                    'tp_total_yearly_inc'=>$postData['tp_total_yearly_inc'],
                    'bp_total_yearly_inc'=>$postData['bp_total_yearly_inc'],
                    'tp_ssi'=>$postData['tp_ssi'],
                    'bp_ssi'=>$postData['bp_ssi'],
                    'tp_child_support_received_NoM'=>$postData['tp_child_support_received_NoM'],
                    'bp_child_support_received_NoM'=>$postData['bp_child_support_received_NoM'],
                    'num_minordependent_children_this_marriage'=>$postData['num_minordependent_children_this_marriage'],
                    'minordependent_fullname1'=>$postData['minordependent_fullname1'],
                    'minordependent_birth_date1'=>$postData['minordependent_birth_date1'],
                    'minordependent_livingwith1'=>$postData['minordependent_livingwith1'],
                    'minordependent_livingwith_other1'=>$postData['minordependent_livingwith_other1'],
                    'minordependent_fullname2'=>$postData['minordependent_fullname2'],
                    'minordependent_birth_date2'=>$postData['minordependent_birth_date2'],
                    'minordependent_livingwith2'=>$postData['minordependent_livingwith2'],
                    'minordependent_livingwith_other2'=>$postData['minordependent_livingwith_other2'],
                    'minordependent_fullname3'=>$postData['minordependent_fullname3'],
                    'minordependent_birth_date3'=>$postData['minordependent_birth_date3'],
                    'minordependent_livingwith3'=>$postData['minordependent_livingwith3'],
                    'minordependent_livingwith_other3'=>$postData['minordependent_livingwith_other3'],
                    'minordependent_fullname4'=>$postData['minordependent_fullname4'],
                    'minordependent_birth_date4'=>$postData['minordependent_birth_date4'],
                    'minordependent_livingwith4'=>$postData['minordependent_livingwith4'],
                    'minordependent_livingwith_other4'=>$postData['minordependent_livingwith_other4'],
                    'minordependent_fullname5'=>$postData['minordependent_fullname5'],
                    'minordependent_birth_date5'=>$postData['minordependent_birth_date5'],
                    'minordependent_livingwith5'=>$postData['minordependent_livingwith5'],
                    'minordependent_livingwith_other5'=>$postData['minordependent_livingwith_other5'],
                    'minordependent_fullname6'=>$postData['minordependent_fullname6'],
                    'minordependent_birth_date6'=>$postData['minordependent_birth_date6'],
                    'minordependent_livingwith6'=>$postData['minordependent_livingwith6'],
                    'minordependent_livingwith_other6'=>$postData['minordependent_livingwith_other6'],
                    'minordependent_fullname7'=>$postData['minordependent_fullname7'],
                    'minordependent_birth_date7'=>$postData['minordependent_birth_date7'],
                    'minordependent_livingwith7'=>$postData['minordependent_livingwith7'],
                    'minordependent_livingwith_other7'=>$postData['minordependent_livingwith_other7'],
                    'minordependent_fullname8'=>$postData['minordependent_fullname8'],
                    'minordependent_birth_date8'=>$postData['minordependent_birth_date8'],
                    'minordependent_livingwith8'=>$postData['minordependent_livingwith8'],
                    'minordependent_livingwith_other8'=>$postData['minordependent_livingwith_other8'],
                    'tp_num_children_NoM'=>$postData['tp_num_children_NoM'],
                    'bp_num_children_NoM'=>$postData['bp_num_children_NoM'],
                    'aff_party_num_adults_in_household'=>$postData['aff_party_num_adults_in_household'],
                    'monthly_housing_rent_first_mortgage_inc_tax_ins'=>$postData['monthly_housing_rent_first_mortgage_inc_tax_ins'],
                    'monthly_housing_second_mort_heloc'=>$postData['monthly_housing_second_mort_heloc'],
                    'monthly_housing_re_taxes'=>$postData['monthly_housing_re_taxes'],
                    'monthly_housing_renter_homeowner_insurance'=>$postData['monthly_housing_renter_homeowner_insurance'],
                    'monthly_housing_hoa_fee'=>$postData['monthly_housing_hoa_fee'],
                    'monthly_housing_electric'=>$postData['monthly_housing_electric'],
                    'monthly_housing_gas_fueloil_propane'=>$postData['monthly_housing_gas_fueloil_propane'],
                    'monthly_housing_water_sewer'=>$postData['monthly_housing_water_sewer'],
                    'monthly_housing_telephone_cellphone'=>$postData['monthly_housing_telephone_cellphone'],
                    'monthly_housing_trash'=>$postData['monthly_housing_trash'],
                    'monthly_housing_cable_satellite_tv'=>$postData['monthly_housing_cable_satellite_tv'],
                    'monthly_housing_internet'=>$postData['monthly_housing_internet'],
                    'monthly_housing_cleaning'=>$postData['monthly_housing_cleaning'],
                    'monthly_housing_lawn_snow'=>$postData['monthly_housing_lawn_snow'],
                    'monthly_housing_other1_type'=>$postData['monthly_housing_other1_type'],
                    'monthly_housing_other1'=>$postData['monthly_housing_other1'],
                    'monthly_housing_other2_type'=>$postData['monthly_housing_other2_type'],
                    'monthly_housing_other2'=>$postData['monthly_housing_other2'],
                    'total_monthly_housing'=>$postData['total_monthly_housing'],
                    'monthly_living_groceries'=>$postData['monthly_living_groceries'],
                    'monthly_living_restaurant'=>$postData['monthly_living_restaurant'],
                    'monthly_living_vehicle_loan_lease'=>$postData['monthly_living_vehicle_loan_lease'],
                    'monthly_living_vehicle_maintenance'=>$postData['monthly_living_vehicle_maintenance'],
                    'monthly_living_vehicle_gasoline'=>$postData['monthly_living_vehicle_gasoline'],
                    'monthly_living_vehicle_parking_pub_transportation'=>$postData['monthly_living_vehicle_parking_pub_transportation'],
                    'monthly_living_clothes'=>$postData['monthly_living_clothes'],
                    'monthly_living_dry_cleaning_laundry'=>$postData['monthly_living_dry_cleaning_laundry'],
                    'monthly_living_hair_nail'=>$postData['monthly_living_hair_nail'],
                    'monthly_living_grooming_other_type'=>$postData['monthly_living_grooming_other_type'],
                    'monthly_living_grooming_other'=>$postData['monthly_living_grooming_other'],
                    'monthly_living_other_type'=>$postData['monthly_living_other_type'],
                    'monthly_living_other'=>$postData['monthly_living_other'],
                    'total_monthly_living'=>$postData['total_monthly_living'],
                    'monthly_minor_work_ed_child_care'=>$postData['monthly_minor_work_ed_child_care'],
                    'monthly_minor_other_child_care_type'=>$postData['monthly_minor_other_child_care_type'],
                    'monthly_minor_other_child_care'=>$postData['monthly_minor_other_child_care'],
                    'monthly_minor_extra_travel_cost'=>$postData['monthly_minor_extra_travel_cost'],
                    'monthly_minor_school_tuition'=>$postData['monthly_minor_school_tuition'],
                    'monthly_minor_school_lunches'=>$postData['monthly_minor_school_lunches'],
                    'monthly_minor_school_supplies'=>$postData['monthly_minor_school_supplies'],
                    'monthly_minor_extracurriculars'=>$postData['monthly_minor_extracurriculars'],
                    'monthly_minor_clothing'=>$postData['monthly_minor_clothing'],
                    'monthly_minor_allowance'=>$postData['monthly_minor_allowance'],
                    'monthly_minor_spec_extra_needs'=>$postData['monthly_minor_spec_extra_needs'],
                    'monthly_minor_other_type'=>$postData['monthly_minor_other_type'],
                    'monthly_minor_other'=>$postData['monthly_minor_other'],
                    'total_monthly_minor'=>$postData['total_monthly_minor'],
                    'monthly_ins_life'=>$postData['monthly_ins_life'],
                    'monthly_ins_auto'=>$postData['monthly_ins_auto'],
                    'monthly_ins_health'=>$postData['monthly_ins_health'],
                    'monthly_ins_disability'=>$postData['monthly_ins_disability'],
                    'monthly_ins_other_type'=>$postData['monthly_ins_other_type'],
                    'monthly_ins_other'=>$postData['monthly_ins_other'],
                    'total_monthly_ins'=>$postData['total_monthly_ins'],
                    'monthly_self_mandatory_work_expenses'=>$postData['monthly_self_mandatory_work_expenses'],
                    'monthly_self_addtional_inc_taxes_paid'=>$postData['monthly_self_addtional_inc_taxes_paid'],
                    'monthly_self_tuition'=>$postData['monthly_self_tuition'],
                    'monthly_self_books_fees_other'=>$postData['monthly_self_books_fees_other'],
                    'monthly_self_college_loan'=>$postData['monthly_self_college_loan'],
                    'monthly_self_other1_type'=>$postData['monthly_self_other1_type'],
                    'monthly_self_other1'=>$postData['monthly_self_other1'],
                    'monthly_self_other2_type'=>$postData['monthly_self_other2_type'],
                    'monthly_self_other2'=>$postData['monthly_self_other2'],
                    'total_monthly_self'=>$postData['total_monthly_self'],
                    'monthly_health_physicians'=>$postData['monthly_health_physicians'],
                    'monthly_health_dentists_orthodontists'=>$postData['monthly_health_dentists_orthodontists'],
                    'monthly_health_optometrists_opticians'=>$postData['monthly_health_optometrists_opticians'],
                    'monthly_health_prescriptions'=>$postData['monthly_health_prescriptions'],
                    'monthly_health_other_type'=>$postData['monthly_health_other_type'],
                    'monthly_health_other'=>$postData['monthly_health_other'],
                    'total_monthly_health'=>$postData['total_monthly_health'],
                    'monthly_misc_extra_ob_minor_children_NoM'=>$postData['monthly_misc_extra_ob_minor_children_NoM'],
                    'monthly_misc_child_support_paid_children_NoM'=>$postData['monthly_misc_child_support_paid_children_NoM'],
                    'monthly_misc_exp_adult_children_NoM'=>$postData['monthly_misc_exp_adult_children_NoM'],
                    'monthly_misc_spousal_support_paid'=>$postData['monthly_misc_spousal_support_paid'],
                    'monthly_misc_subscriptions_books'=>$postData['monthly_misc_subscriptions_books'],
                    'monthly_misc_charity'=>$postData['monthly_misc_charity'],
                    'monthly_misc_assoc_club_membership'=>$postData['monthly_misc_assoc_club_membership'],
                    'monthly_misc_travel_vacations'=>$postData['monthly_misc_travel_vacations'],
                    'monthly_misc_pets'=>$postData['monthly_misc_pets'],
                    'monthly_misc_gifts'=>$postData['monthly_misc_gifts'],
                    'monthly_misc_atty_fees'=>$postData['monthly_misc_atty_fees'],
                    'monthly_misc_other1_type'=>$postData['monthly_misc_other1_type'],
                    'monthly_misc_other1'=>$postData['monthly_misc_other1'],
                    'monthly_misc_other2_type'=>$postData['monthly_misc_other2_type'],
                    'monthly_misc_other2'=>$postData['monthly_misc_other2'],
                    'total_monthly_misc'=>$postData['total_monthly_misc'],
                    'monthly_installment_creditor1'=>$postData['monthly_installment_creditor1'],
                    'monthly_installment_purpose1'=>$postData['monthly_installment_purpose1'],
                    'monthly_installment_balance1'=>$postData['monthly_installment_balance1'],
                    'monthly_installment_payment1'=>$postData['monthly_installment_payment1'],
                    'monthly_installment_creditor2'=>$postData['monthly_installment_creditor2'],
                    'monthly_installment_purpose2'=>$postData['monthly_installment_purpose2'],
                    'monthly_installment_balance2'=>$postData['monthly_installment_balance2'],
                    'monthly_installment_payment2'=>$postData['monthly_installment_payment2'],
                    'monthly_installment_creditor3'=>$postData['monthly_installment_creditor3'],
                    'monthly_installment_purpose3'=>$postData['monthly_installment_purpose3'],
                    'monthly_installment_balance3'=>$postData['monthly_installment_balance3'],
                    'monthly_installment_payment3'=>$postData['monthly_installment_payment3'],
                    'monthly_installment_creditor4'=>$postData['monthly_installment_creditor4'],
                    'monthly_installment_purpose4'=>$postData['monthly_installment_purpose4'],
                    'monthly_installment_balance4'=>$postData['monthly_installment_balance4'],
                    'monthly_installment_payment4'=>$postData['monthly_installment_payment4'],
                    'monthly_installment_creditor5'=>$postData['monthly_installment_creditor5'],
                    'monthly_installment_purpose5'=>$postData['monthly_installment_purpose5'],
                    'monthly_installment_balance5'=>$postData['monthly_installment_balance5'],
                    'monthly_installment_payment5'=>$postData['monthly_installment_payment5'],
                    'monthly_installment_creditor6'=>$postData['monthly_installment_creditor6'],
                    'monthly_installment_purpose6'=>$postData['monthly_installment_purpose6'],
                    'monthly_installment_balance6'=>$postData['monthly_installment_balance6'],
                    'monthly_installment_payment6'=>$postData['monthly_installment_payment6'],
                    'monthly_installment_creditor7'=>$postData['monthly_installment_creditor7'],
                    'monthly_installment_purpose7'=>$postData['monthly_installment_purpose7'],
                    'monthly_installment_balance7'=>$postData['monthly_installment_balance7'],
                    'monthly_installment_payment7'=>$postData['monthly_installment_payment7'],
                    'monthly_installment_creditor8'=>$postData['monthly_installment_creditor8'],
                    'monthly_installment_purpose8'=>$postData['monthly_installment_purpose8'],
                    'monthly_installment_balance8'=>$postData['monthly_installment_balance8'],
                    'monthly_installment_payment8'=>$postData['monthly_installment_payment8'],
                    'monthly_installment_creditor9'=>$postData['monthly_installment_creditor9'],
                    'monthly_installment_purpose9'=>$postData['monthly_installment_purpose9'],
                    'monthly_installment_balance9'=>$postData['monthly_installment_balance9'],
                    'monthly_installment_payment9'=>$postData['monthly_installment_payment9'],
                    'monthly_installment_creditor10'=>$postData['monthly_installment_creditor10'],
                    'monthly_installment_purpose10'=>$postData['monthly_installment_purpose10'],
                    'monthly_installment_balance10'=>$postData['monthly_installment_balance10'],
                    'monthly_installment_payment10'=>$postData['monthly_installment_payment10'],
                    'monthly_installment_creditor11'=>$postData['monthly_installment_creditor11'],
                    'monthly_installment_purpose11'=>$postData['monthly_installment_purpose11'],
                    'monthly_installment_balance11'=>$postData['monthly_installment_balance11'],
                    'monthly_installment_payment11'=>$postData['monthly_installment_payment11'],
                    'monthly_installment_creditor12'=>$postData['monthly_installment_creditor12'],
                    'monthly_installment_purpose12'=>$postData['monthly_installment_purpose12'],
                    'monthly_installment_balance12'=>$postData['monthly_installment_balance12'],
                    'monthly_installment_payment12'=>$postData['monthly_installment_payment12'],
                    'monthly_installment_creditor13'=>$postData['monthly_installment_creditor13'],
                    'monthly_installment_purpose13'=>$postData['monthly_installment_purpose13'],
                    'monthly_installment_balance13'=>$postData['monthly_installment_balance13'],
                    'monthly_installment_payment13'=>$postData['monthly_installment_payment13'],
                    'total_monthly_installment_payments'=>$postData['total_monthly_installment_payments'],
                    'grand_total_monthly_expenses'=>$postData['grand_total_monthly_expenses'],
                    'notary_name'=>$postData['notary_name'],
                    'affidavit_attorney_submissions_id'=>$postData['update_id_serialize'],
                    "active"=>'1',
                    //"Oh_FAFFTrig"=>'1',
                    'updated_at'=>now(),
                );
                $insert_array=$array2;
                $insert_array['created_at']=now();

                if(isset($postData['update_id']) && $postData['update_id'] !=''){
                    DB::table('affidavit_sheet_submissions')->where('id', $postData['update_id'])->update($array2);
                    
                } else {
                    $postData['update_id']=DB::table('affidavit_sheet_submissions')->insertGetId($insert_array);
                }
                // $update_id=$postData['update_id'];
                // $update_id_serialize=$postData['update_id_serialize'];
                // $prefill_data = DB::table('affidavit_attorney_submissions')
                //                 ->where('id', $postData['update_id_serialize'])
                //                 ->get()->pluck('form_text');
                // $postData=unserialize($prefill_data[0]);
                // $postData['update_id']=$update_id;
                // $postData['update_id_serialize']=$update_id_serialize;
                // return view('fdd_tools.fdd_quick_affidavit_of_basic_information_sheet',['chk_prefill'=>$request->chk_prefill, 'postData'=>$postData, 'selected_state_info' => $selected_state_info ]);

                // open child worksheet if requested
                if(isset($request->open_cs_sheet) && $request->open_cs_sheet=='Open FDD Quick Child Support Worksheet')
                {
                    return redirect()->route('affidavit_sheet.open_cs_sheet', [$postData['update_id_serialize']]);
                }

              
             
            }
            if((isset($request->download_sheet) && $request->download_sheet=='Download Affidavit')){
                  // download functionality
                $admin_email=Setting::where('setting_key', 'admin_email')->pluck('setting_value')->first();
                if(!$admin_email){
                    $admin_email=env('APP_EMAIL');
                }
                $triggers_all_packages = DB::table('triggers_all_packages')->insert(
                 ['attorney_self_id' => Auth::user()->id, 'trig_package' => 'FDD Quick Family Law Financial Affidavit','package_select'=> 1,'faff_id'=>$postData['update_id_serialize']]
                );
                $user_id = Auth::user()->id;
                /* call the procedure to update the package_select 0 */ 
                 DB::select("CALL packages2docs(?,?)",[$user_id,0]);
                 
                $votes=DB::table('FDD_triggers_all_documents_Votes')->get();
                //sleep(2);
                //exec('touch /var/www/html/public/LatchProcessing/LatchVotes/FDD_View_Quick_FinAff_PDF/junk.txt', $output, $return); 
                // Return will return non-zero upon an error
                foreach($votes as $vote){
                 exec('touch '.$vote->vote_dir.'', $output, $return);
                 }
                if (!$return)
                {
                    //$response= "PDF Created Successfully";
                    return redirect()->route('attorney.downloads')->with('success', 'Your drafts will be available in your download directory soon. If you do not see your file here after a few seconds then please try again or Email Us.');
                }
                else
                {
                      // $response= "PDF not created";
                      echo $errmsg="Sorry, File that you are trying to download is not available yet. Please <a href='mailto:".$admin_email."'>check</a> with admin for more details"; die;
                }
             }
        }

        return view('fdd_tools.fdd_quick_affidavit_of_basic_information_sheet',['chk_prefill'=>$request->chk_prefill, 'postData' => $postData, 'selected_state_info' => $selected_state_info ]);
   
    }

    public function deactivate($id){
        $array1=['active' => '0'];
        $affidavit_sheet_submissions_data =DB::table('affidavit_sheet_submissions')
                                ->where('id', $id)
                                ->get()
                                ->first();
        if($affidavit_sheet_submissions_data->user_id == Auth::user()->id){
        } else {
            return redirect()->route('home');
        }
        DB::table('affidavit_sheet_submissions')->where('id', $id)->update($array1);
        DB::table('affidavit_attorney_submissions')->where('id', $affidavit_sheet_submissions_data->affidavit_attorney_submissions_id)->update($array1);

        return redirect()->back()->with('success','Affidavit Sheet deactivated successfully!');
    }

    public function activate($id){
        $array1=['active' => '1'];
        $affidavit_sheet_submissions_data =DB::table('affidavit_sheet_submissions')
                                ->where('id', $id)
                                ->get()
                                ->first();
        if($affidavit_sheet_submissions_data->user_id == Auth::user()->id){
        } else {
            return redirect()->route('home');
        }

        DB::table('affidavit_sheet_submissions')->where('id', $id)->update($array1);
        DB::table('affidavit_attorney_submissions')->where('id', $affidavit_sheet_submissions_data->affidavit_attorney_submissions_id)->update($array1);

        return redirect()->back()->with('success','Affidavit Sheet activated successfully!');
    }

    public function openFddQuickCSSheet($aff_att_sub_id){
        $prefill_data = DB::table('affidavit_attorney_submissions')
                                ->where('id', $aff_att_sub_id)
                                ->get()->first();
        $sheetData=unserialize($prefill_data->form_text);
        $attorney_data = User::find(Auth::user()->id)->attorney;
        $case_data=NULL;
        $postData=NULL;
        $ohMinimumWageData=DB::select(DB::raw("select getOHMinimumWage2018(0) AS tmpResult"));
        $OH_Minimum_Wage = $ohMinimumWageData[0]->tmpResult;
        if(isset($prefill_data) && $prefill_data->user_id == Auth::user()->id){
            if($sheetData['cs_sheet_obligor'] == 'top_party'){
                $obligor_name=$sheetData['topparty_name'];
                $obligee_name=$sheetData['bottomparty_name'];
                $parenta_name=$sheetData['topparty_name'];
                $parentb_name=$sheetData['bottomparty_name'];
                
                $obligee_1_radio=$sheetData['bp_inc_radio_dial'];
                $obligee_1_input_year=$sheetData['bp_input_year'];
                $obligee_1_dropdown=$sheetData['bp_dropdown'];
                $obligee_1_input_ytd=$sheetData['bp_input_ytd'];
                $obligee_1_datepick=$sheetData['bp_datepick'];
                
                $obligor_1_radio=$sheetData['tp_inc_radio_dial'];
                $obligor_1_input_year=$sheetData['tp_input_year'];
                $obligor_1_dropdown=$sheetData['tp_dropdown'];
                $obligor_1_input_ytd=$sheetData['tp_input_ytd'];
                $obligor_1_datepick=$sheetData['tp_datepick'];

                $obligee_1=$sheetData['bp_base_yearly_income_current'];
                $obligor_1=$sheetData['tp_base_yearly_income_current'];

                // Annual amount of overtime, bonuses, and commissions
                $obligee_2a=$sheetData['bp_yearly_OT_comms_bonuses_3ya'];
                $obligee_2b=$sheetData['bp_yearly_OT_comms_bonuses_2ya'];
                $obligee_2c=$sheetData['bp_yearly_OT_comms_bonuses_1ya'];

                $obligor_2a=$sheetData['tp_yearly_OT_comms_bonuses_3ya'];
                $obligor_2b=$sheetData['tp_yearly_OT_comms_bonuses_2ya'];
                $obligor_2c=$sheetData['tp_yearly_OT_comms_bonuses_1ya'];
                
                $obligee_4=$sheetData['bp_unemp_comp'];
                $obligor_4=$sheetData['tp_unemp_comp'];
                
                $obligee_5=$sheetData['bp_workers_comp'] + $sheetData['bp_ss_disability'] + $sheetData['bp_other_disability'] + $sheetData['bp_retirement_ss'] + $sheetData['bp_retirement_other'];
                $obligor_5=$sheetData['tp_workers_comp'] + $sheetData['tp_ss_disability'] + $sheetData['tp_other_disability'] + $sheetData['tp_retirement_ss'] + $sheetData['tp_retirement_other'];

                $obligee_6=$sheetData['bp_other_inc'];
                $obligor_6=$sheetData['tp_other_inc'];
                $num_obligor_children=0;
                $num_obligee_children=0;
                $obligor_9a=0;
                $obligee_9a=0;
                if($sheetData['num_minordependent_children_this_marriage'] && $sheetData['num_minordependent_children_this_marriage'] > 0){
                    for ($i=1; $i <= $sheetData['num_minordependent_children_this_marriage'] ; $i++) { 
                        if($sheetData['minordependent_livingwith'.$i.''] == $sheetData['topparty_name']){
                            ++$num_obligor_children;
                        }
                        if($sheetData['minordependent_livingwith'.$i.''] == $sheetData['bottomparty_name']){
                            ++$num_obligee_children;
                        }
                    }
                }
                $obligor_9a=$sheetData['tp_num_children_NoM'] + $num_obligor_children;
                $obligee_9a=$sheetData['bp_num_children_NoM'] + $num_obligee_children;

            } else {
                $obligee_name=$sheetData['topparty_name'];
                $obligor_name=$sheetData['bottomparty_name'];
                $parentb_name=$sheetData['topparty_name'];
                $parenta_name=$sheetData['bottomparty_name'];

                $obligor_1_radio=$sheetData['bp_inc_radio_dial'];
                $obligor_1_input_year=$sheetData['bp_input_year'];
                $obligor_1_dropdown=$sheetData['bp_dropdown'];
                $obligor_1_input_ytd=$sheetData['bp_input_ytd'];
                $obligor_1_datepick=$sheetData['bp_datepick'];
                
                $obligee_1_radio=$sheetData['tp_inc_radio_dial'];
                $obligee_1_input_year=$sheetData['tp_input_year'];
                $obligee_1_dropdown=$sheetData['tp_dropdown'];
                $obligee_1_input_ytd=$sheetData['tp_input_ytd'];
                $obligee_1_datepick=$sheetData['tp_datepick'];

                $obligor_1=$sheetData['bp_base_yearly_income_current'];
                $obligee_1=$sheetData['tp_base_yearly_income_current'];

                // Annual amount of overtime, bonuses, and commissions
                $obligor_2a=$sheetData['bp_yearly_OT_comms_bonuses_3ya'];
                $obligor_2b=$sheetData['bp_yearly_OT_comms_bonuses_2ya'];
                $obligor_2c=$sheetData['bp_yearly_OT_comms_bonuses_1ya'];

                $obligee_2a=$sheetData['tp_yearly_OT_comms_bonuses_3ya'];
                $obligee_2b=$sheetData['tp_yearly_OT_comms_bonuses_2ya'];
                $obligee_2c=$sheetData['tp_yearly_OT_comms_bonuses_1ya'];
                
                $obligor_4=$sheetData['bp_unemp_comp'];
                $obligee_4=$sheetData['tp_unemp_comp'];
                
                $obligor_5=$sheetData['bp_workers_comp'] + $sheetData['bp_ss_disability'] + $sheetData['bp_other_disability'] + $sheetData['bp_retirement_ss'] + $sheetData['bp_retirement_other'];
                $obligee_5=$sheetData['tp_workers_comp'] + $sheetData['tp_ss_disability'] + $sheetData['tp_other_disability'] + $sheetData['tp_retirement_ss'] + $sheetData['tp_retirement_other'];

                $obligor_6=$sheetData['bp_other_inc'];
                $obligee_6=$sheetData['tp_other_inc'];
                $num_obligor_children=0;
                $num_obligee_children=0;
                $obligor_9a=0;
                $obligee_9a=0;
                if($sheetData['num_minordependent_children_this_marriage'] && $sheetData['num_minordependent_children_this_marriage'] > 0){
                    for ($i=1; $i <= $sheetData['num_minordependent_children_this_marriage'] ; $i++) { 
                        if($sheetData['minordependent_livingwith'.$i.''] == $sheetData['topparty_name']){
                            ++$num_obligee_children;
                        }
                        if($sheetData['minordependent_livingwith'.$i.''] == $sheetData['bottomparty_name']){
                            ++$num_obligor_children;
                        }
                    }
                }
                $obligee_9a=$sheetData['tp_num_children_NoM'] + $num_obligee_children;
                $obligor_9a=$sheetData['bp_num_children_NoM'] + $num_obligor_children;
            }
            if($obligee_1_radio == 'ohio_min_wage'){
                $obligee_1_radio = 'oh_min_wage';
            }
            if($obligor_1_radio == 'ohio_min_wage'){
                $obligor_1_radio = 'oh_min_wage';
            }
            $obligee_21b1=NULL;
            $obligee_21b2=NULL;
            $obligee_21b3=NULL;
            $obligee_21b4=NULL;
            $obligee_21b5=NULL;
            $obligee_21b6=NULL;
            $obligor_21b1=NULL;
            $obligor_21b2=NULL;
            $obligor_21b3=NULL;
            $obligor_21b4=NULL;
            $obligor_21b5=NULL;
            $obligor_21b6=NULL;

            if($sheetData['cs_sheet_custody']=='Split'){
                $obligee_num=1;
                $obligor_num=1;
                for ($i=1; $i <= 6 ; $i++) {
                    if($sheetData['minordependent_livingwith'.$i.''] == $obligee_name){
                        ${"obligee_21b" . $obligee_num}=date("m/d/Y", strtotime($sheetData['minordependent_birth_date'.$i.'']));
                        ++$obligee_num;
                    }
                    if($sheetData['minordependent_livingwith'.$i.''] == $obligor_name){
                        ${"obligor_21b" . $obligor_num}=date("m/d/Y", strtotime($sheetData['minordependent_birth_date'.$i.'']));
                        ++$obligor_num;
                    }
                }
            } else {
                for ($i=1; $i <= 6 ; $i++) {
                    if(isset($sheetData['minordependent_birth_date'.$i.''])){
                        ${"obligee_21b" . $i}=date("m/d/Y", strtotime($sheetData['minordependent_birth_date'.$i.'']));                    
                    } else {
                        ${"obligee_21b" . $i}=NULL;
                    }
                }
            }
            $postData=[
                "user_id"=>Auth::user()->id,
                "case_id"=>NULL,
                "obligee_name"=>$obligee_name,
                "obligor_name"=>$obligor_name,
                // "parenta_name"=>$parenta_name,
                // "parentb_name"=>$parentb_name,
                "county_name"=>$sheetData['county_id'],
                "sets_case_number"=>$sheetData['case_number'],
                "number_children_order"=>$sheetData['num_minordependent_children_this_marriage'],
                'obligee_1_radio'=>$obligee_1_radio,
                'obligee_1_input_year'=>$obligee_1_input_year,
                'obligee_1_dropdown'=>$obligee_1_dropdown,
                'obligee_1_input_ytd'=>$obligee_1_input_ytd,
                'obligee_1_datepick'=>date("m/d/Y", strtotime($obligee_1_datepick)),
                'obligee_1'=>$obligee_1,
                'obligor_1_radio'=>$obligor_1_radio,
                'obligor_1_input_year'=>$obligor_1_input_year,
                'obligor_1_dropdown'=>$obligor_1_dropdown,
                'obligor_1_input_ytd'=>$obligor_1_input_ytd,
                'obligor_1_datepick'=>date("m/d/Y", strtotime($obligor_1_datepick)),
                'obligor_1'=>$obligor_1,
                'obligor_2a'=>$obligor_2a,
                'obligor_2b'=>$obligor_2b,
                'obligor_2c'=>$obligor_2c,
                'obligee_2a'=>$obligee_2a,
                'obligee_2b'=>$obligee_2b,
                'obligee_2c'=>$obligee_2c,
                'obligor_4'=>$obligor_4,
                'obligee_4'=>$obligee_4,
                'obligor_5'=>$obligor_5,
                'obligee_5'=>$obligee_5,
                'obligor_6'=>$obligor_6,
                'obligee_6'=>$obligee_6,
                // 'obligor_9a'=>$obligor_9a,
                // 'obligee_9a'=>$obligee_9a,
                // 'obligor_9b'=>$num_obligor_children,
                // 'obligee_9b'=>$num_obligee_children,
                'obligee_21b1'=>$obligee_21b1,
                'obligee_21b2'=>$obligee_21b2,
                'obligee_21b3'=>$obligee_21b3,
                'obligee_21b4'=>$obligee_21b4,
                'obligee_21b5'=>$obligee_21b5,
                'obligee_21b6'=>$obligee_21b6,
                'obligor_21b1'=>$obligor_21b1,
                'obligor_21b2'=>$obligor_21b2,
                'obligor_21b3'=>$obligor_21b3,
                'obligor_21b4'=>$obligor_21b4,
                'obligor_21b5'=>$obligor_21b5,
                'obligor_21b6'=>$obligor_21b6,
            ];
            if($sheetData['cs_sheet_custody']=='Split'){
                return view('computations.split',['sheet_custody' =>$sheetData['cs_sheet_custody'], 'sheet_state' =>$prefill_data->form_state, 'chk_prefill'=>'0', 'case_data'=>$case_data, 'attorney_data'=>$attorney_data, 'OH_Minimum_Wage'=>$OH_Minimum_Wage, 'postData'=>$postData]);
            } else {
                return view('computations.sole_shared',['sheet_custody' =>$sheetData['cs_sheet_custody'], 'sheet_state' =>$prefill_data->form_state, 'chk_prefill'=>'0', 'attorney_data'=>$attorney_data, 'case_data'=>$case_data, 'OH_Minimum_Wage'=>$OH_Minimum_Wage, 'postData'=>$postData]);
            }
        } else {
            return redirect()->route('home');
        }
    }

}