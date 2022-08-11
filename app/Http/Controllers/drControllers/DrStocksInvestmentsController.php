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
use App\DrStocksInvestments;
use App\DrCaseOverview;


class DrStocksInvestmentsController extends Controller
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
        $data=DrStocksInvestments::orderBy('id','DESC')->get();
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

        $drstocksinvestments=DrStocksInvestments::where('case_id',$case_id)->get()->pluck('case_id');
        if(isset($drstocksinvestments['0'])){
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
        return view('dr_tables.dr_Stocks_Investments.create',['case_id'=> $case_id, 'client_name'=>$client_name, 'opponent_name'=>$opponent_name, 'drcaseoverview'=>$drcaseoverview]);
    }

    // save tab info in database table.
    public function store(Request $request)
    {
        $result = $request->except('submit');

        $result['StocksInvestments_Total_Marital_Equity']=0.00;
        $result['StocksInvestments_Client_Total_Marital_Equity']=0.00;
        $result['StocksInvestments_Op_Total_Marital_Equity']=0.00;
        $result['StocksInvestments_Total_Yearly_Income']=0.00;
        $result['StocksInvestments_Total_Yearly_Income_to_Client']=0.00;
        $result['StocksInvestments_Total_Yearly_Income_to_Op']=0.00;

        for ($i=1; $i <= 10; $i++) {
            unset($result[''.$i.'_Joint_StockInvestments_Estimated_Value_Select_Reset']);
            unset($result[''.$i.'_Client_StockInvestments_Estimated_Value_Select_Reset']);
            unset($result[''.$i.'_Op_StockInvestments_Estimated_Value_Select_Reset']);

            if(isset($result['Joint_StockInvestments_Current_Value'.$i.''])){
                $result['Joint_StockInvestments_Percent_Marital_Equity'.$i.'']=$result['Joint_StockInvestments_Current_Value'.$i.''];
            } else {
                $result['Joint_StockInvestments_Current_Value'.$i.'']=NULL;
                $result['Joint_StockInvestments_Percent_Marital_Equity'.$i.'']=NULL;
            }

            if(isset($result['Client_StockInvestments_Current_Value'.$i.''])){
                $result['Client_StockInvestments_Percent_Marital_Equity'.$i.'']=$result['Client_StockInvestments_Current_Value'.$i.''];
            } else {
                $result['Client_StockInvestments_Current_Value'.$i.'']=NULL;
                $result['Client_StockInvestments_Percent_Marital_Equity'.$i.'']=NULL;
            }

            if(isset($result['Op_StockInvestments_Current_Value'.$i.''])){
                $result['Op_StockInvestments_Percent_Marital_Equity'.$i.'']=$result['Op_StockInvestments_Current_Value'.$i.''];
            } else {
                $result['Op_StockInvestments_Current_Value'.$i.'']=NULL;
                $result['Op_StockInvestments_Percent_Marital_Equity'.$i.'']=NULL;
            }
            
            if(isset($result['Joint_StockInvestments_Disposition_Method'.$i.'']) && $result['Joint_StockInvestments_Disposition_Method'.$i.''] !='Fixed Buyout'){
                $result['Joint_StockInvestments_Paying_Party'.$i.'']=NULL;
            }

            if(isset($result['Client_StockInvestments_Disposition_Method'.$i.'']) && $result['Client_StockInvestments_Disposition_Method'.$i.''] !='Fixed Buyout'){
                $result['Client_StockInvestments_Paying_Party'.$i.'']=NULL;
            }

            if(isset($result['Op_StockInvestments_Disposition_Method'.$i.'']) && $result['Op_StockInvestments_Disposition_Method'.$i.''] !='Fixed Buyout'){
                $result['Op_StockInvestments_Paying_Party'.$i.'']=NULL;
            }

            // new calculations
            // for joint
            $result['Joint_StockInvestments_MaritalEquity'.$i.'']=0.00;
            if(isset($result['Joint_StockInvestments_Current_Value'.$i.'']) && $result['Joint_StockInvestments_Current_Value'.$i.''] !='' && !isset($result['Joint_StockInvestments_Date_Marriage_Value'.$i.''])){
                $result['Joint_StockInvestments_MaritalEquity'.$i.'']=$result['Joint_StockInvestments_Current_Value'.$i.''];
            }
            if(isset($result['Joint_StockInvestments_Date_Marriage_Value'.$i.'']) && $result['Joint_StockInvestments_Date_Marriage_Value'.$i.''] !='' && !isset($result['Joint_StockInvestments_Current_Value'.$i.''])){
                $result['Joint_StockInvestments_MaritalEquity'.$i.'']=$result['Joint_StockInvestments_Date_Marriage_Value'.$i.''];
            }
            if(isset($result['Joint_StockInvestments_Current_Value'.$i.'']) && $result['Joint_StockInvestments_Current_Value'.$i.''] !='' && isset($result['Joint_StockInvestments_Date_Marriage_Value'.$i.'']) && $result['Joint_StockInvestments_Date_Marriage_Value'.$i.''] !=''){
                $result['Joint_StockInvestments_MaritalEquity'.$i.'']=$result['Joint_StockInvestments_Current_Value'.$i.'']-$result['Joint_StockInvestments_Date_Marriage_Value'.$i.''];
            }
            $result['Joint_StockInvestments_Estimated_Yearly_Income_to_Client'.$i.'']=0.00;
            if(isset($result['Joint_StockInvestments_Percent_Marital_Equity_to_Client'.$i.'']) && $result['Joint_StockInvestments_Percent_Marital_Equity_to_Client'.$i.''] !='' && !isset($result['Joint_StockInvestments_Yearly_Interest_Dividend'.$i.''])){
                $result['Joint_StockInvestments_Estimated_Yearly_Income_to_Client'.$i.'']=$result['Joint_StockInvestments_Percent_Marital_Equity_to_Client'.$i.''];
            }
            if(isset($result['Joint_StockInvestments_Yearly_Interest_Dividend'.$i.'']) && $result['Joint_StockInvestments_Yearly_Interest_Dividend'.$i.''] !='' && !isset($result['Joint_StockInvestments_Percent_Marital_Equity_to_Client'.$i.''])){
                $result['Joint_StockInvestments_Estimated_Yearly_Income_to_Client'.$i.'']=$result['Joint_StockInvestments_Yearly_Interest_Dividend'.$i.''];
            }
            if(isset($result['Joint_StockInvestments_Percent_Marital_Equity_to_Client'.$i.'']) && $result['Joint_StockInvestments_Percent_Marital_Equity_to_Client'.$i.''] !='' && isset($result['Joint_StockInvestments_Yearly_Interest_Dividend'.$i.'']) && $result['Joint_StockInvestments_Yearly_Interest_Dividend'.$i.''] !=''){
                $result['Joint_StockInvestments_Estimated_Yearly_Income_to_Client'.$i.'']=$result['Joint_StockInvestments_Percent_Marital_Equity_to_Client'.$i.'']*$result['Joint_StockInvestments_Yearly_Interest_Dividend'.$i.''];
            }
            $result['Joint_StockInvestments_Estimated_Yearly_Income_to_Op'.$i.'']=0.00;
            if(isset($result['Joint_StockInvestments_Yearly_Interest_Dividend'.$i.'']) && $result['Joint_StockInvestments_Yearly_Interest_Dividend'.$i.''] !='' && !isset($result['Joint_StockInvestments_Estimated_Yearly_Income_to_Client'.$i.''])){
                $result['Joint_StockInvestments_Estimated_Yearly_Income_to_Op'.$i.'']=$result['Joint_StockInvestments_Yearly_Interest_Dividend'.$i.''];
            }
            if(isset($result['Joint_StockInvestments_Estimated_Yearly_Income_to_Client'.$i.'']) && $result['Joint_StockInvestments_Estimated_Yearly_Income_to_Client'.$i.''] !='' && !isset($result['Joint_StockInvestments_Yearly_Interest_Dividend'.$i.''])){
                $result['Joint_StockInvestments_Estimated_Yearly_Income_to_Op'.$i.'']=$result['Joint_StockInvestments_Estimated_Yearly_Income_to_Client'.$i.''];
            }
            if(isset($result['Joint_StockInvestments_Yearly_Interest_Dividend'.$i.'']) && $result['Joint_StockInvestments_Yearly_Interest_Dividend'.$i.''] !='' && isset($result['Joint_StockInvestments_Estimated_Yearly_Income_to_Client'.$i.'']) && $result['Joint_StockInvestments_Estimated_Yearly_Income_to_Client'.$i.''] !=''){
                $result['Joint_StockInvestments_Estimated_Yearly_Income_to_Op'.$i.'']=$result['Joint_StockInvestments_Yearly_Interest_Dividend'.$i.'']-$result['Joint_StockInvestments_Estimated_Yearly_Income_to_Client'.$i.''];
            }

            // for client
            $result['Client_StockInvestments_MaritalEquity'.$i.'']=0.00;
            if(isset($result['Client_StockInvestments_Current_Value'.$i.'']) && $result['Client_StockInvestments_Current_Value'.$i.''] !='' && !isset($result['Client_StockInvestments_Date_Marriage_Value'.$i.''])){
                $result['Client_StockInvestments_MaritalEquity'.$i.'']=$result['Client_StockInvestments_Current_Value'.$i.''];
            }
            if(isset($result['Client_StockInvestments_Date_Marriage_Value'.$i.'']) && $result['Client_StockInvestments_Date_Marriage_Value'.$i.''] !='' && !isset($result['Client_StockInvestments_Current_Value'.$i.''])){
                $result['Client_StockInvestments_MaritalEquity'.$i.'']=$result['Client_StockInvestments_Date_Marriage_Value'.$i.''];
            }
            if(isset($result['Client_StockInvestments_Current_Value'.$i.'']) && $result['Client_StockInvestments_Current_Value'.$i.''] !='' && isset($result['Client_StockInvestments_Date_Marriage_Value'.$i.'']) && $result['Client_StockInvestments_Date_Marriage_Value'.$i.''] !=''){
                $result['Client_StockInvestments_MaritalEquity'.$i.'']=$result['Client_StockInvestments_Current_Value'.$i.'']-$result['Client_StockInvestments_Date_Marriage_Value'.$i.''];
            }
            $result['Client_StockInvestments_Estimated_Yearly_Income_to_Client'.$i.'']=0.00;
            if(isset($result['Client_StockInvestments_Percent_Marital_Equity_to_Client'.$i.'']) && $result['Client_StockInvestments_Percent_Marital_Equity_to_Client'.$i.''] !='' && !isset($result['Client_StockInvestments_Yearly_Interest_Dividend'.$i.''])){
                $result['Client_StockInvestments_Estimated_Yearly_Income_to_Client'.$i.'']=$result['Client_StockInvestments_Percent_Marital_Equity_to_Client'.$i.''];
            }
            if(isset($result['Client_StockInvestments_Yearly_Interest_Dividend'.$i.'']) && $result['Client_StockInvestments_Yearly_Interest_Dividend'.$i.''] !='' && !isset($result['Client_StockInvestments_Percent_Marital_Equity_to_Client'.$i.''])){
                $result['Client_StockInvestments_Estimated_Yearly_Income_to_Client'.$i.'']=$result['Client_StockInvestments_Yearly_Interest_Dividend'.$i.''];
            }
            if(isset($result['Client_StockInvestments_Percent_Marital_Equity_to_Client'.$i.'']) && $result['Client_StockInvestments_Percent_Marital_Equity_to_Client'.$i.''] !='' && isset($result['Client_StockInvestments_Yearly_Interest_Dividend'.$i.'']) && $result['Client_StockInvestments_Yearly_Interest_Dividend'.$i.''] !=''){
                $result['Client_StockInvestments_Estimated_Yearly_Income_to_Client'.$i.'']=$result['Client_StockInvestments_Percent_Marital_Equity_to_Client'.$i.'']*$result['Client_StockInvestments_Yearly_Interest_Dividend'.$i.''];
            }
            $result['Client_StockInvestments_Estimated_Yearly_Income_to_Op'.$i.'']=0.00;
            if(isset($result['Client_StockInvestments_Yearly_Interest_Dividend'.$i.'']) && $result['Client_StockInvestments_Yearly_Interest_Dividend'.$i.''] !='' && !isset($result['Client_StockInvestments_Estimated_Yearly_Income_to_Client'.$i.''])){
                $result['Client_StockInvestments_Estimated_Yearly_Income_to_Op'.$i.'']=$result['Client_StockInvestments_Yearly_Interest_Dividend'.$i.''];
            }
            if(isset($result['Client_StockInvestments_Estimated_Yearly_Income_to_Client'.$i.'']) && $result['Client_StockInvestments_Estimated_Yearly_Income_to_Client'.$i.''] !='' && !isset($result['Client_StockInvestments_Yearly_Interest_Dividend'.$i.''])){
                $result['Client_StockInvestments_Estimated_Yearly_Income_to_Op'.$i.'']=$result['Client_StockInvestments_Estimated_Yearly_Income_to_Client'.$i.''];
            }
            if(isset($result['Client_StockInvestments_Yearly_Interest_Dividend'.$i.'']) && $result['Client_StockInvestments_Yearly_Interest_Dividend'.$i.''] !='' && isset($result['Client_StockInvestments_Estimated_Yearly_Income_to_Client'.$i.'']) && $result['Client_StockInvestments_Estimated_Yearly_Income_to_Client'.$i.''] !=''){
                $result['Client_StockInvestments_Estimated_Yearly_Income_to_Op'.$i.'']=$result['Client_StockInvestments_Yearly_Interest_Dividend'.$i.'']-$result['Client_StockInvestments_Estimated_Yearly_Income_to_Client'.$i.''];
            }

            // for opponent
            $result['Op_StockInvestments_MaritalEquity'.$i.'']=0.00;
            if(isset($result['Op_StockInvestments_Current_Value'.$i.'']) && $result['Op_StockInvestments_Current_Value'.$i.''] !='' && !isset($result['Op_StockInvestments_Date_Marriage_Value'.$i.''])){
                $result['Op_StockInvestments_MaritalEquity'.$i.'']=$result['Op_StockInvestments_Current_Value'.$i.''];
            }
            if(isset($result['Op_StockInvestments_Date_Marriage_Value'.$i.'']) && $result['Op_StockInvestments_Date_Marriage_Value'.$i.''] !='' && !isset($result['Op_StockInvestments_Current_Value'.$i.''])){
                $result['Op_StockInvestments_MaritalEquity'.$i.'']=$result['Op_StockInvestments_Date_Marriage_Value'.$i.''];
            }
            if(isset($result['Op_StockInvestments_Current_Value'.$i.'']) && $result['Op_StockInvestments_Current_Value'.$i.''] !='' && isset($result['Op_StockInvestments_Date_Marriage_Value'.$i.'']) && $result['Op_StockInvestments_Date_Marriage_Value'.$i.''] !=''){
                $result['Op_StockInvestments_MaritalEquity'.$i.'']=$result['Op_StockInvestments_Current_Value'.$i.'']-$result['Op_StockInvestments_Date_Marriage_Value'.$i.''];
            }
            $result['Op_StockInvestments_Estimated_Yearly_Income_to_Client'.$i.'']=0.00;
            if(isset($result['Op_StockInvestments_Percent_Marital_Equity_to_Client'.$i.'']) && $result['Op_StockInvestments_Percent_Marital_Equity_to_Client'.$i.''] !='' && !isset($result['Op_StockInvestments_Yearly_Interest_Dividend'.$i.''])){
                $result['Op_StockInvestments_Estimated_Yearly_Income_to_Client'.$i.'']=$result['Op_StockInvestments_Percent_Marital_Equity_to_Client'.$i.''];
            }
            if(isset($result['Op_StockInvestments_Yearly_Interest_Dividend'.$i.'']) && $result['Op_StockInvestments_Yearly_Interest_Dividend'.$i.''] !='' && !isset($result['Op_StockInvestments_Percent_Marital_Equity_to_Client'.$i.''])){
                $result['Op_StockInvestments_Estimated_Yearly_Income_to_Client'.$i.'']=$result['Op_StockInvestments_Yearly_Interest_Dividend'.$i.''];
            }
            if(isset($result['Op_StockInvestments_Percent_Marital_Equity_to_Client'.$i.'']) && $result['Op_StockInvestments_Percent_Marital_Equity_to_Client'.$i.''] !='' && isset($result['Op_StockInvestments_Yearly_Interest_Dividend'.$i.'']) && $result['Op_StockInvestments_Yearly_Interest_Dividend'.$i.''] !=''){
                $result['Op_StockInvestments_Estimated_Yearly_Income_to_Client'.$i.'']=$result['Op_StockInvestments_Percent_Marital_Equity_to_Client'.$i.'']*$result['Op_StockInvestments_Yearly_Interest_Dividend'.$i.''];
            }
            $result['Op_StockInvestments_Estimated_Yearly_Income_to_Op'.$i.'']=0.00;
            if(isset($result['Op_StockInvestments_Yearly_Interest_Dividend'.$i.'']) && $result['Op_StockInvestments_Yearly_Interest_Dividend'.$i.''] !='' && !isset($result['Op_StockInvestments_Estimated_Yearly_Income_to_Client'.$i.''])){
                $result['Op_StockInvestments_Estimated_Yearly_Income_to_Op'.$i.'']=$result['Op_StockInvestments_Yearly_Interest_Dividend'.$i.''];
            }
            if(isset($result['Op_StockInvestments_Estimated_Yearly_Income_to_Client'.$i.'']) && $result['Op_StockInvestments_Estimated_Yearly_Income_to_Client'.$i.''] !='' && !isset($result['Op_StockInvestments_Yearly_Interest_Dividend'.$i.''])){
                $result['Op_StockInvestments_Estimated_Yearly_Income_to_Op'.$i.'']=$result['Op_StockInvestments_Estimated_Yearly_Income_to_Client'.$i.''];
            }
            if(isset($result['Op_StockInvestments_Yearly_Interest_Dividend'.$i.'']) && $result['Op_StockInvestments_Yearly_Interest_Dividend'.$i.''] !='' && isset($result['Op_StockInvestments_Estimated_Yearly_Income_to_Client'.$i.'']) && $result['Op_StockInvestments_Estimated_Yearly_Income_to_Client'.$i.''] !=''){
                $result['Op_StockInvestments_Estimated_Yearly_Income_to_Op'.$i.'']=$result['Op_StockInvestments_Yearly_Interest_Dividend'.$i.'']-$result['Op_StockInvestments_Estimated_Yearly_Income_to_Client'.$i.''];
            }

            // for all accounts
            if(isset($result['Joint_StockInvestments_MaritalEquity'.$i.'']) && $result['Joint_StockInvestments_MaritalEquity'.$i.'']!=''){
                $result['StocksInvestments_Total_Marital_Equity']=$result['StocksInvestments_Total_Marital_Equity']+$result['Joint_StockInvestments_MaritalEquity'.$i.''];
            }
            if(isset($result['Client_StockInvestments_MaritalEquity'.$i.'']) && $result['Client_StockInvestments_MaritalEquity'.$i.'']!=''){
                $result['StocksInvestments_Total_Marital_Equity']=$result['StocksInvestments_Total_Marital_Equity']+$result['Client_StockInvestments_MaritalEquity'.$i.''];
            }
            if(isset($result['Op_StockInvestments_MaritalEquity'.$i.'']) && $result['Op_StockInvestments_MaritalEquity'.$i.'']!=''){
                $result['StocksInvestments_Total_Marital_Equity']=$result['StocksInvestments_Total_Marital_Equity']+$result['Op_StockInvestments_MaritalEquity'.$i.''];
            }

            if(isset($result['Joint_StockInvestments_Estimated_Value_to_Client'.$i.'']) && $result['Joint_StockInvestments_Estimated_Value_to_Client'.$i.'']!=''){
                $result['StocksInvestments_Client_Total_Marital_Equity']=$result['StocksInvestments_Client_Total_Marital_Equity']+$result['Joint_StockInvestments_Estimated_Value_to_Client'.$i.''];
            }
            if(isset($result['Client_StockInvestments_Estimated_Value_to_Client'.$i.'']) && $result['Client_StockInvestments_Estimated_Value_to_Client'.$i.'']!=''){
                $result['StocksInvestments_Client_Total_Marital_Equity']=$result['StocksInvestments_Client_Total_Marital_Equity']+$result['Client_StockInvestments_Estimated_Value_to_Client'.$i.''];
            }
            if(isset($result['Op_StockInvestments_Estimated_Value_to_Client'.$i.'']) && $result['Op_StockInvestments_Estimated_Value_to_Client'.$i.'']!=''){
                $result['StocksInvestments_Client_Total_Marital_Equity']=$result['StocksInvestments_Client_Total_Marital_Equity']+$result['Op_StockInvestments_Estimated_Value_to_Client'.$i.''];
            }

            if(isset($result['Joint_StockInvestments_Estimated_Value_to_Op'.$i.'']) && $result['Joint_StockInvestments_Estimated_Value_to_Op'.$i.'']!=''){
                $result['StocksInvestments_Op_Total_Marital_Equity']=$result['StocksInvestments_Op_Total_Marital_Equity']+$result['Joint_StockInvestments_Estimated_Value_to_Op'.$i.''];
            }
            if(isset($result['Client_StockInvestments_Estimated_Value_to_Op'.$i.'']) && $result['Client_StockInvestments_Estimated_Value_to_Op'.$i.'']!=''){
                $result['StocksInvestments_Op_Total_Marital_Equity']=$result['StocksInvestments_Op_Total_Marital_Equity']+$result['Client_StockInvestments_Estimated_Value_to_Op'.$i.''];
            }
            if(isset($result['Op_StockInvestments_Estimated_Value_to_Op'.$i.'']) && $result['Op_StockInvestments_Estimated_Value_to_Op'.$i.'']!=''){
                $result['StocksInvestments_Op_Total_Marital_Equity']=$result['StocksInvestments_Op_Total_Marital_Equity']+$result['Op_StockInvestments_Estimated_Value_to_Op'.$i.''];
            }

            if(isset($result['Joint_StockInvestments_Yearly_Interest_Dividend'.$i.'']) && $result['Joint_StockInvestments_Yearly_Interest_Dividend'.$i.'']!=''){
                $result['StocksInvestments_Total_Yearly_Income']=$result['StocksInvestments_Total_Yearly_Income']+$result['Joint_StockInvestments_Yearly_Interest_Dividend'.$i.''];
            }
            if(isset($result['Client_StockInvestments_Yearly_Interest_Dividend'.$i.'']) && $result['Client_StockInvestments_Yearly_Interest_Dividend'.$i.'']!=''){
                $result['StocksInvestments_Total_Yearly_Income']=$result['StocksInvestments_Total_Yearly_Income']+$result['Client_StockInvestments_Yearly_Interest_Dividend'.$i.''];
            }
            if(isset($result['Op_StockInvestments_Yearly_Interest_Dividend'.$i.'']) && $result['Op_StockInvestments_Yearly_Interest_Dividend'.$i.'']!=''){
                $result['StocksInvestments_Total_Yearly_Income']=$result['StocksInvestments_Total_Yearly_Income']+$result['Op_StockInvestments_Yearly_Interest_Dividend'.$i.''];
            }

            if(isset($result['Joint_StockInvestments_Estimated_Yearly_Income_to_Client'.$i.'']) && $result['Joint_StockInvestments_Estimated_Yearly_Income_to_Client'.$i.'']!=''){
                $result['StocksInvestments_Total_Yearly_Income_to_Client']=$result['StocksInvestments_Total_Yearly_Income_to_Client']+$result['Joint_StockInvestments_Estimated_Yearly_Income_to_Client'.$i.''];
            }
            if(isset($result['Client_StockInvestments_Estimated_Yearly_Income_to_Client'.$i.'']) && $result['Client_StockInvestments_Estimated_Yearly_Income_to_Client'.$i.'']!=''){
                $result['StocksInvestments_Total_Yearly_Income_to_Client']=$result['StocksInvestments_Total_Yearly_Income_to_Client']+$result['Client_StockInvestments_Estimated_Yearly_Income_to_Client'.$i.''];
            }
            if(isset($result['Op_StockInvestments_Estimated_Yearly_Income_to_Client'.$i.'']) && $result['Op_StockInvestments_Estimated_Yearly_Income_to_Client'.$i.'']!=''){
                $result['StocksInvestments_Total_Yearly_Income_to_Client']=$result['StocksInvestments_Total_Yearly_Income_to_Client']+$result['Op_StockInvestments_Estimated_Yearly_Income_to_Client'.$i.''];
            }

            if(isset($result['Joint_StockInvestments_Estimated_Yearly_Income_to_Op'.$i.'']) && $result['Joint_StockInvestments_Estimated_Yearly_Income_to_Op'.$i.'']!=''){
                $result['StocksInvestments_Total_Yearly_Income_to_Op']=$result['StocksInvestments_Total_Yearly_Income_to_Op']+$result['Joint_StockInvestments_Estimated_Yearly_Income_to_Op'.$i.''];
            }
            if(isset($result['Client_StockInvestments_Estimated_Yearly_Income_to_Op'.$i.'']) && $result['Client_StockInvestments_Estimated_Yearly_Income_to_Op'.$i.'']!=''){
                $result['StocksInvestments_Total_Yearly_Income_to_Op']=$result['StocksInvestments_Total_Yearly_Income_to_Op']+$result['Client_StockInvestments_Estimated_Yearly_Income_to_Op'.$i.''];
            }
            if(isset($result['Op_StockInvestments_Estimated_Yearly_Income_to_Op'.$i.'']) && $result['Op_StockInvestments_Estimated_Yearly_Income_to_Op'.$i.'']!=''){
                $result['StocksInvestments_Total_Yearly_Income_to_Op']=$result['StocksInvestments_Total_Yearly_Income_to_Op']+$result['Op_StockInvestments_Estimated_Yearly_Income_to_Op'.$i.''];
            }
            
        }

        if(isset($result['Any_Stocks_Investments_Accounts']) && $result['Any_Stocks_Investments_Accounts']=='1'){
        } else {
            $result['Any_Stocks_Investments_Accounts']='0';
            $result['Num_Joint_StocksInvestments_Accounts']=0;
            $result['Num_Client_StockInvestments_Accounts']=0;
            $result['Num_Op_StockInvestments_Accounts']=0;
        }

        if(isset($result['Num_Joint_StocksInvestments_Accounts'])){
        } else {
            $result['Num_Joint_StocksInvestments_Accounts']='0';
        }
        $Num_Joint_StocksInvestments_Accounts=$result['Num_Joint_StocksInvestments_Accounts'];
        $Num_Joint_StocksInvestments_Accounts=$Num_Joint_StocksInvestments_Accounts+1;
        for ($i=$Num_Joint_StocksInvestments_Accounts; $i <= 10; $i++) { 
            $result['Joint_StockInvestments_Institution_ZIP'.$i.'']=NULL;
            $result['Joint_StockInvestments_Institution_Name'.$i.'']=NULL;
            $result['Joint_StockInvestments_Institution_Street_Address'.$i.'']=NULL;
            $result['Joint_StockInvestments_Institution_City'.$i.'']=NULL;
            $result['Joint_StockInvestments_Institution_State'.$i.'']=NULL;
            $result['Joint_StockInvestments_Acct_Num'.$i.'']=NULL;
            $result['Joint_StockInvestments_Current_Value'.$i.'']=NULL;
            $result['Joint_StockInvestments_Percent_Marital_Equity'.$i.'']=NULL;
            $result['Joint_StockInvestments_Yearly_Interest_Dividend'.$i.'']=NULL;
            $result['Joint_StockInvestments_SoleSeparate_Claim'.$i.'']=NULL;
            $result['Joint_StockInvestments_SoleSeparate_Party'.$i.'']=NULL;
            $result['Joint_StockInvestments_SoleSeparate_Grounds'.$i.'']=NULL;
            $result['Joint_StockInvestments_Disposition_Method'.$i.'']=NULL;
            $result['Joint_StockInvestments_Percent_Marital_Equity_to_Client'.$i.'']=NULL;
            $result['Joint_StockInvestments_Percent_Marital_Equity_to_Op'.$i.'']=NULL;
            $result['Joint_StockInvestments_Estimated_Value_to_Client'.$i.'']=NULL;
            $result['Joint_StockInvestments_Estimated_Value_to_Op'.$i.'']=NULL;
            $result['Joint_StockInvestments_Paying_Party'.$i.'']=NULL;
            $result['Joint_StockInvestments_Date_Marriage_Value'.$i.'']=NULL;
            $result['Joint_StockInvestments_MaritalEquity'.$i.'']=NULL;
            $result['Joint_StockInvestments_Estimated_Yearly_Income_to_Client'.$i.'']=NULL;
            $result['Joint_StockInvestments_Estimated_Yearly_Income_to_Op'.$i.'']=NULL;
            
        }

        if(isset($result['Num_Client_StockInvestments_Accounts'])){
        } else {
            $result['Num_Client_StockInvestments_Accounts']='0';
        }
        $Num_Client_StockInvestments_Accounts=$result['Num_Client_StockInvestments_Accounts'];
        $Num_Client_StockInvestments_Accounts=$Num_Client_StockInvestments_Accounts+1;
        for ($i=$Num_Client_StockInvestments_Accounts; $i <= 10; $i++) { 
            $result['Client_StockInvestments_Institution_ZIP'.$i.'']=NULL;
            $result['Client_StockInvestments_Institution_Name'.$i.'']=NULL;
            $result['Client_StockInvestments_Institution_Street_Address'.$i.'']=NULL;
            $result['Client_StockInvestments_Institution_City'.$i.'']=NULL;
            $result['Client_StockInvestments_Institution_State'.$i.'']=NULL;
            $result['Client_StockInvestments_Acct_Num'.$i.'']=NULL;
            $result['Client_StockInvestments_Current_Value'.$i.'']=NULL;
            $result['Client_StockInvestments_Percent_Marital_Equity'.$i.'']=NULL;
            $result['Client_StockInvestments_Yearly_Interest_Dividend'.$i.'']=NULL;
            $result['Client_StockInvestments_SoleSeparate_Claim'.$i.'']=NULL;
            $result['Client_StockInvestments_SoleSeparate_Party'.$i.'']=NULL;
            $result['Client_StockInvestments_SoleSeparate_Grounds'.$i.'']=NULL;
            $result['Client_StockInvestments_Disposition_Method'.$i.'']=NULL;
            $result['Client_StockInvestments_Percent_Marital_Equity_to_Client'.$i.'']=NULL;
            $result['Client_StockInvestments_Percent_Marital_Equity_to_Op'.$i.'']=NULL;
            $result['Client_StockInvestments_Estimated_Value_to_Client'.$i.'']=NULL;
            $result['Client_StockInvestments_Estimated_Value_to_Op'.$i.'']=NULL;
            $result['Client_StockInvestments_Paying_Party'.$i.'']=NULL;
            $result['Client_StockInvestments_Date_Marriage_Value'.$i.'']=NULL;
            $result['Client_StockInvestments_MaritalEquity'.$i.'']=NULL;
            $result['Client_StockInvestments_Estimated_Yearly_Income_to_Client'.$i.'']=NULL;
            $result['Client_StockInvestments_Estimated_Yearly_Income_to_Op'.$i.'']=NULL;
            
        }

        if(isset($result['Num_Op_StockInvestments_Accounts'])){
        } else {
            $result['Num_Op_StockInvestments_Accounts']='0';
        }
        $Num_Op_StockInvestments_Accounts=$result['Num_Op_StockInvestments_Accounts'];
        $Num_Op_StockInvestments_Accounts=$Num_Op_StockInvestments_Accounts+1;
        for ($i=$Num_Op_StockInvestments_Accounts; $i <= 10; $i++) { 
            $result['Op_StockInvestments_Institution_ZIP'.$i.'']=NULL;
            $result['Op_StockInvestments_Institution_Name'.$i.'']=NULL;
            $result['Op_StockInvestments_Institution_Street_Address'.$i.'']=NULL;
            $result['Op_StockInvestments_Institution_City'.$i.'']=NULL;
            $result['Op_StockInvestments_Institution_State'.$i.'']=NULL;
            $result['Op_StockInvestments_Acct_Num'.$i.'']=NULL;
            $result['Op_StockInvestments_Current_Value'.$i.'']=NULL;
            $result['Op_StockInvestments_Percent_Marital_Equity'.$i.'']=NULL;
            $result['Op_StockInvestments_Yearly_Interest_Dividend'.$i.'']=NULL;
            $result['Op_StockInvestments_SoleSeparate_Claim'.$i.'']=NULL;
            $result['Op_StockInvestments_SoleSeparate_Party'.$i.'']=NULL;
            $result['Op_StockInvestments_SoleSeparate_Grounds'.$i.'']=NULL;
            $result['Op_StockInvestments_Disposition_Method'.$i.'']=NULL;
            $result['Op_StockInvestments_Percent_Marital_Equity_to_Client'.$i.'']=NULL;
            $result['Op_StockInvestments_Percent_Marital_Equity_to_Op'.$i.'']=NULL;
            $result['Op_StockInvestments_Estimated_Value_to_Client'.$i.'']=NULL;
            $result['Op_StockInvestments_Estimated_Value_to_Op'.$i.'']=NULL;
            $result['Op_StockInvestments_Paying_Party'.$i.'']=NULL;
            $result['Op_StockInvestments_Date_Marriage_Value'.$i.'']=NULL;
            $result['Op_StockInvestments_MaritalEquity'.$i.'']=NULL;
            $result['Op_StockInvestments_Estimated_Yearly_Income_to_Client'.$i.'']=NULL;
            $result['Op_StockInvestments_Estimated_Yearly_Income_to_Op'.$i.'']=NULL;
            
        }
        
        // echo "<pre>";print_r($result);die;
        $drstocksinvestments=DrStocksInvestments::create($result);
        // update case overview info.
        $drcaseoverview=DrCaseOverview::where('case_id',$result['case_id'])->get()->first();
        if(isset($drcaseoverview)){
            $drcaseoverview->Any_Stocks_Investments_Accounts=$result['Any_Stocks_Investments_Accounts'];
            $drcaseoverview->Num_Joint_StocksInvestments_Accounts=$result['Num_Joint_StocksInvestments_Accounts'];
            $drcaseoverview->Num_Client_StockInvestments_Accounts=$result['Num_Client_StockInvestments_Accounts'];
            $drcaseoverview->Num_Op_StockInvestments_Accounts=$result['Num_Op_StockInvestments_Accounts'];
            $drcaseoverview->save();
        } else {
            return redirect()->route('cases.family_law_interview_tabs',$result['case_id'])->with('error', 'Complete Case Overview Info Section First.');
        }
        
        return redirect()->route('cases.family_law_interview_tabs',$result['case_id'])->with('success', 'Stocks Investments Information Submitted Successfully.');
        
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
        $drstocksinvestments=DrStocksInvestments::where('case_id',$case_id)->get()->first();
         // echo "<pre>";print_r($drstocksinvestments);//die;
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
         // echo "<pre>";print_r($drstocksinvestments);die;
        $drcaseoverview=DrCaseOverview::where('case_id',$case_id)->get()->first();
        if($drstocksinvestments){
            if(isset($drcaseoverview)){
                if(isset($drcaseoverview) && $drcaseoverview->Any_Stocks_Investments_Accounts==$drstocksinvestments->Any_Stocks_Investments_Accounts && $drcaseoverview->Num_Joint_StocksInvestments_Accounts==$drstocksinvestments->Num_Joint_StocksInvestments_Accounts && $drcaseoverview->Num_Client_StockInvestments_Accounts==$drstocksinvestments->Num_Client_StockInvestments_Accounts && $drcaseoverview->Num_Op_StockInvestments_Accounts==$drstocksinvestments->Num_Op_StockInvestments_Accounts)
                {

                } else {
                    $drstocksinvestments->Any_Stocks_Investments_Accounts=$drcaseoverview->Any_Stocks_Investments_Accounts;
                    $drstocksinvestments->Num_Joint_StocksInvestments_Accounts=$drcaseoverview->Num_Joint_StocksInvestments_Accounts;
                    $drstocksinvestments->Num_Client_StockInvestments_Accounts=$drcaseoverview->Num_Client_StockInvestments_Accounts;
                    $drstocksinvestments->Num_Op_StockInvestments_Accounts=$drcaseoverview->Num_Op_StockInvestments_Accounts;
                }

            }
            return view('dr_tables.dr_Stocks_Investments.edit',['case_id'=> $case_id, 'client_name'=>$client_name, 'opponent_name'=>$opponent_name, 'drstocksinvestments' => $drstocksinvestments]);
        } else {
            return redirect()->route('home');
        }
        
    }

    public function update(Request $request, $id)
    {
        $result = $request->except('submit','_method','_token');

        $result['StocksInvestments_Total_Marital_Equity']=0.00;
        $result['StocksInvestments_Client_Total_Marital_Equity']=0.00;
        $result['StocksInvestments_Op_Total_Marital_Equity']=0.00;
        $result['StocksInvestments_Total_Yearly_Income']=0.00;
        $result['StocksInvestments_Total_Yearly_Income_to_Client']=0.00;
        $result['StocksInvestments_Total_Yearly_Income_to_Op']=0.00;

        for ($i=1; $i <= 10; $i++) {
            unset($result[''.$i.'_Joint_StockInvestments_Estimated_Value_Select_Reset']);
            unset($result[''.$i.'_Client_StockInvestments_Estimated_Value_Select_Reset']);
            unset($result[''.$i.'_Op_StockInvestments_Estimated_Value_Select_Reset']);

            if(isset($result['Joint_StockInvestments_Current_Value'.$i.''])){
                $result['Joint_StockInvestments_Percent_Marital_Equity'.$i.'']=$result['Joint_StockInvestments_Current_Value'.$i.''];
            } else {
                $result['Joint_StockInvestments_Current_Value'.$i.'']=NULL;
                $result['Joint_StockInvestments_Percent_Marital_Equity'.$i.'']=NULL;
            }

            if(isset($result['Client_StockInvestments_Current_Value'.$i.''])){
                $result['Client_StockInvestments_Percent_Marital_Equity'.$i.'']=$result['Client_StockInvestments_Current_Value'.$i.''];
            } else {
                $result['Client_StockInvestments_Current_Value'.$i.'']=NULL;
                $result['Client_StockInvestments_Percent_Marital_Equity'.$i.'']=NULL;
            }

            if(isset($result['Op_StockInvestments_Current_Value'.$i.''])){
                $result['Op_StockInvestments_Percent_Marital_Equity'.$i.'']=$result['Op_StockInvestments_Current_Value'.$i.''];
            } else {
                $result['Op_StockInvestments_Current_Value'.$i.'']=NULL;
                $result['Op_StockInvestments_Percent_Marital_Equity'.$i.'']=NULL;
            }

            if(isset($result['Joint_StockInvestments_Disposition_Method'.$i.'']) && $result['Joint_StockInvestments_Disposition_Method'.$i.''] !='Fixed Buyout'){
                $result['Joint_StockInvestments_Paying_Party'.$i.'']=NULL;
            }

            if(isset($result['Client_StockInvestments_Disposition_Method'.$i.'']) && $result['Client_StockInvestments_Disposition_Method'.$i.''] !='Fixed Buyout'){
                $result['Client_StockInvestments_Paying_Party'.$i.'']=NULL;
            }

            if(isset($result['Op_StockInvestments_Disposition_Method'.$i.'']) && $result['Op_StockInvestments_Disposition_Method'.$i.''] !='Fixed Buyout'){
                $result['Op_StockInvestments_Paying_Party'.$i.'']=NULL;
            }

            // new calculations
            // for joint
            $result['Joint_StockInvestments_MaritalEquity'.$i.'']=0.00;
            if(isset($result['Joint_StockInvestments_Current_Value'.$i.'']) && $result['Joint_StockInvestments_Current_Value'.$i.''] !='' && !isset($result['Joint_StockInvestments_Date_Marriage_Value'.$i.''])){
                $result['Joint_StockInvestments_MaritalEquity'.$i.'']=$result['Joint_StockInvestments_Current_Value'.$i.''];
            }
            if(isset($result['Joint_StockInvestments_Date_Marriage_Value'.$i.'']) && $result['Joint_StockInvestments_Date_Marriage_Value'.$i.''] !='' && !isset($result['Joint_StockInvestments_Current_Value'.$i.''])){
                $result['Joint_StockInvestments_MaritalEquity'.$i.'']=$result['Joint_StockInvestments_Date_Marriage_Value'.$i.''];
            }
            if(isset($result['Joint_StockInvestments_Current_Value'.$i.'']) && $result['Joint_StockInvestments_Current_Value'.$i.''] !='' && isset($result['Joint_StockInvestments_Date_Marriage_Value'.$i.'']) && $result['Joint_StockInvestments_Date_Marriage_Value'.$i.''] !=''){
                $result['Joint_StockInvestments_MaritalEquity'.$i.'']=$result['Joint_StockInvestments_Current_Value'.$i.'']-$result['Joint_StockInvestments_Date_Marriage_Value'.$i.''];
            }
            $result['Joint_StockInvestments_Estimated_Yearly_Income_to_Client'.$i.'']=0.00;
            if(isset($result['Joint_StockInvestments_Percent_Marital_Equity_to_Client'.$i.'']) && $result['Joint_StockInvestments_Percent_Marital_Equity_to_Client'.$i.''] !='' && !isset($result['Joint_StockInvestments_Yearly_Interest_Dividend'.$i.''])){
                $result['Joint_StockInvestments_Estimated_Yearly_Income_to_Client'.$i.'']=$result['Joint_StockInvestments_Percent_Marital_Equity_to_Client'.$i.''];
            }
            if(isset($result['Joint_StockInvestments_Yearly_Interest_Dividend'.$i.'']) && $result['Joint_StockInvestments_Yearly_Interest_Dividend'.$i.''] !='' && !isset($result['Joint_StockInvestments_Percent_Marital_Equity_to_Client'.$i.''])){
                $result['Joint_StockInvestments_Estimated_Yearly_Income_to_Client'.$i.'']=$result['Joint_StockInvestments_Yearly_Interest_Dividend'.$i.''];
            }
            if(isset($result['Joint_StockInvestments_Percent_Marital_Equity_to_Client'.$i.'']) && $result['Joint_StockInvestments_Percent_Marital_Equity_to_Client'.$i.''] !='' && isset($result['Joint_StockInvestments_Yearly_Interest_Dividend'.$i.'']) && $result['Joint_StockInvestments_Yearly_Interest_Dividend'.$i.''] !=''){
                $result['Joint_StockInvestments_Estimated_Yearly_Income_to_Client'.$i.'']=$result['Joint_StockInvestments_Percent_Marital_Equity_to_Client'.$i.'']*$result['Joint_StockInvestments_Yearly_Interest_Dividend'.$i.''];
            }
            $result['Joint_StockInvestments_Estimated_Yearly_Income_to_Op'.$i.'']=0.00;
            if(isset($result['Joint_StockInvestments_Yearly_Interest_Dividend'.$i.'']) && $result['Joint_StockInvestments_Yearly_Interest_Dividend'.$i.''] !='' && !isset($result['Joint_StockInvestments_Estimated_Yearly_Income_to_Client'.$i.''])){
                $result['Joint_StockInvestments_Estimated_Yearly_Income_to_Op'.$i.'']=$result['Joint_StockInvestments_Yearly_Interest_Dividend'.$i.''];
            }
            if(isset($result['Joint_StockInvestments_Estimated_Yearly_Income_to_Client'.$i.'']) && $result['Joint_StockInvestments_Estimated_Yearly_Income_to_Client'.$i.''] !='' && !isset($result['Joint_StockInvestments_Yearly_Interest_Dividend'.$i.''])){
                $result['Joint_StockInvestments_Estimated_Yearly_Income_to_Op'.$i.'']=$result['Joint_StockInvestments_Estimated_Yearly_Income_to_Client'.$i.''];
            }
            if(isset($result['Joint_StockInvestments_Yearly_Interest_Dividend'.$i.'']) && $result['Joint_StockInvestments_Yearly_Interest_Dividend'.$i.''] !='' && isset($result['Joint_StockInvestments_Estimated_Yearly_Income_to_Client'.$i.'']) && $result['Joint_StockInvestments_Estimated_Yearly_Income_to_Client'.$i.''] !=''){
                $result['Joint_StockInvestments_Estimated_Yearly_Income_to_Op'.$i.'']=$result['Joint_StockInvestments_Yearly_Interest_Dividend'.$i.'']-$result['Joint_StockInvestments_Estimated_Yearly_Income_to_Client'.$i.''];
            }

            // for client
            $result['Client_StockInvestments_MaritalEquity'.$i.'']=0.00;
            if(isset($result['Client_StockInvestments_Current_Value'.$i.'']) && $result['Client_StockInvestments_Current_Value'.$i.''] !='' && !isset($result['Client_StockInvestments_Date_Marriage_Value'.$i.''])){
                $result['Client_StockInvestments_MaritalEquity'.$i.'']=$result['Client_StockInvestments_Current_Value'.$i.''];
            }
            if(isset($result['Client_StockInvestments_Date_Marriage_Value'.$i.'']) && $result['Client_StockInvestments_Date_Marriage_Value'.$i.''] !='' && !isset($result['Client_StockInvestments_Current_Value'.$i.''])){
                $result['Client_StockInvestments_MaritalEquity'.$i.'']=$result['Client_StockInvestments_Date_Marriage_Value'.$i.''];
            }
            if(isset($result['Client_StockInvestments_Current_Value'.$i.'']) && $result['Client_StockInvestments_Current_Value'.$i.''] !='' && isset($result['Client_StockInvestments_Date_Marriage_Value'.$i.'']) && $result['Client_StockInvestments_Date_Marriage_Value'.$i.''] !=''){
                $result['Client_StockInvestments_MaritalEquity'.$i.'']=$result['Client_StockInvestments_Current_Value'.$i.'']-$result['Client_StockInvestments_Date_Marriage_Value'.$i.''];
            }
            $result['Client_StockInvestments_Estimated_Yearly_Income_to_Client'.$i.'']=0.00;
            if(isset($result['Client_StockInvestments_Percent_Marital_Equity_to_Client'.$i.'']) && $result['Client_StockInvestments_Percent_Marital_Equity_to_Client'.$i.''] !='' && !isset($result['Client_StockInvestments_Yearly_Interest_Dividend'.$i.''])){
                $result['Client_StockInvestments_Estimated_Yearly_Income_to_Client'.$i.'']=$result['Client_StockInvestments_Percent_Marital_Equity_to_Client'.$i.''];
            }
            if(isset($result['Client_StockInvestments_Yearly_Interest_Dividend'.$i.'']) && $result['Client_StockInvestments_Yearly_Interest_Dividend'.$i.''] !='' && !isset($result['Client_StockInvestments_Percent_Marital_Equity_to_Client'.$i.''])){
                $result['Client_StockInvestments_Estimated_Yearly_Income_to_Client'.$i.'']=$result['Client_StockInvestments_Yearly_Interest_Dividend'.$i.''];
            }
            if(isset($result['Client_StockInvestments_Percent_Marital_Equity_to_Client'.$i.'']) && $result['Client_StockInvestments_Percent_Marital_Equity_to_Client'.$i.''] !='' && isset($result['Client_StockInvestments_Yearly_Interest_Dividend'.$i.'']) && $result['Client_StockInvestments_Yearly_Interest_Dividend'.$i.''] !=''){
                $result['Client_StockInvestments_Estimated_Yearly_Income_to_Client'.$i.'']=$result['Client_StockInvestments_Percent_Marital_Equity_to_Client'.$i.'']*$result['Client_StockInvestments_Yearly_Interest_Dividend'.$i.''];
            }
            $result['Client_StockInvestments_Estimated_Yearly_Income_to_Op'.$i.'']=0.00;
            if(isset($result['Client_StockInvestments_Yearly_Interest_Dividend'.$i.'']) && $result['Client_StockInvestments_Yearly_Interest_Dividend'.$i.''] !='' && !isset($result['Client_StockInvestments_Estimated_Yearly_Income_to_Client'.$i.''])){
                $result['Client_StockInvestments_Estimated_Yearly_Income_to_Op'.$i.'']=$result['Client_StockInvestments_Yearly_Interest_Dividend'.$i.''];
            }
            if(isset($result['Client_StockInvestments_Estimated_Yearly_Income_to_Client'.$i.'']) && $result['Client_StockInvestments_Estimated_Yearly_Income_to_Client'.$i.''] !='' && !isset($result['Client_StockInvestments_Yearly_Interest_Dividend'.$i.''])){
                $result['Client_StockInvestments_Estimated_Yearly_Income_to_Op'.$i.'']=$result['Client_StockInvestments_Estimated_Yearly_Income_to_Client'.$i.''];
            }
            if(isset($result['Client_StockInvestments_Yearly_Interest_Dividend'.$i.'']) && $result['Client_StockInvestments_Yearly_Interest_Dividend'.$i.''] !='' && isset($result['Client_StockInvestments_Estimated_Yearly_Income_to_Client'.$i.'']) && $result['Client_StockInvestments_Estimated_Yearly_Income_to_Client'.$i.''] !=''){
                $result['Client_StockInvestments_Estimated_Yearly_Income_to_Op'.$i.'']=$result['Client_StockInvestments_Yearly_Interest_Dividend'.$i.'']-$result['Client_StockInvestments_Estimated_Yearly_Income_to_Client'.$i.''];
            }

            // for opponent
            $result['Op_StockInvestments_MaritalEquity'.$i.'']=0.00;
            if(isset($result['Op_StockInvestments_Current_Value'.$i.'']) && $result['Op_StockInvestments_Current_Value'.$i.''] !='' && !isset($result['Op_StockInvestments_Date_Marriage_Value'.$i.''])){
                $result['Op_StockInvestments_MaritalEquity'.$i.'']=$result['Op_StockInvestments_Current_Value'.$i.''];
            }
            if(isset($result['Op_StockInvestments_Date_Marriage_Value'.$i.'']) && $result['Op_StockInvestments_Date_Marriage_Value'.$i.''] !='' && !isset($result['Op_StockInvestments_Current_Value'.$i.''])){
                $result['Op_StockInvestments_MaritalEquity'.$i.'']=$result['Op_StockInvestments_Date_Marriage_Value'.$i.''];
            }
            if(isset($result['Op_StockInvestments_Current_Value'.$i.'']) && $result['Op_StockInvestments_Current_Value'.$i.''] !='' && isset($result['Op_StockInvestments_Date_Marriage_Value'.$i.'']) && $result['Op_StockInvestments_Date_Marriage_Value'.$i.''] !=''){
                $result['Op_StockInvestments_MaritalEquity'.$i.'']=$result['Op_StockInvestments_Current_Value'.$i.'']-$result['Op_StockInvestments_Date_Marriage_Value'.$i.''];
            }
            $result['Op_StockInvestments_Estimated_Yearly_Income_to_Client'.$i.'']=0.00;
            if(isset($result['Op_StockInvestments_Percent_Marital_Equity_to_Client'.$i.'']) && $result['Op_StockInvestments_Percent_Marital_Equity_to_Client'.$i.''] !='' && !isset($result['Op_StockInvestments_Yearly_Interest_Dividend'.$i.''])){
                $result['Op_StockInvestments_Estimated_Yearly_Income_to_Client'.$i.'']=$result['Op_StockInvestments_Percent_Marital_Equity_to_Client'.$i.''];
            }
            if(isset($result['Op_StockInvestments_Yearly_Interest_Dividend'.$i.'']) && $result['Op_StockInvestments_Yearly_Interest_Dividend'.$i.''] !='' && !isset($result['Op_StockInvestments_Percent_Marital_Equity_to_Client'.$i.''])){
                $result['Op_StockInvestments_Estimated_Yearly_Income_to_Client'.$i.'']=$result['Op_StockInvestments_Yearly_Interest_Dividend'.$i.''];
            }
            if(isset($result['Op_StockInvestments_Percent_Marital_Equity_to_Client'.$i.'']) && $result['Op_StockInvestments_Percent_Marital_Equity_to_Client'.$i.''] !='' && isset($result['Op_StockInvestments_Yearly_Interest_Dividend'.$i.'']) && $result['Op_StockInvestments_Yearly_Interest_Dividend'.$i.''] !=''){
                $result['Op_StockInvestments_Estimated_Yearly_Income_to_Client'.$i.'']=$result['Op_StockInvestments_Percent_Marital_Equity_to_Client'.$i.'']*$result['Op_StockInvestments_Yearly_Interest_Dividend'.$i.''];
            }
            $result['Op_StockInvestments_Estimated_Yearly_Income_to_Op'.$i.'']=0.00;
            if(isset($result['Op_StockInvestments_Yearly_Interest_Dividend'.$i.'']) && $result['Op_StockInvestments_Yearly_Interest_Dividend'.$i.''] !='' && !isset($result['Op_StockInvestments_Estimated_Yearly_Income_to_Client'.$i.''])){
                $result['Op_StockInvestments_Estimated_Yearly_Income_to_Op'.$i.'']=$result['Op_StockInvestments_Yearly_Interest_Dividend'.$i.''];
            }
            if(isset($result['Op_StockInvestments_Estimated_Yearly_Income_to_Client'.$i.'']) && $result['Op_StockInvestments_Estimated_Yearly_Income_to_Client'.$i.''] !='' && !isset($result['Op_StockInvestments_Yearly_Interest_Dividend'.$i.''])){
                $result['Op_StockInvestments_Estimated_Yearly_Income_to_Op'.$i.'']=$result['Op_StockInvestments_Estimated_Yearly_Income_to_Client'.$i.''];
            }
            if(isset($result['Op_StockInvestments_Yearly_Interest_Dividend'.$i.'']) && $result['Op_StockInvestments_Yearly_Interest_Dividend'.$i.''] !='' && isset($result['Op_StockInvestments_Estimated_Yearly_Income_to_Client'.$i.'']) && $result['Op_StockInvestments_Estimated_Yearly_Income_to_Client'.$i.''] !=''){
                $result['Op_StockInvestments_Estimated_Yearly_Income_to_Op'.$i.'']=$result['Op_StockInvestments_Yearly_Interest_Dividend'.$i.'']-$result['Op_StockInvestments_Estimated_Yearly_Income_to_Client'.$i.''];
            }

            // for all accounts
            if(isset($result['Joint_StockInvestments_MaritalEquity'.$i.'']) && $result['Joint_StockInvestments_MaritalEquity'.$i.'']!=''){
                $result['StocksInvestments_Total_Marital_Equity']=$result['StocksInvestments_Total_Marital_Equity']+$result['Joint_StockInvestments_MaritalEquity'.$i.''];
            }
            if(isset($result['Client_StockInvestments_MaritalEquity'.$i.'']) && $result['Client_StockInvestments_MaritalEquity'.$i.'']!=''){
                $result['StocksInvestments_Total_Marital_Equity']=$result['StocksInvestments_Total_Marital_Equity']+$result['Client_StockInvestments_MaritalEquity'.$i.''];
            }
            if(isset($result['Op_StockInvestments_MaritalEquity'.$i.'']) && $result['Op_StockInvestments_MaritalEquity'.$i.'']!=''){
                $result['StocksInvestments_Total_Marital_Equity']=$result['StocksInvestments_Total_Marital_Equity']+$result['Op_StockInvestments_MaritalEquity'.$i.''];
            }

            if(isset($result['Joint_StockInvestments_Estimated_Value_to_Client'.$i.'']) && $result['Joint_StockInvestments_Estimated_Value_to_Client'.$i.'']!=''){
                $result['StocksInvestments_Client_Total_Marital_Equity']=$result['StocksInvestments_Client_Total_Marital_Equity']+$result['Joint_StockInvestments_Estimated_Value_to_Client'.$i.''];
            }
            if(isset($result['Client_StockInvestments_Estimated_Value_to_Client'.$i.'']) && $result['Client_StockInvestments_Estimated_Value_to_Client'.$i.'']!=''){
                $result['StocksInvestments_Client_Total_Marital_Equity']=$result['StocksInvestments_Client_Total_Marital_Equity']+$result['Client_StockInvestments_Estimated_Value_to_Client'.$i.''];
            }
            if(isset($result['Op_StockInvestments_Estimated_Value_to_Client'.$i.'']) && $result['Op_StockInvestments_Estimated_Value_to_Client'.$i.'']!=''){
                $result['StocksInvestments_Client_Total_Marital_Equity']=$result['StocksInvestments_Client_Total_Marital_Equity']+$result['Op_StockInvestments_Estimated_Value_to_Client'.$i.''];
            }

            if(isset($result['Joint_StockInvestments_Estimated_Value_to_Op'.$i.'']) && $result['Joint_StockInvestments_Estimated_Value_to_Op'.$i.'']!=''){
                $result['StocksInvestments_Op_Total_Marital_Equity']=$result['StocksInvestments_Op_Total_Marital_Equity']+$result['Joint_StockInvestments_Estimated_Value_to_Op'.$i.''];
            }
            if(isset($result['Client_StockInvestments_Estimated_Value_to_Op'.$i.'']) && $result['Client_StockInvestments_Estimated_Value_to_Op'.$i.'']!=''){
                $result['StocksInvestments_Op_Total_Marital_Equity']=$result['StocksInvestments_Op_Total_Marital_Equity']+$result['Client_StockInvestments_Estimated_Value_to_Op'.$i.''];
            }
            if(isset($result['Op_StockInvestments_Estimated_Value_to_Op'.$i.'']) && $result['Op_StockInvestments_Estimated_Value_to_Op'.$i.'']!=''){
                $result['StocksInvestments_Op_Total_Marital_Equity']=$result['StocksInvestments_Op_Total_Marital_Equity']+$result['Op_StockInvestments_Estimated_Value_to_Op'.$i.''];
            }

            if(isset($result['Joint_StockInvestments_Yearly_Interest_Dividend'.$i.'']) && $result['Joint_StockInvestments_Yearly_Interest_Dividend'.$i.'']!=''){
                $result['StocksInvestments_Total_Yearly_Income']=$result['StocksInvestments_Total_Yearly_Income']+$result['Joint_StockInvestments_Yearly_Interest_Dividend'.$i.''];
            }
            if(isset($result['Client_StockInvestments_Yearly_Interest_Dividend'.$i.'']) && $result['Client_StockInvestments_Yearly_Interest_Dividend'.$i.'']!=''){
                $result['StocksInvestments_Total_Yearly_Income']=$result['StocksInvestments_Total_Yearly_Income']+$result['Client_StockInvestments_Yearly_Interest_Dividend'.$i.''];
            }
            if(isset($result['Op_StockInvestments_Yearly_Interest_Dividend'.$i.'']) && $result['Op_StockInvestments_Yearly_Interest_Dividend'.$i.'']!=''){
                $result['StocksInvestments_Total_Yearly_Income']=$result['StocksInvestments_Total_Yearly_Income']+$result['Op_StockInvestments_Yearly_Interest_Dividend'.$i.''];
            }

            if(isset($result['Joint_StockInvestments_Estimated_Yearly_Income_to_Client'.$i.'']) && $result['Joint_StockInvestments_Estimated_Yearly_Income_to_Client'.$i.'']!=''){
                $result['StocksInvestments_Total_Yearly_Income_to_Client']=$result['StocksInvestments_Total_Yearly_Income_to_Client']+$result['Joint_StockInvestments_Estimated_Yearly_Income_to_Client'.$i.''];
            }
            if(isset($result['Client_StockInvestments_Estimated_Yearly_Income_to_Client'.$i.'']) && $result['Client_StockInvestments_Estimated_Yearly_Income_to_Client'.$i.'']!=''){
                $result['StocksInvestments_Total_Yearly_Income_to_Client']=$result['StocksInvestments_Total_Yearly_Income_to_Client']+$result['Client_StockInvestments_Estimated_Yearly_Income_to_Client'.$i.''];
            }
            if(isset($result['Op_StockInvestments_Estimated_Yearly_Income_to_Client'.$i.'']) && $result['Op_StockInvestments_Estimated_Yearly_Income_to_Client'.$i.'']!=''){
                $result['StocksInvestments_Total_Yearly_Income_to_Client']=$result['StocksInvestments_Total_Yearly_Income_to_Client']+$result['Op_StockInvestments_Estimated_Yearly_Income_to_Client'.$i.''];
            }

            if(isset($result['Joint_StockInvestments_Estimated_Yearly_Income_to_Op'.$i.'']) && $result['Joint_StockInvestments_Estimated_Yearly_Income_to_Op'.$i.'']!=''){
                $result['StocksInvestments_Total_Yearly_Income_to_Op']=$result['StocksInvestments_Total_Yearly_Income_to_Op']+$result['Joint_StockInvestments_Estimated_Yearly_Income_to_Op'.$i.''];
            }
            if(isset($result['Client_StockInvestments_Estimated_Yearly_Income_to_Op'.$i.'']) && $result['Client_StockInvestments_Estimated_Yearly_Income_to_Op'.$i.'']!=''){
                $result['StocksInvestments_Total_Yearly_Income_to_Op']=$result['StocksInvestments_Total_Yearly_Income_to_Op']+$result['Client_StockInvestments_Estimated_Yearly_Income_to_Op'.$i.''];
            }
            if(isset($result['Op_StockInvestments_Estimated_Yearly_Income_to_Op'.$i.'']) && $result['Op_StockInvestments_Estimated_Yearly_Income_to_Op'.$i.'']!=''){
                $result['StocksInvestments_Total_Yearly_Income_to_Op']=$result['StocksInvestments_Total_Yearly_Income_to_Op']+$result['Op_StockInvestments_Estimated_Yearly_Income_to_Op'.$i.''];
            }
            
        }

        if(isset($result['Any_Stocks_Investments_Accounts']) && $result['Any_Stocks_Investments_Accounts']=='1'){
        } else {
            $result['Any_Stocks_Investments_Accounts']='0';
            $result['Num_Joint_StocksInvestments_Accounts']=0;
            $result['Num_Client_StockInvestments_Accounts']=0;
            $result['Num_Op_StockInvestments_Accounts']=0;
        }

        if(isset($result['Num_Joint_StocksInvestments_Accounts'])){
        } else {
            $result['Num_Joint_StocksInvestments_Accounts']='0';
        }
        $Num_Joint_StocksInvestments_Accounts=$result['Num_Joint_StocksInvestments_Accounts'];
        $Num_Joint_StocksInvestments_Accounts=$Num_Joint_StocksInvestments_Accounts+1;
        for ($i=$Num_Joint_StocksInvestments_Accounts; $i <= 10; $i++) { 
            $result['Joint_StockInvestments_Institution_ZIP'.$i.'']=NULL;
            $result['Joint_StockInvestments_Institution_Name'.$i.'']=NULL;
            $result['Joint_StockInvestments_Institution_Street_Address'.$i.'']=NULL;
            $result['Joint_StockInvestments_Institution_City'.$i.'']=NULL;
            $result['Joint_StockInvestments_Institution_State'.$i.'']=NULL;
            $result['Joint_StockInvestments_Acct_Num'.$i.'']=NULL;
            $result['Joint_StockInvestments_Current_Value'.$i.'']=NULL;
            $result['Joint_StockInvestments_Percent_Marital_Equity'.$i.'']=NULL;
            $result['Joint_StockInvestments_Yearly_Interest_Dividend'.$i.'']=NULL;
            $result['Joint_StockInvestments_SoleSeparate_Claim'.$i.'']=NULL;
            $result['Joint_StockInvestments_SoleSeparate_Party'.$i.'']=NULL;
            $result['Joint_StockInvestments_SoleSeparate_Grounds'.$i.'']=NULL;
            $result['Joint_StockInvestments_Disposition_Method'.$i.'']=NULL;
            $result['Joint_StockInvestments_Percent_Marital_Equity_to_Client'.$i.'']=NULL;
            $result['Joint_StockInvestments_Percent_Marital_Equity_to_Op'.$i.'']=NULL;
            $result['Joint_StockInvestments_Estimated_Value_to_Client'.$i.'']=NULL;
            $result['Joint_StockInvestments_Estimated_Value_to_Op'.$i.'']=NULL;
            $result['Joint_StockInvestments_Paying_Party'.$i.'']=NULL;
            $result['Joint_StockInvestments_Date_Marriage_Value'.$i.'']=NULL;
            $result['Joint_StockInvestments_MaritalEquity'.$i.'']=NULL;
            $result['Joint_StockInvestments_Estimated_Yearly_Income_to_Client'.$i.'']=NULL;
            $result['Joint_StockInvestments_Estimated_Yearly_Income_to_Op'.$i.'']=NULL;
            
        }

        if(isset($result['Num_Client_StockInvestments_Accounts'])){
        } else {
            $result['Num_Client_StockInvestments_Accounts']='0';
        }
        $Num_Client_StockInvestments_Accounts=$result['Num_Client_StockInvestments_Accounts'];
        $Num_Client_StockInvestments_Accounts=$Num_Client_StockInvestments_Accounts+1;
        for ($i=$Num_Client_StockInvestments_Accounts; $i <= 10; $i++) { 
            $result['Client_StockInvestments_Institution_ZIP'.$i.'']=NULL;
            $result['Client_StockInvestments_Institution_Name'.$i.'']=NULL;
            $result['Client_StockInvestments_Institution_Street_Address'.$i.'']=NULL;
            $result['Client_StockInvestments_Institution_City'.$i.'']=NULL;
            $result['Client_StockInvestments_Institution_State'.$i.'']=NULL;
            $result['Client_StockInvestments_Acct_Num'.$i.'']=NULL;
            $result['Client_StockInvestments_Current_Value'.$i.'']=NULL;
            $result['Client_StockInvestments_Percent_Marital_Equity'.$i.'']=NULL;
            $result['Client_StockInvestments_Yearly_Interest_Dividend'.$i.'']=NULL;
            $result['Client_StockInvestments_SoleSeparate_Claim'.$i.'']=NULL;
            $result['Client_StockInvestments_SoleSeparate_Party'.$i.'']=NULL;
            $result['Client_StockInvestments_SoleSeparate_Grounds'.$i.'']=NULL;
            $result['Client_StockInvestments_Disposition_Method'.$i.'']=NULL;
            $result['Client_StockInvestments_Percent_Marital_Equity_to_Client'.$i.'']=NULL;
            $result['Client_StockInvestments_Percent_Marital_Equity_to_Op'.$i.'']=NULL;
            $result['Client_StockInvestments_Estimated_Value_to_Client'.$i.'']=NULL;
            $result['Client_StockInvestments_Estimated_Value_to_Op'.$i.'']=NULL;
            $result['Client_StockInvestments_Paying_Party'.$i.'']=NULL;
            $result['Client_StockInvestments_Date_Marriage_Value'.$i.'']=NULL;
            $result['Client_StockInvestments_MaritalEquity'.$i.'']=NULL;
            $result['Client_StockInvestments_Estimated_Yearly_Income_to_Client'.$i.'']=NULL;
            $result['Client_StockInvestments_Estimated_Yearly_Income_to_Op'.$i.'']=NULL;
            
        }

        if(isset($result['Num_Op_StockInvestments_Accounts'])){
        } else {
            $result['Num_Op_StockInvestments_Accounts']='0';
        }
        $Num_Op_StockInvestments_Accounts=$result['Num_Op_StockInvestments_Accounts'];
        $Num_Op_StockInvestments_Accounts=$Num_Op_StockInvestments_Accounts+1;
        for ($i=$Num_Op_StockInvestments_Accounts; $i <= 10; $i++) { 
            $result['Op_StockInvestments_Institution_ZIP'.$i.'']=NULL;
            $result['Op_StockInvestments_Institution_Name'.$i.'']=NULL;
            $result['Op_StockInvestments_Institution_Street_Address'.$i.'']=NULL;
            $result['Op_StockInvestments_Institution_City'.$i.'']=NULL;
            $result['Op_StockInvestments_Institution_State'.$i.'']=NULL;
            $result['Op_StockInvestments_Acct_Num'.$i.'']=NULL;
            $result['Op_StockInvestments_Current_Value'.$i.'']=NULL;
            $result['Op_StockInvestments_Percent_Marital_Equity'.$i.'']=NULL;
            $result['Op_StockInvestments_Yearly_Interest_Dividend'.$i.'']=NULL;
            $result['Op_StockInvestments_SoleSeparate_Claim'.$i.'']=NULL;
            $result['Op_StockInvestments_SoleSeparate_Party'.$i.'']=NULL;
            $result['Op_StockInvestments_SoleSeparate_Grounds'.$i.'']=NULL;
            $result['Op_StockInvestments_Disposition_Method'.$i.'']=NULL;
            $result['Op_StockInvestments_Percent_Marital_Equity_to_Client'.$i.'']=NULL;
            $result['Op_StockInvestments_Percent_Marital_Equity_to_Op'.$i.'']=NULL;
            $result['Op_StockInvestments_Estimated_Value_to_Client'.$i.'']=NULL;
            $result['Op_StockInvestments_Estimated_Value_to_Op'.$i.'']=NULL;
            $result['Op_StockInvestments_Paying_Party'.$i.'']=NULL;
            $result['Op_StockInvestments_Date_Marriage_Value'.$i.'']=NULL;
            $result['Op_StockInvestments_MaritalEquity'.$i.'']=NULL;
            $result['Op_StockInvestments_Estimated_Yearly_Income_to_Client'.$i.'']=NULL;
            $result['Op_StockInvestments_Estimated_Yearly_Income_to_Op'.$i.'']=NULL;
            
        }
        
        // echo "<pre>";print_r($result);die;
        $drstocksinvestments  = DrStocksInvestments::findOrFail($id);
        if($drstocksinvestments){
            $drstocksinvestments->fill($result)->save();
            // update case overview info.
            $drcaseoverview=DrCaseOverview::where('case_id',$result['case_id'])->get()->first();
            if(isset($drcaseoverview)){
                $drcaseoverview->Any_Stocks_Investments_Accounts=$result['Any_Stocks_Investments_Accounts'];
                $drcaseoverview->Num_Joint_StocksInvestments_Accounts=$result['Num_Joint_StocksInvestments_Accounts'];
                $drcaseoverview->Num_Client_StockInvestments_Accounts=$result['Num_Client_StockInvestments_Accounts'];
                $drcaseoverview->Num_Op_StockInvestments_Accounts=$result['Num_Op_StockInvestments_Accounts'];
                $drcaseoverview->save();
            } else {
                return redirect()->route('cases.family_law_interview_tabs',$result['case_id'])->with('error', 'Complete Case Overview Info Section First.');
            }
            
            return redirect()->route('drstocksinvestments.edit',$result['case_id'])->with('success', 'Stocks Investments Information Updated Successfully.');
        } else {
            return redirect()->route('drstocksinvestments.edit',$result['case_id'])->with('error', 'Something went wrong. Please try Again.');
        }
    }
    
    public function destroy($id)
    {

    }

}
