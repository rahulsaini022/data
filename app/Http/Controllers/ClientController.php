<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Mail\CaseRegistered;
use Illuminate\Support\Facades\Mail;
use App\User;
use App\State;
use App\County;
use App\Court;
use App\Division;
use App\Attorney;
use App\Courtcase;
use App\Caseuser;
use App\Partyattorney;
use Redirect;
use Validator;
use Auth;
use Carbon\Carbon;
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
use App\DrIncome;
use App\CasePartyInfo;
use App\CasePartyAttorneyInfo;
use App\CaseThirdPartyAttorneyInfo;
use App\CasePaymentPackage;
use App\Usercredithistory;
use App\CasePaymentTransactionHistory;
use App\DrCaseOverview;

class ClientController extends Controller

{

    /* Show cases list to client in which he is added as client and case payment is done. */
    public function index()
    {
        $client_cases = Caseuser::where('user_id', Auth::user()->id)->get();
        $attorney_array=array();
        $case_array=array();
        // old foreach to fetch all cases of client
        // foreach ($client_cases as $client_case) {
        //     $attorney_array[]=$client_case->attorney_id;
        //     $case_array[]=$client_case->case_id;
        // }

        // new foreach to fetch cases in which client if main/first party
        foreach ($client_cases as $client_case) {
            $client_id_check = DB::table('caseusers')
                ->where([['case_id', $client_case->case_id],['type', 'client']])
                ->get()->pluck('user_id');
            if($client_id_check[0]==Auth::user()->id){
                $attorney_array[]=$client_case->attorney_id;
                $case_array[]=$client_case->case_id;
            }
            $opponent_id_check = DB::table('caseusers')
                ->where([['case_id', $client_case->case_id],['type', 'opponent']])
                ->get()->pluck('user_id');
           /* if($opponent_id_check[0]==Auth::user()->id){
                $attorney_array[]=$client_case->attorney_id;
                $case_array[]=$client_case->case_id;
            }*/
            
        }

        $data = Courtcase::whereIn('id', $case_array)->where('case_payment_package_id', '14')->orderBy('id','DESC')->get();
        $client_data=array();
        $opponent_data=array();
        $state_data=array();
        $county_data=array();
        $court_data=array();
        $division_data=array();
        $i=0;
        foreach ($data as $value) {
            $client_id = DB::table('caseusers')
                ->where([['case_id', $value->id],['type', 'client']])
                ->get()->pluck('user_id');
            if($client_id && isset($client_id[0])){
                $data[$i]['client_name']=User::find($client_id[0])->name;
            } else {
                $data[$i]['client_name']='';
            }
            $opponent_id = DB::table('caseusers')
                ->where([['case_id', $value->id],['type', 'opponent']])
                ->get()->pluck('user_id');
            if($opponent_id && isset($opponent_id[0])){
                $data[$i]['opponent_name']=User::find($opponent_id[0])->name;
            } else {
                $data[$i]['opponent_name']='';
            }
            $ally_id = DB::table('caseusers')
                ->where([['case_id', $value->id],['type', 'ally']])
                ->get()->pluck('user_id');
            if($ally_id && isset($ally_id[0])){
                $data[$i]['ally_name']=User::find($ally_id[0])->name;
            } else {
                $data[$i]['ally_name']='';
            }
            if(isset($value->judge_id)){
                 $judge_name = DB::table('judges')
                ->where('id',$value->judge_id)
                ->get()->pluck('adjudicator');
                $data[$i]['judge_name']= $judge_name[0];
            }else if(isset($value->judge_fullname)){
                $data[$i]['judge_name']= $value->judge_fullname;
            } else {
                $data[$i]['judge_name']= '';
            }

            $data[$i]['state_name']= State::find($value->state_id)->state;
            $data[$i]['county_name']= County::find($value->county_id)->county_name;
            $data[$i]['court_name']= Court::find($value->court_id)->name;
            $data[$i]['division_name']= Division::find($value->division_id)->name;
            $drchildren=DrChildren::where('case_id',$value->id)->get()->pluck('This_Marriage_Custody_Arrangement');
            if(isset($drchildren['0'])){
                $data[$i]['custody']=$drchildren['0'];
            }
            ++$i;
        }
        // echo "<pre>";print_r($state_data);print_r($county_data);print_r($court_data);print_r($division_data);die;
        // echo "<pre>";print_r($data);die;
        return view('client.index',['data'=> $data]);

    }

