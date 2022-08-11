@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center dr_RealEstate_main dr_Tables_main">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header"><strong>{{ __('Update Real Estate Info') }}</strong>
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
                    <form role="form" id="dr_RealEstate" method="POST" action="{{route('drrealestate.update',['id'=>$drrealestate->id])}}" autocomplete="off">
                        @csrf
                        @method('put')
                        <input id="" type="hidden" class="form-control" name="case_id" value="{{$case_id}}">
                        <div class="form-row Any_Real_Estate">
                            <div class="form-group col-sm-12">
                                <label></label>
                                <div class="w-100 dataInput">
                                     <label><input type="checkbox" id="Any_Real_Estate" name="Any_Real_Estate" value="1" onchange="getAnyRealEstate(this);" <?php if(isset($drrealestate->Any_Real_Estate) && $drrealestate->Any_Real_Estate=='1'){ echo "checked"; } ?>> Check if any Real Estate is Owned by {{$client_name}} and/or {{$opponent_name}}?</label>
                                </div>
                            </div>
                        </div>
                        <!-- Joint Real Estate Info Section -->
                        <div class="form-row num_Joint_realestate" style="display: none;">
                            <h4 class="col-sm-12">Joint Real Estate Info Section</h4>
                            <div class="col-sm-6">
                                <label for="Num_Joint_Real_Estate_Properties">How many Real Estate Properties are owned in BOTH Parties’ Names</label>
                                <input id="Num_Joint_Real_Estate_Properties" type="number" class="form-control" name="Num_Joint_Real_Estate_Properties" value="<?php if(isset($drrealestate->Num_Joint_Real_Estate_Properties)){ echo $drrealestate->Num_Joint_Real_Estate_Properties; } ?>" min="0" max="5"> 
                            </div>
                        </div>
                        <div class="form-row Joint_realestate_section">
                            <div class="col-sm-12 mt-4 1_Joint_realestate_section" style="display: none;"><h5 class="col-sm-12">First Real Estate Info</h5>
                                <div class="form-group col-sm-6">
                                    <p class="text-danger 1_Joint_no-state-county-found" style="display: none;">No City, State, County found for this zipcode.</p>
                                    <label for="Joint_Real_Estate_ZIP1">ZIP code of this Property?</label>
                                    <input id="Joint_Real_Estate_ZIP1" type="text" class="form-control 1_Joint_realestate_inputs" name="Joint_Real_Estate_ZIP1" value="<?php if(isset($drrealestate->Joint_Real_Estate_ZIP1)){ echo $drrealestate->Joint_Real_Estate_ZIP1; } ?>" data-onload="getCityStateForZip(this, '1', 'Joint');" onkeyup="getCityStateForZip(this, '1', 'Joint');"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_Real_Estate_Street_Address1">This Property Street Address?</label>
                                    <input id="Joint_Real_Estate_Street_Address1" type="text" class="form-control 1_Joint_realestate_inputs" name="Joint_Real_Estate_Street_Address1" value="<?php if(isset($drrealestate->Joint_Real_Estate_Street_Address1)){ echo $drrealestate->Joint_Real_Estate_Street_Address1; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_Real_Estate_City1">This Property City?</label>
                                    <input type="hidden" name="" id="Joint_Real_Estate_Institution_City1_Value" value="<?php if(isset($drrealestate->Joint_Real_Estate_City1)){ echo $drrealestate->Joint_Real_Estate_City1; } ?>">
                                    <select id="Joint_Real_Estate_City1" name="Joint_Real_Estate_City1" class="form-control 1_Joint_city_select">
                                        <option value="">Choose City</option>
                                    </select>   
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_Real_Estate_State1">This Property State?</label>
                                    <input type="hidden" name="" id="Joint_Real_Estate_Institution_State1_Value" value="<?php if(isset($drrealestate->Joint_Real_Estate_State1)){ echo $drrealestate->Joint_Real_Estate_State1; } ?>">
                                    <select id="Joint_Real_Estate_State1" name="Joint_Real_Estate_State1" class="form-control 1_Joint_state_select">
                                        <option value="">Choose State</option>
                                    </select>   
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_Real_Estate_Current_Value1">Current Value?</label>
                                    <input id="Joint_Real_Estate_Current_Value1" type="number" class="form-control 1_Joint_realestate_inputs" name="Joint_Real_Estate_Current_Value1" value="<?php if(isset($drrealestate->Joint_Real_Estate_Current_Value1)){ echo $drrealestate->Joint_Real_Estate_Current_Value1; } ?>" min="0.00" step="0.01" max="999999.99" onchange="getJointCurrentValue(this, '1', 'Joint');" onkeyup="getJointCurrentValue(this, '1', 'Joint');"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_Real_Estate_First_Mortgage_Company_Name1">Name of First Mortgage/Loan Company for this Property?</label>
                                    <input id="Joint_Real_Estate_First_Mortgage_Company_Name1" type="text" class="form-control 1_Joint_realestate_inputs" name="Joint_Real_Estate_First_Mortgage_Company_Name1" value="<?php if(isset($drrealestate->Joint_Real_Estate_First_Mortgage_Company_Name1)){ echo $drrealestate->Joint_Real_Estate_First_Mortgage_Company_Name1; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_Real_Estate_First_Mortgage_Balance1">Balance owed on First Mortgage/Loan for this Property?</label>
                                    <input id="Joint_Real_Estate_First_Mortgage_Balance1" type="number" class="form-control 1_Joint_realestate_inputs" name="Joint_Real_Estate_First_Mortgage_Balance1" value="<?php if(isset($drrealestate->Joint_Real_Estate_First_Mortgage_Balance1)){ echo $drrealestate->Joint_Real_Estate_First_Mortgage_Balance1; } ?>" onchange="getMaritalEquity(this, '1', 'Joint');" onkeyup="getMaritalEquity(this, '1', 'Joint');" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_Real_Estate_First_Mortgage_Monthly_Payment1">Monthly payment for First Mortgage/Loan for this Property?</label>
                                    <input id="Joint_Real_Estate_First_Mortgage_Monthly_Payment1" type="number" class="form-control 1_Joint_realestate_inputs" name="Joint_Real_Estate_First_Mortgage_Monthly_Payment1" value="<?php if(isset($drrealestate->Joint_Real_Estate_First_Mortgage_Monthly_Payment1)){ echo $drrealestate->Joint_Real_Estate_First_Mortgage_Monthly_Payment1; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_Real_Estate_Second_Mortgage_LOC_Company_Name1">Name of Second Mortgage/Loan Company for this Property?</label>
                                    <input id="Joint_Real_Estate_Second_Mortgage_LOC_Company_Name1" type="text" class="form-control 1_Joint_realestate_inputs" name="Joint_Real_Estate_Second_Mortgage_LOC_Company_Name1" value="<?php if(isset($drrealestate->Joint_Real_Estate_Second_Mortgage_LOC_Company_Name1)){ echo $drrealestate->Joint_Real_Estate_Second_Mortgage_LOC_Company_Name1; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_Real_Estate_Second_Mortgage_LOC_Balance1">Balance owed on Second Mortgage/Loan for this Property?</label>
                                    <input id="Joint_Real_Estate_Second_Mortgage_LOC_Balance1" type="number" class="form-control 1_Joint_realestate_inputs" name="Joint_Real_Estate_Second_Mortgage_LOC_Balance1" value="<?php if(isset($drrealestate->Joint_Real_Estate_Second_Mortgage_LOC_Balance1)){ echo $drrealestate->Joint_Real_Estate_Second_Mortgage_LOC_Balance1; } ?>" onchange="getMaritalEquity(this, '1', 'Joint');" onkeyup="getMaritalEquity(this, '1', 'Joint');" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_Real_Estate_Second_Mortgage_LOC_Monthly_Payment1">Monthly payment for Second Mortgage/Loan for this Property?</label>
                                    <input id="Joint_Real_Estate_Second_Mortgage_LOC_Monthly_Payment1" type="number" class="form-control 1_Joint_realestate_inputs" name="Joint_Real_Estate_Second_Mortgage_LOC_Monthly_Payment1" value="<?php if(isset($drrealestate->Joint_Real_Estate_Second_Mortgage_LOC_Monthly_Payment1)){ echo $drrealestate->Joint_Real_Estate_Second_Mortgage_LOC_Monthly_Payment1; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_Real_Estate_MaritalEquity1">Marital Equity</label>
                                    <input id="Joint_Real_Estate_MaritalEquity1" type="number" class="form-control 1_Joint_realestate_inputs" name="Joint_Real_Estate_MaritalEquity1" readonly value="<?php if(isset($drrealestate->Joint_Real_Estate_MaritalEquity1)){ echo $drrealestate->Joint_Real_Estate_MaritalEquity1; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Is this Property a Rental/Investment Property?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Joint_Real_Estate_Rental1_Yes" name="Joint_Real_Estate_Rental1" value="Yes" data-onload="getInitialRentalProperty(this, '1', 'Joint');" onchange="getRentalProperty(this, '1', 'Joint');" <?php if(isset($drrealestate->Joint_Real_Estate_Rental1) && $drrealestate->Joint_Real_Estate_Rental1=='Yes'){ echo "checked"; $hide='style="display: none;"'; } ?>> Yes</label>
                                        <label><input type="radio" id="Joint_Real_Estate_Rental1_No" name="Joint_Real_Estate_Rental1" value="No" data-onload="getInitialRentalProperty(this, '1', 'Joint');" onchange="getRentalProperty(this, '1', 'Joint');" <?php if(isset($drrealestate->Joint_Real_Estate_Rental1) && $drrealestate->Joint_Real_Estate_Rental1=='No'){ echo "checked"; $hide=''; } ?>> No</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_Real_Estate_Yearly_Net_Rental_Income1">Joint Real Estate Yearly Net Rental Income1</label>
                                    <input id="Joint_Real_Estate_Yearly_Net_Rental_Income1" type="number" class="form-control 1_Joint_realestate_inputs" name="Joint_Real_Estate_Yearly_Net_Rental_Income1" onchange="getYearlyNetRentalIncome(this, '1', 'Joint');" onkeyup="getYearlyNetRentalIncome(this, '1', 'Joint');" value="<?php if(isset($drrealestate->Joint_Real_Estate_Yearly_Net_Rental_Income1)){ echo $drrealestate->Joint_Real_Estate_Yearly_Net_Rental_Income1; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6 Joint_Real_Estate_Rental1_Input_Div">
                                    <label for="Joint_Real_Estate_Client_Share_Rental1">{{$client_name}} Share of Yearly Net Rent</label>
                                    <input id="Joint_Real_Estate_Client_Share_Rental1" type="number" class="form-control 1_Joint_realestate_inputs" name="Joint_Real_Estate_Client_Share_Rental1" value="<?php if(isset($drrealestate->Joint_Real_Estate_Client_Share_Rental1)){ echo $drrealestate->Joint_Real_Estate_Client_Share_Rental1; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6 Joint_Real_Estate_Rental1_Input_Div">
                                    <label for="Joint_Real_Estate_Op_Share_Rental1">{{$opponent_name}} Share of Yearly Net Rent</label>
                                    <input id="Joint_Real_Estate_Op_Share_Rental1" type="number" class="form-control 1_Joint_realestate_inputs" name="Joint_Real_Estate_Op_Share_Rental1" value="<?php if(isset($drrealestate->Joint_Real_Estate_Op_Share_Rental1)){ echo $drrealestate->Joint_Real_Estate_Op_Share_Rental1; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Does either party claim a sole/separate interest in this Real Estate?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Joint_Real_Estate_SoleSeparate_Claim1_Yes" name="Joint_Real_Estate_SoleSeparate_Claim1" value="Yes" data-onload="getInitialPartyClaimSoleSeparate(this, '1', 'Joint');" onchange="getPartyClaimSoleSeparate(this, '1', 'Joint');" <?php if(isset($drrealestate->Joint_Real_Estate_SoleSeparate_Claim1) && $drrealestate->Joint_Real_Estate_SoleSeparate_Claim1=='Yes'){ echo "checked"; } ?>> Yes</label>
                                        <label><input type="radio" id="Joint_Real_Estate_SoleSeparate_Claim1_No" name="Joint_Real_Estate_SoleSeparate_Claim1" value="No" data-onload="getInitialPartyClaimSoleSeparate(this, '1', 'Joint');" onchange="getPartyClaimSoleSeparate(this, '1', 'Joint');" <?php if(isset($drrealestate->Joint_Real_Estate_SoleSeparate_Claim1) && $drrealestate->Joint_Real_Estate_SoleSeparate_Claim1=='No'){ echo "checked"; } ?>> No</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6" id="Joint_Real_Estate_SoleSeparate_Party1_Div" style="display: none;">
                                    <label>Who claims to own this Real Estate?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Joint_Real_Estate_SoleSeparate_Party1_Client" name="Joint_Real_Estate_SoleSeparate_Party1" value="{{$client_name}}" <?php if(isset($drrealestate->Joint_Real_Estate_SoleSeparate_Party1) && $drrealestate->Joint_Real_Estate_SoleSeparate_Party1==$client_name){ echo "checked"; } ?>> {{$client_name}}</label>
                                        <label><input type="radio" id="Joint_Real_Estate_SoleSeparate_Party1_Op" name="Joint_Real_Estate_SoleSeparate_Party1" value="{{$opponent_name}}" <?php if(isset($drrealestate->Joint_Real_Estate_SoleSeparate_Party1) && $drrealestate->Joint_Real_Estate_SoleSeparate_Party1==$opponent_name){ echo "checked"; } ?>> {{$opponent_name}}</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6" id="Joint_Real_Estate_SoleSeparate_Grounds1_Div" style="display: none;">
                                    <label for="Joint_Real_Estate_SoleSeparate_Grounds1">Why does this person own this Real Estate solely and separately?</label>
                                    <input id="Joint_Real_Estate_SoleSeparate_Grounds1" type="text" class="form-control 1_Joint_realestate_inputs" name="Joint_Real_Estate_SoleSeparate_Grounds1" value="<?php if(isset($drrealestate->Joint_Real_Estate_SoleSeparate_Grounds1)){ echo $drrealestate->Joint_Real_Estate_SoleSeparate_Grounds1; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>How will this Real Estate value be distributed between the parties?</label>
                                    <div class="w-100 dataInput">
                                        <label><input type="radio" id="Joint_Real_Estate_Disposition_Method1_Liquidate/Split_Net_Value" name="Joint_Real_Estate_Disposition_Method1" value="Liquidate/Split Net Value" data-onload="getInitialDipositionMethod(this, '1', 'Joint');" onchange="getDipositionMethod(this, '1', 'Joint');" <?php if(isset($drrealestate->Joint_Real_Estate_Disposition_Method1) && $drrealestate->Joint_Real_Estate_Disposition_Method1=='Liquidate/Split Net Value'){ echo "checked"; } ?>> Liquidate/Split Net Value</label>
                                        <label><input type="radio" id="Joint_Real_Estate_Disposition_Method1_Fixed_Buyout_Refinance" name="Joint_Real_Estate_Disposition_Method1" value="Fixed Buyout/Refinance" data-onload="getInitialDipositionMethod(this, '1', 'Joint');" onchange="getDipositionMethod(this, '1', 'Joint');" <?php if(isset($drrealestate->Joint_Real_Estate_Disposition_Method1) && $drrealestate->Joint_Real_Estate_Disposition_Method1=='Fixed Buyout/Refinance'){ echo "checked"; } ?>> Fixed Buyout/Refinance</label>
                                    </div>
                                </div>
                                <!-- slider tool -->
                                <div class="form-group col-sm-6 m-auto 1_Joint_Slider_Tool slider-tool-main">
                                    <div class="row">
                                        <div class="col">{{$client_name}}</div>
                                        <div class="col text-right">{{$opponent_name}}</div>
                                    </div>
                                    <input id="1_Joint_balance_range_selector" type="range" class="form-control slider-tool-input 1_Joint_balance_range_selector" name="" value="<?php if(isset($drrealestate->Joint_Real_Estate_Percent_Marital_Equity_to_Op1)){ echo $drrealestate->Joint_Real_Estate_Percent_Marital_Equity_to_Op1; } ?>" min="0.00" step="0.01" max="100" onchange="updateBalanceInput(this.value, '1', 'Joint');">
                                </div>
                                <div class="form-group col-sm-6 m-auto 1_Joint_Slider_Tool slider-tool-main">
                                    <div class="row justify-content-between">
                                        <div class="col selectorTool">
                                            <div class="left-col">
                                                <div class="client-info 1_Joint_clientpercentage_div clientpercentage_div">
                                                    <?php if(isset($drrealestate->Joint_Real_Estate_Percent_Marital_Equity_to_Client1)){ echo $drrealestate->Joint_Real_Estate_Percent_Marital_Equity_to_Client1; } else {
                                                        echo '50.00';
                                                    } ?>%
                                                </div>
                                                <div class="client-info 1_Joint_clientamount_div clientamount_div" style="clear: both;">
                                                    $<?php if(isset($drrealestate->Joint_Real_Estate_Estimated_Value_to_Client1)){ echo $drrealestate->Joint_Real_Estate_Estimated_Value_to_Client1; } else {
                                                        echo '0.00';
                                                    } ?>
                                                </div>
                                            </div>
                                            <label>To {{$client_name}}</label>
                                        </div>                                       
                                        <div class="col selectorTool selectorToolRight">
                                            <label>To {{$opponent_name}}</label>
                                            <div class="left-col right-col">
                                                <div class="client-info 1_Joint_opponentpercentage_div opponentpercentage_div">
                                                    <?php if(isset($drrealestate->Joint_Real_Estate_Percent_Marital_Equity_to_Op1)){ echo $drrealestate->Joint_Real_Estate_Percent_Marital_Equity_to_Op1; } else {
                                                        echo '50.00';
                                                    } ?>%
                                                </div>
                                                <div class="client-info 1_Joint_opponentamount_div opponentamount_div" style="clear: both;">
                                                    $<?php if(isset($drrealestate->Joint_Real_Estate_Estimated_Value_to_Op1)){ echo $drrealestate->Joint_Real_Estate_Estimated_Value_to_Op1; } else {
                                                        echo '0.00';
                                                    } ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 m-auto 1_Joint_Slider_Tool slider-tool-main">
                                    <label></label>
                                    <div class="w-100">
                                        <label><input type="radio" id="1_Joint_Real_Estate_Estimated_Value_Select" name="1_Joint_Real_Estate_Estimated_Value_Select_Reset" class="Real_Estate_Estimated_Value_Select_Reset" value="Save"> Save this Distribution of Real Estate #1</label>
                                        <label><input type="radio" id="1_Joint_Real_Estate_Estimated_Value_Reset" name="1_Joint_Real_Estate_Estimated_Value_Select_Reset" class="Real_Estate_Estimated_Value_Select_Reset" value="Reset" onclick="resetBalanceInput(this, '1', 'Joint');"> Reset to Default (50%)</label>
                                    </div>
                                </div>

                                <div class="form-group col-sm-6 Joint_Real_Estate_Paying_Party1_Inputs_Div" style="display: none;">
                                    <label>Joint Real Estate Paying Party1</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Joint_Real_Estate_Paying_Party1_Client" name="Joint_Real_Estate_Paying_Party1" value="{{$client_name}}" data-onload="getInitialRealEstatePayingParty(this, '1', 'Joint');" onchange="getRealEstatePayingParty(this, '1', 'Joint');" <?php if(isset($drrealestate->Joint_Real_Estate_Paying_Party1) && $drrealestate->Joint_Real_Estate_Paying_Party1==$client_name){ echo "checked"; } ?>> {{$client_name}}</label>
                                        <label><input type="radio" id="Joint_Real_Estate_Paying_Party1_Op" name="Joint_Real_Estate_Paying_Party1" value="{{$opponent_name}}" data-onload="getInitialRealEstatePayingParty(this, '1', 'Joint');" onchange="getRealEstatePayingParty(this, '1', 'Joint');" <?php if(isset($drrealestate->Joint_Real_Estate_Paying_Party1) && $drrealestate->Joint_Real_Estate_Paying_Party1==$opponent_name){ echo "checked"; } ?>> {{$opponent_name}}</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 Joint_Real_Estate_Paying_Party1_Inputs_Div" style="display: none;">
                                    <label>{{$client_name}} Real Estate Equity Percent</label>
                                    <input id="Joint_Real_Estate_Percent_Marital_Equity_to_Client1" type="number" class="form-control 1_Joint_clientpercentage_input clientpercentage_input" name="Joint_Real_Estate_Percent_Marital_Equity_to_Client1" value="<?php if(isset($drrealestate->Joint_Real_Estate_Percent_Marital_Equity_to_Client1)){ echo $drrealestate->Joint_Real_Estate_Percent_Marital_Equity_to_Client1; } ?>" min="0.00" step="0.01" max="100" readonly="">
                                </div>
                                <div class="form-group col-sm-6 Joint_Real_Estate_Paying_Party1_Inputs_Div" style="display: none;">
                                    <label>How much is to be paid to {{$client_name}}?</label>
                                    <input id="Joint_Real_Estate_Estimated_Value_to_Client1" type="number" class="form-control 1_Joint_clientamount_input clientamount_input" name="Joint_Real_Estate_Estimated_Value_to_Client1" value="<?php if(isset($drrealestate->Joint_Real_Estate_Estimated_Value_to_Client1)){ echo $drrealestate->Joint_Real_Estate_Estimated_Value_to_Client1; } ?>" min="0.00" step="0.01" max="999999.99" readonly="" onchange="getEstimatedValueClient(this, '1', 'Joint');" onkeyup="getEstimatedValueClient(this, '1', 'Joint');">
                                </div>
                                <div class="form-group col-sm-6 Joint_Real_Estate_Paying_Party1_Inputs_Div" style="display: none;">
                                    <label>{{$opponent_name}} Real Estate Equity Percent</label>
                                    <input id="Joint_Real_Estate_Percent_Marital_Equity_to_Op1" type="number" class="form-control 1_Joint_opponentpercentage_input opponentpercentage_input" name="Joint_Real_Estate_Percent_Marital_Equity_to_Op1" value="<?php if(isset($drrealestate->Joint_Real_Estate_Percent_Marital_Equity_to_Op1)){ echo $drrealestate->Joint_Real_Estate_Percent_Marital_Equity_to_Op1; } ?>" min="0.00" step="0.01" max="100" readonly="">
                                </div>
                                <div class="form-group col-sm-6 Joint_Real_Estate_Paying_Party1_Inputs_Div" style="display: none;">
                                    <label>How much is to be paid to {{$opponent_name}}?</label>
                                    <input id="Joint_Real_Estate_Estimated_Value_to_Op1" type="number" class="form-control 1_Joint_opponentamount_input opponentamount_input" name="Joint_Real_Estate_Estimated_Value_to_Op1" value="<?php if(isset($drrealestate->Joint_Real_Estate_Estimated_Value_to_Op1)){ echo $drrealestate->Joint_Real_Estate_Estimated_Value_to_Op1; } ?>" min="0.00" step="0.01" max="999999.99" readonly="" onchange="getEstimatedValueOp(this, '1', 'Joint');" onkeyup="getEstimatedValueOp(this, '1', 'Joint');">
                                </div>
                                <!-- end of slider tool -->
                            </div>
                            <div class="col-sm-12 mt-4 2_Joint_realestate_section" style="display: none;"><h5 class="col-sm-12">Second Real Estate Info</h5>
                                <div class="form-group col-sm-6">
                                    <p class="text-danger 2_Joint_no-state-county-found" style="display: none;">No City, State, County found for this zipcode.</p>
                                    <label for="Joint_Real_Estate_ZIP2">ZIP code of this Property?</label>
                                    <input id="Joint_Real_Estate_ZIP2" type="text" class="form-control 2_Joint_realestate_inputs" name="Joint_Real_Estate_ZIP2" value="<?php if(isset($drrealestate->Joint_Real_Estate_ZIP2)){ echo $drrealestate->Joint_Real_Estate_ZIP2; } ?>" data-onload="getCityStateForZip(this, '2', 'Joint');" onkeyup="getCityStateForZip(this, '2', 'Joint');"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_Real_Estate_Street_Address2">This Property Street Address?</label>
                                    <input id="Joint_Real_Estate_Street_Address2" type="text" class="form-control 2_Joint_realestate_inputs" name="Joint_Real_Estate_Street_Address2" value="<?php if(isset($drrealestate->Joint_Real_Estate_Street_Address2)){ echo $drrealestate->Joint_Real_Estate_Street_Address2; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_Real_Estate_City2">This Property City?</label>
                                    <input type="hidden" name="" id="Joint_Real_Estate_Institution_City2_Value" value="<?php if(isset($drrealestate->Joint_Real_Estate_City2)){ echo $drrealestate->Joint_Real_Estate_City2; } ?>">
                                    <select id="Joint_Real_Estate_City2" name="Joint_Real_Estate_City2" class="form-control 2_Joint_city_select">
                                        <option value="">Choose City</option>
                                    </select>   
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_Real_Estate_State2">This Property State?</label>
                                    <input type="hidden" name="" id="Joint_Real_Estate_Institution_State2_Value" value="<?php if(isset($drrealestate->Joint_Real_Estate_State2)){ echo $drrealestate->Joint_Real_Estate_State2; } ?>">
                                    <select id="Joint_Real_Estate_State2" name="Joint_Real_Estate_State2" class="form-control 2_Joint_state_select">
                                        <option value="">Choose State</option>
                                    </select>   
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_Real_Estate_Current_Value2">Current Value?</label>
                                    <input id="Joint_Real_Estate_Current_Value2" type="number" class="form-control 2_Joint_realestate_inputs" name="Joint_Real_Estate_Current_Value2" value="<?php if(isset($drrealestate->Joint_Real_Estate_Current_Value2)){ echo $drrealestate->Joint_Real_Estate_Current_Value2; } ?>" min="0.00" step="0.01" max="999999.99" onchange="getJointCurrentValue(this, '2', 'Joint');" onkeyup="getJointCurrentValue(this, '2', 'Joint');"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_Real_Estate_First_Mortgage_Company_Name2">Name of First Mortgage/Loan Company for this Property?</label>
                                    <input id="Joint_Real_Estate_First_Mortgage_Company_Name2" type="text" class="form-control 2_Joint_realestate_inputs" name="Joint_Real_Estate_First_Mortgage_Company_Name2" value="<?php if(isset($drrealestate->Joint_Real_Estate_First_Mortgage_Company_Name2)){ echo $drrealestate->Joint_Real_Estate_First_Mortgage_Company_Name2; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_Real_Estate_First_Mortgage_Balance2">Balance owed on First Mortgage/Loan for this Property?</label>
                                    <input id="Joint_Real_Estate_First_Mortgage_Balance2" type="number" class="form-control 2_Joint_realestate_inputs" name="Joint_Real_Estate_First_Mortgage_Balance2" value="<?php if(isset($drrealestate->Joint_Real_Estate_First_Mortgage_Balance2)){ echo $drrealestate->Joint_Real_Estate_First_Mortgage_Balance2; } ?>" onchange="getMaritalEquity(this, '2', 'Joint');" onkeyup="getMaritalEquity(this, '2', 'Joint');" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_Real_Estate_First_Mortgage_Monthly_Payment2">Monthly payment for First Mortgage/Loan for this Property?</label>
                                    <input id="Joint_Real_Estate_First_Mortgage_Monthly_Payment2" type="number" class="form-control 2_Joint_realestate_inputs" name="Joint_Real_Estate_First_Mortgage_Monthly_Payment2" value="<?php if(isset($drrealestate->Joint_Real_Estate_First_Mortgage_Monthly_Payment2)){ echo $drrealestate->Joint_Real_Estate_First_Mortgage_Monthly_Payment2; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_Real_Estate_Second_Mortgage_LOC_Company_Name2">Name of Second Mortgage/Loan Company for this Property?</label>
                                    <input id="Joint_Real_Estate_Second_Mortgage_LOC_Company_Name2" type="text" class="form-control 2_Joint_realestate_inputs" name="Joint_Real_Estate_Second_Mortgage_LOC_Company_Name2" value="<?php if(isset($drrealestate->Joint_Real_Estate_Second_Mortgage_LOC_Company_Name2)){ echo $drrealestate->Joint_Real_Estate_Second_Mortgage_LOC_Company_Name2; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_Real_Estate_Second_Mortgage_LOC_Balance2">Balance owed on Second Mortgage/Loan for this Property?</label>
                                    <input id="Joint_Real_Estate_Second_Mortgage_LOC_Balance2" type="number" class="form-control 2_Joint_realestate_inputs" name="Joint_Real_Estate_Second_Mortgage_LOC_Balance2" value="<?php if(isset($drrealestate->Joint_Real_Estate_Second_Mortgage_LOC_Balance2)){ echo $drrealestate->Joint_Real_Estate_Second_Mortgage_LOC_Balance2; } ?>" onchange="getMaritalEquity(this, '2', 'Joint');" onkeyup="getMaritalEquity(this, '2', 'Joint');" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_Real_Estate_Second_Mortgage_LOC_Monthly_Payment2">Monthly payment for Second Mortgage/Loan for this Property?</label>
                                    <input id="Joint_Real_Estate_Second_Mortgage_LOC_Monthly_Payment2" type="number" class="form-control 2_Joint_realestate_inputs" name="Joint_Real_Estate_Second_Mortgage_LOC_Monthly_Payment2" value="<?php if(isset($drrealestate->Joint_Real_Estate_Second_Mortgage_LOC_Monthly_Payment2)){ echo $drrealestate->Joint_Real_Estate_Second_Mortgage_LOC_Monthly_Payment2; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_Real_Estate_MaritalEquity2">Marital Equity</label>
                                    <input id="Joint_Real_Estate_MaritalEquity2" type="number" class="form-control 2_Joint_realestate_inputs" name="Joint_Real_Estate_MaritalEquity2" readonly value="<?php if(isset($drrealestate->Joint_Real_Estate_MaritalEquity2)){ echo $drrealestate->Joint_Real_Estate_MaritalEquity2; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Is this Property a Rental/Investment Property?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Joint_Real_Estate_Rental2_Yes" name="Joint_Real_Estate_Rental2" value="Yes" data-onload="getInitialRentalProperty(this, '2', 'Joint');" onchange="getRentalProperty(this, '2', 'Joint');" <?php if(isset($drrealestate->Joint_Real_Estate_Rental2) && $drrealestate->Joint_Real_Estate_Rental2=='Yes'){ echo "checked"; $hide='style="display: none;"'; } ?>> Yes</label>
                                        <label><input type="radio" id="Joint_Real_Estate_Rental2_No" name="Joint_Real_Estate_Rental2" value="No" data-onload="getInitialRentalProperty(this, '2', 'Joint');" onchange="getRentalProperty(this, '2', 'Joint');" <?php if(isset($drrealestate->Joint_Real_Estate_Rental2) && $drrealestate->Joint_Real_Estate_Rental2=='No'){ echo "checked"; $hide=''; } ?>> No</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_Real_Estate_Yearly_Net_Rental_Income2">Joint Real Estate Yearly Net Rental Income2</label>
                                    <input id="Joint_Real_Estate_Yearly_Net_Rental_Income2" type="number" class="form-control 2_Joint_realestate_inputs" name="Joint_Real_Estate_Yearly_Net_Rental_Income2" onchange="getYearlyNetRentalIncome(this, '2', 'Joint');" onkeyup="getYearlyNetRentalIncome(this, '2', 'Joint');" value="<?php if(isset($drrealestate->Joint_Real_Estate_Yearly_Net_Rental_Income2)){ echo $drrealestate->Joint_Real_Estate_Yearly_Net_Rental_Income2; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6 Joint_Real_Estate_Rental2_Input_Div">
                                    <label for="Joint_Real_Estate_Client_Share_Rental2">{{$client_name}} Share of Yearly Net Rent</label>
                                    <input id="Joint_Real_Estate_Client_Share_Rental2" type="number" class="form-control 2_Joint_realestate_inputs" name="Joint_Real_Estate_Client_Share_Rental2" value="<?php if(isset($drrealestate->Joint_Real_Estate_Client_Share_Rental2)){ echo $drrealestate->Joint_Real_Estate_Client_Share_Rental2; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6 Joint_Real_Estate_Rental2_Input_Div">
                                    <label for="Joint_Real_Estate_Op_Share_Rental2">{{$opponent_name}} Share of Yearly Net Rent</label>
                                    <input id="Joint_Real_Estate_Op_Share_Rental2" type="number" class="form-control 2_Joint_realestate_inputs" name="Joint_Real_Estate_Op_Share_Rental2" value="<?php if(isset($drrealestate->Joint_Real_Estate_Op_Share_Rental2)){ echo $drrealestate->Joint_Real_Estate_Op_Share_Rental2; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Does either party claim a sole/separate interest in this Real Estate?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Joint_Real_Estate_SoleSeparate_Claim2_Yes" name="Joint_Real_Estate_SoleSeparate_Claim2" value="Yes" data-onload="getInitialPartyClaimSoleSeparate(this, '2', 'Joint');" onchange="getPartyClaimSoleSeparate(this, '2', 'Joint');" <?php if(isset($drrealestate->Joint_Real_Estate_SoleSeparate_Claim2) && $drrealestate->Joint_Real_Estate_SoleSeparate_Claim2=='Yes'){ echo "checked"; } ?>> Yes</label>
                                        <label><input type="radio" id="Joint_Real_Estate_SoleSeparate_Claim2_No" name="Joint_Real_Estate_SoleSeparate_Claim2" value="No" data-onload="getInitialPartyClaimSoleSeparate(this, '2', 'Joint');" onchange="getPartyClaimSoleSeparate(this, '2', 'Joint');" <?php if(isset($drrealestate->Joint_Real_Estate_SoleSeparate_Claim2) && $drrealestate->Joint_Real_Estate_SoleSeparate_Claim2=='No'){ echo "checked"; } ?>> No</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6" id="Joint_Real_Estate_SoleSeparate_Party2_Div" style="display: none;">
                                    <label>Who claims to own this Real Estate?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Joint_Real_Estate_SoleSeparate_Party2_Client" name="Joint_Real_Estate_SoleSeparate_Party2" value="{{$client_name}}" <?php if(isset($drrealestate->Joint_Real_Estate_SoleSeparate_Party2) && $drrealestate->Joint_Real_Estate_SoleSeparate_Party2==$client_name){ echo "checked"; } ?>> {{$client_name}}</label>
                                        <label><input type="radio" id="Joint_Real_Estate_SoleSeparate_Party2_Op" name="Joint_Real_Estate_SoleSeparate_Party2" value="{{$opponent_name}}" <?php if(isset($drrealestate->Joint_Real_Estate_SoleSeparate_Party2) && $drrealestate->Joint_Real_Estate_SoleSeparate_Party2==$opponent_name){ echo "checked"; } ?>> {{$opponent_name}}</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6" id="Joint_Real_Estate_SoleSeparate_Grounds2_Div" style="display: none;">
                                    <label for="Joint_Real_Estate_SoleSeparate_Grounds2">Why does this person own this Real Estate solely and separately?</label>
                                    <input id="Joint_Real_Estate_SoleSeparate_Grounds2" type="text" class="form-control 2_Joint_realestate_inputs" name="Joint_Real_Estate_SoleSeparate_Grounds2" value="<?php if(isset($drrealestate->Joint_Real_Estate_SoleSeparate_Grounds2)){ echo $drrealestate->Joint_Real_Estate_SoleSeparate_Grounds2; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>How will this Real Estate value be distributed between the parties?</label>
                                    <div class="w-100 dataInput">
                                        <label><input type="radio" id="Joint_Real_Estate_Disposition_Method2_Liquidate/Split_Net_Value" name="Joint_Real_Estate_Disposition_Method2" value="Liquidate/Split Net Value" data-onload="getInitialDipositionMethod(this, '2', 'Joint');" onchange="getDipositionMethod(this, '2', 'Joint');" <?php if(isset($drrealestate->Joint_Real_Estate_Disposition_Method2) && $drrealestate->Joint_Real_Estate_Disposition_Method2=='Liquidate/Split Net Value'){ echo "checked"; } ?>> Liquidate/Split Net Value</label>
                                        <label><input type="radio" id="Joint_Real_Estate_Disposition_Method2_Fixed_Buyout_Refinance" name="Joint_Real_Estate_Disposition_Method2" value="Fixed Buyout/Refinance" data-onload="getInitialDipositionMethod(this, '2', 'Joint');" onchange="getDipositionMethod(this, '2', 'Joint');" <?php if(isset($drrealestate->Joint_Real_Estate_Disposition_Method2) && $drrealestate->Joint_Real_Estate_Disposition_Method2=='Fixed Buyout/Refinance'){ echo "checked"; } ?>> Fixed Buyout/Refinance</label>
                                    </div>
                                </div>
                                <!-- slider tool -->
                                <div class="form-group col-sm-6 m-auto 2_Joint_Slider_Tool slider-tool-main">
                                    <div class="row">
                                        <div class="col">{{$client_name}}</div>
                                        <div class="col text-right">{{$opponent_name}}</div>
                                    </div>
                                    <input id="2_Joint_balance_range_selector" type="range" class="form-control slider-tool-input 2_Joint_balance_range_selector" name="" value="<?php if(isset($drrealestate->Joint_Real_Estate_Percent_Marital_Equity_to_Op2)){ echo $drrealestate->Joint_Real_Estate_Percent_Marital_Equity_to_Op2; } ?>" min="0.00" step="0.01" max="100" onchange="updateBalanceInput(this.value, '2', 'Joint');">
                                </div>
                                <div class="form-group col-sm-6 m-auto 2_Joint_Slider_Tool slider-tool-main">
                                    <div class="row justify-content-between">
                                        <div class="col selectorTool">
                                            <div class="left-col">
                                                <div class="client-info 2_Joint_clientpercentage_div clientpercentage_div">
                                                    <?php if(isset($drrealestate->Joint_Real_Estate_Percent_Marital_Equity_to_Client2)){ echo $drrealestate->Joint_Real_Estate_Percent_Marital_Equity_to_Client2; } else {
                                                        echo '50.00';
                                                    } ?>%
                                                </div>
                                                <div class="client-info 2_Joint_clientamount_div clientamount_div" style="clear: both;">
                                                    $<?php if(isset($drrealestate->Joint_Real_Estate_Estimated_Value_to_Client2)){ echo $drrealestate->Joint_Real_Estate_Estimated_Value_to_Client2; } else {
                                                        echo '0.00';
                                                    } ?>
                                                </div>
                                            </div>
                                            <label>To {{$client_name}}</label>
                                        </div>                                       
                                        <div class="col selectorTool selectorToolRight">
                                            <label>To {{$opponent_name}}</label>
                                            <div class="left-col right-col">
                                                <div class="client-info 2_Joint_opponentpercentage_div opponentpercentage_div">
                                                    <?php if(isset($drrealestate->Joint_Real_Estate_Percent_Marital_Equity_to_Op2)){ echo $drrealestate->Joint_Real_Estate_Percent_Marital_Equity_to_Op2; } else {
                                                        echo '50.00';
                                                    } ?>%
                                                </div>
                                                <div class="client-info 2_Joint_opponentamount_div opponentamount_div" style="clear: both;">
                                                    $<?php if(isset($drrealestate->Joint_Real_Estate_Estimated_Value_to_Op2)){ echo $drrealestate->Joint_Real_Estate_Estimated_Value_to_Op2; } else {
                                                        echo '0.00';
                                                    } ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 m-auto 2_Joint_Slider_Tool slider-tool-main">
                                    <label></label>
                                    <div class="w-100">
                                        <label><input type="radio" id="2_Joint_Real_Estate_Estimated_Value_Select" name="2_Joint_Real_Estate_Estimated_Value_Select_Reset" class="Real_Estate_Estimated_Value_Select_Reset" value="Save"> Save this Distribution of Real Estate #2</label>
                                        <label><input type="radio" id="2_Joint_Real_Estate_Estimated_Value_Reset" name="2_Joint_Real_Estate_Estimated_Value_Select_Reset" class="Real_Estate_Estimated_Value_Select_Reset" value="Reset" onclick="resetBalanceInput(this, '2', 'Joint');"> Reset to Default (50%)</label>
                                    </div>
                                </div>

                                <div class="form-group col-sm-6 Joint_Real_Estate_Paying_Party2_Inputs_Div" style="display: none;">
                                    <label>Joint Real Estate Paying Party2</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Joint_Real_Estate_Paying_Party2_Client" name="Joint_Real_Estate_Paying_Party2" value="{{$client_name}}" data-onload="getInitialRealEstatePayingParty(this, '2', 'Joint');" onchange="getRealEstatePayingParty(this, '2', 'Joint');" <?php if(isset($drrealestate->Joint_Real_Estate_Paying_Party2) && $drrealestate->Joint_Real_Estate_Paying_Party2==$client_name){ echo "checked"; } ?>> {{$client_name}}</label>
                                        <label><input type="radio" id="Joint_Real_Estate_Paying_Party2_Op" name="Joint_Real_Estate_Paying_Party2" value="{{$opponent_name}}" data-onload="getInitialRealEstatePayingParty(this, '2', 'Joint');" onchange="getRealEstatePayingParty(this, '2', 'Joint');" <?php if(isset($drrealestate->Joint_Real_Estate_Paying_Party2) && $drrealestate->Joint_Real_Estate_Paying_Party2==$opponent_name){ echo "checked"; } ?>> {{$opponent_name}}</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 Joint_Real_Estate_Paying_Party2_Inputs_Div" style="display: none;">
                                    <label>{{$client_name}} Real Estate Equity Percent</label>
                                    <input id="Joint_Real_Estate_Percent_Marital_Equity_to_Client2" type="number" class="form-control 2_Joint_clientpercentage_input clientpercentage_input" name="Joint_Real_Estate_Percent_Marital_Equity_to_Client2" value="<?php if(isset($drrealestate->Joint_Real_Estate_Percent_Marital_Equity_to_Client2)){ echo $drrealestate->Joint_Real_Estate_Percent_Marital_Equity_to_Client2; } ?>" min="0.00" step="0.01" max="100" readonly="">
                                </div>
                                <div class="form-group col-sm-6 Joint_Real_Estate_Paying_Party2_Inputs_Div" style="display: none;">
                                    <label>How much is to be paid to {{$client_name}}?</label>
                                    <input id="Joint_Real_Estate_Estimated_Value_to_Client2" type="number" class="form-control 2_Joint_clientamount_input clientamount_input" name="Joint_Real_Estate_Estimated_Value_to_Client2" value="<?php if(isset($drrealestate->Joint_Real_Estate_Estimated_Value_to_Client2)){ echo $drrealestate->Joint_Real_Estate_Estimated_Value_to_Client2; } ?>" min="0.00" step="0.01" max="999999.99" readonly="" onchange="getEstimatedValueClient(this, '2', 'Joint');" onkeyup="getEstimatedValueClient(this, '2', 'Joint');">
                                </div>
                                <div class="form-group col-sm-6 Joint_Real_Estate_Paying_Party2_Inputs_Div" style="display: none;">
                                    <label>{{$opponent_name}} Real Estate Equity Percent</label>
                                    <input id="Joint_Real_Estate_Percent_Marital_Equity_to_Op2" type="number" class="form-control 2_Joint_opponentpercentage_input opponentpercentage_input" name="Joint_Real_Estate_Percent_Marital_Equity_to_Op2" value="<?php if(isset($drrealestate->Joint_Real_Estate_Percent_Marital_Equity_to_Op2)){ echo $drrealestate->Joint_Real_Estate_Percent_Marital_Equity_to_Op2; } ?>" min="0.00" step="0.01" max="100" readonly="">
                                </div>
                                <div class="form-group col-sm-6 Joint_Real_Estate_Paying_Party2_Inputs_Div" style="display: none;">
                                    <label>How much is to be paid to {{$opponent_name}}?</label>
                                    <input id="Joint_Real_Estate_Estimated_Value_to_Op2" type="number" class="form-control 2_Joint_opponentamount_input opponentamount_input" name="Joint_Real_Estate_Estimated_Value_to_Op2" value="<?php if(isset($drrealestate->Joint_Real_Estate_Estimated_Value_to_Op2)){ echo $drrealestate->Joint_Real_Estate_Estimated_Value_to_Op2; } ?>" min="0.00" step="0.01" max="999999.99" readonly="" onchange="getEstimatedValueOp(this, '2', 'Joint');" onkeyup="getEstimatedValueOp(this, '2', 'Joint');">
                                </div>
                                <!-- end of slider tool -->
                            </div>
                            <div class="col-sm-12 mt-4 3_Joint_realestate_section" style="display: none;"><h5 class="col-sm-12">Third Real Estate Info</h5>
                                <div class="form-group col-sm-6">
                                    <p class="text-danger 3_Joint_no-state-county-found" style="display: none;">No City, State, County found for this zipcode.</p>
                                    <label for="Joint_Real_Estate_ZIP3">ZIP code of this Property?</label>
                                    <input id="Joint_Real_Estate_ZIP3" type="text" class="form-control 3_Joint_realestate_inputs" name="Joint_Real_Estate_ZIP3" value="<?php if(isset($drrealestate->Joint_Real_Estate_ZIP3)){ echo $drrealestate->Joint_Real_Estate_ZIP3; } ?>" data-onload="getCityStateForZip(this, '3', 'Joint');" onkeyup="getCityStateForZip(this, '3', 'Joint');"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_Real_Estate_Street_Address3">This Property Street Address?</label>
                                    <input id="Joint_Real_Estate_Street_Address3" type="text" class="form-control 3_Joint_realestate_inputs" name="Joint_Real_Estate_Street_Address3" value="<?php if(isset($drrealestate->Joint_Real_Estate_Street_Address3)){ echo $drrealestate->Joint_Real_Estate_Street_Address3; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_Real_Estate_City3">This Property City?</label>
                                    <input type="hidden" name="" id="Joint_Real_Estate_Institution_City3_Value" value="<?php if(isset($drrealestate->Joint_Real_Estate_City3)){ echo $drrealestate->Joint_Real_Estate_City3; } ?>">
                                    <select id="Joint_Real_Estate_City3" name="Joint_Real_Estate_City3" class="form-control 3_Joint_city_select">
                                        <option value="">Choose City</option>
                                    </select>   
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_Real_Estate_State3">This Property State?</label>
                                    <input type="hidden" name="" id="Joint_Real_Estate_Institution_State3_Value" value="<?php if(isset($drrealestate->Joint_Real_Estate_State3)){ echo $drrealestate->Joint_Real_Estate_State3; } ?>">
                                    <select id="Joint_Real_Estate_State3" name="Joint_Real_Estate_State3" class="form-control 3_Joint_state_select">
                                        <option value="">Choose State</option>
                                    </select>   
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_Real_Estate_Current_Value3">Current Value?</label>
                                    <input id="Joint_Real_Estate_Current_Value3" type="number" class="form-control 3_Joint_realestate_inputs" name="Joint_Real_Estate_Current_Value3" value="<?php if(isset($drrealestate->Joint_Real_Estate_Current_Value3)){ echo $drrealestate->Joint_Real_Estate_Current_Value3; } ?>" min="0.00" step="0.01" max="999999.99" onchange="getJointCurrentValue(this, '3', 'Joint');" onkeyup="getJointCurrentValue(this, '3', 'Joint');"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_Real_Estate_First_Mortgage_Company_Name3">Name of First Mortgage/Loan Company for this Property?</label>
                                    <input id="Joint_Real_Estate_First_Mortgage_Company_Name3" type="text" class="form-control 3_Joint_realestate_inputs" name="Joint_Real_Estate_First_Mortgage_Company_Name3" value="<?php if(isset($drrealestate->Joint_Real_Estate_First_Mortgage_Company_Name3)){ echo $drrealestate->Joint_Real_Estate_First_Mortgage_Company_Name3; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_Real_Estate_First_Mortgage_Balance3">Balance owed on First Mortgage/Loan for this Property?</label>
                                    <input id="Joint_Real_Estate_First_Mortgage_Balance3" type="number" class="form-control 3_Joint_realestate_inputs" name="Joint_Real_Estate_First_Mortgage_Balance3" value="<?php if(isset($drrealestate->Joint_Real_Estate_First_Mortgage_Balance3)){ echo $drrealestate->Joint_Real_Estate_First_Mortgage_Balance3; } ?>" onchange="getMaritalEquity(this, '3', 'Joint');" onkeyup="getMaritalEquity(this, '3', 'Joint');" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_Real_Estate_First_Mortgage_Monthly_Payment3">Monthly payment for First Mortgage/Loan for this Property?</label>
                                    <input id="Joint_Real_Estate_First_Mortgage_Monthly_Payment3" type="number" class="form-control 3_Joint_realestate_inputs" name="Joint_Real_Estate_First_Mortgage_Monthly_Payment3" value="<?php if(isset($drrealestate->Joint_Real_Estate_First_Mortgage_Monthly_Payment3)){ echo $drrealestate->Joint_Real_Estate_First_Mortgage_Monthly_Payment3; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_Real_Estate_Second_Mortgage_LOC_Company_Name3">Name of Second Mortgage/Loan Company for this Property?</label>
                                    <input id="Joint_Real_Estate_Second_Mortgage_LOC_Company_Name3" type="text" class="form-control 3_Joint_realestate_inputs" name="Joint_Real_Estate_Second_Mortgage_LOC_Company_Name3" value="<?php if(isset($drrealestate->Joint_Real_Estate_Second_Mortgage_LOC_Company_Name3)){ echo $drrealestate->Joint_Real_Estate_Second_Mortgage_LOC_Company_Name3; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_Real_Estate_Second_Mortgage_LOC_Balance3">Balance owed on Second Mortgage/Loan for this Property?</label>
                                    <input id="Joint_Real_Estate_Second_Mortgage_LOC_Balance3" type="number" class="form-control 3_Joint_realestate_inputs" name="Joint_Real_Estate_Second_Mortgage_LOC_Balance3" value="<?php if(isset($drrealestate->Joint_Real_Estate_Second_Mortgage_LOC_Balance3)){ echo $drrealestate->Joint_Real_Estate_Second_Mortgage_LOC_Balance3; } ?>" onchange="getMaritalEquity(this, '3', 'Joint');" onkeyup="getMaritalEquity(this, '3', 'Joint');" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_Real_Estate_Second_Mortgage_LOC_Monthly_Payment3">Monthly payment for Second Mortgage/Loan for this Property?</label>
                                    <input id="Joint_Real_Estate_Second_Mortgage_LOC_Monthly_Payment3" type="number" class="form-control 3_Joint_realestate_inputs" name="Joint_Real_Estate_Second_Mortgage_LOC_Monthly_Payment3" value="<?php if(isset($drrealestate->Joint_Real_Estate_Second_Mortgage_LOC_Monthly_Payment3)){ echo $drrealestate->Joint_Real_Estate_Second_Mortgage_LOC_Monthly_Payment3; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_Real_Estate_MaritalEquity3">Marital Equity</label>
                                    <input id="Joint_Real_Estate_MaritalEquity3" type="number" class="form-control 3_Joint_realestate_inputs" name="Joint_Real_Estate_MaritalEquity3" readonly value="<?php if(isset($drrealestate->Joint_Real_Estate_MaritalEquity3)){ echo $drrealestate->Joint_Real_Estate_MaritalEquity3; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Is this Property a Rental/Investment Property?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Joint_Real_Estate_Rental3_Yes" name="Joint_Real_Estate_Rental3" value="Yes" data-onload="getInitialRentalProperty(this, '3', 'Joint');" onchange="getRentalProperty(this, '3', 'Joint');" <?php if(isset($drrealestate->Joint_Real_Estate_Rental3) && $drrealestate->Joint_Real_Estate_Rental3=='Yes'){ echo "checked"; $hide='style="display: none;"'; } ?>> Yes</label>
                                        <label><input type="radio" id="Joint_Real_Estate_Rental3_No" name="Joint_Real_Estate_Rental3" value="No" data-onload="getInitialRentalProperty(this, '3', 'Joint');" onchange="getRentalProperty(this, '3', 'Joint');" <?php if(isset($drrealestate->Joint_Real_Estate_Rental3) && $drrealestate->Joint_Real_Estate_Rental3=='No'){ echo "checked"; $hide=''; } ?>> No</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_Real_Estate_Yearly_Net_Rental_Income3">Joint Real Estate Yearly Net Rental Income3</label>
                                    <input id="Joint_Real_Estate_Yearly_Net_Rental_Income3" type="number" class="form-control 3_Joint_realestate_inputs" name="Joint_Real_Estate_Yearly_Net_Rental_Income3" onchange="getYearlyNetRentalIncome(this, '3', 'Joint');" onkeyup="getYearlyNetRentalIncome(this, '3', 'Joint');" value="<?php if(isset($drrealestate->Joint_Real_Estate_Yearly_Net_Rental_Income3)){ echo $drrealestate->Joint_Real_Estate_Yearly_Net_Rental_Income3; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6 Joint_Real_Estate_Rental3_Input_Div">
                                    <label for="Joint_Real_Estate_Client_Share_Rental3">{{$client_name}} Share of Yearly Net Rent</label>
                                    <input id="Joint_Real_Estate_Client_Share_Rental3" type="number" class="form-control 3_Joint_realestate_inputs" name="Joint_Real_Estate_Client_Share_Rental3" value="<?php if(isset($drrealestate->Joint_Real_Estate_Client_Share_Rental3)){ echo $drrealestate->Joint_Real_Estate_Client_Share_Rental3; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6 Joint_Real_Estate_Rental3_Input_Div">
                                    <label for="Joint_Real_Estate_Op_Share_Rental3">{{$opponent_name}} Share of Yearly Net Rent</label>
                                    <input id="Joint_Real_Estate_Op_Share_Rental3" type="number" class="form-control 3_Joint_realestate_inputs" name="Joint_Real_Estate_Op_Share_Rental3" value="<?php if(isset($drrealestate->Joint_Real_Estate_Op_Share_Rental3)){ echo $drrealestate->Joint_Real_Estate_Op_Share_Rental3; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Does either party claim a sole/separate interest in this Real Estate?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Joint_Real_Estate_SoleSeparate_Claim3_Yes" name="Joint_Real_Estate_SoleSeparate_Claim3" value="Yes" data-onload="getInitialPartyClaimSoleSeparate(this, '3', 'Joint');" onchange="getPartyClaimSoleSeparate(this, '3', 'Joint');" <?php if(isset($drrealestate->Joint_Real_Estate_SoleSeparate_Claim3) && $drrealestate->Joint_Real_Estate_SoleSeparate_Claim3=='Yes'){ echo "checked"; } ?>> Yes</label>
                                        <label><input type="radio" id="Joint_Real_Estate_SoleSeparate_Claim3_No" name="Joint_Real_Estate_SoleSeparate_Claim3" value="No" data-onload="getInitialPartyClaimSoleSeparate(this, '3', 'Joint');" onchange="getPartyClaimSoleSeparate(this, '3', 'Joint');" <?php if(isset($drrealestate->Joint_Real_Estate_SoleSeparate_Claim3) && $drrealestate->Joint_Real_Estate_SoleSeparate_Claim3=='No'){ echo "checked"; } ?>> No</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6" id="Joint_Real_Estate_SoleSeparate_Party3_Div" style="display: none;">
                                    <label>Who claims to own this Real Estate?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Joint_Real_Estate_SoleSeparate_Party3_Client" name="Joint_Real_Estate_SoleSeparate_Party3" value="{{$client_name}}" <?php if(isset($drrealestate->Joint_Real_Estate_SoleSeparate_Party3) && $drrealestate->Joint_Real_Estate_SoleSeparate_Party3==$client_name){ echo "checked"; } ?>> {{$client_name}}</label>
                                        <label><input type="radio" id="Joint_Real_Estate_SoleSeparate_Party3_Op" name="Joint_Real_Estate_SoleSeparate_Party3" value="{{$opponent_name}}" <?php if(isset($drrealestate->Joint_Real_Estate_SoleSeparate_Party3) && $drrealestate->Joint_Real_Estate_SoleSeparate_Party3==$opponent_name){ echo "checked"; } ?>> {{$opponent_name}}</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6" id="Joint_Real_Estate_SoleSeparate_Grounds3_Div" style="display: none;">
                                    <label for="Joint_Real_Estate_SoleSeparate_Grounds3">Why does this person own this Real Estate solely and separately?</label>
                                    <input id="Joint_Real_Estate_SoleSeparate_Grounds3" type="text" class="form-control 3_Joint_realestate_inputs" name="Joint_Real_Estate_SoleSeparate_Grounds3" value="<?php if(isset($drrealestate->Joint_Real_Estate_SoleSeparate_Grounds3)){ echo $drrealestate->Joint_Real_Estate_SoleSeparate_Grounds3; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>How will this Real Estate value be distributed between the parties?</label>
                                    <div class="w-100 dataInput">
                                        <label><input type="radio" id="Joint_Real_Estate_Disposition_Method3_Liquidate/Split_Net_Value" name="Joint_Real_Estate_Disposition_Method3" value="Liquidate/Split Net Value" data-onload="getInitialDipositionMethod(this, '3', 'Joint');" onchange="getDipositionMethod(this, '3', 'Joint');" <?php if(isset($drrealestate->Joint_Real_Estate_Disposition_Method3) && $drrealestate->Joint_Real_Estate_Disposition_Method3=='Liquidate/Split Net Value'){ echo "checked"; } ?>> Liquidate/Split Net Value</label>
                                        <label><input type="radio" id="Joint_Real_Estate_Disposition_Method3_Fixed_Buyout_Refinance" name="Joint_Real_Estate_Disposition_Method3" value="Fixed Buyout/Refinance" data-onload="getInitialDipositionMethod(this, '3', 'Joint');" onchange="getDipositionMethod(this, '3', 'Joint');" <?php if(isset($drrealestate->Joint_Real_Estate_Disposition_Method3) && $drrealestate->Joint_Real_Estate_Disposition_Method3=='Fixed Buyout/Refinance'){ echo "checked"; } ?>> Fixed Buyout/Refinance</label>
                                    </div>
                                </div>
                                <!-- slider tool -->
                                <div class="form-group col-sm-6 m-auto 3_Joint_Slider_Tool slider-tool-main">
                                    <div class="row">
                                        <div class="col">{{$client_name}}</div>
                                        <div class="col text-right">{{$opponent_name}}</div>
                                    </div>
                                    <input id="3_Joint_balance_range_selector" type="range" class="form-control slider-tool-input 3_Joint_balance_range_selector" name="" value="<?php if(isset($drrealestate->Joint_Real_Estate_Percent_Marital_Equity_to_Op3)){ echo $drrealestate->Joint_Real_Estate_Percent_Marital_Equity_to_Op3; } ?>" min="0.00" step="0.01" max="100" onchange="updateBalanceInput(this.value, '3', 'Joint');">
                                </div>
                                <div class="form-group col-sm-6 m-auto 3_Joint_Slider_Tool slider-tool-main">
                                    <div class="row justify-content-between">
                                        <div class="col selectorTool">
                                            <div class="left-col">
                                                <div class="client-info 3_Joint_clientpercentage_div clientpercentage_div">
                                                    <?php if(isset($drrealestate->Joint_Real_Estate_Percent_Marital_Equity_to_Client3)){ echo $drrealestate->Joint_Real_Estate_Percent_Marital_Equity_to_Client3; } else {
                                                        echo '50.00';
                                                    } ?>%
                                                </div>
                                                <div class="client-info 3_Joint_clientamount_div clientamount_div" style="clear: both;">
                                                    $<?php if(isset($drrealestate->Joint_Real_Estate_Estimated_Value_to_Client3)){ echo $drrealestate->Joint_Real_Estate_Estimated_Value_to_Client3; } else {
                                                        echo '0.00';
                                                    } ?>
                                                </div>
                                            </div>
                                            <label>To {{$client_name}}</label>
                                        </div>                                       
                                        <div class="col selectorTool selectorToolRight">
                                            <label>To {{$opponent_name}}</label>
                                            <div class="left-col right-col">
                                                <div class="client-info 3_Joint_opponentpercentage_div opponentpercentage_div">
                                                    <?php if(isset($drrealestate->Joint_Real_Estate_Percent_Marital_Equity_to_Op3)){ echo $drrealestate->Joint_Real_Estate_Percent_Marital_Equity_to_Op3; } else {
                                                        echo '50.00';
                                                    } ?>%
                                                </div>
                                                <div class="client-info 3_Joint_opponentamount_div opponentamount_div" style="clear: both;">
                                                    $<?php if(isset($drrealestate->Joint_Real_Estate_Estimated_Value_to_Op3)){ echo $drrealestate->Joint_Real_Estate_Estimated_Value_to_Op3; } else {
                                                        echo '0.00';
                                                    } ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 m-auto 3_Joint_Slider_Tool slider-tool-main">
                                    <label></label>
                                    <div class="w-100">
                                        <label><input type="radio" id="3_Joint_Real_Estate_Estimated_Value_Select" name="3_Joint_Real_Estate_Estimated_Value_Select_Reset" class="Real_Estate_Estimated_Value_Select_Reset" value="Save"> Save this Distribution of Real Estate #3</label>
                                        <label><input type="radio" id="3_Joint_Real_Estate_Estimated_Value_Reset" name="3_Joint_Real_Estate_Estimated_Value_Select_Reset" class="Real_Estate_Estimated_Value_Select_Reset" value="Reset" onclick="resetBalanceInput(this, '3', 'Joint');"> Reset to Default (50%)</label>
                                    </div>
                                </div>

                                <div class="form-group col-sm-6 Joint_Real_Estate_Paying_Party3_Inputs_Div" style="display: none;">
                                    <label>Joint Real Estate Paying Party3</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Joint_Real_Estate_Paying_Party3_Client" name="Joint_Real_Estate_Paying_Party3" value="{{$client_name}}" data-onload="getInitialRealEstatePayingParty(this, '3', 'Joint');" onchange="getRealEstatePayingParty(this, '3', 'Joint');" <?php if(isset($drrealestate->Joint_Real_Estate_Paying_Party3) && $drrealestate->Joint_Real_Estate_Paying_Party3==$client_name){ echo "checked"; } ?>> {{$client_name}}</label>
                                        <label><input type="radio" id="Joint_Real_Estate_Paying_Party3_Op" name="Joint_Real_Estate_Paying_Party3" value="{{$opponent_name}}" data-onload="getInitialRealEstatePayingParty(this, '3', 'Joint');" onchange="getRealEstatePayingParty(this, '3', 'Joint');" <?php if(isset($drrealestate->Joint_Real_Estate_Paying_Party3) && $drrealestate->Joint_Real_Estate_Paying_Party3==$opponent_name){ echo "checked"; } ?>> {{$opponent_name}}</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 Joint_Real_Estate_Paying_Party3_Inputs_Div" style="display: none;">
                                    <label>{{$client_name}} Real Estate Equity Percent</label>
                                    <input id="Joint_Real_Estate_Percent_Marital_Equity_to_Client3" type="number" class="form-control 3_Joint_clientpercentage_input clientpercentage_input" name="Joint_Real_Estate_Percent_Marital_Equity_to_Client3" value="<?php if(isset($drrealestate->Joint_Real_Estate_Percent_Marital_Equity_to_Client3)){ echo $drrealestate->Joint_Real_Estate_Percent_Marital_Equity_to_Client3; } ?>" min="0.00" step="0.01" max="100" readonly="">
                                </div>
                                <div class="form-group col-sm-6 Joint_Real_Estate_Paying_Party3_Inputs_Div" style="display: none;">
                                    <label>How much is to be paid to {{$client_name}}?</label>
                                    <input id="Joint_Real_Estate_Estimated_Value_to_Client3" type="number" class="form-control 3_Joint_clientamount_input clientamount_input" name="Joint_Real_Estate_Estimated_Value_to_Client3" value="<?php if(isset($drrealestate->Joint_Real_Estate_Estimated_Value_to_Client3)){ echo $drrealestate->Joint_Real_Estate_Estimated_Value_to_Client3; } ?>" min="0.00" step="0.01" max="999999.99" readonly="" onchange="getEstimatedValueClient(this, '3', 'Joint');" onkeyup="getEstimatedValueClient(this, '3', 'Joint');">
                                </div>
                                <div class="form-group col-sm-6 Joint_Real_Estate_Paying_Party3_Inputs_Div" style="display: none;">
                                    <label>{{$opponent_name}} Real Estate Equity Percent</label>
                                    <input id="Joint_Real_Estate_Percent_Marital_Equity_to_Op3" type="number" class="form-control 3_Joint_opponentpercentage_input opponentpercentage_input" name="Joint_Real_Estate_Percent_Marital_Equity_to_Op3" value="<?php if(isset($drrealestate->Joint_Real_Estate_Percent_Marital_Equity_to_Op3)){ echo $drrealestate->Joint_Real_Estate_Percent_Marital_Equity_to_Op3; } ?>" min="0.00" step="0.01" max="100" readonly="">
                                </div>
                                <div class="form-group col-sm-6 Joint_Real_Estate_Paying_Party3_Inputs_Div" style="display: none;">
                                    <label>How much is to be paid to {{$opponent_name}}?</label>
                                    <input id="Joint_Real_Estate_Estimated_Value_to_Op3" type="number" class="form-control 3_Joint_opponentamount_input opponentamount_input" name="Joint_Real_Estate_Estimated_Value_to_Op3" value="<?php if(isset($drrealestate->Joint_Real_Estate_Estimated_Value_to_Op3)){ echo $drrealestate->Joint_Real_Estate_Estimated_Value_to_Op3; } ?>" min="0.00" step="0.01" max="999999.99" readonly="" onchange="getEstimatedValueOp(this, '3', 'Joint');" onkeyup="getEstimatedValueOp(this, '3', 'Joint');">
                                </div>
                                <!-- end of slider tool -->
                            </div>
                            <div class="col-sm-12 mt-4 4_Joint_realestate_section" style="display: none;"><h5 class="col-sm-12">Fourth Real Estate Info</h5>
                                <div class="form-group col-sm-6">
                                    <p class="text-danger 4_Joint_no-state-county-found" style="display: none;">No City, State, County found for this zipcode.</p>
                                    <label for="Joint_Real_Estate_ZIP4">ZIP code of this Property?</label>
                                    <input id="Joint_Real_Estate_ZIP4" type="text" class="form-control 4_Joint_realestate_inputs" name="Joint_Real_Estate_ZIP4" value="<?php if(isset($drrealestate->Joint_Real_Estate_ZIP4)){ echo $drrealestate->Joint_Real_Estate_ZIP4; } ?>" data-onload="getCityStateForZip(this, '4', 'Joint');" onkeyup="getCityStateForZip(this, '4', 'Joint');"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_Real_Estate_Street_Address4">This Property Street Address?</label>
                                    <input id="Joint_Real_Estate_Street_Address4" type="text" class="form-control 4_Joint_realestate_inputs" name="Joint_Real_Estate_Street_Address4" value="<?php if(isset($drrealestate->Joint_Real_Estate_Street_Address4)){ echo $drrealestate->Joint_Real_Estate_Street_Address4; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_Real_Estate_City4">This Property City?</label>
                                    <input type="hidden" name="" id="Joint_Real_Estate_Institution_City4_Value" value="<?php if(isset($drrealestate->Joint_Real_Estate_City4)){ echo $drrealestate->Joint_Real_Estate_City4; } ?>">
                                    <select id="Joint_Real_Estate_City4" name="Joint_Real_Estate_City4" class="form-control 4_Joint_city_select">
                                        <option value="">Choose City</option>
                                    </select>   
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_Real_Estate_State4">This Property State?</label>
                                    <input type="hidden" name="" id="Joint_Real_Estate_Institution_State4_Value" value="<?php if(isset($drrealestate->Joint_Real_Estate_State4)){ echo $drrealestate->Joint_Real_Estate_State4; } ?>">
                                    <select id="Joint_Real_Estate_State4" name="Joint_Real_Estate_State4" class="form-control 4_Joint_state_select">
                                        <option value="">Choose State</option>
                                    </select>   
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_Real_Estate_Current_Value4">Current Value?</label>
                                    <input id="Joint_Real_Estate_Current_Value4" type="number" class="form-control 4_Joint_realestate_inputs" name="Joint_Real_Estate_Current_Value4" value="<?php if(isset($drrealestate->Joint_Real_Estate_Current_Value4)){ echo $drrealestate->Joint_Real_Estate_Current_Value4; } ?>" min="0.00" step="0.01" max="999999.99" onchange="getJointCurrentValue(this, '4', 'Joint');" onkeyup="getJointCurrentValue(this, '4', 'Joint');"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_Real_Estate_First_Mortgage_Company_Name4">Name of First Mortgage/Loan Company for this Property?</label>
                                    <input id="Joint_Real_Estate_First_Mortgage_Company_Name4" type="text" class="form-control 4_Joint_realestate_inputs" name="Joint_Real_Estate_First_Mortgage_Company_Name4" value="<?php if(isset($drrealestate->Joint_Real_Estate_First_Mortgage_Company_Name4)){ echo $drrealestate->Joint_Real_Estate_First_Mortgage_Company_Name4; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_Real_Estate_First_Mortgage_Balance4">Balance owed on First Mortgage/Loan for this Property?</label>
                                    <input id="Joint_Real_Estate_First_Mortgage_Balance4" type="number" class="form-control 4_Joint_realestate_inputs" name="Joint_Real_Estate_First_Mortgage_Balance4" value="<?php if(isset($drrealestate->Joint_Real_Estate_First_Mortgage_Balance4)){ echo $drrealestate->Joint_Real_Estate_First_Mortgage_Balance4; } ?>" onchange="getMaritalEquity(this, '4', 'Joint');" onkeyup="getMaritalEquity(this, '4', 'Joint');" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_Real_Estate_First_Mortgage_Monthly_Payment4">Monthly payment for First Mortgage/Loan for this Property?</label>
                                    <input id="Joint_Real_Estate_First_Mortgage_Monthly_Payment4" type="number" class="form-control 4_Joint_realestate_inputs" name="Joint_Real_Estate_First_Mortgage_Monthly_Payment4" value="<?php if(isset($drrealestate->Joint_Real_Estate_First_Mortgage_Monthly_Payment4)){ echo $drrealestate->Joint_Real_Estate_First_Mortgage_Monthly_Payment4; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_Real_Estate_Second_Mortgage_LOC_Company_Name4">Name of Second Mortgage/Loan Company for this Property?</label>
                                    <input id="Joint_Real_Estate_Second_Mortgage_LOC_Company_Name4" type="text" class="form-control 4_Joint_realestate_inputs" name="Joint_Real_Estate_Second_Mortgage_LOC_Company_Name4" value="<?php if(isset($drrealestate->Joint_Real_Estate_Second_Mortgage_LOC_Company_Name4)){ echo $drrealestate->Joint_Real_Estate_Second_Mortgage_LOC_Company_Name4; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_Real_Estate_Second_Mortgage_LOC_Balance4">Balance owed on Second Mortgage/Loan for this Property?</label>
                                    <input id="Joint_Real_Estate_Second_Mortgage_LOC_Balance4" type="number" class="form-control 4_Joint_realestate_inputs" name="Joint_Real_Estate_Second_Mortgage_LOC_Balance4" value="<?php if(isset($drrealestate->Joint_Real_Estate_Second_Mortgage_LOC_Balance4)){ echo $drrealestate->Joint_Real_Estate_Second_Mortgage_LOC_Balance4; } ?>" onchange="getMaritalEquity(this, '4', 'Joint');" onkeyup="getMaritalEquity(this, '4', 'Joint');" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_Real_Estate_Second_Mortgage_LOC_Monthly_Payment4">Monthly payment for Second Mortgage/Loan for this Property?</label>
                                    <input id="Joint_Real_Estate_Second_Mortgage_LOC_Monthly_Payment4" type="number" class="form-control 4_Joint_realestate_inputs" name="Joint_Real_Estate_Second_Mortgage_LOC_Monthly_Payment4" value="<?php if(isset($drrealestate->Joint_Real_Estate_Second_Mortgage_LOC_Monthly_Payment4)){ echo $drrealestate->Joint_Real_Estate_Second_Mortgage_LOC_Monthly_Payment4; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_Real_Estate_MaritalEquity4">Marital Equity</label>
                                    <input id="Joint_Real_Estate_MaritalEquity4" type="number" class="form-control 4_Joint_realestate_inputs" name="Joint_Real_Estate_MaritalEquity4" readonly value="<?php if(isset($drrealestate->Joint_Real_Estate_MaritalEquity4)){ echo $drrealestate->Joint_Real_Estate_MaritalEquity4; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Is this Property a Rental/Investment Property?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Joint_Real_Estate_Rental4_Yes" name="Joint_Real_Estate_Rental4" value="Yes" data-onload="getInitialRentalProperty(this, '4', 'Joint');" onchange="getRentalProperty(this, '4', 'Joint');" <?php if(isset($drrealestate->Joint_Real_Estate_Rental4) && $drrealestate->Joint_Real_Estate_Rental4=='Yes'){ echo "checked"; $hide='style="display: none;"'; } ?>> Yes</label>
                                        <label><input type="radio" id="Joint_Real_Estate_Rental4_No" name="Joint_Real_Estate_Rental4" value="No" data-onload="getInitialRentalProperty(this, '4', 'Joint');" onchange="getRentalProperty(this, '4', 'Joint');" <?php if(isset($drrealestate->Joint_Real_Estate_Rental4) && $drrealestate->Joint_Real_Estate_Rental4=='No'){ echo "checked"; $hide=''; } ?>> No</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_Real_Estate_Yearly_Net_Rental_Income4">Joint Real Estate Yearly Net Rental Income4</label>
                                    <input id="Joint_Real_Estate_Yearly_Net_Rental_Income4" type="number" class="form-control 4_Joint_realestate_inputs" name="Joint_Real_Estate_Yearly_Net_Rental_Income4" onchange="getYearlyNetRentalIncome(this, '4', 'Joint');" onkeyup="getYearlyNetRentalIncome(this, '4', 'Joint');" value="<?php if(isset($drrealestate->Joint_Real_Estate_Yearly_Net_Rental_Income4)){ echo $drrealestate->Joint_Real_Estate_Yearly_Net_Rental_Income4; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6 Joint_Real_Estate_Rental4_Input_Div">
                                    <label for="Joint_Real_Estate_Client_Share_Rental4">{{$client_name}} Share of Yearly Net Rent</label>
                                    <input id="Joint_Real_Estate_Client_Share_Rental4" type="number" class="form-control 4_Joint_realestate_inputs" name="Joint_Real_Estate_Client_Share_Rental4" value="<?php if(isset($drrealestate->Joint_Real_Estate_Client_Share_Rental4)){ echo $drrealestate->Joint_Real_Estate_Client_Share_Rental4; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6 Joint_Real_Estate_Rental4_Input_Div">
                                    <label for="Joint_Real_Estate_Op_Share_Rental4">{{$opponent_name}} Share of Yearly Net Rent</label>
                                    <input id="Joint_Real_Estate_Op_Share_Rental4" type="number" class="form-control 4_Joint_realestate_inputs" name="Joint_Real_Estate_Op_Share_Rental4" value="<?php if(isset($drrealestate->Joint_Real_Estate_Op_Share_Rental4)){ echo $drrealestate->Joint_Real_Estate_Op_Share_Rental4; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Does either party claim a sole/separate interest in this Real Estate?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Joint_Real_Estate_SoleSeparate_Claim4_Yes" name="Joint_Real_Estate_SoleSeparate_Claim4" value="Yes" data-onload="getInitialPartyClaimSoleSeparate(this, '4', 'Joint');" onchange="getPartyClaimSoleSeparate(this, '4', 'Joint');" <?php if(isset($drrealestate->Joint_Real_Estate_SoleSeparate_Claim4) && $drrealestate->Joint_Real_Estate_SoleSeparate_Claim4=='Yes'){ echo "checked"; } ?>> Yes</label>
                                        <label><input type="radio" id="Joint_Real_Estate_SoleSeparate_Claim4_No" name="Joint_Real_Estate_SoleSeparate_Claim4" value="No" data-onload="getInitialPartyClaimSoleSeparate(this, '4', 'Joint');" onchange="getPartyClaimSoleSeparate(this, '4', 'Joint');" <?php if(isset($drrealestate->Joint_Real_Estate_SoleSeparate_Claim4) && $drrealestate->Joint_Real_Estate_SoleSeparate_Claim4=='No'){ echo "checked"; } ?>> No</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6" id="Joint_Real_Estate_SoleSeparate_Party4_Div" style="display: none;">
                                    <label>Who claims to own this Real Estate?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Joint_Real_Estate_SoleSeparate_Party4_Client" name="Joint_Real_Estate_SoleSeparate_Party4" value="{{$client_name}}" <?php if(isset($drrealestate->Joint_Real_Estate_SoleSeparate_Party4) && $drrealestate->Joint_Real_Estate_SoleSeparate_Party4==$client_name){ echo "checked"; } ?>> {{$client_name}}</label>
                                        <label><input type="radio" id="Joint_Real_Estate_SoleSeparate_Party4_Op" name="Joint_Real_Estate_SoleSeparate_Party4" value="{{$opponent_name}}" <?php if(isset($drrealestate->Joint_Real_Estate_SoleSeparate_Party4) && $drrealestate->Joint_Real_Estate_SoleSeparate_Party4==$opponent_name){ echo "checked"; } ?>> {{$opponent_name}}</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6" id="Joint_Real_Estate_SoleSeparate_Grounds4_Div" style="display: none;">
                                    <label for="Joint_Real_Estate_SoleSeparate_Grounds4">Why does this person own this Real Estate solely and separately?</label>
                                    <input id="Joint_Real_Estate_SoleSeparate_Grounds4" type="text" class="form-control 4_Joint_realestate_inputs" name="Joint_Real_Estate_SoleSeparate_Grounds4" value="<?php if(isset($drrealestate->Joint_Real_Estate_SoleSeparate_Grounds4)){ echo $drrealestate->Joint_Real_Estate_SoleSeparate_Grounds4; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>How will this Real Estate value be distributed between the parties?</label>
                                    <div class="w-100 dataInput">
                                        <label><input type="radio" id="Joint_Real_Estate_Disposition_Method4_Liquidate/Split_Net_Value" name="Joint_Real_Estate_Disposition_Method4" value="Liquidate/Split Net Value" data-onload="getInitialDipositionMethod(this, '4', 'Joint');" onchange="getDipositionMethod(this, '4', 'Joint');" <?php if(isset($drrealestate->Joint_Real_Estate_Disposition_Method4) && $drrealestate->Joint_Real_Estate_Disposition_Method4=='Liquidate/Split Net Value'){ echo "checked"; } ?>> Liquidate/Split Net Value</label>
                                        <label><input type="radio" id="Joint_Real_Estate_Disposition_Method4_Fixed_Buyout_Refinance" name="Joint_Real_Estate_Disposition_Method4" value="Fixed Buyout/Refinance" data-onload="getInitialDipositionMethod(this, '4', 'Joint');" onchange="getDipositionMethod(this, '4', 'Joint');" <?php if(isset($drrealestate->Joint_Real_Estate_Disposition_Method4) && $drrealestate->Joint_Real_Estate_Disposition_Method4=='Fixed Buyout/Refinance'){ echo "checked"; } ?>> Fixed Buyout/Refinance</label>
                                    </div>
                                </div>
                                <!-- slider tool -->
                                <div class="form-group col-sm-6 m-auto 4_Joint_Slider_Tool slider-tool-main">
                                    <div class="row">
                                        <div class="col">{{$client_name}}</div>
                                        <div class="col text-right">{{$opponent_name}}</div>
                                    </div>
                                    <input id="4_Joint_balance_range_selector" type="range" class="form-control slider-tool-input 4_Joint_balance_range_selector" name="" value="<?php if(isset($drrealestate->Joint_Real_Estate_Percent_Marital_Equity_to_Op4)){ echo $drrealestate->Joint_Real_Estate_Percent_Marital_Equity_to_Op4; } ?>" min="0.00" step="0.01" max="100" onchange="updateBalanceInput(this.value, '4', 'Joint');">
                                </div>
                                <div class="form-group col-sm-6 m-auto 4_Joint_Slider_Tool slider-tool-main">
                                    <div class="row justify-content-between">
                                        <div class="col selectorTool">
                                            <div class="left-col">
                                                <div class="client-info 4_Joint_clientpercentage_div clientpercentage_div">
                                                    <?php if(isset($drrealestate->Joint_Real_Estate_Percent_Marital_Equity_to_Client4)){ echo $drrealestate->Joint_Real_Estate_Percent_Marital_Equity_to_Client4; } else {
                                                        echo '50.00';
                                                    } ?>%
                                                </div>
                                                <div class="client-info 4_Joint_clientamount_div clientamount_div" style="clear: both;">
                                                    $<?php if(isset($drrealestate->Joint_Real_Estate_Estimated_Value_to_Client4)){ echo $drrealestate->Joint_Real_Estate_Estimated_Value_to_Client4; } else {
                                                        echo '0.00';
                                                    } ?>
                                                </div>
                                            </div>
                                            <label>To {{$client_name}}</label>
                                        </div>                                       
                                        <div class="col selectorTool selectorToolRight">
                                            <label>To {{$opponent_name}}</label>
                                            <div class="left-col right-col">
                                                <div class="client-info 4_Joint_opponentpercentage_div opponentpercentage_div">
                                                    <?php if(isset($drrealestate->Joint_Real_Estate_Percent_Marital_Equity_to_Op4)){ echo $drrealestate->Joint_Real_Estate_Percent_Marital_Equity_to_Op4; } else {
                                                        echo '50.00';
                                                    } ?>%
                                                </div>
                                                <div class="client-info 4_Joint_opponentamount_div opponentamount_div" style="clear: both;">
                                                    $<?php if(isset($drrealestate->Joint_Real_Estate_Estimated_Value_to_Op4)){ echo $drrealestate->Joint_Real_Estate_Estimated_Value_to_Op4; } else {
                                                        echo '0.00';
                                                    } ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 m-auto 4_Joint_Slider_Tool slider-tool-main">
                                    <label></label>
                                    <div class="w-100">
                                        <label><input type="radio" id="4_Joint_Real_Estate_Estimated_Value_Select" name="4_Joint_Real_Estate_Estimated_Value_Select_Reset" class="Real_Estate_Estimated_Value_Select_Reset" value="Save"> Save this Distribution of Real Estate #4</label>
                                        <label><input type="radio" id="4_Joint_Real_Estate_Estimated_Value_Reset" name="4_Joint_Real_Estate_Estimated_Value_Select_Reset" class="Real_Estate_Estimated_Value_Select_Reset" value="Reset" onclick="resetBalanceInput(this, '4', 'Joint');"> Reset to Default (50%)</label>
                                    </div>
                                </div>

                                <div class="form-group col-sm-6 Joint_Real_Estate_Paying_Party4_Inputs_Div" style="display: none;">
                                    <label>Joint Real Estate Paying Party4</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Joint_Real_Estate_Paying_Party4_Client" name="Joint_Real_Estate_Paying_Party4" value="{{$client_name}}" data-onload="getInitialRealEstatePayingParty(this, '4', 'Joint');" onchange="getRealEstatePayingParty(this, '4', 'Joint');" <?php if(isset($drrealestate->Joint_Real_Estate_Paying_Party4) && $drrealestate->Joint_Real_Estate_Paying_Party4==$client_name){ echo "checked"; } ?>> {{$client_name}}</label>
                                        <label><input type="radio" id="Joint_Real_Estate_Paying_Party4_Op" name="Joint_Real_Estate_Paying_Party4" value="{{$opponent_name}}" data-onload="getInitialRealEstatePayingParty(this, '4', 'Joint');" onchange="getRealEstatePayingParty(this, '4', 'Joint');" <?php if(isset($drrealestate->Joint_Real_Estate_Paying_Party4) && $drrealestate->Joint_Real_Estate_Paying_Party4==$opponent_name){ echo "checked"; } ?>> {{$opponent_name}}</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 Joint_Real_Estate_Paying_Party4_Inputs_Div" style="display: none;">
                                    <label>{{$client_name}} Real Estate Equity Percent</label>
                                    <input id="Joint_Real_Estate_Percent_Marital_Equity_to_Client4" type="number" class="form-control 4_Joint_clientpercentage_input clientpercentage_input" name="Joint_Real_Estate_Percent_Marital_Equity_to_Client4" value="<?php if(isset($drrealestate->Joint_Real_Estate_Percent_Marital_Equity_to_Client4)){ echo $drrealestate->Joint_Real_Estate_Percent_Marital_Equity_to_Client4; } ?>" min="0.00" step="0.01" max="100" readonly="">
                                </div>
                                <div class="form-group col-sm-6 Joint_Real_Estate_Paying_Party4_Inputs_Div" style="display: none;">
                                    <label>How much is to be paid to {{$client_name}}?</label>
                                    <input id="Joint_Real_Estate_Estimated_Value_to_Client4" type="number" class="form-control 4_Joint_clientamount_input clientamount_input" name="Joint_Real_Estate_Estimated_Value_to_Client4" value="<?php if(isset($drrealestate->Joint_Real_Estate_Estimated_Value_to_Client4)){ echo $drrealestate->Joint_Real_Estate_Estimated_Value_to_Client4; } ?>" min="0.00" step="0.01" max="999999.99" readonly="" onchange="getEstimatedValueClient(this, '4', 'Joint');" onkeyup="getEstimatedValueClient(this, '4', 'Joint');">
                                </div>
                                <div class="form-group col-sm-6 Joint_Real_Estate_Paying_Party4_Inputs_Div" style="display: none;">
                                    <label>{{$opponent_name}} Real Estate Equity Percent</label>
                                    <input id="Joint_Real_Estate_Percent_Marital_Equity_to_Op4" type="number" class="form-control 4_Joint_opponentpercentage_input opponentpercentage_input" name="Joint_Real_Estate_Percent_Marital_Equity_to_Op4" value="<?php if(isset($drrealestate->Joint_Real_Estate_Percent_Marital_Equity_to_Op4)){ echo $drrealestate->Joint_Real_Estate_Percent_Marital_Equity_to_Op4; } ?>" min="0.00" step="0.01" max="100" readonly="">
                                </div>
                                <div class="form-group col-sm-6 Joint_Real_Estate_Paying_Party4_Inputs_Div" style="display: none;">
                                    <label>How much is to be paid to {{$opponent_name}}?</label>
                                    <input id="Joint_Real_Estate_Estimated_Value_to_Op4" type="number" class="form-control 4_Joint_opponentamount_input opponentamount_input" name="Joint_Real_Estate_Estimated_Value_to_Op4" value="<?php if(isset($drrealestate->Joint_Real_Estate_Estimated_Value_to_Op4)){ echo $drrealestate->Joint_Real_Estate_Estimated_Value_to_Op4; } ?>" min="0.00" step="0.01" max="999999.99" readonly="" onchange="getEstimatedValueOp(this, '4', 'Joint');" onkeyup="getEstimatedValueOp(this, '4', 'Joint');">
                                </div>
                                <!-- end of slider tool -->
                            </div>
                            <div class="col-sm-12 mt-4 5_Joint_realestate_section" style="display: none;"><h5 class="col-sm-12">Fifth Real Estate Info</h5>
                                <div class="form-group col-sm-6">
                                    <p class="text-danger 5_Joint_no-state-county-found" style="display: none;">No City, State, County found for this zipcode.</p>
                                    <label for="Joint_Real_Estate_ZIP5">ZIP code of this Property?</label>
                                    <input id="Joint_Real_Estate_ZIP5" type="text" class="form-control 5_Joint_realestate_inputs" name="Joint_Real_Estate_ZIP5" value="<?php if(isset($drrealestate->Joint_Real_Estate_ZIP5)){ echo $drrealestate->Joint_Real_Estate_ZIP5; } ?>" data-onload="getCityStateForZip(this, '5', 'Joint');" onkeyup="getCityStateForZip(this, '5', 'Joint');"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_Real_Estate_Street_Address5">This Property Street Address?</label>
                                    <input id="Joint_Real_Estate_Street_Address5" type="text" class="form-control 5_Joint_realestate_inputs" name="Joint_Real_Estate_Street_Address5" value="<?php if(isset($drrealestate->Joint_Real_Estate_Street_Address5)){ echo $drrealestate->Joint_Real_Estate_Street_Address5; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_Real_Estate_City5">This Property City?</label>
                                    <input type="hidden" name="" id="Joint_Real_Estate_Institution_City5_Value" value="<?php if(isset($drrealestate->Joint_Real_Estate_City5)){ echo $drrealestate->Joint_Real_Estate_City5; } ?>">
                                    <select id="Joint_Real_Estate_City5" name="Joint_Real_Estate_City5" class="form-control 5_Joint_city_select">
                                        <option value="">Choose City</option>
                                    </select>   
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_Real_Estate_State5">This Property State?</label>
                                    <input type="hidden" name="" id="Joint_Real_Estate_Institution_State5_Value" value="<?php if(isset($drrealestate->Joint_Real_Estate_State5)){ echo $drrealestate->Joint_Real_Estate_State5; } ?>">
                                    <select id="Joint_Real_Estate_State5" name="Joint_Real_Estate_State5" class="form-control 5_Joint_state_select">
                                        <option value="">Choose State</option>
                                    </select>   
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_Real_Estate_Current_Value5">Current Value?</label>
                                    <input id="Joint_Real_Estate_Current_Value5" type="number" class="form-control 5_Joint_realestate_inputs" name="Joint_Real_Estate_Current_Value5" value="<?php if(isset($drrealestate->Joint_Real_Estate_Current_Value5)){ echo $drrealestate->Joint_Real_Estate_Current_Value5; } ?>" min="0.00" step="0.01" max="999999.99" onchange="getJointCurrentValue(this, '5', 'Joint');" onkeyup="getJointCurrentValue(this, '5', 'Joint');"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_Real_Estate_First_Mortgage_Company_Name5">Name of First Mortgage/Loan Company for this Property?</label>
                                    <input id="Joint_Real_Estate_First_Mortgage_Company_Name5" type="text" class="form-control 5_Joint_realestate_inputs" name="Joint_Real_Estate_First_Mortgage_Company_Name5" value="<?php if(isset($drrealestate->Joint_Real_Estate_First_Mortgage_Company_Name5)){ echo $drrealestate->Joint_Real_Estate_First_Mortgage_Company_Name5; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_Real_Estate_First_Mortgage_Balance5">Balance owed on First Mortgage/Loan for this Property?</label>
                                    <input id="Joint_Real_Estate_First_Mortgage_Balance5" type="number" class="form-control 5_Joint_realestate_inputs" name="Joint_Real_Estate_First_Mortgage_Balance5" value="<?php if(isset($drrealestate->Joint_Real_Estate_First_Mortgage_Balance5)){ echo $drrealestate->Joint_Real_Estate_First_Mortgage_Balance5; } ?>" onchange="getMaritalEquity(this, '5', 'Joint');" onkeyup="getMaritalEquity(this, '5', 'Joint');" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_Real_Estate_First_Mortgage_Monthly_Payment5">Monthly payment for First Mortgage/Loan for this Property?</label>
                                    <input id="Joint_Real_Estate_First_Mortgage_Monthly_Payment5" type="number" class="form-control 5_Joint_realestate_inputs" name="Joint_Real_Estate_First_Mortgage_Monthly_Payment5" value="<?php if(isset($drrealestate->Joint_Real_Estate_First_Mortgage_Monthly_Payment5)){ echo $drrealestate->Joint_Real_Estate_First_Mortgage_Monthly_Payment5; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_Real_Estate_Second_Mortgage_LOC_Company_Name5">Name of Second Mortgage/Loan Company for this Property?</label>
                                    <input id="Joint_Real_Estate_Second_Mortgage_LOC_Company_Name5" type="text" class="form-control 5_Joint_realestate_inputs" name="Joint_Real_Estate_Second_Mortgage_LOC_Company_Name5" value="<?php if(isset($drrealestate->Joint_Real_Estate_Second_Mortgage_LOC_Company_Name5)){ echo $drrealestate->Joint_Real_Estate_Second_Mortgage_LOC_Company_Name5; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_Real_Estate_Second_Mortgage_LOC_Balance5">Balance owed on Second Mortgage/Loan for this Property?</label>
                                    <input id="Joint_Real_Estate_Second_Mortgage_LOC_Balance5" type="number" class="form-control 5_Joint_realestate_inputs" name="Joint_Real_Estate_Second_Mortgage_LOC_Balance5" value="<?php if(isset($drrealestate->Joint_Real_Estate_Second_Mortgage_LOC_Balance5)){ echo $drrealestate->Joint_Real_Estate_Second_Mortgage_LOC_Balance5; } ?>" onchange="getMaritalEquity(this, '5', 'Joint');" onkeyup="getMaritalEquity(this, '5', 'Joint');" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_Real_Estate_Second_Mortgage_LOC_Monthly_Payment5">Monthly payment for Second Mortgage/Loan for this Property?</label>
                                    <input id="Joint_Real_Estate_Second_Mortgage_LOC_Monthly_Payment5" type="number" class="form-control 5_Joint_realestate_inputs" name="Joint_Real_Estate_Second_Mortgage_LOC_Monthly_Payment5" value="<?php if(isset($drrealestate->Joint_Real_Estate_Second_Mortgage_LOC_Monthly_Payment5)){ echo $drrealestate->Joint_Real_Estate_Second_Mortgage_LOC_Monthly_Payment5; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_Real_Estate_MaritalEquity5">Marital Equity</label>
                                    <input id="Joint_Real_Estate_MaritalEquity5" type="number" class="form-control 5_Joint_realestate_inputs" name="Joint_Real_Estate_MaritalEquity5" readonly value="<?php if(isset($drrealestate->Joint_Real_Estate_MaritalEquity5)){ echo $drrealestate->Joint_Real_Estate_MaritalEquity5; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Is this Property a Rental/Investment Property?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Joint_Real_Estate_Rental5_Yes" name="Joint_Real_Estate_Rental5" value="Yes" data-onload="getInitialRentalProperty(this, '5', 'Joint');" onchange="getRentalProperty(this, '5', 'Joint');" <?php if(isset($drrealestate->Joint_Real_Estate_Rental5) && $drrealestate->Joint_Real_Estate_Rental5=='Yes'){ echo "checked"; $hide='style="display: none;"'; } ?>> Yes</label>
                                        <label><input type="radio" id="Joint_Real_Estate_Rental5_No" name="Joint_Real_Estate_Rental5" value="No" data-onload="getInitialRentalProperty(this, '5', 'Joint');" onchange="getRentalProperty(this, '5', 'Joint');" <?php if(isset($drrealestate->Joint_Real_Estate_Rental5) && $drrealestate->Joint_Real_Estate_Rental5=='No'){ echo "checked"; $hide=''; } ?>> No</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_Real_Estate_Yearly_Net_Rental_Income5">Joint Real Estate Yearly Net Rental Income5</label>
                                    <input id="Joint_Real_Estate_Yearly_Net_Rental_Income5" type="number" class="form-control 5_Joint_realestate_inputs" name="Joint_Real_Estate_Yearly_Net_Rental_Income5" onchange="getYearlyNetRentalIncome(this, '5', 'Joint');" onkeyup="getYearlyNetRentalIncome(this, '5', 'Joint');" value="<?php if(isset($drrealestate->Joint_Real_Estate_Yearly_Net_Rental_Income5)){ echo $drrealestate->Joint_Real_Estate_Yearly_Net_Rental_Income5; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6 Joint_Real_Estate_Rental5_Input_Div">
                                    <label for="Joint_Real_Estate_Client_Share_Rental5">{{$client_name}} Share of Yearly Net Rent</label>
                                    <input id="Joint_Real_Estate_Client_Share_Rental5" type="number" class="form-control 5_Joint_realestate_inputs" name="Joint_Real_Estate_Client_Share_Rental5" value="<?php if(isset($drrealestate->Joint_Real_Estate_Client_Share_Rental5)){ echo $drrealestate->Joint_Real_Estate_Client_Share_Rental5; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6 Joint_Real_Estate_Rental5_Input_Div">
                                    <label for="Joint_Real_Estate_Op_Share_Rental5">{{$opponent_name}} Share of Yearly Net Rent</label>
                                    <input id="Joint_Real_Estate_Op_Share_Rental5" type="number" class="form-control 5_Joint_realestate_inputs" name="Joint_Real_Estate_Op_Share_Rental5" value="<?php if(isset($drrealestate->Joint_Real_Estate_Op_Share_Rental5)){ echo $drrealestate->Joint_Real_Estate_Op_Share_Rental5; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Does either party claim a sole/separate interest in this Real Estate?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Joint_Real_Estate_SoleSeparate_Claim5_Yes" name="Joint_Real_Estate_SoleSeparate_Claim5" value="Yes" data-onload="getInitialPartyClaimSoleSeparate(this, '5', 'Joint');" onchange="getPartyClaimSoleSeparate(this, '5', 'Joint');" <?php if(isset($drrealestate->Joint_Real_Estate_SoleSeparate_Claim5) && $drrealestate->Joint_Real_Estate_SoleSeparate_Claim5=='Yes'){ echo "checked"; } ?>> Yes</label>
                                        <label><input type="radio" id="Joint_Real_Estate_SoleSeparate_Claim5_No" name="Joint_Real_Estate_SoleSeparate_Claim5" value="No" data-onload="getInitialPartyClaimSoleSeparate(this, '5', 'Joint');" onchange="getPartyClaimSoleSeparate(this, '5', 'Joint');" <?php if(isset($drrealestate->Joint_Real_Estate_SoleSeparate_Claim5) && $drrealestate->Joint_Real_Estate_SoleSeparate_Claim5=='No'){ echo "checked"; } ?>> No</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6" id="Joint_Real_Estate_SoleSeparate_Party5_Div" style="display: none;">
                                    <label>Who claims to own this Real Estate?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Joint_Real_Estate_SoleSeparate_Party5_Client" name="Joint_Real_Estate_SoleSeparate_Party5" value="{{$client_name}}" <?php if(isset($drrealestate->Joint_Real_Estate_SoleSeparate_Party5) && $drrealestate->Joint_Real_Estate_SoleSeparate_Party5==$client_name){ echo "checked"; } ?>> {{$client_name}}</label>
                                        <label><input type="radio" id="Joint_Real_Estate_SoleSeparate_Party5_Op" name="Joint_Real_Estate_SoleSeparate_Party5" value="{{$opponent_name}}" <?php if(isset($drrealestate->Joint_Real_Estate_SoleSeparate_Party5) && $drrealestate->Joint_Real_Estate_SoleSeparate_Party5==$opponent_name){ echo "checked"; } ?>> {{$opponent_name}}</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6" id="Joint_Real_Estate_SoleSeparate_Grounds5_Div" style="display: none;">
                                    <label for="Joint_Real_Estate_SoleSeparate_Grounds5">Why does this person own this Real Estate solely and separately?</label>
                                    <input id="Joint_Real_Estate_SoleSeparate_Grounds5" type="text" class="form-control 5_Joint_realestate_inputs" name="Joint_Real_Estate_SoleSeparate_Grounds5" value="<?php if(isset($drrealestate->Joint_Real_Estate_SoleSeparate_Grounds5)){ echo $drrealestate->Joint_Real_Estate_SoleSeparate_Grounds5; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>How will this Real Estate value be distributed between the parties?</label>
                                    <div class="w-100 dataInput">
                                        <label><input type="radio" id="Joint_Real_Estate_Disposition_Method5_Liquidate/Split_Net_Value" name="Joint_Real_Estate_Disposition_Method5" value="Liquidate/Split Net Value" data-onload="getInitialDipositionMethod(this, '5', 'Joint');" onchange="getDipositionMethod(this, '5', 'Joint');" <?php if(isset($drrealestate->Joint_Real_Estate_Disposition_Method5) && $drrealestate->Joint_Real_Estate_Disposition_Method5=='Liquidate/Split Net Value'){ echo "checked"; } ?>> Liquidate/Split Net Value</label>
                                        <label><input type="radio" id="Joint_Real_Estate_Disposition_Method5_Fixed_Buyout_Refinance" name="Joint_Real_Estate_Disposition_Method5" value="Fixed Buyout/Refinance" data-onload="getInitialDipositionMethod(this, '5', 'Joint');" onchange="getDipositionMethod(this, '5', 'Joint');" <?php if(isset($drrealestate->Joint_Real_Estate_Disposition_Method5) && $drrealestate->Joint_Real_Estate_Disposition_Method5=='Fixed Buyout/Refinance'){ echo "checked"; } ?>> Fixed Buyout/Refinance</label>
                                    </div>
                                </div>
                                <!-- slider tool -->
                                <div class="form-group col-sm-6 m-auto 5_Joint_Slider_Tool slider-tool-main">
                                    <div class="row">
                                        <div class="col">{{$client_name}}</div>
                                        <div class="col text-right">{{$opponent_name}}</div>
                                    </div>
                                    <input id="5_Joint_balance_range_selector" type="range" class="form-control slider-tool-input 5_Joint_balance_range_selector" name="" value="<?php if(isset($drrealestate->Joint_Real_Estate_Percent_Marital_Equity_to_Op5)){ echo $drrealestate->Joint_Real_Estate_Percent_Marital_Equity_to_Op5; } ?>" min="0.00" step="0.01" max="100" onchange="updateBalanceInput(this.value, '5', 'Joint');">
                                </div>
                                <div class="form-group col-sm-6 m-auto 5_Joint_Slider_Tool slider-tool-main">
                                    <div class="row justify-content-between">
                                        <div class="col selectorTool">
                                            <div class="left-col">
                                                <div class="client-info 5_Joint_clientpercentage_div clientpercentage_div">
                                                    <?php if(isset($drrealestate->Joint_Real_Estate_Percent_Marital_Equity_to_Client5)){ echo $drrealestate->Joint_Real_Estate_Percent_Marital_Equity_to_Client5; } else {
                                                        echo '50.00';
                                                    } ?>%
                                                </div>
                                                <div class="client-info 5_Joint_clientamount_div clientamount_div" style="clear: both;">
                                                    $<?php if(isset($drrealestate->Joint_Real_Estate_Estimated_Value_to_Client5)){ echo $drrealestate->Joint_Real_Estate_Estimated_Value_to_Client5; } else {
                                                        echo '0.00';
                                                    } ?>
                                                </div>
                                            </div>
                                            <label>To {{$client_name}}</label>
                                        </div>                                       
                                        <div class="col selectorTool selectorToolRight">
                                            <label>To {{$opponent_name}}</label>
                                            <div class="left-col right-col">
                                                <div class="client-info 5_Joint_opponentpercentage_div opponentpercentage_div">
                                                    <?php if(isset($drrealestate->Joint_Real_Estate_Percent_Marital_Equity_to_Op5)){ echo $drrealestate->Joint_Real_Estate_Percent_Marital_Equity_to_Op5; } else {
                                                        echo '50.00';
                                                    } ?>%
                                                </div>
                                                <div class="client-info 5_Joint_opponentamount_div opponentamount_div" style="clear: both;">
                                                    $<?php if(isset($drrealestate->Joint_Real_Estate_Estimated_Value_to_Op5)){ echo $drrealestate->Joint_Real_Estate_Estimated_Value_to_Op5; } else {
                                                        echo '0.00';
                                                    } ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 m-auto 5_Joint_Slider_Tool slider-tool-main">
                                    <label></label>
                                    <div class="w-100">
                                        <label><input type="radio" id="5_Joint_Real_Estate_Estimated_Value_Select" name="5_Joint_Real_Estate_Estimated_Value_Select_Reset" class="Real_Estate_Estimated_Value_Select_Reset" value="Save"> Save this Distribution of Real Estate #5</label>
                                        <label><input type="radio" id="5_Joint_Real_Estate_Estimated_Value_Reset" name="5_Joint_Real_Estate_Estimated_Value_Select_Reset" class="Real_Estate_Estimated_Value_Select_Reset" value="Reset" onclick="resetBalanceInput(this, '5', 'Joint');"> Reset to Default (50%)</label>
                                    </div>
                                </div>

                                <div class="form-group col-sm-6 Joint_Real_Estate_Paying_Party5_Inputs_Div" style="display: none;">
                                    <label>Joint Real Estate Paying Party5</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Joint_Real_Estate_Paying_Party5_Client" name="Joint_Real_Estate_Paying_Party5" value="{{$client_name}}" data-onload="getInitialRealEstatePayingParty(this, '5', 'Joint');" onchange="getRealEstatePayingParty(this, '5', 'Joint');" <?php if(isset($drrealestate->Joint_Real_Estate_Paying_Party5) && $drrealestate->Joint_Real_Estate_Paying_Party5==$client_name){ echo "checked"; } ?>> {{$client_name}}</label>
                                        <label><input type="radio" id="Joint_Real_Estate_Paying_Party5_Op" name="Joint_Real_Estate_Paying_Party5" value="{{$opponent_name}}" data-onload="getInitialRealEstatePayingParty(this, '5', 'Joint');" onchange="getRealEstatePayingParty(this, '5', 'Joint');" <?php if(isset($drrealestate->Joint_Real_Estate_Paying_Party5) && $drrealestate->Joint_Real_Estate_Paying_Party5==$opponent_name){ echo "checked"; } ?>> {{$opponent_name}}</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 Joint_Real_Estate_Paying_Party5_Inputs_Div" style="display: none;">
                                    <label>{{$client_name}} Real Estate Equity Percent</label>
                                    <input id="Joint_Real_Estate_Percent_Marital_Equity_to_Client5" type="number" class="form-control 5_Joint_clientpercentage_input clientpercentage_input" name="Joint_Real_Estate_Percent_Marital_Equity_to_Client5" value="<?php if(isset($drrealestate->Joint_Real_Estate_Percent_Marital_Equity_to_Client5)){ echo $drrealestate->Joint_Real_Estate_Percent_Marital_Equity_to_Client5; } ?>" min="0.00" step="0.01" max="100" readonly="">
                                </div>
                                <div class="form-group col-sm-6 Joint_Real_Estate_Paying_Party5_Inputs_Div" style="display: none;">
                                    <label>How much is to be paid to {{$client_name}}?</label>
                                    <input id="Joint_Real_Estate_Estimated_Value_to_Client5" type="number" class="form-control 5_Joint_clientamount_input clientamount_input" name="Joint_Real_Estate_Estimated_Value_to_Client5" value="<?php if(isset($drrealestate->Joint_Real_Estate_Estimated_Value_to_Client5)){ echo $drrealestate->Joint_Real_Estate_Estimated_Value_to_Client5; } ?>" min="0.00" step="0.01" max="999999.99" readonly="" onchange="getEstimatedValueClient(this, '5', 'Joint');" onkeyup="getEstimatedValueClient(this, '5', 'Joint');">
                                </div>
                                <div class="form-group col-sm-6 Joint_Real_Estate_Paying_Party5_Inputs_Div" style="display: none;">
                                    <label>{{$opponent_name}} Real Estate Equity Percent</label>
                                    <input id="Joint_Real_Estate_Percent_Marital_Equity_to_Op5" type="number" class="form-control 5_Joint_opponentpercentage_input opponentpercentage_input" name="Joint_Real_Estate_Percent_Marital_Equity_to_Op5" value="<?php if(isset($drrealestate->Joint_Real_Estate_Percent_Marital_Equity_to_Op5)){ echo $drrealestate->Joint_Real_Estate_Percent_Marital_Equity_to_Op5; } ?>" min="0.00" step="0.01" max="100" readonly="">
                                </div>
                                <div class="form-group col-sm-6 Joint_Real_Estate_Paying_Party5_Inputs_Div" style="display: none;">
                                    <label>How much is to be paid to {{$opponent_name}}?</label>
                                    <input id="Joint_Real_Estate_Estimated_Value_to_Op5" type="number" class="form-control 5_Joint_opponentamount_input opponentamount_input" name="Joint_Real_Estate_Estimated_Value_to_Op5" value="<?php if(isset($drrealestate->Joint_Real_Estate_Estimated_Value_to_Op5)){ echo $drrealestate->Joint_Real_Estate_Estimated_Value_to_Op5; } ?>" min="0.00" step="0.01" max="999999.99" readonly="" onchange="getEstimatedValueOp(this, '5', 'Joint');" onkeyup="getEstimatedValueOp(this, '5', 'Joint');">
                                </div>
                                <!-- end of slider tool -->
                            </div>
                        </div>
                        <!-- End ofJoint Real Estate Info Section -->

                        <!-- Client Real Estate Info Section -->
                        <div class="form-row num_Client_realestate mt-4" style="display: none;">
                            <h4 class="col-sm-12">{{$client_name}} Real Estate Info Section</h4>
                            <div class="col-sm-6">
                                <label for="Num_Client_Real_Estate_Properties">How many Real Estate Properties are owned in {{$client_name}}’s Name Only</label>
                                <input id="Num_Client_Real_Estate_Properties" type="number" class="form-control" name="Num_Client_Real_Estate_Properties" value="<?php if(isset($drrealestate->Num_Client_Real_Estate_Properties)){ echo $drrealestate->Num_Client_Real_Estate_Properties; } ?>" min="0" max="5"> 
                            </div>
                        </div>
                        <div class="form-row Client_realestate_section">
                            <div class="col-sm-12 mt-4 1_Client_realestate_section" style="display: none;"><h5 class="col-sm-12">First Real Estate Info</h5>
                                <div class="form-group col-sm-6">
                                    <p class="text-danger 1_Client_no-state-county-found" style="display: none;">No City, State, County found for this zipcode.</p>
                                    <label for="Client_Real_Estate_ZIP1">ZIP code of this Property?</label>
                                    <input id="Client_Real_Estate_ZIP1" type="text" class="form-control 1_Client_realestate_inputs" name="Client_Real_Estate_ZIP1" value="<?php if(isset($drrealestate->Client_Real_Estate_ZIP1)){ echo $drrealestate->Client_Real_Estate_ZIP1; } ?>" data-onload="getCityStateForZip(this, '1', 'Client');" onkeyup="getCityStateForZip(this, '1', 'Client');"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Real_Estate_Street_Address1">This Property Street Address?</label>
                                    <input id="Client_Real_Estate_Street_Address1" type="text" class="form-control 1_Client_realestate_inputs" name="Client_Real_Estate_Street_Address1" value="<?php if(isset($drrealestate->Client_Real_Estate_Street_Address1)){ echo $drrealestate->Client_Real_Estate_Street_Address1; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Real_Estate_City1">This Property City?</label>
                                    <input type="hidden" name="" id="Client_Real_Estate_Institution_City1_Value" value="<?php if(isset($drrealestate->Client_Real_Estate_City1)){ echo $drrealestate->Client_Real_Estate_City1; } ?>">
                                    <select id="Client_Real_Estate_City1" name="Client_Real_Estate_City1" class="form-control 1_Client_city_select">
                                        <option value="">Choose City</option>
                                    </select>   
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Real_Estate_State1">This Property State?</label>
                                    <input type="hidden" name="" id="Client_Real_Estate_Institution_State1_Value" value="<?php if(isset($drrealestate->Client_Real_Estate_State1)){ echo $drrealestate->Client_Real_Estate_State1; } ?>">
                                    <select id="Client_Real_Estate_State1" name="Client_Real_Estate_State1" class="form-control 1_Client_state_select">
                                        <option value="">Choose State</option>
                                    </select>   
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Real_Estate_Current_Value1">Current Value?</label>
                                    <input id="Client_Real_Estate_Current_Value1" type="number" class="form-control 1_Client_realestate_inputs" name="Client_Real_Estate_Current_Value1" value="<?php if(isset($drrealestate->Client_Real_Estate_Current_Value1)){ echo $drrealestate->Client_Real_Estate_Current_Value1; } ?>" min="0.00" step="0.01" max="999999.99" onchange="getJointCurrentValue(this, '1', 'Client');" onkeyup="getJointCurrentValue(this, '1', 'Client');"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Real_Estate_First_Mortgage_Company_Name1">Name of First Mortgage/Loan Company for this Property?</label>
                                    <input id="Client_Real_Estate_First_Mortgage_Company_Name1" type="text" class="form-control 1_Client_realestate_inputs" name="Client_Real_Estate_First_Mortgage_Company_Name1" value="<?php if(isset($drrealestate->Client_Real_Estate_First_Mortgage_Company_Name1)){ echo $drrealestate->Client_Real_Estate_First_Mortgage_Company_Name1; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Real_Estate_First_Mortgage_Balance1">Balance owed on First Mortgage/Loan for this Property?</label>
                                    <input id="Client_Real_Estate_First_Mortgage_Balance1" type="number" class="form-control 1_Client_realestate_inputs" name="Client_Real_Estate_First_Mortgage_Balance1" value="<?php if(isset($drrealestate->Client_Real_Estate_First_Mortgage_Balance1)){ echo $drrealestate->Client_Real_Estate_First_Mortgage_Balance1; } ?>" onchange="getMaritalEquity(this, '1', 'Client');" onkeyup="getMaritalEquity(this, '1', 'Client');" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Real_Estate_First_Mortgage_Monthly_Payment1">Monthly payment for First Mortgage/Loan for this Property?</label>
                                    <input id="Client_Real_Estate_First_Mortgage_Monthly_Payment1" type="number" class="form-control 1_Client_realestate_inputs" name="Client_Real_Estate_First_Mortgage_Monthly_Payment1" value="<?php if(isset($drrealestate->Client_Real_Estate_First_Mortgage_Monthly_Payment1)){ echo $drrealestate->Client_Real_Estate_First_Mortgage_Monthly_Payment1; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Real_Estate_Second_Mortgage_LOC_Company_Name1">Name of Second Mortgage/Loan Company for this Property?</label>
                                    <input id="Client_Real_Estate_Second_Mortgage_LOC_Company_Name1" type="text" class="form-control 1_Client_realestate_inputs" name="Client_Real_Estate_Second_Mortgage_LOC_Company_Name1" value="<?php if(isset($drrealestate->Client_Real_Estate_Second_Mortgage_LOC_Company_Name1)){ echo $drrealestate->Client_Real_Estate_Second_Mortgage_LOC_Company_Name1; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Real_Estate_Second_Mortgage_LOC_Balance1">Balance owed on Second Mortgage/Loan for this Property?</label>
                                    <input id="Client_Real_Estate_Second_Mortgage_LOC_Balance1" type="number" class="form-control 1_Client_realestate_inputs" name="Client_Real_Estate_Second_Mortgage_LOC_Balance1" value="<?php if(isset($drrealestate->Client_Real_Estate_Second_Mortgage_LOC_Balance1)){ echo $drrealestate->Client_Real_Estate_Second_Mortgage_LOC_Balance1; } ?>" onchange="getMaritalEquity(this, '1', 'Client');" onkeyup="getMaritalEquity(this, '1', 'Client');" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Real_Estate_Second_Mortgage_LOC_Monthly_Payment1">Monthly payment for Second Mortgage/Loan for this Property?</label>
                                    <input id="Client_Real_Estate_Second_Mortgage_LOC_Monthly_Payment1" type="number" class="form-control 1_Client_realestate_inputs" name="Client_Real_Estate_Second_Mortgage_LOC_Monthly_Payment1" value="<?php if(isset($drrealestate->Client_Real_Estate_Second_Mortgage_LOC_Monthly_Payment1)){ echo $drrealestate->Client_Real_Estate_Second_Mortgage_LOC_Monthly_Payment1; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Real_Estate_MaritalEquity1">Marital Equity</label>
                                    <input id="Client_Real_Estate_MaritalEquity1" type="number" class="form-control 1_Client_realestate_inputs" name="Client_Real_Estate_MaritalEquity1" readonly value="<?php if(isset($drrealestate->Client_Real_Estate_MaritalEquity1)){ echo $drrealestate->Client_Real_Estate_MaritalEquity1; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Is this Property a Rental/Investment Property?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Client_Real_Estate_Rental1_Yes" name="Client_Real_Estate_Rental1" value="Yes" data-onload="getInitialRentalProperty(this, '1', 'Client');" onchange="getRentalProperty(this, '1', 'Client');" <?php if(isset($drrealestate->Client_Real_Estate_Rental1) && $drrealestate->Client_Real_Estate_Rental1=='Yes'){ echo "checked"; $hide='style="display: none;"'; } ?>> Yes</label>
                                        <label><input type="radio" id="Client_Real_Estate_Rental1_No" name="Client_Real_Estate_Rental1" value="No" data-onload="getInitialRentalProperty(this, '1', 'Client');" onchange="getRentalProperty(this, '1', 'Client');" <?php if(isset($drrealestate->Client_Real_Estate_Rental1) && $drrealestate->Client_Real_Estate_Rental1=='No'){ echo "checked"; $hide=''; } ?>> No</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Real_Estate_Yearly_Net_Rental_Income1">{{$client_name}} Real Estate Yearly Net Rental Income1</label>
                                    <input id="Client_Real_Estate_Yearly_Net_Rental_Income1" type="number" class="form-control 1_Client_realestate_inputs" name="Client_Real_Estate_Yearly_Net_Rental_Income1" onchange="getYearlyNetRentalIncome(this, '1', 'Client');" onkeyup="getYearlyNetRentalIncome(this, '1', 'Client');" value="<?php if(isset($drrealestate->Client_Real_Estate_Yearly_Net_Rental_Income1)){ echo $drrealestate->Client_Real_Estate_Yearly_Net_Rental_Income1; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6 Client_Real_Estate_Rental1_Input_Div">
                                    <label for="Client_Real_Estate_Client_Share_Rental1">{{$client_name}} Share of Yearly Net Rent</label>
                                    <input id="Client_Real_Estate_Client_Share_Rental1" type="number" class="form-control 1_Client_realestate_inputs" name="Client_Real_Estate_Client_Share_Rental1" value="<?php if(isset($drrealestate->Client_Real_Estate_Client_Share_Rental1)){ echo $drrealestate->Client_Real_Estate_Client_Share_Rental1; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6 Client_Real_Estate_Rental1_Input_Div">
                                    <label for="Client_Real_Estate_Op_Share_Rental1">{{$opponent_name}} Share of Yearly Net Rent</label>
                                    <input id="Client_Real_Estate_Op_Share_Rental1" type="number" class="form-control 1_Client_realestate_inputs" name="Client_Real_Estate_Op_Share_Rental1" value="<?php if(isset($drrealestate->Client_Real_Estate_Op_Share_Rental1)){ echo $drrealestate->Client_Real_Estate_Op_Share_Rental1; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Does either party claim a sole/separate interest in this Real Estate?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Client_Real_Estate_SoleSeparate_Claim1_Yes" name="Client_Real_Estate_SoleSeparate_Claim1" value="Yes" data-onload="getInitialPartyClaimSoleSeparate(this, '1', 'Client');" onchange="getPartyClaimSoleSeparate(this, '1', 'Client');" <?php if(isset($drrealestate->Client_Real_Estate_SoleSeparate_Claim1) && $drrealestate->Client_Real_Estate_SoleSeparate_Claim1=='Yes'){ echo "checked"; } ?>> Yes</label>
                                        <label><input type="radio" id="Client_Real_Estate_SoleSeparate_Claim1_No" name="Client_Real_Estate_SoleSeparate_Claim1" value="No" data-onload="getInitialPartyClaimSoleSeparate(this, '1', 'Client');" onchange="getPartyClaimSoleSeparate(this, '1', 'Client');" <?php if(isset($drrealestate->Client_Real_Estate_SoleSeparate_Claim1) && $drrealestate->Client_Real_Estate_SoleSeparate_Claim1=='No'){ echo "checked"; } ?>> No</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6" id="Client_Real_Estate_SoleSeparate_Party1_Div" style="display: none;">
                                    <label>Who claims to own this Real Estate?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Client_Real_Estate_SoleSeparate_Party1_Client" name="Client_Real_Estate_SoleSeparate_Party1" value="{{$client_name}}" <?php if(isset($drrealestate->Client_Real_Estate_SoleSeparate_Party1) && $drrealestate->Client_Real_Estate_SoleSeparate_Party1==$client_name){ echo "checked"; } ?>> {{$client_name}}</label>
                                        <label><input type="radio" id="Client_Real_Estate_SoleSeparate_Party1_Op" name="Client_Real_Estate_SoleSeparate_Party1" value="{{$opponent_name}}" <?php if(isset($drrealestate->Client_Real_Estate_SoleSeparate_Party1) && $drrealestate->Client_Real_Estate_SoleSeparate_Party1==$opponent_name){ echo "checked"; } ?>> {{$opponent_name}}</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6" id="Client_Real_Estate_SoleSeparate_Grounds1_Div" style="display: none;">
                                    <label for="Client_Real_Estate_SoleSeparate_Grounds1">Why does this person own this Real Estate solely and separately?</label>
                                    <input id="Client_Real_Estate_SoleSeparate_Grounds1" type="text" class="form-control 1_Client_realestate_inputs" name="Client_Real_Estate_SoleSeparate_Grounds1" value="<?php if(isset($drrealestate->Client_Real_Estate_SoleSeparate_Grounds1)){ echo $drrealestate->Client_Real_Estate_SoleSeparate_Grounds1; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>How will this Real Estate value be distributed between the parties?</label>
                                    <div class="w-100 dataInput">
                                        <label><input type="radio" id="Client_Real_Estate_Disposition_Method1_Liquidate/Split_Net_Value" name="Client_Real_Estate_Disposition_Method1" value="Liquidate/Split Net Value" data-onload="getInitialDipositionMethod(this, '1', 'Client');" onchange="getDipositionMethod(this, '1', 'Client');" <?php if(isset($drrealestate->Client_Real_Estate_Disposition_Method1) && $drrealestate->Client_Real_Estate_Disposition_Method1=='Liquidate/Split Net Value'){ echo "checked"; } ?>> Liquidate/Split Net Value</label>
                                        <label><input type="radio" id="Client_Real_Estate_Disposition_Method1_Fixed_Buyout_Refinance" name="Client_Real_Estate_Disposition_Method1" value="Fixed Buyout/Refinance" data-onload="getInitialDipositionMethod(this, '1', 'Client');" onchange="getDipositionMethod(this, '1', 'Client');" <?php if(isset($drrealestate->Client_Real_Estate_Disposition_Method1) && $drrealestate->Client_Real_Estate_Disposition_Method1=='Fixed Buyout/Refinance'){ echo "checked"; } ?>> Fixed Buyout/Refinance</label>
                                    </div>
                                </div>
                                <!-- slider tool -->
                                <div class="form-group col-sm-6 m-auto 1_Client_Slider_Tool slider-tool-main">
                                    <div class="row">
                                        <div class="col">{{$client_name}}</div>
                                        <div class="col text-right">{{$opponent_name}}</div>
                                    </div>
                                    <input id="1_Client_balance_range_selector" type="range" class="form-control slider-tool-input 1_Client_balance_range_selector" name="" value="<?php if(isset($drrealestate->Client_Real_Estate_Percent_Marital_Equity_to_Op1)){ echo $drrealestate->Client_Real_Estate_Percent_Marital_Equity_to_Op1; } ?>" min="0.00" step="0.01" max="100" onchange="updateBalanceInput(this.value, '1', 'Client');">
                                </div>
                                <div class="form-group col-sm-6 m-auto 1_Client_Slider_Tool slider-tool-main">
                                    <div class="row justify-content-between">
                                        <div class="col selectorTool">
                                            <div class="left-col">
                                                <div class="client-info 1_Client_clientpercentage_div clientpercentage_div">
                                                    <?php if(isset($drrealestate->Client_Real_Estate_Percent_Marital_Equity_to_Client1)){ echo $drrealestate->Client_Real_Estate_Percent_Marital_Equity_to_Client1; } else {
                                                        echo '50.00';
                                                    } ?>%
                                                </div>
                                                <div class="client-info 1_Client_clientamount_div clientamount_div" style="clear: both;">
                                                    $<?php if(isset($drrealestate->Client_Real_Estate_Estimated_Value_to_Client1)){ echo $drrealestate->Client_Real_Estate_Estimated_Value_to_Client1; } else {
                                                        echo '0.00';
                                                    } ?>
                                                </div>
                                            </div>
                                            <label>To {{$client_name}}</label>
                                        </div>                                       
                                        <div class="col selectorTool selectorToolRight">
                                            <label>To {{$opponent_name}}</label>
                                            <div class="left-col right-col">
                                                <div class="client-info 1_Client_opponentpercentage_div opponentpercentage_div">
                                                    <?php if(isset($drrealestate->Client_Real_Estate_Percent_Marital_Equity_to_Op1)){ echo $drrealestate->Client_Real_Estate_Percent_Marital_Equity_to_Op1; } else {
                                                        echo '50.00';
                                                    } ?>%
                                                </div>
                                                <div class="client-info 1_Client_opponentamount_div opponentamount_div" style="clear: both;">
                                                    $<?php if(isset($drrealestate->Client_Real_Estate_Estimated_Value_to_Op1)){ echo $drrealestate->Client_Real_Estate_Estimated_Value_to_Op1; } else {
                                                        echo '0.00';
                                                    } ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 m-auto 1_Client_Slider_Tool slider-tool-main">
                                    <label></label>
                                    <div class="w-100">
                                        <label><input type="radio" id="1_Client_Real_Estate_Estimated_Value_Select" name="1_Client_Real_Estate_Estimated_Value_Select_Reset" class="Real_Estate_Estimated_Value_Select_Reset" value="Save"> Save this Distribution of Real Estate #1</label>
                                        <label><input type="radio" id="1_Client_Real_Estate_Estimated_Value_Reset" name="1_Client_Real_Estate_Estimated_Value_Select_Reset" class="Real_Estate_Estimated_Value_Select_Reset" value="Reset" onclick="resetBalanceInput(this, '1', 'Client');"> Reset to Default (50%)</label>
                                    </div>
                                </div>

                                <div class="form-group col-sm-6 Client_Real_Estate_Paying_Party1_Inputs_Div" style="display: none;">
                                    <label>Client Real Estate Paying Party1</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Client_Real_Estate_Paying_Party1_Client" name="Client_Real_Estate_Paying_Party1" value="{{$client_name}}" data-onload="getInitialRealEstatePayingParty(this, '1', 'Client');" onchange="getRealEstatePayingParty(this, '1', 'Client');" <?php if(isset($drrealestate->Client_Real_Estate_Paying_Party1) && $drrealestate->Client_Real_Estate_Paying_Party1==$client_name){ echo "checked"; } ?>> {{$client_name}}</label>
                                        <label><input type="radio" id="Client_Real_Estate_Paying_Party1_Op" name="Client_Real_Estate_Paying_Party1" value="{{$opponent_name}}" data-onload="getInitialRealEstatePayingParty(this, '1', 'Client');" onchange="getRealEstatePayingParty(this, '1', 'Client');" <?php if(isset($drrealestate->Client_Real_Estate_Paying_Party1) && $drrealestate->Client_Real_Estate_Paying_Party1==$opponent_name){ echo "checked"; } ?>> {{$opponent_name}}</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 Client_Real_Estate_Paying_Party1_Inputs_Div" style="display: none;">
                                    <label>{{$client_name}} Real Estate Equity Percent</label>
                                    <input id="Client_Real_Estate_Percent_Marital_Equity_to_Client1" type="number" class="form-control 1_Client_clientpercentage_input clientpercentage_input" name="Client_Real_Estate_Percent_Marital_Equity_to_Client1" value="<?php if(isset($drrealestate->Client_Real_Estate_Percent_Marital_Equity_to_Client1)){ echo $drrealestate->Client_Real_Estate_Percent_Marital_Equity_to_Client1; } ?>" min="0.00" step="0.01" max="100" readonly="">
                                </div>
                                <div class="form-group col-sm-6 Client_Real_Estate_Paying_Party1_Inputs_Div" style="display: none;">
                                    <label>How much is to be paid to {{$client_name}}?</label>
                                    <input id="Client_Real_Estate_Estimated_Value_to_Client1" type="number" class="form-control 1_Client_clientamount_input clientamount_input" name="Client_Real_Estate_Estimated_Value_to_Client1" value="<?php if(isset($drrealestate->Client_Real_Estate_Estimated_Value_to_Client1)){ echo $drrealestate->Client_Real_Estate_Estimated_Value_to_Client1; } ?>" min="0.00" step="0.01" max="999999.99" readonly="" onchange="getEstimatedValueClient(this, '1', 'Client');" onkeyup="getEstimatedValueClient(this, '1', 'Client');">
                                </div>
                                <div class="form-group col-sm-6 Client_Real_Estate_Paying_Party1_Inputs_Div" style="display: none;">
                                    <label>{{$opponent_name}} Real Estate Equity Percent</label>
                                    <input id="Client_Real_Estate_Percent_Marital_Equity_to_Op1" type="number" class="form-control 1_Client_opponentpercentage_input opponentpercentage_input" name="Client_Real_Estate_Percent_Marital_Equity_to_Op1" value="<?php if(isset($drrealestate->Client_Real_Estate_Percent_Marital_Equity_to_Op1)){ echo $drrealestate->Client_Real_Estate_Percent_Marital_Equity_to_Op1; } ?>" min="0.00" step="0.01" max="100" readonly="">
                                </div>
                                <div class="form-group col-sm-6 Client_Real_Estate_Paying_Party1_Inputs_Div" style="display: none;">
                                    <label>How much is to be paid to {{$opponent_name}}?</label>
                                    <input id="Client_Real_Estate_Estimated_Value_to_Op1" type="number" class="form-control 1_Client_opponentamount_input opponentamount_input" name="Client_Real_Estate_Estimated_Value_to_Op1" value="<?php if(isset($drrealestate->Client_Real_Estate_Estimated_Value_to_Op1)){ echo $drrealestate->Client_Real_Estate_Estimated_Value_to_Op1; } ?>" min="0.00" step="0.01" max="999999.99" readonly="" onchange="getEstimatedValueOp(this, '1', 'Client');" onkeyup="getEstimatedValueOp(this, '1', 'Client');">
                                </div>
                                <!-- end of slider tool -->
                            </div>
                            <div class="col-sm-12 mt-4 2_Client_realestate_section" style="display: none;"><h5 class="col-sm-12">Second Real Estate Info</h5>
                                <div class="form-group col-sm-6">
                                    <p class="text-danger 2_Client_no-state-county-found" style="display: none;">No City, State, County found for this zipcode.</p>
                                    <label for="Client_Real_Estate_ZIP2">ZIP code of this Property?</label>
                                    <input id="Client_Real_Estate_ZIP2" type="text" class="form-control 2_Client_realestate_inputs" name="Client_Real_Estate_ZIP2" value="<?php if(isset($drrealestate->Client_Real_Estate_ZIP2)){ echo $drrealestate->Client_Real_Estate_ZIP2; } ?>" data-onload="getCityStateForZip(this, '2', 'Client');" onkeyup="getCityStateForZip(this, '2', 'Client');"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Real_Estate_Street_Address2">This Property Street Address?</label>
                                    <input id="Client_Real_Estate_Street_Address2" type="text" class="form-control 2_Client_realestate_inputs" name="Client_Real_Estate_Street_Address2" value="<?php if(isset($drrealestate->Client_Real_Estate_Street_Address2)){ echo $drrealestate->Client_Real_Estate_Street_Address2; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Real_Estate_City2">This Property City?</label>
                                    <input type="hidden" name="" id="Client_Real_Estate_Institution_City2_Value" value="<?php if(isset($drrealestate->Client_Real_Estate_City2)){ echo $drrealestate->Client_Real_Estate_City2; } ?>">
                                    <select id="Client_Real_Estate_City2" name="Client_Real_Estate_City2" class="form-control 2_Client_city_select">
                                        <option value="">Choose City</option>
                                    </select>   
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Real_Estate_State2">This Property State?</label>
                                    <input type="hidden" name="" id="Client_Real_Estate_Institution_State2_Value" value="<?php if(isset($drrealestate->Client_Real_Estate_State2)){ echo $drrealestate->Client_Real_Estate_State2; } ?>">
                                    <select id="Client_Real_Estate_State2" name="Client_Real_Estate_State2" class="form-control 2_Client_state_select">
                                        <option value="">Choose State</option>
                                    </select>   
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Real_Estate_Current_Value2">Current Value?</label>
                                    <input id="Client_Real_Estate_Current_Value2" type="number" class="form-control 2_Client_realestate_inputs" name="Client_Real_Estate_Current_Value2" value="<?php if(isset($drrealestate->Client_Real_Estate_Current_Value2)){ echo $drrealestate->Client_Real_Estate_Current_Value2; } ?>" min="0.00" step="0.01" max="999999.99" onchange="getJointCurrentValue(this, '2', 'Client');" onkeyup="getJointCurrentValue(this, '2', 'Client');"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Real_Estate_First_Mortgage_Company_Name2">Name of First Mortgage/Loan Company for this Property?</label>
                                    <input id="Client_Real_Estate_First_Mortgage_Company_Name2" type="text" class="form-control 2_Client_realestate_inputs" name="Client_Real_Estate_First_Mortgage_Company_Name2" value="<?php if(isset($drrealestate->Client_Real_Estate_First_Mortgage_Company_Name2)){ echo $drrealestate->Client_Real_Estate_First_Mortgage_Company_Name2; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Real_Estate_First_Mortgage_Balance2">Balance owed on First Mortgage/Loan for this Property?</label>
                                    <input id="Client_Real_Estate_First_Mortgage_Balance2" type="number" class="form-control 2_Client_realestate_inputs" name="Client_Real_Estate_First_Mortgage_Balance2" value="<?php if(isset($drrealestate->Client_Real_Estate_First_Mortgage_Balance2)){ echo $drrealestate->Client_Real_Estate_First_Mortgage_Balance2; } ?>" onchange="getMaritalEquity(this, '2', 'Client');" onkeyup="getMaritalEquity(this, '2', 'Client');" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Real_Estate_First_Mortgage_Monthly_Payment2">Monthly payment for First Mortgage/Loan for this Property?</label>
                                    <input id="Client_Real_Estate_First_Mortgage_Monthly_Payment2" type="number" class="form-control 2_Client_realestate_inputs" name="Client_Real_Estate_First_Mortgage_Monthly_Payment2" value="<?php if(isset($drrealestate->Client_Real_Estate_First_Mortgage_Monthly_Payment2)){ echo $drrealestate->Client_Real_Estate_First_Mortgage_Monthly_Payment2; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Real_Estate_Second_Mortgage_LOC_Company_Name2">Name of Second Mortgage/Loan Company for this Property?</label>
                                    <input id="Client_Real_Estate_Second_Mortgage_LOC_Company_Name2" type="text" class="form-control 2_Client_realestate_inputs" name="Client_Real_Estate_Second_Mortgage_LOC_Company_Name2" value="<?php if(isset($drrealestate->Client_Real_Estate_Second_Mortgage_LOC_Company_Name2)){ echo $drrealestate->Client_Real_Estate_Second_Mortgage_LOC_Company_Name2; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Real_Estate_Second_Mortgage_LOC_Balance2">Balance owed on Second Mortgage/Loan for this Property?</label>
                                    <input id="Client_Real_Estate_Second_Mortgage_LOC_Balance2" type="number" class="form-control 2_Client_realestate_inputs" name="Client_Real_Estate_Second_Mortgage_LOC_Balance2" value="<?php if(isset($drrealestate->Client_Real_Estate_Second_Mortgage_LOC_Balance2)){ echo $drrealestate->Client_Real_Estate_Second_Mortgage_LOC_Balance2; } ?>" onchange="getMaritalEquity(this, '2', 'Client');" onkeyup="getMaritalEquity(this, '2', 'Client');" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Real_Estate_Second_Mortgage_LOC_Monthly_Payment2">Monthly payment for Second Mortgage/Loan for this Property?</label>
                                    <input id="Client_Real_Estate_Second_Mortgage_LOC_Monthly_Payment2" type="number" class="form-control 2_Client_realestate_inputs" name="Client_Real_Estate_Second_Mortgage_LOC_Monthly_Payment2" value="<?php if(isset($drrealestate->Client_Real_Estate_Second_Mortgage_LOC_Monthly_Payment2)){ echo $drrealestate->Client_Real_Estate_Second_Mortgage_LOC_Monthly_Payment2; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Real_Estate_MaritalEquity2">Marital Equity</label>
                                    <input id="Client_Real_Estate_MaritalEquity2" type="number" class="form-control 2_Client_realestate_inputs" name="Client_Real_Estate_MaritalEquity2" readonly value="<?php if(isset($drrealestate->Client_Real_Estate_MaritalEquity2)){ echo $drrealestate->Client_Real_Estate_MaritalEquity2; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Is this Property a Rental/Investment Property?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Client_Real_Estate_Rental2_Yes" name="Client_Real_Estate_Rental2" value="Yes" data-onload="getInitialRentalProperty(this, '2', 'Client');" onchange="getRentalProperty(this, '2', 'Client');" <?php if(isset($drrealestate->Client_Real_Estate_Rental2) && $drrealestate->Client_Real_Estate_Rental2=='Yes'){ echo "checked"; $hide='style="display: none;"'; } ?>> Yes</label>
                                        <label><input type="radio" id="Client_Real_Estate_Rental2_No" name="Client_Real_Estate_Rental2" value="No" data-onload="getInitialRentalProperty(this, '2', 'Client');" onchange="getRentalProperty(this, '2', 'Client');" <?php if(isset($drrealestate->Client_Real_Estate_Rental2) && $drrealestate->Client_Real_Estate_Rental2=='No'){ echo "checked"; $hide=''; } ?>> No</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Real_Estate_Yearly_Net_Rental_Income2">{{$client_name}} Real Estate Yearly Net Rental Income2</label>
                                    <input id="Client_Real_Estate_Yearly_Net_Rental_Income2" type="number" class="form-control 2_Client_realestate_inputs" name="Client_Real_Estate_Yearly_Net_Rental_Income2" onchange="getYearlyNetRentalIncome(this, '2', 'Client');" onkeyup="getYearlyNetRentalIncome(this, '2', 'Client');" value="<?php if(isset($drrealestate->Client_Real_Estate_Yearly_Net_Rental_Income2)){ echo $drrealestate->Client_Real_Estate_Yearly_Net_Rental_Income2; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6 Client_Real_Estate_Rental2_Input_Div">
                                    <label for="Client_Real_Estate_Client_Share_Rental2">{{$client_name}} Share of Yearly Net Rent</label>
                                    <input id="Client_Real_Estate_Client_Share_Rental2" type="number" class="form-control 2_Client_realestate_inputs" name="Client_Real_Estate_Client_Share_Rental2" value="<?php if(isset($drrealestate->Client_Real_Estate_Client_Share_Rental2)){ echo $drrealestate->Client_Real_Estate_Client_Share_Rental2; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6 Client_Real_Estate_Rental2_Input_Div">
                                    <label for="Client_Real_Estate_Op_Share_Rental2">{{$opponent_name}} Share of Yearly Net Rent</label>
                                    <input id="Client_Real_Estate_Op_Share_Rental2" type="number" class="form-control 2_Client_realestate_inputs" name="Client_Real_Estate_Op_Share_Rental2" value="<?php if(isset($drrealestate->Client_Real_Estate_Op_Share_Rental2)){ echo $drrealestate->Client_Real_Estate_Op_Share_Rental2; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Does either party claim a sole/separate interest in this Real Estate?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Client_Real_Estate_SoleSeparate_Claim2_Yes" name="Client_Real_Estate_SoleSeparate_Claim2" value="Yes" data-onload="getInitialPartyClaimSoleSeparate(this, '2', 'Client');" onchange="getPartyClaimSoleSeparate(this, '2', 'Client');" <?php if(isset($drrealestate->Client_Real_Estate_SoleSeparate_Claim2) && $drrealestate->Client_Real_Estate_SoleSeparate_Claim2=='Yes'){ echo "checked"; } ?>> Yes</label>
                                        <label><input type="radio" id="Client_Real_Estate_SoleSeparate_Claim2_No" name="Client_Real_Estate_SoleSeparate_Claim2" value="No" data-onload="getInitialPartyClaimSoleSeparate(this, '2', 'Client');" onchange="getPartyClaimSoleSeparate(this, '2', 'Client');" <?php if(isset($drrealestate->Client_Real_Estate_SoleSeparate_Claim2) && $drrealestate->Client_Real_Estate_SoleSeparate_Claim2=='No'){ echo "checked"; } ?>> No</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6" id="Client_Real_Estate_SoleSeparate_Party2_Div" style="display: none;">
                                    <label>Who claims to own this Real Estate?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Client_Real_Estate_SoleSeparate_Party2_Client" name="Client_Real_Estate_SoleSeparate_Party2" value="{{$client_name}}" <?php if(isset($drrealestate->Client_Real_Estate_SoleSeparate_Party2) && $drrealestate->Client_Real_Estate_SoleSeparate_Party2==$client_name){ echo "checked"; } ?>> {{$client_name}}</label>
                                        <label><input type="radio" id="Client_Real_Estate_SoleSeparate_Party2_Op" name="Client_Real_Estate_SoleSeparate_Party2" value="{{$opponent_name}}" <?php if(isset($drrealestate->Client_Real_Estate_SoleSeparate_Party2) && $drrealestate->Client_Real_Estate_SoleSeparate_Party2==$opponent_name){ echo "checked"; } ?>> {{$opponent_name}}</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6" id="Client_Real_Estate_SoleSeparate_Grounds2_Div" style="display: none;">
                                    <label for="Client_Real_Estate_SoleSeparate_Grounds2">Why does this person own this Real Estate solely and separately?</label>
                                    <input id="Client_Real_Estate_SoleSeparate_Grounds2" type="text" class="form-control 2_Client_realestate_inputs" name="Client_Real_Estate_SoleSeparate_Grounds2" value="<?php if(isset($drrealestate->Client_Real_Estate_SoleSeparate_Grounds2)){ echo $drrealestate->Client_Real_Estate_SoleSeparate_Grounds2; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>How will this Real Estate value be distributed between the parties?</label>
                                    <div class="w-100 dataInput">
                                        <label><input type="radio" id="Client_Real_Estate_Disposition_Method2_Liquidate/Split_Net_Value" name="Client_Real_Estate_Disposition_Method2" value="Liquidate/Split Net Value" data-onload="getInitialDipositionMethod(this, '2', 'Client');" onchange="getDipositionMethod(this, '2', 'Client');" <?php if(isset($drrealestate->Client_Real_Estate_Disposition_Method2) && $drrealestate->Client_Real_Estate_Disposition_Method2=='Liquidate/Split Net Value'){ echo "checked"; } ?>> Liquidate/Split Net Value</label>
                                        <label><input type="radio" id="Client_Real_Estate_Disposition_Method2_Fixed_Buyout_Refinance" name="Client_Real_Estate_Disposition_Method2" value="Fixed Buyout/Refinance" data-onload="getInitialDipositionMethod(this, '2', 'Client');" onchange="getDipositionMethod(this, '2', 'Client');" <?php if(isset($drrealestate->Client_Real_Estate_Disposition_Method2) && $drrealestate->Client_Real_Estate_Disposition_Method2=='Fixed Buyout/Refinance'){ echo "checked"; } ?>> Fixed Buyout/Refinance</label>
                                    </div>
                                </div>
                                <!-- slider tool -->
                                <div class="form-group col-sm-6 m-auto 2_Client_Slider_Tool slider-tool-main">
                                    <div class="row">
                                        <div class="col">{{$client_name}}</div>
                                        <div class="col text-right">{{$opponent_name}}</div>
                                    </div>
                                    <input id="2_Client_balance_range_selector" type="range" class="form-control slider-tool-input 2_Client_balance_range_selector" name="" value="<?php if(isset($drrealestate->Client_Real_Estate_Percent_Marital_Equity_to_Op2)){ echo $drrealestate->Client_Real_Estate_Percent_Marital_Equity_to_Op2; } ?>" min="0.00" step="0.01" max="100" onchange="updateBalanceInput(this.value, '2', 'Client');">
                                </div>
                                <div class="form-group col-sm-6 m-auto 2_Client_Slider_Tool slider-tool-main">
                                    <div class="row justify-content-between">
                                        <div class="col selectorTool">
                                            <div class="left-col">
                                                <div class="client-info 2_Client_clientpercentage_div clientpercentage_div">
                                                    <?php if(isset($drrealestate->Client_Real_Estate_Percent_Marital_Equity_to_Client2)){ echo $drrealestate->Client_Real_Estate_Percent_Marital_Equity_to_Client2; } else {
                                                        echo '50.00';
                                                    } ?>%
                                                </div>
                                                <div class="client-info 2_Client_clientamount_div clientamount_div" style="clear: both;">
                                                    $<?php if(isset($drrealestate->Client_Real_Estate_Estimated_Value_to_Client2)){ echo $drrealestate->Client_Real_Estate_Estimated_Value_to_Client2; } else {
                                                        echo '0.00';
                                                    } ?>
                                                </div>
                                            </div>
                                            <label>To {{$client_name}}</label>
                                        </div>                                       
                                        <div class="col selectorTool selectorToolRight">
                                            <label>To {{$opponent_name}}</label>
                                            <div class="left-col right-col">
                                                <div class="client-info 2_Client_opponentpercentage_div opponentpercentage_div">
                                                    <?php if(isset($drrealestate->Client_Real_Estate_Percent_Marital_Equity_to_Op2)){ echo $drrealestate->Client_Real_Estate_Percent_Marital_Equity_to_Op2; } else {
                                                        echo '50.00';
                                                    } ?>%
                                                </div>
                                                <div class="client-info 2_Client_opponentamount_div opponentamount_div" style="clear: both;">
                                                    $<?php if(isset($drrealestate->Client_Real_Estate_Estimated_Value_to_Op2)){ echo $drrealestate->Client_Real_Estate_Estimated_Value_to_Op2; } else {
                                                        echo '0.00';
                                                    } ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 m-auto 2_Client_Slider_Tool slider-tool-main">
                                    <label></label>
                                    <div class="w-100">
                                        <label><input type="radio" id="2_Client_Real_Estate_Estimated_Value_Select" name="2_Client_Real_Estate_Estimated_Value_Select_Reset" class="Real_Estate_Estimated_Value_Select_Reset" value="Save"> Save this Distribution of Real Estate #2</label>
                                        <label><input type="radio" id="2_Client_Real_Estate_Estimated_Value_Reset" name="2_Client_Real_Estate_Estimated_Value_Select_Reset" class="Real_Estate_Estimated_Value_Select_Reset" value="Reset" onclick="resetBalanceInput(this, '2', 'Client');"> Reset to Default (50%)</label>
                                    </div>
                                </div>

                                <div class="form-group col-sm-6 Client_Real_Estate_Paying_Party2_Inputs_Div" style="display: none;">
                                    <label>Client Real Estate Paying Party2</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Client_Real_Estate_Paying_Party2_Client" name="Client_Real_Estate_Paying_Party2" value="{{$client_name}}" data-onload="getInitialRealEstatePayingParty(this, '2', 'Client');" onchange="getRealEstatePayingParty(this, '2', 'Client');" <?php if(isset($drrealestate->Client_Real_Estate_Paying_Party2) && $drrealestate->Client_Real_Estate_Paying_Party2==$client_name){ echo "checked"; } ?>> {{$client_name}}</label>
                                        <label><input type="radio" id="Client_Real_Estate_Paying_Party2_Op" name="Client_Real_Estate_Paying_Party2" value="{{$opponent_name}}" data-onload="getInitialRealEstatePayingParty(this, '2', 'Client');" onchange="getRealEstatePayingParty(this, '2', 'Client');" <?php if(isset($drrealestate->Client_Real_Estate_Paying_Party2) && $drrealestate->Client_Real_Estate_Paying_Party2==$opponent_name){ echo "checked"; } ?>> {{$opponent_name}}</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 Client_Real_Estate_Paying_Party2_Inputs_Div" style="display: none;">
                                    <label>{{$client_name}} Real Estate Equity Percent</label>
                                    <input id="Client_Real_Estate_Percent_Marital_Equity_to_Client2" type="number" class="form-control 2_Client_clientpercentage_input clientpercentage_input" name="Client_Real_Estate_Percent_Marital_Equity_to_Client2" value="<?php if(isset($drrealestate->Client_Real_Estate_Percent_Marital_Equity_to_Client2)){ echo $drrealestate->Client_Real_Estate_Percent_Marital_Equity_to_Client2; } ?>" min="0.00" step="0.01" max="100" readonly="">
                                </div>
                                <div class="form-group col-sm-6 Client_Real_Estate_Paying_Party2_Inputs_Div" style="display: none;">
                                    <label>How much is to be paid to {{$client_name}}?</label>
                                    <input id="Client_Real_Estate_Estimated_Value_to_Client2" type="number" class="form-control 2_Client_clientamount_input clientamount_input" name="Client_Real_Estate_Estimated_Value_to_Client2" value="<?php if(isset($drrealestate->Client_Real_Estate_Estimated_Value_to_Client2)){ echo $drrealestate->Client_Real_Estate_Estimated_Value_to_Client2; } ?>" min="0.00" step="0.01" max="999999.99" readonly="" onchange="getEstimatedValueClient(this, '2', 'Client');" onkeyup="getEstimatedValueClient(this, '2', 'Client');">
                                </div>
                                <div class="form-group col-sm-6 Client_Real_Estate_Paying_Party2_Inputs_Div" style="display: none;">
                                    <label>{{$opponent_name}} Real Estate Equity Percent</label>
                                    <input id="Client_Real_Estate_Percent_Marital_Equity_to_Op2" type="number" class="form-control 2_Client_opponentpercentage_input opponentpercentage_input" name="Client_Real_Estate_Percent_Marital_Equity_to_Op2" value="<?php if(isset($drrealestate->Client_Real_Estate_Percent_Marital_Equity_to_Op2)){ echo $drrealestate->Client_Real_Estate_Percent_Marital_Equity_to_Op2; } ?>" min="0.00" step="0.01" max="100" readonly="">
                                </div>
                                <div class="form-group col-sm-6 Client_Real_Estate_Paying_Party2_Inputs_Div" style="display: none;">
                                    <label>How much is to be paid to {{$opponent_name}}?</label>
                                    <input id="Client_Real_Estate_Estimated_Value_to_Op2" type="number" class="form-control 2_Client_opponentamount_input opponentamount_input" name="Client_Real_Estate_Estimated_Value_to_Op2" value="<?php if(isset($drrealestate->Client_Real_Estate_Estimated_Value_to_Op2)){ echo $drrealestate->Client_Real_Estate_Estimated_Value_to_Op2; } ?>" min="0.00" step="0.01" max="999999.99" readonly="" onchange="getEstimatedValueOp(this, '2', 'Client');" onkeyup="getEstimatedValueOp(this, '2', 'Client');">
                                </div>
                                <!-- end of slider tool -->
                            </div>
                            <div class="col-sm-12 mt-4 3_Client_realestate_section" style="display: none;"><h5 class="col-sm-12">Third Real Estate Info</h5>
                                <div class="form-group col-sm-6">
                                    <p class="text-danger 3_Client_no-state-county-found" style="display: none;">No City, State, County found for this zipcode.</p>
                                    <label for="Client_Real_Estate_ZIP3">ZIP code of this Property?</label>
                                    <input id="Client_Real_Estate_ZIP3" type="text" class="form-control 3_Client_realestate_inputs" name="Client_Real_Estate_ZIP3" value="<?php if(isset($drrealestate->Client_Real_Estate_ZIP3)){ echo $drrealestate->Client_Real_Estate_ZIP3; } ?>" data-onload="getCityStateForZip(this, '3', 'Client');" onkeyup="getCityStateForZip(this, '3', 'Client');"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Real_Estate_Street_Address3">This Property Street Address?</label>
                                    <input id="Client_Real_Estate_Street_Address3" type="text" class="form-control 3_Client_realestate_inputs" name="Client_Real_Estate_Street_Address3" value="<?php if(isset($drrealestate->Client_Real_Estate_Street_Address3)){ echo $drrealestate->Client_Real_Estate_Street_Address3; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Real_Estate_City3">This Property City?</label>
                                    <input type="hidden" name="" id="Client_Real_Estate_Institution_City3_Value" value="<?php if(isset($drrealestate->Client_Real_Estate_City3)){ echo $drrealestate->Client_Real_Estate_City3; } ?>">
                                    <select id="Client_Real_Estate_City3" name="Client_Real_Estate_City3" class="form-control 3_Client_city_select">
                                        <option value="">Choose City</option>
                                    </select>   
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Real_Estate_State3">This Property State?</label>
                                    <input type="hidden" name="" id="Client_Real_Estate_Institution_State3_Value" value="<?php if(isset($drrealestate->Client_Real_Estate_State3)){ echo $drrealestate->Client_Real_Estate_State3; } ?>">
                                    <select id="Client_Real_Estate_State3" name="Client_Real_Estate_State3" class="form-control 3_Client_state_select">
                                        <option value="">Choose State</option>
                                    </select>   
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Real_Estate_Current_Value3">Current Value?</label>
                                    <input id="Client_Real_Estate_Current_Value3" type="number" class="form-control 3_Client_realestate_inputs" name="Client_Real_Estate_Current_Value3" value="<?php if(isset($drrealestate->Client_Real_Estate_Current_Value3)){ echo $drrealestate->Client_Real_Estate_Current_Value3; } ?>" min="0.00" step="0.01" max="999999.99" onchange="getJointCurrentValue(this, '3', 'Client');" onkeyup="getJointCurrentValue(this, '3', 'Client');"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Real_Estate_First_Mortgage_Company_Name3">Name of First Mortgage/Loan Company for this Property?</label>
                                    <input id="Client_Real_Estate_First_Mortgage_Company_Name3" type="text" class="form-control 3_Client_realestate_inputs" name="Client_Real_Estate_First_Mortgage_Company_Name3" value="<?php if(isset($drrealestate->Client_Real_Estate_First_Mortgage_Company_Name3)){ echo $drrealestate->Client_Real_Estate_First_Mortgage_Company_Name3; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Real_Estate_First_Mortgage_Balance3">Balance owed on First Mortgage/Loan for this Property?</label>
                                    <input id="Client_Real_Estate_First_Mortgage_Balance3" type="number" class="form-control 3_Client_realestate_inputs" name="Client_Real_Estate_First_Mortgage_Balance3" value="<?php if(isset($drrealestate->Client_Real_Estate_First_Mortgage_Balance3)){ echo $drrealestate->Client_Real_Estate_First_Mortgage_Balance3; } ?>" onchange="getMaritalEquity(this, '3', 'Client');" onkeyup="getMaritalEquity(this, '3', 'Client');" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Real_Estate_First_Mortgage_Monthly_Payment3">Monthly payment for First Mortgage/Loan for this Property?</label>
                                    <input id="Client_Real_Estate_First_Mortgage_Monthly_Payment3" type="number" class="form-control 3_Client_realestate_inputs" name="Client_Real_Estate_First_Mortgage_Monthly_Payment3" value="<?php if(isset($drrealestate->Client_Real_Estate_First_Mortgage_Monthly_Payment3)){ echo $drrealestate->Client_Real_Estate_First_Mortgage_Monthly_Payment3; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Real_Estate_Second_Mortgage_LOC_Company_Name3">Name of Second Mortgage/Loan Company for this Property?</label>
                                    <input id="Client_Real_Estate_Second_Mortgage_LOC_Company_Name3" type="text" class="form-control 3_Client_realestate_inputs" name="Client_Real_Estate_Second_Mortgage_LOC_Company_Name3" value="<?php if(isset($drrealestate->Client_Real_Estate_Second_Mortgage_LOC_Company_Name3)){ echo $drrealestate->Client_Real_Estate_Second_Mortgage_LOC_Company_Name3; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Real_Estate_Second_Mortgage_LOC_Balance3">Balance owed on Second Mortgage/Loan for this Property?</label>
                                    <input id="Client_Real_Estate_Second_Mortgage_LOC_Balance3" type="number" class="form-control 3_Client_realestate_inputs" name="Client_Real_Estate_Second_Mortgage_LOC_Balance3" value="<?php if(isset($drrealestate->Client_Real_Estate_Second_Mortgage_LOC_Balance3)){ echo $drrealestate->Client_Real_Estate_Second_Mortgage_LOC_Balance3; } ?>" onchange="getMaritalEquity(this, '3', 'Client');" onkeyup="getMaritalEquity(this, '3', 'Client');" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Real_Estate_Second_Mortgage_LOC_Monthly_Payment3">Monthly payment for Second Mortgage/Loan for this Property?</label>
                                    <input id="Client_Real_Estate_Second_Mortgage_LOC_Monthly_Payment3" type="number" class="form-control 3_Client_realestate_inputs" name="Client_Real_Estate_Second_Mortgage_LOC_Monthly_Payment3" value="<?php if(isset($drrealestate->Client_Real_Estate_Second_Mortgage_LOC_Monthly_Payment3)){ echo $drrealestate->Client_Real_Estate_Second_Mortgage_LOC_Monthly_Payment3; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Real_Estate_MaritalEquity3">Marital Equity</label>
                                    <input id="Client_Real_Estate_MaritalEquity3" type="number" class="form-control 3_Client_realestate_inputs" name="Client_Real_Estate_MaritalEquity3" readonly value="<?php if(isset($drrealestate->Client_Real_Estate_MaritalEquity3)){ echo $drrealestate->Client_Real_Estate_MaritalEquity3; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Is this Property a Rental/Investment Property?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Client_Real_Estate_Rental3_Yes" name="Client_Real_Estate_Rental3" value="Yes" data-onload="getInitialRentalProperty(this, '3', 'Client');" onchange="getRentalProperty(this, '3', 'Client');" <?php if(isset($drrealestate->Client_Real_Estate_Rental3) && $drrealestate->Client_Real_Estate_Rental3=='Yes'){ echo "checked"; $hide='style="display: none;"'; } ?>> Yes</label>
                                        <label><input type="radio" id="Client_Real_Estate_Rental3_No" name="Client_Real_Estate_Rental3" value="No" data-onload="getInitialRentalProperty(this, '3', 'Client');" onchange="getRentalProperty(this, '3', 'Client');" <?php if(isset($drrealestate->Client_Real_Estate_Rental3) && $drrealestate->Client_Real_Estate_Rental3=='No'){ echo "checked"; $hide=''; } ?>> No</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Real_Estate_Yearly_Net_Rental_Income3">{{$client_name}} Real Estate Yearly Net Rental Income3</label>
                                    <input id="Client_Real_Estate_Yearly_Net_Rental_Income3" type="number" class="form-control 3_Client_realestate_inputs" name="Client_Real_Estate_Yearly_Net_Rental_Income3" onchange="getYearlyNetRentalIncome(this, '3', 'Client');" onkeyup="getYearlyNetRentalIncome(this, '3', 'Client');" value="<?php if(isset($drrealestate->Client_Real_Estate_Yearly_Net_Rental_Income3)){ echo $drrealestate->Client_Real_Estate_Yearly_Net_Rental_Income3; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6 Client_Real_Estate_Rental3_Input_Div">
                                    <label for="Client_Real_Estate_Client_Share_Rental3">{{$client_name}} Share of Yearly Net Rent</label>
                                    <input id="Client_Real_Estate_Client_Share_Rental3" type="number" class="form-control 3_Client_realestate_inputs" name="Client_Real_Estate_Client_Share_Rental3" value="<?php if(isset($drrealestate->Client_Real_Estate_Client_Share_Rental3)){ echo $drrealestate->Client_Real_Estate_Client_Share_Rental3; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6 Client_Real_Estate_Rental3_Input_Div">
                                    <label for="Client_Real_Estate_Op_Share_Rental3">{{$opponent_name}} Share of Yearly Net Rent</label>
                                    <input id="Client_Real_Estate_Op_Share_Rental3" type="number" class="form-control 3_Client_realestate_inputs" name="Client_Real_Estate_Op_Share_Rental3" value="<?php if(isset($drrealestate->Client_Real_Estate_Op_Share_Rental3)){ echo $drrealestate->Client_Real_Estate_Op_Share_Rental3; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Does either party claim a sole/separate interest in this Real Estate?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Client_Real_Estate_SoleSeparate_Claim3_Yes" name="Client_Real_Estate_SoleSeparate_Claim3" value="Yes" data-onload="getInitialPartyClaimSoleSeparate(this, '3', 'Client');" onchange="getPartyClaimSoleSeparate(this, '3', 'Client');" <?php if(isset($drrealestate->Client_Real_Estate_SoleSeparate_Claim3) && $drrealestate->Client_Real_Estate_SoleSeparate_Claim3=='Yes'){ echo "checked"; } ?>> Yes</label>
                                        <label><input type="radio" id="Client_Real_Estate_SoleSeparate_Claim3_No" name="Client_Real_Estate_SoleSeparate_Claim3" value="No" data-onload="getInitialPartyClaimSoleSeparate(this, '3', 'Client');" onchange="getPartyClaimSoleSeparate(this, '3', 'Client');" <?php if(isset($drrealestate->Client_Real_Estate_SoleSeparate_Claim3) && $drrealestate->Client_Real_Estate_SoleSeparate_Claim3=='No'){ echo "checked"; } ?>> No</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6" id="Client_Real_Estate_SoleSeparate_Party3_Div" style="display: none;">
                                    <label>Who claims to own this Real Estate?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Client_Real_Estate_SoleSeparate_Party3_Client" name="Client_Real_Estate_SoleSeparate_Party3" value="{{$client_name}}" <?php if(isset($drrealestate->Client_Real_Estate_SoleSeparate_Party3) && $drrealestate->Client_Real_Estate_SoleSeparate_Party3==$client_name){ echo "checked"; } ?>> {{$client_name}}</label>
                                        <label><input type="radio" id="Client_Real_Estate_SoleSeparate_Party3_Op" name="Client_Real_Estate_SoleSeparate_Party3" value="{{$opponent_name}}" <?php if(isset($drrealestate->Client_Real_Estate_SoleSeparate_Party3) && $drrealestate->Client_Real_Estate_SoleSeparate_Party3==$opponent_name){ echo "checked"; } ?>> {{$opponent_name}}</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6" id="Client_Real_Estate_SoleSeparate_Grounds3_Div" style="display: none;">
                                    <label for="Client_Real_Estate_SoleSeparate_Grounds3">Why does this person own this Real Estate solely and separately?</label>
                                    <input id="Client_Real_Estate_SoleSeparate_Grounds3" type="text" class="form-control 3_Client_realestate_inputs" name="Client_Real_Estate_SoleSeparate_Grounds3" value="<?php if(isset($drrealestate->Client_Real_Estate_SoleSeparate_Grounds3)){ echo $drrealestate->Client_Real_Estate_SoleSeparate_Grounds3; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>How will this Real Estate value be distributed between the parties?</label>
                                    <div class="w-100 dataInput">
                                        <label><input type="radio" id="Client_Real_Estate_Disposition_Method3_Liquidate/Split_Net_Value" name="Client_Real_Estate_Disposition_Method3" value="Liquidate/Split Net Value" data-onload="getInitialDipositionMethod(this, '3', 'Client');" onchange="getDipositionMethod(this, '3', 'Client');" <?php if(isset($drrealestate->Client_Real_Estate_Disposition_Method3) && $drrealestate->Client_Real_Estate_Disposition_Method3=='Liquidate/Split Net Value'){ echo "checked"; } ?>> Liquidate/Split Net Value</label>
                                        <label><input type="radio" id="Client_Real_Estate_Disposition_Method3_Fixed_Buyout_Refinance" name="Client_Real_Estate_Disposition_Method3" value="Fixed Buyout/Refinance" data-onload="getInitialDipositionMethod(this, '3', 'Client');" onchange="getDipositionMethod(this, '3', 'Client');" <?php if(isset($drrealestate->Client_Real_Estate_Disposition_Method3) && $drrealestate->Client_Real_Estate_Disposition_Method3=='Fixed Buyout/Refinance'){ echo "checked"; } ?>> Fixed Buyout/Refinance</label>
                                    </div>
                                </div>
                                <!-- slider tool -->
                                <div class="form-group col-sm-6 m-auto 3_Client_Slider_Tool slider-tool-main">
                                    <div class="row">
                                        <div class="col">{{$client_name}}</div>
                                        <div class="col text-right">{{$opponent_name}}</div>
                                    </div>
                                    <input id="3_Client_balance_range_selector" type="range" class="form-control slider-tool-input 3_Client_balance_range_selector" name="" value="<?php if(isset($drrealestate->Client_Real_Estate_Percent_Marital_Equity_to_Op3)){ echo $drrealestate->Client_Real_Estate_Percent_Marital_Equity_to_Op3; } ?>" min="0.00" step="0.01" max="100" onchange="updateBalanceInput(this.value, '3', 'Client');">
                                </div>
                                <div class="form-group col-sm-6 m-auto 3_Client_Slider_Tool slider-tool-main">
                                    <div class="row justify-content-between">
                                        <div class="col selectorTool">
                                            <div class="left-col">
                                                <div class="client-info 3_Client_clientpercentage_div clientpercentage_div">
                                                    <?php if(isset($drrealestate->Client_Real_Estate_Percent_Marital_Equity_to_Client3)){ echo $drrealestate->Client_Real_Estate_Percent_Marital_Equity_to_Client3; } else {
                                                        echo '50.00';
                                                    } ?>%
                                                </div>
                                                <div class="client-info 3_Client_clientamount_div clientamount_div" style="clear: both;">
                                                    $<?php if(isset($drrealestate->Client_Real_Estate_Estimated_Value_to_Client3)){ echo $drrealestate->Client_Real_Estate_Estimated_Value_to_Client3; } else {
                                                        echo '0.00';
                                                    } ?>
                                                </div>
                                            </div>
                                            <label>To {{$client_name}}</label>
                                        </div>                                       
                                        <div class="col selectorTool selectorToolRight">
                                            <label>To {{$opponent_name}}</label>
                                            <div class="left-col right-col">
                                                <div class="client-info 3_Client_opponentpercentage_div opponentpercentage_div">
                                                    <?php if(isset($drrealestate->Client_Real_Estate_Percent_Marital_Equity_to_Op3)){ echo $drrealestate->Client_Real_Estate_Percent_Marital_Equity_to_Op3; } else {
                                                        echo '50.00';
                                                    } ?>%
                                                </div>
                                                <div class="client-info 3_Client_opponentamount_div opponentamount_div" style="clear: both;">
                                                    $<?php if(isset($drrealestate->Client_Real_Estate_Estimated_Value_to_Op3)){ echo $drrealestate->Client_Real_Estate_Estimated_Value_to_Op3; } else {
                                                        echo '0.00';
                                                    } ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 m-auto 3_Client_Slider_Tool slider-tool-main">
                                    <label></label>
                                    <div class="w-100">
                                        <label><input type="radio" id="3_Client_Real_Estate_Estimated_Value_Select" name="3_Client_Real_Estate_Estimated_Value_Select_Reset" class="Real_Estate_Estimated_Value_Select_Reset" value="Save"> Save this Distribution of Real Estate #3</label>
                                        <label><input type="radio" id="3_Client_Real_Estate_Estimated_Value_Reset" name="3_Client_Real_Estate_Estimated_Value_Select_Reset" class="Real_Estate_Estimated_Value_Select_Reset" value="Reset" onclick="resetBalanceInput(this, '3', 'Client');"> Reset to Default (50%)</label>
                                    </div>
                                </div>

                                <div class="form-group col-sm-6 Client_Real_Estate_Paying_Party3_Inputs_Div" style="display: none;">
                                    <label>Client Real Estate Paying Party3</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Client_Real_Estate_Paying_Party3_Client" name="Client_Real_Estate_Paying_Party3" value="{{$client_name}}" data-onload="getInitialRealEstatePayingParty(this, '3', 'Client');" onchange="getRealEstatePayingParty(this, '3', 'Client');" <?php if(isset($drrealestate->Client_Real_Estate_Paying_Party3) && $drrealestate->Client_Real_Estate_Paying_Party3==$client_name){ echo "checked"; } ?>> {{$client_name}}</label>
                                        <label><input type="radio" id="Client_Real_Estate_Paying_Party3_Op" name="Client_Real_Estate_Paying_Party3" value="{{$opponent_name}}" data-onload="getInitialRealEstatePayingParty(this, '3', 'Client');" onchange="getRealEstatePayingParty(this, '3', 'Client');" <?php if(isset($drrealestate->Client_Real_Estate_Paying_Party3) && $drrealestate->Client_Real_Estate_Paying_Party3==$opponent_name){ echo "checked"; } ?>> {{$opponent_name}}</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 Client_Real_Estate_Paying_Party3_Inputs_Div" style="display: none;">
                                    <label>{{$client_name}} Real Estate Equity Percent</label>
                                    <input id="Client_Real_Estate_Percent_Marital_Equity_to_Client3" type="number" class="form-control 3_Client_clientpercentage_input clientpercentage_input" name="Client_Real_Estate_Percent_Marital_Equity_to_Client3" value="<?php if(isset($drrealestate->Client_Real_Estate_Percent_Marital_Equity_to_Client3)){ echo $drrealestate->Client_Real_Estate_Percent_Marital_Equity_to_Client3; } ?>" min="0.00" step="0.01" max="100" readonly="">
                                </div>
                                <div class="form-group col-sm-6 Client_Real_Estate_Paying_Party3_Inputs_Div" style="display: none;">
                                    <label>How much is to be paid to {{$client_name}}?</label>
                                    <input id="Client_Real_Estate_Estimated_Value_to_Client3" type="number" class="form-control 3_Client_clientamount_input clientamount_input" name="Client_Real_Estate_Estimated_Value_to_Client3" value="<?php if(isset($drrealestate->Client_Real_Estate_Estimated_Value_to_Client3)){ echo $drrealestate->Client_Real_Estate_Estimated_Value_to_Client3; } ?>" min="0.00" step="0.01" max="999999.99" readonly="" onchange="getEstimatedValueClient(this, '3', 'Client');" onkeyup="getEstimatedValueClient(this, '3', 'Client');">
                                </div>
                                <div class="form-group col-sm-6 Client_Real_Estate_Paying_Party3_Inputs_Div" style="display: none;">
                                    <label>{{$opponent_name}} Real Estate Equity Percent</label>
                                    <input id="Client_Real_Estate_Percent_Marital_Equity_to_Op3" type="number" class="form-control 3_Client_opponentpercentage_input opponentpercentage_input" name="Client_Real_Estate_Percent_Marital_Equity_to_Op3" value="<?php if(isset($drrealestate->Client_Real_Estate_Percent_Marital_Equity_to_Op3)){ echo $drrealestate->Client_Real_Estate_Percent_Marital_Equity_to_Op3; } ?>" min="0.00" step="0.01" max="100" readonly="">
                                </div>
                                <div class="form-group col-sm-6 Client_Real_Estate_Paying_Party3_Inputs_Div" style="display: none;">
                                    <label>How much is to be paid to {{$opponent_name}}?</label>
                                    <input id="Client_Real_Estate_Estimated_Value_to_Op3" type="number" class="form-control 3_Client_opponentamount_input opponentamount_input" name="Client_Real_Estate_Estimated_Value_to_Op3" value="<?php if(isset($drrealestate->Client_Real_Estate_Estimated_Value_to_Op3)){ echo $drrealestate->Client_Real_Estate_Estimated_Value_to_Op3; } ?>" min="0.00" step="0.01" max="999999.99" readonly="" onchange="getEstimatedValueOp(this, '3', 'Client');" onkeyup="getEstimatedValueOp(this, '3', 'Client');">
                                </div>
                                <!-- end of slider tool -->
                            </div>
                            <div class="col-sm-12 mt-4 4_Client_realestate_section" style="display: none;"><h5 class="col-sm-12">Fourth Real Estate Info</h5>
                                <div class="form-group col-sm-6">
                                    <p class="text-danger 4_Client_no-state-county-found" style="display: none;">No City, State, County found for this zipcode.</p>
                                    <label for="Client_Real_Estate_ZIP4">ZIP code of this Property?</label>
                                    <input id="Client_Real_Estate_ZIP4" type="text" class="form-control 4_Client_realestate_inputs" name="Client_Real_Estate_ZIP4" value="<?php if(isset($drrealestate->Client_Real_Estate_ZIP4)){ echo $drrealestate->Client_Real_Estate_ZIP4; } ?>" data-onload="getCityStateForZip(this, '4', 'Client');" onkeyup="getCityStateForZip(this, '4', 'Client');"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Real_Estate_Street_Address4">This Property Street Address?</label>
                                    <input id="Client_Real_Estate_Street_Address4" type="text" class="form-control 4_Client_realestate_inputs" name="Client_Real_Estate_Street_Address4" value="<?php if(isset($drrealestate->Client_Real_Estate_Street_Address4)){ echo $drrealestate->Client_Real_Estate_Street_Address4; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Real_Estate_City4">This Property City?</label>
                                    <input type="hidden" name="" id="Client_Real_Estate_Institution_City4_Value" value="<?php if(isset($drrealestate->Client_Real_Estate_City4)){ echo $drrealestate->Client_Real_Estate_City4; } ?>">
                                    <select id="Client_Real_Estate_City4" name="Client_Real_Estate_City4" class="form-control 4_Client_city_select">
                                        <option value="">Choose City</option>
                                    </select>   
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Real_Estate_State4">This Property State?</label>
                                    <input type="hidden" name="" id="Client_Real_Estate_Institution_State4_Value" value="<?php if(isset($drrealestate->Client_Real_Estate_State4)){ echo $drrealestate->Client_Real_Estate_State4; } ?>">
                                    <select id="Client_Real_Estate_State4" name="Client_Real_Estate_State4" class="form-control 4_Client_state_select">
                                        <option value="">Choose State</option>
                                    </select>   
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Real_Estate_Current_Value4">Current Value?</label>
                                    <input id="Client_Real_Estate_Current_Value4" type="number" class="form-control 4_Client_realestate_inputs" name="Client_Real_Estate_Current_Value4" value="<?php if(isset($drrealestate->Client_Real_Estate_Current_Value4)){ echo $drrealestate->Client_Real_Estate_Current_Value4; } ?>" min="0.00" step="0.01" max="999999.99" onchange="getJointCurrentValue(this, '4', 'Client');" onkeyup="getJointCurrentValue(this, '4', 'Client');"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Real_Estate_First_Mortgage_Company_Name4">Name of First Mortgage/Loan Company for this Property?</label>
                                    <input id="Client_Real_Estate_First_Mortgage_Company_Name4" type="text" class="form-control 4_Client_realestate_inputs" name="Client_Real_Estate_First_Mortgage_Company_Name4" value="<?php if(isset($drrealestate->Client_Real_Estate_First_Mortgage_Company_Name4)){ echo $drrealestate->Client_Real_Estate_First_Mortgage_Company_Name4; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Real_Estate_First_Mortgage_Balance4">Balance owed on First Mortgage/Loan for this Property?</label>
                                    <input id="Client_Real_Estate_First_Mortgage_Balance4" type="number" class="form-control 4_Client_realestate_inputs" name="Client_Real_Estate_First_Mortgage_Balance4" value="<?php if(isset($drrealestate->Client_Real_Estate_First_Mortgage_Balance4)){ echo $drrealestate->Client_Real_Estate_First_Mortgage_Balance4; } ?>" onchange="getMaritalEquity(this, '4', 'Client');" onkeyup="getMaritalEquity(this, '4', 'Client');" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Real_Estate_First_Mortgage_Monthly_Payment4">Monthly payment for First Mortgage/Loan for this Property?</label>
                                    <input id="Client_Real_Estate_First_Mortgage_Monthly_Payment4" type="number" class="form-control 4_Client_realestate_inputs" name="Client_Real_Estate_First_Mortgage_Monthly_Payment4" value="<?php if(isset($drrealestate->Client_Real_Estate_First_Mortgage_Monthly_Payment4)){ echo $drrealestate->Client_Real_Estate_First_Mortgage_Monthly_Payment4; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Real_Estate_Second_Mortgage_LOC_Company_Name4">Name of Second Mortgage/Loan Company for this Property?</label>
                                    <input id="Client_Real_Estate_Second_Mortgage_LOC_Company_Name4" type="text" class="form-control 4_Client_realestate_inputs" name="Client_Real_Estate_Second_Mortgage_LOC_Company_Name4" value="<?php if(isset($drrealestate->Client_Real_Estate_Second_Mortgage_LOC_Company_Name4)){ echo $drrealestate->Client_Real_Estate_Second_Mortgage_LOC_Company_Name4; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Real_Estate_Second_Mortgage_LOC_Balance4">Balance owed on Second Mortgage/Loan for this Property?</label>
                                    <input id="Client_Real_Estate_Second_Mortgage_LOC_Balance4" type="number" class="form-control 4_Client_realestate_inputs" name="Client_Real_Estate_Second_Mortgage_LOC_Balance4" value="<?php if(isset($drrealestate->Client_Real_Estate_Second_Mortgage_LOC_Balance4)){ echo $drrealestate->Client_Real_Estate_Second_Mortgage_LOC_Balance4; } ?>" onchange="getMaritalEquity(this, '4', 'Client');" onkeyup="getMaritalEquity(this, '4', 'Client');" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Real_Estate_Second_Mortgage_LOC_Monthly_Payment4">Monthly payment for Second Mortgage/Loan for this Property?</label>
                                    <input id="Client_Real_Estate_Second_Mortgage_LOC_Monthly_Payment4" type="number" class="form-control 4_Client_realestate_inputs" name="Client_Real_Estate_Second_Mortgage_LOC_Monthly_Payment4" value="<?php if(isset($drrealestate->Client_Real_Estate_Second_Mortgage_LOC_Monthly_Payment4)){ echo $drrealestate->Client_Real_Estate_Second_Mortgage_LOC_Monthly_Payment4; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Real_Estate_MaritalEquity4">Marital Equity</label>
                                    <input id="Client_Real_Estate_MaritalEquity4" type="number" class="form-control 4_Client_realestate_inputs" name="Client_Real_Estate_MaritalEquity4" readonly value="<?php if(isset($drrealestate->Client_Real_Estate_MaritalEquity4)){ echo $drrealestate->Client_Real_Estate_MaritalEquity4; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Is this Property a Rental/Investment Property?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Client_Real_Estate_Rental4_Yes" name="Client_Real_Estate_Rental4" value="Yes" data-onload="getInitialRentalProperty(this, '4', 'Client');" onchange="getRentalProperty(this, '4', 'Client');" <?php if(isset($drrealestate->Client_Real_Estate_Rental4) && $drrealestate->Client_Real_Estate_Rental4=='Yes'){ echo "checked"; $hide='style="display: none;"'; } ?>> Yes</label>
                                        <label><input type="radio" id="Client_Real_Estate_Rental4_No" name="Client_Real_Estate_Rental4" value="No" data-onload="getInitialRentalProperty(this, '4', 'Client');" onchange="getRentalProperty(this, '4', 'Client');" <?php if(isset($drrealestate->Client_Real_Estate_Rental4) && $drrealestate->Client_Real_Estate_Rental4=='No'){ echo "checked"; $hide=''; } ?>> No</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Real_Estate_Yearly_Net_Rental_Income4">{{$client_name}} Real Estate Yearly Net Rental Income4</label>
                                    <input id="Client_Real_Estate_Yearly_Net_Rental_Income4" type="number" class="form-control 4_Client_realestate_inputs" name="Client_Real_Estate_Yearly_Net_Rental_Income4" onchange="getYearlyNetRentalIncome(this, '4', 'Client');" onkeyup="getYearlyNetRentalIncome(this, '4', 'Client');" value="<?php if(isset($drrealestate->Client_Real_Estate_Yearly_Net_Rental_Income4)){ echo $drrealestate->Client_Real_Estate_Yearly_Net_Rental_Income4; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6 Client_Real_Estate_Rental4_Input_Div">
                                    <label for="Client_Real_Estate_Client_Share_Rental4">{{$client_name}} Share of Yearly Net Rent</label>
                                    <input id="Client_Real_Estate_Client_Share_Rental4" type="number" class="form-control 4_Client_realestate_inputs" name="Client_Real_Estate_Client_Share_Rental4" value="<?php if(isset($drrealestate->Client_Real_Estate_Client_Share_Rental4)){ echo $drrealestate->Client_Real_Estate_Client_Share_Rental4; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6 Client_Real_Estate_Rental4_Input_Div">
                                    <label for="Client_Real_Estate_Op_Share_Rental4">{{$opponent_name}} Share of Yearly Net Rent</label>
                                    <input id="Client_Real_Estate_Op_Share_Rental4" type="number" class="form-control 4_Client_realestate_inputs" name="Client_Real_Estate_Op_Share_Rental4" value="<?php if(isset($drrealestate->Client_Real_Estate_Op_Share_Rental4)){ echo $drrealestate->Client_Real_Estate_Op_Share_Rental4; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Does either party claim a sole/separate interest in this Real Estate?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Client_Real_Estate_SoleSeparate_Claim4_Yes" name="Client_Real_Estate_SoleSeparate_Claim4" value="Yes" data-onload="getInitialPartyClaimSoleSeparate(this, '4', 'Client');" onchange="getPartyClaimSoleSeparate(this, '4', 'Client');" <?php if(isset($drrealestate->Client_Real_Estate_SoleSeparate_Claim4) && $drrealestate->Client_Real_Estate_SoleSeparate_Claim4=='Yes'){ echo "checked"; } ?>> Yes</label>
                                        <label><input type="radio" id="Client_Real_Estate_SoleSeparate_Claim4_No" name="Client_Real_Estate_SoleSeparate_Claim4" value="No" data-onload="getInitialPartyClaimSoleSeparate(this, '4', 'Client');" onchange="getPartyClaimSoleSeparate(this, '4', 'Client');" <?php if(isset($drrealestate->Client_Real_Estate_SoleSeparate_Claim4) && $drrealestate->Client_Real_Estate_SoleSeparate_Claim4=='No'){ echo "checked"; } ?>> No</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6" id="Client_Real_Estate_SoleSeparate_Party4_Div" style="display: none;">
                                    <label>Who claims to own this Real Estate?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Client_Real_Estate_SoleSeparate_Party4_Client" name="Client_Real_Estate_SoleSeparate_Party4" value="{{$client_name}}" <?php if(isset($drrealestate->Client_Real_Estate_SoleSeparate_Party4) && $drrealestate->Client_Real_Estate_SoleSeparate_Party4==$client_name){ echo "checked"; } ?>> {{$client_name}}</label>
                                        <label><input type="radio" id="Client_Real_Estate_SoleSeparate_Party4_Op" name="Client_Real_Estate_SoleSeparate_Party4" value="{{$opponent_name}}" <?php if(isset($drrealestate->Client_Real_Estate_SoleSeparate_Party4) && $drrealestate->Client_Real_Estate_SoleSeparate_Party4==$opponent_name){ echo "checked"; } ?>> {{$opponent_name}}</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6" id="Client_Real_Estate_SoleSeparate_Grounds4_Div" style="display: none;">
                                    <label for="Client_Real_Estate_SoleSeparate_Grounds4">Why does this person own this Real Estate solely and separately?</label>
                                    <input id="Client_Real_Estate_SoleSeparate_Grounds4" type="text" class="form-control 4_Client_realestate_inputs" name="Client_Real_Estate_SoleSeparate_Grounds4" value="<?php if(isset($drrealestate->Client_Real_Estate_SoleSeparate_Grounds4)){ echo $drrealestate->Client_Real_Estate_SoleSeparate_Grounds4; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>How will this Real Estate value be distributed between the parties?</label>
                                    <div class="w-100 dataInput">
                                        <label><input type="radio" id="Client_Real_Estate_Disposition_Method4_Liquidate/Split_Net_Value" name="Client_Real_Estate_Disposition_Method4" value="Liquidate/Split Net Value" data-onload="getInitialDipositionMethod(this, '4', 'Client');" onchange="getDipositionMethod(this, '4', 'Client');" <?php if(isset($drrealestate->Client_Real_Estate_Disposition_Method4) && $drrealestate->Client_Real_Estate_Disposition_Method4=='Liquidate/Split Net Value'){ echo "checked"; } ?>> Liquidate/Split Net Value</label>
                                        <label><input type="radio" id="Client_Real_Estate_Disposition_Method4_Fixed_Buyout_Refinance" name="Client_Real_Estate_Disposition_Method4" value="Fixed Buyout/Refinance" data-onload="getInitialDipositionMethod(this, '4', 'Client');" onchange="getDipositionMethod(this, '4', 'Client');" <?php if(isset($drrealestate->Client_Real_Estate_Disposition_Method4) && $drrealestate->Client_Real_Estate_Disposition_Method4=='Fixed Buyout/Refinance'){ echo "checked"; } ?>> Fixed Buyout/Refinance</label>
                                    </div>
                                </div>
                                <!-- slider tool -->
                                <div class="form-group col-sm-6 m-auto 4_Client_Slider_Tool slider-tool-main">
                                    <div class="row">
                                        <div class="col">{{$client_name}}</div>
                                        <div class="col text-right">{{$opponent_name}}</div>
                                    </div>
                                    <input id="4_Client_balance_range_selector" type="range" class="form-control slider-tool-input 4_Client_balance_range_selector" name="" value="<?php if(isset($drrealestate->Client_Real_Estate_Percent_Marital_Equity_to_Op4)){ echo $drrealestate->Client_Real_Estate_Percent_Marital_Equity_to_Op4; } ?>" min="0.00" step="0.01" max="100" onchange="updateBalanceInput(this.value, '4', 'Client');">
                                </div>
                                <div class="form-group col-sm-6 m-auto 4_Client_Slider_Tool slider-tool-main">
                                    <div class="row justify-content-between">
                                        <div class="col selectorTool">
                                            <div class="left-col">
                                                <div class="client-info 4_Client_clientpercentage_div clientpercentage_div">
                                                    <?php if(isset($drrealestate->Client_Real_Estate_Percent_Marital_Equity_to_Client4)){ echo $drrealestate->Client_Real_Estate_Percent_Marital_Equity_to_Client4; } else {
                                                        echo '50.00';
                                                    } ?>%
                                                </div>
                                                <div class="client-info 4_Client_clientamount_div clientamount_div" style="clear: both;">
                                                    $<?php if(isset($drrealestate->Client_Real_Estate_Estimated_Value_to_Client4)){ echo $drrealestate->Client_Real_Estate_Estimated_Value_to_Client4; } else {
                                                        echo '0.00';
                                                    } ?>
                                                </div>
                                            </div>
                                            <label>To {{$client_name}}</label>
                                        </div>                                       
                                        <div class="col selectorTool selectorToolRight">
                                            <label>To {{$opponent_name}}</label>
                                            <div class="left-col right-col">
                                                <div class="client-info 4_Client_opponentpercentage_div opponentpercentage_div">
                                                    <?php if(isset($drrealestate->Client_Real_Estate_Percent_Marital_Equity_to_Op4)){ echo $drrealestate->Client_Real_Estate_Percent_Marital_Equity_to_Op4; } else {
                                                        echo '50.00';
                                                    } ?>%
                                                </div>
                                                <div class="client-info 4_Client_opponentamount_div opponentamount_div" style="clear: both;">
                                                    $<?php if(isset($drrealestate->Client_Real_Estate_Estimated_Value_to_Op4)){ echo $drrealestate->Client_Real_Estate_Estimated_Value_to_Op4; } else {
                                                        echo '0.00';
                                                    } ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 m-auto 4_Client_Slider_Tool slider-tool-main">
                                    <label></label>
                                    <div class="w-100">
                                        <label><input type="radio" id="4_Client_Real_Estate_Estimated_Value_Select" name="4_Client_Real_Estate_Estimated_Value_Select_Reset" class="Real_Estate_Estimated_Value_Select_Reset" value="Save"> Save this Distribution of Real Estate #4</label>
                                        <label><input type="radio" id="4_Client_Real_Estate_Estimated_Value_Reset" name="4_Client_Real_Estate_Estimated_Value_Select_Reset" class="Real_Estate_Estimated_Value_Select_Reset" value="Reset" onclick="resetBalanceInput(this, '4', 'Client');"> Reset to Default (50%)</label>
                                    </div>
                                </div>

                                <div class="form-group col-sm-6 Client_Real_Estate_Paying_Party4_Inputs_Div" style="display: none;">
                                    <label>Client Real Estate Paying Party4</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Client_Real_Estate_Paying_Party4_Client" name="Client_Real_Estate_Paying_Party4" value="{{$client_name}}" data-onload="getInitialRealEstatePayingParty(this, '4', 'Client');" onchange="getRealEstatePayingParty(this, '4', 'Client');" <?php if(isset($drrealestate->Client_Real_Estate_Paying_Party4) && $drrealestate->Client_Real_Estate_Paying_Party4==$client_name){ echo "checked"; } ?>> {{$client_name}}</label>
                                        <label><input type="radio" id="Client_Real_Estate_Paying_Party4_Op" name="Client_Real_Estate_Paying_Party4" value="{{$opponent_name}}" data-onload="getInitialRealEstatePayingParty(this, '4', 'Client');" onchange="getRealEstatePayingParty(this, '4', 'Client');" <?php if(isset($drrealestate->Client_Real_Estate_Paying_Party4) && $drrealestate->Client_Real_Estate_Paying_Party4==$opponent_name){ echo "checked"; } ?>> {{$opponent_name}}</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 Client_Real_Estate_Paying_Party4_Inputs_Div" style="display: none;">
                                    <label>{{$client_name}} Real Estate Equity Percent</label>
                                    <input id="Client_Real_Estate_Percent_Marital_Equity_to_Client4" type="number" class="form-control 4_Client_clientpercentage_input clientpercentage_input" name="Client_Real_Estate_Percent_Marital_Equity_to_Client4" value="<?php if(isset($drrealestate->Client_Real_Estate_Percent_Marital_Equity_to_Client4)){ echo $drrealestate->Client_Real_Estate_Percent_Marital_Equity_to_Client4; } ?>" min="0.00" step="0.01" max="100" readonly="">
                                </div>
                                <div class="form-group col-sm-6 Client_Real_Estate_Paying_Party4_Inputs_Div" style="display: none;">
                                    <label>How much is to be paid to {{$client_name}}?</label>
                                    <input id="Client_Real_Estate_Estimated_Value_to_Client4" type="number" class="form-control 4_Client_clientamount_input clientamount_input" name="Client_Real_Estate_Estimated_Value_to_Client4" value="<?php if(isset($drrealestate->Client_Real_Estate_Estimated_Value_to_Client4)){ echo $drrealestate->Client_Real_Estate_Estimated_Value_to_Client4; } ?>" min="0.00" step="0.01" max="999999.99" readonly="" onchange="getEstimatedValueClient(this, '4', 'Client');" onkeyup="getEstimatedValueClient(this, '4', 'Client');">
                                </div>
                                <div class="form-group col-sm-6 Client_Real_Estate_Paying_Party4_Inputs_Div" style="display: none;">
                                    <label>{{$opponent_name}} Real Estate Equity Percent</label>
                                    <input id="Client_Real_Estate_Percent_Marital_Equity_to_Op4" type="number" class="form-control 4_Client_opponentpercentage_input opponentpercentage_input" name="Client_Real_Estate_Percent_Marital_Equity_to_Op4" value="<?php if(isset($drrealestate->Client_Real_Estate_Percent_Marital_Equity_to_Op4)){ echo $drrealestate->Client_Real_Estate_Percent_Marital_Equity_to_Op4; } ?>" min="0.00" step="0.01" max="100" readonly="">
                                </div>
                                <div class="form-group col-sm-6 Client_Real_Estate_Paying_Party4_Inputs_Div" style="display: none;">
                                    <label>How much is to be paid to {{$opponent_name}}?</label>
                                    <input id="Client_Real_Estate_Estimated_Value_to_Op4" type="number" class="form-control 4_Client_opponentamount_input opponentamount_input" name="Client_Real_Estate_Estimated_Value_to_Op4" value="<?php if(isset($drrealestate->Client_Real_Estate_Estimated_Value_to_Op4)){ echo $drrealestate->Client_Real_Estate_Estimated_Value_to_Op4; } ?>" min="0.00" step="0.01" max="999999.99" readonly="" onchange="getEstimatedValueOp(this, '4', 'Client');" onkeyup="getEstimatedValueOp(this, '4', 'Client');">
                                </div>
                                <!-- end of slider tool -->
                            </div>
                            <div class="col-sm-12 mt-4 5_Client_realestate_section" style="display: none;"><h5 class="col-sm-12">Fifth Real Estate Info</h5>
                                <div class="form-group col-sm-6">
                                    <p class="text-danger 5_Client_no-state-county-found" style="display: none;">No City, State, County found for this zipcode.</p>
                                    <label for="Client_Real_Estate_ZIP5">ZIP code of this Property?</label>
                                    <input id="Client_Real_Estate_ZIP5" type="text" class="form-control 5_Client_realestate_inputs" name="Client_Real_Estate_ZIP5" value="<?php if(isset($drrealestate->Client_Real_Estate_ZIP5)){ echo $drrealestate->Client_Real_Estate_ZIP5; } ?>" data-onload="getCityStateForZip(this, '5', 'Client');" onkeyup="getCityStateForZip(this, '5', 'Client');"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Real_Estate_Street_Address5">This Property Street Address?</label>
                                    <input id="Client_Real_Estate_Street_Address5" type="text" class="form-control 5_Client_realestate_inputs" name="Client_Real_Estate_Street_Address5" value="<?php if(isset($drrealestate->Client_Real_Estate_Street_Address5)){ echo $drrealestate->Client_Real_Estate_Street_Address5; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Real_Estate_City5">This Property City?</label>
                                    <input type="hidden" name="" id="Client_Real_Estate_Institution_City5_Value" value="<?php if(isset($drrealestate->Client_Real_Estate_City5)){ echo $drrealestate->Client_Real_Estate_City5; } ?>">
                                    <select id="Client_Real_Estate_City5" name="Client_Real_Estate_City5" class="form-control 5_Client_city_select">
                                        <option value="">Choose City</option>
                                    </select>   
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Real_Estate_State5">This Property State?</label>
                                    <input type="hidden" name="" id="Client_Real_Estate_Institution_State5_Value" value="<?php if(isset($drrealestate->Client_Real_Estate_State5)){ echo $drrealestate->Client_Real_Estate_State5; } ?>">
                                    <select id="Client_Real_Estate_State5" name="Client_Real_Estate_State5" class="form-control 5_Client_state_select">
                                        <option value="">Choose State</option>
                                    </select>   
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Real_Estate_Current_Value5">Current Value?</label>
                                    <input id="Client_Real_Estate_Current_Value5" type="number" class="form-control 5_Client_realestate_inputs" name="Client_Real_Estate_Current_Value5" value="<?php if(isset($drrealestate->Client_Real_Estate_Current_Value5)){ echo $drrealestate->Client_Real_Estate_Current_Value5; } ?>" min="0.00" step="0.01" max="999999.99" onchange="getJointCurrentValue(this, '5', 'Client');" onkeyup="getJointCurrentValue(this, '5', 'Client');"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Real_Estate_First_Mortgage_Company_Name5">Name of First Mortgage/Loan Company for this Property?</label>
                                    <input id="Client_Real_Estate_First_Mortgage_Company_Name5" type="text" class="form-control 5_Client_realestate_inputs" name="Client_Real_Estate_First_Mortgage_Company_Name5" value="<?php if(isset($drrealestate->Client_Real_Estate_First_Mortgage_Company_Name5)){ echo $drrealestate->Client_Real_Estate_First_Mortgage_Company_Name5; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Real_Estate_First_Mortgage_Balance5">Balance owed on First Mortgage/Loan for this Property?</label>
                                    <input id="Client_Real_Estate_First_Mortgage_Balance5" type="number" class="form-control 5_Client_realestate_inputs" name="Client_Real_Estate_First_Mortgage_Balance5" value="<?php if(isset($drrealestate->Client_Real_Estate_First_Mortgage_Balance5)){ echo $drrealestate->Client_Real_Estate_First_Mortgage_Balance5; } ?>" onchange="getMaritalEquity(this, '5', 'Client');" onkeyup="getMaritalEquity(this, '5', 'Client');" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Real_Estate_First_Mortgage_Monthly_Payment5">Monthly payment for First Mortgage/Loan for this Property?</label>
                                    <input id="Client_Real_Estate_First_Mortgage_Monthly_Payment5" type="number" class="form-control 5_Client_realestate_inputs" name="Client_Real_Estate_First_Mortgage_Monthly_Payment5" value="<?php if(isset($drrealestate->Client_Real_Estate_First_Mortgage_Monthly_Payment5)){ echo $drrealestate->Client_Real_Estate_First_Mortgage_Monthly_Payment5; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Real_Estate_Second_Mortgage_LOC_Company_Name5">Name of Second Mortgage/Loan Company for this Property?</label>
                                    <input id="Client_Real_Estate_Second_Mortgage_LOC_Company_Name5" type="text" class="form-control 5_Client_realestate_inputs" name="Client_Real_Estate_Second_Mortgage_LOC_Company_Name5" value="<?php if(isset($drrealestate->Client_Real_Estate_Second_Mortgage_LOC_Company_Name5)){ echo $drrealestate->Client_Real_Estate_Second_Mortgage_LOC_Company_Name5; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Real_Estate_Second_Mortgage_LOC_Balance5">Balance owed on Second Mortgage/Loan for this Property?</label>
                                    <input id="Client_Real_Estate_Second_Mortgage_LOC_Balance5" type="number" class="form-control 5_Client_realestate_inputs" name="Client_Real_Estate_Second_Mortgage_LOC_Balance5" value="<?php if(isset($drrealestate->Client_Real_Estate_Second_Mortgage_LOC_Balance5)){ echo $drrealestate->Client_Real_Estate_Second_Mortgage_LOC_Balance5; } ?>" onchange="getMaritalEquity(this, '5', 'Client');" onkeyup="getMaritalEquity(this, '5', 'Client');" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Real_Estate_Second_Mortgage_LOC_Monthly_Payment5">Monthly payment for Second Mortgage/Loan for this Property?</label>
                                    <input id="Client_Real_Estate_Second_Mortgage_LOC_Monthly_Payment5" type="number" class="form-control 5_Client_realestate_inputs" name="Client_Real_Estate_Second_Mortgage_LOC_Monthly_Payment5" value="<?php if(isset($drrealestate->Client_Real_Estate_Second_Mortgage_LOC_Monthly_Payment5)){ echo $drrealestate->Client_Real_Estate_Second_Mortgage_LOC_Monthly_Payment5; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Real_Estate_MaritalEquity5">Marital Equity</label>
                                    <input id="Client_Real_Estate_MaritalEquity5" type="number" class="form-control 5_Client_realestate_inputs" name="Client_Real_Estate_MaritalEquity5" readonly value="<?php if(isset($drrealestate->Client_Real_Estate_MaritalEquity5)){ echo $drrealestate->Client_Real_Estate_MaritalEquity5; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Is this Property a Rental/Investment Property?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Client_Real_Estate_Rental5_Yes" name="Client_Real_Estate_Rental5" value="Yes" data-onload="getInitialRentalProperty(this, '5', 'Client');" onchange="getRentalProperty(this, '5', 'Client');" <?php if(isset($drrealestate->Client_Real_Estate_Rental5) && $drrealestate->Client_Real_Estate_Rental5=='Yes'){ echo "checked"; $hide='style="display: none;"'; } ?>> Yes</label>
                                        <label><input type="radio" id="Client_Real_Estate_Rental5_No" name="Client_Real_Estate_Rental5" value="No" data-onload="getInitialRentalProperty(this, '5', 'Client');" onchange="getRentalProperty(this, '5', 'Client');" <?php if(isset($drrealestate->Client_Real_Estate_Rental5) && $drrealestate->Client_Real_Estate_Rental5=='No'){ echo "checked"; $hide=''; } ?>> No</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Real_Estate_Yearly_Net_Rental_Income5">{{$client_name}} Real Estate Yearly Net Rental Income5</label>
                                    <input id="Client_Real_Estate_Yearly_Net_Rental_Income5" type="number" class="form-control 5_Client_realestate_inputs" name="Client_Real_Estate_Yearly_Net_Rental_Income5" onchange="getYearlyNetRentalIncome(this, '5', 'Client');" onkeyup="getYearlyNetRentalIncome(this, '5', 'Client');" value="<?php if(isset($drrealestate->Client_Real_Estate_Yearly_Net_Rental_Income5)){ echo $drrealestate->Client_Real_Estate_Yearly_Net_Rental_Income5; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6 Client_Real_Estate_Rental5_Input_Div">
                                    <label for="Client_Real_Estate_Client_Share_Rental5">{{$client_name}} Share of Yearly Net Rent</label>
                                    <input id="Client_Real_Estate_Client_Share_Rental5" type="number" class="form-control 5_Client_realestate_inputs" name="Client_Real_Estate_Client_Share_Rental5" value="<?php if(isset($drrealestate->Client_Real_Estate_Client_Share_Rental5)){ echo $drrealestate->Client_Real_Estate_Client_Share_Rental5; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6 Client_Real_Estate_Rental5_Input_Div">
                                    <label for="Client_Real_Estate_Op_Share_Rental5">{{$opponent_name}} Share of Yearly Net Rent</label>
                                    <input id="Client_Real_Estate_Op_Share_Rental5" type="number" class="form-control 5_Client_realestate_inputs" name="Client_Real_Estate_Op_Share_Rental5" value="<?php if(isset($drrealestate->Client_Real_Estate_Op_Share_Rental5)){ echo $drrealestate->Client_Real_Estate_Op_Share_Rental5; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Does either party claim a sole/separate interest in this Real Estate?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Client_Real_Estate_SoleSeparate_Claim5_Yes" name="Client_Real_Estate_SoleSeparate_Claim5" value="Yes" data-onload="getInitialPartyClaimSoleSeparate(this, '5', 'Client');" onchange="getPartyClaimSoleSeparate(this, '5', 'Client');" <?php if(isset($drrealestate->Client_Real_Estate_SoleSeparate_Claim5) && $drrealestate->Client_Real_Estate_SoleSeparate_Claim5=='Yes'){ echo "checked"; } ?>> Yes</label>
                                        <label><input type="radio" id="Client_Real_Estate_SoleSeparate_Claim5_No" name="Client_Real_Estate_SoleSeparate_Claim5" value="No" data-onload="getInitialPartyClaimSoleSeparate(this, '5', 'Client');" onchange="getPartyClaimSoleSeparate(this, '5', 'Client');" <?php if(isset($drrealestate->Client_Real_Estate_SoleSeparate_Claim5) && $drrealestate->Client_Real_Estate_SoleSeparate_Claim5=='No'){ echo "checked"; } ?>> No</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6" id="Client_Real_Estate_SoleSeparate_Party5_Div" style="display: none;">
                                    <label>Who claims to own this Real Estate?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Client_Real_Estate_SoleSeparate_Party5_Client" name="Client_Real_Estate_SoleSeparate_Party5" value="{{$client_name}}" <?php if(isset($drrealestate->Client_Real_Estate_SoleSeparate_Party5) && $drrealestate->Client_Real_Estate_SoleSeparate_Party5==$client_name){ echo "checked"; } ?>> {{$client_name}}</label>
                                        <label><input type="radio" id="Client_Real_Estate_SoleSeparate_Party5_Op" name="Client_Real_Estate_SoleSeparate_Party5" value="{{$opponent_name}}" <?php if(isset($drrealestate->Client_Real_Estate_SoleSeparate_Party5) && $drrealestate->Client_Real_Estate_SoleSeparate_Party5==$opponent_name){ echo "checked"; } ?>> {{$opponent_name}}</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6" id="Client_Real_Estate_SoleSeparate_Grounds5_Div" style="display: none;">
                                    <label for="Client_Real_Estate_SoleSeparate_Grounds5">Why does this person own this Real Estate solely and separately?</label>
                                    <input id="Client_Real_Estate_SoleSeparate_Grounds5" type="text" class="form-control 5_Client_realestate_inputs" name="Client_Real_Estate_SoleSeparate_Grounds5" value="<?php if(isset($drrealestate->Client_Real_Estate_SoleSeparate_Grounds5)){ echo $drrealestate->Client_Real_Estate_SoleSeparate_Grounds5; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>How will this Real Estate value be distributed between the parties?</label>
                                    <div class="w-100 dataInput">
                                        <label><input type="radio" id="Client_Real_Estate_Disposition_Method5_Liquidate/Split_Net_Value" name="Client_Real_Estate_Disposition_Method5" value="Liquidate/Split Net Value" data-onload="getInitialDipositionMethod(this, '5', 'Client');" onchange="getDipositionMethod(this, '5', 'Client');" <?php if(isset($drrealestate->Client_Real_Estate_Disposition_Method5) && $drrealestate->Client_Real_Estate_Disposition_Method5=='Liquidate/Split Net Value'){ echo "checked"; } ?>> Liquidate/Split Net Value</label>
                                        <label><input type="radio" id="Client_Real_Estate_Disposition_Method5_Fixed_Buyout_Refinance" name="Client_Real_Estate_Disposition_Method5" value="Fixed Buyout/Refinance" data-onload="getInitialDipositionMethod(this, '5', 'Client');" onchange="getDipositionMethod(this, '5', 'Client');" <?php if(isset($drrealestate->Client_Real_Estate_Disposition_Method5) && $drrealestate->Client_Real_Estate_Disposition_Method5=='Fixed Buyout/Refinance'){ echo "checked"; } ?>> Fixed Buyout/Refinance</label>
                                    </div>
                                </div>
                                <!-- slider tool -->
                                <div class="form-group col-sm-6 m-auto 5_Client_Slider_Tool slider-tool-main">
                                    <div class="row">
                                        <div class="col">{{$client_name}}</div>
                                        <div class="col text-right">{{$opponent_name}}</div>
                                    </div>
                                    <input id="5_Client_balance_range_selector" type="range" class="form-control slider-tool-input 5_Client_balance_range_selector" name="" value="<?php if(isset($drrealestate->Client_Real_Estate_Percent_Marital_Equity_to_Op5)){ echo $drrealestate->Client_Real_Estate_Percent_Marital_Equity_to_Op5; } ?>" min="0.00" step="0.01" max="100" onchange="updateBalanceInput(this.value, '5', 'Client');">
                                </div>
                                <div class="form-group col-sm-6 m-auto 5_Client_Slider_Tool slider-tool-main">
                                    <div class="row justify-content-between">
                                        <div class="col selectorTool">
                                            <div class="left-col">
                                                <div class="client-info 5_Client_clientpercentage_div clientpercentage_div">
                                                    <?php if(isset($drrealestate->Client_Real_Estate_Percent_Marital_Equity_to_Client5)){ echo $drrealestate->Client_Real_Estate_Percent_Marital_Equity_to_Client5; } else {
                                                        echo '50.00';
                                                    } ?>%
                                                </div>
                                                <div class="client-info 5_Client_clientamount_div clientamount_div" style="clear: both;">
                                                    $<?php if(isset($drrealestate->Client_Real_Estate_Estimated_Value_to_Client5)){ echo $drrealestate->Client_Real_Estate_Estimated_Value_to_Client5; } else {
                                                        echo '0.00';
                                                    } ?>
                                                </div>
                                            </div>
                                            <label>To {{$client_name}}</label>
                                        </div>                                       
                                        <div class="col selectorTool selectorToolRight">
                                            <label>To {{$opponent_name}}</label>
                                            <div class="left-col right-col">
                                                <div class="client-info 5_Client_opponentpercentage_div opponentpercentage_div">
                                                    <?php if(isset($drrealestate->Client_Real_Estate_Percent_Marital_Equity_to_Op5)){ echo $drrealestate->Client_Real_Estate_Percent_Marital_Equity_to_Op5; } else {
                                                        echo '50.00';
                                                    } ?>%
                                                </div>
                                                <div class="client-info 5_Client_opponentamount_div opponentamount_div" style="clear: both;">
                                                    $<?php if(isset($drrealestate->Client_Real_Estate_Estimated_Value_to_Op5)){ echo $drrealestate->Client_Real_Estate_Estimated_Value_to_Op5; } else {
                                                        echo '0.00';
                                                    } ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 m-auto 5_Client_Slider_Tool slider-tool-main">
                                    <label></label>
                                    <div class="w-100">
                                        <label><input type="radio" id="5_Client_Real_Estate_Estimated_Value_Select" name="5_Client_Real_Estate_Estimated_Value_Select_Reset" class="Real_Estate_Estimated_Value_Select_Reset" value="Save"> Save this Distribution of Real Estate #5</label>
                                        <label><input type="radio" id="5_Client_Real_Estate_Estimated_Value_Reset" name="5_Client_Real_Estate_Estimated_Value_Select_Reset" class="Real_Estate_Estimated_Value_Select_Reset" value="Reset" onclick="resetBalanceInput(this, '5', 'Client');"> Reset to Default (50%)</label>
                                    </div>
                                </div>

                                <div class="form-group col-sm-6 Client_Real_Estate_Paying_Party5_Inputs_Div" style="display: none;">
                                    <label>Client Real Estate Paying Party5</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Client_Real_Estate_Paying_Party5_Client" name="Client_Real_Estate_Paying_Party5" value="{{$client_name}}" data-onload="getInitialRealEstatePayingParty(this, '5', 'Client');" onchange="getRealEstatePayingParty(this, '5', 'Client');" <?php if(isset($drrealestate->Client_Real_Estate_Paying_Party5) && $drrealestate->Client_Real_Estate_Paying_Party5==$client_name){ echo "checked"; } ?>> {{$client_name}}</label>
                                        <label><input type="radio" id="Client_Real_Estate_Paying_Party5_Op" name="Client_Real_Estate_Paying_Party5" value="{{$opponent_name}}" data-onload="getInitialRealEstatePayingParty(this, '5', 'Client');" onchange="getRealEstatePayingParty(this, '5', 'Client');" <?php if(isset($drrealestate->Client_Real_Estate_Paying_Party5) && $drrealestate->Client_Real_Estate_Paying_Party5==$opponent_name){ echo "checked"; } ?>> {{$opponent_name}}</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 Client_Real_Estate_Paying_Party5_Inputs_Div" style="display: none;">
                                    <label>{{$client_name}} Real Estate Equity Percent</label>
                                    <input id="Client_Real_Estate_Percent_Marital_Equity_to_Client5" type="number" class="form-control 5_Client_clientpercentage_input clientpercentage_input" name="Client_Real_Estate_Percent_Marital_Equity_to_Client5" value="<?php if(isset($drrealestate->Client_Real_Estate_Percent_Marital_Equity_to_Client5)){ echo $drrealestate->Client_Real_Estate_Percent_Marital_Equity_to_Client5; } ?>" min="0.00" step="0.01" max="100" readonly="">
                                </div>
                                <div class="form-group col-sm-6 Client_Real_Estate_Paying_Party5_Inputs_Div" style="display: none;">
                                    <label>How much is to be paid to {{$client_name}}?</label>
                                    <input id="Client_Real_Estate_Estimated_Value_to_Client5" type="number" class="form-control 5_Client_clientamount_input clientamount_input" name="Client_Real_Estate_Estimated_Value_to_Client5" value="<?php if(isset($drrealestate->Client_Real_Estate_Estimated_Value_to_Client5)){ echo $drrealestate->Client_Real_Estate_Estimated_Value_to_Client5; } ?>" min="0.00" step="0.01" max="999999.99" readonly="" onchange="getEstimatedValueClient(this, '5', 'Client');" onkeyup="getEstimatedValueClient(this, '5', 'Client');">
                                </div>
                                <div class="form-group col-sm-6 Client_Real_Estate_Paying_Party5_Inputs_Div" style="display: none;">
                                    <label>{{$opponent_name}} Real Estate Equity Percent</label>
                                    <input id="Client_Real_Estate_Percent_Marital_Equity_to_Op5" type="number" class="form-control 5_Client_opponentpercentage_input opponentpercentage_input" name="Client_Real_Estate_Percent_Marital_Equity_to_Op5" value="<?php if(isset($drrealestate->Client_Real_Estate_Percent_Marital_Equity_to_Op5)){ echo $drrealestate->Client_Real_Estate_Percent_Marital_Equity_to_Op5; } ?>" min="0.00" step="0.01" max="100" readonly="">
                                </div>
                                <div class="form-group col-sm-6 Client_Real_Estate_Paying_Party5_Inputs_Div" style="display: none;">
                                    <label>How much is to be paid to {{$opponent_name}}?</label>
                                    <input id="Client_Real_Estate_Estimated_Value_to_Op5" type="number" class="form-control 5_Client_opponentamount_input opponentamount_input" name="Client_Real_Estate_Estimated_Value_to_Op5" value="<?php if(isset($drrealestate->Client_Real_Estate_Estimated_Value_to_Op5)){ echo $drrealestate->Client_Real_Estate_Estimated_Value_to_Op5; } ?>" min="0.00" step="0.01" max="999999.99" readonly="" onchange="getEstimatedValueOp(this, '5', 'Client');" onkeyup="getEstimatedValueOp(this, '5', 'Client');">
                                </div>
                                <!-- end of slider tool -->
                            </div>
                        </div>
                        <!-- End of Client Real Estate Info Section -->

                        <!-- Opponent Real Estate Info Section -->
                        <div class="form-row num_Op_realestate mt-4" style="display: none;">
                            <h4 class="col-sm-12">{{$opponent_name}} Real Estate Info Section</h4>
                            <div class="col-sm-6">
                                <label for="Num_Op_Real_Estate_Properties">How many Real Estate Properties are owned in {{$opponent_name}}’s Name Only</label>
                                <input id="Num_Op_Real_Estate_Properties" type="number" class="form-control" name="Num_Op_Real_Estate_Properties" value="<?php if(isset($drrealestate->Num_Op_Real_Estate_Properties)){ echo $drrealestate->Num_Op_Real_Estate_Properties; } ?>" min="0" max="5"> 
                            </div>
                        </div>
                        <div class="form-row Opponent_realestate_section">
                            <div class="col-sm-12 mt-4 1_Op_realestate_section" style="display: none;"><h5 class="col-sm-12">First Real Estate Info</h5>
                                <div class="form-group col-sm-6">
                                    <p class="text-danger 1_Op_no-state-county-found" style="display: none;">No City, State, County found for this zipcode.</p>
                                    <label for="Op_Real_Estate_ZIP1">ZIP code of this Property?</label>
                                    <input id="Op_Real_Estate_ZIP1" type="text" class="form-control 1_Op_realestate_inputs" name="Op_Real_Estate_ZIP1" value="<?php if(isset($drrealestate->Op_Real_Estate_ZIP1)){ echo $drrealestate->Op_Real_Estate_ZIP1; } ?>" data-onload="getCityStateForZip(this, '1', 'Op');" onkeyup="getCityStateForZip(this, '1', 'Op');"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Real_Estate_Street_Address1">This Property Street Address?</label>
                                    <input id="Op_Real_Estate_Street_Address1" type="text" class="form-control 1_Op_realestate_inputs" name="Op_Real_Estate_Street_Address1" value="<?php if(isset($drrealestate->Op_Real_Estate_Street_Address1)){ echo $drrealestate->Op_Real_Estate_Street_Address1; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Real_Estate_City1">This Property City?</label>
                                    <input type="hidden" name="" id="Op_Real_Estate_Institution_City1_Value" value="<?php if(isset($drrealestate->Op_Real_Estate_City1)){ echo $drrealestate->Op_Real_Estate_City1; } ?>">
                                    <select id="Op_Real_Estate_City1" name="Op_Real_Estate_City1" class="form-control 1_Op_city_select">
                                        <option value="">Choose City</option>
                                    </select>   
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Real_Estate_State1">This Property State?</label>
                                    <input type="hidden" name="" id="Op_Real_Estate_Institution_State1_Value" value="<?php if(isset($drrealestate->Op_Real_Estate_State1)){ echo $drrealestate->Op_Real_Estate_State1; } ?>">
                                    <select id="Op_Real_Estate_State1" name="Op_Real_Estate_State1" class="form-control 1_Op_state_select">
                                        <option value="">Choose State</option>
                                    </select>   
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Real_Estate_Current_Value1">Current Value?</label>
                                    <input id="Op_Real_Estate_Current_Value1" type="number" class="form-control 1_Op_realestate_inputs" name="Op_Real_Estate_Current_Value1" value="<?php if(isset($drrealestate->Op_Real_Estate_Current_Value1)){ echo $drrealestate->Op_Real_Estate_Current_Value1; } ?>" min="0.00" step="0.01" max="999999.99" onchange="getJointCurrentValue(this, '1', 'Op');" onkeyup="getJointCurrentValue(this, '1', 'Op');"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Real_Estate_First_Mortgage_Company_Name1">Name of First Mortgage/Loan Company for this Property?</label>
                                    <input id="Op_Real_Estate_First_Mortgage_Company_Name1" type="text" class="form-control 1_Op_realestate_inputs" name="Op_Real_Estate_First_Mortgage_Company_Name1" value="<?php if(isset($drrealestate->Op_Real_Estate_First_Mortgage_Company_Name1)){ echo $drrealestate->Op_Real_Estate_First_Mortgage_Company_Name1; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Real_Estate_First_Mortgage_Balance1">Balance owed on First Mortgage/Loan for this Property?</label>
                                    <input id="Op_Real_Estate_First_Mortgage_Balance1" type="number" class="form-control 1_Op_realestate_inputs" name="Op_Real_Estate_First_Mortgage_Balance1" value="<?php if(isset($drrealestate->Op_Real_Estate_First_Mortgage_Balance1)){ echo $drrealestate->Op_Real_Estate_First_Mortgage_Balance1; } ?>" onchange="getMaritalEquity(this, '1', 'Op');" onkeyup="getMaritalEquity(this, '1', 'Op');" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Real_Estate_First_Mortgage_Monthly_Payment1">Monthly payment for First Mortgage/Loan for this Property?</label>
                                    <input id="Op_Real_Estate_First_Mortgage_Monthly_Payment1" type="number" class="form-control 1_Op_realestate_inputs" name="Op_Real_Estate_First_Mortgage_Monthly_Payment1" value="<?php if(isset($drrealestate->Op_Real_Estate_First_Mortgage_Monthly_Payment1)){ echo $drrealestate->Op_Real_Estate_First_Mortgage_Monthly_Payment1; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Real_Estate_Second_Mortgage_LOC_Company_Name1">Name of Second Mortgage/Loan Company for this Property?</label>
                                    <input id="Op_Real_Estate_Second_Mortgage_LOC_Company_Name1" type="text" class="form-control 1_Op_realestate_inputs" name="Op_Real_Estate_Second_Mortgage_LOC_Company_Name1" value="<?php if(isset($drrealestate->Op_Real_Estate_Second_Mortgage_LOC_Company_Name1)){ echo $drrealestate->Op_Real_Estate_Second_Mortgage_LOC_Company_Name1; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Real_Estate_Second_Mortgage_LOC_Balance1">Balance owed on Second Mortgage/Loan for this Property?</label>
                                    <input id="Op_Real_Estate_Second_Mortgage_LOC_Balance1" type="number" class="form-control 1_Op_realestate_inputs" name="Op_Real_Estate_Second_Mortgage_LOC_Balance1" value="<?php if(isset($drrealestate->Op_Real_Estate_Second_Mortgage_LOC_Balance1)){ echo $drrealestate->Op_Real_Estate_Second_Mortgage_LOC_Balance1; } ?>" onchange="getMaritalEquity(this, '1', 'Op');" onkeyup="getMaritalEquity(this, '1', 'Op');" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Real_Estate_Second_Mortgage_LOC_Monthly_Payment1">Monthly payment for Second Mortgage/Loan for this Property?</label>
                                    <input id="Op_Real_Estate_Second_Mortgage_LOC_Monthly_Payment1" type="number" class="form-control 1_Op_realestate_inputs" name="Op_Real_Estate_Second_Mortgage_LOC_Monthly_Payment1" value="<?php if(isset($drrealestate->Op_Real_Estate_Second_Mortgage_LOC_Monthly_Payment1)){ echo $drrealestate->Op_Real_Estate_Second_Mortgage_LOC_Monthly_Payment1; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Real_Estate_MaritalEquity1">Marital Equity</label>
                                    <input id="Op_Real_Estate_MaritalEquity1" type="number" class="form-control 1_Op_realestate_inputs" name="Op_Real_Estate_MaritalEquity1" readonly value="<?php if(isset($drrealestate->Op_Real_Estate_MaritalEquity1)){ echo $drrealestate->Op_Real_Estate_MaritalEquity1; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Is this Property a Rental/Investment Property?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Op_Real_Estate_Rental1_Yes" name="Op_Real_Estate_Rental1" value="Yes" data-onload="getInitialRentalProperty(this, '1', 'Op');" onchange="getRentalProperty(this, '1', 'Op');" <?php if(isset($drrealestate->Op_Real_Estate_Rental1) && $drrealestate->Op_Real_Estate_Rental1=='Yes'){ echo "checked"; $hide='style="display: none;"'; } ?>> Yes</label>
                                        <label><input type="radio" id="Op_Real_Estate_Rental1_No" name="Op_Real_Estate_Rental1" value="No" data-onload="getInitialRentalProperty(this, '1', 'Op');" onchange="getRentalProperty(this, '1', 'Op');" <?php if(isset($drrealestate->Op_Real_Estate_Rental1) && $drrealestate->Op_Real_Estate_Rental1=='No'){ echo "checked"; $hide=''; } ?>> No</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Real_Estate_Yearly_Net_Rental_Income1">{{$opponent_name}} Real Estate Yearly Net Rental Income1</label>
                                    <input id="Op_Real_Estate_Yearly_Net_Rental_Income1" type="number" class="form-control 1_Op_realestate_inputs" name="Op_Real_Estate_Yearly_Net_Rental_Income1" onchange="getYearlyNetRentalIncome(this, '1', 'Op');" onkeyup="getYearlyNetRentalIncome(this, '1', 'Op');" value="<?php if(isset($drrealestate->Op_Real_Estate_Yearly_Net_Rental_Income1)){ echo $drrealestate->Op_Real_Estate_Yearly_Net_Rental_Income1; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6 Op_Real_Estate_Rental1_Input_Div">
                                    <label for="Op_Real_Estate_Client_Share_Rental1">{{$client_name}} Share of Yearly Net Rent</label>
                                    <input id="Op_Real_Estate_Client_Share_Rental1" type="number" class="form-control 1_Op_realestate_inputs" name="Op_Real_Estate_Client_Share_Rental1" value="<?php if(isset($drrealestate->Op_Real_Estate_Client_Share_Rental1)){ echo $drrealestate->Op_Real_Estate_Client_Share_Rental1; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6 Op_Real_Estate_Rental1_Input_Div">
                                    <label for="Op_Real_Estate_Op_Share_Rental1">{{$opponent_name}} Share of Yearly Net Rent</label>
                                    <input id="Op_Real_Estate_Op_Share_Rental1" type="number" class="form-control 1_Op_realestate_inputs" name="Op_Real_Estate_Op_Share_Rental1" value="<?php if(isset($drrealestate->Op_Real_Estate_Op_Share_Rental1)){ echo $drrealestate->Op_Real_Estate_Op_Share_Rental1; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Does either party claim a sole/separate interest in this Real Estate?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Op_Real_Estate_SoleSeparate_Claim1_Yes" name="Op_Real_Estate_SoleSeparate_Claim1" value="Yes" data-onload="getInitialPartyClaimSoleSeparate(this, '1', 'Op');" onchange="getPartyClaimSoleSeparate(this, '1', 'Op');" <?php if(isset($drrealestate->Op_Real_Estate_SoleSeparate_Claim1) && $drrealestate->Op_Real_Estate_SoleSeparate_Claim1=='Yes'){ echo "checked"; } ?>> Yes</label>
                                        <label><input type="radio" id="Op_Real_Estate_SoleSeparate_Claim1_No" name="Op_Real_Estate_SoleSeparate_Claim1" value="No" data-onload="getInitialPartyClaimSoleSeparate(this, '1', 'Op');" onchange="getPartyClaimSoleSeparate(this, '1', 'Op');" <?php if(isset($drrealestate->Op_Real_Estate_SoleSeparate_Claim1) && $drrealestate->Op_Real_Estate_SoleSeparate_Claim1=='No'){ echo "checked"; } ?>> No</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6" id="Op_Real_Estate_SoleSeparate_Party1_Div" style="display: none;">
                                    <label>Who claims to own this Real Estate?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Op_Real_Estate_SoleSeparate_Party1_Client" name="Op_Real_Estate_SoleSeparate_Party1" value="{{$client_name}}" <?php if(isset($drrealestate->Op_Real_Estate_SoleSeparate_Party1) && $drrealestate->Op_Real_Estate_SoleSeparate_Party1==$client_name){ echo "checked"; } ?>> {{$client_name}}</label>
                                        <label><input type="radio" id="Op_Real_Estate_SoleSeparate_Party1_Op" name="Op_Real_Estate_SoleSeparate_Party1" value="{{$opponent_name}}" <?php if(isset($drrealestate->Op_Real_Estate_SoleSeparate_Party1) && $drrealestate->Op_Real_Estate_SoleSeparate_Party1==$opponent_name){ echo "checked"; } ?>> {{$opponent_name}}</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6" id="Op_Real_Estate_SoleSeparate_Grounds1_Div" style="display: none;">
                                    <label for="Op_Real_Estate_SoleSeparate_Grounds1">Why does this person own this Real Estate solely and separately?</label>
                                    <input id="Op_Real_Estate_SoleSeparate_Grounds1" type="text" class="form-control 1_Op_realestate_inputs" name="Op_Real_Estate_SoleSeparate_Grounds1" value="<?php if(isset($drrealestate->Op_Real_Estate_SoleSeparate_Grounds1)){ echo $drrealestate->Op_Real_Estate_SoleSeparate_Grounds1; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>How will this Real Estate value be distributed between the parties?</label>
                                    <div class="w-100 dataInput">
                                        <label><input type="radio" id="Op_Real_Estate_Disposition_Method1_Liquidate/Split_Net_Value" name="Op_Real_Estate_Disposition_Method1" value="Liquidate/Split Net Value" data-onload="getInitialDipositionMethod(this, '1', 'Op');" onchange="getDipositionMethod(this, '1', 'Op');" <?php if(isset($drrealestate->Op_Real_Estate_Disposition_Method1) && $drrealestate->Op_Real_Estate_Disposition_Method1=='Liquidate/Split Net Value'){ echo "checked"; } ?>> Liquidate/Split Net Value</label>
                                        <label><input type="radio" id="Op_Real_Estate_Disposition_Method1_Fixed_Buyout_Refinance" name="Op_Real_Estate_Disposition_Method1" value="Fixed Buyout/Refinance" data-onload="getInitialDipositionMethod(this, '1', 'Op');" onchange="getDipositionMethod(this, '1', 'Op');" <?php if(isset($drrealestate->Op_Real_Estate_Disposition_Method1) && $drrealestate->Op_Real_Estate_Disposition_Method1=='Fixed Buyout/Refinance'){ echo "checked"; } ?>> Fixed Buyout/Refinance</label>
                                    </div>
                                </div>
                                <!-- slider tool -->
                                <div class="form-group col-sm-6 m-auto 1_Op_Slider_Tool slider-tool-main">
                                    <div class="row">
                                        <div class="col">{{$client_name}}</div>
                                        <div class="col text-right">{{$opponent_name}}</div>
                                    </div>
                                    <input id="1_Op_balance_range_selector" type="range" class="form-control slider-tool-input 1_Op_balance_range_selector" name="" value="<?php if(isset($drrealestate->Op_Real_Estate_Percent_Marital_Equity_to_Op1)){ echo $drrealestate->Op_Real_Estate_Percent_Marital_Equity_to_Op1; } ?>" min="0.00" step="0.01" max="100" onchange="updateBalanceInput(this.value, '1', 'Op');">
                                </div>
                                <div class="form-group col-sm-6 m-auto 1_Op_Slider_Tool slider-tool-main">
                                    <div class="row justify-content-between">
                                        <div class="col selectorTool">
                                            <div class="left-col">
                                                <div class="client-info 1_Op_clientpercentage_div clientpercentage_div">
                                                    <?php if(isset($drrealestate->Op_Real_Estate_Percent_Marital_Equity_to_Client1)){ echo $drrealestate->Op_Real_Estate_Percent_Marital_Equity_to_Client1; } else {
                                                        echo '50.00';
                                                    } ?>%
                                                </div>
                                                <div class="client-info 1_Op_clientamount_div clientamount_div" style="clear: both;">
                                                    $<?php if(isset($drrealestate->Op_Real_Estate_Estimated_Value_to_Client1)){ echo $drrealestate->Op_Real_Estate_Estimated_Value_to_Client1; } else {
                                                        echo '0.00';
                                                    } ?>
                                                </div>
                                            </div>
                                            <label>To {{$client_name}}</label>
                                        </div>                                       
                                        <div class="col selectorTool selectorToolRight">
                                            <label>To {{$opponent_name}}</label>
                                            <div class="left-col right-col">
                                                <div class="client-info 1_Op_opponentpercentage_div opponentpercentage_div">
                                                    <?php if(isset($drrealestate->Op_Real_Estate_Percent_Marital_Equity_to_Op1)){ echo $drrealestate->Op_Real_Estate_Percent_Marital_Equity_to_Op1; } else {
                                                        echo '50.00';
                                                    } ?>%
                                                </div>
                                                <div class="client-info 1_Op_opponentamount_div opponentamount_div" style="clear: both;">
                                                    $<?php if(isset($drrealestate->Op_Real_Estate_Estimated_Value_to_Op1)){ echo $drrealestate->Op_Real_Estate_Estimated_Value_to_Op1; } else {
                                                        echo '0.00';
                                                    } ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 m-auto 1_Op_Slider_Tool slider-tool-main">
                                    <label></label>
                                    <div class="w-100">
                                        <label><input type="radio" id="1_Op_Real_Estate_Estimated_Value_Select" name="1_Op_Real_Estate_Estimated_Value_Select_Reset" class="Real_Estate_Estimated_Value_Select_Reset" value="Save"> Save this Distribution of Real Estate #1</label>
                                        <label><input type="radio" id="1_Op_Real_Estate_Estimated_Value_Reset" name="1_Op_Real_Estate_Estimated_Value_Select_Reset" class="Real_Estate_Estimated_Value_Select_Reset" value="Reset" onclick="resetBalanceInput(this, '1', 'Op');"> Reset to Default (50%)</label>
                                    </div>
                                </div>

                                <div class="form-group col-sm-6 Op_Real_Estate_Paying_Party1_Inputs_Div" style="display: none;">
                                    <label>Op Real Estate Paying Party1</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Op_Real_Estate_Paying_Party1_Client" name="Op_Real_Estate_Paying_Party1" value="{{$client_name}}" data-onload="getInitialRealEstatePayingParty(this, '1', 'Op');" onchange="getRealEstatePayingParty(this, '1', 'Op');" <?php if(isset($drrealestate->Op_Real_Estate_Paying_Party1) && $drrealestate->Op_Real_Estate_Paying_Party1==$client_name){ echo "checked"; } ?>> {{$client_name}}</label>
                                        <label><input type="radio" id="Op_Real_Estate_Paying_Party1_Op" name="Op_Real_Estate_Paying_Party1" value="{{$opponent_name}}" data-onload="getInitialRealEstatePayingParty(this, '1', 'Op');" onchange="getRealEstatePayingParty(this, '1', 'Op');" <?php if(isset($drrealestate->Op_Real_Estate_Paying_Party1) && $drrealestate->Op_Real_Estate_Paying_Party1==$opponent_name){ echo "checked"; } ?>> {{$opponent_name}}</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 Op_Real_Estate_Paying_Party1_Inputs_Div" style="display: none;">
                                    <label>{{$client_name}} Real Estate Equity Percent</label>
                                    <input id="Op_Real_Estate_Percent_Marital_Equity_to_Client1" type="number" class="form-control 1_Op_clientpercentage_input clientpercentage_input" name="Op_Real_Estate_Percent_Marital_Equity_to_Client1" value="<?php if(isset($drrealestate->Op_Real_Estate_Percent_Marital_Equity_to_Client1)){ echo $drrealestate->Op_Real_Estate_Percent_Marital_Equity_to_Client1; } ?>" min="0.00" step="0.01" max="100" readonly="">
                                </div>
                                <div class="form-group col-sm-6 Op_Real_Estate_Paying_Party1_Inputs_Div" style="display: none;">
                                    <label>How much is to be paid to {{$client_name}}?</label>
                                    <input id="Op_Real_Estate_Estimated_Value_to_Client1" type="number" class="form-control 1_Op_clientamount_input clientamount_input" name="Op_Real_Estate_Estimated_Value_to_Client1" value="<?php if(isset($drrealestate->Op_Real_Estate_Estimated_Value_to_Client1)){ echo $drrealestate->Op_Real_Estate_Estimated_Value_to_Client1; } ?>" min="0.00" step="0.01" max="999999.99" readonly="" onchange="getEstimatedValueClient(this, '1', 'Op');" onkeyup="getEstimatedValueClient(this, '1', 'Op');">
                                </div>
                                <div class="form-group col-sm-6 Op_Real_Estate_Paying_Party1_Inputs_Div" style="display: none;">
                                    <label>{{$opponent_name}} Real Estate Equity Percent</label>
                                    <input id="Op_Real_Estate_Percent_Marital_Equity_to_Op1" type="number" class="form-control 1_Op_opponentpercentage_input opponentpercentage_input" name="Op_Real_Estate_Percent_Marital_Equity_to_Op1" value="<?php if(isset($drrealestate->Op_Real_Estate_Percent_Marital_Equity_to_Op1)){ echo $drrealestate->Op_Real_Estate_Percent_Marital_Equity_to_Op1; } ?>" min="0.00" step="0.01" max="100" readonly="">
                                </div>
                                <div class="form-group col-sm-6 Op_Real_Estate_Paying_Party1_Inputs_Div" style="display: none;">
                                    <label>How much is to be paid to {{$opponent_name}}?</label>
                                    <input id="Op_Real_Estate_Estimated_Value_to_Op1" type="number" class="form-control 1_Op_opponentamount_input opponentamount_input" name="Op_Real_Estate_Estimated_Value_to_Op1" value="<?php if(isset($drrealestate->Op_Real_Estate_Estimated_Value_to_Op1)){ echo $drrealestate->Op_Real_Estate_Estimated_Value_to_Op1; } ?>" min="0.00" step="0.01" max="999999.99" readonly="" onchange="getEstimatedValueOp(this, '1', 'Op');" onkeyup="getEstimatedValueOp(this, '1', 'Op');">
                                </div>
                                <!-- end of slider tool -->
                            </div>
                            <div class="col-sm-12 mt-4 2_Op_realestate_section" style="display: none;"><h5 class="col-sm-12">Second Real Estate Info</h5>
                                <div class="form-group col-sm-6">
                                    <p class="text-danger 2_Op_no-state-county-found" style="display: none;">No City, State, County found for this zipcode.</p>
                                    <label for="Op_Real_Estate_ZIP2">ZIP code of this Property?</label>
                                    <input id="Op_Real_Estate_ZIP2" type="text" class="form-control 2_Op_realestate_inputs" name="Op_Real_Estate_ZIP2" value="<?php if(isset($drrealestate->Op_Real_Estate_ZIP2)){ echo $drrealestate->Op_Real_Estate_ZIP2; } ?>" data-onload="getCityStateForZip(this, '2', 'Op');" onkeyup="getCityStateForZip(this, '2', 'Op');"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Real_Estate_Street_Address2">This Property Street Address?</label>
                                    <input id="Op_Real_Estate_Street_Address2" type="text" class="form-control 2_Op_realestate_inputs" name="Op_Real_Estate_Street_Address2" value="<?php if(isset($drrealestate->Op_Real_Estate_Street_Address2)){ echo $drrealestate->Op_Real_Estate_Street_Address2; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Real_Estate_City2">This Property City?</label>
                                    <input type="hidden" name="" id="Op_Real_Estate_Institution_City2_Value" value="<?php if(isset($drrealestate->Op_Real_Estate_City2)){ echo $drrealestate->Op_Real_Estate_City2; } ?>">
                                    <select id="Op_Real_Estate_City2" name="Op_Real_Estate_City2" class="form-control 2_Op_city_select">
                                        <option value="">Choose City</option>
                                    </select>   
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Real_Estate_State2">This Property State?</label>
                                    <input type="hidden" name="" id="Op_Real_Estate_Institution_State2_Value" value="<?php if(isset($drrealestate->Op_Real_Estate_State2)){ echo $drrealestate->Op_Real_Estate_State2; } ?>">
                                    <select id="Op_Real_Estate_State2" name="Op_Real_Estate_State2" class="form-control 2_Op_state_select">
                                        <option value="">Choose State</option>
                                    </select>   
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Real_Estate_Current_Value2">Current Value?</label>
                                    <input id="Op_Real_Estate_Current_Value2" type="number" class="form-control 2_Op_realestate_inputs" name="Op_Real_Estate_Current_Value2" value="<?php if(isset($drrealestate->Op_Real_Estate_Current_Value2)){ echo $drrealestate->Op_Real_Estate_Current_Value2; } ?>" min="0.00" step="0.01" max="999999.99" onchange="getJointCurrentValue(this, '2', 'Op');" onkeyup="getJointCurrentValue(this, '2', 'Op');"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Real_Estate_First_Mortgage_Company_Name2">Name of First Mortgage/Loan Company for this Property?</label>
                                    <input id="Op_Real_Estate_First_Mortgage_Company_Name2" type="text" class="form-control 2_Op_realestate_inputs" name="Op_Real_Estate_First_Mortgage_Company_Name2" value="<?php if(isset($drrealestate->Op_Real_Estate_First_Mortgage_Company_Name2)){ echo $drrealestate->Op_Real_Estate_First_Mortgage_Company_Name2; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Real_Estate_First_Mortgage_Balance2">Balance owed on First Mortgage/Loan for this Property?</label>
                                    <input id="Op_Real_Estate_First_Mortgage_Balance2" type="number" class="form-control 2_Op_realestate_inputs" name="Op_Real_Estate_First_Mortgage_Balance2" value="<?php if(isset($drrealestate->Op_Real_Estate_First_Mortgage_Balance2)){ echo $drrealestate->Op_Real_Estate_First_Mortgage_Balance2; } ?>" onchange="getMaritalEquity(this, '2', 'Op');" onkeyup="getMaritalEquity(this, '2', 'Op');" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Real_Estate_First_Mortgage_Monthly_Payment2">Monthly payment for First Mortgage/Loan for this Property?</label>
                                    <input id="Op_Real_Estate_First_Mortgage_Monthly_Payment2" type="number" class="form-control 2_Op_realestate_inputs" name="Op_Real_Estate_First_Mortgage_Monthly_Payment2" value="<?php if(isset($drrealestate->Op_Real_Estate_First_Mortgage_Monthly_Payment2)){ echo $drrealestate->Op_Real_Estate_First_Mortgage_Monthly_Payment2; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Real_Estate_Second_Mortgage_LOC_Company_Name2">Name of Second Mortgage/Loan Company for this Property?</label>
                                    <input id="Op_Real_Estate_Second_Mortgage_LOC_Company_Name2" type="text" class="form-control 2_Op_realestate_inputs" name="Op_Real_Estate_Second_Mortgage_LOC_Company_Name2" value="<?php if(isset($drrealestate->Op_Real_Estate_Second_Mortgage_LOC_Company_Name2)){ echo $drrealestate->Op_Real_Estate_Second_Mortgage_LOC_Company_Name2; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Real_Estate_Second_Mortgage_LOC_Balance2">Balance owed on Second Mortgage/Loan for this Property?</label>
                                    <input id="Op_Real_Estate_Second_Mortgage_LOC_Balance2" type="number" class="form-control 2_Op_realestate_inputs" name="Op_Real_Estate_Second_Mortgage_LOC_Balance2" value="<?php if(isset($drrealestate->Op_Real_Estate_Second_Mortgage_LOC_Balance2)){ echo $drrealestate->Op_Real_Estate_Second_Mortgage_LOC_Balance2; } ?>" onchange="getMaritalEquity(this, '2', 'Op');" onkeyup="getMaritalEquity(this, '2', 'Op');" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Real_Estate_Second_Mortgage_LOC_Monthly_Payment2">Monthly payment for Second Mortgage/Loan for this Property?</label>
                                    <input id="Op_Real_Estate_Second_Mortgage_LOC_Monthly_Payment2" type="number" class="form-control 2_Op_realestate_inputs" name="Op_Real_Estate_Second_Mortgage_LOC_Monthly_Payment2" value="<?php if(isset($drrealestate->Op_Real_Estate_Second_Mortgage_LOC_Monthly_Payment2)){ echo $drrealestate->Op_Real_Estate_Second_Mortgage_LOC_Monthly_Payment2; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Real_Estate_MaritalEquity2">Marital Equity</label>
                                    <input id="Op_Real_Estate_MaritalEquity2" type="number" class="form-control 2_Op_realestate_inputs" name="Op_Real_Estate_MaritalEquity2" readonly value="<?php if(isset($drrealestate->Op_Real_Estate_MaritalEquity2)){ echo $drrealestate->Op_Real_Estate_MaritalEquity2; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Is this Property a Rental/Investment Property?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Op_Real_Estate_Rental2_Yes" name="Op_Real_Estate_Rental2" value="Yes" data-onload="getInitialRentalProperty(this, '2', 'Op');" onchange="getRentalProperty(this, '2', 'Op');" <?php if(isset($drrealestate->Op_Real_Estate_Rental2) && $drrealestate->Op_Real_Estate_Rental2=='Yes'){ echo "checked"; $hide='style="display: none;"'; } ?>> Yes</label>
                                        <label><input type="radio" id="Op_Real_Estate_Rental2_No" name="Op_Real_Estate_Rental2" value="No" data-onload="getInitialRentalProperty(this, '2', 'Op');" onchange="getRentalProperty(this, '2', 'Op');" <?php if(isset($drrealestate->Op_Real_Estate_Rental2) && $drrealestate->Op_Real_Estate_Rental2=='No'){ echo "checked"; $hide=''; } ?>> No</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Real_Estate_Yearly_Net_Rental_Income2">{{$opponent_name}} Real Estate Yearly Net Rental Income2</label>
                                    <input id="Op_Real_Estate_Yearly_Net_Rental_Income2" type="number" class="form-control 2_Op_realestate_inputs" name="Op_Real_Estate_Yearly_Net_Rental_Income2" onchange="getYearlyNetRentalIncome(this, '2', 'Op');" onkeyup="getYearlyNetRentalIncome(this, '2', 'Op');" value="<?php if(isset($drrealestate->Op_Real_Estate_Yearly_Net_Rental_Income2)){ echo $drrealestate->Op_Real_Estate_Yearly_Net_Rental_Income2; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6 Op_Real_Estate_Rental2_Input_Div">
                                    <label for="Op_Real_Estate_Client_Share_Rental2">{{$client_name}} Share of Yearly Net Rent</label>
                                    <input id="Op_Real_Estate_Client_Share_Rental2" type="number" class="form-control 2_Op_realestate_inputs" name="Op_Real_Estate_Client_Share_Rental2" value="<?php if(isset($drrealestate->Op_Real_Estate_Client_Share_Rental2)){ echo $drrealestate->Op_Real_Estate_Client_Share_Rental2; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6 Op_Real_Estate_Rental2_Input_Div">
                                    <label for="Op_Real_Estate_Op_Share_Rental2">{{$opponent_name}} Share of Yearly Net Rent</label>
                                    <input id="Op_Real_Estate_Op_Share_Rental2" type="number" class="form-control 2_Op_realestate_inputs" name="Op_Real_Estate_Op_Share_Rental2" value="<?php if(isset($drrealestate->Op_Real_Estate_Op_Share_Rental2)){ echo $drrealestate->Op_Real_Estate_Op_Share_Rental2; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Does either party claim a sole/separate interest in this Real Estate?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Op_Real_Estate_SoleSeparate_Claim2_Yes" name="Op_Real_Estate_SoleSeparate_Claim2" value="Yes" data-onload="getInitialPartyClaimSoleSeparate(this, '2', 'Op');" onchange="getPartyClaimSoleSeparate(this, '2', 'Op');" <?php if(isset($drrealestate->Op_Real_Estate_SoleSeparate_Claim2) && $drrealestate->Op_Real_Estate_SoleSeparate_Claim2=='Yes'){ echo "checked"; } ?>> Yes</label>
                                        <label><input type="radio" id="Op_Real_Estate_SoleSeparate_Claim2_No" name="Op_Real_Estate_SoleSeparate_Claim2" value="No" data-onload="getInitialPartyClaimSoleSeparate(this, '2', 'Op');" onchange="getPartyClaimSoleSeparate(this, '2', 'Op');" <?php if(isset($drrealestate->Op_Real_Estate_SoleSeparate_Claim2) && $drrealestate->Op_Real_Estate_SoleSeparate_Claim2=='No'){ echo "checked"; } ?>> No</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6" id="Op_Real_Estate_SoleSeparate_Party2_Div" style="display: none;">
                                    <label>Who claims to own this Real Estate?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Op_Real_Estate_SoleSeparate_Party2_Client" name="Op_Real_Estate_SoleSeparate_Party2" value="{{$client_name}}" <?php if(isset($drrealestate->Op_Real_Estate_SoleSeparate_Party2) && $drrealestate->Op_Real_Estate_SoleSeparate_Party2==$client_name){ echo "checked"; } ?>> {{$client_name}}</label>
                                        <label><input type="radio" id="Op_Real_Estate_SoleSeparate_Party2_Op" name="Op_Real_Estate_SoleSeparate_Party2" value="{{$opponent_name}}" <?php if(isset($drrealestate->Op_Real_Estate_SoleSeparate_Party2) && $drrealestate->Op_Real_Estate_SoleSeparate_Party2==$opponent_name){ echo "checked"; } ?>> {{$opponent_name}}</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6" id="Op_Real_Estate_SoleSeparate_Grounds2_Div" style="display: none;">
                                    <label for="Op_Real_Estate_SoleSeparate_Grounds2">Why does this person own this Real Estate solely and separately?</label>
                                    <input id="Op_Real_Estate_SoleSeparate_Grounds2" type="text" class="form-control 2_Op_realestate_inputs" name="Op_Real_Estate_SoleSeparate_Grounds2" value="<?php if(isset($drrealestate->Op_Real_Estate_SoleSeparate_Grounds2)){ echo $drrealestate->Op_Real_Estate_SoleSeparate_Grounds2; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>How will this Real Estate value be distributed between the parties?</label>
                                    <div class="w-100 dataInput">
                                        <label><input type="radio" id="Op_Real_Estate_Disposition_Method2_Liquidate/Split_Net_Value" name="Op_Real_Estate_Disposition_Method2" value="Liquidate/Split Net Value" data-onload="getInitialDipositionMethod(this, '2', 'Op');" onchange="getDipositionMethod(this, '2', 'Op');" <?php if(isset($drrealestate->Op_Real_Estate_Disposition_Method2) && $drrealestate->Op_Real_Estate_Disposition_Method2=='Liquidate/Split Net Value'){ echo "checked"; } ?>> Liquidate/Split Net Value</label>
                                        <label><input type="radio" id="Op_Real_Estate_Disposition_Method2_Fixed_Buyout_Refinance" name="Op_Real_Estate_Disposition_Method2" value="Fixed Buyout/Refinance" data-onload="getInitialDipositionMethod(this, '2', 'Op');" onchange="getDipositionMethod(this, '2', 'Op');" <?php if(isset($drrealestate->Op_Real_Estate_Disposition_Method2) && $drrealestate->Op_Real_Estate_Disposition_Method2=='Fixed Buyout/Refinance'){ echo "checked"; } ?>> Fixed Buyout/Refinance</label>
                                    </div>
                                </div>
                                <!-- slider tool -->
                                <div class="form-group col-sm-6 m-auto 2_Op_Slider_Tool slider-tool-main">
                                    <div class="row">
                                        <div class="col">{{$client_name}}</div>
                                        <div class="col text-right">{{$opponent_name}}</div>
                                    </div>
                                    <input id="2_Op_balance_range_selector" type="range" class="form-control slider-tool-input 2_Op_balance_range_selector" name="" value="<?php if(isset($drrealestate->Op_Real_Estate_Percent_Marital_Equity_to_Op2)){ echo $drrealestate->Op_Real_Estate_Percent_Marital_Equity_to_Op2; } ?>" min="0.00" step="0.01" max="100" onchange="updateBalanceInput(this.value, '2', 'Op');">
                                </div>
                                <div class="form-group col-sm-6 m-auto 2_Op_Slider_Tool slider-tool-main">
                                    <div class="row justify-content-between">
                                        <div class="col selectorTool">
                                            <div class="left-col">
                                                <div class="client-info 2_Op_clientpercentage_div clientpercentage_div">
                                                    <?php if(isset($drrealestate->Op_Real_Estate_Percent_Marital_Equity_to_Client2)){ echo $drrealestate->Op_Real_Estate_Percent_Marital_Equity_to_Client2; } else {
                                                        echo '50.00';
                                                    } ?>%
                                                </div>
                                                <div class="client-info 2_Op_clientamount_div clientamount_div" style="clear: both;">
                                                    $<?php if(isset($drrealestate->Op_Real_Estate_Estimated_Value_to_Client2)){ echo $drrealestate->Op_Real_Estate_Estimated_Value_to_Client2; } else {
                                                        echo '0.00';
                                                    } ?>
                                                </div>
                                            </div>
                                            <label>To {{$client_name}}</label>
                                        </div>                                       
                                        <div class="col selectorTool selectorToolRight">
                                            <label>To {{$opponent_name}}</label>
                                            <div class="left-col right-col">
                                                <div class="client-info 2_Op_opponentpercentage_div opponentpercentage_div">
                                                    <?php if(isset($drrealestate->Op_Real_Estate_Percent_Marital_Equity_to_Op2)){ echo $drrealestate->Op_Real_Estate_Percent_Marital_Equity_to_Op2; } else {
                                                        echo '50.00';
                                                    } ?>%
                                                </div>
                                                <div class="client-info 2_Op_opponentamount_div opponentamount_div" style="clear: both;">
                                                    $<?php if(isset($drrealestate->Op_Real_Estate_Estimated_Value_to_Op2)){ echo $drrealestate->Op_Real_Estate_Estimated_Value_to_Op2; } else {
                                                        echo '0.00';
                                                    } ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 m-auto 2_Op_Slider_Tool slider-tool-main">
                                    <label></label>
                                    <div class="w-100">
                                        <label><input type="radio" id="2_Op_Real_Estate_Estimated_Value_Select" name="2_Op_Real_Estate_Estimated_Value_Select_Reset" class="Real_Estate_Estimated_Value_Select_Reset" value="Save"> Save this Distribution of Real Estate #2</label>
                                        <label><input type="radio" id="2_Op_Real_Estate_Estimated_Value_Reset" name="2_Op_Real_Estate_Estimated_Value_Select_Reset" class="Real_Estate_Estimated_Value_Select_Reset" value="Reset" onclick="resetBalanceInput(this, '2', 'Op');"> Reset to Default (50%)</label>
                                    </div>
                                </div>

                                <div class="form-group col-sm-6 Op_Real_Estate_Paying_Party2_Inputs_Div" style="display: none;">
                                    <label>Op Real Estate Paying Party2</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Op_Real_Estate_Paying_Party2_Client" name="Op_Real_Estate_Paying_Party2" value="{{$client_name}}" data-onload="getInitialRealEstatePayingParty(this, '2', 'Op');" onchange="getRealEstatePayingParty(this, '2', 'Op');" <?php if(isset($drrealestate->Op_Real_Estate_Paying_Party2) && $drrealestate->Op_Real_Estate_Paying_Party2==$client_name){ echo "checked"; } ?>> {{$client_name}}</label>
                                        <label><input type="radio" id="Op_Real_Estate_Paying_Party2_Op" name="Op_Real_Estate_Paying_Party2" value="{{$opponent_name}}" data-onload="getInitialRealEstatePayingParty(this, '2', 'Op');" onchange="getRealEstatePayingParty(this, '2', 'Op');" <?php if(isset($drrealestate->Op_Real_Estate_Paying_Party2) && $drrealestate->Op_Real_Estate_Paying_Party2==$opponent_name){ echo "checked"; } ?>> {{$opponent_name}}</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 Op_Real_Estate_Paying_Party2_Inputs_Div" style="display: none;">
                                    <label>{{$client_name}} Real Estate Equity Percent</label>
                                    <input id="Op_Real_Estate_Percent_Marital_Equity_to_Client2" type="number" class="form-control 2_Op_clientpercentage_input clientpercentage_input" name="Op_Real_Estate_Percent_Marital_Equity_to_Client2" value="<?php if(isset($drrealestate->Op_Real_Estate_Percent_Marital_Equity_to_Client2)){ echo $drrealestate->Op_Real_Estate_Percent_Marital_Equity_to_Client2; } ?>" min="0.00" step="0.01" max="100" readonly="">
                                </div>
                                <div class="form-group col-sm-6 Op_Real_Estate_Paying_Party2_Inputs_Div" style="display: none;">
                                    <label>How much is to be paid to {{$client_name}}?</label>
                                    <input id="Op_Real_Estate_Estimated_Value_to_Client2" type="number" class="form-control 2_Op_clientamount_input clientamount_input" name="Op_Real_Estate_Estimated_Value_to_Client2" value="<?php if(isset($drrealestate->Op_Real_Estate_Estimated_Value_to_Client2)){ echo $drrealestate->Op_Real_Estate_Estimated_Value_to_Client2; } ?>" min="0.00" step="0.01" max="999999.99" readonly="" onchange="getEstimatedValueClient(this, '2', 'Op');" onkeyup="getEstimatedValueClient(this, '2', 'Op');">
                                </div>
                                <div class="form-group col-sm-6 Op_Real_Estate_Paying_Party2_Inputs_Div" style="display: none;">
                                    <label>{{$opponent_name}} Real Estate Equity Percent</label>
                                    <input id="Op_Real_Estate_Percent_Marital_Equity_to_Op2" type="number" class="form-control 2_Op_opponentpercentage_input opponentpercentage_input" name="Op_Real_Estate_Percent_Marital_Equity_to_Op2" value="<?php if(isset($drrealestate->Op_Real_Estate_Percent_Marital_Equity_to_Op2)){ echo $drrealestate->Op_Real_Estate_Percent_Marital_Equity_to_Op2; } ?>" min="0.00" step="0.01" max="100" readonly="">
                                </div>
                                <div class="form-group col-sm-6 Op_Real_Estate_Paying_Party2_Inputs_Div" style="display: none;">
                                    <label>How much is to be paid to {{$opponent_name}}?</label>
                                    <input id="Op_Real_Estate_Estimated_Value_to_Op2" type="number" class="form-control 2_Op_opponentamount_input opponentamount_input" name="Op_Real_Estate_Estimated_Value_to_Op2" value="<?php if(isset($drrealestate->Op_Real_Estate_Estimated_Value_to_Op2)){ echo $drrealestate->Op_Real_Estate_Estimated_Value_to_Op2; } ?>" min="0.00" step="0.01" max="999999.99" readonly="" onchange="getEstimatedValueOp(this, '2', 'Op');" onkeyup="getEstimatedValueOp(this, '2', 'Op');">
                                </div>
                                <!-- end of slider tool -->
                            </div>
                            <div class="col-sm-12 mt-4 3_Op_realestate_section" style="display: none;"><h5 class="col-sm-12">Third Real Estate Info</h5>
                                <div class="form-group col-sm-6">
                                    <p class="text-danger 3_Op_no-state-county-found" style="display: none;">No City, State, County found for this zipcode.</p>
                                    <label for="Op_Real_Estate_ZIP3">ZIP code of this Property?</label>
                                    <input id="Op_Real_Estate_ZIP3" type="text" class="form-control 3_Op_realestate_inputs" name="Op_Real_Estate_ZIP3" value="<?php if(isset($drrealestate->Op_Real_Estate_ZIP3)){ echo $drrealestate->Op_Real_Estate_ZIP3; } ?>" data-onload="getCityStateForZip(this, '3', 'Op');" onkeyup="getCityStateForZip(this, '3', 'Op');"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Real_Estate_Street_Address3">This Property Street Address?</label>
                                    <input id="Op_Real_Estate_Street_Address3" type="text" class="form-control 3_Op_realestate_inputs" name="Op_Real_Estate_Street_Address3" value="<?php if(isset($drrealestate->Op_Real_Estate_Street_Address3)){ echo $drrealestate->Op_Real_Estate_Street_Address3; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Real_Estate_City3">This Property City?</label>
                                    <input type="hidden" name="" id="Op_Real_Estate_Institution_City3_Value" value="<?php if(isset($drrealestate->Op_Real_Estate_City3)){ echo $drrealestate->Op_Real_Estate_City3; } ?>">
                                    <select id="Op_Real_Estate_City3" name="Op_Real_Estate_City3" class="form-control 3_Op_city_select">
                                        <option value="">Choose City</option>
                                    </select>   
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Real_Estate_State3">This Property State?</label>
                                    <input type="hidden" name="" id="Op_Real_Estate_Institution_State3_Value" value="<?php if(isset($drrealestate->Op_Real_Estate_State3)){ echo $drrealestate->Op_Real_Estate_State3; } ?>">
                                    <select id="Op_Real_Estate_State3" name="Op_Real_Estate_State3" class="form-control 3_Op_state_select">
                                        <option value="">Choose State</option>
                                    </select>   
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Real_Estate_Current_Value3">Current Value?</label>
                                    <input id="Op_Real_Estate_Current_Value3" type="number" class="form-control 3_Op_realestate_inputs" name="Op_Real_Estate_Current_Value3" value="<?php if(isset($drrealestate->Op_Real_Estate_Current_Value3)){ echo $drrealestate->Op_Real_Estate_Current_Value3; } ?>" min="0.00" step="0.01" max="999999.99" onchange="getJointCurrentValue(this, '3', 'Op');" onkeyup="getJointCurrentValue(this, '3', 'Op');"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Real_Estate_First_Mortgage_Company_Name3">Name of First Mortgage/Loan Company for this Property?</label>
                                    <input id="Op_Real_Estate_First_Mortgage_Company_Name3" type="text" class="form-control 3_Op_realestate_inputs" name="Op_Real_Estate_First_Mortgage_Company_Name3" value="<?php if(isset($drrealestate->Op_Real_Estate_First_Mortgage_Company_Name3)){ echo $drrealestate->Op_Real_Estate_First_Mortgage_Company_Name3; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Real_Estate_First_Mortgage_Balance3">Balance owed on First Mortgage/Loan for this Property?</label>
                                    <input id="Op_Real_Estate_First_Mortgage_Balance3" type="number" class="form-control 3_Op_realestate_inputs" name="Op_Real_Estate_First_Mortgage_Balance3" value="<?php if(isset($drrealestate->Op_Real_Estate_First_Mortgage_Balance3)){ echo $drrealestate->Op_Real_Estate_First_Mortgage_Balance3; } ?>" onchange="getMaritalEquity(this, '3', 'Op');" onkeyup="getMaritalEquity(this, '3', 'Op');" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Real_Estate_First_Mortgage_Monthly_Payment3">Monthly payment for First Mortgage/Loan for this Property?</label>
                                    <input id="Op_Real_Estate_First_Mortgage_Monthly_Payment3" type="number" class="form-control 3_Op_realestate_inputs" name="Op_Real_Estate_First_Mortgage_Monthly_Payment3" value="<?php if(isset($drrealestate->Op_Real_Estate_First_Mortgage_Monthly_Payment3)){ echo $drrealestate->Op_Real_Estate_First_Mortgage_Monthly_Payment3; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Real_Estate_Second_Mortgage_LOC_Company_Name3">Name of Second Mortgage/Loan Company for this Property?</label>
                                    <input id="Op_Real_Estate_Second_Mortgage_LOC_Company_Name3" type="text" class="form-control 3_Op_realestate_inputs" name="Op_Real_Estate_Second_Mortgage_LOC_Company_Name3" value="<?php if(isset($drrealestate->Op_Real_Estate_Second_Mortgage_LOC_Company_Name3)){ echo $drrealestate->Op_Real_Estate_Second_Mortgage_LOC_Company_Name3; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Real_Estate_Second_Mortgage_LOC_Balance3">Balance owed on Second Mortgage/Loan for this Property?</label>
                                    <input id="Op_Real_Estate_Second_Mortgage_LOC_Balance3" type="number" class="form-control 3_Op_realestate_inputs" name="Op_Real_Estate_Second_Mortgage_LOC_Balance3" value="<?php if(isset($drrealestate->Op_Real_Estate_Second_Mortgage_LOC_Balance3)){ echo $drrealestate->Op_Real_Estate_Second_Mortgage_LOC_Balance3; } ?>" onchange="getMaritalEquity(this, '3', 'Op');" onkeyup="getMaritalEquity(this, '3', 'Op');" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Real_Estate_Second_Mortgage_LOC_Monthly_Payment3">Monthly payment for Second Mortgage/Loan for this Property?</label>
                                    <input id="Op_Real_Estate_Second_Mortgage_LOC_Monthly_Payment3" type="number" class="form-control 3_Op_realestate_inputs" name="Op_Real_Estate_Second_Mortgage_LOC_Monthly_Payment3" value="<?php if(isset($drrealestate->Op_Real_Estate_Second_Mortgage_LOC_Monthly_Payment3)){ echo $drrealestate->Op_Real_Estate_Second_Mortgage_LOC_Monthly_Payment3; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Real_Estate_MaritalEquity3">Marital Equity</label>
                                    <input id="Op_Real_Estate_MaritalEquity3" type="number" class="form-control 3_Op_realestate_inputs" name="Op_Real_Estate_MaritalEquity3" readonly value="<?php if(isset($drrealestate->Op_Real_Estate_MaritalEquity3)){ echo $drrealestate->Op_Real_Estate_MaritalEquity3; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Is this Property a Rental/Investment Property?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Op_Real_Estate_Rental3_Yes" name="Op_Real_Estate_Rental3" value="Yes" data-onload="getInitialRentalProperty(this, '3', 'Op');" onchange="getRentalProperty(this, '3', 'Op');" <?php if(isset($drrealestate->Op_Real_Estate_Rental3) && $drrealestate->Op_Real_Estate_Rental3=='Yes'){ echo "checked"; $hide='style="display: none;"'; } ?>> Yes</label>
                                        <label><input type="radio" id="Op_Real_Estate_Rental3_No" name="Op_Real_Estate_Rental3" value="No" data-onload="getInitialRentalProperty(this, '3', 'Op');" onchange="getRentalProperty(this, '3', 'Op');" <?php if(isset($drrealestate->Op_Real_Estate_Rental3) && $drrealestate->Op_Real_Estate_Rental3=='No'){ echo "checked"; $hide=''; } ?>> No</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Real_Estate_Yearly_Net_Rental_Income3">{{$opponent_name}} Real Estate Yearly Net Rental Income3</label>
                                    <input id="Op_Real_Estate_Yearly_Net_Rental_Income3" type="number" class="form-control 3_Op_realestate_inputs" name="Op_Real_Estate_Yearly_Net_Rental_Income3" onchange="getYearlyNetRentalIncome(this, '3', 'Op');" onkeyup="getYearlyNetRentalIncome(this, '3', 'Op');" value="<?php if(isset($drrealestate->Op_Real_Estate_Yearly_Net_Rental_Income3)){ echo $drrealestate->Op_Real_Estate_Yearly_Net_Rental_Income3; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6 Op_Real_Estate_Rental3_Input_Div">
                                    <label for="Op_Real_Estate_Client_Share_Rental3">{{$client_name}} Share of Yearly Net Rent</label>
                                    <input id="Op_Real_Estate_Client_Share_Rental3" type="number" class="form-control 3_Op_realestate_inputs" name="Op_Real_Estate_Client_Share_Rental3" value="<?php if(isset($drrealestate->Op_Real_Estate_Client_Share_Rental3)){ echo $drrealestate->Op_Real_Estate_Client_Share_Rental3; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6 Op_Real_Estate_Rental3_Input_Div">
                                    <label for="Op_Real_Estate_Op_Share_Rental3">{{$opponent_name}} Share of Yearly Net Rent</label>
                                    <input id="Op_Real_Estate_Op_Share_Rental3" type="number" class="form-control 3_Op_realestate_inputs" name="Op_Real_Estate_Op_Share_Rental3" value="<?php if(isset($drrealestate->Op_Real_Estate_Op_Share_Rental3)){ echo $drrealestate->Op_Real_Estate_Op_Share_Rental3; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Does either party claim a sole/separate interest in this Real Estate?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Op_Real_Estate_SoleSeparate_Claim3_Yes" name="Op_Real_Estate_SoleSeparate_Claim3" value="Yes" data-onload="getInitialPartyClaimSoleSeparate(this, '3', 'Op');" onchange="getPartyClaimSoleSeparate(this, '3', 'Op');" <?php if(isset($drrealestate->Op_Real_Estate_SoleSeparate_Claim3) && $drrealestate->Op_Real_Estate_SoleSeparate_Claim3=='Yes'){ echo "checked"; } ?>> Yes</label>
                                        <label><input type="radio" id="Op_Real_Estate_SoleSeparate_Claim3_No" name="Op_Real_Estate_SoleSeparate_Claim3" value="No" data-onload="getInitialPartyClaimSoleSeparate(this, '3', 'Op');" onchange="getPartyClaimSoleSeparate(this, '3', 'Op');" <?php if(isset($drrealestate->Op_Real_Estate_SoleSeparate_Claim3) && $drrealestate->Op_Real_Estate_SoleSeparate_Claim3=='No'){ echo "checked"; } ?>> No</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6" id="Op_Real_Estate_SoleSeparate_Party3_Div" style="display: none;">
                                    <label>Who claims to own this Real Estate?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Op_Real_Estate_SoleSeparate_Party3_Client" name="Op_Real_Estate_SoleSeparate_Party3" value="{{$client_name}}" <?php if(isset($drrealestate->Op_Real_Estate_SoleSeparate_Party3) && $drrealestate->Op_Real_Estate_SoleSeparate_Party3==$client_name){ echo "checked"; } ?>> {{$client_name}}</label>
                                        <label><input type="radio" id="Op_Real_Estate_SoleSeparate_Party3_Op" name="Op_Real_Estate_SoleSeparate_Party3" value="{{$opponent_name}}" <?php if(isset($drrealestate->Op_Real_Estate_SoleSeparate_Party3) && $drrealestate->Op_Real_Estate_SoleSeparate_Party3==$opponent_name){ echo "checked"; } ?>> {{$opponent_name}}</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6" id="Op_Real_Estate_SoleSeparate_Grounds3_Div" style="display: none;">
                                    <label for="Op_Real_Estate_SoleSeparate_Grounds3">Why does this person own this Real Estate solely and separately?</label>
                                    <input id="Op_Real_Estate_SoleSeparate_Grounds3" type="text" class="form-control 3_Op_realestate_inputs" name="Op_Real_Estate_SoleSeparate_Grounds3" value="<?php if(isset($drrealestate->Op_Real_Estate_SoleSeparate_Grounds3)){ echo $drrealestate->Op_Real_Estate_SoleSeparate_Grounds3; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>How will this Real Estate value be distributed between the parties?</label>
                                    <div class="w-100 dataInput">
                                        <label><input type="radio" id="Op_Real_Estate_Disposition_Method3_Liquidate/Split_Net_Value" name="Op_Real_Estate_Disposition_Method3" value="Liquidate/Split Net Value" data-onload="getInitialDipositionMethod(this, '3', 'Op');" onchange="getDipositionMethod(this, '3', 'Op');" <?php if(isset($drrealestate->Op_Real_Estate_Disposition_Method3) && $drrealestate->Op_Real_Estate_Disposition_Method3=='Liquidate/Split Net Value'){ echo "checked"; } ?>> Liquidate/Split Net Value</label>
                                        <label><input type="radio" id="Op_Real_Estate_Disposition_Method3_Fixed_Buyout_Refinance" name="Op_Real_Estate_Disposition_Method3" value="Fixed Buyout/Refinance" data-onload="getInitialDipositionMethod(this, '3', 'Op');" onchange="getDipositionMethod(this, '3', 'Op');" <?php if(isset($drrealestate->Op_Real_Estate_Disposition_Method3) && $drrealestate->Op_Real_Estate_Disposition_Method3=='Fixed Buyout/Refinance'){ echo "checked"; } ?>> Fixed Buyout/Refinance</label>
                                    </div>
                                </div>
                                <!-- slider tool -->
                                <div class="form-group col-sm-6 m-auto 3_Op_Slider_Tool slider-tool-main">
                                    <div class="row">
                                        <div class="col">{{$client_name}}</div>
                                        <div class="col text-right">{{$opponent_name}}</div>
                                    </div>
                                    <input id="3_Op_balance_range_selector" type="range" class="form-control slider-tool-input 3_Op_balance_range_selector" name="" value="<?php if(isset($drrealestate->Op_Real_Estate_Percent_Marital_Equity_to_Op3)){ echo $drrealestate->Op_Real_Estate_Percent_Marital_Equity_to_Op3; } ?>" min="0.00" step="0.01" max="100" onchange="updateBalanceInput(this.value, '3', 'Op');">
                                </div>
                                <div class="form-group col-sm-6 m-auto 3_Op_Slider_Tool slider-tool-main">
                                    <div class="row justify-content-between">
                                        <div class="col selectorTool">
                                            <div class="left-col">
                                                <div class="client-info 3_Op_clientpercentage_div clientpercentage_div">
                                                    <?php if(isset($drrealestate->Op_Real_Estate_Percent_Marital_Equity_to_Client3)){ echo $drrealestate->Op_Real_Estate_Percent_Marital_Equity_to_Client3; } else {
                                                        echo '50.00';
                                                    } ?>%
                                                </div>
                                                <div class="client-info 3_Op_clientamount_div clientamount_div" style="clear: both;">
                                                    $<?php if(isset($drrealestate->Op_Real_Estate_Estimated_Value_to_Client3)){ echo $drrealestate->Op_Real_Estate_Estimated_Value_to_Client3; } else {
                                                        echo '0.00';
                                                    } ?>
                                                </div>
                                            </div>
                                            <label>To {{$client_name}}</label>
                                        </div>                                       
                                        <div class="col selectorTool selectorToolRight">
                                            <label>To {{$opponent_name}}</label>
                                            <div class="left-col right-col">
                                                <div class="client-info 3_Op_opponentpercentage_div opponentpercentage_div">
                                                    <?php if(isset($drrealestate->Op_Real_Estate_Percent_Marital_Equity_to_Op3)){ echo $drrealestate->Op_Real_Estate_Percent_Marital_Equity_to_Op3; } else {
                                                        echo '50.00';
                                                    } ?>%
                                                </div>
                                                <div class="client-info 3_Op_opponentamount_div opponentamount_div" style="clear: both;">
                                                    $<?php if(isset($drrealestate->Op_Real_Estate_Estimated_Value_to_Op3)){ echo $drrealestate->Op_Real_Estate_Estimated_Value_to_Op3; } else {
                                                        echo '0.00';
                                                    } ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 m-auto 3_Op_Slider_Tool slider-tool-main">
                                    <label></label>
                                    <div class="w-100">
                                        <label><input type="radio" id="3_Op_Real_Estate_Estimated_Value_Select" name="3_Op_Real_Estate_Estimated_Value_Select_Reset" class="Real_Estate_Estimated_Value_Select_Reset" value="Save"> Save this Distribution of Real Estate #3</label>
                                        <label><input type="radio" id="3_Op_Real_Estate_Estimated_Value_Reset" name="3_Op_Real_Estate_Estimated_Value_Select_Reset" class="Real_Estate_Estimated_Value_Select_Reset" value="Reset" onclick="resetBalanceInput(this, '3', 'Op');"> Reset to Default (50%)</label>
                                    </div>
                                </div>

                                <div class="form-group col-sm-6 Op_Real_Estate_Paying_Party3_Inputs_Div" style="display: none;">
                                    <label>Op Real Estate Paying Party3</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Op_Real_Estate_Paying_Party3_Client" name="Op_Real_Estate_Paying_Party3" value="{{$client_name}}" data-onload="getInitialRealEstatePayingParty(this, '3', 'Op');" onchange="getRealEstatePayingParty(this, '3', 'Op');" <?php if(isset($drrealestate->Op_Real_Estate_Paying_Party3) && $drrealestate->Op_Real_Estate_Paying_Party3==$client_name){ echo "checked"; } ?>> {{$client_name}}</label>
                                        <label><input type="radio" id="Op_Real_Estate_Paying_Party3_Op" name="Op_Real_Estate_Paying_Party3" value="{{$opponent_name}}" data-onload="getInitialRealEstatePayingParty(this, '3', 'Op');" onchange="getRealEstatePayingParty(this, '3', 'Op');" <?php if(isset($drrealestate->Op_Real_Estate_Paying_Party3) && $drrealestate->Op_Real_Estate_Paying_Party3==$opponent_name){ echo "checked"; } ?>> {{$opponent_name}}</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 Op_Real_Estate_Paying_Party3_Inputs_Div" style="display: none;">
                                    <label>{{$client_name}} Real Estate Equity Percent</label>
                                    <input id="Op_Real_Estate_Percent_Marital_Equity_to_Client3" type="number" class="form-control 3_Op_clientpercentage_input clientpercentage_input" name="Op_Real_Estate_Percent_Marital_Equity_to_Client3" value="<?php if(isset($drrealestate->Op_Real_Estate_Percent_Marital_Equity_to_Client3)){ echo $drrealestate->Op_Real_Estate_Percent_Marital_Equity_to_Client3; } ?>" min="0.00" step="0.01" max="100" readonly="">
                                </div>
                                <div class="form-group col-sm-6 Op_Real_Estate_Paying_Party3_Inputs_Div" style="display: none;">
                                    <label>How much is to be paid to {{$client_name}}?</label>
                                    <input id="Op_Real_Estate_Estimated_Value_to_Client3" type="number" class="form-control 3_Op_clientamount_input clientamount_input" name="Op_Real_Estate_Estimated_Value_to_Client3" value="<?php if(isset($drrealestate->Op_Real_Estate_Estimated_Value_to_Client3)){ echo $drrealestate->Op_Real_Estate_Estimated_Value_to_Client3; } ?>" min="0.00" step="0.01" max="999999.99" readonly="" onchange="getEstimatedValueClient(this, '3', 'Op');" onkeyup="getEstimatedValueClient(this, '3', 'Op');">
                                </div>
                                <div class="form-group col-sm-6 Op_Real_Estate_Paying_Party3_Inputs_Div" style="display: none;">
                                    <label>{{$opponent_name}} Real Estate Equity Percent</label>
                                    <input id="Op_Real_Estate_Percent_Marital_Equity_to_Op3" type="number" class="form-control 3_Op_opponentpercentage_input opponentpercentage_input" name="Op_Real_Estate_Percent_Marital_Equity_to_Op3" value="<?php if(isset($drrealestate->Op_Real_Estate_Percent_Marital_Equity_to_Op3)){ echo $drrealestate->Op_Real_Estate_Percent_Marital_Equity_to_Op3; } ?>" min="0.00" step="0.01" max="100" readonly="">
                                </div>
                                <div class="form-group col-sm-6 Op_Real_Estate_Paying_Party3_Inputs_Div" style="display: none;">
                                    <label>How much is to be paid to {{$opponent_name}}?</label>
                                    <input id="Op_Real_Estate_Estimated_Value_to_Op3" type="number" class="form-control 3_Op_opponentamount_input opponentamount_input" name="Op_Real_Estate_Estimated_Value_to_Op3" value="<?php if(isset($drrealestate->Op_Real_Estate_Estimated_Value_to_Op3)){ echo $drrealestate->Op_Real_Estate_Estimated_Value_to_Op3; } ?>" min="0.00" step="0.01" max="999999.99" readonly="" onchange="getEstimatedValueOp(this, '3', 'Op');" onkeyup="getEstimatedValueOp(this, '3', 'Op');">
                                </div>
                                <!-- end of slider tool -->
                            </div>
                            <div class="col-sm-12 mt-4 4_Op_realestate_section" style="display: none;"><h5 class="col-sm-12">Fourth Real Estate Info</h5>
                                <div class="form-group col-sm-6">
                                    <p class="text-danger 4_Op_no-state-county-found" style="display: none;">No City, State, County found for this zipcode.</p>
                                    <label for="Op_Real_Estate_ZIP4">ZIP code of this Property?</label>
                                    <input id="Op_Real_Estate_ZIP4" type="text" class="form-control 4_Op_realestate_inputs" name="Op_Real_Estate_ZIP4" value="<?php if(isset($drrealestate->Op_Real_Estate_ZIP4)){ echo $drrealestate->Op_Real_Estate_ZIP4; } ?>" data-onload="getCityStateForZip(this, '4', 'Op');" onkeyup="getCityStateForZip(this, '4', 'Op');"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Real_Estate_Street_Address4">This Property Street Address?</label>
                                    <input id="Op_Real_Estate_Street_Address4" type="text" class="form-control 4_Op_realestate_inputs" name="Op_Real_Estate_Street_Address4" value="<?php if(isset($drrealestate->Op_Real_Estate_Street_Address4)){ echo $drrealestate->Op_Real_Estate_Street_Address4; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Real_Estate_City4">This Property City?</label>
                                    <input type="hidden" name="" id="Op_Real_Estate_Institution_City4_Value" value="<?php if(isset($drrealestate->Op_Real_Estate_City4)){ echo $drrealestate->Op_Real_Estate_City4; } ?>">
                                    <select id="Op_Real_Estate_City4" name="Op_Real_Estate_City4" class="form-control 4_Op_city_select">
                                        <option value="">Choose City</option>
                                    </select>   
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Real_Estate_State4">This Property State?</label>
                                    <input type="hidden" name="" id="Op_Real_Estate_Institution_State4_Value" value="<?php if(isset($drrealestate->Op_Real_Estate_State4)){ echo $drrealestate->Op_Real_Estate_State4; } ?>">
                                    <select id="Op_Real_Estate_State4" name="Op_Real_Estate_State4" class="form-control 4_Op_state_select">
                                        <option value="">Choose State</option>
                                    </select>   
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Real_Estate_Current_Value4">Current Value?</label>
                                    <input id="Op_Real_Estate_Current_Value4" type="number" class="form-control 4_Op_realestate_inputs" name="Op_Real_Estate_Current_Value4" value="<?php if(isset($drrealestate->Op_Real_Estate_Current_Value4)){ echo $drrealestate->Op_Real_Estate_Current_Value4; } ?>" min="0.00" step="0.01" max="999999.99" onchange="getJointCurrentValue(this, '4', 'Op');" onkeyup="getJointCurrentValue(this, '4', 'Op');"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Real_Estate_First_Mortgage_Company_Name4">Name of First Mortgage/Loan Company for this Property?</label>
                                    <input id="Op_Real_Estate_First_Mortgage_Company_Name4" type="text" class="form-control 4_Op_realestate_inputs" name="Op_Real_Estate_First_Mortgage_Company_Name4" value="<?php if(isset($drrealestate->Op_Real_Estate_First_Mortgage_Company_Name4)){ echo $drrealestate->Op_Real_Estate_First_Mortgage_Company_Name4; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Real_Estate_First_Mortgage_Balance4">Balance owed on First Mortgage/Loan for this Property?</label>
                                    <input id="Op_Real_Estate_First_Mortgage_Balance4" type="number" class="form-control 4_Op_realestate_inputs" name="Op_Real_Estate_First_Mortgage_Balance4" value="<?php if(isset($drrealestate->Op_Real_Estate_First_Mortgage_Balance4)){ echo $drrealestate->Op_Real_Estate_First_Mortgage_Balance4; } ?>" onchange="getMaritalEquity(this, '4', 'Op');" onkeyup="getMaritalEquity(this, '4', 'Op');" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Real_Estate_First_Mortgage_Monthly_Payment4">Monthly payment for First Mortgage/Loan for this Property?</label>
                                    <input id="Op_Real_Estate_First_Mortgage_Monthly_Payment4" type="number" class="form-control 4_Op_realestate_inputs" name="Op_Real_Estate_First_Mortgage_Monthly_Payment4" value="<?php if(isset($drrealestate->Op_Real_Estate_First_Mortgage_Monthly_Payment4)){ echo $drrealestate->Op_Real_Estate_First_Mortgage_Monthly_Payment4; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Real_Estate_Second_Mortgage_LOC_Company_Name4">Name of Second Mortgage/Loan Company for this Property?</label>
                                    <input id="Op_Real_Estate_Second_Mortgage_LOC_Company_Name4" type="text" class="form-control 4_Op_realestate_inputs" name="Op_Real_Estate_Second_Mortgage_LOC_Company_Name4" value="<?php if(isset($drrealestate->Op_Real_Estate_Second_Mortgage_LOC_Company_Name4)){ echo $drrealestate->Op_Real_Estate_Second_Mortgage_LOC_Company_Name4; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Real_Estate_Second_Mortgage_LOC_Balance4">Balance owed on Second Mortgage/Loan for this Property?</label>
                                    <input id="Op_Real_Estate_Second_Mortgage_LOC_Balance4" type="number" class="form-control 4_Op_realestate_inputs" name="Op_Real_Estate_Second_Mortgage_LOC_Balance4" value="<?php if(isset($drrealestate->Op_Real_Estate_Second_Mortgage_LOC_Balance4)){ echo $drrealestate->Op_Real_Estate_Second_Mortgage_LOC_Balance4; } ?>" onchange="getMaritalEquity(this, '4', 'Op');" onkeyup="getMaritalEquity(this, '4', 'Op');" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Real_Estate_Second_Mortgage_LOC_Monthly_Payment4">Monthly payment for Second Mortgage/Loan for this Property?</label>
                                    <input id="Op_Real_Estate_Second_Mortgage_LOC_Monthly_Payment4" type="number" class="form-control 4_Op_realestate_inputs" name="Op_Real_Estate_Second_Mortgage_LOC_Monthly_Payment4" value="<?php if(isset($drrealestate->Op_Real_Estate_Second_Mortgage_LOC_Monthly_Payment4)){ echo $drrealestate->Op_Real_Estate_Second_Mortgage_LOC_Monthly_Payment4; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Real_Estate_MaritalEquity4">Marital Equity</label>
                                    <input id="Op_Real_Estate_MaritalEquity4" type="number" class="form-control 4_Op_realestate_inputs" name="Op_Real_Estate_MaritalEquity4" readonly value="<?php if(isset($drrealestate->Op_Real_Estate_MaritalEquity4)){ echo $drrealestate->Op_Real_Estate_MaritalEquity4; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Is this Property a Rental/Investment Property?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Op_Real_Estate_Rental4_Yes" name="Op_Real_Estate_Rental4" value="Yes" data-onload="getInitialRentalProperty(this, '4', 'Op');" onchange="getRentalProperty(this, '4', 'Op');" <?php if(isset($drrealestate->Op_Real_Estate_Rental4) && $drrealestate->Op_Real_Estate_Rental4=='Yes'){ echo "checked"; $hide='style="display: none;"'; } ?>> Yes</label>
                                        <label><input type="radio" id="Op_Real_Estate_Rental4_No" name="Op_Real_Estate_Rental4" value="No" data-onload="getInitialRentalProperty(this, '4', 'Op');" onchange="getRentalProperty(this, '4', 'Op');" <?php if(isset($drrealestate->Op_Real_Estate_Rental4) && $drrealestate->Op_Real_Estate_Rental4=='No'){ echo "checked"; $hide=''; } ?>> No</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Real_Estate_Yearly_Net_Rental_Income4">{{$opponent_name}} Real Estate Yearly Net Rental Income4</label>
                                    <input id="Op_Real_Estate_Yearly_Net_Rental_Income4" type="number" class="form-control 4_Op_realestate_inputs" name="Op_Real_Estate_Yearly_Net_Rental_Income4" onchange="getYearlyNetRentalIncome(this, '4', 'Op');" onkeyup="getYearlyNetRentalIncome(this, '4', 'Op');" value="<?php if(isset($drrealestate->Op_Real_Estate_Yearly_Net_Rental_Income4)){ echo $drrealestate->Op_Real_Estate_Yearly_Net_Rental_Income4; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6 Op_Real_Estate_Rental4_Input_Div">
                                    <label for="Op_Real_Estate_Client_Share_Rental4">{{$client_name}} Share of Yearly Net Rent</label>
                                    <input id="Op_Real_Estate_Client_Share_Rental4" type="number" class="form-control 4_Op_realestate_inputs" name="Op_Real_Estate_Client_Share_Rental4" value="<?php if(isset($drrealestate->Op_Real_Estate_Client_Share_Rental4)){ echo $drrealestate->Op_Real_Estate_Client_Share_Rental4; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6 Op_Real_Estate_Rental4_Input_Div">
                                    <label for="Op_Real_Estate_Op_Share_Rental4">{{$opponent_name}} Share of Yearly Net Rent</label>
                                    <input id="Op_Real_Estate_Op_Share_Rental4" type="number" class="form-control 4_Op_realestate_inputs" name="Op_Real_Estate_Op_Share_Rental4" value="<?php if(isset($drrealestate->Op_Real_Estate_Op_Share_Rental4)){ echo $drrealestate->Op_Real_Estate_Op_Share_Rental4; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Does either party claim a sole/separate interest in this Real Estate?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Op_Real_Estate_SoleSeparate_Claim4_Yes" name="Op_Real_Estate_SoleSeparate_Claim4" value="Yes" data-onload="getInitialPartyClaimSoleSeparate(this, '4', 'Op');" onchange="getPartyClaimSoleSeparate(this, '4', 'Op');" <?php if(isset($drrealestate->Op_Real_Estate_SoleSeparate_Claim4) && $drrealestate->Op_Real_Estate_SoleSeparate_Claim4=='Yes'){ echo "checked"; } ?>> Yes</label>
                                        <label><input type="radio" id="Op_Real_Estate_SoleSeparate_Claim4_No" name="Op_Real_Estate_SoleSeparate_Claim4" value="No" data-onload="getInitialPartyClaimSoleSeparate(this, '4', 'Op');" onchange="getPartyClaimSoleSeparate(this, '4', 'Op');" <?php if(isset($drrealestate->Op_Real_Estate_SoleSeparate_Claim4) && $drrealestate->Op_Real_Estate_SoleSeparate_Claim4=='No'){ echo "checked"; } ?>> No</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6" id="Op_Real_Estate_SoleSeparate_Party4_Div" style="display: none;">
                                    <label>Who claims to own this Real Estate?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Op_Real_Estate_SoleSeparate_Party4_Client" name="Op_Real_Estate_SoleSeparate_Party4" value="{{$client_name}}" <?php if(isset($drrealestate->Op_Real_Estate_SoleSeparate_Party4) && $drrealestate->Op_Real_Estate_SoleSeparate_Party4==$client_name){ echo "checked"; } ?>> {{$client_name}}</label>
                                        <label><input type="radio" id="Op_Real_Estate_SoleSeparate_Party4_Op" name="Op_Real_Estate_SoleSeparate_Party4" value="{{$opponent_name}}" <?php if(isset($drrealestate->Op_Real_Estate_SoleSeparate_Party4) && $drrealestate->Op_Real_Estate_SoleSeparate_Party4==$opponent_name){ echo "checked"; } ?>> {{$opponent_name}}</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6" id="Op_Real_Estate_SoleSeparate_Grounds4_Div" style="display: none;">
                                    <label for="Op_Real_Estate_SoleSeparate_Grounds4">Why does this person own this Real Estate solely and separately?</label>
                                    <input id="Op_Real_Estate_SoleSeparate_Grounds4" type="text" class="form-control 4_Op_realestate_inputs" name="Op_Real_Estate_SoleSeparate_Grounds4" value="<?php if(isset($drrealestate->Op_Real_Estate_SoleSeparate_Grounds4)){ echo $drrealestate->Op_Real_Estate_SoleSeparate_Grounds4; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>How will this Real Estate value be distributed between the parties?</label>
                                    <div class="w-100 dataInput">
                                        <label><input type="radio" id="Op_Real_Estate_Disposition_Method4_Liquidate/Split_Net_Value" name="Op_Real_Estate_Disposition_Method4" value="Liquidate/Split Net Value" data-onload="getInitialDipositionMethod(this, '4', 'Op');" onchange="getDipositionMethod(this, '4', 'Op');" <?php if(isset($drrealestate->Op_Real_Estate_Disposition_Method4) && $drrealestate->Op_Real_Estate_Disposition_Method4=='Liquidate/Split Net Value'){ echo "checked"; } ?>> Liquidate/Split Net Value</label>
                                        <label><input type="radio" id="Op_Real_Estate_Disposition_Method4_Fixed_Buyout_Refinance" name="Op_Real_Estate_Disposition_Method4" value="Fixed Buyout/Refinance" data-onload="getInitialDipositionMethod(this, '4', 'Op');" onchange="getDipositionMethod(this, '4', 'Op');" <?php if(isset($drrealestate->Op_Real_Estate_Disposition_Method4) && $drrealestate->Op_Real_Estate_Disposition_Method4=='Fixed Buyout/Refinance'){ echo "checked"; } ?>> Fixed Buyout/Refinance</label>
                                    </div>
                                </div>
                                <!-- slider tool -->
                                <div class="form-group col-sm-6 m-auto 4_Op_Slider_Tool slider-tool-main">
                                    <div class="row">
                                        <div class="col">{{$client_name}}</div>
                                        <div class="col text-right">{{$opponent_name}}</div>
                                    </div>
                                    <input id="4_Op_balance_range_selector" type="range" class="form-control slider-tool-input 4_Op_balance_range_selector" name="" value="<?php if(isset($drrealestate->Op_Real_Estate_Percent_Marital_Equity_to_Op4)){ echo $drrealestate->Op_Real_Estate_Percent_Marital_Equity_to_Op4; } ?>" min="0.00" step="0.01" max="100" onchange="updateBalanceInput(this.value, '4', 'Op');">
                                </div>
                                <div class="form-group col-sm-6 m-auto 4_Op_Slider_Tool slider-tool-main">
                                    <div class="row justify-content-between">
                                        <div class="col selectorTool">
                                            <div class="left-col">
                                                <div class="client-info 4_Op_clientpercentage_div clientpercentage_div">
                                                    <?php if(isset($drrealestate->Op_Real_Estate_Percent_Marital_Equity_to_Client4)){ echo $drrealestate->Op_Real_Estate_Percent_Marital_Equity_to_Client4; } else {
                                                        echo '50.00';
                                                    } ?>%
                                                </div>
                                                <div class="client-info 4_Op_clientamount_div clientamount_div" style="clear: both;">
                                                    $<?php if(isset($drrealestate->Op_Real_Estate_Estimated_Value_to_Client4)){ echo $drrealestate->Op_Real_Estate_Estimated_Value_to_Client4; } else {
                                                        echo '0.00';
                                                    } ?>
                                                </div>
                                            </div>
                                            <label>To {{$client_name}}</label>
                                        </div>                                       
                                        <div class="col selectorTool selectorToolRight">
                                            <label>To {{$opponent_name}}</label>
                                            <div class="left-col right-col">
                                                <div class="client-info 4_Op_opponentpercentage_div opponentpercentage_div">
                                                    <?php if(isset($drrealestate->Op_Real_Estate_Percent_Marital_Equity_to_Op4)){ echo $drrealestate->Op_Real_Estate_Percent_Marital_Equity_to_Op4; } else {
                                                        echo '50.00';
                                                    } ?>%
                                                </div>
                                                <div class="client-info 4_Op_opponentamount_div opponentamount_div" style="clear: both;">
                                                    $<?php if(isset($drrealestate->Op_Real_Estate_Estimated_Value_to_Op4)){ echo $drrealestate->Op_Real_Estate_Estimated_Value_to_Op4; } else {
                                                        echo '0.00';
                                                    } ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 m-auto 4_Op_Slider_Tool slider-tool-main">
                                    <label></label>
                                    <div class="w-100">
                                        <label><input type="radio" id="4_Op_Real_Estate_Estimated_Value_Select" name="4_Op_Real_Estate_Estimated_Value_Select_Reset" class="Real_Estate_Estimated_Value_Select_Reset" value="Save"> Save this Distribution of Real Estate #4</label>
                                        <label><input type="radio" id="4_Op_Real_Estate_Estimated_Value_Reset" name="4_Op_Real_Estate_Estimated_Value_Select_Reset" class="Real_Estate_Estimated_Value_Select_Reset" value="Reset" onclick="resetBalanceInput(this, '4', 'Op');"> Reset to Default (50%)</label>
                                    </div>
                                </div>

                                <div class="form-group col-sm-6 Op_Real_Estate_Paying_Party4_Inputs_Div" style="display: none;">
                                    <label>Op Real Estate Paying Party4</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Op_Real_Estate_Paying_Party4_Client" name="Op_Real_Estate_Paying_Party4" value="{{$client_name}}" data-onload="getInitialRealEstatePayingParty(this, '4', 'Op');" onchange="getRealEstatePayingParty(this, '4', 'Op');" <?php if(isset($drrealestate->Op_Real_Estate_Paying_Party4) && $drrealestate->Op_Real_Estate_Paying_Party4==$client_name){ echo "checked"; } ?>> {{$client_name}}</label>
                                        <label><input type="radio" id="Op_Real_Estate_Paying_Party4_Op" name="Op_Real_Estate_Paying_Party4" value="{{$opponent_name}}" data-onload="getInitialRealEstatePayingParty(this, '4', 'Op');" onchange="getRealEstatePayingParty(this, '4', 'Op');" <?php if(isset($drrealestate->Op_Real_Estate_Paying_Party4) && $drrealestate->Op_Real_Estate_Paying_Party4==$opponent_name){ echo "checked"; } ?>> {{$opponent_name}}</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 Op_Real_Estate_Paying_Party4_Inputs_Div" style="display: none;">
                                    <label>{{$client_name}} Real Estate Equity Percent</label>
                                    <input id="Op_Real_Estate_Percent_Marital_Equity_to_Client4" type="number" class="form-control 4_Op_clientpercentage_input clientpercentage_input" name="Op_Real_Estate_Percent_Marital_Equity_to_Client4" value="<?php if(isset($drrealestate->Op_Real_Estate_Percent_Marital_Equity_to_Client4)){ echo $drrealestate->Op_Real_Estate_Percent_Marital_Equity_to_Client4; } ?>" min="0.00" step="0.01" max="100" readonly="">
                                </div>
                                <div class="form-group col-sm-6 Op_Real_Estate_Paying_Party4_Inputs_Div" style="display: none;">
                                    <label>How much is to be paid to {{$client_name}}?</label>
                                    <input id="Op_Real_Estate_Estimated_Value_to_Client4" type="number" class="form-control 4_Op_clientamount_input clientamount_input" name="Op_Real_Estate_Estimated_Value_to_Client4" value="<?php if(isset($drrealestate->Op_Real_Estate_Estimated_Value_to_Client4)){ echo $drrealestate->Op_Real_Estate_Estimated_Value_to_Client4; } ?>" min="0.00" step="0.01" max="999999.99" readonly="" onchange="getEstimatedValueClient(this, '4', 'Op');" onkeyup="getEstimatedValueClient(this, '4', 'Op');">
                                </div>
                                <div class="form-group col-sm-6 Op_Real_Estate_Paying_Party4_Inputs_Div" style="display: none;">
                                    <label>{{$opponent_name}} Real Estate Equity Percent</label>
                                    <input id="Op_Real_Estate_Percent_Marital_Equity_to_Op4" type="number" class="form-control 4_Op_opponentpercentage_input opponentpercentage_input" name="Op_Real_Estate_Percent_Marital_Equity_to_Op4" value="<?php if(isset($drrealestate->Op_Real_Estate_Percent_Marital_Equity_to_Op4)){ echo $drrealestate->Op_Real_Estate_Percent_Marital_Equity_to_Op4; } ?>" min="0.00" step="0.01" max="100" readonly="">
                                </div>
                                <div class="form-group col-sm-6 Op_Real_Estate_Paying_Party4_Inputs_Div" style="display: none;">
                                    <label>How much is to be paid to {{$opponent_name}}?</label>
                                    <input id="Op_Real_Estate_Estimated_Value_to_Op4" type="number" class="form-control 4_Op_opponentamount_input opponentamount_input" name="Op_Real_Estate_Estimated_Value_to_Op4" value="<?php if(isset($drrealestate->Op_Real_Estate_Estimated_Value_to_Op4)){ echo $drrealestate->Op_Real_Estate_Estimated_Value_to_Op4; } ?>" min="0.00" step="0.01" max="999999.99" readonly="" onchange="getEstimatedValueOp(this, '4', 'Op');" onkeyup="getEstimatedValueOp(this, '4', 'Op');">
                                </div>
                                <!-- end of slider tool -->
                            </div>
                            <div class="col-sm-12 mt-4 5_Op_realestate_section" style="display: none;"><h5 class="col-sm-12">Fifth Real Estate Info</h5>
                                <div class="form-group col-sm-6">
                                    <p class="text-danger 5_Op_no-state-county-found" style="display: none;">No City, State, County found for this zipcode.</p>
                                    <label for="Op_Real_Estate_ZIP5">ZIP code of this Property?</label>
                                    <input id="Op_Real_Estate_ZIP5" type="text" class="form-control 5_Op_realestate_inputs" name="Op_Real_Estate_ZIP5" value="<?php if(isset($drrealestate->Op_Real_Estate_ZIP5)){ echo $drrealestate->Op_Real_Estate_ZIP5; } ?>" data-onload="getCityStateForZip(this, '5', 'Op');" onkeyup="getCityStateForZip(this, '5', 'Op');"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Real_Estate_Street_Address5">This Property Street Address?</label>
                                    <input id="Op_Real_Estate_Street_Address5" type="text" class="form-control 5_Op_realestate_inputs" name="Op_Real_Estate_Street_Address5" value="<?php if(isset($drrealestate->Op_Real_Estate_Street_Address5)){ echo $drrealestate->Op_Real_Estate_Street_Address5; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Real_Estate_City5">This Property City?</label>
                                    <input type="hidden" name="" id="Op_Real_Estate_Institution_City5_Value" value="<?php if(isset($drrealestate->Op_Real_Estate_City5)){ echo $drrealestate->Op_Real_Estate_City5; } ?>">
                                    <select id="Op_Real_Estate_City5" name="Op_Real_Estate_City5" class="form-control 5_Op_city_select">
                                        <option value="">Choose City</option>
                                    </select>   
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Real_Estate_State5">This Property State?</label>
                                    <input type="hidden" name="" id="Op_Real_Estate_Institution_State5_Value" value="<?php if(isset($drrealestate->Op_Real_Estate_State5)){ echo $drrealestate->Op_Real_Estate_State5; } ?>">
                                    <select id="Op_Real_Estate_State5" name="Op_Real_Estate_State5" class="form-control 5_Op_state_select">
                                        <option value="">Choose State</option>
                                    </select>   
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Real_Estate_Current_Value5">Current Value?</label>
                                    <input id="Op_Real_Estate_Current_Value5" type="number" class="form-control 5_Op_realestate_inputs" name="Op_Real_Estate_Current_Value5" value="<?php if(isset($drrealestate->Op_Real_Estate_Current_Value5)){ echo $drrealestate->Op_Real_Estate_Current_Value5; } ?>" min="0.00" step="0.01" max="999999.99" onchange="getJointCurrentValue(this, '5', 'Op');" onkeyup="getJointCurrentValue(this, '5', 'Op');"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Real_Estate_First_Mortgage_Company_Name5">Name of First Mortgage/Loan Company for this Property?</label>
                                    <input id="Op_Real_Estate_First_Mortgage_Company_Name5" type="text" class="form-control 5_Op_realestate_inputs" name="Op_Real_Estate_First_Mortgage_Company_Name5" value="<?php if(isset($drrealestate->Op_Real_Estate_First_Mortgage_Company_Name5)){ echo $drrealestate->Op_Real_Estate_First_Mortgage_Company_Name5; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Real_Estate_First_Mortgage_Balance5">Balance owed on First Mortgage/Loan for this Property?</label>
                                    <input id="Op_Real_Estate_First_Mortgage_Balance5" type="number" class="form-control 5_Op_realestate_inputs" name="Op_Real_Estate_First_Mortgage_Balance5" value="<?php if(isset($drrealestate->Op_Real_Estate_First_Mortgage_Balance5)){ echo $drrealestate->Op_Real_Estate_First_Mortgage_Balance5; } ?>" onchange="getMaritalEquity(this, '5', 'Op');" onkeyup="getMaritalEquity(this, '5', 'Op');" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Real_Estate_First_Mortgage_Monthly_Payment5">Monthly payment for First Mortgage/Loan for this Property?</label>
                                    <input id="Op_Real_Estate_First_Mortgage_Monthly_Payment5" type="number" class="form-control 5_Op_realestate_inputs" name="Op_Real_Estate_First_Mortgage_Monthly_Payment5" value="<?php if(isset($drrealestate->Op_Real_Estate_First_Mortgage_Monthly_Payment5)){ echo $drrealestate->Op_Real_Estate_First_Mortgage_Monthly_Payment5; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Real_Estate_Second_Mortgage_LOC_Company_Name5">Name of Second Mortgage/Loan Company for this Property?</label>
                                    <input id="Op_Real_Estate_Second_Mortgage_LOC_Company_Name5" type="text" class="form-control 5_Op_realestate_inputs" name="Op_Real_Estate_Second_Mortgage_LOC_Company_Name5" value="<?php if(isset($drrealestate->Op_Real_Estate_Second_Mortgage_LOC_Company_Name5)){ echo $drrealestate->Op_Real_Estate_Second_Mortgage_LOC_Company_Name5; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Real_Estate_Second_Mortgage_LOC_Balance5">Balance owed on Second Mortgage/Loan for this Property?</label>
                                    <input id="Op_Real_Estate_Second_Mortgage_LOC_Balance5" type="number" class="form-control 5_Op_realestate_inputs" name="Op_Real_Estate_Second_Mortgage_LOC_Balance5" value="<?php if(isset($drrealestate->Op_Real_Estate_Second_Mortgage_LOC_Balance5)){ echo $drrealestate->Op_Real_Estate_Second_Mortgage_LOC_Balance5; } ?>" onchange="getMaritalEquity(this, '5', 'Op');" onkeyup="getMaritalEquity(this, '5', 'Op');" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Real_Estate_Second_Mortgage_LOC_Monthly_Payment5">Monthly payment for Second Mortgage/Loan for this Property?</label>
                                    <input id="Op_Real_Estate_Second_Mortgage_LOC_Monthly_Payment5" type="number" class="form-control 5_Op_realestate_inputs" name="Op_Real_Estate_Second_Mortgage_LOC_Monthly_Payment5" value="<?php if(isset($drrealestate->Op_Real_Estate_Second_Mortgage_LOC_Monthly_Payment5)){ echo $drrealestate->Op_Real_Estate_Second_Mortgage_LOC_Monthly_Payment5; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Real_Estate_MaritalEquity5">Marital Equity</label>
                                    <input id="Op_Real_Estate_MaritalEquity5" type="number" class="form-control 5_Op_realestate_inputs" name="Op_Real_Estate_MaritalEquity5" readonly value="<?php if(isset($drrealestate->Op_Real_Estate_MaritalEquity5)){ echo $drrealestate->Op_Real_Estate_MaritalEquity5; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Is this Property a Rental/Investment Property?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Op_Real_Estate_Rental5_Yes" name="Op_Real_Estate_Rental5" value="Yes" data-onload="getInitialRentalProperty(this, '5', 'Op');" onchange="getRentalProperty(this, '5', 'Op');" <?php if(isset($drrealestate->Op_Real_Estate_Rental5) && $drrealestate->Op_Real_Estate_Rental5=='Yes'){ echo "checked"; $hide='style="display: none;"'; } ?>> Yes</label>
                                        <label><input type="radio" id="Op_Real_Estate_Rental5_No" name="Op_Real_Estate_Rental5" value="No" data-onload="getInitialRentalProperty(this, '5', 'Op');" onchange="getRentalProperty(this, '5', 'Op');" <?php if(isset($drrealestate->Op_Real_Estate_Rental5) && $drrealestate->Op_Real_Estate_Rental5=='No'){ echo "checked"; $hide=''; } ?>> No</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Real_Estate_Yearly_Net_Rental_Income5">{{$opponent_name}} Real Estate Yearly Net Rental Income5</label>
                                    <input id="Op_Real_Estate_Yearly_Net_Rental_Income5" type="number" class="form-control 5_Op_realestate_inputs" name="Op_Real_Estate_Yearly_Net_Rental_Income5" onchange="getYearlyNetRentalIncome(this, '5', 'Op');" onkeyup="getYearlyNetRentalIncome(this, '5', 'Op');" value="<?php if(isset($drrealestate->Op_Real_Estate_Yearly_Net_Rental_Income5)){ echo $drrealestate->Op_Real_Estate_Yearly_Net_Rental_Income5; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6 Op_Real_Estate_Rental5_Input_Div">
                                    <label for="Op_Real_Estate_Client_Share_Rental5">{{$client_name}} Share of Yearly Net Rent</label>
                                    <input id="Op_Real_Estate_Client_Share_Rental5" type="number" class="form-control 5_Op_realestate_inputs" name="Op_Real_Estate_Client_Share_Rental5" value="<?php if(isset($drrealestate->Op_Real_Estate_Client_Share_Rental5)){ echo $drrealestate->Op_Real_Estate_Client_Share_Rental5; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6 Op_Real_Estate_Rental5_Input_Div">
                                    <label for="Op_Real_Estate_Op_Share_Rental5">{{$opponent_name}} Share of Yearly Net Rent</label>
                                    <input id="Op_Real_Estate_Op_Share_Rental5" type="number" class="form-control 5_Op_realestate_inputs" name="Op_Real_Estate_Op_Share_Rental5" value="<?php if(isset($drrealestate->Op_Real_Estate_Op_Share_Rental5)){ echo $drrealestate->Op_Real_Estate_Op_Share_Rental5; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Does either party claim a sole/separate interest in this Real Estate?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Op_Real_Estate_SoleSeparate_Claim5_Yes" name="Op_Real_Estate_SoleSeparate_Claim5" value="Yes" data-onload="getInitialPartyClaimSoleSeparate(this, '5', 'Op');" onchange="getPartyClaimSoleSeparate(this, '5', 'Op');" <?php if(isset($drrealestate->Op_Real_Estate_SoleSeparate_Claim5) && $drrealestate->Op_Real_Estate_SoleSeparate_Claim5=='Yes'){ echo "checked"; } ?>> Yes</label>
                                        <label><input type="radio" id="Op_Real_Estate_SoleSeparate_Claim5_No" name="Op_Real_Estate_SoleSeparate_Claim5" value="No" data-onload="getInitialPartyClaimSoleSeparate(this, '5', 'Op');" onchange="getPartyClaimSoleSeparate(this, '5', 'Op');" <?php if(isset($drrealestate->Op_Real_Estate_SoleSeparate_Claim5) && $drrealestate->Op_Real_Estate_SoleSeparate_Claim5=='No'){ echo "checked"; } ?>> No</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6" id="Op_Real_Estate_SoleSeparate_Party5_Div" style="display: none;">
                                    <label>Who claims to own this Real Estate?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Op_Real_Estate_SoleSeparate_Party5_Client" name="Op_Real_Estate_SoleSeparate_Party5" value="{{$client_name}}" <?php if(isset($drrealestate->Op_Real_Estate_SoleSeparate_Party5) && $drrealestate->Op_Real_Estate_SoleSeparate_Party5==$client_name){ echo "checked"; } ?>> {{$client_name}}</label>
                                        <label><input type="radio" id="Op_Real_Estate_SoleSeparate_Party5_Op" name="Op_Real_Estate_SoleSeparate_Party5" value="{{$opponent_name}}" <?php if(isset($drrealestate->Op_Real_Estate_SoleSeparate_Party5) && $drrealestate->Op_Real_Estate_SoleSeparate_Party5==$opponent_name){ echo "checked"; } ?>> {{$opponent_name}}</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6" id="Op_Real_Estate_SoleSeparate_Grounds5_Div" style="display: none;">
                                    <label for="Op_Real_Estate_SoleSeparate_Grounds5">Why does this person own this Real Estate solely and separately?</label>
                                    <input id="Op_Real_Estate_SoleSeparate_Grounds5" type="text" class="form-control 5_Op_realestate_inputs" name="Op_Real_Estate_SoleSeparate_Grounds5" value="<?php if(isset($drrealestate->Op_Real_Estate_SoleSeparate_Grounds5)){ echo $drrealestate->Op_Real_Estate_SoleSeparate_Grounds5; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>How will this Real Estate value be distributed between the parties?</label>
                                    <div class="w-100 dataInput">
                                        <label><input type="radio" id="Op_Real_Estate_Disposition_Method5_Liquidate/Split_Net_Value" name="Op_Real_Estate_Disposition_Method5" value="Liquidate/Split Net Value" data-onload="getInitialDipositionMethod(this, '5', 'Op');" onchange="getDipositionMethod(this, '5', 'Op');" <?php if(isset($drrealestate->Op_Real_Estate_Disposition_Method5) && $drrealestate->Op_Real_Estate_Disposition_Method5=='Liquidate/Split Net Value'){ echo "checked"; } ?>> Liquidate/Split Net Value</label>
                                        <label><input type="radio" id="Op_Real_Estate_Disposition_Method5_Fixed_Buyout_Refinance" name="Op_Real_Estate_Disposition_Method5" value="Fixed Buyout/Refinance" data-onload="getInitialDipositionMethod(this, '5', 'Op');" onchange="getDipositionMethod(this, '5', 'Op');" <?php if(isset($drrealestate->Op_Real_Estate_Disposition_Method5) && $drrealestate->Op_Real_Estate_Disposition_Method5=='Fixed Buyout/Refinance'){ echo "checked"; } ?>> Fixed Buyout/Refinance</label>
                                    </div>
                                </div>
                                <!-- slider tool -->
                                <div class="form-group col-sm-6 m-auto 5_Op_Slider_Tool slider-tool-main">
                                    <div class="row">
                                        <div class="col">{{$client_name}}</div>
                                        <div class="col text-right">{{$opponent_name}}</div>
                                    </div>
                                    <input id="5_Op_balance_range_selector" type="range" class="form-control slider-tool-input 5_Op_balance_range_selector" name="" value="<?php if(isset($drrealestate->Op_Real_Estate_Percent_Marital_Equity_to_Op5)){ echo $drrealestate->Op_Real_Estate_Percent_Marital_Equity_to_Op5; } ?>" min="0.00" step="0.01" max="100" onchange="updateBalanceInput(this.value, '5', 'Op');">
                                </div>
                                <div class="form-group col-sm-6 m-auto 5_Op_Slider_Tool slider-tool-main">
                                    <div class="row justify-content-between">
                                        <div class="col selectorTool">
                                            <div class="left-col">
                                                <div class="client-info 5_Op_clientpercentage_div clientpercentage_div">
                                                    <?php if(isset($drrealestate->Op_Real_Estate_Percent_Marital_Equity_to_Client5)){ echo $drrealestate->Op_Real_Estate_Percent_Marital_Equity_to_Client5; } else {
                                                        echo '50.00';
                                                    } ?>%
                                                </div>
                                                <div class="client-info 5_Op_clientamount_div clientamount_div" style="clear: both;">
                                                    $<?php if(isset($drrealestate->Op_Real_Estate_Estimated_Value_to_Client5)){ echo $drrealestate->Op_Real_Estate_Estimated_Value_to_Client5; } else {
                                                        echo '0.00';
                                                    } ?>
                                                </div>
                                            </div>
                                            <label>To {{$client_name}}</label>
                                        </div>                                       
                                        <div class="col selectorTool selectorToolRight">
                                            <label>To {{$opponent_name}}</label>
                                            <div class="left-col right-col">
                                                <div class="client-info 5_Op_opponentpercentage_div opponentpercentage_div">
                                                    <?php if(isset($drrealestate->Op_Real_Estate_Percent_Marital_Equity_to_Op5)){ echo $drrealestate->Op_Real_Estate_Percent_Marital_Equity_to_Op5; } else {
                                                        echo '50.00';
                                                    } ?>%
                                                </div>
                                                <div class="client-info 5_Op_opponentamount_div opponentamount_div" style="clear: both;">
                                                    $<?php if(isset($drrealestate->Op_Real_Estate_Estimated_Value_to_Op5)){ echo $drrealestate->Op_Real_Estate_Estimated_Value_to_Op5; } else {
                                                        echo '0.00';
                                                    } ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 m-auto 5_Op_Slider_Tool slider-tool-main">
                                    <label></label>
                                    <div class="w-100">
                                        <label><input type="radio" id="5_Op_Real_Estate_Estimated_Value_Select" name="5_Op_Real_Estate_Estimated_Value_Select_Reset" class="Real_Estate_Estimated_Value_Select_Reset" value="Save"> Save this Distribution of Real Estate #5</label>
                                        <label><input type="radio" id="5_Op_Real_Estate_Estimated_Value_Reset" name="5_Op_Real_Estate_Estimated_Value_Select_Reset" class="Real_Estate_Estimated_Value_Select_Reset" value="Reset" onclick="resetBalanceInput(this, '5', 'Op');"> Reset to Default (50%)</label>
                                    </div>
                                </div>

                                <div class="form-group col-sm-6 Op_Real_Estate_Paying_Party5_Inputs_Div" style="display: none;">
                                    <label>Op Real Estate Paying Party5</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Op_Real_Estate_Paying_Party5_Client" name="Op_Real_Estate_Paying_Party5" value="{{$client_name}}" data-onload="getInitialRealEstatePayingParty(this, '5', 'Op');" onchange="getRealEstatePayingParty(this, '5', 'Op');" <?php if(isset($drrealestate->Op_Real_Estate_Paying_Party5) && $drrealestate->Op_Real_Estate_Paying_Party5==$client_name){ echo "checked"; } ?>> {{$client_name}}</label>
                                        <label><input type="radio" id="Op_Real_Estate_Paying_Party5_Op" name="Op_Real_Estate_Paying_Party5" value="{{$opponent_name}}" data-onload="getInitialRealEstatePayingParty(this, '5', 'Op');" onchange="getRealEstatePayingParty(this, '5', 'Op');" <?php if(isset($drrealestate->Op_Real_Estate_Paying_Party5) && $drrealestate->Op_Real_Estate_Paying_Party5==$opponent_name){ echo "checked"; } ?>> {{$opponent_name}}</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 Op_Real_Estate_Paying_Party5_Inputs_Div" style="display: none;">
                                    <label>{{$client_name}} Real Estate Equity Percent</label>
                                    <input id="Op_Real_Estate_Percent_Marital_Equity_to_Client5" type="number" class="form-control 5_Op_clientpercentage_input clientpercentage_input" name="Op_Real_Estate_Percent_Marital_Equity_to_Client5" value="<?php if(isset($drrealestate->Op_Real_Estate_Percent_Marital_Equity_to_Client5)){ echo $drrealestate->Op_Real_Estate_Percent_Marital_Equity_to_Client5; } ?>" min="0.00" step="0.01" max="100" readonly="">
                                </div>
                                <div class="form-group col-sm-6 Op_Real_Estate_Paying_Party5_Inputs_Div" style="display: none;">
                                    <label>How much is to be paid to {{$client_name}}?</label>
                                    <input id="Op_Real_Estate_Estimated_Value_to_Client5" type="number" class="form-control 5_Op_clientamount_input clientamount_input" name="Op_Real_Estate_Estimated_Value_to_Client5" value="<?php if(isset($drrealestate->Op_Real_Estate_Estimated_Value_to_Client5)){ echo $drrealestate->Op_Real_Estate_Estimated_Value_to_Client5; } ?>" min="0.00" step="0.01" max="999999.99" readonly="" onchange="getEstimatedValueClient(this, '5', 'Op');" onkeyup="getEstimatedValueClient(this, '5', 'Op');">
                                </div>
                                <div class="form-group col-sm-6 Op_Real_Estate_Paying_Party5_Inputs_Div" style="display: none;">
                                    <label>{{$opponent_name}} Real Estate Equity Percent</label>
                                    <input id="Op_Real_Estate_Percent_Marital_Equity_to_Op5" type="number" class="form-control 5_Op_opponentpercentage_input opponentpercentage_input" name="Op_Real_Estate_Percent_Marital_Equity_to_Op5" value="<?php if(isset($drrealestate->Op_Real_Estate_Percent_Marital_Equity_to_Op5)){ echo $drrealestate->Op_Real_Estate_Percent_Marital_Equity_to_Op5; } ?>" min="0.00" step="0.01" max="100" readonly="">
                                </div>
                                <div class="form-group col-sm-6 Op_Real_Estate_Paying_Party5_Inputs_Div" style="display: none;">
                                    <label>How much is to be paid to {{$opponent_name}}?</label>
                                    <input id="Op_Real_Estate_Estimated_Value_to_Op5" type="number" class="form-control 5_Op_opponentamount_input opponentamount_input" name="Op_Real_Estate_Estimated_Value_to_Op5" value="<?php if(isset($drrealestate->Op_Real_Estate_Estimated_Value_to_Op5)){ echo $drrealestate->Op_Real_Estate_Estimated_Value_to_Op5; } ?>" min="0.00" step="0.01" max="999999.99" readonly="" onchange="getEstimatedValueOp(this, '5', 'Op');" onkeyup="getEstimatedValueOp(this, '5', 'Op');">
                                </div>
                                <!-- end of slider tool -->
                            </div>
                        </div>
                        <!-- End of Opponent Real Estate Info Section -->
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

    // show/hide this interview part based on Any Real Estate Input 
    function getAnyRealEstate(vehicle){
        if(vehicle.checked){
            $('#Num_Joint_Real_Estate_Properties, #Num_Client_Real_Estate_Properties, #Num_Op_Real_Estate_Properties').val('0');
            $('.num_Joint_realestate, .num_Client_realestate, .num_Op_realestate').show();
        } else {
            $('.num_Joint_realestate, .num_Client_realestate, .num_Op_realestate').hide();
            $('#Num_Joint_Real_Estate_Properties, #Num_Client_Real_Estate_Properties, #Num_Op_Real_Estate_Properties').val('0');
            $('.Joint_realestate_section input, .Client_realestate_section input, .Op_realestate_section input').prop('required',false);
            $('.1_Joint_realestate_section, .2_Joint_realestate_section, .3_Joint_realestate_section, .4_Joint_realestate_section, .5_Joint_realestate_section').hide();
            $('.1_Client_realestate_section, .2_Client_realestate_section, .3_Client_realestate_section, .4_Client_realestate_section, .5_Client_realestate_section').hide();
            $('.1_Op_realestate_section, .2_Op_realestate_section, .3_Op_realestate_section, .4_Op_realestate_section, .5_Op_realestate_section').hide();
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

                            var slctd_city=$('#'+ziptype+'_Real_Estate_Institution_City'+zipinputnum+'_Value').val();
                            if(slctd_city){
                                $('.'+zipclass+'_city_select option[value="'+slctd_city+'"]').attr('selected','selected');
                            }

                            var slctd_state=$('#'+ziptype+'_Real_Estate_Institution_State'+zipinputnum+'_Value').val();
                            if(slctd_state){
                                $('.'+zipclass+'_state_select option[value="'+slctd_state+'"]').attr('selected','selected');
                            }
                            $('.'+zipclass+'_no-state-county-found').hide();
                        }
                    }
                });        
            }

        }

    // show/hide inputs based on Rental Property Input on load
    function getInitialRentalProperty(claim, claimnum, claimtype){
        if(claim.value=='No' && claim.checked){
            $('#'+claimtype+'_Real_Estate_Yearly_Net_Rental_Income'+claimnum+'').val('0.00');
            $('#'+claimtype+'_Real_Estate_Client_Share_Rental'+claimnum+'').val('0.00');
            $('#'+claimtype+'_Real_Estate_Op_Share_Rental'+claimnum+'').val('0.00');
            $('#'+claimtype+'_Real_Estate_Yearly_Net_Rental_Income'+claimnum+', #'+claimtype+'_Real_Estate_Client_Share_Rental'+claimnum+', #'+claimtype+'_Real_Estate_Op_Share_Rental'+claimnum+'' ).prop('readonly', true);
        } else {
            $('#'+claimtype+'_Real_Estate_Yearly_Net_Rental_Income'+claimnum+', #'+claimtype+'_Real_Estate_Client_Share_Rental'+claimnum+', #'+claimtype+'_Real_Estate_Op_Share_Rental'+claimnum+'' ).prop('readonly', false);
        }
    }

    // show/hide inputs based on Rental Property Input
    function getRentalProperty(claim, claimnum, claimtype){
        if(claim.value=='No'){
            // $('.'+claimtype+'_Real_Estate_Rental'+claimnum+'_Input_Div').hide();
            $('#'+claimtype+'_Real_Estate_Yearly_Net_Rental_Income'+claimnum+'').val('0.00');
            $('#'+claimtype+'_Real_Estate_Client_Share_Rental'+claimnum+'').val('0.00');
            $('#'+claimtype+'_Real_Estate_Op_Share_Rental'+claimnum+'').val('0.00');
            $('#'+claimtype+'_Real_Estate_Yearly_Net_Rental_Income'+claimnum+', #'+claimtype+'_Real_Estate_Client_Share_Rental'+claimnum+', #'+claimtype+'_Real_Estate_Op_Share_Rental'+claimnum+'' ).prop('readonly', true);
        } else {
            // $('.'+claimtype+'_Real_Estate_Rental'+claimnum+'_Input_Div').show();
            $('#'+claimtype+'_Real_Estate_Yearly_Net_Rental_Income'+claimnum+', #'+claimtype+'_Real_Estate_Client_Share_Rental'+claimnum+', #'+claimtype+'_Real_Estate_Op_Share_Rental'+claimnum+'' ).prop('readonly', false);
        }
    }

    function getYearlyNetRentalIncome(party, partynum, partytype){
        // var current_val=$('#'+partytype+'_Real_Estate_Current_Value'+partynum+'').val();
        var current_val=$('#'+partytype+'_Real_Estate_MaritalEquity'+partynum+'').val();
        if(current_val){
            current_val=parseFloat(current_val).toFixed(2);
            var client_percentage_val=$('#'+partytype+'_Real_Estate_Percent_Marital_Equity_to_Client'+partynum+'').val();
            client_percentage_val=parseFloat(client_percentage_val/100);
            var net_rental_income=$('#'+partytype+'_Real_Estate_Yearly_Net_Rental_Income'+partynum+'').val();
            net_rental_income=parseFloat(net_rental_income).toFixed(2);
            var client_share_rental=client_percentage_val*net_rental_income;
            client_share_rental=parseFloat(client_share_rental).toFixed(2);
            $('#'+partytype+'_Real_Estate_Client_Share_Rental'+partynum+'').val(client_share_rental);
            var op_share_rental = (net_rental_income)-(client_share_rental);
            op_share_rental=parseFloat(op_share_rental).toFixed(2);
            $('#'+partytype+'_Real_Estate_Op_Share_Rental'+partynum+'').val(op_share_rental);
        }
    }
    
    // show/hide inputs based on Rental Property Input
    function getInitialPartyClaimSoleSeparate(claim, claimnum, claimtype){
        if(claim.value=='No' && claim.checked){
            $('#'+claimtype+'_Real_Estate_SoleSeparate_Party'+claimnum+'_Div').hide();
            $('#'+claimtype+'_Real_Estate_SoleSeparate_Grounds'+claimnum+'_Div').hide();
            $('#'+claimtype+'_Real_Estate_SoleSeparate_Grounds'+claimnum+'').val('');
            $('#'+claimtype+'_Real_Estate_SoleSeparate_Party'+claimnum+'').prop('checked', false);
            $('.'+claimnum+'_'+claimtype+'_Slider_Tool').show();
            $('.'+claimtype+'_Real_Estate_Paying_Party'+claimnum+'_Inputs_Div').hide();
            $('.'+claimtype+'_Real_Estate_Paying_Party'+claimnum+'_Inputs_Div input[type=number]').prop('readonly', true);
        } 
        if(claim.value=='Yes' && claim.checked){
            $('#'+claimtype+'_Real_Estate_SoleSeparate_Party'+claimnum+'_Div').show();
            $('#'+claimtype+'_Real_Estate_SoleSeparate_Grounds'+claimnum+'_Div').show();
            $('.'+claimnum+'_'+claimtype+'_Slider_Tool').hide();
            $('.'+claimtype+'_Real_Estate_Paying_Party'+claimnum+'_Inputs_Div').show();
            $('.'+claimtype+'_Real_Estate_Paying_Party'+claimnum+'_Inputs_Div input[type=number]').prop('readonly', true);
        }
    }

    // show/hide inputs based on Claim
    function getPartyClaimSoleSeparate(claim, claimnum, claimtype){
        if(claim.value=='No'){
            $('#'+claimtype+'_Real_Estate_SoleSeparate_Party'+claimnum+'_Div').hide();
            $('#'+claimtype+'_Real_Estate_SoleSeparate_Grounds'+claimnum+'_Div').hide();
            $('#'+claimtype+'_Real_Estate_SoleSeparate_Grounds'+claimnum+'').val('');
            $('#'+claimtype+'_Real_Estate_SoleSeparate_Party'+claimnum+'').prop('checked', false);
            $('.'+claimnum+'_'+claimtype+'_Slider_Tool').show();
            $('.'+claimtype+'_Real_Estate_Paying_Party'+claimnum+'_Inputs_Div').hide();
            $('.'+claimtype+'_Real_Estate_Paying_Party'+claimnum+'_Inputs_Div input[type=number]').prop('readonly', true);
        } else {
            $('#'+claimtype+'_Real_Estate_SoleSeparate_Party'+claimnum+'_Div').show();
            $('#'+claimtype+'_Real_Estate_SoleSeparate_Grounds'+claimnum+'_Div').show();
            $('.'+claimnum+'_'+claimtype+'_Slider_Tool').hide();
            $('.'+claimtype+'_Real_Estate_Paying_Party'+claimnum+'_Inputs_Div').show();
            $('.'+claimtype+'_Real_Estate_Paying_Party'+claimnum+'_Inputs_Div input[type=number]').prop('readonly', true);
        }
    }

    function getInitialDipositionMethod(claim, claimnum, claimtype){
        if(claim.value=='Fixed Buyout/Refinance' && claim.checked){
            $('.'+claimnum+'_'+claimtype+'_Slider_Tool').hide();
            $('.'+claimtype+'_Real_Estate_Paying_Party'+claimnum+'_Inputs_Div').show();
        } else {
            $('.'+claimnum+'_'+claimtype+'_Slider_Tool').show();
            $('.'+claimtype+'_Real_Estate_Paying_Party'+claimnum+'_Inputs_Div').hide();
        }
    }

    // Caclulations based on diposition method
    function getDipositionMethod(claim, claimnum, claimtype){
        if(claim.value=='Fixed Buyout/Refinance'){
            $('.'+claimnum+'_'+claimtype+'_Slider_Tool').hide();
            $('.'+claimtype+'_Real_Estate_Paying_Party'+claimnum+'_Inputs_Div').show();
            $('.'+claimtype+'_Real_Estate_Paying_Party'+claimnum+'_Inputs_Div input[type=number]').prop('readonly', true);
            $('.'+claimtype+'_Real_Estate_Paying_Party'+claimnum+'_Inputs_Div input[type=radio]').prop('checked', false);
            // var current_val=$('#'+claimtype+'_Real_Estate_Current_Value'+claimnum+'').val();
            var current_val=$('#'+claimtype+'_Real_Estate_MaritalEquity'+claimnum+'').val();
            if(current_val){
                current_val=parseFloat(current_val).toFixed(2);
                var op_val=(current_val/2);
                op_val=parseFloat(op_val).toFixed(2);
                var client_val=(current_val)-(op_val);
                client_val=parseFloat(client_val).toFixed(2);
                $('#'+claimtype+'_Real_Estate_Estimated_Value_to_Client'+claimnum+'').val(client_val);
                $('#'+claimtype+'_Real_Estate_Estimated_Value_to_Op'+claimnum+'').val(op_val);
                var client_percentage=(client_val/current_val)*(100).toFixed(2);
                client_percentage=parseFloat(client_percentage).toFixed(2);
                var op_percentage=(100-client_percentage).toFixed(2);
                op_percentage=parseFloat(op_percentage).toFixed(2);
                $('#'+claimtype+'_Real_Estate_Percent_Marital_Equity_to_Client'+claimnum+'').val(client_percentage);
                $('#'+claimtype+'_Real_Estate_Percent_Marital_Equity_to_Op'+claimnum+'').val(op_percentage);
                $('.'+claimnum+'_'+claimtype+'_clientpercentage_div').text('50.00%');
                $('.'+claimnum+'_'+claimtype+'_opponentpercentage_div').text('50.00%');
                $('.'+claimnum+'_'+claimtype+'_clientamount_div').text(formatter.format(client_val));
                $('.'+claimnum+'_'+claimtype+'_opponentamount_div').text(formatter.format(op_val));
            }else {
                $('#'+claimtype+'_Real_Estate_Estimated_Value_to_Client'+claimnum+'').val('0.00');
                $('#'+claimtype+'_Real_Estate_Estimated_Value_to_Op'+claimnum+'').val('0.00');
                $('#'+claimtype+'_Real_Estate_Percent_Marital_Equity_to_Client'+claimnum+'').val('0.00');
                $('#'+claimtype+'_Real_Estate_Percent_Marital_Equity_to_Op'+claimnum+'').val('0.00');
                $('.'+claimnum+'_'+claimtype+'_clientpercentage_div').text('50.00%');
                $('.'+claimnum+'_'+claimtype+'_opponentpercentage_div').text('50.00%');
                $('.'+claimnum+'_'+claimtype+'_clientamount_div').text('0.00');
                $('.'+claimnum+'_'+claimtype+'_opponentamount_div').text('0.00');
            }

        } else {
            $('.'+claimnum+'_'+claimtype+'_Slider_Tool').show();
            $('.'+claimtype+'_Real_Estate_Paying_Party'+claimnum+'_Inputs_Div').hide();
            $('.'+claimtype+'_Real_Estate_Paying_Party'+claimnum+'_Inputs_Div input[type=number]').prop('readonly', true);
            $('.'+claimtype+'_Real_Estate_Paying_Party'+claimnum+'_Inputs_Div input[type=radio]').prop('checked', false);
            // var current_val=$('#'+claimtype+'_Real_Estate_Current_Value'+claimnum+'').val();
            var current_val=$('#'+claimtype+'_Real_Estate_MaritalEquity'+claimnum+'').val();
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

        // Calculation for new fields
        var client_percentage_val=$('#'+claimtype+'_Real_Estate_Percent_Marital_Equity_to_Client'+claimnum+'').val();
        client_percentage_val=parseFloat(client_percentage_val/100);
        var net_rental_income=$('#'+claimtype+'_Real_Estate_Yearly_Net_Rental_Income'+claimnum+'').val();
        net_rental_income=parseFloat(net_rental_income).toFixed(2);
        var client_share_rental=client_percentage_val*net_rental_income;
        client_share_rental=parseFloat(client_share_rental).toFixed(2);
        $('#'+claimtype+'_Real_Estate_Client_Share_Rental'+claimnum+'').val(client_share_rental);
        var op_share_rental = (net_rental_income)-(client_share_rental);
        op_share_rental=parseFloat(op_share_rental).toFixed(2);
        $('#'+claimtype+'_Real_Estate_Op_Share_Rental'+claimnum+'').val(op_share_rental);
    }

    function getInitialRealEstatePayingParty(party, partynum, partytype){
        if(party.id==''+partytype+'_Real_Estate_Paying_Party'+partynum+'_Client' && party.checked){
            $('.'+partytype+'_Real_Estate_Paying_Party'+partynum+'_Inputs_Div').show();
            $('#'+partytype+'_Real_Estate_Estimated_Value_to_Op'+partynum+'').prop('readonly', false);
            $('#'+partytype+'_Real_Estate_Estimated_Value_to_Client'+partynum+'').prop('readonly', true);
        }  

        if(party.id==''+partytype+'_Real_Estate_Paying_Party'+partynum+'_Op' && party.checked){
            $('.'+partytype+'_Real_Estate_Paying_Party'+partynum+'_Inputs_Div').show();
            $('#'+partytype+'_Real_Estate_Estimated_Value_to_Client'+partynum+'').prop('readonly', false);
            $('#'+partytype+'_Real_Estate_Estimated_Value_to_Op'+partynum+'').prop('readonly', true);
        }
    }

    // show/hide inputs based on Real Estate Paying Party
    function getRealEstatePayingParty(party, partynum, partytype){
        if(party.id==''+partytype+'_Real_Estate_Paying_Party'+partynum+'_Client'){
            $('.'+partytype+'_Real_Estate_Paying_Party'+partynum+'_Inputs_Div').show();
            $('#'+partytype+'_Real_Estate_Estimated_Value_to_Op'+partynum+'').prop('readonly', false);
            $('#'+partytype+'_Real_Estate_Estimated_Value_to_Client'+partynum+'').prop('readonly', true);
        } else {
            $('.'+partytype+'_Real_Estate_Paying_Party'+partynum+'_Inputs_Div').show();
            $('#'+partytype+'_Real_Estate_Estimated_Value_to_Client'+partynum+'').prop('readonly', false);
            $('#'+partytype+'_Real_Estate_Estimated_Value_to_Op'+partynum+'').prop('readonly', true);
        }
    }

    // calculations based on Estimated Value of Opponent
    function getEstimatedValueOp(party, partynum, partytype){
        // var current_val=$('#'+partytype+'_Real_Estate_Current_Value'+partynum+'').val();
        var current_val=$('#'+partytype+'_Real_Estate_MaritalEquity'+partynum+'').val();
        if(current_val){
            current_val=parseFloat(current_val).toFixed(2);
            var op_val=party.value;
            op_val=parseFloat(op_val).toFixed(2);
            var client_val=(current_val)-(op_val);
            client_val=parseFloat(client_val).toFixed(2);
            $('#'+partytype+'_Real_Estate_Estimated_Value_to_Client'+partynum+'').val(client_val);
            var client_percentage=(client_val/current_val)*(100).toFixed(2);
            client_percentage=parseFloat(client_percentage).toFixed(2);
            var op_percentage=(100-client_percentage).toFixed(2);
            op_percentage=parseFloat(op_percentage).toFixed(2);
            $('#'+partytype+'_Real_Estate_Percent_Marital_Equity_to_Client'+partynum+'').val(client_percentage);
            $('#'+partytype+'_Real_Estate_Percent_Marital_Equity_to_Op'+partynum+'').val(op_percentage);

            // Calculation for new fields
            var client_percentage_val=$('#'+partytype+'_Real_Estate_Percent_Marital_Equity_to_Client'+partynum+'').val();
            client_percentage_val=parseFloat(client_percentage_val/100);
            var net_rental_income=$('#'+partytype+'_Real_Estate_Yearly_Net_Rental_Income'+partynum+'').val();
            net_rental_income=parseFloat(net_rental_income).toFixed(2);
            var client_share_rental=client_percentage_val*net_rental_income;
            client_share_rental=parseFloat(client_share_rental).toFixed(2);
            $('#'+partytype+'_Real_Estate_Client_Share_Rental'+partynum+'').val(client_share_rental);
            var op_share_rental = (net_rental_income)-(client_share_rental);
            op_share_rental=parseFloat(op_share_rental).toFixed(2);
            $('#'+partytype+'_Real_Estate_Op_Share_Rental'+partynum+'').val(op_share_rental);
        }
    }

    // calculations based on Estimated Value of Client
    function getEstimatedValueClient(party, partynum, partytype){
        // var current_val=$('#'+partytype+'_Real_Estate_Current_Value'+partynum+'').val();
        var current_val=$('#'+partytype+'_Real_Estate_MaritalEquity'+partynum+'').val();
        if(current_val){
            current_val=parseFloat(current_val).toFixed(2);
            var client_val=party.value;
            client_val=parseFloat(client_val).toFixed(2);
            var op_val=(current_val)-(client_val);
            op_val=parseFloat(op_val).toFixed(2);
            $('#'+partytype+'_Real_Estate_Estimated_Value_to_Op'+partynum+'').val(op_val);
            var client_percentage=(client_val/current_val)*(100).toFixed(2);
            client_percentage=parseFloat(client_percentage).toFixed(2);
            var op_percentage=(100-client_percentage).toFixed(2);
            op_percentage=parseFloat(op_percentage).toFixed(2);
            $('#'+partytype+'_Real_Estate_Percent_Marital_Equity_to_Client'+partynum+'').val(client_percentage);
            $('#'+partytype+'_Real_Estate_Percent_Marital_Equity_to_Op'+partynum+'').val(op_percentage);

            // Calculation for new fields
            var client_percentage_val=$('#'+partytype+'_Real_Estate_Percent_Marital_Equity_to_Client'+partynum+'').val();
            client_percentage_val=parseFloat(client_percentage_val/100);
            var net_rental_income=$('#'+partytype+'_Real_Estate_Yearly_Net_Rental_Income'+partynum+'').val();
            net_rental_income=parseFloat(net_rental_income).toFixed(2);
            var client_share_rental=client_percentage_val*net_rental_income;
            client_share_rental=parseFloat(client_share_rental).toFixed(2);
            $('#'+partytype+'_Real_Estate_Client_Share_Rental'+partynum+'').val(client_share_rental);
            var op_share_rental = (net_rental_income)-(client_share_rental);
            op_share_rental=parseFloat(op_share_rental).toFixed(2);
            $('#'+partytype+'_Real_Estate_Op_Share_Rental'+partynum+'').val(op_share_rental);
        }
    }

    // calculations based on Joint Section Current balance
    function getJointCurrentValue(balance, balancenum, balancetype){
        var balanceclass=balancenum+'_'+balancetype;

        // new calculations
        var current_balance=$('#'+balancetype+'_Real_Estate_Current_Value'+balancenum+'').val();
        var first_mortage_balance=$('#'+balancetype+'_Real_Estate_First_Mortgage_Balance'+balancenum+'').val();
        var second_mortage_loc_balance=$('#'+balancetype+'_Real_Estate_Second_Mortgage_LOC_Balance'+balancenum+'').val();
        var current_balance=parseFloat(current_balance).toFixed(2);
        var first_mortage_balance=parseFloat(first_mortage_balance).toFixed(2);
        var second_mortage_loc_balance=parseFloat(second_mortage_loc_balance).toFixed(2);

        var marital_equity=(current_balance-first_mortage_balance-second_mortage_loc_balance);
        var marital_equity=parseFloat(marital_equity).toFixed(2);
        $('#'+balancetype+'_Real_Estate_MaritalEquity'+balancenum+'').val(marital_equity);

        // old calculations
        $('.'+balanceclass+'_balance_range_selector, .'+balanceclass+'_opponentpercentage_input, .'+balanceclass+'_clientpercentage_input').val('50.00');
        $('.'+balanceclass+'_opponentpercentage_div, .'+balanceclass+'_clientpercentage_div').text('50.00%');
        var current_balance=parseFloat(marital_equity).toFixed(2);
        var client_balance_amount=current_balance/2;
        var opponent_balance_amount=current_balance/2;
        client_balance_amount=parseFloat(client_balance_amount).toFixed(2);
        opponent_balance_amount=parseFloat(opponent_balance_amount).toFixed(2);
        $('.'+balanceclass+'_clientamount_input').val(client_balance_amount);
        $('.'+balanceclass+'_opponentamount_input').val(opponent_balance_amount);
        $('.'+balanceclass+'_clientamount_div').text(formatter.format(client_balance_amount));
        $('.'+balanceclass+'_opponentamount_div').text(formatter.format(opponent_balance_amount));

        // Calculation for new fields
        var client_percentage_val=$('#'+balancetype+'_Real_Estate_Percent_Marital_Equity_to_Client'+balancenum+'').val();
        client_percentage_val=parseFloat(client_percentage_val/100);
        var net_rental_income=$('#'+balancetype+'_Real_Estate_Yearly_Net_Rental_Income'+balancenum+'').val();
        net_rental_income=parseFloat(net_rental_income).toFixed(2);
        var client_share_rental=client_percentage_val*net_rental_income;
        client_share_rental=parseFloat(client_share_rental).toFixed(2);
        $('#'+balancetype+'_Real_Estate_Client_Share_Rental'+balancenum+'').val(client_share_rental);
        var op_share_rental = (net_rental_income)-(client_share_rental);
        op_share_rental=parseFloat(op_share_rental).toFixed(2);
        $('#'+balancetype+'_Real_Estate_Op_Share_Rental'+balancenum+'').val(op_share_rental);

        // // new calculations
        // var current_balance=$('#'+balancetype+'_Real_Estate_Current_Value'+balancenum+'').val();
        // var first_mortage_balance=$('#'+balancetype+'_Real_Estate_First_Mortgage_Balance'+balancenum+'').val();
        // var second_mortage_loc_balance=$('#'+balancetype+'_Real_Estate_Second_Mortgage_LOC_Balance'+balancenum+'').val();
        // var current_balance=parseFloat(current_balance).toFixed(2);
        // var first_mortage_balance=parseFloat(first_mortage_balance).toFixed(2);
        // var second_mortage_loc_balance=parseFloat(second_mortage_loc_balance).toFixed(2);

        // var marital_equity=(current_balance-first_mortage_balance-second_mortage_loc_balance);
        // var marital_equity=parseFloat(marital_equity).toFixed(2);
        // $('#'+balancetype+'_Real_Estate_MaritalEquity'+balancenum+'').val(marital_equity);
    }

    // new calculations
    function getMaritalEquity(balance, balancenum, balancetype){
        var balanceclass=balancenum+'_'+balancetype;
        var current_balance=$('#'+balancetype+'_Real_Estate_Current_Value'+balancenum+'').val();
        var first_mortage_balance=$('#'+balancetype+'_Real_Estate_First_Mortgage_Balance'+balancenum+'').val();
        var second_mortage_loc_balance=$('#'+balancetype+'_Real_Estate_Second_Mortgage_LOC_Balance'+balancenum+'').val();
        var current_balance=parseFloat(current_balance).toFixed(2);
        var first_mortage_balance=parseFloat(first_mortage_balance).toFixed(2);
        var second_mortage_loc_balance=parseFloat(second_mortage_loc_balance).toFixed(2);

        var marital_equity=(current_balance-first_mortage_balance-second_mortage_loc_balance);
        var marital_equity=parseFloat(marital_equity).toFixed(2);
        $('#'+balancetype+'_Real_Estate_MaritalEquity'+balancenum+'').val(marital_equity);
    }

    // calculations based on Slider Change
    function updateBalanceInput(value, balancenum, balancetype){
        var sliderclass=balancenum+'_'+balancetype;
        if(value <= 100){
            var value=parseFloat(value).toFixed(2);
            // var joint_balance=$('#'+balancetype+'_Real_Estate_Current_Value'+balancenum+'').val();
            var joint_balance=$('#'+balancetype+'_Real_Estate_MaritalEquity'+balancenum+'').val();
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
            if(isNaN(client_balance_amount_new)) {
                client_balance_amount_new = 0.00;
            }
            if(isNaN(op_balance_amount_new)) {
                op_balance_amount_new = 0.00;
            }
            $('.'+sliderclass+'_opponentamount_input').val(op_balance_amount_new);
            $('.'+sliderclass+'_clientamount_input').val(client_balance_amount_new);
            $('.'+sliderclass+'_opponentamount_div').text(formatter.format(op_balance_amount_new));
            $('.'+sliderclass+'_clientamount_div').text(formatter.format(client_balance_amount_new));

            // Calculation for new fields
            var client_percentage_val=$('#'+balancetype+'_Real_Estate_Percent_Marital_Equity_to_Client'+balancenum+'').val();
            client_percentage_val=parseFloat(client_percentage_val/100);
            var net_rental_income=$('#'+balancetype+'_Real_Estate_Yearly_Net_Rental_Income'+balancenum+'').val();
            net_rental_income=parseFloat(net_rental_income).toFixed(2);
            var client_share_rental=client_percentage_val*net_rental_income;
            client_share_rental=parseFloat(client_share_rental).toFixed(2);
            $('#'+balancetype+'_Real_Estate_Client_Share_Rental'+balancenum+'').val(client_share_rental);
            var op_share_rental = (net_rental_income)-(client_share_rental);
            op_share_rental=parseFloat(op_share_rental).toFixed(2);
            $('#'+balancetype+'_Real_Estate_Op_Share_Rental'+balancenum+'').val(op_share_rental);
        }
    }

    // Reset Calculations to default
    function resetBalanceInput(value, balancenum, balancetype){
        var sliderclass=balancenum+'_'+balancetype;
        $('.'+sliderclass+'_balance_range_selector, .'+sliderclass+'_opponentpercentage_input, .'+sliderclass+'_clientpercentage_input').val('50.00');
        $('.'+sliderclass+'_opponentpercentage_div, .'+sliderclass+'_clientpercentage_div').text('50.00%');
        // var joint_balance=$('#'+balancetype+'_Real_Estate_Current_Value'+balancenum+'').val();
        var joint_balance=$('#'+balancetype+'_Real_Estate_MaritalEquity'+balancenum+'').val();
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

        // Calculation for new fields
        var client_percentage_val=$('#'+balancetype+'_Real_Estate_Percent_Marital_Equity_to_Client'+balancenum+'').val();
        client_percentage_val=parseFloat(client_percentage_val/100);
        var net_rental_income=$('#'+balancetype+'_Real_Estate_Yearly_Net_Rental_Income'+balancenum+'').val();
        net_rental_income=parseFloat(net_rental_income).toFixed(2);
        var client_share_rental=client_percentage_val*net_rental_income;
        client_share_rental=parseFloat(client_share_rental).toFixed(2);
        $('#'+balancetype+'_Real_Estate_Client_Share_Rental'+balancenum+'').val(client_share_rental);
        var op_share_rental = (net_rental_income)-(client_share_rental);
        op_share_rental=parseFloat(op_share_rental).toFixed(2);
        $('#'+balancetype+'_Real_Estate_Op_Share_Rental'+balancenum+'').val(op_share_rental);
    }

    // format amount to currency
    const formatter = new Intl.NumberFormat('en-US', {
        style: 'currency',
        currency: 'USD',
        minimumFractionDigits: 2
    });

    $(document).ready(function(){

        $('#dr_RealEstate').validate();
        $(window).keydown(function(event){
            if(event.keyCode == 13) {
              event.preventDefault();
              return false;
            }
        });

        $('[data-onload]').each(function(){
            eval($(this).data('onload'));
        });

        var any_realestate=$('#Any_Real_Estate');
        if(any_realestate.prop("checked") == true){
            $('.num_Joint_realestate, .num_Client_realestate, .num_Op_realestate').show();
        } else {
            $('.num_Joint_realestate, .num_Client_realestate, .num_Op_realestate').hide();
            $('#Num_Joint_Real_Estate_Properties, #Num_Client_Real_Estate_Properties, #Num_Op_Real_Estate_Properties').val('0');
            $('.Joint_realestate_section input, .Client_realestate_section input, .Op_realestate_section input').prop('required',false);
            $('.1_Joint_realestate_section, .2_Joint_realestate_section, .3_Joint_realestate_section, .4_Joint_realestate_section, .5_Joint_realestate_section').hide();
            $('.1_Client_realestate_section, .2_Client_realestate_section, .3_Client_realestate_section, .4_Client_realestate_section, .5_Client_realestate_section').hide();
            $('.1_Op_realestate_section, .2_Op_realestate_section, .3_Op_realestate_section, .4_Op_realestate_section, .5_Op_realestate_section').hide();
        }

        // on number of joint realestate input change
        $('.1_Joint_realestate_section, .2_Joint_realestate_section, .3_Joint_realestate_section, .4_Joint_realestate_section, .5_Joint_realestate_section').hide();
        if($('#Num_Joint_Real_Estate_Properties').val() > 0 &&  $('#Num_Joint_Real_Estate_Properties').val() <= 5 ){
            for (var i = 1; i <= $('#Num_Joint_Real_Estate_Properties').val(); i++) {
                $('.'+i+'_Joint_realestate_section').show();
                $('.'+i+'_Joint_realestate_section input').first().prop('required',true);
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
        var val=parseInt($('#Num_Joint_Real_Estate_Properties').val())+1;
        for (var i = val; i <= 5; i++) {
            $('.'+i+'_Joint_realestate_section input').prop('required',false);
            $('.'+i+'_Joint_realestate_section select option[value=""]').prop('selected','selected');
        }
        $('#Num_Joint_Real_Estate_Properties').on('change keyup', function(){
            $('.1_Joint_realestate_section, .2_Joint_realestate_section, .3_Joint_realestate_section, .4_Joint_realestate_section, .5_Joint_realestate_section').hide();
            if(this.value > 0 &&  this.value <= 5 ){
                for (var i = 1; i <= this.value; i++) {
                    $('.'+i+'_Joint_realestate_section').show();
                    $('.'+i+'_Joint_realestate_section input').first().prop('required',true);
                }
            }
            var val=parseInt(this.value)+1;
            for (var i = val; i <= 5; i++) {
                $('.'+i+'_Joint_realestate_section input').prop('required',false);
                $('.'+i+'_Joint_realestate_section select option[value=""]').prop('selected','selected');
            }
        });
        // on number of client realestate input change
        $('.1_Client_realestate_section, .2_Client_realestate_section, .3_Client_realestate_section, .4_Client_realestate_section, .5_Client_realestate_section').hide();
        if($('#Num_Client_Real_Estate_Properties').val() > 0 &&  $('#Num_Client_Real_Estate_Properties').val() <= 5 ){
            for (var i = 1; i <= $('#Num_Client_Real_Estate_Properties').val(); i++) {
                $('.'+i+'_Client_realestate_section').show();
                $('.'+i+'_Client_realestate_section input').first().prop('required',true);
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
        var val=parseInt($('#Num_Client_Real_Estate_Properties').val())+1;
        for (var i = val; i <= 5; i++) {
            $('.'+i+'_Client_realestate_section input').prop('required',false);
            $('.'+i+'_Client_realestate_section select option[value=""]').prop('selected','selected');
        }
        $('#Num_Client_Real_Estate_Properties').on('change keyup', function(){
            $('.1_Client_realestate_section, .2_Client_realestate_section, .3_Client_realestate_section, .4_Client_realestate_section, .5_Client_realestate_section').hide();
            if(this.value > 0 &&  this.value <= 5 ){
                for (var i = 1; i <= this.value; i++) {
                    $('.'+i+'_Client_realestate_section').show();
                    $('.'+i+'_Client_realestate_section input').first().prop('required',true);
                }
            }
            var val=parseInt(this.value)+1;
            for (var i = val; i <= 5; i++) {
                $('.'+i+'_Client_realestate_section input').prop('required',false);
                $('.'+i+'_Client_realestate_section select option[value=""]').prop('selected','selected');
            }
        });
        // on number of opponent realestate input change
        $('.1_Op_realestate_section, .2_Op_realestate_section, .3_Op_realestate_section, .4_Op_realestate_section, .5_Op_realestate_section').hide();
        if($('#Num_Op_Real_Estate_Properties').val() > 0 &&  $('#Num_Op_Real_Estate_Properties').val() <= 5 ){
            for (var i = 1; i <= $('#Num_Op_Real_Estate_Properties').val(); i++) {
                $('.'+i+'_Op_realestate_section').show();
                $('.'+i+'_Op_realestate_section input').first().prop('required',true);
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
        var val=parseInt($('#Num_Op_Real_Estate_Properties').val())+1;
        for (var i = val; i <= 5; i++) {
            $('.'+i+'_Op_realestate_section input').prop('required',false);
            $('.'+i+'_Op_realestate_section select option[value=""]').prop('selected','selected');
        }
        $('#Num_Op_Real_Estate_Properties').on('change keyup', function(){
            $('.1_Op_realestate_section, .2_Op_realestate_section, .3_Op_realestate_section, .4_Op_realestate_section, .5_Op_realestate_section').hide();
            if(this.value > 0 &&  this.value <= 5 ){
                for (var i = 1; i <= this.value; i++) {
                    $('.'+i+'_Op_realestate_section').show();
                    $('.'+i+'_Op_realestate_section input').first().prop('required',true);
                }
            }
            var val=parseInt(this.value)+1;
            for (var i = val; i <= 5; i++) {
                $('.'+i+'_Op_realestate_section input').prop('required',false);
                $('.'+i+'_Op_realestate_section select option[value=""]').prop('selected','selected');
            }
        });
    });
</script>   
@endsection