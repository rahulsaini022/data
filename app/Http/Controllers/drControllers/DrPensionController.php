<?php

namespace App\Http\Controllers\drControllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Auth;
use App\User;
use App\Courtcase;
use App\Caseuser;
use App\DrPension;
use App\DrMarriageInfo;
use App\DrCaseOverview;


class DrPensionController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    // to fetch all records
    public function index($case_id)
    {
        $data=DrPension::orderBy('id','DESC')->get();
        echo "<pre>";print_r($data);die;
    }


    public function create($case_id)
    {   
        // $case_data=Courtcase::where([['id', $case_id],['attorney_id', Auth::user()->id]])->get()->first();
        // if(isset($case_data)){
        // } else {
        //     return redirect()->route('home');
        // }
        $user_role=Auth::user()->roles->first()->name;
        if($user_role=='client'){
            $client_attorney = Caseuser::where([['case_id', $case_id],['user_id', Auth::user()->id]])->get()->pluck('attorney_id')->first();
            if($client_attorney){
                // $case_info=Courtcase::where([['id', $case_id],['attorney_id', $client_attorney]])->first();
                $case_data=Courtcase::where([['id', $case_id],['attorney_id', $client_attorney]])->get()->first();
                if(isset($case_data)){
                } else {
                    return redirect()->route('home');
                }
            } else {
                return redirect()->route('client.cases');
            }
        } else {
            $case_data=Courtcase::where([['id', $case_id],['attorney_id', Auth::user()->id]])->get()->first();
            if(isset($case_data)){
            } else {
                return redirect()->route('home');
            }
        }

        $drpension=DrPension::where('case_id',$case_id)->get()->pluck('case_id');
        if(isset($drpension['0'])){
            return redirect()->route('home');
        }
        $drcaseoverview=DrCaseOverview::where('case_id',$case_id)->get()->first();
        if(isset($drcaseoverview)){
        } else {
            return redirect()->route('cases.family_law_interview_tabs',$case_id)->with('error', 'Complete Case Overview Info Section First.');
        }
        $marriageinfo=DrMarriageInfo::where('case_id',$case_id)->get();
        if(isset($marriageinfo['0'])){
        } else {
            return redirect()->route('cases.family_law_interview_tabs',$case_id)->with('error', 'Complete Marriage Info Section First.');
        }
        $caseuser=DB::table('caseusers')
            ->join('users', 'caseusers.user_id', '=', 'users.id')
            ->where([['caseusers.case_id', $case_id],['caseusers.party_group', 'top']])
            ->select('users.name', 'caseusers.party_entity', 'caseusers.mname', 'caseusers.org_comp_name')
            ->first();
        if(isset($caseuser->name)){
            $client_name=$caseuser->name;
            if(isset($caseuser->party_entity) && $caseuser->party_entity=='organization_company') {
                $client_name=$caseuser->org_comp_name;
            } else {
                $mname=$caseuser->mname;
                if(isset($mname) && $mname !='') {
                    $namearray = explode(' ', $caseuser->name, 2);
                    if(count($namearray) > 1) {
                        $client_name=$namearray[0].' '.$mname.' '.$namearray[1];
                    } else {
                        $client_name=$caseuser->name.' '.$mname;
                    }
                }
            }
        }else {
            $client_name='ClientName';
        }
        $caseuser=DB::table('caseusers')
            ->join('users', 'caseusers.user_id', '=', 'users.id')
            ->where([['caseusers.case_id', $case_id],['caseusers.party_group', 'bottom']])
            ->select('users.name', 'caseusers.party_entity', 'caseusers.mname', 'caseusers.org_comp_name')
            ->first();
        if(isset($caseuser->name)){
            $opponent_name=$caseuser->name;
            if(isset($caseuser->party_entity) && $caseuser->party_entity=='organization_company') {
                $opponent_name=$caseuser->org_comp_name;
            } else {
                $mname=$caseuser->mname;
                if(isset($mname) && $mname !='') {
                    $namearray = explode(' ', $caseuser->name, 2);
                    if(count($namearray) > 1) {
                        $opponent_name=$namearray[0].' '.$mname.' '.$namearray[1];
                    } else {
                        $opponent_name=$caseuser->name.' '.$mname;
                    }
                }
            }
        }else {
            $opponent_name='OpName';
        }
        return view('dr_tables.dr_Pensions.create',['client_name'=>$client_name, 'opponent_name'=>$opponent_name, 'marriageinfo'=>$marriageinfo, 'case_data' => $case_data, 'drcaseoverview' => $drcaseoverview]);
    }

    // save tab info in database table.
    public function store(Request $request)
    {
        $result = $request->except('submit');

        if(isset($result['Any_Pension']) && $result['Any_Pension']=='1'){
        } else {
            $result['Any_Pension']='0';
            $result['Num_Client_Pensions']=0;
            $result['Num_Op_Pensions']=0;
        }

        if(isset($result['Num_Client_Pensions'])){
        } else {
            $result['Num_Client_Pensions']='0';
        }

        if(isset($result['Num_Op_Pensions'])){
        } else {
            $result['Num_Op_Pensions']='0';
        }

        $Num_Client_Pensions=$result['Num_Client_Pensions'];
        $insertarray['Any_Pension']=$result['Any_Pension'];
        $insertarray['Num_Client_Pensions']=$result['Num_Client_Pensions'];

        $Pension_Total_Estimated_Default_Net_Client=0;
        $Pension_Total_Estimated_Default_Net_Op=0;
        $Pension_Total_Estimated_Net_Client=0;
        $Pension_Total_Estimated_Net_Op=0;

        for ($i=1; $i <= $Num_Client_Pensions; $i++) {
            if(isset($result['Client_Date_Begin_Earning_Pension'.$i.''])){
                $result['Client_Date_Begin_Earning_Pension'.$i.'']=date("Y-m-d",strtotime($result['Client_Date_Begin_Earning_Pension'.$i.'']));
            } else {
                $result['Client_Date_Begin_Earning_Pension'.$i.'']=NULL;
            }
            if(isset($result['Client_Pension'.$i.'_Vest_Date'])){
                $result['Client_Pension'.$i.'_Vest_Date']=date("Y-m-d",strtotime($result['Client_Pension'.$i.'_Vest_Date']));
            } else {
                $result['Client_Pension'.$i.'_Vest_Date']=NULL;
            }
            if(isset($result['Client_Pension'.$i.'_Earliest_Ret_Date'])){
                $result['Client_Pension'.$i.'_Earliest_Ret_Date']=date("Y-m-d",strtotime($result['Client_Pension'.$i.'_Earliest_Ret_Date']));
            } else {
                $result['Client_Pension'.$i.'_Earliest_Ret_Date']=NULL;
            }
            if(isset($result['Client_Pension'.$i.'_Earliest_Ret_Date'])){
                $result['Client_Pension'.$i.'_Earliest_Ret_Date']=date("Y-m-d",strtotime($result['Client_Pension'.$i.'_Earliest_Ret_Date']));
            } else {
                $result['Client_Pension'.$i.'_Earliest_Ret_Date']=NULL;
            }
            if(isset($result['Client_Pension'.$i.'_Coverture_Denom_End_Date'])){
                $result['Client_Pension'.$i.'_Coverture_Denom_End_Date']=date("Y-m-d",strtotime($result['Client_Pension'.$i.'_Coverture_Denom_End_Date']));
            } else {
                $result['Client_Pension'.$i.'_Coverture_Denom_End_Date']=NULL;
            }
            if(isset($result['Client_Pension'.$i.'_Coverture_Num_Start_Date'])){
                $result['Client_Pension'.$i.'_Coverture_Num_Start_Date']=date("Y-m-d",strtotime($result['Client_Pension'.$i.'_Coverture_Num_Start_Date']));
            } else {
                $result['Client_Pension'.$i.'_Coverture_Num_Start_Date']=NULL;
            }
            if(isset($result['Client_Pension'.$i.'_Coverture_Num_End_Date'])){
                $result['Client_Pension'.$i.'_Coverture_Num_End_Date']=date("Y-m-d",strtotime($result['Client_Pension'.$i.'_Coverture_Num_End_Date']));
            } else {
                $result['Client_Pension'.$i.'_Coverture_Num_End_Date']=NULL;
            }

            if(isset($result['Client_Pension'.$i.'_Disposition_Type']) && $result['Client_Pension'.$i.'_Disposition_Type'] !='Buyout'){
                $result['Client_Pension'.$i.'_Buyout_Op_Amount']=NULL;
            }

            if(isset($result['Client_Pension'.$i.'_Disposition_Type']) && $result['Client_Pension'.$i.'_Disposition_Type'] !=''){
            } else {
                $result['Client_Pension'.$i.'_Disposition_Type']=NULL;
            }

            if(isset($result['Client_Pension'.$i.'_Has_Survivorship_Plan']) && $result['Client_Pension'.$i.'_Has_Survivorship_Plan'] !=''){
            } else {
                $result['Client_Pension'.$i.'_Has_Survivorship_Plan']=NULL;
                $result['Client_Pension'.$i.'_Survivorship_Plan_Percentage_Cost']=NULL;
                $result['Client_Pension'.$i.'_Survivorship_Plan_Monthly_Cost']=NULL;
                $result['Client_Pension'.$i.'_Surv_Payer']=NULL;
            }

            if(isset($result['Client_Pension'.$i.'_Survivorship_Plan_Percentage_Cost']) && $result['Client_Pension'.$i.'_Survivorship_Plan_Percentage_Cost'] !=''){
            } else {
                $result['Client_Pension'.$i.'_Survivorship_Plan_Percentage_Cost']=NULL;
            }

            // to calculate Pension_Total_Estimated_Default_Net_Client
            if(isset($result['Client_Pension'.$i.'_Estimate_Monthly_Client_Default']) && $result['Client_Pension'.$i.'_Estimate_Monthly_Client_Default'] !=''){
                $Pension_Total_Estimated_Default_Net_Client=$Pension_Total_Estimated_Default_Net_Client+$result['Client_Pension'.$i.'_Estimate_Monthly_Client_Default'];
            }
            if(isset($result['Op_Pension'.$i.'_Estimate_Monthly_Client_Default']) && $result['Op_Pension'.$i.'_Estimate_Monthly_Client_Default'] !=''){
                $Pension_Total_Estimated_Default_Net_Client=$Pension_Total_Estimated_Default_Net_Client+$result['Op_Pension'.$i.'_Estimate_Monthly_Client_Default'];
            }

            // to calculate Pension_Total_Estimated_Default_Net_Op
            if(isset($result['Client_Pension'.$i.'_Estimate_Monthly_Op_Default']) && $result['Client_Pension'.$i.'_Estimate_Monthly_Op_Default'] !=''){
                $Pension_Total_Estimated_Default_Net_Op=$Pension_Total_Estimated_Default_Net_Op+$result['Client_Pension'.$i.'_Estimate_Monthly_Op_Default'];
            }
            if(isset($result['Op_Pension'.$i.'_Estimate_Monthly_Op_Default']) && $result['Op_Pension'.$i.'_Estimate_Monthly_Op_Default'] !=''){
                $Pension_Total_Estimated_Default_Net_Op=$Pension_Total_Estimated_Default_Net_Op+$result['Op_Pension'.$i.'_Estimate_Monthly_Op_Default'];
            }


            // to calculate Pension_Total_Estimated_Net_Client
            if(isset($result['Client_Pension'.$i.'_Estimated_Net_Client']) && $result['Client_Pension'.$i.'_Estimated_Net_Client'] !=''){
                $Pension_Total_Estimated_Net_Client=$Pension_Total_Estimated_Net_Client+$result['Client_Pension'.$i.'_Estimated_Net_Client'];
            }
            if(isset($result['Op_Pension'.$i.'_Estimated_Net_Client']) && $result['Op_Pension'.$i.'_Estimated_Net_Client'] !=''){
                $Pension_Total_Estimated_Net_Client=$Pension_Total_Estimated_Net_Client+$result['Op_Pension'.$i.'_Estimated_Net_Client'];
            }


            // to calculate Pension_Total_Estimated_Net_Op
            if(isset($result['Client_Pension'.$i.'_Estimated_Net_Op']) && $result['Client_Pension'.$i.'_Estimated_Net_Op'] !=''){
                $Pension_Total_Estimated_Net_Op=$Pension_Total_Estimated_Net_Op+$result['Client_Pension'.$i.'_Estimated_Net_Op'];
            }
            if(isset($result['Op_Pension'.$i.'_Estimated_Net_Op']) && $result['Op_Pension'.$i.'_Estimated_Net_Op'] !=''){
                $Pension_Total_Estimated_Net_Op=$Pension_Total_Estimated_Net_Op+$result['Op_Pension'.$i.'_Estimated_Net_Op'];
            }

        }

        $insertarray['Pension_Total_Estimated_Default_Net_Client']=$Pension_Total_Estimated_Default_Net_Client;        
        $insertarray['Pension_Total_Estimated_Default_Net_Op']=$Pension_Total_Estimated_Default_Net_Op;        
        $insertarray['Pension_Total_Estimated_Net_Client']=$Pension_Total_Estimated_Net_Client;        
        $insertarray['Pension_Total_Estimated_Net_Op']=$Pension_Total_Estimated_Net_Op;   

        // to make unfilled client inputs null
        if($Num_Client_Pensions > 0){
            for ($i=1; $i <= $Num_Client_Pensions; $i++) {
                $insertarray['Client_Pension'.$i.'_Is_Currently_Being_Paid_Out']=$result['Client_Pension'.$i.'_Is_Currently_Being_Paid_Out'];
                $insertarray['Client_Pension'.$i.'_Type']=$result['Client_Pension'.$i.'_Type'];
                $insertarray['Client_Pension'.$i.'_ZIP']=$result['Client_Pension'.$i.'_ZIP'];
                $insertarray['Client_Pension'.$i.'_Institution_Name']=$result['Client_Pension'.$i.'_Institution_Name'];
                $insertarray['Client_Pension'.$i.'_Street_Address']=$result['Client_Pension'.$i.'_Street_Address'];
                $insertarray['Client_Pension'.$i.'_City']=$result['Client_Pension'.$i.'_City'];
                $insertarray['Client_Pension'.$i.'_State']=$result['Client_Pension'.$i.'_State'];
                $insertarray['Client_Pension'.$i.'_Acct_Num']=$result['Client_Pension'.$i.'_Acct_Num'];
                $insertarray['Client_Date_Begin_Earning_Pension'.$i.'']=$result['Client_Date_Begin_Earning_Pension'.$i.''];
                $insertarray['Client_Pension'.$i.'_Vest_Date']=$result['Client_Pension'.$i.'_Vest_Date'];
                $insertarray['Client_Pension'.$i.'_Earliest_Ret_Date']=$result['Client_Pension'.$i.'_Earliest_Ret_Date'];
                $insertarray['Client_Pension'.$i.'_Coverture_Denom_End_Date']=$result['Client_Pension'.$i.'_Coverture_Denom_End_Date'];
                $insertarray['Client_Pension'.$i.'_Coverture_Denom_Months']=$result['Client_Pension'.$i.'_Coverture_Denom_Months'];
                $insertarray['Client_Pension'.$i.'_Coverture_Num_Start_Date']=$result['Client_Pension'.$i.'_Coverture_Num_Start_Date'];
                $insertarray['Client_Pension'.$i.'_Coverture_Num_Months']=$result['Client_Pension'.$i.'_Coverture_Num_Months'];
                $insertarray['Client_Pension'.$i.'_Coverture_Fraction_Client_Default']=$result['Client_Pension'.$i.'_Coverture_Fraction_Client_Default'];
                $insertarray['Client_Pension'.$i.'_Coverture_Fraction_Op_Default']=$result['Client_Pension'.$i.'_Coverture_Fraction_Op_Default'];
                $insertarray['Client_Pension'.$i.'_Coverture_Num_End_Date']=$result['Client_Pension'.$i.'_Coverture_Num_End_Date'];
                $insertarray['Client_Pension'.$i.'_Estimated_Monthly_Payment']=$result['Client_Pension'.$i.'_Estimated_Monthly_Payment'];
                $insertarray['Client_Pension'.$i.'_Estimate_Monthly_Client_Default']=$result['Client_Pension'.$i.'_Estimate_Monthly_Client_Default'];
                $insertarray['Client_Pension'.$i.'_Estimate_Monthly_Op_Default']=$result['Client_Pension'.$i.'_Estimate_Monthly_Op_Default'];
                $insertarray['Client_Pension'.$i.'_Disposition_Type']=$result['Client_Pension'.$i.'_Disposition_Type'];
                $insertarray['Client_Pension'.$i.'_Has_Survivorship_Plan']=$result['Client_Pension'.$i.'_Has_Survivorship_Plan'];
                $insertarray['Client_Pension'.$i.'_Survivorship_Plan_Percentage_Cost']=$result['Client_Pension'.$i.'_Survivorship_Plan_Percentage_Cost'];
                $insertarray['Client_Pension'.$i.'_Survivorship_Plan_Monthly_Cost']=$result['Client_Pension'.$i.'_Survivorship_Plan_Monthly_Cost'];
                $insertarray['Client_Pension'.$i.'_Surv_Payer']=$result['Client_Pension'.$i.'_Surv_Payer'];
                $insertarray['Client_Pension'.$i.'_Surv_Cost_Client']=$result['Client_Pension'.$i.'_Surv_Cost_Client'];
                $insertarray['Client_Pension'.$i.'_Surv_Cost_Op']=$result['Client_Pension'.$i.'_Surv_Cost_Op'];
                $insertarray['Client_Pension'.$i.'_Buyout_Op_Amount']=$result['Client_Pension'.$i.'_Buyout_Op_Amount'];
                $insertarray['Client_Pension'.$i.'_Custom_Monthly_Op_Amount']=$result['Client_Pension'.$i.'_Custom_Monthly_Op_Amount'];
                $insertarray['Client_Pension'.$i.'_Custom_Monthly_Client_Amount']=$result['Client_Pension'.$i.'_Custom_Monthly_Client_Amount'];
                $insertarray['Client_Pension'.$i.'_Custom_Monthly_Op_Percent']=$result['Client_Pension'.$i.'_Custom_Monthly_Op_Percent'];
                $insertarray['Client_Pension'.$i.'_Custom_Monthly_Client_Percent']=$result['Client_Pension'.$i.'_Custom_Monthly_Client_Percent'];
                $insertarray['Client_Pension'.$i.'_Estimated_Net_Client']=$result['Client_Pension'.$i.'_Estimated_Net_Client'];
                $insertarray['Client_Pension'.$i.'_Estimated_Net_Op']=$result['Client_Pension'.$i.'_Estimated_Net_Op'];
            }
        } 
        // to make unfilled inputs null
        $Num_Client_Pensions=$Num_Client_Pensions+1;
        for ($i=$Num_Client_Pensions; $i <= 4; $i++) { 
            $insertarray['Client_Pension'.$i.'_Is_Currently_Being_Paid_Out']=NULL;
            $insertarray['Client_Pension'.$i.'_Type']=NULL;
            $insertarray['Client_Pension'.$i.'_ZIP']=NULL;
            $insertarray['Client_Pension'.$i.'_Institution_Name']=NULL;
            $insertarray['Client_Pension'.$i.'_Street_Address']=NULL;
            $insertarray['Client_Pension'.$i.'_City']=NULL;
            $insertarray['Client_Pension'.$i.'_State']=NULL;
            $insertarray['Client_Pension'.$i.'_Acct_Num']=NULL;
            $insertarray['Client_Date_Begin_Earning_Pension'.$i.'']=NULL;
            $insertarray['Client_Pension'.$i.'_Vest_Date']=NULL;
            $insertarray['Client_Pension'.$i.'_Earliest_Ret_Date']=NULL;
            $insertarray['Client_Pension'.$i.'_Coverture_Denom_End_Date']=NULL;
            $insertarray['Client_Pension'.$i.'_Coverture_Denom_Months']=NULL;
            $insertarray['Client_Pension'.$i.'_Coverture_Num_Start_Date']=NULL;
            $insertarray['Client_Pension'.$i.'_Coverture_Num_Months']=NULL;
            $insertarray['Client_Pension'.$i.'_Coverture_Fraction_Client_Default']=NULL;
            $insertarray['Client_Pension'.$i.'_Coverture_Fraction_Op_Default']=NULL;
            $insertarray['Client_Pension'.$i.'_Coverture_Num_End_Date']=NULL;
            $insertarray['Client_Pension'.$i.'_Estimated_Monthly_Payment']=NULL;
            $insertarray['Client_Pension'.$i.'_Estimate_Monthly_Client_Default']=NULL;
            $insertarray['Client_Pension'.$i.'_Estimate_Monthly_Op_Default']=NULL;
            $insertarray['Client_Pension'.$i.'_Disposition_Type']=NULL;
            $insertarray['Client_Pension'.$i.'_Has_Survivorship_Plan']=NULL;
            $insertarray['Client_Pension'.$i.'_Survivorship_Plan_Percentage_Cost']=NULL;
            $insertarray['Client_Pension'.$i.'_Survivorship_Plan_Monthly_Cost']=NULL;
            $insertarray['Client_Pension'.$i.'_Surv_Payer']=NULL;
            $insertarray['Client_Pension'.$i.'_Surv_Cost_Client']=NULL;
            $insertarray['Client_Pension'.$i.'_Surv_Cost_Op']=NULL;
            $insertarray['Client_Pension'.$i.'_Buyout_Op_Amount']=NULL;
            $insertarray['Client_Pension'.$i.'_Custom_Monthly_Op_Amount']=NULL;
            $insertarray['Client_Pension'.$i.'_Custom_Monthly_Client_Amount']=NULL;
            $insertarray['Client_Pension'.$i.'_Custom_Monthly_Op_Percent']=NULL;
            $insertarray['Client_Pension'.$i.'_Custom_Monthly_Client_Percent']=NULL;
            $insertarray['Client_Pension'.$i.'_Estimated_Net_Client']=NULL;
            $insertarray['Client_Pension'.$i.'_Estimated_Net_Op']=NULL;
        }

        $Num_Op_Pensions=$result['Num_Op_Pensions'];
        $insertarray['Num_Op_Pensions']=$result['Num_Op_Pensions'];

        for ($i=1; $i <= $Num_Op_Pensions; $i++) {
            if(isset($result['Op_Date_Begin_Earning_Pension'.$i.''])){
                $result['Op_Date_Begin_Earning_Pension'.$i.'']=date("Y-m-d",strtotime($result['Op_Date_Begin_Earning_Pension'.$i.'']));
            } else {
                $result['Op_Date_Begin_Earning_Pension'.$i.'']=NULL;
            }
            if(isset($result['Op_Pension'.$i.'_Vest_Date'])){
                $result['Op_Pension'.$i.'_Vest_Date']=date("Y-m-d",strtotime($result['Op_Pension'.$i.'_Vest_Date']));
            } else {
                $result['Op_Pension'.$i.'_Vest_Date']=NULL;
            }
            if(isset($result['Op_Pension'.$i.'_Earliest_Ret_Date'])){
                $result['Op_Pension'.$i.'_Earliest_Ret_Date']=date("Y-m-d",strtotime($result['Op_Pension'.$i.'_Earliest_Ret_Date']));
            } else {
                $result['Op_Pension'.$i.'_Earliest_Ret_Date']=NULL;
            }
            if(isset($result['Op_Pension'.$i.'_Earliest_Ret_Date'])){
                $result['Op_Pension'.$i.'_Earliest_Ret_Date']=date("Y-m-d",strtotime($result['Op_Pension'.$i.'_Earliest_Ret_Date']));
            } else {
                $result['Op_Pension'.$i.'_Earliest_Ret_Date']=NULL;
            }
            if(isset($result['Op_Pension'.$i.'_Coverture_Denom_End_Date'])){
                $result['Op_Pension'.$i.'_Coverture_Denom_End_Date']=date("Y-m-d",strtotime($result['Op_Pension'.$i.'_Coverture_Denom_End_Date']));
            } else {
                $result['Op_Pension'.$i.'_Coverture_Denom_End_Date']=NULL;
            }
            if(isset($result['Op_Pension'.$i.'_Coverture_Num_Start_Date'])){
                $result['Op_Pension'.$i.'_Coverture_Num_Start_Date']=date("Y-m-d",strtotime($result['Op_Pension'.$i.'_Coverture_Num_Start_Date']));
            } else {
                $result['Op_Pension'.$i.'_Coverture_Num_Start_Date']=NULL;
            }
            if(isset($result['Op_Pension'.$i.'_Coverture_Num_End_Date'])){
                $result['Op_Pension'.$i.'_Coverture_Num_End_Date']=date("Y-m-d",strtotime($result['Op_Pension'.$i.'_Coverture_Num_End_Date']));
            } else {
                $result['Op_Pension'.$i.'_Coverture_Num_End_Date']=NULL;
            }

            if(isset($result['Op_Pension'.$i.'_Disposition_Type']) && $result['Op_Pension'.$i.'_Disposition_Type'] !='Buyout'){
                $result['Op_Pension'.$i.'_Buyout_Op_Amount']=NULL;
            }

            if(isset($result['Op_Pension'.$i.'_Disposition_Type']) && $result['Op_Pension'.$i.'_Disposition_Type'] !=''){
            } else {
                $result['Op_Pension'.$i.'_Disposition_Type']=NULL;
            }

            if(isset($result['Op_Pension'.$i.'_Has_Survivorship_Plan']) && $result['Op_Pension'.$i.'_Has_Survivorship_Plan'] !=''){
            } else {
                $result['Op_Pension'.$i.'_Has_Survivorship_Plan']=NULL;
                $result['Op_Pension'.$i.'_Survivorship_Plan_Percentage_Cost']=NULL;
                $result['Op_Pension'.$i.'_Survivorship_Plan_Monthly_Cost']=NULL;
                $result['Op_Pension'.$i.'_Surv_Payer']=NULL;
            }

            if(isset($result['Op_Pension'.$i.'_Survivorship_Plan_Percentage_Cost']) && $result['Op_Pension'.$i.'_Survivorship_Plan_Percentage_Cost'] !=''){
            } else {
                $result['Op_Pension'.$i.'_Survivorship_Plan_Percentage_Cost']=NULL;
            }
        }
        if($Num_Op_Pensions > 0){
            for ($i=1; $i <= $Num_Op_Pensions; $i++) {
                $insertarray['Op_Pension'.$i.'_Is_Currently_Being_Paid_Out']=$result['Op_Pension'.$i.'_Is_Currently_Being_Paid_Out'];
                $insertarray['Op_Pension'.$i.'_Type']=$result['Op_Pension'.$i.'_Type'];
                $insertarray['Op_Pension'.$i.'_ZIP']=$result['Op_Pension'.$i.'_ZIP'];
                $insertarray['Op_Pension'.$i.'_Institution_Name']=$result['Op_Pension'.$i.'_Institution_Name'];
                $insertarray['Op_Pension'.$i.'_Street_Address']=$result['Op_Pension'.$i.'_Street_Address'];
                $insertarray['Op_Pension'.$i.'_City']=$result['Op_Pension'.$i.'_City'];
                $insertarray['Op_Pension'.$i.'_State']=$result['Op_Pension'.$i.'_State'];
                $insertarray['Op_Pension'.$i.'_Acct_Num']=$result['Op_Pension'.$i.'_Acct_Num'];
                $insertarray['Op_Date_Begin_Earning_Pension'.$i.'']=$result['Op_Date_Begin_Earning_Pension'.$i.''];
                $insertarray['Op_Pension'.$i.'_Vest_Date']=$result['Op_Pension'.$i.'_Vest_Date'];
                $insertarray['Op_Pension'.$i.'_Earliest_Ret_Date']=$result['Op_Pension'.$i.'_Earliest_Ret_Date'];
                $insertarray['Op_Pension'.$i.'_Coverture_Denom_End_Date']=$result['Op_Pension'.$i.'_Coverture_Denom_End_Date'];
                $insertarray['Op_Pension'.$i.'_Coverture_Denom_Months']=$result['Op_Pension'.$i.'_Coverture_Denom_Months'];
                $insertarray['Op_Pension'.$i.'_Coverture_Num_Start_Date']=$result['Op_Pension'.$i.'_Coverture_Num_Start_Date'];
                $insertarray['Op_Pension'.$i.'_Coverture_Num_Months']=$result['Op_Pension'.$i.'_Coverture_Num_Months'];
                $insertarray['Op_Pension'.$i.'_Coverture_Fraction_Client_Default']=$result['Op_Pension'.$i.'_Coverture_Fraction_Client_Default'];
                $insertarray['Op_Pension'.$i.'_Coverture_Fraction_Op_Default']=$result['Op_Pension'.$i.'_Coverture_Fraction_Op_Default'];
                $insertarray['Op_Pension'.$i.'_Coverture_Num_End_Date']=$result['Op_Pension'.$i.'_Coverture_Num_End_Date'];
                $insertarray['Op_Pension'.$i.'_Estimated_Monthly_Payment']=$result['Op_Pension'.$i.'_Estimated_Monthly_Payment'];
                $insertarray['Op_Pension'.$i.'_Estimate_Monthly_Client_Default']=$result['Op_Pension'.$i.'_Estimate_Monthly_Client_Default'];
                $insertarray['Op_Pension'.$i.'_Estimate_Monthly_Op_Default']=$result['Op_Pension'.$i.'_Estimate_Monthly_Op_Default'];
                $insertarray['Op_Pension'.$i.'_Disposition_Type']=$result['Op_Pension'.$i.'_Disposition_Type'];
                $insertarray['Op_Pension'.$i.'_Has_Survivorship_Plan']=$result['Op_Pension'.$i.'_Has_Survivorship_Plan'];
                $insertarray['Op_Pension'.$i.'_Survivorship_Plan_Percentage_Cost']=$result['Op_Pension'.$i.'_Survivorship_Plan_Percentage_Cost'];
                $insertarray['Op_Pension'.$i.'_Survivorship_Plan_Monthly_Cost']=$result['Op_Pension'.$i.'_Survivorship_Plan_Monthly_Cost'];
                $insertarray['Op_Pension'.$i.'_Surv_Payer']=$result['Op_Pension'.$i.'_Surv_Payer'];
                $insertarray['Op_Pension'.$i.'_Surv_Cost_Client']=$result['Op_Pension'.$i.'_Surv_Cost_Client'];
                $insertarray['Op_Pension'.$i.'_Surv_Cost_Op']=$result['Op_Pension'.$i.'_Surv_Cost_Op'];
                $insertarray['Op_Pension'.$i.'_Buyout_Op_Amount']=$result['Op_Pension'.$i.'_Buyout_Op_Amount'];
                $insertarray['Op_Pension'.$i.'_Custom_Monthly_Op_Amount']=$result['Op_Pension'.$i.'_Custom_Monthly_Op_Amount'];
                $insertarray['Op_Pension'.$i.'_Custom_Monthly_Client_Amount']=$result['Op_Pension'.$i.'_Custom_Monthly_Client_Amount'];
                $insertarray['Op_Pension'.$i.'_Custom_Monthly_Op_Percent']=$result['Op_Pension'.$i.'_Custom_Monthly_Op_Percent'];
                $insertarray['Op_Pension'.$i.'_Custom_Monthly_Client_Percent']=$result['Op_Pension'.$i.'_Custom_Monthly_Client_Percent'];
                $insertarray['Op_Pension'.$i.'_Estimated_Net_Client']=$result['Op_Pension'.$i.'_Estimated_Net_Client'];
                $insertarray['Op_Pension'.$i.'_Estimated_Net_Op']=$result['Op_Pension'.$i.'_Estimated_Net_Op'];
            }
        }
        // to make unfilled inputs null
        $Num_Op_Pensions=$Num_Op_Pensions+1;
        for ($i=$Num_Op_Pensions; $i <= 4; $i++) {
            $insertarray['Op_Pension'.$i.'_Is_Currently_Being_Paid_Out']=NULL;
            $insertarray['Op_Pension'.$i.'_Type']=NULL;
            $insertarray['Op_Pension'.$i.'_ZIP']=NULL;
            $insertarray['Op_Pension'.$i.'_Institution_Name']=NULL;
            $insertarray['Op_Pension'.$i.'_Street_Address']=NULL;
            $insertarray['Op_Pension'.$i.'_City']=NULL;
            $insertarray['Op_Pension'.$i.'_State']=NULL;
            $insertarray['Op_Pension'.$i.'_Acct_Num']=NULL;
            $insertarray['Op_Date_Begin_Earning_Pension'.$i.'']=NULL;
            $insertarray['Op_Pension'.$i.'_Vest_Date']=NULL;
            $insertarray['Op_Pension'.$i.'_Earliest_Ret_Date']=NULL;
            $insertarray['Op_Pension'.$i.'_Coverture_Denom_End_Date']=NULL;
            $insertarray['Op_Pension'.$i.'_Coverture_Denom_Months']=NULL;
            $insertarray['Op_Pension'.$i.'_Coverture_Num_Start_Date']=NULL;
            $insertarray['Op_Pension'.$i.'_Coverture_Num_Months']=NULL;
            $insertarray['Op_Pension'.$i.'_Coverture_Fraction_Client_Default']=NULL;
            $insertarray['Op_Pension'.$i.'_Coverture_Fraction_Op_Default']=NULL;
            $insertarray['Op_Pension'.$i.'_Coverture_Num_End_Date']=NULL;
            $insertarray['Op_Pension'.$i.'_Estimated_Monthly_Payment']=NULL;
            $insertarray['Op_Pension'.$i.'_Estimate_Monthly_Client_Default']=NULL;
            $insertarray['Op_Pension'.$i.'_Estimate_Monthly_Op_Default']=NULL;
            $insertarray['Op_Pension'.$i.'_Disposition_Type']=NULL;
            $insertarray['Op_Pension'.$i.'_Has_Survivorship_Plan']=NULL;
            $insertarray['Op_Pension'.$i.'_Survivorship_Plan_Percentage_Cost']=NULL;
            $insertarray['Op_Pension'.$i.'_Survivorship_Plan_Monthly_Cost']=NULL;
            $insertarray['Op_Pension'.$i.'_Surv_Payer']=NULL;
            $insertarray['Op_Pension'.$i.'_Surv_Cost_Client']=NULL;
            $insertarray['Op_Pension'.$i.'_Surv_Cost_Op']=NULL;
            $insertarray['Op_Pension'.$i.'_Buyout_Op_Amount']=NULL;
            $insertarray['Op_Pension'.$i.'_Custom_Monthly_Op_Amount']=NULL;
            $insertarray['Op_Pension'.$i.'_Custom_Monthly_Client_Amount']=NULL;
            $insertarray['Op_Pension'.$i.'_Custom_Monthly_Op_Percent']=NULL;
            $insertarray['Op_Pension'.$i.'_Custom_Monthly_Client_Percent']=NULL;
            $insertarray['Op_Pension'.$i.'_Estimated_Net_Client']=NULL;
            $insertarray['Op_Pension'.$i.'_Estimated_Net_Op']=NULL;
        }
        $insertarray['case_id']=$result['case_id'];
        // die('In Progress');
        // echo "<pre>";print_r($insertarray);die;
        $drpension=DrPension::create($insertarray);
        // update case overview info.
        $drcaseoverview=DrCaseOverview::where('case_id',$result['case_id'])->get()->first();
        if(isset($drcaseoverview)){
            $drcaseoverview->Any_Pension=$result['Any_Pension'];
            $drcaseoverview->Num_Client_Pensions=$result['Num_Client_Pensions'];
            $drcaseoverview->Num_Op_Pensions=$result['Num_Op_Pensions'];
            $drcaseoverview->save();
        } else {
            return redirect()->route('cases.family_law_interview_tabs',$result['case_id'])->with('error', 'Complete Case Overview Info Section First.');
        }

        return redirect()->route('cases.family_law_interview_tabs',$result['case_id'])->with('success', 'Pensions Information Submitted Successfully.');
        
    }

    public function show($id)
    {

    }

    public function edit($case_id)
    {
        // $case_data=Courtcase::where([['id', $case_id],['attorney_id', Auth::user()->id]])->get()->first();
        // if(isset($case_data)){
        // } else {
        //     return redirect()->route('home');
        // }
        $user_role=Auth::user()->roles->first()->name;
        if($user_role=='client'){
            $client_attorney = Caseuser::where([['case_id', $case_id],['user_id', Auth::user()->id]])->get()->pluck('attorney_id')->first();
            if($client_attorney){
                // $case_info=Courtcase::where([['id', $case_id],['attorney_id', $client_attorney]])->first();
                $case_data=Courtcase::where([['id', $case_id],['attorney_id', $client_attorney]])->get()->first();
                if(isset($case_data)){
                } else {
                    return redirect()->route('home');
                }
            } else {
                return redirect()->route('client.cases');
            }
        } else {
            $case_data=Courtcase::where([['id', $case_id],['attorney_id', Auth::user()->id]])->get()->first();
            if(isset($case_data)){
            } else {
                return redirect()->route('home');
            }
        }
        
        $marriageinfo=DrMarriageInfo::where('case_id',$case_id)->get();
        if(isset($marriageinfo['0'])){
        } else {
            return redirect()->route('cases.family_law_interview_tabs',$case_id)->with('error', 'Complete Marriage Info Section First.');
        }

        $drpension=DrPension::where('case_id',$case_id)->get()->first();
         // echo "<pre>";print_r($drpension);//die;
        $caseuser=DB::table('caseusers')
            ->join('users', 'caseusers.user_id', '=', 'users.id')
            ->where([['caseusers.case_id', $case_id],['caseusers.party_group', 'top']])
            ->select('users.name', 'caseusers.party_entity', 'caseusers.mname', 'caseusers.org_comp_name')
            ->first();
        if(isset($caseuser->name)){
            $client_name=$caseuser->name;
            if(isset($caseuser->party_entity) && $caseuser->party_entity=='organization_company') {
                $client_name=$caseuser->org_comp_name;
            } else {
                $mname=$caseuser->mname;
                if(isset($mname) && $mname !='') {
                    $namearray = explode(' ', $caseuser->name, 2);
                    if(count($namearray) > 1) {
                        $client_name=$namearray[0].' '.$mname.' '.$namearray[1];
                    } else {
                        $client_name=$caseuser->name.' '.$mname;
                    }
                }
            }
        }else {
            $client_name='ClientName';
        }
        $caseuser=DB::table('caseusers')
            ->join('users', 'caseusers.user_id', '=', 'users.id')
            ->where([['caseusers.case_id', $case_id],['caseusers.party_group', 'bottom']])
            ->select('users.name', 'caseusers.party_entity', 'caseusers.mname', 'caseusers.org_comp_name')
            ->first();
        if(isset($caseuser->name)){
            $opponent_name=$caseuser->name;
            if(isset($caseuser->party_entity) && $caseuser->party_entity=='organization_company') {
                $opponent_name=$caseuser->org_comp_name;
            } else {
                $mname=$caseuser->mname;
                if(isset($mname) && $mname !='') {
                    $namearray = explode(' ', $caseuser->name, 2);
                    if(count($namearray) > 1) {
                        $opponent_name=$namearray[0].' '.$mname.' '.$namearray[1];
                    } else {
                        $opponent_name=$caseuser->name.' '.$mname;
                    }
                }
            }
        }else {
            $opponent_name='OpName';
        }
         // echo "<pre>";print_r($drpension);die;
        $drcaseoverview=DrCaseOverview::where('case_id',$case_id)->get()->first();
        if($drpension){
            if(isset($drcaseoverview)){
                if(isset($drcaseoverview) && $drcaseoverview->Any_Pension==$drpension->Any_Pension && $drcaseoverview->Num_Client_Pensions==$drpension->Num_Client_Pensions && $drcaseoverview->Num_Op_Pensions==$drpension->Num_Op_Pensions)
                {

                } else {
                    $drpension->Any_Pension=$drcaseoverview->Any_Pension;
                    $drpension->Num_Client_Pensions=$drcaseoverview->Num_Client_Pensions;
                    $drpension->Num_Op_Pensions=$drcaseoverview->Num_Op_Pensions;
                }
            }
            return view('dr_tables.dr_Pensions.edit',['client_name'=>$client_name, 'opponent_name'=>$opponent_name, 'drpension' => $drpension, 'marriageinfo'=>$marriageinfo, 'case_data' => $case_data]);
        } else {
            return redirect()->route('home');
        }
        
    }

    public function update(Request $request, $id)
    {
        $result = $request->except('submit','_method','_token');

        if(isset($result['Any_Pension']) && $result['Any_Pension']=='1'){
        } else {
            $result['Any_Pension']='0';
            $result['Num_Client_Pensions']=0;
            $result['Num_Op_Pensions']=0;
        }

        if(isset($result['Num_Client_Pensions'])){
        } else {
            $result['Num_Client_Pensions']='0';
        }
        
        if(isset($result['Num_Op_Pensions'])){
        } else {
            $result['Num_Op_Pensions']='0';
        }
        
        $Num_Client_Pensions=$result['Num_Client_Pensions'];
        $insertarray['Any_Pension']=$result['Any_Pension'];
        $insertarray['Num_Client_Pensions']=$result['Num_Client_Pensions'];

        $Pension_Total_Estimated_Default_Net_Client=0;
        $Pension_Total_Estimated_Default_Net_Op=0;
        $Pension_Total_Estimated_Net_Client=0;
        $Pension_Total_Estimated_Net_Op=0;

        for ($i=1; $i <= $Num_Client_Pensions; $i++) {
            if(isset($result['Client_Date_Begin_Earning_Pension'.$i.''])){
                $result['Client_Date_Begin_Earning_Pension'.$i.'']=date("Y-m-d",strtotime($result['Client_Date_Begin_Earning_Pension'.$i.'']));
            } else {
                $result['Client_Date_Begin_Earning_Pension'.$i.'']=NULL;
            }
            if(isset($result['Client_Pension'.$i.'_Vest_Date'])){
                $result['Client_Pension'.$i.'_Vest_Date']=date("Y-m-d",strtotime($result['Client_Pension'.$i.'_Vest_Date']));
            } else {
                $result['Client_Pension'.$i.'_Vest_Date']=NULL;
            }
            if(isset($result['Client_Pension'.$i.'_Earliest_Ret_Date'])){
                $result['Client_Pension'.$i.'_Earliest_Ret_Date']=date("Y-m-d",strtotime($result['Client_Pension'.$i.'_Earliest_Ret_Date']));
            } else {
                $result['Client_Pension'.$i.'_Earliest_Ret_Date']=NULL;
            }
            if(isset($result['Client_Pension'.$i.'_Earliest_Ret_Date'])){
                $result['Client_Pension'.$i.'_Earliest_Ret_Date']=date("Y-m-d",strtotime($result['Client_Pension'.$i.'_Earliest_Ret_Date']));
            } else {
                $result['Client_Pension'.$i.'_Earliest_Ret_Date']=NULL;
            }
            if(isset($result['Client_Pension'.$i.'_Coverture_Denom_End_Date'])){
                $result['Client_Pension'.$i.'_Coverture_Denom_End_Date']=date("Y-m-d",strtotime($result['Client_Pension'.$i.'_Coverture_Denom_End_Date']));
            } else {
                $result['Client_Pension'.$i.'_Coverture_Denom_End_Date']=NULL;
            }
            if(isset($result['Client_Pension'.$i.'_Coverture_Num_Start_Date'])){
                $result['Client_Pension'.$i.'_Coverture_Num_Start_Date']=date("Y-m-d",strtotime($result['Client_Pension'.$i.'_Coverture_Num_Start_Date']));
            } else {
                $result['Client_Pension'.$i.'_Coverture_Num_Start_Date']=NULL;
            }
            if(isset($result['Client_Pension'.$i.'_Coverture_Num_End_Date'])){
                $result['Client_Pension'.$i.'_Coverture_Num_End_Date']=date("Y-m-d",strtotime($result['Client_Pension'.$i.'_Coverture_Num_End_Date']));
            } else {
                $result['Client_Pension'.$i.'_Coverture_Num_End_Date']=NULL;
            }

            if(isset($result['Client_Pension'.$i.'_Disposition_Type']) && $result['Client_Pension'.$i.'_Disposition_Type'] !='Buyout'){
                $result['Client_Pension'.$i.'_Buyout_Op_Amount']=NULL;
            }

            if(isset($result['Client_Pension'.$i.'_Disposition_Type']) && $result['Client_Pension'.$i.'_Disposition_Type'] !=''){
            } else {
                $result['Client_Pension'.$i.'_Disposition_Type']=NULL;
            }

            if(isset($result['Client_Pension'.$i.'_Has_Survivorship_Plan']) && $result['Client_Pension'.$i.'_Has_Survivorship_Plan'] !=''){
            } else {
                $result['Client_Pension'.$i.'_Has_Survivorship_Plan']=NULL;
                $result['Client_Pension'.$i.'_Survivorship_Plan_Percentage_Cost']=NULL;
                $result['Client_Pension'.$i.'_Survivorship_Plan_Monthly_Cost']=NULL;
                $result['Client_Pension'.$i.'_Surv_Payer']=NULL;
            }

            if(isset($result['Client_Pension'.$i.'_Survivorship_Plan_Percentage_Cost']) && $result['Client_Pension'.$i.'_Survivorship_Plan_Percentage_Cost'] !=''){
            } else {
                $result['Client_Pension'.$i.'_Survivorship_Plan_Percentage_Cost']=NULL;
            }

            // to calculate Pension_Total_Estimated_Default_Net_Client
            if(isset($result['Client_Pension'.$i.'_Estimate_Monthly_Client_Default']) && $result['Client_Pension'.$i.'_Estimate_Monthly_Client_Default'] !=''){
                $Pension_Total_Estimated_Default_Net_Client=$Pension_Total_Estimated_Default_Net_Client+$result['Client_Pension'.$i.'_Estimate_Monthly_Client_Default'];
            }
            if(isset($result['Op_Pension'.$i.'_Estimate_Monthly_Client_Default']) && $result['Op_Pension'.$i.'_Estimate_Monthly_Client_Default'] !=''){
                $Pension_Total_Estimated_Default_Net_Client=$Pension_Total_Estimated_Default_Net_Client+$result['Op_Pension'.$i.'_Estimate_Monthly_Client_Default'];
            }

            // to calculate Pension_Total_Estimated_Default_Net_Op
            if(isset($result['Client_Pension'.$i.'_Estimate_Monthly_Op_Default']) && $result['Client_Pension'.$i.'_Estimate_Monthly_Op_Default'] !=''){
                $Pension_Total_Estimated_Default_Net_Op=$Pension_Total_Estimated_Default_Net_Op+$result['Client_Pension'.$i.'_Estimate_Monthly_Op_Default'];
            }
            if(isset($result['Op_Pension'.$i.'_Estimate_Monthly_Op_Default']) && $result['Op_Pension'.$i.'_Estimate_Monthly_Op_Default'] !=''){
                $Pension_Total_Estimated_Default_Net_Op=$Pension_Total_Estimated_Default_Net_Op+$result['Op_Pension'.$i.'_Estimate_Monthly_Op_Default'];
            }


            // to calculate Pension_Total_Estimated_Net_Client
            if(isset($result['Client_Pension'.$i.'_Estimated_Net_Client']) && $result['Client_Pension'.$i.'_Estimated_Net_Client'] !=''){
                $Pension_Total_Estimated_Net_Client=$Pension_Total_Estimated_Net_Client+$result['Client_Pension'.$i.'_Estimated_Net_Client'];
            }
            if(isset($result['Op_Pension'.$i.'_Estimated_Net_Client']) && $result['Op_Pension'.$i.'_Estimated_Net_Client'] !=''){
                $Pension_Total_Estimated_Net_Client=$Pension_Total_Estimated_Net_Client+$result['Op_Pension'.$i.'_Estimated_Net_Client'];
            }


            // to calculate Pension_Total_Estimated_Net_Op
            if(isset($result['Client_Pension'.$i.'_Estimated_Net_Op']) && $result['Client_Pension'.$i.'_Estimated_Net_Op'] !=''){
                $Pension_Total_Estimated_Net_Op=$Pension_Total_Estimated_Net_Op+$result['Client_Pension'.$i.'_Estimated_Net_Op'];
            }
            if(isset($result['Op_Pension'.$i.'_Estimated_Net_Op']) && $result['Op_Pension'.$i.'_Estimated_Net_Op'] !=''){
                $Pension_Total_Estimated_Net_Op=$Pension_Total_Estimated_Net_Op+$result['Op_Pension'.$i.'_Estimated_Net_Op'];
            }
        }

        $insertarray['Pension_Total_Estimated_Default_Net_Client']=$Pension_Total_Estimated_Default_Net_Client;        
        $insertarray['Pension_Total_Estimated_Default_Net_Op']=$Pension_Total_Estimated_Default_Net_Op;        
        $insertarray['Pension_Total_Estimated_Net_Client']=$Pension_Total_Estimated_Net_Client;        
        $insertarray['Pension_Total_Estimated_Net_Op']=$Pension_Total_Estimated_Net_Op;

        // to make unfilled client inputs null
        if($Num_Client_Pensions > 0){
            for ($i=1; $i <= $Num_Client_Pensions; $i++) {
                $insertarray['Client_Pension'.$i.'_Is_Currently_Being_Paid_Out']=$result['Client_Pension'.$i.'_Is_Currently_Being_Paid_Out'];
                $insertarray['Client_Pension'.$i.'_Type']=$result['Client_Pension'.$i.'_Type'];
                $insertarray['Client_Pension'.$i.'_ZIP']=$result['Client_Pension'.$i.'_ZIP'];
                $insertarray['Client_Pension'.$i.'_Institution_Name']=$result['Client_Pension'.$i.'_Institution_Name'];
                $insertarray['Client_Pension'.$i.'_Street_Address']=$result['Client_Pension'.$i.'_Street_Address'];
                $insertarray['Client_Pension'.$i.'_City']=$result['Client_Pension'.$i.'_City'];
                $insertarray['Client_Pension'.$i.'_State']=$result['Client_Pension'.$i.'_State'];
                $insertarray['Client_Pension'.$i.'_Acct_Num']=$result['Client_Pension'.$i.'_Acct_Num'];
                $insertarray['Client_Date_Begin_Earning_Pension'.$i.'']=$result['Client_Date_Begin_Earning_Pension'.$i.''];
                $insertarray['Client_Pension'.$i.'_Vest_Date']=$result['Client_Pension'.$i.'_Vest_Date'];
                $insertarray['Client_Pension'.$i.'_Earliest_Ret_Date']=$result['Client_Pension'.$i.'_Earliest_Ret_Date'];
                $insertarray['Client_Pension'.$i.'_Coverture_Denom_End_Date']=$result['Client_Pension'.$i.'_Coverture_Denom_End_Date'];
                $insertarray['Client_Pension'.$i.'_Coverture_Denom_Months']=$result['Client_Pension'.$i.'_Coverture_Denom_Months'];
                $insertarray['Client_Pension'.$i.'_Coverture_Num_Start_Date']=$result['Client_Pension'.$i.'_Coverture_Num_Start_Date'];
                $insertarray['Client_Pension'.$i.'_Coverture_Num_Months']=$result['Client_Pension'.$i.'_Coverture_Num_Months'];
                $insertarray['Client_Pension'.$i.'_Coverture_Fraction_Client_Default']=$result['Client_Pension'.$i.'_Coverture_Fraction_Client_Default'];
                $insertarray['Client_Pension'.$i.'_Coverture_Fraction_Op_Default']=$result['Client_Pension'.$i.'_Coverture_Fraction_Op_Default'];
                $insertarray['Client_Pension'.$i.'_Coverture_Num_End_Date']=$result['Client_Pension'.$i.'_Coverture_Num_End_Date'];
                $insertarray['Client_Pension'.$i.'_Estimated_Monthly_Payment']=$result['Client_Pension'.$i.'_Estimated_Monthly_Payment'];
                $insertarray['Client_Pension'.$i.'_Estimate_Monthly_Client_Default']=$result['Client_Pension'.$i.'_Estimate_Monthly_Client_Default'];
                $insertarray['Client_Pension'.$i.'_Estimate_Monthly_Op_Default']=$result['Client_Pension'.$i.'_Estimate_Monthly_Op_Default'];
                $insertarray['Client_Pension'.$i.'_Disposition_Type']=$result['Client_Pension'.$i.'_Disposition_Type'];
                $insertarray['Client_Pension'.$i.'_Has_Survivorship_Plan']=$result['Client_Pension'.$i.'_Has_Survivorship_Plan'];
                $insertarray['Client_Pension'.$i.'_Survivorship_Plan_Percentage_Cost']=$result['Client_Pension'.$i.'_Survivorship_Plan_Percentage_Cost'];
                $insertarray['Client_Pension'.$i.'_Survivorship_Plan_Monthly_Cost']=$result['Client_Pension'.$i.'_Survivorship_Plan_Monthly_Cost'];
                $insertarray['Client_Pension'.$i.'_Surv_Payer']=$result['Client_Pension'.$i.'_Surv_Payer'];
                $insertarray['Client_Pension'.$i.'_Surv_Cost_Client']=$result['Client_Pension'.$i.'_Surv_Cost_Client'];
                $insertarray['Client_Pension'.$i.'_Surv_Cost_Op']=$result['Client_Pension'.$i.'_Surv_Cost_Op'];
                $insertarray['Client_Pension'.$i.'_Buyout_Op_Amount']=$result['Client_Pension'.$i.'_Buyout_Op_Amount'];
                $insertarray['Client_Pension'.$i.'_Custom_Monthly_Op_Amount']=$result['Client_Pension'.$i.'_Custom_Monthly_Op_Amount'];
                $insertarray['Client_Pension'.$i.'_Custom_Monthly_Client_Amount']=$result['Client_Pension'.$i.'_Custom_Monthly_Client_Amount'];
                $insertarray['Client_Pension'.$i.'_Custom_Monthly_Op_Percent']=$result['Client_Pension'.$i.'_Custom_Monthly_Op_Percent'];
                $insertarray['Client_Pension'.$i.'_Custom_Monthly_Client_Percent']=$result['Client_Pension'.$i.'_Custom_Monthly_Client_Percent'];
                $insertarray['Client_Pension'.$i.'_Estimated_Net_Client']=$result['Client_Pension'.$i.'_Estimated_Net_Client'];
                $insertarray['Client_Pension'.$i.'_Estimated_Net_Op']=$result['Client_Pension'.$i.'_Estimated_Net_Op'];
            }
        } 
        // to make unfilled inputs null
        $Num_Client_Pensions=$Num_Client_Pensions+1;
        for ($i=$Num_Client_Pensions; $i <= 4; $i++) { 
            $insertarray['Client_Pension'.$i.'_Is_Currently_Being_Paid_Out']=NULL;
            $insertarray['Client_Pension'.$i.'_Type']=NULL;
            $insertarray['Client_Pension'.$i.'_ZIP']=NULL;
            $insertarray['Client_Pension'.$i.'_Institution_Name']=NULL;
            $insertarray['Client_Pension'.$i.'_Street_Address']=NULL;
            $insertarray['Client_Pension'.$i.'_City']=NULL;
            $insertarray['Client_Pension'.$i.'_State']=NULL;
            $insertarray['Client_Pension'.$i.'_Acct_Num']=NULL;
            $insertarray['Client_Date_Begin_Earning_Pension'.$i.'']=NULL;
            $insertarray['Client_Pension'.$i.'_Vest_Date']=NULL;
            $insertarray['Client_Pension'.$i.'_Earliest_Ret_Date']=NULL;
            $insertarray['Client_Pension'.$i.'_Coverture_Denom_End_Date']=NULL;
            $insertarray['Client_Pension'.$i.'_Coverture_Denom_Months']=NULL;
            $insertarray['Client_Pension'.$i.'_Coverture_Num_Start_Date']=NULL;
            $insertarray['Client_Pension'.$i.'_Coverture_Num_Months']=NULL;
            $insertarray['Client_Pension'.$i.'_Coverture_Fraction_Client_Default']=NULL;
            $insertarray['Client_Pension'.$i.'_Coverture_Fraction_Op_Default']=NULL;
            $insertarray['Client_Pension'.$i.'_Coverture_Num_End_Date']=NULL;
            $insertarray['Client_Pension'.$i.'_Estimated_Monthly_Payment']=NULL;
            $insertarray['Client_Pension'.$i.'_Estimate_Monthly_Client_Default']=NULL;
            $insertarray['Client_Pension'.$i.'_Estimate_Monthly_Op_Default']=NULL;
            $insertarray['Client_Pension'.$i.'_Disposition_Type']=NULL;
            $insertarray['Client_Pension'.$i.'_Has_Survivorship_Plan']=NULL;
            $insertarray['Client_Pension'.$i.'_Survivorship_Plan_Percentage_Cost']=NULL;
            $insertarray['Client_Pension'.$i.'_Survivorship_Plan_Monthly_Cost']=NULL;
            $insertarray['Client_Pension'.$i.'_Surv_Payer']=NULL;
            $insertarray['Client_Pension'.$i.'_Surv_Cost_Client']=NULL;
            $insertarray['Client_Pension'.$i.'_Surv_Cost_Op']=NULL;
            $insertarray['Client_Pension'.$i.'_Buyout_Op_Amount']=NULL;
            $insertarray['Client_Pension'.$i.'_Custom_Monthly_Op_Amount']=NULL;
            $insertarray['Client_Pension'.$i.'_Custom_Monthly_Client_Amount']=NULL;
            $insertarray['Client_Pension'.$i.'_Custom_Monthly_Op_Percent']=NULL;
            $insertarray['Client_Pension'.$i.'_Custom_Monthly_Client_Percent']=NULL;
            $insertarray['Client_Pension'.$i.'_Estimated_Net_Client']=NULL;
            $insertarray['Client_Pension'.$i.'_Estimated_Net_Op']=NULL;
        }

        $Num_Op_Pensions=$result['Num_Op_Pensions'];
        $insertarray['Num_Op_Pensions']=$result['Num_Op_Pensions'];

        for ($i=1; $i <= $Num_Op_Pensions; $i++) {
            if(isset($result['Op_Date_Begin_Earning_Pension'.$i.''])){
                $result['Op_Date_Begin_Earning_Pension'.$i.'']=date("Y-m-d",strtotime($result['Op_Date_Begin_Earning_Pension'.$i.'']));
            } else {
                $result['Op_Date_Begin_Earning_Pension'.$i.'']=NULL;
            }
            if(isset($result['Op_Pension'.$i.'_Vest_Date'])){
                $result['Op_Pension'.$i.'_Vest_Date']=date("Y-m-d",strtotime($result['Op_Pension'.$i.'_Vest_Date']));
            } else {
                $result['Op_Pension'.$i.'_Vest_Date']=NULL;
            }
            if(isset($result['Op_Pension'.$i.'_Earliest_Ret_Date'])){
                $result['Op_Pension'.$i.'_Earliest_Ret_Date']=date("Y-m-d",strtotime($result['Op_Pension'.$i.'_Earliest_Ret_Date']));
            } else {
                $result['Op_Pension'.$i.'_Earliest_Ret_Date']=NULL;
            }
            if(isset($result['Op_Pension'.$i.'_Earliest_Ret_Date'])){
                $result['Op_Pension'.$i.'_Earliest_Ret_Date']=date("Y-m-d",strtotime($result['Op_Pension'.$i.'_Earliest_Ret_Date']));
            } else {
                $result['Op_Pension'.$i.'_Earliest_Ret_Date']=NULL;
            }
            if(isset($result['Op_Pension'.$i.'_Coverture_Denom_End_Date'])){
                $result['Op_Pension'.$i.'_Coverture_Denom_End_Date']=date("Y-m-d",strtotime($result['Op_Pension'.$i.'_Coverture_Denom_End_Date']));
            } else {
                $result['Op_Pension'.$i.'_Coverture_Denom_End_Date']=NULL;
            }
            if(isset($result['Op_Pension'.$i.'_Coverture_Num_Start_Date'])){
                $result['Op_Pension'.$i.'_Coverture_Num_Start_Date']=date("Y-m-d",strtotime($result['Op_Pension'.$i.'_Coverture_Num_Start_Date']));
            } else {
                $result['Op_Pension'.$i.'_Coverture_Num_Start_Date']=NULL;
            }
            if(isset($result['Op_Pension'.$i.'_Coverture_Num_End_Date'])){
                $result['Op_Pension'.$i.'_Coverture_Num_End_Date']=date("Y-m-d",strtotime($result['Op_Pension'.$i.'_Coverture_Num_End_Date']));
            } else {
                $result['Op_Pension'.$i.'_Coverture_Num_End_Date']=NULL;
            }

            if(isset($result['Op_Pension'.$i.'_Disposition_Type']) && $result['Op_Pension'.$i.'_Disposition_Type'] !='Buyout'){
                $result['Op_Pension'.$i.'_Buyout_Op_Amount']=NULL;
            }

            if(isset($result['Op_Pension'.$i.'_Disposition_Type']) && $result['Op_Pension'.$i.'_Disposition_Type'] !=''){
            } else {
                $result['Op_Pension'.$i.'_Disposition_Type']=NULL;
            }

            if(isset($result['Op_Pension'.$i.'_Has_Survivorship_Plan']) && $result['Op_Pension'.$i.'_Has_Survivorship_Plan'] !=''){
            } else {
                $result['Op_Pension'.$i.'_Has_Survivorship_Plan']=NULL;
                $result['Op_Pension'.$i.'_Survivorship_Plan_Percentage_Cost']=NULL;
                $result['Op_Pension'.$i.'_Survivorship_Plan_Monthly_Cost']=NULL;
                $result['Op_Pension'.$i.'_Surv_Payer']=NULL;
            }

            if(isset($result['Op_Pension'.$i.'_Survivorship_Plan_Percentage_Cost']) && $result['Op_Pension'.$i.'_Survivorship_Plan_Percentage_Cost'] !=''){
            } else {
                $result['Op_Pension'.$i.'_Survivorship_Plan_Percentage_Cost']=NULL;
            }
        }
        if($Num_Op_Pensions > 0){
            for ($i=1; $i <= $Num_Op_Pensions; $i++) {
                $insertarray['Op_Pension'.$i.'_Is_Currently_Being_Paid_Out']=$result['Op_Pension'.$i.'_Is_Currently_Being_Paid_Out'];
                $insertarray['Op_Pension'.$i.'_Type']=$result['Op_Pension'.$i.'_Type'];
                $insertarray['Op_Pension'.$i.'_ZIP']=$result['Op_Pension'.$i.'_ZIP'];
                $insertarray['Op_Pension'.$i.'_Institution_Name']=$result['Op_Pension'.$i.'_Institution_Name'];
                $insertarray['Op_Pension'.$i.'_Street_Address']=$result['Op_Pension'.$i.'_Street_Address'];
                $insertarray['Op_Pension'.$i.'_City']=$result['Op_Pension'.$i.'_City'];
                $insertarray['Op_Pension'.$i.'_State']=$result['Op_Pension'.$i.'_State'];
                $insertarray['Op_Pension'.$i.'_Acct_Num']=$result['Op_Pension'.$i.'_Acct_Num'];
                $insertarray['Op_Date_Begin_Earning_Pension'.$i.'']=$result['Op_Date_Begin_Earning_Pension'.$i.''];
                $insertarray['Op_Pension'.$i.'_Vest_Date']=$result['Op_Pension'.$i.'_Vest_Date'];
                $insertarray['Op_Pension'.$i.'_Earliest_Ret_Date']=$result['Op_Pension'.$i.'_Earliest_Ret_Date'];
                $insertarray['Op_Pension'.$i.'_Coverture_Denom_End_Date']=$result['Op_Pension'.$i.'_Coverture_Denom_End_Date'];
                $insertarray['Op_Pension'.$i.'_Coverture_Denom_Months']=$result['Op_Pension'.$i.'_Coverture_Denom_Months'];
                $insertarray['Op_Pension'.$i.'_Coverture_Num_Start_Date']=$result['Op_Pension'.$i.'_Coverture_Num_Start_Date'];
                $insertarray['Op_Pension'.$i.'_Coverture_Num_Months']=$result['Op_Pension'.$i.'_Coverture_Num_Months'];
                $insertarray['Op_Pension'.$i.'_Coverture_Fraction_Client_Default']=$result['Op_Pension'.$i.'_Coverture_Fraction_Client_Default'];
                $insertarray['Op_Pension'.$i.'_Coverture_Fraction_Op_Default']=$result['Op_Pension'.$i.'_Coverture_Fraction_Op_Default'];
                $insertarray['Op_Pension'.$i.'_Coverture_Num_End_Date']=$result['Op_Pension'.$i.'_Coverture_Num_End_Date'];
                $insertarray['Op_Pension'.$i.'_Estimated_Monthly_Payment']=$result['Op_Pension'.$i.'_Estimated_Monthly_Payment'];
                $insertarray['Op_Pension'.$i.'_Estimate_Monthly_Client_Default']=$result['Op_Pension'.$i.'_Estimate_Monthly_Client_Default'];
                $insertarray['Op_Pension'.$i.'_Estimate_Monthly_Op_Default']=$result['Op_Pension'.$i.'_Estimate_Monthly_Op_Default'];
                $insertarray['Op_Pension'.$i.'_Disposition_Type']=$result['Op_Pension'.$i.'_Disposition_Type'];
                $insertarray['Op_Pension'.$i.'_Has_Survivorship_Plan']=$result['Op_Pension'.$i.'_Has_Survivorship_Plan'];
                $insertarray['Op_Pension'.$i.'_Survivorship_Plan_Percentage_Cost']=$result['Op_Pension'.$i.'_Survivorship_Plan_Percentage_Cost'];
                $insertarray['Op_Pension'.$i.'_Survivorship_Plan_Monthly_Cost']=$result['Op_Pension'.$i.'_Survivorship_Plan_Monthly_Cost'];
                $insertarray['Op_Pension'.$i.'_Surv_Payer']=$result['Op_Pension'.$i.'_Surv_Payer'];
                $insertarray['Op_Pension'.$i.'_Surv_Cost_Client']=$result['Op_Pension'.$i.'_Surv_Cost_Client'];
                $insertarray['Op_Pension'.$i.'_Surv_Cost_Op']=$result['Op_Pension'.$i.'_Surv_Cost_Op'];
                $insertarray['Op_Pension'.$i.'_Buyout_Op_Amount']=$result['Op_Pension'.$i.'_Buyout_Op_Amount'];
                $insertarray['Op_Pension'.$i.'_Custom_Monthly_Op_Amount']=$result['Op_Pension'.$i.'_Custom_Monthly_Op_Amount'];
                $insertarray['Op_Pension'.$i.'_Custom_Monthly_Client_Amount']=$result['Op_Pension'.$i.'_Custom_Monthly_Client_Amount'];
                $insertarray['Op_Pension'.$i.'_Custom_Monthly_Op_Percent']=$result['Op_Pension'.$i.'_Custom_Monthly_Op_Percent'];
                $insertarray['Op_Pension'.$i.'_Custom_Monthly_Client_Percent']=$result['Op_Pension'.$i.'_Custom_Monthly_Client_Percent'];
                $insertarray['Op_Pension'.$i.'_Estimated_Net_Client']=$result['Op_Pension'.$i.'_Estimated_Net_Client'];
                $insertarray['Op_Pension'.$i.'_Estimated_Net_Op']=$result['Op_Pension'.$i.'_Estimated_Net_Op'];
            }
        }
        // to make unfilled inputs null
        $Num_Op_Pensions=$Num_Op_Pensions+1;
        for ($i=$Num_Op_Pensions; $i <= 4; $i++) {
            $insertarray['Op_Pension'.$i.'_Is_Currently_Being_Paid_Out']=NULL;
            $insertarray['Op_Pension'.$i.'_Type']=NULL;
            $insertarray['Op_Pension'.$i.'_ZIP']=NULL;
            $insertarray['Op_Pension'.$i.'_Institution_Name']=NULL;
            $insertarray['Op_Pension'.$i.'_Street_Address']=NULL;
            $insertarray['Op_Pension'.$i.'_City']=NULL;
            $insertarray['Op_Pension'.$i.'_State']=NULL;
            $insertarray['Op_Pension'.$i.'_Acct_Num']=NULL;
            $insertarray['Op_Date_Begin_Earning_Pension'.$i.'']=NULL;
            $insertarray['Op_Pension'.$i.'_Vest_Date']=NULL;
            $insertarray['Op_Pension'.$i.'_Earliest_Ret_Date']=NULL;
            $insertarray['Op_Pension'.$i.'_Coverture_Denom_End_Date']=NULL;
            $insertarray['Op_Pension'.$i.'_Coverture_Denom_Months']=NULL;
            $insertarray['Op_Pension'.$i.'_Coverture_Num_Start_Date']=NULL;
            $insertarray['Op_Pension'.$i.'_Coverture_Num_Months']=NULL;
            $insertarray['Op_Pension'.$i.'_Coverture_Fraction_Client_Default']=NULL;
            $insertarray['Op_Pension'.$i.'_Coverture_Fraction_Op_Default']=NULL;
            $insertarray['Op_Pension'.$i.'_Coverture_Num_End_Date']=NULL;
            $insertarray['Op_Pension'.$i.'_Estimated_Monthly_Payment']=NULL;
            $insertarray['Op_Pension'.$i.'_Estimate_Monthly_Client_Default']=NULL;
            $insertarray['Op_Pension'.$i.'_Estimate_Monthly_Op_Default']=NULL;
            $insertarray['Op_Pension'.$i.'_Disposition_Type']=NULL;
            $insertarray['Op_Pension'.$i.'_Has_Survivorship_Plan']=NULL;
            $insertarray['Op_Pension'.$i.'_Survivorship_Plan_Percentage_Cost']=NULL;
            $insertarray['Op_Pension'.$i.'_Survivorship_Plan_Monthly_Cost']=NULL;
            $insertarray['Op_Pension'.$i.'_Surv_Payer']=NULL;
            $insertarray['Op_Pension'.$i.'_Surv_Cost_Client']=NULL;
            $insertarray['Op_Pension'.$i.'_Surv_Cost_Op']=NULL;
            $insertarray['Op_Pension'.$i.'_Buyout_Op_Amount']=NULL;
            $insertarray['Op_Pension'.$i.'_Custom_Monthly_Op_Amount']=NULL;
            $insertarray['Op_Pension'.$i.'_Custom_Monthly_Client_Amount']=NULL;
            $insertarray['Op_Pension'.$i.'_Custom_Monthly_Op_Percent']=NULL;
            $insertarray['Op_Pension'.$i.'_Custom_Monthly_Client_Percent']=NULL;
            $insertarray['Op_Pension'.$i.'_Estimated_Net_Client']=NULL;
            $insertarray['Op_Pension'.$i.'_Estimated_Net_Op']=NULL;
        }
        $insertarray['case_id']=$result['case_id'];
        
        // echo "<pre>";print_r($result);die;
        $drpension  = DrPension::findOrFail($id);
        if($drpension){
            $drpension->fill($insertarray)->save();
            // update case overview info.
            $drcaseoverview=DrCaseOverview::where('case_id',$result['case_id'])->get()->first();
            if(isset($drcaseoverview)){
                $drcaseoverview->Any_Pension=$result['Any_Pension'];
                $drcaseoverview->Num_Client_Pensions=$result['Num_Client_Pensions'];
                $drcaseoverview->Num_Op_Pensions=$result['Num_Op_Pensions'];
                $drcaseoverview->save();
            } else {
                return redirect()->route('cases.family_law_interview_tabs',$result['case_id'])->with('error', 'Complete Case Overview Info Section First.');
            }
            return redirect()->route('drpensions.edit',$result['case_id'])->with('success', 'Pensions Information Updated Successfully.');
        } else {
            return redirect()->route('drpensions.edit',$result['case_id'])->with('error', 'Something went wrong. Please try Again.');
        }
    }
    
    public function destroy($id)
    {

    }

}
