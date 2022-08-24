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
use App\Judge;
use App\Magistrate;
use App\Clerk;
use App\Attorney;
use App\AttorneyTableActiveBeforeEdit;
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
use App\ProspectCase;
use App\ProspectiveClientTable;

class CaseController extends Controller

{
    /* Show Cases List Based on logged in Attorney */
    public function index(Request $request)
    {
        if ($request->has('show')) {
            $show = $request->input('show');
            if ($show == 'non-hidden') {
                $data = Courtcase::where('attorney_id', Auth::user()->id)->whereNull('hidden_at')->orderBy('id', 'DESC')->get();
            } else if ($show == 'hidden') {
                $data = Courtcase::where('attorney_id', Auth::user()->id)->whereNotNull('hidden_at')->orderBy('id', 'DESC')->get();
            } else if ($show == 'active') {
                $data = Courtcase::where('attorney_id', Auth::user()->id)->whereNull('deactivated_at')->orderBy('id', 'DESC')->get();
            } else if ($show == 'deactivated') {
                $data = Courtcase::where('attorney_id', Auth::user()->id)->whereNotNull('deactivated_at')->orderBy('id', 'DESC')->get();
            } else {
                $data = Courtcase::where('attorney_id', Auth::user()->id)->orderBy('id', 'DESC')->get();
            }
        } else {
            $data = Courtcase::where('attorney_id', Auth::user()->id)->orderBy('id', 'DESC')->get();
        }
        //  dd($data);
        $client_data = array();
        $opponent_data = array();
        $state_data = array();
        $county_data = array();
        $court_data = array();
        $division_data = array();
        $i = 0;
        foreach ($data as $value) {
            //  dd($value->case_type_ids);
            // to check package upgrade is available or not
            $case_type_ids = explode(",", $value->case_type_ids);
if($value->case_type_ids !== '')
{
            $raw_query = '';
            foreach ($case_type_ids as $key => $case_type_id) {
                if ($key == '0') {
                    $raw_query .= " FIND_IN_SET(" . $case_type_id . ",case_type_ids) ";
                } else {
                    $raw_query .= " OR FIND_IN_SET(" . $case_type_id . ",case_type_ids) ";
                }
            }
            $package_data = DB::table("case_payment_packages")
                ->select("case_payment_packages.*")
                ->whereRaw($raw_query)
                ->where('active', '1')
                ->orderBy('package_price', 'ASC')
                ->distinct()
                ->get();

            $lastKey = $package_data->keys()->last();
            $data[$i]['is_package_upgrade_available'] = TRUE;
            if ($value->payment_status == '1' && $value->case_payment_package_id == NULL) {
                $data[$i]['is_package_upgrade_available'] = FALSE;
            }
            if ($value->payment_status == '1' && $lastKey && $value->case_payment_package_id == $package_data[$lastKey]->id) {
                $data[$i]['is_package_upgrade_available'] = FALSE;
            }
        }
        else{   $data[$i]['is_package_upgrade_available'] = TRUE;
            }
            // end to check package upgrade is available or not

            $client_id = DB::table('caseusers')
                ->where([['case_id', $value->id], ['type', 'client']])
                ->get()->pluck('user_id');
            if ($client_id && isset($client_id[0])) {
                $data[$i]['client_name'] = User::find($client_id[0])->name;
            } else {
                $data[$i]['client_name'] = '';
            }
            $opponent_id = DB::table('caseusers')
                ->where([['case_id', $value->id], ['type', 'opponent']])
                ->get()->pluck('user_id');
            if ($opponent_id && isset($opponent_id[0])) {
                $data[$i]['opponent_name'] = User::find($opponent_id[0])->name;
            } else {
                $data[$i]['opponent_name'] = '';
            }
            $ally_id = DB::table('caseusers')
                ->where([['case_id', $value->id], ['type', 'ally']])
                ->get()->pluck('user_id');
            if ($ally_id && isset($ally_id[0])) {
                $data[$i]['ally_name'] = User::find($ally_id[0])->name;
            } else {
                $data[$i]['ally_name'] = '';
            }
            if (isset($value->judge_id)) {
                $judge_name = DB::table('judges')
                    ->where('id', $value->judge_id)
                    ->get()->pluck('adjudicator');
                $data[$i]['judge_name'] = $judge_name[0];
            } else if (isset($value->judge_fullname)) {
                $data[$i]['judge_name'] = $value->judge_fullname;
            } else {
                $data[$i]['judge_name'] = '';
            }

            $data[$i]['state_name'] = State::find($value->state_id)->state;
            $data[$i]['county_name'] = County::find($value->county_id)->county_name;
            $data[$i]['court_name'] = Court::find($value->court_id)->name;
            $data[$i]['division_name'] = Division::find($value->division_id)->name;
            $drchildren = DrChildren::where('case_id', $value->id)->get()->pluck('This_Marriage_Custody_Arrangement');
            if (isset($drchildren['0'])) {
                $data[$i]['custody'] = $drchildren['0'];
            }

            // check if family interview completed
            $data[$i]['family_law_interview_done'] = true;
            $drcaseoverview = DrCaseOverview::where('case_id', $value->id)->get()->first();
            if (isset($drcaseoverview)) {
                // $data[$i]['family_law_interview_done']=true;

            } else {
                $data[$i]['family_law_interview_done'] = false;
                // $data['caseoverviewinfo']=false;
            }
            $personalinfo = DrPersonalInfo::where('case_id', $value->id)->get()->first();
            // $data['caseoverviewinfo']=true;
            if (isset($personalinfo)) {
                // $data[$i]['family_law_interview_done']=true;
                if (isset($drcaseoverview) && $drcaseoverview->Client_Info_Active_Military == $personalinfo->Client_Info_Active_Military && $drcaseoverview->Client_Branch == $personalinfo->Client_Branch && $drcaseoverview->SCRA_Prevents_Client == $personalinfo->SCRA_Prevents_Client && $drcaseoverview->Client_Waive_SCRA_Rights == $personalinfo->Client_Waive_SCRA_Rights && $drcaseoverview->Client_Possible_SCRA_Issues == $personalinfo->Client_Possible_SCRA_Issues && $drcaseoverview->Op_Info_Active_Military == $personalinfo->Op_Info_Active_Military && $drcaseoverview->Op_Branch == $personalinfo->Op_Branch && $drcaseoverview->SCRA_Prevents_Op == $personalinfo->SCRA_Prevents_Op && $drcaseoverview->Op_Waive_SCRA_Rights == $personalinfo->Op_Waive_SCRA_Rights && $drcaseoverview->Op_Possible_SCRA_Issues == $personalinfo->Op_Possible_SCRA_Issues) {
                } else {
                    $data[$i]['family_law_interview_done'] = false;
                }
            } else {
                $data[$i]['family_law_interview_done'] = false;
                // $data['caseoverviewinfo']=false;
            }
            $childreninfo = DrChildren::where('case_id', $value->id)->get()->first();
            if (isset($childreninfo)) {
                // $data[$i]['family_law_interview_done']=true;
                if (isset($drcaseoverview) && $drcaseoverview->Num_Children_ONLY_This_Marriage == $childreninfo->Num_Children_ONLY_This_Marriage && $drcaseoverview->Num_MinorDepChildren_ONLY_This_Marriage == $childreninfo->Num_MinorDepChildren_ONLY_This_Marriage && $drcaseoverview->Num_Client_Children_NOT_this_Marriage == $childreninfo->Num_Client_Children_NOT_this_Marriage && $drcaseoverview->Num_Op_Children_NOT_this_Marriage == $childreninfo->Num_Op_Children_NOT_this_Marriage) {
                } else {
                    $data[$i]['family_law_interview_done'] = false;
                }
            } else {
                $data[$i]['family_law_interview_done'] = false;
                // $data['caseoverviewinfo']=false;
            }
            $nsuranceinfo = DrInsurance::where('case_id', $value->id)->get()->pluck('case_id');
            if (isset($nsuranceinfo['0'])) {
                // $data[$i]['family_law_interview_done']=true;
            } else {
                $data[$i]['family_law_interview_done'] = false;
            }
            $temporaryordersinfo = DrTemporaryOrders::where('case_id', $value->id)->get()->pluck('case_id');
            if (isset($temporaryordersinfo['0'])) {
                // $data[$i]['family_law_interview_done']=true;
            } else {
                $data[$i]['family_law_interview_done'] = false;
            }
            $monthlyhousingexpensesinfo = DrMonthlyHousingExpenses::where('case_id', $value->id)->get()->pluck('case_id');
            if (isset($monthlyhousingexpensesinfo['0'])) {
                // $data[$i]['family_law_interview_done']=true;
            } else {
                $data[$i]['family_law_interview_done'] = false;
            }
            $monthlyhealthcareexpensesinfo = DrMonthlyHealthCareExpenses::where('case_id', $value->id)->get()->pluck('case_id');
            if (isset($monthlyhealthcareexpensesinfo['0'])) {
                // $data[$i]['family_law_interview_done']=true;
            } else {
                $data[$i]['family_law_interview_done'] = false;
            }
            $monthlyeducationexpensesinfo = DrMonthlyEducationExpenses::where('case_id', $value->id)->get()->pluck('case_id');
            if (isset($monthlyeducationexpensesinfo['0'])) {
                // $data[$i]['family_law_interview_done']=true;
            } else {
                $data[$i]['family_law_interview_done'] = false;
            }
            $giftinheritanceinfo = DrGiftInheritance::where('case_id', $value->id)->get()->pluck('case_id');
            if (isset($giftinheritanceinfo['0'])) {
                // $data[$i]['family_law_interview_done']=true;
            } else {
                $data[$i]['family_law_interview_done'] = false;
            }
            $monthlylivingexpensesinfo = DrMonthlyLivingExpenses::where('case_id', $value->id)->get()->pluck('case_id');
            if (isset($monthlylivingexpensesinfo['0'])) {
                // $data[$i]['family_law_interview_done']=true;
            } else {
                $data[$i]['family_law_interview_done'] = false;
            }
            $monthlydebtpaymentsinfo = DrMonthlyDebtPayments::where('case_id', $value->id)->get()->pluck('case_id');
            if (isset($monthlydebtpaymentsinfo['0'])) {
                // $data[$i]['family_law_interview_done']=true;
            } else {
                $data[$i]['family_law_interview_done'] = false;
            }
            $marriageinfo = DrMarriageInfo::where('case_id', $value->id)->get()->pluck('case_id');
            if (isset($marriageinfo['0'])) {
                // $data[$i]['family_law_interview_done']=true;
            } else {
                $data[$i]['family_law_interview_done'] = false;
            }
            $spousalsupportthismarriage = DrSpousalSupportThisMarriage::where('case_id', $value->id)->get()->pluck('case_id');
            if (isset($spousalsupportthismarriage['0'])) {
                // $data[$i]['family_law_interview_done']=true;
            } else {
                $data[$i]['family_law_interview_done'] = false;
            }
            $monthlyexpenseschildrenofthismarriage = DrMonthlyExpensesChildrenOfThisMarriage::where('case_id', $value->id)->get()->pluck('case_id');
            if (isset($monthlyexpenseschildrenofthismarriage['0'])) {
                // $data[$i]['family_law_interview_done']=true;
            } else {
                $data[$i]['family_law_interview_done'] = false;
            }

            $fundsondeposit = DrFundsOnDeposit::where('case_id', $value->id)->get()->first();
            if (isset($fundsondeposit)) {
                // $data[$i]['family_law_interview_done']=true;
                if (isset($drcaseoverview) && $drcaseoverview->Any_FOD == $fundsondeposit->Any_FOD && $drcaseoverview->Num_Joint_Deposit_Accounts == $fundsondeposit->Num_Joint_Deposit_Accounts && $drcaseoverview->Num_Client_Deposit_Accounts == $fundsondeposit->Num_Client_Deposit_Accounts && $drcaseoverview->Num_Op_Deposit_Accounts == $fundsondeposit->Num_Op_Deposit_Accounts) {
                } else {
                    $data[$i]['family_law_interview_done'] = false;
                }
            } else {
                $data[$i]['family_law_interview_done'] = false;
                // $data['caseoverviewinfo']=false;
            }
            $stocksinvestments = DrStocksInvestments::where('case_id', $value->id)->get()->first();
            if (isset($stocksinvestments)) {
                // $data[$i]['family_law_interview_done']=true;
                if (isset($drcaseoverview) && $drcaseoverview->Any_Stocks_Investments_Accounts == $stocksinvestments->Any_Stocks_Investments_Accounts && $drcaseoverview->Num_Joint_StocksInvestments_Accounts == $stocksinvestments->Num_Joint_StocksInvestments_Accounts && $drcaseoverview->Num_Client_StockInvestments_Accounts == $stocksinvestments->Num_Client_StockInvestments_Accounts && $drcaseoverview->Num_Op_StockInvestments_Accounts == $stocksinvestments->Num_Op_StockInvestments_Accounts) {
                } else {
                    $data[$i]['family_law_interview_done'] = false;
                }
            } else {
                $data[$i]['family_law_interview_done'] = false;
                // $data['caseoverviewinfo']=false;
            }
            $realestate = DrRealEstate::where('case_id', $value->id)->get()->first();
            if (isset($realestate)) {
                // $data[$i]['family_law_interview_done']=true;
                if (isset($drcaseoverview) && $drcaseoverview->Any_Real_Estate == $realestate->Any_Real_Estate && $drcaseoverview->Num_Joint_Real_Estate_Properties == $realestate->Num_Joint_Real_Estate_Properties && $drcaseoverview->Num_Client_Real_Estate_Properties == $realestate->Num_Client_Real_Estate_Properties && $drcaseoverview->Num_Op_Real_Estate_Properties == $realestate->Num_Op_Real_Estate_Properties) {
                } else {
                    $data[$i]['family_law_interview_done'] = false;
                }
            } else {
                $data[$i]['family_law_interview_done'] = false;
                // $data['caseoverviewinfo']=false;
            }
            $retirementaccts = DrRetirementAccts::where('case_id', $value->id)->get()->first();
            if (isset($retirementaccts)) {
                // $data[$i]['family_law_interview_done']=true;
                if (isset($drcaseoverview) && $drcaseoverview->Any_Retirement_Accts == $retirementaccts->Any_Retirement_Accts && $drcaseoverview->Num_Client_Retirement_Accts == $retirementaccts->Num_Client_Retirement_Accts && $drcaseoverview->Num_Op_Retirement_Accts == $retirementaccts->Num_Op_Retirement_Accts) {
                } else {
                    $data[$i]['family_law_interview_done'] = false;
                }
            } else {
                $data[$i]['family_law_interview_done'] = false;
                // $data['caseoverviewinfo']=false;
            }
            $vehicles = DrVehicles::where('case_id', $value->id)->get()->first();
            if (isset($vehicles)) {
                // $data[$i]['family_law_interview_done']=true;
                if (isset($drcaseoverview) && $drcaseoverview->Any_Vehicles == $vehicles->Any_Vehicles && $drcaseoverview->Num_Joint_Vehicles == $vehicles->Num_Joint_Vehicles && $drcaseoverview->Num_Client_Vehicles == $vehicles->Num_Client_Vehicles && $drcaseoverview->Num_Op_Vehicles == $vehicles->Num_Op_Vehicles) {
                } else {
                    $data[$i]['family_law_interview_done'] = false;
                }
            } else {
                $data[$i]['family_law_interview_done'] = false;
                // $data['caseoverviewinfo']=false;
            }
            $pensions = DrPension::where('case_id', $value->id)->get()->first();
            if (isset($pensions)) {
                // $data[$i]['family_law_interview_done']=true;
                if (isset($drcaseoverview) && $drcaseoverview->Any_Pension == $pensions->Any_Pension && $drcaseoverview->Num_Client_Pensions == $pensions->Num_Client_Pensions && $drcaseoverview->Num_Op_Pensions == $pensions->Num_Op_Pensions) {
                } else {
                    $data[$i]['family_law_interview_done'] = false;
                }
            } else {
                $data[$i]['family_law_interview_done'] = false;
                // $data['caseoverviewinfo']=false;
            }
            $income = DrIncome::where('case_id', $value->id)->get()->pluck('case_id');
            if (isset($income['0'])) {
                // $data[$i]['family_law_interview_done']=true;
            } else {
                $data[$i]['family_law_interview_done'] = false;
            }

            ++$i;
        }
        // die;
        // echo "<pre>";print_r($state_data);print_r($county_data);print_r($court_data);print_r($division_data);die;
        return view('case.index', ['data' => $data]);
    }

    public function show($id)
    {
    }

    public function create()
    {
        // return view('case.create');
        return view('case.create_case');
    }

    public function edit_case_data($id)
    {
        $data = array();
        $case_data = Courtcase::where([['id', $id], ['attorney_id', Auth::user()->id]])->get()->first();
        if (isset($case_data)) {
        } else {
            return redirect()->route('cases.index');
        }
        return view('case.edit_case_data', ['case_id' => $id, 'case_data' => $case_data]);
    }

    /* Show Family law interview tabs with status done/pending */
    public function familyLawInterviewData($id)
    {
        // $case_data=Courtcase::where([['id', $id],['attorney_id', Auth::user()->id]])->get()->first();
        // if(isset($case_data)){
        // } else {
        //     return redirect()->route('home');
        // }

        $user_role = Auth::user()->roles->first()->name;
        if ($user_role == 'client') {
            $client_attorney = Caseuser::where([['case_id', $id], ['user_id', Auth::user()->id]])->get()->pluck('attorney_id')->first();
            if ($client_attorney) {
                // $case_info=Courtcase::where([['id', $case_id],['attorney_id', $client_attorney]])->first();
                $case_data = Courtcase::where([['id', $id], ['attorney_id', $client_attorney]])->get()->first();
                if (isset($case_data)) {
                } else {
                    return redirect()->route('home');
                }
            } else {
                return redirect()->route('client.cases');
            }
        } else {
            $case_data = Courtcase::where([['id', $id], ['attorney_id', Auth::user()->id]])->get()->first();
            if (isset($case_data)) {
            } else {
                return redirect()->route('home');
            }
        }

        $data = array();
        $drcaseoverview = DrCaseOverview::where('case_id', $id)->get()->first();
        if (isset($drcaseoverview)) {
            $data['addcaseoverviewinfo'] = true;
        } else {
            $data['addcaseoverviewinfo'] = false;
            // $data['caseoverviewinfo']=false;
        }
        $personalinfo = DrPersonalInfo::where('case_id', $id)->get()->first();
        // $data['caseoverviewinfo']=true;
        if (isset($personalinfo)) {
            if (isset($drcaseoverview) && $drcaseoverview->Client_Info_Active_Military == $personalinfo->Client_Info_Active_Military && $drcaseoverview->Client_Branch == $personalinfo->Client_Branch && $drcaseoverview->SCRA_Prevents_Client == $personalinfo->SCRA_Prevents_Client && $drcaseoverview->Client_Waive_SCRA_Rights == $personalinfo->Client_Waive_SCRA_Rights && $drcaseoverview->Client_Possible_SCRA_Issues == $personalinfo->Client_Possible_SCRA_Issues && $drcaseoverview->Op_Info_Active_Military == $personalinfo->Op_Info_Active_Military && $drcaseoverview->Op_Branch == $personalinfo->Op_Branch && $drcaseoverview->SCRA_Prevents_Op == $personalinfo->SCRA_Prevents_Op && $drcaseoverview->Op_Waive_SCRA_Rights == $personalinfo->Op_Waive_SCRA_Rights && $drcaseoverview->Op_Possible_SCRA_Issues == $personalinfo->Op_Possible_SCRA_Issues) {
                $data['addpersonalinfo'] = 'true';
            } else {
                $data['addpersonalinfo'] = 'update';
            }
        } else {
            $data['addpersonalinfo'] = false;
            // $data['caseoverviewinfo']=false;
        }
        $childreninfo = DrChildren::where('case_id', $id)->get()->first();
        if (isset($childreninfo)) {
            if (
                isset($drcaseoverview) && $drcaseoverview->Num_Children_ONLY_This_Marriage == $childreninfo->Num_Children_ONLY_This_Marriage && $drcaseoverview->Num_MinorDepChildren_ONLY_This_Marriage == $childreninfo->Num_MinorDepChildren_ONLY_This_Marriage && $drcaseoverview->Num_Client_Children_NOT_this_Marriage == $childreninfo->Num_Client_Children_NOT_this_Marriage && $drcaseoverview->Num_Op_Children_NOT_this_Marriage == $childreninfo->Num_Op_Children_NOT_this_Marriage &&
                $drcaseoverview->Num_Children_Born_ONLY_These_Parties_Before_Marriage == $childreninfo->Num_Children_Born_ONLY_These_Parties_Before_Marriage && $drcaseoverview->Num_Children_Born_Emancipated_Not_Dep == $childreninfo->Num_Children_Born_Emancipated_Not_Dep && $drcaseoverview->Num_Children_Born_Disabled_Dependent == $childreninfo->Num_Children_Born_Disabled_Dependent && $drcaseoverview->Num_Children_Parenting_Support_Order == $childreninfo->Num_Children_Parenting_Support_Order && $drcaseoverview->Num_Children_This_Marriage == $childreninfo->Num_Children_This_Marriage
            ) {
                $data['addchildreninfo'] = 'true';
            } else {
                $data['addchildreninfo'] = 'update';
            }
        } else {
            $data['addchildreninfo'] = false;
            // $data['caseoverviewinfo']=false;
        }
        $nsuranceinfo = DrInsurance::where('case_id', $id)->get()->pluck('case_id');
        if (isset($nsuranceinfo['0'])) {
            $data['addinsuranceinfo'] = true;
        } else {
            $data['addinsuranceinfo'] = false;
        }
        $temporaryordersinfo = DrTemporaryOrders::where('case_id', $id)->get()->pluck('case_id');
        if (isset($temporaryordersinfo['0'])) {
            $data['addtemporaryordersinfo'] = true;
        } else {
            $data['addtemporaryordersinfo'] = false;
        }
        $monthlyhousingexpensesinfo = DrMonthlyHousingExpenses::where('case_id', $id)->get()->pluck('case_id');
        if (isset($monthlyhousingexpensesinfo['0'])) {
            $data['addmonthlyhousingexpensesinfo'] = true;
        } else {
            $data['addmonthlyhousingexpensesinfo'] = false;
        }
        $monthlyhealthcareexpensesinfo = DrMonthlyHealthCareExpenses::where('case_id', $id)->get()->pluck('case_id');
        if (isset($monthlyhealthcareexpensesinfo['0'])) {
            $data['addmonthlyhealthcareexpensesinfo'] = true;
        } else {
            $data['addmonthlyhealthcareexpensesinfo'] = false;
        }
        $monthlyeducationexpensesinfo = DrMonthlyEducationExpenses::where('case_id', $id)->get()->pluck('case_id');
        if (isset($monthlyeducationexpensesinfo['0'])) {
            $data['addmonthlyeducationexpensesinfo'] = true;
        } else {
            $data['addmonthlyeducationexpensesinfo'] = false;
        }
        $giftinheritanceinfo = DrGiftInheritance::where('case_id', $id)->get()->pluck('case_id');
        if (isset($giftinheritanceinfo['0'])) {
            $data['addgiftinheritanceinfo'] = true;
        } else {
            $data['addgiftinheritanceinfo'] = false;
        }
        $monthlylivingexpensesinfo = DrMonthlyLivingExpenses::where('case_id', $id)->get()->pluck('case_id');
        if (isset($monthlylivingexpensesinfo['0'])) {
            $data['addmonthlylivingexpensesinfo'] = true;
        } else {
            $data['addmonthlylivingexpensesinfo'] = false;
        }
        $monthlydebtpaymentsinfo = DrMonthlyDebtPayments::where('case_id', $id)->get()->pluck('case_id');
        if (isset($monthlydebtpaymentsinfo['0'])) {
            $data['addmonthlydebtpaymentsinfo'] = true;
        } else {
            $data['addmonthlydebtpaymentsinfo'] = false;
        }
        $marriageinfo = DrMarriageInfo::where('case_id', $id)->get()->pluck('case_id');
        if (isset($marriageinfo['0'])) {
            $data['addmarriageinfo'] = true;
        } else {
            $data['addmarriageinfo'] = false;
        }
        $spousalsupportthismarriage = DrSpousalSupportThisMarriage::where('case_id', $id)->get()->pluck('case_id');
        if (isset($spousalsupportthismarriage['0'])) {
            $data['addspousalsupportthismarriageinfo'] = true;
        } else {
            $data['addspousalsupportthismarriageinfo'] = false;
        }
        $Num_MinorDependant_Children_of_this_Marriage = DrMarriageInfo::where('case_id', $id)->get()->pluck('Num_MinorDependant_Children_of_this_Marriage')->first();
        if (isset($Num_MinorDependant_Children_of_this_Marriage)) {
            $data['ismarriageinfoset'] = true;
            $monthlyexpenseschildrenofthismarriage = DrMonthlyExpensesChildrenOfThisMarriage::where('case_id', $id)->get()->pluck('case_id');
            $data['Num_MinorDependant_Children_of_this_Marriage'] = $Num_MinorDependant_Children_of_this_Marriage;
            if (isset($monthlyexpenseschildrenofthismarriage['0'])) {
                $data['addmonthlyexpenseschildrenofthismarriageinfo'] = true;
            } else {
                $data['addmonthlyexpenseschildrenofthismarriageinfo'] = false;
            }
        } else {
            $data['ismarriageinfoset'] = false;
        }
        $fundsondeposit = DrFundsOnDeposit::where('case_id', $id)->get()->first();
        if (isset($fundsondeposit)) {
            if (isset($drcaseoverview) && $drcaseoverview->Any_FOD == $fundsondeposit->Any_FOD && $drcaseoverview->Num_Joint_Deposit_Accounts == $fundsondeposit->Num_Joint_Deposit_Accounts && $drcaseoverview->Num_Client_Deposit_Accounts == $fundsondeposit->Num_Client_Deposit_Accounts && $drcaseoverview->Num_Op_Deposit_Accounts == $fundsondeposit->Num_Op_Deposit_Accounts) {
                $data['addfundsondepositinfo'] = 'true';
            } else {
                $data['addfundsondepositinfo'] = 'update';
            }
        } else {
            $data['addfundsondepositinfo'] = false;
            // $data['caseoverviewinfo']=false;
        }
        $stocksinvestments = DrStocksInvestments::where('case_id', $id)->get()->first();
        if (isset($stocksinvestments)) {
            if (isset($drcaseoverview) && $drcaseoverview->Any_Stocks_Investments_Accounts == $stocksinvestments->Any_Stocks_Investments_Accounts && $drcaseoverview->Num_Joint_StocksInvestments_Accounts == $stocksinvestments->Num_Joint_StocksInvestments_Accounts && $drcaseoverview->Num_Client_StockInvestments_Accounts == $stocksinvestments->Num_Client_StockInvestments_Accounts && $drcaseoverview->Num_Op_StockInvestments_Accounts == $stocksinvestments->Num_Op_StockInvestments_Accounts) {
                $data['addstocksinvestmentsinfo'] = 'true';
            } else {
                $data['addstocksinvestmentsinfo'] = 'update';
            }
        } else {
            $data['addstocksinvestmentsinfo'] = false;
            // $data['caseoverviewinfo']=false;
        }
        $realestate = DrRealEstate::where('case_id', $id)->get()->first();
        if (isset($realestate)) {
            if (isset($drcaseoverview) && $drcaseoverview->Any_Real_Estate == $realestate->Any_Real_Estate && $drcaseoverview->Num_Joint_Real_Estate_Properties == $realestate->Num_Joint_Real_Estate_Properties && $drcaseoverview->Num_Client_Real_Estate_Properties == $realestate->Num_Client_Real_Estate_Properties && $drcaseoverview->Num_Op_Real_Estate_Properties == $realestate->Num_Op_Real_Estate_Properties) {
                $data['addrealestateinfo'] = 'true';
            } else {
                $data['addrealestateinfo'] = 'update';
            }
        } else {
            $data['addrealestateinfo'] = false;
            // $data['caseoverviewinfo']=false;
        }
        $retirementaccts = DrRetirementAccts::where('case_id', $id)->get()->first();
        if (isset($retirementaccts)) {
            if (isset($drcaseoverview) && $drcaseoverview->Any_Retirement_Accts == $retirementaccts->Any_Retirement_Accts && $drcaseoverview->Num_Client_Retirement_Accts == $retirementaccts->Num_Client_Retirement_Accts && $drcaseoverview->Num_Op_Retirement_Accts == $retirementaccts->Num_Op_Retirement_Accts) {
                $data['addretirementacctsinfo'] = 'true';
            } else {
                $data['addretirementacctsinfo'] = 'update';
            }
        } else {
            $data['addretirementacctsinfo'] = false;
            // $data['caseoverviewinfo']=false;
        }
        $vehicles = DrVehicles::where('case_id', $id)->get()->first();
        if (isset($vehicles)) {
            if (isset($drcaseoverview) && $drcaseoverview->Any_Vehicles == $vehicles->Any_Vehicles && $drcaseoverview->Num_Joint_Vehicles == $vehicles->Num_Joint_Vehicles && $drcaseoverview->Num_Client_Vehicles == $vehicles->Num_Client_Vehicles && $drcaseoverview->Num_Op_Vehicles == $vehicles->Num_Op_Vehicles) {
                $data['addvehiclesinfo'] = 'true';
            } else {
                $data['addvehiclesinfo'] = 'update';
            }
        } else {
            $data['addvehiclesinfo'] = false;
            // $data['caseoverviewinfo']=false;
        }
        $pensions = DrPension::where('case_id', $id)->get()->first();
        if (isset($pensions)) {
            if (isset($drcaseoverview) && $drcaseoverview->Any_Pension == $pensions->Any_Pension && $drcaseoverview->Num_Client_Pensions == $pensions->Num_Client_Pensions && $drcaseoverview->Num_Op_Pensions == $pensions->Num_Op_Pensions) {
                $data['addpensionsinfo'] = 'true';
            } else {
                $data['addpensionsinfo'] = 'update';
            }
        } else {
            $data['addpensionsinfo'] = false;
            // $data['caseoverviewinfo']=false;
        }
        $income = DrIncome::where('case_id', $id)->get()->first();
        if (isset($income)) {
            $data['addincomeinfo'] = true;
            $current_year = date("Y");
            $last_updated_year = date('Y', strtotime($income->updated_at));

            if ($current_year <= $last_updated_year) {
                $data['addincomeinfo'] = 'true';
            } else {
                $data['addincomeinfo'] = 'update';
            }
        } else {
            $data['addincomeinfo'] = false;
        }

        // to get client name
        // $client_id = DB::table('caseusers')
        //     ->where([['case_id', $id],['type', 'client']])
        //     ->get()->pluck('user_id');
        // if($client_id && isset($client_id[0])){
        //     $data['client_name']=User::find($client_id[0])->name;
        // } else {
        //     $data['client_name']='Client Name';
        // }

        $caseuser = DB::table('caseusers')
            ->join('users', 'caseusers.user_id', '=', 'users.id')
            ->where([['caseusers.case_id', $id], ['caseusers.party_group', 'top']])
            ->select('users.name', 'caseusers.party_entity', 'caseusers.mname', 'caseusers.org_comp_name')
            ->first();
        if (isset($caseuser->name)) {
            $data['client_name'] = $caseuser->name;
            if (isset($caseuser->party_entity) && $caseuser->party_entity == 'organization_company') {
                $data['client_name'] = $caseuser->org_comp_name;
            } else {
                $mname = $caseuser->mname;
                if (isset($mname) && $mname != '') {
                    $namearray = explode(' ', $caseuser->name, 2);
                    if (count($namearray) > 1) {
                        $data['client_name'] = $namearray[0] . ' ' . $mname . ' ' . $namearray[1];
                    } else {
                        $data['client_name'] = $caseuser->name . ' ' . $mname;
                    }
                }
            }
        } else {
            $data['client_name'] = 'ClientName';
        }

        return view('case.family_law_interview_tabs', ['case_id' => $id, 'data' => $data]);
    }

    /* Show edit case info form */
    public function edit($id)
    {

        $case_data = Courtcase::find($id);
        //return $case_data;

        if (!isset($case_data) || $case_data->attorney_id != Auth::user()->id) {
            return redirect()->route('cases.index');
        }
        $created_at = $case_data->created_at;
        $created_at = Carbon::parse($created_at)->toDateTimeString();
        $now = Carbon::now()->toDateTimeString();
        $to = Carbon::createFromFormat('Y-m-d H:i:s', $created_at);

        $from = Carbon::createFromFormat('Y-m-d H:i:s', $now);
        $totalDuration = $from->diffInHours($to);
        return view('case.edit_case', ['case_data' => $case_data]);
    }

    /* Show case payment form */
    public function getPaymentForm($id)
    {
        $case_details = Courtcase::find($id);
        if ($case_details && $case_details->attorney_id == Auth::user()->id) {
        } else {
            abort('404');
        }
        if ($case_details->payment_status == '1' && $case_details->case_payment_package_id != NULL) {
            return redirect()->route('cases.index');
            die('Payment Already done for this Case.');
        }
        $case_type_ids = explode(",", $case_details->case_type_ids);
        // $data = CasePaymentPackage::where('active', '1')->whereIn('id', $case_type_ids)->orderBy('id','ASC')->get();

        $raw_query = '';
        foreach ($case_type_ids as $key => $case_type_id) {
            if ($key == '0') {
                $raw_query .= "FIND_IN_SET(" . $case_type_id . ",case_type_ids)";
            } else {
                $raw_query .= " OR FIND_IN_SET(" . $case_type_id . ",case_type_ids)";
            }
        }
        $data = DB::table("case_payment_packages")
            ->select("case_payment_packages.*")
            ->whereRaw($raw_query)
            ->where('active', '1')
            ->orderBy('id', 'ASC')
            ->distinct()
            ->get();
        // SELECT * FROM case_payment_packages WHERE FIND_IN_SET(32,case_type_ids) OR FIND_IN_SET(33,case_type_ids) 
        return view('case.payment', ['case_packages' => $data, 'case_details' => $case_details, 'intent' => Auth::user()->createSetupIntent()]);
    }

    /* Create Charge for Case Payment */
    public function casePayment(Request $request)
    {
        $paymentMethod = $request->payment_method;
        $package_name = $request->package_name;
        $package_id = $request->package_id;
        $package_details = DB::table('case_payment_packages')
            ->where('id', $package_id)
            ->first();
        $package_price = $package_details->package_price;
        $amount = intval($package_price * 100);
        $case_type = $request->case_type;
        $case_id = $request->case_id;
        $court_case = Courtcase::find($case_id);
        $client_id = DB::table('caseusers')
            ->where([['case_id', $case_id], ['type', 'client']])
            ->get()->pluck('user_id');
        //$client=User::find($client_id);
        $user = User::find(Auth::user()->id);
        if (isset($court_case->case_number) && $court_case->case_number != '') {
            $case_number = $court_case->case_number;
            $des = '';
        } else if (isset($court_case->original_case_number) && $court_case->original_case_number != '') {
            $case_number = $court_case->original_case_number;
            $des = '';
        } else {
            $case_number = $case_id;
            $des = 'RECORD ';
        }
        $user->createOrGetStripeCustomer();



        $user->addPaymentMethod($paymentMethod);
        // if ($user->hasPaymentMethod()) {
        //     // $paymentMethods = $user->paymentMethods();
        //     $user->addPaymentMethod($paymentMethod);
        // } else {
        //     $user->addPaymentMethod($paymentMethod);
        // }
        // echo "<pre>"; print_r($user->paymentMethods());die;
        try {
            $payment = $user->charge($amount, $paymentMethod, [
                'metadata' => array(
                    'attorney_name' => $user->name,
                    'case_id' => $case_id,
                    'package_name' => $package_name,
                    'case_type' => $case_type
                ),
                'description' => 'CASE ' . $des . $case_number . ' REGISTERATION PAYMENT FOR AMOUNT $' . $package_price . ' DATED ' . date('m-d-Y') . ' BY ' . $user->name,
            ]);
            $court_case->payment_status = '1';
            $court_case->deactivated_at = NULL;
            $court_case->hidden_at = NULL;
            $court_case->case_payment_package_id = $package_id;
            $court_case->save();

            // to update case payment transaction history
            $history = array(
                'user_id' => $user->id,
                'case_id' => $case_id,
                'case_package_id' => $package_id,
                'amount' => $package_price,
                'stripe_transaction_id' => $payment->id,
                'description' => 'CASE ' . $des . $case_number . ' REGISTERATION PAYMENT FOR AMOUNT $' . $package_price . ' VIA TRANSACTION ID: ' . $payment->id . ' DATED ' . date('m-d-Y') . ' BY ' . $user->name,
                'created_at' => now(),
                'updated_at' => now(),
            );
            $case_payment_transaction_history = CasePaymentTransactionHistory::create($history);

            // $email_sent=Mail::to($client[0]->email)->send(new CaseRegistered());
            return redirect()->route('cases.index')->with('success', 'Thanks! Your case has been registered successfully.');
        } catch (Exception $e) {
            // return redirect()->back()->with('error', ['Something went Wrong. Please try again.']);   
            return redirect()->route('cases.index')->with('error', 'Something went Wrong. Please try again.');
        }
    }

    //  following functions are for new case registration steps
    /* Store case info */
    public function store_case(Request $request)
    {

        // to register case
        $case_state = $request->case_state;
        $case_county = $request->case_county;
        $case_court = $request->case_court;
        $case_division = $request->case_division;
        $case_action = $request->case_action;
        $case_judge = $request->case_judge;
        $case_type1 = 'NA';
        $case_type2 = 'NA';
        $case_type3 = 'NA';
        $case_type4 = 'NA';
        $case_type5 = 'NA';
        $case_type6 = 'NA';
        $case_type7 = 'NA';
        $case_type8 = 'NA';
        $case_type9 = 'NA';
        $case_type10 = 'NA';
        $coa1 = 'NA';
        $coa2 = 'NA';
        $coa3 = 'NA';
        $coa4 = 'NA';
        $coa5 = 'NA';
        $coa6 = 'NA';
        $coa7 = 'NA';
        $coa8 = 'NA';
        $coa9 = 'NA';
        $coa10 = 'NA';
        $case_type_id = 'case_type_id';
        $judge_fullname = NULL;
        $judge_title = 'Judge';
        $magistrate_fullname = NULL;
        $magistrate_title = 'Magistrate';
        if ($case_judge == 'other') {
            $case_judge = NULL;
            $judge_fullname = $request->judge_fullname;
            if ($request->judge_title) {
                $judge_title = $request->judge_title;
            }
        }
        $case_magistrate = $request->case_magistrate;
        if ($case_magistrate == 'other') {
            $case_magistrate = NULL;
            $magistrate_fullname = $request->magistrate_fullname;
            if ($request->magistrate_title) {
                $magistrate_title = $request->magistrate_title;
            }
        }

        $other_case_type = NULL;

        $case_type = $request->case_type;

        $case_types = '';
        $case_actions = '';
        $case_type_titles = NULL;
        $case_type_titles_array = DB::table('causes_of_action')
            ->whereIn('coa_id', $case_action)
            ->get()->pluck('primary_case_type')->all();
        $case_type_titles_array = array_unique($case_type_titles_array);
        $case_type_ids = DB::table('case_types')
            ->whereIn('case_type', $case_type_titles_array)
            ->get()->pluck('id')->all();
        if ($case_type_ids) {
            $case_types = array();
            $case_types = implode(",", $case_type_ids);
        }
        if ($case_action) {
            $case_actions = array();
            $case_actions = implode(",", $case_action);
            $case_action = DB::table('causes_of_action')
                ->whereIn('coa_id', $case_action)
                ->get()->pluck('coa')->all();
        }

        $case_type = $case_type_titles_array;

        if ($case_type_titles_array) {
            $case_type_titles = implode(",", $case_type_titles_array);
        }
        $num_case_types = 0;
        $num_coas = 0;


        if ($case_type) {
            $num_case_types = count($case_type);
            $i = 0;

            foreach ($case_type as $casetype) {

                /* if($casetype=='42'){
                    $other_case_type=$request->other_case_type;
                    if($other_case_type==''){
                        $other_case_type=NULL;
                    }
                }*/
                if ($i == 0) {
                    $case_type1 = $casetype;
                }
                if ($i == 1) {
                    $case_type2 = $casetype;
                }
                if ($i == 2) {
                    $case_type3 = $casetype;
                }
                if ($i == 3) {
                    $case_type4 = $casetype;
                }
                if ($i == 4) {
                    $case_type5 = $casetype;
                }
                if ($i == 5) {
                    $case_type6 = $casetype;
                }
                if ($i == 6) {
                    $case_type7 = $casetype;
                }
                if ($i == 7) {
                    $case_type8 = $casetype;
                }
                if ($i == 8) {
                    $case_type9 = $casetype;
                }
                if ($i == 9) {
                    $case_type10 = $casetype;
                }
                $i++;
            }
        }

        if ($case_action) {
            $num_coas = count($case_action);
            $i = 0;

            foreach ($case_action as $caseaction) {


                if ($i == 0) {
                    $coa1 = $caseaction;
                }
                if ($i == 1) {
                    $coa2 = $caseaction;
                }
                if ($i == 2) {
                    $coa3 = $caseaction;
                }
                if ($i == 3) {
                    $coa4 = $caseaction;
                }
                if ($i == 4) {
                    $coa5 = $caseaction;
                }
                if ($i == 5) {
                    $coa6 = $caseaction;
                }
                if ($i == 6) {
                    $coa7 = $caseaction;
                }
                if ($i == 7) {
                    $coa8 = $caseaction;
                }
                if ($i == 8) {
                    $coa9 = $caseaction;
                }
                if ($i == 9) {
                    $coa10 = $caseaction;
                }
                $i++;
            }
        }

        $jury_demand = $request->jury_demand;
        $case_sets = $request->case_sets;

        $initial_service_type = $request->initial_service_types;
        $initial_service_types = '';
        if ($initial_service_type) {
            $initial_service_types = array();
            foreach ($initial_service_type as $initialservicetype) {
                $initial_service_types[] = $initialservicetype;
            }
            $initial_service_types = implode(",", $initial_service_types);
        }

        $case_filing_status = $request->case_filing_status;

        $top_party_type = NULL;
        $number_top_party_type = NULL;
        $bottom_party_type = NULL;
        $number_bottom_party_type = NULL;
        $if_there_is_third_party_complaint = 'No';
        $number_top_third_parties = NULL;
        $number_bottom_third_parties = NULL;
        $court_case_number = NULL;
        $date_filed = NULL;
        $date_served = NULL;
        $final_hearing_date = NULL;


        $court_case_number = NULL;
        $original_court_case_number = NULL;
        $original_top_party_type = NULL;
        $original_number_top_party_type = NULL;
        $original_bottom_party_type = NULL;
        $original_number_bottom_party_type = NULL;
        $original_case_state = NULL;
        $original_case_county = NULL;
        $original_case_court = NULL;
        $original_case_division = NULL;
        $original_case_judge = NULL;
        $original_case_magistrate = NULL;
        $original_judge_fullname = NULL;
        $original_magistrate_fullname = NULL;
        $original_judge_title = 'Judge';
        $original_magistrate_title = 'Magistrate';
        $original_date_filed = NULL;
        $original_date_served = NULL;
        $original_final_hearing_date = NULL;
        $original_journalization_date = NULL;


        if ($case_filing_status == 'to_be_filed_new') {
            $top_party_type = $request->top_party_type;
            $number_top_party_type = $request->number_top_party_type;
            $bottom_party_type = $request->bottom_party_type;
            $number_bottom_party_type = $request->number_bottom_party_type;

            if (isset($request->if_there_is_third_party_complaint) && $request->if_there_is_third_party_complaint == 'Yes') {
                $if_there_is_third_party_complaint = $request->if_there_is_third_party_complaint;
                $number_top_third_parties = $request->number_top_third_parties;
                $number_bottom_third_parties = $request->number_bottom_third_parties;
            }
        }

        if ($case_filing_status == 'currently_filed') {
            $top_party_type = $request->top_party_type;
            $number_top_party_type = $request->number_top_party_type;
            $bottom_party_type = $request->bottom_party_type;
            $number_bottom_party_type = $request->number_bottom_party_type;
            $court_case_number = $request->court_case_number;

            if ($request->date_filed) {
                $date_filed = date("Y-m-d", strtotime($request->date_filed));
            } else {
                $date_filed = $request->date_filed;
            }

            if ($request->date_served) {
                $date_served = date("Y-m-d", strtotime($request->date_served));
            } else {
                $date_served = $request->date_served;
            }

            if ($request->final_hearing_date) {
                $final_hearing_date = date("Y-m-d", strtotime($request->final_hearing_date));
            } else {
                $final_hearing_date = $request->final_hearing_date;
            }

            if (isset($request->if_there_is_third_party_complaint) && $request->if_there_is_third_party_complaint == 'Yes') {
                $if_there_is_third_party_complaint = $request->if_there_is_third_party_complaint;
                $number_top_third_parties = $request->number_top_third_parties;
                $number_bottom_third_parties = $request->number_bottom_third_parties;
            }
        }

        if ($case_filing_status == 'prev_filed_refiling') {
            $court_case_number = $request->court_case_number;
            $original_court_case_number = $request->original_court_case_number;
            $original_top_party_type = $request->original_top_party_type;
            $original_number_top_party_type = $request->original_number_top_party_type;
            $original_bottom_party_type = $request->original_bottom_party_type;
            $original_number_bottom_party_type = $request->original_number_bottom_party_type;
            $original_case_state = $request->original_case_state;
            $original_case_county = $request->original_case_county;
            $original_case_court = $request->original_case_court;
            $original_case_division = $request->original_case_division;
            $original_case_judge = $request->original_case_judge;
            $original_case_magistrate = $request->original_case_magistrate;
            $original_judge_fullname = $request->original_judge_fullname;
            $original_magistrate_fullname = $request->original_magistrate_fullname;

            if ($request->original_judge_title) {
                $original_judge_title = $request->original_judge_title;
            }
            if ($request->original_magistrate_title) {
                $original_magistrate_title = $request->original_magistrate_title;
            }

            if ($request->original_date_filed) {
                $original_date_filed = date("Y-m-d", strtotime($request->original_date_filed));
            } else {
                $original_date_filed = $request->original_date_filed;
            }

            if ($request->original_date_served) {
                $original_date_served = date("Y-m-d", strtotime($request->original_date_served));
            } else {
                $original_date_served = $request->original_date_served;
            }
        }

        if ($case_filing_status == 'prev_filed_post_decree') {
            $court_case_number = $request->court_case_number;
            $original_court_case_number = $request->original_court_case_number;
            $original_top_party_type = $request->original_top_party_type;
            $original_number_top_party_type = $request->original_number_top_party_type;
            $original_bottom_party_type = $request->original_bottom_party_type;
            $original_number_bottom_party_type = $request->original_number_bottom_party_type;
            $original_case_state = $request->original_case_state;
            $original_case_county = $request->original_case_county;
            $original_case_court = $request->original_case_court;
            $original_case_division = $request->original_case_division;
            $original_case_judge = $request->original_case_judge;
            $original_case_magistrate = $request->original_case_magistrate;
            $original_judge_fullname = $request->original_judge_fullname;
            $original_magistrate_fullname = $request->original_magistrate_fullname;

            if ($request->original_judge_title) {
                $original_judge_title = $request->original_judge_title;
            }
            if ($request->original_magistrate_title) {
                $original_magistrate_title = $request->original_magistrate_title;
            }

            if ($request->original_date_filed) {
                $original_date_filed = date("Y-m-d", strtotime($request->original_date_filed));
            } else {
                $original_date_filed = $request->original_date_filed;
            }

            if ($request->original_date_served) {
                $original_date_served = date("Y-m-d", strtotime($request->original_date_served));
            } else {
                $original_date_served = $request->original_date_served;
            }

            if ($request->original_final_hearing_date) {
                $original_final_hearing_date = date("Y-m-d", strtotime($request->original_final_hearing_date));
            } else {
                $original_final_hearing_date = $request->original_final_hearing_date;
            }

            if ($request->original_journalization_date) {
                $original_journalization_date = date("Y-m-d", strtotime($request->original_journalization_date));
            } else {
                $original_journalization_date = $request->original_journalization_date;
            }

            if ($case_state == env('STATEID') && $case_county == '2049' && $case_court == '15' && $case_division == '8' && $case_types == '8') {
                $original_court_case_number = $court_case_number;
            }
        }

        if ($original_case_judge == 'other') {
            $original_case_judge = NULL;
        }
        if ($original_case_magistrate == 'other') {
            $original_case_magistrate = NULL;
        }

        // for new fields which were added later for improving views

        $courtcase_state_name = NULL;
        $courtcase_county_name = NULL;
        $court_name = NULL;
        $division_name = NULL;
        // $judge_name=NULL;
        // $magistrate_name=NULL;
        $courtcase_original_state_name = NULL;
        $courtcase_original_county_name = NULL;
        $original_court_name = NULL;
        $original_division_name = NULL;
        // $original_judge_name=NULL;
        // $original_magistrate_name=NULL;

        if ($case_state) {
            $courtcase_state_name = State::find($case_state)->state;
        }
        if ($case_county) {
            $courtcase_county_name = County::find($case_county)->county_name;
        }
        if ($case_court) {
            $court_name = Court::find($case_court)->name;
        }
        if ($case_division) {
            $division_name = Division::find($case_division)->name;
        }
        if ($case_judge) {
            $judge = Judge::find($case_judge);
            // $judge_name= $judge->adjudicator;
            $judge_fullname = $judge->adjudicator;
            $judge_title = $judge->adj_title;
        }
        if ($case_magistrate) {
            $magistrate = Magistrate::find($case_magistrate);
            // $magistrate_name= $magistrate->mag_name;
            $magistrate_fullname = $magistrate->mag_name;
            $magistrate_title = $magistrate->mag_title;
        }

        if ($original_case_state) {
            $courtcase_original_state_name = State::find($original_case_state)->state;
        }
        if ($original_case_county) {
            $courtcase_original_county_name = County::find($original_case_county)->county_name;
        }
        if ($original_case_court) {
            $original_court_name = Court::find($original_case_court)->name;
        }
        if ($original_case_division) {
            $original_division_name = Division::find($original_case_division)->name;
        }
        if ($original_case_judge) {
            $original_judge = Judge::find($original_case_judge);
            // $original_judge_name= $original_judge->adjudicator;
            $original_judge_fullname = $original_judge->adjudicator;
            $original_judge_title = $original_judge->adj_title;
        }
        if ($original_case_magistrate) {
            $original_magistrate = Magistrate::find($original_case_magistrate);
            // $original_magistrate_name= $original_magistrate->mag_name;
            $original_magistrate_fullname = $original_magistrate->mag_name;
            $original_magistrate_title = $original_magistrate->mag_title;
        }

        // court correlation table info
        $clerk_name = $request->clerk_name;
        $clerk_title = $request->clerk_title;
        if ($clerk_name == 'other') {
            $clerk_name = $request->clerk_fullname;
        }
        if ($clerk_title == 'other') {
            $clerk_title = $request->other_clerktitle;
        }

        $street_ad = $request->filing_location_street_ad;
        $address_too = $request->filing_location_address_too;
        $city = $request->filing_location_city;
        $zip = $request->filing_location_zip;
        $email = $request->email;
        $phone = $request->phone;
        $fax = $request->fax;

        $cap1 = NULL;
        $cap2 = NULL;
        $cap3 = NULL;
        $cap4 = NULL;
        $email_filing_allowed = NULL;
        $faxfile_allowed = NULL;
        $efile_mandatory = NULL;
        $Efile_Site = NULL;
        $case_website = NULL;
        $geographic_jurisdiction = NULL;
        $geo_jurisdiction_statute = NULL;
        $courttype = NULL;

        $court_correlation_table = DB::table('court_correlation_table')->where([['court_id', $case_court], ['division_id', $case_division]])->get()->first();
        if ($court_correlation_table) {
            $cap1 = $court_correlation_table->cap1;
            $cap2 = $court_correlation_table->cap2;
            $cap3 = $court_correlation_table->cap3;
            $cap4 = $court_correlation_table->cap4;
            $email_filing_allowed = $court_correlation_table->email_filing_allowed;
            $faxfile_allowed = $court_correlation_table->faxfile_allowed;
            $efile_mandatory = $court_correlation_table->efile_mandatory;
            $Efile_Site = $court_correlation_table->Efile_Site;
            $case_website = $court_correlation_table->case_website;
            $geographic_jurisdiction = $court_correlation_table->geographic_jurisdiction;
            $geo_jurisdiction_statute = $court_correlation_table->geo_jurisdiction_statute;
            $courttype = $court_correlation_table->courttype;
        }


        $case_array = array(
            'attorney_id' => Auth::user()->id,
            'state_id' => $case_state,
            'county_id' => $case_county,
            'court_id' => $case_court,
            'division_id' => $case_division,
            'judge_id' => $case_judge,
            'magistrate_id' => $case_magistrate,
            'case_type_ids' => $case_types,
            'case_type_titles' => $case_type_titles,
            'other_case_type' => $other_case_type,
            'judge_fullname' => $judge_fullname,
            'magistrate_fullname' => $magistrate_fullname,
            'jury_demand' => $jury_demand,
            'sets' => $case_sets,
            'initial_service_types' => $initial_service_types,
            'payment_status' => '0',
            'is_approved' => '0',
            'filing_type' => $case_filing_status,
            'top_party_type' => $top_party_type,
            'bottom_party_type' => $bottom_party_type,
            'number_top_party_type' => $number_top_party_type,
            'number_bottom_party_type' => $number_bottom_party_type,
            'if_there_is_third_party_complaint' => $if_there_is_third_party_complaint,
            'number_top_third_parties' => $number_top_third_parties,
            'number_bottom_third_parties' => $number_bottom_third_parties,
            'case_number' => $court_case_number,
            'date_filed' => $date_filed,
            'date_served' => $date_served,
            'final_hearing_date' => $final_hearing_date,
            'original_top_party_type' => $original_top_party_type,
            'original_bottom_party_type' => $original_bottom_party_type,
            'original_number_top_party_type' => $original_number_top_party_type,
            'original_number_bottom_party_type' => $original_number_bottom_party_type,
            'original_state_id' => $original_case_state,
            'original_county_id' => $original_case_county,
            'original_court_id' => $original_case_court,
            'original_division_id' => $original_case_division,
            'original_judge_id' => $original_case_judge,
            'original_magistrate_id' => $original_case_magistrate,
            'original_case_number' => $original_court_case_number,
            'original_date_filed' => $original_date_filed,
            'original_date_served' => $original_date_served,
            'original_final_hearing_date' => $original_final_hearing_date,
            'original_journalization_date' => $original_journalization_date,
            'original_judge_fullname' => $original_judge_fullname,
            'original_magistrate_fullname' => $original_magistrate_fullname,
            'created_at' => now(),
            'updated_at' => now(),
            'courtcase_state_name' => $courtcase_state_name,
            'courtcase_county_name' => $courtcase_county_name,
            'court_name' => $court_name,
            'division_name' => $division_name,
            // 'judge_name'=>$judge_name,
            // 'magistrate_name'=>$magistrate_name,
            'courtcase_original_state_name' => $courtcase_original_state_name,
            'courtcase_original_county_name' => $courtcase_original_county_name,
            'original_court_name' => $original_court_name,
            'original_division_name' => $original_division_name,
            // 'original_judge_name'=>$original_judge_name,
            // 'original_magistrate_name'=>$original_magistrate_name,

            'judge_title' => $judge_title,
            'magistrate_title' => $magistrate_title,
            'original_judge_title' => $original_judge_title,
            'original_magistrate_title' => $original_magistrate_title,
            'clerk_name' => $clerk_name,
            'clerk_title' => $clerk_title,
            'cap1' => $cap1,
            'cap2' => $cap2,
            'cap3' => $cap3,
            'cap4' => $cap4,
            'street_ad' => $street_ad,
            'address_too' => $address_too,
            'city' => $city,
            'zip' => $zip,
            'phone' => $phone,
            'fax' => $fax,
            'email' => $email,
            'email_filing_allowed' => $email_filing_allowed,
            'faxfile_allowed' => $faxfile_allowed,
            'efile_mandatory' => $efile_mandatory,
            'Efile_Site' => $Efile_Site,
            'case_website' => $case_website,
            'geographic_jurisdiction' => $geographic_jurisdiction,
            'geo_jurisdiction_statute' => $geo_jurisdiction_statute,
            'courttype' => $courttype,
            'case_type1' => $case_type1,
            'case_type2' => $case_type2,
            'case_type3' => $case_type3,
            'case_type4' => $case_type4,
            'case_type5' => $case_type5,
            'case_type6' => $case_type6,
            'case_type7' => $case_type7,
            'case_type8' => $case_type8,
            'case_type9' => $case_type9,
            'case_type10' => $case_type10,
            'num_case_types' => $num_case_types,
            'coa1' => $coa1,
            'coa2' => $coa2,
            'coa3' => $coa3,
            'coa4' => $coa4,
            'coa5' => $coa5,
            'coa6' => $coa6,
            'coa7' => $coa7,
            'coa8' => $coa8,
            'coa9' => $coa9,
            'coa10' => $coa10,
            'num_coas' => $num_coas,
            'coa_ids' => $case_actions

        );

        // echo "<pre>"; print_r($case_array);die;
        $courtcase = Courtcase::create($case_array);

        // add 5 credits to attorney account for new registered case. 
        $user = User::find(Auth::user()->id);
        $old_credits = $user->credits;
        $new_credits = $old_credits + 5;
        $user->credits = $new_credits;
        $user->save();

        // to update user credit history
        $history = array(
            'user_id' => $user->id,
            'source' => 'Case',
            'source_id' => $courtcase->id,
            'type' => 'credit',
            'number_of_credited_debited' => '5',
            'description' => ' 5 FDD CREDITS ADDED VIA CREATING NEW CASE ' . $courtcase->id . ' DATED ' . date('m-d-Y') . ' BY ' . $user->name,
            'created_at' => now(),
            'updated_at' => now(),
        );
        $user_credits_history = Usercredithistory::create($history);

        // to register case frpm prospect
        $prospect_id = $request->prospect_id;
        if (isset($prospect_id) && $prospect_id != '') {
            $prospect_data = array(
                'prospect_id' => $prospect_id,
                'case_id' => $courtcase->id
            );
            ProspectCase::create($prospect_data);
        }

        return redirect()->route('cases.show_party_reg_form', $courtcase->id);
    }

    /* Update case info */
    public function update_case(Request $request, $id)
    {
        //return $request->all();

        // to update case details

        $case_state = $request->case_state;
        $case_county = $request->case_county;
        $case_court = $request->case_court;
        $case_division = $request->case_division;
        $case_judge = $request->case_judge;
        $case_type1 = 'NA';
        $case_type2 = 'NA';
        $case_type3 = 'NA';
        $case_type4 = 'NA';
        $case_type5 = 'NA';
        $case_type6 = 'NA';
        $case_type7 = 'NA';
        $case_type8 = 'NA';
        $case_type9 = 'NA';
        $case_type10 = 'NA';
        $coa1 = 'NA';
        $coa2 = 'NA';
        $coa3 = 'NA';
        $coa4 = 'NA';
        $coa5 = 'NA';
        $coa6 = 'NA';
        $coa7 = 'NA';
        $coa8 = 'NA';
        $coa9 = 'NA';
        $coa10 = 'NA';
        $judge_fullname = NULL;
        $judge_title = 'Judge';
        $magistrate_fullname = NULL;
        $magistrate_title = 'Magistrate';
        if ($case_judge == 'other') {
            $case_judge = NULL;
            $judge_fullname = $request->judge_fullname;
            if ($request->judge_title) {
                $judge_title = $request->judge_title;
            }
        }
        $case_magistrate = $request->case_magistrate;
        if ($case_magistrate == 'other') {
            $case_magistrate = NULL;
            $magistrate_fullname = $request->magistrate_fullname;
            $magistrate_title = $request->magistrate_title;
            if ($request->magistrate_title) {
                $magistrate_title = $request->magistrate_title;
            }
        }
        $case_types = '';
        $case_actions = '';
        $other_case_type = NULL;

        $case_type = $request->case_types;
        $case_action = $request->case_action;
        $case_type_titles_array = DB::table('causes_of_action')
            ->whereIn('coa_id', $case_action)
            ->get()->pluck('primary_case_type')->all();
        $case_type_titles_array = array_unique($case_type_titles_array);
        $case_type_ids = DB::table('case_types')
            ->whereIn('case_type', $case_type_titles_array)
            ->get()->pluck('id')->all();
        /*$case_type = DB::table('case_types')
                         ->whereIn('case_type',$case_type_titles_array)
                         ->get()->pluck('id')->all();*/

        if ($case_type_ids) {
            $case_types = array();
            $case_types = implode(",", $case_type_ids);
        } else {
            return redirect()->route('cases.edit', $id)->with('error', 'Invalid master case type in database.');
        }
        if ($case_action) {
            $case_actions = array();
            $case_actions = implode(",", $case_action);
            $case_action = DB::table('causes_of_action')
                ->whereIn('coa_id', $case_action)
                ->get()->pluck('coa')->all();
        }
        $case_type_titles = NULL;
        if ($case_type_titles_array) {
            $case_type_titles = implode(",", $case_type_titles_array);
        }

        $case_type = $case_type_titles_array;
        $num_case_types = 0;
        $num_coas = 0;
        if ($case_type) {
            $i = 0;
            $num_case_types = count($case_type);

            foreach ($case_type as $casetype) {

                /*if($casetype=='42'){
                    $other_case_type=$request->other_case_type;
                    if($other_case_type==''){
                        $other_case_type=NULL;
                    }
                }*/
                if ($i == 0) {
                    $case_type1 = $casetype;
                }
                if ($i == 1) {
                    $case_type2 = $casetype;
                }
                if ($i == 2) {
                    $case_type3 = $casetype;
                }
                if ($i == 3) {
                    $case_type4 = $casetype;
                }
                if ($i == 4) {
                    $case_type5 = $casetype;
                }
                if ($i == 5) {
                    $case_type6 = $casetype;
                }
                if ($i == 6) {
                    $case_type7 = $casetype;
                }
                if ($i == 7) {
                    $case_type8 = $casetype;
                }
                if ($i == 8) {
                    $case_type9 = $casetype;
                }
                if ($i == 9) {
                    $case_type10 = $casetype;
                }
                $i++;
            }
        }

        if ($case_action) {
            $num_coas = count($case_action);
            $i = 0;

            foreach ($case_action as $caseaction) {

                if ($i == 0) {
                    $coa1 = $caseaction;
                }
                if ($i == 1) {
                    $coa2 = $caseaction;
                }
                if ($i == 2) {
                    $coa3 = $caseaction;
                }
                if ($i == 3) {
                    $coa4 = $caseaction;
                }
                if ($i == 4) {
                    $coa5 = $caseaction;
                }
                if ($i == 5) {
                    $coa6 = $caseaction;
                }
                if ($i == 6) {
                    $coa7 = $caseaction;
                }
                if ($i == 7) {
                    $coa8 = $caseaction;
                }
                if ($i == 8) {
                    $coa9 = $caseaction;
                }
                if ($i == 9) {
                    $coa10 = $caseaction;
                }
                $i++;
            }
        }

        $jury_demand = $request->jury_demand;
        $case_sets = $request->case_sets;
        $initial_service_type = $request->initial_service_types;
        $initial_service_types = '';
        if ($initial_service_type) {
            $initial_service_types = array();
            foreach ($initial_service_type as $initialservicetype) {
                $initial_service_types[] = $initialservicetype;
            }
            $initial_service_types = implode(",", $initial_service_types);
        }

        $case_filing_status = $request->case_filing_status;

        $top_party_type = NULL;
        $number_top_party_type = NULL;
        $bottom_party_type = NULL;
        $number_bottom_party_type = NULL;
        $if_there_is_third_party_complaint = 'No';
        $number_top_third_parties = NULL;
        $number_bottom_third_parties = NULL;
        $court_case_number = NULL;
        $date_filed = NULL;
        $date_served = NULL;
        $final_hearing_date = NULL;


        $court_case_number = NULL;
        $original_court_case_number = NULL;
        $original_top_party_type = NULL;
        $original_number_top_party_type = NULL;
        $original_bottom_party_type = NULL;
        $original_number_bottom_party_type = NULL;
        $original_case_state = NULL;
        $original_case_county = NULL;
        $original_case_court = NULL;
        $original_case_division = NULL;
        $original_case_judge = NULL;
        $original_case_magistrate = NULL;
        $original_judge_fullname = NULL;
        $original_magistrate_fullname = NULL;
        $original_date_filed = NULL;
        $original_date_served = NULL;
        $original_final_hearing_date = NULL;
        $original_journalization_date = NULL;
        $original_judge_title = 'Judge';
        $original_magistrate_title = 'Magistrate';


        if ($case_filing_status == 'to_be_filed_new') {
            $top_party_type = $request->top_party_type;
            $number_top_party_type = $request->number_top_party_type;
            $bottom_party_type = $request->bottom_party_type;
            $number_bottom_party_type = $request->number_bottom_party_type;
            if (isset($request->if_there_is_third_party_complaint) && $request->if_there_is_third_party_complaint == 'Yes') {
                $if_there_is_third_party_complaint = $request->if_there_is_third_party_complaint;
                $number_top_third_parties = $request->number_top_third_parties;
                $number_bottom_third_parties = $request->number_bottom_third_parties;
            }
        }

        if ($case_filing_status == 'currently_filed') {
            $top_party_type = $request->top_party_type;
            $number_top_party_type = $request->number_top_party_type;
            $bottom_party_type = $request->bottom_party_type;
            $number_bottom_party_type = $request->number_bottom_party_type;
            $court_case_number = $request->court_case_number;

            if ($request->date_filed) {
                $date_filed = date("Y-m-d", strtotime($request->date_filed));
            } else {
                $date_filed = $request->date_filed;
            }

            if ($request->date_served) {
                $date_served = date("Y-m-d", strtotime($request->date_served));
            } else {
                $date_served = $request->date_served;
            }

            if ($request->final_hearing_date) {
                $final_hearing_date = date("Y-m-d", strtotime($request->final_hearing_date));
            } else {
                $final_hearing_date = $request->final_hearing_date;
            }

            if (isset($request->if_there_is_third_party_complaint) && $request->if_there_is_third_party_complaint == 'Yes') {
                $if_there_is_third_party_complaint = $request->if_there_is_third_party_complaint;
                $number_top_third_parties = $request->number_top_third_parties;
                $number_bottom_third_parties = $request->number_bottom_third_parties;
            }
        }

        if ($case_filing_status == 'prev_filed_refiling') {
            $court_case_number = $request->court_case_number;
            $original_court_case_number = $request->original_court_case_number;
            $original_top_party_type = $request->original_top_party_type;
            $original_number_top_party_type = $request->original_number_top_party_type;
            $original_bottom_party_type = $request->original_bottom_party_type;
            $original_number_bottom_party_type = $request->original_number_bottom_party_type;
            $original_case_state = $request->original_case_state;
            $original_case_county = $request->original_case_county;
            $original_case_court = $request->original_case_court;
            $original_case_division = $request->original_case_division;
            $original_case_judge = $request->original_case_judge;
            $original_case_magistrate = $request->original_case_magistrate;
            $original_judge_fullname = $request->original_judge_fullname;
            $original_magistrate_fullname = $request->original_magistrate_fullname;

            if ($request->original_judge_title) {
                $original_judge_title = $request->original_judge_title;
            }
            if ($request->original_magistrate_title) {
                $original_magistrate_title = $request->original_magistrate_title;
            }

            if ($request->original_date_filed) {
                $original_date_filed = date("Y-m-d", strtotime($request->original_date_filed));
            } else {
                $original_date_filed = $request->original_date_filed;
            }

            if ($request->original_date_served) {
                $original_date_served = date("Y-m-d", strtotime($request->original_date_served));
            } else {
                $original_date_served = $request->original_date_served;
            }
        }

        if ($case_filing_status == 'prev_filed_post_decree') {
            $court_case_number = $request->court_case_number;
            $original_court_case_number = $request->original_court_case_number;
            $original_top_party_type = $request->original_top_party_type;
            $original_number_top_party_type = $request->original_number_top_party_type;
            $original_bottom_party_type = $request->original_bottom_party_type;
            $original_number_bottom_party_type = $request->original_number_bottom_party_type;
            $original_case_state = $request->original_case_state;
            $original_case_county = $request->original_case_county;
            $original_case_court = $request->original_case_court;
            $original_case_division = $request->original_case_division;
            $original_case_judge = $request->original_case_judge;
            $original_case_magistrate = $request->original_case_magistrate;
            $original_judge_fullname = $request->original_judge_fullname;
            $original_magistrate_fullname = $request->original_magistrate_fullname;

            if ($request->original_judge_title) {
                $original_judge_title = $request->original_judge_title;
            }
            if ($request->original_magistrate_title) {
                $original_magistrate_title = $request->original_magistrate_title;
            }

            if ($request->original_date_filed) {
                $original_date_filed = date("Y-m-d", strtotime($request->original_date_filed));
            } else {
                $original_date_filed = $request->original_date_filed;
            }

            if ($request->original_date_served) {
                $original_date_served = date("Y-m-d", strtotime($request->original_date_served));
            } else {
                $original_date_served = $request->original_date_served;
            }

            if ($request->original_final_hearing_date) {
                $original_final_hearing_date = date("Y-m-d", strtotime($request->original_final_hearing_date));
            } else {
                $original_final_hearing_date = $request->original_final_hearing_date;
            }

            if ($request->original_journalization_date) {
                $original_journalization_date = date("Y-m-d", strtotime($request->original_journalization_date));
            } else {
                $original_journalization_date = $request->original_journalization_date;
            }

            if ($case_state == env('STATEID') && $case_county == '2049' && $case_court == '15' && $case_division == '8' && $case_types == '8') {
                $original_court_case_number = $court_case_number;
            }
        }

        if ($original_case_judge == 'other') {
            $original_case_judge = NULL;
        }
        if ($original_case_magistrate == 'other') {
            $original_case_magistrate = NULL;
        }

        // for new fields which were added later for improving views

        $courtcase_state_name = NULL;
        $courtcase_county_name = NULL;
        $court_name = NULL;
        $division_name = NULL;
        // $judge_name=NULL;
        // $magistrate_name=NULL;
        $courtcase_original_state_name = NULL;
        $courtcase_original_county_name = NULL;
        $original_court_name = NULL;
        $original_division_name = NULL;
        // $original_judge_name=NULL;
        // $original_magistrate_name=NULL;

        if ($case_state) {
            $courtcase_state_name = State::find($case_state)->state;
        }
        if ($case_county) {
            $courtcase_county_name = County::find($case_county)->county_name;
        }
        if ($case_court) {
            $court_name = Court::find($case_court)->name;
        }
        if ($case_division) {
            $division_name = Division::find($case_division)->name;
        }
        if ($case_judge) {
            $judge = Judge::find($case_judge);
            // $judge_name= $judge->adjudicator;
            $judge_fullname = $judge->adjudicator;
            $judge_title = $judge->adj_title;
        }
        if ($case_magistrate) {
            $magistrate = Magistrate::find($case_magistrate);
            // $magistrate_name= $magistrate->mag_name;
            $magistrate_fullname = $magistrate->mag_name;
            $magistrate_title = $magistrate->mag_title;
        }

        if ($original_case_state) {
            $courtcase_original_state_name = State::find($original_case_state)->state;
        }
        if ($original_case_county) {
            $courtcase_original_county_name = County::find($original_case_county)->county_name;
        }
        if ($original_case_court) {
            $original_court_name = Court::find($original_case_court)->name;
        }
        if ($original_case_division) {
            $original_division_name = Division::find($original_case_division)->name;
        }
        if ($original_case_judge) {
            $original_judge = Judge::find($original_case_judge);
            // $original_judge_name= $original_judge->adjudicator;
            $original_judge_fullname = $original_judge->adjudicator;
            $original_judge_title = $original_judge->adj_title;
        }
        if ($original_case_magistrate) {
            $original_magistrate = Magistrate::find($original_case_magistrate);
            // $original_magistrate_name= $original_magistrate->mag_name;
            $original_magistrate_fullname = $original_magistrate->mag_name;
            $original_magistrate_title = $original_magistrate->mag_title;
        }

        // court correlation table info
        $clerk_name = $request->clerk_name;
        $clerk_title = $request->clerk_title;
        if ($clerk_name == 'other') {
            $clerk_name = $request->clerk_fullname;
        }
        if ($clerk_title == 'other') {
            $clerk_title = $request->other_clerktitle;
        }
        $street_ad = $request->filing_location_street_ad;
        $address_too = $request->filing_location_address_too;
        $city = $request->filing_location_city;
        $zip = $request->filing_location_zip;
        $email = $request->email;
        $phone = $request->phone;
        $fax = $request->fax;

        $cap1 = NULL;
        $cap2 = NULL;
        $cap3 = NULL;
        $cap4 = NULL;
        $email_filing_allowed = NULL;
        $faxfile_allowed = NULL;
        $efile_mandatory = NULL;
        $Efile_Site = NULL;
        $case_website = NULL;
        $geographic_jurisdiction = NULL;
        $geo_jurisdiction_statute = NULL;
        $courttype = NULL;

        $court_correlation_table = DB::table('court_correlation_table')->where([['court_id', $case_court], ['division_id', $case_division]])->get()->first();
        if ($court_correlation_table) {
            $cap1 = $court_correlation_table->cap1;
            $cap2 = $court_correlation_table->cap2;
            $cap3 = $court_correlation_table->cap3;
            $cap4 = $court_correlation_table->cap4;
            $email_filing_allowed = $court_correlation_table->email_filing_allowed;
            $faxfile_allowed = $court_correlation_table->faxfile_allowed;
            $efile_mandatory = $court_correlation_table->efile_mandatory;
            $Efile_Site = $court_correlation_table->Efile_Site;
            $case_website = $court_correlation_table->case_website;
            $geographic_jurisdiction = $court_correlation_table->geographic_jurisdiction;
            $geo_jurisdiction_statute = $court_correlation_table->geo_jurisdiction_statute;
            $courttype = $court_correlation_table->courttype;
        }


        $court_case = Courtcase::find($id);
        $court_case->attorney_id = Auth::user()->id;
        $court_case->state_id = $case_state;
        $court_case->county_id = $case_county;
        $court_case->court_id = $case_court;
        $court_case->division_id = $case_division;
        $court_case->judge_id = $case_judge;
        $court_case->magistrate_id = $case_magistrate;
        $court_case->case_type_ids = $case_types;
        $court_case->case_type_titles = $case_type_titles;
        $court_case->other_case_type = $other_case_type;
        $court_case->judge_fullname = $judge_fullname;
        $court_case->magistrate_fullname = $magistrate_fullname;
        $court_case->jury_demand = $jury_demand;
        $court_case->sets = $case_sets;
        $court_case->initial_service_types = $initial_service_types;
        $court_case->filing_type = $case_filing_status;
        $court_case->top_party_type = $top_party_type;
        $court_case->bottom_party_type = $bottom_party_type;
        $court_case->number_top_party_type = $number_top_party_type;
        $court_case->number_bottom_party_type = $number_bottom_party_type;
        $court_case->if_there_is_third_party_complaint = $if_there_is_third_party_complaint;
        $court_case->number_top_third_parties = $number_top_third_parties;
        $court_case->number_bottom_third_parties = $number_bottom_third_parties;
        $court_case->case_number = $court_case_number;
        $court_case->date_filed = $date_filed;
        $court_case->date_served = $date_served;
        $court_case->final_hearing_date = $final_hearing_date;
        $court_case->original_top_party_type = $original_top_party_type;
        $court_case->original_bottom_party_type = $original_bottom_party_type;
        $court_case->original_number_top_party_type = $original_number_top_party_type;
        $court_case->original_number_bottom_party_type = $original_number_bottom_party_type;
        $court_case->original_state_id = $original_case_state;
        $court_case->original_county_id = $original_case_county;
        $court_case->original_court_id = $original_case_court;
        $court_case->original_division_id = $original_case_division;
        $court_case->original_judge_id = $original_case_judge;
        $court_case->original_magistrate_id = $original_case_magistrate;
        $court_case->original_case_number = $original_court_case_number;
        $court_case->original_date_filed = $original_date_filed;
        $court_case->original_date_served = $original_date_served;
        $court_case->original_final_hearing_date = $original_final_hearing_date;
        $court_case->original_journalization_date = $original_journalization_date;
        $court_case->original_judge_fullname = $original_judge_fullname;
        $court_case->original_magistrate_fullname = $original_magistrate_fullname;
        $court_case->updated_at = now();
        $court_case->short_caption = $request->short_caption;

        $court_case->courtcase_state_name = $courtcase_state_name;
        $court_case->courtcase_county_name = $courtcase_county_name;
        $court_case->court_name = $court_name;
        $court_case->division_name = $division_name;
        // $court_case->judge_name=$judge_name;
        // $court_case->magistrate_name=$magistrate_name;
        $court_case->courtcase_original_state_name = $courtcase_original_state_name;
        $court_case->courtcase_original_county_name = $courtcase_original_county_name;
        $court_case->original_court_name = $original_court_name;
        $court_case->original_division_name = $original_division_name;
        // $court_case->original_judge_name=$original_judge_name;
        // $court_case->original_magistrate_name=$original_magistrate_name;

        $court_case->judge_title = $judge_title;
        $court_case->magistrate_title = $magistrate_title;
        $court_case->original_judge_title = $original_judge_title;
        $court_case->original_magistrate_title = $original_magistrate_title;
        $court_case->clerk_name = $clerk_name;
        $court_case->clerk_title = $clerk_title;
        $court_case->cap1 = $cap1;
        $court_case->cap2 = $cap2;
        $court_case->cap3 = $cap3;
        $court_case->cap4 = $cap4;
        $court_case->street_ad = $street_ad;
        $court_case->address_too = $address_too;
        $court_case->city = $city;
        $court_case->zip = $zip;
        $court_case->phone = $phone;
        $court_case->fax = $fax;
        $court_case->email = $email;
        $court_case->email_filing_allowed = $email_filing_allowed;
        $court_case->faxfile_allowed = $faxfile_allowed;
        $court_case->efile_mandatory = $efile_mandatory;
        $court_case->Efile_Site = $Efile_Site;
        $court_case->case_website = $case_website;
        $court_case->geographic_jurisdiction = $geographic_jurisdiction;
        $court_case->geo_jurisdiction_statute = $geo_jurisdiction_statute;
        $court_case->courttype = $courttype;
        $court_case->case_type1 = $case_type1;
        $court_case->case_type2 = $case_type2;
        $court_case->case_type3 = $case_type3;
        $court_case->case_type4 = $case_type4;
        $court_case->case_type5 = $case_type5;
        $court_case->case_type6 = $case_type6;
        $court_case->case_type7 = $case_type7;
        $court_case->case_type8 = $case_type8;
        $court_case->case_type9 = $case_type9;
        $court_case->case_type10 = $case_type10;
        $court_case->num_case_types = $num_case_types;

        $court_case->coa1 = $coa1;
        $court_case->coa2 = $coa2;
        $court_case->coa3 = $coa3;
        $court_case->coa4 = $coa4;
        $court_case->coa5 = $coa5;
        $court_case->coa6 = $coa6;
        $court_case->coa7 = $coa7;
        $court_case->coa8 = $coa8;
        $court_case->coa9 = $coa9;
        $court_case->coa10 = $coa10;
        $court_case->num_coas = $num_coas;
        $court_case->coa_ids = $case_actions;
        // echo "<pre>"; print_r($court_case);die;
        $court_case->save();

        // short caption
        $short_caption = '';
        $case_id = $id;
        $court_case_data = Courtcase::find($case_id);
        if (isset($court_case_data->top_party_type)) {
            $top_party_type = $court_case_data->top_party_type;
            $bottom_party_type = $court_case_data->bottom_party_type;
        } else {
            $top_party_type = $court_case_data->original_top_party_type;
            $bottom_party_type = $court_case_data->original_bottom_party_type;
        }

        $caseusersclienttop = Caseuser::where([['case_id', $case_id], ['party_group', 'top']])->get()->all();
        $count_caseusersclienttop = count($caseusersclienttop);
        if ($count_caseusersclienttop) {

            if (isset($caseusersclienttop[0]->party_entity) && $caseusersclienttop[0]->party_entity == 'organization_company' && isset($caseusersclienttop[0]->org_comp_name)) {
                $short_caption = $caseusersclienttop[0]->org_comp_name;
                $short_caption .= " Corporation";
            } else {
                $short_caption = $caseusersclienttop[0]->lname;
            }
            if ($count_caseusersclienttop > 1) {
                $short_caption .= ', et al.';
            }
        }

        $caseusersclientbottom = Caseuser::where([['case_id', $case_id], ['party_group', 'bottom']])->get()->all();
        $count_caseusersclientbottom = count($caseusersclientbottom);
        if ($count_caseusersclientbottom) {
            if (isset($caseusersclientbottom[0]->party_entity) && $caseusersclientbottom[0]->party_entity == 'organization_company' && isset($caseusersclientbottom[0]->org_comp_name)) {
                $bottom_party_lname = $caseusersclientbottom[0]->org_comp_name;
                $bottom_party_lname .= " Corporation";
            } else {
                $bottom_party_lname = $caseusersclientbottom[0]->lname;
            }
            if (isset($court_case_data->case_type_ids) && ($court_case_data->case_type_ids == '1' || $court_case_data->case_type_ids == '2')) {
                $short_caption .= " and " . $bottom_party_lname;
            } else {
                $short_caption .= " v " . $bottom_party_lname;
            }
            if ($count_caseusersclientbottom > 1) {
                $short_caption .= ', et al.';
            }
        }
        if ($request->short_caption) {
            $court_case_data->short_caption = $request->short_caption;
        } else {
            $court_case_data->short_caption = $short_caption;
        }


        $court_case_data->save();
        // end short caption

        return redirect()->route('cases.edit', $court_case->id)->with('success', 'Your case details are updated successfully.');
    }

    /* Show case party reg form */
    public function show_party_reg_form($id)
    {
        $case_data = Courtcase::find($id);
        if (isset($case_data) && $case_data->attorney_id == Auth::user()->id) {
            $hascaseid = 0;
            $case_type_ids = explode(",", $case_data->case_type_ids);
            $array = array('1', '2', '3', '4', '5', '6', '7', '8', '9', '49', '50', '51', '52');
            $hascaseid = !empty(array_intersect($array, $case_type_ids));

            $case_data['total_top_parties'] = '0';
            $case_data['total_bottom_parties'] = '0';
            $already_client_top = '0';
            $user_ids_top = Caseuser::where([['case_id', $id], ['party_group', 'top']])->get()->pluck('user_id')->all();
            $user_ids_bottom = Caseuser::where([['case_id', $id], ['party_group', 'bottom']])->get()->pluck('user_id')->all();
            if ($user_ids_top) {
                $top_party_data = array();
                // $top_party_data=User::whereIn('id', $user_ids_top)->get();
                $i = 0;
                $case_data['total_top_parties'] = count($user_ids_top);
                foreach ($user_ids_top as $user_id) {

                    $top_party_data[] = User::where('id', $user_id)->get()->first();
                    // $user_types=Caseuser::where([['case_id', $id],['user_id', $user_id]])->first();
                    $user_types = DB::table('caseusers')
                        //->join('states', 'caseusers.state_id', '=', 'states.id')
                        //->join('counties', [['caseusers.county_id', '=', 'counties.id'],['caseusers.state_id', '=', 'counties.state_id']])
                        ->where([['case_id', $id], ['user_id', $user_id]])
                        // ->select('caseusers.telephone','caseusers.type','caseusers.party_group','caseusers.user_city', 'caseusers.state_id','states.state', 'counties.id','counties.county_name')
                        ->get();
                    $top_party_data[$i]['telephone'] = $user_types[0]->telephone;
                    $top_party_data[$i]['type'] = $user_types[0]->type;
                    $top_party_data[$i]['party_group'] = $user_types[0]->party_group;
                    $top_party_data[$i]['city'] = $user_types[0]->user_city;

                    if (isset($user_types[0]->state_id) && $user_types[0]->state_id != '') {
                        $top_party_data[$i]['state'] = DB::table('states')->where('id', $user_types[0]->state_id)->get()->pluck('state')->first();
                    } else {
                        $top_party_data[$i]['state'] = NULL;
                    }
                    if (isset($user_types[0]->county_id) && $user_types[0]->county_id != '') {
                        $top_party_data[$i]['county'] = DB::table('counties')->where('id', $user_types[0]->county_id)->get()->pluck('county_name')->first();
                    } else {
                        $top_party_data[$i]['county'] = '';
                    }
                    // $top_party_data[$i]['state']=$user_types[0]->state;
                    // $top_party_data[$i]['county']=$user_types[0]->county_name;

                    $attorney_ids = Partyattorney::where([['party_id', $user_id], ['case_id', $id]])->get();
                    if ($attorney_ids) {
                        $top_party_data[$i]['total_attornies'] = count($attorney_ids);
                    } else {
                        $top_party_data[$i]['total_attornies'] = 0;
                    }

                    if ($user_types[0]->type == 'client') {
                        $already_client_top = '1';
                    }

                    ++$i;
                }
            }
            $already_client_bottom = '0';
            if ($user_ids_bottom) {
                $bottom_party_data = array();
                // $bottom_party_data=User::whereIn('id', $user_ids_bottom)->get();
                $i = 0;
                $case_data['total_bottom_parties'] = count($user_ids_bottom);
                foreach ($user_ids_bottom as $user_id) {

                    $bottom_party_data[] = User::where('id', $user_id)->get()->first();
                    // $user_types=Caseuser::where([['case_id', $id],['user_id', $user_id]])->first();
                    $user_types = DB::table('caseusers')
                        // ->join('states', 'caseusers.state_id', '=', 'states.id')
                        // ->join('counties', [['caseusers.county_id', '=', 'counties.id'],['caseusers.state_id', '=', 'counties.state_id']])
                        ->where([['case_id', $id], ['user_id', $user_id]])
                        // ->select('caseusers.telephone','caseusers.type','caseusers.party_group','caseusers.user_city', 'caseusers.state_id','states.state', 'counties.id','counties.county_name')
                        ->get();
                    $bottom_party_data[$i]['telephone'] = $user_types[0]->telephone;
                    $bottom_party_data[$i]['type'] = $user_types[0]->type;
                    $bottom_party_data[$i]['party_group'] = $user_types[0]->party_group;
                    $bottom_party_data[$i]['city'] = $user_types[0]->user_city;
                    if (isset($user_types[0]->state_id) && $user_types[0]->state_id != '') {
                        $bottom_party_data[$i]['state'] = DB::table('states')->where('id', $user_types[0]->state_id)->get()->pluck('state')->first();
                    } else {
                        $bottom_party_data[$i]['state'] = NULL;
                    }
                    if (isset($user_types[0]->county_id) && $user_types[0]->county_id != '') {
                        $bottom_party_data[$i]['county'] = DB::table('counties')->where('id', $user_types[0]->county_id)->get()->pluck('county_name')->first();
                    } else {
                        $bottom_party_data[$i]['county'] = '';
                    }

                    $attorney_ids = Partyattorney::where([['party_id', $user_id], ['case_id', $id]])->get();
                    if ($attorney_ids) {
                        $bottom_party_data[$i]['total_attornies'] = count($attorney_ids);
                    } else {
                        $bottom_party_data[$i]['total_attornies'] = 0;
                    }
                    if ($user_types[0]->type == 'client') {
                        $already_client_bottom = '1';
                    }

                    ++$i;
                }
            }

            // for third parties
            $user_ids_top_third = Caseuser::where([['case_id', $id], ['party_group', 'top_third']])->get()->pluck('user_id')->all();
            $user_ids_bottom_third = Caseuser::where([['case_id', $id], ['party_group', 'bottom_third']])->get()->pluck('user_id')->all();
            $top_third_party_data = array();
            if ($user_ids_top_third) {
                // $top_third_party_data=User::whereIn('id', $user_ids_top_third)->get();
                $i = 0;
                $case_data['total_top_third_parties'] = count($user_ids_top_third);
                foreach ($user_ids_top_third as $user_id) {

                    $top_third_party_data[] = User::where('id', $user_id)->get()->first();
                    // $user_types=Caseuser::where([['case_id', $id],['user_id', $user_id]])->first();
                    $user_types = DB::table('caseusers')
                        // ->join('states', 'caseusers.state_id', '=', 'states.id')
                        // ->join('counties', [['caseusers.county_id', '=', 'counties.id'],['caseusers.state_id', '=', 'counties.state_id']])
                        ->where([['case_id', $id], ['user_id', $user_id]])
                        // ->select('caseusers.telephone','caseusers.type','caseusers.party_group','caseusers.user_city', 'caseusers.state_id','states.state', 'counties.id','counties.county_name')
                        ->get();
                    $top_third_party_data[$i]['telephone'] = $user_types[0]->telephone;
                    $top_third_party_data[$i]['type'] = $user_types[0]->type;
                    $top_third_party_data[$i]['party_group'] = $user_types[0]->party_group;
                    $top_third_party_data[$i]['city'] = $user_types[0]->user_city;
                    if (isset($user_types[0]->state_id) && $user_types[0]->state_id != '') {
                        $top_third_party_data[$i]['state'] = DB::table('states')->where('id', $user_types[0]->state_id)->get()->pluck('state')->first();
                    } else {
                        $top_third_party_data[$i]['state'] = NULL;
                    }
                    if (isset($user_types[0]->county_id) && $user_types[0]->county_id != '') {
                        $top_third_party_data[$i]['county'] = DB::table('counties')->where('id', $user_types[0]->county_id)->get()->pluck('county_name')->first();
                    } else {
                        $top_third_party_data[$i]['county'] = '';
                    }

                    $attorney_ids = Partyattorney::where([['party_id', $user_id], ['case_id', $id]])->get();
                    if ($attorney_ids) {
                        $top_third_party_data[$i]['total_attornies'] = count($attorney_ids);
                    } else {
                        $top_third_party_data[$i]['total_attornies'] = 0;
                    }

                    ++$i;
                }
            }
            $bottom_third_party_data = array();
            if ($user_ids_bottom_third) {
                // $bottom_third_party_data=User::whereIn('id', $user_ids_bottom_third)->get();
                $i = 0;
                $case_data['total_bottom_third_parties'] = count($user_ids_bottom_third);
                foreach ($user_ids_bottom_third as $user_id) {

                    $bottom_third_party_data[] = User::where('id', $user_id)->get()->first();
                    // $user_types=Caseuser::where([['case_id', $id],['user_id', $user_id]])->first();
                    $user_types = DB::table('caseusers')
                        // ->join('states', 'caseusers.state_id', '=', 'states.id')
                        // ->join('counties', [['caseusers.county_id', '=', 'counties.id'],['caseusers.state_id', '=', 'counties.state_id']])
                        ->where([['case_id', $id], ['user_id', $user_id]])
                        // ->select('caseusers.telephone','caseusers.type','caseusers.party_group','caseusers.user_city', 'caseusers.state_id','states.state', 'counties.id','counties.county_name')
                        ->get();
                    $bottom_third_party_data[$i]['telephone'] = $user_types[0]->telephone;
                    $bottom_third_party_data[$i]['type'] = $user_types[0]->type;
                    $bottom_third_party_data[$i]['party_group'] = $user_types[0]->party_group;
                    $bottom_third_party_data[$i]['city'] = $user_types[0]->user_city;
                    if (isset($user_types[0]->state_id) && $user_types[0]->state_id != '') {
                        $bottom_third_party_data[$i]['state'] = DB::table('states')->where('id', $user_types[0]->state_id)->get()->pluck('state')->first();
                    } else {
                        $bottom_third_party_data[$i]['state'] = NULL;
                    }
                    if (isset($user_types[0]->county_id) && $user_types[0]->county_id != '') {
                        $bottom_third_party_data[$i]['county'] = DB::table('counties')->where('id', $user_types[0]->county_id)->get()->pluck('county_name')->first();
                    } else {
                        $bottom_third_party_data[$i]['county'] = '';
                    }

                    $attorney_ids = Partyattorney::where([['party_id', $user_id], ['case_id', $id]])->get();
                    if ($attorney_ids) {
                        $bottom_third_party_data[$i]['total_attornies'] = count($attorney_ids);
                    } else {
                        $bottom_third_party_data[$i]['total_attornies'] = 0;
                    }

                    ++$i;
                }
            }

            // to fetch case prospect details if any
            $case_prospect = ProspectCase::where('case_id', $id)->get()->first();
            if ($case_prospect) {
                $prospect_client = ProspectiveClientTable::find($case_prospect->prospect_id);
            }

            if ($user_ids_top && $user_ids_bottom) {
                return view('case.create_party', ['case_id' => $id, 'top_party_data' => $top_party_data, 'bottom_party_data' => $bottom_party_data, 'case_data' => $case_data, 'top_third_party_data' => $top_third_party_data, 'bottom_third_party_data' => $bottom_third_party_data, 'already_client_top' => $already_client_top, 'already_client_bottom' => $already_client_bottom, 'hascaseid' => $hascaseid]);
            } else if ($user_ids_top) {
                return view('case.create_party', ['case_id' => $id, 'top_party_data' => $top_party_data, 'case_data' => $case_data, 'top_third_party_data' => $top_third_party_data, 'bottom_third_party_data' => $bottom_third_party_data, 'already_client_top' => $already_client_top, 'already_client_bottom' => $already_client_bottom, 'hascaseid' => $hascaseid]);
            } else if ($user_ids_bottom) {
                return view('case.create_party', ['case_id' => $id, 'bottom_party_data' => $bottom_party_data, 'case_data' => $case_data, 'top_third_party_data' => $top_third_party_data, 'bottom_third_party_data' => $bottom_third_party_data, 'already_client_top' => $already_client_top, 'already_client_bottom' => $already_client_bottom, 'hascaseid' => $hascaseid]);
            } else {
                if (isset($prospect_client)) {
                    return view('case.create_party', ['case_id' => $id, 'case_data' => $case_data, 'top_third_party_data' => $top_third_party_data, 'bottom_third_party_data' => $bottom_third_party_data, 'already_client_top' => $already_client_top, 'already_client_bottom' => $already_client_bottom, 'prospect_client' => $prospect_client, 'hascaseid' => $hascaseid]);
                } else {
                    return view('case.create_party', ['case_id' => $id, 'case_data' => $case_data, 'top_third_party_data' => $top_third_party_data, 'bottom_third_party_data' => $bottom_third_party_data, 'already_client_top' => $already_client_top, 'already_client_bottom' => $already_client_bottom, 'hascaseid' => $hascaseid]);
                }
            }
        } else {
            return redirect()->route('home');
        }
    }
    //get case prospect detail 
    public function getProspect($case_id)
    {
        $case_prospect = ProspectCase::where('case_id', $case_id)->get()->first();
        $prospect_client = ProspectiveClientTable::find($case_prospect->prospect_id);
        return response($prospect_client);
    }
    // to store case party info
    public function store_party(Request $request)
    {
        // short caption
        // $short_caption='';
        // $court_case_data=Courtcase::find($request->case_id);
        // if(isset($court_case_data) && $court_case_data->attorney_id!=Auth::user()->id){
        //     return redirect()->route('home');
        // }
        // if(isset($court_case_data->top_party_type)){
        //     $top_party_type=$court_case_data->top_party_type;
        //     $bottom_party_type=$court_case_data->bottom_party_type;
        // } else {
        //     $top_party_type=$court_case_data->original_top_party_type;
        //     $bottom_party_type=$court_case_data->original_bottom_party_type;
        // }

        // $caseusersclienttop=Caseuser::where([['case_id', $request->case_id], ['party_group', 'top']])->get()->all();
        // $count_caseusersclienttop=count($caseusersclienttop);
        // if($count_caseusersclienttop){
        //     $top_party_user=User::where('id', $caseusersclienttop[0]->user_id)->get()->first();
        //     $top_party_fullname=$top_party_user->name;
        //     $top_party_fullname = explode(" ", $top_party_fullname);
        //     if(isset($top_party_fullname[1])){
        //         $short_caption=$top_party_fullname[1];
        //     } else {
        //         $short_caption=$top_party_fullname[0];
        //     }
        //     if(isset($caseusersclienttop[0]->party_entity) && $caseusersclienttop[0]->party_entity=='organization_company' && isset($caseusersclienttop[0]->org_comp_name)){
        //         $short_caption=$caseusersclienttop[0]->org_comp_name;
        //         $short_caption.=" Corporation";
        //     }
        // } else {
        //     if(isset($request->cllname)){
        //         $short_caption=$request->cllname;
        //     } else {
        //         $short_caption=$request->org_comp_name;
        //     }
        // }
        // $caseusersclientbottom=Caseuser::where([['case_id', $request->case_id], ['party_group', 'bottom']])->get()->all();
        // $count_caseusersclientbottom=count($caseusersclientbottom);
        // if($count_caseusersclientbottom){
        //     $bottom_party_user=User::where('id', $caseusersclientbottom[0]->user_id)->get()->first();
        //     $bottom_party_fullname=$bottom_party_user->name;
        //     $bottom_party_fullname = explode(" ", $bottom_party_fullname);

        //     if(isset($top_party_type) && $top_party_type=='Petitioner 1'){
        //         if(isset($bottom_party_fullname[1])){
        //             if(isset($count_caseusersclienttop) && $count_caseusersclienttop > 1){
        //                 $short_caption.= ", et al. and ".$bottom_party_fullname[1];
        //             }else {
        //                 $short_caption.= " and ".$bottom_party_fullname[1];
        //             }
        //         } else {
        //             if(isset($count_caseusersclienttop) && $count_caseusersclienttop > 1){
        //                 $short_caption.= ", et al. v ".$bottom_party_fullname[0];
        //             }else {
        //                 $short_caption.= " v ".$bottom_party_fullname[0];
        //             }
        //         } 
        //     }
        //     if(isset($top_party_type) && $top_party_type!='Petitioner 1'){
        //         if(isset($bottom_party_fullname[1])){
        //             if(isset($count_caseusersclienttop) && $count_caseusersclienttop > 1){
        //                 $short_caption.= ", et al. and ".$bottom_party_fullname[1];
        //             }else {
        //                 $short_caption.= " and ".$bottom_party_fullname[1];
        //             }
        //         } else {
        //             if(isset($count_caseusersclienttop) && $count_caseusersclienttop > 1){
        //                 $short_caption.= ", et al. v ".$bottom_party_fullname[0];
        //             }else {
        //                 $short_caption.= " v ".$bottom_party_fullname[0];
        //             }
        //         } 
        //     } 

        // } else {
        //     if($request->party_group=='bottom'){
        //         if($request->party_entity=='individual'){
        //             $bottom_party_fullname=$request->clfname." ".$request->cllname;
        //             $bottom_party_fullname = explode(" ", $bottom_party_fullname);
        //         } else {
        //             $bottom_party_fullname=$request->org_comp_name;
        //             $bottom_party_fullname = explode(" ", $bottom_party_fullname);
        //             $bottom_party_fullname[1]=$request->org_comp_name." Corporation";
        //             $bottom_party_fullname[0]=$request->org_comp_name." Corporation";
        //         }
        //         if(isset($top_party_type) && $top_party_type=='Petitioner 1'){
        //             if(isset($bottom_party_fullname[1])){
        //                 if(isset($count_caseusersclienttop) && $count_caseusersclienttop > 1){
        //                     $short_caption.= ", et al. and ".$bottom_party_fullname[1];
        //                 }else {
        //                     $short_caption.= " and ".$bottom_party_fullname[1];
        //                 }
        //             } else {
        //                 if(isset($count_caseusersclienttop) && $count_caseusersclienttop > 1){
        //                     $short_caption.= ", et al. and ".$bottom_party_fullname[0];
        //                 }else {
        //                     $short_caption.= " and ".$bottom_party_fullname[0];
        //                 }
        //             } 
        //         }
        //         if(isset($top_party_type) && $top_party_type!='Petitioner 1'){
        //             if(isset($bottom_party_fullname[1])){
        //                 if(isset($count_caseusersclienttop) && $count_caseusersclienttop > 1){
        //                     $short_caption.= ", et al. v ".$bottom_party_fullname[1];
        //                 }else {
        //                     $short_caption.= " v ".$bottom_party_fullname[1];
        //                 }
        //             } else {
        //                 if(isset($count_caseusersclienttop) && $count_caseusersclienttop > 1){
        //                     $short_caption.= ", et al. v ".$bottom_party_fullname[0];
        //                 }else {
        //                     $short_caption.= " v ".$bottom_party_fullname[0];
        //                 }
        //             } 
        //         }

        //     }
        // }

        // $court_case_data->short_caption=$short_caption;  
        // $court_case_data->save();

        // check if user already exists for this case
        if (isset($request->clemail)) {
            $user_client = User::where('email', $request->clemail)->first();
            if ($user_client) {
                $already_exist = Caseuser::where([['user_id', $user_client->id], ['case_id', $request->case_id], ['attorney_id',  Auth::user()->id]])->first();
                if ($already_exist) {
                    return redirect()->route('cases.show_party_reg_form', ['case_id' => $request->case_id])->with('error', 'The party you are adding already exists for this case.');
                }
            }
        }

        // client info 
        $clfname = $request->clfname;
        $cllname = $request->cllname;
        if (isset($request->party_type) && $request->party_type != 'client') {
            if (isset($request->name_unknown) && $request->name_unknown == 'Yes') {
                $name_unknown = $request->name_unknown;
                $clfname = 'Name(s)';
                $cllname = 'Unknown';
                if (isset($request->gen_desc) && $request->gen_desc != '') {
                    $gen_desc = $request->gen_desc;
                } else {
                    $gen_desc = NULL;
                }
                if (isset($request->is_multi_desc) && $request->is_multi_desc == 'Yes') {
                    $is_multi_desc = $request->is_multi_desc;
                    if (isset($request->more_gen_desc) && $request->more_gen_desc != '') {
                        $more_gen_desc = $request->more_gen_desc;
                    } else {
                        $more_gen_desc = NULL;
                    }
                } else {
                    $is_multi_desc = 'No';
                    $more_gen_desc = NULL;
                }
            } else {
                $name_unknown = 'No';
                $gen_desc = NULL;
                $is_multi_desc = 'No';
                $more_gen_desc = NULL;
            }
            if (isset($request->address_unknown) && $request->address_unknown == 'Yes') {
                $address_unknown = 'Yes';
                $request->merge([
                    'clzip' => NULL,
                    'clstate' => NULL,
                    'clcounty' => NULL,
                    'clcity' => NULL,
                    'clstreetad' => NULL,
                ]);
            } else {
                $address_unknown = 'No';
            }
        } else {
            $name_unknown = 'No';
            $gen_desc = NULL;
            $is_multi_desc = 'No';
            $more_gen_desc = NULL;
            $address_unknown = 'No';
        }

        if (isset($clfname) && isset($cllname)) {
            $clname = $clfname . ' ' . $cllname;
        } else {
            if ($request->party_entity == 'organization_company') {
                $clname = $request->org_comp_name;
            } else {
                $clname = $clfname . ' ' . $cllname;
            }
        }
        if ((!isset($request->clemail) || $request->clemail == '') && $request->party_type != 'client') {
            $clemail = 'unknown_' . $request->case_id . '_' . Carbon::now()->timestamp . '@firstdraftdata.com';
        } else {
            $clemail = $request->clemail;
        }
        $type = $request->party_type;


        $user_client = User::where('email', $clemail)->first();
        if ($user_client) {
            if ($type == 'client') {
                // $user_client->active='1';
            }
            $user_client->save();
        } else {
            $client_user_array = array(
                'name' => $clname,
                'email' => $clemail,
                'username' => $clemail,
                'password' => Hash::make($clfname . $cllname),
                'created_at' => now(),
                'updated_at' => now(),
            );
            Session::put('entered_password', $clfname . $cllname);
            Session::put('is_client', true);
            $user_client = User::create($client_user_array);
            $user_client->assignRole('client');
            if ($type == 'client') {
                // $user_client->active='1';
            }
            $user_client->save();
        }

        if ($request->cldob) {
            $cldob = date("Y-m-d", strtotime($request->cldob));
        } else {
            $cldob = $request->cldob;
        }
        $clprimlang = $request->clprimlang;
        if ($clprimlang == 'OTHER') {
            $clprimlang = ucwords($request->client_primlang_other);
        }
        $clssno = $request->clssno;
        $care_of = $request->care_of;
        $employer_identification = $request->employer_identification;
        $org_comp_name = $request->org_comp_name;
        if ($request->party_entity == 'individual') {
            $org_comp_name = NULL;
            $employer_identification = NULL;
            $care_of = NULL;
            $pauperis = $request->pauperis;
        } else {
            $cldob = NULL;
            $clssno = NULL;
            $pauperis = 'No';
        }

        // for designations
        $designation1 = NULL;
        $designation2 = NULL;
        $designation3 = NULL;
        $designation4 = NULL;
        $designation5 = NULL;
        if ($request->party_group == 'top' || $request->party_group == 'bottom') {
            $designation1 = $request->designation1;
            $designation2 = $request->designation2;
            $designation3 = $request->designation3;
            if (isset($request->designation4) || isset($request->designation5)) {
                $designation4 = $request->designation4;
                $designation5 = $request->designation5;
            }
        } else {
            $type = NULL;
            if (isset($request->designation4) || isset($request->designation5)) {
                $designation4 = $request->designation4;
                $designation5 = $request->designation5;
            }
        }

        $client_case_array = array(
            'user_id' => $user_client->id,
            'attorney_id' => Auth::user()->id,
            'case_id' => $request->case_id,
            'party_group' => $request->party_group,
            'party_entity' => $request->party_entity,
            'org_comp_name' => $org_comp_name,
            'type' => $type,
            'care_of' => $care_of,
            'prefix' => $request->clprefix,
            'fname' => $clfname,
            'mname' => $request->clmname,
            'lname' => $cllname,
            'telephone' => $request->clphone,
            'suffix' => $request->clsuffix,
            'prefname' => $request->clprefname,
            'short_name' => $request->short_name,
            'gender' => $request->clgender,
            'social_sec_number' => $clssno,
            'employer_identification' => $employer_identification,
            'date_of_birth' => $cldob,
            'user_zipcode' => $request->clzip,
            'street_address' => $request->clstreetad,
            'user_city' => $request->clcity,
            'state_id' => $request->clstate,
            'county_id' => $request->clcounty,
            'fax' => $request->clfax,
            'primary_language' => $clprimlang,
            'req_lang_trans' => $request->clreqlangtrans,
            'hearing_impaired' => $request->clhearingimpaired,
            'req_sign_lang' => $request->clreqsignlang,
            'unit' => $request->unit,
            'pobox' => $request->pobox,
            'designation1' => $designation1,
            'designation2' => $designation2,
            'designation3' => $designation3,
            'designation4' => $designation4,
            'designation5' => $designation5,
            'name_unknown' => $name_unknown,
            'gen_desc' => $gen_desc,
            'is_multi_desc' => $is_multi_desc,
            'more_gen_desc' => $more_gen_desc,
            'address_unknown' => $address_unknown,
            'pauperis' => $pauperis,
            'created_at' => now(),
            'updated_at' => now(),
            'relation' => ($request->relation) ? $request->relation : 'null'
        );

        // echo "<pre>"; print_r($client_case_array); die;
        $caseusersclient = Caseuser::create($client_case_array);

        // to register case frpm prospect
        $prospect_id = $request->prospect_id;
        // if (isset($prospect_id) && $prospect_id != '') {
        //     ProspectiveClientTable::find($prospect_id)->delete();
        // }

        // short caption
        $short_caption = '';
        $case_id = $request->case_id;
        $court_case_data = Courtcase::find($case_id);
        if (isset($court_case_data) && $court_case_data->attorney_id != Auth::user()->id) {
            return redirect()->route('home');
        }
        if (isset($court_case_data->top_party_type)) {
            $top_party_type = $court_case_data->top_party_type;
            $bottom_party_type = $court_case_data->bottom_party_type;
        } else {
            $top_party_type = $court_case_data->original_top_party_type;
            $bottom_party_type = $court_case_data->original_bottom_party_type;
        }

        $caseusersclienttop = Caseuser::where([['case_id', $case_id], ['party_group', 'top']])->get()->all();
        $count_caseusersclienttop = count($caseusersclienttop);
        if ($count_caseusersclienttop) {

            if (isset($caseusersclienttop[0]->party_entity) && $caseusersclienttop[0]->party_entity == 'organization_company' && isset($caseusersclienttop[0]->org_comp_name)) {
                $short_caption = $caseusersclienttop[0]->org_comp_name;
                $short_caption .= " Corporation";
            } else {
                $short_caption = $caseusersclienttop[0]->lname;
            }
            if ($count_caseusersclienttop > 1) {
                $short_caption .= ', et al.';
            }
        } else {
            if (isset($request->party_entity) && $request->party_entity == 'organization_company' && isset($request->org_comp_name)) {
                $short_caption = $request->org_comp_name;
                $short_caption .= " Corporation";
            } else {
                $short_caption = $request->cllname;
            }
        }

        $caseusersclientbottom = Caseuser::where([['case_id', $case_id], ['party_group', 'bottom']])->get()->all();
        $count_caseusersclientbottom = count($caseusersclientbottom);
        if ($count_caseusersclientbottom) {
            if (isset($caseusersclientbottom[0]->party_entity) && $caseusersclientbottom[0]->party_entity == 'organization_company' && isset($caseusersclientbottom[0]->org_comp_name)) {
                $bottom_party_lname = $caseusersclientbottom[0]->org_comp_name;
                $bottom_party_lname .= " Corporation";
            } else {
                $bottom_party_lname = $caseusersclientbottom[0]->lname;
            }
            if (isset($court_case_data->case_type_ids) && ($court_case_data->case_type_ids == '1' || $court_case_data->case_type_ids == '2')) {
                $short_caption .= " and " . $bottom_party_lname;
            } else {
                $short_caption .= " v " . $bottom_party_lname;
            }
            if ($count_caseusersclientbottom > 1) {
                $short_caption .= ', et al.';
            }
        } else {
            if (isset($request->party_entity) && $request->party_entity == 'organization_company' && isset($request->org_comp_name)) {
                $bottom_party_lname = $request->org_comp_name;
                $bottom_party_lname .= " Corporation";
            } else {
                $bottom_party_lname = $request->cllname;
            }
            if (isset($court_case_data->case_type_ids) && ($court_case_data->case_type_ids == '1' || $court_case_data->case_type_ids == '2')) {
                $short_caption .= " and " . $bottom_party_lname;
            } else {
                $short_caption .= " v " . $bottom_party_lname;
            }
        }

        $court_case_data->short_caption = $short_caption;
        $court_case_data->save();
        // end short caption

        // ----------fololowing code is to update case party info table-------------//
        if ($request->party_group == 'top' || $request->party_group == 'bottom') {
            $casetopparties = Caseuser::where([['case_id', $request->case_id], ['party_group', 'top']])->get()->all();
            $casebottomparties = Caseuser::where([['case_id', $request->case_id], ['party_group', 'bottom']])->get()->all();
            $client_case_array2 = array(
                'case_id' => $request->case_id,
            );
            $i = 0;
            $num = 0;
            foreach ($casetopparties as $casetopparty) {
                $name = User::where('id', $casetopparty['user_id'])->get()->pluck('name')->first();
                $fullname = $name;
                if (isset($casetopparty['party_entity']) && $casetopparty['party_entity'] == 'organization_company') {
                    $fullname = $casetopparty['org_comp_name'];
                } else {
                    $mname = $casetopparty['mname'];
                    if (isset($mname) && $mname != '') {
                        $namearray = explode(' ', $name, 2);
                        if (count($namearray) > 1) {
                            $fullname = $namearray[0] . ' ' . $mname . ' ' . $namearray[1];
                        } else {
                            $fullname = $name . ' ' . $mname;
                        }
                    } else {
                        $fullname = $name;
                    }
                }

                $casetopparties[$i]['name'] = $fullname;
                if (isset($casetopparty['state_id']) && $casetopparty['state_id'] != '') {
                    $casetopparties[$i]['state_name'] = DB::table('states')->where('id', $casetopparty['state_id'])->get()->pluck('state')->first();
                } else {
                    $casetopparties[$i]['state_name'] = NULL;
                }
                if (isset($casetopparty['county_id']) && $casetopparty['county_id'] != '') {
                    $casetopparties[$i]['county_name'] = DB::table('counties')->where('id', $casetopparty['county_id'])->get()->pluck('county_name')->first();
                } else {
                    $casetopparties[$i]['county_name'] = NULL;
                }
                $num++;
                $client_case_array2['topparty' . $num . '_user_id'] = $casetopparty['user_id'];
                $client_case_array2['topparty' . $num . '_name'] = $casetopparties[$i]['name'];
                $client_case_array2['topparty' . $num . '_party_group'] = $casetopparty['party_group'];
                $client_case_array2['topparty' . $num . '_org_comp_name'] = $casetopparty['org_comp_name'];
                $client_case_array2['topparty' . $num . '_type'] = $casetopparty['type'];
                $client_case_array2['topparty' . $num . '_care_of'] = $casetopparty['care_of'];
                $client_case_array2['topparty' . $num . '_prefix'] = $casetopparty['prefix'];
                $client_case_array2['topparty' . $num . '_fname'] = $casetopparty['fname'];
                $client_case_array2['topparty' . $num . '_mname'] = $casetopparty['mname'];
                $client_case_array2['topparty' . $num . '_lname'] = $casetopparty['lname'];
                $client_case_array2['topparty' . $num . '_phone'] = $casetopparty['telephone'];
                $client_case_array2['topparty' . $num . '_suffix'] = $casetopparty['suffix'];
                $client_case_array2['topparty' . $num . '_prefname'] = $casetopparty['prefname'];
                $client_case_array2['topparty' . $num . '_short_name'] = $casetopparty['short_name'];
                $client_case_array2['topparty' . $num . '_gender'] = $casetopparty['gender'];
                $client_case_array2['topparty' . $num . '_social_sec_number'] = $casetopparty['social_sec_number'];
                $client_case_array2['topparty' . $num . '_employer_identification'] = $casetopparty['employer_identification'];
                $client_case_array2['topparty' . $num . '_date_of_birth'] = $casetopparty['date_of_birth'];
                $client_case_array2['topparty' . $num . '_zipcode'] = $casetopparty['user_zipcode'];
                $client_case_array2['topparty' . $num . '_street_address'] = $casetopparty['street_address'];
                $client_case_array2['topparty' . $num . '_city_name'] = $casetopparty['user_city'];
                $client_case_array2['topparty' . $num . '_state_name'] = $casetopparties[$i]['state_name'];
                $client_case_array2['topparty' . $num . '_county_name'] = $casetopparties[$i]['county_name'];
                $client_case_array2['topparty' . $num . '_fax'] = $casetopparty['fax'];
                $client_case_array2['topparty' . $num . '_primary_language'] = $casetopparty['primary_language'];
                $client_case_array2['topparty' . $num . '_req_lang_trans'] = $casetopparty['req_lang_trans'];
                $client_case_array2['topparty' . $num . '_hearing_impaired'] = $casetopparty['hearing_impaired'];
                $client_case_array2['topparty' . $num . '_req_sign_lang'] = $casetopparty['req_sign_lang'];
                $client_case_array2['topparty' . $num . '_name_unknown'] = $casetopparty['name_unknown'];
                $client_case_array2['topparty' . $num . '_address_unknown'] = $casetopparty['address_unknown'];
                $client_case_array2['topparty' . $num . '_gen_desc'] = $casetopparty['gen_desc'];
                $client_case_array2['topparty' . $num . '_is_multi_desc'] = $casetopparty['is_multi_desc'];
                $client_case_array2['topparty' . $num . '_more_gen_desc'] = $casetopparty['more_gen_desc'];
                $client_case_array2['topparty' . $num . '_pauperis'] = $casetopparty['pauperis'];
                $client_case_array2['topparty' . $num . '_num_attys'] = '0';
                $client_case_array2['tp_child_relation' . $num] = ($casetopparty['relation']) ? $casetopparty['relation'] : 'null';

                $i++;
            }
            $limit = $num + 1;
            for ($j = $limit; $j <= 6; $j++) {
                $client_case_array2['topparty' . $j . '_user_id'] = NULL;
                $client_case_array2['topparty' . $j . '_name'] = NULL;
                $client_case_array2['topparty' . $j . '_party_group'] = NULL;
                $client_case_array2['topparty' . $j . '_org_comp_name'] = NULL;
                $client_case_array2['topparty' . $j . '_type'] = NULL;
                $client_case_array2['topparty' . $j . '_care_of'] = NULL;
                $client_case_array2['topparty' . $j . '_prefix'] = NULL;
                $client_case_array2['topparty' . $j . '_fname'] = NULL;
                $client_case_array2['topparty' . $j . '_mname'] = NULL;
                $client_case_array2['topparty' . $j . '_lname'] = NULL;
                $client_case_array2['topparty' . $j . '_phone'] = NULL;
                $client_case_array2['topparty' . $j . '_suffix'] = NULL;
                $client_case_array2['topparty' . $j . '_prefname'] = NULL;
                $client_case_array2['topparty' . $j . '_short_name'] = NULL;
                $client_case_array2['topparty' . $j . '_gender'] = NULL;
                $client_case_array2['topparty' . $j . '_social_sec_number'] = NULL;
                $client_case_array2['topparty' . $j . '_employer_identification'] = NULL;
                $client_case_array2['topparty' . $j . '_date_of_birth'] = NULL;
                $client_case_array2['topparty' . $j . '_zipcode'] = NULL;
                $client_case_array2['topparty' . $j . '_street_address'] = NULL;
                $client_case_array2['topparty' . $j . '_city_name'] = NULL;
                $client_case_array2['topparty' . $j . '_state_name'] = NULL;
                $client_case_array2['topparty' . $j . '_county_name'] = NULL;
                $client_case_array2['topparty' . $j . '_fax'] = NULL;
                $client_case_array2['topparty' . $j . '_primary_language'] = NULL;
                $client_case_array2['topparty' . $j . '_req_lang_trans'] = NULL;
                $client_case_array2['topparty' . $j . '_hearing_impaired'] = NULL;
                $client_case_array2['topparty' . $j . '_req_sign_lang'] = NULL;
                $client_case_array2['topparty' . $j . '_name_unknown'] = 'No';
                $client_case_array2['topparty' . $j . '_address_unknown'] = 'No';
                $client_case_array2['topparty' . $j . '_gen_desc'] = NULL;
                $client_case_array2['topparty' . $j . '_is_multi_desc'] = NULL;
                $client_case_array2['topparty' . $j . '_more_gen_desc'] = NULL;
                $client_case_array2['topparty' . $j . '_pauperis'] = NULL;
                $client_case_array2['topparty' . $j . '_num_attys'] = '0';
                $client_case_array2['tp_child_relation' . $j] = Null;
            }
            $i = 0;
            $num = 0;
            foreach ($casebottomparties as $casebottomparty) {
                $name = User::where('id', $casebottomparty['user_id'])->get()->pluck('name')->first();
                $fullname = $name;
                if (isset($casebottomparty['party_entity']) && $casebottomparty['party_entity'] == 'organization_company') {
                    $fullname = $casebottomparty['org_comp_name'];
                } else {
                    $mname = $casebottomparty['mname'];
                    if (isset($mname) && $mname != '') {
                        $namearray = explode(' ', $name, 2);
                        if (count($namearray) > 1) {
                            $fullname = $namearray[0] . ' ' . $mname . ' ' . $namearray[1];
                        } else {
                            $fullname = $name . ' ' . $mname;
                        }
                    } else {
                        $fullname = $name;
                    }
                }

                $casebottomparties[$i]['name'] = $fullname;

                // $casebottomparties[$i]['state_name']=DB::table('states')->where('id',$casebottomparty['state_id'])->get()->pluck('state')->first();
                // $casebottomparties[$i]['county_name']=DB::table('counties')->where('id',$casebottomparty['county_id'])->get()->pluck('county_name')->first();

                if (isset($casebottomparty['state_id']) && $casebottomparty['state_id'] != '') {
                    $casebottomparties[$i]['state_name'] = DB::table('states')->where('id', $casebottomparty['state_id'])->get()->pluck('state')->first();
                } else {
                    $casebottomparties[$i]['state_name'] = NULL;
                }
                if (isset($casebottomparty['county_id']) && $casebottomparty['county_id'] != '') {
                    $casebottomparties[$i]['county_name'] = DB::table('counties')->where('id', $casebottomparty['county_id'])->get()->pluck('county_name')->first();
                } else {
                    $casebottomparties[$i]['county_name'] = NULL;
                }
                $num++;
                $client_case_array2['bottomparty' . $num . '_user_id'] = $casebottomparty['user_id'];
                $client_case_array2['bottomparty' . $num . '_name'] = $casebottomparties[$i]['name'];
                $client_case_array2['bottomparty' . $num . '_party_group'] = $casebottomparty['party_group'];
                $client_case_array2['bottomparty' . $num . '_org_comp_name'] = $casebottomparty['org_comp_name'];
                $client_case_array2['bottomparty' . $num . '_type'] = $casebottomparty['type'];
                $client_case_array2['bottomparty' . $num . '_care_of'] = $casebottomparty['care_of'];
                $client_case_array2['bottomparty' . $num . '_prefix'] = $casebottomparty['prefix'];
                $client_case_array2['bottomparty' . $num . '_fname'] = $casebottomparty['fname'];
                $client_case_array2['bottomparty' . $num . '_mname'] = $casebottomparty['mname'];
                $client_case_array2['bottomparty' . $num . '_lname'] = $casebottomparty['lname'];
                $client_case_array2['bottomparty' . $num . '_phone'] = $casebottomparty['telephone'];
                $client_case_array2['bottomparty' . $num . '_suffix'] = $casebottomparty['suffix'];
                $client_case_array2['bottomparty' . $num . '_prefname'] = $casebottomparty['prefname'];
                $client_case_array2['bottomparty' . $num . '_short_name'] = $casebottomparty['short_name'];
                $client_case_array2['bottomparty' . $num . '_gender'] = $casebottomparty['gender'];
                $client_case_array2['bottomparty' . $num . '_social_sec_number'] = $casebottomparty['social_sec_number'];
                $client_case_array2['bottomparty' . $num . '_employer_identification'] = $casebottomparty['employer_identification'];
                $client_case_array2['bottomparty' . $num . '_date_of_birth'] = $casebottomparty['date_of_birth'];
                $client_case_array2['bottomparty' . $num . '_zipcode'] = $casebottomparty['user_zipcode'];
                $client_case_array2['bottomparty' . $num . '_street_address'] = $casebottomparty['street_address'];
                $client_case_array2['bottomparty' . $num . '_city_name'] = $casebottomparty['user_city'];
                $client_case_array2['bottomparty' . $num . '_state_name'] = $casebottomparties[$i]['state_name'];
                $client_case_array2['bottomparty' . $num . '_county_name'] = $casebottomparties[$i]['county_name'];
                $client_case_array2['bottomparty' . $num . '_fax'] = $casebottomparty['fax'];
                $client_case_array2['bottomparty' . $num . '_primary_language'] = $casebottomparty['primary_language'];
                $client_case_array2['bottomparty' . $num . '_req_lang_trans'] = $casebottomparty['req_lang_trans'];
                $client_case_array2['bottomparty' . $num . '_hearing_impaired'] = $casebottomparty['hearing_impaired'];
                $client_case_array2['bottomparty' . $num . '_req_sign_lang'] = $casebottomparty['req_sign_lang'];
                $client_case_array2['bottomparty' . $num . '_name_unknown'] = $casebottomparty['name_unknown'];
                $client_case_array2['bottomparty' . $num . '_address_unknown'] = $casebottomparty['address_unknown'];
                $client_case_array2['bottomparty' . $num . '_gen_desc'] = $casebottomparty['gen_desc'];
                $client_case_array2['bottomparty' . $num . '_is_multi_desc'] = $casebottomparty['is_multi_desc'];
                $client_case_array2['bottomparty' . $num . '_more_gen_desc'] = $casebottomparty['more_gen_desc'];
                $client_case_array2['bottomparty' . $num . '_pauperis'] = $casebottomparty['pauperis'];
                $client_case_array2['bottomparty' . $num . '_num_attys'] = '0';
                $client_case_array2['bp_child_relation' . $num] = ($casebottomparty['relation']) ? $casebottomparty['relation'] : 'null';
                $i++;
            }
            $limit = $num + 1;
            for ($j = $limit; $j <= 6; $j++) {
                $client_case_array2['bottomparty' . $j . '_user_id'] = NULL;
                $client_case_array2['bottomparty' . $j . '_name'] = NULL;
                $client_case_array2['bottomparty' . $j . '_party_group'] = NULL;
                $client_case_array2['bottomparty' . $j . '_org_comp_name'] = NULL;
                $client_case_array2['bottomparty' . $j . '_type'] = NULL;
                $client_case_array2['bottomparty' . $j . '_care_of'] = NULL;
                $client_case_array2['bottomparty' . $j . '_prefix'] = NULL;
                $client_case_array2['bottomparty' . $j . '_fname'] = NULL;
                $client_case_array2['bottomparty' . $j . '_mname'] = NULL;
                $client_case_array2['bottomparty' . $j . '_lname'] = NULL;
                $client_case_array2['bottomparty' . $j . '_phone'] = NULL;
                $client_case_array2['bottomparty' . $j . '_suffix'] = NULL;
                $client_case_array2['bottomparty' . $j . '_prefname'] = NULL;
                $client_case_array2['bottomparty' . $j . '_short_name'] = NULL;
                $client_case_array2['bottomparty' . $j . '_gender'] = NULL;
                $client_case_array2['bottomparty' . $j . '_social_sec_number'] = NULL;
                $client_case_array2['bottomparty' . $j . '_employer_identification'] = NULL;
                $client_case_array2['bottomparty' . $j . '_date_of_birth'] = NULL;
                $client_case_array2['bottomparty' . $j . '_zipcode'] = NULL;
                $client_case_array2['bottomparty' . $j . '_street_address'] = NULL;
                $client_case_array2['bottomparty' . $j . '_city_name'] = NULL;
                $client_case_array2['bottomparty' . $j . '_state_name'] = NULL;
                $client_case_array2['bottomparty' . $j . '_county_name'] = NULL;
                $client_case_array2['bottomparty' . $j . '_fax'] = NULL;
                $client_case_array2['bottomparty' . $j . '_primary_language'] = NULL;
                $client_case_array2['bottomparty' . $j . '_req_lang_trans'] = NULL;
                $client_case_array2['bottomparty' . $j . '_hearing_impaired'] = NULL;
                $client_case_array2['bottomparty' . $j . '_req_sign_lang'] = NULL;
                $client_case_array2['bottomparty' . $j . '_name_unknown'] = 'No';
                $client_case_array2['bottomparty' . $j . '_address_unknown'] = 'No';
                $client_case_array2['bottomparty' . $j . '_gen_desc'] = NULL;
                $client_case_array2['bottomparty' . $j . '_is_multi_desc'] = NULL;
                $client_case_array2['bottomparty' . $j . '_more_gen_desc'] = NULL;
                $client_case_array2['bottomparty' . $j . '_pauperis'] = NULL;
                $client_case_array2['bottomparty' . $j . '_num_attys'] = '0';
                $client_case_array2['bp_child_relation' . $j] = Null;
            }

            // dd($client_case_array2);
            $partytypeinfoprev = CasePartyInfo::where('case_id', $request->case_id)->get()->first();
            if ($partytypeinfoprev) {
                $partytypeinfo = $partytypeinfoprev->fill($client_case_array2)->save();
            } else {
                $partytypeinfo = CasePartyInfo::create($client_case_array2);
            }
        }

        // for third parties
        if ($request->party_group == 'top_third' || $request->party_group == 'bottom_third') {
            $casetop_thirdparties = Caseuser::where([['case_id', $request->case_id], ['party_group', 'top_third']])->get()->all();
            $casebottom_thirdparties = Caseuser::where([['case_id', $request->case_id], ['party_group', 'bottom_third']])->get()->all();
            $client_case_array2 = array(
                'case_id' => $request->case_id,
            );
            $i = 0;
            $num = 0;
            foreach ($casetop_thirdparties as $casetop_thirdparty) {
                $name = User::where('id', $casetop_thirdparty['user_id'])->get()->pluck('name')->first();
                $fullname = $name;
                if (isset($casetop_thirdparty['party_entity']) && $casetop_thirdparty['party_entity'] == 'organization_company') {
                    $fullname = $casetop_thirdparty['org_comp_name'];
                } else {
                    $mname = $casetop_thirdparty['mname'];
                    if (isset($mname) && $mname != '') {
                        $namearray = explode(' ', $name, 2);
                        if (count($namearray) > 1) {
                            $fullname = $namearray[0] . ' ' . $mname . ' ' . $namearray[1];
                        } else {
                            $fullname = $name . ' ' . $mname;
                        }
                    } else {
                        $fullname = $name;
                    }
                }

                $casetop_thirdparties[$i]['name'] = $fullname;

                // $casetop_thirdparties[$i]['state_name']=DB::table('states')->where('id',$casetop_thirdparty['state_id'])->get()->pluck('state')->first();
                // $casetop_thirdparties[$i]['county_name']=DB::table('counties')->where('id',$casetop_thirdparty['county_id'])->get()->pluck('county_name')->first();

                if (isset($casetop_thirdparty['state_id']) && $casetop_thirdparty['state_id'] != '') {
                    $casetop_thirdparties[$i]['state_name'] = DB::table('states')->where('id', $casetop_thirdparty['state_id'])->get()->pluck('state')->first();
                } else {
                    $casetop_thirdparties[$i]['state_name'] = NULL;
                }
                if (isset($casetop_thirdparty['county_id']) && $casetop_thirdparty['county_id'] != '') {
                    $casetop_thirdparties[$i]['county_name'] = DB::table('counties')->where('id', $casetop_thirdparty['county_id'])->get()->pluck('county_name')->first();
                } else {
                    $casetop_thirdparties[$i]['county_name'] = NULL;
                }
                $num++;
                $client_case_array2['top_thirdparty' . $num . '_user_id'] = $casetop_thirdparty['user_id'];
                $client_case_array2['top_thirdparty' . $num . '_name'] = $casetop_thirdparties[$i]['name'];
                $client_case_array2['top_thirdparty' . $num . '_party_group'] = $casetop_thirdparty['party_group'];
                $client_case_array2['top_thirdparty' . $num . '_org_comp_name'] = $casetop_thirdparty['org_comp_name'];
                $client_case_array2['top_thirdparty' . $num . '_type'] = $casetop_thirdparty['type'];
                $client_case_array2['top_thirdparty' . $num . '_care_of'] = $casetop_thirdparty['care_of'];
                $client_case_array2['top_thirdparty' . $num . '_prefix'] = $casetop_thirdparty['prefix'];
                $client_case_array2['top_thirdparty' . $num . '_fname'] = $casetop_thirdparty['fname'];
                $client_case_array2['top_thirdparty' . $num . '_mname'] = $casetop_thirdparty['mname'];
                $client_case_array2['top_thirdparty' . $num . '_lname'] = $casetop_thirdparty['lname'];
                $client_case_array2['top_thirdparty' . $num . '_phone'] = $casetop_thirdparty['telephone'];
                $client_case_array2['top_thirdparty' . $num . '_suffix'] = $casetop_thirdparty['suffix'];
                $client_case_array2['top_thirdparty' . $num . '_prefname'] = $casetop_thirdparty['prefname'];
                $client_case_array2['top_thirdparty' . $num . '_short_name'] = $casetop_thirdparty['short_name'];
                $client_case_array2['top_thirdparty' . $num . '_gender'] = $casetop_thirdparty['gender'];
                $client_case_array2['top_thirdparty' . $num . '_social_sec_number'] = $casetop_thirdparty['social_sec_number'];
                $client_case_array2['top_thirdparty' . $num . '_employer_identification'] = $casetop_thirdparty['employer_identification'];
                $client_case_array2['top_thirdparty' . $num . '_date_of_birth'] = $casetop_thirdparty['date_of_birth'];
                $client_case_array2['top_thirdparty' . $num . '_zipcode'] = $casetop_thirdparty['user_zipcode'];
                $client_case_array2['top_thirdparty' . $num . '_street_address'] = $casetop_thirdparty['street_address'];
                $client_case_array2['top_thirdparty' . $num . '_city_name'] = $casetop_thirdparty['user_city'];
                $client_case_array2['top_thirdparty' . $num . '_state_name'] = $casetop_thirdparties[$i]['state_name'];
                $client_case_array2['top_thirdparty' . $num . '_county_name'] = $casetop_thirdparties[$i]['county_name'];
                $client_case_array2['top_thirdparty' . $num . '_fax'] = $casetop_thirdparty['fax'];
                $client_case_array2['top_thirdparty' . $num . '_primary_language'] = $casetop_thirdparty['primary_language'];
                $client_case_array2['top_thirdparty' . $num . '_req_lang_trans'] = $casetop_thirdparty['req_lang_trans'];
                $client_case_array2['top_thirdparty' . $num . '_hearing_impaired'] = $casetop_thirdparty['hearing_impaired'];
                $client_case_array2['top_thirdparty' . $num . '_req_sign_lang'] = $casetop_thirdparty['req_sign_lang'];
                $client_case_array2['top_thirdparty' . $num . '_name_unknown'] = $casetop_thirdparty['name_unknown'];
                $client_case_array2['top_thirdparty' . $num . '_address_unknown'] = $casetop_thirdparty['address_unknown'];
                $client_case_array2['top_thirdparty' . $num . '_gen_desc'] = $casetop_thirdparty['gen_desc'];
                $client_case_array2['top_thirdparty' . $num . '_is_multi_desc'] = $casetop_thirdparty['is_multi_desc'];
                $client_case_array2['top_thirdparty' . $num . '_more_gen_desc'] = $casetop_thirdparty['more_gen_desc'];
                $client_case_array2['top_thirdparty' . $num . '_pauperis'] = $casetop_thirdparty['pauperis'];
                $client_case_array2['top_thirdparty' . $num . '_num_attys'] = '0';

                $i++;
            }
            $limit = $num + 1;
            for ($j = $limit; $j <= 3; $j++) {
                $client_case_array2['top_thirdparty' . $j . '_user_id'] = NULL;
                $client_case_array2['top_thirdparty' . $j . '_name'] = NULL;
                $client_case_array2['top_thirdparty' . $j . '_party_group'] = NULL;
                $client_case_array2['top_thirdparty' . $j . '_org_comp_name'] = NULL;
                $client_case_array2['top_thirdparty' . $j . '_type'] = NULL;
                $client_case_array2['top_thirdparty' . $j . '_care_of'] = NULL;
                $client_case_array2['top_thirdparty' . $j . '_prefix'] = NULL;
                $client_case_array2['top_thirdparty' . $j . '_fname'] = NULL;
                $client_case_array2['top_thirdparty' . $j . '_mname'] = NULL;
                $client_case_array2['top_thirdparty' . $j . '_lname'] = NULL;
                $client_case_array2['top_thirdparty' . $j . '_phone'] = NULL;
                $client_case_array2['top_thirdparty' . $j . '_suffix'] = NULL;
                $client_case_array2['top_thirdparty' . $j . '_prefname'] = NULL;
                $client_case_array2['top_thirdparty' . $j . '_short_name'] = NULL;
                $client_case_array2['top_thirdparty' . $j . '_gender'] = NULL;
                $client_case_array2['top_thirdparty' . $j . '_social_sec_number'] = NULL;
                $client_case_array2['top_thirdparty' . $j . '_employer_identification'] = NULL;
                $client_case_array2['top_thirdparty' . $j . '_date_of_birth'] = NULL;
                $client_case_array2['top_thirdparty' . $j . '_zipcode'] = NULL;
                $client_case_array2['top_thirdparty' . $j . '_street_address'] = NULL;
                $client_case_array2['top_thirdparty' . $j . '_city_name'] = NULL;
                $client_case_array2['top_thirdparty' . $j . '_state_name'] = NULL;
                $client_case_array2['top_thirdparty' . $j . '_county_name'] = NULL;
                $client_case_array2['top_thirdparty' . $j . '_fax'] = NULL;
                $client_case_array2['top_thirdparty' . $j . '_primary_language'] = NULL;
                $client_case_array2['top_thirdparty' . $j . '_req_lang_trans'] = NULL;
                $client_case_array2['top_thirdparty' . $j . '_hearing_impaired'] = NULL;
                $client_case_array2['top_thirdparty' . $j . '_req_sign_lang'] = NULL;
                $client_case_array2['top_thirdparty' . $j . '_name_unknown'] = NULL;
                $client_case_array2['top_thirdparty' . $j . '_address_unknown'] = 'No';
                $client_case_array2['top_thirdparty' . $j . '_gen_desc'] = NULL;
                $client_case_array2['top_thirdparty' . $j . '_is_multi_desc'] = NULL;
                $client_case_array2['top_thirdparty' . $j . '_more_gen_desc'] = NULL;
                $client_case_array2['top_thirdparty' . $j . '_pauperis'] = NULL;
                $client_case_array2['top_thirdparty' . $j . '_num_attys'] = '0';
            }
            $i = 0;
            $num = 0;
            foreach ($casebottom_thirdparties as $casebottom_thirdparty) {
                $name = User::where('id', $casebottom_thirdparty['user_id'])->get()->pluck('name')->first();
                $fullname = $name;
                if (isset($casebottom_thirdparty['party_entity']) && $casebottom_thirdparty['party_entity'] == 'organization_company') {
                    $fullname = $casebottom_thirdparty['org_comp_name'];
                } else {
                    $mname = $casebottom_thirdparty['mname'];
                    if (isset($mname) && $mname != '') {
                        $namearray = explode(' ', $name, 2);
                        if (count($namearray) > 1) {
                            $fullname = $namearray[0] . ' ' . $mname . ' ' . $namearray[1];
                        } else {
                            $fullname = $name . ' ' . $mname;
                        }
                    } else {
                        $fullname = $name;
                    }
                }

                $casebottom_thirdparties[$i]['name'] = $fullname;

                // $casebottom_thirdparties[$i]['state_name']=DB::table('states')->where('id',$casebottom_thirdparty['state_id'])->get()->pluck('state')->first();
                // $casebottom_thirdparties[$i]['county_name']=DB::table('counties')->where('id',$casebottom_thirdparty['county_id'])->get()->pluck('county_name')->first();

                if (isset($casebottom_thirdparty['state_id']) && $casebottom_thirdparty['state_id'] != '') {
                    $casebottom_thirdparties[$i]['state_name'] = DB::table('states')->where('id', $casebottom_thirdparty['state_id'])->get()->pluck('state')->first();
                } else {
                    $casebottom_thirdparties[$i]['state_name'] = NULL;
                }
                if (isset($casebottom_thirdparty['county_id']) && $casebottom_thirdparty['county_id'] != '') {
                    $casebottom_thirdparties[$i]['county_name'] = DB::table('counties')->where('id', $casebottom_thirdparty['county_id'])->get()->pluck('county_name')->first();
                } else {
                    $casebottom_thirdparties[$i]['county_name'] = NULL;
                }
                $num++;
                $client_case_array2['bottom_thirdparty' . $num . '_user_id'] = $casebottom_thirdparty['user_id'];
                $client_case_array2['bottom_thirdparty' . $num . '_name'] = $casebottom_thirdparties[$i]['name'];
                $client_case_array2['bottom_thirdparty' . $num . '_party_group'] = $casebottom_thirdparty['party_group'];
                $client_case_array2['bottom_thirdparty' . $num . '_org_comp_name'] = $casebottom_thirdparty['org_comp_name'];
                $client_case_array2['bottom_thirdparty' . $num . '_type'] = $casebottom_thirdparty['type'];
                $client_case_array2['bottom_thirdparty' . $num . '_care_of'] = $casebottom_thirdparty['care_of'];
                $client_case_array2['bottom_thirdparty' . $num . '_prefix'] = $casebottom_thirdparty['prefix'];
                $client_case_array2['bottom_thirdparty' . $num . '_fname'] = $casebottom_thirdparty['fname'];
                $client_case_array2['bottom_thirdparty' . $num . '_mname'] = $casebottom_thirdparty['mname'];
                $client_case_array2['bottom_thirdparty' . $num . '_lname'] = $casebottom_thirdparty['lname'];
                $client_case_array2['bottom_thirdparty' . $num . '_phone'] = $casebottom_thirdparty['telephone'];
                $client_case_array2['bottom_thirdparty' . $num . '_suffix'] = $casebottom_thirdparty['suffix'];
                $client_case_array2['bottom_thirdparty' . $num . '_prefname'] = $casebottom_thirdparty['prefname'];
                $client_case_array2['bottom_thirdparty' . $num . '_short_name'] = $casebottom_thirdparty['short_name'];
                $client_case_array2['bottom_thirdparty' . $num . '_gender'] = $casebottom_thirdparty['gender'];
                $client_case_array2['bottom_thirdparty' . $num . '_social_sec_number'] = $casebottom_thirdparty['social_sec_number'];
                $client_case_array2['bottom_thirdparty' . $num . '_employer_identification'] = $casebottom_thirdparty['employer_identification'];
                $client_case_array2['bottom_thirdparty' . $num . '_date_of_birth'] = $casebottom_thirdparty['date_of_birth'];
                $client_case_array2['bottom_thirdparty' . $num . '_zipcode'] = $casebottom_thirdparty['user_zipcode'];
                $client_case_array2['bottom_thirdparty' . $num . '_street_address'] = $casebottom_thirdparty['street_address'];
                $client_case_array2['bottom_thirdparty' . $num . '_city_name'] = $casebottom_thirdparty['user_city'];
                $client_case_array2['bottom_thirdparty' . $num . '_state_name'] = $casebottom_thirdparties[$i]['state_name'];
                $client_case_array2['bottom_thirdparty' . $num . '_county_name'] = $casebottom_thirdparties[$i]['county_name'];
                $client_case_array2['bottom_thirdparty' . $num . '_fax'] = $casebottom_thirdparty['fax'];
                $client_case_array2['bottom_thirdparty' . $num . '_primary_language'] = $casebottom_thirdparty['primary_language'];
                $client_case_array2['bottom_thirdparty' . $num . '_req_lang_trans'] = $casebottom_thirdparty['req_lang_trans'];
                $client_case_array2['bottom_thirdparty' . $num . '_hearing_impaired'] = $casebottom_thirdparty['hearing_impaired'];
                $client_case_array2['bottom_thirdparty' . $num . '_req_sign_lang'] = $casebottom_thirdparty['req_sign_lang'];
                $client_case_array2['bottom_thirdparty' . $num . '_name_unknown'] = $casebottom_thirdparty['name_unknown'];
                $client_case_array2['bottom_thirdparty' . $num . '_address_unknown'] = $casebottom_thirdparty['address_unknown'];
                $client_case_array2['bottom_thirdparty' . $num . '_gen_desc'] = $casebottom_thirdparty['gen_desc'];
                $client_case_array2['bottom_thirdparty' . $num . '_is_multi_desc'] = $casebottom_thirdparty['is_multi_desc'];
                $client_case_array2['bottom_thirdparty' . $num . '_more_gen_desc'] = $casebottom_thirdparty['more_gen_desc'];
                $client_case_array2['bottom_thirdparty' . $num . '_pauperis'] = $casebottom_thirdparty['pauperis'];
                $client_case_array2['bottom_thirdparty' . $num . '_num_attys'] = '0';

                $i++;
            }
            $limit = $num + 1;
            for ($j = $limit; $j <= 3; $j++) {
                $client_case_array2['bottom_thirdparty' . $j . '_user_id'] = NULL;
                $client_case_array2['bottom_thirdparty' . $j . '_name'] = NULL;
                $client_case_array2['bottom_thirdparty' . $j . '_party_group'] = NULL;
                $client_case_array2['bottom_thirdparty' . $j . '_org_comp_name'] = NULL;
                $client_case_array2['bottom_thirdparty' . $j . '_type'] = NULL;
                $client_case_array2['bottom_thirdparty' . $j . '_care_of'] = NULL;
                $client_case_array2['bottom_thirdparty' . $j . '_prefix'] = NULL;
                $client_case_array2['bottom_thirdparty' . $j . '_fname'] = NULL;
                $client_case_array2['bottom_thirdparty' . $j . '_mname'] = NULL;
                $client_case_array2['bottom_thirdparty' . $j . '_lname'] = NULL;
                $client_case_array2['bottom_thirdparty' . $j . '_phone'] = NULL;
                $client_case_array2['bottom_thirdparty' . $j . '_suffix'] = NULL;
                $client_case_array2['bottom_thirdparty' . $j . '_prefname'] = NULL;
                $client_case_array2['bottom_thirdparty' . $j . '_short_name'] = NULL;
                $client_case_array2['bottom_thirdparty' . $j . '_gender'] = NULL;
                $client_case_array2['bottom_thirdparty' . $j . '_social_sec_number'] = NULL;
                $client_case_array2['bottom_thirdparty' . $j . '_employer_identification'] = NULL;
                $client_case_array2['bottom_thirdparty' . $j . '_date_of_birth'] = NULL;
                $client_case_array2['bottom_thirdparty' . $j . '_zipcode'] = NULL;
                $client_case_array2['bottom_thirdparty' . $j . '_street_address'] = NULL;
                $client_case_array2['bottom_thirdparty' . $j . '_city_name'] = NULL;
                $client_case_array2['bottom_thirdparty' . $j . '_state_name'] = NULL;
                $client_case_array2['bottom_thirdparty' . $j . '_county_name'] = NULL;
                $client_case_array2['bottom_thirdparty' . $j . '_fax'] = NULL;
                $client_case_array2['bottom_thirdparty' . $j . '_primary_language'] = NULL;
                $client_case_array2['bottom_thirdparty' . $j . '_req_lang_trans'] = NULL;
                $client_case_array2['bottom_thirdparty' . $j . '_hearing_impaired'] = NULL;
                $client_case_array2['bottom_thirdparty' . $j . '_req_sign_lang'] = NULL;
                $client_case_array2['bottom_thirdparty' . $j . '_name_unknown'] = 'No';
                $client_case_array2['bottom_thirdparty' . $j . '_address_unknown'] = 'No';
                $client_case_array2['bottom_thirdparty' . $j . '_gen_desc'] = NULL;
                $client_case_array2['bottom_thirdparty' . $j . '_is_multi_desc'] = NULL;
                $client_case_array2['bottom_thirdparty' . $j . '_more_gen_desc'] = NULL;
                $client_case_array2['bottom_thirdparty' . $j . '_pauperis'] = NULL;
                $client_case_array2['bottom_thirdparty' . $j . '_num_attys'] = '0';
            }

            // dd($client_case_array2);
            $partytypeinfoprev = CasePartyInfo::where('case_id', $request->case_id)->get()->first();
            if ($partytypeinfoprev) {
                $partytypeinfo = $partytypeinfoprev->fill($client_case_array2)->save();
            } else {
                $partytypeinfo = CasePartyInfo::create($client_case_array2);
            }
        }
        // end for third parties

        // ----------end of code to update case party info table-------------//


        return redirect()->route('cases.show_party_reg_form', ['case_id' => $request->case_id])->with('success', 'Case party registered successfully.');
        // return view('case.create_party',['case_id' => $id]);
    }

    // to show edit party details form
    public function edit_party_info_form($user_id, $case_id, $type, $number)
    {
        $case_data = Courtcase::find($case_id);
        $hascaseid = 0;
        $case_type_ids = explode(",", $case_data->case_type_ids);
        $array = array('1', '2', '3', '4', '5', '6', '7', '8', '9', '49', '50', '51', '52');
        $hascaseid = !empty(array_intersect($array, $case_type_ids));
        if (isset($case_data) && $case_data->attorney_id != Auth::user()->id) {
            return redirect()->route('home');
        }
        $user = User::find($user_id);
        if ($type == 'third') {
            $case_user = Caseuser::where([['user_id', $user_id], ['case_id', $case_id]])->whereNull('type')->get()->first();
        } else {
            $case_user = Caseuser::where([['user_id', $user_id], ['case_id', $case_id], ['type', $type]])->get()->first();
        }
        if (isset($case_user) && $case_user->attorney_id != Auth::user()->id) {
            return redirect()->route('home');
        }
        if ($user && $case_user) {
            $case_user['name'] = $user->name;
            $case_user['email'] = $user->email;
            $case_user['number'] = $number;
            $case_user_client = Caseuser::where([['attorney_id', Auth::user()->id], ['case_id', $case_id], ['type', 'client']])->get()->first();
            $already_client = '';
            if ($case_user_client && $case_user_client->party_group == 'top') {
                $already_client = 'top';
            }

            if ($case_user_client && $case_user_client->party_group == 'bottom') {
                $already_client = 'bottom';
            }

            // echo "<pre>"; print_r($case_user);die;
            return view('case.edit_party', ['client_data' => $case_user, 'case_data' => $case_data, 'already_client' => $already_client, 'hascaseid' => $hascaseid]);
        } else {
            return redirect()->route('cases.show_party_reg_form', ['case_id' => $case_id]);
        }
    }

    // to update case party details
    public function update_party(Request $request, $user_id, $case_id)
    {
        // short caption
        // $short_caption='';
        // $court_case_data=Courtcase::find($case_id);
        // if(isset($court_case_data) && $court_case_data->attorney_id!=Auth::user()->id){
        //     return redirect()->route('home');
        // }
        // if(isset($court_case_data->top_party_type)){
        //     $top_party_type=$court_case_data->top_party_type;
        //     $bottom_party_type=$court_case_data->bottom_party_type;
        // } else {
        //     $top_party_type=$court_case_data->original_top_party_type;
        //     $bottom_party_type=$court_case_data->original_bottom_party_type;
        // }

        // $caseusersclienttop=Caseuser::where([['case_id', $case_id], ['party_group', 'top']])->get()->all();
        // $count_caseusersclienttop=count($caseusersclienttop);
        // if($count_caseusersclienttop){

        //     if(isset($caseusersclienttop[0]->party_entity) && $caseusersclienttop[0]->party_entity=='organization_company' && isset($caseusersclienttop[0]->org_comp_name)){
        //         $short_caption=$caseusersclienttop[0]->org_comp_name;
        //         $short_caption.=" Corporation";
        //     } else {
        //         $short_caption=$caseusersclienttop[0]->lname;
        //     }
        //     if($count_caseusersclienttop > 1){
        //         $short_caption.=', et al.';
        //     }
        // } else {
        //     if(isset($request->party_entity) && $request->party_entity=='organization_company' && isset($request->org_comp_name)){
        //         $short_caption=$request->org_comp_name;
        //         $short_caption.=" Corporation";
        //     } else {
        //         $short_caption=$request->cllname;
        //     }
        // }

        // $caseusersclientbottom=Caseuser::where([['case_id', $case_id], ['party_group', 'bottom']])->get()->all();
        // $count_caseusersclientbottom=count($caseusersclientbottom);
        // if($count_caseusersclientbottom){
        //     if(isset($caseusersclientbottom[0]->party_entity) && $caseusersclientbottom[0]->party_entity=='organization_company' && isset($caseusersclientbottom[0]->org_comp_name)){
        //         $bottom_party_lname=$caseusersclientbottom[0]->org_comp_name;
        //         $bottom_party_lname.=" Corporation";
        //     } else {
        //         $bottom_party_lname=$caseusersclientbottom[0]->lname;
        //     }
        //     if(isset($court_case_data->case_type_ids) && ($court_case_data->case_type_ids =='1' || $court_case_data->case_type_ids =='2')){
        //         $short_caption.= " and ".$bottom_party_lname;
        //     }else {
        //         $short_caption.= " v ".$bottom_party_lname;
        //     }
        //     if($count_caseusersclientbottom > 1){
        //         $short_caption.=', et al.';
        //     }
        // } else {
        //     if(isset($request->party_entity) && $request->party_entity=='organization_company' && isset($request->org_comp_name)){
        //         $bottom_party_lname=$request->org_comp_name;
        //         $bottom_party_lname.=" Corporation";
        //     } else {
        //         $bottom_party_lname=$request->cllname;
        //     }
        //     if(isset($court_case_data->case_type_ids) && ($court_case_data->case_type_ids =='1' || $court_case_data->case_type_ids =='2')){
        //         $short_caption.= " and ".$bottom_party_lname;
        //     }else {
        //         $short_caption.= " v ".$bottom_party_lname;
        //     }
        // }

        // $court_case_data->short_caption=$short_caption;  
        // $court_case_data->save();
        // end short caption
        // update client info 
        $court_case_data = Courtcase::find($case_id);
        if (isset($court_case_data) && $court_case_data->attorney_id != Auth::user()->id) {
            return redirect()->route('home');
        }
        $initial_party_type = $request->initial_party_type;
        $type = $request->party_type;
        $clfname = $request->clfname;
        $cllname = $request->cllname;

        if (isset($request->party_type) && $request->party_type != 'client') {
            if (isset($request->name_unknown) && $request->name_unknown == 'Yes') {
                $name_unknown = $request->name_unknown;
                $clfname = 'Name(s)';
                $cllname = 'Unknown';
                if (isset($request->gen_desc) && $request->gen_desc != '') {
                    $gen_desc = $request->gen_desc;
                } else {
                    $gen_desc = NULL;
                }
                if (isset($request->is_multi_desc) && $request->is_multi_desc == 'Yes') {
                    $is_multi_desc = $request->is_multi_desc;
                    if (isset($request->more_gen_desc) && $request->more_gen_desc != '') {
                        $more_gen_desc = $request->more_gen_desc;
                    } else {
                        $more_gen_desc = NULL;
                    }
                } else {
                    $is_multi_desc = 'No';
                    $more_gen_desc = NULL;
                }
            } else {
                $name_unknown = 'No';
                $gen_desc = NULL;
                $is_multi_desc = 'No';
                $more_gen_desc = NULL;
            }
            if (isset($request->address_unknown) && $request->address_unknown == 'Yes') {
                $address_unknown = 'Yes';
                $request->merge([
                    'clzip' => NULL,
                    'clstate' => NULL,
                    'clcounty' => NULL,
                    'clcity' => NULL,
                    'clstreetad' => NULL,
                ]);
            } else {
                $address_unknown = 'No';
            }
        } else {
            $name_unknown = 'No';
            $gen_desc = NULL;
            $is_multi_desc = 'No';
            $more_gen_desc = NULL;
            $address_unknown = 'No';
        }

        if (isset($clfname) && isset($cllname)) {
            $clname = $clfname . ' ' . $cllname;
        } else {
            if ($request->party_entity == 'organization_company') {
                $clname = $request->org_comp_name;
            } else {
                $clname = $clfname . ' ' . $cllname;
            }
        }



        // $clemail=$request->clemail;
        if ((!isset($request->clemail) || $request->clemail == '') && $request->party_type != 'client') {
            if (isset($request->op_ally_email) && $request->op_ally_email != '') {
                $clemail = $request->op_ally_email;
            } else {
                $clemail = 'unknown_' . $request->case_id . '_' . Carbon::now()->timestamp . '@firstdraftdata.com';
            }
        } else {
            $clemail = $request->clemail;
        }
        $user_client = User::where('email', $clemail)->first();
        if ($user_client) {
            $user_client->name = $clname;
            if ($request->party_type == 'client') {
                // $user_client->active='1';
            }
            $user_client->save();
        } else {
            $client_user_array = array(
                'name' => $clfname . ' ' . $cllname,
                'email' => $clemail,
                'password' => Hash::make($clfname . $cllname),
                'created_at' => now(),
                'updated_at' => now(),
            );
            Session::put('entered_password', $clfname . $cllname);
            Session::put('is_client', true);
            $user_client = User::create($client_user_array);
            $user_client->assignRole('client');
            if ($request->party_type == 'client') {
                // $user_client->active='1';
            }
            $user_client->save();
        }

        if ($request->cldob) {
            $cldob = date("Y-m-d", strtotime($request->cldob));
        } else {
            $cldob = $request->cldob;
        }
        $clprimlang = $request->clprimlang;
        if ($clprimlang == 'OTHER') {
            $clprimlang = ucwords($request->client_primlang_other);
        }
        $clssno = $request->clssno;
        $care_of = $request->care_of;
        $employer_identification = $request->employer_identification;
        $org_comp_name = $request->org_comp_name;
        if ($request->party_entity == 'individual') {
            $org_comp_name = NULL;
            $employer_identification = NULL;
            $care_of = NULL;
            $pauperis = $request->pauperis;
        } else {
            $cldob = NULL;
            $clssno = NULL;
            $pauperis = 'No';
        }

        // for designations
        $designation1 = NULL;
        $designation2 = NULL;
        $designation3 = NULL;
        $designation4 = NULL;
        $designation5 = NULL;
        if ($request->party_group == 'top' || $request->party_group == 'bottom') {
            $designation1 = $request->designation1;
            $designation2 = $request->designation2;
            $designation3 = $request->designation3;
            if (isset($request->designation4) || isset($request->designation5)) {
                $designation4 = $request->designation4;
                $designation5 = $request->designation5;
            }
        } else {
            $type = NULL;
            if (isset($request->designation4) || isset($request->designation5)) {
                $designation4 = $request->designation4;
                $designation5 = $request->designation5;
            }
        }
        if ($initial_party_type == NULL) {
            $client_case_user = Caseuser::where('attorney_id', Auth::user()->id)->where('case_id', $case_id)->where('user_id', $user_id)->whereNull('type')->first();
        } else {
            $client_case_user = Caseuser::where('attorney_id', Auth::user()->id)->where('case_id', $case_id)->where('user_id', $user_id)->where('type', $initial_party_type)->first();
        }
        $client_case_user->user_id = $user_client->id;
        $client_case_user->attorney_id = Auth::user()->id;
        $client_case_user->type = $type;
        $client_case_user->care_of = $care_of;
        $client_case_user->party_entity = $request->party_entity;
        $client_case_user->org_comp_name = $org_comp_name;
        $client_case_user->prefix = $request->clprefix;
        $client_case_user->fname = $clfname;
        $client_case_user->mname = $request->clmname;
        $client_case_user->lname = $cllname;
        $client_case_user->telephone = $request->clphone;
        $client_case_user->suffix = $request->clsuffix;
        $client_case_user->prefname = $request->clprefname;
        $client_case_user->short_name = $request->short_name;
        $client_case_user->gender = $request->clgender;
        $client_case_user->social_sec_number = $clssno;
        $client_case_user->employer_identification = $employer_identification;
        $client_case_user->date_of_birth = $cldob;
        $client_case_user->user_zipcode = $request->clzip;
        $client_case_user->street_address = $request->clstreetad;
        $client_case_user->user_city = $request->clcity;
        $client_case_user->state_id = $request->clstate;
        $client_case_user->county_id = $request->clcounty;
        $client_case_user->fax = $request->clfax;
        $client_case_user->primary_language = $clprimlang;
        $client_case_user->req_lang_trans = $request->clreqlangtrans;
        $client_case_user->hearing_impaired = $request->clhearingimpaired;
        $client_case_user->req_sign_lang = $request->clreqsignlang;
        $client_case_user->unit = $request->unit;
        $client_case_user->pobox = $request->pobox;
        $client_case_user->designation1 = $designation1;
        $client_case_user->designation2 = $designation2;
        $client_case_user->designation3 = $designation3;
        $client_case_user->designation4 = $designation4;
        $client_case_user->designation5 = $designation5;
        $client_case_user->name_unknown = $name_unknown;
        $client_case_user->gen_desc = $gen_desc;
        $client_case_user->is_multi_desc = $is_multi_desc;
        $client_case_user->more_gen_desc = $more_gen_desc;
        $client_case_user->address_unknown = $address_unknown;
        $client_case_user->pauperis = $pauperis;
        if (isset($request->relation)) {
            $client_case_user->relation = $request->relation;
        }

        $client_case_user->updated_at = now();

        // echo "<pre>"; print_r($client_case_user);die;
        $client_case_user->save();

        // ----------fololowing code is to update case party info table-------------//
        if ($request->party_group == 'top' || $request->party_group == 'bottom') {
            $casetopparties = Caseuser::where([['case_id', $case_id], ['party_group', 'top']])->get()->all();
            $casebottomparties = Caseuser::where([['case_id', $case_id], ['party_group', 'bottom']])->get()->all();
            $client_case_array2 = array(
                'case_id' => $case_id,
            );
            $i = 0;
            $num = 0;
            foreach ($casetopparties as $casetopparty) {
                $name = User::where('id', $casetopparty['user_id'])->get()->pluck('name')->first();
                $fullname = $name;
                if (isset($casetopparty['party_entity']) && $casetopparty['party_entity'] == 'organization_company') {
                    $fullname = $casetopparty['org_comp_name'];
                } else {
                    $mname = $casetopparty['mname'];
                    if (isset($mname) && $mname != '') {
                        $namearray = explode(' ', $name, 2);
                        if (count($namearray) > 1) {
                            $fullname = $namearray[0] . ' ' . $mname . ' ' . $namearray[1];
                        } else {
                            $fullname = $name . ' ' . $mname;
                        }
                    } else {
                        $fullname = $name;
                    }
                }

                $casetopparties[$i]['name'] = $fullname;

                if (isset($casetopparty['state_id']) && $casetopparty['state_id'] != '') {
                    $casetopparties[$i]['state_name'] = DB::table('states')->where('id', $casetopparty['state_id'])->get()->pluck('state')->first();
                } else {
                    $casetopparties[$i]['state_name'] = NULL;
                }
                if (isset($casetopparty['county_id']) && $casetopparty['county_id'] != '') {
                    $casetopparties[$i]['county_name'] = DB::table('counties')->where('id', $casetopparty['county_id'])->get()->pluck('county_name')->first();
                } else {
                    $casetopparties[$i]['county_name'] = NULL;
                }
                $num++;
                $client_case_array2['topparty' . $num . '_user_id'] = $casetopparty['user_id'];
                $client_case_array2['topparty' . $num . '_name'] = $casetopparties[$i]['name'];
                $client_case_array2['topparty' . $num . '_party_group'] = $casetopparty['party_group'];
                $client_case_array2['topparty' . $num . '_org_comp_name'] = $casetopparty['org_comp_name'];
                $client_case_array2['topparty' . $num . '_type'] = $casetopparty['type'];
                $client_case_array2['topparty' . $num . '_care_of'] = $casetopparty['care_of'];
                $client_case_array2['topparty' . $num . '_prefix'] = $casetopparty['prefix'];
                $client_case_array2['topparty' . $num . '_fname'] = $casetopparty['fname'];
                $client_case_array2['topparty' . $num . '_mname'] = $casetopparty['mname'];
                $client_case_array2['topparty' . $num . '_lname'] = $casetopparty['lname'];
                $client_case_array2['topparty' . $num . '_phone'] = $casetopparty['telephone'];
                $client_case_array2['topparty' . $num . '_suffix'] = $casetopparty['suffix'];
                $client_case_array2['topparty' . $num . '_prefname'] = $casetopparty['prefname'];
                $client_case_array2['topparty' . $num . '_short_name'] = $casetopparty['short_name'];
                $client_case_array2['topparty' . $num . '_gender'] = $casetopparty['gender'];
                $client_case_array2['topparty' . $num . '_social_sec_number'] = $casetopparty['social_sec_number'];
                $client_case_array2['topparty' . $num . '_employer_identification'] = $casetopparty['employer_identification'];
                $client_case_array2['topparty' . $num . '_date_of_birth'] = $casetopparty['date_of_birth'];
                $client_case_array2['topparty' . $num . '_zipcode'] = $casetopparty['user_zipcode'];
                $client_case_array2['topparty' . $num . '_street_address'] = $casetopparty['street_address'];
                $client_case_array2['topparty' . $num . '_city_name'] = $casetopparty['user_city'];
                $client_case_array2['topparty' . $num . '_state_name'] = $casetopparties[$i]['state_name'];
                $client_case_array2['topparty' . $num . '_county_name'] = $casetopparties[$i]['county_name'];
                $client_case_array2['topparty' . $num . '_fax'] = $casetopparty['fax'];
                $client_case_array2['topparty' . $num . '_primary_language'] = $casetopparty['primary_language'];
                $client_case_array2['topparty' . $num . '_req_lang_trans'] = $casetopparty['req_lang_trans'];
                $client_case_array2['topparty' . $num . '_hearing_impaired'] = $casetopparty['hearing_impaired'];
                $client_case_array2['topparty' . $num . '_req_sign_lang'] = $casetopparty['req_sign_lang'];
                $client_case_array2['topparty' . $num . '_name_unknown'] = $casetopparty['name_unknown'];
                $client_case_array2['topparty' . $num . '_address_unknown'] = $casetopparty['address_unknown'];
                $client_case_array2['topparty' . $num . '_gen_desc'] = $casetopparty['gen_desc'];
                $client_case_array2['topparty' . $num . '_is_multi_desc'] = $casetopparty['is_multi_desc'];
                $client_case_array2['topparty' . $num . '_more_gen_desc'] = $casetopparty['more_gen_desc'];
                $client_case_array2['topparty' . $num . '_pauperis'] = $casetopparty['pauperis'];
                $client_case_array2['tp_child_relation' . $num] = $casetopparty['relation'];

                $i++;
            }
            $limit = $num + 1;
            for ($j = $limit; $j <= 6; $j++) {
                $client_case_array2['topparty' . $j . '_user_id'] = NULL;
                $client_case_array2['topparty' . $j . '_name'] = NULL;
                $client_case_array2['topparty' . $j . '_party_group'] = NULL;
                $client_case_array2['topparty' . $j . '_org_comp_name'] = NULL;
                $client_case_array2['topparty' . $j . '_type'] = NULL;
                $client_case_array2['topparty' . $j . '_care_of'] = NULL;
                $client_case_array2['topparty' . $j . '_prefix'] = NULL;
                $client_case_array2['topparty' . $j . '_fname'] = NULL;
                $client_case_array2['topparty' . $j . '_mname'] = NULL;
                $client_case_array2['topparty' . $j . '_lname'] = NULL;
                $client_case_array2['topparty' . $j . '_phone'] = NULL;
                $client_case_array2['topparty' . $j . '_suffix'] = NULL;
                $client_case_array2['topparty' . $j . '_prefname'] = NULL;
                $client_case_array2['topparty' . $j . '_short_name'] = NULL;
                $client_case_array2['topparty' . $j . '_gender'] = NULL;
                $client_case_array2['topparty' . $j . '_social_sec_number'] = NULL;
                $client_case_array2['topparty' . $j . '_employer_identification'] = NULL;
                $client_case_array2['topparty' . $j . '_date_of_birth'] = NULL;
                $client_case_array2['topparty' . $j . '_zipcode'] = NULL;
                $client_case_array2['topparty' . $j . '_street_address'] = NULL;
                $client_case_array2['topparty' . $j . '_city_name'] = NULL;
                $client_case_array2['topparty' . $j . '_state_name'] = NULL;
                $client_case_array2['topparty' . $j . '_county_name'] = NULL;
                $client_case_array2['topparty' . $j . '_fax'] = NULL;
                $client_case_array2['topparty' . $j . '_primary_language'] = NULL;
                $client_case_array2['topparty' . $j . '_req_lang_trans'] = NULL;
                $client_case_array2['topparty' . $j . '_hearing_impaired'] = NULL;
                $client_case_array2['topparty' . $j . '_req_sign_lang'] = NULL;
                $client_case_array2['topparty' . $j . '_name_unknown'] = 'No';
                $client_case_array2['topparty' . $j . '_address_unknown'] = 'No';
                $client_case_array2['topparty' . $j . '_gen_desc'] = NULL;
                $client_case_array2['topparty' . $j . '_is_multi_desc'] = NULL;
                $client_case_array2['topparty' . $j . '_more_gen_desc'] = NULL;
                $client_case_array2['topparty' . $j . '_pauperis'] = NULL;
                $client_case_array2['topparty' . $j . '_num_attys'] = '0';
                $client_case_array2['tp_child_relation' . $j] = Null;
            }
            $i = 0;
            $num = 0;
            foreach ($casebottomparties as $casebottomparty) {
                $name = User::where('id', $casebottomparty['user_id'])->get()->pluck('name')->first();
                $fullname = $name;
                if (isset($casebottomparty['party_entity']) && $casebottomparty['party_entity'] == 'organization_company') {
                    $fullname = $casebottomparty['org_comp_name'];
                } else {
                    $mname = $casebottomparty['mname'];
                    if (isset($mname) && $mname != '') {
                        $namearray = explode(' ', $name, 2);
                        if (count($namearray) > 1) {
                            $fullname = $namearray[0] . ' ' . $mname . ' ' . $namearray[1];
                        } else {
                            $fullname = $name . ' ' . $mname;
                        }
                    } else {
                        $fullname = $name;
                    }
                }

                $casebottomparties[$i]['name'] = $fullname;

                // $casebottomparties[$i]['state_name']=DB::table('states')->where('id',$casebottomparty['state_id'])->get()->pluck('state')->first();
                // $casebottomparties[$i]['county_name']=DB::table('counties')->where('id',$casebottomparty['state_id'])->get()->pluck('county_name')->first();

                if (isset($casebottomparty['state_id']) && $casebottomparty['state_id'] != '') {
                    $casebottomparties[$i]['state_name'] = DB::table('states')->where('id', $casebottomparty['state_id'])->get()->pluck('state')->first();
                } else {
                    $casebottomparties[$i]['state_name'] = NULL;
                }
                if (isset($casebottomparty['county_id']) && $casebottomparty['county_id'] != '') {
                    $casebottomparties[$i]['county_name'] = DB::table('counties')->where('id', $casebottomparty['county_id'])->get()->pluck('county_name')->first();
                } else {
                    $casebottomparties[$i]['county_name'] = NULL;
                }

                $num++;

                $client_case_array2['bottomparty' . $num . '_user_id'] = $casebottomparty['user_id'];
                $client_case_array2['bottomparty' . $num . '_name'] = $casebottomparties[$i]['name'];
                $client_case_array2['bottomparty' . $num . '_party_group'] = $casebottomparty['party_group'];
                $client_case_array2['bottomparty' . $num . '_org_comp_name'] = $casebottomparty['org_comp_name'];
                $client_case_array2['bottomparty' . $num . '_type'] = $casebottomparty['type'];
                $client_case_array2['bottomparty' . $num . '_care_of'] = $casebottomparty['care_of'];
                $client_case_array2['bottomparty' . $num . '_prefix'] = $casebottomparty['prefix'];
                $client_case_array2['bottomparty' . $num . '_fname'] = $casebottomparty['fname'];
                $client_case_array2['bottomparty' . $num . '_mname'] = $casebottomparty['mname'];
                $client_case_array2['bottomparty' . $num . '_lname'] = $casebottomparty['lname'];
                $client_case_array2['bottomparty' . $num . '_phone'] = $casebottomparty['telephone'];
                $client_case_array2['bottomparty' . $num . '_suffix'] = $casebottomparty['suffix'];
                $client_case_array2['bottomparty' . $num . '_prefname'] = $casebottomparty['prefname'];
                $client_case_array2['bottomparty' . $num . '_short_name'] = $casebottomparty['short_name'];
                $client_case_array2['bottomparty' . $num . '_gender'] = $casebottomparty['gender'];
                $client_case_array2['bottomparty' . $num . '_social_sec_number'] = $casebottomparty['social_sec_number'];
                $client_case_array2['bottomparty' . $num . '_employer_identification'] = $casebottomparty['employer_identification'];
                $client_case_array2['bottomparty' . $num . '_date_of_birth'] = $casebottomparty['date_of_birth'];
                $client_case_array2['bottomparty' . $num . '_zipcode'] = $casebottomparty['user_zipcode'];
                $client_case_array2['bottomparty' . $num . '_street_address'] = $casebottomparty['street_address'];
                $client_case_array2['bottomparty' . $num . '_city_name'] = $casebottomparty['user_city'];
                $client_case_array2['bottomparty' . $num . '_state_name'] = $casebottomparties[$i]['state_name'];
                $client_case_array2['bottomparty' . $num . '_county_name'] = $casebottomparties[$i]['county_name'];
                $client_case_array2['bottomparty' . $num . '_fax'] = $casebottomparty['fax'];
                $client_case_array2['bottomparty' . $num . '_primary_language'] = $casebottomparty['primary_language'];
                $client_case_array2['bottomparty' . $num . '_req_lang_trans'] = $casebottomparty['req_lang_trans'];
                $client_case_array2['bottomparty' . $num . '_hearing_impaired'] = $casebottomparty['hearing_impaired'];
                $client_case_array2['bottomparty' . $num . '_req_sign_lang'] = $casebottomparty['req_sign_lang'];
                $client_case_array2['bottomparty' . $num . '_name_unknown'] = $casebottomparty['name_unknown'];
                $client_case_array2['bottomparty' . $num . '_address_unknown'] = $casebottomparty['address_unknown'];
                $client_case_array2['bottomparty' . $num . '_gen_desc'] = $casebottomparty['gen_desc'];
                $client_case_array2['bottomparty' . $num . '_is_multi_desc'] = $casebottomparty['is_multi_desc'];
                $client_case_array2['bottomparty' . $num . '_more_gen_desc'] = $casebottomparty['more_gen_desc'];
                $client_case_array2['bottomparty' . $num . '_pauperis'] = $casebottomparty['pauperis'];
                $client_case_array2['bp_child_relation' . $num] = $casebottomparty['relation'];

                $i++;
            }
            $limit = $num + 1;
            // echo($num);
            // die();
            for ($j = $limit; $j <= 6; $j++) {
                $client_case_array2['bottomparty' . $j . '_user_id'] = NULL;
                $client_case_array2['bottomparty' . $j . '_name'] = NULL;
                $client_case_array2['bottomparty' . $j . '_party_group'] = NULL;
                $client_case_array2['bottomparty' . $j . '_org_comp_name'] = NULL;
                $client_case_array2['bottomparty' . $j . '_type'] = NULL;
                $client_case_array2['bottomparty' . $j . '_care_of'] = NULL;
                $client_case_array2['bottomparty' . $j . '_prefix'] = NULL;
                $client_case_array2['bottomparty' . $j . '_fname'] = NULL;
                $client_case_array2['bottomparty' . $j . '_mname'] = NULL;
                $client_case_array2['bottomparty' . $j . '_lname'] = NULL;
                $client_case_array2['bottomparty' . $j . '_phone'] = NULL;
                $client_case_array2['bottomparty' . $j . '_suffix'] = NULL;
                $client_case_array2['bottomparty' . $j . '_prefname'] = NULL;
                $client_case_array2['bottomparty' . $j . '_short_name'] = NULL;
                $client_case_array2['bottomparty' . $j . '_gender'] = NULL;
                $client_case_array2['bottomparty' . $j . '_social_sec_number'] = NULL;
                $client_case_array2['bottomparty' . $j . '_employer_identification'] = NULL;
                $client_case_array2['bottomparty' . $j . '_date_of_birth'] = NULL;
                $client_case_array2['bottomparty' . $j . '_zipcode'] = NULL;
                $client_case_array2['bottomparty' . $j . '_street_address'] = NULL;
                $client_case_array2['bottomparty' . $j . '_city_name'] = NULL;
                $client_case_array2['bottomparty' . $j . '_state_name'] = NULL;
                $client_case_array2['bottomparty' . $j . '_county_name'] = NULL;
                $client_case_array2['bottomparty' . $j . '_fax'] = NULL;
                $client_case_array2['bottomparty' . $j . '_primary_language'] = NULL;
                $client_case_array2['bottomparty' . $j . '_req_lang_trans'] = NULL;
                $client_case_array2['bottomparty' . $j . '_hearing_impaired'] = NULL;
                $client_case_array2['bottomparty' . $j . '_req_sign_lang'] = NULL;
                $client_case_array2['bottomparty' . $j . '_name_unknown'] = 'No';
                $client_case_array2['bottomparty' . $j . '_address_unknown'] = 'No';
                $client_case_array2['bottomparty' . $j . '_gen_desc'] = NULL;
                $client_case_array2['bottomparty' . $j . '_is_multi_desc'] = NULL;
                $client_case_array2['bottomparty' . $j . '_more_gen_desc'] = NULL;
                $client_case_array2['bottomparty' . $j . '_pauperis'] = NULL;
                $client_case_array2['bottomparty' . $j . '_num_attys'] = '0';
                $client_case_array2['bp_child_relation' . $j] = Null;
            }

            $partytypeinfoprev = CasePartyInfo::where('case_id', $case_id)->get()->first();
            if ($partytypeinfoprev) {
                $partytypeinfo = $partytypeinfoprev->fill($client_case_array2)->save();
            } else {
                // $partytypeinfo=CasePartyInfo::create($client_case_array2);
            }
        }

        // for third parties
        if ($request->party_group == 'top_third' || $request->party_group == 'bottom_third') {
            $casetop_thirdparties = Caseuser::where([['case_id', $request->case_id], ['party_group', 'top_third']])->get()->all();
            $casebottom_thirdparties = Caseuser::where([['case_id', $request->case_id], ['party_group', 'bottom_third']])->get()->all();
            $client_case_array2 = array(
                'case_id' => $request->case_id,
            );
            $i = 0;
            $num = 0;
            foreach ($casetop_thirdparties as $casetop_thirdparty) {
                $name = User::where('id', $casetop_thirdparty['user_id'])->get()->pluck('name')->first();
                $fullname = $name;
                if (isset($casetop_thirdparty['party_entity']) && $casetop_thirdparty['party_entity'] == 'organization_company') {
                    $fullname = $casetop_thirdparty['org_comp_name'];
                } else {
                    $mname = $casetop_thirdparty['mname'];
                    if (isset($mname) && $mname != '') {
                        $namearray = explode(' ', $name, 2);
                        if (count($namearray) > 1) {
                            $fullname = $namearray[0] . ' ' . $mname . ' ' . $namearray[1];
                        } else {
                            $fullname = $name . ' ' . $mname;
                        }
                    } else {
                        $fullname = $name;
                    }
                }

                $casetop_thirdparties[$i]['name'] = $fullname;

                // $casetop_thirdparties[$i]['state_name']=DB::table('states')->where('id',$casetop_thirdparty['state_id'])->get()->pluck('state')->first();
                // $casetop_thirdparties[$i]['county_name']=DB::table('counties')->where('id',$casetop_thirdparty['state_id'])->get()->pluck('county_name')->first();

                if (isset($casetop_thirdparty['state_id']) && $casetop_thirdparty['state_id'] != '') {
                    $casetop_thirdparties[$i]['state_name'] = DB::table('states')->where('id', $casetop_thirdparty['state_id'])->get()->pluck('state')->first();
                } else {
                    $casetop_thirdparties[$i]['state_name'] = NULL;
                }
                if (isset($casetop_thirdparty['county_id']) && $casetop_thirdparty['county_id'] != '') {
                    $casetop_thirdparties[$i]['county_name'] = DB::table('counties')->where('id', $casetop_thirdparty['county_id'])->get()->pluck('county_name')->first();
                } else {
                    $casetop_thirdparties[$i]['county_name'] = NULL;
                }

                $num++;
                $client_case_array2['top_thirdparty' . $num . '_user_id'] = $casetop_thirdparty['user_id'];
                $client_case_array2['top_thirdparty' . $num . '_name'] = $casetop_thirdparties[$i]['name'];
                $client_case_array2['top_thirdparty' . $num . '_party_group'] = $casetop_thirdparty['party_group'];
                $client_case_array2['top_thirdparty' . $num . '_org_comp_name'] = $casetop_thirdparty['org_comp_name'];
                $client_case_array2['top_thirdparty' . $num . '_type'] = $casetop_thirdparty['type'];
                $client_case_array2['top_thirdparty' . $num . '_care_of'] = $casetop_thirdparty['care_of'];
                $client_case_array2['top_thirdparty' . $num . '_prefix'] = $casetop_thirdparty['prefix'];
                $client_case_array2['top_thirdparty' . $num . '_fname'] = $casetop_thirdparty['fname'];
                $client_case_array2['top_thirdparty' . $num . '_mname'] = $casetop_thirdparty['mname'];
                $client_case_array2['top_thirdparty' . $num . '_lname'] = $casetop_thirdparty['lname'];
                $client_case_array2['top_thirdparty' . $num . '_phone'] = $casetop_thirdparty['telephone'];
                $client_case_array2['top_thirdparty' . $num . '_suffix'] = $casetop_thirdparty['suffix'];
                $client_case_array2['top_thirdparty' . $num . '_prefname'] = $casetop_thirdparty['prefname'];
                $client_case_array2['top_thirdparty' . $num . '_short_name'] = $casetop_thirdparty['short_name'];
                $client_case_array2['top_thirdparty' . $num . '_gender'] = $casetop_thirdparty['gender'];
                $client_case_array2['top_thirdparty' . $num . '_social_sec_number'] = $casetop_thirdparty['social_sec_number'];
                $client_case_array2['top_thirdparty' . $num . '_employer_identification'] = $casetop_thirdparty['employer_identification'];
                $client_case_array2['top_thirdparty' . $num . '_date_of_birth'] = $casetop_thirdparty['date_of_birth'];
                $client_case_array2['top_thirdparty' . $num . '_zipcode'] = $casetop_thirdparty['user_zipcode'];
                $client_case_array2['top_thirdparty' . $num . '_street_address'] = $casetop_thirdparty['street_address'];
                $client_case_array2['top_thirdparty' . $num . '_city_name'] = $casetop_thirdparty['user_city'];
                $client_case_array2['top_thirdparty' . $num . '_state_name'] = $casetop_thirdparties[$i]['state_name'];
                $client_case_array2['top_thirdparty' . $num . '_county_name'] = $casetop_thirdparties[$i]['county_name'];
                $client_case_array2['top_thirdparty' . $num . '_fax'] = $casetop_thirdparty['fax'];
                $client_case_array2['top_thirdparty' . $num . '_primary_language'] = $casetop_thirdparty['primary_language'];
                $client_case_array2['top_thirdparty' . $num . '_req_lang_trans'] = $casetop_thirdparty['req_lang_trans'];
                $client_case_array2['top_thirdparty' . $num . '_hearing_impaired'] = $casetop_thirdparty['hearing_impaired'];
                $client_case_array2['top_thirdparty' . $num . '_req_sign_lang'] = $casetop_thirdparty['req_sign_lang'];
                $client_case_array2['top_thirdparty' . $num . '_name_unknown'] = $casetop_thirdparty['name_unknown'];
                $client_case_array2['top_thirdparty' . $num . '_address_unknown'] = $casetop_thirdparty['address_unknown'];
                $client_case_array2['top_thirdparty' . $num . '_gen_desc'] = $casetop_thirdparty['gen_desc'];
                $client_case_array2['top_thirdparty' . $num . '_is_multi_desc'] = $casetop_thirdparty['is_multi_desc'];
                $client_case_array2['top_thirdparty' . $num . '_more_gen_desc'] = $casetop_thirdparty['more_gen_desc'];
                $client_case_array2['top_thirdparty' . $num . '_pauperis'] = $casetop_thirdparty['pauperis'];

                $i++;
            }
            $limit = $num + 1;
            for ($j = $limit; $j <= 3; $j++) {
                $client_case_array2['top_thirdparty' . $j . '_user_id'] = NULL;
                $client_case_array2['top_thirdparty' . $j . '_name'] = NULL;
                $client_case_array2['top_thirdparty' . $j . '_party_group'] = NULL;
                $client_case_array2['top_thirdparty' . $j . '_org_comp_name'] = NULL;
                $client_case_array2['top_thirdparty' . $j . '_type'] = NULL;
                $client_case_array2['top_thirdparty' . $j . '_care_of'] = NULL;
                $client_case_array2['top_thirdparty' . $j . '_prefix'] = NULL;
                $client_case_array2['top_thirdparty' . $j . '_fname'] = NULL;
                $client_case_array2['top_thirdparty' . $j . '_mname'] = NULL;
                $client_case_array2['top_thirdparty' . $j . '_lname'] = NULL;
                $client_case_array2['top_thirdparty' . $j . '_phone'] = NULL;
                $client_case_array2['top_thirdparty' . $j . '_suffix'] = NULL;
                $client_case_array2['top_thirdparty' . $j . '_prefname'] = NULL;
                $client_case_array2['top_thirdparty' . $j . '_short_name'] = NULL;
                $client_case_array2['top_thirdparty' . $j . '_gender'] = NULL;
                $client_case_array2['top_thirdparty' . $j . '_social_sec_number'] = NULL;
                $client_case_array2['top_thirdparty' . $j . '_employer_identification'] = NULL;
                $client_case_array2['top_thirdparty' . $j . '_date_of_birth'] = NULL;
                $client_case_array2['top_thirdparty' . $j . '_zipcode'] = NULL;
                $client_case_array2['top_thirdparty' . $j . '_street_address'] = NULL;
                $client_case_array2['top_thirdparty' . $j . '_city_name'] = NULL;
                $client_case_array2['top_thirdparty' . $j . '_state_name'] = NULL;
                $client_case_array2['top_thirdparty' . $j . '_county_name'] = NULL;
                $client_case_array2['top_thirdparty' . $j . '_fax'] = NULL;
                $client_case_array2['top_thirdparty' . $j . '_primary_language'] = NULL;
                $client_case_array2['top_thirdparty' . $j . '_req_lang_trans'] = NULL;
                $client_case_array2['top_thirdparty' . $j . '_hearing_impaired'] = NULL;
                $client_case_array2['top_thirdparty' . $j . '_req_sign_lang'] = NULL;
                $client_case_array2['top_thirdparty' . $j . '_name_unknown'] = 'No';
                $client_case_array2['top_thirdparty' . $j . '_address_unknown'] = 'No';
                $client_case_array2['top_thirdparty' . $j . '_gen_desc'] = NULL;
                $client_case_array2['top_thirdparty' . $j . '_is_multi_desc'] = NULL;
                $client_case_array2['top_thirdparty' . $j . '_more_gen_desc'] = NULL;
                $client_case_array2['top_thirdparty' . $j . '_pauperis'] = NULL;
                $client_case_array2['top_thirdparty' . $j . '_num_attys'] = '0';
            }
            $i = 0;
            $num = 0;
            foreach ($casebottom_thirdparties as $casebottom_thirdparty) {
                $name = User::where('id', $casebottom_thirdparty['user_id'])->get()->pluck('name')->first();
                $fullname = $name;
                if (isset($casebottom_thirdparty['party_entity']) && $casebottom_thirdparty['party_entity'] == 'organization_company') {
                    $fullname = $casebottom_thirdparty['org_comp_name'];
                } else {
                    $mname = $casebottom_thirdparty['mname'];
                    if (isset($mname) && $mname != '') {
                        $namearray = explode(' ', $name, 2);
                        if (count($namearray) > 1) {
                            $fullname = $namearray[0] . ' ' . $mname . ' ' . $namearray[1];
                        } else {
                            $fullname = $name . ' ' . $mname;
                        }
                    } else {
                        $fullname = $name;
                    }
                }

                $casebottom_thirdparties[$i]['name'] = $fullname;

                // $casebottom_thirdparties[$i]['state_name']=DB::table('states')->where('id',$casebottom_thirdparty['state_id'])->get()->pluck('state')->first();
                // $casebottom_thirdparties[$i]['county_name']=DB::table('counties')->where('id',$casebottom_thirdparty['state_id'])->get()->pluck('county_name')->first();

                if (isset($casebottom_thirdparty['state_id']) && $casebottom_thirdparty['state_id'] != '') {
                    $casebottom_thirdparties[$i]['state_name'] = DB::table('states')->where('id', $casebottom_thirdparty['state_id'])->get()->pluck('state')->first();
                } else {
                    $casebottom_thirdparties[$i]['state_name'] = NULL;
                }
                if (isset($casebottom_thirdparty['county_id']) && $casebottom_thirdparty['county_id'] != '') {
                    $casebottom_thirdparties[$i]['county_name'] = DB::table('counties')->where('id', $casebottom_thirdparty['county_id'])->get()->pluck('county_name')->first();
                } else {
                    $casebottom_thirdparties[$i]['county_name'] = NULL;
                }

                $num++;
                $client_case_array2['bottom_thirdparty' . $num . '_user_id'] = $casebottom_thirdparty['user_id'];
                $client_case_array2['bottom_thirdparty' . $num . '_name'] = $casebottom_thirdparties[$i]['name'];
                $client_case_array2['bottom_thirdparty' . $num . '_party_group'] = $casebottom_thirdparty['party_group'];
                $client_case_array2['bottom_thirdparty' . $num . '_org_comp_name'] = $casebottom_thirdparty['org_comp_name'];
                $client_case_array2['bottom_thirdparty' . $num . '_type'] = $casebottom_thirdparty['type'];
                $client_case_array2['bottom_thirdparty' . $num . '_care_of'] = $casebottom_thirdparty['care_of'];
                $client_case_array2['bottom_thirdparty' . $num . '_prefix'] = $casebottom_thirdparty['prefix'];
                $client_case_array2['bottom_thirdparty' . $num . '_fname'] = $casebottom_thirdparty['fname'];
                $client_case_array2['bottom_thirdparty' . $num . '_mname'] = $casebottom_thirdparty['mname'];
                $client_case_array2['bottom_thirdparty' . $num . '_lname'] = $casebottom_thirdparty['lname'];
                $client_case_array2['bottom_thirdparty' . $num . '_phone'] = $casebottom_thirdparty['telephone'];
                $client_case_array2['bottom_thirdparty' . $num . '_suffix'] = $casebottom_thirdparty['suffix'];
                $client_case_array2['bottom_thirdparty' . $num . '_prefname'] = $casebottom_thirdparty['prefname'];
                $client_case_array2['bottom_thirdparty' . $num . '_short_name'] = $casebottom_thirdparty['short_name'];
                $client_case_array2['bottom_thirdparty' . $num . '_gender'] = $casebottom_thirdparty['gender'];
                $client_case_array2['bottom_thirdparty' . $num . '_social_sec_number'] = $casebottom_thirdparty['social_sec_number'];
                $client_case_array2['bottom_thirdparty' . $num . '_employer_identification'] = $casebottom_thirdparty['employer_identification'];
                $client_case_array2['bottom_thirdparty' . $num . '_date_of_birth'] = $casebottom_thirdparty['date_of_birth'];
                $client_case_array2['bottom_thirdparty' . $num . '_zipcode'] = $casebottom_thirdparty['user_zipcode'];
                $client_case_array2['bottom_thirdparty' . $num . '_street_address'] = $casebottom_thirdparty['street_address'];
                $client_case_array2['bottom_thirdparty' . $num . '_city_name'] = $casebottom_thirdparty['user_city'];
                $client_case_array2['bottom_thirdparty' . $num . '_state_name'] = $casebottom_thirdparties[$i]['state_name'];
                $client_case_array2['bottom_thirdparty' . $num . '_county_name'] = $casebottom_thirdparties[$i]['county_name'];
                $client_case_array2['bottom_thirdparty' . $num . '_fax'] = $casebottom_thirdparty['fax'];
                $client_case_array2['bottom_thirdparty' . $num . '_primary_language'] = $casebottom_thirdparty['primary_language'];
                $client_case_array2['bottom_thirdparty' . $num . '_req_lang_trans'] = $casebottom_thirdparty['req_lang_trans'];
                $client_case_array2['bottom_thirdparty' . $num . '_hearing_impaired'] = $casebottom_thirdparty['hearing_impaired'];
                $client_case_array2['bottom_thirdparty' . $num . '_req_sign_lang'] = $casebottom_thirdparty['req_sign_lang'];
                $client_case_array2['bottom_thirdparty' . $num . '_name_unknown'] = $casebottom_thirdparty['name_unknown'];
                $client_case_array2['bottom_thirdparty' . $num . '_address_unknown'] = $casebottom_thirdparty['address_unknown'];
                $client_case_array2['bottom_thirdparty' . $num . '_gen_desc'] = $casebottom_thirdparty['gen_desc'];
                $client_case_array2['bottom_thirdparty' . $num . '_is_multi_desc'] = $casebottom_thirdparty['is_multi_desc'];
                $client_case_array2['bottom_thirdparty' . $num . '_more_gen_desc'] = $casebottom_thirdparty['more_gen_desc'];
                $client_case_array2['bottom_thirdparty' . $num . '_pauperis'] = $casebottom_thirdparty['pauperis'];

                $i++;
            }
            $limit = $num + 1;
            for ($j = $limit; $j <= 3; $j++) {
                $client_case_array2['bottom_thirdparty' . $j . '_user_id'] = NULL;
                $client_case_array2['bottom_thirdparty' . $j . '_name'] = NULL;
                $client_case_array2['bottom_thirdparty' . $j . '_party_group'] = NULL;
                $client_case_array2['bottom_thirdparty' . $j . '_org_comp_name'] = NULL;
                $client_case_array2['bottom_thirdparty' . $j . '_type'] = NULL;
                $client_case_array2['bottom_thirdparty' . $j . '_care_of'] = NULL;
                $client_case_array2['bottom_thirdparty' . $j . '_prefix'] = NULL;
                $client_case_array2['bottom_thirdparty' . $j . '_fname'] = NULL;
                $client_case_array2['bottom_thirdparty' . $j . '_mname'] = NULL;
                $client_case_array2['bottom_thirdparty' . $j . '_lname'] = NULL;
                $client_case_array2['bottom_thirdparty' . $j . '_phone'] = NULL;
                $client_case_array2['bottom_thirdparty' . $j . '_suffix'] = NULL;
                $client_case_array2['bottom_thirdparty' . $j . '_prefname'] = NULL;
                $client_case_array2['bottom_thirdparty' . $j . '_short_name'] = NULL;
                $client_case_array2['bottom_thirdparty' . $j . '_gender'] = NULL;
                $client_case_array2['bottom_thirdparty' . $j . '_social_sec_number'] = NULL;
                $client_case_array2['bottom_thirdparty' . $j . '_employer_identification'] = NULL;
                $client_case_array2['bottom_thirdparty' . $j . '_date_of_birth'] = NULL;
                $client_case_array2['bottom_thirdparty' . $j . '_zipcode'] = NULL;
                $client_case_array2['bottom_thirdparty' . $j . '_street_address'] = NULL;
                $client_case_array2['bottom_thirdparty' . $j . '_city_name'] = NULL;
                $client_case_array2['bottom_thirdparty' . $j . '_state_name'] = NULL;
                $client_case_array2['bottom_thirdparty' . $j . '_county_name'] = NULL;
                $client_case_array2['bottom_thirdparty' . $j . '_fax'] = NULL;
                $client_case_array2['bottom_thirdparty' . $j . '_primary_language'] = NULL;
                $client_case_array2['bottom_thirdparty' . $j . '_req_lang_trans'] = NULL;
                $client_case_array2['bottom_thirdparty' . $j . '_hearing_impaired'] = NULL;
                $client_case_array2['bottom_thirdparty' . $j . '_req_sign_lang'] = NULL;
                $client_case_array2['bottom_thirdparty' . $j . '_name_unknown'] = 'No';
                $client_case_array2['bottom_thirdparty' . $j . '_address_unknown'] = 'No';
                $client_case_array2['bottom_thirdparty' . $j . '_gen_desc'] = NULL;
                $client_case_array2['bottom_thirdparty' . $j . '_is_multi_desc'] = NULL;
                $client_case_array2['bottom_thirdparty' . $j . '_more_gen_desc'] = NULL;
                $client_case_array2['bottom_thirdparty' . $j . '_pauperis'] = NULL;
                $client_case_array2['bottom_thirdparty' . $j . '_num_attys'] = '0';
            }

            // dd($client_case_array2);
            $partytypeinfoprev = CasePartyInfo::where('case_id', $request->case_id)->get()->first();
            if ($partytypeinfoprev) {
                $partytypeinfo = $partytypeinfoprev->fill($client_case_array2)->save();
            } else {
                //$partytypeinfo=CasePartyInfo::create($client_case_array2);
            }
        }
        // end for third parties
        // ----------end of code to update case party info table-------------//

        return redirect()->route('cases.show_party_reg_form', ['case_id' => $case_id])->with('success', 'Case party details updated successfully.');
    }

    // delete party from a case
    public function delete_party($user_id, $case_id, $type, $party_group)
    {
        $court_case_data = Courtcase::find($case_id);
        if (isset($court_case_data) && $court_case_data->attorney_id != Auth::user()->id) {
            return redirect()->route('home');
        }

        if ($type == 'third') {
            Caseuser::where([['user_id', $user_id], ['case_id', $case_id], ['party_group', $party_group], ['attorney_id',  Auth::user()->id]])->whereNull('type')->delete();
        } else {
            Caseuser::where([['user_id', $user_id], ['case_id', $case_id], ['type', $type], ['party_group', $party_group], ['attorney_id',  Auth::user()->id]])->delete();
        }

        // short caption
        // $short_caption='';
        // $court_case_data=Courtcase::find($case_id);
        // if(isset($court_case_data) && $court_case_data->attorney_id!=Auth::user()->id){
        //     return redirect()->route('home');
        // }
        // if(isset($court_case_data->top_party_type)){
        //     $top_party_type=$court_case_data->top_party_type;
        //     $bottom_party_type=$court_case_data->bottom_party_type;
        // } else {
        //     $top_party_type=$court_case_data->original_top_party_type;
        //     $bottom_party_type=$court_case_data->original_bottom_party_type;
        // }

        // $caseusersclienttop=Caseuser::where([['case_id', $case_id], ['party_group', 'top']])->get()->all();
        // $count_caseusersclienttop=count($caseusersclienttop);
        // if($count_caseusersclienttop){

        //     if(isset($caseusersclienttop[0]->party_entity) && $caseusersclienttop[0]->party_entity=='organization_company' && isset($caseusersclienttop[0]->org_comp_name)){
        //         $short_caption=$caseusersclienttop[0]->org_comp_name;
        //         $short_caption.=" Corporation";
        //     } else {
        //         $short_caption=$caseusersclienttop[0]->lname;
        //     }
        //     if($count_caseusersclienttop > 1){
        //         $short_caption.=', et al.';
        //     }
        // }

        // $caseusersclientbottom=Caseuser::where([['case_id', $case_id], ['party_group', 'bottom']])->get()->all();
        // $count_caseusersclientbottom=count($caseusersclientbottom);
        // if($count_caseusersclientbottom){
        //     if(isset($caseusersclientbottom[0]->party_entity) && $caseusersclientbottom[0]->party_entity=='organization_company' && isset($caseusersclientbottom[0]->org_comp_name)){
        //         $bottom_party_lname=$caseusersclientbottom[0]->org_comp_name;
        //         $bottom_party_lname.=" Corporation";
        //     } else {
        //         $bottom_party_lname=$caseusersclientbottom[0]->lname;
        //     }
        //     if(isset($court_case_data->case_type_ids) && ($court_case_data->case_type_ids =='1' || $court_case_data->case_type_ids =='2')){
        //         $short_caption.= " and ".$bottom_party_lname;
        //     }else {
        //         $short_caption.= " v ".$bottom_party_lname;
        //     }
        //     if($count_caseusersclientbottom > 1){
        //         $short_caption.=', et al.';
        //     }
        // }

        // $court_case_data->short_caption=$short_caption;  
        // $court_case_data->save();
        // end short caption

        // ----------fololowing code is to update case party info table-------------//
        if ($party_group == 'top' || $party_group == 'bottom') {
            $casetopparties = Caseuser::where([['case_id', $case_id], ['party_group', 'top']])->get()->all();
            $casebottomparties = Caseuser::where([['case_id', $case_id], ['party_group', 'bottom']])->get()->all();
            $client_case_array2 = array(
                'case_id' => $case_id,
            );
            $i = 0;
            $num = 0;
            foreach ($casetopparties as $casetopparty) {
                $name = User::where('id', $casetopparty['user_id'])->get()->pluck('name')->first();
                $fullname = $name;
                if (isset($casetopparty['party_entity']) && $casetopparty['party_entity'] == 'organization_company') {
                    $fullname = $casetopparty['org_comp_name'];
                } else {
                    $mname = $casetopparty['mname'];
                    if (isset($mname) && $mname != '') {
                        $namearray = explode(' ', $name, 2);
                        if (count($namearray) > 1) {
                            $fullname = $namearray[0] . ' ' . $mname . ' ' . $namearray[1];
                        } else {
                            $fullname = $name . ' ' . $mname;
                        }
                    } else {
                        $fullname = $name;
                    }
                }

                $casetopparties[$i]['name'] = $fullname;

                $casetopparties[$i]['state_name'] = DB::table('states')->where('id', $casetopparty['state_id'])->get()->pluck('state')->first();
                $casetopparties[$i]['county_name'] = DB::table('counties')->where('id', $casetopparty['state_id'])->get()->pluck('county_name')->first();
                $num++;
                $client_case_array2['topparty' . $num . '_user_id'] = $casetopparty['user_id'];
                $client_case_array2['topparty' . $num . '_name'] = $casetopparties[$i]['name'];
                $client_case_array2['topparty' . $num . '_party_group'] = $casetopparty['party_group'];
                $client_case_array2['topparty' . $num . '_org_comp_name'] = $casetopparty['org_comp_name'];
                $client_case_array2['topparty' . $num . '_type'] = $casetopparty['type'];
                $client_case_array2['topparty' . $num . '_care_of'] = $casetopparty['care_of'];
                $client_case_array2['topparty' . $num . '_prefix'] = $casetopparty['prefix'];
                $client_case_array2['topparty' . $num . '_fname'] = $casetopparty['fname'];
                $client_case_array2['topparty' . $num . '_mname'] = $casetopparty['mname'];
                $client_case_array2['topparty' . $num . '_lname'] = $casetopparty['lname'];
                $client_case_array2['topparty' . $num . '_phone'] = $casetopparty['telephone'];
                $client_case_array2['topparty' . $num . '_suffix'] = $casetopparty['suffix'];
                $client_case_array2['topparty' . $num . '_prefname'] = $casetopparty['prefname'];
                $client_case_array2['topparty' . $num . '_short_name'] = $casetopparty['short_name'];
                $client_case_array2['topparty' . $num . '_gender'] = $casetopparty['gender'];
                $client_case_array2['topparty' . $num . '_social_sec_number'] = $casetopparty['social_sec_number'];
                $client_case_array2['topparty' . $num . '_employer_identification'] = $casetopparty['employer_identification'];
                $client_case_array2['topparty' . $num . '_date_of_birth'] = $casetopparty['date_of_birth'];
                $client_case_array2['topparty' . $num . '_zipcode'] = $casetopparty['user_zipcode'];
                $client_case_array2['topparty' . $num . '_street_address'] = $casetopparty['street_address'];
                $client_case_array2['topparty' . $num . '_city_name'] = $casetopparty['user_city'];
                $client_case_array2['topparty' . $num . '_state_name'] = $casetopparties[$i]['state_name'];
                $client_case_array2['topparty' . $num . '_county_name'] = $casetopparties[$i]['county_name'];
                $client_case_array2['topparty' . $num . '_fax'] = $casetopparty['fax'];
                $client_case_array2['topparty' . $num . '_primary_language'] = $casetopparty['primary_language'];
                $client_case_array2['topparty' . $num . '_req_lang_trans'] = $casetopparty['req_lang_trans'];
                $client_case_array2['topparty' . $num . '_hearing_impaired'] = $casetopparty['hearing_impaired'];
                $client_case_array2['topparty' . $num . '_req_sign_lang'] = $casetopparty['req_sign_lang'];

                $i++;
            }
            $limit = $num + 1;
            for ($j = $limit; $j <= 6; $j++) {
                $client_case_array2['topparty' . $j . '_user_id'] = NULL;
                $client_case_array2['topparty' . $j . '_name'] = NULL;
                $client_case_array2['topparty' . $j . '_party_group'] = NULL;
                $client_case_array2['topparty' . $j . '_org_comp_name'] = NULL;
                $client_case_array2['topparty' . $j . '_type'] = NULL;
                $client_case_array2['topparty' . $j . '_care_of'] = NULL;
                $client_case_array2['topparty' . $j . '_prefix'] = NULL;
                $client_case_array2['topparty' . $j . '_fname'] = NULL;
                $client_case_array2['topparty' . $j . '_mname'] = NULL;
                $client_case_array2['topparty' . $j . '_lname'] = NULL;
                $client_case_array2['topparty' . $j . '_phone'] = NULL;
                $client_case_array2['topparty' . $j . '_suffix'] = NULL;
                $client_case_array2['topparty' . $j . '_prefname'] = NULL;
                $client_case_array2['topparty' . $j . '_short_name'] = NULL;
                $client_case_array2['topparty' . $j . '_gender'] = NULL;
                $client_case_array2['topparty' . $j . '_social_sec_number'] = NULL;
                $client_case_array2['topparty' . $j . '_employer_identification'] = NULL;
                $client_case_array2['topparty' . $j . '_date_of_birth'] = NULL;
                $client_case_array2['topparty' . $j . '_zipcode'] = NULL;
                $client_case_array2['topparty' . $j . '_street_address'] = NULL;
                $client_case_array2['topparty' . $j . '_city_name'] = NULL;
                $client_case_array2['topparty' . $j . '_state_name'] = NULL;
                $client_case_array2['topparty' . $j . '_county_name'] = NULL;
                $client_case_array2['topparty' . $j . '_fax'] = NULL;
                $client_case_array2['topparty' . $j . '_primary_language'] = NULL;
                $client_case_array2['topparty' . $j . '_req_lang_trans'] = NULL;
                $client_case_array2['topparty' . $j . '_hearing_impaired'] = NULL;
                $client_case_array2['topparty' . $j . '_req_sign_lang'] = NULL;
                $client_case_array2['bottomparty' . $j . '_num_attys'] = '0';
            }
            $i = 0;
            $num = 0;
            foreach ($casebottomparties as $casebottomparty) {
                $name = User::where('id', $casebottomparty['user_id'])->get()->pluck('name')->first();
                $fullname = $name;
                if (isset($casebottomparty['party_entity']) && $casebottomparty['party_entity'] == 'organization_company') {
                    $fullname = $casebottomparty['org_comp_name'];
                } else {
                    $mname = $casebottomparty['mname'];
                    if (isset($mname) && $mname != '') {
                        $namearray = explode(' ', $name, 2);
                        if (count($namearray) > 1) {
                            $fullname = $namearray[0] . ' ' . $mname . ' ' . $namearray[1];
                        } else {
                            $fullname = $name . ' ' . $mname;
                        }
                    } else {
                        $fullname = $name;
                    }
                }

                $casebottomparties[$i]['name'] = $fullname;

                $casebottomparties[$i]['state_name'] = DB::table('states')->where('id', $casebottomparty['state_id'])->get()->pluck('state')->first();
                $casebottomparties[$i]['county_name'] = DB::table('counties')->where('id', $casebottomparty['state_id'])->get()->pluck('county_name')->first();
                $num++;
                $client_case_array2['bottomparty' . $num . '_user_id'] = $casebottomparty['user_id'];
                $client_case_array2['bottomparty' . $num . '_name'] = $casebottomparties[$i]['name'];
                $client_case_array2['bottomparty' . $num . '_party_group'] = $casebottomparty['party_group'];
                $client_case_array2['bottomparty' . $num . '_org_comp_name'] = $casebottomparty['org_comp_name'];
                $client_case_array2['bottomparty' . $num . '_type'] = $casebottomparty['type'];
                $client_case_array2['bottomparty' . $num . '_care_of'] = $casebottomparty['care_of'];
                $client_case_array2['bottomparty' . $num . '_prefix'] = $casebottomparty['prefix'];
                $client_case_array2['bottomparty' . $num . '_fname'] = $casebottomparty['fname'];
                $client_case_array2['bottomparty' . $num . '_mname'] = $casebottomparty['mname'];
                $client_case_array2['bottomparty' . $num . '_lname'] = $casebottomparty['lname'];
                $client_case_array2['bottomparty' . $num . '_phone'] = $casebottomparty['telephone'];
                $client_case_array2['bottomparty' . $num . '_suffix'] = $casebottomparty['suffix'];
                $client_case_array2['bottomparty' . $num . '_prefname'] = $casebottomparty['prefname'];
                $client_case_array2['bottomparty' . $num . '_short_name'] = $casebottomparty['short_name'];
                $client_case_array2['bottomparty' . $num . '_gender'] = $casebottomparty['gender'];
                $client_case_array2['bottomparty' . $num . '_social_sec_number'] = $casebottomparty['social_sec_number'];
                $client_case_array2['bottomparty' . $num . '_employer_identification'] = $casebottomparty['employer_identification'];
                $client_case_array2['bottomparty' . $num . '_date_of_birth'] = $casebottomparty['date_of_birth'];
                $client_case_array2['bottomparty' . $num . '_zipcode'] = $casebottomparty['user_zipcode'];
                $client_case_array2['bottomparty' . $num . '_street_address'] = $casebottomparty['street_address'];
                $client_case_array2['bottomparty' . $num . '_city_name'] = $casebottomparty['user_city'];
                $client_case_array2['bottomparty' . $num . '_state_name'] = $casebottomparties[$i]['state_name'];
                $client_case_array2['bottomparty' . $num . '_county_name'] = $casebottomparties[$i]['county_name'];
                $client_case_array2['bottomparty' . $num . '_fax'] = $casebottomparty['fax'];
                $client_case_array2['bottomparty' . $num . '_primary_language'] = $casebottomparty['primary_language'];
                $client_case_array2['bottomparty' . $num . '_req_lang_trans'] = $casebottomparty['req_lang_trans'];
                $client_case_array2['bottomparty' . $num . '_hearing_impaired'] = $casebottomparty['hearing_impaired'];
                $client_case_array2['bottomparty' . $num . '_req_sign_lang'] = $casebottomparty['req_sign_lang'];

                $i++;
            }
            $limit = $num + 1;
            for ($j = $limit; $j <= 6; $j++) {
                $client_case_array2['bottomparty' . $j . '_user_id'] = NULL;
                $client_case_array2['bottomparty' . $j . '_name'] = NULL;
                $client_case_array2['bottomparty' . $j . '_party_group'] = NULL;
                $client_case_array2['bottomparty' . $j . '_org_comp_name'] = NULL;
                $client_case_array2['bottomparty' . $j . '_type'] = NULL;
                $client_case_array2['bottomparty' . $j . '_care_of'] = NULL;
                $client_case_array2['bottomparty' . $j . '_prefix'] = NULL;
                $client_case_array2['bottomparty' . $j . '_fname'] = NULL;
                $client_case_array2['bottomparty' . $j . '_mname'] = NULL;
                $client_case_array2['bottomparty' . $j . '_lname'] = NULL;
                $client_case_array2['bottomparty' . $j . '_phone'] = NULL;
                $client_case_array2['bottomparty' . $j . '_suffix'] = NULL;
                $client_case_array2['bottomparty' . $j . '_prefname'] = NULL;
                $client_case_array2['bottomparty' . $j . '_short_name'] = NULL;
                $client_case_array2['bottomparty' . $j . '_gender'] = NULL;
                $client_case_array2['bottomparty' . $j . '_social_sec_number'] = NULL;
                $client_case_array2['bottomparty' . $j . '_employer_identification'] = NULL;
                $client_case_array2['bottomparty' . $j . '_date_of_birth'] = NULL;
                $client_case_array2['bottomparty' . $j . '_zipcode'] = NULL;
                $client_case_array2['bottomparty' . $j . '_street_address'] = NULL;
                $client_case_array2['bottomparty' . $j . '_city_name'] = NULL;
                $client_case_array2['bottomparty' . $j . '_state_name'] = NULL;
                $client_case_array2['bottomparty' . $j . '_county_name'] = NULL;
                $client_case_array2['bottomparty' . $j . '_fax'] = NULL;
                $client_case_array2['bottomparty' . $j . '_primary_language'] = NULL;
                $client_case_array2['bottomparty' . $j . '_req_lang_trans'] = NULL;
                $client_case_array2['bottomparty' . $j . '_hearing_impaired'] = NULL;
                $client_case_array2['bottomparty' . $j . '_req_sign_lang'] = NULL;
                $client_case_array2['bottomparty' . $j . '_num_attys'] = '0';
            }

            $partytypeinfoprev = CasePartyInfo::where('case_id', $case_id)->get()->first();
            if ($partytypeinfoprev) {
                $partytypeinfo = $partytypeinfoprev->fill($client_case_array2)->save();
            } else {
                // $partytypeinfo=CasePartyInfo::create($client_case_array2);
            }
        }

        // for third parties
        if ($party_group == 'top_third' || $party_group == 'bottom_third') {
            $casetop_thirdparties = Caseuser::where([['case_id', $case_id], ['party_group', 'top_third']])->get()->all();
            $casebottom_thirdparties = Caseuser::where([['case_id', $case_id], ['party_group', 'bottom_third']])->get()->all();
            $client_case_array2 = array(
                'case_id' => $case_id,
            );
            $i = 0;
            $num = 0;
            foreach ($casetop_thirdparties as $casetop_thirdparty) {
                $name = User::where('id', $casetop_thirdparty['user_id'])->get()->pluck('name')->first();
                $fullname = $name;
                if (isset($casetop_thirdparty['party_entity']) && $casetop_thirdparty['party_entity'] == 'organization_company') {
                    $fullname = $casetop_thirdparty['org_comp_name'];
                } else {
                    $mname = $casetop_thirdparty['mname'];
                    if (isset($mname) && $mname != '') {
                        $namearray = explode(' ', $name, 2);
                        if (count($namearray) > 1) {
                            $fullname = $namearray[0] . ' ' . $mname . ' ' . $namearray[1];
                        } else {
                            $fullname = $name . ' ' . $mname;
                        }
                    } else {
                        $fullname = $name;
                    }
                }

                $casetop_thirdparties[$i]['name'] = $fullname;

                $casetop_thirdparties[$i]['state_name'] = DB::table('states')->where('id', $casetop_thirdparty['state_id'])->get()->pluck('state')->first();
                $casetop_thirdparties[$i]['county_name'] = DB::table('counties')->where('id', $casetop_thirdparty['state_id'])->get()->pluck('county_name')->first();
                $num++;
                $client_case_array2['top_thirdparty' . $num . '_user_id'] = $casetop_thirdparty['user_id'];
                $client_case_array2['top_thirdparty' . $num . '_name'] = $casetop_thirdparties[$i]['name'];
                $client_case_array2['top_thirdparty' . $num . '_party_group'] = $casetop_thirdparty['party_group'];
                $client_case_array2['top_thirdparty' . $num . '_org_comp_name'] = $casetop_thirdparty['org_comp_name'];
                $client_case_array2['top_thirdparty' . $num . '_type'] = $casetop_thirdparty['type'];
                $client_case_array2['top_thirdparty' . $num . '_care_of'] = $casetop_thirdparty['care_of'];
                $client_case_array2['top_thirdparty' . $num . '_prefix'] = $casetop_thirdparty['prefix'];
                $client_case_array2['top_thirdparty' . $num . '_fname'] = $casetop_thirdparty['fname'];
                $client_case_array2['top_thirdparty' . $num . '_mname'] = $casetop_thirdparty['mname'];
                $client_case_array2['top_thirdparty' . $num . '_lname'] = $casetop_thirdparty['lname'];
                $client_case_array2['top_thirdparty' . $num . '_phone'] = $casetop_thirdparty['telephone'];
                $client_case_array2['top_thirdparty' . $num . '_suffix'] = $casetop_thirdparty['suffix'];
                $client_case_array2['top_thirdparty' . $num . '_prefname'] = $casetop_thirdparty['prefname'];
                $client_case_array2['top_thirdparty' . $num . '_short_name'] = $casetop_thirdparty['short_name'];
                $client_case_array2['top_thirdparty' . $num . '_gender'] = $casetop_thirdparty['gender'];
                $client_case_array2['top_thirdparty' . $num . '_social_sec_number'] = $casetop_thirdparty['social_sec_number'];
                $client_case_array2['top_thirdparty' . $num . '_employer_identification'] = $casetop_thirdparty['employer_identification'];
                $client_case_array2['top_thirdparty' . $num . '_date_of_birth'] = $casetop_thirdparty['date_of_birth'];
                $client_case_array2['top_thirdparty' . $num . '_zipcode'] = $casetop_thirdparty['user_zipcode'];
                $client_case_array2['top_thirdparty' . $num . '_street_address'] = $casetop_thirdparty['street_address'];
                $client_case_array2['top_thirdparty' . $num . '_city_name'] = $casetop_thirdparty['user_city'];
                $client_case_array2['top_thirdparty' . $num . '_state_name'] = $casetop_thirdparties[$i]['state_name'];
                $client_case_array2['top_thirdparty' . $num . '_county_name'] = $casetop_thirdparties[$i]['county_name'];
                $client_case_array2['top_thirdparty' . $num . '_fax'] = $casetop_thirdparty['fax'];
                $client_case_array2['top_thirdparty' . $num . '_primary_language'] = $casetop_thirdparty['primary_language'];
                $client_case_array2['top_thirdparty' . $num . '_req_lang_trans'] = $casetop_thirdparty['req_lang_trans'];
                $client_case_array2['top_thirdparty' . $num . '_hearing_impaired'] = $casetop_thirdparty['hearing_impaired'];
                $client_case_array2['top_thirdparty' . $num . '_req_sign_lang'] = $casetop_thirdparty['req_sign_lang'];

                $i++;
            }
            $limit = $num + 1;
            for ($j = $limit; $j <= 3; $j++) {
                $client_case_array2['top_thirdparty' . $j . '_user_id'] = NULL;
                $client_case_array2['top_thirdparty' . $j . '_name'] = NULL;
                $client_case_array2['top_thirdparty' . $j . '_party_group'] = NULL;
                $client_case_array2['top_thirdparty' . $j . '_org_comp_name'] = NULL;
                $client_case_array2['top_thirdparty' . $j . '_type'] = NULL;
                $client_case_array2['top_thirdparty' . $j . '_care_of'] = NULL;
                $client_case_array2['top_thirdparty' . $j . '_prefix'] = NULL;
                $client_case_array2['top_thirdparty' . $j . '_fname'] = NULL;
                $client_case_array2['top_thirdparty' . $j . '_mname'] = NULL;
                $client_case_array2['top_thirdparty' . $j . '_lname'] = NULL;
                $client_case_array2['top_thirdparty' . $j . '_phone'] = NULL;
                $client_case_array2['top_thirdparty' . $j . '_suffix'] = NULL;
                $client_case_array2['top_thirdparty' . $j . '_prefname'] = NULL;
                $client_case_array2['top_thirdparty' . $j . '_short_name'] = NULL;
                $client_case_array2['top_thirdparty' . $j . '_gender'] = NULL;
                $client_case_array2['top_thirdparty' . $j . '_social_sec_number'] = NULL;
                $client_case_array2['top_thirdparty' . $j . '_employer_identification'] = NULL;
                $client_case_array2['top_thirdparty' . $j . '_date_of_birth'] = NULL;
                $client_case_array2['top_thirdparty' . $j . '_zipcode'] = NULL;
                $client_case_array2['top_thirdparty' . $j . '_street_address'] = NULL;
                $client_case_array2['top_thirdparty' . $j . '_city_name'] = NULL;
                $client_case_array2['top_thirdparty' . $j . '_state_name'] = NULL;
                $client_case_array2['top_thirdparty' . $j . '_county_name'] = NULL;
                $client_case_array2['top_thirdparty' . $j . '_fax'] = NULL;
                $client_case_array2['top_thirdparty' . $j . '_primary_language'] = NULL;
                $client_case_array2['top_thirdparty' . $j . '_req_lang_trans'] = NULL;
                $client_case_array2['top_thirdparty' . $j . '_hearing_impaired'] = NULL;
                $client_case_array2['top_thirdparty' . $j . '_req_sign_lang'] = NULL;
                $client_case_array2['top_thirdparty' . $j . '_num_attys'] = '0';
            }
            $i = 0;
            $num = 0;
            foreach ($casebottom_thirdparties as $casebottom_thirdparty) {
                $name = User::where('id', $casebottom_thirdparty['user_id'])->get()->pluck('name')->first();
                $fullname = $name;
                if (isset($casebottom_thirdparty['party_entity']) && $casebottom_thirdparty['party_entity'] == 'organization_company') {
                    $fullname = $casebottom_thirdparty['org_comp_name'];
                } else {
                    $mname = $casebottom_thirdparty['mname'];
                    if (isset($mname) && $mname != '') {
                        $namearray = explode(' ', $name, 2);
                        if (count($namearray) > 1) {
                            $fullname = $namearray[0] . ' ' . $mname . ' ' . $namearray[1];
                        } else {
                            $fullname = $name . ' ' . $mname;
                        }
                    } else {
                        $fullname = $name;
                    }
                }

                $casebottom_thirdparties[$i]['name'] = $fullname;

                $casebottom_thirdparties[$i]['state_name'] = DB::table('states')->where('id', $casebottom_thirdparty['state_id'])->get()->pluck('state')->first();
                $casebottom_thirdparties[$i]['county_name'] = DB::table('counties')->where('id', $casebottom_thirdparty['state_id'])->get()->pluck('county_name')->first();
                $num++;
                $client_case_array2['bottom_thirdparty' . $num . '_user_id'] = $casebottom_thirdparty['user_id'];
                $client_case_array2['bottom_thirdparty' . $num . '_name'] = $casebottom_thirdparties[$i]['name'];
                $client_case_array2['bottom_thirdparty' . $num . '_party_group'] = $casebottom_thirdparty['party_group'];
                $client_case_array2['bottom_thirdparty' . $num . '_org_comp_name'] = $casebottom_thirdparty['org_comp_name'];
                $client_case_array2['bottom_thirdparty' . $num . '_type'] = $casebottom_thirdparty['type'];
                $client_case_array2['bottom_thirdparty' . $num . '_care_of'] = $casebottom_thirdparty['care_of'];
                $client_case_array2['bottom_thirdparty' . $num . '_prefix'] = $casebottom_thirdparty['prefix'];
                $client_case_array2['bottom_thirdparty' . $num . '_fname'] = $casebottom_thirdparty['fname'];
                $client_case_array2['bottom_thirdparty' . $num . '_mname'] = $casebottom_thirdparty['mname'];
                $client_case_array2['bottom_thirdparty' . $num . '_lname'] = $casebottom_thirdparty['lname'];
                $client_case_array2['bottom_thirdparty' . $num . '_phone'] = $casebottom_thirdparty['telephone'];
                $client_case_array2['bottom_thirdparty' . $num . '_suffix'] = $casebottom_thirdparty['suffix'];
                $client_case_array2['bottom_thirdparty' . $num . '_prefname'] = $casebottom_thirdparty['prefname'];
                $client_case_array2['bottom_thirdparty' . $num . '_short_name'] = $casebottom_thirdparty['short_name'];
                $client_case_array2['bottom_thirdparty' . $num . '_gender'] = $casebottom_thirdparty['gender'];
                $client_case_array2['bottom_thirdparty' . $num . '_social_sec_number'] = $casebottom_thirdparty['social_sec_number'];
                $client_case_array2['bottom_thirdparty' . $num . '_employer_identification'] = $casebottom_thirdparty['employer_identification'];
                $client_case_array2['bottom_thirdparty' . $num . '_date_of_birth'] = $casebottom_thirdparty['date_of_birth'];
                $client_case_array2['bottom_thirdparty' . $num . '_zipcode'] = $casebottom_thirdparty['user_zipcode'];
                $client_case_array2['bottom_thirdparty' . $num . '_street_address'] = $casebottom_thirdparty['street_address'];
                $client_case_array2['bottom_thirdparty' . $num . '_city_name'] = $casebottom_thirdparty['user_city'];
                $client_case_array2['bottom_thirdparty' . $num . '_state_name'] = $casebottom_thirdparties[$i]['state_name'];
                $client_case_array2['bottom_thirdparty' . $num . '_county_name'] = $casebottom_thirdparties[$i]['county_name'];
                $client_case_array2['bottom_thirdparty' . $num . '_fax'] = $casebottom_thirdparty['fax'];
                $client_case_array2['bottom_thirdparty' . $num . '_primary_language'] = $casebottom_thirdparty['primary_language'];
                $client_case_array2['bottom_thirdparty' . $num . '_req_lang_trans'] = $casebottom_thirdparty['req_lang_trans'];
                $client_case_array2['bottom_thirdparty' . $num . '_hearing_impaired'] = $casebottom_thirdparty['hearing_impaired'];
                $client_case_array2['bottom_thirdparty' . $num . '_req_sign_lang'] = $casebottom_thirdparty['req_sign_lang'];

                $i++;
            }
            $limit = $num + 1;
            for ($j = $limit; $j <= 3; $j++) {
                $client_case_array2['bottom_thirdparty' . $j . '_user_id'] = NULL;
                $client_case_array2['bottom_thirdparty' . $j . '_name'] = NULL;
                $client_case_array2['bottom_thirdparty' . $j . '_party_group'] = NULL;
                $client_case_array2['bottom_thirdparty' . $j . '_org_comp_name'] = NULL;
                $client_case_array2['bottom_thirdparty' . $j . '_type'] = NULL;
                $client_case_array2['bottom_thirdparty' . $j . '_care_of'] = NULL;
                $client_case_array2['bottom_thirdparty' . $j . '_prefix'] = NULL;
                $client_case_array2['bottom_thirdparty' . $j . '_fname'] = NULL;
                $client_case_array2['bottom_thirdparty' . $j . '_mname'] = NULL;
                $client_case_array2['bottom_thirdparty' . $j . '_lname'] = NULL;
                $client_case_array2['bottom_thirdparty' . $j . '_phone'] = NULL;
                $client_case_array2['bottom_thirdparty' . $j . '_suffix'] = NULL;
                $client_case_array2['bottom_thirdparty' . $j . '_prefname'] = NULL;
                $client_case_array2['bottom_thirdparty' . $j . '_short_name'] = NULL;
                $client_case_array2['bottom_thirdparty' . $j . '_gender'] = NULL;
                $client_case_array2['bottom_thirdparty' . $j . '_social_sec_number'] = NULL;
                $client_case_array2['bottom_thirdparty' . $j . '_employer_identification'] = NULL;
                $client_case_array2['bottom_thirdparty' . $j . '_date_of_birth'] = NULL;
                $client_case_array2['bottom_thirdparty' . $j . '_zipcode'] = NULL;
                $client_case_array2['bottom_thirdparty' . $j . '_street_address'] = NULL;
                $client_case_array2['bottom_thirdparty' . $j . '_city_name'] = NULL;
                $client_case_array2['bottom_thirdparty' . $j . '_state_name'] = NULL;
                $client_case_array2['bottom_thirdparty' . $j . '_county_name'] = NULL;
                $client_case_array2['bottom_thirdparty' . $j . '_fax'] = NULL;
                $client_case_array2['bottom_thirdparty' . $j . '_primary_language'] = NULL;
                $client_case_array2['bottom_thirdparty' . $j . '_req_lang_trans'] = NULL;
                $client_case_array2['bottom_thirdparty' . $j . '_hearing_impaired'] = NULL;
                $client_case_array2['bottom_thirdparty' . $j . '_req_sign_lang'] = NULL;
                $client_case_array2['bottom_thirdparty' . $j . '_num_attys'] = '0';
            }

            // dd($client_case_array2);
            $partytypeinfoprev = CasePartyInfo::where('case_id', $case_id)->get()->first();
            if ($partytypeinfoprev) {
                $partytypeinfo = $partytypeinfoprev->fill($client_case_array2)->save();
            } else {
                //$partytypeinfo=CasePartyInfo::create($client_case_array2);
            }
        }
        // for third parties
        // ----------end of code to update case party info table-------------//
        return redirect()->route('cases.show_party_reg_form', ['case_id' => $case_id])->with('success', 'Case party deleted successfully.');
    }

    // to show register attornies form for parties 
    public function show_attorney_reg_form($party_id, $case_id, $party_number)
    {
        $case_data = Courtcase::find($case_id);
        if (isset($case_data) && $case_data->attorney_id != Auth::user()->id) {
            return redirect()->route('home');
        }
        $user_party_group = '';

        $user = User::find($party_id);
        $case_party_user = Caseuser::where([['user_id', $party_id], ['case_id', $case_id], ['attorney_id', Auth::user()->id]])->get()->first();
        if (!$case_party_user) {
            return redirect()->route('home');
        }
        $case_party_user->name = $user->name;
        if ($case_party_user->party_group == 'top') {
            if (isset($case_data->top_party_type)) {
                $user_party_group = $case_data->top_party_type;
            } else {
                $user_party_group = $case_data->original_top_party_type;
            }
        }
        if ($case_party_user->party_group == 'bottom') {
            if (isset($case_data->top_party_type)) {
                $user_party_group = $case_data->bottom_party_type;
            } else {
                $user_party_group = $case_data->original_bottom_party_type;
            }
        }

        if ($case_party_user->party_group == 'top_third') {
            if (isset($case_data->top_party_type)) {
                $user_party_group = 'Third-Party ' . $case_data->top_party_type;
            } else {
                $user_party_group = 'Third-Party ' . $case_data->original_top_party_type;
            }
        }
        if ($case_party_user->party_group == 'bottom_third') {
            if (isset($case_data->top_party_type)) {
                $user_party_group = 'Third-Party ' . $case_data->bottom_party_type;
            } else {
                $user_party_group = 'Third-Party ' . $case_data->original_bottom_party_type;
            }
        }


        $case_party_user->user_party_group = $user_party_group;
        $case_party_user->party_number = $party_number;

        $trial_attorneys = Partyattorney::where([['party_id', $party_id], ['case_id', $case_id], ['trial_attorney', 'Yes']])->get()->all();
        $total_trial_attorneys = count($trial_attorneys);

        $customer_attorney = Partyattorney::where([['party_id', $party_id], ['case_id', $case_id], ['customer_attorney', 'Yes']])->get()->all();
        $total_customer_attorney = count($customer_attorney);

        $attorney_ids = Partyattorney::where([['party_id', $party_id], ['case_id', $case_id]])->get()->all();

        if ($attorney_ids) {

            $attorney = array();
            $i = 0;
            $case_party_user['total_attornies'] = count($attorney_ids);
            foreach ($attorney_ids as $user_id) {
                $attorney[] = User::where('id', $user_id->attorney_id)->get()->first();
                $party_attorney = DB::table('attorneys')
                    ->join('states', 'attorneys.state_id', '=', 'states.id')
                    ->join('counties', [['attorneys.county_id', '=', 'counties.id'], ['attorneys.state_id', '=', 'counties.state_id']])
                    ->where('user_id', $user_id->attorney_id)
                    ->select('attorneys.firm_name', 'attorneys.firm_city', 'attorneys.state_id', 'states.state', 'counties.id', 'counties.county_name')
                    ->get();

                $attorney[$i]['firm_name'] = $party_attorney[0]->firm_name;
                $attorney[$i]['firm_city'] = $party_attorney[0]->firm_city;
                $attorney[$i]['state'] = $party_attorney[0]->state;
                $attorney[$i]['county'] = $party_attorney[0]->county_name;
                $attorney[$i]['trial_attorney'] = $user_id->trial_attorney;

                ++$i;
            }
        } else {
            return view('case.register_attorney', ['case_id' => $case_id, 'case_party_user' => $case_party_user, 'total_trial_attorneys' => $total_trial_attorneys, 'total_customer_attorney' => $total_customer_attorney]);
        }

        return view('case.register_attorney', ['case_id' => $case_id, 'case_party_user' => $case_party_user, 'party_attorney' => $attorney, 'total_trial_attorneys' => $total_trial_attorneys, 'total_customer_attorney' => $total_customer_attorney]);
    }

    // to register attornies for parties 
    public function store_attorney(Request $request)
    {

        $court_case_data = Courtcase::find($request->case_id);
        if (isset($court_case_data) && $court_case_data->attorney_id != Auth::user()->id) {
            return redirect()->route('home');
        }
        $case_id = $request->case_id;
        $party_id = $request->party_id;
        $email = $request->email;

        // Partyattorney::where([['case_id', $case_id],['party_id', $party_id],['attorney_id', $attorney_id]])->delete();
        $attorney_ids = Partyattorney::where([['party_id', $party_id], ['case_id', $case_id]])->get()->all();
        $totalattornies = count($attorney_ids);
        foreach ($attorney_ids as $user_id) {
            $attorneyemail = User::where('id', $user_id->attorney_id)->get()->pluck('email')->first();
            if ($attorneyemail == $email) {
                return redirect()->route('cases.show_attorney_reg_form', ['party_id' => $party_id, 'case_id' => $case_id, 'party_number' => $request->party_number])->with('error', 'Attorney Already Added.');
            }
        }

        $fname = $request->fname;
        $mname = $request->mname;
        $lname = $request->lname;
        $document_sign_name = $request->document_sign_name;
        if (!isset($request->email) || $request->email == '') {
            $username = 'unknown_' . $request->case_id . '_' . Carbon::now()->timestamp . '@firstdraftdata.com';
            $email = 'unknown_' . $request->case_id . '_' . Carbon::now()->timestamp . '@firstdraftdata.com';
        } else {
            $username = $request->email;
            $email = $request->email;
        }
        // $username=$request->email;
        $password = Hash::make(str_random(8));
        $special_practice = $request->special_practice;
        $firm_name = $request->firm_name;
        $firm_street_address = $request->firm_street_address;
        $firm_suite_unit_mailcode = $request->firm_suite_unit_mailcode;
        $po_box = $request->po_box;
        $firm_city = $request->firm_city;
        $firm_state = $request->firm_state;
        $firm_county = $request->firm_county;
        $firm_zipcode = $request->firm_zipcode;
        $firm_telephone = $request->firm_telephone;
        $firm_fax = $request->firm_fax;
        $attorney_reg_1_state_id = $request->attorney_reg_1_state_id;

        $attorney_reg_1_num = $request->attorney_reg_1_num;


        if (isset($request->pro_hac_vice) && $request->pro_hac_vice == 'yes' && isset($request->pro_vice_hac_num) && $request->pro_vice_hac_num != '') {
            $pro_vice_hac_num = $request->pro_vice_hac_num;
        } else {
            $pro_vice_hac_num = NULL;
        }

        if ($special_practice == 'court') {
            $special_practice_text = $request->court_text;
        } else if ($special_practice == 'law_school') {

            $special_practice_text = $request->law_school_text;
        } else if ($special_practice == 'legal_aid') {

            $special_practice_text = $request->legal_aid_text;
        } else {

            $special_practice_text = 'Nill';
        }
        if (isset($request->trial_attorney) && !empty($request->trial_attorney)) {
            $trial_attorney = $request->trial_attorney;
        } else {
            $trial_attorney = 'No';
        }
        if (isset($request->customer_attorney) && !empty($request->customer_attorney)) {
            $customer_attorney = $request->customer_attorney;
        } else {
            $customer_attorney = 'No';
        }
        $user_attorney = User::where('email', $email)->first();
        if ($user_attorney) {
            // $user_attorney->name=$fname.' '.$lname;
            // $user_attorney->active='1';
            // $user_attorney->save();
            $reg_attorney = Attorney::where('user_id', $user_attorney->id)->first();
            if ($reg_attorney) {
            } else {

                $attorney_state = State::where('id', $firm_state)->get()->first();
                $attorney_reg_state = State::where('id', $attorney_reg_1_state_id)->get()->first();
                $attorney_county = County::where('id', $firm_county)->get()->first();

                $array2 = array(
                    'user_id' => $user_attorney->id,
                    'mname' => $mname,
                    'document_sign_name' => $document_sign_name,
                    'special_practice' => $special_practice,
                    'special_practice_text' => $special_practice_text,
                    'firm_name' => $firm_name,
                    'firm_street_address' => $firm_street_address,
                    'firm_suite_unit_mailcode' => $firm_suite_unit_mailcode,
                    'po_box' => $po_box,
                    'firm_city' => $firm_city,
                    'state_id' => $firm_state,
                    'county_id' => $firm_county,
                    'firm_zipcode' => $firm_zipcode,
                    'firm_telephone' => $firm_telephone,
                    'firm_fax' => $firm_fax,
                    'attorney_reg_1_state_id' => $attorney_reg_1_state_id,

                    'attorney_reg_1_num' => $attorney_reg_1_num,

                    'pro_vice_hac_num' => $pro_vice_hac_num,
                    'created_at' => now(),
                    'updated_at' => now(),

                    'fname' => $request->fname,
                    'lname' => $request->lname,
                    'sufname' => $request->sufname,
                    'currentstatus' => $request->currentstatus,
                    'gender' => $request->gender,
                    'attorneytitle' => $request->attorneytitle,
                    'insured' => $request->insured,
                    'admissiondate' => date("Y-m-d", strtotime($request->admissiondate)),
                    'admissiondatevalue' => date("Ymd", strtotime($request->admissiondate)),
                    'howadmitted' => $request->howadmitted,
                    'birthdate' => date("Y-m-d", strtotime($request->birthdate)),
                    'birthdatevalue' => date("Ymd", strtotime($request->birthdate)),
                    'firm_tagline' => $request->firm_tagline,
                    'firm_state' => $attorney_state->state,
                    'firm_state_abr' => $attorney_state->state_abbreviation,
                    'email' => $request->email,
                    'firm_county' => $attorney_county->county_name,
                    'registration_state_1' => $attorney_reg_state->state,

                );
                // echo "<pre>"; print_r($array2);
                $attorney = Attorney::create($array2);
            }
        } else {
            $array = array(
                'name' => $fname . ' ' . $lname,
                'email' => $email,
                'username' => $email,
                'password' => $password,
                'created_at' => now(),
                'updated_at' => now(),
            );
            Session::put('entered_password', $password);
            Session::put('is_client', false);
            $user_attorney = User::create($array);
            $user_attorney->assignRole('attorney');

            $attorney_state = State::where('id', $firm_state)->get()->first();
            $attorney_reg_state = State::where('id', $attorney_reg_1_state_id)->get()->first();
            $attorney_county = County::where('id', $firm_county)->get()->first();

            // echo "<pre>"; print_r($array);
            $array2 = array(
                'user_id' => $user_attorney->id,
                'mname' => $mname,
                'document_sign_name' => $document_sign_name,
                'special_practice' => $special_practice,
                'special_practice_text' => $special_practice_text,
                'firm_name' => $firm_name,
                'firm_street_address' => $firm_street_address,
                'firm_suite_unit_mailcode' => $firm_suite_unit_mailcode,
                'po_box' => $po_box,
                'firm_city' => $firm_city,
                'state_id' => $firm_state,
                'county_id' => $firm_county,
                'firm_zipcode' => $firm_zipcode,
                'firm_telephone' => $firm_telephone,
                'firm_fax' => $firm_fax,
                'attorney_reg_1_state_id' => $attorney_reg_1_state_id,
                'attorney_reg_1_num' => $attorney_reg_1_num,
                'pro_vice_hac_num' => $pro_vice_hac_num,
                'created_at' => now(),
                'updated_at' => now(),

                'fname' => $request->fname,
                'lname' => $request->lname,
                'sufname' => $request->sufname,
                'currentstatus' => $request->currentstatus,
                'gender' => $request->gender,
                'attorneytitle' => $request->attorneytitle,
                'insured' => $request->insured,
                'admissiondate' => date("Y-m-d", strtotime($request->admissiondate)),
                'admissiondatevalue' => date("Ymd", strtotime($request->admissiondate)),
                'howadmitted' => $request->howadmitted,
                'birthdate' => date("Y-m-d", strtotime($request->birthdate)),
                'birthdatevalue' => date("Ymd", strtotime($request->birthdate)),
                'firm_tagline' => $request->firm_tagline,
                'firm_state' => $attorney_state->state,
                'firm_state_abr' => $attorney_state->state_abbreviation,
                'email' => $request->email,
                'firm_county' => $attorney_county->county_name,
                'registration_state_1' => $attorney_reg_state->state,
            );
            // echo "<pre>"; print_r($array2);
            $attorney = Attorney::create($array2);
        }

        $array3 = array(
            'case_id' => $case_id,
            'party_id' => $party_id,
            'attorney_id' => $user_attorney->id,
            'trial_attorney' => $trial_attorney,
            'customer_attorney' => $customer_attorney,
            'created_at' => now(),
            'updated_at' => now(),
        );

        // echo "<pre>"; print_r($array3);die;
        $partyattorney = Partyattorney::create($array3);
        // ----------fololowing code is to update case party attorney info table-------------//
        if ($request->party_group == 'top' || $request->party_group == 'bottom') {
            $attorney_ids = Partyattorney::where([['party_id', $party_id], ['case_id', $case_id]])->get()->all();
            $party_group = Caseuser::where([['case_id', $case_id], ['user_id', $party_id]])->get()->pluck('party_group')->first();
            $attorney = array('case_id' => $case_id);
            $party_num = $request->party_number;
            $num = 0;
            $totalattornies = count($attorney_ids);
            foreach ($attorney_ids as $user_id) {
                $attorneyname = User::where('id', $user_id->attorney_id)->get()->first();
                $party_attorney = DB::table('attorneys')
                    ->join('states', 'attorneys.state_id', '=', 'states.id')
                    ->join('counties', [['attorneys.county_id', '=', 'counties.id'], ['attorneys.state_id', '=', 'counties.state_id']])
                    ->where('user_id', $user_id->attorney_id)
                    ->select('attorneys.*', 'states.state', 'counties.id', 'counties.county_name')
                    ->get()->first();
                $caseattytitle = 'Co-Counsel';
                if (count($attorney_ids) == 1 && $user_id->trial_attorney == 'Yes') {
                    $caseattytitle = 'Trial Attorney and Counsel';
                }
                if (count($attorney_ids) > 1 && $user_id->trial_attorney == 'Yes') {
                    $caseattytitle = 'Trial Attorney and Co-Counsel';
                }
                $num++;
                $attorney['' . $party_group . 'party' . $party_num . '_attorney' . $num . '_user_id'] = $user_id->attorney_id;
                $attorney['' . $party_group . 'party' . $party_num . '_attorney' . $num . '_name'] = $attorneyname->name;
                $attorney['' . $party_group . 'party' . $party_num . '_attorney' . $num . '_email'] = $attorneyname->email;
                $attorney['' . $party_group . 'party' . $party_num . '_attorney' . $num . '_document_sign_name'] = $party_attorney->document_sign_name;
                $attorney['' . $party_group . 'party' . $party_num . '_attorney' . $num . '_special_practice'] = $party_attorney->special_practice;
                $attorney['' . $party_group . 'party' . $party_num . '_attorney' . $num . '_special_practice_text'] = $party_attorney->special_practice_text;
                $attorney['' . $party_group . 'party' . $party_num . '_attorney' . $num . '_firm_name'] = $party_attorney->firm_name;
                $attorney['' . $party_group . 'party' . $party_num . '_attorney' . $num . '_firm_street_address'] = $party_attorney->firm_street_address;
                $attorney['' . $party_group . 'party' . $party_num . '_attorney' . $num . '_firm_suite_unit_mailcode'] = $party_attorney->firm_suite_unit_mailcode;
                $attorney['' . $party_group . 'party' . $party_num . '_attorney' . $num . '_po_box'] = $party_attorney->po_box;
                $attorney['' . $party_group . 'party' . $party_num . '_attorney' . $num . '_firm_city'] = $party_attorney->firm_city;
                $attorney['' . $party_group . 'party' . $party_num . '_attorney' . $num . '_firm_state'] = $party_attorney->state;
                $attorney['' . $party_group . 'party' . $party_num . '_attorney' . $num . '_firm_county'] = $party_attorney->county_name;
                $attorney['' . $party_group . 'party' . $party_num . '_attorney' . $num . '_firm_zipcode'] = $party_attorney->firm_zipcode;
                $attorney['' . $party_group . 'party' . $party_num . '_attorney' . $num . '_firm_telephone'] = $party_attorney->firm_telephone;
                $attorney['' . $party_group . 'party' . $party_num . '_attorney' . $num . '_firm_fax'] = $party_attorney->firm_fax;
                $attorney['' . $party_group . 'party' . $party_num . '_attorney' . $num . '_reg_1_num'] = $party_attorney->attorney_reg_1_num;
                $attorney['' . $party_group . 'party' . $party_num . '_attorney' . $num . '_trial_attorney'] = $user_id->trial_attorney;
                $attorney['' . $party_group . 'party' . $party_num . '_attorney' . $num . '_customer_attorney'] = $user_id->customer_attorney;
                $attorney['' . $party_group . 'party' . $party_num . '_attorney' . $num . '_caseattytitle'] = $caseattytitle;
            }
            $limit = $num + 1;
            for ($j = $limit; $j <= 3; $j++) {
                $attorney['' . $party_group . 'party' . $party_num . '_attorney' . $j . '_user_id'] = NULL;
                $attorney['' . $party_group . 'party' . $party_num . '_attorney' . $j . '_name'] = NULL;
                $attorney['' . $party_group . 'party' . $party_num . '_attorney' . $j . '_email'] = NULL;
                $attorney['' . $party_group . 'party' . $party_num . '_attorney' . $j . '_document_sign_name'] = NULL;
                $attorney['' . $party_group . 'party' . $party_num . '_attorney' . $j . '_special_practice'] = NULL;
                $attorney['' . $party_group . 'party' . $party_num . '_attorney' . $j . '_special_practice_text'] = NULL;
                $attorney['' . $party_group . 'party' . $party_num . '_attorney' . $j . '_firm_name'] = NULL;
                $attorney['' . $party_group . 'party' . $party_num . '_attorney' . $j . '_firm_street_address'] = NULL;
                $attorney['' . $party_group . 'party' . $party_num . '_attorney' . $j . '_firm_suite_unit_mailcode'] = NULL;
                $attorney['' . $party_group . 'party' . $party_num . '_attorney' . $j . '_po_box'] = NULL;
                $attorney['' . $party_group . 'party' . $party_num . '_attorney' . $j . '_firm_city'] = NULL;
                $attorney['' . $party_group . 'party' . $party_num . '_attorney' . $j . '_firm_state'] = NULL;
                $attorney['' . $party_group . 'party' . $party_num . '_attorney' . $j . '_firm_county'] = NULL;
                $attorney['' . $party_group . 'party' . $party_num . '_attorney' . $j . '_firm_zipcode'] = NULL;
                $attorney['' . $party_group . 'party' . $party_num . '_attorney' . $j . '_firm_telephone'] = NULL;
                $attorney['' . $party_group . 'party' . $party_num . '_attorney' . $j . '_firm_fax'] = NULL;
                $attorney['' . $party_group . 'party' . $party_num . '_attorney' . $j . '_reg_1_num'] = NULL;
                $attorney['' . $party_group . 'party' . $party_num . '_attorney' . $j . '_trial_attorney'] = NULL;
                $attorney['' . $party_group . 'party' . $party_num . '_attorney' . $j . '_customer_attorney'] = NULL;
                $attorney['' . $party_group . 'party' . $party_num . '_attorney' . $j . '_caseattytitle'] = NULL;
            }
            $partytypeattorneyinfoprev = CasePartyAttorneyInfo::where('case_id', $case_id)->get()->first();
            if ($partytypeattorneyinfoprev) {
                $partytypeattorneyinfo = $partytypeattorneyinfoprev->fill($attorney)->save();
            } else {
                $partytypeattorneyinfo = CasePartyAttorneyInfo::create($attorney);
            }
            $totalpartyattorney = array('' . $party_group . 'party' . $party_num . '_num_attys' => $num);
            $partytypeinfoprev = CasePartyInfo::where('case_id', $case_id)->get()->first();
            if ($partytypeinfoprev) {
                $partytypeinfo = $partytypeinfoprev->fill($totalpartyattorney)->save();
            }
        }
        // for third parties
        if ($request->party_group == 'top_third' || $request->party_group == 'bottom_third') {
            $attorney_ids = Partyattorney::where([['party_id', $party_id], ['case_id', $case_id]])->get()->all();
            $party_group = Caseuser::where([['case_id', $case_id], ['user_id', $party_id]])->get()->pluck('party_group')->first();
            $attorney = array('case_id' => $case_id);
            $party_num = $request->party_number;
            $num = 0;
            $totalattornies = count($attorney_ids);
            foreach ($attorney_ids as $user_id) {
                $attorneyname = User::where('id', $user_id->attorney_id)->get()->first();
                $party_attorney = DB::table('attorneys')
                    ->join('states', 'attorneys.state_id', '=', 'states.id')
                    ->join('counties', [['attorneys.county_id', '=', 'counties.id'], ['attorneys.state_id', '=', 'counties.state_id']])
                    ->where('user_id', $user_id->attorney_id)
                    ->select('attorneys.*', 'states.state', 'counties.id', 'counties.county_name')
                    ->get()->first();
                $caseattytitle = 'Co-Counsel';
                if (count($attorney_ids) == 1 && $user_id->trial_attorney == 'Yes') {
                    $caseattytitle = 'Trial Attorney and Counsel';
                }
                if (count($attorney_ids) > 1 && $user_id->trial_attorney == 'Yes') {
                    $caseattytitle = 'Trial Attorney and Co-Counsel';
                }
                $num++;
                $attorney['' . $party_group . 'party' . $party_num . '_attorney' . $num . '_user_id'] = $user_id->attorney_id;
                $attorney['' . $party_group . 'party' . $party_num . '_attorney' . $num . '_name'] = $attorneyname->name;
                $attorney['' . $party_group . 'party' . $party_num . '_attorney' . $num . '_email'] = $attorneyname->email;
                $attorney['' . $party_group . 'party' . $party_num . '_attorney' . $num . '_document_sign_name'] = $party_attorney->document_sign_name;
                $attorney['' . $party_group . 'party' . $party_num . '_attorney' . $num . '_special_practice'] = $party_attorney->special_practice;
                $attorney['' . $party_group . 'party' . $party_num . '_attorney' . $num . '_special_practice_text'] = $party_attorney->special_practice_text;
                $attorney['' . $party_group . 'party' . $party_num . '_attorney' . $num . '_firm_name'] = $party_attorney->firm_name;
                $attorney['' . $party_group . 'party' . $party_num . '_attorney' . $num . '_firm_street_address'] = $party_attorney->firm_street_address;
                $attorney['' . $party_group . 'party' . $party_num . '_attorney' . $num . '_firm_suite_unit_mailcode'] = $party_attorney->firm_suite_unit_mailcode;
                $attorney['' . $party_group . 'party' . $party_num . '_attorney' . $num . '_po_box'] = $party_attorney->po_box;
                $attorney['' . $party_group . 'party' . $party_num . '_attorney' . $num . '_firm_city'] = $party_attorney->firm_city;
                $attorney['' . $party_group . 'party' . $party_num . '_attorney' . $num . '_firm_state'] = $party_attorney->state;
                $attorney['' . $party_group . 'party' . $party_num . '_attorney' . $num . '_firm_county'] = $party_attorney->county_name;
                $attorney['' . $party_group . 'party' . $party_num . '_attorney' . $num . '_firm_zipcode'] = $party_attorney->firm_zipcode;
                $attorney['' . $party_group . 'party' . $party_num . '_attorney' . $num . '_firm_telephone'] = $party_attorney->firm_telephone;
                $attorney['' . $party_group . 'party' . $party_num . '_attorney' . $num . '_firm_fax'] = $party_attorney->firm_fax;
                $attorney['' . $party_group . 'party' . $party_num . '_attorney' . $num . '_reg_1_num'] = $party_attorney->attorney_reg_1_num;
                $attorney['' . $party_group . 'party' . $party_num . '_attorney' . $num . '_trial_attorney'] = $user_id->trial_attorney;
                $attorney['' . $party_group . 'party' . $party_num . '_attorney' . $num . '_customer_attorney'] = $user_id->customer_attorney;
                $attorney['' . $party_group . 'party' . $party_num . '_attorney' . $num . '_caseattytitle'] = $caseattytitle;
            }
            $limit = $num + 1;
            for ($j = $limit; $j <= 3; $j++) {
                $attorney['' . $party_group . 'party' . $party_num . '_attorney' . $j . '_user_id'] = NULL;
                $attorney['' . $party_group . 'party' . $party_num . '_attorney' . $j . '_name'] = NULL;
                $attorney['' . $party_group . 'party' . $party_num . '_attorney' . $j . '_email'] = NULL;
                $attorney['' . $party_group . 'party' . $party_num . '_attorney' . $j . '_document_sign_name'] = NULL;
                $attorney['' . $party_group . 'party' . $party_num . '_attorney' . $j . '_special_practice'] = NULL;
                $attorney['' . $party_group . 'party' . $party_num . '_attorney' . $j . '_special_practice_text'] = NULL;
                $attorney['' . $party_group . 'party' . $party_num . '_attorney' . $j . '_firm_name'] = NULL;
                $attorney['' . $party_group . 'party' . $party_num . '_attorney' . $j . '_firm_street_address'] = NULL;
                $attorney['' . $party_group . 'party' . $party_num . '_attorney' . $j . '_firm_suite_unit_mailcode'] = NULL;
                $attorney['' . $party_group . 'party' . $party_num . '_attorney' . $j . '_po_box'] = NULL;
                $attorney['' . $party_group . 'party' . $party_num . '_attorney' . $j . '_firm_city'] = NULL;
                $attorney['' . $party_group . 'party' . $party_num . '_attorney' . $j . '_firm_state'] = NULL;
                $attorney['' . $party_group . 'party' . $party_num . '_attorney' . $j . '_firm_county'] = NULL;
                $attorney['' . $party_group . 'party' . $party_num . '_attorney' . $j . '_firm_zipcode'] = NULL;
                $attorney['' . $party_group . 'party' . $party_num . '_attorney' . $j . '_firm_telephone'] = NULL;
                $attorney['' . $party_group . 'party' . $party_num . '_attorney' . $j . '_firm_fax'] = NULL;
                $attorney['' . $party_group . 'party' . $party_num . '_attorney' . $j . '_reg_1_num'] = NULL;
                $attorney['' . $party_group . 'party' . $party_num . '_attorney' . $j . '_trial_attorney'] = NULL;
                $attorney['' . $party_group . 'party' . $party_num . '_attorney' . $j . '_customer_attorney'] = NULL;
                $attorney['' . $party_group . 'party' . $party_num . '_attorney' . $j . '_caseattytitle'] = NULL;
            }
            $partytypeattorneyinfoprev = CaseThirdPartyAttorneyInfo::where('case_id', $case_id)->get()->first();
            if ($partytypeattorneyinfoprev) {
                $partytypeattorneyinfo = $partytypeattorneyinfoprev->fill($attorney)->save();
            } else {
                $partytypeattorneyinfo = CaseThirdPartyAttorneyInfo::create($attorney);
            }
            $totalpartyattorney = array('' . $party_group . 'party' . $party_num . '_num_attys' => $num);
            $partytypeinfoprev = CasePartyInfo::where('case_id', $case_id)->get()->first();
            if ($partytypeinfoprev) {
                $partytypeinfo = $partytypeinfoprev->fill($totalpartyattorney)->save();
            }
        }
        // end for third parties
        // ----------end fololowing code is to update case party attorney info table-------------//

        return redirect()->route('cases.show_attorney_reg_form', ['party_id' => $party_id, 'case_id' => $case_id, 'party_number' => $request->party_number])->with('success', 'Attorney registered successfully.');
    }

    // delete party attorney from a case
    public function delete_party_attorney($party_id, $case_id, $attorney_id, $party_number)
    {
        $court_case_data = Courtcase::find($case_id);
        if (isset($court_case_data) && $court_case_data->attorney_id != Auth::user()->id) {
            return redirect()->route('home');
        }

        Partyattorney::where([['case_id', $case_id], ['party_id', $party_id], ['attorney_id', $attorney_id]])->delete();
        $partyattorney = Partyattorney::where([['case_id', $case_id], ['party_id', $party_id]])->get()->first();
        if ($partyattorney) {
            $partyattorney->trial_attorney = 'Yes';
            $partyattorney->customer_attorney = 'Yes';
            $partyattorney->save();
        }
        // ----------following code is to update case party attorney info table-------------//
        $attorney_ids = Partyattorney::where([['party_id', $party_id], ['case_id', $case_id]])->get()->all();
        $party_group = Caseuser::where([['case_id', $case_id], ['user_id', $party_id]])->get()->pluck('party_group')->first();
        if ($party_group == 'top' || $party_group == 'bottom') {
            $attorney = array('case_id' => $case_id);
            $party_num = $party_number;
            $num = 0;
            $totalattornies = count($attorney_ids);
            foreach ($attorney_ids as $user_id) {
                $attorneyname = User::where('id', $user_id->attorney_id)->get()->first();
                $party_attorney = DB::table('attorneys')
                    ->join('states', 'attorneys.state_id', '=', 'states.id')
                    ->join('counties', [['attorneys.county_id', '=', 'counties.id'], ['attorneys.state_id', '=', 'counties.state_id']])
                    ->where('user_id', $user_id->attorney_id)
                    ->select('attorneys.*', 'states.state', 'counties.id', 'counties.county_name')
                    ->get()->first();
                $caseattytitle = 'Co-Counsel';
                if (count($attorney_ids) == 1 && $user_id->trial_attorney == 'Yes') {
                    $caseattytitle = 'Trial Attorney and Counsel';
                }
                if (count($attorney_ids) > 1 && $user_id->trial_attorney == 'Yes') {
                    $caseattytitle = 'Trial Attorney and Co-Counsel';
                }
                $num++;
                $attorney['' . $party_group . 'party' . $party_num . '_attorney' . $num . '_user_id'] = $user_id->attorney_id;
                $attorney['' . $party_group . 'party' . $party_num . '_attorney' . $num . '_name'] = $attorneyname->name;
                $attorney['' . $party_group . 'party' . $party_num . '_attorney' . $num . '_email'] = $attorneyname->email;
                $attorney['' . $party_group . 'party' . $party_num . '_attorney' . $num . '_document_sign_name'] = $party_attorney->document_sign_name;
                $attorney['' . $party_group . 'party' . $party_num . '_attorney' . $num . '_special_practice'] = $party_attorney->special_practice;
                $attorney['' . $party_group . 'party' . $party_num . '_attorney' . $num . '_special_practice_text'] = $party_attorney->special_practice_text;
                $attorney['' . $party_group . 'party' . $party_num . '_attorney' . $num . '_firm_name'] = $party_attorney->firm_name;
                $attorney['' . $party_group . 'party' . $party_num . '_attorney' . $num . '_firm_street_address'] = $party_attorney->firm_street_address;
                $attorney['' . $party_group . 'party' . $party_num . '_attorney' . $num . '_firm_suite_unit_mailcode'] = $party_attorney->firm_suite_unit_mailcode;
                $attorney['' . $party_group . 'party' . $party_num . '_attorney' . $num . '_po_box'] = $party_attorney->po_box;
                $attorney['' . $party_group . 'party' . $party_num . '_attorney' . $num . '_firm_city'] = $party_attorney->firm_city;
                $attorney['' . $party_group . 'party' . $party_num . '_attorney' . $num . '_firm_state'] = $party_attorney->state;
                $attorney['' . $party_group . 'party' . $party_num . '_attorney' . $num . '_firm_county'] = $party_attorney->county_name;
                $attorney['' . $party_group . 'party' . $party_num . '_attorney' . $num . '_firm_zipcode'] = $party_attorney->firm_zipcode;
                $attorney['' . $party_group . 'party' . $party_num . '_attorney' . $num . '_firm_telephone'] = $party_attorney->firm_telephone;
                $attorney['' . $party_group . 'party' . $party_num . '_attorney' . $num . '_firm_fax'] = $party_attorney->firm_fax;
                $attorney['' . $party_group . 'party' . $party_num . '_attorney' . $num . '_reg_1_num'] = $party_attorney->attorney_reg_1_num;
                $attorney['' . $party_group . 'party' . $party_num . '_attorney' . $num . '_trial_attorney'] = $user_id->trial_attorney;
                $attorney['' . $party_group . 'party' . $party_num . '_attorney' . $num . '_customer_attorney'] = $user_id->customer_attorney;
                $attorney['' . $party_group . 'party' . $party_num . '_attorney' . $num . '_caseattytitle'] = $caseattytitle;
            }
            $limit = $num + 1;
            for ($j = $limit; $j <= 3; $j++) {
                $attorney['' . $party_group . 'party' . $party_num . '_attorney' . $j . '_user_id'] = NULL;
                $attorney['' . $party_group . 'party' . $party_num . '_attorney' . $j . '_name'] = NULL;
                $attorney['' . $party_group . 'party' . $party_num . '_attorney' . $j . '_email'] = NULL;
                $attorney['' . $party_group . 'party' . $party_num . '_attorney' . $j . '_document_sign_name'] = NULL;
                $attorney['' . $party_group . 'party' . $party_num . '_attorney' . $j . '_special_practice'] = NULL;
                $attorney['' . $party_group . 'party' . $party_num . '_attorney' . $j . '_special_practice_text'] = NULL;
                $attorney['' . $party_group . 'party' . $party_num . '_attorney' . $j . '_firm_name'] = NULL;
                $attorney['' . $party_group . 'party' . $party_num . '_attorney' . $j . '_firm_street_address'] = NULL;
                $attorney['' . $party_group . 'party' . $party_num . '_attorney' . $j . '_firm_suite_unit_mailcode'] = NULL;
                $attorney['' . $party_group . 'party' . $party_num . '_attorney' . $j . '_po_box'] = NULL;
                $attorney['' . $party_group . 'party' . $party_num . '_attorney' . $j . '_firm_city'] = NULL;
                $attorney['' . $party_group . 'party' . $party_num . '_attorney' . $j . '_firm_state'] = NULL;
                $attorney['' . $party_group . 'party' . $party_num . '_attorney' . $j . '_firm_county'] = NULL;
                $attorney['' . $party_group . 'party' . $party_num . '_attorney' . $j . '_firm_zipcode'] = NULL;
                $attorney['' . $party_group . 'party' . $party_num . '_attorney' . $j . '_firm_telephone'] = NULL;
                $attorney['' . $party_group . 'party' . $party_num . '_attorney' . $j . '_firm_fax'] = NULL;
                $attorney['' . $party_group . 'party' . $party_num . '_attorney' . $j . '_reg_1_num'] = NULL;
                $attorney['' . $party_group . 'party' . $party_num . '_attorney' . $j . '_trial_attorney'] = NULL;
                $attorney['' . $party_group . 'party' . $party_num . '_attorney' . $j . '_customer_attorney'] = NULL;
                $attorney['' . $party_group . 'party' . $party_num . '_attorney' . $j . '_caseattytitle'] = NULL;
            }
            $partytypeattorneyinfoprev = CasePartyAttorneyInfo::where('case_id', $case_id)->get()->first();
            if ($partytypeattorneyinfoprev) {
                $partytypeattorneyinfo = $partytypeattorneyinfoprev->fill($attorney)->save();
            } else {
                $partytypeattorneyinfo = CasePartyAttorneyInfo::create($attorney);
            }
            $totalpartyattorney = array('' . $party_group . 'party' . $party_num . '_num_attys' => $num);
            $partytypeinfoprev = CasePartyInfo::where('case_id', $case_id)->get()->first();
            if ($partytypeinfoprev) {
                $partytypeinfo = $partytypeinfoprev->fill($totalpartyattorney)->save();
            }
        }
        // for third parties
        if ($party_group == 'top_third' || $party_group == 'bottom_third') {
            $attorney = array('case_id' => $case_id);
            $party_num = $party_number;
            $num = 0;
            $totalattornies = count($attorney_ids);
            foreach ($attorney_ids as $user_id) {
                $attorneyname = User::where('id', $user_id->attorney_id)->get()->first();
                $party_attorney = DB::table('attorneys')
                    ->join('states', 'attorneys.state_id', '=', 'states.id')
                    ->join('counties', [['attorneys.county_id', '=', 'counties.id'], ['attorneys.state_id', '=', 'counties.state_id']])
                    ->where('user_id', $user_id->attorney_id)
                    ->select('attorneys.*', 'states.state', 'counties.id', 'counties.county_name')
                    ->get()->first();
                $caseattytitle = 'Co-Counsel';
                if (count($attorney_ids) == 1 && $user_id->trial_attorney == 'Yes') {
                    $caseattytitle = 'Trial Attorney and Counsel';
                }
                if (count($attorney_ids) > 1 && $user_id->trial_attorney == 'Yes') {
                    $caseattytitle = 'Trial Attorney and Co-Counsel';
                }
                $num++;
                $attorney['' . $party_group . 'party' . $party_num . '_attorney' . $num . '_user_id'] = $user_id->attorney_id;
                $attorney['' . $party_group . 'party' . $party_num . '_attorney' . $num . '_name'] = $attorneyname->name;
                $attorney['' . $party_group . 'party' . $party_num . '_attorney' . $num . '_email'] = $attorneyname->email;
                $attorney['' . $party_group . 'party' . $party_num . '_attorney' . $num . '_document_sign_name'] = $party_attorney->document_sign_name;
                $attorney['' . $party_group . 'party' . $party_num . '_attorney' . $num . '_special_practice'] = $party_attorney->special_practice;
                $attorney['' . $party_group . 'party' . $party_num . '_attorney' . $num . '_special_practice_text'] = $party_attorney->special_practice_text;
                $attorney['' . $party_group . 'party' . $party_num . '_attorney' . $num . '_firm_name'] = $party_attorney->firm_name;
                $attorney['' . $party_group . 'party' . $party_num . '_attorney' . $num . '_firm_street_address'] = $party_attorney->firm_street_address;
                $attorney['' . $party_group . 'party' . $party_num . '_attorney' . $num . '_firm_suite_unit_mailcode'] = $party_attorney->firm_suite_unit_mailcode;
                $attorney['' . $party_group . 'party' . $party_num . '_attorney' . $num . '_po_box'] = $party_attorney->po_box;
                $attorney['' . $party_group . 'party' . $party_num . '_attorney' . $num . '_firm_city'] = $party_attorney->firm_city;
                $attorney['' . $party_group . 'party' . $party_num . '_attorney' . $num . '_firm_state'] = $party_attorney->state;
                $attorney['' . $party_group . 'party' . $party_num . '_attorney' . $num . '_firm_county'] = $party_attorney->county_name;
                $attorney['' . $party_group . 'party' . $party_num . '_attorney' . $num . '_firm_zipcode'] = $party_attorney->firm_zipcode;
                $attorney['' . $party_group . 'party' . $party_num . '_attorney' . $num . '_firm_telephone'] = $party_attorney->firm_telephone;
                $attorney['' . $party_group . 'party' . $party_num . '_attorney' . $num . '_firm_fax'] = $party_attorney->firm_fax;
                $attorney['' . $party_group . 'party' . $party_num . '_attorney' . $num . '_reg_1_num'] = $party_attorney->attorney_reg_1_num;
                $attorney['' . $party_group . 'party' . $party_num . '_attorney' . $num . '_trial_attorney'] = $user_id->trial_attorney;
                $attorney['' . $party_group . 'party' . $party_num . '_attorney' . $num . '_customer_attorney'] = $user_id->customer_attorney;
                $attorney['' . $party_group . 'party' . $party_num . '_attorney' . $num . '_caseattytitle'] = $caseattytitle;
            }
            $limit = $num + 1;
            for ($j = $limit; $j <= 3; $j++) {
                $attorney['' . $party_group . 'party' . $party_num . '_attorney' . $j . '_user_id'] = NULL;
                $attorney['' . $party_group . 'party' . $party_num . '_attorney' . $j . '_name'] = NULL;
                $attorney['' . $party_group . 'party' . $party_num . '_attorney' . $j . '_email'] = NULL;
                $attorney['' . $party_group . 'party' . $party_num . '_attorney' . $j . '_document_sign_name'] = NULL;
                $attorney['' . $party_group . 'party' . $party_num . '_attorney' . $j . '_special_practice'] = NULL;
                $attorney['' . $party_group . 'party' . $party_num . '_attorney' . $j . '_special_practice_text'] = NULL;
                $attorney['' . $party_group . 'party' . $party_num . '_attorney' . $j . '_firm_name'] = NULL;
                $attorney['' . $party_group . 'party' . $party_num . '_attorney' . $j . '_firm_street_address'] = NULL;
                $attorney['' . $party_group . 'party' . $party_num . '_attorney' . $j . '_firm_suite_unit_mailcode'] = NULL;
                $attorney['' . $party_group . 'party' . $party_num . '_attorney' . $j . '_po_box'] = NULL;
                $attorney['' . $party_group . 'party' . $party_num . '_attorney' . $j . '_firm_city'] = NULL;
                $attorney['' . $party_group . 'party' . $party_num . '_attorney' . $j . '_firm_state'] = NULL;
                $attorney['' . $party_group . 'party' . $party_num . '_attorney' . $j . '_firm_county'] = NULL;
                $attorney['' . $party_group . 'party' . $party_num . '_attorney' . $j . '_firm_zipcode'] = NULL;
                $attorney['' . $party_group . 'party' . $party_num . '_attorney' . $j . '_firm_telephone'] = NULL;
                $attorney['' . $party_group . 'party' . $party_num . '_attorney' . $j . '_firm_fax'] = NULL;
                $attorney['' . $party_group . 'party' . $party_num . '_attorney' . $j . '_reg_1_num'] = NULL;
                $attorney['' . $party_group . 'party' . $party_num . '_attorney' . $j . '_trial_attorney'] = NULL;
                $attorney['' . $party_group . 'party' . $party_num . '_attorney' . $j . '_customer_attorney'] = NULL;
                $attorney['' . $party_group . 'party' . $party_num . '_attorney' . $j . '_caseattytitle'] = NULL;
            }
            $partytypeattorneyinfoprev = CaseThirdPartyAttorneyInfo::where('case_id', $case_id)->get()->first();
            if ($partytypeattorneyinfoprev) {
                $partytypeattorneyinfo = $partytypeattorneyinfoprev->fill($attorney)->save();
            } else {
                $partytypeattorneyinfo = CaseThirdPartyAttorneyInfo::create($attorney);
            }
            $totalpartyattorney = array('' . $party_group . 'party' . $party_num . '_num_attys' => $num);
            $partytypeinfoprev = CasePartyInfo::where('case_id', $case_id)->get()->first();
            if ($partytypeinfoprev) {
                $partytypeinfo = $partytypeinfoprev->fill($totalpartyattorney)->save();
            }
        }
        // end for third parties
        // ----------end fololowing code is to update case party attorney info table-------------//

        return redirect()->route('cases.show_attorney_reg_form', ['party_id' => $party_id, 'case_id' => $case_id, 'party_number' => $party_number])->with('success', 'Attorney seleted successfully.');
    }

    // to show computation sheets for cases not prefilled with case data.
    public function showComputationSheet(Request $request)
    {
       
        $case_details = Courtcase::find($request->case_id);
        if ($case_details && $case_details->attorney_id == Auth::user()->id) {
        } else {
            return redirect()->route('cases.index');
        }
 
        $form_custody = strtolower($request->form_custody);
        $user_ids_top = Caseuser::where([['case_id', $request->case_id], ['party_group', 'top']])->get()->pluck('user_id')->first();
        $user_ids_bottom = Caseuser::where([['case_id', $request->case_id], ['party_group', 'bottom']])->get()->pluck('user_id')->first();
        if ($user_ids_top) {
            $top_party_data = User::where('id', $user_ids_top)->get()->first();
        }
        if ($user_ids_bottom) {
            $bottom_party_data = User::where('id', $user_ids_bottom)->get()->first();
        }
        $attorney_data = User::find(Auth::user()->id)->attorney;
        // $prefill_data = DB::table('users_attorney_submissions')
        //                 ->where([
        //                   ['user_id', '=', Auth::user()->id],
        //                   ['case_id', '=',$request->case_id],
        //                   ['form_state', '=', $request->form_state],
        //                   ['form_custody', '=', $form_custody]
        //                 ])
        //                  ->orderBy('id', 'desc')
        //                  ->limit(1)
        //                 ->get()->pluck('form_text');
        // if(isset($prefill_data[0])){
        //     $case_data['case_id']=$request->case_id;
        //     $postData=unserialize($prefill_data[0]);
        //     $ohMinimumWageData=DB::select(DB::raw("select getOHMinimumWage2018(0) AS tmpResult"));
        //     $OH_Minimum_Wage = $ohMinimumWageData[0]->tmpResult;
        //     $postData['OH_Minimum_Wage']=$OH_Minimum_Wage;
        //     if($form_custody=='split'){
        //         return view('computations.split',['sheet_custody' =>$form_custody, 'sheet_state' =>$request->form_state, 'chk_prefill'=>'1', 'case_data'=>$case_data, 'postData'=>$postData,  'attorney_data'=>$attorney_data ]);
        //     } else {
        //         return view('computations.sole_shared',['sheet_custody' =>$form_custody, 'sheet_state' =>$request->form_state, 'case_data'=>$case_data, 'chk_prefill'=>'1', 'postData'=>$postData,  'attorney_data'=>$attorney_data ]);
        //     }
        // } else {
        if (isset($top_party_data)) {
            $client_name = $top_party_data->name;
        } else {
            $client_name = 'ClientName';
        }
        if (isset($bottom_party_data)) {
            $opponent_name = $bottom_party_data->name;
        } else {
            $opponent_name = 'OpName';
        }

        $caseuser = DB::table('caseusers')
            ->join('users', 'caseusers.user_id', '=', 'users.id')
            ->where([['caseusers.case_id', $request->case_id], ['caseusers.party_group', 'top']])
            ->select('users.name', 'caseusers.party_entity', 'caseusers.mname', 'caseusers.org_comp_name')
            ->first();
        if (isset($caseuser->name)) {
            $client_full_name = $caseuser->name;
            if (isset($caseuser->party_entity) && $caseuser->party_entity == 'organization_company') {
                $client_full_name = $caseuser->org_comp_name;
            } else {
                $mname = $caseuser->mname;
                if (isset($mname) && $mname != '') {
                    $namearray = explode(' ', $caseuser->name, 2);
                    if (count($namearray) > 1) {
                        $client_full_name = $namearray[0] . ' ' . $mname . ' ' . $namearray[1];
                    } else {
                        $client_full_name = $caseuser->name . ' ' . $mname;
                    }
                }
            }
        } else {
            $client_full_name = $client_name;
        }
        $caseuser = DB::table('caseusers')
            ->join('users', 'caseusers.user_id', '=', 'users.id')
            ->where([['caseusers.case_id', $request->case_id], ['caseusers.party_group', 'bottom']])
            ->select('users.name', 'caseusers.party_entity', 'caseusers.mname', 'caseusers.org_comp_name')
            ->first();
        if (isset($caseuser->name)) {
            $opponent_full_name = $caseuser->name;
            if (isset($caseuser->party_entity) && $caseuser->party_entity == 'organization_company') {
                $opponent_full_name = $caseuser->org_comp_name;
            } else {
                $mname = $caseuser->mname;
                if (isset($mname) && $mname != '') {
                    $namearray = explode(' ', $caseuser->name, 2);
                    if (count($namearray) > 1) {
                        $opponent_full_name = $namearray[0] . ' ' . $mname . ' ' . $namearray[1];
                    } else {
                        $opponent_full_name = $caseuser->name . ' ' . $mname;
                    }
                }
            }
        } else {
            $opponent_full_name = $opponent_name;
        }

        $case_data = array(
            'case_id' => $request->case_id,
            'client_name' => $client_name,
            'opponent_name' => $opponent_name,
            'client_full_name' => $client_full_name,
            'opponent_full_name' => $opponent_full_name
        );
        $ohMinimumWageData = DB::select(DB::raw("select getOHMinimumWage2018(0) AS tmpResult"));
        $OH_Minimum_Wage = $ohMinimumWageData[0]->tmpResult;



        if (isset($request->computation_sheet_version) && $request->computation_sheet_version == 'Computed from Database') {
            $childreninfo = DrChildren::where('case_id', $request->case_id)->get()->first();
            if (isset($childreninfo) && isset($childreninfo->This_Marriage_Custody_Arrangement)) {
                $form_custody = strtolower($childreninfo->This_Marriage_Custody_Arrangement);
            } else {
                die('Please Fill Dr Children Info first.');
            }

            if (strtolower($form_custody) == 'split') {
            } else {
                if (isset($childreninfo->This_Marriage_Child_Support_Obligor_CLient_OP) && $childreninfo->This_Marriage_Child_Support_Obligor_CLient_OP == $opponent_full_name) {
                    $case_data['client_name'] = $client_name;
                    $case_data['client_full_name'] = $client_full_name;
                    $case_data['opponent_name'] = $opponent_name;
                    $case_data['opponent_full_name'] = $opponent_full_name;
                } else {
                    $case_data['client_name'] = $opponent_name;
                    $case_data['client_full_name'] = $opponent_full_name;
                    $case_data['opponent_name'] = $client_name;
                    $case_data['opponent_full_name'] = $client_full_name;
                }
            }

            $prefill_data = DB::table('users_attorney_submissions')
                ->where([
                    ['user_id', '=', Auth::user()->id],
                    ['case_id', '=', $request->case_id],
                    ['form_state', '=', $request->form_state],
                    ['form_custody', '=', $form_custody]
                ])
                ->orderBy('id', 'desc')
                ->limit(1)
                ->get()->pluck('form_text');
            // if(isset($prefill_data[0])){
            //     $postData=unserialize($prefill_data[0]);
            //     $ohMinimumWageData=DB::select(DB::raw("select getOHMinimumWage2018(0) AS tmpResult"));
            //     $OH_Minimum_Wage = $ohMinimumWageData[0]->tmpResult;
            //     $postData['OH_Minimum_Wage']=$OH_Minimum_Wage;

            //     if($form_custody=='split'){
            //         return view('computations.computed.split',['sheet_custody' =>$form_custody, 'sheet_state' =>$request->form_state, 'chk_prefill'=>'1', 'case_data'=>$case_data, 'postData'=>$postData,  'attorney_data'=>$attorney_data ]);
            //     } else {
            //         return view('computations.computed.sole_shared',['sheet_custody' =>$form_custody, 'sheet_state' =>$request->form_state, 'case_data'=>$case_data, 'chk_prefill'=>'1', 'postData'=>$postData,  'attorney_data'=>$attorney_data ]);
            //     }
            // } else {

            $ohMinimumWageData = DB::select(DB::raw("select getOHMinimumWage2018(0) AS tmpResult"));
            $OH_Minimum_Wage = $ohMinimumWageData[0]->tmpResult;
            $postData['OH_Minimum_Wage'] = $OH_Minimum_Wage;

            if (isset($case_details->county_id)) {
                $postData['county_name'] = $case_details->county_id;
            }
            if (isset($case_details->sets)) {
                $postData['sets_case_number'] = $case_details->sets;
            }
            if (isset($case_details->case_number)) {
                $postData['court_administrative_order_number'] = $case_details->case_number;
            }
            if (!($case_details->case_number) && isset($case_details->original_case_number)) {
                $postData['court_administrative_order_number'] = $case_details->case_number;
            }

            if (isset($childreninfo)) {
                $postData['number_children_order'] = $childreninfo->Num_MinorDepChildren_ONLY_This_Marriage;
            }

            $income = DrIncome::where('case_id', $request->case_id)->get()->first();
            if (isset($income)) {
                // to get 1st Point Info of Sheet.
                if (isset($income->Client_Wages_per_Period)) {
                    $postData['obligee_1_radio'] = 'year';
                    $postData['obligee_1_input_year'] = $income->Client_Wages_per_Period;
                    $postData['obligee_1_dropdown'] = $income->Client_Pay_Periods_Yearly;
                }
                if (isset($income->Op_Wages_per_Period)) {
                    $postData['obligor_1_radio'] = 'year';
                    $postData['obligor_1_input_year'] = $income->Op_Wages_per_Period;
                    $postData['obligor_1_dropdown'] = $income->Op_Pay_Periods_Yearly;
                }
                if (isset($income->Client_Pay_YTD)) {
                    $postData['obligee_1_radio'] = 'ytd';
                    $postData['obligee_1_input_ytd'] = $income->Client_Pay_YTD;
                    $postData['obligee_1_datepick'] = date("m/d/Y", strtotime($income->Client_YTD_Date));
                }
                if (isset($income->Op_Pay_YTD)) {
                    $postData['obligor_1_radio'] = 'ytd';
                    $postData['obligor_1_input_ytd'] = $income->Op_Pay_YTD;
                    $postData['obligor_1_datepick'] = date("m/d/Y", strtotime($income->Op_YTD_Date));
                }
                if (isset($income->Client_RegWage_YTD_MinWage) && $income->Client_RegWage_YTD_MinWage == '3') {
                    $postData['obligee_1_radio'] = 'oh_min_wage';
                }
                if (isset($income->Op_RegWage_YTD_MinWage) && $income->Op_RegWage_YTD_MinWage == '3') {
                    $postData['obligor_1_radio'] = 'oh_min_wage';
                }

                // to get 2nd Point Info of Sheet.
                if (isset($income->Client_Third_Most_Recent_Yearly_OT_Comms_Bonuses)) {
                    $postData['obligee_2a'] = $income->Client_Third_Most_Recent_Yearly_OT_Comms_Bonuses;
                }
                if (isset($income->Op_Third_Most_Recent_Yearly_OT_Comms_Bonuses)) {
                    $postData['obligor_2a'] = $income->Op_Third_Most_Recent_Yearly_OT_Comms_Bonuses;
                }
                if (isset($income->Client_Second_Most_Recent_Yearly_OT_Comms_Bonuses)) {
                    $postData['obligee_2b'] = $income->Client_Second_Most_Recent_Yearly_OT_Comms_Bonuses;
                }
                if (isset($income->Op_Second_Most_Recent_Yearly_OT_Comms_Bonuses)) {
                    $postData['obligor_2b'] = $income->Op_Second_Most_Recent_Yearly_OT_Comms_Bonuses;
                }
                if (isset($income->Client_Most_Recent_Yearly_OT_Comms_Bonuses)) {
                    $postData['obligee_2c'] = $income->Client_Most_Recent_Yearly_OT_Comms_Bonuses;
                }
                if (isset($income->Op_Most_Recent_Yearly_OT_Comms_Bonuses)) {
                    $postData['obligor_2c'] = $income->Op_Most_Recent_Yearly_OT_Comms_Bonuses;
                }
                if (isset($income->Client_Min_Ave_OT_Comms_Bonuses)) {
                    $postData['obligee_2d'] = $income->Client_Min_Ave_OT_Comms_Bonuses;
                }
                if (isset($income->Op_Min_Ave_OT_Comms_Bonuses)) {
                    $postData['obligor_2d'] = $income->Op_Min_Ave_OT_Comms_Bonuses;
                }

                // to get 3rd Point Info of Sheet.
                if (isset($income->Client_Yearly_Gross_Self_Employment_Income)) {
                    $postData['obligee_3a'] = $income->Client_Yearly_Gross_Self_Employment_Income;
                }
                if (isset($income->Op_Yearly_Gross_Self_Employment_Income)) {
                    $postData['obligor_3a'] = $income->Op_Yearly_Gross_Self_Employment_Income;
                }
                if (isset($income->Client_Yearly_Self_Employment_Expenses)) {
                    $postData['obligee_3b'] = $income->Client_Yearly_Self_Employment_Expenses;
                }
                if (isset($income->Op_Yearly_Self_Employment_Expenses)) {
                    $postData['obligor_3b'] = $income->Op_Yearly_Self_Employment_Expenses;
                }

                // to get 4th Point Info of Sheet.
                if (isset($income->Client_Yearly_Unemployment_Compensation)) {
                    $postData['obligee_4'] = $income->Client_Yearly_Unemployment_Compensation;
                }
                if (isset($income->Op_Yearly_Unemployment_Compensation)) {
                    $postData['obligor_4'] = $income->Op_Yearly_Unemployment_Compensation;
                }

                // to get 5th Point Info of Sheet.
                $postData['obligee_5'] = 0.00;
                $postData['obligor_5'] = 0.00;

                if (isset($income->Client_Yearly_Workers_Compensation)) {
                    $postData['obligee_5'] = $postData['obligee_5'] + $income->Client_Yearly_Workers_Compensation;
                }
                if (isset($income->Client_Yearly_Social_Security_Disability)) {
                    $postData['obligee_5'] = $postData['obligee_5'] + $income->Client_Yearly_Social_Security_Disability;
                }
                if (isset($income->Client_Yearly_Other_Disability_Income)) {
                    $postData['obligee_5'] = $postData['obligee_5'] + $income->Client_Yearly_Other_Disability_Income;
                }
                if (isset($income->Client_Yearly_Social_Security_Retirement)) {
                    $postData['obligee_5'] = $postData['obligee_5'] + $income->Client_Yearly_Social_Security_Retirement;
                }

                if (isset($income->Op_Yearly_Workers_Compensation)) {
                    $postData['obligor_5'] = $postData['obligor_5'] + $income->Op_Yearly_Workers_Compensation;
                }
                if (isset($income->Op_Yearly_Social_Security_Disability)) {
                    $postData['obligor_5'] = $postData['obligor_5'] + $income->Op_Yearly_Social_Security_Disability;
                }
                if (isset($income->Op_Yearly_Other_Disability_Income)) {
                    $postData['obligor_5'] = $postData['obligor_5'] + $income->Op_Yearly_Other_Disability_Income;
                }
                if (isset($income->Op_Yearly_Social_Security_Retirement)) {
                    $postData['obligor_5'] = $postData['obligor_5'] + $income->Op_Yearly_Social_Security_Retirement;
                }

                // to get 6th Point Info of Sheet.
                $postData['obligee_6'] = 0.00;
                $postData['obligor_6'] = 0.00;

                if (isset($income->Client_Rent)) {
                    $postData['obligee_6'] = $postData['obligee_6'] + $income->Client_Rent;
                }
                if (isset($income->Client_Retirement_Pensions)) {
                    $postData['obligee_6'] = $postData['obligee_6'] + $income->Client_Retirement_Pensions;
                }
                if (isset($income->Client_Interest_Dividends)) {
                    $postData['obligee_6'] = $postData['obligee_6'] + $income->Client_Interest_Dividends;
                }

                if (isset($income->Op_Rent)) {
                    $postData['obligor_6'] = $postData['obligor_6'] + $income->Op_Rent;
                }
                if (isset($income->Op_Retirement_Pensions)) {
                    $postData['obligor_6'] = $postData['obligor_6'] + $income->Op_Retirement_Pensions;
                }
                if (isset($income->Op_Interest_Dividends)) {
                    $postData['obligor_6'] = $postData['obligor_6'] + $income->Op_Interest_Dividends;
                }
            }


            if (isset($childreninfo)) {
                // to get 9th Point Info of Sheet.
                $postData['obligee_9a'] = 0.00;
                $postData['obligor_9a'] = 0.00;
                if (isset($childreninfo->Num_Children_ONLY_This_Marriage)) {
                    $postData['obligee_9a'] = $postData['obligee_9a'] + $childreninfo->Num_Children_ONLY_This_Marriage;
                }
                if (isset($childreninfo->Num_Client_Children_NOT_this_Marriage)) {
                    $postData['obligee_9a'] = $postData['obligee_9a'] + $childreninfo->Num_Client_Children_NOT_this_Marriage;
                }

                if (isset($childreninfo->Num_Children_ONLY_This_Marriage)) {
                    $postData['obligor_9a'] = $postData['obligor_9a'] + $childreninfo->Num_Children_ONLY_This_Marriage;
                }
                if (isset($childreninfo->Num_Op_Children_NOT_this_Marriage)) {
                    $postData['obligor_9a'] = $postData['obligor_9a'] + $childreninfo->Num_Op_Children_NOT_this_Marriage;
                }

                // if(isset($childreninfo->Num_MinorDepChildren_ONLY_This_Marriage)){
                //     $postData['obligee_9b']=$childreninfo->Num_MinorDepChildren_ONLY_This_Marriage;
                //     $postData['obligor_9b']=$childreninfo->Num_MinorDepChildren_ONLY_This_Marriage;
                // }

                // to get 10th Point Info of Sheet.
                $postData['obligee_10a'] = $postData['obligor_10a'] = '0';
                $client_name_array = explode(" ", $client_name);
                if (isset($childreninfo->This_Marriage_Health_Ins_Obligor_CLient_OP) && isset($client_name_array[0]) && strpos($childreninfo->This_Marriage_Health_Ins_Obligor_CLient_OP, $client_name_array[0]) !== false) {
                    if (isset($childreninfo->This_Marriage_Health_Ins_Obligor_CLient_OP) && isset($client_name_array[1])) {
                        if (strpos($childreninfo->This_Marriage_Health_Ins_Obligor_CLient_OP, $client_name_array[1]) !== false) {
                            $postData['obligee_10a'] = '1';
                        } else {
                            $postData['obligee_10a'] = '0';
                        }
                    } else {
                        $postData['obligee_10a'] = '1';
                    }
                }
                $opponent_name_array = explode(" ", $opponent_name);
                if (isset($childreninfo->This_Marriage_Health_Ins_Obligor_CLient_OP) && isset($opponent_name_array[0]) && strpos($childreninfo->This_Marriage_Health_Ins_Obligor_CLient_OP, $opponent_name_array[0]) !== false) {
                    if (isset($childreninfo->This_Marriage_Health_Ins_Obligor_CLient_OP) && isset($opponent_name_array[1])) {
                        if (strpos($childreninfo->This_Marriage_Health_Ins_Obligor_CLient_OP, $opponent_name_array[1]) !== false) {
                            $postData['obligor_10a'] = '1';
                        } else {
                            $postData['obligor_10a'] = '0';
                        }
                    } else {
                        $postData['obligor_10a'] = '1';
                    }
                }
                if (isset($childreninfo->This_Marriage_Health_Ins_Obligor_CLient_OP) && $childreninfo->This_Marriage_Health_Ins_Obligor_CLient_OP == 'Both Parties') {
                    $postData['obligee_10a'] = '1';
                    $postData['obligor_10a'] = '1';
                }
            }

            $insurance = DrInsurance::where('case_id', $request->case_id)->get()->first();
            if (isset($insurance)) {
                // to get 10th Point Info of Sheet.
                $postData['obligee_10b'] = 0.00;
                $postData['obligor_10b'] = 0.00;
                if (isset($insurance->Client_Monthly_Health_Insurance_Premium)) {
                    $postData['obligee_10b'] = 12 * $insurance->Client_Monthly_Health_Insurance_Premium;
                }
                if (isset($insurance->Op_Monthly_Health_Insurance_Premium)) {
                    $postData['obligor_10b'] = 12 * $insurance->Op_Monthly_Health_Insurance_Premium;
                }
            }

            // to get 11th Point Info of Sheet.
            $DrSpousalSupportThisMarriage = DrSpousalSupportThisMarriage::where('case_id', $request->case_id)->get()->first();
            $DrMonthlyLivingExpenses = DrMonthlyLivingExpenses::where('case_id', $request->case_id)->get()->first();
            $postData['obligee_11'] = 0.00;
            $postData['obligor_11'] = 0.00;
            if (isset($DrSpousalSupportThisMarriage)) {
                if (isset($DrSpousalSupportThisMarriage->Monthly_Spousal_Support_Amount)) {
                    $postData['obligee_11'] = $postData['obligor_11'] = 12 * $DrSpousalSupportThisMarriage->Monthly_Spousal_Support_Amount;
                }
            }
            if (isset($DrMonthlyLivingExpenses)) {
                if (isset($DrMonthlyLivingExpenses->Client_Monthly_Pays_Spousal_Support_NOM)) {
                    $postData['obligee_11'] = 12 * $DrMonthlyLivingExpenses->Client_Monthly_Pays_Spousal_Support_NOM;
                }
                if (isset($DrMonthlyLivingExpenses->Op_Monthly_Pays_Spousal_Support_NOM)) {
                    $postData['obligor_11'] = 12 * $DrMonthlyLivingExpenses->Op_Monthly_Pays_Spousal_Support_NOM;
                }
            }
            if (isset($DrMonthlyLivingExpenses) && isset($DrMonthlyLivingExpenses)) {
                if (isset($DrSpousalSupportThisMarriage->Monthly_Spousal_Support_Amount) && isset($DrMonthlyLivingExpenses->Client_Monthly_Pays_Spousal_Support_NOM)) {
                    $postData['obligee_11'] = 12 * ($DrSpousalSupportThisMarriage->Monthly_Spousal_Support_Amount + $DrMonthlyLivingExpenses->Client_Monthly_Pays_Spousal_Support_NOM);
                }
                if (isset($DrSpousalSupportThisMarriage->Monthly_Spousal_Support_Amount) && isset($DrMonthlyLivingExpenses->Op_Monthly_Pays_Spousal_Support_NOM)) {
                    $postData['obligor_11'] = 12 * ($DrSpousalSupportThisMarriage->Monthly_Spousal_Support_Amount + $DrMonthlyLivingExpenses->Op_Monthly_Pays_Spousal_Support_NOM);
                }
            }

            if (strtolower($form_custody) == 'sole' || strtolower($form_custody) == 'shared') {
                // to get 21st Point Info of Sheet.
                if (isset($childreninfo)) {
                    $children_length = array('First', 'Second', 'Third', 'Fourth', 'Fifth', 'Sixth', 'Seventh', 'Eigth');
                    $b = 1;
                    for ($i = 0; $i < $childreninfo->Num_Children_ONLY_This_Marriage; $i++) {
                        $obj_key = 'This_Marriage_' . $children_length[$i] . '_Child_DOB';

                        $obj_key3 = 'This_Marriage_' . $children_length[$i] . '_Child_Disabled_Dependent_Y_N';
                        $is_disabled_dependent = $childreninfo->{$obj_key3};

                        $child_age = Carbon::parse($childreninfo->{$obj_key})->age;

                        if ((isset($is_disabled_dependent) && $is_disabled_dependent == 'Yes') || (isset($child_age) && $child_age < '18')) {
                            $postData['obligee_21b' . $b . ''] = date("m/d/Y", strtotime($childreninfo->{$obj_key}));
                            $b++;
                        }
                    }
                }

                $postData['obligor_25b'] = 0.00;
                $postData['obligor_28'] = 0.00;

                return view('computations.computed.sole_shared', ['sheet_custody' => $form_custody, 'sheet_state' => $request->form_state, 'case_data' => $case_data, 'chk_prefill' => '1', 'attorney_data' => $attorney_data, 'OH_Minimum_Wage' => $OH_Minimum_Wage, 'postData' => $postData]);
            }

            if (strtolower($form_custody) == 'split') {
                if (isset($childreninfo)) {
                    // to get 18th and 21st Point Info of Sheet.
                    $with_parent_A = 0;
                    $with_parent_B = 0;
                    $i_A = 1;
                    $i_B = 1;
                    $children_length = array('First', 'Second', 'Third', 'Fourth', 'Fifth', 'Sixth', 'Seventh', 'Eigth');
                    $children_name = array(
                        'Child_1' => ['name' => 'Child 1', 'parent_name' => ''],
                        'Child_2' => ['name' => 'Child 2', 'parent_name' => ''],
                        'Child_3' => ['name' => 'Child 3', 'parent_name' => ''],
                        'Child_4' => ['name' => 'Child 4', 'parent_name' => ''],
                        'Child_5' => ['name' => 'Child 5', 'parent_name' => ''],
                        'Child_6' => ['name' => 'Child 6', 'parent_name' => ''],
                        'Child_7' => ['name' => 'Child 7', 'parent_name' => ''],
                        'Child_8' => ['name' => 'Child 8', 'parent_name' => '']
                    );
                    for ($i = 0; $i < $childreninfo->Num_Children_ONLY_This_Marriage; $i++) {
                        $b = $i + 1;
                        $obj_key = 'This_Marriage_' . $children_length[$i] . '_Child_DOB';
                        $postData['obligee_21b' . $i_A . ''] = NULL;
                        $postData['obligor_21b' . $i_B . ''] = NULL;

                        $obj_key1 = 'This_Marriage_' . $children_length[$i] . '_Child_WILL_Resides_With';
                        $will_reside_with = $childreninfo->{$obj_key1};

                        $obj_key2 = 'This_Marriage_' . $children_length[$i] . '_Child_FirstName';

                        $obj_key3 = 'This_Marriage_' . $children_length[$i] . '_Child_Disabled_Dependent_Y_N';
                        $is_disabled_dependent = $childreninfo->{$obj_key3};

                        $child_age = Carbon::parse($childreninfo->{$obj_key})->age;

                        if ((isset($is_disabled_dependent) && $is_disabled_dependent == 'Yes') || (isset($child_age) && $child_age < '18')) {

                            if (isset($will_reside_with) && isset($client_name_array[0]) && strpos($will_reside_with, $client_name_array[0]) !== false) {
                                if (isset($will_reside_with) && isset($client_name_array[1])) {
                                    if (strpos($will_reside_with, $client_name_array[1]) !== false) {
                                        $with_parent_A = $with_parent_A + 1;
                                        $postData['obligee_21b' . $i_A . ''] = date("m/d/Y", strtotime($childreninfo->{$obj_key}));
                                        $postData['obligee_21b' . $i_A . '_child_name'] = $childreninfo->{$obj_key2};
                                        $children_name['Child_' . $b . '']['name'] = $childreninfo->{$obj_key2};
                                        $children_name['Child_' . $b . '']['parent_name'] = $client_full_name;
                                        $i_A = $i_A + 1;
                                    } else {
                                        $with_parent_A = $with_parent_A;
                                        $postData['obligee_21b' . $i_A . ''] = NULL;
                                        $postData['obligee_21b' . $i_A . '_child_name'] = NULL;
                                        $i_A = $i_A;
                                    }
                                } else {
                                    $with_parent_A = $with_parent_A + 1;
                                    $postData['obligee_21b' . $i_A . ''] = date("m/d/Y", strtotime($childreninfo->{$obj_key}));
                                    $postData['obligee_21b' . $i_A . '_child_name'] = $childreninfo->{$obj_key2};
                                    $children_name['Child_' . $b . '']['name'] = $childreninfo->{$obj_key2};
                                    $children_name['Child_' . $b . '']['parent_name'] = $client_full_name;
                                    $i_A = $i_A + 1;
                                }
                            }
                            $opponent_name_array = explode(" ", $opponent_name);
                            if (isset($will_reside_with) && isset($opponent_name_array[0]) && strpos($will_reside_with, $opponent_name_array[0]) !== false) {
                                if (isset($will_reside_with) && isset($opponent_name_array[1])) {
                                    if (strpos($will_reside_with, $opponent_name_array[1]) !== false) {
                                        $with_parent_B = $with_parent_B + 1;
                                        $postData['obligor_21b' . $i_B . ''] = date("m/d/Y", strtotime($childreninfo->{$obj_key}));
                                        $postData['obligor_21b' . $i_B . '_child_name'] = $childreninfo->{$obj_key2};
                                        $children_name['Child_' . $b . '']['name'] = $childreninfo->{$obj_key2};
                                        $children_name['Child_' . $b . '']['parent_name'] = $opponent_full_name;
                                        $i_B = $i_B + 1;
                                    } else {
                                        $with_parent_B = $with_parent_B;
                                        $postData['obligor_21b' . $i_B . ''] = NULL;
                                        $postData['obligor_21b' . $i_B . '_child_name'] = NULL;
                                        $i_B = $i_B;
                                    }
                                } else {
                                    $with_parent_B = $with_parent_B + 1;
                                    $postData['obligor_21b' . $i_B . ''] = date("m/d/Y", strtotime($childreninfo->{$obj_key}));
                                    $postData['obligor_21b' . $i_B . '_child_name'] = $childreninfo->{$obj_key2};
                                    $children_name['Child_' . $b . '']['name'] = $childreninfo->{$obj_key2};
                                    $children_name['Child_' . $b . '']['parent_name'] = $opponent_full_name;
                                    $i_B = $i_B + 1;
                                }
                            }
                        }
                    }

                    $postData['parent_a_children'] = $with_parent_A;
                    $postData['parent_b_children'] = $with_parent_B;
                    $postData['obligee_9b'] = $with_parent_A;
                    $postData['obligor_9b'] = $with_parent_B;
                }
                return view('computations.computed.split', ['sheet_custody' => $form_custody, 'sheet_state' => $request->form_state, 'case_data' => $case_data, 'chk_prefill' => '1', 'attorney_data' => $attorney_data, 'OH_Minimum_Wage' => $OH_Minimum_Wage, 'postData' => $postData, 'children_name' => $children_name]);
            }
            // }

        } else {
            if (!isset($request->form_custody)) {
                die('Case Custody is not set for this case.');
            }

            if (strtolower($form_custody) == 'split') {
                return view('computations.split', ['sheet_custody' => $form_custody, 'sheet_state' => $request->form_state, 'case_data' => $case_data, 'chk_prefill' => '1', 'attorney_data' => $attorney_data, 'OH_Minimum_Wage' => $OH_Minimum_Wage]);
            } else {
                return view('computations.sole_shared', ['sheet_custody' => $form_custody, 'sheet_state' => $request->form_state, 'case_data' => $case_data, 'chk_prefill' => '1', 'attorney_data' => $attorney_data, 'OH_Minimum_Wage' => $OH_Minimum_Wage]);
            }
        }
        // }
    }

    // to show computation sheets for cases prefilled with case data.
    public function showPrefilledFromDatabaseComputationSheet(Request $request)
    {
        $case_details = Courtcase::find($request->case_id);
        if ($case_details && $case_details->attorney_id == Auth::user()->id) {
        } else {
            return redirect()->route('cases.index');
        }

        if (isset($request->computation_sheet_version) && $request->computation_sheet_version == 'Computed from Database') {
            die('Coming Soon...');
        }

        if (!isset($request->form_custody)) {
            die('Case Custody is not set for this case.');
        }

        $form_custody = strtolower($request->form_custody);
        $user_ids_top = Caseuser::where([['case_id', $request->case_id], ['party_group', 'top']])->get()->pluck('user_id')->first();
        $user_ids_bottom = Caseuser::where([['case_id', $request->case_id], ['party_group', 'bottom']])->get()->pluck('user_id')->first();
        if ($user_ids_top) {
            $top_party_data = User::where('id', $user_ids_top)->get()->first();
        }
        if ($user_ids_bottom) {
            $bottom_party_data = User::where('id', $user_ids_bottom)->get()->first();
        }
        $attorney_data = User::find(Auth::user()->id)->attorney;
        $prefill_data = DB::table('users_attorney_submissions')
            ->where([
                ['user_id', '=', Auth::user()->id],
                ['case_id', '=', $request->case_id],
                ['form_state', '=', $request->form_state],
                ['form_custody', '=', $form_custody]
            ])
            ->orderBy('id', 'desc')
            ->limit(1)
            ->get()->pluck('form_text');


        if (isset($prefill_data[0])) {
            // $case_data['case_id']=$request->case_id;

            if (isset($top_party_data)) {
                $client_name = $top_party_data->name;
            } else {
                $client_name = '';
            }
            if (isset($bottom_party_data)) {
                $opponent_name = $bottom_party_data->name;
            } else {
                $opponent_name = '';
            }
            $case_data = array(
                'case_id' => $request->case_id,
                'client_name' => $client_name,
                'opponent_name' => $opponent_name
            );

            $postData = unserialize($prefill_data[0]);
            $ohMinimumWageData = DB::select(DB::raw("select getOHMinimumWage2018(0) AS tmpResult"));
            $OH_Minimum_Wage = $ohMinimumWageData[0]->tmpResult;
            $postData['OH_Minimum_Wage'] = $OH_Minimum_Wage;
            if ($form_custody == 'split') {
                return view('computations.split', ['sheet_custody' => $form_custody, 'sheet_state' => $request->form_state, 'chk_prefill' => '1', 'case_data' => $case_data, 'postData' => $postData,  'attorney_data' => $attorney_data]);
            } else {
                return view('computations.sole_shared', ['sheet_custody' => $form_custody, 'sheet_state' => $request->form_state, 'case_data' => $case_data, 'chk_prefill' => '1', 'postData' => $postData,  'attorney_data' => $attorney_data]);
            }
        } else {
            if (isset($top_party_data)) {
                $client_name = $top_party_data->name;
            } else {
                $client_name = '';
            }
            if (isset($bottom_party_data)) {
                $opponent_name = $bottom_party_data->name;
            } else {
                $opponent_name = '';
            }
            $case_data = array(
                'case_id' => $request->case_id,
                'client_name' => $client_name,
                'opponent_name' => $opponent_name
            );
            $ohMinimumWageData = DB::select(DB::raw("select getOHMinimumWage2018(0) AS tmpResult"));
            $OH_Minimum_Wage = $ohMinimumWageData[0]->tmpResult;
            if ($form_custody == 'split') {
                return view('computations.split', ['sheet_custody' => $form_custody, 'sheet_state' => $request->form_state, 'case_data' => $case_data, 'chk_prefill' => '1', 'attorney_data' => $attorney_data, 'OH_Minimum_Wage' => $OH_Minimum_Wage]);
            } else {
                return view('computations.sole_shared', ['sheet_custody' => $form_custody, 'sheet_state' => $request->form_state, 'case_data' => $case_data, 'chk_prefill' => '1', 'attorney_data' => $attorney_data, 'OH_Minimum_Wage' => $OH_Minimum_Wage]);
            }
        }
    }

    /* Update case party trial attroney info */
    public function updatePartyTrialAttorney(Request $request)
    {
        $court_case_data = Courtcase::find($request->case_id);
        if (isset($court_case_data) && $court_case_data->attorney_id != Auth::user()->id) {
            return redirect()->route('home');
        }

        $data = Partyattorney::where([
            ['case_id', '=', $request->case_id],
            ['party_id', '=', $request->party_id],
        ])
            ->update(['trial_attorney' => 'No']);
        $data2 = Partyattorney::where([
            ['case_id', '=', $request->case_id],
            ['party_id', '=', $request->party_id],
            ['attorney_id', '=', $request->attorney_id],
        ])
            ->update(['trial_attorney' => 'Yes']);
        return redirect()->route('cases.show_attorney_reg_form', ['party_id' => $request->party_id, 'case_id' => $request->case_id, 'party_number' => $request->party_number])->with('success', 'Attorney updated successfully.');
    }

    /* Activate/ Deactivate case party to complete interview section after case payment */
    public function activateDeactivateParty(Request $request)
    {
        $court_case_data = Courtcase::find($request->case_id);
        if (isset($court_case_data) && $court_case_data->attorney_id != Auth::user()->id) {
            return redirect()->route('home');
        }

        $case_id = $request->case_id;
        $party_id = $request->party_id;
        $active_status = $request->active_status;

        $case_party_user = Caseuser::where([['user_id', $party_id], ['case_id', $case_id], ['attorney_id', Auth::user()->id]])->get()->first();
        if (!$case_party_user) {
            return redirect()->route('cases.show_party_reg_form', $case_id)->with('error', 'Something went wrong. Please try again.');
        }
        $user = User::find($party_id);
        $user->active = $active_status;
        $user->save();

        // send email to client informing about his account activation by attorney
        $password_reset_link = route('password.request');
        $home_link = route('home');

        if ($user->active == '0') {
            // $subject='FDD Account Deactivated';
            // $content='Your account for First Draft Data is deactivated by your attorney '.Auth::user()->name.'.Now you can not login to <a class="text text-info" href="'.$home_link.'">First Draft Data</a>. Please conatct your Attorney in case you have any queries regarding deactivation of your account.';

            return redirect()->route('cases.show_party_reg_form', $case_id)->with('success', 'Party account is deactivated successfully.');
        } else {

            $subject = 'FDD Account Activated';
            $content = 'Your First Draft Data account is activated by your attorney <strong>' . Auth::user()->name . '</strong>. You can reset your account password and complete your Fam Law Interview Section. Please <a class="text text-info" href="' . $password_reset_link . '">Click Here</a> to reset your password.';
        }

        $email_from = env('MAIL_FROM_ADDRESS');
        $email_us = Mail::send(
            'emails.client-activated-deactivated',
            array(
                'name' => $user->name,
                'content' => $content,
            ),
            function ($message) use ($user, $email_from, $subject) {
                $message->from($email_from);
                $message->to($user->email, 'Admin')->subject($subject);
            }
        );

        return redirect()->route('cases.show_party_reg_form', $case_id)->with('success', 'Party account is activated successfully. We have sent an email with link to login into website and complete the fam law interview.');
    }

    // Form For upgrading the case package.
    public function getUpgradePackagePaymentForm($id)
    {
        $case_details = Courtcase::find($id);
        if ($case_details && $case_details->attorney_id == Auth::user()->id) {
        } else {
            abort('404');
        }
        $old_package_details = DB::table('case_payment_packages')
            ->where('id', $case_details->case_payment_package_id)
            ->first();
        // $old_package_price = $old_package_details->package_price;
        if ($case_details->payment_status == '0') {
            return redirect()->route('cases.index');
            die('Payment Not done for this Case.');
        }

        // if($case_details->payment_status=='1'){
        //     return redirect()->route('cases.index');
        //     die('Payment Already done for this Case.');
        // }
        // $data = CasePaymentPackage::orderBy('id','ASC')->get();

        $case_type_ids = explode(",", $case_details->case_type_ids);
        // $data = CasePaymentPackage::where('active', '1')->whereIn('id', $case_type_ids)->orderBy('id','ASC')->get();

        $raw_query = '';
        foreach ($case_type_ids as $key => $case_type_id) {
            if ($key == '0') {
                $raw_query .= "FIND_IN_SET(" . $case_type_id . ",case_type_ids)";
            } else {
                $raw_query .= " OR FIND_IN_SET(" . $case_type_id . ",case_type_ids)";
            }
        }
        $data = DB::table("case_payment_packages")
            ->select("case_payment_packages.*")
            ->whereRaw($raw_query)
            ->where('active', '1')
            ->orderBy('package_price', 'ASC')
            ->distinct()
            ->get();

        $lastKey = $data->keys()->last();

        if ($case_details->payment_status == '1' && $lastKey && $case_details->case_payment_package_id == $data[$lastKey]->id) {
            return redirect()->route('cases.index');
            die('Payment Already done for this Case.');
        }

        return view('case.upgrade_payment_package', ['old_package_details' => $old_package_details, 'case_packages' => $data, 'case_details' => $case_details, 'intent' => Auth::user()->createSetupIntent()]);
    }

    // Upgrade the case package.
    public function upgradeCasePackagePayment(Request $request)
    {
        $case_id = $request->case_id;
        $case_details = Courtcase::find($case_id);
        if ($case_details && $case_details->attorney_id == Auth::user()->id) {
        } else {
            abort('404');
        }
        $old_package_id = $case_details->case_payment_package_id;
        $old_package_details = DB::table('case_payment_packages')
            ->where('id', $old_package_id)
            ->first();
        $old_package_price = $old_package_details->package_price;
        $paymentMethod = $request->payment_method;
        $package_name = $request->package_name;
        $package_id = $request->package_id;
        $package_details = DB::table('case_payment_packages')
            ->where('id', $package_id)
            ->first();
        $new_package_price = $package_details->package_price;
        $package_price = $new_package_price - $old_package_price;
        $amount = intval($package_price * 100);
        $case_type = $request->case_type;
        $court_case = Courtcase::find($case_id);
        $client_id = DB::table('caseusers')
            ->where([['case_id', $case_id], ['type', 'client']])
            ->get()->pluck('user_id');
        //$client=User::find($client_id);
        $user = User::find(Auth::user()->id);
        if (isset($court_case->case_number) && $court_case->case_number != '') {
            $case_number = $court_case->case_number;
            $des = '';
        } else if (isset($court_case->original_case_number) && $court_case->original_case_number != '') {
            $case_number = $court_case->original_case_number;
            $des = '';
        } else {
            $case_number = $case_id;
            $des = 'RECORD ';
        }
        // $user->createAsStripeCustomer();



        $user->addPaymentMethod($paymentMethod);
        // if ($user->hasPaymentMethod()) {
        //     // $paymentMethods = $user->paymentMethods();
        //     $user->addPaymentMethod($paymentMethod);
        // } else {
        //     $user->addPaymentMethod($paymentMethod);
        // }
        // echo "<pre>"; print_r($user->paymentMethods());die;
        try {
            $payment = $user->charge($amount, $paymentMethod, [
                'metadata' => array(
                    'attorney_name' => $user->name,
                    'case_id' => $case_id,
                    'package_name' => $package_name,
                    'case_type' => $case_type
                ),
                'description' => 'CASE ' . $des . $case_number . ' PACKAGE UPGRADATION PAYMENT FOR AMOUNT $' . $package_price . ' DATED ' . date('m-d-Y') . ' BY ' . $user->name,
            ]);
            $court_case->payment_status = '1';
            $court_case->case_payment_package_id = $package_id;
            $court_case->save();

            // to update case payment transaction history
            $history = array(
                'user_id' => $user->id,
                'case_id' => $case_id,
                'case_package_id' => $package_id,
                'amount' => $package_price,
                'stripe_transaction_id' => $payment->id,
                'description' => 'CASE ' . $des . $case_number . ' PACKAGE UPGRADATION PAYMENT FOR AMOUNT $' . $package_price . ' VIA TRANSACTION ID: ' . $payment->id . ' DATED ' . date('m-d-Y') . ' BY ' . $user->name,
                'created_at' => now(),
                'updated_at' => now(),
            );
            $case_payment_transaction_history = CasePaymentTransactionHistory::create($history);

            // $email_sent=Mail::to($client[0]->email)->send(new CaseRegistered());
            return redirect()->route('cases.index')->with('success', 'Thanks! Your case package has been upgraded successfully.');
        } catch (Exception $e) {
            // return redirect()->back()->with('error', ['Something went Wrong. Please try again.']);   
            return redirect()->route('cases.index')->with('error', 'Something went wrong. Please try again.');
        }
    }

    /* Show update case party attorney info form */
    public function getUpdatePartyAttorneyForm($party_id, $case_id, $attorney_id, $party_number)
    {
        $court_case_data = Courtcase::find($case_id);
        if (isset($court_case_data) && $court_case_data->attorney_id != Auth::user()->id) {
            return redirect()->route('home');
        }
        $attorney = User::find($attorney_id);
        $attorney_data = User::find($attorney_id)->attorney;
        if ($attorney_data) {
            $attorney_active_data = DB::table('attorney_table_active')
                ->where([['registrationnumber', $attorney_data->attorney_reg_1_num], ['registration_state_id', $attorney_data->attorney_reg_1_state_id]])
                // ->orWhere('registrationnumber_state1', $attorney_data->attorney_reg_1_num)
                ->get()->first();
        } else {
            $attorney_active_data = NULL;
        }
        return view('case.edit_attorney', ['attorney' => $attorney, 'attorney_data' => $attorney_data, 'attorney_active_data' => $attorney_active_data, 'party_id' => $party_id, 'case_id' => $case_id, 'party_number' => $party_number]);
    }

    /* update case party attorney info */
    public function updateAttorney(Request $request)
    {
        $court_case_data = Courtcase::find($request->case_id);
        if (isset($court_case_data) && $court_case_data->attorney_id != Auth::user()->id) {
            return redirect()->route('home');
        }

        $attorney_id = $request->attorney_id;
        $party_id = $request->party_id;
        $case_id = $request->case_id;
        $party_number = $request->party_number;
        // dd($request->all());
        if (!isset($request->email) || $request->email == '') {
            $username = 'unknown_' . $request->case_id . '_' . Carbon::now()->timestamp . '@firstdraftdata.com';
            $email = 'unknown_' . $request->case_id . '_' . Carbon::now()->timestamp . '@firstdraftdata.com';
        } else {
            $username = $request->email;
            $email = $request->email;
        }
        $fname = $request->fname;
        $mname = $request->mname;
        $lname = $request->lname;
        $document_sign_name = $request->document_sign_name;
        $special_practice = $request->special_practice;
        $firm_name = $request->firm_name;
        $firm_street_address = $request->firm_street_address;
        $firm_suite_unit_mailcode = $request->firm_suite_unit_mailcode;
        $po_box = $request->po_box;
        $firm_city = $request->firm_city;
        $firm_state = $request->firm_state;
        $firm_county = $request->firm_county;
        $firm_zipcode = $request->firm_zipcode;
        $firm_telephone = $request->firm_telephone;
        $firm_fax = $request->firm_fax;
        $attorney_reg_1_state_id = $request->attorney_reg_1_state_id;
        // $attorney_reg_2_state_id=$request->attorney_reg_2_state_id;
        // $attorney_reg_3_state_id=$request->attorney_reg_3_state_id;
        $attorney_reg_1_num = $request->attorney_reg_1_num;
        // $attorney_reg_2_num=$request->attorney_reg_2_num;
        // $attorney_reg_3_num=$request->attorney_reg_3_num;

        if (isset($request->pro_hac_vice) && $request->pro_hac_vice == 'yes' && isset($request->pro_vice_hac_num) && $request->pro_vice_hac_num != '') {
            $pro_vice_hac_num = $request->pro_vice_hac_num;
        } else {
            $pro_vice_hac_num = NULL;
        }

        if ($special_practice == 'court') {
            $special_practice_text = $request->court_text;
        } else if ($special_practice == 'law_school') {

            $special_practice_text = $request->law_school_text;;
        } else if ($special_practice == 'legal_aid') {

            $special_practice_text = $request->legal_aid_text;
        } else {

            $special_practice_text = 'Nill';
        }

        $attorney_state = State::where('id', $firm_state)->get()->first();
        $attorney_reg_state = State::where('id', $attorney_reg_1_state_id)->get()->first();
        $attorney_county = County::where('id', $firm_county)->get()->first();
        $checkemail = User::where('email', $email)->first();
        if ($checkemail) {
        } else {
            $user = User::find($attorney_id);
            $user->email = $email;
            $user->username = $username;
            $user->name = $fname . ' ' . $lname;
            $user->updated_at = now();
            $user->save();
        }

        $attorney_user = User::find($attorney_id)->attorney;
        $attorney_user->mname = $mname;
        $attorney_user->document_sign_name = $document_sign_name;
        $attorney_user->special_practice = $special_practice;
        $attorney_user->special_practice_text = $special_practice_text;
        $attorney_user->firm_name = $firm_name;
        $attorney_user->firm_street_address = $firm_street_address;
        $attorney_user->firm_suite_unit_mailcode = $firm_suite_unit_mailcode;
        $attorney_user->po_box = $po_box;
        $attorney_user->firm_city = $firm_city;
        $attorney_user->state_id = $firm_state;
        $attorney_user->county_id = $firm_county;
        $attorney_user->firm_zipcode = $firm_zipcode;
        $attorney_user->firm_telephone = $firm_telephone;
        $attorney_user->firm_fax = $firm_fax;
        $attorney_user->attorney_reg_1_state_id = $attorney_reg_1_state_id;
        // $attorney_user->attorney_reg_2_state_id=$attorney_reg_2_state_id;
        // $attorney_user->attorney_reg_3_state_id=$attorney_reg_3_state_id;
        $attorney_user->attorney_reg_1_num = $attorney_reg_1_num;
        // $attorney_user->attorney_reg_2_num=$attorney_reg_2_num;
        // $attorney_user->attorney_reg_3_num=$attorney_reg_3_num;
        $attorney_user->pro_vice_hac_num = $pro_vice_hac_num;
        $attorney_user->updated_at = now();


        $attorney_user->fname = $request->fname;
        $attorney_user->lname = $request->lname;
        $attorney_user->sufname = $request->sufname;
        $attorney_user->currentstatus = $request->currentstatus;
        $attorney_user->gender = $request->gender;
        $attorney_user->attorneytitle = $request->attorneytitle;
        $attorney_user->insured = $request->insured;
        $attorney_user->admissiondate = date("Y-m-d", strtotime($request->admissiondate));
        $attorney_user->admissiondatevalue = date("Ymd", strtotime($request->admissiondate));
        $attorney_user->howadmitted = $request->howadmitted;
        $attorney_user->birthdate = date("Y-m-d", strtotime($request->birthdate));
        $attorney_user->birthdatevalue = date("Ymd", strtotime($request->birthdate));
        $attorney_user->firm_tagline = $request->firm_tagline;
        $attorney_user->firm_state = $attorney_state->state;
        $attorney_user->firm_state_abr = $attorney_state->state_abbreviation;
        $attorney_user->email = $request->email;
        $attorney_user->firm_county = $attorney_county->county_name;
        $attorney_user->registration_state_1 = $attorney_reg_state->state;

        $attorney_user->save();

        // to backup old attorney data before updating in attorney table active
        if (isset($request->update_source_data) && $request->update_source_data == 'Yes') {
            $attorney_active_data_old = DB::table('attorney_table_active')
                ->where([['registrationnumber', $request->attorney_reg_1_num], ['registration_state_id', $request->attorney_reg_1_state_id]])
                ->get()->first();
            if ($attorney_active_data_old) {
                unset($attorney_active_data_old->id);
                $attorney_active_data_old = (array) $attorney_active_data_old;
                AttorneyTableActiveBeforeEdit::create($attorney_active_data_old);
            }

            //  to update attorney table active
            // $attorney_state=State::where('id',$firm_state)->get()->first();
            // $attorney_county=County::where('id',$firm_county)->get()->first();
            $last_update = date('Y-m-d');
            $lastupdatevalue = date('Ymd');
            if (isset($request->gender) && $request->gender != '') {
                $gender = $request->gender;
            } else {
                $gender = 'N';
            }
            if (isset($request->insured) && $request->insured != '') {
                $insured = $request->insured;
            } else {
                $insured = NULL;
            }
            $data['fname'] = $fname;
            $data['mname'] = $mname;
            $data['lname'] = $lname;
            $data['sufname'] = $request->sufname;
            $data['document_sign_name'] = $document_sign_name;
            $data['gender'] = $gender;
            $data['attorneytitle'] = $request->attorneytitle;
            $data['insured'] = $insured;
            $data['firm_zip'] = $firm_zipcode;
            $data['firm_name'] = $firm_name;
            $data['firm_tagline'] = $request->firm_tagline;
            $data['firm_street_address'] = $firm_street_address;
            $data['firm_suite_unit_mailcode'] = $firm_suite_unit_mailcode;
            $data['po_box'] = $po_box;
            $data['firm_city'] = $firm_city;
            $data['firm_state'] = $attorney_state->state;
            $data['firm_state_abr'] = $attorney_state->state_abbreviation;
            $data['firm_telephone'] = $firm_telephone;
            $data['firm_fax'] = $firm_fax;
            // $data['email']=$request;
            $data['lawschool'] = $request->law_school_text;
            $data['firm_county'] = $attorney_county->county_name;
            $data['county_id'] = $firm_county;
            $data['last_update'] = $last_update;
            $data['last_updatevalue'] = $lastupdatevalue;
            $data['last_edited_by'] = Auth::user()->name;

            $data['admissiondate'] = date("Y-m-d", strtotime($request->admissiondate));
            $data['admissiondatevalue'] = date("Ymd", strtotime($request->admissiondate));
            $data['howadmitted'] = $request->howadmitted;
            $data['birthdate'] = date("Y-m-d", strtotime($request->birthdate));
            $data['birthdatevalue'] = date("Ymd", strtotime($request->birthdate));
            $data['registration_state'] = $attorney_reg_state->state;
            $data['currentstatus'] = $request->currentstatus;
            // dd($data);
            $attorney_active_data = DB::table('attorney_table_active')
                ->where([['registrationnumber', $request->attorney_reg_1_num], ['registration_state_id', $request->attorney_reg_1_state_id]])
                // ->orWhere('registrationnumber_state1', $request->attorney_reg_1_num)
                ->update($data);
        }


        // ----------fololowing code is to update case party attorney info table-------------//
        $attorney_ids = Partyattorney::where([['party_id', $party_id], ['case_id', $case_id]])->get()->all();
        $party_group = Caseuser::where([['case_id', $case_id], ['user_id', $party_id]])->get()->pluck('party_group')->first();
        if ($party_group == 'top' || $party_group == 'bottom') {
            $attorney = array('case_id' => $case_id);
            $party_num = $party_number;
            $num = 0;
            $totalattornies = count($attorney_ids);
            foreach ($attorney_ids as $user_id) {
                $attorneyname = User::where('id', $user_id->attorney_id)->get()->first();
                $party_attorney = DB::table('attorneys')
                    ->join('states', 'attorneys.state_id', '=', 'states.id')
                    ->join('counties', [['attorneys.county_id', '=', 'counties.id'], ['attorneys.state_id', '=', 'counties.state_id']])
                    ->where('user_id', $user_id->attorney_id)
                    ->select('attorneys.*', 'states.state', 'counties.id', 'counties.county_name')
                    ->get()->first();
                $caseattytitle = 'Co-Counsel';
                if (count($attorney_ids) == 1 && $user_id->trial_attorney == 'Yes') {
                    $caseattytitle = 'Trial Attorney and Counsel';
                }
                if (count($attorney_ids) > 1 && $user_id->trial_attorney == 'Yes') {
                    $caseattytitle = 'Trial Attorney and Co-Counsel';
                }
                $num++;
                $attorney['' . $party_group . 'party' . $party_num . '_attorney' . $num . '_user_id'] = $user_id->attorney_id;
                $attorney['' . $party_group . 'party' . $party_num . '_attorney' . $num . '_name'] = $attorneyname->name;
                $attorney['' . $party_group . 'party' . $party_num . '_attorney' . $num . '_email'] = $attorneyname->email;
                $attorney['' . $party_group . 'party' . $party_num . '_attorney' . $num . '_document_sign_name'] = $party_attorney->document_sign_name;
                $attorney['' . $party_group . 'party' . $party_num . '_attorney' . $num . '_special_practice'] = $party_attorney->special_practice;
                $attorney['' . $party_group . 'party' . $party_num . '_attorney' . $num . '_special_practice_text'] = $party_attorney->special_practice_text;
                $attorney['' . $party_group . 'party' . $party_num . '_attorney' . $num . '_firm_name'] = $party_attorney->firm_name;
                $attorney['' . $party_group . 'party' . $party_num . '_attorney' . $num . '_firm_street_address'] = $party_attorney->firm_street_address;
                $attorney['' . $party_group . 'party' . $party_num . '_attorney' . $num . '_firm_suite_unit_mailcode'] = $party_attorney->firm_suite_unit_mailcode;
                $attorney['' . $party_group . 'party' . $party_num . '_attorney' . $num . '_po_box'] = $party_attorney->po_box;
                $attorney['' . $party_group . 'party' . $party_num . '_attorney' . $num . '_firm_city'] = $party_attorney->firm_city;
                $attorney['' . $party_group . 'party' . $party_num . '_attorney' . $num . '_firm_state'] = $party_attorney->state;
                $attorney['' . $party_group . 'party' . $party_num . '_attorney' . $num . '_firm_county'] = $party_attorney->county_name;
                $attorney['' . $party_group . 'party' . $party_num . '_attorney' . $num . '_firm_zipcode'] = $party_attorney->firm_zipcode;
                $attorney['' . $party_group . 'party' . $party_num . '_attorney' . $num . '_firm_telephone'] = $party_attorney->firm_telephone;
                $attorney['' . $party_group . 'party' . $party_num . '_attorney' . $num . '_firm_fax'] = $party_attorney->firm_fax;
                $attorney['' . $party_group . 'party' . $party_num . '_attorney' . $num . '_reg_1_num'] = $party_attorney->attorney_reg_1_num;
                $attorney['' . $party_group . 'party' . $party_num . '_attorney' . $num . '_trial_attorney'] = $user_id->trial_attorney;
                $attorney['' . $party_group . 'party' . $party_num . '_attorney' . $num . '_customer_attorney'] = $user_id->customer_attorney;
                $attorney['' . $party_group . 'party' . $party_num . '_attorney' . $num . '_caseattytitle'] = $caseattytitle;
            }
            $limit = $num + 1;
            for ($j = $limit; $j <= 3; $j++) {
                $attorney['' . $party_group . 'party' . $party_num . '_attorney' . $j . '_user_id'] = NULL;
                $attorney['' . $party_group . 'party' . $party_num . '_attorney' . $j . '_name'] = NULL;
                $attorney['' . $party_group . 'party' . $party_num . '_attorney' . $j . '_email'] = NULL;
                $attorney['' . $party_group . 'party' . $party_num . '_attorney' . $j . '_document_sign_name'] = NULL;
                $attorney['' . $party_group . 'party' . $party_num . '_attorney' . $j . '_special_practice'] = NULL;
                $attorney['' . $party_group . 'party' . $party_num . '_attorney' . $j . '_special_practice_text'] = NULL;
                $attorney['' . $party_group . 'party' . $party_num . '_attorney' . $j . '_firm_name'] = NULL;
                $attorney['' . $party_group . 'party' . $party_num . '_attorney' . $j . '_firm_street_address'] = NULL;
                $attorney['' . $party_group . 'party' . $party_num . '_attorney' . $j . '_firm_suite_unit_mailcode'] = NULL;
                $attorney['' . $party_group . 'party' . $party_num . '_attorney' . $j . '_po_box'] = NULL;
                $attorney['' . $party_group . 'party' . $party_num . '_attorney' . $j . '_firm_city'] = NULL;
                $attorney['' . $party_group . 'party' . $party_num . '_attorney' . $j . '_firm_state'] = NULL;
                $attorney['' . $party_group . 'party' . $party_num . '_attorney' . $j . '_firm_county'] = NULL;
                $attorney['' . $party_group . 'party' . $party_num . '_attorney' . $j . '_firm_zipcode'] = NULL;
                $attorney['' . $party_group . 'party' . $party_num . '_attorney' . $j . '_firm_telephone'] = NULL;
                $attorney['' . $party_group . 'party' . $party_num . '_attorney' . $j . '_firm_fax'] = NULL;
                $attorney['' . $party_group . 'party' . $party_num . '_attorney' . $j . '_reg_1_num'] = NULL;
                $attorney['' . $party_group . 'party' . $party_num . '_attorney' . $j . '_trial_attorney'] = NULL;
                $attorney['' . $party_group . 'party' . $party_num . '_attorney' . $j . '_customer_attorney'] = NULL;
                $attorney['' . $party_group . 'party' . $party_num . '_attorney' . $j . '_caseattytitle'] = NULL;
            }
            $partytypeattorneyinfoprev = CasePartyAttorneyInfo::where('case_id', $case_id)->get()->first();
            if ($partytypeattorneyinfoprev) {
                $partytypeattorneyinfo = $partytypeattorneyinfoprev->fill($attorney)->save();
            } else {
                $partytypeattorneyinfo = CasePartyAttorneyInfo::create($attorney);
            }
            $totalpartyattorney = array('' . $party_group . 'party' . $party_num . '_num_attys' => $num);
            $partytypeinfoprev = CasePartyInfo::where('case_id', $case_id)->get()->first();
            if ($partytypeinfoprev) {
                $partytypeinfo = $partytypeinfoprev->fill($totalpartyattorney)->save();
            }
        }
        // for third parties
        if ($party_group == 'top_third' || $party_group == 'bottom_third') {
            $attorney = array('case_id' => $case_id);
            $party_num = $party_number;
            $num = 0;
            $totalattornies = count($attorney_ids);
            foreach ($attorney_ids as $user_id) {
                $attorneyname = User::where('id', $user_id->attorney_id)->get()->first();
                $party_attorney = DB::table('attorneys')
                    ->join('states', 'attorneys.state_id', '=', 'states.id')
                    ->join('counties', [['attorneys.county_id', '=', 'counties.id'], ['attorneys.state_id', '=', 'counties.state_id']])
                    ->where('user_id', $user_id->attorney_id)
                    ->select('attorneys.*', 'states.state', 'counties.id', 'counties.county_name')
                    ->get()->first();
                $caseattytitle = 'Co-Counsel';
                if (count($attorney_ids) == 1 && $user_id->trial_attorney == 'Yes') {
                    $caseattytitle = 'Trial Attorney and Counsel';
                }
                if (count($attorney_ids) > 1 && $user_id->trial_attorney == 'Yes') {
                    $caseattytitle = 'Trial Attorney and Co-Counsel';
                }
                $num++;
                $attorney['' . $party_group . 'party' . $party_num . '_attorney' . $num . '_user_id'] = $user_id->attorney_id;
                $attorney['' . $party_group . 'party' . $party_num . '_attorney' . $num . '_name'] = $attorneyname->name;
                $attorney['' . $party_group . 'party' . $party_num . '_attorney' . $num . '_email'] = $attorneyname->email;
                $attorney['' . $party_group . 'party' . $party_num . '_attorney' . $num . '_document_sign_name'] = $party_attorney->document_sign_name;
                $attorney['' . $party_group . 'party' . $party_num . '_attorney' . $num . '_special_practice'] = $party_attorney->special_practice;
                $attorney['' . $party_group . 'party' . $party_num . '_attorney' . $num . '_special_practice_text'] = $party_attorney->special_practice_text;
                $attorney['' . $party_group . 'party' . $party_num . '_attorney' . $num . '_firm_name'] = $party_attorney->firm_name;
                $attorney['' . $party_group . 'party' . $party_num . '_attorney' . $num . '_firm_street_address'] = $party_attorney->firm_street_address;
                $attorney['' . $party_group . 'party' . $party_num . '_attorney' . $num . '_firm_suite_unit_mailcode'] = $party_attorney->firm_suite_unit_mailcode;
                $attorney['' . $party_group . 'party' . $party_num . '_attorney' . $num . '_po_box'] = $party_attorney->po_box;
                $attorney['' . $party_group . 'party' . $party_num . '_attorney' . $num . '_firm_city'] = $party_attorney->firm_city;
                $attorney['' . $party_group . 'party' . $party_num . '_attorney' . $num . '_firm_state'] = $party_attorney->state;
                $attorney['' . $party_group . 'party' . $party_num . '_attorney' . $num . '_firm_county'] = $party_attorney->county_name;
                $attorney['' . $party_group . 'party' . $party_num . '_attorney' . $num . '_firm_zipcode'] = $party_attorney->firm_zipcode;
                $attorney['' . $party_group . 'party' . $party_num . '_attorney' . $num . '_firm_telephone'] = $party_attorney->firm_telephone;
                $attorney['' . $party_group . 'party' . $party_num . '_attorney' . $num . '_firm_fax'] = $party_attorney->firm_fax;
                $attorney['' . $party_group . 'party' . $party_num . '_attorney' . $num . '_reg_1_num'] = $party_attorney->attorney_reg_1_num;
                $attorney['' . $party_group . 'party' . $party_num . '_attorney' . $num . '_trial_attorney'] = $user_id->trial_attorney;
                $attorney['' . $party_group . 'party' . $party_num . '_attorney' . $num . '_customer_attorney'] = $user_id->customer_attorney;
                $attorney['' . $party_group . 'party' . $party_num . '_attorney' . $num . '_caseattytitle'] = $caseattytitle;
            }
            $limit = $num + 1;
            for ($j = $limit; $j <= 3; $j++) {
                $attorney['' . $party_group . 'party' . $party_num . '_attorney' . $j . '_user_id'] = NULL;
                $attorney['' . $party_group . 'party' . $party_num . '_attorney' . $j . '_name'] = NULL;
                $attorney['' . $party_group . 'party' . $party_num . '_attorney' . $j . '_email'] = NULL;
                $attorney['' . $party_group . 'party' . $party_num . '_attorney' . $j . '_document_sign_name'] = NULL;
                $attorney['' . $party_group . 'party' . $party_num . '_attorney' . $j . '_special_practice'] = NULL;
                $attorney['' . $party_group . 'party' . $party_num . '_attorney' . $j . '_special_practice_text'] = NULL;
                $attorney['' . $party_group . 'party' . $party_num . '_attorney' . $j . '_firm_name'] = NULL;
                $attorney['' . $party_group . 'party' . $party_num . '_attorney' . $j . '_firm_street_address'] = NULL;
                $attorney['' . $party_group . 'party' . $party_num . '_attorney' . $j . '_firm_suite_unit_mailcode'] = NULL;
                $attorney['' . $party_group . 'party' . $party_num . '_attorney' . $j . '_po_box'] = NULL;
                $attorney['' . $party_group . 'party' . $party_num . '_attorney' . $j . '_firm_city'] = NULL;
                $attorney['' . $party_group . 'party' . $party_num . '_attorney' . $j . '_firm_state'] = NULL;
                $attorney['' . $party_group . 'party' . $party_num . '_attorney' . $j . '_firm_county'] = NULL;
                $attorney['' . $party_group . 'party' . $party_num . '_attorney' . $j . '_firm_zipcode'] = NULL;
                $attorney['' . $party_group . 'party' . $party_num . '_attorney' . $j . '_firm_telephone'] = NULL;
                $attorney['' . $party_group . 'party' . $party_num . '_attorney' . $j . '_firm_fax'] = NULL;
                $attorney['' . $party_group . 'party' . $party_num . '_attorney' . $j . '_reg_1_num'] = NULL;
                $attorney['' . $party_group . 'party' . $party_num . '_attorney' . $j . '_trial_attorney'] = NULL;
                $attorney['' . $party_group . 'party' . $party_num . '_attorney' . $j . '_customer_attorney'] = NULL;
                $attorney['' . $party_group . 'party' . $party_num . '_attorney' . $j . '_caseattytitle'] = NULL;
            }
            $partytypeattorneyinfoprev = CaseThirdPartyAttorneyInfo::where('case_id', $case_id)->get()->first();
            if ($partytypeattorneyinfoprev) {
                $partytypeattorneyinfo = $partytypeattorneyinfoprev->fill($attorney)->save();
            } else {
                $partytypeattorneyinfo = CaseThirdPartyAttorneyInfo::create($attorney);
            }
            $totalpartyattorney = array('' . $party_group . 'party' . $party_num . '_num_attys' => $num);
            $partytypeinfoprev = CasePartyInfo::where('case_id', $case_id)->get()->first(); 
            if ($partytypeinfoprev) {
                $partytypeinfo = $partytypeinfoprev->fill($totalpartyattorney)->save();
            }
        }
        // end for third parties
        // ----------end fololowing code is to update case party attorney info table-------------//

        return redirect()->route('cases.show_update_party_attorney_form', ['party_id' => $party_id, 'case_id' => $case_id, 'attorney_id' => $attorney_id, 'party_number' => $party_number])->with('success', 'Attorney info updated successfully.');
    }

    // show all cases list to super admin
    public function allCasesList()
    {
        // $data = DB::table('courtcases')->join('users', 'courtcases.attorney_id', '=', 'users.id')->select('courtcases.*','users.name')->orderBy('id','DESC')->paginate(50);
        $data = DB::table('courtcases')->join('users', 'courtcases.attorney_id', '=', 'users.id')->select('courtcases.*', 'users.name')->orderBy('id', 'DESC')->get();
        return view('admin.courtcases.index', compact('data'));
    }

    public function changeCasePaymentStatus(Request $request, $id)
    {
        $payment_status = $request->payment_status;
        $courtcase = Courtcase::find($id);
        $courtcase->payment_status = $payment_status;
        $courtcase->save();

        return redirect()->route('cases.all')

            ->with('success', 'Case info updated successfully');
    }

    public function deactivateCase($id)
    {
        die('invalid');
        $courtcase = Courtcase::find($id);
        $courtcase->deactivated_at = now();
        $courtcase->save();
    }

    public function activateCase($id)
    {
        die('invalid');
        $courtcase = Courtcase::find($id);
        $courtcase->deactivated_at = NULL;
        $courtcase->save();
    }

    /**

     * Remove the specified resource from storage.

     *

     * @param  int  $id

     * @return \Illuminate\Http\Response

     */

    public function destroy($id)

    {
        $case_data = Courtcase::find($id);
        if (isset($case_data) && $case_data->attorney_id == Auth::user()->id) {

            Courtcase::find($id)->delete();

            return redirect()->route('cases.index')

                ->with('success', 'Case deleted successfully');
        } else {
            return redirect()->route('cases.index')

                ->with('error', 'Case not found');
        }
    }

    public function showHideCase(Request $request, $id)
    {
        $courtcase = Courtcase::find($id);
        if (isset($request->show_hide)) {
            if ($request->show_hide == 'hide') {
                $courtcase->hidden_at = now();
                $courtcase->save();
            } else if ($request->show_hide == 'show') {
                $courtcase->hidden_at = NULL;
                $courtcase->save();
            } else {
                return redirect()->route('cases.index')
                    ->with('error', 'Something went wrong.');
            }
        } else {
            return redirect()->route('cases.index')
                ->with('error', 'Something went wrong.');
        }
        return redirect()->route('cases.index')
            ->with('success', 'Case info updated successfully');
    }
}
