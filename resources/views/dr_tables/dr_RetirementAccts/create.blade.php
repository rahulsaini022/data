@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center dr_RetirementAccts_main dr_Tables_main">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header"><strong>{{ __('Retirement Accts Info') }}</strong>
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
                    <form role="form" id="dr_RetirementAccts" method="POST" action="{{route('drretirementaccts.store')}}" autocomplete="off">
                        @csrf
                        <input id="" type="hidden" class="form-control" name="case_id" value="{{$case_id}}">
                        <div class="form-row Any_Retirement_Accts">
                            <div class="form-group col-sm-12">
                                <label></label>
                                <div class="w-100 dataInput">
                                     <label><input type="checkbox" id="Any_Retirement_Accts" name="Any_Retirement_Accts" value="1" onchange="getAnyRetirementAccts(this);" <?php if(isset($drcaseoverview->Any_Retirement_Accts) && $drcaseoverview->Any_Retirement_Accts=='1'){ echo "checked"; } ?>> Does either party have a retirement account?</label>
                                </div>
                            </div>
                        </div>
                        <!-- Client Retirement Accts Info Section -->
                        <div class="form-row num_Client_Retirement_Accts_info" style="display: none;">
                            <h4 class="col-sm-12">{{$client_name}} Retirement Accts Info Section</h4>
                            <div class="col-sm-6">
                                <label for="Num_Client_Retirement_Accts">How many pensions does {{$client_name}} have or is contributing to?</label>
                                <input id="Num_Client_Retirement_Accts" type="number" class="form-control" name="Num_Client_Retirement_Accts" value="<?php if(isset($drcaseoverview->Num_Client_Retirement_Accts)){ echo $drcaseoverview->Num_Client_Retirement_Accts; } ?>" min="0" max="4"> 
                            </div>
                        </div>
                        <div class="form-row Client_retirementaccts_section">
                            <div class="col-sm-12 mt-4 1_Client_retirementaccts_section" style="display: none;"><h5 class="col-sm-12">First Retirement Acct Info</h5>
                                <div class="form-group col-sm-6">
                                    <p class="text-danger 1_Client_no-state-county-found" style="display: none;">No City, State, County found for this zipcode.</p>
                                    <label for="Client_RetAcct1_Institution_ZIP">Retirement Account Institution Zip Code?</label>
                                    <input id="Client_RetAcct1_Institution_ZIP" type="text" class="form-control 1_Client_retirementaccts_inputs" name="Client_RetAcct1_Institution_ZIP" value="" onkeyup="getCityStateForZip(this, '1', 'Client');"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_RetAcct1_Institution_Name">Name of Retirement Account Institution?</label>
                                    <input id="Client_RetAcct1_Institution_Name" type="text" class="form-control 1_Client_retirementaccts_inputs" name="Client_RetAcct1_Institution_Name" value=""> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_RetAcct1_Institution_Street_Address">Retirement Account Institution Street Address?</label>
                                    <input id="Client_RetAcct1_Institution_Street_Address" type="text" class="form-control 1_Client_retirementaccts_inputs" name="Client_RetAcct1_Institution_Street_Address" value=""> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_RetAcct1_Institution_City">Retirement Account Institution City?</label>
                                    <select id="Client_RetAcct1_Institution_City" name="Client_RetAcct1_Institution_City" class="form-control 1_Client_city_select">
                                        <option value="">Choose City</option>
                                    </select>   
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_RetAcct1_Institution_State">Retirement Account Institution State?</label>
                                    <select id="Client_RetAcct1_Institution_State" name="Client_RetAcct1_Institution_State" class="form-control 1_Client_state_select">
                                        <option value="">Choose State</option>
                                    </select>   
                                </div>                                
                                <div class="form-group col-sm-6">
                                    <label for="Client_RetAcct1_Institution_Acct_Num">Account Number?</label>
                                    <input id="Client_RetAcct1_Institution_Acct_Num" type="text" class="form-control 1_Client_retirementaccts_inputs" name="Client_RetAcct1_Institution_Acct_Num" value="" onchange="getAcctNum(this, '1', 'Client');" onkeyup="getAcctNum(this, '1', 'Client');"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_RetAcct1_Date_of_Marriage_Balance">Balance on marriage date (0.00, if started after marriage)?</label>
                                    <input id="Client_RetAcct1_Date_of_Marriage_Balance" type="number" class="form-control 1_Client_retirementaccts_inputs" name="Client_RetAcct1_Date_of_Marriage_Balance" value="0.00" min="0.00" step="0.01" max="999999.99" onchange="getMarriageBalance(this, '1', 'Client');" onkeyup="getMarriageBalance(this, '1', 'Client');"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_RetAcct1_Current_Balance">Current Balance?</label>
                                    <input id="Client_RetAcct1_Current_Balance" type="number" class="form-control 1_Client_retirementaccts_inputs" name="Client_RetAcct1_Current_Balance" value="0.00" min="0.00" step="0.01" max="999999.99" onchange="getCurrentBalance(this, '1', 'Client');" onkeyup="getCurrentBalance(this, '1', 'Client');"> 
                                </div>                                
                                <div class="form-group col-sm-6">
                                    <label for="Client_RetAcct1_Estimated_MaritalEquity1">Marital Equity<!-- N/A, calculated = Client_RetAcct1_Current_Balance – Client_RetAcct1_Date_of_Marriage_Balance --></label>
                                    <input id="Client_RetAcct1_Estimated_MaritalEquity1" type="number" class="form-control 1_Client_retirementaccts_inputs" name="Client_RetAcct1_Estimated_MaritalEquity1" value="0.00" min="0.00" step="0.01" max="999999.99" readonly=""> 
                                </div>                                
                                <div class="form-group col-sm-6">
                                    <label for="Client_RetAcct1_Current_Yearly_Income">Amount of Yearly Interest?</label>
                                    <input id="Client_RetAcct1_Current_Yearly_Income" type="number" class="form-control 1_Client_retirementaccts_inputs" name="Client_RetAcct1_Current_Yearly_Income" value="0.00" min="0.00" step="0.01" max="999999.99"> 
                                </div>

                                <div class="form-group col-sm-6">
                                    <label>Does either party claim a sole/separate interest from the other on this account?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Client_RetAcct1_SoleSeparate_Claim_Yes" name="Client_RetAcct1_SoleSeparate_Claim" value="Yes" onchange="getPartyClaimSoleSeparate(this, '1', 'Client');"> Yes</label>
                                        <label><input type="radio" id="Client_RetAcct1_SoleSeparate_Claim_No" name="Client_RetAcct1_SoleSeparate_Claim" value="No" checked="" onchange="getPartyClaimSoleSeparate(this, '1', 'Client');"> No</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6" id="Client_RetAcct1_SoleSeparate_Party_Div" style="display: none;">
                                    <label>Who claims to own this account?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Client_RetAcct1_SoleSeparate_Party_Client" name="Client_RetAcct1_SoleSeparate_Party" value="{{$client_name}}"> {{$client_name}}</label>
                                        <label><input type="radio" id="Client_RetAcct1_SoleSeparate_Party_Op" name="Client_RetAcct1_SoleSeparate_Party" value="{{$opponent_name}}"> {{$opponent_name}}</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6" id="Client_RetAcct1_SoleSeparate_Grounds_Div" style="display: none;">
                                    <label for="Client_RetAcct1_SoleSeparate_Grounds">Why does this person own this account solely and separately?</label>
                                    <input id="Client_RetAcct1_SoleSeparate_Grounds" type="text" class="form-control 1_Client_retirementaccts_inputs" name="Client_RetAcct1_SoleSeparate_Grounds" value=""> 
                                </div>
                                <!-- <div class="form-group col-sm-6">
                                    <label>What type of distribution will this be?</label>
                                    <div class="w-100 dataInput">
                                        <label><input type="radio" id="Client_RetAcct1_Disposition_Type_Distribute Investments" name="Client_RetAcct1_Disposition_Type" value="Distribute Investments"> Distribute Investments</label>
                                        <label><input type="radio" id="Client_RetAcct1_Disposition_Type_Liquidate/Split Net Value" name="Client_RetAcct1_Disposition_Type" value="Liquidate/Split Net Value"> Liquidate/Split Net Value</label>
                                        <label><input type="radio" id="Client_RetAcct1_Disposition_Type_QDRO" name="Client_RetAcct1_Disposition_Type" value="QDRO"> QDRO</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>How will this account value be distributed between the parties?</label>
                                    <div class="w-100 dataInput">
                                        <label><input type="radio" id="Client_RetAcct1_Disposition_Method_Percentage_Buyout" name="Client_RetAcct1_Disposition_Method" value="Percentage Buyout" onchange="getDipositionMethod(this, '1', 'Client');"> Percentage Buyout</label>
                                        <label><input type="radio" id="Client_RetAcct1_Disposition_Method_Fixed_Buyout" name="Client_RetAcct1_Disposition_Method" value="Fixed Buyout" onchange="getDipositionMethod(this, '1', 'Client');"> Fixed Buyout</label>
                                    </div>
                                </div> -->
                                <div class="form-group col-sm-6">
                                    <label>Distribute By</label>
                                    <div class="w-100 dataInput">
                                        <label><input type="radio" id="Client_RetAcct1_Disposition_Type_QDRO_Fixed" name="Client_RetAcct1_Disposition_Type_QDRO" value="QDRO_Fixed" onchange="getDistributionMethod(this, '1', 'Client');"> QDRO (Fixed amount to {{$opponent_name}})</label>
                                        <label><input type="radio" id="Client_RetAcct1_Disposition_Type_Fixed_Buyout" name="Client_RetAcct1_Disposition_Type_QDRO" value="Fixed_Buyout" onchange="getDistributionMethod(this, '1', 'Client');"> Buyout – Don’t distribute</label>
                                        <label><input type="radio" id="Client_RetAcct1_Disposition_Type_QDRO_Percentage" name="Client_RetAcct1_Disposition_Type_QDRO" value="QDRO_Percentage" onchange="getDistributionMethod(this, '1', 'Client');"> QDRO (Percent amount to {{$opponent_name}})</label>
                                    </div>                           
                                </div>
                                <div class="form-group col-sm-6 Client_RetAcct1_Disposition_Type_QDRO_Amount_Div" style="display: none;">
                                    <label for="Client_RetAcct1_Disposition_Type_QDRO_Amount">Enter Fixed Amount to {{$opponent_name}}</label>
                                    <input id="Client_RetAcct1_Disposition_Type_QDRO_Amount" type="number" class="form-control 1_Client_retirementaccts_inputs" name="Client_RetAcct1_Disposition_Type_QDRO_Amount" value="0.00" min="0.00" step="0.01" max="999999.99" onchange="getQDROFixedAmount(this, '1', 'Client');" onkeyup="getQDROFixedAmount(this, '1', 'Client');">
                                </div>
                                <div class="form-group col-sm-6 Client_RetAcct1_Disposition_Type_QDRO_Percentage_Amount_Div" style="display: none;">
                                    <label for="Client_RetAcct1_Disposition_Type_QDRO_Percentage_Amount">Enter Fixed Percenrage Amount to {{$opponent_name}}</label>
                                    <input id="Client_RetAcct1_Disposition_Type_QDRO_Percentage_Amount" type="number" class="form-control 1_Client_retirementaccts_inputs" name="Client_RetAcct1_Disposition_Type_QDRO_Percentage_Amount" value="0.00" min="0.00" step="0.01" max="100" onchange="getQDROFixedPercentageAmount(this, '1', 'Client');" onkeyup="getQDROFixedPercentageAmount(this, '1', 'Client');">
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
                                                    $0.00
                                                </div>
                                                <div class="client-info 1_Client_EPclientamount_div EPclientamount_div" style="clear: both;"><span>$0.00</span>
                                                    <input type="number" id="Client_RetAcct1_Estimated_EP_to_Client" name="Client_RetAcct1_Estimated_EP_to_Client" value="0.00" readonly="" style="display: none;">
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
                                                    $0.00
                                                </div>
                                                <div class="client-info 1_Client_EPopponentamount_div EPopponentamount_div" style="clear: both;"><span>$0.00</span>
                                                    <input type="number" id="Client_RetAcct1_Estimated_EP_to_Op" name="Client_RetAcct1_Estimated_EP_to_Op" value="0.00" readonly="" style="display: none;">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 m-auto 1_Client_Slider_Tool slider-tool-main">
                                    <label><strong>{{$client_name}} Retirement Acct#-<span class="1_Client_RetAcct_Number_Span"></span> Equalization Payment</strong></label>
                                    <div class="w-100">
                                        <label><input type="radio" id="1_Client_RetAcct_Estimated_Value_Select" name="1_Client_RetAcct_Estimated_Value_Select_Reset" class="RetAcct_Estimated_Value_Select_Reset" value="Save"> Save this Distribution of Retirement Acct#-<span class="1_Client_RetAcct_Number_Span">1</span></label>
                                        <label><input type="radio" id="1_Client_RetAcct_Estimated_Value_Reset" name="1_Client_RetAcct_Estimated_Value_Select_Reset" class="RetAcct_Estimated_Value_Select_Reset" value="Reset" onclick="resetBalanceInput(this, '1', 'Client');"> Reset to Default (50%)</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 Client_RetAcct_Paying_Party1_Inputs_Div" style="display: none;">
                                    <label>{{$client_name}} Retirement Accts Equity Percent</label>
                                    <input id="Client_RetAcct1_Percent_Marital_Equity_to_Client" type="number" class="form-control 1_Client_clientpercentage_input clientpercentage_input" name="Client_RetAcct1_Percent_Marital_Equity_to_Client" value="50.00" min="0.00" step="0.01" max="100" readonly="">
                                </div>
                                <div class="form-group col-sm-6 Client_RetAcct_Paying_Party1_Inputs_Div" style="display: none;">
                                    <label>N/A, calculated = Client_RetAcct1_Estimated_MaritalEquity – Client_RetAcct1_Estimated_Value_to_Op</label>
                                    <input id="Client_RetAcct1_Estimated_Value_to_Client" type="number" class="form-control 1_Client_clientamount_input clientamount_input" name="Client_RetAcct1_Estimated_Value_to_Client" value="" min="0.00" step="0.01" max="999999.99" readonly="">
                                </div>
                                <div class="form-group col-sm-6 Client_RetAcct_Paying_Party1_Inputs_Div" style="display: none;">
                                    <label>{{$opponent_name}} Retirement Accts Equity Percent</label>
                                    <input id="Client_RetAcct1_Percent_Marital_Equity_to_Op" type="number" class="form-control 1_Client_opponentpercentage_input opponentpercentage_input" name="Client_RetAcct1_Percent_Marital_Equity_to_Op" value="50.00" min="0.00" step="0.01" max="100" readonly="">
                                </div>
                                <div class="form-group col-sm-6 Client_RetAcct1_Disposition_Method_Fixed_Div Client_RetAcct_Paying_Party1_Inputs_Div" style="display: none;">
                                    <label>How much is to be paid to {{$opponent_name}}?</label>
                                    <input id="Client_RetAcct1_Estimated_Value_to_Op" type="number" class="form-control 1_Client_opponentamount_input opponentamount_input" name="Client_RetAcct1_Estimated_Value_to_Op" value="" min="0.00" step="0.01" max="999999.99" readonly="" onchange="getEstimatedValueOp(this, '1', 'Client');" onkeyup="getEstimatedValueOp(this, '1', 'Client');">
                                </div>
                                <!-- end of slider tool -->
                            </div>
                            <div class="col-sm-12 mt-4 2_Client_retirementaccts_section" style="display: none;"><h5 class="col-sm-12">Second Retirement Acct Info</h5>
                                <div class="form-group col-sm-6">
                                    <p class="text-danger 2_Client_no-state-county-found" style="display: none;">No City, State, County found for this zipcode.</p>
                                    <label for="Client_RetAcct2_Institution_ZIP">Retirement Account Institution Zip Code?</label>
                                    <input id="Client_RetAcct2_Institution_ZIP" type="text" class="form-control 2_Client_retirementaccts_inputs" name="Client_RetAcct2_Institution_ZIP" value="" onkeyup="getCityStateForZip(this, '2', 'Client');"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_RetAcct2_Institution_Name">Name of Retirement Account Institution?</label>
                                    <input id="Client_RetAcct2_Institution_Name" type="text" class="form-control 2_Client_retirementaccts_inputs" name="Client_RetAcct2_Institution_Name" value=""> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_RetAcct2_Institution_Street_Address">Retirement Account Institution Street Address?</label>
                                    <input id="Client_RetAcct2_Institution_Street_Address" type="text" class="form-control 2_Client_retirementaccts_inputs" name="Client_RetAcct2_Institution_Street_Address" value=""> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_RetAcct2_Institution_City">Retirement Account Institution City?</label>
                                    <select id="Client_RetAcct2_Institution_City" name="Client_RetAcct2_Institution_City" class="form-control 2_Client_city_select">
                                        <option value="">Choose City</option>
                                    </select>   
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_RetAcct2_Institution_State">Retirement Account Institution State?</label>
                                    <select id="Client_RetAcct2_Institution_State" name="Client_RetAcct2_Institution_State" class="form-control 2_Client_state_select">
                                        <option value="">Choose State</option>
                                    </select>   
                                </div>                                
                                <div class="form-group col-sm-6">
                                    <label for="Client_RetAcct2_Institution_Acct_Num">Account Number?</label>
                                    <input id="Client_RetAcct2_Institution_Acct_Num" type="text" class="form-control 2_Client_retirementaccts_inputs" name="Client_RetAcct2_Institution_Acct_Num" value="" onchange="getAcctNum(this, '2', 'Client');" onkeyup="getAcctNum(this, '2', 'Client');"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_RetAcct2_Date_of_Marriage_Balance">Balance on marriage date (0.00, if started after marriage)?</label>
                                    <input id="Client_RetAcct2_Date_of_Marriage_Balance" type="number" class="form-control 2_Client_retirementaccts_inputs" name="Client_RetAcct2_Date_of_Marriage_Balance" value="0.00" min="0.00" step="0.01" max="999999.99" onchange="getMarriageBalance(this, '2', 'Client');" onkeyup="getMarriageBalance(this, '2', 'Client');"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_RetAcct2_Current_Balance">Current Balance?</label>
                                    <input id="Client_RetAcct2_Current_Balance" type="number" class="form-control 2_Client_retirementaccts_inputs" name="Client_RetAcct2_Current_Balance" value="0.00" min="0.00" step="0.01" max="999999.99" onchange="getCurrentBalance(this, '2', 'Client');" onkeyup="getCurrentBalance(this, '2', 'Client');"> 
                                </div>                                
                                <div class="form-group col-sm-6">
                                    <label for="Client_RetAcct2_Estimated_MaritalEquity1">Marital Equity</label>
                                    <input id="Client_RetAcct2_Estimated_MaritalEquity1" type="number" class="form-control 2_Client_retirementaccts_inputs" name="Client_RetAcct2_Estimated_MaritalEquity1" value="0.00" min="0.00" step="0.01" max="999999.99" readonly=""> 
                                </div>                                
                                <div class="form-group col-sm-6">
                                    <label for="Client_RetAcct2_Current_Yearly_Income">Amount of Yearly Interest?</label>
                                    <input id="Client_RetAcct2_Current_Yearly_Income" type="number" class="form-control 2_Client_retirementaccts_inputs" name="Client_RetAcct2_Current_Yearly_Income" value="0.00" min="0.00" step="0.01" max="999999.99"> 
                                </div>

                                <div class="form-group col-sm-6">
                                    <label>Does either party claim a sole/separate interest from the other on this account?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Client_RetAcct2_SoleSeparate_Claim_Yes" name="Client_RetAcct2_SoleSeparate_Claim" value="Yes" onchange="getPartyClaimSoleSeparate(this, '2', 'Client');"> Yes</label>
                                        <label><input type="radio" id="Client_RetAcct2_SoleSeparate_Claim_No" name="Client_RetAcct2_SoleSeparate_Claim" value="No" checked="" onchange="getPartyClaimSoleSeparate(this, '2', 'Client');"> No</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6" id="Client_RetAcct2_SoleSeparate_Party_Div" style="display: none;">
                                    <label>Who claims to own this account?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Client_RetAcct2_SoleSeparate_Party_Client" name="Client_RetAcct2_SoleSeparate_Party" value="{{$client_name}}"> {{$client_name}}</label>
                                        <label><input type="radio" id="Client_RetAcct2_SoleSeparate_Party_Op" name="Client_RetAcct2_SoleSeparate_Party" value="{{$opponent_name}}"> {{$opponent_name}}</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6" id="Client_RetAcct2_SoleSeparate_Grounds_Div" style="display: none;">
                                    <label for="Client_RetAcct2_SoleSeparate_Grounds">Why does this person own this account solely and separately?</label>
                                    <input id="Client_RetAcct2_SoleSeparate_Grounds" type="text" class="form-control 2_Client_retirementaccts_inputs" name="Client_RetAcct2_SoleSeparate_Grounds" value=""> 
                                </div>
                                <!-- <div class="form-group col-sm-6">
                                    <label>What type of distribution will this be?</label>
                                    <div class="w-100 dataInput">
                                        <label><input type="radio" id="Client_RetAcct2_Disposition_Type_Distribute Investments" name="Client_RetAcct2_Disposition_Type" value="Distribute Investments"> Distribute Investments</label>
                                        <label><input type="radio" id="Client_RetAcct2_Disposition_Type_Liquidate/Split Net Value" name="Client_RetAcct2_Disposition_Type" value="Liquidate/Split Net Value"> Liquidate/Split Net Value</label>
                                        <label><input type="radio" id="Client_RetAcct2_Disposition_Type_QDRO" name="Client_RetAcct2_Disposition_Type" value="QDRO"> QDRO</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>How will this account value be distributed between the parties?</label>
                                    <div class="w-100 dataInput">
                                        <label><input type="radio" id="Client_RetAcct2_Disposition_Method_Percentage_Buyout" name="Client_RetAcct2_Disposition_Method" value="Percentage Buyout" onchange="getDipositionMethod(this, '2', 'Client');"> Percentage Buyout</label>
                                        <label><input type="radio" id="Client_RetAcct2_Disposition_Method_Fixed_Buyout" name="Client_RetAcct2_Disposition_Method" value="Fixed Buyout" onchange="getDipositionMethod(this, '2', 'Client');"> Fixed Buyout</label>
                                    </div>
                                </div> -->
                                <div class="form-group col-sm-6">
                                    <label>Distribute By</label>
                                    <div class="w-100 dataInput">
                                        <label><input type="radio" id="Client_RetAcct2_Disposition_Type_QDRO_Fixed" name="Client_RetAcct2_Disposition_Type_QDRO" value="QDRO_Fixed" onchange="getDistributionMethod(this, '2', 'Client');"> QDRO (Fixed amount to {{$opponent_name}})</label>
                                        <label><input type="radio" id="Client_RetAcct2_Disposition_Type_Fixed_Buyout" name="Client_RetAcct2_Disposition_Type_QDRO" value="Fixed_Buyout" onchange="getDistributionMethod(this, '2', 'Client');"> Buyout – Don’t distribute</label>
                                        <label><input type="radio" id="Client_RetAcct2_Disposition_Type_QDRO_Percentage" name="Client_RetAcct2_Disposition_Type_QDRO" value="QDRO_Percentage" onchange="getDistributionMethod(this, '2', 'Client');"> QDRO (Percent amount to {{$opponent_name}})</label>
                                    </div>                           
                                </div>
                                <div class="form-group col-sm-6 Client_RetAcct2_Disposition_Type_QDRO_Amount_Div" style="display: none;">
                                    <label for="Client_RetAcct2_Disposition_Type_QDRO_Amount">Enter Fixed Amount to {{$opponent_name}}</label>
                                    <input id="Client_RetAcct2_Disposition_Type_QDRO_Amount" type="number" class="form-control 2_Client_retirementaccts_inputs" name="Client_RetAcct2_Disposition_Type_QDRO_Amount" value="0.00" min="0.00" step="0.01" max="999999.99" onchange="getQDROFixedAmount(this, '2', 'Client');" onkeyup="getQDROFixedAmount(this, '2', 'Client');">
                                </div>
                                <div class="form-group col-sm-6 Client_RetAcct2_Disposition_Type_QDRO_Percentage_Amount_Div" style="display: none;">
                                    <label for="Client_RetAcct2_Disposition_Type_QDRO_Percentage_Amount">Enter Fixed Percenrage Amount to {{$opponent_name}}</label>
                                    <input id="Client_RetAcct2_Disposition_Type_QDRO_Percentage_Amount" type="number" class="form-control 2_Client_retirementaccts_inputs" name="Client_RetAcct2_Disposition_Type_QDRO_Percentage_Amount" value="0.00" min="0.00" step="0.01" max="100" onchange="getQDROFixedPercentageAmount(this, '2', 'Client');" onkeyup="getQDROFixedPercentageAmount(this, '2', 'Client');">
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
                                                    $0.00
                                                </div>
                                                <div class="client-info 2_Client_EPclientamount_div EPclientamount_div" style="clear: both;"><span>$0.00</span>
                                                    <input type="number" id="Client_RetAcct2_Estimated_EP_to_Client" name="Client_RetAcct2_Estimated_EP_to_Client" value="0.00" readonly="" style="display: none;">
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
                                                    $0.00
                                                </div>
                                                <div class="client-info 2_Client_EPopponentamount_div EPopponentamount_div" style="clear: both;"><span>$0.00</span>
                                                    <input type="number" id="Client_RetAcct2_Estimated_EP_to_Op" name="Client_RetAcct2_Estimated_EP_to_Op" value="0.00" readonly="" style="display: none;">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 m-auto 2_Client_Slider_Tool slider-tool-main">
                                    <label><strong>{{$client_name}} Retirement Acct#-<span class="2_Client_RetAcct_Number_Span"></span> Equalization Payment</strong></label>
                                    <div class="w-100">
                                        <label><input type="radio" id="2_Client_RetAcct_Estimated_Value_Select" name="2_Client_RetAcct_Estimated_Value_Select_Reset" class="RetAcct_Estimated_Value_Select_Reset" value="Save"> Save this Distribution of Retirement Acct#-<span class="2_Client_RetAcct_Number_Span">2</span></label>
                                        <label><input type="radio" id="2_Client_RetAcct_Estimated_Value_Reset" name="2_Client_RetAcct_Estimated_Value_Select_Reset" class="RetAcct_Estimated_Value_Select_Reset" value="Reset" onclick="resetBalanceInput(this, '2', 'Client');"> Reset to Default (50%)</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 Client_RetAcct_Paying_Party2_Inputs_Div" style="display: none;">
                                    <label>{{$client_name}} Retirement Accts Equity Percent</label>
                                    <input id="Client_RetAcct2_Percent_Marital_Equity_to_Client" type="number" class="form-control 2_Client_clientpercentage_input clientpercentage_input" name="Client_RetAcct2_Percent_Marital_Equity_to_Client" value="50.00" min="0.00" step="0.01" max="100" readonly="">
                                </div>
                                <div class="form-group col-sm-6 Client_RetAcct_Paying_Party2_Inputs_Div" style="display: none;">
                                    <label>N/A, calculated = Client_RetAcct2_Estimated_MaritalEquity – Client_RetAcct2_Estimated_Value_to_Op</label>
                                    <input id="Client_RetAcct2_Estimated_Value_to_Client" type="number" class="form-control 2_Client_clientamount_input clientamount_input" name="Client_RetAcct2_Estimated_Value_to_Client" value="" min="0.00" step="0.01" max="999999.99" readonly="">
                                </div>
                                <div class="form-group col-sm-6 Client_RetAcct_Paying_Party2_Inputs_Div" style="display: none;">
                                    <label>{{$opponent_name}} Retirement Accts Equity Percent</label>
                                    <input id="Client_RetAcct2_Percent_Marital_Equity_to_Op" type="number" class="form-control 2_Client_opponentpercentage_input opponentpercentage_input" name="Client_RetAcct2_Percent_Marital_Equity_to_Op" value="50.00" min="0.00" step="0.01" max="100" readonly="">
                                </div>
                                <div class="form-group col-sm-6 Client_RetAcct2_Disposition_Method_Fixed_Div Client_RetAcct_Paying_Party2_Inputs_Div" style="display: none;">
                                    <label>How much is to be paid to {{$opponent_name}}?</label>
                                    <input id="Client_RetAcct2_Estimated_Value_to_Op" type="number" class="form-control 2_Client_opponentamount_input opponentamount_input" name="Client_RetAcct2_Estimated_Value_to_Op" value="" min="0.00" step="0.01" max="999999.99" readonly="" onchange="getEstimatedValueOp(this, '2', 'Client');" onkeyup="getEstimatedValueOp(this, '2', 'Client');">
                                </div>
                                <!-- end of slider tool -->
                            </div>
                            <div class="col-sm-12 mt-4 3_Client_retirementaccts_section" style="display: none;"><h5 class="col-sm-12">Third Retirement Acct Info</h5>
                                <div class="form-group col-sm-6">
                                    <p class="text-danger 3_Client_no-state-county-found" style="display: none;">No City, State, County found for this zipcode.</p>
                                    <label for="Client_RetAcct3_Institution_ZIP">Retirement Account Institution Zip Code?</label>
                                    <input id="Client_RetAcct3_Institution_ZIP" type="text" class="form-control 3_Client_retirementaccts_inputs" name="Client_RetAcct3_Institution_ZIP" value="" onkeyup="getCityStateForZip(this, '3', 'Client');"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_RetAcct3_Institution_Name">Name of Retirement Account Institution?</label>
                                    <input id="Client_RetAcct3_Institution_Name" type="text" class="form-control 3_Client_retirementaccts_inputs" name="Client_RetAcct3_Institution_Name" value=""> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_RetAcct3_Institution_Street_Address">Retirement Account Institution Street Address?</label>
                                    <input id="Client_RetAcct3_Institution_Street_Address" type="text" class="form-control 3_Client_retirementaccts_inputs" name="Client_RetAcct3_Institution_Street_Address" value=""> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_RetAcct3_Institution_City">Retirement Account Institution City?</label>
                                    <select id="Client_RetAcct3_Institution_City" name="Client_RetAcct3_Institution_City" class="form-control 3_Client_city_select">
                                        <option value="">Choose City</option>
                                    </select>   
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_RetAcct3_Institution_State">Retirement Account Institution State?</label>
                                    <select id="Client_RetAcct3_Institution_State" name="Client_RetAcct3_Institution_State" class="form-control 3_Client_state_select">
                                        <option value="">Choose State</option>
                                    </select>   
                                </div>                                
                                <div class="form-group col-sm-6">
                                    <label for="Client_RetAcct3_Institution_Acct_Num">Account Number?</label>
                                    <input id="Client_RetAcct3_Institution_Acct_Num" type="text" class="form-control 3_Client_retirementaccts_inputs" name="Client_RetAcct3_Institution_Acct_Num" value="" onchange="getAcctNum(this, '3', 'Client');" onkeyup="getAcctNum(this, '3', 'Client');"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_RetAcct3_Date_of_Marriage_Balance">Balance on marriage date (0.00, if started after marriage)?</label>
                                    <input id="Client_RetAcct3_Date_of_Marriage_Balance" type="number" class="form-control 3_Client_retirementaccts_inputs" name="Client_RetAcct3_Date_of_Marriage_Balance" value="0.00" min="0.00" step="0.01" max="999999.99" onchange="getMarriageBalance(this, '3', 'Client');" onkeyup="getMarriageBalance(this, '3', 'Client');"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_RetAcct3_Current_Balance">Current Balance?</label>
                                    <input id="Client_RetAcct3_Current_Balance" type="number" class="form-control 3_Client_retirementaccts_inputs" name="Client_RetAcct3_Current_Balance" value="0.00" min="0.00" step="0.01" max="999999.99" onchange="getCurrentBalance(this, '3', 'Client');" onkeyup="getCurrentBalance(this, '3', 'Client');"> 
                                </div>                                
                                <div class="form-group col-sm-6">
                                    <label for="Client_RetAcct3_Estimated_MaritalEquity1">Marital Equity</label>
                                    <input id="Client_RetAcct3_Estimated_MaritalEquity1" type="number" class="form-control 3_Client_retirementaccts_inputs" name="Client_RetAcct3_Estimated_MaritalEquity1" value="0.00" min="0.00" step="0.01" max="999999.99" readonly=""> 
                                </div>                                
                                <div class="form-group col-sm-6">
                                    <label for="Client_RetAcct3_Current_Yearly_Income">Amount of Yearly Interest?</label>
                                    <input id="Client_RetAcct3_Current_Yearly_Income" type="number" class="form-control 3_Client_retirementaccts_inputs" name="Client_RetAcct3_Current_Yearly_Income" value="0.00" min="0.00" step="0.01" max="999999.99"> 
                                </div>

                                <div class="form-group col-sm-6">
                                    <label>Does either party claim a sole/separate interest from the other on this account?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Client_RetAcct3_SoleSeparate_Claim_Yes" name="Client_RetAcct3_SoleSeparate_Claim" value="Yes" onchange="getPartyClaimSoleSeparate(this, '3', 'Client');"> Yes</label>
                                        <label><input type="radio" id="Client_RetAcct3_SoleSeparate_Claim_No" name="Client_RetAcct3_SoleSeparate_Claim" value="No" checked="" onchange="getPartyClaimSoleSeparate(this, '3', 'Client');"> No</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6" id="Client_RetAcct3_SoleSeparate_Party_Div" style="display: none;">
                                    <label>Who claims to own this account?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Client_RetAcct3_SoleSeparate_Party_Client" name="Client_RetAcct3_SoleSeparate_Party" value="{{$client_name}}"> {{$client_name}}</label>
                                        <label><input type="radio" id="Client_RetAcct3_SoleSeparate_Party_Op" name="Client_RetAcct3_SoleSeparate_Party" value="{{$opponent_name}}"> {{$opponent_name}}</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6" id="Client_RetAcct3_SoleSeparate_Grounds_Div" style="display: none;">
                                    <label for="Client_RetAcct3_SoleSeparate_Grounds">Why does this person own this account solely and separately?</label>
                                    <input id="Client_RetAcct3_SoleSeparate_Grounds" type="text" class="form-control 3_Client_retirementaccts_inputs" name="Client_RetAcct3_SoleSeparate_Grounds" value=""> 
                                </div>
                                <!-- <div class="form-group col-sm-6">
                                    <label>What type of distribution will this be?</label>
                                    <div class="w-100 dataInput">
                                        <label><input type="radio" id="Client_RetAcct3_Disposition_Type_Distribute Investments" name="Client_RetAcct3_Disposition_Type" value="Distribute Investments"> Distribute Investments</label>
                                        <label><input type="radio" id="Client_RetAcct3_Disposition_Type_Liquidate/Split Net Value" name="Client_RetAcct3_Disposition_Type" value="Liquidate/Split Net Value"> Liquidate/Split Net Value</label>
                                        <label><input type="radio" id="Client_RetAcct3_Disposition_Type_QDRO" name="Client_RetAcct3_Disposition_Type" value="QDRO"> QDRO</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>How will this account value be distributed between the parties?</label>
                                    <div class="w-100 dataInput">
                                        <label><input type="radio" id="Client_RetAcct3_Disposition_Method_Percentage_Buyout" name="Client_RetAcct3_Disposition_Method" value="Percentage Buyout" onchange="getDipositionMethod(this, '3', 'Client');"> Percentage Buyout</label>
                                        <label><input type="radio" id="Client_RetAcct3_Disposition_Method_Fixed_Buyout" name="Client_RetAcct3_Disposition_Method" value="Fixed Buyout" onchange="getDipositionMethod(this, '3', 'Client');"> Fixed Buyout</label>
                                    </div>
                                </div> -->
                                <div class="form-group col-sm-6">
                                    <label>Distribute By</label>
                                    <div class="w-100 dataInput">
                                        <label><input type="radio" id="Client_RetAcct3_Disposition_Type_QDRO_Fixed" name="Client_RetAcct3_Disposition_Type_QDRO" value="QDRO_Fixed" onchange="getDistributionMethod(this, '3', 'Client');"> QDRO (Fixed amount to {{$opponent_name}})</label>
                                        <label><input type="radio" id="Client_RetAcct3_Disposition_Type_Fixed_Buyout" name="Client_RetAcct3_Disposition_Type_QDRO" value="Fixed_Buyout" onchange="getDistributionMethod(this, '3', 'Client');"> Buyout – Don’t distribute</label>
                                        <label><input type="radio" id="Client_RetAcct3_Disposition_Type_QDRO_Percentage" name="Client_RetAcct3_Disposition_Type_QDRO" value="QDRO_Percentage" onchange="getDistributionMethod(this, '3', 'Client');"> QDRO (Percent amount to {{$opponent_name}})</label>
                                    </div>                           
                                </div>
                                <div class="form-group col-sm-6 Client_RetAcct3_Disposition_Type_QDRO_Amount_Div" style="display: none;">
                                    <label for="Client_RetAcct3_Disposition_Type_QDRO_Amount">Enter Fixed Amount to {{$opponent_name}}</label>
                                    <input id="Client_RetAcct3_Disposition_Type_QDRO_Amount" type="number" class="form-control 3_Client_retirementaccts_inputs" name="Client_RetAcct3_Disposition_Type_QDRO_Amount" value="0.00" min="0.00" step="0.01" max="999999.99" onchange="getQDROFixedAmount(this, '3', 'Client');" onkeyup="getQDROFixedAmount(this, '3', 'Client');">
                                </div>
                                <div class="form-group col-sm-6 Client_RetAcct3_Disposition_Type_QDRO_Percentage_Amount_Div" style="display: none;">
                                    <label for="Client_RetAcct3_Disposition_Type_QDRO_Percentage_Amount">Enter Fixed Percenrage Amount to {{$opponent_name}}</label>
                                    <input id="Client_RetAcct3_Disposition_Type_QDRO_Percentage_Amount" type="number" class="form-control 3_Client_retirementaccts_inputs" name="Client_RetAcct3_Disposition_Type_QDRO_Percentage_Amount" value="0.00" min="0.00" step="0.01" max="100" onchange="getQDROFixedPercentageAmount(this, '3', 'Client');" onkeyup="getQDROFixedPercentageAmount(this, '3', 'Client');">
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
                                                    $0.00
                                                </div>
                                                <div class="client-info 3_Client_EPclientamount_div EPclientamount_div" style="clear: both;"><span>$0.00</span>
                                                    <input type="number" id="Client_RetAcct3_Estimated_EP_to_Client" name="Client_RetAcct3_Estimated_EP_to_Client" value="0.00" readonly="" style="display: none;">
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
                                                    $0.00
                                                </div>
                                                <div class="client-info 3_Client_EPopponentamount_div EPopponentamount_div" style="clear: both;"><span>$0.00</span>
                                                    <input type="number" id="Client_RetAcct3_Estimated_EP_to_Op" name="Client_RetAcct3_Estimated_EP_to_Op" value="0.00" readonly="" style="display: none;">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 m-auto 3_Client_Slider_Tool slider-tool-main">
                                    <label><strong>{{$client_name}} Retirement Acct#-<span class="3_Client_RetAcct_Number_Span"></span> Equalization Payment</strong></label>
                                    <div class="w-100">
                                        <label><input type="radio" id="3_Client_RetAcct_Estimated_Value_Select" name="3_Client_RetAcct_Estimated_Value_Select_Reset" class="RetAcct_Estimated_Value_Select_Reset" value="Save"> Save this Distribution of Retirement Acct#-<span class="3_Client_RetAcct_Number_Span">3</span></label>
                                        <label><input type="radio" id="3_Client_RetAcct_Estimated_Value_Reset" name="3_Client_RetAcct_Estimated_Value_Select_Reset" class="RetAcct_Estimated_Value_Select_Reset" value="Reset" onclick="resetBalanceInput(this, '3', 'Client');"> Reset to Default (50%)</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 Client_RetAcct_Paying_Party3_Inputs_Div" style="display: none;">
                                    <label>{{$client_name}} Retirement Accts Equity Percent</label>
                                    <input id="Client_RetAcct3_Percent_Marital_Equity_to_Client" type="number" class="form-control 3_Client_clientpercentage_input clientpercentage_input" name="Client_RetAcct3_Percent_Marital_Equity_to_Client" value="50.00" min="0.00" step="0.01" max="100" readonly="">
                                </div>
                                <div class="form-group col-sm-6 Client_RetAcct_Paying_Party3_Inputs_Div" style="display: none;">
                                    <label>N/A, calculated = Client_RetAcct3_Estimated_MaritalEquity – Client_RetAcct3_Estimated_Value_to_Op</label>
                                    <input id="Client_RetAcct3_Estimated_Value_to_Client" type="number" class="form-control 3_Client_clientamount_input clientamount_input" name="Client_RetAcct3_Estimated_Value_to_Client" value="" min="0.00" step="0.01" max="999999.99" readonly="">
                                </div>
                                <div class="form-group col-sm-6 Client_RetAcct_Paying_Party3_Inputs_Div" style="display: none;">
                                    <label>{{$opponent_name}} Retirement Accts Equity Percent</label>
                                    <input id="Client_RetAcct3_Percent_Marital_Equity_to_Op" type="number" class="form-control 3_Client_opponentpercentage_input opponentpercentage_input" name="Client_RetAcct3_Percent_Marital_Equity_to_Op" value="50.00" min="0.00" step="0.01" max="100" readonly="">
                                </div>
                                <div class="form-group col-sm-6 Client_RetAcct3_Disposition_Method_Fixed_Div Client_RetAcct_Paying_Party3_Inputs_Div" style="display: none;">
                                    <label>How much is to be paid to {{$opponent_name}}?</label>
                                    <input id="Client_RetAcct3_Estimated_Value_to_Op" type="number" class="form-control 3_Client_opponentamount_input opponentamount_input" name="Client_RetAcct3_Estimated_Value_to_Op" value="" min="0.00" step="0.01" max="999999.99" readonly="" onchange="getEstimatedValueOp(this, '3', 'Client');" onkeyup="getEstimatedValueOp(this, '3', 'Client');">
                                </div>
                                <!-- end of slider tool -->
                            </div>
                            <div class="col-sm-12 mt-4 4_Client_retirementaccts_section" style="display: none;"><h5 class="col-sm-12">Fourth Retirement Acct Info</h5>
                                <div class="form-group col-sm-6">
                                    <p class="text-danger 4_Client_no-state-county-found" style="display: none;">No City, State, County found for this zipcode.</p>
                                    <label for="Client_RetAcct4_Institution_ZIP">Retirement Account Institution Zip Code?</label>
                                    <input id="Client_RetAcct4_Institution_ZIP" type="text" class="form-control 4_Client_retirementaccts_inputs" name="Client_RetAcct4_Institution_ZIP" value="" onkeyup="getCityStateForZip(this, '4', 'Client');"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_RetAcct4_Institution_Name">Name of Retirement Account Institution?</label>
                                    <input id="Client_RetAcct4_Institution_Name" type="text" class="form-control 4_Client_retirementaccts_inputs" name="Client_RetAcct4_Institution_Name" value=""> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_RetAcct4_Institution_Street_Address">Retirement Account Institution Street Address?</label>
                                    <input id="Client_RetAcct4_Institution_Street_Address" type="text" class="form-control 4_Client_retirementaccts_inputs" name="Client_RetAcct4_Institution_Street_Address" value=""> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_RetAcct4_Institution_City">Retirement Account Institution City?</label>
                                    <select id="Client_RetAcct4_Institution_City" name="Client_RetAcct4_Institution_City" class="form-control 4_Client_city_select">
                                        <option value="">Choose City</option>
                                    </select>   
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_RetAcct4_Institution_State">Retirement Account Institution State?</label>
                                    <select id="Client_RetAcct4_Institution_State" name="Client_RetAcct4_Institution_State" class="form-control 4_Client_state_select">
                                        <option value="">Choose State</option>
                                    </select>   
                                </div>                                
                                <div class="form-group col-sm-6">
                                    <label for="Client_RetAcct4_Institution_Acct_Num">Account Number?</label>
                                    <input id="Client_RetAcct4_Institution_Acct_Num" type="text" class="form-control 4_Client_retirementaccts_inputs" name="Client_RetAcct4_Institution_Acct_Num" value="" onchange="getAcctNum(this, '4', 'Client');" onkeyup="getAcctNum(this, '4', 'Client');"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_RetAcct4_Date_of_Marriage_Balance">Balance on marriage date (0.00, if started after marriage)?</label>
                                    <input id="Client_RetAcct4_Date_of_Marriage_Balance" type="number" class="form-control 4_Client_retirementaccts_inputs" name="Client_RetAcct4_Date_of_Marriage_Balance" value="0.00" min="0.00" step="0.01" max="999999.99" onchange="getMarriageBalance(this, '4', 'Client');" onkeyup="getMarriageBalance(this, '4', 'Client');"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_RetAcct4_Current_Balance">Current Balance?</label>
                                    <input id="Client_RetAcct4_Current_Balance" type="number" class="form-control 4_Client_retirementaccts_inputs" name="Client_RetAcct4_Current_Balance" value="0.00" min="0.00" step="0.01" max="999999.99" onchange="getCurrentBalance(this, '4', 'Client');" onkeyup="getCurrentBalance(this, '4', 'Client');"> 
                                </div>                                
                                <div class="form-group col-sm-6">
                                    <label for="Client_RetAcct4_Estimated_MaritalEquity1">Marital Equity</label>
                                    <input id="Client_RetAcct4_Estimated_MaritalEquity1" type="number" class="form-control 4_Client_retirementaccts_inputs" name="Client_RetAcct4_Estimated_MaritalEquity1" value="0.00" min="0.00" step="0.01" max="999999.99" readonly=""> 
                                </div>                                
                                <div class="form-group col-sm-6">
                                    <label for="Client_RetAcct4_Current_Yearly_Income">Amount of Yearly Interest?</label>
                                    <input id="Client_RetAcct4_Current_Yearly_Income" type="number" class="form-control 4_Client_retirementaccts_inputs" name="Client_RetAcct4_Current_Yearly_Income" value="0.00" min="0.00" step="0.01" max="999999.99"> 
                                </div>

                                <div class="form-group col-sm-6">
                                    <label>Does either party claim a sole/separate interest from the other on this account?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Client_RetAcct4_SoleSeparate_Claim_Yes" name="Client_RetAcct4_SoleSeparate_Claim" value="Yes" onchange="getPartyClaimSoleSeparate(this, '4', 'Client');"> Yes</label>
                                        <label><input type="radio" id="Client_RetAcct4_SoleSeparate_Claim_No" name="Client_RetAcct4_SoleSeparate_Claim" value="No" checked="" onchange="getPartyClaimSoleSeparate(this, '4', 'Client');"> No</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6" id="Client_RetAcct4_SoleSeparate_Party_Div" style="display: none;">
                                    <label>Who claims to own this account?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Client_RetAcct4_SoleSeparate_Party_Client" name="Client_RetAcct4_SoleSeparate_Party" value="{{$client_name}}"> {{$client_name}}</label>
                                        <label><input type="radio" id="Client_RetAcct4_SoleSeparate_Party_Op" name="Client_RetAcct4_SoleSeparate_Party" value="{{$opponent_name}}"> {{$opponent_name}}</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6" id="Client_RetAcct4_SoleSeparate_Grounds_Div" style="display: none;">
                                    <label for="Client_RetAcct4_SoleSeparate_Grounds">Why does this person own this account solely and separately?</label>
                                    <input id="Client_RetAcct4_SoleSeparate_Grounds" type="text" class="form-control 4_Client_retirementaccts_inputs" name="Client_RetAcct4_SoleSeparate_Grounds" value=""> 
                                </div>
                                <!-- <div class="form-group col-sm-6">
                                    <label>What type of distribution will this be?</label>
                                    <div class="w-100 dataInput">
                                        <label><input type="radio" id="Client_RetAcct4_Disposition_Type_Distribute Investments" name="Client_RetAcct4_Disposition_Type" value="Distribute Investments"> Distribute Investments</label>
                                        <label><input type="radio" id="Client_RetAcct4_Disposition_Type_Liquidate/Split Net Value" name="Client_RetAcct4_Disposition_Type" value="Liquidate/Split Net Value"> Liquidate/Split Net Value</label>
                                        <label><input type="radio" id="Client_RetAcct4_Disposition_Type_QDRO" name="Client_RetAcct4_Disposition_Type" value="QDRO"> QDRO</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>How will this account value be distributed between the parties?</label>
                                    <div class="w-100 dataInput">
                                        <label><input type="radio" id="Client_RetAcct4_Disposition_Method_Percentage_Buyout" name="Client_RetAcct4_Disposition_Method" value="Percentage Buyout" onchange="getDipositionMethod(this, '4', 'Client');"> Percentage Buyout</label>
                                        <label><input type="radio" id="Client_RetAcct4_Disposition_Method_Fixed_Buyout" name="Client_RetAcct4_Disposition_Method" value="Fixed Buyout" onchange="getDipositionMethod(this, '4', 'Client');"> Fixed Buyout</label>
                                    </div>
                                </div> -->
                                <div class="form-group col-sm-6">
                                    <label>Distribute By</label>
                                    <div class="w-100 dataInput">
                                        <label><input type="radio" id="Client_RetAcct4_Disposition_Type_QDRO_Fixed" name="Client_RetAcct4_Disposition_Type_QDRO" value="QDRO_Fixed" onchange="getDistributionMethod(this, '4', 'Client');"> QDRO (Fixed amount to {{$opponent_name}})</label>
                                        <label><input type="radio" id="Client_RetAcct4_Disposition_Type_Fixed_Buyout" name="Client_RetAcct4_Disposition_Type_QDRO" value="Fixed_Buyout" onchange="getDistributionMethod(this, '4', 'Client');"> Buyout – Don’t distribute</label>
                                        <label><input type="radio" id="Client_RetAcct4_Disposition_Type_QDRO_Percentage" name="Client_RetAcct4_Disposition_Type_QDRO" value="QDRO_Percentage" onchange="getDistributionMethod(this, '4', 'Client');"> QDRO (Percent amount to {{$opponent_name}})</label>
                                    </div>                           
                                </div>
                                <div class="form-group col-sm-6 Client_RetAcct4_Disposition_Type_QDRO_Amount_Div" style="display: none;">
                                    <label for="Client_RetAcct4_Disposition_Type_QDRO_Amount">Enter Fixed Amount to {{$opponent_name}}</label>
                                    <input id="Client_RetAcct4_Disposition_Type_QDRO_Amount" type="number" class="form-control 4_Client_retirementaccts_inputs" name="Client_RetAcct4_Disposition_Type_QDRO_Amount" value="0.00" min="0.00" step="0.01" max="999999.99" onchange="getQDROFixedAmount(this, '4', 'Client');" onkeyup="getQDROFixedAmount(this, '4', 'Client');">
                                </div>
                                <div class="form-group col-sm-6 Client_RetAcct4_Disposition_Type_QDRO_Percentage_Amount_Div" style="display: none;">
                                    <label for="Client_RetAcct4_Disposition_Type_QDRO_Percentage_Amount">Enter Fixed Percenrage Amount to {{$opponent_name}}</label>
                                    <input id="Client_RetAcct4_Disposition_Type_QDRO_Percentage_Amount" type="number" class="form-control 4_Client_retirementaccts_inputs" name="Client_RetAcct4_Disposition_Type_QDRO_Percentage_Amount" value="0.00" min="0.00" step="0.01" max="100" onchange="getQDROFixedPercentageAmount(this, '4', 'Client');" onkeyup="getQDROFixedPercentageAmount(this, '4', 'Client');">
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
                                                    $0.00
                                                </div>
                                                <div class="client-info 4_Client_EPclientamount_div EPclientamount_div" style="clear: both;"><span>$0.00</span>
                                                    <input type="number" id="Client_RetAcct4_Estimated_EP_to_Client" name="Client_RetAcct4_Estimated_EP_to_Client" value="0.00" readonly="" style="display: none;">
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
                                                    $0.00
                                                </div>
                                                <div class="client-info 4_Client_EPopponentamount_div EPopponentamount_div" style="clear: both;"><span>$0.00</span>
                                                    <input type="number" id="Client_RetAcct4_Estimated_EP_to_Op" name="Client_RetAcct4_Estimated_EP_to_Op" value="0.00" readonly="" style="display: none;">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 m-auto 4_Client_Slider_Tool slider-tool-main">
                                    <label><strong>{{$client_name}} Retirement Acct#-<span class="4_Client_RetAcct_Number_Span"></span> Equalization Payment</strong></label>
                                    <div class="w-100">
                                        <label><input type="radio" id="4_Client_RetAcct_Estimated_Value_Select" name="4_Client_RetAcct_Estimated_Value_Select_Reset" class="RetAcct_Estimated_Value_Select_Reset" value="Save"> Save this Distribution of Retirement Acct#-<span class="4_Client_RetAcct_Number_Span">4</span></label>
                                        <label><input type="radio" id="4_Client_RetAcct_Estimated_Value_Reset" name="4_Client_RetAcct_Estimated_Value_Select_Reset" class="RetAcct_Estimated_Value_Select_Reset" value="Reset" onclick="resetBalanceInput(this, '4', 'Client');"> Reset to Default (50%)</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 Client_RetAcct_Paying_Party4_Inputs_Div" style="display: none;">
                                    <label>{{$client_name}} Retirement Accts Equity Percent</label>
                                    <input id="Client_RetAcct4_Percent_Marital_Equity_to_Client" type="number" class="form-control 4_Client_clientpercentage_input clientpercentage_input" name="Client_RetAcct4_Percent_Marital_Equity_to_Client" value="50.00" min="0.00" step="0.01" max="100" readonly="">
                                </div>
                                <div class="form-group col-sm-6 Client_RetAcct_Paying_Party4_Inputs_Div" style="display: none;">
                                    <label>N/A, calculated = Client_RetAcct4_Estimated_MaritalEquity – Client_RetAcct4_Estimated_Value_to_Op</label>
                                    <input id="Client_RetAcct4_Estimated_Value_to_Client" type="number" class="form-control 4_Client_clientamount_input clientamount_input" name="Client_RetAcct4_Estimated_Value_to_Client" value="" min="0.00" step="0.01" max="999999.99" readonly="">
                                </div>
                                <div class="form-group col-sm-6 Client_RetAcct_Paying_Party4_Inputs_Div" style="display: none;">
                                    <label>{{$opponent_name}} Retirement Accts Equity Percent</label>
                                    <input id="Client_RetAcct4_Percent_Marital_Equity_to_Op" type="number" class="form-control 4_Client_opponentpercentage_input opponentpercentage_input" name="Client_RetAcct4_Percent_Marital_Equity_to_Op" value="50.00" min="0.00" step="0.01" max="100" readonly="">
                                </div>
                                <div class="form-group col-sm-6 Client_RetAcct4_Disposition_Method_Fixed_Div Client_RetAcct_Paying_Party4_Inputs_Div" style="display: none;">
                                    <label>How much is to be paid to {{$opponent_name}}?</label>
                                    <input id="Client_RetAcct4_Estimated_Value_to_Op" type="number" class="form-control 4_Client_opponentamount_input opponentamount_input" name="Client_RetAcct4_Estimated_Value_to_Op" value="" min="0.00" step="0.01" max="999999.99" readonly="" onchange="getEstimatedValueOp(this, '4', 'Client');" onkeyup="getEstimatedValueOp(this, '4', 'Client');">
                                </div>
                                <!-- end of slider tool -->
                            </div>
                        </div>
                        <!-- End of Client Retirement Accts Info Section -->

                        <!-- Opponent Retirement Accts Info Section -->

                        <div class="form-row num_Op_Retirement_Accts_info mt-4" style="display: none;">
                            <h4 class="col-sm-12">{{$opponent_name}} Retirement Accts Info Section</h4>
                            <div class="col-sm-6">
                                <label for="Num_Op_Retirement_Accts">How many pensions does {{$opponent_name}} have or is contributing to?</label>
                                <input id="Num_Op_Retirement_Accts" type="number" class="form-control" name="Num_Op_Retirement_Accts" value="<?php if(isset($drcaseoverview->Num_Op_Retirement_Accts)){ echo $drcaseoverview->Num_Op_Retirement_Accts; } ?>" min="0" max="4"> 
                            </div>
                        </div>
                        <div class="form-row Op_retirementaccts_section mt-2">
                            <div class="col-sm-12 mt-4 1_Op_retirementaccts_section" style="display: none;"><h5 class="col-sm-12">First Retirement Acct Info</h5>
                                <div class="form-group col-sm-6">
                                    <p class="text-danger 1_Op_no-state-county-found" style="display: none;">No City, State, County found for this zipcode.</p>
                                    <label for="Op_RetAcct1_Institution_ZIP">Retirement Account Institution Zip Code?</label>
                                    <input id="Op_RetAcct1_Institution_ZIP" type="text" class="form-control 1_Op_retirementaccts_inputs" name="Op_RetAcct1_Institution_ZIP" value="" onkeyup="getCityStateForZip(this, '1', 'Op');"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_RetAcct1_Institution_Name">Name of Retirement Account Institution?</label>
                                    <input id="Op_RetAcct1_Institution_Name" type="text" class="form-control 1_Op_retirementaccts_inputs" name="Op_RetAcct1_Institution_Name" value=""> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_RetAcct1_Institution_Street_Address">Retirement Account Institution Street Address?</label>
                                    <input id="Op_RetAcct1_Institution_Street_Address" type="text" class="form-control 1_Op_retirementaccts_inputs" name="Op_RetAcct1_Institution_Street_Address" value=""> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_RetAcct1_Institution_City">Retirement Account Institution City?</label>
                                    <select id="Op_RetAcct1_Institution_City" name="Op_RetAcct1_Institution_City" class="form-control 1_Op_city_select">
                                        <option value="">Choose City</option>
                                    </select>   
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_RetAcct1_Institution_State">Retirement Account Institution State?</label>
                                    <select id="Op_RetAcct1_Institution_State" name="Op_RetAcct1_Institution_State" class="form-control 1_Op_state_select">
                                        <option value="">Choose State</option>
                                    </select>   
                                </div>                                
                                <div class="form-group col-sm-6">
                                    <label for="Op_RetAcct1_Institution_Acct_Num">Account Number?</label>
                                    <input id="Op_RetAcct1_Institution_Acct_Num" type="text" class="form-control 1_Op_retirementaccts_inputs" name="Op_RetAcct1_Institution_Acct_Num" value="" onchange="getAcctNum(this, '1', 'Op');" onkeyup="getAcctNum(this, '1', 'Op');"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_RetAcct1_Date_of_Marriage_Balance">Balance on marriage date (0.00, if started after marriage)?</label>
                                    <input id="Op_RetAcct1_Date_of_Marriage_Balance" type="number" class="form-control 1_Op_retirementaccts_inputs" name="Op_RetAcct1_Date_of_Marriage_Balance" value="0.00" min="0.00" step="0.01" max="999999.99" onchange="getMarriageBalance(this, '1', 'Op');" onkeyup="getMarriageBalance(this, '1', 'Op');"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_RetAcct1_Current_Balance">Current Balance?</label>
                                    <input id="Op_RetAcct1_Current_Balance" type="number" class="form-control 1_Op_retirementaccts_inputs" name="Op_RetAcct1_Current_Balance" value="0.00" min="0.00" step="0.01" max="999999.99" onchange="getCurrentBalance(this, '1', 'Op');" onkeyup="getCurrentBalance(this, '1', 'Op');"> 
                                </div>                                
                                <div class="form-group col-sm-6">
                                    <label for="Op_RetAcct1_Estimated_MaritalEquity1">Marital Equity</label>
                                    <input id="Op_RetAcct1_Estimated_MaritalEquity1" type="number" class="form-control 1_Op_retirementaccts_inputs" name="Op_RetAcct1_Estimated_MaritalEquity1" value="0.00" min="0.00" step="0.01" max="999999.99" readonly=""> 
                                </div>                                
                                <div class="form-group col-sm-6">
                                    <label for="Op_RetAcct1_Current_Yearly_Income">Amount of Yearly Interest?</label>
                                    <input id="Op_RetAcct1_Current_Yearly_Income" type="number" class="form-control 1_Op_retirementaccts_inputs" name="Op_RetAcct1_Current_Yearly_Income" value="0.00" min="0.00" step="0.01" max="999999.99"> 
                                </div>

                                <div class="form-group col-sm-6">
                                    <label>Does either party claim a sole/separate interest from the other on this account?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Op_RetAcct1_SoleSeparate_Claim_Yes" name="Op_RetAcct1_SoleSeparate_Claim" value="Yes" onchange="getPartyClaimSoleSeparate(this, '1', 'Op');"> Yes</label>
                                        <label><input type="radio" id="Op_RetAcct1_SoleSeparate_Claim_No" name="Op_RetAcct1_SoleSeparate_Claim" value="No" checked="" onchange="getPartyClaimSoleSeparate(this, '1', 'Op');"> No</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6" id="Op_RetAcct1_SoleSeparate_Party_Div" style="display: none;">
                                    <label>Who claims to own this account?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Op_RetAcct1_SoleSeparate_Party_Client" name="Op_RetAcct1_SoleSeparate_Party" value="{{$client_name}}"> {{$client_name}}</label>
                                        <label><input type="radio" id="Op_RetAcct1_SoleSeparate_Party_Op" name="Op_RetAcct1_SoleSeparate_Party" value="{{$opponent_name}}"> {{$opponent_name}}</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6" id="Op_RetAcct1_SoleSeparate_Grounds_Div" style="display: none;">
                                    <label for="Op_RetAcct1_SoleSeparate_Grounds">Why does this person own this account solely and separately?</label>
                                    <input id="Op_RetAcct1_SoleSeparate_Grounds" type="text" class="form-control 1_Op_retirementaccts_inputs" name="Op_RetAcct1_SoleSeparate_Grounds" value=""> 
                                </div>
                                <!-- <div class="form-group col-sm-6">
                                    <label>What type of distribution will this be?</label>
                                    <div class="w-100 dataInput">
                                        <label><input type="radio" id="Op_RetAcct1_Disposition_Type_Distribute Investments" name="Op_RetAcct1_Disposition_Type" value="Distribute Investments"> Distribute Investments</label>
                                        <label><input type="radio" id="Op_RetAcct1_Disposition_Type_Liquidate/Split Net Value" name="Op_RetAcct1_Disposition_Type" value="Liquidate/Split Net Value"> Liquidate/Split Net Value</label>
                                        <label><input type="radio" id="Op_RetAcct1_Disposition_Type_QDRO" name="Op_RetAcct1_Disposition_Type" value="QDRO"> QDRO</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>How will this account value be distributed between the parties?</label>
                                    <div class="w-100 dataInput">
                                        <label><input type="radio" id="Op_RetAcct1_Disposition_Method_Percentage_Buyout" name="Op_RetAcct1_Disposition_Method" value="Percentage Buyout" onchange="getDipositionMethod(this, '1', 'Op');"> Percentage Buyout</label>
                                        <label><input type="radio" id="Op_RetAcct1_Disposition_Method_Fixed_Buyout" name="Op_RetAcct1_Disposition_Method" value="Fixed Buyout" onchange="getDipositionMethod(this, '1', 'Op');"> Fixed Buyout</label>
                                    </div>
                                </div> -->
                                <div class="form-group col-sm-6">
                                    <label>Distribute By</label>
                                    <div class="w-100 dataInput">
                                        <label><input type="radio" id="Op_RetAcct1_Disposition_Type_QDRO_Fixed" name="Op_RetAcct1_Disposition_Type_QDRO" value="QDRO_Fixed" onchange="getDistributionMethod(this, '1', 'Op');"> QDRO (Fixed amount to {{$client_name}})</label>
                                        <label><input type="radio" id="Op_RetAcct1_Disposition_Type_Fixed_Buyout" name="Op_RetAcct1_Disposition_Type_QDRO" value="Fixed_Buyout" onchange="getDistributionMethod(this, '1', 'Op');"> Buyout – Don’t distribute</label>
                                        <label><input type="radio" id="Op_RetAcct1_Disposition_Type_QDRO_Percentage" name="Op_RetAcct1_Disposition_Type_QDRO" value="QDRO_Percentage" onchange="getDistributionMethod(this, '1', 'Op');"> QDRO (Percent amount to {{$client_name}})</label>
                                    </div>                           
                                </div>
                                <div class="form-group col-sm-6 Op_RetAcct1_Disposition_Type_QDRO_Amount_Div" style="display: none;">
                                    <label for="Op_RetAcct1_Disposition_Type_QDRO_Amount">Enter Fixed Amount to {{$client_name}}</label>
                                    <input id="Op_RetAcct1_Disposition_Type_QDRO_Amount" type="number" class="form-control 1_Op_retirementaccts_inputs" name="Op_RetAcct1_Disposition_Type_QDRO_Amount" value="0.00" min="0.00" step="0.01" max="999999.99" onchange="getQDROFixedAmount(this, '1', 'Op');" onkeyup="getQDROFixedAmount(this, '1', 'Op');">
                                </div>
                                <div class="form-group col-sm-6 Op_RetAcct1_Disposition_Type_QDRO_Percentage_Amount_Div" style="display: none;">
                                    <label for="Op_RetAcct1_Disposition_Type_QDRO_Percentage_Amount">Enter Fixed Percenrage Amount to {{$client_name}}</label>
                                    <input id="Op_RetAcct1_Disposition_Type_QDRO_Percentage_Amount" type="number" class="form-control 1_Op_retirementaccts_inputs" name="Op_RetAcct1_Disposition_Type_QDRO_Percentage_Amount" value="0.00" min="0.00" step="0.01" max="100" onchange="getQDROFixedPercentageAmount(this, '1', 'Op');" onkeyup="getQDROFixedPercentageAmount(this, '1', 'Op');">
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
                                                    $0.00
                                                </div>
                                                <div class="client-info 1_Op_EPclientamount_div EPclientamount_div" style="clear: both;"><span>$0.00</span>
                                                    <input type="number" id="Op_RetAcct1_Estimated_EP_to_Client" name="Op_RetAcct1_Estimated_EP_to_Client" value="0.00" readonly="" style="display: none;">
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
                                                    $0.00
                                                </div>
                                                <div class="client-info 1_Op_EPopponentamount_div EPopponentamount_div" style="clear: both;"><span>$0.00</span>
                                                    <input type="number" id="Op_RetAcct1_Estimated_EP_to_Op" name="Op_RetAcct1_Estimated_EP_to_Op" value="0.00" readonly="" style="display: none;">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 m-auto 1_Op_Slider_Tool slider-tool-main">
                                    <label><strong>{{$opponent_name}} Retirement Acct#-<span class="1_Op_RetAcct_Number_Span"></span> Equalization Payment</strong></label>
                                    <div class="w-100">
                                        <label><input type="radio" id="1_Op_RetAcct_Estimated_Value_Select" name="1_Op_RetAcct_Estimated_Value_Select_Reset" class="RetAcct_Estimated_Value_Select_Reset" value="Save"> Save this Distribution of Retirement Acct#-<span class="1_Op_RetAcct_Number_Span">1</span></label>
                                        <label><input type="radio" id="1_Op_RetAcct_Estimated_Value_Reset" name="1_Op_RetAcct_Estimated_Value_Select_Reset" class="RetAcct_Estimated_Value_Select_Reset" value="Reset" onclick="resetBalanceInput(this, '1', 'Op');"> Reset to Default (50%)</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 Op_RetAcct_Paying_Party1_Inputs_Div" style="display: none;">
                                    <label>{{$client_name}} Retirement Accts Equity Percent</label>
                                    <input id="Op_RetAcct1_Percent_Marital_Equity_to_Client" type="number" class="form-control 1_Op_clientpercentage_input clientpercentage_input" name="Op_RetAcct1_Percent_Marital_Equity_to_Client" value="50.00" min="0.00" step="0.01" max="100" readonly="">
                                </div>
                                <div class="form-group col-sm-6 Op_RetAcct_Paying_Party1_Inputs_Div" style="display: none;">
                                    <label>N/A, calculated = Op_RetAcct1_Estimated_MaritalEquity – Op_RetAcct1_Estimated_Value_to_Op</label>
                                    <input id="Op_RetAcct1_Estimated_Value_to_Client" type="number" class="form-control 1_Op_clientamount_input clientamount_input" name="Op_RetAcct1_Estimated_Value_to_Client" value="" min="0.00" step="0.01" max="999999.99" readonly="">
                                </div>
                                <div class="form-group col-sm-6 Op_RetAcct_Paying_Party1_Inputs_Div" style="display: none;">
                                    <label>{{$opponent_name}} Retirement Accts Equity Percent</label>
                                    <input id="Op_RetAcct1_Percent_Marital_Equity_to_Op" type="number" class="form-control 1_Op_opponentpercentage_input opponentpercentage_input" name="Op_RetAcct1_Percent_Marital_Equity_to_Op" value="50.00" min="0.00" step="0.01" max="100" readonly="">
                                </div>
                                <div class="form-group col-sm-6 Op_RetAcct1_Disposition_Method_Fixed_Div Op_RetAcct_Paying_Party1_Inputs_Div" style="display: none;">
                                    <label>How much is to be paid to {{$opponent_name}}?</label>
                                    <input id="Op_RetAcct1_Estimated_Value_to_Op" type="number" class="form-control 1_Op_opponentamount_input opponentamount_input" name="Op_RetAcct1_Estimated_Value_to_Op" value="" min="0.00" step="0.01" max="999999.99" readonly="" onchange="getEstimatedValueOp(this, '1', 'Op');" onkeyup="getEstimatedValueOp(this, '1', 'Op');">
                                </div>
                                <!-- end of slider tool -->
                            </div>
                            <div class="col-sm-12 mt-4 2_Op_retirementaccts_section" style="display: none;"><h5 class="col-sm-12">Second Retirement Acct Info</h5>
                                <div class="form-group col-sm-6">
                                    <p class="text-danger 2_Op_no-state-county-found" style="display: none;">No City, State, County found for this zipcode.</p>
                                    <label for="Op_RetAcct2_Institution_ZIP">Retirement Account Institution Zip Code?</label>
                                    <input id="Op_RetAcct2_Institution_ZIP" type="text" class="form-control 2_Op_retirementaccts_inputs" name="Op_RetAcct2_Institution_ZIP" value="" onkeyup="getCityStateForZip(this, '2', 'Op');"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_RetAcct2_Institution_Name">Name of Retirement Account Institution?</label>
                                    <input id="Op_RetAcct2_Institution_Name" type="text" class="form-control 2_Op_retirementaccts_inputs" name="Op_RetAcct2_Institution_Name" value=""> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_RetAcct2_Institution_Street_Address">Retirement Account Institution Street Address?</label>
                                    <input id="Op_RetAcct2_Institution_Street_Address" type="text" class="form-control 2_Op_retirementaccts_inputs" name="Op_RetAcct2_Institution_Street_Address" value=""> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_RetAcct2_Institution_City">Retirement Account Institution City?</label>
                                    <select id="Op_RetAcct2_Institution_City" name="Op_RetAcct2_Institution_City" class="form-control 2_Op_city_select">
                                        <option value="">Choose City</option>
                                    </select>   
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_RetAcct2_Institution_State">Retirement Account Institution State?</label>
                                    <select id="Op_RetAcct2_Institution_State" name="Op_RetAcct2_Institution_State" class="form-control 2_Op_state_select">
                                        <option value="">Choose State</option>
                                    </select>   
                                </div>                                
                                <div class="form-group col-sm-6">
                                    <label for="Op_RetAcct2_Institution_Acct_Num">Account Number?</label>
                                    <input id="Op_RetAcct2_Institution_Acct_Num" type="text" class="form-control 2_Op_retirementaccts_inputs" name="Op_RetAcct2_Institution_Acct_Num" value="" onchange="getAcctNum(this, '2', 'Op');" onkeyup="getAcctNum(this, '2', 'Op');"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_RetAcct2_Date_of_Marriage_Balance">Balance on marriage date (0.00, if started after marriage)?</label>
                                    <input id="Op_RetAcct2_Date_of_Marriage_Balance" type="number" class="form-control 2_Op_retirementaccts_inputs" name="Op_RetAcct2_Date_of_Marriage_Balance" value="0.00" min="0.00" step="0.01" max="999999.99" onchange="getMarriageBalance(this, '2', 'Op');" onkeyup="getMarriageBalance(this, '2', 'Op');"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_RetAcct2_Current_Balance">Current Balance?</label>
                                    <input id="Op_RetAcct2_Current_Balance" type="number" class="form-control 2_Op_retirementaccts_inputs" name="Op_RetAcct2_Current_Balance" value="0.00" min="0.00" step="0.01" max="999999.99" onchange="getCurrentBalance(this, '2', 'Op');" onkeyup="getCurrentBalance(this, '2', 'Op');"> 
                                </div>                                
                                <div class="form-group col-sm-6">
                                    <label for="Op_RetAcct2_Estimated_MaritalEquity1">Marital Equity</label>
                                    <input id="Op_RetAcct2_Estimated_MaritalEquity1" type="number" class="form-control 2_Op_retirementaccts_inputs" name="Op_RetAcct2_Estimated_MaritalEquity1" value="0.00" min="0.00" step="0.01" max="999999.99" readonly=""> 
                                </div>                                
                                <div class="form-group col-sm-6">
                                    <label for="Op_RetAcct2_Current_Yearly_Income">Amount of Yearly Interest?</label>
                                    <input id="Op_RetAcct2_Current_Yearly_Income" type="number" class="form-control 2_Op_retirementaccts_inputs" name="Op_RetAcct2_Current_Yearly_Income" value="0.00" min="0.00" step="0.01" max="999999.99"> 
                                </div>

                                <div class="form-group col-sm-6">
                                    <label>Does either party claim a sole/separate interest from the other on this account?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Op_RetAcct2_SoleSeparate_Claim_Yes" name="Op_RetAcct2_SoleSeparate_Claim" value="Yes" onchange="getPartyClaimSoleSeparate(this, '2', 'Op');"> Yes</label>
                                        <label><input type="radio" id="Op_RetAcct2_SoleSeparate_Claim_No" name="Op_RetAcct2_SoleSeparate_Claim" value="No" checked="" onchange="getPartyClaimSoleSeparate(this, '2', 'Op');"> No</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6" id="Op_RetAcct2_SoleSeparate_Party_Div" style="display: none;">
                                    <label>Who claims to own this account?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Op_RetAcct2_SoleSeparate_Party_Client" name="Op_RetAcct2_SoleSeparate_Party" value="{{$client_name}}"> {{$client_name}}</label>
                                        <label><input type="radio" id="Op_RetAcct2_SoleSeparate_Party_Op" name="Op_RetAcct2_SoleSeparate_Party" value="{{$opponent_name}}"> {{$opponent_name}}</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6" id="Op_RetAcct2_SoleSeparate_Grounds_Div" style="display: none;">
                                    <label for="Op_RetAcct2_SoleSeparate_Grounds">Why does this person own this account solely and separately?</label>
                                    <input id="Op_RetAcct2_SoleSeparate_Grounds" type="text" class="form-control 2_Op_retirementaccts_inputs" name="Op_RetAcct2_SoleSeparate_Grounds" value=""> 
                                </div>
                                <!-- <div class="form-group col-sm-6">
                                    <label>What type of distribution will this be?</label>
                                    <div class="w-100 dataInput">
                                        <label><input type="radio" id="Op_RetAcct2_Disposition_Type_Distribute Investments" name="Op_RetAcct2_Disposition_Type" value="Distribute Investments"> Distribute Investments</label>
                                        <label><input type="radio" id="Op_RetAcct2_Disposition_Type_Liquidate/Split Net Value" name="Op_RetAcct2_Disposition_Type" value="Liquidate/Split Net Value"> Liquidate/Split Net Value</label>
                                        <label><input type="radio" id="Op_RetAcct2_Disposition_Type_QDRO" name="Op_RetAcct2_Disposition_Type" value="QDRO"> QDRO</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>How will this account value be distributed between the parties?</label>
                                    <div class="w-100 dataInput">
                                        <label><input type="radio" id="Op_RetAcct2_Disposition_Method_Percentage_Buyout" name="Op_RetAcct2_Disposition_Method" value="Percentage Buyout" onchange="getDipositionMethod(this, '2', 'Op');"> Percentage Buyout</label>
                                        <label><input type="radio" id="Op_RetAcct2_Disposition_Method_Fixed_Buyout" name="Op_RetAcct2_Disposition_Method" value="Fixed Buyout" onchange="getDipositionMethod(this, '2', 'Op');"> Fixed Buyout</label>
                                    </div>
                                </div> -->
                                <div class="form-group col-sm-6">
                                    <label>Distribute By</label>
                                    <div class="w-100 dataInput">
                                        <label><input type="radio" id="Op_RetAcct2_Disposition_Type_QDRO_Fixed" name="Op_RetAcct2_Disposition_Type_QDRO" value="QDRO_Fixed" onchange="getDistributionMethod(this, '2', 'Op');"> QDRO (Fixed amount to {{$client_name}})</label>
                                        <label><input type="radio" id="Op_RetAcct2_Disposition_Type_Fixed_Buyout" name="Op_RetAcct2_Disposition_Type_QDRO" value="Fixed_Buyout" onchange="getDistributionMethod(this, '2', 'Op');"> Buyout – Don’t distribute</label>
                                        <label><input type="radio" id="Op_RetAcct2_Disposition_Type_QDRO_Percentage" name="Op_RetAcct2_Disposition_Type_QDRO" value="QDRO_Percentage" onchange="getDistributionMethod(this, '2', 'Op');"> QDRO (Percent amount to {{$client_name}})</label>
                                    </div>                           
                                </div>
                                <div class="form-group col-sm-6 Op_RetAcct2_Disposition_Type_QDRO_Amount_Div" style="display: none;">
                                    <label for="Op_RetAcct2_Disposition_Type_QDRO_Amount">Enter Fixed Amount to {{$client_name}}</label>
                                    <input id="Op_RetAcct2_Disposition_Type_QDRO_Amount" type="number" class="form-control 2_Op_retirementaccts_inputs" name="Op_RetAcct2_Disposition_Type_QDRO_Amount" value="0.00" min="0.00" step="0.01" max="999999.99" onchange="getQDROFixedAmount(this, '2', 'Op');" onkeyup="getQDROFixedAmount(this, '2', 'Op');">
                                </div>
                                <div class="form-group col-sm-6 Op_RetAcct2_Disposition_Type_QDRO_Percentage_Amount_Div" style="display: none;">
                                    <label for="Op_RetAcct2_Disposition_Type_QDRO_Percentage_Amount">Enter Fixed Percenrage Amount to {{$client_name}}</label>
                                    <input id="Op_RetAcct2_Disposition_Type_QDRO_Percentage_Amount" type="number" class="form-control 2_Op_retirementaccts_inputs" name="Op_RetAcct2_Disposition_Type_QDRO_Percentage_Amount" value="0.00" min="0.00" step="0.01" max="100" onchange="getQDROFixedPercentageAmount(this, '2', 'Op');" onkeyup="getQDROFixedPercentageAmount(this, '2', 'Op');">
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
                                                    $0.00
                                                </div>
                                                <div class="client-info 2_Op_EPclientamount_div EPclientamount_div" style="clear: both;"><span>$0.00</span>
                                                    <input type="number" id="Op_RetAcct2_Estimated_EP_to_Client" name="Op_RetAcct2_Estimated_EP_to_Client" value="0.00" readonly="" style="display: none;">
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
                                                    $0.00
                                                </div>
                                                <div class="client-info 2_Op_EPopponentamount_div EPopponentamount_div" style="clear: both;"><span>$0.00</span>
                                                    <input type="number" id="Op_RetAcct2_Estimated_EP_to_Op" name="Op_RetAcct2_Estimated_EP_to_Op" value="0.00" readonly="" style="display: none;">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 m-auto 2_Op_Slider_Tool slider-tool-main">
                                    <label><strong>{{$opponent_name}} Retirement Acct#-<span class="2_Op_RetAcct_Number_Span"></span> Equalization Payment</strong></label>
                                    <div class="w-100">
                                        <label><input type="radio" id="2_Op_RetAcct_Estimated_Value_Select" name="2_Op_RetAcct_Estimated_Value_Select_Reset" class="RetAcct_Estimated_Value_Select_Reset" value="Save"> Save this Distribution of Retirement Acct#-<span class="2_Op_RetAcct_Number_Span">2</span></label>
                                        <label><input type="radio" id="2_Op_RetAcct_Estimated_Value_Reset" name="2_Op_RetAcct_Estimated_Value_Select_Reset" class="RetAcct_Estimated_Value_Select_Reset" value="Reset" onclick="resetBalanceInput(this, '2', 'Op');"> Reset to Default (50%)</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 Op_RetAcct_Paying_Party2_Inputs_Div" style="display: none;">
                                    <label>{{$client_name}} Retirement Accts Equity Percent</label>
                                    <input id="Op_RetAcct2_Percent_Marital_Equity_to_Client" type="number" class="form-control 2_Op_clientpercentage_input clientpercentage_input" name="Op_RetAcct2_Percent_Marital_Equity_to_Client" value="50.00" min="0.00" step="0.01" max="100" readonly="">
                                </div>
                                <div class="form-group col-sm-6 Op_RetAcct_Paying_Party2_Inputs_Div" style="display: none;">
                                    <label>N/A, calculated = Op_RetAcct2_Estimated_MaritalEquity – Op_RetAcct2_Estimated_Value_to_Op</label>
                                    <input id="Op_RetAcct2_Estimated_Value_to_Client" type="number" class="form-control 2_Op_clientamount_input clientamount_input" name="Op_RetAcct2_Estimated_Value_to_Client" value="" min="0.00" step="0.01" max="999999.99" readonly="">
                                </div>
                                <div class="form-group col-sm-6 Op_RetAcct_Paying_Party2_Inputs_Div" style="display: none;">
                                    <label>{{$opponent_name}} Retirement Accts Equity Percent</label>
                                    <input id="Op_RetAcct2_Percent_Marital_Equity_to_Op" type="number" class="form-control 2_Op_opponentpercentage_input opponentpercentage_input" name="Op_RetAcct2_Percent_Marital_Equity_to_Op" value="50.00" min="0.00" step="0.01" max="100" readonly="">
                                </div>
                                <div class="form-group col-sm-6 Op_RetAcct2_Disposition_Method_Fixed_Div Op_RetAcct_Paying_Party2_Inputs_Div" style="display: none;">
                                    <label>How much is to be paid to {{$opponent_name}}?</label>
                                    <input id="Op_RetAcct2_Estimated_Value_to_Op" type="number" class="form-control 2_Op_opponentamount_input opponentamount_input" name="Op_RetAcct2_Estimated_Value_to_Op" value="" min="0.00" step="0.01" max="999999.99" readonly="" onchange="getEstimatedValueOp(this, '2', 'Op');" onkeyup="getEstimatedValueOp(this, '2', 'Op');">
                                </div>
                                <!-- end of slider tool -->
                            </div>
                            <div class="col-sm-12 mt-4 3_Op_retirementaccts_section" style="display: none;"><h5 class="col-sm-12">Third Retirement Acct Info</h5>
                                <div class="form-group col-sm-6">
                                    <p class="text-danger 3_Op_no-state-county-found" style="display: none;">No City, State, County found for this zipcode.</p>
                                    <label for="Op_RetAcct3_Institution_ZIP">Retirement Account Institution Zip Code?</label>
                                    <input id="Op_RetAcct3_Institution_ZIP" type="text" class="form-control 3_Op_retirementaccts_inputs" name="Op_RetAcct3_Institution_ZIP" value="" onkeyup="getCityStateForZip(this, '3', 'Op');"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_RetAcct3_Institution_Name">Name of Retirement Account Institution?</label>
                                    <input id="Op_RetAcct3_Institution_Name" type="text" class="form-control 3_Op_retirementaccts_inputs" name="Op_RetAcct3_Institution_Name" value=""> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_RetAcct3_Institution_Street_Address">Retirement Account Institution Street Address?</label>
                                    <input id="Op_RetAcct3_Institution_Street_Address" type="text" class="form-control 3_Op_retirementaccts_inputs" name="Op_RetAcct3_Institution_Street_Address" value=""> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_RetAcct3_Institution_City">Retirement Account Institution City?</label>
                                    <select id="Op_RetAcct3_Institution_City" name="Op_RetAcct3_Institution_City" class="form-control 3_Op_city_select">
                                        <option value="">Choose City</option>
                                    </select>   
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_RetAcct3_Institution_State">Retirement Account Institution State?</label>
                                    <select id="Op_RetAcct3_Institution_State" name="Op_RetAcct3_Institution_State" class="form-control 3_Op_state_select">
                                        <option value="">Choose State</option>
                                    </select>   
                                </div>                                
                                <div class="form-group col-sm-6">
                                    <label for="Op_RetAcct3_Institution_Acct_Num">Account Number?</label>
                                    <input id="Op_RetAcct3_Institution_Acct_Num" type="text" class="form-control 3_Op_retirementaccts_inputs" name="Op_RetAcct3_Institution_Acct_Num" value="" onchange="getAcctNum(this, '3', 'Op');" onkeyup="getAcctNum(this, '3', 'Op');"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_RetAcct3_Date_of_Marriage_Balance">Balance on marriage date (0.00, if started after marriage)?</label>
                                    <input id="Op_RetAcct3_Date_of_Marriage_Balance" type="number" class="form-control 3_Op_retirementaccts_inputs" name="Op_RetAcct3_Date_of_Marriage_Balance" value="0.00" min="0.00" step="0.01" max="999999.99" onchange="getMarriageBalance(this, '3', 'Op');" onkeyup="getMarriageBalance(this, '3', 'Op');"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_RetAcct3_Current_Balance">Current Balance?</label>
                                    <input id="Op_RetAcct3_Current_Balance" type="number" class="form-control 3_Op_retirementaccts_inputs" name="Op_RetAcct3_Current_Balance" value="0.00" min="0.00" step="0.01" max="999999.99" onchange="getCurrentBalance(this, '3', 'Op');" onkeyup="getCurrentBalance(this, '3', 'Op');"> 
                                </div>                                
                                <div class="form-group col-sm-6">
                                    <label for="Op_RetAcct3_Estimated_MaritalEquity1">Marital Equity</label>
                                    <input id="Op_RetAcct3_Estimated_MaritalEquity1" type="number" class="form-control 3_Op_retirementaccts_inputs" name="Op_RetAcct3_Estimated_MaritalEquity1" value="0.00" min="0.00" step="0.01" max="999999.99" readonly=""> 
                                </div>                                
                                <div class="form-group col-sm-6">
                                    <label for="Op_RetAcct3_Current_Yearly_Income">Amount of Yearly Interest?</label>
                                    <input id="Op_RetAcct3_Current_Yearly_Income" type="number" class="form-control 3_Op_retirementaccts_inputs" name="Op_RetAcct3_Current_Yearly_Income" value="0.00" min="0.00" step="0.01" max="999999.99"> 
                                </div>

                                <div class="form-group col-sm-6">
                                    <label>Does either party claim a sole/separate interest from the other on this account?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Op_RetAcct3_SoleSeparate_Claim_Yes" name="Op_RetAcct3_SoleSeparate_Claim" value="Yes" onchange="getPartyClaimSoleSeparate(this, '3', 'Op');"> Yes</label>
                                        <label><input type="radio" id="Op_RetAcct3_SoleSeparate_Claim_No" name="Op_RetAcct3_SoleSeparate_Claim" value="No" checked="" onchange="getPartyClaimSoleSeparate(this, '3', 'Op');"> No</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6" id="Op_RetAcct3_SoleSeparate_Party_Div" style="display: none;">
                                    <label>Who claims to own this account?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Op_RetAcct3_SoleSeparate_Party_Client" name="Op_RetAcct3_SoleSeparate_Party" value="{{$client_name}}"> {{$client_name}}</label>
                                        <label><input type="radio" id="Op_RetAcct3_SoleSeparate_Party_Op" name="Op_RetAcct3_SoleSeparate_Party" value="{{$opponent_name}}"> {{$opponent_name}}</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6" id="Op_RetAcct3_SoleSeparate_Grounds_Div" style="display: none;">
                                    <label for="Op_RetAcct3_SoleSeparate_Grounds">Why does this person own this account solely and separately?</label>
                                    <input id="Op_RetAcct3_SoleSeparate_Grounds" type="text" class="form-control 3_Op_retirementaccts_inputs" name="Op_RetAcct3_SoleSeparate_Grounds" value=""> 
                                </div>
                                <!-- <div class="form-group col-sm-6">
                                    <label>What type of distribution will this be?</label>
                                    <div class="w-100 dataInput">
                                        <label><input type="radio" id="Op_RetAcct3_Disposition_Type_Distribute Investments" name="Op_RetAcct3_Disposition_Type" value="Distribute Investments"> Distribute Investments</label>
                                        <label><input type="radio" id="Op_RetAcct3_Disposition_Type_Liquidate/Split Net Value" name="Op_RetAcct3_Disposition_Type" value="Liquidate/Split Net Value"> Liquidate/Split Net Value</label>
                                        <label><input type="radio" id="Op_RetAcct3_Disposition_Type_QDRO" name="Op_RetAcct3_Disposition_Type" value="QDRO"> QDRO</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>How will this account value be distributed between the parties?</label>
                                    <div class="w-100 dataInput">
                                        <label><input type="radio" id="Op_RetAcct3_Disposition_Method_Percentage_Buyout" name="Op_RetAcct3_Disposition_Method" value="Percentage Buyout" onchange="getDipositionMethod(this, '3', 'Op');"> Percentage Buyout</label>
                                        <label><input type="radio" id="Op_RetAcct3_Disposition_Method_Fixed_Buyout" name="Op_RetAcct3_Disposition_Method" value="Fixed Buyout" onchange="getDipositionMethod(this, '3', 'Op');"> Fixed Buyout</label>
                                    </div>
                                </div> -->
                                <div class="form-group col-sm-6">
                                    <label>Distribute By</label>
                                    <div class="w-100 dataInput">
                                        <label><input type="radio" id="Op_RetAcct3_Disposition_Type_QDRO_Fixed" name="Op_RetAcct3_Disposition_Type_QDRO" value="QDRO_Fixed" onchange="getDistributionMethod(this, '3', 'Op');"> QDRO (Fixed amount to {{$client_name}})</label>
                                        <label><input type="radio" id="Op_RetAcct3_Disposition_Type_Fixed_Buyout" name="Op_RetAcct3_Disposition_Type_QDRO" value="Fixed_Buyout" onchange="getDistributionMethod(this, '3', 'Op');"> Buyout – Don’t distribute</label>
                                        <label><input type="radio" id="Op_RetAcct3_Disposition_Type_QDRO_Percentage" name="Op_RetAcct3_Disposition_Type_QDRO" value="QDRO_Percentage" onchange="getDistributionMethod(this, '3', 'Op');"> QDRO (Percent amount to {{$client_name}})</label>
                                    </div>                           
                                </div>
                                <div class="form-group col-sm-6 Op_RetAcct3_Disposition_Type_QDRO_Amount_Div" style="display: none;">
                                    <label for="Op_RetAcct3_Disposition_Type_QDRO_Amount">Enter Fixed Amount to {{$client_name}}</label>
                                    <input id="Op_RetAcct3_Disposition_Type_QDRO_Amount" type="number" class="form-control 3_Op_retirementaccts_inputs" name="Op_RetAcct3_Disposition_Type_QDRO_Amount" value="0.00" min="0.00" step="0.01" max="999999.99" onchange="getQDROFixedAmount(this, '3', 'Op');" onkeyup="getQDROFixedAmount(this, '3', 'Op');">
                                </div>
                                <div class="form-group col-sm-6 Op_RetAcct3_Disposition_Type_QDRO_Percentage_Amount_Div" style="display: none;">
                                    <label for="Op_RetAcct3_Disposition_Type_QDRO_Percentage_Amount">Enter Fixed Percenrage Amount to {{$client_name}}</label>
                                    <input id="Op_RetAcct3_Disposition_Type_QDRO_Percentage_Amount" type="number" class="form-control 3_Op_retirementaccts_inputs" name="Op_RetAcct3_Disposition_Type_QDRO_Percentage_Amount" value="0.00" min="0.00" step="0.01" max="100" onchange="getQDROFixedPercentageAmount(this, '3', 'Op');" onkeyup="getQDROFixedPercentageAmount(this, '3', 'Op');">
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
                                                    $0.00
                                                </div>
                                                <div class="client-info 3_Op_EPclientamount_div EPclientamount_div" style="clear: both;"><span>$0.00</span>
                                                    <input type="number" id="Op_RetAcct3_Estimated_EP_to_Client" name="Op_RetAcct3_Estimated_EP_to_Client" value="0.00" readonly="" style="display: none;">
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
                                                    $0.00
                                                </div>
                                                <div class="client-info 3_Op_EPopponentamount_div EPopponentamount_div" style="clear: both;"><span>$0.00</span>
                                                    <input type="number" id="Op_RetAcct3_Estimated_EP_to_Op" name="Op_RetAcct3_Estimated_EP_to_Op" value="0.00" readonly="" style="display: none;">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 m-auto 3_Op_Slider_Tool slider-tool-main">
                                    <label><strong>{{$opponent_name}} Retirement Acct#-<span class="3_Op_RetAcct_Number_Span"></span> Equalization Payment</strong></label>
                                    <div class="w-100">
                                        <label><input type="radio" id="3_Op_RetAcct_Estimated_Value_Select" name="3_Op_RetAcct_Estimated_Value_Select_Reset" class="RetAcct_Estimated_Value_Select_Reset" value="Save"> Save this Distribution of Retirement Acct#-<span class="3_Op_RetAcct_Number_Span">3</span></label>
                                        <label><input type="radio" id="3_Op_RetAcct_Estimated_Value_Reset" name="3_Op_RetAcct_Estimated_Value_Select_Reset" class="RetAcct_Estimated_Value_Select_Reset" value="Reset" onclick="resetBalanceInput(this, '3', 'Op');"> Reset to Default (50%)</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 Op_RetAcct_Paying_Party3_Inputs_Div" style="display: none;">
                                    <label>{{$client_name}} Retirement Accts Equity Percent</label>
                                    <input id="Op_RetAcct3_Percent_Marital_Equity_to_Client" type="number" class="form-control 3_Op_clientpercentage_input clientpercentage_input" name="Op_RetAcct3_Percent_Marital_Equity_to_Client" value="50.00" min="0.00" step="0.01" max="100" readonly="">
                                </div>
                                <div class="form-group col-sm-6 Op_RetAcct_Paying_Party3_Inputs_Div" style="display: none;">
                                    <label>N/A, calculated = Op_RetAcct3_Estimated_MaritalEquity – Op_RetAcct3_Estimated_Value_to_Op</label>
                                    <input id="Op_RetAcct3_Estimated_Value_to_Client" type="number" class="form-control 3_Op_clientamount_input clientamount_input" name="Op_RetAcct3_Estimated_Value_to_Client" value="" min="0.00" step="0.01" max="999999.99" readonly="">
                                </div>
                                <div class="form-group col-sm-6 Op_RetAcct_Paying_Party3_Inputs_Div" style="display: none;">
                                    <label>{{$opponent_name}} Retirement Accts Equity Percent</label>
                                    <input id="Op_RetAcct3_Percent_Marital_Equity_to_Op" type="number" class="form-control 3_Op_opponentpercentage_input opponentpercentage_input" name="Op_RetAcct3_Percent_Marital_Equity_to_Op" value="50.00" min="0.00" step="0.01" max="100" readonly="">
                                </div>
                                <div class="form-group col-sm-6 Op_RetAcct3_Disposition_Method_Fixed_Div Op_RetAcct_Paying_Party3_Inputs_Div" style="display: none;">
                                    <label>How much is to be paid to {{$opponent_name}}?</label>
                                    <input id="Op_RetAcct3_Estimated_Value_to_Op" type="number" class="form-control 3_Op_opponentamount_input opponentamount_input" name="Op_RetAcct3_Estimated_Value_to_Op" value="" min="0.00" step="0.01" max="999999.99" readonly="" onchange="getEstimatedValueOp(this, '3', 'Op');" onkeyup="getEstimatedValueOp(this, '3', 'Op');">
                                </div>
                                <!-- end of slider tool -->
                            </div>
                            <div class="col-sm-12 mt-4 4_Op_retirementaccts_section" style="display: none;"><h5 class="col-sm-12">Fourth Retirement Acct Info</h5>
                                <div class="form-group col-sm-6">
                                    <p class="text-danger 4_Op_no-state-county-found" style="display: none;">No City, State, County found for this zipcode.</p>
                                    <label for="Op_RetAcct4_Institution_ZIP">Retirement Account Institution Zip Code?</label>
                                    <input id="Op_RetAcct4_Institution_ZIP" type="text" class="form-control 4_Op_retirementaccts_inputs" name="Op_RetAcct4_Institution_ZIP" value="" onkeyup="getCityStateForZip(this, '4', 'Op');"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_RetAcct4_Institution_Name">Name of Retirement Account Institution?</label>
                                    <input id="Op_RetAcct4_Institution_Name" type="text" class="form-control 4_Op_retirementaccts_inputs" name="Op_RetAcct4_Institution_Name" value=""> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_RetAcct4_Institution_Street_Address">Retirement Account Institution Street Address?</label>
                                    <input id="Op_RetAcct4_Institution_Street_Address" type="text" class="form-control 4_Op_retirementaccts_inputs" name="Op_RetAcct4_Institution_Street_Address" value=""> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_RetAcct4_Institution_City">Retirement Account Institution City?</label>
                                    <select id="Op_RetAcct4_Institution_City" name="Op_RetAcct4_Institution_City" class="form-control 4_Op_city_select">
                                        <option value="">Choose City</option>
                                    </select>   
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_RetAcct4_Institution_State">Retirement Account Institution State?</label>
                                    <select id="Op_RetAcct4_Institution_State" name="Op_RetAcct4_Institution_State" class="form-control 4_Op_state_select">
                                        <option value="">Choose State</option>
                                    </select>   
                                </div>                                
                                <div class="form-group col-sm-6">
                                    <label for="Op_RetAcct4_Institution_Acct_Num">Account Number?</label>
                                    <input id="Op_RetAcct4_Institution_Acct_Num" type="text" class="form-control 4_Op_retirementaccts_inputs" name="Op_RetAcct4_Institution_Acct_Num" value="" onchange="getAcctNum(this, '4', 'Op');" onkeyup="getAcctNum(this, '4', 'Op');"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_RetAcct4_Date_of_Marriage_Balance">Balance on marriage date (0.00, if started after marriage)?</label>
                                    <input id="Op_RetAcct4_Date_of_Marriage_Balance" type="number" class="form-control 4_Op_retirementaccts_inputs" name="Op_RetAcct4_Date_of_Marriage_Balance" value="0.00" min="0.00" step="0.01" max="999999.99" onchange="getMarriageBalance(this, '4', 'Op');" onkeyup="getMarriageBalance(this, '4', 'Op');"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_RetAcct4_Current_Balance">Current Balance?</label>
                                    <input id="Op_RetAcct4_Current_Balance" type="number" class="form-control 4_Op_retirementaccts_inputs" name="Op_RetAcct4_Current_Balance" value="0.00" min="0.00" step="0.01" max="999999.99" onchange="getCurrentBalance(this, '4', 'Op');" onkeyup="getCurrentBalance(this, '4', 'Op');"> 
                                </div>                                
                                <div class="form-group col-sm-6">
                                    <label for="Op_RetAcct4_Estimated_MaritalEquity1">Marital Equity</label>
                                    <input id="Op_RetAcct4_Estimated_MaritalEquity1" type="number" class="form-control 4_Op_retirementaccts_inputs" name="Op_RetAcct4_Estimated_MaritalEquity1" value="0.00" min="0.00" step="0.01" max="999999.99" readonly=""> 
                                </div>                                
                                <div class="form-group col-sm-6">
                                    <label for="Op_RetAcct4_Current_Yearly_Income">Amount of Yearly Interest?</label>
                                    <input id="Op_RetAcct4_Current_Yearly_Income" type="number" class="form-control 4_Op_retirementaccts_inputs" name="Op_RetAcct4_Current_Yearly_Income" value="0.00" min="0.00" step="0.01" max="999999.99"> 
                                </div>

                                <div class="form-group col-sm-6">
                                    <label>Does either party claim a sole/separate interest from the other on this account?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Op_RetAcct4_SoleSeparate_Claim_Yes" name="Op_RetAcct4_SoleSeparate_Claim" value="Yes" onchange="getPartyClaimSoleSeparate(this, '4', 'Op');"> Yes</label>
                                        <label><input type="radio" id="Op_RetAcct4_SoleSeparate_Claim_No" name="Op_RetAcct4_SoleSeparate_Claim" value="No" checked="" onchange="getPartyClaimSoleSeparate(this, '4', 'Op');"> No</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6" id="Op_RetAcct4_SoleSeparate_Party_Div" style="display: none;">
                                    <label>Who claims to own this account?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Op_RetAcct4_SoleSeparate_Party_Client" name="Op_RetAcct4_SoleSeparate_Party" value="{{$client_name}}"> {{$client_name}}</label>
                                        <label><input type="radio" id="Op_RetAcct4_SoleSeparate_Party_Op" name="Op_RetAcct4_SoleSeparate_Party" value="{{$opponent_name}}"> {{$opponent_name}}</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6" id="Op_RetAcct4_SoleSeparate_Grounds_Div" style="display: none;">
                                    <label for="Op_RetAcct4_SoleSeparate_Grounds">Why does this person own this account solely and separately?</label>
                                    <input id="Op_RetAcct4_SoleSeparate_Grounds" type="text" class="form-control 4_Op_retirementaccts_inputs" name="Op_RetAcct4_SoleSeparate_Grounds" value=""> 
                                </div>
                                <!-- <div class="form-group col-sm-6">
                                    <label>What type of distribution will this be?</label>
                                    <div class="w-100 dataInput">
                                        <label><input type="radio" id="Op_RetAcct4_Disposition_Type_Distribute Investments" name="Op_RetAcct4_Disposition_Type" value="Distribute Investments"> Distribute Investments</label>
                                        <label><input type="radio" id="Op_RetAcct4_Disposition_Type_Liquidate/Split Net Value" name="Op_RetAcct4_Disposition_Type" value="Liquidate/Split Net Value"> Liquidate/Split Net Value</label>
                                        <label><input type="radio" id="Op_RetAcct4_Disposition_Type_QDRO" name="Op_RetAcct4_Disposition_Type" value="QDRO"> QDRO</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>How will this account value be distributed between the parties?</label>
                                    <div class="w-100 dataInput">
                                        <label><input type="radio" id="Op_RetAcct4_Disposition_Method_Percentage_Buyout" name="Op_RetAcct4_Disposition_Method" value="Percentage Buyout" onchange="getDipositionMethod(this, '4', 'Op');"> Percentage Buyout</label>
                                        <label><input type="radio" id="Op_RetAcct4_Disposition_Method_Fixed_Buyout" name="Op_RetAcct4_Disposition_Method" value="Fixed Buyout" onchange="getDipositionMethod(this, '4', 'Op');"> Fixed Buyout</label>
                                    </div>
                                </div> -->
                                <div class="form-group col-sm-6">
                                    <label>Distribute By</label>
                                    <div class="w-100 dataInput">
                                        <label><input type="radio" id="Op_RetAcct4_Disposition_Type_QDRO_Fixed" name="Op_RetAcct4_Disposition_Type_QDRO" value="QDRO_Fixed" onchange="getDistributionMethod(this, '4', 'Op');"> QDRO (Fixed amount to {{$client_name}})</label>
                                        <label><input type="radio" id="Op_RetAcct4_Disposition_Type_Fixed_Buyout" name="Op_RetAcct4_Disposition_Type_QDRO" value="Fixed_Buyout" onchange="getDistributionMethod(this, '4', 'Op');"> Buyout – Don’t distribute</label>
                                        <label><input type="radio" id="Op_RetAcct4_Disposition_Type_QDRO_Percentage" name="Op_RetAcct4_Disposition_Type_QDRO" value="QDRO_Percentage" onchange="getDistributionMethod(this, '4', 'Op');"> QDRO (Percent amount to {{$client_name}})</label>
                                    </div>                           
                                </div>
                                <div class="form-group col-sm-6 Op_RetAcct4_Disposition_Type_QDRO_Amount_Div" style="display: none;">
                                    <label for="Op_RetAcct4_Disposition_Type_QDRO_Amount">Enter Fixed Amount to {{$client_name}}</label>
                                    <input id="Op_RetAcct4_Disposition_Type_QDRO_Amount" type="number" class="form-control 4_Op_retirementaccts_inputs" name="Op_RetAcct4_Disposition_Type_QDRO_Amount" value="0.00" min="0.00" step="0.01" max="999999.99" onchange="getQDROFixedAmount(this, '4', 'Op');" onkeyup="getQDROFixedAmount(this, '4', 'Op');">
                                </div>
                                <div class="form-group col-sm-6 Op_RetAcct4_Disposition_Type_QDRO_Percentage_Amount_Div" style="display: none;">
                                    <label for="Op_RetAcct4_Disposition_Type_QDRO_Percentage_Amount">Enter Fixed Percenrage Amount to {{$client_name}}</label>
                                    <input id="Op_RetAcct4_Disposition_Type_QDRO_Percentage_Amount" type="number" class="form-control 4_Op_retirementaccts_inputs" name="Op_RetAcct4_Disposition_Type_QDRO_Percentage_Amount" value="0.00" min="0.00" step="0.01" max="100" onchange="getQDROFixedPercentageAmount(this, '4', 'Op');" onkeyup="getQDROFixedPercentageAmount(this, '4', 'Op');">
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
                                                    $0.00
                                                </div>
                                                <div class="client-info 4_Op_EPclientamount_div EPclientamount_div" style="clear: both;"><span>$0.00</span>
                                                    <input type="number" id="Op_RetAcct4_Estimated_EP_to_Client" name="Op_RetAcct4_Estimated_EP_to_Client" value="0.00" readonly="" style="display: none;">
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
                                                    $0.00
                                                </div>
                                                <div class="client-info 4_Op_EPopponentamount_div EPopponentamount_div" style="clear: both;"><span>$0.00</span>
                                                    <input type="number" id="Op_RetAcct4_Estimated_EP_to_Op" name="Op_RetAcct4_Estimated_EP_to_Op" value="0.00" readonly="" style="display: none;">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 m-auto 4_Op_Slider_Tool slider-tool-main">
                                    <label><strong>{{$opponent_name}} Retirement Acct#-<span class="4_Op_RetAcct_Number_Span"></span> Equalization Payment</strong></label>
                                    <div class="w-100">
                                        <label><input type="radio" id="4_Op_RetAcct_Estimated_Value_Select" name="4_Op_RetAcct_Estimated_Value_Select_Reset" class="RetAcct_Estimated_Value_Select_Reset" value="Save"> Save this Distribution of Retirement Acct#-<span class="4_Op_RetAcct_Number_Span">4</span></label>
                                        <label><input type="radio" id="4_Op_RetAcct_Estimated_Value_Reset" name="4_Op_RetAcct_Estimated_Value_Select_Reset" class="RetAcct_Estimated_Value_Select_Reset" value="Reset" onclick="resetBalanceInput(this, '4', 'Op');"> Reset to Default (50%)</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 Op_RetAcct_Paying_Party4_Inputs_Div" style="display: none;">
                                    <label>{{$client_name}} Retirement Accts Equity Percent</label>
                                    <input id="Op_RetAcct4_Percent_Marital_Equity_to_Client" type="number" class="form-control 4_Op_clientpercentage_input clientpercentage_input" name="Op_RetAcct4_Percent_Marital_Equity_to_Client" value="50.00" min="0.00" step="0.01" max="100" readonly="">
                                </div>
                                <div class="form-group col-sm-6 Op_RetAcct_Paying_Party4_Inputs_Div" style="display: none;">
                                    <label>N/A, calculated = Op_RetAcct4_Estimated_MaritalEquity – Op_RetAcct4_Estimated_Value_to_Op</label>
                                    <input id="Op_RetAcct4_Estimated_Value_to_Client" type="number" class="form-control 4_Op_clientamount_input clientamount_input" name="Op_RetAcct4_Estimated_Value_to_Client" value="" min="0.00" step="0.01" max="999999.99" readonly="">
                                </div>
                                <div class="form-group col-sm-6 Op_RetAcct_Paying_Party4_Inputs_Div" style="display: none;">
                                    <label>{{$opponent_name}} Retirement Accts Equity Percent</label>
                                    <input id="Op_RetAcct4_Percent_Marital_Equity_to_Op" type="number" class="form-control 4_Op_opponentpercentage_input opponentpercentage_input" name="Op_RetAcct4_Percent_Marital_Equity_to_Op" value="50.00" min="0.00" step="0.01" max="100" readonly="">
                                </div>
                                <div class="form-group col-sm-6 Op_RetAcct4_Disposition_Method_Fixed_Div Op_RetAcct_Paying_Party4_Inputs_Div" style="display: none;">
                                    <label>How much is to be paid to {{$opponent_name}}?</label>
                                    <input id="Op_RetAcct4_Estimated_Value_to_Op" type="number" class="form-control 4_Op_opponentamount_input opponentamount_input" name="Op_RetAcct4_Estimated_Value_to_Op" value="" min="0.00" step="0.01" max="999999.99" readonly="" onchange="getEstimatedValueOp(this, '4', 'Op');" onkeyup="getEstimatedValueOp(this, '4', 'Op');">
                                </div>
                                <!-- end of slider tool -->
                            </div>
                        </div>
                        <!-- End of Opponent Retirement Accts Info Section -->
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

    function getAnyRetirementAccts(retacc){
        if(retacc.checked){
            $('#Num_Client_Retirement_Accts, #Num_Op_Retirement_Accts').val('0');
            $('.num_Client_Retirement_Accts_info, .num_Op_Retirement_Accts_info').show();
        } else {
            $('.num_Client_Retirement_Accts_info, .num_Op_Retirement_Accts_info').hide();
            $('#Num_Client_Retirement_Accts, #Num_Op_Retirement_Accts').val('0');
            $('.Client_retirementaccts_section input, .Op_retirementaccts_section input').prop('required',false);
            $('.1_Client_retirementaccts_section, .2_Client_retirementaccts_section, .3_Client_retirementaccts_section, .4_Client_retirementaccts_section').hide();
            $('.1_Op_retirementaccts_section, .2_Op_retirementaccts_section, .3_Op_retirementaccts_section, .4_Op_retirementaccts_section').hide();
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
                        
                        $('.'+zipclass+'_no-state-county-found').hide();
                    }
                }
            });        
        }

    }

    function getMarriageBalance(balance, balancenum, balancetype){
        var balanceclass=balancenum+'_'+balancetype;
        $('.'+balanceclass+'_balance_range_selector, .'+balanceclass+'_opponentpercentage_input, .'+balanceclass+'_clientpercentage_input').val('50.00');
        $('.'+balanceclass+'_opponentpercentage_div, .'+balanceclass+'_clientpercentage_div').text('50.00%');
        var marriage_balance=parseFloat(balance.value).toFixed(2);
        var current_balance=$('#'+balancetype+'_RetAcct'+balancenum+'_Current_Balance').val();
        if(current_balance && current_balance > 0){
            current_balance=parseFloat(current_balance).toFixed(2);
            var total_balance=(current_balance)-(marriage_balance);
            total_balance=parseFloat(total_balance).toFixed(2);
            $('#'+balancetype+'_RetAcct'+balancenum+'_Estimated_MaritalEquity1').val(total_balance);
            var client_balance_amount=total_balance/2;
            var opponent_balance_amount=total_balance/2;
            client_balance_amount=parseFloat(client_balance_amount).toFixed(2);
            opponent_balance_amount=parseFloat(opponent_balance_amount).toFixed(2);
            $('.'+balanceclass+'_clientamount_input').val(client_balance_amount);
            $('.'+balanceclass+'_opponentamount_input').val(opponent_balance_amount);
            $('.'+balanceclass+'_clientamount_div').text(formatter.format(client_balance_amount));
            $('.'+balanceclass+'_opponentamount_div').text(formatter.format(opponent_balance_amount));

            // calculation for new fields
            var EP_to_CLient=0-((client_balance_amount-opponent_balance_amount)/2);
            var EP_to_Op=0-(EP_to_CLient);
            EP_to_CLient=parseFloat(EP_to_CLient).toFixed(2);
            EP_to_Op=parseFloat(EP_to_Op).toFixed(2);
            $('#'+balancetype+'_RetAcct'+balancenum+'_Estimated_EP_to_Client').val(EP_to_CLient);
            $('#'+balancetype+'_RetAcct'+balancenum+'_Estimated_EP_to_Op').val(EP_to_Op);
            $('.'+balanceclass+'_EPclientamount_div span').text(formatter.format(EP_to_CLient));
            $('.'+balanceclass+'_EPopponentamount_div span').text(formatter.format(EP_to_Op));
        }
    }
    function getCurrentBalance(balance, balancenum, balancetype){
        var balanceclass=balancenum+'_'+balancetype;
        $('.'+balanceclass+'_balance_range_selector, .'+balanceclass+'_opponentpercentage_input, .'+balanceclass+'_clientpercentage_input').val('50.00');
        $('.'+balanceclass+'_opponentpercentage_div, .'+balanceclass+'_clientpercentage_div').text('50.00%');
        if(balance.value){
            current_balance=parseFloat(balance.value).toFixed(2);
        } else {
            current_balance=0.00;
        }
        var marriage_balance=$('#'+balancetype+'_RetAcct'+balancenum+'_Date_of_Marriage_Balance').val();
        if(marriage_balance){
            marriage_balance=parseFloat(marriage_balance).toFixed(2);
        } else {
            marriage_balance=0.00;
        }
        var total_balance=(current_balance)-(marriage_balance);
        total_balance=parseFloat(total_balance).toFixed(2);
        $('#'+balancetype+'_RetAcct'+balancenum+'_Estimated_MaritalEquity1').val(total_balance);
        var client_balance_amount=total_balance/2;
        var opponent_balance_amount=total_balance/2;
        client_balance_amount=parseFloat(client_balance_amount).toFixed(2);
        opponent_balance_amount=parseFloat(opponent_balance_amount).toFixed(2);
        $('.'+balanceclass+'_clientamount_input').val(client_balance_amount);
        $('.'+balanceclass+'_opponentamount_input').val(opponent_balance_amount);
        $('.'+balanceclass+'_clientamount_div').text(formatter.format(client_balance_amount));
        $('.'+balanceclass+'_opponentamount_div').text(formatter.format(opponent_balance_amount));

        // calculation for new fields
        var EP_to_CLient=0-((client_balance_amount-opponent_balance_amount)/2);
        var EP_to_Op=0-(EP_to_CLient);
        EP_to_CLient=parseFloat(EP_to_CLient).toFixed(2);
        EP_to_Op=parseFloat(EP_to_Op).toFixed(2);
        $('#'+balancetype+'_RetAcct'+balancenum+'_Estimated_EP_to_Client').val(EP_to_CLient);
        $('#'+balancetype+'_RetAcct'+balancenum+'_Estimated_EP_to_Op').val(EP_to_Op);
        $('.'+balanceclass+'_EPclientamount_div span').text(formatter.format(EP_to_CLient));
        $('.'+balanceclass+'_EPopponentamount_div span').text(formatter.format(EP_to_Op));
    }

    function getPartyClaimSoleSeparate(claim, claimnum, claimtype){
        if(claim.value=='No'){
            $('#'+claimtype+'_RetAcct'+claimnum+'_SoleSeparate_Party_Div').hide();
            $('#'+claimtype+'_RetAcct'+claimnum+'_SoleSeparate_Grounds_Div').hide();
            $('#'+claimtype+'_RetAcct'+claimnum+'_SoleSeparate_Grounds').val('');
            $('#'+claimtype+'_RetAcct'+claimnum+'_SoleSeparate_Party').prop('checked', false);
            $('.'+claimnum+'_'+claimtype+'_Slider_Tool').show();
        } else {
            $('#'+claimtype+'_RetAcct'+claimnum+'_SoleSeparate_Party_Div').show();
            $('#'+claimtype+'_RetAcct'+claimnum+'_SoleSeparate_Grounds_Div').show();
            $('.'+claimnum+'_'+claimtype+'_Slider_Tool').hide();
        }
    }

    function getDistributionMethod(claim, claimnum, claimtype){
        $('.'+claimtype+'_RetAcct'+claimnum+'_Disposition_Type_QDRO_Amount_Div').hide();
        $('.'+claimtype+'_RetAcct'+claimnum+'_Disposition_Type_QDRO_Percentage_Amount_Div').hide();
        $('#'+claimtype+'_RetAcct'+claimnum+'_Disposition_Type_QDRO_Amount').val('0.00');
        $('#'+claimtype+'_RetAcct'+claimnum+'_Disposition_Type_QDRO_Percentage_Amount').val('0.00');

        if(claim.checked && claim.value=='QDRO_Fixed'){
            $('.'+claimtype+'_RetAcct'+claimnum+'_Disposition_Type_QDRO_Amount_Div').show();
        }
        if(claim.checked && claim.value=='QDRO_Percentage'){
            $('.'+claimtype+'_RetAcct'+claimnum+'_Disposition_Type_QDRO_Percentage_Amount_Div').show();
        }
        if(claim.checked && claim.value=='Fixed_Buyout'){
            var balanceclass=claimnum+'_'+claimtype;
            if(claimtype=='Client'){
                var percentage_to_op=0;
                $('.'+balanceclass+'_balance_range_selector').val(percentage_to_op).trigger('change');
            }
            if(claimtype=='Op'){
                var percentage_to_client=100;
                var percentage_to_client=parseFloat(percentage_to_client).toFixed(2);
                $('.'+balanceclass+'_balance_range_selector').val(percentage_to_client).trigger('change');
            }
        }

    }

    function getQDROFixedAmount(balance, balancenum, balancetype){
        var balanceclass=balancenum+'_'+balancetype;
        
        var current_balance=$('#'+balancetype+'_RetAcct'+balancenum+'_Current_Balance').val();
        if(current_balance){
        } else {
            current_balance=0.00;
        }
        var marriage_balance=$('#'+balancetype+'_RetAcct'+balancenum+'_Date_of_Marriage_Balance').val();
        if(marriage_balance){
            marriage_balance=parseFloat(marriage_balance).toFixed(2);
        } else {
            marriage_balance=0.00;
        }
        var total_balance=(current_balance)-(marriage_balance);
        total_balance=parseFloat(total_balance).toFixed(2);
        if(parseFloat(total_balance) < parseFloat(balance.value)){
            $(balance).val('0.00');
            alert('Please Enter Amount less than '+total_balance+'');
            // return;
        }
        $('#'+balancetype+'_RetAcct'+balancenum+'_Estimated_MaritalEquity1').val(total_balance);
        var opponent_balance_amount=0.00;
        var client_balance_amount=0.00;
        if(balance.value && balancetype=='Client'){
            opponent_balance_amount=parseFloat(balance.value).toFixed(2);
            client_balance_amount=total_balance-opponent_balance_amount;
        }
        if(balance.value && balancetype=='Op'){
            client_balance_amount=parseFloat(balance.value).toFixed(2);
            opponent_balance_amount=total_balance-client_balance_amount;
        }

        client_balance_amount=parseFloat(client_balance_amount).toFixed(2);
        opponent_balance_amount=parseFloat(opponent_balance_amount).toFixed(2);
        $('.'+balanceclass+'_clientamount_input').val(client_balance_amount);
        $('.'+balanceclass+'_opponentamount_input').val(opponent_balance_amount);
        $('.'+balanceclass+'_clientamount_div').text(formatter.format(client_balance_amount));
        $('.'+balanceclass+'_opponentamount_div').text(formatter.format(opponent_balance_amount));

        var client_percentage_amaount=(client_balance_amount/total_balance)*100;
        client_percentage_amaount=parseFloat(client_percentage_amaount).toFixed(2);
        op_percentage_amaount=parseFloat(100-client_percentage_amaount).toFixed(2);
        $('.'+balanceclass+'_opponentpercentage_input').val(op_percentage_amaount);
        $('.'+balanceclass+'_clientpercentage_input').val(client_percentage_amaount);
        $('.'+balanceclass+'_clientpercentage_div').text(client_percentage_amaount+'%');
        $('.'+balanceclass+'_opponentpercentage_div').text(op_percentage_amaount+'%');
        $('.'+balanceclass+'_balance_range_selector').val(op_percentage_amaount).trigger('change');

        // calculation for new fields
        var EP_to_CLient=0-((client_balance_amount-opponent_balance_amount)/2);
        var EP_to_Op=0-(EP_to_CLient);
        EP_to_CLient=parseFloat(EP_to_CLient).toFixed(2);
        EP_to_Op=parseFloat(EP_to_Op).toFixed(2);
        $('#'+balancetype+'_RetAcct'+balancenum+'_Estimated_EP_to_Client').val(EP_to_CLient);
        $('#'+balancetype+'_RetAcct'+balancenum+'_Estimated_EP_to_Op').val(EP_to_Op);
        $('.'+balanceclass+'_EPclientamount_div span').text(formatter.format(EP_to_CLient));
        $('.'+balanceclass+'_EPopponentamount_div span').text(formatter.format(EP_to_Op));
    }

    function getQDROFixedPercentageAmount(balance, balancenum, balancetype){
        var balanceclass=balancenum+'_'+balancetype;
        if(balance.value && balancetype=='Client'){
            var percentage_to_op=parseFloat(balance.value).toFixed(2);
            $('.'+balanceclass+'_balance_range_selector').val(percentage_to_op).trigger('change');
        }
        if(balance.value && balancetype=='Op'){
            var percentage_to_client=100-balance.value;
            var percentage_to_client=parseFloat(percentage_to_client).toFixed(2);
            $('.'+balanceclass+'_balance_range_selector').val(percentage_to_client).trigger('change');
        }
    }

    function getAcctNum(acct, acctnum, accttype){
        var spanclass=acctnum+'_'+accttype;
        $('.'+spanclass+'_RetAcct_Number_Span').text(acct.value);
    }

    function getDipositionMethod(claim, claimnum, claimtype){
        if(claim.value=='Fixed Buyout'){
            $('.'+claimnum+'_'+claimtype+'_Slider_Tool').hide();
            var current_val=$('#'+claimtype+'_RetAcct'+claimnum+'_Current_Balance').val();
            if(current_val){
                current_val=parseFloat(current_val).toFixed(2);
                var marriage_balance=$('#'+claimtype+'_RetAcct'+claimnum+'_Date_of_Marriage_Balance').val();
                if(marriage_balance){
                    marriage_balance=parseFloat(marriage_balance).toFixed(2);
                } else {
                    marriage_balance=0.00;
                }
                var total_balance=(current_val)-(marriage_balance);
                total_balance=parseFloat(total_balance).toFixed(2);
                $('#'+claimtype+'_RetAcct'+claimnum+'_Estimated_MaritalEquity1').val(total_balance);

                var op_val=(total_balance/2);
                op_val=parseFloat(op_val).toFixed(2);
                var client_val=(total_balance)-(op_val);
                client_val=parseFloat(client_val).toFixed(2);
                $('#'+claimtype+'_RetAcct'+claimnum+'_Estimated_Value_to_Client').val(client_val);
                $('#'+claimtype+'_RetAcct'+claimnum+'_Estimated_Value_to_Op').val(op_val);
                var client_percentage=(client_val/total_balance)*(100).toFixed(2);
                client_percentage=parseFloat(client_percentage).toFixed(2);
                var op_percentage=(100-client_percentage).toFixed(2);
                op_percentage=parseFloat(op_percentage).toFixed(2);
                $('#'+claimtype+'_RetAcct'+claimnum+'_Percent_Marital_Equity_to_Client').val(client_percentage);
                $('#'+claimtype+'_RetAcct'+claimnum+'_Percent_Marital_Equity_to_Op').val(op_percentage);
                $('.'+claimnum+'_'+claimtype+'_clientpercentage_div').text('50.00%');
                $('.'+claimnum+'_'+claimtype+'_opponentpercentage_div').text('50.00%');
                $('.'+claimnum+'_'+claimtype+'_clientamount_div').text(formatter.format(client_val));
                $('.'+claimnum+'_'+claimtype+'_opponentamount_div').text(formatter.format(op_val));

                // calculation for new fields
                var EP_to_CLient=0-((client_val-client_val)/2);
                var EP_to_Op=0-(EP_to_CLient);
                EP_to_CLient=parseFloat(EP_to_CLient).toFixed(2);
                EP_to_Op=parseFloat(EP_to_Op).toFixed(2);
                $('#'+claimtype+'_RetAcct'+claimnum+'_Estimated_EP_to_Client').val(EP_to_CLient);
                $('#'+claimtype+'_RetAcct'+claimnum+'_Estimated_EP_to_Op').val(EP_to_Op);
                $('.'+claimnum+'_'+claimtype+'_EPclientamount_div span').text(formatter.format(EP_to_CLient));
                $('.'+claimnum+'_'+claimtype+'_EPopponentamount_div span').text(formatter.format(EP_to_Op));

            }else {
                $('#'+claimtype+'_RetAcct'+claimnum+'_Estimated_Value_to_Client').val('0.00');
                $('#'+claimtype+'_RetAcct'+claimnum+'_Estimated_Value_to_Op').val('0.00');
                $('#'+claimtype+'_RetAcct'+claimnum+'_Percent_Marital_Equity_to_Client').val('0.00');
                $('#'+claimtype+'_RetAcct'+claimnum+'_Percent_Marital_Equity_to_Op').val('0.00');
                $('.'+claimnum+'_'+claimtype+'_clientpercentage_div').text('50.00%');
                $('.'+claimnum+'_'+claimtype+'_opponentpercentage_div').text('50.00%');
                $('.'+claimnum+'_'+claimtype+'_clientamount_div').text('0.00');
                $('.'+claimnum+'_'+claimtype+'_opponentamount_div').text('0.00');

                // calculation for new fields
                var EP_to_CLient=0;
                var EP_to_Op=0-(EP_to_CLient);
                EP_to_CLient=parseFloat(EP_to_CLient).toFixed(2);
                EP_to_Op=parseFloat(EP_to_Op).toFixed(2);
                $('#'+claimtype+'_RetAcct'+claimnum+'_Estimated_EP_to_Client').val(EP_to_CLient);
                $('#'+claimtype+'_RetAcct'+claimnum+'_Estimated_EP_to_Op').val(EP_to_Op);
                $('.'+claimnum+'_'+claimtype+'_EPclientamount_div span').text(formatter.format(EP_to_CLient));
                $('.'+claimnum+'_'+claimtype+'_EPopponentamount_div span').text(formatter.format(EP_to_Op));

            }
            $('.'+claimtype+'_RetAcct'+claimnum+'_Disposition_Method_Fixed_Div').show();
            $('.'+claimtype+'_RetAcct'+claimnum+'_Disposition_Method_Fixed_Div input[type=number]').prop('readonly', false);

        } else {
            $('.'+claimnum+'_'+claimtype+'_Slider_Tool').show();
            var current_val=$('#'+claimtype+'_RetAcct'+claimnum+'_Current_Balance').val();
            if(current_val){
                current_val=parseFloat(current_val).toFixed(2);
                var marriage_balance=$('#'+claimtype+'_RetAcct'+claimnum+'_Date_of_Marriage_Balance').val();
                if(marriage_balance){
                    marriage_balance=parseFloat(marriage_balance).toFixed(2);
                } else {
                    marriage_balance=0.00;
                }
                var total_balance=(current_val)-(marriage_balance);
                total_balance=parseFloat(total_balance).toFixed(2);
                $('#'+claimtype+'_RetAcct'+claimnum+'_Estimated_MaritalEquity1').val(total_balance);

                var half_current_val=total_balance/2;
                half_current_val=parseFloat(half_current_val).toFixed(2);
                $('.'+claimnum+'_'+claimtype+'_clientamount_input').val(half_current_val);
                $('.'+claimnum+'_'+claimtype+'_opponentamount_input').val(half_current_val);
                $('.'+claimnum+'_'+claimtype+'_clientpercentage_input, .'+claimnum+'_'+claimtype+'_opponentpercentage_input, .'+claimnum+'_'+claimtype+'_balance_range_selector').val('50.00');
                $('.'+claimnum+'_'+claimtype+'_clientpercentage_div, .'+claimnum+'_'+claimtype+'_opponentpercentage_div').text('50.00%');
                $('.'+claimnum+'_'+claimtype+'_clientamount_div, .'+claimnum+'_'+claimtype+'_opponentamount_div').text(formatter.format(half_current_val));
            }
            $('.'+claimtype+'_RetAcct'+claimnum+'_Disposition_Method_Fixed_Div').hide();
            $('.'+claimtype+'_RetAcct'+claimnum+'_Disposition_Method_Fixed_Div input[type=number]').prop('readonly', true);

            // calculation for new fields
            var EP_to_CLient=0-((half_current_val-half_current_val)/2);
            var EP_to_Op=0-(EP_to_CLient);
            EP_to_CLient=parseFloat(EP_to_CLient).toFixed(2);
            EP_to_Op=parseFloat(EP_to_Op).toFixed(2);
            $('#'+claimtype+'_RetAcct'+claimnum+'_Estimated_EP_to_Client').val(EP_to_CLient);
            $('#'+claimtype+'_RetAcct'+claimnum+'_Estimated_EP_to_Op').val(EP_to_Op);
            $('.'+claimnum+'_'+claimtype+'_EPclientamount_div span').text(formatter.format(EP_to_CLient));
            $('.'+claimnum+'_'+claimtype+'_EPopponentamount_div span').text(formatter.format(EP_to_Op));
        }
    }

    function updateBalanceInput(value, balancenum, balancetype){
        var sliderclass=balancenum+'_'+balancetype;
        if(value <= 100){
            var value=parseFloat(value).toFixed(2);
            var current_balance=$('#'+balancetype+'_RetAcct'+balancenum+'_Current_Balance').val();
            $('.'+sliderclass+'_opponentpercentage_input').val(value);
            $('.'+sliderclass+'_opponentpercentage_div').text(value+'%');
            var client_balance_percentage_new=100-value;
            client_balance_percentage_new=parseFloat(client_balance_percentage_new).toFixed(2);
            $('.'+sliderclass+'_clientpercentage_input').val(client_balance_percentage_new);
            $('.'+sliderclass+'_clientpercentage_div').text(client_balance_percentage_new+'%');
            if(current_balance){
                current_balance=parseFloat(current_balance).toFixed(2);
            } else {
                current_balance=0.00;
            }
            var marriage_balance=$('#'+balancetype+'_RetAcct'+balancenum+'_Date_of_Marriage_Balance').val();
            if(marriage_balance){
                marriage_balance=parseFloat(marriage_balance).toFixed(2);
            } else {
                marriage_balance=0.00;
            }
            var joint_balance=(current_balance)-(marriage_balance);
            joint_balance=parseFloat(joint_balance).toFixed(2);
            $('#'+balancetype+'_RetAcct'+balancenum+'_Estimated_MaritalEquity1').val(joint_balance);

            var client_balance_amount_new = joint_balance - (joint_balance * value/100);
            var opponent_balance_amount_new = joint_balance - (joint_balance * client_balance_percentage_new/100);
            opponent_balance_amount_new=parseFloat(opponent_balance_amount_new).toFixed(2);
            client_balance_amount_new=parseFloat(client_balance_amount_new).toFixed(2);
            $('.'+sliderclass+'_opponentamount_input').val(opponent_balance_amount_new);
            $('.'+sliderclass+'_clientamount_input').val(client_balance_amount_new);
            $('.'+sliderclass+'_opponentamount_div').text(formatter.format(opponent_balance_amount_new));
            $('.'+sliderclass+'_clientamount_div').text(formatter.format(client_balance_amount_new));

            // calculation for new fields
            var EP_to_CLient=0-((client_balance_amount_new-opponent_balance_amount_new)/2);
            var EP_to_Op=0-(EP_to_CLient);
            EP_to_CLient=parseFloat(EP_to_CLient).toFixed(2);
            EP_to_Op=parseFloat(EP_to_Op).toFixed(2);
            $('#'+balancetype+'_RetAcct'+balancenum+'_Estimated_EP_to_Client').val(EP_to_CLient);
            $('#'+balancetype+'_RetAcct'+balancenum+'_Estimated_EP_to_Op').val(EP_to_Op);
            $('.'+sliderclass+'_EPclientamount_div span').text(formatter.format(EP_to_CLient));
            $('.'+sliderclass+'_EPopponentamount_div span').text(formatter.format(EP_to_Op));
        }
    }

    function resetBalanceInput(value, balancenum, balancetype){
        var sliderclass=balancenum+'_'+balancetype;
        $('.'+sliderclass+'_balance_range_selector, .'+sliderclass+'_opponentpercentage_input, .'+sliderclass+'_clientpercentage_input').val('50.00');
        $('.'+sliderclass+'_opponentpercentage_div, .'+sliderclass+'_clientpercentage_div').text('50.00%');
        var current_balance=$('#'+balancetype+'_RetAcct'+balancenum+'_Current_Balance').val();
        if(current_balance){
                current_balance=parseFloat(current_balance).toFixed(2);
        } else {
            current_balance=0.00;
        }
        var marriage_balance=$('#'+balancetype+'_RetAcct'+balancenum+'_Date_of_Marriage_Balance').val();
        if(marriage_balance){
            marriage_balance=parseFloat(marriage_balance).toFixed(2);
        } else {
            marriage_balance=0.00;
        }
        var joint_balance=(current_balance)-(marriage_balance);
        joint_balance=parseFloat(joint_balance).toFixed(2);
        $('#'+balancetype+'_RetAcct'+balancenum+'_Estimated_MaritalEquity1').val(joint_balance);

        client_balance=joint_balance/2;
        client_balance=parseFloat(client_balance).toFixed(2);
        $('.'+sliderclass+'_clientamount_input').val(client_balance);
        $('.'+sliderclass+'_opponentamount_input').val(client_balance);
        $('.'+sliderclass+'_clientamount_div').text(formatter.format(client_balance));
        $('.'+sliderclass+'_opponentamount_div').text(formatter.format(client_balance));

        // calculation for new fields
        var EP_to_CLient=0-((client_balance-client_balance)/2);
        var EP_to_Op=0-(EP_to_CLient);
        EP_to_CLient=parseFloat(EP_to_CLient).toFixed(2);
        EP_to_Op=parseFloat(EP_to_Op).toFixed(2);
        $('#'+balancetype+'_RetAcct'+balancenum+'_Estimated_EP_to_Client').val(EP_to_CLient);
        $('#'+balancetype+'_RetAcct'+balancenum+'_Estimated_EP_to_Op').val(EP_to_Op);
        $('.'+sliderclass+'_EPclientamount_div span').text(formatter.format(EP_to_CLient));
        $('.'+sliderclass+'_EPopponentamount_div span').text(formatter.format(EP_to_Op));
    }

    function getEstimatedValueOp(party, partynum, partytype){
        var current_val=$('#'+partytype+'_RetAcct'+partynum+'_Current_Balance').val();
        if(current_val){
            current_val=parseFloat(current_val).toFixed(2);
            var marriage_balance=$('#'+partytype+'_RetAcct'+partynum+'_Date_of_Marriage_Balance').val();
            if(marriage_balance){
                marriage_balance=parseFloat(marriage_balance).toFixed(2);
            } else {
                marriage_balance=0.00;
            }
            var total_balance=(current_val)-(marriage_balance);
            total_balance=parseFloat(total_balance).toFixed(2);
            $('#'+partytype+'_RetAcct'+partynum+'_Estimated_MaritalEquity1').val(total_balance);


            var op_val=party.value;
            op_val=parseFloat(op_val).toFixed(2);
            var client_val=(total_balance)-(op_val);
            client_val=parseFloat(client_val).toFixed(2);
            $('#'+partytype+'_RetAcct'+partynum+'_Estimated_Value_to_Client').val(client_val);
            var client_percentage=(client_val/total_balance)*(100).toFixed(2);
            client_percentage=parseFloat(client_percentage).toFixed(2);
            var op_percentage=(100-client_percentage).toFixed(2);
            op_percentage=parseFloat(op_percentage).toFixed(2);
            $('#'+partytype+'_RetAcct'+partynum+'_Percent_Marital_Equity_to_Client').val(client_percentage);
            $('#'+partytype+'_RetAcct'+partynum+'_Percent_Marital_Equity_to_Op').val(op_percentage);
        }
    }

    const formatter = new Intl.NumberFormat('en-US', {
        style: 'currency',
        currency: 'USD',
        minimumFractionDigits: 2
    });

    $(document).ready(function(){

        $('#dr_RetirementAccts').validate();
        $(window).keydown(function(event){
            if(event.keyCode == 13) {
              event.preventDefault();
              return false;
            }
        });

        // $('#Num_Client_Retirement_Accts, #Num_Op_Retirement_Accts').val('0');
        // $('.Client_retirementaccts_section input, .Op_retirementaccts_section input').prop('required',false);
        var any_retacc=$('#Any_Retirement_Accts');
        if(any_retacc.prop("checked") == true){
            $('.num_Client_Retirement_Accts_info, .num_Op_Retirement_Accts_info').show();
        } else {
            $('.num_Client_Retirement_Accts_info, .num_Op_Retirement_Accts_info').hide();
            $('#Num_Client_Retirement_Accts, #Num_Op_Retirement_Accts').val('0');
            $('.Client_retirementaccts_section input, .Op_retirementaccts_section input').prop('required',false);
            $('.1_Client_retirementaccts_section, .2_Client_retirementaccts_section, .3_Client_retirementaccts_section, .4_Client_retirementaccts_section').hide();
            $('.1_Op_retirementaccts_section, .2_Op_retirementaccts_section, .3_Op_retirementaccts_section, .4_Op_retirementaccts_section').hide();
        }
        // on number of client retirement acc input change
        $('.1_Client_retirementaccts_section, .2_Client_retirementaccts_section, .3_Client_retirementaccts_section, .4_Client_retirementaccts_section').hide();
        if($('#Num_Client_Retirement_Accts').val() > 0 &&  $('#Num_Client_Retirement_Accts').val() <= 4 ){
            for (var i = 1; i <= $('#Num_Client_Retirement_Accts').val(); i++) {
                $('.'+i+'_Client_retirementaccts_section').show();
                $('.'+i+'_Client_retirementaccts_section input').first().prop('required',true);
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
        var val=parseInt($('#Num_Client_Retirement_Accts').val())+1;
        for (var i = val; i <= 4; i++) {
            $('.'+i+'_Client_retirementaccts_section input').prop('required',false);
            $('.'+i+'_Client_retirementaccts_section select option[value=""]').prop('selected','selected');
        }

        $('#Num_Client_Retirement_Accts').on('change keyup', function(){
            $('.1_Client_retirementaccts_section, .2_Client_retirementaccts_section, .3_Client_retirementaccts_section, .4_Client_retirementaccts_section').hide();
            if(this.value > 0 &&  this.value <= 4 ){
                for (var i = 1; i <= this.value; i++) {
                    $('.'+i+'_Client_retirementaccts_section').show();
                }
            }
            var val=parseInt(this.value)+1;
            for (var i = val; i <= 4; i++) {
                $('.'+i+'_Client_retirementaccts_section input').prop('required',false);
                $('.'+i+'_Client_retirementaccts_section select option[value=""]').prop('selected','selected');
            }
        });

        // on number of opponent retirement acc input change
        $('.1_Op_retirementaccts_section, .2_Op_retirementaccts_section, .3_Op_retirementaccts_section, .4_Op_retirementaccts_section').hide();
        if($('#Num_Op_Retirement_Accts').val() > 0 &&  $('#Num_Op_Retirement_Accts').val() <= 4 ){
            for (var i = 1; i <= $('#Num_Op_Retirement_Accts').val(); i++) {
                $('.'+i+'_Op_retirementaccts_section').show();
                $('.'+i+'_Op_retirementaccts_section input').first().prop('required',true);
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
        var val=parseInt($('#Num_Op_Retirement_Accts').val())+1;
        for (var i = val; i <= 4; i++) {
            $('.'+i+'_Op_retirementaccts_section input').prop('required',false);
            $('.'+i+'_Op_retirementaccts_section select option[value=""]').prop('selected','selected');
        }
        
        $('#Num_Op_Retirement_Accts').on('change keyup', function(){
            $('.1_Op_retirementaccts_section, .2_Op_retirementaccts_section, .3_Op_retirementaccts_section, .4_Op_retirementaccts_section').hide();
            if(this.value > 0 &&  this.value <= 4 ){
                for (var i = 1; i <= this.value; i++) {
                    $('.'+i+'_Op_retirementaccts_section').show();
                }
            }
            var val=parseInt(this.value)+1;
            for (var i = val; i <= 4; i++) {
                $('.'+i+'_Op_retirementaccts_section input').prop('required',false);
                $('.'+i+'_Op_retirementaccts_section select option[value=""]').prop('selected','selected');
            }
        });
    });
</script>   
@endsection