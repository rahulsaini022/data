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
use App\DrVehicles;
use App\DrRealEstate;
use App\DrFundsOnDeposit;
use App\DrStocksInvestments;
use App\DrRetirementAccts;
use App\DrPension;
use App\DrPersonalInfo;
use App\DrChildren;
use App\DrCaseOverview;

class DrCaseOverviewController extends Controller
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
        // $data=DrIncome::orderBy('id','DESC')->get();
        // echo "<pre>";print_r($data);die;
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

        // $drincome=DrIncome::where('case_id',$case_id)->get()->pluck('case_id');
        // if(isset($drincome['0'])){
        //     return redirect()->route('home');
        // }
        $realestate=DrRealEstate::where('case_id',$case_id)->get()->first();
        if(isset($realestate)){
        } else {
            // return redirect()->route('cases.family_law_interview_tabs',$case_id)->with('error', 'Complete Real Estate Info Section First.');
        }
        $pension=DrPension::where('case_id',$case_id)->get()->first();
        if(isset($pension)){
        } else {
            // return redirect()->route('cases.family_law_interview_tabs',$case_id)->with('error', 'Complete Pension Info Section First.');
        }
        $retirementaccounts=DrRetirementAccts::where('case_id',$case_id)->get()->first();
        if(isset($retirementaccounts)){
        } else {
            // return redirect()->route('cases.family_law_interview_tabs',$case_id)->with('error', 'Complete Retirement Accounts Info Section First.');
        }
        $stockinvestment=DrStocksInvestments::where('case_id',$case_id)->get()->first();
        if(isset($stockinvestment)){
        } else {
            // return redirect()->route('cases.family_law_interview_tabs',$case_id)->with('error', 'Complete Stock Investment Info Section First.');
        }
        $fundsondeposit=DrFundsOnDeposit::where('case_id',$case_id)->get()->first();
        if(isset($fundsondeposit)){
        } else {
            // return redirect()->route('cases.family_law_interview_tabs',$case_id)->with('error', 'Complete Funds on Deposit Info Section First.');
        }
        $personalinfo=DrPersonalInfo::where('case_id',$case_id)->get()->first();
        if(isset($personalinfo)){
        } else {
            // return redirect()->route('cases.family_law_interview_tabs',$case_id)->with('error', 'Complete Personal Info Section First.');
        }
        $vehiclesinfo=DrVehicles::where('case_id',$case_id)->get()->first();
        if(isset($vehiclesinfo)){
        } else {
            // return redirect()->route('cases.family_law_interview_tabs',$case_id)->with('error', 'Complete Vehicles Info Section First.');
        }
        $childrensinfo=DrChildren::where('case_id',$case_id)->get()->first();
        if(isset($childrensinfo)){
        } else {
            // return redirect()->route('cases.family_law_interview_tabs',$case_id)->with('error', 'Complete Children Info Section First.');
        }

        $data=array(
            'realestateinfo' => $realestate,
            'pensioninfo' => $pension,
            'retirementaccountsinfo' => $retirementaccounts,
            'stockinvestmentinfo' => $stockinvestment,
            'fundsondepositinfo' => $fundsondeposit,
            'personalinfo' => $personalinfo,
            'vehiclesinfo' => $vehiclesinfo,
            'childrensinfo' => $childrensinfo,
        );

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
         $courtcase = DB::table('courtcases')->where('id',$case_id)->first();
        $case_typeids = $courtcase->case_type_ids;
        $case_typeids = explode(',',$case_typeids);
        $case_type = DB::table('case_types')->whereIn('id',$case_typeids)->get();
        $child = 1;
        foreach($case_type as $k=>$v){
            if($v == 'Divorce Without Children Of This Marriage'){
                $child = 0;
            }

            if($v == "Dissolution Without Children Of This Marriage"){
                $child = 0;
            }

            if($v == "Legal Separation Without Children Of This Marriage"){
                $child = 0;
            }
            if($v == "Annulment without children"){
                $child = 0;
            }
        }
        return view('dr_tables.dr_Case_Overview.create',['client_name'=>$client_name, 'opponent_name'=>$opponent_name, 'case_data' => $case_data, 'data' => $data,'child'=>$child]);
    }

    // save tab info in database table.
    public function store(Request $request)
    {
        $result = $request->except('submit');

        // personal info section
        if(isset($result['Client_Info_Active_Military']) && $result['Client_Info_Active_Military']=='1'){
            if(isset($result['SCRA_Prevents_Client']) && $result['SCRA_Prevents_Client']=='1'){
                if(isset($result['Client_Waive_SCRA_Rights']) && $result['Client_Waive_SCRA_Rights']=='1'){
                } else {
                    $result['Client_Waive_SCRA_Rights']='0';
                }
                $result['Client_Possible_SCRA_Issues']='1';
            } else {
                $result['Client_Possible_SCRA_Issues']='0';
                $result['SCRA_Prevents_Client']='0';
            }
        } else {
            $result['Client_Info_Active_Military']='0';
            $result['Client_Branch']=NULL;
            $result['SCRA_Prevents_Client']='0';
            $result['Client_Waive_SCRA_Rights']='0';
            $result['Client_Possible_SCRA_Issues']='0';
        }

        if(isset($result['Op_Info_Active_Military']) && $result['Op_Info_Active_Military']=='1'){
            if(isset($result['SCRA_Prevents_Op']) && $result['SCRA_Prevents_Op']=='1'){
                if(isset($result['Op_Waive_SCRA_Rights']) && $result['Op_Waive_SCRA_Rights']=='1'){
                } else {
                    $result['Op_Waive_SCRA_Rights']='0';
                }
                $result['Op_Possible_SCRA_Issues']='1';
            } else {
                $result['Op_Possible_SCRA_Issues']='0';
                $result['SCRA_Prevents_Op']='0';
            }
        } else {
            $result['Op_Info_Active_Military']='0';
            $result['Op_Branch']=NULL;
            $result['SCRA_Prevents_Op']='0';
            $result['Op_Waive_SCRA_Rights']='0';
            $result['Op_Possible_SCRA_Issues']='0';
        }

        // vehicles info section
        if(isset($result['Any_Vehicles']) && $result['Any_Vehicles']=='1'){
        } else {
            $result['Num_Joint_Vehicles']=0;
            $result['Num_Client_Vehicles']=0;
            $result['Num_Op_Vehicles']=0;
        }

        // Real Estate info section
        if(isset($result['Any_Real_Estate']) && $result['Any_Real_Estate']=='1'){
        } else {
            $result['Num_Joint_Real_Estate_Properties']=0;
            $result['Num_Client_Real_Estate_Properties']=0;
            $result['Num_Op_Real_Estate_Properties']=0;
        }

        // Stock Investment info section
        if(isset($result['Any_Stocks_Investments_Accounts']) && $result['Any_Stocks_Investments_Accounts']=='1'){
        } else {
            $result['Num_Joint_StocksInvestments_Accounts']=0;
            $result['Num_Client_StockInvestments_Accounts']=0;
            $result['Num_Op_StockInvestments_Accounts']=0;
        }
        
        // Funds On Deposit info section
        if(isset($result['Any_FOD']) && $result['Any_FOD']=='1'){
        } else {
            $result['Num_Joint_Deposit_Accounts']=0;
            $result['Num_Client_Deposit_Accounts']=0;
            $result['Num_Op_Deposit_Accounts']=0;
        }

        // Pensions info section
        if(isset($result['Any_Pension']) && $result['Any_Pension']=='1'){
        } else {
            $result['Any_Pension']='0';
            $result['Num_Client_Pensions']=0;
            $result['Num_Op_Pensions']=0;
        }

        // Retirement Accounts info section
        if(isset($result['Any_Retirement_Accts']) && $result['Any_Retirement_Accts']=='1'){
        } else {
            $result['Any_Retirement_Accts']='0';
            $result['Num_Client_Retirement_Accts']=0;
            $result['Num_Op_Retirement_Accts']=0;
        }

        $result['Num_Children_This_Marriage'] = $result['Num_Children_Born_ONLY_These_Parties_Before_Marriage'] + $result['Num_Children_ONLY_This_Marriage'];

        // echo "<pre>";print_r($result);die;
        $drcaseoverview=DrCaseOverview::create($result);
        
        return redirect()->route('cases.family_law_interview_tabs',$result['case_id'])->with('success', 'Case Overview Information Submitted Successfully.');
        
    }

    public function show($id)
    {

    }

    public function edit($case_id)
    {
        // $case_attorney=Courtcase::where([['id', $case_id],['attorney_id', Auth::user()->id]])->pluck('attorney_id');
        // if(isset($case_attorney['0'])){
        // } else {
        //     return redirect()->route('home');
        // }
        $user_role=Auth::user()->roles->first()->name;
        if($user_role=='client'){
            $client_attorney = Caseuser::where([['case_id', $case_id],['user_id', Auth::user()->id]])->get()->pluck('attorney_id')->first();
            if($client_attorney){
                // $case_info=Courtcase::where([['id', $case_id],['attorney_id', $client_attorney]])->first();
                $case_attorney=Courtcase::where([['id', $case_id],['attorney_id', $client_attorney]])->pluck('attorney_id');
                if(isset($case_attorney['0'])){
                } else {
                    return redirect()->route('home');
                }
            } else {
                return redirect()->route('client.cases');
            }
        } else {
            $case_attorney=Courtcase::where([['id', $case_id],['attorney_id', Auth::user()->id]])->pluck('attorney_id');
            if(isset($case_attorney['0'])){
            } else {
                return redirect()->route('home');
            }
        }

        $drcaseoverview=DrCaseOverview::where('case_id',$case_id)->get()->first();
         // echo "<pre>";print_r($drrealestate);//die;
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
        // $drincome=DrIncome::where('case_id',$case_id)->get()->pluck('case_id');
        // if(isset($drincome['0'])){
        //     return redirect()->route('home');
        // }
        // $realestate=DrRealEstate::where('case_id',$case_id)->get()->first();
        // if(isset($realestate)){
        // } else {
        //     // return redirect()->route('cases.family_law_interview_tabs',$case_id)->with('error', 'Complete Real Estate Info Section First.');
        // }
        // $pension=DrPension::where('case_id',$case_id)->get()->first();
        // if(isset($pension)){
        // } else {
        //     // return redirect()->route('cases.family_law_interview_tabs',$case_id)->with('error', 'Complete Pension Info Section First.');
        // }
        // $retirementaccounts=DrRetirementAccts::where('case_id',$case_id)->get()->first();
        // if(isset($retirementaccounts)){
        // } else {
        //     // return redirect()->route('cases.family_law_interview_tabs',$case_id)->with('error', 'Complete Retirement Accounts Info Section First.');
        // }
        // $stockinvestment=DrStocksInvestments::where('case_id',$case_id)->get()->first();
        // if(isset($stockinvestment)){
        // } else {
        //     // return redirect()->route('cases.family_law_interview_tabs',$case_id)->with('error', 'Complete Stock Investment Info Section First.');
        // }
        // $fundsondeposit=DrFundsOnDeposit::where('case_id',$case_id)->get()->first();
        // if(isset($fundsondeposit)){
        // } else {
        //     // return redirect()->route('cases.family_law_interview_tabs',$case_id)->with('error', 'Complete Funds on Deposit Info Section First.');
        // }
        // $personalinfo=DrPersonalInfo::where('case_id',$case_id)->get()->first();
        // if(isset($personalinfo)){
        // } else {
        //     // return redirect()->route('cases.family_law_interview_tabs',$case_id)->with('error', 'Complete Personal Info Section First.');
        // }
        // $vehiclesinfo=DrVehicles::where('case_id',$case_id)->get()->first();
        // if(isset($vehiclesinfo)){
        // } else {
        //     // return redirect()->route('cases.family_law_interview_tabs',$case_id)->with('error', 'Complete Vehicles Info Section First.');
        // }
        // $childrensinfo=DrChildren::where('case_id',$case_id)->get()->first();
        // if(isset($childrensinfo)){
        // } else {
        //     // return redirect()->route('cases.family_law_interview_tabs',$case_id)->with('error', 'Complete Children Info Section First.');
        // }

        // $data=array(
        //     'realestateinfo' => $realestate,
        //     'pensioninfo' => $pension,
        //     'retirementaccountsinfo' => $retirementaccounts,
        //     'stockinvestmentinfo' => $stockinvestment,
        //     'fundsondepositinfo' => $fundsondeposit,
        //     'personalinfo' => $personalinfo,
        //     'vehiclesinfo' => $vehiclesinfo,
        //     'childrensinfo' => $childrensinfo,
        // );

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
         // echo "<pre>";print_r($drcaseoverview);die;
        if($drcaseoverview){
            return view('dr_tables.dr_Case_Overview.edit',['case_id'=> $case_id, 'client_name'=>$client_name, 'opponent_name'=>$opponent_name, 'drcaseoverview' => $drcaseoverview, 'case_data' => $case_data]);
        } else {
            return redirect()->route('home');
        }
        
    }

    public function update(Request $request, $id)
    {

        $result = $request->except('submit','_method','_token');

        // personal info section
        if(isset($result['Client_Info_Active_Military']) && $result['Client_Info_Active_Military']=='1'){
            if(isset($result['SCRA_Prevents_Client']) && $result['SCRA_Prevents_Client']=='1'){
                if(isset($result['Client_Waive_SCRA_Rights']) && $result['Client_Waive_SCRA_Rights']=='1'){
                } else {
                    $result['Client_Waive_SCRA_Rights']='0';
                }
                $result['Client_Possible_SCRA_Issues']='1';
            } else {
                $result['Client_Possible_SCRA_Issues']='0';
                $result['SCRA_Prevents_Client']='0';
            }
        } else {
            $result['Client_Info_Active_Military']='0';
            $result['Client_Branch']=NULL;
            $result['SCRA_Prevents_Client']='0';
            $result['Client_Waive_SCRA_Rights']='0';
            $result['Client_Possible_SCRA_Issues']='0';
        }

        if(isset($result['Op_Info_Active_Military']) && $result['Op_Info_Active_Military']=='1'){
            if(isset($result['SCRA_Prevents_Op']) && $result['SCRA_Prevents_Op']=='1'){
                if(isset($result['Op_Waive_SCRA_Rights']) && $result['Op_Waive_SCRA_Rights']=='1'){
                } else {
                    $result['Op_Waive_SCRA_Rights']='0';
                }
                $result['Op_Possible_SCRA_Issues']='1';
            } else {
                $result['Op_Possible_SCRA_Issues']='0';
                $result['SCRA_Prevents_Op']='0';
            }
        } else {
            $result['Op_Info_Active_Military']='0';
            $result['Op_Branch']=NULL;
            $result['SCRA_Prevents_Op']='0';
            $result['Op_Waive_SCRA_Rights']='0';
            $result['Op_Possible_SCRA_Issues']='0';
        }

        // vehicles info section
        if(isset($result['Any_Vehicles']) && $result['Any_Vehicles']=='1'){
        } else {
            $result['Num_Joint_Vehicles']=0;
            $result['Num_Client_Vehicles']=0;
            $result['Num_Op_Vehicles']=0;
        }

        // Real Estate info section
        if(isset($result['Any_Real_Estate']) && $result['Any_Real_Estate']=='1'){
        } else {
            $result['Num_Joint_Real_Estate_Properties']=0;
            $result['Num_Client_Real_Estate_Properties']=0;
            $result['Num_Op_Real_Estate_Properties']=0;
        }

        // Stock Investment info section
        if(isset($result['Any_Stocks_Investments_Accounts']) && $result['Any_Stocks_Investments_Accounts']=='1'){
        } else {
            $result['Num_Joint_StocksInvestments_Accounts']=0;
            $result['Num_Client_StockInvestments_Accounts']=0;
            $result['Num_Op_StockInvestments_Accounts']=0;
        }
        
        // Funds On Deposit info section
        if(isset($result['Any_FOD']) && $result['Any_FOD']=='1'){
        } else {
            $result['Num_Joint_Deposit_Accounts']=0;
            $result['Num_Client_Deposit_Accounts']=0;
            $result['Num_Op_Deposit_Accounts']=0;
        }

        // Pensions info section
        if(isset($result['Any_Pension']) && $result['Any_Pension']=='1'){
        } else {
            $result['Any_Pension']='0';
            $result['Num_Client_Pensions']=0;
            $result['Num_Op_Pensions']=0;
        }

        // Retirement Accounts info section
        if(isset($result['Any_Retirement_Accts']) && $result['Any_Retirement_Accts']=='1'){
        } else {
            $result['Any_Retirement_Accts']='0';
            $result['Num_Client_Retirement_Accts']=0;
            $result['Num_Op_Retirement_Accts']=0;
        }
        $result['Num_Children_This_Marriage'] = $result['Num_Children_Born_ONLY_These_Parties_Before_Marriage'] + $result['Num_Children_ONLY_This_Marriage'];
        
        // echo "<pre>";print_r($result);die;
        $drcaseoverview  = DrCaseOverview::findOrFail($id);
        if($drcaseoverview){
            $drcaseoverview->fill($result)->save();
            return redirect()->route('drcaseoverview.edit',$result['case_id'])->with('success', 'Case Overview Information Updated Successfully.');
        } else {
            return redirect()->route('drcaseoverview.edit',$result['case_id'])->with('error', 'Something went wrong. Please try Again.');
        }
    }
    
    public function destroy($id)
    {

    }
}
