@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center dr_Pensions_main dr_Tables_main">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header"><strong>{{ __('Pensions Info') }}</strong>
                    <div class="pull-right">

                        <a class="btn btn-primary" href="{{ route('cases.family_law_interview_tabs',$case_data->id) }}"> Back</a>

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
                    <form role="form" id="dr_Pensions" method="POST" action="{{route('drpensions.store')}}" autocomplete="off">
                        @csrf
                        <input id="" type="hidden" class="form-control" name="case_id" value="{{$case_data->id}}">
                        <input id="month_diff" type="hidden" class="form-control" name="" value="">

                        <div class="form-row Any_Pension">
                            <div class="form-group col-sm-12">
                                <label></label>
                                <div class="w-100 dataInput">
                                     <label><input type="checkbox" id="Any_Pension" name="Any_Pension" value="1" onchange="getAnyPension(this);" <?php if(isset($drcaseoverview->Any_Pension) && $drcaseoverview->Any_Pension=='1'){ echo "checked"; } ?>> Check if Any Pensions of {{$client_name}} and/or {{$opponent_name}}?</label>
                                </div>
                            </div>
                        </div>

                        <div class="form-row Client_Op_Pension" style="display: none;">
                            <div class="col-sm-6">
                                <label for="Num_Client_Pensions">How many pensions does {{$client_name}} have or is contributing to?</label>
                                <input id="Num_Client_Pensions" type="number" class="form-control" name="Num_Client_Pensions" value="<?php if(isset($drcaseoverview->Num_Client_Pensions)){ echo $drcaseoverview->Num_Client_Pensions; } ?>" min="0" max="4"> 
                            </div>
                            <div class="col-sm-6">
                                <label for="Num_Op_Pensions">How many pensions does {{$opponent_name}} have or is contributing to?</label>
                                <input id="Num_Op_Pensions" type="number" class="form-control" name="Num_Op_Pensions" value="<?php if(isset($drcaseoverview->Num_Op_Pensions)){ echo $drcaseoverview->Num_Op_Pensions; } ?>" min="0" max="4"> 
                            </div>
                        </div>

                        <!-- Client Pensions Info Section -->
                        <div class="form-row Client_Pensions_section">
                            <div class="col-sm-12 mt-4 1_Client_Pensions_section" style="display: none;">
                                <h4 class="col-sm-12">{{$client_name}} Pension Info Section</h4>
                                <h5 class="col-sm-12">First Pension Info</h5>
                                <div class="form-group col-sm-6">
                                    <label>Pension is currently being paid out</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Client_Pension1_Is_Currently_Being_Paid_Out_Yes" name="Client_Pension1_Is_Currently_Being_Paid_Out" value="Yes"> Yes</label>
                                        <label><input type="radio" id="Client_Pension1_Is_Currently_Being_Paid_Out_No" name="Client_Pension1_Is_Currently_Being_Paid_Out" value="No" checked=""> No</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Pension1_Type">What type of pension?</label>
                                    <select id="Client_Pension1_Type" name="Client_Pension1_Type" class="form-control 1_Client_Pensions_select">
                                        <option value="">Select</option>
                                        <option value="Federal">Federal</option>
                                        <option value="State">State</option>
                                        <option value="Private">Private</option>
                                    </select>   
                                </div>
                                <div class="form-group col-sm-6">
                                    <p class="text-danger 1_Client_no-state-county-found" style="display: none;">No City, State, County found for this zipcode.</p>
                                    <label for="Client_Pension1_ZIP">Pension Institution Zip Code?</label>
                                    <input id="Client_Pension1_ZIP" type="text" class="form-control 1_Client_Pensions_inputs" name="Client_Pension1_ZIP" value="" onkeyup="getCityStateForZip(this, '1_Client');"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Pension1_Institution_Name">Name of Pension Institution?</label>
                                    <input id="Client_Pension1_Institution_Name" type="text" class="form-control 1_Client_Pensions_inputs" name="Client_Pension1_Institution_Name" value=""> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Pension1_Street_Address">Pension Institution Street Address?</label>
                                    <input id="Client_Pension1_Street_Address" type="text" class="form-control 1_Client_Pensions_inputs" name="Client_Pension1_Street_Address" value=""> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Pension1_City">Pension Institution City?</label>
                                    <select id="Client_Pension1_City" name="Client_Pension1_City" class="form-control 1_Client_city_select">
                                        <option value="">Choose City</option>
                                    </select>   
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Pension1_State">Pension Institution State?</label>
                                    <select id="Client_Pension1_State" name="Client_Pension1_State" class="form-control 1_Client_state_select">
                                        <option value="">Choose State</option>
                                    </select>   
                                </div>                                
                                <div class="form-group col-sm-6">
                                    <label for="Client_Pension1_Acct_Num">Account Number?</label>
                                    <input id="Client_Pension1_Acct_Num" type="text" class="form-control 1_Client_Pensions_inputs" name="Client_Pension1_Acct_Num" value=""> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Date_Begin_Earning_Pension1">When did you BEGIN earning this pension?</label>
                                    <input id="Client_Date_Begin_Earning_Pension1" type="text" class="form-control 1_Client_Pensions_inputs hasDatepicker" name="Client_Date_Begin_Earning_Pension1" value="" autocomplete="off" onchange="getConvertureDenomMonths(this, '1', 'Client')"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Pension1_Vest_Date">On what date did/does this Pension vest?</label>
                                    <input id="Client_Pension1_Vest_Date" type="text" class="form-control 1_Client_Pensions_inputs hasDatepicker" name="Client_Pension1_Vest_Date" value="" autocomplete="off" onchange="getConvertureDenomEndDate(this, '1', 'Client')"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Pension1_Earliest_Ret_Date">When is the earliest you CAN retire and receive this Pension?</label>
                                    <input id="Client_Pension1_Earliest_Ret_Date" type="text" class="form-control 1_Client_Pensions_inputs hasDatepicker" name="Client_Pension1_Earliest_Ret_Date" value="" autocomplete="off" onchange="getConvertureDenomEndDate(this, '1', 'Client')">
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label for="Client_Pension1_Coverture_Denom_End_Date">N/A = MIN(Client_Pension1_Vest_Date,Client_Pension1_Earliest_Ret_Date)</label>
                                    <input id="Client_Pension1_Coverture_Denom_End_Date" type="text" class="form-control 1_Client_Pensions_inputs" name="Client_Pension1_Coverture_Denom_End_Date" value="" autocomplete="off"> 
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label for="Client_Pension1_Coverture_Denom_Months">N/A = period_diff(date_format(Client_Pension1_Coverture_Denom_End_Date, ‘%Y%m’), date_format(Client_Date_Begin_Earning_Pension1, ‘%Ym’)))</label>
                                    <input id="Client_Pension1_Coverture_Denom_Months" type="number" class="form-control 1_Client_Pensions_inputs" name="Client_Pension1_Coverture_Denom_Months" value=""> 
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label for="Client_Pension1_Coverture_Num_Start_Date">N/A = MAX(dr_MarriageInfo.Marriage_Date,Client_Date_Begin_Earning_Pension1)</label>
                                    <input id="Client_Pension1_Coverture_Num_Start_Date" type="text" class="form-control 1_Client_Pensions_inputs" name="Client_Pension1_Coverture_Num_Start_Date" value="" autocomplete="off"> 
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label for="Client_Pension1_Coverture_Num_End_Date">N/A = MIN(dr_MarriageInfo.Date_of_Separation,Client_Pension1_Coverture_Denom_End_Date)</label>
                                    <input id="Client_Pension1_Coverture_Num_End_Date" type="text" class="form-control 1_Client_Pensions_inputs" name="Client_Pension1_Coverture_Num_End_Date" value="" autocomplete="off"> 
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label for="Client_Pension1_Coverture_Num_Months">N/A = period_diff(date_format(Client_Pension1_Coverture_Num_End_Date, ‘%Y%m’), date_format(Client_Pension1_Coverture_Num_Start_Date, ‘%Ym’))</label>
                                    <input id="Client_Pension1_Coverture_Num_Months" type="number" class="form-control 1_Client_Pensions_inputs" name="Client_Pension1_Coverture_Num_Months" value=""> 
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label for="Client_Pension1_Coverture_Fraction_Client_Default">N/A = 1-(Client_Pension1_Coverture_Num_Months/Client_Pension1_Coverture_Denom_Months)/2</label>
                                    <input id="Client_Pension1_Coverture_Fraction_Client_Default" type="number" class="form-control 1_Client_Pensions_inputs" name="Client_Pension1_Coverture_Fraction_Client_Default" value="0.0000" min="0.0000" step="0.0001" max="99.9999"> 
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label for="Client_Pension1_Coverture_Fraction_Op_Default">N/A = (Client_Pension1_Coverture_Num_Months/Client_Pension1_Coverture_Denom_Months)/2</label>
                                    <input id="Client_Pension1_Coverture_Fraction_Op_Default" type="number" class="form-control 1_Client_Pensions_inputs" name="Client_Pension1_Coverture_Fraction_Op_Default" value="0.0000" min="0.0000" step="0.0001" max="99.9999"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Pension1_Estimated_Monthly_Payment">Please provide the your best estimate of this Pension monthly payment.</label>
                                    <input id="Client_Pension1_Estimated_Monthly_Payment" type="number" class="form-control 1_Client_Pensions_inputs" name="Client_Pension1_Estimated_Monthly_Payment" value="0.00" min="0.00" step="0.01" max="999999.99" onchange="getEstimateMonthlyDefault(this, '1', 'Client');" onkeyup="getEstimateMonthlyDefault(this, '1', 'Client');"> 
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label for="Client_Pension1_Estimate_Monthly_Client_Default">N/A = Client_Pension1_Estimated_Monthly_Payment – (Client_Pension1_Coverture_Fraction_Client_Default * Client_Pension1_Estimated_Monthly_Payment)</label>
                                    <input id="Client_Pension1_Estimate_Monthly_Client_Default" type="number" class="form-control 1_Client_Pensions_inputs" name="Client_Pension1_Estimate_Monthly_Client_Default" value="0.00" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label for="Client_Pension1_Estimate_Monthly_Op_Default">N/A = (Client_Pension1_Coverture_Fraction_Op_Default * Client_Pension1_Estimated_Monthly_Payment)</label>
                                    <input id="Client_Pension1_Estimate_Monthly_Op_Default" type="number" class="form-control 1_Client_Pensions_inputs" name="Client_Pension1_Estimate_Monthly_Op_Default" value="0.00" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>What type of distribution will this be?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="" name="Client_Pension1_Disposition_Type" value="Coverture" onchange="onDistributionChange(this, '1', 'Client');"> Coverture</label>
                                        <label><input type="radio" id="" name="Client_Pension1_Disposition_Type" value="Custom %" onchange="onDistributionChange(this, '1', 'Client');"> Custom %</label>
                                        <label><input type="radio" id="" name="Client_Pension1_Disposition_Type" value="Custom Amount" onchange="onDistributionChange(this, '1', 'Client');"> Custom Amount</label>
                                        <label><input type="radio" id="" name="Client_Pension1_Disposition_Type" value="Buyout" onchange="onDistributionChange(this, '1', 'Client');"> Buyout</label>
                                        <label><input type="radio" id="" name="Client_Pension1_Disposition_Type" value="Owner Keeps" onchange="onDistributionChange(this, '1', 'Client');"> Owner Keeps</label>
                                    </div>
                                </div>

                                <div class="form-group col-sm-6 1_Client_Coverture_Date_Div" style="display: none;">
                                    <label>Which date to be used?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" class="1_Client_Coverture_Date_Input" name="Client_Pension1_Coverture_Date_Input" value="DateOfSeparation" onchange="onSeparationHearingDateChange(this, '1', 'Client');"> DateOfSeparation</label>
                                        <label><input type="radio" class="1_Client_Coverture_Date_Input" name="Client_Pension1_Coverture_Date_Input" value="FinalHearingDate" onchange="onSeparationHearingDateChange(this, '1', 'Client');"> FinalHearingDate</label>
                                    </div>
                                </div>
                                <!-- Pension Tool -->
                                <!-- <h5>Pension Tool</h5> -->    
                                <div class="form-group col-sm-6 1_Client_Pension_Has_Survivorship_Plan_Div" style="display: none;">
                                    <label>Check if this Pension has a Survivorship Plan.</label>
                                    <div class="w-100 dataInput">
                                        <label><input type="checkbox" id="" name="Client_Pension1_Has_Survivorship_Plan" value="1" onchange="PensionhasSurvivorshipPlan(this, '1', 'Client');"> Yes</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 1_Client_survivorship_plan_inputs_div" style="display: none;">
                                    <label>Percentage Cost of survivorship plan</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="" name="Client_Pension1_Survivorship_Plan_Percentage_Cost" value="Fixed Monthly Cost"> Fixed Monthly Cost</label>
                                        <label><input type="radio" id="" name="Client_Pension1_Survivorship_Plan_Percentage_Cost" value="Fixed Percentage of Benefit"> Fixed Percentage of Benefit</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 1_Client_survivorship_plan_inputs_div" style="display: none;">
                                    <label for="Client_Pension1_Survivorship_Plan_Monthly_Cost">Cost of survivorship plan</label>
                                    <input id="Client_Pension1_Survivorship_Plan_Monthly_Cost" type="number" onchange="getCostOfSurvivorshipPlan(this, '1', 'Client');" onkeyup="getCostOfSurvivorshipPlan(this, '1', 'Client');" class="form-control 1_Client_Pensions_inputs" name="Client_Pension1_Survivorship_Plan_Monthly_Cost" value="0.00" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6 1_Client_survivorship_plan_inputs_div" style="display: none;">
                                    <label>Payment options for Survivorship Plan</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="" name="Client_Pension1_Surv_Payer" value="Declined" onchange="PaymentOptionsForSurvivorshipPlan(this, '1', 'Client');"> Declined</label>
                                        <label><input type="radio" id="Client_Pension1_Surv_Payer_Op_Name" name="Client_Pension1_Surv_Payer" value="{{$opponent_name}}" onchange="PaymentOptionsForSurvivorshipPlan(this, '1', 'Client');"> {{$opponent_name}}</label>
                                         <label><input type="radio" id="" name="Client_Pension1_Surv_Payer" value="Both Parties Equally" onchange="PaymentOptionsForSurvivorshipPlan(this, '1', 'Client');"> Both Parties Equally</label>
                                        <label><input type="radio" id="Client_Pension1_Surv_Payer_Client_Name" name="Client_Pension1_Surv_Payer" value="{{$client_name}}" onchange="PaymentOptionsForSurvivorshipPlan(this, '1', 'Client');"> {{$client_name}}</label>
                                    </div>
                                </div>
                                <!-- <div class="form-group col-sm-6 1_Client_If_Buyout_Div" style="display: none;">
                                    <label for="Client_Pension1_Amount_To_Pay_Op">Amount to pay {{$opponent_name}}</label>
                                    <input id="Client_Pension1_Amount_To_Pay_Op" type="number" class="form-control 1_Client_Pensions_inputs" name="Client_Pension1_Amount_To_Pay_Op" value="0.00" min="0.00" step="0.01" max="999999.99">   
                                </div> -->
                                <!-- <div class="form-group col-sm-6 1_Client_Custom_Percentage_Div" style="display: none;">
                                    <label for="Client_Pension1_Custom_Percentage_Input">Amount to be paid by {{$opponent_name}} (%)</label>
                                    <input id="Client_Pension1_Custom_Percentage_Input" type="number" class="form-control 1_Client_Pensions_inputs" name="Client_Pension1_Amount_To_Pay_Percent_Op" value="0.00" min="0.00" step="0.01" max="100.00"  onchange="onCustomPercentageChange(this, '1', 'Client');" onkeyup="onCustomPercentageChange(this, '1', 'Client');">   
                                </div>
                                <div class="form-group col-sm-6 1_Client_Custom_Amount_Div" style="display: none;">
                                    <label for="Client_Pension1_Custom_Amount_Input">Amount to be paid by {{$opponent_name}} (per month)</label>
                                    <input id="Client_Pension1_Custom_Amount_Input" type="number" class="form-control 1_Client_Pensions_inputs" name="Client_Pension1_Amount_To_Pay_Per_Month_Op" value="0.00" min="0.00" step="0.01" max="999999.99"  onchange="onCustomAmountChange(this, '1', 'Client');" onkeyup="onCustomAmountChange(this, '1', 'Client');">   
                                </div> --> 
                                <!--<div class="form-group col-sm-2 1_Client_Coverture_Div 1_Client_Buyout_Div 1_Client_Owner_Keeps_Div" style="display: none;">
                                    <label for="">Converture %</label>
                                </div>
                                <div class="form-group col-sm-5 1_Client_Coverture_Div 1_Client_Buyout_Div 1_Client_Owner_Keeps_Div" style="display: none;">
                                    <label for="Client_Pension1_Converture_Percent_Client">{{$client_name}}</label>
                                    <input id="Client_Pension1_Converture_Percent_Client" type="number" class="form-control 1_Client_Pensions_inputs" name="Client_Pension1_Converture_Percent_Client" value="0.00" min="0.00" step="0.01" max="100.00">   
                                </div>
                                <div class="form-group col-sm-5 1_Client_Coverture_Div 1_Client_Buyout_Div 1_Client_Owner_Keeps_Div" style="display: none;">
                                    <label for="Client_Pension1_Converture_Percent_Op">{{$opponent_name}}</label>
                                    <input id="Client_Pension1_Converture_Percent_Op" type="number" class="form-control 1_Client_Pensions_inputs" name="Client_Pension1_Converture_Percent_Op" value="0.00" min="0.00" step="0.01" max="100.00">   
                                </div>
                                <div class="form-group col-sm-2 1_Client_Custom_Div" style="display: none;">
                                    <label for="">Estimated Monthly Net Payment</label>
                                </div>
                                <div class="form-group col-sm-5 1_Client_Custom_Div" style="display: none;">
                                    <label for="Client_Pension1_Estimated_Payment_Client">{{$client_name}}</label>
                                    <input id="Client_Pension1_Estimated_Payment_Client" type="number" class="form-control 1_Client_Pensions_inputs" name="Client_Pension1_Estimated_Payment_Client" value="0.00" min="0.00" step="0.01" max="100.00">   
                                </div>
                                <div class="form-group col-sm-5 1_Client_Custom_Div" style="display: none;">
                                    <label for="Client_Pension1_Estimated_Payment_Op">{{$opponent_name}}</label>
                                    <input id="Client_Pension1_Estimated_Payment_Op" type="number" class="form-control 1_Client_Pensions_inputs" name="Client_Pension1_Estimated_Payment_Op" value="0.00" min="0.00" step="0.01" max="100.00">   
                                </div> -->
                                <!-- End Pension Tool -->
                                <div class="form-group col-sm-6 1_Client_survivorship_plan_inputs_div" style="display: none;">
                                    <label for="Client_Pension1_Surv_Cost_Client">Pension Survivorship Cost {{$client_name}}</label>
                                    <input id="Client_Pension1_Surv_Cost_Client" type="number" class="form-control 1_Client_Pensions_inputs" name="Client_Pension1_Surv_Cost_Client" value="0.00" min="0.00" step="0.01" max="999999.99" onchange="onClientPensionSurvCostChange(this, '1', 'Client');" onkeyup="onClientPensionSurvCostChange(this, '1', 'Client');"> 
                                </div>
                                <div class="form-group col-sm-6 1_Client_survivorship_plan_inputs_div" style="display: none;">
                                    <label for="Client_Pension1_Surv_Cost_Op">Pension Survivorship Cost {{$opponent_name}}</label>
                                    <input id="Client_Pension1_Surv_Cost_Op" type="number" class="form-control 1_Client_Pensions_inputs" name="Client_Pension1_Surv_Cost_Op" value="0.00" min="0.00" step="0.01" max="999999.99" onchange="onOpponentPensionSurvCostChange(this, '1', 'Client');" onkeyup="onOpponentPensionSurvCostChange(this, '1', 'Client');"> 
                                </div>
                                <div class="form-group col-sm-6 Client_Pension1_Buyout_Op_Amount_Div" style="display: none;" style="display: none;">
                                    <label for="Client_Pension1_Buyout_Op_Amount">Pension Buyout {{$opponent_name}}’s Amount</label>
                                    <input id="Client_Pension1_Buyout_Op_Amount" type="number" class="form-control 1_Client_Pensions_inputs" name="Client_Pension1_Buyout_Op_Amount" value="0.00" min="0.00" step="0.01" max="999999.99"> 
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
                                        <label><input type="radio" id="1_Client_Pension_Estimated_Value_Select" name="1_Client_Pension_Estimated_Value_Select_Reset" class="Pension_Estimated_Value_Select_Reset" value="Save"> Save this Distribution of Pension Account #1</label>
                                        <label><input type="radio" id="1_Client_Pension_Estimated_Value_Reset" name="1_Client_Pension_Estimated_Value_Select_Reset" class="Pension_Estimated_Value_Select_Reset" value="Reset" onclick="resetBalanceInput(this, '1', 'Client');"> Reset to Default (Coverture)</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label>Pension Custom Monthly Client Percent</label>
                                    <input id="Client_Pension1_Custom_Monthly_Client_Percent" type="number" class="form-control 1_Client_clientpercentage_input clientpercentage_input" name="Client_Pension1_Custom_Monthly_Client_Percent" value="50.00" min="0.00" step="0.01" max="100" readonly="">
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label>Pension Custom Monthly Client Amount</label>
                                    <input id="Client_Pension1_Custom_Monthly_Client_Amount" type="number" class="form-control 1_Client_clientamount_input clientamount_input" name="Client_Pension1_Custom_Monthly_Client_Amount" value="" min="0.00" step="0.01" max="999999.99" readonly="">
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label>Pension Custom Monthly Opponent Percent</label>
                                    <input id="Client_Pension1_Custom_Monthly_Op_Percent" type="number" class="form-control 1_Client_opponentpercentage_input opponentpercentage_input" name="Client_Pension1_Custom_Monthly_Op_Percent" value="50.00" min="0.00" step="0.01" max="100" readonly="">
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label>Pension Custom Monthly Oppnent Amount</label>
                                    <input id="Client_Pension1_Custom_Monthly_Op_Amount" type="number" class="form-control 1_Client_opponentamount_input opponentamount_input" name="Client_Pension1_Custom_Monthly_Op_Amount" value="" min="0.00" step="0.01" max="999999.99" readonly="">
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Pension1_Estimated_Net_Client">Pension Estimated Net to {{$client_name}}</label>
                                    <input id="Client_Pension1_Estimated_Net_Client" type="number" class="form-control 1_Client_Pensions_inputs 1_Client_clientnetamount_input clientnetamount_input" name="Client_Pension1_Estimated_Net_Client" value="0.00" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Pension1_Estimated_Net_Op">Pension Estimated Net to {{$opponent_name}}</label>
                                    <input id="Client_Pension1_Estimated_Net_Op" type="number" class="form-control 1_Client_Pensions_inputs 1_Client_opponentnetamount_input opponentnetamount_input" name="Client_Pension1_Estimated_Net_Op" value="0.00" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <!-- end of slider tool -->
                            </div>
                            <div class="col-sm-12 mt-4 2_Client_Pensions_section" style="display: none;">
                                <h5 class="col-sm-12">Second Pension Info</h5>
                                <div class="form-group col-sm-6">
                                    <label>Pension is currently being paid out</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Client_Pension2_Is_Currently_Being_Paid_Out_Yes" name="Client_Pension2_Is_Currently_Being_Paid_Out" value="Yes"> Yes</label>
                                        <label><input type="radio" id="Client_Pension2_Is_Currently_Being_Paid_Out_No" name="Client_Pension2_Is_Currently_Being_Paid_Out" value="No" checked=""> No</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Pension2_Type">What type of pension?</label>
                                    <select id="Client_Pension2_Type" name="Client_Pension2_Type" class="form-control 2_Client_Pensions_select">
                                        <option value="">Select</option>
                                        <option value="Federal">Federal</option>
                                        <option value="State">State</option>
                                        <option value="Private">Private</option>
                                    </select>   
                                </div>
                                <div class="form-group col-sm-6">
                                    <p class="text-danger 2_Client_no-state-county-found" style="display: none;">No City, State, County found for this zipcode.</p>
                                    <label for="Client_Pension2_ZIP">Pension Institution Zip Code?</label>
                                    <input id="Client_Pension2_ZIP" type="text" class="form-control 2_Client_Pensions_inputs" name="Client_Pension2_ZIP" value="" onkeyup="getCityStateForZip(this, '2_Client');"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Pension2_Institution_Name">Name of Pension Institution?</label>
                                    <input id="Client_Pension2_Institution_Name" type="text" class="form-control 2_Client_Pensions_inputs" name="Client_Pension2_Institution_Name" value=""> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Pension2_Street_Address">Pension Institution Street Address?</label>
                                    <input id="Client_Pension2_Street_Address" type="text" class="form-control 2_Client_Pensions_inputs" name="Client_Pension2_Street_Address" value=""> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Pension2_City">Pension Institution City?</label>
                                    <select id="Client_Pension2_City" name="Client_Pension2_City" class="form-control 2_Client_city_select">
                                        <option value="">Choose City</option>
                                    </select>   
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Pension2_State">Pension Institution State?</label>
                                    <select id="Client_Pension2_State" name="Client_Pension2_State" class="form-control 2_Client_state_select">
                                        <option value="">Choose State</option>
                                    </select>   
                                </div>                                
                                <div class="form-group col-sm-6">
                                    <label for="Client_Pension2_Acct_Num">Account Number?</label>
                                    <input id="Client_Pension2_Acct_Num" type="text" class="form-control 2_Client_Pensions_inputs" name="Client_Pension2_Acct_Num" value=""> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Date_Begin_Earning_Pension2">When did you BEGIN earning this pension?</label>
                                    <input id="Client_Date_Begin_Earning_Pension2" type="text" class="form-control 2_Client_Pensions_inputs hasDatepicker" name="Client_Date_Begin_Earning_Pension2" value="" autocomplete="off" onchange="getConvertureDenomMonths(this, '2', 'Client')"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Pension2_Vest_Date">On what date did/does this Pension vest?</label>
                                    <input id="Client_Pension2_Vest_Date" type="text" class="form-control 2_Client_Pensions_inputs hasDatepicker" name="Client_Pension2_Vest_Date" value="" autocomplete="off" onchange="getConvertureDenomEndDate(this, '2', 'Client')"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Pension2_Earliest_Ret_Date">When is the earliest you CAN retire and receive this Pension?</label>
                                    <input id="Client_Pension2_Earliest_Ret_Date" type="text" class="form-control 2_Client_Pensions_inputs hasDatepicker" name="Client_Pension2_Earliest_Ret_Date" value="" autocomplete="off" onchange="getConvertureDenomEndDate(this, '2', 'Client')">
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label for="Client_Pension2_Coverture_Denom_End_Date">N/A = MIN(Client_Pension2_Vest_Date,Client_Pension2_Earliest_Ret_Date)</label>
                                    <input id="Client_Pension2_Coverture_Denom_End_Date" type="text" class="form-control 2_Client_Pensions_inputs" name="Client_Pension2_Coverture_Denom_End_Date" value="" autocomplete="off"> 
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label for="Client_Pension2_Coverture_Denom_Months">N/A = period_diff(date_format(Client_Pension2_Coverture_Denom_End_Date, ‘%Y%m’), date_format(Client_Date_Begin_Earning_Pension2, ‘%Ym’)))</label>
                                    <input id="Client_Pension2_Coverture_Denom_Months" type="number" class="form-control 2_Client_Pensions_inputs" name="Client_Pension2_Coverture_Denom_Months" value=""> 
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label for="Client_Pension2_Coverture_Num_Start_Date">N/A = MAX(dr_MarriageInfo.Marriage_Date,Client_Date_Begin_Earning_Pension2)</label>
                                    <input id="Client_Pension2_Coverture_Num_Start_Date" type="text" class="form-control 2_Client_Pensions_inputs" name="Client_Pension2_Coverture_Num_Start_Date" value="" autocomplete="off"> 
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label for="Client_Pension2_Coverture_Num_End_Date">N/A = MIN(dr_MarriageInfo.Date_of_Separation,Client_Pension2_Coverture_Denom_End_Date)</label>
                                    <input id="Client_Pension2_Coverture_Num_End_Date" type="text" class="form-control 2_Client_Pensions_inputs" name="Client_Pension2_Coverture_Num_End_Date" value="" autocomplete="off"> 
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label for="Client_Pension2_Coverture_Num_Months">N/A = period_diff(date_format(Client_Pension2_Coverture_Num_End_Date, ‘%Y%m’), date_format(Client_Pension2_Coverture_Num_Start_Date, ‘%Ym’))</label>
                                    <input id="Client_Pension2_Coverture_Num_Months" type="number" class="form-control 2_Client_Pensions_inputs" name="Client_Pension2_Coverture_Num_Months" value=""> 
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label for="Client_Pension2_Coverture_Fraction_Client_Default">N/A = 1-(Client_Pension2_Coverture_Num_Months/Client_Pension2_Coverture_Denom_Months)/2</label>
                                    <input id="Client_Pension2_Coverture_Fraction_Client_Default" type="number" class="form-control 2_Client_Pensions_inputs" name="Client_Pension2_Coverture_Fraction_Client_Default" value="0.0000" min="0.0000" step="0.0001" max="99.9999"> 
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label for="Client_Pension2_Coverture_Fraction_Op_Default">N/A = (Client_Pension2_Coverture_Num_Months/Client_Pension2_Coverture_Denom_Months)/2</label>
                                    <input id="Client_Pension2_Coverture_Fraction_Op_Default" type="number" class="form-control 2_Client_Pensions_inputs" name="Client_Pension2_Coverture_Fraction_Op_Default" value="0.0000" min="0.0000" step="0.0001" max="99.9999"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Pension2_Estimated_Monthly_Payment">Please provide the your best estimate of this Pension monthly payment.</label>
                                    <input id="Client_Pension2_Estimated_Monthly_Payment" type="number" class="form-control 2_Client_Pensions_inputs" name="Client_Pension2_Estimated_Monthly_Payment" value="0.00" min="0.00" step="0.01" max="999999.99" onchange="getEstimateMonthlyDefault(this, '2', 'Client');" onkeyup="getEstimateMonthlyDefault(this, '2', 'Client');"> 
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label for="Client_Pension2_Estimate_Monthly_Client_Default">N/A = Client_Pension2_Estimated_Monthly_Payment – (Client_Pension2_Coverture_Fraction_Client_Default * Client_Pension2_Estimated_Monthly_Payment)</label>
                                    <input id="Client_Pension2_Estimate_Monthly_Client_Default" type="number" class="form-control 2_Client_Pensions_inputs" name="Client_Pension2_Estimate_Monthly_Client_Default" value="0.00" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label for="Client_Pension2_Estimate_Monthly_Op_Default">N/A = (Client_Pension2_Coverture_Fraction_Op_Default * Client_Pension2_Estimated_Monthly_Payment)</label>
                                    <input id="Client_Pension2_Estimate_Monthly_Op_Default" type="number" class="form-control 2_Client_Pensions_inputs" name="Client_Pension2_Estimate_Monthly_Op_Default" value="0.00" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>What type of distribution will this be?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="" name="Client_Pension2_Disposition_Type" value="Coverture" onchange="onDistributionChange(this, '2', 'Client');"> Coverture</label>
                                        <label><input type="radio" id="" name="Client_Pension2_Disposition_Type" value="Custom %" onchange="onDistributionChange(this, '2', 'Client');"> Custom %</label>
                                        <label><input type="radio" id="" name="Client_Pension2_Disposition_Type" value="Custom Amount" onchange="onDistributionChange(this, '2', 'Client');"> Custom Amount</label>
                                        <label><input type="radio" id="" name="Client_Pension2_Disposition_Type" value="Buyout" onchange="onDistributionChange(this, '2', 'Client');"> Buyout</label>
                                        <label><input type="radio" id="" name="Client_Pension2_Disposition_Type" value="Owner Keeps" onchange="onDistributionChange(this, '2', 'Client');"> Owner Keeps</label>
                                    </div>
                                </div>

                                <div class="form-group col-sm-6 2_Client_Coverture_Date_Div" style="display: none;">
                                    <label>Which date to be used?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" class="2_Client_Coverture_Date_Input" name="Client_Pension2_Coverture_Date_Input" value="DateOfSeparation" onchange="onSeparationHearingDateChange(this, '2', 'Client');"> DateOfSeparation</label>
                                        <label><input type="radio" class="2_Client_Coverture_Date_Input" name="Client_Pension2_Coverture_Date_Input" value="FinalHearingDate" onchange="onSeparationHearingDateChange(this, '2', 'Client');"> FinalHearingDate</label>
                                    </div>
                                </div>
                                <!-- Pension Tool -->
                                <!-- <h5>Pension Tool</h5> -->    
                                <div class="form-group col-sm-6 2_Client_Pension_Has_Survivorship_Plan_Div" style="display: none;">
                                    <label>Check if this Pension has a Survivorship Plan.</label>
                                    <div class="w-100 dataInput">
                                        <label><input type="checkbox" id="" name="Client_Pension2_Has_Survivorship_Plan" value="1" onchange="PensionhasSurvivorshipPlan(this, '2', 'Client');"> Yes</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 2_Client_survivorship_plan_inputs_div" style="display: none;">
                                    <label>Percentage Cost of survivorship plan</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="" name="Client_Pension2_Survivorship_Plan_Percentage_Cost" value="Fixed Monthly Cost"> Fixed Monthly Cost</label>
                                        <label><input type="radio" id="" name="Client_Pension2_Survivorship_Plan_Percentage_Cost" value="Fixed Percentage of Benefit"> Fixed Percentage of Benefit</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 2_Client_survivorship_plan_inputs_div" style="display: none;">
                                    <label for="Client_Pension2_Survivorship_Plan_Monthly_Cost">Cost of survivorship plan</label>
                                    <input id="Client_Pension2_Survivorship_Plan_Monthly_Cost" type="number" onchange="getCostOfSurvivorshipPlan(this, '2', 'Client');" onkeyup="getCostOfSurvivorshipPlan(this, '2', 'Client');" class="form-control 2_Client_Pensions_inputs" name="Client_Pension2_Survivorship_Plan_Monthly_Cost" value="0.00" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6 2_Client_survivorship_plan_inputs_div" style="display: none;">
                                    <label>Payment options for Survivorship Plan</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="" name="Client_Pension2_Surv_Payer" value="Declined" onchange="PaymentOptionsForSurvivorshipPlan(this, '2', 'Client');"> Declined</label>
                                        <label><input type="radio" id="Client_Pension2_Surv_Payer_Op_Name" name="Client_Pension2_Surv_Payer" value="{{$opponent_name}}" onchange="PaymentOptionsForSurvivorshipPlan(this, '2', 'Client');"> {{$opponent_name}}</label>
                                         <label><input type="radio" id="" name="Client_Pension2_Surv_Payer" value="Both Parties Equally" onchange="PaymentOptionsForSurvivorshipPlan(this, '2', 'Client');"> Both Parties Equally</label>
                                        <label><input type="radio" id="Client_Pension2_Surv_Payer_Client_Name" name="Client_Pension2_Surv_Payer" value="{{$client_name}}" onchange="PaymentOptionsForSurvivorshipPlan(this, '2', 'Client');"> {{$client_name}}</label>
                                    </div>
                                </div>
                                <!-- <div class="form-group col-sm-6 2_Client_If_Buyout_Div" style="display: none;">
                                    <label for="Client_Pension2_Amount_To_Pay_Op">Amount to pay {{$opponent_name}}</label>
                                    <input id="Client_Pension2_Amount_To_Pay_Op" type="number" class="form-control 2_Client_Pensions_inputs" name="Client_Pension2_Amount_To_Pay_Op" value="0.00" min="0.00" step="0.01" max="999999.99">   
                                </div> -->
                                <!-- <div class="form-group col-sm-6 2_Client_Custom_Percentage_Div" style="display: none;">
                                    <label for="Client_Pension2_Custom_Percentage_Input">Amount to be paid by {{$opponent_name}} (%)</label>
                                    <input id="Client_Pension2_Custom_Percentage_Input" type="number" class="form-control 2_Client_Pensions_inputs" name="Client_Pension2_Amount_To_Pay_Percent_Op" value="0.00" min="0.00" step="0.01" max="100.00"  onchange="onCustomPercentageChange(this, '2', 'Client');" onkeyup="onCustomPercentageChange(this, '2', 'Client');">   
                                </div>
                                <div class="form-group col-sm-6 2_Client_Custom_Amount_Div" style="display: none;">
                                    <label for="Client_Pension2_Custom_Amount_Input">Amount to be paid by {{$opponent_name}} (per month)</label>
                                    <input id="Client_Pension2_Custom_Amount_Input" type="number" class="form-control 2_Client_Pensions_inputs" name="Client_Pension2_Amount_To_Pay_Per_Month_Op" value="0.00" min="0.00" step="0.01" max="999999.99"  onchange="onCustomAmountChange(this, '2', 'Client');" onkeyup="onCustomAmountChange(this, '2', 'Client');">   
                                </div> --> 
                                <!--<div class="form-group col-sm-2 2_Client_Coverture_Div 2_Client_Buyout_Div 2_Client_Owner_Keeps_Div" style="display: none;">
                                    <label for="">Converture %</label>
                                </div>
                                <div class="form-group col-sm-5 2_Client_Coverture_Div 2_Client_Buyout_Div 2_Client_Owner_Keeps_Div" style="display: none;">
                                    <label for="Client_Pension2_Converture_Percent_Client">{{$client_name}}</label>
                                    <input id="Client_Pension2_Converture_Percent_Client" type="number" class="form-control 2_Client_Pensions_inputs" name="Client_Pension2_Converture_Percent_Client" value="0.00" min="0.00" step="0.01" max="100.00">   
                                </div>
                                <div class="form-group col-sm-5 2_Client_Coverture_Div 2_Client_Buyout_Div 2_Client_Owner_Keeps_Div" style="display: none;">
                                    <label for="Client_Pension2_Converture_Percent_Op">{{$opponent_name}}</label>
                                    <input id="Client_Pension2_Converture_Percent_Op" type="number" class="form-control 2_Client_Pensions_inputs" name="Client_Pension2_Converture_Percent_Op" value="0.00" min="0.00" step="0.01" max="100.00">   
                                </div>
                                <div class="form-group col-sm-2 2_Client_Custom_Div" style="display: none;">
                                    <label for="">Estimated Monthly Net Payment</label>
                                </div>
                                <div class="form-group col-sm-5 2_Client_Custom_Div" style="display: none;">
                                    <label for="Client_Pension2_Estimated_Payment_Client">{{$client_name}}</label>
                                    <input id="Client_Pension2_Estimated_Payment_Client" type="number" class="form-control 2_Client_Pensions_inputs" name="Client_Pension2_Estimated_Payment_Client" value="0.00" min="0.00" step="0.01" max="100.00">   
                                </div>
                                <div class="form-group col-sm-5 2_Client_Custom_Div" style="display: none;">
                                    <label for="Client_Pension2_Estimated_Payment_Op">{{$opponent_name}}</label>
                                    <input id="Client_Pension2_Estimated_Payment_Op" type="number" class="form-control 2_Client_Pensions_inputs" name="Client_Pension2_Estimated_Payment_Op" value="0.00" min="0.00" step="0.01" max="100.00">   
                                </div> -->
                                <!-- End Pension Tool -->
                                <div class="form-group col-sm-6 2_Client_survivorship_plan_inputs_div" style="display: none;">
                                    <label for="Client_Pension2_Surv_Cost_Client">Pension Survivorship Cost {{$client_name}}</label>
                                    <input id="Client_Pension2_Surv_Cost_Client" type="number" class="form-control 2_Client_Pensions_inputs" name="Client_Pension2_Surv_Cost_Client" value="0.00" min="0.00" step="0.01" max="999999.99" onchange="onClientPensionSurvCostChange(this, '2', 'Client');" onkeyup="onClientPensionSurvCostChange(this, '2', 'Client');"> 
                                </div>
                                <div class="form-group col-sm-6 2_Client_survivorship_plan_inputs_div" style="display: none;">
                                    <label for="Client_Pension2_Surv_Cost_Op">Pension Survivorship Cost {{$opponent_name}}</label>
                                    <input id="Client_Pension2_Surv_Cost_Op" type="number" class="form-control 2_Client_Pensions_inputs" name="Client_Pension2_Surv_Cost_Op" value="0.00" min="0.00" step="0.01" max="999999.99" onchange="onOpponentPensionSurvCostChange(this, '2', 'Client');" onkeyup="onOpponentPensionSurvCostChange(this, '2', 'Client');"> 
                                </div>
                                <div class="form-group col-sm-6 Client_Pension2_Buyout_Op_Amount_Div" style="display: none;" style="display: none;">
                                    <label for="Client_Pension2_Buyout_Op_Amount">Pension Buyout {{$opponent_name}}’s Amount</label>
                                    <input id="Client_Pension2_Buyout_Op_Amount" type="number" class="form-control 2_Client_Pensions_inputs" name="Client_Pension2_Buyout_Op_Amount" value="0.00" min="0.00" step="0.01" max="999999.99"> 
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
                                        <label><input type="radio" id="2_Client_Pension_Estimated_Value_Select" name="2_Client_Pension_Estimated_Value_Select_Reset" class="Pension_Estimated_Value_Select_Reset" value="Save"> Save this Distribution of Pension Account #2</label>
                                        <label><input type="radio" id="2_Client_Pension_Estimated_Value_Reset" name="2_Client_Pension_Estimated_Value_Select_Reset" class="Pension_Estimated_Value_Select_Reset" value="Reset" onclick="resetBalanceInput(this, '2', 'Client');"> Reset to Default (Coverture)</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label>Pension Custom Monthly Client Percent</label>
                                    <input id="Client_Pension2_Custom_Monthly_Client_Percent" type="number" class="form-control 2_Client_clientpercentage_input clientpercentage_input" name="Client_Pension2_Custom_Monthly_Client_Percent" value="50.00" min="0.00" step="0.01" max="100" readonly="">
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label>Pension Custom Monthly Client Amount</label>
                                    <input id="Client_Pension2_Custom_Monthly_Client_Amount" type="number" class="form-control 2_Client_clientamount_input clientamount_input" name="Client_Pension2_Custom_Monthly_Client_Amount" value="" min="0.00" step="0.01" max="999999.99" readonly="">
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label>Pension Custom Monthly Opponent Percent</label>
                                    <input id="Client_Pension2_Custom_Monthly_Op_Percent" type="number" class="form-control 2_Client_opponentpercentage_input opponentpercentage_input" name="Client_Pension2_Custom_Monthly_Op_Percent" value="50.00" min="0.00" step="0.01" max="100" readonly="">
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label>Pension Custom Monthly Oppnent Amount</label>
                                    <input id="Client_Pension2_Custom_Monthly_Op_Amount" type="number" class="form-control 2_Client_opponentamount_input opponentamount_input" name="Client_Pension2_Custom_Monthly_Op_Amount" value="" min="0.00" step="0.01" max="999999.99" readonly="">
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Pension2_Estimated_Net_Client">Pension Estimated Net to {{$client_name}}</label>
                                    <input id="Client_Pension2_Estimated_Net_Client" type="number" class="form-control 2_Client_Pensions_inputs 2_Client_clientnetamount_input clientnetamount_input" name="Client_Pension2_Estimated_Net_Client" value="0.00" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Pension2_Estimated_Net_Op">Pension Estimated Net to {{$opponent_name}}</label>
                                    <input id="Client_Pension2_Estimated_Net_Op" type="number" class="form-control 2_Client_Pensions_inputs 2_Client_opponentnetamount_input opponentnetamount_input" name="Client_Pension2_Estimated_Net_Op" value="0.00" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <!-- end of slider tool -->
                            </div>
                            <div class="col-sm-12 mt-4 3_Client_Pensions_section" style="display: none;">
                                <h5 class="col-sm-12">Third Pension Info</h5>
                                <div class="form-group col-sm-6">
                                    <label>Pension is currently being paid out</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Client_Pension3_Is_Currently_Being_Paid_Out_Yes" name="Client_Pension3_Is_Currently_Being_Paid_Out" value="Yes"> Yes</label>
                                        <label><input type="radio" id="Client_Pension3_Is_Currently_Being_Paid_Out_No" name="Client_Pension3_Is_Currently_Being_Paid_Out" value="No" checked=""> No</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Pension3_Type">What type of pension?</label>
                                    <select id="Client_Pension3_Type" name="Client_Pension3_Type" class="form-control 3_Client_Pensions_select">
                                        <option value="">Select</option>
                                        <option value="Federal">Federal</option>
                                        <option value="State">State</option>
                                        <option value="Private">Private</option>
                                    </select>   
                                </div>
                                <div class="form-group col-sm-6">
                                    <p class="text-danger 3_Client_no-state-county-found" style="display: none;">No City, State, County found for this zipcode.</p>
                                    <label for="Client_Pension3_ZIP">Pension Institution Zip Code?</label>
                                    <input id="Client_Pension3_ZIP" type="text" class="form-control 3_Client_Pensions_inputs" name="Client_Pension3_ZIP" value="" onkeyup="getCityStateForZip(this, '3_Client');"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Pension3_Institution_Name">Name of Pension Institution?</label>
                                    <input id="Client_Pension3_Institution_Name" type="text" class="form-control 3_Client_Pensions_inputs" name="Client_Pension3_Institution_Name" value=""> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Pension3_Street_Address">Pension Institution Street Address?</label>
                                    <input id="Client_Pension3_Street_Address" type="text" class="form-control 3_Client_Pensions_inputs" name="Client_Pension3_Street_Address" value=""> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Pension3_City">Pension Institution City?</label>
                                    <select id="Client_Pension3_City" name="Client_Pension3_City" class="form-control 3_Client_city_select">
                                        <option value="">Choose City</option>
                                    </select>   
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Pension3_State">Pension Institution State?</label>
                                    <select id="Client_Pension3_State" name="Client_Pension3_State" class="form-control 3_Client_state_select">
                                        <option value="">Choose State</option>
                                    </select>   
                                </div>                                
                                <div class="form-group col-sm-6">
                                    <label for="Client_Pension3_Acct_Num">Account Number?</label>
                                    <input id="Client_Pension3_Acct_Num" type="text" class="form-control 3_Client_Pensions_inputs" name="Client_Pension3_Acct_Num" value=""> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Date_Begin_Earning_Pension3">When did you BEGIN earning this pension?</label>
                                    <input id="Client_Date_Begin_Earning_Pension3" type="text" class="form-control 3_Client_Pensions_inputs hasDatepicker" name="Client_Date_Begin_Earning_Pension3" value="" autocomplete="off" onchange="getConvertureDenomMonths(this, '3', 'Client')"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Pension3_Vest_Date">On what date did/does this Pension vest?</label>
                                    <input id="Client_Pension3_Vest_Date" type="text" class="form-control 3_Client_Pensions_inputs hasDatepicker" name="Client_Pension3_Vest_Date" value="" autocomplete="off" onchange="getConvertureDenomEndDate(this, '3', 'Client')"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Pension3_Earliest_Ret_Date">When is the earliest you CAN retire and receive this Pension?</label>
                                    <input id="Client_Pension3_Earliest_Ret_Date" type="text" class="form-control 3_Client_Pensions_inputs hasDatepicker" name="Client_Pension3_Earliest_Ret_Date" value="" autocomplete="off" onchange="getConvertureDenomEndDate(this, '3', 'Client')">
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label for="Client_Pension3_Coverture_Denom_End_Date">N/A = MIN(Client_Pension3_Vest_Date,Client_Pension3_Earliest_Ret_Date)</label>
                                    <input id="Client_Pension3_Coverture_Denom_End_Date" type="text" class="form-control 3_Client_Pensions_inputs" name="Client_Pension3_Coverture_Denom_End_Date" value="" autocomplete="off"> 
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label for="Client_Pension3_Coverture_Denom_Months">N/A = period_diff(date_format(Client_Pension3_Coverture_Denom_End_Date, ‘%Y%m’), date_format(Client_Date_Begin_Earning_Pension3, ‘%Ym’)))</label>
                                    <input id="Client_Pension3_Coverture_Denom_Months" type="number" class="form-control 3_Client_Pensions_inputs" name="Client_Pension3_Coverture_Denom_Months" value=""> 
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label for="Client_Pension3_Coverture_Num_Start_Date">N/A = MAX(dr_MarriageInfo.Marriage_Date,Client_Date_Begin_Earning_Pension3)</label>
                                    <input id="Client_Pension3_Coverture_Num_Start_Date" type="text" class="form-control 3_Client_Pensions_inputs" name="Client_Pension3_Coverture_Num_Start_Date" value="" autocomplete="off"> 
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label for="Client_Pension3_Coverture_Num_End_Date">N/A = MIN(dr_MarriageInfo.Date_of_Separation,Client_Pension3_Coverture_Denom_End_Date)</label>
                                    <input id="Client_Pension3_Coverture_Num_End_Date" type="text" class="form-control 3_Client_Pensions_inputs" name="Client_Pension3_Coverture_Num_End_Date" value="" autocomplete="off"> 
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label for="Client_Pension3_Coverture_Num_Months">N/A = period_diff(date_format(Client_Pension3_Coverture_Num_End_Date, ‘%Y%m’), date_format(Client_Pension3_Coverture_Num_Start_Date, ‘%Ym’))</label>
                                    <input id="Client_Pension3_Coverture_Num_Months" type="number" class="form-control 3_Client_Pensions_inputs" name="Client_Pension3_Coverture_Num_Months" value=""> 
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label for="Client_Pension3_Coverture_Fraction_Client_Default">N/A = 1-(Client_Pension3_Coverture_Num_Months/Client_Pension3_Coverture_Denom_Months)/2</label>
                                    <input id="Client_Pension3_Coverture_Fraction_Client_Default" type="number" class="form-control 3_Client_Pensions_inputs" name="Client_Pension3_Coverture_Fraction_Client_Default" value="0.0000" min="0.0000" step="0.0001" max="99.9999"> 
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label for="Client_Pension3_Coverture_Fraction_Op_Default">N/A = (Client_Pension3_Coverture_Num_Months/Client_Pension3_Coverture_Denom_Months)/2</label>
                                    <input id="Client_Pension3_Coverture_Fraction_Op_Default" type="number" class="form-control 3_Client_Pensions_inputs" name="Client_Pension3_Coverture_Fraction_Op_Default" value="0.0000" min="0.0000" step="0.0001" max="99.9999"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Pension3_Estimated_Monthly_Payment">Please provide the your best estimate of this Pension monthly payment.</label>
                                    <input id="Client_Pension3_Estimated_Monthly_Payment" type="number" class="form-control 3_Client_Pensions_inputs" name="Client_Pension3_Estimated_Monthly_Payment" value="0.00" min="0.00" step="0.01" max="999999.99" onchange="getEstimateMonthlyDefault(this, '3', 'Client');" onkeyup="getEstimateMonthlyDefault(this, '3', 'Client');"> 
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label for="Client_Pension3_Estimate_Monthly_Client_Default">N/A = Client_Pension3_Estimated_Monthly_Payment – (Client_Pension3_Coverture_Fraction_Client_Default * Client_Pension3_Estimated_Monthly_Payment)</label>
                                    <input id="Client_Pension3_Estimate_Monthly_Client_Default" type="number" class="form-control 3_Client_Pensions_inputs" name="Client_Pension3_Estimate_Monthly_Client_Default" value="0.00" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label for="Client_Pension3_Estimate_Monthly_Op_Default">N/A = (Client_Pension3_Coverture_Fraction_Op_Default * Client_Pension3_Estimated_Monthly_Payment)</label>
                                    <input id="Client_Pension3_Estimate_Monthly_Op_Default" type="number" class="form-control 3_Client_Pensions_inputs" name="Client_Pension3_Estimate_Monthly_Op_Default" value="0.00" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>What type of distribution will this be?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="" name="Client_Pension3_Disposition_Type" value="Coverture" onchange="onDistributionChange(this, '3', 'Client');"> Coverture</label>
                                        <label><input type="radio" id="" name="Client_Pension3_Disposition_Type" value="Custom %" onchange="onDistributionChange(this, '3', 'Client');"> Custom %</label>
                                        <label><input type="radio" id="" name="Client_Pension3_Disposition_Type" value="Custom Amount" onchange="onDistributionChange(this, '3', 'Client');"> Custom Amount</label>
                                        <label><input type="radio" id="" name="Client_Pension3_Disposition_Type" value="Buyout" onchange="onDistributionChange(this, '3', 'Client');"> Buyout</label>
                                        <label><input type="radio" id="" name="Client_Pension3_Disposition_Type" value="Owner Keeps" onchange="onDistributionChange(this, '3', 'Client');"> Owner Keeps</label>
                                    </div>
                                </div>

                                <div class="form-group col-sm-6 3_Client_Coverture_Date_Div" style="display: none;">
                                    <label>Which date to be used?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" class="3_Client_Coverture_Date_Input" name="Client_Pension3_Coverture_Date_Input" value="DateOfSeparation" onchange="onSeparationHearingDateChange(this, '3', 'Client');"> DateOfSeparation</label>
                                        <label><input type="radio" class="3_Client_Coverture_Date_Input" name="Client_Pension3_Coverture_Date_Input" value="FinalHearingDate" onchange="onSeparationHearingDateChange(this, '3', 'Client');"> FinalHearingDate</label>
                                    </div>
                                </div>
                                <!-- Pension Tool -->
                                <!-- <h5>Pension Tool</h5> -->    
                                <div class="form-group col-sm-6 3_Client_Pension_Has_Survivorship_Plan_Div" style="display: none;">
                                    <label>Check if this Pension has a Survivorship Plan.</label>
                                    <div class="w-100 dataInput">
                                        <label><input type="checkbox" id="" name="Client_Pension3_Has_Survivorship_Plan" value="1" onchange="PensionhasSurvivorshipPlan(this, '3', 'Client');"> Yes</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 3_Client_survivorship_plan_inputs_div" style="display: none;">
                                    <label>Percentage Cost of survivorship plan</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="" name="Client_Pension3_Survivorship_Plan_Percentage_Cost" value="Fixed Monthly Cost"> Fixed Monthly Cost</label>
                                        <label><input type="radio" id="" name="Client_Pension3_Survivorship_Plan_Percentage_Cost" value="Fixed Percentage of Benefit"> Fixed Percentage of Benefit</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 3_Client_survivorship_plan_inputs_div" style="display: none;">
                                    <label for="Client_Pension3_Survivorship_Plan_Monthly_Cost">Cost of survivorship plan</label>
                                    <input id="Client_Pension3_Survivorship_Plan_Monthly_Cost" type="number" onchange="getCostOfSurvivorshipPlan(this, '3', 'Client');" onkeyup="getCostOfSurvivorshipPlan(this, '3', 'Client');" class="form-control 3_Client_Pensions_inputs" name="Client_Pension3_Survivorship_Plan_Monthly_Cost" value="0.00" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6 3_Client_survivorship_plan_inputs_div" style="display: none;">
                                    <label>Payment options for Survivorship Plan</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="" name="Client_Pension3_Surv_Payer" value="Declined" onchange="PaymentOptionsForSurvivorshipPlan(this, '3', 'Client');"> Declined</label>
                                        <label><input type="radio" id="Client_Pension3_Surv_Payer_Op_Name" name="Client_Pension3_Surv_Payer" value="{{$opponent_name}}" onchange="PaymentOptionsForSurvivorshipPlan(this, '3', 'Client');"> {{$opponent_name}}</label>
                                         <label><input type="radio" id="" name="Client_Pension3_Surv_Payer" value="Both Parties Equally" onchange="PaymentOptionsForSurvivorshipPlan(this, '3', 'Client');"> Both Parties Equally</label>
                                        <label><input type="radio" id="Client_Pension3_Surv_Payer_Client_Name" name="Client_Pension3_Surv_Payer" value="{{$client_name}}" onchange="PaymentOptionsForSurvivorshipPlan(this, '3', 'Client');"> {{$client_name}}</label>
                                    </div>
                                </div>
                                <!-- <div class="form-group col-sm-6 3_Client_If_Buyout_Div" style="display: none;">
                                    <label for="Client_Pension3_Amount_To_Pay_Op">Amount to pay {{$opponent_name}}</label>
                                    <input id="Client_Pension3_Amount_To_Pay_Op" type="number" class="form-control 3_Client_Pensions_inputs" name="Client_Pension3_Amount_To_Pay_Op" value="0.00" min="0.00" step="0.01" max="999999.99">   
                                </div> -->
                                <!-- <div class="form-group col-sm-6 3_Client_Custom_Percentage_Div" style="display: none;">
                                    <label for="Client_Pension3_Custom_Percentage_Input">Amount to be paid by {{$opponent_name}} (%)</label>
                                    <input id="Client_Pension3_Custom_Percentage_Input" type="number" class="form-control 3_Client_Pensions_inputs" name="Client_Pension3_Amount_To_Pay_Percent_Op" value="0.00" min="0.00" step="0.01" max="100.00"  onchange="onCustomPercentageChange(this, '3', 'Client');" onkeyup="onCustomPercentageChange(this, '3', 'Client');">   
                                </div>
                                <div class="form-group col-sm-6 3_Client_Custom_Amount_Div" style="display: none;">
                                    <label for="Client_Pension3_Custom_Amount_Input">Amount to be paid by {{$opponent_name}} (per month)</label>
                                    <input id="Client_Pension3_Custom_Amount_Input" type="number" class="form-control 3_Client_Pensions_inputs" name="Client_Pension3_Amount_To_Pay_Per_Month_Op" value="0.00" min="0.00" step="0.01" max="999999.99"  onchange="onCustomAmountChange(this, '3', 'Client');" onkeyup="onCustomAmountChange(this, '3', 'Client');">   
                                </div> --> 
                                <!--<div class="form-group col-sm-2 3_Client_Coverture_Div 3_Client_Buyout_Div 3_Client_Owner_Keeps_Div" style="display: none;">
                                    <label for="">Converture %</label>
                                </div>
                                <div class="form-group col-sm-5 3_Client_Coverture_Div 3_Client_Buyout_Div 3_Client_Owner_Keeps_Div" style="display: none;">
                                    <label for="Client_Pension3_Converture_Percent_Client">{{$client_name}}</label>
                                    <input id="Client_Pension3_Converture_Percent_Client" type="number" class="form-control 3_Client_Pensions_inputs" name="Client_Pension3_Converture_Percent_Client" value="0.00" min="0.00" step="0.01" max="100.00">   
                                </div>
                                <div class="form-group col-sm-5 3_Client_Coverture_Div 3_Client_Buyout_Div 3_Client_Owner_Keeps_Div" style="display: none;">
                                    <label for="Client_Pension3_Converture_Percent_Op">{{$opponent_name}}</label>
                                    <input id="Client_Pension3_Converture_Percent_Op" type="number" class="form-control 3_Client_Pensions_inputs" name="Client_Pension3_Converture_Percent_Op" value="0.00" min="0.00" step="0.01" max="100.00">   
                                </div>
                                <div class="form-group col-sm-2 3_Client_Custom_Div" style="display: none;">
                                    <label for="">Estimated Monthly Net Payment</label>
                                </div>
                                <div class="form-group col-sm-5 3_Client_Custom_Div" style="display: none;">
                                    <label for="Client_Pension3_Estimated_Payment_Client">{{$client_name}}</label>
                                    <input id="Client_Pension3_Estimated_Payment_Client" type="number" class="form-control 3_Client_Pensions_inputs" name="Client_Pension3_Estimated_Payment_Client" value="0.00" min="0.00" step="0.01" max="100.00">   
                                </div>
                                <div class="form-group col-sm-5 3_Client_Custom_Div" style="display: none;">
                                    <label for="Client_Pension3_Estimated_Payment_Op">{{$opponent_name}}</label>
                                    <input id="Client_Pension3_Estimated_Payment_Op" type="number" class="form-control 3_Client_Pensions_inputs" name="Client_Pension3_Estimated_Payment_Op" value="0.00" min="0.00" step="0.01" max="100.00">   
                                </div> -->
                                <!-- End Pension Tool -->
                                <div class="form-group col-sm-6 3_Client_survivorship_plan_inputs_div" style="display: none;">
                                    <label for="Client_Pension3_Surv_Cost_Client">Pension Survivorship Cost {{$client_name}}</label>
                                    <input id="Client_Pension3_Surv_Cost_Client" type="number" class="form-control 3_Client_Pensions_inputs" name="Client_Pension3_Surv_Cost_Client" value="0.00" min="0.00" step="0.01" max="999999.99" onchange="onClientPensionSurvCostChange(this, '3', 'Client');" onkeyup="onClientPensionSurvCostChange(this, '3', 'Client');"> 
                                </div>
                                <div class="form-group col-sm-6 3_Client_survivorship_plan_inputs_div" style="display: none;">
                                    <label for="Client_Pension3_Surv_Cost_Op">Pension Survivorship Cost {{$opponent_name}}</label>
                                    <input id="Client_Pension3_Surv_Cost_Op" type="number" class="form-control 3_Client_Pensions_inputs" name="Client_Pension3_Surv_Cost_Op" value="0.00" min="0.00" step="0.01" max="999999.99" onchange="onOpponentPensionSurvCostChange(this, '3', 'Client');" onkeyup="onOpponentPensionSurvCostChange(this, '3', 'Client');"> 
                                </div>
                                <div class="form-group col-sm-6 Client_Pension3_Buyout_Op_Amount_Div" style="display: none;" style="display: none;">
                                    <label for="Client_Pension3_Buyout_Op_Amount">Pension Buyout {{$opponent_name}}’s Amount</label>
                                    <input id="Client_Pension3_Buyout_Op_Amount" type="number" class="form-control 3_Client_Pensions_inputs" name="Client_Pension3_Buyout_Op_Amount" value="0.00" min="0.00" step="0.01" max="999999.99"> 
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
                                        <label><input type="radio" id="3_Client_Pension_Estimated_Value_Select" name="3_Client_Pension_Estimated_Value_Select_Reset" class="Pension_Estimated_Value_Select_Reset" value="Save"> Save this Distribution of Pension Account #3</label>
                                        <label><input type="radio" id="3_Client_Pension_Estimated_Value_Reset" name="3_Client_Pension_Estimated_Value_Select_Reset" class="Pension_Estimated_Value_Select_Reset" value="Reset" onclick="resetBalanceInput(this, '3', 'Client');"> Reset to Default (Coverture)</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label>Pension Custom Monthly Client Percent</label>
                                    <input id="Client_Pension3_Custom_Monthly_Client_Percent" type="number" class="form-control 3_Client_clientpercentage_input clientpercentage_input" name="Client_Pension3_Custom_Monthly_Client_Percent" value="50.00" min="0.00" step="0.01" max="100" readonly="">
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label>Pension Custom Monthly Client Amount</label>
                                    <input id="Client_Pension3_Custom_Monthly_Client_Amount" type="number" class="form-control 3_Client_clientamount_input clientamount_input" name="Client_Pension3_Custom_Monthly_Client_Amount" value="" min="0.00" step="0.01" max="999999.99" readonly="">
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label>Pension Custom Monthly Opponent Percent</label>
                                    <input id="Client_Pension3_Custom_Monthly_Op_Percent" type="number" class="form-control 3_Client_opponentpercentage_input opponentpercentage_input" name="Client_Pension3_Custom_Monthly_Op_Percent" value="50.00" min="0.00" step="0.01" max="100" readonly="">
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label>Pension Custom Monthly Oppnent Amount</label>
                                    <input id="Client_Pension3_Custom_Monthly_Op_Amount" type="number" class="form-control 3_Client_opponentamount_input opponentamount_input" name="Client_Pension3_Custom_Monthly_Op_Amount" value="" min="0.00" step="0.01" max="999999.99" readonly="">
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Pension3_Estimated_Net_Client">Pension Estimated Net to {{$client_name}}</label>
                                    <input id="Client_Pension3_Estimated_Net_Client" type="number" class="form-control 3_Client_Pensions_inputs 3_Client_clientnetamount_input clientnetamount_input" name="Client_Pension3_Estimated_Net_Client" value="0.00" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Pension3_Estimated_Net_Op">Pension Estimated Net to {{$opponent_name}}</label>
                                    <input id="Client_Pension3_Estimated_Net_Op" type="number" class="form-control 3_Client_Pensions_inputs 3_Client_opponentnetamount_input opponentnetamount_input" name="Client_Pension3_Estimated_Net_Op" value="0.00" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <!-- end of slider tool -->
                            </div>
                            <div class="col-sm-12 mt-4 4_Client_Pensions_section" style="display: none;">
                                <h5 class="col-sm-12">Fourth Pension Info</h5>
                                <div class="form-group col-sm-6">
                                    <label>Pension is currently being paid out</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Client_Pension4_Is_Currently_Being_Paid_Out_Yes" name="Client_Pension4_Is_Currently_Being_Paid_Out" value="Yes"> Yes</label>
                                        <label><input type="radio" id="Client_Pension4_Is_Currently_Being_Paid_Out_No" name="Client_Pension4_Is_Currently_Being_Paid_Out" value="No" checked=""> No</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Pension4_Type">What type of pension?</label>
                                    <select id="Client_Pension4_Type" name="Client_Pension4_Type" class="form-control 4_Client_Pensions_select">
                                        <option value="">Select</option>
                                        <option value="Federal">Federal</option>
                                        <option value="State">State</option>
                                        <option value="Private">Private</option>
                                    </select>   
                                </div>
                                <div class="form-group col-sm-6">
                                    <p class="text-danger 4_Client_no-state-county-found" style="display: none;">No City, State, County found for this zipcode.</p>
                                    <label for="Client_Pension4_ZIP">Pension Institution Zip Code?</label>
                                    <input id="Client_Pension4_ZIP" type="text" class="form-control 4_Client_Pensions_inputs" name="Client_Pension4_ZIP" value="" onkeyup="getCityStateForZip(this, '4_Client');"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Pension4_Institution_Name">Name of Pension Institution?</label>
                                    <input id="Client_Pension4_Institution_Name" type="text" class="form-control 4_Client_Pensions_inputs" name="Client_Pension4_Institution_Name" value=""> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Pension4_Street_Address">Pension Institution Street Address?</label>
                                    <input id="Client_Pension4_Street_Address" type="text" class="form-control 4_Client_Pensions_inputs" name="Client_Pension4_Street_Address" value=""> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Pension4_City">Pension Institution City?</label>
                                    <select id="Client_Pension4_City" name="Client_Pension4_City" class="form-control 4_Client_city_select">
                                        <option value="">Choose City</option>
                                    </select>   
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Pension4_State">Pension Institution State?</label>
                                    <select id="Client_Pension4_State" name="Client_Pension4_State" class="form-control 4_Client_state_select">
                                        <option value="">Choose State</option>
                                    </select>   
                                </div>                                
                                <div class="form-group col-sm-6">
                                    <label for="Client_Pension4_Acct_Num">Account Number?</label>
                                    <input id="Client_Pension4_Acct_Num" type="text" class="form-control 4_Client_Pensions_inputs" name="Client_Pension4_Acct_Num" value=""> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Date_Begin_Earning_Pension4">When did you BEGIN earning this pension?</label>
                                    <input id="Client_Date_Begin_Earning_Pension4" type="text" class="form-control 4_Client_Pensions_inputs hasDatepicker" name="Client_Date_Begin_Earning_Pension4" value="" autocomplete="off" onchange="getConvertureDenomMonths(this, '4', 'Client')"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Pension4_Vest_Date">On what date did/does this Pension vest?</label>
                                    <input id="Client_Pension4_Vest_Date" type="text" class="form-control 4_Client_Pensions_inputs hasDatepicker" name="Client_Pension4_Vest_Date" value="" autocomplete="off" onchange="getConvertureDenomEndDate(this, '4', 'Client')"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Pension4_Earliest_Ret_Date">When is the earliest you CAN retire and receive this Pension?</label>
                                    <input id="Client_Pension4_Earliest_Ret_Date" type="text" class="form-control 4_Client_Pensions_inputs hasDatepicker" name="Client_Pension4_Earliest_Ret_Date" value="" autocomplete="off" onchange="getConvertureDenomEndDate(this, '4', 'Client')">
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label for="Client_Pension4_Coverture_Denom_End_Date">N/A = MIN(Client_Pension4_Vest_Date,Client_Pension4_Earliest_Ret_Date)</label>
                                    <input id="Client_Pension4_Coverture_Denom_End_Date" type="text" class="form-control 4_Client_Pensions_inputs" name="Client_Pension4_Coverture_Denom_End_Date" value="" autocomplete="off"> 
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label for="Client_Pension4_Coverture_Denom_Months">N/A = period_diff(date_format(Client_Pension4_Coverture_Denom_End_Date, ‘%Y%m’), date_format(Client_Date_Begin_Earning_Pension4, ‘%Ym’)))</label>
                                    <input id="Client_Pension4_Coverture_Denom_Months" type="number" class="form-control 4_Client_Pensions_inputs" name="Client_Pension4_Coverture_Denom_Months" value=""> 
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label for="Client_Pension4_Coverture_Num_Start_Date">N/A = MAX(dr_MarriageInfo.Marriage_Date,Client_Date_Begin_Earning_Pension4)</label>
                                    <input id="Client_Pension4_Coverture_Num_Start_Date" type="text" class="form-control 4_Client_Pensions_inputs" name="Client_Pension4_Coverture_Num_Start_Date" value="" autocomplete="off"> 
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label for="Client_Pension4_Coverture_Num_End_Date">N/A = MIN(dr_MarriageInfo.Date_of_Separation,Client_Pension4_Coverture_Denom_End_Date)</label>
                                    <input id="Client_Pension4_Coverture_Num_End_Date" type="text" class="form-control 4_Client_Pensions_inputs" name="Client_Pension4_Coverture_Num_End_Date" value="" autocomplete="off"> 
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label for="Client_Pension4_Coverture_Num_Months">N/A = period_diff(date_format(Client_Pension4_Coverture_Num_End_Date, ‘%Y%m’), date_format(Client_Pension4_Coverture_Num_Start_Date, ‘%Ym’))</label>
                                    <input id="Client_Pension4_Coverture_Num_Months" type="number" class="form-control 4_Client_Pensions_inputs" name="Client_Pension4_Coverture_Num_Months" value=""> 
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label for="Client_Pension4_Coverture_Fraction_Client_Default">N/A = 1-(Client_Pension4_Coverture_Num_Months/Client_Pension4_Coverture_Denom_Months)/2</label>
                                    <input id="Client_Pension4_Coverture_Fraction_Client_Default" type="number" class="form-control 4_Client_Pensions_inputs" name="Client_Pension4_Coverture_Fraction_Client_Default" value="0.0000" min="0.0000" step="0.0001" max="99.9999"> 
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label for="Client_Pension4_Coverture_Fraction_Op_Default">N/A = (Client_Pension4_Coverture_Num_Months/Client_Pension4_Coverture_Denom_Months)/2</label>
                                    <input id="Client_Pension4_Coverture_Fraction_Op_Default" type="number" class="form-control 4_Client_Pensions_inputs" name="Client_Pension4_Coverture_Fraction_Op_Default" value="0.0000" min="0.0000" step="0.0001" max="99.9999"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Pension4_Estimated_Monthly_Payment">Please provide the your best estimate of this Pension monthly payment.</label>
                                    <input id="Client_Pension4_Estimated_Monthly_Payment" type="number" class="form-control 4_Client_Pensions_inputs" name="Client_Pension4_Estimated_Monthly_Payment" value="0.00" min="0.00" step="0.01" max="999999.99" onchange="getEstimateMonthlyDefault(this, '4', 'Client');

                                    $('#prev_filed_post_decree').prop("checked",true).trigger("change");" onkeyup="getEstimateMonthlyDefault(this, '4', 'Client');"> 
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label for="Client_Pension4_Estimate_Monthly_Client_Default">N/A = Client_Pension4_Estimated_Monthly_Payment – (Client_Pension4_Coverture_Fraction_Client_Default * Client_Pension4_Estimated_Monthly_Payment)</label>
                                    <input id="Client_Pension4_Estimate_Monthly_Client_Default" type="number" class="form-control 4_Client_Pensions_inputs" name="Client_Pension4_Estimate_Monthly_Client_Default" value="0.00" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label for="Client_Pension4_Estimate_Monthly_Op_Default">N/A = (Client_Pension4_Coverture_Fraction_Op_Default * Client_Pension4_Estimated_Monthly_Payment)</label>
                                    <input id="Client_Pension4_Estimate_Monthly_Op_Default" type="number" class="form-control 4_Client_Pensions_inputs" name="Client_Pension4_Estimate_Monthly_Op_Default" value="0.00" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>What type of distribution will this be?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="" name="Client_Pension4_Disposition_Type" value="Coverture" onchange="onDistributionChange(this, '4', 'Client');"> Coverture</label>
                                        <label><input type="radio" id="" name="Client_Pension4_Disposition_Type" value="Custom %" onchange="onDistributionChange(this, '4', 'Client');"> Custom %</label>
                                        <label><input type="radio" id="" name="Client_Pension4_Disposition_Type" value="Custom Amount" onchange="onDistributionChange(this, '4', 'Client');"> Custom Amount</label>
                                        <label><input type="radio" id="" name="Client_Pension4_Disposition_Type" value="Buyout" onchange="onDistributionChange(this, '4', 'Client');"> Buyout</label>
                                        <label><input type="radio" id="" name="Client_Pension4_Disposition_Type" value="Owner Keeps" onchange="onDistributionChange(this, '4', 'Client');"> Owner Keeps</label>
                                    </div>
                                </div>

                                <div class="form-group col-sm-6 4_Client_Coverture_Date_Div" style="display: none;">
                                    <label>Which date to be used?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" class="4_Client_Coverture_Date_Input" name="Client_Pension4_Coverture_Date_Input" value="DateOfSeparation" onchange="onSeparationHearingDateChange(this, '4', 'Client');"> DateOfSeparation</label>
                                        <label><input type="radio" class="4_Client_Coverture_Date_Input" name="Client_Pension4_Coverture_Date_Input" value="FinalHearingDate" onchange="onSeparationHearingDateChange(this, '4', 'Client');"> FinalHearingDate</label>
                                    </div>
                                </div>
                                <!-- Pension Tool -->
                                <!-- <h5>Pension Tool</h5> -->    
                                <div class="form-group col-sm-6 4_Client_Pension_Has_Survivorship_Plan_Div" style="display: none;">
                                    <label>Check if this Pension has a Survivorship Plan.</label>
                                    <div class="w-100 dataInput">
                                        <label><input type="checkbox" id="" name="Client_Pension4_Has_Survivorship_Plan" value="1" onchange="PensionhasSurvivorshipPlan(this, '4', 'Client');"> Yes</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 4_Client_survivorship_plan_inputs_div" style="display: none;">
                                    <label>Percentage Cost of survivorship plan</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="" name="Client_Pension4_Survivorship_Plan_Percentage_Cost" value="Fixed Monthly Cost"> Fixed Monthly Cost</label>
                                        <label><input type="radio" id="" name="Client_Pension4_Survivorship_Plan_Percentage_Cost" value="Fixed Percentage of Benefit"> Fixed Percentage of Benefit</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 4_Client_survivorship_plan_inputs_div" style="display: none;">
                                    <label for="Client_Pension4_Survivorship_Plan_Monthly_Cost">Cost of survivorship plan</label>
                                    <input id="Client_Pension4_Survivorship_Plan_Monthly_Cost" type="number" onchange="getCostOfSurvivorshipPlan(this, '4', 'Client');" onkeyup="getCostOfSurvivorshipPlan(this, '4', 'Client');" class="form-control 4_Client_Pensions_inputs" name="Client_Pension4_Survivorship_Plan_Monthly_Cost" value="0.00" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6 4_Client_survivorship_plan_inputs_div" style="display: none;">
                                    <label>Payment options for Survivorship Plan</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="" name="Client_Pension4_Surv_Payer" value="Declined" onchange="PaymentOptionsForSurvivorshipPlan(this, '4', 'Client');"> Declined</label>
                                        <label><input type="radio" id="Client_Pension4_Surv_Payer_Op_Name" name="Client_Pension4_Surv_Payer" value="{{$opponent_name}}" onchange="PaymentOptionsForSurvivorshipPlan(this, '4', 'Client');"> {{$opponent_name}}</label>
                                         <label><input type="radio" id="" name="Client_Pension4_Surv_Payer" value="Both Parties Equally" onchange="PaymentOptionsForSurvivorshipPlan(this, '4', 'Client');"> Both Parties Equally</label>
                                        <label><input type="radio" id="Client_Pension4_Surv_Payer_Client_Name" name="Client_Pension4_Surv_Payer" value="{{$client_name}}" onchange="PaymentOptionsForSurvivorshipPlan(this, '4', 'Client');"> {{$client_name}}</label>
                                    </div>
                                </div>
                                <!-- <div class="form-group col-sm-6 4_Client_If_Buyout_Div" style="display: none;">
                                    <label for="Client_Pension4_Amount_To_Pay_Op">Amount to pay {{$opponent_name}}</label>
                                    <input id="Client_Pension4_Amount_To_Pay_Op" type="number" class="form-control 4_Client_Pensions_inputs" name="Client_Pension4_Amount_To_Pay_Op" value="0.00" min="0.00" step="0.01" max="999999.99">   
                                </div> -->
                                <!-- <div class="form-group col-sm-6 4_Client_Custom_Percentage_Div" style="display: none;">
                                    <label for="Client_Pension4_Custom_Percentage_Input">Amount to be paid by {{$opponent_name}} (%)</label>
                                    <input id="Client_Pension4_Custom_Percentage_Input" type="number" class="form-control 4_Client_Pensions_inputs" name="Client_Pension4_Amount_To_Pay_Percent_Op" value="0.00" min="0.00" step="0.01" max="100.00"  onchange="onCustomPercentageChange(this, '4', 'Client');" onkeyup="onCustomPercentageChange(this, '4', 'Client');">   
                                </div>
                                <div class="form-group col-sm-6 4_Client_Custom_Amount_Div" style="display: none;">
                                    <label for="Client_Pension4_Custom_Amount_Input">Amount to be paid by {{$opponent_name}} (per month)</label>
                                    <input id="Client_Pension4_Custom_Amount_Input" type="number" class="form-control 4_Client_Pensions_inputs" name="Client_Pension4_Amount_To_Pay_Per_Month_Op" value="0.00" min="0.00" step="0.01" max="999999.99"  onchange="onCustomAmountChange(this, '4', 'Client');" onkeyup="onCustomAmountChange(this, '4', 'Client');">   
                                </div> --> 
                                <!--<div class="form-group col-sm-2 4_Client_Coverture_Div 4_Client_Buyout_Div 4_Client_Owner_Keeps_Div" style="display: none;">
                                    <label for="">Converture %</label>
                                </div>
                                <div class="form-group col-sm-5 4_Client_Coverture_Div 4_Client_Buyout_Div 4_Client_Owner_Keeps_Div" style="display: none;">
                                    <label for="Client_Pension4_Converture_Percent_Client">{{$client_name}}</label>
                                    <input id="Client_Pension4_Converture_Percent_Client" type="number" class="form-control 4_Client_Pensions_inputs" name="Client_Pension4_Converture_Percent_Client" value="0.00" min="0.00" step="0.01" max="100.00">   
                                </div>
                                <div class="form-group col-sm-5 4_Client_Coverture_Div 4_Client_Buyout_Div 4_Client_Owner_Keeps_Div" style="display: none;">
                                    <label for="Client_Pension4_Converture_Percent_Op">{{$opponent_name}}</label>
                                    <input id="Client_Pension4_Converture_Percent_Op" type="number" class="form-control 4_Client_Pensions_inputs" name="Client_Pension4_Converture_Percent_Op" value="0.00" min="0.00" step="0.01" max="100.00">   
                                </div>
                                <div class="form-group col-sm-2 4_Client_Custom_Div" style="display: none;">
                                    <label for="">Estimated Monthly Net Payment</label>
                                </div>
                                <div class="form-group col-sm-5 4_Client_Custom_Div" style="display: none;">
                                    <label for="Client_Pension4_Estimated_Payment_Client">{{$client_name}}</label>
                                    <input id="Client_Pension4_Estimated_Payment_Client" type="number" class="form-control 4_Client_Pensions_inputs" name="Client_Pension4_Estimated_Payment_Client" value="0.00" min="0.00" step="0.01" max="100.00">   
                                </div>
                                <div class="form-group col-sm-5 4_Client_Custom_Div" style="display: none;">
                                    <label for="Client_Pension4_Estimated_Payment_Op">{{$opponent_name}}</label>
                                    <input id="Client_Pension4_Estimated_Payment_Op" type="number" class="form-control 4_Client_Pensions_inputs" name="Client_Pension4_Estimated_Payment_Op" value="0.00" min="0.00" step="0.01" max="100.00">   
                                </div> -->
                                <!-- End Pension Tool -->
                                <div class="form-group col-sm-6 4_Client_survivorship_plan_inputs_div" style="display: none;">
                                    <label for="Client_Pension4_Surv_Cost_Client">Pension Survivorship Cost {{$client_name}}</label>
                                    <input id="Client_Pension4_Surv_Cost_Client" type="number" class="form-control 4_Client_Pensions_inputs" name="Client_Pension4_Surv_Cost_Client" value="0.00" min="0.00" step="0.01" max="999999.99" onchange="onClientPensionSurvCostChange(this, '4', 'Client');" onkeyup="onClientPensionSurvCostChange(this, '4', 'Client');"> 
                                </div>
                                <div class="form-group col-sm-6 4_Client_survivorship_plan_inputs_div" style="display: none;">
                                    <label for="Client_Pension4_Surv_Cost_Op">Pension Survivorship Cost {{$opponent_name}}</label>
                                    <input id="Client_Pension4_Surv_Cost_Op" type="number" class="form-control 4_Client_Pensions_inputs" name="Client_Pension4_Surv_Cost_Op" value="0.00" min="0.00" step="0.01" max="999999.99" onchange="onOpponentPensionSurvCostChange(this, '4', 'Client');" onkeyup="onOpponentPensionSurvCostChange(this, '4', 'Client');"> 
                                </div>
                                <div class="form-group col-sm-6 Client_Pension4_Buyout_Op_Amount_Div" style="display: none;" style="display: none;">
                                    <label for="Client_Pension4_Buyout_Op_Amount">Pension Buyout {{$opponent_name}}’s Amount</label>
                                    <input id="Client_Pension4_Buyout_Op_Amount" type="number" class="form-control 4_Client_Pensions_inputs" name="Client_Pension4_Buyout_Op_Amount" value="0.00" min="0.00" step="0.01" max="999999.99"> 
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
                                        <label><input type="radio" id="4_Client_Pension_Estimated_Value_Select" name="4_Client_Pension_Estimated_Value_Select_Reset" class="Pension_Estimated_Value_Select_Reset" value="Save"> Save this Distribution of Pension Account #4</label>
                                        <label><input type="radio" id="4_Client_Pension_Estimated_Value_Reset" name="4_Client_Pension_Estimated_Value_Select_Reset" class="Pension_Estimated_Value_Select_Reset" value="Reset" onclick="resetBalanceInput(this, '4', 'Client');"> Reset to Default (Coverture)</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label>Pension Custom Monthly Client Percent</label>
                                    <input id="Client_Pension4_Custom_Monthly_Client_Percent" type="number" class="form-control 4_Client_clientpercentage_input clientpercentage_input" name="Client_Pension4_Custom_Monthly_Client_Percent" value="50.00" min="0.00" step="0.01" max="100" readonly="">
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label>Pension Custom Monthly Client Amount</label>
                                    <input id="Client_Pension4_Custom_Monthly_Client_Amount" type="number" class="form-control 4_Client_clientamount_input clientamount_input" name="Client_Pension4_Custom_Monthly_Client_Amount" value="" min="0.00" step="0.01" max="999999.99" readonly="">
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label>Pension Custom Monthly Opponent Percent</label>
                                    <input id="Client_Pension4_Custom_Monthly_Op_Percent" type="number" class="form-control 4_Client_opponentpercentage_input opponentpercentage_input" name="Client_Pension4_Custom_Monthly_Op_Percent" value="50.00" min="0.00" step="0.01" max="100" readonly="">
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label>Pension Custom Monthly Oppnent Amount</label>
                                    <input id="Client_Pension4_Custom_Monthly_Op_Amount" type="number" class="form-control 4_Client_opponentamount_input opponentamount_input" name="Client_Pension4_Custom_Monthly_Op_Amount" value="" min="0.00" step="0.01" max="999999.99" readonly="">
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Pension4_Estimated_Net_Client">Pension Estimated Net to {{$client_name}}</label>
                                    <input id="Client_Pension4_Estimated_Net_Client" type="number" class="form-control 4_Client_Pensions_inputs 4_Client_clientnetamount_input clientnetamount_input" name="Client_Pension4_Estimated_Net_Client" value="0.00" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Pension4_Estimated_Net_Op">Pension Estimated Net to {{$opponent_name}}</label>
                                    <input id="Client_Pension4_Estimated_Net_Op" type="number" class="form-control 4_Client_Pensions_inputs 4_Client_opponentnetamount_input opponentnetamount_input" name="Client_Pension4_Estimated_Net_Op" value="0.00" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <!-- end of slider tool -->
                            </div>
                        </div>
                        <!-- End of Client Pensions Info Section -->
                        <!-- Opponent Pensions Info Section -->
                        <div class="form-row Op_Pensions_section">
                            <div class="col-sm-12 mt-4 1_Op_Pensions_section" style="display: none;">
                                <h4 class="col-sm-12">{{$opponent_name}} Pension Info Section</h4>
                                <h5 class="col-sm-12">First Pension Info</h5>
                                <div class="form-group col-sm-6">
                                    <label>Pension is currently being paid out</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Op_Pension1_Is_Currently_Being_Paid_Out_Yes" name="Op_Pension1_Is_Currently_Being_Paid_Out" value="Yes"> Yes</label>
                                        <label><input type="radio" id="Op_Pension1_Is_Currently_Being_Paid_Out_No" name="Op_Pension1_Is_Currently_Being_Paid_Out" value="No" checked=""> No</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Pension1_Type">What type of pension?</label>
                                    <select id="Op_Pension1_Type" name="Op_Pension1_Type" class="form-control 1_Op_Pensions_select">
                                        <option value="">Select</option>
                                        <option value="Federal">Federal</option>
                                        <option value="State">State</option>
                                        <option value="Private">Private</option>
                                    </select>   
                                </div>
                                <div class="form-group col-sm-6">
                                    <p class="text-danger 1_Op_no-state-county-found" style="display: none;">No City, State, County found for this zipcode.</p>
                                    <label for="Op_Pension1_ZIP">Pension Institution Zip Code?</label>
                                    <input id="Op_Pension1_ZIP" type="text" class="form-control 1_Op_Pensions_inputs" name="Op_Pension1_ZIP" value="" onkeyup="getCityStateForZip(this, '1_Op');"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Pension1_Institution_Name">Name of Pension Institution?</label>
                                    <input id="Op_Pension1_Institution_Name" type="text" class="form-control 1_Op_Pensions_inputs" name="Op_Pension1_Institution_Name" value=""> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Pension1_Street_Address">Pension Institution Street Address?</label>
                                    <input id="Op_Pension1_Street_Address" type="text" class="form-control 1_Op_Pensions_inputs" name="Op_Pension1_Street_Address" value=""> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Pension1_City">Pension Institution City?</label>
                                    <select id="Op_Pension1_City" name="Op_Pension1_City" class="form-control 1_Op_city_select">
                                        <option value="">Choose City</option>
                                    </select>   
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Pension1_State">Pension Institution State?</label>
                                    <select id="Op_Pension1_State" name="Op_Pension1_State" class="form-control 1_Op_state_select">
                                        <option value="">Choose State</option>
                                    </select>   
                                </div>                                
                                <div class="form-group col-sm-6">
                                    <label for="Op_Pension1_Acct_Num">Account Number?</label>
                                    <input id="Op_Pension1_Acct_Num" type="text" class="form-control 1_Op_Pensions_inputs" name="Op_Pension1_Acct_Num" value=""> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Date_Begin_Earning_Pension1">When did you BEGIN earning this pension?</label>
                                    <input id="Op_Date_Begin_Earning_Pension1" type="text" class="form-control 1_Op_Pensions_inputs hasDatepicker" name="Op_Date_Begin_Earning_Pension1" value="" autocomplete="off" onchange="getConvertureDenomMonths(this, '1', 'Op')"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Pension1_Vest_Date">On what date did/does this Pension vest?</label>
                                    <input id="Op_Pension1_Vest_Date" type="text" class="form-control 1_Op_Pensions_inputs hasDatepicker" name="Op_Pension1_Vest_Date" value="" autocomplete="off" onchange="getConvertureDenomEndDate(this, '1', 'Op')"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Pension1_Earliest_Ret_Date">When is the earliest you CAN retire and receive this Pension?</label>
                                    <input id="Op_Pension1_Earliest_Ret_Date" type="text" class="form-control 1_Op_Pensions_inputs hasDatepicker" name="Op_Pension1_Earliest_Ret_Date" value="" autocomplete="off" onchange="getConvertureDenomEndDate(this, '1', 'Op')">
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label for="Op_Pension1_Coverture_Denom_End_Date">N/A = MIN(Op_Pension1_Vest_Date,Op_Pension1_Earliest_Ret_Date)</label>
                                    <input id="Op_Pension1_Coverture_Denom_End_Date" type="text" class="form-control 1_Op_Pensions_inputs" name="Op_Pension1_Coverture_Denom_End_Date" value="" autocomplete="off"> 
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label for="Op_Pension1_Coverture_Denom_Months">N/A = period_diff(date_format(Op_Pension1_Coverture_Denom_End_Date, ‘%Y%m’), date_format(Op_Date_Begin_Earning_Pension1, ‘%Ym’)))</label>
                                    <input id="Op_Pension1_Coverture_Denom_Months" type="number" class="form-control 1_Op_Pensions_inputs" name="Op_Pension1_Coverture_Denom_Months" value=""> 
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label for="Op_Pension1_Coverture_Num_Start_Date">N/A = MAX(dr_MarriageInfo.Marriage_Date,Op_Date_Begin_Earning_Pension1)</label>
                                    <input id="Op_Pension1_Coverture_Num_Start_Date" type="text" class="form-control 1_Op_Pensions_inputs" name="Op_Pension1_Coverture_Num_Start_Date" value="" autocomplete="off"> 
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label for="Op_Pension1_Coverture_Num_End_Date">N/A = MIN(dr_MarriageInfo.Date_of_Separation,Op_Pension1_Coverture_Denom_End_Date)</label>
                                    <input id="Op_Pension1_Coverture_Num_End_Date" type="text" class="form-control 1_Op_Pensions_inputs" name="Op_Pension1_Coverture_Num_End_Date" value="" autocomplete="off"> 
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label for="Op_Pension1_Coverture_Num_Months">N/A = period_diff(date_format(Op_Pension1_Coverture_Num_End_Date, ‘%Y%m’), date_format(Op_Pension1_Coverture_Num_Start_Date, ‘%Ym’))</label>
                                    <input id="Op_Pension1_Coverture_Num_Months" type="number" class="form-control 1_Op_Pensions_inputs" name="Op_Pension1_Coverture_Num_Months" value=""> 
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label for="Op_Pension1_Coverture_Fraction_Client_Default">N/A = 1-(Op_Pension1_Coverture_Num_Months/Op_Pension1_Coverture_Denom_Months)/2</label>
                                    <input id="Op_Pension1_Coverture_Fraction_Client_Default" type="number" class="form-control 1_Op_Pensions_inputs" name="Op_Pension1_Coverture_Fraction_Client_Default" value="0.0000" min="0.0000" step="0.0001" max="99.9999"> 
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label for="Op_Pension1_Coverture_Fraction_Op_Default">N/A = (Op_Pension1_Coverture_Num_Months/Op_Pension1_Coverture_Denom_Months)/2</label>
                                    <input id="Op_Pension1_Coverture_Fraction_Op_Default" type="number" class="form-control 1_Op_Pensions_inputs" name="Op_Pension1_Coverture_Fraction_Op_Default" value="0.0000" min="0.0000" step="0.0001" max="99.9999"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Pension1_Estimated_Monthly_Payment">Please provide the your best estimate of this Pension monthly payment.</label>
                                    <input id="Op_Pension1_Estimated_Monthly_Payment" type="number" class="form-control 

                                    $('#prev_filed_post_decree').prop("checked",true).trigger("change");1_Op_Pensions_inputs" name="Op_Pension1_Estimated_Monthly_Payment" value="0.00" min="0.00" step="0.01" max="999999.99" onchange="getEstimateMonthlyDefault(this, '1', 'Op');" onkeyup="getEstimateMonthlyDefault(this, '1', 'Op');"> 
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label for="Op_Pension1_Estimate_Monthly_Client_Default">N/A = Op_Pension1_Estimated_Monthly_Payment – (Op_Pension1_Coverture_Fraction_Client_Default * Op_Pension1_Estimated_Monthly_Payment)</label>
                                    <input id="Op_Pension1_Estimate_Monthly_Client_Default" type="number" class="form-control 1_Op_Pensions_inputs" name="Op_Pension1_Estimate_Monthly_Client_Default" value="0.00" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label for="Op_Pension1_Estimate_Monthly_Op_Default">N/A = (Op_Pension1_Coverture_Fraction_Op_Default * Op_Pension1_Estimated_Monthly_Payment)</label>
                                    <input id="Op_Pension1_Estimate_Monthly_Op_Default" type="number" class="form-control 1_Op_Pensions_inputs" name="Op_Pension1_Estimate_Monthly_Op_Default" value="0.00" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>What type of distribution will this be?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="" name="Op_Pension1_Disposition_Type" value="Coverture" onchange="onDistributionChange(this, '1', 'Op');"> Coverture</label>
                                        <label><input type="radio" id="" name="Op_Pension1_Disposition_Type" value="Custom %" onchange="onDistributionChange(this, '1', 'Op');"> Custom %</label>
                                        <label><input type="radio" id="" name="Op_Pension1_Disposition_Type" value="Custom Amount" onchange="onDistributionChange(this, '1', 'Op');"> Custom Amount</label>
                                        <label><input type="radio" id="" name="Op_Pension1_Disposition_Type" value="Buyout" onchange="onDistributionChange(this, '1', 'Op');"> Buyout</label>
                                        <label><input type="radio" id="" name="Op_Pension1_Disposition_Type" value="Owner Keeps" onchange="onDistributionChange(this, '1', 'Op');"> Owner Keeps</label>
                                    </div>
                                </div>

                                <div class="form-group col-sm-6 1_Op_Coverture_Date_Div" style="display: none;">
                                    <label>Which date to be used?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" class="1_Op_Coverture_Date_Input" name="Op_Pension1_Coverture_Date_Input" value="DateOfSeparation" onchange="onSeparationHearingDateChange(this, '1', 'Op');"> DateOfSeparation</label>
                                        <label><input type="radio" class="1_Op_Coverture_Date_Input" name="Op_Pension1_Coverture_Date_Input" value="FinalHearingDate" onchange="onSeparationHearingDateChange(this, '1', 'Op');"> FinalHearingDate</label>
                                    </div>
                                </div>
                                <!-- Pension Tool -->
                                <!-- <h5>Pension Tool</h5> -->    
                                <div class="form-group col-sm-6 1_Op_Pension_Has_Survivorship_Plan_Div" style="display: none;">
                                    <label>Check if this Pension has a Survivorship Plan.</label>
                                    <div class="w-100 dataInput">
                                        <label><input type="checkbox" id="" name="Op_Pension1_Has_Survivorship_Plan" value="1" onchange="PensionhasSurvivorshipPlan(this, '1', 'Op');"> Yes</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 1_Op_survivorship_plan_inputs_div" style="display: none;">
                                    <label>Percentage Cost of survivorship plan</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="" name="Op_Pension1_Survivorship_Plan_Percentage_Cost" value="Fixed Monthly Cost"> Fixed Monthly Cost</label>
                                        <label><input type="radio" id="" name="Op_Pension1_Survivorship_Plan_Percentage_Cost" value="Fixed Percentage of Benefit"> Fixed Percentage of Benefit</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 1_Op_survivorship_plan_inputs_div" style="display: none;">
                                    <label for="Op_Pension1_Survivorship_Plan_Monthly_Cost">Cost of survivorship plan</label>
                                    <input id="Op_Pension1_Survivorship_Plan_Monthly_Cost" type="number" onchange="getCostOfSurvivorshipPlan(this, '1', 'Op');" onkeyup="getCostOfSurvivorshipPlan(this, '1', 'Op');" class="form-control 1_Op_Pensions_inputs" name="Op_Pension1_Survivorship_Plan_Monthly_Cost" value="0.00" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6 1_Op_survivorship_plan_inputs_div" style="display: none;">
                                    <label>Payment options for Survivorship Plan</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="" name="Op_Pension1_Surv_Payer" value="Declined" onchange="PaymentOptionsForSurvivorshipPlan(this, '1', 'Op');"> Declined</label>
                                        <label><input type="radio" id="Op_Pension1_Surv_Payer_Op_Name" name="Op_Pension1_Surv_Payer" value="{{$opponent_name}}" onchange="PaymentOptionsForSurvivorshipPlan(this, '1', 'Op');"> {{$opponent_name}}</label>
                                         <label><input type="radio" id="" name="Op_Pension1_Surv_Payer" value="Both Parties Equally" onchange="PaymentOptionsForSurvivorshipPlan(this, '1', 'Op');"> Both Parties Equally</label>
                                        <label><input type="radio" id="Op_Pension1_Surv_Payer_Client_Name" name="Op_Pension1_Surv_Payer" value="{{$client_name}}" onchange="PaymentOptionsForSurvivorshipPlan(this, '1', 'Op');"> {{$client_name}}</label>
                                    </div>
                                </div>
                                <!-- <div class="form-group col-sm-6 1_Op_If_Buyout_Div" style="display: none;">
                                    <label for="Op_Pension1_Amount_To_Pay_Op">Amount to pay {{$opponent_name}}</label>
                                    <input id="Op_Pension1_Amount_To_Pay_Op" type="number" class="form-control 1_Op_Pensions_inputs" name="Op_Pension1_Amount_To_Pay_Op" value="0.00" min="0.00" step="0.01" max="999999.99">   
                                </div> -->
                                <!-- <div class="form-group col-sm-6 1_Op_Custom_Percentage_Div" style="display: none;">
                                    <label for="Op_Pension1_Custom_Percentage_Input">Amount to be paid by {{$opponent_name}} (%)</label>
                                    <input id="Op_Pension1_Custom_Percentage_Input" type="number" class="form-control 1_Op_Pensions_inputs" name="Op_Pension1_Amount_To_Pay_Percent_Op" value="0.00" min="0.00" step="0.01" max="100.00"  onchange="onCustomPercentageChange(this, '1', 'Op');" onkeyup="onCustomPercentageChange(this, '1', 'Op');">   
                                </div>
                                <div class="form-group col-sm-6 1_Op_Custom_Amount_Div" style="display: none;">
                                    <label for="Op_Pension1_Custom_Amount_Input">Amount to be paid by {{$opponent_name}} (per month)</label>
                                    <input id="Op_Pension1_Custom_Amount_Input" type="number" class="form-control 1_Op_Pensions_inputs" name="Op_Pension1_Amount_To_Pay_Per_Month_Op" value="0.00" min="0.00" step="0.01" max="999999.99"  onchange="onCustomAmountChange(this, '1', 'Op');" onkeyup="onCustomAmountChange(this, '1', 'Op');">   
                                </div> --> 
                                <!--<div class="form-group col-sm-2 1_Op_Coverture_Div 1_Op_Buyout_Div 1_Op_Owner_Keeps_Div" style="display: none;">
                                    <label for="">Converture %</label>
                                </div>
                                <div class="form-group col-sm-5 1_Op_Coverture_Div 1_Op_Buyout_Div 1_Op_Owner_Keeps_Div" style="display: none;">
                                    <label for="Op_Pension1_Converture_Percent_Client">{{$client_name}}</label>
                                    <input id="Op_Pension1_Converture_Percent_Client" type="number" class="form-control 1_Op_Pensions_inputs" name="Op_Pension1_Converture_Percent_Client" value="0.00" min="0.00" step="0.01" max="100.00">   
                                </div>
                                <div class="form-group col-sm-5 1_Op_Coverture_Div 1_Op_Buyout_Div 1_Op_Owner_Keeps_Div" style="display: none;">
                                    <label for="Op_Pension1_Converture_Percent_Op">{{$opponent_name}}</label>
                                    <input id="Op_Pension1_Converture_Percent_Op" type="number" class="form-control 1_Op_Pensions_inputs" name="Op_Pension1_Converture_Percent_Op" value="0.00" min="0.00" step="0.01" max="100.00">   
                                </div>
                                <div class="form-group col-sm-2 1_Op_Custom_Div" style="display: none;">
                                    <label for="">Estimated Monthly Net Payment</label>
                                </div>
                                <div class="form-group col-sm-5 1_Op_Custom_Div" style="display: none;">
                                    <label for="Op_Pension1_Estimated_Payment_Client">{{$client_name}}</label>
                                    <input id="Op_Pension1_Estimated_Payment_Client" type="number" class="form-control 1_Op_Pensions_inputs" name="Op_Pension1_Estimated_Payment_Client" value="0.00" min="0.00" step="0.01" max="100.00">   
                                </div>
                                <div class="form-group col-sm-5 1_Op_Custom_Div" style="display: none;">
                                    <label for="Op_Pension1_Estimated_Payment_Op">{{$opponent_name}}</label>
                                    <input id="Op_Pension1_Estimated_Payment_Op" type="number" class="form-control 1_Op_Pensions_inputs" name="Op_Pension1_Estimated_Payment_Op" value="0.00" min="0.00" step="0.01" max="100.00">   
                                </div> -->
                                <!-- End Pension Tool -->
                                <div class="form-group col-sm-6 1_Op_survivorship_plan_inputs_div" style="display: none;">
                                    <label for="Op_Pension1_Surv_Cost_Client">Pension Survivorship Cost {{$client_name}}</label>
                                    <input id="Op_Pension1_Surv_Cost_Client" type="number" class="form-control 1_Op_Pensions_inputs" name="Op_Pension1_Surv_Cost_Client" value="0.00" min="0.00" step="0.01" max="999999.99" onchange="onClientPensionSurvCostChange(this, '1', 'Op');" onkeyup="onClientPensionSurvCostChange(this, '1', 'Op');"> 
                                </div>
                                <div class="form-group col-sm-6 1_Op_survivorship_plan_inputs_div" style="display: none;">
                                    <label for="Op_Pension1_Surv_Cost_Op">Pension Survivorship Cost {{$opponent_name}}</label>
                                    <input id="Op_Pension1_Surv_Cost_Op" type="number" class="form-control 1_Op_Pensions_inputs" name="Op_Pension1_Surv_Cost_Op" value="0.00" min="0.00" step="0.01" max="999999.99" onchange="onOpponentPensionSurvCostChange(this, '1', 'Op');" onkeyup="onOpponentPensionSurvCostChange(this, '1', 'Op');"> 
                                </div>
                                <div class="form-group col-sm-6 Op_Pension1_Buyout_Op_Amount_Div" style="display: none;" style="display: none;">
                                    <label for="Op_Pension1_Buyout_Op_Amount">Pension Buyout {{$opponent_name}}’s Amount</label>
                                    <input id="Op_Pension1_Buyout_Op_Amount" type="number" class="form-control 1_Op_Pensions_inputs" name="Op_Pension1_Buyout_Op_Amount" value="0.00" min="0.00" step="0.01" max="999999.99"> 
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
                                        <label><input type="radio" id="1_Op_Pension_Estimated_Value_Select" name="1_Op_Pension_Estimated_Value_Select_Reset" class="Pension_Estimated_Value_Select_Reset" value="Save"> Save this Distribution of Pension Account #1</label>
                                        <label><input type="radio" id="1_Op_Pension_Estimated_Value_Reset" name="1_Op_Pension_Estimated_Value_Select_Reset" class="Pension_Estimated_Value_Select_Reset" value="Reset" onclick="resetBalanceInput(this, '1', 'Op');"> Reset to Default (Coverture)</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label>Pension Custom Monthly Client Percent</label>
                                    <input id="Op_Pension1_Custom_Monthly_Client_Percent" type="number" class="form-control 1_Op_clientpercentage_input clientpercentage_input" name="Op_Pension1_Custom_Monthly_Client_Percent" value="50.00" min="0.00" step="0.01" max="100" readonly="">
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label>Pension Custom Monthly Client Amount</label>
                                    <input id="Op_Pension1_Custom_Monthly_Client_Amount" type="number" class="form-control 1_Op_clientamount_input clientamount_input" name="Op_Pension1_Custom_Monthly_Client_Amount" value="" min="0.00" step="0.01" max="999999.99" readonly="">
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label>Pension Custom Monthly Opponent Percent</label>
                                    <input id="Op_Pension1_Custom_Monthly_Op_Percent" type="number" class="form-control 1_Op_opponentpercentage_input opponentpercentage_input" name="Op_Pension1_Custom_Monthly_Op_Percent" value="50.00" min="0.00" step="0.01" max="100" readonly="">
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label>Pension Custom Monthly Oppnent Amount</label>
                                    <input id="Op_Pension1_Custom_Monthly_Op_Amount" type="number" class="form-control 1_Op_opponentamount_input opponentamount_input" name="Op_Pension1_Custom_Monthly_Op_Amount" value="" min="0.00" step="0.01" max="999999.99" readonly="">
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Pension1_Estimated_Net_Client">Pension Estimated Net to {{$client_name}}</label>
                                    <input id="Op_Pension1_Estimated_Net_Client" type="number" class="form-control 1_Op_Pensions_inputs 1_Op_clientnetamount_input clientnetamount_input" name="Op_Pension1_Estimated_Net_Client" value="0.00" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Pension1_Estimated_Net_Op">Pension Estimated Net to {{$opponent_name}}</label>
                                    <input id="Op_Pension1_Estimated_Net_Op" type="number" class="form-control 1_Op_Pensions_inputs 1_Op_opponentnetamount_input opponentnetamount_input" name="Op_Pension1_Estimated_Net_Op" value="0.00" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <!-- end of slider tool -->
                            </div>
                            <div class="col-sm-12 mt-4 2_Op_Pensions_section" style="display: none;">
                                <h5 class="col-sm-12">Second Pension Info</h5>
                                <div class="form-group col-sm-6">
                                    <label>Pension is currently being paid out</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Op_Pension2_Is_Currently_Being_Paid_Out_Yes" name="Op_Pension2_Is_Currently_Being_Paid_Out" value="Yes"> Yes</label>
                                        <label><input type="radio" id="Op_Pension2_Is_Currently_Being_Paid_Out_No" name="Op_Pension2_Is_Currently_Being_Paid_Out" value="No" checked=""> No</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Pension2_Type">What type of pension?</label>
                                    <select id="Op_Pension2_Type" name="Op_Pension2_Type" class="form-control 2_Op_Pensions_select">
                                        <option value="">Select</option>
                                        <option value="Federal">Federal</option>
                                        <option value="State">State</option>
                                        <option value="Private">Private</option>
                                    </select>   
                                </div>
                                <div class="form-group col-sm-6">
                                    <p class="text-danger 2_Op_no-state-county-found" style="display: none;">No City, State, County found for this zipcode.</p>
                                    <label for="Op_Pension2_ZIP">Pension Institution Zip Code?</label>
                                    <input id="Op_Pension2_ZIP" type="text" class="form-control 2_Op_Pensions_inputs" name="Op_Pension2_ZIP" value="" onkeyup="getCityStateForZip(this, '2_Op');"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Pension2_Institution_Name">Name of Pension Institution?</label>
                                    <input id="Op_Pension2_Institution_Name" type="text" class="form-control 2_Op_Pensions_inputs" name="Op_Pension2_Institution_Name" value=""> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Pension2_Street_Address">Pension Institution Street Address?</label>
                                    <input id="Op_Pension2_Street_Address" type="text" class="form-control 2_Op_Pensions_inputs" name="Op_Pension2_Street_Address" value=""> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Pension2_City">Pension Institution City?</label>
                                    <select id="Op_Pension2_City" name="Op_Pension2_City" class="form-control 2_Op_city_select">
                                        <option value="">Choose City</option>
                                    </select>   
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Pension2_State">Pension Institution State?</label>
                                    <select id="Op_Pension2_State" name="Op_Pension2_State" class="form-control 2_Op_state_select">
                                        <option value="">Choose State</option>
                                    </select>   
                                </div>                                
                                <div class="form-group col-sm-6">
                                    <label for="Op_Pension2_Acct_Num">Account Number?</label>
                                    <input id="Op_Pension2_Acct_Num" type="text" class="form-control 2_Op_Pensions_inputs" name="Op_Pension2_Acct_Num" value=""> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Date_Begin_Earning_Pension2">When did you BEGIN earning this pension?</label>
                                    <input id="Op_Date_Begin_Earning_Pension2" type="text" class="form-control 2_Op_Pensions_inputs hasDatepicker" name="Op_Date_Begin_Earning_Pension2" value="" autocomplete="off" onchange="getConvertureDenomMonths(this, '2', 'Op')"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Pension2_Vest_Date">On what date did/does this Pension vest?</label>
                                    <input id="Op_Pension2_Vest_Date" type="text" class="form-control 2_Op_Pensions_inputs hasDatepicker" name="Op_Pension2_Vest_Date" value="" autocomplete="off" onchange="getConvertureDenomEndDate(this, '2', 'Op')"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Pension2_Earliest_Ret_Date">When is the earliest you CAN retire and receive this Pension?</label>
                                    <input id="Op_Pension2_Earliest_Ret_Date" type="text" class="form-control 2_Op_Pensions_inputs hasDatepicker" name="Op_Pension2_Earliest_Ret_Date" value="" autocomplete="off" onchange="getConvertureDenomEndDate(this, '2', 'Op')">
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label for="Op_Pension2_Coverture_Denom_End_Date">N/A = MIN(Op_Pension2_Vest_Date,Op_Pension2_Earliest_Ret_Date)</label>
                                    <input id="Op_Pension2_Coverture_Denom_End_Date" type="text" class="form-control 2_Op_Pensions_inputs" name="Op_Pension2_Coverture_Denom_End_Date" value="" autocomplete="off"> 
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label for="Op_Pension2_Coverture_Denom_Months">N/A = period_diff(date_format(Op_Pension2_Coverture_Denom_End_Date, ‘%Y%m’), date_format(Op_Date_Begin_Earning_Pension2, ‘%Ym’)))</label>
                                    <input id="Op_Pension2_Coverture_Denom_Months" type="number" class="form-control 2_Op_Pensions_inputs" name="Op_Pension2_Coverture_Denom_Months" value=""> 
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label for="Op_Pension2_Coverture_Num_Start_Date">N/A = MAX(dr_MarriageInfo.Marriage_Date,Op_Date_Begin_Earning_Pension2)</label>
                                    <input id="Op_Pension2_Coverture_Num_Start_Date" type="text" class="form-control 2_Op_Pensions_inputs" name="Op_Pension2_Coverture_Num_Start_Date" value="" autocomplete="off"> 
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label for="Op_Pension2_Coverture_Num_End_Date">N/A = MIN(dr_MarriageInfo.Date_of_Separation,Op_Pension2_Coverture_Denom_End_Date)</label>
                                    <input id="Op_Pension2_Coverture_Num_End_Date" type="text" class="form-control 2_Op_Pensions_inputs" name="Op_Pension2_Coverture_Num_End_Date" value="" autocomplete="off"> 
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label for="Op_Pension2_Coverture_Num_Months">N/A = period_diff(date_format(Op_Pension2_Coverture_Num_End_Date, ‘%Y%m’), date_format(Op_Pension2_Coverture_Num_Start_Date, ‘%Ym’))</label>
                                    <input id="Op_Pension2_Coverture_Num_Months" type="number" class="form-control 2_Op_Pensions_inputs" name="Op_Pension2_Coverture_Num_Months" value=""> 
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label for="Op_Pension2_Coverture_Fraction_Client_Default">N/A = 1-(Op_Pension2_Coverture_Num_Months/Op_Pension2_Coverture_Denom_Months)/2</label>
                                    <input id="Op_Pension2_Coverture_Fraction_Client_Default" type="number" class="form-control 2_Op_Pensions_inputs" name="Op_Pension2_Coverture_Fraction_Client_Default" value="0.0000" min="0.0000" step="0.0001" max="99.9999"> 
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label for="Op_Pension2_Coverture_Fraction_Op_Default">N/A = (Op_Pension2_Coverture_Num_Months/Op_Pension2_Coverture_Denom_Months)/2</label>
                                    <input id="Op_Pension2_Coverture_Fraction_Op_Default" type="number" class="form-control 2_Op_Pensions_inputs" name="Op_Pension2_Coverture_Fraction_Op_Default" value="0.0000" min="0.0000" step="0.0001" max="99.9999"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Pension2_Estimated_Monthly_Payment">Please provide the your best estimate of this Pension monthly payment.</label>
                                    <input id="Op_Pension2_Estimated_Monthly_Payment" type="number" class="form-control 2_Op_Pensions_inputs" name="Op_Pension2_Estimated_Monthly_Payment" value="0.00" min="0.00" step="0.01" max="999999.99" onchange="getEstimateMonthlyDefault(this, '2', 'Op');" onkeyup="getEstimateMonthlyDefault(this, '2', 'Op');"> 
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label for="Op_Pension2_Estimate_Monthly_Client_Default">N/A = Op_Pension2_Estimated_Monthly_Payment – (Op_Pension2_Coverture_Fraction_Client_Default * Op_Pension2_Estimated_Monthly_Payment)</label>
                                    <input id="Op_Pension2_Estimate_Monthly_Client_Default" type="number" class="form-control 2_Op_Pensions_inputs" name="Op_Pension2_Estimate_Monthly_Client_Default" value="0.00" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label for="Op_Pension2_Estimate_Monthly_Op_Default">N/A = (Op_Pension2_Coverture_Fraction_Op_Default * Op_Pension2_Estimated_Monthly_Payment)</label>

                                    $('#prev_filed_post_decree').prop("checked",true).trigger("change");
                                    <input id="Op_Pension2_Estimate_Monthly_Op_Default" type="number" class="form-control 2_Op_Pensions_inputs" name="Op_Pension2_Estimate_Monthly_Op_Default" value="0.00" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>What type of distribution will this be?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="" name="Op_Pension2_Disposition_Type" value="Coverture" onchange="onDistributionChange(this, '2', 'Op');"> Coverture</label>
                                        <label><input type="radio" id="" name="Op_Pension2_Disposition_Type" value="Custom %" onchange="onDistributionChange(this, '2', 'Op');"> Custom %</label>
                                        <label><input type="radio" id="" name="Op_Pension2_Disposition_Type" value="Custom Amount" onchange="onDistributionChange(this, '2', 'Op');"> Custom Amount</label>
                                        <label><input type="radio" id="" name="Op_Pension2_Disposition_Type" value="Buyout" onchange="onDistributionChange(this, '2', 'Op');"> Buyout</label>
                                        <label><input type="radio" id="" name="Op_Pension2_Disposition_Type" value="Owner Keeps" onchange="onDistributionChange(this, '2', 'Op');"> Owner Keeps</label>
                                    </div>
                                </div>

                                <div class="form-group col-sm-6 2_Op_Coverture_Date_Div" style="display: none;">
                                    <label>Which date to be used?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" class="2_Op_Coverture_Date_Input" name="Op_Pension2_Coverture_Date_Input" value="DateOfSeparation" onchange="onSeparationHearingDateChange(this, '2', 'Op');"> DateOfSeparation</label>
                                        <label><input type="radio" class="2_Op_Coverture_Date_Input" name="Op_Pension2_Coverture_Date_Input" value="FinalHearingDate" onchange="onSeparationHearingDateChange(this, '2', 'Op');"> FinalHearingDate</label>
                                    </div>
                                </div>
                                <!-- Pension Tool -->
                                <!-- <h5>Pension Tool</h5> -->    
                                <div class="form-group col-sm-6 2_Op_Pension_Has_Survivorship_Plan_Div" style="display: none;">
                                    <label>Check if this Pension has a Survivorship Plan.</label>
                                    <div class="w-100 dataInput">
                                        <label><input type="checkbox" id="" name="Op_Pension2_Has_Survivorship_Plan" value="1" onchange="PensionhasSurvivorshipPlan(this, '2', 'Op');"> Yes</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 2_Op_survivorship_plan_inputs_div" style="display: none;">
                                    <label>Percentage Cost of survivorship plan</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="" name="Op_Pension2_Survivorship_Plan_Percentage_Cost" value="Fixed Monthly Cost"> Fixed Monthly Cost</label>
                                        <label><input type="radio" id="" name="Op_Pension2_Survivorship_Plan_Percentage_Cost" value="Fixed Percentage of Benefit"> Fixed Percentage of Benefit</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 2_Op_survivorship_plan_inputs_div" style="display: none;">
                                    <label for="Op_Pension2_Survivorship_Plan_Monthly_Cost">Cost of survivorship plan</label>
                                    <input id="Op_Pension2_Survivorship_Plan_Monthly_Cost" type="number" onchange="getCostOfSurvivorshipPlan(this, '2', 'Op');" onkeyup="getCostOfSurvivorshipPlan(this, '2', 'Op');" class="form-control 2_Op_Pensions_inputs" name="Op_Pension2_Survivorship_Plan_Monthly_Cost" value="0.00" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6 2_Op_survivorship_plan_inputs_div" style="display: none;">
                                    <label>Payment options for Survivorship Plan</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="" name="Op_Pension2_Surv_Payer" value="Declined" onchange="PaymentOptionsForSurvivorshipPlan(this, '2', 'Op');"> Declined</label>
                                        <label><input type="radio" id="Op_Pension2_Surv_Payer_Op_Name" name="Op_Pension2_Surv_Payer" value="{{$opponent_name}}" onchange="PaymentOptionsForSurvivorshipPlan(this, '2', 'Op');"> {{$opponent_name}}</label>
                                         <label><input type="radio" id="" name="Op_Pension2_Surv_Payer" value="Both Parties Equally" onchange="PaymentOptionsForSurvivorshipPlan(this, '2', 'Op');"> Both Parties Equally</label>
                                        <label><input type="radio" id="Op_Pension2_Surv_Payer_Client_Name" name="Op_Pension2_Surv_Payer" value="{{$client_name}}" onchange="PaymentOptionsForSurvivorshipPlan(this, '2', 'Op');"> {{$client_name}}</label>
                                    </div>
                                </div>
                                <!-- <div class="form-group col-sm-6 2_Op_If_Buyout_Div" style="display: none;">
                                    <label for="Op_Pension2_Amount_To_Pay_Op">Amount to pay {{$opponent_name}}</label>
                                    <input id="Op_Pension2_Amount_To_Pay_Op" type="number" class="form-control 2_Op_Pensions_inputs" name="Op_Pension2_Amount_To_Pay_Op" value="0.00" min="0.00" step="0.01" max="999999.99">   
                                </div> -->
                                <!-- <div class="form-group col-sm-6 2_Op_Custom_Percentage_Div" style="display: none;">
                                    <label for="Op_Pension2_Custom_Percentage_Input">Amount to be paid by {{$opponent_name}} (%)</label>
                                    <input id="Op_Pension2_Custom_Percentage_Input" type="number" class="form-control 2_Op_Pensions_inputs" name="Op_Pension2_Amount_To_Pay_Percent_Op" value="0.00" min="0.00" step="0.01" max="100.00"  onchange="onCustomPercentageChange(this, '2', 'Op');" onkeyup="onCustomPercentageChange(this, '2', 'Op');">   
                                </div>
                                <div class="form-group col-sm-6 2_Op_Custom_Amount_Div" style="display: none;">
                                    <label for="Op_Pension2_Custom_Amount_Input">Amount to be paid by {{$opponent_name}} (per month)</label>
                                    <input id="Op_Pension2_Custom_Amount_Input" type="number" class="form-control 2_Op_Pensions_inputs" name="Op_Pension2_Amount_To_Pay_Per_Month_Op" value="0.00" min="0.00" step="0.01" max="999999.99"  onchange="onCustomAmountChange(this, '2', 'Op');" onkeyup="onCustomAmountChange(this, '2', 'Op');">   
                                </div> --> 
                                <!--<div class="form-group col-sm-2 2_Op_Coverture_Div 2_Op_Buyout_Div 2_Op_Owner_Keeps_Div" style="display: none;">
                                    <label for="">Converture %</label>
                                </div>
                                <div class="form-group col-sm-5 2_Op_Coverture_Div 2_Op_Buyout_Div 2_Op_Owner_Keeps_Div" style="display: none;">
                                    <label for="Op_Pension2_Converture_Percent_Client">{{$client_name}}</label>
                                    <input id="Op_Pension2_Converture_Percent_Client" type="number" class="form-control 2_Op_Pensions_inputs" name="Op_Pension2_Converture_Percent_Client" value="0.00" min="0.00" step="0.01" max="100.00">   
                                </div>
                                <div class="form-group col-sm-5 2_Op_Coverture_Div 2_Op_Buyout_Div 2_Op_Owner_Keeps_Div" style="display: none;">
                                    <label for="Op_Pension2_Converture_Percent_Op">{{$opponent_name}}</label>
                                    <input id="Op_Pension2_Converture_Percent_Op" type="number" class="form-control 2_Op_Pensions_inputs" name="Op_Pension2_Converture_Percent_Op" value="0.00" min="0.00" step="0.01" max="100.00">   
                                </div>
                                <div class="form-group col-sm-2 2_Op_Custom_Div" style="display: none;">
                                    <label for="">Estimated Monthly Net Payment</label>
                                </div>
                                <div class="form-group col-sm-5 2_Op_Custom_Div" style="display: none;">
                                    <label for="Op_Pension2_Estimated_Payment_Client">{{$client_name}}</label>
                                    <input id="Op_Pension2_Estimated_Payment_Client" type="number" class="form-control 2_Op_Pensions_inputs" name="Op_Pension2_Estimated_Payment_Client" value="0.00" min="0.00" step="0.01" max="100.00">   
                                </div>
                                <div class="form-group col-sm-5 2_Op_Custom_Div" style="display: none;">
                                    <label for="Op_Pension2_Estimated_Payment_Op">{{$opponent_name}}</label>
                                    <input id="Op_Pension2_Estimated_Payment_Op" type="number" class="form-control 2_Op_Pensions_inputs" name="Op_Pension2_Estimated_Payment_Op" value="0.00" min="0.00" step="0.01" max="100.00">   
                                </div> -->
                                <!-- End Pension Tool -->
                                <div class="form-group col-sm-6 2_Op_survivorship_plan_inputs_div" style="display: none;">
                                    <label for="Op_Pension2_Surv_Cost_Client">Pension Survivorship Cost {{$client_name}}</label>
                                    <input id="Op_Pension2_Surv_Cost_Client" type="number" class="form-control 2_Op_Pensions_inputs" name="Op_Pension2_Surv_Cost_Client" value="0.00" min="0.00" step="0.01" max="999999.99" onchange="onClientPensionSurvCostChange(this, '2', 'Op');" onkeyup="onClientPensionSurvCostChange(this, '2', 'Op');"> 
                                </div>
                                <div class="form-group col-sm-6 2_Op_survivorship_plan_inputs_div" style="display: none;">
                                    <label for="Op_Pension2_Surv_Cost_Op">Pension Survivorship Cost {{$opponent_name}}</label>
                                    <input id="Op_Pension2_Surv_Cost_Op" type="number" class="form-control 2_Op_Pensions_inputs" name="Op_Pension2_Surv_Cost_Op" value="0.00" min="0.00" step="0.01" max="999999.99" onchange="onOpponentPensionSurvCostChange(this, '2', 'Op');" onkeyup="onOpponentPensionSurvCostChange(this, '2', 'Op');"> 
                                </div>
                                <div class="form-group col-sm-6 Op_Pension2_Buyout_Op_Amount_Div" style="display: none;" style="display: none;">
                                    <label for="Op_Pension2_Buyout_Op_Amount">Pension Buyout {{$opponent_name}}’s Amount</label>
                                    <input id="Op_Pension2_Buyout_Op_Amount" type="number" class="form-control 2_Op_Pensions_inputs" name="Op_Pension2_Buyout_Op_Amount" value="0.00" min="0.00" step="0.01" max="999999.99"> 
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
                                        <label><input type="radio" id="2_Op_Pension_Estimated_Value_Select" name="2_Op_Pension_Estimated_Value_Select_Reset" class="Pension_Estimated_Value_Select_Reset" value="Save"> Save this Distribution of Pension Account #2</label>
                                        <label><input type="radio" id="2_Op_Pension_Estimated_Value_Reset" name="2_Op_Pension_Estimated_Value_Select_Reset" class="Pension_Estimated_Value_Select_Reset" value="Reset" onclick="resetBalanceInput(this, '2', 'Op');"> Reset to Default (Coverture)</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label>Pension Custom Monthly Client Percent</label>
                                    <input id="Op_Pension2_Custom_Monthly_Client_Percent" type="number" class="form-control 2_Op_clientpercentage_input clientpercentage_input" name="Op_Pension2_Custom_Monthly_Client_Percent" value="50.00" min="0.00" step="0.01" max="100" readonly="">
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label>Pension Custom Monthly Client Amount</label>
                                    <input id="Op_Pension2_Custom_Monthly_Client_Amount" type="number" class="form-control 2_Op_clientamount_input clientamount_input" name="Op_Pension2_Custom_Monthly_Client_Amount" value="" min="0.00" step="0.01" max="999999.99" readonly="">
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label>Pension Custom Monthly Opponent Percent</label>
                                    <input id="Op_Pension2_Custom_Monthly_Op_Percent" type="number" class="form-control 2_Op_opponentpercentage_input opponentpercentage_input" name="Op_Pension2_Custom_Monthly_Op_Percent" value="50.00" min="0.00" step="0.01" max="100" readonly="">
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label>Pension Custom Monthly Oppnent Amount</label>
                                    <input id="Op_Pension2_Custom_Monthly_Op_Amount" type="number" class="form-control 2_Op_opponentamount_input opponentamount_input" name="Op_Pension2_Custom_Monthly_Op_Amount" value="" min="0.00" step="0.01" max="999999.99" readonly="">
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Pension2_Estimated_Net_Client">Pension Estimated Net to {{$client_name}}</label>
                                    <input id="Op_Pension2_Estimated_Net_Client" type="number" class="form-control 2_Op_Pensions_inputs 2_Op_clientnetamount_input clientnetamount_input" name="Op_Pension2_Estimated_Net_Client" value="0.00" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Pension2_Estimated_Net_Op">Pension Estimated Net to {{$opponent_name}}</label>
                                    <input id="Op_Pension2_Estimated_Net_Op" type="number" class="form-control 2_Op_Pensions_inputs 2_Op_opponentnetamount_input opponentnetamount_input" name="Op_Pension2_Estimated_Net_Op" value="0.00" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <!-- end of slider tool -->
                            </div>
                            <div class="col-sm-12 mt-4 3_Op_Pensions_section" style="display: none;">
                                <h5 class="col-sm-12">Third Pension Info</h5>
                                <div class="form-group col-sm-6">
                                    <label>Pension is currently being paid out</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Op_Pension3_Is_Currently_Being_Paid_Out_Yes" name="Op_Pension3_Is_Currently_Being_Paid_Out" value="Yes"> Yes</label>
                                        <label><input type="radio" id="Op_Pension3_Is_Currently_Being_Paid_Out_No" name="Op_Pension3_Is_Currently_Being_Paid_Out" value="No" checked=""> No</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Pension3_Type">What type of pension?</label>
                                    <select id="Op_Pension3_Type" name="Op_Pension3_Type" class="form-control 3_Op_Pensions_select">
                                        <option value="">Select</option>
                                        <option value="Federal">Federal</option>
                                        <option value="State">State</option>
                                        <option value="Private">Private</option>
                                    </select>   
                                </div>
                                <div class="form-group col-sm-6">
                                    <p class="text-danger 3_Op_no-state-county-found" style="display: none;">No City, State, County found for this zipcode.</p>
                                    <label for="Op_Pension3_ZIP">Pension Institution Zip Code?</label>
                                    <input id="Op_Pension3_ZIP" type="text" class="form-control 3_Op_Pensions_inputs" name="Op_Pension3_ZIP" value="" onkeyup="getCityStateForZip(this, '3_Op');"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Pension3_Institution_Name">Name of Pension Institution?</label>
                                    <input id="Op_Pension3_Institution_Name" type="text" class="form-control 3_Op_Pensions_inputs" name="Op_Pension3_Institution_Name" value=""> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Pension3_Street_Address">Pension Institution Street Address?</label>
                                    <input id="Op_Pension3_Street_Address" type="text" class="form-control 3_Op_Pensions_inputs" name="Op_Pension3_Street_Address" value=""> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Pension3_City">Pension Institution City?</label>
                                    <select id="Op_Pension3_City" name="Op_Pension3_City" class="form-control 3_Op_city_select">
                                        <option value="">Choose City</option>
                                    </select>   
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Pension3_State">Pension Institution State?</label>
                                    <select id="Op_Pension3_State" name="Op_Pension3_State" class="form-control 3_Op_state_select">
                                        <option value="">Choose State</option>
                                    </select>   
                                </div>                                
                                <div class="form-group col-sm-6">
                                    <label for="Op_Pension3_Acct_Num">Account Number?</label>
                                    <input id="Op_Pension3_Acct_Num" type="text" class="form-control 3_Op_Pensions_inputs" name="Op_Pension3_Acct_Num" value=""> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Date_Begin_Earning_Pension3">When did you BEGIN earning this pension?</label>
                                    <input id="Op_Date_Begin_Earning_Pension3" type="text" class="form-control 3_Op_Pensions_inputs hasDatepicker" name="Op_Date_Begin_Earning_Pension3" value="" autocomplete="off" onchange="getConvertureDenomMonths(this, '3', 'Op')"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Pension3_Vest_Date">On what date did/does this Pension vest?</label>
                                    <input id="Op_Pension3_Vest_Date" type="text" class="form-control 3_Op_Pensions_inputs hasDatepicker" name="Op_Pension3_Vest_Date" value="" autocomplete="off" onchange="getConvertureDenomEndDate(this, '3', 'Op')"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Pension3_Earliest_Ret_Date">When is the earliest you CAN retire and receive this Pension?</label>
                                    <input id="Op_Pension3_Earliest_Ret_Date" type="text" class="form-control 3_Op_Pensions_inputs hasDatepicker" name="Op_Pension3_Earliest_Ret_Date" value="" autocomplete="off" onchange="getConvertureDenomEndDate(this, '3', 'Op')">
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label for="Op_Pension3_Coverture_Denom_End_Date">N/A = MIN(Op_Pension3_Vest_Date,Op_Pension3_Earliest_Ret_Date)</label>
                                    <input id="Op_Pension3_Coverture_Denom_End_Date" type="text" class="form-control 3_Op_Pensions_inputs" name="Op_Pension3_Coverture_Denom_End_Date" value="" autocomplete="off"> 
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label for="Op_Pension3_Coverture_Denom_Months">N/A = period_diff(date_format(Op_Pension3_Coverture_Denom_End_Date, ‘%Y%m’), date_format(Op_Date_Begin_Earning_Pension3, ‘%Ym’)))</label>
                                    <input id="Op_Pension3_Coverture_Denom_Months" type="number" class="form-control 3_Op_Pensions_inputs" name="Op_Pension3_Coverture_Denom_Months" value=""> 
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label for="Op_Pension3_Coverture_Num_Start_Date">N/A = MAX(dr_MarriageInfo.Marriage_Date,Op_Date_Begin_Earning_Pension3)</label>
                                    <input id="Op_Pension3_Coverture_Num_Start_Date" type="text" class="form-control 3_Op_Pensions_inputs" name="Op_Pension3_Coverture_Num_Start_Date" value="" autocomplete="off"> 
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label for="Op_Pension3_Coverture_Num_End_Date">N/A = MIN(dr_MarriageInfo.Date_of_Separation,Op_Pension3_Coverture_Denom_End_Date)</label>
                                    <input id="Op_Pension3_Coverture_Num_End_Date" type="text" class="form-control 3_Op_Pensions_inputs" name="Op_Pension3_Coverture_Num_End_Date" value="" autocomplete="off"> 
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label for="Op_Pension3_Coverture_Num_Months">N/A = period_diff(date_format(Op_Pension3_Coverture_Num_End_Date, ‘%Y%m’), date_format(Op_Pension3_Coverture_Num_Start_Date, ‘%Ym’))</label>
                                    <input id="Op_Pension3_Coverture_Num_Months" type="number" class="form-control 3_Op_Pensions_inputs" name="Op_Pension3_Coverture_Num_Months" value=""> 
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label for="Op_Pension3_Coverture_Fraction_Client_Default">N/A = 1-(Op_Pension3_Coverture_Num_Months/Op_Pension3_Coverture_Denom_Months)/2</label>
                                    <input id="Op_Pension3_Coverture_Fraction_Client_Default" type="number" class="form-control 3_Op_Pensions_inputs" name="Op_Pension3_Coverture_Fraction_Client_Default" value="0.0000" min="0.0000" step="0.0001" max="99.9999"> 
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label for="Op_Pension3_Coverture_Fraction_Op_Default">N/A = (Op_Pension3_Coverture_Num_Months/Op_Pension3_Coverture_Denom_Months)/2</label>
                                    <input id="Op_Pension3_Coverture_Fraction_Op_Default" type="number" class="form-control 3_Op_Pensions_inputs" name="Op_Pension3_Coverture_Fraction_Op_Default" value="0.0000" min="0.0000" step="0.0001" max="99.9999"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Pension3_Estimated_Monthly_Payment">Please provide the your best estimate of this Pension monthly payment.</label>
                                    <input id="Op_Pension3_Estimated_Monthly_Payment" type="number" class="form-control 3_Op_Pensions_inputs" name="Op_Pension3_Estimated_Monthly_Payment" value="0.00" min="0.00" step="0.01" max="999999.99" onchange="getEstimateMonthlyDefault(this, '3', 'Op');" onkeyup="getEstimateMonthlyDefault(this, '3', 'Op');"> 
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label for="Op_Pension3_Estimate_Monthly_Client_Default">N/A = Op_Pension3_Estimated_Monthly_Payment – (Op_Pension3_Coverture_Fraction_Client_Default * Op_Pension3_Estimated_Monthly_Payment)</label>
                                    <input id="Op_Pension3_Estimate_Monthly_Client_Default" type="number" class="form-control 3_Op_Pensions_inputs" name="Op_Pension3_Estimate_Monthly_Client_Default" value="0.00" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label for="Op_Pension3_Estimate_Monthly_Op_Default">N/A = (Op_Pension3_Coverture_Fraction_Op_Default * Op_Pension3_Estimated_Monthly_Payment)</label>
                                    <input id="Op_Pension3_Estimate_Monthly_Op_Default" type="number" class="form-control 3_Op_Pensions_inputs" name="Op_Pension3_Estimate_Monthly_Op_Default" value="0.00" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>What type of distribution will this be?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="" name="Op_Pension3_Disposition_Type" value="Coverture" onchange="onDistributionChange(this, '3', 'Op');"> Coverture</label>
                                        <label><input type="radio" id="" name="Op_Pension3_Disposition_Type" value="Custom %" onchange="onDistributionChange(this, '3', 'Op');"> Custom %</label>
                                        <label><input type="radio" id="" name="Op_Pension3_Disposition_Type" value="Custom Amount" onchange="onDistributionChange(this, '3', 'Op');"> Custom Amount</label>
                                        <label><input type="radio" id="" name="Op_Pension3_Disposition_Type" value="Buyout" onchange="onDistributionChange(this, '3', 'Op');"> Buyout</label>
                                        <label><input type="radio" id="" name="Op_Pension3_Disposition_Type" value="Owner Keeps"

                                        $('#prev_filed_post_decree').prop("checked",true).trigger("change"); onchange="onDistributionChange(this, '3', 'Op');"> Owner Keeps</label>
                                    </div>
                                </div>

                                <div class="form-group col-sm-6 3_Op_Coverture_Date_Div" style="display: none;">
                                    <label>Which date to be used?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" class="3_Op_Coverture_Date_Input" name="Op_Pension3_Coverture_Date_Input" value="DateOfSeparation" onchange="onSeparationHearingDateChange(this, '3', 'Op');"> DateOfSeparation</label>
                                        <label><input type="radio" class="3_Op_Coverture_Date_Input" name="Op_Pension3_Coverture_Date_Input" value="FinalHearingDate" onchange="onSeparationHearingDateChange(this, '3', 'Op');"> FinalHearingDate</label>
                                    </div>
                                </div>
                                <!-- Pension Tool -->
                                <!-- <h5>Pension Tool</h5> -->    
                                <div class="form-group col-sm-6 3_Op_Pension_Has_Survivorship_Plan_Div" style="display: none;">
                                    <label>Check if this Pension has a Survivorship Plan.</label>
                                    <div class="w-100 dataInput">
                                        <label><input type="checkbox" id="" name="Op_Pension3_Has_Survivorship_Plan" value="1" onchange="PensionhasSurvivorshipPlan(this, '3', 'Op');"> Yes</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 3_Op_survivorship_plan_inputs_div" style="display: none;">
                                    <label>Percentage Cost of survivorship plan</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="" name="Op_Pension3_Survivorship_Plan_Percentage_Cost" value="Fixed Monthly Cost"> Fixed Monthly Cost</label>
                                        <label><input type="radio" id="" name="Op_Pension3_Survivorship_Plan_Percentage_Cost" value="Fixed Percentage of Benefit"> Fixed Percentage of Benefit</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 3_Op_survivorship_plan_inputs_div" style="display: none;">
                                    <label for="Op_Pension3_Survivorship_Plan_Monthly_Cost">Cost of survivorship plan</label>
                                    <input id="Op_Pension3_Survivorship_Plan_Monthly_Cost" type="number" onchange="getCostOfSurvivorshipPlan(this, '3', 'Op');" onkeyup="getCostOfSurvivorshipPlan(this, '3', 'Op');" class="form-control 3_Op_Pensions_inputs" name="Op_Pension3_Survivorship_Plan_Monthly_Cost" value="0.00" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6 3_Op_survivorship_plan_inputs_div" style="display: none;">
                                    <label>Payment options for Survivorship Plan</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="" name="Op_Pension3_Surv_Payer" value="Declined" onchange="PaymentOptionsForSurvivorshipPlan(this, '3', 'Op');"> Declined</label>
                                        <label><input type="radio" id="Op_Pension3_Surv_Payer_Op_Name" name="Op_Pension3_Surv_Payer" value="{{$opponent_name}}" onchange="PaymentOptionsForSurvivorshipPlan(this, '3', 'Op');"> {{$opponent_name}}</label>
                                         <label><input type="radio" id="" name="Op_Pension3_Surv_Payer" value="Both Parties Equally" onchange="PaymentOptionsForSurvivorshipPlan(this, '3', 'Op');"> Both Parties Equally</label>
                                        <label><input type="radio" id="Op_Pension3_Surv_Payer_Client_Name" name="Op_Pension3_Surv_Payer" value="{{$client_name}}" onchange="PaymentOptionsForSurvivorshipPlan(this, '3', 'Op');"> {{$client_name}}</label>
                                    </div>
                                </div>
                                <!-- <div class="form-group col-sm-6 3_Op_If_Buyout_Div" style="display: none;">
                                    <label for="Op_Pension3_Amount_To_Pay_Op">Amount to pay {{$opponent_name}}</label>
                                    <input id="Op_Pension3_Amount_To_Pay_Op" type="number" class="form-control 3_Op_Pensions_inputs" name="Op_Pension3_Amount_To_Pay_Op" value="0.00" min="0.00" step="0.01" max="999999.99">   
                                </div> -->
                                <!-- <div class="form-group col-sm-6 3_Op_Custom_Percentage_Div" style="display: none;">
                                    <label for="Op_Pension3_Custom_Percentage_Input">Amount to be paid by {{$opponent_name}} (%)</label>
                                    <input id="Op_Pension3_Custom_Percentage_Input" type="number" class="form-control 3_Op_Pensions_inputs" name="Op_Pension3_Amount_To_Pay_Percent_Op" value="0.00" min="0.00" step="0.01" max="100.00"  onchange="onCustomPercentageChange(this, '3', 'Op');" onkeyup="onCustomPercentageChange(this, '3', 'Op');">   
                                </div>
                                <div class="form-group col-sm-6 3_Op_Custom_Amount_Div" style="display: none;">
                                    <label for="Op_Pension3_Custom_Amount_Input">Amount to be paid by {{$opponent_name}} (per month)</label>
                                    <input id="Op_Pension3_Custom_Amount_Input" type="number" class="form-control 3_Op_Pensions_inputs" name="Op_Pension3_Amount_To_Pay_Per_Month_Op" value="0.00" min="0.00" step="0.01" max="999999.99"  onchange="onCustomAmountChange(this, '3', 'Op');" onkeyup="onCustomAmountChange(this, '3', 'Op');">   
                                </div> --> 
                                <!--<div class="form-group col-sm-2 3_Op_Coverture_Div 3_Op_Buyout_Div 3_Op_Owner_Keeps_Div" style="display: none;">
                                    <label for="">Converture %</label>
                                </div>
                                <div class="form-group col-sm-5 3_Op_Coverture_Div 3_Op_Buyout_Div 3_Op_Owner_Keeps_Div" style="display: none;">
                                    <label for="Op_Pension3_Converture_Percent_Client">{{$client_name}}</label>
                                    <input id="Op_Pension3_Converture_Percent_Client" type="number" class="form-control 3_Op_Pensions_inputs" name="Op_Pension3_Converture_Percent_Client" value="0.00" min="0.00" step="0.01" max="100.00">   
                                </div>
                                <div class="form-group col-sm-5 3_Op_Coverture_Div 3_Op_Buyout_Div 3_Op_Owner_Keeps_Div" style="display: none;">
                                    <label for="Op_Pension3_Converture_Percent_Op">{{$opponent_name}}</label>
                                    <input id="Op_Pension3_Converture_Percent_Op" type="number" class="form-control 3_Op_Pensions_inputs" name="Op_Pension3_Converture_Percent_Op" value="0.00" min="0.00" step="0.01" max="100.00">   
                                </div>
                                <div class="form-group col-sm-2 3_Op_Custom_Div" style="display: none;">
                                    <label for="">Estimated Monthly Net Payment</label>
                                </div>
                                <div class="form-group col-sm-5 3_Op_Custom_Div" style="display: none;">
                                    <label for="Op_Pension3_Estimated_Payment_Client">{{$client_name}}</label>
                                    <input id="Op_Pension3_Estimated_Payment_Client" type="number" class="form-control 3_Op_Pensions_inputs" name="Op_Pension3_Estimated_Payment_Client" value="0.00" min="0.00" step="0.01" max="100.00">   
                                </div>
                                <div class="form-group col-sm-5 3_Op_Custom_Div" style="display: none;">
                                    <label for="Op_Pension3_Estimated_Payment_Op">{{$opponent_name}}</label>
                                    <input id="Op_Pension3_Estimated_Payment_Op" type="number" class="form-control 3_Op_Pensions_inputs" name="Op_Pension3_Estimated_Payment_Op" value="0.00" min="0.00" step="0.01" max="100.00">   
                                </div> -->
                                <!-- End Pension Tool -->
                                <div class="form-group col-sm-6 3_Op_survivorship_plan_inputs_div" style="display: none;">
                                    <label for="Op_Pension3_Surv_Cost_Client">Pension Survivorship Cost {{$client_name}}</label>
                                    <input id="Op_Pension3_Surv_Cost_Client" type="number" class="form-control 3_Op_Pensions_inputs" name="Op_Pension3_Surv_Cost_Client" value="0.00" min="0.00" step="0.01" max="999999.99" onchange="onClientPensionSurvCostChange(this, '3', 'Op');" onkeyup="onClientPensionSurvCostChange(this, '3', 'Op');"> 
                                </div>
                                <div class="form-group col-sm-6 3_Op_survivorship_plan_inputs_div" style="display: none;">
                                    <label for="Op_Pension3_Surv_Cost_Op">Pension Survivorship Cost {{$opponent_name}}</label>
                                    <input id="Op_Pension3_Surv_Cost_Op" type="number" class="form-control 3_Op_Pensions_inputs" name="Op_Pension3_Surv_Cost_Op" value="0.00" min="0.00" step="0.01" max="999999.99" onchange="onOpponentPensionSurvCostChange(this, '3', 'Op');" onkeyup="onOpponentPensionSurvCostChange(this, '3', 'Op');"> 
                                </div>
                                <div class="form-group col-sm-6 Op_Pension3_Buyout_Op_Amount_Div" style="display: none;" style="display: none;">
                                    <label for="Op_Pension3_Buyout_Op_Amount">Pension Buyout {{$opponent_name}}’s Amount</label>
                                    <input id="Op_Pension3_Buyout_Op_Amount" type="number" class="form-control 3_Op_Pensions_inputs" name="Op_Pension3_Buyout_Op_Amount" value="0.00" min="0.00" step="0.01" max="999999.99"> 
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
                                        <label><input type="radio" id="3_Op_Pension_Estimated_Value_Select" name="3_Op_Pension_Estimated_Value_Select_Reset" class="Pension_Estimated_Value_Select_Reset" value="Save"> Save this Distribution of Pension Account #3</label>
                                        <label><input type="radio" id="3_Op_Pension_Estimated_Value_Reset" name="3_Op_Pension_Estimated_Value_Select_Reset" class="Pension_Estimated_Value_Select_Reset" value="Reset" onclick="resetBalanceInput(this, '3', 'Op');"> Reset to Default (Coverture)</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label>Pension Custom Monthly Client Percent</label>
                                    <input id="Op_Pension3_Custom_Monthly_Client_Percent" type="number" class="form-control 3_Op_clientpercentage_input clientpercentage_input" name="Op_Pension3_Custom_Monthly_Client_Percent" value="50.00" min="0.00" step="0.01" max="100" readonly="">
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label>Pension Custom Monthly Client Amount</label>
                                    <input id="Op_Pension3_Custom_Monthly_Client_Amount" type="number" class="form-control 3_Op_clientamount_input clientamount_input" name="Op_Pension3_Custom_Monthly_Client_Amount" value="" min="0.00" step="0.01" max="999999.99" readonly="">
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label>Pension Custom Monthly Opponent Percent</label>
                                    <input id="Op_Pension3_Custom_Monthly_Op_Percent" type="number" class="form-control 3_Op_opponentpercentage_input opponentpercentage_input" name="Op_Pension3_Custom_Monthly_Op_Percent" value="50.00" min="0.00" step="0.01" max="100" readonly="">
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label>Pension Custom Monthly Oppnent Amount</label>
                                    <input id="Op_Pension3_Custom_Monthly_Op_Amount" type="number" class="form-control 3_Op_opponentamount_input opponentamount_input" name="Op_Pension3_Custom_Monthly_Op_Amount" value="" min="0.00" step="0.01" max="999999.99" readonly="">
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Pension3_Estimated_Net_Client">Pension Estimated Net to {{$client_name}}</label>
                                    <input id="Op_Pension3_Estimated_Net_Client" type="number" class="form-control 3_Op_Pensions_inputs 3_Op_clientnetamount_input clientnetamount_input" name="Op_Pension3_Estimated_Net_Client" value="0.00" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Pension3_Estimated_Net_Op">Pension Estimated Net to {{$opponent_name}}</label>
                                    <input id="Op_Pension3_Estimated_Net_Op" type="number" class="form-control 3_Op_Pensions_inputs 3_Op_opponentnetamount_input opponentnetamount_input" name="Op_Pension3_Estimated_Net_Op" value="0.00" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <!-- end of slider tool -->
                            </div>
                            <div class="col-sm-12 mt-4 4_Op_Pensions_section" style="display: none;">
                                <h5 class="col-sm-12">Fourth Pension Info</h5>
                                <div class="form-group col-sm-6">
                                    <label>Pension is currently being paid out</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Op_Pension4_Is_Currently_Being_Paid_Out_Yes" name="Op_Pension4_Is_Currently_Being_Paid_Out" value="Yes"> Yes</label>
                                        <label><input type="radio" id="Op_Pension4_Is_Currently_Being_Paid_Out_No" name="Op_Pension4_Is_Currently_Being_Paid_Out" value="No" checked=""> No</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Pension4_Type">What type of pension?</label>
                                    <select id="Op_Pension4_Type" name="Op_Pension4_Type" class="form-control 4_Op_Pensions_select">
                                        <option value="">Select</option>
                                        <option value="Federal">Federal</option>
                                        <option value="State">State</option>
                                        <option value="Private">Private</option>
                                    </select>   
                                </div>
                                <div class="form-group col-sm-6">
                                    <p class="text-danger 4_Op_no-state-county-found" style="display: none;">No City, State, County found for this zipcode.</p>
                                    <label for="Op_Pension4_ZIP">Pension Institution Zip Code?</label>
                                    <input id="Op_Pension4_ZIP" type="text" class="form-control 4_Op_Pensions_inputs" name="Op_Pension4_ZIP" value="" onkeyup="getCityStateForZip(this, '4_Op');"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Pension4_Institution_Name">Name of Pension Institution?</label>
                                    <input id="Op_Pension4_Institution_Name" type="text" class="form-control 4_Op_Pensions_inputs" name="Op_Pension4_Institution_Name" value=""> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Pension4_Street_Address">Pension Institution Street Address?</label>
                                    <input id="Op_Pension4_Street_Address" type="text" class="form-control 4_Op_Pensions_inputs" name="Op_Pension4_Street_Address" value=""> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Pension4_City">Pension Institution City?</label>
                                    <select id="Op_Pension4_City" name="Op_Pension4_City" class="form-control 4_Op_city_select">
                                        <option value="">Choose City</option>
                                    </select>   
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Pension4_State">Pension Institution State?</label>
                                    <select id="Op_Pension4_State" name="Op_Pension4_State" class="form-control 4_Op_state_select">
                                        <option value="">Choose State</option>
                                    </select>   
                                </div>                                
                                <div class="form-group col-sm-6">
                                    <label for="Op_Pension4_Acct_Num">Account Number?</label>
                                    <input id="Op_Pension4_Acct_Num" type="text" class="form-control 4_Op_Pensions_inputs" name="Op_Pension4_Acct_Num" value=""> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Date_Begin_Earning_Pension4">When did you BEGIN earning this pension?</label>
                                    <input id="Op_Date_Begin_Earning_Pension4" type="text" class="form-control 4_Op_Pensions_inputs hasDatepicker" name="Op_Date_Begin_Earning_Pension4" value="" autocomplete="off" onchange="getConvertureDenomMonths(this, '4', 'Op')"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Pension4_Vest_Date">On what date did/does this Pension vest?</label>
                                    <input id="Op_Pension4_Vest_Date" type="text" class="form-control 4_Op_Pensions_inputs hasDatepicker" name="Op_Pension4_Vest_Date" value="" autocomplete="off" onchange="getConvertureDenomEndDate(this, '4', 'Op')"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Pension4_Earliest_Ret_Date">When is the earliest you CAN retire and receive this Pension?</label>
                                    <input id="Op_Pension4_Earliest_Ret_Date" type="text" class="form-control 4_Op_Pensions_inputs hasDatepicker" name="Op_Pension4_Earliest_Ret_Date" value="" autocomplete="off" onchange="getConvertureDenomEndDate(this, '4', 'Op')">
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label for="Op_Pension4_Coverture_Denom_End_Date">N/A = MIN(Op_Pension4_Vest_Date,Op_Pension4_Earliest_Ret_Date)</label>
                                    <input id="Op_Pension4_Coverture_Denom_End_Date" type="text" class="form-control 4_Op_Pensions_inputs" name="Op_Pension4_Coverture_Denom_End_Date" value="" autocomplete="off"> 
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label for="Op_Pension4_Coverture_Denom_Months">N/A = period_diff(date_format(Op_Pension4_Coverture_Denom_End_Date, ‘%Y%m’), date_format(Op_Date_Begin_Earning_Pension4, ‘%Ym’)))</label>
                                    <input id="Op_Pension4_Coverture_Denom_Months" type="number" class="form-control 4_Op_Pensions_inputs" name="Op_Pension4_Coverture_Denom_Months" value=""> 
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label for="Op_Pension4_Coverture_Num_Start_Date">N/A = MAX(dr_MarriageInfo.Marriage_Date,Op_Date_Begin_Earning_Pension4)</label>
                                    <input id="Op_Pension4_Coverture_Num_Start_Date" type="text" class="form-control 4_Op_Pensions_inputs" name="Op_Pension4_Coverture_Num_Start_Date" value="" autocomplete="off"> 
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label for="Op_Pension4_Coverture_Num_End_Date">N/A = MIN(dr_MarriageInfo.Date_of_Separation,Op_Pension4_Coverture_Denom_End_Date)</label>
                                    <input id="Op_Pension4_Coverture_Num_End_Date" type="text" class="form-control 4_Op_Pensions_inputs" name="Op_Pension4_Coverture_Num_End_Date" value="" autocomplete="off"> 
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label for="Op_Pension4_Coverture_Num_Months">N/A = period_diff(date_format(Op_Pension4_Coverture_Num_End_Date, ‘%Y%m’), date_format(Op_Pension4_Coverture_Num_Start_Date, ‘%Ym’))</label>
                                    <input id="Op_Pension4_Coverture_Num_Months" type="number" class="form-control 4_Op_Pensions_inputs" name="Op_Pension4_Coverture_Num_Months" value=""> 
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label for="Op_Pension4_Coverture_Fraction_Client_Default">N/A = 1-(Op_Pension4_Coverture_Num_Months/Op_Pension4_Coverture_Denom_Months)/2</label>
                                    <input id="Op_Pension4_Coverture_Fraction_Client_Default" type="number" class="form-control 4_Op_Pensions_inputs" name="Op_Pension4_Coverture_Fraction_Client_Default" value="0.0000" min="0.0000" step="0.0001" max="99.9999"> 
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label for="Op_Pension4_Coverture_Fraction_Op_Default">N/A = (Op_Pension4_Coverture_Num_Months/Op_Pension4_Coverture_Denom_Months)/2</label>
                                    <input id="Op_Pension4_Coverture_Fraction_Op_Default" type="number" class="form-control 4_Op_Pensions_inputs" name="Op_Pension4_Coverture_Fraction_Op_Default" value="0.0000" min="0.0000" step="0.0001" max="99.9999"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Pension4_Estimated_Monthly_Payment">Please provide the your best estimate of this Pension monthly payment.</label>
                                    <input id="Op_Pension4_Estimated_Monthly_Payment" type="number" class="form-control 4_Op_Pensions_inputs" name="Op_Pension4_Estimated_Monthly_Payment" value="0.00" min="0.00" step="0.01" max="999999.99" onchange="getEstimateMonthlyDefault(this, '4', 'Op');" onkeyup="getEstimateMonthlyDefault(this, '4', 'Op');"> 
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label for="Op_Pension4_Estimate_Monthly_Client_Default">N/A = Op_Pension4_Estimated_Monthly_Payment – (Op_Pension4_Coverture_Fraction_Client_Default * Op_Pension4_Estimated_Monthly_Payment)</label>
                                    <input id="Op_Pension4_Estimate_Monthly_Client_Default" type="number" class="form-control 4_Op_Pensions_inputs" name="Op_Pension4_Estimate_Monthly_Client_Default" value="0.00" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label for="Op_Pension4_Estimate_Monthly_Op_Default">N/A = (Op_Pension4_Coverture_Fraction_Op_Default * Op_Pension4_Estimated_Monthly_Payment)</label>
                                    <input id="Op_Pension4_Estimate_Monthly_Op_Default" type="number" class="form-control 4_Op_Pensions_inputs" name="Op_Pension4_Estimate_Monthly_Op_Default" value="0.00" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>What type of distribution will this be?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="" name="Op_Pension4_Disposition_Type" value="Coverture" onchange="onDistributionChange(this, '4', 'Op');"> Coverture</label>
                                        <label><input type="radio" id="" name="Op_Pension4_Disposition_Type" value="Custom %" onchange="onDistributionChange(this, '4', 'Op');"> Custom %</label>
                                        <label><input type="radio" id="" name="Op_Pension4_Disposition_Type" value="Custom Amount" onchange="onDistributionChange(this, '4', 'Op');"> Custom Amount</label>
                                        <label><input type="radio" id="" name="Op_Pension4_Disposition_Type" value="Buyout" onchange="onDistributionChange(this, '4', 'Op');"> Buyout</label>
                                        <label><input type="radio" id="" name="Op_Pension4_Disposition_Type" value="Owner Keeps" onchange="onDistributionChange(this, '4', 'Op');"> Owner Keeps</label>
                                    </div>
                                </div>

                                <div class="form-group col-sm-6 4_Op_Coverture_Date_Div" style="display: none;">
                                    <label>Which date to be used?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" class="4_Op_Coverture_Date_Input" name="

                                            $('#prev_filed_post_decree').prop("checked",true).trigger("change");Op_Pension4_Coverture_Date_Input" value="DateOfSeparation" onchange="onSeparationHearingDateChange(this, '4', 'Op');"> DateOfSeparation</label>
                                        <label><input type="radio" class="4_Op_Coverture_Date_Input" name="Op_Pension4_Coverture_Date_Input" value="FinalHearingDate" onchange="onSeparationHearingDateChange(this, '4', 'Op');"> FinalHearingDate</label>
                                    </div>
                                </div>
                                <!-- Pension Tool -->
                                <!-- <h5>Pension Tool</h5> -->    
                                <div class="form-group col-sm-6 4_Op_Pension_Has_Survivorship_Plan_Div" style="display: none;">
                                    <label>Check if this Pension has a Survivorship Plan.</label>
                                    <div class="w-100 dataInput">
                                        <label><input type="checkbox" id="" name="Op_Pension4_Has_Survivorship_Plan" value="1" onchange="PensionhasSurvivorshipPlan(this, '4', 'Op');"> Yes</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 4_Op_survivorship_plan_inputs_div" style="display: none;">
                                    <label>Percentage Cost of survivorship plan</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="" name="Op_Pension4_Survivorship_Plan_Percentage_Cost" value="Fixed Monthly Cost"> Fixed Monthly Cost</label>
                                        <label><input type="radio" id="" name="Op_Pension4_Survivorship_Plan_Percentage_Cost" value="Fixed Percentage of Benefit"> Fixed Percentage of Benefit</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 4_Op_survivorship_plan_inputs_div" style="display: none;">
                                    <label for="Op_Pension4_Survivorship_Plan_Monthly_Cost">Cost of survivorship plan</label>
                                    <input id="Op_Pension4_Survivorship_Plan_Monthly_Cost" type="number" onchange="getCostOfSurvivorshipPlan(this, '4', 'Op');" onkeyup="getCostOfSurvivorshipPlan(this, '4', 'Op');" class="form-control 4_Op_Pensions_inputs" name="Op_Pension4_Survivorship_Plan_Monthly_Cost" value="0.00" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6 4_Op_survivorship_plan_inputs_div" style="display: none;">
                                    <label>Payment options for Survivorship Plan</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="" name="Op_Pension4_Surv_Payer" value="Declined" onchange="PaymentOptionsForSurvivorshipPlan(this, '4', 'Op');"> Declined</label>
                                        <label><input type="radio" id="Op_Pension4_Surv_Payer_Op_Name" name="Op_Pension4_Surv_Payer" value="{{$opponent_name}}" onchange="PaymentOptionsForSurvivorshipPlan(this, '4', 'Op');"> {{$opponent_name}}</label>
                                         <label><input type="radio" id="" name="Op_Pension4_Surv_Payer" value="Both Parties Equally" onchange="PaymentOptionsForSurvivorshipPlan(this, '4', 'Op');"> Both Parties Equally</label>
                                        <label><input type="radio" id="Op_Pension4_Surv_Payer_Client_Name" name="Op_Pension4_Surv_Payer" value="{{$client_name}}" onchange="PaymentOptionsForSurvivorshipPlan(this, '4', 'Op');"> {{$client_name}}</label>
                                    </div>
                                </div>
                                <!-- <div class="form-group col-sm-6 4_Op_If_Buyout_Div" style="display: none;">
                                    <label for="Op_Pension4_Amount_To_Pay_Op">Amount to pay {{$opponent_name}}</label>
                                    <input id="Op_Pension4_Amount_To_Pay_Op" type="number" class="form-control 4_Op_Pensions_inputs" name="Op_Pension4_Amount_To_Pay_Op" value="0.00" min="0.00" step="0.01" max="999999.99">   
                                </div> -->
                                <!-- <div class="form-group col-sm-6 4_Op_Custom_Percentage_Div" style="display: none;">
                                    <label for="Op_Pension4_Custom_Percentage_Input">Amount to be paid by {{$opponent_name}} (%)</label>
                                    <input id="Op_Pension4_Custom_Percentage_Input" type="number" class="form-control 4_Op_Pensions_inputs" name="Op_Pension4_Amount_To_Pay_Percent_Op" value="0.00" min="0.00" step="0.01" max="100.00"  onchange="onCustomPercentageChange(this, '4', 'Op');" onkeyup="onCustomPercentageChange(this, '4', 'Op');">   
                                </div>
                                <div class="form-group col-sm-6 4_Op_Custom_Amount_Div" style="display: none;">
                                    <label for="Op_Pension4_Custom_Amount_Input">Amount to be paid by {{$opponent_name}} (per month)</label>
                                    <input id="Op_Pension4_Custom_Amount_Input" type="number" class="form-control 4_Op_Pensions_inputs" name="Op_Pension4_Amount_To_Pay_Per_Month_Op" value="0.00" min="0.00" step="0.01" max="999999.99"  onchange="onCustomAmountChange(this, '4', 'Op');" onkeyup="onCustomAmountChange(this, '4', 'Op');">   
                                </div> --> 
                                <!--<div class="form-group col-sm-2 4_Op_Coverture_Div 4_Op_Buyout_Div 4_Op_Owner_Keeps_Div" style="display: none;">
                                    <label for="">Converture %</label>
                                </div>
                                <div class="form-group col-sm-5 4_Op_Coverture_Div 4_Op_Buyout_Div 4_Op_Owner_Keeps_Div" style="display: none;">
                                    <label for="Op_Pension4_Converture_Percent_Client">{{$client_name}}</label>
                                    <input id="Op_Pension4_Converture_Percent_Client" type="number" class="form-control 4_Op_Pensions_inputs" name="Op_Pension4_Converture_Percent_Client" value="0.00" min="0.00" step="0.01" max="100.00">   
                                </div>
                                <div class="form-group col-sm-5 4_Op_Coverture_Div 4_Op_Buyout_Div 4_Op_Owner_Keeps_Div" style="display: none;">
                                    <label for="Op_Pension4_Converture_Percent_Op">{{$opponent_name}}</label>
                                    <input id="Op_Pension4_Converture_Percent_Op" type="number" class="form-control 4_Op_Pensions_inputs" name="Op_Pension4_Converture_Percent_Op" value="0.00" min="0.00" step="0.01" max="100.00">   
                                </div>
                                <div class="form-group col-sm-2 4_Op_Custom_Div" style="display: none;">
                                    <label for="">Estimated Monthly Net Payment</label>
                                </div>
                                <div class="form-group col-sm-5 4_Op_Custom_Div" style="display: none;">
                                    <label for="Op_Pension4_Estimated_Payment_Client">{{$client_name}}</label>
                                    <input id="Op_Pension4_Estimated_Payment_Client" type="number" class="form-control 4_Op_Pensions_inputs" name="Op_Pension4_Estimated_Payment_Client" value="0.00" min="0.00" step="0.01" max="100.00">   
                                </div>
                                <div class="form-group col-sm-5 4_Op_Custom_Div" style="display: none;">
                                    <label for="Op_Pension4_Estimated_Payment_Op">{{$opponent_name}}</label>
                                    <input id="Op_Pension4_Estimated_Payment_Op" type="number" class="form-control 4_Op_Pensions_inputs" name="Op_Pension4_Estimated_Payment_Op" value="0.00" min="0.00" step="0.01" max="100.00">   
                                </div> -->
                                <!-- End Pension Tool -->
                                <div class="form-group col-sm-6 4_Op_survivorship_plan_inputs_div" style="display: none;">
                                    <label for="Op_Pension4_Surv_Cost_Client">Pension Survivorship Cost {{$client_name}}</label>
                                    <input id="Op_Pension4_Surv_Cost_Client" type="number" class="form-control 4_Op_Pensions_inputs" name="Op_Pension4_Surv_Cost_Client" value="0.00" min="0.00" step="0.01" max="999999.99" onchange="onClientPensionSurvCostChange(this, '4', 'Op');" onkeyup="onClientPensionSurvCostChange(this, '4', 'Op');"> 
                                </div>
                                <div class="form-group col-sm-6 4_Op_survivorship_plan_inputs_div" style="display: none;">
                                    <label for="Op_Pension4_Surv_Cost_Op">Pension Survivorship Cost {{$opponent_name}}</label>
                                    <input id="Op_Pension4_Surv_Cost_Op" type="number" class="form-control 4_Op_Pensions_inputs" name="Op_Pension4_Surv_Cost_Op" value="0.00" min="0.00" step="0.01" max="999999.99" onchange="onOpponentPensionSurvCostChange(this, '4', 'Op');" onkeyup="onOpponentPensionSurvCostChange(this, '4', 'Op');"> 
                                </div>
                                <div class="form-group col-sm-6 Op_Pension4_Buyout_Op_Amount_Div" style="display: none;" style="display: none;">
                                    <label for="Op_Pension4_Buyout_Op_Amount">Pension Buyout {{$opponent_name}}’s Amount</label>
                                    <input id="Op_Pension4_Buyout_Op_Amount" type="number" class="form-control 4_Op_Pensions_inputs" name="Op_Pension4_Buyout_Op_Amount" value="0.00" min="0.00" step="0.01" max="999999.99"> 
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
                                        <label><input type="radio" id="4_Op_Pension_Estimated_Value_Select" name="4_Op_Pension_Estimated_Value_Select_Reset" class="Pension_Estimated_Value_Select_Reset" value="Save"> Save this Distribution of Pension Account #4</label>
                                        <label><input type="radio" id="4_Op_Pension_Estimated_Value_Reset" name="4_Op_Pension_Estimated_Value_Select_Reset" class="Pension_Estimated_Value_Select_Reset" value="Reset" onclick="resetBalanceInput(this, '4', 'Op');"> Reset to Default (Coverture)</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label>Pension Custom Monthly Client Percent</label>
                                    <input id="Op_Pension4_Custom_Monthly_Client_Percent" type="number" class="form-control 4_Op_clientpercentage_input clientpercentage_input" name="Op_Pension4_Custom_Monthly_Client_Percent" value="50.00" min="0.00" step="0.01" max="100" readonly="">
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label>Pension Custom Monthly Client Amount</label>
                                    <input id="Op_Pension4_Custom_Monthly_Client_Amount" type="number" class="form-control 4_Op_clientamount_input clientamount_input" name="Op_Pension4_Custom_Monthly_Client_Amount" value="" min="0.00" step="0.01" max="999999.99" readonly="">
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label>Pension Custom Monthly Opponent Percent</label>
                                    <input id="Op_Pension4_Custom_Monthly_Op_Percent" type="number" class="form-control 4_Op_opponentpercentage_input opponentpercentage_input" name="Op_Pension4_Custom_Monthly_Op_Percent" value="50.00" min="0.00" step="0.01" max="100" readonly="">
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label>Pension Custom Monthly Oppnent Amount</label>
                                    <input id="Op_Pension4_Custom_Monthly_Op_Amount" type="number" class="form-control 4_Op_opponentamount_input opponentamount_input" name="Op_Pension4_Custom_Monthly_Op_Amount" value="" min="0.00" step="0.01" max="999999.99" readonly="">
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Pension4_Estimated_Net_Client">Pension Estimated Net to {{$client_name}}</label>
                                    <input id="Op_Pension4_Estimated_Net_Client" type="number" class="form-control 4_Op_Pensions_inputs 4_Op_clientnetamount_input clientnetamount_input" name="Op_Pension4_Estimated_Net_Client" value="0.00" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Pension4_Estimated_Net_Op">Pension Estimated Net to {{$opponent_name}}</label>
                                    <input id="Op_Pension4_Estimated_Net_Op" type="number" class="form-control 4_Op_Pensions_inputs 4_Op_opponentnetamount_input opponentnetamount_input" name="Op_Pension4_Estimated_Net_Op" value="0.00" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <!-- end of slider tool -->
                            </div>
                        </div>
                        <!-- End of Opponent Pensions Info Section -->

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