    /* Shown interview tabs to clients with status done/pending */
    public function familyLawInterviewData($id)
    {
        $case_data=Courtcase::find($id);
        if(isset($case_data)){
        } else {
            return redirect()->route('home');
        }
        $data=array();
        $drcaseoverview=DrCaseOverview::where('case_id',$id)->get()->first();
        if(isset($drcaseoverview)){
            $data['addcaseoverviewinfo']=true;

        } else {
            $data['addcaseoverviewinfo']=false;
            // $data['caseoverviewinfo']=false;
        }
        $personalinfo=DrPersonalInfo::where('case_id',$id)->get()->first();
        // $data['caseoverviewinfo']=true;
        if(isset($personalinfo)){
            if(isset($drcaseoverview) && $drcaseoverview->Client_Info_Active_Military==$personalinfo->Client_Info_Active_Military && $drcaseoverview->Client_Branch==$personalinfo->Client_Branch && $drcaseoverview->SCRA_Prevents_Client==$personalinfo->SCRA_Prevents_Client && $drcaseoverview->Client_Waive_SCRA_Rights==$personalinfo->Client_Waive_SCRA_Rights && $drcaseoverview->Client_Possible_SCRA_Issues==$personalinfo->Client_Possible_SCRA_Issues && $drcaseoverview->Op_Info_Active_Military==$personalinfo->Op_Info_Active_Military && $drcaseoverview->Op_Branch==$personalinfo->Op_Branch && $drcaseoverview->SCRA_Prevents_Op==$personalinfo->SCRA_Prevents_Op && $drcaseoverview->Op_Waive_SCRA_Rights==$personalinfo->Op_Waive_SCRA_Rights && $drcaseoverview->Op_Possible_SCRA_Issues==$personalinfo->Op_Possible_SCRA_Issues)
            {
                $data['addpersonalinfo']='true';
            } else {
                $data['addpersonalinfo']='update';
            }

        } else {
            $data['addpersonalinfo']=false;
            // $data['caseoverviewinfo']=false;
        }
        $childreninfo=DrChildren::where('case_id',$id)->get()->first();
        if(isset($childreninfo)){
            if(isset($drcaseoverview) && $drcaseoverview->Num_Children_ONLY_This_Marriage==$childreninfo->Num_Children_ONLY_This_Marriage && $drcaseoverview->Num_MinorDepChildren_ONLY_This_Marriage==$childreninfo->Num_MinorDepChildren_ONLY_This_Marriage && $drcaseoverview->Num_Client_Children_NOT_this_Marriage==$childreninfo->Num_Client_Children_NOT_this_Marriage && $drcaseoverview->Num_Op_Children_NOT_this_Marriage==$childreninfo->Num_Op_Children_NOT_this_Marriage)
            {
                $data['addchildreninfo']='true';
            } else {
                $data['addchildreninfo']='update';
            }
        } else {
            $data['addchildreninfo']=false;
            // $data['caseoverviewinfo']=false;
        }
        $nsuranceinfo=DrInsurance::where('case_id',$id)->get()->pluck('case_id');
        if(isset($nsuranceinfo['0'])){
            $data['addinsuranceinfo']=true;
        } else {
            $data['addinsuranceinfo']=false;
        }
        $temporaryordersinfo=DrTemporaryOrders::where('case_id',$id)->get()->pluck('case_id');
        if(isset($temporaryordersinfo['0'])){
            $data['addtemporaryordersinfo']=true;
        } else {
            $data['addtemporaryordersinfo']=false;
        }
        $monthlyhousingexpensesinfo=DrMonthlyHousingExpenses::where('case_id',$id)->get()->pluck('case_id');
        if(isset($monthlyhousingexpensesinfo['0'])){
            $data['addmonthlyhousingexpensesinfo']=true;
        } else {
            $data['addmonthlyhousingexpensesinfo']=false;
        }
        $monthlyhealthcareexpensesinfo=DrMonthlyHealthCareExpenses::where('case_id',$id)->get()->pluck('case_id');
        if(isset($monthlyhealthcareexpensesinfo['0'])){
            $data['addmonthlyhealthcareexpensesinfo']=true;
        } else {
            $data['addmonthlyhealthcareexpensesinfo']=false;
        }
        $monthlyeducationexpensesinfo=DrMonthlyEducationExpenses::where('case_id',$id)->get()->pluck('case_id');
        if(isset($monthlyeducationexpensesinfo['0'])){
            $data['addmonthlyeducationexpensesinfo']=true;
        } else {
            $data['addmonthlyeducationexpensesinfo']=false;
        }
        $giftinheritanceinfo=DrGiftInheritance::where('case_id',$id)->get()->pluck('case_id');
        if(isset($giftinheritanceinfo['0'])){
            $data['addgiftinheritanceinfo']=true;
        } else {
            $data['addgiftinheritanceinfo']=false;
        }
        $monthlylivingexpensesinfo=DrMonthlyLivingExpenses::where('case_id',$id)->get()->pluck('case_id');
        if(isset($monthlylivingexpensesinfo['0'])){
            $data['addmonthlylivingexpensesinfo']=true;
        } else {
            $data['addmonthlylivingexpensesinfo']=false;
        }
        $monthlydebtpaymentsinfo=DrMonthlyDebtPayments::where('case_id',$id)->get()->pluck('case_id');
        if(isset($monthlydebtpaymentsinfo['0'])){
            $data['addmonthlydebtpaymentsinfo']=true;
        } else {
            $data['addmonthlydebtpaymentsinfo']=false;
        }
        $marriageinfo=DrMarriageInfo::where('case_id',$id)->get()->pluck('case_id');
        if(isset($marriageinfo['0'])){
            $data['addmarriageinfo']=true;
        } else {
            $data['addmarriageinfo']=false;
        }
        $spousalsupportthismarriage=DrSpousalSupportThisMarriage::where('case_id',$id)->get()->pluck('case_id');
        if(isset($spousalsupportthismarriage['0'])){
            $data['addspousalsupportthismarriageinfo']=true;
        } else {
            $data['addspousalsupportthismarriageinfo']=false;
        }
        $Num_MinorDependant_Children_of_this_Marriage=DrMarriageInfo::where('case_id',$id)->get()->pluck('Num_MinorDependant_Children_of_this_Marriage')->first();
        if(isset($Num_MinorDependant_Children_of_this_Marriage)){
            $data['ismarriageinfoset']=true;
            $monthlyexpenseschildrenofthismarriage=DrMonthlyExpensesChildrenOfThisMarriage::where('case_id',$id)->get()->pluck('case_id');
            $data['Num_MinorDependant_Children_of_this_Marriage']=$Num_MinorDependant_Children_of_this_Marriage;
            if(isset($monthlyexpenseschildrenofthismarriage['0'])){
                $data['addmonthlyexpenseschildrenofthismarriageinfo']=true;
            } else {
                $data['addmonthlyexpenseschildrenofthismarriageinfo']=false;
            }
        } else {
            $data['ismarriageinfoset']=false;
        }
        $fundsondeposit=DrFundsOnDeposit::where('case_id',$id)->get()->first();
        if(isset($fundsondeposit)){
            if(isset($drcaseoverview) && $drcaseoverview->Any_FOD==$fundsondeposit->Any_FOD && $drcaseoverview->Num_Joint_Deposit_Accounts==$fundsondeposit->Num_Joint_Deposit_Accounts && $drcaseoverview->Num_Client_Deposit_Accounts==$fundsondeposit->Num_Client_Deposit_Accounts && $drcaseoverview->Num_Op_Deposit_Accounts==$fundsondeposit->Num_Op_Deposit_Accounts){
                $data['addfundsondepositinfo']='true';
            } else {
                $data['addfundsondepositinfo']='update';
            }
        } else {
            $data['addfundsondepositinfo']=false;
            // $data['caseoverviewinfo']=false;
        }
        $stocksinvestments=DrStocksInvestments::where('case_id',$id)->get()->first();
        if(isset($stocksinvestments)){
            if(isset($drcaseoverview) && $drcaseoverview->Any_Stocks_Investments_Accounts==$stocksinvestments->Any_Stocks_Investments_Accounts && $drcaseoverview->Num_Joint_StocksInvestments_Accounts==$stocksinvestments->Num_Joint_StocksInvestments_Accounts && $drcaseoverview->Num_Client_StockInvestments_Accounts==$stocksinvestments->Num_Client_StockInvestments_Accounts && $drcaseoverview->Num_Op_StockInvestments_Accounts==$stocksinvestments->Num_Op_StockInvestments_Accounts){
                $data['addstocksinvestmentsinfo']='true';
            } else {
                $data['addstocksinvestmentsinfo']='update';
            }
        } else {
            $data['addstocksinvestmentsinfo']=false;
            // $data['caseoverviewinfo']=false;
        }
        $realestate=DrRealEstate::where('case_id',$id)->get()->first();
        if(isset($realestate)){
            if(isset($drcaseoverview) && $drcaseoverview->Any_Real_Estate==$realestate->Any_Real_Estate && $drcaseoverview->Num_Joint_Real_Estate_Properties==$realestate->Num_Joint_Real_Estate_Properties && $drcaseoverview->Num_Client_Real_Estate_Properties==$realestate->Num_Client_Real_Estate_Properties && $drcaseoverview->Num_Op_Real_Estate_Properties==$realestate->Num_Op_Real_Estate_Properties)
            {
                $data['addrealestateinfo']='true';
            } else {
                $data['addrealestateinfo']='update';
            }
        } else {
            $data['addrealestateinfo']=false;
            // $data['caseoverviewinfo']=false;
        }
        $retirementaccts=DrRetirementAccts::where('case_id',$id)->get()->first();
        if(isset($retirementaccts)){
            if(isset($drcaseoverview) && $drcaseoverview->Any_Retirement_Accts==$retirementaccts->Any_Retirement_Accts && $drcaseoverview->Num_Client_Retirement_Accts==$retirementaccts->Num_Client_Retirement_Accts && $drcaseoverview->Num_Op_Retirement_Accts==$retirementaccts->Num_Op_Retirement_Accts){
                $data['addretirementacctsinfo']='true';
            } else {
                $data['addretirementacctsinfo']='update';
            }
        } else {
            $data['addretirementacctsinfo']=false;
            // $data['caseoverviewinfo']=false;
        }
        $vehicles=DrVehicles::where('case_id',$id)->get()->first();
        if(isset($vehicles)){
            if(isset($drcaseoverview) && $drcaseoverview->Any_Vehicles==$vehicles->Any_Vehicles && $drcaseoverview->Num_Joint_Vehicles==$vehicles->Num_Joint_Vehicles && $drcaseoverview->Num_Client_Vehicles==$vehicles->Num_Client_Vehicles && $drcaseoverview->Num_Op_Vehicles==$vehicles->Num_Op_Vehicles){
                $data['addvehiclesinfo']='true';
            } else {
                $data['addvehiclesinfo']='update';
            }
        } else {
            $data['addvehiclesinfo']=false;
            // $data['caseoverviewinfo']=false;
        }
        $pensions=DrPension::where('case_id',$id)->get()->first();
        if(isset($pensions)){
            if(isset($drcaseoverview) && $drcaseoverview->Any_Pension==$pensions->Any_Pension && $drcaseoverview->Num_Client_Pensions==$pensions->Num_Client_Pensions && $drcaseoverview->Num_Op_Pensions==$pensions->Num_Op_Pensions){
                $data['addpensionsinfo']='true';
            } else {
                $data['addpensionsinfo']='update';
            }
        } else {
            $data['addpensionsinfo']=false;
            // $data['caseoverviewinfo']=false;
        }
        $income=DrIncome::where('case_id',$id)->get()->pluck('case_id');
        if(isset($income['0'])){
            $data['addincomeinfo']=true;
        } else {
            $data['addincomeinfo']=false;
        }

        return view('client.family_law_interview_tabs',['case_id'=>$id, 'data' => $data]);
    }
}