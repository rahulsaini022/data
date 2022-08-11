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
use App\DrFundsOnDeposit;
use App\DrCaseOverview;


class DrFundsOnDepositController extends Controller
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
        $data=DrFundsOnDeposit::orderBy('id','DESC')->get();
        echo "<pre>";print_r($data);die;
    }


    public function create($case_id)
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

        $drfundsondeposit=DrFundsOnDeposit::where('case_id',$case_id)->get()->pluck('case_id');
        if(isset($drfundsondeposit['0'])){
            return redirect()->route('home');
        }
        $drcaseoverview=DrCaseOverview::where('case_id',$case_id)->get()->first();
        if(isset($drcaseoverview)){
        } else {
            return redirect()->route('cases.family_law_interview_tabs',$case_id)->with('error', 'Complete Case Overview Info Section First.');
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
        return view('dr_tables.dr_FundsOnDeposit.create',['case_id'=> $case_id, 'client_name'=>$client_name, 'opponent_name'=>$opponent_name, 'drcaseoverview'=>$drcaseoverview]);
    }
    
    // save tab info in database table.
    public function store(Request $request)
    {
        $result = $request->except('submit');

        $result['Funds_on_Deposit_Total_PropertyValue']=0.00;
        $result['Funds_on_Deposit_Total_Yearly_Income']=0.00;
        $result['Funds_on_Deposit_Total_Estimated_Yearly_Income_to_Client']=0.00;
        $result['Funds_on_Deposit_Total_Estimated_Yearly_Income_to_Op']=0.00;
        $result['Funds_on_Deposit_Total_Estimated_PropertyValue_to_Client']=0.00;
        $result['Funds_on_Deposit_Total_Estimated_PropertyValue_to_Op']=0.00;

        for ($i=1; $i <= 10; $i++) {
            unset($result[''.$i.'_Joint_Funds_on_Deposit_Estimated_Value_Select_Reset']);
            unset($result[''.$i.'_Client_Funds_on_Deposit_Estimated_Value_Select_Reset']);
            unset($result[''.$i.'_Op_Funds_on_Deposit_Estimated_Value_Select_Reset']);

            if(isset($result['Joint_Funds_on_Deposit_Institution_Current_Balance'.$i.''])){
                $result['Joint_Funds_on_Deposit_Estimated_MaritalEquity'.$i.'']=$result['Joint_Funds_on_Deposit_Institution_Current_Balance'.$i.''];
            } else {
                $result['Joint_Funds_on_Deposit_Estimated_MaritalEquity'.$i.'']=NULL;
            }

            if(isset($result['Client_Funds_on_Deposit_Institution_Current_Balance'.$i.''])){
                $result['Client_Funds_on_Deposit_Estimated_MaritalEquity'.$i.'']=$result['Client_Funds_on_Deposit_Institution_Current_Balance'.$i.'']- $result['Client_Funds_on_Deposit_Institution_Balance_Date_of_Marriage'.$i.''];
            } else {
                $result['Client_Funds_on_Deposit_Estimated_MaritalEquity'.$i.'']=NULL;
            }

            if(isset($result['Op_Funds_on_Deposit_Institution_Current_Balance'.$i.''])){
                $result['Op_Funds_on_Deposit_Estimated_MaritalEquity'.$i.'']=$result['Op_Funds_on_Deposit_Institution_Current_Balance'.$i.'']- $result['Op_Funds_on_Deposit_Institution_Balance_Date_of_Marriage'.$i.''];
            } else {
                $result['Op_Funds_on_Deposit_Estimated_MaritalEquity'.$i.'']=NULL;
            }

            // for new calculations
            $result['Joint_Funds_on_Deposit_Estimated_Yearly_Income_to_Client'.$i.'']=0.00;
            $result['Joint_Funds_on_Deposit_Estimated_Yearly_Income_to_Op'.$i.'']=0.00;

            if(isset($result['Joint_Funds_on_Deposit_Percent_Marital_Equity_to_Client'.$i.'']) && $result['Joint_Funds_on_Deposit_Percent_Marital_Equity_to_Client'.$i.''] !='' && isset($result['Joint_Funds_on_Deposit_Institution_Yearly_Interest_Dividend'.$i.'']) && $result['Joint_Funds_on_Deposit_Institution_Yearly_Interest_Dividend'.$i.''] !=''){
                $result['Joint_Funds_on_Deposit_Estimated_Yearly_Income_to_Client'.$i.'']=$result['Joint_Funds_on_Deposit_Percent_Marital_Equity_to_Client'.$i.'']*$result['Joint_Funds_on_Deposit_Institution_Yearly_Interest_Dividend'.$i.''];
            }

            if(isset($result['Joint_Funds_on_Deposit_Institution_Yearly_Interest_Dividend'.$i.'']) && $result['Joint_Funds_on_Deposit_Institution_Yearly_Interest_Dividend'.$i.''] !='' && isset($result['Joint_Funds_on_Deposit_Estimated_Yearly_Income_to_Client'.$i.'']) && $result['Joint_Funds_on_Deposit_Estimated_Yearly_Income_to_Client'.$i.''] !=''){
                $result['Joint_Funds_on_Deposit_Estimated_Yearly_Income_to_Op'.$i.'']=$result['Joint_Funds_on_Deposit_Institution_Yearly_Interest_Dividend'.$i.'']-$result['Joint_Funds_on_Deposit_Estimated_Yearly_Income_to_Client'.$i.''];
            }

            $result['Client_Funds_on_Deposit_Estimated_Yearly_Income_to_Client'.$i.'']=0.00;
            $result['Client_Funds_on_Deposit_Estimated_Yearly_Income_to_Op'.$i.'']=0.00;

            if(isset($result['Client_Funds_on_Deposit_Percent_Marital_Equity_to_Client'.$i.'']) && $result['Client_Funds_on_Deposit_Percent_Marital_Equity_to_Client'.$i.''] !='' && isset($result['Client_Funds_on_Deposit_Institution_Yearly_Interest_Dividend'.$i.'']) && $result['Client_Funds_on_Deposit_Institution_Yearly_Interest_Dividend'.$i.''] !=''){
                $result['Client_Funds_on_Deposit_Estimated_Yearly_Income_to_Client'.$i.'']=$result['Client_Funds_on_Deposit_Percent_Marital_Equity_to_Client'.$i.'']*$result['Client_Funds_on_Deposit_Institution_Yearly_Interest_Dividend'.$i.''];
            }

            if(isset($result['Client_Funds_on_Deposit_Institution_Yearly_Interest_Dividend'.$i.'']) && $result['Client_Funds_on_Deposit_Institution_Yearly_Interest_Dividend'.$i.''] !='' && isset($result['Client_Funds_on_Deposit_Estimated_Yearly_Income_to_Client'.$i.'']) && $result['Client_Funds_on_Deposit_Estimated_Yearly_Income_to_Client'.$i.''] !=''){
                $result['Client_Funds_on_Deposit_Estimated_Yearly_Income_to_Op'.$i.'']=$result['Client_Funds_on_Deposit_Institution_Yearly_Interest_Dividend'.$i.'']-$result['Client_Funds_on_Deposit_Estimated_Yearly_Income_to_Client'.$i.''];
            }

            $result['Op_Funds_on_Deposit_Estimated_Yearly_Income_to_Client'.$i.'']=0.00;
            $result['Op_Funds_on_Deposit_Estimated_Yearly_Income_to_Op'.$i.'']=0.00;

            if(isset($result['Op_Funds_on_Deposit_Percent_Marital_Equity_to_Client'.$i.'']) && $result['Op_Funds_on_Deposit_Percent_Marital_Equity_to_Client'.$i.''] !='' && isset($result['Op_Funds_on_Deposit_Institution_Yearly_Interest_Dividend'.$i.'']) && $result['Op_Funds_on_Deposit_Institution_Yearly_Interest_Dividend'.$i.''] !=''){
                $result['Op_Funds_on_Deposit_Estimated_Yearly_Income_to_Client'.$i.'']=$result['Op_Funds_on_Deposit_Percent_Marital_Equity_to_Client'.$i.'']*$result['Op_Funds_on_Deposit_Institution_Yearly_Interest_Dividend'.$i.''];
            }

            if(isset($result['Op_Funds_on_Deposit_Institution_Yearly_Interest_Dividend'.$i.'']) && $result['Op_Funds_on_Deposit_Institution_Yearly_Interest_Dividend'.$i.''] !='' && isset($result['Op_Funds_on_Deposit_Estimated_Yearly_Income_to_Client'.$i.'']) && $result['Op_Funds_on_Deposit_Estimated_Yearly_Income_to_Client'.$i.''] !=''){
                $result['Op_Funds_on_Deposit_Estimated_Yearly_Income_to_Op'.$i.'']=$result['Op_Funds_on_Deposit_Institution_Yearly_Interest_Dividend'.$i.'']-$result['Op_Funds_on_Deposit_Estimated_Yearly_Income_to_Client'.$i.''];
            }
            
            // $result['Funds_on_Deposit_Total_PropertyValue']=0.00;

            if(isset($result['Joint_Funds_on_Deposit_Estimated_MaritalEquity'.$i.'']) && $result['Joint_Funds_on_Deposit_Estimated_MaritalEquity'.$i.''] !=''){
                $result['Funds_on_Deposit_Total_PropertyValue']=$result['Funds_on_Deposit_Total_PropertyValue']+$result['Joint_Funds_on_Deposit_Estimated_MaritalEquity'.$i.''];
            }

            if(isset($result['Client_Funds_on_Deposit_Institution_Current_Balance'.$i.'']) && $result['Client_Funds_on_Deposit_Institution_Current_Balance'.$i.''] !=''){
                $result['Funds_on_Deposit_Total_PropertyValue']=$result['Funds_on_Deposit_Total_PropertyValue']+$result['Client_Funds_on_Deposit_Institution_Current_Balance'.$i.''];
            }

            if(isset($result['Op_Funds_on_Deposit_Institution_Current_Balance'.$i.'']) && $result['Op_Funds_on_Deposit_Institution_Current_Balance'.$i.''] !=''){
                $result['Funds_on_Deposit_Total_PropertyValue']=$result['Funds_on_Deposit_Total_PropertyValue']+$result['Op_Funds_on_Deposit_Institution_Current_Balance'.$i.''];
            }

            // $result['Funds_on_Deposit_Total_Yearly_Income']=0.00;

            if(isset($result['Joint_Funds_on_Deposit_Institution_Yearly_Interest_Dividend'.$i.'']) && $result['Joint_Funds_on_Deposit_Institution_Yearly_Interest_Dividend'.$i.''] !=''){
                $result['Funds_on_Deposit_Total_Yearly_Income']=$result['Funds_on_Deposit_Total_Yearly_Income']+$result['Joint_Funds_on_Deposit_Institution_Yearly_Interest_Dividend'.$i.''];
            }

            if(isset($result['Client_Funds_on_Deposit_Institution_Yearly_Interest_Dividend'.$i.'']) && $result['Client_Funds_on_Deposit_Institution_Yearly_Interest_Dividend'.$i.''] !=''){
                $result['Funds_on_Deposit_Total_Yearly_Income']=$result['Funds_on_Deposit_Total_Yearly_Income']+$result['Client_Funds_on_Deposit_Institution_Yearly_Interest_Dividend'.$i.''];
            }

            if(isset($result['Op_Funds_on_Deposit_Institution_Yearly_Interest_Dividend'.$i.'']) && $result['Op_Funds_on_Deposit_Institution_Yearly_Interest_Dividend'.$i.''] !=''){
                $result['Funds_on_Deposit_Total_Yearly_Income']=$result['Funds_on_Deposit_Total_Yearly_Income']+$result['Op_Funds_on_Deposit_Institution_Yearly_Interest_Dividend'.$i.''];
            }

            // $result['Funds_on_Deposit_Total_Estimated_Yearly_Income_to_Client']=0.00;

            if(isset($result['Joint_Funds_on_Deposit_Estimated_Yearly_Income_to_Client'.$i.'']) && $result['Joint_Funds_on_Deposit_Estimated_Yearly_Income_to_Client'.$i.''] !=''){
                $result['Funds_on_Deposit_Total_Estimated_Yearly_Income_to_Client']=$result['Funds_on_Deposit_Total_Estimated_Yearly_Income_to_Client']+$result['Joint_Funds_on_Deposit_Estimated_Yearly_Income_to_Client'.$i.''];
            }

            if(isset($result['Client_Funds_on_Deposit_Estimated_Yearly_Income_to_Client'.$i.'']) && $result['Client_Funds_on_Deposit_Estimated_Yearly_Income_to_Client'.$i.''] !=''){
                $result['Funds_on_Deposit_Total_Estimated_Yearly_Income_to_Client']=$result['Funds_on_Deposit_Total_Estimated_Yearly_Income_to_Client']+$result['Client_Funds_on_Deposit_Estimated_Yearly_Income_to_Client'.$i.''];
            }

            if(isset($result['Op_Funds_on_Deposit_Estimated_Yearly_Income_to_Client'.$i.'']) && $result['Op_Funds_on_Deposit_Estimated_Yearly_Income_to_Client'.$i.''] !=''){
                $result['Funds_on_Deposit_Total_Estimated_Yearly_Income_to_Client']=$result['Funds_on_Deposit_Total_Estimated_Yearly_Income_to_Client']+$result['Op_Funds_on_Deposit_Estimated_Yearly_Income_to_Client'.$i.''];
            }

            // $result['Funds_on_Deposit_Total_Estimated_Yearly_Income_to_Op']=0.00;

            if(isset($result['Joint_Funds_on_Deposit_Estimated_Yearly_Income_to_Op'.$i.'']) && $result['Joint_Funds_on_Deposit_Estimated_Yearly_Income_to_Op'.$i.''] !=''){
                $result['Funds_on_Deposit_Total_Estimated_Yearly_Income_to_Op']=$result['Funds_on_Deposit_Total_Estimated_Yearly_Income_to_Op']+$result['Joint_Funds_on_Deposit_Estimated_Yearly_Income_to_Op'.$i.''];
            }

            if(isset($result['Client_Funds_on_Deposit_Estimated_Yearly_Income_to_Op'.$i.'']) && $result['Client_Funds_on_Deposit_Estimated_Yearly_Income_to_Op'.$i.''] !=''){
                $result['Funds_on_Deposit_Total_Estimated_Yearly_Income_to_Op']=$result['Funds_on_Deposit_Total_Estimated_Yearly_Income_to_Op']+$result['Client_Funds_on_Deposit_Estimated_Yearly_Income_to_Op'.$i.''];
            }

            if(isset($result['Op_Funds_on_Deposit_Estimated_Yearly_Income_to_Op'.$i.'']) && $result['Op_Funds_on_Deposit_Estimated_Yearly_Income_to_Op'.$i.''] !=''){
                $result['Funds_on_Deposit_Total_Estimated_Yearly_Income_to_Op']=$result['Funds_on_Deposit_Total_Estimated_Yearly_Income_to_Op']+$result['Op_Funds_on_Deposit_Estimated_Yearly_Income_to_Op'.$i.''];
            }

            // $result['Funds_on_Deposit_Total_Estimated_PropertyValue_to_Client']=0.00;

            if(isset($result['Joint_Funds_on_Deposit_Estimated_Value_to_Client'.$i.'']) && $result['Joint_Funds_on_Deposit_Estimated_Value_to_Client'.$i.''] !=''){
                $result['Funds_on_Deposit_Total_Estimated_PropertyValue_to_Client']=$result['Funds_on_Deposit_Total_Estimated_PropertyValue_to_Client']+$result['Joint_Funds_on_Deposit_Estimated_Value_to_Client'.$i.''];
            }

            if(isset($result['Client_Funds_on_Deposit_Estimated_Value_to_Client'.$i.'']) && $result['Client_Funds_on_Deposit_Estimated_Value_to_Client'.$i.''] !=''){
                $result['Funds_on_Deposit_Total_Estimated_PropertyValue_to_Client']=$result['Funds_on_Deposit_Total_Estimated_PropertyValue_to_Client']+$result['Client_Funds_on_Deposit_Estimated_Value_to_Client'.$i.''];
            }

            if(isset($result['Op_Funds_on_Deposit_Estimated_Value_to_Client'.$i.'']) && $result['Op_Funds_on_Deposit_Estimated_Value_to_Client'.$i.''] !=''){
                $result['Funds_on_Deposit_Total_Estimated_PropertyValue_to_Client']=$result['Funds_on_Deposit_Total_Estimated_PropertyValue_to_Client']+$result['Op_Funds_on_Deposit_Estimated_Value_to_Client'.$i.''];
            }

            // $result['Funds_on_Deposit_Total_Estimated_PropertyValue_to_Op']=0.00;

            if(isset($result['Joint_Funds_on_Deposit_Estimated_Value_to_Op'.$i.'']) && $result['Joint_Funds_on_Deposit_Estimated_Value_to_Op'.$i.''] !=''){
                $result['Funds_on_Deposit_Total_Estimated_PropertyValue_to_Op']=$result['Funds_on_Deposit_Total_Estimated_PropertyValue_to_Op']+$result['Joint_Funds_on_Deposit_Estimated_Value_to_Op'.$i.''];
            }

            if(isset($result['Client_Funds_on_Deposit_Estimated_Value_to_Op'.$i.'']) && $result['Client_Funds_on_Deposit_Estimated_Value_to_Op'.$i.''] !=''){
                $result['Funds_on_Deposit_Total_Estimated_PropertyValue_to_Op']=$result['Funds_on_Deposit_Total_Estimated_PropertyValue_to_Op']+$result['Client_Funds_on_Deposit_Estimated_Value_to_Op'.$i.''];
            }

            if(isset($result['Op_Funds_on_Deposit_Estimated_Value_to_Op'.$i.'']) && $result['Op_Funds_on_Deposit_Estimated_Value_to_Op'.$i.''] !=''){
                $result['Funds_on_Deposit_Total_Estimated_PropertyValue_to_Op']=$result['Funds_on_Deposit_Total_Estimated_PropertyValue_to_Op']+$result['Op_Funds_on_Deposit_Estimated_Value_to_Op'.$i.''];
            }

        }

        if(isset($result['Any_FOD']) && $result['Any_FOD']=='1'){
        } else {
            $result['Any_FOD']='0';
            $result['Num_Joint_Deposit_Accounts']=0;
            $result['Num_Client_Deposit_Accounts']=0;
            $result['Num_Op_Deposit_Accounts']=0;
        }

        if(isset($result['Num_Joint_Deposit_Accounts'])){
        } else {
            $result['Num_Joint_Deposit_Accounts']='0';
        }
        $Num_Joint_Deposit_Accounts=$result['Num_Joint_Deposit_Accounts'];
        $Num_Joint_Deposit_Accounts=$Num_Joint_Deposit_Accounts+1;
        for ($i=$Num_Joint_Deposit_Accounts; $i <= 10; $i++) { 
            $result['Joint_Funds_on_Deposit_Institution_ZIP'.$i.'']=NULL;
            $result['Joint_Funds_on_Deposit_Institution_Name'.$i.'']=NULL;
            $result['Joint_Funds_on_Deposit_Institution_Street_Address'.$i.'']=NULL;
            $result['Joint_Funds_on_Deposit_Institution_City'.$i.'']=NULL;
            $result['Joint_Funds_on_Deposit_Institution_State'.$i.'']=NULL;
            $result['Joint_Funds_on_Deposit_Institution_Acct_Num'.$i.'']=NULL;
            $result['Joint_Funds_on_Deposit_Institution_Current_Balance'.$i.'']=NULL;
            $result['Joint_Funds_on_Deposit_Estimated_MaritalEquity'.$i.'']=NULL;
            $result['Joint_Funds_on_Deposit_Institution_Yearly_Interest_Dividend'.$i.'']=NULL;
            $result['Joint_Funds_on_Deposit_SoleSeparate_Claim'.$i.'']=NULL;
            $result['Joint_Funds_on_Deposit_SoleSeparate_Party'.$i.'']=NULL;
            $result['Joint_Funds_on_Deposit_SoleSeparate_Grounds'.$i.'']=NULL;
            $result['Joint_Funds_on_Deposit_Percent_Marital_Equity_to_Client'.$i.'']=NULL;
            $result['Joint_Funds_on_Deposit_Percent_Marital_Equity_to_Op'.$i.'']=NULL;
            $result['Joint_Funds_on_Deposit_Estimated_Value_to_Client'.$i.'']=NULL;
            $result['Joint_Funds_on_Deposit_Estimated_Value_to_Op'.$i.'']=NULL;
            $result['Joint_Funds_on_Deposit_Estimated_Yearly_Income_to_Client'.$i.'']=NULL;
            $result['Joint_Funds_on_Deposit_Estimated_Yearly_Income_to_Op'.$i.'']=NULL;
        }

        if(isset($result['Num_Client_Deposit_Accounts'])){
        } else {
            $result['Num_Client_Deposit_Accounts']='0';
        }
        $Num_Client_Deposit_Accounts=$result['Num_Client_Deposit_Accounts'];
        $Num_Client_Deposit_Accounts=$Num_Client_Deposit_Accounts+1;
        for ($i=$Num_Client_Deposit_Accounts; $i <= 10; $i++) { 
            $result['Client_Funds_on_Deposit_Institution_ZIP'.$i.'']=NULL;
            $result['Client_Funds_on_Deposit_Institution_Name'.$i.'']=NULL;
            $result['Client_Funds_on_Deposit_Institution_Street_Address'.$i.'']=NULL;
            $result['Client_Funds_on_Deposit_Institution_City'.$i.'']=NULL;
            $result['Client_Funds_on_Deposit_Institution_State'.$i.'']=NULL;
            $result['Client_Funds_on_Deposit_Institution_Acct_Num'.$i.'']=NULL;
            $result['Client_Funds_on_Deposit_Institution_Name_on_Acct'.$i.'']=NULL;
            $result['Client_Funds_on_Deposit_Institution_Current_Balance'.$i.'']=NULL;
            $result['Client_Funds_on_Deposit_Institution_Yearly_Interest_Dividend'.$i.'']=NULL;
            $result['Client_Funds_on_Deposit_Institution_Balance_Date_of_Marriage'.$i.'']=NULL;
            $result['Client_Funds_on_Deposit_Estimated_MaritalEquity'.$i.'']=NULL;
            $result['Client_Funds_on_Deposit_SoleSeparate_Claim'.$i.'']=NULL;
            $result['Client_Funds_on_Deposit_SoleSeparate_Party'.$i.'']=NULL;
            $result['Client_Funds_on_Deposit_SoleSeparate_Grounds'.$i.'']=NULL;
            $result['Client_Funds_on_Deposit_Percent_Marital_Equity_to_Client'.$i.'']=NULL;
            $result['Client_Funds_on_Deposit_Percent_Marital_Equity_to_Op'.$i.'']=NULL;
            $result['Client_Funds_on_Deposit_Estimated_Value_to_Client'.$i.'']=NULL;
            $result['Client_Funds_on_Deposit_Estimated_Value_to_Op'.$i.'']=NULL;
            $result['Client_Funds_on_Deposit_Estimated_Yearly_Income_to_Client'.$i.'']=NULL;
            $result['Client_Funds_on_Deposit_Estimated_Yearly_Income_to_Op'.$i.'']=NULL;
        }

        if(isset($result['Num_Op_Deposit_Accounts'])){
        } else {
            $result['Num_Op_Deposit_Accounts']='0';
        }
        $Num_Op_Deposit_Accounts=$result['Num_Op_Deposit_Accounts'];
        $Num_Op_Deposit_Accounts=$Num_Op_Deposit_Accounts+1;
        for ($i=$Num_Op_Deposit_Accounts; $i <= 10; $i++) { 
            $result['Op_Funds_on_Deposit_Institution_ZIP'.$i.'']=NULL;
            $result['Op_Funds_on_Deposit_Institution_Name'.$i.'']=NULL;
            $result['Op_Funds_on_Deposit_Institution_Street_Address'.$i.'']=NULL;
            $result['Op_Funds_on_Deposit_Institution_City'.$i.'']=NULL;
            $result['Op_Funds_on_Deposit_Institution_State'.$i.'']=NULL;
            $result['Op_Funds_on_Deposit_Institution_Acct_Num'.$i.'']=NULL;
            $result['Op_Funds_on_Deposit_Institution_Name_on_Acct'.$i.'']=NULL;
            $result['Op_Funds_on_Deposit_Institution_Current_Balance'.$i.'']=NULL;
            $result['Op_Funds_on_Deposit_Institution_Yearly_Interest_Dividend'.$i.'']=NULL;
            $result['Op_Funds_on_Deposit_Institution_Balance_Date_of_Marriage'.$i.'']=NULL;
            $result['Op_Funds_on_Deposit_Estimated_MaritalEquity'.$i.'']=NULL;
            $result['Op_Funds_on_Deposit_SoleSeparate_Claim'.$i.'']=NULL;
            $result['Op_Funds_on_Deposit_SoleSeparate_Party'.$i.'']=NULL;
            $result['Op_Funds_on_Deposit_SoleSeparate_Grounds'.$i.'']=NULL;
            $result['Op_Funds_on_Deposit_Percent_Marital_Equity_to_Client'.$i.'']=NULL;
            $result['Op_Funds_on_Deposit_Percent_Marital_Equity_to_Op'.$i.'']=NULL;
            $result['Op_Funds_on_Deposit_Estimated_Value_to_Client'.$i.'']=NULL;
            $result['Op_Funds_on_Deposit_Estimated_Value_to_Op'.$i.'']=NULL;
            $result['Op_Funds_on_Deposit_Estimated_Yearly_Income_to_Client'.$i.'']=NULL;
            $result['Op_Funds_on_Deposit_Estimated_Yearly_Income_to_Op'.$i.'']=NULL;
        }


        // echo "<pre>";print_r($result);die;
        $DrFundsOnDeposit=DrFundsOnDeposit::create($result);
        // update case overview info.
        $drcaseoverview=DrCaseOverview::where('case_id',$result['case_id'])->get()->first();
        if(isset($drcaseoverview)){
            $drcaseoverview->Any_FOD=$result['Any_FOD'];
            $drcaseoverview->Num_Joint_Deposit_Accounts=$result['Num_Joint_Deposit_Accounts'];
            $drcaseoverview->Num_Client_Deposit_Accounts=$result['Num_Client_Deposit_Accounts'];
            $drcaseoverview->Num_Op_Deposit_Accounts=$result['Num_Op_Deposit_Accounts'];
            $drcaseoverview->save();
        } else {
            return redirect()->route('cases.family_law_interview_tabs',$result['case_id'])->with('error', 'Complete Case Overview Info Section First.');
        }
        return redirect()->route('cases.family_law_interview_tabs',$result['case_id'])->with('success', 'Funds On Deposit Information Submitted Successfully.');
        
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
        
        $drfundsondeposit=DrFundsOnDeposit::where('case_id',$case_id)->get()->first();
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
         // echo "<pre>";print_r($drfundsondeposit);die;
        $drcaseoverview=DrCaseOverview::where('case_id',$case_id)->get()->first();
        if($drfundsondeposit){
            if(isset($drcaseoverview)){
                if(isset($drcaseoverview) && $drcaseoverview->Any_FOD==$drfundsondeposit->Any_FOD && $drcaseoverview->Num_Joint_Deposit_Accounts==$drfundsondeposit->Num_Joint_Deposit_Accounts && $drcaseoverview->Num_Client_Deposit_Accounts==$drfundsondeposit->Num_Client_Deposit_Accounts && $drcaseoverview->Num_Op_Deposit_Accounts==$drfundsondeposit->Num_Op_Deposit_Accounts)
                {

                } else {
                    $drfundsondeposit->Any_FOD=$drcaseoverview->Any_FOD;
                    $drfundsondeposit->Num_Joint_Deposit_Accounts=$drcaseoverview->Num_Joint_Deposit_Accounts;
                    $drfundsondeposit->Num_Client_Deposit_Accounts=$drcaseoverview->Num_Client_Deposit_Accounts;
                    $drfundsondeposit->Num_Op_Deposit_Accounts=$drcaseoverview->Num_Op_Deposit_Accounts;
                }
            }
            return view('dr_tables.dr_FundsOnDeposit.edit',['case_id'=> $case_id, 'client_name'=>$client_name, 'opponent_name'=>$opponent_name, 'drfundsondeposit' => $drfundsondeposit]);
        } else {
            return redirect()->route('home');
        }
        
    }

    public function update(Request $request, $id)
    {
        $result = $request->except('submit','_method','_token');
        
        $result['Funds_on_Deposit_Total_PropertyValue']=0.00;
        $result['Funds_on_Deposit_Total_Yearly_Income']=0.00;
        $result['Funds_on_Deposit_Total_Estimated_Yearly_Income_to_Client']=0.00;
        $result['Funds_on_Deposit_Total_Estimated_Yearly_Income_to_Op']=0.00;
        $result['Funds_on_Deposit_Total_Estimated_PropertyValue_to_Client']=0.00;
        $result['Funds_on_Deposit_Total_Estimated_PropertyValue_to_Op']=0.00;

        for ($i=1; $i <= 10; $i++) {
            unset($result[''.$i.'_Joint_Funds_on_Deposit_Estimated_Value_Select_Reset']);
            unset($result[''.$i.'_Client_Funds_on_Deposit_Estimated_Value_Select_Reset']);
            unset($result[''.$i.'_Op_Funds_on_Deposit_Estimated_Value_Select_Reset']);

            if(isset($result['Joint_Funds_on_Deposit_Institution_Current_Balance'.$i.''])){
                $result['Joint_Funds_on_Deposit_Estimated_MaritalEquity'.$i.'']=$result['Joint_Funds_on_Deposit_Institution_Current_Balance'.$i.''];
            } else {
                $result['Joint_Funds_on_Deposit_Estimated_MaritalEquity'.$i.'']=NULL;
            }

            if(isset($result['Client_Funds_on_Deposit_Institution_Current_Balance'.$i.''])){
                $result['Client_Funds_on_Deposit_Estimated_MaritalEquity'.$i.'']=$result['Client_Funds_on_Deposit_Institution_Current_Balance'.$i.'']- $result['Client_Funds_on_Deposit_Institution_Balance_Date_of_Marriage'.$i.''];
            } else {
                $result['Client_Funds_on_Deposit_Estimated_MaritalEquity'.$i.'']=NULL;
            }

            if(isset($result['Op_Funds_on_Deposit_Institution_Current_Balance'.$i.''])){
                $result['Op_Funds_on_Deposit_Estimated_MaritalEquity'.$i.'']=$result['Op_Funds_on_Deposit_Institution_Current_Balance'.$i.'']- $result['Op_Funds_on_Deposit_Institution_Balance_Date_of_Marriage'.$i.''];
            } else {
                $result['Op_Funds_on_Deposit_Estimated_MaritalEquity'.$i.'']=NULL;
            }

            // for new calculations
            $result['Joint_Funds_on_Deposit_Estimated_Yearly_Income_to_Client'.$i.'']=0.00;
            $result['Joint_Funds_on_Deposit_Estimated_Yearly_Income_to_Op'.$i.'']=0.00;

            if(isset($result['Joint_Funds_on_Deposit_Percent_Marital_Equity_to_Client'.$i.'']) && $result['Joint_Funds_on_Deposit_Percent_Marital_Equity_to_Client'.$i.''] !='' && isset($result['Joint_Funds_on_Deposit_Institution_Yearly_Interest_Dividend'.$i.'']) && $result['Joint_Funds_on_Deposit_Institution_Yearly_Interest_Dividend'.$i.''] !=''){
                $result['Joint_Funds_on_Deposit_Estimated_Yearly_Income_to_Client'.$i.'']=$result['Joint_Funds_on_Deposit_Percent_Marital_Equity_to_Client'.$i.'']*$result['Joint_Funds_on_Deposit_Institution_Yearly_Interest_Dividend'.$i.''];
            }

            if(isset($result['Joint_Funds_on_Deposit_Institution_Yearly_Interest_Dividend'.$i.'']) && $result['Joint_Funds_on_Deposit_Institution_Yearly_Interest_Dividend'.$i.''] !='' && isset($result['Joint_Funds_on_Deposit_Estimated_Yearly_Income_to_Client'.$i.'']) && $result['Joint_Funds_on_Deposit_Estimated_Yearly_Income_to_Client'.$i.''] !=''){
                $result['Joint_Funds_on_Deposit_Estimated_Yearly_Income_to_Op'.$i.'']=$result['Joint_Funds_on_Deposit_Institution_Yearly_Interest_Dividend'.$i.'']-$result['Joint_Funds_on_Deposit_Estimated_Yearly_Income_to_Client'.$i.''];
            }

            $result['Client_Funds_on_Deposit_Estimated_Yearly_Income_to_Client'.$i.'']=0.00;
            $result['Client_Funds_on_Deposit_Estimated_Yearly_Income_to_Op'.$i.'']=0.00;

            if(isset($result['Client_Funds_on_Deposit_Percent_Marital_Equity_to_Client'.$i.'']) && $result['Client_Funds_on_Deposit_Percent_Marital_Equity_to_Client'.$i.''] !='' && isset($result['Client_Funds_on_Deposit_Institution_Yearly_Interest_Dividend'.$i.'']) && $result['Client_Funds_on_Deposit_Institution_Yearly_Interest_Dividend'.$i.''] !=''){
                $result['Client_Funds_on_Deposit_Estimated_Yearly_Income_to_Client'.$i.'']=$result['Client_Funds_on_Deposit_Percent_Marital_Equity_to_Client'.$i.'']*$result['Client_Funds_on_Deposit_Institution_Yearly_Interest_Dividend'.$i.''];
            }

            if(isset($result['Client_Funds_on_Deposit_Institution_Yearly_Interest_Dividend'.$i.'']) && $result['Client_Funds_on_Deposit_Institution_Yearly_Interest_Dividend'.$i.''] !='' && isset($result['Client_Funds_on_Deposit_Estimated_Yearly_Income_to_Client'.$i.'']) && $result['Client_Funds_on_Deposit_Estimated_Yearly_Income_to_Client'.$i.''] !=''){
                $result['Client_Funds_on_Deposit_Estimated_Yearly_Income_to_Op'.$i.'']=$result['Client_Funds_on_Deposit_Institution_Yearly_Interest_Dividend'.$i.'']-$result['Client_Funds_on_Deposit_Estimated_Yearly_Income_to_Client'.$i.''];
            }

            $result['Op_Funds_on_Deposit_Estimated_Yearly_Income_to_Client'.$i.'']=0.00;
            $result['Op_Funds_on_Deposit_Estimated_Yearly_Income_to_Op'.$i.'']=0.00;

            if(isset($result['Op_Funds_on_Deposit_Percent_Marital_Equity_to_Client'.$i.'']) && $result['Op_Funds_on_Deposit_Percent_Marital_Equity_to_Client'.$i.''] !='' && isset($result['Op_Funds_on_Deposit_Institution_Yearly_Interest_Dividend'.$i.'']) && $result['Op_Funds_on_Deposit_Institution_Yearly_Interest_Dividend'.$i.''] !=''){
                $result['Op_Funds_on_Deposit_Estimated_Yearly_Income_to_Client'.$i.'']=$result['Op_Funds_on_Deposit_Percent_Marital_Equity_to_Client'.$i.'']*$result['Op_Funds_on_Deposit_Institution_Yearly_Interest_Dividend'.$i.''];
            }

            if(isset($result['Op_Funds_on_Deposit_Institution_Yearly_Interest_Dividend'.$i.'']) && $result['Op_Funds_on_Deposit_Institution_Yearly_Interest_Dividend'.$i.''] !='' && isset($result['Op_Funds_on_Deposit_Estimated_Yearly_Income_to_Client'.$i.'']) && $result['Op_Funds_on_Deposit_Estimated_Yearly_Income_to_Client'.$i.''] !=''){
                $result['Op_Funds_on_Deposit_Estimated_Yearly_Income_to_Op'.$i.'']=$result['Op_Funds_on_Deposit_Institution_Yearly_Interest_Dividend'.$i.'']-$result['Op_Funds_on_Deposit_Estimated_Yearly_Income_to_Client'.$i.''];
            }
            
            // $result['Funds_on_Deposit_Total_PropertyValue']=0.00;

            if(isset($result['Joint_Funds_on_Deposit_Estimated_MaritalEquity'.$i.'']) && $result['Joint_Funds_on_Deposit_Estimated_MaritalEquity'.$i.''] !=''){
                $result['Funds_on_Deposit_Total_PropertyValue']=$result['Funds_on_Deposit_Total_PropertyValue']+$result['Joint_Funds_on_Deposit_Estimated_MaritalEquity'.$i.''];
            }

            if(isset($result['Client_Funds_on_Deposit_Institution_Current_Balance'.$i.'']) && $result['Client_Funds_on_Deposit_Institution_Current_Balance'.$i.''] !=''){
                $result['Funds_on_Deposit_Total_PropertyValue']=$result['Funds_on_Deposit_Total_PropertyValue']+$result['Client_Funds_on_Deposit_Institution_Current_Balance'.$i.''];
            }

            if(isset($result['Op_Funds_on_Deposit_Institution_Current_Balance'.$i.'']) && $result['Op_Funds_on_Deposit_Institution_Current_Balance'.$i.''] !=''){
                $result['Funds_on_Deposit_Total_PropertyValue']=$result['Funds_on_Deposit_Total_PropertyValue']+$result['Op_Funds_on_Deposit_Institution_Current_Balance'.$i.''];
            }

            // $result['Funds_on_Deposit_Total_Yearly_Income']=0.00;

            if(isset($result['Joint_Funds_on_Deposit_Institution_Yearly_Interest_Dividend'.$i.'']) && $result['Joint_Funds_on_Deposit_Institution_Yearly_Interest_Dividend'.$i.''] !=''){
                $result['Funds_on_Deposit_Total_Yearly_Income']=$result['Funds_on_Deposit_Total_Yearly_Income']+$result['Joint_Funds_on_Deposit_Institution_Yearly_Interest_Dividend'.$i.''];
            }

            if(isset($result['Client_Funds_on_Deposit_Institution_Yearly_Interest_Dividend'.$i.'']) && $result['Client_Funds_on_Deposit_Institution_Yearly_Interest_Dividend'.$i.''] !=''){
                $result['Funds_on_Deposit_Total_Yearly_Income']=$result['Funds_on_Deposit_Total_Yearly_Income']+$result['Client_Funds_on_Deposit_Institution_Yearly_Interest_Dividend'.$i.''];
            }

            if(isset($result['Op_Funds_on_Deposit_Institution_Yearly_Interest_Dividend'.$i.'']) && $result['Op_Funds_on_Deposit_Institution_Yearly_Interest_Dividend'.$i.''] !=''){
                $result['Funds_on_Deposit_Total_Yearly_Income']=$result['Funds_on_Deposit_Total_Yearly_Income']+$result['Op_Funds_on_Deposit_Institution_Yearly_Interest_Dividend'.$i.''];
            }

            // $result['Funds_on_Deposit_Total_Estimated_Yearly_Income_to_Client']=0.00;

            if(isset($result['Joint_Funds_on_Deposit_Estimated_Yearly_Income_to_Client'.$i.'']) && $result['Joint_Funds_on_Deposit_Estimated_Yearly_Income_to_Client'.$i.''] !=''){
                $result['Funds_on_Deposit_Total_Estimated_Yearly_Income_to_Client']=$result['Funds_on_Deposit_Total_Estimated_Yearly_Income_to_Client']+$result['Joint_Funds_on_Deposit_Estimated_Yearly_Income_to_Client'.$i.''];
            }

            if(isset($result['Client_Funds_on_Deposit_Estimated_Yearly_Income_to_Client'.$i.'']) && $result['Client_Funds_on_Deposit_Estimated_Yearly_Income_to_Client'.$i.''] !=''){
                $result['Funds_on_Deposit_Total_Estimated_Yearly_Income_to_Client']=$result['Funds_on_Deposit_Total_Estimated_Yearly_Income_to_Client']+$result['Client_Funds_on_Deposit_Estimated_Yearly_Income_to_Client'.$i.''];
            }

            if(isset($result['Op_Funds_on_Deposit_Estimated_Yearly_Income_to_Client'.$i.'']) && $result['Op_Funds_on_Deposit_Estimated_Yearly_Income_to_Client'.$i.''] !=''){
                $result['Funds_on_Deposit_Total_Estimated_Yearly_Income_to_Client']=$result['Funds_on_Deposit_Total_Estimated_Yearly_Income_to_Client']+$result['Op_Funds_on_Deposit_Estimated_Yearly_Income_to_Client'.$i.''];
            }

            // $result['Funds_on_Deposit_Total_Estimated_Yearly_Income_to_Op']=0.00;

            if(isset($result['Joint_Funds_on_Deposit_Estimated_Yearly_Income_to_Op'.$i.'']) && $result['Joint_Funds_on_Deposit_Estimated_Yearly_Income_to_Op'.$i.''] !=''){
                $result['Funds_on_Deposit_Total_Estimated_Yearly_Income_to_Op']=$result['Funds_on_Deposit_Total_Estimated_Yearly_Income_to_Op']+$result['Joint_Funds_on_Deposit_Estimated_Yearly_Income_to_Op'.$i.''];
            }

            if(isset($result['Client_Funds_on_Deposit_Estimated_Yearly_Income_to_Op'.$i.'']) && $result['Client_Funds_on_Deposit_Estimated_Yearly_Income_to_Op'.$i.''] !=''){
                $result['Funds_on_Deposit_Total_Estimated_Yearly_Income_to_Op']=$result['Funds_on_Deposit_Total_Estimated_Yearly_Income_to_Op']+$result['Client_Funds_on_Deposit_Estimated_Yearly_Income_to_Op'.$i.''];
            }

            if(isset($result['Op_Funds_on_Deposit_Estimated_Yearly_Income_to_Op'.$i.'']) && $result['Op_Funds_on_Deposit_Estimated_Yearly_Income_to_Op'.$i.''] !=''){
                $result['Funds_on_Deposit_Total_Estimated_Yearly_Income_to_Op']=$result['Funds_on_Deposit_Total_Estimated_Yearly_Income_to_Op']+$result['Op_Funds_on_Deposit_Estimated_Yearly_Income_to_Op'.$i.''];
            }

            // $result['Funds_on_Deposit_Total_Estimated_PropertyValue_to_Client']=0.00;

            if(isset($result['Joint_Funds_on_Deposit_Estimated_Value_to_Client'.$i.'']) && $result['Joint_Funds_on_Deposit_Estimated_Value_to_Client'.$i.''] !=''){
                $result['Funds_on_Deposit_Total_Estimated_PropertyValue_to_Client']=$result['Funds_on_Deposit_Total_Estimated_PropertyValue_to_Client']+$result['Joint_Funds_on_Deposit_Estimated_Value_to_Client'.$i.''];
            }

            if(isset($result['Client_Funds_on_Deposit_Estimated_Value_to_Client'.$i.'']) && $result['Client_Funds_on_Deposit_Estimated_Value_to_Client'.$i.''] !=''){
                $result['Funds_on_Deposit_Total_Estimated_PropertyValue_to_Client']=$result['Funds_on_Deposit_Total_Estimated_PropertyValue_to_Client']+$result['Client_Funds_on_Deposit_Estimated_Value_to_Client'.$i.''];
            }

            if(isset($result['Op_Funds_on_Deposit_Estimated_Value_to_Client'.$i.'']) && $result['Op_Funds_on_Deposit_Estimated_Value_to_Client'.$i.''] !=''){
                $result['Funds_on_Deposit_Total_Estimated_PropertyValue_to_Client']=$result['Funds_on_Deposit_Total_Estimated_PropertyValue_to_Client']+$result['Op_Funds_on_Deposit_Estimated_Value_to_Client'.$i.''];
            }

            // $result['Funds_on_Deposit_Total_Estimated_PropertyValue_to_Op']=0.00;

            if(isset($result['Joint_Funds_on_Deposit_Estimated_Value_to_Op'.$i.'']) && $result['Joint_Funds_on_Deposit_Estimated_Value_to_Op'.$i.''] !=''){
                $result['Funds_on_Deposit_Total_Estimated_PropertyValue_to_Op']=$result['Funds_on_Deposit_Total_Estimated_PropertyValue_to_Op']+$result['Joint_Funds_on_Deposit_Estimated_Value_to_Op'.$i.''];
            }

            if(isset($result['Client_Funds_on_Deposit_Estimated_Value_to_Op'.$i.'']) && $result['Client_Funds_on_Deposit_Estimated_Value_to_Op'.$i.''] !=''){
                $result['Funds_on_Deposit_Total_Estimated_PropertyValue_to_Op']=$result['Funds_on_Deposit_Total_Estimated_PropertyValue_to_Op']+$result['Client_Funds_on_Deposit_Estimated_Value_to_Op'.$i.''];
            }

            if(isset($result['Op_Funds_on_Deposit_Estimated_Value_to_Op'.$i.'']) && $result['Op_Funds_on_Deposit_Estimated_Value_to_Op'.$i.''] !=''){
                $result['Funds_on_Deposit_Total_Estimated_PropertyValue_to_Op']=$result['Funds_on_Deposit_Total_Estimated_PropertyValue_to_Op']+$result['Op_Funds_on_Deposit_Estimated_Value_to_Op'.$i.''];
            }

            
        }

        if(isset($result['Any_FOD']) && $result['Any_FOD']=='1'){
        } else {
            $result['Any_FOD']='0';
            $result['Num_Joint_Deposit_Accounts']=0;
            $result['Num_Client_Deposit_Accounts']=0;
            $result['Num_Op_Deposit_Accounts']=0;
        }

        if(isset($result['Num_Joint_Deposit_Accounts'])){
        } else {
            $result['Num_Joint_Deposit_Accounts']='0';
        }
        $Num_Joint_Deposit_Accounts=$result['Num_Joint_Deposit_Accounts'];
        $Num_Joint_Deposit_Accounts=$Num_Joint_Deposit_Accounts+1;
        for ($i=$Num_Joint_Deposit_Accounts; $i <= 10; $i++) { 
            $result['Joint_Funds_on_Deposit_Institution_ZIP'.$i.'']=NULL;
            $result['Joint_Funds_on_Deposit_Institution_Name'.$i.'']=NULL;
            $result['Joint_Funds_on_Deposit_Institution_Street_Address'.$i.'']=NULL;
            $result['Joint_Funds_on_Deposit_Institution_City'.$i.'']=NULL;
            $result['Joint_Funds_on_Deposit_Institution_State'.$i.'']=NULL;
            $result['Joint_Funds_on_Deposit_Institution_Acct_Num'.$i.'']=NULL;
            $result['Joint_Funds_on_Deposit_Institution_Current_Balance'.$i.'']=NULL;
            $result['Joint_Funds_on_Deposit_Estimated_MaritalEquity'.$i.'']=NULL;
            $result['Joint_Funds_on_Deposit_Institution_Yearly_Interest_Dividend'.$i.'']=NULL;
            $result['Joint_Funds_on_Deposit_SoleSeparate_Claim'.$i.'']=NULL;
            $result['Joint_Funds_on_Deposit_SoleSeparate_Party'.$i.'']=NULL;
            $result['Joint_Funds_on_Deposit_SoleSeparate_Grounds'.$i.'']=NULL;
            $result['Joint_Funds_on_Deposit_Percent_Marital_Equity_to_Client'.$i.'']=NULL;
            $result['Joint_Funds_on_Deposit_Percent_Marital_Equity_to_Op'.$i.'']=NULL;
            $result['Joint_Funds_on_Deposit_Estimated_Value_to_Client'.$i.'']=NULL;
            $result['Joint_Funds_on_Deposit_Estimated_Value_to_Op'.$i.'']=NULL;
            $result['Joint_Funds_on_Deposit_Estimated_Yearly_Income_to_Client'.$i.'']=NULL;
            $result['Joint_Funds_on_Deposit_Estimated_Yearly_Income_to_Op'.$i.'']=NULL;
        }

        if(isset($result['Num_Client_Deposit_Accounts'])){
        } else {
            $result['Num_Client_Deposit_Accounts']='0';
        }
        $Num_Client_Deposit_Accounts=$result['Num_Client_Deposit_Accounts'];
        $Num_Client_Deposit_Accounts=$Num_Client_Deposit_Accounts+1;
        for ($i=$Num_Client_Deposit_Accounts; $i <= 10; $i++) { 
            $result['Client_Funds_on_Deposit_Institution_ZIP'.$i.'']=NULL;
            $result['Client_Funds_on_Deposit_Institution_Name'.$i.'']=NULL;
            $result['Client_Funds_on_Deposit_Institution_Street_Address'.$i.'']=NULL;
            $result['Client_Funds_on_Deposit_Institution_City'.$i.'']=NULL;
            $result['Client_Funds_on_Deposit_Institution_State'.$i.'']=NULL;
            $result['Client_Funds_on_Deposit_Institution_Acct_Num'.$i.'']=NULL;
            $result['Client_Funds_on_Deposit_Institution_Name_on_Acct'.$i.'']=NULL;
            $result['Client_Funds_on_Deposit_Institution_Current_Balance'.$i.'']=NULL;
            $result['Client_Funds_on_Deposit_Institution_Yearly_Interest_Dividend'.$i.'']=NULL;
            $result['Client_Funds_on_Deposit_Institution_Balance_Date_of_Marriage'.$i.'']=NULL;
            $result['Client_Funds_on_Deposit_Estimated_MaritalEquity'.$i.'']=NULL;
            $result['Client_Funds_on_Deposit_SoleSeparate_Claim'.$i.'']=NULL;
            $result['Client_Funds_on_Deposit_SoleSeparate_Party'.$i.'']=NULL;
            $result['Client_Funds_on_Deposit_SoleSeparate_Grounds'.$i.'']=NULL;
            $result['Client_Funds_on_Deposit_Percent_Marital_Equity_to_Client'.$i.'']=NULL;
            $result['Client_Funds_on_Deposit_Percent_Marital_Equity_to_Op'.$i.'']=NULL;
            $result['Client_Funds_on_Deposit_Estimated_Value_to_Client'.$i.'']=NULL;
            $result['Client_Funds_on_Deposit_Estimated_Value_to_Op'.$i.'']=NULL;
            $result['Client_Funds_on_Deposit_Estimated_Yearly_Income_to_Client'.$i.'']=NULL;
            $result['Client_Funds_on_Deposit_Estimated_Yearly_Income_to_Op'.$i.'']=NULL;
        }

        if(isset($result['Num_Op_Deposit_Accounts'])){
        } else {
            $result['Num_Op_Deposit_Accounts']='0';
        }
        $Num_Op_Deposit_Accounts=$result['Num_Op_Deposit_Accounts'];
        $Num_Op_Deposit_Accounts=$Num_Op_Deposit_Accounts+1;
        for ($i=$Num_Op_Deposit_Accounts; $i <= 10; $i++) { 
            $result['Op_Funds_on_Deposit_Institution_ZIP'.$i.'']=NULL;
            $result['Op_Funds_on_Deposit_Institution_Name'.$i.'']=NULL;
            $result['Op_Funds_on_Deposit_Institution_Street_Address'.$i.'']=NULL;
            $result['Op_Funds_on_Deposit_Institution_City'.$i.'']=NULL;
            $result['Op_Funds_on_Deposit_Institution_State'.$i.'']=NULL;
            $result['Op_Funds_on_Deposit_Institution_Acct_Num'.$i.'']=NULL;
            $result['Op_Funds_on_Deposit_Institution_Name_on_Acct'.$i.'']=NULL;
            $result['Op_Funds_on_Deposit_Institution_Current_Balance'.$i.'']=NULL;
            $result['Op_Funds_on_Deposit_Institution_Yearly_Interest_Dividend'.$i.'']=NULL;
            $result['Op_Funds_on_Deposit_Institution_Balance_Date_of_Marriage'.$i.'']=NULL;
            $result['Op_Funds_on_Deposit_Estimated_MaritalEquity'.$i.'']=NULL;
            $result['Op_Funds_on_Deposit_SoleSeparate_Claim'.$i.'']=NULL;
            $result['Op_Funds_on_Deposit_SoleSeparate_Party'.$i.'']=NULL;
            $result['Op_Funds_on_Deposit_SoleSeparate_Grounds'.$i.'']=NULL;
            $result['Op_Funds_on_Deposit_Percent_Marital_Equity_to_Client'.$i.'']=NULL;
            $result['Op_Funds_on_Deposit_Percent_Marital_Equity_to_Op'.$i.'']=NULL;
            $result['Op_Funds_on_Deposit_Estimated_Value_to_Client'.$i.'']=NULL;
            $result['Op_Funds_on_Deposit_Estimated_Value_to_Op'.$i.'']=NULL;
            $result['Op_Funds_on_Deposit_Estimated_Yearly_Income_to_Client'.$i.'']=NULL;
            $result['Op_Funds_on_Deposit_Estimated_Yearly_Income_to_Op'.$i.'']=NULL;
        }
        
        // echo "<pre>";print_r($result);die;
        $DrFundsOnDeposit  = DrFundsOnDeposit::findOrFail($id);
        if($DrFundsOnDeposit){
            $DrFundsOnDeposit->fill($result)->save();
            // update case overview info.
            $drcaseoverview=DrCaseOverview::where('case_id',$result['case_id'])->get()->first();
            if(isset($drcaseoverview)){
                $drcaseoverview->Any_FOD=$result['Any_FOD'];
                $drcaseoverview->Num_Joint_Deposit_Accounts=$result['Num_Joint_Deposit_Accounts'];
                $drcaseoverview->Num_Client_Deposit_Accounts=$result['Num_Client_Deposit_Accounts'];
                $drcaseoverview->Num_Op_Deposit_Accounts=$result['Num_Op_Deposit_Accounts'];
                $drcaseoverview->save();
            } else {
                return redirect()->route('cases.family_law_interview_tabs',$result['case_id'])->with('error', 'Complete Case Overview Info Section First.');
            }
            return redirect()->route('drfundsondeposit.edit',$result['case_id'])->with('success', 'Funds On Deposit Information Updated Successfully.');
        } else {
            return redirect()->route('drfundsondeposit.edit',$result['case_id'])->with('error', 'Something went wrong. Please try Again.');
        }
    }
    
    public function destroy($id)
    {

    }

}
