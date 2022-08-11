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
use App\DrIncome;
use App\DrRealEstate;
use App\DrFundsOnDeposit;
use App\DrStocksInvestments;
use App\DrRetirementAccts;
use App\DrPension;
use App\DrPersonalInfo;
use App\DrChildren;

class DrIncomeController extends Controller
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
        $data=DrIncome::orderBy('id','DESC')->get();
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

        $drincome=DrIncome::where('case_id',$case_id)->get()->pluck('case_id');
        if(isset($drincome['0'])){
            return redirect()->route('home');
        }
        $realestate=DrRealEstate::where('case_id',$case_id)->get()->first();
        if(isset($realestate)){
            // N/A, Calculated from dr_RealEstate = SUM(Joint/Client/Op_Real_Estate_Client_Share_Rental)

            $Client_Rent = $realestate->Joint_Real_Estate_Client_Share_Rental1 + $realestate->Joint_Real_Estate_Client_Share_Rental2 + $realestate->Joint_Real_Estate_Client_Share_Rental3 + $realestate->Joint_Real_Estate_Client_Share_Rental4 + $realestate->Joint_Real_Estate_Client_Share_Rental5 + $realestate->Cliet_Real_Estate_Client_Share_Rental1 + $realestate->Cliet_Real_Estate_Client_Share_Rental2 + $realestate->Cliet_Real_Estate_Client_Share_Rental3 + $realestate->Cliet_Real_Estate_Client_Share_Rental4 + $realestate->Cliet_Real_Estate_Client_Share_Rental5 + $realestate->Op_Real_Estate_Client_Share_Rental1 + $realestate->Op_Real_Estate_Client_Share_Rental2 + $realestate->Op_Real_Estate_Client_Share_Rental3 + $realestate->Op_Real_Estate_Client_Share_Rental4 + $realestate->Op_Real_Estate_Client_Share_Rental5;

            $Op_Rent = $realestate->Joint_Real_Estate_Op_Share_Rental1 + $realestate->Joint_Real_Estate_Op_Share_Rental2 + $realestate->Joint_Real_Estate_Op_Share_Rental3 + $realestate->Joint_Real_Estate_Op_Share_Rental4 + $realestate->Joint_Real_Estate_Op_Share_Rental5 + $realestate->Cliet_Real_Estate_Op_Share_Rental1 + $realestate->Cliet_Real_Estate_Op_Share_Rental2 + $realestate->Cliet_Real_Estate_Op_Share_Rental3 + $realestate->Cliet_Real_Estate_Op_Share_Rental4 + $realestate->Cliet_Real_Estate_Op_Share_Rental5 + $realestate->Op_Real_Estate_Op_Share_Rental1 + $realestate->Op_Real_Estate_Op_Share_Rental2 + $realestate->Op_Real_Estate_Op_Share_Rental3 + $realestate->Op_Real_Estate_Op_Share_Rental4 + $realestate->Op_Real_Estate_Op_Share_Rental5;

            $Client_Rent=round($Client_Rent,2);
            $Op_Rent=round($Op_Rent,2);

        } else {
            return redirect()->route('cases.family_law_interview_tabs',$case_id)->with('error', 'Complete Real Estate Info Section First.');
        }
        $pension=DrPension::where('case_id',$case_id)->get()->first();
        if(isset($pension)){
            // "N/A, Calculated from dr_Pensions & dr_RetirementAccts =SUM(Client/Op_Pension_Custom_Monthly_Client_Amount) + SUM(Client/Op_RetAcct_Current_Monthly_Income * Client/Op_RetAcct_Percent_Marital_Equity_to_Client )"

            $client_pensions= $pension->Client_Pension1_Custom_Monthly_Client_Amount + $pension->Client_Pension2_Custom_Monthly_Client_Amount + $pension->Client_Pension3_Custom_Monthly_Client_Amount + $pension->Client_Pension4_Custom_Monthly_Client_Amount + $pension->Op_Pension1_Custom_Monthly_Client_Amount + $pension->Op_Pension2_Custom_Monthly_Client_Amount + $pension->Op_Pension3_Custom_Monthly_Client_Amount + $pension->Op_Pension4_Custom_Monthly_Client_Amount;

            $opponent_pensions= $pension->Client_Pension1_Custom_Monthly_Op_Amount + $pension->Client_Pension2_Custom_Monthly_Op_Amount + $pension->Client_Pension3_Custom_Monthly_Op_Amount + $pension->Client_Pension4_Custom_Monthly_Op_Amount + $pension->Op_Pension1_Custom_Monthly_Op_Amount + $pension->Op_Pension2_Custom_Monthly_Op_Amount + $pension->Op_Pension3_Custom_Monthly_Op_Amount + $pension->Op_Pension4_Custom_Monthly_Op_Amount;

        } else {
            return redirect()->route('cases.family_law_interview_tabs',$case_id)->with('error', 'Complete Pension Info Section First.');
        }
        $retirementaccounts=DrRetirementAccts::where('case_id',$case_id)->get()->first();
        if(isset($retirementaccounts)){
            $Client_Op_RetAcct_Equity_to_Client=$retirementaccounts->Client_RetAcct1_Percent_Marital_Equity_to_Client + $retirementaccounts->Client_RetAcct2_Percent_Marital_Equity_to_Client + $retirementaccounts->Client_RetAcct3_Percent_Marital_Equity_to_Client + $retirementaccounts->Client_RetAcct4_Percent_Marital_Equity_to_Client + $retirementaccounts->Op_RetAcct1_Percent_Marital_Equity_to_Client + $retirementaccounts->Op_RetAcct2_Percent_Marital_Equity_to_Client + $retirementaccounts->Op_RetAcct3_Percent_Marital_Equity_to_Client + $retirementaccounts->Op_RetAcct4_Percent_Marital_Equity_to_Client;

            $Client_Op_RetAcct_Equity_to_Op=$retirementaccounts->Client_RetAcct1_Percent_Marital_Equity_to_Op + $retirementaccounts->Client_RetAcct2_Percent_Marital_Equity_to_Op + $retirementaccounts->Client_RetAcct3_Percent_Marital_Equity_to_Op + $retirementaccounts->Client_RetAcct4_Percent_Marital_Equity_to_Op + $retirementaccounts->Op_RetAcct1_Percent_Marital_Equity_to_Op + $retirementaccounts->Op_RetAcct2_Percent_Marital_Equity_to_Op + $retirementaccounts->Op_RetAcct3_Percent_Marital_Equity_to_Op + $retirementaccounts->Op_RetAcct4_Percent_Marital_Equity_to_Op;

            $client_op_recacct_monthly_income= $retirementaccounts->Client_RetAcct1_Current_Monthly_Income + $retirementaccounts->Client_RetAcct2_Current_Monthly_Income + $retirementaccounts->Client_RetAcct3_Current_Monthly_Income + $retirementaccounts->Client_RetAcct4_Current_Monthly_Income + $retirementaccounts->Op_RetAcct1_Current_Monthly_Income + $retirementaccounts->Op_RetAcct2_Current_Monthly_Income + $retirementaccounts->Op_RetAcct3_Current_Monthly_Income + $retirementaccounts->Op_RetAcct4_Current_Monthly_Income;

            //"N/A, Calculated from dr_Pensions & dr_RetirementAccts =SUM(Client/Op_Pension1_Custom_Monthly_Client_Amount) + SUM(Client/Op_RetAcct1_Current_Monthly_Income * Client/Op_RetAcct1_Percent_Marital_Equity_to_Client )"

            //"N/A, Calculated from dr_Pensions & dr_RetirementAccts =SUM(Client/Op_Pension1_Custom_Monthly_Op_Amount) + SUM(Client/Op_RetAcct1_Current_Monthly_Income * Client/Op_RetAcct1_Percent_Marital_Equity_to_Op );

            $Client_Retirement_Pensions = $client_pensions + ($client_op_recacct_monthly_income * $Client_Op_RetAcct_Equity_to_Client/100);
            $Client_Retirement_Pensions = $Client_Retirement_Pensions * 12;

            $Op_Retirement_Pensions = $opponent_pensions + ($client_op_recacct_monthly_income * $Client_Op_RetAcct_Equity_to_Op/100);
            $Op_Retirement_Pensions = $Op_Retirement_Pensions * 12;

            $Client_Retirement_Pensions=round($Client_Retirement_Pensions,2);
            $Op_Retirement_Pensions=round($Op_Retirement_Pensions,2);


        } else {
            return redirect()->route('cases.family_law_interview_tabs',$case_id)->with('error', 'Complete Retirement Accounts Info Section First.');
        }
        $stockinvestment=DrStocksInvestments::where('case_id',$case_id)->get()->first();
        if(isset($stockinvestment)){
            // N/A, Calculated from dr_Stocks_Investments & dr_FundsOnDeposit = SUM(Joint/Client/Op_StockInvestments_Yearly_Interest_Dividend * Joint/Client/Op_StockInvestments_Percent_Marital_Equity_to_Client ) + SUM(Joint/Client/Op_Funds_on_Deposit_Institution_Yearly_Interest_Dividend * Joint/Client/Op Funds_on_Deposit_Percent_Marital_Equity_to_Client );

            // N/A, Calculated from dr_Stocks_Investments & dr_FundsOnDeposit = SUM(Joint/Client/Op_StockInvestments_Yearly_Interest_Dividend * Joint/Client/Op_StockInvestments_Percent_Marital_Equity_to_Op ) + SUM(Joint/Client/Op_Funds_on_Deposit_Institution_Yearly_Interest_Dividend * Joint/Client/Op Funds_on_Deposit_Percent_Marital_Equity_to_Op );

            $yearly_interest_divident = $stockinvestment->Joint_StockInvestments_Yearly_Interest_Dividend1 + $stockinvestment->Joint_StockInvestments_Yearly_Interest_Dividend2 + $stockinvestment->Joint_StockInvestments_Yearly_Interest_Dividend3 + $stockinvestment->Joint_StockInvestments_Yearly_Interest_Dividend4 + $stockinvestment->Joint_StockInvestments_Yearly_Interest_Dividend5 + $stockinvestment->Joint_StockInvestments_Yearly_Interest_Dividend6 + $stockinvestment->Joint_StockInvestments_Yearly_Interest_Dividend7 + $stockinvestment->Joint_StockInvestments_Yearly_Interest_Dividend8 + $stockinvestment->Joint_StockInvestments_Yearly_Interest_Dividend9 + $stockinvestment->Joint_StockInvestments_Yearly_Interest_Dividend10 + $stockinvestment->Client_StockInvestments_Yearly_Interest_Dividend1 + $stockinvestment->Client_StockInvestments_Yearly_Interest_Dividend2 + $stockinvestment->Client_StockInvestments_Yearly_Interest_Dividend3 + $stockinvestment->Client_StockInvestments_Yearly_Interest_Dividend4 + $stockinvestment->Client_StockInvestments_Yearly_Interest_Dividend5 + $stockinvestment->Client_StockInvestments_Yearly_Interest_Dividend6 + $stockinvestment->Client_StockInvestments_Yearly_Interest_Dividend7 + $stockinvestment->Client_StockInvestments_Yearly_Interest_Dividend8 + $stockinvestment->Client_StockInvestments_Yearly_Interest_Dividend9 + $stockinvestment->Client_StockInvestments_Yearly_Interest_Dividend10 + $stockinvestment->Op_StockInvestments_Yearly_Interest_Dividend1 + $stockinvestment->Op_StockInvestments_Yearly_Interest_Dividend2 + $stockinvestment->Op_StockInvestments_Yearly_Interest_Dividend3 + $stockinvestment->Op_StockInvestments_Yearly_Interest_Dividend4 + $stockinvestment->Op_StockInvestments_Yearly_Interest_Dividend5 + $stockinvestment->Op_StockInvestments_Yearly_Interest_Dividend6 + $stockinvestment->Op_StockInvestments_Yearly_Interest_Dividend7 + $stockinvestment->Op_StockInvestments_Yearly_Interest_Dividend8 + $stockinvestment->Op_StockInvestments_Yearly_Interest_Dividend9 + $stockinvestment->Op_StockInvestments_Yearly_Interest_Dividend10;

                $Joint_Client_Op_StockInvestments_Equity_to_Client = $stockinvestment->Joint_StockInvestments_Percent_Marital_Equity_to_Client1 + $stockinvestment->Joint_StockInvestments_Percent_Marital_Equity_to_Client2 + $stockinvestment->Joint_StockInvestments_Percent_Marital_Equity_to_Client3 + $stockinvestment->Joint_StockInvestments_Percent_Marital_Equity_to_Client4 + $stockinvestment->Joint_StockInvestments_Percent_Marital_Equity_to_Client5 + $stockinvestment->Joint_StockInvestments_Percent_Marital_Equity_to_Client6 + $stockinvestment->Joint_StockInvestments_Percent_Marital_Equity_to_Client7 + $stockinvestment->Joint_StockInvestments_Percent_Marital_Equity_to_Client8 + $stockinvestment->Joint_StockInvestments_Percent_Marital_Equity_to_Client9 + $stockinvestment->Joint_StockInvestments_Percent_Marital_Equity_to_Client10 + $stockinvestment->Client_StockInvestments_Percent_Marital_Equity_to_Client1 + $stockinvestment->Client_StockInvestments_Percent_Marital_Equity_to_Client2 + $stockinvestment->Client_StockInvestments_Percent_Marital_Equity_to_Client3 + $stockinvestment->Client_StockInvestments_Percent_Marital_Equity_to_Client4 + $stockinvestment->Client_StockInvestments_Percent_Marital_Equity_to_Client5 + $stockinvestment->Client_StockInvestments_Percent_Marital_Equity_to_Client6 + $stockinvestment->Client_StockInvestments_Percent_Marital_Equity_to_Client7 + $stockinvestment->Client_StockInvestments_Percent_Marital_Equity_to_Client8 + $stockinvestment->Client_StockInvestments_Percent_Marital_Equity_to_Client9 + $stockinvestment->Client_StockInvestments_Percent_Marital_Equity_to_Client10 + $stockinvestment->Op_StockInvestments_Percent_Marital_Equity_to_Client1 + $stockinvestment->Op_StockInvestments_Percent_Marital_Equity_to_Client2 + $stockinvestment->Op_StockInvestments_Percent_Marital_Equity_to_Client3 + $stockinvestment->Op_StockInvestments_Percent_Marital_Equity_to_Client4 + $stockinvestment->Op_StockInvestments_Percent_Marital_Equity_to_Client5 + $stockinvestment->Op_StockInvestments_Percent_Marital_Equity_to_Client6 + $stockinvestment->Op_StockInvestments_Percent_Marital_Equity_to_Client7 + $stockinvestment->Op_StockInvestments_Percent_Marital_Equity_to_Client8 + $stockinvestment->Op_StockInvestments_Percent_Marital_Equity_to_Client9 + $stockinvestment->Op_StockInvestments_Percent_Marital_Equity_to_Client10;

                $Joint_Client_Op_StockInvestments_Equity_to_Op = $stockinvestment->Joint_StockInvestments_Percent_Marital_Equity_to_Op1 + $stockinvestment->Joint_StockInvestments_Percent_Marital_Equity_to_Op2 + $stockinvestment->Joint_StockInvestments_Percent_Marital_Equity_to_Op3 + $stockinvestment->Joint_StockInvestments_Percent_Marital_Equity_to_Op4 + $stockinvestment->Joint_StockInvestments_Percent_Marital_Equity_to_Op5 + $stockinvestment->Joint_StockInvestments_Percent_Marital_Equity_to_Op6 + $stockinvestment->Joint_StockInvestments_Percent_Marital_Equity_to_Op7 + $stockinvestment->Joint_StockInvestments_Percent_Marital_Equity_to_Op8 + $stockinvestment->Joint_StockInvestments_Percent_Marital_Equity_to_Op9 + $stockinvestment->Joint_StockInvestments_Percent_Marital_Equity_to_Op10 + $stockinvestment->Client_StockInvestments_Percent_Marital_Equity_to_Op1 + $stockinvestment->Client_StockInvestments_Percent_Marital_Equity_to_Op2 + $stockinvestment->Client_StockInvestments_Percent_Marital_Equity_to_Op3 + $stockinvestment->Client_StockInvestments_Percent_Marital_Equity_to_Op4 + $stockinvestment->Client_StockInvestments_Percent_Marital_Equity_to_Op5 + $stockinvestment->Client_StockInvestments_Percent_Marital_Equity_to_Op6 + $stockinvestment->Client_StockInvestments_Percent_Marital_Equity_to_Op7 + $stockinvestment->Client_StockInvestments_Percent_Marital_Equity_to_Op8 + $stockinvestment->Client_StockInvestments_Percent_Marital_Equity_to_Op9 + $stockinvestment->Client_StockInvestments_Percent_Marital_Equity_to_Op10 + $stockinvestment->Op_StockInvestments_Percent_Marital_Equity_to_Op1 + $stockinvestment->Op_StockInvestments_Percent_Marital_Equity_to_Op2 + $stockinvestment->Op_StockInvestments_Percent_Marital_Equity_to_Op3 + $stockinvestment->Op_StockInvestments_Percent_Marital_Equity_to_Op4 + $stockinvestment->Op_StockInvestments_Percent_Marital_Equity_to_Op5 + $stockinvestment->Op_StockInvestments_Percent_Marital_Equity_to_Op6 + $stockinvestment->Op_StockInvestments_Percent_Marital_Equity_to_Op7 + $stockinvestment->Op_StockInvestments_Percent_Marital_Equity_to_Op8 + $stockinvestment->Op_StockInvestments_Percent_Marital_Equity_to_Op9 + $stockinvestment->Op_StockInvestments_Percent_Marital_Equity_to_Op10;

                $client_drstockinvestment_amount=$yearly_interest_divident * ($Joint_Client_Op_StockInvestments_Equity_to_Client/100);
                $opponent_drstockinvestment_amount=$yearly_interest_divident * ($Joint_Client_Op_StockInvestments_Equity_to_Op/100);


        } else {
            return redirect()->route('cases.family_law_interview_tabs',$case_id)->with('error', 'Complete Stock Investment Info Section First.');
        }
        $fundsondeposit=DrFundsOnDeposit::where('case_id',$case_id)->get()->first();
        if(isset($fundsondeposit)){

            $yearly_funds_on_deposit_interest_divident = $fundsondeposit->Joint_Funds_on_Deposit_Institution_Yearly_Interest_Dividend1 + $fundsondeposit->Joint_Funds_on_Deposit_Institution_Yearly_Interest_Dividend2 + $fundsondeposit->Joint_Funds_on_Deposit_Institution_Yearly_Interest_Dividend3 + $fundsondeposit->Joint_Funds_on_Deposit_Institution_Yearly_Interest_Dividend4 + $fundsondeposit->Joint_Funds_on_Deposit_Institution_Yearly_Interest_Dividend5 + $fundsondeposit->Joint_Funds_on_Deposit_Institution_Yearly_Interest_Dividend6 + $fundsondeposit->Joint_Funds_on_Deposit_Institution_Yearly_Interest_Dividend7 + $fundsondeposit->Joint_Funds_on_Deposit_Institution_Yearly_Interest_Dividend8 + $fundsondeposit->Joint_Funds_on_Deposit_Institution_Yearly_Interest_Dividend9 + $fundsondeposit->Joint_Funds_on_Deposit_Institution_Yearly_Interest_Dividend10 + $fundsondeposit->Client_Funds_on_Deposit_Institution_Yearly_Interest_Dividend1 + $fundsondeposit->Client_Funds_on_Deposit_Institution_Yearly_Interest_Dividend2 + $fundsondeposit->Client_Funds_on_Deposit_Institution_Yearly_Interest_Dividend3 + $fundsondeposit->Client_Funds_on_Deposit_Institution_Yearly_Interest_Dividend4 + $fundsondeposit->Client_Funds_on_Deposit_Institution_Yearly_Interest_Dividend5 + $fundsondeposit->Client_Funds_on_Deposit_Institution_Yearly_Interest_Dividend6 + $fundsondeposit->Client_Funds_on_Deposit_Institution_Yearly_Interest_Dividend7 + $fundsondeposit->Client_Funds_on_Deposit_Institution_Yearly_Interest_Dividend8 + $fundsondeposit->Client_Funds_on_Deposit_Institution_Yearly_Interest_Dividend9 + $fundsondeposit->Client_Funds_on_Deposit_Institution_Yearly_Interest_Dividend10 + $fundsondeposit->Op_Funds_on_Deposit_Institution_Yearly_Interest_Dividend1 + $fundsondeposit->Op_Funds_on_Deposit_Institution_Yearly_Interest_Dividend2 + $fundsondeposit->Op_Funds_on_Deposit_Institution_Yearly_Interest_Dividend3 + $fundsondeposit->Op_Funds_on_Deposit_Institution_Yearly_Interest_Dividend4 + $fundsondeposit->Op_Funds_on_Deposit_Institution_Yearly_Interest_Dividend5 + $fundsondeposit->Op_Funds_on_Deposit_Institution_Yearly_Interest_Dividend6 + $fundsondeposit->Op_Funds_on_Deposit_Institution_Yearly_Interest_Dividend7 + $fundsondeposit->Op_Funds_on_Deposit_Institution_Yearly_Interest_Dividend8 + $fundsondeposit->Op_Funds_on_Deposit_Institution_Yearly_Interest_Dividend9 + $fundsondeposit->Op_Funds_on_Deposit_Institution_Yearly_Interest_Dividend10;

            $Joint_Client_Op_Funds_on_Deposit_Equity_to_Client = $fundsondeposit->Joint_Funds_on_Deposit_Percent_Marital_Equity_to_Client1 + $fundsondeposit->Joint_Funds_on_Deposit_Percent_Marital_Equity_to_Client2 + $fundsondeposit->Joint_Funds_on_Deposit_Percent_Marital_Equity_to_Client3 + $fundsondeposit->Joint_Funds_on_Deposit_Percent_Marital_Equity_to_Client4 + $fundsondeposit->Joint_Funds_on_Deposit_Percent_Marital_Equity_to_Client5 + $fundsondeposit->Joint_Funds_on_Deposit_Percent_Marital_Equity_to_Client6 + $fundsondeposit->Joint_Funds_on_Deposit_Percent_Marital_Equity_to_Client7 + $fundsondeposit->Joint_Funds_on_Deposit_Percent_Marital_Equity_to_Client8 + $fundsondeposit->Joint_Funds_on_Deposit_Percent_Marital_Equity_to_Client9 + $fundsondeposit->Joint_Funds_on_Deposit_Percent_Marital_Equity_to_Client10 + $fundsondeposit->Client_Funds_on_Deposit_Percent_Marital_Equity_to_Client1 + $fundsondeposit->Client_Funds_on_Deposit_Percent_Marital_Equity_to_Client2 + $fundsondeposit->Client_Funds_on_Deposit_Percent_Marital_Equity_to_Client3 + $fundsondeposit->Client_Funds_on_Deposit_Percent_Marital_Equity_to_Client4 + $fundsondeposit->Client_Funds_on_Deposit_Percent_Marital_Equity_to_Client5 + $fundsondeposit->Client_Funds_on_Deposit_Percent_Marital_Equity_to_Client6 + $fundsondeposit->Client_Funds_on_Deposit_Percent_Marital_Equity_to_Client7 + $fundsondeposit->Client_Funds_on_Deposit_Percent_Marital_Equity_to_Client8 + $fundsondeposit->Client_Funds_on_Deposit_Percent_Marital_Equity_to_Client9 + $fundsondeposit->Client_Funds_on_Deposit_Percent_Marital_Equity_to_Client10 + $fundsondeposit->Op_Funds_on_Deposit_Percent_Marital_Equity_to_Client1 + $fundsondeposit->Op_Funds_on_Deposit_Percent_Marital_Equity_to_Client2 + $fundsondeposit->Op_Funds_on_Deposit_Percent_Marital_Equity_to_Client3 + $fundsondeposit->Op_Funds_on_Deposit_Percent_Marital_Equity_to_Client4 + $fundsondeposit->Op_Funds_on_Deposit_Percent_Marital_Equity_to_Client5 + $fundsondeposit->Op_Funds_on_Deposit_Percent_Marital_Equity_to_Client6 + $fundsondeposit->Op_Funds_on_Deposit_Percent_Marital_Equity_to_Client7 + $fundsondeposit->Op_Funds_on_Deposit_Percent_Marital_Equity_to_Client8 + $fundsondeposit->Op_Funds_on_Deposit_Percent_Marital_Equity_to_Client9 + $fundsondeposit->Op_Funds_on_Deposit_Percent_Marital_Equity_to_Client10;

            $Joint_Client_Op_Funds_on_Deposit_Equity_to_Op = $fundsondeposit->Joint_Funds_on_Deposit_Percent_Marital_Equity_to_Op1 + $fundsondeposit->Joint_Funds_on_Deposit_Percent_Marital_Equity_to_Op2 + $fundsondeposit->Joint_Funds_on_Deposit_Percent_Marital_Equity_to_Op3 + $fundsondeposit->Joint_Funds_on_Deposit_Percent_Marital_Equity_to_Op4 + $fundsondeposit->Joint_Funds_on_Deposit_Percent_Marital_Equity_to_Op5 + $fundsondeposit->Joint_Funds_on_Deposit_Percent_Marital_Equity_to_Op6 + $fundsondeposit->Joint_Funds_on_Deposit_Percent_Marital_Equity_to_Op7 + $fundsondeposit->Joint_Funds_on_Deposit_Percent_Marital_Equity_to_Op8 + $fundsondeposit->Joint_Funds_on_Deposit_Percent_Marital_Equity_to_Op9 + $fundsondeposit->Joint_Funds_on_Deposit_Percent_Marital_Equity_to_Op10 + $fundsondeposit->Client_Funds_on_Deposit_Percent_Marital_Equity_to_Op1 + $fundsondeposit->Client_Funds_on_Deposit_Percent_Marital_Equity_to_Op2 + $fundsondeposit->Client_Funds_on_Deposit_Percent_Marital_Equity_to_Op3 + $fundsondeposit->Client_Funds_on_Deposit_Percent_Marital_Equity_to_Op4 + $fundsondeposit->Client_Funds_on_Deposit_Percent_Marital_Equity_to_Op5 + $fundsondeposit->Client_Funds_on_Deposit_Percent_Marital_Equity_to_Op6 + $fundsondeposit->Client_Funds_on_Deposit_Percent_Marital_Equity_to_Op7 + $fundsondeposit->Client_Funds_on_Deposit_Percent_Marital_Equity_to_Op8 + $fundsondeposit->Client_Funds_on_Deposit_Percent_Marital_Equity_to_Op9 + $fundsondeposit->Client_Funds_on_Deposit_Percent_Marital_Equity_to_Op10 + $fundsondeposit->Op_Funds_on_Deposit_Percent_Marital_Equity_to_Op1 + $fundsondeposit->Op_Funds_on_Deposit_Percent_Marital_Equity_to_Op2 + $fundsondeposit->Op_Funds_on_Deposit_Percent_Marital_Equity_to_Op3 + $fundsondeposit->Op_Funds_on_Deposit_Percent_Marital_Equity_to_Op4 + $fundsondeposit->Op_Funds_on_Deposit_Percent_Marital_Equity_to_Op5 + $fundsondeposit->Op_Funds_on_Deposit_Percent_Marital_Equity_to_Op6 + $fundsondeposit->Op_Funds_on_Deposit_Percent_Marital_Equity_to_Op7 + $fundsondeposit->Op_Funds_on_Deposit_Percent_Marital_Equity_to_Op8 + $fundsondeposit->Op_Funds_on_Deposit_Percent_Marital_Equity_to_Op9 + $fundsondeposit->Op_Funds_on_Deposit_Percent_Marital_Equity_to_Op10;

            $client_drfundsondeposit_amount=$yearly_funds_on_deposit_interest_divident * ($Joint_Client_Op_Funds_on_Deposit_Equity_to_Client/100);
            $opponent_drfundsondeposit_amount=$yearly_funds_on_deposit_interest_divident * ($Joint_Client_Op_Funds_on_Deposit_Equity_to_Op/100);


            // N/A, Calculated from dr_Stocks_Investments & dr_FundsOnDeposit = SUM(Joint/Client/Op_StockInvestments_Yearly_Interest_Dividend * Joint/Client/Op_StockInvestments_Percent_Marital_Equity_to_Client ) + SUM(Joint/Client/Op_Funds_on_Deposit_Institution_Yearly_Interest_Dividend * Joint/Client/Op Funds_on_Deposit_Percent_Marital_Equity_to_Client );

            // N/A, Calculated from dr_Stocks_Investments & dr_FundsOnDeposit = SUM(Joint/Client/Op_StockInvestments_Yearly_Interest_Dividend * Joint/Client/Op_StockInvestments_Percent_Marital_Equity_to_Op ) + SUM(Joint/Client/Op_Funds_on_Deposit_Institution_Yearly_Interest_Dividend * Joint/Client/Op Funds_on_Deposit_Percent_Marital_Equity_to_Op );

            $Client_Interest_Dividends = $client_drstockinvestment_amount + $client_drfundsondeposit_amount;
            $Op_Interest_Dividends = $opponent_drstockinvestment_amount + $opponent_drfundsondeposit_amount;
            $Client_Interest_Dividends=round($Client_Interest_Dividends,2);
            $Op_Interest_Dividends=round($Op_Interest_Dividends,2);
            

        } else {
            return redirect()->route('cases.family_law_interview_tabs',$case_id)->with('error', 'Complete Funds on Deposit Info Section First.');
        }
        $personalinfo=DrPersonalInfo::where('case_id',$case_id)->get()->first();
        if(isset($personalinfo)){
            // Client_Yearly_Spousal_Support_Received_Not_This_Marriage =N/A, Calculated from dr_PersonalInfo * 12
            // Response:- Confirmed with proviso that it is First Prior Divorce Monthly Spousal Support RECEIVED + Second Prior Divorce Monthly Spousal Support RECEIVED.

            $Client_Yearly_Spousal_Support_Received_Not_This_Marriage= 12 * ($personalinfo->Client_Info_Prior_Divorce1_Support_RECEIVED + $personalinfo->Client_Info_Prior_Divorce2_Support_RECEIVED);

            $Op_Yearly_Spousal_Support_Received_Not_This_Marriage= 12 * ($personalinfo->Op_Info_Prior_Divorce1_Support_RECEIVED + $personalinfo->Op_Info_Prior_Divorce2_Support_RECEIVED);

            $Client_Yearly_Spousal_Support_Received_Not_This_Marriage=round($Client_Yearly_Spousal_Support_Received_Not_This_Marriage,2);
            $Op_Yearly_Spousal_Support_Received_Not_This_Marriage=round($Op_Yearly_Spousal_Support_Received_Not_This_Marriage,2);


        } else {
            return redirect()->route('cases.family_law_interview_tabs',$case_id)->with('error', 'Complete Personal Info Section First.');
        }
        $childreninfo=DrChildren::where('case_id',$case_id)->get()->first();
        if(isset($childreninfo)){
        // Client_Monthly_Gets_Child_Support_NoM = N/A, Calculated from dr_Children

        // Please elaborate which field from dr_Children to be used here for calculation.

        //  Response:- We’ll need to use all child support received for children belonging to Client who were not children of this marriage.

        // =SUM(Lines 129,  141, 153, 165, 177, 189)

           // line 129 = Client_First_Child_NOM_Monthly_Child_Support_RECEIVED
           // line 141 = Client_Second_Child_NOM_Monthly_Child_Support_RECEIVED
           // line 153 = Client_Third_Child_NOM_Monthly_Child_Support_RECEIVED
           // line 165 = Client_Fourth_Child_NOM_Monthly_Child_Support_RECEIVED
           // line 177 = Client_Fifth_Child_NOM_Monthly_Child_Support_RECEIVED
           // line 189 = Client_Sixth_Child_NOM_Monthly_Child_Support_RECEIVED

            $Client_Monthly_Gets_Child_Support_NoM=$childreninfo->Client_First_Child_NOM_Monthly_Child_Support_RECEIVED + $childreninfo->Client_Second_Child_NOM_Monthly_Child_Support_RECEIVED + $childreninfo->Client_Third_Child_NOM_Monthly_Child_Support_RECEIVED + $childreninfo->Client_Fourth_Child_NOM_Monthly_Child_Support_RECEIVED + $childreninfo->Client_Fifth_Child_NOM_Monthly_Child_Support_RECEIVED + $childreninfo->Client_Sixth_Child_NOM_Monthly_Child_Support_RECEIVED;

            $Op_Monthly_Gets_Child_Support_NoM=$childreninfo->Op_First_Child_NOM_Monthly_Child_Support_RECEIVED + $childreninfo->Op_Second_Child_NOM_Monthly_Child_Support_RECEIVED + $childreninfo->Op_Third_Child_NOM_Monthly_Child_Support_RECEIVED + $childreninfo->Op_Fourth_Child_NOM_Monthly_Child_Support_RECEIVED + $childreninfo->Op_Fifth_Child_NOM_Monthly_Child_Support_RECEIVED + $childreninfo->Op_Sixth_Child_NOM_Monthly_Child_Support_RECEIVED;

            $Client_Monthly_Gets_Child_Support_NoM=round($Client_Monthly_Gets_Child_Support_NoM,2);
            $Op_Monthly_Gets_Child_Support_NoM=round($Op_Monthly_Gets_Child_Support_NoM,2);

        } else {
            return redirect()->route('cases.family_law_interview_tabs',$case_id)->with('error', 'Complete Children Info Section First.');
        }

        $data=array(
            'realestateinfo' => $realestate,
            'pensioninfo' => $pension,
            'retirementaccountsinfo' => $retirementaccounts,
            'stockinvestmentinfo' => $stockinvestment,
            'fundsondepositinfo' => $fundsondeposit,
            'personalinfo' => $personalinfo,
            'childreninfo' => $childreninfo,
            'Client_Rent' => $Client_Rent,
            'Op_Rent' => $Op_Rent,
            'Client_Retirement_Pensions' => $Client_Retirement_Pensions,
            'Op_Retirement_Pensions' => $Op_Retirement_Pensions,
            'Client_Interest_Dividends' => $Client_Interest_Dividends,
            'Op_Interest_Dividends' => $Op_Interest_Dividends,
            'Client_Yearly_Spousal_Support_Received_Not_This_Marriage' => $Client_Yearly_Spousal_Support_Received_Not_This_Marriage,
            'Op_Yearly_Spousal_Support_Received_Not_This_Marriage' => $Op_Yearly_Spousal_Support_Received_Not_This_Marriage,
            'Client_Monthly_Gets_Child_Support_NoM' => $Client_Monthly_Gets_Child_Support_NoM,
            'Op_Monthly_Gets_Child_Support_NoM' => $Op_Monthly_Gets_Child_Support_NoM,
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
        return view('dr_tables.dr_Income.create',['client_name'=>$client_name, 'opponent_name'=>$opponent_name, 'case_data' => $case_data, 'data' => $data]);
    }

    // save tab info in database table.
    public function store(Request $request)
    {
        $result = $request->except('submit');

        if(isset($result['Client_Employed']) && $result['Client_Employed']=='Yes'){
        } else {
            $result['Client_Inc_Employer']=NULL;
            $result['Client_Inc_Employer_Payroll_Street_Address']=NULL;
            $result['Client_Inc_Employer_Payroll_City_State_Zip']=NULL;
        }

        if(isset($result['Client_RegWage_YTD_MinWage']) && $result['Client_RegWage_YTD_MinWage']=='1'){
            $result['Client_Wages_per_Period']=$result['Client_Wages_per_Period'];
            $result['Client_Pay_Periods_Yearly']=$result['Client_Pay_Periods_Yearly'];
        } else {
            $result['Client_Wages_per_Period']=NULL;
            $result['Client_Pay_Periods_Yearly']=NULL;
        }

        if(isset($result['Client_RegWage_YTD_MinWage']) && $result['Client_RegWage_YTD_MinWage']=='2'){
            $result['Client_Pay_YTD']=$result['Client_Pay_YTD'];
            $result['Client_YTD_Date']=$result['Client_YTD_Date'];
            if(isset($result['Client_YTD_Date'])){
                $result['Client_YTD_Date']=date("Y-m-d",strtotime($result['Client_YTD_Date']));
            } else {
                $result['Client_YTD_Date']=NULL;
            }

        } else{
            $result['Client_Pay_YTD']=NULL;
            $result['Client_YTD_Date']=NULL;
        }

        // new calculations for client
        $result['Client_Total_Yearly_Income']=0.00;
        if(isset($result['Client_Base_Yearly_Wages']) && $result['Client_Base_Yearly_Wages']!=''){
            $result['Client_Total_Yearly_Income']=$result['Client_Total_Yearly_Income']+$result['Client_Base_Yearly_Wages'];
        }
        if(isset($result['Client_Min_Ave_OT_Comms_Bonuses']) && $result['Client_Min_Ave_OT_Comms_Bonuses']!=''){
            $result['Client_Total_Yearly_Income']=$result['Client_Total_Yearly_Income']+$result['Client_Min_Ave_OT_Comms_Bonuses'];
        }
        if(isset($result['Client_Yearly_Unemployment_Compensation']) && $result['Client_Yearly_Unemployment_Compensation']!=''){
            $result['Client_Total_Yearly_Income']=$result['Client_Total_Yearly_Income']+$result['Client_Yearly_Unemployment_Compensation'];
        }
        if(isset($result['Client_Yearly_Workers_Compensation']) && $result['Client_Yearly_Workers_Compensation']!=''){
            $result['Client_Total_Yearly_Income']=$result['Client_Total_Yearly_Income']+$result['Client_Yearly_Workers_Compensation'];
        }
        if(isset($result['Client_Yearly_Social_Security_Disability']) && $result['Client_Yearly_Social_Security_Disability']!=''){
            $result['Client_Total_Yearly_Income']=$result['Client_Total_Yearly_Income']+$result['Client_Yearly_Social_Security_Disability'];
        }
        if(isset($result['Client_Yearly_Other_Disability_Income']) && $result['Client_Yearly_Other_Disability_Income']!=''){
            $result['Client_Total_Yearly_Income']=$result['Client_Total_Yearly_Income']+$result['Client_Yearly_Other_Disability_Income'];
        }
        if(isset($result['Client_Yearly_Social_Security_Retirement']) && $result['Client_Yearly_Social_Security_Retirement']!=''){
            $result['Client_Total_Yearly_Income']=$result['Client_Total_Yearly_Income']+$result['Client_Yearly_Social_Security_Retirement'];
        }
        if(isset($result['Client_Retirement_Pensions']) && $result['Client_Retirement_Pensions']!=''){
            $result['Client_Total_Yearly_Income']=$result['Client_Total_Yearly_Income']+$result['Client_Retirement_Pensions'];
        }
        if(isset($result['Client_Yearly_Gross_Self_Employment_Income']) && $result['Client_Yearly_Gross_Self_Employment_Income']!=''){
            $result['Client_Total_Yearly_Income']=$result['Client_Total_Yearly_Income']+$result['Client_Yearly_Gross_Self_Employment_Income'];
        }
        if(isset($result['Client_Yearly_Self_Employment_Expenses']) && $result['Client_Yearly_Self_Employment_Expenses']!=''){
            $result['Client_Total_Yearly_Income']=$result['Client_Total_Yearly_Income']-$result['Client_Yearly_Self_Employment_Expenses'];
        }
        if(isset($result['Client_Interest_Dividends']) && $result['Client_Interest_Dividends']!=''){
            $result['Client_Total_Yearly_Income']=$result['Client_Total_Yearly_Income']+$result['Client_Interest_Dividends'];
        }
        if(isset($result['Client_Yearly_Spousal_Support_Received_Not_This_Marriage']) && $result['Client_Yearly_Spousal_Support_Received_Not_This_Marriage']!=''){
            $result['Client_Total_Yearly_Income']=$result['Client_Total_Yearly_Income']+$result['Client_Yearly_Spousal_Support_Received_Not_This_Marriage'];
        }

        // new calculations for op
        $result['Op_Total_Yearly_Income']=0.00;
        if(isset($result['Op_Base_Yearly_Wages']) && $result['Op_Base_Yearly_Wages']!=''){
            $result['Op_Total_Yearly_Income']=$result['Op_Total_Yearly_Income']+$result['Op_Base_Yearly_Wages'];
        }
        if(isset($result['Op_Min_Ave_OT_Comms_Bonuses']) && $result['Op_Min_Ave_OT_Comms_Bonuses']!=''){
            $result['Op_Total_Yearly_Income']=$result['Op_Total_Yearly_Income']+$result['Op_Min_Ave_OT_Comms_Bonuses'];
        }
        if(isset($result['Op_Yearly_Unemployment_Compensation']) && $result['Op_Yearly_Unemployment_Compensation']!=''){
            $result['Op_Total_Yearly_Income']=$result['Op_Total_Yearly_Income']+$result['Op_Yearly_Unemployment_Compensation'];
        }
        if(isset($result['Op_Yearly_Workers_Compensation']) && $result['Op_Yearly_Workers_Compensation']!=''){
            $result['Op_Total_Yearly_Income']=$result['Op_Total_Yearly_Income']+$result['Op_Yearly_Workers_Compensation'];
        }
        if(isset($result['Op_Yearly_Social_Security_Disability']) && $result['Op_Yearly_Social_Security_Disability']!=''){
            $result['Op_Total_Yearly_Income']=$result['Op_Total_Yearly_Income']+$result['Op_Yearly_Social_Security_Disability'];
        }
        if(isset($result['Op_Yearly_Other_Disability_Income']) && $result['Op_Yearly_Other_Disability_Income']!=''){
            $result['Op_Total_Yearly_Income']=$result['Op_Total_Yearly_Income']+$result['Op_Yearly_Other_Disability_Income'];
        }
        if(isset($result['Op_Yearly_Social_Security_Retirement']) && $result['Op_Yearly_Social_Security_Retirement']!=''){
            $result['Op_Total_Yearly_Income']=$result['Op_Total_Yearly_Income']+$result['Op_Yearly_Social_Security_Retirement'];
        }
        if(isset($result['Op_Retirement_Pensions']) && $result['Op_Retirement_Pensions']!=''){
            $result['Op_Total_Yearly_Income']=$result['Op_Total_Yearly_Income']+$result['Op_Retirement_Pensions'];
        }
        if(isset($result['Op_Yearly_Gross_Self_Employment_Income']) && $result['Op_Yearly_Gross_Self_Employment_Income']!=''){
            $result['Op_Total_Yearly_Income']=$result['Op_Total_Yearly_Income']+$result['Op_Yearly_Gross_Self_Employment_Income'];
        }
        if(isset($result['Op_Yearly_Self_Employment_Expenses']) && $result['Op_Yearly_Self_Employment_Expenses']!=''){
            $result['Op_Total_Yearly_Income']=$result['Op_Total_Yearly_Income']-$result['Op_Yearly_Self_Employment_Expenses'];
        }
        if(isset($result['Op_Interest_Dividends']) && $result['Op_Interest_Dividends']!=''){
            $result['Op_Total_Yearly_Income']=$result['Op_Total_Yearly_Income']+$result['Op_Interest_Dividends'];
        }
        if(isset($result['Op_Yearly_Spousal_Support_Received_Not_This_Marriage']) && $result['Op_Yearly_Spousal_Support_Received_Not_This_Marriage']!=''){
            $result['Op_Total_Yearly_Income']=$result['Op_Total_Yearly_Income']+$result['Op_Yearly_Spousal_Support_Received_Not_This_Marriage'];
        }

        if(isset($result['Client_Other_Source_Income']) && $result['Client_Other_Source_Income']=='1'){
        } else {
            $result['Client_Other_Source_Income']='0';
            $result['Client_Other_Source_Name1']=NULL;
            $result['Client_Other_Source_Zip1']=NULL;
            $result['Client_Other_Source_Street_Address1']=NULL;
            $result['Client_Other_Source_City1']=NULL;
            $result['Client_Other_Source_State1']=NULL;
            $result['Client_Other_Source_Acct_Num_or_Description1']=NULL;
            $result['Client_Other_Source_Yearly_Income1']=NULL;
            $result['Client_Other_Source_Name2']=NULL;
            $result['Client_Other_Source_Zip2']=NULL;
            $result['Client_Other_Source_Street_Address2']=NULL;
            $result['Client_Other_Source_City2']=NULL;
            $result['Client_Other_Source_State2']=NULL;
            $result['Client_Other_Source_Acct_Num_or_Description2']=NULL;
            $result['Client_Other_Source_Yearly_Income2']=NULL;
            $result['Client_Other_Source_Name3']=NULL;
            $result['Client_Other_Source_Zip3']=NULL;
            $result['Client_Other_Source_Street_Address3']=NULL;
            $result['Client_Other_Source_City3']=NULL;
            $result['Client_Other_Source_State3']=NULL;
            $result['Client_Other_Source_Acct_Num_or_Description3']=NULL;
            $result['Client_Other_Source_Yearly_Income3']=NULL;
            $result['Client_Other_Source_Name4']=NULL;
            $result['Client_Other_Source_Zip4']=NULL;
            $result['Client_Other_Source_Street_Address4']=NULL;
            $result['Client_Other_Source_City4']=NULL;
            $result['Client_Other_Source_State4']=NULL;
            $result['Client_Other_Source_Acct_Num_or_Description4']=NULL;
            $result['Client_Other_Source_Yearly_Income4']=NULL;
            $result['Client_Other_Source_Name5']=NULL;
            $result['Client_Other_Source_Zip5']=NULL;
            $result['Client_Other_Source_Street_Address5']=NULL;
            $result['Client_Other_Source_City5']=NULL;
            $result['Client_Other_Source_State5']=NULL;
            $result['Client_Other_Source_Acct_Num_or_Description5']=NULL;
            $result['Client_Other_Source_Yearly_Income5']=NULL;
            $result['Client_Other_Yearly_Income_Total']=NULL;
            $result['Client_Total_Yearly_Income']=NULL;
        }

        // for Op

        if(isset($result['Op_Employed']) && $result['Op_Employed']=='Yes'){
        } else {
            $result['Op_Inc_Employer']=NULL;
            $result['Op_Inc_Employer_Payroll_Street_Address']=NULL;
            $result['Op_Inc_Employer_Payroll_City_State_Zip']=NULL;
        }

        if(isset($result['Op_RegWage_YTD_MinWage']) && $result['Op_RegWage_YTD_MinWage']=='1'){
            $result['Op_Wages_per_Period']=$result['Op_Wages_per_Period'];
            $result['Op_Pay_Periods_Yearly']=$result['Op_Pay_Periods_Yearly'];
        } else {
            $result['Op_Wages_per_Period']=NULL;
            $result['Op_Pay_Periods_Yearly']=NULL;
        }

        if(isset($result['Op_RegWage_YTD_MinWage']) && $result['Op_RegWage_YTD_MinWage']=='2'){
            $result['Op_Pay_YTD']=$result['Op_Pay_YTD'];
            $result['Op_YTD_Date']=$result['Op_YTD_Date'];
            if(isset($result['Op_YTD_Date'])){
                $result['Op_YTD_Date']=date("Y-m-d",strtotime($result['Op_YTD_Date']));
            } else {
                $result['Op_YTD_Date']=NULL;
            }

        } else{
            $result['Op_Pay_YTD']=NULL;
            $result['Op_YTD_Date']=NULL;
        }

        if(isset($result['Op_Other_Source_Income']) && $result['Op_Other_Source_Income']=='1'){
        } else {
            $result['Op_Other_Source_Income']='0';
            $result['Op_Other_Source_Name1']=NULL;
            $result['Op_Other_Source_Zip1']=NULL;
            $result['Op_Other_Source_Street_Address1']=NULL;
            $result['Op_Other_Source_City1']=NULL;
            $result['Op_Other_Source_State1']=NULL;
            $result['Op_Other_Source_Acct_Num_or_Description1']=NULL;
            $result['Op_Other_Source_Yearly_Income1']=NULL;
            $result['Op_Other_Source_Name2']=NULL;
            $result['Op_Other_Source_Zip2']=NULL;
            $result['Op_Other_Source_Street_Address2']=NULL;
            $result['Op_Other_Source_City2']=NULL;
            $result['Op_Other_Source_State2']=NULL;
            $result['Op_Other_Source_Acct_Num_or_Description2']=NULL;
            $result['Op_Other_Source_Yearly_Income2']=NULL;
            $result['Op_Other_Source_Name3']=NULL;
            $result['Op_Other_Source_Zip3']=NULL;
            $result['Op_Other_Source_Street_Address3']=NULL;
            $result['Op_Other_Source_City3']=NULL;
            $result['Op_Other_Source_State3']=NULL;
            $result['Op_Other_Source_Acct_Num_or_Description3']=NULL;
            $result['Op_Other_Source_Yearly_Income3']=NULL;
            $result['Op_Other_Source_Name4']=NULL;
            $result['Op_Other_Source_Zip4']=NULL;
            $result['Op_Other_Source_Street_Address4']=NULL;
            $result['Op_Other_Source_City4']=NULL;
            $result['Op_Other_Source_State4']=NULL;
            $result['Op_Other_Source_Acct_Num_or_Description4']=NULL;
            $result['Op_Other_Source_Yearly_Income4']=NULL;
            $result['Op_Other_Source_Name5']=NULL;
            $result['Op_Other_Source_Zip5']=NULL;
            $result['Op_Other_Source_Street_Address5']=NULL;
            $result['Op_Other_Source_City5']=NULL;
            $result['Op_Other_Source_State5']=NULL;
            $result['Op_Other_Source_Acct_Num_or_Description5']=NULL;
            $result['Op_Other_Source_Yearly_Income5']=NULL;
            $result['Op_Other_Yearly_Income_Total']=NULL;
            $result['Op_Total_Yearly_Income']=NULL;
        }

        // die('In Progress');
        // echo "<pre>";print_r($result);die;
        $drincome=DrIncome::create($result);
        
        return redirect()->route('cases.family_law_interview_tabs',$result['case_id'])->with('success', 'Income Information Submitted Successfully.');
        
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
        
        $drincome=DrIncome::where('case_id',$case_id)->get()->first();

        $realestate=DrRealEstate::where('case_id',$case_id)->get()->first();
        if(isset($realestate)){
            // N/A, Calculated from dr_RealEstate = SUM(Joint/Client/Op_Real_Estate_Client_Share_Rental)

            $Client_Rent = $realestate->Joint_Real_Estate_Client_Share_Rental1 + $realestate->Joint_Real_Estate_Client_Share_Rental2 + $realestate->Joint_Real_Estate_Client_Share_Rental3 + $realestate->Joint_Real_Estate_Client_Share_Rental4 + $realestate->Joint_Real_Estate_Client_Share_Rental5 + $realestate->Cliet_Real_Estate_Client_Share_Rental1 + $realestate->Cliet_Real_Estate_Client_Share_Rental2 + $realestate->Cliet_Real_Estate_Client_Share_Rental3 + $realestate->Cliet_Real_Estate_Client_Share_Rental4 + $realestate->Cliet_Real_Estate_Client_Share_Rental5 + $realestate->Op_Real_Estate_Client_Share_Rental1 + $realestate->Op_Real_Estate_Client_Share_Rental2 + $realestate->Op_Real_Estate_Client_Share_Rental3 + $realestate->Op_Real_Estate_Client_Share_Rental4 + $realestate->Op_Real_Estate_Client_Share_Rental5;

            $Op_Rent = $realestate->Joint_Real_Estate_Op_Share_Rental1 + $realestate->Joint_Real_Estate_Op_Share_Rental2 + $realestate->Joint_Real_Estate_Op_Share_Rental3 + $realestate->Joint_Real_Estate_Op_Share_Rental4 + $realestate->Joint_Real_Estate_Op_Share_Rental5 + $realestate->Cliet_Real_Estate_Op_Share_Rental1 + $realestate->Cliet_Real_Estate_Op_Share_Rental2 + $realestate->Cliet_Real_Estate_Op_Share_Rental3 + $realestate->Cliet_Real_Estate_Op_Share_Rental4 + $realestate->Cliet_Real_Estate_Op_Share_Rental5 + $realestate->Op_Real_Estate_Op_Share_Rental1 + $realestate->Op_Real_Estate_Op_Share_Rental2 + $realestate->Op_Real_Estate_Op_Share_Rental3 + $realestate->Op_Real_Estate_Op_Share_Rental4 + $realestate->Op_Real_Estate_Op_Share_Rental5;

            $Client_Rent=round($Client_Rent,2);
            $Op_Rent=round($Op_Rent,2);

        } else {
            return redirect()->route('cases.family_law_interview_tabs',$case_id)->with('error', 'Complete Real Estate Info Section First.');
        }
        $pension=DrPension::where('case_id',$case_id)->get()->first();
        if(isset($pension)){
            // "N/A, Calculated from dr_Pensions & dr_RetirementAccts =SUM(Client/Op_Pension_Custom_Monthly_Client_Amount) + SUM(Client/Op_RetAcct_Current_Monthly_Income * Client/Op_RetAcct_Percent_Marital_Equity_to_Client )"

            $client_pensions= $pension->Client_Pension1_Custom_Monthly_Client_Amount + $pension->Client_Pension2_Custom_Monthly_Client_Amount + $pension->Client_Pension3_Custom_Monthly_Client_Amount + $pension->Client_Pension4_Custom_Monthly_Client_Amount + $pension->Op_Pension1_Custom_Monthly_Client_Amount + $pension->Op_Pension2_Custom_Monthly_Client_Amount + $pension->Op_Pension3_Custom_Monthly_Client_Amount + $pension->Op_Pension4_Custom_Monthly_Client_Amount;

            $opponent_pensions= $pension->Client_Pension1_Custom_Monthly_Op_Amount + $pension->Client_Pension2_Custom_Monthly_Op_Amount + $pension->Client_Pension3_Custom_Monthly_Op_Amount + $pension->Client_Pension4_Custom_Monthly_Op_Amount + $pension->Op_Pension1_Custom_Monthly_Op_Amount + $pension->Op_Pension2_Custom_Monthly_Op_Amount + $pension->Op_Pension3_Custom_Monthly_Op_Amount + $pension->Op_Pension4_Custom_Monthly_Op_Amount;

        } else {
            return redirect()->route('cases.family_law_interview_tabs',$case_id)->with('error', 'Complete Pension Info Section First.');
        }
        $retirementaccounts=DrRetirementAccts::where('case_id',$case_id)->get()->first();
        if(isset($retirementaccounts)){
            $Client_Op_RetAcct_Equity_to_Client=$retirementaccounts->Client_RetAcct1_Percent_Marital_Equity_to_Client + $retirementaccounts->Client_RetAcct2_Percent_Marital_Equity_to_Client + $retirementaccounts->Client_RetAcct3_Percent_Marital_Equity_to_Client + $retirementaccounts->Client_RetAcct4_Percent_Marital_Equity_to_Client + $retirementaccounts->Op_RetAcct1_Percent_Marital_Equity_to_Client + $retirementaccounts->Op_RetAcct2_Percent_Marital_Equity_to_Client + $retirementaccounts->Op_RetAcct3_Percent_Marital_Equity_to_Client + $retirementaccounts->Op_RetAcct4_Percent_Marital_Equity_to_Client;

            $Client_Op_RetAcct_Equity_to_Op=$retirementaccounts->Client_RetAcct1_Percent_Marital_Equity_to_Op + $retirementaccounts->Client_RetAcct2_Percent_Marital_Equity_to_Op + $retirementaccounts->Client_RetAcct3_Percent_Marital_Equity_to_Op + $retirementaccounts->Client_RetAcct4_Percent_Marital_Equity_to_Op + $retirementaccounts->Op_RetAcct1_Percent_Marital_Equity_to_Op + $retirementaccounts->Op_RetAcct2_Percent_Marital_Equity_to_Op + $retirementaccounts->Op_RetAcct3_Percent_Marital_Equity_to_Op + $retirementaccounts->Op_RetAcct4_Percent_Marital_Equity_to_Op;

            $client_op_recacct_monthly_income= $retirementaccounts->Client_RetAcct1_Current_Monthly_Income + $retirementaccounts->Client_RetAcct2_Current_Monthly_Income + $retirementaccounts->Client_RetAcct3_Current_Monthly_Income + $retirementaccounts->Client_RetAcct4_Current_Monthly_Income + $retirementaccounts->Op_RetAcct1_Current_Monthly_Income + $retirementaccounts->Op_RetAcct2_Current_Monthly_Income + $retirementaccounts->Op_RetAcct3_Current_Monthly_Income + $retirementaccounts->Op_RetAcct4_Current_Monthly_Income;

            //"N/A, Calculated from dr_Pensions & dr_RetirementAccts =SUM(Client/Op_Pension1_Custom_Monthly_Client_Amount) + SUM(Client/Op_RetAcct1_Current_Monthly_Income * Client/Op_RetAcct1_Percent_Marital_Equity_to_Client )"

            //"N/A, Calculated from dr_Pensions & dr_RetirementAccts =SUM(Client/Op_Pension1_Custom_Monthly_Op_Amount) + SUM(Client/Op_RetAcct1_Current_Monthly_Income * Client/Op_RetAcct1_Percent_Marital_Equity_to_Op );

            $Client_Retirement_Pensions = $client_pensions + ($client_op_recacct_monthly_income * $Client_Op_RetAcct_Equity_to_Client/100);
            $Client_Retirement_Pensions = $Client_Retirement_Pensions * 12;

            $Op_Retirement_Pensions = $opponent_pensions + ($client_op_recacct_monthly_income * $Client_Op_RetAcct_Equity_to_Op/100);
            $Op_Retirement_Pensions = $Op_Retirement_Pensions * 12;

            $Client_Retirement_Pensions=round($Client_Retirement_Pensions,2);
            $Op_Retirement_Pensions=round($Op_Retirement_Pensions,2);


        } else {
            return redirect()->route('cases.family_law_interview_tabs',$case_id)->with('error', 'Complete Retirement Accounts Info Section First.');
        }
        $stockinvestment=DrStocksInvestments::where('case_id',$case_id)->get()->first();
        if(isset($stockinvestment)){
            // N/A, Calculated from dr_Stocks_Investments & dr_FundsOnDeposit = SUM(Joint/Client/Op_StockInvestments_Yearly_Interest_Dividend * Joint/Client/Op_StockInvestments_Percent_Marital_Equity_to_Client ) + SUM(Joint/Client/Op_Funds_on_Deposit_Institution_Yearly_Interest_Dividend * Joint/Client/Op Funds_on_Deposit_Percent_Marital_Equity_to_Client );

            // N/A, Calculated from dr_Stocks_Investments & dr_FundsOnDeposit = SUM(Joint/Client/Op_StockInvestments_Yearly_Interest_Dividend * Joint/Client/Op_StockInvestments_Percent_Marital_Equity_to_Op ) + SUM(Joint/Client/Op_Funds_on_Deposit_Institution_Yearly_Interest_Dividend * Joint/Client/Op Funds_on_Deposit_Percent_Marital_Equity_to_Op );

            $yearly_interest_divident = $stockinvestment->Joint_StockInvestments_Yearly_Interest_Dividend1 + $stockinvestment->Joint_StockInvestments_Yearly_Interest_Dividend2 + $stockinvestment->Joint_StockInvestments_Yearly_Interest_Dividend3 + $stockinvestment->Joint_StockInvestments_Yearly_Interest_Dividend4 + $stockinvestment->Joint_StockInvestments_Yearly_Interest_Dividend5 + $stockinvestment->Joint_StockInvestments_Yearly_Interest_Dividend6 + $stockinvestment->Joint_StockInvestments_Yearly_Interest_Dividend7 + $stockinvestment->Joint_StockInvestments_Yearly_Interest_Dividend8 + $stockinvestment->Joint_StockInvestments_Yearly_Interest_Dividend9 + $stockinvestment->Joint_StockInvestments_Yearly_Interest_Dividend10 + $stockinvestment->Client_StockInvestments_Yearly_Interest_Dividend1 + $stockinvestment->Client_StockInvestments_Yearly_Interest_Dividend2 + $stockinvestment->Client_StockInvestments_Yearly_Interest_Dividend3 + $stockinvestment->Client_StockInvestments_Yearly_Interest_Dividend4 + $stockinvestment->Client_StockInvestments_Yearly_Interest_Dividend5 + $stockinvestment->Client_StockInvestments_Yearly_Interest_Dividend6 + $stockinvestment->Client_StockInvestments_Yearly_Interest_Dividend7 + $stockinvestment->Client_StockInvestments_Yearly_Interest_Dividend8 + $stockinvestment->Client_StockInvestments_Yearly_Interest_Dividend9 + $stockinvestment->Client_StockInvestments_Yearly_Interest_Dividend10 + $stockinvestment->Op_StockInvestments_Yearly_Interest_Dividend1 + $stockinvestment->Op_StockInvestments_Yearly_Interest_Dividend2 + $stockinvestment->Op_StockInvestments_Yearly_Interest_Dividend3 + $stockinvestment->Op_StockInvestments_Yearly_Interest_Dividend4 + $stockinvestment->Op_StockInvestments_Yearly_Interest_Dividend5 + $stockinvestment->Op_StockInvestments_Yearly_Interest_Dividend6 + $stockinvestment->Op_StockInvestments_Yearly_Interest_Dividend7 + $stockinvestment->Op_StockInvestments_Yearly_Interest_Dividend8 + $stockinvestment->Op_StockInvestments_Yearly_Interest_Dividend9 + $stockinvestment->Op_StockInvestments_Yearly_Interest_Dividend10;

                $Joint_Client_Op_StockInvestments_Equity_to_Client = $stockinvestment->Joint_StockInvestments_Percent_Marital_Equity_to_Client1 + $stockinvestment->Joint_StockInvestments_Percent_Marital_Equity_to_Client2 + $stockinvestment->Joint_StockInvestments_Percent_Marital_Equity_to_Client3 + $stockinvestment->Joint_StockInvestments_Percent_Marital_Equity_to_Client4 + $stockinvestment->Joint_StockInvestments_Percent_Marital_Equity_to_Client5 + $stockinvestment->Joint_StockInvestments_Percent_Marital_Equity_to_Client6 + $stockinvestment->Joint_StockInvestments_Percent_Marital_Equity_to_Client7 + $stockinvestment->Joint_StockInvestments_Percent_Marital_Equity_to_Client8 + $stockinvestment->Joint_StockInvestments_Percent_Marital_Equity_to_Client9 + $stockinvestment->Joint_StockInvestments_Percent_Marital_Equity_to_Client10 + $stockinvestment->Client_StockInvestments_Percent_Marital_Equity_to_Client1 + $stockinvestment->Client_StockInvestments_Percent_Marital_Equity_to_Client2 + $stockinvestment->Client_StockInvestments_Percent_Marital_Equity_to_Client3 + $stockinvestment->Client_StockInvestments_Percent_Marital_Equity_to_Client4 + $stockinvestment->Client_StockInvestments_Percent_Marital_Equity_to_Client5 + $stockinvestment->Client_StockInvestments_Percent_Marital_Equity_to_Client6 + $stockinvestment->Client_StockInvestments_Percent_Marital_Equity_to_Client7 + $stockinvestment->Client_StockInvestments_Percent_Marital_Equity_to_Client8 + $stockinvestment->Client_StockInvestments_Percent_Marital_Equity_to_Client9 + $stockinvestment->Client_StockInvestments_Percent_Marital_Equity_to_Client10 + $stockinvestment->Op_StockInvestments_Percent_Marital_Equity_to_Client1 + $stockinvestment->Op_StockInvestments_Percent_Marital_Equity_to_Client2 + $stockinvestment->Op_StockInvestments_Percent_Marital_Equity_to_Client3 + $stockinvestment->Op_StockInvestments_Percent_Marital_Equity_to_Client4 + $stockinvestment->Op_StockInvestments_Percent_Marital_Equity_to_Client5 + $stockinvestment->Op_StockInvestments_Percent_Marital_Equity_to_Client6 + $stockinvestment->Op_StockInvestments_Percent_Marital_Equity_to_Client7 + $stockinvestment->Op_StockInvestments_Percent_Marital_Equity_to_Client8 + $stockinvestment->Op_StockInvestments_Percent_Marital_Equity_to_Client9 + $stockinvestment->Op_StockInvestments_Percent_Marital_Equity_to_Client10;

                $Joint_Client_Op_StockInvestments_Equity_to_Op = $stockinvestment->Joint_StockInvestments_Percent_Marital_Equity_to_Op1 + $stockinvestment->Joint_StockInvestments_Percent_Marital_Equity_to_Op2 + $stockinvestment->Joint_StockInvestments_Percent_Marital_Equity_to_Op3 + $stockinvestment->Joint_StockInvestments_Percent_Marital_Equity_to_Op4 + $stockinvestment->Joint_StockInvestments_Percent_Marital_Equity_to_Op5 + $stockinvestment->Joint_StockInvestments_Percent_Marital_Equity_to_Op6 + $stockinvestment->Joint_StockInvestments_Percent_Marital_Equity_to_Op7 + $stockinvestment->Joint_StockInvestments_Percent_Marital_Equity_to_Op8 + $stockinvestment->Joint_StockInvestments_Percent_Marital_Equity_to_Op9 + $stockinvestment->Joint_StockInvestments_Percent_Marital_Equity_to_Op10 + $stockinvestment->Client_StockInvestments_Percent_Marital_Equity_to_Op1 + $stockinvestment->Client_StockInvestments_Percent_Marital_Equity_to_Op2 + $stockinvestment->Client_StockInvestments_Percent_Marital_Equity_to_Op3 + $stockinvestment->Client_StockInvestments_Percent_Marital_Equity_to_Op4 + $stockinvestment->Client_StockInvestments_Percent_Marital_Equity_to_Op5 + $stockinvestment->Client_StockInvestments_Percent_Marital_Equity_to_Op6 + $stockinvestment->Client_StockInvestments_Percent_Marital_Equity_to_Op7 + $stockinvestment->Client_StockInvestments_Percent_Marital_Equity_to_Op8 + $stockinvestment->Client_StockInvestments_Percent_Marital_Equity_to_Op9 + $stockinvestment->Client_StockInvestments_Percent_Marital_Equity_to_Op10 + $stockinvestment->Op_StockInvestments_Percent_Marital_Equity_to_Op1 + $stockinvestment->Op_StockInvestments_Percent_Marital_Equity_to_Op2 + $stockinvestment->Op_StockInvestments_Percent_Marital_Equity_to_Op3 + $stockinvestment->Op_StockInvestments_Percent_Marital_Equity_to_Op4 + $stockinvestment->Op_StockInvestments_Percent_Marital_Equity_to_Op5 + $stockinvestment->Op_StockInvestments_Percent_Marital_Equity_to_Op6 + $stockinvestment->Op_StockInvestments_Percent_Marital_Equity_to_Op7 + $stockinvestment->Op_StockInvestments_Percent_Marital_Equity_to_Op8 + $stockinvestment->Op_StockInvestments_Percent_Marital_Equity_to_Op9 + $stockinvestment->Op_StockInvestments_Percent_Marital_Equity_to_Op10;

                $client_drstockinvestment_amount=$yearly_interest_divident * ($Joint_Client_Op_StockInvestments_Equity_to_Client/100);
                $opponent_drstockinvestment_amount=$yearly_interest_divident * ($Joint_Client_Op_StockInvestments_Equity_to_Op/100);


        } else {
            return redirect()->route('cases.family_law_interview_tabs',$case_id)->with('error', 'Complete Stock Investment Info Section First.');
        }
        $fundsondeposit=DrFundsOnDeposit::where('case_id',$case_id)->get()->first();
        if(isset($fundsondeposit)){

            $yearly_funds_on_deposit_interest_divident = $fundsondeposit->Joint_Funds_on_Deposit_Institution_Yearly_Interest_Dividend1 + $fundsondeposit->Joint_Funds_on_Deposit_Institution_Yearly_Interest_Dividend2 + $fundsondeposit->Joint_Funds_on_Deposit_Institution_Yearly_Interest_Dividend3 + $fundsondeposit->Joint_Funds_on_Deposit_Institution_Yearly_Interest_Dividend4 + $fundsondeposit->Joint_Funds_on_Deposit_Institution_Yearly_Interest_Dividend5 + $fundsondeposit->Joint_Funds_on_Deposit_Institution_Yearly_Interest_Dividend6 + $fundsondeposit->Joint_Funds_on_Deposit_Institution_Yearly_Interest_Dividend7 + $fundsondeposit->Joint_Funds_on_Deposit_Institution_Yearly_Interest_Dividend8 + $fundsondeposit->Joint_Funds_on_Deposit_Institution_Yearly_Interest_Dividend9 + $fundsondeposit->Joint_Funds_on_Deposit_Institution_Yearly_Interest_Dividend10 + $fundsondeposit->Client_Funds_on_Deposit_Institution_Yearly_Interest_Dividend1 + $fundsondeposit->Client_Funds_on_Deposit_Institution_Yearly_Interest_Dividend2 + $fundsondeposit->Client_Funds_on_Deposit_Institution_Yearly_Interest_Dividend3 + $fundsondeposit->Client_Funds_on_Deposit_Institution_Yearly_Interest_Dividend4 + $fundsondeposit->Client_Funds_on_Deposit_Institution_Yearly_Interest_Dividend5 + $fundsondeposit->Client_Funds_on_Deposit_Institution_Yearly_Interest_Dividend6 + $fundsondeposit->Client_Funds_on_Deposit_Institution_Yearly_Interest_Dividend7 + $fundsondeposit->Client_Funds_on_Deposit_Institution_Yearly_Interest_Dividend8 + $fundsondeposit->Client_Funds_on_Deposit_Institution_Yearly_Interest_Dividend9 + $fundsondeposit->Client_Funds_on_Deposit_Institution_Yearly_Interest_Dividend10 + $fundsondeposit->Op_Funds_on_Deposit_Institution_Yearly_Interest_Dividend1 + $fundsondeposit->Op_Funds_on_Deposit_Institution_Yearly_Interest_Dividend2 + $fundsondeposit->Op_Funds_on_Deposit_Institution_Yearly_Interest_Dividend3 + $fundsondeposit->Op_Funds_on_Deposit_Institution_Yearly_Interest_Dividend4 + $fundsondeposit->Op_Funds_on_Deposit_Institution_Yearly_Interest_Dividend5 + $fundsondeposit->Op_Funds_on_Deposit_Institution_Yearly_Interest_Dividend6 + $fundsondeposit->Op_Funds_on_Deposit_Institution_Yearly_Interest_Dividend7 + $fundsondeposit->Op_Funds_on_Deposit_Institution_Yearly_Interest_Dividend8 + $fundsondeposit->Op_Funds_on_Deposit_Institution_Yearly_Interest_Dividend9 + $fundsondeposit->Op_Funds_on_Deposit_Institution_Yearly_Interest_Dividend10;

            $Joint_Client_Op_Funds_on_Deposit_Equity_to_Client = $fundsondeposit->Joint_Funds_on_Deposit_Percent_Marital_Equity_to_Client1 + $fundsondeposit->Joint_Funds_on_Deposit_Percent_Marital_Equity_to_Client2 + $fundsondeposit->Joint_Funds_on_Deposit_Percent_Marital_Equity_to_Client3 + $fundsondeposit->Joint_Funds_on_Deposit_Percent_Marital_Equity_to_Client4 + $fundsondeposit->Joint_Funds_on_Deposit_Percent_Marital_Equity_to_Client5 + $fundsondeposit->Joint_Funds_on_Deposit_Percent_Marital_Equity_to_Client6 + $fundsondeposit->Joint_Funds_on_Deposit_Percent_Marital_Equity_to_Client7 + $fundsondeposit->Joint_Funds_on_Deposit_Percent_Marital_Equity_to_Client8 + $fundsondeposit->Joint_Funds_on_Deposit_Percent_Marital_Equity_to_Client9 + $fundsondeposit->Joint_Funds_on_Deposit_Percent_Marital_Equity_to_Client10 + $fundsondeposit->Client_Funds_on_Deposit_Percent_Marital_Equity_to_Client1 + $fundsondeposit->Client_Funds_on_Deposit_Percent_Marital_Equity_to_Client2 + $fundsondeposit->Client_Funds_on_Deposit_Percent_Marital_Equity_to_Client3 + $fundsondeposit->Client_Funds_on_Deposit_Percent_Marital_Equity_to_Client4 + $fundsondeposit->Client_Funds_on_Deposit_Percent_Marital_Equity_to_Client5 + $fundsondeposit->Client_Funds_on_Deposit_Percent_Marital_Equity_to_Client6 + $fundsondeposit->Client_Funds_on_Deposit_Percent_Marital_Equity_to_Client7 + $fundsondeposit->Client_Funds_on_Deposit_Percent_Marital_Equity_to_Client8 + $fundsondeposit->Client_Funds_on_Deposit_Percent_Marital_Equity_to_Client9 + $fundsondeposit->Client_Funds_on_Deposit_Percent_Marital_Equity_to_Client10 + $fundsondeposit->Op_Funds_on_Deposit_Percent_Marital_Equity_to_Client1 + $fundsondeposit->Op_Funds_on_Deposit_Percent_Marital_Equity_to_Client2 + $fundsondeposit->Op_Funds_on_Deposit_Percent_Marital_Equity_to_Client3 + $fundsondeposit->Op_Funds_on_Deposit_Percent_Marital_Equity_to_Client4 + $fundsondeposit->Op_Funds_on_Deposit_Percent_Marital_Equity_to_Client5 + $fundsondeposit->Op_Funds_on_Deposit_Percent_Marital_Equity_to_Client6 + $fundsondeposit->Op_Funds_on_Deposit_Percent_Marital_Equity_to_Client7 + $fundsondeposit->Op_Funds_on_Deposit_Percent_Marital_Equity_to_Client8 + $fundsondeposit->Op_Funds_on_Deposit_Percent_Marital_Equity_to_Client9 + $fundsondeposit->Op_Funds_on_Deposit_Percent_Marital_Equity_to_Client10;

            $Joint_Client_Op_Funds_on_Deposit_Equity_to_Op = $fundsondeposit->Joint_Funds_on_Deposit_Percent_Marital_Equity_to_Op1 + $fundsondeposit->Joint_Funds_on_Deposit_Percent_Marital_Equity_to_Op2 + $fundsondeposit->Joint_Funds_on_Deposit_Percent_Marital_Equity_to_Op3 + $fundsondeposit->Joint_Funds_on_Deposit_Percent_Marital_Equity_to_Op4 + $fundsondeposit->Joint_Funds_on_Deposit_Percent_Marital_Equity_to_Op5 + $fundsondeposit->Joint_Funds_on_Deposit_Percent_Marital_Equity_to_Op6 + $fundsondeposit->Joint_Funds_on_Deposit_Percent_Marital_Equity_to_Op7 + $fundsondeposit->Joint_Funds_on_Deposit_Percent_Marital_Equity_to_Op8 + $fundsondeposit->Joint_Funds_on_Deposit_Percent_Marital_Equity_to_Op9 + $fundsondeposit->Joint_Funds_on_Deposit_Percent_Marital_Equity_to_Op10 + $fundsondeposit->Client_Funds_on_Deposit_Percent_Marital_Equity_to_Op1 + $fundsondeposit->Client_Funds_on_Deposit_Percent_Marital_Equity_to_Op2 + $fundsondeposit->Client_Funds_on_Deposit_Percent_Marital_Equity_to_Op3 + $fundsondeposit->Client_Funds_on_Deposit_Percent_Marital_Equity_to_Op4 + $fundsondeposit->Client_Funds_on_Deposit_Percent_Marital_Equity_to_Op5 + $fundsondeposit->Client_Funds_on_Deposit_Percent_Marital_Equity_to_Op6 + $fundsondeposit->Client_Funds_on_Deposit_Percent_Marital_Equity_to_Op7 + $fundsondeposit->Client_Funds_on_Deposit_Percent_Marital_Equity_to_Op8 + $fundsondeposit->Client_Funds_on_Deposit_Percent_Marital_Equity_to_Op9 + $fundsondeposit->Client_Funds_on_Deposit_Percent_Marital_Equity_to_Op10 + $fundsondeposit->Op_Funds_on_Deposit_Percent_Marital_Equity_to_Op1 + $fundsondeposit->Op_Funds_on_Deposit_Percent_Marital_Equity_to_Op2 + $fundsondeposit->Op_Funds_on_Deposit_Percent_Marital_Equity_to_Op3 + $fundsondeposit->Op_Funds_on_Deposit_Percent_Marital_Equity_to_Op4 + $fundsondeposit->Op_Funds_on_Deposit_Percent_Marital_Equity_to_Op5 + $fundsondeposit->Op_Funds_on_Deposit_Percent_Marital_Equity_to_Op6 + $fundsondeposit->Op_Funds_on_Deposit_Percent_Marital_Equity_to_Op7 + $fundsondeposit->Op_Funds_on_Deposit_Percent_Marital_Equity_to_Op8 + $fundsondeposit->Op_Funds_on_Deposit_Percent_Marital_Equity_to_Op9 + $fundsondeposit->Op_Funds_on_Deposit_Percent_Marital_Equity_to_Op10;

            $client_drfundsondeposit_amount=$yearly_funds_on_deposit_interest_divident * ($Joint_Client_Op_Funds_on_Deposit_Equity_to_Client/100);
            $opponent_drfundsondeposit_amount=$yearly_funds_on_deposit_interest_divident * ($Joint_Client_Op_Funds_on_Deposit_Equity_to_Op/100);


            // N/A, Calculated from dr_Stocks_Investments & dr_FundsOnDeposit = SUM(Joint/Client/Op_StockInvestments_Yearly_Interest_Dividend * Joint/Client/Op_StockInvestments_Percent_Marital_Equity_to_Client ) + SUM(Joint/Client/Op_Funds_on_Deposit_Institution_Yearly_Interest_Dividend * Joint/Client/Op Funds_on_Deposit_Percent_Marital_Equity_to_Client );

            // N/A, Calculated from dr_Stocks_Investments & dr_FundsOnDeposit = SUM(Joint/Client/Op_StockInvestments_Yearly_Interest_Dividend * Joint/Client/Op_StockInvestments_Percent_Marital_Equity_to_Op ) + SUM(Joint/Client/Op_Funds_on_Deposit_Institution_Yearly_Interest_Dividend * Joint/Client/Op Funds_on_Deposit_Percent_Marital_Equity_to_Op );

            // old calculations
            $Client_Interest_Dividends = $client_drstockinvestment_amount + $client_drfundsondeposit_amount;
            $Op_Interest_Dividends = $opponent_drstockinvestment_amount + $opponent_drfundsondeposit_amount;
            $Client_Interest_Dividends=round($Client_Interest_Dividends,2);
            $Op_Interest_Dividends=round($Op_Interest_Dividends,2);

            //new calculations
            $Client_Interest_Dividends=$stockinvestment->StocksInvestments_Total_Yearly_Income_to_Client+$fundsondeposit->Funds_on_Deposit_Total_Estimated_Yearly_Income_to_Client;
            $Op_Interest_Dividends=$stockinvestment->StocksInvestments_Total_Yearly_Income_to_Op+$fundsondeposit->Funds_on_Deposit_Total_Estimated_Yearly_Income_to_Op;

        } else {
            return redirect()->route('cases.family_law_interview_tabs',$case_id)->with('error', 'Complete Funds on Deposit Info Section First.');
        }
        $personalinfo=DrPersonalInfo::where('case_id',$case_id)->get()->first();
        if(isset($personalinfo)){
            // Client_Yearly_Spousal_Support_Received_Not_This_Marriage =N/A, Calculated from dr_PersonalInfo * 12
            // Response:- Confirmed with proviso that it is First Prior Divorce Monthly Spousal Support RECEIVED + Second Prior Divorce Monthly Spousal Support RECEIVED.

            $Client_Yearly_Spousal_Support_Received_Not_This_Marriage= 12 * ($personalinfo->Client_Info_Prior_Divorce1_Support_RECEIVED + $personalinfo->Client_Info_Prior_Divorce2_Support_RECEIVED);

            $Op_Yearly_Spousal_Support_Received_Not_This_Marriage= 12 * ($personalinfo->Op_Info_Prior_Divorce1_Support_RECEIVED + $personalinfo->Op_Info_Prior_Divorce2_Support_RECEIVED);

            $Client_Yearly_Spousal_Support_Received_Not_This_Marriage=round($Client_Yearly_Spousal_Support_Received_Not_This_Marriage,2);
            $Op_Yearly_Spousal_Support_Received_Not_This_Marriage=round($Op_Yearly_Spousal_Support_Received_Not_This_Marriage,2);


        } else {
            return redirect()->route('cases.family_law_interview_tabs',$case_id)->with('error', 'Complete Personal Info Section First.');
        }
        $childreninfo=DrChildren::where('case_id',$case_id)->get()->first();
        if(isset($childreninfo)){
        // Client_Monthly_Gets_Child_Support_NoM = N/A, Calculated from dr_Children

        // Please elaborate which field from dr_Children to be used here for calculation.

        //  Response:- We’ll need to use all child support received for children belonging to Client who were not children of this marriage.

        // =SUM(Lines 129,  141, 153, 165, 177, 189)

           // line 129 = Client_First_Child_NOM_Monthly_Child_Support_RECEIVED
           // line 141 = Client_Second_Child_NOM_Monthly_Child_Support_RECEIVED
           // line 153 = Client_Third_Child_NOM_Monthly_Child_Support_RECEIVED
           // line 165 = Client_Fourth_Child_NOM_Monthly_Child_Support_RECEIVED
           // line 177 = Client_Fifth_Child_NOM_Monthly_Child_Support_RECEIVED
           // line 189 = Client_Sixth_Child_NOM_Monthly_Child_Support_RECEIVED

            $Client_Monthly_Gets_Child_Support_NoM=$childreninfo->Client_First_Child_NOM_Monthly_Child_Support_RECEIVED + $childreninfo->Client_Second_Child_NOM_Monthly_Child_Support_RECEIVED + $childreninfo->Client_Third_Child_NOM_Monthly_Child_Support_RECEIVED + $childreninfo->Client_Fourth_Child_NOM_Monthly_Child_Support_RECEIVED + $childreninfo->Client_Fifth_Child_NOM_Monthly_Child_Support_RECEIVED + $childreninfo->Client_Sixth_Child_NOM_Monthly_Child_Support_RECEIVED;

            $Op_Monthly_Gets_Child_Support_NoM=$childreninfo->Op_First_Child_NOM_Monthly_Child_Support_RECEIVED + $childreninfo->Op_Second_Child_NOM_Monthly_Child_Support_RECEIVED + $childreninfo->Op_Third_Child_NOM_Monthly_Child_Support_RECEIVED + $childreninfo->Op_Fourth_Child_NOM_Monthly_Child_Support_RECEIVED + $childreninfo->Op_Fifth_Child_NOM_Monthly_Child_Support_RECEIVED + $childreninfo->Op_Sixth_Child_NOM_Monthly_Child_Support_RECEIVED;

            $Client_Monthly_Gets_Child_Support_NoM=round($Client_Monthly_Gets_Child_Support_NoM,2);
            $Op_Monthly_Gets_Child_Support_NoM=round($Op_Monthly_Gets_Child_Support_NoM,2);

        } else {
            return redirect()->route('cases.family_law_interview_tabs',$case_id)->with('error', 'Complete Children Info Section First.');
        }

        $data=array(
            'realestateinfo' => $realestate,
            'pensioninfo' => $pension,
            'retirementaccountsinfo' => $retirementaccounts,
            'stockinvestmentinfo' => $stockinvestment,
            'fundsondepositinfo' => $fundsondeposit,
            'personalinfo' => $personalinfo,
            'childreninfo' => $childreninfo,
            'Client_Rent' => $Client_Rent,
            'Op_Rent' => $Op_Rent,
            'Client_Retirement_Pensions' => $Client_Retirement_Pensions,
            'Op_Retirement_Pensions' => $Op_Retirement_Pensions,
            'Client_Interest_Dividends' => $Client_Interest_Dividends,
            'Op_Interest_Dividends' => $Op_Interest_Dividends,
            'Client_Yearly_Spousal_Support_Received_Not_This_Marriage' => $Client_Yearly_Spousal_Support_Received_Not_This_Marriage,
            'Op_Yearly_Spousal_Support_Received_Not_This_Marriage' => $Op_Yearly_Spousal_Support_Received_Not_This_Marriage,
            'Client_Monthly_Gets_Child_Support_NoM' => $Client_Monthly_Gets_Child_Support_NoM,
            'Op_Monthly_Gets_Child_Support_NoM' => $Op_Monthly_Gets_Child_Support_NoM,
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
         // echo "<pre>";print_r($drincome);die;
        if($drincome){
            return view('dr_tables.dr_Income.edit',['client_name'=>$client_name, 'opponent_name'=>$opponent_name, 'drincome' => $drincome, 'data'=>$data, 'case_data' => $case_data]);
        } else {
            return redirect()->route('home');
        }
        
    }

    public function update(Request $request, $id)
    {
        $result = $request->except('submit','_method','_token');

        
        // echo "<pre>";print_r($result);die;
        if(isset($result['Client_Employed']) && $result['Client_Employed']=='Yes'){
        } else {
            $result['Client_Inc_Employer']=NULL;
            $result['Client_Inc_Employer_Payroll_Street_Address']=NULL;
            $result['Client_Inc_Employer_Payroll_City_State_Zip']=NULL;
        }

        if(isset($result['Client_RegWage_YTD_MinWage']) && $result['Client_RegWage_YTD_MinWage']=='1'){
            $result['Client_Wages_per_Period']=$result['Client_Wages_per_Period'];
            $result['Client_Pay_Periods_Yearly']=$result['Client_Pay_Periods_Yearly'];
        } else {
            $result['Client_Wages_per_Period']=NULL;
            $result['Client_Pay_Periods_Yearly']=NULL;
        }

        if(isset($result['Client_RegWage_YTD_MinWage']) && $result['Client_RegWage_YTD_MinWage']=='2'){
            $result['Client_Pay_YTD']=$result['Client_Pay_YTD'];
            $result['Client_YTD_Date']=$result['Client_YTD_Date'];
            if(isset($result['Client_YTD_Date'])){
                $result['Client_YTD_Date']=date("Y-m-d",strtotime($result['Client_YTD_Date']));
            } else {
                $result['Client_YTD_Date']=NULL;
            }

        } else{
            $result['Client_Pay_YTD']=NULL;
            $result['Client_YTD_Date']=NULL;
        }

        // new calculations for client
        $result['Client_Total_Yearly_Income']=0.00;
        if(isset($result['Client_Base_Yearly_Wages']) && $result['Client_Base_Yearly_Wages']!=''){
            $result['Client_Total_Yearly_Income']=$result['Client_Total_Yearly_Income']+$result['Client_Base_Yearly_Wages'];
        }
        if(isset($result['Client_Min_Ave_OT_Comms_Bonuses']) && $result['Client_Min_Ave_OT_Comms_Bonuses']!=''){
            $result['Client_Total_Yearly_Income']=$result['Client_Total_Yearly_Income']+$result['Client_Min_Ave_OT_Comms_Bonuses'];
        }
        if(isset($result['Client_Yearly_Unemployment_Compensation']) && $result['Client_Yearly_Unemployment_Compensation']!=''){
            $result['Client_Total_Yearly_Income']=$result['Client_Total_Yearly_Income']+$result['Client_Yearly_Unemployment_Compensation'];
        }
        if(isset($result['Client_Yearly_Workers_Compensation']) && $result['Client_Yearly_Workers_Compensation']!=''){
            $result['Client_Total_Yearly_Income']=$result['Client_Total_Yearly_Income']+$result['Client_Yearly_Workers_Compensation'];
        }
        if(isset($result['Client_Yearly_Social_Security_Disability']) && $result['Client_Yearly_Social_Security_Disability']!=''){
            $result['Client_Total_Yearly_Income']=$result['Client_Total_Yearly_Income']+$result['Client_Yearly_Social_Security_Disability'];
        }
        if(isset($result['Client_Yearly_Other_Disability_Income']) && $result['Client_Yearly_Other_Disability_Income']!=''){
            $result['Client_Total_Yearly_Income']=$result['Client_Total_Yearly_Income']+$result['Client_Yearly_Other_Disability_Income'];
        }
        if(isset($result['Client_Yearly_Social_Security_Retirement']) && $result['Client_Yearly_Social_Security_Retirement']!=''){
            $result['Client_Total_Yearly_Income']=$result['Client_Total_Yearly_Income']+$result['Client_Yearly_Social_Security_Retirement'];
        }
        if(isset($result['Client_Retirement_Pensions']) && $result['Client_Retirement_Pensions']!=''){
            $result['Client_Total_Yearly_Income']=$result['Client_Total_Yearly_Income']+$result['Client_Retirement_Pensions'];
        }
        if(isset($result['Client_Yearly_Gross_Self_Employment_Income']) && $result['Client_Yearly_Gross_Self_Employment_Income']!=''){
            $result['Client_Total_Yearly_Income']=$result['Client_Total_Yearly_Income']+$result['Client_Yearly_Gross_Self_Employment_Income'];
        }
        if(isset($result['Client_Yearly_Self_Employment_Expenses']) && $result['Client_Yearly_Self_Employment_Expenses']!=''){
            $result['Client_Total_Yearly_Income']=$result['Client_Total_Yearly_Income']-$result['Client_Yearly_Self_Employment_Expenses'];
        }
        if(isset($result['Client_Interest_Dividends']) && $result['Client_Interest_Dividends']!=''){
            $result['Client_Total_Yearly_Income']=$result['Client_Total_Yearly_Income']+$result['Client_Interest_Dividends'];
        }
        if(isset($result['Client_Yearly_Spousal_Support_Received_Not_This_Marriage']) && $result['Client_Yearly_Spousal_Support_Received_Not_This_Marriage']!=''){
            $result['Client_Total_Yearly_Income']=$result['Client_Total_Yearly_Income']+$result['Client_Yearly_Spousal_Support_Received_Not_This_Marriage'];
        }

        // new calculations for op
        $result['Op_Total_Yearly_Income']=0.00;
        if(isset($result['Op_Base_Yearly_Wages']) && $result['Op_Base_Yearly_Wages']!=''){
            $result['Op_Total_Yearly_Income']=$result['Op_Total_Yearly_Income']+$result['Op_Base_Yearly_Wages'];
        }
        if(isset($result['Op_Min_Ave_OT_Comms_Bonuses']) && $result['Op_Min_Ave_OT_Comms_Bonuses']!=''){
            $result['Op_Total_Yearly_Income']=$result['Op_Total_Yearly_Income']+$result['Op_Min_Ave_OT_Comms_Bonuses'];
        }
        if(isset($result['Op_Yearly_Unemployment_Compensation']) && $result['Op_Yearly_Unemployment_Compensation']!=''){
            $result['Op_Total_Yearly_Income']=$result['Op_Total_Yearly_Income']+$result['Op_Yearly_Unemployment_Compensation'];
        }
        if(isset($result['Op_Yearly_Workers_Compensation']) && $result['Op_Yearly_Workers_Compensation']!=''){
            $result['Op_Total_Yearly_Income']=$result['Op_Total_Yearly_Income']+$result['Op_Yearly_Workers_Compensation'];
        }
        if(isset($result['Op_Yearly_Social_Security_Disability']) && $result['Op_Yearly_Social_Security_Disability']!=''){
            $result['Op_Total_Yearly_Income']=$result['Op_Total_Yearly_Income']+$result['Op_Yearly_Social_Security_Disability'];
        }
        if(isset($result['Op_Yearly_Other_Disability_Income']) && $result['Op_Yearly_Other_Disability_Income']!=''){
            $result['Op_Total_Yearly_Income']=$result['Op_Total_Yearly_Income']+$result['Op_Yearly_Other_Disability_Income'];
        }
        if(isset($result['Op_Yearly_Social_Security_Retirement']) && $result['Op_Yearly_Social_Security_Retirement']!=''){
            $result['Op_Total_Yearly_Income']=$result['Op_Total_Yearly_Income']+$result['Op_Yearly_Social_Security_Retirement'];
        }
        if(isset($result['Op_Retirement_Pensions']) && $result['Op_Retirement_Pensions']!=''){
            $result['Op_Total_Yearly_Income']=$result['Op_Total_Yearly_Income']+$result['Op_Retirement_Pensions'];
        }
        if(isset($result['Op_Yearly_Gross_Self_Employment_Income']) && $result['Op_Yearly_Gross_Self_Employment_Income']!=''){
            $result['Op_Total_Yearly_Income']=$result['Op_Total_Yearly_Income']+$result['Op_Yearly_Gross_Self_Employment_Income'];
        }
        if(isset($result['Op_Yearly_Self_Employment_Expenses']) && $result['Op_Yearly_Self_Employment_Expenses']!=''){
            $result['Op_Total_Yearly_Income']=$result['Op_Total_Yearly_Income']-$result['Op_Yearly_Self_Employment_Expenses'];
        }
        if(isset($result['Op_Interest_Dividends']) && $result['Op_Interest_Dividends']!=''){
            $result['Op_Total_Yearly_Income']=$result['Op_Total_Yearly_Income']+$result['Op_Interest_Dividends'];
        }
        if(isset($result['Op_Yearly_Spousal_Support_Received_Not_This_Marriage']) && $result['Op_Yearly_Spousal_Support_Received_Not_This_Marriage']!=''){
            $result['Op_Total_Yearly_Income']=$result['Op_Total_Yearly_Income']+$result['Op_Yearly_Spousal_Support_Received_Not_This_Marriage'];
        }
        
        if(isset($result['Client_Other_Source_Income']) && $result['Client_Other_Source_Income']=='1'){
        } else {
            $result['Client_Other_Source_Income']='0';
            $result['Client_Other_Source_Name1']=NULL;
            $result['Client_Other_Source_Zip1']=NULL;
            $result['Client_Other_Source_Street_Address1']=NULL;
            $result['Client_Other_Source_City1']=NULL;
            $result['Client_Other_Source_State1']=NULL;
            $result['Client_Other_Source_Acct_Num_or_Description1']=NULL;
            $result['Client_Other_Source_Yearly_Income1']=NULL;
            $result['Client_Other_Source_Name2']=NULL;
            $result['Client_Other_Source_Zip2']=NULL;
            $result['Client_Other_Source_Street_Address2']=NULL;
            $result['Client_Other_Source_City2']=NULL;
            $result['Client_Other_Source_State2']=NULL;
            $result['Client_Other_Source_Acct_Num_or_Description2']=NULL;
            $result['Client_Other_Source_Yearly_Income2']=NULL;
            $result['Client_Other_Source_Name3']=NULL;
            $result['Client_Other_Source_Zip3']=NULL;
            $result['Client_Other_Source_Street_Address3']=NULL;
            $result['Client_Other_Source_City3']=NULL;
            $result['Client_Other_Source_State3']=NULL;
            $result['Client_Other_Source_Acct_Num_or_Description3']=NULL;
            $result['Client_Other_Source_Yearly_Income3']=NULL;
            $result['Client_Other_Source_Name4']=NULL;
            $result['Client_Other_Source_Zip4']=NULL;
            $result['Client_Other_Source_Street_Address4']=NULL;
            $result['Client_Other_Source_City4']=NULL;
            $result['Client_Other_Source_State4']=NULL;
            $result['Client_Other_Source_Acct_Num_or_Description4']=NULL;
            $result['Client_Other_Source_Yearly_Income4']=NULL;
            $result['Client_Other_Source_Name5']=NULL;
            $result['Client_Other_Source_Zip5']=NULL;
            $result['Client_Other_Source_Street_Address5']=NULL;
            $result['Client_Other_Source_City5']=NULL;
            $result['Client_Other_Source_State5']=NULL;
            $result['Client_Other_Source_Acct_Num_or_Description5']=NULL;
            $result['Client_Other_Source_Yearly_Income5']=NULL;
            $result['Client_Other_Yearly_Income_Total']=NULL;
        }

        // for Op

        if(isset($result['Op_Employed']) && $result['Op_Employed']=='Yes'){
        } else {
            $result['Op_Inc_Employer']=NULL;
            $result['Op_Inc_Employer_Payroll_Street_Address']=NULL;
            $result['Op_Inc_Employer_Payroll_City_State_Zip']=NULL;
        }

        if(isset($result['Op_RegWage_YTD_MinWage']) && $result['Op_RegWage_YTD_MinWage']=='1'){
            $result['Op_Wages_per_Period']=$result['Op_Wages_per_Period'];
            $result['Op_Pay_Periods_Yearly']=$result['Op_Pay_Periods_Yearly'];
        } else {
            $result['Op_Wages_per_Period']=NULL;
            $result['Op_Pay_Periods_Yearly']=NULL;
        }

        if(isset($result['Op_RegWage_YTD_MinWage']) && $result['Op_RegWage_YTD_MinWage']=='2'){
            $result['Op_Pay_YTD']=$result['Op_Pay_YTD'];
            $result['Op_YTD_Date']=$result['Op_YTD_Date'];
            if(isset($result['Op_YTD_Date'])){
                $result['Op_YTD_Date']=date("Y-m-d",strtotime($result['Op_YTD_Date']));
            } else {
                $result['Op_YTD_Date']=NULL;
            }

        } else{
            $result['Op_Pay_YTD']=NULL;
            $result['Op_YTD_Date']=NULL;
        }

        if(isset($result['Op_Other_Source_Income']) && $result['Op_Other_Source_Income']=='1'){
        } else {
            $result['Op_Other_Source_Income']='0';
            $result['Op_Other_Source_Name1']=NULL;
            $result['Op_Other_Source_Zip1']=NULL;
            $result['Op_Other_Source_Street_Address1']=NULL;
            $result['Op_Other_Source_City1']=NULL;
            $result['Op_Other_Source_State1']=NULL;
            $result['Op_Other_Source_Acct_Num_or_Description1']=NULL;
            $result['Op_Other_Source_Yearly_Income1']=NULL;
            $result['Op_Other_Source_Name2']=NULL;
            $result['Op_Other_Source_Zip2']=NULL;
            $result['Op_Other_Source_Street_Address2']=NULL;
            $result['Op_Other_Source_City2']=NULL;
            $result['Op_Other_Source_State2']=NULL;
            $result['Op_Other_Source_Acct_Num_or_Description2']=NULL;
            $result['Op_Other_Source_Yearly_Income2']=NULL;
            $result['Op_Other_Source_Name3']=NULL;
            $result['Op_Other_Source_Zip3']=NULL;
            $result['Op_Other_Source_Street_Address3']=NULL;
            $result['Op_Other_Source_City3']=NULL;
            $result['Op_Other_Source_State3']=NULL;
            $result['Op_Other_Source_Acct_Num_or_Description3']=NULL;
            $result['Op_Other_Source_Yearly_Income3']=NULL;
            $result['Op_Other_Source_Name4']=NULL;
            $result['Op_Other_Source_Zip4']=NULL;
            $result['Op_Other_Source_Street_Address4']=NULL;
            $result['Op_Other_Source_City4']=NULL;
            $result['Op_Other_Source_State4']=NULL;
            $result['Op_Other_Source_Acct_Num_or_Description4']=NULL;
            $result['Op_Other_Source_Yearly_Income4']=NULL;
            $result['Op_Other_Source_Name5']=NULL;
            $result['Op_Other_Source_Zip5']=NULL;
            $result['Op_Other_Source_Street_Address5']=NULL;
            $result['Op_Other_Source_City5']=NULL;
            $result['Op_Other_Source_State5']=NULL;
            $result['Op_Other_Source_Acct_Num_or_Description5']=NULL;
            $result['Op_Other_Source_Yearly_Income5']=NULL;
            $result['Op_Other_Yearly_Income_Total']=NULL;
        }
        // echo "<pre>";print_r($result);die;
        
        $drincome  = DrIncome::findOrFail($id);
        if($drincome){
            $drincome->fill($result)->save();
            return redirect()->route('drincome.edit',$result['case_id'])->with('success', 'Income Information Updated Successfully.');
        } else {
            return redirect()->route('drincome.edit',$result['case_id'])->with('error', 'Something went wrong. Please try Again.');
        }
    }
    
    public function destroy($id)
    {

    }

}