// If Client Opponent Has Any Pension
function getAnyPension(pension){
    if(pension.checked){
        $('#Num_Client_Pensions, #Num_Client_Pensions').val('0');
        $('.Client_Op_Pension').show();
    } else {
        $('#Num_Client_Pensions, #Num_Client_Pensions').val('0');
        $('.Client_Op_Pension').hide();
        $('#dr_Pensions input').prop('required',false);
        $('#dr_Pensions select').prop('required',false);
        $('#dr_Pensions select option[value=""]').prop('selected','selected');
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

// get converture denom end date on vest date and ret date change
function getConvertureDenomEndDate(input, number, type){
    var vest_date=$('#'+type+'_Pension'+number+'_Vest_Date').val();
    var ret_date=$('#'+type+'_Pension'+number+'_Earliest_Ret_Date').val();
    if(vest_date && ret_date){
        var dates=[];
        dates.push(new Date(vest_date));
        dates.push(new Date(ret_date)); 
        var coverture_denom_end_date=new Date(Math.min.apply(null,dates));
    } else {
        if(vest_date){
            var coverture_denom_end_date=new Date(vest_date);
        } else if(ret_date){
            var coverture_denom_end_date=new Date(ret_date);
        } else {
            var coverture_denom_end_date='';
        }
        
    }
    $('#'+type+'_Pension'+number+'_Coverture_Denom_End_Date').datepicker("setDate", coverture_denom_end_date);
    // to calculate denom months
    var earning_date=$('#'+type+'_Date_Begin_Earning_Pension'+number+'').val();
    if(earning_date){
        var earning_date=new Date(earning_date);
        var denom_months = diff_months(coverture_denom_end_date, earning_date);
        $('#'+type+'_Pension'+number+'_Coverture_Denom_Months').val(denom_months);
    } else {
        //alert('Enter When did you BEGIN earning this pension?');
    }
    // to calculate converture num end date
    var date_of_separation='{{$marriageinfo[0]->Date_of_Separation}}';
    if(date_of_separation){
        var dates1=[];
        dates1.push(new Date(coverture_denom_end_date));
        dates1.push(new Date(date_of_separation));     
        var coverture_num_end_date=new Date(Math.min.apply(null,dates1));
    } else {
        var coverture_num_end_date=new Date(coverture_denom_end_date);
    }
    
    $('#'+type+'_Pension'+number+'_Coverture_Num_End_Date').datepicker("setDate", coverture_num_end_date);

    // to calculate Coverture Num Months
    var coverture_num_start_date=$('#'+type+'_Pension'+number+'_Coverture_Num_Start_Date').val();
    if(coverture_num_end_date && coverture_num_start_date){
        var coverture_num_start_date=new Date(coverture_num_start_date);
        var converture_num_months = diff_months(coverture_num_end_date, coverture_num_start_date);
        $('#'+type+'_Pension'+number+'_Coverture_Num_Months').val(converture_num_months);
    }

    if(converture_num_months && denom_months){
        // to calculate Coverture Fraction Client Default
        var coverture_fraction_client_default=1-(converture_num_months/denom_months)/2;
        console.log(coverture_fraction_client_default);
        $('#'+type+'_Pension'+number+'_Coverture_Fraction_Client_Default').val(coverture_fraction_client_default);
        
        // to calculate Coverture Fraction Opponent Default
        var coverture_fraction_opponent_default=(converture_num_months/denom_months)/2;
        console.log(coverture_fraction_opponent_default);
        $('#'+type+'_Pension'+number+'_Coverture_Fraction_Op_Default').val(coverture_fraction_opponent_default);
    }

}

// on BEGIN earning this pension change
function getConvertureDenomMonths(input, number, type){
    var coverture_denom_end_date=$('#'+type+'_Pension'+number+'_Coverture_Denom_End_Date').val();
    // to calculate denom months
    var earning_date=$('#'+type+'_Date_Begin_Earning_Pension'+number+'').val();
    if(earning_date && coverture_denom_end_date){
        var coverture_denom_end_date=new Date(coverture_denom_end_date);
        var earning_date=new Date(earning_date);
        // var year1=coverture_denom_end_date.getFullYear();
        // var year2=earning_date.getFullYear();
        // var month1=coverture_denom_end_date.getMonth();
        // var month2=earning_date.getMonth();
        // if(month1===0){ //Have to take into account
        //   month1++;
        //   month2++;

        $('#prev_filed_post_decree').prop("checked",true).trigger("change");
        // }
        var denom_months=diff_months(coverture_denom_end_date, earning_date);
        // var denom_months = (year2 - year1) * 12 + (month2 - month1);
        $('#'+type+'_Pension'+number+'_Coverture_Denom_Months').val(denom_months);
    }
    if(earning_date){
        // to calculate converture num start date
        var marriage_date='{{$marriageinfo[0]->Marriage_Date}}';
        if(marriage_date){
            var dates1=[];
            dates1.push(new Date(earning_date));
            dates1.push(new Date(marriage_date)); 
            var coverture_num_start_date=new Date(Math.max.apply(null,dates1));
        } else {
            var coverture_num_start_date=new Date(earning_date);
        }
        
        $('#'+type+'_Pension'+number+'_Coverture_Num_Start_Date').datepicker("setDate", coverture_num_start_date);
    }

    // to calculate Coverture Num Months
    var coverture_num_end_date=$('#'+type+'_Pension'+number+'_Coverture_Num_End_Date').val();
    if(coverture_num_end_date && coverture_num_start_date){
        var coverture_num_end_date=new Date(coverture_num_end_date);
        var converture_num_months = diff_months(coverture_num_end_date, coverture_num_start_date);
        $('#'+type+'_Pension'+number+'_Coverture_Num_Months').val(converture_num_months);
    }

    if(converture_num_months && denom_months){
        // to calculate Coverture Fraction Client Default
        var coverture_fraction_client_default=1-(converture_num_months/denom_months)/2;
        console.log(coverture_fraction_client_default);
        $('#'+type+'_Pension'+number+'_Coverture_Fraction_Client_Default').val(coverture_fraction_client_default);
        
        // to calculate Coverture Fraction Opponent Default
        var coverture_fraction_opponent_default=(converture_num_months/denom_months)/2;
        console.log(coverture_fraction_opponent_default);
        $('#'+type+'_Pension'+number+'_Coverture_Fraction_Op_Default').val(coverture_fraction_opponent_default);
    }
}

// to get month difference between two dates
function diff_months(dt2, dt1){
    let date1 = dt1;
    let date2 = dt2;
    let yearsDiff =  date2.getFullYear() - date1.getFullYear();
    let months =(yearsDiff * 12) + (date2.getMonth() - date1.getMonth()) ;
    // console.log(months);
    months=Math.abs(months);
    return months;

    // var diff =(dt2.getTime() - dt1.getTime()) / 1000;
    // diff /= (60 * 60 * 24 * 7 * 4);
    // return Math.abs(Math.round(diff));

    // var dt1 = new Date(dt1);
    // var dd = String(dt1.getDate()).padStart(2, '0');
    var mm = String(dt1.getMonth() + 1).padStart(2, '0'); //January is 0!
    var yyyy = dt1.getFullYear();
    dt1 = mm + '/' + yyyy;

    // var dt2 = new Date(dt2);
    // var dd = String(dt2.getDate()).padStart(2, '0');
    var mm = String(dt2.getMonth() + 1).padStart(2, '0'); //January is 0!
    var yyyy = dt2.getFullYear();
    dt2 = mm + '/' + yyyy;

    var token= $('input[name=_token]').val();
    if (dt1 && dt2) {
        // var tmp = null;
        $.ajax({
            url:"{{route('ajax_get_period_diff')}}",
            method:"POST",
            // async: false,
            // dataType: 'json',
            data:{
                max_date: dt2, 
                min_date: dt1, 
                _token: token,
            },
            success: function(data){
                console.log(data);
                // tmp=data;
                $('#month_diff').val(data);
            }
        });
        var tmp=$('#month_diff').val();
        // $('#month_diff').val('');
        return tmp;
    }
  
}

// on Distribution Input Change
function onDistributionChange(input, number, type){
    $('.'+type+'_Pension'+number+'_Buyout_Op_Amount_Div').hide();
    $('.'+number+'_'+type+'_Coverture_Date_Div').hide();
    // $('.'+number+'_'+type+'_Custom_Percentage_Div').hide();
    // $('.'+number+'_'+type+'_Custom_Amount_Div').hide();
    $('.'+number+'_'+type+'_Coverture_Date_Input').prop('checked', false);
    $('input[name="'+type+'_Pension'+number+'_Has_Survivorship_Plan"]').prop('checked', false);
    $('#'+type+'_Pension'+number+'_Buyout_Op_Amount').val('0.00');
    if(input.checked && input.value!='Buyout' && input.value!='Owner Keeps'){
        $('.'+number+'_'+type+'_Pension_Has_Survivorship_Plan_Div').show();
    } else {
        //$('.'+number+'_'+type+'_Pension_Has_Survivorship_Plan_Div').hide();
    }

    if(input.checked && input.value=='Custom %'){
        // $('.'+number+'_'+type+'_Custom_Percentage_Div').show();

    }

    if(input.checked && input.value=='Custom Amount'){
        // $('.'+number+'_'+type+'_Custom_Amount_Div').show();

    }

    if(input.checked && input.value=='Coverture'){
        $('.'+number+'_'+type+'_Coverture_Date_Div').show();
    }

    if(input.checked && input.value=='Buyout'){
        $('.'+type+'_Pension'+number+'_Buyout_Op_Amount_Div').show();
        $('.'+number+'_'+type+'_Pension_Has_Survivorship_Plan_Div').hide();
        $('.'+number+'_'+type+'_survivorship_plan_inputs_div').hide();
    }

    if(input.checked && (input.value=='Owner Keeps' || input.value=='Buyout')){
        var sliderclass=number+'_'+type;
        if(type=='Client'){
            value=0;
        } else {
            value=100;
        }
        if(value <= 100){
            var value=parseFloat(value).toFixed(2);
            var monthly_pension=$('#'+type+'_Pension'+number+'_Estimated_Monthly_Payment').val();
            $('.'+sliderclass+'_opponentpercentage_input').val(value);
            $('.'+sliderclass+'_opponentpercentage_div').text(value+'%');
            var client_pension_percentage_new=100-value;
            client_pension_percentage_new=parseFloat(client_pension_percentage_new).toFixed(2);
            $('.'+sliderclass+'_balance_range_selector').val(client_pension_percentage_new);
            $('.'+sliderclass+'_clientpercentage_input').val(client_pension_percentage_new);
            $('.'+sliderclass+'_clientpercentage_div').text(client_pension_percentage_new+'%');
            monthly_pension=parseFloat(monthly_pension);
            var client_pension_amount_new = monthly_pension - (monthly_pension * value/100);
            var opponent_pension_amount = monthly_pension - (monthly_pension * client_pension_percentage_new/100);
            opponent_pension_amount=parseFloat(opponent_pension_amount).toFixed(2);
            client_pension_amount_new=parseFloat(client_pension_amount_new).toFixed(2);
            $('.'+sliderclass+'_opponentamount_input').val(opponent_pension_amount);
            $('.'+sliderclass+'_clientamount_input').val(client_pension_amount_new);
            $('.'+sliderclass+'_opponentamount_div').text(formatter.format(opponent_pension_amount));
            $('.'+sliderclass+'_clientamount_div').text(formatter.format(client_pension_amount_new));

            // to calculate net value
            var client_surv_cost=$('#'+type+'_Pension'+number+'_Surv_Cost_Client').val();
            client_surv_cost=parseFloat(client_surv_cost).toFixed(2);
            var net_value=client_pension_amount_new-client_surv_cost;
            net_value=parseFloat(net_value).toFixed(2);
            $('#'+type+'_Pension'+number+'_Estimated_Net_Client').val(net_value);

            var opponent_surv_cost=$('#'+type+'_Pension'+number+'_Surv_Cost_Op').val();
            opponent_surv_cost=parseFloat(opponent_surv_cost).toFixed(2);
            var net_value=opponent_pension_amount-opponent_surv_cost;
            net_value=parseFloat(net_value).toFixed(2);
            $('#'+type+'_Pension'+number+'_Estimated_Net_Op').val(net_value);

        }
    }
}

// on Separation/Hearing Date Input Change
function onSeparationHearingDateChange(input, number, type){
    if(input.checked && input.value=='DateOfSeparation'){
        //Cfnum=MONTHS(MIN{[DateOfSeparation or FinalHearingDate], PensionVestDate) - MAX(DateOfMarriage, PensionStartDate})

        // CFden=MONTHS(PensionVestDate – PensionStartDate)

        // CF=0.5*(CFnum/CFden)
        var vest_date=$('#'+type+'_Pension'+number+'_Vest_Date').val();
        var date_of_separation='{{$marriageinfo[0]->Date_of_Separation}}';
        if(date_of_separation){
            var dates1=[];
            dates1.push(new Date(vest_date));
            dates1.push(new Date(date_of_separation));     
            var min_date=new Date(Math.min.apply(null,dates1));
        } else {
            var min_date=new Date(vest_date);
        }

        var pension_date=$('#'+type+'_Date_Begin_Earning_Pension'+number+'').val();
        var marriage_date='{{$marriageinfo[0]->Marriage_Date}}';
        if(marriage_date){
            var dates1=[];
            dates1.push(new Date(pension_date));
            dates1.push(new Date(marriage_date)); 
            var max_date=new Date(Math.max.apply(null,dates1));
        } else {
            var max_date=new Date(pension_date);
        }

        // var cfnum = diff_months(min_date, max_date);
        var cfnum = diff_months(max_date, min_date);
    }

    if(input.checked && input.value=='FinalHearingDate'){

        var vest_date=$('#'+type+'_Pension'+number+'_Vest_Date').val();
        var final_hearing_date='{{$case_data->final_hearing_date}}';
        if(final_hearing_date){
            var dates1=[];
            dates1.push(new Date(vest_date));
            dates1.push(new Date(final_hearing_date));     
            var min_date=new Date(Math.min.apply(null,dates1));
        } else {
            alert('Final Hearing Date is not set for this case. Please go to edit core case detail to add Final Hearing Date.');
            var min_date=new Date(vest_date);
        }

        var pension_date=$('#'+type+'_Date_Begin_Earning_Pension'+number+'').val();
        var marriage_date='{{$marriageinfo[0]->Marriage_Date}}';
        if(marriage_date){
            var dates1=[];
            dates1.push(new Date(pension_date));
            dates1.push(new Date(marriage_date)); 
            var max_date=new Date(Math.max.apply(null,dates1));
        } else {
            var max_date=new Date(pension_date);
        }

        // var cfnum = diff_months(min_date, max_date);
        var cfnum = diff_months(max_date, min_date);
        
    }
    // CFden=MONTHS(PensionVestDate – PensionStartDate)
    var vest_date=$('#'+type+'_Pension'+number+'_Vest_Date').val();
    var vest_date=new Date(vest_date);
    var pension_date=$('#'+type+'_Date_Begin_Earning_Pension'+number+'').val();
    var pension_date=new Date(pension_date);
    var cfden = diff_months(vest_date, pension_date);
    if(cfnum/cfden){
        // var cf=0.5*(cfnum/cfden);
        var cf=(cfnum/(cfden*2));
    } else {
        cf=0.5;
    }
    var sliderclass=number+'_'+type;
    if(cf <= 100){
        if(type=='Op'){
            var cf=100-cf;
        }
        var cf=cf*100;
        var cf=parseFloat(cf).toFixed(2);
        $('.'+sliderclass+'_balance_range_selector, .'+sliderclass+'_opponentpercentage_input, .'+sliderclass+'_clientpercentage_input').val(cf);
        var monthly_pension=$('#'+type+'_Pension'+number+'_Estimated_Monthly_Payment').val();
        $('.'+sliderclass+'_opponentpercentage_input').val(cf);
        $('.'+sliderclass+'_opponentpercentage_div').text(cf+'%');
        var client_pension_percentage_new=100-cf;
        client_pension_percentage_new=parseFloat(client_pension_percentage_new).toFixed(2);
        $('.'+sliderclass+'_clientpercentage_input').val(client_pension_percentage_new);
        $('.'+sliderclass+'_clientpercentage_div').text(client_pension_percentage_new+'%');
        monthly_pension=parseFloat(monthly_pension);
        var client_pension_amount_new = monthly_pension - (monthly_pension * cf/100);
        var opponent_pension_amount = monthly_pension - (monthly_pension * client_pension_percentage_new/100);
        opponent_pension_amount=parseFloat(opponent_pension_amount).toFixed(2);
        client_pension_amount_new=parseFloat(client_pension_amount_new).toFixed(2);
        $('.'+sliderclass+'_opponentamount_input').val(opponent_pension_amount);
        $('.'+sliderclass+'_clientamount_input').val(client_pension_amount_new);
        $('.'+sliderclass+'_opponentamount_div').text(formatter.format(opponent_pension_amount));
        $('.'+sliderclass+'_clientamount_div').text(formatter.format(client_pension_amount_new));
    }

}

// get client/oppponent amount based on custom percentage
function onCustomPercentageChange(input, number, type){
    var sliderclass=number+'_'+type;
    var value=input.value;
    //var value=100-value;
    if(value <= 100){
        var value=parseFloat(value).toFixed(2);
        $('.'+sliderclass+'_balance_range_selector, .'+sliderclass+'_opponentpercentage_input, .'+sliderclass+'_clientpercentage_input').val(value);
        var monthly_pension=$('#'+type+'_Pension'+number+'_Estimated_Monthly_Payment').val();
        $('.'+sliderclass+'_opponentpercentage_input').val(value);
        $('.'+sliderclass+'_opponentpercentage_div').text(value+'%');
        var client_pension_percentage_new=100-value;
        client_pension_percentage_new=parseFloat(client_pension_percentage_new).toFixed(2);
        $('.'+sliderclass+'_clientpercentage_input').val(client_pension_percentage_new);
        $('.'+sliderclass+'_clientpercentage_div').text(client_pension_percentage_new+'%');
        monthly_pension=parseFloat(monthly_pension);
        var client_pension_amount_new = monthly_pension - (monthly_pension * value/100);
        var opponent_pension_amount = monthly_pension - (monthly_pension * client_pension_percentage_new/100);
        opponent_pension_amount=parseFloat(opponent_pension_amount).toFixed(2);
        client_pension_amount_new=parseFloat(client_pension_amount_new).toFixed(2);
        $('.'+sliderclass+'_opponentamount_input').val(opponent_pension_amount);
        $('.'+sliderclass+'_clientamount_input').val(client_pension_amount_new);
        $('.'+sliderclass+'_opponentamount_div').text(formatter.format(opponent_pension_amount));
        $('.'+sliderclass+'_clientamount_div').text(formatter.format(client_pension_amount_new));
    }

}

// get client/oppponent amount based on custom amount
function onCustomAmountChange(input, number, type){
    var custom_amount=input.value;
    var custom_amount=parseFloat(custom_amount).toFixed(2);
    var monthly_pension=$('#'+type+'_Pension'+number+'_Estimated_Monthly_Payment').val();
    var pensionclass=number+'_'+type;
    var current_pension=parseFloat(monthly_pension).toFixed(2);
    if(parseFloat(current_pension) < parseFloat(custom_amount)){
        alert('Enter Amount Less Than '+current_pension+'');
    } else {
        var client_pension_amount=current_pension-custom_amount;
        var opponent_pension_amount=custom_amount;
        opponent_pension_amount=parseFloat(opponent_pension_amount).toFixed(2);
        client_pension_amount=parseFloat(client_pension_amount).toFixed(2);
        var opponent_pension_percentage=(((opponent_pension_amount)/monthly_pension)*100);
        opponent_pension_percentage=parseFloat(opponent_pension_percentage).toFixed(2);
        var client_pension_percentage=100-opponent_pension_percentage;
        client_pension_percentage=parseFloat(client_pension_percentage).toFixed(2);
        $('.'+pensionclass+'_balance_range_selector').val(opponent_pension_percentage);
        $('.'+pensionclass+'_clientpercentage_input').val(client_pension_percentage);
        $('.'+pensionclass+'_opponentpercentage_input').val(opponent_pension_percentage);
        $('.'+pensionclass+'_opponentpercentage_div').text(opponent_pension_percentage);
        $('.'+pensionclass+'_clientpercentage_div').text(client_pension_percentage);
        $('.'+pensionclass+'_opponentamount_input').val(opponent_pension_amount);
        $('.'+pensionclass+'_clientamount_input').val(client_pension_amount);
        $('.'+pensionclass+'_opponentamount_div').text(formatter.format(opponent_pension_amount));
        $('.'+pensionclass+'_clientamount_div').text(formatter.format(client_pension_amount));
    }

}

// show survivorship related inputs if pension has survivorship plan
function PensionhasSurvivorshipPlan(input, number, type){
    if(input.checked){
        $('.'+number+'_'+type+'_survivorship_plan_inputs_div').show();
    } else {
        $('.'+number+'_'+type+'_survivorship_plan_inputs_div').hide();
        $('#'+type+'_Pension'+number+'_Surv_Cost_Client').val('0.00');
        $('#'+type+'_Pension'+number+'_Surv_Cost_Op').val('0.00');
    }
}


function getCostOfSurvivorshipPlan(input, number, type){
    $('input[name="'+type+'_Pension'+number+'_Surv_Payer"]').prop("checked",false);
    $('input[name="'+type+'_Pension'+number+'_Surv_Payer"][value="Declined"]').prop("checked",true).trigger("change");
}

function PaymentOptionsForSurvivorshipPlan(input, number, type){
    var plan_percentage_cost=$('#'+type+'_Pension'+number+'_Survivorship_Plan_Percentage_Cost').val();
    var plan_monthly_cost=$('#'+type+'_Pension'+number+'_Survivorship_Plan_Monthly_Cost').val();
    if(plan_monthly_cost && plan_monthly_cost !=''){
        plan_monthly_cost=plan_monthly_cost;
    } else {
        plan_monthly_cost=0;
    }
    if(input.checked && input.value=='Declined'){
        $('#'+type+'_Pension'+number+'_Surv_Cost_Client').val('0.00');
        $('#'+type+'_Pension'+number+'_Surv_Cost_Op').val('0.00');
        $('#'+type+'_Pension'+number+'_Surv_Cost_Client').prop("readonly",false).trigger("change");
        $('#'+type+'_Pension'+number+'_Surv_Cost_Op').prop("readonly",false).trigger("change");
    }
    if(input.checked && input.value=='Both Parties Equally'){
        var plan_monthly_cost=parseFloat(plan_monthly_cost).toFixed(2);
        var equal_plan_monthly_cost=plan_monthly_cost/2;
        var equal_plan_monthly_cost_client=parseFloat(equal_plan_monthly_cost).toFixed(2);
        var equal_plan_monthly_cost_op=plan_monthly_cost-equal_plan_monthly_cost_client;
        var equal_plan_monthly_cost_op=parseFloat(equal_plan_monthly_cost_op).toFixed(2);
        $('#'+type+'_Pension'+number+'_Surv_Cost_Client').val(equal_plan_monthly_cost_client);
        $('#'+type+'_Pension'+number+'_Surv_Cost_Op').val(equal_plan_monthly_cost_op);
        $('#'+type+'_Pension'+number+'_Surv_Cost_Client').prop("readonly",false).trigger("change");
        $('#'+type+'_Pension'+number+'_Surv_Cost_Op').prop("readonly",false).trigger("change");
    }
    if(input.checked && input.id==''+type+'_Pension'+number+'_Surv_Payer_Op_Name'){
        var plan_monthly_cost=parseFloat(plan_monthly_cost).toFixed(2);
        $('#'+type+'_Pension'+number+'_Surv_Cost_Client').val('0.00');
        $('#'+type+'_Pension'+number+'_Surv_Cost_Op').val(plan_monthly_cost);
        $('#'+type+'_Pension'+number+'_Surv_Cost_Client').prop("readonly",false).trigger("change");
        $('#'+type+'_Pension'+number+'_Surv_Cost_Op').prop("readonly",false).trigger("change");
    }
    if(input.checked && input.id==''+type+'_Pension'+number+'_Surv_Payer_Client_Name'){
        var plan_monthly_cost=parseFloat(plan_monthly_cost).toFixed(2);
        $('#'+type+'_Pension'+number+'_Surv_Cost_Client').val(plan_monthly_cost);
        $('#'+type+'_Pension'+number+'_Surv_Cost_Op').val('0.00');
        $('#'+type+'_Pension'+number+'_Surv_Cost_Client').prop("readonly",false).trigger("change");
        $('#'+type+'_Pension'+number+'_Surv_Cost_Op').prop("readonly",false).trigger("change");
    }
}


// to calculate Estimate Monthly Default
function getEstimateMonthlyDefault(pension, pensionnum, pensiontype){
    var estimated_monthly_payment=pension.value;
    var fraction_client_default=$('#'+pensiontype+'_Pension'+pensionnum+'_Coverture_Fraction_Client_Default').val();
    var fraction_op_default=$('#'+pensiontype+'_Pension'+pensionnum+'_Coverture_Fraction_Op_Default').val();
    var monthly_client_default=estimated_monthly_payment-(fraction_client_default*estimated_monthly_payment);
    var monthly_op_default=(fraction_op_default*estimated_monthly_payment);
    $('#'+pensiontype+'_Pension'+pensionnum+'_Estimate_Monthly_Client_Default').val(monthly_client_default);
    $('#'+pensiontype+'_Pension'+pensionnum+'_Estimate_Monthly_Op_Default').val(monthly_op_default);


    var pensionclass=pensionnum+'_'+pensiontype;
    $('.'+pensionclass+'_balance_range_selector, .'+pensionclass+'_opponentpercentage_input, .'+pensionclass+'_clientpercentage_input').val('50.00');
    $('.'+pensionclass+'_opponentpercentage_div, .'+pensionclass+'_clientpercentage_div').text('50.00%');
    var current_pension=parseFloat(pension.value).toFixed(2);
    var client_pension_amount=current_pension/2;
    var opponent_pension_amount=current_pension/2;
    client_pension_amount=parseFloat(client_pension_amount).toFixed(2);
    opponent_pension_amount=parseFloat(opponent_pension_amount).toFixed(2);
    $('.'+pensionclass+'_clientamount_input').val(client_pension_amount);
    $('.'+pensionclass+'_opponentamount_input').val(opponent_pension_amount);
    $('.'+pensionclass+'_clientamount_div').text(formatter.format(client_pension_amount));
    $('.'+pensionclass+'_opponentamount_div').text(formatter.format(opponent_pension_amount));

    // to calculate net value
    var client_surv_cost=$('#'+pensiontype+'_Pension'+pensionnum+'_Surv_Cost_Client').val();
    client_surv_cost=parseFloat(client_surv_cost).toFixed(2);

    var client_pension_cost=$('#'+pensiontype+'_Pension'+pensionnum+'_Custom_Monthly_Client_Amount').val();
    client_pension_cost=parseFloat(client_pension_cost).toFixed(2);
    var net_value=client_pension_cost-client_surv_cost;
    net_value=parseFloat(net_value).toFixed(2);
    $('#'+pensiontype+'_Pension'+pensionnum+'_Estimated_Net_Client').val(net_value);

    var opponent_surv_cost=$('#'+pensiontype+'_Pension'+pensionnum+'_Surv_Cost_Op').val();
    opponent_surv_cost=parseFloat(opponent_surv_cost).toFixed(2);

    var opponent_pension_cost=$('#'+pensiontype+'_Pension'+pensionnum+'_Custom_Monthly_Op_Amount').val();
    opponent_pension_cost=parseFloat(opponent_pension_cost).toFixed(2);
    var net_value=opponent_pension_cost-opponent_surv_cost;
    net_value=parseFloat(net_value).toFixed(2);
    $('#'+pensiontype+'_Pension'+pensionnum+'_Estimated_Net_Op').val(net_value);

    // to make type of distribution unchecked
    $('input[name="'+pensiontype+'_Pension'+pensionnum+'_Disposition_Type"]').prop("checked",false).trigger("change");
    $('.'+pensiontype+'_Pension'+pensionnum+'_Buyout_Op_Amount_Div').hide();
    $('.'+pensionnum+'_'+pensiontype+'_Pension_Has_Survivorship_Plan_Div').hide();
    $('.'+pensionnum+'_'+pensiontype+'_survivorship_plan_inputs_div').hide();
}

// Calulations based on Client Pension Surv Cost Change
function onClientPensionSurvCostChange(pension, pensionnum, pensiontype){
    var client_pension_cost=$('#'+pensiontype+'_Pension'+pensionnum+'_Custom_Monthly_Client_Amount').val();
    client_pension_cost=parseFloat(client_pension_cost).toFixed(2);
    var surv_cost=parseFloat(pension.value).toFixed(2);
    var net_value=client_pension_cost-surv_cost;
    net_value=parseFloat(net_value).toFixed(2);
    $('#'+pensiontype+'_Pension'+pensionnum+'_Estimated_Net_Client').val(net_value);
}

// Calulations based on Opponent Pension Surv Cost Change
function onOpponentPensionSurvCostChange(pension, pensionnum, pensiontype){
    var opponent_pension_cost=$('#'+pensiontype+'_Pension'+pensionnum+'_Custom_Monthly_Op_Amount').val();
    opponent_pension_cost=parseFloat(opponent_pension_cost).toFixed(2);
    var surv_cost=parseFloat(pension.value).toFixed(2);
    var net_value=opponent_pension_cost-surv_cost;
    net_value=parseFloat(net_value).toFixed(2);
    $('#'+pensiontype+'_Pension'+pensionnum+'_Estimated_Net_Op').val(net_value);
}

// on slider tool slider change
function updateBalanceInput(value, pensionnum, pensiontype){
    var sliderclass=pensionnum+'_'+pensiontype;
    if(value <= 100){
        var value=parseFloat(value).toFixed(2);
        var monthly_pension=$('#'+pensiontype+'_Pension'+pensionnum+'_Estimated_Monthly_Payment').val();
        $('.'+sliderclass+'_opponentpercentage_input').val(value);
        $('.'+sliderclass+'_opponentpercentage_div').text(value+'%');
        var client_pension_percentage_new=100-value;
        client_pension_percentage_new=parseFloat(client_pension_percentage_new).toFixed(2);
        $('.'+sliderclass+'_clientpercentage_input').val(client_pension_percentage_new);
        $('.'+sliderclass+'_clientpercentage_div').text(client_pension_percentage_new+'%');
        monthly_pension=parseFloat(monthly_pension);
        var client_pension_amount_new = monthly_pension - (monthly_pension * value/100);
        var opponent_pension_amount = monthly_pension - (monthly_pension * client_pension_percentage_new/100);
        opponent_pension_amount=parseFloat(opponent_pension_amount).toFixed(2);
        client_pension_amount_new=parseFloat(client_pension_amount_new).toFixed(2);
        $('.'+sliderclass+'_opponentamount_input').val(opponent_pension_amount);
        $('.'+sliderclass+'_clientamount_input').val(client_pension_amount_new);
        $('.'+sliderclass+'_opponentamount_div').text(formatter.format(opponent_pension_amount));
        $('.'+sliderclass+'_clientamount_div').text(formatter.format(client_pension_amount_new));

        // to calculate net value
        var client_surv_cost=$('#'+pensiontype+'_Pension'+pensionnum+'_Surv_Cost_Client').val();
        client_surv_cost=parseFloat(client_surv_cost).toFixed(2);
        var net_value=client_pension_amount_new-client_surv_cost;
        net_value=parseFloat(net_value).toFixed(2);
        $('#'+pensiontype+'_Pension'+pensionnum+'_Estimated_Net_Client').val(net_value);

        var opponent_surv_cost=$('#'+pensiontype+'_Pension'+pensionnum+'_Surv_Cost_Op').val();
        opponent_surv_cost=parseFloat(opponent_surv_cost).toFixed(2);
        var net_value=opponent_pension_amount-opponent_surv_cost;
        net_value=parseFloat(net_value).toFixed(2);
        $('#'+pensiontype+'_Pension'+pensionnum+'_Estimated_Net_Op').val(net_value);
    }
}

// Reset caclulations to default
function resetBalanceInput(value, pensionnum, pensiontype){
    // var dateinput=$('input[name="Client_Pension1_Coverture_Date_Input"]');
    // alert(dateinput.val());
    // var sliderclass=pensionnum+'_'+pensiontype;
    // $('.'+sliderclass+'_balance_range_selector, .'+sliderclass+'_opponentpercentage_input, .'+sliderclass+'_clientpercentage_input').val('50.00');
    // $('.'+sliderclass+'_opponentpercentage_div, .'+sliderclass+'_clientpercentage_div').text('50.00%');
    // var monthly_pension=$('#'+pensiontype+'_Pension'+pensionnum+'_Estimated_Monthly_Payment').val();
    // monthly_pension=parseFloat(monthly_pension).toFixed(2);
    // client_pension=monthly_pension/2;
    // client_pension=parseFloat(client_pension).toFixed(2);
    // $('.'+sliderclass+'_clientamount_input').val(client_pension);
    // $('.'+sliderclass+'_opponentamount_input').val(client_pension);
    // $('.'+sliderclass+'_clientamount_div').text(formatter.format(client_pension));
    // $('.'+sliderclass+'_opponentamount_div').text(formatter.format(client_pension));

    var dateinput=$('input[name="Client_Pension1_Coverture_Date_Input"]');
    if($(dateinput).is(":checked") && dateinput.val()=='DateOfSeparation'){
        //Cfnum=MONTHS(MIN{[DateOfSeparation or FinalHearingDate], PensionVestDate) - MAX(DateOfMarriage, PensionStartDate})

        // CFden=MONTHS(PensionVestDate – PensionStartDate)

        // CF=0.5*(CFnum/CFden)
        var vest_date=$('#'+pensiontype+'_Pension'+pensionnum+'_Vest_Date').val();
        var date_of_separation='{{$marriageinfo[0]->Date_of_Separation}}';
        if(date_of_separation){
            var dates1=[];
            dates1.push(new Date(vest_date));
            dates1.push(new Date(date_of_separation));     
            var min_date=new Date(Math.min.apply(null,dates1));
        } else {
            var min_date=new Date(vest_date);
        }

        var pension_date=$('#'+pensiontype+'_Date_Begin_Earning_Pension'+pensionnum+'1').val();
        var marriage_date='{{$marriageinfo[0]->Marriage_Date}}';
        if(marriage_date){
            var dates1=[];
            dates1.push(new Date(pension_date));
            dates1.push(new Date(marriage_date)); 
            var max_date=new Date(Math.max.apply(null,dates1));
        } else {
            var max_date=new Date(pension_date);
        }

        // var cfnum = diff_months(min_date, max_date);
        var cfnum = diff_months(max_date, min_date);
    }

    if($(dateinput).is(":checked") && dateinput.val()=='FinalHearingDate'){

        var vest_date=$('#'+pensiontype+'_Pension'+pensionnum+'_Vest_Date').val();
        var final_hearing_date='{{$case_data->final_hearing_date}}';
        if(final_hearing_date){
            var dates1=[];
            dates1.push(new Date(vest_date));
            dates1.push(new Date(final_hearing_date));     
            var min_date=new Date(Math.min.apply(null,dates1));
        } else {
            alert('Final Hearing Date is not set for this case. Please go to edit core case detail to add Final Hearing Date.');
            var min_date=new Date(vest_date);
        }

        var pension_date=$('#'+pensiontype+'_Date_Begin_Earning_Pension'+pensionnum+'1').val();
        var marriage_date='{{$marriageinfo[0]->Marriage_Date}}';
        if(marriage_date){
            var dates1=[];
            dates1.push(new Date(pension_date));
            dates1.push(new Date(marriage_date)); 
            var max_date=new Date(Math.max.apply(null,dates1));
        } else {
            var max_date=new Date(pension_date);
        }

        // var cfnum = diff_months(min_date, max_date);
        var cfnum = diff_months(max_date, min_date);
        
    }
    // CFden=MONTHS(PensionVestDate – PensionStartDate)
    var vest_date=$('#'+pensiontype+'_Pension'+pensionnum+'_Vest_Date').val();
    var vest_date=new Date(vest_date);
    var pension_date=$('#'+pensiontype+'_Date_Begin_Earning_Pension'+pensionnum+'1').val();
    var pension_date=new Date(pension_date);
    var cfden = diff_months(vest_date, pension_date);
    if(cfnum/cfden){
        // var cf=0.5*(cfnum/cfden);
        var cf=(cfnum/(cfden*2));
    } else {
        cf=0.5;
    }
    var sliderclass=pensionnum+'_'+pensiontype;
    if(cf <= 100){
        if(type=='Op'){
            var cf=100-cf;
        }
        var cf=cf*100;
        var cf=parseFloat(cf).toFixed(2);
        $('.'+sliderclass+'_balance_range_selector, .'+sliderclass+'_opponentpercentage_input, .'+sliderclass+'_clientpercentage_input').val(cf);
        var monthly_pension=$('#'+pensiontype+'_Pension'+pensionnum+'_Estimated_Monthly_Payment').val();
        $('.'+sliderclass+'_opponentpercentage_input').val(cf);
        $('.'+sliderclass+'_opponentpercentage_div').text(cf+'%');
        var client_pension_percentage_new=100-cf;
        client_pension_percentage_new=parseFloat(client_pension_percentage_new).toFixed(2);
        $('.'+sliderclass+'_clientpercentage_input').val(client_pension_percentage_new);
        $('.'+sliderclass+'_clientpercentage_div').text(client_pension_percentage_new+'%');
        monthly_pension=parseFloat(monthly_pension);
        var client_pension_amount_new = monthly_pension - (monthly_pension * cf/100);
        var opponent_pension_amount = monthly_pension - (monthly_pension * client_pension_percentage_new/100);
        opponent_pension_amount=parseFloat(opponent_pension_amount).toFixed(2);
        client_pension_amount_new=parseFloat(client_pension_amount_new).toFixed(2);
        $('.'+sliderclass+'_opponentamount_input').val(opponent_pension_amount);
        $('.'+sliderclass+'_clientamount_input').val(client_pension_amount_new);
        $('.'+sliderclass+'_opponentamount_div').text(formatter.format(opponent_pension_amount));
        $('.'+sliderclass+'_clientamount_div').text(formatter.format(client_pension_amount_new));
    }
}

// format amounts to currency inputs
const formatter = new Intl.NumberFormat('en-US', {
    style: 'currency',
    currency: 'USD',
    minimumFractionDigits: 2
});

$(document).ready(function(){

    $('#dr_Pensions').validate();
    $(window).keydown(function(event){
        if(event.keyCode == 13) {
          event.preventDefault();
          return false;
        }
    });
    $(".hasDatepicker").datepicker({
        startDate: "01/01/1900",
        // endDate: '+0d',
    });

    var any_pensioncheck=$('#Any_Pension');
    if(any_pensioncheck.prop("checked") == true){
        $('.Client_Op_Pension').show();
    } else {
        $('#Num_Client_Pensions, #Num_Client_Pensions').val('0');
        $('.Client_Op_Pension').hide();
        $('#dr_Pensions input').prop('required',false);
        $('#dr_Pensions select').prop('required',false);
        $('#dr_Pensions select option[value=""]').prop('selected','selected');
    }

    // on number client pensions change
    $('.1_Client_Pensions_section, .2_Client_Pensions_section, .3_Client_Pensions_section, .4_Client_Pensions_section').hide();
    if($('#Num_Client_Pensions').val() > 0 &&  $('#Num_Client_Pensions').val() <= 4 ){
        for (var i = 1; i <= $('#Num_Client_Pensions').val(); i++) {
            $('.'+i+'_Client_Pensions_section').show();
            $('.'+i+'_Client_Pensions_section input').first().prop('required',true);
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
    var val=parseInt($('#Num_Client_Pensions').val())+1;
    for (var i = val; i <= 4; i++) {
        $('.'+i+'_Client_Pensions_section input').prop('required',false);
        $('.'+i+'_Client_Pensions_section select option[value=""]').prop('selected','selected');
    }

    $('#Num_Client_Pensions').on('change keyup', function(){
        $('.1_Client_Pensions_section, .2_Client_Pensions_section, .3_Client_Pensions_section, .4_Client_Pensions_section').hide();
        if(this.value > 0 &&  this.value <= 4 ){
            for (var i = 1; i <= this.value; i++) {
                $('.'+i+'_Client_Pensions_section').show();
            }
        }
        var val=parseInt(this.value)+1;
        for (var i = val; i <= 4; i++) {
            $('.'+i+'_Client_Pensions_section input').prop('required',false);
            $('.'+i+'_Client_Pensions_section select option[value=""]').prop('selected','selected');
        }
    });

    // on number client pensions change
    $('.1_Op_Pensions_section, .2_Op_Pensions_section, .3_Op_Pensions_section, .4_Op_Pensions_section').hide();
    if($('#Num_Op_Pensions').val() > 0 &&  $('#Num_Op_Pensions').val() <= 4 ){
        for (var i = 1; i <= $('#Num_Op_Pensions').val(); i++) {
            $('.'+i+'_Op_Pensions_section').show();
            $('.'+i+'_Op_Pensions_section input').first().prop('required',true);
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
    var val=parseInt($('#Num_Op_Pensions').val())+1;
    for (var i = val; i <= 4; i++) {
        $('.'+i+'_Op_Pensions_section input').prop('required',false);
        $('.'+i+'_Op_Pensions_section select option[value=""]').prop('selected','selected');
    }
    
    $('#Num_Op_Pensions').on('change keyup', function(){

        $('#prev_filed_post_decree').prop("checked",true).trigger("change");
        $('.1_Op_Pensions_section, .2_Op_Pensions_section, .3_Op_Pensions_section, .4_Op_Pensions_section').hide();
        if(this.value > 0 &&  this.value <= 4 ){
            for (var i = 1; i <= this.value; i++) {
                $('.'+i+'_Op_Pensions_section').show();
            }
        }
        var val=parseInt(this.value)+1;
        for (var i = val; i <= 4; i++) {
            $('.'+i+'_Op_Pensions_section input').prop('required',false);
            $('.'+i+'_Op_Pensions_section select option[value=""]').prop('selected','selected');
        }
    });
});
</script>   
@endsection