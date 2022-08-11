@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center dr_FundsOnDeposit_main dr_Tables_main">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header"><strong>{{ __('Update Funds On Deposit Info') }}</strong>
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
                    <form role="form" id="dr_FundsOnDeposit" method="POST" action="{{route('drfundsondeposit.update',['id'=>$drfundsondeposit->id])}}" autocomplete="off">
                        @csrf
                        @method('put')
                        <input id="" type="hidden" class="form-control" name="case_id" value="{{$case_id}}">
                        <div class="form-row Any_FOD">
                            <div class="form-group col-sm-12">
                                <label></label>
                                <div class="w-100 dataInput">
                                     <label><input type="checkbox" id="Any_FOD" name="Any_FOD" value="1" onchange="getAnyFOD(this);" <?php if(isset($drfundsondeposit->Any_FOD) && $drfundsondeposit->Any_FOD=='1'){ echo "checked"; } ?>> Do the parties have any saving, checking, or other funds on deposit?</label>
                                </div>
                            </div>
                        </div>
                        <!-- Joint Funds On Deposit Info Section -->
                        <div class="form-row num_Joint_fundsondeposit_info" style="display: none;">
                            <h4 class="col-sm-12">Joint Funds On Deposit Info Section</h4>
                            <div class="col-sm-6">
                                <label for="Num_Joint_Deposit_Accounts">How many deposit accounts in BOTH parties’ names?</label>
                                <input id="Num_Joint_Deposit_Accounts" type="number" class="form-control" name="Num_Joint_Deposit_Accounts" value="<?php if(isset($drfundsondeposit->Num_Joint_Deposit_Accounts)){ echo $drfundsondeposit->Num_Joint_Deposit_Accounts; } ?>" min="0" max="10"> 
                            </div>
                        </div>
                        <div class="form-row Joint_fundsondeposit_info_section">
                            <div class="col-sm-12 mt-4 1_Joint_fundsondeposit_section" style="display: none;"><h5 class="col-sm-12">First Deposit Account Info</h5>
                                <div class="form-group col-sm-6">
                                    <p class="text-danger 1_Joint_no-state-county-found" style="display: none;">No City, State, County found for this zipcode.</p>
                                    <label for="Joint_Funds_on_Deposit_Institution_ZIP1">Deposit Institution Zip Code?</label>
                                    <input id="Joint_Funds_on_Deposit_Institution_ZIP1" type="text" class="form-control 1_Joint_fundsondeposit_inputs" name="Joint_Funds_on_Deposit_Institution_ZIP1" value="<?php if(isset($drfundsondeposit->Joint_Funds_on_Deposit_Institution_ZIP1)){ echo $drfundsondeposit->Joint_Funds_on_Deposit_Institution_ZIP1; } ?>" data-onload="getCityStateForZip(this, '1', 'Joint');" onkeyup="getCityStateForZip(this, '1', 'Joint');"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_Funds_on_Deposit_Institution_Name1">Name of Deposit Institution?</label>
                                    <input id="Joint_Funds_on_Deposit_Institution_Name1" type="text" class="form-control 1_Joint_fundsondeposit_inputs" name="Joint_Funds_on_Deposit_Institution_Name1" value="<?php if(isset($drfundsondeposit->Joint_Funds_on_Deposit_Institution_Name1)){ echo $drfundsondeposit->Joint_Funds_on_Deposit_Institution_Name1; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_Funds_on_Deposit_Institution_Street_Address1">Deposit Institution Street Address?</label>
                                    <input id="Joint_Funds_on_Deposit_Institution_Street_Address1" type="text" class="form-control 1_Joint_fundsondeposit_inputs" name="Joint_Funds_on_Deposit_Institution_Street_Address1" value="<?php if(isset($drfundsondeposit->Joint_Funds_on_Deposit_Institution_Street_Address1)){ echo $drfundsondeposit->Joint_Funds_on_Deposit_Institution_Street_Address1; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_Funds_on_Deposit_Institution_City1">Deposit Institution City?</label>
                                    <input type="hidden" name="" id="Joint_Funds_on_Deposit_Institution_City1_Value" value="<?php if(isset($drfundsondeposit->Joint_Funds_on_Deposit_Institution_City1)){ echo $drfundsondeposit->Joint_Funds_on_Deposit_Institution_City1; } ?>">
                                    <select id="Joint_Funds_on_Deposit_Institution_City1" name="Joint_Funds_on_Deposit_Institution_City1" class="form-control 1_Joint_city_select">
                                        <option value="">Choose City</option>
                                    </select>   
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_Funds_on_Deposit_Institution_State1">Deposit Institution State?</label>
                                    <input type="hidden" name="" id="Joint_Funds_on_Deposit_Institution_State1_Value" value="<?php if(isset($drfundsondeposit->Joint_Funds_on_Deposit_Institution_State1)){ echo $drfundsondeposit->Joint_Funds_on_Deposit_Institution_State1; } ?>">
                                    <select id="Joint_Funds_on_Deposit_Institution_State1" name="Joint_Funds_on_Deposit_Institution_State1" class="form-control 1_Joint_state_select">
                                        <option value="">Choose State</option>
                                    </select>   
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_Funds_on_Deposit_Institution_Acct_Num1">Account Number?</label>
                                    <input id="Joint_Funds_on_Deposit_Institution_Acct_Num1" type="text" class="form-control 1_Joint_fundsondeposit_inputs" name="Joint_Funds_on_Deposit_Institution_Acct_Num1" value="<?php if(isset($drfundsondeposit->Joint_Funds_on_Deposit_Institution_Acct_Num1)){ echo $drfundsondeposit->Joint_Funds_on_Deposit_Institution_Acct_Num1; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_Funds_on_Deposit_Institution_Current_Balance1">Current Balance?</label>
                                    <input id="Joint_Funds_on_Deposit_Institution_Current_Balance1" type="number" class="form-control 1_Joint_fundsondeposit_inputs" name="Joint_Funds_on_Deposit_Institution_Current_Balance1" value="<?php if(isset($drfundsondeposit->Joint_Funds_on_Deposit_Institution_Current_Balance1)){ echo $drfundsondeposit->Joint_Funds_on_Deposit_Institution_Current_Balance1; } ?>" min="0.00" step="0.01" max="999999.99" onchange="getJointCurrentBalance(this, '1_Joint');" onkeyup="getJointCurrentBalance(this, '1_Joint');"> 
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label for="Joint_Funds_on_Deposit_Estimated_MaritalEquity1">N/A, calculated = Joint_Funds_on_Deposit_Institution_Current_Balance1</label>
                                    <input id="Joint_Funds_on_Deposit_Estimated_MaritalEquity1" type="number" class="form-control 1_Joint_fundsondeposit_inputs" name="Joint_Funds_on_Deposit_Estimated_MaritalEquity1" value="<?php if(isset($drfundsondeposit->Joint_Funds_on_Deposit_Estimated_MaritalEquity1)){ echo $drfundsondeposit->Joint_Funds_on_Deposit_Estimated_MaritalEquity1; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_Funds_on_Deposit_Institution_Yearly_Interest_Dividend1">Yearly Interest?</label>
                                    <input id="Joint_Funds_on_Deposit_Institution_Yearly_Interest_Dividend1" type="number" class="form-control 1_Joint_fundsondeposit_inputs" name="Joint_Funds_on_Deposit_Institution_Yearly_Interest_Dividend1" value="<?php if(isset($drfundsondeposit->Joint_Funds_on_Deposit_Institution_Yearly_Interest_Dividend1)){ echo $drfundsondeposit->Joint_Funds_on_Deposit_Institution_Yearly_Interest_Dividend1; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Does either party claim a sole/separate interest from the other on this fund?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Joint_Funds_on_Deposit_SoleSeparate_Claim1_Yes" name="Joint_Funds_on_Deposit_SoleSeparate_Claim1" value="Yes" <?php if(isset($drfundsondeposit->Joint_Funds_on_Deposit_SoleSeparate_Claim1) && $drfundsondeposit->Joint_Funds_on_Deposit_SoleSeparate_Claim1=='Yes'){ echo "checked"; } ?>> Yes</label>
                                        <label><input type="radio" id="Joint_Funds_on_Deposit_SoleSeparate_Claim1_No" name="Joint_Funds_on_Deposit_SoleSeparate_Claim1" value="No" <?php if(isset($drfundsondeposit->Joint_Funds_on_Deposit_SoleSeparate_Claim1) && $drfundsondeposit->Joint_Funds_on_Deposit_SoleSeparate_Claim1=='No'){ echo "checked"; } ?>> No</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Who claims to own this fund?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Joint_Funds_on_Deposit_SoleSeparate_Party1_Client" name="Joint_Funds_on_Deposit_SoleSeparate_Party1" value="{{$client_name}}" <?php if(isset($drfundsondeposit->Joint_Funds_on_Deposit_SoleSeparate_Party1) && $drfundsondeposit->Joint_Funds_on_Deposit_SoleSeparate_Party1==$client_name){ echo "checked"; } ?>> {{$client_name}}</label>
                                        <label><input type="radio" id="Joint_Funds_on_Deposit_SoleSeparate_Party1_Op" name="Joint_Funds_on_Deposit_SoleSeparate_Party1" value="{{$opponent_name}}" <?php if(isset($drfundsondeposit->Joint_Funds_on_Deposit_SoleSeparate_Party1) && $drfundsondeposit->Joint_Funds_on_Deposit_SoleSeparate_Party1==$opponent_name){ echo "checked"; } ?>> {{$opponent_name}}</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 left-clear">
                                    <label for="Joint_Funds_on_Deposit_SoleSeparate_Grounds1">Why does this person own this fund solely and separately?</label>
                                    <input id="Joint_Funds_on_Deposit_SoleSeparate_Grounds1" type="text" class="form-control 1_Joint_fundsondeposit_inputs" name="Joint_Funds_on_Deposit_SoleSeparate_Grounds1" value="<?php if(isset($drfundsondeposit->Joint_Funds_on_Deposit_SoleSeparate_Grounds1)){ echo $drfundsondeposit->Joint_Funds_on_Deposit_SoleSeparate_Grounds1; } ?>"> 
                                </div>
                                <!-- slider tool -->
                                <div class="form-group col-sm-6 m-auto slider-tool-main">
                                    <div class="row">
                                        <div class="col">{{$client_name}}</div>
                                        <div class="col text-right">{{$opponent_name}}</div>
                                    </div>
                                    <input id="1_Joint_balance_range_selector" type="range" class="form-control slider-tool-input 1_Joint_balance_range_selector" name="" value="<?php if(isset($drfundsondeposit->Joint_Funds_on_Deposit_Percent_Marital_Equity_to_Op1)){ echo $drfundsondeposit->Joint_Funds_on_Deposit_Percent_Marital_Equity_to_Op1; } ?>" min="0.00" step="0.01" max="100" onchange="updateBalanceInput(this.value, '1', 'Joint');">
                                </div>
                                <div class="form-group col-sm-6 m-auto slider-tool-main">
                                    <div class="row justify-content-between">
                                        <div class="col selectorTool">
                                            <div class="left-col">
                                                <div class="client-info 1_Joint_clientpercentage_div clientpercentage_div">
                                                    <?php if(isset($drfundsondeposit->Joint_Funds_on_Deposit_Percent_Marital_Equity_to_Client1)){ echo $drfundsondeposit->Joint_Funds_on_Deposit_Percent_Marital_Equity_to_Client1; } else {
                                                        echo "50.00";
                                                    } ?>%
                                                </div>
                                                <div class="client-info 1_Joint_clientamount_div clientamount_div" style="clear: both;">
                                                    $<?php if(isset($drfundsondeposit->Joint_Funds_on_Deposit_Estimated_Value_to_Client1)){ echo $drfundsondeposit->Joint_Funds_on_Deposit_Estimated_Value_to_Client1; } ?>
                                                </div>
                                            </div>
                                            <label>To {{$client_name}}</label>
                                        </div>                                       
                                        <div class="col selectorTool selectorToolRight">
                                            <label>To {{$opponent_name}}</label>
                                            <div class="left-col right-col">
                                                <div class="client-info 1_Joint_opponentpercentage_div opponentpercentage_div">
                                                    <?php if(isset($drfundsondeposit->Joint_Funds_on_Deposit_Percent_Marital_Equity_to_Op1)){ echo $drfundsondeposit->Joint_Funds_on_Deposit_Percent_Marital_Equity_to_Op1; } else {
                                                        echo "50.00";
                                                    } ?>%
                                                </div>
                                                <div class="client-info 1_Joint_opponentamount_div opponentamount_div" style="clear: both;">
                                                    $<?php if(isset($drfundsondeposit->Joint_Funds_on_Deposit_Estimated_Value_to_Op1)){ echo $drfundsondeposit->Joint_Funds_on_Deposit_Estimated_Value_to_Op1; } ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 m-auto slider-tool-main">
                                    <label></label>
                                    <div class="w-100">
                                        <label><input type="radio" id="1_Joint_Funds_on_Deposit_Estimated_Value_Select" name="1_Joint_Funds_on_Deposit_Estimated_Value_Select_Reset" class="Funds_on_Deposit_Estimated_Value_Select_Reset" value="Save"> Save this Distribution of Deposit Account #1</label>
                                        <label><input type="radio" id="1_Joint_Funds_on_Deposit_Estimated_Value_Reset" name="1_Joint_Funds_on_Deposit_Estimated_Value_Select_Reset" class="Funds_on_Deposit_Estimated_Value_Select_Reset" value="Reset" onclick="resetBalanceInput(this, '1', 'Joint');"> Reset to Default (50%)</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label>{{$client_name}} Deposite Equity Percent</label>
                                    <input id="Joint_Funds_on_Deposit_Percent_Marital_Equity_to_Client1" type="number" class="form-control 1_Joint_clientpercentage_input clientpercentage_input" name="Joint_Funds_on_Deposit_Percent_Marital_Equity_to_Client1" value="<?php if(isset($drfundsondeposit->Joint_Funds_on_Deposit_Percent_Marital_Equity_to_Client1)){ echo $drfundsondeposit->Joint_Funds_on_Deposit_Percent_Marital_Equity_to_Client1; } ?>" min="0.00" step="0.01" max="100" readonly="">
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label>{{$client_name}} Deposite Equity Amount</label>
                                    <input id="Joint_Funds_on_Deposit_Estimated_Value_to_Client1" type="number" class="form-control 1_Joint_clientamount_input clientamount_input" name="Joint_Funds_on_Deposit_Estimated_Value_to_Client1" value="<?php if(isset($drfundsondeposit->Joint_Funds_on_Deposit_Estimated_Value_to_Client1)){ echo $drfundsondeposit->Joint_Funds_on_Deposit_Estimated_Value_to_Client1; } ?>" min="0.00" step="0.01" max="999999.99" readonly="">
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label>{{$opponent_name}} Deposite Equity Percent</label>
                                    <input id="Joint_Funds_on_Deposit_Percent_Marital_Equity_to_Op1" type="number" class="form-control 1_Joint_opponentpercentage_input opponentpercentage_input" name="Joint_Funds_on_Deposit_Percent_Marital_Equity_to_Op1" value="<?php if(isset($drfundsondeposit->Joint_Funds_on_Deposit_Percent_Marital_Equity_to_Op1)){ echo $drfundsondeposit->Joint_Funds_on_Deposit_Percent_Marital_Equity_to_Op1; } ?>" min="0.00" step="0.01" max="100" readonly="">
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label>{{$opponent_name}} Deposite Equity Amount</label>
                                    <input id="Joint_Funds_on_Deposit_Estimated_Value_to_Op1" type="number" class="form-control 1_Joint_opponentamount_input opponentamount_input" name="Joint_Funds_on_Deposit_Estimated_Value_to_Op1" value="<?php if(isset($drfundsondeposit->Joint_Funds_on_Deposit_Estimated_Value_to_Op1)){ echo $drfundsondeposit->Joint_Funds_on_Deposit_Estimated_Value_to_Op1; } ?>" min="0.00" step="0.01" max="999999.99" readonly="">
                                </div>
                                <!-- end of slider tool -->
                            </div>
                            <div class="col-sm-12 mt-4 2_Joint_fundsondeposit_section" style="display: none;"><h5 class="col-sm-12">Second Deposit Account Info</h5>
                                <div class="form-group col-sm-6">
                                    <p class="text-danger 2_Joint_no-state-county-found" style="display: none;">No City, State, County found for this zipcode.</p>
                                    <label for="Joint_Funds_on_Deposit_Institution_ZIP2">Deposit Institution Zip Code?</label>
                                    <input id="Joint_Funds_on_Deposit_Institution_ZIP2" type="text" class="form-control 2_Joint_fundsondeposit_inputs" name="Joint_Funds_on_Deposit_Institution_ZIP2" value="<?php if(isset($drfundsondeposit->Joint_Funds_on_Deposit_Institution_ZIP2)){ echo $drfundsondeposit->Joint_Funds_on_Deposit_Institution_ZIP2; } ?>" data-onload="getCityStateForZip(this, '2', 'Joint');" onkeyup="getCityStateForZip(this, '2', 'Joint');"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_Funds_on_Deposit_Institution_Name2">Name of Deposit Institution?</label>
                                    <input id="Joint_Funds_on_Deposit_Institution_Name2" type="text" class="form-control 2_Joint_fundsondeposit_inputs" name="Joint_Funds_on_Deposit_Institution_Name2" value="<?php if(isset($drfundsondeposit->Joint_Funds_on_Deposit_Institution_Name2)){ echo $drfundsondeposit->Joint_Funds_on_Deposit_Institution_Name2; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_Funds_on_Deposit_Institution_Street_Address2">Deposit Institution Street Address?</label>
                                    <input id="Joint_Funds_on_Deposit_Institution_Street_Address2" type="text" class="form-control 2_Joint_fundsondeposit_inputs" name="Joint_Funds_on_Deposit_Institution_Street_Address2" value="<?php if(isset($drfundsondeposit->Joint_Funds_on_Deposit_Institution_Street_Address2)){ echo $drfundsondeposit->Joint_Funds_on_Deposit_Institution_Street_Address2; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_Funds_on_Deposit_Institution_City2">Deposit Institution City?</label>
                                    <input type="hidden" name="" id="Joint_Funds_on_Deposit_Institution_City2_Value" value="<?php if(isset($drfundsondeposit->Joint_Funds_on_Deposit_Institution_City2)){ echo $drfundsondeposit->Joint_Funds_on_Deposit_Institution_City2; } ?>">
                                    <select id="Joint_Funds_on_Deposit_Institution_City2" name="Joint_Funds_on_Deposit_Institution_City2" class="form-control 2_Joint_city_select">
                                        <option value="">Choose City</option>
                                    </select>   
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_Funds_on_Deposit_Institution_State2">Deposit Institution State?</label>
                                    <input type="hidden" name="" id="Joint_Funds_on_Deposit_Institution_State2_Value" value="<?php if(isset($drfundsondeposit->Joint_Funds_on_Deposit_Institution_State2)){ echo $drfundsondeposit->Joint_Funds_on_Deposit_Institution_State2; } ?>">
                                    <select id="Joint_Funds_on_Deposit_Institution_State2" name="Joint_Funds_on_Deposit_Institution_State2" class="form-control 2_Joint_state_select">
                                        <option value="">Choose State</option>
                                    </select>   
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_Funds_on_Deposit_Institution_Acct_Num2">Account Number?</label>
                                    <input id="Joint_Funds_on_Deposit_Institution_Acct_Num2" type="text" class="form-control 2_Joint_fundsondeposit_inputs" name="Joint_Funds_on_Deposit_Institution_Acct_Num2" value="<?php if(isset($drfundsondeposit->Joint_Funds_on_Deposit_Institution_Acct_Num2)){ echo $drfundsondeposit->Joint_Funds_on_Deposit_Institution_Acct_Num2; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_Funds_on_Deposit_Institution_Current_Balance2">Current Balance?</label>
                                    <input id="Joint_Funds_on_Deposit_Institution_Current_Balance2" type="number" class="form-control 2_Joint_fundsondeposit_inputs" name="Joint_Funds_on_Deposit_Institution_Current_Balance2" value="<?php if(isset($drfundsondeposit->Joint_Funds_on_Deposit_Institution_Current_Balance2)){ echo $drfundsondeposit->Joint_Funds_on_Deposit_Institution_Current_Balance2; } ?>" min="0.00" step="0.01" max="999999.99" onchange="getJointCurrentBalance(this, '2_Joint');" onkeyup="getJointCurrentBalance(this, '2_Joint');"> 
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label for="Joint_Funds_on_Deposit_Estimated_MaritalEquity2">N/A, calculated = Joint_Funds_on_Deposit_Institution_Current_Balance2</label>
                                    <input id="Joint_Funds_on_Deposit_Estimated_MaritalEquity2" type="number" class="form-control 2_Joint_fundsondeposit_inputs" name="Joint_Funds_on_Deposit_Estimated_MaritalEquity2" value="<?php if(isset($drfundsondeposit->Joint_Funds_on_Deposit_Estimated_MaritalEquity2)){ echo $drfundsondeposit->Joint_Funds_on_Deposit_Estimated_MaritalEquity2; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_Funds_on_Deposit_Institution_Yearly_Interest_Dividend2">Yearly Interest?</label>
                                    <input id="Joint_Funds_on_Deposit_Institution_Yearly_Interest_Dividend2" type="number" class="form-control 2_Joint_fundsondeposit_inputs" name="Joint_Funds_on_Deposit_Institution_Yearly_Interest_Dividend2" value="<?php if(isset($drfundsondeposit->Joint_Funds_on_Deposit_Institution_Yearly_Interest_Dividend2)){ echo $drfundsondeposit->Joint_Funds_on_Deposit_Institution_Yearly_Interest_Dividend2; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Does either party claim a sole/separate interest from the other on this fund?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Joint_Funds_on_Deposit_SoleSeparate_Claim2_Yes" name="Joint_Funds_on_Deposit_SoleSeparate_Claim2" value="Yes" <?php if(isset($drfundsondeposit->Joint_Funds_on_Deposit_SoleSeparate_Claim2) && $drfundsondeposit->Joint_Funds_on_Deposit_SoleSeparate_Claim2=='Yes'){ echo "checked"; } ?>> Yes</label>
                                        <label><input type="radio" id="Joint_Funds_on_Deposit_SoleSeparate_Claim2_No" name="Joint_Funds_on_Deposit_SoleSeparate_Claim2" value="No" <?php if(isset($drfundsondeposit->Joint_Funds_on_Deposit_SoleSeparate_Claim2) && $drfundsondeposit->Joint_Funds_on_Deposit_SoleSeparate_Claim2=='No'){ echo "checked"; } ?>> No</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Who claims to own this fund?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Joint_Funds_on_Deposit_SoleSeparate_Party2_Client" name="Joint_Funds_on_Deposit_SoleSeparate_Party2" value="{{$client_name}}" <?php if(isset($drfundsondeposit->Joint_Funds_on_Deposit_SoleSeparate_Party2) && $drfundsondeposit->Joint_Funds_on_Deposit_SoleSeparate_Party2==$client_name){ echo "checked"; } ?>> {{$client_name}}</label>
                                        <label><input type="radio" id="Joint_Funds_on_Deposit_SoleSeparate_Party2_Op" name="Joint_Funds_on_Deposit_SoleSeparate_Party2" value="{{$opponent_name}}" <?php if(isset($drfundsondeposit->Joint_Funds_on_Deposit_SoleSeparate_Party2) && $drfundsondeposit->Joint_Funds_on_Deposit_SoleSeparate_Party2==$opponent_name){ echo "checked"; } ?>> {{$opponent_name}}</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 left-clear">
                                    <label for="Joint_Funds_on_Deposit_SoleSeparate_Grounds2">Why does this person own this fund solely and separately?</label>
                                    <input id="Joint_Funds_on_Deposit_SoleSeparate_Grounds2" type="text" class="form-control 2_Joint_fundsondeposit_inputs" name="Joint_Funds_on_Deposit_SoleSeparate_Grounds2" value="<?php if(isset($drfundsondeposit->Joint_Funds_on_Deposit_SoleSeparate_Grounds2)){ echo $drfundsondeposit->Joint_Funds_on_Deposit_SoleSeparate_Grounds2; } ?>"> 
                                </div>
                                <!-- slider tool -->
                                <div class="form-group col-sm-6 m-auto slider-tool-main">
                                    <div class="row">
                                        <div class="col">{{$client_name}}</div>
                                        <div class="col text-right">{{$opponent_name}}</div>
                                    </div>
                                    <input id="2_Joint_balance_range_selector" type="range" class="form-control slider-tool-input 2_Joint_balance_range_selector" name="" value="<?php if(isset($drfundsondeposit->Joint_Funds_on_Deposit_Percent_Marital_Equity_to_Op2)){ echo $drfundsondeposit->Joint_Funds_on_Deposit_Percent_Marital_Equity_to_Op2; } ?>" min="0.00" step="0.01" max="100" onchange="updateBalanceInput(this.value, '2', 'Joint');">
                                </div>
                                <div class="form-group col-sm-6 m-auto slider-tool-main">
                                    <div class="row justify-content-between">
                                        <div class="col selectorTool">
                                            <div class="left-col">
                                                <div class="client-info 2_Joint_clientpercentage_div clientpercentage_div">
                                                    <?php if(isset($drfundsondeposit->Joint_Funds_on_Deposit_Percent_Marital_Equity_to_Client2)){ echo $drfundsondeposit->Joint_Funds_on_Deposit_Percent_Marital_Equity_to_Client2; } else {
                                                        echo "50.00";
                                                    } ?>%
                                                </div>
                                                <div class="client-info 2_Joint_clientamount_div clientamount_div" style="clear: both;">
                                                    $<?php if(isset($drfundsondeposit->Joint_Funds_on_Deposit_Estimated_Value_to_Client2)){ echo $drfundsondeposit->Joint_Funds_on_Deposit_Estimated_Value_to_Client2; } ?>
                                                </div>
                                            </div>
                                            <label>To {{$client_name}}</label>
                                        </div>                                       
                                        <div class="col selectorTool selectorToolRight">
                                            <label>To {{$opponent_name}}</label>
                                            <div class="left-col right-col">
                                                <div class="client-info 2_Joint_opponentpercentage_div opponentpercentage_div">
                                                    <?php if(isset($drfundsondeposit->Joint_Funds_on_Deposit_Percent_Marital_Equity_to_Op2)){ echo $drfundsondeposit->Joint_Funds_on_Deposit_Percent_Marital_Equity_to_Op2; } else {
                                                        echo "50.00";
                                                    } ?>%
                                                </div>
                                                <div class="client-info 2_Joint_opponentamount_div opponentamount_div" style="clear: both;">
                                                    $<?php if(isset($drfundsondeposit->Joint_Funds_on_Deposit_Estimated_Value_to_Op2)){ echo $drfundsondeposit->Joint_Funds_on_Deposit_Estimated_Value_to_Op2; } ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 m-auto slider-tool-main">
                                    <label></label>
                                    <div class="w-100">
                                        <label><input type="radio" id="2_Joint_Funds_on_Deposit_Estimated_Value_Select" name="2_Joint_Funds_on_Deposit_Estimated_Value_Select_Reset" class="Funds_on_Deposit_Estimated_Value_Select_Reset" value="Save"> Save this Distribution of Deposit Account #2</label>
                                        <label><input type="radio" id="2_Joint_Funds_on_Deposit_Estimated_Value_Reset" name="2_Joint_Funds_on_Deposit_Estimated_Value_Select_Reset" class="Funds_on_Deposit_Estimated_Value_Select_Reset" value="Reset" onclick="resetBalanceInput(this, '2', 'Joint');"> Reset to Default (50%)</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label>{{$client_name}} Deposite Equity Percent</label>
                                    <input id="Joint_Funds_on_Deposit_Percent_Marital_Equity_to_Client2" type="number" class="form-control 2_Joint_clientpercentage_input clientpercentage_input" name="Joint_Funds_on_Deposit_Percent_Marital_Equity_to_Client2" value="<?php if(isset($drfundsondeposit->Joint_Funds_on_Deposit_Percent_Marital_Equity_to_Client2)){ echo $drfundsondeposit->Joint_Funds_on_Deposit_Percent_Marital_Equity_to_Client2; } ?>" min="0.00" step="0.01" max="100" readonly="">
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label>{{$client_name}} Deposite Equity Amount</label>
                                    <input id="Joint_Funds_on_Deposit_Estimated_Value_to_Client2" type="number" class="form-control 2_Joint_clientamount_input clientamount_input" name="Joint_Funds_on_Deposit_Estimated_Value_to_Client2" value="<?php if(isset($drfundsondeposit->Joint_Funds_on_Deposit_Estimated_Value_to_Client2)){ echo $drfundsondeposit->Joint_Funds_on_Deposit_Estimated_Value_to_Client2; } ?>" min="0.00" step="0.01" max="999999.99" readonly="">
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label>{{$opponent_name}} Deposite Equity Percent</label>
                                    <input id="Joint_Funds_on_Deposit_Percent_Marital_Equity_to_Op2" type="number" class="form-control 2_Joint_opponentpercentage_input opponentpercentage_input" name="Joint_Funds_on_Deposit_Percent_Marital_Equity_to_Op2" value="<?php if(isset($drfundsondeposit->Joint_Funds_on_Deposit_Percent_Marital_Equity_to_Op2)){ echo $drfundsondeposit->Joint_Funds_on_Deposit_Percent_Marital_Equity_to_Op2; } ?>" min="0.00" step="0.01" max="100" readonly="">
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label>{{$opponent_name}} Deposite Equity Amount</label>
                                    <input id="Joint_Funds_on_Deposit_Estimated_Value_to_Op2" type="number" class="form-control 2_Joint_opponentamount_input opponentamount_input" name="Joint_Funds_on_Deposit_Estimated_Value_to_Op2" value="<?php if(isset($drfundsondeposit->Joint_Funds_on_Deposit_Estimated_Value_to_Op2)){ echo $drfundsondeposit->Joint_Funds_on_Deposit_Estimated_Value_to_Op2; } ?>" min="0.00" step="0.01" max="999999.99" readonly="">
                                </div>
                                <!-- end of slider tool -->
                            </div>
                            <div class="col-sm-12 mt-4 3_Joint_fundsondeposit_section" style="display: none;"><h5 class="col-sm-12">Third Deposit Account Info</h5>
                                <div class="form-group col-sm-6">
                                    <p class="text-danger 3_Joint_no-state-county-found" style="display: none;">No City, State, County found for this zipcode.</p>
                                    <label for="Joint_Funds_on_Deposit_Institution_ZIP3">Deposit Institution Zip Code?</label>
                                    <input id="Joint_Funds_on_Deposit_Institution_ZIP3" type="text" class="form-control 3_Joint_fundsondeposit_inputs" name="Joint_Funds_on_Deposit_Institution_ZIP3" value="<?php if(isset($drfundsondeposit->Joint_Funds_on_Deposit_Institution_ZIP3)){ echo $drfundsondeposit->Joint_Funds_on_Deposit_Institution_ZIP3; } ?>" data-onload="getCityStateForZip(this, '3', 'Joint');" onkeyup="getCityStateForZip(this, '3', 'Joint');"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_Funds_on_Deposit_Institution_Name3">Name of Deposit Institution?</label>
                                    <input id="Joint_Funds_on_Deposit_Institution_Name3" type="text" class="form-control 3_Joint_fundsondeposit_inputs" name="Joint_Funds_on_Deposit_Institution_Name3" value="<?php if(isset($drfundsondeposit->Joint_Funds_on_Deposit_Institution_Name3)){ echo $drfundsondeposit->Joint_Funds_on_Deposit_Institution_Name3; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_Funds_on_Deposit_Institution_Street_Address3">Deposit Institution Street Address?</label>
                                    <input id="Joint_Funds_on_Deposit_Institution_Street_Address3" type="text" class="form-control 3_Joint_fundsondeposit_inputs" name="Joint_Funds_on_Deposit_Institution_Street_Address3" value="<?php if(isset($drfundsondeposit->Joint_Funds_on_Deposit_Institution_Street_Address3)){ echo $drfundsondeposit->Joint_Funds_on_Deposit_Institution_Street_Address3; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_Funds_on_Deposit_Institution_City3">Deposit Institution City?</label>
                                    <input type="hidden" name="" id="Joint_Funds_on_Deposit_Institution_City3_Value" value="<?php if(isset($drfundsondeposit->Joint_Funds_on_Deposit_Institution_City3)){ echo $drfundsondeposit->Joint_Funds_on_Deposit_Institution_City3; } ?>">
                                    <select id="Joint_Funds_on_Deposit_Institution_City3" name="Joint_Funds_on_Deposit_Institution_City3" class="form-control 3_Joint_city_select">
                                        <option value="">Choose City</option>
                                    </select>   
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_Funds_on_Deposit_Institution_State3">Deposit Institution State?</label>
                                    <input type="hidden" name="" id="Joint_Funds_on_Deposit_Institution_State3_Value" value="<?php if(isset($drfundsondeposit->Joint_Funds_on_Deposit_Institution_State3)){ echo $drfundsondeposit->Joint_Funds_on_Deposit_Institution_State3; } ?>">
                                    <select id="Joint_Funds_on_Deposit_Institution_State3" name="Joint_Funds_on_Deposit_Institution_State3" class="form-control 3_Joint_state_select">
                                        <option value="">Choose State</option>
                                    </select>   
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_Funds_on_Deposit_Institution_Acct_Num3">Account Number?</label>
                                    <input id="Joint_Funds_on_Deposit_Institution_Acct_Num3" type="text" class="form-control 3_Joint_fundsondeposit_inputs" name="Joint_Funds_on_Deposit_Institution_Acct_Num3" value="<?php if(isset($drfundsondeposit->Joint_Funds_on_Deposit_Institution_Acct_Num3)){ echo $drfundsondeposit->Joint_Funds_on_Deposit_Institution_Acct_Num3; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_Funds_on_Deposit_Institution_Current_Balance3">Current Balance?</label>
                                    <input id="Joint_Funds_on_Deposit_Institution_Current_Balance3" type="number" class="form-control 3_Joint_fundsondeposit_inputs" name="Joint_Funds_on_Deposit_Institution_Current_Balance3" value="<?php if(isset($drfundsondeposit->Joint_Funds_on_Deposit_Institution_Current_Balance3)){ echo $drfundsondeposit->Joint_Funds_on_Deposit_Institution_Current_Balance3; } ?>" min="0.00" step="0.01" max="999999.99" onchange="getJointCurrentBalance(this, '3_Joint');" onkeyup="getJointCurrentBalance(this, '3_Joint');"> 
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label for="Joint_Funds_on_Deposit_Estimated_MaritalEquity3">N/A, calculated = Joint_Funds_on_Deposit_Institution_Current_Balance3</label>
                                    <input id="Joint_Funds_on_Deposit_Estimated_MaritalEquity3" type="number" class="form-control 3_Joint_fundsondeposit_inputs" name="Joint_Funds_on_Deposit_Estimated_MaritalEquity3" value="<?php if(isset($drfundsondeposit->Joint_Funds_on_Deposit_Estimated_MaritalEquity3)){ echo $drfundsondeposit->Joint_Funds_on_Deposit_Estimated_MaritalEquity3; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_Funds_on_Deposit_Institution_Yearly_Interest_Dividend3">Yearly Interest?</label>
                                    <input id="Joint_Funds_on_Deposit_Institution_Yearly_Interest_Dividend3" type="number" class="form-control 3_Joint_fundsondeposit_inputs" name="Joint_Funds_on_Deposit_Institution_Yearly_Interest_Dividend3" value="<?php if(isset($drfundsondeposit->Joint_Funds_on_Deposit_Institution_Yearly_Interest_Dividend3)){ echo $drfundsondeposit->Joint_Funds_on_Deposit_Institution_Yearly_Interest_Dividend3; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Does either party claim a sole/separate interest from the other on this fund?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Joint_Funds_on_Deposit_SoleSeparate_Claim3_Yes" name="Joint_Funds_on_Deposit_SoleSeparate_Claim3" value="Yes" <?php if(isset($drfundsondeposit->Joint_Funds_on_Deposit_SoleSeparate_Claim3) && $drfundsondeposit->Joint_Funds_on_Deposit_SoleSeparate_Claim3=='Yes'){ echo "checked"; } ?>> Yes</label>
                                        <label><input type="radio" id="Joint_Funds_on_Deposit_SoleSeparate_Claim3_No" name="Joint_Funds_on_Deposit_SoleSeparate_Claim3" value="No" <?php if(isset($drfundsondeposit->Joint_Funds_on_Deposit_SoleSeparate_Claim3) && $drfundsondeposit->Joint_Funds_on_Deposit_SoleSeparate_Claim3=='No'){ echo "checked"; } ?>> No</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Who claims to own this fund?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Joint_Funds_on_Deposit_SoleSeparate_Party3_Client" name="Joint_Funds_on_Deposit_SoleSeparate_Party3" value="{{$client_name}}" <?php if(isset($drfundsondeposit->Joint_Funds_on_Deposit_SoleSeparate_Party3) && $drfundsondeposit->Joint_Funds_on_Deposit_SoleSeparate_Party3==$client_name){ echo "checked"; } ?>> {{$client_name}}</label>
                                        <label><input type="radio" id="Joint_Funds_on_Deposit_SoleSeparate_Party3_Op" name="Joint_Funds_on_Deposit_SoleSeparate_Party3" value="{{$opponent_name}}" <?php if(isset($drfundsondeposit->Joint_Funds_on_Deposit_SoleSeparate_Party3) && $drfundsondeposit->Joint_Funds_on_Deposit_SoleSeparate_Party3==$opponent_name){ echo "checked"; } ?>> {{$opponent_name}}</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 left-clear">
                                    <label for="Joint_Funds_on_Deposit_SoleSeparate_Grounds3">Why does this person own this fund solely and separately?</label>
                                    <input id="Joint_Funds_on_Deposit_SoleSeparate_Grounds3" type="text" class="form-control 3_Joint_fundsondeposit_inputs" name="Joint_Funds_on_Deposit_SoleSeparate_Grounds3" value="<?php if(isset($drfundsondeposit->Joint_Funds_on_Deposit_SoleSeparate_Grounds3)){ echo $drfundsondeposit->Joint_Funds_on_Deposit_SoleSeparate_Grounds3; } ?>"> 
                                </div>
                                <!-- slider tool -->
                                <div class="form-group col-sm-6 m-auto slider-tool-main">
                                    <div class="row">
                                        <div class="col">{{$client_name}}</div>
                                        <div class="col text-right">{{$opponent_name}}</div>
                                    </div>
                                    <input id="3_Joint_balance_range_selector" type="range" class="form-control slider-tool-input 3_Joint_balance_range_selector" name="" value="<?php if(isset($drfundsondeposit->Joint_Funds_on_Deposit_Percent_Marital_Equity_to_Op3)){ echo $drfundsondeposit->Joint_Funds_on_Deposit_Percent_Marital_Equity_to_Op3; } ?>" min="0.00" step="0.01" max="100" onchange="updateBalanceInput(this.value, '3', 'Joint');">
                                </div>
                                <div class="form-group col-sm-6 m-auto slider-tool-main">
                                    <div class="row justify-content-between">
                                        <div class="col selectorTool">
                                            <div class="left-col">
                                                <div class="client-info 3_Joint_clientpercentage_div clientpercentage_div">
                                                    <?php if(isset($drfundsondeposit->Joint_Funds_on_Deposit_Percent_Marital_Equity_to_Client3)){ echo $drfundsondeposit->Joint_Funds_on_Deposit_Percent_Marital_Equity_to_Client3; } else {
                                                        echo "50.00";
                                                    } ?>%
                                                </div>
                                                <div class="client-info 3_Joint_clientamount_div clientamount_div" style="clear: both;">
                                                    $<?php if(isset($drfundsondeposit->Joint_Funds_on_Deposit_Estimated_Value_to_Client3)){ echo $drfundsondeposit->Joint_Funds_on_Deposit_Estimated_Value_to_Client3; } ?>
                                                </div>
                                            </div>
                                            <label>To {{$client_name}}</label>
                                        </div>                                       
                                        <div class="col selectorTool selectorToolRight">
                                            <label>To {{$opponent_name}}</label>
                                            <div class="left-col right-col">
                                                <div class="client-info 3_Joint_opponentpercentage_div opponentpercentage_div">
                                                    <?php if(isset($drfundsondeposit->Joint_Funds_on_Deposit_Percent_Marital_Equity_to_Op3)){ echo $drfundsondeposit->Joint_Funds_on_Deposit_Percent_Marital_Equity_to_Op3; } else {
                                                        echo "50.00";
                                                    } ?>%
                                                </div>
                                                <div class="client-info 3_Joint_opponentamount_div opponentamount_div" style="clear: both;">
                                                    $<?php if(isset($drfundsondeposit->Joint_Funds_on_Deposit_Estimated_Value_to_Op3)){ echo $drfundsondeposit->Joint_Funds_on_Deposit_Estimated_Value_to_Op3; } ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 m-auto slider-tool-main">
                                    <label></label>
                                    <div class="w-100">
                                        <label><input type="radio" id="3_Joint_Funds_on_Deposit_Estimated_Value_Select" name="3_Joint_Funds_on_Deposit_Estimated_Value_Select_Reset" class="Funds_on_Deposit_Estimated_Value_Select_Reset" value="Save"> Save this Distribution of Deposit Account #3</label>
                                        <label><input type="radio" id="3_Joint_Funds_on_Deposit_Estimated_Value_Reset" name="3_Joint_Funds_on_Deposit_Estimated_Value_Select_Reset" class="Funds_on_Deposit_Estimated_Value_Select_Reset" value="Reset" onclick="resetBalanceInput(this, '3', 'Joint');"> Reset to Default (50%)</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label>{{$client_name}} Deposite Equity Percent</label>
                                    <input id="Joint_Funds_on_Deposit_Percent_Marital_Equity_to_Client3" type="number" class="form-control 3_Joint_clientpercentage_input clientpercentage_input" name="Joint_Funds_on_Deposit_Percent_Marital_Equity_to_Client3" value="<?php if(isset($drfundsondeposit->Joint_Funds_on_Deposit_Percent_Marital_Equity_to_Client3)){ echo $drfundsondeposit->Joint_Funds_on_Deposit_Percent_Marital_Equity_to_Client3; } ?>" min="0.00" step="0.01" max="100" readonly="">
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label>{{$client_name}} Deposite Equity Amount</label>
                                    <input id="Joint_Funds_on_Deposit_Estimated_Value_to_Client3" type="number" class="form-control 3_Joint_clientamount_input clientamount_input" name="Joint_Funds_on_Deposit_Estimated_Value_to_Client3" value="<?php if(isset($drfundsondeposit->Joint_Funds_on_Deposit_Estimated_Value_to_Client3)){ echo $drfundsondeposit->Joint_Funds_on_Deposit_Estimated_Value_to_Client3; } ?>" min="0.00" step="0.01" max="999999.99" readonly="">
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label>{{$opponent_name}} Deposite Equity Percent</label>
                                    <input id="Joint_Funds_on_Deposit_Percent_Marital_Equity_to_Op3" type="number" class="form-control 3_Joint_opponentpercentage_input opponentpercentage_input" name="Joint_Funds_on_Deposit_Percent_Marital_Equity_to_Op3" value="<?php if(isset($drfundsondeposit->Joint_Funds_on_Deposit_Percent_Marital_Equity_to_Op3)){ echo $drfundsondeposit->Joint_Funds_on_Deposit_Percent_Marital_Equity_to_Op3; } ?>" min="0.00" step="0.01" max="100" readonly="">
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label>{{$opponent_name}} Deposite Equity Amount</label>
                                    <input id="Joint_Funds_on_Deposit_Estimated_Value_to_Op3" type="number" class="form-control 3_Joint_opponentamount_input opponentamount_input" name="Joint_Funds_on_Deposit_Estimated_Value_to_Op3" value="<?php if(isset($drfundsondeposit->Joint_Funds_on_Deposit_Estimated_Value_to_Op3)){ echo $drfundsondeposit->Joint_Funds_on_Deposit_Estimated_Value_to_Op3; } ?>" min="0.00" step="0.01" max="999999.99" readonly="">
                                </div>
                                <!-- end of slider tool -->
                            </div>
                            <div class="col-sm-12 mt-4 4_Joint_fundsondeposit_section" style="display: none;"><h5 class="col-sm-12">Fourth Deposit Account Info</h5>
                                <div class="form-group col-sm-6">
                                    <p class="text-danger 4_Joint_no-state-county-found" style="display: none;">No City, State, County found for this zipcode.</p>
                                    <label for="Joint_Funds_on_Deposit_Institution_ZIP4">Deposit Institution Zip Code?</label>
                                    <input id="Joint_Funds_on_Deposit_Institution_ZIP4" type="text" class="form-control 4_Joint_fundsondeposit_inputs" name="Joint_Funds_on_Deposit_Institution_ZIP4" value="<?php if(isset($drfundsondeposit->Joint_Funds_on_Deposit_Institution_ZIP4)){ echo $drfundsondeposit->Joint_Funds_on_Deposit_Institution_ZIP4; } ?>" data-onload="getCityStateForZip(this, '4', 'Joint');" onkeyup="getCityStateForZip(this, '4', 'Joint');"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_Funds_on_Deposit_Institution_Name4">Name of Deposit Institution?</label>
                                    <input id="Joint_Funds_on_Deposit_Institution_Name4" type="text" class="form-control 4_Joint_fundsondeposit_inputs" name="Joint_Funds_on_Deposit_Institution_Name4" value="<?php if(isset($drfundsondeposit->Joint_Funds_on_Deposit_Institution_Name4)){ echo $drfundsondeposit->Joint_Funds_on_Deposit_Institution_Name4; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_Funds_on_Deposit_Institution_Street_Address4">Deposit Institution Street Address?</label>
                                    <input id="Joint_Funds_on_Deposit_Institution_Street_Address4" type="text" class="form-control 4_Joint_fundsondeposit_inputs" name="Joint_Funds_on_Deposit_Institution_Street_Address4" value="<?php if(isset($drfundsondeposit->Joint_Funds_on_Deposit_Institution_Street_Address4)){ echo $drfundsondeposit->Joint_Funds_on_Deposit_Institution_Street_Address4; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_Funds_on_Deposit_Institution_City4">Deposit Institution City?</label>
                                    <input type="hidden" name="" id="Joint_Funds_on_Deposit_Institution_City4_Value" value="<?php if(isset($drfundsondeposit->Joint_Funds_on_Deposit_Institution_City4)){ echo $drfundsondeposit->Joint_Funds_on_Deposit_Institution_City4; } ?>">
                                    <select id="Joint_Funds_on_Deposit_Institution_City4" name="Joint_Funds_on_Deposit_Institution_City4" class="form-control 4_Joint_city_select">
                                        <option value="">Choose City</option>
                                    </select>   
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_Funds_on_Deposit_Institution_State4">Deposit Institution State?</label>
                                    <input type="hidden" name="" id="Joint_Funds_on_Deposit_Institution_State4_Value" value="<?php if(isset($drfundsondeposit->Joint_Funds_on_Deposit_Institution_State4)){ echo $drfundsondeposit->Joint_Funds_on_Deposit_Institution_State4; } ?>">
                                    <select id="Joint_Funds_on_Deposit_Institution_State4" name="Joint_Funds_on_Deposit_Institution_State4" class="form-control 4_Joint_state_select">
                                        <option value="">Choose State</option>
                                    </select>   
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_Funds_on_Deposit_Institution_Acct_Num4">Account Number?</label>
                                    <input id="Joint_Funds_on_Deposit_Institution_Acct_Num4" type="text" class="form-control 4_Joint_fundsondeposit_inputs" name="Joint_Funds_on_Deposit_Institution_Acct_Num4" value="<?php if(isset($drfundsondeposit->Joint_Funds_on_Deposit_Institution_Acct_Num4)){ echo $drfundsondeposit->Joint_Funds_on_Deposit_Institution_Acct_Num4; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_Funds_on_Deposit_Institution_Current_Balance4">Current Balance?</label>
                                    <input id="Joint_Funds_on_Deposit_Institution_Current_Balance4" type="number" class="form-control 4_Joint_fundsondeposit_inputs" name="Joint_Funds_on_Deposit_Institution_Current_Balance4" value="<?php if(isset($drfundsondeposit->Joint_Funds_on_Deposit_Institution_Current_Balance4)){ echo $drfundsondeposit->Joint_Funds_on_Deposit_Institution_Current_Balance4; } ?>" min="0.00" step="0.01" max="999999.99" onchange="getJointCurrentBalance(this, '4_Joint');" onkeyup="getJointCurrentBalance(this, '4_Joint');"> 
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label for="Joint_Funds_on_Deposit_Estimated_MaritalEquity4">N/A, calculated = Joint_Funds_on_Deposit_Institution_Current_Balance4</label>
                                    <input id="Joint_Funds_on_Deposit_Estimated_MaritalEquity4" type="number" class="form-control 4_Joint_fundsondeposit_inputs" name="Joint_Funds_on_Deposit_Estimated_MaritalEquity4" value="<?php if(isset($drfundsondeposit->Joint_Funds_on_Deposit_Estimated_MaritalEquity4)){ echo $drfundsondeposit->Joint_Funds_on_Deposit_Estimated_MaritalEquity4; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_Funds_on_Deposit_Institution_Yearly_Interest_Dividend4">Yearly Interest?</label>
                                    <input id="Joint_Funds_on_Deposit_Institution_Yearly_Interest_Dividend4" type="number" class="form-control 4_Joint_fundsondeposit_inputs" name="Joint_Funds_on_Deposit_Institution_Yearly_Interest_Dividend4" value="<?php if(isset($drfundsondeposit->Joint_Funds_on_Deposit_Institution_Yearly_Interest_Dividend4)){ echo $drfundsondeposit->Joint_Funds_on_Deposit_Institution_Yearly_Interest_Dividend4; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Does either party claim a sole/separate interest from the other on this fund?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Joint_Funds_on_Deposit_SoleSeparate_Claim4_Yes" name="Joint_Funds_on_Deposit_SoleSeparate_Claim4" value="Yes" <?php if(isset($drfundsondeposit->Joint_Funds_on_Deposit_SoleSeparate_Claim4) && $drfundsondeposit->Joint_Funds_on_Deposit_SoleSeparate_Claim4=='Yes'){ echo "checked"; } ?>> Yes</label>
                                        <label><input type="radio" id="Joint_Funds_on_Deposit_SoleSeparate_Claim4_No" name="Joint_Funds_on_Deposit_SoleSeparate_Claim4" value="No" <?php if(isset($drfundsondeposit->Joint_Funds_on_Deposit_SoleSeparate_Claim4) && $drfundsondeposit->Joint_Funds_on_Deposit_SoleSeparate_Claim4=='No'){ echo "checked"; } ?>> No</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Who claims to own this fund?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Joint_Funds_on_Deposit_SoleSeparate_Party4_Client" name="Joint_Funds_on_Deposit_SoleSeparate_Party4" value="{{$client_name}}" <?php if(isset($drfundsondeposit->Joint_Funds_on_Deposit_SoleSeparate_Party4) && $drfundsondeposit->Joint_Funds_on_Deposit_SoleSeparate_Party4==$client_name){ echo "checked"; } ?>> {{$client_name}}</label>
                                        <label><input type="radio" id="Joint_Funds_on_Deposit_SoleSeparate_Party4_Op" name="Joint_Funds_on_Deposit_SoleSeparate_Party4" value="{{$opponent_name}}" <?php if(isset($drfundsondeposit->Joint_Funds_on_Deposit_SoleSeparate_Party4) && $drfundsondeposit->Joint_Funds_on_Deposit_SoleSeparate_Party4==$opponent_name){ echo "checked"; } ?>> {{$opponent_name}}</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 left-clear">
                                    <label for="Joint_Funds_on_Deposit_SoleSeparate_Grounds4">Why does this person own this fund solely and separately?</label>
                                    <input id="Joint_Funds_on_Deposit_SoleSeparate_Grounds4" type="text" class="form-control 4_Joint_fundsondeposit_inputs" name="Joint_Funds_on_Deposit_SoleSeparate_Grounds4" value="<?php if(isset($drfundsondeposit->Joint_Funds_on_Deposit_SoleSeparate_Grounds4)){ echo $drfundsondeposit->Joint_Funds_on_Deposit_SoleSeparate_Grounds4; } ?>"> 
                                </div>
                                <!-- slider tool -->
                                <div class="form-group col-sm-6 m-auto slider-tool-main">
                                    <div class="row">
                                        <div class="col">{{$client_name}}</div>
                                        <div class="col text-right">{{$opponent_name}}</div>
                                    </div>
                                    <input id="4_Joint_balance_range_selector" type="range" class="form-control slider-tool-input 4_Joint_balance_range_selector" name="" value="<?php if(isset($drfundsondeposit->Joint_Funds_on_Deposit_Percent_Marital_Equity_to_Op4)){ echo $drfundsondeposit->Joint_Funds_on_Deposit_Percent_Marital_Equity_to_Op4; } ?>" min="0.00" step="0.01" max="100" onchange="updateBalanceInput(this.value, '4', 'Joint');">
                                </div>
                                <div class="form-group col-sm-6 m-auto slider-tool-main">
                                    <div class="row justify-content-between">
                                        <div class="col selectorTool">
                                            <div class="left-col">
                                                <div class="client-info 4_Joint_clientpercentage_div clientpercentage_div">
                                                    <?php if(isset($drfundsondeposit->Joint_Funds_on_Deposit_Percent_Marital_Equity_to_Client4)){ echo $drfundsondeposit->Joint_Funds_on_Deposit_Percent_Marital_Equity_to_Client4; } else {
                                                        echo "50.00";
                                                    } ?>%
                                                </div>
                                                <div class="client-info 4_Joint_clientamount_div clientamount_div" style="clear: both;">
                                                    $<?php if(isset($drfundsondeposit->Joint_Funds_on_Deposit_Estimated_Value_to_Client4)){ echo $drfundsondeposit->Joint_Funds_on_Deposit_Estimated_Value_to_Client4; } ?>
                                                </div>
                                            </div>
                                            <label>To {{$client_name}}</label>
                                        </div>                                       
                                        <div class="col selectorTool selectorToolRight">
                                            <label>To {{$opponent_name}}</label>
                                            <div class="left-col right-col">
                                                <div class="client-info 4_Joint_opponentpercentage_div opponentpercentage_div">
                                                    <?php if(isset($drfundsondeposit->Joint_Funds_on_Deposit_Percent_Marital_Equity_to_Op4)){ echo $drfundsondeposit->Joint_Funds_on_Deposit_Percent_Marital_Equity_to_Op4; } else {
                                                        echo "50.00";
                                                    } ?>%
                                                </div>
                                                <div class="client-info 4_Joint_opponentamount_div opponentamount_div" style="clear: both;">
                                                    $<?php if(isset($drfundsondeposit->Joint_Funds_on_Deposit_Estimated_Value_to_Op4)){ echo $drfundsondeposit->Joint_Funds_on_Deposit_Estimated_Value_to_Op4; } ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 m-auto slider-tool-main">
                                    <label></label>
                                    <div class="w-100">
                                        <label><input type="radio" id="4_Joint_Funds_on_Deposit_Estimated_Value_Select" name="4_Joint_Funds_on_Deposit_Estimated_Value_Select_Reset" class="Funds_on_Deposit_Estimated_Value_Select_Reset" value="Save"> Save this Distribution of Deposit Account #4</label>
                                        <label><input type="radio" id="4_Joint_Funds_on_Deposit_Estimated_Value_Reset" name="4_Joint_Funds_on_Deposit_Estimated_Value_Select_Reset" class="Funds_on_Deposit_Estimated_Value_Select_Reset" value="Reset" onclick="resetBalanceInput(this, '4', 'Joint');"> Reset to Default (50%)</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label>{{$client_name}} Deposite Equity Percent</label>
                                    <input id="Joint_Funds_on_Deposit_Percent_Marital_Equity_to_Client4" type="number" class="form-control 4_Joint_clientpercentage_input clientpercentage_input" name="Joint_Funds_on_Deposit_Percent_Marital_Equity_to_Client4" value="<?php if(isset($drfundsondeposit->Joint_Funds_on_Deposit_Percent_Marital_Equity_to_Client4)){ echo $drfundsondeposit->Joint_Funds_on_Deposit_Percent_Marital_Equity_to_Client4; } ?>" min="0.00" step="0.01" max="100" readonly="">
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label>{{$client_name}} Deposite Equity Amount</label>
                                    <input id="Joint_Funds_on_Deposit_Estimated_Value_to_Client4" type="number" class="form-control 4_Joint_clientamount_input clientamount_input" name="Joint_Funds_on_Deposit_Estimated_Value_to_Client4" value="<?php if(isset($drfundsondeposit->Joint_Funds_on_Deposit_Estimated_Value_to_Client4)){ echo $drfundsondeposit->Joint_Funds_on_Deposit_Estimated_Value_to_Client4; } ?>" min="0.00" step="0.01" max="999999.99" readonly="">
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label>{{$opponent_name}} Deposite Equity Percent</label>
                                    <input id="Joint_Funds_on_Deposit_Percent_Marital_Equity_to_Op4" type="number" class="form-control 4_Joint_opponentpercentage_input opponentpercentage_input" name="Joint_Funds_on_Deposit_Percent_Marital_Equity_to_Op4" value="<?php if(isset($drfundsondeposit->Joint_Funds_on_Deposit_Percent_Marital_Equity_to_Op4)){ echo $drfundsondeposit->Joint_Funds_on_Deposit_Percent_Marital_Equity_to_Op4; } ?>" min="0.00" step="0.01" max="100" readonly="">
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label>{{$opponent_name}} Deposite Equity Amount</label>
                                    <input id="Joint_Funds_on_Deposit_Estimated_Value_to_Op4" type="number" class="form-control 4_Joint_opponentamount_input opponentamount_input" name="Joint_Funds_on_Deposit_Estimated_Value_to_Op4" value="<?php if(isset($drfundsondeposit->Joint_Funds_on_Deposit_Estimated_Value_to_Op4)){ echo $drfundsondeposit->Joint_Funds_on_Deposit_Estimated_Value_to_Op4; } ?>" min="0.00" step="0.01" max="999999.99" readonly="">
                                </div>
                                <!-- end of slider tool -->
                            </div>
                            <div class="col-sm-12 mt-4 5_Joint_fundsondeposit_section" style="display: none;"><h5 class="col-sm-12">Fifth Deposit Account Info</h5>
                                <div class="form-group col-sm-6">
                                    <p class="text-danger 5_Joint_no-state-county-found" style="display: none;">No City, State, County found for this zipcode.</p>
                                    <label for="Joint_Funds_on_Deposit_Institution_ZIP5">Deposit Institution Zip Code?</label>
                                    <input id="Joint_Funds_on_Deposit_Institution_ZIP5" type="text" class="form-control 5_Joint_fundsondeposit_inputs" name="Joint_Funds_on_Deposit_Institution_ZIP5" value="<?php if(isset($drfundsondeposit->Joint_Funds_on_Deposit_Institution_ZIP5)){ echo $drfundsondeposit->Joint_Funds_on_Deposit_Institution_ZIP5; } ?>" data-onload="getCityStateForZip(this, '5', 'Joint');" onkeyup="getCityStateForZip(this, '5', 'Joint');"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_Funds_on_Deposit_Institution_Name5">Name of Deposit Institution?</label>
                                    <input id="Joint_Funds_on_Deposit_Institution_Name5" type="text" class="form-control 5_Joint_fundsondeposit_inputs" name="Joint_Funds_on_Deposit_Institution_Name5" value="<?php if(isset($drfundsondeposit->Joint_Funds_on_Deposit_Institution_Name5)){ echo $drfundsondeposit->Joint_Funds_on_Deposit_Institution_Name5; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_Funds_on_Deposit_Institution_Street_Address5">Deposit Institution Street Address?</label>
                                    <input id="Joint_Funds_on_Deposit_Institution_Street_Address5" type="text" class="form-control 5_Joint_fundsondeposit_inputs" name="Joint_Funds_on_Deposit_Institution_Street_Address5" value="<?php if(isset($drfundsondeposit->Joint_Funds_on_Deposit_Institution_Street_Address5)){ echo $drfundsondeposit->Joint_Funds_on_Deposit_Institution_Street_Address5; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_Funds_on_Deposit_Institution_City5">Deposit Institution City?</label>
                                    <input type="hidden" name="" id="Joint_Funds_on_Deposit_Institution_City5_Value" value="<?php if(isset($drfundsondeposit->Joint_Funds_on_Deposit_Institution_City5)){ echo $drfundsondeposit->Joint_Funds_on_Deposit_Institution_City5; } ?>">
                                    <select id="Joint_Funds_on_Deposit_Institution_City5" name="Joint_Funds_on_Deposit_Institution_City5" class="form-control 5_Joint_city_select">
                                        <option value="">Choose City</option>
                                    </select>   
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_Funds_on_Deposit_Institution_State5">Deposit Institution State?</label>
                                    <input type="hidden" name="" id="Joint_Funds_on_Deposit_Institution_State5_Value" value="<?php if(isset($drfundsondeposit->Joint_Funds_on_Deposit_Institution_State5)){ echo $drfundsondeposit->Joint_Funds_on_Deposit_Institution_State5; } ?>">
                                    <select id="Joint_Funds_on_Deposit_Institution_State5" name="Joint_Funds_on_Deposit_Institution_State5" class="form-control 5_Joint_state_select">
                                        <option value="">Choose State</option>
                                    </select>   
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_Funds_on_Deposit_Institution_Acct_Num5">Account Number?</label>
                                    <input id="Joint_Funds_on_Deposit_Institution_Acct_Num5" type="text" class="form-control 5_Joint_fundsondeposit_inputs" name="Joint_Funds_on_Deposit_Institution_Acct_Num5" value="<?php if(isset($drfundsondeposit->Joint_Funds_on_Deposit_Institution_Acct_Num5)){ echo $drfundsondeposit->Joint_Funds_on_Deposit_Institution_Acct_Num5; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_Funds_on_Deposit_Institution_Current_Balance5">Current Balance?</label>
                                    <input id="Joint_Funds_on_Deposit_Institution_Current_Balance5" type="number" class="form-control 5_Joint_fundsondeposit_inputs" name="Joint_Funds_on_Deposit_Institution_Current_Balance5" value="<?php if(isset($drfundsondeposit->Joint_Funds_on_Deposit_Institution_Current_Balance5)){ echo $drfundsondeposit->Joint_Funds_on_Deposit_Institution_Current_Balance5; } ?>" min="0.00" step="0.01" max="999999.99" onchange="getJointCurrentBalance(this, '5_Joint');" onkeyup="getJointCurrentBalance(this, '5_Joint');"> 
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label for="Joint_Funds_on_Deposit_Estimated_MaritalEquity5">N/A, calculated = Joint_Funds_on_Deposit_Institution_Current_Balance5</label>
                                    <input id="Joint_Funds_on_Deposit_Estimated_MaritalEquity5" type="number" class="form-control 5_Joint_fundsondeposit_inputs" name="Joint_Funds_on_Deposit_Estimated_MaritalEquity5" value="<?php if(isset($drfundsondeposit->Joint_Funds_on_Deposit_Estimated_MaritalEquity5)){ echo $drfundsondeposit->Joint_Funds_on_Deposit_Estimated_MaritalEquity5; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_Funds_on_Deposit_Institution_Yearly_Interest_Dividend5">Yearly Interest?</label>
                                    <input id="Joint_Funds_on_Deposit_Institution_Yearly_Interest_Dividend5" type="number" class="form-control 5_Joint_fundsondeposit_inputs" name="Joint_Funds_on_Deposit_Institution_Yearly_Interest_Dividend5" value="<?php if(isset($drfundsondeposit->Joint_Funds_on_Deposit_Institution_Yearly_Interest_Dividend5)){ echo $drfundsondeposit->Joint_Funds_on_Deposit_Institution_Yearly_Interest_Dividend5; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Does either party claim a sole/separate interest from the other on this fund?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Joint_Funds_on_Deposit_SoleSeparate_Claim5_Yes" name="Joint_Funds_on_Deposit_SoleSeparate_Claim5" value="Yes" <?php if(isset($drfundsondeposit->Joint_Funds_on_Deposit_SoleSeparate_Claim5) && $drfundsondeposit->Joint_Funds_on_Deposit_SoleSeparate_Claim5=='Yes'){ echo "checked"; } ?>> Yes</label>
                                        <label><input type="radio" id="Joint_Funds_on_Deposit_SoleSeparate_Claim5_No" name="Joint_Funds_on_Deposit_SoleSeparate_Claim5" value="No" <?php if(isset($drfundsondeposit->Joint_Funds_on_Deposit_SoleSeparate_Claim5) && $drfundsondeposit->Joint_Funds_on_Deposit_SoleSeparate_Claim5=='No'){ echo "checked"; } ?>> No</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Who claims to own this fund?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Joint_Funds_on_Deposit_SoleSeparate_Party5_Client" name="Joint_Funds_on_Deposit_SoleSeparate_Party5" value="{{$client_name}}" <?php if(isset($drfundsondeposit->Joint_Funds_on_Deposit_SoleSeparate_Party5) && $drfundsondeposit->Joint_Funds_on_Deposit_SoleSeparate_Party5==$client_name){ echo "checked"; } ?>> {{$client_name}}</label>
                                        <label><input type="radio" id="Joint_Funds_on_Deposit_SoleSeparate_Party5_Op" name="Joint_Funds_on_Deposit_SoleSeparate_Party5" value="{{$opponent_name}}" <?php if(isset($drfundsondeposit->Joint_Funds_on_Deposit_SoleSeparate_Party5) && $drfundsondeposit->Joint_Funds_on_Deposit_SoleSeparate_Party5==$opponent_name){ echo "checked"; } ?>> {{$opponent_name}}</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 left-clear">
                                    <label for="Joint_Funds_on_Deposit_SoleSeparate_Grounds5">Why does this person own this fund solely and separately?</label>
                                    <input id="Joint_Funds_on_Deposit_SoleSeparate_Grounds5" type="text" class="form-control 5_Joint_fundsondeposit_inputs" name="Joint_Funds_on_Deposit_SoleSeparate_Grounds5" value="<?php if(isset($drfundsondeposit->Joint_Funds_on_Deposit_SoleSeparate_Grounds5)){ echo $drfundsondeposit->Joint_Funds_on_Deposit_SoleSeparate_Grounds5; } ?>"> 
                                </div>
                                <!-- slider tool -->
                                <div class="form-group col-sm-6 m-auto slider-tool-main">
                                    <div class="row">
                                        <div class="col">{{$client_name}}</div>
                                        <div class="col text-right">{{$opponent_name}}</div>
                                    </div>
                                    <input id="5_Joint_balance_range_selector" type="range" class="form-control slider-tool-input 5_Joint_balance_range_selector" name="" value="<?php if(isset($drfundsondeposit->Joint_Funds_on_Deposit_Percent_Marital_Equity_to_Op5)){ echo $drfundsondeposit->Joint_Funds_on_Deposit_Percent_Marital_Equity_to_Op5; } ?>" min="0.00" step="0.01" max="100" onchange="updateBalanceInput(this.value, '5', 'Joint');">
                                </div>
                                <div class="form-group col-sm-6 m-auto slider-tool-main">
                                    <div class="row justify-content-between">
                                        <div class="col selectorTool">
                                            <div class="left-col">
                                                <div class="client-info 5_Joint_clientpercentage_div clientpercentage_div">
                                                    <?php if(isset($drfundsondeposit->Joint_Funds_on_Deposit_Percent_Marital_Equity_to_Client5)){ echo $drfundsondeposit->Joint_Funds_on_Deposit_Percent_Marital_Equity_to_Client5; } else {
                                                        echo "50.00";
                                                    } ?>%
                                                </div>
                                                <div class="client-info 5_Joint_clientamount_div clientamount_div" style="clear: both;">
                                                    $<?php if(isset($drfundsondeposit->Joint_Funds_on_Deposit_Estimated_Value_to_Client5)){ echo $drfundsondeposit->Joint_Funds_on_Deposit_Estimated_Value_to_Client5; } ?>
                                                </div>
                                            </div>
                                            <label>To {{$client_name}}</label>
                                        </div>                                       
                                        <div class="col selectorTool selectorToolRight">
                                            <label>To {{$opponent_name}}</label>
                                            <div class="left-col right-col">
                                                <div class="client-info 5_Joint_opponentpercentage_div opponentpercentage_div">
                                                    <?php if(isset($drfundsondeposit->Joint_Funds_on_Deposit_Percent_Marital_Equity_to_Op5)){ echo $drfundsondeposit->Joint_Funds_on_Deposit_Percent_Marital_Equity_to_Op5; } else {
                                                        echo "50.00";
                                                    } ?>%
                                                </div>
                                                <div class="client-info 5_Joint_opponentamount_div opponentamount_div" style="clear: both;">
                                                    $<?php if(isset($drfundsondeposit->Joint_Funds_on_Deposit_Estimated_Value_to_Op5)){ echo $drfundsondeposit->Joint_Funds_on_Deposit_Estimated_Value_to_Op5; } ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 m-auto slider-tool-main">
                                    <label></label>
                                    <div class="w-100">
                                        <label><input type="radio" id="5_Joint_Funds_on_Deposit_Estimated_Value_Select" name="5_Joint_Funds_on_Deposit_Estimated_Value_Select_Reset" class="Funds_on_Deposit_Estimated_Value_Select_Reset" value="Save"> Save this Distribution of Deposit Account #5</label>
                                        <label><input type="radio" id="5_Joint_Funds_on_Deposit_Estimated_Value_Reset" name="5_Joint_Funds_on_Deposit_Estimated_Value_Select_Reset" class="Funds_on_Deposit_Estimated_Value_Select_Reset" value="Reset" onclick="resetBalanceInput(this, '5', 'Joint');"> Reset to Default (50%)</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label>{{$client_name}} Deposite Equity Percent</label>
                                    <input id="Joint_Funds_on_Deposit_Percent_Marital_Equity_to_Client5" type="number" class="form-control 5_Joint_clientpercentage_input clientpercentage_input" name="Joint_Funds_on_Deposit_Percent_Marital_Equity_to_Client5" value="<?php if(isset($drfundsondeposit->Joint_Funds_on_Deposit_Percent_Marital_Equity_to_Client5)){ echo $drfundsondeposit->Joint_Funds_on_Deposit_Percent_Marital_Equity_to_Client5; } ?>" min="0.00" step="0.01" max="100" readonly="">
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label>{{$client_name}} Deposite Equity Amount</label>
                                    <input id="Joint_Funds_on_Deposit_Estimated_Value_to_Client5" type="number" class="form-control 5_Joint_clientamount_input clientamount_input" name="Joint_Funds_on_Deposit_Estimated_Value_to_Client5" value="<?php if(isset($drfundsondeposit->Joint_Funds_on_Deposit_Estimated_Value_to_Client5)){ echo $drfundsondeposit->Joint_Funds_on_Deposit_Estimated_Value_to_Client5; } ?>" min="0.00" step="0.01" max="999999.99" readonly="">
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label>{{$opponent_name}} Deposite Equity Percent</label>
                                    <input id="Joint_Funds_on_Deposit_Percent_Marital_Equity_to_Op5" type="number" class="form-control 5_Joint_opponentpercentage_input opponentpercentage_input" name="Joint_Funds_on_Deposit_Percent_Marital_Equity_to_Op5" value="<?php if(isset($drfundsondeposit->Joint_Funds_on_Deposit_Percent_Marital_Equity_to_Op5)){ echo $drfundsondeposit->Joint_Funds_on_Deposit_Percent_Marital_Equity_to_Op5; } ?>" min="0.00" step="0.01" max="100" readonly="">
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label>{{$opponent_name}} Deposite Equity Amount</label>
                                    <input id="Joint_Funds_on_Deposit_Estimated_Value_to_Op5" type="number" class="form-control 5_Joint_opponentamount_input opponentamount_input" name="Joint_Funds_on_Deposit_Estimated_Value_to_Op5" value="<?php if(isset($drfundsondeposit->Joint_Funds_on_Deposit_Estimated_Value_to_Op5)){ echo $drfundsondeposit->Joint_Funds_on_Deposit_Estimated_Value_to_Op5; } ?>" min="0.00" step="0.01" max="999999.99" readonly="">
                                </div>
                                <!-- end of slider tool -->
                            </div>
                            <div class="col-sm-12 mt-4 6_Joint_fundsondeposit_section" style="display: none;"><h5 class="col-sm-12">Sixth Deposit Account Info</h5>
                                <div class="form-group col-sm-6">
                                    <p class="text-danger 6_Joint_no-state-county-found" style="display: none;">No City, State, County found for this zipcode.</p>
                                    <label for="Joint_Funds_on_Deposit_Institution_ZIP6">Deposit Institution Zip Code?</label>
                                    <input id="Joint_Funds_on_Deposit_Institution_ZIP6" type="text" class="form-control 6_Joint_fundsondeposit_inputs" name="Joint_Funds_on_Deposit_Institution_ZIP6" value="<?php if(isset($drfundsondeposit->Joint_Funds_on_Deposit_Institution_ZIP6)){ echo $drfundsondeposit->Joint_Funds_on_Deposit_Institution_ZIP6; } ?>" data-onload="getCityStateForZip(this, '6', 'Joint');" onkeyup="getCityStateForZip(this, '6', 'Joint');"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_Funds_on_Deposit_Institution_Name6">Name of Deposit Institution?</label>
                                    <input id="Joint_Funds_on_Deposit_Institution_Name6" type="text" class="form-control 6_Joint_fundsondeposit_inputs" name="Joint_Funds_on_Deposit_Institution_Name6" value="<?php if(isset($drfundsondeposit->Joint_Funds_on_Deposit_Institution_Name6)){ echo $drfundsondeposit->Joint_Funds_on_Deposit_Institution_Name6; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_Funds_on_Deposit_Institution_Street_Address6">Deposit Institution Street Address?</label>
                                    <input id="Joint_Funds_on_Deposit_Institution_Street_Address6" type="text" class="form-control 6_Joint_fundsondeposit_inputs" name="Joint_Funds_on_Deposit_Institution_Street_Address6" value="<?php if(isset($drfundsondeposit->Joint_Funds_on_Deposit_Institution_Street_Address6)){ echo $drfundsondeposit->Joint_Funds_on_Deposit_Institution_Street_Address6; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_Funds_on_Deposit_Institution_City6">Deposit Institution City?</label>
                                    <input type="hidden" name="" id="Joint_Funds_on_Deposit_Institution_City6_Value" value="<?php if(isset($drfundsondeposit->Joint_Funds_on_Deposit_Institution_City6)){ echo $drfundsondeposit->Joint_Funds_on_Deposit_Institution_City6; } ?>">
                                    <select id="Joint_Funds_on_Deposit_Institution_City6" name="Joint_Funds_on_Deposit_Institution_City6" class="form-control 6_Joint_city_select">
                                        <option value="">Choose City</option>
                                    </select>   
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_Funds_on_Deposit_Institution_State6">Deposit Institution State?</label>
                                    <input type="hidden" name="" id="Joint_Funds_on_Deposit_Institution_State6_Value" value="<?php if(isset($drfundsondeposit->Joint_Funds_on_Deposit_Institution_State6)){ echo $drfundsondeposit->Joint_Funds_on_Deposit_Institution_State6; } ?>">
                                    <select id="Joint_Funds_on_Deposit_Institution_State6" name="Joint_Funds_on_Deposit_Institution_State6" class="form-control 6_Joint_state_select">
                                        <option value="">Choose State</option>
                                    </select>   
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_Funds_on_Deposit_Institution_Acct_Num6">Account Number?</label>
                                    <input id="Joint_Funds_on_Deposit_Institution_Acct_Num6" type="text" class="form-control 6_Joint_fundsondeposit_inputs" name="Joint_Funds_on_Deposit_Institution_Acct_Num6" value="<?php if(isset($drfundsondeposit->Joint_Funds_on_Deposit_Institution_Acct_Num6)){ echo $drfundsondeposit->Joint_Funds_on_Deposit_Institution_Acct_Num6; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_Funds_on_Deposit_Institution_Current_Balance6">Current Balance?</label>
                                    <input id="Joint_Funds_on_Deposit_Institution_Current_Balance6" type="number" class="form-control 6_Joint_fundsondeposit_inputs" name="Joint_Funds_on_Deposit_Institution_Current_Balance6" value="<?php if(isset($drfundsondeposit->Joint_Funds_on_Deposit_Institution_Current_Balance6)){ echo $drfundsondeposit->Joint_Funds_on_Deposit_Institution_Current_Balance6; } ?>" min="0.00" step="0.01" max="999999.99" onchange="getJointCurrentBalance(this, '6_Joint');" onkeyup="getJointCurrentBalance(this, '6_Joint');"> 
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label for="Joint_Funds_on_Deposit_Estimated_MaritalEquity6">N/A, calculated = Joint_Funds_on_Deposit_Institution_Current_Balance6</label>
                                    <input id="Joint_Funds_on_Deposit_Estimated_MaritalEquity6" type="number" class="form-control 6_Joint_fundsondeposit_inputs" name="Joint_Funds_on_Deposit_Estimated_MaritalEquity6" value="<?php if(isset($drfundsondeposit->Joint_Funds_on_Deposit_Estimated_MaritalEquity6)){ echo $drfundsondeposit->Joint_Funds_on_Deposit_Estimated_MaritalEquity6; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_Funds_on_Deposit_Institution_Yearly_Interest_Dividend6">Yearly Interest?</label>
                                    <input id="Joint_Funds_on_Deposit_Institution_Yearly_Interest_Dividend6" type="number" class="form-control 6_Joint_fundsondeposit_inputs" name="Joint_Funds_on_Deposit_Institution_Yearly_Interest_Dividend6" value="<?php if(isset($drfundsondeposit->Joint_Funds_on_Deposit_Institution_Yearly_Interest_Dividend6)){ echo $drfundsondeposit->Joint_Funds_on_Deposit_Institution_Yearly_Interest_Dividend6; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Does either party claim a sole/separate interest from the other on this fund?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Joint_Funds_on_Deposit_SoleSeparate_Claim6_Yes" name="Joint_Funds_on_Deposit_SoleSeparate_Claim6" value="Yes" <?php if(isset($drfundsondeposit->Joint_Funds_on_Deposit_SoleSeparate_Claim6) && $drfundsondeposit->Joint_Funds_on_Deposit_SoleSeparate_Claim6=='Yes'){ echo "checked"; } ?>> Yes</label>
                                        <label><input type="radio" id="Joint_Funds_on_Deposit_SoleSeparate_Claim6_No" name="Joint_Funds_on_Deposit_SoleSeparate_Claim6" value="No" <?php if(isset($drfundsondeposit->Joint_Funds_on_Deposit_SoleSeparate_Claim6) && $drfundsondeposit->Joint_Funds_on_Deposit_SoleSeparate_Claim6=='No'){ echo "checked"; } ?>> No</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Who claims to own this fund?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Joint_Funds_on_Deposit_SoleSeparate_Party6_Client" name="Joint_Funds_on_Deposit_SoleSeparate_Party6" value="{{$client_name}}" <?php if(isset($drfundsondeposit->Joint_Funds_on_Deposit_SoleSeparate_Party6) && $drfundsondeposit->Joint_Funds_on_Deposit_SoleSeparate_Party6==$client_name){ echo "checked"; } ?>> {{$client_name}}</label>
                                        <label><input type="radio" id="Joint_Funds_on_Deposit_SoleSeparate_Party6_Op" name="Joint_Funds_on_Deposit_SoleSeparate_Party6" value="{{$opponent_name}}" <?php if(isset($drfundsondeposit->Joint_Funds_on_Deposit_SoleSeparate_Party6) && $drfundsondeposit->Joint_Funds_on_Deposit_SoleSeparate_Party6==$opponent_name){ echo "checked"; } ?>> {{$opponent_name}}</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 left-clear">
                                    <label for="Joint_Funds_on_Deposit_SoleSeparate_Grounds6">Why does this person own this fund solely and separately?</label>
                                    <input id="Joint_Funds_on_Deposit_SoleSeparate_Grounds6" type="text" class="form-control 6_Joint_fundsondeposit_inputs" name="Joint_Funds_on_Deposit_SoleSeparate_Grounds6" value="<?php if(isset($drfundsondeposit->Joint_Funds_on_Deposit_SoleSeparate_Grounds6)){ echo $drfundsondeposit->Joint_Funds_on_Deposit_SoleSeparate_Grounds6; } ?>"> 
                                </div>
                                <!-- slider tool -->
                                <div class="form-group col-sm-6 m-auto slider-tool-main">
                                    <div class="row">
                                        <div class="col">{{$client_name}}</div>
                                        <div class="col text-right">{{$opponent_name}}</div>
                                    </div>
                                    <input id="6_Joint_balance_range_selector" type="range" class="form-control slider-tool-input 6_Joint_balance_range_selector" name="" value="<?php if(isset($drfundsondeposit->Joint_Funds_on_Deposit_Percent_Marital_Equity_to_Op6)){ echo $drfundsondeposit->Joint_Funds_on_Deposit_Percent_Marital_Equity_to_Op6; } ?>" min="0.00" step="0.01" max="100" onchange="updateBalanceInput(this.value, '6', 'Joint');">
                                </div>
                                <div class="form-group col-sm-6 m-auto slider-tool-main">
                                    <div class="row justify-content-between">
                                        <div class="col selectorTool">
                                            <div class="left-col">
                                                <div class="client-info 6_Joint_clientpercentage_div clientpercentage_div">
                                                    <?php if(isset($drfundsondeposit->Joint_Funds_on_Deposit_Percent_Marital_Equity_to_Client6)){ echo $drfundsondeposit->Joint_Funds_on_Deposit_Percent_Marital_Equity_to_Client6; } else {
                                                        echo "50.00";
                                                    } ?>%
                                                </div>
                                                <div class="client-info 6_Joint_clientamount_div clientamount_div" style="clear: both;">
                                                    $<?php if(isset($drfundsondeposit->Joint_Funds_on_Deposit_Estimated_Value_to_Client6)){ echo $drfundsondeposit->Joint_Funds_on_Deposit_Estimated_Value_to_Client6; } ?>
                                                </div>
                                            </div>
                                            <label>To {{$client_name}}</label>
                                        </div>                                       
                                        <div class="col selectorTool selectorToolRight">
                                            <label>To {{$opponent_name}}</label>
                                            <div class="left-col right-col">
                                                <div class="client-info 6_Joint_opponentpercentage_div opponentpercentage_div">
                                                    <?php if(isset($drfundsondeposit->Joint_Funds_on_Deposit_Percent_Marital_Equity_to_Op6)){ echo $drfundsondeposit->Joint_Funds_on_Deposit_Percent_Marital_Equity_to_Op6; } else {
                                                        echo "50.00";
                                                    } ?>%
                                                </div>
                                                <div class="client-info 6_Joint_opponentamount_div opponentamount_div" style="clear: both;">
                                                    $<?php if(isset($drfundsondeposit->Joint_Funds_on_Deposit_Estimated_Value_to_Op6)){ echo $drfundsondeposit->Joint_Funds_on_Deposit_Estimated_Value_to_Op6; } ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 m-auto slider-tool-main">
                                    <label></label>
                                    <div class="w-100">
                                        <label><input type="radio" id="6_Joint_Funds_on_Deposit_Estimated_Value_Select" name="6_Joint_Funds_on_Deposit_Estimated_Value_Select_Reset" class="Funds_on_Deposit_Estimated_Value_Select_Reset" value="Save"> Save this Distribution of Deposit Account #6</label>
                                        <label><input type="radio" id="6_Joint_Funds_on_Deposit_Estimated_Value_Reset" name="6_Joint_Funds_on_Deposit_Estimated_Value_Select_Reset" class="Funds_on_Deposit_Estimated_Value_Select_Reset" value="Reset" onclick="resetBalanceInput(this, '6', 'Joint');"> Reset to Default (50%)</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label>{{$client_name}} Deposite Equity Percent</label>
                                    <input id="Joint_Funds_on_Deposit_Percent_Marital_Equity_to_Client6" type="number" class="form-control 6_Joint_clientpercentage_input clientpercentage_input" name="Joint_Funds_on_Deposit_Percent_Marital_Equity_to_Client6" value="<?php if(isset($drfundsondeposit->Joint_Funds_on_Deposit_Percent_Marital_Equity_to_Client6)){ echo $drfundsondeposit->Joint_Funds_on_Deposit_Percent_Marital_Equity_to_Client6; } ?>" min="0.00" step="0.01" max="100" readonly="">
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label>{{$client_name}} Deposite Equity Amount</label>
                                    <input id="Joint_Funds_on_Deposit_Estimated_Value_to_Client6" type="number" class="form-control 6_Joint_clientamount_input clientamount_input" name="Joint_Funds_on_Deposit_Estimated_Value_to_Client6" value="<?php if(isset($drfundsondeposit->Joint_Funds_on_Deposit_Estimated_Value_to_Client6)){ echo $drfundsondeposit->Joint_Funds_on_Deposit_Estimated_Value_to_Client6; } ?>" min="0.00" step="0.01" max="999999.99" readonly="">
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label>{{$opponent_name}} Deposite Equity Percent</label>
                                    <input id="Joint_Funds_on_Deposit_Percent_Marital_Equity_to_Op6" type="number" class="form-control 6_Joint_opponentpercentage_input opponentpercentage_input" name="Joint_Funds_on_Deposit_Percent_Marital_Equity_to_Op6" value="<?php if(isset($drfundsondeposit->Joint_Funds_on_Deposit_Percent_Marital_Equity_to_Op6)){ echo $drfundsondeposit->Joint_Funds_on_Deposit_Percent_Marital_Equity_to_Op6; } ?>" min="0.00" step="0.01" max="100" readonly="">
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label>{{$opponent_name}} Deposite Equity Amount</label>
                                    <input id="Joint_Funds_on_Deposit_Estimated_Value_to_Op6" type="number" class="form-control 6_Joint_opponentamount_input opponentamount_input" name="Joint_Funds_on_Deposit_Estimated_Value_to_Op6" value="<?php if(isset($drfundsondeposit->Joint_Funds_on_Deposit_Estimated_Value_to_Op6)){ echo $drfundsondeposit->Joint_Funds_on_Deposit_Estimated_Value_to_Op6; } ?>" min="0.00" step="0.01" max="999999.99" readonly="">
                                </div>
                                <!-- end of slider tool -->
                            </div>
                            <div class="col-sm-12 mt-4 7_Joint_fundsondeposit_section" style="display: none;"><h5 class="col-sm-12">Seventh Deposit Account Info</h5>
                                <div class="form-group col-sm-6">
                                    <p class="text-danger 7_Joint_no-state-county-found" style="display: none;">No City, State, County found for this zipcode.</p>
                                    <label for="Joint_Funds_on_Deposit_Institution_ZIP7">Deposit Institution Zip Code?</label>
                                    <input id="Joint_Funds_on_Deposit_Institution_ZIP7" type="text" class="form-control 7_Joint_fundsondeposit_inputs" name="Joint_Funds_on_Deposit_Institution_ZIP7" value="<?php if(isset($drfundsondeposit->Joint_Funds_on_Deposit_Institution_ZIP7)){ echo $drfundsondeposit->Joint_Funds_on_Deposit_Institution_ZIP7; } ?>" data-onload="getCityStateForZip(this, '7', 'Joint');" onkeyup="getCityStateForZip(this, '7', 'Joint');"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_Funds_on_Deposit_Institution_Name7">Name of Deposit Institution?</label>
                                    <input id="Joint_Funds_on_Deposit_Institution_Name7" type="text" class="form-control 7_Joint_fundsondeposit_inputs" name="Joint_Funds_on_Deposit_Institution_Name7" value="<?php if(isset($drfundsondeposit->Joint_Funds_on_Deposit_Institution_Name7)){ echo $drfundsondeposit->Joint_Funds_on_Deposit_Institution_Name7; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_Funds_on_Deposit_Institution_Street_Address7">Deposit Institution Street Address?</label>
                                    <input id="Joint_Funds_on_Deposit_Institution_Street_Address7" type="text" class="form-control 7_Joint_fundsondeposit_inputs" name="Joint_Funds_on_Deposit_Institution_Street_Address7" value="<?php if(isset($drfundsondeposit->Joint_Funds_on_Deposit_Institution_Street_Address7)){ echo $drfundsondeposit->Joint_Funds_on_Deposit_Institution_Street_Address7; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_Funds_on_Deposit_Institution_City7">Deposit Institution City?</label>
                                    <input type="hidden" name="" id="Joint_Funds_on_Deposit_Institution_City7_Value" value="<?php if(isset($drfundsondeposit->Joint_Funds_on_Deposit_Institution_City7)){ echo $drfundsondeposit->Joint_Funds_on_Deposit_Institution_City7; } ?>">
                                    <select id="Joint_Funds_on_Deposit_Institution_City7" name="Joint_Funds_on_Deposit_Institution_City7" class="form-control 7_Joint_city_select">
                                        <option value="">Choose City</option>
                                    </select>   
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_Funds_on_Deposit_Institution_State7">Deposit Institution State?</label>
                                    <input type="hidden" name="" id="Joint_Funds_on_Deposit_Institution_State7_Value" value="<?php if(isset($drfundsondeposit->Joint_Funds_on_Deposit_Institution_State7)){ echo $drfundsondeposit->Joint_Funds_on_Deposit_Institution_State7; } ?>">
                                    <select id="Joint_Funds_on_Deposit_Institution_State7" name="Joint_Funds_on_Deposit_Institution_State7" class="form-control 7_Joint_state_select">
                                        <option value="">Choose State</option>
                                    </select>   
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_Funds_on_Deposit_Institution_Acct_Num7">Account Number?</label>
                                    <input id="Joint_Funds_on_Deposit_Institution_Acct_Num7" type="text" class="form-control 7_Joint_fundsondeposit_inputs" name="Joint_Funds_on_Deposit_Institution_Acct_Num7" value="<?php if(isset($drfundsondeposit->Joint_Funds_on_Deposit_Institution_Acct_Num7)){ echo $drfundsondeposit->Joint_Funds_on_Deposit_Institution_Acct_Num7; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_Funds_on_Deposit_Institution_Current_Balance7">Current Balance?</label>
                                    <input id="Joint_Funds_on_Deposit_Institution_Current_Balance7" type="number" class="form-control 7_Joint_fundsondeposit_inputs" name="Joint_Funds_on_Deposit_Institution_Current_Balance7" value="<?php if(isset($drfundsondeposit->Joint_Funds_on_Deposit_Institution_Current_Balance7)){ echo $drfundsondeposit->Joint_Funds_on_Deposit_Institution_Current_Balance7; } ?>" min="0.00" step="0.01" max="999999.99" onchange="getJointCurrentBalance(this, '7_Joint');" onkeyup="getJointCurrentBalance(this, '7_Joint');"> 
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label for="Joint_Funds_on_Deposit_Estimated_MaritalEquity7">N/A, calculated = Joint_Funds_on_Deposit_Institution_Current_Balance7</label>
                                    <input id="Joint_Funds_on_Deposit_Estimated_MaritalEquity7" type="number" class="form-control 7_Joint_fundsondeposit_inputs" name="Joint_Funds_on_Deposit_Estimated_MaritalEquity7" value="<?php if(isset($drfundsondeposit->Joint_Funds_on_Deposit_Estimated_MaritalEquity7)){ echo $drfundsondeposit->Joint_Funds_on_Deposit_Estimated_MaritalEquity7; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_Funds_on_Deposit_Institution_Yearly_Interest_Dividend7">Yearly Interest?</label>
                                    <input id="Joint_Funds_on_Deposit_Institution_Yearly_Interest_Dividend7" type="number" class="form-control 7_Joint_fundsondeposit_inputs" name="Joint_Funds_on_Deposit_Institution_Yearly_Interest_Dividend7" value="<?php if(isset($drfundsondeposit->Joint_Funds_on_Deposit_Institution_Yearly_Interest_Dividend7)){ echo $drfundsondeposit->Joint_Funds_on_Deposit_Institution_Yearly_Interest_Dividend7; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Does either party claim a sole/separate interest from the other on this fund?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Joint_Funds_on_Deposit_SoleSeparate_Claim7_Yes" name="Joint_Funds_on_Deposit_SoleSeparate_Claim7" value="Yes" <?php if(isset($drfundsondeposit->Joint_Funds_on_Deposit_SoleSeparate_Claim7) && $drfundsondeposit->Joint_Funds_on_Deposit_SoleSeparate_Claim7=='Yes'){ echo "checked"; } ?>> Yes</label>
                                        <label><input type="radio" id="Joint_Funds_on_Deposit_SoleSeparate_Claim7_No" name="Joint_Funds_on_Deposit_SoleSeparate_Claim7" value="No" <?php if(isset($drfundsondeposit->Joint_Funds_on_Deposit_SoleSeparate_Claim7) && $drfundsondeposit->Joint_Funds_on_Deposit_SoleSeparate_Claim7=='No'){ echo "checked"; } ?>> No</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Who claims to own this fund?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Joint_Funds_on_Deposit_SoleSeparate_Party7_Client" name="Joint_Funds_on_Deposit_SoleSeparate_Party7" value="{{$client_name}}" <?php if(isset($drfundsondeposit->Joint_Funds_on_Deposit_SoleSeparate_Party7) && $drfundsondeposit->Joint_Funds_on_Deposit_SoleSeparate_Party7==$client_name){ echo "checked"; } ?>> {{$client_name}}</label>
                                        <label><input type="radio" id="Joint_Funds_on_Deposit_SoleSeparate_Party7_Op" name="Joint_Funds_on_Deposit_SoleSeparate_Party7" value="{{$opponent_name}}" <?php if(isset($drfundsondeposit->Joint_Funds_on_Deposit_SoleSeparate_Party7) && $drfundsondeposit->Joint_Funds_on_Deposit_SoleSeparate_Party7==$opponent_name){ echo "checked"; } ?>> {{$opponent_name}}</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 left-clear">
                                    <label for="Joint_Funds_on_Deposit_SoleSeparate_Grounds7">Why does this person own this fund solely and separately?</label>
                                    <input id="Joint_Funds_on_Deposit_SoleSeparate_Grounds7" type="text" class="form-control 7_Joint_fundsondeposit_inputs" name="Joint_Funds_on_Deposit_SoleSeparate_Grounds7" value="<?php if(isset($drfundsondeposit->Joint_Funds_on_Deposit_SoleSeparate_Grounds7)){ echo $drfundsondeposit->Joint_Funds_on_Deposit_SoleSeparate_Grounds7; } ?>"> 
                                </div>
                                <!-- slider tool -->
                                <div class="form-group col-sm-6 m-auto slider-tool-main">
                                    <div class="row">
                                        <div class="col">{{$client_name}}</div>
                                        <div class="col text-right">{{$opponent_name}}</div>
                                    </div>
                                    <input id="7_Joint_balance_range_selector" type="range" class="form-control slider-tool-input 7_Joint_balance_range_selector" name="" value="<?php if(isset($drfundsondeposit->Joint_Funds_on_Deposit_Percent_Marital_Equity_to_Op7)){ echo $drfundsondeposit->Joint_Funds_on_Deposit_Percent_Marital_Equity_to_Op7; } ?>" min="0.00" step="0.01" max="100" onchange="updateBalanceInput(this.value, '7', 'Joint');">
                                </div>
                                <div class="form-group col-sm-6 m-auto slider-tool-main">
                                    <div class="row justify-content-between">
                                        <div class="col selectorTool">
                                            <div class="left-col">
                                                <div class="client-info 7_Joint_clientpercentage_div clientpercentage_div">
                                                    <?php if(isset($drfundsondeposit->Joint_Funds_on_Deposit_Percent_Marital_Equity_to_Client7)){ echo $drfundsondeposit->Joint_Funds_on_Deposit_Percent_Marital_Equity_to_Client7; } else {
                                                        echo "50.00";
                                                    } ?>%
                                                </div>
                                                <div class="client-info 7_Joint_clientamount_div clientamount_div" style="clear: both;">
                                                    $<?php if(isset($drfundsondeposit->Joint_Funds_on_Deposit_Estimated_Value_to_Client7)){ echo $drfundsondeposit->Joint_Funds_on_Deposit_Estimated_Value_to_Client7; } ?>
                                                </div>
                                            </div>
                                            <label>To {{$client_name}}</label>
                                        </div>                                       
                                        <div class="col selectorTool selectorToolRight">
                                            <label>To {{$opponent_name}}</label>
                                            <div class="left-col right-col">
                                                <div class="client-info 7_Joint_opponentpercentage_div opponentpercentage_div">
                                                    <?php if(isset($drfundsondeposit->Joint_Funds_on_Deposit_Percent_Marital_Equity_to_Op7)){ echo $drfundsondeposit->Joint_Funds_on_Deposit_Percent_Marital_Equity_to_Op7; } else {
                                                        echo "50.00";
                                                    } ?>%
                                                </div>
                                                <div class="client-info 7_Joint_opponentamount_div opponentamount_div" style="clear: both;">
                                                    $<?php if(isset($drfundsondeposit->Joint_Funds_on_Deposit_Estimated_Value_to_Op7)){ echo $drfundsondeposit->Joint_Funds_on_Deposit_Estimated_Value_to_Op7; } ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 m-auto slider-tool-main">
                                    <label></label>
                                    <div class="w-100">
                                        <label><input type="radio" id="7_Joint_Funds_on_Deposit_Estimated_Value_Select" name="7_Joint_Funds_on_Deposit_Estimated_Value_Select_Reset" class="Funds_on_Deposit_Estimated_Value_Select_Reset" value="Save"> Save this Distribution of Deposit Account #7</label>
                                        <label><input type="radio" id="7_Joint_Funds_on_Deposit_Estimated_Value_Reset" name="7_Joint_Funds_on_Deposit_Estimated_Value_Select_Reset" class="Funds_on_Deposit_Estimated_Value_Select_Reset" value="Reset" onclick="resetBalanceInput(this, '7', 'Joint');"> Reset to Default (50%)</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label>{{$client_name}} Deposite Equity Percent</label>
                                    <input id="Joint_Funds_on_Deposit_Percent_Marital_Equity_to_Client7" type="number" class="form-control 7_Joint_clientpercentage_input clientpercentage_input" name="Joint_Funds_on_Deposit_Percent_Marital_Equity_to_Client7" value="<?php if(isset($drfundsondeposit->Joint_Funds_on_Deposit_Percent_Marital_Equity_to_Client7)){ echo $drfundsondeposit->Joint_Funds_on_Deposit_Percent_Marital_Equity_to_Client7; } ?>" min="0.00" step="0.01" max="100" readonly="">
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label>{{$client_name}} Deposite Equity Amount</label>
                                    <input id="Joint_Funds_on_Deposit_Estimated_Value_to_Client7" type="number" class="form-control 7_Joint_clientamount_input clientamount_input" name="Joint_Funds_on_Deposit_Estimated_Value_to_Client7" value="<?php if(isset($drfundsondeposit->Joint_Funds_on_Deposit_Estimated_Value_to_Client7)){ echo $drfundsondeposit->Joint_Funds_on_Deposit_Estimated_Value_to_Client7; } ?>" min="0.00" step="0.01" max="999999.99" readonly="">
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label>{{$opponent_name}} Deposite Equity Percent</label>
                                    <input id="Joint_Funds_on_Deposit_Percent_Marital_Equity_to_Op7" type="number" class="form-control 7_Joint_opponentpercentage_input opponentpercentage_input" name="Joint_Funds_on_Deposit_Percent_Marital_Equity_to_Op7" value="<?php if(isset($drfundsondeposit->Joint_Funds_on_Deposit_Percent_Marital_Equity_to_Op7)){ echo $drfundsondeposit->Joint_Funds_on_Deposit_Percent_Marital_Equity_to_Op7; } ?>" min="0.00" step="0.01" max="100" readonly="">
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label>{{$opponent_name}} Deposite Equity Amount</label>
                                    <input id="Joint_Funds_on_Deposit_Estimated_Value_to_Op7" type="number" class="form-control 7_Joint_opponentamount_input opponentamount_input" name="Joint_Funds_on_Deposit_Estimated_Value_to_Op7" value="<?php if(isset($drfundsondeposit->Joint_Funds_on_Deposit_Estimated_Value_to_Op7)){ echo $drfundsondeposit->Joint_Funds_on_Deposit_Estimated_Value_to_Op7; } ?>" min="0.00" step="0.01" max="999999.99" readonly="">
                                </div>
                                <!-- end of slider tool -->
                            </div>
                            <div class="col-sm-12 mt-4 8_Joint_fundsondeposit_section" style="display: none;"><h5 class="col-sm-12">Eighth Deposit Account Info</h5>
                                <div class="form-group col-sm-6">
                                    <p class="text-danger 8_Joint_no-state-county-found" style="display: none;">No City, State, County found for this zipcode.</p>
                                    <label for="Joint_Funds_on_Deposit_Institution_ZIP8">Deposit Institution Zip Code?</label>
                                    <input id="Joint_Funds_on_Deposit_Institution_ZIP8" type="text" class="form-control 8_Joint_fundsondeposit_inputs" name="Joint_Funds_on_Deposit_Institution_ZIP8" value="<?php if(isset($drfundsondeposit->Joint_Funds_on_Deposit_Institution_ZIP8)){ echo $drfundsondeposit->Joint_Funds_on_Deposit_Institution_ZIP8; } ?>" data-onload="getCityStateForZip(this, '8', 'Joint');" onkeyup="getCityStateForZip(this, '8', 'Joint');"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_Funds_on_Deposit_Institution_Name8">Name of Deposit Institution?</label>
                                    <input id="Joint_Funds_on_Deposit_Institution_Name8" type="text" class="form-control 8_Joint_fundsondeposit_inputs" name="Joint_Funds_on_Deposit_Institution_Name8" value="<?php if(isset($drfundsondeposit->Joint_Funds_on_Deposit_Institution_Name8)){ echo $drfundsondeposit->Joint_Funds_on_Deposit_Institution_Name8; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_Funds_on_Deposit_Institution_Street_Address8">Deposit Institution Street Address?</label>
                                    <input id="Joint_Funds_on_Deposit_Institution_Street_Address8" type="text" class="form-control 8_Joint_fundsondeposit_inputs" name="Joint_Funds_on_Deposit_Institution_Street_Address8" value="<?php if(isset($drfundsondeposit->Joint_Funds_on_Deposit_Institution_Street_Address8)){ echo $drfundsondeposit->Joint_Funds_on_Deposit_Institution_Street_Address8; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_Funds_on_Deposit_Institution_City8">Deposit Institution City?</label>
                                    <input type="hidden" name="" id="Joint_Funds_on_Deposit_Institution_City8_Value" value="<?php if(isset($drfundsondeposit->Joint_Funds_on_Deposit_Institution_City8)){ echo $drfundsondeposit->Joint_Funds_on_Deposit_Institution_City8; } ?>">
                                    <select id="Joint_Funds_on_Deposit_Institution_City8" name="Joint_Funds_on_Deposit_Institution_City8" class="form-control 8_Joint_city_select">
                                        <option value="">Choose City</option>
                                    </select>   
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_Funds_on_Deposit_Institution_State8">Deposit Institution State?</label>
                                    <input type="hidden" name="" id="Joint_Funds_on_Deposit_Institution_State8_Value" value="<?php if(isset($drfundsondeposit->Joint_Funds_on_Deposit_Institution_State8)){ echo $drfundsondeposit->Joint_Funds_on_Deposit_Institution_State8; } ?>">
                                    <select id="Joint_Funds_on_Deposit_Institution_State8" name="Joint_Funds_on_Deposit_Institution_State8" class="form-control 8_Joint_state_select">
                                        <option value="">Choose State</option>
                                    </select>   
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_Funds_on_Deposit_Institution_Acct_Num8">Account Number?</label>
                                    <input id="Joint_Funds_on_Deposit_Institution_Acct_Num8" type="text" class="form-control 8_Joint_fundsondeposit_inputs" name="Joint_Funds_on_Deposit_Institution_Acct_Num8" value="<?php if(isset($drfundsondeposit->Joint_Funds_on_Deposit_Institution_Acct_Num8)){ echo $drfundsondeposit->Joint_Funds_on_Deposit_Institution_Acct_Num8; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_Funds_on_Deposit_Institution_Current_Balance8">Current Balance?</label>
                                    <input id="Joint_Funds_on_Deposit_Institution_Current_Balance8" type="number" class="form-control 8_Joint_fundsondeposit_inputs" name="Joint_Funds_on_Deposit_Institution_Current_Balance8" value="<?php if(isset($drfundsondeposit->Joint_Funds_on_Deposit_Institution_Current_Balance8)){ echo $drfundsondeposit->Joint_Funds_on_Deposit_Institution_Current_Balance8; } ?>" min="0.00" step="0.01" max="999999.99" onchange="getJointCurrentBalance(this, '8_Joint');" onkeyup="getJointCurrentBalance(this, '8_Joint');"> 
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label for="Joint_Funds_on_Deposit_Estimated_MaritalEquity8">N/A, calculated = Joint_Funds_on_Deposit_Institution_Current_Balance8</label>
                                    <input id="Joint_Funds_on_Deposit_Estimated_MaritalEquity8" type="number" class="form-control 8_Joint_fundsondeposit_inputs" name="Joint_Funds_on_Deposit_Estimated_MaritalEquity8" value="<?php if(isset($drfundsondeposit->Joint_Funds_on_Deposit_Estimated_MaritalEquity8)){ echo $drfundsondeposit->Joint_Funds_on_Deposit_Estimated_MaritalEquity8; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_Funds_on_Deposit_Institution_Yearly_Interest_Dividend8">Yearly Interest?</label>
                                    <input id="Joint_Funds_on_Deposit_Institution_Yearly_Interest_Dividend8" type="number" class="form-control 8_Joint_fundsondeposit_inputs" name="Joint_Funds_on_Deposit_Institution_Yearly_Interest_Dividend8" value="<?php if(isset($drfundsondeposit->Joint_Funds_on_Deposit_Institution_Yearly_Interest_Dividend8)){ echo $drfundsondeposit->Joint_Funds_on_Deposit_Institution_Yearly_Interest_Dividend8; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Does either party claim a sole/separate interest from the other on this fund?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Joint_Funds_on_Deposit_SoleSeparate_Claim8_Yes" name="Joint_Funds_on_Deposit_SoleSeparate_Claim8" value="Yes" <?php if(isset($drfundsondeposit->Joint_Funds_on_Deposit_SoleSeparate_Claim8) && $drfundsondeposit->Joint_Funds_on_Deposit_SoleSeparate_Claim8=='Yes'){ echo "checked"; } ?>> Yes</label>
                                        <label><input type="radio" id="Joint_Funds_on_Deposit_SoleSeparate_Claim8_No" name="Joint_Funds_on_Deposit_SoleSeparate_Claim8" value="No" <?php if(isset($drfundsondeposit->Joint_Funds_on_Deposit_SoleSeparate_Claim8) && $drfundsondeposit->Joint_Funds_on_Deposit_SoleSeparate_Claim8=='No'){ echo "checked"; } ?>> No</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Who claims to own this fund?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Joint_Funds_on_Deposit_SoleSeparate_Party8_Client" name="Joint_Funds_on_Deposit_SoleSeparate_Party8" value="{{$client_name}}" <?php if(isset($drfundsondeposit->Joint_Funds_on_Deposit_SoleSeparate_Party8) && $drfundsondeposit->Joint_Funds_on_Deposit_SoleSeparate_Party8==$client_name){ echo "checked"; } ?>> {{$client_name}}</label>
                                        <label><input type="radio" id="Joint_Funds_on_Deposit_SoleSeparate_Party8_Op" name="Joint_Funds_on_Deposit_SoleSeparate_Party8" value="{{$opponent_name}}" <?php if(isset($drfundsondeposit->Joint_Funds_on_Deposit_SoleSeparate_Party8) && $drfundsondeposit->Joint_Funds_on_Deposit_SoleSeparate_Party8==$opponent_name){ echo "checked"; } ?>> {{$opponent_name}}</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 left-clear">
                                    <label for="Joint_Funds_on_Deposit_SoleSeparate_Grounds8">Why does this person own this fund solely and separately?</label>
                                    <input id="Joint_Funds_on_Deposit_SoleSeparate_Grounds8" type="text" class="form-control 8_Joint_fundsondeposit_inputs" name="Joint_Funds_on_Deposit_SoleSeparate_Grounds8" value="<?php if(isset($drfundsondeposit->Joint_Funds_on_Deposit_SoleSeparate_Grounds8)){ echo $drfundsondeposit->Joint_Funds_on_Deposit_SoleSeparate_Grounds8; } ?>"> 
                                </div>
                                <!-- slider tool -->
                                <div class="form-group col-sm-6 m-auto slider-tool-main">
                                    <div class="row">
                                        <div class="col">{{$client_name}}</div>
                                        <div class="col text-right">{{$opponent_name}}</div>
                                    </div>
                                    <input id="8_Joint_balance_range_selector" type="range" class="form-control slider-tool-input 8_Joint_balance_range_selector" name="" value="<?php if(isset($drfundsondeposit->Joint_Funds_on_Deposit_Percent_Marital_Equity_to_Op8)){ echo $drfundsondeposit->Joint_Funds_on_Deposit_Percent_Marital_Equity_to_Op8; } ?>" min="0.00" step="0.01" max="100" onchange="updateBalanceInput(this.value, '8', 'Joint');">
                                </div>
                                <div class="form-group col-sm-6 m-auto slider-tool-main">
                                    <div class="row justify-content-between">
                                        <div class="col selectorTool">
                                            <div class="left-col">
                                                <div class="client-info 8_Joint_clientpercentage_div clientpercentage_div">
                                                    <?php if(isset($drfundsondeposit->Joint_Funds_on_Deposit_Percent_Marital_Equity_to_Client8)){ echo $drfundsondeposit->Joint_Funds_on_Deposit_Percent_Marital_Equity_to_Client8; } else {
                                                        echo "50.00";
                                                    } ?>%
                                                </div>
                                                <div class="client-info 8_Joint_clientamount_div clientamount_div" style="clear: both;">
                                                    $<?php if(isset($drfundsondeposit->Joint_Funds_on_Deposit_Estimated_Value_to_Client8)){ echo $drfundsondeposit->Joint_Funds_on_Deposit_Estimated_Value_to_Client8; } ?>
                                                </div>
                                            </div>
                                            <label>To {{$client_name}}</label>
                                        </div>                                       
                                        <div class="col selectorTool selectorToolRight">
                                            <label>To {{$opponent_name}}</label>
                                            <div class="left-col right-col">
                                                <div class="client-info 8_Joint_opponentpercentage_div opponentpercentage_div">
                                                    <?php if(isset($drfundsondeposit->Joint_Funds_on_Deposit_Percent_Marital_Equity_to_Op8)){ echo $drfundsondeposit->Joint_Funds_on_Deposit_Percent_Marital_Equity_to_Op8; } else {
                                                        echo "50.00";
                                                    } ?>%
                                                </div>
                                                <div class="client-info 8_Joint_opponentamount_div opponentamount_div" style="clear: both;">
                                                    $<?php if(isset($drfundsondeposit->Joint_Funds_on_Deposit_Estimated_Value_to_Op8)){ echo $drfundsondeposit->Joint_Funds_on_Deposit_Estimated_Value_to_Op8; } ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 m-auto slider-tool-main">
                                    <label></label>
                                    <div class="w-100">
                                        <label><input type="radio" id="8_Joint_Funds_on_Deposit_Estimated_Value_Select" name="8_Joint_Funds_on_Deposit_Estimated_Value_Select_Reset" class="Funds_on_Deposit_Estimated_Value_Select_Reset" value="Save"> Save this Distribution of Deposit Account #8</label>
                                        <label><input type="radio" id="8_Joint_Funds_on_Deposit_Estimated_Value_Reset" name="8_Joint_Funds_on_Deposit_Estimated_Value_Select_Reset" class="Funds_on_Deposit_Estimated_Value_Select_Reset" value="Reset" onclick="resetBalanceInput(this, '8', 'Joint');"> Reset to Default (50%)</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label>{{$client_name}} Deposite Equity Percent</label>
                                    <input id="Joint_Funds_on_Deposit_Percent_Marital_Equity_to_Client8" type="number" class="form-control 8_Joint_clientpercentage_input clientpercentage_input" name="Joint_Funds_on_Deposit_Percent_Marital_Equity_to_Client8" value="<?php if(isset($drfundsondeposit->Joint_Funds_on_Deposit_Percent_Marital_Equity_to_Client8)){ echo $drfundsondeposit->Joint_Funds_on_Deposit_Percent_Marital_Equity_to_Client8; } ?>" min="0.00" step="0.01" max="100" readonly="">
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label>{{$client_name}} Deposite Equity Amount</label>
                                    <input id="Joint_Funds_on_Deposit_Estimated_Value_to_Client8" type="number" class="form-control 8_Joint_clientamount_input clientamount_input" name="Joint_Funds_on_Deposit_Estimated_Value_to_Client8" value="<?php if(isset($drfundsondeposit->Joint_Funds_on_Deposit_Estimated_Value_to_Client8)){ echo $drfundsondeposit->Joint_Funds_on_Deposit_Estimated_Value_to_Client8; } ?>" min="0.00" step="0.01" max="999999.99" readonly="">
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label>{{$opponent_name}} Deposite Equity Percent</label>
                                    <input id="Joint_Funds_on_Deposit_Percent_Marital_Equity_to_Op8" type="number" class="form-control 8_Joint_opponentpercentage_input opponentpercentage_input" name="Joint_Funds_on_Deposit_Percent_Marital_Equity_to_Op8" value="<?php if(isset($drfundsondeposit->Joint_Funds_on_Deposit_Percent_Marital_Equity_to_Op8)){ echo $drfundsondeposit->Joint_Funds_on_Deposit_Percent_Marital_Equity_to_Op8; } ?>" min="0.00" step="0.01" max="100" readonly="">
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label>{{$opponent_name}} Deposite Equity Amount</label>
                                    <input id="Joint_Funds_on_Deposit_Estimated_Value_to_Op8" type="number" class="form-control 8_Joint_opponentamount_input opponentamount_input" name="Joint_Funds_on_Deposit_Estimated_Value_to_Op8" value="<?php if(isset($drfundsondeposit->Joint_Funds_on_Deposit_Estimated_Value_to_Op8)){ echo $drfundsondeposit->Joint_Funds_on_Deposit_Estimated_Value_to_Op8; } ?>" min="0.00" step="0.01" max="999999.99" readonly="">
                                </div>
                                <!-- end of slider tool -->
                            </div>
                            <div class="col-sm-12 mt-4 9_Joint_fundsondeposit_section" style="display: none;"><h5 class="col-sm-12">Nineth Deposit Account Info</h5>
                                <div class="form-group col-sm-6">
                                    <p class="text-danger 9_Joint_no-state-county-found" style="display: none;">No City, State, County found for this zipcode.</p>
                                    <label for="Joint_Funds_on_Deposit_Institution_ZIP9">Deposit Institution Zip Code?</label>
                                    <input id="Joint_Funds_on_Deposit_Institution_ZIP9" type="text" class="form-control 9_Joint_fundsondeposit_inputs" name="Joint_Funds_on_Deposit_Institution_ZIP9" value="<?php if(isset($drfundsondeposit->Joint_Funds_on_Deposit_Institution_ZIP9)){ echo $drfundsondeposit->Joint_Funds_on_Deposit_Institution_ZIP9; } ?>" data-onload="getCityStateForZip(this, '9', 'Joint');" onkeyup="getCityStateForZip(this, '9', 'Joint');"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_Funds_on_Deposit_Institution_Name9">Name of Deposit Institution?</label>
                                    <input id="Joint_Funds_on_Deposit_Institution_Name9" type="text" class="form-control 9_Joint_fundsondeposit_inputs" name="Joint_Funds_on_Deposit_Institution_Name9" value="<?php if(isset($drfundsondeposit->Joint_Funds_on_Deposit_Institution_Name9)){ echo $drfundsondeposit->Joint_Funds_on_Deposit_Institution_Name9; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_Funds_on_Deposit_Institution_Street_Address9">Deposit Institution Street Address?</label>
                                    <input id="Joint_Funds_on_Deposit_Institution_Street_Address9" type="text" class="form-control 9_Joint_fundsondeposit_inputs" name="Joint_Funds_on_Deposit_Institution_Street_Address9" value="<?php if(isset($drfundsondeposit->Joint_Funds_on_Deposit_Institution_Street_Address9)){ echo $drfundsondeposit->Joint_Funds_on_Deposit_Institution_Street_Address9; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_Funds_on_Deposit_Institution_City9">Deposit Institution City?</label>
                                    <input type="hidden" name="" id="Joint_Funds_on_Deposit_Institution_City9_Value" value="<?php if(isset($drfundsondeposit->Joint_Funds_on_Deposit_Institution_City9)){ echo $drfundsondeposit->Joint_Funds_on_Deposit_Institution_City9; } ?>">
                                    <select id="Joint_Funds_on_Deposit_Institution_City9" name="Joint_Funds_on_Deposit_Institution_City9" class="form-control 9_Joint_city_select">
                                        <option value="">Choose City</option>
                                    </select>   
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_Funds_on_Deposit_Institution_State9">Deposit Institution State?</label>
                                    <input type="hidden" name="" id="Joint_Funds_on_Deposit_Institution_State9_Value" value="<?php if(isset($drfundsondeposit->Joint_Funds_on_Deposit_Institution_State9)){ echo $drfundsondeposit->Joint_Funds_on_Deposit_Institution_State9; } ?>">
                                    <select id="Joint_Funds_on_Deposit_Institution_State9" name="Joint_Funds_on_Deposit_Institution_State9" class="form-control 9_Joint_state_select">
                                        <option value="">Choose State</option>
                                    </select>   
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_Funds_on_Deposit_Institution_Acct_Num9">Account Number?</label>
                                    <input id="Joint_Funds_on_Deposit_Institution_Acct_Num9" type="text" class="form-control 9_Joint_fundsondeposit_inputs" name="Joint_Funds_on_Deposit_Institution_Acct_Num9" value="<?php if(isset($drfundsondeposit->Joint_Funds_on_Deposit_Institution_Acct_Num9)){ echo $drfundsondeposit->Joint_Funds_on_Deposit_Institution_Acct_Num9; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_Funds_on_Deposit_Institution_Current_Balance9">Current Balance?</label>
                                    <input id="Joint_Funds_on_Deposit_Institution_Current_Balance9" type="number" class="form-control 9_Joint_fundsondeposit_inputs" name="Joint_Funds_on_Deposit_Institution_Current_Balance9" value="<?php if(isset($drfundsondeposit->Joint_Funds_on_Deposit_Institution_Current_Balance9)){ echo $drfundsondeposit->Joint_Funds_on_Deposit_Institution_Current_Balance9; } ?>" min="0.00" step="0.01" max="999999.99" onchange="getJointCurrentBalance(this, '9_Joint');" onkeyup="getJointCurrentBalance(this, '9_Joint');"> 
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label for="Joint_Funds_on_Deposit_Estimated_MaritalEquity9">N/A, calculated = Joint_Funds_on_Deposit_Institution_Current_Balance9</label>
                                    <input id="Joint_Funds_on_Deposit_Estimated_MaritalEquity9" type="number" class="form-control 9_Joint_fundsondeposit_inputs" name="Joint_Funds_on_Deposit_Estimated_MaritalEquity9" value="<?php if(isset($drfundsondeposit->Joint_Funds_on_Deposit_Estimated_MaritalEquity9)){ echo $drfundsondeposit->Joint_Funds_on_Deposit_Estimated_MaritalEquity9; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_Funds_on_Deposit_Institution_Yearly_Interest_Dividend9">Yearly Interest?</label>
                                    <input id="Joint_Funds_on_Deposit_Institution_Yearly_Interest_Dividend9" type="number" class="form-control 9_Joint_fundsondeposit_inputs" name="Joint_Funds_on_Deposit_Institution_Yearly_Interest_Dividend9" value="<?php if(isset($drfundsondeposit->Joint_Funds_on_Deposit_Institution_Yearly_Interest_Dividend9)){ echo $drfundsondeposit->Joint_Funds_on_Deposit_Institution_Yearly_Interest_Dividend9; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Does either party claim a sole/separate interest from the other on this fund?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Joint_Funds_on_Deposit_SoleSeparate_Claim9_Yes" name="Joint_Funds_on_Deposit_SoleSeparate_Claim9" value="Yes" <?php if(isset($drfundsondeposit->Joint_Funds_on_Deposit_SoleSeparate_Claim9) && $drfundsondeposit->Joint_Funds_on_Deposit_SoleSeparate_Claim9=='Yes'){ echo "checked"; } ?>> Yes</label>
                                        <label><input type="radio" id="Joint_Funds_on_Deposit_SoleSeparate_Claim9_No" name="Joint_Funds_on_Deposit_SoleSeparate_Claim9" value="No" <?php if(isset($drfundsondeposit->Joint_Funds_on_Deposit_SoleSeparate_Claim9) && $drfundsondeposit->Joint_Funds_on_Deposit_SoleSeparate_Claim9=='No'){ echo "checked"; } ?>> No</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Who claims to own this fund?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Joint_Funds_on_Deposit_SoleSeparate_Party9_Client" name="Joint_Funds_on_Deposit_SoleSeparate_Party9" value="{{$client_name}}" <?php if(isset($drfundsondeposit->Joint_Funds_on_Deposit_SoleSeparate_Party9) && $drfundsondeposit->Joint_Funds_on_Deposit_SoleSeparate_Party9==$client_name){ echo "checked"; } ?>> {{$client_name}}</label>
                                        <label><input type="radio" id="Joint_Funds_on_Deposit_SoleSeparate_Party9_Op" name="Joint_Funds_on_Deposit_SoleSeparate_Party9" value="{{$opponent_name}}" <?php if(isset($drfundsondeposit->Joint_Funds_on_Deposit_SoleSeparate_Party9) && $drfundsondeposit->Joint_Funds_on_Deposit_SoleSeparate_Party9==$opponent_name){ echo "checked"; } ?>> {{$opponent_name}}</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 left-clear">
                                    <label for="Joint_Funds_on_Deposit_SoleSeparate_Grounds9">Why does this person own this fund solely and separately?</label>
                                    <input id="Joint_Funds_on_Deposit_SoleSeparate_Grounds9" type="text" class="form-control 9_Joint_fundsondeposit_inputs" name="Joint_Funds_on_Deposit_SoleSeparate_Grounds9" value="<?php if(isset($drfundsondeposit->Joint_Funds_on_Deposit_SoleSeparate_Grounds9)){ echo $drfundsondeposit->Joint_Funds_on_Deposit_SoleSeparate_Grounds9; } ?>"> 
                                </div>
                                <!-- slider tool -->
                                <div class="form-group col-sm-6 m-auto slider-tool-main">
                                    <div class="row">
                                        <div class="col">{{$client_name}}</div>
                                        <div class="col text-right">{{$opponent_name}}</div>
                                    </div>
                                    <input id="9_Joint_balance_range_selector" type="range" class="form-control slider-tool-input 9_Joint_balance_range_selector" name="" value="<?php if(isset($drfundsondeposit->Joint_Funds_on_Deposit_Percent_Marital_Equity_to_Op9)){ echo $drfundsondeposit->Joint_Funds_on_Deposit_Percent_Marital_Equity_to_Op9; } ?>" min="0.00" step="0.01" max="100" onchange="updateBalanceInput(this.value, '9', 'Joint');">
                                </div>
                                <div class="form-group col-sm-6 m-auto slider-tool-main">
                                    <div class="row justify-content-between">
                                        <div class="col selectorTool">
                                            <div class="left-col">
                                                <div class="client-info 9_Joint_clientpercentage_div clientpercentage_div">
                                                    <?php if(isset($drfundsondeposit->Joint_Funds_on_Deposit_Percent_Marital_Equity_to_Client9)){ echo $drfundsondeposit->Joint_Funds_on_Deposit_Percent_Marital_Equity_to_Client9; } else {
                                                        echo "50.00";
                                                    } ?>%
                                                </div>
                                                <div class="client-info 9_Joint_clientamount_div clientamount_div" style="clear: both;">
                                                    $<?php if(isset($drfundsondeposit->Joint_Funds_on_Deposit_Estimated_Value_to_Client9)){ echo $drfundsondeposit->Joint_Funds_on_Deposit_Estimated_Value_to_Client9; } ?>
                                                </div>
                                            </div>
                                            <label>To {{$client_name}}</label>
                                        </div>                                       
                                        <div class="col selectorTool selectorToolRight">
                                            <label>To {{$opponent_name}}</label>
                                            <div class="left-col right-col">
                                                <div class="client-info 9_Joint_opponentpercentage_div opponentpercentage_div">
                                                    <?php if(isset($drfundsondeposit->Joint_Funds_on_Deposit_Percent_Marital_Equity_to_Op9)){ echo $drfundsondeposit->Joint_Funds_on_Deposit_Percent_Marital_Equity_to_Op9; } else {
                                                        echo "50.00";
                                                    } ?>%
                                                </div>
                                                <div class="client-info 9_Joint_opponentamount_div opponentamount_div" style="clear: both;">
                                                    $<?php if(isset($drfundsondeposit->Joint_Funds_on_Deposit_Estimated_Value_to_Op9)){ echo $drfundsondeposit->Joint_Funds_on_Deposit_Estimated_Value_to_Op9; } ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 m-auto slider-tool-main">
                                    <label></label>
                                    <div class="w-100">
                                        <label><input type="radio" id="9_Joint_Funds_on_Deposit_Estimated_Value_Select" name="9_Joint_Funds_on_Deposit_Estimated_Value_Select_Reset" class="Funds_on_Deposit_Estimated_Value_Select_Reset" value="Save"> Save this Distribution of Deposit Account #9</label>
                                        <label><input type="radio" id="9_Joint_Funds_on_Deposit_Estimated_Value_Reset" name="9_Joint_Funds_on_Deposit_Estimated_Value_Select_Reset" class="Funds_on_Deposit_Estimated_Value_Select_Reset" value="Reset" onclick="resetBalanceInput(this, '9', 'Joint');"> Reset to Default (50%)</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label>{{$client_name}} Deposite Equity Percent</label>
                                    <input id="Joint_Funds_on_Deposit_Percent_Marital_Equity_to_Client9" type="number" class="form-control 9_Joint_clientpercentage_input clientpercentage_input" name="Joint_Funds_on_Deposit_Percent_Marital_Equity_to_Client9" value="<?php if(isset($drfundsondeposit->Joint_Funds_on_Deposit_Percent_Marital_Equity_to_Client9)){ echo $drfundsondeposit->Joint_Funds_on_Deposit_Percent_Marital_Equity_to_Client9; } ?>" min="0.00" step="0.01" max="100" readonly="">
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label>{{$client_name}} Deposite Equity Amount</label>
                                    <input id="Joint_Funds_on_Deposit_Estimated_Value_to_Client9" type="number" class="form-control 9_Joint_clientamount_input clientamount_input" name="Joint_Funds_on_Deposit_Estimated_Value_to_Client9" value="<?php if(isset($drfundsondeposit->Joint_Funds_on_Deposit_Estimated_Value_to_Client9)){ echo $drfundsondeposit->Joint_Funds_on_Deposit_Estimated_Value_to_Client9; } ?>" min="0.00" step="0.01" max="999999.99" readonly="">
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label>{{$opponent_name}} Deposite Equity Percent</label>
                                    <input id="Joint_Funds_on_Deposit_Percent_Marital_Equity_to_Op9" type="number" class="form-control 9_Joint_opponentpercentage_input opponentpercentage_input" name="Joint_Funds_on_Deposit_Percent_Marital_Equity_to_Op9" value="<?php if(isset($drfundsondeposit->Joint_Funds_on_Deposit_Percent_Marital_Equity_to_Op9)){ echo $drfundsondeposit->Joint_Funds_on_Deposit_Percent_Marital_Equity_to_Op9; } ?>" min="0.00" step="0.01" max="100" readonly="">
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label>{{$opponent_name}} Deposite Equity Amount</label>
                                    <input id="Joint_Funds_on_Deposit_Estimated_Value_to_Op9" type="number" class="form-control 9_Joint_opponentamount_input opponentamount_input" name="Joint_Funds_on_Deposit_Estimated_Value_to_Op9" value="<?php if(isset($drfundsondeposit->Joint_Funds_on_Deposit_Estimated_Value_to_Op9)){ echo $drfundsondeposit->Joint_Funds_on_Deposit_Estimated_Value_to_Op9; } ?>" min="0.00" step="0.01" max="999999.99" readonly="">
                                </div>
                                <!-- end of slider tool -->
                            </div>
                            <div class="col-sm-12 mt-4 10_Joint_fundsondeposit_section" style="display: none;"><h5 class="col-sm-12">Tenth Deposit Account Info</h5>
                                <div class="form-group col-sm-6">
                                    <p class="text-danger 10_Joint_no-state-county-found" style="display: none;">No City, State, County found for this zipcode.</p>
                                    <label for="Joint_Funds_on_Deposit_Institution_ZIP10">Deposit Institution Zip Code?</label>
                                    <input id="Joint_Funds_on_Deposit_Institution_ZIP10" type="text" class="form-control 10_Joint_fundsondeposit_inputs" name="Joint_Funds_on_Deposit_Institution_ZIP10" value="<?php if(isset($drfundsondeposit->Joint_Funds_on_Deposit_Institution_ZIP10)){ echo $drfundsondeposit->Joint_Funds_on_Deposit_Institution_ZIP10; } ?>" data-onload="getCityStateForZip(this, '10', 'Joint');" onkeyup="getCityStateForZip(this, '10', 'Joint');"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_Funds_on_Deposit_Institution_Name10">Name of Deposit Institution?</label>
                                    <input id="Joint_Funds_on_Deposit_Institution_Name10" type="text" class="form-control 10_Joint_fundsondeposit_inputs" name="Joint_Funds_on_Deposit_Institution_Name10" value="<?php if(isset($drfundsondeposit->Joint_Funds_on_Deposit_Institution_Name10)){ echo $drfundsondeposit->Joint_Funds_on_Deposit_Institution_Name10; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_Funds_on_Deposit_Institution_Street_Address10">Deposit Institution Street Address?</label>
                                    <input id="Joint_Funds_on_Deposit_Institution_Street_Address10" type="text" class="form-control 10_Joint_fundsondeposit_inputs" name="Joint_Funds_on_Deposit_Institution_Street_Address10" value="<?php if(isset($drfundsondeposit->Joint_Funds_on_Deposit_Institution_Street_Address10)){ echo $drfundsondeposit->Joint_Funds_on_Deposit_Institution_Street_Address10; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_Funds_on_Deposit_Institution_City10">Deposit Institution City?</label>
                                    <input type="hidden" name="" id="Joint_Funds_on_Deposit_Institution_City10_Value" value="<?php if(isset($drfundsondeposit->Joint_Funds_on_Deposit_Institution_City10)){ echo $drfundsondeposit->Joint_Funds_on_Deposit_Institution_City10; } ?>">
                                    <select id="Joint_Funds_on_Deposit_Institution_City10" name="Joint_Funds_on_Deposit_Institution_City10" class="form-control 10_Joint_city_select">
                                        <option value="">Choose City</option>
                                    </select>   
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_Funds_on_Deposit_Institution_State10">Deposit Institution State?</label>
                                    <input type="hidden" name="" id="Joint_Funds_on_Deposit_Institution_State10_Value" value="<?php if(isset($drfundsondeposit->Joint_Funds_on_Deposit_Institution_State10)){ echo $drfundsondeposit->Joint_Funds_on_Deposit_Institution_State10; } ?>">
                                    <select id="Joint_Funds_on_Deposit_Institution_State10" name="Joint_Funds_on_Deposit_Institution_State10" class="form-control 10_Joint_state_select">
                                        <option value="">Choose State</option>
                                    </select>   
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_Funds_on_Deposit_Institution_Acct_Num10">Account Number?</label>
                                    <input id="Joint_Funds_on_Deposit_Institution_Acct_Num10" type="text" class="form-control 10_Joint_fundsondeposit_inputs" name="Joint_Funds_on_Deposit_Institution_Acct_Num10" value="<?php if(isset($drfundsondeposit->Joint_Funds_on_Deposit_Institution_Acct_Num10)){ echo $drfundsondeposit->Joint_Funds_on_Deposit_Institution_Acct_Num10; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_Funds_on_Deposit_Institution_Current_Balance10">Current Balance?</label>
                                    <input id="Joint_Funds_on_Deposit_Institution_Current_Balance10" type="number" class="form-control 10_Joint_fundsondeposit_inputs" name="Joint_Funds_on_Deposit_Institution_Current_Balance10" value="<?php if(isset($drfundsondeposit->Joint_Funds_on_Deposit_Institution_Current_Balance10)){ echo $drfundsondeposit->Joint_Funds_on_Deposit_Institution_Current_Balance10; } ?>" min="0.00" step="0.01" max="999999.99" onchange="getJointCurrentBalance(this, '10_Joint');" onkeyup="getJointCurrentBalance(this, '10_Joint');"> 
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label for="Joint_Funds_on_Deposit_Estimated_MaritalEquity10">N/A, calculated = Joint_Funds_on_Deposit_Institution_Current_Balance10</label>
                                    <input id="Joint_Funds_on_Deposit_Estimated_MaritalEquity10" type="number" class="form-control 10_Joint_fundsondeposit_inputs" name="Joint_Funds_on_Deposit_Estimated_MaritalEquity10" value="<?php if(isset($drfundsondeposit->Joint_Funds_on_Deposit_Estimated_MaritalEquity10)){ echo $drfundsondeposit->Joint_Funds_on_Deposit_Estimated_MaritalEquity10; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_Funds_on_Deposit_Institution_Yearly_Interest_Dividend10">Yearly Interest?</label>
                                    <input id="Joint_Funds_on_Deposit_Institution_Yearly_Interest_Dividend10" type="number" class="form-control 10_Joint_fundsondeposit_inputs" name="Joint_Funds_on_Deposit_Institution_Yearly_Interest_Dividend10" value="<?php if(isset($drfundsondeposit->Joint_Funds_on_Deposit_Institution_Yearly_Interest_Dividend10)){ echo $drfundsondeposit->Joint_Funds_on_Deposit_Institution_Yearly_Interest_Dividend10; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Does either party claim a sole/separate interest from the other on this fund?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Joint_Funds_on_Deposit_SoleSeparate_Claim10_Yes" name="Joint_Funds_on_Deposit_SoleSeparate_Claim10" value="Yes" <?php if(isset($drfundsondeposit->Joint_Funds_on_Deposit_SoleSeparate_Claim10) && $drfundsondeposit->Joint_Funds_on_Deposit_SoleSeparate_Claim10=='Yes'){ echo "checked"; } ?>> Yes</label>
                                        <label><input type="radio" id="Joint_Funds_on_Deposit_SoleSeparate_Claim10_No" name="Joint_Funds_on_Deposit_SoleSeparate_Claim10" value="No" <?php if(isset($drfundsondeposit->Joint_Funds_on_Deposit_SoleSeparate_Claim10) && $drfundsondeposit->Joint_Funds_on_Deposit_SoleSeparate_Claim10=='No'){ echo "checked"; } ?>> No</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Who claims to own this fund?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Joint_Funds_on_Deposit_SoleSeparate_Party10_Client" name="Joint_Funds_on_Deposit_SoleSeparate_Party10" value="{{$client_name}}" <?php if(isset($drfundsondeposit->Joint_Funds_on_Deposit_SoleSeparate_Party10) && $drfundsondeposit->Joint_Funds_on_Deposit_SoleSeparate_Party10==$client_name){ echo "checked"; } ?>> {{$client_name}}</label>
                                        <label><input type="radio" id="Joint_Funds_on_Deposit_SoleSeparate_Party10_Op" name="Joint_Funds_on_Deposit_SoleSeparate_Party10" value="{{$opponent_name}}" <?php if(isset($drfundsondeposit->Joint_Funds_on_Deposit_SoleSeparate_Party10) && $drfundsondeposit->Joint_Funds_on_Deposit_SoleSeparate_Party10==$opponent_name){ echo "checked"; } ?>> {{$opponent_name}}</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 left-clear">
                                    <label for="Joint_Funds_on_Deposit_SoleSeparate_Grounds10">Why does this person own this fund solely and separately?</label>
                                    <input id="Joint_Funds_on_Deposit_SoleSeparate_Grounds10" type="text" class="form-control 10_Joint_fundsondeposit_inputs" name="Joint_Funds_on_Deposit_SoleSeparate_Grounds10" value="<?php if(isset($drfundsondeposit->Joint_Funds_on_Deposit_SoleSeparate_Grounds10)){ echo $drfundsondeposit->Joint_Funds_on_Deposit_SoleSeparate_Grounds10; } ?>"> 
                                </div>
                                <!-- slider tool -->
                                <div class="form-group col-sm-6 m-auto slider-tool-main">
                                    <div class="row">
                                        <div class="col">{{$client_name}}</div>
                                        <div class="col text-right">{{$opponent_name}}</div>
                                    </div>
                                    <input id="10_Joint_balance_range_selector" type="range" class="form-control slider-tool-input 10_Joint_balance_range_selector" name="" value="<?php if(isset($drfundsondeposit->Joint_Funds_on_Deposit_Percent_Marital_Equity_to_Op10)){ echo $drfundsondeposit->Joint_Funds_on_Deposit_Percent_Marital_Equity_to_Op10; } ?>" min="0.00" step="0.01" max="100" onchange="updateBalanceInput(this.value, '10', 'Joint');">
                                </div>
                                <div class="form-group col-sm-6 m-auto slider-tool-main">
                                    <div class="row justify-content-between">
                                        <div class="col selectorTool">
                                            <div class="left-col">
                                                <div class="client-info 10_Joint_clientpercentage_div clientpercentage_div">
                                                    <?php if(isset($drfundsondeposit->Joint_Funds_on_Deposit_Percent_Marital_Equity_to_Client10)){ echo $drfundsondeposit->Joint_Funds_on_Deposit_Percent_Marital_Equity_to_Client10; } else {
                                                        echo "50.00";
                                                    } ?>%
                                                </div>
                                                <div class="client-info 10_Joint_clientamount_div clientamount_div" style="clear: both;">
                                                    $<?php if(isset($drfundsondeposit->Joint_Funds_on_Deposit_Estimated_Value_to_Client10)){ echo $drfundsondeposit->Joint_Funds_on_Deposit_Estimated_Value_to_Client10; } ?>
                                                </div>
                                            </div>
                                            <label>To {{$client_name}}</label>
                                        </div>                                       
                                        <div class="col selectorTool selectorToolRight">
                                            <label>To {{$opponent_name}}</label>
                                            <div class="left-col right-col">
                                                <div class="client-info 10_Joint_opponentpercentage_div opponentpercentage_div">
                                                    <?php if(isset($drfundsondeposit->Joint_Funds_on_Deposit_Percent_Marital_Equity_to_Op10)){ echo $drfundsondeposit->Joint_Funds_on_Deposit_Percent_Marital_Equity_to_Op10; } else {
                                                        echo "50.00";
                                                    } ?>%
                                                </div>
                                                <div class="client-info 10_Joint_opponentamount_div opponentamount_div" style="clear: both;">
                                                    $<?php if(isset($drfundsondeposit->Joint_Funds_on_Deposit_Estimated_Value_to_Op10)){ echo $drfundsondeposit->Joint_Funds_on_Deposit_Estimated_Value_to_Op10; } ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 m-auto slider-tool-main">
                                    <label></label>
                                    <div class="w-100">
                                        <label><input type="radio" id="10_Joint_Funds_on_Deposit_Estimated_Value_Select" name="10_Joint_Funds_on_Deposit_Estimated_Value_Select_Reset" class="Funds_on_Deposit_Estimated_Value_Select_Reset" value="Save"> Save this Distribution of Deposit Account #10</label>
                                        <label><input type="radio" id="10_Joint_Funds_on_Deposit_Estimated_Value_Reset" name="10_Joint_Funds_on_Deposit_Estimated_Value_Select_Reset" class="Funds_on_Deposit_Estimated_Value_Select_Reset" value="Reset" onclick="resetBalanceInput(this, '10', 'Joint');"> Reset to Default (50%)</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label>{{$client_name}} Deposite Equity Percent</label>
                                    <input id="Joint_Funds_on_Deposit_Percent_Marital_Equity_to_Client10" type="number" class="form-control 10_Joint_clientpercentage_input clientpercentage_input" name="Joint_Funds_on_Deposit_Percent_Marital_Equity_to_Client10" value="<?php if(isset($drfundsondeposit->Joint_Funds_on_Deposit_Percent_Marital_Equity_to_Client10)){ echo $drfundsondeposit->Joint_Funds_on_Deposit_Percent_Marital_Equity_to_Client10; } ?>" min="0.00" step="0.01" max="100" readonly="">
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label>{{$client_name}} Deposite Equity Amount</label>
                                    <input id="Joint_Funds_on_Deposit_Estimated_Value_to_Client10" type="number" class="form-control 10_Joint_clientamount_input clientamount_input" name="Joint_Funds_on_Deposit_Estimated_Value_to_Client10" value="<?php if(isset($drfundsondeposit->Joint_Funds_on_Deposit_Estimated_Value_to_Client10)){ echo $drfundsondeposit->Joint_Funds_on_Deposit_Estimated_Value_to_Client10; } ?>" min="0.00" step="0.01" max="999999.99" readonly="">
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label>{{$opponent_name}} Deposite Equity Percent</label>
                                    <input id="Joint_Funds_on_Deposit_Percent_Marital_Equity_to_Op10" type="number" class="form-control 10_Joint_opponentpercentage_input opponentpercentage_input" name="Joint_Funds_on_Deposit_Percent_Marital_Equity_to_Op10" value="<?php if(isset($drfundsondeposit->Joint_Funds_on_Deposit_Percent_Marital_Equity_to_Op10)){ echo $drfundsondeposit->Joint_Funds_on_Deposit_Percent_Marital_Equity_to_Op10; } ?>" min="0.00" step="0.01" max="100" readonly="">
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label>{{$opponent_name}} Deposite Equity Amount</label>
                                    <input id="Joint_Funds_on_Deposit_Estimated_Value_to_Op10" type="number" class="form-control 10_Joint_opponentamount_input opponentamount_input" name="Joint_Funds_on_Deposit_Estimated_Value_to_Op10" value="<?php if(isset($drfundsondeposit->Joint_Funds_on_Deposit_Estimated_Value_to_Op10)){ echo $drfundsondeposit->Joint_Funds_on_Deposit_Estimated_Value_to_Op10; } ?>" min="0.00" step="0.01" max="999999.99" readonly="">
                                </div>
                                <!-- end of slider tool -->
                            </div>

                            
                        </div>
                        <!-- End of Joint Funds On Deposit Info Section -->

                        <!-- Client Funds On Deposit Info Section -->
                        <div class="form-row num_Client_fundsondeposit_info mt-4" style="display: none;">
                            <h4 class="col-sm-12">{{$client_name}} Funds On Deposit Info Section</h4>
                            <div class="col-sm-6">
                                <label for="Num_Client_Deposit_Accounts">How many deposit accounts in {{$client_name}}’s name only?</label>
                                <input id="Num_Client_Deposit_Accounts" type="number" class="form-control" name="Num_Client_Deposit_Accounts" value="<?php if(isset($drfundsondeposit->Num_Client_Deposit_Accounts)){ echo $drfundsondeposit->Num_Client_Deposit_Accounts; } ?>" min="0" max="10"> 
                            </div>
                        </div>
                        <div class="form-row Client_fundsondeposit_section">
                            <div class="col-sm-12 mt-4 1_Client_fundsondeposit_section" style="display: none;"><h5 class="col-sm-12">First Deposit Account Info</h5>
                                <div class="form-group col-sm-6">
                                    <p class="text-danger 1_Client_no-state-county-found" style="display: none;">No City, State, County found for this zipcode.</p>
                                    <label for="Client_Funds_on_Deposit_Institution_ZIP1">Deposit Institution Zip Code?</label>
                                    <input id="Client_Funds_on_Deposit_Institution_ZIP1" type="text" class="form-control 1_Client_fundsondeposit_inputs" name="Client_Funds_on_Deposit_Institution_ZIP1" value="<?php if(isset($drfundsondeposit->Client_Funds_on_Deposit_Institution_ZIP1)){ echo $drfundsondeposit->Client_Funds_on_Deposit_Institution_ZIP1; } ?>" data-onload="getCityStateForZip(this, '1', 'Client');" onkeyup="getCityStateForZip(this, '1', 'Client');"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Funds_on_Deposit_Institution_Name1">Name of Deposit Institution?</label>
                                    <input id="Client_Funds_on_Deposit_Institution_Name1" type="text" class="form-control 1_Client_fundsondeposit_inputs" name="Client_Funds_on_Deposit_Institution_Name1" value="<?php if(isset($drfundsondeposit->Client_Funds_on_Deposit_Institution_Name1)){ echo $drfundsondeposit->Client_Funds_on_Deposit_Institution_Name1; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Funds_on_Deposit_Institution_Street_Address1">Deposit Institution Street Address?</label>
                                    <input id="Client_Funds_on_Deposit_Institution_Street_Address1" type="text" class="form-control 1_Client_fundsondeposit_inputs" name="Client_Funds_on_Deposit_Institution_Street_Address1" value="<?php if(isset($drfundsondeposit->Client_Funds_on_Deposit_Institution_Street_Address1)){ echo $drfundsondeposit->Client_Funds_on_Deposit_Institution_Street_Address1; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Funds_on_Deposit_Institution_City1">Deposit Institution City?</label>
                                    <input type="hidden" name="" id="Client_Funds_on_Deposit_Institution_City1_Value" value="<?php if(isset($drfundsondeposit->Client_Funds_on_Deposit_Institution_City1)){ echo $drfundsondeposit->Client_Funds_on_Deposit_Institution_City1; } ?>">
                                    <select id="Client_Funds_on_Deposit_Institution_City1" name="Client_Funds_on_Deposit_Institution_City1" class="form-control 1_Client_city_select">
                                        <option value="">Choose City</option>
                                    </select>   
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Funds_on_Deposit_Institution_State1">Deposit Institution State?</label>
                                    <input type="hidden" name="" id="Client_Funds_on_Deposit_Institution_State1_Value" value="<?php if(isset($drfundsondeposit->Client_Funds_on_Deposit_Institution_City1)){ echo $drfundsondeposit->Client_Funds_on_Deposit_Institution_City1; } ?>">
                                    <select id="Client_Funds_on_Deposit_Institution_State1" name="Client_Funds_on_Deposit_Institution_State1" class="form-control 1_Client_state_select">
                                        <option value="">Choose State</option>
                                    </select>   
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Funds_on_Deposit_Institution_Acct_Num1">Account Number?</label>
                                    <input id="Client_Funds_on_Deposit_Institution_Acct_Num1" type="text" class="form-control 1_Client_fundsondeposit_inputs" name="Client_Funds_on_Deposit_Institution_Acct_Num1" value="<?php if(isset($drfundsondeposit->Client_Funds_on_Deposit_Institution_Acct_Num1)){ echo $drfundsondeposit->Client_Funds_on_Deposit_Institution_Acct_Num1; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Name on this account?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Client_Funds_on_Deposit_Institution_Name_on_Acct1_Client" name="Client_Funds_on_Deposit_Institution_Name_on_Acct1" value="{{$client_name}}" <?php if(isset($drfundsondeposit->Client_Funds_on_Deposit_Institution_Name_on_Acct1) && $drfundsondeposit->Client_Funds_on_Deposit_Institution_Name_on_Acct1==$client_name){ echo "checked"; } ?>> {{$client_name}}</label>
                                        <label><input type="radio" id="Client_Funds_on_Deposit_Institution_Name_on_Acct1_Op" name="Client_Funds_on_Deposit_Institution_Name_on_Acct1" value="{{$opponent_name}}" <?php if(isset($drfundsondeposit->Client_Funds_on_Deposit_Institution_Name_on_Acct1) && $drfundsondeposit->Client_Funds_on_Deposit_Institution_Name_on_Acct1==$opponent_name){ echo "checked"; } ?>> {{$opponent_name}}</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Funds_on_Deposit_Institution_Current_Balance1">Current Balance?</label>
                                    <input id="Client_Funds_on_Deposit_Institution_Current_Balance1" type="number" class="form-control 1_Client_fundsondeposit_inputs" name="Client_Funds_on_Deposit_Institution_Current_Balance1" value="<?php if(isset($drfundsondeposit->Client_Funds_on_Deposit_Institution_Current_Balance1)){ echo $drfundsondeposit->Client_Funds_on_Deposit_Institution_Current_Balance1; } ?>" min="0.00" step="0.01" max="999999.99" onchange="getClientOpCurrentBalance(this, '1', 'Client');" onkeyup="getClientOpCurrentBalance(this, '1', 'Client');"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Funds_on_Deposit_Institution_Yearly_Interest_Dividend1">Yearly Interest?</label>
                                    <input id="Client_Funds_on_Deposit_Institution_Yearly_Interest_Dividend1" type="number" class="form-control 1_Client_fundsondeposit_inputs" name="Client_Funds_on_Deposit_Institution_Yearly_Interest_Dividend1" value="<?php if(isset($drfundsondeposit->Client_Funds_on_Deposit_Institution_Yearly_Interest_Dividend1)){ echo $drfundsondeposit->Client_Funds_on_Deposit_Institution_Yearly_Interest_Dividend1; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Funds_on_Deposit_Institution_Balance_Date_of_Marriage1">Balance on marriage date (0.00, if started after marriage)?</label>
                                    <input id="Client_Funds_on_Deposit_Institution_Balance_Date_of_Marriage1" type="number" class="form-control 1_Client_fundsondeposit_inputs" name="Client_Funds_on_Deposit_Institution_Balance_Date_of_Marriage1" value="<?php if(isset($drfundsondeposit->Client_Funds_on_Deposit_Institution_Balance_Date_of_Marriage1)){ echo $drfundsondeposit->Client_Funds_on_Deposit_Institution_Balance_Date_of_Marriage1; } ?>" min="0.00" step="0.01" max="999999.99" onchange="getClientOpCurrentBalance(this, '1', 'Client');" onkeyup="getClientOpCurrentBalance(this, '1', 'Client');"> 
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label for="Client_Funds_on_Deposit_Estimated_MaritalEquity1">N/A, calculated = Client_Funds_on_Deposit_Institution_Current_Balance1 – Client_Funds_on_Deposit_Institution_Balance_Date_of_Marriage1</label>
                                    <input id="Client_Funds_on_Deposit_Estimated_MaritalEquity1" type="number" class="form-control 1_Client_fundsondeposit_inputs" name="Client_Funds_on_Deposit_Estimated_MaritalEquity1" value="<?php if(isset($drfundsondeposit->Client_Funds_on_Deposit_Estimated_MaritalEquity1)){ echo $drfundsondeposit->Client_Funds_on_Deposit_Estimated_MaritalEquity1; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Does either party claim a sole/separate interest from the other on this fund?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Client_Funds_on_Deposit_SoleSeparate_Claim1_Yes" name="Client_Funds_on_Deposit_SoleSeparate_Claim1" value="Yes" <?php if(isset($drfundsondeposit->Client_Funds_on_Deposit_SoleSeparate_Claim1) && $drfundsondeposit->Client_Funds_on_Deposit_SoleSeparate_Claim1=='Yes'){ echo "checked"; } ?>> Yes</label>
                                        <label><input type="radio" id="Client_Funds_on_Deposit_SoleSeparate_Claim1_No" name="Client_Funds_on_Deposit_SoleSeparate_Claim1" value="No" <?php if(isset($drfundsondeposit->Client_Funds_on_Deposit_SoleSeparate_Claim1) && $drfundsondeposit->Client_Funds_on_Deposit_SoleSeparate_Claim1=='No'){ echo "checked"; } ?>> No</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Who claims to own this fund?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Client_Funds_on_Deposit_SoleSeparate_Party1_Client" name="Client_Funds_on_Deposit_SoleSeparate_Party1" value="{{$client_name}}" <?php if(isset($drfundsondeposit->Client_Funds_on_Deposit_SoleSeparate_Party1) && $drfundsondeposit->Client_Funds_on_Deposit_SoleSeparate_Party1==$client_name){ echo "checked"; } ?>> {{$client_name}}</label>
                                        <label><input type="radio" id="Client_Funds_on_Deposit_SoleSeparate_Party1_Op" name="Client_Funds_on_Deposit_SoleSeparate_Party1" value="{{$opponent_name}}" <?php if(isset($drfundsondeposit->Client_Funds_on_Deposit_SoleSeparate_Party1) && $drfundsondeposit->Client_Funds_on_Deposit_SoleSeparate_Party1==$opponent_name){ echo "checked"; } ?>> {{$opponent_name}}</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 left-clear">
                                    <label for="Client_Funds_on_Deposit_SoleSeparate_Grounds1">Why does this person own this fund solely and separately?</label>
                                    <input id="Client_Funds_on_Deposit_SoleSeparate_Grounds1" type="text" class="form-control 1_Client_fundsondeposit_inputs" name="Client_Funds_on_Deposit_SoleSeparate_Grounds1" value="<?php if(isset($drfundsondeposit->Client_Funds_on_Deposit_SoleSeparate_Grounds1)){ echo $drfundsondeposit->Client_Funds_on_Deposit_SoleSeparate_Grounds1; } ?>"> 
                                </div>
                                <!-- slider tool -->
                                <div class="form-group col-sm-6 m-auto slider-tool-main">
                                    <div class="row">
                                        <div class="col">{{$client_name}}</div>
                                        <div class="col text-right">{{$opponent_name}}</div>
                                    </div>
                                    <input id="1_Client_balance_range_selector" type="range" class="form-control slider-tool-input 1_Client_balance_range_selector" name="" value="<?php if(isset($drfundsondeposit->Client_Funds_on_Deposit_Percent_Marital_Equity_to_Op1)){ echo $drfundsondeposit->Client_Funds_on_Deposit_Percent_Marital_Equity_to_Op1; } ?>" min="0.00" step="0.01" max="100" onchange="updateBalanceInput(this.value, '1', 'Client');">
                                </div>
                                <div class="form-group col-sm-6 m-auto slider-tool-main">
                                    <div class="row justify-content-between">
                                        <div class="col selectorTool">
                                            <div class="left-col">
                                                <div class="client-info 1_Client_clientpercentage_div clientpercentage_div">
                                                    <?php if(isset($drfundsondeposit->Client_Funds_on_Deposit_Percent_Marital_Equity_to_Client1)){ echo $drfundsondeposit->Client_Funds_on_Deposit_Percent_Marital_Equity_to_Client1; } else {
                                                        echo "50.00";
                                                    } ?>%
                                                </div>
                                                <div class="client-info 1_Client_clientamount_div clientamount_div" style="clear: both;">
                                                    $<?php if(isset($drfundsondeposit->Client_Funds_on_Deposit_Estimated_Value_to_Client1)){ echo $drfundsondeposit->Client_Funds_on_Deposit_Estimated_Value_to_Client1; } ?>
                                                </div>
                                            </div>
                                            <label>To {{$client_name}}</label>
                                        </div>                                       
                                        <div class="col selectorTool selectorToolRight">
                                            <label>To {{$opponent_name}}</label>
                                            <div class="left-col right-col">
                                                <div class="client-info 1_Client_opponentpercentage_div opponentpercentage_div">
                                                    <?php if(isset($drfundsondeposit->Client_Funds_on_Deposit_Percent_Marital_Equity_to_Op1)){ echo $drfundsondeposit->Client_Funds_on_Deposit_Percent_Marital_Equity_to_Op1; } else {
                                                        echo "50.00";
                                                    } ?>%
                                                </div>
                                                <div class="client-info 1_Client_opponentamount_div opponentamount_div" style="clear: both;">
                                                    $<?php if(isset($drfundsondeposit->Client_Funds_on_Deposit_Estimated_Value_to_Op1)){ echo $drfundsondeposit->Client_Funds_on_Deposit_Estimated_Value_to_Op1; } ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 m-auto slider-tool-main">
                                    <label></label>
                                    <div class="w-100">
                                        <label><input type="radio" id="1_Client_Funds_on_Deposit_Estimated_Value_Select" name="1_Client_Funds_on_Deposit_Estimated_Value_Select_Reset" class="Funds_on_Deposit_Estimated_Value_Select_Reset" value="Save"> Save this Distribution of Deposit Account #1</label>
                                        <label><input type="radio" id="1_Client_Funds_on_Deposit_Estimated_Value_Reset" name="1_Client_Funds_on_Deposit_Estimated_Value_Select_Reset" class="Funds_on_Deposit_Estimated_Value_Select_Reset" value="Reset" onclick="resetBalanceInput(this, '1', 'Client');"> Reset to Default (50%)</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label>{{$client_name}} Deposite Equity Percent</label>
                                    <input id="Client_Funds_on_Deposit_Percent_Marital_Equity_to_Client1" type="number" class="form-control 1_Client_clientpercentage_input clientpercentage_input" name="Client_Funds_on_Deposit_Percent_Marital_Equity_to_Client1" value="<?php if(isset($drfundsondeposit->Client_Funds_on_Deposit_Percent_Marital_Equity_to_Client1)){ echo $drfundsondeposit->Client_Funds_on_Deposit_Percent_Marital_Equity_to_Client1; } ?>" min="0.00" step="0.01" max="100" readonly="">
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label>{{$client_name}} Deposite Equity Amount</label>
                                    <input id="Client_Funds_on_Deposit_Estimated_Value_to_Client1" type="number" class="form-control 1_Client_clientamount_input clientamount_input" name="Client_Funds_on_Deposit_Estimated_Value_to_Client1" value="<?php if(isset($drfundsondeposit->Client_Funds_on_Deposit_Estimated_Value_to_Client1)){ echo $drfundsondeposit->Client_Funds_on_Deposit_Estimated_Value_to_Client1; } ?>" min="0.00" step="0.01" max="999999.99" readonly="">
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label>{{$opponent_name}} Deposite Equity Percent</label>
                                    <input id="Client_Funds_on_Deposit_Percent_Marital_Equity_to_Op1" type="number" class="form-control 1_Client_opponentpercentage_input opponentpercentage_input" name="Client_Funds_on_Deposit_Percent_Marital_Equity_to_Op1" value="<?php if(isset($drfundsondeposit->Client_Funds_on_Deposit_Percent_Marital_Equity_to_Op1)){ echo $drfundsondeposit->Client_Funds_on_Deposit_Percent_Marital_Equity_to_Op1; } ?>" min="0.00" step="0.01" max="100" readonly="">
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label>{{$opponent_name}} Deposite Equity Amount</label>
                                    <input id="Client_Funds_on_Deposit_Estimated_Value_to_Op1" type="number" class="form-control 1_Client_opponentamount_input opponentamount_input" name="Client_Funds_on_Deposit_Estimated_Value_to_Op1" value="<?php if(isset($drfundsondeposit->Client_Funds_on_Deposit_Estimated_Value_to_Op1)){ echo $drfundsondeposit->Client_Funds_on_Deposit_Estimated_Value_to_Op1; } ?>" min="0.00" step="0.01" max="999999.99" readonly="">
                                </div>
                                <!-- end of slider tool -->
                            </div>
                            <div class="col-sm-12 mt-4 2_Client_fundsondeposit_section" style="display: none;"><h5 class="col-sm-12">Second Deposit Account Info</h5>
                                <div class="form-group col-sm-6">
                                    <p class="text-danger 2_Client_no-state-county-found" style="display: none;">No City, State, County found for this zipcode.</p>
                                    <label for="Client_Funds_on_Deposit_Institution_ZIP2">Deposit Institution Zip Code?</label>
                                    <input id="Client_Funds_on_Deposit_Institution_ZIP2" type="text" class="form-control 2_Client_fundsondeposit_inputs" name="Client_Funds_on_Deposit_Institution_ZIP2" value="<?php if(isset($drfundsondeposit->Client_Funds_on_Deposit_Institution_ZIP2)){ echo $drfundsondeposit->Client_Funds_on_Deposit_Institution_ZIP2; } ?>" data-onload="getCityStateForZip(this, '2', 'Client');" onkeyup="getCityStateForZip(this, '2', 'Client');"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Funds_on_Deposit_Institution_Name2">Name of Deposit Institution?</label>
                                    <input id="Client_Funds_on_Deposit_Institution_Name2" type="text" class="form-control 2_Client_fundsondeposit_inputs" name="Client_Funds_on_Deposit_Institution_Name2" value="<?php if(isset($drfundsondeposit->Client_Funds_on_Deposit_Institution_Name2)){ echo $drfundsondeposit->Client_Funds_on_Deposit_Institution_Name2; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Funds_on_Deposit_Institution_Street_Address2">Deposit Institution Street Address?</label>
                                    <input id="Client_Funds_on_Deposit_Institution_Street_Address2" type="text" class="form-control 2_Client_fundsondeposit_inputs" name="Client_Funds_on_Deposit_Institution_Street_Address2" value="<?php if(isset($drfundsondeposit->Client_Funds_on_Deposit_Institution_Street_Address2)){ echo $drfundsondeposit->Client_Funds_on_Deposit_Institution_Street_Address2; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Funds_on_Deposit_Institution_City2">Deposit Institution City?</label>
                                    <input type="hidden" name="" id="Client_Funds_on_Deposit_Institution_City2_Value" value="<?php if(isset($drfundsondeposit->Client_Funds_on_Deposit_Institution_City2)){ echo $drfundsondeposit->Client_Funds_on_Deposit_Institution_City2; } ?>">
                                    <select id="Client_Funds_on_Deposit_Institution_City2" name="Client_Funds_on_Deposit_Institution_City2" class="form-control 2_Client_city_select">
                                        <option value="">Choose City</option>
                                    </select>   
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Funds_on_Deposit_Institution_State2">Deposit Institution State?</label>
                                    <input type="hidden" name="" id="Client_Funds_on_Deposit_Institution_State2_Value" value="<?php if(isset($drfundsondeposit->Client_Funds_on_Deposit_Institution_City2)){ echo $drfundsondeposit->Client_Funds_on_Deposit_Institution_City2; } ?>">
                                    <select id="Client_Funds_on_Deposit_Institution_State2" name="Client_Funds_on_Deposit_Institution_State2" class="form-control 2_Client_state_select">
                                        <option value="">Choose State</option>
                                    </select>   
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Funds_on_Deposit_Institution_Acct_Num2">Account Number?</label>
                                    <input id="Client_Funds_on_Deposit_Institution_Acct_Num2" type="text" class="form-control 2_Client_fundsondeposit_inputs" name="Client_Funds_on_Deposit_Institution_Acct_Num2" value="<?php if(isset($drfundsondeposit->Client_Funds_on_Deposit_Institution_Acct_Num2)){ echo $drfundsondeposit->Client_Funds_on_Deposit_Institution_Acct_Num2; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Name on this account?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Client_Funds_on_Deposit_Institution_Name_on_Acct2_Client" name="Client_Funds_on_Deposit_Institution_Name_on_Acct2" value="{{$client_name}}" <?php if(isset($drfundsondeposit->Client_Funds_on_Deposit_Institution_Name_on_Acct2) && $drfundsondeposit->Client_Funds_on_Deposit_Institution_Name_on_Acct2==$client_name){ echo "checked"; } ?>> {{$client_name}}</label>
                                        <label><input type="radio" id="Client_Funds_on_Deposit_Institution_Name_on_Acct2_Op" name="Client_Funds_on_Deposit_Institution_Name_on_Acct2" value="{{$opponent_name}}" <?php if(isset($drfundsondeposit->Client_Funds_on_Deposit_Institution_Name_on_Acct2) && $drfundsondeposit->Client_Funds_on_Deposit_Institution_Name_on_Acct2==$opponent_name){ echo "checked"; } ?>> {{$opponent_name}}</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Funds_on_Deposit_Institution_Current_Balance2">Current Balance?</label>
                                    <input id="Client_Funds_on_Deposit_Institution_Current_Balance2" type="number" class="form-control 2_Client_fundsondeposit_inputs" name="Client_Funds_on_Deposit_Institution_Current_Balance2" value="<?php if(isset($drfundsondeposit->Client_Funds_on_Deposit_Institution_Current_Balance2)){ echo $drfundsondeposit->Client_Funds_on_Deposit_Institution_Current_Balance2; } ?>" min="0.00" step="0.01" max="999999.99" onchange="getClientOpCurrentBalance(this, '2', 'Client');" onkeyup="getClientOpCurrentBalance(this, '2', 'Client');"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Funds_on_Deposit_Institution_Yearly_Interest_Dividend2">Yearly Interest?</label>
                                    <input id="Client_Funds_on_Deposit_Institution_Yearly_Interest_Dividend2" type="number" class="form-control 2_Client_fundsondeposit_inputs" name="Client_Funds_on_Deposit_Institution_Yearly_Interest_Dividend2" value="<?php if(isset($drfundsondeposit->Client_Funds_on_Deposit_Institution_Yearly_Interest_Dividend2)){ echo $drfundsondeposit->Client_Funds_on_Deposit_Institution_Yearly_Interest_Dividend2; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Funds_on_Deposit_Institution_Balance_Date_of_Marriage2">Balance on marriage date (0.00, if started after marriage)?</label>
                                    <input id="Client_Funds_on_Deposit_Institution_Balance_Date_of_Marriage2" type="number" class="form-control 2_Client_fundsondeposit_inputs" name="Client_Funds_on_Deposit_Institution_Balance_Date_of_Marriage2" value="<?php if(isset($drfundsondeposit->Client_Funds_on_Deposit_Institution_Balance_Date_of_Marriage2)){ echo $drfundsondeposit->Client_Funds_on_Deposit_Institution_Balance_Date_of_Marriage2; } ?>" min="0.00" step="0.01" max="999999.99" onchange="getClientOpCurrentBalance(this, '2', 'Client');" onkeyup="getClientOpCurrentBalance(this, '2', 'Client');"> 
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label for="Client_Funds_on_Deposit_Estimated_MaritalEquity2">N/A, calculated = Client_Funds_on_Deposit_Institution_Current_Balance2 – Client_Funds_on_Deposit_Institution_Balance_Date_of_Marriage2</label>
                                    <input id="Client_Funds_on_Deposit_Estimated_MaritalEquity2" type="number" class="form-control 2_Client_fundsondeposit_inputs" name="Client_Funds_on_Deposit_Estimated_MaritalEquity2" value="<?php if(isset($drfundsondeposit->Client_Funds_on_Deposit_Estimated_MaritalEquity2)){ echo $drfundsondeposit->Client_Funds_on_Deposit_Estimated_MaritalEquity2; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Does either party claim a sole/separate interest from the other on this fund?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Client_Funds_on_Deposit_SoleSeparate_Claim2_Yes" name="Client_Funds_on_Deposit_SoleSeparate_Claim2" value="Yes" <?php if(isset($drfundsondeposit->Client_Funds_on_Deposit_SoleSeparate_Claim2) && $drfundsondeposit->Client_Funds_on_Deposit_SoleSeparate_Claim2=='Yes'){ echo "checked"; } ?>> Yes</label>
                                        <label><input type="radio" id="Client_Funds_on_Deposit_SoleSeparate_Claim2_No" name="Client_Funds_on_Deposit_SoleSeparate_Claim2" value="No" <?php if(isset($drfundsondeposit->Client_Funds_on_Deposit_SoleSeparate_Claim2) && $drfundsondeposit->Client_Funds_on_Deposit_SoleSeparate_Claim2=='No'){ echo "checked"; } ?>> No</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Who claims to own this fund?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Client_Funds_on_Deposit_SoleSeparate_Party2_Client" name="Client_Funds_on_Deposit_SoleSeparate_Party2" value="{{$client_name}}" <?php if(isset($drfundsondeposit->Client_Funds_on_Deposit_SoleSeparate_Party2) && $drfundsondeposit->Client_Funds_on_Deposit_SoleSeparate_Party2==$client_name){ echo "checked"; } ?>> {{$client_name}}</label>
                                        <label><input type="radio" id="Client_Funds_on_Deposit_SoleSeparate_Party2_Op" name="Client_Funds_on_Deposit_SoleSeparate_Party2" value="{{$opponent_name}}" <?php if(isset($drfundsondeposit->Client_Funds_on_Deposit_SoleSeparate_Party2) && $drfundsondeposit->Client_Funds_on_Deposit_SoleSeparate_Party2==$opponent_name){ echo "checked"; } ?>> {{$opponent_name}}</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 left-clear">
                                    <label for="Client_Funds_on_Deposit_SoleSeparate_Grounds2">Why does this person own this fund solely and separately?</label>
                                    <input id="Client_Funds_on_Deposit_SoleSeparate_Grounds2" type="text" class="form-control 2_Client_fundsondeposit_inputs" name="Client_Funds_on_Deposit_SoleSeparate_Grounds2" value="<?php if(isset($drfundsondeposit->Client_Funds_on_Deposit_SoleSeparate_Grounds2)){ echo $drfundsondeposit->Client_Funds_on_Deposit_SoleSeparate_Grounds2; } ?>"> 
                                </div>
                                <!-- slider tool -->
                                <div class="form-group col-sm-6 m-auto slider-tool-main">
                                    <div class="row">
                                        <div class="col">{{$client_name}}</div>
                                        <div class="col text-right">{{$opponent_name}}</div>
                                    </div>
                                    <input id="2_Client_balance_range_selector" type="range" class="form-control slider-tool-input 2_Client_balance_range_selector" name="" value="<?php if(isset($drfundsondeposit->Client_Funds_on_Deposit_Percent_Marital_Equity_to_Op2)){ echo $drfundsondeposit->Client_Funds_on_Deposit_Percent_Marital_Equity_to_Op2; } ?>" min="0.00" step="0.01" max="100" onchange="updateBalanceInput(this.value, '2', 'Client');">
                                </div>
                                <div class="form-group col-sm-6 m-auto slider-tool-main">
                                    <div class="row justify-content-between">
                                        <div class="col selectorTool">
                                            <div class="left-col">
                                                <div class="client-info 2_Client_clientpercentage_div clientpercentage_div">
                                                    <?php if(isset($drfundsondeposit->Client_Funds_on_Deposit_Percent_Marital_Equity_to_Client2)){ echo $drfundsondeposit->Client_Funds_on_Deposit_Percent_Marital_Equity_to_Client2; } else {
                                                        echo "50.00";
                                                    } ?>%
                                                </div>
                                                <div class="client-info 2_Client_clientamount_div clientamount_div" style="clear: both;">
                                                    $<?php if(isset($drfundsondeposit->Client_Funds_on_Deposit_Estimated_Value_to_Client2)){ echo $drfundsondeposit->Client_Funds_on_Deposit_Estimated_Value_to_Client2; } ?>
                                                </div>
                                            </div>
                                            <label>To {{$client_name}}</label>
                                        </div>                                       
                                        <div class="col selectorTool selectorToolRight">
                                            <label>To {{$opponent_name}}</label>
                                            <div class="left-col right-col">
                                                <div class="client-info 2_Client_opponentpercentage_div opponentpercentage_div">
                                                    <?php if(isset($drfundsondeposit->Client_Funds_on_Deposit_Percent_Marital_Equity_to_Op2)){ echo $drfundsondeposit->Client_Funds_on_Deposit_Percent_Marital_Equity_to_Op2; } else {
                                                        echo "50.00";
                                                    } ?>%
                                                </div>
                                                <div class="client-info 2_Client_opponentamount_div opponentamount_div" style="clear: both;">
                                                    $<?php if(isset($drfundsondeposit->Client_Funds_on_Deposit_Estimated_Value_to_Op2)){ echo $drfundsondeposit->Client_Funds_on_Deposit_Estimated_Value_to_Op2; } ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 m-auto slider-tool-main">
                                    <label></label>
                                    <div class="w-100">
                                        <label><input type="radio" id="2_Client_Funds_on_Deposit_Estimated_Value_Select" name="2_Client_Funds_on_Deposit_Estimated_Value_Select_Reset" class="Funds_on_Deposit_Estimated_Value_Select_Reset" value="Save"> Save this Distribution of Deposit Account #2</label>
                                        <label><input type="radio" id="2_Client_Funds_on_Deposit_Estimated_Value_Reset" name="2_Client_Funds_on_Deposit_Estimated_Value_Select_Reset" class="Funds_on_Deposit_Estimated_Value_Select_Reset" value="Reset" onclick="resetBalanceInput(this, '2', 'Client');"> Reset to Default (50%)</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label>{{$client_name}} Deposite Equity Percent</label>
                                    <input id="Client_Funds_on_Deposit_Percent_Marital_Equity_to_Client2" type="number" class="form-control 2_Client_clientpercentage_input clientpercentage_input" name="Client_Funds_on_Deposit_Percent_Marital_Equity_to_Client2" value="<?php if(isset($drfundsondeposit->Client_Funds_on_Deposit_Percent_Marital_Equity_to_Client2)){ echo $drfundsondeposit->Client_Funds_on_Deposit_Percent_Marital_Equity_to_Client2; } ?>" min="0.00" step="0.01" max="100" readonly="">
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label>{{$client_name}} Deposite Equity Amount</label>
                                    <input id="Client_Funds_on_Deposit_Estimated_Value_to_Client2" type="number" class="form-control 2_Client_clientamount_input clientamount_input" name="Client_Funds_on_Deposit_Estimated_Value_to_Client2" value="<?php if(isset($drfundsondeposit->Client_Funds_on_Deposit_Estimated_Value_to_Client2)){ echo $drfundsondeposit->Client_Funds_on_Deposit_Estimated_Value_to_Client2; } ?>" min="0.00" step="0.01" max="999999.99" readonly="">
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label>{{$opponent_name}} Deposite Equity Percent</label>
                                    <input id="Client_Funds_on_Deposit_Percent_Marital_Equity_to_Op2" type="number" class="form-control 2_Client_opponentpercentage_input opponentpercentage_input" name="Client_Funds_on_Deposit_Percent_Marital_Equity_to_Op2" value="<?php if(isset($drfundsondeposit->Client_Funds_on_Deposit_Percent_Marital_Equity_to_Op2)){ echo $drfundsondeposit->Client_Funds_on_Deposit_Percent_Marital_Equity_to_Op2; } ?>" min="0.00" step="0.01" max="100" readonly="">
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label>{{$opponent_name}} Deposite Equity Amount</label>
                                    <input id="Client_Funds_on_Deposit_Estimated_Value_to_Op2" type="number" class="form-control 2_Client_opponentamount_input opponentamount_input" name="Client_Funds_on_Deposit_Estimated_Value_to_Op2" value="<?php if(isset($drfundsondeposit->Client_Funds_on_Deposit_Estimated_Value_to_Op2)){ echo $drfundsondeposit->Client_Funds_on_Deposit_Estimated_Value_to_Op2; } ?>" min="0.00" step="0.01" max="999999.99" readonly="">
                                </div>
                                <!-- end of slider tool -->
                            </div>
                            <div class="col-sm-12 mt-4 3_Client_fundsondeposit_section" style="display: none;"><h5 class="col-sm-12">Third Deposit Account Info</h5>
                                <div class="form-group col-sm-6">
                                    <p class="text-danger 3_Client_no-state-county-found" style="display: none;">No City, State, County found for this zipcode.</p>
                                    <label for="Client_Funds_on_Deposit_Institution_ZIP3">Deposit Institution Zip Code?</label>
                                    <input id="Client_Funds_on_Deposit_Institution_ZIP3" type="text" class="form-control 3_Client_fundsondeposit_inputs" name="Client_Funds_on_Deposit_Institution_ZIP3" value="<?php if(isset($drfundsondeposit->Client_Funds_on_Deposit_Institution_ZIP3)){ echo $drfundsondeposit->Client_Funds_on_Deposit_Institution_ZIP3; } ?>" data-onload="getCityStateForZip(this, '3', 'Client');" onkeyup="getCityStateForZip(this, '3', 'Client');"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Funds_on_Deposit_Institution_Name3">Name of Deposit Institution?</label>
                                    <input id="Client_Funds_on_Deposit_Institution_Name3" type="text" class="form-control 3_Client_fundsondeposit_inputs" name="Client_Funds_on_Deposit_Institution_Name3" value="<?php if(isset($drfundsondeposit->Client_Funds_on_Deposit_Institution_Name3)){ echo $drfundsondeposit->Client_Funds_on_Deposit_Institution_Name3; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Funds_on_Deposit_Institution_Street_Address3">Deposit Institution Street Address?</label>
                                    <input id="Client_Funds_on_Deposit_Institution_Street_Address3" type="text" class="form-control 3_Client_fundsondeposit_inputs" name="Client_Funds_on_Deposit_Institution_Street_Address3" value="<?php if(isset($drfundsondeposit->Client_Funds_on_Deposit_Institution_Street_Address3)){ echo $drfundsondeposit->Client_Funds_on_Deposit_Institution_Street_Address3; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Funds_on_Deposit_Institution_City3">Deposit Institution City?</label>
                                    <input type="hidden" name="" id="Client_Funds_on_Deposit_Institution_City3_Value" value="<?php if(isset($drfundsondeposit->Client_Funds_on_Deposit_Institution_City3)){ echo $drfundsondeposit->Client_Funds_on_Deposit_Institution_City3; } ?>">
                                    <select id="Client_Funds_on_Deposit_Institution_City3" name="Client_Funds_on_Deposit_Institution_City3" class="form-control 3_Client_city_select">
                                        <option value="">Choose City</option>
                                    </select>   
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Funds_on_Deposit_Institution_State3">Deposit Institution State?</label>
                                    <input type="hidden" name="" id="Client_Funds_on_Deposit_Institution_State3_Value" value="<?php if(isset($drfundsondeposit->Client_Funds_on_Deposit_Institution_City3)){ echo $drfundsondeposit->Client_Funds_on_Deposit_Institution_City3; } ?>">
                                    <select id="Client_Funds_on_Deposit_Institution_State3" name="Client_Funds_on_Deposit_Institution_State3" class="form-control 3_Client_state_select">
                                        <option value="">Choose State</option>
                                    </select>   
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Funds_on_Deposit_Institution_Acct_Num3">Account Number?</label>
                                    <input id="Client_Funds_on_Deposit_Institution_Acct_Num3" type="text" class="form-control 3_Client_fundsondeposit_inputs" name="Client_Funds_on_Deposit_Institution_Acct_Num3" value="<?php if(isset($drfundsondeposit->Client_Funds_on_Deposit_Institution_Acct_Num3)){ echo $drfundsondeposit->Client_Funds_on_Deposit_Institution_Acct_Num3; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Name on this account?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Client_Funds_on_Deposit_Institution_Name_on_Acct3_Client" name="Client_Funds_on_Deposit_Institution_Name_on_Acct3" value="{{$client_name}}" <?php if(isset($drfundsondeposit->Client_Funds_on_Deposit_Institution_Name_on_Acct3) && $drfundsondeposit->Client_Funds_on_Deposit_Institution_Name_on_Acct3==$client_name){ echo "checked"; } ?>> {{$client_name}}</label>
                                        <label><input type="radio" id="Client_Funds_on_Deposit_Institution_Name_on_Acct3_Op" name="Client_Funds_on_Deposit_Institution_Name_on_Acct3" value="{{$opponent_name}}" <?php if(isset($drfundsondeposit->Client_Funds_on_Deposit_Institution_Name_on_Acct3) && $drfundsondeposit->Client_Funds_on_Deposit_Institution_Name_on_Acct3==$opponent_name){ echo "checked"; } ?>> {{$opponent_name}}</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Funds_on_Deposit_Institution_Current_Balance3">Current Balance?</label>
                                    <input id="Client_Funds_on_Deposit_Institution_Current_Balance3" type="number" class="form-control 3_Client_fundsondeposit_inputs" name="Client_Funds_on_Deposit_Institution_Current_Balance3" value="<?php if(isset($drfundsondeposit->Client_Funds_on_Deposit_Institution_Current_Balance3)){ echo $drfundsondeposit->Client_Funds_on_Deposit_Institution_Current_Balance3; } ?>" min="0.00" step="0.01" max="999999.99" onchange="getClientOpCurrentBalance(this, '3', 'Client');" onkeyup="getClientOpCurrentBalance(this, '3', 'Client');"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Funds_on_Deposit_Institution_Yearly_Interest_Dividend3">Yearly Interest?</label>
                                    <input id="Client_Funds_on_Deposit_Institution_Yearly_Interest_Dividend3" type="number" class="form-control 3_Client_fundsondeposit_inputs" name="Client_Funds_on_Deposit_Institution_Yearly_Interest_Dividend3" value="<?php if(isset($drfundsondeposit->Client_Funds_on_Deposit_Institution_Yearly_Interest_Dividend3)){ echo $drfundsondeposit->Client_Funds_on_Deposit_Institution_Yearly_Interest_Dividend3; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Funds_on_Deposit_Institution_Balance_Date_of_Marriage3">Balance on marriage date (0.00, if started after marriage)?</label>
                                    <input id="Client_Funds_on_Deposit_Institution_Balance_Date_of_Marriage3" type="number" class="form-control 3_Client_fundsondeposit_inputs" name="Client_Funds_on_Deposit_Institution_Balance_Date_of_Marriage3" value="<?php if(isset($drfundsondeposit->Client_Funds_on_Deposit_Institution_Balance_Date_of_Marriage3)){ echo $drfundsondeposit->Client_Funds_on_Deposit_Institution_Balance_Date_of_Marriage3; } ?>" min="0.00" step="0.01" max="999999.99" onchange="getClientOpCurrentBalance(this, '3', 'Client');" onkeyup="getClientOpCurrentBalance(this, '3', 'Client');"> 
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label for="Client_Funds_on_Deposit_Estimated_MaritalEquity3">N/A, calculated = Client_Funds_on_Deposit_Institution_Current_Balance3 – Client_Funds_on_Deposit_Institution_Balance_Date_of_Marriage3</label>
                                    <input id="Client_Funds_on_Deposit_Estimated_MaritalEquity3" type="number" class="form-control 3_Client_fundsondeposit_inputs" name="Client_Funds_on_Deposit_Estimated_MaritalEquity3" value="<?php if(isset($drfundsondeposit->Client_Funds_on_Deposit_Estimated_MaritalEquity3)){ echo $drfundsondeposit->Client_Funds_on_Deposit_Estimated_MaritalEquity3; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Does either party claim a sole/separate interest from the other on this fund?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Client_Funds_on_Deposit_SoleSeparate_Claim3_Yes" name="Client_Funds_on_Deposit_SoleSeparate_Claim3" value="Yes" <?php if(isset($drfundsondeposit->Client_Funds_on_Deposit_SoleSeparate_Claim3) && $drfundsondeposit->Client_Funds_on_Deposit_SoleSeparate_Claim3=='Yes'){ echo "checked"; } ?>> Yes</label>
                                        <label><input type="radio" id="Client_Funds_on_Deposit_SoleSeparate_Claim3_No" name="Client_Funds_on_Deposit_SoleSeparate_Claim3" value="No" <?php if(isset($drfundsondeposit->Client_Funds_on_Deposit_SoleSeparate_Claim3) && $drfundsondeposit->Client_Funds_on_Deposit_SoleSeparate_Claim3=='No'){ echo "checked"; } ?>> No</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Who claims to own this fund?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Client_Funds_on_Deposit_SoleSeparate_Party3_Client" name="Client_Funds_on_Deposit_SoleSeparate_Party3" value="{{$client_name}}" <?php if(isset($drfundsondeposit->Client_Funds_on_Deposit_SoleSeparate_Party3) && $drfundsondeposit->Client_Funds_on_Deposit_SoleSeparate_Party3==$client_name){ echo "checked"; } ?>> {{$client_name}}</label>
                                        <label><input type="radio" id="Client_Funds_on_Deposit_SoleSeparate_Party3_Op" name="Client_Funds_on_Deposit_SoleSeparate_Party3" value="{{$opponent_name}}" <?php if(isset($drfundsondeposit->Client_Funds_on_Deposit_SoleSeparate_Party3) && $drfundsondeposit->Client_Funds_on_Deposit_SoleSeparate_Party3==$opponent_name){ echo "checked"; } ?>> {{$opponent_name}}</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 left-clear">
                                    <label for="Client_Funds_on_Deposit_SoleSeparate_Grounds3">Why does this person own this fund solely and separately?</label>
                                    <input id="Client_Funds_on_Deposit_SoleSeparate_Grounds3" type="text" class="form-control 3_Client_fundsondeposit_inputs" name="Client_Funds_on_Deposit_SoleSeparate_Grounds3" value="<?php if(isset($drfundsondeposit->Client_Funds_on_Deposit_SoleSeparate_Grounds3)){ echo $drfundsondeposit->Client_Funds_on_Deposit_SoleSeparate_Grounds3; } ?>"> 
                                </div>
                                <!-- slider tool -->
                                <div class="form-group col-sm-6 m-auto slider-tool-main">
                                    <div class="row">
                                        <div class="col">{{$client_name}}</div>
                                        <div class="col text-right">{{$opponent_name}}</div>
                                    </div>
                                    <input id="3_Client_balance_range_selector" type="range" class="form-control slider-tool-input 3_Client_balance_range_selector" name="" value="<?php if(isset($drfundsondeposit->Client_Funds_on_Deposit_Percent_Marital_Equity_to_Op3)){ echo $drfundsondeposit->Client_Funds_on_Deposit_Percent_Marital_Equity_to_Op3; } ?>" min="0.00" step="0.01" max="100" onchange="updateBalanceInput(this.value, '3', 'Client');">
                                </div>
                                <div class="form-group col-sm-6 m-auto slider-tool-main">
                                    <div class="row justify-content-between">
                                        <div class="col selectorTool">
                                            <div class="left-col">
                                                <div class="client-info 3_Client_clientpercentage_div clientpercentage_div">
                                                    <?php if(isset($drfundsondeposit->Client_Funds_on_Deposit_Percent_Marital_Equity_to_Client3)){ echo $drfundsondeposit->Client_Funds_on_Deposit_Percent_Marital_Equity_to_Client3; } else {
                                                        echo "50.00";
                                                    } ?>%
                                                </div>
                                                <div class="client-info 3_Client_clientamount_div clientamount_div" style="clear: both;">
                                                    $<?php if(isset($drfundsondeposit->Client_Funds_on_Deposit_Estimated_Value_to_Client3)){ echo $drfundsondeposit->Client_Funds_on_Deposit_Estimated_Value_to_Client3; } ?>
                                                </div>
                                            </div>
                                            <label>To {{$client_name}}</label>
                                        </div>                                       
                                        <div class="col selectorTool selectorToolRight">
                                            <label>To {{$opponent_name}}</label>
                                            <div class="left-col right-col">
                                                <div class="client-info 3_Client_opponentpercentage_div opponentpercentage_div">
                                                    <?php if(isset($drfundsondeposit->Client_Funds_on_Deposit_Percent_Marital_Equity_to_Op3)){ echo $drfundsondeposit->Client_Funds_on_Deposit_Percent_Marital_Equity_to_Op3; } else {
                                                        echo "50.00";
                                                    } ?>%
                                                </div>
                                                <div class="client-info 3_Client_opponentamount_div opponentamount_div" style="clear: both;">
                                                    $<?php if(isset($drfundsondeposit->Client_Funds_on_Deposit_Estimated_Value_to_Op3)){ echo $drfundsondeposit->Client_Funds_on_Deposit_Estimated_Value_to_Op3; } ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 m-auto slider-tool-main">
                                    <label></label>
                                    <div class="w-100">
                                        <label><input type="radio" id="3_Client_Funds_on_Deposit_Estimated_Value_Select" name="3_Client_Funds_on_Deposit_Estimated_Value_Select_Reset" class="Funds_on_Deposit_Estimated_Value_Select_Reset" value="Save"> Save this Distribution of Deposit Account #3</label>
                                        <label><input type="radio" id="3_Client_Funds_on_Deposit_Estimated_Value_Reset" name="3_Client_Funds_on_Deposit_Estimated_Value_Select_Reset" class="Funds_on_Deposit_Estimated_Value_Select_Reset" value="Reset" onclick="resetBalanceInput(this, '3', 'Client');"> Reset to Default (50%)</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label>{{$client_name}} Deposite Equity Percent</label>
                                    <input id="Client_Funds_on_Deposit_Percent_Marital_Equity_to_Client3" type="number" class="form-control 3_Client_clientpercentage_input clientpercentage_input" name="Client_Funds_on_Deposit_Percent_Marital_Equity_to_Client3" value="<?php if(isset($drfundsondeposit->Client_Funds_on_Deposit_Percent_Marital_Equity_to_Client3)){ echo $drfundsondeposit->Client_Funds_on_Deposit_Percent_Marital_Equity_to_Client3; } ?>" min="0.00" step="0.01" max="100" readonly="">
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label>{{$client_name}} Deposite Equity Amount</label>
                                    <input id="Client_Funds_on_Deposit_Estimated_Value_to_Client3" type="number" class="form-control 3_Client_clientamount_input clientamount_input" name="Client_Funds_on_Deposit_Estimated_Value_to_Client3" value="<?php if(isset($drfundsondeposit->Client_Funds_on_Deposit_Estimated_Value_to_Client3)){ echo $drfundsondeposit->Client_Funds_on_Deposit_Estimated_Value_to_Client3; } ?>" min="0.00" step="0.01" max="999999.99" readonly="">
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label>{{$opponent_name}} Deposite Equity Percent</label>
                                    <input id="Client_Funds_on_Deposit_Percent_Marital_Equity_to_Op3" type="number" class="form-control 3_Client_opponentpercentage_input opponentpercentage_input" name="Client_Funds_on_Deposit_Percent_Marital_Equity_to_Op3" value="<?php if(isset($drfundsondeposit->Client_Funds_on_Deposit_Percent_Marital_Equity_to_Op3)){ echo $drfundsondeposit->Client_Funds_on_Deposit_Percent_Marital_Equity_to_Op3; } ?>" min="0.00" step="0.01" max="100" readonly="">
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label>{{$opponent_name}} Deposite Equity Amount</label>
                                    <input id="Client_Funds_on_Deposit_Estimated_Value_to_Op3" type="number" class="form-control 3_Client_opponentamount_input opponentamount_input" name="Client_Funds_on_Deposit_Estimated_Value_to_Op3" value="<?php if(isset($drfundsondeposit->Client_Funds_on_Deposit_Estimated_Value_to_Op3)){ echo $drfundsondeposit->Client_Funds_on_Deposit_Estimated_Value_to_Op3; } ?>" min="0.00" step="0.01" max="999999.99" readonly="">
                                </div>
                                <!-- end of slider tool -->
                            </div>
                            <div class="col-sm-12 mt-4 4_Client_fundsondeposit_section" style="display: none;"><h5 class="col-sm-12">Fourth Deposit Account Info</h5>
                                <div class="form-group col-sm-6">
                                    <p class="text-danger 4_Client_no-state-county-found" style="display: none;">No City, State, County found for this zipcode.</p>
                                    <label for="Client_Funds_on_Deposit_Institution_ZIP4">Deposit Institution Zip Code?</label>
                                    <input id="Client_Funds_on_Deposit_Institution_ZIP4" type="text" class="form-control 4_Client_fundsondeposit_inputs" name="Client_Funds_on_Deposit_Institution_ZIP4" value="<?php if(isset($drfundsondeposit->Client_Funds_on_Deposit_Institution_ZIP4)){ echo $drfundsondeposit->Client_Funds_on_Deposit_Institution_ZIP4; } ?>" data-onload="getCityStateForZip(this, '4', 'Client');" onkeyup="getCityStateForZip(this, '4', 'Client');"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Funds_on_Deposit_Institution_Name4">Name of Deposit Institution?</label>
                                    <input id="Client_Funds_on_Deposit_Institution_Name4" type="text" class="form-control 4_Client_fundsondeposit_inputs" name="Client_Funds_on_Deposit_Institution_Name4" value="<?php if(isset($drfundsondeposit->Client_Funds_on_Deposit_Institution_Name4)){ echo $drfundsondeposit->Client_Funds_on_Deposit_Institution_Name4; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Funds_on_Deposit_Institution_Street_Address4">Deposit Institution Street Address?</label>
                                    <input id="Client_Funds_on_Deposit_Institution_Street_Address4" type="text" class="form-control 4_Client_fundsondeposit_inputs" name="Client_Funds_on_Deposit_Institution_Street_Address4" value="<?php if(isset($drfundsondeposit->Client_Funds_on_Deposit_Institution_Street_Address4)){ echo $drfundsondeposit->Client_Funds_on_Deposit_Institution_Street_Address4; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Funds_on_Deposit_Institution_City4">Deposit Institution City?</label>
                                    <input type="hidden" name="" id="Client_Funds_on_Deposit_Institution_City4_Value" value="<?php if(isset($drfundsondeposit->Client_Funds_on_Deposit_Institution_City4)){ echo $drfundsondeposit->Client_Funds_on_Deposit_Institution_City4; } ?>">
                                    <select id="Client_Funds_on_Deposit_Institution_City4" name="Client_Funds_on_Deposit_Institution_City4" class="form-control 4_Client_city_select">
                                        <option value="">Choose City</option>
                                    </select>   
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Funds_on_Deposit_Institution_State4">Deposit Institution State?</label>
                                    <input type="hidden" name="" id="Client_Funds_on_Deposit_Institution_State4_Value" value="<?php if(isset($drfundsondeposit->Client_Funds_on_Deposit_Institution_City4)){ echo $drfundsondeposit->Client_Funds_on_Deposit_Institution_City4; } ?>">
                                    <select id="Client_Funds_on_Deposit_Institution_State4" name="Client_Funds_on_Deposit_Institution_State4" class="form-control 4_Client_state_select">
                                        <option value="">Choose State</option>
                                    </select>   
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Funds_on_Deposit_Institution_Acct_Num4">Account Number?</label>
                                    <input id="Client_Funds_on_Deposit_Institution_Acct_Num4" type="text" class="form-control 4_Client_fundsondeposit_inputs" name="Client_Funds_on_Deposit_Institution_Acct_Num4" value="<?php if(isset($drfundsondeposit->Client_Funds_on_Deposit_Institution_Acct_Num4)){ echo $drfundsondeposit->Client_Funds_on_Deposit_Institution_Acct_Num4; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Name on this account?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Client_Funds_on_Deposit_Institution_Name_on_Acct4_Client" name="Client_Funds_on_Deposit_Institution_Name_on_Acct4" value="{{$client_name}}" <?php if(isset($drfundsondeposit->Client_Funds_on_Deposit_Institution_Name_on_Acct4) && $drfundsondeposit->Client_Funds_on_Deposit_Institution_Name_on_Acct4==$client_name){ echo "checked"; } ?>> {{$client_name}}</label>
                                        <label><input type="radio" id="Client_Funds_on_Deposit_Institution_Name_on_Acct4_Op" name="Client_Funds_on_Deposit_Institution_Name_on_Acct4" value="{{$opponent_name}}" <?php if(isset($drfundsondeposit->Client_Funds_on_Deposit_Institution_Name_on_Acct4) && $drfundsondeposit->Client_Funds_on_Deposit_Institution_Name_on_Acct4==$opponent_name){ echo "checked"; } ?>> {{$opponent_name}}</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Funds_on_Deposit_Institution_Current_Balance4">Current Balance?</label>
                                    <input id="Client_Funds_on_Deposit_Institution_Current_Balance4" type="number" class="form-control 4_Client_fundsondeposit_inputs" name="Client_Funds_on_Deposit_Institution_Current_Balance4" value="<?php if(isset($drfundsondeposit->Client_Funds_on_Deposit_Institution_Current_Balance4)){ echo $drfundsondeposit->Client_Funds_on_Deposit_Institution_Current_Balance4; } ?>" min="0.00" step="0.01" max="999999.99" onchange="getClientOpCurrentBalance(this, '4', 'Client');" onkeyup="getClientOpCurrentBalance(this, '4', 'Client');"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Funds_on_Deposit_Institution_Yearly_Interest_Dividend4">Yearly Interest?</label>
                                    <input id="Client_Funds_on_Deposit_Institution_Yearly_Interest_Dividend4" type="number" class="form-control 4_Client_fundsondeposit_inputs" name="Client_Funds_on_Deposit_Institution_Yearly_Interest_Dividend4" value="<?php if(isset($drfundsondeposit->Client_Funds_on_Deposit_Institution_Yearly_Interest_Dividend4)){ echo $drfundsondeposit->Client_Funds_on_Deposit_Institution_Yearly_Interest_Dividend4; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Funds_on_Deposit_Institution_Balance_Date_of_Marriage4">Balance on marriage date (0.00, if started after marriage)?</label>
                                    <input id="Client_Funds_on_Deposit_Institution_Balance_Date_of_Marriage4" type="number" class="form-control 4_Client_fundsondeposit_inputs" name="Client_Funds_on_Deposit_Institution_Balance_Date_of_Marriage4" value="<?php if(isset($drfundsondeposit->Client_Funds_on_Deposit_Institution_Balance_Date_of_Marriage4)){ echo $drfundsondeposit->Client_Funds_on_Deposit_Institution_Balance_Date_of_Marriage4; } ?>" min="0.00" step="0.01" max="999999.99" onchange="getClientOpCurrentBalance(this, '4', 'Client');" onkeyup="getClientOpCurrentBalance(this, '4', 'Client');"> 
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label for="Client_Funds_on_Deposit_Estimated_MaritalEquity4">N/A, calculated = Client_Funds_on_Deposit_Institution_Current_Balance4 – Client_Funds_on_Deposit_Institution_Balance_Date_of_Marriage4</label>
                                    <input id="Client_Funds_on_Deposit_Estimated_MaritalEquity4" type="number" class="form-control 4_Client_fundsondeposit_inputs" name="Client_Funds_on_Deposit_Estimated_MaritalEquity4" value="<?php if(isset($drfundsondeposit->Client_Funds_on_Deposit_Estimated_MaritalEquity4)){ echo $drfundsondeposit->Client_Funds_on_Deposit_Estimated_MaritalEquity4; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Does either party claim a sole/separate interest from the other on this fund?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Client_Funds_on_Deposit_SoleSeparate_Claim4_Yes" name="Client_Funds_on_Deposit_SoleSeparate_Claim4" value="Yes" <?php if(isset($drfundsondeposit->Client_Funds_on_Deposit_SoleSeparate_Claim4) && $drfundsondeposit->Client_Funds_on_Deposit_SoleSeparate_Claim4=='Yes'){ echo "checked"; } ?>> Yes</label>
                                        <label><input type="radio" id="Client_Funds_on_Deposit_SoleSeparate_Claim4_No" name="Client_Funds_on_Deposit_SoleSeparate_Claim4" value="No" <?php if(isset($drfundsondeposit->Client_Funds_on_Deposit_SoleSeparate_Claim4) && $drfundsondeposit->Client_Funds_on_Deposit_SoleSeparate_Claim4=='No'){ echo "checked"; } ?>> No</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Who claims to own this fund?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Client_Funds_on_Deposit_SoleSeparate_Party4_Client" name="Client_Funds_on_Deposit_SoleSeparate_Party4" value="{{$client_name}}" <?php if(isset($drfundsondeposit->Client_Funds_on_Deposit_SoleSeparate_Party4) && $drfundsondeposit->Client_Funds_on_Deposit_SoleSeparate_Party4==$client_name){ echo "checked"; } ?>> {{$client_name}}</label>
                                        <label><input type="radio" id="Client_Funds_on_Deposit_SoleSeparate_Party4_Op" name="Client_Funds_on_Deposit_SoleSeparate_Party4" value="{{$opponent_name}}" <?php if(isset($drfundsondeposit->Client_Funds_on_Deposit_SoleSeparate_Party4) && $drfundsondeposit->Client_Funds_on_Deposit_SoleSeparate_Party4==$opponent_name){ echo "checked"; } ?>> {{$opponent_name}}</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 left-clear">
                                    <label for="Client_Funds_on_Deposit_SoleSeparate_Grounds4">Why does this person own this fund solely and separately?</label>
                                    <input id="Client_Funds_on_Deposit_SoleSeparate_Grounds4" type="text" class="form-control 4_Client_fundsondeposit_inputs" name="Client_Funds_on_Deposit_SoleSeparate_Grounds4" value="<?php if(isset($drfundsondeposit->Client_Funds_on_Deposit_SoleSeparate_Grounds4)){ echo $drfundsondeposit->Client_Funds_on_Deposit_SoleSeparate_Grounds4; } ?>"> 
                                </div>
                                <!-- slider tool -->
                                <div class="form-group col-sm-6 m-auto slider-tool-main">
                                    <div class="row">
                                        <div class="col">{{$client_name}}</div>
                                        <div class="col text-right">{{$opponent_name}}</div>
                                    </div>
                                    <input id="4_Client_balance_range_selector" type="range" class="form-control slider-tool-input 4_Client_balance_range_selector" name="" value="<?php if(isset($drfundsondeposit->Client_Funds_on_Deposit_Percent_Marital_Equity_to_Op4)){ echo $drfundsondeposit->Client_Funds_on_Deposit_Percent_Marital_Equity_to_Op4; } ?>" min="0.00" step="0.01" max="100" onchange="updateBalanceInput(this.value, '4', 'Client');">
                                </div>
                                <div class="form-group col-sm-6 m-auto slider-tool-main">
                                    <div class="row justify-content-between">
                                        <div class="col selectorTool">
                                            <div class="left-col">
                                                <div class="client-info 4_Client_clientpercentage_div clientpercentage_div">
                                                    <?php if(isset($drfundsondeposit->Client_Funds_on_Deposit_Percent_Marital_Equity_to_Client4)){ echo $drfundsondeposit->Client_Funds_on_Deposit_Percent_Marital_Equity_to_Client4; } else {
                                                        echo "50.00";
                                                    } ?>%
                                                </div>
                                                <div class="client-info 4_Client_clientamount_div clientamount_div" style="clear: both;">
                                                    $<?php if(isset($drfundsondeposit->Client_Funds_on_Deposit_Estimated_Value_to_Client4)){ echo $drfundsondeposit->Client_Funds_on_Deposit_Estimated_Value_to_Client4; } ?>
                                                </div>
                                            </div>
                                            <label>To {{$client_name}}</label>
                                        </div>                                       
                                        <div class="col selectorTool selectorToolRight">
                                            <label>To {{$opponent_name}}</label>
                                            <div class="left-col right-col">
                                                <div class="client-info 4_Client_opponentpercentage_div opponentpercentage_div">
                                                    <?php if(isset($drfundsondeposit->Client_Funds_on_Deposit_Percent_Marital_Equity_to_Op4)){ echo $drfundsondeposit->Client_Funds_on_Deposit_Percent_Marital_Equity_to_Op4; } else {
                                                        echo "50.00";
                                                    } ?>%
                                                </div>
                                                <div class="client-info 4_Client_opponentamount_div opponentamount_div" style="clear: both;">
                                                    $<?php if(isset($drfundsondeposit->Client_Funds_on_Deposit_Estimated_Value_to_Op4)){ echo $drfundsondeposit->Client_Funds_on_Deposit_Estimated_Value_to_Op4; } ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 m-auto slider-tool-main">
                                    <label></label>
                                    <div class="w-100">
                                        <label><input type="radio" id="4_Client_Funds_on_Deposit_Estimated_Value_Select" name="4_Client_Funds_on_Deposit_Estimated_Value_Select_Reset" class="Funds_on_Deposit_Estimated_Value_Select_Reset" value="Save"> Save this Distribution of Deposit Account #4</label>
                                        <label><input type="radio" id="4_Client_Funds_on_Deposit_Estimated_Value_Reset" name="4_Client_Funds_on_Deposit_Estimated_Value_Select_Reset" class="Funds_on_Deposit_Estimated_Value_Select_Reset" value="Reset" onclick="resetBalanceInput(this, '4', 'Client');"> Reset to Default (50%)</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label>{{$client_name}} Deposite Equity Percent</label>
                                    <input id="Client_Funds_on_Deposit_Percent_Marital_Equity_to_Client4" type="number" class="form-control 4_Client_clientpercentage_input clientpercentage_input" name="Client_Funds_on_Deposit_Percent_Marital_Equity_to_Client4" value="<?php if(isset($drfundsondeposit->Client_Funds_on_Deposit_Percent_Marital_Equity_to_Client4)){ echo $drfundsondeposit->Client_Funds_on_Deposit_Percent_Marital_Equity_to_Client4; } ?>" min="0.00" step="0.01" max="100" readonly="">
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label>{{$client_name}} Deposite Equity Amount</label>
                                    <input id="Client_Funds_on_Deposit_Estimated_Value_to_Client4" type="number" class="form-control 4_Client_clientamount_input clientamount_input" name="Client_Funds_on_Deposit_Estimated_Value_to_Client4" value="<?php if(isset($drfundsondeposit->Client_Funds_on_Deposit_Estimated_Value_to_Client4)){ echo $drfundsondeposit->Client_Funds_on_Deposit_Estimated_Value_to_Client4; } ?>" min="0.00" step="0.01" max="999999.99" readonly="">
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label>{{$opponent_name}} Deposite Equity Percent</label>
                                    <input id="Client_Funds_on_Deposit_Percent_Marital_Equity_to_Op4" type="number" class="form-control 4_Client_opponentpercentage_input opponentpercentage_input" name="Client_Funds_on_Deposit_Percent_Marital_Equity_to_Op4" value="<?php if(isset($drfundsondeposit->Client_Funds_on_Deposit_Percent_Marital_Equity_to_Op4)){ echo $drfundsondeposit->Client_Funds_on_Deposit_Percent_Marital_Equity_to_Op4; } ?>" min="0.00" step="0.01" max="100" readonly="">
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label>{{$opponent_name}} Deposite Equity Amount</label>
                                    <input id="Client_Funds_on_Deposit_Estimated_Value_to_Op4" type="number" class="form-control 4_Client_opponentamount_input opponentamount_input" name="Client_Funds_on_Deposit_Estimated_Value_to_Op4" value="<?php if(isset($drfundsondeposit->Client_Funds_on_Deposit_Estimated_Value_to_Op4)){ echo $drfundsondeposit->Client_Funds_on_Deposit_Estimated_Value_to_Op4; } ?>" min="0.00" step="0.01" max="999999.99" readonly="">
                                </div>
                                <!-- end of slider tool -->
                            </div>
                            <div class="col-sm-12 mt-4 5_Client_fundsondeposit_section" style="display: none;"><h5 class="col-sm-12">Fifth Deposit Account Info</h5>
                                <div class="form-group col-sm-6">
                                    <p class="text-danger 5_Client_no-state-county-found" style="display: none;">No City, State, County found for this zipcode.</p>
                                    <label for="Client_Funds_on_Deposit_Institution_ZIP5">Deposit Institution Zip Code?</label>
                                    <input id="Client_Funds_on_Deposit_Institution_ZIP5" type="text" class="form-control 5_Client_fundsondeposit_inputs" name="Client_Funds_on_Deposit_Institution_ZIP5" value="<?php if(isset($drfundsondeposit->Client_Funds_on_Deposit_Institution_ZIP5)){ echo $drfundsondeposit->Client_Funds_on_Deposit_Institution_ZIP5; } ?>" data-onload="getCityStateForZip(this, '5', 'Client');" onkeyup="getCityStateForZip(this, '5', 'Client');"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Funds_on_Deposit_Institution_Name5">Name of Deposit Institution?</label>
                                    <input id="Client_Funds_on_Deposit_Institution_Name5" type="text" class="form-control 5_Client_fundsondeposit_inputs" name="Client_Funds_on_Deposit_Institution_Name5" value="<?php if(isset($drfundsondeposit->Client_Funds_on_Deposit_Institution_Name5)){ echo $drfundsondeposit->Client_Funds_on_Deposit_Institution_Name5; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Funds_on_Deposit_Institution_Street_Address5">Deposit Institution Street Address?</label>
                                    <input id="Client_Funds_on_Deposit_Institution_Street_Address5" type="text" class="form-control 5_Client_fundsondeposit_inputs" name="Client_Funds_on_Deposit_Institution_Street_Address5" value="<?php if(isset($drfundsondeposit->Client_Funds_on_Deposit_Institution_Street_Address5)){ echo $drfundsondeposit->Client_Funds_on_Deposit_Institution_Street_Address5; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Funds_on_Deposit_Institution_City5">Deposit Institution City?</label>
                                    <input type="hidden" name="" id="Client_Funds_on_Deposit_Institution_City5_Value" value="<?php if(isset($drfundsondeposit->Client_Funds_on_Deposit_Institution_City5)){ echo $drfundsondeposit->Client_Funds_on_Deposit_Institution_City5; } ?>">
                                    <select id="Client_Funds_on_Deposit_Institution_City5" name="Client_Funds_on_Deposit_Institution_City5" class="form-control 5_Client_city_select">
                                        <option value="">Choose City</option>
                                    </select>   
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Funds_on_Deposit_Institution_State5">Deposit Institution State?</label>
                                    <input type="hidden" name="" id="Client_Funds_on_Deposit_Institution_State5_Value" value="<?php if(isset($drfundsondeposit->Client_Funds_on_Deposit_Institution_City5)){ echo $drfundsondeposit->Client_Funds_on_Deposit_Institution_City5; } ?>">
                                    <select id="Client_Funds_on_Deposit_Institution_State5" name="Client_Funds_on_Deposit_Institution_State5" class="form-control 5_Client_state_select">
                                        <option value="">Choose State</option>
                                    </select>   
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Funds_on_Deposit_Institution_Acct_Num5">Account Number?</label>
                                    <input id="Client_Funds_on_Deposit_Institution_Acct_Num5" type="text" class="form-control 5_Client_fundsondeposit_inputs" name="Client_Funds_on_Deposit_Institution_Acct_Num5" value="<?php if(isset($drfundsondeposit->Client_Funds_on_Deposit_Institution_Acct_Num5)){ echo $drfundsondeposit->Client_Funds_on_Deposit_Institution_Acct_Num5; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Name on this account?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Client_Funds_on_Deposit_Institution_Name_on_Acct5_Client" name="Client_Funds_on_Deposit_Institution_Name_on_Acct5" value="{{$client_name}}" <?php if(isset($drfundsondeposit->Client_Funds_on_Deposit_Institution_Name_on_Acct5) && $drfundsondeposit->Client_Funds_on_Deposit_Institution_Name_on_Acct5==$client_name){ echo "checked"; } ?>> {{$client_name}}</label>
                                        <label><input type="radio" id="Client_Funds_on_Deposit_Institution_Name_on_Acct5_Op" name="Client_Funds_on_Deposit_Institution_Name_on_Acct5" value="{{$opponent_name}}" <?php if(isset($drfundsondeposit->Client_Funds_on_Deposit_Institution_Name_on_Acct5) && $drfundsondeposit->Client_Funds_on_Deposit_Institution_Name_on_Acct5==$opponent_name){ echo "checked"; } ?>> {{$opponent_name}}</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Funds_on_Deposit_Institution_Current_Balance5">Current Balance?</label>
                                    <input id="Client_Funds_on_Deposit_Institution_Current_Balance5" type="number" class="form-control 5_Client_fundsondeposit_inputs" name="Client_Funds_on_Deposit_Institution_Current_Balance5" value="<?php if(isset($drfundsondeposit->Client_Funds_on_Deposit_Institution_Current_Balance5)){ echo $drfundsondeposit->Client_Funds_on_Deposit_Institution_Current_Balance5; } ?>" min="0.00" step="0.01" max="999999.99" onchange="getClientOpCurrentBalance(this, '5', 'Client');" onkeyup="getClientOpCurrentBalance(this, '5', 'Client');"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Funds_on_Deposit_Institution_Yearly_Interest_Dividend5">Yearly Interest?</label>
                                    <input id="Client_Funds_on_Deposit_Institution_Yearly_Interest_Dividend5" type="number" class="form-control 5_Client_fundsondeposit_inputs" name="Client_Funds_on_Deposit_Institution_Yearly_Interest_Dividend5" value="<?php if(isset($drfundsondeposit->Client_Funds_on_Deposit_Institution_Yearly_Interest_Dividend5)){ echo $drfundsondeposit->Client_Funds_on_Deposit_Institution_Yearly_Interest_Dividend5; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Funds_on_Deposit_Institution_Balance_Date_of_Marriage5">Balance on marriage date (0.00, if started after marriage)?</label>
                                    <input id="Client_Funds_on_Deposit_Institution_Balance_Date_of_Marriage5" type="number" class="form-control 5_Client_fundsondeposit_inputs" name="Client_Funds_on_Deposit_Institution_Balance_Date_of_Marriage5" value="<?php if(isset($drfundsondeposit->Client_Funds_on_Deposit_Institution_Balance_Date_of_Marriage5)){ echo $drfundsondeposit->Client_Funds_on_Deposit_Institution_Balance_Date_of_Marriage5; } ?>" min="0.00" step="0.01" max="999999.99" onchange="getClientOpCurrentBalance(this, '5', 'Client');" onkeyup="getClientOpCurrentBalance(this, '5', 'Client');"> 
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label for="Client_Funds_on_Deposit_Estimated_MaritalEquity5">N/A, calculated = Client_Funds_on_Deposit_Institution_Current_Balance5 – Client_Funds_on_Deposit_Institution_Balance_Date_of_Marriage5</label>
                                    <input id="Client_Funds_on_Deposit_Estimated_MaritalEquity5" type="number" class="form-control 5_Client_fundsondeposit_inputs" name="Client_Funds_on_Deposit_Estimated_MaritalEquity5" value="<?php if(isset($drfundsondeposit->Client_Funds_on_Deposit_Estimated_MaritalEquity5)){ echo $drfundsondeposit->Client_Funds_on_Deposit_Estimated_MaritalEquity5; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Does either party claim a sole/separate interest from the other on this fund?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Client_Funds_on_Deposit_SoleSeparate_Claim5_Yes" name="Client_Funds_on_Deposit_SoleSeparate_Claim5" value="Yes" <?php if(isset($drfundsondeposit->Client_Funds_on_Deposit_SoleSeparate_Claim5) && $drfundsondeposit->Client_Funds_on_Deposit_SoleSeparate_Claim5=='Yes'){ echo "checked"; } ?>> Yes</label>
                                        <label><input type="radio" id="Client_Funds_on_Deposit_SoleSeparate_Claim5_No" name="Client_Funds_on_Deposit_SoleSeparate_Claim5" value="No" <?php if(isset($drfundsondeposit->Client_Funds_on_Deposit_SoleSeparate_Claim5) && $drfundsondeposit->Client_Funds_on_Deposit_SoleSeparate_Claim5=='No'){ echo "checked"; } ?>> No</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Who claims to own this fund?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Client_Funds_on_Deposit_SoleSeparate_Party5_Client" name="Client_Funds_on_Deposit_SoleSeparate_Party5" value="{{$client_name}}" <?php if(isset($drfundsondeposit->Client_Funds_on_Deposit_SoleSeparate_Party5) && $drfundsondeposit->Client_Funds_on_Deposit_SoleSeparate_Party5==$client_name){ echo "checked"; } ?>> {{$client_name}}</label>
                                        <label><input type="radio" id="Client_Funds_on_Deposit_SoleSeparate_Party5_Op" name="Client_Funds_on_Deposit_SoleSeparate_Party5" value="{{$opponent_name}}" <?php if(isset($drfundsondeposit->Client_Funds_on_Deposit_SoleSeparate_Party5) && $drfundsondeposit->Client_Funds_on_Deposit_SoleSeparate_Party5==$opponent_name){ echo "checked"; } ?>> {{$opponent_name}}</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 left-clear">
                                    <label for="Client_Funds_on_Deposit_SoleSeparate_Grounds5">Why does this person own this fund solely and separately?</label>
                                    <input id="Client_Funds_on_Deposit_SoleSeparate_Grounds5" type="text" class="form-control 5_Client_fundsondeposit_inputs" name="Client_Funds_on_Deposit_SoleSeparate_Grounds5" value="<?php if(isset($drfundsondeposit->Client_Funds_on_Deposit_SoleSeparate_Grounds5)){ echo $drfundsondeposit->Client_Funds_on_Deposit_SoleSeparate_Grounds5; } ?>"> 
                                </div>
                                <!-- slider tool -->
                                <div class="form-group col-sm-6 m-auto slider-tool-main">
                                    <div class="row">
                                        <div class="col">{{$client_name}}</div>
                                        <div class="col text-right">{{$opponent_name}}</div>
                                    </div>
                                    <input id="5_Client_balance_range_selector" type="range" class="form-control slider-tool-input 5_Client_balance_range_selector" name="" value="<?php if(isset($drfundsondeposit->Client_Funds_on_Deposit_Percent_Marital_Equity_to_Op5)){ echo $drfundsondeposit->Client_Funds_on_Deposit_Percent_Marital_Equity_to_Op5; } ?>" min="0.00" step="0.01" max="100" onchange="updateBalanceInput(this.value, '5', 'Client');">
                                </div>
                                <div class="form-group col-sm-6 m-auto slider-tool-main">
                                    <div class="row justify-content-between">
                                        <div class="col selectorTool">
                                            <div class="left-col">
                                                <div class="client-info 5_Client_clientpercentage_div clientpercentage_div">
                                                    <?php if(isset($drfundsondeposit->Client_Funds_on_Deposit_Percent_Marital_Equity_to_Client5)){ echo $drfundsondeposit->Client_Funds_on_Deposit_Percent_Marital_Equity_to_Client5; } else {
                                                        echo "50.00";
                                                    } ?>%
                                                </div>
                                                <div class="client-info 5_Client_clientamount_div clientamount_div" style="clear: both;">
                                                    $<?php if(isset($drfundsondeposit->Client_Funds_on_Deposit_Estimated_Value_to_Client5)){ echo $drfundsondeposit->Client_Funds_on_Deposit_Estimated_Value_to_Client5; } ?>
                                                </div>
                                            </div>
                                            <label>To {{$client_name}}</label>
                                        </div>                                       
                                        <div class="col selectorTool selectorToolRight">
                                            <label>To {{$opponent_name}}</label>
                                            <div class="left-col right-col">
                                                <div class="client-info 5_Client_opponentpercentage_div opponentpercentage_div">
                                                    <?php if(isset($drfundsondeposit->Client_Funds_on_Deposit_Percent_Marital_Equity_to_Op5)){ echo $drfundsondeposit->Client_Funds_on_Deposit_Percent_Marital_Equity_to_Op5; } else {
                                                        echo "50.00";
                                                    } ?>%
                                                </div>
                                                <div class="client-info 5_Client_opponentamount_div opponentamount_div" style="clear: both;">
                                                    $<?php if(isset($drfundsondeposit->Client_Funds_on_Deposit_Estimated_Value_to_Op5)){ echo $drfundsondeposit->Client_Funds_on_Deposit_Estimated_Value_to_Op5; } ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 m-auto slider-tool-main">
                                    <label></label>
                                    <div class="w-100">
                                        <label><input type="radio" id="5_Client_Funds_on_Deposit_Estimated_Value_Select" name="5_Client_Funds_on_Deposit_Estimated_Value_Select_Reset" class="Funds_on_Deposit_Estimated_Value_Select_Reset" value="Save"> Save this Distribution of Deposit Account #5</label>
                                        <label><input type="radio" id="5_Client_Funds_on_Deposit_Estimated_Value_Reset" name="5_Client_Funds_on_Deposit_Estimated_Value_Select_Reset" class="Funds_on_Deposit_Estimated_Value_Select_Reset" value="Reset" onclick="resetBalanceInput(this, '5', 'Client');"> Reset to Default (50%)</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label>{{$client_name}} Deposite Equity Percent</label>
                                    <input id="Client_Funds_on_Deposit_Percent_Marital_Equity_to_Client5" type="number" class="form-control 5_Client_clientpercentage_input clientpercentage_input" name="Client_Funds_on_Deposit_Percent_Marital_Equity_to_Client5" value="<?php if(isset($drfundsondeposit->Client_Funds_on_Deposit_Percent_Marital_Equity_to_Client5)){ echo $drfundsondeposit->Client_Funds_on_Deposit_Percent_Marital_Equity_to_Client5; } ?>" min="0.00" step="0.01" max="100" readonly="">
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label>{{$client_name}} Deposite Equity Amount</label>
                                    <input id="Client_Funds_on_Deposit_Estimated_Value_to_Client5" type="number" class="form-control 5_Client_clientamount_input clientamount_input" name="Client_Funds_on_Deposit_Estimated_Value_to_Client5" value="<?php if(isset($drfundsondeposit->Client_Funds_on_Deposit_Estimated_Value_to_Client5)){ echo $drfundsondeposit->Client_Funds_on_Deposit_Estimated_Value_to_Client5; } ?>" min="0.00" step="0.01" max="999999.99" readonly="">
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label>{{$opponent_name}} Deposite Equity Percent</label>
                                    <input id="Client_Funds_on_Deposit_Percent_Marital_Equity_to_Op5" type="number" class="form-control 5_Client_opponentpercentage_input opponentpercentage_input" name="Client_Funds_on_Deposit_Percent_Marital_Equity_to_Op5" value="<?php if(isset($drfundsondeposit->Client_Funds_on_Deposit_Percent_Marital_Equity_to_Op5)){ echo $drfundsondeposit->Client_Funds_on_Deposit_Percent_Marital_Equity_to_Op5; } ?>" min="0.00" step="0.01" max="100" readonly="">
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label>{{$opponent_name}} Deposite Equity Amount</label>
                                    <input id="Client_Funds_on_Deposit_Estimated_Value_to_Op5" type="number" class="form-control 5_Client_opponentamount_input opponentamount_input" name="Client_Funds_on_Deposit_Estimated_Value_to_Op5" value="<?php if(isset($drfundsondeposit->Client_Funds_on_Deposit_Estimated_Value_to_Op5)){ echo $drfundsondeposit->Client_Funds_on_Deposit_Estimated_Value_to_Op5; } ?>" min="0.00" step="0.01" max="999999.99" readonly="">
                                </div>
                                <!-- end of slider tool -->
                            </div>
                            <div class="col-sm-12 mt-4 6_Client_fundsondeposit_section" style="display: none;"><h5 class="col-sm-12">Sixth Deposit Account Info</h5>
                                <div class="form-group col-sm-6">
                                    <p class="text-danger 6_Client_no-state-county-found" style="display: none;">No City, State, County found for this zipcode.</p>
                                    <label for="Client_Funds_on_Deposit_Institution_ZIP6">Deposit Institution Zip Code?</label>
                                    <input id="Client_Funds_on_Deposit_Institution_ZIP6" type="text" class="form-control 6_Client_fundsondeposit_inputs" name="Client_Funds_on_Deposit_Institution_ZIP6" value="<?php if(isset($drfundsondeposit->Client_Funds_on_Deposit_Institution_ZIP6)){ echo $drfundsondeposit->Client_Funds_on_Deposit_Institution_ZIP6; } ?>" data-onload="getCityStateForZip(this, '6', 'Client');" onkeyup="getCityStateForZip(this, '6', 'Client');"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Funds_on_Deposit_Institution_Name6">Name of Deposit Institution?</label>
                                    <input id="Client_Funds_on_Deposit_Institution_Name6" type="text" class="form-control 6_Client_fundsondeposit_inputs" name="Client_Funds_on_Deposit_Institution_Name6" value="<?php if(isset($drfundsondeposit->Client_Funds_on_Deposit_Institution_Name6)){ echo $drfundsondeposit->Client_Funds_on_Deposit_Institution_Name6; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Funds_on_Deposit_Institution_Street_Address6">Deposit Institution Street Address?</label>
                                    <input id="Client_Funds_on_Deposit_Institution_Street_Address6" type="text" class="form-control 6_Client_fundsondeposit_inputs" name="Client_Funds_on_Deposit_Institution_Street_Address6" value="<?php if(isset($drfundsondeposit->Client_Funds_on_Deposit_Institution_Street_Address6)){ echo $drfundsondeposit->Client_Funds_on_Deposit_Institution_Street_Address6; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Funds_on_Deposit_Institution_City6">Deposit Institution City?</label>
                                    <input type="hidden" name="" id="Client_Funds_on_Deposit_Institution_City6_Value" value="<?php if(isset($drfundsondeposit->Client_Funds_on_Deposit_Institution_City6)){ echo $drfundsondeposit->Client_Funds_on_Deposit_Institution_City6; } ?>">
                                    <select id="Client_Funds_on_Deposit_Institution_City6" name="Client_Funds_on_Deposit_Institution_City6" class="form-control 6_Client_city_select">
                                        <option value="">Choose City</option>
                                    </select>   
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Funds_on_Deposit_Institution_State6">Deposit Institution State?</label>
                                    <input type="hidden" name="" id="Client_Funds_on_Deposit_Institution_State6_Value" value="<?php if(isset($drfundsondeposit->Client_Funds_on_Deposit_Institution_City6)){ echo $drfundsondeposit->Client_Funds_on_Deposit_Institution_City6; } ?>">
                                    <select id="Client_Funds_on_Deposit_Institution_State6" name="Client_Funds_on_Deposit_Institution_State6" class="form-control 6_Client_state_select">
                                        <option value="">Choose State</option>
                                    </select>   
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Funds_on_Deposit_Institution_Acct_Num6">Account Number?</label>
                                    <input id="Client_Funds_on_Deposit_Institution_Acct_Num6" type="text" class="form-control 6_Client_fundsondeposit_inputs" name="Client_Funds_on_Deposit_Institution_Acct_Num6" value="<?php if(isset($drfundsondeposit->Client_Funds_on_Deposit_Institution_Acct_Num6)){ echo $drfundsondeposit->Client_Funds_on_Deposit_Institution_Acct_Num6; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Name on this account?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Client_Funds_on_Deposit_Institution_Name_on_Acct6_Client" name="Client_Funds_on_Deposit_Institution_Name_on_Acct6" value="{{$client_name}}" <?php if(isset($drfundsondeposit->Client_Funds_on_Deposit_Institution_Name_on_Acct6) && $drfundsondeposit->Client_Funds_on_Deposit_Institution_Name_on_Acct6==$client_name){ echo "checked"; } ?>> {{$client_name}}</label>
                                        <label><input type="radio" id="Client_Funds_on_Deposit_Institution_Name_on_Acct6_Op" name="Client_Funds_on_Deposit_Institution_Name_on_Acct6" value="{{$opponent_name}}" <?php if(isset($drfundsondeposit->Client_Funds_on_Deposit_Institution_Name_on_Acct6) && $drfundsondeposit->Client_Funds_on_Deposit_Institution_Name_on_Acct6==$opponent_name){ echo "checked"; } ?>> {{$opponent_name}}</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Funds_on_Deposit_Institution_Current_Balance6">Current Balance?</label>
                                    <input id="Client_Funds_on_Deposit_Institution_Current_Balance6" type="number" class="form-control 6_Client_fundsondeposit_inputs" name="Client_Funds_on_Deposit_Institution_Current_Balance6" value="<?php if(isset($drfundsondeposit->Client_Funds_on_Deposit_Institution_Current_Balance6)){ echo $drfundsondeposit->Client_Funds_on_Deposit_Institution_Current_Balance6; } ?>" min="0.00" step="0.01" max="999999.99" onchange="getClientOpCurrentBalance(this, '6', 'Client');" onkeyup="getClientOpCurrentBalance(this, '6', 'Client');"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Funds_on_Deposit_Institution_Yearly_Interest_Dividend6">Yearly Interest?</label>
                                    <input id="Client_Funds_on_Deposit_Institution_Yearly_Interest_Dividend6" type="number" class="form-control 6_Client_fundsondeposit_inputs" name="Client_Funds_on_Deposit_Institution_Yearly_Interest_Dividend6" value="<?php if(isset($drfundsondeposit->Client_Funds_on_Deposit_Institution_Yearly_Interest_Dividend6)){ echo $drfundsondeposit->Client_Funds_on_Deposit_Institution_Yearly_Interest_Dividend6; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Funds_on_Deposit_Institution_Balance_Date_of_Marriage6">Balance on marriage date (0.00, if started after marriage)?</label>
                                    <input id="Client_Funds_on_Deposit_Institution_Balance_Date_of_Marriage6" type="number" class="form-control 6_Client_fundsondeposit_inputs" name="Client_Funds_on_Deposit_Institution_Balance_Date_of_Marriage6" value="<?php if(isset($drfundsondeposit->Client_Funds_on_Deposit_Institution_Balance_Date_of_Marriage6)){ echo $drfundsondeposit->Client_Funds_on_Deposit_Institution_Balance_Date_of_Marriage6; } ?>" min="0.00" step="0.01" max="999999.99" onchange="getClientOpCurrentBalance(this, '6', 'Client');" onkeyup="getClientOpCurrentBalance(this, '6', 'Client');"> 
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label for="Client_Funds_on_Deposit_Estimated_MaritalEquity6">N/A, calculated = Client_Funds_on_Deposit_Institution_Current_Balance6 – Client_Funds_on_Deposit_Institution_Balance_Date_of_Marriage6</label>
                                    <input id="Client_Funds_on_Deposit_Estimated_MaritalEquity6" type="number" class="form-control 6_Client_fundsondeposit_inputs" name="Client_Funds_on_Deposit_Estimated_MaritalEquity6" value="<?php if(isset($drfundsondeposit->Client_Funds_on_Deposit_Estimated_MaritalEquity6)){ echo $drfundsondeposit->Client_Funds_on_Deposit_Estimated_MaritalEquity6; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Does either party claim a sole/separate interest from the other on this fund?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Client_Funds_on_Deposit_SoleSeparate_Claim6_Yes" name="Client_Funds_on_Deposit_SoleSeparate_Claim6" value="Yes" <?php if(isset($drfundsondeposit->Client_Funds_on_Deposit_SoleSeparate_Claim6) && $drfundsondeposit->Client_Funds_on_Deposit_SoleSeparate_Claim6=='Yes'){ echo "checked"; } ?>> Yes</label>
                                        <label><input type="radio" id="Client_Funds_on_Deposit_SoleSeparate_Claim6_No" name="Client_Funds_on_Deposit_SoleSeparate_Claim6" value="No" <?php if(isset($drfundsondeposit->Client_Funds_on_Deposit_SoleSeparate_Claim6) && $drfundsondeposit->Client_Funds_on_Deposit_SoleSeparate_Claim6=='No'){ echo "checked"; } ?>> No</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Who claims to own this fund?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Client_Funds_on_Deposit_SoleSeparate_Party6_Client" name="Client_Funds_on_Deposit_SoleSeparate_Party6" value="{{$client_name}}" <?php if(isset($drfundsondeposit->Client_Funds_on_Deposit_SoleSeparate_Party6) && $drfundsondeposit->Client_Funds_on_Deposit_SoleSeparate_Party6==$client_name){ echo "checked"; } ?>> {{$client_name}}</label>
                                        <label><input type="radio" id="Client_Funds_on_Deposit_SoleSeparate_Party6_Op" name="Client_Funds_on_Deposit_SoleSeparate_Party6" value="{{$opponent_name}}" <?php if(isset($drfundsondeposit->Client_Funds_on_Deposit_SoleSeparate_Party6) && $drfundsondeposit->Client_Funds_on_Deposit_SoleSeparate_Party6==$opponent_name){ echo "checked"; } ?>> {{$opponent_name}}</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 left-clear">
                                    <label for="Client_Funds_on_Deposit_SoleSeparate_Grounds6">Why does this person own this fund solely and separately?</label>
                                    <input id="Client_Funds_on_Deposit_SoleSeparate_Grounds6" type="text" class="form-control 6_Client_fundsondeposit_inputs" name="Client_Funds_on_Deposit_SoleSeparate_Grounds6" value="<?php if(isset($drfundsondeposit->Client_Funds_on_Deposit_SoleSeparate_Grounds6)){ echo $drfundsondeposit->Client_Funds_on_Deposit_SoleSeparate_Grounds6; } ?>"> 
                                </div>
                                <!-- slider tool -->
                                <div class="form-group col-sm-6 m-auto slider-tool-main">
                                    <div class="row">
                                        <div class="col">{{$client_name}}</div>
                                        <div class="col text-right">{{$opponent_name}}</div>
                                    </div>
                                    <input id="6_Client_balance_range_selector" type="range" class="form-control slider-tool-input 6_Client_balance_range_selector" name="" value="<?php if(isset($drfundsondeposit->Client_Funds_on_Deposit_Percent_Marital_Equity_to_Op6)){ echo $drfundsondeposit->Client_Funds_on_Deposit_Percent_Marital_Equity_to_Op6; } ?>" min="0.00" step="0.01" max="100" onchange="updateBalanceInput(this.value, '6', 'Client');">
                                </div>
                                <div class="form-group col-sm-6 m-auto slider-tool-main">
                                    <div class="row justify-content-between">
                                        <div class="col selectorTool">
                                            <div class="left-col">
                                                <div class="client-info 6_Client_clientpercentage_div clientpercentage_div">
                                                    <?php if(isset($drfundsondeposit->Client_Funds_on_Deposit_Percent_Marital_Equity_to_Client6)){ echo $drfundsondeposit->Client_Funds_on_Deposit_Percent_Marital_Equity_to_Client6; } else {
                                                        echo "50.00";
                                                    } ?>%
                                                </div>
                                                <div class="client-info 6_Client_clientamount_div clientamount_div" style="clear: both;">
                                                    $<?php if(isset($drfundsondeposit->Client_Funds_on_Deposit_Estimated_Value_to_Client6)){ echo $drfundsondeposit->Client_Funds_on_Deposit_Estimated_Value_to_Client6; } ?>
                                                </div>
                                            </div>
                                            <label>To {{$client_name}}</label>
                                        </div>                                       
                                        <div class="col selectorTool selectorToolRight">
                                            <label>To {{$opponent_name}}</label>
                                            <div class="left-col right-col">
                                                <div class="client-info 6_Client_opponentpercentage_div opponentpercentage_div">
                                                    <?php if(isset($drfundsondeposit->Client_Funds_on_Deposit_Percent_Marital_Equity_to_Op6)){ echo $drfundsondeposit->Client_Funds_on_Deposit_Percent_Marital_Equity_to_Op6; } else {
                                                        echo "50.00";
                                                    } ?>%
                                                </div>
                                                <div class="client-info 6_Client_opponentamount_div opponentamount_div" style="clear: both;">
                                                    $<?php if(isset($drfundsondeposit->Client_Funds_on_Deposit_Estimated_Value_to_Op6)){ echo $drfundsondeposit->Client_Funds_on_Deposit_Estimated_Value_to_Op6; } ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 m-auto slider-tool-main">
                                    <label></label>
                                    <div class="w-100">
                                        <label><input type="radio" id="6_Client_Funds_on_Deposit_Estimated_Value_Select" name="6_Client_Funds_on_Deposit_Estimated_Value_Select_Reset" class="Funds_on_Deposit_Estimated_Value_Select_Reset" value="Save"> Save this Distribution of Deposit Account #6</label>
                                        <label><input type="radio" id="6_Client_Funds_on_Deposit_Estimated_Value_Reset" name="6_Client_Funds_on_Deposit_Estimated_Value_Select_Reset" class="Funds_on_Deposit_Estimated_Value_Select_Reset" value="Reset" onclick="resetBalanceInput(this, '6', 'Client');"> Reset to Default (50%)</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label>{{$client_name}} Deposite Equity Percent</label>
                                    <input id="Client_Funds_on_Deposit_Percent_Marital_Equity_to_Client6" type="number" class="form-control 6_Client_clientpercentage_input clientpercentage_input" name="Client_Funds_on_Deposit_Percent_Marital_Equity_to_Client6" value="<?php if(isset($drfundsondeposit->Client_Funds_on_Deposit_Percent_Marital_Equity_to_Client6)){ echo $drfundsondeposit->Client_Funds_on_Deposit_Percent_Marital_Equity_to_Client6; } ?>" min="0.00" step="0.01" max="100" readonly="">
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label>{{$client_name}} Deposite Equity Amount</label>
                                    <input id="Client_Funds_on_Deposit_Estimated_Value_to_Client6" type="number" class="form-control 6_Client_clientamount_input clientamount_input" name="Client_Funds_on_Deposit_Estimated_Value_to_Client6" value="<?php if(isset($drfundsondeposit->Client_Funds_on_Deposit_Estimated_Value_to_Client6)){ echo $drfundsondeposit->Client_Funds_on_Deposit_Estimated_Value_to_Client6; } ?>" min="0.00" step="0.01" max="999999.99" readonly="">
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label>{{$opponent_name}} Deposite Equity Percent</label>
                                    <input id="Client_Funds_on_Deposit_Percent_Marital_Equity_to_Op6" type="number" class="form-control 6_Client_opponentpercentage_input opponentpercentage_input" name="Client_Funds_on_Deposit_Percent_Marital_Equity_to_Op6" value="<?php if(isset($drfundsondeposit->Client_Funds_on_Deposit_Percent_Marital_Equity_to_Op6)){ echo $drfundsondeposit->Client_Funds_on_Deposit_Percent_Marital_Equity_to_Op6; } ?>" min="0.00" step="0.01" max="100" readonly="">
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label>{{$opponent_name}} Deposite Equity Amount</label>
                                    <input id="Client_Funds_on_Deposit_Estimated_Value_to_Op6" type="number" class="form-control 6_Client_opponentamount_input opponentamount_input" name="Client_Funds_on_Deposit_Estimated_Value_to_Op6" value="<?php if(isset($drfundsondeposit->Client_Funds_on_Deposit_Estimated_Value_to_Op6)){ echo $drfundsondeposit->Client_Funds_on_Deposit_Estimated_Value_to_Op6; } ?>" min="0.00" step="0.01" max="999999.99" readonly="">
                                </div>
                                <!-- end of slider tool -->
                            </div>
                            <div class="col-sm-12 mt-4 7_Client_fundsondeposit_section" style="display: none;"><h5 class="col-sm-12">Seventh Deposit Account Info</h5>
                                <div class="form-group col-sm-6">
                                    <p class="text-danger 7_Client_no-state-county-found" style="display: none;">No City, State, County found for this zipcode.</p>
                                    <label for="Client_Funds_on_Deposit_Institution_ZIP7">Deposit Institution Zip Code?</label>
                                    <input id="Client_Funds_on_Deposit_Institution_ZIP7" type="text" class="form-control 7_Client_fundsondeposit_inputs" name="Client_Funds_on_Deposit_Institution_ZIP7" value="<?php if(isset($drfundsondeposit->Client_Funds_on_Deposit_Institution_ZIP7)){ echo $drfundsondeposit->Client_Funds_on_Deposit_Institution_ZIP7; } ?>" data-onload="getCityStateForZip(this, '7', 'Client');" onkeyup="getCityStateForZip(this, '7', 'Client');"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Funds_on_Deposit_Institution_Name7">Name of Deposit Institution?</label>
                                    <input id="Client_Funds_on_Deposit_Institution_Name7" type="text" class="form-control 7_Client_fundsondeposit_inputs" name="Client_Funds_on_Deposit_Institution_Name7" value="<?php if(isset($drfundsondeposit->Client_Funds_on_Deposit_Institution_Name7)){ echo $drfundsondeposit->Client_Funds_on_Deposit_Institution_Name7; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Funds_on_Deposit_Institution_Street_Address7">Deposit Institution Street Address?</label>
                                    <input id="Client_Funds_on_Deposit_Institution_Street_Address7" type="text" class="form-control 7_Client_fundsondeposit_inputs" name="Client_Funds_on_Deposit_Institution_Street_Address7" value="<?php if(isset($drfundsondeposit->Client_Funds_on_Deposit_Institution_Street_Address7)){ echo $drfundsondeposit->Client_Funds_on_Deposit_Institution_Street_Address7; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Funds_on_Deposit_Institution_City7">Deposit Institution City?</label>
                                    <input type="hidden" name="" id="Client_Funds_on_Deposit_Institution_City7_Value" value="<?php if(isset($drfundsondeposit->Client_Funds_on_Deposit_Institution_City7)){ echo $drfundsondeposit->Client_Funds_on_Deposit_Institution_City7; } ?>">
                                    <select id="Client_Funds_on_Deposit_Institution_City7" name="Client_Funds_on_Deposit_Institution_City7" class="form-control 7_Client_city_select">
                                        <option value="">Choose City</option>
                                    </select>   
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Funds_on_Deposit_Institution_State7">Deposit Institution State?</label>
                                    <input type="hidden" name="" id="Client_Funds_on_Deposit_Institution_State7_Value" value="<?php if(isset($drfundsondeposit->Client_Funds_on_Deposit_Institution_City7)){ echo $drfundsondeposit->Client_Funds_on_Deposit_Institution_City7; } ?>">
                                    <select id="Client_Funds_on_Deposit_Institution_State7" name="Client_Funds_on_Deposit_Institution_State7" class="form-control 7_Client_state_select">
                                        <option value="">Choose State</option>
                                    </select>   
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Funds_on_Deposit_Institution_Acct_Num7">Account Number?</label>
                                    <input id="Client_Funds_on_Deposit_Institution_Acct_Num7" type="text" class="form-control 7_Client_fundsondeposit_inputs" name="Client_Funds_on_Deposit_Institution_Acct_Num7" value="<?php if(isset($drfundsondeposit->Client_Funds_on_Deposit_Institution_Acct_Num7)){ echo $drfundsondeposit->Client_Funds_on_Deposit_Institution_Acct_Num7; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Name on this account?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Client_Funds_on_Deposit_Institution_Name_on_Acct7_Client" name="Client_Funds_on_Deposit_Institution_Name_on_Acct7" value="{{$client_name}}" <?php if(isset($drfundsondeposit->Client_Funds_on_Deposit_Institution_Name_on_Acct7) && $drfundsondeposit->Client_Funds_on_Deposit_Institution_Name_on_Acct7==$client_name){ echo "checked"; } ?>> {{$client_name}}</label>
                                        <label><input type="radio" id="Client_Funds_on_Deposit_Institution_Name_on_Acct7_Op" name="Client_Funds_on_Deposit_Institution_Name_on_Acct7" value="{{$opponent_name}}" <?php if(isset($drfundsondeposit->Client_Funds_on_Deposit_Institution_Name_on_Acct7) && $drfundsondeposit->Client_Funds_on_Deposit_Institution_Name_on_Acct7==$opponent_name){ echo "checked"; } ?>> {{$opponent_name}}</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Funds_on_Deposit_Institution_Current_Balance7">Current Balance?</label>
                                    <input id="Client_Funds_on_Deposit_Institution_Current_Balance7" type="number" class="form-control 7_Client_fundsondeposit_inputs" name="Client_Funds_on_Deposit_Institution_Current_Balance7" value="<?php if(isset($drfundsondeposit->Client_Funds_on_Deposit_Institution_Current_Balance7)){ echo $drfundsondeposit->Client_Funds_on_Deposit_Institution_Current_Balance7; } ?>" min="0.00" step="0.01" max="999999.99" onchange="getClientOpCurrentBalance(this, '7', 'Client');" onkeyup="getClientOpCurrentBalance(this, '7', 'Client');"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Funds_on_Deposit_Institution_Yearly_Interest_Dividend7">Yearly Interest?</label>
                                    <input id="Client_Funds_on_Deposit_Institution_Yearly_Interest_Dividend7" type="number" class="form-control 7_Client_fundsondeposit_inputs" name="Client_Funds_on_Deposit_Institution_Yearly_Interest_Dividend7" value="<?php if(isset($drfundsondeposit->Client_Funds_on_Deposit_Institution_Yearly_Interest_Dividend7)){ echo $drfundsondeposit->Client_Funds_on_Deposit_Institution_Yearly_Interest_Dividend7; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Funds_on_Deposit_Institution_Balance_Date_of_Marriage7">Balance on marriage date (0.00, if started after marriage)?</label>
                                    <input id="Client_Funds_on_Deposit_Institution_Balance_Date_of_Marriage7" type="number" class="form-control 7_Client_fundsondeposit_inputs" name="Client_Funds_on_Deposit_Institution_Balance_Date_of_Marriage7" value="<?php if(isset($drfundsondeposit->Client_Funds_on_Deposit_Institution_Balance_Date_of_Marriage7)){ echo $drfundsondeposit->Client_Funds_on_Deposit_Institution_Balance_Date_of_Marriage7; } ?>" min="0.00" step="0.01" max="999999.99" onchange="getClientOpCurrentBalance(this, '7', 'Client');" onkeyup="getClientOpCurrentBalance(this, '7', 'Client');"> 
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label for="Client_Funds_on_Deposit_Estimated_MaritalEquity7">N/A, calculated = Client_Funds_on_Deposit_Institution_Current_Balance7 – Client_Funds_on_Deposit_Institution_Balance_Date_of_Marriage7</label>
                                    <input id="Client_Funds_on_Deposit_Estimated_MaritalEquity7" type="number" class="form-control 7_Client_fundsondeposit_inputs" name="Client_Funds_on_Deposit_Estimated_MaritalEquity7" value="<?php if(isset($drfundsondeposit->Client_Funds_on_Deposit_Estimated_MaritalEquity7)){ echo $drfundsondeposit->Client_Funds_on_Deposit_Estimated_MaritalEquity7; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Does either party claim a sole/separate interest from the other on this fund?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Client_Funds_on_Deposit_SoleSeparate_Claim7_Yes" name="Client_Funds_on_Deposit_SoleSeparate_Claim7" value="Yes" <?php if(isset($drfundsondeposit->Client_Funds_on_Deposit_SoleSeparate_Claim7) && $drfundsondeposit->Client_Funds_on_Deposit_SoleSeparate_Claim7=='Yes'){ echo "checked"; } ?>> Yes</label>
                                        <label><input type="radio" id="Client_Funds_on_Deposit_SoleSeparate_Claim7_No" name="Client_Funds_on_Deposit_SoleSeparate_Claim7" value="No" <?php if(isset($drfundsondeposit->Client_Funds_on_Deposit_SoleSeparate_Claim7) && $drfundsondeposit->Client_Funds_on_Deposit_SoleSeparate_Claim7=='No'){ echo "checked"; } ?>> No</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Who claims to own this fund?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Client_Funds_on_Deposit_SoleSeparate_Party7_Client" name="Client_Funds_on_Deposit_SoleSeparate_Party7" value="{{$client_name}}" <?php if(isset($drfundsondeposit->Client_Funds_on_Deposit_SoleSeparate_Party7) && $drfundsondeposit->Client_Funds_on_Deposit_SoleSeparate_Party7==$client_name){ echo "checked"; } ?>> {{$client_name}}</label>
                                        <label><input type="radio" id="Client_Funds_on_Deposit_SoleSeparate_Party7_Op" name="Client_Funds_on_Deposit_SoleSeparate_Party7" value="{{$opponent_name}}" <?php if(isset($drfundsondeposit->Client_Funds_on_Deposit_SoleSeparate_Party7) && $drfundsondeposit->Client_Funds_on_Deposit_SoleSeparate_Party7==$opponent_name){ echo "checked"; } ?>> {{$opponent_name}}</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 left-clear">
                                    <label for="Client_Funds_on_Deposit_SoleSeparate_Grounds7">Why does this person own this fund solely and separately?</label>
                                    <input id="Client_Funds_on_Deposit_SoleSeparate_Grounds7" type="text" class="form-control 7_Client_fundsondeposit_inputs" name="Client_Funds_on_Deposit_SoleSeparate_Grounds7" value="<?php if(isset($drfundsondeposit->Client_Funds_on_Deposit_SoleSeparate_Grounds7)){ echo $drfundsondeposit->Client_Funds_on_Deposit_SoleSeparate_Grounds7; } ?>"> 
                                </div>
                                <!-- slider tool -->
                                <div class="form-group col-sm-6 m-auto slider-tool-main">
                                    <div class="row">
                                        <div class="col">{{$client_name}}</div>
                                        <div class="col text-right">{{$opponent_name}}</div>
                                    </div>
                                    <input id="7_Client_balance_range_selector" type="range" class="form-control slider-tool-input 7_Client_balance_range_selector" name="" value="<?php if(isset($drfundsondeposit->Client_Funds_on_Deposit_Percent_Marital_Equity_to_Op7)){ echo $drfundsondeposit->Client_Funds_on_Deposit_Percent_Marital_Equity_to_Op7; } ?>" min="0.00" step="0.01" max="100" onchange="updateBalanceInput(this.value, '7', 'Client');">
                                </div>
                                <div class="form-group col-sm-6 m-auto slider-tool-main">
                                    <div class="row justify-content-between">
                                        <div class="col selectorTool">
                                            <div class="left-col">
                                                <div class="client-info 7_Client_clientpercentage_div clientpercentage_div">
                                                    <?php if(isset($drfundsondeposit->Client_Funds_on_Deposit_Percent_Marital_Equity_to_Client7)){ echo $drfundsondeposit->Client_Funds_on_Deposit_Percent_Marital_Equity_to_Client7; } else {
                                                        echo "50.00";
                                                    } ?>%
                                                </div>
                                                <div class="client-info 7_Client_clientamount_div clientamount_div" style="clear: both;">
                                                    $<?php if(isset($drfundsondeposit->Client_Funds_on_Deposit_Estimated_Value_to_Client7)){ echo $drfundsondeposit->Client_Funds_on_Deposit_Estimated_Value_to_Client7; } ?>
                                                </div>
                                            </div>
                                            <label>To {{$client_name}}</label>
                                        </div>                                       
                                        <div class="col selectorTool selectorToolRight">
                                            <label>To {{$opponent_name}}</label>
                                            <div class="left-col right-col">
                                                <div class="client-info 7_Client_opponentpercentage_div opponentpercentage_div">
                                                    <?php if(isset($drfundsondeposit->Client_Funds_on_Deposit_Percent_Marital_Equity_to_Op7)){ echo $drfundsondeposit->Client_Funds_on_Deposit_Percent_Marital_Equity_to_Op7; } else {
                                                        echo "50.00";
                                                    } ?>%
                                                </div>
                                                <div class="client-info 7_Client_opponentamount_div opponentamount_div" style="clear: both;">
                                                    $<?php if(isset($drfundsondeposit->Client_Funds_on_Deposit_Estimated_Value_to_Op7)){ echo $drfundsondeposit->Client_Funds_on_Deposit_Estimated_Value_to_Op7; } ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 m-auto slider-tool-main">
                                    <label></label>
                                    <div class="w-100">
                                        <label><input type="radio" id="7_Client_Funds_on_Deposit_Estimated_Value_Select" name="7_Client_Funds_on_Deposit_Estimated_Value_Select_Reset" class="Funds_on_Deposit_Estimated_Value_Select_Reset" value="Save"> Save this Distribution of Deposit Account #7</label>
                                        <label><input type="radio" id="7_Client_Funds_on_Deposit_Estimated_Value_Reset" name="7_Client_Funds_on_Deposit_Estimated_Value_Select_Reset" class="Funds_on_Deposit_Estimated_Value_Select_Reset" value="Reset" onclick="resetBalanceInput(this, '7', 'Client');"> Reset to Default (50%)</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label>{{$client_name}} Deposite Equity Percent</label>
                                    <input id="Client_Funds_on_Deposit_Percent_Marital_Equity_to_Client7" type="number" class="form-control 7_Client_clientpercentage_input clientpercentage_input" name="Client_Funds_on_Deposit_Percent_Marital_Equity_to_Client7" value="<?php if(isset($drfundsondeposit->Client_Funds_on_Deposit_Percent_Marital_Equity_to_Client7)){ echo $drfundsondeposit->Client_Funds_on_Deposit_Percent_Marital_Equity_to_Client7; } ?>" min="0.00" step="0.01" max="100" readonly="">
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label>{{$client_name}} Deposite Equity Amount</label>
                                    <input id="Client_Funds_on_Deposit_Estimated_Value_to_Client7" type="number" class="form-control 7_Client_clientamount_input clientamount_input" name="Client_Funds_on_Deposit_Estimated_Value_to_Client7" value="<?php if(isset($drfundsondeposit->Client_Funds_on_Deposit_Estimated_Value_to_Client7)){ echo $drfundsondeposit->Client_Funds_on_Deposit_Estimated_Value_to_Client7; } ?>" min="0.00" step="0.01" max="999999.99" readonly="">
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label>{{$opponent_name}} Deposite Equity Percent</label>
                                    <input id="Client_Funds_on_Deposit_Percent_Marital_Equity_to_Op7" type="number" class="form-control 7_Client_opponentpercentage_input opponentpercentage_input" name="Client_Funds_on_Deposit_Percent_Marital_Equity_to_Op7" value="<?php if(isset($drfundsondeposit->Client_Funds_on_Deposit_Percent_Marital_Equity_to_Op7)){ echo $drfundsondeposit->Client_Funds_on_Deposit_Percent_Marital_Equity_to_Op7; } ?>" min="0.00" step="0.01" max="100" readonly="">
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label>{{$opponent_name}} Deposite Equity Amount</label>
                                    <input id="Client_Funds_on_Deposit_Estimated_Value_to_Op7" type="number" class="form-control 7_Client_opponentamount_input opponentamount_input" name="Client_Funds_on_Deposit_Estimated_Value_to_Op7" value="<?php if(isset($drfundsondeposit->Client_Funds_on_Deposit_Estimated_Value_to_Op7)){ echo $drfundsondeposit->Client_Funds_on_Deposit_Estimated_Value_to_Op7; } ?>" min="0.00" step="0.01" max="999999.99" readonly="">
                                </div>
                                <!-- end of slider tool -->
                            </div>
                            <div class="col-sm-12 mt-4 8_Client_fundsondeposit_section" style="display: none;"><h5 class="col-sm-12">Eighth Deposit Account Info</h5>
                                <div class="form-group col-sm-6">
                                    <p class="text-danger 8_Client_no-state-county-found" style="display: none;">No City, State, County found for this zipcode.</p>
                                    <label for="Client_Funds_on_Deposit_Institution_ZIP8">Deposit Institution Zip Code?</label>
                                    <input id="Client_Funds_on_Deposit_Institution_ZIP8" type="text" class="form-control 8_Client_fundsondeposit_inputs" name="Client_Funds_on_Deposit_Institution_ZIP8" value="<?php if(isset($drfundsondeposit->Client_Funds_on_Deposit_Institution_ZIP8)){ echo $drfundsondeposit->Client_Funds_on_Deposit_Institution_ZIP8; } ?>" data-onload="getCityStateForZip(this, '8', 'Client');" onkeyup="getCityStateForZip(this, '8', 'Client');"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Funds_on_Deposit_Institution_Name8">Name of Deposit Institution?</label>
                                    <input id="Client_Funds_on_Deposit_Institution_Name8" type="text" class="form-control 8_Client_fundsondeposit_inputs" name="Client_Funds_on_Deposit_Institution_Name8" value="<?php if(isset($drfundsondeposit->Client_Funds_on_Deposit_Institution_Name8)){ echo $drfundsondeposit->Client_Funds_on_Deposit_Institution_Name8; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Funds_on_Deposit_Institution_Street_Address8">Deposit Institution Street Address?</label>
                                    <input id="Client_Funds_on_Deposit_Institution_Street_Address8" type="text" class="form-control 8_Client_fundsondeposit_inputs" name="Client_Funds_on_Deposit_Institution_Street_Address8" value="<?php if(isset($drfundsondeposit->Client_Funds_on_Deposit_Institution_Street_Address8)){ echo $drfundsondeposit->Client_Funds_on_Deposit_Institution_Street_Address8; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Funds_on_Deposit_Institution_City8">Deposit Institution City?</label>
                                    <input type="hidden" name="" id="Client_Funds_on_Deposit_Institution_City8_Value" value="<?php if(isset($drfundsondeposit->Client_Funds_on_Deposit_Institution_City8)){ echo $drfundsondeposit->Client_Funds_on_Deposit_Institution_City8; } ?>">
                                    <select id="Client_Funds_on_Deposit_Institution_City8" name="Client_Funds_on_Deposit_Institution_City8" class="form-control 8_Client_city_select">
                                        <option value="">Choose City</option>
                                    </select>   
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Funds_on_Deposit_Institution_State8">Deposit Institution State?</label>
                                    <input type="hidden" name="" id="Client_Funds_on_Deposit_Institution_State8_Value" value="<?php if(isset($drfundsondeposit->Client_Funds_on_Deposit_Institution_City8)){ echo $drfundsondeposit->Client_Funds_on_Deposit_Institution_City8; } ?>">
                                    <select id="Client_Funds_on_Deposit_Institution_State8" name="Client_Funds_on_Deposit_Institution_State8" class="form-control 8_Client_state_select">
                                        <option value="">Choose State</option>
                                    </select>   
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Funds_on_Deposit_Institution_Acct_Num8">Account Number?</label>
                                    <input id="Client_Funds_on_Deposit_Institution_Acct_Num8" type="text" class="form-control 8_Client_fundsondeposit_inputs" name="Client_Funds_on_Deposit_Institution_Acct_Num8" value="<?php if(isset($drfundsondeposit->Client_Funds_on_Deposit_Institution_Acct_Num8)){ echo $drfundsondeposit->Client_Funds_on_Deposit_Institution_Acct_Num8; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Name on this account?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Client_Funds_on_Deposit_Institution_Name_on_Acct8_Client" name="Client_Funds_on_Deposit_Institution_Name_on_Acct8" value="{{$client_name}}" <?php if(isset($drfundsondeposit->Client_Funds_on_Deposit_Institution_Name_on_Acct8) && $drfundsondeposit->Client_Funds_on_Deposit_Institution_Name_on_Acct8==$client_name){ echo "checked"; } ?>> {{$client_name}}</label>
                                        <label><input type="radio" id="Client_Funds_on_Deposit_Institution_Name_on_Acct8_Op" name="Client_Funds_on_Deposit_Institution_Name_on_Acct8" value="{{$opponent_name}}" <?php if(isset($drfundsondeposit->Client_Funds_on_Deposit_Institution_Name_on_Acct8) && $drfundsondeposit->Client_Funds_on_Deposit_Institution_Name_on_Acct8==$opponent_name){ echo "checked"; } ?>> {{$opponent_name}}</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Funds_on_Deposit_Institution_Current_Balance8">Current Balance?</label>
                                    <input id="Client_Funds_on_Deposit_Institution_Current_Balance8" type="number" class="form-control 8_Client_fundsondeposit_inputs" name="Client_Funds_on_Deposit_Institution_Current_Balance8" value="<?php if(isset($drfundsondeposit->Client_Funds_on_Deposit_Institution_Current_Balance8)){ echo $drfundsondeposit->Client_Funds_on_Deposit_Institution_Current_Balance8; } ?>" min="0.00" step="0.01" max="999999.99" onchange="getClientOpCurrentBalance(this, '8', 'Client');" onkeyup="getClientOpCurrentBalance(this, '8', 'Client');"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Funds_on_Deposit_Institution_Yearly_Interest_Dividend8">Yearly Interest?</label>
                                    <input id="Client_Funds_on_Deposit_Institution_Yearly_Interest_Dividend8" type="number" class="form-control 8_Client_fundsondeposit_inputs" name="Client_Funds_on_Deposit_Institution_Yearly_Interest_Dividend8" value="<?php if(isset($drfundsondeposit->Client_Funds_on_Deposit_Institution_Yearly_Interest_Dividend8)){ echo $drfundsondeposit->Client_Funds_on_Deposit_Institution_Yearly_Interest_Dividend8; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Funds_on_Deposit_Institution_Balance_Date_of_Marriage8">Balance on marriage date (0.00, if started after marriage)?</label>
                                    <input id="Client_Funds_on_Deposit_Institution_Balance_Date_of_Marriage8" type="number" class="form-control 8_Client_fundsondeposit_inputs" name="Client_Funds_on_Deposit_Institution_Balance_Date_of_Marriage8" value="<?php if(isset($drfundsondeposit->Client_Funds_on_Deposit_Institution_Balance_Date_of_Marriage8)){ echo $drfundsondeposit->Client_Funds_on_Deposit_Institution_Balance_Date_of_Marriage8; } ?>" min="0.00" step="0.01" max="999999.99" onchange="getClientOpCurrentBalance(this, '8', 'Client');" onkeyup="getClientOpCurrentBalance(this, '8', 'Client');"> 
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label for="Client_Funds_on_Deposit_Estimated_MaritalEquity8">N/A, calculated = Client_Funds_on_Deposit_Institution_Current_Balance8 – Client_Funds_on_Deposit_Institution_Balance_Date_of_Marriage8</label>
                                    <input id="Client_Funds_on_Deposit_Estimated_MaritalEquity8" type="number" class="form-control 8_Client_fundsondeposit_inputs" name="Client_Funds_on_Deposit_Estimated_MaritalEquity8" value="<?php if(isset($drfundsondeposit->Client_Funds_on_Deposit_Estimated_MaritalEquity8)){ echo $drfundsondeposit->Client_Funds_on_Deposit_Estimated_MaritalEquity8; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Does either party claim a sole/separate interest from the other on this fund?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Client_Funds_on_Deposit_SoleSeparate_Claim8_Yes" name="Client_Funds_on_Deposit_SoleSeparate_Claim8" value="Yes" <?php if(isset($drfundsondeposit->Client_Funds_on_Deposit_SoleSeparate_Claim8) && $drfundsondeposit->Client_Funds_on_Deposit_SoleSeparate_Claim8=='Yes'){ echo "checked"; } ?>> Yes</label>
                                        <label><input type="radio" id="Client_Funds_on_Deposit_SoleSeparate_Claim8_No" name="Client_Funds_on_Deposit_SoleSeparate_Claim8" value="No" <?php if(isset($drfundsondeposit->Client_Funds_on_Deposit_SoleSeparate_Claim8) && $drfundsondeposit->Client_Funds_on_Deposit_SoleSeparate_Claim8=='No'){ echo "checked"; } ?>> No</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Who claims to own this fund?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Client_Funds_on_Deposit_SoleSeparate_Party8_Client" name="Client_Funds_on_Deposit_SoleSeparate_Party8" value="{{$client_name}}" <?php if(isset($drfundsondeposit->Client_Funds_on_Deposit_SoleSeparate_Party8) && $drfundsondeposit->Client_Funds_on_Deposit_SoleSeparate_Party8==$client_name){ echo "checked"; } ?>> {{$client_name}}</label>
                                        <label><input type="radio" id="Client_Funds_on_Deposit_SoleSeparate_Party8_Op" name="Client_Funds_on_Deposit_SoleSeparate_Party8" value="{{$opponent_name}}" <?php if(isset($drfundsondeposit->Client_Funds_on_Deposit_SoleSeparate_Party8) && $drfundsondeposit->Client_Funds_on_Deposit_SoleSeparate_Party8==$opponent_name){ echo "checked"; } ?>> {{$opponent_name}}</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 left-clear">
                                    <label for="Client_Funds_on_Deposit_SoleSeparate_Grounds8">Why does this person own this fund solely and separately?</label>
                                    <input id="Client_Funds_on_Deposit_SoleSeparate_Grounds8" type="text" class="form-control 8_Client_fundsondeposit_inputs" name="Client_Funds_on_Deposit_SoleSeparate_Grounds8" value="<?php if(isset($drfundsondeposit->Client_Funds_on_Deposit_SoleSeparate_Grounds8)){ echo $drfundsondeposit->Client_Funds_on_Deposit_SoleSeparate_Grounds8; } ?>"> 
                                </div>
                                <!-- slider tool -->
                                <div class="form-group col-sm-6 m-auto slider-tool-main">
                                    <div class="row">
                                        <div class="col">{{$client_name}}</div>
                                        <div class="col text-right">{{$opponent_name}}</div>
                                    </div>
                                    <input id="8_Client_balance_range_selector" type="range" class="form-control slider-tool-input 8_Client_balance_range_selector" name="" value="<?php if(isset($drfundsondeposit->Client_Funds_on_Deposit_Percent_Marital_Equity_to_Op8)){ echo $drfundsondeposit->Client_Funds_on_Deposit_Percent_Marital_Equity_to_Op8; } ?>" min="0.00" step="0.01" max="100" onchange="updateBalanceInput(this.value, '8', 'Client');">
                                </div>
                                <div class="form-group col-sm-6 m-auto slider-tool-main">
                                    <div class="row justify-content-between">
                                        <div class="col selectorTool">
                                            <div class="left-col">
                                                <div class="client-info 8_Client_clientpercentage_div clientpercentage_div">
                                                    <?php if(isset($drfundsondeposit->Client_Funds_on_Deposit_Percent_Marital_Equity_to_Client8)){ echo $drfundsondeposit->Client_Funds_on_Deposit_Percent_Marital_Equity_to_Client8; } else {
                                                        echo "50.00";
                                                    } ?>%
                                                </div>
                                                <div class="client-info 8_Client_clientamount_div clientamount_div" style="clear: both;">
                                                    $<?php if(isset($drfundsondeposit->Client_Funds_on_Deposit_Estimated_Value_to_Client8)){ echo $drfundsondeposit->Client_Funds_on_Deposit_Estimated_Value_to_Client8; } ?>
                                                </div>
                                            </div>
                                            <label>To {{$client_name}}</label>
                                        </div>                                       
                                        <div class="col selectorTool selectorToolRight">
                                            <label>To {{$opponent_name}}</label>
                                            <div class="left-col right-col">
                                                <div class="client-info 8_Client_opponentpercentage_div opponentpercentage_div">
                                                    <?php if(isset($drfundsondeposit->Client_Funds_on_Deposit_Percent_Marital_Equity_to_Op8)){ echo $drfundsondeposit->Client_Funds_on_Deposit_Percent_Marital_Equity_to_Op8; } else {
                                                        echo "50.00";
                                                    } ?>%
                                                </div>
                                                <div class="client-info 8_Client_opponentamount_div opponentamount_div" style="clear: both;">
                                                    $<?php if(isset($drfundsondeposit->Client_Funds_on_Deposit_Estimated_Value_to_Op8)){ echo $drfundsondeposit->Client_Funds_on_Deposit_Estimated_Value_to_Op8; } ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 m-auto slider-tool-main">
                                    <label></label>
                                    <div class="w-100">
                                        <label><input type="radio" id="8_Client_Funds_on_Deposit_Estimated_Value_Select" name="8_Client_Funds_on_Deposit_Estimated_Value_Select_Reset" class="Funds_on_Deposit_Estimated_Value_Select_Reset" value="Save"> Save this Distribution of Deposit Account #8</label>
                                        <label><input type="radio" id="8_Client_Funds_on_Deposit_Estimated_Value_Reset" name="8_Client_Funds_on_Deposit_Estimated_Value_Select_Reset" class="Funds_on_Deposit_Estimated_Value_Select_Reset" value="Reset" onclick="resetBalanceInput(this, '8', 'Client');"> Reset to Default (50%)</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label>{{$client_name}} Deposite Equity Percent</label>
                                    <input id="Client_Funds_on_Deposit_Percent_Marital_Equity_to_Client8" type="number" class="form-control 8_Client_clientpercentage_input clientpercentage_input" name="Client_Funds_on_Deposit_Percent_Marital_Equity_to_Client8" value="<?php if(isset($drfundsondeposit->Client_Funds_on_Deposit_Percent_Marital_Equity_to_Client8)){ echo $drfundsondeposit->Client_Funds_on_Deposit_Percent_Marital_Equity_to_Client8; } ?>" min="0.00" step="0.01" max="100" readonly="">
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label>{{$client_name}} Deposite Equity Amount</label>
                                    <input id="Client_Funds_on_Deposit_Estimated_Value_to_Client8" type="number" class="form-control 8_Client_clientamount_input clientamount_input" name="Client_Funds_on_Deposit_Estimated_Value_to_Client8" value="<?php if(isset($drfundsondeposit->Client_Funds_on_Deposit_Estimated_Value_to_Client8)){ echo $drfundsondeposit->Client_Funds_on_Deposit_Estimated_Value_to_Client8; } ?>" min="0.00" step="0.01" max="999999.99" readonly="">
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label>{{$opponent_name}} Deposite Equity Percent</label>
                                    <input id="Client_Funds_on_Deposit_Percent_Marital_Equity_to_Op8" type="number" class="form-control 8_Client_opponentpercentage_input opponentpercentage_input" name="Client_Funds_on_Deposit_Percent_Marital_Equity_to_Op8" value="<?php if(isset($drfundsondeposit->Client_Funds_on_Deposit_Percent_Marital_Equity_to_Op8)){ echo $drfundsondeposit->Client_Funds_on_Deposit_Percent_Marital_Equity_to_Op8; } ?>" min="0.00" step="0.01" max="100" readonly="">
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label>{{$opponent_name}} Deposite Equity Amount</label>
                                    <input id="Client_Funds_on_Deposit_Estimated_Value_to_Op8" type="number" class="form-control 8_Client_opponentamount_input opponentamount_input" name="Client_Funds_on_Deposit_Estimated_Value_to_Op8" value="<?php if(isset($drfundsondeposit->Client_Funds_on_Deposit_Estimated_Value_to_Op8)){ echo $drfundsondeposit->Client_Funds_on_Deposit_Estimated_Value_to_Op8; } ?>" min="0.00" step="0.01" max="999999.99" readonly="">
                                </div>
                                <!-- end of slider tool -->
                            </div>
                            <div class="col-sm-12 mt-4 9_Client_fundsondeposit_section" style="display: none;"><h5 class="col-sm-12">Nineth Deposit Account Info</h5>
                                <div class="form-group col-sm-6">
                                    <p class="text-danger 9_Client_no-state-county-found" style="display: none;">No City, State, County found for this zipcode.</p>
                                    <label for="Client_Funds_on_Deposit_Institution_ZIP9">Deposit Institution Zip Code?</label>
                                    <input id="Client_Funds_on_Deposit_Institution_ZIP9" type="text" class="form-control 9_Client_fundsondeposit_inputs" name="Client_Funds_on_Deposit_Institution_ZIP9" value="<?php if(isset($drfundsondeposit->Client_Funds_on_Deposit_Institution_ZIP9)){ echo $drfundsondeposit->Client_Funds_on_Deposit_Institution_ZIP9; } ?>" data-onload="getCityStateForZip(this, '9', 'Client');" onkeyup="getCityStateForZip(this, '9', 'Client');"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Funds_on_Deposit_Institution_Name9">Name of Deposit Institution?</label>
                                    <input id="Client_Funds_on_Deposit_Institution_Name9" type="text" class="form-control 9_Client_fundsondeposit_inputs" name="Client_Funds_on_Deposit_Institution_Name9" value="<?php if(isset($drfundsondeposit->Client_Funds_on_Deposit_Institution_Name9)){ echo $drfundsondeposit->Client_Funds_on_Deposit_Institution_Name9; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Funds_on_Deposit_Institution_Street_Address9">Deposit Institution Street Address?</label>
                                    <input id="Client_Funds_on_Deposit_Institution_Street_Address9" type="text" class="form-control 9_Client_fundsondeposit_inputs" name="Client_Funds_on_Deposit_Institution_Street_Address9" value="<?php if(isset($drfundsondeposit->Client_Funds_on_Deposit_Institution_Street_Address9)){ echo $drfundsondeposit->Client_Funds_on_Deposit_Institution_Street_Address9; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Funds_on_Deposit_Institution_City9">Deposit Institution City?</label>
                                    <input type="hidden" name="" id="Client_Funds_on_Deposit_Institution_City9_Value" value="<?php if(isset($drfundsondeposit->Client_Funds_on_Deposit_Institution_City9)){ echo $drfundsondeposit->Client_Funds_on_Deposit_Institution_City9; } ?>">
                                    <select id="Client_Funds_on_Deposit_Institution_City9" name="Client_Funds_on_Deposit_Institution_City9" class="form-control 9_Client_city_select">
                                        <option value="">Choose City</option>
                                    </select>   
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Funds_on_Deposit_Institution_State9">Deposit Institution State?</label>
                                    <input type="hidden" name="" id="Client_Funds_on_Deposit_Institution_State9_Value" value="<?php if(isset($drfundsondeposit->Client_Funds_on_Deposit_Institution_City9)){ echo $drfundsondeposit->Client_Funds_on_Deposit_Institution_City9; } ?>">
                                    <select id="Client_Funds_on_Deposit_Institution_State9" name="Client_Funds_on_Deposit_Institution_State9" class="form-control 9_Client_state_select">
                                        <option value="">Choose State</option>
                                    </select>   
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Funds_on_Deposit_Institution_Acct_Num9">Account Number?</label>
                                    <input id="Client_Funds_on_Deposit_Institution_Acct_Num9" type="text" class="form-control 9_Client_fundsondeposit_inputs" name="Client_Funds_on_Deposit_Institution_Acct_Num9" value="<?php if(isset($drfundsondeposit->Client_Funds_on_Deposit_Institution_Acct_Num9)){ echo $drfundsondeposit->Client_Funds_on_Deposit_Institution_Acct_Num9; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Name on this account?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Client_Funds_on_Deposit_Institution_Name_on_Acct9_Client" name="Client_Funds_on_Deposit_Institution_Name_on_Acct9" value="{{$client_name}}" <?php if(isset($drfundsondeposit->Client_Funds_on_Deposit_Institution_Name_on_Acct9) && $drfundsondeposit->Client_Funds_on_Deposit_Institution_Name_on_Acct9==$client_name){ echo "checked"; } ?>> {{$client_name}}</label>
                                        <label><input type="radio" id="Client_Funds_on_Deposit_Institution_Name_on_Acct9_Op" name="Client_Funds_on_Deposit_Institution_Name_on_Acct9" value="{{$opponent_name}}" <?php if(isset($drfundsondeposit->Client_Funds_on_Deposit_Institution_Name_on_Acct9) && $drfundsondeposit->Client_Funds_on_Deposit_Institution_Name_on_Acct9==$opponent_name){ echo "checked"; } ?>> {{$opponent_name}}</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Funds_on_Deposit_Institution_Current_Balance9">Current Balance?</label>
                                    <input id="Client_Funds_on_Deposit_Institution_Current_Balance9" type="number" class="form-control 9_Client_fundsondeposit_inputs" name="Client_Funds_on_Deposit_Institution_Current_Balance9" value="<?php if(isset($drfundsondeposit->Client_Funds_on_Deposit_Institution_Current_Balance9)){ echo $drfundsondeposit->Client_Funds_on_Deposit_Institution_Current_Balance9; } ?>" min="0.00" step="0.01" max="999999.99" onchange="getClientOpCurrentBalance(this, '9', 'Client');" onkeyup="getClientOpCurrentBalance(this, '9', 'Client');"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Funds_on_Deposit_Institution_Yearly_Interest_Dividend9">Yearly Interest?</label>
                                    <input id="Client_Funds_on_Deposit_Institution_Yearly_Interest_Dividend9" type="number" class="form-control 9_Client_fundsondeposit_inputs" name="Client_Funds_on_Deposit_Institution_Yearly_Interest_Dividend9" value="<?php if(isset($drfundsondeposit->Client_Funds_on_Deposit_Institution_Yearly_Interest_Dividend9)){ echo $drfundsondeposit->Client_Funds_on_Deposit_Institution_Yearly_Interest_Dividend9; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Funds_on_Deposit_Institution_Balance_Date_of_Marriage9">Balance on marriage date (0.00, if started after marriage)?</label>
                                    <input id="Client_Funds_on_Deposit_Institution_Balance_Date_of_Marriage9" type="number" class="form-control 9_Client_fundsondeposit_inputs" name="Client_Funds_on_Deposit_Institution_Balance_Date_of_Marriage9" value="<?php if(isset($drfundsondeposit->Client_Funds_on_Deposit_Institution_Balance_Date_of_Marriage9)){ echo $drfundsondeposit->Client_Funds_on_Deposit_Institution_Balance_Date_of_Marriage9; } ?>" min="0.00" step="0.01" max="999999.99" onchange="getClientOpCurrentBalance(this, '9', 'Client');" onkeyup="getClientOpCurrentBalance(this, '9', 'Client');"> 
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label for="Client_Funds_on_Deposit_Estimated_MaritalEquity9">N/A, calculated = Client_Funds_on_Deposit_Institution_Current_Balance9 – Client_Funds_on_Deposit_Institution_Balance_Date_of_Marriage9</label>
                                    <input id="Client_Funds_on_Deposit_Estimated_MaritalEquity9" type="number" class="form-control 9_Client_fundsondeposit_inputs" name="Client_Funds_on_Deposit_Estimated_MaritalEquity9" value="<?php if(isset($drfundsondeposit->Client_Funds_on_Deposit_Estimated_MaritalEquity9)){ echo $drfundsondeposit->Client_Funds_on_Deposit_Estimated_MaritalEquity9; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Does either party claim a sole/separate interest from the other on this fund?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Client_Funds_on_Deposit_SoleSeparate_Claim9_Yes" name="Client_Funds_on_Deposit_SoleSeparate_Claim9" value="Yes" <?php if(isset($drfundsondeposit->Client_Funds_on_Deposit_SoleSeparate_Claim9) && $drfundsondeposit->Client_Funds_on_Deposit_SoleSeparate_Claim9=='Yes'){ echo "checked"; } ?>> Yes</label>
                                        <label><input type="radio" id="Client_Funds_on_Deposit_SoleSeparate_Claim9_No" name="Client_Funds_on_Deposit_SoleSeparate_Claim9" value="No" <?php if(isset($drfundsondeposit->Client_Funds_on_Deposit_SoleSeparate_Claim9) && $drfundsondeposit->Client_Funds_on_Deposit_SoleSeparate_Claim9=='No'){ echo "checked"; } ?>> No</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Who claims to own this fund?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Client_Funds_on_Deposit_SoleSeparate_Party9_Client" name="Client_Funds_on_Deposit_SoleSeparate_Party9" value="{{$client_name}}" <?php if(isset($drfundsondeposit->Client_Funds_on_Deposit_SoleSeparate_Party9) && $drfundsondeposit->Client_Funds_on_Deposit_SoleSeparate_Party9==$client_name){ echo "checked"; } ?>> {{$client_name}}</label>
                                        <label><input type="radio" id="Client_Funds_on_Deposit_SoleSeparate_Party9_Op" name="Client_Funds_on_Deposit_SoleSeparate_Party9" value="{{$opponent_name}}" <?php if(isset($drfundsondeposit->Client_Funds_on_Deposit_SoleSeparate_Party9) && $drfundsondeposit->Client_Funds_on_Deposit_SoleSeparate_Party9==$opponent_name){ echo "checked"; } ?>> {{$opponent_name}}</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 left-clear">
                                    <label for="Client_Funds_on_Deposit_SoleSeparate_Grounds9">Why does this person own this fund solely and separately?</label>
                                    <input id="Client_Funds_on_Deposit_SoleSeparate_Grounds9" type="text" class="form-control 9_Client_fundsondeposit_inputs" name="Client_Funds_on_Deposit_SoleSeparate_Grounds9" value="<?php if(isset($drfundsondeposit->Client_Funds_on_Deposit_SoleSeparate_Grounds9)){ echo $drfundsondeposit->Client_Funds_on_Deposit_SoleSeparate_Grounds9; } ?>"> 
                                </div>
                                <!-- slider tool -->
                                <div class="form-group col-sm-6 m-auto slider-tool-main">
                                    <div class="row">
                                        <div class="col">{{$client_name}}</div>
                                        <div class="col text-right">{{$opponent_name}}</div>
                                    </div>
                                    <input id="9_Client_balance_range_selector" type="range" class="form-control slider-tool-input 9_Client_balance_range_selector" name="" value="<?php if(isset($drfundsondeposit->Client_Funds_on_Deposit_Percent_Marital_Equity_to_Op9)){ echo $drfundsondeposit->Client_Funds_on_Deposit_Percent_Marital_Equity_to_Op9; } ?>" min="0.00" step="0.01" max="100" onchange="updateBalanceInput(this.value, '9', 'Client');">
                                </div>
                                <div class="form-group col-sm-6 m-auto slider-tool-main">
                                    <div class="row justify-content-between">
                                        <div class="col selectorTool">
                                            <div class="left-col">
                                                <div class="client-info 9_Client_clientpercentage_div clientpercentage_div">
                                                    <?php if(isset($drfundsondeposit->Client_Funds_on_Deposit_Percent_Marital_Equity_to_Client9)){ echo $drfundsondeposit->Client_Funds_on_Deposit_Percent_Marital_Equity_to_Client9; } else {
                                                        echo "50.00";
                                                    } ?>%
                                                </div>
                                                <div class="client-info 9_Client_clientamount_div clientamount_div" style="clear: both;">
                                                    $<?php if(isset($drfundsondeposit->Client_Funds_on_Deposit_Estimated_Value_to_Client9)){ echo $drfundsondeposit->Client_Funds_on_Deposit_Estimated_Value_to_Client9; } ?>
                                                </div>
                                            </div>
                                            <label>To {{$client_name}}</label>
                                        </div>                                       
                                        <div class="col selectorTool selectorToolRight">
                                            <label>To {{$opponent_name}}</label>
                                            <div class="left-col right-col">
                                                <div class="client-info 9_Client_opponentpercentage_div opponentpercentage_div">
                                                    <?php if(isset($drfundsondeposit->Client_Funds_on_Deposit_Percent_Marital_Equity_to_Op9)){ echo $drfundsondeposit->Client_Funds_on_Deposit_Percent_Marital_Equity_to_Op9; } else {
                                                        echo "50.00";
                                                    } ?>%
                                                </div>
                                                <div class="client-info 9_Client_opponentamount_div opponentamount_div" style="clear: both;">
                                                    $<?php if(isset($drfundsondeposit->Client_Funds_on_Deposit_Estimated_Value_to_Op9)){ echo $drfundsondeposit->Client_Funds_on_Deposit_Estimated_Value_to_Op9; } ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 m-auto slider-tool-main">
                                    <label></label>
                                    <div class="w-100">
                                        <label><input type="radio" id="9_Client_Funds_on_Deposit_Estimated_Value_Select" name="9_Client_Funds_on_Deposit_Estimated_Value_Select_Reset" class="Funds_on_Deposit_Estimated_Value_Select_Reset" value="Save"> Save this Distribution of Deposit Account #9</label>
                                        <label><input type="radio" id="9_Client_Funds_on_Deposit_Estimated_Value_Reset" name="9_Client_Funds_on_Deposit_Estimated_Value_Select_Reset" class="Funds_on_Deposit_Estimated_Value_Select_Reset" value="Reset" onclick="resetBalanceInput(this, '9', 'Client');"> Reset to Default (50%)</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label>{{$client_name}} Deposite Equity Percent</label>
                                    <input id="Client_Funds_on_Deposit_Percent_Marital_Equity_to_Client9" type="number" class="form-control 9_Client_clientpercentage_input clientpercentage_input" name="Client_Funds_on_Deposit_Percent_Marital_Equity_to_Client9" value="<?php if(isset($drfundsondeposit->Client_Funds_on_Deposit_Percent_Marital_Equity_to_Client9)){ echo $drfundsondeposit->Client_Funds_on_Deposit_Percent_Marital_Equity_to_Client9; } ?>" min="0.00" step="0.01" max="100" readonly="">
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label>{{$client_name}} Deposite Equity Amount</label>
                                    <input id="Client_Funds_on_Deposit_Estimated_Value_to_Client9" type="number" class="form-control 9_Client_clientamount_input clientamount_input" name="Client_Funds_on_Deposit_Estimated_Value_to_Client9" value="<?php if(isset($drfundsondeposit->Client_Funds_on_Deposit_Estimated_Value_to_Client9)){ echo $drfundsondeposit->Client_Funds_on_Deposit_Estimated_Value_to_Client9; } ?>" min="0.00" step="0.01" max="999999.99" readonly="">
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label>{{$opponent_name}} Deposite Equity Percent</label>
                                    <input id="Client_Funds_on_Deposit_Percent_Marital_Equity_to_Op9" type="number" class="form-control 9_Client_opponentpercentage_input opponentpercentage_input" name="Client_Funds_on_Deposit_Percent_Marital_Equity_to_Op9" value="<?php if(isset($drfundsondeposit->Client_Funds_on_Deposit_Percent_Marital_Equity_to_Op9)){ echo $drfundsondeposit->Client_Funds_on_Deposit_Percent_Marital_Equity_to_Op9; } ?>" min="0.00" step="0.01" max="100" readonly="">
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label>{{$opponent_name}} Deposite Equity Amount</label>
                                    <input id="Client_Funds_on_Deposit_Estimated_Value_to_Op9" type="number" class="form-control 9_Client_opponentamount_input opponentamount_input" name="Client_Funds_on_Deposit_Estimated_Value_to_Op9" value="<?php if(isset($drfundsondeposit->Client_Funds_on_Deposit_Estimated_Value_to_Op9)){ echo $drfundsondeposit->Client_Funds_on_Deposit_Estimated_Value_to_Op9; } ?>" min="0.00" step="0.01" max="999999.99" readonly="">
                                </div>
                                <!-- end of slider tool -->
                            </div>
                            <div class="col-sm-12 mt-4 10_Client_fundsondeposit_section" style="display: none;"><h5 class="col-sm-12">Tenth Deposit Account Info</h5>
                                <div class="form-group col-sm-6">
                                    <p class="text-danger 10_Client_no-state-county-found" style="display: none;">No City, State, County found for this zipcode.</p>
                                    <label for="Client_Funds_on_Deposit_Institution_ZIP10">Deposit Institution Zip Code?</label>
                                    <input id="Client_Funds_on_Deposit_Institution_ZIP10" type="text" class="form-control 10_Client_fundsondeposit_inputs" name="Client_Funds_on_Deposit_Institution_ZIP10" value="<?php if(isset($drfundsondeposit->Client_Funds_on_Deposit_Institution_ZIP10)){ echo $drfundsondeposit->Client_Funds_on_Deposit_Institution_ZIP10; } ?>" data-onload="getCityStateForZip(this, '10', 'Client');" onkeyup="getCityStateForZip(this, '10', 'Client');"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Funds_on_Deposit_Institution_Name10">Name of Deposit Institution?</label>
                                    <input id="Client_Funds_on_Deposit_Institution_Name10" type="text" class="form-control 10_Client_fundsondeposit_inputs" name="Client_Funds_on_Deposit_Institution_Name10" value="<?php if(isset($drfundsondeposit->Client_Funds_on_Deposit_Institution_Name10)){ echo $drfundsondeposit->Client_Funds_on_Deposit_Institution_Name10; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Funds_on_Deposit_Institution_Street_Address10">Deposit Institution Street Address?</label>
                                    <input id="Client_Funds_on_Deposit_Institution_Street_Address10" type="text" class="form-control 10_Client_fundsondeposit_inputs" name="Client_Funds_on_Deposit_Institution_Street_Address10" value="<?php if(isset($drfundsondeposit->Client_Funds_on_Deposit_Institution_Street_Address10)){ echo $drfundsondeposit->Client_Funds_on_Deposit_Institution_Street_Address10; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Funds_on_Deposit_Institution_City10">Deposit Institution City?</label>
                                    <input type="hidden" name="" id="Client_Funds_on_Deposit_Institution_City10_Value" value="<?php if(isset($drfundsondeposit->Client_Funds_on_Deposit_Institution_City10)){ echo $drfundsondeposit->Client_Funds_on_Deposit_Institution_City10; } ?>">
                                    <select id="Client_Funds_on_Deposit_Institution_City10" name="Client_Funds_on_Deposit_Institution_City10" class="form-control 10_Client_city_select">
                                        <option value="">Choose City</option>
                                    </select>   
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Funds_on_Deposit_Institution_State10">Deposit Institution State?</label>
                                    <input type="hidden" name="" id="Client_Funds_on_Deposit_Institution_State10_Value" value="<?php if(isset($drfundsondeposit->Client_Funds_on_Deposit_Institution_City10)){ echo $drfundsondeposit->Client_Funds_on_Deposit_Institution_City10; } ?>">
                                    <select id="Client_Funds_on_Deposit_Institution_State10" name="Client_Funds_on_Deposit_Institution_State10" class="form-control 10_Client_state_select">
                                        <option value="">Choose State</option>
                                    </select>   
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Funds_on_Deposit_Institution_Acct_Num10">Account Number?</label>
                                    <input id="Client_Funds_on_Deposit_Institution_Acct_Num10" type="text" class="form-control 10_Client_fundsondeposit_inputs" name="Client_Funds_on_Deposit_Institution_Acct_Num10" value="<?php if(isset($drfundsondeposit->Client_Funds_on_Deposit_Institution_Acct_Num10)){ echo $drfundsondeposit->Client_Funds_on_Deposit_Institution_Acct_Num10; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Name on this account?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Client_Funds_on_Deposit_Institution_Name_on_Acct10_Client" name="Client_Funds_on_Deposit_Institution_Name_on_Acct10" value="{{$client_name}}" <?php if(isset($drfundsondeposit->Client_Funds_on_Deposit_Institution_Name_on_Acct10) && $drfundsondeposit->Client_Funds_on_Deposit_Institution_Name_on_Acct10==$client_name){ echo "checked"; } ?>> {{$client_name}}</label>
                                        <label><input type="radio" id="Client_Funds_on_Deposit_Institution_Name_on_Acct10_Op" name="Client_Funds_on_Deposit_Institution_Name_on_Acct10" value="{{$opponent_name}}" <?php if(isset($drfundsondeposit->Client_Funds_on_Deposit_Institution_Name_on_Acct10) && $drfundsondeposit->Client_Funds_on_Deposit_Institution_Name_on_Acct10==$opponent_name){ echo "checked"; } ?>> {{$opponent_name}}</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Funds_on_Deposit_Institution_Current_Balance10">Current Balance?</label>
                                    <input id="Client_Funds_on_Deposit_Institution_Current_Balance10" type="number" class="form-control 10_Client_fundsondeposit_inputs" name="Client_Funds_on_Deposit_Institution_Current_Balance10" value="<?php if(isset($drfundsondeposit->Client_Funds_on_Deposit_Institution_Current_Balance10)){ echo $drfundsondeposit->Client_Funds_on_Deposit_Institution_Current_Balance10; } ?>" min="0.00" step="0.01" max="999999.99" onchange="getClientOpCurrentBalance(this, '10', 'Client');" onkeyup="getClientOpCurrentBalance(this, '10', 'Client');"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Funds_on_Deposit_Institution_Yearly_Interest_Dividend10">Yearly Interest?</label>
                                    <input id="Client_Funds_on_Deposit_Institution_Yearly_Interest_Dividend10" type="number" class="form-control 10_Client_fundsondeposit_inputs" name="Client_Funds_on_Deposit_Institution_Yearly_Interest_Dividend10" value="<?php if(isset($drfundsondeposit->Client_Funds_on_Deposit_Institution_Yearly_Interest_Dividend10)){ echo $drfundsondeposit->Client_Funds_on_Deposit_Institution_Yearly_Interest_Dividend10; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Funds_on_Deposit_Institution_Balance_Date_of_Marriage10">Balance on marriage date (0.00, if started after marriage)?</label>
                                    <input id="Client_Funds_on_Deposit_Institution_Balance_Date_of_Marriage10" type="number" class="form-control 10_Client_fundsondeposit_inputs" name="Client_Funds_on_Deposit_Institution_Balance_Date_of_Marriage10" value="<?php if(isset($drfundsondeposit->Client_Funds_on_Deposit_Institution_Balance_Date_of_Marriage10)){ echo $drfundsondeposit->Client_Funds_on_Deposit_Institution_Balance_Date_of_Marriage10; } ?>" min="0.00" step="0.01" max="999999.99" onchange="getClientOpCurrentBalance(this, '10', 'Client');" onkeyup="getClientOpCurrentBalance(this, '10', 'Client');"> 
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label for="Client_Funds_on_Deposit_Estimated_MaritalEquity10">N/A, calculated = Client_Funds_on_Deposit_Institution_Current_Balance10 – Client_Funds_on_Deposit_Institution_Balance_Date_of_Marriage10</label>
                                    <input id="Client_Funds_on_Deposit_Estimated_MaritalEquity10" type="number" class="form-control 10_Client_fundsondeposit_inputs" name="Client_Funds_on_Deposit_Estimated_MaritalEquity10" value="<?php if(isset($drfundsondeposit->Client_Funds_on_Deposit_Estimated_MaritalEquity10)){ echo $drfundsondeposit->Client_Funds_on_Deposit_Estimated_MaritalEquity10; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Does either party claim a sole/separate interest from the other on this fund?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Client_Funds_on_Deposit_SoleSeparate_Claim10_Yes" name="Client_Funds_on_Deposit_SoleSeparate_Claim10" value="Yes" <?php if(isset($drfundsondeposit->Client_Funds_on_Deposit_SoleSeparate_Claim10) && $drfundsondeposit->Client_Funds_on_Deposit_SoleSeparate_Claim10=='Yes'){ echo "checked"; } ?>> Yes</label>
                                        <label><input type="radio" id="Client_Funds_on_Deposit_SoleSeparate_Claim10_No" name="Client_Funds_on_Deposit_SoleSeparate_Claim10" value="No" <?php if(isset($drfundsondeposit->Client_Funds_on_Deposit_SoleSeparate_Claim10) && $drfundsondeposit->Client_Funds_on_Deposit_SoleSeparate_Claim10=='No'){ echo "checked"; } ?>> No</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Who claims to own this fund?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Client_Funds_on_Deposit_SoleSeparate_Party10_Client" name="Client_Funds_on_Deposit_SoleSeparate_Party10" value="{{$client_name}}" <?php if(isset($drfundsondeposit->Client_Funds_on_Deposit_SoleSeparate_Party10) && $drfundsondeposit->Client_Funds_on_Deposit_SoleSeparate_Party10==$client_name){ echo "checked"; } ?>> {{$client_name}}</label>
                                        <label><input type="radio" id="Client_Funds_on_Deposit_SoleSeparate_Party10_Op" name="Client_Funds_on_Deposit_SoleSeparate_Party10" value="{{$opponent_name}}" <?php if(isset($drfundsondeposit->Client_Funds_on_Deposit_SoleSeparate_Party10) && $drfundsondeposit->Client_Funds_on_Deposit_SoleSeparate_Party10==$opponent_name){ echo "checked"; } ?>> {{$opponent_name}}</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 left-clear">
                                    <label for="Client_Funds_on_Deposit_SoleSeparate_Grounds10">Why does this person own this fund solely and separately?</label>
                                    <input id="Client_Funds_on_Deposit_SoleSeparate_Grounds10" type="text" class="form-control 10_Client_fundsondeposit_inputs" name="Client_Funds_on_Deposit_SoleSeparate_Grounds10" value="<?php if(isset($drfundsondeposit->Client_Funds_on_Deposit_SoleSeparate_Grounds10)){ echo $drfundsondeposit->Client_Funds_on_Deposit_SoleSeparate_Grounds10; } ?>"> 
                                </div>
                                <!-- slider tool -->
                                <div class="form-group col-sm-6 m-auto slider-tool-main">
                                    <div class="row">
                                        <div class="col">{{$client_name}}</div>
                                        <div class="col text-right">{{$opponent_name}}</div>
                                    </div>
                                    <input id="10_Client_balance_range_selector" type="range" class="form-control slider-tool-input 10_Client_balance_range_selector" name="" value="<?php if(isset($drfundsondeposit->Client_Funds_on_Deposit_Percent_Marital_Equity_to_Op10)){ echo $drfundsondeposit->Client_Funds_on_Deposit_Percent_Marital_Equity_to_Op10; } ?>" min="0.00" step="0.01" max="100" onchange="updateBalanceInput(this.value, '10', 'Client');">
                                </div>
                                <div class="form-group col-sm-6 m-auto slider-tool-main">
                                    <div class="row justify-content-between">
                                        <div class="col selectorTool">
                                            <div class="left-col">
                                                <div class="client-info 10_Client_clientpercentage_div clientpercentage_div">
                                                    <?php if(isset($drfundsondeposit->Client_Funds_on_Deposit_Percent_Marital_Equity_to_Client10)){ echo $drfundsondeposit->Client_Funds_on_Deposit_Percent_Marital_Equity_to_Client10; } else {
                                                        echo "50.00";
                                                    } ?>%
                                                </div>
                                                <div class="client-info 10_Client_clientamount_div clientamount_div" style="clear: both;">
                                                    $<?php if(isset($drfundsondeposit->Client_Funds_on_Deposit_Estimated_Value_to_Client10)){ echo $drfundsondeposit->Client_Funds_on_Deposit_Estimated_Value_to_Client10; } ?>
                                                </div>
                                            </div>
                                            <label>To {{$client_name}}</label>
                                        </div>                                       
                                        <div class="col selectorTool selectorToolRight">
                                            <label>To {{$opponent_name}}</label>
                                            <div class="left-col right-col">
                                                <div class="client-info 10_Client_opponentpercentage_div opponentpercentage_div">
                                                    <?php if(isset($drfundsondeposit->Client_Funds_on_Deposit_Percent_Marital_Equity_to_Op10)){ echo $drfundsondeposit->Client_Funds_on_Deposit_Percent_Marital_Equity_to_Op10; } else {
                                                        echo "50.00";
                                                    } ?>%
                                                </div>
                                                <div class="client-info 10_Client_opponentamount_div opponentamount_div" style="clear: both;">
                                                    $<?php if(isset($drfundsondeposit->Client_Funds_on_Deposit_Estimated_Value_to_Op10)){ echo $drfundsondeposit->Client_Funds_on_Deposit_Estimated_Value_to_Op10; } ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 m-auto slider-tool-main">
                                    <label></label>
                                    <div class="w-100">
                                        <label><input type="radio" id="10_Client_Funds_on_Deposit_Estimated_Value_Select" name="10_Client_Funds_on_Deposit_Estimated_Value_Select_Reset" class="Funds_on_Deposit_Estimated_Value_Select_Reset" value="Save"> Save this Distribution of Deposit Account #10</label>
                                        <label><input type="radio" id="10_Client_Funds_on_Deposit_Estimated_Value_Reset" name="10_Client_Funds_on_Deposit_Estimated_Value_Select_Reset" class="Funds_on_Deposit_Estimated_Value_Select_Reset" value="Reset" onclick="resetBalanceInput(this, '10', 'Client');"> Reset to Default (50%)</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label>{{$client_name}} Deposite Equity Percent</label>
                                    <input id="Client_Funds_on_Deposit_Percent_Marital_Equity_to_Client10" type="number" class="form-control 10_Client_clientpercentage_input clientpercentage_input" name="Client_Funds_on_Deposit_Percent_Marital_Equity_to_Client10" value="<?php if(isset($drfundsondeposit->Client_Funds_on_Deposit_Percent_Marital_Equity_to_Client10)){ echo $drfundsondeposit->Client_Funds_on_Deposit_Percent_Marital_Equity_to_Client10; } ?>" min="0.00" step="0.01" max="100" readonly="">
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label>{{$client_name}} Deposite Equity Amount</label>
                                    <input id="Client_Funds_on_Deposit_Estimated_Value_to_Client10" type="number" class="form-control 10_Client_clientamount_input clientamount_input" name="Client_Funds_on_Deposit_Estimated_Value_to_Client10" value="<?php if(isset($drfundsondeposit->Client_Funds_on_Deposit_Estimated_Value_to_Client10)){ echo $drfundsondeposit->Client_Funds_on_Deposit_Estimated_Value_to_Client10; } ?>" min="0.00" step="0.01" max="999999.99" readonly="">
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label>{{$opponent_name}} Deposite Equity Percent</label>
                                    <input id="Client_Funds_on_Deposit_Percent_Marital_Equity_to_Op10" type="number" class="form-control 10_Client_opponentpercentage_input opponentpercentage_input" name="Client_Funds_on_Deposit_Percent_Marital_Equity_to_Op10" value="<?php if(isset($drfundsondeposit->Client_Funds_on_Deposit_Percent_Marital_Equity_to_Op10)){ echo $drfundsondeposit->Client_Funds_on_Deposit_Percent_Marital_Equity_to_Op10; } ?>" min="0.00" step="0.01" max="100" readonly="">
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label>{{$opponent_name}} Deposite Equity Amount</label>
                                    <input id="Client_Funds_on_Deposit_Estimated_Value_to_Op10" type="number" class="form-control 10_Client_opponentamount_input opponentamount_input" name="Client_Funds_on_Deposit_Estimated_Value_to_Op10" value="<?php if(isset($drfundsondeposit->Client_Funds_on_Deposit_Estimated_Value_to_Op10)){ echo $drfundsondeposit->Client_Funds_on_Deposit_Estimated_Value_to_Op10; } ?>" min="0.00" step="0.01" max="999999.99" readonly="">
                                </div>
                                <!-- end of slider tool -->
                            </div>

                            
                        </div>
                        <!-- End of Client Funds On Deposit Info Section -->

                        <!-- Opponent Funds On Deposit Info Section -->
                        <div class="form-row num_Op_fundsondeposit_info mt-4" style="display: none;">
                            <h4 class="col-sm-12">{{$opponent_name}} Funds On Deposit Info Section</h4>
                            <div class="col-sm-6">
                                <label for="Num_Op_Deposit_Accounts">How many deposit accounts in {{$opponent_name}}’s name only?</label>
                                <input id="Num_Op_Deposit_Accounts" type="number" class="form-control" name="Num_Op_Deposit_Accounts" value="<?php if(isset($drfundsondeposit->Num_Op_Deposit_Accounts)){ echo $drfundsondeposit->Num_Op_Deposit_Accounts; } ?>" min="0" max="10"> 
                            </div>
                        </div>
                        <div class="form-row Opponent_fundsondeposit_section">
                            <div class="col-sm-12 mt-4 1_Op_fundsondeposit_section" style="display: none;"><h5 class="col-sm-12">First Deposit Account Info</h5>
                                <div class="form-group col-sm-6">
                                    <p class="text-danger 1_Op_no-state-county-found" style="display: none;">No City, State, County found for this zipcode.</p>
                                    <label for="Op_Funds_on_Deposit_Institution_ZIP1">Deposit Institution Zip Code?</label>
                                    <input id="Op_Funds_on_Deposit_Institution_ZIP1" type="text" class="form-control 1_Op_fundsondeposit_inputs" name="Op_Funds_on_Deposit_Institution_ZIP1" value="<?php if(isset($drfundsondeposit->Op_Funds_on_Deposit_Institution_ZIP1)){ echo $drfundsondeposit->Op_Funds_on_Deposit_Institution_ZIP1; } ?>" data-onload="getCityStateForZip(this, '1', 'Op');" onkeyup="getCityStateForZip(this, '1', 'Op');"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Funds_on_Deposit_Institution_Name1">Name of Deposit Institution?</label>
                                    <input id="Op_Funds_on_Deposit_Institution_Name1" type="text" class="form-control 1_Op_fundsondeposit_inputs" name="Op_Funds_on_Deposit_Institution_Name1" value="<?php if(isset($drfundsondeposit->Op_Funds_on_Deposit_Institution_Name1)){ echo $drfundsondeposit->Op_Funds_on_Deposit_Institution_Name1; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Funds_on_Deposit_Institution_Street_Address1">Deposit Institution Street Address?</label>
                                    <input id="Op_Funds_on_Deposit_Institution_Street_Address1" type="text" class="form-control 1_Op_fundsondeposit_inputs" name="Op_Funds_on_Deposit_Institution_Street_Address1" value="<?php if(isset($drfundsondeposit->Op_Funds_on_Deposit_Institution_Street_Address1)){ echo $drfundsondeposit->Op_Funds_on_Deposit_Institution_Street_Address1; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Funds_on_Deposit_Institution_City1">Deposit Institution City?</label>
                                    <input type="hidden" name="" id="Op_Funds_on_Deposit_Institution_City1_Value" value="<?php if(isset($drfundsondeposit->Op_Funds_on_Deposit_Institution_City1)){ echo $drfundsondeposit->Op_Funds_on_Deposit_Institution_City1; } ?>">
                                    <select id="Op_Funds_on_Deposit_Institution_City1" name="Op_Funds_on_Deposit_Institution_City1" class="form-control 1_Op_city_select">
                                        <option value="">Choose City</option>
                                    </select>   
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Funds_on_Deposit_Institution_State1">Deposit Institution State?</label>
                                    <input type="hidden" name="" id="Op_Funds_on_Deposit_Institution_State1_Value" value="<?php if(isset($drfundsondeposit->Op_Funds_on_Deposit_Institution_City1)){ echo $drfundsondeposit->Op_Funds_on_Deposit_Institution_City1; } ?>">
                                    <select id="Op_Funds_on_Deposit_Institution_State1" name="Op_Funds_on_Deposit_Institution_State1" class="form-control 1_Op_state_select">
                                        <option value="">Choose State</option>
                                    </select>   
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Funds_on_Deposit_Institution_Acct_Num1">Account Number?</label>
                                    <input id="Op_Funds_on_Deposit_Institution_Acct_Num1" type="text" class="form-control 1_Op_fundsondeposit_inputs" name="Op_Funds_on_Deposit_Institution_Acct_Num1" value="<?php if(isset($drfundsondeposit->Op_Funds_on_Deposit_Institution_Acct_Num1)){ echo $drfundsondeposit->Op_Funds_on_Deposit_Institution_Acct_Num1; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Name on this account?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Op_Funds_on_Deposit_Institution_Name_on_Acct1_Client" name="Op_Funds_on_Deposit_Institution_Name_on_Acct1" value="{{$client_name}}" <?php if(isset($drfundsondeposit->Op_Funds_on_Deposit_Institution_Name_on_Acct1) && $drfundsondeposit->Op_Funds_on_Deposit_Institution_Name_on_Acct1==$client_name){ echo "checked"; } ?>> {{$client_name}}</label>
                                        <label><input type="radio" id="Op_Funds_on_Deposit_Institution_Name_on_Acct1_Op" name="Op_Funds_on_Deposit_Institution_Name_on_Acct1" value="{{$opponent_name}}" <?php if(isset($drfundsondeposit->Op_Funds_on_Deposit_Institution_Name_on_Acct1) && $drfundsondeposit->Op_Funds_on_Deposit_Institution_Name_on_Acct1==$opponent_name){ echo "checked"; } ?>> {{$opponent_name}}</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Funds_on_Deposit_Institution_Current_Balance1">Current Balance?</label>
                                    <input id="Op_Funds_on_Deposit_Institution_Current_Balance1" type="number" class="form-control 1_Op_fundsondeposit_inputs" name="Op_Funds_on_Deposit_Institution_Current_Balance1" value="<?php if(isset($drfundsondeposit->Op_Funds_on_Deposit_Institution_Current_Balance1)){ echo $drfundsondeposit->Op_Funds_on_Deposit_Institution_Current_Balance1; } ?>" min="0.00" step="0.01" max="999999.99" onchange="getClientOpCurrentBalance(this, '1', 'Op');" onkeyup="getClientOpCurrentBalance(this, '1', 'Op');"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Funds_on_Deposit_Institution_Yearly_Interest_Dividend1">Yearly Interest?</label>
                                    <input id="Op_Funds_on_Deposit_Institution_Yearly_Interest_Dividend1" type="number" class="form-control 1_Op_fundsondeposit_inputs" name="Op_Funds_on_Deposit_Institution_Yearly_Interest_Dividend1" value="<?php if(isset($drfundsondeposit->Op_Funds_on_Deposit_Institution_Yearly_Interest_Dividend1)){ echo $drfundsondeposit->Op_Funds_on_Deposit_Institution_Yearly_Interest_Dividend1; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Funds_on_Deposit_Institution_Balance_Date_of_Marriage1">Balance on marriage date (0.00, if started after marriage)?</label>
                                    <input id="Op_Funds_on_Deposit_Institution_Balance_Date_of_Marriage1" type="number" class="form-control 1_Op_fundsondeposit_inputs" name="Op_Funds_on_Deposit_Institution_Balance_Date_of_Marriage1" value="<?php if(isset($drfundsondeposit->Op_Funds_on_Deposit_Institution_Balance_Date_of_Marriage1)){ echo $drfundsondeposit->Op_Funds_on_Deposit_Institution_Balance_Date_of_Marriage1; } ?>" min="0.00" step="0.01" max="999999.99" onchange="getClientOpCurrentBalance(this, '1', 'Op');" onkeyup="getClientOpCurrentBalance(this, '1', 'Op');"> 
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label for="Op_Funds_on_Deposit_Estimated_MaritalEquity1">N/A, calculated = Op_Funds_on_Deposit_Institution_Current_Balance1 – Op_Funds_on_Deposit_Institution_Balance_Date_of_Marriage1</label>
                                    <input id="Op_Funds_on_Deposit_Estimated_MaritalEquity1" type="number" class="form-control 1_Op_fundsondeposit_inputs" name="Op_Funds_on_Deposit_Estimated_MaritalEquity1" value="<?php if(isset($drfundsondeposit->Op_Funds_on_Deposit_Estimated_MaritalEquity1)){ echo $drfundsondeposit->Op_Funds_on_Deposit_Estimated_MaritalEquity1; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Does either party claim a sole/separate interest from the other on this fund?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Op_Funds_on_Deposit_SoleSeparate_Claim1_Yes" name="Op_Funds_on_Deposit_SoleSeparate_Claim1" value="Yes" <?php if(isset($drfundsondeposit->Op_Funds_on_Deposit_SoleSeparate_Claim1) && $drfundsondeposit->Op_Funds_on_Deposit_SoleSeparate_Claim1=='Yes'){ echo "checked"; } ?>> Yes</label>
                                        <label><input type="radio" id="Op_Funds_on_Deposit_SoleSeparate_Claim1_No" name="Op_Funds_on_Deposit_SoleSeparate_Claim1" value="No" <?php if(isset($drfundsondeposit->Op_Funds_on_Deposit_SoleSeparate_Claim1) && $drfundsondeposit->Op_Funds_on_Deposit_SoleSeparate_Claim1=='No'){ echo "checked"; } ?>> No</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Who claims to own this fund?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Op_Funds_on_Deposit_SoleSeparate_Party1_Client" name="Op_Funds_on_Deposit_SoleSeparate_Party1" value="{{$client_name}}" <?php if(isset($drfundsondeposit->Op_Funds_on_Deposit_SoleSeparate_Party1) && $drfundsondeposit->Op_Funds_on_Deposit_SoleSeparate_Party1==$client_name){ echo "checked"; } ?>> {{$client_name}}</label>
                                        <label><input type="radio" id="Op_Funds_on_Deposit_SoleSeparate_Party1_Op" name="Op_Funds_on_Deposit_SoleSeparate_Party1" value="{{$opponent_name}}" <?php if(isset($drfundsondeposit->Op_Funds_on_Deposit_SoleSeparate_Party1) && $drfundsondeposit->Op_Funds_on_Deposit_SoleSeparate_Party1==$opponent_name){ echo "checked"; } ?>> {{$opponent_name}}</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 left-clear">
                                    <label for="Op_Funds_on_Deposit_SoleSeparate_Grounds1">Why does this person own this fund solely and separately?</label>
                                    <input id="Op_Funds_on_Deposit_SoleSeparate_Grounds1" type="text" class="form-control 1_Op_fundsondeposit_inputs" name="Op_Funds_on_Deposit_SoleSeparate_Grounds1" value="<?php if(isset($drfundsondeposit->Op_Funds_on_Deposit_SoleSeparate_Grounds1)){ echo $drfundsondeposit->Op_Funds_on_Deposit_SoleSeparate_Grounds1; } ?>"> 
                                </div>
                                <!-- slider tool -->
                                <div class="form-group col-sm-6 m-auto slider-tool-main">
                                    <div class="row">
                                        <div class="col">{{$client_name}}</div>
                                        <div class="col text-right">{{$opponent_name}}</div>
                                    </div>
                                    <input id="1_Op_balance_range_selector" type="range" class="form-control slider-tool-input 1_Op_balance_range_selector" name="" value="<?php if(isset($drfundsondeposit->Op_Funds_on_Deposit_Percent_Marital_Equity_to_Op1)){ echo $drfundsondeposit->Op_Funds_on_Deposit_Percent_Marital_Equity_to_Op1; } ?>" min="0.00" step="0.01" max="100" onchange="updateBalanceInput(this.value, '1', 'Op');">
                                </div>
                                <div class="form-group col-sm-6 m-auto slider-tool-main">
                                    <div class="row justify-content-between">
                                        <div class="col selectorTool">
                                            <div class="left-col">
                                                <div class="client-info 1_Op_clientpercentage_div clientpercentage_div">
                                                    <?php if(isset($drfundsondeposit->Op_Funds_on_Deposit_Percent_Marital_Equity_to_Client1)){ echo $drfundsondeposit->Op_Funds_on_Deposit_Percent_Marital_Equity_to_Client1; } else {
                                                        echo "50.00";
                                                    } ?>%
                                                </div>
                                                <div class="client-info 1_Op_clientamount_div clientamount_div" style="clear: both;">
                                                    $<?php if(isset($drfundsondeposit->Op_Funds_on_Deposit_Estimated_Value_to_Client1)){ echo $drfundsondeposit->Op_Funds_on_Deposit_Estimated_Value_to_Client1; } ?>
                                                </div>
                                            </div>
                                            <label>To {{$client_name}}</label>
                                        </div>                                       
                                        <div class="col selectorTool selectorToolRight">
                                            <label>To {{$opponent_name}}</label>
                                            <div class="left-col right-col">
                                                <div class="client-info 1_Op_opponentpercentage_div opponentpercentage_div">
                                                    <?php if(isset($drfundsondeposit->Op_Funds_on_Deposit_Percent_Marital_Equity_to_Op1)){ echo $drfundsondeposit->Op_Funds_on_Deposit_Percent_Marital_Equity_to_Op1; } else {
                                                        echo "50.00";
                                                    } ?>%
                                                </div>
                                                <div class="client-info 1_Op_opponentamount_div opponentamount_div" style="clear: both;">
                                                    $<?php if(isset($drfundsondeposit->Op_Funds_on_Deposit_Estimated_Value_to_Op1)){ echo $drfundsondeposit->Op_Funds_on_Deposit_Estimated_Value_to_Op1; } ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 m-auto slider-tool-main">
                                    <label></label>
                                    <div class="w-100">
                                        <label><input type="radio" id="1_Op_Funds_on_Deposit_Estimated_Value_Select" name="1_Op_Funds_on_Deposit_Estimated_Value_Select_Reset" class="Funds_on_Deposit_Estimated_Value_Select_Reset" value="Save"> Save this Distribution of Deposit Account #1</label>
                                        <label><input type="radio" id="1_Op_Funds_on_Deposit_Estimated_Value_Reset" name="1_Op_Funds_on_Deposit_Estimated_Value_Select_Reset" class="Funds_on_Deposit_Estimated_Value_Select_Reset" value="Reset" onclick="resetBalanceInput(this, '1', 'Op');"> Reset to Default (50%)</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label>{{$client_name}} Deposite Equity Percent</label>
                                    <input id="Op_Funds_on_Deposit_Percent_Marital_Equity_to_Client1" type="number" class="form-control 1_Op_clientpercentage_input clientpercentage_input" name="Op_Funds_on_Deposit_Percent_Marital_Equity_to_Client1" value="<?php if(isset($drfundsondeposit->Op_Funds_on_Deposit_Percent_Marital_Equity_to_Client1)){ echo $drfundsondeposit->Op_Funds_on_Deposit_Percent_Marital_Equity_to_Client1; } ?>" min="0.00" step="0.01" max="100" readonly="">
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label>{{$client_name}} Deposite Equity Amount</label>
                                    <input id="Op_Funds_on_Deposit_Estimated_Value_to_Client1" type="number" class="form-control 1_Op_clientamount_input clientamount_input" name="Op_Funds_on_Deposit_Estimated_Value_to_Client1" value="<?php if(isset($drfundsondeposit->Op_Funds_on_Deposit_Estimated_Value_to_Client1)){ echo $drfundsondeposit->Op_Funds_on_Deposit_Estimated_Value_to_Client1; } ?>" min="0.00" step="0.01" max="999999.99" readonly="">
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label>{{$opponent_name}} Deposite Equity Percent</label>
                                    <input id="Op_Funds_on_Deposit_Percent_Marital_Equity_to_Op1" type="number" class="form-control 1_Op_opponentpercentage_input opponentpercentage_input" name="Op_Funds_on_Deposit_Percent_Marital_Equity_to_Op1" value="<?php if(isset($drfundsondeposit->Op_Funds_on_Deposit_Percent_Marital_Equity_to_Op1)){ echo $drfundsondeposit->Op_Funds_on_Deposit_Percent_Marital_Equity_to_Op1; } ?>" min="0.00" step="0.01" max="100" readonly="">
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label>{{$opponent_name}} Deposite Equity Amount</label>
                                    <input id="Op_Funds_on_Deposit_Estimated_Value_to_Op1" type="number" class="form-control 1_Op_opponentamount_input opponentamount_input" name="Op_Funds_on_Deposit_Estimated_Value_to_Op1" value="<?php if(isset($drfundsondeposit->Op_Funds_on_Deposit_Estimated_Value_to_Op1)){ echo $drfundsondeposit->Op_Funds_on_Deposit_Estimated_Value_to_Op1; } ?>" min="0.00" step="0.01" max="999999.99" readonly="">
                                </div>
                                <!-- end of slider tool -->
                            </div>
                            <div class="col-sm-12 mt-4 2_Op_fundsondeposit_section" style="display: none;"><h5 class="col-sm-12">Second Deposit Account Info</h5>
                                <div class="form-group col-sm-6">
                                    <p class="text-danger 2_Op_no-state-county-found" style="display: none;">No City, State, County found for this zipcode.</p>
                                    <label for="Op_Funds_on_Deposit_Institution_ZIP2">Deposit Institution Zip Code?</label>
                                    <input id="Op_Funds_on_Deposit_Institution_ZIP2" type="text" class="form-control 2_Op_fundsondeposit_inputs" name="Op_Funds_on_Deposit_Institution_ZIP2" value="<?php if(isset($drfundsondeposit->Op_Funds_on_Deposit_Institution_ZIP2)){ echo $drfundsondeposit->Op_Funds_on_Deposit_Institution_ZIP2; } ?>" data-onload="getCityStateForZip(this, '2', 'Op');" onkeyup="getCityStateForZip(this, '2', 'Op');"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Funds_on_Deposit_Institution_Name2">Name of Deposit Institution?</label>
                                    <input id="Op_Funds_on_Deposit_Institution_Name2" type="text" class="form-control 2_Op_fundsondeposit_inputs" name="Op_Funds_on_Deposit_Institution_Name2" value="<?php if(isset($drfundsondeposit->Op_Funds_on_Deposit_Institution_Name2)){ echo $drfundsondeposit->Op_Funds_on_Deposit_Institution_Name2; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Funds_on_Deposit_Institution_Street_Address2">Deposit Institution Street Address?</label>
                                    <input id="Op_Funds_on_Deposit_Institution_Street_Address2" type="text" class="form-control 2_Op_fundsondeposit_inputs" name="Op_Funds_on_Deposit_Institution_Street_Address2" value="<?php if(isset($drfundsondeposit->Op_Funds_on_Deposit_Institution_Street_Address2)){ echo $drfundsondeposit->Op_Funds_on_Deposit_Institution_Street_Address2; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Funds_on_Deposit_Institution_City2">Deposit Institution City?</label>
                                    <input type="hidden" name="" id="Op_Funds_on_Deposit_Institution_City2_Value" value="<?php if(isset($drfundsondeposit->Op_Funds_on_Deposit_Institution_City2)){ echo $drfundsondeposit->Op_Funds_on_Deposit_Institution_City2; } ?>">
                                    <select id="Op_Funds_on_Deposit_Institution_City2" name="Op_Funds_on_Deposit_Institution_City2" class="form-control 2_Op_city_select">
                                        <option value="">Choose City</option>
                                    </select>   
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Funds_on_Deposit_Institution_State2">Deposit Institution State?</label>
                                    <input type="hidden" name="" id="Op_Funds_on_Deposit_Institution_State2_Value" value="<?php if(isset($drfundsondeposit->Op_Funds_on_Deposit_Institution_City2)){ echo $drfundsondeposit->Op_Funds_on_Deposit_Institution_City2; } ?>">
                                    <select id="Op_Funds_on_Deposit_Institution_State2" name="Op_Funds_on_Deposit_Institution_State2" class="form-control 2_Op_state_select">
                                        <option value="">Choose State</option>
                                    </select>   
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Funds_on_Deposit_Institution_Acct_Num2">Account Number?</label>
                                    <input id="Op_Funds_on_Deposit_Institution_Acct_Num2" type="text" class="form-control 2_Op_fundsondeposit_inputs" name="Op_Funds_on_Deposit_Institution_Acct_Num2" value="<?php if(isset($drfundsondeposit->Op_Funds_on_Deposit_Institution_Acct_Num2)){ echo $drfundsondeposit->Op_Funds_on_Deposit_Institution_Acct_Num2; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Name on this account?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Op_Funds_on_Deposit_Institution_Name_on_Acct2_Client" name="Op_Funds_on_Deposit_Institution_Name_on_Acct2" value="{{$client_name}}" <?php if(isset($drfundsondeposit->Op_Funds_on_Deposit_Institution_Name_on_Acct2) && $drfundsondeposit->Op_Funds_on_Deposit_Institution_Name_on_Acct2==$client_name){ echo "checked"; } ?>> {{$client_name}}</label>
                                        <label><input type="radio" id="Op_Funds_on_Deposit_Institution_Name_on_Acct2_Op" name="Op_Funds_on_Deposit_Institution_Name_on_Acct2" value="{{$opponent_name}}" <?php if(isset($drfundsondeposit->Op_Funds_on_Deposit_Institution_Name_on_Acct2) && $drfundsondeposit->Op_Funds_on_Deposit_Institution_Name_on_Acct2==$opponent_name){ echo "checked"; } ?>> {{$opponent_name}}</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Funds_on_Deposit_Institution_Current_Balance2">Current Balance?</label>
                                    <input id="Op_Funds_on_Deposit_Institution_Current_Balance2" type="number" class="form-control 2_Op_fundsondeposit_inputs" name="Op_Funds_on_Deposit_Institution_Current_Balance2" value="<?php if(isset($drfundsondeposit->Op_Funds_on_Deposit_Institution_Current_Balance2)){ echo $drfundsondeposit->Op_Funds_on_Deposit_Institution_Current_Balance2; } ?>" min="0.00" step="0.01" max="999999.99" onchange="getClientOpCurrentBalance(this, '2', 'Op');" onkeyup="getClientOpCurrentBalance(this, '2', 'Op');"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Funds_on_Deposit_Institution_Yearly_Interest_Dividend2">Yearly Interest?</label>
                                    <input id="Op_Funds_on_Deposit_Institution_Yearly_Interest_Dividend2" type="number" class="form-control 2_Op_fundsondeposit_inputs" name="Op_Funds_on_Deposit_Institution_Yearly_Interest_Dividend2" value="<?php if(isset($drfundsondeposit->Op_Funds_on_Deposit_Institution_Yearly_Interest_Dividend2)){ echo $drfundsondeposit->Op_Funds_on_Deposit_Institution_Yearly_Interest_Dividend2; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Funds_on_Deposit_Institution_Balance_Date_of_Marriage2">Balance on marriage date (0.00, if started after marriage)?</label>
                                    <input id="Op_Funds_on_Deposit_Institution_Balance_Date_of_Marriage2" type="number" class="form-control 2_Op_fundsondeposit_inputs" name="Op_Funds_on_Deposit_Institution_Balance_Date_of_Marriage2" value="<?php if(isset($drfundsondeposit->Op_Funds_on_Deposit_Institution_Balance_Date_of_Marriage2)){ echo $drfundsondeposit->Op_Funds_on_Deposit_Institution_Balance_Date_of_Marriage2; } ?>" min="0.00" step="0.01" max="999999.99" onchange="getClientOpCurrentBalance(this, '2', 'Op');" onkeyup="getClientOpCurrentBalance(this, '2', 'Op');"> 
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label for="Op_Funds_on_Deposit_Estimated_MaritalEquity2">N/A, calculated = Op_Funds_on_Deposit_Institution_Current_Balance2 – Op_Funds_on_Deposit_Institution_Balance_Date_of_Marriage2</label>
                                    <input id="Op_Funds_on_Deposit_Estimated_MaritalEquity2" type="number" class="form-control 2_Op_fundsondeposit_inputs" name="Op_Funds_on_Deposit_Estimated_MaritalEquity2" value="<?php if(isset($drfundsondeposit->Op_Funds_on_Deposit_Estimated_MaritalEquity2)){ echo $drfundsondeposit->Op_Funds_on_Deposit_Estimated_MaritalEquity2; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Does either party claim a sole/separate interest from the other on this fund?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Op_Funds_on_Deposit_SoleSeparate_Claim2_Yes" name="Op_Funds_on_Deposit_SoleSeparate_Claim2" value="Yes" <?php if(isset($drfundsondeposit->Op_Funds_on_Deposit_SoleSeparate_Claim2) && $drfundsondeposit->Op_Funds_on_Deposit_SoleSeparate_Claim2=='Yes'){ echo "checked"; } ?>> Yes</label>
                                        <label><input type="radio" id="Op_Funds_on_Deposit_SoleSeparate_Claim2_No" name="Op_Funds_on_Deposit_SoleSeparate_Claim2" value="No" <?php if(isset($drfundsondeposit->Op_Funds_on_Deposit_SoleSeparate_Claim2) && $drfundsondeposit->Op_Funds_on_Deposit_SoleSeparate_Claim2=='No'){ echo "checked"; } ?>> No</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Who claims to own this fund?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Op_Funds_on_Deposit_SoleSeparate_Party2_Client" name="Op_Funds_on_Deposit_SoleSeparate_Party2" value="{{$client_name}}" <?php if(isset($drfundsondeposit->Op_Funds_on_Deposit_SoleSeparate_Party2) && $drfundsondeposit->Op_Funds_on_Deposit_SoleSeparate_Party2==$client_name){ echo "checked"; } ?>> {{$client_name}}</label>
                                        <label><input type="radio" id="Op_Funds_on_Deposit_SoleSeparate_Party2_Op" name="Op_Funds_on_Deposit_SoleSeparate_Party2" value="{{$opponent_name}}" <?php if(isset($drfundsondeposit->Op_Funds_on_Deposit_SoleSeparate_Party2) && $drfundsondeposit->Op_Funds_on_Deposit_SoleSeparate_Party2==$opponent_name){ echo "checked"; } ?>> {{$opponent_name}}</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 left-clear">
                                    <label for="Op_Funds_on_Deposit_SoleSeparate_Grounds2">Why does this person own this fund solely and separately?</label>
                                    <input id="Op_Funds_on_Deposit_SoleSeparate_Grounds2" type="text" class="form-control 2_Op_fundsondeposit_inputs" name="Op_Funds_on_Deposit_SoleSeparate_Grounds2" value="<?php if(isset($drfundsondeposit->Op_Funds_on_Deposit_SoleSeparate_Grounds2)){ echo $drfundsondeposit->Op_Funds_on_Deposit_SoleSeparate_Grounds2; } ?>"> 
                                </div>
                                <!-- slider tool -->
                                <div class="form-group col-sm-6 m-auto slider-tool-main">
                                    <div class="row">
                                        <div class="col">{{$client_name}}</div>
                                        <div class="col text-right">{{$opponent_name}}</div>
                                    </div>
                                    <input id="2_Op_balance_range_selector" type="range" class="form-control slider-tool-input 2_Op_balance_range_selector" name="" value="<?php if(isset($drfundsondeposit->Op_Funds_on_Deposit_Percent_Marital_Equity_to_Op2)){ echo $drfundsondeposit->Op_Funds_on_Deposit_Percent_Marital_Equity_to_Op2; } ?>" min="0.00" step="0.01" max="100" onchange="updateBalanceInput(this.value, '2', 'Op');">
                                </div>
                                <div class="form-group col-sm-6 m-auto slider-tool-main">
                                    <div class="row justify-content-between">
                                        <div class="col selectorTool">
                                            <div class="left-col">
                                                <div class="client-info 2_Op_clientpercentage_div clientpercentage_div">
                                                    <?php if(isset($drfundsondeposit->Op_Funds_on_Deposit_Percent_Marital_Equity_to_Client2)){ echo $drfundsondeposit->Op_Funds_on_Deposit_Percent_Marital_Equity_to_Client2; } else {
                                                        echo "50.00";
                                                    } ?>%
                                                </div>
                                                <div class="client-info 2_Op_clientamount_div clientamount_div" style="clear: both;">
                                                    $<?php if(isset($drfundsondeposit->Op_Funds_on_Deposit_Estimated_Value_to_Client2)){ echo $drfundsondeposit->Op_Funds_on_Deposit_Estimated_Value_to_Client2; } ?>
                                                </div>
                                            </div>
                                            <label>To {{$client_name}}</label>
                                        </div>                                       
                                        <div class="col selectorTool selectorToolRight">
                                            <label>To {{$opponent_name}}</label>
                                            <div class="left-col right-col">
                                                <div class="client-info 2_Op_opponentpercentage_div opponentpercentage_div">
                                                    <?php if(isset($drfundsondeposit->Op_Funds_on_Deposit_Percent_Marital_Equity_to_Op2)){ echo $drfundsondeposit->Op_Funds_on_Deposit_Percent_Marital_Equity_to_Op2; } else {
                                                        echo "50.00";
                                                    } ?>%
                                                </div>
                                                <div class="client-info 2_Op_opponentamount_div opponentamount_div" style="clear: both;">
                                                    $<?php if(isset($drfundsondeposit->Op_Funds_on_Deposit_Estimated_Value_to_Op2)){ echo $drfundsondeposit->Op_Funds_on_Deposit_Estimated_Value_to_Op2; } ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 m-auto slider-tool-main">
                                    <label></label>
                                    <div class="w-100">
                                        <label><input type="radio" id="2_Op_Funds_on_Deposit_Estimated_Value_Select" name="2_Op_Funds_on_Deposit_Estimated_Value_Select_Reset" class="Funds_on_Deposit_Estimated_Value_Select_Reset" value="Save"> Save this Distribution of Deposit Account #2</label>
                                        <label><input type="radio" id="2_Op_Funds_on_Deposit_Estimated_Value_Reset" name="2_Op_Funds_on_Deposit_Estimated_Value_Select_Reset" class="Funds_on_Deposit_Estimated_Value_Select_Reset" value="Reset" onclick="resetBalanceInput(this, '2', 'Op');"> Reset to Default (50%)</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label>{{$client_name}} Deposite Equity Percent</label>
                                    <input id="Op_Funds_on_Deposit_Percent_Marital_Equity_to_Client2" type="number" class="form-control 2_Op_clientpercentage_input clientpercentage_input" name="Op_Funds_on_Deposit_Percent_Marital_Equity_to_Client2" value="<?php if(isset($drfundsondeposit->Op_Funds_on_Deposit_Percent_Marital_Equity_to_Client2)){ echo $drfundsondeposit->Op_Funds_on_Deposit_Percent_Marital_Equity_to_Client2; } ?>" min="0.00" step="0.01" max="100" readonly="">
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label>{{$client_name}} Deposite Equity Amount</label>
                                    <input id="Op_Funds_on_Deposit_Estimated_Value_to_Client2" type="number" class="form-control 2_Op_clientamount_input clientamount_input" name="Op_Funds_on_Deposit_Estimated_Value_to_Client2" value="<?php if(isset($drfundsondeposit->Op_Funds_on_Deposit_Estimated_Value_to_Client2)){ echo $drfundsondeposit->Op_Funds_on_Deposit_Estimated_Value_to_Client2; } ?>" min="0.00" step="0.01" max="999999.99" readonly="">
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label>{{$opponent_name}} Deposite Equity Percent</label>
                                    <input id="Op_Funds_on_Deposit_Percent_Marital_Equity_to_Op2" type="number" class="form-control 2_Op_opponentpercentage_input opponentpercentage_input" name="Op_Funds_on_Deposit_Percent_Marital_Equity_to_Op2" value="<?php if(isset($drfundsondeposit->Op_Funds_on_Deposit_Percent_Marital_Equity_to_Op2)){ echo $drfundsondeposit->Op_Funds_on_Deposit_Percent_Marital_Equity_to_Op2; } ?>" min="0.00" step="0.01" max="100" readonly="">
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label>{{$opponent_name}} Deposite Equity Amount</label>
                                    <input id="Op_Funds_on_Deposit_Estimated_Value_to_Op2" type="number" class="form-control 2_Op_opponentamount_input opponentamount_input" name="Op_Funds_on_Deposit_Estimated_Value_to_Op2" value="<?php if(isset($drfundsondeposit->Op_Funds_on_Deposit_Estimated_Value_to_Op2)){ echo $drfundsondeposit->Op_Funds_on_Deposit_Estimated_Value_to_Op2; } ?>" min="0.00" step="0.01" max="999999.99" readonly="">
                                </div>
                                <!-- end of slider tool -->
                            </div>
                            <div class="col-sm-12 mt-4 3_Op_fundsondeposit_section" style="display: none;"><h5 class="col-sm-12">Third Deposit Account Info</h5>
                                <div class="form-group col-sm-6">
                                    <p class="text-danger 3_Op_no-state-county-found" style="display: none;">No City, State, County found for this zipcode.</p>
                                    <label for="Op_Funds_on_Deposit_Institution_ZIP3">Deposit Institution Zip Code?</label>
                                    <input id="Op_Funds_on_Deposit_Institution_ZIP3" type="text" class="form-control 3_Op_fundsondeposit_inputs" name="Op_Funds_on_Deposit_Institution_ZIP3" value="<?php if(isset($drfundsondeposit->Op_Funds_on_Deposit_Institution_ZIP3)){ echo $drfundsondeposit->Op_Funds_on_Deposit_Institution_ZIP3; } ?>" data-onload="getCityStateForZip(this, '3', 'Op');" onkeyup="getCityStateForZip(this, '3', 'Op');"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Funds_on_Deposit_Institution_Name3">Name of Deposit Institution?</label>
                                    <input id="Op_Funds_on_Deposit_Institution_Name3" type="text" class="form-control 3_Op_fundsondeposit_inputs" name="Op_Funds_on_Deposit_Institution_Name3" value="<?php if(isset($drfundsondeposit->Op_Funds_on_Deposit_Institution_Name3)){ echo $drfundsondeposit->Op_Funds_on_Deposit_Institution_Name3; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Funds_on_Deposit_Institution_Street_Address3">Deposit Institution Street Address?</label>
                                    <input id="Op_Funds_on_Deposit_Institution_Street_Address3" type="text" class="form-control 3_Op_fundsondeposit_inputs" name="Op_Funds_on_Deposit_Institution_Street_Address3" value="<?php if(isset($drfundsondeposit->Op_Funds_on_Deposit_Institution_Street_Address3)){ echo $drfundsondeposit->Op_Funds_on_Deposit_Institution_Street_Address3; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Funds_on_Deposit_Institution_City3">Deposit Institution City?</label>
                                    <input type="hidden" name="" id="Op_Funds_on_Deposit_Institution_City3_Value" value="<?php if(isset($drfundsondeposit->Op_Funds_on_Deposit_Institution_City3)){ echo $drfundsondeposit->Op_Funds_on_Deposit_Institution_City3; } ?>">
                                    <select id="Op_Funds_on_Deposit_Institution_City3" name="Op_Funds_on_Deposit_Institution_City3" class="form-control 3_Op_city_select">
                                        <option value="">Choose City</option>
                                    </select>   
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Funds_on_Deposit_Institution_State3">Deposit Institution State?</label>
                                    <input type="hidden" name="" id="Op_Funds_on_Deposit_Institution_State3_Value" value="<?php if(isset($drfundsondeposit->Op_Funds_on_Deposit_Institution_City3)){ echo $drfundsondeposit->Op_Funds_on_Deposit_Institution_City3; } ?>">
                                    <select id="Op_Funds_on_Deposit_Institution_State3" name="Op_Funds_on_Deposit_Institution_State3" class="form-control 3_Op_state_select">
                                        <option value="">Choose State</option>
                                    </select>   
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Funds_on_Deposit_Institution_Acct_Num3">Account Number?</label>
                                    <input id="Op_Funds_on_Deposit_Institution_Acct_Num3" type="text" class="form-control 3_Op_fundsondeposit_inputs" name="Op_Funds_on_Deposit_Institution_Acct_Num3" value="<?php if(isset($drfundsondeposit->Op_Funds_on_Deposit_Institution_Acct_Num3)){ echo $drfundsondeposit->Op_Funds_on_Deposit_Institution_Acct_Num3; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Name on this account?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Op_Funds_on_Deposit_Institution_Name_on_Acct3_Client" name="Op_Funds_on_Deposit_Institution_Name_on_Acct3" value="{{$client_name}}" <?php if(isset($drfundsondeposit->Op_Funds_on_Deposit_Institution_Name_on_Acct3) && $drfundsondeposit->Op_Funds_on_Deposit_Institution_Name_on_Acct3==$client_name){ echo "checked"; } ?>> {{$client_name}}</label>
                                        <label><input type="radio" id="Op_Funds_on_Deposit_Institution_Name_on_Acct3_Op" name="Op_Funds_on_Deposit_Institution_Name_on_Acct3" value="{{$opponent_name}}" <?php if(isset($drfundsondeposit->Op_Funds_on_Deposit_Institution_Name_on_Acct3) && $drfundsondeposit->Op_Funds_on_Deposit_Institution_Name_on_Acct3==$opponent_name){ echo "checked"; } ?>> {{$opponent_name}}</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Funds_on_Deposit_Institution_Current_Balance3">Current Balance?</label>
                                    <input id="Op_Funds_on_Deposit_Institution_Current_Balance3" type="number" class="form-control 3_Op_fundsondeposit_inputs" name="Op_Funds_on_Deposit_Institution_Current_Balance3" value="<?php if(isset($drfundsondeposit->Op_Funds_on_Deposit_Institution_Current_Balance3)){ echo $drfundsondeposit->Op_Funds_on_Deposit_Institution_Current_Balance3; } ?>" min="0.00" step="0.01" max="999999.99" onchange="getClientOpCurrentBalance(this, '3', 'Op');" onkeyup="getClientOpCurrentBalance(this, '3', 'Op');"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Funds_on_Deposit_Institution_Yearly_Interest_Dividend3">Yearly Interest?</label>
                                    <input id="Op_Funds_on_Deposit_Institution_Yearly_Interest_Dividend3" type="number" class="form-control 3_Op_fundsondeposit_inputs" name="Op_Funds_on_Deposit_Institution_Yearly_Interest_Dividend3" value="<?php if(isset($drfundsondeposit->Op_Funds_on_Deposit_Institution_Yearly_Interest_Dividend3)){ echo $drfundsondeposit->Op_Funds_on_Deposit_Institution_Yearly_Interest_Dividend3; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Funds_on_Deposit_Institution_Balance_Date_of_Marriage3">Balance on marriage date (0.00, if started after marriage)?</label>
                                    <input id="Op_Funds_on_Deposit_Institution_Balance_Date_of_Marriage3" type="number" class="form-control 3_Op_fundsondeposit_inputs" name="Op_Funds_on_Deposit_Institution_Balance_Date_of_Marriage3" value="<?php if(isset($drfundsondeposit->Op_Funds_on_Deposit_Institution_Balance_Date_of_Marriage3)){ echo $drfundsondeposit->Op_Funds_on_Deposit_Institution_Balance_Date_of_Marriage3; } ?>" min="0.00" step="0.01" max="999999.99" onchange="getClientOpCurrentBalance(this, '3', 'Op');" onkeyup="getClientOpCurrentBalance(this, '3', 'Op');"> 
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label for="Op_Funds_on_Deposit_Estimated_MaritalEquity3">N/A, calculated = Op_Funds_on_Deposit_Institution_Current_Balance3 – Op_Funds_on_Deposit_Institution_Balance_Date_of_Marriage3</label>
                                    <input id="Op_Funds_on_Deposit_Estimated_MaritalEquity3" type="number" class="form-control 3_Op_fundsondeposit_inputs" name="Op_Funds_on_Deposit_Estimated_MaritalEquity3" value="<?php if(isset($drfundsondeposit->Op_Funds_on_Deposit_Estimated_MaritalEquity3)){ echo $drfundsondeposit->Op_Funds_on_Deposit_Estimated_MaritalEquity3; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Does either party claim a sole/separate interest from the other on this fund?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Op_Funds_on_Deposit_SoleSeparate_Claim3_Yes" name="Op_Funds_on_Deposit_SoleSeparate_Claim3" value="Yes" <?php if(isset($drfundsondeposit->Op_Funds_on_Deposit_SoleSeparate_Claim3) && $drfundsondeposit->Op_Funds_on_Deposit_SoleSeparate_Claim3=='Yes'){ echo "checked"; } ?>> Yes</label>
                                        <label><input type="radio" id="Op_Funds_on_Deposit_SoleSeparate_Claim3_No" name="Op_Funds_on_Deposit_SoleSeparate_Claim3" value="No" <?php if(isset($drfundsondeposit->Op_Funds_on_Deposit_SoleSeparate_Claim3) && $drfundsondeposit->Op_Funds_on_Deposit_SoleSeparate_Claim3=='No'){ echo "checked"; } ?>> No</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Who claims to own this fund?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Op_Funds_on_Deposit_SoleSeparate_Party3_Client" name="Op_Funds_on_Deposit_SoleSeparate_Party3" value="{{$client_name}}" <?php if(isset($drfundsondeposit->Op_Funds_on_Deposit_SoleSeparate_Party3) && $drfundsondeposit->Op_Funds_on_Deposit_SoleSeparate_Party3==$client_name){ echo "checked"; } ?>> {{$client_name}}</label>
                                        <label><input type="radio" id="Op_Funds_on_Deposit_SoleSeparate_Party3_Op" name="Op_Funds_on_Deposit_SoleSeparate_Party3" value="{{$opponent_name}}" <?php if(isset($drfundsondeposit->Op_Funds_on_Deposit_SoleSeparate_Party3) && $drfundsondeposit->Op_Funds_on_Deposit_SoleSeparate_Party3==$opponent_name){ echo "checked"; } ?>> {{$opponent_name}}</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 left-clear">
                                    <label for="Op_Funds_on_Deposit_SoleSeparate_Grounds3">Why does this person own this fund solely and separately?</label>
                                    <input id="Op_Funds_on_Deposit_SoleSeparate_Grounds3" type="text" class="form-control 3_Op_fundsondeposit_inputs" name="Op_Funds_on_Deposit_SoleSeparate_Grounds3" value="<?php if(isset($drfundsondeposit->Op_Funds_on_Deposit_SoleSeparate_Grounds3)){ echo $drfundsondeposit->Op_Funds_on_Deposit_SoleSeparate_Grounds3; } ?>"> 
                                </div>
                                <!-- slider tool -->
                                <div class="form-group col-sm-6 m-auto slider-tool-main">
                                    <div class="row">
                                        <div class="col">{{$client_name}}</div>
                                        <div class="col text-right">{{$opponent_name}}</div>
                                    </div>
                                    <input id="3_Op_balance_range_selector" type="range" class="form-control slider-tool-input 3_Op_balance_range_selector" name="" value="<?php if(isset($drfundsondeposit->Op_Funds_on_Deposit_Percent_Marital_Equity_to_Op3)){ echo $drfundsondeposit->Op_Funds_on_Deposit_Percent_Marital_Equity_to_Op3; } ?>" min="0.00" step="0.01" max="100" onchange="updateBalanceInput(this.value, '3', 'Op');">
                                </div>
                                <div class="form-group col-sm-6 m-auto slider-tool-main">
                                    <div class="row justify-content-between">
                                        <div class="col selectorTool">
                                            <div class="left-col">
                                                <div class="client-info 3_Op_clientpercentage_div clientpercentage_div">
                                                    <?php if(isset($drfundsondeposit->Op_Funds_on_Deposit_Percent_Marital_Equity_to_Client3)){ echo $drfundsondeposit->Op_Funds_on_Deposit_Percent_Marital_Equity_to_Client3; } else {
                                                        echo "50.00";
                                                    } ?>%
                                                </div>
                                                <div class="client-info 3_Op_clientamount_div clientamount_div" style="clear: both;">
                                                    $<?php if(isset($drfundsondeposit->Op_Funds_on_Deposit_Estimated_Value_to_Client3)){ echo $drfundsondeposit->Op_Funds_on_Deposit_Estimated_Value_to_Client3; } ?>
                                                </div>
                                            </div>
                                            <label>To {{$client_name}}</label>
                                        </div>                                       
                                        <div class="col selectorTool selectorToolRight">
                                            <label>To {{$opponent_name}}</label>
                                            <div class="left-col right-col">
                                                <div class="client-info 3_Op_opponentpercentage_div opponentpercentage_div">
                                                    <?php if(isset($drfundsondeposit->Op_Funds_on_Deposit_Percent_Marital_Equity_to_Op3)){ echo $drfundsondeposit->Op_Funds_on_Deposit_Percent_Marital_Equity_to_Op3; } else {
                                                        echo "50.00";
                                                    } ?>%
                                                </div>
                                                <div class="client-info 3_Op_opponentamount_div opponentamount_div" style="clear: both;">
                                                    $<?php if(isset($drfundsondeposit->Op_Funds_on_Deposit_Estimated_Value_to_Op3)){ echo $drfundsondeposit->Op_Funds_on_Deposit_Estimated_Value_to_Op3; } ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 m-auto slider-tool-main">
                                    <label></label>
                                    <div class="w-100">
                                        <label><input type="radio" id="3_Op_Funds_on_Deposit_Estimated_Value_Select" name="3_Op_Funds_on_Deposit_Estimated_Value_Select_Reset" class="Funds_on_Deposit_Estimated_Value_Select_Reset" value="Save"> Save this Distribution of Deposit Account #3</label>
                                        <label><input type="radio" id="3_Op_Funds_on_Deposit_Estimated_Value_Reset" name="3_Op_Funds_on_Deposit_Estimated_Value_Select_Reset" class="Funds_on_Deposit_Estimated_Value_Select_Reset" value="Reset" onclick="resetBalanceInput(this, '3', 'Op');"> Reset to Default (50%)</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label>{{$client_name}} Deposite Equity Percent</label>
                                    <input id="Op_Funds_on_Deposit_Percent_Marital_Equity_to_Client3" type="number" class="form-control 3_Op_clientpercentage_input clientpercentage_input" name="Op_Funds_on_Deposit_Percent_Marital_Equity_to_Client3" value="<?php if(isset($drfundsondeposit->Op_Funds_on_Deposit_Percent_Marital_Equity_to_Client3)){ echo $drfundsondeposit->Op_Funds_on_Deposit_Percent_Marital_Equity_to_Client3; } ?>" min="0.00" step="0.01" max="100" readonly="">
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label>{{$client_name}} Deposite Equity Amount</label>
                                    <input id="Op_Funds_on_Deposit_Estimated_Value_to_Client3" type="number" class="form-control 3_Op_clientamount_input clientamount_input" name="Op_Funds_on_Deposit_Estimated_Value_to_Client3" value="<?php if(isset($drfundsondeposit->Op_Funds_on_Deposit_Estimated_Value_to_Client3)){ echo $drfundsondeposit->Op_Funds_on_Deposit_Estimated_Value_to_Client3; } ?>" min="0.00" step="0.01" max="999999.99" readonly="">
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label>{{$opponent_name}} Deposite Equity Percent</label>
                                    <input id="Op_Funds_on_Deposit_Percent_Marital_Equity_to_Op3" type="number" class="form-control 3_Op_opponentpercentage_input opponentpercentage_input" name="Op_Funds_on_Deposit_Percent_Marital_Equity_to_Op3" value="<?php if(isset($drfundsondeposit->Op_Funds_on_Deposit_Percent_Marital_Equity_to_Op3)){ echo $drfundsondeposit->Op_Funds_on_Deposit_Percent_Marital_Equity_to_Op3; } ?>" min="0.00" step="0.01" max="100" readonly="">
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label>{{$opponent_name}} Deposite Equity Amount</label>
                                    <input id="Op_Funds_on_Deposit_Estimated_Value_to_Op3" type="number" class="form-control 3_Op_opponentamount_input opponentamount_input" name="Op_Funds_on_Deposit_Estimated_Value_to_Op3" value="<?php if(isset($drfundsondeposit->Op_Funds_on_Deposit_Estimated_Value_to_Op3)){ echo $drfundsondeposit->Op_Funds_on_Deposit_Estimated_Value_to_Op3; } ?>" min="0.00" step="0.01" max="999999.99" readonly="">
                                </div>
                                <!-- end of slider tool -->
                            </div>
                            <div class="col-sm-12 mt-4 4_Op_fundsondeposit_section" style="display: none;"><h5 class="col-sm-12">Fourth Deposit Account Info</h5>
                                <div class="form-group col-sm-6">
                                    <p class="text-danger 4_Op_no-state-county-found" style="display: none;">No City, State, County found for this zipcode.</p>
                                    <label for="Op_Funds_on_Deposit_Institution_ZIP4">Deposit Institution Zip Code?</label>
                                    <input id="Op_Funds_on_Deposit_Institution_ZIP4" type="text" class="form-control 4_Op_fundsondeposit_inputs" name="Op_Funds_on_Deposit_Institution_ZIP4" value="<?php if(isset($drfundsondeposit->Op_Funds_on_Deposit_Institution_ZIP4)){ echo $drfundsondeposit->Op_Funds_on_Deposit_Institution_ZIP4; } ?>" data-onload="getCityStateForZip(this, '4', 'Op');" onkeyup="getCityStateForZip(this, '4', 'Op');"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Funds_on_Deposit_Institution_Name4">Name of Deposit Institution?</label>
                                    <input id="Op_Funds_on_Deposit_Institution_Name4" type="text" class="form-control 4_Op_fundsondeposit_inputs" name="Op_Funds_on_Deposit_Institution_Name4" value="<?php if(isset($drfundsondeposit->Op_Funds_on_Deposit_Institution_Name4)){ echo $drfundsondeposit->Op_Funds_on_Deposit_Institution_Name4; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Funds_on_Deposit_Institution_Street_Address4">Deposit Institution Street Address?</label>
                                    <input id="Op_Funds_on_Deposit_Institution_Street_Address4" type="text" class="form-control 4_Op_fundsondeposit_inputs" name="Op_Funds_on_Deposit_Institution_Street_Address4" value="<?php if(isset($drfundsondeposit->Op_Funds_on_Deposit_Institution_Street_Address4)){ echo $drfundsondeposit->Op_Funds_on_Deposit_Institution_Street_Address4; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Funds_on_Deposit_Institution_City4">Deposit Institution City?</label>
                                    <input type="hidden" name="" id="Op_Funds_on_Deposit_Institution_City4_Value" value="<?php if(isset($drfundsondeposit->Op_Funds_on_Deposit_Institution_City4)){ echo $drfundsondeposit->Op_Funds_on_Deposit_Institution_City4; } ?>">
                                    <select id="Op_Funds_on_Deposit_Institution_City4" name="Op_Funds_on_Deposit_Institution_City4" class="form-control 4_Op_city_select">
                                        <option value="">Choose City</option>
                                    </select>   
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Funds_on_Deposit_Institution_State4">Deposit Institution State?</label>
                                    <input type="hidden" name="" id="Op_Funds_on_Deposit_Institution_State4_Value" value="<?php if(isset($drfundsondeposit->Op_Funds_on_Deposit_Institution_City4)){ echo $drfundsondeposit->Op_Funds_on_Deposit_Institution_City4; } ?>">
                                    <select id="Op_Funds_on_Deposit_Institution_State4" name="Op_Funds_on_Deposit_Institution_State4" class="form-control 4_Op_state_select">
                                        <option value="">Choose State</option>
                                    </select>   
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Funds_on_Deposit_Institution_Acct_Num4">Account Number?</label>
                                    <input id="Op_Funds_on_Deposit_Institution_Acct_Num4" type="text" class="form-control 4_Op_fundsondeposit_inputs" name="Op_Funds_on_Deposit_Institution_Acct_Num4" value="<?php if(isset($drfundsondeposit->Op_Funds_on_Deposit_Institution_Acct_Num4)){ echo $drfundsondeposit->Op_Funds_on_Deposit_Institution_Acct_Num4; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Name on this account?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Op_Funds_on_Deposit_Institution_Name_on_Acct4_Client" name="Op_Funds_on_Deposit_Institution_Name_on_Acct4" value="{{$client_name}}" <?php if(isset($drfundsondeposit->Op_Funds_on_Deposit_Institution_Name_on_Acct4) && $drfundsondeposit->Op_Funds_on_Deposit_Institution_Name_on_Acct4==$client_name){ echo "checked"; } ?>> {{$client_name}}</label>
                                        <label><input type="radio" id="Op_Funds_on_Deposit_Institution_Name_on_Acct4_Op" name="Op_Funds_on_Deposit_Institution_Name_on_Acct4" value="{{$opponent_name}}" <?php if(isset($drfundsondeposit->Op_Funds_on_Deposit_Institution_Name_on_Acct4) && $drfundsondeposit->Op_Funds_on_Deposit_Institution_Name_on_Acct4==$opponent_name){ echo "checked"; } ?>> {{$opponent_name}}</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Funds_on_Deposit_Institution_Current_Balance4">Current Balance?</label>
                                    <input id="Op_Funds_on_Deposit_Institution_Current_Balance4" type="number" class="form-control 4_Op_fundsondeposit_inputs" name="Op_Funds_on_Deposit_Institution_Current_Balance4" value="<?php if(isset($drfundsondeposit->Op_Funds_on_Deposit_Institution_Current_Balance4)){ echo $drfundsondeposit->Op_Funds_on_Deposit_Institution_Current_Balance4; } ?>" min="0.00" step="0.01" max="999999.99" onchange="getClientOpCurrentBalance(this, '4', 'Op');" onkeyup="getClientOpCurrentBalance(this, '4', 'Op');"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Funds_on_Deposit_Institution_Yearly_Interest_Dividend4">Yearly Interest?</label>
                                    <input id="Op_Funds_on_Deposit_Institution_Yearly_Interest_Dividend4" type="number" class="form-control 4_Op_fundsondeposit_inputs" name="Op_Funds_on_Deposit_Institution_Yearly_Interest_Dividend4" value="<?php if(isset($drfundsondeposit->Op_Funds_on_Deposit_Institution_Yearly_Interest_Dividend4)){ echo $drfundsondeposit->Op_Funds_on_Deposit_Institution_Yearly_Interest_Dividend4; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Funds_on_Deposit_Institution_Balance_Date_of_Marriage4">Balance on marriage date (0.00, if started after marriage)?</label>
                                    <input id="Op_Funds_on_Deposit_Institution_Balance_Date_of_Marriage4" type="number" class="form-control 4_Op_fundsondeposit_inputs" name="Op_Funds_on_Deposit_Institution_Balance_Date_of_Marriage4" value="<?php if(isset($drfundsondeposit->Op_Funds_on_Deposit_Institution_Balance_Date_of_Marriage4)){ echo $drfundsondeposit->Op_Funds_on_Deposit_Institution_Balance_Date_of_Marriage4; } ?>" min="0.00" step="0.01" max="999999.99" onchange="getClientOpCurrentBalance(this, '4', 'Op');" onkeyup="getClientOpCurrentBalance(this, '4', 'Op');"> 
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label for="Op_Funds_on_Deposit_Estimated_MaritalEquity4">N/A, calculated = Op_Funds_on_Deposit_Institution_Current_Balance4 – Op_Funds_on_Deposit_Institution_Balance_Date_of_Marriage4</label>
                                    <input id="Op_Funds_on_Deposit_Estimated_MaritalEquity4" type="number" class="form-control 4_Op_fundsondeposit_inputs" name="Op_Funds_on_Deposit_Estimated_MaritalEquity4" value="<?php if(isset($drfundsondeposit->Op_Funds_on_Deposit_Estimated_MaritalEquity4)){ echo $drfundsondeposit->Op_Funds_on_Deposit_Estimated_MaritalEquity4; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Does either party claim a sole/separate interest from the other on this fund?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Op_Funds_on_Deposit_SoleSeparate_Claim4_Yes" name="Op_Funds_on_Deposit_SoleSeparate_Claim4" value="Yes" <?php if(isset($drfundsondeposit->Op_Funds_on_Deposit_SoleSeparate_Claim4) && $drfundsondeposit->Op_Funds_on_Deposit_SoleSeparate_Claim4=='Yes'){ echo "checked"; } ?>> Yes</label>
                                        <label><input type="radio" id="Op_Funds_on_Deposit_SoleSeparate_Claim4_No" name="Op_Funds_on_Deposit_SoleSeparate_Claim4" value="No" <?php if(isset($drfundsondeposit->Op_Funds_on_Deposit_SoleSeparate_Claim4) && $drfundsondeposit->Op_Funds_on_Deposit_SoleSeparate_Claim4=='No'){ echo "checked"; } ?>> No</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Who claims to own this fund?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Op_Funds_on_Deposit_SoleSeparate_Party4_Client" name="Op_Funds_on_Deposit_SoleSeparate_Party4" value="{{$client_name}}" <?php if(isset($drfundsondeposit->Op_Funds_on_Deposit_SoleSeparate_Party4) && $drfundsondeposit->Op_Funds_on_Deposit_SoleSeparate_Party4==$client_name){ echo "checked"; } ?>> {{$client_name}}</label>
                                        <label><input type="radio" id="Op_Funds_on_Deposit_SoleSeparate_Party4_Op" name="Op_Funds_on_Deposit_SoleSeparate_Party4" value="{{$opponent_name}}" <?php if(isset($drfundsondeposit->Op_Funds_on_Deposit_SoleSeparate_Party4) && $drfundsondeposit->Op_Funds_on_Deposit_SoleSeparate_Party4==$opponent_name){ echo "checked"; } ?>> {{$opponent_name}}</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 left-clear">
                                    <label for="Op_Funds_on_Deposit_SoleSeparate_Grounds4">Why does this person own this fund solely and separately?</label>
                                    <input id="Op_Funds_on_Deposit_SoleSeparate_Grounds4" type="text" class="form-control 4_Op_fundsondeposit_inputs" name="Op_Funds_on_Deposit_SoleSeparate_Grounds4" value="<?php if(isset($drfundsondeposit->Op_Funds_on_Deposit_SoleSeparate_Grounds4)){ echo $drfundsondeposit->Op_Funds_on_Deposit_SoleSeparate_Grounds4; } ?>"> 
                                </div>
                                <!-- slider tool -->
                                <div class="form-group col-sm-6 m-auto slider-tool-main">
                                    <div class="row">
                                        <div class="col">{{$client_name}}</div>
                                        <div class="col text-right">{{$opponent_name}}</div>
                                    </div>
                                    <input id="4_Op_balance_range_selector" type="range" class="form-control slider-tool-input 4_Op_balance_range_selector" name="" value="<?php if(isset($drfundsondeposit->Op_Funds_on_Deposit_Percent_Marital_Equity_to_Op4)){ echo $drfundsondeposit->Op_Funds_on_Deposit_Percent_Marital_Equity_to_Op4; } ?>" min="0.00" step="0.01" max="100" onchange="updateBalanceInput(this.value, '4', 'Op');">
                                </div>
                                <div class="form-group col-sm-6 m-auto slider-tool-main">
                                    <div class="row justify-content-between">
                                        <div class="col selectorTool">
                                            <div class="left-col">
                                                <div class="client-info 4_Op_clientpercentage_div clientpercentage_div">
                                                    <?php if(isset($drfundsondeposit->Op_Funds_on_Deposit_Percent_Marital_Equity_to_Client4)){ echo $drfundsondeposit->Op_Funds_on_Deposit_Percent_Marital_Equity_to_Client4; } else {
                                                        echo "50.00";
                                                    } ?>%
                                                </div>
                                                <div class="client-info 4_Op_clientamount_div clientamount_div" style="clear: both;">
                                                    $<?php if(isset($drfundsondeposit->Op_Funds_on_Deposit_Estimated_Value_to_Client4)){ echo $drfundsondeposit->Op_Funds_on_Deposit_Estimated_Value_to_Client4; } ?>
                                                </div>
                                            </div>
                                            <label>To {{$client_name}}</label>
                                        </div>                                       
                                        <div class="col selectorTool selectorToolRight">
                                            <label>To {{$opponent_name}}</label>
                                            <div class="left-col right-col">
                                                <div class="client-info 4_Op_opponentpercentage_div opponentpercentage_div">
                                                    <?php if(isset($drfundsondeposit->Op_Funds_on_Deposit_Percent_Marital_Equity_to_Op4)){ echo $drfundsondeposit->Op_Funds_on_Deposit_Percent_Marital_Equity_to_Op4; } else {
                                                        echo "50.00";
                                                    } ?>%
                                                </div>
                                                <div class="client-info 4_Op_opponentamount_div opponentamount_div" style="clear: both;">
                                                    $<?php if(isset($drfundsondeposit->Op_Funds_on_Deposit_Estimated_Value_to_Op4)){ echo $drfundsondeposit->Op_Funds_on_Deposit_Estimated_Value_to_Op4; } ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 m-auto slider-tool-main">
                                    <label></label>
                                    <div class="w-100">
                                        <label><input type="radio" id="4_Op_Funds_on_Deposit_Estimated_Value_Select" name="4_Op_Funds_on_Deposit_Estimated_Value_Select_Reset" class="Funds_on_Deposit_Estimated_Value_Select_Reset" value="Save"> Save this Distribution of Deposit Account #4</label>
                                        <label><input type="radio" id="4_Op_Funds_on_Deposit_Estimated_Value_Reset" name="4_Op_Funds_on_Deposit_Estimated_Value_Select_Reset" class="Funds_on_Deposit_Estimated_Value_Select_Reset" value="Reset" onclick="resetBalanceInput(this, '4', 'Op');"> Reset to Default (50%)</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label>{{$client_name}} Deposite Equity Percent</label>
                                    <input id="Op_Funds_on_Deposit_Percent_Marital_Equity_to_Client4" type="number" class="form-control 4_Op_clientpercentage_input clientpercentage_input" name="Op_Funds_on_Deposit_Percent_Marital_Equity_to_Client4" value="<?php if(isset($drfundsondeposit->Op_Funds_on_Deposit_Percent_Marital_Equity_to_Client4)){ echo $drfundsondeposit->Op_Funds_on_Deposit_Percent_Marital_Equity_to_Client4; } ?>" min="0.00" step="0.01" max="100" readonly="">
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label>{{$client_name}} Deposite Equity Amount</label>
                                    <input id="Op_Funds_on_Deposit_Estimated_Value_to_Client4" type="number" class="form-control 4_Op_clientamount_input clientamount_input" name="Op_Funds_on_Deposit_Estimated_Value_to_Client4" value="<?php if(isset($drfundsondeposit->Op_Funds_on_Deposit_Estimated_Value_to_Client4)){ echo $drfundsondeposit->Op_Funds_on_Deposit_Estimated_Value_to_Client4; } ?>" min="0.00" step="0.01" max="999999.99" readonly="">
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label>{{$opponent_name}} Deposite Equity Percent</label>
                                    <input id="Op_Funds_on_Deposit_Percent_Marital_Equity_to_Op4" type="number" class="form-control 4_Op_opponentpercentage_input opponentpercentage_input" name="Op_Funds_on_Deposit_Percent_Marital_Equity_to_Op4" value="<?php if(isset($drfundsondeposit->Op_Funds_on_Deposit_Percent_Marital_Equity_to_Op4)){ echo $drfundsondeposit->Op_Funds_on_Deposit_Percent_Marital_Equity_to_Op4; } ?>" min="0.00" step="0.01" max="100" readonly="">
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label>{{$opponent_name}} Deposite Equity Amount</label>
                                    <input id="Op_Funds_on_Deposit_Estimated_Value_to_Op4" type="number" class="form-control 4_Op_opponentamount_input opponentamount_input" name="Op_Funds_on_Deposit_Estimated_Value_to_Op4" value="<?php if(isset($drfundsondeposit->Op_Funds_on_Deposit_Estimated_Value_to_Op4)){ echo $drfundsondeposit->Op_Funds_on_Deposit_Estimated_Value_to_Op4; } ?>" min="0.00" step="0.01" max="999999.99" readonly="">
                                </div>
                                <!-- end of slider tool -->
                            </div>
                            <div class="col-sm-12 mt-4 5_Op_fundsondeposit_section" style="display: none;"><h5 class="col-sm-12">Fifth Deposit Account Info</h5>
                                <div class="form-group col-sm-6">
                                    <p class="text-danger 5_Op_no-state-county-found" style="display: none;">No City, State, County found for this zipcode.</p>
                                    <label for="Op_Funds_on_Deposit_Institution_ZIP5">Deposit Institution Zip Code?</label>
                                    <input id="Op_Funds_on_Deposit_Institution_ZIP5" type="text" class="form-control 5_Op_fundsondeposit_inputs" name="Op_Funds_on_Deposit_Institution_ZIP5" value="<?php if(isset($drfundsondeposit->Op_Funds_on_Deposit_Institution_ZIP5)){ echo $drfundsondeposit->Op_Funds_on_Deposit_Institution_ZIP5; } ?>" data-onload="getCityStateForZip(this, '5', 'Op');" onkeyup="getCityStateForZip(this, '5', 'Op');"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Funds_on_Deposit_Institution_Name5">Name of Deposit Institution?</label>
                                    <input id="Op_Funds_on_Deposit_Institution_Name5" type="text" class="form-control 5_Op_fundsondeposit_inputs" name="Op_Funds_on_Deposit_Institution_Name5" value="<?php if(isset($drfundsondeposit->Op_Funds_on_Deposit_Institution_Name5)){ echo $drfundsondeposit->Op_Funds_on_Deposit_Institution_Name5; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Funds_on_Deposit_Institution_Street_Address5">Deposit Institution Street Address?</label>
                                    <input id="Op_Funds_on_Deposit_Institution_Street_Address5" type="text" class="form-control 5_Op_fundsondeposit_inputs" name="Op_Funds_on_Deposit_Institution_Street_Address5" value="<?php if(isset($drfundsondeposit->Op_Funds_on_Deposit_Institution_Street_Address5)){ echo $drfundsondeposit->Op_Funds_on_Deposit_Institution_Street_Address5; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Funds_on_Deposit_Institution_City5">Deposit Institution City?</label>
                                    <input type="hidden" name="" id="Op_Funds_on_Deposit_Institution_City5_Value" value="<?php if(isset($drfundsondeposit->Op_Funds_on_Deposit_Institution_City5)){ echo $drfundsondeposit->Op_Funds_on_Deposit_Institution_City5; } ?>">
                                    <select id="Op_Funds_on_Deposit_Institution_City5" name="Op_Funds_on_Deposit_Institution_City5" class="form-control 5_Op_city_select">
                                        <option value="">Choose City</option>
                                    </select>   
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Funds_on_Deposit_Institution_State5">Deposit Institution State?</label>
                                    <input type="hidden" name="" id="Op_Funds_on_Deposit_Institution_State5_Value" value="<?php if(isset($drfundsondeposit->Op_Funds_on_Deposit_Institution_City5)){ echo $drfundsondeposit->Op_Funds_on_Deposit_Institution_City5; } ?>">
                                    <select id="Op_Funds_on_Deposit_Institution_State5" name="Op_Funds_on_Deposit_Institution_State5" class="form-control 5_Op_state_select">
                                        <option value="">Choose State</option>
                                    </select>   
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Funds_on_Deposit_Institution_Acct_Num5">Account Number?</label>
                                    <input id="Op_Funds_on_Deposit_Institution_Acct_Num5" type="text" class="form-control 5_Op_fundsondeposit_inputs" name="Op_Funds_on_Deposit_Institution_Acct_Num5" value="<?php if(isset($drfundsondeposit->Op_Funds_on_Deposit_Institution_Acct_Num5)){ echo $drfundsondeposit->Op_Funds_on_Deposit_Institution_Acct_Num5; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Name on this account?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Op_Funds_on_Deposit_Institution_Name_on_Acct5_Client" name="Op_Funds_on_Deposit_Institution_Name_on_Acct5" value="{{$client_name}}" <?php if(isset($drfundsondeposit->Op_Funds_on_Deposit_Institution_Name_on_Acct5) && $drfundsondeposit->Op_Funds_on_Deposit_Institution_Name_on_Acct5==$client_name){ echo "checked"; } ?>> {{$client_name}}</label>
                                        <label><input type="radio" id="Op_Funds_on_Deposit_Institution_Name_on_Acct5_Op" name="Op_Funds_on_Deposit_Institution_Name_on_Acct5" value="{{$opponent_name}}" <?php if(isset($drfundsondeposit->Op_Funds_on_Deposit_Institution_Name_on_Acct5) && $drfundsondeposit->Op_Funds_on_Deposit_Institution_Name_on_Acct5==$opponent_name){ echo "checked"; } ?>> {{$opponent_name}}</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Funds_on_Deposit_Institution_Current_Balance5">Current Balance?</label>
                                    <input id="Op_Funds_on_Deposit_Institution_Current_Balance5" type="number" class="form-control 5_Op_fundsondeposit_inputs" name="Op_Funds_on_Deposit_Institution_Current_Balance5" value="<?php if(isset($drfundsondeposit->Op_Funds_on_Deposit_Institution_Current_Balance5)){ echo $drfundsondeposit->Op_Funds_on_Deposit_Institution_Current_Balance5; } ?>" min="0.00" step="0.01" max="999999.99" onchange="getClientOpCurrentBalance(this, '5', 'Op');" onkeyup="getClientOpCurrentBalance(this, '5', 'Op');"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Funds_on_Deposit_Institution_Yearly_Interest_Dividend5">Yearly Interest?</label>
                                    <input id="Op_Funds_on_Deposit_Institution_Yearly_Interest_Dividend5" type="number" class="form-control 5_Op_fundsondeposit_inputs" name="Op_Funds_on_Deposit_Institution_Yearly_Interest_Dividend5" value="<?php if(isset($drfundsondeposit->Op_Funds_on_Deposit_Institution_Yearly_Interest_Dividend5)){ echo $drfundsondeposit->Op_Funds_on_Deposit_Institution_Yearly_Interest_Dividend5; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Funds_on_Deposit_Institution_Balance_Date_of_Marriage5">Balance on marriage date (0.00, if started after marriage)?</label>
                                    <input id="Op_Funds_on_Deposit_Institution_Balance_Date_of_Marriage5" type="number" class="form-control 5_Op_fundsondeposit_inputs" name="Op_Funds_on_Deposit_Institution_Balance_Date_of_Marriage5" value="<?php if(isset($drfundsondeposit->Op_Funds_on_Deposit_Institution_Balance_Date_of_Marriage5)){ echo $drfundsondeposit->Op_Funds_on_Deposit_Institution_Balance_Date_of_Marriage5; } ?>" min="0.00" step="0.01" max="999999.99" onchange="getClientOpCurrentBalance(this, '5', 'Op');" onkeyup="getClientOpCurrentBalance(this, '5', 'Op');"> 
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label for="Op_Funds_on_Deposit_Estimated_MaritalEquity5">N/A, calculated = Op_Funds_on_Deposit_Institution_Current_Balance5 – Op_Funds_on_Deposit_Institution_Balance_Date_of_Marriage5</label>
                                    <input id="Op_Funds_on_Deposit_Estimated_MaritalEquity5" type="number" class="form-control 5_Op_fundsondeposit_inputs" name="Op_Funds_on_Deposit_Estimated_MaritalEquity5" value="<?php if(isset($drfundsondeposit->Op_Funds_on_Deposit_Estimated_MaritalEquity5)){ echo $drfundsondeposit->Op_Funds_on_Deposit_Estimated_MaritalEquity5; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Does either party claim a sole/separate interest from the other on this fund?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Op_Funds_on_Deposit_SoleSeparate_Claim5_Yes" name="Op_Funds_on_Deposit_SoleSeparate_Claim5" value="Yes" <?php if(isset($drfundsondeposit->Op_Funds_on_Deposit_SoleSeparate_Claim5) && $drfundsondeposit->Op_Funds_on_Deposit_SoleSeparate_Claim5=='Yes'){ echo "checked"; } ?>> Yes</label>
                                        <label><input type="radio" id="Op_Funds_on_Deposit_SoleSeparate_Claim5_No" name="Op_Funds_on_Deposit_SoleSeparate_Claim5" value="No" <?php if(isset($drfundsondeposit->Op_Funds_on_Deposit_SoleSeparate_Claim5) && $drfundsondeposit->Op_Funds_on_Deposit_SoleSeparate_Claim5=='No'){ echo "checked"; } ?>> No</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Who claims to own this fund?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Op_Funds_on_Deposit_SoleSeparate_Party5_Client" name="Op_Funds_on_Deposit_SoleSeparate_Party5" value="{{$client_name}}" <?php if(isset($drfundsondeposit->Op_Funds_on_Deposit_SoleSeparate_Party5) && $drfundsondeposit->Op_Funds_on_Deposit_SoleSeparate_Party5==$client_name){ echo "checked"; } ?>> {{$client_name}}</label>
                                        <label><input type="radio" id="Op_Funds_on_Deposit_SoleSeparate_Party5_Op" name="Op_Funds_on_Deposit_SoleSeparate_Party5" value="{{$opponent_name}}" <?php if(isset($drfundsondeposit->Op_Funds_on_Deposit_SoleSeparate_Party5) && $drfundsondeposit->Op_Funds_on_Deposit_SoleSeparate_Party5==$opponent_name){ echo "checked"; } ?>> {{$opponent_name}}</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 left-clear">
                                    <label for="Op_Funds_on_Deposit_SoleSeparate_Grounds5">Why does this person own this fund solely and separately?</label>
                                    <input id="Op_Funds_on_Deposit_SoleSeparate_Grounds5" type="text" class="form-control 5_Op_fundsondeposit_inputs" name="Op_Funds_on_Deposit_SoleSeparate_Grounds5" value="<?php if(isset($drfundsondeposit->Op_Funds_on_Deposit_SoleSeparate_Grounds5)){ echo $drfundsondeposit->Op_Funds_on_Deposit_SoleSeparate_Grounds5; } ?>"> 
                                </div>
                                <!-- slider tool -->
                                <div class="form-group col-sm-6 m-auto slider-tool-main">
                                    <div class="row">
                                        <div class="col">{{$client_name}}</div>
                                        <div class="col text-right">{{$opponent_name}}</div>
                                    </div>
                                    <input id="5_Op_balance_range_selector" type="range" class="form-control slider-tool-input 5_Op_balance_range_selector" name="" value="<?php if(isset($drfundsondeposit->Op_Funds_on_Deposit_Percent_Marital_Equity_to_Op5)){ echo $drfundsondeposit->Op_Funds_on_Deposit_Percent_Marital_Equity_to_Op5; } ?>" min="0.00" step="0.01" max="100" onchange="updateBalanceInput(this.value, '5', 'Op');">
                                </div>
                                <div class="form-group col-sm-6 m-auto slider-tool-main">
                                    <div class="row justify-content-between">
                                        <div class="col selectorTool">
                                            <div class="left-col">
                                                <div class="client-info 5_Op_clientpercentage_div clientpercentage_div">
                                                    <?php if(isset($drfundsondeposit->Op_Funds_on_Deposit_Percent_Marital_Equity_to_Client5)){ echo $drfundsondeposit->Op_Funds_on_Deposit_Percent_Marital_Equity_to_Client5; } else {
                                                        echo "50.00";
                                                    } ?>%
                                                </div>
                                                <div class="client-info 5_Op_clientamount_div clientamount_div" style="clear: both;">
                                                    $<?php if(isset($drfundsondeposit->Op_Funds_on_Deposit_Estimated_Value_to_Client5)){ echo $drfundsondeposit->Op_Funds_on_Deposit_Estimated_Value_to_Client5; } ?>
                                                </div>
                                            </div>
                                            <label>To {{$client_name}}</label>
                                        </div>                                       
                                        <div class="col selectorTool selectorToolRight">
                                            <label>To {{$opponent_name}}</label>
                                            <div class="left-col right-col">
                                                <div class="client-info 5_Op_opponentpercentage_div opponentpercentage_div">
                                                    <?php if(isset($drfundsondeposit->Op_Funds_on_Deposit_Percent_Marital_Equity_to_Op5)){ echo $drfundsondeposit->Op_Funds_on_Deposit_Percent_Marital_Equity_to_Op5; } else {
                                                        echo "50.00";
                                                    } ?>%
                                                </div>
                                                <div class="client-info 5_Op_opponentamount_div opponentamount_div" style="clear: both;">
                                                    $<?php if(isset($drfundsondeposit->Op_Funds_on_Deposit_Estimated_Value_to_Op5)){ echo $drfundsondeposit->Op_Funds_on_Deposit_Estimated_Value_to_Op5; } ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 m-auto slider-tool-main">
                                    <label></label>
                                    <div class="w-100">
                                        <label><input type="radio" id="5_Op_Funds_on_Deposit_Estimated_Value_Select" name="5_Op_Funds_on_Deposit_Estimated_Value_Select_Reset" class="Funds_on_Deposit_Estimated_Value_Select_Reset" value="Save"> Save this Distribution of Deposit Account #5</label>
                                        <label><input type="radio" id="5_Op_Funds_on_Deposit_Estimated_Value_Reset" name="5_Op_Funds_on_Deposit_Estimated_Value_Select_Reset" class="Funds_on_Deposit_Estimated_Value_Select_Reset" value="Reset" onclick="resetBalanceInput(this, '5', 'Op');"> Reset to Default (50%)</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label>{{$client_name}} Deposite Equity Percent</label>
                                    <input id="Op_Funds_on_Deposit_Percent_Marital_Equity_to_Client5" type="number" class="form-control 5_Op_clientpercentage_input clientpercentage_input" name="Op_Funds_on_Deposit_Percent_Marital_Equity_to_Client5" value="<?php if(isset($drfundsondeposit->Op_Funds_on_Deposit_Percent_Marital_Equity_to_Client5)){ echo $drfundsondeposit->Op_Funds_on_Deposit_Percent_Marital_Equity_to_Client5; } ?>" min="0.00" step="0.01" max="100" readonly="">
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label>{{$client_name}} Deposite Equity Amount</label>
                                    <input id="Op_Funds_on_Deposit_Estimated_Value_to_Client5" type="number" class="form-control 5_Op_clientamount_input clientamount_input" name="Op_Funds_on_Deposit_Estimated_Value_to_Client5" value="<?php if(isset($drfundsondeposit->Op_Funds_on_Deposit_Estimated_Value_to_Client5)){ echo $drfundsondeposit->Op_Funds_on_Deposit_Estimated_Value_to_Client5; } ?>" min="0.00" step="0.01" max="999999.99" readonly="">
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label>{{$opponent_name}} Deposite Equity Percent</label>
                                    <input id="Op_Funds_on_Deposit_Percent_Marital_Equity_to_Op5" type="number" class="form-control 5_Op_opponentpercentage_input opponentpercentage_input" name="Op_Funds_on_Deposit_Percent_Marital_Equity_to_Op5" value="<?php if(isset($drfundsondeposit->Op_Funds_on_Deposit_Percent_Marital_Equity_to_Op5)){ echo $drfundsondeposit->Op_Funds_on_Deposit_Percent_Marital_Equity_to_Op5; } ?>" min="0.00" step="0.01" max="100" readonly="">
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label>{{$opponent_name}} Deposite Equity Amount</label>
                                    <input id="Op_Funds_on_Deposit_Estimated_Value_to_Op5" type="number" class="form-control 5_Op_opponentamount_input opponentamount_input" name="Op_Funds_on_Deposit_Estimated_Value_to_Op5" value="<?php if(isset($drfundsondeposit->Op_Funds_on_Deposit_Estimated_Value_to_Op5)){ echo $drfundsondeposit->Op_Funds_on_Deposit_Estimated_Value_to_Op5; } ?>" min="0.00" step="0.01" max="999999.99" readonly="">
                                </div>
                                <!-- end of slider tool -->
                            </div>
                            <div class="col-sm-12 mt-4 6_Op_fundsondeposit_section" style="display: none;"><h5 class="col-sm-12">Sixth Deposit Account Info</h5>
                                <div class="form-group col-sm-6">
                                    <p class="text-danger 6_Op_no-state-county-found" style="display: none;">No City, State, County found for this zipcode.</p>
                                    <label for="Op_Funds_on_Deposit_Institution_ZIP6">Deposit Institution Zip Code?</label>
                                    <input id="Op_Funds_on_Deposit_Institution_ZIP6" type="text" class="form-control 6_Op_fundsondeposit_inputs" name="Op_Funds_on_Deposit_Institution_ZIP6" value="<?php if(isset($drfundsondeposit->Op_Funds_on_Deposit_Institution_ZIP6)){ echo $drfundsondeposit->Op_Funds_on_Deposit_Institution_ZIP6; } ?>" data-onload="getCityStateForZip(this, '6', 'Op');" onkeyup="getCityStateForZip(this, '6', 'Op');"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Funds_on_Deposit_Institution_Name6">Name of Deposit Institution?</label>
                                    <input id="Op_Funds_on_Deposit_Institution_Name6" type="text" class="form-control 6_Op_fundsondeposit_inputs" name="Op_Funds_on_Deposit_Institution_Name6" value="<?php if(isset($drfundsondeposit->Op_Funds_on_Deposit_Institution_Name6)){ echo $drfundsondeposit->Op_Funds_on_Deposit_Institution_Name6; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Funds_on_Deposit_Institution_Street_Address6">Deposit Institution Street Address?</label>
                                    <input id="Op_Funds_on_Deposit_Institution_Street_Address6" type="text" class="form-control 6_Op_fundsondeposit_inputs" name="Op_Funds_on_Deposit_Institution_Street_Address6" value="<?php if(isset($drfundsondeposit->Op_Funds_on_Deposit_Institution_Street_Address6)){ echo $drfundsondeposit->Op_Funds_on_Deposit_Institution_Street_Address6; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Funds_on_Deposit_Institution_City6">Deposit Institution City?</label>
                                    <input type="hidden" name="" id="Op_Funds_on_Deposit_Institution_City6_Value" value="<?php if(isset($drfundsondeposit->Op_Funds_on_Deposit_Institution_City6)){ echo $drfundsondeposit->Op_Funds_on_Deposit_Institution_City6; } ?>">
                                    <select id="Op_Funds_on_Deposit_Institution_City6" name="Op_Funds_on_Deposit_Institution_City6" class="form-control 6_Op_city_select">
                                        <option value="">Choose City</option>
                                    </select>   
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Funds_on_Deposit_Institution_State6">Deposit Institution State?</label>
                                    <input type="hidden" name="" id="Op_Funds_on_Deposit_Institution_State6_Value" value="<?php if(isset($drfundsondeposit->Op_Funds_on_Deposit_Institution_City6)){ echo $drfundsondeposit->Op_Funds_on_Deposit_Institution_City6; } ?>">
                                    <select id="Op_Funds_on_Deposit_Institution_State6" name="Op_Funds_on_Deposit_Institution_State6" class="form-control 6_Op_state_select">
                                        <option value="">Choose State</option>
                                    </select>   
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Funds_on_Deposit_Institution_Acct_Num6">Account Number?</label>
                                    <input id="Op_Funds_on_Deposit_Institution_Acct_Num6" type="text" class="form-control 6_Op_fundsondeposit_inputs" name="Op_Funds_on_Deposit_Institution_Acct_Num6" value="<?php if(isset($drfundsondeposit->Op_Funds_on_Deposit_Institution_Acct_Num6)){ echo $drfundsondeposit->Op_Funds_on_Deposit_Institution_Acct_Num6; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Name on this account?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Op_Funds_on_Deposit_Institution_Name_on_Acct6_Client" name="Op_Funds_on_Deposit_Institution_Name_on_Acct6" value="{{$client_name}}" <?php if(isset($drfundsondeposit->Op_Funds_on_Deposit_Institution_Name_on_Acct6) && $drfundsondeposit->Op_Funds_on_Deposit_Institution_Name_on_Acct6==$client_name){ echo "checked"; } ?>> {{$client_name}}</label>
                                        <label><input type="radio" id="Op_Funds_on_Deposit_Institution_Name_on_Acct6_Op" name="Op_Funds_on_Deposit_Institution_Name_on_Acct6" value="{{$opponent_name}}" <?php if(isset($drfundsondeposit->Op_Funds_on_Deposit_Institution_Name_on_Acct6) && $drfundsondeposit->Op_Funds_on_Deposit_Institution_Name_on_Acct6==$opponent_name){ echo "checked"; } ?>> {{$opponent_name}}</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Funds_on_Deposit_Institution_Current_Balance6">Current Balance?</label>
                                    <input id="Op_Funds_on_Deposit_Institution_Current_Balance6" type="number" class="form-control 6_Op_fundsondeposit_inputs" name="Op_Funds_on_Deposit_Institution_Current_Balance6" value="<?php if(isset($drfundsondeposit->Op_Funds_on_Deposit_Institution_Current_Balance6)){ echo $drfundsondeposit->Op_Funds_on_Deposit_Institution_Current_Balance6; } ?>" min="0.00" step="0.01" max="999999.99" onchange="getClientOpCurrentBalance(this, '6', 'Op');" onkeyup="getClientOpCurrentBalance(this, '6', 'Op');"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Funds_on_Deposit_Institution_Yearly_Interest_Dividend6">Yearly Interest?</label>
                                    <input id="Op_Funds_on_Deposit_Institution_Yearly_Interest_Dividend6" type="number" class="form-control 6_Op_fundsondeposit_inputs" name="Op_Funds_on_Deposit_Institution_Yearly_Interest_Dividend6" value="<?php if(isset($drfundsondeposit->Op_Funds_on_Deposit_Institution_Yearly_Interest_Dividend6)){ echo $drfundsondeposit->Op_Funds_on_Deposit_Institution_Yearly_Interest_Dividend6; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Funds_on_Deposit_Institution_Balance_Date_of_Marriage6">Balance on marriage date (0.00, if started after marriage)?</label>
                                    <input id="Op_Funds_on_Deposit_Institution_Balance_Date_of_Marriage6" type="number" class="form-control 6_Op_fundsondeposit_inputs" name="Op_Funds_on_Deposit_Institution_Balance_Date_of_Marriage6" value="<?php if(isset($drfundsondeposit->Op_Funds_on_Deposit_Institution_Balance_Date_of_Marriage6)){ echo $drfundsondeposit->Op_Funds_on_Deposit_Institution_Balance_Date_of_Marriage6; } ?>" min="0.00" step="0.01" max="999999.99" onchange="getClientOpCurrentBalance(this, '6', 'Op');" onkeyup="getClientOpCurrentBalance(this, '6', 'Op');"> 
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label for="Op_Funds_on_Deposit_Estimated_MaritalEquity6">N/A, calculated = Op_Funds_on_Deposit_Institution_Current_Balance6 – Op_Funds_on_Deposit_Institution_Balance_Date_of_Marriage6</label>
                                    <input id="Op_Funds_on_Deposit_Estimated_MaritalEquity6" type="number" class="form-control 6_Op_fundsondeposit_inputs" name="Op_Funds_on_Deposit_Estimated_MaritalEquity6" value="<?php if(isset($drfundsondeposit->Op_Funds_on_Deposit_Estimated_MaritalEquity6)){ echo $drfundsondeposit->Op_Funds_on_Deposit_Estimated_MaritalEquity6; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Does either party claim a sole/separate interest from the other on this fund?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Op_Funds_on_Deposit_SoleSeparate_Claim6_Yes" name="Op_Funds_on_Deposit_SoleSeparate_Claim6" value="Yes" <?php if(isset($drfundsondeposit->Op_Funds_on_Deposit_SoleSeparate_Claim6) && $drfundsondeposit->Op_Funds_on_Deposit_SoleSeparate_Claim6=='Yes'){ echo "checked"; } ?>> Yes</label>
                                        <label><input type="radio" id="Op_Funds_on_Deposit_SoleSeparate_Claim6_No" name="Op_Funds_on_Deposit_SoleSeparate_Claim6" value="No" <?php if(isset($drfundsondeposit->Op_Funds_on_Deposit_SoleSeparate_Claim6) && $drfundsondeposit->Op_Funds_on_Deposit_SoleSeparate_Claim6=='No'){ echo "checked"; } ?>> No</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Who claims to own this fund?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Op_Funds_on_Deposit_SoleSeparate_Party6_Client" name="Op_Funds_on_Deposit_SoleSeparate_Party6" value="{{$client_name}}" <?php if(isset($drfundsondeposit->Op_Funds_on_Deposit_SoleSeparate_Party6) && $drfundsondeposit->Op_Funds_on_Deposit_SoleSeparate_Party6==$client_name){ echo "checked"; } ?>> {{$client_name}}</label>
                                        <label><input type="radio" id="Op_Funds_on_Deposit_SoleSeparate_Party6_Op" name="Op_Funds_on_Deposit_SoleSeparate_Party6" value="{{$opponent_name}}" <?php if(isset($drfundsondeposit->Op_Funds_on_Deposit_SoleSeparate_Party6) && $drfundsondeposit->Op_Funds_on_Deposit_SoleSeparate_Party6==$opponent_name){ echo "checked"; } ?>> {{$opponent_name}}</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 left-clear">
                                    <label for="Op_Funds_on_Deposit_SoleSeparate_Grounds6">Why does this person own this fund solely and separately?</label>
                                    <input id="Op_Funds_on_Deposit_SoleSeparate_Grounds6" type="text" class="form-control 6_Op_fundsondeposit_inputs" name="Op_Funds_on_Deposit_SoleSeparate_Grounds6" value="<?php if(isset($drfundsondeposit->Op_Funds_on_Deposit_SoleSeparate_Grounds6)){ echo $drfundsondeposit->Op_Funds_on_Deposit_SoleSeparate_Grounds6; } ?>"> 
                                </div>
                                <!-- slider tool -->
                                <div class="form-group col-sm-6 m-auto slider-tool-main">
                                    <div class="row">
                                        <div class="col">{{$client_name}}</div>
                                        <div class="col text-right">{{$opponent_name}}</div>
                                    </div>
                                    <input id="6_Op_balance_range_selector" type="range" class="form-control slider-tool-input 6_Op_balance_range_selector" name="" value="<?php if(isset($drfundsondeposit->Op_Funds_on_Deposit_Percent_Marital_Equity_to_Op6)){ echo $drfundsondeposit->Op_Funds_on_Deposit_Percent_Marital_Equity_to_Op6; } ?>" min="0.00" step="0.01" max="100" onchange="updateBalanceInput(this.value, '6', 'Op');">
                                </div>
                                <div class="form-group col-sm-6 m-auto slider-tool-main">
                                    <div class="row justify-content-between">
                                        <div class="col selectorTool">
                                            <div class="left-col">
                                                <div class="client-info 6_Op_clientpercentage_div clientpercentage_div">
                                                    <?php if(isset($drfundsondeposit->Op_Funds_on_Deposit_Percent_Marital_Equity_to_Client6)){ echo $drfundsondeposit->Op_Funds_on_Deposit_Percent_Marital_Equity_to_Client6; } else {
                                                        echo "50.00";
                                                    } ?>%
                                                </div>
                                                <div class="client-info 6_Op_clientamount_div clientamount_div" style="clear: both;">
                                                    $<?php if(isset($drfundsondeposit->Op_Funds_on_Deposit_Estimated_Value_to_Client6)){ echo $drfundsondeposit->Op_Funds_on_Deposit_Estimated_Value_to_Client6; } ?>
                                                </div>
                                            </div>
                                            <label>To {{$client_name}}</label>
                                        </div>                                       
                                        <div class="col selectorTool selectorToolRight">
                                            <label>To {{$opponent_name}}</label>
                                            <div class="left-col right-col">
                                                <div class="client-info 6_Op_opponentpercentage_div opponentpercentage_div">
                                                    <?php if(isset($drfundsondeposit->Op_Funds_on_Deposit_Percent_Marital_Equity_to_Op6)){ echo $drfundsondeposit->Op_Funds_on_Deposit_Percent_Marital_Equity_to_Op6; } else {
                                                        echo "50.00";
                                                    } ?>%
                                                </div>
                                                <div class="client-info 6_Op_opponentamount_div opponentamount_div" style="clear: both;">
                                                    $<?php if(isset($drfundsondeposit->Op_Funds_on_Deposit_Estimated_Value_to_Op6)){ echo $drfundsondeposit->Op_Funds_on_Deposit_Estimated_Value_to_Op6; } ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 m-auto slider-tool-main">
                                    <label></label>
                                    <div class="w-100">
                                        <label><input type="radio" id="6_Op_Funds_on_Deposit_Estimated_Value_Select" name="6_Op_Funds_on_Deposit_Estimated_Value_Select_Reset" class="Funds_on_Deposit_Estimated_Value_Select_Reset" value="Save"> Save this Distribution of Deposit Account #6</label>
                                        <label><input type="radio" id="6_Op_Funds_on_Deposit_Estimated_Value_Reset" name="6_Op_Funds_on_Deposit_Estimated_Value_Select_Reset" class="Funds_on_Deposit_Estimated_Value_Select_Reset" value="Reset" onclick="resetBalanceInput(this, '6', 'Op');"> Reset to Default (50%)</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label>{{$client_name}} Deposite Equity Percent</label>
                                    <input id="Op_Funds_on_Deposit_Percent_Marital_Equity_to_Client6" type="number" class="form-control 6_Op_clientpercentage_input clientpercentage_input" name="Op_Funds_on_Deposit_Percent_Marital_Equity_to_Client6" value="<?php if(isset($drfundsondeposit->Op_Funds_on_Deposit_Percent_Marital_Equity_to_Client6)){ echo $drfundsondeposit->Op_Funds_on_Deposit_Percent_Marital_Equity_to_Client6; } ?>" min="0.00" step="0.01" max="100" readonly="">
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label>{{$client_name}} Deposite Equity Amount</label>
                                    <input id="Op_Funds_on_Deposit_Estimated_Value_to_Client6" type="number" class="form-control 6_Op_clientamount_input clientamount_input" name="Op_Funds_on_Deposit_Estimated_Value_to_Client6" value="<?php if(isset($drfundsondeposit->Op_Funds_on_Deposit_Estimated_Value_to_Client6)){ echo $drfundsondeposit->Op_Funds_on_Deposit_Estimated_Value_to_Client6; } ?>" min="0.00" step="0.01" max="999999.99" readonly="">
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label>{{$opponent_name}} Deposite Equity Percent</label>
                                    <input id="Op_Funds_on_Deposit_Percent_Marital_Equity_to_Op6" type="number" class="form-control 6_Op_opponentpercentage_input opponentpercentage_input" name="Op_Funds_on_Deposit_Percent_Marital_Equity_to_Op6" value="<?php if(isset($drfundsondeposit->Op_Funds_on_Deposit_Percent_Marital_Equity_to_Op6)){ echo $drfundsondeposit->Op_Funds_on_Deposit_Percent_Marital_Equity_to_Op6; } ?>" min="0.00" step="0.01" max="100" readonly="">
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label>{{$opponent_name}} Deposite Equity Amount</label>
                                    <input id="Op_Funds_on_Deposit_Estimated_Value_to_Op6" type="number" class="form-control 6_Op_opponentamount_input opponentamount_input" name="Op_Funds_on_Deposit_Estimated_Value_to_Op6" value="<?php if(isset($drfundsondeposit->Op_Funds_on_Deposit_Estimated_Value_to_Op6)){ echo $drfundsondeposit->Op_Funds_on_Deposit_Estimated_Value_to_Op6; } ?>" min="0.00" step="0.01" max="999999.99" readonly="">
                                </div>
                                <!-- end of slider tool -->
                            </div>
                            <div class="col-sm-12 mt-4 7_Op_fundsondeposit_section" style="display: none;"><h5 class="col-sm-12">Seventh Deposit Account Info</h5>
                                <div class="form-group col-sm-6">
                                    <p class="text-danger 7_Op_no-state-county-found" style="display: none;">No City, State, County found for this zipcode.</p>
                                    <label for="Op_Funds_on_Deposit_Institution_ZIP7">Deposit Institution Zip Code?</label>
                                    <input id="Op_Funds_on_Deposit_Institution_ZIP7" type="text" class="form-control 7_Op_fundsondeposit_inputs" name="Op_Funds_on_Deposit_Institution_ZIP7" value="<?php if(isset($drfundsondeposit->Op_Funds_on_Deposit_Institution_ZIP7)){ echo $drfundsondeposit->Op_Funds_on_Deposit_Institution_ZIP7; } ?>" data-onload="getCityStateForZip(this, '7', 'Op');" onkeyup="getCityStateForZip(this, '7', 'Op');"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Funds_on_Deposit_Institution_Name7">Name of Deposit Institution?</label>
                                    <input id="Op_Funds_on_Deposit_Institution_Name7" type="text" class="form-control 7_Op_fundsondeposit_inputs" name="Op_Funds_on_Deposit_Institution_Name7" value="<?php if(isset($drfundsondeposit->Op_Funds_on_Deposit_Institution_Name7)){ echo $drfundsondeposit->Op_Funds_on_Deposit_Institution_Name7; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Funds_on_Deposit_Institution_Street_Address7">Deposit Institution Street Address?</label>
                                    <input id="Op_Funds_on_Deposit_Institution_Street_Address7" type="text" class="form-control 7_Op_fundsondeposit_inputs" name="Op_Funds_on_Deposit_Institution_Street_Address7" value="<?php if(isset($drfundsondeposit->Op_Funds_on_Deposit_Institution_Street_Address7)){ echo $drfundsondeposit->Op_Funds_on_Deposit_Institution_Street_Address7; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Funds_on_Deposit_Institution_City7">Deposit Institution City?</label>
                                    <input type="hidden" name="" id="Op_Funds_on_Deposit_Institution_City7_Value" value="<?php if(isset($drfundsondeposit->Op_Funds_on_Deposit_Institution_City7)){ echo $drfundsondeposit->Op_Funds_on_Deposit_Institution_City7; } ?>">
                                    <select id="Op_Funds_on_Deposit_Institution_City7" name="Op_Funds_on_Deposit_Institution_City7" class="form-control 7_Op_city_select">
                                        <option value="">Choose City</option>
                                    </select>   
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Funds_on_Deposit_Institution_State7">Deposit Institution State?</label>
                                    <input type="hidden" name="" id="Op_Funds_on_Deposit_Institution_State7_Value" value="<?php if(isset($drfundsondeposit->Op_Funds_on_Deposit_Institution_City7)){ echo $drfundsondeposit->Op_Funds_on_Deposit_Institution_City7; } ?>">
                                    <select id="Op_Funds_on_Deposit_Institution_State7" name="Op_Funds_on_Deposit_Institution_State7" class="form-control 7_Op_state_select">
                                        <option value="">Choose State</option>
                                    </select>   
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Funds_on_Deposit_Institution_Acct_Num7">Account Number?</label>
                                    <input id="Op_Funds_on_Deposit_Institution_Acct_Num7" type="text" class="form-control 7_Op_fundsondeposit_inputs" name="Op_Funds_on_Deposit_Institution_Acct_Num7" value="<?php if(isset($drfundsondeposit->Op_Funds_on_Deposit_Institution_Acct_Num7)){ echo $drfundsondeposit->Op_Funds_on_Deposit_Institution_Acct_Num7; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Name on this account?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Op_Funds_on_Deposit_Institution_Name_on_Acct7_Client" name="Op_Funds_on_Deposit_Institution_Name_on_Acct7" value="{{$client_name}}" <?php if(isset($drfundsondeposit->Op_Funds_on_Deposit_Institution_Name_on_Acct7) && $drfundsondeposit->Op_Funds_on_Deposit_Institution_Name_on_Acct7==$client_name){ echo "checked"; } ?>> {{$client_name}}</label>
                                        <label><input type="radio" id="Op_Funds_on_Deposit_Institution_Name_on_Acct7_Op" name="Op_Funds_on_Deposit_Institution_Name_on_Acct7" value="{{$opponent_name}}" <?php if(isset($drfundsondeposit->Op_Funds_on_Deposit_Institution_Name_on_Acct7) && $drfundsondeposit->Op_Funds_on_Deposit_Institution_Name_on_Acct7==$opponent_name){ echo "checked"; } ?>> {{$opponent_name}}</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Funds_on_Deposit_Institution_Current_Balance7">Current Balance?</label>
                                    <input id="Op_Funds_on_Deposit_Institution_Current_Balance7" type="number" class="form-control 7_Op_fundsondeposit_inputs" name="Op_Funds_on_Deposit_Institution_Current_Balance7" value="<?php if(isset($drfundsondeposit->Op_Funds_on_Deposit_Institution_Current_Balance7)){ echo $drfundsondeposit->Op_Funds_on_Deposit_Institution_Current_Balance7; } ?>" min="0.00" step="0.01" max="999999.99" onchange="getClientOpCurrentBalance(this, '7', 'Op');" onkeyup="getClientOpCurrentBalance(this, '7', 'Op');"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Funds_on_Deposit_Institution_Yearly_Interest_Dividend7">Yearly Interest?</label>
                                    <input id="Op_Funds_on_Deposit_Institution_Yearly_Interest_Dividend7" type="number" class="form-control 7_Op_fundsondeposit_inputs" name="Op_Funds_on_Deposit_Institution_Yearly_Interest_Dividend7" value="<?php if(isset($drfundsondeposit->Op_Funds_on_Deposit_Institution_Yearly_Interest_Dividend7)){ echo $drfundsondeposit->Op_Funds_on_Deposit_Institution_Yearly_Interest_Dividend7; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Funds_on_Deposit_Institution_Balance_Date_of_Marriage7">Balance on marriage date (0.00, if started after marriage)?</label>
                                    <input id="Op_Funds_on_Deposit_Institution_Balance_Date_of_Marriage7" type="number" class="form-control 7_Op_fundsondeposit_inputs" name="Op_Funds_on_Deposit_Institution_Balance_Date_of_Marriage7" value="<?php if(isset($drfundsondeposit->Op_Funds_on_Deposit_Institution_Balance_Date_of_Marriage7)){ echo $drfundsondeposit->Op_Funds_on_Deposit_Institution_Balance_Date_of_Marriage7; } ?>" min="0.00" step="0.01" max="999999.99" onchange="getClientOpCurrentBalance(this, '7', 'Op');" onkeyup="getClientOpCurrentBalance(this, '7', 'Op');"> 
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label for="Op_Funds_on_Deposit_Estimated_MaritalEquity7">N/A, calculated = Op_Funds_on_Deposit_Institution_Current_Balance7 – Op_Funds_on_Deposit_Institution_Balance_Date_of_Marriage7</label>
                                    <input id="Op_Funds_on_Deposit_Estimated_MaritalEquity7" type="number" class="form-control 7_Op_fundsondeposit_inputs" name="Op_Funds_on_Deposit_Estimated_MaritalEquity7" value="<?php if(isset($drfundsondeposit->Op_Funds_on_Deposit_Estimated_MaritalEquity7)){ echo $drfundsondeposit->Op_Funds_on_Deposit_Estimated_MaritalEquity7; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Does either party claim a sole/separate interest from the other on this fund?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Op_Funds_on_Deposit_SoleSeparate_Claim7_Yes" name="Op_Funds_on_Deposit_SoleSeparate_Claim7" value="Yes" <?php if(isset($drfundsondeposit->Op_Funds_on_Deposit_SoleSeparate_Claim7) && $drfundsondeposit->Op_Funds_on_Deposit_SoleSeparate_Claim7=='Yes'){ echo "checked"; } ?>> Yes</label>
                                        <label><input type="radio" id="Op_Funds_on_Deposit_SoleSeparate_Claim7_No" name="Op_Funds_on_Deposit_SoleSeparate_Claim7" value="No" <?php if(isset($drfundsondeposit->Op_Funds_on_Deposit_SoleSeparate_Claim7) && $drfundsondeposit->Op_Funds_on_Deposit_SoleSeparate_Claim7=='No'){ echo "checked"; } ?>> No</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Who claims to own this fund?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Op_Funds_on_Deposit_SoleSeparate_Party7_Client" name="Op_Funds_on_Deposit_SoleSeparate_Party7" value="{{$client_name}}" <?php if(isset($drfundsondeposit->Op_Funds_on_Deposit_SoleSeparate_Party7) && $drfundsondeposit->Op_Funds_on_Deposit_SoleSeparate_Party7==$client_name){ echo "checked"; } ?>> {{$client_name}}</label>
                                        <label><input type="radio" id="Op_Funds_on_Deposit_SoleSeparate_Party7_Op" name="Op_Funds_on_Deposit_SoleSeparate_Party7" value="{{$opponent_name}}" <?php if(isset($drfundsondeposit->Op_Funds_on_Deposit_SoleSeparate_Party7) && $drfundsondeposit->Op_Funds_on_Deposit_SoleSeparate_Party7==$opponent_name){ echo "checked"; } ?>> {{$opponent_name}}</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 left-clear">
                                    <label for="Op_Funds_on_Deposit_SoleSeparate_Grounds7">Why does this person own this fund solely and separately?</label>
                                    <input id="Op_Funds_on_Deposit_SoleSeparate_Grounds7" type="text" class="form-control 7_Op_fundsondeposit_inputs" name="Op_Funds_on_Deposit_SoleSeparate_Grounds7" value="<?php if(isset($drfundsondeposit->Op_Funds_on_Deposit_SoleSeparate_Grounds7)){ echo $drfundsondeposit->Op_Funds_on_Deposit_SoleSeparate_Grounds7; } ?>"> 
                                </div>
                                <!-- slider tool -->
                                <div class="form-group col-sm-6 m-auto slider-tool-main">
                                    <div class="row">
                                        <div class="col">{{$client_name}}</div>
                                        <div class="col text-right">{{$opponent_name}}</div>
                                    </div>
                                    <input id="7_Op_balance_range_selector" type="range" class="form-control slider-tool-input 7_Op_balance_range_selector" name="" value="<?php if(isset($drfundsondeposit->Op_Funds_on_Deposit_Percent_Marital_Equity_to_Op7)){ echo $drfundsondeposit->Op_Funds_on_Deposit_Percent_Marital_Equity_to_Op7; } ?>" min="0.00" step="0.01" max="100" onchange="updateBalanceInput(this.value, '7', 'Op');">
                                </div>
                                <div class="form-group col-sm-6 m-auto slider-tool-main">
                                    <div class="row justify-content-between">
                                        <div class="col selectorTool">
                                            <div class="left-col">
                                                <div class="client-info 7_Op_clientpercentage_div clientpercentage_div">
                                                    <?php if(isset($drfundsondeposit->Op_Funds_on_Deposit_Percent_Marital_Equity_to_Client7)){ echo $drfundsondeposit->Op_Funds_on_Deposit_Percent_Marital_Equity_to_Client7; } else {
                                                        echo "50.00";
                                                    } ?>%
                                                </div>
                                                <div class="client-info 7_Op_clientamount_div clientamount_div" style="clear: both;">
                                                    $<?php if(isset($drfundsondeposit->Op_Funds_on_Deposit_Estimated_Value_to_Client7)){ echo $drfundsondeposit->Op_Funds_on_Deposit_Estimated_Value_to_Client7; } ?>
                                                </div>
                                            </div>
                                            <label>To {{$client_name}}</label>
                                        </div>                                       
                                        <div class="col selectorTool selectorToolRight">
                                            <label>To {{$opponent_name}}</label>
                                            <div class="left-col right-col">
                                                <div class="client-info 7_Op_opponentpercentage_div opponentpercentage_div">
                                                    <?php if(isset($drfundsondeposit->Op_Funds_on_Deposit_Percent_Marital_Equity_to_Op7)){ echo $drfundsondeposit->Op_Funds_on_Deposit_Percent_Marital_Equity_to_Op7; } else {
                                                        echo "50.00";
                                                    } ?>%
                                                </div>
                                                <div class="client-info 7_Op_opponentamount_div opponentamount_div" style="clear: both;">
                                                    $<?php if(isset($drfundsondeposit->Op_Funds_on_Deposit_Estimated_Value_to_Op7)){ echo $drfundsondeposit->Op_Funds_on_Deposit_Estimated_Value_to_Op7; } ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 m-auto slider-tool-main">
                                    <label></label>
                                    <div class="w-100">
                                        <label><input type="radio" id="7_Op_Funds_on_Deposit_Estimated_Value_Select" name="7_Op_Funds_on_Deposit_Estimated_Value_Select_Reset" class="Funds_on_Deposit_Estimated_Value_Select_Reset" value="Save"> Save this Distribution of Deposit Account #7</label>
                                        <label><input type="radio" id="7_Op_Funds_on_Deposit_Estimated_Value_Reset" name="7_Op_Funds_on_Deposit_Estimated_Value_Select_Reset" class="Funds_on_Deposit_Estimated_Value_Select_Reset" value="Reset" onclick="resetBalanceInput(this, '7', 'Op');"> Reset to Default (50%)</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label>{{$client_name}} Deposite Equity Percent</label>
                                    <input id="Op_Funds_on_Deposit_Percent_Marital_Equity_to_Client7" type="number" class="form-control 7_Op_clientpercentage_input clientpercentage_input" name="Op_Funds_on_Deposit_Percent_Marital_Equity_to_Client7" value="<?php if(isset($drfundsondeposit->Op_Funds_on_Deposit_Percent_Marital_Equity_to_Client7)){ echo $drfundsondeposit->Op_Funds_on_Deposit_Percent_Marital_Equity_to_Client7; } ?>" min="0.00" step="0.01" max="100" readonly="">
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label>{{$client_name}} Deposite Equity Amount</label>
                                    <input id="Op_Funds_on_Deposit_Estimated_Value_to_Client7" type="number" class="form-control 7_Op_clientamount_input clientamount_input" name="Op_Funds_on_Deposit_Estimated_Value_to_Client7" value="<?php if(isset($drfundsondeposit->Op_Funds_on_Deposit_Estimated_Value_to_Client7)){ echo $drfundsondeposit->Op_Funds_on_Deposit_Estimated_Value_to_Client7; } ?>" min="0.00" step="0.01" max="999999.99" readonly="">
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label>{{$opponent_name}} Deposite Equity Percent</label>
                                    <input id="Op_Funds_on_Deposit_Percent_Marital_Equity_to_Op7" type="number" class="form-control 7_Op_opponentpercentage_input opponentpercentage_input" name="Op_Funds_on_Deposit_Percent_Marital_Equity_to_Op7" value="<?php if(isset($drfundsondeposit->Op_Funds_on_Deposit_Percent_Marital_Equity_to_Op7)){ echo $drfundsondeposit->Op_Funds_on_Deposit_Percent_Marital_Equity_to_Op7; } ?>" min="0.00" step="0.01" max="100" readonly="">
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label>{{$opponent_name}} Deposite Equity Amount</label>
                                    <input id="Op_Funds_on_Deposit_Estimated_Value_to_Op7" type="number" class="form-control 7_Op_opponentamount_input opponentamount_input" name="Op_Funds_on_Deposit_Estimated_Value_to_Op7" value="<?php if(isset($drfundsondeposit->Op_Funds_on_Deposit_Estimated_Value_to_Op7)){ echo $drfundsondeposit->Op_Funds_on_Deposit_Estimated_Value_to_Op7; } ?>" min="0.00" step="0.01" max="999999.99" readonly="">
                                </div>
                                <!-- end of slider tool -->
                            </div>
                            <div class="col-sm-12 mt-4 8_Op_fundsondeposit_section" style="display: none;"><h5 class="col-sm-12">Eighth Deposit Account Info</h5>
                                <div class="form-group col-sm-6">
                                    <p class="text-danger 8_Op_no-state-county-found" style="display: none;">No City, State, County found for this zipcode.</p>
                                    <label for="Op_Funds_on_Deposit_Institution_ZIP8">Deposit Institution Zip Code?</label>
                                    <input id="Op_Funds_on_Deposit_Institution_ZIP8" type="text" class="form-control 8_Op_fundsondeposit_inputs" name="Op_Funds_on_Deposit_Institution_ZIP8" value="<?php if(isset($drfundsondeposit->Op_Funds_on_Deposit_Institution_ZIP8)){ echo $drfundsondeposit->Op_Funds_on_Deposit_Institution_ZIP8; } ?>" data-onload="getCityStateForZip(this, '8', 'Op');" onkeyup="getCityStateForZip(this, '8', 'Op');"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Funds_on_Deposit_Institution_Name8">Name of Deposit Institution?</label>
                                    <input id="Op_Funds_on_Deposit_Institution_Name8" type="text" class="form-control 8_Op_fundsondeposit_inputs" name="Op_Funds_on_Deposit_Institution_Name8" value="<?php if(isset($drfundsondeposit->Op_Funds_on_Deposit_Institution_Name8)){ echo $drfundsondeposit->Op_Funds_on_Deposit_Institution_Name8; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Funds_on_Deposit_Institution_Street_Address8">Deposit Institution Street Address?</label>
                                    <input id="Op_Funds_on_Deposit_Institution_Street_Address8" type="text" class="form-control 8_Op_fundsondeposit_inputs" name="Op_Funds_on_Deposit_Institution_Street_Address8" value="<?php if(isset($drfundsondeposit->Op_Funds_on_Deposit_Institution_Street_Address8)){ echo $drfundsondeposit->Op_Funds_on_Deposit_Institution_Street_Address8; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Funds_on_Deposit_Institution_City8">Deposit Institution City?</label>
                                    <input type="hidden" name="" id="Op_Funds_on_Deposit_Institution_City8_Value" value="<?php if(isset($drfundsondeposit->Op_Funds_on_Deposit_Institution_City8)){ echo $drfundsondeposit->Op_Funds_on_Deposit_Institution_City8; } ?>">
                                    <select id="Op_Funds_on_Deposit_Institution_City8" name="Op_Funds_on_Deposit_Institution_City8" class="form-control 8_Op_city_select">
                                        <option value="">Choose City</option>
                                    </select>   
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Funds_on_Deposit_Institution_State8">Deposit Institution State?</label>
                                    <input type="hidden" name="" id="Op_Funds_on_Deposit_Institution_State8_Value" value="<?php if(isset($drfundsondeposit->Op_Funds_on_Deposit_Institution_City8)){ echo $drfundsondeposit->Op_Funds_on_Deposit_Institution_City8; } ?>">
                                    <select id="Op_Funds_on_Deposit_Institution_State8" name="Op_Funds_on_Deposit_Institution_State8" class="form-control 8_Op_state_select">
                                        <option value="">Choose State</option>
                                    </select>   
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Funds_on_Deposit_Institution_Acct_Num8">Account Number?</label>
                                    <input id="Op_Funds_on_Deposit_Institution_Acct_Num8" type="text" class="form-control 8_Op_fundsondeposit_inputs" name="Op_Funds_on_Deposit_Institution_Acct_Num8" value="<?php if(isset($drfundsondeposit->Op_Funds_on_Deposit_Institution_Acct_Num8)){ echo $drfundsondeposit->Op_Funds_on_Deposit_Institution_Acct_Num8; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Name on this account?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Op_Funds_on_Deposit_Institution_Name_on_Acct8_Client" name="Op_Funds_on_Deposit_Institution_Name_on_Acct8" value="{{$client_name}}" <?php if(isset($drfundsondeposit->Op_Funds_on_Deposit_Institution_Name_on_Acct8) && $drfundsondeposit->Op_Funds_on_Deposit_Institution_Name_on_Acct8==$client_name){ echo "checked"; } ?>> {{$client_name}}</label>
                                        <label><input type="radio" id="Op_Funds_on_Deposit_Institution_Name_on_Acct8_Op" name="Op_Funds_on_Deposit_Institution_Name_on_Acct8" value="{{$opponent_name}}" <?php if(isset($drfundsondeposit->Op_Funds_on_Deposit_Institution_Name_on_Acct8) && $drfundsondeposit->Op_Funds_on_Deposit_Institution_Name_on_Acct8==$opponent_name){ echo "checked"; } ?>> {{$opponent_name}}</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Funds_on_Deposit_Institution_Current_Balance8">Current Balance?</label>
                                    <input id="Op_Funds_on_Deposit_Institution_Current_Balance8" type="number" class="form-control 8_Op_fundsondeposit_inputs" name="Op_Funds_on_Deposit_Institution_Current_Balance8" value="<?php if(isset($drfundsondeposit->Op_Funds_on_Deposit_Institution_Current_Balance8)){ echo $drfundsondeposit->Op_Funds_on_Deposit_Institution_Current_Balance8; } ?>" min="0.00" step="0.01" max="999999.99" onchange="getClientOpCurrentBalance(this, '8', 'Op');" onkeyup="getClientOpCurrentBalance(this, '8', 'Op');"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Funds_on_Deposit_Institution_Yearly_Interest_Dividend8">Yearly Interest?</label>
                                    <input id="Op_Funds_on_Deposit_Institution_Yearly_Interest_Dividend8" type="number" class="form-control 8_Op_fundsondeposit_inputs" name="Op_Funds_on_Deposit_Institution_Yearly_Interest_Dividend8" value="<?php if(isset($drfundsondeposit->Op_Funds_on_Deposit_Institution_Yearly_Interest_Dividend8)){ echo $drfundsondeposit->Op_Funds_on_Deposit_Institution_Yearly_Interest_Dividend8; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Funds_on_Deposit_Institution_Balance_Date_of_Marriage8">Balance on marriage date (0.00, if started after marriage)?</label>
                                    <input id="Op_Funds_on_Deposit_Institution_Balance_Date_of_Marriage8" type="number" class="form-control 8_Op_fundsondeposit_inputs" name="Op_Funds_on_Deposit_Institution_Balance_Date_of_Marriage8" value="<?php if(isset($drfundsondeposit->Op_Funds_on_Deposit_Institution_Balance_Date_of_Marriage8)){ echo $drfundsondeposit->Op_Funds_on_Deposit_Institution_Balance_Date_of_Marriage8; } ?>" min="0.00" step="0.01" max="999999.99" onchange="getClientOpCurrentBalance(this, '8', 'Op');" onkeyup="getClientOpCurrentBalance(this, '8', 'Op');"> 
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label for="Op_Funds_on_Deposit_Estimated_MaritalEquity8">N/A, calculated = Op_Funds_on_Deposit_Institution_Current_Balance8 – Op_Funds_on_Deposit_Institution_Balance_Date_of_Marriage8</label>
                                    <input id="Op_Funds_on_Deposit_Estimated_MaritalEquity8" type="number" class="form-control 8_Op_fundsondeposit_inputs" name="Op_Funds_on_Deposit_Estimated_MaritalEquity8" value="<?php if(isset($drfundsondeposit->Op_Funds_on_Deposit_Estimated_MaritalEquity8)){ echo $drfundsondeposit->Op_Funds_on_Deposit_Estimated_MaritalEquity8; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Does either party claim a sole/separate interest from the other on this fund?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Op_Funds_on_Deposit_SoleSeparate_Claim8_Yes" name="Op_Funds_on_Deposit_SoleSeparate_Claim8" value="Yes" <?php if(isset($drfundsondeposit->Op_Funds_on_Deposit_SoleSeparate_Claim8) && $drfundsondeposit->Op_Funds_on_Deposit_SoleSeparate_Claim8=='Yes'){ echo "checked"; } ?>> Yes</label>
                                        <label><input type="radio" id="Op_Funds_on_Deposit_SoleSeparate_Claim8_No" name="Op_Funds_on_Deposit_SoleSeparate_Claim8" value="No" <?php if(isset($drfundsondeposit->Op_Funds_on_Deposit_SoleSeparate_Claim8) && $drfundsondeposit->Op_Funds_on_Deposit_SoleSeparate_Claim8=='No'){ echo "checked"; } ?>> No</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Who claims to own this fund?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Op_Funds_on_Deposit_SoleSeparate_Party8_Client" name="Op_Funds_on_Deposit_SoleSeparate_Party8" value="{{$client_name}}" <?php if(isset($drfundsondeposit->Op_Funds_on_Deposit_SoleSeparate_Party8) && $drfundsondeposit->Op_Funds_on_Deposit_SoleSeparate_Party8==$client_name){ echo "checked"; } ?>> {{$client_name}}</label>
                                        <label><input type="radio" id="Op_Funds_on_Deposit_SoleSeparate_Party8_Op" name="Op_Funds_on_Deposit_SoleSeparate_Party8" value="{{$opponent_name}}" <?php if(isset($drfundsondeposit->Op_Funds_on_Deposit_SoleSeparate_Party8) && $drfundsondeposit->Op_Funds_on_Deposit_SoleSeparate_Party8==$opponent_name){ echo "checked"; } ?>> {{$opponent_name}}</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 left-clear">
                                    <label for="Op_Funds_on_Deposit_SoleSeparate_Grounds8">Why does this person own this fund solely and separately?</label>
                                    <input id="Op_Funds_on_Deposit_SoleSeparate_Grounds8" type="text" class="form-control 8_Op_fundsondeposit_inputs" name="Op_Funds_on_Deposit_SoleSeparate_Grounds8" value="<?php if(isset($drfundsondeposit->Op_Funds_on_Deposit_SoleSeparate_Grounds8)){ echo $drfundsondeposit->Op_Funds_on_Deposit_SoleSeparate_Grounds8; } ?>"> 
                                </div>
                                <!-- slider tool -->
                                <div class="form-group col-sm-6 m-auto slider-tool-main">
                                    <div class="row">
                                        <div class="col">{{$client_name}}</div>
                                        <div class="col text-right">{{$opponent_name}}</div>
                                    </div>
                                    <input id="8_Op_balance_range_selector" type="range" class="form-control slider-tool-input 8_Op_balance_range_selector" name="" value="<?php if(isset($drfundsondeposit->Op_Funds_on_Deposit_Percent_Marital_Equity_to_Op8)){ echo $drfundsondeposit->Op_Funds_on_Deposit_Percent_Marital_Equity_to_Op8; } ?>" min="0.00" step="0.01" max="100" onchange="updateBalanceInput(this.value, '8', 'Op');">
                                </div>
                                <div class="form-group col-sm-6 m-auto slider-tool-main">
                                    <div class="row justify-content-between">
                                        <div class="col selectorTool">
                                            <div class="left-col">
                                                <div class="client-info 8_Op_clientpercentage_div clientpercentage_div">
                                                    <?php if(isset($drfundsondeposit->Op_Funds_on_Deposit_Percent_Marital_Equity_to_Client8)){ echo $drfundsondeposit->Op_Funds_on_Deposit_Percent_Marital_Equity_to_Client8; } else {
                                                        echo "50.00";
                                                    } ?>%
                                                </div>
                                                <div class="client-info 8_Op_clientamount_div clientamount_div" style="clear: both;">
                                                    $<?php if(isset($drfundsondeposit->Op_Funds_on_Deposit_Estimated_Value_to_Client8)){ echo $drfundsondeposit->Op_Funds_on_Deposit_Estimated_Value_to_Client8; } ?>
                                                </div>
                                            </div>
                                            <label>To {{$client_name}}</label>
                                        </div>                                       
                                        <div class="col selectorTool selectorToolRight">
                                            <label>To {{$opponent_name}}</label>
                                            <div class="left-col right-col">
                                                <div class="client-info 8_Op_opponentpercentage_div opponentpercentage_div">
                                                    <?php if(isset($drfundsondeposit->Op_Funds_on_Deposit_Percent_Marital_Equity_to_Op8)){ echo $drfundsondeposit->Op_Funds_on_Deposit_Percent_Marital_Equity_to_Op8; } else {
                                                        echo "50.00";
                                                    } ?>%
                                                </div>
                                                <div class="client-info 8_Op_opponentamount_div opponentamount_div" style="clear: both;">
                                                    $<?php if(isset($drfundsondeposit->Op_Funds_on_Deposit_Estimated_Value_to_Op8)){ echo $drfundsondeposit->Op_Funds_on_Deposit_Estimated_Value_to_Op8; } ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 m-auto slider-tool-main">
                                    <label></label>
                                    <div class="w-100">
                                        <label><input type="radio" id="8_Op_Funds_on_Deposit_Estimated_Value_Select" name="8_Op_Funds_on_Deposit_Estimated_Value_Select_Reset" class="Funds_on_Deposit_Estimated_Value_Select_Reset" value="Save"> Save this Distribution of Deposit Account #8</label>
                                        <label><input type="radio" id="8_Op_Funds_on_Deposit_Estimated_Value_Reset" name="8_Op_Funds_on_Deposit_Estimated_Value_Select_Reset" class="Funds_on_Deposit_Estimated_Value_Select_Reset" value="Reset" onclick="resetBalanceInput(this, '8', 'Op');"> Reset to Default (50%)</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label>{{$client_name}} Deposite Equity Percent</label>
                                    <input id="Op_Funds_on_Deposit_Percent_Marital_Equity_to_Client8" type="number" class="form-control 8_Op_clientpercentage_input clientpercentage_input" name="Op_Funds_on_Deposit_Percent_Marital_Equity_to_Client8" value="<?php if(isset($drfundsondeposit->Op_Funds_on_Deposit_Percent_Marital_Equity_to_Client8)){ echo $drfundsondeposit->Op_Funds_on_Deposit_Percent_Marital_Equity_to_Client8; } ?>" min="0.00" step="0.01" max="100" readonly="">
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label>{{$client_name}} Deposite Equity Amount</label>
                                    <input id="Op_Funds_on_Deposit_Estimated_Value_to_Client8" type="number" class="form-control 8_Op_clientamount_input clientamount_input" name="Op_Funds_on_Deposit_Estimated_Value_to_Client8" value="<?php if(isset($drfundsondeposit->Op_Funds_on_Deposit_Estimated_Value_to_Client8)){ echo $drfundsondeposit->Op_Funds_on_Deposit_Estimated_Value_to_Client8; } ?>" min="0.00" step="0.01" max="999999.99" readonly="">
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label>{{$opponent_name}} Deposite Equity Percent</label>
                                    <input id="Op_Funds_on_Deposit_Percent_Marital_Equity_to_Op8" type="number" class="form-control 8_Op_opponentpercentage_input opponentpercentage_input" name="Op_Funds_on_Deposit_Percent_Marital_Equity_to_Op8" value="<?php if(isset($drfundsondeposit->Op_Funds_on_Deposit_Percent_Marital_Equity_to_Op8)){ echo $drfundsondeposit->Op_Funds_on_Deposit_Percent_Marital_Equity_to_Op8; } ?>" min="0.00" step="0.01" max="100" readonly="">
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label>{{$opponent_name}} Deposite Equity Amount</label>
                                    <input id="Op_Funds_on_Deposit_Estimated_Value_to_Op8" type="number" class="form-control 8_Op_opponentamount_input opponentamount_input" name="Op_Funds_on_Deposit_Estimated_Value_to_Op8" value="<?php if(isset($drfundsondeposit->Op_Funds_on_Deposit_Estimated_Value_to_Op8)){ echo $drfundsondeposit->Op_Funds_on_Deposit_Estimated_Value_to_Op8; } ?>" min="0.00" step="0.01" max="999999.99" readonly="">
                                </div>
                                <!-- end of slider tool -->
                            </div>
                            <div class="col-sm-12 mt-4 9_Op_fundsondeposit_section" style="display: none;"><h5 class="col-sm-12">Nineth Deposit Account Info</h5>
                                <div class="form-group col-sm-6">
                                    <p class="text-danger 9_Op_no-state-county-found" style="display: none;">No City, State, County found for this zipcode.</p>
                                    <label for="Op_Funds_on_Deposit_Institution_ZIP9">Deposit Institution Zip Code?</label>
                                    <input id="Op_Funds_on_Deposit_Institution_ZIP9" type="text" class="form-control 9_Op_fundsondeposit_inputs" name="Op_Funds_on_Deposit_Institution_ZIP9" value="<?php if(isset($drfundsondeposit->Op_Funds_on_Deposit_Institution_ZIP9)){ echo $drfundsondeposit->Op_Funds_on_Deposit_Institution_ZIP9; } ?>" data-onload="getCityStateForZip(this, '9', 'Op');" onkeyup="getCityStateForZip(this, '9', 'Op');"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Funds_on_Deposit_Institution_Name9">Name of Deposit Institution?</label>
                                    <input id="Op_Funds_on_Deposit_Institution_Name9" type="text" class="form-control 9_Op_fundsondeposit_inputs" name="Op_Funds_on_Deposit_Institution_Name9" value="<?php if(isset($drfundsondeposit->Op_Funds_on_Deposit_Institution_Name9)){ echo $drfundsondeposit->Op_Funds_on_Deposit_Institution_Name9; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Funds_on_Deposit_Institution_Street_Address9">Deposit Institution Street Address?</label>
                                    <input id="Op_Funds_on_Deposit_Institution_Street_Address9" type="text" class="form-control 9_Op_fundsondeposit_inputs" name="Op_Funds_on_Deposit_Institution_Street_Address9" value="<?php if(isset($drfundsondeposit->Op_Funds_on_Deposit_Institution_Street_Address9)){ echo $drfundsondeposit->Op_Funds_on_Deposit_Institution_Street_Address9; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Funds_on_Deposit_Institution_City9">Deposit Institution City?</label>
                                    <input type="hidden" name="" id="Op_Funds_on_Deposit_Institution_City9_Value" value="<?php if(isset($drfundsondeposit->Op_Funds_on_Deposit_Institution_City9)){ echo $drfundsondeposit->Op_Funds_on_Deposit_Institution_City9; } ?>">
                                    <select id="Op_Funds_on_Deposit_Institution_City9" name="Op_Funds_on_Deposit_Institution_City9" class="form-control 9_Op_city_select">
                                        <option value="">Choose City</option>
                                    </select>   
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Funds_on_Deposit_Institution_State9">Deposit Institution State?</label>
                                    <input type="hidden" name="" id="Op_Funds_on_Deposit_Institution_State9_Value" value="<?php if(isset($drfundsondeposit->Op_Funds_on_Deposit_Institution_City9)){ echo $drfundsondeposit->Op_Funds_on_Deposit_Institution_City9; } ?>">
                                    <select id="Op_Funds_on_Deposit_Institution_State9" name="Op_Funds_on_Deposit_Institution_State9" class="form-control 9_Op_state_select">
                                        <option value="">Choose State</option>
                                    </select>   
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Funds_on_Deposit_Institution_Acct_Num9">Account Number?</label>
                                    <input id="Op_Funds_on_Deposit_Institution_Acct_Num9" type="text" class="form-control 9_Op_fundsondeposit_inputs" name="Op_Funds_on_Deposit_Institution_Acct_Num9" value="<?php if(isset($drfundsondeposit->Op_Funds_on_Deposit_Institution_Acct_Num9)){ echo $drfundsondeposit->Op_Funds_on_Deposit_Institution_Acct_Num9; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Name on this account?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Op_Funds_on_Deposit_Institution_Name_on_Acct9_Client" name="Op_Funds_on_Deposit_Institution_Name_on_Acct9" value="{{$client_name}}" <?php if(isset($drfundsondeposit->Op_Funds_on_Deposit_Institution_Name_on_Acct9) && $drfundsondeposit->Op_Funds_on_Deposit_Institution_Name_on_Acct9==$client_name){ echo "checked"; } ?>> {{$client_name}}</label>
                                        <label><input type="radio" id="Op_Funds_on_Deposit_Institution_Name_on_Acct9_Op" name="Op_Funds_on_Deposit_Institution_Name_on_Acct9" value="{{$opponent_name}}" <?php if(isset($drfundsondeposit->Op_Funds_on_Deposit_Institution_Name_on_Acct9) && $drfundsondeposit->Op_Funds_on_Deposit_Institution_Name_on_Acct9==$opponent_name){ echo "checked"; } ?>> {{$opponent_name}}</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Funds_on_Deposit_Institution_Current_Balance9">Current Balance?</label>
                                    <input id="Op_Funds_on_Deposit_Institution_Current_Balance9" type="number" class="form-control 9_Op_fundsondeposit_inputs" name="Op_Funds_on_Deposit_Institution_Current_Balance9" value="<?php if(isset($drfundsondeposit->Op_Funds_on_Deposit_Institution_Current_Balance9)){ echo $drfundsondeposit->Op_Funds_on_Deposit_Institution_Current_Balance9; } ?>" min="0.00" step="0.01" max="999999.99" onchange="getClientOpCurrentBalance(this, '9', 'Op');" onkeyup="getClientOpCurrentBalance(this, '9', 'Op');"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Funds_on_Deposit_Institution_Yearly_Interest_Dividend9">Yearly Interest?</label>
                                    <input id="Op_Funds_on_Deposit_Institution_Yearly_Interest_Dividend9" type="number" class="form-control 9_Op_fundsondeposit_inputs" name="Op_Funds_on_Deposit_Institution_Yearly_Interest_Dividend9" value="<?php if(isset($drfundsondeposit->Op_Funds_on_Deposit_Institution_Yearly_Interest_Dividend9)){ echo $drfundsondeposit->Op_Funds_on_Deposit_Institution_Yearly_Interest_Dividend9; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Funds_on_Deposit_Institution_Balance_Date_of_Marriage9">Balance on marriage date (0.00, if started after marriage)?</label>
                                    <input id="Op_Funds_on_Deposit_Institution_Balance_Date_of_Marriage9" type="number" class="form-control 9_Op_fundsondeposit_inputs" name="Op_Funds_on_Deposit_Institution_Balance_Date_of_Marriage9" value="<?php if(isset($drfundsondeposit->Op_Funds_on_Deposit_Institution_Balance_Date_of_Marriage9)){ echo $drfundsondeposit->Op_Funds_on_Deposit_Institution_Balance_Date_of_Marriage9; } ?>" min="0.00" step="0.01" max="999999.99" onchange="getClientOpCurrentBalance(this, '9', 'Op');" onkeyup="getClientOpCurrentBalance(this, '9', 'Op');"> 
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label for="Op_Funds_on_Deposit_Estimated_MaritalEquity9">N/A, calculated = Op_Funds_on_Deposit_Institution_Current_Balance9 – Op_Funds_on_Deposit_Institution_Balance_Date_of_Marriage9</label>
                                    <input id="Op_Funds_on_Deposit_Estimated_MaritalEquity9" type="number" class="form-control 9_Op_fundsondeposit_inputs" name="Op_Funds_on_Deposit_Estimated_MaritalEquity9" value="<?php if(isset($drfundsondeposit->Op_Funds_on_Deposit_Estimated_MaritalEquity9)){ echo $drfundsondeposit->Op_Funds_on_Deposit_Estimated_MaritalEquity9; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Does either party claim a sole/separate interest from the other on this fund?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Op_Funds_on_Deposit_SoleSeparate_Claim9_Yes" name="Op_Funds_on_Deposit_SoleSeparate_Claim9" value="Yes" <?php if(isset($drfundsondeposit->Op_Funds_on_Deposit_SoleSeparate_Claim9) && $drfundsondeposit->Op_Funds_on_Deposit_SoleSeparate_Claim9=='Yes'){ echo "checked"; } ?>> Yes</label>
                                        <label><input type="radio" id="Op_Funds_on_Deposit_SoleSeparate_Claim9_No" name="Op_Funds_on_Deposit_SoleSeparate_Claim9" value="No" <?php if(isset($drfundsondeposit->Op_Funds_on_Deposit_SoleSeparate_Claim9) && $drfundsondeposit->Op_Funds_on_Deposit_SoleSeparate_Claim9=='No'){ echo "checked"; } ?>> No</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Who claims to own this fund?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Op_Funds_on_Deposit_SoleSeparate_Party9_Client" name="Op_Funds_on_Deposit_SoleSeparate_Party9" value="{{$client_name}}" <?php if(isset($drfundsondeposit->Op_Funds_on_Deposit_SoleSeparate_Party9) && $drfundsondeposit->Op_Funds_on_Deposit_SoleSeparate_Party9==$client_name){ echo "checked"; } ?>> {{$client_name}}</label>
                                        <label><input type="radio" id="Op_Funds_on_Deposit_SoleSeparate_Party9_Op" name="Op_Funds_on_Deposit_SoleSeparate_Party9" value="{{$opponent_name}}" <?php if(isset($drfundsondeposit->Op_Funds_on_Deposit_SoleSeparate_Party9) && $drfundsondeposit->Op_Funds_on_Deposit_SoleSeparate_Party9==$opponent_name){ echo "checked"; } ?>> {{$opponent_name}}</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 left-clear">
                                    <label for="Op_Funds_on_Deposit_SoleSeparate_Grounds9">Why does this person own this fund solely and separately?</label>
                                    <input id="Op_Funds_on_Deposit_SoleSeparate_Grounds9" type="text" class="form-control 9_Op_fundsondeposit_inputs" name="Op_Funds_on_Deposit_SoleSeparate_Grounds9" value="<?php if(isset($drfundsondeposit->Op_Funds_on_Deposit_SoleSeparate_Grounds9)){ echo $drfundsondeposit->Op_Funds_on_Deposit_SoleSeparate_Grounds9; } ?>"> 
                                </div>
                                <!-- slider tool -->
                                <div class="form-group col-sm-6 m-auto slider-tool-main">
                                    <div class="row">
                                        <div class="col">{{$client_name}}</div>
                                        <div class="col text-right">{{$opponent_name}}</div>
                                    </div>
                                    <input id="9_Op_balance_range_selector" type="range" class="form-control slider-tool-input 9_Op_balance_range_selector" name="" value="<?php if(isset($drfundsondeposit->Op_Funds_on_Deposit_Percent_Marital_Equity_to_Op9)){ echo $drfundsondeposit->Op_Funds_on_Deposit_Percent_Marital_Equity_to_Op9; } ?>" min="0.00" step="0.01" max="100" onchange="updateBalanceInput(this.value, '9', 'Op');">
                                </div>
                                <div class="form-group col-sm-6 m-auto slider-tool-main">
                                    <div class="row justify-content-between">
                                        <div class="col selectorTool">
                                            <div class="left-col">
                                                <div class="client-info 9_Op_clientpercentage_div clientpercentage_div">
                                                    <?php if(isset($drfundsondeposit->Op_Funds_on_Deposit_Percent_Marital_Equity_to_Client9)){ echo $drfundsondeposit->Op_Funds_on_Deposit_Percent_Marital_Equity_to_Client9; } else {
                                                        echo "50.00";
                                                    } ?>%
                                                </div>
                                                <div class="client-info 9_Op_clientamount_div clientamount_div" style="clear: both;">
                                                    $<?php if(isset($drfundsondeposit->Op_Funds_on_Deposit_Estimated_Value_to_Client9)){ echo $drfundsondeposit->Op_Funds_on_Deposit_Estimated_Value_to_Client9; } ?>
                                                </div>
                                            </div>
                                            <label>To {{$client_name}}</label>
                                        </div>                                       
                                        <div class="col selectorTool selectorToolRight">
                                            <label>To {{$opponent_name}}</label>
                                            <div class="left-col right-col">
                                                <div class="client-info 9_Op_opponentpercentage_div opponentpercentage_div">
                                                    <?php if(isset($drfundsondeposit->Op_Funds_on_Deposit_Percent_Marital_Equity_to_Op9)){ echo $drfundsondeposit->Op_Funds_on_Deposit_Percent_Marital_Equity_to_Op9; } else {
                                                        echo "50.00";
                                                    } ?>%
                                                </div>
                                                <div class="client-info 9_Op_opponentamount_div opponentamount_div" style="clear: both;">
                                                    $<?php if(isset($drfundsondeposit->Op_Funds_on_Deposit_Estimated_Value_to_Op9)){ echo $drfundsondeposit->Op_Funds_on_Deposit_Estimated_Value_to_Op9; } ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 m-auto slider-tool-main">
                                    <label></label>
                                    <div class="w-100">
                                        <label><input type="radio" id="9_Op_Funds_on_Deposit_Estimated_Value_Select" name="9_Op_Funds_on_Deposit_Estimated_Value_Select_Reset" class="Funds_on_Deposit_Estimated_Value_Select_Reset" value="Save"> Save this Distribution of Deposit Account #9</label>
                                        <label><input type="radio" id="9_Op_Funds_on_Deposit_Estimated_Value_Reset" name="9_Op_Funds_on_Deposit_Estimated_Value_Select_Reset" class="Funds_on_Deposit_Estimated_Value_Select_Reset" value="Reset" onclick="resetBalanceInput(this, '9', 'Op');"> Reset to Default (50%)</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label>{{$client_name}} Deposite Equity Percent</label>
                                    <input id="Op_Funds_on_Deposit_Percent_Marital_Equity_to_Client9" type="number" class="form-control 9_Op_clientpercentage_input clientpercentage_input" name="Op_Funds_on_Deposit_Percent_Marital_Equity_to_Client9" value="<?php if(isset($drfundsondeposit->Op_Funds_on_Deposit_Percent_Marital_Equity_to_Client9)){ echo $drfundsondeposit->Op_Funds_on_Deposit_Percent_Marital_Equity_to_Client9; } ?>" min="0.00" step="0.01" max="100" readonly="">
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label>{{$client_name}} Deposite Equity Amount</label>
                                    <input id="Op_Funds_on_Deposit_Estimated_Value_to_Client9" type="number" class="form-control 9_Op_clientamount_input clientamount_input" name="Op_Funds_on_Deposit_Estimated_Value_to_Client9" value="<?php if(isset($drfundsondeposit->Op_Funds_on_Deposit_Estimated_Value_to_Client9)){ echo $drfundsondeposit->Op_Funds_on_Deposit_Estimated_Value_to_Client9; } ?>" min="0.00" step="0.01" max="999999.99" readonly="">
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label>{{$opponent_name}} Deposite Equity Percent</label>
                                    <input id="Op_Funds_on_Deposit_Percent_Marital_Equity_to_Op9" type="number" class="form-control 9_Op_opponentpercentage_input opponentpercentage_input" name="Op_Funds_on_Deposit_Percent_Marital_Equity_to_Op9" value="<?php if(isset($drfundsondeposit->Op_Funds_on_Deposit_Percent_Marital_Equity_to_Op9)){ echo $drfundsondeposit->Op_Funds_on_Deposit_Percent_Marital_Equity_to_Op9; } ?>" min="0.00" step="0.01" max="100" readonly="">
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label>{{$opponent_name}} Deposite Equity Amount</label>
                                    <input id="Op_Funds_on_Deposit_Estimated_Value_to_Op9" type="number" class="form-control 9_Op_opponentamount_input opponentamount_input" name="Op_Funds_on_Deposit_Estimated_Value_to_Op9" value="<?php if(isset($drfundsondeposit->Op_Funds_on_Deposit_Estimated_Value_to_Op9)){ echo $drfundsondeposit->Op_Funds_on_Deposit_Estimated_Value_to_Op9; } ?>" min="0.00" step="0.01" max="999999.99" readonly="">
                                </div>
                                <!-- end of slider tool -->
                            </div>
                            <div class="col-sm-12 mt-4 10_Op_fundsondeposit_section" style="display: none;"><h5 class="col-sm-12">Tenth Deposit Account Info</h5>
                                <div class="form-group col-sm-6">
                                    <p class="text-danger 10_Op_no-state-county-found" style="display: none;">No City, State, County found for this zipcode.</p>
                                    <label for="Op_Funds_on_Deposit_Institution_ZIP10">Deposit Institution Zip Code?</label>
                                    <input id="Op_Funds_on_Deposit_Institution_ZIP10" type="text" class="form-control 10_Op_fundsondeposit_inputs" name="Op_Funds_on_Deposit_Institution_ZIP10" value="<?php if(isset($drfundsondeposit->Op_Funds_on_Deposit_Institution_ZIP10)){ echo $drfundsondeposit->Op_Funds_on_Deposit_Institution_ZIP10; } ?>" data-onload="getCityStateForZip(this, '10', 'Op');" onkeyup="getCityStateForZip(this, '10', 'Op');"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Funds_on_Deposit_Institution_Name10">Name of Deposit Institution?</label>
                                    <input id="Op_Funds_on_Deposit_Institution_Name10" type="text" class="form-control 10_Op_fundsondeposit_inputs" name="Op_Funds_on_Deposit_Institution_Name10" value="<?php if(isset($drfundsondeposit->Op_Funds_on_Deposit_Institution_Name10)){ echo $drfundsondeposit->Op_Funds_on_Deposit_Institution_Name10; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Funds_on_Deposit_Institution_Street_Address10">Deposit Institution Street Address?</label>
                                    <input id="Op_Funds_on_Deposit_Institution_Street_Address10" type="text" class="form-control 10_Op_fundsondeposit_inputs" name="Op_Funds_on_Deposit_Institution_Street_Address10" value="<?php if(isset($drfundsondeposit->Op_Funds_on_Deposit_Institution_Street_Address10)){ echo $drfundsondeposit->Op_Funds_on_Deposit_Institution_Street_Address10; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Funds_on_Deposit_Institution_City10">Deposit Institution City?</label>
                                    <input type="hidden" name="" id="Op_Funds_on_Deposit_Institution_City10_Value" value="<?php if(isset($drfundsondeposit->Op_Funds_on_Deposit_Institution_City10)){ echo $drfundsondeposit->Op_Funds_on_Deposit_Institution_City10; } ?>">
                                    <select id="Op_Funds_on_Deposit_Institution_City10" name="Op_Funds_on_Deposit_Institution_City10" class="form-control 10_Op_city_select">
                                        <option value="">Choose City</option>
                                    </select>   
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Funds_on_Deposit_Institution_State10">Deposit Institution State?</label>
                                    <input type="hidden" name="" id="Op_Funds_on_Deposit_Institution_State10_Value" value="<?php if(isset($drfundsondeposit->Op_Funds_on_Deposit_Institution_City10)){ echo $drfundsondeposit->Op_Funds_on_Deposit_Institution_City10; } ?>">
                                    <select id="Op_Funds_on_Deposit_Institution_State10" name="Op_Funds_on_Deposit_Institution_State10" class="form-control 10_Op_state_select">
                                        <option value="">Choose State</option>
                                    </select>   
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Funds_on_Deposit_Institution_Acct_Num10">Account Number?</label>
                                    <input id="Op_Funds_on_Deposit_Institution_Acct_Num10" type="text" class="form-control 10_Op_fundsondeposit_inputs" name="Op_Funds_on_Deposit_Institution_Acct_Num10" value="<?php if(isset($drfundsondeposit->Op_Funds_on_Deposit_Institution_Acct_Num10)){ echo $drfundsondeposit->Op_Funds_on_Deposit_Institution_Acct_Num10; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Name on this account?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Op_Funds_on_Deposit_Institution_Name_on_Acct10_Client" name="Op_Funds_on_Deposit_Institution_Name_on_Acct10" value="{{$client_name}}" <?php if(isset($drfundsondeposit->Op_Funds_on_Deposit_Institution_Name_on_Acct10) && $drfundsondeposit->Op_Funds_on_Deposit_Institution_Name_on_Acct10==$client_name){ echo "checked"; } ?>> {{$client_name}}</label>
                                        <label><input type="radio" id="Op_Funds_on_Deposit_Institution_Name_on_Acct10_Op" name="Op_Funds_on_Deposit_Institution_Name_on_Acct10" value="{{$opponent_name}}" <?php if(isset($drfundsondeposit->Op_Funds_on_Deposit_Institution_Name_on_Acct10) && $drfundsondeposit->Op_Funds_on_Deposit_Institution_Name_on_Acct10==$opponent_name){ echo "checked"; } ?>> {{$opponent_name}}</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Funds_on_Deposit_Institution_Current_Balance10">Current Balance?</label>
                                    <input id="Op_Funds_on_Deposit_Institution_Current_Balance10" type="number" class="form-control 10_Op_fundsondeposit_inputs" name="Op_Funds_on_Deposit_Institution_Current_Balance10" value="<?php if(isset($drfundsondeposit->Op_Funds_on_Deposit_Institution_Current_Balance10)){ echo $drfundsondeposit->Op_Funds_on_Deposit_Institution_Current_Balance10; } ?>" min="0.00" step="0.01" max="999999.99" onchange="getClientOpCurrentBalance(this, '10', 'Op');" onkeyup="getClientOpCurrentBalance(this, '10', 'Op');"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Funds_on_Deposit_Institution_Yearly_Interest_Dividend10">Yearly Interest?</label>
                                    <input id="Op_Funds_on_Deposit_Institution_Yearly_Interest_Dividend10" type="number" class="form-control 10_Op_fundsondeposit_inputs" name="Op_Funds_on_Deposit_Institution_Yearly_Interest_Dividend10" value="<?php if(isset($drfundsondeposit->Op_Funds_on_Deposit_Institution_Yearly_Interest_Dividend10)){ echo $drfundsondeposit->Op_Funds_on_Deposit_Institution_Yearly_Interest_Dividend10; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Funds_on_Deposit_Institution_Balance_Date_of_Marriage10">Balance on marriage date (0.00, if started after marriage)?</label>
                                    <input id="Op_Funds_on_Deposit_Institution_Balance_Date_of_Marriage10" type="number" class="form-control 10_Op_fundsondeposit_inputs" name="Op_Funds_on_Deposit_Institution_Balance_Date_of_Marriage10" value="<?php if(isset($drfundsondeposit->Op_Funds_on_Deposit_Institution_Balance_Date_of_Marriage10)){ echo $drfundsondeposit->Op_Funds_on_Deposit_Institution_Balance_Date_of_Marriage10; } ?>" min="0.00" step="0.01" max="999999.99" onchange="getClientOpCurrentBalance(this, '10', 'Op');" onkeyup="getClientOpCurrentBalance(this, '10', 'Op');"> 
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label for="Op_Funds_on_Deposit_Estimated_MaritalEquity10">N/A, calculated = Op_Funds_on_Deposit_Institution_Current_Balance10 – Op_Funds_on_Deposit_Institution_Balance_Date_of_Marriage10</label>
                                    <input id="Op_Funds_on_Deposit_Estimated_MaritalEquity10" type="number" class="form-control 10_Op_fundsondeposit_inputs" name="Op_Funds_on_Deposit_Estimated_MaritalEquity10" value="<?php if(isset($drfundsondeposit->Op_Funds_on_Deposit_Estimated_MaritalEquity10)){ echo $drfundsondeposit->Op_Funds_on_Deposit_Estimated_MaritalEquity10; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Does either party claim a sole/separate interest from the other on this fund?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Op_Funds_on_Deposit_SoleSeparate_Claim10_Yes" name="Op_Funds_on_Deposit_SoleSeparate_Claim10" value="Yes" <?php if(isset($drfundsondeposit->Op_Funds_on_Deposit_SoleSeparate_Claim10) && $drfundsondeposit->Op_Funds_on_Deposit_SoleSeparate_Claim10=='Yes'){ echo "checked"; } ?>> Yes</label>
                                        <label><input type="radio" id="Op_Funds_on_Deposit_SoleSeparate_Claim10_No" name="Op_Funds_on_Deposit_SoleSeparate_Claim10" value="No" <?php if(isset($drfundsondeposit->Op_Funds_on_Deposit_SoleSeparate_Claim10) && $drfundsondeposit->Op_Funds_on_Deposit_SoleSeparate_Claim10=='No'){ echo "checked"; } ?>> No</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Who claims to own this fund?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Op_Funds_on_Deposit_SoleSeparate_Party10_Client" name="Op_Funds_on_Deposit_SoleSeparate_Party10" value="{{$client_name}}" <?php if(isset($drfundsondeposit->Op_Funds_on_Deposit_SoleSeparate_Party10) && $drfundsondeposit->Op_Funds_on_Deposit_SoleSeparate_Party10==$client_name){ echo "checked"; } ?>> {{$client_name}}</label>
                                        <label><input type="radio" id="Op_Funds_on_Deposit_SoleSeparate_Party10_Op" name="Op_Funds_on_Deposit_SoleSeparate_Party10" value="{{$opponent_name}}" <?php if(isset($drfundsondeposit->Op_Funds_on_Deposit_SoleSeparate_Party10) && $drfundsondeposit->Op_Funds_on_Deposit_SoleSeparate_Party10==$opponent_name){ echo "checked"; } ?>> {{$opponent_name}}</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 left-clear">
                                    <label for="Op_Funds_on_Deposit_SoleSeparate_Grounds10">Why does this person own this fund solely and separately?</label>
                                    <input id="Op_Funds_on_Deposit_SoleSeparate_Grounds10" type="text" class="form-control 10_Op_fundsondeposit_inputs" name="Op_Funds_on_Deposit_SoleSeparate_Grounds10" value="<?php if(isset($drfundsondeposit->Op_Funds_on_Deposit_SoleSeparate_Grounds10)){ echo $drfundsondeposit->Op_Funds_on_Deposit_SoleSeparate_Grounds10; } ?>"> 
                                </div>
                                <!-- slider tool -->
                                <div class="form-group col-sm-6 m-auto slider-tool-main">
                                    <div class="row">
                                        <div class="col">{{$client_name}}</div>
                                        <div class="col text-right">{{$opponent_name}}</div>
                                    </div>
                                    <input id="10_Op_balance_range_selector" type="range" class="form-control slider-tool-input 10_Op_balance_range_selector" name="" value="<?php if(isset($drfundsondeposit->Op_Funds_on_Deposit_Percent_Marital_Equity_to_Op10)){ echo $drfundsondeposit->Op_Funds_on_Deposit_Percent_Marital_Equity_to_Op10; } ?>" min="0.00" step="0.01" max="100" onchange="updateBalanceInput(this.value, '10', 'Op');">
                                </div>
                                <div class="form-group col-sm-6 m-auto slider-tool-main">
                                    <div class="row justify-content-between">
                                        <div class="col selectorTool">
                                            <div class="left-col">
                                                <div class="client-info 10_Op_clientpercentage_div clientpercentage_div">
                                                    <?php if(isset($drfundsondeposit->Op_Funds_on_Deposit_Percent_Marital_Equity_to_Client10)){ echo $drfundsondeposit->Op_Funds_on_Deposit_Percent_Marital_Equity_to_Client10; } else {
                                                        echo "50.00";
                                                    } ?>%
                                                </div>
                                                <div class="client-info 10_Op_clientamount_div clientamount_div" style="clear: both;">
                                                    $<?php if(isset($drfundsondeposit->Op_Funds_on_Deposit_Estimated_Value_to_Client10)){ echo $drfundsondeposit->Op_Funds_on_Deposit_Estimated_Value_to_Client10; } ?>
                                                </div>
                                            </div>
                                            <label>To {{$client_name}}</label>
                                        </div>                                       
                                        <div class="col selectorTool selectorToolRight">
                                            <label>To {{$opponent_name}}</label>
                                            <div class="left-col right-col">
                                                <div class="client-info 10_Op_opponentpercentage_div opponentpercentage_div">
                                                    <?php if(isset($drfundsondeposit->Op_Funds_on_Deposit_Percent_Marital_Equity_to_Op10)){ echo $drfundsondeposit->Op_Funds_on_Deposit_Percent_Marital_Equity_to_Op10; } else {
                                                        echo "50.00";
                                                    } ?>%
                                                </div>
                                                <div class="client-info 10_Op_opponentamount_div opponentamount_div" style="clear: both;">
                                                    $<?php if(isset($drfundsondeposit->Op_Funds_on_Deposit_Estimated_Value_to_Op10)){ echo $drfundsondeposit->Op_Funds_on_Deposit_Estimated_Value_to_Op10; } ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 m-auto slider-tool-main">
                                    <label></label>
                                    <div class="w-100">
                                        <label><input type="radio" id="10_Op_Funds_on_Deposit_Estimated_Value_Select" name="10_Op_Funds_on_Deposit_Estimated_Value_Select_Reset" class="Funds_on_Deposit_Estimated_Value_Select_Reset" value="Save"> Save this Distribution of Deposit Account #10</label>
                                        <label><input type="radio" id="10_Op_Funds_on_Deposit_Estimated_Value_Reset" name="10_Op_Funds_on_Deposit_Estimated_Value_Select_Reset" class="Funds_on_Deposit_Estimated_Value_Select_Reset" value="Reset" onclick="resetBalanceInput(this, '10', 'Op');"> Reset to Default (50%)</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label>{{$client_name}} Deposite Equity Percent</label>
                                    <input id="Op_Funds_on_Deposit_Percent_Marital_Equity_to_Client10" type="number" class="form-control 10_Op_clientpercentage_input clientpercentage_input" name="Op_Funds_on_Deposit_Percent_Marital_Equity_to_Client10" value="<?php if(isset($drfundsondeposit->Op_Funds_on_Deposit_Percent_Marital_Equity_to_Client10)){ echo $drfundsondeposit->Op_Funds_on_Deposit_Percent_Marital_Equity_to_Client10; } ?>" min="0.00" step="0.01" max="100" readonly="">
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label>{{$client_name}} Deposite Equity Amount</label>
                                    <input id="Op_Funds_on_Deposit_Estimated_Value_to_Client10" type="number" class="form-control 10_Op_clientamount_input clientamount_input" name="Op_Funds_on_Deposit_Estimated_Value_to_Client10" value="<?php if(isset($drfundsondeposit->Op_Funds_on_Deposit_Estimated_Value_to_Client10)){ echo $drfundsondeposit->Op_Funds_on_Deposit_Estimated_Value_to_Client10; } ?>" min="0.00" step="0.01" max="999999.99" readonly="">
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label>{{$opponent_name}} Deposite Equity Percent</label>
                                    <input id="Op_Funds_on_Deposit_Percent_Marital_Equity_to_Op10" type="number" class="form-control 10_Op_opponentpercentage_input opponentpercentage_input" name="Op_Funds_on_Deposit_Percent_Marital_Equity_to_Op10" value="<?php if(isset($drfundsondeposit->Op_Funds_on_Deposit_Percent_Marital_Equity_to_Op10)){ echo $drfundsondeposit->Op_Funds_on_Deposit_Percent_Marital_Equity_to_Op10; } ?>" min="0.00" step="0.01" max="100" readonly="">
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label>{{$opponent_name}} Deposite Equity Amount</label>
                                    <input id="Op_Funds_on_Deposit_Estimated_Value_to_Op10" type="number" class="form-control 10_Op_opponentamount_input opponentamount_input" name="Op_Funds_on_Deposit_Estimated_Value_to_Op10" value="<?php if(isset($drfundsondeposit->Op_Funds_on_Deposit_Estimated_Value_to_Op10)){ echo $drfundsondeposit->Op_Funds_on_Deposit_Estimated_Value_to_Op10; } ?>" min="0.00" step="0.01" max="999999.99" readonly="">
                                </div>
                                <!-- end of slider tool -->
                            </div>

                        </div>
                        <!-- End of Opponent Funds On Deposit Info Section -->
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
    // If there is any Funds On Deposite
    function getAnyFOD(fodcheck){
        if(fodcheck.checked){
            $('#Num_Joint_Deposit_Accounts, #Num_Client_Deposit_Accounts, #Num_Op_Deposit_Accounts').val('0');
            $('.num_Joint_fundsondeposit_info, .num_Client_fundsondeposit_info, .num_Op_fundsondeposit_info').show();
        } else {
            $('.num_Joint_fundsondeposit_info, .num_Client_fundsondeposit_info, .num_Op_fundsondeposit_info').hide();
            $('#Num_Joint_Deposit_Accounts, #Num_Client_Deposit_Accounts, #Num_Op_Deposit_Accounts').val('0');
            $('.Joint_fundsondeposit_info_section input, .Client_fundsondeposit_section input, .Opponent_fundsondeposit_section input').prop('required',false);
            $('.Joint_fundsondeposit_info_section select option[value=""], .Client_fundsondeposit_section select option[value=""], .Opponent_fundsondeposit_section select option[value=""]').prop('selected','selected');
            $('.1_Joint_fundsondeposit_section, .2_Joint_fundsondeposit_section, .3_Joint_fundsondeposit_section, .4_Joint_fundsondeposit_section, .5_Joint_fundsondeposit_section, .6_Joint_fundsondeposit_section, .7_Joint_fundsondeposit_section, .8_Joint_fundsondeposit_section, .9_Joint_fundsondeposit_section, .10_Joint_fundsondeposit_section').hide();
            $('.1_Client_fundsondeposit_section, .2_Client_fundsondeposit_section, .3_Client_fundsondeposit_section, .4_Client_fundsondeposit_section, .5_Client_fundsondeposit_section, .6_Client_fundsondeposit_section, .7_Client_fundsondeposit_section, .8_Client_fundsondeposit_section, .9_Client_fundsondeposit_section, .10_Client_fundsondeposit_section').hide();
            $('.1_Op_fundsondeposit_section, .2_Op_fundsondeposit_section, .3_Op_fundsondeposit_section, .4_Op_fundsondeposit_section, .5_Op_fundsondeposit_section, .6_Op_fundsondeposit_section, .7_Op_fundsondeposit_section, .8_Op_fundsondeposit_section, .9_Op_fundsondeposit_section, .10_Op_fundsondeposit_section').hide();
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

                            var slctd_city=$('#'+ziptype+'_Funds_on_Deposit_Institution_City'+zipinputnum+'_Value').val();
                            if(slctd_city){
                                $('.'+zipclass+'_city_select option[value="'+slctd_city+'"]').attr('selected','selected');
                            }

                            var slctd_state=$('#'+ziptype+'_Funds_on_Deposit_Institution_State'+zipinputnum+'_Value').val();
                            if(slctd_state){
                                $('.'+zipclass+'_state_select option[value="'+slctd_state+'"]').attr('selected','selected');
                            }
                            $('.'+zipclass+'_no-state-county-found').hide();
                        }
                    }
                });        
            }

        }


        function getJointCurrentBalance(balance, balanceclass){
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

        function getClientOpCurrentBalance(balance, balancenum, balancetype){
             $('.'+balancenum+'_'+balancetype+'_balance_range_selector, .'+balancenum+'_'+balancetype+'_opponentpercentage_input, .'+balancenum+'_'+balancetype+'_clientpercentage_input').val('50.00');
            $('.'+balancenum+'_'+balancetype+'_opponentpercentage_div, .'+balancenum+'_'+balancetype+'_clientpercentage_div').text('50.00%');
            var current_balance=$('#'+balancetype+'_Funds_on_Deposit_Institution_Current_Balance'+balancenum+'').val();
            var marriage_balance=$('#'+balancetype+'_Funds_on_Deposit_Institution_Balance_Date_of_Marriage'+balancenum+'').val();
            if(current_balance){
                current_balance=parseFloat(current_balance).toFixed(2);
            } else {
                current_balance=0;
            }
            if(marriage_balance){
                marriage_balance=parseFloat(marriage_balance).toFixed(2);
            } else {
                marriage_balance=0;
            }
            var total_balance=(current_balance) - (marriage_balance);
            total_balance=parseFloat(total_balance).toFixed(2);
            var client_balance_amount=total_balance/2;
            var opponent_balance_amount=total_balance/2;
            client_balance_amount=parseFloat(client_balance_amount).toFixed(2);
            opponent_balance_amount=parseFloat(opponent_balance_amount).toFixed(2);
            $('.'+balancenum+'_'+balancetype+'_clientamount_input').val(client_balance_amount);
            $('.'+balancenum+'_'+balancetype+'_opponentamount_input').val(opponent_balance_amount);
            $('.'+balancenum+'_'+balancetype+'_clientamount_div').text(formatter.format(client_balance_amount));
            $('.'+balancenum+'_'+balancetype+'_opponentamount_div').text(formatter.format(opponent_balance_amount));
        }


        function resetBalanceInput(value, balancenum, balancetype){
            var sliderclass=balancenum+'_'+balancetype;
            $('.'+sliderclass+'_balance_range_selector, .'+sliderclass+'_opponentpercentage_input, .'+sliderclass+'_clientpercentage_input').val('50.00');
            $('.'+sliderclass+'_opponentpercentage_div, .'+sliderclass+'_clientpercentage_div').text('50.00%');
            if(balancetype=='Joint'){
                var joint_balance=$('#'+balancetype+'_Funds_on_Deposit_Institution_Current_Balance'+balancenum+'').val();
            } else {
                var current_balance=$('#'+balancetype+'_Funds_on_Deposit_Institution_Current_Balance'+balancenum+'').val();
                var marriage_balance=$('#'+balancetype+'_Funds_on_Deposit_Institution_Balance_Date_of_Marriage'+balancenum+'').val();
                if(current_balance){
                    current_balance=parseFloat(current_balance).toFixed(2);
                } else {
                    current_balance=0;
                }
                if(marriage_balance){
                    marriage_balance=parseFloat(marriage_balance).toFixed(2);
                } else {
                    marriage_balance=0;
                }
                var joint_balance=(current_balance) - (marriage_balance);
            }
            joint_balance=parseFloat(joint_balance).toFixed(2);
            client_balance=joint_balance/2;
            client_balance=parseFloat(client_balance).toFixed(2);
            $('.'+sliderclass+'_clientamount_input').val(client_balance);
            $('.'+sliderclass+'_opponentamount_input').val(client_balance);
            $('.'+sliderclass+'_clientamount_div').text(formatter.format(client_balance));
            $('.'+sliderclass+'_opponentamount_div').text(formatter.format(client_balance));

        }

        function updateBalanceInput(value, balancenum, balancetype){
            var sliderclass=balancenum+'_'+balancetype;
            if(value <= 100){
                var value=parseFloat(value).toFixed(2);
                if(balancetype=='Joint'){
                    var joint_balance=$('#'+balancetype+'_Funds_on_Deposit_Institution_Current_Balance'+balancenum+'').val();
                } else {
                    var current_balance=$('#'+balancetype+'_Funds_on_Deposit_Institution_Current_Balance'+balancenum+'').val();
                    var marriage_balance=$('#'+balancetype+'_Funds_on_Deposit_Institution_Balance_Date_of_Marriage'+balancenum+'').val();
                    if(current_balance){
                        current_balance=parseFloat(current_balance).toFixed(2);
                    } else {
                        current_balance=0;
                    }
                    if(marriage_balance){
                        marriage_balance=parseFloat(marriage_balance).toFixed(2);
                    } else {
                        marriage_balance=0;
                    }
                    var joint_balance=(current_balance) - (marriage_balance);
                }
                $('.'+sliderclass+'_opponentpercentage_input').val(value);
                $('.'+sliderclass+'_opponentpercentage_div').text(value+'%');
                var client_balance_percentage_new=100-value;
                client_balance_percentage_new=parseFloat(client_balance_percentage_new).toFixed(2);
                $('.'+sliderclass+'_clientpercentage_input').val(client_balance_percentage_new);
                $('.'+sliderclass+'_clientpercentage_div').text(client_balance_percentage_new+'%');
                joint_balance=parseFloat(joint_balance);
                var client_balance_amount_new = joint_balance - (joint_balance * value/100);
                var op_balance_amount_new = joint_balance - (joint_balance * client_balance_percentage_new/100);
                op_balance_amount_new=parseFloat(op_balance_amount_new).toFixed(2);
                client_balance_amount_new=parseFloat(client_balance_amount_new).toFixed(2);
                $('.'+sliderclass+'_opponentamount_input').val(op_balance_amount_new);
                $('.'+sliderclass+'_clientamount_input').val(client_balance_amount_new);
                $('.'+sliderclass+'_opponentamount_div').text(formatter.format(op_balance_amount_new));
                $('.'+sliderclass+'_clientamount_div').text(formatter.format(client_balance_amount_new));
            }
        }
        
        const formatter = new Intl.NumberFormat('en-US', {
          style: 'currency',
          currency: 'USD',
          minimumFractionDigits: 2
        });

    $(document).ready(function(){

        $('#dr_FundsOnDeposit').validate();
        $(window).keydown(function(event){
            if(event.keyCode == 13) {
              event.preventDefault();
              return false;
            }
        });

        /* Find any element which has a 'data-onload' function and load that to simulate an onload. */
        $('[data-onload]').each(function(){
            eval($(this).data('onload'));
        });

        var any_fodcheck=$('#Any_FOD');
        if(any_fodcheck.prop("checked") == true){
            $('.num_Joint_fundsondeposit_info, .num_Client_fundsondeposit_info, .num_Op_fundsondeposit_info').show();
        } else {
            $('.num_Joint_fundsondeposit_info, .num_Client_fundsondeposit_info, .num_Op_fundsondeposit_info').hide();
            $('#Num_Joint_Deposit_Accounts, #Num_Client_Deposit_Accounts, #Num_Op_Deposit_Accounts').val('0');
            $('.Joint_fundsondeposit_info_section input, .Client_fundsondeposit_section input, .Opponent_fundsondeposit_section input').prop('required',false);
            $('.Joint_fundsondeposit_info_section select option[value=""], .Client_fundsondeposit_section select option[value=""], .Opponent_fundsondeposit_section select option[value=""]').prop('selected','selected');
            $('.1_Joint_fundsondeposit_section, .2_Joint_fundsondeposit_section, .3_Joint_fundsondeposit_section, .4_Joint_fundsondeposit_section, .5_Joint_fundsondeposit_section, .6_Joint_fundsondeposit_section, .7_Joint_fundsondeposit_section, .8_Joint_fundsondeposit_section, .9_Joint_fundsondeposit_section, .10_Joint_fundsondeposit_section').hide();
            $('.1_Client_fundsondeposit_section, .2_Client_fundsondeposit_section, .3_Client_fundsondeposit_section, .4_Client_fundsondeposit_section, .5_Client_fundsondeposit_section, .6_Client_fundsondeposit_section, .7_Client_fundsondeposit_section, .8_Client_fundsondeposit_section, .9_Client_fundsondeposit_section, .10_Client_fundsondeposit_section').hide();
            $('.1_Op_fundsondeposit_section, .2_Op_fundsondeposit_section, .3_Op_fundsondeposit_section, .4_Op_fundsondeposit_section, .5_Op_fundsondeposit_section, .6_Op_fundsondeposit_section, .7_Op_fundsondeposit_section, .8_Op_fundsondeposit_section, .9_Op_fundsondeposit_section, .10_Op_fundsondeposit_section').hide();
        }
        
        // on number of joint monthly debts creditors input change
        $('.1_Joint_fundsondeposit_section, .2_Joint_fundsondeposit_section, .3_Joint_fundsondeposit_section, .4_Joint_fundsondeposit_section, .5_Joint_fundsondeposit_section, .6_Joint_fundsondeposit_section, .7_Joint_fundsondeposit_section, .8_Joint_fundsondeposit_section, .9_Joint_fundsondeposit_section, .10_Joint_fundsondeposit_section').hide();
        
        if($('#Num_Joint_Deposit_Accounts').val() > 0 &&  $('#Num_Joint_Deposit_Accounts').val() <= 10 ){
            for (var i = 1; i <= $('#Num_Joint_Deposit_Accounts').val(); i++) {
                $('.'+i+'_Joint_fundsondeposit_section').show();
                $('.'+i+'_Joint_fundsondeposit_section input').first().prop('required',true);
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
        var val=parseInt($('#Num_Joint_Deposit_Accounts').val())+1;
        for (var i = val; i <= 10; i++) {
            $('.'+i+'_Joint_fundsondeposit_section input').prop('required',false);
            $('.'+i+'_Joint_fundsondeposit_section select option[value=""]').prop('selected','selected');
        }


        $('#Num_Joint_Deposit_Accounts').on('change keyup', function(){
            $('.1_Joint_fundsondeposit_section, .2_Joint_fundsondeposit_section, .3_Joint_fundsondeposit_section, .4_Joint_fundsondeposit_section, .5_Joint_fundsondeposit_section, .6_Joint_fundsondeposit_section, .7_Joint_fundsondeposit_section, .8_Joint_fundsondeposit_section, .9_Joint_fundsondeposit_section, .10_Joint_fundsondeposit_section').hide();
            if(this.value > 0 &&  this.value <= 10 ){
                for (var i = 1; i <= this.value; i++) {
                    $('.'+i+'_Joint_fundsondeposit_section').show();
                    $('.'+i+'_Joint_fundsondeposit_section input').first().prop('required',true);
                }
            }
            var val=parseInt(this.value)+1;
            for (var i = val; i <= 10; i++) {
                $('.'+i+'_Joint_fundsondeposit_section input').prop('required',false);
                $('.'+i+'_Joint_fundsondeposit_section select option[value=""]').prop('selected','selected');
            }
        });
        // on number of client monthly debts creditors input change
        $('.1_Client_fundsondeposit_section, .2_Client_fundsondeposit_section, .3_Client_fundsondeposit_section, .4_Client_fundsondeposit_section, .5_Client_fundsondeposit_section, .6_Client_fundsondeposit_section, .7_Client_fundsondeposit_section, .8_Client_fundsondeposit_section, .9_Client_fundsondeposit_section, .10_Client_fundsondeposit_section').hide();
        if($('#Num_Client_Deposit_Accounts').val() > 0 &&  $('#Num_Client_Deposit_Accounts').val() <= 10 ){
            for (var i = 1; i <= $('#Num_Client_Deposit_Accounts').val(); i++) {
                $('.'+i+'_Client_fundsondeposit_section').show();
                $('.'+i+'_Client_fundsondeposit_section input').first().prop('required',true);
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
        var val=parseInt($('#Num_Client_Deposit_Accounts').val())+1;
        for (var i = val; i <= 10; i++) {
            $('.'+i+'_Client_fundsondeposit_section input').prop('required',false);
            $('.'+i+'_Client_fundsondeposit_section select option[value=""]').prop('selected','selected');
        }

        $('#Num_Client_Deposit_Accounts').on('change keyup', function(){
            $('.1_Client_fundsondeposit_section, .2_Client_fundsondeposit_section, .3_Client_fundsondeposit_section, .4_Client_fundsondeposit_section, .5_Client_fundsondeposit_section, .6_Client_fundsondeposit_section, .7_Client_fundsondeposit_section, .8_Client_fundsondeposit_section, .9_Client_fundsondeposit_section, .10_Client_fundsondeposit_section').hide();
            if(this.value > 0 &&  this.value <= 10 ){
                for (var i = 1; i <= this.value; i++) {
                    $('.'+i+'_Client_fundsondeposit_section').show();
                    $('.'+i+'_Client_fundsondeposit_section input').first().prop('required',true);
                }
            }
            var val=parseInt(this.value)+1;
            for (var i = val; i <= 10; i++) {
                $('.'+i+'_Client_fundsondeposit_section input').prop('required',false);
                $('.'+i+'_Client_fundsondeposit_section select option[value=""]').prop('selected','selected');
            }
        });
        // on number of opponent monthly debts creditors input change
        $('.1_Op_fundsondeposit_section, .2_Op_fundsondeposit_section, .3_Op_fundsondeposit_section, .4_Op_fundsondeposit_section, .5_Op_fundsondeposit_section, .6_Op_fundsondeposit_section, .7_Op_fundsondeposit_section, .8_Op_fundsondeposit_section, .9_Op_fundsondeposit_section, .10_Op_fundsondeposit_section').hide();
        if($('#Num_Op_Deposit_Accounts').val() > 0 &&  $('#Num_Op_Deposit_Accounts').val() <= 10 ){
            for (var i = 1; i <= $('#Num_Op_Deposit_Accounts').val(); i++) {
                $('.'+i+'_Op_fundsondeposit_section').show();
                $('.'+i+'_Op_fundsondeposit_section input').first().prop('required',true);
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
        var val=parseInt($('#Num_Op_Deposit_Accounts').val())+1;
        for (var i = val; i <= 10; i++) {
            $('.'+i+'_Op_fundsondeposit_section input').prop('required',false);
            $('.'+i+'_Op_fundsondeposit_section select option[value=""]').prop('selected','selected');
        }
        $('#Num_Op_Deposit_Accounts').on('change keyup', function(){
            $('.1_Op_fundsondeposit_section, .2_Op_fundsondeposit_section, .3_Op_fundsondeposit_section, .4_Op_fundsondeposit_section, .5_Op_fundsondeposit_section, .6_Op_fundsondeposit_section, .7_Op_fundsondeposit_section, .8_Op_fundsondeposit_section, .9_Op_fundsondeposit_section, .10_Op_fundsondeposit_section').hide();
            if(this.value > 0 &&  this.value <= 10 ){
                for (var i = 1; i <= this.value; i++) {
                    $('.'+i+'_Op_fundsondeposit_section').show();
                    $('.'+i+'_Op_fundsondeposit_section input').first().prop('required',true);
                }
            }
            var val=parseInt(this.value)+1;
            for (var i = val; i <= 10; i++) {
                $('.'+i+'_Op_fundsondeposit_section input').prop('required',false);
                $('.'+i+'_Op_fundsondeposit_section select option[value=""]').prop('selected','selected');
            }
        });
    });
</script>   
@endsection