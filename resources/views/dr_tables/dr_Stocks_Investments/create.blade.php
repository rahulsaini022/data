@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center dr_Stocks_Investments_main">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header"><strong>{{ __('Stocks Investments Info') }}</strong>
                    <div class="pull-right">

                        <a class="btn btn-primary" href="{{ route('cases.family_law_interview_tabs',$case_id) }}"> Back</a>

                    </div>
                </div>
                <div class="card-body">
                    @if ($message = Session::get('success'))
                        <div class="alert alert-success alert-block">
                            <button type="button" class="close" data-dismiss="alert">×</button> 
                                <strong>{{ $message }}</strong>
                        </div>
                    @endif
                    @if ($message = Session::get('error'))
                        <div class="alert alert-danger alert-block">
                            <button type="button" class="close" data-dismiss="alert">×</button> 
                                <strong>{{ $message }}</strong>
                        </div>
                    @endif
                    <form role="form" id="dr_Stocks_Investments" method="POST" action="{{route('drstocksinvestments.store')}}" autocomplete="off">
                        @csrf
                        <input id="" type="hidden" class="form-control" name="case_id" value="{{$case_id}}">
                        <div class="form-row Any_Stocks_Investments_Accounts">
                            <div class="form-group col-sm-12">
                                <label></label>
                                <div class="w-100 dataInput">
                                     <label><input type="checkbox" id="Any_Stocks_Investments_Accounts" name="Any_Stocks_Investments_Accounts" value="1" onchange="getAnySIA(this);" <?php if(isset($drcaseoverview->Any_Stocks_Investments_Accounts) && $drcaseoverview->Any_Stocks_Investments_Accounts=='1'){ echo "checked"; } ?>> Check if any Stocks or Investments (Accounts or Certificates) is Owned by {{$client_name}} and/or {{$opponent_name}}?</label>
                                </div>
                            </div>
                        </div>
                        <!-- Joint Stocks Investments Info Section -->
                        <div class="form-row num_Joint_stocksinvestments_info" style="display: none;">
                            <h4 class="col-sm-12">Joint Stocks Investments Info Section</h4>
                            <div class="col-sm-6">
                                <label for="Num_Joint_StocksInvestments_Accounts">How many deposit accounts in BOTH parties’ names?</label>
                                <input id="Num_Joint_StocksInvestments_Accounts" type="number" class="form-control" name="Num_Joint_StocksInvestments_Accounts" value="<?php if(isset($drcaseoverview->Num_Joint_StocksInvestments_Accounts)){ echo $drcaseoverview->Num_Joint_StocksInvestments_Accounts; } ?>" min="0" max="10"> 
                            </div>
                        </div>
                        <div class="form-row Joint_stocksinvestments_info_section">
                            <div class="col-sm-12 mt-4 1_Joint_stocksinvestments_section" style="display: none;"><h5 class="col-sm-12">First Stock Investment Info</h5>
                                <div class="form-group col-sm-6">
                                    <p class="text-danger 1_Joint_no-state-county-found" style="display: none;">No City, State, County found for this zipcode.</p>
                                    <label for="Joint_StockInvestments_Institution_ZIP1">Stock/Investment Institution Zip Code?</label>
                                    <input id="Joint_StockInvestments_Institution_ZIP1" type="text" class="form-control 1_Joint_stocksinvestments_inputs" name="Joint_StockInvestments_Institution_ZIP1" value="" onkeyup="getCityStateForZip(this, '1_Joint');"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_StockInvestments_Institution_Name1">Name of Stock/Investment Institution?</label>
                                    <input id="Joint_StockInvestments_Institution_Name1" type="text" class="form-control 1_Joint_stocksinvestments_inputs" name="Joint_StockInvestments_Institution_Name1" value=""> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_StockInvestments_Institution_Street_Address1">Stock/Investment Institution Street Address?</label>
                                    <input id="Joint_StockInvestments_Institution_Street_Address1" type="text" class="form-control 1_Joint_stocksinvestments_inputs" name="Joint_StockInvestments_Institution_Street_Address1" value=""> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_StockInvestments_Institution_City1">Stock/Investment Institution City?</label>
                                    <select id="Joint_StockInvestments_Institution_City1" name="Joint_StockInvestments_Institution_City1" class="form-control 1_Joint_city_select">
                                        <option value="">Choose City</option>
                                    </select>   
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_StockInvestments_Institution_State1">Stock/Investment Institution State?</label>
                                    <select id="Joint_StockInvestments_Institution_State1" name="Joint_StockInvestments_Institution_State1" class="form-control 1_Joint_state_select">
                                        <option value="">Choose State</option>
                                    </select>   
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_StockInvestments_Acct_Num1">Account Number?</label>
                                    <input id="Joint_StockInvestments_Acct_Num1" type="text" class="form-control 1_Joint_stocksinvestments_inputs" name="Joint_StockInvestments_Acct_Num1" value=""> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_StockInvestments_Date_Marriage_Value1">Marriage Date Value?</label>
                                    <input id="Joint_StockInvestments_Date_Marriage_Value1" type="number" class="form-control 1_Joint_stocksinvestments_inputs" name="Joint_StockInvestments_Date_Marriage_Value1" value="0.00" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_StockInvestments_Current_Value1">Current Value?</label>
                                    <input id="Joint_StockInvestments_Current_Value1" type="number" class="form-control 1_Joint_stocksinvestments_inputs" name="Joint_StockInvestments_Current_Value1" value="0.00" min="0.00" step="0.01" max="999999.99" onchange="getJointCurrentValue(this, '1', 'Joint');" onkeyup="getJointCurrentValue(this, '1', 'Joint');"> 
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label for="Joint_StockInvestments_Percent_Marital_Equity1">N/A, calculated = Joint_StockInvestments_Institution_Current_Value1</label>
                                    <input id="Joint_StockInvestments_Percent_Marital_Equity1" type="number" class="form-control 1_Joint_stocksinvestments_inputs" name="Joint_StockInvestments_Percent_Marital_Equity1" value="" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_StockInvestments_Yearly_Interest_Dividend1">Yearly Interest and Dividends from this account?</label>
                                    <input id="Joint_StockInvestments_Yearly_Interest_Dividend1" type="number" class="form-control 1_Joint_stocksinvestments_inputs" name="Joint_StockInvestments_Yearly_Interest_Dividend1" value="0.00" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Does either party claim a sole/separate interest from the other on this account?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Joint_StockInvestments_SoleSeparate_Claim1_Yes" name="Joint_StockInvestments_SoleSeparate_Claim1" value="Yes" onchange="getPartyClaimSoleSeparate(this, '1', 'Joint');"> Yes</label>
                                        <label><input type="radio" id="Joint_StockInvestments_SoleSeparate_Claim1_No" name="Joint_StockInvestments_SoleSeparate_Claim1" value="No" checked="" onchange="getPartyClaimSoleSeparate(this, '1', 'Joint');"> No</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6" id="Joint_StockInvestments_SoleSeparate_Party1_Div" style="display: none;">
                                    <label>Who claims to own this account?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Joint_StockInvestments_SoleSeparate_Party1_Client" name="Joint_StockInvestments_SoleSeparate_Party1" value="{{$client_name}}"> {{$client_name}}</label>
                                        <label><input type="radio" id="Joint_StockInvestments_SoleSeparate_Party1_Op" name="Joint_StockInvestments_SoleSeparate_Party1" value="{{$opponent_name}}" checked=""> {{$opponent_name}}</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 left-clear" id="Joint_StockInvestments_SoleSeparate_Grounds1_Div" style="display: none; clear: left;">
                                    <label for="Joint_StockInvestments_SoleSeparate_Grounds1">Why does this person own this account solely and separately?</label>
                                    <input id="Joint_StockInvestments_SoleSeparate_Grounds1" type="text" class="form-control 1_Joint_stocksinvestments_inputs" name="Joint_StockInvestments_SoleSeparate_Grounds1" value=""> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>How will this account value be distributed between the parties?</label>
                                    <div class="w-100 dataInput">
                                        <label><input type="radio" id="Joint_StockInvestments_Disposition_Method1_Distribute Investments" name="Joint_StockInvestments_Disposition_Method1" value="Distribute Investments" onchange="getDipositionMethod(this, '1', 'Joint');"> Distribute Investments</label>
                                        <label><input type="radio" id="Joint_StockInvestments_Disposition_Method1_Liquidate/Split Net Value" name="Joint_StockInvestments_Disposition_Method1" value="Liquidate/Split Net Value" onchange="getDipositionMethod(this, '1', 'Joint');"> Liquidate/Split Net Value</label>
                                        <label><input type="radio" id="Joint_StockInvestments_Disposition_Method1_Percentage Buyout" name="Joint_StockInvestments_Disposition_Method1" value="Percentage Buyout" onchange="getDipositionMethod(this, '1', 'Joint');"> Percentage Buyout</label>
                                        <label><input type="radio" id="Joint_StockInvestments_Disposition_Method1_Fixed Buyout" name="Joint_StockInvestments_Disposition_Method1" value="Fixed Buyout" onchange="getDipositionMethod(this, '1', 'Joint');"> Fixed Buyout</label>
                                    </div>
                                </div>
                                <!-- slider tool -->
                                <div class="form-group col-sm-6 m-auto 1_Joint_Slider_Tool slider-tool-main">
                                    <div class="row">
                                        <div class="col">{{$client_name}}</div>
                                        <div class="col text-right">{{$opponent_name}}</div>
                                    </div>
                                    <input id="1_Joint_balance_range_selector" type="range" class="form-control slider-tool-input 1_Joint_balance_range_selector" name="" value="50.00" min="0.00" step="0.01" max="100" onchange="updateBalanceInput(this.value, '1', 'Joint');">
                                </div>
                                <div class="form-group col-sm-6 m-auto 1_Joint_Slider_Tool slider-tool-main">
                                    <div class="row justify-content-between">
                                        <div class="col selectorTool">
                                            <div class="left-col">
                                                <div class="client-info 1_Joint_clientpercentage_div clientpercentage_div">
                                                    50.00%
                                                </div>
                                                <div class="client-info 1_Joint_clientamount_div clientamount_div" style="clear: both;">
                                                    $0
                                                </div>
                                            </div>
                                            <label>To {{$client_name}}</label>
                                        </div>                                       
                                        <div class="col selectorTool selectorToolRight">
                                            <label>To {{$opponent_name}}</label>
                                            <div class="left-col right-col">
                                                <div class="client-info 1_Joint_opponentpercentage_div opponentpercentage_div">
                                                    50.00%
                                                </div>
                                                <div class="client-info 1_Joint_opponentamount_div opponentamount_div" style="clear: both;">
                                                    $0
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 m-auto 1_Joint_Slider_Tool slider-tool-main">
                                    <label></label>
                                    <div class="w-100">
                                        <label><input type="radio" id="1_Joint_StockInvestments_Estimated_Value_Select" name="1_Joint_StockInvestments_Estimated_Value_Select_Reset" class="StockInvestments_Estimated_Value_Select_Reset" value="Save"> Save this Distribution of StockInvestment Account #1</label>
                                        <label><input type="radio" id="1_Joint_StockInvestments_Estimated_Value_Reset" name="1_Joint_StockInvestments_Estimated_Value_Select_Reset" class="StockInvestments_Estimated_Value_Select_Reset" value="Reset" onclick="resetBalanceInput(this, '1', 'Joint');"> Reset to Default (50%)</label>
                                    </div>
                                </div>

                                <div class="form-group col-sm-6 Joint_StockInvestments_Paying_Party1_Inputs_Div" style="display: none;">
                                    <label>Joint StockInvestments Paying Party1</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Joint_StockInvestments_Paying_Party1_Client" name="Joint_StockInvestments_Paying_Party1" value="{{$client_name}}" onchange="getStockInvestmentPayingParty(this, '1', 'Joint');"> {{$client_name}}</label>
                                        <label><input type="radio" id="Joint_StockInvestments_Paying_Party1_Op" name="Joint_StockInvestments_Paying_Party1" value="{{$opponent_name}}" onchange="getStockInvestmentPayingParty(this, '1', 'Joint');"> {{$opponent_name}}</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 Joint_StockInvestments_Paying_Party1_Inputs_Div" style="display: none;">
                                    <label>{{$client_name}} StockInvestment Equity Percent</label>
                                    <input id="Joint_StockInvestments_Percent_Marital_Equity_to_Client1" type="number" class="form-control 1_Joint_clientpercentage_input clientpercentage_input" name="Joint_StockInvestments_Percent_Marital_Equity_to_Client1" value="50.00" min="0.00" step="0.01" max="100" readonly="">
                                </div>
                                <div class="form-group col-sm-6 Joint_StockInvestments_Paying_Party1_Inputs_Div" style="display: none;">
                                    <label>How much is to be paid to {{$client_name}}?</label>
                                    <input id="Joint_StockInvestments_Estimated_Value_to_Client1" type="number" class="form-control 1_Joint_clientamount_input clientamount_input" name="Joint_StockInvestments_Estimated_Value_to_Client1" value="" min="0.00" step="0.01" max="999999.99" readonly="" onchange="getEstimatedValueClient(this, '1', 'Joint');" onkeyup="getEstimatedValueClient(this, '1', 'Joint');">
                                </div>
                                <div class="form-group col-sm-6 Joint_StockInvestments_Paying_Party1_Inputs_Div" style="display: none;">
                                    <label>{{$opponent_name}} StockInvestment Equity Percent</label>
                                    <input id="Joint_StockInvestments_Percent_Marital_Equity_to_Op1" type="number" class="form-control 1_Joint_opponentpercentage_input opponentpercentage_input" name="Joint_StockInvestments_Percent_Marital_Equity_to_Op1" value="50.00" min="0.00" step="0.01" max="100" readonly="">
                                </div>
                                <div class="form-group col-sm-6 Joint_StockInvestments_Paying_Party1_Inputs_Div" style="display: none;">
                                    <label>How much is to be paid to {{$opponent_name}}?</label>
                                    <input id="Joint_StockInvestments_Estimated_Value_to_Op1" type="number" class="form-control 1_Joint_opponentamount_input opponentamount_input" name="Joint_StockInvestments_Estimated_Value_to_Op1" value="" min="0.00" step="0.01" max="999999.99" readonly="" onchange="getEstimatedValueOp(this, '1', 'Joint');" onkeyup="getEstimatedValueOp(this, '1', 'Joint');">
                                </div>
                                <!-- end of slider tool -->
                            </div>
                            <div class="col-sm-12 mt-4 2_Joint_stocksinvestments_section" style="display: none;"><h5 class="col-sm-12">Second Stock Investment Info</h5>
                                <div class="form-group col-sm-6">
                                    <p class="text-danger 2_Joint_no-state-county-found" style="display: none;">No City, State, County found for this zipcode.</p>
                                    <label for="Joint_StockInvestments_Institution_ZIP2">Stock/Investment Institution Zip Code?</label>
                                    <input id="Joint_StockInvestments_Institution_ZIP2" type="text" class="form-control 2_Joint_stocksinvestments_inputs" name="Joint_StockInvestments_Institution_ZIP2" value="" onkeyup="getCityStateForZip(this, '2_Joint');"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_StockInvestments_Institution_Name2">Name of Stock/Investment Institution?</label>
                                    <input id="Joint_StockInvestments_Institution_Name2" type="text" class="form-control 2_Joint_stocksinvestments_inputs" name="Joint_StockInvestments_Institution_Name2" value=""> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_StockInvestments_Institution_Street_Address2">Stock/Investment Institution Street Address?</label>
                                    <input id="Joint_StockInvestments_Institution_Street_Address2" type="text" class="form-control 2_Joint_stocksinvestments_inputs" name="Joint_StockInvestments_Institution_Street_Address2" value=""> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_StockInvestments_Institution_City2">Stock/Investment Institution City?</label>
                                    <select id="Joint_StockInvestments_Institution_City2" name="Joint_StockInvestments_Institution_City2" class="form-control 2_Joint_city_select">
                                        <option value="">Choose City</option>
                                    </select>   
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_StockInvestments_Institution_State2">Stock/Investment Institution State?</label>
                                    <select id="Joint_StockInvestments_Institution_State2" name="Joint_StockInvestments_Institution_State2" class="form-control 2_Joint_state_select">
                                        <option value="">Choose State</option>
                                    </select>   
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_StockInvestments_Acct_Num2">Account Number?</label>
                                    <input id="Joint_StockInvestments_Acct_Num2" type="text" class="form-control 2_Joint_stocksinvestments_inputs" name="Joint_StockInvestments_Acct_Num2" value=""> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_StockInvestments_Date_Marriage_Value2">Marriage Date Value?</label>
                                    <input id="Joint_StockInvestments_Date_Marriage_Value2" type="number" class="form-control 2_Joint_stocksinvestments_inputs" name="Joint_StockInvestments_Date_Marriage_Value2" value="0.00" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_StockInvestments_Current_Value2">Current Value?</label>
                                    <input id="Joint_StockInvestments_Current_Value2" type="number" class="form-control 2_Joint_stocksinvestments_inputs" name="Joint_StockInvestments_Current_Value2" value="0.00" min="0.00" step="0.01" max="999999.99" onchange="getJointCurrentValue(this, '2', 'Joint');" onkeyup="getJointCurrentValue(this, '2', 'Joint');"> 
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label for="Joint_StockInvestments_Percent_Marital_Equity2">N/A, calculated = Joint_StockInvestments_Institution_Current_Value2</label>
                                    <input id="Joint_StockInvestments_Percent_Marital_Equity2" type="number" class="form-control 2_Joint_stocksinvestments_inputs" name="Joint_StockInvestments_Percent_Marital_Equity2" value="" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_StockInvestments_Yearly_Interest_Dividend2">Yearly Interest and Dividends from this account?</label>
                                    <input id="Joint_StockInvestments_Yearly_Interest_Dividend2" type="number" class="form-control 2_Joint_stocksinvestments_inputs" name="Joint_StockInvestments_Yearly_Interest_Dividend2" value="0.00" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Does either party claim a sole/separate interest from the other on this account?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Joint_StockInvestments_SoleSeparate_Claim2_Yes" name="Joint_StockInvestments_SoleSeparate_Claim2" value="Yes" onchange="getPartyClaimSoleSeparate(this, '2', 'Joint');"> Yes</label>
                                        <label><input type="radio" id="Joint_StockInvestments_SoleSeparate_Claim2_No" name="Joint_StockInvestments_SoleSeparate_Claim2" value="No" checked="" onchange="getPartyClaimSoleSeparate(this, '2', 'Joint');"> No</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6" id="Joint_StockInvestments_SoleSeparate_Party2_Div" style="display: none;">
                                    <label>Who claims to own this account?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Joint_StockInvestments_SoleSeparate_Party2_Client" name="Joint_StockInvestments_SoleSeparate_Party2" value="{{$client_name}}"> {{$client_name}}</label>
                                        <label><input type="radio" id="Joint_StockInvestments_SoleSeparate_Party2_Op" name="Joint_StockInvestments_SoleSeparate_Party2" value="{{$opponent_name}}" checked=""> {{$opponent_name}}</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 left-clear" id="Joint_StockInvestments_SoleSeparate_Grounds2_Div" style="display: none; clear: left;">
                                    <label for="Joint_StockInvestments_SoleSeparate_Grounds2">Why does this person own this account solely and separately?</label>
                                    <input id="Joint_StockInvestments_SoleSeparate_Grounds2" type="text" class="form-control 2_Joint_stocksinvestments_inputs" name="Joint_StockInvestments_SoleSeparate_Grounds2" value=""> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>How will this account value be distributed between the parties?</label>
                                    <div class="w-100 dataInput">
                                        <label><input type="radio" id="Joint_StockInvestments_Disposition_Method2_Distribute Investments" name="Joint_StockInvestments_Disposition_Method2" value="Distribute Investments" onchange="getDipositionMethod(this, '2', 'Joint');"> Distribute Investments</label>
                                        <label><input type="radio" id="Joint_StockInvestments_Disposition_Method2_Liquidate/Split Net Value" name="Joint_StockInvestments_Disposition_Method2" value="Liquidate/Split Net Value" onchange="getDipositionMethod(this, '2', 'Joint');"> Liquidate/Split Net Value</label>
                                        <label><input type="radio" id="Joint_StockInvestments_Disposition_Method2_Percentage Buyout" name="Joint_StockInvestments_Disposition_Method2" value="Percentage Buyout" onchange="getDipositionMethod(this, '2', 'Joint');"> Percentage Buyout</label>
                                        <label><input type="radio" id="Joint_StockInvestments_Disposition_Method2_Fixed Buyout" name="Joint_StockInvestments_Disposition_Method2" value="Fixed Buyout" onchange="getDipositionMethod(this, '2', 'Joint');"> Fixed Buyout</label>
                                    </div>
                                </div>
                                <!-- slider tool -->
                                <div class="form-group col-sm-6 m-auto 2_Joint_Slider_Tool slider-tool-main">
                                    <div class="row">
                                        <div class="col">{{$client_name}}</div>
                                        <div class="col text-right">{{$opponent_name}}</div>
                                    </div>
                                    <input id="2_Joint_balance_range_selector" type="range" class="form-control slider-tool-input 2_Joint_balance_range_selector" name="" value="50.00" min="0.00" step="0.01" max="100" onchange="updateBalanceInput(this.value, '2', 'Joint');">
                                </div>
                                <div class="form-group col-sm-6 m-auto 2_Joint_Slider_Tool slider-tool-main">
                                    <div class="row justify-content-between">
                                        <div class="col selectorTool">
                                            <div class="left-col">
                                                <div class="client-info 2_Joint_clientpercentage_div clientpercentage_div">
                                                    50.00%
                                                </div>
                                                <div class="client-info 2_Joint_clientamount_div clientamount_div" style="clear: both;">
                                                    $0
                                                </div>
                                            </div>
                                            <label>To {{$client_name}}</label>
                                        </div>                                       
                                        <div class="col selectorTool selectorToolRight">
                                            <label>To {{$opponent_name}}</label>
                                            <div class="left-col right-col">
                                                <div class="client-info 2_Joint_opponentpercentage_div opponentpercentage_div">
                                                    50.00%
                                                </div>
                                                <div class="client-info 2_Joint_opponentamount_div opponentamount_div" style="clear: both;">
                                                    $0
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 m-auto 2_Joint_Slider_Tool slider-tool-main">
                                    <label></label>
                                    <div class="w-100">
                                        <label><input type="radio" id="2_Joint_StockInvestments_Estimated_Value_Select" name="2_Joint_StockInvestments_Estimated_Value_Select_Reset" class="StockInvestments_Estimated_Value_Select_Reset" value="Save"> Save this Distribution of StockInvestment Account #2</label>
                                        <label><input type="radio" id="2_Joint_StockInvestments_Estimated_Value_Reset" name="2_Joint_StockInvestments_Estimated_Value_Select_Reset" class="StockInvestments_Estimated_Value_Select_Reset" value="Reset" onclick="resetBalanceInput(this, '2', 'Joint');"> Reset to Default (50%)</label>
                                    </div>
                                </div>

                                <div class="form-group col-sm-6 Joint_StockInvestments_Paying_Party2_Inputs_Div" style="display: none;">
                                    <label>Joint StockInvestments Paying Party2</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Joint_StockInvestments_Paying_Party2_Client" name="Joint_StockInvestments_Paying_Party2" value="{{$client_name}}" onchange="getStockInvestmentPayingParty(this, '2', 'Joint');"> {{$client_name}}</label>
                                        <label><input type="radio" id="Joint_StockInvestments_Paying_Party2_Op" name="Joint_StockInvestments_Paying_Party2" value="{{$opponent_name}}" onchange="getStockInvestmentPayingParty(this, '2', 'Joint');"> {{$opponent_name}}</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 Joint_StockInvestments_Paying_Party2_Inputs_Div" style="display: none;">
                                    <label>{{$client_name}} StockInvestment Equity Percent</label>
                                    <input id="Joint_StockInvestments_Percent_Marital_Equity_to_Client2" type="number" class="form-control 2_Joint_clientpercentage_input clientpercentage_input" name="Joint_StockInvestments_Percent_Marital_Equity_to_Client2" value="50.00" min="0.00" step="0.01" max="100" readonly="">
                                </div>
                                <div class="form-group col-sm-6 Joint_StockInvestments_Paying_Party2_Inputs_Div" style="display: none;">
                                    <label>How much is to be paid to {{$client_name}}?</label>
                                    <input id="Joint_StockInvestments_Estimated_Value_to_Client2" type="number" class="form-control 2_Joint_clientamount_input clientamount_input" name="Joint_StockInvestments_Estimated_Value_to_Client2" value="" min="0.00" step="0.01" max="999999.99" readonly="" onchange="getEstimatedValueClient(this, '2', 'Joint');" onkeyup="getEstimatedValueClient(this, '2', 'Joint');">
                                </div>
                                <div class="form-group col-sm-6 Joint_StockInvestments_Paying_Party2_Inputs_Div" style="display: none;">
                                    <label>{{$opponent_name}} StockInvestment Equity Percent</label>
                                    <input id="Joint_StockInvestments_Percent_Marital_Equity_to_Op2" type="number" class="form-control 2_Joint_opponentpercentage_input opponentpercentage_input" name="Joint_StockInvestments_Percent_Marital_Equity_to_Op2" value="50.00" min="0.00" step="0.01" max="100" readonly="">
                                </div>
                                <div class="form-group col-sm-6 Joint_StockInvestments_Paying_Party2_Inputs_Div" style="display: none;">
                                    <label>How much is to be paid to {{$opponent_name}}?</label>
                                    <input id="Joint_StockInvestments_Estimated_Value_to_Op2" type="number" class="form-control 2_Joint_opponentamount_input opponentamount_input" name="Joint_StockInvestments_Estimated_Value_to_Op2" value="" min="0.00" step="0.01" max="999999.99" readonly="" onchange="getEstimatedValueOp(this, '2', 'Joint');" onkeyup="getEstimatedValueOp(this, '2', 'Joint');">
                                </div>
                                <!-- end of slider tool -->
                            </div>
                            <div class="col-sm-12 mt-4 3_Joint_stocksinvestments_section" style="display: none;"><h5 class="col-sm-12">Third Stock Investment Info</h5>
                                <div class="form-group col-sm-6">
                                    <p class="text-danger 3_Joint_no-state-county-found" style="display: none;">No City, State, County found for this zipcode.</p>
                                    <label for="Joint_StockInvestments_Institution_ZIP3">Stock/Investment Institution Zip Code?</label>
                                    <input id="Joint_StockInvestments_Institution_ZIP3" type="text" class="form-control 3_Joint_stocksinvestments_inputs" name="Joint_StockInvestments_Institution_ZIP3" value="" onkeyup="getCityStateForZip(this, '3_Joint');"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_StockInvestments_Institution_Name3">Name of Stock/Investment Institution?</label>
                                    <input id="Joint_StockInvestments_Institution_Name3" type="text" class="form-control 3_Joint_stocksinvestments_inputs" name="Joint_StockInvestments_Institution_Name3" value=""> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_StockInvestments_Institution_Street_Address3">Stock/Investment Institution Street Address?</label>
                                    <input id="Joint_StockInvestments_Institution_Street_Address3" type="text" class="form-control 3_Joint_stocksinvestments_inputs" name="Joint_StockInvestments_Institution_Street_Address3" value=""> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_StockInvestments_Institution_City3">Stock/Investment Institution City?</label>
                                    <select id="Joint_StockInvestments_Institution_City3" name="Joint_StockInvestments_Institution_City3" class="form-control 3_Joint_city_select">
                                        <option value="">Choose City</option>
                                    </select>   
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_StockInvestments_Institution_State3">Stock/Investment Institution State?</label>
                                    <select id="Joint_StockInvestments_Institution_State3" name="Joint_StockInvestments_Institution_State3" class="form-control 3_Joint_state_select">
                                        <option value="">Choose State</option>
                                    </select>   
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_StockInvestments_Acct_Num3">Account Number?</label>
                                    <input id="Joint_StockInvestments_Acct_Num3" type="text" class="form-control 3_Joint_stocksinvestments_inputs" name="Joint_StockInvestments_Acct_Num3" value=""> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_StockInvestments_Date_Marriage_Value3">Marriage Date Value?</label>
                                    <input id="Joint_StockInvestments_Date_Marriage_Value3" type="number" class="form-control 3_Joint_stocksinvestments_inputs" name="Joint_StockInvestments_Date_Marriage_Value3" value="0.00" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_StockInvestments_Current_Value3">Current Value?</label>
                                    <input id="Joint_StockInvestments_Current_Value3" type="number" class="form-control 3_Joint_stocksinvestments_inputs" name="Joint_StockInvestments_Current_Value3" value="0.00" min="0.00" step="0.01" max="999999.99" onchange="getJointCurrentValue(this, '3', 'Joint');" onkeyup="getJointCurrentValue(this, '3', 'Joint');"> 
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label for="Joint_StockInvestments_Percent_Marital_Equity3">N/A, calculated = Joint_StockInvestments_Institution_Current_Value3</label>
                                    <input id="Joint_StockInvestments_Percent_Marital_Equity3" type="number" class="form-control 3_Joint_stocksinvestments_inputs" name="Joint_StockInvestments_Percent_Marital_Equity3" value="" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_StockInvestments_Yearly_Interest_Dividend3">Yearly Interest and Dividends from this account?</label>
                                    <input id="Joint_StockInvestments_Yearly_Interest_Dividend3" type="number" class="form-control 3_Joint_stocksinvestments_inputs" name="Joint_StockInvestments_Yearly_Interest_Dividend3" value="0.00" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Does either party claim a sole/separate interest from the other on this account?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Joint_StockInvestments_SoleSeparate_Claim3_Yes" name="Joint_StockInvestments_SoleSeparate_Claim3" value="Yes" onchange="getPartyClaimSoleSeparate(this, '3', 'Joint');"> Yes</label>
                                        <label><input type="radio" id="Joint_StockInvestments_SoleSeparate_Claim3_No" name="Joint_StockInvestments_SoleSeparate_Claim3" value="No" checked="" onchange="getPartyClaimSoleSeparate(this, '3', 'Joint');"> No</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6" id="Joint_StockInvestments_SoleSeparate_Party3_Div" style="display: none;">
                                    <label>Who claims to own this account?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Joint_StockInvestments_SoleSeparate_Party3_Client" name="Joint_StockInvestments_SoleSeparate_Party3" value="{{$client_name}}"> {{$client_name}}</label>
                                        <label><input type="radio" id="Joint_StockInvestments_SoleSeparate_Party3_Op" name="Joint_StockInvestments_SoleSeparate_Party3" value="{{$opponent_name}}" checked=""> {{$opponent_name}}</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 left-clear" id="Joint_StockInvestments_SoleSeparate_Grounds3_Div" style="display: none; clear: left;">
                                    <label for="Joint_StockInvestments_SoleSeparate_Grounds3">Why does this person own this account solely and separately?</label>
                                    <input id="Joint_StockInvestments_SoleSeparate_Grounds3" type="text" class="form-control 3_Joint_stocksinvestments_inputs" name="Joint_StockInvestments_SoleSeparate_Grounds3" value=""> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>How will this account value be distributed between the parties?</label>
                                    <div class="w-100 dataInput">
                                        <label><input type="radio" id="Joint_StockInvestments_Disposition_Method3_Distribute Investments" name="Joint_StockInvestments_Disposition_Method3" value="Distribute Investments" onchange="getDipositionMethod(this, '3', 'Joint');"> Distribute Investments</label>
                                        <label><input type="radio" id="Joint_StockInvestments_Disposition_Method3_Liquidate/Split Net Value" name="Joint_StockInvestments_Disposition_Method3" value="Liquidate/Split Net Value" onchange="getDipositionMethod(this, '3', 'Joint');"> Liquidate/Split Net Value</label>
                                        <label><input type="radio" id="Joint_StockInvestments_Disposition_Method3_Percentage Buyout" name="Joint_StockInvestments_Disposition_Method3" value="Percentage Buyout" onchange="getDipositionMethod(this, '3', 'Joint');"> Percentage Buyout</label>
                                        <label><input type="radio" id="Joint_StockInvestments_Disposition_Method3_Fixed Buyout" name="Joint_StockInvestments_Disposition_Method3" value="Fixed Buyout" onchange="getDipositionMethod(this, '3', 'Joint');"> Fixed Buyout</label>
                                    </div>
                                </div>
                                <!-- slider tool -->
                                <div class="form-group col-sm-6 m-auto 3_Joint_Slider_Tool slider-tool-main">
                                    <div class="row">
                                        <div class="col">{{$client_name}}</div>
                                        <div class="col text-right">{{$opponent_name}}</div>
                                    </div>
                                    <input id="3_Joint_balance_range_selector" type="range" class="form-control slider-tool-input 3_Joint_balance_range_selector" name="" value="50.00" min="0.00" step="0.01" max="100" onchange="updateBalanceInput(this.value, '3', 'Joint');">
                                </div>
                                <div class="form-group col-sm-6 m-auto 3_Joint_Slider_Tool slider-tool-main">
                                    <div class="row justify-content-between">
                                        <div class="col selectorTool">
                                            <div class="left-col">
                                                <div class="client-info 3_Joint_clientpercentage_div clientpercentage_div">
                                                    50.00%
                                                </div>
                                                <div class="client-info 3_Joint_clientamount_div clientamount_div" style="clear: both;">
                                                    $0
                                                </div>
                                            </div>
                                            <label>To {{$client_name}}</label>
                                        </div>                                       
                                        <div class="col selectorTool selectorToolRight">
                                            <label>To {{$opponent_name}}</label>
                                            <div class="left-col right-col">
                                                <div class="client-info 3_Joint_opponentpercentage_div opponentpercentage_div">
                                                    50.00%
                                                </div>
                                                <div class="client-info 3_Joint_opponentamount_div opponentamount_div" style="clear: both;">
                                                    $0
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 m-auto 3_Joint_Slider_Tool slider-tool-main">
                                    <label></label>
                                    <div class="w-100">
                                        <label><input type="radio" id="3_Joint_StockInvestments_Estimated_Value_Select" name="3_Joint_StockInvestments_Estimated_Value_Select_Reset" class="StockInvestments_Estimated_Value_Select_Reset" value="Save"> Save this Distribution of StockInvestment Account #3</label>
                                        <label><input type="radio" id="3_Joint_StockInvestments_Estimated_Value_Reset" name="3_Joint_StockInvestments_Estimated_Value_Select_Reset" class="StockInvestments_Estimated_Value_Select_Reset" value="Reset" onclick="resetBalanceInput(this, '3', 'Joint');"> Reset to Default (50%)</label>
                                    </div>
                                </div>

                                <div class="form-group col-sm-6 Joint_StockInvestments_Paying_Party3_Inputs_Div" style="display: none;">
                                    <label>Joint StockInvestments Paying Party3</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Joint_StockInvestments_Paying_Party3_Client" name="Joint_StockInvestments_Paying_Party3" value="{{$client_name}}" onchange="getStockInvestmentPayingParty(this, '3', 'Joint');"> {{$client_name}}</label>
                                        <label><input type="radio" id="Joint_StockInvestments_Paying_Party3_Op" name="Joint_StockInvestments_Paying_Party3" value="{{$opponent_name}}" onchange="getStockInvestmentPayingParty(this, '3', 'Joint');"> {{$opponent_name}}</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 Joint_StockInvestments_Paying_Party3_Inputs_Div" style="display: none;">
                                    <label>{{$client_name}} StockInvestment Equity Percent</label>
                                    <input id="Joint_StockInvestments_Percent_Marital_Equity_to_Client3" type="number" class="form-control 3_Joint_clientpercentage_input clientpercentage_input" name="Joint_StockInvestments_Percent_Marital_Equity_to_Client3" value="50.00" min="0.00" step="0.01" max="100" readonly="">
                                </div>
                                <div class="form-group col-sm-6 Joint_StockInvestments_Paying_Party3_Inputs_Div" style="display: none;">
                                    <label>How much is to be paid to {{$client_name}}?</label>
                                    <input id="Joint_StockInvestments_Estimated_Value_to_Client3" type="number" class="form-control 3_Joint_clientamount_input clientamount_input" name="Joint_StockInvestments_Estimated_Value_to_Client3" value="" min="0.00" step="0.01" max="999999.99" readonly="" onchange="getEstimatedValueClient(this, '3', 'Joint');" onkeyup="getEstimatedValueClient(this, '3', 'Joint');">
                                </div>
                                <div class="form-group col-sm-6 Joint_StockInvestments_Paying_Party3_Inputs_Div" style="display: none;">
                                    <label>{{$opponent_name}} StockInvestment Equity Percent</label>
                                    <input id="Joint_StockInvestments_Percent_Marital_Equity_to_Op3" type="number" class="form-control 3_Joint_opponentpercentage_input opponentpercentage_input" name="Joint_StockInvestments_Percent_Marital_Equity_to_Op3" value="50.00" min="0.00" step="0.01" max="100" readonly="">
                                </div>
                                <div class="form-group col-sm-6 Joint_StockInvestments_Paying_Party3_Inputs_Div" style="display: none;">
                                    <label>How much is to be paid to {{$opponent_name}}?</label>
                                    <input id="Joint_StockInvestments_Estimated_Value_to_Op3" type="number" class="form-control 3_Joint_opponentamount_input opponentamount_input" name="Joint_StockInvestments_Estimated_Value_to_Op3" value="" min="0.00" step="0.01" max="999999.99" readonly="" onchange="getEstimatedValueOp(this, '3', 'Joint');" onkeyup="getEstimatedValueOp(this, '3', 'Joint');">
                                </div>
                                <!-- end of slider tool -->
                            </div>
                            <div class="col-sm-12 mt-4 4_Joint_stocksinvestments_section" style="display: none;"><h5 class="col-sm-12">Fourth Stock Investment Info</h5>
                                <div class="form-group col-sm-6">
                                    <p class="text-danger 4_Joint_no-state-county-found" style="display: none;">No City, State, County found for this zipcode.</p>
                                    <label for="Joint_StockInvestments_Institution_ZIP4">Stock/Investment Institution Zip Code?</label>
                                    <input id="Joint_StockInvestments_Institution_ZIP4" type="text" class="form-control 4_Joint_stocksinvestments_inputs" name="Joint_StockInvestments_Institution_ZIP4" value="" onkeyup="getCityStateForZip(this, '4_Joint');"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_StockInvestments_Institution_Name4">Name of Stock/Investment Institution?</label>
                                    <input id="Joint_StockInvestments_Institution_Name4" type="text" class="form-control 4_Joint_stocksinvestments_inputs" name="Joint_StockInvestments_Institution_Name4" value=""> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_StockInvestments_Institution_Street_Address4">Stock/Investment Institution Street Address?</label>
                                    <input id="Joint_StockInvestments_Institution_Street_Address4" type="text" class="form-control 4_Joint_stocksinvestments_inputs" name="Joint_StockInvestments_Institution_Street_Address4" value=""> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_StockInvestments_Institution_City4">Stock/Investment Institution City?</label>
                                    <select id="Joint_StockInvestments_Institution_City4" name="Joint_StockInvestments_Institution_City4" class="form-control 4_Joint_city_select">
                                        <option value="">Choose City</option>
                                    </select>   
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_StockInvestments_Institution_State4">Stock/Investment Institution State?</label>
                                    <select id="Joint_StockInvestments_Institution_State4" name="Joint_StockInvestments_Institution_State4" class="form-control 4_Joint_state_select">
                                        <option value="">Choose State</option>
                                    </select>   
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_StockInvestments_Acct_Num4">Account Number?</label>
                                    <input id="Joint_StockInvestments_Acct_Num4" type="text" class="form-control 4_Joint_stocksinvestments_inputs" name="Joint_StockInvestments_Acct_Num4" value=""> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_StockInvestments_Date_Marriage_Value4">Marriage Date Value?</label>
                                    <input id="Joint_StockInvestments_Date_Marriage_Value4" type="number" class="form-control 4_Joint_stocksinvestments_inputs" name="Joint_StockInvestments_Date_Marriage_Value4" value="0.00" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_StockInvestments_Current_Value4">Current Value?</label>
                                    <input id="Joint_StockInvestments_Current_Value4" type="number" class="form-control 4_Joint_stocksinvestments_inputs" name="Joint_StockInvestments_Current_Value4" value="0.00" min="0.00" step="0.01" max="999999.99" onchange="getJointCurrentValue(this, '4', 'Joint');" onkeyup="getJointCurrentValue(this, '4', 'Joint');"> 
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label for="Joint_StockInvestments_Percent_Marital_Equity4">N/A, calculated = Joint_StockInvestments_Institution_Current_Value4</label>
                                    <input id="Joint_StockInvestments_Percent_Marital_Equity4" type="number" class="form-control 4_Joint_stocksinvestments_inputs" name="Joint_StockInvestments_Percent_Marital_Equity4" value="" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_StockInvestments_Yearly_Interest_Dividend4">Yearly Interest and Dividends from this account?</label>
                                    <input id="Joint_StockInvestments_Yearly_Interest_Dividend4" type="number" class="form-control 4_Joint_stocksinvestments_inputs" name="Joint_StockInvestments_Yearly_Interest_Dividend4" value="0.00" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Does either party claim a sole/separate interest from the other on this account?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Joint_StockInvestments_SoleSeparate_Claim4_Yes" name="Joint_StockInvestments_SoleSeparate_Claim4" value="Yes" onchange="getPartyClaimSoleSeparate(this, '4', 'Joint');"> Yes</label>
                                        <label><input type="radio" id="Joint_StockInvestments_SoleSeparate_Claim4_No" name="Joint_StockInvestments_SoleSeparate_Claim4" value="No" checked="" onchange="getPartyClaimSoleSeparate(this, '4', 'Joint');"> No</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6" id="Joint_StockInvestments_SoleSeparate_Party4_Div" style="display: none;">
                                    <label>Who claims to own this account?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Joint_StockInvestments_SoleSeparate_Party4_Client" name="Joint_StockInvestments_SoleSeparate_Party4" value="{{$client_name}}"> {{$client_name}}</label>
                                        <label><input type="radio" id="Joint_StockInvestments_SoleSeparate_Party4_Op" name="Joint_StockInvestments_SoleSeparate_Party4" value="{{$opponent_name}}" checked=""> {{$opponent_name}}</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 left-clear" id="Joint_StockInvestments_SoleSeparate_Grounds4_Div" style="display: none; clear: left;">
                                    <label for="Joint_StockInvestments_SoleSeparate_Grounds4">Why does this person own this account solely and separately?</label>
                                    <input id="Joint_StockInvestments_SoleSeparate_Grounds4" type="text" class="form-control 4_Joint_stocksinvestments_inputs" name="Joint_StockInvestments_SoleSeparate_Grounds4" value=""> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>How will this account value be distributed between the parties?</label>
                                    <div class="w-100 dataInput">
                                        <label><input type="radio" id="Joint_StockInvestments_Disposition_Method4_Distribute Investments" name="Joint_StockInvestments_Disposition_Method4" value="Distribute Investments" onchange="getDipositionMethod(this, '4', 'Joint');"> Distribute Investments</label>
                                        <label><input type="radio" id="Joint_StockInvestments_Disposition_Method4_Liquidate/Split Net Value" name="Joint_StockInvestments_Disposition_Method4" value="Liquidate/Split Net Value" onchange="getDipositionMethod(this, '4', 'Joint');"> Liquidate/Split Net Value</label>
                                        <label><input type="radio" id="Joint_StockInvestments_Disposition_Method4_Percentage Buyout" name="Joint_StockInvestments_Disposition_Method4" value="Percentage Buyout" onchange="getDipositionMethod(this, '4', 'Joint');"> Percentage Buyout</label>
                                        <label><input type="radio" id="Joint_StockInvestments_Disposition_Method4_Fixed Buyout" name="Joint_StockInvestments_Disposition_Method4" value="Fixed Buyout" onchange="getDipositionMethod(this, '4', 'Joint');"> Fixed Buyout</label>
                                    </div>
                                </div>
                                <!-- slider tool -->
                                <div class="form-group col-sm-6 m-auto 4_Joint_Slider_Tool slider-tool-main">
                                    <div class="row">
                                        <div class="col">{{$client_name}}</div>
                                        <div class="col text-right">{{$opponent_name}}</div>
                                    </div>
                                    <input id="4_Joint_balance_range_selector" type="range" class="form-control slider-tool-input 4_Joint_balance_range_selector" name="" value="50.00" min="0.00" step="0.01" max="100" onchange="updateBalanceInput(this.value, '4', 'Joint');">
                                </div>
                                <div class="form-group col-sm-6 m-auto 4_Joint_Slider_Tool slider-tool-main">
                                    <div class="row justify-content-between">
                                        <div class="col selectorTool">
                                            <div class="left-col">
                                                <div class="client-info 4_Joint_clientpercentage_div clientpercentage_div">
                                                    50.00%
                                                </div>
                                                <div class="client-info 4_Joint_clientamount_div clientamount_div" style="clear: both;">
                                                    $0
                                                </div>
                                            </div>
                                            <label>To {{$client_name}}</label>
                                        </div>                                       
                                        <div class="col selectorTool selectorToolRight">
                                            <label>To {{$opponent_name}}</label>
                                            <div class="left-col right-col">
                                                <div class="client-info 4_Joint_opponentpercentage_div opponentpercentage_div">
                                                    50.00%
                                                </div>
                                                <div class="client-info 4_Joint_opponentamount_div opponentamount_div" style="clear: both;">
                                                    $0
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 m-auto 4_Joint_Slider_Tool slider-tool-main">
                                    <label></label>
                                    <div class="w-100">
                                        <label><input type="radio" id="4_Joint_StockInvestments_Estimated_Value_Select" name="4_Joint_StockInvestments_Estimated_Value_Select_Reset" class="StockInvestments_Estimated_Value_Select_Reset" value="Save"> Save this Distribution of StockInvestment Account #4</label>
                                        <label><input type="radio" id="4_Joint_StockInvestments_Estimated_Value_Reset" name="4_Joint_StockInvestments_Estimated_Value_Select_Reset" class="StockInvestments_Estimated_Value_Select_Reset" value="Reset" onclick="resetBalanceInput(this, '4', 'Joint');"> Reset to Default (50%)</label>
                                    </div>
                                </div>

                                <div class="form-group col-sm-6 Joint_StockInvestments_Paying_Party4_Inputs_Div" style="display: none;">
                                    <label>Joint StockInvestments Paying Party4</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Joint_StockInvestments_Paying_Party4_Client" name="Joint_StockInvestments_Paying_Party4" value="{{$client_name}}" onchange="getStockInvestmentPayingParty(this, '4', 'Joint');"> {{$client_name}}</label>
                                        <label><input type="radio" id="Joint_StockInvestments_Paying_Party4_Op" name="Joint_StockInvestments_Paying_Party4" value="{{$opponent_name}}" onchange="getStockInvestmentPayingParty(this, '4', 'Joint');"> {{$opponent_name}}</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 Joint_StockInvestments_Paying_Party4_Inputs_Div" style="display: none;">
                                    <label>{{$client_name}} StockInvestment Equity Percent</label>
                                    <input id="Joint_StockInvestments_Percent_Marital_Equity_to_Client4" type="number" class="form-control 4_Joint_clientpercentage_input clientpercentage_input" name="Joint_StockInvestments_Percent_Marital_Equity_to_Client4" value="50.00" min="0.00" step="0.01" max="100" readonly="">
                                </div>
                                <div class="form-group col-sm-6 Joint_StockInvestments_Paying_Party4_Inputs_Div" style="display: none;">
                                    <label>How much is to be paid to {{$client_name}}?</label>
                                    <input id="Joint_StockInvestments_Estimated_Value_to_Client4" type="number" class="form-control 4_Joint_clientamount_input clientamount_input" name="Joint_StockInvestments_Estimated_Value_to_Client4" value="" min="0.00" step="0.01" max="999999.99" readonly="" onchange="getEstimatedValueClient(this, '4', 'Joint');" onkeyup="getEstimatedValueClient(this, '4', 'Joint');">
                                </div>
                                <div class="form-group col-sm-6 Joint_StockInvestments_Paying_Party4_Inputs_Div" style="display: none;">
                                    <label>{{$opponent_name}} StockInvestment Equity Percent</label>
                                    <input id="Joint_StockInvestments_Percent_Marital_Equity_to_Op4" type="number" class="form-control 4_Joint_opponentpercentage_input opponentpercentage_input" name="Joint_StockInvestments_Percent_Marital_Equity_to_Op4" value="50.00" min="0.00" step="0.01" max="100" readonly="">
                                </div>
                                <div class="form-group col-sm-6 Joint_StockInvestments_Paying_Party4_Inputs_Div" style="display: none;">
                                    <label>How much is to be paid to {{$opponent_name}}?</label>
                                    <input id="Joint_StockInvestments_Estimated_Value_to_Op4" type="number" class="form-control 4_Joint_opponentamount_input opponentamount_input" name="Joint_StockInvestments_Estimated_Value_to_Op4" value="" min="0.00" step="0.01" max="999999.99" readonly="" onchange="getEstimatedValueOp(this, '4', 'Joint');" onkeyup="getEstimatedValueOp(this, '4', 'Joint');">
                                </div>
                                <!-- end of slider tool -->
                            </div>
                            <div class="col-sm-12 mt-4 5_Joint_stocksinvestments_section" style="display: none;"><h5 class="col-sm-12">Fifth Stock Investment Info</h5>
                                <div class="form-group col-sm-6">
                                    <p class="text-danger 5_Joint_no-state-county-found" style="display: none;">No City, State, County found for this zipcode.</p>
                                    <label for="Joint_StockInvestments_Institution_ZIP5">Stock/Investment Institution Zip Code?</label>
                                    <input id="Joint_StockInvestments_Institution_ZIP5" type="text" class="form-control 5_Joint_stocksinvestments_inputs" name="Joint_StockInvestments_Institution_ZIP5" value="" onkeyup="getCityStateForZip(this, '5_Joint');"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_StockInvestments_Institution_Name5">Name of Stock/Investment Institution?</label>
                                    <input id="Joint_StockInvestments_Institution_Name5" type="text" class="form-control 5_Joint_stocksinvestments_inputs" name="Joint_StockInvestments_Institution_Name5" value=""> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_StockInvestments_Institution_Street_Address5">Stock/Investment Institution Street Address?</label>
                                    <input id="Joint_StockInvestments_Institution_Street_Address5" type="text" class="form-control 5_Joint_stocksinvestments_inputs" name="Joint_StockInvestments_Institution_Street_Address5" value=""> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_StockInvestments_Institution_City5">Stock/Investment Institution City?</label>
                                    <select id="Joint_StockInvestments_Institution_City5" name="Joint_StockInvestments_Institution_City5" class="form-control 5_Joint_city_select">
                                        <option value="">Choose City</option>
                                    </select>   
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_StockInvestments_Institution_State5">Stock/Investment Institution State?</label>
                                    <select id="Joint_StockInvestments_Institution_State5" name="Joint_StockInvestments_Institution_State5" class="form-control 5_Joint_state_select">
                                        <option value="">Choose State</option>
                                    </select>   
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_StockInvestments_Acct_Num5">Account Number?</label>
                                    <input id="Joint_StockInvestments_Acct_Num5" type="text" class="form-control 5_Joint_stocksinvestments_inputs" name="Joint_StockInvestments_Acct_Num5" value=""> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_StockInvestments_Date_Marriage_Value5">Marriage Date Value?</label>
                                    <input id="Joint_StockInvestments_Date_Marriage_Value5" type="number" class="form-control 5_Joint_stocksinvestments_inputs" name="Joint_StockInvestments_Date_Marriage_Value5" value="0.00" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_StockInvestments_Current_Value5">Current Value?</label>
                                    <input id="Joint_StockInvestments_Current_Value5" type="number" class="form-control 5_Joint_stocksinvestments_inputs" name="Joint_StockInvestments_Current_Value5" value="0.00" min="0.00" step="0.01" max="999999.99" onchange="getJointCurrentValue(this, '5', 'Joint');" onkeyup="getJointCurrentValue(this, '5', 'Joint');"> 
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label for="Joint_StockInvestments_Percent_Marital_Equity5">N/A, calculated = Joint_StockInvestments_Institution_Current_Value5</label>
                                    <input id="Joint_StockInvestments_Percent_Marital_Equity5" type="number" class="form-control 5_Joint_stocksinvestments_inputs" name="Joint_StockInvestments_Percent_Marital_Equity5" value="" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_StockInvestments_Yearly_Interest_Dividend5">Yearly Interest and Dividends from this account?</label>
                                    <input id="Joint_StockInvestments_Yearly_Interest_Dividend5" type="number" class="form-control 5_Joint_stocksinvestments_inputs" name="Joint_StockInvestments_Yearly_Interest_Dividend5" value="0.00" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Does either party claim a sole/separate interest from the other on this account?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Joint_StockInvestments_SoleSeparate_Claim5_Yes" name="Joint_StockInvestments_SoleSeparate_Claim5" value="Yes" onchange="getPartyClaimSoleSeparate(this, '5', 'Joint');"> Yes</label>
                                        <label><input type="radio" id="Joint_StockInvestments_SoleSeparate_Claim5_No" name="Joint_StockInvestments_SoleSeparate_Claim5" value="No" checked="" onchange="getPartyClaimSoleSeparate(this, '5', 'Joint');"> No</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6" id="Joint_StockInvestments_SoleSeparate_Party5_Div" style="display: none;">
                                    <label>Who claims to own this account?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Joint_StockInvestments_SoleSeparate_Party5_Client" name="Joint_StockInvestments_SoleSeparate_Party5" value="{{$client_name}}"> {{$client_name}}</label>
                                        <label><input type="radio" id="Joint_StockInvestments_SoleSeparate_Party5_Op" name="Joint_StockInvestments_SoleSeparate_Party5" value="{{$opponent_name}}" checked=""> {{$opponent_name}}</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 left-clear" id="Joint_StockInvestments_SoleSeparate_Grounds5_Div" style="display: none; clear: left;">
                                    <label for="Joint_StockInvestments_SoleSeparate_Grounds5">Why does this person own this account solely and separately?</label>
                                    <input id="Joint_StockInvestments_SoleSeparate_Grounds5" type="text" class="form-control 5_Joint_stocksinvestments_inputs" name="Joint_StockInvestments_SoleSeparate_Grounds5" value=""> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>How will this account value be distributed between the parties?</label>
                                    <div class="w-100 dataInput">
                                        <label><input type="radio" id="Joint_StockInvestments_Disposition_Method5_Distribute Investments" name="Joint_StockInvestments_Disposition_Method5" value="Distribute Investments" onchange="getDipositionMethod(this, '5', 'Joint');"> Distribute Investments</label>
                                        <label><input type="radio" id="Joint_StockInvestments_Disposition_Method5_Liquidate/Split Net Value" name="Joint_StockInvestments_Disposition_Method5" value="Liquidate/Split Net Value" onchange="getDipositionMethod(this, '5', 'Joint');"> Liquidate/Split Net Value</label>
                                        <label><input type="radio" id="Joint_StockInvestments_Disposition_Method5_Percentage Buyout" name="Joint_StockInvestments_Disposition_Method5" value="Percentage Buyout" onchange="getDipositionMethod(this, '5', 'Joint');"> Percentage Buyout</label>
                                        <label><input type="radio" id="Joint_StockInvestments_Disposition_Method5_Fixed Buyout" name="Joint_StockInvestments_Disposition_Method5" value="Fixed Buyout" onchange="getDipositionMethod(this, '5', 'Joint');"> Fixed Buyout</label>
                                    </div>
                                </div>
                                <!-- slider tool -->
                                <div class="form-group col-sm-6 m-auto 5_Joint_Slider_Tool slider-tool-main">
                                    <div class="row">
                                        <div class="col">{{$client_name}}</div>
                                        <div class="col text-right">{{$opponent_name}}</div>
                                    </div>
                                    <input id="5_Joint_balance_range_selector" type="range" class="form-control slider-tool-input 5_Joint_balance_range_selector" name="" value="50.00" min="0.00" step="0.01" max="100" onchange="updateBalanceInput(this.value, '5', 'Joint');">
                                </div>
                                <div class="form-group col-sm-6 m-auto 5_Joint_Slider_Tool slider-tool-main">
                                    <div class="row justify-content-between">
                                        <div class="col selectorTool">
                                            <div class="left-col">
                                                <div class="client-info 5_Joint_clientpercentage_div clientpercentage_div">
                                                    50.00%
                                                </div>
                                                <div class="client-info 5_Joint_clientamount_div clientamount_div" style="clear: both;">
                                                    $0
                                                </div>
                                            </div>
                                            <label>To {{$client_name}}</label>
                                        </div>                                       
                                        <div class="col selectorTool selectorToolRight">
                                            <label>To {{$opponent_name}}</label>
                                            <div class="left-col right-col">
                                                <div class="client-info 5_Joint_opponentpercentage_div opponentpercentage_div">
                                                    50.00%
                                                </div>
                                                <div class="client-info 5_Joint_opponentamount_div opponentamount_div" style="clear: both;">
                                                    $0
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 m-auto 5_Joint_Slider_Tool slider-tool-main">
                                    <label></label>
                                    <div class="w-100">
                                        <label><input type="radio" id="5_Joint_StockInvestments_Estimated_Value_Select" name="5_Joint_StockInvestments_Estimated_Value_Select_Reset" class="StockInvestments_Estimated_Value_Select_Reset" value="Save"> Save this Distribution of StockInvestment Account #5</label>
                                        <label><input type="radio" id="5_Joint_StockInvestments_Estimated_Value_Reset" name="5_Joint_StockInvestments_Estimated_Value_Select_Reset" class="StockInvestments_Estimated_Value_Select_Reset" value="Reset" onclick="resetBalanceInput(this, '5', 'Joint');"> Reset to Default (50%)</label>
                                    </div>
                                </div>

                                <div class="form-group col-sm-6 Joint_StockInvestments_Paying_Party5_Inputs_Div" style="display: none;">
                                    <label>Joint StockInvestments Paying Party5</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Joint_StockInvestments_Paying_Party5_Client" name="Joint_StockInvestments_Paying_Party5" value="{{$client_name}}" onchange="getStockInvestmentPayingParty(this, '5', 'Joint');"> {{$client_name}}</label>
                                        <label><input type="radio" id="Joint_StockInvestments_Paying_Party5_Op" name="Joint_StockInvestments_Paying_Party5" value="{{$opponent_name}}" onchange="getStockInvestmentPayingParty(this, '5', 'Joint');"> {{$opponent_name}}</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 Joint_StockInvestments_Paying_Party5_Inputs_Div" style="display: none;">
                                    <label>{{$client_name}} StockInvestment Equity Percent</label>
                                    <input id="Joint_StockInvestments_Percent_Marital_Equity_to_Client5" type="number" class="form-control 5_Joint_clientpercentage_input clientpercentage_input" name="Joint_StockInvestments_Percent_Marital_Equity_to_Client5" value="50.00" min="0.00" step="0.01" max="100" readonly="">
                                </div>
                                <div class="form-group col-sm-6 Joint_StockInvestments_Paying_Party5_Inputs_Div" style="display: none;">
                                    <label>How much is to be paid to {{$client_name}}?</label>
                                    <input id="Joint_StockInvestments_Estimated_Value_to_Client5" type="number" class="form-control 5_Joint_clientamount_input clientamount_input" name="Joint_StockInvestments_Estimated_Value_to_Client5" value="" min="0.00" step="0.01" max="999999.99" readonly="" onchange="getEstimatedValueClient(this, '5', 'Joint');" onkeyup="getEstimatedValueClient(this, '5', 'Joint');">
                                </div>
                                <div class="form-group col-sm-6 Joint_StockInvestments_Paying_Party5_Inputs_Div" style="display: none;">
                                    <label>{{$opponent_name}} StockInvestment Equity Percent</label>
                                    <input id="Joint_StockInvestments_Percent_Marital_Equity_to_Op5" type="number" class="form-control 5_Joint_opponentpercentage_input opponentpercentage_input" name="Joint_StockInvestments_Percent_Marital_Equity_to_Op5" value="50.00" min="0.00" step="0.01" max="100" readonly="">
                                </div>
                                <div class="form-group col-sm-6 Joint_StockInvestments_Paying_Party5_Inputs_Div" style="display: none;">
                                    <label>How much is to be paid to {{$opponent_name}}?</label>
                                    <input id="Joint_StockInvestments_Estimated_Value_to_Op5" type="number" class="form-control 5_Joint_opponentamount_input opponentamount_input" name="Joint_StockInvestments_Estimated_Value_to_Op5" value="" min="0.00" step="0.01" max="999999.99" readonly="" onchange="getEstimatedValueOp(this, '5', 'Joint');" onkeyup="getEstimatedValueOp(this, '5', 'Joint');">
                                </div>
                                <!-- end of slider tool -->
                            </div>
                            <div class="col-sm-12 mt-4 6_Joint_stocksinvestments_section" style="display: none;"><h5 class="col-sm-12">Sixth Stock Investment Info</h5>
                                <div class="form-group col-sm-6">
                                    <p class="text-danger 6_Joint_no-state-county-found" style="display: none;">No City, State, County found for this zipcode.</p>
                                    <label for="Joint_StockInvestments_Institution_ZIP6">Stock/Investment Institution Zip Code?</label>
                                    <input id="Joint_StockInvestments_Institution_ZIP6" type="text" class="form-control 6_Joint_stocksinvestments_inputs" name="Joint_StockInvestments_Institution_ZIP6" value="" onkeyup="getCityStateForZip(this, '6_Joint');"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_StockInvestments_Institution_Name6">Name of Stock/Investment Institution?</label>
                                    <input id="Joint_StockInvestments_Institution_Name6" type="text" class="form-control 6_Joint_stocksinvestments_inputs" name="Joint_StockInvestments_Institution_Name6" value=""> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_StockInvestments_Institution_Street_Address6">Stock/Investment Institution Street Address?</label>
                                    <input id="Joint_StockInvestments_Institution_Street_Address6" type="text" class="form-control 6_Joint_stocksinvestments_inputs" name="Joint_StockInvestments_Institution_Street_Address6" value=""> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_StockInvestments_Institution_City6">Stock/Investment Institution City?</label>
                                    <select id="Joint_StockInvestments_Institution_City6" name="Joint_StockInvestments_Institution_City6" class="form-control 6_Joint_city_select">
                                        <option value="">Choose City</option>
                                    </select>   
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_StockInvestments_Institution_State6">Stock/Investment Institution State?</label>
                                    <select id="Joint_StockInvestments_Institution_State6" name="Joint_StockInvestments_Institution_State6" class="form-control 6_Joint_state_select">
                                        <option value="">Choose State</option>
                                    </select>   
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_StockInvestments_Acct_Num6">Account Number?</label>
                                    <input id="Joint_StockInvestments_Acct_Num6" type="text" class="form-control 6_Joint_stocksinvestments_inputs" name="Joint_StockInvestments_Acct_Num6" value=""> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_StockInvestments_Date_Marriage_Value6">Marriage Date Value?</label>
                                    <input id="Joint_StockInvestments_Date_Marriage_Value6" type="number" class="form-control 6_Joint_stocksinvestments_inputs" name="Joint_StockInvestments_Date_Marriage_Value6" value="0.00" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_StockInvestments_Current_Value6">Current Value?</label>
                                    <input id="Joint_StockInvestments_Current_Value6" type="number" class="form-control 6_Joint_stocksinvestments_inputs" name="Joint_StockInvestments_Current_Value6" value="0.00" min="0.00" step="0.01" max="999999.99" onchange="getJointCurrentValue(this, '6', 'Joint');" onkeyup="getJointCurrentValue(this, '6', 'Joint');"> 
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label for="Joint_StockInvestments_Percent_Marital_Equity6">N/A, calculated = Joint_StockInvestments_Institution_Current_Value6</label>
                                    <input id="Joint_StockInvestments_Percent_Marital_Equity6" type="number" class="form-control 6_Joint_stocksinvestments_inputs" name="Joint_StockInvestments_Percent_Marital_Equity6" value="" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_StockInvestments_Yearly_Interest_Dividend6">Yearly Interest and Dividends from this account?</label>
                                    <input id="Joint_StockInvestments_Yearly_Interest_Dividend6" type="number" class="form-control 6_Joint_stocksinvestments_inputs" name="Joint_StockInvestments_Yearly_Interest_Dividend6" value="0.00" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Does either party claim a sole/separate interest from the other on this account?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Joint_StockInvestments_SoleSeparate_Claim6_Yes" name="Joint_StockInvestments_SoleSeparate_Claim6" value="Yes" onchange="getPartyClaimSoleSeparate(this, '6', 'Joint');"> Yes</label>
                                        <label><input type="radio" id="Joint_StockInvestments_SoleSeparate_Claim6_No" name="Joint_StockInvestments_SoleSeparate_Claim6" value="No" checked="" onchange="getPartyClaimSoleSeparate(this, '6', 'Joint');"> No</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6" id="Joint_StockInvestments_SoleSeparate_Party6_Div" style="display: none;">
                                    <label>Who claims to own this account?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Joint_StockInvestments_SoleSeparate_Party6_Client" name="Joint_StockInvestments_SoleSeparate_Party6" value="{{$client_name}}"> {{$client_name}}</label>
                                        <label><input type="radio" id="Joint_StockInvestments_SoleSeparate_Party6_Op" name="Joint_StockInvestments_SoleSeparate_Party6" value="{{$opponent_name}}" checked=""> {{$opponent_name}}</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 left-clear" id="Joint_StockInvestments_SoleSeparate_Grounds6_Div" style="display: none; clear: left;">
                                    <label for="Joint_StockInvestments_SoleSeparate_Grounds6">Why does this person own this account solely and separately?</label>
                                    <input id="Joint_StockInvestments_SoleSeparate_Grounds6" type="text" class="form-control 6_Joint_stocksinvestments_inputs" name="Joint_StockInvestments_SoleSeparate_Grounds6" value=""> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>How will this account value be distributed between the parties?</label>
                                    <div class="w-100 dataInput">
                                        <label><input type="radio" id="Joint_StockInvestments_Disposition_Method6_Distribute Investments" name="Joint_StockInvestments_Disposition_Method6" value="Distribute Investments" onchange="getDipositionMethod(this, '6', 'Joint');"> Distribute Investments</label>
                                        <label><input type="radio" id="Joint_StockInvestments_Disposition_Method6_Liquidate/Split Net Value" name="Joint_StockInvestments_Disposition_Method6" value="Liquidate/Split Net Value" onchange="getDipositionMethod(this, '6', 'Joint');"> Liquidate/Split Net Value</label>
                                        <label><input type="radio" id="Joint_StockInvestments_Disposition_Method6_Percentage Buyout" name="Joint_StockInvestments_Disposition_Method6" value="Percentage Buyout" onchange="getDipositionMethod(this, '6', 'Joint');"> Percentage Buyout</label>
                                        <label><input type="radio" id="Joint_StockInvestments_Disposition_Method6_Fixed Buyout" name="Joint_StockInvestments_Disposition_Method6" value="Fixed Buyout" onchange="getDipositionMethod(this, '6', 'Joint');"> Fixed Buyout</label>
                                    </div>
                                </div>
                                <!-- slider tool -->
                                <div class="form-group col-sm-6 m-auto 6_Joint_Slider_Tool slider-tool-main">
                                    <div class="row">
                                        <div class="col">{{$client_name}}</div>
                                        <div class="col text-right">{{$opponent_name}}</div>
                                    </div>
                                    <input id="6_Joint_balance_range_selector" type="range" class="form-control slider-tool-input 6_Joint_balance_range_selector" name="" value="50.00" min="0.00" step="0.01" max="100" onchange="updateBalanceInput(this.value, '6', 'Joint');">
                                </div>
                                <div class="form-group col-sm-6 m-auto 6_Joint_Slider_Tool slider-tool-main">
                                    <div class="row justify-content-between">
                                        <div class="col selectorTool">
                                            <div class="left-col">
                                                <div class="client-info 6_Joint_clientpercentage_div clientpercentage_div">
                                                    50.00%
                                                </div>
                                                <div class="client-info 6_Joint_clientamount_div clientamount_div" style="clear: both;">
                                                    $0
                                                </div>
                                            </div>
                                            <label>To {{$client_name}}</label>
                                        </div>                                       
                                        <div class="col selectorTool selectorToolRight">
                                            <label>To {{$opponent_name}}</label>
                                            <div class="left-col right-col">
                                                <div class="client-info 6_Joint_opponentpercentage_div opponentpercentage_div">
                                                    50.00%
                                                </div>
                                                <div class="client-info 6_Joint_opponentamount_div opponentamount_div" style="clear: both;">
                                                    $0
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 m-auto 6_Joint_Slider_Tool slider-tool-main">
                                    <label></label>
                                    <div class="w-100">
                                        <label><input type="radio" id="6_Joint_StockInvestments_Estimated_Value_Select" name="6_Joint_StockInvestments_Estimated_Value_Select_Reset" class="StockInvestments_Estimated_Value_Select_Reset" value="Save"> Save this Distribution of StockInvestment Account #6</label>
                                        <label><input type="radio" id="6_Joint_StockInvestments_Estimated_Value_Reset" name="6_Joint_StockInvestments_Estimated_Value_Select_Reset" class="StockInvestments_Estimated_Value_Select_Reset" value="Reset" onclick="resetBalanceInput(this, '6', 'Joint');"> Reset to Default (50%)</label>
                                    </div>
                                </div>

                                <div class="form-group col-sm-6 Joint_StockInvestments_Paying_Party6_Inputs_Div" style="display: none;">
                                    <label>Joint StockInvestments Paying Party6</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Joint_StockInvestments_Paying_Party6_Client" name="Joint_StockInvestments_Paying_Party6" value="{{$client_name}}" onchange="getStockInvestmentPayingParty(this, '6', 'Joint');"> {{$client_name}}</label>
                                        <label><input type="radio" id="Joint_StockInvestments_Paying_Party6_Op" name="Joint_StockInvestments_Paying_Party6" value="{{$opponent_name}}" onchange="getStockInvestmentPayingParty(this, '6', 'Joint');"> {{$opponent_name}}</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 Joint_StockInvestments_Paying_Party6_Inputs_Div" style="display: none;">
                                    <label>{{$client_name}} StockInvestment Equity Percent</label>
                                    <input id="Joint_StockInvestments_Percent_Marital_Equity_to_Client6" type="number" class="form-control 6_Joint_clientpercentage_input clientpercentage_input" name="Joint_StockInvestments_Percent_Marital_Equity_to_Client6" value="50.00" min="0.00" step="0.01" max="100" readonly="">
                                </div>
                                <div class="form-group col-sm-6 Joint_StockInvestments_Paying_Party6_Inputs_Div" style="display: none;">
                                    <label>How much is to be paid to {{$client_name}}?</label>
                                    <input id="Joint_StockInvestments_Estimated_Value_to_Client6" type="number" class="form-control 6_Joint_clientamount_input clientamount_input" name="Joint_StockInvestments_Estimated_Value_to_Client6" value="" min="0.00" step="0.01" max="999999.99" readonly="" onchange="getEstimatedValueClient(this, '6', 'Joint');" onkeyup="getEstimatedValueClient(this, '6', 'Joint');">
                                </div>
                                <div class="form-group col-sm-6 Joint_StockInvestments_Paying_Party6_Inputs_Div" style="display: none;">
                                    <label>{{$opponent_name}} StockInvestment Equity Percent</label>
                                    <input id="Joint_StockInvestments_Percent_Marital_Equity_to_Op6" type="number" class="form-control 6_Joint_opponentpercentage_input opponentpercentage_input" name="Joint_StockInvestments_Percent_Marital_Equity_to_Op6" value="50.00" min="0.00" step="0.01" max="100" readonly="">
                                </div>
                                <div class="form-group col-sm-6 Joint_StockInvestments_Paying_Party6_Inputs_Div" style="display: none;">
                                    <label>How much is to be paid to {{$opponent_name}}?</label>
                                    <input id="Joint_StockInvestments_Estimated_Value_to_Op6" type="number" class="form-control 6_Joint_opponentamount_input opponentamount_input" name="Joint_StockInvestments_Estimated_Value_to_Op6" value="" min="0.00" step="0.01" max="999999.99" readonly="" onchange="getEstimatedValueOp(this, '6', 'Joint');" onkeyup="getEstimatedValueOp(this, '6', 'Joint');">
                                </div>
                                <!-- end of slider tool -->
                            </div>
                            <div class="col-sm-12 mt-4 7_Joint_stocksinvestments_section" style="display: none;"><h5 class="col-sm-12">Seventh Stock Investment Info</h5>
                                <div class="form-group col-sm-6">
                                    <p class="text-danger 7_Joint_no-state-county-found" style="display: none;">No City, State, County found for this zipcode.</p>
                                    <label for="Joint_StockInvestments_Institution_ZIP7">Stock/Investment Institution Zip Code?</label>
                                    <input id="Joint_StockInvestments_Institution_ZIP7" type="text" class="form-control 7_Joint_stocksinvestments_inputs" name="Joint_StockInvestments_Institution_ZIP7" value="" onkeyup="getCityStateForZip(this, '7_Joint');"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_StockInvestments_Institution_Name7">Name of Stock/Investment Institution?</label>
                                    <input id="Joint_StockInvestments_Institution_Name7" type="text" class="form-control 7_Joint_stocksinvestments_inputs" name="Joint_StockInvestments_Institution_Name7" value=""> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_StockInvestments_Institution_Street_Address7">Stock/Investment Institution Street Address?</label>
                                    <input id="Joint_StockInvestments_Institution_Street_Address7" type="text" class="form-control 7_Joint_stocksinvestments_inputs" name="Joint_StockInvestments_Institution_Street_Address7" value=""> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_StockInvestments_Institution_City7">Stock/Investment Institution City?</label>
                                    <select id="Joint_StockInvestments_Institution_City7" name="Joint_StockInvestments_Institution_City7" class="form-control 7_Joint_city_select">
                                        <option value="">Choose City</option>
                                    </select>   
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_StockInvestments_Institution_State7">Stock/Investment Institution State?</label>
                                    <select id="Joint_StockInvestments_Institution_State7" name="Joint_StockInvestments_Institution_State7" class="form-control 7_Joint_state_select">
                                        <option value="">Choose State</option>
                                    </select>   
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_StockInvestments_Acct_Num7">Account Number?</label>
                                    <input id="Joint_StockInvestments_Acct_Num7" type="text" class="form-control 7_Joint_stocksinvestments_inputs" name="Joint_StockInvestments_Acct_Num7" value=""> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_StockInvestments_Date_Marriage_Value7">Marriage Date Value?</label>
                                    <input id="Joint_StockInvestments_Date_Marriage_Value7" type="number" class="form-control 7_Joint_stocksinvestments_inputs" name="Joint_StockInvestments_Date_Marriage_Value7" value="0.00" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_StockInvestments_Current_Value7">Current Value?</label>
                                    <input id="Joint_StockInvestments_Current_Value7" type="number" class="form-control 7_Joint_stocksinvestments_inputs" name="Joint_StockInvestments_Current_Value7" value="0.00" min="0.00" step="0.01" max="999999.99" onchange="getJointCurrentValue(this, '7', 'Joint');" onkeyup="getJointCurrentValue(this, '7', 'Joint');"> 
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label for="Joint_StockInvestments_Percent_Marital_Equity7">N/A, calculated = Joint_StockInvestments_Institution_Current_Value7</label>
                                    <input id="Joint_StockInvestments_Percent_Marital_Equity7" type="number" class="form-control 7_Joint_stocksinvestments_inputs" name="Joint_StockInvestments_Percent_Marital_Equity7" value="" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_StockInvestments_Yearly_Interest_Dividend7">Yearly Interest and Dividends from this account?</label>
                                    <input id="Joint_StockInvestments_Yearly_Interest_Dividend7" type="number" class="form-control 7_Joint_stocksinvestments_inputs" name="Joint_StockInvestments_Yearly_Interest_Dividend7" value="0.00" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Does either party claim a sole/separate interest from the other on this account?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Joint_StockInvestments_SoleSeparate_Claim7_Yes" name="Joint_StockInvestments_SoleSeparate_Claim7" value="Yes" onchange="getPartyClaimSoleSeparate(this, '7', 'Joint');"> Yes</label>
                                        <label><input type="radio" id="Joint_StockInvestments_SoleSeparate_Claim7_No" name="Joint_StockInvestments_SoleSeparate_Claim7" value="No" checked="" onchange="getPartyClaimSoleSeparate(this, '7', 'Joint');"> No</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6" id="Joint_StockInvestments_SoleSeparate_Party7_Div" style="display: none;">
                                    <label>Who claims to own this account?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Joint_StockInvestments_SoleSeparate_Party7_Client" name="Joint_StockInvestments_SoleSeparate_Party7" value="{{$client_name}}"> {{$client_name}}</label>
                                        <label><input type="radio" id="Joint_StockInvestments_SoleSeparate_Party7_Op" name="Joint_StockInvestments_SoleSeparate_Party7" value="{{$opponent_name}}" checked=""> {{$opponent_name}}</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 left-clear" id="Joint_StockInvestments_SoleSeparate_Grounds7_Div" style="display: none; clear: left;">
                                    <label for="Joint_StockInvestments_SoleSeparate_Grounds7">Why does this person own this account solely and separately?</label>
                                    <input id="Joint_StockInvestments_SoleSeparate_Grounds7" type="text" class="form-control 7_Joint_stocksinvestments_inputs" name="Joint_StockInvestments_SoleSeparate_Grounds7" value=""> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>How will this account value be distributed between the parties?</label>
                                    <div class="w-100 dataInput">
                                        <label><input type="radio" id="Joint_StockInvestments_Disposition_Method7_Distribute Investments" name="Joint_StockInvestments_Disposition_Method7" value="Distribute Investments" onchange="getDipositionMethod(this, '7', 'Joint');"> Distribute Investments</label>
                                        <label><input type="radio" id="Joint_StockInvestments_Disposition_Method7_Liquidate/Split Net Value" name="Joint_StockInvestments_Disposition_Method7" value="Liquidate/Split Net Value" onchange="getDipositionMethod(this, '7', 'Joint');"> Liquidate/Split Net Value</label>
                                        <label><input type="radio" id="Joint_StockInvestments_Disposition_Method7_Percentage Buyout" name="Joint_StockInvestments_Disposition_Method7" value="Percentage Buyout" onchange="getDipositionMethod(this, '7', 'Joint');"> Percentage Buyout</label>
                                        <label><input type="radio" id="Joint_StockInvestments_Disposition_Method7_Fixed Buyout" name="Joint_StockInvestments_Disposition_Method7" value="Fixed Buyout" onchange="getDipositionMethod(this, '7', 'Joint');"> Fixed Buyout</label>
                                    </div>
                                </div>
                                <!-- slider tool -->
                                <div class="form-group col-sm-6 m-auto 7_Joint_Slider_Tool slider-tool-main">
                                    <div class="row">
                                        <div class="col">{{$client_name}}</div>
                                        <div class="col text-right">{{$opponent_name}}</div>
                                    </div>
                                    <input id="7_Joint_balance_range_selector" type="range" class="form-control slider-tool-input 7_Joint_balance_range_selector" name="" value="50.00" min="0.00" step="0.01" max="100" onchange="updateBalanceInput(this.value, '7', 'Joint');">
                                </div>
                                <div class="form-group col-sm-6 m-auto 7_Joint_Slider_Tool slider-tool-main">
                                    <div class="row justify-content-between">
                                        <div class="col selectorTool">
                                            <div class="left-col">
                                                <div class="client-info 7_Joint_clientpercentage_div clientpercentage_div">
                                                    50.00%
                                                </div>
                                                <div class="client-info 7_Joint_clientamount_div clientamount_div" style="clear: both;">
                                                    $0
                                                </div>
                                            </div>
                                            <label>To {{$client_name}}</label>
                                        </div>                                       
                                        <div class="col selectorTool selectorToolRight">
                                            <label>To {{$opponent_name}}</label>
                                            <div class="left-col right-col">
                                                <div class="client-info 7_Joint_opponentpercentage_div opponentpercentage_div">
                                                    50.00%
                                                </div>
                                                <div class="client-info 7_Joint_opponentamount_div opponentamount_div" style="clear: both;">
                                                    $0
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 m-auto 7_Joint_Slider_Tool slider-tool-main">
                                    <label></label>
                                    <div class="w-100">
                                        <label><input type="radio" id="7_Joint_StockInvestments_Estimated_Value_Select" name="7_Joint_StockInvestments_Estimated_Value_Select_Reset" class="StockInvestments_Estimated_Value_Select_Reset" value="Save"> Save this Distribution of StockInvestment Account #7</label>
                                        <label><input type="radio" id="7_Joint_StockInvestments_Estimated_Value_Reset" name="7_Joint_StockInvestments_Estimated_Value_Select_Reset" class="StockInvestments_Estimated_Value_Select_Reset" value="Reset" onclick="resetBalanceInput(this, '7', 'Joint');"> Reset to Default (50%)</label>
                                    </div>
                                </div>

                                <div class="form-group col-sm-6 Joint_StockInvestments_Paying_Party7_Inputs_Div" style="display: none;">
                                    <label>Joint StockInvestments Paying Party7</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Joint_StockInvestments_Paying_Party7_Client" name="Joint_StockInvestments_Paying_Party7" value="{{$client_name}}" onchange="getStockInvestmentPayingParty(this, '7', 'Joint');"> {{$client_name}}</label>
                                        <label><input type="radio" id="Joint_StockInvestments_Paying_Party7_Op" name="Joint_StockInvestments_Paying_Party7" value="{{$opponent_name}}" onchange="getStockInvestmentPayingParty(this, '7', 'Joint');"> {{$opponent_name}}</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 Joint_StockInvestments_Paying_Party7_Inputs_Div" style="display: none;">
                                    <label>{{$client_name}} StockInvestment Equity Percent</label>
                                    <input id="Joint_StockInvestments_Percent_Marital_Equity_to_Client7" type="number" class="form-control 7_Joint_clientpercentage_input clientpercentage_input" name="Joint_StockInvestments_Percent_Marital_Equity_to_Client7" value="50.00" min="0.00" step="0.01" max="100" readonly="">
                                </div>
                                <div class="form-group col-sm-6 Joint_StockInvestments_Paying_Party7_Inputs_Div" style="display: none;">
                                    <label>How much is to be paid to {{$client_name}}?</label>
                                    <input id="Joint_StockInvestments_Estimated_Value_to_Client7" type="number" class="form-control 7_Joint_clientamount_input clientamount_input" name="Joint_StockInvestments_Estimated_Value_to_Client7" value="" min="0.00" step="0.01" max="999999.99" readonly="" onchange="getEstimatedValueClient(this, '7', 'Joint');" onkeyup="getEstimatedValueClient(this, '7', 'Joint');">
                                </div>
                                <div class="form-group col-sm-6 Joint_StockInvestments_Paying_Party7_Inputs_Div" style="display: none;">
                                    <label>{{$opponent_name}} StockInvestment Equity Percent</label>
                                    <input id="Joint_StockInvestments_Percent_Marital_Equity_to_Op7" type="number" class="form-control 7_Joint_opponentpercentage_input opponentpercentage_input" name="Joint_StockInvestments_Percent_Marital_Equity_to_Op7" value="50.00" min="0.00" step="0.01" max="100" readonly="">
                                </div>
                                <div class="form-group col-sm-6 Joint_StockInvestments_Paying_Party7_Inputs_Div" style="display: none;">
                                    <label>How much is to be paid to {{$opponent_name}}?</label>
                                    <input id="Joint_StockInvestments_Estimated_Value_to_Op7" type="number" class="form-control 7_Joint_opponentamount_input opponentamount_input" name="Joint_StockInvestments_Estimated_Value_to_Op7" value="" min="0.00" step="0.01" max="999999.99" readonly="" onchange="getEstimatedValueOp(this, '7', 'Joint');" onkeyup="getEstimatedValueOp(this, '7', 'Joint');">
                                </div>
                                <!-- end of slider tool -->
                            </div>
                            <div class="col-sm-12 mt-4 8_Joint_stocksinvestments_section" style="display: none;"><h5 class="col-sm-12">Eighth Stock Investment Info</h5>
                                <div class="form-group col-sm-6">
                                    <p class="text-danger 8_Joint_no-state-county-found" style="display: none;">No City, State, County found for this zipcode.</p>
                                    <label for="Joint_StockInvestments_Institution_ZIP8">Stock/Investment Institution Zip Code?</label>
                                    <input id="Joint_StockInvestments_Institution_ZIP8" type="text" class="form-control 8_Joint_stocksinvestments_inputs" name="Joint_StockInvestments_Institution_ZIP8" value="" onkeyup="getCityStateForZip(this, '8_Joint');"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_StockInvestments_Institution_Name8">Name of Stock/Investment Institution?</label>
                                    <input id="Joint_StockInvestments_Institution_Name8" type="text" class="form-control 8_Joint_stocksinvestments_inputs" name="Joint_StockInvestments_Institution_Name8" value=""> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_StockInvestments_Institution_Street_Address8">Stock/Investment Institution Street Address?</label>
                                    <input id="Joint_StockInvestments_Institution_Street_Address8" type="text" class="form-control 8_Joint_stocksinvestments_inputs" name="Joint_StockInvestments_Institution_Street_Address8" value=""> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_StockInvestments_Institution_City8">Stock/Investment Institution City?</label>
                                    <select id="Joint_StockInvestments_Institution_City8" name="Joint_StockInvestments_Institution_City8" class="form-control 8_Joint_city_select">
                                        <option value="">Choose City</option>
                                    </select>   
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_StockInvestments_Institution_State8">Stock/Investment Institution State?</label>
                                    <select id="Joint_StockInvestments_Institution_State8" name="Joint_StockInvestments_Institution_State8" class="form-control 8_Joint_state_select">
                                        <option value="">Choose State</option>
                                    </select>   
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_StockInvestments_Acct_Num8">Account Number?</label>
                                    <input id="Joint_StockInvestments_Acct_Num8" type="text" class="form-control 8_Joint_stocksinvestments_inputs" name="Joint_StockInvestments_Acct_Num8" value=""> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_StockInvestments_Date_Marriage_Value8">Marriage Date Value?</label>
                                    <input id="Joint_StockInvestments_Date_Marriage_Value8" type="number" class="form-control 8_Joint_stocksinvestments_inputs" name="Joint_StockInvestments_Date_Marriage_Value8" value="0.00" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_StockInvestments_Current_Value8">Current Value?</label>
                                    <input id="Joint_StockInvestments_Current_Value8" type="number" class="form-control 8_Joint_stocksinvestments_inputs" name="Joint_StockInvestments_Current_Value8" value="0.00" min="0.00" step="0.01" max="999999.99" onchange="getJointCurrentValue(this, '8', 'Joint');" onkeyup="getJointCurrentValue(this, '8', 'Joint');"> 
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label for="Joint_StockInvestments_Percent_Marital_Equity8">N/A, calculated = Joint_StockInvestments_Institution_Current_Value8</label>
                                    <input id="Joint_StockInvestments_Percent_Marital_Equity8" type="number" class="form-control 8_Joint_stocksinvestments_inputs" name="Joint_StockInvestments_Percent_Marital_Equity8" value="" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_StockInvestments_Yearly_Interest_Dividend8">Yearly Interest and Dividends from this account?</label>
                                    <input id="Joint_StockInvestments_Yearly_Interest_Dividend8" type="number" class="form-control 8_Joint_stocksinvestments_inputs" name="Joint_StockInvestments_Yearly_Interest_Dividend8" value="0.00" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Does either party claim a sole/separate interest from the other on this account?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Joint_StockInvestments_SoleSeparate_Claim8_Yes" name="Joint_StockInvestments_SoleSeparate_Claim8" value="Yes" onchange="getPartyClaimSoleSeparate(this, '8', 'Joint');"> Yes</label>
                                        <label><input type="radio" id="Joint_StockInvestments_SoleSeparate_Claim8_No" name="Joint_StockInvestments_SoleSeparate_Claim8" value="No" checked="" onchange="getPartyClaimSoleSeparate(this, '8', 'Joint');"> No</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6" id="Joint_StockInvestments_SoleSeparate_Party8_Div" style="display: none;">
                                    <label>Who claims to own this account?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Joint_StockInvestments_SoleSeparate_Party8_Client" name="Joint_StockInvestments_SoleSeparate_Party8" value="{{$client_name}}"> {{$client_name}}</label>
                                        <label><input type="radio" id="Joint_StockInvestments_SoleSeparate_Party8_Op" name="Joint_StockInvestments_SoleSeparate_Party8" value="{{$opponent_name}}" checked=""> {{$opponent_name}}</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 left-clear" id="Joint_StockInvestments_SoleSeparate_Grounds8_Div" style="display: none; clear: left;">
                                    <label for="Joint_StockInvestments_SoleSeparate_Grounds8">Why does this person own this account solely and separately?</label>
                                    <input id="Joint_StockInvestments_SoleSeparate_Grounds8" type="text" class="form-control 8_Joint_stocksinvestments_inputs" name="Joint_StockInvestments_SoleSeparate_Grounds8" value=""> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>How will this account value be distributed between the parties?</label>
                                    <div class="w-100 dataInput">
                                        <label><input type="radio" id="Joint_StockInvestments_Disposition_Method8_Distribute Investments" name="Joint_StockInvestments_Disposition_Method8" value="Distribute Investments" onchange="getDipositionMethod(this, '8', 'Joint');"> Distribute Investments</label>
                                        <label><input type="radio" id="Joint_StockInvestments_Disposition_Method8_Liquidate/Split Net Value" name="Joint_StockInvestments_Disposition_Method8" value="Liquidate/Split Net Value" onchange="getDipositionMethod(this, '8', 'Joint');"> Liquidate/Split Net Value</label>
                                        <label><input type="radio" id="Joint_StockInvestments_Disposition_Method8_Percentage Buyout" name="Joint_StockInvestments_Disposition_Method8" value="Percentage Buyout" onchange="getDipositionMethod(this, '8', 'Joint');"> Percentage Buyout</label>
                                        <label><input type="radio" id="Joint_StockInvestments_Disposition_Method8_Fixed Buyout" name="Joint_StockInvestments_Disposition_Method8" value="Fixed Buyout" onchange="getDipositionMethod(this, '8', 'Joint');"> Fixed Buyout</label>
                                    </div>
                                </div>
                                <!-- slider tool -->
                                <div class="form-group col-sm-6 m-auto 8_Joint_Slider_Tool slider-tool-main">
                                    <div class="row">
                                        <div class="col">{{$client_name}}</div>
                                        <div class="col text-right">{{$opponent_name}}</div>
                                    </div>
                                    <input id="8_Joint_balance_range_selector" type="range" class="form-control slider-tool-input 8_Joint_balance_range_selector" name="" value="50.00" min="0.00" step="0.01" max="100" onchange="updateBalanceInput(this.value, '8', 'Joint');">
                                </div>
                                <div class="form-group col-sm-6 m-auto 8_Joint_Slider_Tool slider-tool-main">
                                    <div class="row justify-content-between">
                                        <div class="col selectorTool">
                                            <div class="left-col">
                                                <div class="client-info 8_Joint_clientpercentage_div clientpercentage_div">
                                                    50.00%
                                                </div>
                                                <div class="client-info 8_Joint_clientamount_div clientamount_div" style="clear: both;">
                                                    $0
                                                </div>
                                            </div>
                                            <label>To {{$client_name}}</label>
                                        </div>                                       
                                        <div class="col selectorTool selectorToolRight">
                                            <label>To {{$opponent_name}}</label>
                                            <div class="left-col right-col">
                                                <div class="client-info 8_Joint_opponentpercentage_div opponentpercentage_div">
                                                    50.00%
                                                </div>
                                                <div class="client-info 8_Joint_opponentamount_div opponentamount_div" style="clear: both;">
                                                    $0
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 m-auto 8_Joint_Slider_Tool slider-tool-main">
                                    <label></label>
                                    <div class="w-100">
                                        <label><input type="radio" id="8_Joint_StockInvestments_Estimated_Value_Select" name="8_Joint_StockInvestments_Estimated_Value_Select_Reset" class="StockInvestments_Estimated_Value_Select_Reset" value="Save"> Save this Distribution of StockInvestment Account #8</label>
                                        <label><input type="radio" id="8_Joint_StockInvestments_Estimated_Value_Reset" name="8_Joint_StockInvestments_Estimated_Value_Select_Reset" class="StockInvestments_Estimated_Value_Select_Reset" value="Reset" onclick="resetBalanceInput(this, '8', 'Joint');"> Reset to Default (50%)</label>
                                    </div>
                                </div>

                                <div class="form-group col-sm-6 Joint_StockInvestments_Paying_Party8_Inputs_Div" style="display: none;">
                                    <label>Joint StockInvestments Paying Party8</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Joint_StockInvestments_Paying_Party8_Client" name="Joint_StockInvestments_Paying_Party8" value="{{$client_name}}" onchange="getStockInvestmentPayingParty(this, '8', 'Joint');"> {{$client_name}}</label>
                                        <label><input type="radio" id="Joint_StockInvestments_Paying_Party8_Op" name="Joint_StockInvestments_Paying_Party8" value="{{$opponent_name}}" onchange="getStockInvestmentPayingParty(this, '8', 'Joint');"> {{$opponent_name}}</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 Joint_StockInvestments_Paying_Party8_Inputs_Div" style="display: none;">
                                    <label>{{$client_name}} StockInvestment Equity Percent</label>
                                    <input id="Joint_StockInvestments_Percent_Marital_Equity_to_Client8" type="number" class="form-control 8_Joint_clientpercentage_input clientpercentage_input" name="Joint_StockInvestments_Percent_Marital_Equity_to_Client8" value="50.00" min="0.00" step="0.01" max="100" readonly="">
                                </div>
                                <div class="form-group col-sm-6 Joint_StockInvestments_Paying_Party8_Inputs_Div" style="display: none;">
                                    <label>How much is to be paid to {{$client_name}}?</label>
                                    <input id="Joint_StockInvestments_Estimated_Value_to_Client8" type="number" class="form-control 8_Joint_clientamount_input clientamount_input" name="Joint_StockInvestments_Estimated_Value_to_Client8" value="" min="0.00" step="0.01" max="999999.99" readonly="" onchange="getEstimatedValueClient(this, '8', 'Joint');" onkeyup="getEstimatedValueClient(this, '8', 'Joint');">
                                </div>
                                <div class="form-group col-sm-6 Joint_StockInvestments_Paying_Party8_Inputs_Div" style="display: none;">
                                    <label>{{$opponent_name}} StockInvestment Equity Percent</label>
                                    <input id="Joint_StockInvestments_Percent_Marital_Equity_to_Op8" type="number" class="form-control 8_Joint_opponentpercentage_input opponentpercentage_input" name="Joint_StockInvestments_Percent_Marital_Equity_to_Op8" value="50.00" min="0.00" step="0.01" max="100" readonly="">
                                </div>
                                <div class="form-group col-sm-6 Joint_StockInvestments_Paying_Party8_Inputs_Div" style="display: none;">
                                    <label>How much is to be paid to {{$opponent_name}}?</label>
                                    <input id="Joint_StockInvestments_Estimated_Value_to_Op8" type="number" class="form-control 8_Joint_opponentamount_input opponentamount_input" name="Joint_StockInvestments_Estimated_Value_to_Op8" value="" min="0.00" step="0.01" max="999999.99" readonly="" onchange="getEstimatedValueOp(this, '8', 'Joint');" onkeyup="getEstimatedValueOp(this, '8', 'Joint');">
                                </div>
                                <!-- end of slider tool -->
                            </div>
                            <div class="col-sm-12 mt-4 9_Joint_stocksinvestments_section" style="display: none;"><h5 class="col-sm-12">Nineth Stock Investment Info</h5>
                                <div class="form-group col-sm-6">
                                    <p class="text-danger 9_Joint_no-state-county-found" style="display: none;">No City, State, County found for this zipcode.</p>
                                    <label for="Joint_StockInvestments_Institution_ZIP9">Stock/Investment Institution Zip Code?</label>
                                    <input id="Joint_StockInvestments_Institution_ZIP9" type="text" class="form-control 9_Joint_stocksinvestments_inputs" name="Joint_StockInvestments_Institution_ZIP9" value="" onkeyup="getCityStateForZip(this, '9_Joint');"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_StockInvestments_Institution_Name9">Name of Stock/Investment Institution?</label>
                                    <input id="Joint_StockInvestments_Institution_Name9" type="text" class="form-control 9_Joint_stocksinvestments_inputs" name="Joint_StockInvestments_Institution_Name9" value=""> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_StockInvestments_Institution_Street_Address9">Stock/Investment Institution Street Address?</label>
                                    <input id="Joint_StockInvestments_Institution_Street_Address9" type="text" class="form-control 9_Joint_stocksinvestments_inputs" name="Joint_StockInvestments_Institution_Street_Address9" value=""> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_StockInvestments_Institution_City9">Stock/Investment Institution City?</label>
                                    <select id="Joint_StockInvestments_Institution_City9" name="Joint_StockInvestments_Institution_City9" class="form-control 9_Joint_city_select">
                                        <option value="">Choose City</option>
                                    </select>   
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_StockInvestments_Institution_State9">Stock/Investment Institution State?</label>
                                    <select id="Joint_StockInvestments_Institution_State9" name="Joint_StockInvestments_Institution_State9" class="form-control 9_Joint_state_select">
                                        <option value="">Choose State</option>
                                    </select>   
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_StockInvestments_Acct_Num9">Account Number?</label>
                                    <input id="Joint_StockInvestments_Acct_Num9" type="text" class="form-control 9_Joint_stocksinvestments_inputs" name="Joint_StockInvestments_Acct_Num9" value=""> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_StockInvestments_Date_Marriage_Value9">Marriage Date Value?</label>
                                    <input id="Joint_StockInvestments_Date_Marriage_Value9" type="number" class="form-control 9_Joint_stocksinvestments_inputs" name="Joint_StockInvestments_Date_Marriage_Value9" value="0.00" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_StockInvestments_Current_Value9">Current Value?</label>
                                    <input id="Joint_StockInvestments_Current_Value9" type="number" class="form-control 9_Joint_stocksinvestments_inputs" name="Joint_StockInvestments_Current_Value9" value="0.00" min="0.00" step="0.01" max="999999.99" onchange="getJointCurrentValue(this, '9', 'Joint');" onkeyup="getJointCurrentValue(this, '9', 'Joint');"> 
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label for="Joint_StockInvestments_Percent_Marital_Equity9">N/A, calculated = Joint_StockInvestments_Institution_Current_Value9</label>
                                    <input id="Joint_StockInvestments_Percent_Marital_Equity9" type="number" class="form-control 9_Joint_stocksinvestments_inputs" name="Joint_StockInvestments_Percent_Marital_Equity9" value="" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_StockInvestments_Yearly_Interest_Dividend9">Yearly Interest and Dividends from this account?</label>
                                    <input id="Joint_StockInvestments_Yearly_Interest_Dividend9" type="number" class="form-control 9_Joint_stocksinvestments_inputs" name="Joint_StockInvestments_Yearly_Interest_Dividend9" value="0.00" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Does either party claim a sole/separate interest from the other on this account?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Joint_StockInvestments_SoleSeparate_Claim9_Yes" name="Joint_StockInvestments_SoleSeparate_Claim9" value="Yes" onchange="getPartyClaimSoleSeparate(this, '9', 'Joint');"> Yes</label>
                                        <label><input type="radio" id="Joint_StockInvestments_SoleSeparate_Claim9_No" name="Joint_StockInvestments_SoleSeparate_Claim9" value="No" checked="" onchange="getPartyClaimSoleSeparate(this, '9', 'Joint');"> No</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6" id="Joint_StockInvestments_SoleSeparate_Party9_Div" style="display: none;">
                                    <label>Who claims to own this account?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Joint_StockInvestments_SoleSeparate_Party9_Client" name="Joint_StockInvestments_SoleSeparate_Party9" value="{{$client_name}}"> {{$client_name}}</label>
                                        <label><input type="radio" id="Joint_StockInvestments_SoleSeparate_Party9_Op" name="Joint_StockInvestments_SoleSeparate_Party9" value="{{$opponent_name}}" checked=""> {{$opponent_name}}</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 left-clear" id="Joint_StockInvestments_SoleSeparate_Grounds9_Div" style="display: none; clear: left;">
                                    <label for="Joint_StockInvestments_SoleSeparate_Grounds9">Why does this person own this account solely and separately?</label>
                                    <input id="Joint_StockInvestments_SoleSeparate_Grounds9" type="text" class="form-control 9_Joint_stocksinvestments_inputs" name="Joint_StockInvestments_SoleSeparate_Grounds9" value=""> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>How will this account value be distributed between the parties?</label>
                                    <div class="w-100 dataInput">
                                        <label><input type="radio" id="Joint_StockInvestments_Disposition_Method9_Distribute Investments" name="Joint_StockInvestments_Disposition_Method9" value="Distribute Investments" onchange="getDipositionMethod(this, '9', 'Joint');"> Distribute Investments</label>
                                        <label><input type="radio" id="Joint_StockInvestments_Disposition_Method9_Liquidate/Split Net Value" name="Joint_StockInvestments_Disposition_Method9" value="Liquidate/Split Net Value" onchange="getDipositionMethod(this, '9', 'Joint');"> Liquidate/Split Net Value</label>
                                        <label><input type="radio" id="Joint_StockInvestments_Disposition_Method9_Percentage Buyout" name="Joint_StockInvestments_Disposition_Method9" value="Percentage Buyout" onchange="getDipositionMethod(this, '9', 'Joint');"> Percentage Buyout</label>
                                        <label><input type="radio" id="Joint_StockInvestments_Disposition_Method9_Fixed Buyout" name="Joint_StockInvestments_Disposition_Method9" value="Fixed Buyout" onchange="getDipositionMethod(this, '9', 'Joint');"> Fixed Buyout</label>
                                    </div>
                                </div>
                                <!-- slider tool -->
                                <div class="form-group col-sm-6 m-auto 9_Joint_Slider_Tool slider-tool-main">
                                    <div class="row">
                                        <div class="col">{{$client_name}}</div>
                                        <div class="col text-right">{{$opponent_name}}</div>
                                    </div>
                                    <input id="9_Joint_balance_range_selector" type="range" class="form-control slider-tool-input 9_Joint_balance_range_selector" name="" value="50.00" min="0.00" step="0.01" max="100" onchange="updateBalanceInput(this.value, '9', 'Joint');">
                                </div>
                                <div class="form-group col-sm-6 m-auto 9_Joint_Slider_Tool slider-tool-main">
                                    <div class="row justify-content-between">
                                        <div class="col selectorTool">
                                            <div class="left-col">
                                                <div class="client-info 9_Joint_clientpercentage_div clientpercentage_div">
                                                    50.00%
                                                </div>
                                                <div class="client-info 9_Joint_clientamount_div clientamount_div" style="clear: both;">
                                                    $0
                                                </div>
                                            </div>
                                            <label>To {{$client_name}}</label>
                                        </div>                                       
                                        <div class="col selectorTool selectorToolRight">
                                            <label>To {{$opponent_name}}</label>
                                            <div class="left-col right-col">
                                                <div class="client-info 9_Joint_opponentpercentage_div opponentpercentage_div">
                                                    50.00%
                                                </div>
                                                <div class="client-info 9_Joint_opponentamount_div opponentamount_div" style="clear: both;">
                                                    $0
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 m-auto 9_Joint_Slider_Tool slider-tool-main">
                                    <label></label>
                                    <div class="w-100">
                                        <label><input type="radio" id="9_Joint_StockInvestments_Estimated_Value_Select" name="9_Joint_StockInvestments_Estimated_Value_Select_Reset" class="StockInvestments_Estimated_Value_Select_Reset" value="Save"> Save this Distribution of StockInvestment Account #9</label>
                                        <label><input type="radio" id="9_Joint_StockInvestments_Estimated_Value_Reset" name="9_Joint_StockInvestments_Estimated_Value_Select_Reset" class="StockInvestments_Estimated_Value_Select_Reset" value="Reset" onclick="resetBalanceInput(this, '9', 'Joint');"> Reset to Default (50%)</label>
                                    </div>
                                </div>

                                <div class="form-group col-sm-6 Joint_StockInvestments_Paying_Party9_Inputs_Div" style="display: none;">
                                    <label>Joint StockInvestments Paying Party9</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Joint_StockInvestments_Paying_Party9_Client" name="Joint_StockInvestments_Paying_Party9" value="{{$client_name}}" onchange="getStockInvestmentPayingParty(this, '9', 'Joint');"> {{$client_name}}</label>
                                        <label><input type="radio" id="Joint_StockInvestments_Paying_Party9_Op" name="Joint_StockInvestments_Paying_Party9" value="{{$opponent_name}}" onchange="getStockInvestmentPayingParty(this, '9', 'Joint');"> {{$opponent_name}}</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 Joint_StockInvestments_Paying_Party9_Inputs_Div" style="display: none;">
                                    <label>{{$client_name}} StockInvestment Equity Percent</label>
                                    <input id="Joint_StockInvestments_Percent_Marital_Equity_to_Client9" type="number" class="form-control 9_Joint_clientpercentage_input clientpercentage_input" name="Joint_StockInvestments_Percent_Marital_Equity_to_Client9" value="50.00" min="0.00" step="0.01" max="100" readonly="">
                                </div>
                                <div class="form-group col-sm-6 Joint_StockInvestments_Paying_Party9_Inputs_Div" style="display: none;">
                                    <label>How much is to be paid to {{$client_name}}?</label>
                                    <input id="Joint_StockInvestments_Estimated_Value_to_Client9" type="number" class="form-control 9_Joint_clientamount_input clientamount_input" name="Joint_StockInvestments_Estimated_Value_to_Client9" value="" min="0.00" step="0.01" max="999999.99" readonly="" onchange="getEstimatedValueClient(this, '9', 'Joint');" onkeyup="getEstimatedValueClient(this, '9', 'Joint');">
                                </div>
                                <div class="form-group col-sm-6 Joint_StockInvestments_Paying_Party9_Inputs_Div" style="display: none;">
                                    <label>{{$opponent_name}} StockInvestment Equity Percent</label>
                                    <input id="Joint_StockInvestments_Percent_Marital_Equity_to_Op9" type="number" class="form-control 9_Joint_opponentpercentage_input opponentpercentage_input" name="Joint_StockInvestments_Percent_Marital_Equity_to_Op9" value="50.00" min="0.00" step="0.01" max="100" readonly="">
                                </div>
                                <div class="form-group col-sm-6 Joint_StockInvestments_Paying_Party9_Inputs_Div" style="display: none;">
                                    <label>How much is to be paid to {{$opponent_name}}?</label>
                                    <input id="Joint_StockInvestments_Estimated_Value_to_Op9" type="number" class="form-control 9_Joint_opponentamount_input opponentamount_input" name="Joint_StockInvestments_Estimated_Value_to_Op9" value="" min="0.00" step="0.01" max="999999.99" readonly="" onchange="getEstimatedValueOp(this, '9', 'Joint');" onkeyup="getEstimatedValueOp(this, '9', 'Joint');">
                                </div>
                                <!-- end of slider tool -->
                            </div>
                            <div class="col-sm-12 mt-4 10_Joint_stocksinvestments_section" style="display: none;"><h5 class="col-sm-12">Tenth Stock Investment Info</h5>
                                <div class="form-group col-sm-6">
                                    <p class="text-danger 10_Joint_no-state-county-found" style="display: none;">No City, State, County found for this zipcode.</p>
                                    <label for="Joint_StockInvestments_Institution_ZIP10">Stock/Investment Institution Zip Code?</label>
                                    <input id="Joint_StockInvestments_Institution_ZIP10" type="text" class="form-control 10_Joint_stocksinvestments_inputs" name="Joint_StockInvestments_Institution_ZIP10" value="" onkeyup="getCityStateForZip(this, '10_Joint');"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_StockInvestments_Institution_Name10">Name of Stock/Investment Institution?</label>
                                    <input id="Joint_StockInvestments_Institution_Name10" type="text" class="form-control 10_Joint_stocksinvestments_inputs" name="Joint_StockInvestments_Institution_Name10" value=""> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_StockInvestments_Institution_Street_Address10">Stock/Investment Institution Street Address?</label>
                                    <input id="Joint_StockInvestments_Institution_Street_Address10" type="text" class="form-control 10_Joint_stocksinvestments_inputs" name="Joint_StockInvestments_Institution_Street_Address10" value=""> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_StockInvestments_Institution_City10">Stock/Investment Institution City?</label>
                                    <select id="Joint_StockInvestments_Institution_City10" name="Joint_StockInvestments_Institution_City10" class="form-control 10_Joint_city_select">
                                        <option value="">Choose City</option>
                                    </select>   
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_StockInvestments_Institution_State10">Stock/Investment Institution State?</label>
                                    <select id="Joint_StockInvestments_Institution_State10" name="Joint_StockInvestments_Institution_State10" class="form-control 10_Joint_state_select">
                                        <option value="">Choose State</option>
                                    </select>   
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_StockInvestments_Acct_Num10">Account Number?</label>
                                    <input id="Joint_StockInvestments_Acct_Num10" type="text" class="form-control 10_Joint_stocksinvestments_inputs" name="Joint_StockInvestments_Acct_Num10" value=""> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_StockInvestments_Date_Marriage_Value10">Marriage Date Value?</label>
                                    <input id="Joint_StockInvestments_Date_Marriage_Value10" type="number" class="form-control 10_Joint_stocksinvestments_inputs" name="Joint_StockInvestments_Date_Marriage_Value10" value="0.00" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_StockInvestments_Current_Value10">Current Value?</label>
                                    <input id="Joint_StockInvestments_Current_Value10" type="number" class="form-control 10_Joint_stocksinvestments_inputs" name="Joint_StockInvestments_Current_Value10" value="0.00" min="0.00" step="0.01" max="999999.99" onchange="getJointCurrentValue(this, '10', 'Joint');" onkeyup="getJointCurrentValue(this, '10', 'Joint');"> 
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label for="Joint_StockInvestments_Percent_Marital_Equity10">N/A, calculated = Joint_StockInvestments_Institution_Current_Value10</label>
                                    <input id="Joint_StockInvestments_Percent_Marital_Equity10" type="number" class="form-control 10_Joint_stocksinvestments_inputs" name="Joint_StockInvestments_Percent_Marital_Equity10" value="" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_StockInvestments_Yearly_Interest_Dividend10">Yearly Interest and Dividends from this account?</label>
                                    <input id="Joint_StockInvestments_Yearly_Interest_Dividend10" type="number" class="form-control 10_Joint_stocksinvestments_inputs" name="Joint_StockInvestments_Yearly_Interest_Dividend10" value="0.00" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Does either party claim a sole/separate interest from the other on this account?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Joint_StockInvestments_SoleSeparate_Claim10_Yes" name="Joint_StockInvestments_SoleSeparate_Claim10" value="Yes" onchange="getPartyClaimSoleSeparate(this, '10', 'Joint');"> Yes</label>
                                        <label><input type="radio" id="Joint_StockInvestments_SoleSeparate_Claim10_No" name="Joint_StockInvestments_SoleSeparate_Claim10" value="No" checked="" onchange="getPartyClaimSoleSeparate(this, '10', 'Joint');"> No</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6" id="Joint_StockInvestments_SoleSeparate_Party10_Div" style="display: none;">
                                    <label>Who claims to own this account?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Joint_StockInvestments_SoleSeparate_Party10_Client" name="Joint_StockInvestments_SoleSeparate_Party10" value="{{$client_name}}"> {{$client_name}}</label>
                                        <label><input type="radio" id="Joint_StockInvestments_SoleSeparate_Party10_Op" name="Joint_StockInvestments_SoleSeparate_Party10" value="{{$opponent_name}}" checked=""> {{$opponent_name}}</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 left-clear" id="Joint_StockInvestments_SoleSeparate_Grounds10_Div" style="display: none; clear: left;">
                                    <label for="Joint_StockInvestments_SoleSeparate_Grounds10">Why does this person own this account solely and separately?</label>
                                    <input id="Joint_StockInvestments_SoleSeparate_Grounds10" type="text" class="form-control 10_Joint_stocksinvestments_inputs" name="Joint_StockInvestments_SoleSeparate_Grounds10" value=""> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>How will this account value be distributed between the parties?</label>
                                    <div class="w-100 dataInput">
                                        <label><input type="radio" id="Joint_StockInvestments_Disposition_Method10_Distribute Investments" name="Joint_StockInvestments_Disposition_Method10" value="Distribute Investments" onchange="getDipositionMethod(this, '10', 'Joint');"> Distribute Investments</label>
                                        <label><input type="radio" id="Joint_StockInvestments_Disposition_Method10_Liquidate/Split Net Value" name="Joint_StockInvestments_Disposition_Method10" value="Liquidate/Split Net Value" onchange="getDipositionMethod(this, '10', 'Joint');"> Liquidate/Split Net Value</label>
                                        <label><input type="radio" id="Joint_StockInvestments_Disposition_Method10_Percentage Buyout" name="Joint_StockInvestments_Disposition_Method10" value="Percentage Buyout" onchange="getDipositionMethod(this, '10', 'Joint');"> Percentage Buyout</label>
                                        <label><input type="radio" id="Joint_StockInvestments_Disposition_Method10_Fixed Buyout" name="Joint_StockInvestments_Disposition_Method10" value="Fixed Buyout" onchange="getDipositionMethod(this, '10', 'Joint');"> Fixed Buyout</label>
                                    </div>
                                </div>
                                <!-- slider tool -->
                                <div class="form-group col-sm-6 m-auto 10_Joint_Slider_Tool slider-tool-main">
                                    <div class="row">
                                        <div class="col">{{$client_name}}</div>
                                        <div class="col text-right">{{$opponent_name}}</div>
                                    </div>
                                    <input id="10_Joint_balance_range_selector" type="range" class="form-control slider-tool-input 10_Joint_balance_range_selector" name="" value="50.00" min="0.00" step="0.01" max="100" onchange="updateBalanceInput(this.value, '10', 'Joint');">
                                </div>
                                <div class="form-group col-sm-6 m-auto 10_Joint_Slider_Tool slider-tool-main">
                                    <div class="row justify-content-between">
                                        <div class="col selectorTool">
                                            <div class="left-col">
                                                <div class="client-info 10_Joint_clientpercentage_div clientpercentage_div">
                                                    50.00%
                                                </div>
                                                <div class="client-info 10_Joint_clientamount_div clientamount_div" style="clear: both;">
                                                    $0
                                                </div>
                                            </div>
                                            <label>To {{$client_name}}</label>
                                        </div>                                       
                                        <div class="col selectorTool selectorToolRight">
                                            <label>To {{$opponent_name}}</label>
                                            <div class="left-col right-col">
                                                <div class="client-info 10_Joint_opponentpercentage_div opponentpercentage_div">
                                                    50.00%
                                                </div>
                                                <div class="client-info 10_Joint_opponentamount_div opponentamount_div" style="clear: both;">
                                                    $0
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 m-auto 10_Joint_Slider_Tool slider-tool-main">
                                    <label></label>
                                    <div class="w-100">
                                        <label><input type="radio" id="10_Joint_StockInvestments_Estimated_Value_Select" name="10_Joint_StockInvestments_Estimated_Value_Select_Reset" class="StockInvestments_Estimated_Value_Select_Reset" value="Save"> Save this Distribution of StockInvestment Account #10</label>
                                        <label><input type="radio" id="10_Joint_StockInvestments_Estimated_Value_Reset" name="10_Joint_StockInvestments_Estimated_Value_Select_Reset" class="StockInvestments_Estimated_Value_Select_Reset" value="Reset" onclick="resetBalanceInput(this, '10', 'Joint');"> Reset to Default (50%)</label>
                                    </div>
                                </div>

                                <div class="form-group col-sm-6 Joint_StockInvestments_Paying_Party10_Inputs_Div" style="display: none;">
                                    <label>Joint StockInvestments Paying Party10</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Joint_StockInvestments_Paying_Party10_Client" name="Joint_StockInvestments_Paying_Party10" value="{{$client_name}}" onchange="getStockInvestmentPayingParty(this, '10', 'Joint');"> {{$client_name}}</label>
                                        <label><input type="radio" id="Joint_StockInvestments_Paying_Party10_Op" name="Joint_StockInvestments_Paying_Party10" value="{{$opponent_name}}" onchange="getStockInvestmentPayingParty(this, '10', 'Joint');"> {{$opponent_name}}</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 Joint_StockInvestments_Paying_Party10_Inputs_Div" style="display: none;">
                                    <label>{{$client_name}} StockInvestment Equity Percent</label>
                                    <input id="Joint_StockInvestments_Percent_Marital_Equity_to_Client10" type="number" class="form-control 10_Joint_clientpercentage_input clientpercentage_input" name="Joint_StockInvestments_Percent_Marital_Equity_to_Client10" value="50.00" min="0.00" step="0.01" max="100" readonly="">
                                </div>
                                <div class="form-group col-sm-6 Joint_StockInvestments_Paying_Party10_Inputs_Div" style="display: none;">
                                    <label>How much is to be paid to {{$client_name}}?</label>
                                    <input id="Joint_StockInvestments_Estimated_Value_to_Client10" type="number" class="form-control 10_Joint_clientamount_input clientamount_input" name="Joint_StockInvestments_Estimated_Value_to_Client10" value="" min="0.00" step="0.01" max="999999.99" readonly="" onchange="getEstimatedValueClient(this, '10', 'Joint');" onkeyup="getEstimatedValueClient(this, '10', 'Joint');">
                                </div>
                                <div class="form-group col-sm-6 Joint_StockInvestments_Paying_Party10_Inputs_Div" style="display: none;">
                                    <label>{{$opponent_name}} StockInvestment Equity Percent</label>
                                    <input id="Joint_StockInvestments_Percent_Marital_Equity_to_Op10" type="number" class="form-control 10_Joint_opponentpercentage_input opponentpercentage_input" name="Joint_StockInvestments_Percent_Marital_Equity_to_Op10" value="50.00" min="0.00" step="0.01" max="100" readonly="">
                                </div>
                                <div class="form-group col-sm-6 Joint_StockInvestments_Paying_Party10_Inputs_Div" style="display: none;">
                                    <label>How much is to be paid to {{$opponent_name}}?</label>
                                    <input id="Joint_StockInvestments_Estimated_Value_to_Op10" type="number" class="form-control 10_Joint_opponentamount_input opponentamount_input" name="Joint_StockInvestments_Estimated_Value_to_Op10" value="" min="0.00" step="0.01" max="999999.99" readonly="" onchange="getEstimatedValueOp(this, '10', 'Joint');" onkeyup="getEstimatedValueOp(this, '10', 'Joint');">
                                </div>
                                <!-- end of slider tool -->
                            </div>
                        </div>
                        <!-- End of Joint Stocks Investments Info Section -->

                        <!-- Client Stocks Investments Info Section -->
                        <div class="form-row num_Client_stocksinvestments_info mt-4" style="display: none;">
                            <h4 class="col-sm-12">{{$client_name}} Stocks Investments Info Section</h4>
                            <div class="col-sm-6">
                                <label for="Num_Client_StockInvestments_Accounts">How many deposit accounts in {{$client_name}}’s name only?</label>
                                <input id="Num_Client_StockInvestments_Accounts" type="number" class="form-control" name="Num_Client_StockInvestments_Accounts" value="<?php if(isset($drcaseoverview->Num_Client_StockInvestments_Accounts)){ echo $drcaseoverview->Num_Client_StockInvestments_Accounts; } ?>" min="0" max="10"> 
                            </div>
                        </div>
                        <div class="form-row Client_stocksinvestments_section">
                            <div class="col-sm-12 mt-4 1_Client_stocksinvestments_section" style="display: none;"><h5 class="col-sm-12">First Stock Investment Info</h5>
                                <div class="form-group col-sm-6">
                                    <p class="text-danger 1_Client_no-state-county-found" style="display: none;">No City, State, County found for this zipcode.</p>
                                    <label for="Client_StockInvestments_Institution_ZIP1">Stock/Investment Institution Zip Code?</label>
                                    <input id="Client_StockInvestments_Institution_ZIP1" type="text" class="form-control 1_Client_stocksinvestments_inputs" name="Client_StockInvestments_Institution_ZIP1" value="" onkeyup="getCityStateForZip(this, '1_Client');"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_StockInvestments_Institution_Name1">Name of Stock/Investment Institution?</label>
                                    <input id="Client_StockInvestments_Institution_Name1" type="text" class="form-control 1_Client_stocksinvestments_inputs" name="Client_StockInvestments_Institution_Name1" value=""> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_StockInvestments_Institution_Street_Address1">Stock/Investment Institution Street Address?</label>
                                    <input id="Client_StockInvestments_Institution_Street_Address1" type="text" class="form-control 1_Client_stocksinvestments_inputs" name="Client_StockInvestments_Institution_Street_Address1" value=""> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_StockInvestments_Institution_City1">Stock/Investment Institution City?</label>
                                    <select id="Client_StockInvestments_Institution_City1" name="Client_StockInvestments_Institution_City1" class="form-control 1_Client_city_select">
                                        <option value="">Choose City</option>
                                    </select>   
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_StockInvestments_Institution_State1">Stock/Investment Institution State?</label>
                                    <select id="Client_StockInvestments_Institution_State1" name="Client_StockInvestments_Institution_State1" class="form-control 1_Client_state_select">
                                        <option value="">Choose State</option>
                                    </select>   
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_StockInvestments_Acct_Num1">Account Number?</label>
                                    <input id="Client_StockInvestments_Acct_Num1" type="text" class="form-control 1_Client_stocksinvestments_inputs" name="Client_StockInvestments_Acct_Num1" value=""> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_StockInvestments_Date_Marriage_Value1">Marriage Date Value?</label>
                                    <input id="Client_StockInvestments_Date_Marriage_Value1" type="number" class="form-control 1_Client_stocksinvestments_inputs" name="Client_StockInvestments_Date_Marriage_Value1" value="0.00" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_StockInvestments_Current_Value1">Current Value?</label>
                                    <input id="Client_StockInvestments_Current_Value1" type="number" class="form-control 1_Client_stocksinvestments_inputs" name="Client_StockInvestments_Current_Value1" value="0.00" min="0.00" step="0.01" max="999999.99" onchange="getJointCurrentValue(this, '1', 'Client');" onkeyup="getJointCurrentValue(this, '1', 'Client');"> 
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label for="Client_StockInvestments_Percent_Marital_Equity1">N/A, calculated = Client_StockInvestments_Institution_Current_Value1</label>
                                    <input id="Client_StockInvestments_Percent_Marital_Equity1" type="number" class="form-control 1_Client_stocksinvestments_inputs" name="Client_StockInvestments_Percent_Marital_Equity1" value="" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_StockInvestments_Yearly_Interest_Dividend1">Yearly Interest and Dividends from this account?</label>
                                    <input id="Client_StockInvestments_Yearly_Interest_Dividend1" type="number" class="form-control 1_Client_stocksinvestments_inputs" name="Client_StockInvestments_Yearly_Interest_Dividend1" value="0.00" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Does either party claim a sole/separate interest from the other on this account?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Client_StockInvestments_SoleSeparate_Claim1_Yes" name="Client_StockInvestments_SoleSeparate_Claim1" value="Yes" onchange="getPartyClaimSoleSeparate(this, '1', 'Client');"> Yes</label>
                                        <label><input type="radio" id="Client_StockInvestments_SoleSeparate_Claim1_No" name="Client_StockInvestments_SoleSeparate_Claim1" value="No" checked="" onchange="getPartyClaimSoleSeparate(this, '1', 'Client');"> No</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6" id="Client_StockInvestments_SoleSeparate_Party1_Div" style="display: none;">
                                    <label>Who claims to own this account?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Client_StockInvestments_SoleSeparate_Party1_Client" name="Client_StockInvestments_SoleSeparate_Party1" value="{{$client_name}}"> {{$client_name}}</label>
                                        <label><input type="radio" id="Client_StockInvestments_SoleSeparate_Party1_Op" name="Client_StockInvestments_SoleSeparate_Party1" value="{{$opponent_name}}" checked=""> {{$opponent_name}}</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 left-clear" id="Client_StockInvestments_SoleSeparate_Grounds1_Div" style="display: none; clear: left;">
                                    <label for="Client_StockInvestments_SoleSeparate_Grounds1">Why does this person own this account solely and separately?</label>
                                    <input id="Client_StockInvestments_SoleSeparate_Grounds1" type="text" class="form-control 1_Client_stocksinvestments_inputs" name="Client_StockInvestments_SoleSeparate_Grounds1" value=""> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>How will this account value be distributed between the parties?</label>
                                    <div class="w-100 dataInput">
                                        <label><input type="radio" id="Client_StockInvestments_Disposition_Method1_Distribute Investments" name="Client_StockInvestments_Disposition_Method1" value="Distribute Investments" onchange="getDipositionMethod(this, '1', 'Client');"> Distribute Investments</label>
                                        <label><input type="radio" id="Client_StockInvestments_Disposition_Method1_Liquidate/Split Net Value" name="Client_StockInvestments_Disposition_Method1" value="Liquidate/Split Net Value" onchange="getDipositionMethod(this, '1', 'Client');"> Liquidate/Split Net Value</label>
                                        <label><input type="radio" id="Client_StockInvestments_Disposition_Method1_Percentage Buyout" name="Client_StockInvestments_Disposition_Method1" value="Percentage Buyout" onchange="getDipositionMethod(this, '1', 'Client');"> Percentage Buyout</label>
                                        <label><input type="radio" id="Client_StockInvestments_Disposition_Method1_Fixed Buyout" name="Client_StockInvestments_Disposition_Method1" value="Fixed Buyout" onchange="getDipositionMethod(this, '1', 'Client');"> Fixed Buyout</label>
                                    </div>
                                </div>
                                <!-- slider tool -->
                                <div class="form-group col-sm-6 m-auto 1_Client_Slider_Tool slider-tool-main">
                                    <div class="row">
                                        <div class="col">{{$client_name}}</div>
                                        <div class="col text-right">{{$opponent_name}}</div>
                                    </div>
                                    <input id="1_Client_balance_range_selector" type="range" class="form-control slider-tool-input 1_Client_balance_range_selector" name="" value="50.00" min="0.00" step="0.01" max="100" onchange="updateBalanceInput(this.value, '1', 'Client');">
                                </div>
                                <div class="form-group col-sm-6 m-auto 1_Client_Slider_Tool slider-tool-main">
                                    <div class="row justify-content-between">
                                        <div class="col selectorTool">
                                            <div class="left-col">
                                                <div class="client-info 1_Client_clientpercentage_div clientpercentage_div">
                                                    50.00%
                                                </div>
                                                <div class="client-info 1_Client_clientamount_div clientamount_div" style="clear: both;">
                                                    $0
                                                </div>
                                            </div>
                                            <label>To {{$client_name}}</label>
                                        </div>                                       
                                        <div class="col selectorTool selectorToolRight">
                                            <label>To {{$opponent_name}}</label>
                                            <div class="left-col right-col">
                                                <div class="client-info 1_Client_opponentpercentage_div opponentpercentage_div">
                                                    50.00%
                                                </div>
                                                <div class="client-info 1_Client_opponentamount_div opponentamount_div" style="clear: both;">
                                                    $0
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 m-auto 1_Client_Slider_Tool slider-tool-main">
                                    <label></label>
                                    <div class="w-100">
                                        <label><input type="radio" id="1_Client_StockInvestments_Estimated_Value_Select" name="1_Client_StockInvestments_Estimated_Value_Select_Reset" class="StockInvestments_Estimated_Value_Select_Reset" value="Save"> Save this Distribution of StockInvestment Account #1</label>
                                        <label><input type="radio" id="1_Client_StockInvestments_Estimated_Value_Reset" name="1_Client_StockInvestments_Estimated_Value_Select_Reset" class="StockInvestments_Estimated_Value_Select_Reset" value="Reset" onclick="resetBalanceInput(this, '1', 'Client');"> Reset to Default (50%)</label>
                                    </div>
                                </div>

                                <div class="form-group col-sm-6 Client_StockInvestments_Paying_Party1_Inputs_Div" style="display: none;">
                                    <label>Client StockInvestments Paying Party1</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Client_StockInvestments_Paying_Party1_Client" name="Client_StockInvestments_Paying_Party1" value="{{$client_name}}" onchange="getStockInvestmentPayingParty(this, '1', 'Client');"> {{$client_name}}</label>
                                        <label><input type="radio" id="Client_StockInvestments_Paying_Party1_Op" name="Client_StockInvestments_Paying_Party1" value="{{$opponent_name}}" onchange="getStockInvestmentPayingParty(this, '1', 'Client');"> {{$opponent_name}}</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 Client_StockInvestments_Paying_Party1_Inputs_Div" style="display: none;">
                                    <label>{{$client_name}} StockInvestment Equity Percent</label>
                                    <input id="Client_StockInvestments_Percent_Marital_Equity_to_Client1" type="number" class="form-control 1_Client_clientpercentage_input clientpercentage_input" name="Client_StockInvestments_Percent_Marital_Equity_to_Client1" value="50.00" min="0.00" step="0.01" max="100" readonly="">
                                </div>
                                <div class="form-group col-sm-6 Client_StockInvestments_Paying_Party1_Inputs_Div" style="display: none;">
                                    <label>How much is to be paid to {{$client_name}}?</label>
                                    <input id="Client_StockInvestments_Estimated_Value_to_Client1" type="number" class="form-control 1_Client_clientamount_input clientamount_input" name="Client_StockInvestments_Estimated_Value_to_Client1" value="" min="0.00" step="0.01" max="999999.99" readonly="" onchange="getEstimatedValueClient(this, '1', 'Client');" onkeyup="getEstimatedValueClient(this, '1', 'Client');">
                                </div>
                                <div class="form-group col-sm-6 Client_StockInvestments_Paying_Party1_Inputs_Div" style="display: none;">
                                    <label>{{$opponent_name}} StockInvestment Equity Percent</label>
                                    <input id="Client_StockInvestments_Percent_Marital_Equity_to_Op1" type="number" class="form-control 1_Client_opponentpercentage_input opponentpercentage_input" name="Client_StockInvestments_Percent_Marital_Equity_to_Op1" value="50.00" min="0.00" step="0.01" max="100" readonly="">
                                </div>
                                <div class="form-group col-sm-6 Client_StockInvestments_Paying_Party1_Inputs_Div" style="display: none;">
                                    <label>How much is to be paid to {{$opponent_name}}?</label>
                                    <input id="Client_StockInvestments_Estimated_Value_to_Op1" type="number" class="form-control 1_Client_opponentamount_input opponentamount_input" name="Client_StockInvestments_Estimated_Value_to_Op1" value="" min="0.00" step="0.01" max="999999.99" readonly="" onchange="getEstimatedValueOp(this, '1', 'Client');" onkeyup="getEstimatedValueOp(this, '1', 'Client');">
                                </div>
                                <!-- end of slider tool -->
                            </div>
                            <div class="col-sm-12 mt-4 2_Client_stocksinvestments_section" style="display: none;"><h5 class="col-sm-12">Second Stock Investment Info</h5>
                                <div class="form-group col-sm-6">
                                    <p class="text-danger 2_Client_no-state-county-found" style="display: none;">No City, State, County found for this zipcode.</p>
                                    <label for="Client_StockInvestments_Institution_ZIP2">Stock/Investment Institution Zip Code?</label>
                                    <input id="Client_StockInvestments_Institution_ZIP2" type="text" class="form-control 2_Client_stocksinvestments_inputs" name="Client_StockInvestments_Institution_ZIP2" value="" onkeyup="getCityStateForZip(this, '2_Client');"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_StockInvestments_Institution_Name2">Name of Stock/Investment Institution?</label>
                                    <input id="Client_StockInvestments_Institution_Name2" type="text" class="form-control 2_Client_stocksinvestments_inputs" name="Client_StockInvestments_Institution_Name2" value=""> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_StockInvestments_Institution_Street_Address2">Stock/Investment Institution Street Address?</label>
                                    <input id="Client_StockInvestments_Institution_Street_Address2" type="text" class="form-control 2_Client_stocksinvestments_inputs" name="Client_StockInvestments_Institution_Street_Address2" value=""> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_StockInvestments_Institution_City2">Stock/Investment Institution City?</label>
                                    <select id="Client_StockInvestments_Institution_City2" name="Client_StockInvestments_Institution_City2" class="form-control 2_Client_city_select">
                                        <option value="">Choose City</option>
                                    </select>   
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_StockInvestments_Institution_State2">Stock/Investment Institution State?</label>
                                    <select id="Client_StockInvestments_Institution_State2" name="Client_StockInvestments_Institution_State2" class="form-control 2_Client_state_select">
                                        <option value="">Choose State</option>
                                    </select>   
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_StockInvestments_Acct_Num2">Account Number?</label>
                                    <input id="Client_StockInvestments_Acct_Num2" type="text" class="form-control 2_Client_stocksinvestments_inputs" name="Client_StockInvestments_Acct_Num2" value=""> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_StockInvestments_Date_Marriage_Value2">Marriage Date Value?</label>
                                    <input id="Client_StockInvestments_Date_Marriage_Value2" type="number" class="form-control 2_Client_stocksinvestments_inputs" name="Client_StockInvestments_Date_Marriage_Value2" value="0.00" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_StockInvestments_Current_Value2">Current Value?</label>
                                    <input id="Client_StockInvestments_Current_Value2" type="number" class="form-control 2_Client_stocksinvestments_inputs" name="Client_StockInvestments_Current_Value2" value="0.00" min="0.00" step="0.01" max="999999.99" onchange="getJointCurrentValue(this, '2', 'Client');" onkeyup="getJointCurrentValue(this, '2', 'Client');"> 
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label for="Client_StockInvestments_Percent_Marital_Equity2">N/A, calculated = Client_StockInvestments_Institution_Current_Value2</label>
                                    <input id="Client_StockInvestments_Percent_Marital_Equity2" type="number" class="form-control 2_Client_stocksinvestments_inputs" name="Client_StockInvestments_Percent_Marital_Equity2" value="" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_StockInvestments_Yearly_Interest_Dividend2">Yearly Interest and Dividends from this account?</label>
                                    <input id="Client_StockInvestments_Yearly_Interest_Dividend2" type="number" class="form-control 2_Client_stocksinvestments_inputs" name="Client_StockInvestments_Yearly_Interest_Dividend2" value="0.00" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Does either party claim a sole/separate interest from the other on this account?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Client_StockInvestments_SoleSeparate_Claim2_Yes" name="Client_StockInvestments_SoleSeparate_Claim2" value="Yes" onchange="getPartyClaimSoleSeparate(this, '2', 'Client');"> Yes</label>
                                        <label><input type="radio" id="Client_StockInvestments_SoleSeparate_Claim2_No" name="Client_StockInvestments_SoleSeparate_Claim2" value="No" checked="" onchange="getPartyClaimSoleSeparate(this, '2', 'Client');"> No</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6" id="Client_StockInvestments_SoleSeparate_Party2_Div" style="display: none;">
                                    <label>Who claims to own this account?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Client_StockInvestments_SoleSeparate_Party2_Client" name="Client_StockInvestments_SoleSeparate_Party2" value="{{$client_name}}"> {{$client_name}}</label>
                                        <label><input type="radio" id="Client_StockInvestments_SoleSeparate_Party2_Op" name="Client_StockInvestments_SoleSeparate_Party2" value="{{$opponent_name}}" checked=""> {{$opponent_name}}</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 left-clear" id="Client_StockInvestments_SoleSeparate_Grounds2_Div" style="display: none; clear: left;">
                                    <label for="Client_StockInvestments_SoleSeparate_Grounds2">Why does this person own this account solely and separately?</label>
                                    <input id="Client_StockInvestments_SoleSeparate_Grounds2" type="text" class="form-control 2_Client_stocksinvestments_inputs" name="Client_StockInvestments_SoleSeparate_Grounds2" value=""> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>How will this account value be distributed between the parties?</label>
                                    <div class="w-100 dataInput">
                                        <label><input type="radio" id="Client_StockInvestments_Disposition_Method2_Distribute Investments" name="Client_StockInvestments_Disposition_Method2" value="Distribute Investments" onchange="getDipositionMethod(this, '2', 'Client');"> Distribute Investments</label>
                                        <label><input type="radio" id="Client_StockInvestments_Disposition_Method2_Liquidate/Split Net Value" name="Client_StockInvestments_Disposition_Method2" value="Liquidate/Split Net Value" onchange="getDipositionMethod(this, '2', 'Client');"> Liquidate/Split Net Value</label>
                                        <label><input type="radio" id="Client_StockInvestments_Disposition_Method2_Percentage Buyout" name="Client_StockInvestments_Disposition_Method2" value="Percentage Buyout" onchange="getDipositionMethod(this, '2', 'Client');"> Percentage Buyout</label>
                                        <label><input type="radio" id="Client_StockInvestments_Disposition_Method2_Fixed Buyout" name="Client_StockInvestments_Disposition_Method2" value="Fixed Buyout" onchange="getDipositionMethod(this, '2', 'Client');"> Fixed Buyout</label>
                                    </div>
                                </div>
                                <!-- slider tool -->
                                <div class="form-group col-sm-6 m-auto 2_Client_Slider_Tool slider-tool-main">
                                    <div class="row">
                                        <div class="col">{{$client_name}}</div>
                                        <div class="col text-right">{{$opponent_name}}</div>
                                    </div>
                                    <input id="2_Client_balance_range_selector" type="range" class="form-control slider-tool-input 2_Client_balance_range_selector" name="" value="50.00" min="0.00" step="0.01" max="100" onchange="updateBalanceInput(this.value, '2', 'Client');">
                                </div>
                                <div class="form-group col-sm-6 m-auto 2_Client_Slider_Tool slider-tool-main">
                                    <div class="row justify-content-between">
                                        <div class="col selectorTool">
                                            <div class="left-col">
                                                <div class="client-info 2_Client_clientpercentage_div clientpercentage_div">
                                                    50.00%
                                                </div>
                                                <div class="client-info 2_Client_clientamount_div clientamount_div" style="clear: both;">
                                                    $0
                                                </div>
                                            </div>
                                            <label>To {{$client_name}}</label>
                                        </div>                                       
                                        <div class="col selectorTool selectorToolRight">
                                            <label>To {{$opponent_name}}</label>
                                            <div class="left-col right-col">
                                                <div class="client-info 2_Client_opponentpercentage_div opponentpercentage_div">
                                                    50.00%
                                                </div>
                                                <div class="client-info 2_Client_opponentamount_div opponentamount_div" style="clear: both;">
                                                    $0
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 m-auto 2_Client_Slider_Tool slider-tool-main">
                                    <label></label>
                                    <div class="w-100">
                                        <label><input type="radio" id="2_Client_StockInvestments_Estimated_Value_Select" name="2_Client_StockInvestments_Estimated_Value_Select_Reset" class="StockInvestments_Estimated_Value_Select_Reset" value="Save"> Save this Distribution of StockInvestment Account #2</label>
                                        <label><input type="radio" id="2_Client_StockInvestments_Estimated_Value_Reset" name="2_Client_StockInvestments_Estimated_Value_Select_Reset" class="StockInvestments_Estimated_Value_Select_Reset" value="Reset" onclick="resetBalanceInput(this, '2', 'Client');"> Reset to Default (50%)</label>
                                    </div>
                                </div>

                                <div class="form-group col-sm-6 Client_StockInvestments_Paying_Party2_Inputs_Div" style="display: none;">
                                    <label>Client StockInvestments Paying Party2</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Client_StockInvestments_Paying_Party2_Client" name="Client_StockInvestments_Paying_Party2" value="{{$client_name}}" onchange="getStockInvestmentPayingParty(this, '2', 'Client');"> {{$client_name}}</label>
                                        <label><input type="radio" id="Client_StockInvestments_Paying_Party2_Op" name="Client_StockInvestments_Paying_Party2" value="{{$opponent_name}}" onchange="getStockInvestmentPayingParty(this, '2', 'Client');"> {{$opponent_name}}</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 Client_StockInvestments_Paying_Party2_Inputs_Div" style="display: none;">
                                    <label>{{$client_name}} StockInvestment Equity Percent</label>
                                    <input id="Client_StockInvestments_Percent_Marital_Equity_to_Client2" type="number" class="form-control 2_Client_clientpercentage_input clientpercentage_input" name="Client_StockInvestments_Percent_Marital_Equity_to_Client2" value="50.00" min="0.00" step="0.01" max="100" readonly="">
                                </div>
                                <div class="form-group col-sm-6 Client_StockInvestments_Paying_Party2_Inputs_Div" style="display: none;">
                                    <label>How much is to be paid to {{$client_name}}?</label>
                                    <input id="Client_StockInvestments_Estimated_Value_to_Client2" type="number" class="form-control 2_Client_clientamount_input clientamount_input" name="Client_StockInvestments_Estimated_Value_to_Client2" value="" min="0.00" step="0.01" max="999999.99" readonly="" onchange="getEstimatedValueClient(this, '2', 'Client');" onkeyup="getEstimatedValueClient(this, '2', 'Client');">
                                </div>
                                <div class="form-group col-sm-6 Client_StockInvestments_Paying_Party2_Inputs_Div" style="display: none;">
                                    <label>{{$opponent_name}} StockInvestment Equity Percent</label>
                                    <input id="Client_StockInvestments_Percent_Marital_Equity_to_Op2" type="number" class="form-control 2_Client_opponentpercentage_input opponentpercentage_input" name="Client_StockInvestments_Percent_Marital_Equity_to_Op2" value="50.00" min="0.00" step="0.01" max="100" readonly="">
                                </div>
                                <div class="form-group col-sm-6 Client_StockInvestments_Paying_Party2_Inputs_Div" style="display: none;">
                                    <label>How much is to be paid to {{$opponent_name}}?</label>
                                    <input id="Client_StockInvestments_Estimated_Value_to_Op2" type="number" class="form-control 2_Client_opponentamount_input opponentamount_input" name="Client_StockInvestments_Estimated_Value_to_Op2" value="" min="0.00" step="0.01" max="999999.99" readonly="" onchange="getEstimatedValueOp(this, '2', 'Client');" onkeyup="getEstimatedValueOp(this, '2', 'Client');">
                                </div>
                                <!-- end of slider tool -->
                            </div>
                            <div class="col-sm-12 mt-4 3_Client_stocksinvestments_section" style="display: none;"><h5 class="col-sm-12">Third Stock Investment Info</h5>
                                <div class="form-group col-sm-6">
                                    <p class="text-danger 3_Client_no-state-county-found" style="display: none;">No City, State, County found for this zipcode.</p>
                                    <label for="Client_StockInvestments_Institution_ZIP3">Stock/Investment Institution Zip Code?</label>
                                    <input id="Client_StockInvestments_Institution_ZIP3" type="text" class="form-control 3_Client_stocksinvestments_inputs" name="Client_StockInvestments_Institution_ZIP3" value="" onkeyup="getCityStateForZip(this, '3_Client');"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_StockInvestments_Institution_Name3">Name of Stock/Investment Institution?</label>
                                    <input id="Client_StockInvestments_Institution_Name3" type="text" class="form-control 3_Client_stocksinvestments_inputs" name="Client_StockInvestments_Institution_Name3" value=""> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_StockInvestments_Institution_Street_Address3">Stock/Investment Institution Street Address?</label>
                                    <input id="Client_StockInvestments_Institution_Street_Address3" type="text" class="form-control 3_Client_stocksinvestments_inputs" name="Client_StockInvestments_Institution_Street_Address3" value=""> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_StockInvestments_Institution_City3">Stock/Investment Institution City?</label>
                                    <select id="Client_StockInvestments_Institution_City3" name="Client_StockInvestments_Institution_City3" class="form-control 3_Client_city_select">
                                        <option value="">Choose City</option>
                                    </select>   
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_StockInvestments_Institution_State3">Stock/Investment Institution State?</label>
                                    <select id="Client_StockInvestments_Institution_State3" name="Client_StockInvestments_Institution_State3" class="form-control 3_Client_state_select">
                                        <option value="">Choose State</option>
                                    </select>   
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_StockInvestments_Acct_Num3">Account Number?</label>
                                    <input id="Client_StockInvestments_Acct_Num3" type="text" class="form-control 3_Client_stocksinvestments_inputs" name="Client_StockInvestments_Acct_Num3" value=""> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_StockInvestments_Date_Marriage_Value3">Marriage Date Value?</label>
                                    <input id="Client_StockInvestments_Date_Marriage_Value3" type="number" class="form-control 3_Client_stocksinvestments_inputs" name="Client_StockInvestments_Date_Marriage_Value3" value="0.00" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_StockInvestments_Current_Value3">Current Value?</label>
                                    <input id="Client_StockInvestments_Current_Value3" type="number" class="form-control 3_Client_stocksinvestments_inputs" name="Client_StockInvestments_Current_Value3" value="0.00" min="0.00" step="0.01" max="999999.99" onchange="getJointCurrentValue(this, '3', 'Client');" onkeyup="getJointCurrentValue(this, '3', 'Client');"> 
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label for="Client_StockInvestments_Percent_Marital_Equity3">N/A, calculated = Client_StockInvestments_Institution_Current_Value3</label>
                                    <input id="Client_StockInvestments_Percent_Marital_Equity3" type="number" class="form-control 3_Client_stocksinvestments_inputs" name="Client_StockInvestments_Percent_Marital_Equity3" value="" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_StockInvestments_Yearly_Interest_Dividend3">Yearly Interest and Dividends from this account?</label>
                                    <input id="Client_StockInvestments_Yearly_Interest_Dividend3" type="number" class="form-control 3_Client_stocksinvestments_inputs" name="Client_StockInvestments_Yearly_Interest_Dividend3" value="0.00" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Does either party claim a sole/separate interest from the other on this account?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Client_StockInvestments_SoleSeparate_Claim3_Yes" name="Client_StockInvestments_SoleSeparate_Claim3" value="Yes" onchange="getPartyClaimSoleSeparate(this, '3', 'Client');"> Yes</label>
                                        <label><input type="radio" id="Client_StockInvestments_SoleSeparate_Claim3_No" name="Client_StockInvestments_SoleSeparate_Claim3" value="No" checked="" onchange="getPartyClaimSoleSeparate(this, '3', 'Client');"> No</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6" id="Client_StockInvestments_SoleSeparate_Party3_Div" style="display: none;">
                                    <label>Who claims to own this account?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Client_StockInvestments_SoleSeparate_Party3_Client" name="Client_StockInvestments_SoleSeparate_Party3" value="{{$client_name}}"> {{$client_name}}</label>
                                        <label><input type="radio" id="Client_StockInvestments_SoleSeparate_Party3_Op" name="Client_StockInvestments_SoleSeparate_Party3" value="{{$opponent_name}}" checked=""> {{$opponent_name}}</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 left-clear" id="Client_StockInvestments_SoleSeparate_Grounds3_Div" style="display: none; clear: left;">
                                    <label for="Client_StockInvestments_SoleSeparate_Grounds3">Why does this person own this account solely and separately?</label>
                                    <input id="Client_StockInvestments_SoleSeparate_Grounds3" type="text" class="form-control 3_Client_stocksinvestments_inputs" name="Client_StockInvestments_SoleSeparate_Grounds3" value=""> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>How will this account value be distributed between the parties?</label>
                                    <div class="w-100 dataInput">
                                        <label><input type="radio" id="Client_StockInvestments_Disposition_Method3_Distribute Investments" name="Client_StockInvestments_Disposition_Method3" value="Distribute Investments" onchange="getDipositionMethod(this, '3', 'Client');"> Distribute Investments</label>
                                        <label><input type="radio" id="Client_StockInvestments_Disposition_Method3_Liquidate/Split Net Value" name="Client_StockInvestments_Disposition_Method3" value="Liquidate/Split Net Value" onchange="getDipositionMethod(this, '3', 'Client');"> Liquidate/Split Net Value</label>
                                        <label><input type="radio" id="Client_StockInvestments_Disposition_Method3_Percentage Buyout" name="Client_StockInvestments_Disposition_Method3" value="Percentage Buyout" onchange="getDipositionMethod(this, '3', 'Client');"> Percentage Buyout</label>
                                        <label><input type="radio" id="Client_StockInvestments_Disposition_Method3_Fixed Buyout" name="Client_StockInvestments_Disposition_Method3" value="Fixed Buyout" onchange="getDipositionMethod(this, '3', 'Client');"> Fixed Buyout</label>
                                    </div>
                                </div>
                                <!-- slider tool -->
                                <div class="form-group col-sm-6 m-auto 3_Client_Slider_Tool slider-tool-main">
                                    <div class="row">
                                        <div class="col">{{$client_name}}</div>
                                        <div class="col text-right">{{$opponent_name}}</div>
                                    </div>
                                    <input id="3_Client_balance_range_selector" type="range" class="form-control slider-tool-input 3_Client_balance_range_selector" name="" value="50.00" min="0.00" step="0.01" max="100" onchange="updateBalanceInput(this.value, '3', 'Client');">
                                </div>
                                <div class="form-group col-sm-6 m-auto 3_Client_Slider_Tool slider-tool-main">
                                    <div class="row justify-content-between">
                                        <div class="col selectorTool">
                                            <div class="left-col">
                                                <div class="client-info 3_Client_clientpercentage_div clientpercentage_div">
                                                    50.00%
                                                </div>
                                                <div class="client-info 3_Client_clientamount_div clientamount_div" style="clear: both;">
                                                    $0
                                                </div>
                                            </div>
                                            <label>To {{$client_name}}</label>
                                        </div>                                       
                                        <div class="col selectorTool selectorToolRight">
                                            <label>To {{$opponent_name}}</label>
                                            <div class="left-col right-col">
                                                <div class="client-info 3_Client_opponentpercentage_div opponentpercentage_div">
                                                    50.00%
                                                </div>
                                                <div class="client-info 3_Client_opponentamount_div opponentamount_div" style="clear: both;">
                                                    $0
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 m-auto 3_Client_Slider_Tool slider-tool-main">
                                    <label></label>
                                    <div class="w-100">
                                        <label><input type="radio" id="3_Client_StockInvestments_Estimated_Value_Select" name="3_Client_StockInvestments_Estimated_Value_Select_Reset" class="StockInvestments_Estimated_Value_Select_Reset" value="Save"> Save this Distribution of StockInvestment Account #3</label>
                                        <label><input type="radio" id="3_Client_StockInvestments_Estimated_Value_Reset" name="3_Client_StockInvestments_Estimated_Value_Select_Reset" class="StockInvestments_Estimated_Value_Select_Reset" value="Reset" onclick="resetBalanceInput(this, '3', 'Client');"> Reset to Default (50%)</label>
                                    </div>
                                </div>

                                <div class="form-group col-sm-6 Client_StockInvestments_Paying_Party3_Inputs_Div" style="display: none;">
                                    <label>Client StockInvestments Paying Party3</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Client_StockInvestments_Paying_Party3_Client" name="Client_StockInvestments_Paying_Party3" value="{{$client_name}}" onchange="getStockInvestmentPayingParty(this, '3', 'Client');"> {{$client_name}}</label>
                                        <label><input type="radio" id="Client_StockInvestments_Paying_Party3_Op" name="Client_StockInvestments_Paying_Party3" value="{{$opponent_name}}" onchange="getStockInvestmentPayingParty(this, '3', 'Client');"> {{$opponent_name}}</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 Client_StockInvestments_Paying_Party3_Inputs_Div" style="display: none;">
                                    <label>{{$client_name}} StockInvestment Equity Percent</label>
                                    <input id="Client_StockInvestments_Percent_Marital_Equity_to_Client3" type="number" class="form-control 3_Client_clientpercentage_input clientpercentage_input" name="Client_StockInvestments_Percent_Marital_Equity_to_Client3" value="50.00" min="0.00" step="0.01" max="100" readonly="">
                                </div>
                                <div class="form-group col-sm-6 Client_StockInvestments_Paying_Party3_Inputs_Div" style="display: none;">
                                    <label>How much is to be paid to {{$client_name}}?</label>
                                    <input id="Client_StockInvestments_Estimated_Value_to_Client3" type="number" class="form-control 3_Client_clientamount_input clientamount_input" name="Client_StockInvestments_Estimated_Value_to_Client3" value="" min="0.00" step="0.01" max="999999.99" readonly="" onchange="getEstimatedValueClient(this, '3', 'Client');" onkeyup="getEstimatedValueClient(this, '3', 'Client');">
                                </div>
                                <div class="form-group col-sm-6 Client_StockInvestments_Paying_Party3_Inputs_Div" style="display: none;">
                                    <label>{{$opponent_name}} StockInvestment Equity Percent</label>
                                    <input id="Client_StockInvestments_Percent_Marital_Equity_to_Op3" type="number" class="form-control 3_Client_opponentpercentage_input opponentpercentage_input" name="Client_StockInvestments_Percent_Marital_Equity_to_Op3" value="50.00" min="0.00" step="0.01" max="100" readonly="">
                                </div>
                                <div class="form-group col-sm-6 Client_StockInvestments_Paying_Party3_Inputs_Div" style="display: none;">
                                    <label>How much is to be paid to {{$opponent_name}}?</label>
                                    <input id="Client_StockInvestments_Estimated_Value_to_Op3" type="number" class="form-control 3_Client_opponentamount_input opponentamount_input" name="Client_StockInvestments_Estimated_Value_to_Op3" value="" min="0.00" step="0.01" max="999999.99" readonly="" onchange="getEstimatedValueOp(this, '3', 'Client');" onkeyup="getEstimatedValueOp(this, '3', 'Client');">
                                </div>
                                <!-- end of slider tool -->
                            </div>
                            <div class="col-sm-12 mt-4 4_Client_stocksinvestments_section" style="display: none;"><h5 class="col-sm-12">Fourth Stock Investment Info</h5>
                                <div class="form-group col-sm-6">
                                    <p class="text-danger 4_Client_no-state-county-found" style="display: none;">No City, State, County found for this zipcode.</p>
                                    <label for="Client_StockInvestments_Institution_ZIP4">Stock/Investment Institution Zip Code?</label>
                                    <input id="Client_StockInvestments_Institution_ZIP4" type="text" class="form-control 4_Client_stocksinvestments_inputs" name="Client_StockInvestments_Institution_ZIP4" value="" onkeyup="getCityStateForZip(this, '4_Client');"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_StockInvestments_Institution_Name4">Name of Stock/Investment Institution?</label>
                                    <input id="Client_StockInvestments_Institution_Name4" type="text" class="form-control 4_Client_stocksinvestments_inputs" name="Client_StockInvestments_Institution_Name4" value=""> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_StockInvestments_Institution_Street_Address4">Stock/Investment Institution Street Address?</label>
                                    <input id="Client_StockInvestments_Institution_Street_Address4" type="text" class="form-control 4_Client_stocksinvestments_inputs" name="Client_StockInvestments_Institution_Street_Address4" value=""> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_StockInvestments_Institution_City4">Stock/Investment Institution City?</label>
                                    <select id="Client_StockInvestments_Institution_City4" name="Client_StockInvestments_Institution_City4" class="form-control 4_Client_city_select">
                                        <option value="">Choose City</option>
                                    </select>   
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_StockInvestments_Institution_State4">Stock/Investment Institution State?</label>
                                    <select id="Client_StockInvestments_Institution_State4" name="Client_StockInvestments_Institution_State4" class="form-control 4_Client_state_select">
                                        <option value="">Choose State</option>
                                    </select>   
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_StockInvestments_Acct_Num4">Account Number?</label>
                                    <input id="Client_StockInvestments_Acct_Num4" type="text" class="form-control 4_Client_stocksinvestments_inputs" name="Client_StockInvestments_Acct_Num4" value=""> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_StockInvestments_Date_Marriage_Value4">Marriage Date Value?</label>
                                    <input id="Client_StockInvestments_Date_Marriage_Value4" type="number" class="form-control 4_Client_stocksinvestments_inputs" name="Client_StockInvestments_Date_Marriage_Value4" value="0.00" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_StockInvestments_Current_Value4">Current Value?</label>
                                    <input id="Client_StockInvestments_Current_Value4" type="number" class="form-control 4_Client_stocksinvestments_inputs" name="Client_StockInvestments_Current_Value4" value="0.00" min="0.00" step="0.01" max="999999.99" onchange="getJointCurrentValue(this, '4', 'Client');" onkeyup="getJointCurrentValue(this, '4', 'Client');"> 
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label for="Client_StockInvestments_Percent_Marital_Equity4">N/A, calculated = Client_StockInvestments_Institution_Current_Value4</label>
                                    <input id="Client_StockInvestments_Percent_Marital_Equity4" type="number" class="form-control 4_Client_stocksinvestments_inputs" name="Client_StockInvestments_Percent_Marital_Equity4" value="" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_StockInvestments_Yearly_Interest_Dividend4">Yearly Interest and Dividends from this account?</label>
                                    <input id="Client_StockInvestments_Yearly_Interest_Dividend4" type="number" class="form-control 4_Client_stocksinvestments_inputs" name="Client_StockInvestments_Yearly_Interest_Dividend4" value="0.00" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Does either party claim a sole/separate interest from the other on this account?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Client_StockInvestments_SoleSeparate_Claim4_Yes" name="Client_StockInvestments_SoleSeparate_Claim4" value="Yes" onchange="getPartyClaimSoleSeparate(this, '4', 'Client');"> Yes</label>
                                        <label><input type="radio" id="Client_StockInvestments_SoleSeparate_Claim4_No" name="Client_StockInvestments_SoleSeparate_Claim4" value="No" checked="" onchange="getPartyClaimSoleSeparate(this, '4', 'Client');"> No</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6" id="Client_StockInvestments_SoleSeparate_Party4_Div" style="display: none;">
                                    <label>Who claims to own this account?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Client_StockInvestments_SoleSeparate_Party4_Client" name="Client_StockInvestments_SoleSeparate_Party4" value="{{$client_name}}"> {{$client_name}}</label>
                                        <label><input type="radio" id="Client_StockInvestments_SoleSeparate_Party4_Op" name="Client_StockInvestments_SoleSeparate_Party4" value="{{$opponent_name}}" checked=""> {{$opponent_name}}</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 left-clear" id="Client_StockInvestments_SoleSeparate_Grounds4_Div" style="display: none; clear: left;">
                                    <label for="Client_StockInvestments_SoleSeparate_Grounds4">Why does this person own this account solely and separately?</label>
                                    <input id="Client_StockInvestments_SoleSeparate_Grounds4" type="text" class="form-control 4_Client_stocksinvestments_inputs" name="Client_StockInvestments_SoleSeparate_Grounds4" value=""> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>How will this account value be distributed between the parties?</label>
                                    <div class="w-100 dataInput">
                                        <label><input type="radio" id="Client_StockInvestments_Disposition_Method4_Distribute Investments" name="Client_StockInvestments_Disposition_Method4" value="Distribute Investments" onchange="getDipositionMethod(this, '4', 'Client');"> Distribute Investments</label>
                                        <label><input type="radio" id="Client_StockInvestments_Disposition_Method4_Liquidate/Split Net Value" name="Client_StockInvestments_Disposition_Method4" value="Liquidate/Split Net Value" onchange="getDipositionMethod(this, '4', 'Client');"> Liquidate/Split Net Value</label>
                                        <label><input type="radio" id="Client_StockInvestments_Disposition_Method4_Percentage Buyout" name="Client_StockInvestments_Disposition_Method4" value="Percentage Buyout" onchange="getDipositionMethod(this, '4', 'Client');"> Percentage Buyout</label>
                                        <label><input type="radio" id="Client_StockInvestments_Disposition_Method4_Fixed Buyout" name="Client_StockInvestments_Disposition_Method4" value="Fixed Buyout" onchange="getDipositionMethod(this, '4', 'Client');"> Fixed Buyout</label>
                                    </div>
                                </div>
                                <!-- slider tool -->
                                <div class="form-group col-sm-6 m-auto 4_Client_Slider_Tool slider-tool-main">
                                    <div class="row">
                                        <div class="col">{{$client_name}}</div>
                                        <div class="col text-right">{{$opponent_name}}</div>
                                    </div>
                                    <input id="4_Client_balance_range_selector" type="range" class="form-control slider-tool-input 4_Client_balance_range_selector" name="" value="50.00" min="0.00" step="0.01" max="100" onchange="updateBalanceInput(this.value, '4', 'Client');">
                                </div>
                                <div class="form-group col-sm-6 m-auto 4_Client_Slider_Tool slider-tool-main">
                                    <div class="row justify-content-between">
                                        <div class="col selectorTool">
                                            <div class="left-col">
                                                <div class="client-info 4_Client_clientpercentage_div clientpercentage_div">
                                                    50.00%
                                                </div>
                                                <div class="client-info 4_Client_clientamount_div clientamount_div" style="clear: both;">
                                                    $0
                                                </div>
                                            </div>
                                            <label>To {{$client_name}}</label>
                                        </div>                                       
                                        <div class="col selectorTool selectorToolRight">
                                            <label>To {{$opponent_name}}</label>
                                            <div class="left-col right-col">
                                                <div class="client-info 4_Client_opponentpercentage_div opponentpercentage_div">
                                                    50.00%
                                                </div>
                                                <div class="client-info 4_Client_opponentamount_div opponentamount_div" style="clear: both;">
                                                    $0
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 m-auto 4_Client_Slider_Tool slider-tool-main">
                                    <label></label>
                                    <div class="w-100">
                                        <label><input type="radio" id="4_Client_StockInvestments_Estimated_Value_Select" name="4_Client_StockInvestments_Estimated_Value_Select_Reset" class="StockInvestments_Estimated_Value_Select_Reset" value="Save"> Save this Distribution of StockInvestment Account #4</label>
                                        <label><input type="radio" id="4_Client_StockInvestments_Estimated_Value_Reset" name="4_Client_StockInvestments_Estimated_Value_Select_Reset" class="StockInvestments_Estimated_Value_Select_Reset" value="Reset" onclick="resetBalanceInput(this, '4', 'Client');"> Reset to Default (50%)</label>
                                    </div>
                                </div>

                                <div class="form-group col-sm-6 Client_StockInvestments_Paying_Party4_Inputs_Div" style="display: none;">
                                    <label>Client StockInvestments Paying Party4</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Client_StockInvestments_Paying_Party4_Client" name="Client_StockInvestments_Paying_Party4" value="{{$client_name}}" onchange="getStockInvestmentPayingParty(this, '4', 'Client');"> {{$client_name}}</label>
                                        <label><input type="radio" id="Client_StockInvestments_Paying_Party4_Op" name="Client_StockInvestments_Paying_Party4" value="{{$opponent_name}}" onchange="getStockInvestmentPayingParty(this, '4', 'Client');"> {{$opponent_name}}</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 Client_StockInvestments_Paying_Party4_Inputs_Div" style="display: none;">
                                    <label>{{$client_name}} StockInvestment Equity Percent</label>
                                    <input id="Client_StockInvestments_Percent_Marital_Equity_to_Client4" type="number" class="form-control 4_Client_clientpercentage_input clientpercentage_input" name="Client_StockInvestments_Percent_Marital_Equity_to_Client4" value="50.00" min="0.00" step="0.01" max="100" readonly="">
                                </div>
                                <div class="form-group col-sm-6 Client_StockInvestments_Paying_Party4_Inputs_Div" style="display: none;">
                                    <label>How much is to be paid to {{$client_name}}?</label>
                                    <input id="Client_StockInvestments_Estimated_Value_to_Client4" type="number" class="form-control 4_Client_clientamount_input clientamount_input" name="Client_StockInvestments_Estimated_Value_to_Client4" value="" min="0.00" step="0.01" max="999999.99" readonly="" onchange="getEstimatedValueClient(this, '4', 'Client');" onkeyup="getEstimatedValueClient(this, '4', 'Client');">
                                </div>
                                <div class="form-group col-sm-6 Client_StockInvestments_Paying_Party4_Inputs_Div" style="display: none;">
                                    <label>{{$opponent_name}} StockInvestment Equity Percent</label>
                                    <input id="Client_StockInvestments_Percent_Marital_Equity_to_Op4" type="number" class="form-control 4_Client_opponentpercentage_input opponentpercentage_input" name="Client_StockInvestments_Percent_Marital_Equity_to_Op4" value="50.00" min="0.00" step="0.01" max="100" readonly="">
                                </div>
                                <div class="form-group col-sm-6 Client_StockInvestments_Paying_Party4_Inputs_Div" style="display: none;">
                                    <label>How much is to be paid to {{$opponent_name}}?</label>
                                    <input id="Client_StockInvestments_Estimated_Value_to_Op4" type="number" class="form-control 4_Client_opponentamount_input opponentamount_input" name="Client_StockInvestments_Estimated_Value_to_Op4" value="" min="0.00" step="0.01" max="999999.99" readonly="" onchange="getEstimatedValueOp(this, '4', 'Client');" onkeyup="getEstimatedValueOp(this, '4', 'Client');">
                                </div>
                                <!-- end of slider tool -->
                            </div>
                            <div class="col-sm-12 mt-4 5_Client_stocksinvestments_section" style="display: none;"><h5 class="col-sm-12">Fifth Stock Investment Info</h5>
                                <div class="form-group col-sm-6">
                                    <p class="text-danger 5_Client_no-state-county-found" style="display: none;">No City, State, County found for this zipcode.</p>
                                    <label for="Client_StockInvestments_Institution_ZIP5">Stock/Investment Institution Zip Code?</label>
                                    <input id="Client_StockInvestments_Institution_ZIP5" type="text" class="form-control 5_Client_stocksinvestments_inputs" name="Client_StockInvestments_Institution_ZIP5" value="" onkeyup="getCityStateForZip(this, '5_Client');"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_StockInvestments_Institution_Name5">Name of Stock/Investment Institution?</label>
                                    <input id="Client_StockInvestments_Institution_Name5" type="text" class="form-control 5_Client_stocksinvestments_inputs" name="Client_StockInvestments_Institution_Name5" value=""> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_StockInvestments_Institution_Street_Address5">Stock/Investment Institution Street Address?</label>
                                    <input id="Client_StockInvestments_Institution_Street_Address5" type="text" class="form-control 5_Client_stocksinvestments_inputs" name="Client_StockInvestments_Institution_Street_Address5" value=""> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_StockInvestments_Institution_City5">Stock/Investment Institution City?</label>
                                    <select id="Client_StockInvestments_Institution_City5" name="Client_StockInvestments_Institution_City5" class="form-control 5_Client_city_select">
                                        <option value="">Choose City</option>
                                    </select>   
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_StockInvestments_Institution_State5">Stock/Investment Institution State?</label>
                                    <select id="Client_StockInvestments_Institution_State5" name="Client_StockInvestments_Institution_State5" class="form-control 5_Client_state_select">
                                        <option value="">Choose State</option>
                                    </select>   
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_StockInvestments_Acct_Num5">Account Number?</label>
                                    <input id="Client_StockInvestments_Acct_Num5" type="text" class="form-control 5_Client_stocksinvestments_inputs" name="Client_StockInvestments_Acct_Num5" value=""> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_StockInvestments_Date_Marriage_Value5">Marriage Date Value?</label>
                                    <input id="Client_StockInvestments_Date_Marriage_Value5" type="number" class="form-control 5_Client_stocksinvestments_inputs" name="Client_StockInvestments_Date_Marriage_Value5" value="0.00" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_StockInvestments_Current_Value5">Current Value?</label>
                                    <input id="Client_StockInvestments_Current_Value5" type="number" class="form-control 5_Client_stocksinvestments_inputs" name="Client_StockInvestments_Current_Value5" value="0.00" min="0.00" step="0.01" max="999999.99" onchange="getJointCurrentValue(this, '5', 'Client');" onkeyup="getJointCurrentValue(this, '5', 'Client');"> 
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label for="Client_StockInvestments_Percent_Marital_Equity5">N/A, calculated = Client_StockInvestments_Institution_Current_Value5</label>
                                    <input id="Client_StockInvestments_Percent_Marital_Equity5" type="number" class="form-control 5_Client_stocksinvestments_inputs" name="Client_StockInvestments_Percent_Marital_Equity5" value="" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_StockInvestments_Yearly_Interest_Dividend5">Yearly Interest and Dividends from this account?</label>
                                    <input id="Client_StockInvestments_Yearly_Interest_Dividend5" type="number" class="form-control 5_Client_stocksinvestments_inputs" name="Client_StockInvestments_Yearly_Interest_Dividend5" value="0.00" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Does either party claim a sole/separate interest from the other on this account?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Client_StockInvestments_SoleSeparate_Claim5_Yes" name="Client_StockInvestments_SoleSeparate_Claim5" value="Yes" onchange="getPartyClaimSoleSeparate(this, '5', 'Client');"> Yes</label>
                                        <label><input type="radio" id="Client_StockInvestments_SoleSeparate_Claim5_No" name="Client_StockInvestments_SoleSeparate_Claim5" value="No" checked="" onchange="getPartyClaimSoleSeparate(this, '5', 'Client');"> No</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6" id="Client_StockInvestments_SoleSeparate_Party5_Div" style="display: none;">
                                    <label>Who claims to own this account?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Client_StockInvestments_SoleSeparate_Party5_Client" name="Client_StockInvestments_SoleSeparate_Party5" value="{{$client_name}}"> {{$client_name}}</label>
                                        <label><input type="radio" id="Client_StockInvestments_SoleSeparate_Party5_Op" name="Client_StockInvestments_SoleSeparate_Party5" value="{{$opponent_name}}" checked=""> {{$opponent_name}}</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 left-clear" id="Client_StockInvestments_SoleSeparate_Grounds5_Div" style="display: none; clear: left;">
                                    <label for="Client_StockInvestments_SoleSeparate_Grounds5">Why does this person own this account solely and separately?</label>
                                    <input id="Client_StockInvestments_SoleSeparate_Grounds5" type="text" class="form-control 5_Client_stocksinvestments_inputs" name="Client_StockInvestments_SoleSeparate_Grounds5" value=""> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>How will this account value be distributed between the parties?</label>
                                    <div class="w-100 dataInput">
                                        <label><input type="radio" id="Client_StockInvestments_Disposition_Method5_Distribute Investments" name="Client_StockInvestments_Disposition_Method5" value="Distribute Investments" onchange="getDipositionMethod(this, '5', 'Client');"> Distribute Investments</label>
                                        <label><input type="radio" id="Client_StockInvestments_Disposition_Method5_Liquidate/Split Net Value" name="Client_StockInvestments_Disposition_Method5" value="Liquidate/Split Net Value" onchange="getDipositionMethod(this, '5', 'Client');"> Liquidate/Split Net Value</label>
                                        <label><input type="radio" id="Client_StockInvestments_Disposition_Method5_Percentage Buyout" name="Client_StockInvestments_Disposition_Method5" value="Percentage Buyout" onchange="getDipositionMethod(this, '5', 'Client');"> Percentage Buyout</label>
                                        <label><input type="radio" id="Client_StockInvestments_Disposition_Method5_Fixed Buyout" name="Client_StockInvestments_Disposition_Method5" value="Fixed Buyout" onchange="getDipositionMethod(this, '5', 'Client');"> Fixed Buyout</label>
                                    </div>
                                </div>
                                <!-- slider tool -->
                                <div class="form-group col-sm-6 m-auto 5_Client_Slider_Tool slider-tool-main">
                                    <div class="row">
                                        <div class="col">{{$client_name}}</div>
                                        <div class="col text-right">{{$opponent_name}}</div>
                                    </div>
                                    <input id="5_Client_balance_range_selector" type="range" class="form-control slider-tool-input 5_Client_balance_range_selector" name="" value="50.00" min="0.00" step="0.01" max="100" onchange="updateBalanceInput(this.value, '5', 'Client');">
                                </div>
                                <div class="form-group col-sm-6 m-auto 5_Client_Slider_Tool slider-tool-main">
                                    <div class="row justify-content-between">
                                        <div class="col selectorTool">
                                            <div class="left-col">
                                                <div class="client-info 5_Client_clientpercentage_div clientpercentage_div">
                                                    50.00%
                                                </div>
                                                <div class="client-info 5_Client_clientamount_div clientamount_div" style="clear: both;">
                                                    $0
                                                </div>
                                            </div>
                                            <label>To {{$client_name}}</label>
                                        </div>                                       
                                        <div class="col selectorTool selectorToolRight">
                                            <label>To {{$opponent_name}}</label>
                                            <div class="left-col right-col">
                                                <div class="client-info 5_Client_opponentpercentage_div opponentpercentage_div">
                                                    50.00%
                                                </div>
                                                <div class="client-info 5_Client_opponentamount_div opponentamount_div" style="clear: both;">
                                                    $0
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 m-auto 5_Client_Slider_Tool slider-tool-main">
                                    <label></label>
                                    <div class="w-100">
                                        <label><input type="radio" id="5_Client_StockInvestments_Estimated_Value_Select" name="5_Client_StockInvestments_Estimated_Value_Select_Reset" class="StockInvestments_Estimated_Value_Select_Reset" value="Save"> Save this Distribution of StockInvestment Account #5</label>
                                        <label><input type="radio" id="5_Client_StockInvestments_Estimated_Value_Reset" name="5_Client_StockInvestments_Estimated_Value_Select_Reset" class="StockInvestments_Estimated_Value_Select_Reset" value="Reset" onclick="resetBalanceInput(this, '5', 'Client');"> Reset to Default (50%)</label>
                                    </div>
                                </div>

                                <div class="form-group col-sm-6 Client_StockInvestments_Paying_Party5_Inputs_Div" style="display: none;">
                                    <label>Client StockInvestments Paying Party5</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Client_StockInvestments_Paying_Party5_Client" name="Client_StockInvestments_Paying_Party5" value="{{$client_name}}" onchange="getStockInvestmentPayingParty(this, '5', 'Client');"> {{$client_name}}</label>
                                        <label><input type="radio" id="Client_StockInvestments_Paying_Party5_Op" name="Client_StockInvestments_Paying_Party5" value="{{$opponent_name}}" onchange="getStockInvestmentPayingParty(this, '5', 'Client');"> {{$opponent_name}}</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 Client_StockInvestments_Paying_Party5_Inputs_Div" style="display: none;">
                                    <label>{{$client_name}} StockInvestment Equity Percent</label>
                                    <input id="Client_StockInvestments_Percent_Marital_Equity_to_Client5" type="number" class="form-control 5_Client_clientpercentage_input clientpercentage_input" name="Client_StockInvestments_Percent_Marital_Equity_to_Client5" value="50.00" min="0.00" step="0.01" max="100" readonly="">
                                </div>
                                <div class="form-group col-sm-6 Client_StockInvestments_Paying_Party5_Inputs_Div" style="display: none;">
                                    <label>How much is to be paid to {{$client_name}}?</label>
                                    <input id="Client_StockInvestments_Estimated_Value_to_Client5" type="number" class="form-control 5_Client_clientamount_input clientamount_input" name="Client_StockInvestments_Estimated_Value_to_Client5" value="" min="0.00" step="0.01" max="999999.99" readonly="" onchange="getEstimatedValueClient(this, '5', 'Client');" onkeyup="getEstimatedValueClient(this, '5', 'Client');">
                                </div>
                                <div class="form-group col-sm-6 Client_StockInvestments_Paying_Party5_Inputs_Div" style="display: none;">
                                    <label>{{$opponent_name}} StockInvestment Equity Percent</label>
                                    <input id="Client_StockInvestments_Percent_Marital_Equity_to_Op5" type="number" class="form-control 5_Client_opponentpercentage_input opponentpercentage_input" name="Client_StockInvestments_Percent_Marital_Equity_to_Op5" value="50.00" min="0.00" step="0.01" max="100" readonly="">
                                </div>
                                <div class="form-group col-sm-6 Client_StockInvestments_Paying_Party5_Inputs_Div" style="display: none;">
                                    <label>How much is to be paid to {{$opponent_name}}?</label>
                                    <input id="Client_StockInvestments_Estimated_Value_to_Op5" type="number" class="form-control 5_Client_opponentamount_input opponentamount_input" name="Client_StockInvestments_Estimated_Value_to_Op5" value="" min="0.00" step="0.01" max="999999.99" readonly="" onchange="getEstimatedValueOp(this, '5', 'Client');" onkeyup="getEstimatedValueOp(this, '5', 'Client');">
                                </div>
                                <!-- end of slider tool -->
                            </div>
                            <div class="col-sm-12 mt-4 6_Client_stocksinvestments_section" style="display: none;"><h5 class="col-sm-12">Sixth Stock Investment Info</h5>
                                <div class="form-group col-sm-6">
                                    <p class="text-danger 6_Client_no-state-county-found" style="display: none;">No City, State, County found for this zipcode.</p>
                                    <label for="Client_StockInvestments_Institution_ZIP6">Stock/Investment Institution Zip Code?</label>
                                    <input id="Client_StockInvestments_Institution_ZIP6" type="text" class="form-control 6_Client_stocksinvestments_inputs" name="Client_StockInvestments_Institution_ZIP6" value="" onkeyup="getCityStateForZip(this, '6_Client');"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_StockInvestments_Institution_Name6">Name of Stock/Investment Institution?</label>
                                    <input id="Client_StockInvestments_Institution_Name6" type="text" class="form-control 6_Client_stocksinvestments_inputs" name="Client_StockInvestments_Institution_Name6" value=""> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_StockInvestments_Institution_Street_Address6">Stock/Investment Institution Street Address?</label>
                                    <input id="Client_StockInvestments_Institution_Street_Address6" type="text" class="form-control 6_Client_stocksinvestments_inputs" name="Client_StockInvestments_Institution_Street_Address6" value=""> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_StockInvestments_Institution_City6">Stock/Investment Institution City?</label>
                                    <select id="Client_StockInvestments_Institution_City6" name="Client_StockInvestments_Institution_City6" class="form-control 6_Client_city_select">
                                        <option value="">Choose City</option>
                                    </select>   
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_StockInvestments_Institution_State6">Stock/Investment Institution State?</label>
                                    <select id="Client_StockInvestments_Institution_State6" name="Client_StockInvestments_Institution_State6" class="form-control 6_Client_state_select">
                                        <option value="">Choose State</option>
                                    </select>   
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_StockInvestments_Acct_Num6">Account Number?</label>
                                    <input id="Client_StockInvestments_Acct_Num6" type="text" class="form-control 6_Client_stocksinvestments_inputs" name="Client_StockInvestments_Acct_Num6" value=""> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_StockInvestments_Date_Marriage_Value6">Marriage Date Value?</label>
                                    <input id="Client_StockInvestments_Date_Marriage_Value6" type="number" class="form-control 6_Client_stocksinvestments_inputs" name="Client_StockInvestments_Date_Marriage_Value6" value="0.00" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_StockInvestments_Current_Value6">Current Value?</label>
                                    <input id="Client_StockInvestments_Current_Value6" type="number" class="form-control 6_Client_stocksinvestments_inputs" name="Client_StockInvestments_Current_Value6" value="0.00" min="0.00" step="0.01" max="999999.99" onchange="getJointCurrentValue(this, '6', 'Client');" onkeyup="getJointCurrentValue(this, '6', 'Client');"> 
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label for="Client_StockInvestments_Percent_Marital_Equity6">N/A, calculated = Client_StockInvestments_Institution_Current_Value6</label>
                                    <input id="Client_StockInvestments_Percent_Marital_Equity6" type="number" class="form-control 6_Client_stocksinvestments_inputs" name="Client_StockInvestments_Percent_Marital_Equity6" value="" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_StockInvestments_Yearly_Interest_Dividend6">Yearly Interest and Dividends from this account?</label>
                                    <input id="Client_StockInvestments_Yearly_Interest_Dividend6" type="number" class="form-control 6_Client_stocksinvestments_inputs" name="Client_StockInvestments_Yearly_Interest_Dividend6" value="0.00" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Does either party claim a sole/separate interest from the other on this account?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Client_StockInvestments_SoleSeparate_Claim6_Yes" name="Client_StockInvestments_SoleSeparate_Claim6" value="Yes" onchange="getPartyClaimSoleSeparate(this, '6', 'Client');"> Yes</label>
                                        <label><input type="radio" id="Client_StockInvestments_SoleSeparate_Claim6_No" name="Client_StockInvestments_SoleSeparate_Claim6" value="No" checked="" onchange="getPartyClaimSoleSeparate(this, '6', 'Client');"> No</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6" id="Client_StockInvestments_SoleSeparate_Party6_Div" style="display: none;">
                                    <label>Who claims to own this account?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Client_StockInvestments_SoleSeparate_Party6_Client" name="Client_StockInvestments_SoleSeparate_Party6" value="{{$client_name}}"> {{$client_name}}</label>
                                        <label><input type="radio" id="Client_StockInvestments_SoleSeparate_Party6_Op" name="Client_StockInvestments_SoleSeparate_Party6" value="{{$opponent_name}}" checked=""> {{$opponent_name}}</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 left-clear" id="Client_StockInvestments_SoleSeparate_Grounds6_Div" style="display: none; clear: left;">
                                    <label for="Client_StockInvestments_SoleSeparate_Grounds6">Why does this person own this account solely and separately?</label>
                                    <input id="Client_StockInvestments_SoleSeparate_Grounds6" type="text" class="form-control 6_Client_stocksinvestments_inputs" name="Client_StockInvestments_SoleSeparate_Grounds6" value=""> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>How will this account value be distributed between the parties?</label>
                                    <div class="w-100 dataInput">
                                        <label><input type="radio" id="Client_StockInvestments_Disposition_Method6_Distribute Investments" name="Client_StockInvestments_Disposition_Method6" value="Distribute Investments" onchange="getDipositionMethod(this, '6', 'Client');"> Distribute Investments</label>
                                        <label><input type="radio" id="Client_StockInvestments_Disposition_Method6_Liquidate/Split Net Value" name="Client_StockInvestments_Disposition_Method6" value="Liquidate/Split Net Value" onchange="getDipositionMethod(this, '6', 'Client');"> Liquidate/Split Net Value</label>
                                        <label><input type="radio" id="Client_StockInvestments_Disposition_Method6_Percentage Buyout" name="Client_StockInvestments_Disposition_Method6" value="Percentage Buyout" onchange="getDipositionMethod(this, '6', 'Client');"> Percentage Buyout</label>
                                        <label><input type="radio" id="Client_StockInvestments_Disposition_Method6_Fixed Buyout" name="Client_StockInvestments_Disposition_Method6" value="Fixed Buyout" onchange="getDipositionMethod(this, '6', 'Client');"> Fixed Buyout</label>
                                    </div>
                                </div>
                                <!-- slider tool -->
                                <div class="form-group col-sm-6 m-auto 6_Client_Slider_Tool slider-tool-main">
                                    <div class="row">
                                        <div class="col">{{$client_name}}</div>
                                        <div class="col text-right">{{$opponent_name}}</div>
                                    </div>
                                    <input id="6_Client_balance_range_selector" type="range" class="form-control slider-tool-input 6_Client_balance_range_selector" name="" value="50.00" min="0.00" step="0.01" max="100" onchange="updateBalanceInput(this.value, '6', 'Client');">
                                </div>
                                <div class="form-group col-sm-6 m-auto 6_Client_Slider_Tool slider-tool-main">
                                    <div class="row justify-content-between">
                                        <div class="col selectorTool">
                                            <div class="left-col">
                                                <div class="client-info 6_Client_clientpercentage_div clientpercentage_div">
                                                    50.00%
                                                </div>
                                                <div class="client-info 6_Client_clientamount_div clientamount_div" style="clear: both;">
                                                    $0
                                                </div>
                                            </div>
                                            <label>To {{$client_name}}</label>
                                        </div>                                       
                                        <div class="col selectorTool selectorToolRight">
                                            <label>To {{$opponent_name}}</label>
                                            <div class="left-col right-col">
                                                <div class="client-info 6_Client_opponentpercentage_div opponentpercentage_div">
                                                    50.00%
                                                </div>
                                                <div class="client-info 6_Client_opponentamount_div opponentamount_div" style="clear: both;">
                                                    $0
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 m-auto 6_Client_Slider_Tool slider-tool-main">
                                    <label></label>
                                    <div class="w-100">
                                        <label><input type="radio" id="6_Client_StockInvestments_Estimated_Value_Select" name="6_Client_StockInvestments_Estimated_Value_Select_Reset" class="StockInvestments_Estimated_Value_Select_Reset" value="Save"> Save this Distribution of StockInvestment Account #6</label>
                                        <label><input type="radio" id="6_Client_StockInvestments_Estimated_Value_Reset" name="6_Client_StockInvestments_Estimated_Value_Select_Reset" class="StockInvestments_Estimated_Value_Select_Reset" value="Reset" onclick="resetBalanceInput(this, '6', 'Client');"> Reset to Default (50%)</label>
                                    </div>
                                </div>

                                <div class="form-group col-sm-6 Client_StockInvestments_Paying_Party6_Inputs_Div" style="display: none;">
                                    <label>Client StockInvestments Paying Party6</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Client_StockInvestments_Paying_Party6_Client" name="Client_StockInvestments_Paying_Party6" value="{{$client_name}}" onchange="getStockInvestmentPayingParty(this, '6', 'Client');"> {{$client_name}}</label>
                                        <label><input type="radio" id="Client_StockInvestments_Paying_Party6_Op" name="Client_StockInvestments_Paying_Party6" value="{{$opponent_name}}" onchange="getStockInvestmentPayingParty(this, '6', 'Client');"> {{$opponent_name}}</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 Client_StockInvestments_Paying_Party6_Inputs_Div" style="display: none;">
                                    <label>{{$client_name}} StockInvestment Equity Percent</label>
                                    <input id="Client_StockInvestments_Percent_Marital_Equity_to_Client6" type="number" class="form-control 6_Client_clientpercentage_input clientpercentage_input" name="Client_StockInvestments_Percent_Marital_Equity_to_Client6" value="50.00" min="0.00" step="0.01" max="100" readonly="">
                                </div>
                                <div class="form-group col-sm-6 Client_StockInvestments_Paying_Party6_Inputs_Div" style="display: none;">
                                    <label>How much is to be paid to {{$client_name}}?</label>
                                    <input id="Client_StockInvestments_Estimated_Value_to_Client6" type="number" class="form-control 6_Client_clientamount_input clientamount_input" name="Client_StockInvestments_Estimated_Value_to_Client6" value="" min="0.00" step="0.01" max="999999.99" readonly="" onchange="getEstimatedValueClient(this, '6', 'Client');" onkeyup="getEstimatedValueClient(this, '6', 'Client');">
                                </div>
                                <div class="form-group col-sm-6 Client_StockInvestments_Paying_Party6_Inputs_Div" style="display: none;">
                                    <label>{{$opponent_name}} StockInvestment Equity Percent</label>
                                    <input id="Client_StockInvestments_Percent_Marital_Equity_to_Op6" type="number" class="form-control 6_Client_opponentpercentage_input opponentpercentage_input" name="Client_StockInvestments_Percent_Marital_Equity_to_Op6" value="50.00" min="0.00" step="0.01" max="100" readonly="">
                                </div>
                                <div class="form-group col-sm-6 Client_StockInvestments_Paying_Party6_Inputs_Div" style="display: none;">
                                    <label>How much is to be paid to {{$opponent_name}}?</label>
                                    <input id="Client_StockInvestments_Estimated_Value_to_Op6" type="number" class="form-control 6_Client_opponentamount_input opponentamount_input" name="Client_StockInvestments_Estimated_Value_to_Op6" value="" min="0.00" step="0.01" max="999999.99" readonly="" onchange="getEstimatedValueOp(this, '6', 'Client');" onkeyup="getEstimatedValueOp(this, '6', 'Client');">
                                </div>
                                <!-- end of slider tool -->
                            </div>
                            <div class="col-sm-12 mt-4 7_Client_stocksinvestments_section" style="display: none;"><h5 class="col-sm-12">Seventh Stock Investment Info</h5>
                                <div class="form-group col-sm-6">
                                    <p class="text-danger 7_Client_no-state-county-found" style="display: none;">No City, State, County found for this zipcode.</p>
                                    <label for="Client_StockInvestments_Institution_ZIP7">Stock/Investment Institution Zip Code?</label>
                                    <input id="Client_StockInvestments_Institution_ZIP7" type="text" class="form-control 7_Client_stocksinvestments_inputs" name="Client_StockInvestments_Institution_ZIP7" value="" onkeyup="getCityStateForZip(this, '7_Client');"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_StockInvestments_Institution_Name7">Name of Stock/Investment Institution?</label>
                                    <input id="Client_StockInvestments_Institution_Name7" type="text" class="form-control 7_Client_stocksinvestments_inputs" name="Client_StockInvestments_Institution_Name7" value=""> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_StockInvestments_Institution_Street_Address7">Stock/Investment Institution Street Address?</label>
                                    <input id="Client_StockInvestments_Institution_Street_Address7" type="text" class="form-control 7_Client_stocksinvestments_inputs" name="Client_StockInvestments_Institution_Street_Address7" value=""> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_StockInvestments_Institution_City7">Stock/Investment Institution City?</label>
                                    <select id="Client_StockInvestments_Institution_City7" name="Client_StockInvestments_Institution_City7" class="form-control 7_Client_city_select">
                                        <option value="">Choose City</option>
                                    </select>   
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_StockInvestments_Institution_State7">Stock/Investment Institution State?</label>
                                    <select id="Client_StockInvestments_Institution_State7" name="Client_StockInvestments_Institution_State7" class="form-control 7_Client_state_select">
                                        <option value="">Choose State</option>
                                    </select>   
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_StockInvestments_Acct_Num7">Account Number?</label>
                                    <input id="Client_StockInvestments_Acct_Num7" type="text" class="form-control 7_Client_stocksinvestments_inputs" name="Client_StockInvestments_Acct_Num7" value=""> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_StockInvestments_Date_Marriage_Value7">Marriage Date Value?</label>
                                    <input id="Client_StockInvestments_Date_Marriage_Value7" type="number" class="form-control 7_Client_stocksinvestments_inputs" name="Client_StockInvestments_Date_Marriage_Value7" value="0.00" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_StockInvestments_Current_Value7">Current Value?</label>
                                    <input id="Client_StockInvestments_Current_Value7" type="number" class="form-control 7_Client_stocksinvestments_inputs" name="Client_StockInvestments_Current_Value7" value="0.00" min="0.00" step="0.01" max="999999.99" onchange="getJointCurrentValue(this, '7', 'Client');" onkeyup="getJointCurrentValue(this, '7', 'Client');"> 
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label for="Client_StockInvestments_Percent_Marital_Equity7">N/A, calculated = Client_StockInvestments_Institution_Current_Value7</label>
                                    <input id="Client_StockInvestments_Percent_Marital_Equity7" type="number" class="form-control 7_Client_stocksinvestments_inputs" name="Client_StockInvestments_Percent_Marital_Equity7" value="" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_StockInvestments_Yearly_Interest_Dividend7">Yearly Interest and Dividends from this account?</label>
                                    <input id="Client_StockInvestments_Yearly_Interest_Dividend7" type="number" class="form-control 7_Client_stocksinvestments_inputs" name="Client_StockInvestments_Yearly_Interest_Dividend7" value="0.00" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Does either party claim a sole/separate interest from the other on this account?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Client_StockInvestments_SoleSeparate_Claim7_Yes" name="Client_StockInvestments_SoleSeparate_Claim7" value="Yes" onchange="getPartyClaimSoleSeparate(this, '7', 'Client');"> Yes</label>
                                        <label><input type="radio" id="Client_StockInvestments_SoleSeparate_Claim7_No" name="Client_StockInvestments_SoleSeparate_Claim7" value="No" checked="" onchange="getPartyClaimSoleSeparate(this, '7', 'Client');"> No</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6" id="Client_StockInvestments_SoleSeparate_Party7_Div" style="display: none;">
                                    <label>Who claims to own this account?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Client_StockInvestments_SoleSeparate_Party7_Client" name="Client_StockInvestments_SoleSeparate_Party7" value="{{$client_name}}"> {{$client_name}}</label>
                                        <label><input type="radio" id="Client_StockInvestments_SoleSeparate_Party7_Op" name="Client_StockInvestments_SoleSeparate_Party7" value="{{$opponent_name}}" checked=""> {{$opponent_name}}</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 left-clear" id="Client_StockInvestments_SoleSeparate_Grounds7_Div" style="display: none; clear: left;">
                                    <label for="Client_StockInvestments_SoleSeparate_Grounds7">Why does this person own this account solely and separately?</label>
                                    <input id="Client_StockInvestments_SoleSeparate_Grounds7" type="text" class="form-control 7_Client_stocksinvestments_inputs" name="Client_StockInvestments_SoleSeparate_Grounds7" value=""> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>How will this account value be distributed between the parties?</label>
                                    <div class="w-100 dataInput">
                                        <label><input type="radio" id="Client_StockInvestments_Disposition_Method7_Distribute Investments" name="Client_StockInvestments_Disposition_Method7" value="Distribute Investments" onchange="getDipositionMethod(this, '7', 'Client');"> Distribute Investments</label>
                                        <label><input type="radio" id="Client_StockInvestments_Disposition_Method7_Liquidate/Split Net Value" name="Client_StockInvestments_Disposition_Method7" value="Liquidate/Split Net Value" onchange="getDipositionMethod(this, '7', 'Client');"> Liquidate/Split Net Value</label>
                                        <label><input type="radio" id="Client_StockInvestments_Disposition_Method7_Percentage Buyout" name="Client_StockInvestments_Disposition_Method7" value="Percentage Buyout" onchange="getDipositionMethod(this, '7', 'Client');"> Percentage Buyout</label>
                                        <label><input type="radio" id="Client_StockInvestments_Disposition_Method7_Fixed Buyout" name="Client_StockInvestments_Disposition_Method7" value="Fixed Buyout" onchange="getDipositionMethod(this, '7', 'Client');"> Fixed Buyout</label>
                                    </div>
                                </div>
                                <!-- slider tool -->
                                <div class="form-group col-sm-6 m-auto 7_Client_Slider_Tool slider-tool-main">
                                    <div class="row">
                                        <div class="col">{{$client_name}}</div>
                                        <div class="col text-right">{{$opponent_name}}</div>
                                    </div>
                                    <input id="7_Client_balance_range_selector" type="range" class="form-control slider-tool-input 7_Client_balance_range_selector" name="" value="50.00" min="0.00" step="0.01" max="100" onchange="updateBalanceInput(this.value, '7', 'Client');">
                                </div>
                                <div class="form-group col-sm-6 m-auto 7_Client_Slider_Tool slider-tool-main">
                                    <div class="row justify-content-between">
                                        <div class="col selectorTool">
                                            <div class="left-col">
                                                <div class="client-info 7_Client_clientpercentage_div clientpercentage_div">
                                                    50.00%
                                                </div>
                                                <div class="client-info 7_Client_clientamount_div clientamount_div" style="clear: both;">
                                                    $0
                                                </div>
                                            </div>
                                            <label>To {{$client_name}}</label>
                                        </div>                                       
                                        <div class="col selectorTool selectorToolRight">
                                            <label>To {{$opponent_name}}</label>
                                            <div class="left-col right-col">
                                                <div class="client-info 7_Client_opponentpercentage_div opponentpercentage_div">
                                                    50.00%
                                                </div>
                                                <div class="client-info 7_Client_opponentamount_div opponentamount_div" style="clear: both;">
                                                    $0
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 m-auto 7_Client_Slider_Tool slider-tool-main">
                                    <label></label>
                                    <div class="w-100">
                                        <label><input type="radio" id="7_Client_StockInvestments_Estimated_Value_Select" name="7_Client_StockInvestments_Estimated_Value_Select_Reset" class="StockInvestments_Estimated_Value_Select_Reset" value="Save"> Save this Distribution of StockInvestment Account #7</label>
                                        <label><input type="radio" id="7_Client_StockInvestments_Estimated_Value_Reset" name="7_Client_StockInvestments_Estimated_Value_Select_Reset" class="StockInvestments_Estimated_Value_Select_Reset" value="Reset" onclick="resetBalanceInput(this, '7', 'Client');"> Reset to Default (50%)</label>
                                    </div>
                                </div>

                                <div class="form-group col-sm-6 Client_StockInvestments_Paying_Party7_Inputs_Div" style="display: none;">
                                    <label>Client StockInvestments Paying Party7</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Client_StockInvestments_Paying_Party7_Client" name="Client_StockInvestments_Paying_Party7" value="{{$client_name}}" onchange="getStockInvestmentPayingParty(this, '7', 'Client');"> {{$client_name}}</label>
                                        <label><input type="radio" id="Client_StockInvestments_Paying_Party7_Op" name="Client_StockInvestments_Paying_Party7" value="{{$opponent_name}}" onchange="getStockInvestmentPayingParty(this, '7', 'Client');"> {{$opponent_name}}</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 Client_StockInvestments_Paying_Party7_Inputs_Div" style="display: none;">
                                    <label>{{$client_name}} StockInvestment Equity Percent</label>
                                    <input id="Client_StockInvestments_Percent_Marital_Equity_to_Client7" type="number" class="form-control 7_Client_clientpercentage_input clientpercentage_input" name="Client_StockInvestments_Percent_Marital_Equity_to_Client7" value="50.00" min="0.00" step="0.01" max="100" readonly="">
                                </div>
                                <div class="form-group col-sm-6 Client_StockInvestments_Paying_Party7_Inputs_Div" style="display: none;">
                                    <label>How much is to be paid to {{$client_name}}?</label>
                                    <input id="Client_StockInvestments_Estimated_Value_to_Client7" type="number" class="form-control 7_Client_clientamount_input clientamount_input" name="Client_StockInvestments_Estimated_Value_to_Client7" value="" min="0.00" step="0.01" max="999999.99" readonly="" onchange="getEstimatedValueClient(this, '7', 'Client');" onkeyup="getEstimatedValueClient(this, '7', 'Client');">
                                </div>
                                <div class="form-group col-sm-6 Client_StockInvestments_Paying_Party7_Inputs_Div" style="display: none;">
                                    <label>{{$opponent_name}} StockInvestment Equity Percent</label>
                                    <input id="Client_StockInvestments_Percent_Marital_Equity_to_Op7" type="number" class="form-control 7_Client_opponentpercentage_input opponentpercentage_input" name="Client_StockInvestments_Percent_Marital_Equity_to_Op7" value="50.00" min="0.00" step="0.01" max="100" readonly="">
                                </div>
                                <div class="form-group col-sm-6 Client_StockInvestments_Paying_Party7_Inputs_Div" style="display: none;">
                                    <label>How much is to be paid to {{$opponent_name}}?</label>
                                    <input id="Client_StockInvestments_Estimated_Value_to_Op7" type="number" class="form-control 7_Client_opponentamount_input opponentamount_input" name="Client_StockInvestments_Estimated_Value_to_Op7" value="" min="0.00" step="0.01" max="999999.99" readonly="" onchange="getEstimatedValueOp(this, '7', 'Client');" onkeyup="getEstimatedValueOp(this, '7', 'Client');">
                                </div>
                                <!-- end of slider tool -->
                            </div>
                            <div class="col-sm-12 mt-4 8_Client_stocksinvestments_section" style="display: none;"><h5 class="col-sm-12">Eighth Stock Investment Info</h5>
                                <div class="form-group col-sm-6">
                                    <p class="text-danger 8_Client_no-state-county-found" style="display: none;">No City, State, County found for this zipcode.</p>
                                    <label for="Client_StockInvestments_Institution_ZIP8">Stock/Investment Institution Zip Code?</label>
                                    <input id="Client_StockInvestments_Institution_ZIP8" type="text" class="form-control 8_Client_stocksinvestments_inputs" name="Client_StockInvestments_Institution_ZIP8" value="" onkeyup="getCityStateForZip(this, '8_Client');"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_StockInvestments_Institution_Name8">Name of Stock/Investment Institution?</label>
                                    <input id="Client_StockInvestments_Institution_Name8" type="text" class="form-control 8_Client_stocksinvestments_inputs" name="Client_StockInvestments_Institution_Name8" value=""> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_StockInvestments_Institution_Street_Address8">Stock/Investment Institution Street Address?</label>
                                    <input id="Client_StockInvestments_Institution_Street_Address8" type="text" class="form-control 8_Client_stocksinvestments_inputs" name="Client_StockInvestments_Institution_Street_Address8" value=""> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_StockInvestments_Institution_City8">Stock/Investment Institution City?</label>
                                    <select id="Client_StockInvestments_Institution_City8" name="Client_StockInvestments_Institution_City8" class="form-control 8_Client_city_select">
                                        <option value="">Choose City</option>
                                    </select>   
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_StockInvestments_Institution_State8">Stock/Investment Institution State?</label>
                                    <select id="Client_StockInvestments_Institution_State8" name="Client_StockInvestments_Institution_State8" class="form-control 8_Client_state_select">
                                        <option value="">Choose State</option>
                                    </select>   
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_StockInvestments_Acct_Num8">Account Number?</label>
                                    <input id="Client_StockInvestments_Acct_Num8" type="text" class="form-control 8_Client_stocksinvestments_inputs" name="Client_StockInvestments_Acct_Num8" value=""> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_StockInvestments_Date_Marriage_Value8">Marriage Date Value?</label>
                                    <input id="Client_StockInvestments_Date_Marriage_Value8" type="number" class="form-control 8_Client_stocksinvestments_inputs" name="Client_StockInvestments_Date_Marriage_Value8" value="0.00" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_StockInvestments_Current_Value8">Current Value?</label>
                                    <input id="Client_StockInvestments_Current_Value8" type="number" class="form-control 8_Client_stocksinvestments_inputs" name="Client_StockInvestments_Current_Value8" value="0.00" min="0.00" step="0.01" max="999999.99" onchange="getJointCurrentValue(this, '8', 'Client');" onkeyup="getJointCurrentValue(this, '8', 'Client');"> 
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label for="Client_StockInvestments_Percent_Marital_Equity8">N/A, calculated = Client_StockInvestments_Institution_Current_Value8</label>
                                    <input id="Client_StockInvestments_Percent_Marital_Equity8" type="number" class="form-control 8_Client_stocksinvestments_inputs" name="Client_StockInvestments_Percent_Marital_Equity8" value="" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_StockInvestments_Yearly_Interest_Dividend8">Yearly Interest and Dividends from this account?</label>
                                    <input id="Client_StockInvestments_Yearly_Interest_Dividend8" type="number" class="form-control 8_Client_stocksinvestments_inputs" name="Client_StockInvestments_Yearly_Interest_Dividend8" value="0.00" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Does either party claim a sole/separate interest from the other on this account?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Client_StockInvestments_SoleSeparate_Claim8_Yes" name="Client_StockInvestments_SoleSeparate_Claim8" value="Yes" onchange="getPartyClaimSoleSeparate(this, '8', 'Client');"> Yes</label>
                                        <label><input type="radio" id="Client_StockInvestments_SoleSeparate_Claim8_No" name="Client_StockInvestments_SoleSeparate_Claim8" value="No" checked="" onchange="getPartyClaimSoleSeparate(this, '8', 'Client');"> No</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6" id="Client_StockInvestments_SoleSeparate_Party8_Div" style="display: none;">
                                    <label>Who claims to own this account?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Client_StockInvestments_SoleSeparate_Party8_Client" name="Client_StockInvestments_SoleSeparate_Party8" value="{{$client_name}}"> {{$client_name}}</label>
                                        <label><input type="radio" id="Client_StockInvestments_SoleSeparate_Party8_Op" name="Client_StockInvestments_SoleSeparate_Party8" value="{{$opponent_name}}" checked=""> {{$opponent_name}}</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 left-clear" id="Client_StockInvestments_SoleSeparate_Grounds8_Div" style="display: none; clear: left;">
                                    <label for="Client_StockInvestments_SoleSeparate_Grounds8">Why does this person own this account solely and separately?</label>
                                    <input id="Client_StockInvestments_SoleSeparate_Grounds8" type="text" class="form-control 8_Client_stocksinvestments_inputs" name="Client_StockInvestments_SoleSeparate_Grounds8" value=""> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>How will this account value be distributed between the parties?</label>
                                    <div class="w-100 dataInput">
                                        <label><input type="radio" id="Client_StockInvestments_Disposition_Method8_Distribute Investments" name="Client_StockInvestments_Disposition_Method8" value="Distribute Investments" onchange="getDipositionMethod(this, '8', 'Client');"> Distribute Investments</label>
                                        <label><input type="radio" id="Client_StockInvestments_Disposition_Method8_Liquidate/Split Net Value" name="Client_StockInvestments_Disposition_Method8" value="Liquidate/Split Net Value" onchange="getDipositionMethod(this, '8', 'Client');"> Liquidate/Split Net Value</label>
                                        <label><input type="radio" id="Client_StockInvestments_Disposition_Method8_Percentage Buyout" name="Client_StockInvestments_Disposition_Method8" value="Percentage Buyout" onchange="getDipositionMethod(this, '8', 'Client');"> Percentage Buyout</label>
                                        <label><input type="radio" id="Client_StockInvestments_Disposition_Method8_Fixed Buyout" name="Client_StockInvestments_Disposition_Method8" value="Fixed Buyout" onchange="getDipositionMethod(this, '8', 'Client');"> Fixed Buyout</label>
                                    </div>
                                </div>
                                <!-- slider tool -->
                                <div class="form-group col-sm-6 m-auto 8_Client_Slider_Tool slider-tool-main">
                                    <div class="row">
                                        <div class="col">{{$client_name}}</div>
                                        <div class="col text-right">{{$opponent_name}}</div>
                                    </div>
                                    <input id="8_Client_balance_range_selector" type="range" class="form-control slider-tool-input 8_Client_balance_range_selector" name="" value="50.00" min="0.00" step="0.01" max="100" onchange="updateBalanceInput(this.value, '8', 'Client');">
                                </div>
                                <div class="form-group col-sm-6 m-auto 8_Client_Slider_Tool slider-tool-main">
                                    <div class="row justify-content-between">
                                        <div class="col selectorTool">
                                            <div class="left-col">
                                                <div class="client-info 8_Client_clientpercentage_div clientpercentage_div">
                                                    50.00%
                                                </div>
                                                <div class="client-info 8_Client_clientamount_div clientamount_div" style="clear: both;">
                                                    $0
                                                </div>
                                            </div>
                                            <label>To {{$client_name}}</label>
                                        </div>                                       
                                        <div class="col selectorTool selectorToolRight">
                                            <label>To {{$opponent_name}}</label>
                                            <div class="left-col right-col">
                                                <div class="client-info 8_Client_opponentpercentage_div opponentpercentage_div">
                                                    50.00%
                                                </div>
                                                <div class="client-info 8_Client_opponentamount_div opponentamount_div" style="clear: both;">
                                                    $0
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 m-auto 8_Client_Slider_Tool slider-tool-main">
                                    <label></label>
                                    <div class="w-100">
                                        <label><input type="radio" id="8_Client_StockInvestments_Estimated_Value_Select" name="8_Client_StockInvestments_Estimated_Value_Select_Reset" class="StockInvestments_Estimated_Value_Select_Reset" value="Save"> Save this Distribution of StockInvestment Account #8</label>
                                        <label><input type="radio" id="8_Client_StockInvestments_Estimated_Value_Reset" name="8_Client_StockInvestments_Estimated_Value_Select_Reset" class="StockInvestments_Estimated_Value_Select_Reset" value="Reset" onclick="resetBalanceInput(this, '8', 'Client');"> Reset to Default (50%)</label>
                                    </div>
                                </div>

                                <div class="form-group col-sm-6 Client_StockInvestments_Paying_Party8_Inputs_Div" style="display: none;">
                                    <label>Client StockInvestments Paying Party8</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Client_StockInvestments_Paying_Party8_Client" name="Client_StockInvestments_Paying_Party8" value="{{$client_name}}" onchange="getStockInvestmentPayingParty(this, '8', 'Client');"> {{$client_name}}</label>
                                        <label><input type="radio" id="Client_StockInvestments_Paying_Party8_Op" name="Client_StockInvestments_Paying_Party8" value="{{$opponent_name}}" onchange="getStockInvestmentPayingParty(this, '8', 'Client');"> {{$opponent_name}}</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 Client_StockInvestments_Paying_Party8_Inputs_Div" style="display: none;">
                                    <label>{{$client_name}} StockInvestment Equity Percent</label>
                                    <input id="Client_StockInvestments_Percent_Marital_Equity_to_Client8" type="number" class="form-control 8_Client_clientpercentage_input clientpercentage_input" name="Client_StockInvestments_Percent_Marital_Equity_to_Client8" value="50.00" min="0.00" step="0.01" max="100" readonly="">
                                </div>
                                <div class="form-group col-sm-6 Client_StockInvestments_Paying_Party8_Inputs_Div" style="display: none;">
                                    <label>How much is to be paid to {{$client_name}}?</label>
                                    <input id="Client_StockInvestments_Estimated_Value_to_Client8" type="number" class="form-control 8_Client_clientamount_input clientamount_input" name="Client_StockInvestments_Estimated_Value_to_Client8" value="" min="0.00" step="0.01" max="999999.99" readonly="" onchange="getEstimatedValueClient(this, '8', 'Client');" onkeyup="getEstimatedValueClient(this, '8', 'Client');">
                                </div>
                                <div class="form-group col-sm-6 Client_StockInvestments_Paying_Party8_Inputs_Div" style="display: none;">
                                    <label>{{$opponent_name}} StockInvestment Equity Percent</label>
                                    <input id="Client_StockInvestments_Percent_Marital_Equity_to_Op8" type="number" class="form-control 8_Client_opponentpercentage_input opponentpercentage_input" name="Client_StockInvestments_Percent_Marital_Equity_to_Op8" value="50.00" min="0.00" step="0.01" max="100" readonly="">
                                </div>
                                <div class="form-group col-sm-6 Client_StockInvestments_Paying_Party8_Inputs_Div" style="display: none;">
                                    <label>How much is to be paid to {{$opponent_name}}?</label>
                                    <input id="Client_StockInvestments_Estimated_Value_to_Op8" type="number" class="form-control 8_Client_opponentamount_input opponentamount_input" name="Client_StockInvestments_Estimated_Value_to_Op8" value="" min="0.00" step="0.01" max="999999.99" readonly="" onchange="getEstimatedValueOp(this, '8', 'Client');" onkeyup="getEstimatedValueOp(this, '8', 'Client');">
                                </div>
                                <!-- end of slider tool -->
                            </div>
                            <div class="col-sm-12 mt-4 9_Client_stocksinvestments_section" style="display: none;"><h5 class="col-sm-12">Nineth Stock Investment Info</h5>
                                <div class="form-group col-sm-6">
                                    <p class="text-danger 9_Client_no-state-county-found" style="display: none;">No City, State, County found for this zipcode.</p>
                                    <label for="Client_StockInvestments_Institution_ZIP9">Stock/Investment Institution Zip Code?</label>
                                    <input id="Client_StockInvestments_Institution_ZIP9" type="text" class="form-control 9_Client_stocksinvestments_inputs" name="Client_StockInvestments_Institution_ZIP9" value="" onkeyup="getCityStateForZip(this, '9_Client');"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_StockInvestments_Institution_Name9">Name of Stock/Investment Institution?</label>
                                    <input id="Client_StockInvestments_Institution_Name9" type="text" class="form-control 9_Client_stocksinvestments_inputs" name="Client_StockInvestments_Institution_Name9" value=""> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_StockInvestments_Institution_Street_Address9">Stock/Investment Institution Street Address?</label>
                                    <input id="Client_StockInvestments_Institution_Street_Address9" type="text" class="form-control 9_Client_stocksinvestments_inputs" name="Client_StockInvestments_Institution_Street_Address9" value=""> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_StockInvestments_Institution_City9">Stock/Investment Institution City?</label>
                                    <select id="Client_StockInvestments_Institution_City9" name="Client_StockInvestments_Institution_City9" class="form-control 9_Client_city_select">
                                        <option value="">Choose City</option>
                                    </select>   
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_StockInvestments_Institution_State9">Stock/Investment Institution State?</label>
                                    <select id="Client_StockInvestments_Institution_State9" name="Client_StockInvestments_Institution_State9" class="form-control 9_Client_state_select">
                                        <option value="">Choose State</option>
                                    </select>   
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_StockInvestments_Acct_Num9">Account Number?</label>
                                    <input id="Client_StockInvestments_Acct_Num9" type="text" class="form-control 9_Client_stocksinvestments_inputs" name="Client_StockInvestments_Acct_Num9" value=""> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_StockInvestments_Date_Marriage_Value9">Marriage Date Value?</label>
                                    <input id="Client_StockInvestments_Date_Marriage_Value9" type="number" class="form-control 9_Client_stocksinvestments_inputs" name="Client_StockInvestments_Date_Marriage_Value9" value="0.00" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_StockInvestments_Current_Value9">Current Value?</label>
                                    <input id="Client_StockInvestments_Current_Value9" type="number" class="form-control 9_Client_stocksinvestments_inputs" name="Client_StockInvestments_Current_Value9" value="0.00" min="0.00" step="0.01" max="999999.99" onchange="getJointCurrentValue(this, '9', 'Client');" onkeyup="getJointCurrentValue(this, '9', 'Client');"> 
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label for="Client_StockInvestments_Percent_Marital_Equity9">N/A, calculated = Client_StockInvestments_Institution_Current_Value9</label>
                                    <input id="Client_StockInvestments_Percent_Marital_Equity9" type="number" class="form-control 9_Client_stocksinvestments_inputs" name="Client_StockInvestments_Percent_Marital_Equity9" value="" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_StockInvestments_Yearly_Interest_Dividend9">Yearly Interest and Dividends from this account?</label>
                                    <input id="Client_StockInvestments_Yearly_Interest_Dividend9" type="number" class="form-control 9_Client_stocksinvestments_inputs" name="Client_StockInvestments_Yearly_Interest_Dividend9" value="0.00" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Does either party claim a sole/separate interest from the other on this account?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Client_StockInvestments_SoleSeparate_Claim9_Yes" name="Client_StockInvestments_SoleSeparate_Claim9" value="Yes" onchange="getPartyClaimSoleSeparate(this, '9', 'Client');"> Yes</label>
                                        <label><input type="radio" id="Client_StockInvestments_SoleSeparate_Claim9_No" name="Client_StockInvestments_SoleSeparate_Claim9" value="No" checked="" onchange="getPartyClaimSoleSeparate(this, '9', 'Client');"> No</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6" id="Client_StockInvestments_SoleSeparate_Party9_Div" style="display: none;">
                                    <label>Who claims to own this account?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Client_StockInvestments_SoleSeparate_Party9_Client" name="Client_StockInvestments_SoleSeparate_Party9" value="{{$client_name}}"> {{$client_name}}</label>
                                        <label><input type="radio" id="Client_StockInvestments_SoleSeparate_Party9_Op" name="Client_StockInvestments_SoleSeparate_Party9" value="{{$opponent_name}}" checked=""> {{$opponent_name}}</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 left-clear" id="Client_StockInvestments_SoleSeparate_Grounds9_Div" style="display: none; clear: left;">
                                    <label for="Client_StockInvestments_SoleSeparate_Grounds9">Why does this person own this account solely and separately?</label>
                                    <input id="Client_StockInvestments_SoleSeparate_Grounds9" type="text" class="form-control 9_Client_stocksinvestments_inputs" name="Client_StockInvestments_SoleSeparate_Grounds9" value=""> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>How will this account value be distributed between the parties?</label>
                                    <div class="w-100 dataInput">
                                        <label><input type="radio" id="Client_StockInvestments_Disposition_Method9_Distribute Investments" name="Client_StockInvestments_Disposition_Method9" value="Distribute Investments" onchange="getDipositionMethod(this, '9', 'Client');"> Distribute Investments</label>
                                        <label><input type="radio" id="Client_StockInvestments_Disposition_Method9_Liquidate/Split Net Value" name="Client_StockInvestments_Disposition_Method9" value="Liquidate/Split Net Value" onchange="getDipositionMethod(this, '9', 'Client');"> Liquidate/Split Net Value</label>
                                        <label><input type="radio" id="Client_StockInvestments_Disposition_Method9_Percentage Buyout" name="Client_StockInvestments_Disposition_Method9" value="Percentage Buyout" onchange="getDipositionMethod(this, '9', 'Client');"> Percentage Buyout</label>
                                        <label><input type="radio" id="Client_StockInvestments_Disposition_Method9_Fixed Buyout" name="Client_StockInvestments_Disposition_Method9" value="Fixed Buyout" onchange="getDipositionMethod(this, '9', 'Client');"> Fixed Buyout</label>
                                    </div>
                                </div>
                                <!-- slider tool -->
                                <div class="form-group col-sm-6 m-auto 9_Client_Slider_Tool slider-tool-main">
                                    <div class="row">
                                        <div class="col">{{$client_name}}</div>
                                        <div class="col text-right">{{$opponent_name}}</div>
                                    </div>
                                    <input id="9_Client_balance_range_selector" type="range" class="form-control slider-tool-input 9_Client_balance_range_selector" name="" value="50.00" min="0.00" step="0.01" max="100" onchange="updateBalanceInput(this.value, '9', 'Client');">
                                </div>
                                <div class="form-group col-sm-6 m-auto 9_Client_Slider_Tool slider-tool-main">
                                    <div class="row justify-content-between">
                                        <div class="col selectorTool">
                                            <div class="left-col">
                                                <div class="client-info 9_Client_clientpercentage_div clientpercentage_div">
                                                    50.00%
                                                </div>
                                                <div class="client-info 9_Client_clientamount_div clientamount_div" style="clear: both;">
                                                    $0
                                                </div>
                                            </div>
                                            <label>To {{$client_name}}</label>
                                        </div>                                       
                                        <div class="col selectorTool selectorToolRight">
                                            <label>To {{$opponent_name}}</label>
                                            <div class="left-col right-col">
                                                <div class="client-info 9_Client_opponentpercentage_div opponentpercentage_div">
                                                    50.00%
                                                </div>
                                                <div class="client-info 9_Client_opponentamount_div opponentamount_div" style="clear: both;">
                                                    $0
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 m-auto 9_Client_Slider_Tool slider-tool-main">
                                    <label></label>
                                    <div class="w-100">
                                        <label><input type="radio" id="9_Client_StockInvestments_Estimated_Value_Select" name="9_Client_StockInvestments_Estimated_Value_Select_Reset" class="StockInvestments_Estimated_Value_Select_Reset" value="Save"> Save this Distribution of StockInvestment Account #9</label>
                                        <label><input type="radio" id="9_Client_StockInvestments_Estimated_Value_Reset" name="9_Client_StockInvestments_Estimated_Value_Select_Reset" class="StockInvestments_Estimated_Value_Select_Reset" value="Reset" onclick="resetBalanceInput(this, '9', 'Client');"> Reset to Default (50%)</label>
                                    </div>
                                </div>

                                <div class="form-group col-sm-6 Client_StockInvestments_Paying_Party9_Inputs_Div" style="display: none;">
                                    <label>Client StockInvestments Paying Party9</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Client_StockInvestments_Paying_Party9_Client" name="Client_StockInvestments_Paying_Party9" value="{{$client_name}}" onchange="getStockInvestmentPayingParty(this, '9', 'Client');"> {{$client_name}}</label>
                                        <label><input type="radio" id="Client_StockInvestments_Paying_Party9_Op" name="Client_StockInvestments_Paying_Party9" value="{{$opponent_name}}" onchange="getStockInvestmentPayingParty(this, '9', 'Client');"> {{$opponent_name}}</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 Client_StockInvestments_Paying_Party9_Inputs_Div" style="display: none;">
                                    <label>{{$client_name}} StockInvestment Equity Percent</label>
                                    <input id="Client_StockInvestments_Percent_Marital_Equity_to_Client9" type="number" class="form-control 9_Client_clientpercentage_input clientpercentage_input" name="Client_StockInvestments_Percent_Marital_Equity_to_Client9" value="50.00" min="0.00" step="0.01" max="100" readonly="">
                                </div>
                                <div class="form-group col-sm-6 Client_StockInvestments_Paying_Party9_Inputs_Div" style="display: none;">
                                    <label>How much is to be paid to {{$client_name}}?</label>
                                    <input id="Client_StockInvestments_Estimated_Value_to_Client9" type="number" class="form-control 9_Client_clientamount_input clientamount_input" name="Client_StockInvestments_Estimated_Value_to_Client9" value="" min="0.00" step="0.01" max="999999.99" readonly="" onchange="getEstimatedValueClient(this, '9', 'Client');" onkeyup="getEstimatedValueClient(this, '9', 'Client');">
                                </div>
                                <div class="form-group col-sm-6 Client_StockInvestments_Paying_Party9_Inputs_Div" style="display: none;">
                                    <label>{{$opponent_name}} StockInvestment Equity Percent</label>
                                    <input id="Client_StockInvestments_Percent_Marital_Equity_to_Op9" type="number" class="form-control 9_Client_opponentpercentage_input opponentpercentage_input" name="Client_StockInvestments_Percent_Marital_Equity_to_Op9" value="50.00" min="0.00" step="0.01" max="100" readonly="">
                                </div>
                                <div class="form-group col-sm-6 Client_StockInvestments_Paying_Party9_Inputs_Div" style="display: none;">
                                    <label>How much is to be paid to {{$opponent_name}}?</label>
                                    <input id="Client_StockInvestments_Estimated_Value_to_Op9" type="number" class="form-control 9_Client_opponentamount_input opponentamount_input" name="Client_StockInvestments_Estimated_Value_to_Op9" value="" min="0.00" step="0.01" max="999999.99" readonly="" onchange="getEstimatedValueOp(this, '9', 'Client');" onkeyup="getEstimatedValueOp(this, '9', 'Client');">
                                </div>
                                <!-- end of slider tool -->
                            </div>
                            <div class="col-sm-12 mt-4 10_Client_stocksinvestments_section" style="display: none;"><h5 class="col-sm-12">Tenth Stock Investment Info</h5>
                                <div class="form-group col-sm-6">
                                    <p class="text-danger 10_Client_no-state-county-found" style="display: none;">No City, State, County found for this zipcode.</p>
                                    <label for="Client_StockInvestments_Institution_ZIP10">Stock/Investment Institution Zip Code?</label>
                                    <input id="Client_StockInvestments_Institution_ZIP10" type="text" class="form-control 10_Client_stocksinvestments_inputs" name="Client_StockInvestments_Institution_ZIP10" value="" onkeyup="getCityStateForZip(this, '10_Client');"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_StockInvestments_Institution_Name10">Name of Stock/Investment Institution?</label>
                                    <input id="Client_StockInvestments_Institution_Name10" type="text" class="form-control 10_Client_stocksinvestments_inputs" name="Client_StockInvestments_Institution_Name10" value=""> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_StockInvestments_Institution_Street_Address10">Stock/Investment Institution Street Address?</label>
                                    <input id="Client_StockInvestments_Institution_Street_Address10" type="text" class="form-control 10_Client_stocksinvestments_inputs" name="Client_StockInvestments_Institution_Street_Address10" value=""> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_StockInvestments_Institution_City10">Stock/Investment Institution City?</label>
                                    <select id="Client_StockInvestments_Institution_City10" name="Client_StockInvestments_Institution_City10" class="form-control 10_Client_city_select">
                                        <option value="">Choose City</option>
                                    </select>   
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_StockInvestments_Institution_State10">Stock/Investment Institution State?</label>
                                    <select id="Client_StockInvestments_Institution_State10" name="Client_StockInvestments_Institution_State10" class="form-control 10_Client_state_select">
                                        <option value="">Choose State</option>
                                    </select>   
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_StockInvestments_Acct_Num10">Account Number?</label>
                                    <input id="Client_StockInvestments_Acct_Num10" type="text" class="form-control 10_Client_stocksinvestments_inputs" name="Client_StockInvestments_Acct_Num10" value=""> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_StockInvestments_Date_Marriage_Value10">Marriage Date Value?</label>
                                    <input id="Client_StockInvestments_Date_Marriage_Value10" type="number" class="form-control 10_Client_stocksinvestments_inputs" name="Client_StockInvestments_Date_Marriage_Value10" value="0.00" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_StockInvestments_Current_Value10">Current Value?</label>
                                    <input id="Client_StockInvestments_Current_Value10" type="number" class="form-control 10_Client_stocksinvestments_inputs" name="Client_StockInvestments_Current_Value10" value="0.00" min="0.00" step="0.01" max="999999.99" onchange="getJointCurrentValue(this, '10', 'Client');" onkeyup="getJointCurrentValue(this, '10', 'Client');"> 
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label for="Client_StockInvestments_Percent_Marital_Equity10">N/A, calculated = Client_StockInvestments_Institution_Current_Value10</label>
                                    <input id="Client_StockInvestments_Percent_Marital_Equity10" type="number" class="form-control 10_Client_stocksinvestments_inputs" name="Client_StockInvestments_Percent_Marital_Equity10" value="" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_StockInvestments_Yearly_Interest_Dividend10">Yearly Interest and Dividends from this account?</label>
                                    <input id="Client_StockInvestments_Yearly_Interest_Dividend10" type="number" class="form-control 10_Client_stocksinvestments_inputs" name="Client_StockInvestments_Yearly_Interest_Dividend10" value="0.00" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Does either party claim a sole/separate interest from the other on this account?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Client_StockInvestments_SoleSeparate_Claim10_Yes" name="Client_StockInvestments_SoleSeparate_Claim10" value="Yes" onchange="getPartyClaimSoleSeparate(this, '10', 'Client');"> Yes</label>
                                        <label><input type="radio" id="Client_StockInvestments_SoleSeparate_Claim10_No" name="Client_StockInvestments_SoleSeparate_Claim10" value="No" checked="" onchange="getPartyClaimSoleSeparate(this, '10', 'Client');"> No</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6" id="Client_StockInvestments_SoleSeparate_Party10_Div" style="display: none;">
                                    <label>Who claims to own this account?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Client_StockInvestments_SoleSeparate_Party10_Client" name="Client_StockInvestments_SoleSeparate_Party10" value="{{$client_name}}"> {{$client_name}}</label>
                                        <label><input type="radio" id="Client_StockInvestments_SoleSeparate_Party10_Op" name="Client_StockInvestments_SoleSeparate_Party10" value="{{$opponent_name}}" checked=""> {{$opponent_name}}</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 left-clear" id="Client_StockInvestments_SoleSeparate_Grounds10_Div" style="display: none; clear: left;">
                                    <label for="Client_StockInvestments_SoleSeparate_Grounds10">Why does this person own this account solely and separately?</label>
                                    <input id="Client_StockInvestments_SoleSeparate_Grounds10" type="text" class="form-control 10_Client_stocksinvestments_inputs" name="Client_StockInvestments_SoleSeparate_Grounds10" value=""> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>How will this account value be distributed between the parties?</label>
                                    <div class="w-100 dataInput">
                                        <label><input type="radio" id="Client_StockInvestments_Disposition_Method10_Distribute Investments" name="Client_StockInvestments_Disposition_Method10" value="Distribute Investments" onchange="getDipositionMethod(this, '10', 'Client');"> Distribute Investments</label>
                                        <label><input type="radio" id="Client_StockInvestments_Disposition_Method10_Liquidate/Split Net Value" name="Client_StockInvestments_Disposition_Method10" value="Liquidate/Split Net Value" onchange="getDipositionMethod(this, '10', 'Client');"> Liquidate/Split Net Value</label>
                                        <label><input type="radio" id="Client_StockInvestments_Disposition_Method10_Percentage Buyout" name="Client_StockInvestments_Disposition_Method10" value="Percentage Buyout" onchange="getDipositionMethod(this, '10', 'Client');"> Percentage Buyout</label>
                                        <label><input type="radio" id="Client_StockInvestments_Disposition_Method10_Fixed Buyout" name="Client_StockInvestments_Disposition_Method10" value="Fixed Buyout" onchange="getDipositionMethod(this, '10', 'Client');"> Fixed Buyout</label>
                                    </div>
                                </div>
                                <!-- slider tool -->
                                <div class="form-group col-sm-6 m-auto 10_Client_Slider_Tool slider-tool-main">
                                    <div class="row">
                                        <div class="col">{{$client_name}}</div>
                                        <div class="col text-right">{{$opponent_name}}</div>
                                    </div>
                                    <input id="10_Client_balance_range_selector" type="range" class="form-control slider-tool-input 10_Client_balance_range_selector" name="" value="50.00" min="0.00" step="0.01" max="100" onchange="updateBalanceInput(this.value, '10', 'Client');">
                                </div>
                                <div class="form-group col-sm-6 m-auto 10_Client_Slider_Tool slider-tool-main">
                                    <div class="row justify-content-between">
                                        <div class="col selectorTool">
                                            <div class="left-col">
                                                <div class="client-info 10_Client_clientpercentage_div clientpercentage_div">
                                                    50.00%
                                                </div>
                                                <div class="client-info 10_Client_clientamount_div clientamount_div" style="clear: both;">
                                                    $0
                                                </div>
                                            </div>
                                            <label>To {{$client_name}}</label>
                                        </div>                                       
                                        <div class="col selectorTool selectorToolRight">
                                            <label>To {{$opponent_name}}</label>
                                            <div class="left-col right-col">
                                                <div class="client-info 10_Client_opponentpercentage_div opponentpercentage_div">
                                                    50.00%
                                                </div>
                                                <div class="client-info 10_Client_opponentamount_div opponentamount_div" style="clear: both;">
                                                    $0
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 m-auto 10_Client_Slider_Tool slider-tool-main">
                                    <label></label>
                                    <div class="w-100">
                                        <label><input type="radio" id="10_Client_StockInvestments_Estimated_Value_Select" name="10_Client_StockInvestments_Estimated_Value_Select_Reset" class="StockInvestments_Estimated_Value_Select_Reset" value="Save"> Save this Distribution of StockInvestment Account #10</label>
                                        <label><input type="radio" id="10_Client_StockInvestments_Estimated_Value_Reset" name="10_Client_StockInvestments_Estimated_Value_Select_Reset" class="StockInvestments_Estimated_Value_Select_Reset" value="Reset" onclick="resetBalanceInput(this, '10', 'Client');"> Reset to Default (50%)</label>
                                    </div>
                                </div>

                                <div class="form-group col-sm-6 Client_StockInvestments_Paying_Party10_Inputs_Div" style="display: none;">
                                    <label>Client StockInvestments Paying Party10</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Client_StockInvestments_Paying_Party10_Client" name="Client_StockInvestments_Paying_Party10" value="{{$client_name}}" onchange="getStockInvestmentPayingParty(this, '10', 'Client');"> {{$client_name}}</label>
                                        <label><input type="radio" id="Client_StockInvestments_Paying_Party10_Op" name="Client_StockInvestments_Paying_Party10" value="{{$opponent_name}}" onchange="getStockInvestmentPayingParty(this, '10', 'Client');"> {{$opponent_name}}</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 Client_StockInvestments_Paying_Party10_Inputs_Div" style="display: none;">
                                    <label>{{$client_name}} StockInvestment Equity Percent</label>
                                    <input id="Client_StockInvestments_Percent_Marital_Equity_to_Client10" type="number" class="form-control 10_Client_clientpercentage_input clientpercentage_input" name="Client_StockInvestments_Percent_Marital_Equity_to_Client10" value="50.00" min="0.00" step="0.01" max="100" readonly="">
                                </div>
                                <div class="form-group col-sm-6 Client_StockInvestments_Paying_Party10_Inputs_Div" style="display: none;">
                                    <label>How much is to be paid to {{$client_name}}?</label>
                                    <input id="Client_StockInvestments_Estimated_Value_to_Client10" type="number" class="form-control 10_Client_clientamount_input clientamount_input" name="Client_StockInvestments_Estimated_Value_to_Client10" value="" min="0.00" step="0.01" max="999999.99" readonly="" onchange="getEstimatedValueClient(this, '10', 'Client');" onkeyup="getEstimatedValueClient(this, '10', 'Client');">
                                </div>
                                <div class="form-group col-sm-6 Client_StockInvestments_Paying_Party10_Inputs_Div" style="display: none;">
                                    <label>{{$opponent_name}} StockInvestment Equity Percent</label>
                                    <input id="Client_StockInvestments_Percent_Marital_Equity_to_Op10" type="number" class="form-control 10_Client_opponentpercentage_input opponentpercentage_input" name="Client_StockInvestments_Percent_Marital_Equity_to_Op10" value="50.00" min="0.00" step="0.01" max="100" readonly="">
                                </div>
                                <div class="form-group col-sm-6 Client_StockInvestments_Paying_Party10_Inputs_Div" style="display: none;">
                                    <label>How much is to be paid to {{$opponent_name}}?</label>
                                    <input id="Client_StockInvestments_Estimated_Value_to_Op10" type="number" class="form-control 10_Client_opponentamount_input opponentamount_input" name="Client_StockInvestments_Estimated_Value_to_Op10" value="" min="0.00" step="0.01" max="999999.99" readonly="" onchange="getEstimatedValueOp(this, '10', 'Client');" onkeyup="getEstimatedValueOp(this, '10', 'Client');">
                                </div>
                                <!-- end of slider tool -->
                            </div>
                        </div>
                        <!-- End of Client Stocks Investments Info Section -->

                        <!-- Opponent Stocks Investments Info Section -->
                        <div class="form-row num_Op_stocksinvestments_info mt-4" style="display: none;">
                            <h4 class="col-sm-12">{{$opponent_name}} Stocks Investments Info Section</h4>
                            <div class="col-sm-6">
                                <label for="Num_Op_StockInvestments_Accounts">How many deposit accounts in {{$opponent_name}}’s name only?</label>
                                <input id="Num_Op_StockInvestments_Accounts" type="number" class="form-control" name="Num_Op_StockInvestments_Accounts" value="<?php if(isset($drcaseoverview->Num_Op_StockInvestments_Accounts)){ echo $drcaseoverview->Num_Op_StockInvestments_Accounts; } ?>" min="0" max="10"> 
                            </div>
                        </div>
                        <div class="form-row Opponent_stocksinvestments_section">
                            <div class="col-sm-12 mt-4 1_Op_stocksinvestments_section" style="display: none;"><h5 class="col-sm-12">First Stock Investment Info</h5>
                                <div class="form-group col-sm-6">
                                    <p class="text-danger 1_Op_no-state-county-found" style="display: none;">No City, State, County found for this zipcode.</p>
                                    <label for="Op_StockInvestments_Institution_ZIP1">Stock/Investment Institution Zip Code?</label>
                                    <input id="Op_StockInvestments_Institution_ZIP1" type="text" class="form-control 1_Op_stocksinvestments_inputs" name="Op_StockInvestments_Institution_ZIP1" value="" onkeyup="getCityStateForZip(this, '1_Op');"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_StockInvestments_Institution_Name1">Name of Stock/Investment Institution?</label>
                                    <input id="Op_StockInvestments_Institution_Name1" type="text" class="form-control 1_Op_stocksinvestments_inputs" name="Op_StockInvestments_Institution_Name1" value=""> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_StockInvestments_Institution_Street_Address1">Stock/Investment Institution Street Address?</label>
                                    <input id="Op_StockInvestments_Institution_Street_Address1" type="text" class="form-control 1_Op_stocksinvestments_inputs" name="Op_StockInvestments_Institution_Street_Address1" value=""> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_StockInvestments_Institution_City1">Stock/Investment Institution City?</label>
                                    <select id="Op_StockInvestments_Institution_City1" name="Op_StockInvestments_Institution_City1" class="form-control 1_Op_city_select">
                                        <option value="">Choose City</option>
                                    </select>   
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_StockInvestments_Institution_State1">Stock/Investment Institution State?</label>
                                    <select id="Op_StockInvestments_Institution_State1" name="Op_StockInvestments_Institution_State1" class="form-control 1_Op_state_select">
                                        <option value="">Choose State</option>
                                    </select>   
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_StockInvestments_Acct_Num1">Account Number?</label>
                                    <input id="Op_StockInvestments_Acct_Num1" type="text" class="form-control 1_Op_stocksinvestments_inputs" name="Op_StockInvestments_Acct_Num1" value=""> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_StockInvestments_Date_Marriage_Value1">Marriage Date Value?</label>
                                    <input id="Op_StockInvestments_Date_Marriage_Value1" type="number" class="form-control 1_Op_stocksinvestments_inputs" name="Op_StockInvestments_Date_Marriage_Value1" value="0.00" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_StockInvestments_Current_Value1">Current Value?</label>
                                    <input id="Op_StockInvestments_Current_Value1" type="number" class="form-control 1_Op_stocksinvestments_inputs" name="Op_StockInvestments_Current_Value1" value="0.00" min="0.00" step="0.01" max="999999.99" onchange="getJointCurrentValue(this, '1', 'Op');" onkeyup="getJointCurrentValue(this, '1', 'Op');"> 
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label for="Op_StockInvestments_Percent_Marital_Equity1">N/A, calculated = Op_StockInvestments_Institution_Current_Value1</label>
                                    <input id="Op_StockInvestments_Percent_Marital_Equity1" type="number" class="form-control 1_Op_stocksinvestments_inputs" name="Op_StockInvestments_Percent_Marital_Equity1" value="" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_StockInvestments_Yearly_Interest_Dividend1">Yearly Interest and Dividends from this account?</label>
                                    <input id="Op_StockInvestments_Yearly_Interest_Dividend1" type="number" class="form-control 1_Op_stocksinvestments_inputs" name="Op_StockInvestments_Yearly_Interest_Dividend1" value="0.00" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Does either party claim a sole/separate interest from the other on this account?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Op_StockInvestments_SoleSeparate_Claim1_Yes" name="Op_StockInvestments_SoleSeparate_Claim1" value="Yes" onchange="getPartyClaimSoleSeparate(this, '1', 'Op');"> Yes</label>
                                        <label><input type="radio" id="Op_StockInvestments_SoleSeparate_Claim1_No" name="Op_StockInvestments_SoleSeparate_Claim1" value="No" checked="" onchange="getPartyClaimSoleSeparate(this, '1', 'Op');"> No</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6" id="Op_StockInvestments_SoleSeparate_Party1_Div" style="display: none;">
                                    <label>Who claims to own this account?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Op_StockInvestments_SoleSeparate_Party1_Client" name="Op_StockInvestments_SoleSeparate_Party1" value="{{$client_name}}"> {{$client_name}}</label>
                                        <label><input type="radio" id="Op_StockInvestments_SoleSeparate_Party1_Op" name="Op_StockInvestments_SoleSeparate_Party1" value="{{$opponent_name}}" checked=""> {{$opponent_name}}</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 left-clear" id="Op_StockInvestments_SoleSeparate_Grounds1_Div" style="display: none; clear: left;">
                                    <label for="Op_StockInvestments_SoleSeparate_Grounds1">Why does this person own this account solely and separately?</label>
                                    <input id="Op_StockInvestments_SoleSeparate_Grounds1" type="text" class="form-control 1_Op_stocksinvestments_inputs" name="Op_StockInvestments_SoleSeparate_Grounds1" value=""> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>How will this account value be distributed between the parties?</label>
                                    <div class="w-100 dataInput">
                                        <label><input type="radio" id="Op_StockInvestments_Disposition_Method1_Distribute Investments" name="Op_StockInvestments_Disposition_Method1" value="Distribute Investments" onchange="getDipositionMethod(this, '1', 'Op');"> Distribute Investments</label>
                                        <label><input type="radio" id="Op_StockInvestments_Disposition_Method1_Liquidate/Split Net Value" name="Op_StockInvestments_Disposition_Method1" value="Liquidate/Split Net Value" onchange="getDipositionMethod(this, '1', 'Op');"> Liquidate/Split Net Value</label>
                                        <label><input type="radio" id="Op_StockInvestments_Disposition_Method1_Percentage Buyout" name="Op_StockInvestments_Disposition_Method1" value="Percentage Buyout" onchange="getDipositionMethod(this, '1', 'Op');"> Percentage Buyout</label>
                                        <label><input type="radio" id="Op_StockInvestments_Disposition_Method1_Fixed Buyout" name="Op_StockInvestments_Disposition_Method1" value="Fixed Buyout" onchange="getDipositionMethod(this, '1', 'Op');"> Fixed Buyout</label>
                                    </div>
                                </div>
                                <!-- slider tool -->
                                <div class="form-group col-sm-6 m-auto 1_Op_Slider_Tool slider-tool-main">
                                    <div class="row">
                                        <div class="col">{{$client_name}}</div>
                                        <div class="col text-right">{{$opponent_name}}</div>
                                    </div>
                                    <input id="1_Op_balance_range_selector" type="range" class="form-control slider-tool-input 1_Op_balance_range_selector" name="" value="50.00" min="0.00" step="0.01" max="100" onchange="updateBalanceInput(this.value, '1', 'Op');">
                                </div>
                                <div class="form-group col-sm-6 m-auto 1_Op_Slider_Tool slider-tool-main">
                                    <div class="row justify-content-between">
                                        <div class="col selectorTool">
                                            <div class="left-col">
                                                <div class="client-info 1_Op_clientpercentage_div clientpercentage_div">
                                                    50.00%
                                                </div>
                                                <div class="client-info 1_Op_clientamount_div clientamount_div" style="clear: both;">
                                                    $0
                                                </div>
                                            </div>
                                            <label>To {{$client_name}}</label>
                                        </div>                                       
                                        <div class="col selectorTool selectorToolRight">
                                            <label>To {{$opponent_name}}</label>
                                            <div class="left-col right-col">
                                                <div class="client-info 1_Op_opponentpercentage_div opponentpercentage_div">
                                                    50.00%
                                                </div>
                                                <div class="client-info 1_Op_opponentamount_div opponentamount_div" style="clear: both;">
                                                    $0
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 m-auto 1_Op_Slider_Tool slider-tool-main">
                                    <label></label>
                                    <div class="w-100">
                                        <label><input type="radio" id="1_Op_StockInvestments_Estimated_Value_Select" name="1_Op_StockInvestments_Estimated_Value_Select_Reset" class="StockInvestments_Estimated_Value_Select_Reset" value="Save"> Save this Distribution of StockInvestment Account #1</label>
                                        <label><input type="radio" id="1_Op_StockInvestments_Estimated_Value_Reset" name="1_Op_StockInvestments_Estimated_Value_Select_Reset" class="StockInvestments_Estimated_Value_Select_Reset" value="Reset" onclick="resetBalanceInput(this, '1', 'Op');"> Reset to Default (50%)</label>
                                    </div>
                                </div>

                                <div class="form-group col-sm-6 Op_StockInvestments_Paying_Party1_Inputs_Div" style="display: none;">
                                    <label>Op StockInvestments Paying Party1</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Op_StockInvestments_Paying_Party1_Client" name="Op_StockInvestments_Paying_Party1" value="{{$client_name}}" onchange="getStockInvestmentPayingParty(this, '1', 'Op');"> {{$client_name}}</label>
                                        <label><input type="radio" id="Op_StockInvestments_Paying_Party1_Op" name="Op_StockInvestments_Paying_Party1" value="{{$opponent_name}}" onchange="getStockInvestmentPayingParty(this, '1', 'Op');"> {{$opponent_name}}</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 Op_StockInvestments_Paying_Party1_Inputs_Div" style="display: none;">
                                    <label>{{$client_name}} StockInvestment Equity Percent</label>
                                    <input id="Op_StockInvestments_Percent_Marital_Equity_to_Client1" type="number" class="form-control 1_Op_clientpercentage_input clientpercentage_input" name="Op_StockInvestments_Percent_Marital_Equity_to_Client1" value="50.00" min="0.00" step="0.01" max="100" readonly="">
                                </div>
                                <div class="form-group col-sm-6 Op_StockInvestments_Paying_Party1_Inputs_Div" style="display: none;">
                                    <label>How much is to be paid to {{$client_name}}?</label>
                                    <input id="Op_StockInvestments_Estimated_Value_to_Client1" type="number" class="form-control 1_Op_clientamount_input clientamount_input" name="Op_StockInvestments_Estimated_Value_to_Client1" value="" min="0.00" step="0.01" max="999999.99" readonly="" onchange="getEstimatedValueClient(this, '1', 'Op');" onkeyup="getEstimatedValueClient(this, '1', 'Op');">
                                </div>
                                <div class="form-group col-sm-6 Op_StockInvestments_Paying_Party1_Inputs_Div" style="display: none;">
                                    <label>{{$opponent_name}} StockInvestment Equity Percent</label>
                                    <input id="Op_StockInvestments_Percent_Marital_Equity_to_Op1" type="number" class="form-control 1_Op_opponentpercentage_input opponentpercentage_input" name="Op_StockInvestments_Percent_Marital_Equity_to_Op1" value="50.00" min="0.00" step="0.01" max="100" readonly="">
                                </div>
                                <div class="form-group col-sm-6 Op_StockInvestments_Paying_Party1_Inputs_Div" style="display: none;">
                                    <label>How much is to be paid to {{$opponent_name}}?</label>
                                    <input id="Op_StockInvestments_Estimated_Value_to_Op1" type="number" class="form-control 1_Op_opponentamount_input opponentamount_input" name="Op_StockInvestments_Estimated_Value_to_Op1" value="" min="0.00" step="0.01" max="999999.99" readonly="" onchange="getEstimatedValueOp(this, '1', 'Op');" onkeyup="getEstimatedValueOp(this, '1', 'Op');">
                                </div>
                                <!-- end of slider tool -->
                            </div>
                            <div class="col-sm-12 mt-4 2_Op_stocksinvestments_section" style="display: none;"><h5 class="col-sm-12">Second Stock Investment Info</h5>
                                <div class="form-group col-sm-6">
                                    <p class="text-danger 2_Op_no-state-county-found" style="display: none;">No City, State, County found for this zipcode.</p>
                                    <label for="Op_StockInvestments_Institution_ZIP2">Stock/Investment Institution Zip Code?</label>
                                    <input id="Op_StockInvestments_Institution_ZIP2" type="text" class="form-control 2_Op_stocksinvestments_inputs" name="Op_StockInvestments_Institution_ZIP2" value="" onkeyup="getCityStateForZip(this, '2_Op');"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_StockInvestments_Institution_Name2">Name of Stock/Investment Institution?</label>
                                    <input id="Op_StockInvestments_Institution_Name2" type="text" class="form-control 2_Op_stocksinvestments_inputs" name="Op_StockInvestments_Institution_Name2" value=""> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_StockInvestments_Institution_Street_Address2">Stock/Investment Institution Street Address?</label>
                                    <input id="Op_StockInvestments_Institution_Street_Address2" type="text" class="form-control 2_Op_stocksinvestments_inputs" name="Op_StockInvestments_Institution_Street_Address2" value=""> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_StockInvestments_Institution_City2">Stock/Investment Institution City?</label>
                                    <select id="Op_StockInvestments_Institution_City2" name="Op_StockInvestments_Institution_City2" class="form-control 2_Op_city_select">
                                        <option value="">Choose City</option>
                                    </select>   
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_StockInvestments_Institution_State2">Stock/Investment Institution State?</label>
                                    <select id="Op_StockInvestments_Institution_State2" name="Op_StockInvestments_Institution_State2" class="form-control 2_Op_state_select">
                                        <option value="">Choose State</option>
                                    </select>   
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_StockInvestments_Acct_Num2">Account Number?</label>
                                    <input id="Op_StockInvestments_Acct_Num2" type="text" class="form-control 2_Op_stocksinvestments_inputs" name="Op_StockInvestments_Acct_Num2" value=""> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_StockInvestments_Date_Marriage_Value2">Marriage Date Value?</label>
                                    <input id="Op_StockInvestments_Date_Marriage_Value2" type="number" class="form-control 2_Op_stocksinvestments_inputs" name="Op_StockInvestments_Date_Marriage_Value2" value="0.00" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_StockInvestments_Current_Value2">Current Value?</label>
                                    <input id="Op_StockInvestments_Current_Value2" type="number" class="form-control 2_Op_stocksinvestments_inputs" name="Op_StockInvestments_Current_Value2" value="0.00" min="0.00" step="0.01" max="999999.99" onchange="getJointCurrentValue(this, '2', 'Op');" onkeyup="getJointCurrentValue(this, '2', 'Op');"> 
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label for="Op_StockInvestments_Percent_Marital_Equity2">N/A, calculated = Op_StockInvestments_Institution_Current_Value2</label>
                                    <input id="Op_StockInvestments_Percent_Marital_Equity2" type="number" class="form-control 2_Op_stocksinvestments_inputs" name="Op_StockInvestments_Percent_Marital_Equity2" value="" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_StockInvestments_Yearly_Interest_Dividend2">Yearly Interest and Dividends from this account?</label>
                                    <input id="Op_StockInvestments_Yearly_Interest_Dividend2" type="number" class="form-control 2_Op_stocksinvestments_inputs" name="Op_StockInvestments_Yearly_Interest_Dividend2" value="0.00" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Does either party claim a sole/separate interest from the other on this account?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Op_StockInvestments_SoleSeparate_Claim2_Yes" name="Op_StockInvestments_SoleSeparate_Claim2" value="Yes" onchange="getPartyClaimSoleSeparate(this, '2', 'Op');"> Yes</label>
                                        <label><input type="radio" id="Op_StockInvestments_SoleSeparate_Claim2_No" name="Op_StockInvestments_SoleSeparate_Claim2" value="No" checked="" onchange="getPartyClaimSoleSeparate(this, '2', 'Op');"> No</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6" id="Op_StockInvestments_SoleSeparate_Party2_Div" style="display: none;">
                                    <label>Who claims to own this account?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Op_StockInvestments_SoleSeparate_Party2_Client" name="Op_StockInvestments_SoleSeparate_Party2" value="{{$client_name}}"> {{$client_name}}</label>
                                        <label><input type="radio" id="Op_StockInvestments_SoleSeparate_Party2_Op" name="Op_StockInvestments_SoleSeparate_Party2" value="{{$opponent_name}}" checked=""> {{$opponent_name}}</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 left-clear" id="Op_StockInvestments_SoleSeparate_Grounds2_Div" style="display: none; clear: left;">
                                    <label for="Op_StockInvestments_SoleSeparate_Grounds2">Why does this person own this account solely and separately?</label>
                                    <input id="Op_StockInvestments_SoleSeparate_Grounds2" type="text" class="form-control 2_Op_stocksinvestments_inputs" name="Op_StockInvestments_SoleSeparate_Grounds2" value=""> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>How will this account value be distributed between the parties?</label>
                                    <div class="w-100 dataInput">
                                        <label><input type="radio" id="Op_StockInvestments_Disposition_Method2_Distribute Investments" name="Op_StockInvestments_Disposition_Method2" value="Distribute Investments" onchange="getDipositionMethod(this, '2', 'Op');"> Distribute Investments</label>
                                        <label><input type="radio" id="Op_StockInvestments_Disposition_Method2_Liquidate/Split Net Value" name="Op_StockInvestments_Disposition_Method2" value="Liquidate/Split Net Value" onchange="getDipositionMethod(this, '2', 'Op');"> Liquidate/Split Net Value</label>
                                        <label><input type="radio" id="Op_StockInvestments_Disposition_Method2_Percentage Buyout" name="Op_StockInvestments_Disposition_Method2" value="Percentage Buyout" onchange="getDipositionMethod(this, '2', 'Op');"> Percentage Buyout</label>
                                        <label><input type="radio" id="Op_StockInvestments_Disposition_Method2_Fixed Buyout" name="Op_StockInvestments_Disposition_Method2" value="Fixed Buyout" onchange="getDipositionMethod(this, '2', 'Op');"> Fixed Buyout</label>
                                    </div>
                                </div>
                                <!-- slider tool -->
                                <div class="form-group col-sm-6 m-auto 2_Op_Slider_Tool slider-tool-main">
                                    <div class="row">
                                        <div class="col">{{$client_name}}</div>
                                        <div class="col text-right">{{$opponent_name}}</div>
                                    </div>
                                    <input id="2_Op_balance_range_selector" type="range" class="form-control slider-tool-input 2_Op_balance_range_selector" name="" value="50.00" min="0.00" step="0.01" max="100" onchange="updateBalanceInput(this.value, '2', 'Op');">
                                </div>
                                <div class="form-group col-sm-6 m-auto 2_Op_Slider_Tool slider-tool-main">
                                    <div class="row justify-content-between">
                                        <div class="col selectorTool">
                                            <div class="left-col">
                                                <div class="client-info 2_Op_clientpercentage_div clientpercentage_div">
                                                    50.00%
                                                </div>
                                                <div class="client-info 2_Op_clientamount_div clientamount_div" style="clear: both;">
                                                    $0
                                                </div>
                                            </div>
                                            <label>To {{$client_name}}</label>
                                        </div>                                       
                                        <div class="col selectorTool selectorToolRight">
                                            <label>To {{$opponent_name}}</label>
                                            <div class="left-col right-col">
                                                <div class="client-info 2_Op_opponentpercentage_div opponentpercentage_div">
                                                    50.00%
                                                </div>
                                                <div class="client-info 2_Op_opponentamount_div opponentamount_div" style="clear: both;">
                                                    $0
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 m-auto 2_Op_Slider_Tool slider-tool-main">
                                    <label></label>
                                    <div class="w-100">
                                        <label><input type="radio" id="2_Op_StockInvestments_Estimated_Value_Select" name="2_Op_StockInvestments_Estimated_Value_Select_Reset" class="StockInvestments_Estimated_Value_Select_Reset" value="Save"> Save this Distribution of StockInvestment Account #2</label>
                                        <label><input type="radio" id="2_Op_StockInvestments_Estimated_Value_Reset" name="2_Op_StockInvestments_Estimated_Value_Select_Reset" class="StockInvestments_Estimated_Value_Select_Reset" value="Reset" onclick="resetBalanceInput(this, '2', 'Op');"> Reset to Default (50%)</label>
                                    </div>
                                </div>

                                <div class="form-group col-sm-6 Op_StockInvestments_Paying_Party2_Inputs_Div" style="display: none;">
                                    <label>Op StockInvestments Paying Party2</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Op_StockInvestments_Paying_Party2_Client" name="Op_StockInvestments_Paying_Party2" value="{{$client_name}}" onchange="getStockInvestmentPayingParty(this, '2', 'Op');"> {{$client_name}}</label>
                                        <label><input type="radio" id="Op_StockInvestments_Paying_Party2_Op" name="Op_StockInvestments_Paying_Party2" value="{{$opponent_name}}" onchange="getStockInvestmentPayingParty(this, '2', 'Op');"> {{$opponent_name}}</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 Op_StockInvestments_Paying_Party2_Inputs_Div" style="display: none;">
                                    <label>{{$client_name}} StockInvestment Equity Percent</label>
                                    <input id="Op_StockInvestments_Percent_Marital_Equity_to_Client2" type="number" class="form-control 2_Op_clientpercentage_input clientpercentage_input" name="Op_StockInvestments_Percent_Marital_Equity_to_Client2" value="50.00" min="0.00" step="0.01" max="100" readonly="">
                                </div>
                                <div class="form-group col-sm-6 Op_StockInvestments_Paying_Party2_Inputs_Div" style="display: none;">
                                    <label>How much is to be paid to {{$client_name}}?</label>
                                    <input id="Op_StockInvestments_Estimated_Value_to_Client2" type="number" class="form-control 2_Op_clientamount_input clientamount_input" name="Op_StockInvestments_Estimated_Value_to_Client2" value="" min="0.00" step="0.01" max="999999.99" readonly="" onchange="getEstimatedValueClient(this, '2', 'Op');" onkeyup="getEstimatedValueClient(this, '2', 'Op');">
                                </div>
                                <div class="form-group col-sm-6 Op_StockInvestments_Paying_Party2_Inputs_Div" style="display: none;">
                                    <label>{{$opponent_name}} StockInvestment Equity Percent</label>
                                    <input id="Op_StockInvestments_Percent_Marital_Equity_to_Op2" type="number" class="form-control 2_Op_opponentpercentage_input opponentpercentage_input" name="Op_StockInvestments_Percent_Marital_Equity_to_Op2" value="50.00" min="0.00" step="0.01" max="100" readonly="">
                                </div>
                                <div class="form-group col-sm-6 Op_StockInvestments_Paying_Party2_Inputs_Div" style="display: none;">
                                    <label>How much is to be paid to {{$opponent_name}}?</label>
                                    <input id="Op_StockInvestments_Estimated_Value_to_Op2" type="number" class="form-control 2_Op_opponentamount_input opponentamount_input" name="Op_StockInvestments_Estimated_Value_to_Op2" value="" min="0.00" step="0.01" max="999999.99" readonly="" onchange="getEstimatedValueOp(this, '2', 'Op');" onkeyup="getEstimatedValueOp(this, '2', 'Op');">
                                </div>
                                <!-- end of slider tool -->
                            </div>
                            <div class="col-sm-12 mt-4 3_Op_stocksinvestments_section" style="display: none;"><h5 class="col-sm-12">Third Stock Investment Info</h5>
                                <div class="form-group col-sm-6">
                                    <p class="text-danger 3_Op_no-state-county-found" style="display: none;">No City, State, County found for this zipcode.</p>
                                    <label for="Op_StockInvestments_Institution_ZIP3">Stock/Investment Institution Zip Code?</label>
                                    <input id="Op_StockInvestments_Institution_ZIP3" type="text" class="form-control 3_Op_stocksinvestments_inputs" name="Op_StockInvestments_Institution_ZIP3" value="" onkeyup="getCityStateForZip(this, '3_Op');"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_StockInvestments_Institution_Name3">Name of Stock/Investment Institution?</label>
                                    <input id="Op_StockInvestments_Institution_Name3" type="text" class="form-control 3_Op_stocksinvestments_inputs" name="Op_StockInvestments_Institution_Name3" value=""> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_StockInvestments_Institution_Street_Address3">Stock/Investment Institution Street Address?</label>
                                    <input id="Op_StockInvestments_Institution_Street_Address3" type="text" class="form-control 3_Op_stocksinvestments_inputs" name="Op_StockInvestments_Institution_Street_Address3" value=""> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_StockInvestments_Institution_City3">Stock/Investment Institution City?</label>
                                    <select id="Op_StockInvestments_Institution_City3" name="Op_StockInvestments_Institution_City3" class="form-control 3_Op_city_select">
                                        <option value="">Choose City</option>
                                    </select>   
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_StockInvestments_Institution_State3">Stock/Investment Institution State?</label>
                                    <select id="Op_StockInvestments_Institution_State3" name="Op_StockInvestments_Institution_State3" class="form-control 3_Op_state_select">
                                        <option value="">Choose State</option>
                                    </select>   
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_StockInvestments_Acct_Num3">Account Number?</label>
                                    <input id="Op_StockInvestments_Acct_Num3" type="text" class="form-control 3_Op_stocksinvestments_inputs" name="Op_StockInvestments_Acct_Num3" value=""> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_StockInvestments_Date_Marriage_Value3">Marriage Date Value?</label>
                                    <input id="Op_StockInvestments_Date_Marriage_Value3" type="number" class="form-control 3_Op_stocksinvestments_inputs" name="Op_StockInvestments_Date_Marriage_Value3" value="0.00" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_StockInvestments_Current_Value3">Current Value?</label>
                                    <input id="Op_StockInvestments_Current_Value3" type="number" class="form-control 3_Op_stocksinvestments_inputs" name="Op_StockInvestments_Current_Value3" value="0.00" min="0.00" step="0.01" max="999999.99" onchange="getJointCurrentValue(this, '3', 'Op');" onkeyup="getJointCurrentValue(this, '3', 'Op');"> 
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label for="Op_StockInvestments_Percent_Marital_Equity3">N/A, calculated = Op_StockInvestments_Institution_Current_Value3</label>
                                    <input id="Op_StockInvestments_Percent_Marital_Equity3" type="number" class="form-control 3_Op_stocksinvestments_inputs" name="Op_StockInvestments_Percent_Marital_Equity3" value="" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_StockInvestments_Yearly_Interest_Dividend3">Yearly Interest and Dividends from this account?</label>
                                    <input id="Op_StockInvestments_Yearly_Interest_Dividend3" type="number" class="form-control 3_Op_stocksinvestments_inputs" name="Op_StockInvestments_Yearly_Interest_Dividend3" value="0.00" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Does either party claim a sole/separate interest from the other on this account?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Op_StockInvestments_SoleSeparate_Claim3_Yes" name="Op_StockInvestments_SoleSeparate_Claim3" value="Yes" onchange="getPartyClaimSoleSeparate(this, '3', 'Op');"> Yes</label>
                                        <label><input type="radio" id="Op_StockInvestments_SoleSeparate_Claim3_No" name="Op_StockInvestments_SoleSeparate_Claim3" value="No" checked="" onchange="getPartyClaimSoleSeparate(this, '3', 'Op');"> No</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6" id="Op_StockInvestments_SoleSeparate_Party3_Div" style="display: none;">
                                    <label>Who claims to own this account?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Op_StockInvestments_SoleSeparate_Party3_Client" name="Op_StockInvestments_SoleSeparate_Party3" value="{{$client_name}}"> {{$client_name}}</label>
                                        <label><input type="radio" id="Op_StockInvestments_SoleSeparate_Party3_Op" name="Op_StockInvestments_SoleSeparate_Party3" value="{{$opponent_name}}" checked=""> {{$opponent_name}}</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 left-clear" id="Op_StockInvestments_SoleSeparate_Grounds3_Div" style="display: none; clear: left;">
                                    <label for="Op_StockInvestments_SoleSeparate_Grounds3">Why does this person own this account solely and separately?</label>
                                    <input id="Op_StockInvestments_SoleSeparate_Grounds3" type="text" class="form-control 3_Op_stocksinvestments_inputs" name="Op_StockInvestments_SoleSeparate_Grounds3" value=""> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>How will this account value be distributed between the parties?</label>
                                    <div class="w-100 dataInput">
                                        <label><input type="radio" id="Op_StockInvestments_Disposition_Method3_Distribute Investments" name="Op_StockInvestments_Disposition_Method3" value="Distribute Investments" onchange="getDipositionMethod(this, '3', 'Op');"> Distribute Investments</label>
                                        <label><input type="radio" id="Op_StockInvestments_Disposition_Method3_Liquidate/Split Net Value" name="Op_StockInvestments_Disposition_Method3" value="Liquidate/Split Net Value" onchange="getDipositionMethod(this, '3', 'Op');"> Liquidate/Split Net Value</label>
                                        <label><input type="radio" id="Op_StockInvestments_Disposition_Method3_Percentage Buyout" name="Op_StockInvestments_Disposition_Method3" value="Percentage Buyout" onchange="getDipositionMethod(this, '3', 'Op');"> Percentage Buyout</label>
                                        <label><input type="radio" id="Op_StockInvestments_Disposition_Method3_Fixed Buyout" name="Op_StockInvestments_Disposition_Method3" value="Fixed Buyout" onchange="getDipositionMethod(this, '3', 'Op');"> Fixed Buyout</label>
                                    </div>
                                </div>
                                <!-- slider tool -->
                                <div class="form-group col-sm-6 m-auto 3_Op_Slider_Tool slider-tool-main">
                                    <div class="row">
                                        <div class="col">{{$client_name}}</div>
                                        <div class="col text-right">{{$opponent_name}}</div>
                                    </div>
                                    <input id="3_Op_balance_range_selector" type="range" class="form-control slider-tool-input 3_Op_balance_range_selector" name="" value="50.00" min="0.00" step="0.01" max="100" onchange="updateBalanceInput(this.value, '3', 'Op');">
                                </div>
                                <div class="form-group col-sm-6 m-auto 3_Op_Slider_Tool slider-tool-main">
                                    <div class="row justify-content-between">
                                        <div class="col selectorTool">
                                            <div class="left-col">
                                                <div class="client-info 3_Op_clientpercentage_div clientpercentage_div">
                                                    50.00%
                                                </div>
                                                <div class="client-info 3_Op_clientamount_div clientamount_div" style="clear: both;">
                                                    $0
                                                </div>
                                            </div>
                                            <label>To {{$client_name}}</label>
                                        </div>                                       
                                        <div class="col selectorTool selectorToolRight">
                                            <label>To {{$opponent_name}}</label>
                                            <div class="left-col right-col">
                                                <div class="client-info 3_Op_opponentpercentage_div opponentpercentage_div">
                                                    50.00%
                                                </div>
                                                <div class="client-info 3_Op_opponentamount_div opponentamount_div" style="clear: both;">
                                                    $0
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 m-auto 3_Op_Slider_Tool slider-tool-main">
                                    <label></label>
                                    <div class="w-100">
                                        <label><input type="radio" id="3_Op_StockInvestments_Estimated_Value_Select" name="3_Op_StockInvestments_Estimated_Value_Select_Reset" class="StockInvestments_Estimated_Value_Select_Reset" value="Save"> Save this Distribution of StockInvestment Account #3</label>
                                        <label><input type="radio" id="3_Op_StockInvestments_Estimated_Value_Reset" name="3_Op_StockInvestments_Estimated_Value_Select_Reset" class="StockInvestments_Estimated_Value_Select_Reset" value="Reset" onclick="resetBalanceInput(this, '3', 'Op');"> Reset to Default (50%)</label>
                                    </div>
                                </div>

                                <div class="form-group col-sm-6 Op_StockInvestments_Paying_Party3_Inputs_Div" style="display: none;">
                                    <label>Op StockInvestments Paying Party3</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Op_StockInvestments_Paying_Party3_Client" name="Op_StockInvestments_Paying_Party3" value="{{$client_name}}" onchange="getStockInvestmentPayingParty(this, '3', 'Op');"> {{$client_name}}</label>
                                        <label><input type="radio" id="Op_StockInvestments_Paying_Party3_Op" name="Op_StockInvestments_Paying_Party3" value="{{$opponent_name}}" onchange="getStockInvestmentPayingParty(this, '3', 'Op');"> {{$opponent_name}}</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 Op_StockInvestments_Paying_Party3_Inputs_Div" style="display: none;">
                                    <label>{{$client_name}} StockInvestment Equity Percent</label>
                                    <input id="Op_StockInvestments_Percent_Marital_Equity_to_Client3" type="number" class="form-control 3_Op_clientpercentage_input clientpercentage_input" name="Op_StockInvestments_Percent_Marital_Equity_to_Client3" value="50.00" min="0.00" step="0.01" max="100" readonly="">
                                </div>
                                <div class="form-group col-sm-6 Op_StockInvestments_Paying_Party3_Inputs_Div" style="display: none;">
                                    <label>How much is to be paid to {{$client_name}}?</label>
                                    <input id="Op_StockInvestments_Estimated_Value_to_Client3" type="number" class="form-control 3_Op_clientamount_input clientamount_input" name="Op_StockInvestments_Estimated_Value_to_Client3" value="" min="0.00" step="0.01" max="999999.99" readonly="" onchange="getEstimatedValueClient(this, '3', 'Op');" onkeyup="getEstimatedValueClient(this, '3', 'Op');">
                                </div>
                                <div class="form-group col-sm-6 Op_StockInvestments_Paying_Party3_Inputs_Div" style="display: none;">
                                    <label>{{$opponent_name}} StockInvestment Equity Percent</label>
                                    <input id="Op_StockInvestments_Percent_Marital_Equity_to_Op3" type="number" class="form-control 3_Op_opponentpercentage_input opponentpercentage_input" name="Op_StockInvestments_Percent_Marital_Equity_to_Op3" value="50.00" min="0.00" step="0.01" max="100" readonly="">
                                </div>
                                <div class="form-group col-sm-6 Op_StockInvestments_Paying_Party3_Inputs_Div" style="display: none;">
                                    <label>How much is to be paid to {{$opponent_name}}?</label>
                                    <input id="Op_StockInvestments_Estimated_Value_to_Op3" type="number" class="form-control 3_Op_opponentamount_input opponentamount_input" name="Op_StockInvestments_Estimated_Value_to_Op3" value="" min="0.00" step="0.01" max="999999.99" readonly="" onchange="getEstimatedValueOp(this, '3', 'Op');" onkeyup="getEstimatedValueOp(this, '3', 'Op');">
                                </div>
                                <!-- end of slider tool -->
                            </div>
                            <div class="col-sm-12 mt-4 4_Op_stocksinvestments_section" style="display: none;"><h5 class="col-sm-12">Fourth Stock Investment Info</h5>
                                <div class="form-group col-sm-6">
                                    <p class="text-danger 4_Op_no-state-county-found" style="display: none;">No City, State, County found for this zipcode.</p>
                                    <label for="Op_StockInvestments_Institution_ZIP4">Stock/Investment Institution Zip Code?</label>
                                    <input id="Op_StockInvestments_Institution_ZIP4" type="text" class="form-control 4_Op_stocksinvestments_inputs" name="Op_StockInvestments_Institution_ZIP4" value="" onkeyup="getCityStateForZip(this, '4_Op');"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_StockInvestments_Institution_Name4">Name of Stock/Investment Institution?</label>
                                    <input id="Op_StockInvestments_Institution_Name4" type="text" class="form-control 4_Op_stocksinvestments_inputs" name="Op_StockInvestments_Institution_Name4" value=""> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_StockInvestments_Institution_Street_Address4">Stock/Investment Institution Street Address?</label>
                                    <input id="Op_StockInvestments_Institution_Street_Address4" type="text" class="form-control 4_Op_stocksinvestments_inputs" name="Op_StockInvestments_Institution_Street_Address4" value=""> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_StockInvestments_Institution_City4">Stock/Investment Institution City?</label>
                                    <select id="Op_StockInvestments_Institution_City4" name="Op_StockInvestments_Institution_City4" class="form-control 4_Op_city_select">
                                        <option value="">Choose City</option>
                                    </select>   
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_StockInvestments_Institution_State4">Stock/Investment Institution State?</label>
                                    <select id="Op_StockInvestments_Institution_State4" name="Op_StockInvestments_Institution_State4" class="form-control 4_Op_state_select">
                                        <option value="">Choose State</option>
                                    </select>   
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_StockInvestments_Acct_Num4">Account Number?</label>
                                    <input id="Op_StockInvestments_Acct_Num4" type="text" class="form-control 4_Op_stocksinvestments_inputs" name="Op_StockInvestments_Acct_Num4" value=""> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_StockInvestments_Date_Marriage_Value4">Marriage Date Value?</label>
                                    <input id="Op_StockInvestments_Date_Marriage_Value4" type="number" class="form-control 4_Op_stocksinvestments_inputs" name="Op_StockInvestments_Date_Marriage_Value4" value="0.00" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_StockInvestments_Current_Value4">Current Value?</label>
                                    <input id="Op_StockInvestments_Current_Value4" type="number" class="form-control 4_Op_stocksinvestments_inputs" name="Op_StockInvestments_Current_Value4" value="0.00" min="0.00" step="0.01" max="999999.99" onchange="getJointCurrentValue(this, '4', 'Op');" onkeyup="getJointCurrentValue(this, '4', 'Op');"> 
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label for="Op_StockInvestments_Percent_Marital_Equity4">N/A, calculated = Op_StockInvestments_Institution_Current_Value4</label>
                                    <input id="Op_StockInvestments_Percent_Marital_Equity4" type="number" class="form-control 4_Op_stocksinvestments_inputs" name="Op_StockInvestments_Percent_Marital_Equity4" value="" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_StockInvestments_Yearly_Interest_Dividend4">Yearly Interest and Dividends from this account?</label>
                                    <input id="Op_StockInvestments_Yearly_Interest_Dividend4" type="number" class="form-control 4_Op_stocksinvestments_inputs" name="Op_StockInvestments_Yearly_Interest_Dividend4" value="0.00" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Does either party claim a sole/separate interest from the other on this account?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Op_StockInvestments_SoleSeparate_Claim4_Yes" name="Op_StockInvestments_SoleSeparate_Claim4" value="Yes" onchange="getPartyClaimSoleSeparate(this, '4', 'Op');"> Yes</label>
                                        <label><input type="radio" id="Op_StockInvestments_SoleSeparate_Claim4_No" name="Op_StockInvestments_SoleSeparate_Claim4" value="No" checked="" onchange="getPartyClaimSoleSeparate(this, '4', 'Op');"> No</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6" id="Op_StockInvestments_SoleSeparate_Party4_Div" style="display: none;">
                                    <label>Who claims to own this account?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Op_StockInvestments_SoleSeparate_Party4_Client" name="Op_StockInvestments_SoleSeparate_Party4" value="{{$client_name}}"> {{$client_name}}</label>
                                        <label><input type="radio" id="Op_StockInvestments_SoleSeparate_Party4_Op" name="Op_StockInvestments_SoleSeparate_Party4" value="{{$opponent_name}}" checked=""> {{$opponent_name}}</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 left-clear" id="Op_StockInvestments_SoleSeparate_Grounds4_Div" style="display: none; clear: left;">
                                    <label for="Op_StockInvestments_SoleSeparate_Grounds4">Why does this person own this account solely and separately?</label>
                                    <input id="Op_StockInvestments_SoleSeparate_Grounds4" type="text" class="form-control 4_Op_stocksinvestments_inputs" name="Op_StockInvestments_SoleSeparate_Grounds4" value=""> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>How will this account value be distributed between the parties?</label>
                                    <div class="w-100 dataInput">
                                        <label><input type="radio" id="Op_StockInvestments_Disposition_Method4_Distribute Investments" name="Op_StockInvestments_Disposition_Method4" value="Distribute Investments" onchange="getDipositionMethod(this, '4', 'Op');"> Distribute Investments</label>
                                        <label><input type="radio" id="Op_StockInvestments_Disposition_Method4_Liquidate/Split Net Value" name="Op_StockInvestments_Disposition_Method4" value="Liquidate/Split Net Value" onchange="getDipositionMethod(this, '4', 'Op');"> Liquidate/Split Net Value</label>
                                        <label><input type="radio" id="Op_StockInvestments_Disposition_Method4_Percentage Buyout" name="Op_StockInvestments_Disposition_Method4" value="Percentage Buyout" onchange="getDipositionMethod(this, '4', 'Op');"> Percentage Buyout</label>
                                        <label><input type="radio" id="Op_StockInvestments_Disposition_Method4_Fixed Buyout" name="Op_StockInvestments_Disposition_Method4" value="Fixed Buyout" onchange="getDipositionMethod(this, '4', 'Op');"> Fixed Buyout</label>
                                    </div>
                                </div>
                                <!-- slider tool -->
                                <div class="form-group col-sm-6 m-auto 4_Op_Slider_Tool slider-tool-main">
                                    <div class="row">
                                        <div class="col">{{$client_name}}</div>
                                        <div class="col text-right">{{$opponent_name}}</div>
                                    </div>
                                    <input id="4_Op_balance_range_selector" type="range" class="form-control slider-tool-input 4_Op_balance_range_selector" name="" value="50.00" min="0.00" step="0.01" max="100" onchange="updateBalanceInput(this.value, '4', 'Op');">
                                </div>
                                <div class="form-group col-sm-6 m-auto 4_Op_Slider_Tool slider-tool-main">
                                    <div class="row justify-content-between">
                                        <div class="col selectorTool">
                                            <div class="left-col">
                                                <div class="client-info 4_Op_clientpercentage_div clientpercentage_div">
                                                    50.00%
                                                </div>
                                                <div class="client-info 4_Op_clientamount_div clientamount_div" style="clear: both;">
                                                    $0
                                                </div>
                                            </div>
                                            <label>To {{$client_name}}</label>
                                        </div>                                       
                                        <div class="col selectorTool selectorToolRight">
                                            <label>To {{$opponent_name}}</label>
                                            <div class="left-col right-col">
                                                <div class="client-info 4_Op_opponentpercentage_div opponentpercentage_div">
                                                    50.00%
                                                </div>
                                                <div class="client-info 4_Op_opponentamount_div opponentamount_div" style="clear: both;">
                                                    $0
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 m-auto 4_Op_Slider_Tool slider-tool-main">
                                    <label></label>
                                    <div class="w-100">
                                        <label><input type="radio" id="4_Op_StockInvestments_Estimated_Value_Select" name="4_Op_StockInvestments_Estimated_Value_Select_Reset" class="StockInvestments_Estimated_Value_Select_Reset" value="Save"> Save this Distribution of StockInvestment Account #4</label>
                                        <label><input type="radio" id="4_Op_StockInvestments_Estimated_Value_Reset" name="4_Op_StockInvestments_Estimated_Value_Select_Reset" class="StockInvestments_Estimated_Value_Select_Reset" value="Reset" onclick="resetBalanceInput(this, '4', 'Op');"> Reset to Default (50%)</label>
                                    </div>
                                </div>

                                <div class="form-group col-sm-6 Op_StockInvestments_Paying_Party4_Inputs_Div" style="display: none;">
                                    <label>Op StockInvestments Paying Party4</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Op_StockInvestments_Paying_Party4_Client" name="Op_StockInvestments_Paying_Party4" value="{{$client_name}}" onchange="getStockInvestmentPayingParty(this, '4', 'Op');"> {{$client_name}}</label>
                                        <label><input type="radio" id="Op_StockInvestments_Paying_Party4_Op" name="Op_StockInvestments_Paying_Party4" value="{{$opponent_name}}" onchange="getStockInvestmentPayingParty(this, '4', 'Op');"> {{$opponent_name}}</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 Op_StockInvestments_Paying_Party4_Inputs_Div" style="display: none;">
                                    <label>{{$client_name}} StockInvestment Equity Percent</label>
                                    <input id="Op_StockInvestments_Percent_Marital_Equity_to_Client4" type="number" class="form-control 4_Op_clientpercentage_input clientpercentage_input" name="Op_StockInvestments_Percent_Marital_Equity_to_Client4" value="50.00" min="0.00" step="0.01" max="100" readonly="">
                                </div>
                                <div class="form-group col-sm-6 Op_StockInvestments_Paying_Party4_Inputs_Div" style="display: none;">
                                    <label>How much is to be paid to {{$client_name}}?</label>
                                    <input id="Op_StockInvestments_Estimated_Value_to_Client4" type="number" class="form-control 4_Op_clientamount_input clientamount_input" name="Op_StockInvestments_Estimated_Value_to_Client4" value="" min="0.00" step="0.01" max="999999.99" readonly="" onchange="getEstimatedValueClient(this, '4', 'Op');" onkeyup="getEstimatedValueClient(this, '4', 'Op');">
                                </div>
                                <div class="form-group col-sm-6 Op_StockInvestments_Paying_Party4_Inputs_Div" style="display: none;">
                                    <label>{{$opponent_name}} StockInvestment Equity Percent</label>
                                    <input id="Op_StockInvestments_Percent_Marital_Equity_to_Op4" type="number" class="form-control 4_Op_opponentpercentage_input opponentpercentage_input" name="Op_StockInvestments_Percent_Marital_Equity_to_Op4" value="50.00" min="0.00" step="0.01" max="100" readonly="">
                                </div>
                                <div class="form-group col-sm-6 Op_StockInvestments_Paying_Party4_Inputs_Div" style="display: none;">
                                    <label>How much is to be paid to {{$opponent_name}}?</label>
                                    <input id="Op_StockInvestments_Estimated_Value_to_Op4" type="number" class="form-control 4_Op_opponentamount_input opponentamount_input" name="Op_StockInvestments_Estimated_Value_to_Op4" value="" min="0.00" step="0.01" max="999999.99" readonly="" onchange="getEstimatedValueOp(this, '4', 'Op');" onkeyup="getEstimatedValueOp(this, '4', 'Op');">
                                </div>
                                <!-- end of slider tool -->
                            </div>
                            <div class="col-sm-12 mt-4 5_Op_stocksinvestments_section" style="display: none;"><h5 class="col-sm-12">Fifth Stock Investment Info</h5>
                                <div class="form-group col-sm-6">
                                    <p class="text-danger 5_Op_no-state-county-found" style="display: none;">No City, State, County found for this zipcode.</p>
                                    <label for="Op_StockInvestments_Institution_ZIP5">Stock/Investment Institution Zip Code?</label>
                                    <input id="Op_StockInvestments_Institution_ZIP5" type="text" class="form-control 5_Op_stocksinvestments_inputs" name="Op_StockInvestments_Institution_ZIP5" value="" onkeyup="getCityStateForZip(this, '5_Op');"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_StockInvestments_Institution_Name5">Name of Stock/Investment Institution?</label>
                                    <input id="Op_StockInvestments_Institution_Name5" type="text" class="form-control 5_Op_stocksinvestments_inputs" name="Op_StockInvestments_Institution_Name5" value=""> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_StockInvestments_Institution_Street_Address5">Stock/Investment Institution Street Address?</label>
                                    <input id="Op_StockInvestments_Institution_Street_Address5" type="text" class="form-control 5_Op_stocksinvestments_inputs" name="Op_StockInvestments_Institution_Street_Address5" value=""> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_StockInvestments_Institution_City5">Stock/Investment Institution City?</label>
                                    <select id="Op_StockInvestments_Institution_City5" name="Op_StockInvestments_Institution_City5" class="form-control 5_Op_city_select">
                                        <option value="">Choose City</option>
                                    </select>   
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_StockInvestments_Institution_State5">Stock/Investment Institution State?</label>
                                    <select id="Op_StockInvestments_Institution_State5" name="Op_StockInvestments_Institution_State5" class="form-control 5_Op_state_select">
                                        <option value="">Choose State</option>
                                    </select>   
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_StockInvestments_Acct_Num5">Account Number?</label>
                                    <input id="Op_StockInvestments_Acct_Num5" type="text" class="form-control 5_Op_stocksinvestments_inputs" name="Op_StockInvestments_Acct_Num5" value=""> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_StockInvestments_Date_Marriage_Value5">Marriage Date Value?</label>
                                    <input id="Op_StockInvestments_Date_Marriage_Value5" type="number" class="form-control 5_Op_stocksinvestments_inputs" name="Op_StockInvestments_Date_Marriage_Value5" value="0.00" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_StockInvestments_Current_Value5">Current Value?</label>
                                    <input id="Op_StockInvestments_Current_Value5" type="number" class="form-control 5_Op_stocksinvestments_inputs" name="Op_StockInvestments_Current_Value5" value="0.00" min="0.00" step="0.01" max="999999.99" onchange="getJointCurrentValue(this, '5', 'Op');" onkeyup="getJointCurrentValue(this, '5', 'Op');"> 
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label for="Op_StockInvestments_Percent_Marital_Equity5">N/A, calculated = Op_StockInvestments_Institution_Current_Value5</label>
                                    <input id="Op_StockInvestments_Percent_Marital_Equity5" type="number" class="form-control 5_Op_stocksinvestments_inputs" name="Op_StockInvestments_Percent_Marital_Equity5" value="" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_StockInvestments_Yearly_Interest_Dividend5">Yearly Interest and Dividends from this account?</label>
                                    <input id="Op_StockInvestments_Yearly_Interest_Dividend5" type="number" class="form-control 5_Op_stocksinvestments_inputs" name="Op_StockInvestments_Yearly_Interest_Dividend5" value="0.00" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Does either party claim a sole/separate interest from the other on this account?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Op_StockInvestments_SoleSeparate_Claim5_Yes" name="Op_StockInvestments_SoleSeparate_Claim5" value="Yes" onchange="getPartyClaimSoleSeparate(this, '5', 'Op');"> Yes</label>
                                        <label><input type="radio" id="Op_StockInvestments_SoleSeparate_Claim5_No" name="Op_StockInvestments_SoleSeparate_Claim5" value="No" checked="" onchange="getPartyClaimSoleSeparate(this, '5', 'Op');"> No</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6" id="Op_StockInvestments_SoleSeparate_Party5_Div" style="display: none;">
                                    <label>Who claims to own this account?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Op_StockInvestments_SoleSeparate_Party5_Client" name="Op_StockInvestments_SoleSeparate_Party5" value="{{$client_name}}"> {{$client_name}}</label>
                                        <label><input type="radio" id="Op_StockInvestments_SoleSeparate_Party5_Op" name="Op_StockInvestments_SoleSeparate_Party5" value="{{$opponent_name}}" checked=""> {{$opponent_name}}</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 left-clear" id="Op_StockInvestments_SoleSeparate_Grounds5_Div" style="display: none; clear: left;">
                                    <label for="Op_StockInvestments_SoleSeparate_Grounds5">Why does this person own this account solely and separately?</label>
                                    <input id="Op_StockInvestments_SoleSeparate_Grounds5" type="text" class="form-control 5_Op_stocksinvestments_inputs" name="Op_StockInvestments_SoleSeparate_Grounds5" value=""> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>How will this account value be distributed between the parties?</label>
                                    <div class="w-100 dataInput">
                                        <label><input type="radio" id="Op_StockInvestments_Disposition_Method5_Distribute Investments" name="Op_StockInvestments_Disposition_Method5" value="Distribute Investments" onchange="getDipositionMethod(this, '5', 'Op');"> Distribute Investments</label>
                                        <label><input type="radio" id="Op_StockInvestments_Disposition_Method5_Liquidate/Split Net Value" name="Op_StockInvestments_Disposition_Method5" value="Liquidate/Split Net Value" onchange="getDipositionMethod(this, '5', 'Op');"> Liquidate/Split Net Value</label>
                                        <label><input type="radio" id="Op_StockInvestments_Disposition_Method5_Percentage Buyout" name="Op_StockInvestments_Disposition_Method5" value="Percentage Buyout" onchange="getDipositionMethod(this, '5', 'Op');"> Percentage Buyout</label>
                                        <label><input type="radio" id="Op_StockInvestments_Disposition_Method5_Fixed Buyout" name="Op_StockInvestments_Disposition_Method5" value="Fixed Buyout" onchange="getDipositionMethod(this, '5', 'Op');"> Fixed Buyout</label>
                                    </div>
                                </div>
                                <!-- slider tool -->
                                <div class="form-group col-sm-6 m-auto 5_Op_Slider_Tool slider-tool-main">
                                    <div class="row">
                                        <div class="col">{{$client_name}}</div>
                                        <div class="col text-right">{{$opponent_name}}</div>
                                    </div>
                                    <input id="5_Op_balance_range_selector" type="range" class="form-control slider-tool-input 5_Op_balance_range_selector" name="" value="50.00" min="0.00" step="0.01" max="100" onchange="updateBalanceInput(this.value, '5', 'Op');">
                                </div>
                                <div class="form-group col-sm-6 m-auto 5_Op_Slider_Tool slider-tool-main">
                                    <div class="row justify-content-between">
                                        <div class="col selectorTool">
                                            <div class="left-col">
                                                <div class="client-info 5_Op_clientpercentage_div clientpercentage_div">
                                                    50.00%
                                                </div>
                                                <div class="client-info 5_Op_clientamount_div clientamount_div" style="clear: both;">
                                                    $0
                                                </div>
                                            </div>
                                            <label>To {{$client_name}}</label>
                                        </div>                                       
                                        <div class="col selectorTool selectorToolRight">
                                            <label>To {{$opponent_name}}</label>
                                            <div class="left-col right-col">
                                                <div class="client-info 5_Op_opponentpercentage_div opponentpercentage_div">
                                                    50.00%
                                                </div>
                                                <div class="client-info 5_Op_opponentamount_div opponentamount_div" style="clear: both;">
                                                    $0
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 m-auto 5_Op_Slider_Tool slider-tool-main">
                                    <label></label>
                                    <div class="w-100">
                                        <label><input type="radio" id="5_Op_StockInvestments_Estimated_Value_Select" name="5_Op_StockInvestments_Estimated_Value_Select_Reset" class="StockInvestments_Estimated_Value_Select_Reset" value="Save"> Save this Distribution of StockInvestment Account #5</label>
                                        <label><input type="radio" id="5_Op_StockInvestments_Estimated_Value_Reset" name="5_Op_StockInvestments_Estimated_Value_Select_Reset" class="StockInvestments_Estimated_Value_Select_Reset" value="Reset" onclick="resetBalanceInput(this, '5', 'Op');"> Reset to Default (50%)</label>
                                    </div>
                                </div>

                                <div class="form-group col-sm-6 Op_StockInvestments_Paying_Party5_Inputs_Div" style="display: none;">
                                    <label>Op StockInvestments Paying Party5</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Op_StockInvestments_Paying_Party5_Client" name="Op_StockInvestments_Paying_Party5" value="{{$client_name}}" onchange="getStockInvestmentPayingParty(this, '5', 'Op');"> {{$client_name}}</label>
                                        <label><input type="radio" id="Op_StockInvestments_Paying_Party5_Op" name="Op_StockInvestments_Paying_Party5" value="{{$opponent_name}}" onchange="getStockInvestmentPayingParty(this, '5', 'Op');"> {{$opponent_name}}</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 Op_StockInvestments_Paying_Party5_Inputs_Div" style="display: none;">
                                    <label>{{$client_name}} StockInvestment Equity Percent</label>
                                    <input id="Op_StockInvestments_Percent_Marital_Equity_to_Client5" type="number" class="form-control 5_Op_clientpercentage_input clientpercentage_input" name="Op_StockInvestments_Percent_Marital_Equity_to_Client5" value="50.00" min="0.00" step="0.01" max="100" readonly="">
                                </div>
                                <div class="form-group col-sm-6 Op_StockInvestments_Paying_Party5_Inputs_Div" style="display: none;">
                                    <label>How much is to be paid to {{$client_name}}?</label>
                                    <input id="Op_StockInvestments_Estimated_Value_to_Client5" type="number" class="form-control 5_Op_clientamount_input clientamount_input" name="Op_StockInvestments_Estimated_Value_to_Client5" value="" min="0.00" step="0.01" max="999999.99" readonly="" onchange="getEstimatedValueClient(this, '5', 'Op');" onkeyup="getEstimatedValueClient(this, '5', 'Op');">
                                </div>
                                <div class="form-group col-sm-6 Op_StockInvestments_Paying_Party5_Inputs_Div" style="display: none;">
                                    <label>{{$opponent_name}} StockInvestment Equity Percent</label>
                                    <input id="Op_StockInvestments_Percent_Marital_Equity_to_Op5" type="number" class="form-control 5_Op_opponentpercentage_input opponentpercentage_input" name="Op_StockInvestments_Percent_Marital_Equity_to_Op5" value="50.00" min="0.00" step="0.01" max="100" readonly="">
                                </div>
                                <div class="form-group col-sm-6 Op_StockInvestments_Paying_Party5_Inputs_Div" style="display: none;">
                                    <label>How much is to be paid to {{$opponent_name}}?</label>
                                    <input id="Op_StockInvestments_Estimated_Value_to_Op5" type="number" class="form-control 5_Op_opponentamount_input opponentamount_input" name="Op_StockInvestments_Estimated_Value_to_Op5" value="" min="0.00" step="0.01" max="999999.99" readonly="" onchange="getEstimatedValueOp(this, '5', 'Op');" onkeyup="getEstimatedValueOp(this, '5', 'Op');">
                                </div>
                                <!-- end of slider tool -->
                            </div>
                            <div class="col-sm-12 mt-4 6_Op_stocksinvestments_section" style="display: none;"><h5 class="col-sm-12">Sixth Stock Investment Info</h5>
                                <div class="form-group col-sm-6">
                                    <p class="text-danger 6_Op_no-state-county-found" style="display: none;">No City, State, County found for this zipcode.</p>
                                    <label for="Op_StockInvestments_Institution_ZIP6">Stock/Investment Institution Zip Code?</label>
                                    <input id="Op_StockInvestments_Institution_ZIP6" type="text" class="form-control 6_Op_stocksinvestments_inputs" name="Op_StockInvestments_Institution_ZIP6" value="" onkeyup="getCityStateForZip(this, '6_Op');"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_StockInvestments_Institution_Name6">Name of Stock/Investment Institution?</label>
                                    <input id="Op_StockInvestments_Institution_Name6" type="text" class="form-control 6_Op_stocksinvestments_inputs" name="Op_StockInvestments_Institution_Name6" value=""> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_StockInvestments_Institution_Street_Address6">Stock/Investment Institution Street Address?</label>
                                    <input id="Op_StockInvestments_Institution_Street_Address6" type="text" class="form-control 6_Op_stocksinvestments_inputs" name="Op_StockInvestments_Institution_Street_Address6" value=""> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_StockInvestments_Institution_City6">Stock/Investment Institution City?</label>
                                    <select id="Op_StockInvestments_Institution_City6" name="Op_StockInvestments_Institution_City6" class="form-control 6_Op_city_select">
                                        <option value="">Choose City</option>
                                    </select>   
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_StockInvestments_Institution_State6">Stock/Investment Institution State?</label>
                                    <select id="Op_StockInvestments_Institution_State6" name="Op_StockInvestments_Institution_State6" class="form-control 6_Op_state_select">
                                        <option value="">Choose State</option>
                                    </select>   
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_StockInvestments_Acct_Num6">Account Number?</label>
                                    <input id="Op_StockInvestments_Acct_Num6" type="text" class="form-control 6_Op_stocksinvestments_inputs" name="Op_StockInvestments_Acct_Num6" value=""> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_StockInvestments_Date_Marriage_Value6">Marriage Date Value?</label>
                                    <input id="Op_StockInvestments_Date_Marriage_Value6" type="number" class="form-control 6_Op_stocksinvestments_inputs" name="Op_StockInvestments_Date_Marriage_Value6" value="0.00" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_StockInvestments_Current_Value6">Current Value?</label>
                                    <input id="Op_StockInvestments_Current_Value6" type="number" class="form-control 6_Op_stocksinvestments_inputs" name="Op_StockInvestments_Current_Value6" value="0.00" min="0.00" step="0.01" max="999999.99" onchange="getJointCurrentValue(this, '6', 'Op');" onkeyup="getJointCurrentValue(this, '6', 'Op');"> 
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label for="Op_StockInvestments_Percent_Marital_Equity6">N/A, calculated = Op_StockInvestments_Institution_Current_Value6</label>
                                    <input id="Op_StockInvestments_Percent_Marital_Equity6" type="number" class="form-control 6_Op_stocksinvestments_inputs" name="Op_StockInvestments_Percent_Marital_Equity6" value="" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_StockInvestments_Yearly_Interest_Dividend6">Yearly Interest and Dividends from this account?</label>
                                    <input id="Op_StockInvestments_Yearly_Interest_Dividend6" type="number" class="form-control 6_Op_stocksinvestments_inputs" name="Op_StockInvestments_Yearly_Interest_Dividend6" value="0.00" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Does either party claim a sole/separate interest from the other on this account?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Op_StockInvestments_SoleSeparate_Claim6_Yes" name="Op_StockInvestments_SoleSeparate_Claim6" value="Yes" onchange="getPartyClaimSoleSeparate(this, '6', 'Op');"> Yes</label>
                                        <label><input type="radio" id="Op_StockInvestments_SoleSeparate_Claim6_No" name="Op_StockInvestments_SoleSeparate_Claim6" value="No" checked="" onchange="getPartyClaimSoleSeparate(this, '6', 'Op');"> No</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6" id="Op_StockInvestments_SoleSeparate_Party6_Div" style="display: none;">
                                    <label>Who claims to own this account?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Op_StockInvestments_SoleSeparate_Party6_Client" name="Op_StockInvestments_SoleSeparate_Party6" value="{{$client_name}}"> {{$client_name}}</label>
                                        <label><input type="radio" id="Op_StockInvestments_SoleSeparate_Party6_Op" name="Op_StockInvestments_SoleSeparate_Party6" value="{{$opponent_name}}" checked=""> {{$opponent_name}}</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 left-clear" id="Op_StockInvestments_SoleSeparate_Grounds6_Div" style="display: none; clear: left;">
                                    <label for="Op_StockInvestments_SoleSeparate_Grounds6">Why does this person own this account solely and separately?</label>
                                    <input id="Op_StockInvestments_SoleSeparate_Grounds6" type="text" class="form-control 6_Op_stocksinvestments_inputs" name="Op_StockInvestments_SoleSeparate_Grounds6" value=""> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>How will this account value be distributed between the parties?</label>
                                    <div class="w-100 dataInput">
                                        <label><input type="radio" id="Op_StockInvestments_Disposition_Method6_Distribute Investments" name="Op_StockInvestments_Disposition_Method6" value="Distribute Investments" onchange="getDipositionMethod(this, '6', 'Op');"> Distribute Investments</label>
                                        <label><input type="radio" id="Op_StockInvestments_Disposition_Method6_Liquidate/Split Net Value" name="Op_StockInvestments_Disposition_Method6" value="Liquidate/Split Net Value" onchange="getDipositionMethod(this, '6', 'Op');"> Liquidate/Split Net Value</label>
                                        <label><input type="radio" id="Op_StockInvestments_Disposition_Method6_Percentage Buyout" name="Op_StockInvestments_Disposition_Method6" value="Percentage Buyout" onchange="getDipositionMethod(this, '6', 'Op');"> Percentage Buyout</label>
                                        <label><input type="radio" id="Op_StockInvestments_Disposition_Method6_Fixed Buyout" name="Op_StockInvestments_Disposition_Method6" value="Fixed Buyout" onchange="getDipositionMethod(this, '6', 'Op');"> Fixed Buyout</label>
                                    </div>
                                </div>
                                <!-- slider tool -->
                                <div class="form-group col-sm-6 m-auto 6_Op_Slider_Tool slider-tool-main">
                                    <div class="row">
                                        <div class="col">{{$client_name}}</div>
                                        <div class="col text-right">{{$opponent_name}}</div>
                                    </div>
                                    <input id="6_Op_balance_range_selector" type="range" class="form-control slider-tool-input 6_Op_balance_range_selector" name="" value="50.00" min="0.00" step="0.01" max="100" onchange="updateBalanceInput(this.value, '6', 'Op');">
                                </div>
                                <div class="form-group col-sm-6 m-auto 6_Op_Slider_Tool slider-tool-main">
                                    <div class="row justify-content-between">
                                        <div class="col selectorTool">
                                            <div class="left-col">
                                                <div class="client-info 6_Op_clientpercentage_div clientpercentage_div">
                                                    50.00%
                                                </div>
                                                <div class="client-info 6_Op_clientamount_div clientamount_div" style="clear: both;">
                                                    $0
                                                </div>
                                            </div>
                                            <label>To {{$client_name}}</label>
                                        </div>                                       
                                        <div class="col selectorTool selectorToolRight">
                                            <label>To {{$opponent_name}}</label>
                                            <div class="left-col right-col">
                                                <div class="client-info 6_Op_opponentpercentage_div opponentpercentage_div">
                                                    50.00%
                                                </div>
                                                <div class="client-info 6_Op_opponentamount_div opponentamount_div" style="clear: both;">
                                                    $0
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 m-auto 6_Op_Slider_Tool slider-tool-main">
                                    <label></label>
                                    <div class="w-100">
                                        <label><input type="radio" id="6_Op_StockInvestments_Estimated_Value_Select" name="6_Op_StockInvestments_Estimated_Value_Select_Reset" class="StockInvestments_Estimated_Value_Select_Reset" value="Save"> Save this Distribution of StockInvestment Account #6</label>
                                        <label><input type="radio" id="6_Op_StockInvestments_Estimated_Value_Reset" name="6_Op_StockInvestments_Estimated_Value_Select_Reset" class="StockInvestments_Estimated_Value_Select_Reset" value="Reset" onclick="resetBalanceInput(this, '6', 'Op');"> Reset to Default (50%)</label>
                                    </div>
                                </div>

                                <div class="form-group col-sm-6 Op_StockInvestments_Paying_Party6_Inputs_Div" style="display: none;">
                                    <label>Op StockInvestments Paying Party6</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Op_StockInvestments_Paying_Party6_Client" name="Op_StockInvestments_Paying_Party6" value="{{$client_name}}" onchange="getStockInvestmentPayingParty(this, '6', 'Op');"> {{$client_name}}</label>
                                        <label><input type="radio" id="Op_StockInvestments_Paying_Party6_Op" name="Op_StockInvestments_Paying_Party6" value="{{$opponent_name}}" onchange="getStockInvestmentPayingParty(this, '6', 'Op');"> {{$opponent_name}}</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 Op_StockInvestments_Paying_Party6_Inputs_Div" style="display: none;">
                                    <label>{{$client_name}} StockInvestment Equity Percent</label>
                                    <input id="Op_StockInvestments_Percent_Marital_Equity_to_Client6" type="number" class="form-control 6_Op_clientpercentage_input clientpercentage_input" name="Op_StockInvestments_Percent_Marital_Equity_to_Client6" value="50.00" min="0.00" step="0.01" max="100" readonly="">
                                </div>
                                <div class="form-group col-sm-6 Op_StockInvestments_Paying_Party6_Inputs_Div" style="display: none;">
                                    <label>How much is to be paid to {{$client_name}}?</label>
                                    <input id="Op_StockInvestments_Estimated_Value_to_Client6" type="number" class="form-control 6_Op_clientamount_input clientamount_input" name="Op_StockInvestments_Estimated_Value_to_Client6" value="" min="0.00" step="0.01" max="999999.99" readonly="" onchange="getEstimatedValueClient(this, '6', 'Op');" onkeyup="getEstimatedValueClient(this, '6', 'Op');">
                                </div>
                                <div class="form-group col-sm-6 Op_StockInvestments_Paying_Party6_Inputs_Div" style="display: none;">
                                    <label>{{$opponent_name}} StockInvestment Equity Percent</label>
                                    <input id="Op_StockInvestments_Percent_Marital_Equity_to_Op6" type="number" class="form-control 6_Op_opponentpercentage_input opponentpercentage_input" name="Op_StockInvestments_Percent_Marital_Equity_to_Op6" value="50.00" min="0.00" step="0.01" max="100" readonly="">
                                </div>
                                <div class="form-group col-sm-6 Op_StockInvestments_Paying_Party6_Inputs_Div" style="display: none;">
                                    <label>How much is to be paid to {{$opponent_name}}?</label>
                                    <input id="Op_StockInvestments_Estimated_Value_to_Op6" type="number" class="form-control 6_Op_opponentamount_input opponentamount_input" name="Op_StockInvestments_Estimated_Value_to_Op6" value="" min="0.00" step="0.01" max="999999.99" readonly="" onchange="getEstimatedValueOp(this, '6', 'Op');" onkeyup="getEstimatedValueOp(this, '6', 'Op');">
                                </div>
                                <!-- end of slider tool -->
                            </div>
                            <div class="col-sm-12 mt-4 7_Op_stocksinvestments_section" style="display: none;"><h5 class="col-sm-12">Seventh Stock Investment Info</h5>
                                <div class="form-group col-sm-6">
                                    <p class="text-danger 7_Op_no-state-county-found" style="display: none;">No City, State, County found for this zipcode.</p>
                                    <label for="Op_StockInvestments_Institution_ZIP7">Stock/Investment Institution Zip Code?</label>
                                    <input id="Op_StockInvestments_Institution_ZIP7" type="text" class="form-control 7_Op_stocksinvestments_inputs" name="Op_StockInvestments_Institution_ZIP7" value="" onkeyup="getCityStateForZip(this, '7_Op');"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_StockInvestments_Institution_Name7">Name of Stock/Investment Institution?</label>
                                    <input id="Op_StockInvestments_Institution_Name7" type="text" class="form-control 7_Op_stocksinvestments_inputs" name="Op_StockInvestments_Institution_Name7" value=""> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_StockInvestments_Institution_Street_Address7">Stock/Investment Institution Street Address?</label>
                                    <input id="Op_StockInvestments_Institution_Street_Address7" type="text" class="form-control 7_Op_stocksinvestments_inputs" name="Op_StockInvestments_Institution_Street_Address7" value=""> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_StockInvestments_Institution_City7">Stock/Investment Institution City?</label>
                                    <select id="Op_StockInvestments_Institution_City7" name="Op_StockInvestments_Institution_City7" class="form-control 7_Op_city_select">
                                        <option value="">Choose City</option>
                                    </select>   
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_StockInvestments_Institution_State7">Stock/Investment Institution State?</label>
                                    <select id="Op_StockInvestments_Institution_State7" name="Op_StockInvestments_Institution_State7" class="form-control 7_Op_state_select">
                                        <option value="">Choose State</option>
                                    </select>   
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_StockInvestments_Acct_Num7">Account Number?</label>
                                    <input id="Op_StockInvestments_Acct_Num7" type="text" class="form-control 7_Op_stocksinvestments_inputs" name="Op_StockInvestments_Acct_Num7" value=""> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_StockInvestments_Date_Marriage_Value7">Marriage Date Value?</label>
                                    <input id="Op_StockInvestments_Date_Marriage_Value7" type="number" class="form-control 7_Op_stocksinvestments_inputs" name="Op_StockInvestments_Date_Marriage_Value7" value="0.00" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_StockInvestments_Current_Value7">Current Value?</label>
                                    <input id="Op_StockInvestments_Current_Value7" type="number" class="form-control 7_Op_stocksinvestments_inputs" name="Op_StockInvestments_Current_Value7" value="0.00" min="0.00" step="0.01" max="999999.99" onchange="getJointCurrentValue(this, '7', 'Op');" onkeyup="getJointCurrentValue(this, '7', 'Op');"> 
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label for="Op_StockInvestments_Percent_Marital_Equity7">N/A, calculated = Op_StockInvestments_Institution_Current_Value7</label>
                                    <input id="Op_StockInvestments_Percent_Marital_Equity7" type="number" class="form-control 7_Op_stocksinvestments_inputs" name="Op_StockInvestments_Percent_Marital_Equity7" value="" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_StockInvestments_Yearly_Interest_Dividend7">Yearly Interest and Dividends from this account?</label>
                                    <input id="Op_StockInvestments_Yearly_Interest_Dividend7" type="number" class="form-control 7_Op_stocksinvestments_inputs" name="Op_StockInvestments_Yearly_Interest_Dividend7" value="0.00" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Does either party claim a sole/separate interest from the other on this account?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Op_StockInvestments_SoleSeparate_Claim7_Yes" name="Op_StockInvestments_SoleSeparate_Claim7" value="Yes" onchange="getPartyClaimSoleSeparate(this, '7', 'Op');"> Yes</label>
                                        <label><input type="radio" id="Op_StockInvestments_SoleSeparate_Claim7_No" name="Op_StockInvestments_SoleSeparate_Claim7" value="No" checked="" onchange="getPartyClaimSoleSeparate(this, '7', 'Op');"> No</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6" id="Op_StockInvestments_SoleSeparate_Party7_Div" style="display: none;">
                                    <label>Who claims to own this account?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Op_StockInvestments_SoleSeparate_Party7_Client" name="Op_StockInvestments_SoleSeparate_Party7" value="{{$client_name}}"> {{$client_name}}</label>
                                        <label><input type="radio" id="Op_StockInvestments_SoleSeparate_Party7_Op" name="Op_StockInvestments_SoleSeparate_Party7" value="{{$opponent_name}}" checked=""> {{$opponent_name}}</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 left-clear" id="Op_StockInvestments_SoleSeparate_Grounds7_Div" style="display: none; clear: left;">
                                    <label for="Op_StockInvestments_SoleSeparate_Grounds7">Why does this person own this account solely and separately?</label>
                                    <input id="Op_StockInvestments_SoleSeparate_Grounds7" type="text" class="form-control 7_Op_stocksinvestments_inputs" name="Op_StockInvestments_SoleSeparate_Grounds7" value=""> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>How will this account value be distributed between the parties?</label>
                                    <div class="w-100 dataInput">
                                        <label><input type="radio" id="Op_StockInvestments_Disposition_Method7_Distribute Investments" name="Op_StockInvestments_Disposition_Method7" value="Distribute Investments" onchange="getDipositionMethod(this, '7', 'Op');"> Distribute Investments</label>
                                        <label><input type="radio" id="Op_StockInvestments_Disposition_Method7_Liquidate/Split Net Value" name="Op_StockInvestments_Disposition_Method7" value="Liquidate/Split Net Value" onchange="getDipositionMethod(this, '7', 'Op');"> Liquidate/Split Net Value</label>
                                        <label><input type="radio" id="Op_StockInvestments_Disposition_Method7_Percentage Buyout" name="Op_StockInvestments_Disposition_Method7" value="Percentage Buyout" onchange="getDipositionMethod(this, '7', 'Op');"> Percentage Buyout</label>
                                        <label><input type="radio" id="Op_StockInvestments_Disposition_Method7_Fixed Buyout" name="Op_StockInvestments_Disposition_Method7" value="Fixed Buyout" onchange="getDipositionMethod(this, '7', 'Op');"> Fixed Buyout</label>
                                    </div>
                                </div>
                                <!-- slider tool -->
                                <div class="form-group col-sm-6 m-auto 7_Op_Slider_Tool slider-tool-main">
                                    <div class="row">
                                        <div class="col">{{$client_name}}</div>
                                        <div class="col text-right">{{$opponent_name}}</div>
                                    </div>
                                    <input id="7_Op_balance_range_selector" type="range" class="form-control slider-tool-input 7_Op_balance_range_selector" name="" value="50.00" min="0.00" step="0.01" max="100" onchange="updateBalanceInput(this.value, '7', 'Op');">
                                </div>
                                <div class="form-group col-sm-6 m-auto 7_Op_Slider_Tool slider-tool-main">
                                    <div class="row justify-content-between">
                                        <div class="col selectorTool">
                                            <div class="left-col">
                                                <div class="client-info 7_Op_clientpercentage_div clientpercentage_div">
                                                    50.00%
                                                </div>
                                                <div class="client-info 7_Op_clientamount_div clientamount_div" style="clear: both;">
                                                    $0
                                                </div>
                                            </div>
                                            <label>To {{$client_name}}</label>
                                        </div>                                       
                                        <div class="col selectorTool selectorToolRight">
                                            <label>To {{$opponent_name}}</label>
                                            <div class="left-col right-col">
                                                <div class="client-info 7_Op_opponentpercentage_div opponentpercentage_div">
                                                    50.00%
                                                </div>
                                                <div class="client-info 7_Op_opponentamount_div opponentamount_div" style="clear: both;">
                                                    $0
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 m-auto 7_Op_Slider_Tool slider-tool-main">
                                    <label></label>
                                    <div class="w-100">
                                        <label><input type="radio" id="7_Op_StockInvestments_Estimated_Value_Select" name="7_Op_StockInvestments_Estimated_Value_Select_Reset" class="StockInvestments_Estimated_Value_Select_Reset" value="Save"> Save this Distribution of StockInvestment Account #7</label>
                                        <label><input type="radio" id="7_Op_StockInvestments_Estimated_Value_Reset" name="7_Op_StockInvestments_Estimated_Value_Select_Reset" class="StockInvestments_Estimated_Value_Select_Reset" value="Reset" onclick="resetBalanceInput(this, '7', 'Op');"> Reset to Default (50%)</label>
                                    </div>
                                </div>

                                <div class="form-group col-sm-6 Op_StockInvestments_Paying_Party7_Inputs_Div" style="display: none;">
                                    <label>Op StockInvestments Paying Party7</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Op_StockInvestments_Paying_Party7_Client" name="Op_StockInvestments_Paying_Party7" value="{{$client_name}}" onchange="getStockInvestmentPayingParty(this, '7', 'Op');"> {{$client_name}}</label>
                                        <label><input type="radio" id="Op_StockInvestments_Paying_Party7_Op" name="Op_StockInvestments_Paying_Party7" value="{{$opponent_name}}" onchange="getStockInvestmentPayingParty(this, '7', 'Op');"> {{$opponent_name}}</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 Op_StockInvestments_Paying_Party7_Inputs_Div" style="display: none;">
                                    <label>{{$client_name}} StockInvestment Equity Percent</label>
                                    <input id="Op_StockInvestments_Percent_Marital_Equity_to_Client7" type="number" class="form-control 7_Op_clientpercentage_input clientpercentage_input" name="Op_StockInvestments_Percent_Marital_Equity_to_Client7" value="50.00" min="0.00" step="0.01" max="100" readonly="">
                                </div>
                                <div class="form-group col-sm-6 Op_StockInvestments_Paying_Party7_Inputs_Div" style="display: none;">
                                    <label>How much is to be paid to {{$client_name}}?</label>
                                    <input id="Op_StockInvestments_Estimated_Value_to_Client7" type="number" class="form-control 7_Op_clientamount_input clientamount_input" name="Op_StockInvestments_Estimated_Value_to_Client7" value="" min="0.00" step="0.01" max="999999.99" readonly="" onchange="getEstimatedValueClient(this, '7', 'Op');" onkeyup="getEstimatedValueClient(this, '7', 'Op');">
                                </div>
                                <div class="form-group col-sm-6 Op_StockInvestments_Paying_Party7_Inputs_Div" style="display: none;">
                                    <label>{{$opponent_name}} StockInvestment Equity Percent</label>
                                    <input id="Op_StockInvestments_Percent_Marital_Equity_to_Op7" type="number" class="form-control 7_Op_opponentpercentage_input opponentpercentage_input" name="Op_StockInvestments_Percent_Marital_Equity_to_Op7" value="50.00" min="0.00" step="0.01" max="100" readonly="">
                                </div>
                                <div class="form-group col-sm-6 Op_StockInvestments_Paying_Party7_Inputs_Div" style="display: none;">
                                    <label>How much is to be paid to {{$opponent_name}}?</label>
                                    <input id="Op_StockInvestments_Estimated_Value_to_Op7" type="number" class="form-control 7_Op_opponentamount_input opponentamount_input" name="Op_StockInvestments_Estimated_Value_to_Op7" value="" min="0.00" step="0.01" max="999999.99" readonly="" onchange="getEstimatedValueOp(this, '7', 'Op');" onkeyup="getEstimatedValueOp(this, '7', 'Op');">
                                </div>
                                <!-- end of slider tool -->
                            </div>
                            <div class="col-sm-12 mt-4 8_Op_stocksinvestments_section" style="display: none;"><h5 class="col-sm-12">Eighth Stock Investment Info</h5>
                                <div class="form-group col-sm-6">
                                    <p class="text-danger 8_Op_no-state-county-found" style="display: none;">No City, State, County found for this zipcode.</p>
                                    <label for="Op_StockInvestments_Institution_ZIP8">Stock/Investment Institution Zip Code?</label>
                                    <input id="Op_StockInvestments_Institution_ZIP8" type="text" class="form-control 8_Op_stocksinvestments_inputs" name="Op_StockInvestments_Institution_ZIP8" value="" onkeyup="getCityStateForZip(this, '8_Op');"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_StockInvestments_Institution_Name8">Name of Stock/Investment Institution?</label>
                                    <input id="Op_StockInvestments_Institution_Name8" type="text" class="form-control 8_Op_stocksinvestments_inputs" name="Op_StockInvestments_Institution_Name8" value=""> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_StockInvestments_Institution_Street_Address8">Stock/Investment Institution Street Address?</label>
                                    <input id="Op_StockInvestments_Institution_Street_Address8" type="text" class="form-control 8_Op_stocksinvestments_inputs" name="Op_StockInvestments_Institution_Street_Address8" value=""> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_StockInvestments_Institution_City8">Stock/Investment Institution City?</label>
                                    <select id="Op_StockInvestments_Institution_City8" name="Op_StockInvestments_Institution_City8" class="form-control 8_Op_city_select">
                                        <option value="">Choose City</option>
                                    </select>   
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_StockInvestments_Institution_State8">Stock/Investment Institution State?</label>
                                    <select id="Op_StockInvestments_Institution_State8" name="Op_StockInvestments_Institution_State8" class="form-control 8_Op_state_select">
                                        <option value="">Choose State</option>
                                    </select>   
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_StockInvestments_Acct_Num8">Account Number?</label>
                                    <input id="Op_StockInvestments_Acct_Num8" type="text" class="form-control 8_Op_stocksinvestments_inputs" name="Op_StockInvestments_Acct_Num8" value=""> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_StockInvestments_Date_Marriage_Value8">Marriage Date Value?</label>
                                    <input id="Op_StockInvestments_Date_Marriage_Value8" type="number" class="form-control 8_Op_stocksinvestments_inputs" name="Op_StockInvestments_Date_Marriage_Value8" value="0.00" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_StockInvestments_Current_Value8">Current Value?</label>
                                    <input id="Op_StockInvestments_Current_Value8" type="number" class="form-control 8_Op_stocksinvestments_inputs" name="Op_StockInvestments_Current_Value8" value="0.00" min="0.00" step="0.01" max="999999.99" onchange="getJointCurrentValue(this, '8', 'Op');" onkeyup="getJointCurrentValue(this, '8', 'Op');"> 
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label for="Op_StockInvestments_Percent_Marital_Equity8">N/A, calculated = Op_StockInvestments_Institution_Current_Value8</label>
                                    <input id="Op_StockInvestments_Percent_Marital_Equity8" type="number" class="form-control 8_Op_stocksinvestments_inputs" name="Op_StockInvestments_Percent_Marital_Equity8" value="" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_StockInvestments_Yearly_Interest_Dividend8">Yearly Interest and Dividends from this account?</label>
                                    <input id="Op_StockInvestments_Yearly_Interest_Dividend8" type="number" class="form-control 8_Op_stocksinvestments_inputs" name="Op_StockInvestments_Yearly_Interest_Dividend8" value="0.00" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Does either party claim a sole/separate interest from the other on this account?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Op_StockInvestments_SoleSeparate_Claim8_Yes" name="Op_StockInvestments_SoleSeparate_Claim8" value="Yes" onchange="getPartyClaimSoleSeparate(this, '8', 'Op');"> Yes</label>
                                        <label><input type="radio" id="Op_StockInvestments_SoleSeparate_Claim8_No" name="Op_StockInvestments_SoleSeparate_Claim8" value="No" checked="" onchange="getPartyClaimSoleSeparate(this, '8', 'Op');"> No</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6" id="Op_StockInvestments_SoleSeparate_Party8_Div" style="display: none;">
                                    <label>Who claims to own this account?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Op_StockInvestments_SoleSeparate_Party8_Client" name="Op_StockInvestments_SoleSeparate_Party8" value="{{$client_name}}"> {{$client_name}}</label>
                                        <label><input type="radio" id="Op_StockInvestments_SoleSeparate_Party8_Op" name="Op_StockInvestments_SoleSeparate_Party8" value="{{$opponent_name}}" checked=""> {{$opponent_name}}</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 left-clear" id="Op_StockInvestments_SoleSeparate_Grounds8_Div" style="display: none; clear: left;">
                                    <label for="Op_StockInvestments_SoleSeparate_Grounds8">Why does this person own this account solely and separately?</label>
                                    <input id="Op_StockInvestments_SoleSeparate_Grounds8" type="text" class="form-control 8_Op_stocksinvestments_inputs" name="Op_StockInvestments_SoleSeparate_Grounds8" value=""> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>How will this account value be distributed between the parties?</label>
                                    <div class="w-100 dataInput">
                                        <label><input type="radio" id="Op_StockInvestments_Disposition_Method8_Distribute Investments" name="Op_StockInvestments_Disposition_Method8" value="Distribute Investments" onchange="getDipositionMethod(this, '8', 'Op');"> Distribute Investments</label>
                                        <label><input type="radio" id="Op_StockInvestments_Disposition_Method8_Liquidate/Split Net Value" name="Op_StockInvestments_Disposition_Method8" value="Liquidate/Split Net Value" onchange="getDipositionMethod(this, '8', 'Op');"> Liquidate/Split Net Value</label>
                                        <label><input type="radio" id="Op_StockInvestments_Disposition_Method8_Percentage Buyout" name="Op_StockInvestments_Disposition_Method8" value="Percentage Buyout" onchange="getDipositionMethod(this, '8', 'Op');"> Percentage Buyout</label>
                                        <label><input type="radio" id="Op_StockInvestments_Disposition_Method8_Fixed Buyout" name="Op_StockInvestments_Disposition_Method8" value="Fixed Buyout" onchange="getDipositionMethod(this, '8', 'Op');"> Fixed Buyout</label>
                                    </div>
                                </div>
                                <!-- slider tool -->
                                <div class="form-group col-sm-6 m-auto 8_Op_Slider_Tool slider-tool-main">
                                    <div class="row">
                                        <div class="col">{{$client_name}}</div>
                                        <div class="col text-right">{{$opponent_name}}</div>
                                    </div>
                                    <input id="8_Op_balance_range_selector" type="range" class="form-control slider-tool-input 8_Op_balance_range_selector" name="" value="50.00" min="0.00" step="0.01" max="100" onchange="updateBalanceInput(this.value, '8', 'Op');">
                                </div>
                                <div class="form-group col-sm-6 m-auto 8_Op_Slider_Tool slider-tool-main">
                                    <div class="row justify-content-between">
                                        <div class="col selectorTool">
                                            <div class="left-col">
                                                <div class="client-info 8_Op_clientpercentage_div clientpercentage_div">
                                                    50.00%
                                                </div>
                                                <div class="client-info 8_Op_clientamount_div clientamount_div" style="clear: both;">
                                                    $0
                                                </div>
                                            </div>
                                            <label>To {{$client_name}}</label>
                                        </div>                                       
                                        <div class="col selectorTool selectorToolRight">
                                            <label>To {{$opponent_name}}</label>
                                            <div class="left-col right-col">
                                                <div class="client-info 8_Op_opponentpercentage_div opponentpercentage_div">
                                                    50.00%
                                                </div>
                                                <div class="client-info 8_Op_opponentamount_div opponentamount_div" style="clear: both;">
                                                    $0
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 m-auto 8_Op_Slider_Tool slider-tool-main">
                                    <label></label>
                                    <div class="w-100">
                                        <label><input type="radio" id="8_Op_StockInvestments_Estimated_Value_Select" name="8_Op_StockInvestments_Estimated_Value_Select_Reset" class="StockInvestments_Estimated_Value_Select_Reset" value="Save"> Save this Distribution of StockInvestment Account #8</label>
                                        <label><input type="radio" id="8_Op_StockInvestments_Estimated_Value_Reset" name="8_Op_StockInvestments_Estimated_Value_Select_Reset" class="StockInvestments_Estimated_Value_Select_Reset" value="Reset" onclick="resetBalanceInput(this, '8', 'Op');"> Reset to Default (50%)</label>
                                    </div>
                                </div>

                                <div class="form-group col-sm-6 Op_StockInvestments_Paying_Party8_Inputs_Div" style="display: none;">
                                    <label>Op StockInvestments Paying Party8</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Op_StockInvestments_Paying_Party8_Client" name="Op_StockInvestments_Paying_Party8" value="{{$client_name}}" onchange="getStockInvestmentPayingParty(this, '8', 'Op');"> {{$client_name}}</label>
                                        <label><input type="radio" id="Op_StockInvestments_Paying_Party8_Op" name="Op_StockInvestments_Paying_Party8" value="{{$opponent_name}}" onchange="getStockInvestmentPayingParty(this, '8', 'Op');"> {{$opponent_name}}</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 Op_StockInvestments_Paying_Party8_Inputs_Div" style="display: none;">
                                    <label>{{$client_name}} StockInvestment Equity Percent</label>
                                    <input id="Op_StockInvestments_Percent_Marital_Equity_to_Client8" type="number" class="form-control 8_Op_clientpercentage_input clientpercentage_input" name="Op_StockInvestments_Percent_Marital_Equity_to_Client8" value="50.00" min="0.00" step="0.01" max="100" readonly="">
                                </div>
                                <div class="form-group col-sm-6 Op_StockInvestments_Paying_Party8_Inputs_Div" style="display: none;">
                                    <label>How much is to be paid to {{$client_name}}?</label>
                                    <input id="Op_StockInvestments_Estimated_Value_to_Client8" type="number" class="form-control 8_Op_clientamount_input clientamount_input" name="Op_StockInvestments_Estimated_Value_to_Client8" value="" min="0.00" step="0.01" max="999999.99" readonly="" onchange="getEstimatedValueClient(this, '8', 'Op');" onkeyup="getEstimatedValueClient(this, '8', 'Op');">
                                </div>
                                <div class="form-group col-sm-6 Op_StockInvestments_Paying_Party8_Inputs_Div" style="display: none;">
                                    <label>{{$opponent_name}} StockInvestment Equity Percent</label>
                                    <input id="Op_StockInvestments_Percent_Marital_Equity_to_Op8" type="number" class="form-control 8_Op_opponentpercentage_input opponentpercentage_input" name="Op_StockInvestments_Percent_Marital_Equity_to_Op8" value="50.00" min="0.00" step="0.01" max="100" readonly="">
                                </div>
                                <div class="form-group col-sm-6 Op_StockInvestments_Paying_Party8_Inputs_Div" style="display: none;">
                                    <label>How much is to be paid to {{$opponent_name}}?</label>
                                    <input id="Op_StockInvestments_Estimated_Value_to_Op8" type="number" class="form-control 8_Op_opponentamount_input opponentamount_input" name="Op_StockInvestments_Estimated_Value_to_Op8" value="" min="0.00" step="0.01" max="999999.99" readonly="" onchange="getEstimatedValueOp(this, '8', 'Op');" onkeyup="getEstimatedValueOp(this, '8', 'Op');">
                                </div>
                                <!-- end of slider tool -->
                            </div>
                            <div class="col-sm-12 mt-4 9_Op_stocksinvestments_section" style="display: none;"><h5 class="col-sm-12">Nineth Stock Investment Info</h5>
                                <div class="form-group col-sm-6">
                                    <p class="text-danger 9_Op_no-state-county-found" style="display: none;">No City, State, County found for this zipcode.</p>
                                    <label for="Op_StockInvestments_Institution_ZIP9">Stock/Investment Institution Zip Code?</label>
                                    <input id="Op_StockInvestments_Institution_ZIP9" type="text" class="form-control 9_Op_stocksinvestments_inputs" name="Op_StockInvestments_Institution_ZIP9" value="" onkeyup="getCityStateForZip(this, '9_Op');"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_StockInvestments_Institution_Name9">Name of Stock/Investment Institution?</label>
                                    <input id="Op_StockInvestments_Institution_Name9" type="text" class="form-control 9_Op_stocksinvestments_inputs" name="Op_StockInvestments_Institution_Name9" value=""> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_StockInvestments_Institution_Street_Address9">Stock/Investment Institution Street Address?</label>
                                    <input id="Op_StockInvestments_Institution_Street_Address9" type="text" class="form-control 9_Op_stocksinvestments_inputs" name="Op_StockInvestments_Institution_Street_Address9" value=""> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_StockInvestments_Institution_City9">Stock/Investment Institution City?</label>
                                    <select id="Op_StockInvestments_Institution_City9" name="Op_StockInvestments_Institution_City9" class="form-control 9_Op_city_select">
                                        <option value="">Choose City</option>
                                    </select>   
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_StockInvestments_Institution_State9">Stock/Investment Institution State?</label>
                                    <select id="Op_StockInvestments_Institution_State9" name="Op_StockInvestments_Institution_State9" class="form-control 9_Op_state_select">
                                        <option value="">Choose State</option>
                                    </select>   
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_StockInvestments_Acct_Num9">Account Number?</label>
                                    <input id="Op_StockInvestments_Acct_Num9" type="text" class="form-control 9_Op_stocksinvestments_inputs" name="Op_StockInvestments_Acct_Num9" value=""> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_StockInvestments_Date_Marriage_Value9">Marriage Date Value?</label>
                                    <input id="Op_StockInvestments_Date_Marriage_Value9" type="number" class="form-control 9_Op_stocksinvestments_inputs" name="Op_StockInvestments_Date_Marriage_Value9" value="0.00" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_StockInvestments_Current_Value9">Current Value?</label>
                                    <input id="Op_StockInvestments_Current_Value9" type="number" class="form-control 9_Op_stocksinvestments_inputs" name="Op_StockInvestments_Current_Value9" value="0.00" min="0.00" step="0.01" max="999999.99" onchange="getJointCurrentValue(this, '9', 'Op');" onkeyup="getJointCurrentValue(this, '9', 'Op');"> 
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label for="Op_StockInvestments_Percent_Marital_Equity9">N/A, calculated = Op_StockInvestments_Institution_Current_Value9</label>
                                    <input id="Op_StockInvestments_Percent_Marital_Equity9" type="number" class="form-control 9_Op_stocksinvestments_inputs" name="Op_StockInvestments_Percent_Marital_Equity9" value="" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_StockInvestments_Yearly_Interest_Dividend9">Yearly Interest and Dividends from this account?</label>
                                    <input id="Op_StockInvestments_Yearly_Interest_Dividend9" type="number" class="form-control 9_Op_stocksinvestments_inputs" name="Op_StockInvestments_Yearly_Interest_Dividend9" value="0.00" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Does either party claim a sole/separate interest from the other on this account?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Op_StockInvestments_SoleSeparate_Claim9_Yes" name="Op_StockInvestments_SoleSeparate_Claim9" value="Yes" onchange="getPartyClaimSoleSeparate(this, '9', 'Op');"> Yes</label>
                                        <label><input type="radio" id="Op_StockInvestments_SoleSeparate_Claim9_No" name="Op_StockInvestments_SoleSeparate_Claim9" value="No" checked="" onchange="getPartyClaimSoleSeparate(this, '9', 'Op');"> No</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6" id="Op_StockInvestments_SoleSeparate_Party9_Div" style="display: none;">
                                    <label>Who claims to own this account?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Op_StockInvestments_SoleSeparate_Party9_Client" name="Op_StockInvestments_SoleSeparate_Party9" value="{{$client_name}}"> {{$client_name}}</label>
                                        <label><input type="radio" id="Op_StockInvestments_SoleSeparate_Party9_Op" name="Op_StockInvestments_SoleSeparate_Party9" value="{{$opponent_name}}" checked=""> {{$opponent_name}}</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 left-clear" id="Op_StockInvestments_SoleSeparate_Grounds9_Div" style="display: none; clear: left;">
                                    <label for="Op_StockInvestments_SoleSeparate_Grounds9">Why does this person own this account solely and separately?</label>
                                    <input id="Op_StockInvestments_SoleSeparate_Grounds9" type="text" class="form-control 9_Op_stocksinvestments_inputs" name="Op_StockInvestments_SoleSeparate_Grounds9" value=""> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>How will this account value be distributed between the parties?</label>
                                    <div class="w-100 dataInput">
                                        <label><input type="radio" id="Op_StockInvestments_Disposition_Method9_Distribute Investments" name="Op_StockInvestments_Disposition_Method9" value="Distribute Investments" onchange="getDipositionMethod(this, '9', 'Op');"> Distribute Investments</label>
                                        <label><input type="radio" id="Op_StockInvestments_Disposition_Method9_Liquidate/Split Net Value" name="Op_StockInvestments_Disposition_Method9" value="Liquidate/Split Net Value" onchange="getDipositionMethod(this, '9', 'Op');"> Liquidate/Split Net Value</label>
                                        <label><input type="radio" id="Op_StockInvestments_Disposition_Method9_Percentage Buyout" name="Op_StockInvestments_Disposition_Method9" value="Percentage Buyout" onchange="getDipositionMethod(this, '9', 'Op');"> Percentage Buyout</label>
                                        <label><input type="radio" id="Op_StockInvestments_Disposition_Method9_Fixed Buyout" name="Op_StockInvestments_Disposition_Method9" value="Fixed Buyout" onchange="getDipositionMethod(this, '9', 'Op');"> Fixed Buyout</label>
                                    </div>
                                </div>
                                <!-- slider tool -->
                                <div class="form-group col-sm-6 m-auto 9_Op_Slider_Tool slider-tool-main">
                                    <div class="row">
                                        <div class="col">{{$client_name}}</div>
                                        <div class="col text-right">{{$opponent_name}}</div>
                                    </div>
                                    <input id="9_Op_balance_range_selector" type="range" class="form-control slider-tool-input 9_Op_balance_range_selector" name="" value="50.00" min="0.00" step="0.01" max="100" onchange="updateBalanceInput(this.value, '9', 'Op');">
                                </div>
                                <div class="form-group col-sm-6 m-auto 9_Op_Slider_Tool slider-tool-main">
                                    <div class="row justify-content-between">
                                        <div class="col selectorTool">
                                            <div class="left-col">
                                                <div class="client-info 9_Op_clientpercentage_div clientpercentage_div">
                                                    50.00%
                                                </div>
                                                <div class="client-info 9_Op_clientamount_div clientamount_div" style="clear: both;">
                                                    $0
                                                </div>
                                            </div>
                                            <label>To {{$client_name}}</label>
                                        </div>                                       
                                        <div class="col selectorTool selectorToolRight">
                                            <label>To {{$opponent_name}}</label>
                                            <div class="left-col right-col">
                                                <div class="client-info 9_Op_opponentpercentage_div opponentpercentage_div">
                                                    50.00%
                                                </div>
                                                <div class="client-info 9_Op_opponentamount_div opponentamount_div" style="clear: both;">
                                                    $0
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 m-auto 9_Op_Slider_Tool slider-tool-main">
                                    <label></label>
                                    <div class="w-100">
                                        <label><input type="radio" id="9_Op_StockInvestments_Estimated_Value_Select" name="9_Op_StockInvestments_Estimated_Value_Select_Reset" class="StockInvestments_Estimated_Value_Select_Reset" value="Save"> Save this Distribution of StockInvestment Account #9</label>
                                        <label><input type="radio" id="9_Op_StockInvestments_Estimated_Value_Reset" name="9_Op_StockInvestments_Estimated_Value_Select_Reset" class="StockInvestments_Estimated_Value_Select_Reset" value="Reset" onclick="resetBalanceInput(this, '9', 'Op');"> Reset to Default (50%)</label>
                                    </div>
                                </div>

                                <div class="form-group col-sm-6 Op_StockInvestments_Paying_Party9_Inputs_Div" style="display: none;">
                                    <label>Op StockInvestments Paying Party9</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Op_StockInvestments_Paying_Party9_Client" name="Op_StockInvestments_Paying_Party9" value="{{$client_name}}" onchange="getStockInvestmentPayingParty(this, '9', 'Op');"> {{$client_name}}</label>
                                        <label><input type="radio" id="Op_StockInvestments_Paying_Party9_Op" name="Op_StockInvestments_Paying_Party9" value="{{$opponent_name}}" onchange="getStockInvestmentPayingParty(this, '9', 'Op');"> {{$opponent_name}}</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 Op_StockInvestments_Paying_Party9_Inputs_Div" style="display: none;">
                                    <label>{{$client_name}} StockInvestment Equity Percent</label>
                                    <input id="Op_StockInvestments_Percent_Marital_Equity_to_Client9" type="number" class="form-control 9_Op_clientpercentage_input clientpercentage_input" name="Op_StockInvestments_Percent_Marital_Equity_to_Client9" value="50.00" min="0.00" step="0.01" max="100" readonly="">
                                </div>
                                <div class="form-group col-sm-6 Op_StockInvestments_Paying_Party9_Inputs_Div" style="display: none;">
                                    <label>How much is to be paid to {{$client_name}}?</label>
                                    <input id="Op_StockInvestments_Estimated_Value_to_Client9" type="number" class="form-control 9_Op_clientamount_input clientamount_input" name="Op_StockInvestments_Estimated_Value_to_Client9" value="" min="0.00" step="0.01" max="999999.99" readonly="" onchange="getEstimatedValueClient(this, '9', 'Op');" onkeyup="getEstimatedValueClient(this, '9', 'Op');">
                                </div>
                                <div class="form-group col-sm-6 Op_StockInvestments_Paying_Party9_Inputs_Div" style="display: none;">
                                    <label>{{$opponent_name}} StockInvestment Equity Percent</label>
                                    <input id="Op_StockInvestments_Percent_Marital_Equity_to_Op9" type="number" class="form-control 9_Op_opponentpercentage_input opponentpercentage_input" name="Op_StockInvestments_Percent_Marital_Equity_to_Op9" value="50.00" min="0.00" step="0.01" max="100" readonly="">
                                </div>
                                <div class="form-group col-sm-6 Op_StockInvestments_Paying_Party9_Inputs_Div" style="display: none;">
                                    <label>How much is to be paid to {{$opponent_name}}?</label>
                                    <input id="Op_StockInvestments_Estimated_Value_to_Op9" type="number" class="form-control 9_Op_opponentamount_input opponentamount_input" name="Op_StockInvestments_Estimated_Value_to_Op9" value="" min="0.00" step="0.01" max="999999.99" readonly="" onchange="getEstimatedValueOp(this, '9', 'Op');" onkeyup="getEstimatedValueOp(this, '9', 'Op');">
                                </div>
                                <!-- end of slider tool -->
                            </div>
                            <div class="col-sm-12 mt-4 10_Op_stocksinvestments_section" style="display: none;"><h5 class="col-sm-12">Tenth Stock Investment Info</h5>
                                <div class="form-group col-sm-6">
                                    <p class="text-danger 10_Op_no-state-county-found" style="display: none;">No City, State, County found for this zipcode.</p>
                                    <label for="Op_StockInvestments_Institution_ZIP10">Stock/Investment Institution Zip Code?</label>
                                    <input id="Op_StockInvestments_Institution_ZIP10" type="text" class="form-control 10_Op_stocksinvestments_inputs" name="Op_StockInvestments_Institution_ZIP10" value="" onkeyup="getCityStateForZip(this, '10_Op');"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_StockInvestments_Institution_Name10">Name of Stock/Investment Institution?</label>
                                    <input id="Op_StockInvestments_Institution_Name10" type="text" class="form-control 10_Op_stocksinvestments_inputs" name="Op_StockInvestments_Institution_Name10" value=""> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_StockInvestments_Institution_Street_Address10">Stock/Investment Institution Street Address?</label>
                                    <input id="Op_StockInvestments_Institution_Street_Address10" type="text" class="form-control 10_Op_stocksinvestments_inputs" name="Op_StockInvestments_Institution_Street_Address10" value=""> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_StockInvestments_Institution_City10">Stock/Investment Institution City?</label>
                                    <select id="Op_StockInvestments_Institution_City10" name="Op_StockInvestments_Institution_City10" class="form-control 10_Op_city_select">
                                        <option value="">Choose City</option>
                                    </select>   
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_StockInvestments_Institution_State10">Stock/Investment Institution State?</label>
                                    <select id="Op_StockInvestments_Institution_State10" name="Op_StockInvestments_Institution_State10" class="form-control 10_Op_state_select">
                                        <option value="">Choose State</option>
                                    </select>   
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_StockInvestments_Acct_Num10">Account Number?</label>
                                    <input id="Op_StockInvestments_Acct_Num10" type="text" class="form-control 10_Op_stocksinvestments_inputs" name="Op_StockInvestments_Acct_Num10" value=""> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_StockInvestments_Date_Marriage_Value10">Marriage Date Value?</label>
                                    <input id="Op_StockInvestments_Date_Marriage_Value10" type="number" class="form-control 10_Op_stocksinvestments_inputs" name="Op_StockInvestments_Date_Marriage_Value10" value="0.00" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_StockInvestments_Current_Value10">Current Value?</label>
                                    <input id="Op_StockInvestments_Current_Value10" type="number" class="form-control 10_Op_stocksinvestments_inputs" name="Op_StockInvestments_Current_Value10" value="0.00" min="0.00" step="0.01" max="999999.99" onchange="getJointCurrentValue(this, '10', 'Op');" onkeyup="getJointCurrentValue(this, '10', 'Op');"> 
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label for="Op_StockInvestments_Percent_Marital_Equity10">N/A, calculated = Op_StockInvestments_Institution_Current_Value10</label>
                                    <input id="Op_StockInvestments_Percent_Marital_Equity10" type="number" class="form-control 10_Op_stocksinvestments_inputs" name="Op_StockInvestments_Percent_Marital_Equity10" value="" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_StockInvestments_Yearly_Interest_Dividend10">Yearly Interest and Dividends from this account?</label>
                                    <input id="Op_StockInvestments_Yearly_Interest_Dividend10" type="number" class="form-control 10_Op_stocksinvestments_inputs" name="Op_StockInvestments_Yearly_Interest_Dividend10" value="0.00" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Does either party claim a sole/separate interest from the other on this account?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Op_StockInvestments_SoleSeparate_Claim10_Yes" name="Op_StockInvestments_SoleSeparate_Claim10" value="Yes" onchange="getPartyClaimSoleSeparate(this, '10', 'Op');"> Yes</label>
                                        <label><input type="radio" id="Op_StockInvestments_SoleSeparate_Claim10_No" name="Op_StockInvestments_SoleSeparate_Claim10" value="No" checked="" onchange="getPartyClaimSoleSeparate(this, '10', 'Op');"> No</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6" id="Op_StockInvestments_SoleSeparate_Party10_Div" style="display: none;">
                                    <label>Who claims to own this account?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Op_StockInvestments_SoleSeparate_Party10_Client" name="Op_StockInvestments_SoleSeparate_Party10" value="{{$client_name}}"> {{$client_name}}</label>
                                        <label><input type="radio" id="Op_StockInvestments_SoleSeparate_Party10_Op" name="Op_StockInvestments_SoleSeparate_Party10" value="{{$opponent_name}}" checked=""> {{$opponent_name}}</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 left-clear" id="Op_StockInvestments_SoleSeparate_Grounds10_Div" style="display: none; clear: left;">
                                    <label for="Op_StockInvestments_SoleSeparate_Grounds10">Why does this person own this account solely and separately?</label>
                                    <input id="Op_StockInvestments_SoleSeparate_Grounds10" type="text" class="form-control 10_Op_stocksinvestments_inputs" name="Op_StockInvestments_SoleSeparate_Grounds10" value=""> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>How will this account value be distributed between the parties?</label>
                                    <div class="w-100 dataInput">
                                        <label><input type="radio" id="Op_StockInvestments_Disposition_Method10_Distribute Investments" name="Op_StockInvestments_Disposition_Method10" value="Distribute Investments" onchange="getDipositionMethod(this, '10', 'Op');"> Distribute Investments</label>
                                        <label><input type="radio" id="Op_StockInvestments_Disposition_Method10_Liquidate/Split Net Value" name="Op_StockInvestments_Disposition_Method10" value="Liquidate/Split Net Value" onchange="getDipositionMethod(this, '10', 'Op');"> Liquidate/Split Net Value</label>
                                        <label><input type="radio" id="Op_StockInvestments_Disposition_Method10_Percentage Buyout" name="Op_StockInvestments_Disposition_Method10" value="Percentage Buyout" onchange="getDipositionMethod(this, '10', 'Op');"> Percentage Buyout</label>
                                        <label><input type="radio" id="Op_StockInvestments_Disposition_Method10_Fixed Buyout" name="Op_StockInvestments_Disposition_Method10" value="Fixed Buyout" onchange="getDipositionMethod(this, '10', 'Op');"> Fixed Buyout</label>
                                    </div>
                                </div>
                                <!-- slider tool -->
                                <div class="form-group col-sm-6 m-auto 10_Op_Slider_Tool slider-tool-main">
                                    <div class="row">
                                        <div class="col">{{$client_name}}</div>
                                        <div class="col text-right">{{$opponent_name}}</div>
                                    </div>
                                    <input id="10_Op_balance_range_selector" type="range" class="form-control slider-tool-input 10_Op_balance_range_selector" name="" value="50.00" min="0.00" step="0.01" max="100" onchange="updateBalanceInput(this.value, '10', 'Op');">
                                </div>
                                <div class="form-group col-sm-6 m-auto 10_Op_Slider_Tool slider-tool-main">
                                    <div class="row justify-content-between">
                                        <div class="col selectorTool">
                                            <div class="left-col">
                                                <div class="client-info 10_Op_clientpercentage_div clientpercentage_div">
                                                    50.00%
                                                </div>
                                                <div class="client-info 10_Op_clientamount_div clientamount_div" style="clear: both;">
                                                    $0
                                                </div>
                                            </div>
                                            <label>To {{$client_name}}</label>
                                        </div>                                       
                                        <div class="col selectorTool selectorToolRight">
                                            <label>To {{$opponent_name}}</label>
                                            <div class="left-col right-col">
                                                <div class="client-info 10_Op_opponentpercentage_div opponentpercentage_div">
                                                    50.00%
                                                </div>
                                                <div class="client-info 10_Op_opponentamount_div opponentamount_div" style="clear: both;">
                                                    $0
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 m-auto 10_Op_Slider_Tool slider-tool-main">
                                    <label></label>
                                    <div class="w-100">
                                        <label><input type="radio" id="10_Op_StockInvestments_Estimated_Value_Select" name="10_Op_StockInvestments_Estimated_Value_Select_Reset" class="StockInvestments_Estimated_Value_Select_Reset" value="Save"> Save this Distribution of StockInvestment Account #10</label>
                                        <label><input type="radio" id="10_Op_StockInvestments_Estimated_Value_Reset" name="10_Op_StockInvestments_Estimated_Value_Select_Reset" class="StockInvestments_Estimated_Value_Select_Reset" value="Reset" onclick="resetBalanceInput(this, '10', 'Op');"> Reset to Default (50%)</label>
                                    </div>
                                </div>

                                <div class="form-group col-sm-6 Op_StockInvestments_Paying_Party10_Inputs_Div" style="display: none;">
                                    <label>Op StockInvestments Paying Party10</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Op_StockInvestments_Paying_Party10_Client" name="Op_StockInvestments_Paying_Party10" value="{{$client_name}}" onchange="getStockInvestmentPayingParty(this, '10', 'Op');"> {{$client_name}}</label>
                                        <label><input type="radio" id="Op_StockInvestments_Paying_Party10_Op" name="Op_StockInvestments_Paying_Party10" value="{{$opponent_name}}" onchange="getStockInvestmentPayingParty(this, '10', 'Op');"> {{$opponent_name}}</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 Op_StockInvestments_Paying_Party10_Inputs_Div" style="display: none;">
                                    <label>{{$client_name}} StockInvestment Equity Percent</label>
                                    <input id="Op_StockInvestments_Percent_Marital_Equity_to_Client10" type="number" class="form-control 10_Op_clientpercentage_input clientpercentage_input" name="Op_StockInvestments_Percent_Marital_Equity_to_Client10" value="50.00" min="0.00" step="0.01" max="100" readonly="">
                                </div>
                                <div class="form-group col-sm-6 Op_StockInvestments_Paying_Party10_Inputs_Div" style="display: none;">
                                    <label>How much is to be paid to {{$client_name}}?</label>
                                    <input id="Op_StockInvestments_Estimated_Value_to_Client10" type="number" class="form-control 10_Op_clientamount_input clientamount_input" name="Op_StockInvestments_Estimated_Value_to_Client10" value="" min="0.00" step="0.01" max="999999.99" readonly="" onchange="getEstimatedValueClient(this, '10', 'Op');" onkeyup="getEstimatedValueClient(this, '10', 'Op');">
                                </div>
                                <div class="form-group col-sm-6 Op_StockInvestments_Paying_Party10_Inputs_Div" style="display: none;">
                                    <label>{{$opponent_name}} StockInvestment Equity Percent</label>
                                    <input id="Op_StockInvestments_Percent_Marital_Equity_to_Op10" type="number" class="form-control 10_Op_opponentpercentage_input opponentpercentage_input" name="Op_StockInvestments_Percent_Marital_Equity_to_Op10" value="50.00" min="0.00" step="0.01" max="100" readonly="">
                                </div>
                                <div class="form-group col-sm-6 Op_StockInvestments_Paying_Party10_Inputs_Div" style="display: none;">
                                    <label>How much is to be paid to {{$opponent_name}}?</label>
                                    <input id="Op_StockInvestments_Estimated_Value_to_Op10" type="number" class="form-control 10_Op_opponentamount_input opponentamount_input" name="Op_StockInvestments_Estimated_Value_to_Op10" value="" min="0.00" step="0.01" max="999999.99" readonly="" onchange="getEstimatedValueOp(this, '10', 'Op');" onkeyup="getEstimatedValueOp(this, '10', 'Op');">
                                </div>
                                <!-- end of slider tool -->
                            </div>
                        </div>
                        <!-- End of Opponent Stocks Investments Info Section -->
                        <div class="form-group col-sm-12 text-center mt-4">
                            <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>

    function getAnySIA(siacheck){
        if(siacheck.checked){
            $('#Num_Joint_StocksInvestments_Accounts, #Num_Client_StockInvestments_Accounts, #Num_Op_StockInvestments_Accounts').val('0');
            $('.num_Joint_stocksinvestments_info, .num_Client_stocksinvestments_info, .num_Op_stocksinvestments_info').show();
        } else {
            $('.num_Joint_stocksinvestments_info, .num_Client_stocksinvestments_info, .num_Op_stocksinvestments_info').hide();
            $('#Num_Joint_StocksInvestments_Accounts, #Num_Client_StockInvestments_Accounts, #Num_Op_StockInvestments_Accounts').val('0');
            $('.Joint_stocksinvestments_info_section input, .Client_stocksinvestments_info_section input, .Op_stocksinvestments_info_section input').prop('required',false);
            $('.1_Joint_stocksinvestments_section, .2_Joint_stocksinvestments_section, .3_Joint_stocksinvestments_section, .4_Joint_stocksinvestments_section, .5_Joint_stocksinvestments_section, .6_Joint_stocksinvestments_section, .7_Joint_stocksinvestments_section, .8_Joint_stocksinvestments_section, .9_Joint_stocksinvestments_section, .10_Joint_stocksinvestments_section').hide();
            $('.1_Client_stocksinvestments_section, .2_Client_stocksinvestments_section, .3_Client_stocksinvestments_section, .4_Client_stocksinvestments_section, .5_Client_stocksinvestments_section, .6_Client_stocksinvestments_section, .7_Client_stocksinvestments_section, .8_Client_stocksinvestments_section, .9_Client_stocksinvestments_section, .10_Client_stocksinvestments_section').hide();
            $('.1_Op_stocksinvestments_section, .2_Op_stocksinvestments_section, .3_Op_stocksinvestments_section, .4_Op_stocksinvestments_section, .5_Op_stocksinvestments_section, .6_Op_stocksinvestments_section, .7_Op_stocksinvestments_section, .8_Op_stocksinvestments_section, .9_Op_stocksinvestments_section, .10_Op_stocksinvestments_section').hide();
        }
    }

     // fetch city, state, county of client based on zipcode
        function getCityStateForZip(zipinput, zipclass) {
            
            $('.'+zipclass+'_no-state-county-found').hide();
            $('.'+zipclass+'_city_select').find('option').remove().end().append('<option value="">Choose City</option>');
            $('.'+zipclass+'_state_select').find('option').remove().end().append('<option value="">Choose State</option>');
            var zip=zipinput.value;
            if( zip != '' && zip != null && zip.length >= '3'){
                var token= $('input[name=_token]').val();
                $.ajax({
                    url:"{{route('ajax_get_city_state_county_by_zip')}}",
                    method:"POST",
                    dataType: 'json',
                    data:{
                        zip: zip, 
                        _token: token, 
                    },
                    success: function(data){
                        // console.log(data);
                        if(data=='null' || data==''){
                            $('.'+zipclass+'_no-state-county-found').show();
                        } else {
                            $('.'+zipclass+'_no-state-county-found').hide();
                            $.each(data, function (key, val) {
                                $('.'+zipclass+'_city_select').append('<option value="'+data[key].city+'">'+data[key].city+'</option>');
                                $('.'+zipclass+'_state_select').append('<option value="'+data[key].state+'">'+data[key].state+'</option>');
                            });
                            var a = new Array();
                            $('.'+zipclass+'_city_select').children("option").each(function(x){
                                test = false;
                                b = a[x] = $(this).val();
                                for (i=0;i<a.length-1;i++){
                                    if (b ==a[i]) test =true;
                                }
                                if (test) $(this).remove();
                            })
                            var a = new Array();
                            $('.'+zipclass+'_state_select').children("option").each(function(x){
                                test = false;
                                b = a[x] = $(this).val();
                                for (i=0;i<a.length-1;i++){
                                    if (b ==a[i]) test =true;
                                }
                                if (test) $(this).remove();
                            })
                            
                            if($('.'+zipclass+'_city_select').children('option').length=='2'){
                                $('.'+zipclass+'_city_select').children('option').first().remove();
                            }
                            if($('.'+zipclass+'_state_select').children('option').length=='2'){
                                $('.'+zipclass+'_state_select').children('option').first().remove();
                            }
                            $('.'+zipclass+'_no-state-county-found').hide();
                        }
                    }
                });        
            }

        }

    function getPartyClaimSoleSeparate(claim, claimnum, claimtype){
        if(claim.value=='No'){
            $('#'+claimtype+'_StockInvestments_SoleSeparate_Party'+claimnum+'_Div').hide();
            $('#'+claimtype+'_StockInvestments_SoleSeparate_Grounds'+claimnum+'_Div').hide();
            $('#'+claimtype+'_StockInvestments_SoleSeparate_Grounds'+claimnum+'').val('');
            $('#'+claimtype+'_StockInvestments_SoleSeparate_Party'+claimnum+'').prop('checked', false);
            $('.'+claimnum+'_'+claimtype+'_Slider_Tool').show();
            $('.'+claimtype+'_StockInvestments_Paying_Party'+claimnum+'_Inputs_Div').hide();
            $('.'+claimtype+'_StockInvestments_Paying_Party'+claimnum+'_Inputs_Div input[type=number]').prop('readonly', true);
        } else {
            $('#'+claimtype+'_StockInvestments_SoleSeparate_Party'+claimnum+'_Div').show();
            $('#'+claimtype+'_StockInvestments_SoleSeparate_Grounds'+claimnum+'_Div').show();
            $('.'+claimnum+'_'+claimtype+'_Slider_Tool').hide();
            $('.'+claimtype+'_StockInvestments_Paying_Party'+claimnum+'_Inputs_Div').show();
            $('.'+claimtype+'_StockInvestments_Paying_Party'+claimnum+'_Inputs_Div input[type=number]').prop('readonly', true);
        }
    }

    function getDipositionMethod(claim, claimnum, claimtype){
        if(claim.value=='Fixed Buyout'){
            $('.'+claimnum+'_'+claimtype+'_Slider_Tool').hide();
            $('.'+claimtype+'_StockInvestments_Paying_Party'+claimnum+'_Inputs_Div').show();
            $('.'+claimtype+'_StockInvestments_Paying_Party'+claimnum+'_Inputs_Div input[type=number]').prop('readonly', true);
            $('.'+claimtype+'_StockInvestments_Paying_Party'+claimnum+'_Inputs_Div input[type=radio]').prop('checked', false);
            var current_val=$('#'+claimtype+'_StockInvestments_Current_Value'+claimnum+'').val();
            if(current_val){
                current_val=parseFloat(current_val).toFixed(2);
                var op_val=(current_val/2);
                op_val=parseFloat(op_val).toFixed(2);
                var client_val=(current_val)-(op_val);
                client_val=parseFloat(client_val).toFixed(2);
                $('#'+claimtype+'_StockInvestments_Estimated_Value_to_Client'+claimnum+'').val(client_val);
                $('#'+claimtype+'_StockInvestments_Estimated_Value_to_Op'+claimnum+'').val(op_val);
                var client_percentage=(client_val/current_val)*(100).toFixed(2);
                client_percentage=parseFloat(client_percentage).toFixed(2);
                var op_percentage=(100-client_percentage).toFixed(2);
                op_percentage=parseFloat(op_percentage).toFixed(2);
                $('#'+claimtype+'_StockInvestments_Percent_Marital_Equity_to_Client'+claimnum+'').val(client_percentage);
                $('#'+claimtype+'_StockInvestments_Percent_Marital_Equity_to_Op'+claimnum+'').val(op_percentage);
                $('.'+claimnum+'_'+claimtype+'_clientpercentage_div').text('50.00%');
                $('.'+claimnum+'_'+claimtype+'_opponentpercentage_div').text('50.00%');
                $('.'+claimnum+'_'+claimtype+'_clientamount_div').text(formatter.format(client_val));
                $('.'+claimnum+'_'+claimtype+'_opponentamount_div').text(formatter.format(op_val));
            }else {
                $('#'+claimtype+'_StockInvestments_Estimated_Value_to_Client'+claimnum+'').val('0.00');
                $('#'+claimtype+'_StockInvestments_Estimated_Value_to_Op'+claimnum+'').val('0.00');
                $('#'+claimtype+'_StockInvestments_Percent_Marital_Equity_to_Client'+claimnum+'').val('0.00');
                $('#'+claimtype+'_StockInvestments_Percent_Marital_Equity_to_Op'+claimnum+'').val('0.00');
                $('.'+claimnum+'_'+claimtype+'_clientpercentage_div').text('50.00%');
                $('.'+claimnum+'_'+claimtype+'_opponentpercentage_div').text('50.00%');
                $('.'+claimnum+'_'+claimtype+'_clientamount_div').text('0.00');
                $('.'+claimnum+'_'+claimtype+'_opponentamount_div').text('0.00');
            }

        } else {
            $('.'+claimnum+'_'+claimtype+'_Slider_Tool').show();
            $('.'+claimtype+'_StockInvestments_Paying_Party'+claimnum+'_Inputs_Div').hide();
            $('.'+claimtype+'_StockInvestments_Paying_Party'+claimnum+'_Inputs_Div input[type=number]').prop('readonly', true);
            $('.'+claimtype+'_StockInvestments_Paying_Party'+claimnum+'_Inputs_Div input[type=radio]').prop('checked', false);
            var current_val=$('#'+claimtype+'_StockInvestments_Current_Value'+claimnum+'').val();
            if(current_val){
                current_val=parseFloat(current_val).toFixed(2);
                var half_current_val=current_val/2;
                half_current_val=parseFloat(half_current_val).toFixed(2);
                $('.'+claimnum+'_'+claimtype+'_clientamount_input').val(half_current_val);
                $('.'+claimnum+'_'+claimtype+'_opponentamount_input').val(half_current_val);
                $('.'+claimnum+'_'+claimtype+'_clientpercentage_input, .'+claimnum+'_'+claimtype+'_opponentpercentage_input, .'+claimnum+'_'+claimtype+'_balance_range_selector').val('50.00');
                $('.'+claimnum+'_'+claimtype+'_clientpercentage_div, .'+claimnum+'_'+claimtype+'_opponentpercentage_div').text('50.00%');
                $('.'+claimnum+'_'+claimtype+'_clientamount_div, .'+claimnum+'_'+claimtype+'_opponentamount_div').text(formatter.format(half_current_val));
            }
        }
    }

    function getStockInvestmentPayingParty(party, partynum, partytype){
        if(party.id==''+partytype+'_StockInvestments_Paying_Party'+partynum+'_Client'){
            $('.'+partytype+'_StockInvestments_Paying_Party'+partynum+'_Inputs_Div').show();
            $('#'+partytype+'_StockInvestments_Estimated_Value_to_Op'+partynum+'').prop('readonly', false);
            $('#'+partytype+'_StockInvestments_Estimated_Value_to_Client'+partynum+'').prop('readonly', true);
        } else {
            $('.'+partytype+'_StockInvestments_Paying_Party'+partynum+'_Inputs_Div').show();
            $('#'+partytype+'_StockInvestments_Estimated_Value_to_Client'+partynum+'').prop('readonly', false);
            $('#'+partytype+'_StockInvestments_Estimated_Value_to_Op'+partynum+'').prop('readonly', true);
        }
    }

    function getEstimatedValueOp(party, partynum, partytype){
        var current_val=$('#'+partytype+'_StockInvestments_Current_Value'+partynum+'').val();
        if(current_val){
            current_val=parseFloat(current_val).toFixed(2);
            var op_val=party.value;
            op_val=parseFloat(op_val).toFixed(2);
            var client_val=(current_val)-(op_val);
            client_val=parseFloat(client_val).toFixed(2);
            $('#'+partytype+'_StockInvestments_Estimated_Value_to_Client'+partynum+'').val(client_val);
            var client_percentage=(client_val/current_val)*(100).toFixed(2);
            client_percentage=parseFloat(client_percentage).toFixed(2);
            var op_percentage=(100-client_percentage).toFixed(2);
            op_percentage=parseFloat(op_percentage).toFixed(2);
            $('#'+partytype+'_StockInvestments_Percent_Marital_Equity_to_Client'+partynum+'').val(client_percentage);
            $('#'+partytype+'_StockInvestments_Percent_Marital_Equity_to_Op'+partynum+'').val(op_percentage);
        }
    }

    function getEstimatedValueClient(party, partynum, partytype){
        var current_val=$('#'+partytype+'_StockInvestments_Current_Value'+partynum+'').val();
        if(current_val){
            current_val=parseFloat(current_val).toFixed(2);
            var client_val=party.value;
            client_val=parseFloat(client_val).toFixed(2);
            var op_val=(current_val)-(client_val);
            op_val=parseFloat(op_val).toFixed(2);
            $('#'+partytype+'_StockInvestments_Estimated_Value_to_Op'+partynum+'').val(op_val);
            var client_percentage=(client_val/current_val)*(100).toFixed(2);
            client_percentage=parseFloat(client_percentage).toFixed(2);
            var op_percentage=(100-client_percentage).toFixed(2);
            op_percentage=parseFloat(op_percentage).toFixed(2);
            $('#'+partytype+'_StockInvestments_Percent_Marital_Equity_to_Client'+partynum+'').val(client_percentage);
            $('#'+partytype+'_StockInvestments_Percent_Marital_Equity_to_Op'+partynum+'').val(op_percentage);
        }
    }

    function getJointCurrentValue(balance, balancenum, balancetype){
        var balanceclass=balancenum+'_'+balancetype;
        $('.'+balanceclass+'_balance_range_selector, .'+balanceclass+'_opponentpercentage_input, .'+balanceclass+'_clientpercentage_input').val('50.00');
        $('.'+balanceclass+'_opponentpercentage_div, .'+balanceclass+'_clientpercentage_div').text('50.00%');
        var current_balance=parseFloat(balance.value).toFixed(2);
        var client_balance_amount=current_balance/2;
        var opponent_balance_amount=current_balance/2;
        client_balance_amount=parseFloat(client_balance_amount).toFixed(2);
        opponent_balance_amount=parseFloat(opponent_balance_amount).toFixed(2);
        $('.'+balanceclass+'_clientamount_input').val(client_balance_amount);
        $('.'+balanceclass+'_opponentamount_input').val(opponent_balance_amount);
        $('.'+balanceclass+'_clientamount_div').text(formatter.format(client_balance_amount));
        $('.'+balanceclass+'_opponentamount_div').text(formatter.format(opponent_balance_amount));
    }

    function updateBalanceInput(value, balancenum, balancetype){
        var sliderclass=balancenum+'_'+balancetype;
        if(value <= 100){
            var value=parseFloat(value).toFixed(2);
            var joint_balance=$('#'+balancetype+'_StockInvestments_Current_Value'+balancenum+'').val();
            $('.'+sliderclass+'_opponentpercentage_input').val(value);
            $('.'+sliderclass+'_opponentpercentage_div').text(value+'%');
            var client_balance_percentage_new=100-value;
            client_balance_percentage_new=parseFloat(client_balance_percentage_new).toFixed(2);
            $('.'+sliderclass+'_clientpercentage_input').val(client_balance_percentage_new);
            $('.'+sliderclass+'_clientpercentage_div').text(client_balance_percentage_new+'%');
            joint_balance=parseFloat(joint_balance);
            var client_balance_amount_new = joint_balance - (joint_balance * value/100);
            var opponent_balance_amount = joint_balance - (joint_balance * client_balance_percentage_new/100);
            opponent_balance_amount=parseFloat(opponent_balance_amount).toFixed(2);
            client_balance_amount_new=parseFloat(client_balance_amount_new).toFixed(2);
            $('.'+sliderclass+'_opponentamount_input').val(opponent_balance_amount);
            $('.'+sliderclass+'_clientamount_input').val(client_balance_amount_new);
            $('.'+sliderclass+'_opponentamount_div').text(formatter.format(opponent_balance_amount));
            $('.'+sliderclass+'_clientamount_div').text(formatter.format(client_balance_amount_new));
        }
    }

    function resetBalanceInput(value, balancenum, balancetype){
        var sliderclass=balancenum+'_'+balancetype;
        $('.'+sliderclass+'_balance_range_selector, .'+sliderclass+'_opponentpercentage_input, .'+sliderclass+'_clientpercentage_input').val('50.00');
        $('.'+sliderclass+'_opponentpercentage_div, .'+sliderclass+'_clientpercentage_div').text('50.00%');
        var joint_balance=$('#'+balancetype+'_StockInvestments_Current_Value'+balancenum+'').val();
        joint_balance=parseFloat(joint_balance).toFixed(2);
        client_balance=joint_balance/2;
        client_balance=parseFloat(client_balance).toFixed(2);
        $('.'+sliderclass+'_clientamount_input').val(client_balance);
        $('.'+sliderclass+'_opponentamount_input').val(client_balance);
        $('.'+sliderclass+'_clientamount_div').text(formatter.format(client_balance));
        $('.'+sliderclass+'_opponentamount_div').text(formatter.format(client_balance));
    }

    const formatter = new Intl.NumberFormat('en-US', {
        style: 'currency',
        currency: 'USD',
        minimumFractionDigits: 2
    });

    $(document).ready(function(){

        $('#dr_Stocks_Investments').validate();
        $(window).keydown(function(event){
            if(event.keyCode == 13) {
              event.preventDefault();
              return false;
            }
        });

        // $('#Num_Joint_StocksInvestments_Accounts, #Num_Client_StockInvestments_Accounts, #Num_Op_StockInvestments_Accounts').val('0');
        // $('.Joint_stocksinvestments_info_section input, .Client_stocksinvestments_info_section input, .Op_stocksinvestments_info_section input').prop('required',false);
        var any_siacheck=$('#Any_Stocks_Investments_Accounts');
        if(any_siacheck.prop("checked") == true){
            $('.num_Joint_stocksinvestments_info, .num_Client_stocksinvestments_info, .num_Op_stocksinvestments_info').show();
        } else {
            $('.num_Joint_stocksinvestments_info, .num_Client_stocksinvestments_info, .num_Op_stocksinvestments_info').hide();
            $('#Num_Joint_StocksInvestments_Accounts, #Num_Client_StockInvestments_Accounts, #Num_Op_StockInvestments_Accounts').val('0');
            $('.Joint_stocksinvestments_info_section input, .Client_stocksinvestments_info_section input, .Op_stocksinvestments_info_section input').prop('required',false);
            $('.1_Joint_stocksinvestments_section, .2_Joint_stocksinvestments_section, .3_Joint_stocksinvestments_section, .4_Joint_stocksinvestments_section, .5_Joint_stocksinvestments_section, .6_Joint_stocksinvestments_section, .7_Joint_stocksinvestments_section, .8_Joint_stocksinvestments_section, .9_Joint_stocksinvestments_section, .10_Joint_stocksinvestments_section').hide();
            $('.1_Client_stocksinvestments_section, .2_Client_stocksinvestments_section, .3_Client_stocksinvestments_section, .4_Client_stocksinvestments_section, .5_Client_stocksinvestments_section, .6_Client_stocksinvestments_section, .7_Client_stocksinvestments_section, .8_Client_stocksinvestments_section, .9_Client_stocksinvestments_section, .10_Client_stocksinvestments_section').hide();
            $('.1_Op_stocksinvestments_section, .2_Op_stocksinvestments_section, .3_Op_stocksinvestments_section, .4_Op_stocksinvestments_section, .5_Op_stocksinvestments_section, .6_Op_stocksinvestments_section, .7_Op_stocksinvestments_section, .8_Op_stocksinvestments_section, .9_Op_stocksinvestments_section, .10_Op_stocksinvestments_section').hide();
        }

        // on number of joint StocksInvestments input change
        $('.1_Joint_stocksinvestments_section, .2_Joint_stocksinvestments_section, .3_Joint_stocksinvestments_section, .4_Joint_stocksinvestments_section, .5_Joint_stocksinvestments_section, .6_Joint_stocksinvestments_section, .7_Joint_stocksinvestments_section, .8_Joint_stocksinvestments_section, .9_Joint_stocksinvestments_section, .10_Joint_stocksinvestments_section').hide();
        if($('#Num_Joint_StocksInvestments_Accounts').val() > 0 &&  $('#Num_Joint_StocksInvestments_Accounts').val() <= 10 ){
            for (var i = 1; i <= $('#Num_Joint_StocksInvestments_Accounts').val(); i++) {
                $('.'+i+'_Joint_stocksinvestments_section').show();
                $('.'+i+'_Joint_stocksinvestments_section input').first().prop('required',true);
                var client_balance=$('.'+i+'_Joint_clientamount_input').val();
                var opponent_balance=$('.'+i+'_Joint_opponentamount_input').val();
                client_balance=parseFloat(client_balance).toFixed(2);
                opponent_balance=parseFloat(opponent_balance).toFixed(2);
                if(isNaN(client_balance)) {
                    client_balance = 0.00;
                }
                if(isNaN(opponent_balance)) {
                    opponent_balance = 0.00;
                }
                $('.'+i+'_Joint_clientamount_div').text(formatter.format(client_balance));
                $('.'+i+'_Joint_opponentamount_div').text(formatter.format(opponent_balance));
            }
        }
        var val=parseInt($('#Num_Joint_StocksInvestments_Accounts').val())+1;
        for (var i = val; i <= 10; i++) {
            $('.'+i+'_Joint_stocksinvestments_section input').prop('required',false);
            $('.'+i+'_Joint_stocksinvestments_section select option[value=""]').prop('selected','selected');
        }
        $('#Num_Joint_StocksInvestments_Accounts').on('change keyup', function(){
            $('.1_Joint_stocksinvestments_section, .2_Joint_stocksinvestments_section, .3_Joint_stocksinvestments_section, .4_Joint_stocksinvestments_section, .5_Joint_stocksinvestments_section, .6_Joint_stocksinvestments_section, .7_Joint_stocksinvestments_section, .8_Joint_stocksinvestments_section, .9_Joint_stocksinvestments_section, .10_Joint_stocksinvestments_section').hide();
            if(this.value > 0 &&  this.value <= 10 ){
                for (var i = 1; i <= this.value; i++) {
                    $('.'+i+'_Joint_stocksinvestments_section').show();
                }
            }
            var val=parseInt(this.value)+1;
            for (var i = val; i <= 10; i++) {
                $('.'+i+'_Joint_stocksinvestments_section input').prop('required',false);
                $('.'+i+'_Joint_stocksinvestments_section select option[value=""]').prop('selected','selected');
            }
        });
        // on number of client StocksInvestments input change
        $('.1_Client_stocksinvestments_section, .2_Client_stocksinvestments_section, .3_Client_stocksinvestments_section, .4_Client_stocksinvestments_section, .5_Client_stocksinvestments_section, .6_Client_stocksinvestments_section, .7_Client_stocksinvestments_section, .8_Client_stocksinvestments_section, .9_Client_stocksinvestments_section, .10_Client_stocksinvestments_section').hide();
        if($('#Num_Client_StockInvestments_Accounts').val() > 0 &&  $('#Num_Client_StockInvestments_Accounts').val() <= 10 ){
            for (var i = 1; i <= $('#Num_Client_StockInvestments_Accounts').val(); i++) {
                $('.'+i+'_Client_stocksinvestments_section').show();
                $('.'+i+'_Client_stocksinvestments_section input').first().prop('required',true);
                var client_balance=$('.'+i+'_Client_clientamount_input').val();
                var opponent_balance=$('.'+i+'_Client_opponentamount_input').val();
                client_balance=parseFloat(client_balance).toFixed(2);
                opponent_balance=parseFloat(opponent_balance).toFixed(2);
                if(isNaN(client_balance)) {
                    client_balance = 0.00;
                }
                if(isNaN(opponent_balance)) {
                    opponent_balance = 0.00;
                }
                $('.'+i+'_Client_clientamount_div').text(formatter.format(client_balance));
                $('.'+i+'_Client_opponentamount_div').text(formatter.format(opponent_balance));
            }
        }
        var val=parseInt($('#Num_Client_StockInvestments_Accounts').val())+1;
        for (var i = val; i <= 10; i++) {
            $('.'+i+'_Client_stocksinvestments_section input').prop('required',false);
            $('.'+i+'_Client_stocksinvestments_section select option[value=""]').prop('selected','selected');
        }
        $('#Num_Client_StockInvestments_Accounts').on('change keyup', function(){
            $('.1_Client_stocksinvestments_section, .2_Client_stocksinvestments_section, .3_Client_stocksinvestments_section, .4_Client_stocksinvestments_section, .5_Client_stocksinvestments_section, .6_Client_stocksinvestments_section, .7_Client_stocksinvestments_section, .8_Client_stocksinvestments_section, .9_Client_stocksinvestments_section, .10_Client_stocksinvestments_section').hide();
            if(this.value > 0 &&  this.value <= 10 ){
                for (var i = 1; i <= this.value; i++) {
                    $('.'+i+'_Client_stocksinvestments_section').show();
                }
            }
            var val=parseInt(this.value)+1;
            for (var i = val; i <= 10; i++) {
                $('.'+i+'_Client_stocksinvestments_section input').prop('required',false);
                $('.'+i+'_Client_stocksinvestments_section select option[value=""]').prop('selected','selected');
            }
        });
        // on number of opponent StocksInvestments input change
        $('.1_Op_stocksinvestments_section, .2_Op_stocksinvestments_section, .3_Op_stocksinvestments_section, .4_Op_stocksinvestments_section, .5_Op_stocksinvestments_section, .6_Op_stocksinvestments_section, .7_Op_stocksinvestments_section, .8_Op_stocksinvestments_section, .9_Op_stocksinvestments_section, .10_Op_stocksinvestments_section').hide();
        if($('#Num_Op_StockInvestments_Accounts').val() > 0 &&  $('#Num_Op_StockInvestments_Accounts').val() <= 10 ){
            for (var i = 1; i <= $('#Num_Op_StockInvestments_Accounts').val(); i++) {
                $('.'+i+'_Op_stocksinvestments_section').show();
                $('.'+i+'_Op_stocksinvestments_section input').first().prop('required',true);
                var client_balance=$('.'+i+'_Op_clientamount_input').val();
                var opponent_balance=$('.'+i+'_Op_opponentamount_input').val();
                client_balance=parseFloat(client_balance).toFixed(2);
                opponent_balance=parseFloat(opponent_balance).toFixed(2);
                if(isNaN(client_balance)) {
                    client_balance = 0.00;
                }
                if(isNaN(opponent_balance)) {
                    opponent_balance = 0.00;
                }
                $('.'+i+'_Op_clientamount_div').text(formatter.format(client_balance));
                $('.'+i+'_Op_opponentamount_div').text(formatter.format(opponent_balance));
            }
        }
        var val=parseInt($('#Num_Op_StockInvestments_Accounts').val())+1;
        for (var i = val; i <= 10; i++) {
            $('.'+i+'_Op_stocksinvestments_section input').prop('required',false);
            $('.'+i+'_Op_stocksinvestments_section select option[value=""]').prop('selected','selected');
        }
        $('#Num_Op_StockInvestments_Accounts').on('change keyup', function(){
            $('.1_Op_stocksinvestments_section, .2_Op_stocksinvestments_section, .3_Op_stocksinvestments_section, .4_Op_stocksinvestments_section, .5_Op_stocksinvestments_section, .6_Op_stocksinvestments_section, .7_Op_stocksinvestments_section, .8_Op_stocksinvestments_section, .9_Op_stocksinvestments_section, .10_Op_stocksinvestments_section').hide();
            if(this.value > 0 &&  this.value <= 10 ){
                for (var i = 1; i <= this.value; i++) {
                    $('.'+i+'_Op_stocksinvestments_section').show();
                }
            }
            var val=parseInt(this.value)+1;
            for (var i = val; i <= 10; i++) {
                $('.'+i+'_Op_stocksinvestments_section input').prop('required',false);
                $('.'+i+'_Op_stocksinvestments_section select option[value=""]').prop('selected','selected');
            }
        });
    });
</script>   
@endsection