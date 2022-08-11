@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center dr_Stocks_Investments_main">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header"><strong>{{ __('Update Stocks Investments Info') }}</strong>
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
                    <form role="form" id="dr_Stocks_Investments" method="POST" action="{{route('drstocksinvestments.update',['id'=>$drstocksinvestments->id])}}" autocomplete="off">
                        @csrf
                        @method('put')
                        <input id="" type="hidden" class="form-control" name="case_id" value="{{$case_id}}">
                        <div class="form-row Any_Stocks_Investments_Accounts">
                            <div class="form-group col-sm-12">
                                <label></label>
                                <div class="w-100 dataInput">
                                     <label><input type="checkbox" id="Any_Stocks_Investments_Accounts" name="Any_Stocks_Investments_Accounts" value="1" onchange="getAnySIA(this);" <?php if(isset($drstocksinvestments->Any_Stocks_Investments_Accounts) && $drstocksinvestments->Any_Stocks_Investments_Accounts=='1'){ echo "checked"; } ?>> Check if any Stocks or Investments (Accounts or Certificates) is Owned by {{$client_name}} and/or {{$opponent_name}}?</label>
                                </div>
                            </div>
                        </div>
                        <!-- Joint Stocks Investments Info Section -->
                        <div class="form-row num_Joint_stocksinvestments_info" style="display: none;">
                            <h4 class="col-sm-12">Joint Stocks Investments Info Section</h4>
                            <div class="col-sm-6">
                                <label for="Num_Joint_StocksInvestments_Accounts">How many deposit accounts in BOTH parties’ names?</label>
                                <input id="Num_Joint_StocksInvestments_Accounts" type="number" class="form-control" name="Num_Joint_StocksInvestments_Accounts" value="<?php if(isset($drstocksinvestments->Num_Joint_StocksInvestments_Accounts)){ echo $drstocksinvestments->Num_Joint_StocksInvestments_Accounts; } ?>" min="0" max="10"> 
                            </div>
                        </div>
                        <div class="form-row Joint_stocksinvestments_info_section">
                            <div class="col-sm-12 mt-4 1_Joint_stocksinvestments_section" style="display: none;"><h5 class="col-sm-12">First Stock Investment Info</h5>
                                <div class="form-group col-sm-6">
                                    <p class="text-danger 1_Joint_no-state-county-found" style="display: none;">No City, State, County found for this zipcode.</p>
                                    <label for="Joint_StockInvestments_Institution_ZIP1">Stock/Investment Institution Zip Code?</label>
                                    <input id="Joint_StockInvestments_Institution_ZIP1" type="text" class="form-control 1_Joint_stocksinvestments_inputs" name="Joint_StockInvestments_Institution_ZIP1" value="<?php if(isset($drstocksinvestments->Joint_StockInvestments_Institution_ZIP1)){ echo $drstocksinvestments->Joint_StockInvestments_Institution_ZIP1; } ?>" data-onload="getCityStateForZip(this, '1', 'Joint');" onkeyup="getCityStateForZip(this, '1', 'Joint');"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_StockInvestments_Institution_Name1">Name of Stock/Investment Institution?</label>
                                    <input id="Joint_StockInvestments_Institution_Name1" type="text" class="form-control 1_Joint_stocksinvestments_inputs" name="Joint_StockInvestments_Institution_Name1" value="<?php if(isset($drstocksinvestments->Joint_StockInvestments_Institution_Name1)){ echo $drstocksinvestments->Joint_StockInvestments_Institution_Name1; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_StockInvestments_Institution_Street_Address1">Stock/Investment Institution Street Address?</label>
                                    <input id="Joint_StockInvestments_Institution_Street_Address1" type="text" class="form-control 1_Joint_stocksinvestments_inputs" name="Joint_StockInvestments_Institution_Street_Address1" value="<?php if(isset($drstocksinvestments->Joint_StockInvestments_Institution_Street_Address1)){ echo $drstocksinvestments->Joint_StockInvestments_Institution_Street_Address1; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_StockInvestments_Institution_City1">Stock/Investment Institution City?</label>
                                    <input type="hidden" name="" id="Joint_StockInvestments_Institution_City1_Value" value="<?php if(isset($drstocksinvestments->Joint_StockInvestments_Institution_City1)){ echo $drstocksinvestments->Joint_StockInvestments_Institution_City1; } ?>">
                                    <select id="Joint_StockInvestments_Institution_City1" name="Joint_StockInvestments_Institution_City1" class="form-control 1_Joint_city_select">
                                        <option value="">Choose City</option>
                                    </select>   
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_StockInvestments_Institution_State1">Stock/Investment Institution State?</label>
                                    <input type="hidden" name="" id="Joint_StockInvestments_Institution_State1_Value" value="<?php if(isset($drstocksinvestments->Joint_StockInvestments_Institution_State1)){ echo $drstocksinvestments->Joint_StockInvestments_Institution_State1; } ?>">
                                    <select id="Joint_StockInvestments_Institution_State1" name="Joint_StockInvestments_Institution_State1" class="form-control 1_Joint_state_select">
                                        <option value="">Choose State</option>
                                    </select>   
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_StockInvestments_Acct_Num1">Account Number?</label>
                                    <input id="Joint_StockInvestments_Acct_Num1" type="text" class="form-control 1_Joint_stocksinvestments_inputs" name="Joint_StockInvestments_Acct_Num1" value="<?php if(isset($drstocksinvestments->Joint_StockInvestments_Acct_Num1)){ echo $drstocksinvestments->Joint_StockInvestments_Acct_Num1; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_StockInvestments_Date_Marriage_Value1">Marriage Date Value?</label>
                                    <input id="Joint_StockInvestments_Date_Marriage_Value1" type="number" class="form-control 1_Joint_stocksinvestments_inputs" name="Joint_StockInvestments_Date_Marriage_Value1" value="<?php if(isset($drstocksinvestments->Joint_StockInvestments_Date_Marriage_Value1)){ echo $drstocksinvestments->Joint_StockInvestments_Date_Marriage_Value1; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_StockInvestments_Current_Value1">Current Value?</label>
                                    <input id="Joint_StockInvestments_Current_Value1" type="number" class="form-control 1_Joint_stocksinvestments_inputs" name="Joint_StockInvestments_Current_Value1" value="<?php if(isset($drstocksinvestments->Joint_StockInvestments_Current_Value1)){ echo $drstocksinvestments->Joint_StockInvestments_Current_Value1; } ?>" min="0.00" step="0.01" max="999999.99" onchange="getJointCurrentValue(this, '1', 'Joint');" onkeyup="getJointCurrentValue(this, '1', 'Joint');"> 
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label for="Joint_StockInvestments_Percent_Marital_Equity1">N/A, calculated = Joint_StockInvestments_Institution_Current_Value1</label>
                                    <input id="Joint_StockInvestments_Percent_Marital_Equity1" type="number" class="form-control 1_Joint_stocksinvestments_inputs" name="Joint_StockInvestments_Percent_Marital_Equity1" value="<?php if(isset($drstocksinvestments->Joint_StockInvestments_Percent_Marital_Equity1)){ echo $drstocksinvestments->Joint_StockInvestments_Percent_Marital_Equity1; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_StockInvestments_Yearly_Interest_Dividend1">Yearly Interest and Dividends from this account?</label>
                                    <input id="Joint_StockInvestments_Yearly_Interest_Dividend1" type="number" class="form-control 1_Joint_stocksinvestments_inputs" name="Joint_StockInvestments_Yearly_Interest_Dividend1" value="<?php if(isset($drstocksinvestments->Joint_StockInvestments_Yearly_Interest_Dividend1)){ echo $drstocksinvestments->Joint_StockInvestments_Yearly_Interest_Dividend1; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Does either party claim a sole/separate interest from the other on this account?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Joint_StockInvestments_SoleSeparate_Claim1_Yes" name="Joint_StockInvestments_SoleSeparate_Claim1" value="Yes" data-onload="getInitialPartyClaimSoleSeparate(this, '1', 'Joint');" onchange="getPartyClaimSoleSeparate(this, '1', 'Joint');" <?php if(isset($drstocksinvestments->Joint_StockInvestments_SoleSeparate_Claim1) && $drstocksinvestments->Joint_StockInvestments_SoleSeparate_Claim1=='Yes'){ echo "checked"; } ?>> Yes</label>
                                        <label><input type="radio" id="Joint_StockInvestments_SoleSeparate_Claim1_No" name="Joint_StockInvestments_SoleSeparate_Claim1" value="No" data-onload="getInitialPartyClaimSoleSeparate(this, '1', 'Joint');" onchange="getPartyClaimSoleSeparate(this, '1', 'Joint');" <?php if(isset($drstocksinvestments->Joint_StockInvestments_SoleSeparate_Claim1) && $drstocksinvestments->Joint_StockInvestments_SoleSeparate_Claim1=='No'){ echo "checked"; } ?>> No</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6" id="Joint_StockInvestments_SoleSeparate_Party1_Div" style="display: none;">
                                    <label>Who claims to own this account?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Joint_StockInvestments_SoleSeparate_Party1_Client" name="Joint_StockInvestments_SoleSeparate_Party1" value="{{$client_name}}" <?php if(isset($drstocksinvestments->Joint_StockInvestments_SoleSeparate_Party1) && $drstocksinvestments->Joint_StockInvestments_SoleSeparate_Party1==$client_name){ echo "checked"; } ?>> {{$client_name}}</label>
                                        <label><input type="radio" id="Joint_StockInvestments_SoleSeparate_Party1_Op" name="Joint_StockInvestments_SoleSeparate_Party1" value="{{$opponent_name}}" <?php if(isset($drstocksinvestments->Joint_StockInvestments_SoleSeparate_Party1) && $drstocksinvestments->Joint_StockInvestments_SoleSeparate_Party1==$opponent_name){ echo "checked"; } ?>> {{$opponent_name}}</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 left-clear" id="Joint_StockInvestments_SoleSeparate_Grounds1_Div" style="display: none; clear: left;">
                                    <label for="Joint_StockInvestments_SoleSeparate_Grounds1">Why does this person own this account solely and separately?</label>
                                    <input id="Joint_StockInvestments_SoleSeparate_Grounds1" type="text" class="form-control 1_Joint_stocksinvestments_inputs" name="Joint_StockInvestments_SoleSeparate_Grounds1" value="<?php if(isset($drstocksinvestments->Joint_StockInvestments_SoleSeparate_Grounds1)){ echo $drstocksinvestments->Joint_StockInvestments_SoleSeparate_Grounds1; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>How will this account value be distributed between the parties?</label>
                                    <div class="w-100 dataInput">
                                        <label><input type="radio" id="Joint_StockInvestments_Disposition_Method1_Distribute_Investments" name="Joint_StockInvestments_Disposition_Method1" value="Distribute Investments" data-onload="getInitialDipositionMethod(this, '1', 'Joint');" onchange="getDipositionMethod(this, '1', 'Joint');" <?php if(isset($drstocksinvestments->Joint_StockInvestments_Disposition_Method1) && $drstocksinvestments->Joint_StockInvestments_Disposition_Method1=='Distribute Investments'){ echo "checked"; } ?>> Distribute Investments</label>
                                        <label><input type="radio" id="Joint_StockInvestments_Disposition_Method1_Liquidate_Split_Net_Value" name="Joint_StockInvestments_Disposition_Method1" value="Liquidate/Split Net Value" data-onload="getInitialDipositionMethod(this, '1', 'Joint');" onchange="getDipositionMethod(this, '1', 'Joint');" <?php if(isset($drstocksinvestments->Joint_StockInvestments_Disposition_Method1) && $drstocksinvestments->Joint_StockInvestments_Disposition_Method1=='Liquidate/Split Net Value'){ echo "checked"; } ?>> Liquidate/Split Net Value</label>
                                        <label><input type="radio" id="Joint_StockInvestments_Disposition_Method1_Percentage_Buyout" name="Joint_StockInvestments_Disposition_Method1" value="Percentage Buyout" data-onload="getInitialDipositionMethod(this, '1', 'Joint');" onchange="getDipositionMethod(this, '1', 'Joint');" <?php if(isset($drstocksinvestments->Joint_StockInvestments_Disposition_Method1) && $drstocksinvestments->Joint_StockInvestments_Disposition_Method1=='Percentage Buyout'){ echo "checked"; } ?>> Percentage Buyout</label>
                                        <label><input type="radio" id="Joint_StockInvestments_Disposition_Method1_Fixed Buyout" name="Joint_StockInvestments_Disposition_Method1" value="Fixed Buyout" data-onload="getInitialDipositionMethod(this, '1', 'Joint');" onchange="getDipositionMethod(this, '1', 'Joint');" <?php if(isset($drstocksinvestments->Joint_StockInvestments_Disposition_Method1) && $drstocksinvestments->Joint_StockInvestments_Disposition_Method1=='Fixed Buyout'){ echo "checked"; } ?>> Fixed Buyout</label>
                                    </div>
                                </div>
                                <!-- slider tool -->
                                <div class="form-group col-sm-6 m-auto 1_Joint_Slider_Tool slider-tool-main">
                                    <div class="row">
                                        <div class="col">{{$client_name}}</div>
                                        <div class="col text-right">{{$opponent_name}}</div>
                                    </div>
                                    <input id="1_Joint_balance_range_selector" type="range" class="form-control slider-tool-input 1_Joint_balance_range_selector" name="" value="<?php if(isset($drstocksinvestments->Joint_StockInvestments_Percent_Marital_Equity_to_Op1)){ echo $drstocksinvestments->Joint_StockInvestments_Percent_Marital_Equity_to_Op1; } ?>" min="0.00" step="0.01" max="100" onchange="updateBalanceInput(this.value, '1', 'Joint');">
                                </div>
                                <div class="form-group col-sm-6 m-auto 1_Joint_Slider_Tool slider-tool-main">
                                    <div class="row justify-content-between">
                                        <div class="col selectorTool">
                                            <div class="left-col">
                                                <div class="client-info 1_Joint_clientpercentage_div clientpercentage_div">
                                                    <?php if(isset($drstocksinvestments->Joint_StockInvestments_Percent_Marital_Equity_to_Client1)){ echo $drstocksinvestments->Joint_StockInvestments_Percent_Marital_Equity_to_Client1; } else {
                                                        echo "50.00";
                                                    } ?>%
                                                </div>
                                                <div class="client-info 1_Joint_clientamount_div clientamount_div" style="clear: both;">
                                                    $<?php if(isset($drstocksinvestments->Joint_StockInvestments_Estimated_Value_to_Client1)){ echo $drstocksinvestments->Joint_StockInvestments_Estimated_Value_to_Client1; }else {
                                                        echo "0.00";
                                                    } ?>
                                                </div>
                                            </div>
                                            <label>To {{$client_name}}</label>
                                        </div>                                       
                                        <div class="col selectorTool selectorToolRight">
                                            <label>To {{$opponent_name}}</label>
                                            <div class="left-col right-col">
                                                <div class="client-info 1_Joint_opponentpercentage_div opponentpercentage_div">
                                                    <?php if(isset($drstocksinvestments->Joint_StockInvestments_Percent_Marital_Equity_to_Op1)){ echo $drstocksinvestments->Joint_StockInvestments_Percent_Marital_Equity_to_Op1; } else {
                                                        echo "50.00";
                                                    } ?>%
                                                </div>
                                                <div class="client-info 1_Joint_opponentamount_div opponentamount_div" style="clear: both;">
                                                    $<?php if(isset($drstocksinvestments->Joint_StockInvestments_Estimated_Value_to_Op1)){ echo $drstocksinvestments->Joint_StockInvestments_Estimated_Value_to_Op1; }else {
                                                        echo "0.00";
                                                    } ?>
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
                                         <label><input type="radio" id="Joint_StockInvestments_Paying_Party1_Client" name="Joint_StockInvestments_Paying_Party1" value="{{$client_name}}" data-onload="getInitialStockInvestmentPayingParty(this, '1', 'Joint');" onchange="getStockInvestmentPayingParty(this, '1', 'Joint');"  <?php if(isset($drstocksinvestments->Joint_StockInvestments_Paying_Party1) && $drstocksinvestments->Joint_StockInvestments_Paying_Party1==$client_name){ echo "checked"; } ?>> {{$client_name}}</label>
                                        <label><input type="radio" id="Joint_StockInvestments_Paying_Party1_Op" name="Joint_StockInvestments_Paying_Party1" value="{{$opponent_name}}" data-onload="getInitialStockInvestmentPayingParty(this, '1', 'Joint');" onchange="getStockInvestmentPayingParty(this, '1', 'Joint');"  <?php if(isset($drstocksinvestments->Joint_StockInvestments_Paying_Party1) && $drstocksinvestments->Joint_StockInvestments_Paying_Party1==$opponent_name){ echo "checked"; } ?>> {{$opponent_name}}</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 Joint_StockInvestments_Paying_Party1_Inputs_Div" style="display: none;">
                                    <label>{{$client_name}} StockInvestment Equity Percent</label>
                                    <input id="Joint_StockInvestments_Percent_Marital_Equity_to_Client1" type="number" class="form-control 1_Joint_clientpercentage_input clientpercentage_input" name="Joint_StockInvestments_Percent_Marital_Equity_to_Client1" value="<?php if(isset($drstocksinvestments->Joint_StockInvestments_Percent_Marital_Equity_to_Client1)){ echo $drstocksinvestments->Joint_StockInvestments_Percent_Marital_Equity_to_Client1; } ?>" min="0.00" step="0.01" max="100" readonly="">
                                </div>
                                <div class="form-group col-sm-6 Joint_StockInvestments_Paying_Party1_Inputs_Div" style="display: none;">
                                    <label>How much is to be paid to {{$client_name}}?</label>
                                    <input id="Joint_StockInvestments_Estimated_Value_to_Client1" type="number" class="form-control 1_Joint_clientamount_input clientamount_input" name="Joint_StockInvestments_Estimated_Value_to_Client1" value="<?php if(isset($drstocksinvestments->Joint_StockInvestments_Estimated_Value_to_Client1)){ echo $drstocksinvestments->Joint_StockInvestments_Estimated_Value_to_Client1; } ?>" min="0.00" step="0.01" max="999999.99" readonly="" onchange="getEstimatedValueClient(this, '1', 'Joint');" onkeyup="getEstimatedValueClient(this, '1', 'Joint');">
                                </div>
                                <div class="form-group col-sm-6 Joint_StockInvestments_Paying_Party1_Inputs_Div" style="display: none;">
                                    <label>{{$opponent_name}} StockInvestment Equity Percent</label>
                                    <input id="Joint_StockInvestments_Percent_Marital_Equity_to_Op1" type="number" class="form-control 1_Joint_opponentpercentage_input opponentpercentage_input" name="Joint_StockInvestments_Percent_Marital_Equity_to_Op1" value="<?php if(isset($drstocksinvestments->Joint_StockInvestments_Percent_Marital_Equity_to_Op1)){ echo $drstocksinvestments->Joint_StockInvestments_Percent_Marital_Equity_to_Op1; } ?>" min="0.00" step="0.01" max="100" readonly="">
                                </div>
                                <div class="form-group col-sm-6 Joint_StockInvestments_Paying_Party1_Inputs_Div" style="display: none;">
                                    <label>How much is to be paid to {{$opponent_name}}?</label>
                                    <input id="Joint_StockInvestments_Estimated_Value_to_Op1" type="number" class="form-control 1_Joint_opponentamount_input opponentamount_input" name="Joint_StockInvestments_Estimated_Value_to_Op1" value="<?php if(isset($drstocksinvestments->Joint_StockInvestments_Estimated_Value_to_Op1)){ echo $drstocksinvestments->Joint_StockInvestments_Estimated_Value_to_Op1; } ?>" min="0.00" step="0.01" max="999999.99" readonly="" onchange="getEstimatedValueOp(this, '1', 'Joint');" onkeyup="getEstimatedValueOp(this, '1', 'Joint');">
                                </div>
                                <!-- end of slider tool -->
                            </div>
                            <div class="col-sm-12 mt-4 2_Joint_stocksinvestments_section" style="display: none;"><h5 class="col-sm-12">Second Stock Investment Info</h5>
                                <div class="form-group col-sm-6">
                                    <p class="text-danger 2_Joint_no-state-county-found" style="display: none;">No City, State, County found for this zipcode.</p>
                                    <label for="Joint_StockInvestments_Institution_ZIP2">Stock/Investment Institution Zip Code?</label>
                                    <input id="Joint_StockInvestments_Institution_ZIP2" type="text" class="form-control 2_Joint_stocksinvestments_inputs" name="Joint_StockInvestments_Institution_ZIP2" value="<?php if(isset($drstocksinvestments->Joint_StockInvestments_Institution_ZIP2)){ echo $drstocksinvestments->Joint_StockInvestments_Institution_ZIP2; } ?>" data-onload="getCityStateForZip(this, '2', 'Joint');" onkeyup="getCityStateForZip(this, '2', 'Joint');"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_StockInvestments_Institution_Name2">Name of Stock/Investment Institution?</label>
                                    <input id="Joint_StockInvestments_Institution_Name2" type="text" class="form-control 2_Joint_stocksinvestments_inputs" name="Joint_StockInvestments_Institution_Name2" value="<?php if(isset($drstocksinvestments->Joint_StockInvestments_Institution_Name2)){ echo $drstocksinvestments->Joint_StockInvestments_Institution_Name2; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_StockInvestments_Institution_Street_Address2">Stock/Investment Institution Street Address?</label>
                                    <input id="Joint_StockInvestments_Institution_Street_Address2" type="text" class="form-control 2_Joint_stocksinvestments_inputs" name="Joint_StockInvestments_Institution_Street_Address2" value="<?php if(isset($drstocksinvestments->Joint_StockInvestments_Institution_Street_Address2)){ echo $drstocksinvestments->Joint_StockInvestments_Institution_Street_Address2; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_StockInvestments_Institution_City2">Stock/Investment Institution City?</label>
                                    <input type="hidden" name="" id="Joint_StockInvestments_Institution_City2_Value" value="<?php if(isset($drstocksinvestments->Joint_StockInvestments_Institution_City2)){ echo $drstocksinvestments->Joint_StockInvestments_Institution_City2; } ?>">
                                    <select id="Joint_StockInvestments_Institution_City2" name="Joint_StockInvestments_Institution_City2" class="form-control 2_Joint_city_select">
                                        <option value="">Choose City</option>
                                    </select>   
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_StockInvestments_Institution_State2">Stock/Investment Institution State?</label>
                                    <input type="hidden" name="" id="Joint_StockInvestments_Institution_State2_Value" value="<?php if(isset($drstocksinvestments->Joint_StockInvestments_Institution_State2)){ echo $drstocksinvestments->Joint_StockInvestments_Institution_State2; } ?>">
                                    <select id="Joint_StockInvestments_Institution_State2" name="Joint_StockInvestments_Institution_State2" class="form-control 2_Joint_state_select">
                                        <option value="">Choose State</option>
                                    </select>   
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_StockInvestments_Acct_Num2">Account Number?</label>
                                    <input id="Joint_StockInvestments_Acct_Num2" type="text" class="form-control 2_Joint_stocksinvestments_inputs" name="Joint_StockInvestments_Acct_Num2" value="<?php if(isset($drstocksinvestments->Joint_StockInvestments_Acct_Num2)){ echo $drstocksinvestments->Joint_StockInvestments_Acct_Num2; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_StockInvestments_Date_Marriage_Value2">Marriage Date Value?</label>
                                    <input id="Joint_StockInvestments_Date_Marriage_Value2" type="number" class="form-control 2_Joint_stocksinvestments_inputs" name="Joint_StockInvestments_Date_Marriage_Value2" value="<?php if(isset($drstocksinvestments->Joint_StockInvestments_Date_Marriage_Value2)){ echo $drstocksinvestments->Joint_StockInvestments_Date_Marriage_Value2; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_StockInvestments_Current_Value2">Current Value?</label>
                                    <input id="Joint_StockInvestments_Current_Value2" type="number" class="form-control 2_Joint_stocksinvestments_inputs" name="Joint_StockInvestments_Current_Value2" value="<?php if(isset($drstocksinvestments->Joint_StockInvestments_Current_Value2)){ echo $drstocksinvestments->Joint_StockInvestments_Current_Value2; } ?>" min="0.00" step="0.01" max="999999.99" onchange="getJointCurrentValue(this, '2', 'Joint');" onkeyup="getJointCurrentValue(this, '2', 'Joint');"> 
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label for="Joint_StockInvestments_Percent_Marital_Equity2">N/A, calculated = Joint_StockInvestments_Institution_Current_Value2</label>
                                    <input id="Joint_StockInvestments_Percent_Marital_Equity2" type="number" class="form-control 2_Joint_stocksinvestments_inputs" name="Joint_StockInvestments_Percent_Marital_Equity2" value="<?php if(isset($drstocksinvestments->Joint_StockInvestments_Percent_Marital_Equity2)){ echo $drstocksinvestments->Joint_StockInvestments_Percent_Marital_Equity2; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_StockInvestments_Yearly_Interest_Dividend2">Yearly Interest and Dividends from this account?</label>
                                    <input id="Joint_StockInvestments_Yearly_Interest_Dividend2" type="number" class="form-control 2_Joint_stocksinvestments_inputs" name="Joint_StockInvestments_Yearly_Interest_Dividend2" value="<?php if(isset($drstocksinvestments->Joint_StockInvestments_Yearly_Interest_Dividend2)){ echo $drstocksinvestments->Joint_StockInvestments_Yearly_Interest_Dividend2; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Does either party claim a sole/separate interest from the other on this account?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Joint_StockInvestments_SoleSeparate_Claim2_Yes" name="Joint_StockInvestments_SoleSeparate_Claim2" value="Yes" data-onload="getInitialPartyClaimSoleSeparate(this, '2', 'Joint');" onchange="getPartyClaimSoleSeparate(this, '2', 'Joint');" <?php if(isset($drstocksinvestments->Joint_StockInvestments_SoleSeparate_Claim2) && $drstocksinvestments->Joint_StockInvestments_SoleSeparate_Claim2=='Yes'){ echo "checked"; } ?>> Yes</label>
                                        <label><input type="radio" id="Joint_StockInvestments_SoleSeparate_Claim2_No" name="Joint_StockInvestments_SoleSeparate_Claim2" value="No" data-onload="getInitialPartyClaimSoleSeparate(this, '2', 'Joint');" onchange="getPartyClaimSoleSeparate(this, '2', 'Joint');" <?php if(isset($drstocksinvestments->Joint_StockInvestments_SoleSeparate_Claim2) && $drstocksinvestments->Joint_StockInvestments_SoleSeparate_Claim2=='No'){ echo "checked"; } ?>> No</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6" id="Joint_StockInvestments_SoleSeparate_Party2_Div" style="display: none;">
                                    <label>Who claims to own this account?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Joint_StockInvestments_SoleSeparate_Party2_Client" name="Joint_StockInvestments_SoleSeparate_Party2" value="{{$client_name}}" <?php if(isset($drstocksinvestments->Joint_StockInvestments_SoleSeparate_Party2) && $drstocksinvestments->Joint_StockInvestments_SoleSeparate_Party2==$client_name){ echo "checked"; } ?>> {{$client_name}}</label>
                                        <label><input type="radio" id="Joint_StockInvestments_SoleSeparate_Party2_Op" name="Joint_StockInvestments_SoleSeparate_Party2" value="{{$opponent_name}}" <?php if(isset($drstocksinvestments->Joint_StockInvestments_SoleSeparate_Party2) && $drstocksinvestments->Joint_StockInvestments_SoleSeparate_Party2==$opponent_name){ echo "checked"; } ?>> {{$opponent_name}}</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 left-clear" id="Joint_StockInvestments_SoleSeparate_Grounds2_Div" style="display: none; clear: left;">
                                    <label for="Joint_StockInvestments_SoleSeparate_Grounds2">Why does this person own this account solely and separately?</label>
                                    <input id="Joint_StockInvestments_SoleSeparate_Grounds2" type="text" class="form-control 2_Joint_stocksinvestments_inputs" name="Joint_StockInvestments_SoleSeparate_Grounds2" value="<?php if(isset($drstocksinvestments->Joint_StockInvestments_SoleSeparate_Grounds2)){ echo $drstocksinvestments->Joint_StockInvestments_SoleSeparate_Grounds2; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>How will this account value be distributed between the parties?</label>
                                    <div class="w-100 dataInput">
                                        <label><input type="radio" id="Joint_StockInvestments_Disposition_Method2_Distribute_Investments" name="Joint_StockInvestments_Disposition_Method2" value="Distribute Investments" data-onload="getInitialDipositionMethod(this, '2', 'Joint');" onchange="getDipositionMethod(this, '2', 'Joint');" <?php if(isset($drstocksinvestments->Joint_StockInvestments_Disposition_Method2) && $drstocksinvestments->Joint_StockInvestments_Disposition_Method2=='Distribute Investments'){ echo "checked"; } ?>> Distribute Investments</label>
                                        <label><input type="radio" id="Joint_StockInvestments_Disposition_Method2_Liquidate_Split_Net_Value" name="Joint_StockInvestments_Disposition_Method2" value="Liquidate/Split Net Value" data-onload="getInitialDipositionMethod(this, '2', 'Joint');" onchange="getDipositionMethod(this, '2', 'Joint');" <?php if(isset($drstocksinvestments->Joint_StockInvestments_Disposition_Method2) && $drstocksinvestments->Joint_StockInvestments_Disposition_Method2=='Liquidate/Split Net Value'){ echo "checked"; } ?>> Liquidate/Split Net Value</label>
                                        <label><input type="radio" id="Joint_StockInvestments_Disposition_Method2_Percentage_Buyout" name="Joint_StockInvestments_Disposition_Method2" value="Percentage Buyout" data-onload="getInitialDipositionMethod(this, '2', 'Joint');" onchange="getDipositionMethod(this, '2', 'Joint');" <?php if(isset($drstocksinvestments->Joint_StockInvestments_Disposition_Method2) && $drstocksinvestments->Joint_StockInvestments_Disposition_Method2=='Percentage Buyout'){ echo "checked"; } ?>> Percentage Buyout</label>
                                        <label><input type="radio" id="Joint_StockInvestments_Disposition_Method2_Fixed Buyout" name="Joint_StockInvestments_Disposition_Method2" value="Fixed Buyout" data-onload="getInitialDipositionMethod(this, '2', 'Joint');" onchange="getDipositionMethod(this, '2', 'Joint');" <?php if(isset($drstocksinvestments->Joint_StockInvestments_Disposition_Method2) && $drstocksinvestments->Joint_StockInvestments_Disposition_Method2=='Fixed Buyout'){ echo "checked"; } ?>> Fixed Buyout</label>
                                    </div>
                                </div>
                                <!-- slider tool -->
                                <div class="form-group col-sm-6 m-auto 2_Joint_Slider_Tool slider-tool-main">
                                    <div class="row">
                                        <div class="col">{{$client_name}}</div>
                                        <div class="col text-right">{{$opponent_name}}</div>
                                    </div>
                                    <input id="2_Joint_balance_range_selector" type="range" class="form-control slider-tool-input 2_Joint_balance_range_selector" name="" value="<?php if(isset($drstocksinvestments->Joint_StockInvestments_Percent_Marital_Equity_to_Op2)){ echo $drstocksinvestments->Joint_StockInvestments_Percent_Marital_Equity_to_Op2; } ?>" min="0.00" step="0.01" max="100" onchange="updateBalanceInput(this.value, '2', 'Joint');">
                                </div>
                                <div class="form-group col-sm-6 m-auto 2_Joint_Slider_Tool slider-tool-main">
                                    <div class="row justify-content-between">
                                        <div class="col selectorTool">
                                            <div class="left-col">
                                                <div class="client-info 2_Joint_clientpercentage_div clientpercentage_div">
                                                    <?php if(isset($drstocksinvestments->Joint_StockInvestments_Percent_Marital_Equity_to_Client2)){ echo $drstocksinvestments->Joint_StockInvestments_Percent_Marital_Equity_to_Client2; } else {
                                                        echo "50.00";
                                                    } ?>%
                                                </div>
                                                <div class="client-info 2_Joint_clientamount_div clientamount_div" style="clear: both;">
                                                    $<?php if(isset($drstocksinvestments->Joint_StockInvestments_Estimated_Value_to_Client2)){ echo $drstocksinvestments->Joint_StockInvestments_Estimated_Value_to_Client2; }else {
                                                        echo "0.00";
                                                    } ?>
                                                </div>
                                            </div>
                                            <label>To {{$client_name}}</label>
                                        </div>                                       
                                        <div class="col selectorTool selectorToolRight">
                                            <label>To {{$opponent_name}}</label>
                                            <div class="left-col right-col">
                                                <div class="client-info 2_Joint_opponentpercentage_div opponentpercentage_div">
                                                    <?php if(isset($drstocksinvestments->Joint_StockInvestments_Percent_Marital_Equity_to_Op2)){ echo $drstocksinvestments->Joint_StockInvestments_Percent_Marital_Equity_to_Op2; } else {
                                                        echo "50.00";
                                                    } ?>%
                                                </div>
                                                <div class="client-info 2_Joint_opponentamount_div opponentamount_div" style="clear: both;">
                                                    $<?php if(isset($drstocksinvestments->Joint_StockInvestments_Estimated_Value_to_Op2)){ echo $drstocksinvestments->Joint_StockInvestments_Estimated_Value_to_Op2; }else {
                                                        echo "0.00";
                                                    } ?>
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
                                         <label><input type="radio" id="Joint_StockInvestments_Paying_Party2_Client" name="Joint_StockInvestments_Paying_Party2" value="{{$client_name}}" data-onload="getInitialStockInvestmentPayingParty(this, '2', 'Joint');" onchange="getStockInvestmentPayingParty(this, '2', 'Joint');"  <?php if(isset($drstocksinvestments->Joint_StockInvestments_Paying_Party2) && $drstocksinvestments->Joint_StockInvestments_Paying_Party2==$client_name){ echo "checked"; } ?>> {{$client_name}}</label>
                                        <label><input type="radio" id="Joint_StockInvestments_Paying_Party2_Op" name="Joint_StockInvestments_Paying_Party2" value="{{$opponent_name}}" data-onload="getInitialStockInvestmentPayingParty(this, '2', 'Joint');" onchange="getStockInvestmentPayingParty(this, '2', 'Joint');"  <?php if(isset($drstocksinvestments->Joint_StockInvestments_Paying_Party2) && $drstocksinvestments->Joint_StockInvestments_Paying_Party2==$opponent_name){ echo "checked"; } ?>> {{$opponent_name}}</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 Joint_StockInvestments_Paying_Party2_Inputs_Div" style="display: none;">
                                    <label>{{$client_name}} StockInvestment Equity Percent</label>
                                    <input id="Joint_StockInvestments_Percent_Marital_Equity_to_Client2" type="number" class="form-control 2_Joint_clientpercentage_input clientpercentage_input" name="Joint_StockInvestments_Percent_Marital_Equity_to_Client2" value="<?php if(isset($drstocksinvestments->Joint_StockInvestments_Percent_Marital_Equity_to_Client2)){ echo $drstocksinvestments->Joint_StockInvestments_Percent_Marital_Equity_to_Client2; } ?>" min="0.00" step="0.01" max="100" readonly="">
                                </div>
                                <div class="form-group col-sm-6 Joint_StockInvestments_Paying_Party2_Inputs_Div" style="display: none;">
                                    <label>How much is to be paid to {{$client_name}}?</label>
                                    <input id="Joint_StockInvestments_Estimated_Value_to_Client2" type="number" class="form-control 2_Joint_clientamount_input clientamount_input" name="Joint_StockInvestments_Estimated_Value_to_Client2" value="<?php if(isset($drstocksinvestments->Joint_StockInvestments_Estimated_Value_to_Client2)){ echo $drstocksinvestments->Joint_StockInvestments_Estimated_Value_to_Client2; } ?>" min="0.00" step="0.01" max="999999.99" readonly="" onchange="getEstimatedValueClient(this, '2', 'Joint');" onkeyup="getEstimatedValueClient(this, '2', 'Joint');">
                                </div>
                                <div class="form-group col-sm-6 Joint_StockInvestments_Paying_Party2_Inputs_Div" style="display: none;">
                                    <label>{{$opponent_name}} StockInvestment Equity Percent</label>
                                    <input id="Joint_StockInvestments_Percent_Marital_Equity_to_Op2" type="number" class="form-control 2_Joint_opponentpercentage_input opponentpercentage_input" name="Joint_StockInvestments_Percent_Marital_Equity_to_Op2" value="<?php if(isset($drstocksinvestments->Joint_StockInvestments_Percent_Marital_Equity_to_Op2)){ echo $drstocksinvestments->Joint_StockInvestments_Percent_Marital_Equity_to_Op2; } ?>" min="0.00" step="0.01" max="100" readonly="">
                                </div>
                                <div class="form-group col-sm-6 Joint_StockInvestments_Paying_Party2_Inputs_Div" style="display: none;">
                                    <label>How much is to be paid to {{$opponent_name}}?</label>
                                    <input id="Joint_StockInvestments_Estimated_Value_to_Op2" type="number" class="form-control 2_Joint_opponentamount_input opponentamount_input" name="Joint_StockInvestments_Estimated_Value_to_Op2" value="<?php if(isset($drstocksinvestments->Joint_StockInvestments_Estimated_Value_to_Op2)){ echo $drstocksinvestments->Joint_StockInvestments_Estimated_Value_to_Op2; } ?>" min="0.00" step="0.01" max="999999.99" readonly="" onchange="getEstimatedValueOp(this, '2', 'Joint');" onkeyup="getEstimatedValueOp(this, '2', 'Joint');">
                                </div>
                                <!-- end of slider tool -->
                            </div>
                            <div class="col-sm-12 mt-4 3_Joint_stocksinvestments_section" style="display: none;"><h5 class="col-sm-12">Third Stock Investment Info</h5>
                                <div class="form-group col-sm-6">
                                    <p class="text-danger 3_Joint_no-state-county-found" style="display: none;">No City, State, County found for this zipcode.</p>
                                    <label for="Joint_StockInvestments_Institution_ZIP3">Stock/Investment Institution Zip Code?</label>
                                    <input id="Joint_StockInvestments_Institution_ZIP3" type="text" class="form-control 3_Joint_stocksinvestments_inputs" name="Joint_StockInvestments_Institution_ZIP3" value="<?php if(isset($drstocksinvestments->Joint_StockInvestments_Institution_ZIP3)){ echo $drstocksinvestments->Joint_StockInvestments_Institution_ZIP3; } ?>" data-onload="getCityStateForZip(this, '3', 'Joint');" onkeyup="getCityStateForZip(this, '3', 'Joint');"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_StockInvestments_Institution_Name3">Name of Stock/Investment Institution?</label>
                                    <input id="Joint_StockInvestments_Institution_Name3" type="text" class="form-control 3_Joint_stocksinvestments_inputs" name="Joint_StockInvestments_Institution_Name3" value="<?php if(isset($drstocksinvestments->Joint_StockInvestments_Institution_Name3)){ echo $drstocksinvestments->Joint_StockInvestments_Institution_Name3; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_StockInvestments_Institution_Street_Address3">Stock/Investment Institution Street Address?</label>
                                    <input id="Joint_StockInvestments_Institution_Street_Address3" type="text" class="form-control 3_Joint_stocksinvestments_inputs" name="Joint_StockInvestments_Institution_Street_Address3" value="<?php if(isset($drstocksinvestments->Joint_StockInvestments_Institution_Street_Address3)){ echo $drstocksinvestments->Joint_StockInvestments_Institution_Street_Address3; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_StockInvestments_Institution_City3">Stock/Investment Institution City?</label>
                                    <input type="hidden" name="" id="Joint_StockInvestments_Institution_City3_Value" value="<?php if(isset($drstocksinvestments->Joint_StockInvestments_Institution_City3)){ echo $drstocksinvestments->Joint_StockInvestments_Institution_City3; } ?>">
                                    <select id="Joint_StockInvestments_Institution_City3" name="Joint_StockInvestments_Institution_City3" class="form-control 3_Joint_city_select">
                                        <option value="">Choose City</option>
                                    </select>   
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_StockInvestments_Institution_State3">Stock/Investment Institution State?</label>
                                    <input type="hidden" name="" id="Joint_StockInvestments_Institution_State3_Value" value="<?php if(isset($drstocksinvestments->Joint_StockInvestments_Institution_State3)){ echo $drstocksinvestments->Joint_StockInvestments_Institution_State3; } ?>">
                                    <select id="Joint_StockInvestments_Institution_State3" name="Joint_StockInvestments_Institution_State3" class="form-control 3_Joint_state_select">
                                        <option value="">Choose State</option>
                                    </select>   
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_StockInvestments_Acct_Num3">Account Number?</label>
                                    <input id="Joint_StockInvestments_Acct_Num3" type="text" class="form-control 3_Joint_stocksinvestments_inputs" name="Joint_StockInvestments_Acct_Num3" value="<?php if(isset($drstocksinvestments->Joint_StockInvestments_Acct_Num3)){ echo $drstocksinvestments->Joint_StockInvestments_Acct_Num3; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_StockInvestments_Date_Marriage_Value3">Marriage Date Value?</label>
                                    <input id="Joint_StockInvestments_Date_Marriage_Value3" type="number" class="form-control 3_Joint_stocksinvestments_inputs" name="Joint_StockInvestments_Date_Marriage_Value3" value="<?php if(isset($drstocksinvestments->Joint_StockInvestments_Date_Marriage_Value3)){ echo $drstocksinvestments->Joint_StockInvestments_Date_Marriage_Value3; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_StockInvestments_Current_Value3">Current Value?</label>
                                    <input id="Joint_StockInvestments_Current_Value3" type="number" class="form-control 3_Joint_stocksinvestments_inputs" name="Joint_StockInvestments_Current_Value3" value="<?php if(isset($drstocksinvestments->Joint_StockInvestments_Current_Value3)){ echo $drstocksinvestments->Joint_StockInvestments_Current_Value3; } ?>" min="0.00" step="0.01" max="999999.99" onchange="getJointCurrentValue(this, '3', 'Joint');" onkeyup="getJointCurrentValue(this, '3', 'Joint');"> 
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label for="Joint_StockInvestments_Percent_Marital_Equity3">N/A, calculated = Joint_StockInvestments_Institution_Current_Value3</label>
                                    <input id="Joint_StockInvestments_Percent_Marital_Equity3" type="number" class="form-control 3_Joint_stocksinvestments_inputs" name="Joint_StockInvestments_Percent_Marital_Equity3" value="<?php if(isset($drstocksinvestments->Joint_StockInvestments_Percent_Marital_Equity3)){ echo $drstocksinvestments->Joint_StockInvestments_Percent_Marital_Equity3; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_StockInvestments_Yearly_Interest_Dividend3">Yearly Interest and Dividends from this account?</label>
                                    <input id="Joint_StockInvestments_Yearly_Interest_Dividend3" type="number" class="form-control 3_Joint_stocksinvestments_inputs" name="Joint_StockInvestments_Yearly_Interest_Dividend3" value="<?php if(isset($drstocksinvestments->Joint_StockInvestments_Yearly_Interest_Dividend3)){ echo $drstocksinvestments->Joint_StockInvestments_Yearly_Interest_Dividend3; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Does either party claim a sole/separate interest from the other on this account?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Joint_StockInvestments_SoleSeparate_Claim3_Yes" name="Joint_StockInvestments_SoleSeparate_Claim3" value="Yes" data-onload="getInitialPartyClaimSoleSeparate(this, '3', 'Joint');" onchange="getPartyClaimSoleSeparate(this, '3', 'Joint');" <?php if(isset($drstocksinvestments->Joint_StockInvestments_SoleSeparate_Claim3) && $drstocksinvestments->Joint_StockInvestments_SoleSeparate_Claim3=='Yes'){ echo "checked"; } ?>> Yes</label>
                                        <label><input type="radio" id="Joint_StockInvestments_SoleSeparate_Claim3_No" name="Joint_StockInvestments_SoleSeparate_Claim3" value="No" data-onload="getInitialPartyClaimSoleSeparate(this, '3', 'Joint');" onchange="getPartyClaimSoleSeparate(this, '3', 'Joint');" <?php if(isset($drstocksinvestments->Joint_StockInvestments_SoleSeparate_Claim3) && $drstocksinvestments->Joint_StockInvestments_SoleSeparate_Claim3=='No'){ echo "checked"; } ?>> No</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6" id="Joint_StockInvestments_SoleSeparate_Party3_Div" style="display: none;">
                                    <label>Who claims to own this account?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Joint_StockInvestments_SoleSeparate_Party3_Client" name="Joint_StockInvestments_SoleSeparate_Party3" value="{{$client_name}}" <?php if(isset($drstocksinvestments->Joint_StockInvestments_SoleSeparate_Party3) && $drstocksinvestments->Joint_StockInvestments_SoleSeparate_Party3==$client_name){ echo "checked"; } ?>> {{$client_name}}</label>
                                        <label><input type="radio" id="Joint_StockInvestments_SoleSeparate_Party3_Op" name="Joint_StockInvestments_SoleSeparate_Party3" value="{{$opponent_name}}" <?php if(isset($drstocksinvestments->Joint_StockInvestments_SoleSeparate_Party3) && $drstocksinvestments->Joint_StockInvestments_SoleSeparate_Party3==$opponent_name){ echo "checked"; } ?>> {{$opponent_name}}</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 left-clear" id="Joint_StockInvestments_SoleSeparate_Grounds3_Div" style="display: none; clear: left;">
                                    <label for="Joint_StockInvestments_SoleSeparate_Grounds3">Why does this person own this account solely and separately?</label>
                                    <input id="Joint_StockInvestments_SoleSeparate_Grounds3" type="text" class="form-control 3_Joint_stocksinvestments_inputs" name="Joint_StockInvestments_SoleSeparate_Grounds3" value="<?php if(isset($drstocksinvestments->Joint_StockInvestments_SoleSeparate_Grounds3)){ echo $drstocksinvestments->Joint_StockInvestments_SoleSeparate_Grounds3; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>How will this account value be distributed between the parties?</label>
                                    <div class="w-100 dataInput">
                                        <label><input type="radio" id="Joint_StockInvestments_Disposition_Method3_Distribute_Investments" name="Joint_StockInvestments_Disposition_Method3" value="Distribute Investments" data-onload="getInitialDipositionMethod(this, '3', 'Joint');" onchange="getDipositionMethod(this, '3', 'Joint');" <?php if(isset($drstocksinvestments->Joint_StockInvestments_Disposition_Method3) && $drstocksinvestments->Joint_StockInvestments_Disposition_Method3=='Distribute Investments'){ echo "checked"; } ?>> Distribute Investments</label>
                                        <label><input type="radio" id="Joint_StockInvestments_Disposition_Method3_Liquidate_Split_Net_Value" name="Joint_StockInvestments_Disposition_Method3" value="Liquidate/Split Net Value" data-onload="getInitialDipositionMethod(this, '3', 'Joint');" onchange="getDipositionMethod(this, '3', 'Joint');" <?php if(isset($drstocksinvestments->Joint_StockInvestments_Disposition_Method3) && $drstocksinvestments->Joint_StockInvestments_Disposition_Method3=='Liquidate/Split Net Value'){ echo "checked"; } ?>> Liquidate/Split Net Value</label>
                                        <label><input type="radio" id="Joint_StockInvestments_Disposition_Method3_Percentage_Buyout" name="Joint_StockInvestments_Disposition_Method3" value="Percentage Buyout" data-onload="getInitialDipositionMethod(this, '3', 'Joint');" onchange="getDipositionMethod(this, '3', 'Joint');" <?php if(isset($drstocksinvestments->Joint_StockInvestments_Disposition_Method3) && $drstocksinvestments->Joint_StockInvestments_Disposition_Method3=='Percentage Buyout'){ echo "checked"; } ?>> Percentage Buyout</label>
                                        <label><input type="radio" id="Joint_StockInvestments_Disposition_Method3_Fixed Buyout" name="Joint_StockInvestments_Disposition_Method3" value="Fixed Buyout" data-onload="getInitialDipositionMethod(this, '3', 'Joint');" onchange="getDipositionMethod(this, '3', 'Joint');" <?php if(isset($drstocksinvestments->Joint_StockInvestments_Disposition_Method3) && $drstocksinvestments->Joint_StockInvestments_Disposition_Method3=='Fixed Buyout'){ echo "checked"; } ?>> Fixed Buyout</label>
                                    </div>
                                </div>
                                <!-- slider tool -->
                                <div class="form-group col-sm-6 m-auto 3_Joint_Slider_Tool slider-tool-main">
                                    <div class="row">
                                        <div class="col">{{$client_name}}</div>
                                        <div class="col text-right">{{$opponent_name}}</div>
                                    </div>
                                    <input id="3_Joint_balance_range_selector" type="range" class="form-control slider-tool-input 3_Joint_balance_range_selector" name="" value="<?php if(isset($drstocksinvestments->Joint_StockInvestments_Percent_Marital_Equity_to_Op3)){ echo $drstocksinvestments->Joint_StockInvestments_Percent_Marital_Equity_to_Op3; } ?>" min="0.00" step="0.01" max="100" onchange="updateBalanceInput(this.value, '3', 'Joint');">
                                </div>
                                <div class="form-group col-sm-6 m-auto 3_Joint_Slider_Tool slider-tool-main">
                                    <div class="row justify-content-between">
                                        <div class="col selectorTool">
                                            <div class="left-col">
                                                <div class="client-info 3_Joint_clientpercentage_div clientpercentage_div">
                                                    <?php if(isset($drstocksinvestments->Joint_StockInvestments_Percent_Marital_Equity_to_Client3)){ echo $drstocksinvestments->Joint_StockInvestments_Percent_Marital_Equity_to_Client3; } else {
                                                        echo "50.00";
                                                    } ?>%
                                                </div>
                                                <div class="client-info 3_Joint_clientamount_div clientamount_div" style="clear: both;">
                                                    $<?php if(isset($drstocksinvestments->Joint_StockInvestments_Estimated_Value_to_Client3)){ echo $drstocksinvestments->Joint_StockInvestments_Estimated_Value_to_Client3; }else {
                                                        echo "0.00";
                                                    } ?>
                                                </div>
                                            </div>
                                            <label>To {{$client_name}}</label>
                                        </div>                                       
                                        <div class="col selectorTool selectorToolRight">
                                            <label>To {{$opponent_name}}</label>
                                            <div class="left-col right-col">
                                                <div class="client-info 3_Joint_opponentpercentage_div opponentpercentage_div">
                                                    <?php if(isset($drstocksinvestments->Joint_StockInvestments_Percent_Marital_Equity_to_Op3)){ echo $drstocksinvestments->Joint_StockInvestments_Percent_Marital_Equity_to_Op3; } else {
                                                        echo "50.00";
                                                    } ?>%
                                                </div>
                                                <div class="client-info 3_Joint_opponentamount_div opponentamount_div" style="clear: both;">
                                                    $<?php if(isset($drstocksinvestments->Joint_StockInvestments_Estimated_Value_to_Op3)){ echo $drstocksinvestments->Joint_StockInvestments_Estimated_Value_to_Op3; }else {
                                                        echo "0.00";
                                                    } ?>
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
                                         <label><input type="radio" id="Joint_StockInvestments_Paying_Party3_Client" name="Joint_StockInvestments_Paying_Party3" value="{{$client_name}}" data-onload="getInitialStockInvestmentPayingParty(this, '3', 'Joint');" onchange="getStockInvestmentPayingParty(this, '3', 'Joint');"  <?php if(isset($drstocksinvestments->Joint_StockInvestments_Paying_Party3) && $drstocksinvestments->Joint_StockInvestments_Paying_Party3==$client_name){ echo "checked"; } ?>> {{$client_name}}</label>
                                        <label><input type="radio" id="Joint_StockInvestments_Paying_Party3_Op" name="Joint_StockInvestments_Paying_Party3" value="{{$opponent_name}}" data-onload="getInitialStockInvestmentPayingParty(this, '3', 'Joint');" onchange="getStockInvestmentPayingParty(this, '3', 'Joint');"  <?php if(isset($drstocksinvestments->Joint_StockInvestments_Paying_Party3) && $drstocksinvestments->Joint_StockInvestments_Paying_Party3==$opponent_name){ echo "checked"; } ?>> {{$opponent_name}}</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 Joint_StockInvestments_Paying_Party3_Inputs_Div" style="display: none;">
                                    <label>{{$client_name}} StockInvestment Equity Percent</label>
                                    <input id="Joint_StockInvestments_Percent_Marital_Equity_to_Client3" type="number" class="form-control 3_Joint_clientpercentage_input clientpercentage_input" name="Joint_StockInvestments_Percent_Marital_Equity_to_Client3" value="<?php if(isset($drstocksinvestments->Joint_StockInvestments_Percent_Marital_Equity_to_Client3)){ echo $drstocksinvestments->Joint_StockInvestments_Percent_Marital_Equity_to_Client3; } ?>" min="0.00" step="0.01" max="100" readonly="">
                                </div>
                                <div class="form-group col-sm-6 Joint_StockInvestments_Paying_Party3_Inputs_Div" style="display: none;">
                                    <label>How much is to be paid to {{$client_name}}?</label>
                                    <input id="Joint_StockInvestments_Estimated_Value_to_Client3" type="number" class="form-control 3_Joint_clientamount_input clientamount_input" name="Joint_StockInvestments_Estimated_Value_to_Client3" value="<?php if(isset($drstocksinvestments->Joint_StockInvestments_Estimated_Value_to_Client3)){ echo $drstocksinvestments->Joint_StockInvestments_Estimated_Value_to_Client3; } ?>" min="0.00" step="0.01" max="999999.99" readonly="" onchange="getEstimatedValueClient(this, '3', 'Joint');" onkeyup="getEstimatedValueClient(this, '3', 'Joint');">
                                </div>
                                <div class="form-group col-sm-6 Joint_StockInvestments_Paying_Party3_Inputs_Div" style="display: none;">
                                    <label>{{$opponent_name}} StockInvestment Equity Percent</label>
                                    <input id="Joint_StockInvestments_Percent_Marital_Equity_to_Op3" type="number" class="form-control 3_Joint_opponentpercentage_input opponentpercentage_input" name="Joint_StockInvestments_Percent_Marital_Equity_to_Op3" value="<?php if(isset($drstocksinvestments->Joint_StockInvestments_Percent_Marital_Equity_to_Op3)){ echo $drstocksinvestments->Joint_StockInvestments_Percent_Marital_Equity_to_Op3; } ?>" min="0.00" step="0.01" max="100" readonly="">
                                </div>
                                <div class="form-group col-sm-6 Joint_StockInvestments_Paying_Party3_Inputs_Div" style="display: none;">
                                    <label>How much is to be paid to {{$opponent_name}}?</label>
                                    <input id="Joint_StockInvestments_Estimated_Value_to_Op3" type="number" class="form-control 3_Joint_opponentamount_input opponentamount_input" name="Joint_StockInvestments_Estimated_Value_to_Op3" value="<?php if(isset($drstocksinvestments->Joint_StockInvestments_Estimated_Value_to_Op3)){ echo $drstocksinvestments->Joint_StockInvestments_Estimated_Value_to_Op3; } ?>" min="0.00" step="0.01" max="999999.99" readonly="" onchange="getEstimatedValueOp(this, '3', 'Joint');" onkeyup="getEstimatedValueOp(this, '3', 'Joint');">
                                </div>
                                <!-- end of slider tool -->
                            </div>
                            <div class="col-sm-12 mt-4 4_Joint_stocksinvestments_section" style="display: none;"><h5 class="col-sm-12">Fourth Stock Investment Info</h5>
                                <div class="form-group col-sm-6">
                                    <p class="text-danger 4_Joint_no-state-county-found" style="display: none;">No City, State, County found for this zipcode.</p>
                                    <label for="Joint_StockInvestments_Institution_ZIP4">Stock/Investment Institution Zip Code?</label>
                                    <input id="Joint_StockInvestments_Institution_ZIP4" type="text" class="form-control 4_Joint_stocksinvestments_inputs" name="Joint_StockInvestments_Institution_ZIP4" value="<?php if(isset($drstocksinvestments->Joint_StockInvestments_Institution_ZIP4)){ echo $drstocksinvestments->Joint_StockInvestments_Institution_ZIP4; } ?>" data-onload="getCityStateForZip(this, '4', 'Joint');" onkeyup="getCityStateForZip(this, '4', 'Joint');"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_StockInvestments_Institution_Name4">Name of Stock/Investment Institution?</label>
                                    <input id="Joint_StockInvestments_Institution_Name4" type="text" class="form-control 4_Joint_stocksinvestments_inputs" name="Joint_StockInvestments_Institution_Name4" value="<?php if(isset($drstocksinvestments->Joint_StockInvestments_Institution_Name4)){ echo $drstocksinvestments->Joint_StockInvestments_Institution_Name4; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_StockInvestments_Institution_Street_Address4">Stock/Investment Institution Street Address?</label>
                                    <input id="Joint_StockInvestments_Institution_Street_Address4" type="text" class="form-control 4_Joint_stocksinvestments_inputs" name="Joint_StockInvestments_Institution_Street_Address4" value="<?php if(isset($drstocksinvestments->Joint_StockInvestments_Institution_Street_Address4)){ echo $drstocksinvestments->Joint_StockInvestments_Institution_Street_Address4; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_StockInvestments_Institution_City4">Stock/Investment Institution City?</label>
                                    <input type="hidden" name="" id="Joint_StockInvestments_Institution_City4_Value" value="<?php if(isset($drstocksinvestments->Joint_StockInvestments_Institution_City4)){ echo $drstocksinvestments->Joint_StockInvestments_Institution_City4; } ?>">
                                    <select id="Joint_StockInvestments_Institution_City4" name="Joint_StockInvestments_Institution_City4" class="form-control 4_Joint_city_select">
                                        <option value="">Choose City</option>
                                    </select>   
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_StockInvestments_Institution_State4">Stock/Investment Institution State?</label>
                                    <input type="hidden" name="" id="Joint_StockInvestments_Institution_State4_Value" value="<?php if(isset($drstocksinvestments->Joint_StockInvestments_Institution_State4)){ echo $drstocksinvestments->Joint_StockInvestments_Institution_State4; } ?>">
                                    <select id="Joint_StockInvestments_Institution_State4" name="Joint_StockInvestments_Institution_State4" class="form-control 4_Joint_state_select">
                                        <option value="">Choose State</option>
                                    </select>   
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_StockInvestments_Acct_Num4">Account Number?</label>
                                    <input id="Joint_StockInvestments_Acct_Num4" type="text" class="form-control 4_Joint_stocksinvestments_inputs" name="Joint_StockInvestments_Acct_Num4" value="<?php if(isset($drstocksinvestments->Joint_StockInvestments_Acct_Num4)){ echo $drstocksinvestments->Joint_StockInvestments_Acct_Num4; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_StockInvestments_Date_Marriage_Value4">Marriage Date Value?</label>
                                    <input id="Joint_StockInvestments_Date_Marriage_Value4" type="number" class="form-control 4_Joint_stocksinvestments_inputs" name="Joint_StockInvestments_Date_Marriage_Value4" value="<?php if(isset($drstocksinvestments->Joint_StockInvestments_Date_Marriage_Value4)){ echo $drstocksinvestments->Joint_StockInvestments_Date_Marriage_Value4; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_StockInvestments_Current_Value4">Current Value?</label>
                                    <input id="Joint_StockInvestments_Current_Value4" type="number" class="form-control 4_Joint_stocksinvestments_inputs" name="Joint_StockInvestments_Current_Value4" value="<?php if(isset($drstocksinvestments->Joint_StockInvestments_Current_Value4)){ echo $drstocksinvestments->Joint_StockInvestments_Current_Value4; } ?>" min="0.00" step="0.01" max="999999.99" onchange="getJointCurrentValue(this, '4', 'Joint');" onkeyup="getJointCurrentValue(this, '4', 'Joint');"> 
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label for="Joint_StockInvestments_Percent_Marital_Equity4">N/A, calculated = Joint_StockInvestments_Institution_Current_Value4</label>
                                    <input id="Joint_StockInvestments_Percent_Marital_Equity4" type="number" class="form-control 4_Joint_stocksinvestments_inputs" name="Joint_StockInvestments_Percent_Marital_Equity4" value="<?php if(isset($drstocksinvestments->Joint_StockInvestments_Percent_Marital_Equity4)){ echo $drstocksinvestments->Joint_StockInvestments_Percent_Marital_Equity4; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_StockInvestments_Yearly_Interest_Dividend4">Yearly Interest and Dividends from this account?</label>
                                    <input id="Joint_StockInvestments_Yearly_Interest_Dividend4" type="number" class="form-control 4_Joint_stocksinvestments_inputs" name="Joint_StockInvestments_Yearly_Interest_Dividend4" value="<?php if(isset($drstocksinvestments->Joint_StockInvestments_Yearly_Interest_Dividend4)){ echo $drstocksinvestments->Joint_StockInvestments_Yearly_Interest_Dividend4; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Does either party claim a sole/separate interest from the other on this account?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Joint_StockInvestments_SoleSeparate_Claim4_Yes" name="Joint_StockInvestments_SoleSeparate_Claim4" value="Yes" data-onload="getInitialPartyClaimSoleSeparate(this, '4', 'Joint');" onchange="getPartyClaimSoleSeparate(this, '4', 'Joint');" <?php if(isset($drstocksinvestments->Joint_StockInvestments_SoleSeparate_Claim4) && $drstocksinvestments->Joint_StockInvestments_SoleSeparate_Claim4=='Yes'){ echo "checked"; } ?>> Yes</label>
                                        <label><input type="radio" id="Joint_StockInvestments_SoleSeparate_Claim4_No" name="Joint_StockInvestments_SoleSeparate_Claim4" value="No" data-onload="getInitialPartyClaimSoleSeparate(this, '4', 'Joint');" onchange="getPartyClaimSoleSeparate(this, '4', 'Joint');" <?php if(isset($drstocksinvestments->Joint_StockInvestments_SoleSeparate_Claim4) && $drstocksinvestments->Joint_StockInvestments_SoleSeparate_Claim4=='No'){ echo "checked"; } ?>> No</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6" id="Joint_StockInvestments_SoleSeparate_Party4_Div" style="display: none;">
                                    <label>Who claims to own this account?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Joint_StockInvestments_SoleSeparate_Party4_Client" name="Joint_StockInvestments_SoleSeparate_Party4" value="{{$client_name}}" <?php if(isset($drstocksinvestments->Joint_StockInvestments_SoleSeparate_Party4) && $drstocksinvestments->Joint_StockInvestments_SoleSeparate_Party4==$client_name){ echo "checked"; } ?>> {{$client_name}}</label>
                                        <label><input type="radio" id="Joint_StockInvestments_SoleSeparate_Party4_Op" name="Joint_StockInvestments_SoleSeparate_Party4" value="{{$opponent_name}}" <?php if(isset($drstocksinvestments->Joint_StockInvestments_SoleSeparate_Party4) && $drstocksinvestments->Joint_StockInvestments_SoleSeparate_Party4==$opponent_name){ echo "checked"; } ?>> {{$opponent_name}}</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 left-clear" id="Joint_StockInvestments_SoleSeparate_Grounds4_Div" style="display: none; clear: left;">
                                    <label for="Joint_StockInvestments_SoleSeparate_Grounds4">Why does this person own this account solely and separately?</label>
                                    <input id="Joint_StockInvestments_SoleSeparate_Grounds4" type="text" class="form-control 4_Joint_stocksinvestments_inputs" name="Joint_StockInvestments_SoleSeparate_Grounds4" value="<?php if(isset($drstocksinvestments->Joint_StockInvestments_SoleSeparate_Grounds4)){ echo $drstocksinvestments->Joint_StockInvestments_SoleSeparate_Grounds4; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>How will this account value be distributed between the parties?</label>
                                    <div class="w-100 dataInput">
                                        <label><input type="radio" id="Joint_StockInvestments_Disposition_Method4_Distribute_Investments" name="Joint_StockInvestments_Disposition_Method4" value="Distribute Investments" data-onload="getInitialDipositionMethod(this, '4', 'Joint');" onchange="getDipositionMethod(this, '4', 'Joint');" <?php if(isset($drstocksinvestments->Joint_StockInvestments_Disposition_Method4) && $drstocksinvestments->Joint_StockInvestments_Disposition_Method4=='Distribute Investments'){ echo "checked"; } ?>> Distribute Investments</label>
                                        <label><input type="radio" id="Joint_StockInvestments_Disposition_Method4_Liquidate_Split_Net_Value" name="Joint_StockInvestments_Disposition_Method4" value="Liquidate/Split Net Value" data-onload="getInitialDipositionMethod(this, '4', 'Joint');" onchange="getDipositionMethod(this, '4', 'Joint');" <?php if(isset($drstocksinvestments->Joint_StockInvestments_Disposition_Method4) && $drstocksinvestments->Joint_StockInvestments_Disposition_Method4=='Liquidate/Split Net Value'){ echo "checked"; } ?>> Liquidate/Split Net Value</label>
                                        <label><input type="radio" id="Joint_StockInvestments_Disposition_Method4_Percentage_Buyout" name="Joint_StockInvestments_Disposition_Method4" value="Percentage Buyout" data-onload="getInitialDipositionMethod(this, '4', 'Joint');" onchange="getDipositionMethod(this, '4', 'Joint');" <?php if(isset($drstocksinvestments->Joint_StockInvestments_Disposition_Method4) && $drstocksinvestments->Joint_StockInvestments_Disposition_Method4=='Percentage Buyout'){ echo "checked"; } ?>> Percentage Buyout</label>
                                        <label><input type="radio" id="Joint_StockInvestments_Disposition_Method4_Fixed Buyout" name="Joint_StockInvestments_Disposition_Method4" value="Fixed Buyout" data-onload="getInitialDipositionMethod(this, '4', 'Joint');" onchange="getDipositionMethod(this, '4', 'Joint');" <?php if(isset($drstocksinvestments->Joint_StockInvestments_Disposition_Method4) && $drstocksinvestments->Joint_StockInvestments_Disposition_Method4=='Fixed Buyout'){ echo "checked"; } ?>> Fixed Buyout</label>
                                    </div>
                                </div>
                                <!-- slider tool -->
                                <div class="form-group col-sm-6 m-auto 4_Joint_Slider_Tool slider-tool-main">
                                    <div class="row">
                                        <div class="col">{{$client_name}}</div>
                                        <div class="col text-right">{{$opponent_name}}</div>
                                    </div>
                                    <input id="4_Joint_balance_range_selector" type="range" class="form-control slider-tool-input 4_Joint_balance_range_selector" name="" value="<?php if(isset($drstocksinvestments->Joint_StockInvestments_Percent_Marital_Equity_to_Op4)){ echo $drstocksinvestments->Joint_StockInvestments_Percent_Marital_Equity_to_Op4; } ?>" min="0.00" step="0.01" max="100" onchange="updateBalanceInput(this.value, '4', 'Joint');">
                                </div>
                                <div class="form-group col-sm-6 m-auto 4_Joint_Slider_Tool slider-tool-main">
                                    <div class="row justify-content-between">
                                        <div class="col selectorTool">
                                            <div class="left-col">
                                                <div class="client-info 4_Joint_clientpercentage_div clientpercentage_div">
                                                    <?php if(isset($drstocksinvestments->Joint_StockInvestments_Percent_Marital_Equity_to_Client4)){ echo $drstocksinvestments->Joint_StockInvestments_Percent_Marital_Equity_to_Client4; } else {
                                                        echo "50.00";
                                                    } ?>%
                                                </div>
                                                <div class="client-info 4_Joint_clientamount_div clientamount_div" style="clear: both;">
                                                    $<?php if(isset($drstocksinvestments->Joint_StockInvestments_Estimated_Value_to_Client4)){ echo $drstocksinvestments->Joint_StockInvestments_Estimated_Value_to_Client4; }else {
                                                        echo "0.00";
                                                    } ?>
                                                </div>
                                            </div>
                                            <label>To {{$client_name}}</label>
                                        </div>                                       
                                        <div class="col selectorTool selectorToolRight">
                                            <label>To {{$opponent_name}}</label>
                                            <div class="left-col right-col">
                                                <div class="client-info 4_Joint_opponentpercentage_div opponentpercentage_div">
                                                    <?php if(isset($drstocksinvestments->Joint_StockInvestments_Percent_Marital_Equity_to_Op4)){ echo $drstocksinvestments->Joint_StockInvestments_Percent_Marital_Equity_to_Op4; } else {
                                                        echo "50.00";
                                                    } ?>%
                                                </div>
                                                <div class="client-info 4_Joint_opponentamount_div opponentamount_div" style="clear: both;">
                                                    $<?php if(isset($drstocksinvestments->Joint_StockInvestments_Estimated_Value_to_Op4)){ echo $drstocksinvestments->Joint_StockInvestments_Estimated_Value_to_Op4; }else {
                                                        echo "0.00";
                                                    } ?>
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
                                         <label><input type="radio" id="Joint_StockInvestments_Paying_Party4_Client" name="Joint_StockInvestments_Paying_Party4" value="{{$client_name}}" data-onload="getInitialStockInvestmentPayingParty(this, '4', 'Joint');" onchange="getStockInvestmentPayingParty(this, '4', 'Joint');"  <?php if(isset($drstocksinvestments->Joint_StockInvestments_Paying_Party4) && $drstocksinvestments->Joint_StockInvestments_Paying_Party4==$client_name){ echo "checked"; } ?>> {{$client_name}}</label>
                                        <label><input type="radio" id="Joint_StockInvestments_Paying_Party4_Op" name="Joint_StockInvestments_Paying_Party4" value="{{$opponent_name}}" data-onload="getInitialStockInvestmentPayingParty(this, '4', 'Joint');" onchange="getStockInvestmentPayingParty(this, '4', 'Joint');"  <?php if(isset($drstocksinvestments->Joint_StockInvestments_Paying_Party4) && $drstocksinvestments->Joint_StockInvestments_Paying_Party4==$opponent_name){ echo "checked"; } ?>> {{$opponent_name}}</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 Joint_StockInvestments_Paying_Party4_Inputs_Div" style="display: none;">
                                    <label>{{$client_name}} StockInvestment Equity Percent</label>
                                    <input id="Joint_StockInvestments_Percent_Marital_Equity_to_Client4" type="number" class="form-control 4_Joint_clientpercentage_input clientpercentage_input" name="Joint_StockInvestments_Percent_Marital_Equity_to_Client4" value="<?php if(isset($drstocksinvestments->Joint_StockInvestments_Percent_Marital_Equity_to_Client4)){ echo $drstocksinvestments->Joint_StockInvestments_Percent_Marital_Equity_to_Client4; } ?>" min="0.00" step="0.01" max="100" readonly="">
                                </div>
                                <div class="form-group col-sm-6 Joint_StockInvestments_Paying_Party4_Inputs_Div" style="display: none;">
                                    <label>How much is to be paid to {{$client_name}}?</label>
                                    <input id="Joint_StockInvestments_Estimated_Value_to_Client4" type="number" class="form-control 4_Joint_clientamount_input clientamount_input" name="Joint_StockInvestments_Estimated_Value_to_Client4" value="<?php if(isset($drstocksinvestments->Joint_StockInvestments_Estimated_Value_to_Client4)){ echo $drstocksinvestments->Joint_StockInvestments_Estimated_Value_to_Client4; } ?>" min="0.00" step="0.01" max="999999.99" readonly="" onchange="getEstimatedValueClient(this, '4', 'Joint');" onkeyup="getEstimatedValueClient(this, '4', 'Joint');">
                                </div>
                                <div class="form-group col-sm-6 Joint_StockInvestments_Paying_Party4_Inputs_Div" style="display: none;">
                                    <label>{{$opponent_name}} StockInvestment Equity Percent</label>
                                    <input id="Joint_StockInvestments_Percent_Marital_Equity_to_Op4" type="number" class="form-control 4_Joint_opponentpercentage_input opponentpercentage_input" name="Joint_StockInvestments_Percent_Marital_Equity_to_Op4" value="<?php if(isset($drstocksinvestments->Joint_StockInvestments_Percent_Marital_Equity_to_Op4)){ echo $drstocksinvestments->Joint_StockInvestments_Percent_Marital_Equity_to_Op4; } ?>" min="0.00" step="0.01" max="100" readonly="">
                                </div>
                                <div class="form-group col-sm-6 Joint_StockInvestments_Paying_Party4_Inputs_Div" style="display: none;">
                                    <label>How much is to be paid to {{$opponent_name}}?</label>
                                    <input id="Joint_StockInvestments_Estimated_Value_to_Op4" type="number" class="form-control 4_Joint_opponentamount_input opponentamount_input" name="Joint_StockInvestments_Estimated_Value_to_Op4" value="<?php if(isset($drstocksinvestments->Joint_StockInvestments_Estimated_Value_to_Op4)){ echo $drstocksinvestments->Joint_StockInvestments_Estimated_Value_to_Op4; } ?>" min="0.00" step="0.01" max="999999.99" readonly="" onchange="getEstimatedValueOp(this, '4', 'Joint');" onkeyup="getEstimatedValueOp(this, '4', 'Joint');">
                                </div>
                                <!-- end of slider tool -->
                            </div>
                            <div class="col-sm-12 mt-4 5_Joint_stocksinvestments_section" style="display: none;"><h5 class="col-sm-12">Fifth Stock Investment Info</h5>
                                <div class="form-group col-sm-6">
                                    <p class="text-danger 5_Joint_no-state-county-found" style="display: none;">No City, State, County found for this zipcode.</p>
                                    <label for="Joint_StockInvestments_Institution_ZIP5">Stock/Investment Institution Zip Code?</label>
                                    <input id="Joint_StockInvestments_Institution_ZIP5" type="text" class="form-control 5_Joint_stocksinvestments_inputs" name="Joint_StockInvestments_Institution_ZIP5" value="<?php if(isset($drstocksinvestments->Joint_StockInvestments_Institution_ZIP5)){ echo $drstocksinvestments->Joint_StockInvestments_Institution_ZIP5; } ?>" data-onload="getCityStateForZip(this, '5', 'Joint');" onkeyup="getCityStateForZip(this, '5', 'Joint');"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_StockInvestments_Institution_Name5">Name of Stock/Investment Institution?</label>
                                    <input id="Joint_StockInvestments_Institution_Name5" type="text" class="form-control 5_Joint_stocksinvestments_inputs" name="Joint_StockInvestments_Institution_Name5" value="<?php if(isset($drstocksinvestments->Joint_StockInvestments_Institution_Name5)){ echo $drstocksinvestments->Joint_StockInvestments_Institution_Name5; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_StockInvestments_Institution_Street_Address5">Stock/Investment Institution Street Address?</label>
                                    <input id="Joint_StockInvestments_Institution_Street_Address5" type="text" class="form-control 5_Joint_stocksinvestments_inputs" name="Joint_StockInvestments_Institution_Street_Address5" value="<?php if(isset($drstocksinvestments->Joint_StockInvestments_Institution_Street_Address5)){ echo $drstocksinvestments->Joint_StockInvestments_Institution_Street_Address5; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_StockInvestments_Institution_City5">Stock/Investment Institution City?</label>
                                    <input type="hidden" name="" id="Joint_StockInvestments_Institution_City5_Value" value="<?php if(isset($drstocksinvestments->Joint_StockInvestments_Institution_City5)){ echo $drstocksinvestments->Joint_StockInvestments_Institution_City5; } ?>">
                                    <select id="Joint_StockInvestments_Institution_City5" name="Joint_StockInvestments_Institution_City5" class="form-control 5_Joint_city_select">
                                        <option value="">Choose City</option>
                                    </select>   
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_StockInvestments_Institution_State5">Stock/Investment Institution State?</label>
                                    <input type="hidden" name="" id="Joint_StockInvestments_Institution_State5_Value" value="<?php if(isset($drstocksinvestments->Joint_StockInvestments_Institution_State5)){ echo $drstocksinvestments->Joint_StockInvestments_Institution_State5; } ?>">
                                    <select id="Joint_StockInvestments_Institution_State5" name="Joint_StockInvestments_Institution_State5" class="form-control 5_Joint_state_select">
                                        <option value="">Choose State</option>
                                    </select>   
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_StockInvestments_Acct_Num5">Account Number?</label>
                                    <input id="Joint_StockInvestments_Acct_Num5" type="text" class="form-control 5_Joint_stocksinvestments_inputs" name="Joint_StockInvestments_Acct_Num5" value="<?php if(isset($drstocksinvestments->Joint_StockInvestments_Acct_Num5)){ echo $drstocksinvestments->Joint_StockInvestments_Acct_Num5; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_StockInvestments_Date_Marriage_Value5">Marriage Date Value?</label>
                                    <input id="Joint_StockInvestments_Date_Marriage_Value5" type="number" class="form-control 5_Joint_stocksinvestments_inputs" name="Joint_StockInvestments_Date_Marriage_Value5" value="<?php if(isset($drstocksinvestments->Joint_StockInvestments_Date_Marriage_Value5)){ echo $drstocksinvestments->Joint_StockInvestments_Date_Marriage_Value5; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_StockInvestments_Current_Value5">Current Value?</label>
                                    <input id="Joint_StockInvestments_Current_Value5" type="number" class="form-control 5_Joint_stocksinvestments_inputs" name="Joint_StockInvestments_Current_Value5" value="<?php if(isset($drstocksinvestments->Joint_StockInvestments_Current_Value5)){ echo $drstocksinvestments->Joint_StockInvestments_Current_Value5; } ?>" min="0.00" step="0.01" max="999999.99" onchange="getJointCurrentValue(this, '5', 'Joint');" onkeyup="getJointCurrentValue(this, '5', 'Joint');"> 
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label for="Joint_StockInvestments_Percent_Marital_Equity5">N/A, calculated = Joint_StockInvestments_Institution_Current_Value5</label>
                                    <input id="Joint_StockInvestments_Percent_Marital_Equity5" type="number" class="form-control 5_Joint_stocksinvestments_inputs" name="Joint_StockInvestments_Percent_Marital_Equity5" value="<?php if(isset($drstocksinvestments->Joint_StockInvestments_Percent_Marital_Equity5)){ echo $drstocksinvestments->Joint_StockInvestments_Percent_Marital_Equity5; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_StockInvestments_Yearly_Interest_Dividend5">Yearly Interest and Dividends from this account?</label>
                                    <input id="Joint_StockInvestments_Yearly_Interest_Dividend5" type="number" class="form-control 5_Joint_stocksinvestments_inputs" name="Joint_StockInvestments_Yearly_Interest_Dividend5" value="<?php if(isset($drstocksinvestments->Joint_StockInvestments_Yearly_Interest_Dividend5)){ echo $drstocksinvestments->Joint_StockInvestments_Yearly_Interest_Dividend5; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Does either party claim a sole/separate interest from the other on this account?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Joint_StockInvestments_SoleSeparate_Claim5_Yes" name="Joint_StockInvestments_SoleSeparate_Claim5" value="Yes" data-onload="getInitialPartyClaimSoleSeparate(this, '5', 'Joint');" onchange="getPartyClaimSoleSeparate(this, '5', 'Joint');" <?php if(isset($drstocksinvestments->Joint_StockInvestments_SoleSeparate_Claim5) && $drstocksinvestments->Joint_StockInvestments_SoleSeparate_Claim5=='Yes'){ echo "checked"; } ?>> Yes</label>
                                        <label><input type="radio" id="Joint_StockInvestments_SoleSeparate_Claim5_No" name="Joint_StockInvestments_SoleSeparate_Claim5" value="No" data-onload="getInitialPartyClaimSoleSeparate(this, '5', 'Joint');" onchange="getPartyClaimSoleSeparate(this, '5', 'Joint');" <?php if(isset($drstocksinvestments->Joint_StockInvestments_SoleSeparate_Claim5) && $drstocksinvestments->Joint_StockInvestments_SoleSeparate_Claim5=='No'){ echo "checked"; } ?>> No</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6" id="Joint_StockInvestments_SoleSeparate_Party5_Div" style="display: none;">
                                    <label>Who claims to own this account?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Joint_StockInvestments_SoleSeparate_Party5_Client" name="Joint_StockInvestments_SoleSeparate_Party5" value="{{$client_name}}" <?php if(isset($drstocksinvestments->Joint_StockInvestments_SoleSeparate_Party5) && $drstocksinvestments->Joint_StockInvestments_SoleSeparate_Party5==$client_name){ echo "checked"; } ?>> {{$client_name}}</label>
                                        <label><input type="radio" id="Joint_StockInvestments_SoleSeparate_Party5_Op" name="Joint_StockInvestments_SoleSeparate_Party5" value="{{$opponent_name}}" <?php if(isset($drstocksinvestments->Joint_StockInvestments_SoleSeparate_Party5) && $drstocksinvestments->Joint_StockInvestments_SoleSeparate_Party5==$opponent_name){ echo "checked"; } ?>> {{$opponent_name}}</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 left-clear" id="Joint_StockInvestments_SoleSeparate_Grounds5_Div" style="display: none; clear: left;">
                                    <label for="Joint_StockInvestments_SoleSeparate_Grounds5">Why does this person own this account solely and separately?</label>
                                    <input id="Joint_StockInvestments_SoleSeparate_Grounds5" type="text" class="form-control 5_Joint_stocksinvestments_inputs" name="Joint_StockInvestments_SoleSeparate_Grounds5" value="<?php if(isset($drstocksinvestments->Joint_StockInvestments_SoleSeparate_Grounds5)){ echo $drstocksinvestments->Joint_StockInvestments_SoleSeparate_Grounds5; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>How will this account value be distributed between the parties?</label>
                                    <div class="w-100 dataInput">
                                        <label><input type="radio" id="Joint_StockInvestments_Disposition_Method5_Distribute_Investments" name="Joint_StockInvestments_Disposition_Method5" value="Distribute Investments" data-onload="getInitialDipositionMethod(this, '5', 'Joint');" onchange="getDipositionMethod(this, '5', 'Joint');" <?php if(isset($drstocksinvestments->Joint_StockInvestments_Disposition_Method5) && $drstocksinvestments->Joint_StockInvestments_Disposition_Method5=='Distribute Investments'){ echo "checked"; } ?>> Distribute Investments</label>
                                        <label><input type="radio" id="Joint_StockInvestments_Disposition_Method5_Liquidate_Split_Net_Value" name="Joint_StockInvestments_Disposition_Method5" value="Liquidate/Split Net Value" data-onload="getInitialDipositionMethod(this, '5', 'Joint');" onchange="getDipositionMethod(this, '5', 'Joint');" <?php if(isset($drstocksinvestments->Joint_StockInvestments_Disposition_Method5) && $drstocksinvestments->Joint_StockInvestments_Disposition_Method5=='Liquidate/Split Net Value'){ echo "checked"; } ?>> Liquidate/Split Net Value</label>
                                        <label><input type="radio" id="Joint_StockInvestments_Disposition_Method5_Percentage_Buyout" name="Joint_StockInvestments_Disposition_Method5" value="Percentage Buyout" data-onload="getInitialDipositionMethod(this, '5', 'Joint');" onchange="getDipositionMethod(this, '5', 'Joint');" <?php if(isset($drstocksinvestments->Joint_StockInvestments_Disposition_Method5) && $drstocksinvestments->Joint_StockInvestments_Disposition_Method5=='Percentage Buyout'){ echo "checked"; } ?>> Percentage Buyout</label>
                                        <label><input type="radio" id="Joint_StockInvestments_Disposition_Method5_Fixed Buyout" name="Joint_StockInvestments_Disposition_Method5" value="Fixed Buyout" data-onload="getInitialDipositionMethod(this, '5', 'Joint');" onchange="getDipositionMethod(this, '5', 'Joint');" <?php if(isset($drstocksinvestments->Joint_StockInvestments_Disposition_Method5) && $drstocksinvestments->Joint_StockInvestments_Disposition_Method5=='Fixed Buyout'){ echo "checked"; } ?>> Fixed Buyout</label>
                                    </div>
                                </div>
                                <!-- slider tool -->
                                <div class="form-group col-sm-6 m-auto 5_Joint_Slider_Tool slider-tool-main">
                                    <div class="row">
                                        <div class="col">{{$client_name}}</div>
                                        <div class="col text-right">{{$opponent_name}}</div>
                                    </div>
                                    <input id="5_Joint_balance_range_selector" type="range" class="form-control slider-tool-input 5_Joint_balance_range_selector" name="" value="<?php if(isset($drstocksinvestments->Joint_StockInvestments_Percent_Marital_Equity_to_Op5)){ echo $drstocksinvestments->Joint_StockInvestments_Percent_Marital_Equity_to_Op5; } ?>" min="0.00" step="0.01" max="100" onchange="updateBalanceInput(this.value, '5', 'Joint');">
                                </div>
                                <div class="form-group col-sm-6 m-auto 5_Joint_Slider_Tool slider-tool-main">
                                    <div class="row justify-content-between">
                                        <div class="col selectorTool">
                                            <div class="left-col">
                                                <div class="client-info 5_Joint_clientpercentage_div clientpercentage_div">
                                                    <?php if(isset($drstocksinvestments->Joint_StockInvestments_Percent_Marital_Equity_to_Client5)){ echo $drstocksinvestments->Joint_StockInvestments_Percent_Marital_Equity_to_Client5; } else {
                                                        echo "50.00";
                                                    } ?>%
                                                </div>
                                                <div class="client-info 5_Joint_clientamount_div clientamount_div" style="clear: both;">
                                                    $<?php if(isset($drstocksinvestments->Joint_StockInvestments_Estimated_Value_to_Client5)){ echo $drstocksinvestments->Joint_StockInvestments_Estimated_Value_to_Client5; }else {
                                                        echo "0.00";
                                                    } ?>
                                                </div>
                                            </div>
                                            <label>To {{$client_name}}</label>
                                        </div>                                       
                                        <div class="col selectorTool selectorToolRight">
                                            <label>To {{$opponent_name}}</label>
                                            <div class="left-col right-col">
                                                <div class="client-info 5_Joint_opponentpercentage_div opponentpercentage_div">
                                                    <?php if(isset($drstocksinvestments->Joint_StockInvestments_Percent_Marital_Equity_to_Op5)){ echo $drstocksinvestments->Joint_StockInvestments_Percent_Marital_Equity_to_Op5; } else {
                                                        echo "50.00";
                                                    } ?>%
                                                </div>
                                                <div class="client-info 5_Joint_opponentamount_div opponentamount_div" style="clear: both;">
                                                    $<?php if(isset($drstocksinvestments->Joint_StockInvestments_Estimated_Value_to_Op5)){ echo $drstocksinvestments->Joint_StockInvestments_Estimated_Value_to_Op5; }else {
                                                        echo "0.00";
                                                    } ?>
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
                                         <label><input type="radio" id="Joint_StockInvestments_Paying_Party5_Client" name="Joint_StockInvestments_Paying_Party5" value="{{$client_name}}" data-onload="getInitialStockInvestmentPayingParty(this, '5', 'Joint');" onchange="getStockInvestmentPayingParty(this, '5', 'Joint');"  <?php if(isset($drstocksinvestments->Joint_StockInvestments_Paying_Party5) && $drstocksinvestments->Joint_StockInvestments_Paying_Party5==$client_name){ echo "checked"; } ?>> {{$client_name}}</label>
                                        <label><input type="radio" id="Joint_StockInvestments_Paying_Party5_Op" name="Joint_StockInvestments_Paying_Party5" value="{{$opponent_name}}" data-onload="getInitialStockInvestmentPayingParty(this, '5', 'Joint');" onchange="getStockInvestmentPayingParty(this, '5', 'Joint');"  <?php if(isset($drstocksinvestments->Joint_StockInvestments_Paying_Party5) && $drstocksinvestments->Joint_StockInvestments_Paying_Party5==$opponent_name){ echo "checked"; } ?>> {{$opponent_name}}</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 Joint_StockInvestments_Paying_Party5_Inputs_Div" style="display: none;">
                                    <label>{{$client_name}} StockInvestment Equity Percent</label>
                                    <input id="Joint_StockInvestments_Percent_Marital_Equity_to_Client5" type="number" class="form-control 5_Joint_clientpercentage_input clientpercentage_input" name="Joint_StockInvestments_Percent_Marital_Equity_to_Client5" value="<?php if(isset($drstocksinvestments->Joint_StockInvestments_Percent_Marital_Equity_to_Client5)){ echo $drstocksinvestments->Joint_StockInvestments_Percent_Marital_Equity_to_Client5; } ?>" min="0.00" step="0.01" max="100" readonly="">
                                </div>
                                <div class="form-group col-sm-6 Joint_StockInvestments_Paying_Party5_Inputs_Div" style="display: none;">
                                    <label>How much is to be paid to {{$client_name}}?</label>
                                    <input id="Joint_StockInvestments_Estimated_Value_to_Client5" type="number" class="form-control 5_Joint_clientamount_input clientamount_input" name="Joint_StockInvestments_Estimated_Value_to_Client5" value="<?php if(isset($drstocksinvestments->Joint_StockInvestments_Estimated_Value_to_Client5)){ echo $drstocksinvestments->Joint_StockInvestments_Estimated_Value_to_Client5; } ?>" min="0.00" step="0.01" max="999999.99" readonly="" onchange="getEstimatedValueClient(this, '5', 'Joint');" onkeyup="getEstimatedValueClient(this, '5', 'Joint');">
                                </div>
                                <div class="form-group col-sm-6 Joint_StockInvestments_Paying_Party5_Inputs_Div" style="display: none;">
                                    <label>{{$opponent_name}} StockInvestment Equity Percent</label>
                                    <input id="Joint_StockInvestments_Percent_Marital_Equity_to_Op5" type="number" class="form-control 5_Joint_opponentpercentage_input opponentpercentage_input" name="Joint_StockInvestments_Percent_Marital_Equity_to_Op5" value="<?php if(isset($drstocksinvestments->Joint_StockInvestments_Percent_Marital_Equity_to_Op5)){ echo $drstocksinvestments->Joint_StockInvestments_Percent_Marital_Equity_to_Op5; } ?>" min="0.00" step="0.01" max="100" readonly="">
                                </div>
                                <div class="form-group col-sm-6 Joint_StockInvestments_Paying_Party5_Inputs_Div" style="display: none;">
                                    <label>How much is to be paid to {{$opponent_name}}?</label>
                                    <input id="Joint_StockInvestments_Estimated_Value_to_Op5" type="number" class="form-control 5_Joint_opponentamount_input opponentamount_input" name="Joint_StockInvestments_Estimated_Value_to_Op5" value="<?php if(isset($drstocksinvestments->Joint_StockInvestments_Estimated_Value_to_Op5)){ echo $drstocksinvestments->Joint_StockInvestments_Estimated_Value_to_Op5; } ?>" min="0.00" step="0.01" max="999999.99" readonly="" onchange="getEstimatedValueOp(this, '5', 'Joint');" onkeyup="getEstimatedValueOp(this, '5', 'Joint');">
                                </div>
                                <!-- end of slider tool -->
                            </div>
                            <div class="col-sm-12 mt-4 6_Joint_stocksinvestments_section" style="display: none;"><h5 class="col-sm-12">Sixth Stock Investment Info</h5>
                                <div class="form-group col-sm-6">
                                    <p class="text-danger 6_Joint_no-state-county-found" style="display: none;">No City, State, County found for this zipcode.</p>
                                    <label for="Joint_StockInvestments_Institution_ZIP6">Stock/Investment Institution Zip Code?</label>
                                    <input id="Joint_StockInvestments_Institution_ZIP6" type="text" class="form-control 6_Joint_stocksinvestments_inputs" name="Joint_StockInvestments_Institution_ZIP6" value="<?php if(isset($drstocksinvestments->Joint_StockInvestments_Institution_ZIP6)){ echo $drstocksinvestments->Joint_StockInvestments_Institution_ZIP6; } ?>" data-onload="getCityStateForZip(this, '6', 'Joint');" onkeyup="getCityStateForZip(this, '6', 'Joint');"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_StockInvestments_Institution_Name6">Name of Stock/Investment Institution?</label>
                                    <input id="Joint_StockInvestments_Institution_Name6" type="text" class="form-control 6_Joint_stocksinvestments_inputs" name="Joint_StockInvestments_Institution_Name6" value="<?php if(isset($drstocksinvestments->Joint_StockInvestments_Institution_Name6)){ echo $drstocksinvestments->Joint_StockInvestments_Institution_Name6; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_StockInvestments_Institution_Street_Address6">Stock/Investment Institution Street Address?</label>
                                    <input id="Joint_StockInvestments_Institution_Street_Address6" type="text" class="form-control 6_Joint_stocksinvestments_inputs" name="Joint_StockInvestments_Institution_Street_Address6" value="<?php if(isset($drstocksinvestments->Joint_StockInvestments_Institution_Street_Address6)){ echo $drstocksinvestments->Joint_StockInvestments_Institution_Street_Address6; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_StockInvestments_Institution_City6">Stock/Investment Institution City?</label>
                                    <input type="hidden" name="" id="Joint_StockInvestments_Institution_City6_Value" value="<?php if(isset($drstocksinvestments->Joint_StockInvestments_Institution_City6)){ echo $drstocksinvestments->Joint_StockInvestments_Institution_City6; } ?>">
                                    <select id="Joint_StockInvestments_Institution_City6" name="Joint_StockInvestments_Institution_City6" class="form-control 6_Joint_city_select">
                                        <option value="">Choose City</option>
                                    </select>   
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_StockInvestments_Institution_State6">Stock/Investment Institution State?</label>
                                    <input type="hidden" name="" id="Joint_StockInvestments_Institution_State6_Value" value="<?php if(isset($drstocksinvestments->Joint_StockInvestments_Institution_State6)){ echo $drstocksinvestments->Joint_StockInvestments_Institution_State6; } ?>">
                                    <select id="Joint_StockInvestments_Institution_State6" name="Joint_StockInvestments_Institution_State6" class="form-control 6_Joint_state_select">
                                        <option value="">Choose State</option>
                                    </select>   
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_StockInvestments_Acct_Num6">Account Number?</label>
                                    <input id="Joint_StockInvestments_Acct_Num6" type="text" class="form-control 6_Joint_stocksinvestments_inputs" name="Joint_StockInvestments_Acct_Num6" value="<?php if(isset($drstocksinvestments->Joint_StockInvestments_Acct_Num6)){ echo $drstocksinvestments->Joint_StockInvestments_Acct_Num6; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_StockInvestments_Date_Marriage_Value6">Marriage Date Value?</label>
                                    <input id="Joint_StockInvestments_Date_Marriage_Value6" type="number" class="form-control 6_Joint_stocksinvestments_inputs" name="Joint_StockInvestments_Date_Marriage_Value6" value="<?php if(isset($drstocksinvestments->Joint_StockInvestments_Date_Marriage_Value6)){ echo $drstocksinvestments->Joint_StockInvestments_Date_Marriage_Value6; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_StockInvestments_Current_Value6">Current Value?</label>
                                    <input id="Joint_StockInvestments_Current_Value6" type="number" class="form-control 6_Joint_stocksinvestments_inputs" name="Joint_StockInvestments_Current_Value6" value="<?php if(isset($drstocksinvestments->Joint_StockInvestments_Current_Value6)){ echo $drstocksinvestments->Joint_StockInvestments_Current_Value6; } ?>" min="0.00" step="0.01" max="999999.99" onchange="getJointCurrentValue(this, '6', 'Joint');" onkeyup="getJointCurrentValue(this, '6', 'Joint');"> 
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label for="Joint_StockInvestments_Percent_Marital_Equity6">N/A, calculated = Joint_StockInvestments_Institution_Current_Value6</label>
                                    <input id="Joint_StockInvestments_Percent_Marital_Equity6" type="number" class="form-control 6_Joint_stocksinvestments_inputs" name="Joint_StockInvestments_Percent_Marital_Equity6" value="<?php if(isset($drstocksinvestments->Joint_StockInvestments_Percent_Marital_Equity6)){ echo $drstocksinvestments->Joint_StockInvestments_Percent_Marital_Equity6; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_StockInvestments_Yearly_Interest_Dividend6">Yearly Interest and Dividends from this account?</label>
                                    <input id="Joint_StockInvestments_Yearly_Interest_Dividend6" type="number" class="form-control 6_Joint_stocksinvestments_inputs" name="Joint_StockInvestments_Yearly_Interest_Dividend6" value="<?php if(isset($drstocksinvestments->Joint_StockInvestments_Yearly_Interest_Dividend6)){ echo $drstocksinvestments->Joint_StockInvestments_Yearly_Interest_Dividend6; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Does either party claim a sole/separate interest from the other on this account?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Joint_StockInvestments_SoleSeparate_Claim6_Yes" name="Joint_StockInvestments_SoleSeparate_Claim6" value="Yes" data-onload="getInitialPartyClaimSoleSeparate(this, '6', 'Joint');" onchange="getPartyClaimSoleSeparate(this, '6', 'Joint');" <?php if(isset($drstocksinvestments->Joint_StockInvestments_SoleSeparate_Claim6) && $drstocksinvestments->Joint_StockInvestments_SoleSeparate_Claim6=='Yes'){ echo "checked"; } ?>> Yes</label>
                                        <label><input type="radio" id="Joint_StockInvestments_SoleSeparate_Claim6_No" name="Joint_StockInvestments_SoleSeparate_Claim6" value="No" data-onload="getInitialPartyClaimSoleSeparate(this, '6', 'Joint');" onchange="getPartyClaimSoleSeparate(this, '6', 'Joint');" <?php if(isset($drstocksinvestments->Joint_StockInvestments_SoleSeparate_Claim6) && $drstocksinvestments->Joint_StockInvestments_SoleSeparate_Claim6=='No'){ echo "checked"; } ?>> No</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6" id="Joint_StockInvestments_SoleSeparate_Party6_Div" style="display: none;">
                                    <label>Who claims to own this account?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Joint_StockInvestments_SoleSeparate_Party6_Client" name="Joint_StockInvestments_SoleSeparate_Party6" value="{{$client_name}}" <?php if(isset($drstocksinvestments->Joint_StockInvestments_SoleSeparate_Party6) && $drstocksinvestments->Joint_StockInvestments_SoleSeparate_Party6==$client_name){ echo "checked"; } ?>> {{$client_name}}</label>
                                        <label><input type="radio" id="Joint_StockInvestments_SoleSeparate_Party6_Op" name="Joint_StockInvestments_SoleSeparate_Party6" value="{{$opponent_name}}" <?php if(isset($drstocksinvestments->Joint_StockInvestments_SoleSeparate_Party6) && $drstocksinvestments->Joint_StockInvestments_SoleSeparate_Party6==$opponent_name){ echo "checked"; } ?>> {{$opponent_name}}</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 left-clear" id="Joint_StockInvestments_SoleSeparate_Grounds6_Div" style="display: none; clear: left;">
                                    <label for="Joint_StockInvestments_SoleSeparate_Grounds6">Why does this person own this account solely and separately?</label>
                                    <input id="Joint_StockInvestments_SoleSeparate_Grounds6" type="text" class="form-control 6_Joint_stocksinvestments_inputs" name="Joint_StockInvestments_SoleSeparate_Grounds6" value="<?php if(isset($drstocksinvestments->Joint_StockInvestments_SoleSeparate_Grounds6)){ echo $drstocksinvestments->Joint_StockInvestments_SoleSeparate_Grounds6; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>How will this account value be distributed between the parties?</label>
                                    <div class="w-100 dataInput">
                                        <label><input type="radio" id="Joint_StockInvestments_Disposition_Method6_Distribute_Investments" name="Joint_StockInvestments_Disposition_Method6" value="Distribute Investments" data-onload="getInitialDipositionMethod(this, '6', 'Joint');" onchange="getDipositionMethod(this, '6', 'Joint');" <?php if(isset($drstocksinvestments->Joint_StockInvestments_Disposition_Method6) && $drstocksinvestments->Joint_StockInvestments_Disposition_Method6=='Distribute Investments'){ echo "checked"; } ?>> Distribute Investments</label>
                                        <label><input type="radio" id="Joint_StockInvestments_Disposition_Method6_Liquidate_Split_Net_Value" name="Joint_StockInvestments_Disposition_Method6" value="Liquidate/Split Net Value" data-onload="getInitialDipositionMethod(this, '6', 'Joint');" onchange="getDipositionMethod(this, '6', 'Joint');" <?php if(isset($drstocksinvestments->Joint_StockInvestments_Disposition_Method6) && $drstocksinvestments->Joint_StockInvestments_Disposition_Method6=='Liquidate/Split Net Value'){ echo "checked"; } ?>> Liquidate/Split Net Value</label>
                                        <label><input type="radio" id="Joint_StockInvestments_Disposition_Method6_Percentage_Buyout" name="Joint_StockInvestments_Disposition_Method6" value="Percentage Buyout" data-onload="getInitialDipositionMethod(this, '6', 'Joint');" onchange="getDipositionMethod(this, '6', 'Joint');" <?php if(isset($drstocksinvestments->Joint_StockInvestments_Disposition_Method6) && $drstocksinvestments->Joint_StockInvestments_Disposition_Method6=='Percentage Buyout'){ echo "checked"; } ?>> Percentage Buyout</label>
                                        <label><input type="radio" id="Joint_StockInvestments_Disposition_Method6_Fixed Buyout" name="Joint_StockInvestments_Disposition_Method6" value="Fixed Buyout" data-onload="getInitialDipositionMethod(this, '6', 'Joint');" onchange="getDipositionMethod(this, '6', 'Joint');" <?php if(isset($drstocksinvestments->Joint_StockInvestments_Disposition_Method6) && $drstocksinvestments->Joint_StockInvestments_Disposition_Method6=='Fixed Buyout'){ echo "checked"; } ?>> Fixed Buyout</label>
                                    </div>
                                </div>
                                <!-- slider tool -->
                                <div class="form-group col-sm-6 m-auto 6_Joint_Slider_Tool slider-tool-main">
                                    <div class="row">
                                        <div class="col">{{$client_name}}</div>
                                        <div class="col text-right">{{$opponent_name}}</div>
                                    </div>
                                    <input id="6_Joint_balance_range_selector" type="range" class="form-control slider-tool-input 6_Joint_balance_range_selector" name="" value="<?php if(isset($drstocksinvestments->Joint_StockInvestments_Percent_Marital_Equity_to_Op6)){ echo $drstocksinvestments->Joint_StockInvestments_Percent_Marital_Equity_to_Op6; } ?>" min="0.00" step="0.01" max="100" onchange="updateBalanceInput(this.value, '6', 'Joint');">
                                </div>
                                <div class="form-group col-sm-6 m-auto 6_Joint_Slider_Tool slider-tool-main">
                                    <div class="row justify-content-between">
                                        <div class="col selectorTool">
                                            <div class="left-col">
                                                <div class="client-info 6_Joint_clientpercentage_div clientpercentage_div">
                                                    <?php if(isset($drstocksinvestments->Joint_StockInvestments_Percent_Marital_Equity_to_Client6)){ echo $drstocksinvestments->Joint_StockInvestments_Percent_Marital_Equity_to_Client6; } else {
                                                        echo "50.00";
                                                    } ?>%
                                                </div>
                                                <div class="client-info 6_Joint_clientamount_div clientamount_div" style="clear: both;">
                                                    $<?php if(isset($drstocksinvestments->Joint_StockInvestments_Estimated_Value_to_Client6)){ echo $drstocksinvestments->Joint_StockInvestments_Estimated_Value_to_Client6; }else {
                                                        echo "0.00";
                                                    } ?>
                                                </div>
                                            </div>
                                            <label>To {{$client_name}}</label>
                                        </div>                                       
                                        <div class="col selectorTool selectorToolRight">
                                            <label>To {{$opponent_name}}</label>
                                            <div class="left-col right-col">
                                                <div class="client-info 6_Joint_opponentpercentage_div opponentpercentage_div">
                                                    <?php if(isset($drstocksinvestments->Joint_StockInvestments_Percent_Marital_Equity_to_Op6)){ echo $drstocksinvestments->Joint_StockInvestments_Percent_Marital_Equity_to_Op6; } else {
                                                        echo "50.00";
                                                    } ?>%
                                                </div>
                                                <div class="client-info 6_Joint_opponentamount_div opponentamount_div" style="clear: both;">
                                                    $<?php if(isset($drstocksinvestments->Joint_StockInvestments_Estimated_Value_to_Op6)){ echo $drstocksinvestments->Joint_StockInvestments_Estimated_Value_to_Op6; }else {
                                                        echo "0.00";
                                                    } ?>
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
                                         <label><input type="radio" id="Joint_StockInvestments_Paying_Party6_Client" name="Joint_StockInvestments_Paying_Party6" value="{{$client_name}}" data-onload="getInitialStockInvestmentPayingParty(this, '6', 'Joint');" onchange="getStockInvestmentPayingParty(this, '6', 'Joint');"  <?php if(isset($drstocksinvestments->Joint_StockInvestments_Paying_Party6) && $drstocksinvestments->Joint_StockInvestments_Paying_Party6==$client_name){ echo "checked"; } ?>> {{$client_name}}</label>
                                        <label><input type="radio" id="Joint_StockInvestments_Paying_Party6_Op" name="Joint_StockInvestments_Paying_Party6" value="{{$opponent_name}}" data-onload="getInitialStockInvestmentPayingParty(this, '6', 'Joint');" onchange="getStockInvestmentPayingParty(this, '6', 'Joint');"  <?php if(isset($drstocksinvestments->Joint_StockInvestments_Paying_Party6) && $drstocksinvestments->Joint_StockInvestments_Paying_Party6==$opponent_name){ echo "checked"; } ?>> {{$opponent_name}}</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 Joint_StockInvestments_Paying_Party6_Inputs_Div" style="display: none;">
                                    <label>{{$client_name}} StockInvestment Equity Percent</label>
                                    <input id="Joint_StockInvestments_Percent_Marital_Equity_to_Client6" type="number" class="form-control 6_Joint_clientpercentage_input clientpercentage_input" name="Joint_StockInvestments_Percent_Marital_Equity_to_Client6" value="<?php if(isset($drstocksinvestments->Joint_StockInvestments_Percent_Marital_Equity_to_Client6)){ echo $drstocksinvestments->Joint_StockInvestments_Percent_Marital_Equity_to_Client6; } ?>" min="0.00" step="0.01" max="100" readonly="">
                                </div>
                                <div class="form-group col-sm-6 Joint_StockInvestments_Paying_Party6_Inputs_Div" style="display: none;">
                                    <label>How much is to be paid to {{$client_name}}?</label>
                                    <input id="Joint_StockInvestments_Estimated_Value_to_Client6" type="number" class="form-control 6_Joint_clientamount_input clientamount_input" name="Joint_StockInvestments_Estimated_Value_to_Client6" value="<?php if(isset($drstocksinvestments->Joint_StockInvestments_Estimated_Value_to_Client6)){ echo $drstocksinvestments->Joint_StockInvestments_Estimated_Value_to_Client6; } ?>" min="0.00" step="0.01" max="999999.99" readonly="" onchange="getEstimatedValueClient(this, '6', 'Joint');" onkeyup="getEstimatedValueClient(this, '6', 'Joint');">
                                </div>
                                <div class="form-group col-sm-6 Joint_StockInvestments_Paying_Party6_Inputs_Div" style="display: none;">
                                    <label>{{$opponent_name}} StockInvestment Equity Percent</label>
                                    <input id="Joint_StockInvestments_Percent_Marital_Equity_to_Op6" type="number" class="form-control 6_Joint_opponentpercentage_input opponentpercentage_input" name="Joint_StockInvestments_Percent_Marital_Equity_to_Op6" value="<?php if(isset($drstocksinvestments->Joint_StockInvestments_Percent_Marital_Equity_to_Op6)){ echo $drstocksinvestments->Joint_StockInvestments_Percent_Marital_Equity_to_Op6; } ?>" min="0.00" step="0.01" max="100" readonly="">
                                </div>
                                <div class="form-group col-sm-6 Joint_StockInvestments_Paying_Party6_Inputs_Div" style="display: none;">
                                    <label>How much is to be paid to {{$opponent_name}}?</label>
                                    <input id="Joint_StockInvestments_Estimated_Value_to_Op6" type="number" class="form-control 6_Joint_opponentamount_input opponentamount_input" name="Joint_StockInvestments_Estimated_Value_to_Op6" value="<?php if(isset($drstocksinvestments->Joint_StockInvestments_Estimated_Value_to_Op6)){ echo $drstocksinvestments->Joint_StockInvestments_Estimated_Value_to_Op6; } ?>" min="0.00" step="0.01" max="999999.99" readonly="" onchange="getEstimatedValueOp(this, '6', 'Joint');" onkeyup="getEstimatedValueOp(this, '6', 'Joint');">
                                </div>
                                <!-- end of slider tool -->
                            </div>
                            <div class="col-sm-12 mt-4 7_Joint_stocksinvestments_section" style="display: none;"><h5 class="col-sm-12">Seventh Stock Investment Info</h5>
                                <div class="form-group col-sm-6">
                                    <p class="text-danger 7_Joint_no-state-county-found" style="display: none;">No City, State, County found for this zipcode.</p>
                                    <label for="Joint_StockInvestments_Institution_ZIP7">Stock/Investment Institution Zip Code?</label>
                                    <input id="Joint_StockInvestments_Institution_ZIP7" type="text" class="form-control 7_Joint_stocksinvestments_inputs" name="Joint_StockInvestments_Institution_ZIP7" value="<?php if(isset($drstocksinvestments->Joint_StockInvestments_Institution_ZIP7)){ echo $drstocksinvestments->Joint_StockInvestments_Institution_ZIP7; } ?>" data-onload="getCityStateForZip(this, '7', 'Joint');" onkeyup="getCityStateForZip(this, '7', 'Joint');"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_StockInvestments_Institution_Name7">Name of Stock/Investment Institution?</label>
                                    <input id="Joint_StockInvestments_Institution_Name7" type="text" class="form-control 7_Joint_stocksinvestments_inputs" name="Joint_StockInvestments_Institution_Name7" value="<?php if(isset($drstocksinvestments->Joint_StockInvestments_Institution_Name7)){ echo $drstocksinvestments->Joint_StockInvestments_Institution_Name7; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_StockInvestments_Institution_Street_Address7">Stock/Investment Institution Street Address?</label>
                                    <input id="Joint_StockInvestments_Institution_Street_Address7" type="text" class="form-control 7_Joint_stocksinvestments_inputs" name="Joint_StockInvestments_Institution_Street_Address7" value="<?php if(isset($drstocksinvestments->Joint_StockInvestments_Institution_Street_Address7)){ echo $drstocksinvestments->Joint_StockInvestments_Institution_Street_Address7; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_StockInvestments_Institution_City7">Stock/Investment Institution City?</label>
                                    <input type="hidden" name="" id="Joint_StockInvestments_Institution_City7_Value" value="<?php if(isset($drstocksinvestments->Joint_StockInvestments_Institution_City7)){ echo $drstocksinvestments->Joint_StockInvestments_Institution_City7; } ?>">
                                    <select id="Joint_StockInvestments_Institution_City7" name="Joint_StockInvestments_Institution_City7" class="form-control 7_Joint_city_select">
                                        <option value="">Choose City</option>
                                    </select>   
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_StockInvestments_Institution_State7">Stock/Investment Institution State?</label>
                                    <input type="hidden" name="" id="Joint_StockInvestments_Institution_State7_Value" value="<?php if(isset($drstocksinvestments->Joint_StockInvestments_Institution_State7)){ echo $drstocksinvestments->Joint_StockInvestments_Institution_State7; } ?>">
                                    <select id="Joint_StockInvestments_Institution_State7" name="Joint_StockInvestments_Institution_State7" class="form-control 7_Joint_state_select">
                                        <option value="">Choose State</option>
                                    </select>   
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_StockInvestments_Acct_Num7">Account Number?</label>
                                    <input id="Joint_StockInvestments_Acct_Num7" type="text" class="form-control 7_Joint_stocksinvestments_inputs" name="Joint_StockInvestments_Acct_Num7" value="<?php if(isset($drstocksinvestments->Joint_StockInvestments_Acct_Num7)){ echo $drstocksinvestments->Joint_StockInvestments_Acct_Num7; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_StockInvestments_Date_Marriage_Value7">Marriage Date Value?</label>
                                    <input id="Joint_StockInvestments_Date_Marriage_Value7" type="number" class="form-control 7_Joint_stocksinvestments_inputs" name="Joint_StockInvestments_Date_Marriage_Value7" value="<?php if(isset($drstocksinvestments->Joint_StockInvestments_Date_Marriage_Value7)){ echo $drstocksinvestments->Joint_StockInvestments_Date_Marriage_Value7; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_StockInvestments_Current_Value7">Current Value?</label>
                                    <input id="Joint_StockInvestments_Current_Value7" type="number" class="form-control 7_Joint_stocksinvestments_inputs" name="Joint_StockInvestments_Current_Value7" value="<?php if(isset($drstocksinvestments->Joint_StockInvestments_Current_Value7)){ echo $drstocksinvestments->Joint_StockInvestments_Current_Value7; } ?>" min="0.00" step="0.01" max="999999.99" onchange="getJointCurrentValue(this, '7', 'Joint');" onkeyup="getJointCurrentValue(this, '7', 'Joint');"> 
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label for="Joint_StockInvestments_Percent_Marital_Equity7">N/A, calculated = Joint_StockInvestments_Institution_Current_Value7</label>
                                    <input id="Joint_StockInvestments_Percent_Marital_Equity7" type="number" class="form-control 7_Joint_stocksinvestments_inputs" name="Joint_StockInvestments_Percent_Marital_Equity7" value="<?php if(isset($drstocksinvestments->Joint_StockInvestments_Percent_Marital_Equity7)){ echo $drstocksinvestments->Joint_StockInvestments_Percent_Marital_Equity7; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_StockInvestments_Yearly_Interest_Dividend7">Yearly Interest and Dividends from this account?</label>
                                    <input id="Joint_StockInvestments_Yearly_Interest_Dividend7" type="number" class="form-control 7_Joint_stocksinvestments_inputs" name="Joint_StockInvestments_Yearly_Interest_Dividend7" value="<?php if(isset($drstocksinvestments->Joint_StockInvestments_Yearly_Interest_Dividend7)){ echo $drstocksinvestments->Joint_StockInvestments_Yearly_Interest_Dividend7; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Does either party claim a sole/separate interest from the other on this account?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Joint_StockInvestments_SoleSeparate_Claim7_Yes" name="Joint_StockInvestments_SoleSeparate_Claim7" value="Yes" data-onload="getInitialPartyClaimSoleSeparate(this, '7', 'Joint');" onchange="getPartyClaimSoleSeparate(this, '7', 'Joint');" <?php if(isset($drstocksinvestments->Joint_StockInvestments_SoleSeparate_Claim7) && $drstocksinvestments->Joint_StockInvestments_SoleSeparate_Claim7=='Yes'){ echo "checked"; } ?>> Yes</label>
                                        <label><input type="radio" id="Joint_StockInvestments_SoleSeparate_Claim7_No" name="Joint_StockInvestments_SoleSeparate_Claim7" value="No" data-onload="getInitialPartyClaimSoleSeparate(this, '7', 'Joint');" onchange="getPartyClaimSoleSeparate(this, '7', 'Joint');" <?php if(isset($drstocksinvestments->Joint_StockInvestments_SoleSeparate_Claim7) && $drstocksinvestments->Joint_StockInvestments_SoleSeparate_Claim7=='No'){ echo "checked"; } ?>> No</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6" id="Joint_StockInvestments_SoleSeparate_Party7_Div" style="display: none;">
                                    <label>Who claims to own this account?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Joint_StockInvestments_SoleSeparate_Party7_Client" name="Joint_StockInvestments_SoleSeparate_Party7" value="{{$client_name}}" <?php if(isset($drstocksinvestments->Joint_StockInvestments_SoleSeparate_Party7) && $drstocksinvestments->Joint_StockInvestments_SoleSeparate_Party7==$client_name){ echo "checked"; } ?>> {{$client_name}}</label>
                                        <label><input type="radio" id="Joint_StockInvestments_SoleSeparate_Party7_Op" name="Joint_StockInvestments_SoleSeparate_Party7" value="{{$opponent_name}}" <?php if(isset($drstocksinvestments->Joint_StockInvestments_SoleSeparate_Party7) && $drstocksinvestments->Joint_StockInvestments_SoleSeparate_Party7==$opponent_name){ echo "checked"; } ?>> {{$opponent_name}}</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 left-clear" id="Joint_StockInvestments_SoleSeparate_Grounds7_Div" style="display: none; clear: left;">
                                    <label for="Joint_StockInvestments_SoleSeparate_Grounds7">Why does this person own this account solely and separately?</label>
                                    <input id="Joint_StockInvestments_SoleSeparate_Grounds7" type="text" class="form-control 7_Joint_stocksinvestments_inputs" name="Joint_StockInvestments_SoleSeparate_Grounds7" value="<?php if(isset($drstocksinvestments->Joint_StockInvestments_SoleSeparate_Grounds7)){ echo $drstocksinvestments->Joint_StockInvestments_SoleSeparate_Grounds7; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>How will this account value be distributed between the parties?</label>
                                    <div class="w-100 dataInput">
                                        <label><input type="radio" id="Joint_StockInvestments_Disposition_Method7_Distribute_Investments" name="Joint_StockInvestments_Disposition_Method7" value="Distribute Investments" data-onload="getInitialDipositionMethod(this, '7', 'Joint');" onchange="getDipositionMethod(this, '7', 'Joint');" <?php if(isset($drstocksinvestments->Joint_StockInvestments_Disposition_Method7) && $drstocksinvestments->Joint_StockInvestments_Disposition_Method7=='Distribute Investments'){ echo "checked"; } ?>> Distribute Investments</label>
                                        <label><input type="radio" id="Joint_StockInvestments_Disposition_Method7_Liquidate_Split_Net_Value" name="Joint_StockInvestments_Disposition_Method7" value="Liquidate/Split Net Value" data-onload="getInitialDipositionMethod(this, '7', 'Joint');" onchange="getDipositionMethod(this, '7', 'Joint');" <?php if(isset($drstocksinvestments->Joint_StockInvestments_Disposition_Method7) && $drstocksinvestments->Joint_StockInvestments_Disposition_Method7=='Liquidate/Split Net Value'){ echo "checked"; } ?>> Liquidate/Split Net Value</label>
                                        <label><input type="radio" id="Joint_StockInvestments_Disposition_Method7_Percentage_Buyout" name="Joint_StockInvestments_Disposition_Method7" value="Percentage Buyout" data-onload="getInitialDipositionMethod(this, '7', 'Joint');" onchange="getDipositionMethod(this, '7', 'Joint');" <?php if(isset($drstocksinvestments->Joint_StockInvestments_Disposition_Method7) && $drstocksinvestments->Joint_StockInvestments_Disposition_Method7=='Percentage Buyout'){ echo "checked"; } ?>> Percentage Buyout</label>
                                        <label><input type="radio" id="Joint_StockInvestments_Disposition_Method7_Fixed Buyout" name="Joint_StockInvestments_Disposition_Method7" value="Fixed Buyout" data-onload="getInitialDipositionMethod(this, '7', 'Joint');" onchange="getDipositionMethod(this, '7', 'Joint');" <?php if(isset($drstocksinvestments->Joint_StockInvestments_Disposition_Method7) && $drstocksinvestments->Joint_StockInvestments_Disposition_Method7=='Fixed Buyout'){ echo "checked"; } ?>> Fixed Buyout</label>
                                    </div>
                                </div>
                                <!-- slider tool -->
                                <div class="form-group col-sm-6 m-auto 7_Joint_Slider_Tool slider-tool-main">
                                    <div class="row">
                                        <div class="col">{{$client_name}}</div>
                                        <div class="col text-right">{{$opponent_name}}</div>
                                    </div>
                                    <input id="7_Joint_balance_range_selector" type="range" class="form-control slider-tool-input 7_Joint_balance_range_selector" name="" value="<?php if(isset($drstocksinvestments->Joint_StockInvestments_Percent_Marital_Equity_to_Op7)){ echo $drstocksinvestments->Joint_StockInvestments_Percent_Marital_Equity_to_Op7; } ?>" min="0.00" step="0.01" max="100" onchange="updateBalanceInput(this.value, '7', 'Joint');">
                                </div>
                                <div class="form-group col-sm-6 m-auto 7_Joint_Slider_Tool slider-tool-main">
                                    <div class="row justify-content-between">
                                        <div class="col selectorTool">
                                            <div class="left-col">
                                                <div class="client-info 7_Joint_clientpercentage_div clientpercentage_div">
                                                    <?php if(isset($drstocksinvestments->Joint_StockInvestments_Percent_Marital_Equity_to_Client7)){ echo $drstocksinvestments->Joint_StockInvestments_Percent_Marital_Equity_to_Client7; } else {
                                                        echo "50.00";
                                                    } ?>%
                                                </div>
                                                <div class="client-info 7_Joint_clientamount_div clientamount_div" style="clear: both;">
                                                    $<?php if(isset($drstocksinvestments->Joint_StockInvestments_Estimated_Value_to_Client7)){ echo $drstocksinvestments->Joint_StockInvestments_Estimated_Value_to_Client7; }else {
                                                        echo "0.00";
                                                    } ?>
                                                </div>
                                            </div>
                                            <label>To {{$client_name}}</label>
                                        </div>                                       
                                        <div class="col selectorTool selectorToolRight">
                                            <label>To {{$opponent_name}}</label>
                                            <div class="left-col right-col">
                                                <div class="client-info 7_Joint_opponentpercentage_div opponentpercentage_div">
                                                    <?php if(isset($drstocksinvestments->Joint_StockInvestments_Percent_Marital_Equity_to_Op7)){ echo $drstocksinvestments->Joint_StockInvestments_Percent_Marital_Equity_to_Op7; } else {
                                                        echo "50.00";
                                                    } ?>%
                                                </div>
                                                <div class="client-info 7_Joint_opponentamount_div opponentamount_div" style="clear: both;">
                                                    $<?php if(isset($drstocksinvestments->Joint_StockInvestments_Estimated_Value_to_Op7)){ echo $drstocksinvestments->Joint_StockInvestments_Estimated_Value_to_Op7; }else {
                                                        echo "0.00";
                                                    } ?>
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
                                         <label><input type="radio" id="Joint_StockInvestments_Paying_Party7_Client" name="Joint_StockInvestments_Paying_Party7" value="{{$client_name}}" data-onload="getInitialStockInvestmentPayingParty(this, '7', 'Joint');" onchange="getStockInvestmentPayingParty(this, '7', 'Joint');"  <?php if(isset($drstocksinvestments->Joint_StockInvestments_Paying_Party7) && $drstocksinvestments->Joint_StockInvestments_Paying_Party7==$client_name){ echo "checked"; } ?>> {{$client_name}}</label>
                                        <label><input type="radio" id="Joint_StockInvestments_Paying_Party7_Op" name="Joint_StockInvestments_Paying_Party7" value="{{$opponent_name}}" data-onload="getInitialStockInvestmentPayingParty(this, '7', 'Joint');" onchange="getStockInvestmentPayingParty(this, '7', 'Joint');"  <?php if(isset($drstocksinvestments->Joint_StockInvestments_Paying_Party7) && $drstocksinvestments->Joint_StockInvestments_Paying_Party7==$opponent_name){ echo "checked"; } ?>> {{$opponent_name}}</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 Joint_StockInvestments_Paying_Party7_Inputs_Div" style="display: none;">
                                    <label>{{$client_name}} StockInvestment Equity Percent</label>
                                    <input id="Joint_StockInvestments_Percent_Marital_Equity_to_Client7" type="number" class="form-control 7_Joint_clientpercentage_input clientpercentage_input" name="Joint_StockInvestments_Percent_Marital_Equity_to_Client7" value="<?php if(isset($drstocksinvestments->Joint_StockInvestments_Percent_Marital_Equity_to_Client7)){ echo $drstocksinvestments->Joint_StockInvestments_Percent_Marital_Equity_to_Client7; } ?>" min="0.00" step="0.01" max="100" readonly="">
                                </div>
                                <div class="form-group col-sm-6 Joint_StockInvestments_Paying_Party7_Inputs_Div" style="display: none;">
                                    <label>How much is to be paid to {{$client_name}}?</label>
                                    <input id="Joint_StockInvestments_Estimated_Value_to_Client7" type="number" class="form-control 7_Joint_clientamount_input clientamount_input" name="Joint_StockInvestments_Estimated_Value_to_Client7" value="<?php if(isset($drstocksinvestments->Joint_StockInvestments_Estimated_Value_to_Client7)){ echo $drstocksinvestments->Joint_StockInvestments_Estimated_Value_to_Client7; } ?>" min="0.00" step="0.01" max="999999.99" readonly="" onchange="getEstimatedValueClient(this, '7', 'Joint');" onkeyup="getEstimatedValueClient(this, '7', 'Joint');">
                                </div>
                                <div class="form-group col-sm-6 Joint_StockInvestments_Paying_Party7_Inputs_Div" style="display: none;">
                                    <label>{{$opponent_name}} StockInvestment Equity Percent</label>
                                    <input id="Joint_StockInvestments_Percent_Marital_Equity_to_Op7" type="number" class="form-control 7_Joint_opponentpercentage_input opponentpercentage_input" name="Joint_StockInvestments_Percent_Marital_Equity_to_Op7" value="<?php if(isset($drstocksinvestments->Joint_StockInvestments_Percent_Marital_Equity_to_Op7)){ echo $drstocksinvestments->Joint_StockInvestments_Percent_Marital_Equity_to_Op7; } ?>" min="0.00" step="0.01" max="100" readonly="">
                                </div>
                                <div class="form-group col-sm-6 Joint_StockInvestments_Paying_Party7_Inputs_Div" style="display: none;">
                                    <label>How much is to be paid to {{$opponent_name}}?</label>
                                    <input id="Joint_StockInvestments_Estimated_Value_to_Op7" type="number" class="form-control 7_Joint_opponentamount_input opponentamount_input" name="Joint_StockInvestments_Estimated_Value_to_Op7" value="<?php if(isset($drstocksinvestments->Joint_StockInvestments_Estimated_Value_to_Op7)){ echo $drstocksinvestments->Joint_StockInvestments_Estimated_Value_to_Op7; } ?>" min="0.00" step="0.01" max="999999.99" readonly="" onchange="getEstimatedValueOp(this, '7', 'Joint');" onkeyup="getEstimatedValueOp(this, '7', 'Joint');">
                                </div>
                                <!-- end of slider tool -->
                            </div>
                            <div class="col-sm-12 mt-4 8_Joint_stocksinvestments_section" style="display: none;"><h5 class="col-sm-12">Eighth Stock Investment Info</h5>
                                <div class="form-group col-sm-6">
                                    <p class="text-danger 8_Joint_no-state-county-found" style="display: none;">No City, State, County found for this zipcode.</p>
                                    <label for="Joint_StockInvestments_Institution_ZIP8">Stock/Investment Institution Zip Code?</label>
                                    <input id="Joint_StockInvestments_Institution_ZIP8" type="text" class="form-control 8_Joint_stocksinvestments_inputs" name="Joint_StockInvestments_Institution_ZIP8" value="<?php if(isset($drstocksinvestments->Joint_StockInvestments_Institution_ZIP8)){ echo $drstocksinvestments->Joint_StockInvestments_Institution_ZIP8; } ?>" data-onload="getCityStateForZip(this, '8', 'Joint');" onkeyup="getCityStateForZip(this, '8', 'Joint');"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_StockInvestments_Institution_Name8">Name of Stock/Investment Institution?</label>
                                    <input id="Joint_StockInvestments_Institution_Name8" type="text" class="form-control 8_Joint_stocksinvestments_inputs" name="Joint_StockInvestments_Institution_Name8" value="<?php if(isset($drstocksinvestments->Joint_StockInvestments_Institution_Name8)){ echo $drstocksinvestments->Joint_StockInvestments_Institution_Name8; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_StockInvestments_Institution_Street_Address8">Stock/Investment Institution Street Address?</label>
                                    <input id="Joint_StockInvestments_Institution_Street_Address8" type="text" class="form-control 8_Joint_stocksinvestments_inputs" name="Joint_StockInvestments_Institution_Street_Address8" value="<?php if(isset($drstocksinvestments->Joint_StockInvestments_Institution_Street_Address8)){ echo $drstocksinvestments->Joint_StockInvestments_Institution_Street_Address8; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_StockInvestments_Institution_City8">Stock/Investment Institution City?</label>
                                    <input type="hidden" name="" id="Joint_StockInvestments_Institution_City8_Value" value="<?php if(isset($drstocksinvestments->Joint_StockInvestments_Institution_City8)){ echo $drstocksinvestments->Joint_StockInvestments_Institution_City8; } ?>">
                                    <select id="Joint_StockInvestments_Institution_City8" name="Joint_StockInvestments_Institution_City8" class="form-control 8_Joint_city_select">
                                        <option value="">Choose City</option>
                                    </select>   
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_StockInvestments_Institution_State8">Stock/Investment Institution State?</label>
                                    <input type="hidden" name="" id="Joint_StockInvestments_Institution_State8_Value" value="<?php if(isset($drstocksinvestments->Joint_StockInvestments_Institution_State8)){ echo $drstocksinvestments->Joint_StockInvestments_Institution_State8; } ?>">
                                    <select id="Joint_StockInvestments_Institution_State8" name="Joint_StockInvestments_Institution_State8" class="form-control 8_Joint_state_select">
                                        <option value="">Choose State</option>
                                    </select>   
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_StockInvestments_Acct_Num8">Account Number?</label>
                                    <input id="Joint_StockInvestments_Acct_Num8" type="text" class="form-control 8_Joint_stocksinvestments_inputs" name="Joint_StockInvestments_Acct_Num8" value="<?php if(isset($drstocksinvestments->Joint_StockInvestments_Acct_Num8)){ echo $drstocksinvestments->Joint_StockInvestments_Acct_Num8; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_StockInvestments_Date_Marriage_Value8">Marriage Date Value?</label>
                                    <input id="Joint_StockInvestments_Date_Marriage_Value8" type="number" class="form-control 8_Joint_stocksinvestments_inputs" name="Joint_StockInvestments_Date_Marriage_Value8" value="<?php if(isset($drstocksinvestments->Joint_StockInvestments_Date_Marriage_Value8)){ echo $drstocksinvestments->Joint_StockInvestments_Date_Marriage_Value8; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_StockInvestments_Current_Value8">Current Value?</label>
                                    <input id="Joint_StockInvestments_Current_Value8" type="number" class="form-control 8_Joint_stocksinvestments_inputs" name="Joint_StockInvestments_Current_Value8" value="<?php if(isset($drstocksinvestments->Joint_StockInvestments_Current_Value8)){ echo $drstocksinvestments->Joint_StockInvestments_Current_Value8; } ?>" min="0.00" step="0.01" max="999999.99" onchange="getJointCurrentValue(this, '8', 'Joint');" onkeyup="getJointCurrentValue(this, '8', 'Joint');"> 
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label for="Joint_StockInvestments_Percent_Marital_Equity8">N/A, calculated = Joint_StockInvestments_Institution_Current_Value8</label>
                                    <input id="Joint_StockInvestments_Percent_Marital_Equity8" type="number" class="form-control 8_Joint_stocksinvestments_inputs" name="Joint_StockInvestments_Percent_Marital_Equity8" value="<?php if(isset($drstocksinvestments->Joint_StockInvestments_Percent_Marital_Equity8)){ echo $drstocksinvestments->Joint_StockInvestments_Percent_Marital_Equity8; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_StockInvestments_Yearly_Interest_Dividend8">Yearly Interest and Dividends from this account?</label>
                                    <input id="Joint_StockInvestments_Yearly_Interest_Dividend8" type="number" class="form-control 8_Joint_stocksinvestments_inputs" name="Joint_StockInvestments_Yearly_Interest_Dividend8" value="<?php if(isset($drstocksinvestments->Joint_StockInvestments_Yearly_Interest_Dividend8)){ echo $drstocksinvestments->Joint_StockInvestments_Yearly_Interest_Dividend8; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Does either party claim a sole/separate interest from the other on this account?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Joint_StockInvestments_SoleSeparate_Claim8_Yes" name="Joint_StockInvestments_SoleSeparate_Claim8" value="Yes" data-onload="getInitialPartyClaimSoleSeparate(this, '8', 'Joint');" onchange="getPartyClaimSoleSeparate(this, '8', 'Joint');" <?php if(isset($drstocksinvestments->Joint_StockInvestments_SoleSeparate_Claim8) && $drstocksinvestments->Joint_StockInvestments_SoleSeparate_Claim8=='Yes'){ echo "checked"; } ?>> Yes</label>
                                        <label><input type="radio" id="Joint_StockInvestments_SoleSeparate_Claim8_No" name="Joint_StockInvestments_SoleSeparate_Claim8" value="No" data-onload="getInitialPartyClaimSoleSeparate(this, '8', 'Joint');" onchange="getPartyClaimSoleSeparate(this, '8', 'Joint');" <?php if(isset($drstocksinvestments->Joint_StockInvestments_SoleSeparate_Claim8) && $drstocksinvestments->Joint_StockInvestments_SoleSeparate_Claim8=='No'){ echo "checked"; } ?>> No</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6" id="Joint_StockInvestments_SoleSeparate_Party8_Div" style="display: none;">
                                    <label>Who claims to own this account?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Joint_StockInvestments_SoleSeparate_Party8_Client" name="Joint_StockInvestments_SoleSeparate_Party8" value="{{$client_name}}" <?php if(isset($drstocksinvestments->Joint_StockInvestments_SoleSeparate_Party8) && $drstocksinvestments->Joint_StockInvestments_SoleSeparate_Party8==$client_name){ echo "checked"; } ?>> {{$client_name}}</label>
                                        <label><input type="radio" id="Joint_StockInvestments_SoleSeparate_Party8_Op" name="Joint_StockInvestments_SoleSeparate_Party8" value="{{$opponent_name}}" <?php if(isset($drstocksinvestments->Joint_StockInvestments_SoleSeparate_Party8) && $drstocksinvestments->Joint_StockInvestments_SoleSeparate_Party8==$opponent_name){ echo "checked"; } ?>> {{$opponent_name}}</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 left-clear" id="Joint_StockInvestments_SoleSeparate_Grounds8_Div" style="display: none; clear: left;">
                                    <label for="Joint_StockInvestments_SoleSeparate_Grounds8">Why does this person own this account solely and separately?</label>
                                    <input id="Joint_StockInvestments_SoleSeparate_Grounds8" type="text" class="form-control 8_Joint_stocksinvestments_inputs" name="Joint_StockInvestments_SoleSeparate_Grounds8" value="<?php if(isset($drstocksinvestments->Joint_StockInvestments_SoleSeparate_Grounds8)){ echo $drstocksinvestments->Joint_StockInvestments_SoleSeparate_Grounds8; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>How will this account value be distributed between the parties?</label>
                                    <div class="w-100 dataInput">
                                        <label><input type="radio" id="Joint_StockInvestments_Disposition_Method8_Distribute_Investments" name="Joint_StockInvestments_Disposition_Method8" value="Distribute Investments" data-onload="getInitialDipositionMethod(this, '8', 'Joint');" onchange="getDipositionMethod(this, '8', 'Joint');" <?php if(isset($drstocksinvestments->Joint_StockInvestments_Disposition_Method8) && $drstocksinvestments->Joint_StockInvestments_Disposition_Method8=='Distribute Investments'){ echo "checked"; } ?>> Distribute Investments</label>
                                        <label><input type="radio" id="Joint_StockInvestments_Disposition_Method8_Liquidate_Split_Net_Value" name="Joint_StockInvestments_Disposition_Method8" value="Liquidate/Split Net Value" data-onload="getInitialDipositionMethod(this, '8', 'Joint');" onchange="getDipositionMethod(this, '8', 'Joint');" <?php if(isset($drstocksinvestments->Joint_StockInvestments_Disposition_Method8) && $drstocksinvestments->Joint_StockInvestments_Disposition_Method8=='Liquidate/Split Net Value'){ echo "checked"; } ?>> Liquidate/Split Net Value</label>
                                        <label><input type="radio" id="Joint_StockInvestments_Disposition_Method8_Percentage_Buyout" name="Joint_StockInvestments_Disposition_Method8" value="Percentage Buyout" data-onload="getInitialDipositionMethod(this, '8', 'Joint');" onchange="getDipositionMethod(this, '8', 'Joint');" <?php if(isset($drstocksinvestments->Joint_StockInvestments_Disposition_Method8) && $drstocksinvestments->Joint_StockInvestments_Disposition_Method8=='Percentage Buyout'){ echo "checked"; } ?>> Percentage Buyout</label>
                                        <label><input type="radio" id="Joint_StockInvestments_Disposition_Method8_Fixed Buyout" name="Joint_StockInvestments_Disposition_Method8" value="Fixed Buyout" data-onload="getInitialDipositionMethod(this, '8', 'Joint');" onchange="getDipositionMethod(this, '8', 'Joint');" <?php if(isset($drstocksinvestments->Joint_StockInvestments_Disposition_Method8) && $drstocksinvestments->Joint_StockInvestments_Disposition_Method8=='Fixed Buyout'){ echo "checked"; } ?>> Fixed Buyout</label>
                                    </div>
                                </div>
                                <!-- slider tool -->
                                <div class="form-group col-sm-6 m-auto 8_Joint_Slider_Tool slider-tool-main">
                                    <div class="row">
                                        <div class="col">{{$client_name}}</div>
                                        <div class="col text-right">{{$opponent_name}}</div>
                                    </div>
                                    <input id="8_Joint_balance_range_selector" type="range" class="form-control slider-tool-input 8_Joint_balance_range_selector" name="" value="<?php if(isset($drstocksinvestments->Joint_StockInvestments_Percent_Marital_Equity_to_Op8)){ echo $drstocksinvestments->Joint_StockInvestments_Percent_Marital_Equity_to_Op8; } ?>" min="0.00" step="0.01" max="100" onchange="updateBalanceInput(this.value, '8', 'Joint');">
                                </div>
                                <div class="form-group col-sm-6 m-auto 8_Joint_Slider_Tool slider-tool-main">
                                    <div class="row justify-content-between">
                                        <div class="col selectorTool">
                                            <div class="left-col">
                                                <div class="client-info 8_Joint_clientpercentage_div clientpercentage_div">
                                                    <?php if(isset($drstocksinvestments->Joint_StockInvestments_Percent_Marital_Equity_to_Client8)){ echo $drstocksinvestments->Joint_StockInvestments_Percent_Marital_Equity_to_Client8; } else {
                                                        echo "50.00";
                                                    } ?>%
                                                </div>
                                                <div class="client-info 8_Joint_clientamount_div clientamount_div" style="clear: both;">
                                                    $<?php if(isset($drstocksinvestments->Joint_StockInvestments_Estimated_Value_to_Client8)){ echo $drstocksinvestments->Joint_StockInvestments_Estimated_Value_to_Client8; }else {
                                                        echo "0.00";
                                                    } ?>
                                                </div>
                                            </div>
                                            <label>To {{$client_name}}</label>
                                        </div>                                       
                                        <div class="col selectorTool selectorToolRight">
                                            <label>To {{$opponent_name}}</label>
                                            <div class="left-col right-col">
                                                <div class="client-info 8_Joint_opponentpercentage_div opponentpercentage_div">
                                                    <?php if(isset($drstocksinvestments->Joint_StockInvestments_Percent_Marital_Equity_to_Op8)){ echo $drstocksinvestments->Joint_StockInvestments_Percent_Marital_Equity_to_Op8; } else {
                                                        echo "50.00";
                                                    } ?>%
                                                </div>
                                                <div class="client-info 8_Joint_opponentamount_div opponentamount_div" style="clear: both;">
                                                    $<?php if(isset($drstocksinvestments->Joint_StockInvestments_Estimated_Value_to_Op8)){ echo $drstocksinvestments->Joint_StockInvestments_Estimated_Value_to_Op8; }else {
                                                        echo "0.00";
                                                    } ?>
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
                                         <label><input type="radio" id="Joint_StockInvestments_Paying_Party8_Client" name="Joint_StockInvestments_Paying_Party8" value="{{$client_name}}" data-onload="getInitialStockInvestmentPayingParty(this, '8', 'Joint');" onchange="getStockInvestmentPayingParty(this, '8', 'Joint');"  <?php if(isset($drstocksinvestments->Joint_StockInvestments_Paying_Party8) && $drstocksinvestments->Joint_StockInvestments_Paying_Party8==$client_name){ echo "checked"; } ?>> {{$client_name}}</label>
                                        <label><input type="radio" id="Joint_StockInvestments_Paying_Party8_Op" name="Joint_StockInvestments_Paying_Party8" value="{{$opponent_name}}" data-onload="getInitialStockInvestmentPayingParty(this, '8', 'Joint');" onchange="getStockInvestmentPayingParty(this, '8', 'Joint');"  <?php if(isset($drstocksinvestments->Joint_StockInvestments_Paying_Party8) && $drstocksinvestments->Joint_StockInvestments_Paying_Party8==$opponent_name){ echo "checked"; } ?>> {{$opponent_name}}</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 Joint_StockInvestments_Paying_Party8_Inputs_Div" style="display: none;">
                                    <label>{{$client_name}} StockInvestment Equity Percent</label>
                                    <input id="Joint_StockInvestments_Percent_Marital_Equity_to_Client8" type="number" class="form-control 8_Joint_clientpercentage_input clientpercentage_input" name="Joint_StockInvestments_Percent_Marital_Equity_to_Client8" value="<?php if(isset($drstocksinvestments->Joint_StockInvestments_Percent_Marital_Equity_to_Client8)){ echo $drstocksinvestments->Joint_StockInvestments_Percent_Marital_Equity_to_Client8; } ?>" min="0.00" step="0.01" max="100" readonly="">
                                </div>
                                <div class="form-group col-sm-6 Joint_StockInvestments_Paying_Party8_Inputs_Div" style="display: none;">
                                    <label>How much is to be paid to {{$client_name}}?</label>
                                    <input id="Joint_StockInvestments_Estimated_Value_to_Client8" type="number" class="form-control 8_Joint_clientamount_input clientamount_input" name="Joint_StockInvestments_Estimated_Value_to_Client8" value="<?php if(isset($drstocksinvestments->Joint_StockInvestments_Estimated_Value_to_Client8)){ echo $drstocksinvestments->Joint_StockInvestments_Estimated_Value_to_Client8; } ?>" min="0.00" step="0.01" max="999999.99" readonly="" onchange="getEstimatedValueClient(this, '8', 'Joint');" onkeyup="getEstimatedValueClient(this, '8', 'Joint');">
                                </div>
                                <div class="form-group col-sm-6 Joint_StockInvestments_Paying_Party8_Inputs_Div" style="display: none;">
                                    <label>{{$opponent_name}} StockInvestment Equity Percent</label>
                                    <input id="Joint_StockInvestments_Percent_Marital_Equity_to_Op8" type="number" class="form-control 8_Joint_opponentpercentage_input opponentpercentage_input" name="Joint_StockInvestments_Percent_Marital_Equity_to_Op8" value="<?php if(isset($drstocksinvestments->Joint_StockInvestments_Percent_Marital_Equity_to_Op8)){ echo $drstocksinvestments->Joint_StockInvestments_Percent_Marital_Equity_to_Op8; } ?>" min="0.00" step="0.01" max="100" readonly="">
                                </div>
                                <div class="form-group col-sm-6 Joint_StockInvestments_Paying_Party8_Inputs_Div" style="display: none;">
                                    <label>How much is to be paid to {{$opponent_name}}?</label>
                                    <input id="Joint_StockInvestments_Estimated_Value_to_Op8" type="number" class="form-control 8_Joint_opponentamount_input opponentamount_input" name="Joint_StockInvestments_Estimated_Value_to_Op8" value="<?php if(isset($drstocksinvestments->Joint_StockInvestments_Estimated_Value_to_Op8)){ echo $drstocksinvestments->Joint_StockInvestments_Estimated_Value_to_Op8; } ?>" min="0.00" step="0.01" max="999999.99" readonly="" onchange="getEstimatedValueOp(this, '8', 'Joint');" onkeyup="getEstimatedValueOp(this, '8', 'Joint');">
                                </div>
                                <!-- end of slider tool -->
                            </div>
                            <div class="col-sm-12 mt-4 9_Joint_stocksinvestments_section" style="display: none;"><h5 class="col-sm-12">Nineth Stock Investment Info</h5>
                                <div class="form-group col-sm-6">
                                    <p class="text-danger 9_Joint_no-state-county-found" style="display: none;">No City, State, County found for this zipcode.</p>
                                    <label for="Joint_StockInvestments_Institution_ZIP9">Stock/Investment Institution Zip Code?</label>
                                    <input id="Joint_StockInvestments_Institution_ZIP9" type="text" class="form-control 9_Joint_stocksinvestments_inputs" name="Joint_StockInvestments_Institution_ZIP9" value="<?php if(isset($drstocksinvestments->Joint_StockInvestments_Institution_ZIP9)){ echo $drstocksinvestments->Joint_StockInvestments_Institution_ZIP9; } ?>" data-onload="getCityStateForZip(this, '9', 'Joint');" onkeyup="getCityStateForZip(this, '9', 'Joint');"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_StockInvestments_Institution_Name9">Name of Stock/Investment Institution?</label>
                                    <input id="Joint_StockInvestments_Institution_Name9" type="text" class="form-control 9_Joint_stocksinvestments_inputs" name="Joint_StockInvestments_Institution_Name9" value="<?php if(isset($drstocksinvestments->Joint_StockInvestments_Institution_Name9)){ echo $drstocksinvestments->Joint_StockInvestments_Institution_Name9; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_StockInvestments_Institution_Street_Address9">Stock/Investment Institution Street Address?</label>
                                    <input id="Joint_StockInvestments_Institution_Street_Address9" type="text" class="form-control 9_Joint_stocksinvestments_inputs" name="Joint_StockInvestments_Institution_Street_Address9" value="<?php if(isset($drstocksinvestments->Joint_StockInvestments_Institution_Street_Address9)){ echo $drstocksinvestments->Joint_StockInvestments_Institution_Street_Address9; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_StockInvestments_Institution_City9">Stock/Investment Institution City?</label>
                                    <input type="hidden" name="" id="Joint_StockInvestments_Institution_City9_Value" value="<?php if(isset($drstocksinvestments->Joint_StockInvestments_Institution_City9)){ echo $drstocksinvestments->Joint_StockInvestments_Institution_City9; } ?>">
                                    <select id="Joint_StockInvestments_Institution_City9" name="Joint_StockInvestments_Institution_City9" class="form-control 9_Joint_city_select">
                                        <option value="">Choose City</option>
                                    </select>   
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_StockInvestments_Institution_State9">Stock/Investment Institution State?</label>
                                    <input type="hidden" name="" id="Joint_StockInvestments_Institution_State9_Value" value="<?php if(isset($drstocksinvestments->Joint_StockInvestments_Institution_State9)){ echo $drstocksinvestments->Joint_StockInvestments_Institution_State9; } ?>">
                                    <select id="Joint_StockInvestments_Institution_State9" name="Joint_StockInvestments_Institution_State9" class="form-control 9_Joint_state_select">
                                        <option value="">Choose State</option>
                                    </select>   
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_StockInvestments_Acct_Num9">Account Number?</label>
                                    <input id="Joint_StockInvestments_Acct_Num9" type="text" class="form-control 9_Joint_stocksinvestments_inputs" name="Joint_StockInvestments_Acct_Num9" value="<?php if(isset($drstocksinvestments->Joint_StockInvestments_Acct_Num9)){ echo $drstocksinvestments->Joint_StockInvestments_Acct_Num9; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_StockInvestments_Date_Marriage_Value9">Marriage Date Value?</label>
                                    <input id="Joint_StockInvestments_Date_Marriage_Value9" type="number" class="form-control 9_Joint_stocksinvestments_inputs" name="Joint_StockInvestments_Date_Marriage_Value9" value="<?php if(isset($drstocksinvestments->Joint_StockInvestments_Date_Marriage_Value9)){ echo $drstocksinvestments->Joint_StockInvestments_Date_Marriage_Value9; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_StockInvestments_Current_Value9">Current Value?</label>
                                    <input id="Joint_StockInvestments_Current_Value9" type="number" class="form-control 9_Joint_stocksinvestments_inputs" name="Joint_StockInvestments_Current_Value9" value="<?php if(isset($drstocksinvestments->Joint_StockInvestments_Current_Value9)){ echo $drstocksinvestments->Joint_StockInvestments_Current_Value9; } ?>" min="0.00" step="0.01" max="999999.99" onchange="getJointCurrentValue(this, '9', 'Joint');" onkeyup="getJointCurrentValue(this, '9', 'Joint');"> 
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label for="Joint_StockInvestments_Percent_Marital_Equity9">N/A, calculated = Joint_StockInvestments_Institution_Current_Value9</label>
                                    <input id="Joint_StockInvestments_Percent_Marital_Equity9" type="number" class="form-control 9_Joint_stocksinvestments_inputs" name="Joint_StockInvestments_Percent_Marital_Equity9" value="<?php if(isset($drstocksinvestments->Joint_StockInvestments_Percent_Marital_Equity9)){ echo $drstocksinvestments->Joint_StockInvestments_Percent_Marital_Equity9; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_StockInvestments_Yearly_Interest_Dividend9">Yearly Interest and Dividends from this account?</label>
                                    <input id="Joint_StockInvestments_Yearly_Interest_Dividend9" type="number" class="form-control 9_Joint_stocksinvestments_inputs" name="Joint_StockInvestments_Yearly_Interest_Dividend9" value="<?php if(isset($drstocksinvestments->Joint_StockInvestments_Yearly_Interest_Dividend9)){ echo $drstocksinvestments->Joint_StockInvestments_Yearly_Interest_Dividend9; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Does either party claim a sole/separate interest from the other on this account?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Joint_StockInvestments_SoleSeparate_Claim9_Yes" name="Joint_StockInvestments_SoleSeparate_Claim9" value="Yes" data-onload="getInitialPartyClaimSoleSeparate(this, '9', 'Joint');" onchange="getPartyClaimSoleSeparate(this, '9', 'Joint');" <?php if(isset($drstocksinvestments->Joint_StockInvestments_SoleSeparate_Claim9) && $drstocksinvestments->Joint_StockInvestments_SoleSeparate_Claim9=='Yes'){ echo "checked"; } ?>> Yes</label>
                                        <label><input type="radio" id="Joint_StockInvestments_SoleSeparate_Claim9_No" name="Joint_StockInvestments_SoleSeparate_Claim9" value="No" data-onload="getInitialPartyClaimSoleSeparate(this, '9', 'Joint');" onchange="getPartyClaimSoleSeparate(this, '9', 'Joint');" <?php if(isset($drstocksinvestments->Joint_StockInvestments_SoleSeparate_Claim9) && $drstocksinvestments->Joint_StockInvestments_SoleSeparate_Claim9=='No'){ echo "checked"; } ?>> No</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6" id="Joint_StockInvestments_SoleSeparate_Party9_Div" style="display: none;">
                                    <label>Who claims to own this account?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Joint_StockInvestments_SoleSeparate_Party9_Client" name="Joint_StockInvestments_SoleSeparate_Party9" value="{{$client_name}}" <?php if(isset($drstocksinvestments->Joint_StockInvestments_SoleSeparate_Party9) && $drstocksinvestments->Joint_StockInvestments_SoleSeparate_Party9==$client_name){ echo "checked"; } ?>> {{$client_name}}</label>
                                        <label><input type="radio" id="Joint_StockInvestments_SoleSeparate_Party9_Op" name="Joint_StockInvestments_SoleSeparate_Party9" value="{{$opponent_name}}" <?php if(isset($drstocksinvestments->Joint_StockInvestments_SoleSeparate_Party9) && $drstocksinvestments->Joint_StockInvestments_SoleSeparate_Party9==$opponent_name){ echo "checked"; } ?>> {{$opponent_name}}</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 left-clear" id="Joint_StockInvestments_SoleSeparate_Grounds9_Div" style="display: none; clear: left;">
                                    <label for="Joint_StockInvestments_SoleSeparate_Grounds9">Why does this person own this account solely and separately?</label>
                                    <input id="Joint_StockInvestments_SoleSeparate_Grounds9" type="text" class="form-control 9_Joint_stocksinvestments_inputs" name="Joint_StockInvestments_SoleSeparate_Grounds9" value="<?php if(isset($drstocksinvestments->Joint_StockInvestments_SoleSeparate_Grounds9)){ echo $drstocksinvestments->Joint_StockInvestments_SoleSeparate_Grounds9; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>How will this account value be distributed between the parties?</label>
                                    <div class="w-100 dataInput">
                                        <label><input type="radio" id="Joint_StockInvestments_Disposition_Method9_Distribute_Investments" name="Joint_StockInvestments_Disposition_Method9" value="Distribute Investments" data-onload="getInitialDipositionMethod(this, '9', 'Joint');" onchange="getDipositionMethod(this, '9', 'Joint');" <?php if(isset($drstocksinvestments->Joint_StockInvestments_Disposition_Method9) && $drstocksinvestments->Joint_StockInvestments_Disposition_Method9=='Distribute Investments'){ echo "checked"; } ?>> Distribute Investments</label>
                                        <label><input type="radio" id="Joint_StockInvestments_Disposition_Method9_Liquidate_Split_Net_Value" name="Joint_StockInvestments_Disposition_Method9" value="Liquidate/Split Net Value" data-onload="getInitialDipositionMethod(this, '9', 'Joint');" onchange="getDipositionMethod(this, '9', 'Joint');" <?php if(isset($drstocksinvestments->Joint_StockInvestments_Disposition_Method9) && $drstocksinvestments->Joint_StockInvestments_Disposition_Method9=='Liquidate/Split Net Value'){ echo "checked"; } ?>> Liquidate/Split Net Value</label>
                                        <label><input type="radio" id="Joint_StockInvestments_Disposition_Method9_Percentage_Buyout" name="Joint_StockInvestments_Disposition_Method9" value="Percentage Buyout" data-onload="getInitialDipositionMethod(this, '9', 'Joint');" onchange="getDipositionMethod(this, '9', 'Joint');" <?php if(isset($drstocksinvestments->Joint_StockInvestments_Disposition_Method9) && $drstocksinvestments->Joint_StockInvestments_Disposition_Method9=='Percentage Buyout'){ echo "checked"; } ?>> Percentage Buyout</label>
                                        <label><input type="radio" id="Joint_StockInvestments_Disposition_Method9_Fixed Buyout" name="Joint_StockInvestments_Disposition_Method9" value="Fixed Buyout" data-onload="getInitialDipositionMethod(this, '9', 'Joint');" onchange="getDipositionMethod(this, '9', 'Joint');" <?php if(isset($drstocksinvestments->Joint_StockInvestments_Disposition_Method9) && $drstocksinvestments->Joint_StockInvestments_Disposition_Method9=='Fixed Buyout'){ echo "checked"; } ?>> Fixed Buyout</label>
                                    </div>
                                </div>
                                <!-- slider tool -->
                                <div class="form-group col-sm-6 m-auto 9_Joint_Slider_Tool slider-tool-main">
                                    <div class="row">
                                        <div class="col">{{$client_name}}</div>
                                        <div class="col text-right">{{$opponent_name}}</div>
                                    </div>
                                    <input id="9_Joint_balance_range_selector" type="range" class="form-control slider-tool-input 9_Joint_balance_range_selector" name="" value="<?php if(isset($drstocksinvestments->Joint_StockInvestments_Percent_Marital_Equity_to_Op9)){ echo $drstocksinvestments->Joint_StockInvestments_Percent_Marital_Equity_to_Op9; } ?>" min="0.00" step="0.01" max="100" onchange="updateBalanceInput(this.value, '9', 'Joint');">
                                </div>
                                <div class="form-group col-sm-6 m-auto 9_Joint_Slider_Tool slider-tool-main">
                                    <div class="row justify-content-between">
                                        <div class="col selectorTool">
                                            <div class="left-col">
                                                <div class="client-info 9_Joint_clientpercentage_div clientpercentage_div">
                                                    <?php if(isset($drstocksinvestments->Joint_StockInvestments_Percent_Marital_Equity_to_Client9)){ echo $drstocksinvestments->Joint_StockInvestments_Percent_Marital_Equity_to_Client9; } else {
                                                        echo "50.00";
                                                    } ?>%
                                                </div>
                                                <div class="client-info 9_Joint_clientamount_div clientamount_div" style="clear: both;">
                                                    $<?php if(isset($drstocksinvestments->Joint_StockInvestments_Estimated_Value_to_Client9)){ echo $drstocksinvestments->Joint_StockInvestments_Estimated_Value_to_Client9; }else {
                                                        echo "0.00";
                                                    } ?>
                                                </div>
                                            </div>
                                            <label>To {{$client_name}}</label>
                                        </div>                                       
                                        <div class="col selectorTool selectorToolRight">
                                            <label>To {{$opponent_name}}</label>
                                            <div class="left-col right-col">
                                                <div class="client-info 9_Joint_opponentpercentage_div opponentpercentage_div">
                                                    <?php if(isset($drstocksinvestments->Joint_StockInvestments_Percent_Marital_Equity_to_Op9)){ echo $drstocksinvestments->Joint_StockInvestments_Percent_Marital_Equity_to_Op9; } else {
                                                        echo "50.00";
                                                    } ?>%
                                                </div>
                                                <div class="client-info 9_Joint_opponentamount_div opponentamount_div" style="clear: both;">
                                                    $<?php if(isset($drstocksinvestments->Joint_StockInvestments_Estimated_Value_to_Op9)){ echo $drstocksinvestments->Joint_StockInvestments_Estimated_Value_to_Op9; }else {
                                                        echo "0.00";
                                                    } ?>
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
                                         <label><input type="radio" id="Joint_StockInvestments_Paying_Party9_Client" name="Joint_StockInvestments_Paying_Party9" value="{{$client_name}}" data-onload="getInitialStockInvestmentPayingParty(this, '9', 'Joint');" onchange="getStockInvestmentPayingParty(this, '9', 'Joint');"  <?php if(isset($drstocksinvestments->Joint_StockInvestments_Paying_Party9) && $drstocksinvestments->Joint_StockInvestments_Paying_Party9==$client_name){ echo "checked"; } ?>> {{$client_name}}</label>
                                        <label><input type="radio" id="Joint_StockInvestments_Paying_Party9_Op" name="Joint_StockInvestments_Paying_Party9" value="{{$opponent_name}}" data-onload="getInitialStockInvestmentPayingParty(this, '9', 'Joint');" onchange="getStockInvestmentPayingParty(this, '9', 'Joint');"  <?php if(isset($drstocksinvestments->Joint_StockInvestments_Paying_Party9) && $drstocksinvestments->Joint_StockInvestments_Paying_Party9==$opponent_name){ echo "checked"; } ?>> {{$opponent_name}}</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 Joint_StockInvestments_Paying_Party9_Inputs_Div" style="display: none;">
                                    <label>{{$client_name}} StockInvestment Equity Percent</label>
                                    <input id="Joint_StockInvestments_Percent_Marital_Equity_to_Client9" type="number" class="form-control 9_Joint_clientpercentage_input clientpercentage_input" name="Joint_StockInvestments_Percent_Marital_Equity_to_Client9" value="<?php if(isset($drstocksinvestments->Joint_StockInvestments_Percent_Marital_Equity_to_Client9)){ echo $drstocksinvestments->Joint_StockInvestments_Percent_Marital_Equity_to_Client9; } ?>" min="0.00" step="0.01" max="100" readonly="">
                                </div>
                                <div class="form-group col-sm-6 Joint_StockInvestments_Paying_Party9_Inputs_Div" style="display: none;">
                                    <label>How much is to be paid to {{$client_name}}?</label>
                                    <input id="Joint_StockInvestments_Estimated_Value_to_Client9" type="number" class="form-control 9_Joint_clientamount_input clientamount_input" name="Joint_StockInvestments_Estimated_Value_to_Client9" value="<?php if(isset($drstocksinvestments->Joint_StockInvestments_Estimated_Value_to_Client9)){ echo $drstocksinvestments->Joint_StockInvestments_Estimated_Value_to_Client9; } ?>" min="0.00" step="0.01" max="999999.99" readonly="" onchange="getEstimatedValueClient(this, '9', 'Joint');" onkeyup="getEstimatedValueClient(this, '9', 'Joint');">
                                </div>
                                <div class="form-group col-sm-6 Joint_StockInvestments_Paying_Party9_Inputs_Div" style="display: none;">
                                    <label>{{$opponent_name}} StockInvestment Equity Percent</label>
                                    <input id="Joint_StockInvestments_Percent_Marital_Equity_to_Op9" type="number" class="form-control 9_Joint_opponentpercentage_input opponentpercentage_input" name="Joint_StockInvestments_Percent_Marital_Equity_to_Op9" value="<?php if(isset($drstocksinvestments->Joint_StockInvestments_Percent_Marital_Equity_to_Op9)){ echo $drstocksinvestments->Joint_StockInvestments_Percent_Marital_Equity_to_Op9; } ?>" min="0.00" step="0.01" max="100" readonly="">
                                </div>
                                <div class="form-group col-sm-6 Joint_StockInvestments_Paying_Party9_Inputs_Div" style="display: none;">
                                    <label>How much is to be paid to {{$opponent_name}}?</label>
                                    <input id="Joint_StockInvestments_Estimated_Value_to_Op9" type="number" class="form-control 9_Joint_opponentamount_input opponentamount_input" name="Joint_StockInvestments_Estimated_Value_to_Op9" value="<?php if(isset($drstocksinvestments->Joint_StockInvestments_Estimated_Value_to_Op9)){ echo $drstocksinvestments->Joint_StockInvestments_Estimated_Value_to_Op9; } ?>" min="0.00" step="0.01" max="999999.99" readonly="" onchange="getEstimatedValueOp(this, '9', 'Joint');" onkeyup="getEstimatedValueOp(this, '9', 'Joint');">
                                </div>
                                <!-- end of slider tool -->
                            </div>
                            <div class="col-sm-12 mt-4 10_Joint_stocksinvestments_section" style="display: none;"><h5 class="col-sm-12">Tenth Stock Investment Info</h5>
                                <div class="form-group col-sm-6">
                                    <p class="text-danger 10_Joint_no-state-county-found" style="display: none;">No City, State, County found for this zipcode.</p>
                                    <label for="Joint_StockInvestments_Institution_ZIP10">Stock/Investment Institution Zip Code?</label>
                                    <input id="Joint_StockInvestments_Institution_ZIP10" type="text" class="form-control 10_Joint_stocksinvestments_inputs" name="Joint_StockInvestments_Institution_ZIP10" value="<?php if(isset($drstocksinvestments->Joint_StockInvestments_Institution_ZIP10)){ echo $drstocksinvestments->Joint_StockInvestments_Institution_ZIP10; } ?>" data-onload="getCityStateForZip(this, '10', 'Joint');" onkeyup="getCityStateForZip(this, '10', 'Joint');"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_StockInvestments_Institution_Name10">Name of Stock/Investment Institution?</label>
                                    <input id="Joint_StockInvestments_Institution_Name10" type="text" class="form-control 10_Joint_stocksinvestments_inputs" name="Joint_StockInvestments_Institution_Name10" value="<?php if(isset($drstocksinvestments->Joint_StockInvestments_Institution_Name10)){ echo $drstocksinvestments->Joint_StockInvestments_Institution_Name10; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_StockInvestments_Institution_Street_Address10">Stock/Investment Institution Street Address?</label>
                                    <input id="Joint_StockInvestments_Institution_Street_Address10" type="text" class="form-control 10_Joint_stocksinvestments_inputs" name="Joint_StockInvestments_Institution_Street_Address10" value="<?php if(isset($drstocksinvestments->Joint_StockInvestments_Institution_Street_Address10)){ echo $drstocksinvestments->Joint_StockInvestments_Institution_Street_Address10; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_StockInvestments_Institution_City10">Stock/Investment Institution City?</label>
                                    <input type="hidden" name="" id="Joint_StockInvestments_Institution_City10_Value" value="<?php if(isset($drstocksinvestments->Joint_StockInvestments_Institution_City10)){ echo $drstocksinvestments->Joint_StockInvestments_Institution_City10; } ?>">
                                    <select id="Joint_StockInvestments_Institution_City10" name="Joint_StockInvestments_Institution_City10" class="form-control 10_Joint_city_select">
                                        <option value="">Choose City</option>
                                    </select>   
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_StockInvestments_Institution_State10">Stock/Investment Institution State?</label>
                                    <input type="hidden" name="" id="Joint_StockInvestments_Institution_State10_Value" value="<?php if(isset($drstocksinvestments->Joint_StockInvestments_Institution_State10)){ echo $drstocksinvestments->Joint_StockInvestments_Institution_State10; } ?>">
                                    <select id="Joint_StockInvestments_Institution_State10" name="Joint_StockInvestments_Institution_State10" class="form-control 10_Joint_state_select">
                                        <option value="">Choose State</option>
                                    </select>   
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_StockInvestments_Acct_Num10">Account Number?</label>
                                    <input id="Joint_StockInvestments_Acct_Num10" type="text" class="form-control 10_Joint_stocksinvestments_inputs" name="Joint_StockInvestments_Acct_Num10" value="<?php if(isset($drstocksinvestments->Joint_StockInvestments_Acct_Num10)){ echo $drstocksinvestments->Joint_StockInvestments_Acct_Num10; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_StockInvestments_Date_Marriage_Value10">Marriage Date Value?</label>
                                    <input id="Joint_StockInvestments_Date_Marriage_Value10" type="number" class="form-control 10_Joint_stocksinvestments_inputs" name="Joint_StockInvestments_Date_Marriage_Value10" value="<?php if(isset($drstocksinvestments->Joint_StockInvestments_Date_Marriage_Value10)){ echo $drstocksinvestments->Joint_StockInvestments_Date_Marriage_Value10; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_StockInvestments_Current_Value10">Current Value?</label>
                                    <input id="Joint_StockInvestments_Current_Value10" type="number" class="form-control 10_Joint_stocksinvestments_inputs" name="Joint_StockInvestments_Current_Value10" value="<?php if(isset($drstocksinvestments->Joint_StockInvestments_Current_Value10)){ echo $drstocksinvestments->Joint_StockInvestments_Current_Value10; } ?>" min="0.00" step="0.01" max="999999.99" onchange="getJointCurrentValue(this, '10', 'Joint');" onkeyup="getJointCurrentValue(this, '10', 'Joint');"> 
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label for="Joint_StockInvestments_Percent_Marital_Equity10">N/A, calculated = Joint_StockInvestments_Institution_Current_Value10</label>
                                    <input id="Joint_StockInvestments_Percent_Marital_Equity10" type="number" class="form-control 10_Joint_stocksinvestments_inputs" name="Joint_StockInvestments_Percent_Marital_Equity10" value="<?php if(isset($drstocksinvestments->Joint_StockInvestments_Percent_Marital_Equity10)){ echo $drstocksinvestments->Joint_StockInvestments_Percent_Marital_Equity10; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_StockInvestments_Yearly_Interest_Dividend10">Yearly Interest and Dividends from this account?</label>
                                    <input id="Joint_StockInvestments_Yearly_Interest_Dividend10" type="number" class="form-control 10_Joint_stocksinvestments_inputs" name="Joint_StockInvestments_Yearly_Interest_Dividend10" value="<?php if(isset($drstocksinvestments->Joint_StockInvestments_Yearly_Interest_Dividend10)){ echo $drstocksinvestments->Joint_StockInvestments_Yearly_Interest_Dividend10; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Does either party claim a sole/separate interest from the other on this account?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Joint_StockInvestments_SoleSeparate_Claim10_Yes" name="Joint_StockInvestments_SoleSeparate_Claim10" value="Yes" data-onload="getInitialPartyClaimSoleSeparate(this, '10', 'Joint');" onchange="getPartyClaimSoleSeparate(this, '10', 'Joint');" <?php if(isset($drstocksinvestments->Joint_StockInvestments_SoleSeparate_Claim10) && $drstocksinvestments->Joint_StockInvestments_SoleSeparate_Claim10=='Yes'){ echo "checked"; } ?>> Yes</label>
                                        <label><input type="radio" id="Joint_StockInvestments_SoleSeparate_Claim10_No" name="Joint_StockInvestments_SoleSeparate_Claim10" value="No" data-onload="getInitialPartyClaimSoleSeparate(this, '10', 'Joint');" onchange="getPartyClaimSoleSeparate(this, '10', 'Joint');" <?php if(isset($drstocksinvestments->Joint_StockInvestments_SoleSeparate_Claim10) && $drstocksinvestments->Joint_StockInvestments_SoleSeparate_Claim10=='No'){ echo "checked"; } ?>> No</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6" id="Joint_StockInvestments_SoleSeparate_Party10_Div" style="display: none;">
                                    <label>Who claims to own this account?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Joint_StockInvestments_SoleSeparate_Party10_Client" name="Joint_StockInvestments_SoleSeparate_Party10" value="{{$client_name}}" <?php if(isset($drstocksinvestments->Joint_StockInvestments_SoleSeparate_Party10) && $drstocksinvestments->Joint_StockInvestments_SoleSeparate_Party10==$client_name){ echo "checked"; } ?>> {{$client_name}}</label>
                                        <label><input type="radio" id="Joint_StockInvestments_SoleSeparate_Party10_Op" name="Joint_StockInvestments_SoleSeparate_Party10" value="{{$opponent_name}}" <?php if(isset($drstocksinvestments->Joint_StockInvestments_SoleSeparate_Party10) && $drstocksinvestments->Joint_StockInvestments_SoleSeparate_Party10==$opponent_name){ echo "checked"; } ?>> {{$opponent_name}}</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 left-clear" id="Joint_StockInvestments_SoleSeparate_Grounds10_Div" style="display: none; clear: left;">
                                    <label for="Joint_StockInvestments_SoleSeparate_Grounds10">Why does this person own this account solely and separately?</label>
                                    <input id="Joint_StockInvestments_SoleSeparate_Grounds10" type="text" class="form-control 10_Joint_stocksinvestments_inputs" name="Joint_StockInvestments_SoleSeparate_Grounds10" value="<?php if(isset($drstocksinvestments->Joint_StockInvestments_SoleSeparate_Grounds10)){ echo $drstocksinvestments->Joint_StockInvestments_SoleSeparate_Grounds10; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>How will this account value be distributed between the parties?</label>
                                    <div class="w-100 dataInput">
                                        <label><input type="radio" id="Joint_StockInvestments_Disposition_Method10_Distribute_Investments" name="Joint_StockInvestments_Disposition_Method10" value="Distribute Investments" data-onload="getInitialDipositionMethod(this, '10', 'Joint');" onchange="getDipositionMethod(this, '10', 'Joint');" <?php if(isset($drstocksinvestments->Joint_StockInvestments_Disposition_Method10) && $drstocksinvestments->Joint_StockInvestments_Disposition_Method10=='Distribute Investments'){ echo "checked"; } ?>> Distribute Investments</label>
                                        <label><input type="radio" id="Joint_StockInvestments_Disposition_Method10_Liquidate_Split_Net_Value" name="Joint_StockInvestments_Disposition_Method10" value="Liquidate/Split Net Value" data-onload="getInitialDipositionMethod(this, '10', 'Joint');" onchange="getDipositionMethod(this, '10', 'Joint');" <?php if(isset($drstocksinvestments->Joint_StockInvestments_Disposition_Method10) && $drstocksinvestments->Joint_StockInvestments_Disposition_Method10=='Liquidate/Split Net Value'){ echo "checked"; } ?>> Liquidate/Split Net Value</label>
                                        <label><input type="radio" id="Joint_StockInvestments_Disposition_Method10_Percentage_Buyout" name="Joint_StockInvestments_Disposition_Method10" value="Percentage Buyout" data-onload="getInitialDipositionMethod(this, '10', 'Joint');" onchange="getDipositionMethod(this, '10', 'Joint');" <?php if(isset($drstocksinvestments->Joint_StockInvestments_Disposition_Method10) && $drstocksinvestments->Joint_StockInvestments_Disposition_Method10=='Percentage Buyout'){ echo "checked"; } ?>> Percentage Buyout</label>
                                        <label><input type="radio" id="Joint_StockInvestments_Disposition_Method10_Fixed Buyout" name="Joint_StockInvestments_Disposition_Method10" value="Fixed Buyout" data-onload="getInitialDipositionMethod(this, '10', 'Joint');" onchange="getDipositionMethod(this, '10', 'Joint');" <?php if(isset($drstocksinvestments->Joint_StockInvestments_Disposition_Method10) && $drstocksinvestments->Joint_StockInvestments_Disposition_Method10=='Fixed Buyout'){ echo "checked"; } ?>> Fixed Buyout</label>
                                    </div>
                                </div>
                                <!-- slider tool -->
                                <div class="form-group col-sm-6 m-auto 10_Joint_Slider_Tool slider-tool-main">
                                    <div class="row">
                                        <div class="col">{{$client_name}}</div>
                                        <div class="col text-right">{{$opponent_name}}</div>
                                    </div>
                                    <input id="10_Joint_balance_range_selector" type="range" class="form-control slider-tool-input 10_Joint_balance_range_selector" name="" value="<?php if(isset($drstocksinvestments->Joint_StockInvestments_Percent_Marital_Equity_to_Op10)){ echo $drstocksinvestments->Joint_StockInvestments_Percent_Marital_Equity_to_Op10; } ?>" min="0.00" step="0.01" max="100" onchange="updateBalanceInput(this.value, '10', 'Joint');">
                                </div>
                                <div class="form-group col-sm-6 m-auto 10_Joint_Slider_Tool slider-tool-main">
                                    <div class="row justify-content-between">
                                        <div class="col selectorTool">
                                            <div class="left-col">
                                                <div class="client-info 10_Joint_clientpercentage_div clientpercentage_div">
                                                    <?php if(isset($drstocksinvestments->Joint_StockInvestments_Percent_Marital_Equity_to_Client10)){ echo $drstocksinvestments->Joint_StockInvestments_Percent_Marital_Equity_to_Client10; } else {
                                                        echo "50.00";
                                                    } ?>%
                                                </div>
                                                <div class="client-info 10_Joint_clientamount_div clientamount_div" style="clear: both;">
                                                    $<?php if(isset($drstocksinvestments->Joint_StockInvestments_Estimated_Value_to_Client10)){ echo $drstocksinvestments->Joint_StockInvestments_Estimated_Value_to_Client10; }else {
                                                        echo "0.00";
                                                    } ?>
                                                </div>
                                            </div>
                                            <label>To {{$client_name}}</label>
                                        </div>                                       
                                        <div class="col selectorTool selectorToolRight">
                                            <label>To {{$opponent_name}}</label>
                                            <div class="left-col right-col">
                                                <div class="client-info 10_Joint_opponentpercentage_div opponentpercentage_div">
                                                    <?php if(isset($drstocksinvestments->Joint_StockInvestments_Percent_Marital_Equity_to_Op10)){ echo $drstocksinvestments->Joint_StockInvestments_Percent_Marital_Equity_to_Op10; } else {
                                                        echo "50.00";
                                                    } ?>%
                                                </div>
                                                <div class="client-info 10_Joint_opponentamount_div opponentamount_div" style="clear: both;">
                                                    $<?php if(isset($drstocksinvestments->Joint_StockInvestments_Estimated_Value_to_Op10)){ echo $drstocksinvestments->Joint_StockInvestments_Estimated_Value_to_Op10; }else {
                                                        echo "0.00";
                                                    } ?>
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
                                         <label><input type="radio" id="Joint_StockInvestments_Paying_Party10_Client" name="Joint_StockInvestments_Paying_Party10" value="{{$client_name}}" data-onload="getInitialStockInvestmentPayingParty(this, '10', 'Joint');" onchange="getStockInvestmentPayingParty(this, '10', 'Joint');"  <?php if(isset($drstocksinvestments->Joint_StockInvestments_Paying_Party10) && $drstocksinvestments->Joint_StockInvestments_Paying_Party10==$client_name){ echo "checked"; } ?>> {{$client_name}}</label>
                                        <label><input type="radio" id="Joint_StockInvestments_Paying_Party10_Op" name="Joint_StockInvestments_Paying_Party10" value="{{$opponent_name}}" data-onload="getInitialStockInvestmentPayingParty(this, '10', 'Joint');" onchange="getStockInvestmentPayingParty(this, '10', 'Joint');"  <?php if(isset($drstocksinvestments->Joint_StockInvestments_Paying_Party10) && $drstocksinvestments->Joint_StockInvestments_Paying_Party10==$opponent_name){ echo "checked"; } ?>> {{$opponent_name}}</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 Joint_StockInvestments_Paying_Party10_Inputs_Div" style="display: none;">
                                    <label>{{$client_name}} StockInvestment Equity Percent</label>
                                    <input id="Joint_StockInvestments_Percent_Marital_Equity_to_Client10" type="number" class="form-control 10_Joint_clientpercentage_input clientpercentage_input" name="Joint_StockInvestments_Percent_Marital_Equity_to_Client10" value="<?php if(isset($drstocksinvestments->Joint_StockInvestments_Percent_Marital_Equity_to_Client10)){ echo $drstocksinvestments->Joint_StockInvestments_Percent_Marital_Equity_to_Client10; } ?>" min="0.00" step="0.01" max="100" readonly="">
                                </div>
                                <div class="form-group col-sm-6 Joint_StockInvestments_Paying_Party10_Inputs_Div" style="display: none;">
                                    <label>How much is to be paid to {{$client_name}}?</label>
                                    <input id="Joint_StockInvestments_Estimated_Value_to_Client10" type="number" class="form-control 10_Joint_clientamount_input clientamount_input" name="Joint_StockInvestments_Estimated_Value_to_Client10" value="<?php if(isset($drstocksinvestments->Joint_StockInvestments_Estimated_Value_to_Client10)){ echo $drstocksinvestments->Joint_StockInvestments_Estimated_Value_to_Client10; } ?>" min="0.00" step="0.01" max="999999.99" readonly="" onchange="getEstimatedValueClient(this, '10', 'Joint');" onkeyup="getEstimatedValueClient(this, '10', 'Joint');">
                                </div>
                                <div class="form-group col-sm-6 Joint_StockInvestments_Paying_Party10_Inputs_Div" style="display: none;">
                                    <label>{{$opponent_name}} StockInvestment Equity Percent</label>
                                    <input id="Joint_StockInvestments_Percent_Marital_Equity_to_Op10" type="number" class="form-control 10_Joint_opponentpercentage_input opponentpercentage_input" name="Joint_StockInvestments_Percent_Marital_Equity_to_Op10" value="<?php if(isset($drstocksinvestments->Joint_StockInvestments_Percent_Marital_Equity_to_Op10)){ echo $drstocksinvestments->Joint_StockInvestments_Percent_Marital_Equity_to_Op10; } ?>" min="0.00" step="0.01" max="100" readonly="">
                                </div>
                                <div class="form-group col-sm-6 Joint_StockInvestments_Paying_Party10_Inputs_Div" style="display: none;">
                                    <label>How much is to be paid to {{$opponent_name}}?</label>
                                    <input id="Joint_StockInvestments_Estimated_Value_to_Op10" type="number" class="form-control 10_Joint_opponentamount_input opponentamount_input" name="Joint_StockInvestments_Estimated_Value_to_Op10" value="<?php if(isset($drstocksinvestments->Joint_StockInvestments_Estimated_Value_to_Op10)){ echo $drstocksinvestments->Joint_StockInvestments_Estimated_Value_to_Op10; } ?>" min="0.00" step="0.01" max="999999.99" readonly="" onchange="getEstimatedValueOp(this, '10', 'Joint');" onkeyup="getEstimatedValueOp(this, '10', 'Joint');">
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
                                <input id="Num_Client_StockInvestments_Accounts" type="number" class="form-control" name="Num_Client_StockInvestments_Accounts" value="<?php if(isset($drstocksinvestments->Num_Client_StockInvestments_Accounts)){ echo $drstocksinvestments->Num_Client_StockInvestments_Accounts; } ?>" min="0" max="10"> 
                            </div>
                        </div>
                        <div class="form-row Client_stocksinvestments_section">
                            <div class="col-sm-12 mt-4 1_Client_stocksinvestments_section" style="display: none;"><h5 class="col-sm-12">First Stock Investment Info</h5>
                                <div class="form-group col-sm-6">
                                    <p class="text-danger 1_Client_no-state-county-found" style="display: none;">No City, State, County found for this zipcode.</p>
                                    <label for="Client_StockInvestments_Institution_ZIP1">Stock/Investment Institution Zip Code?</label>
                                    <input id="Client_StockInvestments_Institution_ZIP1" type="text" class="form-control 1_Client_stocksinvestments_inputs" name="Client_StockInvestments_Institution_ZIP1" value="<?php if(isset($drstocksinvestments->Client_StockInvestments_Institution_ZIP1)){ echo $drstocksinvestments->Client_StockInvestments_Institution_ZIP1; } ?>" data-onload="getCityStateForZip(this, '1', 'Client');" onkeyup="getCityStateForZip(this, '1', 'Client');"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_StockInvestments_Institution_Name1">Name of Stock/Investment Institution?</label>
                                    <input id="Client_StockInvestments_Institution_Name1" type="text" class="form-control 1_Client_stocksinvestments_inputs" name="Client_StockInvestments_Institution_Name1" value="<?php if(isset($drstocksinvestments->Client_StockInvestments_Institution_Name1)){ echo $drstocksinvestments->Client_StockInvestments_Institution_Name1; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_StockInvestments_Institution_Street_Address1">Stock/Investment Institution Street Address?</label>
                                    <input id="Client_StockInvestments_Institution_Street_Address1" type="text" class="form-control 1_Client_stocksinvestments_inputs" name="Client_StockInvestments_Institution_Street_Address1" value="<?php if(isset($drstocksinvestments->Client_StockInvestments_Institution_Street_Address1)){ echo $drstocksinvestments->Client_StockInvestments_Institution_Street_Address1; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_StockInvestments_Institution_City1">Stock/Investment Institution City?</label>
                                    <input type="hidden" name="" id="Client_StockInvestments_Institution_City1_Value" value="<?php if(isset($drstocksinvestments->Client_StockInvestments_Institution_City1)){ echo $drstocksinvestments->Client_StockInvestments_Institution_City1; } ?>">
                                    <select id="Client_StockInvestments_Institution_City1" name="Client_StockInvestments_Institution_City1" class="form-control 1_Client_city_select">
                                        <option value="">Choose City</option>
                                    </select>   
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_StockInvestments_Institution_State1">Stock/Investment Institution State?</label>
                                    <input type="hidden" name="" id="Client_StockInvestments_Institution_State1_Value" value="<?php if(isset($drstocksinvestments->Client_StockInvestments_Institution_State1)){ echo $drstocksinvestments->Client_StockInvestments_Institution_State1; } ?>">
                                    <select id="Client_StockInvestments_Institution_State1" name="Client_StockInvestments_Institution_State1" class="form-control 1_Client_state_select">
                                        <option value="">Choose State</option>
                                    </select>   
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_StockInvestments_Acct_Num1">Account Number?</label>
                                    <input id="Client_StockInvestments_Acct_Num1" type="text" class="form-control 1_Client_stocksinvestments_inputs" name="Client_StockInvestments_Acct_Num1" value="<?php if(isset($drstocksinvestments->Client_StockInvestments_Acct_Num1)){ echo $drstocksinvestments->Client_StockInvestments_Acct_Num1; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_StockInvestments_Date_Marriage_Value1">Marriage Date Value?</label>
                                    <input id="Client_StockInvestments_Date_Marriage_Value1" type="number" class="form-control 1_Client_stocksinvestments_inputs" name="Client_StockInvestments_Date_Marriage_Value1" value="<?php if(isset($drstocksinvestments->Client_StockInvestments_Date_Marriage_Value1)){ echo $drstocksinvestments->Client_StockInvestments_Date_Marriage_Value1; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_StockInvestments_Current_Value1">Current Value?</label>
                                    <input id="Client_StockInvestments_Current_Value1" type="number" class="form-control 1_Client_stocksinvestments_inputs" name="Client_StockInvestments_Current_Value1" value="<?php if(isset($drstocksinvestments->Client_StockInvestments_Current_Value1)){ echo $drstocksinvestments->Client_StockInvestments_Current_Value1; } ?>" min="0.00" step="0.01" max="999999.99" onchange="getJointCurrentValue(this, '1', 'Client');" onkeyup="getJointCurrentValue(this, '1', 'Client');"> 
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label for="Client_StockInvestments_Percent_Marital_Equity1">N/A, calculated = Client_StockInvestments_Institution_Current_Value1</label>
                                    <input id="Client_StockInvestments_Percent_Marital_Equity1" type="number" class="form-control 1_Client_stocksinvestments_inputs" name="Client_StockInvestments_Percent_Marital_Equity1" value="<?php if(isset($drstocksinvestments->Client_StockInvestments_Percent_Marital_Equity1)){ echo $drstocksinvestments->Client_StockInvestments_Percent_Marital_Equity1; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_StockInvestments_Yearly_Interest_Dividend1">Yearly Interest and Dividends from this account?</label>
                                    <input id="Client_StockInvestments_Yearly_Interest_Dividend1" type="number" class="form-control 1_Client_stocksinvestments_inputs" name="Client_StockInvestments_Yearly_Interest_Dividend1" value="<?php if(isset($drstocksinvestments->Client_StockInvestments_Yearly_Interest_Dividend1)){ echo $drstocksinvestments->Client_StockInvestments_Yearly_Interest_Dividend1; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Does either party claim a sole/separate interest from the other on this account?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Client_StockInvestments_SoleSeparate_Claim1_Yes" name="Client_StockInvestments_SoleSeparate_Claim1" value="Yes" data-onload="getInitialPartyClaimSoleSeparate(this, '1', 'Client');" onchange="getPartyClaimSoleSeparate(this, '1', 'Client');" <?php if(isset($drstocksinvestments->Client_StockInvestments_SoleSeparate_Claim1) && $drstocksinvestments->Client_StockInvestments_SoleSeparate_Claim1=='Yes'){ echo "checked"; } ?>> Yes</label>
                                        <label><input type="radio" id="Client_StockInvestments_SoleSeparate_Claim1_No" name="Client_StockInvestments_SoleSeparate_Claim1" value="No" data-onload="getInitialPartyClaimSoleSeparate(this, '1', 'Client');" onchange="getPartyClaimSoleSeparate(this, '1', 'Client');" <?php if(isset($drstocksinvestments->Client_StockInvestments_SoleSeparate_Claim1) && $drstocksinvestments->Client_StockInvestments_SoleSeparate_Claim1=='No'){ echo "checked"; } ?>> No</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6" id="Client_StockInvestments_SoleSeparate_Party1_Div" style="display: none;">
                                    <label>Who claims to own this account?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Client_StockInvestments_SoleSeparate_Party1_Client" name="Client_StockInvestments_SoleSeparate_Party1" value="{{$client_name}}" <?php if(isset($drstocksinvestments->Client_StockInvestments_SoleSeparate_Party1) && $drstocksinvestments->Client_StockInvestments_SoleSeparate_Party1==$client_name){ echo "checked"; } ?>> {{$client_name}}</label>
                                        <label><input type="radio" id="Client_StockInvestments_SoleSeparate_Party1_Op" name="Client_StockInvestments_SoleSeparate_Party1" value="{{$opponent_name}}" <?php if(isset($drstocksinvestments->Client_StockInvestments_SoleSeparate_Party1) && $drstocksinvestments->Client_StockInvestments_SoleSeparate_Party1==$opponent_name){ echo "checked"; } ?>> {{$opponent_name}}</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 left-clear" id="Client_StockInvestments_SoleSeparate_Grounds1_Div" style="display: none; clear: left;">
                                    <label for="Client_StockInvestments_SoleSeparate_Grounds1">Why does this person own this account solely and separately?</label>
                                    <input id="Client_StockInvestments_SoleSeparate_Grounds1" type="text" class="form-control 1_Client_stocksinvestments_inputs" name="Client_StockInvestments_SoleSeparate_Grounds1" value="<?php if(isset($drstocksinvestments->Client_StockInvestments_SoleSeparate_Grounds1)){ echo $drstocksinvestments->Client_StockInvestments_SoleSeparate_Grounds1; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>How will this account value be distributed between the parties?</label>
                                    <div class="w-100 dataInput">
                                        <label><input type="radio" id="Client_StockInvestments_Disposition_Method1_Distribute_Investments" name="Client_StockInvestments_Disposition_Method1" value="Distribute Investments" data-onload="getInitialDipositionMethod(this, '1', 'Client');" onchange="getDipositionMethod(this, '1', 'Client');" <?php if(isset($drstocksinvestments->Client_StockInvestments_Disposition_Method1) && $drstocksinvestments->Client_StockInvestments_Disposition_Method1=='Distribute Investments'){ echo "checked"; } ?>> Distribute Investments</label>
                                        <label><input type="radio" id="Client_StockInvestments_Disposition_Method1_Liquidate_Split_Net_Value" name="Client_StockInvestments_Disposition_Method1" value="Liquidate/Split Net Value" data-onload="getInitialDipositionMethod(this, '1', 'Client');" onchange="getDipositionMethod(this, '1', 'Client');" <?php if(isset($drstocksinvestments->Client_StockInvestments_Disposition_Method1) && $drstocksinvestments->Client_StockInvestments_Disposition_Method1=='Liquidate/Split Net Value'){ echo "checked"; } ?>> Liquidate/Split Net Value</label>
                                        <label><input type="radio" id="Client_StockInvestments_Disposition_Method1_Percentage_Buyout" name="Client_StockInvestments_Disposition_Method1" value="Percentage Buyout" data-onload="getInitialDipositionMethod(this, '1', 'Client');" onchange="getDipositionMethod(this, '1', 'Client');" <?php if(isset($drstocksinvestments->Client_StockInvestments_Disposition_Method1) && $drstocksinvestments->Client_StockInvestments_Disposition_Method1=='Percentage Buyout'){ echo "checked"; } ?>> Percentage Buyout</label>
                                        <label><input type="radio" id="Client_StockInvestments_Disposition_Method1_Fixed Buyout" name="Client_StockInvestments_Disposition_Method1" value="Fixed Buyout" data-onload="getInitialDipositionMethod(this, '1', 'Client');" onchange="getDipositionMethod(this, '1', 'Client');" <?php if(isset($drstocksinvestments->Client_StockInvestments_Disposition_Method1) && $drstocksinvestments->Client_StockInvestments_Disposition_Method1=='Fixed Buyout'){ echo "checked"; } ?>> Fixed Buyout</label>
                                    </div>
                                </div>
                                <!-- slider tool -->
                                <div class="form-group col-sm-6 m-auto 1_Client_Slider_Tool slider-tool-main">
                                    <div class="row">
                                        <div class="col">{{$client_name}}</div>
                                        <div class="col text-right">{{$opponent_name}}</div>
                                    </div>
                                    <input id="1_Client_balance_range_selector" type="range" class="form-control slider-tool-input 1_Client_balance_range_selector" name="" value="<?php if(isset($drstocksinvestments->Client_StockInvestments_Percent_Marital_Equity_to_Op1)){ echo $drstocksinvestments->Client_StockInvestments_Percent_Marital_Equity_to_Op1; } ?>" min="0.00" step="0.01" max="100" onchange="updateBalanceInput(this.value, '1', 'Client');">
                                </div>
                                <div class="form-group col-sm-6 m-auto 1_Client_Slider_Tool slider-tool-main">
                                    <div class="row justify-content-between">
                                        <div class="col selectorTool">
                                            <div class="left-col">
                                                <div class="client-info 1_Client_clientpercentage_div clientpercentage_div">
                                                    <?php if(isset($drstocksinvestments->Client_StockInvestments_Percent_Marital_Equity_to_Client1)){ echo $drstocksinvestments->Client_StockInvestments_Percent_Marital_Equity_to_Client1; } else {
                                                        echo "50.00";
                                                    } ?>%
                                                </div>
                                                <div class="client-info 1_Client_clientamount_div clientamount_div" style="clear: both;">
                                                    $<?php if(isset($drstocksinvestments->Client_StockInvestments_Estimated_Value_to_Client1)){ echo $drstocksinvestments->Client_StockInvestments_Estimated_Value_to_Client1; }else {
                                                        echo "0.00";
                                                    } ?>
                                                </div>
                                            </div>
                                            <label>To {{$client_name}}</label>
                                        </div>                                       
                                        <div class="col selectorTool selectorToolRight">
                                            <label>To {{$opponent_name}}</label>
                                            <div class="left-col right-col">
                                                <div class="client-info 1_Client_opponentpercentage_div opponentpercentage_div">
                                                    <?php if(isset($drstocksinvestments->Client_StockInvestments_Percent_Marital_Equity_to_Op1)){ echo $drstocksinvestments->Client_StockInvestments_Percent_Marital_Equity_to_Op1; } else {
                                                        echo "50.00";
                                                    } ?>%
                                                </div>
                                                <div class="client-info 1_Client_opponentamount_div opponentamount_div" style="clear: both;">
                                                    $<?php if(isset($drstocksinvestments->Client_StockInvestments_Estimated_Value_to_Op1)){ echo $drstocksinvestments->Client_StockInvestments_Estimated_Value_to_Op1; }else {
                                                        echo "0.00";
                                                    } ?>
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
                                         <label><input type="radio" id="Client_StockInvestments_Paying_Party1_Client" name="Client_StockInvestments_Paying_Party1" value="{{$client_name}}" data-onload="getInitialStockInvestmentPayingParty(this, '1', 'Client');" onchange="getStockInvestmentPayingParty(this, '1', 'Client');"  <?php if(isset($drstocksinvestments->Client_StockInvestments_Paying_Party1) && $drstocksinvestments->Client_StockInvestments_Paying_Party1==$client_name){ echo "checked"; } ?>> {{$client_name}}</label>
                                        <label><input type="radio" id="Client_StockInvestments_Paying_Party1_Op" name="Client_StockInvestments_Paying_Party1" value="{{$opponent_name}}" data-onload="getInitialStockInvestmentPayingParty(this, '1', 'Client');" onchange="getStockInvestmentPayingParty(this, '1', 'Client');"  <?php if(isset($drstocksinvestments->Client_StockInvestments_Paying_Party1) && $drstocksinvestments->Client_StockInvestments_Paying_Party1==$opponent_name){ echo "checked"; } ?>> {{$opponent_name}}</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 Client_StockInvestments_Paying_Party1_Inputs_Div" style="display: none;">
                                    <label>{{$client_name}} StockInvestment Equity Percent</label>
                                    <input id="Client_StockInvestments_Percent_Marital_Equity_to_Client1" type="number" class="form-control 1_Client_clientpercentage_input clientpercentage_input" name="Client_StockInvestments_Percent_Marital_Equity_to_Client1" value="<?php if(isset($drstocksinvestments->Client_StockInvestments_Percent_Marital_Equity_to_Client1)){ echo $drstocksinvestments->Client_StockInvestments_Percent_Marital_Equity_to_Client1; } ?>" min="0.00" step="0.01" max="100" readonly="">
                                </div>
                                <div class="form-group col-sm-6 Client_StockInvestments_Paying_Party1_Inputs_Div" style="display: none;">
                                    <label>How much is to be paid to {{$client_name}}?</label>
                                    <input id="Client_StockInvestments_Estimated_Value_to_Client1" type="number" class="form-control 1_Client_clientamount_input clientamount_input" name="Client_StockInvestments_Estimated_Value_to_Client1" value="<?php if(isset($drstocksinvestments->Client_StockInvestments_Estimated_Value_to_Client1)){ echo $drstocksinvestments->Client_StockInvestments_Estimated_Value_to_Client1; } ?>" min="0.00" step="0.01" max="999999.99" readonly="" onchange="getEstimatedValueClient(this, '1', 'Client');" onkeyup="getEstimatedValueClient(this, '1', 'Client');">
                                </div>
                                <div class="form-group col-sm-6 Client_StockInvestments_Paying_Party1_Inputs_Div" style="display: none;">
                                    <label>{{$opponent_name}} StockInvestment Equity Percent</label>
                                    <input id="Client_StockInvestments_Percent_Marital_Equity_to_Op1" type="number" class="form-control 1_Client_opponentpercentage_input opponentpercentage_input" name="Client_StockInvestments_Percent_Marital_Equity_to_Op1" value="<?php if(isset($drstocksinvestments->Client_StockInvestments_Percent_Marital_Equity_to_Op1)){ echo $drstocksinvestments->Client_StockInvestments_Percent_Marital_Equity_to_Op1; } ?>" min="0.00" step="0.01" max="100" readonly="">
                                </div>
                                <div class="form-group col-sm-6 Client_StockInvestments_Paying_Party1_Inputs_Div" style="display: none;">
                                    <label>How much is to be paid to {{$opponent_name}}?</label>
                                    <input id="Client_StockInvestments_Estimated_Value_to_Op1" type="number" class="form-control 1_Client_opponentamount_input opponentamount_input" name="Client_StockInvestments_Estimated_Value_to_Op1" value="<?php if(isset($drstocksinvestments->Client_StockInvestments_Estimated_Value_to_Op1)){ echo $drstocksinvestments->Client_StockInvestments_Estimated_Value_to_Op1; } ?>" min="0.00" step="0.01" max="999999.99" readonly="" onchange="getEstimatedValueOp(this, '1', 'Client');" onkeyup="getEstimatedValueOp(this, '1', 'Client');">
                                </div>
                                <!-- end of slider tool -->
                            </div>
                            <div class="col-sm-12 mt-4 2_Client_stocksinvestments_section" style="display: none;"><h5 class="col-sm-12">Second Stock Investment Info</h5>
                                <div class="form-group col-sm-6">
                                    <p class="text-danger 2_Client_no-state-county-found" style="display: none;">No City, State, County found for this zipcode.</p>
                                    <label for="Client_StockInvestments_Institution_ZIP2">Stock/Investment Institution Zip Code?</label>
                                    <input id="Client_StockInvestments_Institution_ZIP2" type="text" class="form-control 2_Client_stocksinvestments_inputs" name="Client_StockInvestments_Institution_ZIP2" value="<?php if(isset($drstocksinvestments->Client_StockInvestments_Institution_ZIP2)){ echo $drstocksinvestments->Client_StockInvestments_Institution_ZIP2; } ?>" data-onload="getCityStateForZip(this, '2', 'Client');" onkeyup="getCityStateForZip(this, '2', 'Client');"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_StockInvestments_Institution_Name2">Name of Stock/Investment Institution?</label>
                                    <input id="Client_StockInvestments_Institution_Name2" type="text" class="form-control 2_Client_stocksinvestments_inputs" name="Client_StockInvestments_Institution_Name2" value="<?php if(isset($drstocksinvestments->Client_StockInvestments_Institution_Name2)){ echo $drstocksinvestments->Client_StockInvestments_Institution_Name2; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_StockInvestments_Institution_Street_Address2">Stock/Investment Institution Street Address?</label>
                                    <input id="Client_StockInvestments_Institution_Street_Address2" type="text" class="form-control 2_Client_stocksinvestments_inputs" name="Client_StockInvestments_Institution_Street_Address2" value="<?php if(isset($drstocksinvestments->Client_StockInvestments_Institution_Street_Address2)){ echo $drstocksinvestments->Client_StockInvestments_Institution_Street_Address2; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_StockInvestments_Institution_City2">Stock/Investment Institution City?</label>
                                    <input type="hidden" name="" id="Client_StockInvestments_Institution_City2_Value" value="<?php if(isset($drstocksinvestments->Client_StockInvestments_Institution_City2)){ echo $drstocksinvestments->Client_StockInvestments_Institution_City2; } ?>">
                                    <select id="Client_StockInvestments_Institution_City2" name="Client_StockInvestments_Institution_City2" class="form-control 2_Client_city_select">
                                        <option value="">Choose City</option>
                                    </select>   
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_StockInvestments_Institution_State2">Stock/Investment Institution State?</label>
                                    <input type="hidden" name="" id="Client_StockInvestments_Institution_State2_Value" value="<?php if(isset($drstocksinvestments->Client_StockInvestments_Institution_State2)){ echo $drstocksinvestments->Client_StockInvestments_Institution_State2; } ?>">
                                    <select id="Client_StockInvestments_Institution_State2" name="Client_StockInvestments_Institution_State2" class="form-control 2_Client_state_select">
                                        <option value="">Choose State</option>
                                    </select>   
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_StockInvestments_Acct_Num2">Account Number?</label>
                                    <input id="Client_StockInvestments_Acct_Num2" type="text" class="form-control 2_Client_stocksinvestments_inputs" name="Client_StockInvestments_Acct_Num2" value="<?php if(isset($drstocksinvestments->Client_StockInvestments_Acct_Num2)){ echo $drstocksinvestments->Client_StockInvestments_Acct_Num2; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_StockInvestments_Date_Marriage_Value2">Marriage Date Value?</label>
                                    <input id="Client_StockInvestments_Date_Marriage_Value2" type="number" class="form-control 2_Client_stocksinvestments_inputs" name="Client_StockInvestments_Date_Marriage_Value2" value="<?php if(isset($drstocksinvestments->Client_StockInvestments_Date_Marriage_Value2)){ echo $drstocksinvestments->Client_StockInvestments_Date_Marriage_Value2; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_StockInvestments_Current_Value2">Current Value?</label>
                                    <input id="Client_StockInvestments_Current_Value2" type="number" class="form-control 2_Client_stocksinvestments_inputs" name="Client_StockInvestments_Current_Value2" value="<?php if(isset($drstocksinvestments->Client_StockInvestments_Current_Value2)){ echo $drstocksinvestments->Client_StockInvestments_Current_Value2; } ?>" min="0.00" step="0.01" max="999999.99" onchange="getJointCurrentValue(this, '2', 'Client');" onkeyup="getJointCurrentValue(this, '2', 'Client');"> 
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label for="Client_StockInvestments_Percent_Marital_Equity2">N/A, calculated = Client_StockInvestments_Institution_Current_Value2</label>
                                    <input id="Client_StockInvestments_Percent_Marital_Equity2" type="number" class="form-control 2_Client_stocksinvestments_inputs" name="Client_StockInvestments_Percent_Marital_Equity2" value="<?php if(isset($drstocksinvestments->Client_StockInvestments_Percent_Marital_Equity2)){ echo $drstocksinvestments->Client_StockInvestments_Percent_Marital_Equity2; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_StockInvestments_Yearly_Interest_Dividend2">Yearly Interest and Dividends from this account?</label>
                                    <input id="Client_StockInvestments_Yearly_Interest_Dividend2" type="number" class="form-control 2_Client_stocksinvestments_inputs" name="Client_StockInvestments_Yearly_Interest_Dividend2" value="<?php if(isset($drstocksinvestments->Client_StockInvestments_Yearly_Interest_Dividend2)){ echo $drstocksinvestments->Client_StockInvestments_Yearly_Interest_Dividend2; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Does either party claim a sole/separate interest from the other on this account?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Client_StockInvestments_SoleSeparate_Claim2_Yes" name="Client_StockInvestments_SoleSeparate_Claim2" value="Yes" data-onload="getInitialPartyClaimSoleSeparate(this, '2', 'Client');" onchange="getPartyClaimSoleSeparate(this, '2', 'Client');" <?php if(isset($drstocksinvestments->Client_StockInvestments_SoleSeparate_Claim2) && $drstocksinvestments->Client_StockInvestments_SoleSeparate_Claim2=='Yes'){ echo "checked"; } ?>> Yes</label>
                                        <label><input type="radio" id="Client_StockInvestments_SoleSeparate_Claim2_No" name="Client_StockInvestments_SoleSeparate_Claim2" value="No" data-onload="getInitialPartyClaimSoleSeparate(this, '2', 'Client');" onchange="getPartyClaimSoleSeparate(this, '2', 'Client');" <?php if(isset($drstocksinvestments->Client_StockInvestments_SoleSeparate_Claim2) && $drstocksinvestments->Client_StockInvestments_SoleSeparate_Claim2=='No'){ echo "checked"; } ?>> No</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6" id="Client_StockInvestments_SoleSeparate_Party2_Div" style="display: none;">
                                    <label>Who claims to own this account?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Client_StockInvestments_SoleSeparate_Party2_Client" name="Client_StockInvestments_SoleSeparate_Party2" value="{{$client_name}}" <?php if(isset($drstocksinvestments->Client_StockInvestments_SoleSeparate_Party2) && $drstocksinvestments->Client_StockInvestments_SoleSeparate_Party2==$client_name){ echo "checked"; } ?>> {{$client_name}}</label>
                                        <label><input type="radio" id="Client_StockInvestments_SoleSeparate_Party2_Op" name="Client_StockInvestments_SoleSeparate_Party2" value="{{$opponent_name}}" <?php if(isset($drstocksinvestments->Client_StockInvestments_SoleSeparate_Party2) && $drstocksinvestments->Client_StockInvestments_SoleSeparate_Party2==$opponent_name){ echo "checked"; } ?>> {{$opponent_name}}</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 left-clear" id="Client_StockInvestments_SoleSeparate_Grounds2_Div" style="display: none; clear: left;">
                                    <label for="Client_StockInvestments_SoleSeparate_Grounds2">Why does this person own this account solely and separately?</label>
                                    <input id="Client_StockInvestments_SoleSeparate_Grounds2" type="text" class="form-control 2_Client_stocksinvestments_inputs" name="Client_StockInvestments_SoleSeparate_Grounds2" value="<?php if(isset($drstocksinvestments->Client_StockInvestments_SoleSeparate_Grounds2)){ echo $drstocksinvestments->Client_StockInvestments_SoleSeparate_Grounds2; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>How will this account value be distributed between the parties?</label>
                                    <div class="w-100 dataInput">
                                        <label><input type="radio" id="Client_StockInvestments_Disposition_Method2_Distribute_Investments" name="Client_StockInvestments_Disposition_Method2" value="Distribute Investments" data-onload="getInitialDipositionMethod(this, '2', 'Client');" onchange="getDipositionMethod(this, '2', 'Client');" <?php if(isset($drstocksinvestments->Client_StockInvestments_Disposition_Method2) && $drstocksinvestments->Client_StockInvestments_Disposition_Method2=='Distribute Investments'){ echo "checked"; } ?>> Distribute Investments</label>
                                        <label><input type="radio" id="Client_StockInvestments_Disposition_Method2_Liquidate_Split_Net_Value" name="Client_StockInvestments_Disposition_Method2" value="Liquidate/Split Net Value" data-onload="getInitialDipositionMethod(this, '2', 'Client');" onchange="getDipositionMethod(this, '2', 'Client');" <?php if(isset($drstocksinvestments->Client_StockInvestments_Disposition_Method2) && $drstocksinvestments->Client_StockInvestments_Disposition_Method2=='Liquidate/Split Net Value'){ echo "checked"; } ?>> Liquidate/Split Net Value</label>
                                        <label><input type="radio" id="Client_StockInvestments_Disposition_Method2_Percentage_Buyout" name="Client_StockInvestments_Disposition_Method2" value="Percentage Buyout" data-onload="getInitialDipositionMethod(this, '2', 'Client');" onchange="getDipositionMethod(this, '2', 'Client');" <?php if(isset($drstocksinvestments->Client_StockInvestments_Disposition_Method2) && $drstocksinvestments->Client_StockInvestments_Disposition_Method2=='Percentage Buyout'){ echo "checked"; } ?>> Percentage Buyout</label>
                                        <label><input type="radio" id="Client_StockInvestments_Disposition_Method2_Fixed Buyout" name="Client_StockInvestments_Disposition_Method2" value="Fixed Buyout" data-onload="getInitialDipositionMethod(this, '2', 'Client');" onchange="getDipositionMethod(this, '2', 'Client');" <?php if(isset($drstocksinvestments->Client_StockInvestments_Disposition_Method2) && $drstocksinvestments->Client_StockInvestments_Disposition_Method2=='Fixed Buyout'){ echo "checked"; } ?>> Fixed Buyout</label>
                                    </div>
                                </div>
                                <!-- slider tool -->
                                <div class="form-group col-sm-6 m-auto 2_Client_Slider_Tool slider-tool-main">
                                    <div class="row">
                                        <div class="col">{{$client_name}}</div>
                                        <div class="col text-right">{{$opponent_name}}</div>
                                    </div>
                                    <input id="2_Client_balance_range_selector" type="range" class="form-control slider-tool-input 2_Client_balance_range_selector" name="" value="<?php if(isset($drstocksinvestments->Client_StockInvestments_Percent_Marital_Equity_to_Op2)){ echo $drstocksinvestments->Client_StockInvestments_Percent_Marital_Equity_to_Op2; } ?>" min="0.00" step="0.01" max="100" onchange="updateBalanceInput(this.value, '2', 'Client');">
                                </div>
                                <div class="form-group col-sm-6 m-auto 2_Client_Slider_Tool slider-tool-main">
                                    <div class="row justify-content-between">
                                        <div class="col selectorTool">
                                            <div class="left-col">
                                                <div class="client-info 2_Client_clientpercentage_div clientpercentage_div">
                                                    <?php if(isset($drstocksinvestments->Client_StockInvestments_Percent_Marital_Equity_to_Client2)){ echo $drstocksinvestments->Client_StockInvestments_Percent_Marital_Equity_to_Client2; } else {
                                                        echo "50.00";
                                                    } ?>%
                                                </div>
                                                <div class="client-info 2_Client_clientamount_div clientamount_div" style="clear: both;">
                                                    $<?php if(isset($drstocksinvestments->Client_StockInvestments_Estimated_Value_to_Client2)){ echo $drstocksinvestments->Client_StockInvestments_Estimated_Value_to_Client2; }else {
                                                        echo "0.00";
                                                    } ?>
                                                </div>
                                            </div>
                                            <label>To {{$client_name}}</label>
                                        </div>                                       
                                        <div class="col selectorTool selectorToolRight">
                                            <label>To {{$opponent_name}}</label>
                                            <div class="left-col right-col">
                                                <div class="client-info 2_Client_opponentpercentage_div opponentpercentage_div">
                                                    <?php if(isset($drstocksinvestments->Client_StockInvestments_Percent_Marital_Equity_to_Op2)){ echo $drstocksinvestments->Client_StockInvestments_Percent_Marital_Equity_to_Op2; } else {
                                                        echo "50.00";
                                                    } ?>%
                                                </div>
                                                <div class="client-info 2_Client_opponentamount_div opponentamount_div" style="clear: both;">
                                                    $<?php if(isset($drstocksinvestments->Client_StockInvestments_Estimated_Value_to_Op2)){ echo $drstocksinvestments->Client_StockInvestments_Estimated_Value_to_Op2; }else {
                                                        echo "0.00";
                                                    } ?>
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
                                         <label><input type="radio" id="Client_StockInvestments_Paying_Party2_Client" name="Client_StockInvestments_Paying_Party2" value="{{$client_name}}" data-onload="getInitialStockInvestmentPayingParty(this, '2', 'Client');" onchange="getStockInvestmentPayingParty(this, '2', 'Client');"  <?php if(isset($drstocksinvestments->Client_StockInvestments_Paying_Party2) && $drstocksinvestments->Client_StockInvestments_Paying_Party2==$client_name){ echo "checked"; } ?>> {{$client_name}}</label>
                                        <label><input type="radio" id="Client_StockInvestments_Paying_Party2_Op" name="Client_StockInvestments_Paying_Party2" value="{{$opponent_name}}" data-onload="getInitialStockInvestmentPayingParty(this, '2', 'Client');" onchange="getStockInvestmentPayingParty(this, '2', 'Client');"  <?php if(isset($drstocksinvestments->Client_StockInvestments_Paying_Party2) && $drstocksinvestments->Client_StockInvestments_Paying_Party2==$opponent_name){ echo "checked"; } ?>> {{$opponent_name}}</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 Client_StockInvestments_Paying_Party2_Inputs_Div" style="display: none;">
                                    <label>{{$client_name}} StockInvestment Equity Percent</label>
                                    <input id="Client_StockInvestments_Percent_Marital_Equity_to_Client2" type="number" class="form-control 2_Client_clientpercentage_input clientpercentage_input" name="Client_StockInvestments_Percent_Marital_Equity_to_Client2" value="<?php if(isset($drstocksinvestments->Client_StockInvestments_Percent_Marital_Equity_to_Client2)){ echo $drstocksinvestments->Client_StockInvestments_Percent_Marital_Equity_to_Client2; } ?>" min="0.00" step="0.01" max="100" readonly="">
                                </div>
                                <div class="form-group col-sm-6 Client_StockInvestments_Paying_Party2_Inputs_Div" style="display: none;">
                                    <label>How much is to be paid to {{$client_name}}?</label>
                                    <input id="Client_StockInvestments_Estimated_Value_to_Client2" type="number" class="form-control 2_Client_clientamount_input clientamount_input" name="Client_StockInvestments_Estimated_Value_to_Client2" value="<?php if(isset($drstocksinvestments->Client_StockInvestments_Estimated_Value_to_Client2)){ echo $drstocksinvestments->Client_StockInvestments_Estimated_Value_to_Client2; } ?>" min="0.00" step="0.01" max="999999.99" readonly="" onchange="getEstimatedValueClient(this, '2', 'Client');" onkeyup="getEstimatedValueClient(this, '2', 'Client');">
                                </div>
                                <div class="form-group col-sm-6 Client_StockInvestments_Paying_Party2_Inputs_Div" style="display: none;">
                                    <label>{{$opponent_name}} StockInvestment Equity Percent</label>
                                    <input id="Client_StockInvestments_Percent_Marital_Equity_to_Op2" type="number" class="form-control 2_Client_opponentpercentage_input opponentpercentage_input" name="Client_StockInvestments_Percent_Marital_Equity_to_Op2" value="<?php if(isset($drstocksinvestments->Client_StockInvestments_Percent_Marital_Equity_to_Op2)){ echo $drstocksinvestments->Client_StockInvestments_Percent_Marital_Equity_to_Op2; } ?>" min="0.00" step="0.01" max="100" readonly="">
                                </div>
                                <div class="form-group col-sm-6 Client_StockInvestments_Paying_Party2_Inputs_Div" style="display: none;">
                                    <label>How much is to be paid to {{$opponent_name}}?</label>
                                    <input id="Client_StockInvestments_Estimated_Value_to_Op2" type="number" class="form-control 2_Client_opponentamount_input opponentamount_input" name="Client_StockInvestments_Estimated_Value_to_Op2" value="<?php if(isset($drstocksinvestments->Client_StockInvestments_Estimated_Value_to_Op2)){ echo $drstocksinvestments->Client_StockInvestments_Estimated_Value_to_Op2; } ?>" min="0.00" step="0.01" max="999999.99" readonly="" onchange="getEstimatedValueOp(this, '2', 'Client');" onkeyup="getEstimatedValueOp(this, '2', 'Client');">
                                </div>
                                <!-- end of slider tool -->
                            </div>
                            <div class="col-sm-12 mt-4 3_Client_stocksinvestments_section" style="display: none;"><h5 class="col-sm-12">Third Stock Investment Info</h5>
                                <div class="form-group col-sm-6">
                                    <p class="text-danger 3_Client_no-state-county-found" style="display: none;">No City, State, County found for this zipcode.</p>
                                    <label for="Client_StockInvestments_Institution_ZIP3">Stock/Investment Institution Zip Code?</label>
                                    <input id="Client_StockInvestments_Institution_ZIP3" type="text" class="form-control 3_Client_stocksinvestments_inputs" name="Client_StockInvestments_Institution_ZIP3" value="<?php if(isset($drstocksinvestments->Client_StockInvestments_Institution_ZIP3)){ echo $drstocksinvestments->Client_StockInvestments_Institution_ZIP3; } ?>" data-onload="getCityStateForZip(this, '3', 'Client');" onkeyup="getCityStateForZip(this, '3', 'Client');"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_StockInvestments_Institution_Name3">Name of Stock/Investment Institution?</label>
                                    <input id="Client_StockInvestments_Institution_Name3" type="text" class="form-control 3_Client_stocksinvestments_inputs" name="Client_StockInvestments_Institution_Name3" value="<?php if(isset($drstocksinvestments->Client_StockInvestments_Institution_Name3)){ echo $drstocksinvestments->Client_StockInvestments_Institution_Name3; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_StockInvestments_Institution_Street_Address3">Stock/Investment Institution Street Address?</label>
                                    <input id="Client_StockInvestments_Institution_Street_Address3" type="text" class="form-control 3_Client_stocksinvestments_inputs" name="Client_StockInvestments_Institution_Street_Address3" value="<?php if(isset($drstocksinvestments->Client_StockInvestments_Institution_Street_Address3)){ echo $drstocksinvestments->Client_StockInvestments_Institution_Street_Address3; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_StockInvestments_Institution_City3">Stock/Investment Institution City?</label>
                                    <input type="hidden" name="" id="Client_StockInvestments_Institution_City3_Value" value="<?php if(isset($drstocksinvestments->Client_StockInvestments_Institution_City3)){ echo $drstocksinvestments->Client_StockInvestments_Institution_City3; } ?>">
                                    <select id="Client_StockInvestments_Institution_City3" name="Client_StockInvestments_Institution_City3" class="form-control 3_Client_city_select">
                                        <option value="">Choose City</option>
                                    </select>   
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_StockInvestments_Institution_State3">Stock/Investment Institution State?</label>
                                    <input type="hidden" name="" id="Client_StockInvestments_Institution_State3_Value" value="<?php if(isset($drstocksinvestments->Client_StockInvestments_Institution_State3)){ echo $drstocksinvestments->Client_StockInvestments_Institution_State3; } ?>">
                                    <select id="Client_StockInvestments_Institution_State3" name="Client_StockInvestments_Institution_State3" class="form-control 3_Client_state_select">
                                        <option value="">Choose State</option>
                                    </select>   
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_StockInvestments_Acct_Num3">Account Number?</label>
                                    <input id="Client_StockInvestments_Acct_Num3" type="text" class="form-control 3_Client_stocksinvestments_inputs" name="Client_StockInvestments_Acct_Num3" value="<?php if(isset($drstocksinvestments->Client_StockInvestments_Acct_Num3)){ echo $drstocksinvestments->Client_StockInvestments_Acct_Num3; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_StockInvestments_Date_Marriage_Value3">Marriage Date Value?</label>
                                    <input id="Client_StockInvestments_Date_Marriage_Value3" type="number" class="form-control 3_Client_stocksinvestments_inputs" name="Client_StockInvestments_Date_Marriage_Value3" value="<?php if(isset($drstocksinvestments->Client_StockInvestments_Date_Marriage_Value3)){ echo $drstocksinvestments->Client_StockInvestments_Date_Marriage_Value3; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_StockInvestments_Current_Value3">Current Value?</label>
                                    <input id="Client_StockInvestments_Current_Value3" type="number" class="form-control 3_Client_stocksinvestments_inputs" name="Client_StockInvestments_Current_Value3" value="<?php if(isset($drstocksinvestments->Client_StockInvestments_Current_Value3)){ echo $drstocksinvestments->Client_StockInvestments_Current_Value3; } ?>" min="0.00" step="0.01" max="999999.99" onchange="getJointCurrentValue(this, '3', 'Client');" onkeyup="getJointCurrentValue(this, '3', 'Client');"> 
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label for="Client_StockInvestments_Percent_Marital_Equity3">N/A, calculated = Client_StockInvestments_Institution_Current_Value3</label>
                                    <input id="Client_StockInvestments_Percent_Marital_Equity3" type="number" class="form-control 3_Client_stocksinvestments_inputs" name="Client_StockInvestments_Percent_Marital_Equity3" value="<?php if(isset($drstocksinvestments->Client_StockInvestments_Percent_Marital_Equity3)){ echo $drstocksinvestments->Client_StockInvestments_Percent_Marital_Equity3; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_StockInvestments_Yearly_Interest_Dividend3">Yearly Interest and Dividends from this account?</label>
                                    <input id="Client_StockInvestments_Yearly_Interest_Dividend3" type="number" class="form-control 3_Client_stocksinvestments_inputs" name="Client_StockInvestments_Yearly_Interest_Dividend3" value="<?php if(isset($drstocksinvestments->Client_StockInvestments_Yearly_Interest_Dividend3)){ echo $drstocksinvestments->Client_StockInvestments_Yearly_Interest_Dividend3; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Does either party claim a sole/separate interest from the other on this account?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Client_StockInvestments_SoleSeparate_Claim3_Yes" name="Client_StockInvestments_SoleSeparate_Claim3" value="Yes" data-onload="getInitialPartyClaimSoleSeparate(this, '3', 'Client');" onchange="getPartyClaimSoleSeparate(this, '3', 'Client');" <?php if(isset($drstocksinvestments->Client_StockInvestments_SoleSeparate_Claim3) && $drstocksinvestments->Client_StockInvestments_SoleSeparate_Claim3=='Yes'){ echo "checked"; } ?>> Yes</label>
                                        <label><input type="radio" id="Client_StockInvestments_SoleSeparate_Claim3_No" name="Client_StockInvestments_SoleSeparate_Claim3" value="No" data-onload="getInitialPartyClaimSoleSeparate(this, '3', 'Client');" onchange="getPartyClaimSoleSeparate(this, '3', 'Client');" <?php if(isset($drstocksinvestments->Client_StockInvestments_SoleSeparate_Claim3) && $drstocksinvestments->Client_StockInvestments_SoleSeparate_Claim3=='No'){ echo "checked"; } ?>> No</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6" id="Client_StockInvestments_SoleSeparate_Party3_Div" style="display: none;">
                                    <label>Who claims to own this account?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Client_StockInvestments_SoleSeparate_Party3_Client" name="Client_StockInvestments_SoleSeparate_Party3" value="{{$client_name}}" <?php if(isset($drstocksinvestments->Client_StockInvestments_SoleSeparate_Party3) && $drstocksinvestments->Client_StockInvestments_SoleSeparate_Party3==$client_name){ echo "checked"; } ?>> {{$client_name}}</label>
                                        <label><input type="radio" id="Client_StockInvestments_SoleSeparate_Party3_Op" name="Client_StockInvestments_SoleSeparate_Party3" value="{{$opponent_name}}" <?php if(isset($drstocksinvestments->Client_StockInvestments_SoleSeparate_Party3) && $drstocksinvestments->Client_StockInvestments_SoleSeparate_Party3==$opponent_name){ echo "checked"; } ?>> {{$opponent_name}}</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 left-clear" id="Client_StockInvestments_SoleSeparate_Grounds3_Div" style="display: none; clear: left;">
                                    <label for="Client_StockInvestments_SoleSeparate_Grounds3">Why does this person own this account solely and separately?</label>
                                    <input id="Client_StockInvestments_SoleSeparate_Grounds3" type="text" class="form-control 3_Client_stocksinvestments_inputs" name="Client_StockInvestments_SoleSeparate_Grounds3" value="<?php if(isset($drstocksinvestments->Client_StockInvestments_SoleSeparate_Grounds3)){ echo $drstocksinvestments->Client_StockInvestments_SoleSeparate_Grounds3; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>How will this account value be distributed between the parties?</label>
                                    <div class="w-100 dataInput">
                                        <label><input type="radio" id="Client_StockInvestments_Disposition_Method3_Distribute_Investments" name="Client_StockInvestments_Disposition_Method3" value="Distribute Investments" data-onload="getInitialDipositionMethod(this, '3', 'Client');" onchange="getDipositionMethod(this, '3', 'Client');" <?php if(isset($drstocksinvestments->Client_StockInvestments_Disposition_Method3) && $drstocksinvestments->Client_StockInvestments_Disposition_Method3=='Distribute Investments'){ echo "checked"; } ?>> Distribute Investments</label>
                                        <label><input type="radio" id="Client_StockInvestments_Disposition_Method3_Liquidate_Split_Net_Value" name="Client_StockInvestments_Disposition_Method3" value="Liquidate/Split Net Value" data-onload="getInitialDipositionMethod(this, '3', 'Client');" onchange="getDipositionMethod(this, '3', 'Client');" <?php if(isset($drstocksinvestments->Client_StockInvestments_Disposition_Method3) && $drstocksinvestments->Client_StockInvestments_Disposition_Method3=='Liquidate/Split Net Value'){ echo "checked"; } ?>> Liquidate/Split Net Value</label>
                                        <label><input type="radio" id="Client_StockInvestments_Disposition_Method3_Percentage_Buyout" name="Client_StockInvestments_Disposition_Method3" value="Percentage Buyout" data-onload="getInitialDipositionMethod(this, '3', 'Client');" onchange="getDipositionMethod(this, '3', 'Client');" <?php if(isset($drstocksinvestments->Client_StockInvestments_Disposition_Method3) && $drstocksinvestments->Client_StockInvestments_Disposition_Method3=='Percentage Buyout'){ echo "checked"; } ?>> Percentage Buyout</label>
                                        <label><input type="radio" id="Client_StockInvestments_Disposition_Method3_Fixed Buyout" name="Client_StockInvestments_Disposition_Method3" value="Fixed Buyout" data-onload="getInitialDipositionMethod(this, '3', 'Client');" onchange="getDipositionMethod(this, '3', 'Client');" <?php if(isset($drstocksinvestments->Client_StockInvestments_Disposition_Method3) && $drstocksinvestments->Client_StockInvestments_Disposition_Method3=='Fixed Buyout'){ echo "checked"; } ?>> Fixed Buyout</label>
                                    </div>
                                </div>
                                <!-- slider tool -->
                                <div class="form-group col-sm-6 m-auto 3_Client_Slider_Tool slider-tool-main">
                                    <div class="row">
                                        <div class="col">{{$client_name}}</div>
                                        <div class="col text-right">{{$opponent_name}}</div>
                                    </div>
                                    <input id="3_Client_balance_range_selector" type="range" class="form-control slider-tool-input 3_Client_balance_range_selector" name="" value="<?php if(isset($drstocksinvestments->Client_StockInvestments_Percent_Marital_Equity_to_Op3)){ echo $drstocksinvestments->Client_StockInvestments_Percent_Marital_Equity_to_Op3; } ?>" min="0.00" step="0.01" max="100" onchange="updateBalanceInput(this.value, '3', 'Client');">
                                </div>
                                <div class="form-group col-sm-6 m-auto 3_Client_Slider_Tool slider-tool-main">
                                    <div class="row justify-content-between">
                                        <div class="col selectorTool">
                                            <div class="left-col">
                                                <div class="client-info 3_Client_clientpercentage_div clientpercentage_div">
                                                    <?php if(isset($drstocksinvestments->Client_StockInvestments_Percent_Marital_Equity_to_Client3)){ echo $drstocksinvestments->Client_StockInvestments_Percent_Marital_Equity_to_Client3; } else {
                                                        echo "50.00";
                                                    } ?>%
                                                </div>
                                                <div class="client-info 3_Client_clientamount_div clientamount_div" style="clear: both;">
                                                    $<?php if(isset($drstocksinvestments->Client_StockInvestments_Estimated_Value_to_Client3)){ echo $drstocksinvestments->Client_StockInvestments_Estimated_Value_to_Client3; }else {
                                                        echo "0.00";
                                                    } ?>
                                                </div>
                                            </div>
                                            <label>To {{$client_name}}</label>
                                        </div>                                       
                                        <div class="col selectorTool selectorToolRight">
                                            <label>To {{$opponent_name}}</label>
                                            <div class="left-col right-col">
                                                <div class="client-info 3_Client_opponentpercentage_div opponentpercentage_div">
                                                    <?php if(isset($drstocksinvestments->Client_StockInvestments_Percent_Marital_Equity_to_Op3)){ echo $drstocksinvestments->Client_StockInvestments_Percent_Marital_Equity_to_Op3; } else {
                                                        echo "50.00";
                                                    } ?>%
                                                </div>
                                                <div class="client-info 3_Client_opponentamount_div opponentamount_div" style="clear: both;">
                                                    $<?php if(isset($drstocksinvestments->Client_StockInvestments_Estimated_Value_to_Op3)){ echo $drstocksinvestments->Client_StockInvestments_Estimated_Value_to_Op3; }else {
                                                        echo "0.00";
                                                    } ?>
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
                                         <label><input type="radio" id="Client_StockInvestments_Paying_Party3_Client" name="Client_StockInvestments_Paying_Party3" value="{{$client_name}}" data-onload="getInitialStockInvestmentPayingParty(this, '3', 'Client');" onchange="getStockInvestmentPayingParty(this, '3', 'Client');"  <?php if(isset($drstocksinvestments->Client_StockInvestments_Paying_Party3) && $drstocksinvestments->Client_StockInvestments_Paying_Party3==$client_name){ echo "checked"; } ?>> {{$client_name}}</label>
                                        <label><input type="radio" id="Client_StockInvestments_Paying_Party3_Op" name="Client_StockInvestments_Paying_Party3" value="{{$opponent_name}}" data-onload="getInitialStockInvestmentPayingParty(this, '3', 'Client');" onchange="getStockInvestmentPayingParty(this, '3', 'Client');"  <?php if(isset($drstocksinvestments->Client_StockInvestments_Paying_Party3) && $drstocksinvestments->Client_StockInvestments_Paying_Party3==$opponent_name){ echo "checked"; } ?>> {{$opponent_name}}</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 Client_StockInvestments_Paying_Party3_Inputs_Div" style="display: none;">
                                    <label>{{$client_name}} StockInvestment Equity Percent</label>
                                    <input id="Client_StockInvestments_Percent_Marital_Equity_to_Client3" type="number" class="form-control 3_Client_clientpercentage_input clientpercentage_input" name="Client_StockInvestments_Percent_Marital_Equity_to_Client3" value="<?php if(isset($drstocksinvestments->Client_StockInvestments_Percent_Marital_Equity_to_Client3)){ echo $drstocksinvestments->Client_StockInvestments_Percent_Marital_Equity_to_Client3; } ?>" min="0.00" step="0.01" max="100" readonly="">
                                </div>
                                <div class="form-group col-sm-6 Client_StockInvestments_Paying_Party3_Inputs_Div" style="display: none;">
                                    <label>How much is to be paid to {{$client_name}}?</label>
                                    <input id="Client_StockInvestments_Estimated_Value_to_Client3" type="number" class="form-control 3_Client_clientamount_input clientamount_input" name="Client_StockInvestments_Estimated_Value_to_Client3" value="<?php if(isset($drstocksinvestments->Client_StockInvestments_Estimated_Value_to_Client3)){ echo $drstocksinvestments->Client_StockInvestments_Estimated_Value_to_Client3; } ?>" min="0.00" step="0.01" max="999999.99" readonly="" onchange="getEstimatedValueClient(this, '3', 'Client');" onkeyup="getEstimatedValueClient(this, '3', 'Client');">
                                </div>
                                <div class="form-group col-sm-6 Client_StockInvestments_Paying_Party3_Inputs_Div" style="display: none;">
                                    <label>{{$opponent_name}} StockInvestment Equity Percent</label>
                                    <input id="Client_StockInvestments_Percent_Marital_Equity_to_Op3" type="number" class="form-control 3_Client_opponentpercentage_input opponentpercentage_input" name="Client_StockInvestments_Percent_Marital_Equity_to_Op3" value="<?php if(isset($drstocksinvestments->Client_StockInvestments_Percent_Marital_Equity_to_Op3)){ echo $drstocksinvestments->Client_StockInvestments_Percent_Marital_Equity_to_Op3; } ?>" min="0.00" step="0.01" max="100" readonly="">
                                </div>
                                <div class="form-group col-sm-6 Client_StockInvestments_Paying_Party3_Inputs_Div" style="display: none;">
                                    <label>How much is to be paid to {{$opponent_name}}?</label>
                                    <input id="Client_StockInvestments_Estimated_Value_to_Op3" type="number" class="form-control 3_Client_opponentamount_input opponentamount_input" name="Client_StockInvestments_Estimated_Value_to_Op3" value="<?php if(isset($drstocksinvestments->Client_StockInvestments_Estimated_Value_to_Op3)){ echo $drstocksinvestments->Client_StockInvestments_Estimated_Value_to_Op3; } ?>" min="0.00" step="0.01" max="999999.99" readonly="" onchange="getEstimatedValueOp(this, '3', 'Client');" onkeyup="getEstimatedValueOp(this, '3', 'Client');">
                                </div>
                                <!-- end of slider tool -->
                            </div>
                            <div class="col-sm-12 mt-4 4_Client_stocksinvestments_section" style="display: none;"><h5 class="col-sm-12">Fourth Stock Investment Info</h5>
                                <div class="form-group col-sm-6">
                                    <p class="text-danger 4_Client_no-state-county-found" style="display: none;">No City, State, County found for this zipcode.</p>
                                    <label for="Client_StockInvestments_Institution_ZIP4">Stock/Investment Institution Zip Code?</label>
                                    <input id="Client_StockInvestments_Institution_ZIP4" type="text" class="form-control 4_Client_stocksinvestments_inputs" name="Client_StockInvestments_Institution_ZIP4" value="<?php if(isset($drstocksinvestments->Client_StockInvestments_Institution_ZIP4)){ echo $drstocksinvestments->Client_StockInvestments_Institution_ZIP4; } ?>" data-onload="getCityStateForZip(this, '4', 'Client');" onkeyup="getCityStateForZip(this, '4', 'Client');"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_StockInvestments_Institution_Name4">Name of Stock/Investment Institution?</label>
                                    <input id="Client_StockInvestments_Institution_Name4" type="text" class="form-control 4_Client_stocksinvestments_inputs" name="Client_StockInvestments_Institution_Name4" value="<?php if(isset($drstocksinvestments->Client_StockInvestments_Institution_Name4)){ echo $drstocksinvestments->Client_StockInvestments_Institution_Name4; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_StockInvestments_Institution_Street_Address4">Stock/Investment Institution Street Address?</label>
                                    <input id="Client_StockInvestments_Institution_Street_Address4" type="text" class="form-control 4_Client_stocksinvestments_inputs" name="Client_StockInvestments_Institution_Street_Address4" value="<?php if(isset($drstocksinvestments->Client_StockInvestments_Institution_Street_Address4)){ echo $drstocksinvestments->Client_StockInvestments_Institution_Street_Address4; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_StockInvestments_Institution_City4">Stock/Investment Institution City?</label>
                                    <input type="hidden" name="" id="Client_StockInvestments_Institution_City4_Value" value="<?php if(isset($drstocksinvestments->Client_StockInvestments_Institution_City4)){ echo $drstocksinvestments->Client_StockInvestments_Institution_City4; } ?>">
                                    <select id="Client_StockInvestments_Institution_City4" name="Client_StockInvestments_Institution_City4" class="form-control 4_Client_city_select">
                                        <option value="">Choose City</option>
                                    </select>   
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_StockInvestments_Institution_State4">Stock/Investment Institution State?</label>
                                    <input type="hidden" name="" id="Client_StockInvestments_Institution_State4_Value" value="<?php if(isset($drstocksinvestments->Client_StockInvestments_Institution_State4)){ echo $drstocksinvestments->Client_StockInvestments_Institution_State4; } ?>">
                                    <select id="Client_StockInvestments_Institution_State4" name="Client_StockInvestments_Institution_State4" class="form-control 4_Client_state_select">
                                        <option value="">Choose State</option>
                                    </select>   
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_StockInvestments_Acct_Num4">Account Number?</label>
                                    <input id="Client_StockInvestments_Acct_Num4" type="text" class="form-control 4_Client_stocksinvestments_inputs" name="Client_StockInvestments_Acct_Num4" value="<?php if(isset($drstocksinvestments->Client_StockInvestments_Acct_Num4)){ echo $drstocksinvestments->Client_StockInvestments_Acct_Num4; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_StockInvestments_Date_Marriage_Value4">Marriage Date Value?</label>
                                    <input id="Client_StockInvestments_Date_Marriage_Value4" type="number" class="form-control 4_Client_stocksinvestments_inputs" name="Client_StockInvestments_Date_Marriage_Value4" value="<?php if(isset($drstocksinvestments->Client_StockInvestments_Date_Marriage_Value4)){ echo $drstocksinvestments->Client_StockInvestments_Date_Marriage_Value4; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_StockInvestments_Current_Value4">Current Value?</label>
                                    <input id="Client_StockInvestments_Current_Value4" type="number" class="form-control 4_Client_stocksinvestments_inputs" name="Client_StockInvestments_Current_Value4" value="<?php if(isset($drstocksinvestments->Client_StockInvestments_Current_Value4)){ echo $drstocksinvestments->Client_StockInvestments_Current_Value4; } ?>" min="0.00" step="0.01" max="999999.99" onchange="getJointCurrentValue(this, '4', 'Client');" onkeyup="getJointCurrentValue(this, '4', 'Client');"> 
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label for="Client_StockInvestments_Percent_Marital_Equity4">N/A, calculated = Client_StockInvestments_Institution_Current_Value4</label>
                                    <input id="Client_StockInvestments_Percent_Marital_Equity4" type="number" class="form-control 4_Client_stocksinvestments_inputs" name="Client_StockInvestments_Percent_Marital_Equity4" value="<?php if(isset($drstocksinvestments->Client_StockInvestments_Percent_Marital_Equity4)){ echo $drstocksinvestments->Client_StockInvestments_Percent_Marital_Equity4; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_StockInvestments_Yearly_Interest_Dividend4">Yearly Interest and Dividends from this account?</label>
                                    <input id="Client_StockInvestments_Yearly_Interest_Dividend4" type="number" class="form-control 4_Client_stocksinvestments_inputs" name="Client_StockInvestments_Yearly_Interest_Dividend4" value="<?php if(isset($drstocksinvestments->Client_StockInvestments_Yearly_Interest_Dividend4)){ echo $drstocksinvestments->Client_StockInvestments_Yearly_Interest_Dividend4; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Does either party claim a sole/separate interest from the other on this account?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Client_StockInvestments_SoleSeparate_Claim4_Yes" name="Client_StockInvestments_SoleSeparate_Claim4" value="Yes" data-onload="getInitialPartyClaimSoleSeparate(this, '4', 'Client');" onchange="getPartyClaimSoleSeparate(this, '4', 'Client');" <?php if(isset($drstocksinvestments->Client_StockInvestments_SoleSeparate_Claim4) && $drstocksinvestments->Client_StockInvestments_SoleSeparate_Claim4=='Yes'){ echo "checked"; } ?>> Yes</label>
                                        <label><input type="radio" id="Client_StockInvestments_SoleSeparate_Claim4_No" name="Client_StockInvestments_SoleSeparate_Claim4" value="No" data-onload="getInitialPartyClaimSoleSeparate(this, '4', 'Client');" onchange="getPartyClaimSoleSeparate(this, '4', 'Client');" <?php if(isset($drstocksinvestments->Client_StockInvestments_SoleSeparate_Claim4) && $drstocksinvestments->Client_StockInvestments_SoleSeparate_Claim4=='No'){ echo "checked"; } ?>> No</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6" id="Client_StockInvestments_SoleSeparate_Party4_Div" style="display: none;">
                                    <label>Who claims to own this account?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Client_StockInvestments_SoleSeparate_Party4_Client" name="Client_StockInvestments_SoleSeparate_Party4" value="{{$client_name}}" <?php if(isset($drstocksinvestments->Client_StockInvestments_SoleSeparate_Party4) && $drstocksinvestments->Client_StockInvestments_SoleSeparate_Party4==$client_name){ echo "checked"; } ?>> {{$client_name}}</label>
                                        <label><input type="radio" id="Client_StockInvestments_SoleSeparate_Party4_Op" name="Client_StockInvestments_SoleSeparate_Party4" value="{{$opponent_name}}" <?php if(isset($drstocksinvestments->Client_StockInvestments_SoleSeparate_Party4) && $drstocksinvestments->Client_StockInvestments_SoleSeparate_Party4==$opponent_name){ echo "checked"; } ?>> {{$opponent_name}}</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 left-clear" id="Client_StockInvestments_SoleSeparate_Grounds4_Div" style="display: none; clear: left;">
                                    <label for="Client_StockInvestments_SoleSeparate_Grounds4">Why does this person own this account solely and separately?</label>
                                    <input id="Client_StockInvestments_SoleSeparate_Grounds4" type="text" class="form-control 4_Client_stocksinvestments_inputs" name="Client_StockInvestments_SoleSeparate_Grounds4" value="<?php if(isset($drstocksinvestments->Client_StockInvestments_SoleSeparate_Grounds4)){ echo $drstocksinvestments->Client_StockInvestments_SoleSeparate_Grounds4; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>How will this account value be distributed between the parties?</label>
                                    <div class="w-100 dataInput">
                                        <label><input type="radio" id="Client_StockInvestments_Disposition_Method4_Distribute_Investments" name="Client_StockInvestments_Disposition_Method4" value="Distribute Investments" data-onload="getInitialDipositionMethod(this, '4', 'Client');" onchange="getDipositionMethod(this, '4', 'Client');" <?php if(isset($drstocksinvestments->Client_StockInvestments_Disposition_Method4) && $drstocksinvestments->Client_StockInvestments_Disposition_Method4=='Distribute Investments'){ echo "checked"; } ?>> Distribute Investments</label>
                                        <label><input type="radio" id="Client_StockInvestments_Disposition_Method4_Liquidate_Split_Net_Value" name="Client_StockInvestments_Disposition_Method4" value="Liquidate/Split Net Value" data-onload="getInitialDipositionMethod(this, '4', 'Client');" onchange="getDipositionMethod(this, '4', 'Client');" <?php if(isset($drstocksinvestments->Client_StockInvestments_Disposition_Method4) && $drstocksinvestments->Client_StockInvestments_Disposition_Method4=='Liquidate/Split Net Value'){ echo "checked"; } ?>> Liquidate/Split Net Value</label>
                                        <label><input type="radio" id="Client_StockInvestments_Disposition_Method4_Percentage_Buyout" name="Client_StockInvestments_Disposition_Method4" value="Percentage Buyout" data-onload="getInitialDipositionMethod(this, '4', 'Client');" onchange="getDipositionMethod(this, '4', 'Client');" <?php if(isset($drstocksinvestments->Client_StockInvestments_Disposition_Method4) && $drstocksinvestments->Client_StockInvestments_Disposition_Method4=='Percentage Buyout'){ echo "checked"; } ?>> Percentage Buyout</label>
                                        <label><input type="radio" id="Client_StockInvestments_Disposition_Method4_Fixed Buyout" name="Client_StockInvestments_Disposition_Method4" value="Fixed Buyout" data-onload="getInitialDipositionMethod(this, '4', 'Client');" onchange="getDipositionMethod(this, '4', 'Client');" <?php if(isset($drstocksinvestments->Client_StockInvestments_Disposition_Method4) && $drstocksinvestments->Client_StockInvestments_Disposition_Method4=='Fixed Buyout'){ echo "checked"; } ?>> Fixed Buyout</label>
                                    </div>
                                </div>
                                <!-- slider tool -->
                                <div class="form-group col-sm-6 m-auto 4_Client_Slider_Tool slider-tool-main">
                                    <div class="row">
                                        <div class="col">{{$client_name}}</div>
                                        <div class="col text-right">{{$opponent_name}}</div>
                                    </div>
                                    <input id="4_Client_balance_range_selector" type="range" class="form-control slider-tool-input 4_Client_balance_range_selector" name="" value="<?php if(isset($drstocksinvestments->Client_StockInvestments_Percent_Marital_Equity_to_Op4)){ echo $drstocksinvestments->Client_StockInvestments_Percent_Marital_Equity_to_Op4; } ?>" min="0.00" step="0.01" max="100" onchange="updateBalanceInput(this.value, '4', 'Client');">
                                </div>
                                <div class="form-group col-sm-6 m-auto 4_Client_Slider_Tool slider-tool-main">
                                    <div class="row justify-content-between">
                                        <div class="col selectorTool">
                                            <div class="left-col">
                                                <div class="client-info 4_Client_clientpercentage_div clientpercentage_div">
                                                    <?php if(isset($drstocksinvestments->Client_StockInvestments_Percent_Marital_Equity_to_Client4)){ echo $drstocksinvestments->Client_StockInvestments_Percent_Marital_Equity_to_Client4; } else {
                                                        echo "50.00";
                                                    } ?>%
                                                </div>
                                                <div class="client-info 4_Client_clientamount_div clientamount_div" style="clear: both;">
                                                    $<?php if(isset($drstocksinvestments->Client_StockInvestments_Estimated_Value_to_Client4)){ echo $drstocksinvestments->Client_StockInvestments_Estimated_Value_to_Client4; }else {
                                                        echo "0.00";
                                                    } ?>
                                                </div>
                                            </div>
                                            <label>To {{$client_name}}</label>
                                        </div>                                       
                                        <div class="col selectorTool selectorToolRight">
                                            <label>To {{$opponent_name}}</label>
                                            <div class="left-col right-col">
                                                <div class="client-info 4_Client_opponentpercentage_div opponentpercentage_div">
                                                    <?php if(isset($drstocksinvestments->Client_StockInvestments_Percent_Marital_Equity_to_Op4)){ echo $drstocksinvestments->Client_StockInvestments_Percent_Marital_Equity_to_Op4; } else {
                                                        echo "50.00";
                                                    } ?>%
                                                </div>
                                                <div class="client-info 4_Client_opponentamount_div opponentamount_div" style="clear: both;">
                                                    $<?php if(isset($drstocksinvestments->Client_StockInvestments_Estimated_Value_to_Op4)){ echo $drstocksinvestments->Client_StockInvestments_Estimated_Value_to_Op4; }else {
                                                        echo "0.00";
                                                    } ?>
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
                                         <label><input type="radio" id="Client_StockInvestments_Paying_Party4_Client" name="Client_StockInvestments_Paying_Party4" value="{{$client_name}}" data-onload="getInitialStockInvestmentPayingParty(this, '4', 'Client');" onchange="getStockInvestmentPayingParty(this, '4', 'Client');"  <?php if(isset($drstocksinvestments->Client_StockInvestments_Paying_Party4) && $drstocksinvestments->Client_StockInvestments_Paying_Party4==$client_name){ echo "checked"; } ?>> {{$client_name}}</label>
                                        <label><input type="radio" id="Client_StockInvestments_Paying_Party4_Op" name="Client_StockInvestments_Paying_Party4" value="{{$opponent_name}}" data-onload="getInitialStockInvestmentPayingParty(this, '4', 'Client');" onchange="getStockInvestmentPayingParty(this, '4', 'Client');"  <?php if(isset($drstocksinvestments->Client_StockInvestments_Paying_Party4) && $drstocksinvestments->Client_StockInvestments_Paying_Party4==$opponent_name){ echo "checked"; } ?>> {{$opponent_name}}</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 Client_StockInvestments_Paying_Party4_Inputs_Div" style="display: none;">
                                    <label>{{$client_name}} StockInvestment Equity Percent</label>
                                    <input id="Client_StockInvestments_Percent_Marital_Equity_to_Client4" type="number" class="form-control 4_Client_clientpercentage_input clientpercentage_input" name="Client_StockInvestments_Percent_Marital_Equity_to_Client4" value="<?php if(isset($drstocksinvestments->Client_StockInvestments_Percent_Marital_Equity_to_Client4)){ echo $drstocksinvestments->Client_StockInvestments_Percent_Marital_Equity_to_Client4; } ?>" min="0.00" step="0.01" max="100" readonly="">
                                </div>
                                <div class="form-group col-sm-6 Client_StockInvestments_Paying_Party4_Inputs_Div" style="display: none;">
                                    <label>How much is to be paid to {{$client_name}}?</label>
                                    <input id="Client_StockInvestments_Estimated_Value_to_Client4" type="number" class="form-control 4_Client_clientamount_input clientamount_input" name="Client_StockInvestments_Estimated_Value_to_Client4" value="<?php if(isset($drstocksinvestments->Client_StockInvestments_Estimated_Value_to_Client4)){ echo $drstocksinvestments->Client_StockInvestments_Estimated_Value_to_Client4; } ?>" min="0.00" step="0.01" max="999999.99" readonly="" onchange="getEstimatedValueClient(this, '4', 'Client');" onkeyup="getEstimatedValueClient(this, '4', 'Client');">
                                </div>
                                <div class="form-group col-sm-6 Client_StockInvestments_Paying_Party4_Inputs_Div" style="display: none;">
                                    <label>{{$opponent_name}} StockInvestment Equity Percent</label>
                                    <input id="Client_StockInvestments_Percent_Marital_Equity_to_Op4" type="number" class="form-control 4_Client_opponentpercentage_input opponentpercentage_input" name="Client_StockInvestments_Percent_Marital_Equity_to_Op4" value="<?php if(isset($drstocksinvestments->Client_StockInvestments_Percent_Marital_Equity_to_Op4)){ echo $drstocksinvestments->Client_StockInvestments_Percent_Marital_Equity_to_Op4; } ?>" min="0.00" step="0.01" max="100" readonly="">
                                </div>
                                <div class="form-group col-sm-6 Client_StockInvestments_Paying_Party4_Inputs_Div" style="display: none;">
                                    <label>How much is to be paid to {{$opponent_name}}?</label>
                                    <input id="Client_StockInvestments_Estimated_Value_to_Op4" type="number" class="form-control 4_Client_opponentamount_input opponentamount_input" name="Client_StockInvestments_Estimated_Value_to_Op4" value="<?php if(isset($drstocksinvestments->Client_StockInvestments_Estimated_Value_to_Op4)){ echo $drstocksinvestments->Client_StockInvestments_Estimated_Value_to_Op4; } ?>" min="0.00" step="0.01" max="999999.99" readonly="" onchange="getEstimatedValueOp(this, '4', 'Client');" onkeyup="getEstimatedValueOp(this, '4', 'Client');">
                                </div>
                                <!-- end of slider tool -->
                            </div>
                            <div class="col-sm-12 mt-4 5_Client_stocksinvestments_section" style="display: none;"><h5 class="col-sm-12">Fifth Stock Investment Info</h5>
                                <div class="form-group col-sm-6">
                                    <p class="text-danger 5_Client_no-state-county-found" style="display: none;">No City, State, County found for this zipcode.</p>
                                    <label for="Client_StockInvestments_Institution_ZIP5">Stock/Investment Institution Zip Code?</label>
                                    <input id="Client_StockInvestments_Institution_ZIP5" type="text" class="form-control 5_Client_stocksinvestments_inputs" name="Client_StockInvestments_Institution_ZIP5" value="<?php if(isset($drstocksinvestments->Client_StockInvestments_Institution_ZIP5)){ echo $drstocksinvestments->Client_StockInvestments_Institution_ZIP5; } ?>" data-onload="getCityStateForZip(this, '5', 'Client');" onkeyup="getCityStateForZip(this, '5', 'Client');"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_StockInvestments_Institution_Name5">Name of Stock/Investment Institution?</label>
                                    <input id="Client_StockInvestments_Institution_Name5" type="text" class="form-control 5_Client_stocksinvestments_inputs" name="Client_StockInvestments_Institution_Name5" value="<?php if(isset($drstocksinvestments->Client_StockInvestments_Institution_Name5)){ echo $drstocksinvestments->Client_StockInvestments_Institution_Name5; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_StockInvestments_Institution_Street_Address5">Stock/Investment Institution Street Address?</label>
                                    <input id="Client_StockInvestments_Institution_Street_Address5" type="text" class="form-control 5_Client_stocksinvestments_inputs" name="Client_StockInvestments_Institution_Street_Address5" value="<?php if(isset($drstocksinvestments->Client_StockInvestments_Institution_Street_Address5)){ echo $drstocksinvestments->Client_StockInvestments_Institution_Street_Address5; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_StockInvestments_Institution_City5">Stock/Investment Institution City?</label>
                                    <input type="hidden" name="" id="Client_StockInvestments_Institution_City5_Value" value="<?php if(isset($drstocksinvestments->Client_StockInvestments_Institution_City5)){ echo $drstocksinvestments->Client_StockInvestments_Institution_City5; } ?>">
                                    <select id="Client_StockInvestments_Institution_City5" name="Client_StockInvestments_Institution_City5" class="form-control 5_Client_city_select">
                                        <option value="">Choose City</option>
                                    </select>   
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_StockInvestments_Institution_State5">Stock/Investment Institution State?</label>
                                    <input type="hidden" name="" id="Client_StockInvestments_Institution_State5_Value" value="<?php if(isset($drstocksinvestments->Client_StockInvestments_Institution_State5)){ echo $drstocksinvestments->Client_StockInvestments_Institution_State5; } ?>">
                                    <select id="Client_StockInvestments_Institution_State5" name="Client_StockInvestments_Institution_State5" class="form-control 5_Client_state_select">
                                        <option value="">Choose State</option>
                                    </select>   
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_StockInvestments_Acct_Num5">Account Number?</label>
                                    <input id="Client_StockInvestments_Acct_Num5" type="text" class="form-control 5_Client_stocksinvestments_inputs" name="Client_StockInvestments_Acct_Num5" value="<?php if(isset($drstocksinvestments->Client_StockInvestments_Acct_Num5)){ echo $drstocksinvestments->Client_StockInvestments_Acct_Num5; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_StockInvestments_Date_Marriage_Value5">Marriage Date Value?</label>
                                    <input id="Client_StockInvestments_Date_Marriage_Value5" type="number" class="form-control 5_Client_stocksinvestments_inputs" name="Client_StockInvestments_Date_Marriage_Value5" value="<?php if(isset($drstocksinvestments->Client_StockInvestments_Date_Marriage_Value5)){ echo $drstocksinvestments->Client_StockInvestments_Date_Marriage_Value5; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_StockInvestments_Current_Value5">Current Value?</label>
                                    <input id="Client_StockInvestments_Current_Value5" type="number" class="form-control 5_Client_stocksinvestments_inputs" name="Client_StockInvestments_Current_Value5" value="<?php if(isset($drstocksinvestments->Client_StockInvestments_Current_Value5)){ echo $drstocksinvestments->Client_StockInvestments_Current_Value5; } ?>" min="0.00" step="0.01" max="999999.99" onchange="getJointCurrentValue(this, '5', 'Client');" onkeyup="getJointCurrentValue(this, '5', 'Client');"> 
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label for="Client_StockInvestments_Percent_Marital_Equity5">N/A, calculated = Client_StockInvestments_Institution_Current_Value5</label>
                                    <input id="Client_StockInvestments_Percent_Marital_Equity5" type="number" class="form-control 5_Client_stocksinvestments_inputs" name="Client_StockInvestments_Percent_Marital_Equity5" value="<?php if(isset($drstocksinvestments->Client_StockInvestments_Percent_Marital_Equity5)){ echo $drstocksinvestments->Client_StockInvestments_Percent_Marital_Equity5; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_StockInvestments_Yearly_Interest_Dividend5">Yearly Interest and Dividends from this account?</label>
                                    <input id="Client_StockInvestments_Yearly_Interest_Dividend5" type="number" class="form-control 5_Client_stocksinvestments_inputs" name="Client_StockInvestments_Yearly_Interest_Dividend5" value="<?php if(isset($drstocksinvestments->Client_StockInvestments_Yearly_Interest_Dividend5)){ echo $drstocksinvestments->Client_StockInvestments_Yearly_Interest_Dividend5; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Does either party claim a sole/separate interest from the other on this account?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Client_StockInvestments_SoleSeparate_Claim5_Yes" name="Client_StockInvestments_SoleSeparate_Claim5" value="Yes" data-onload="getInitialPartyClaimSoleSeparate(this, '5', 'Client');" onchange="getPartyClaimSoleSeparate(this, '5', 'Client');" <?php if(isset($drstocksinvestments->Client_StockInvestments_SoleSeparate_Claim5) && $drstocksinvestments->Client_StockInvestments_SoleSeparate_Claim5=='Yes'){ echo "checked"; } ?>> Yes</label>
                                        <label><input type="radio" id="Client_StockInvestments_SoleSeparate_Claim5_No" name="Client_StockInvestments_SoleSeparate_Claim5" value="No" data-onload="getInitialPartyClaimSoleSeparate(this, '5', 'Client');" onchange="getPartyClaimSoleSeparate(this, '5', 'Client');" <?php if(isset($drstocksinvestments->Client_StockInvestments_SoleSeparate_Claim5) && $drstocksinvestments->Client_StockInvestments_SoleSeparate_Claim5=='No'){ echo "checked"; } ?>> No</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6" id="Client_StockInvestments_SoleSeparate_Party5_Div" style="display: none;">
                                    <label>Who claims to own this account?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Client_StockInvestments_SoleSeparate_Party5_Client" name="Client_StockInvestments_SoleSeparate_Party5" value="{{$client_name}}" <?php if(isset($drstocksinvestments->Client_StockInvestments_SoleSeparate_Party5) && $drstocksinvestments->Client_StockInvestments_SoleSeparate_Party5==$client_name){ echo "checked"; } ?>> {{$client_name}}</label>
                                        <label><input type="radio" id="Client_StockInvestments_SoleSeparate_Party5_Op" name="Client_StockInvestments_SoleSeparate_Party5" value="{{$opponent_name}}" <?php if(isset($drstocksinvestments->Client_StockInvestments_SoleSeparate_Party5) && $drstocksinvestments->Client_StockInvestments_SoleSeparate_Party5==$opponent_name){ echo "checked"; } ?>> {{$opponent_name}}</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 left-clear" id="Client_StockInvestments_SoleSeparate_Grounds5_Div" style="display: none; clear: left;">
                                    <label for="Client_StockInvestments_SoleSeparate_Grounds5">Why does this person own this account solely and separately?</label>
                                    <input id="Client_StockInvestments_SoleSeparate_Grounds5" type="text" class="form-control 5_Client_stocksinvestments_inputs" name="Client_StockInvestments_SoleSeparate_Grounds5" value="<?php if(isset($drstocksinvestments->Client_StockInvestments_SoleSeparate_Grounds5)){ echo $drstocksinvestments->Client_StockInvestments_SoleSeparate_Grounds5; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>How will this account value be distributed between the parties?</label>
                                    <div class="w-100 dataInput">
                                        <label><input type="radio" id="Client_StockInvestments_Disposition_Method5_Distribute_Investments" name="Client_StockInvestments_Disposition_Method5" value="Distribute Investments" data-onload="getInitialDipositionMethod(this, '5', 'Client');" onchange="getDipositionMethod(this, '5', 'Client');" <?php if(isset($drstocksinvestments->Client_StockInvestments_Disposition_Method5) && $drstocksinvestments->Client_StockInvestments_Disposition_Method5=='Distribute Investments'){ echo "checked"; } ?>> Distribute Investments</label>
                                        <label><input type="radio" id="Client_StockInvestments_Disposition_Method5_Liquidate_Split_Net_Value" name="Client_StockInvestments_Disposition_Method5" value="Liquidate/Split Net Value" data-onload="getInitialDipositionMethod(this, '5', 'Client');" onchange="getDipositionMethod(this, '5', 'Client');" <?php if(isset($drstocksinvestments->Client_StockInvestments_Disposition_Method5) && $drstocksinvestments->Client_StockInvestments_Disposition_Method5=='Liquidate/Split Net Value'){ echo "checked"; } ?>> Liquidate/Split Net Value</label>
                                        <label><input type="radio" id="Client_StockInvestments_Disposition_Method5_Percentage_Buyout" name="Client_StockInvestments_Disposition_Method5" value="Percentage Buyout" data-onload="getInitialDipositionMethod(this, '5', 'Client');" onchange="getDipositionMethod(this, '5', 'Client');" <?php if(isset($drstocksinvestments->Client_StockInvestments_Disposition_Method5) && $drstocksinvestments->Client_StockInvestments_Disposition_Method5=='Percentage Buyout'){ echo "checked"; } ?>> Percentage Buyout</label>
                                        <label><input type="radio" id="Client_StockInvestments_Disposition_Method5_Fixed Buyout" name="Client_StockInvestments_Disposition_Method5" value="Fixed Buyout" data-onload="getInitialDipositionMethod(this, '5', 'Client');" onchange="getDipositionMethod(this, '5', 'Client');" <?php if(isset($drstocksinvestments->Client_StockInvestments_Disposition_Method5) && $drstocksinvestments->Client_StockInvestments_Disposition_Method5=='Fixed Buyout'){ echo "checked"; } ?>> Fixed Buyout</label>
                                    </div>
                                </div>
                                <!-- slider tool -->
                                <div class="form-group col-sm-6 m-auto 5_Client_Slider_Tool slider-tool-main">
                                    <div class="row">
                                        <div class="col">{{$client_name}}</div>
                                        <div class="col text-right">{{$opponent_name}}</div>
                                    </div>
                                    <input id="5_Client_balance_range_selector" type="range" class="form-control slider-tool-input 5_Client_balance_range_selector" name="" value="<?php if(isset($drstocksinvestments->Client_StockInvestments_Percent_Marital_Equity_to_Op5)){ echo $drstocksinvestments->Client_StockInvestments_Percent_Marital_Equity_to_Op5; } ?>" min="0.00" step="0.01" max="100" onchange="updateBalanceInput(this.value, '5', 'Client');">
                                </div>
                                <div class="form-group col-sm-6 m-auto 5_Client_Slider_Tool slider-tool-main">
                                    <div class="row justify-content-between">
                                        <div class="col selectorTool">
                                            <div class="left-col">
                                                <div class="client-info 5_Client_clientpercentage_div clientpercentage_div">
                                                    <?php if(isset($drstocksinvestments->Client_StockInvestments_Percent_Marital_Equity_to_Client5)){ echo $drstocksinvestments->Client_StockInvestments_Percent_Marital_Equity_to_Client5; } else {
                                                        echo "50.00";
                                                    } ?>%
                                                </div>
                                                <div class="client-info 5_Client_clientamount_div clientamount_div" style="clear: both;">
                                                    $<?php if(isset($drstocksinvestments->Client_StockInvestments_Estimated_Value_to_Client5)){ echo $drstocksinvestments->Client_StockInvestments_Estimated_Value_to_Client5; }else {
                                                        echo "0.00";
                                                    } ?>
                                                </div>
                                            </div>
                                            <label>To {{$client_name}}</label>
                                        </div>                                       
                                        <div class="col selectorTool selectorToolRight">
                                            <label>To {{$opponent_name}}</label>
                                            <div class="left-col right-col">
                                                <div class="client-info 5_Client_opponentpercentage_div opponentpercentage_div">
                                                    <?php if(isset($drstocksinvestments->Client_StockInvestments_Percent_Marital_Equity_to_Op5)){ echo $drstocksinvestments->Client_StockInvestments_Percent_Marital_Equity_to_Op5; } else {
                                                        echo "50.00";
                                                    } ?>%
                                                </div>
                                                <div class="client-info 5_Client_opponentamount_div opponentamount_div" style="clear: both;">
                                                    $<?php if(isset($drstocksinvestments->Client_StockInvestments_Estimated_Value_to_Op5)){ echo $drstocksinvestments->Client_StockInvestments_Estimated_Value_to_Op5; }else {
                                                        echo "0.00";
                                                    } ?>
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
                                         <label><input type="radio" id="Client_StockInvestments_Paying_Party5_Client" name="Client_StockInvestments_Paying_Party5" value="{{$client_name}}" data-onload="getInitialStockInvestmentPayingParty(this, '5', 'Client');" onchange="getStockInvestmentPayingParty(this, '5', 'Client');"  <?php if(isset($drstocksinvestments->Client_StockInvestments_Paying_Party5) && $drstocksinvestments->Client_StockInvestments_Paying_Party5==$client_name){ echo "checked"; } ?>> {{$client_name}}</label>
                                        <label><input type="radio" id="Client_StockInvestments_Paying_Party5_Op" name="Client_StockInvestments_Paying_Party5" value="{{$opponent_name}}" data-onload="getInitialStockInvestmentPayingParty(this, '5', 'Client');" onchange="getStockInvestmentPayingParty(this, '5', 'Client');"  <?php if(isset($drstocksinvestments->Client_StockInvestments_Paying_Party5) && $drstocksinvestments->Client_StockInvestments_Paying_Party5==$opponent_name){ echo "checked"; } ?>> {{$opponent_name}}</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 Client_StockInvestments_Paying_Party5_Inputs_Div" style="display: none;">
                                    <label>{{$client_name}} StockInvestment Equity Percent</label>
                                    <input id="Client_StockInvestments_Percent_Marital_Equity_to_Client5" type="number" class="form-control 5_Client_clientpercentage_input clientpercentage_input" name="Client_StockInvestments_Percent_Marital_Equity_to_Client5" value="<?php if(isset($drstocksinvestments->Client_StockInvestments_Percent_Marital_Equity_to_Client5)){ echo $drstocksinvestments->Client_StockInvestments_Percent_Marital_Equity_to_Client5; } ?>" min="0.00" step="0.01" max="100" readonly="">
                                </div>
                                <div class="form-group col-sm-6 Client_StockInvestments_Paying_Party5_Inputs_Div" style="display: none;">
                                    <label>How much is to be paid to {{$client_name}}?</label>
                                    <input id="Client_StockInvestments_Estimated_Value_to_Client5" type="number" class="form-control 5_Client_clientamount_input clientamount_input" name="Client_StockInvestments_Estimated_Value_to_Client5" value="<?php if(isset($drstocksinvestments->Client_StockInvestments_Estimated_Value_to_Client5)){ echo $drstocksinvestments->Client_StockInvestments_Estimated_Value_to_Client5; } ?>" min="0.00" step="0.01" max="999999.99" readonly="" onchange="getEstimatedValueClient(this, '5', 'Client');" onkeyup="getEstimatedValueClient(this, '5', 'Client');">
                                </div>
                                <div class="form-group col-sm-6 Client_StockInvestments_Paying_Party5_Inputs_Div" style="display: none;">
                                    <label>{{$opponent_name}} StockInvestment Equity Percent</label>
                                    <input id="Client_StockInvestments_Percent_Marital_Equity_to_Op5" type="number" class="form-control 5_Client_opponentpercentage_input opponentpercentage_input" name="Client_StockInvestments_Percent_Marital_Equity_to_Op5" value="<?php if(isset($drstocksinvestments->Client_StockInvestments_Percent_Marital_Equity_to_Op5)){ echo $drstocksinvestments->Client_StockInvestments_Percent_Marital_Equity_to_Op5; } ?>" min="0.00" step="0.01" max="100" readonly="">
                                </div>
                                <div class="form-group col-sm-6 Client_StockInvestments_Paying_Party5_Inputs_Div" style="display: none;">
                                    <label>How much is to be paid to {{$opponent_name}}?</label>
                                    <input id="Client_StockInvestments_Estimated_Value_to_Op5" type="number" class="form-control 5_Client_opponentamount_input opponentamount_input" name="Client_StockInvestments_Estimated_Value_to_Op5" value="<?php if(isset($drstocksinvestments->Client_StockInvestments_Estimated_Value_to_Op5)){ echo $drstocksinvestments->Client_StockInvestments_Estimated_Value_to_Op5; } ?>" min="0.00" step="0.01" max="999999.99" readonly="" onchange="getEstimatedValueOp(this, '5', 'Client');" onkeyup="getEstimatedValueOp(this, '5', 'Client');">
                                </div>
                                <!-- end of slider tool -->
                            </div>
                            <div class="col-sm-12 mt-4 6_Client_stocksinvestments_section" style="display: none;"><h5 class="col-sm-12">Sixth Stock Investment Info</h5>
                                <div class="form-group col-sm-6">
                                    <p class="text-danger 6_Client_no-state-county-found" style="display: none;">No City, State, County found for this zipcode.</p>
                                    <label for="Client_StockInvestments_Institution_ZIP6">Stock/Investment Institution Zip Code?</label>
                                    <input id="Client_StockInvestments_Institution_ZIP6" type="text" class="form-control 6_Client_stocksinvestments_inputs" name="Client_StockInvestments_Institution_ZIP6" value="<?php if(isset($drstocksinvestments->Client_StockInvestments_Institution_ZIP6)){ echo $drstocksinvestments->Client_StockInvestments_Institution_ZIP6; } ?>" data-onload="getCityStateForZip(this, '6', 'Client');" onkeyup="getCityStateForZip(this, '6', 'Client');"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_StockInvestments_Institution_Name6">Name of Stock/Investment Institution?</label>
                                    <input id="Client_StockInvestments_Institution_Name6" type="text" class="form-control 6_Client_stocksinvestments_inputs" name="Client_StockInvestments_Institution_Name6" value="<?php if(isset($drstocksinvestments->Client_StockInvestments_Institution_Name6)){ echo $drstocksinvestments->Client_StockInvestments_Institution_Name6; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_StockInvestments_Institution_Street_Address6">Stock/Investment Institution Street Address?</label>
                                    <input id="Client_StockInvestments_Institution_Street_Address6" type="text" class="form-control 6_Client_stocksinvestments_inputs" name="Client_StockInvestments_Institution_Street_Address6" value="<?php if(isset($drstocksinvestments->Client_StockInvestments_Institution_Street_Address6)){ echo $drstocksinvestments->Client_StockInvestments_Institution_Street_Address6; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_StockInvestments_Institution_City6">Stock/Investment Institution City?</label>
                                    <input type="hidden" name="" id="Client_StockInvestments_Institution_City6_Value" value="<?php if(isset($drstocksinvestments->Client_StockInvestments_Institution_City6)){ echo $drstocksinvestments->Client_StockInvestments_Institution_City6; } ?>">
                                    <select id="Client_StockInvestments_Institution_City6" name="Client_StockInvestments_Institution_City6" class="form-control 6_Client_city_select">
                                        <option value="">Choose City</option>
                                    </select>   
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_StockInvestments_Institution_State6">Stock/Investment Institution State?</label>
                                    <input type="hidden" name="" id="Client_StockInvestments_Institution_State6_Value" value="<?php if(isset($drstocksinvestments->Client_StockInvestments_Institution_State6)){ echo $drstocksinvestments->Client_StockInvestments_Institution_State6; } ?>">
                                    <select id="Client_StockInvestments_Institution_State6" name="Client_StockInvestments_Institution_State6" class="form-control 6_Client_state_select">
                                        <option value="">Choose State</option>
                                    </select>   
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_StockInvestments_Acct_Num6">Account Number?</label>
                                    <input id="Client_StockInvestments_Acct_Num6" type="text" class="form-control 6_Client_stocksinvestments_inputs" name="Client_StockInvestments_Acct_Num6" value="<?php if(isset($drstocksinvestments->Client_StockInvestments_Acct_Num6)){ echo $drstocksinvestments->Client_StockInvestments_Acct_Num6; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_StockInvestments_Date_Marriage_Value6">Marriage Date Value?</label>
                                    <input id="Client_StockInvestments_Date_Marriage_Value6" type="number" class="form-control 6_Client_stocksinvestments_inputs" name="Client_StockInvestments_Date_Marriage_Value6" value="<?php if(isset($drstocksinvestments->Client_StockInvestments_Date_Marriage_Value6)){ echo $drstocksinvestments->Client_StockInvestments_Date_Marriage_Value6; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_StockInvestments_Current_Value6">Current Value?</label>
                                    <input id="Client_StockInvestments_Current_Value6" type="number" class="form-control 6_Client_stocksinvestments_inputs" name="Client_StockInvestments_Current_Value6" value="<?php if(isset($drstocksinvestments->Client_StockInvestments_Current_Value6)){ echo $drstocksinvestments->Client_StockInvestments_Current_Value6; } ?>" min="0.00" step="0.01" max="999999.99" onchange="getJointCurrentValue(this, '6', 'Client');" onkeyup="getJointCurrentValue(this, '6', 'Client');"> 
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label for="Client_StockInvestments_Percent_Marital_Equity6">N/A, calculated = Client_StockInvestments_Institution_Current_Value6</label>
                                    <input id="Client_StockInvestments_Percent_Marital_Equity6" type="number" class="form-control 6_Client_stocksinvestments_inputs" name="Client_StockInvestments_Percent_Marital_Equity6" value="<?php if(isset($drstocksinvestments->Client_StockInvestments_Percent_Marital_Equity6)){ echo $drstocksinvestments->Client_StockInvestments_Percent_Marital_Equity6; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_StockInvestments_Yearly_Interest_Dividend6">Yearly Interest and Dividends from this account?</label>
                                    <input id="Client_StockInvestments_Yearly_Interest_Dividend6" type="number" class="form-control 6_Client_stocksinvestments_inputs" name="Client_StockInvestments_Yearly_Interest_Dividend6" value="<?php if(isset($drstocksinvestments->Client_StockInvestments_Yearly_Interest_Dividend6)){ echo $drstocksinvestments->Client_StockInvestments_Yearly_Interest_Dividend6; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Does either party claim a sole/separate interest from the other on this account?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Client_StockInvestments_SoleSeparate_Claim6_Yes" name="Client_StockInvestments_SoleSeparate_Claim6" value="Yes" data-onload="getInitialPartyClaimSoleSeparate(this, '6', 'Client');" onchange="getPartyClaimSoleSeparate(this, '6', 'Client');" <?php if(isset($drstocksinvestments->Client_StockInvestments_SoleSeparate_Claim6) && $drstocksinvestments->Client_StockInvestments_SoleSeparate_Claim6=='Yes'){ echo "checked"; } ?>> Yes</label>
                                        <label><input type="radio" id="Client_StockInvestments_SoleSeparate_Claim6_No" name="Client_StockInvestments_SoleSeparate_Claim6" value="No" data-onload="getInitialPartyClaimSoleSeparate(this, '6', 'Client');" onchange="getPartyClaimSoleSeparate(this, '6', 'Client');" <?php if(isset($drstocksinvestments->Client_StockInvestments_SoleSeparate_Claim6) && $drstocksinvestments->Client_StockInvestments_SoleSeparate_Claim6=='No'){ echo "checked"; } ?>> No</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6" id="Client_StockInvestments_SoleSeparate_Party6_Div" style="display: none;">
                                    <label>Who claims to own this account?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Client_StockInvestments_SoleSeparate_Party6_Client" name="Client_StockInvestments_SoleSeparate_Party6" value="{{$client_name}}" <?php if(isset($drstocksinvestments->Client_StockInvestments_SoleSeparate_Party6) && $drstocksinvestments->Client_StockInvestments_SoleSeparate_Party6==$client_name){ echo "checked"; } ?>> {{$client_name}}</label>
                                        <label><input type="radio" id="Client_StockInvestments_SoleSeparate_Party6_Op" name="Client_StockInvestments_SoleSeparate_Party6" value="{{$opponent_name}}" <?php if(isset($drstocksinvestments->Client_StockInvestments_SoleSeparate_Party6) && $drstocksinvestments->Client_StockInvestments_SoleSeparate_Party6==$opponent_name){ echo "checked"; } ?>> {{$opponent_name}}</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 left-clear" id="Client_StockInvestments_SoleSeparate_Grounds6_Div" style="display: none; clear: left;">
                                    <label for="Client_StockInvestments_SoleSeparate_Grounds6">Why does this person own this account solely and separately?</label>
                                    <input id="Client_StockInvestments_SoleSeparate_Grounds6" type="text" class="form-control 6_Client_stocksinvestments_inputs" name="Client_StockInvestments_SoleSeparate_Grounds6" value="<?php if(isset($drstocksinvestments->Client_StockInvestments_SoleSeparate_Grounds6)){ echo $drstocksinvestments->Client_StockInvestments_SoleSeparate_Grounds6; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>How will this account value be distributed between the parties?</label>
                                    <div class="w-100 dataInput">
                                        <label><input type="radio" id="Client_StockInvestments_Disposition_Method6_Distribute_Investments" name="Client_StockInvestments_Disposition_Method6" value="Distribute Investments" data-onload="getInitialDipositionMethod(this, '6', 'Client');" onchange="getDipositionMethod(this, '6', 'Client');" <?php if(isset($drstocksinvestments->Client_StockInvestments_Disposition_Method6) && $drstocksinvestments->Client_StockInvestments_Disposition_Method6=='Distribute Investments'){ echo "checked"; } ?>> Distribute Investments</label>
                                        <label><input type="radio" id="Client_StockInvestments_Disposition_Method6_Liquidate_Split_Net_Value" name="Client_StockInvestments_Disposition_Method6" value="Liquidate/Split Net Value" data-onload="getInitialDipositionMethod(this, '6', 'Client');" onchange="getDipositionMethod(this, '6', 'Client');" <?php if(isset($drstocksinvestments->Client_StockInvestments_Disposition_Method6) && $drstocksinvestments->Client_StockInvestments_Disposition_Method6=='Liquidate/Split Net Value'){ echo "checked"; } ?>> Liquidate/Split Net Value</label>
                                        <label><input type="radio" id="Client_StockInvestments_Disposition_Method6_Percentage_Buyout" name="Client_StockInvestments_Disposition_Method6" value="Percentage Buyout" data-onload="getInitialDipositionMethod(this, '6', 'Client');" onchange="getDipositionMethod(this, '6', 'Client');" <?php if(isset($drstocksinvestments->Client_StockInvestments_Disposition_Method6) && $drstocksinvestments->Client_StockInvestments_Disposition_Method6=='Percentage Buyout'){ echo "checked"; } ?>> Percentage Buyout</label>
                                        <label><input type="radio" id="Client_StockInvestments_Disposition_Method6_Fixed Buyout" name="Client_StockInvestments_Disposition_Method6" value="Fixed Buyout" data-onload="getInitialDipositionMethod(this, '6', 'Client');" onchange="getDipositionMethod(this, '6', 'Client');" <?php if(isset($drstocksinvestments->Client_StockInvestments_Disposition_Method6) && $drstocksinvestments->Client_StockInvestments_Disposition_Method6=='Fixed Buyout'){ echo "checked"; } ?>> Fixed Buyout</label>
                                    </div>
                                </div>
                                <!-- slider tool -->
                                <div class="form-group col-sm-6 m-auto 6_Client_Slider_Tool slider-tool-main">
                                    <div class="row">
                                        <div class="col">{{$client_name}}</div>
                                        <div class="col text-right">{{$opponent_name}}</div>
                                    </div>
                                    <input id="6_Client_balance_range_selector" type="range" class="form-control slider-tool-input 6_Client_balance_range_selector" name="" value="<?php if(isset($drstocksinvestments->Client_StockInvestments_Percent_Marital_Equity_to_Op6)){ echo $drstocksinvestments->Client_StockInvestments_Percent_Marital_Equity_to_Op6; } ?>" min="0.00" step="0.01" max="100" onchange="updateBalanceInput(this.value, '6', 'Client');">
                                </div>
                                <div class="form-group col-sm-6 m-auto 6_Client_Slider_Tool slider-tool-main">
                                    <div class="row justify-content-between">
                                        <div class="col selectorTool">
                                            <div class="left-col">
                                                <div class="client-info 6_Client_clientpercentage_div clientpercentage_div">
                                                    <?php if(isset($drstocksinvestments->Client_StockInvestments_Percent_Marital_Equity_to_Client6)){ echo $drstocksinvestments->Client_StockInvestments_Percent_Marital_Equity_to_Client6; } else {
                                                        echo "50.00";
                                                    } ?>%
                                                </div>
                                                <div class="client-info 6_Client_clientamount_div clientamount_div" style="clear: both;">
                                                    $<?php if(isset($drstocksinvestments->Client_StockInvestments_Estimated_Value_to_Client6)){ echo $drstocksinvestments->Client_StockInvestments_Estimated_Value_to_Client6; }else {
                                                        echo "0.00";
                                                    } ?>
                                                </div>
                                            </div>
                                            <label>To {{$client_name}}</label>
                                        </div>                                       
                                        <div class="col selectorTool selectorToolRight">
                                            <label>To {{$opponent_name}}</label>
                                            <div class="left-col right-col">
                                                <div class="client-info 6_Client_opponentpercentage_div opponentpercentage_div">
                                                    <?php if(isset($drstocksinvestments->Client_StockInvestments_Percent_Marital_Equity_to_Op6)){ echo $drstocksinvestments->Client_StockInvestments_Percent_Marital_Equity_to_Op6; } else {
                                                        echo "50.00";
                                                    } ?>%
                                                </div>
                                                <div class="client-info 6_Client_opponentamount_div opponentamount_div" style="clear: both;">
                                                    $<?php if(isset($drstocksinvestments->Client_StockInvestments_Estimated_Value_to_Op6)){ echo $drstocksinvestments->Client_StockInvestments_Estimated_Value_to_Op6; }else {
                                                        echo "0.00";
                                                    } ?>
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
                                         <label><input type="radio" id="Client_StockInvestments_Paying_Party6_Client" name="Client_StockInvestments_Paying_Party6" value="{{$client_name}}" data-onload="getInitialStockInvestmentPayingParty(this, '6', 'Client');" onchange="getStockInvestmentPayingParty(this, '6', 'Client');"  <?php if(isset($drstocksinvestments->Client_StockInvestments_Paying_Party6) && $drstocksinvestments->Client_StockInvestments_Paying_Party6==$client_name){ echo "checked"; } ?>> {{$client_name}}</label>
                                        <label><input type="radio" id="Client_StockInvestments_Paying_Party6_Op" name="Client_StockInvestments_Paying_Party6" value="{{$opponent_name}}" data-onload="getInitialStockInvestmentPayingParty(this, '6', 'Client');" onchange="getStockInvestmentPayingParty(this, '6', 'Client');"  <?php if(isset($drstocksinvestments->Client_StockInvestments_Paying_Party6) && $drstocksinvestments->Client_StockInvestments_Paying_Party6==$opponent_name){ echo "checked"; } ?>> {{$opponent_name}}</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 Client_StockInvestments_Paying_Party6_Inputs_Div" style="display: none;">
                                    <label>{{$client_name}} StockInvestment Equity Percent</label>
                                    <input id="Client_StockInvestments_Percent_Marital_Equity_to_Client6" type="number" class="form-control 6_Client_clientpercentage_input clientpercentage_input" name="Client_StockInvestments_Percent_Marital_Equity_to_Client6" value="<?php if(isset($drstocksinvestments->Client_StockInvestments_Percent_Marital_Equity_to_Client6)){ echo $drstocksinvestments->Client_StockInvestments_Percent_Marital_Equity_to_Client6; } ?>" min="0.00" step="0.01" max="100" readonly="">
                                </div>
                                <div class="form-group col-sm-6 Client_StockInvestments_Paying_Party6_Inputs_Div" style="display: none;">
                                    <label>How much is to be paid to {{$client_name}}?</label>
                                    <input id="Client_StockInvestments_Estimated_Value_to_Client6" type="number" class="form-control 6_Client_clientamount_input clientamount_input" name="Client_StockInvestments_Estimated_Value_to_Client6" value="<?php if(isset($drstocksinvestments->Client_StockInvestments_Estimated_Value_to_Client6)){ echo $drstocksinvestments->Client_StockInvestments_Estimated_Value_to_Client6; } ?>" min="0.00" step="0.01" max="999999.99" readonly="" onchange="getEstimatedValueClient(this, '6', 'Client');" onkeyup="getEstimatedValueClient(this, '6', 'Client');">
                                </div>
                                <div class="form-group col-sm-6 Client_StockInvestments_Paying_Party6_Inputs_Div" style="display: none;">
                                    <label>{{$opponent_name}} StockInvestment Equity Percent</label>
                                    <input id="Client_StockInvestments_Percent_Marital_Equity_to_Op6" type="number" class="form-control 6_Client_opponentpercentage_input opponentpercentage_input" name="Client_StockInvestments_Percent_Marital_Equity_to_Op6" value="<?php if(isset($drstocksinvestments->Client_StockInvestments_Percent_Marital_Equity_to_Op6)){ echo $drstocksinvestments->Client_StockInvestments_Percent_Marital_Equity_to_Op6; } ?>" min="0.00" step="0.01" max="100" readonly="">
                                </div>
                                <div class="form-group col-sm-6 Client_StockInvestments_Paying_Party6_Inputs_Div" style="display: none;">
                                    <label>How much is to be paid to {{$opponent_name}}?</label>
                                    <input id="Client_StockInvestments_Estimated_Value_to_Op6" type="number" class="form-control 6_Client_opponentamount_input opponentamount_input" name="Client_StockInvestments_Estimated_Value_to_Op6" value="<?php if(isset($drstocksinvestments->Client_StockInvestments_Estimated_Value_to_Op6)){ echo $drstocksinvestments->Client_StockInvestments_Estimated_Value_to_Op6; } ?>" min="0.00" step="0.01" max="999999.99" readonly="" onchange="getEstimatedValueOp(this, '6', 'Client');" onkeyup="getEstimatedValueOp(this, '6', 'Client');">
                                </div>
                                <!-- end of slider tool -->
                            </div>
                            <div class="col-sm-12 mt-4 7_Client_stocksinvestments_section" style="display: none;"><h5 class="col-sm-12">Seventh Stock Investment Info</h5>
                                <div class="form-group col-sm-6">
                                    <p class="text-danger 7_Client_no-state-county-found" style="display: none;">No City, State, County found for this zipcode.</p>
                                    <label for="Client_StockInvestments_Institution_ZIP7">Stock/Investment Institution Zip Code?</label>
                                    <input id="Client_StockInvestments_Institution_ZIP7" type="text" class="form-control 7_Client_stocksinvestments_inputs" name="Client_StockInvestments_Institution_ZIP7" value="<?php if(isset($drstocksinvestments->Client_StockInvestments_Institution_ZIP7)){ echo $drstocksinvestments->Client_StockInvestments_Institution_ZIP7; } ?>" data-onload="getCityStateForZip(this, '7', 'Client');" onkeyup="getCityStateForZip(this, '7', 'Client');"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_StockInvestments_Institution_Name7">Name of Stock/Investment Institution?</label>
                                    <input id="Client_StockInvestments_Institution_Name7" type="text" class="form-control 7_Client_stocksinvestments_inputs" name="Client_StockInvestments_Institution_Name7" value="<?php if(isset($drstocksinvestments->Client_StockInvestments_Institution_Name7)){ echo $drstocksinvestments->Client_StockInvestments_Institution_Name7; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_StockInvestments_Institution_Street_Address7">Stock/Investment Institution Street Address?</label>
                                    <input id="Client_StockInvestments_Institution_Street_Address7" type="text" class="form-control 7_Client_stocksinvestments_inputs" name="Client_StockInvestments_Institution_Street_Address7" value="<?php if(isset($drstocksinvestments->Client_StockInvestments_Institution_Street_Address7)){ echo $drstocksinvestments->Client_StockInvestments_Institution_Street_Address7; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_StockInvestments_Institution_City7">Stock/Investment Institution City?</label>
                                    <input type="hidden" name="" id="Client_StockInvestments_Institution_City7_Value" value="<?php if(isset($drstocksinvestments->Client_StockInvestments_Institution_City7)){ echo $drstocksinvestments->Client_StockInvestments_Institution_City7; } ?>">
                                    <select id="Client_StockInvestments_Institution_City7" name="Client_StockInvestments_Institution_City7" class="form-control 7_Client_city_select">
                                        <option value="">Choose City</option>
                                    </select>   
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_StockInvestments_Institution_State7">Stock/Investment Institution State?</label>
                                    <input type="hidden" name="" id="Client_StockInvestments_Institution_State7_Value" value="<?php if(isset($drstocksinvestments->Client_StockInvestments_Institution_State7)){ echo $drstocksinvestments->Client_StockInvestments_Institution_State7; } ?>">
                                    <select id="Client_StockInvestments_Institution_State7" name="Client_StockInvestments_Institution_State7" class="form-control 7_Client_state_select">
                                        <option value="">Choose State</option>
                                    </select>   
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_StockInvestments_Acct_Num7">Account Number?</label>
                                    <input id="Client_StockInvestments_Acct_Num7" type="text" class="form-control 7_Client_stocksinvestments_inputs" name="Client_StockInvestments_Acct_Num7" value="<?php if(isset($drstocksinvestments->Client_StockInvestments_Acct_Num7)){ echo $drstocksinvestments->Client_StockInvestments_Acct_Num7; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_StockInvestments_Date_Marriage_Value7">Marriage Date Value?</label>
                                    <input id="Client_StockInvestments_Date_Marriage_Value7" type="number" class="form-control 7_Client_stocksinvestments_inputs" name="Client_StockInvestments_Date_Marriage_Value7" value="<?php if(isset($drstocksinvestments->Client_StockInvestments_Date_Marriage_Value7)){ echo $drstocksinvestments->Client_StockInvestments_Date_Marriage_Value7; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_StockInvestments_Current_Value7">Current Value?</label>
                                    <input id="Client_StockInvestments_Current_Value7" type="number" class="form-control 7_Client_stocksinvestments_inputs" name="Client_StockInvestments_Current_Value7" value="<?php if(isset($drstocksinvestments->Client_StockInvestments_Current_Value7)){ echo $drstocksinvestments->Client_StockInvestments_Current_Value7; } ?>" min="0.00" step="0.01" max="999999.99" onchange="getJointCurrentValue(this, '7', 'Client');" onkeyup="getJointCurrentValue(this, '7', 'Client');"> 
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label for="Client_StockInvestments_Percent_Marital_Equity7">N/A, calculated = Client_StockInvestments_Institution_Current_Value7</label>
                                    <input id="Client_StockInvestments_Percent_Marital_Equity7" type="number" class="form-control 7_Client_stocksinvestments_inputs" name="Client_StockInvestments_Percent_Marital_Equity7" value="<?php if(isset($drstocksinvestments->Client_StockInvestments_Percent_Marital_Equity7)){ echo $drstocksinvestments->Client_StockInvestments_Percent_Marital_Equity7; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_StockInvestments_Yearly_Interest_Dividend7">Yearly Interest and Dividends from this account?</label>
                                    <input id="Client_StockInvestments_Yearly_Interest_Dividend7" type="number" class="form-control 7_Client_stocksinvestments_inputs" name="Client_StockInvestments_Yearly_Interest_Dividend7" value="<?php if(isset($drstocksinvestments->Client_StockInvestments_Yearly_Interest_Dividend7)){ echo $drstocksinvestments->Client_StockInvestments_Yearly_Interest_Dividend7; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Does either party claim a sole/separate interest from the other on this account?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Client_StockInvestments_SoleSeparate_Claim7_Yes" name="Client_StockInvestments_SoleSeparate_Claim7" value="Yes" data-onload="getInitialPartyClaimSoleSeparate(this, '7', 'Client');" onchange="getPartyClaimSoleSeparate(this, '7', 'Client');" <?php if(isset($drstocksinvestments->Client_StockInvestments_SoleSeparate_Claim7) && $drstocksinvestments->Client_StockInvestments_SoleSeparate_Claim7=='Yes'){ echo "checked"; } ?>> Yes</label>
                                        <label><input type="radio" id="Client_StockInvestments_SoleSeparate_Claim7_No" name="Client_StockInvestments_SoleSeparate_Claim7" value="No" data-onload="getInitialPartyClaimSoleSeparate(this, '7', 'Client');" onchange="getPartyClaimSoleSeparate(this, '7', 'Client');" <?php if(isset($drstocksinvestments->Client_StockInvestments_SoleSeparate_Claim7) && $drstocksinvestments->Client_StockInvestments_SoleSeparate_Claim7=='No'){ echo "checked"; } ?>> No</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6" id="Client_StockInvestments_SoleSeparate_Party7_Div" style="display: none;">
                                    <label>Who claims to own this account?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Client_StockInvestments_SoleSeparate_Party7_Client" name="Client_StockInvestments_SoleSeparate_Party7" value="{{$client_name}}" <?php if(isset($drstocksinvestments->Client_StockInvestments_SoleSeparate_Party7) && $drstocksinvestments->Client_StockInvestments_SoleSeparate_Party7==$client_name){ echo "checked"; } ?>> {{$client_name}}</label>
                                        <label><input type="radio" id="Client_StockInvestments_SoleSeparate_Party7_Op" name="Client_StockInvestments_SoleSeparate_Party7" value="{{$opponent_name}}" <?php if(isset($drstocksinvestments->Client_StockInvestments_SoleSeparate_Party7) && $drstocksinvestments->Client_StockInvestments_SoleSeparate_Party7==$opponent_name){ echo "checked"; } ?>> {{$opponent_name}}</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 left-clear" id="Client_StockInvestments_SoleSeparate_Grounds7_Div" style="display: none; clear: left;">
                                    <label for="Client_StockInvestments_SoleSeparate_Grounds7">Why does this person own this account solely and separately?</label>
                                    <input id="Client_StockInvestments_SoleSeparate_Grounds7" type="text" class="form-control 7_Client_stocksinvestments_inputs" name="Client_StockInvestments_SoleSeparate_Grounds7" value="<?php if(isset($drstocksinvestments->Client_StockInvestments_SoleSeparate_Grounds7)){ echo $drstocksinvestments->Client_StockInvestments_SoleSeparate_Grounds7; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>How will this account value be distributed between the parties?</label>
                                    <div class="w-100 dataInput">
                                        <label><input type="radio" id="Client_StockInvestments_Disposition_Method7_Distribute_Investments" name="Client_StockInvestments_Disposition_Method7" value="Distribute Investments" data-onload="getInitialDipositionMethod(this, '7', 'Client');" onchange="getDipositionMethod(this, '7', 'Client');" <?php if(isset($drstocksinvestments->Client_StockInvestments_Disposition_Method7) && $drstocksinvestments->Client_StockInvestments_Disposition_Method7=='Distribute Investments'){ echo "checked"; } ?>> Distribute Investments</label>
                                        <label><input type="radio" id="Client_StockInvestments_Disposition_Method7_Liquidate_Split_Net_Value" name="Client_StockInvestments_Disposition_Method7" value="Liquidate/Split Net Value" data-onload="getInitialDipositionMethod(this, '7', 'Client');" onchange="getDipositionMethod(this, '7', 'Client');" <?php if(isset($drstocksinvestments->Client_StockInvestments_Disposition_Method7) && $drstocksinvestments->Client_StockInvestments_Disposition_Method7=='Liquidate/Split Net Value'){ echo "checked"; } ?>> Liquidate/Split Net Value</label>
                                        <label><input type="radio" id="Client_StockInvestments_Disposition_Method7_Percentage_Buyout" name="Client_StockInvestments_Disposition_Method7" value="Percentage Buyout" data-onload="getInitialDipositionMethod(this, '7', 'Client');" onchange="getDipositionMethod(this, '7', 'Client');" <?php if(isset($drstocksinvestments->Client_StockInvestments_Disposition_Method7) && $drstocksinvestments->Client_StockInvestments_Disposition_Method7=='Percentage Buyout'){ echo "checked"; } ?>> Percentage Buyout</label>
                                        <label><input type="radio" id="Client_StockInvestments_Disposition_Method7_Fixed Buyout" name="Client_StockInvestments_Disposition_Method7" value="Fixed Buyout" data-onload="getInitialDipositionMethod(this, '7', 'Client');" onchange="getDipositionMethod(this, '7', 'Client');" <?php if(isset($drstocksinvestments->Client_StockInvestments_Disposition_Method7) && $drstocksinvestments->Client_StockInvestments_Disposition_Method7=='Fixed Buyout'){ echo "checked"; } ?>> Fixed Buyout</label>
                                    </div>
                                </div>
                                <!-- slider tool -->
                                <div class="form-group col-sm-6 m-auto 7_Client_Slider_Tool slider-tool-main">
                                    <div class="row">
                                        <div class="col">{{$client_name}}</div>
                                        <div class="col text-right">{{$opponent_name}}</div>
                                    </div>
                                    <input id="7_Client_balance_range_selector" type="range" class="form-control slider-tool-input 7_Client_balance_range_selector" name="" value="<?php if(isset($drstocksinvestments->Client_StockInvestments_Percent_Marital_Equity_to_Op7)){ echo $drstocksinvestments->Client_StockInvestments_Percent_Marital_Equity_to_Op7; } ?>" min="0.00" step="0.01" max="100" onchange="updateBalanceInput(this.value, '7', 'Client');">
                                </div>
                                <div class="form-group col-sm-6 m-auto 7_Client_Slider_Tool slider-tool-main">
                                    <div class="row justify-content-between">
                                        <div class="col selectorTool">
                                            <div class="left-col">
                                                <div class="client-info 7_Client_clientpercentage_div clientpercentage_div">
                                                    <?php if(isset($drstocksinvestments->Client_StockInvestments_Percent_Marital_Equity_to_Client7)){ echo $drstocksinvestments->Client_StockInvestments_Percent_Marital_Equity_to_Client7; } else {
                                                        echo "50.00";
                                                    } ?>%
                                                </div>
                                                <div class="client-info 7_Client_clientamount_div clientamount_div" style="clear: both;">
                                                    $<?php if(isset($drstocksinvestments->Client_StockInvestments_Estimated_Value_to_Client7)){ echo $drstocksinvestments->Client_StockInvestments_Estimated_Value_to_Client7; }else {
                                                        echo "0.00";
                                                    } ?>
                                                </div>
                                            </div>
                                            <label>To {{$client_name}}</label>
                                        </div>                                       
                                        <div class="col selectorTool selectorToolRight">
                                            <label>To {{$opponent_name}}</label>
                                            <div class="left-col right-col">
                                                <div class="client-info 7_Client_opponentpercentage_div opponentpercentage_div">
                                                    <?php if(isset($drstocksinvestments->Client_StockInvestments_Percent_Marital_Equity_to_Op7)){ echo $drstocksinvestments->Client_StockInvestments_Percent_Marital_Equity_to_Op7; } else {
                                                        echo "50.00";
                                                    } ?>%
                                                </div>
                                                <div class="client-info 7_Client_opponentamount_div opponentamount_div" style="clear: both;">
                                                    $<?php if(isset($drstocksinvestments->Client_StockInvestments_Estimated_Value_to_Op7)){ echo $drstocksinvestments->Client_StockInvestments_Estimated_Value_to_Op7; }else {
                                                        echo "0.00";
                                                    } ?>
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
                                         <label><input type="radio" id="Client_StockInvestments_Paying_Party7_Client" name="Client_StockInvestments_Paying_Party7" value="{{$client_name}}" data-onload="getInitialStockInvestmentPayingParty(this, '7', 'Client');" onchange="getStockInvestmentPayingParty(this, '7', 'Client');"  <?php if(isset($drstocksinvestments->Client_StockInvestments_Paying_Party7) && $drstocksinvestments->Client_StockInvestments_Paying_Party7==$client_name){ echo "checked"; } ?>> {{$client_name}}</label>
                                        <label><input type="radio" id="Client_StockInvestments_Paying_Party7_Op" name="Client_StockInvestments_Paying_Party7" value="{{$opponent_name}}" data-onload="getInitialStockInvestmentPayingParty(this, '7', 'Client');" onchange="getStockInvestmentPayingParty(this, '7', 'Client');"  <?php if(isset($drstocksinvestments->Client_StockInvestments_Paying_Party7) && $drstocksinvestments->Client_StockInvestments_Paying_Party7==$opponent_name){ echo "checked"; } ?>> {{$opponent_name}}</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 Client_StockInvestments_Paying_Party7_Inputs_Div" style="display: none;">
                                    <label>{{$client_name}} StockInvestment Equity Percent</label>
                                    <input id="Client_StockInvestments_Percent_Marital_Equity_to_Client7" type="number" class="form-control 7_Client_clientpercentage_input clientpercentage_input" name="Client_StockInvestments_Percent_Marital_Equity_to_Client7" value="<?php if(isset($drstocksinvestments->Client_StockInvestments_Percent_Marital_Equity_to_Client7)){ echo $drstocksinvestments->Client_StockInvestments_Percent_Marital_Equity_to_Client7; } ?>" min="0.00" step="0.01" max="100" readonly="">
                                </div>
                                <div class="form-group col-sm-6 Client_StockInvestments_Paying_Party7_Inputs_Div" style="display: none;">
                                    <label>How much is to be paid to {{$client_name}}?</label>
                                    <input id="Client_StockInvestments_Estimated_Value_to_Client7" type="number" class="form-control 7_Client_clientamount_input clientamount_input" name="Client_StockInvestments_Estimated_Value_to_Client7" value="<?php if(isset($drstocksinvestments->Client_StockInvestments_Estimated_Value_to_Client7)){ echo $drstocksinvestments->Client_StockInvestments_Estimated_Value_to_Client7; } ?>" min="0.00" step="0.01" max="999999.99" readonly="" onchange="getEstimatedValueClient(this, '7', 'Client');" onkeyup="getEstimatedValueClient(this, '7', 'Client');">
                                </div>
                                <div class="form-group col-sm-6 Client_StockInvestments_Paying_Party7_Inputs_Div" style="display: none;">
                                    <label>{{$opponent_name}} StockInvestment Equity Percent</label>
                                    <input id="Client_StockInvestments_Percent_Marital_Equity_to_Op7" type="number" class="form-control 7_Client_opponentpercentage_input opponentpercentage_input" name="Client_StockInvestments_Percent_Marital_Equity_to_Op7" value="<?php if(isset($drstocksinvestments->Client_StockInvestments_Percent_Marital_Equity_to_Op7)){ echo $drstocksinvestments->Client_StockInvestments_Percent_Marital_Equity_to_Op7; } ?>" min="0.00" step="0.01" max="100" readonly="">
                                </div>
                                <div class="form-group col-sm-6 Client_StockInvestments_Paying_Party7_Inputs_Div" style="display: none;">
                                    <label>How much is to be paid to {{$opponent_name}}?</label>
                                    <input id="Client_StockInvestments_Estimated_Value_to_Op7" type="number" class="form-control 7_Client_opponentamount_input opponentamount_input" name="Client_StockInvestments_Estimated_Value_to_Op7" value="<?php if(isset($drstocksinvestments->Client_StockInvestments_Estimated_Value_to_Op7)){ echo $drstocksinvestments->Client_StockInvestments_Estimated_Value_to_Op7; } ?>" min="0.00" step="0.01" max="999999.99" readonly="" onchange="getEstimatedValueOp(this, '7', 'Client');" onkeyup="getEstimatedValueOp(this, '7', 'Client');">
                                </div>
                                <!-- end of slider tool -->
                            </div>
                            <div class="col-sm-12 mt-4 8_Client_stocksinvestments_section" style="display: none;"><h5 class="col-sm-12">Eighth Stock Investment Info</h5>
                                <div class="form-group col-sm-6">
                                    <p class="text-danger 8_Client_no-state-county-found" style="display: none;">No City, State, County found for this zipcode.</p>
                                    <label for="Client_StockInvestments_Institution_ZIP8">Stock/Investment Institution Zip Code?</label>
                                    <input id="Client_StockInvestments_Institution_ZIP8" type="text" class="form-control 8_Client_stocksinvestments_inputs" name="Client_StockInvestments_Institution_ZIP8" value="<?php if(isset($drstocksinvestments->Client_StockInvestments_Institution_ZIP8)){ echo $drstocksinvestments->Client_StockInvestments_Institution_ZIP8; } ?>" data-onload="getCityStateForZip(this, '8', 'Client');" onkeyup="getCityStateForZip(this, '8', 'Client');"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_StockInvestments_Institution_Name8">Name of Stock/Investment Institution?</label>
                                    <input id="Client_StockInvestments_Institution_Name8" type="text" class="form-control 8_Client_stocksinvestments_inputs" name="Client_StockInvestments_Institution_Name8" value="<?php if(isset($drstocksinvestments->Client_StockInvestments_Institution_Name8)){ echo $drstocksinvestments->Client_StockInvestments_Institution_Name8; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_StockInvestments_Institution_Street_Address8">Stock/Investment Institution Street Address?</label>
                                    <input id="Client_StockInvestments_Institution_Street_Address8" type="text" class="form-control 8_Client_stocksinvestments_inputs" name="Client_StockInvestments_Institution_Street_Address8" value="<?php if(isset($drstocksinvestments->Client_StockInvestments_Institution_Street_Address8)){ echo $drstocksinvestments->Client_StockInvestments_Institution_Street_Address8; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_StockInvestments_Institution_City8">Stock/Investment Institution City?</label>
                                    <input type="hidden" name="" id="Client_StockInvestments_Institution_City8_Value" value="<?php if(isset($drstocksinvestments->Client_StockInvestments_Institution_City8)){ echo $drstocksinvestments->Client_StockInvestments_Institution_City8; } ?>">
                                    <select id="Client_StockInvestments_Institution_City8" name="Client_StockInvestments_Institution_City8" class="form-control 8_Client_city_select">
                                        <option value="">Choose City</option>
                                    </select>   
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_StockInvestments_Institution_State8">Stock/Investment Institution State?</label>
                                    <input type="hidden" name="" id="Client_StockInvestments_Institution_State8_Value" value="<?php if(isset($drstocksinvestments->Client_StockInvestments_Institution_State8)){ echo $drstocksinvestments->Client_StockInvestments_Institution_State8; } ?>">
                                    <select id="Client_StockInvestments_Institution_State8" name="Client_StockInvestments_Institution_State8" class="form-control 8_Client_state_select">
                                        <option value="">Choose State</option>
                                    </select>   
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_StockInvestments_Acct_Num8">Account Number?</label>
                                    <input id="Client_StockInvestments_Acct_Num8" type="text" class="form-control 8_Client_stocksinvestments_inputs" name="Client_StockInvestments_Acct_Num8" value="<?php if(isset($drstocksinvestments->Client_StockInvestments_Acct_Num8)){ echo $drstocksinvestments->Client_StockInvestments_Acct_Num8; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_StockInvestments_Date_Marriage_Value8">Marriage Date Value?</label>
                                    <input id="Client_StockInvestments_Date_Marriage_Value8" type="number" class="form-control 8_Client_stocksinvestments_inputs" name="Client_StockInvestments_Date_Marriage_Value8" value="<?php if(isset($drstocksinvestments->Client_StockInvestments_Date_Marriage_Value8)){ echo $drstocksinvestments->Client_StockInvestments_Date_Marriage_Value8; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_StockInvestments_Current_Value8">Current Value?</label>
                                    <input id="Client_StockInvestments_Current_Value8" type="number" class="form-control 8_Client_stocksinvestments_inputs" name="Client_StockInvestments_Current_Value8" value="<?php if(isset($drstocksinvestments->Client_StockInvestments_Current_Value8)){ echo $drstocksinvestments->Client_StockInvestments_Current_Value8; } ?>" min="0.00" step="0.01" max="999999.99" onchange="getJointCurrentValue(this, '8', 'Client');" onkeyup="getJointCurrentValue(this, '8', 'Client');"> 
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label for="Client_StockInvestments_Percent_Marital_Equity8">N/A, calculated = Client_StockInvestments_Institution_Current_Value8</label>
                                    <input id="Client_StockInvestments_Percent_Marital_Equity8" type="number" class="form-control 8_Client_stocksinvestments_inputs" name="Client_StockInvestments_Percent_Marital_Equity8" value="<?php if(isset($drstocksinvestments->Client_StockInvestments_Percent_Marital_Equity8)){ echo $drstocksinvestments->Client_StockInvestments_Percent_Marital_Equity8; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_StockInvestments_Yearly_Interest_Dividend8">Yearly Interest and Dividends from this account?</label>
                                    <input id="Client_StockInvestments_Yearly_Interest_Dividend8" type="number" class="form-control 8_Client_stocksinvestments_inputs" name="Client_StockInvestments_Yearly_Interest_Dividend8" value="<?php if(isset($drstocksinvestments->Client_StockInvestments_Yearly_Interest_Dividend8)){ echo $drstocksinvestments->Client_StockInvestments_Yearly_Interest_Dividend8; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Does either party claim a sole/separate interest from the other on this account?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Client_StockInvestments_SoleSeparate_Claim8_Yes" name="Client_StockInvestments_SoleSeparate_Claim8" value="Yes" data-onload="getInitialPartyClaimSoleSeparate(this, '8', 'Client');" onchange="getPartyClaimSoleSeparate(this, '8', 'Client');" <?php if(isset($drstocksinvestments->Client_StockInvestments_SoleSeparate_Claim8) && $drstocksinvestments->Client_StockInvestments_SoleSeparate_Claim8=='Yes'){ echo "checked"; } ?>> Yes</label>
                                        <label><input type="radio" id="Client_StockInvestments_SoleSeparate_Claim8_No" name="Client_StockInvestments_SoleSeparate_Claim8" value="No" data-onload="getInitialPartyClaimSoleSeparate(this, '8', 'Client');" onchange="getPartyClaimSoleSeparate(this, '8', 'Client');" <?php if(isset($drstocksinvestments->Client_StockInvestments_SoleSeparate_Claim8) && $drstocksinvestments->Client_StockInvestments_SoleSeparate_Claim8=='No'){ echo "checked"; } ?>> No</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6" id="Client_StockInvestments_SoleSeparate_Party8_Div" style="display: none;">
                                    <label>Who claims to own this account?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Client_StockInvestments_SoleSeparate_Party8_Client" name="Client_StockInvestments_SoleSeparate_Party8" value="{{$client_name}}" <?php if(isset($drstocksinvestments->Client_StockInvestments_SoleSeparate_Party8) && $drstocksinvestments->Client_StockInvestments_SoleSeparate_Party8==$client_name){ echo "checked"; } ?>> {{$client_name}}</label>
                                        <label><input type="radio" id="Client_StockInvestments_SoleSeparate_Party8_Op" name="Client_StockInvestments_SoleSeparate_Party8" value="{{$opponent_name}}" <?php if(isset($drstocksinvestments->Client_StockInvestments_SoleSeparate_Party8) && $drstocksinvestments->Client_StockInvestments_SoleSeparate_Party8==$opponent_name){ echo "checked"; } ?>> {{$opponent_name}}</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 left-clear" id="Client_StockInvestments_SoleSeparate_Grounds8_Div" style="display: none; clear: left;">
                                    <label for="Client_StockInvestments_SoleSeparate_Grounds8">Why does this person own this account solely and separately?</label>
                                    <input id="Client_StockInvestments_SoleSeparate_Grounds8" type="text" class="form-control 8_Client_stocksinvestments_inputs" name="Client_StockInvestments_SoleSeparate_Grounds8" value="<?php if(isset($drstocksinvestments->Client_StockInvestments_SoleSeparate_Grounds8)){ echo $drstocksinvestments->Client_StockInvestments_SoleSeparate_Grounds8; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>How will this account value be distributed between the parties?</label>
                                    <div class="w-100 dataInput">
                                        <label><input type="radio" id="Client_StockInvestments_Disposition_Method8_Distribute_Investments" name="Client_StockInvestments_Disposition_Method8" value="Distribute Investments" data-onload="getInitialDipositionMethod(this, '8', 'Client');" onchange="getDipositionMethod(this, '8', 'Client');" <?php if(isset($drstocksinvestments->Client_StockInvestments_Disposition_Method8) && $drstocksinvestments->Client_StockInvestments_Disposition_Method8=='Distribute Investments'){ echo "checked"; } ?>> Distribute Investments</label>
                                        <label><input type="radio" id="Client_StockInvestments_Disposition_Method8_Liquidate_Split_Net_Value" name="Client_StockInvestments_Disposition_Method8" value="Liquidate/Split Net Value" data-onload="getInitialDipositionMethod(this, '8', 'Client');" onchange="getDipositionMethod(this, '8', 'Client');" <?php if(isset($drstocksinvestments->Client_StockInvestments_Disposition_Method8) && $drstocksinvestments->Client_StockInvestments_Disposition_Method8=='Liquidate/Split Net Value'){ echo "checked"; } ?>> Liquidate/Split Net Value</label>
                                        <label><input type="radio" id="Client_StockInvestments_Disposition_Method8_Percentage_Buyout" name="Client_StockInvestments_Disposition_Method8" value="Percentage Buyout" data-onload="getInitialDipositionMethod(this, '8', 'Client');" onchange="getDipositionMethod(this, '8', 'Client');" <?php if(isset($drstocksinvestments->Client_StockInvestments_Disposition_Method8) && $drstocksinvestments->Client_StockInvestments_Disposition_Method8=='Percentage Buyout'){ echo "checked"; } ?>> Percentage Buyout</label>
                                        <label><input type="radio" id="Client_StockInvestments_Disposition_Method8_Fixed Buyout" name="Client_StockInvestments_Disposition_Method8" value="Fixed Buyout" data-onload="getInitialDipositionMethod(this, '8', 'Client');" onchange="getDipositionMethod(this, '8', 'Client');" <?php if(isset($drstocksinvestments->Client_StockInvestments_Disposition_Method8) && $drstocksinvestments->Client_StockInvestments_Disposition_Method8=='Fixed Buyout'){ echo "checked"; } ?>> Fixed Buyout</label>
                                    </div>
                                </div>
                                <!-- slider tool -->
                                <div class="form-group col-sm-6 m-auto 8_Client_Slider_Tool slider-tool-main">
                                    <div class="row">
                                        <div class="col">{{$client_name}}</div>
                                        <div class="col text-right">{{$opponent_name}}</div>
                                    </div>
                                    <input id="8_Client_balance_range_selector" type="range" class="form-control slider-tool-input 8_Client_balance_range_selector" name="" value="<?php if(isset($drstocksinvestments->Client_StockInvestments_Percent_Marital_Equity_to_Op8)){ echo $drstocksinvestments->Client_StockInvestments_Percent_Marital_Equity_to_Op8; } ?>" min="0.00" step="0.01" max="100" onchange="updateBalanceInput(this.value, '8', 'Client');">
                                </div>
                                <div class="form-group col-sm-6 m-auto 8_Client_Slider_Tool slider-tool-main">
                                    <div class="row justify-content-between">
                                        <div class="col selectorTool">
                                            <div class="left-col">
                                                <div class="client-info 8_Client_clientpercentage_div clientpercentage_div">
                                                    <?php if(isset($drstocksinvestments->Client_StockInvestments_Percent_Marital_Equity_to_Client8)){ echo $drstocksinvestments->Client_StockInvestments_Percent_Marital_Equity_to_Client8; } else {
                                                        echo "50.00";
                                                    } ?>%
                                                </div>
                                                <div class="client-info 8_Client_clientamount_div clientamount_div" style="clear: both;">
                                                    $<?php if(isset($drstocksinvestments->Client_StockInvestments_Estimated_Value_to_Client8)){ echo $drstocksinvestments->Client_StockInvestments_Estimated_Value_to_Client8; }else {
                                                        echo "0.00";
                                                    } ?>
                                                </div>
                                            </div>
                                            <label>To {{$client_name}}</label>
                                        </div>                                       
                                        <div class="col selectorTool selectorToolRight">
                                            <label>To {{$opponent_name}}</label>
                                            <div class="left-col right-col">
                                                <div class="client-info 8_Client_opponentpercentage_div opponentpercentage_div">
                                                    <?php if(isset($drstocksinvestments->Client_StockInvestments_Percent_Marital_Equity_to_Op8)){ echo $drstocksinvestments->Client_StockInvestments_Percent_Marital_Equity_to_Op8; } else {
                                                        echo "50.00";
                                                    } ?>%
                                                </div>
                                                <div class="client-info 8_Client_opponentamount_div opponentamount_div" style="clear: both;">
                                                    $<?php if(isset($drstocksinvestments->Client_StockInvestments_Estimated_Value_to_Op8)){ echo $drstocksinvestments->Client_StockInvestments_Estimated_Value_to_Op8; }else {
                                                        echo "0.00";
                                                    } ?>
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
                                         <label><input type="radio" id="Client_StockInvestments_Paying_Party8_Client" name="Client_StockInvestments_Paying_Party8" value="{{$client_name}}" data-onload="getInitialStockInvestmentPayingParty(this, '8', 'Client');" onchange="getStockInvestmentPayingParty(this, '8', 'Client');"  <?php if(isset($drstocksinvestments->Client_StockInvestments_Paying_Party8) && $drstocksinvestments->Client_StockInvestments_Paying_Party8==$client_name){ echo "checked"; } ?>> {{$client_name}}</label>
                                        <label><input type="radio" id="Client_StockInvestments_Paying_Party8_Op" name="Client_StockInvestments_Paying_Party8" value="{{$opponent_name}}" data-onload="getInitialStockInvestmentPayingParty(this, '8', 'Client');" onchange="getStockInvestmentPayingParty(this, '8', 'Client');"  <?php if(isset($drstocksinvestments->Client_StockInvestments_Paying_Party8) && $drstocksinvestments->Client_StockInvestments_Paying_Party8==$opponent_name){ echo "checked"; } ?>> {{$opponent_name}}</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 Client_StockInvestments_Paying_Party8_Inputs_Div" style="display: none;">
                                    <label>{{$client_name}} StockInvestment Equity Percent</label>
                                    <input id="Client_StockInvestments_Percent_Marital_Equity_to_Client8" type="number" class="form-control 8_Client_clientpercentage_input clientpercentage_input" name="Client_StockInvestments_Percent_Marital_Equity_to_Client8" value="<?php if(isset($drstocksinvestments->Client_StockInvestments_Percent_Marital_Equity_to_Client8)){ echo $drstocksinvestments->Client_StockInvestments_Percent_Marital_Equity_to_Client8; } ?>" min="0.00" step="0.01" max="100" readonly="">
                                </div>
                                <div class="form-group col-sm-6 Client_StockInvestments_Paying_Party8_Inputs_Div" style="display: none;">
                                    <label>How much is to be paid to {{$client_name}}?</label>
                                    <input id="Client_StockInvestments_Estimated_Value_to_Client8" type="number" class="form-control 8_Client_clientamount_input clientamount_input" name="Client_StockInvestments_Estimated_Value_to_Client8" value="<?php if(isset($drstocksinvestments->Client_StockInvestments_Estimated_Value_to_Client8)){ echo $drstocksinvestments->Client_StockInvestments_Estimated_Value_to_Client8; } ?>" min="0.00" step="0.01" max="999999.99" readonly="" onchange="getEstimatedValueClient(this, '8', 'Client');" onkeyup="getEstimatedValueClient(this, '8', 'Client');">
                                </div>
                                <div class="form-group col-sm-6 Client_StockInvestments_Paying_Party8_Inputs_Div" style="display: none;">
                                    <label>{{$opponent_name}} StockInvestment Equity Percent</label>
                                    <input id="Client_StockInvestments_Percent_Marital_Equity_to_Op8" type="number" class="form-control 8_Client_opponentpercentage_input opponentpercentage_input" name="Client_StockInvestments_Percent_Marital_Equity_to_Op8" value="<?php if(isset($drstocksinvestments->Client_StockInvestments_Percent_Marital_Equity_to_Op8)){ echo $drstocksinvestments->Client_StockInvestments_Percent_Marital_Equity_to_Op8; } ?>" min="0.00" step="0.01" max="100" readonly="">
                                </div>
                                <div class="form-group col-sm-6 Client_StockInvestments_Paying_Party8_Inputs_Div" style="display: none;">
                                    <label>How much is to be paid to {{$opponent_name}}?</label>
                                    <input id="Client_StockInvestments_Estimated_Value_to_Op8" type="number" class="form-control 8_Client_opponentamount_input opponentamount_input" name="Client_StockInvestments_Estimated_Value_to_Op8" value="<?php if(isset($drstocksinvestments->Client_StockInvestments_Estimated_Value_to_Op8)){ echo $drstocksinvestments->Client_StockInvestments_Estimated_Value_to_Op8; } ?>" min="0.00" step="0.01" max="999999.99" readonly="" onchange="getEstimatedValueOp(this, '8', 'Client');" onkeyup="getEstimatedValueOp(this, '8', 'Client');">
                                </div>
                                <!-- end of slider tool -->
                            </div>
                            <div class="col-sm-12 mt-4 9_Client_stocksinvestments_section" style="display: none;"><h5 class="col-sm-12">Nineth Stock Investment Info</h5>
                                <div class="form-group col-sm-6">
                                    <p class="text-danger 9_Client_no-state-county-found" style="display: none;">No City, State, County found for this zipcode.</p>
                                    <label for="Client_StockInvestments_Institution_ZIP9">Stock/Investment Institution Zip Code?</label>
                                    <input id="Client_StockInvestments_Institution_ZIP9" type="text" class="form-control 9_Client_stocksinvestments_inputs" name="Client_StockInvestments_Institution_ZIP9" value="<?php if(isset($drstocksinvestments->Client_StockInvestments_Institution_ZIP9)){ echo $drstocksinvestments->Client_StockInvestments_Institution_ZIP9; } ?>" data-onload="getCityStateForZip(this, '9', 'Client');" onkeyup="getCityStateForZip(this, '9', 'Client');"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_StockInvestments_Institution_Name9">Name of Stock/Investment Institution?</label>
                                    <input id="Client_StockInvestments_Institution_Name9" type="text" class="form-control 9_Client_stocksinvestments_inputs" name="Client_StockInvestments_Institution_Name9" value="<?php if(isset($drstocksinvestments->Client_StockInvestments_Institution_Name9)){ echo $drstocksinvestments->Client_StockInvestments_Institution_Name9; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_StockInvestments_Institution_Street_Address9">Stock/Investment Institution Street Address?</label>
                                    <input id="Client_StockInvestments_Institution_Street_Address9" type="text" class="form-control 9_Client_stocksinvestments_inputs" name="Client_StockInvestments_Institution_Street_Address9" value="<?php if(isset($drstocksinvestments->Client_StockInvestments_Institution_Street_Address9)){ echo $drstocksinvestments->Client_StockInvestments_Institution_Street_Address9; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_StockInvestments_Institution_City9">Stock/Investment Institution City?</label>
                                    <input type="hidden" name="" id="Client_StockInvestments_Institution_City9_Value" value="<?php if(isset($drstocksinvestments->Client_StockInvestments_Institution_City9)){ echo $drstocksinvestments->Client_StockInvestments_Institution_City9; } ?>">
                                    <select id="Client_StockInvestments_Institution_City9" name="Client_StockInvestments_Institution_City9" class="form-control 9_Client_city_select">
                                        <option value="">Choose City</option>
                                    </select>   
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_StockInvestments_Institution_State9">Stock/Investment Institution State?</label>
                                    <input type="hidden" name="" id="Client_StockInvestments_Institution_State9_Value" value="<?php if(isset($drstocksinvestments->Client_StockInvestments_Institution_State9)){ echo $drstocksinvestments->Client_StockInvestments_Institution_State9; } ?>">
                                    <select id="Client_StockInvestments_Institution_State9" name="Client_StockInvestments_Institution_State9" class="form-control 9_Client_state_select">
                                        <option value="">Choose State</option>
                                    </select>   
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_StockInvestments_Acct_Num9">Account Number?</label>
                                    <input id="Client_StockInvestments_Acct_Num9" type="text" class="form-control 9_Client_stocksinvestments_inputs" name="Client_StockInvestments_Acct_Num9" value="<?php if(isset($drstocksinvestments->Client_StockInvestments_Acct_Num9)){ echo $drstocksinvestments->Client_StockInvestments_Acct_Num9; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_StockInvestments_Date_Marriage_Value9">Marriage Date Value?</label>
                                    <input id="Client_StockInvestments_Date_Marriage_Value9" type="number" class="form-control 9_Client_stocksinvestments_inputs" name="Client_StockInvestments_Date_Marriage_Value9" value="<?php if(isset($drstocksinvestments->Client_StockInvestments_Date_Marriage_Value9)){ echo $drstocksinvestments->Client_StockInvestments_Date_Marriage_Value9; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_StockInvestments_Current_Value9">Current Value?</label>
                                    <input id="Client_StockInvestments_Current_Value9" type="number" class="form-control 9_Client_stocksinvestments_inputs" name="Client_StockInvestments_Current_Value9" value="<?php if(isset($drstocksinvestments->Client_StockInvestments_Current_Value9)){ echo $drstocksinvestments->Client_StockInvestments_Current_Value9; } ?>" min="0.00" step="0.01" max="999999.99" onchange="getJointCurrentValue(this, '9', 'Client');" onkeyup="getJointCurrentValue(this, '9', 'Client');"> 
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label for="Client_StockInvestments_Percent_Marital_Equity9">N/A, calculated = Client_StockInvestments_Institution_Current_Value9</label>
                                    <input id="Client_StockInvestments_Percent_Marital_Equity9" type="number" class="form-control 9_Client_stocksinvestments_inputs" name="Client_StockInvestments_Percent_Marital_Equity9" value="<?php if(isset($drstocksinvestments->Client_StockInvestments_Percent_Marital_Equity9)){ echo $drstocksinvestments->Client_StockInvestments_Percent_Marital_Equity9; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_StockInvestments_Yearly_Interest_Dividend9">Yearly Interest and Dividends from this account?</label>
                                    <input id="Client_StockInvestments_Yearly_Interest_Dividend9" type="number" class="form-control 9_Client_stocksinvestments_inputs" name="Client_StockInvestments_Yearly_Interest_Dividend9" value="<?php if(isset($drstocksinvestments->Client_StockInvestments_Yearly_Interest_Dividend9)){ echo $drstocksinvestments->Client_StockInvestments_Yearly_Interest_Dividend9; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Does either party claim a sole/separate interest from the other on this account?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Client_StockInvestments_SoleSeparate_Claim9_Yes" name="Client_StockInvestments_SoleSeparate_Claim9" value="Yes" data-onload="getInitialPartyClaimSoleSeparate(this, '9', 'Client');" onchange="getPartyClaimSoleSeparate(this, '9', 'Client');" <?php if(isset($drstocksinvestments->Client_StockInvestments_SoleSeparate_Claim9) && $drstocksinvestments->Client_StockInvestments_SoleSeparate_Claim9=='Yes'){ echo "checked"; } ?>> Yes</label>
                                        <label><input type="radio" id="Client_StockInvestments_SoleSeparate_Claim9_No" name="Client_StockInvestments_SoleSeparate_Claim9" value="No" data-onload="getInitialPartyClaimSoleSeparate(this, '9', 'Client');" onchange="getPartyClaimSoleSeparate(this, '9', 'Client');" <?php if(isset($drstocksinvestments->Client_StockInvestments_SoleSeparate_Claim9) && $drstocksinvestments->Client_StockInvestments_SoleSeparate_Claim9=='No'){ echo "checked"; } ?>> No</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6" id="Client_StockInvestments_SoleSeparate_Party9_Div" style="display: none;">
                                    <label>Who claims to own this account?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Client_StockInvestments_SoleSeparate_Party9_Client" name="Client_StockInvestments_SoleSeparate_Party9" value="{{$client_name}}" <?php if(isset($drstocksinvestments->Client_StockInvestments_SoleSeparate_Party9) && $drstocksinvestments->Client_StockInvestments_SoleSeparate_Party9==$client_name){ echo "checked"; } ?>> {{$client_name}}</label>
                                        <label><input type="radio" id="Client_StockInvestments_SoleSeparate_Party9_Op" name="Client_StockInvestments_SoleSeparate_Party9" value="{{$opponent_name}}" <?php if(isset($drstocksinvestments->Client_StockInvestments_SoleSeparate_Party9) && $drstocksinvestments->Client_StockInvestments_SoleSeparate_Party9==$opponent_name){ echo "checked"; } ?>> {{$opponent_name}}</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 left-clear" id="Client_StockInvestments_SoleSeparate_Grounds9_Div" style="display: none; clear: left;">
                                    <label for="Client_StockInvestments_SoleSeparate_Grounds9">Why does this person own this account solely and separately?</label>
                                    <input id="Client_StockInvestments_SoleSeparate_Grounds9" type="text" class="form-control 9_Client_stocksinvestments_inputs" name="Client_StockInvestments_SoleSeparate_Grounds9" value="<?php if(isset($drstocksinvestments->Client_StockInvestments_SoleSeparate_Grounds9)){ echo $drstocksinvestments->Client_StockInvestments_SoleSeparate_Grounds9; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>How will this account value be distributed between the parties?</label>
                                    <div class="w-100 dataInput">
                                        <label><input type="radio" id="Client_StockInvestments_Disposition_Method9_Distribute_Investments" name="Client_StockInvestments_Disposition_Method9" value="Distribute Investments" data-onload="getInitialDipositionMethod(this, '9', 'Client');" onchange="getDipositionMethod(this, '9', 'Client');" <?php if(isset($drstocksinvestments->Client_StockInvestments_Disposition_Method9) && $drstocksinvestments->Client_StockInvestments_Disposition_Method9=='Distribute Investments'){ echo "checked"; } ?>> Distribute Investments</label>
                                        <label><input type="radio" id="Client_StockInvestments_Disposition_Method9_Liquidate_Split_Net_Value" name="Client_StockInvestments_Disposition_Method9" value="Liquidate/Split Net Value" data-onload="getInitialDipositionMethod(this, '9', 'Client');" onchange="getDipositionMethod(this, '9', 'Client');" <?php if(isset($drstocksinvestments->Client_StockInvestments_Disposition_Method9) && $drstocksinvestments->Client_StockInvestments_Disposition_Method9=='Liquidate/Split Net Value'){ echo "checked"; } ?>> Liquidate/Split Net Value</label>
                                        <label><input type="radio" id="Client_StockInvestments_Disposition_Method9_Percentage_Buyout" name="Client_StockInvestments_Disposition_Method9" value="Percentage Buyout" data-onload="getInitialDipositionMethod(this, '9', 'Client');" onchange="getDipositionMethod(this, '9', 'Client');" <?php if(isset($drstocksinvestments->Client_StockInvestments_Disposition_Method9) && $drstocksinvestments->Client_StockInvestments_Disposition_Method9=='Percentage Buyout'){ echo "checked"; } ?>> Percentage Buyout</label>
                                        <label><input type="radio" id="Client_StockInvestments_Disposition_Method9_Fixed Buyout" name="Client_StockInvestments_Disposition_Method9" value="Fixed Buyout" data-onload="getInitialDipositionMethod(this, '9', 'Client');" onchange="getDipositionMethod(this, '9', 'Client');" <?php if(isset($drstocksinvestments->Client_StockInvestments_Disposition_Method9) && $drstocksinvestments->Client_StockInvestments_Disposition_Method9=='Fixed Buyout'){ echo "checked"; } ?>> Fixed Buyout</label>
                                    </div>
                                </div>
                                <!-- slider tool -->
                                <div class="form-group col-sm-6 m-auto 9_Client_Slider_Tool slider-tool-main">
                                    <div class="row">
                                        <div class="col">{{$client_name}}</div>
                                        <div class="col text-right">{{$opponent_name}}</div>
                                    </div>
                                    <input id="9_Client_balance_range_selector" type="range" class="form-control slider-tool-input 9_Client_balance_range_selector" name="" value="<?php if(isset($drstocksinvestments->Client_StockInvestments_Percent_Marital_Equity_to_Op9)){ echo $drstocksinvestments->Client_StockInvestments_Percent_Marital_Equity_to_Op9; } ?>" min="0.00" step="0.01" max="100" onchange="updateBalanceInput(this.value, '9', 'Client');">
                                </div>
                                <div class="form-group col-sm-6 m-auto 9_Client_Slider_Tool slider-tool-main">
                                    <div class="row justify-content-between">
                                        <div class="col selectorTool">
                                            <div class="left-col">
                                                <div class="client-info 9_Client_clientpercentage_div clientpercentage_div">
                                                    <?php if(isset($drstocksinvestments->Client_StockInvestments_Percent_Marital_Equity_to_Client9)){ echo $drstocksinvestments->Client_StockInvestments_Percent_Marital_Equity_to_Client9; } else {
                                                        echo "50.00";
                                                    } ?>%
                                                </div>
                                                <div class="client-info 9_Client_clientamount_div clientamount_div" style="clear: both;">
                                                    $<?php if(isset($drstocksinvestments->Client_StockInvestments_Estimated_Value_to_Client9)){ echo $drstocksinvestments->Client_StockInvestments_Estimated_Value_to_Client9; }else {
                                                        echo "0.00";
                                                    } ?>
                                                </div>
                                            </div>
                                            <label>To {{$client_name}}</label>
                                        </div>                                       
                                        <div class="col selectorTool selectorToolRight">
                                            <label>To {{$opponent_name}}</label>
                                            <div class="left-col right-col">
                                                <div class="client-info 9_Client_opponentpercentage_div opponentpercentage_div">
                                                    <?php if(isset($drstocksinvestments->Client_StockInvestments_Percent_Marital_Equity_to_Op9)){ echo $drstocksinvestments->Client_StockInvestments_Percent_Marital_Equity_to_Op9; } else {
                                                        echo "50.00";
                                                    } ?>%
                                                </div>
                                                <div class="client-info 9_Client_opponentamount_div opponentamount_div" style="clear: both;">
                                                    $<?php if(isset($drstocksinvestments->Client_StockInvestments_Estimated_Value_to_Op9)){ echo $drstocksinvestments->Client_StockInvestments_Estimated_Value_to_Op9; }else {
                                                        echo "0.00";
                                                    } ?>
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
                                         <label><input type="radio" id="Client_StockInvestments_Paying_Party9_Client" name="Client_StockInvestments_Paying_Party9" value="{{$client_name}}" data-onload="getInitialStockInvestmentPayingParty(this, '9', 'Client');" onchange="getStockInvestmentPayingParty(this, '9', 'Client');"  <?php if(isset($drstocksinvestments->Client_StockInvestments_Paying_Party9) && $drstocksinvestments->Client_StockInvestments_Paying_Party9==$client_name){ echo "checked"; } ?>> {{$client_name}}</label>
                                        <label><input type="radio" id="Client_StockInvestments_Paying_Party9_Op" name="Client_StockInvestments_Paying_Party9" value="{{$opponent_name}}" data-onload="getInitialStockInvestmentPayingParty(this, '9', 'Client');" onchange="getStockInvestmentPayingParty(this, '9', 'Client');"  <?php if(isset($drstocksinvestments->Client_StockInvestments_Paying_Party9) && $drstocksinvestments->Client_StockInvestments_Paying_Party9==$opponent_name){ echo "checked"; } ?>> {{$opponent_name}}</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 Client_StockInvestments_Paying_Party9_Inputs_Div" style="display: none;">
                                    <label>{{$client_name}} StockInvestment Equity Percent</label>
                                    <input id="Client_StockInvestments_Percent_Marital_Equity_to_Client9" type="number" class="form-control 9_Client_clientpercentage_input clientpercentage_input" name="Client_StockInvestments_Percent_Marital_Equity_to_Client9" value="<?php if(isset($drstocksinvestments->Client_StockInvestments_Percent_Marital_Equity_to_Client9)){ echo $drstocksinvestments->Client_StockInvestments_Percent_Marital_Equity_to_Client9; } ?>" min="0.00" step="0.01" max="100" readonly="">
                                </div>
                                <div class="form-group col-sm-6 Client_StockInvestments_Paying_Party9_Inputs_Div" style="display: none;">
                                    <label>How much is to be paid to {{$client_name}}?</label>
                                    <input id="Client_StockInvestments_Estimated_Value_to_Client9" type="number" class="form-control 9_Client_clientamount_input clientamount_input" name="Client_StockInvestments_Estimated_Value_to_Client9" value="<?php if(isset($drstocksinvestments->Client_StockInvestments_Estimated_Value_to_Client9)){ echo $drstocksinvestments->Client_StockInvestments_Estimated_Value_to_Client9; } ?>" min="0.00" step="0.01" max="999999.99" readonly="" onchange="getEstimatedValueClient(this, '9', 'Client');" onkeyup="getEstimatedValueClient(this, '9', 'Client');">
                                </div>
                                <div class="form-group col-sm-6 Client_StockInvestments_Paying_Party9_Inputs_Div" style="display: none;">
                                    <label>{{$opponent_name}} StockInvestment Equity Percent</label>
                                    <input id="Client_StockInvestments_Percent_Marital_Equity_to_Op9" type="number" class="form-control 9_Client_opponentpercentage_input opponentpercentage_input" name="Client_StockInvestments_Percent_Marital_Equity_to_Op9" value="<?php if(isset($drstocksinvestments->Client_StockInvestments_Percent_Marital_Equity_to_Op9)){ echo $drstocksinvestments->Client_StockInvestments_Percent_Marital_Equity_to_Op9; } ?>" min="0.00" step="0.01" max="100" readonly="">
                                </div>
                                <div class="form-group col-sm-6 Client_StockInvestments_Paying_Party9_Inputs_Div" style="display: none;">
                                    <label>How much is to be paid to {{$opponent_name}}?</label>
                                    <input id="Client_StockInvestments_Estimated_Value_to_Op9" type="number" class="form-control 9_Client_opponentamount_input opponentamount_input" name="Client_StockInvestments_Estimated_Value_to_Op9" value="<?php if(isset($drstocksinvestments->Client_StockInvestments_Estimated_Value_to_Op9)){ echo $drstocksinvestments->Client_StockInvestments_Estimated_Value_to_Op9; } ?>" min="0.00" step="0.01" max="999999.99" readonly="" onchange="getEstimatedValueOp(this, '9', 'Client');" onkeyup="getEstimatedValueOp(this, '9', 'Client');">
                                </div>
                                <!-- end of slider tool -->
                            </div>
                            <div class="col-sm-12 mt-4 10_Client_stocksinvestments_section" style="display: none;"><h5 class="col-sm-12">Tenth Stock Investment Info</h5>
                                <div class="form-group col-sm-6">
                                    <p class="text-danger 10_Client_no-state-county-found" style="display: none;">No City, State, County found for this zipcode.</p>
                                    <label for="Client_StockInvestments_Institution_ZIP10">Stock/Investment Institution Zip Code?</label>
                                    <input id="Client_StockInvestments_Institution_ZIP10" type="text" class="form-control 10_Client_stocksinvestments_inputs" name="Client_StockInvestments_Institution_ZIP10" value="<?php if(isset($drstocksinvestments->Client_StockInvestments_Institution_ZIP10)){ echo $drstocksinvestments->Client_StockInvestments_Institution_ZIP10; } ?>" data-onload="getCityStateForZip(this, '10', 'Client');" onkeyup="getCityStateForZip(this, '10', 'Client');"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_StockInvestments_Institution_Name10">Name of Stock/Investment Institution?</label>
                                    <input id="Client_StockInvestments_Institution_Name10" type="text" class="form-control 10_Client_stocksinvestments_inputs" name="Client_StockInvestments_Institution_Name10" value="<?php if(isset($drstocksinvestments->Client_StockInvestments_Institution_Name10)){ echo $drstocksinvestments->Client_StockInvestments_Institution_Name10; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_StockInvestments_Institution_Street_Address10">Stock/Investment Institution Street Address?</label>
                                    <input id="Client_StockInvestments_Institution_Street_Address10" type="text" class="form-control 10_Client_stocksinvestments_inputs" name="Client_StockInvestments_Institution_Street_Address10" value="<?php if(isset($drstocksinvestments->Client_StockInvestments_Institution_Street_Address10)){ echo $drstocksinvestments->Client_StockInvestments_Institution_Street_Address10; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_StockInvestments_Institution_City10">Stock/Investment Institution City?</label>
                                    <input type="hidden" name="" id="Client_StockInvestments_Institution_City10_Value" value="<?php if(isset($drstocksinvestments->Client_StockInvestments_Institution_City10)){ echo $drstocksinvestments->Client_StockInvestments_Institution_City10; } ?>">
                                    <select id="Client_StockInvestments_Institution_City10" name="Client_StockInvestments_Institution_City10" class="form-control 10_Client_city_select">
                                        <option value="">Choose City</option>
                                    </select>   
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_StockInvestments_Institution_State10">Stock/Investment Institution State?</label>
                                    <input type="hidden" name="" id="Client_StockInvestments_Institution_State10_Value" value="<?php if(isset($drstocksinvestments->Client_StockInvestments_Institution_State10)){ echo $drstocksinvestments->Client_StockInvestments_Institution_State10; } ?>">
                                    <select id="Client_StockInvestments_Institution_State10" name="Client_StockInvestments_Institution_State10" class="form-control 10_Client_state_select">
                                        <option value="">Choose State</option>
                                    </select>   
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_StockInvestments_Acct_Num10">Account Number?</label>
                                    <input id="Client_StockInvestments_Acct_Num10" type="text" class="form-control 10_Client_stocksinvestments_inputs" name="Client_StockInvestments_Acct_Num10" value="<?php if(isset($drstocksinvestments->Client_StockInvestments_Acct_Num10)){ echo $drstocksinvestments->Client_StockInvestments_Acct_Num10; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_StockInvestments_Date_Marriage_Value10">Marriage Date Value?</label>
                                    <input id="Client_StockInvestments_Date_Marriage_Value10" type="number" class="form-control 10_Client_stocksinvestments_inputs" name="Client_StockInvestments_Date_Marriage_Value10" value="<?php if(isset($drstocksinvestments->Client_StockInvestments_Date_Marriage_Value10)){ echo $drstocksinvestments->Client_StockInvestments_Date_Marriage_Value10; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_StockInvestments_Current_Value10">Current Value?</label>
                                    <input id="Client_StockInvestments_Current_Value10" type="number" class="form-control 10_Client_stocksinvestments_inputs" name="Client_StockInvestments_Current_Value10" value="<?php if(isset($drstocksinvestments->Client_StockInvestments_Current_Value10)){ echo $drstocksinvestments->Client_StockInvestments_Current_Value10; } ?>" min="0.00" step="0.01" max="999999.99" onchange="getJointCurrentValue(this, '10', 'Client');" onkeyup="getJointCurrentValue(this, '10', 'Client');"> 
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label for="Client_StockInvestments_Percent_Marital_Equity10">N/A, calculated = Client_StockInvestments_Institution_Current_Value10</label>
                                    <input id="Client_StockInvestments_Percent_Marital_Equity10" type="number" class="form-control 10_Client_stocksinvestments_inputs" name="Client_StockInvestments_Percent_Marital_Equity10" value="<?php if(isset($drstocksinvestments->Client_StockInvestments_Percent_Marital_Equity10)){ echo $drstocksinvestments->Client_StockInvestments_Percent_Marital_Equity10; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_StockInvestments_Yearly_Interest_Dividend10">Yearly Interest and Dividends from this account?</label>
                                    <input id="Client_StockInvestments_Yearly_Interest_Dividend10" type="number" class="form-control 10_Client_stocksinvestments_inputs" name="Client_StockInvestments_Yearly_Interest_Dividend10" value="<?php if(isset($drstocksinvestments->Client_StockInvestments_Yearly_Interest_Dividend10)){ echo $drstocksinvestments->Client_StockInvestments_Yearly_Interest_Dividend10; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Does either party claim a sole/separate interest from the other on this account?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Client_StockInvestments_SoleSeparate_Claim10_Yes" name="Client_StockInvestments_SoleSeparate_Claim10" value="Yes" data-onload="getInitialPartyClaimSoleSeparate(this, '10', 'Client');" onchange="getPartyClaimSoleSeparate(this, '10', 'Client');" <?php if(isset($drstocksinvestments->Client_StockInvestments_SoleSeparate_Claim10) && $drstocksinvestments->Client_StockInvestments_SoleSeparate_Claim10=='Yes'){ echo "checked"; } ?>> Yes</label>
                                        <label><input type="radio" id="Client_StockInvestments_SoleSeparate_Claim10_No" name="Client_StockInvestments_SoleSeparate_Claim10" value="No" data-onload="getInitialPartyClaimSoleSeparate(this, '10', 'Client');" onchange="getPartyClaimSoleSeparate(this, '10', 'Client');" <?php if(isset($drstocksinvestments->Client_StockInvestments_SoleSeparate_Claim10) && $drstocksinvestments->Client_StockInvestments_SoleSeparate_Claim10=='No'){ echo "checked"; } ?>> No</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6" id="Client_StockInvestments_SoleSeparate_Party10_Div" style="display: none;">
                                    <label>Who claims to own this account?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Client_StockInvestments_SoleSeparate_Party10_Client" name="Client_StockInvestments_SoleSeparate_Party10" value="{{$client_name}}" <?php if(isset($drstocksinvestments->Client_StockInvestments_SoleSeparate_Party10) && $drstocksinvestments->Client_StockInvestments_SoleSeparate_Party10==$client_name){ echo "checked"; } ?>> {{$client_name}}</label>
                                        <label><input type="radio" id="Client_StockInvestments_SoleSeparate_Party10_Op" name="Client_StockInvestments_SoleSeparate_Party10" value="{{$opponent_name}}" <?php if(isset($drstocksinvestments->Client_StockInvestments_SoleSeparate_Party10) && $drstocksinvestments->Client_StockInvestments_SoleSeparate_Party10==$opponent_name){ echo "checked"; } ?>> {{$opponent_name}}</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 left-clear" id="Client_StockInvestments_SoleSeparate_Grounds10_Div" style="display: none; clear: left;">
                                    <label for="Client_StockInvestments_SoleSeparate_Grounds10">Why does this person own this account solely and separately?</label>
                                    <input id="Client_StockInvestments_SoleSeparate_Grounds10" type="text" class="form-control 10_Client_stocksinvestments_inputs" name="Client_StockInvestments_SoleSeparate_Grounds10" value="<?php if(isset($drstocksinvestments->Client_StockInvestments_SoleSeparate_Grounds10)){ echo $drstocksinvestments->Client_StockInvestments_SoleSeparate_Grounds10; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>How will this account value be distributed between the parties?</label>
                                    <div class="w-100 dataInput">
                                        <label><input type="radio" id="Client_StockInvestments_Disposition_Method10_Distribute_Investments" name="Client_StockInvestments_Disposition_Method10" value="Distribute Investments" data-onload="getInitialDipositionMethod(this, '10', 'Client');" onchange="getDipositionMethod(this, '10', 'Client');" <?php if(isset($drstocksinvestments->Client_StockInvestments_Disposition_Method10) && $drstocksinvestments->Client_StockInvestments_Disposition_Method10=='Distribute Investments'){ echo "checked"; } ?>> Distribute Investments</label>
                                        <label><input type="radio" id="Client_StockInvestments_Disposition_Method10_Liquidate_Split_Net_Value" name="Client_StockInvestments_Disposition_Method10" value="Liquidate/Split Net Value" data-onload="getInitialDipositionMethod(this, '10', 'Client');" onchange="getDipositionMethod(this, '10', 'Client');" <?php if(isset($drstocksinvestments->Client_StockInvestments_Disposition_Method10) && $drstocksinvestments->Client_StockInvestments_Disposition_Method10=='Liquidate/Split Net Value'){ echo "checked"; } ?>> Liquidate/Split Net Value</label>
                                        <label><input type="radio" id="Client_StockInvestments_Disposition_Method10_Percentage_Buyout" name="Client_StockInvestments_Disposition_Method10" value="Percentage Buyout" data-onload="getInitialDipositionMethod(this, '10', 'Client');" onchange="getDipositionMethod(this, '10', 'Client');" <?php if(isset($drstocksinvestments->Client_StockInvestments_Disposition_Method10) && $drstocksinvestments->Client_StockInvestments_Disposition_Method10=='Percentage Buyout'){ echo "checked"; } ?>> Percentage Buyout</label>
                                        <label><input type="radio" id="Client_StockInvestments_Disposition_Method10_Fixed Buyout" name="Client_StockInvestments_Disposition_Method10" value="Fixed Buyout" data-onload="getInitialDipositionMethod(this, '10', 'Client');" onchange="getDipositionMethod(this, '10', 'Client');" <?php if(isset($drstocksinvestments->Client_StockInvestments_Disposition_Method10) && $drstocksinvestments->Client_StockInvestments_Disposition_Method10=='Fixed Buyout'){ echo "checked"; } ?>> Fixed Buyout</label>
                                    </div>
                                </div>
                                <!-- slider tool -->
                                <div class="form-group col-sm-6 m-auto 10_Client_Slider_Tool slider-tool-main">
                                    <div class="row">
                                        <div class="col">{{$client_name}}</div>
                                        <div class="col text-right">{{$opponent_name}}</div>
                                    </div>
                                    <input id="10_Client_balance_range_selector" type="range" class="form-control slider-tool-input 10_Client_balance_range_selector" name="" value="<?php if(isset($drstocksinvestments->Client_StockInvestments_Percent_Marital_Equity_to_Op10)){ echo $drstocksinvestments->Client_StockInvestments_Percent_Marital_Equity_to_Op10; } ?>" min="0.00" step="0.01" max="100" onchange="updateBalanceInput(this.value, '10', 'Client');">
                                </div>
                                <div class="form-group col-sm-6 m-auto 10_Client_Slider_Tool slider-tool-main">
                                    <div class="row justify-content-between">
                                        <div class="col selectorTool">
                                            <div class="left-col">
                                                <div class="client-info 10_Client_clientpercentage_div clientpercentage_div">
                                                    <?php if(isset($drstocksinvestments->Client_StockInvestments_Percent_Marital_Equity_to_Client10)){ echo $drstocksinvestments->Client_StockInvestments_Percent_Marital_Equity_to_Client10; } else {
                                                        echo "50.00";
                                                    } ?>%
                                                </div>
                                                <div class="client-info 10_Client_clientamount_div clientamount_div" style="clear: both;">
                                                    $<?php if(isset($drstocksinvestments->Client_StockInvestments_Estimated_Value_to_Client10)){ echo $drstocksinvestments->Client_StockInvestments_Estimated_Value_to_Client10; }else {
                                                        echo "0.00";
                                                    } ?>
                                                </div>
                                            </div>
                                            <label>To {{$client_name}}</label>
                                        </div>                                       
                                        <div class="col selectorTool selectorToolRight">
                                            <label>To {{$opponent_name}}</label>
                                            <div class="left-col right-col">
                                                <div class="client-info 10_Client_opponentpercentage_div opponentpercentage_div">
                                                    <?php if(isset($drstocksinvestments->Client_StockInvestments_Percent_Marital_Equity_to_Op10)){ echo $drstocksinvestments->Client_StockInvestments_Percent_Marital_Equity_to_Op10; } else {
                                                        echo "50.00";
                                                    } ?>%
                                                </div>
                                                <div class="client-info 10_Client_opponentamount_div opponentamount_div" style="clear: both;">
                                                    $<?php if(isset($drstocksinvestments->Client_StockInvestments_Estimated_Value_to_Op10)){ echo $drstocksinvestments->Client_StockInvestments_Estimated_Value_to_Op10; }else {
                                                        echo "0.00";
                                                    } ?>
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
                                         <label><input type="radio" id="Client_StockInvestments_Paying_Party10_Client" name="Client_StockInvestments_Paying_Party10" value="{{$client_name}}" data-onload="getInitialStockInvestmentPayingParty(this, '10', 'Client');" onchange="getStockInvestmentPayingParty(this, '10', 'Client');"  <?php if(isset($drstocksinvestments->Client_StockInvestments_Paying_Party10) && $drstocksinvestments->Client_StockInvestments_Paying_Party10==$client_name){ echo "checked"; } ?>> {{$client_name}}</label>
                                        <label><input type="radio" id="Client_StockInvestments_Paying_Party10_Op" name="Client_StockInvestments_Paying_Party10" value="{{$opponent_name}}" data-onload="getInitialStockInvestmentPayingParty(this, '10', 'Client');" onchange="getStockInvestmentPayingParty(this, '10', 'Client');"  <?php if(isset($drstocksinvestments->Client_StockInvestments_Paying_Party10) && $drstocksinvestments->Client_StockInvestments_Paying_Party10==$opponent_name){ echo "checked"; } ?>> {{$opponent_name}}</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 Client_StockInvestments_Paying_Party10_Inputs_Div" style="display: none;">
                                    <label>{{$client_name}} StockInvestment Equity Percent</label>
                                    <input id="Client_StockInvestments_Percent_Marital_Equity_to_Client10" type="number" class="form-control 10_Client_clientpercentage_input clientpercentage_input" name="Client_StockInvestments_Percent_Marital_Equity_to_Client10" value="<?php if(isset($drstocksinvestments->Client_StockInvestments_Percent_Marital_Equity_to_Client10)){ echo $drstocksinvestments->Client_StockInvestments_Percent_Marital_Equity_to_Client10; } ?>" min="0.00" step="0.01" max="100" readonly="">
                                </div>
                                <div class="form-group col-sm-6 Client_StockInvestments_Paying_Party10_Inputs_Div" style="display: none;">
                                    <label>How much is to be paid to {{$client_name}}?</label>
                                    <input id="Client_StockInvestments_Estimated_Value_to_Client10" type="number" class="form-control 10_Client_clientamount_input clientamount_input" name="Client_StockInvestments_Estimated_Value_to_Client10" value="<?php if(isset($drstocksinvestments->Client_StockInvestments_Estimated_Value_to_Client10)){ echo $drstocksinvestments->Client_StockInvestments_Estimated_Value_to_Client10; } ?>" min="0.00" step="0.01" max="999999.99" readonly="" onchange="getEstimatedValueClient(this, '10', 'Client');" onkeyup="getEstimatedValueClient(this, '10', 'Client');">
                                </div>
                                <div class="form-group col-sm-6 Client_StockInvestments_Paying_Party10_Inputs_Div" style="display: none;">
                                    <label>{{$opponent_name}} StockInvestment Equity Percent</label>
                                    <input id="Client_StockInvestments_Percent_Marital_Equity_to_Op10" type="number" class="form-control 10_Client_opponentpercentage_input opponentpercentage_input" name="Client_StockInvestments_Percent_Marital_Equity_to_Op10" value="<?php if(isset($drstocksinvestments->Client_StockInvestments_Percent_Marital_Equity_to_Op10)){ echo $drstocksinvestments->Client_StockInvestments_Percent_Marital_Equity_to_Op10; } ?>" min="0.00" step="0.01" max="100" readonly="">
                                </div>
                                <div class="form-group col-sm-6 Client_StockInvestments_Paying_Party10_Inputs_Div" style="display: none;">
                                    <label>How much is to be paid to {{$opponent_name}}?</label>
                                    <input id="Client_StockInvestments_Estimated_Value_to_Op10" type="number" class="form-control 10_Client_opponentamount_input opponentamount_input" name="Client_StockInvestments_Estimated_Value_to_Op10" value="<?php if(isset($drstocksinvestments->Client_StockInvestments_Estimated_Value_to_Op10)){ echo $drstocksinvestments->Client_StockInvestments_Estimated_Value_to_Op10; } ?>" min="0.00" step="0.01" max="999999.99" readonly="" onchange="getEstimatedValueOp(this, '10', 'Client');" onkeyup="getEstimatedValueOp(this, '10', 'Client');">
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
                                <input id="Num_Op_StockInvestments_Accounts" type="number" class="form-control" name="Num_Op_StockInvestments_Accounts" value="<?php if(isset($drstocksinvestments->Num_Op_StockInvestments_Accounts)){ echo $drstocksinvestments->Num_Op_StockInvestments_Accounts; } ?>" min="0" max="10"> 
                            </div>
                        </div>
                        <div class="form-row Opponent_stocksinvestments_section">
                            <div class="col-sm-12 mt-4 1_Op_stocksinvestments_section" style="display: none;"><h5 class="col-sm-12">First Stock Investment Info</h5>
                                <div class="form-group col-sm-6">
                                    <p class="text-danger 1_Op_no-state-county-found" style="display: none;">No City, State, County found for this zipcode.</p>
                                    <label for="Op_StockInvestments_Institution_ZIP1">Stock/Investment Institution Zip Code?</label>
                                    <input id="Op_StockInvestments_Institution_ZIP1" type="text" class="form-control 1_Op_stocksinvestments_inputs" name="Op_StockInvestments_Institution_ZIP1" value="<?php if(isset($drstocksinvestments->Op_StockInvestments_Institution_ZIP1)){ echo $drstocksinvestments->Op_StockInvestments_Institution_ZIP1; } ?>" data-onload="getCityStateForZip(this, '1', 'Op');" onkeyup="getCityStateForZip(this, '1', 'Op');"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_StockInvestments_Institution_Name1">Name of Stock/Investment Institution?</label>
                                    <input id="Op_StockInvestments_Institution_Name1" type="text" class="form-control 1_Op_stocksinvestments_inputs" name="Op_StockInvestments_Institution_Name1" value="<?php if(isset($drstocksinvestments->Op_StockInvestments_Institution_Name1)){ echo $drstocksinvestments->Op_StockInvestments_Institution_Name1; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_StockInvestments_Institution_Street_Address1">Stock/Investment Institution Street Address?</label>
                                    <input id="Op_StockInvestments_Institution_Street_Address1" type="text" class="form-control 1_Op_stocksinvestments_inputs" name="Op_StockInvestments_Institution_Street_Address1" value="<?php if(isset($drstocksinvestments->Op_StockInvestments_Institution_Street_Address1)){ echo $drstocksinvestments->Op_StockInvestments_Institution_Street_Address1; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_StockInvestments_Institution_City1">Stock/Investment Institution City?</label>
                                    <input type="hidden" name="" id="Op_StockInvestments_Institution_City1_Value" value="<?php if(isset($drstocksinvestments->Op_StockInvestments_Institution_City1)){ echo $drstocksinvestments->Op_StockInvestments_Institution_City1; } ?>">
                                    <select id="Op_StockInvestments_Institution_City1" name="Op_StockInvestments_Institution_City1" class="form-control 1_Op_city_select">
                                        <option value="">Choose City</option>
                                    </select>   
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_StockInvestments_Institution_State1">Stock/Investment Institution State?</label>
                                    <input type="hidden" name="" id="Op_StockInvestments_Institution_State1_Value" value="<?php if(isset($drstocksinvestments->Op_StockInvestments_Institution_State1)){ echo $drstocksinvestments->Op_StockInvestments_Institution_State1; } ?>">
                                    <select id="Op_StockInvestments_Institution_State1" name="Op_StockInvestments_Institution_State1" class="form-control 1_Op_state_select">
                                        <option value="">Choose State</option>
                                    </select>   
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_StockInvestments_Acct_Num1">Account Number?</label>
                                    <input id="Op_StockInvestments_Acct_Num1" type="text" class="form-control 1_Op_stocksinvestments_inputs" name="Op_StockInvestments_Acct_Num1" value="<?php if(isset($drstocksinvestments->Op_StockInvestments_Acct_Num1)){ echo $drstocksinvestments->Op_StockInvestments_Acct_Num1; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_StockInvestments_Date_Marriage_Value1">Marriage Date Value?</label>
                                    <input id="Op_StockInvestments_Date_Marriage_Value1" type="number" class="form-control 1_Op_stocksinvestments_inputs" name="Op_StockInvestments_Date_Marriage_Value1" value="<?php if(isset($drstocksinvestments->Op_StockInvestments_Date_Marriage_Value1)){ echo $drstocksinvestments->Op_StockInvestments_Date_Marriage_Value1; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_StockInvestments_Current_Value1">Current Value?</label>
                                    <input id="Op_StockInvestments_Current_Value1" type="number" class="form-control 1_Op_stocksinvestments_inputs" name="Op_StockInvestments_Current_Value1" value="<?php if(isset($drstocksinvestments->Op_StockInvestments_Current_Value1)){ echo $drstocksinvestments->Op_StockInvestments_Current_Value1; } ?>" min="0.00" step="0.01" max="999999.99" onchange="getJointCurrentValue(this, '1', 'Op');" onkeyup="getJointCurrentValue(this, '1', 'Op');"> 
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label for="Op_StockInvestments_Percent_Marital_Equity1">N/A, calculated = Op_StockInvestments_Institution_Current_Value1</label>
                                    <input id="Op_StockInvestments_Percent_Marital_Equity1" type="number" class="form-control 1_Op_stocksinvestments_inputs" name="Op_StockInvestments_Percent_Marital_Equity1" value="<?php if(isset($drstocksinvestments->Op_StockInvestments_Percent_Marital_Equity1)){ echo $drstocksinvestments->Op_StockInvestments_Percent_Marital_Equity1; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_StockInvestments_Yearly_Interest_Dividend1">Yearly Interest and Dividends from this account?</label>
                                    <input id="Op_StockInvestments_Yearly_Interest_Dividend1" type="number" class="form-control 1_Op_stocksinvestments_inputs" name="Op_StockInvestments_Yearly_Interest_Dividend1" value="<?php if(isset($drstocksinvestments->Op_StockInvestments_Yearly_Interest_Dividend1)){ echo $drstocksinvestments->Op_StockInvestments_Yearly_Interest_Dividend1; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Does either party claim a sole/separate interest from the other on this account?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Op_StockInvestments_SoleSeparate_Claim1_Yes" name="Op_StockInvestments_SoleSeparate_Claim1" value="Yes" data-onload="getInitialPartyClaimSoleSeparate(this, '1', 'Op');" onchange="getPartyClaimSoleSeparate(this, '1', 'Op');" <?php if(isset($drstocksinvestments->Op_StockInvestments_SoleSeparate_Claim1) && $drstocksinvestments->Op_StockInvestments_SoleSeparate_Claim1=='Yes'){ echo "checked"; } ?>> Yes</label>
                                        <label><input type="radio" id="Op_StockInvestments_SoleSeparate_Claim1_No" name="Op_StockInvestments_SoleSeparate_Claim1" value="No" data-onload="getInitialPartyClaimSoleSeparate(this, '1', 'Op');" onchange="getPartyClaimSoleSeparate(this, '1', 'Op');" <?php if(isset($drstocksinvestments->Op_StockInvestments_SoleSeparate_Claim1) && $drstocksinvestments->Op_StockInvestments_SoleSeparate_Claim1=='No'){ echo "checked"; } ?>> No</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6" id="Op_StockInvestments_SoleSeparate_Party1_Div" style="display: none;">
                                    <label>Who claims to own this account?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Op_StockInvestments_SoleSeparate_Party1_Client" name="Op_StockInvestments_SoleSeparate_Party1" value="{{$client_name}}" <?php if(isset($drstocksinvestments->Op_StockInvestments_SoleSeparate_Party1) && $drstocksinvestments->Op_StockInvestments_SoleSeparate_Party1==$client_name){ echo "checked"; } ?>> {{$client_name}}</label>
                                        <label><input type="radio" id="Op_StockInvestments_SoleSeparate_Party1_Op" name="Op_StockInvestments_SoleSeparate_Party1" value="{{$opponent_name}}" <?php if(isset($drstocksinvestments->Op_StockInvestments_SoleSeparate_Party1) && $drstocksinvestments->Op_StockInvestments_SoleSeparate_Party1==$opponent_name){ echo "checked"; } ?>> {{$opponent_name}}</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 left-clear" id="Op_StockInvestments_SoleSeparate_Grounds1_Div" style="display: none; clear: left;">
                                    <label for="Op_StockInvestments_SoleSeparate_Grounds1">Why does this person own this account solely and separately?</label>
                                    <input id="Op_StockInvestments_SoleSeparate_Grounds1" type="text" class="form-control 1_Op_stocksinvestments_inputs" name="Op_StockInvestments_SoleSeparate_Grounds1" value="<?php if(isset($drstocksinvestments->Op_StockInvestments_SoleSeparate_Grounds1)){ echo $drstocksinvestments->Op_StockInvestments_SoleSeparate_Grounds1; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>How will this account value be distributed between the parties?</label>
                                    <div class="w-100 dataInput">
                                        <label><input type="radio" id="Op_StockInvestments_Disposition_Method1_Distribute_Investments" name="Op_StockInvestments_Disposition_Method1" value="Distribute Investments" data-onload="getInitialDipositionMethod(this, '1', 'Op');" onchange="getDipositionMethod(this, '1', 'Op');" <?php if(isset($drstocksinvestments->Op_StockInvestments_Disposition_Method1) && $drstocksinvestments->Op_StockInvestments_Disposition_Method1=='Distribute Investments'){ echo "checked"; } ?>> Distribute Investments</label>
                                        <label><input type="radio" id="Op_StockInvestments_Disposition_Method1_Liquidate_Split_Net_Value" name="Op_StockInvestments_Disposition_Method1" value="Liquidate/Split Net Value" data-onload="getInitialDipositionMethod(this, '1', 'Op');" onchange="getDipositionMethod(this, '1', 'Op');" <?php if(isset($drstocksinvestments->Op_StockInvestments_Disposition_Method1) && $drstocksinvestments->Op_StockInvestments_Disposition_Method1=='Liquidate/Split Net Value'){ echo "checked"; } ?>> Liquidate/Split Net Value</label>
                                        <label><input type="radio" id="Op_StockInvestments_Disposition_Method1_Percentage_Buyout" name="Op_StockInvestments_Disposition_Method1" value="Percentage Buyout" data-onload="getInitialDipositionMethod(this, '1', 'Op');" onchange="getDipositionMethod(this, '1', 'Op');" <?php if(isset($drstocksinvestments->Op_StockInvestments_Disposition_Method1) && $drstocksinvestments->Op_StockInvestments_Disposition_Method1=='Percentage Buyout'){ echo "checked"; } ?>> Percentage Buyout</label>
                                        <label><input type="radio" id="Op_StockInvestments_Disposition_Method1_Fixed Buyout" name="Op_StockInvestments_Disposition_Method1" value="Fixed Buyout" data-onload="getInitialDipositionMethod(this, '1', 'Op');" onchange="getDipositionMethod(this, '1', 'Op');" <?php if(isset($drstocksinvestments->Op_StockInvestments_Disposition_Method1) && $drstocksinvestments->Op_StockInvestments_Disposition_Method1=='Fixed Buyout'){ echo "checked"; } ?>> Fixed Buyout</label>
                                    </div>
                                </div>
                                <!-- slider tool -->
                                <div class="form-group col-sm-6 m-auto 1_Op_Slider_Tool slider-tool-main">
                                    <div class="row">
                                        <div class="col">{{$client_name}}</div>
                                        <div class="col text-right">{{$opponent_name}}</div>
                                    </div>
                                    <input id="1_Op_balance_range_selector" type="range" class="form-control slider-tool-input 1_Op_balance_range_selector" name="" value="<?php if(isset($drstocksinvestments->Op_StockInvestments_Percent_Marital_Equity_to_Op1)){ echo $drstocksinvestments->Op_StockInvestments_Percent_Marital_Equity_to_Op1; } ?>" min="0.00" step="0.01" max="100" onchange="updateBalanceInput(this.value, '1', 'Op');">
                                </div>
                                <div class="form-group col-sm-6 m-auto 1_Op_Slider_Tool slider-tool-main">
                                    <div class="row justify-content-between">
                                        <div class="col selectorTool">
                                            <div class="left-col">
                                                <div class="client-info 1_Op_clientpercentage_div clientpercentage_div">
                                                    <?php if(isset($drstocksinvestments->Op_StockInvestments_Percent_Marital_Equity_to_Client1)){ echo $drstocksinvestments->Op_StockInvestments_Percent_Marital_Equity_to_Client1; } else {
                                                        echo "50.00";
                                                    } ?>%
                                                </div>
                                                <div class="client-info 1_Op_clientamount_div clientamount_div" style="clear: both;">
                                                    $<?php if(isset($drstocksinvestments->Op_StockInvestments_Estimated_Value_to_Client1)){ echo $drstocksinvestments->Op_StockInvestments_Estimated_Value_to_Client1; }else {
                                                        echo "0.00";
                                                    } ?>
                                                </div>
                                            </div>
                                            <label>To {{$client_name}}</label>
                                        </div>                                       
                                        <div class="col selectorTool selectorToolRight">
                                            <label>To {{$opponent_name}}</label>
                                            <div class="left-col right-col">
                                                <div class="client-info 1_Op_opponentpercentage_div opponentpercentage_div">
                                                    <?php if(isset($drstocksinvestments->Op_StockInvestments_Percent_Marital_Equity_to_Op1)){ echo $drstocksinvestments->Op_StockInvestments_Percent_Marital_Equity_to_Op1; } else {
                                                        echo "50.00";
                                                    } ?>%
                                                </div>
                                                <div class="client-info 1_Op_opponentamount_div opponentamount_div" style="clear: both;">
                                                    $<?php if(isset($drstocksinvestments->Op_StockInvestments_Estimated_Value_to_Op1)){ echo $drstocksinvestments->Op_StockInvestments_Estimated_Value_to_Op1; }else {
                                                        echo "0.00";
                                                    } ?>
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
                                         <label><input type="radio" id="Op_StockInvestments_Paying_Party1_Client" name="Op_StockInvestments_Paying_Party1" value="{{$client_name}}" data-onload="getInitialStockInvestmentPayingParty(this, '1', 'Op');" onchange="getStockInvestmentPayingParty(this, '1', 'Op');"  <?php if(isset($drstocksinvestments->Op_StockInvestments_Paying_Party1) && $drstocksinvestments->Op_StockInvestments_Paying_Party1==$client_name){ echo "checked"; } ?>> {{$client_name}}</label>
                                        <label><input type="radio" id="Op_StockInvestments_Paying_Party1_Op" name="Op_StockInvestments_Paying_Party1" value="{{$opponent_name}}" data-onload="getInitialStockInvestmentPayingParty(this, '1', 'Op');" onchange="getStockInvestmentPayingParty(this, '1', 'Op');"  <?php if(isset($drstocksinvestments->Op_StockInvestments_Paying_Party1) && $drstocksinvestments->Op_StockInvestments_Paying_Party1==$opponent_name){ echo "checked"; } ?>> {{$opponent_name}}</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 Op_StockInvestments_Paying_Party1_Inputs_Div" style="display: none;">
                                    <label>{{$client_name}} StockInvestment Equity Percent</label>
                                    <input id="Op_StockInvestments_Percent_Marital_Equity_to_Client1" type="number" class="form-control 1_Op_clientpercentage_input clientpercentage_input" name="Op_StockInvestments_Percent_Marital_Equity_to_Client1" value="<?php if(isset($drstocksinvestments->Op_StockInvestments_Percent_Marital_Equity_to_Client1)){ echo $drstocksinvestments->Op_StockInvestments_Percent_Marital_Equity_to_Client1; } ?>" min="0.00" step="0.01" max="100" readonly="">
                                </div>
                                <div class="form-group col-sm-6 Op_StockInvestments_Paying_Party1_Inputs_Div" style="display: none;">
                                    <label>How much is to be paid to {{$client_name}}?</label>
                                    <input id="Op_StockInvestments_Estimated_Value_to_Client1" type="number" class="form-control 1_Op_clientamount_input clientamount_input" name="Op_StockInvestments_Estimated_Value_to_Client1" value="<?php if(isset($drstocksinvestments->Op_StockInvestments_Estimated_Value_to_Client1)){ echo $drstocksinvestments->Op_StockInvestments_Estimated_Value_to_Client1; } ?>" min="0.00" step="0.01" max="999999.99" readonly="" onchange="getEstimatedValueClient(this, '1', 'Op');" onkeyup="getEstimatedValueClient(this, '1', 'Op');">
                                </div>
                                <div class="form-group col-sm-6 Op_StockInvestments_Paying_Party1_Inputs_Div" style="display: none;">
                                    <label>{{$opponent_name}} StockInvestment Equity Percent</label>
                                    <input id="Op_StockInvestments_Percent_Marital_Equity_to_Op1" type="number" class="form-control 1_Op_opponentpercentage_input opponentpercentage_input" name="Op_StockInvestments_Percent_Marital_Equity_to_Op1" value="<?php if(isset($drstocksinvestments->Op_StockInvestments_Percent_Marital_Equity_to_Op1)){ echo $drstocksinvestments->Op_StockInvestments_Percent_Marital_Equity_to_Op1; } ?>" min="0.00" step="0.01" max="100" readonly="">
                                </div>
                                <div class="form-group col-sm-6 Op_StockInvestments_Paying_Party1_Inputs_Div" style="display: none;">
                                    <label>How much is to be paid to {{$opponent_name}}?</label>
                                    <input id="Op_StockInvestments_Estimated_Value_to_Op1" type="number" class="form-control 1_Op_opponentamount_input opponentamount_input" name="Op_StockInvestments_Estimated_Value_to_Op1" value="<?php if(isset($drstocksinvestments->Op_StockInvestments_Estimated_Value_to_Op1)){ echo $drstocksinvestments->Op_StockInvestments_Estimated_Value_to_Op1; } ?>" min="0.00" step="0.01" max="999999.99" readonly="" onchange="getEstimatedValueOp(this, '1', 'Op');" onkeyup="getEstimatedValueOp(this, '1', 'Op');">
                                </div>
                                <!-- end of slider tool -->
                            </div>
                            <div class="col-sm-12 mt-4 2_Op_stocksinvestments_section" style="display: none;"><h5 class="col-sm-12">Second Stock Investment Info</h5>
                                <div class="form-group col-sm-6">
                                    <p class="text-danger 2_Op_no-state-county-found" style="display: none;">No City, State, County found for this zipcode.</p>
                                    <label for="Op_StockInvestments_Institution_ZIP2">Stock/Investment Institution Zip Code?</label>
                                    <input id="Op_StockInvestments_Institution_ZIP2" type="text" class="form-control 2_Op_stocksinvestments_inputs" name="Op_StockInvestments_Institution_ZIP2" value="<?php if(isset($drstocksinvestments->Op_StockInvestments_Institution_ZIP2)){ echo $drstocksinvestments->Op_StockInvestments_Institution_ZIP2; } ?>" data-onload="getCityStateForZip(this, '2', 'Op');" onkeyup="getCityStateForZip(this, '2', 'Op');"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_StockInvestments_Institution_Name2">Name of Stock/Investment Institution?</label>
                                    <input id="Op_StockInvestments_Institution_Name2" type="text" class="form-control 2_Op_stocksinvestments_inputs" name="Op_StockInvestments_Institution_Name2" value="<?php if(isset($drstocksinvestments->Op_StockInvestments_Institution_Name2)){ echo $drstocksinvestments->Op_StockInvestments_Institution_Name2; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_StockInvestments_Institution_Street_Address2">Stock/Investment Institution Street Address?</label>
                                    <input id="Op_StockInvestments_Institution_Street_Address2" type="text" class="form-control 2_Op_stocksinvestments_inputs" name="Op_StockInvestments_Institution_Street_Address2" value="<?php if(isset($drstocksinvestments->Op_StockInvestments_Institution_Street_Address2)){ echo $drstocksinvestments->Op_StockInvestments_Institution_Street_Address2; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_StockInvestments_Institution_City2">Stock/Investment Institution City?</label>
                                    <input type="hidden" name="" id="Op_StockInvestments_Institution_City2_Value" value="<?php if(isset($drstocksinvestments->Op_StockInvestments_Institution_City2)){ echo $drstocksinvestments->Op_StockInvestments_Institution_City2; } ?>">
                                    <select id="Op_StockInvestments_Institution_City2" name="Op_StockInvestments_Institution_City2" class="form-control 2_Op_city_select">
                                        <option value="">Choose City</option>
                                    </select>   
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_StockInvestments_Institution_State2">Stock/Investment Institution State?</label>
                                    <input type="hidden" name="" id="Op_StockInvestments_Institution_State2_Value" value="<?php if(isset($drstocksinvestments->Op_StockInvestments_Institution_State2)){ echo $drstocksinvestments->Op_StockInvestments_Institution_State2; } ?>">
                                    <select id="Op_StockInvestments_Institution_State2" name="Op_StockInvestments_Institution_State2" class="form-control 2_Op_state_select">
                                        <option value="">Choose State</option>
                                    </select>   
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_StockInvestments_Acct_Num2">Account Number?</label>
                                    <input id="Op_StockInvestments_Acct_Num2" type="text" class="form-control 2_Op_stocksinvestments_inputs" name="Op_StockInvestments_Acct_Num2" value="<?php if(isset($drstocksinvestments->Op_StockInvestments_Acct_Num2)){ echo $drstocksinvestments->Op_StockInvestments_Acct_Num2; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_StockInvestments_Date_Marriage_Value2">Marriage Date Value?</label>
                                    <input id="Op_StockInvestments_Date_Marriage_Value2" type="number" class="form-control 2_Op_stocksinvestments_inputs" name="Op_StockInvestments_Date_Marriage_Value2" value="<?php if(isset($drstocksinvestments->Op_StockInvestments_Date_Marriage_Value2)){ echo $drstocksinvestments->Op_StockInvestments_Date_Marriage_Value2; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_StockInvestments_Current_Value2">Current Value?</label>
                                    <input id="Op_StockInvestments_Current_Value2" type="number" class="form-control 2_Op_stocksinvestments_inputs" name="Op_StockInvestments_Current_Value2" value="<?php if(isset($drstocksinvestments->Op_StockInvestments_Current_Value2)){ echo $drstocksinvestments->Op_StockInvestments_Current_Value2; } ?>" min="0.00" step="0.01" max="999999.99" onchange="getJointCurrentValue(this, '2', 'Op');" onkeyup="getJointCurrentValue(this, '2', 'Op');"> 
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label for="Op_StockInvestments_Percent_Marital_Equity2">N/A, calculated = Op_StockInvestments_Institution_Current_Value2</label>
                                    <input id="Op_StockInvestments_Percent_Marital_Equity2" type="number" class="form-control 2_Op_stocksinvestments_inputs" name="Op_StockInvestments_Percent_Marital_Equity2" value="<?php if(isset($drstocksinvestments->Op_StockInvestments_Percent_Marital_Equity2)){ echo $drstocksinvestments->Op_StockInvestments_Percent_Marital_Equity2; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_StockInvestments_Yearly_Interest_Dividend2">Yearly Interest and Dividends from this account?</label>
                                    <input id="Op_StockInvestments_Yearly_Interest_Dividend2" type="number" class="form-control 2_Op_stocksinvestments_inputs" name="Op_StockInvestments_Yearly_Interest_Dividend2" value="<?php if(isset($drstocksinvestments->Op_StockInvestments_Yearly_Interest_Dividend2)){ echo $drstocksinvestments->Op_StockInvestments_Yearly_Interest_Dividend2; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Does either party claim a sole/separate interest from the other on this account?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Op_StockInvestments_SoleSeparate_Claim2_Yes" name="Op_StockInvestments_SoleSeparate_Claim2" value="Yes" data-onload="getInitialPartyClaimSoleSeparate(this, '2', 'Op');" onchange="getPartyClaimSoleSeparate(this, '2', 'Op');" <?php if(isset($drstocksinvestments->Op_StockInvestments_SoleSeparate_Claim2) && $drstocksinvestments->Op_StockInvestments_SoleSeparate_Claim2=='Yes'){ echo "checked"; } ?>> Yes</label>
                                        <label><input type="radio" id="Op_StockInvestments_SoleSeparate_Claim2_No" name="Op_StockInvestments_SoleSeparate_Claim2" value="No" data-onload="getInitialPartyClaimSoleSeparate(this, '2', 'Op');" onchange="getPartyClaimSoleSeparate(this, '2', 'Op');" <?php if(isset($drstocksinvestments->Op_StockInvestments_SoleSeparate_Claim2) && $drstocksinvestments->Op_StockInvestments_SoleSeparate_Claim2=='No'){ echo "checked"; } ?>> No</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6" id="Op_StockInvestments_SoleSeparate_Party2_Div" style="display: none;">
                                    <label>Who claims to own this account?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Op_StockInvestments_SoleSeparate_Party2_Client" name="Op_StockInvestments_SoleSeparate_Party2" value="{{$client_name}}" <?php if(isset($drstocksinvestments->Op_StockInvestments_SoleSeparate_Party2) && $drstocksinvestments->Op_StockInvestments_SoleSeparate_Party2==$client_name){ echo "checked"; } ?>> {{$client_name}}</label>
                                        <label><input type="radio" id="Op_StockInvestments_SoleSeparate_Party2_Op" name="Op_StockInvestments_SoleSeparate_Party2" value="{{$opponent_name}}" <?php if(isset($drstocksinvestments->Op_StockInvestments_SoleSeparate_Party2) && $drstocksinvestments->Op_StockInvestments_SoleSeparate_Party2==$opponent_name){ echo "checked"; } ?>> {{$opponent_name}}</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 left-clear" id="Op_StockInvestments_SoleSeparate_Grounds2_Div" style="display: none; clear: left;">
                                    <label for="Op_StockInvestments_SoleSeparate_Grounds2">Why does this person own this account solely and separately?</label>
                                    <input id="Op_StockInvestments_SoleSeparate_Grounds2" type="text" class="form-control 2_Op_stocksinvestments_inputs" name="Op_StockInvestments_SoleSeparate_Grounds2" value="<?php if(isset($drstocksinvestments->Op_StockInvestments_SoleSeparate_Grounds2)){ echo $drstocksinvestments->Op_StockInvestments_SoleSeparate_Grounds2; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>How will this account value be distributed between the parties?</label>
                                    <div class="w-100 dataInput">
                                        <label><input type="radio" id="Op_StockInvestments_Disposition_Method2_Distribute_Investments" name="Op_StockInvestments_Disposition_Method2" value="Distribute Investments" data-onload="getInitialDipositionMethod(this, '2', 'Op');" onchange="getDipositionMethod(this, '2', 'Op');" <?php if(isset($drstocksinvestments->Op_StockInvestments_Disposition_Method2) && $drstocksinvestments->Op_StockInvestments_Disposition_Method2=='Distribute Investments'){ echo "checked"; } ?>> Distribute Investments</label>
                                        <label><input type="radio" id="Op_StockInvestments_Disposition_Method2_Liquidate_Split_Net_Value" name="Op_StockInvestments_Disposition_Method2" value="Liquidate/Split Net Value" data-onload="getInitialDipositionMethod(this, '2', 'Op');" onchange="getDipositionMethod(this, '2', 'Op');" <?php if(isset($drstocksinvestments->Op_StockInvestments_Disposition_Method2) && $drstocksinvestments->Op_StockInvestments_Disposition_Method2=='Liquidate/Split Net Value'){ echo "checked"; } ?>> Liquidate/Split Net Value</label>
                                        <label><input type="radio" id="Op_StockInvestments_Disposition_Method2_Percentage_Buyout" name="Op_StockInvestments_Disposition_Method2" value="Percentage Buyout" data-onload="getInitialDipositionMethod(this, '2', 'Op');" onchange="getDipositionMethod(this, '2', 'Op');" <?php if(isset($drstocksinvestments->Op_StockInvestments_Disposition_Method2) && $drstocksinvestments->Op_StockInvestments_Disposition_Method2=='Percentage Buyout'){ echo "checked"; } ?>> Percentage Buyout</label>
                                        <label><input type="radio" id="Op_StockInvestments_Disposition_Method2_Fixed Buyout" name="Op_StockInvestments_Disposition_Method2" value="Fixed Buyout" data-onload="getInitialDipositionMethod(this, '2', 'Op');" onchange="getDipositionMethod(this, '2', 'Op');" <?php if(isset($drstocksinvestments->Op_StockInvestments_Disposition_Method2) && $drstocksinvestments->Op_StockInvestments_Disposition_Method2=='Fixed Buyout'){ echo "checked"; } ?>> Fixed Buyout</label>
                                    </div>
                                </div>
                                <!-- slider tool -->
                                <div class="form-group col-sm-6 m-auto 2_Op_Slider_Tool slider-tool-main">
                                    <div class="row">
                                        <div class="col">{{$client_name}}</div>
                                        <div class="col text-right">{{$opponent_name}}</div>
                                    </div>
                                    <input id="2_Op_balance_range_selector" type="range" class="form-control slider-tool-input 2_Op_balance_range_selector" name="" value="<?php if(isset($drstocksinvestments->Op_StockInvestments_Percent_Marital_Equity_to_Op2)){ echo $drstocksinvestments->Op_StockInvestments_Percent_Marital_Equity_to_Op2; } ?>" min="0.00" step="0.01" max="100" onchange="updateBalanceInput(this.value, '2', 'Op');">
                                </div>
                                <div class="form-group col-sm-6 m-auto 2_Op_Slider_Tool slider-tool-main">
                                    <div class="row justify-content-between">
                                        <div class="col selectorTool">
                                            <div class="left-col">
                                                <div class="client-info 2_Op_clientpercentage_div clientpercentage_div">
                                                    <?php if(isset($drstocksinvestments->Op_StockInvestments_Percent_Marital_Equity_to_Client2)){ echo $drstocksinvestments->Op_StockInvestments_Percent_Marital_Equity_to_Client2; } else {
                                                        echo "50.00";
                                                    } ?>%
                                                </div>
                                                <div class="client-info 2_Op_clientamount_div clientamount_div" style="clear: both;">
                                                    $<?php if(isset($drstocksinvestments->Op_StockInvestments_Estimated_Value_to_Client2)){ echo $drstocksinvestments->Op_StockInvestments_Estimated_Value_to_Client2; }else {
                                                        echo "0.00";
                                                    } ?>
                                                </div>
                                            </div>
                                            <label>To {{$client_name}}</label>
                                        </div>                                       
                                        <div class="col selectorTool selectorToolRight">
                                            <label>To {{$opponent_name}}</label>
                                            <div class="left-col right-col">
                                                <div class="client-info 2_Op_opponentpercentage_div opponentpercentage_div">
                                                    <?php if(isset($drstocksinvestments->Op_StockInvestments_Percent_Marital_Equity_to_Op2)){ echo $drstocksinvestments->Op_StockInvestments_Percent_Marital_Equity_to_Op2; } else {
                                                        echo "50.00";
                                                    } ?>%
                                                </div>
                                                <div class="client-info 2_Op_opponentamount_div opponentamount_div" style="clear: both;">
                                                    $<?php if(isset($drstocksinvestments->Op_StockInvestments_Estimated_Value_to_Op2)){ echo $drstocksinvestments->Op_StockInvestments_Estimated_Value_to_Op2; }else {
                                                        echo "0.00";
                                                    } ?>
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
                                         <label><input type="radio" id="Op_StockInvestments_Paying_Party2_Client" name="Op_StockInvestments_Paying_Party2" value="{{$client_name}}" data-onload="getInitialStockInvestmentPayingParty(this, '2', 'Op');" onchange="getStockInvestmentPayingParty(this, '2', 'Op');"  <?php if(isset($drstocksinvestments->Op_StockInvestments_Paying_Party2) && $drstocksinvestments->Op_StockInvestments_Paying_Party2==$client_name){ echo "checked"; } ?>> {{$client_name}}</label>
                                        <label><input type="radio" id="Op_StockInvestments_Paying_Party2_Op" name="Op_StockInvestments_Paying_Party2" value="{{$opponent_name}}" data-onload="getInitialStockInvestmentPayingParty(this, '2', 'Op');" onchange="getStockInvestmentPayingParty(this, '2', 'Op');"  <?php if(isset($drstocksinvestments->Op_StockInvestments_Paying_Party2) && $drstocksinvestments->Op_StockInvestments_Paying_Party2==$opponent_name){ echo "checked"; } ?>> {{$opponent_name}}</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 Op_StockInvestments_Paying_Party2_Inputs_Div" style="display: none;">
                                    <label>{{$client_name}} StockInvestment Equity Percent</label>
                                    <input id="Op_StockInvestments_Percent_Marital_Equity_to_Client2" type="number" class="form-control 2_Op_clientpercentage_input clientpercentage_input" name="Op_StockInvestments_Percent_Marital_Equity_to_Client2" value="<?php if(isset($drstocksinvestments->Op_StockInvestments_Percent_Marital_Equity_to_Client2)){ echo $drstocksinvestments->Op_StockInvestments_Percent_Marital_Equity_to_Client2; } ?>" min="0.00" step="0.01" max="100" readonly="">
                                </div>
                                <div class="form-group col-sm-6 Op_StockInvestments_Paying_Party2_Inputs_Div" style="display: none;">
                                    <label>How much is to be paid to {{$client_name}}?</label>
                                    <input id="Op_StockInvestments_Estimated_Value_to_Client2" type="number" class="form-control 2_Op_clientamount_input clientamount_input" name="Op_StockInvestments_Estimated_Value_to_Client2" value="<?php if(isset($drstocksinvestments->Op_StockInvestments_Estimated_Value_to_Client2)){ echo $drstocksinvestments->Op_StockInvestments_Estimated_Value_to_Client2; } ?>" min="0.00" step="0.01" max="999999.99" readonly="" onchange="getEstimatedValueClient(this, '2', 'Op');" onkeyup="getEstimatedValueClient(this, '2', 'Op');">
                                </div>
                                <div class="form-group col-sm-6 Op_StockInvestments_Paying_Party2_Inputs_Div" style="display: none;">
                                    <label>{{$opponent_name}} StockInvestment Equity Percent</label>
                                    <input id="Op_StockInvestments_Percent_Marital_Equity_to_Op2" type="number" class="form-control 2_Op_opponentpercentage_input opponentpercentage_input" name="Op_StockInvestments_Percent_Marital_Equity_to_Op2" value="<?php if(isset($drstocksinvestments->Op_StockInvestments_Percent_Marital_Equity_to_Op2)){ echo $drstocksinvestments->Op_StockInvestments_Percent_Marital_Equity_to_Op2; } ?>" min="0.00" step="0.01" max="100" readonly="">
                                </div>
                                <div class="form-group col-sm-6 Op_StockInvestments_Paying_Party2_Inputs_Div" style="display: none;">
                                    <label>How much is to be paid to {{$opponent_name}}?</label>
                                    <input id="Op_StockInvestments_Estimated_Value_to_Op2" type="number" class="form-control 2_Op_opponentamount_input opponentamount_input" name="Op_StockInvestments_Estimated_Value_to_Op2" value="<?php if(isset($drstocksinvestments->Op_StockInvestments_Estimated_Value_to_Op2)){ echo $drstocksinvestments->Op_StockInvestments_Estimated_Value_to_Op2; } ?>" min="0.00" step="0.01" max="999999.99" readonly="" onchange="getEstimatedValueOp(this, '2', 'Op');" onkeyup="getEstimatedValueOp(this, '2', 'Op');">
                                </div>
                                <!-- end of slider tool -->
                            </div>
                            <div class="col-sm-12 mt-4 3_Op_stocksinvestments_section" style="display: none;"><h5 class="col-sm-12">Third Stock Investment Info</h5>
                                <div class="form-group col-sm-6">
                                    <p class="text-danger 3_Op_no-state-county-found" style="display: none;">No City, State, County found for this zipcode.</p>
                                    <label for="Op_StockInvestments_Institution_ZIP3">Stock/Investment Institution Zip Code?</label>
                                    <input id="Op_StockInvestments_Institution_ZIP3" type="text" class="form-control 3_Op_stocksinvestments_inputs" name="Op_StockInvestments_Institution_ZIP3" value="<?php if(isset($drstocksinvestments->Op_StockInvestments_Institution_ZIP3)){ echo $drstocksinvestments->Op_StockInvestments_Institution_ZIP3; } ?>" data-onload="getCityStateForZip(this, '3', 'Op');" onkeyup="getCityStateForZip(this, '3', 'Op');"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_StockInvestments_Institution_Name3">Name of Stock/Investment Institution?</label>
                                    <input id="Op_StockInvestments_Institution_Name3" type="text" class="form-control 3_Op_stocksinvestments_inputs" name="Op_StockInvestments_Institution_Name3" value="<?php if(isset($drstocksinvestments->Op_StockInvestments_Institution_Name3)){ echo $drstocksinvestments->Op_StockInvestments_Institution_Name3; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_StockInvestments_Institution_Street_Address3">Stock/Investment Institution Street Address?</label>
                                    <input id="Op_StockInvestments_Institution_Street_Address3" type="text" class="form-control 3_Op_stocksinvestments_inputs" name="Op_StockInvestments_Institution_Street_Address3" value="<?php if(isset($drstocksinvestments->Op_StockInvestments_Institution_Street_Address3)){ echo $drstocksinvestments->Op_StockInvestments_Institution_Street_Address3; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_StockInvestments_Institution_City3">Stock/Investment Institution City?</label>
                                    <input type="hidden" name="" id="Op_StockInvestments_Institution_City3_Value" value="<?php if(isset($drstocksinvestments->Op_StockInvestments_Institution_City3)){ echo $drstocksinvestments->Op_StockInvestments_Institution_City3; } ?>">
                                    <select id="Op_StockInvestments_Institution_City3" name="Op_StockInvestments_Institution_City3" class="form-control 3_Op_city_select">
                                        <option value="">Choose City</option>
                                    </select>   
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_StockInvestments_Institution_State3">Stock/Investment Institution State?</label>
                                    <input type="hidden" name="" id="Op_StockInvestments_Institution_State3_Value" value="<?php if(isset($drstocksinvestments->Op_StockInvestments_Institution_State3)){ echo $drstocksinvestments->Op_StockInvestments_Institution_State3; } ?>">
                                    <select id="Op_StockInvestments_Institution_State3" name="Op_StockInvestments_Institution_State3" class="form-control 3_Op_state_select">
                                        <option value="">Choose State</option>
                                    </select>   
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_StockInvestments_Acct_Num3">Account Number?</label>
                                    <input id="Op_StockInvestments_Acct_Num3" type="text" class="form-control 3_Op_stocksinvestments_inputs" name="Op_StockInvestments_Acct_Num3" value="<?php if(isset($drstocksinvestments->Op_StockInvestments_Acct_Num3)){ echo $drstocksinvestments->Op_StockInvestments_Acct_Num3; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_StockInvestments_Date_Marriage_Value3">Marriage Date Value?</label>
                                    <input id="Op_StockInvestments_Date_Marriage_Value3" type="number" class="form-control 3_Op_stocksinvestments_inputs" name="Op_StockInvestments_Date_Marriage_Value3" value="<?php if(isset($drstocksinvestments->Op_StockInvestments_Date_Marriage_Value3)){ echo $drstocksinvestments->Op_StockInvestments_Date_Marriage_Value3; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_StockInvestments_Current_Value3">Current Value?</label>
                                    <input id="Op_StockInvestments_Current_Value3" type="number" class="form-control 3_Op_stocksinvestments_inputs" name="Op_StockInvestments_Current_Value3" value="<?php if(isset($drstocksinvestments->Op_StockInvestments_Current_Value3)){ echo $drstocksinvestments->Op_StockInvestments_Current_Value3; } ?>" min="0.00" step="0.01" max="999999.99" onchange="getJointCurrentValue(this, '3', 'Op');" onkeyup="getJointCurrentValue(this, '3', 'Op');"> 
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label for="Op_StockInvestments_Percent_Marital_Equity3">N/A, calculated = Op_StockInvestments_Institution_Current_Value3</label>
                                    <input id="Op_StockInvestments_Percent_Marital_Equity3" type="number" class="form-control 3_Op_stocksinvestments_inputs" name="Op_StockInvestments_Percent_Marital_Equity3" value="<?php if(isset($drstocksinvestments->Op_StockInvestments_Percent_Marital_Equity3)){ echo $drstocksinvestments->Op_StockInvestments_Percent_Marital_Equity3; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_StockInvestments_Yearly_Interest_Dividend3">Yearly Interest and Dividends from this account?</label>
                                    <input id="Op_StockInvestments_Yearly_Interest_Dividend3" type="number" class="form-control 3_Op_stocksinvestments_inputs" name="Op_StockInvestments_Yearly_Interest_Dividend3" value="<?php if(isset($drstocksinvestments->Op_StockInvestments_Yearly_Interest_Dividend3)){ echo $drstocksinvestments->Op_StockInvestments_Yearly_Interest_Dividend3; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Does either party claim a sole/separate interest from the other on this account?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Op_StockInvestments_SoleSeparate_Claim3_Yes" name="Op_StockInvestments_SoleSeparate_Claim3" value="Yes" data-onload="getInitialPartyClaimSoleSeparate(this, '3', 'Op');" onchange="getPartyClaimSoleSeparate(this, '3', 'Op');" <?php if(isset($drstocksinvestments->Op_StockInvestments_SoleSeparate_Claim3) && $drstocksinvestments->Op_StockInvestments_SoleSeparate_Claim3=='Yes'){ echo "checked"; } ?>> Yes</label>
                                        <label><input type="radio" id="Op_StockInvestments_SoleSeparate_Claim3_No" name="Op_StockInvestments_SoleSeparate_Claim3" value="No" data-onload="getInitialPartyClaimSoleSeparate(this, '3', 'Op');" onchange="getPartyClaimSoleSeparate(this, '3', 'Op');" <?php if(isset($drstocksinvestments->Op_StockInvestments_SoleSeparate_Claim3) && $drstocksinvestments->Op_StockInvestments_SoleSeparate_Claim3=='No'){ echo "checked"; } ?>> No</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6" id="Op_StockInvestments_SoleSeparate_Party3_Div" style="display: none;">
                                    <label>Who claims to own this account?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Op_StockInvestments_SoleSeparate_Party3_Client" name="Op_StockInvestments_SoleSeparate_Party3" value="{{$client_name}}" <?php if(isset($drstocksinvestments->Op_StockInvestments_SoleSeparate_Party3) && $drstocksinvestments->Op_StockInvestments_SoleSeparate_Party3==$client_name){ echo "checked"; } ?>> {{$client_name}}</label>
                                        <label><input type="radio" id="Op_StockInvestments_SoleSeparate_Party3_Op" name="Op_StockInvestments_SoleSeparate_Party3" value="{{$opponent_name}}" <?php if(isset($drstocksinvestments->Op_StockInvestments_SoleSeparate_Party3) && $drstocksinvestments->Op_StockInvestments_SoleSeparate_Party3==$opponent_name){ echo "checked"; } ?>> {{$opponent_name}}</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 left-clear" id="Op_StockInvestments_SoleSeparate_Grounds3_Div" style="display: none; clear: left;">
                                    <label for="Op_StockInvestments_SoleSeparate_Grounds3">Why does this person own this account solely and separately?</label>
                                    <input id="Op_StockInvestments_SoleSeparate_Grounds3" type="text" class="form-control 3_Op_stocksinvestments_inputs" name="Op_StockInvestments_SoleSeparate_Grounds3" value="<?php if(isset($drstocksinvestments->Op_StockInvestments_SoleSeparate_Grounds3)){ echo $drstocksinvestments->Op_StockInvestments_SoleSeparate_Grounds3; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>How will this account value be distributed between the parties?</label>
                                    <div class="w-100 dataInput">
                                        <label><input type="radio" id="Op_StockInvestments_Disposition_Method3_Distribute_Investments" name="Op_StockInvestments_Disposition_Method3" value="Distribute Investments" data-onload="getInitialDipositionMethod(this, '3', 'Op');" onchange="getDipositionMethod(this, '3', 'Op');" <?php if(isset($drstocksinvestments->Op_StockInvestments_Disposition_Method3) && $drstocksinvestments->Op_StockInvestments_Disposition_Method3=='Distribute Investments'){ echo "checked"; } ?>> Distribute Investments</label>
                                        <label><input type="radio" id="Op_StockInvestments_Disposition_Method3_Liquidate_Split_Net_Value" name="Op_StockInvestments_Disposition_Method3" value="Liquidate/Split Net Value" data-onload="getInitialDipositionMethod(this, '3', 'Op');" onchange="getDipositionMethod(this, '3', 'Op');" <?php if(isset($drstocksinvestments->Op_StockInvestments_Disposition_Method3) && $drstocksinvestments->Op_StockInvestments_Disposition_Method3=='Liquidate/Split Net Value'){ echo "checked"; } ?>> Liquidate/Split Net Value</label>
                                        <label><input type="radio" id="Op_StockInvestments_Disposition_Method3_Percentage_Buyout" name="Op_StockInvestments_Disposition_Method3" value="Percentage Buyout" data-onload="getInitialDipositionMethod(this, '3', 'Op');" onchange="getDipositionMethod(this, '3', 'Op');" <?php if(isset($drstocksinvestments->Op_StockInvestments_Disposition_Method3) && $drstocksinvestments->Op_StockInvestments_Disposition_Method3=='Percentage Buyout'){ echo "checked"; } ?>> Percentage Buyout</label>
                                        <label><input type="radio" id="Op_StockInvestments_Disposition_Method3_Fixed Buyout" name="Op_StockInvestments_Disposition_Method3" value="Fixed Buyout" data-onload="getInitialDipositionMethod(this, '3', 'Op');" onchange="getDipositionMethod(this, '3', 'Op');" <?php if(isset($drstocksinvestments->Op_StockInvestments_Disposition_Method3) && $drstocksinvestments->Op_StockInvestments_Disposition_Method3=='Fixed Buyout'){ echo "checked"; } ?>> Fixed Buyout</label>
                                    </div>
                                </div>
                                <!-- slider tool -->
                                <div class="form-group col-sm-6 m-auto 3_Op_Slider_Tool slider-tool-main">
                                    <div class="row">
                                        <div class="col">{{$client_name}}</div>
                                        <div class="col text-right">{{$opponent_name}}</div>
                                    </div>
                                    <input id="3_Op_balance_range_selector" type="range" class="form-control slider-tool-input 3_Op_balance_range_selector" name="" value="<?php if(isset($drstocksinvestments->Op_StockInvestments_Percent_Marital_Equity_to_Op3)){ echo $drstocksinvestments->Op_StockInvestments_Percent_Marital_Equity_to_Op3; } ?>" min="0.00" step="0.01" max="100" onchange="updateBalanceInput(this.value, '3', 'Op');">
                                </div>
                                <div class="form-group col-sm-6 m-auto 3_Op_Slider_Tool slider-tool-main">
                                    <div class="row justify-content-between">
                                        <div class="col selectorTool">
                                            <div class="left-col">
                                                <div class="client-info 3_Op_clientpercentage_div clientpercentage_div">
                                                    <?php if(isset($drstocksinvestments->Op_StockInvestments_Percent_Marital_Equity_to_Client3)){ echo $drstocksinvestments->Op_StockInvestments_Percent_Marital_Equity_to_Client3; } else {
                                                        echo "50.00";
                                                    } ?>%
                                                </div>
                                                <div class="client-info 3_Op_clientamount_div clientamount_div" style="clear: both;">
                                                    $<?php if(isset($drstocksinvestments->Op_StockInvestments_Estimated_Value_to_Client3)){ echo $drstocksinvestments->Op_StockInvestments_Estimated_Value_to_Client3; }else {
                                                        echo "0.00";
                                                    } ?>
                                                </div>
                                            </div>
                                            <label>To {{$client_name}}</label>
                                        </div>                                       
                                        <div class="col selectorTool selectorToolRight">
                                            <label>To {{$opponent_name}}</label>
                                            <div class="left-col right-col">
                                                <div class="client-info 3_Op_opponentpercentage_div opponentpercentage_div">
                                                    <?php if(isset($drstocksinvestments->Op_StockInvestments_Percent_Marital_Equity_to_Op3)){ echo $drstocksinvestments->Op_StockInvestments_Percent_Marital_Equity_to_Op3; } else {
                                                        echo "50.00";
                                                    } ?>%
                                                </div>
                                                <div class="client-info 3_Op_opponentamount_div opponentamount_div" style="clear: both;">
                                                    $<?php if(isset($drstocksinvestments->Op_StockInvestments_Estimated_Value_to_Op3)){ echo $drstocksinvestments->Op_StockInvestments_Estimated_Value_to_Op3; }else {
                                                        echo "0.00";
                                                    } ?>
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
                                         <label><input type="radio" id="Op_StockInvestments_Paying_Party3_Client" name="Op_StockInvestments_Paying_Party3" value="{{$client_name}}" data-onload="getInitialStockInvestmentPayingParty(this, '3', 'Op');" onchange="getStockInvestmentPayingParty(this, '3', 'Op');"  <?php if(isset($drstocksinvestments->Op_StockInvestments_Paying_Party3) && $drstocksinvestments->Op_StockInvestments_Paying_Party3==$client_name){ echo "checked"; } ?>> {{$client_name}}</label>
                                        <label><input type="radio" id="Op_StockInvestments_Paying_Party3_Op" name="Op_StockInvestments_Paying_Party3" value="{{$opponent_name}}" data-onload="getInitialStockInvestmentPayingParty(this, '3', 'Op');" onchange="getStockInvestmentPayingParty(this, '3', 'Op');"  <?php if(isset($drstocksinvestments->Op_StockInvestments_Paying_Party3) && $drstocksinvestments->Op_StockInvestments_Paying_Party3==$opponent_name){ echo "checked"; } ?>> {{$opponent_name}}</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 Op_StockInvestments_Paying_Party3_Inputs_Div" style="display: none;">
                                    <label>{{$client_name}} StockInvestment Equity Percent</label>
                                    <input id="Op_StockInvestments_Percent_Marital_Equity_to_Client3" type="number" class="form-control 3_Op_clientpercentage_input clientpercentage_input" name="Op_StockInvestments_Percent_Marital_Equity_to_Client3" value="<?php if(isset($drstocksinvestments->Op_StockInvestments_Percent_Marital_Equity_to_Client3)){ echo $drstocksinvestments->Op_StockInvestments_Percent_Marital_Equity_to_Client3; } ?>" min="0.00" step="0.01" max="100" readonly="">
                                </div>
                                <div class="form-group col-sm-6 Op_StockInvestments_Paying_Party3_Inputs_Div" style="display: none;">
                                    <label>How much is to be paid to {{$client_name}}?</label>
                                    <input id="Op_StockInvestments_Estimated_Value_to_Client3" type="number" class="form-control 3_Op_clientamount_input clientamount_input" name="Op_StockInvestments_Estimated_Value_to_Client3" value="<?php if(isset($drstocksinvestments->Op_StockInvestments_Estimated_Value_to_Client3)){ echo $drstocksinvestments->Op_StockInvestments_Estimated_Value_to_Client3; } ?>" min="0.00" step="0.01" max="999999.99" readonly="" onchange="getEstimatedValueClient(this, '3', 'Op');" onkeyup="getEstimatedValueClient(this, '3', 'Op');">
                                </div>
                                <div class="form-group col-sm-6 Op_StockInvestments_Paying_Party3_Inputs_Div" style="display: none;">
                                    <label>{{$opponent_name}} StockInvestment Equity Percent</label>
                                    <input id="Op_StockInvestments_Percent_Marital_Equity_to_Op3" type="number" class="form-control 3_Op_opponentpercentage_input opponentpercentage_input" name="Op_StockInvestments_Percent_Marital_Equity_to_Op3" value="<?php if(isset($drstocksinvestments->Op_StockInvestments_Percent_Marital_Equity_to_Op3)){ echo $drstocksinvestments->Op_StockInvestments_Percent_Marital_Equity_to_Op3; } ?>" min="0.00" step="0.01" max="100" readonly="">
                                </div>
                                <div class="form-group col-sm-6 Op_StockInvestments_Paying_Party3_Inputs_Div" style="display: none;">
                                    <label>How much is to be paid to {{$opponent_name}}?</label>
                                    <input id="Op_StockInvestments_Estimated_Value_to_Op3" type="number" class="form-control 3_Op_opponentamount_input opponentamount_input" name="Op_StockInvestments_Estimated_Value_to_Op3" value="<?php if(isset($drstocksinvestments->Op_StockInvestments_Estimated_Value_to_Op3)){ echo $drstocksinvestments->Op_StockInvestments_Estimated_Value_to_Op3; } ?>" min="0.00" step="0.01" max="999999.99" readonly="" onchange="getEstimatedValueOp(this, '3', 'Op');" onkeyup="getEstimatedValueOp(this, '3', 'Op');">
                                </div>
                                <!-- end of slider tool -->
                            </div>
                            <div class="col-sm-12 mt-4 4_Op_stocksinvestments_section" style="display: none;"><h5 class="col-sm-12">Fourth Stock Investment Info</h5>
                                <div class="form-group col-sm-6">
                                    <p class="text-danger 4_Op_no-state-county-found" style="display: none;">No City, State, County found for this zipcode.</p>
                                    <label for="Op_StockInvestments_Institution_ZIP4">Stock/Investment Institution Zip Code?</label>
                                    <input id="Op_StockInvestments_Institution_ZIP4" type="text" class="form-control 4_Op_stocksinvestments_inputs" name="Op_StockInvestments_Institution_ZIP4" value="<?php if(isset($drstocksinvestments->Op_StockInvestments_Institution_ZIP4)){ echo $drstocksinvestments->Op_StockInvestments_Institution_ZIP4; } ?>" data-onload="getCityStateForZip(this, '4', 'Op');" onkeyup="getCityStateForZip(this, '4', 'Op');"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_StockInvestments_Institution_Name4">Name of Stock/Investment Institution?</label>
                                    <input id="Op_StockInvestments_Institution_Name4" type="text" class="form-control 4_Op_stocksinvestments_inputs" name="Op_StockInvestments_Institution_Name4" value="<?php if(isset($drstocksinvestments->Op_StockInvestments_Institution_Name4)){ echo $drstocksinvestments->Op_StockInvestments_Institution_Name4; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_StockInvestments_Institution_Street_Address4">Stock/Investment Institution Street Address?</label>
                                    <input id="Op_StockInvestments_Institution_Street_Address4" type="text" class="form-control 4_Op_stocksinvestments_inputs" name="Op_StockInvestments_Institution_Street_Address4" value="<?php if(isset($drstocksinvestments->Op_StockInvestments_Institution_Street_Address4)){ echo $drstocksinvestments->Op_StockInvestments_Institution_Street_Address4; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_StockInvestments_Institution_City4">Stock/Investment Institution City?</label>
                                    <input type="hidden" name="" id="Op_StockInvestments_Institution_City4_Value" value="<?php if(isset($drstocksinvestments->Op_StockInvestments_Institution_City4)){ echo $drstocksinvestments->Op_StockInvestments_Institution_City4; } ?>">
                                    <select id="Op_StockInvestments_Institution_City4" name="Op_StockInvestments_Institution_City4" class="form-control 4_Op_city_select">
                                        <option value="">Choose City</option>
                                    </select>   
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_StockInvestments_Institution_State4">Stock/Investment Institution State?</label>
                                    <input type="hidden" name="" id="Op_StockInvestments_Institution_State4_Value" value="<?php if(isset($drstocksinvestments->Op_StockInvestments_Institution_State4)){ echo $drstocksinvestments->Op_StockInvestments_Institution_State4; } ?>">
                                    <select id="Op_StockInvestments_Institution_State4" name="Op_StockInvestments_Institution_State4" class="form-control 4_Op_state_select">
                                        <option value="">Choose State</option>
                                    </select>   
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_StockInvestments_Acct_Num4">Account Number?</label>
                                    <input id="Op_StockInvestments_Acct_Num4" type="text" class="form-control 4_Op_stocksinvestments_inputs" name="Op_StockInvestments_Acct_Num4" value="<?php if(isset($drstocksinvestments->Op_StockInvestments_Acct_Num4)){ echo $drstocksinvestments->Op_StockInvestments_Acct_Num4; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_StockInvestments_Date_Marriage_Value4">Marriage Date Value?</label>
                                    <input id="Op_StockInvestments_Date_Marriage_Value4" type="number" class="form-control 4_Op_stocksinvestments_inputs" name="Op_StockInvestments_Date_Marriage_Value4" value="<?php if(isset($drstocksinvestments->Op_StockInvestments_Date_Marriage_Value4)){ echo $drstocksinvestments->Op_StockInvestments_Date_Marriage_Value4; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_StockInvestments_Current_Value4">Current Value?</label>
                                    <input id="Op_StockInvestments_Current_Value4" type="number" class="form-control 4_Op_stocksinvestments_inputs" name="Op_StockInvestments_Current_Value4" value="<?php if(isset($drstocksinvestments->Op_StockInvestments_Current_Value4)){ echo $drstocksinvestments->Op_StockInvestments_Current_Value4; } ?>" min="0.00" step="0.01" max="999999.99" onchange="getJointCurrentValue(this, '4', 'Op');" onkeyup="getJointCurrentValue(this, '4', 'Op');"> 
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label for="Op_StockInvestments_Percent_Marital_Equity4">N/A, calculated = Op_StockInvestments_Institution_Current_Value4</label>
                                    <input id="Op_StockInvestments_Percent_Marital_Equity4" type="number" class="form-control 4_Op_stocksinvestments_inputs" name="Op_StockInvestments_Percent_Marital_Equity4" value="<?php if(isset($drstocksinvestments->Op_StockInvestments_Percent_Marital_Equity4)){ echo $drstocksinvestments->Op_StockInvestments_Percent_Marital_Equity4; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_StockInvestments_Yearly_Interest_Dividend4">Yearly Interest and Dividends from this account?</label>
                                    <input id="Op_StockInvestments_Yearly_Interest_Dividend4" type="number" class="form-control 4_Op_stocksinvestments_inputs" name="Op_StockInvestments_Yearly_Interest_Dividend4" value="<?php if(isset($drstocksinvestments->Op_StockInvestments_Yearly_Interest_Dividend4)){ echo $drstocksinvestments->Op_StockInvestments_Yearly_Interest_Dividend4; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Does either party claim a sole/separate interest from the other on this account?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Op_StockInvestments_SoleSeparate_Claim4_Yes" name="Op_StockInvestments_SoleSeparate_Claim4" value="Yes" data-onload="getInitialPartyClaimSoleSeparate(this, '4', 'Op');" onchange="getPartyClaimSoleSeparate(this, '4', 'Op');" <?php if(isset($drstocksinvestments->Op_StockInvestments_SoleSeparate_Claim4) && $drstocksinvestments->Op_StockInvestments_SoleSeparate_Claim4=='Yes'){ echo "checked"; } ?>> Yes</label>
                                        <label><input type="radio" id="Op_StockInvestments_SoleSeparate_Claim4_No" name="Op_StockInvestments_SoleSeparate_Claim4" value="No" data-onload="getInitialPartyClaimSoleSeparate(this, '4', 'Op');" onchange="getPartyClaimSoleSeparate(this, '4', 'Op');" <?php if(isset($drstocksinvestments->Op_StockInvestments_SoleSeparate_Claim4) && $drstocksinvestments->Op_StockInvestments_SoleSeparate_Claim4=='No'){ echo "checked"; } ?>> No</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6" id="Op_StockInvestments_SoleSeparate_Party4_Div" style="display: none;">
                                    <label>Who claims to own this account?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Op_StockInvestments_SoleSeparate_Party4_Client" name="Op_StockInvestments_SoleSeparate_Party4" value="{{$client_name}}" <?php if(isset($drstocksinvestments->Op_StockInvestments_SoleSeparate_Party4) && $drstocksinvestments->Op_StockInvestments_SoleSeparate_Party4==$client_name){ echo "checked"; } ?>> {{$client_name}}</label>
                                        <label><input type="radio" id="Op_StockInvestments_SoleSeparate_Party4_Op" name="Op_StockInvestments_SoleSeparate_Party4" value="{{$opponent_name}}" <?php if(isset($drstocksinvestments->Op_StockInvestments_SoleSeparate_Party4) && $drstocksinvestments->Op_StockInvestments_SoleSeparate_Party4==$opponent_name){ echo "checked"; } ?>> {{$opponent_name}}</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 left-clear" id="Op_StockInvestments_SoleSeparate_Grounds4_Div" style="display: none; clear: left;">
                                    <label for="Op_StockInvestments_SoleSeparate_Grounds4">Why does this person own this account solely and separately?</label>
                                    <input id="Op_StockInvestments_SoleSeparate_Grounds4" type="text" class="form-control 4_Op_stocksinvestments_inputs" name="Op_StockInvestments_SoleSeparate_Grounds4" value="<?php if(isset($drstocksinvestments->Op_StockInvestments_SoleSeparate_Grounds4)){ echo $drstocksinvestments->Op_StockInvestments_SoleSeparate_Grounds4; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>How will this account value be distributed between the parties?</label>
                                    <div class="w-100 dataInput">
                                        <label><input type="radio" id="Op_StockInvestments_Disposition_Method4_Distribute_Investments" name="Op_StockInvestments_Disposition_Method4" value="Distribute Investments" data-onload="getInitialDipositionMethod(this, '4', 'Op');" onchange="getDipositionMethod(this, '4', 'Op');" <?php if(isset($drstocksinvestments->Op_StockInvestments_Disposition_Method4) && $drstocksinvestments->Op_StockInvestments_Disposition_Method4=='Distribute Investments'){ echo "checked"; } ?>> Distribute Investments</label>
                                        <label><input type="radio" id="Op_StockInvestments_Disposition_Method4_Liquidate_Split_Net_Value" name="Op_StockInvestments_Disposition_Method4" value="Liquidate/Split Net Value" data-onload="getInitialDipositionMethod(this, '4', 'Op');" onchange="getDipositionMethod(this, '4', 'Op');" <?php if(isset($drstocksinvestments->Op_StockInvestments_Disposition_Method4) && $drstocksinvestments->Op_StockInvestments_Disposition_Method4=='Liquidate/Split Net Value'){ echo "checked"; } ?>> Liquidate/Split Net Value</label>
                                        <label><input type="radio" id="Op_StockInvestments_Disposition_Method4_Percentage_Buyout" name="Op_StockInvestments_Disposition_Method4" value="Percentage Buyout" data-onload="getInitialDipositionMethod(this, '4', 'Op');" onchange="getDipositionMethod(this, '4', 'Op');" <?php if(isset($drstocksinvestments->Op_StockInvestments_Disposition_Method4) && $drstocksinvestments->Op_StockInvestments_Disposition_Method4=='Percentage Buyout'){ echo "checked"; } ?>> Percentage Buyout</label>
                                        <label><input type="radio" id="Op_StockInvestments_Disposition_Method4_Fixed Buyout" name="Op_StockInvestments_Disposition_Method4" value="Fixed Buyout" data-onload="getInitialDipositionMethod(this, '4', 'Op');" onchange="getDipositionMethod(this, '4', 'Op');" <?php if(isset($drstocksinvestments->Op_StockInvestments_Disposition_Method4) && $drstocksinvestments->Op_StockInvestments_Disposition_Method4=='Fixed Buyout'){ echo "checked"; } ?>> Fixed Buyout</label>
                                    </div>
                                </div>
                                <!-- slider tool -->
                                <div class="form-group col-sm-6 m-auto 4_Op_Slider_Tool slider-tool-main">
                                    <div class="row">
                                        <div class="col">{{$client_name}}</div>
                                        <div class="col text-right">{{$opponent_name}}</div>
                                    </div>
                                    <input id="4_Op_balance_range_selector" type="range" class="form-control slider-tool-input 4_Op_balance_range_selector" name="" value="<?php if(isset($drstocksinvestments->Op_StockInvestments_Percent_Marital_Equity_to_Op4)){ echo $drstocksinvestments->Op_StockInvestments_Percent_Marital_Equity_to_Op4; } ?>" min="0.00" step="0.01" max="100" onchange="updateBalanceInput(this.value, '4', 'Op');">
                                </div>
                                <div class="form-group col-sm-6 m-auto 4_Op_Slider_Tool slider-tool-main">
                                    <div class="row justify-content-between">
                                        <div class="col selectorTool">
                                            <div class="left-col">
                                                <div class="client-info 4_Op_clientpercentage_div clientpercentage_div">
                                                    <?php if(isset($drstocksinvestments->Op_StockInvestments_Percent_Marital_Equity_to_Client4)){ echo $drstocksinvestments->Op_StockInvestments_Percent_Marital_Equity_to_Client4; } else {
                                                        echo "50.00";
                                                    } ?>%
                                                </div>
                                                <div class="client-info 4_Op_clientamount_div clientamount_div" style="clear: both;">
                                                    $<?php if(isset($drstocksinvestments->Op_StockInvestments_Estimated_Value_to_Client4)){ echo $drstocksinvestments->Op_StockInvestments_Estimated_Value_to_Client4; }else {
                                                        echo "0.00";
                                                    } ?>
                                                </div>
                                            </div>
                                            <label>To {{$client_name}}</label>
                                        </div>                                       
                                        <div class="col selectorTool selectorToolRight">
                                            <label>To {{$opponent_name}}</label>
                                            <div class="left-col right-col">
                                                <div class="client-info 4_Op_opponentpercentage_div opponentpercentage_div">
                                                    <?php if(isset($drstocksinvestments->Op_StockInvestments_Percent_Marital_Equity_to_Op4)){ echo $drstocksinvestments->Op_StockInvestments_Percent_Marital_Equity_to_Op4; } else {
                                                        echo "50.00";
                                                    } ?>%
                                                </div>
                                                <div class="client-info 4_Op_opponentamount_div opponentamount_div" style="clear: both;">
                                                    $<?php if(isset($drstocksinvestments->Op_StockInvestments_Estimated_Value_to_Op4)){ echo $drstocksinvestments->Op_StockInvestments_Estimated_Value_to_Op4; }else {
                                                        echo "0.00";
                                                    } ?>
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
                                         <label><input type="radio" id="Op_StockInvestments_Paying_Party4_Client" name="Op_StockInvestments_Paying_Party4" value="{{$client_name}}" data-onload="getInitialStockInvestmentPayingParty(this, '4', 'Op');" onchange="getStockInvestmentPayingParty(this, '4', 'Op');"  <?php if(isset($drstocksinvestments->Op_StockInvestments_Paying_Party4) && $drstocksinvestments->Op_StockInvestments_Paying_Party4==$client_name){ echo "checked"; } ?>> {{$client_name}}</label>
                                        <label><input type="radio" id="Op_StockInvestments_Paying_Party4_Op" name="Op_StockInvestments_Paying_Party4" value="{{$opponent_name}}" data-onload="getInitialStockInvestmentPayingParty(this, '4', 'Op');" onchange="getStockInvestmentPayingParty(this, '4', 'Op');"  <?php if(isset($drstocksinvestments->Op_StockInvestments_Paying_Party4) && $drstocksinvestments->Op_StockInvestments_Paying_Party4==$opponent_name){ echo "checked"; } ?>> {{$opponent_name}}</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 Op_StockInvestments_Paying_Party4_Inputs_Div" style="display: none;">
                                    <label>{{$client_name}} StockInvestment Equity Percent</label>
                                    <input id="Op_StockInvestments_Percent_Marital_Equity_to_Client4" type="number" class="form-control 4_Op_clientpercentage_input clientpercentage_input" name="Op_StockInvestments_Percent_Marital_Equity_to_Client4" value="<?php if(isset($drstocksinvestments->Op_StockInvestments_Percent_Marital_Equity_to_Client4)){ echo $drstocksinvestments->Op_StockInvestments_Percent_Marital_Equity_to_Client4; } ?>" min="0.00" step="0.01" max="100" readonly="">
                                </div>
                                <div class="form-group col-sm-6 Op_StockInvestments_Paying_Party4_Inputs_Div" style="display: none;">
                                    <label>How much is to be paid to {{$client_name}}?</label>
                                    <input id="Op_StockInvestments_Estimated_Value_to_Client4" type="number" class="form-control 4_Op_clientamount_input clientamount_input" name="Op_StockInvestments_Estimated_Value_to_Client4" value="<?php if(isset($drstocksinvestments->Op_StockInvestments_Estimated_Value_to_Client4)){ echo $drstocksinvestments->Op_StockInvestments_Estimated_Value_to_Client4; } ?>" min="0.00" step="0.01" max="999999.99" readonly="" onchange="getEstimatedValueClient(this, '4', 'Op');" onkeyup="getEstimatedValueClient(this, '4', 'Op');">
                                </div>
                                <div class="form-group col-sm-6 Op_StockInvestments_Paying_Party4_Inputs_Div" style="display: none;">
                                    <label>{{$opponent_name}} StockInvestment Equity Percent</label>
                                    <input id="Op_StockInvestments_Percent_Marital_Equity_to_Op4" type="number" class="form-control 4_Op_opponentpercentage_input opponentpercentage_input" name="Op_StockInvestments_Percent_Marital_Equity_to_Op4" value="<?php if(isset($drstocksinvestments->Op_StockInvestments_Percent_Marital_Equity_to_Op4)){ echo $drstocksinvestments->Op_StockInvestments_Percent_Marital_Equity_to_Op4; } ?>" min="0.00" step="0.01" max="100" readonly="">
                                </div>
                                <div class="form-group col-sm-6 Op_StockInvestments_Paying_Party4_Inputs_Div" style="display: none;">
                                    <label>How much is to be paid to {{$opponent_name}}?</label>
                                    <input id="Op_StockInvestments_Estimated_Value_to_Op4" type="number" class="form-control 4_Op_opponentamount_input opponentamount_input" name="Op_StockInvestments_Estimated_Value_to_Op4" value="<?php if(isset($drstocksinvestments->Op_StockInvestments_Estimated_Value_to_Op4)){ echo $drstocksinvestments->Op_StockInvestments_Estimated_Value_to_Op4; } ?>" min="0.00" step="0.01" max="999999.99" readonly="" onchange="getEstimatedValueOp(this, '4', 'Op');" onkeyup="getEstimatedValueOp(this, '4', 'Op');">
                                </div>
                                <!-- end of slider tool -->
                            </div>
                            <div class="col-sm-12 mt-4 5_Op_stocksinvestments_section" style="display: none;"><h5 class="col-sm-12">Fifth Stock Investment Info</h5>
                                <div class="form-group col-sm-6">
                                    <p class="text-danger 5_Op_no-state-county-found" style="display: none;">No City, State, County found for this zipcode.</p>
                                    <label for="Op_StockInvestments_Institution_ZIP5">Stock/Investment Institution Zip Code?</label>
                                    <input id="Op_StockInvestments_Institution_ZIP5" type="text" class="form-control 5_Op_stocksinvestments_inputs" name="Op_StockInvestments_Institution_ZIP5" value="<?php if(isset($drstocksinvestments->Op_StockInvestments_Institution_ZIP5)){ echo $drstocksinvestments->Op_StockInvestments_Institution_ZIP5; } ?>" data-onload="getCityStateForZip(this, '5', 'Op');" onkeyup="getCityStateForZip(this, '5', 'Op');"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_StockInvestments_Institution_Name5">Name of Stock/Investment Institution?</label>
                                    <input id="Op_StockInvestments_Institution_Name5" type="text" class="form-control 5_Op_stocksinvestments_inputs" name="Op_StockInvestments_Institution_Name5" value="<?php if(isset($drstocksinvestments->Op_StockInvestments_Institution_Name5)){ echo $drstocksinvestments->Op_StockInvestments_Institution_Name5; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_StockInvestments_Institution_Street_Address5">Stock/Investment Institution Street Address?</label>
                                    <input id="Op_StockInvestments_Institution_Street_Address5" type="text" class="form-control 5_Op_stocksinvestments_inputs" name="Op_StockInvestments_Institution_Street_Address5" value="<?php if(isset($drstocksinvestments->Op_StockInvestments_Institution_Street_Address5)){ echo $drstocksinvestments->Op_StockInvestments_Institution_Street_Address5; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_StockInvestments_Institution_City5">Stock/Investment Institution City?</label>
                                    <input type="hidden" name="" id="Op_StockInvestments_Institution_City5_Value" value="<?php if(isset($drstocksinvestments->Op_StockInvestments_Institution_City5)){ echo $drstocksinvestments->Op_StockInvestments_Institution_City5; } ?>">
                                    <select id="Op_StockInvestments_Institution_City5" name="Op_StockInvestments_Institution_City5" class="form-control 5_Op_city_select">
                                        <option value="">Choose City</option>
                                    </select>   
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_StockInvestments_Institution_State5">Stock/Investment Institution State?</label>
                                    <input type="hidden" name="" id="Op_StockInvestments_Institution_State5_Value" value="<?php if(isset($drstocksinvestments->Op_StockInvestments_Institution_State5)){ echo $drstocksinvestments->Op_StockInvestments_Institution_State5; } ?>">
                                    <select id="Op_StockInvestments_Institution_State5" name="Op_StockInvestments_Institution_State5" class="form-control 5_Op_state_select">
                                        <option value="">Choose State</option>
                                    </select>   
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_StockInvestments_Acct_Num5">Account Number?</label>
                                    <input id="Op_StockInvestments_Acct_Num5" type="text" class="form-control 5_Op_stocksinvestments_inputs" name="Op_StockInvestments_Acct_Num5" value="<?php if(isset($drstocksinvestments->Op_StockInvestments_Acct_Num5)){ echo $drstocksinvestments->Op_StockInvestments_Acct_Num5; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_StockInvestments_Date_Marriage_Value5">Marriage Date Value?</label>
                                    <input id="Op_StockInvestments_Date_Marriage_Value5" type="number" class="form-control 5_Op_stocksinvestments_inputs" name="Op_StockInvestments_Date_Marriage_Value5" value="<?php if(isset($drstocksinvestments->Op_StockInvestments_Date_Marriage_Value5)){ echo $drstocksinvestments->Op_StockInvestments_Date_Marriage_Value5; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_StockInvestments_Current_Value5">Current Value?</label>
                                    <input id="Op_StockInvestments_Current_Value5" type="number" class="form-control 5_Op_stocksinvestments_inputs" name="Op_StockInvestments_Current_Value5" value="<?php if(isset($drstocksinvestments->Op_StockInvestments_Current_Value5)){ echo $drstocksinvestments->Op_StockInvestments_Current_Value5; } ?>" min="0.00" step="0.01" max="999999.99" onchange="getJointCurrentValue(this, '5', 'Op');" onkeyup="getJointCurrentValue(this, '5', 'Op');"> 
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label for="Op_StockInvestments_Percent_Marital_Equity5">N/A, calculated = Op_StockInvestments_Institution_Current_Value5</label>
                                    <input id="Op_StockInvestments_Percent_Marital_Equity5" type="number" class="form-control 5_Op_stocksinvestments_inputs" name="Op_StockInvestments_Percent_Marital_Equity5" value="<?php if(isset($drstocksinvestments->Op_StockInvestments_Percent_Marital_Equity5)){ echo $drstocksinvestments->Op_StockInvestments_Percent_Marital_Equity5; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_StockInvestments_Yearly_Interest_Dividend5">Yearly Interest and Dividends from this account?</label>
                                    <input id="Op_StockInvestments_Yearly_Interest_Dividend5" type="number" class="form-control 5_Op_stocksinvestments_inputs" name="Op_StockInvestments_Yearly_Interest_Dividend5" value="<?php if(isset($drstocksinvestments->Op_StockInvestments_Yearly_Interest_Dividend5)){ echo $drstocksinvestments->Op_StockInvestments_Yearly_Interest_Dividend5; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Does either party claim a sole/separate interest from the other on this account?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Op_StockInvestments_SoleSeparate_Claim5_Yes" name="Op_StockInvestments_SoleSeparate_Claim5" value="Yes" data-onload="getInitialPartyClaimSoleSeparate(this, '5', 'Op');" onchange="getPartyClaimSoleSeparate(this, '5', 'Op');" <?php if(isset($drstocksinvestments->Op_StockInvestments_SoleSeparate_Claim5) && $drstocksinvestments->Op_StockInvestments_SoleSeparate_Claim5=='Yes'){ echo "checked"; } ?>> Yes</label>
                                        <label><input type="radio" id="Op_StockInvestments_SoleSeparate_Claim5_No" name="Op_StockInvestments_SoleSeparate_Claim5" value="No" data-onload="getInitialPartyClaimSoleSeparate(this, '5', 'Op');" onchange="getPartyClaimSoleSeparate(this, '5', 'Op');" <?php if(isset($drstocksinvestments->Op_StockInvestments_SoleSeparate_Claim5) && $drstocksinvestments->Op_StockInvestments_SoleSeparate_Claim5=='No'){ echo "checked"; } ?>> No</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6" id="Op_StockInvestments_SoleSeparate_Party5_Div" style="display: none;">
                                    <label>Who claims to own this account?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Op_StockInvestments_SoleSeparate_Party5_Client" name="Op_StockInvestments_SoleSeparate_Party5" value="{{$client_name}}" <?php if(isset($drstocksinvestments->Op_StockInvestments_SoleSeparate_Party5) && $drstocksinvestments->Op_StockInvestments_SoleSeparate_Party5==$client_name){ echo "checked"; } ?>> {{$client_name}}</label>
                                        <label><input type="radio" id="Op_StockInvestments_SoleSeparate_Party5_Op" name="Op_StockInvestments_SoleSeparate_Party5" value="{{$opponent_name}}" <?php if(isset($drstocksinvestments->Op_StockInvestments_SoleSeparate_Party5) && $drstocksinvestments->Op_StockInvestments_SoleSeparate_Party5==$opponent_name){ echo "checked"; } ?>> {{$opponent_name}}</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 left-clear" id="Op_StockInvestments_SoleSeparate_Grounds5_Div" style="display: none; clear: left;">
                                    <label for="Op_StockInvestments_SoleSeparate_Grounds5">Why does this person own this account solely and separately?</label>
                                    <input id="Op_StockInvestments_SoleSeparate_Grounds5" type="text" class="form-control 5_Op_stocksinvestments_inputs" name="Op_StockInvestments_SoleSeparate_Grounds5" value="<?php if(isset($drstocksinvestments->Op_StockInvestments_SoleSeparate_Grounds5)){ echo $drstocksinvestments->Op_StockInvestments_SoleSeparate_Grounds5; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>How will this account value be distributed between the parties?</label>
                                    <div class="w-100 dataInput">
                                        <label><input type="radio" id="Op_StockInvestments_Disposition_Method5_Distribute_Investments" name="Op_StockInvestments_Disposition_Method5" value="Distribute Investments" data-onload="getInitialDipositionMethod(this, '5', 'Op');" onchange="getDipositionMethod(this, '5', 'Op');" <?php if(isset($drstocksinvestments->Op_StockInvestments_Disposition_Method5) && $drstocksinvestments->Op_StockInvestments_Disposition_Method5=='Distribute Investments'){ echo "checked"; } ?>> Distribute Investments</label>
                                        <label><input type="radio" id="Op_StockInvestments_Disposition_Method5_Liquidate_Split_Net_Value" name="Op_StockInvestments_Disposition_Method5" value="Liquidate/Split Net Value" data-onload="getInitialDipositionMethod(this, '5', 'Op');" onchange="getDipositionMethod(this, '5', 'Op');" <?php if(isset($drstocksinvestments->Op_StockInvestments_Disposition_Method5) && $drstocksinvestments->Op_StockInvestments_Disposition_Method5=='Liquidate/Split Net Value'){ echo "checked"; } ?>> Liquidate/Split Net Value</label>
                                        <label><input type="radio" id="Op_StockInvestments_Disposition_Method5_Percentage_Buyout" name="Op_StockInvestments_Disposition_Method5" value="Percentage Buyout" data-onload="getInitialDipositionMethod(this, '5', 'Op');" onchange="getDipositionMethod(this, '5', 'Op');" <?php if(isset($drstocksinvestments->Op_StockInvestments_Disposition_Method5) && $drstocksinvestments->Op_StockInvestments_Disposition_Method5=='Percentage Buyout'){ echo "checked"; } ?>> Percentage Buyout</label>
                                        <label><input type="radio" id="Op_StockInvestments_Disposition_Method5_Fixed Buyout" name="Op_StockInvestments_Disposition_Method5" value="Fixed Buyout" data-onload="getInitialDipositionMethod(this, '5', 'Op');" onchange="getDipositionMethod(this, '5', 'Op');" <?php if(isset($drstocksinvestments->Op_StockInvestments_Disposition_Method5) && $drstocksinvestments->Op_StockInvestments_Disposition_Method5=='Fixed Buyout'){ echo "checked"; } ?>> Fixed Buyout</label>
                                    </div>
                                </div>
                                <!-- slider tool -->
                                <div class="form-group col-sm-6 m-auto 5_Op_Slider_Tool slider-tool-main">
                                    <div class="row">
                                        <div class="col">{{$client_name}}</div>
                                        <div class="col text-right">{{$opponent_name}}</div>
                                    </div>
                                    <input id="5_Op_balance_range_selector" type="range" class="form-control slider-tool-input 5_Op_balance_range_selector" name="" value="<?php if(isset($drstocksinvestments->Op_StockInvestments_Percent_Marital_Equity_to_Op5)){ echo $drstocksinvestments->Op_StockInvestments_Percent_Marital_Equity_to_Op5; } ?>" min="0.00" step="0.01" max="100" onchange="updateBalanceInput(this.value, '5', 'Op');">
                                </div>
                                <div class="form-group col-sm-6 m-auto 5_Op_Slider_Tool slider-tool-main">
                                    <div class="row justify-content-between">
                                        <div class="col selectorTool">
                                            <div class="left-col">
                                                <div class="client-info 5_Op_clientpercentage_div clientpercentage_div">
                                                    <?php if(isset($drstocksinvestments->Op_StockInvestments_Percent_Marital_Equity_to_Client5)){ echo $drstocksinvestments->Op_StockInvestments_Percent_Marital_Equity_to_Client5; } else {
                                                        echo "50.00";
                                                    } ?>%
                                                </div>
                                                <div class="client-info 5_Op_clientamount_div clientamount_div" style="clear: both;">
                                                    $<?php if(isset($drstocksinvestments->Op_StockInvestments_Estimated_Value_to_Client5)){ echo $drstocksinvestments->Op_StockInvestments_Estimated_Value_to_Client5; }else {
                                                        echo "0.00";
                                                    } ?>
                                                </div>
                                            </div>
                                            <label>To {{$client_name}}</label>
                                        </div>                                       
                                        <div class="col selectorTool selectorToolRight">
                                            <label>To {{$opponent_name}}</label>
                                            <div class="left-col right-col">
                                                <div class="client-info 5_Op_opponentpercentage_div opponentpercentage_div">
                                                    <?php if(isset($drstocksinvestments->Op_StockInvestments_Percent_Marital_Equity_to_Op5)){ echo $drstocksinvestments->Op_StockInvestments_Percent_Marital_Equity_to_Op5; } else {
                                                        echo "50.00";
                                                    } ?>%
                                                </div>
                                                <div class="client-info 5_Op_opponentamount_div opponentamount_div" style="clear: both;">
                                                    $<?php if(isset($drstocksinvestments->Op_StockInvestments_Estimated_Value_to_Op5)){ echo $drstocksinvestments->Op_StockInvestments_Estimated_Value_to_Op5; }else {
                                                        echo "0.00";
                                                    } ?>
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
                                         <label><input type="radio" id="Op_StockInvestments_Paying_Party5_Client" name="Op_StockInvestments_Paying_Party5" value="{{$client_name}}" data-onload="getInitialStockInvestmentPayingParty(this, '5', 'Op');" onchange="getStockInvestmentPayingParty(this, '5', 'Op');"  <?php if(isset($drstocksinvestments->Op_StockInvestments_Paying_Party5) && $drstocksinvestments->Op_StockInvestments_Paying_Party5==$client_name){ echo "checked"; } ?>> {{$client_name}}</label>
                                        <label><input type="radio" id="Op_StockInvestments_Paying_Party5_Op" name="Op_StockInvestments_Paying_Party5" value="{{$opponent_name}}" data-onload="getInitialStockInvestmentPayingParty(this, '5', 'Op');" onchange="getStockInvestmentPayingParty(this, '5', 'Op');"  <?php if(isset($drstocksinvestments->Op_StockInvestments_Paying_Party5) && $drstocksinvestments->Op_StockInvestments_Paying_Party5==$opponent_name){ echo "checked"; } ?>> {{$opponent_name}}</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 Op_StockInvestments_Paying_Party5_Inputs_Div" style="display: none;">
                                    <label>{{$client_name}} StockInvestment Equity Percent</label>
                                    <input id="Op_StockInvestments_Percent_Marital_Equity_to_Client5" type="number" class="form-control 5_Op_clientpercentage_input clientpercentage_input" name="Op_StockInvestments_Percent_Marital_Equity_to_Client5" value="<?php if(isset($drstocksinvestments->Op_StockInvestments_Percent_Marital_Equity_to_Client5)){ echo $drstocksinvestments->Op_StockInvestments_Percent_Marital_Equity_to_Client5; } ?>" min="0.00" step="0.01" max="100" readonly="">
                                </div>
                                <div class="form-group col-sm-6 Op_StockInvestments_Paying_Party5_Inputs_Div" style="display: none;">
                                    <label>How much is to be paid to {{$client_name}}?</label>
                                    <input id="Op_StockInvestments_Estimated_Value_to_Client5" type="number" class="form-control 5_Op_clientamount_input clientamount_input" name="Op_StockInvestments_Estimated_Value_to_Client5" value="<?php if(isset($drstocksinvestments->Op_StockInvestments_Estimated_Value_to_Client5)){ echo $drstocksinvestments->Op_StockInvestments_Estimated_Value_to_Client5; } ?>" min="0.00" step="0.01" max="999999.99" readonly="" onchange="getEstimatedValueClient(this, '5', 'Op');" onkeyup="getEstimatedValueClient(this, '5', 'Op');">
                                </div>
                                <div class="form-group col-sm-6 Op_StockInvestments_Paying_Party5_Inputs_Div" style="display: none;">
                                    <label>{{$opponent_name}} StockInvestment Equity Percent</label>
                                    <input id="Op_StockInvestments_Percent_Marital_Equity_to_Op5" type="number" class="form-control 5_Op_opponentpercentage_input opponentpercentage_input" name="Op_StockInvestments_Percent_Marital_Equity_to_Op5" value="<?php if(isset($drstocksinvestments->Op_StockInvestments_Percent_Marital_Equity_to_Op5)){ echo $drstocksinvestments->Op_StockInvestments_Percent_Marital_Equity_to_Op5; } ?>" min="0.00" step="0.01" max="100" readonly="">
                                </div>
                                <div class="form-group col-sm-6 Op_StockInvestments_Paying_Party5_Inputs_Div" style="display: none;">
                                    <label>How much is to be paid to {{$opponent_name}}?</label>
                                    <input id="Op_StockInvestments_Estimated_Value_to_Op5" type="number" class="form-control 5_Op_opponentamount_input opponentamount_input" name="Op_StockInvestments_Estimated_Value_to_Op5" value="<?php if(isset($drstocksinvestments->Op_StockInvestments_Estimated_Value_to_Op5)){ echo $drstocksinvestments->Op_StockInvestments_Estimated_Value_to_Op5; } ?>" min="0.00" step="0.01" max="999999.99" readonly="" onchange="getEstimatedValueOp(this, '5', 'Op');" onkeyup="getEstimatedValueOp(this, '5', 'Op');">
                                </div>
                                <!-- end of slider tool -->
                            </div>
                            <div class="col-sm-12 mt-4 6_Op_stocksinvestments_section" style="display: none;"><h5 class="col-sm-12">Sixth Stock Investment Info</h5>
                                <div class="form-group col-sm-6">
                                    <p class="text-danger 6_Op_no-state-county-found" style="display: none;">No City, State, County found for this zipcode.</p>
                                    <label for="Op_StockInvestments_Institution_ZIP6">Stock/Investment Institution Zip Code?</label>
                                    <input id="Op_StockInvestments_Institution_ZIP6" type="text" class="form-control 6_Op_stocksinvestments_inputs" name="Op_StockInvestments_Institution_ZIP6" value="<?php if(isset($drstocksinvestments->Op_StockInvestments_Institution_ZIP6)){ echo $drstocksinvestments->Op_StockInvestments_Institution_ZIP6; } ?>" data-onload="getCityStateForZip(this, '6', 'Op');" onkeyup="getCityStateForZip(this, '6', 'Op');"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_StockInvestments_Institution_Name6">Name of Stock/Investment Institution?</label>
                                    <input id="Op_StockInvestments_Institution_Name6" type="text" class="form-control 6_Op_stocksinvestments_inputs" name="Op_StockInvestments_Institution_Name6" value="<?php if(isset($drstocksinvestments->Op_StockInvestments_Institution_Name6)){ echo $drstocksinvestments->Op_StockInvestments_Institution_Name6; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_StockInvestments_Institution_Street_Address6">Stock/Investment Institution Street Address?</label>
                                    <input id="Op_StockInvestments_Institution_Street_Address6" type="text" class="form-control 6_Op_stocksinvestments_inputs" name="Op_StockInvestments_Institution_Street_Address6" value="<?php if(isset($drstocksinvestments->Op_StockInvestments_Institution_Street_Address6)){ echo $drstocksinvestments->Op_StockInvestments_Institution_Street_Address6; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_StockInvestments_Institution_City6">Stock/Investment Institution City?</label>
                                    <input type="hidden" name="" id="Op_StockInvestments_Institution_City6_Value" value="<?php if(isset($drstocksinvestments->Op_StockInvestments_Institution_City6)){ echo $drstocksinvestments->Op_StockInvestments_Institution_City6; } ?>">
                                    <select id="Op_StockInvestments_Institution_City6" name="Op_StockInvestments_Institution_City6" class="form-control 6_Op_city_select">
                                        <option value="">Choose City</option>
                                    </select>   
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_StockInvestments_Institution_State6">Stock/Investment Institution State?</label>
                                    <input type="hidden" name="" id="Op_StockInvestments_Institution_State6_Value" value="<?php if(isset($drstocksinvestments->Op_StockInvestments_Institution_State6)){ echo $drstocksinvestments->Op_StockInvestments_Institution_State6; } ?>">
                                    <select id="Op_StockInvestments_Institution_State6" name="Op_StockInvestments_Institution_State6" class="form-control 6_Op_state_select">
                                        <option value="">Choose State</option>
                                    </select>   
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_StockInvestments_Acct_Num6">Account Number?</label>
                                    <input id="Op_StockInvestments_Acct_Num6" type="text" class="form-control 6_Op_stocksinvestments_inputs" name="Op_StockInvestments_Acct_Num6" value="<?php if(isset($drstocksinvestments->Op_StockInvestments_Acct_Num6)){ echo $drstocksinvestments->Op_StockInvestments_Acct_Num6; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_StockInvestments_Date_Marriage_Value6">Marriage Date Value?</label>
                                    <input id="Op_StockInvestments_Date_Marriage_Value6" type="number" class="form-control 6_Op_stocksinvestments_inputs" name="Op_StockInvestments_Date_Marriage_Value6" value="<?php if(isset($drstocksinvestments->Op_StockInvestments_Date_Marriage_Value6)){ echo $drstocksinvestments->Op_StockInvestments_Date_Marriage_Value6; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_StockInvestments_Current_Value6">Current Value?</label>
                                    <input id="Op_StockInvestments_Current_Value6" type="number" class="form-control 6_Op_stocksinvestments_inputs" name="Op_StockInvestments_Current_Value6" value="<?php if(isset($drstocksinvestments->Op_StockInvestments_Current_Value6)){ echo $drstocksinvestments->Op_StockInvestments_Current_Value6; } ?>" min="0.00" step="0.01" max="999999.99" onchange="getJointCurrentValue(this, '6', 'Op');" onkeyup="getJointCurrentValue(this, '6', 'Op');"> 
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label for="Op_StockInvestments_Percent_Marital_Equity6">N/A, calculated = Op_StockInvestments_Institution_Current_Value6</label>
                                    <input id="Op_StockInvestments_Percent_Marital_Equity6" type="number" class="form-control 6_Op_stocksinvestments_inputs" name="Op_StockInvestments_Percent_Marital_Equity6" value="<?php if(isset($drstocksinvestments->Op_StockInvestments_Percent_Marital_Equity6)){ echo $drstocksinvestments->Op_StockInvestments_Percent_Marital_Equity6; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_StockInvestments_Yearly_Interest_Dividend6">Yearly Interest and Dividends from this account?</label>
                                    <input id="Op_StockInvestments_Yearly_Interest_Dividend6" type="number" class="form-control 6_Op_stocksinvestments_inputs" name="Op_StockInvestments_Yearly_Interest_Dividend6" value="<?php if(isset($drstocksinvestments->Op_StockInvestments_Yearly_Interest_Dividend6)){ echo $drstocksinvestments->Op_StockInvestments_Yearly_Interest_Dividend6; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Does either party claim a sole/separate interest from the other on this account?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Op_StockInvestments_SoleSeparate_Claim6_Yes" name="Op_StockInvestments_SoleSeparate_Claim6" value="Yes" data-onload="getInitialPartyClaimSoleSeparate(this, '6', 'Op');" onchange="getPartyClaimSoleSeparate(this, '6', 'Op');" <?php if(isset($drstocksinvestments->Op_StockInvestments_SoleSeparate_Claim6) && $drstocksinvestments->Op_StockInvestments_SoleSeparate_Claim6=='Yes'){ echo "checked"; } ?>> Yes</label>
                                        <label><input type="radio" id="Op_StockInvestments_SoleSeparate_Claim6_No" name="Op_StockInvestments_SoleSeparate_Claim6" value="No" data-onload="getInitialPartyClaimSoleSeparate(this, '6', 'Op');" onchange="getPartyClaimSoleSeparate(this, '6', 'Op');" <?php if(isset($drstocksinvestments->Op_StockInvestments_SoleSeparate_Claim6) && $drstocksinvestments->Op_StockInvestments_SoleSeparate_Claim6=='No'){ echo "checked"; } ?>> No</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6" id="Op_StockInvestments_SoleSeparate_Party6_Div" style="display: none;">
                                    <label>Who claims to own this account?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Op_StockInvestments_SoleSeparate_Party6_Client" name="Op_StockInvestments_SoleSeparate_Party6" value="{{$client_name}}" <?php if(isset($drstocksinvestments->Op_StockInvestments_SoleSeparate_Party6) && $drstocksinvestments->Op_StockInvestments_SoleSeparate_Party6==$client_name){ echo "checked"; } ?>> {{$client_name}}</label>
                                        <label><input type="radio" id="Op_StockInvestments_SoleSeparate_Party6_Op" name="Op_StockInvestments_SoleSeparate_Party6" value="{{$opponent_name}}" <?php if(isset($drstocksinvestments->Op_StockInvestments_SoleSeparate_Party6) && $drstocksinvestments->Op_StockInvestments_SoleSeparate_Party6==$opponent_name){ echo "checked"; } ?>> {{$opponent_name}}</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 left-clear" id="Op_StockInvestments_SoleSeparate_Grounds6_Div" style="display: none; clear: left;">
                                    <label for="Op_StockInvestments_SoleSeparate_Grounds6">Why does this person own this account solely and separately?</label>
                                    <input id="Op_StockInvestments_SoleSeparate_Grounds6" type="text" class="form-control 6_Op_stocksinvestments_inputs" name="Op_StockInvestments_SoleSeparate_Grounds6" value="<?php if(isset($drstocksinvestments->Op_StockInvestments_SoleSeparate_Grounds6)){ echo $drstocksinvestments->Op_StockInvestments_SoleSeparate_Grounds6; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>How will this account value be distributed between the parties?</label>
                                    <div class="w-100 dataInput">
                                        <label><input type="radio" id="Op_StockInvestments_Disposition_Method6_Distribute_Investments" name="Op_StockInvestments_Disposition_Method6" value="Distribute Investments" data-onload="getInitialDipositionMethod(this, '6', 'Op');" onchange="getDipositionMethod(this, '6', 'Op');" <?php if(isset($drstocksinvestments->Op_StockInvestments_Disposition_Method6) && $drstocksinvestments->Op_StockInvestments_Disposition_Method6=='Distribute Investments'){ echo "checked"; } ?>> Distribute Investments</label>
                                        <label><input type="radio" id="Op_StockInvestments_Disposition_Method6_Liquidate_Split_Net_Value" name="Op_StockInvestments_Disposition_Method6" value="Liquidate/Split Net Value" data-onload="getInitialDipositionMethod(this, '6', 'Op');" onchange="getDipositionMethod(this, '6', 'Op');" <?php if(isset($drstocksinvestments->Op_StockInvestments_Disposition_Method6) && $drstocksinvestments->Op_StockInvestments_Disposition_Method6=='Liquidate/Split Net Value'){ echo "checked"; } ?>> Liquidate/Split Net Value</label>
                                        <label><input type="radio" id="Op_StockInvestments_Disposition_Method6_Percentage_Buyout" name="Op_StockInvestments_Disposition_Method6" value="Percentage Buyout" data-onload="getInitialDipositionMethod(this, '6', 'Op');" onchange="getDipositionMethod(this, '6', 'Op');" <?php if(isset($drstocksinvestments->Op_StockInvestments_Disposition_Method6) && $drstocksinvestments->Op_StockInvestments_Disposition_Method6=='Percentage Buyout'){ echo "checked"; } ?>> Percentage Buyout</label>
                                        <label><input type="radio" id="Op_StockInvestments_Disposition_Method6_Fixed Buyout" name="Op_StockInvestments_Disposition_Method6" value="Fixed Buyout" data-onload="getInitialDipositionMethod(this, '6', 'Op');" onchange="getDipositionMethod(this, '6', 'Op');" <?php if(isset($drstocksinvestments->Op_StockInvestments_Disposition_Method6) && $drstocksinvestments->Op_StockInvestments_Disposition_Method6=='Fixed Buyout'){ echo "checked"; } ?>> Fixed Buyout</label>
                                    </div>
                                </div>
                                <!-- slider tool -->
                                <div class="form-group col-sm-6 m-auto 6_Op_Slider_Tool slider-tool-main">
                                    <div class="row">
                                        <div class="col">{{$client_name}}</div>
                                        <div class="col text-right">{{$opponent_name}}</div>
                                    </div>
                                    <input id="6_Op_balance_range_selector" type="range" class="form-control slider-tool-input 6_Op_balance_range_selector" name="" value="<?php if(isset($drstocksinvestments->Op_StockInvestments_Percent_Marital_Equity_to_Op6)){ echo $drstocksinvestments->Op_StockInvestments_Percent_Marital_Equity_to_Op6; } ?>" min="0.00" step="0.01" max="100" onchange="updateBalanceInput(this.value, '6', 'Op');">
                                </div>
                                <div class="form-group col-sm-6 m-auto 6_Op_Slider_Tool slider-tool-main">
                                    <div class="row justify-content-between">
                                        <div class="col selectorTool">
                                            <div class="left-col">
                                                <div class="client-info 6_Op_clientpercentage_div clientpercentage_div">
                                                    <?php if(isset($drstocksinvestments->Op_StockInvestments_Percent_Marital_Equity_to_Client6)){ echo $drstocksinvestments->Op_StockInvestments_Percent_Marital_Equity_to_Client6; } else {
                                                        echo "50.00";
                                                    } ?>%
                                                </div>
                                                <div class="client-info 6_Op_clientamount_div clientamount_div" style="clear: both;">
                                                    $<?php if(isset($drstocksinvestments->Op_StockInvestments_Estimated_Value_to_Client6)){ echo $drstocksinvestments->Op_StockInvestments_Estimated_Value_to_Client6; }else {
                                                        echo "0.00";
                                                    } ?>
                                                </div>
                                            </div>
                                            <label>To {{$client_name}}</label>
                                        </div>                                       
                                        <div class="col selectorTool selectorToolRight">
                                            <label>To {{$opponent_name}}</label>
                                            <div class="left-col right-col">
                                                <div class="client-info 6_Op_opponentpercentage_div opponentpercentage_div">
                                                    <?php if(isset($drstocksinvestments->Op_StockInvestments_Percent_Marital_Equity_to_Op6)){ echo $drstocksinvestments->Op_StockInvestments_Percent_Marital_Equity_to_Op6; } else {
                                                        echo "50.00";
                                                    } ?>%
                                                </div>
                                                <div class="client-info 6_Op_opponentamount_div opponentamount_div" style="clear: both;">
                                                    $<?php if(isset($drstocksinvestments->Op_StockInvestments_Estimated_Value_to_Op6)){ echo $drstocksinvestments->Op_StockInvestments_Estimated_Value_to_Op6; }else {
                                                        echo "0.00";
                                                    } ?>
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
                                         <label><input type="radio" id="Op_StockInvestments_Paying_Party6_Client" name="Op_StockInvestments_Paying_Party6" value="{{$client_name}}" data-onload="getInitialStockInvestmentPayingParty(this, '6', 'Op');" onchange="getStockInvestmentPayingParty(this, '6', 'Op');"  <?php if(isset($drstocksinvestments->Op_StockInvestments_Paying_Party6) && $drstocksinvestments->Op_StockInvestments_Paying_Party6==$client_name){ echo "checked"; } ?>> {{$client_name}}</label>
                                        <label><input type="radio" id="Op_StockInvestments_Paying_Party6_Op" name="Op_StockInvestments_Paying_Party6" value="{{$opponent_name}}" data-onload="getInitialStockInvestmentPayingParty(this, '6', 'Op');" onchange="getStockInvestmentPayingParty(this, '6', 'Op');"  <?php if(isset($drstocksinvestments->Op_StockInvestments_Paying_Party6) && $drstocksinvestments->Op_StockInvestments_Paying_Party6==$opponent_name){ echo "checked"; } ?>> {{$opponent_name}}</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 Op_StockInvestments_Paying_Party6_Inputs_Div" style="display: none;">
                                    <label>{{$client_name}} StockInvestment Equity Percent</label>
                                    <input id="Op_StockInvestments_Percent_Marital_Equity_to_Client6" type="number" class="form-control 6_Op_clientpercentage_input clientpercentage_input" name="Op_StockInvestments_Percent_Marital_Equity_to_Client6" value="<?php if(isset($drstocksinvestments->Op_StockInvestments_Percent_Marital_Equity_to_Client6)){ echo $drstocksinvestments->Op_StockInvestments_Percent_Marital_Equity_to_Client6; } ?>" min="0.00" step="0.01" max="100" readonly="">
                                </div>
                                <div class="form-group col-sm-6 Op_StockInvestments_Paying_Party6_Inputs_Div" style="display: none;">
                                    <label>How much is to be paid to {{$client_name}}?</label>
                                    <input id="Op_StockInvestments_Estimated_Value_to_Client6" type="number" class="form-control 6_Op_clientamount_input clientamount_input" name="Op_StockInvestments_Estimated_Value_to_Client6" value="<?php if(isset($drstocksinvestments->Op_StockInvestments_Estimated_Value_to_Client6)){ echo $drstocksinvestments->Op_StockInvestments_Estimated_Value_to_Client6; } ?>" min="0.00" step="0.01" max="999999.99" readonly="" onchange="getEstimatedValueClient(this, '6', 'Op');" onkeyup="getEstimatedValueClient(this, '6', 'Op');">
                                </div>
                                <div class="form-group col-sm-6 Op_StockInvestments_Paying_Party6_Inputs_Div" style="display: none;">
                                    <label>{{$opponent_name}} StockInvestment Equity Percent</label>
                                    <input id="Op_StockInvestments_Percent_Marital_Equity_to_Op6" type="number" class="form-control 6_Op_opponentpercentage_input opponentpercentage_input" name="Op_StockInvestments_Percent_Marital_Equity_to_Op6" value="<?php if(isset($drstocksinvestments->Op_StockInvestments_Percent_Marital_Equity_to_Op6)){ echo $drstocksinvestments->Op_StockInvestments_Percent_Marital_Equity_to_Op6; } ?>" min="0.00" step="0.01" max="100" readonly="">
                                </div>
                                <div class="form-group col-sm-6 Op_StockInvestments_Paying_Party6_Inputs_Div" style="display: none;">
                                    <label>How much is to be paid to {{$opponent_name}}?</label>
                                    <input id="Op_StockInvestments_Estimated_Value_to_Op6" type="number" class="form-control 6_Op_opponentamount_input opponentamount_input" name="Op_StockInvestments_Estimated_Value_to_Op6" value="<?php if(isset($drstocksinvestments->Op_StockInvestments_Estimated_Value_to_Op6)){ echo $drstocksinvestments->Op_StockInvestments_Estimated_Value_to_Op6; } ?>" min="0.00" step="0.01" max="999999.99" readonly="" onchange="getEstimatedValueOp(this, '6', 'Op');" onkeyup="getEstimatedValueOp(this, '6', 'Op');">
                                </div>
                                <!-- end of slider tool -->
                            </div>
                            <div class="col-sm-12 mt-4 7_Op_stocksinvestments_section" style="display: none;"><h5 class="col-sm-12">Seventh Stock Investment Info</h5>
                                <div class="form-group col-sm-6">
                                    <p class="text-danger 7_Op_no-state-county-found" style="display: none;">No City, State, County found for this zipcode.</p>
                                    <label for="Op_StockInvestments_Institution_ZIP7">Stock/Investment Institution Zip Code?</label>
                                    <input id="Op_StockInvestments_Institution_ZIP7" type="text" class="form-control 7_Op_stocksinvestments_inputs" name="Op_StockInvestments_Institution_ZIP7" value="<?php if(isset($drstocksinvestments->Op_StockInvestments_Institution_ZIP7)){ echo $drstocksinvestments->Op_StockInvestments_Institution_ZIP7; } ?>" data-onload="getCityStateForZip(this, '7', 'Op');" onkeyup="getCityStateForZip(this, '7', 'Op');"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_StockInvestments_Institution_Name7">Name of Stock/Investment Institution?</label>
                                    <input id="Op_StockInvestments_Institution_Name7" type="text" class="form-control 7_Op_stocksinvestments_inputs" name="Op_StockInvestments_Institution_Name7" value="<?php if(isset($drstocksinvestments->Op_StockInvestments_Institution_Name7)){ echo $drstocksinvestments->Op_StockInvestments_Institution_Name7; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_StockInvestments_Institution_Street_Address7">Stock/Investment Institution Street Address?</label>
                                    <input id="Op_StockInvestments_Institution_Street_Address7" type="text" class="form-control 7_Op_stocksinvestments_inputs" name="Op_StockInvestments_Institution_Street_Address7" value="<?php if(isset($drstocksinvestments->Op_StockInvestments_Institution_Street_Address7)){ echo $drstocksinvestments->Op_StockInvestments_Institution_Street_Address7; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_StockInvestments_Institution_City7">Stock/Investment Institution City?</label>
                                    <input type="hidden" name="" id="Op_StockInvestments_Institution_City7_Value" value="<?php if(isset($drstocksinvestments->Op_StockInvestments_Institution_City7)){ echo $drstocksinvestments->Op_StockInvestments_Institution_City7; } ?>">
                                    <select id="Op_StockInvestments_Institution_City7" name="Op_StockInvestments_Institution_City7" class="form-control 7_Op_city_select">
                                        <option value="">Choose City</option>
                                    </select>   
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_StockInvestments_Institution_State7">Stock/Investment Institution State?</label>
                                    <input type="hidden" name="" id="Op_StockInvestments_Institution_State7_Value" value="<?php if(isset($drstocksinvestments->Op_StockInvestments_Institution_State7)){ echo $drstocksinvestments->Op_StockInvestments_Institution_State7; } ?>">
                                    <select id="Op_StockInvestments_Institution_State7" name="Op_StockInvestments_Institution_State7" class="form-control 7_Op_state_select">
                                        <option value="">Choose State</option>
                                    </select>   
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_StockInvestments_Acct_Num7">Account Number?</label>
                                    <input id="Op_StockInvestments_Acct_Num7" type="text" class="form-control 7_Op_stocksinvestments_inputs" name="Op_StockInvestments_Acct_Num7" value="<?php if(isset($drstocksinvestments->Op_StockInvestments_Acct_Num7)){ echo $drstocksinvestments->Op_StockInvestments_Acct_Num7; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_StockInvestments_Date_Marriage_Value7">Marriage Date Value?</label>
                                    <input id="Op_StockInvestments_Date_Marriage_Value7" type="number" class="form-control 7_Op_stocksinvestments_inputs" name="Op_StockInvestments_Date_Marriage_Value7" value="<?php if(isset($drstocksinvestments->Op_StockInvestments_Date_Marriage_Value7)){ echo $drstocksinvestments->Op_StockInvestments_Date_Marriage_Value7; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_StockInvestments_Current_Value7">Current Value?</label>
                                    <input id="Op_StockInvestments_Current_Value7" type="number" class="form-control 7_Op_stocksinvestments_inputs" name="Op_StockInvestments_Current_Value7" value="<?php if(isset($drstocksinvestments->Op_StockInvestments_Current_Value7)){ echo $drstocksinvestments->Op_StockInvestments_Current_Value7; } ?>" min="0.00" step="0.01" max="999999.99" onchange="getJointCurrentValue(this, '7', 'Op');" onkeyup="getJointCurrentValue(this, '7', 'Op');"> 
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label for="Op_StockInvestments_Percent_Marital_Equity7">N/A, calculated = Op_StockInvestments_Institution_Current_Value7</label>
                                    <input id="Op_StockInvestments_Percent_Marital_Equity7" type="number" class="form-control 7_Op_stocksinvestments_inputs" name="Op_StockInvestments_Percent_Marital_Equity7" value="<?php if(isset($drstocksinvestments->Op_StockInvestments_Percent_Marital_Equity7)){ echo $drstocksinvestments->Op_StockInvestments_Percent_Marital_Equity7; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_StockInvestments_Yearly_Interest_Dividend7">Yearly Interest and Dividends from this account?</label>
                                    <input id="Op_StockInvestments_Yearly_Interest_Dividend7" type="number" class="form-control 7_Op_stocksinvestments_inputs" name="Op_StockInvestments_Yearly_Interest_Dividend7" value="<?php if(isset($drstocksinvestments->Op_StockInvestments_Yearly_Interest_Dividend7)){ echo $drstocksinvestments->Op_StockInvestments_Yearly_Interest_Dividend7; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Does either party claim a sole/separate interest from the other on this account?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Op_StockInvestments_SoleSeparate_Claim7_Yes" name="Op_StockInvestments_SoleSeparate_Claim7" value="Yes" data-onload="getInitialPartyClaimSoleSeparate(this, '7', 'Op');" onchange="getPartyClaimSoleSeparate(this, '7', 'Op');" <?php if(isset($drstocksinvestments->Op_StockInvestments_SoleSeparate_Claim7) && $drstocksinvestments->Op_StockInvestments_SoleSeparate_Claim7=='Yes'){ echo "checked"; } ?>> Yes</label>
                                        <label><input type="radio" id="Op_StockInvestments_SoleSeparate_Claim7_No" name="Op_StockInvestments_SoleSeparate_Claim7" value="No" data-onload="getInitialPartyClaimSoleSeparate(this, '7', 'Op');" onchange="getPartyClaimSoleSeparate(this, '7', 'Op');" <?php if(isset($drstocksinvestments->Op_StockInvestments_SoleSeparate_Claim7) && $drstocksinvestments->Op_StockInvestments_SoleSeparate_Claim7=='No'){ echo "checked"; } ?>> No</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6" id="Op_StockInvestments_SoleSeparate_Party7_Div" style="display: none;">
                                    <label>Who claims to own this account?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Op_StockInvestments_SoleSeparate_Party7_Client" name="Op_StockInvestments_SoleSeparate_Party7" value="{{$client_name}}" <?php if(isset($drstocksinvestments->Op_StockInvestments_SoleSeparate_Party7) && $drstocksinvestments->Op_StockInvestments_SoleSeparate_Party7==$client_name){ echo "checked"; } ?>> {{$client_name}}</label>
                                        <label><input type="radio" id="Op_StockInvestments_SoleSeparate_Party7_Op" name="Op_StockInvestments_SoleSeparate_Party7" value="{{$opponent_name}}" <?php if(isset($drstocksinvestments->Op_StockInvestments_SoleSeparate_Party7) && $drstocksinvestments->Op_StockInvestments_SoleSeparate_Party7==$opponent_name){ echo "checked"; } ?>> {{$opponent_name}}</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 left-clear" id="Op_StockInvestments_SoleSeparate_Grounds7_Div" style="display: none; clear: left;">
                                    <label for="Op_StockInvestments_SoleSeparate_Grounds7">Why does this person own this account solely and separately?</label>
                                    <input id="Op_StockInvestments_SoleSeparate_Grounds7" type="text" class="form-control 7_Op_stocksinvestments_inputs" name="Op_StockInvestments_SoleSeparate_Grounds7" value="<?php if(isset($drstocksinvestments->Op_StockInvestments_SoleSeparate_Grounds7)){ echo $drstocksinvestments->Op_StockInvestments_SoleSeparate_Grounds7; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>How will this account value be distributed between the parties?</label>
                                    <div class="w-100 dataInput">
                                        <label><input type="radio" id="Op_StockInvestments_Disposition_Method7_Distribute_Investments" name="Op_StockInvestments_Disposition_Method7" value="Distribute Investments" data-onload="getInitialDipositionMethod(this, '7', 'Op');" onchange="getDipositionMethod(this, '7', 'Op');" <?php if(isset($drstocksinvestments->Op_StockInvestments_Disposition_Method7) && $drstocksinvestments->Op_StockInvestments_Disposition_Method7=='Distribute Investments'){ echo "checked"; } ?>> Distribute Investments</label>
                                        <label><input type="radio" id="Op_StockInvestments_Disposition_Method7_Liquidate_Split_Net_Value" name="Op_StockInvestments_Disposition_Method7" value="Liquidate/Split Net Value" data-onload="getInitialDipositionMethod(this, '7', 'Op');" onchange="getDipositionMethod(this, '7', 'Op');" <?php if(isset($drstocksinvestments->Op_StockInvestments_Disposition_Method7) && $drstocksinvestments->Op_StockInvestments_Disposition_Method7=='Liquidate/Split Net Value'){ echo "checked"; } ?>> Liquidate/Split Net Value</label>
                                        <label><input type="radio" id="Op_StockInvestments_Disposition_Method7_Percentage_Buyout" name="Op_StockInvestments_Disposition_Method7" value="Percentage Buyout" data-onload="getInitialDipositionMethod(this, '7', 'Op');" onchange="getDipositionMethod(this, '7', 'Op');" <?php if(isset($drstocksinvestments->Op_StockInvestments_Disposition_Method7) && $drstocksinvestments->Op_StockInvestments_Disposition_Method7=='Percentage Buyout'){ echo "checked"; } ?>> Percentage Buyout</label>
                                        <label><input type="radio" id="Op_StockInvestments_Disposition_Method7_Fixed Buyout" name="Op_StockInvestments_Disposition_Method7" value="Fixed Buyout" data-onload="getInitialDipositionMethod(this, '7', 'Op');" onchange="getDipositionMethod(this, '7', 'Op');" <?php if(isset($drstocksinvestments->Op_StockInvestments_Disposition_Method7) && $drstocksinvestments->Op_StockInvestments_Disposition_Method7=='Fixed Buyout'){ echo "checked"; } ?>> Fixed Buyout</label>
                                    </div>
                                </div>
                                <!-- slider tool -->
                                <div class="form-group col-sm-6 m-auto 7_Op_Slider_Tool slider-tool-main">
                                    <div class="row">
                                        <div class="col">{{$client_name}}</div>
                                        <div class="col text-right">{{$opponent_name}}</div>
                                    </div>
                                    <input id="7_Op_balance_range_selector" type="range" class="form-control slider-tool-input 7_Op_balance_range_selector" name="" value="<?php if(isset($drstocksinvestments->Op_StockInvestments_Percent_Marital_Equity_to_Op7)){ echo $drstocksinvestments->Op_StockInvestments_Percent_Marital_Equity_to_Op7; } ?>" min="0.00" step="0.01" max="100" onchange="updateBalanceInput(this.value, '7', 'Op');">
                                </div>
                                <div class="form-group col-sm-6 m-auto 7_Op_Slider_Tool slider-tool-main">
                                    <div class="row justify-content-between">
                                        <div class="col selectorTool">
                                            <div class="left-col">
                                                <div class="client-info 7_Op_clientpercentage_div clientpercentage_div">
                                                    <?php if(isset($drstocksinvestments->Op_StockInvestments_Percent_Marital_Equity_to_Client7)){ echo $drstocksinvestments->Op_StockInvestments_Percent_Marital_Equity_to_Client7; } else {
                                                        echo "50.00";
                                                    } ?>%
                                                </div>
                                                <div class="client-info 7_Op_clientamount_div clientamount_div" style="clear: both;">
                                                    $<?php if(isset($drstocksinvestments->Op_StockInvestments_Estimated_Value_to_Client7)){ echo $drstocksinvestments->Op_StockInvestments_Estimated_Value_to_Client7; }else {
                                                        echo "0.00";
                                                    } ?>
                                                </div>
                                            </div>
                                            <label>To {{$client_name}}</label>
                                        </div>                                       
                                        <div class="col selectorTool selectorToolRight">
                                            <label>To {{$opponent_name}}</label>
                                            <div class="left-col right-col">
                                                <div class="client-info 7_Op_opponentpercentage_div opponentpercentage_div">
                                                    <?php if(isset($drstocksinvestments->Op_StockInvestments_Percent_Marital_Equity_to_Op7)){ echo $drstocksinvestments->Op_StockInvestments_Percent_Marital_Equity_to_Op7; } else {
                                                        echo "50.00";
                                                    } ?>%
                                                </div>
                                                <div class="client-info 7_Op_opponentamount_div opponentamount_div" style="clear: both;">
                                                    $<?php if(isset($drstocksinvestments->Op_StockInvestments_Estimated_Value_to_Op7)){ echo $drstocksinvestments->Op_StockInvestments_Estimated_Value_to_Op7; }else {
                                                        echo "0.00";
                                                    } ?>
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
                                         <label><input type="radio" id="Op_StockInvestments_Paying_Party7_Client" name="Op_StockInvestments_Paying_Party7" value="{{$client_name}}" data-onload="getInitialStockInvestmentPayingParty(this, '7', 'Op');" onchange="getStockInvestmentPayingParty(this, '7', 'Op');"  <?php if(isset($drstocksinvestments->Op_StockInvestments_Paying_Party7) && $drstocksinvestments->Op_StockInvestments_Paying_Party7==$client_name){ echo "checked"; } ?>> {{$client_name}}</label>
                                        <label><input type="radio" id="Op_StockInvestments_Paying_Party7_Op" name="Op_StockInvestments_Paying_Party7" value="{{$opponent_name}}" data-onload="getInitialStockInvestmentPayingParty(this, '7', 'Op');" onchange="getStockInvestmentPayingParty(this, '7', 'Op');"  <?php if(isset($drstocksinvestments->Op_StockInvestments_Paying_Party7) && $drstocksinvestments->Op_StockInvestments_Paying_Party7==$opponent_name){ echo "checked"; } ?>> {{$opponent_name}}</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 Op_StockInvestments_Paying_Party7_Inputs_Div" style="display: none;">
                                    <label>{{$client_name}} StockInvestment Equity Percent</label>
                                    <input id="Op_StockInvestments_Percent_Marital_Equity_to_Client7" type="number" class="form-control 7_Op_clientpercentage_input clientpercentage_input" name="Op_StockInvestments_Percent_Marital_Equity_to_Client7" value="<?php if(isset($drstocksinvestments->Op_StockInvestments_Percent_Marital_Equity_to_Client7)){ echo $drstocksinvestments->Op_StockInvestments_Percent_Marital_Equity_to_Client7; } ?>" min="0.00" step="0.01" max="100" readonly="">
                                </div>
                                <div class="form-group col-sm-6 Op_StockInvestments_Paying_Party7_Inputs_Div" style="display: none;">
                                    <label>How much is to be paid to {{$client_name}}?</label>
                                    <input id="Op_StockInvestments_Estimated_Value_to_Client7" type="number" class="form-control 7_Op_clientamount_input clientamount_input" name="Op_StockInvestments_Estimated_Value_to_Client7" value="<?php if(isset($drstocksinvestments->Op_StockInvestments_Estimated_Value_to_Client7)){ echo $drstocksinvestments->Op_StockInvestments_Estimated_Value_to_Client7; } ?>" min="0.00" step="0.01" max="999999.99" readonly="" onchange="getEstimatedValueClient(this, '7', 'Op');" onkeyup="getEstimatedValueClient(this, '7', 'Op');">
                                </div>
                                <div class="form-group col-sm-6 Op_StockInvestments_Paying_Party7_Inputs_Div" style="display: none;">
                                    <label>{{$opponent_name}} StockInvestment Equity Percent</label>
                                    <input id="Op_StockInvestments_Percent_Marital_Equity_to_Op7" type="number" class="form-control 7_Op_opponentpercentage_input opponentpercentage_input" name="Op_StockInvestments_Percent_Marital_Equity_to_Op7" value="<?php if(isset($drstocksinvestments->Op_StockInvestments_Percent_Marital_Equity_to_Op7)){ echo $drstocksinvestments->Op_StockInvestments_Percent_Marital_Equity_to_Op7; } ?>" min="0.00" step="0.01" max="100" readonly="">
                                </div>
                                <div class="form-group col-sm-6 Op_StockInvestments_Paying_Party7_Inputs_Div" style="display: none;">
                                    <label>How much is to be paid to {{$opponent_name}}?</label>
                                    <input id="Op_StockInvestments_Estimated_Value_to_Op7" type="number" class="form-control 7_Op_opponentamount_input opponentamount_input" name="Op_StockInvestments_Estimated_Value_to_Op7" value="<?php if(isset($drstocksinvestments->Op_StockInvestments_Estimated_Value_to_Op7)){ echo $drstocksinvestments->Op_StockInvestments_Estimated_Value_to_Op7; } ?>" min="0.00" step="0.01" max="999999.99" readonly="" onchange="getEstimatedValueOp(this, '7', 'Op');" onkeyup="getEstimatedValueOp(this, '7', 'Op');">
                                </div>
                                <!-- end of slider tool -->
                            </div>
                            <div class="col-sm-12 mt-4 8_Op_stocksinvestments_section" style="display: none;"><h5 class="col-sm-12">Eighth Stock Investment Info</h5>
                                <div class="form-group col-sm-6">
                                    <p class="text-danger 8_Op_no-state-county-found" style="display: none;">No City, State, County found for this zipcode.</p>
                                    <label for="Op_StockInvestments_Institution_ZIP8">Stock/Investment Institution Zip Code?</label>
                                    <input id="Op_StockInvestments_Institution_ZIP8" type="text" class="form-control 8_Op_stocksinvestments_inputs" name="Op_StockInvestments_Institution_ZIP8" value="<?php if(isset($drstocksinvestments->Op_StockInvestments_Institution_ZIP8)){ echo $drstocksinvestments->Op_StockInvestments_Institution_ZIP8; } ?>" data-onload="getCityStateForZip(this, '8', 'Op');" onkeyup="getCityStateForZip(this, '8', 'Op');"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_StockInvestments_Institution_Name8">Name of Stock/Investment Institution?</label>
                                    <input id="Op_StockInvestments_Institution_Name8" type="text" class="form-control 8_Op_stocksinvestments_inputs" name="Op_StockInvestments_Institution_Name8" value="<?php if(isset($drstocksinvestments->Op_StockInvestments_Institution_Name8)){ echo $drstocksinvestments->Op_StockInvestments_Institution_Name8; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_StockInvestments_Institution_Street_Address8">Stock/Investment Institution Street Address?</label>
                                    <input id="Op_StockInvestments_Institution_Street_Address8" type="text" class="form-control 8_Op_stocksinvestments_inputs" name="Op_StockInvestments_Institution_Street_Address8" value="<?php if(isset($drstocksinvestments->Op_StockInvestments_Institution_Street_Address8)){ echo $drstocksinvestments->Op_StockInvestments_Institution_Street_Address8; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_StockInvestments_Institution_City8">Stock/Investment Institution City?</label>
                                    <input type="hidden" name="" id="Op_StockInvestments_Institution_City8_Value" value="<?php if(isset($drstocksinvestments->Op_StockInvestments_Institution_City8)){ echo $drstocksinvestments->Op_StockInvestments_Institution_City8; } ?>">
                                    <select id="Op_StockInvestments_Institution_City8" name="Op_StockInvestments_Institution_City8" class="form-control 8_Op_city_select">
                                        <option value="">Choose City</option>
                                    </select>   
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_StockInvestments_Institution_State8">Stock/Investment Institution State?</label>
                                    <input type="hidden" name="" id="Op_StockInvestments_Institution_State8_Value" value="<?php if(isset($drstocksinvestments->Op_StockInvestments_Institution_State8)){ echo $drstocksinvestments->Op_StockInvestments_Institution_State8; } ?>">
                                    <select id="Op_StockInvestments_Institution_State8" name="Op_StockInvestments_Institution_State8" class="form-control 8_Op_state_select">
                                        <option value="">Choose State</option>
                                    </select>   
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_StockInvestments_Acct_Num8">Account Number?</label>
                                    <input id="Op_StockInvestments_Acct_Num8" type="text" class="form-control 8_Op_stocksinvestments_inputs" name="Op_StockInvestments_Acct_Num8" value="<?php if(isset($drstocksinvestments->Op_StockInvestments_Acct_Num8)){ echo $drstocksinvestments->Op_StockInvestments_Acct_Num8; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_StockInvestments_Date_Marriage_Value8">Marriage Date Value?</label>
                                    <input id="Op_StockInvestments_Date_Marriage_Value8" type="number" class="form-control 8_Op_stocksinvestments_inputs" name="Op_StockInvestments_Date_Marriage_Value8" value="<?php if(isset($drstocksinvestments->Op_StockInvestments_Date_Marriage_Value8)){ echo $drstocksinvestments->Op_StockInvestments_Date_Marriage_Value8; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_StockInvestments_Current_Value8">Current Value?</label>
                                    <input id="Op_StockInvestments_Current_Value8" type="number" class="form-control 8_Op_stocksinvestments_inputs" name="Op_StockInvestments_Current_Value8" value="<?php if(isset($drstocksinvestments->Op_StockInvestments_Current_Value8)){ echo $drstocksinvestments->Op_StockInvestments_Current_Value8; } ?>" min="0.00" step="0.01" max="999999.99" onchange="getJointCurrentValue(this, '8', 'Op');" onkeyup="getJointCurrentValue(this, '8', 'Op');"> 
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label for="Op_StockInvestments_Percent_Marital_Equity8">N/A, calculated = Op_StockInvestments_Institution_Current_Value8</label>
                                    <input id="Op_StockInvestments_Percent_Marital_Equity8" type="number" class="form-control 8_Op_stocksinvestments_inputs" name="Op_StockInvestments_Percent_Marital_Equity8" value="<?php if(isset($drstocksinvestments->Op_StockInvestments_Percent_Marital_Equity8)){ echo $drstocksinvestments->Op_StockInvestments_Percent_Marital_Equity8; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_StockInvestments_Yearly_Interest_Dividend8">Yearly Interest and Dividends from this account?</label>
                                    <input id="Op_StockInvestments_Yearly_Interest_Dividend8" type="number" class="form-control 8_Op_stocksinvestments_inputs" name="Op_StockInvestments_Yearly_Interest_Dividend8" value="<?php if(isset($drstocksinvestments->Op_StockInvestments_Yearly_Interest_Dividend8)){ echo $drstocksinvestments->Op_StockInvestments_Yearly_Interest_Dividend8; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Does either party claim a sole/separate interest from the other on this account?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Op_StockInvestments_SoleSeparate_Claim8_Yes" name="Op_StockInvestments_SoleSeparate_Claim8" value="Yes" data-onload="getInitialPartyClaimSoleSeparate(this, '8', 'Op');" onchange="getPartyClaimSoleSeparate(this, '8', 'Op');" <?php if(isset($drstocksinvestments->Op_StockInvestments_SoleSeparate_Claim8) && $drstocksinvestments->Op_StockInvestments_SoleSeparate_Claim8=='Yes'){ echo "checked"; } ?>> Yes</label>
                                        <label><input type="radio" id="Op_StockInvestments_SoleSeparate_Claim8_No" name="Op_StockInvestments_SoleSeparate_Claim8" value="No" data-onload="getInitialPartyClaimSoleSeparate(this, '8', 'Op');" onchange="getPartyClaimSoleSeparate(this, '8', 'Op');" <?php if(isset($drstocksinvestments->Op_StockInvestments_SoleSeparate_Claim8) && $drstocksinvestments->Op_StockInvestments_SoleSeparate_Claim8=='No'){ echo "checked"; } ?>> No</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6" id="Op_StockInvestments_SoleSeparate_Party8_Div" style="display: none;">
                                    <label>Who claims to own this account?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Op_StockInvestments_SoleSeparate_Party8_Client" name="Op_StockInvestments_SoleSeparate_Party8" value="{{$client_name}}" <?php if(isset($drstocksinvestments->Op_StockInvestments_SoleSeparate_Party8) && $drstocksinvestments->Op_StockInvestments_SoleSeparate_Party8==$client_name){ echo "checked"; } ?>> {{$client_name}}</label>
                                        <label><input type="radio" id="Op_StockInvestments_SoleSeparate_Party8_Op" name="Op_StockInvestments_SoleSeparate_Party8" value="{{$opponent_name}}" <?php if(isset($drstocksinvestments->Op_StockInvestments_SoleSeparate_Party8) && $drstocksinvestments->Op_StockInvestments_SoleSeparate_Party8==$opponent_name){ echo "checked"; } ?>> {{$opponent_name}}</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 left-clear" id="Op_StockInvestments_SoleSeparate_Grounds8_Div" style="display: none; clear: left;">
                                    <label for="Op_StockInvestments_SoleSeparate_Grounds8">Why does this person own this account solely and separately?</label>
                                    <input id="Op_StockInvestments_SoleSeparate_Grounds8" type="text" class="form-control 8_Op_stocksinvestments_inputs" name="Op_StockInvestments_SoleSeparate_Grounds8" value="<?php if(isset($drstocksinvestments->Op_StockInvestments_SoleSeparate_Grounds8)){ echo $drstocksinvestments->Op_StockInvestments_SoleSeparate_Grounds8; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>How will this account value be distributed between the parties?</label>
                                    <div class="w-100 dataInput">
                                        <label><input type="radio" id="Op_StockInvestments_Disposition_Method8_Distribute_Investments" name="Op_StockInvestments_Disposition_Method8" value="Distribute Investments" data-onload="getInitialDipositionMethod(this, '8', 'Op');" onchange="getDipositionMethod(this, '8', 'Op');" <?php if(isset($drstocksinvestments->Op_StockInvestments_Disposition_Method8) && $drstocksinvestments->Op_StockInvestments_Disposition_Method8=='Distribute Investments'){ echo "checked"; } ?>> Distribute Investments</label>
                                        <label><input type="radio" id="Op_StockInvestments_Disposition_Method8_Liquidate_Split_Net_Value" name="Op_StockInvestments_Disposition_Method8" value="Liquidate/Split Net Value" data-onload="getInitialDipositionMethod(this, '8', 'Op');" onchange="getDipositionMethod(this, '8', 'Op');" <?php if(isset($drstocksinvestments->Op_StockInvestments_Disposition_Method8) && $drstocksinvestments->Op_StockInvestments_Disposition_Method8=='Liquidate/Split Net Value'){ echo "checked"; } ?>> Liquidate/Split Net Value</label>
                                        <label><input type="radio" id="Op_StockInvestments_Disposition_Method8_Percentage_Buyout" name="Op_StockInvestments_Disposition_Method8" value="Percentage Buyout" data-onload="getInitialDipositionMethod(this, '8', 'Op');" onchange="getDipositionMethod(this, '8', 'Op');" <?php if(isset($drstocksinvestments->Op_StockInvestments_Disposition_Method8) && $drstocksinvestments->Op_StockInvestments_Disposition_Method8=='Percentage Buyout'){ echo "checked"; } ?>> Percentage Buyout</label>
                                        <label><input type="radio" id="Op_StockInvestments_Disposition_Method8_Fixed Buyout" name="Op_StockInvestments_Disposition_Method8" value="Fixed Buyout" data-onload="getInitialDipositionMethod(this, '8', 'Op');" onchange="getDipositionMethod(this, '8', 'Op');" <?php if(isset($drstocksinvestments->Op_StockInvestments_Disposition_Method8) && $drstocksinvestments->Op_StockInvestments_Disposition_Method8=='Fixed Buyout'){ echo "checked"; } ?>> Fixed Buyout</label>
                                    </div>
                                </div>
                                <!-- slider tool -->
                                <div class="form-group col-sm-6 m-auto 8_Op_Slider_Tool slider-tool-main">
                                    <div class="row">
                                        <div class="col">{{$client_name}}</div>
                                        <div class="col text-right">{{$opponent_name}}</div>
                                    </div>
                                    <input id="8_Op_balance_range_selector" type="range" class="form-control slider-tool-input 8_Op_balance_range_selector" name="" value="<?php if(isset($drstocksinvestments->Op_StockInvestments_Percent_Marital_Equity_to_Op8)){ echo $drstocksinvestments->Op_StockInvestments_Percent_Marital_Equity_to_Op8; } ?>" min="0.00" step="0.01" max="100" onchange="updateBalanceInput(this.value, '8', 'Op');">
                                </div>
                                <div class="form-group col-sm-6 m-auto 8_Op_Slider_Tool slider-tool-main">
                                    <div class="row justify-content-between">
                                        <div class="col selectorTool">
                                            <div class="left-col">
                                                <div class="client-info 8_Op_clientpercentage_div clientpercentage_div">
                                                    <?php if(isset($drstocksinvestments->Op_StockInvestments_Percent_Marital_Equity_to_Client8)){ echo $drstocksinvestments->Op_StockInvestments_Percent_Marital_Equity_to_Client8; } else {
                                                        echo "50.00";
                                                    } ?>%
                                                </div>
                                                <div class="client-info 8_Op_clientamount_div clientamount_div" style="clear: both;">
                                                    $<?php if(isset($drstocksinvestments->Op_StockInvestments_Estimated_Value_to_Client8)){ echo $drstocksinvestments->Op_StockInvestments_Estimated_Value_to_Client8; }else {
                                                        echo "0.00";
                                                    } ?>
                                                </div>
                                            </div>
                                            <label>To {{$client_name}}</label>
                                        </div>                                       
                                        <div class="col selectorTool selectorToolRight">
                                            <label>To {{$opponent_name}}</label>
                                            <div class="left-col right-col">
                                                <div class="client-info 8_Op_opponentpercentage_div opponentpercentage_div">
                                                    <?php if(isset($drstocksinvestments->Op_StockInvestments_Percent_Marital_Equity_to_Op8)){ echo $drstocksinvestments->Op_StockInvestments_Percent_Marital_Equity_to_Op8; } else {
                                                        echo "50.00";
                                                    } ?>%
                                                </div>
                                                <div class="client-info 8_Op_opponentamount_div opponentamount_div" style="clear: both;">
                                                    $<?php if(isset($drstocksinvestments->Op_StockInvestments_Estimated_Value_to_Op8)){ echo $drstocksinvestments->Op_StockInvestments_Estimated_Value_to_Op8; }else {
                                                        echo "0.00";
                                                    } ?>
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
                                         <label><input type="radio" id="Op_StockInvestments_Paying_Party8_Client" name="Op_StockInvestments_Paying_Party8" value="{{$client_name}}" data-onload="getInitialStockInvestmentPayingParty(this, '8', 'Op');" onchange="getStockInvestmentPayingParty(this, '8', 'Op');"  <?php if(isset($drstocksinvestments->Op_StockInvestments_Paying_Party8) && $drstocksinvestments->Op_StockInvestments_Paying_Party8==$client_name){ echo "checked"; } ?>> {{$client_name}}</label>
                                        <label><input type="radio" id="Op_StockInvestments_Paying_Party8_Op" name="Op_StockInvestments_Paying_Party8" value="{{$opponent_name}}" data-onload="getInitialStockInvestmentPayingParty(this, '8', 'Op');" onchange="getStockInvestmentPayingParty(this, '8', 'Op');"  <?php if(isset($drstocksinvestments->Op_StockInvestments_Paying_Party8) && $drstocksinvestments->Op_StockInvestments_Paying_Party8==$opponent_name){ echo "checked"; } ?>> {{$opponent_name}}</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 Op_StockInvestments_Paying_Party8_Inputs_Div" style="display: none;">
                                    <label>{{$client_name}} StockInvestment Equity Percent</label>
                                    <input id="Op_StockInvestments_Percent_Marital_Equity_to_Client8" type="number" class="form-control 8_Op_clientpercentage_input clientpercentage_input" name="Op_StockInvestments_Percent_Marital_Equity_to_Client8" value="<?php if(isset($drstocksinvestments->Op_StockInvestments_Percent_Marital_Equity_to_Client8)){ echo $drstocksinvestments->Op_StockInvestments_Percent_Marital_Equity_to_Client8; } ?>" min="0.00" step="0.01" max="100" readonly="">
                                </div>
                                <div class="form-group col-sm-6 Op_StockInvestments_Paying_Party8_Inputs_Div" style="display: none;">
                                    <label>How much is to be paid to {{$client_name}}?</label>
                                    <input id="Op_StockInvestments_Estimated_Value_to_Client8" type="number" class="form-control 8_Op_clientamount_input clientamount_input" name="Op_StockInvestments_Estimated_Value_to_Client8" value="<?php if(isset($drstocksinvestments->Op_StockInvestments_Estimated_Value_to_Client8)){ echo $drstocksinvestments->Op_StockInvestments_Estimated_Value_to_Client8; } ?>" min="0.00" step="0.01" max="999999.99" readonly="" onchange="getEstimatedValueClient(this, '8', 'Op');" onkeyup="getEstimatedValueClient(this, '8', 'Op');">
                                </div>
                                <div class="form-group col-sm-6 Op_StockInvestments_Paying_Party8_Inputs_Div" style="display: none;">
                                    <label>{{$opponent_name}} StockInvestment Equity Percent</label>
                                    <input id="Op_StockInvestments_Percent_Marital_Equity_to_Op8" type="number" class="form-control 8_Op_opponentpercentage_input opponentpercentage_input" name="Op_StockInvestments_Percent_Marital_Equity_to_Op8" value="<?php if(isset($drstocksinvestments->Op_StockInvestments_Percent_Marital_Equity_to_Op8)){ echo $drstocksinvestments->Op_StockInvestments_Percent_Marital_Equity_to_Op8; } ?>" min="0.00" step="0.01" max="100" readonly="">
                                </div>
                                <div class="form-group col-sm-6 Op_StockInvestments_Paying_Party8_Inputs_Div" style="display: none;">
                                    <label>How much is to be paid to {{$opponent_name}}?</label>
                                    <input id="Op_StockInvestments_Estimated_Value_to_Op8" type="number" class="form-control 8_Op_opponentamount_input opponentamount_input" name="Op_StockInvestments_Estimated_Value_to_Op8" value="<?php if(isset($drstocksinvestments->Op_StockInvestments_Estimated_Value_to_Op8)){ echo $drstocksinvestments->Op_StockInvestments_Estimated_Value_to_Op8; } ?>" min="0.00" step="0.01" max="999999.99" readonly="" onchange="getEstimatedValueOp(this, '8', 'Op');" onkeyup="getEstimatedValueOp(this, '8', 'Op');">
                                </div>
                                <!-- end of slider tool -->
                            </div>
                            <div class="col-sm-12 mt-4 9_Op_stocksinvestments_section" style="display: none;"><h5 class="col-sm-12">Nineth Stock Investment Info</h5>
                                <div class="form-group col-sm-6">
                                    <p class="text-danger 9_Op_no-state-county-found" style="display: none;">No City, State, County found for this zipcode.</p>
                                    <label for="Op_StockInvestments_Institution_ZIP9">Stock/Investment Institution Zip Code?</label>
                                    <input id="Op_StockInvestments_Institution_ZIP9" type="text" class="form-control 9_Op_stocksinvestments_inputs" name="Op_StockInvestments_Institution_ZIP9" value="<?php if(isset($drstocksinvestments->Op_StockInvestments_Institution_ZIP9)){ echo $drstocksinvestments->Op_StockInvestments_Institution_ZIP9; } ?>" data-onload="getCityStateForZip(this, '9', 'Op');" onkeyup="getCityStateForZip(this, '9', 'Op');"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_StockInvestments_Institution_Name9">Name of Stock/Investment Institution?</label>
                                    <input id="Op_StockInvestments_Institution_Name9" type="text" class="form-control 9_Op_stocksinvestments_inputs" name="Op_StockInvestments_Institution_Name9" value="<?php if(isset($drstocksinvestments->Op_StockInvestments_Institution_Name9)){ echo $drstocksinvestments->Op_StockInvestments_Institution_Name9; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_StockInvestments_Institution_Street_Address9">Stock/Investment Institution Street Address?</label>
                                    <input id="Op_StockInvestments_Institution_Street_Address9" type="text" class="form-control 9_Op_stocksinvestments_inputs" name="Op_StockInvestments_Institution_Street_Address9" value="<?php if(isset($drstocksinvestments->Op_StockInvestments_Institution_Street_Address9)){ echo $drstocksinvestments->Op_StockInvestments_Institution_Street_Address9; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_StockInvestments_Institution_City9">Stock/Investment Institution City?</label>
                                    <input type="hidden" name="" id="Op_StockInvestments_Institution_City9_Value" value="<?php if(isset($drstocksinvestments->Op_StockInvestments_Institution_City9)){ echo $drstocksinvestments->Op_StockInvestments_Institution_City9; } ?>">
                                    <select id="Op_StockInvestments_Institution_City9" name="Op_StockInvestments_Institution_City9" class="form-control 9_Op_city_select">
                                        <option value="">Choose City</option>
                                    </select>   
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_StockInvestments_Institution_State9">Stock/Investment Institution State?</label>
                                    <input type="hidden" name="" id="Op_StockInvestments_Institution_State9_Value" value="<?php if(isset($drstocksinvestments->Op_StockInvestments_Institution_State9)){ echo $drstocksinvestments->Op_StockInvestments_Institution_State9; } ?>">
                                    <select id="Op_StockInvestments_Institution_State9" name="Op_StockInvestments_Institution_State9" class="form-control 9_Op_state_select">
                                        <option value="">Choose State</option>
                                    </select>   
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_StockInvestments_Acct_Num9">Account Number?</label>
                                    <input id="Op_StockInvestments_Acct_Num9" type="text" class="form-control 9_Op_stocksinvestments_inputs" name="Op_StockInvestments_Acct_Num9" value="<?php if(isset($drstocksinvestments->Op_StockInvestments_Acct_Num9)){ echo $drstocksinvestments->Op_StockInvestments_Acct_Num9; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_StockInvestments_Date_Marriage_Value9">Marriage Date Value?</label>
                                    <input id="Op_StockInvestments_Date_Marriage_Value9" type="number" class="form-control 9_Op_stocksinvestments_inputs" name="Op_StockInvestments_Date_Marriage_Value9" value="<?php if(isset($drstocksinvestments->Op_StockInvestments_Date_Marriage_Value9)){ echo $drstocksinvestments->Op_StockInvestments_Date_Marriage_Value9; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_StockInvestments_Current_Value9">Current Value?</label>
                                    <input id="Op_StockInvestments_Current_Value9" type="number" class="form-control 9_Op_stocksinvestments_inputs" name="Op_StockInvestments_Current_Value9" value="<?php if(isset($drstocksinvestments->Op_StockInvestments_Current_Value9)){ echo $drstocksinvestments->Op_StockInvestments_Current_Value9; } ?>" min="0.00" step="0.01" max="999999.99" onchange="getJointCurrentValue(this, '9', 'Op');" onkeyup="getJointCurrentValue(this, '9', 'Op');"> 
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label for="Op_StockInvestments_Percent_Marital_Equity9">N/A, calculated = Op_StockInvestments_Institution_Current_Value9</label>
                                    <input id="Op_StockInvestments_Percent_Marital_Equity9" type="number" class="form-control 9_Op_stocksinvestments_inputs" name="Op_StockInvestments_Percent_Marital_Equity9" value="<?php if(isset($drstocksinvestments->Op_StockInvestments_Percent_Marital_Equity9)){ echo $drstocksinvestments->Op_StockInvestments_Percent_Marital_Equity9; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_StockInvestments_Yearly_Interest_Dividend9">Yearly Interest and Dividends from this account?</label>
                                    <input id="Op_StockInvestments_Yearly_Interest_Dividend9" type="number" class="form-control 9_Op_stocksinvestments_inputs" name="Op_StockInvestments_Yearly_Interest_Dividend9" value="<?php if(isset($drstocksinvestments->Op_StockInvestments_Yearly_Interest_Dividend9)){ echo $drstocksinvestments->Op_StockInvestments_Yearly_Interest_Dividend9; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Does either party claim a sole/separate interest from the other on this account?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Op_StockInvestments_SoleSeparate_Claim9_Yes" name="Op_StockInvestments_SoleSeparate_Claim9" value="Yes" data-onload="getInitialPartyClaimSoleSeparate(this, '9', 'Op');" onchange="getPartyClaimSoleSeparate(this, '9', 'Op');" <?php if(isset($drstocksinvestments->Op_StockInvestments_SoleSeparate_Claim9) && $drstocksinvestments->Op_StockInvestments_SoleSeparate_Claim9=='Yes'){ echo "checked"; } ?>> Yes</label>
                                        <label><input type="radio" id="Op_StockInvestments_SoleSeparate_Claim9_No" name="Op_StockInvestments_SoleSeparate_Claim9" value="No" data-onload="getInitialPartyClaimSoleSeparate(this, '9', 'Op');" onchange="getPartyClaimSoleSeparate(this, '9', 'Op');" <?php if(isset($drstocksinvestments->Op_StockInvestments_SoleSeparate_Claim9) && $drstocksinvestments->Op_StockInvestments_SoleSeparate_Claim9=='No'){ echo "checked"; } ?>> No</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6" id="Op_StockInvestments_SoleSeparate_Party9_Div" style="display: none;">
                                    <label>Who claims to own this account?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Op_StockInvestments_SoleSeparate_Party9_Client" name="Op_StockInvestments_SoleSeparate_Party9" value="{{$client_name}}" <?php if(isset($drstocksinvestments->Op_StockInvestments_SoleSeparate_Party9) && $drstocksinvestments->Op_StockInvestments_SoleSeparate_Party9==$client_name){ echo "checked"; } ?>> {{$client_name}}</label>
                                        <label><input type="radio" id="Op_StockInvestments_SoleSeparate_Party9_Op" name="Op_StockInvestments_SoleSeparate_Party9" value="{{$opponent_name}}" <?php if(isset($drstocksinvestments->Op_StockInvestments_SoleSeparate_Party9) && $drstocksinvestments->Op_StockInvestments_SoleSeparate_Party9==$opponent_name){ echo "checked"; } ?>> {{$opponent_name}}</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 left-clear" id="Op_StockInvestments_SoleSeparate_Grounds9_Div" style="display: none; clear: left;">
                                    <label for="Op_StockInvestments_SoleSeparate_Grounds9">Why does this person own this account solely and separately?</label>
                                    <input id="Op_StockInvestments_SoleSeparate_Grounds9" type="text" class="form-control 9_Op_stocksinvestments_inputs" name="Op_StockInvestments_SoleSeparate_Grounds9" value="<?php if(isset($drstocksinvestments->Op_StockInvestments_SoleSeparate_Grounds9)){ echo $drstocksinvestments->Op_StockInvestments_SoleSeparate_Grounds9; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>How will this account value be distributed between the parties?</label>
                                    <div class="w-100 dataInput">
                                        <label><input type="radio" id="Op_StockInvestments_Disposition_Method9_Distribute_Investments" name="Op_StockInvestments_Disposition_Method9" value="Distribute Investments" data-onload="getInitialDipositionMethod(this, '9', 'Op');" onchange="getDipositionMethod(this, '9', 'Op');" <?php if(isset($drstocksinvestments->Op_StockInvestments_Disposition_Method9) && $drstocksinvestments->Op_StockInvestments_Disposition_Method9=='Distribute Investments'){ echo "checked"; } ?>> Distribute Investments</label>
                                        <label><input type="radio" id="Op_StockInvestments_Disposition_Method9_Liquidate_Split_Net_Value" name="Op_StockInvestments_Disposition_Method9" value="Liquidate/Split Net Value" data-onload="getInitialDipositionMethod(this, '9', 'Op');" onchange="getDipositionMethod(this, '9', 'Op');" <?php if(isset($drstocksinvestments->Op_StockInvestments_Disposition_Method9) && $drstocksinvestments->Op_StockInvestments_Disposition_Method9=='Liquidate/Split Net Value'){ echo "checked"; } ?>> Liquidate/Split Net Value</label>
                                        <label><input type="radio" id="Op_StockInvestments_Disposition_Method9_Percentage_Buyout" name="Op_StockInvestments_Disposition_Method9" value="Percentage Buyout" data-onload="getInitialDipositionMethod(this, '9', 'Op');" onchange="getDipositionMethod(this, '9', 'Op');" <?php if(isset($drstocksinvestments->Op_StockInvestments_Disposition_Method9) && $drstocksinvestments->Op_StockInvestments_Disposition_Method9=='Percentage Buyout'){ echo "checked"; } ?>> Percentage Buyout</label>
                                        <label><input type="radio" id="Op_StockInvestments_Disposition_Method9_Fixed Buyout" name="Op_StockInvestments_Disposition_Method9" value="Fixed Buyout" data-onload="getInitialDipositionMethod(this, '9', 'Op');" onchange="getDipositionMethod(this, '9', 'Op');" <?php if(isset($drstocksinvestments->Op_StockInvestments_Disposition_Method9) && $drstocksinvestments->Op_StockInvestments_Disposition_Method9=='Fixed Buyout'){ echo "checked"; } ?>> Fixed Buyout</label>
                                    </div>
                                </div>
                                <!-- slider tool -->
                                <div class="form-group col-sm-6 m-auto 9_Op_Slider_Tool slider-tool-main">
                                    <div class="row">
                                        <div class="col">{{$client_name}}</div>
                                        <div class="col text-right">{{$opponent_name}}</div>
                                    </div>
                                    <input id="9_Op_balance_range_selector" type="range" class="form-control slider-tool-input 9_Op_balance_range_selector" name="" value="<?php if(isset($drstocksinvestments->Op_StockInvestments_Percent_Marital_Equity_to_Op9)){ echo $drstocksinvestments->Op_StockInvestments_Percent_Marital_Equity_to_Op9; } ?>" min="0.00" step="0.01" max="100" onchange="updateBalanceInput(this.value, '9', 'Op');">
                                </div>
                                <div class="form-group col-sm-6 m-auto 9_Op_Slider_Tool slider-tool-main">
                                    <div class="row justify-content-between">
                                        <div class="col selectorTool">
                                            <div class="left-col">
                                                <div class="client-info 9_Op_clientpercentage_div clientpercentage_div">
                                                    <?php if(isset($drstocksinvestments->Op_StockInvestments_Percent_Marital_Equity_to_Client9)){ echo $drstocksinvestments->Op_StockInvestments_Percent_Marital_Equity_to_Client9; } else {
                                                        echo "50.00";
                                                    } ?>%
                                                </div>
                                                <div class="client-info 9_Op_clientamount_div clientamount_div" style="clear: both;">
                                                    $<?php if(isset($drstocksinvestments->Op_StockInvestments_Estimated_Value_to_Client9)){ echo $drstocksinvestments->Op_StockInvestments_Estimated_Value_to_Client9; }else {
                                                        echo "0.00";
                                                    } ?>
                                                </div>
                                            </div>
                                            <label>To {{$client_name}}</label>
                                        </div>                                       
                                        <div class="col selectorTool selectorToolRight">
                                            <label>To {{$opponent_name}}</label>
                                            <div class="left-col right-col">
                                                <div class="client-info 9_Op_opponentpercentage_div opponentpercentage_div">
                                                    <?php if(isset($drstocksinvestments->Op_StockInvestments_Percent_Marital_Equity_to_Op9)){ echo $drstocksinvestments->Op_StockInvestments_Percent_Marital_Equity_to_Op9; } else {
                                                        echo "50.00";
                                                    } ?>%
                                                </div>
                                                <div class="client-info 9_Op_opponentamount_div opponentamount_div" style="clear: both;">
                                                    $<?php if(isset($drstocksinvestments->Op_StockInvestments_Estimated_Value_to_Op9)){ echo $drstocksinvestments->Op_StockInvestments_Estimated_Value_to_Op9; }else {
                                                        echo "0.00";
                                                    } ?>
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
                                         <label><input type="radio" id="Op_StockInvestments_Paying_Party9_Client" name="Op_StockInvestments_Paying_Party9" value="{{$client_name}}" data-onload="getInitialStockInvestmentPayingParty(this, '9', 'Op');" onchange="getStockInvestmentPayingParty(this, '9', 'Op');"  <?php if(isset($drstocksinvestments->Op_StockInvestments_Paying_Party9) && $drstocksinvestments->Op_StockInvestments_Paying_Party9==$client_name){ echo "checked"; } ?>> {{$client_name}}</label>
                                        <label><input type="radio" id="Op_StockInvestments_Paying_Party9_Op" name="Op_StockInvestments_Paying_Party9" value="{{$opponent_name}}" data-onload="getInitialStockInvestmentPayingParty(this, '9', 'Op');" onchange="getStockInvestmentPayingParty(this, '9', 'Op');"  <?php if(isset($drstocksinvestments->Op_StockInvestments_Paying_Party9) && $drstocksinvestments->Op_StockInvestments_Paying_Party9==$opponent_name){ echo "checked"; } ?>> {{$opponent_name}}</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 Op_StockInvestments_Paying_Party9_Inputs_Div" style="display: none;">
                                    <label>{{$client_name}} StockInvestment Equity Percent</label>
                                    <input id="Op_StockInvestments_Percent_Marital_Equity_to_Client9" type="number" class="form-control 9_Op_clientpercentage_input clientpercentage_input" name="Op_StockInvestments_Percent_Marital_Equity_to_Client9" value="<?php if(isset($drstocksinvestments->Op_StockInvestments_Percent_Marital_Equity_to_Client9)){ echo $drstocksinvestments->Op_StockInvestments_Percent_Marital_Equity_to_Client9; } ?>" min="0.00" step="0.01" max="100" readonly="">
                                </div>
                                <div class="form-group col-sm-6 Op_StockInvestments_Paying_Party9_Inputs_Div" style="display: none;">
                                    <label>How much is to be paid to {{$client_name}}?</label>
                                    <input id="Op_StockInvestments_Estimated_Value_to_Client9" type="number" class="form-control 9_Op_clientamount_input clientamount_input" name="Op_StockInvestments_Estimated_Value_to_Client9" value="<?php if(isset($drstocksinvestments->Op_StockInvestments_Estimated_Value_to_Client9)){ echo $drstocksinvestments->Op_StockInvestments_Estimated_Value_to_Client9; } ?>" min="0.00" step="0.01" max="999999.99" readonly="" onchange="getEstimatedValueClient(this, '9', 'Op');" onkeyup="getEstimatedValueClient(this, '9', 'Op');">
                                </div>
                                <div class="form-group col-sm-6 Op_StockInvestments_Paying_Party9_Inputs_Div" style="display: none;">
                                    <label>{{$opponent_name}} StockInvestment Equity Percent</label>
                                    <input id="Op_StockInvestments_Percent_Marital_Equity_to_Op9" type="number" class="form-control 9_Op_opponentpercentage_input opponentpercentage_input" name="Op_StockInvestments_Percent_Marital_Equity_to_Op9" value="<?php if(isset($drstocksinvestments->Op_StockInvestments_Percent_Marital_Equity_to_Op9)){ echo $drstocksinvestments->Op_StockInvestments_Percent_Marital_Equity_to_Op9; } ?>" min="0.00" step="0.01" max="100" readonly="">
                                </div>
                                <div class="form-group col-sm-6 Op_StockInvestments_Paying_Party9_Inputs_Div" style="display: none;">
                                    <label>How much is to be paid to {{$opponent_name}}?</label>
                                    <input id="Op_StockInvestments_Estimated_Value_to_Op9" type="number" class="form-control 9_Op_opponentamount_input opponentamount_input" name="Op_StockInvestments_Estimated_Value_to_Op9" value="<?php if(isset($drstocksinvestments->Op_StockInvestments_Estimated_Value_to_Op9)){ echo $drstocksinvestments->Op_StockInvestments_Estimated_Value_to_Op9; } ?>" min="0.00" step="0.01" max="999999.99" readonly="" onchange="getEstimatedValueOp(this, '9', 'Op');" onkeyup="getEstimatedValueOp(this, '9', 'Op');">
                                </div>
                                <!-- end of slider tool -->
                            </div>
                            <div class="col-sm-12 mt-4 10_Op_stocksinvestments_section" style="display: none;"><h5 class="col-sm-12">Tenth Stock Investment Info</h5>
                                <div class="form-group col-sm-6">
                                    <p class="text-danger 10_Op_no-state-county-found" style="display: none;">No City, State, County found for this zipcode.</p>
                                    <label for="Op_StockInvestments_Institution_ZIP10">Stock/Investment Institution Zip Code?</label>
                                    <input id="Op_StockInvestments_Institution_ZIP10" type="text" class="form-control 10_Op_stocksinvestments_inputs" name="Op_StockInvestments_Institution_ZIP10" value="<?php if(isset($drstocksinvestments->Op_StockInvestments_Institution_ZIP10)){ echo $drstocksinvestments->Op_StockInvestments_Institution_ZIP10; } ?>" data-onload="getCityStateForZip(this, '10', 'Op');" onkeyup="getCityStateForZip(this, '10', 'Op');"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_StockInvestments_Institution_Name10">Name of Stock/Investment Institution?</label>
                                    <input id="Op_StockInvestments_Institution_Name10" type="text" class="form-control 10_Op_stocksinvestments_inputs" name="Op_StockInvestments_Institution_Name10" value="<?php if(isset($drstocksinvestments->Op_StockInvestments_Institution_Name10)){ echo $drstocksinvestments->Op_StockInvestments_Institution_Name10; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_StockInvestments_Institution_Street_Address10">Stock/Investment Institution Street Address?</label>
                                    <input id="Op_StockInvestments_Institution_Street_Address10" type="text" class="form-control 10_Op_stocksinvestments_inputs" name="Op_StockInvestments_Institution_Street_Address10" value="<?php if(isset($drstocksinvestments->Op_StockInvestments_Institution_Street_Address10)){ echo $drstocksinvestments->Op_StockInvestments_Institution_Street_Address10; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_StockInvestments_Institution_City10">Stock/Investment Institution City?</label>
                                    <input type="hidden" name="" id="Op_StockInvestments_Institution_City10_Value" value="<?php if(isset($drstocksinvestments->Op_StockInvestments_Institution_City10)){ echo $drstocksinvestments->Op_StockInvestments_Institution_City10; } ?>">
                                    <select id="Op_StockInvestments_Institution_City10" name="Op_StockInvestments_Institution_City10" class="form-control 10_Op_city_select">
                                        <option value="">Choose City</option>
                                    </select>   
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_StockInvestments_Institution_State10">Stock/Investment Institution State?</label>
                                    <input type="hidden" name="" id="Op_StockInvestments_Institution_State10_Value" value="<?php if(isset($drstocksinvestments->Op_StockInvestments_Institution_State10)){ echo $drstocksinvestments->Op_StockInvestments_Institution_State10; } ?>">
                                    <select id="Op_StockInvestments_Institution_State10" name="Op_StockInvestments_Institution_State10" class="form-control 10_Op_state_select">
                                        <option value="">Choose State</option>
                                    </select>   
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_StockInvestments_Acct_Num10">Account Number?</label>
                                    <input id="Op_StockInvestments_Acct_Num10" type="text" class="form-control 10_Op_stocksinvestments_inputs" name="Op_StockInvestments_Acct_Num10" value="<?php if(isset($drstocksinvestments->Op_StockInvestments_Acct_Num10)){ echo $drstocksinvestments->Op_StockInvestments_Acct_Num10; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_StockInvestments_Date_Marriage_Value10">Marriage Date Value?</label>
                                    <input id="Op_StockInvestments_Date_Marriage_Value10" type="number" class="form-control 10_Op_stocksinvestments_inputs" name="Op_StockInvestments_Date_Marriage_Value10" value="<?php if(isset($drstocksinvestments->Op_StockInvestments_Date_Marriage_Value10)){ echo $drstocksinvestments->Op_StockInvestments_Date_Marriage_Value10; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_StockInvestments_Current_Value10">Current Value?</label>
                                    <input id="Op_StockInvestments_Current_Value10" type="number" class="form-control 10_Op_stocksinvestments_inputs" name="Op_StockInvestments_Current_Value10" value="<?php if(isset($drstocksinvestments->Op_StockInvestments_Current_Value10)){ echo $drstocksinvestments->Op_StockInvestments_Current_Value10; } ?>" min="0.00" step="0.01" max="999999.99" onchange="getJointCurrentValue(this, '10', 'Op');" onkeyup="getJointCurrentValue(this, '10', 'Op');"> 
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label for="Op_StockInvestments_Percent_Marital_Equity10">N/A, calculated = Op_StockInvestments_Institution_Current_Value10</label>
                                    <input id="Op_StockInvestments_Percent_Marital_Equity10" type="number" class="form-control 10_Op_stocksinvestments_inputs" name="Op_StockInvestments_Percent_Marital_Equity10" value="<?php if(isset($drstocksinvestments->Op_StockInvestments_Percent_Marital_Equity10)){ echo $drstocksinvestments->Op_StockInvestments_Percent_Marital_Equity10; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_StockInvestments_Yearly_Interest_Dividend10">Yearly Interest and Dividends from this account?</label>
                                    <input id="Op_StockInvestments_Yearly_Interest_Dividend10" type="number" class="form-control 10_Op_stocksinvestments_inputs" name="Op_StockInvestments_Yearly_Interest_Dividend10" value="<?php if(isset($drstocksinvestments->Op_StockInvestments_Yearly_Interest_Dividend10)){ echo $drstocksinvestments->Op_StockInvestments_Yearly_Interest_Dividend10; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Does either party claim a sole/separate interest from the other on this account?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Op_StockInvestments_SoleSeparate_Claim10_Yes" name="Op_StockInvestments_SoleSeparate_Claim10" value="Yes" data-onload="getInitialPartyClaimSoleSeparate(this, '10', 'Op');" onchange="getPartyClaimSoleSeparate(this, '10', 'Op');" <?php if(isset($drstocksinvestments->Op_StockInvestments_SoleSeparate_Claim10) && $drstocksinvestments->Op_StockInvestments_SoleSeparate_Claim10=='Yes'){ echo "checked"; } ?>> Yes</label>
                                        <label><input type="radio" id="Op_StockInvestments_SoleSeparate_Claim10_No" name="Op_StockInvestments_SoleSeparate_Claim10" value="No" data-onload="getInitialPartyClaimSoleSeparate(this, '10', 'Op');" onchange="getPartyClaimSoleSeparate(this, '10', 'Op');" <?php if(isset($drstocksinvestments->Op_StockInvestments_SoleSeparate_Claim10) && $drstocksinvestments->Op_StockInvestments_SoleSeparate_Claim10=='No'){ echo "checked"; } ?>> No</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6" id="Op_StockInvestments_SoleSeparate_Party10_Div" style="display: none;">
                                    <label>Who claims to own this account?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Op_StockInvestments_SoleSeparate_Party10_Client" name="Op_StockInvestments_SoleSeparate_Party10" value="{{$client_name}}" <?php if(isset($drstocksinvestments->Op_StockInvestments_SoleSeparate_Party10) && $drstocksinvestments->Op_StockInvestments_SoleSeparate_Party10==$client_name){ echo "checked"; } ?>> {{$client_name}}</label>
                                        <label><input type="radio" id="Op_StockInvestments_SoleSeparate_Party10_Op" name="Op_StockInvestments_SoleSeparate_Party10" value="{{$opponent_name}}" <?php if(isset($drstocksinvestments->Op_StockInvestments_SoleSeparate_Party10) && $drstocksinvestments->Op_StockInvestments_SoleSeparate_Party10==$opponent_name){ echo "checked"; } ?>> {{$opponent_name}}</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 left-clear" id="Op_StockInvestments_SoleSeparate_Grounds10_Div" style="display: none; clear: left;">
                                    <label for="Op_StockInvestments_SoleSeparate_Grounds10">Why does this person own this account solely and separately?</label>
                                    <input id="Op_StockInvestments_SoleSeparate_Grounds10" type="text" class="form-control 10_Op_stocksinvestments_inputs" name="Op_StockInvestments_SoleSeparate_Grounds10" value="<?php if(isset($drstocksinvestments->Op_StockInvestments_SoleSeparate_Grounds10)){ echo $drstocksinvestments->Op_StockInvestments_SoleSeparate_Grounds10; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>How will this account value be distributed between the parties?</label>
                                    <div class="w-100 dataInput">
                                        <label><input type="radio" id="Op_StockInvestments_Disposition_Method10_Distribute_Investments" name="Op_StockInvestments_Disposition_Method10" value="Distribute Investments" data-onload="getInitialDipositionMethod(this, '10', 'Op');" onchange="getDipositionMethod(this, '10', 'Op');" <?php if(isset($drstocksinvestments->Op_StockInvestments_Disposition_Method10) && $drstocksinvestments->Op_StockInvestments_Disposition_Method10=='Distribute Investments'){ echo "checked"; } ?>> Distribute Investments</label>
                                        <label><input type="radio" id="Op_StockInvestments_Disposition_Method10_Liquidate_Split_Net_Value" name="Op_StockInvestments_Disposition_Method10" value="Liquidate/Split Net Value" data-onload="getInitialDipositionMethod(this, '10', 'Op');" onchange="getDipositionMethod(this, '10', 'Op');" <?php if(isset($drstocksinvestments->Op_StockInvestments_Disposition_Method10) && $drstocksinvestments->Op_StockInvestments_Disposition_Method10=='Liquidate/Split Net Value'){ echo "checked"; } ?>> Liquidate/Split Net Value</label>
                                        <label><input type="radio" id="Op_StockInvestments_Disposition_Method10_Percentage_Buyout" name="Op_StockInvestments_Disposition_Method10" value="Percentage Buyout" data-onload="getInitialDipositionMethod(this, '10', 'Op');" onchange="getDipositionMethod(this, '10', 'Op');" <?php if(isset($drstocksinvestments->Op_StockInvestments_Disposition_Method10) && $drstocksinvestments->Op_StockInvestments_Disposition_Method10=='Percentage Buyout'){ echo "checked"; } ?>> Percentage Buyout</label>
                                        <label><input type="radio" id="Op_StockInvestments_Disposition_Method10_Fixed Buyout" name="Op_StockInvestments_Disposition_Method10" value="Fixed Buyout" data-onload="getInitialDipositionMethod(this, '10', 'Op');" onchange="getDipositionMethod(this, '10', 'Op');" <?php if(isset($drstocksinvestments->Op_StockInvestments_Disposition_Method10) && $drstocksinvestments->Op_StockInvestments_Disposition_Method10=='Fixed Buyout'){ echo "checked"; } ?>> Fixed Buyout</label>
                                    </div>
                                </div>
                                <!-- slider tool -->
                                <div class="form-group col-sm-6 m-auto 10_Op_Slider_Tool slider-tool-main">
                                    <div class="row">
                                        <div class="col">{{$client_name}}</div>
                                        <div class="col text-right">{{$opponent_name}}</div>
                                    </div>
                                    <input id="10_Op_balance_range_selector" type="range" class="form-control slider-tool-input 10_Op_balance_range_selector" name="" value="<?php if(isset($drstocksinvestments->Op_StockInvestments_Percent_Marital_Equity_to_Op10)){ echo $drstocksinvestments->Op_StockInvestments_Percent_Marital_Equity_to_Op10; } ?>" min="0.00" step="0.01" max="100" onchange="updateBalanceInput(this.value, '10', 'Op');">
                                </div>
                                <div class="form-group col-sm-6 m-auto 10_Op_Slider_Tool slider-tool-main">
                                    <div class="row justify-content-between">
                                        <div class="col selectorTool">
                                            <div class="left-col">
                                                <div class="client-info 10_Op_clientpercentage_div clientpercentage_div">
                                                    <?php if(isset($drstocksinvestments->Op_StockInvestments_Percent_Marital_Equity_to_Client10)){ echo $drstocksinvestments->Op_StockInvestments_Percent_Marital_Equity_to_Client10; } else {
                                                        echo "50.00";
                                                    } ?>%
                                                </div>
                                                <div class="client-info 10_Op_clientamount_div clientamount_div" style="clear: both;">
                                                    $<?php if(isset($drstocksinvestments->Op_StockInvestments_Estimated_Value_to_Client10)){ echo $drstocksinvestments->Op_StockInvestments_Estimated_Value_to_Client10; }else {
                                                        echo "0.00";
                                                    } ?>
                                                </div>
                                            </div>
                                            <label>To {{$client_name}}</label>
                                        </div>                                       
                                        <div class="col selectorTool selectorToolRight">
                                            <label>To {{$opponent_name}}</label>
                                            <div class="left-col right-col">
                                                <div class="client-info 10_Op_opponentpercentage_div opponentpercentage_div">
                                                    <?php if(isset($drstocksinvestments->Op_StockInvestments_Percent_Marital_Equity_to_Op10)){ echo $drstocksinvestments->Op_StockInvestments_Percent_Marital_Equity_to_Op10; } else {
                                                        echo "50.00";
                                                    } ?>%
                                                </div>
                                                <div class="client-info 10_Op_opponentamount_div opponentamount_div" style="clear: both;">
                                                    $<?php if(isset($drstocksinvestments->Op_StockInvestments_Estimated_Value_to_Op10)){ echo $drstocksinvestments->Op_StockInvestments_Estimated_Value_to_Op10; }else {
                                                        echo "0.00";
                                                    } ?>
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
                                         <label><input type="radio" id="Op_StockInvestments_Paying_Party10_Client" name="Op_StockInvestments_Paying_Party10" value="{{$client_name}}" data-onload="getInitialStockInvestmentPayingParty(this, '10', 'Op');" onchange="getStockInvestmentPayingParty(this, '10', 'Op');"  <?php if(isset($drstocksinvestments->Op_StockInvestments_Paying_Party10) && $drstocksinvestments->Op_StockInvestments_Paying_Party10==$client_name){ echo "checked"; } ?>> {{$client_name}}</label>
                                        <label><input type="radio" id="Op_StockInvestments_Paying_Party10_Op" name="Op_StockInvestments_Paying_Party10" value="{{$opponent_name}}" data-onload="getInitialStockInvestmentPayingParty(this, '10', 'Op');" onchange="getStockInvestmentPayingParty(this, '10', 'Op');"  <?php if(isset($drstocksinvestments->Op_StockInvestments_Paying_Party10) && $drstocksinvestments->Op_StockInvestments_Paying_Party10==$opponent_name){ echo "checked"; } ?>> {{$opponent_name}}</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 Op_StockInvestments_Paying_Party10_Inputs_Div" style="display: none;">
                                    <label>{{$client_name}} StockInvestment Equity Percent</label>
                                    <input id="Op_StockInvestments_Percent_Marital_Equity_to_Client10" type="number" class="form-control 10_Op_clientpercentage_input clientpercentage_input" name="Op_StockInvestments_Percent_Marital_Equity_to_Client10" value="<?php if(isset($drstocksinvestments->Op_StockInvestments_Percent_Marital_Equity_to_Client10)){ echo $drstocksinvestments->Op_StockInvestments_Percent_Marital_Equity_to_Client10; } ?>" min="0.00" step="0.01" max="100" readonly="">
                                </div>
                                <div class="form-group col-sm-6 Op_StockInvestments_Paying_Party10_Inputs_Div" style="display: none;">
                                    <label>How much is to be paid to {{$client_name}}?</label>
                                    <input id="Op_StockInvestments_Estimated_Value_to_Client10" type="number" class="form-control 10_Op_clientamount_input clientamount_input" name="Op_StockInvestments_Estimated_Value_to_Client10" value="<?php if(isset($drstocksinvestments->Op_StockInvestments_Estimated_Value_to_Client10)){ echo $drstocksinvestments->Op_StockInvestments_Estimated_Value_to_Client10; } ?>" min="0.00" step="0.01" max="999999.99" readonly="" onchange="getEstimatedValueClient(this, '10', 'Op');" onkeyup="getEstimatedValueClient(this, '10', 'Op');">
                                </div>
                                <div class="form-group col-sm-6 Op_StockInvestments_Paying_Party10_Inputs_Div" style="display: none;">
                                    <label>{{$opponent_name}} StockInvestment Equity Percent</label>
                                    <input id="Op_StockInvestments_Percent_Marital_Equity_to_Op10" type="number" class="form-control 10_Op_opponentpercentage_input opponentpercentage_input" name="Op_StockInvestments_Percent_Marital_Equity_to_Op10" value="<?php if(isset($drstocksinvestments->Op_StockInvestments_Percent_Marital_Equity_to_Op10)){ echo $drstocksinvestments->Op_StockInvestments_Percent_Marital_Equity_to_Op10; } ?>" min="0.00" step="0.01" max="100" readonly="">
                                </div>
                                <div class="form-group col-sm-6 Op_StockInvestments_Paying_Party10_Inputs_Div" style="display: none;">
                                    <label>How much is to be paid to {{$opponent_name}}?</label>
                                    <input id="Op_StockInvestments_Estimated_Value_to_Op10" type="number" class="form-control 10_Op_opponentamount_input opponentamount_input" name="Op_StockInvestments_Estimated_Value_to_Op10" value="<?php if(isset($drstocksinvestments->Op_StockInvestments_Estimated_Value_to_Op10)){ echo $drstocksinvestments->Op_StockInvestments_Estimated_Value_to_Op10; } ?>" min="0.00" step="0.01" max="999999.99" readonly="" onchange="getEstimatedValueOp(this, '10', 'Op');" onkeyup="getEstimatedValueOp(this, '10', 'Op');">
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
        function getCityStateForZip(zipinput, zipinputnum, ziptype) {
            var zipclass=zipinputnum+'_'+ziptype;
            
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

                            var slctd_city=$('#'+ziptype+'_StockInvestments_Institution_City'+zipinputnum+'_Value').val();
                            if(slctd_city){
                                $('.'+zipclass+'_city_select option[value="'+slctd_city+'"]').attr('selected','selected');
                            }

                            var slctd_state=$('#'+ziptype+'_StockInvestments_Institution_State'+zipinputnum+'_Value').val();
                            if(slctd_state){
                                $('.'+zipclass+'_state_select option[value="'+slctd_state+'"]').attr('selected','selected');
                            }
                            $('.'+zipclass+'_no-state-county-found').hide();
                        }
                    }
                });        
            }

        }

    function getInitialPartyClaimSoleSeparate(claim, claimnum, claimtype){
        if(claim.value=='No' && claim.checked){
            $('#'+claimtype+'_StockInvestments_SoleSeparate_Party'+claimnum+'_Div').hide();
            $('#'+claimtype+'_StockInvestments_SoleSeparate_Grounds'+claimnum+'_Div').hide();
            $('#'+claimtype+'_StockInvestments_SoleSeparate_Grounds'+claimnum+'').val('');
            $('#'+claimtype+'_StockInvestments_SoleSeparate_Party'+claimnum+'').prop('checked', false);
            $('.'+claimnum+'_'+claimtype+'_Slider_Tool').show();
            $('.'+claimtype+'_StockInvestments_Paying_Party'+claimnum+'_Inputs_Div').hide();
            $('.'+claimtype+'_StockInvestments_Paying_Party'+claimnum+'_Inputs_Div input[type=number]').prop('readonly', true);
        } 
        if(claim.value=='Yes' && claim.checked){
            $('#'+claimtype+'_StockInvestments_SoleSeparate_Party'+claimnum+'_Div').show();
            $('#'+claimtype+'_StockInvestments_SoleSeparate_Grounds'+claimnum+'_Div').show();
            $('.'+claimnum+'_'+claimtype+'_Slider_Tool').hide();
            $('.'+claimtype+'_StockInvestments_Paying_Party'+claimnum+'_Inputs_Div').show();
            $('.'+claimtype+'_StockInvestments_Paying_Party'+claimnum+'_Inputs_Div input[type=number]').prop('readonly', true);
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

    function getInitialDipositionMethod(claim, claimnum, claimtype){
        if(claim.value=='Fixed Buyout' && claim.checked){
            $('.'+claimnum+'_'+claimtype+'_Slider_Tool').hide();
            $('.'+claimtype+'_StockInvestments_Paying_Party'+claimnum+'_Inputs_Div').show();
        } else {
            $('.'+claimnum+'_'+claimtype+'_Slider_Tool').show();
            $('.'+claimtype+'_StockInvestments_Paying_Party'+claimnum+'_Inputs_Div').hide();
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

    function getInitialStockInvestmentPayingParty(party, partynum, partytype){
        if(party.id==''+partytype+'_StockInvestments_Paying_Party'+partynum+'_Client' && party.checked){
            $('.'+partytype+'_StockInvestments_Paying_Party'+partynum+'_Inputs_Div').show();
            $('#'+partytype+'_StockInvestments_Estimated_Value_to_Op'+partynum+'').prop('readonly', false);
            $('#'+partytype+'_StockInvestments_Estimated_Value_to_Client'+partynum+'').prop('readonly', true);
        }  

        if(party.id==''+partytype+'_StockInvestments_Paying_Party'+partynum+'_Op' && party.checked){
            $('.'+partytype+'_StockInvestments_Paying_Party'+partynum+'_Inputs_Div').show();
            $('#'+partytype+'_StockInvestments_Estimated_Value_to_Client'+partynum+'').prop('readonly', false);
            $('#'+partytype+'_StockInvestments_Estimated_Value_to_Op'+partynum+'').prop('readonly', true);
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
            if(isNaN(client_balance_amount_new)) {
                client_balance_amount_new = 0.00;
            }
            if(isNaN(opponent_balance_amount)) {
                opponent_balance_amount = 0.00;
            }
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
        if(isNaN(client_balance)) {
            client_balance = 0.00;
        }
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

        $('[data-onload]').each(function(){
            eval($(this).data('onload'));
        });

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
                    $('.'+i+'_Joint_stocksinvestments_section input').first().prop('required',true);
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
                    $('.'+i+'_Client_stocksinvestments_section input').first().prop('required',true);
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
                    $('.'+i+'_Op_stocksinvestments_section input').first().prop('required',true);
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