@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center dr_Vehicles_main dr_Tables_main">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header"><strong>{{ __('Update Vehicles Info') }}</strong>
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
                    <form role="form" id="dr_Vehicles" method="POST" action="{{route('drvehicles.update',['id'=>$drvehicles->id])}}" autocomplete="off">
                        @csrf
                        @method('put')
                        <input id="" type="hidden" class="form-control" name="case_id" value="{{$case_id}}">
                        <input id="" type="hidden" class="form-control" name="client_name" value="{{$client_name}}">
                        <input id="" type="hidden" class="form-control" name="opponent_name" value="{{$opponent_name}}">
                        <div class="form-row Any_Vehicles">
                            <div class="form-group col-sm-12">
                                <label></label>
                                <div class="w-100 dataInput">
                                     <label><input type="checkbox" id="Any_Vehicles" name="Any_Vehicles" value="1" onchange="getAnyVehicle(this);" <?php if(isset($drvehicles->Any_Vehicles) && $drvehicles->Any_Vehicles=='1'){ echo "checked"; } ?>> Check if Any Vehicles (Cars, Trucks, Boats, Trailers, etc.) is Owned and/or Leased by {{$client_name}} and/or {{$opponent_name}}?</label>
                                </div>
                            </div>
                        </div>
                        <!-- Joint Vehicles Info Section -->
                        <div class="form-row Num_Joint_Vehicles" style="display: none;">
                            <h4 class="col-sm-12">Joint Vehicles Info Section</h4>
                            <div class="col-sm-6">
                                <label for="Num_Joint_Vehicles">How Many Vehicles Leased or Titled in Both Parties’ Names?</label>
                                <input id="Num_Joint_Vehicles" type="number" class="form-control" name="Num_Joint_Vehicles" value="<?php if(isset($drvehicles->Num_Joint_Vehicles)){ echo $drvehicles->Num_Joint_Vehicles; } ?>" min="0" max="6"> 
                            </div>
                        </div>
                        <div class="form-row Joint_vehicles_section">
                            <div class="col-sm-12 mt-4 1_Joint_vehicles_section" style="display: none;"><h5 class="col-sm-12">First Vehicle Info</h5>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_Vehicle_Year1">Model year of this vehicle?</label>
                                    <select id="Joint_Vehicle_Year1" name="Joint_Vehicle_Year1" class="form-control 1_Joint_vehicles_select">
                                        <?php 
                                            if(isset($drvehicles->Joint_Vehicle_Year1)){ 
                                                $already_selected_value = $drvehicles->Joint_Vehicle_Year1; 
                                            } else {
                                                $already_selected_value = '';
                                            }
                                            $earliest_year = 1900;
                                            foreach (range(date('Y'), $earliest_year) as $x) {
                                                echo '<option value="'.$x.'"'.($x == $already_selected_value ? ' selected="selected"' : '').'>'.$x.'</option>';
                                            }
                                        ?>
                                    </select>   
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_Vehicle_Make_Model1">What make and model is this vehicle?</label>
                                    <input id="Joint_Vehicle_Make_Model1" type="text" class="form-control 1_Joint_vehicles_inputs" name="Joint_Vehicle_Make_Model1" value="<?php if(isset($drvehicles->Joint_Vehicle_Make_Model1)){ echo $drvehicles->Joint_Vehicle_Make_Model1; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Is this vehicle leased or owned?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Joint_Vehicle_Owned_Leased1_Owned" name="Joint_Vehicle_Owned_Leased1" value="Owned" data-onload="getInitialVehicleOwnedLeased(this, '1', 'Joint');" onchange="getVehicleOwnedLeased(this, '1', 'Joint');" <?php if(isset($drvehicles->Joint_Vehicle_Owned_Leased1) && $drvehicles->Joint_Vehicle_Owned_Leased1=='Owned'){ echo "checked"; } ?>> Owned</label>
                                        <label><input type="radio" id="Joint_Vehicle_Owned_Leased1_Leased" name="Joint_Vehicle_Owned_Leased1" value="Leased" data-onload="getInitialVehicleOwnedLeased(this, '1', 'Joint');" onchange="getVehicleOwnedLeased(this, '1', 'Joint');" <?php if(isset($drvehicles->Joint_Vehicle_Owned_Leased1) && $drvehicles->Joint_Vehicle_Owned_Leased1=='Leased'){ echo "checked"; } ?>> Leased</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 Joint_Vehicle_Owned1_Div">
                                    <label for="Joint_Vehicle_VIN1">What is the VIN of this vehicle?</label>
                                    <input id="Joint_Vehicle_VIN1" type="text" class="form-control 1_Joint_vehicles_inputs" name="Joint_Vehicle_VIN1" value="<?php if(isset($drvehicles->Joint_Vehicle_VIN1)){ echo $drvehicles->Joint_Vehicle_VIN1; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6 Joint_Vehicle_Owned1_Div">
                                    <label for="Joint_Vehicle_Current_Value1">What is the current value of this vehicle?</label>
                                    <input id="Joint_Vehicle_Current_Value1" type="number" class="form-control 1_Joint_vehicles_inputs" name="Joint_Vehicle_Current_Value1" value="<?php if(isset($drvehicles->Joint_Vehicle_Current_Value1)){ echo $drvehicles->Joint_Vehicle_Current_Value1; } ?>" min="0.00" step="0.01" max="999999.99" onchange="getCurrentValue(this, '1', 'Joint');" onkeyup="getCurrentValue(this, '1', 'Joint');">
                                </div>
                                <div class="form-group col-sm-6 Joint_Vehicle_Owned1_Div">
                                    <label for="Joint_Vehicle_Loan_Company_Name1">Name of first car loan company?</label>
                                    <input id="Joint_Vehicle_Loan_Company_Name1" type="text" class="form-control 1_Joint_vehicles_inputs" name="Joint_Vehicle_Loan_Company_Name1" value="<?php if(isset($drvehicles->Joint_Vehicle_Loan_Company_Name1)){ echo $drvehicles->Joint_Vehicle_Loan_Company_Name1; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6 Joint_Vehicle_Owned1_Div">
                                    <label for="Joint_Vehicle_Loan_Balance1">Balance due to first car loan company for this vehicle?</label>
                                    <input id="Joint_Vehicle_Loan_Balance1" type="number" class="form-control 1_Joint_vehicles_inputs" name="Joint_Vehicle_Loan_Balance1" value="<?php if(isset($drvehicles->Joint_Vehicle_Loan_Balance1)){ echo $drvehicles->Joint_Vehicle_Loan_Balance1; } ?>" min="0.00" step="0.01" max="999999.99" onchange="getLoanBalance(this, '1', 'Joint');" onkeyup="getLoanBalance(this, '1', 'Joint');">
                                </div>
                                <div class="form-group col-sm-6 Joint_Vehicle_Owned1_Div">
                                    <label for="Joint_Vehicle_Loan_Monthly_Payment1">Monthly payment to first car loan company for this vehicle?</label>
                                    <input id="Joint_Vehicle_Loan_Monthly_Payment1" type="number" class="form-control 1_Joint_vehicles_inputs" name="Joint_Vehicle_Loan_Monthly_Payment1" value="<?php if(isset($drvehicles->Joint_Vehicle_Loan_Monthly_Payment1)){ echo $drvehicles->Joint_Vehicle_Loan_Monthly_Payment1; } ?>" min="0.00" step="0.01" max="999999.99">
                                </div>
                                <div class="form-group col-sm-6 Joint_Vehicle_Owned1_Div">
                                    <label for="Joint_Vehicle_Loan_Second_Company_Name1">Name of second car loan company?</label>
                                    <input id="Joint_Vehicle_Loan_Second_Company_Name1" type="text" class="form-control 1_Joint_vehicles_inputs" name="Joint_Vehicle_Loan_Second_Company_Name1" value="<?php if(isset($drvehicles->Joint_Vehicle_Loan_Second_Company_Name1)){ echo $drvehicles->Joint_Vehicle_Loan_Second_Company_Name1; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6 Joint_Vehicle_Owned1_Div">
                                    <label for="Joint_Vehicle_Loan_Second_Company_Balance1">Balance due to second car loan company for this vehicle?</label>
                                    <input id="Joint_Vehicle_Loan_Second_Company_Balance1" type="number" class="form-control 1_Joint_vehicles_inputs" name="Joint_Vehicle_Loan_Second_Company_Balance1" value="<?php if(isset($drvehicles->Joint_Vehicle_Loan_Second_Company_Balance1)){ echo $drvehicles->Joint_Vehicle_Loan_Second_Company_Balance1; } ?>" min="0.00" step="0.01" max="999999.99" onchange="getCompanyBalance(this, '1', 'Joint');" onkeyup="getCompanyBalance(this, '1', 'Joint');">
                                </div>
                                <div class="form-group col-sm-6 Joint_Vehicle_Owned1_Div">
                                    <label for="Joint_Vehicle_Loan_Second_Company_Monthly_Payment1">Monthly payment to second car loan company for this vehicle?</label>
                                    <input id="Joint_Vehicle_Loan_Second_Company_Monthly_Payment1" type="number" class="form-control 1_Joint_vehicles_inputs" name="Joint_Vehicle_Loan_Second_Company_Monthly_Payment1" value="<?php if(isset($drvehicles->Joint_Vehicle_Loan_Second_Company_Monthly_Payment1)){ echo $drvehicles->Joint_Vehicle_Loan_Second_Company_Monthly_Payment1; } ?>" min="0.00" step="0.01" max="999999.99">
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label for="Joint_Vehicle_Marital_Equity1">N/A, calculated = Joint_Vehicle_Current_Value1-Joint_Vehicle_Loan_Balance1-Joint_Vehicle_Loan_Second_Company_Balance1</label>
                                    <input id="Joint_Vehicle_Marital_Equity1" type="number" class="form-control 1_Joint_vehicles_inputs" name="Joint_Vehicle_Marital_Equity1" value="<?php if(isset($drvehicles->Joint_Vehicle_Marital_Equity1)){ echo $drvehicles->Joint_Vehicle_Marital_Equity1; } ?>" min="0.00" step="0.01" max="999999.99">
                                </div>
                                <div class="form-group col-sm-6 Joint_Vehicle_Owned1_Div">
                                    <label>Does either party claim a sole/separate interest in this vehicle?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Joint_Vehicle_SoleSeparate_Claim1_Yes" name="Joint_Vehicle_SoleSeparate_Claim1" value="Yes" data-onload="getInitialPartyClaimSoleSeparate(this, '1', 'Joint');" onchange="getPartyClaimSoleSeparate(this, '1', 'Joint');" <?php if(isset($drvehicles->Joint_Vehicle_SoleSeparate_Claim1) && $drvehicles->Joint_Vehicle_SoleSeparate_Claim1=='Yes'){ echo "checked"; } ?>> Yes</label>
                                        <label><input type="radio" id="Joint_Vehicle_SoleSeparate_Claim1_No" name="Joint_Vehicle_SoleSeparate_Claim1" value="No" data-onload="getInitialPartyClaimSoleSeparate(this, '1', 'Joint');" onchange="getPartyClaimSoleSeparate(this, '1', 'Joint');" <?php if(isset($drvehicles->Joint_Vehicle_SoleSeparate_Claim1) && $drvehicles->Joint_Vehicle_SoleSeparate_Claim1=='No'){ echo "checked"; } ?>> No</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 Joint_Vehicle_Owned1_Div" id="Joint_Vehicle_SoleSeparate_Party1_Div" style="display: none;">
                                    <label>Who claims to own this vehicle?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Joint_Vehicle_SoleSeparate_Party1_Client" name="Joint_Vehicle_SoleSeparate_Party1" value="{{$client_name}}" <?php if(isset($drvehicles->Joint_Vehicle_SoleSeparate_Party1) && $drvehicles->Joint_Vehicle_SoleSeparate_Party1==$client_name){ echo "checked"; } ?>> {{$client_name}}</label>
                                        <label><input type="radio" id="Joint_Vehicle_SoleSeparate_Party1_Op" name="Joint_Vehicle_SoleSeparate_Party1" value="{{$opponent_name}}" <?php if(isset($drvehicles->Joint_Vehicle_SoleSeparate_Party1) && $drvehicles->Joint_Vehicle_SoleSeparate_Party1==$opponent_name){ echo "checked"; } ?>> {{$opponent_name}}</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 Joint_Vehicle_Owned1_Div" id="Joint_Vehicle_SoleSeparate_Grounds1_Div" style="display: none;">
                                    <label for="Joint_Vehicle_SoleSeparate_Grounds1">Why does this person own this vehicle solely and separately?</label>
                                    <input id="Joint_Vehicle_SoleSeparate_Grounds1" type="text" class="form-control 1_Joint_vehicles_inputs" name="Joint_Vehicle_SoleSeparate_Grounds1" value="<?php if(isset($drvehicles->Joint_Vehicle_SoleSeparate_Grounds1)){ echo $drvehicles->Joint_Vehicle_SoleSeparate_Grounds1; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6 Joint_Vehicle_Owned1_Div">
                                    <label>How will this vehicle value be distributed between the parties?</label>
                                    <div class="w-100 dataInput">
                                        <label><input type="radio" id="Joint_Vehicle_Disposition_Method1_Liquidate_Split_Net_Value" name="Joint_Vehicle_Disposition_Method1" value="Liquidate/Split Net Value" data-onload="getInitialDipositionMethod(this, '1', 'Joint');" onchange="getDipositionMethod(this, '1', 'Joint');" <?php if(isset($drvehicles->Joint_Vehicle_Disposition_Method1) && $drvehicles->Joint_Vehicle_Disposition_Method1=='Liquidate/Split Net Value'){ echo "checked"; } ?>> Liquidate/Split Net Value</label>
                                        <label><input type="radio" id="Joint_Vehicle_Disposition_Method1_Fixed_Buyout" name="Joint_Vehicle_Disposition_Method1" value="Fixed Buyout" data-onload="getInitialDipositionMethod(this, '1', 'Joint');" onchange="getDipositionMethod(this, '1', 'Joint');" <?php if(isset($drvehicles->Joint_Vehicle_Disposition_Method1) && $drvehicles->Joint_Vehicle_Disposition_Method1=='Fixed Buyout'){ echo "checked"; } ?>> Fixed Buyout</label>
                                    </div>
                                </div>
                                <!-- slider tool -->
                                <div class="form-group col-sm-6 m-auto 1_Joint_Slider_Tool Joint_Vehicle_Owned1_Div">
                                    <div class="row">
                                        <div class="col">{{$client_name}}</div>
                                        <div class="col text-right">{{$opponent_name}}</div>
                                    </div>
                                    <input id="1_Joint_balance_range_selector" type="range" class="form-control slider-tool-input 1_Joint_balance_range_selector" name="" value="<?php if(isset($drvehicles->Joint_Vehicle_Percent_Marital_Equity_to_Op1)){ echo $drvehicles->Joint_Vehicle_Percent_Marital_Equity_to_Op1; } ?>" min="0.00" step="0.01" max="100" onchange="updateBalanceInput(this.value, '1', 'Joint');">
                                </div>
                                <div class="form-group col-sm-6 m-auto 1_Joint_Slider_Tool Joint_Vehicle_Owned1_Div">
                                    <div class="row justify-content-between">
                                        <div class="col selectorTool">
                                            <div class="left-col">
                                                <div class="client-info 1_Joint_clientpercentage_div clientpercentage_div">
                                                    <?php if(isset($drvehicles->Joint_Vehicle_Percent_Marital_Equity_to_Client1)){ echo $drvehicles->Joint_Vehicle_Percent_Marital_Equity_to_Client1; } else {
                                                        echo '50.00';
                                                    } ?>%
                                                </div>
                                                <div class="client-info 1_Joint_clientamount_div clientamount_div" style="clear: both;">
                                                    $<?php if(isset($drvehicles->Joint_Vehicle_Estimated_Value_to_Client1)){ echo $drvehicles->Joint_Vehicle_Estimated_Value_to_Client1; } else {
                                                        echo '50.00';
                                                    } ?>
                                                </div>
                                            </div>
                                            <label>To {{$client_name}}</label>
                                        </div>                                       
                                        <div class="col selectorTool selectorToolRight">
                                            <label>To {{$opponent_name}}</label>
                                            <div class="left-col right-col">
                                                <div class="client-info 1_Joint_opponentpercentage_div opponentpercentage_div">
                                                    <?php if(isset($drvehicles->Joint_Vehicle_Percent_Marital_Equity_to_Op1)){ echo $drvehicles->Joint_Vehicle_Percent_Marital_Equity_to_Op1; } else {
                                                        echo '50.00';
                                                    } ?>%
                                                </div>
                                                <div class="client-info 1_Joint_opponentamount_div opponentamount_div" style="clear: both;">
                                                    $<?php if(isset($drvehicles->Joint_Vehicle_Estimated_Value_to_Op1)){ echo $drvehicles->Joint_Vehicle_Estimated_Value_to_Op1; } else {
                                                        echo '50.00';
                                                    } ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 m-auto 1_Joint_Slider_Tool Joint_Vehicle_Owned1_Div">
                                    <label></label>
                                    <div class="w-100">
                                        <label><input type="radio" id="1_Joint_Vehicle_Estimated_Value_Select" name="1_Joint_Vehicle_Estimated_Value_Select_Reset" class="Vehicle_Estimated_Value_Select_Reset" value="Save"> Save this Distribution of Vehicles #1</label>
                                        <label><input type="radio" id="1_Joint_Vehicle_Estimated_Value_Reset" name="1_Joint_Vehicle_Estimated_Value_Select_Reset" class="Vehicle_Estimated_Value_Select_Reset" value="Reset" onclick="resetBalanceInput(this, '1', 'Joint');"> Reset to Default (50%)</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 Joint_Vehicle_Owned1_Div Joint_Vehicle_Paying_Party1_Inputs_Div" style="display: none;">
                                    <label>Joint Vehicles Paying Party1</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Joint_Vehicle_Paying_Party1_Client" name="Joint_Vehicle_Paying_Party1" value="{{$client_name}}" data-onload="getInitialVehiclesPayingParty(this, '1', 'Joint');" onchange="getVehiclesPayingParty(this, '1', 'Joint');" <?php if(isset($drvehicles->Joint_Vehicle_Paying_Party1) && $drvehicles->Joint_Vehicle_Paying_Party1==$client_name){ echo "checked"; } ?>> {{$client_name}}</label>
                                        <label><input type="radio" id="Joint_Vehicle_Paying_Party1_Op" name="Joint_Vehicle_Paying_Party1" value="{{$opponent_name}}" data-onload="getInitialVehiclesPayingParty(this, '1', 'Joint');" onchange="getVehiclesPayingParty(this, '1', 'Joint');" <?php if(isset($drvehicles->Joint_Vehicle_Paying_Party1) && $drvehicles->Joint_Vehicle_Paying_Party1==$opponent_name){ echo "checked"; } ?>> {{$opponent_name}}</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 Joint_Vehicle_Owned1_Div Joint_Vehicle_Paying_Party1_Inputs_Div" style="display: none;">
                                    <label>{{$client_name}} Vehicles Equity Percent</label>
                                    <input id="Joint_Vehicle_Percent_Marital_Equity_to_Client1" type="number" class="form-control 1_Joint_clientpercentage_input clientpercentage_input" name="Joint_Vehicle_Percent_Marital_Equity_to_Client1" value="<?php if(isset($drvehicles->Joint_Vehicle_Percent_Marital_Equity_to_Client1)){ echo $drvehicles->Joint_Vehicle_Percent_Marital_Equity_to_Client1; } ?>" min="0.00" step="0.01" max="100" readonly="">
                                </div>
                                <div class="form-group col-sm-6 Joint_Vehicle_Owned1_Div Joint_Vehicle_Paying_Party1_Inputs_Div" style="display: none;">
                                    <label>How much is to be paid to {{$client_name}}?</label>
                                    <input id="Joint_Vehicle_Estimated_Value_to_Client1" type="number" class="form-control 1_Joint_clientamount_input clientamount_input" name="Joint_Vehicle_Estimated_Value_to_Client1" value="<?php if(isset($drvehicles->Joint_Vehicle_Estimated_Value_to_Client1)){ echo $drvehicles->Joint_Vehicle_Estimated_Value_to_Client1; } ?>" min="0.00" step="0.01" max="999999.99" readonly="" onchange="getEstimatedValueClient(this, '1', 'Joint');" onkeyup="getEstimatedValueClient(this, '1', 'Joint');">
                                </div>
                                <div class="form-group col-sm-6 Joint_Vehicle_Owned1_Div Joint_Vehicle_Paying_Party1_Inputs_Div" style="display: none;">
                                    <label>{{$opponent_name}} Vehicles Equity Percent</label>
                                    <input id="Joint_Vehicle_Percent_Marital_Equity_to_Op1" type="number" class="form-control 1_Joint_opponentpercentage_input opponentpercentage_input" name="Joint_Vehicle_Percent_Marital_Equity_to_Op1" value="<?php if(isset($drvehicles->Joint_Vehicle_Percent_Marital_Equity_to_Op1)){ echo $drvehicles->Joint_Vehicle_Percent_Marital_Equity_to_Op1; } ?>" min="0.00" step="0.01" max="100" readonly="">
                                </div>
                                <div class="form-group col-sm-6 Joint_Vehicle_Owned1_Div Joint_Vehicle_Paying_Party1_Inputs_Div" style="display: none;">
                                    <label>How much is to be paid to {{$opponent_name}}?</label>
                                    <input id="Joint_Vehicle_Estimated_Value_to_Op1" type="number" class="form-control 1_Joint_opponentamount_input opponentamount_input" name="Joint_Vehicle_Estimated_Value_to_Op1" value="<?php if(isset($drvehicles->Joint_Vehicle_Estimated_Value_to_Op1)){ echo $drvehicles->Joint_Vehicle_Estimated_Value_to_Op1; } ?>" min="0.00" step="0.01" max="999999.99" readonly="" onchange="getEstimatedValueOp(this, '1', 'Joint');" onkeyup="getEstimatedValueOp(this, '1', 'Joint');">
                                </div>
                                <!-- end of slider tool -->
                                <div class="form-group col-sm-6 Joint_Vehicle_Paying_Party1_Leased_Div" style="display: none;">
                                    <label for="Joint_Vehicle_Lease_Company1">Name of vehicle lease company?</label>
                                    <input id="Joint_Vehicle_Lease_Company1" type="text" class="form-control 1_Joint_vehicles_inputs Joint_Vehicle_Paying_Party1_Leased_Input" name="Joint_Vehicle_Lease_Company1" value="<?php if(isset($drvehicles->Joint_Vehicle_Lease_Company1)){ echo $drvehicles->Joint_Vehicle_Lease_Company1; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6 Joint_Vehicle_Paying_Party1_Leased_Div" style="display: none;">
                                    <label>Monthly lease payment for this vehicle?</label>
                                    <input id="Joint_Vehicle_Monthly_Lease_Amount1" type="number" class="form-control 1_Joint_vehicles_inputs Joint_Vehicle_Paying_Party1_Leased_Input" name="Joint_Vehicle_Monthly_Lease_Amount1" value="<?php if(isset($drvehicles->Joint_Vehicle_Monthly_Lease_Amount1)){ echo $drvehicles->Joint_Vehicle_Monthly_Lease_Amount1; } ?>" min="0.00" step="0.01" max="999999.99">
                                </div>
                                <div class="form-group col-sm-6 Joint_Vehicle_Paying_Party1_Leased_Div" style="display: none;">
                                    <label>How will this leased vehicle be handled?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Joint_Vehicle_Lease_Disposition_Method1_Terminate_Lease" name="Joint_Vehicle_Lease_Disposition_Method1" value="Terminate Lease" <?php if(isset($drvehicles->Joint_Vehicle_Lease_Disposition_Method1) && $drvehicles->Joint_Vehicle_Lease_Disposition_Method1=='Terminate Lease'){ echo "checked"; } ?>> Terminate Lease</label>
                                        <label><input type="radio" id="Joint_Vehicle_Lease_Disposition_Method1_Transfer_Lease_Responsibility_to_ClientName" name="Joint_Vehicle_Lease_Disposition_Method1" value="Transfer Lease Responsibility to {{$client_name}}" <?php if(isset($drvehicles->Joint_Vehicle_Lease_Disposition_Method1) && $drvehicles->Joint_Vehicle_Lease_Disposition_Method1=='Transfer Lease Responsibility to '.$client_name.''){ echo "checked"; } ?>> Transfer Lease Responsibility to {{$client_name}}</label>
                                        <label><input type="radio" id="Joint_Vehicle_Lease_Disposition_Method1_Transfer_Lease_Responsibility_to_OpName" name="Joint_Vehicle_Lease_Disposition_Method1" value="Transfer Lease Responsibility to {{$opponent_name}}" <?php if(isset($drvehicles->Joint_Vehicle_Lease_Disposition_Method1) && $drvehicles->Joint_Vehicle_Lease_Disposition_Method1=='Transfer Lease Responsibility to '.$opponent_name.''){ echo "checked"; } ?>> Transfer Lease Responsibility to {{$opponent_name}}</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 mt-4 2_Joint_vehicles_section" style="display: none;"><h5 class="col-sm-12">Second Vehicle Info</h5>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_Vehicle_Year2">Model year of this vehicle?</label>
                                    <select id="Joint_Vehicle_Year2" name="Joint_Vehicle_Year2" class="form-control 2_Joint_vehicles_select">
                                        <?php 
                                            if(isset($drvehicles->Joint_Vehicle_Year2)){ 
                                                $already_selected_value = $drvehicles->Joint_Vehicle_Year2; 
                                            } else {
                                                $already_selected_value = '';
                                            }
                                            $earliest_year = 1900;
                                            foreach (range(date('Y'), $earliest_year) as $x) {
                                                echo '<option value="'.$x.'"'.($x == $already_selected_value ? ' selected="selected"' : '').'>'.$x.'</option>';
                                            }
                                        ?>
                                    </select>   
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_Vehicle_Make_Model2">What make and model is this vehicle?</label>
                                    <input id="Joint_Vehicle_Make_Model2" type="text" class="form-control 2_Joint_vehicles_inputs" name="Joint_Vehicle_Make_Model2" value="<?php if(isset($drvehicles->Joint_Vehicle_Make_Model2)){ echo $drvehicles->Joint_Vehicle_Make_Model2; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Is this vehicle leased or owned?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Joint_Vehicle_Owned_Leased2_Owned" name="Joint_Vehicle_Owned_Leased2" value="Owned" data-onload="getInitialVehicleOwnedLeased(this, '2', 'Joint');" onchange="getVehicleOwnedLeased(this, '2', 'Joint');" <?php if(isset($drvehicles->Joint_Vehicle_Owned_Leased2) && $drvehicles->Joint_Vehicle_Owned_Leased2=='Owned'){ echo "checked"; } ?>> Owned</label>
                                        <label><input type="radio" id="Joint_Vehicle_Owned_Leased2_Leased" name="Joint_Vehicle_Owned_Leased2" value="Leased" data-onload="getInitialVehicleOwnedLeased(this, '2', 'Joint');" onchange="getVehicleOwnedLeased(this, '2', 'Joint');" <?php if(isset($drvehicles->Joint_Vehicle_Owned_Leased2) && $drvehicles->Joint_Vehicle_Owned_Leased2=='Leased'){ echo "checked"; } ?>> Leased</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 Joint_Vehicle_Owned2_Div">
                                    <label for="Joint_Vehicle_VIN2">What is the VIN of this vehicle?</label>
                                    <input id="Joint_Vehicle_VIN2" type="text" class="form-control 2_Joint_vehicles_inputs" name="Joint_Vehicle_VIN2" value="<?php if(isset($drvehicles->Joint_Vehicle_VIN2)){ echo $drvehicles->Joint_Vehicle_VIN2; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6 Joint_Vehicle_Owned2_Div">
                                    <label for="Joint_Vehicle_Current_Value2">What is the current value of this vehicle?</label>
                                    <input id="Joint_Vehicle_Current_Value2" type="number" class="form-control 2_Joint_vehicles_inputs" name="Joint_Vehicle_Current_Value2" value="<?php if(isset($drvehicles->Joint_Vehicle_Current_Value2)){ echo $drvehicles->Joint_Vehicle_Current_Value2; } ?>" min="0.00" step="0.01" max="999999.99" onchange="getCurrentValue(this, '2', 'Joint');" onkeyup="getCurrentValue(this, '2', 'Joint');">
                                </div>
                                <div class="form-group col-sm-6 Joint_Vehicle_Owned2_Div">
                                    <label for="Joint_Vehicle_Loan_Company_Name2">Name of first car loan company?</label>
                                    <input id="Joint_Vehicle_Loan_Company_Name2" type="text" class="form-control 2_Joint_vehicles_inputs" name="Joint_Vehicle_Loan_Company_Name2" value="<?php if(isset($drvehicles->Joint_Vehicle_Loan_Company_Name2)){ echo $drvehicles->Joint_Vehicle_Loan_Company_Name2; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6 Joint_Vehicle_Owned2_Div">
                                    <label for="Joint_Vehicle_Loan_Balance2">Balance due to first car loan company for this vehicle?</label>
                                    <input id="Joint_Vehicle_Loan_Balance2" type="number" class="form-control 2_Joint_vehicles_inputs" name="Joint_Vehicle_Loan_Balance2" value="<?php if(isset($drvehicles->Joint_Vehicle_Loan_Balance2)){ echo $drvehicles->Joint_Vehicle_Loan_Balance2; } ?>" min="0.00" step="0.01" max="999999.99" onchange="getLoanBalance(this, '2', 'Joint');" onkeyup="getLoanBalance(this, '2', 'Joint');">
                                </div>
                                <div class="form-group col-sm-6 Joint_Vehicle_Owned2_Div">
                                    <label for="Joint_Vehicle_Loan_Monthly_Payment2">Monthly payment to first car loan company for this vehicle?</label>
                                    <input id="Joint_Vehicle_Loan_Monthly_Payment2" type="number" class="form-control 2_Joint_vehicles_inputs" name="Joint_Vehicle_Loan_Monthly_Payment2" value="<?php if(isset($drvehicles->Joint_Vehicle_Loan_Monthly_Payment2)){ echo $drvehicles->Joint_Vehicle_Loan_Monthly_Payment2; } ?>" min="0.00" step="0.01" max="999999.99">
                                </div>
                                <div class="form-group col-sm-6 Joint_Vehicle_Owned2_Div">
                                    <label for="Joint_Vehicle_Loan_Second_Company_Name2">Name of second car loan company?</label>
                                    <input id="Joint_Vehicle_Loan_Second_Company_Name2" type="text" class="form-control 2_Joint_vehicles_inputs" name="Joint_Vehicle_Loan_Second_Company_Name2" value="<?php if(isset($drvehicles->Joint_Vehicle_Loan_Second_Company_Name2)){ echo $drvehicles->Joint_Vehicle_Loan_Second_Company_Name2; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6 Joint_Vehicle_Owned2_Div">
                                    <label for="Joint_Vehicle_Loan_Second_Company_Balance2">Balance due to second car loan company for this vehicle?</label>
                                    <input id="Joint_Vehicle_Loan_Second_Company_Balance2" type="number" class="form-control 2_Joint_vehicles_inputs" name="Joint_Vehicle_Loan_Second_Company_Balance2" value="<?php if(isset($drvehicles->Joint_Vehicle_Loan_Second_Company_Balance2)){ echo $drvehicles->Joint_Vehicle_Loan_Second_Company_Balance2; } ?>" min="0.00" step="0.01" max="999999.99" onchange="getCompanyBalance(this, '2', 'Joint');" onkeyup="getCompanyBalance(this, '2', 'Joint');">
                                </div>
                                <div class="form-group col-sm-6 Joint_Vehicle_Owned2_Div">
                                    <label for="Joint_Vehicle_Loan_Second_Company_Monthly_Payment2">Monthly payment to second car loan company for this vehicle?</label>
                                    <input id="Joint_Vehicle_Loan_Second_Company_Monthly_Payment2" type="number" class="form-control 2_Joint_vehicles_inputs" name="Joint_Vehicle_Loan_Second_Company_Monthly_Payment2" value="<?php if(isset($drvehicles->Joint_Vehicle_Loan_Second_Company_Monthly_Payment2)){ echo $drvehicles->Joint_Vehicle_Loan_Second_Company_Monthly_Payment2; } ?>" min="0.00" step="0.01" max="999999.99">
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label for="Joint_Vehicle_Marital_Equity2">N/A, calculated = Joint_Vehicle_Current_Value2-Joint_Vehicle_Loan_Balance2-Joint_Vehicle_Loan_Second_Company_Balance2</label>
                                    <input id="Joint_Vehicle_Marital_Equity2" type="number" class="form-control 2_Joint_vehicles_inputs" name="Joint_Vehicle_Marital_Equity2" value="<?php if(isset($drvehicles->Joint_Vehicle_Marital_Equity2)){ echo $drvehicles->Joint_Vehicle_Marital_Equity2; } ?>" min="0.00" step="0.01" max="999999.99">
                                </div>
                                <div class="form-group col-sm-6 Joint_Vehicle_Owned2_Div">
                                    <label>Does either party claim a sole/separate interest in this vehicle?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Joint_Vehicle_SoleSeparate_Claim2_Yes" name="Joint_Vehicle_SoleSeparate_Claim2" value="Yes" data-onload="getInitialPartyClaimSoleSeparate(this, '2', 'Joint');" onchange="getPartyClaimSoleSeparate(this, '2', 'Joint');" <?php if(isset($drvehicles->Joint_Vehicle_SoleSeparate_Claim2) && $drvehicles->Joint_Vehicle_SoleSeparate_Claim2=='Yes'){ echo "checked"; } ?>> Yes</label>
                                        <label><input type="radio" id="Joint_Vehicle_SoleSeparate_Claim2_No" name="Joint_Vehicle_SoleSeparate_Claim2" value="No" data-onload="getInitialPartyClaimSoleSeparate(this, '2', 'Joint');" onchange="getPartyClaimSoleSeparate(this, '2', 'Joint');" <?php if(isset($drvehicles->Joint_Vehicle_SoleSeparate_Claim2) && $drvehicles->Joint_Vehicle_SoleSeparate_Claim2=='No'){ echo "checked"; } ?>> No</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 Joint_Vehicle_Owned2_Div" id="Joint_Vehicle_SoleSeparate_Party2_Div" style="display: none;">
                                    <label>Who claims to own this vehicle?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Joint_Vehicle_SoleSeparate_Party2_Client" name="Joint_Vehicle_SoleSeparate_Party2" value="{{$client_name}}" <?php if(isset($drvehicles->Joint_Vehicle_SoleSeparate_Party2) && $drvehicles->Joint_Vehicle_SoleSeparate_Party2==$client_name){ echo "checked"; } ?>> {{$client_name}}</label>
                                        <label><input type="radio" id="Joint_Vehicle_SoleSeparate_Party2_Op" name="Joint_Vehicle_SoleSeparate_Party2" value="{{$opponent_name}}" <?php if(isset($drvehicles->Joint_Vehicle_SoleSeparate_Party2) && $drvehicles->Joint_Vehicle_SoleSeparate_Party2==$opponent_name){ echo "checked"; } ?>> {{$opponent_name}}</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 Joint_Vehicle_Owned2_Div" id="Joint_Vehicle_SoleSeparate_Grounds2_Div" style="display: none;">
                                    <label for="Joint_Vehicle_SoleSeparate_Grounds2">Why does this person own this vehicle solely and separately?</label>
                                    <input id="Joint_Vehicle_SoleSeparate_Grounds2" type="text" class="form-control 2_Joint_vehicles_inputs" name="Joint_Vehicle_SoleSeparate_Grounds2" value="<?php if(isset($drvehicles->Joint_Vehicle_SoleSeparate_Grounds2)){ echo $drvehicles->Joint_Vehicle_SoleSeparate_Grounds2; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6 Joint_Vehicle_Owned2_Div">
                                    <label>How will this vehicle value be distributed between the parties?</label>
                                    <div class="w-100 dataInput">
                                        <label><input type="radio" id="Joint_Vehicle_Disposition_Method2_Liquidate_Split_Net_Value" name="Joint_Vehicle_Disposition_Method2" value="Liquidate/Split Net Value" data-onload="getInitialDipositionMethod(this, '2', 'Joint');" onchange="getDipositionMethod(this, '2', 'Joint');" <?php if(isset($drvehicles->Joint_Vehicle_Disposition_Method2) && $drvehicles->Joint_Vehicle_Disposition_Method2=='Liquidate/Split Net Value'){ echo "checked"; } ?>> Liquidate/Split Net Value</label>
                                        <label><input type="radio" id="Joint_Vehicle_Disposition_Method2_Fixed_Buyout" name="Joint_Vehicle_Disposition_Method2" value="Fixed Buyout" data-onload="getInitialDipositionMethod(this, '2', 'Joint');" onchange="getDipositionMethod(this, '2', 'Joint');" <?php if(isset($drvehicles->Joint_Vehicle_Disposition_Method2) && $drvehicles->Joint_Vehicle_Disposition_Method2=='Fixed Buyout'){ echo "checked"; } ?>> Fixed Buyout</label>
                                    </div>
                                </div>
                                <!-- slider tool -->
                                <div class="form-group col-sm-6 m-auto 2_Joint_Slider_Tool Joint_Vehicle_Owned2_Div">
                                    <div class="row">
                                        <div class="col">{{$client_name}}</div>
                                        <div class="col text-right">{{$opponent_name}}</div>
                                    </div>
                                    <input id="2_Joint_balance_range_selector" type="range" class="form-control slider-tool-input 2_Joint_balance_range_selector" name="" value="<?php if(isset($drvehicles->Joint_Vehicle_Percent_Marital_Equity_to_Op2)){ echo $drvehicles->Joint_Vehicle_Percent_Marital_Equity_to_Op2; } ?>" min="0.00" step="0.01" max="100" onchange="updateBalanceInput(this.value, '2', 'Joint');">
                                </div>
                                <div class="form-group col-sm-6 m-auto 2_Joint_Slider_Tool Joint_Vehicle_Owned2_Div">
                                    <div class="row justify-content-between">
                                        <div class="col selectorTool">
                                            <div class="left-col">
                                                <div class="client-info 2_Joint_clientpercentage_div clientpercentage_div">
                                                    <?php if(isset($drvehicles->Joint_Vehicle_Percent_Marital_Equity_to_Client2)){ echo $drvehicles->Joint_Vehicle_Percent_Marital_Equity_to_Client2; } else {
                                                        echo '50.00';
                                                    } ?>%
                                                </div>
                                                <div class="client-info 2_Joint_clientamount_div clientamount_div" style="clear: both;">
                                                    $<?php if(isset($drvehicles->Joint_Vehicle_Estimated_Value_to_Client2)){ echo $drvehicles->Joint_Vehicle_Estimated_Value_to_Client2; } else {
                                                        echo '50.00';
                                                    } ?>
                                                </div>
                                            </div>
                                            <label>To {{$client_name}}</label>
                                        </div>                                       
                                        <div class="col selectorTool selectorToolRight">
                                            <label>To {{$opponent_name}}</label>
                                            <div class="left-col right-col">
                                                <div class="client-info 2_Joint_opponentpercentage_div opponentpercentage_div">
                                                    <?php if(isset($drvehicles->Joint_Vehicle_Percent_Marital_Equity_to_Op2)){ echo $drvehicles->Joint_Vehicle_Percent_Marital_Equity_to_Op2; } else {
                                                        echo '50.00';
                                                    } ?>%
                                                </div>
                                                <div class="client-info 2_Joint_opponentamount_div opponentamount_div" style="clear: both;">
                                                    $<?php if(isset($drvehicles->Joint_Vehicle_Estimated_Value_to_Op2)){ echo $drvehicles->Joint_Vehicle_Estimated_Value_to_Op2; } else {
                                                        echo '50.00';
                                                    } ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 m-auto 2_Joint_Slider_Tool Joint_Vehicle_Owned2_Div">
                                    <label></label>
                                    <div class="w-100">
                                        <label><input type="radio" id="2_Joint_Vehicle_Estimated_Value_Select" name="2_Joint_Vehicle_Estimated_Value_Select_Reset" class="Vehicle_Estimated_Value_Select_Reset" value="Save"> Save this Distribution of Vehicles #2</label>
                                        <label><input type="radio" id="2_Joint_Vehicle_Estimated_Value_Reset" name="2_Joint_Vehicle_Estimated_Value_Select_Reset" class="Vehicle_Estimated_Value_Select_Reset" value="Reset" onclick="resetBalanceInput(this, '2', 'Joint');"> Reset to Default (50%)</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 Joint_Vehicle_Owned2_Div Joint_Vehicle_Paying_Party2_Inputs_Div" style="display: none;">
                                    <label>Joint Vehicles Paying Party2</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Joint_Vehicle_Paying_Party2_Client" name="Joint_Vehicle_Paying_Party2" value="{{$client_name}}" data-onload="getInitialVehiclesPayingParty(this, '2', 'Joint');" onchange="getVehiclesPayingParty(this, '2', 'Joint');" <?php if(isset($drvehicles->Joint_Vehicle_Paying_Party2) && $drvehicles->Joint_Vehicle_Paying_Party2==$client_name){ echo "checked"; } ?>> {{$client_name}}</label>
                                        <label><input type="radio" id="Joint_Vehicle_Paying_Party2_Op" name="Joint_Vehicle_Paying_Party2" value="{{$opponent_name}}" data-onload="getInitialVehiclesPayingParty(this, '2', 'Joint');" onchange="getVehiclesPayingParty(this, '2', 'Joint');" <?php if(isset($drvehicles->Joint_Vehicle_Paying_Party2) && $drvehicles->Joint_Vehicle_Paying_Party2==$opponent_name){ echo "checked"; } ?>> {{$opponent_name}}</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 Joint_Vehicle_Owned2_Div Joint_Vehicle_Paying_Party2_Inputs_Div" style="display: none;">
                                    <label>{{$client_name}} Vehicles Equity Percent</label>
                                    <input id="Joint_Vehicle_Percent_Marital_Equity_to_Client2" type="number" class="form-control 2_Joint_clientpercentage_input clientpercentage_input" name="Joint_Vehicle_Percent_Marital_Equity_to_Client2" value="<?php if(isset($drvehicles->Joint_Vehicle_Percent_Marital_Equity_to_Client2)){ echo $drvehicles->Joint_Vehicle_Percent_Marital_Equity_to_Client2; } ?>" min="0.00" step="0.01" max="100" readonly="">
                                </div>
                                <div class="form-group col-sm-6 Joint_Vehicle_Owned2_Div Joint_Vehicle_Paying_Party2_Inputs_Div" style="display: none;">
                                    <label>How much is to be paid to {{$client_name}}?</label>
                                    <input id="Joint_Vehicle_Estimated_Value_to_Client2" type="number" class="form-control 2_Joint_clientamount_input clientamount_input" name="Joint_Vehicle_Estimated_Value_to_Client2" value="<?php if(isset($drvehicles->Joint_Vehicle_Estimated_Value_to_Client2)){ echo $drvehicles->Joint_Vehicle_Estimated_Value_to_Client2; } ?>" min="0.00" step="0.01" max="999999.99" readonly="" onchange="getEstimatedValueClient(this, '2', 'Joint');" onkeyup="getEstimatedValueClient(this, '2', 'Joint');">
                                </div>
                                <div class="form-group col-sm-6 Joint_Vehicle_Owned2_Div Joint_Vehicle_Paying_Party2_Inputs_Div" style="display: none;">
                                    <label>{{$opponent_name}} Vehicles Equity Percent</label>
                                    <input id="Joint_Vehicle_Percent_Marital_Equity_to_Op2" type="number" class="form-control 2_Joint_opponentpercentage_input opponentpercentage_input" name="Joint_Vehicle_Percent_Marital_Equity_to_Op2" value="<?php if(isset($drvehicles->Joint_Vehicle_Percent_Marital_Equity_to_Op2)){ echo $drvehicles->Joint_Vehicle_Percent_Marital_Equity_to_Op2; } ?>" min="0.00" step="0.01" max="100" readonly="">
                                </div>
                                <div class="form-group col-sm-6 Joint_Vehicle_Owned2_Div Joint_Vehicle_Paying_Party2_Inputs_Div" style="display: none;">
                                    <label>How much is to be paid to {{$opponent_name}}?</label>
                                    <input id="Joint_Vehicle_Estimated_Value_to_Op2" type="number" class="form-control 2_Joint_opponentamount_input opponentamount_input" name="Joint_Vehicle_Estimated_Value_to_Op2" value="<?php if(isset($drvehicles->Joint_Vehicle_Estimated_Value_to_Op2)){ echo $drvehicles->Joint_Vehicle_Estimated_Value_to_Op2; } ?>" min="0.00" step="0.01" max="999999.99" readonly="" onchange="getEstimatedValueOp(this, '2', 'Joint');" onkeyup="getEstimatedValueOp(this, '2', 'Joint');">
                                </div>
                                <!-- end of slider tool -->
                                <div class="form-group col-sm-6 Joint_Vehicle_Paying_Party2_Leased_Div" style="display: none;">
                                    <label for="Joint_Vehicle_Lease_Company2">Name of vehicle lease company?</label>
                                    <input id="Joint_Vehicle_Lease_Company2" type="text" class="form-control 2_Joint_vehicles_inputs Joint_Vehicle_Paying_Party2_Leased_Input" name="Joint_Vehicle_Lease_Company2" value="<?php if(isset($drvehicles->Joint_Vehicle_Lease_Company2)){ echo $drvehicles->Joint_Vehicle_Lease_Company2; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6 Joint_Vehicle_Paying_Party2_Leased_Div" style="display: none;">
                                    <label>Monthly lease payment for this vehicle?</label>
                                    <input id="Joint_Vehicle_Monthly_Lease_Amount2" type="number" class="form-control 2_Joint_vehicles_inputs Joint_Vehicle_Paying_Party2_Leased_Input" name="Joint_Vehicle_Monthly_Lease_Amount2" value="<?php if(isset($drvehicles->Joint_Vehicle_Monthly_Lease_Amount2)){ echo $drvehicles->Joint_Vehicle_Monthly_Lease_Amount2; } ?>" min="0.00" step="0.01" max="999999.99">
                                </div>
                                <div class="form-group col-sm-6 Joint_Vehicle_Paying_Party2_Leased_Div" style="display: none;">
                                    <label>How will this leased vehicle be handled?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Joint_Vehicle_Lease_Disposition_Method2_Terminate_Lease" name="Joint_Vehicle_Lease_Disposition_Method2" value="Terminate Lease" <?php if(isset($drvehicles->Joint_Vehicle_Lease_Disposition_Method2) && $drvehicles->Joint_Vehicle_Lease_Disposition_Method2=='Terminate Lease'){ echo "checked"; } ?>> Terminate Lease</label>
                                        <label><input type="radio" id="Joint_Vehicle_Lease_Disposition_Method2_Transfer_Lease_Responsibility_to_ClientName" name="Joint_Vehicle_Lease_Disposition_Method2" value="Transfer Lease Responsibility to {{$client_name}}" <?php if(isset($drvehicles->Joint_Vehicle_Lease_Disposition_Method2) && $drvehicles->Joint_Vehicle_Lease_Disposition_Method2=='Transfer Lease Responsibility to '.$client_name.''){ echo "checked"; } ?>> Transfer Lease Responsibility to {{$client_name}}</label>
                                        <label><input type="radio" id="Joint_Vehicle_Lease_Disposition_Method2_Transfer_Lease_Responsibility_to_OpName" name="Joint_Vehicle_Lease_Disposition_Method2" value="Transfer Lease Responsibility to {{$opponent_name}}" <?php if(isset($drvehicles->Joint_Vehicle_Lease_Disposition_Method2) && $drvehicles->Joint_Vehicle_Lease_Disposition_Method2=='Transfer Lease Responsibility to '.$opponent_name.''){ echo "checked"; } ?>> Transfer Lease Responsibility to {{$opponent_name}}</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 mt-4 3_Joint_vehicles_section" style="display: none;"><h5 class="col-sm-12">Third Vehicle Info</h5>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_Vehicle_Year3">Model year of this vehicle?</label>
                                    <select id="Joint_Vehicle_Year3" name="Joint_Vehicle_Year3" class="form-control 3_Joint_vehicles_select">
                                        <?php 
                                            if(isset($drvehicles->Joint_Vehicle_Year3)){ 
                                                $already_selected_value = $drvehicles->Joint_Vehicle_Year3; 
                                            } else {
                                                $already_selected_value = '';
                                            }
                                            $earliest_year = 1900;
                                            foreach (range(date('Y'), $earliest_year) as $x) {
                                                echo '<option value="'.$x.'"'.($x == $already_selected_value ? ' selected="selected"' : '').'>'.$x.'</option>';
                                            }
                                        ?>
                                    </select>   
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_Vehicle_Make_Model3">What make and model is this vehicle?</label>
                                    <input id="Joint_Vehicle_Make_Model3" type="text" class="form-control 3_Joint_vehicles_inputs" name="Joint_Vehicle_Make_Model3" value="<?php if(isset($drvehicles->Joint_Vehicle_Make_Model3)){ echo $drvehicles->Joint_Vehicle_Make_Model3; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Is this vehicle leased or owned?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Joint_Vehicle_Owned_Leased3_Owned" name="Joint_Vehicle_Owned_Leased3" value="Owned" data-onload="getInitialVehicleOwnedLeased(this, '3', 'Joint');" onchange="getVehicleOwnedLeased(this, '3', 'Joint');" <?php if(isset($drvehicles->Joint_Vehicle_Owned_Leased3) && $drvehicles->Joint_Vehicle_Owned_Leased3=='Owned'){ echo "checked"; } ?>> Owned</label>
                                        <label><input type="radio" id="Joint_Vehicle_Owned_Leased3_Leased" name="Joint_Vehicle_Owned_Leased3" value="Leased" data-onload="getInitialVehicleOwnedLeased(this, '3', 'Joint');" onchange="getVehicleOwnedLeased(this, '3', 'Joint');" <?php if(isset($drvehicles->Joint_Vehicle_Owned_Leased3) && $drvehicles->Joint_Vehicle_Owned_Leased3=='Leased'){ echo "checked"; } ?>> Leased</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 Joint_Vehicle_Owned3_Div">
                                    <label for="Joint_Vehicle_VIN3">What is the VIN of this vehicle?</label>
                                    <input id="Joint_Vehicle_VIN3" type="text" class="form-control 3_Joint_vehicles_inputs" name="Joint_Vehicle_VIN3" value="<?php if(isset($drvehicles->Joint_Vehicle_VIN3)){ echo $drvehicles->Joint_Vehicle_VIN3; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6 Joint_Vehicle_Owned3_Div">
                                    <label for="Joint_Vehicle_Current_Value3">What is the current value of this vehicle?</label>
                                    <input id="Joint_Vehicle_Current_Value3" type="number" class="form-control 3_Joint_vehicles_inputs" name="Joint_Vehicle_Current_Value3" value="<?php if(isset($drvehicles->Joint_Vehicle_Current_Value3)){ echo $drvehicles->Joint_Vehicle_Current_Value3; } ?>" min="0.00" step="0.01" max="999999.99" onchange="getCurrentValue(this, '3', 'Joint');" onkeyup="getCurrentValue(this, '3', 'Joint');">
                                </div>
                                <div class="form-group col-sm-6 Joint_Vehicle_Owned3_Div">
                                    <label for="Joint_Vehicle_Loan_Company_Name3">Name of first car loan company?</label>
                                    <input id="Joint_Vehicle_Loan_Company_Name3" type="text" class="form-control 3_Joint_vehicles_inputs" name="Joint_Vehicle_Loan_Company_Name3" value="<?php if(isset($drvehicles->Joint_Vehicle_Loan_Company_Name3)){ echo $drvehicles->Joint_Vehicle_Loan_Company_Name3; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6 Joint_Vehicle_Owned3_Div">
                                    <label for="Joint_Vehicle_Loan_Balance3">Balance due to first car loan company for this vehicle?</label>
                                    <input id="Joint_Vehicle_Loan_Balance3" type="number" class="form-control 3_Joint_vehicles_inputs" name="Joint_Vehicle_Loan_Balance3" value="<?php if(isset($drvehicles->Joint_Vehicle_Loan_Balance3)){ echo $drvehicles->Joint_Vehicle_Loan_Balance3; } ?>" min="0.00" step="0.01" max="999999.99" onchange="getLoanBalance(this, '3', 'Joint');" onkeyup="getLoanBalance(this, '3', 'Joint');">
                                </div>
                                <div class="form-group col-sm-6 Joint_Vehicle_Owned3_Div">
                                    <label for="Joint_Vehicle_Loan_Monthly_Payment3">Monthly payment to first car loan company for this vehicle?</label>
                                    <input id="Joint_Vehicle_Loan_Monthly_Payment3" type="number" class="form-control 3_Joint_vehicles_inputs" name="Joint_Vehicle_Loan_Monthly_Payment3" value="<?php if(isset($drvehicles->Joint_Vehicle_Loan_Monthly_Payment3)){ echo $drvehicles->Joint_Vehicle_Loan_Monthly_Payment3; } ?>" min="0.00" step="0.01" max="999999.99">
                                </div>
                                <div class="form-group col-sm-6 Joint_Vehicle_Owned3_Div">
                                    <label for="Joint_Vehicle_Loan_Second_Company_Name3">Name of second car loan company?</label>
                                    <input id="Joint_Vehicle_Loan_Second_Company_Name3" type="text" class="form-control 3_Joint_vehicles_inputs" name="Joint_Vehicle_Loan_Second_Company_Name3" value="<?php if(isset($drvehicles->Joint_Vehicle_Loan_Second_Company_Name3)){ echo $drvehicles->Joint_Vehicle_Loan_Second_Company_Name3; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6 Joint_Vehicle_Owned3_Div">
                                    <label for="Joint_Vehicle_Loan_Second_Company_Balance3">Balance due to second car loan company for this vehicle?</label>
                                    <input id="Joint_Vehicle_Loan_Second_Company_Balance3" type="number" class="form-control 3_Joint_vehicles_inputs" name="Joint_Vehicle_Loan_Second_Company_Balance3" value="<?php if(isset($drvehicles->Joint_Vehicle_Loan_Second_Company_Balance3)){ echo $drvehicles->Joint_Vehicle_Loan_Second_Company_Balance3; } ?>" min="0.00" step="0.01" max="999999.99" onchange="getCompanyBalance(this, '3', 'Joint');" onkeyup="getCompanyBalance(this, '3', 'Joint');">
                                </div>
                                <div class="form-group col-sm-6 Joint_Vehicle_Owned3_Div">
                                    <label for="Joint_Vehicle_Loan_Second_Company_Monthly_Payment3">Monthly payment to second car loan company for this vehicle?</label>
                                    <input id="Joint_Vehicle_Loan_Second_Company_Monthly_Payment3" type="number" class="form-control 3_Joint_vehicles_inputs" name="Joint_Vehicle_Loan_Second_Company_Monthly_Payment3" value="<?php if(isset($drvehicles->Joint_Vehicle_Loan_Second_Company_Monthly_Payment3)){ echo $drvehicles->Joint_Vehicle_Loan_Second_Company_Monthly_Payment3; } ?>" min="0.00" step="0.01" max="999999.99">
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label for="Joint_Vehicle_Marital_Equity3">N/A, calculated = Joint_Vehicle_Current_Value3-Joint_Vehicle_Loan_Balance3-Joint_Vehicle_Loan_Second_Company_Balance3</label>
                                    <input id="Joint_Vehicle_Marital_Equity3" type="number" class="form-control 3_Joint_vehicles_inputs" name="Joint_Vehicle_Marital_Equity3" value="<?php if(isset($drvehicles->Joint_Vehicle_Marital_Equity3)){ echo $drvehicles->Joint_Vehicle_Marital_Equity3; } ?>" min="0.00" step="0.01" max="999999.99">
                                </div>
                                <div class="form-group col-sm-6 Joint_Vehicle_Owned3_Div">
                                    <label>Does either party claim a sole/separate interest in this vehicle?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Joint_Vehicle_SoleSeparate_Claim3_Yes" name="Joint_Vehicle_SoleSeparate_Claim3" value="Yes" data-onload="getInitialPartyClaimSoleSeparate(this, '3', 'Joint');" onchange="getPartyClaimSoleSeparate(this, '3', 'Joint');" <?php if(isset($drvehicles->Joint_Vehicle_SoleSeparate_Claim3) && $drvehicles->Joint_Vehicle_SoleSeparate_Claim3=='Yes'){ echo "checked"; } ?>> Yes</label>
                                        <label><input type="radio" id="Joint_Vehicle_SoleSeparate_Claim3_No" name="Joint_Vehicle_SoleSeparate_Claim3" value="No" data-onload="getInitialPartyClaimSoleSeparate(this, '3', 'Joint');" onchange="getPartyClaimSoleSeparate(this, '3', 'Joint');" <?php if(isset($drvehicles->Joint_Vehicle_SoleSeparate_Claim3) && $drvehicles->Joint_Vehicle_SoleSeparate_Claim3=='No'){ echo "checked"; } ?>> No</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 Joint_Vehicle_Owned3_Div" id="Joint_Vehicle_SoleSeparate_Party3_Div" style="display: none;">
                                    <label>Who claims to own this vehicle?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Joint_Vehicle_SoleSeparate_Party3_Client" name="Joint_Vehicle_SoleSeparate_Party3" value="{{$client_name}}" <?php if(isset($drvehicles->Joint_Vehicle_SoleSeparate_Party3) && $drvehicles->Joint_Vehicle_SoleSeparate_Party3==$client_name){ echo "checked"; } ?>> {{$client_name}}</label>
                                        <label><input type="radio" id="Joint_Vehicle_SoleSeparate_Party3_Op" name="Joint_Vehicle_SoleSeparate_Party3" value="{{$opponent_name}}" <?php if(isset($drvehicles->Joint_Vehicle_SoleSeparate_Party3) && $drvehicles->Joint_Vehicle_SoleSeparate_Party3==$opponent_name){ echo "checked"; } ?>> {{$opponent_name}}</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 Joint_Vehicle_Owned3_Div" id="Joint_Vehicle_SoleSeparate_Grounds3_Div" style="display: none;">
                                    <label for="Joint_Vehicle_SoleSeparate_Grounds3">Why does this person own this vehicle solely and separately?</label>
                                    <input id="Joint_Vehicle_SoleSeparate_Grounds3" type="text" class="form-control 3_Joint_vehicles_inputs" name="Joint_Vehicle_SoleSeparate_Grounds3" value="<?php if(isset($drvehicles->Joint_Vehicle_SoleSeparate_Grounds3)){ echo $drvehicles->Joint_Vehicle_SoleSeparate_Grounds3; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6 Joint_Vehicle_Owned3_Div">
                                    <label>How will this vehicle value be distributed between the parties?</label>
                                    <div class="w-100 dataInput">
                                        <label><input type="radio" id="Joint_Vehicle_Disposition_Method3_Liquidate_Split_Net_Value" name="Joint_Vehicle_Disposition_Method3" value="Liquidate/Split Net Value" data-onload="getInitialDipositionMethod(this, '3', 'Joint');" onchange="getDipositionMethod(this, '3', 'Joint');" <?php if(isset($drvehicles->Joint_Vehicle_Disposition_Method3) && $drvehicles->Joint_Vehicle_Disposition_Method3=='Liquidate/Split Net Value'){ echo "checked"; } ?>> Liquidate/Split Net Value</label>
                                        <label><input type="radio" id="Joint_Vehicle_Disposition_Method3_Fixed_Buyout" name="Joint_Vehicle_Disposition_Method3" value="Fixed Buyout" data-onload="getInitialDipositionMethod(this, '3', 'Joint');" onchange="getDipositionMethod(this, '3', 'Joint');" <?php if(isset($drvehicles->Joint_Vehicle_Disposition_Method3) && $drvehicles->Joint_Vehicle_Disposition_Method3=='Fixed Buyout'){ echo "checked"; } ?>> Fixed Buyout</label>
                                    </div>
                                </div>
                                <!-- slider tool -->
                                <div class="form-group col-sm-6 m-auto 3_Joint_Slider_Tool Joint_Vehicle_Owned3_Div">
                                    <div class="row">
                                        <div class="col">{{$client_name}}</div>
                                        <div class="col text-right">{{$opponent_name}}</div>
                                    </div>
                                    <input id="3_Joint_balance_range_selector" type="range" class="form-control slider-tool-input 3_Joint_balance_range_selector" name="" value="<?php if(isset($drvehicles->Joint_Vehicle_Percent_Marital_Equity_to_Op3)){ echo $drvehicles->Joint_Vehicle_Percent_Marital_Equity_to_Op3; } ?>" min="0.00" step="0.01" max="100" onchange="updateBalanceInput(this.value, '3', 'Joint');">
                                </div>
                                <div class="form-group col-sm-6 m-auto 3_Joint_Slider_Tool Joint_Vehicle_Owned3_Div">
                                    <div class="row justify-content-between">
                                        <div class="col selectorTool">
                                            <div class="left-col">
                                                <div class="client-info 3_Joint_clientpercentage_div clientpercentage_div">
                                                    <?php if(isset($drvehicles->Joint_Vehicle_Percent_Marital_Equity_to_Client3)){ echo $drvehicles->Joint_Vehicle_Percent_Marital_Equity_to_Client3; } else {
                                                        echo '50.00';
                                                    } ?>%
                                                </div>
                                                <div class="client-info 3_Joint_clientamount_div clientamount_div" style="clear: both;">
                                                    $<?php if(isset($drvehicles->Joint_Vehicle_Estimated_Value_to_Client3)){ echo $drvehicles->Joint_Vehicle_Estimated_Value_to_Client3; } else {
                                                        echo '50.00';
                                                    } ?>
                                                </div>
                                            </div>
                                            <label>To {{$client_name}}</label>
                                        </div>                                       
                                        <div class="col selectorTool selectorToolRight">
                                            <label>To {{$opponent_name}}</label>
                                            <div class="left-col right-col">
                                                <div class="client-info 3_Joint_opponentpercentage_div opponentpercentage_div">
                                                    <?php if(isset($drvehicles->Joint_Vehicle_Percent_Marital_Equity_to_Op3)){ echo $drvehicles->Joint_Vehicle_Percent_Marital_Equity_to_Op3; } else {
                                                        echo '50.00';
                                                    } ?>%
                                                </div>
                                                <div class="client-info 3_Joint_opponentamount_div opponentamount_div" style="clear: both;">
                                                    $<?php if(isset($drvehicles->Joint_Vehicle_Estimated_Value_to_Op3)){ echo $drvehicles->Joint_Vehicle_Estimated_Value_to_Op3; } else {
                                                        echo '50.00';
                                                    } ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 m-auto 3_Joint_Slider_Tool Joint_Vehicle_Owned3_Div">
                                    <label></label>
                                    <div class="w-100">
                                        <label><input type="radio" id="3_Joint_Vehicle_Estimated_Value_Select" name="3_Joint_Vehicle_Estimated_Value_Select_Reset" class="Vehicle_Estimated_Value_Select_Reset" value="Save"> Save this Distribution of Vehicles #3</label>
                                        <label><input type="radio" id="3_Joint_Vehicle_Estimated_Value_Reset" name="3_Joint_Vehicle_Estimated_Value_Select_Reset" class="Vehicle_Estimated_Value_Select_Reset" value="Reset" onclick="resetBalanceInput(this, '3', 'Joint');"> Reset to Default (50%)</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 Joint_Vehicle_Owned3_Div Joint_Vehicle_Paying_Party3_Inputs_Div" style="display: none;">
                                    <label>Joint Vehicles Paying Party3</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Joint_Vehicle_Paying_Party3_Client" name="Joint_Vehicle_Paying_Party3" value="{{$client_name}}" data-onload="getInitialVehiclesPayingParty(this, '3', 'Joint');" onchange="getVehiclesPayingParty(this, '3', 'Joint');" <?php if(isset($drvehicles->Joint_Vehicle_Paying_Party3) && $drvehicles->Joint_Vehicle_Paying_Party3==$client_name){ echo "checked"; } ?>> {{$client_name}}</label>
                                        <label><input type="radio" id="Joint_Vehicle_Paying_Party3_Op" name="Joint_Vehicle_Paying_Party3" value="{{$opponent_name}}" data-onload="getInitialVehiclesPayingParty(this, '3', 'Joint');" onchange="getVehiclesPayingParty(this, '3', 'Joint');" <?php if(isset($drvehicles->Joint_Vehicle_Paying_Party3) && $drvehicles->Joint_Vehicle_Paying_Party3==$opponent_name){ echo "checked"; } ?>> {{$opponent_name}}</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 Joint_Vehicle_Owned3_Div Joint_Vehicle_Paying_Party3_Inputs_Div" style="display: none;">
                                    <label>{{$client_name}} Vehicles Equity Percent</label>
                                    <input id="Joint_Vehicle_Percent_Marital_Equity_to_Client3" type="number" class="form-control 3_Joint_clientpercentage_input clientpercentage_input" name="Joint_Vehicle_Percent_Marital_Equity_to_Client3" value="<?php if(isset($drvehicles->Joint_Vehicle_Percent_Marital_Equity_to_Client3)){ echo $drvehicles->Joint_Vehicle_Percent_Marital_Equity_to_Client3; } ?>" min="0.00" step="0.01" max="100" readonly="">
                                </div>
                                <div class="form-group col-sm-6 Joint_Vehicle_Owned3_Div Joint_Vehicle_Paying_Party3_Inputs_Div" style="display: none;">
                                    <label>How much is to be paid to {{$client_name}}?</label>
                                    <input id="Joint_Vehicle_Estimated_Value_to_Client3" type="number" class="form-control 3_Joint_clientamount_input clientamount_input" name="Joint_Vehicle_Estimated_Value_to_Client3" value="<?php if(isset($drvehicles->Joint_Vehicle_Estimated_Value_to_Client3)){ echo $drvehicles->Joint_Vehicle_Estimated_Value_to_Client3; } ?>" min="0.00" step="0.01" max="999999.99" readonly="" onchange="getEstimatedValueClient(this, '3', 'Joint');" onkeyup="getEstimatedValueClient(this, '3', 'Joint');">
                                </div>
                                <div class="form-group col-sm-6 Joint_Vehicle_Owned3_Div Joint_Vehicle_Paying_Party3_Inputs_Div" style="display: none;">
                                    <label>{{$opponent_name}} Vehicles Equity Percent</label>
                                    <input id="Joint_Vehicle_Percent_Marital_Equity_to_Op3" type="number" class="form-control 3_Joint_opponentpercentage_input opponentpercentage_input" name="Joint_Vehicle_Percent_Marital_Equity_to_Op3" value="<?php if(isset($drvehicles->Joint_Vehicle_Percent_Marital_Equity_to_Op3)){ echo $drvehicles->Joint_Vehicle_Percent_Marital_Equity_to_Op3; } ?>" min="0.00" step="0.01" max="100" readonly="">
                                </div>
                                <div class="form-group col-sm-6 Joint_Vehicle_Owned3_Div Joint_Vehicle_Paying_Party3_Inputs_Div" style="display: none;">
                                    <label>How much is to be paid to {{$opponent_name}}?</label>
                                    <input id="Joint_Vehicle_Estimated_Value_to_Op3" type="number" class="form-control 3_Joint_opponentamount_input opponentamount_input" name="Joint_Vehicle_Estimated_Value_to_Op3" value="<?php if(isset($drvehicles->Joint_Vehicle_Estimated_Value_to_Op3)){ echo $drvehicles->Joint_Vehicle_Estimated_Value_to_Op3; } ?>" min="0.00" step="0.01" max="999999.99" readonly="" onchange="getEstimatedValueOp(this, '3', 'Joint');" onkeyup="getEstimatedValueOp(this, '3', 'Joint');">
                                </div>
                                <!-- end of slider tool -->
                                <div class="form-group col-sm-6 Joint_Vehicle_Paying_Party3_Leased_Div" style="display: none;">
                                    <label for="Joint_Vehicle_Lease_Company3">Name of vehicle lease company?</label>
                                    <input id="Joint_Vehicle_Lease_Company3" type="text" class="form-control 3_Joint_vehicles_inputs Joint_Vehicle_Paying_Party3_Leased_Input" name="Joint_Vehicle_Lease_Company3" value="<?php if(isset($drvehicles->Joint_Vehicle_Lease_Company3)){ echo $drvehicles->Joint_Vehicle_Lease_Company3; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6 Joint_Vehicle_Paying_Party3_Leased_Div" style="display: none;">
                                    <label>Monthly lease payment for this vehicle?</label>
                                    <input id="Joint_Vehicle_Monthly_Lease_Amount3" type="number" class="form-control 3_Joint_vehicles_inputs Joint_Vehicle_Paying_Party3_Leased_Input" name="Joint_Vehicle_Monthly_Lease_Amount3" value="<?php if(isset($drvehicles->Joint_Vehicle_Monthly_Lease_Amount3)){ echo $drvehicles->Joint_Vehicle_Monthly_Lease_Amount3; } ?>" min="0.00" step="0.01" max="999999.99">
                                </div>
                                <div class="form-group col-sm-6 Joint_Vehicle_Paying_Party3_Leased_Div" style="display: none;">
                                    <label>How will this leased vehicle be handled?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Joint_Vehicle_Lease_Disposition_Method3_Terminate_Lease" name="Joint_Vehicle_Lease_Disposition_Method3" value="Terminate Lease" <?php if(isset($drvehicles->Joint_Vehicle_Lease_Disposition_Method3) && $drvehicles->Joint_Vehicle_Lease_Disposition_Method3=='Terminate Lease'){ echo "checked"; } ?>> Terminate Lease</label>
                                        <label><input type="radio" id="Joint_Vehicle_Lease_Disposition_Method3_Transfer_Lease_Responsibility_to_ClientName" name="Joint_Vehicle_Lease_Disposition_Method3" value="Transfer Lease Responsibility to {{$client_name}}" <?php if(isset($drvehicles->Joint_Vehicle_Lease_Disposition_Method3) && $drvehicles->Joint_Vehicle_Lease_Disposition_Method3=='Transfer Lease Responsibility to '.$client_name.''){ echo "checked"; } ?>> Transfer Lease Responsibility to {{$client_name}}</label>
                                        <label><input type="radio" id="Joint_Vehicle_Lease_Disposition_Method3_Transfer_Lease_Responsibility_to_OpName" name="Joint_Vehicle_Lease_Disposition_Method3" value="Transfer Lease Responsibility to {{$opponent_name}}" <?php if(isset($drvehicles->Joint_Vehicle_Lease_Disposition_Method3) && $drvehicles->Joint_Vehicle_Lease_Disposition_Method3=='Transfer Lease Responsibility to '.$opponent_name.''){ echo "checked"; } ?>> Transfer Lease Responsibility to {{$opponent_name}}</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 mt-4 4_Joint_vehicles_section" style="display: none;"><h5 class="col-sm-12">Fourth Vehicle Info</h5>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_Vehicle_Year4">Model year of this vehicle?</label>
                                    <select id="Joint_Vehicle_Year4" name="Joint_Vehicle_Year4" class="form-control 4_Joint_vehicles_select">
                                        <?php 
                                            if(isset($drvehicles->Joint_Vehicle_Year4)){ 
                                                $already_selected_value = $drvehicles->Joint_Vehicle_Year4; 
                                            } else {
                                                $already_selected_value = '';
                                            }
                                            $earliest_year = 1900;
                                            foreach (range(date('Y'), $earliest_year) as $x) {
                                                echo '<option value="'.$x.'"'.($x == $already_selected_value ? ' selected="selected"' : '').'>'.$x.'</option>';
                                            }
                                        ?>
                                    </select>   
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_Vehicle_Make_Model4">What make and model is this vehicle?</label>
                                    <input id="Joint_Vehicle_Make_Model4" type="text" class="form-control 4_Joint_vehicles_inputs" name="Joint_Vehicle_Make_Model4" value="<?php if(isset($drvehicles->Joint_Vehicle_Make_Model4)){ echo $drvehicles->Joint_Vehicle_Make_Model4; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Is this vehicle leased or owned?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Joint_Vehicle_Owned_Leased4_Owned" name="Joint_Vehicle_Owned_Leased4" value="Owned" data-onload="getInitialVehicleOwnedLeased(this, '4', 'Joint');" onchange="getVehicleOwnedLeased(this, '4', 'Joint');" <?php if(isset($drvehicles->Joint_Vehicle_Owned_Leased4) && $drvehicles->Joint_Vehicle_Owned_Leased4=='Owned'){ echo "checked"; } ?>> Owned</label>
                                        <label><input type="radio" id="Joint_Vehicle_Owned_Leased4_Leased" name="Joint_Vehicle_Owned_Leased4" value="Leased" data-onload="getInitialVehicleOwnedLeased(this, '4', 'Joint');" onchange="getVehicleOwnedLeased(this, '4', 'Joint');" <?php if(isset($drvehicles->Joint_Vehicle_Owned_Leased4) && $drvehicles->Joint_Vehicle_Owned_Leased4=='Leased'){ echo "checked"; } ?>> Leased</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 Joint_Vehicle_Owned4_Div">
                                    <label for="Joint_Vehicle_VIN4">What is the VIN of this vehicle?</label>
                                    <input id="Joint_Vehicle_VIN4" type="text" class="form-control 4_Joint_vehicles_inputs" name="Joint_Vehicle_VIN4" value="<?php if(isset($drvehicles->Joint_Vehicle_VIN4)){ echo $drvehicles->Joint_Vehicle_VIN4; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6 Joint_Vehicle_Owned4_Div">
                                    <label for="Joint_Vehicle_Current_Value4">What is the current value of this vehicle?</label>
                                    <input id="Joint_Vehicle_Current_Value4" type="number" class="form-control 4_Joint_vehicles_inputs" name="Joint_Vehicle_Current_Value4" value="<?php if(isset($drvehicles->Joint_Vehicle_Current_Value4)){ echo $drvehicles->Joint_Vehicle_Current_Value4; } ?>" min="0.00" step="0.01" max="999999.99" onchange="getCurrentValue(this, '4', 'Joint');" onkeyup="getCurrentValue(this, '4', 'Joint');">
                                </div>
                                <div class="form-group col-sm-6 Joint_Vehicle_Owned4_Div">
                                    <label for="Joint_Vehicle_Loan_Company_Name4">Name of first car loan company?</label>
                                    <input id="Joint_Vehicle_Loan_Company_Name4" type="text" class="form-control 4_Joint_vehicles_inputs" name="Joint_Vehicle_Loan_Company_Name4" value="<?php if(isset($drvehicles->Joint_Vehicle_Loan_Company_Name4)){ echo $drvehicles->Joint_Vehicle_Loan_Company_Name4; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6 Joint_Vehicle_Owned4_Div">
                                    <label for="Joint_Vehicle_Loan_Balance4">Balance due to first car loan company for this vehicle?</label>
                                    <input id="Joint_Vehicle_Loan_Balance4" type="number" class="form-control 4_Joint_vehicles_inputs" name="Joint_Vehicle_Loan_Balance4" value="<?php if(isset($drvehicles->Joint_Vehicle_Loan_Balance4)){ echo $drvehicles->Joint_Vehicle_Loan_Balance4; } ?>" min="0.00" step="0.01" max="999999.99" onchange="getLoanBalance(this, '4', 'Joint');" onkeyup="getLoanBalance(this, '4', 'Joint');">
                                </div>
                                <div class="form-group col-sm-6 Joint_Vehicle_Owned4_Div">
                                    <label for="Joint_Vehicle_Loan_Monthly_Payment4">Monthly payment to first car loan company for this vehicle?</label>
                                    <input id="Joint_Vehicle_Loan_Monthly_Payment4" type="number" class="form-control 4_Joint_vehicles_inputs" name="Joint_Vehicle_Loan_Monthly_Payment4" value="<?php if(isset($drvehicles->Joint_Vehicle_Loan_Monthly_Payment4)){ echo $drvehicles->Joint_Vehicle_Loan_Monthly_Payment4; } ?>" min="0.00" step="0.01" max="999999.99">
                                </div>
                                <div class="form-group col-sm-6 Joint_Vehicle_Owned4_Div">
                                    <label for="Joint_Vehicle_Loan_Second_Company_Name4">Name of second car loan company?</label>
                                    <input id="Joint_Vehicle_Loan_Second_Company_Name4" type="text" class="form-control 4_Joint_vehicles_inputs" name="Joint_Vehicle_Loan_Second_Company_Name4" value="<?php if(isset($drvehicles->Joint_Vehicle_Loan_Second_Company_Name4)){ echo $drvehicles->Joint_Vehicle_Loan_Second_Company_Name4; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6 Joint_Vehicle_Owned4_Div">
                                    <label for="Joint_Vehicle_Loan_Second_Company_Balance4">Balance due to second car loan company for this vehicle?</label>
                                    <input id="Joint_Vehicle_Loan_Second_Company_Balance4" type="number" class="form-control 4_Joint_vehicles_inputs" name="Joint_Vehicle_Loan_Second_Company_Balance4" value="<?php if(isset($drvehicles->Joint_Vehicle_Loan_Second_Company_Balance4)){ echo $drvehicles->Joint_Vehicle_Loan_Second_Company_Balance4; } ?>" min="0.00" step="0.01" max="999999.99" onchange="getCompanyBalance(this, '4', 'Joint');" onkeyup="getCompanyBalance(this, '4', 'Joint');">
                                </div>
                                <div class="form-group col-sm-6 Joint_Vehicle_Owned4_Div">
                                    <label for="Joint_Vehicle_Loan_Second_Company_Monthly_Payment4">Monthly payment to second car loan company for this vehicle?</label>
                                    <input id="Joint_Vehicle_Loan_Second_Company_Monthly_Payment4" type="number" class="form-control 4_Joint_vehicles_inputs" name="Joint_Vehicle_Loan_Second_Company_Monthly_Payment4" value="<?php if(isset($drvehicles->Joint_Vehicle_Loan_Second_Company_Monthly_Payment4)){ echo $drvehicles->Joint_Vehicle_Loan_Second_Company_Monthly_Payment4; } ?>" min="0.00" step="0.01" max="999999.99">
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label for="Joint_Vehicle_Marital_Equity4">N/A, calculated = Joint_Vehicle_Current_Value4-Joint_Vehicle_Loan_Balance4-Joint_Vehicle_Loan_Second_Company_Balance4</label>
                                    <input id="Joint_Vehicle_Marital_Equity4" type="number" class="form-control 4_Joint_vehicles_inputs" name="Joint_Vehicle_Marital_Equity4" value="<?php if(isset($drvehicles->Joint_Vehicle_Marital_Equity4)){ echo $drvehicles->Joint_Vehicle_Marital_Equity4; } ?>" min="0.00" step="0.01" max="999999.99">
                                </div>
                                <div class="form-group col-sm-6 Joint_Vehicle_Owned4_Div">
                                    <label>Does either party claim a sole/separate interest in this vehicle?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Joint_Vehicle_SoleSeparate_Claim4_Yes" name="Joint_Vehicle_SoleSeparate_Claim4" value="Yes" data-onload="getInitialPartyClaimSoleSeparate(this, '4', 'Joint');" onchange="getPartyClaimSoleSeparate(this, '4', 'Joint');" <?php if(isset($drvehicles->Joint_Vehicle_SoleSeparate_Claim4) && $drvehicles->Joint_Vehicle_SoleSeparate_Claim4=='Yes'){ echo "checked"; } ?>> Yes</label>
                                        <label><input type="radio" id="Joint_Vehicle_SoleSeparate_Claim4_No" name="Joint_Vehicle_SoleSeparate_Claim4" value="No" data-onload="getInitialPartyClaimSoleSeparate(this, '4', 'Joint');" onchange="getPartyClaimSoleSeparate(this, '4', 'Joint');" <?php if(isset($drvehicles->Joint_Vehicle_SoleSeparate_Claim4) && $drvehicles->Joint_Vehicle_SoleSeparate_Claim4=='No'){ echo "checked"; } ?>> No</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 Joint_Vehicle_Owned4_Div" id="Joint_Vehicle_SoleSeparate_Party4_Div" style="display: none;">
                                    <label>Who claims to own this vehicle?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Joint_Vehicle_SoleSeparate_Party4_Client" name="Joint_Vehicle_SoleSeparate_Party4" value="{{$client_name}}" <?php if(isset($drvehicles->Joint_Vehicle_SoleSeparate_Party4) && $drvehicles->Joint_Vehicle_SoleSeparate_Party4==$client_name){ echo "checked"; } ?>> {{$client_name}}</label>
                                        <label><input type="radio" id="Joint_Vehicle_SoleSeparate_Party4_Op" name="Joint_Vehicle_SoleSeparate_Party4" value="{{$opponent_name}}" <?php if(isset($drvehicles->Joint_Vehicle_SoleSeparate_Party4) && $drvehicles->Joint_Vehicle_SoleSeparate_Party4==$opponent_name){ echo "checked"; } ?>> {{$opponent_name}}</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 Joint_Vehicle_Owned4_Div" id="Joint_Vehicle_SoleSeparate_Grounds4_Div" style="display: none;">
                                    <label for="Joint_Vehicle_SoleSeparate_Grounds4">Why does this person own this vehicle solely and separately?</label>
                                    <input id="Joint_Vehicle_SoleSeparate_Grounds4" type="text" class="form-control 4_Joint_vehicles_inputs" name="Joint_Vehicle_SoleSeparate_Grounds4" value="<?php if(isset($drvehicles->Joint_Vehicle_SoleSeparate_Grounds4)){ echo $drvehicles->Joint_Vehicle_SoleSeparate_Grounds4; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6 Joint_Vehicle_Owned4_Div">
                                    <label>How will this vehicle value be distributed between the parties?</label>
                                    <div class="w-100 dataInput">
                                        <label><input type="radio" id="Joint_Vehicle_Disposition_Method4_Liquidate_Split_Net_Value" name="Joint_Vehicle_Disposition_Method4" value="Liquidate/Split Net Value" data-onload="getInitialDipositionMethod(this, '4', 'Joint');" onchange="getDipositionMethod(this, '4', 'Joint');" <?php if(isset($drvehicles->Joint_Vehicle_Disposition_Method4) && $drvehicles->Joint_Vehicle_Disposition_Method4=='Liquidate/Split Net Value'){ echo "checked"; } ?>> Liquidate/Split Net Value</label>
                                        <label><input type="radio" id="Joint_Vehicle_Disposition_Method4_Fixed_Buyout" name="Joint_Vehicle_Disposition_Method4" value="Fixed Buyout" data-onload="getInitialDipositionMethod(this, '4', 'Joint');" onchange="getDipositionMethod(this, '4', 'Joint');" <?php if(isset($drvehicles->Joint_Vehicle_Disposition_Method4) && $drvehicles->Joint_Vehicle_Disposition_Method4=='Fixed Buyout'){ echo "checked"; } ?>> Fixed Buyout</label>
                                    </div>
                                </div>
                                <!-- slider tool -->
                                <div class="form-group col-sm-6 m-auto 4_Joint_Slider_Tool Joint_Vehicle_Owned4_Div">
                                    <div class="row">
                                        <div class="col">{{$client_name}}</div>
                                        <div class="col text-right">{{$opponent_name}}</div>
                                    </div>
                                    <input id="4_Joint_balance_range_selector" type="range" class="form-control slider-tool-input 4_Joint_balance_range_selector" name="" value="<?php if(isset($drvehicles->Joint_Vehicle_Percent_Marital_Equity_to_Op4)){ echo $drvehicles->Joint_Vehicle_Percent_Marital_Equity_to_Op4; } ?>" min="0.00" step="0.01" max="100" onchange="updateBalanceInput(this.value, '4', 'Joint');">
                                </div>
                                <div class="form-group col-sm-6 m-auto 4_Joint_Slider_Tool Joint_Vehicle_Owned4_Div">
                                    <div class="row justify-content-between">
                                        <div class="col selectorTool">
                                            <div class="left-col">
                                                <div class="client-info 4_Joint_clientpercentage_div clientpercentage_div">
                                                    <?php if(isset($drvehicles->Joint_Vehicle_Percent_Marital_Equity_to_Client4)){ echo $drvehicles->Joint_Vehicle_Percent_Marital_Equity_to_Client4; } else {
                                                        echo '50.00';
                                                    } ?>%
                                                </div>
                                                <div class="client-info 4_Joint_clientamount_div clientamount_div" style="clear: both;">
                                                    $<?php if(isset($drvehicles->Joint_Vehicle_Estimated_Value_to_Client4)){ echo $drvehicles->Joint_Vehicle_Estimated_Value_to_Client4; } else {
                                                        echo '50.00';
                                                    } ?>
                                                </div>
                                            </div>
                                            <label>To {{$client_name}}</label>
                                        </div>                                       
                                        <div class="col selectorTool selectorToolRight">
                                            <label>To {{$opponent_name}}</label>
                                            <div class="left-col right-col">
                                                <div class="client-info 4_Joint_opponentpercentage_div opponentpercentage_div">
                                                    <?php if(isset($drvehicles->Joint_Vehicle_Percent_Marital_Equity_to_Op4)){ echo $drvehicles->Joint_Vehicle_Percent_Marital_Equity_to_Op4; } else {
                                                        echo '50.00';
                                                    } ?>%
                                                </div>
                                                <div class="client-info 4_Joint_opponentamount_div opponentamount_div" style="clear: both;">
                                                    $<?php if(isset($drvehicles->Joint_Vehicle_Estimated_Value_to_Op4)){ echo $drvehicles->Joint_Vehicle_Estimated_Value_to_Op4; } else {
                                                        echo '50.00';
                                                    } ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 m-auto 4_Joint_Slider_Tool Joint_Vehicle_Owned4_Div">
                                    <label></label>
                                    <div class="w-100">
                                        <label><input type="radio" id="4_Joint_Vehicle_Estimated_Value_Select" name="4_Joint_Vehicle_Estimated_Value_Select_Reset" class="Vehicle_Estimated_Value_Select_Reset" value="Save"> Save this Distribution of Vehicles #4</label>
                                        <label><input type="radio" id="4_Joint_Vehicle_Estimated_Value_Reset" name="4_Joint_Vehicle_Estimated_Value_Select_Reset" class="Vehicle_Estimated_Value_Select_Reset" value="Reset" onclick="resetBalanceInput(this, '4', 'Joint');"> Reset to Default (50%)</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 Joint_Vehicle_Owned4_Div Joint_Vehicle_Paying_Party4_Inputs_Div" style="display: none;">
                                    <label>Joint Vehicles Paying Party4</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Joint_Vehicle_Paying_Party4_Client" name="Joint_Vehicle_Paying_Party4" value="{{$client_name}}" data-onload="getInitialVehiclesPayingParty(this, '4', 'Joint');" onchange="getVehiclesPayingParty(this, '4', 'Joint');" <?php if(isset($drvehicles->Joint_Vehicle_Paying_Party4) && $drvehicles->Joint_Vehicle_Paying_Party4==$client_name){ echo "checked"; } ?>> {{$client_name}}</label>
                                        <label><input type="radio" id="Joint_Vehicle_Paying_Party4_Op" name="Joint_Vehicle_Paying_Party4" value="{{$opponent_name}}" data-onload="getInitialVehiclesPayingParty(this, '4', 'Joint');" onchange="getVehiclesPayingParty(this, '4', 'Joint');" <?php if(isset($drvehicles->Joint_Vehicle_Paying_Party4) && $drvehicles->Joint_Vehicle_Paying_Party4==$opponent_name){ echo "checked"; } ?>> {{$opponent_name}}</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 Joint_Vehicle_Owned4_Div Joint_Vehicle_Paying_Party4_Inputs_Div" style="display: none;">
                                    <label>{{$client_name}} Vehicles Equity Percent</label>
                                    <input id="Joint_Vehicle_Percent_Marital_Equity_to_Client4" type="number" class="form-control 4_Joint_clientpercentage_input clientpercentage_input" name="Joint_Vehicle_Percent_Marital_Equity_to_Client4" value="<?php if(isset($drvehicles->Joint_Vehicle_Percent_Marital_Equity_to_Client4)){ echo $drvehicles->Joint_Vehicle_Percent_Marital_Equity_to_Client4; } ?>" min="0.00" step="0.01" max="100" readonly="">
                                </div>
                                <div class="form-group col-sm-6 Joint_Vehicle_Owned4_Div Joint_Vehicle_Paying_Party4_Inputs_Div" style="display: none;">
                                    <label>How much is to be paid to {{$client_name}}?</label>
                                    <input id="Joint_Vehicle_Estimated_Value_to_Client4" type="number" class="form-control 4_Joint_clientamount_input clientamount_input" name="Joint_Vehicle_Estimated_Value_to_Client4" value="<?php if(isset($drvehicles->Joint_Vehicle_Estimated_Value_to_Client4)){ echo $drvehicles->Joint_Vehicle_Estimated_Value_to_Client4; } ?>" min="0.00" step="0.01" max="999999.99" readonly="" onchange="getEstimatedValueClient(this, '4', 'Joint');" onkeyup="getEstimatedValueClient(this, '4', 'Joint');">
                                </div>
                                <div class="form-group col-sm-6 Joint_Vehicle_Owned4_Div Joint_Vehicle_Paying_Party4_Inputs_Div" style="display: none;">
                                    <label>{{$opponent_name}} Vehicles Equity Percent</label>
                                    <input id="Joint_Vehicle_Percent_Marital_Equity_to_Op4" type="number" class="form-control 4_Joint_opponentpercentage_input opponentpercentage_input" name="Joint_Vehicle_Percent_Marital_Equity_to_Op4" value="<?php if(isset($drvehicles->Joint_Vehicle_Percent_Marital_Equity_to_Op4)){ echo $drvehicles->Joint_Vehicle_Percent_Marital_Equity_to_Op4; } ?>" min="0.00" step="0.01" max="100" readonly="">
                                </div>
                                <div class="form-group col-sm-6 Joint_Vehicle_Owned4_Div Joint_Vehicle_Paying_Party4_Inputs_Div" style="display: none;">
                                    <label>How much is to be paid to {{$opponent_name}}?</label>
                                    <input id="Joint_Vehicle_Estimated_Value_to_Op4" type="number" class="form-control 4_Joint_opponentamount_input opponentamount_input" name="Joint_Vehicle_Estimated_Value_to_Op4" value="<?php if(isset($drvehicles->Joint_Vehicle_Estimated_Value_to_Op4)){ echo $drvehicles->Joint_Vehicle_Estimated_Value_to_Op4; } ?>" min="0.00" step="0.01" max="999999.99" readonly="" onchange="getEstimatedValueOp(this, '4', 'Joint');" onkeyup="getEstimatedValueOp(this, '4', 'Joint');">
                                </div>
                                <!-- end of slider tool -->
                                <div class="form-group col-sm-6 Joint_Vehicle_Paying_Party4_Leased_Div" style="display: none;">
                                    <label for="Joint_Vehicle_Lease_Company4">Name of vehicle lease company?</label>
                                    <input id="Joint_Vehicle_Lease_Company4" type="text" class="form-control 4_Joint_vehicles_inputs Joint_Vehicle_Paying_Party4_Leased_Input" name="Joint_Vehicle_Lease_Company4" value="<?php if(isset($drvehicles->Joint_Vehicle_Lease_Company4)){ echo $drvehicles->Joint_Vehicle_Lease_Company4; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6 Joint_Vehicle_Paying_Party4_Leased_Div" style="display: none;">
                                    <label>Monthly lease payment for this vehicle?</label>
                                    <input id="Joint_Vehicle_Monthly_Lease_Amount4" type="number" class="form-control 4_Joint_vehicles_inputs Joint_Vehicle_Paying_Party4_Leased_Input" name="Joint_Vehicle_Monthly_Lease_Amount4" value="<?php if(isset($drvehicles->Joint_Vehicle_Monthly_Lease_Amount4)){ echo $drvehicles->Joint_Vehicle_Monthly_Lease_Amount4; } ?>" min="0.00" step="0.01" max="999999.99">
                                </div>
                                <div class="form-group col-sm-6 Joint_Vehicle_Paying_Party4_Leased_Div" style="display: none;">
                                    <label>How will this leased vehicle be handled?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Joint_Vehicle_Lease_Disposition_Method4_Terminate_Lease" name="Joint_Vehicle_Lease_Disposition_Method4" value="Terminate Lease" <?php if(isset($drvehicles->Joint_Vehicle_Lease_Disposition_Method4) && $drvehicles->Joint_Vehicle_Lease_Disposition_Method4=='Terminate Lease'){ echo "checked"; } ?>> Terminate Lease</label>
                                        <label><input type="radio" id="Joint_Vehicle_Lease_Disposition_Method4_Transfer_Lease_Responsibility_to_ClientName" name="Joint_Vehicle_Lease_Disposition_Method4" value="Transfer Lease Responsibility to {{$client_name}}" <?php if(isset($drvehicles->Joint_Vehicle_Lease_Disposition_Method4) && $drvehicles->Joint_Vehicle_Lease_Disposition_Method4=='Transfer Lease Responsibility to '.$client_name.''){ echo "checked"; } ?>> Transfer Lease Responsibility to {{$client_name}}</label>
                                        <label><input type="radio" id="Joint_Vehicle_Lease_Disposition_Method4_Transfer_Lease_Responsibility_to_OpName" name="Joint_Vehicle_Lease_Disposition_Method4" value="Transfer Lease Responsibility to {{$opponent_name}}" <?php if(isset($drvehicles->Joint_Vehicle_Lease_Disposition_Method4) && $drvehicles->Joint_Vehicle_Lease_Disposition_Method4=='Transfer Lease Responsibility to '.$opponent_name.''){ echo "checked"; } ?>> Transfer Lease Responsibility to {{$opponent_name}}</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 mt-4 5_Joint_vehicles_section" style="display: none;"><h5 class="col-sm-12">Fifth Vehicle Info</h5>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_Vehicle_Year5">Model year of this vehicle?</label>
                                    <select id="Joint_Vehicle_Year5" name="Joint_Vehicle_Year5" class="form-control 5_Joint_vehicles_select">
                                        <?php 
                                            if(isset($drvehicles->Joint_Vehicle_Year5)){ 
                                                $already_selected_value = $drvehicles->Joint_Vehicle_Year5; 
                                            } else {
                                                $already_selected_value = '';
                                            }
                                            $earliest_year = 1900;
                                            foreach (range(date('Y'), $earliest_year) as $x) {
                                                echo '<option value="'.$x.'"'.($x == $already_selected_value ? ' selected="selected"' : '').'>'.$x.'</option>';
                                            }
                                        ?>
                                    </select>   
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_Vehicle_Make_Model5">What make and model is this vehicle?</label>
                                    <input id="Joint_Vehicle_Make_Model5" type="text" class="form-control 5_Joint_vehicles_inputs" name="Joint_Vehicle_Make_Model5" value="<?php if(isset($drvehicles->Joint_Vehicle_Make_Model5)){ echo $drvehicles->Joint_Vehicle_Make_Model5; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Is this vehicle leased or owned?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Joint_Vehicle_Owned_Leased5_Owned" name="Joint_Vehicle_Owned_Leased5" value="Owned" data-onload="getInitialVehicleOwnedLeased(this, '5', 'Joint');" onchange="getVehicleOwnedLeased(this, '5', 'Joint');" <?php if(isset($drvehicles->Joint_Vehicle_Owned_Leased5) && $drvehicles->Joint_Vehicle_Owned_Leased5=='Owned'){ echo "checked"; } ?>> Owned</label>
                                        <label><input type="radio" id="Joint_Vehicle_Owned_Leased5_Leased" name="Joint_Vehicle_Owned_Leased5" value="Leased" data-onload="getInitialVehicleOwnedLeased(this, '5', 'Joint');" onchange="getVehicleOwnedLeased(this, '5', 'Joint');" <?php if(isset($drvehicles->Joint_Vehicle_Owned_Leased5) && $drvehicles->Joint_Vehicle_Owned_Leased5=='Leased'){ echo "checked"; } ?>> Leased</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 Joint_Vehicle_Owned5_Div">
                                    <label for="Joint_Vehicle_VIN5">What is the VIN of this vehicle?</label>
                                    <input id="Joint_Vehicle_VIN5" type="text" class="form-control 5_Joint_vehicles_inputs" name="Joint_Vehicle_VIN5" value="<?php if(isset($drvehicles->Joint_Vehicle_VIN5)){ echo $drvehicles->Joint_Vehicle_VIN5; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6 Joint_Vehicle_Owned5_Div">
                                    <label for="Joint_Vehicle_Current_Value5">What is the current value of this vehicle?</label>
                                    <input id="Joint_Vehicle_Current_Value5" type="number" class="form-control 5_Joint_vehicles_inputs" name="Joint_Vehicle_Current_Value5" value="<?php if(isset($drvehicles->Joint_Vehicle_Current_Value5)){ echo $drvehicles->Joint_Vehicle_Current_Value5; } ?>" min="0.00" step="0.01" max="999999.99" onchange="getCurrentValue(this, '5', 'Joint');" onkeyup="getCurrentValue(this, '5', 'Joint');">
                                </div>
                                <div class="form-group col-sm-6 Joint_Vehicle_Owned5_Div">
                                    <label for="Joint_Vehicle_Loan_Company_Name5">Name of first car loan company?</label>
                                    <input id="Joint_Vehicle_Loan_Company_Name5" type="text" class="form-control 5_Joint_vehicles_inputs" name="Joint_Vehicle_Loan_Company_Name5" value="<?php if(isset($drvehicles->Joint_Vehicle_Loan_Company_Name5)){ echo $drvehicles->Joint_Vehicle_Loan_Company_Name5; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6 Joint_Vehicle_Owned5_Div">
                                    <label for="Joint_Vehicle_Loan_Balance5">Balance due to first car loan company for this vehicle?</label>
                                    <input id="Joint_Vehicle_Loan_Balance5" type="number" class="form-control 5_Joint_vehicles_inputs" name="Joint_Vehicle_Loan_Balance5" value="<?php if(isset($drvehicles->Joint_Vehicle_Loan_Balance5)){ echo $drvehicles->Joint_Vehicle_Loan_Balance5; } ?>" min="0.00" step="0.01" max="999999.99" onchange="getLoanBalance(this, '5', 'Joint');" onkeyup="getLoanBalance(this, '5', 'Joint');">
                                </div>
                                <div class="form-group col-sm-6 Joint_Vehicle_Owned5_Div">
                                    <label for="Joint_Vehicle_Loan_Monthly_Payment5">Monthly payment to first car loan company for this vehicle?</label>
                                    <input id="Joint_Vehicle_Loan_Monthly_Payment5" type="number" class="form-control 5_Joint_vehicles_inputs" name="Joint_Vehicle_Loan_Monthly_Payment5" value="<?php if(isset($drvehicles->Joint_Vehicle_Loan_Monthly_Payment5)){ echo $drvehicles->Joint_Vehicle_Loan_Monthly_Payment5; } ?>" min="0.00" step="0.01" max="999999.99">
                                </div>
                                <div class="form-group col-sm-6 Joint_Vehicle_Owned5_Div">
                                    <label for="Joint_Vehicle_Loan_Second_Company_Name5">Name of second car loan company?</label>
                                    <input id="Joint_Vehicle_Loan_Second_Company_Name5" type="text" class="form-control 5_Joint_vehicles_inputs" name="Joint_Vehicle_Loan_Second_Company_Name5" value="<?php if(isset($drvehicles->Joint_Vehicle_Loan_Second_Company_Name5)){ echo $drvehicles->Joint_Vehicle_Loan_Second_Company_Name5; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6 Joint_Vehicle_Owned5_Div">
                                    <label for="Joint_Vehicle_Loan_Second_Company_Balance5">Balance due to second car loan company for this vehicle?</label>
                                    <input id="Joint_Vehicle_Loan_Second_Company_Balance5" type="number" class="form-control 5_Joint_vehicles_inputs" name="Joint_Vehicle_Loan_Second_Company_Balance5" value="<?php if(isset($drvehicles->Joint_Vehicle_Loan_Second_Company_Balance5)){ echo $drvehicles->Joint_Vehicle_Loan_Second_Company_Balance5; } ?>" min="0.00" step="0.01" max="999999.99" onchange="getCompanyBalance(this, '5', 'Joint');" onkeyup="getCompanyBalance(this, '5', 'Joint');">
                                </div>
                                <div class="form-group col-sm-6 Joint_Vehicle_Owned5_Div">
                                    <label for="Joint_Vehicle_Loan_Second_Company_Monthly_Payment5">Monthly payment to second car loan company for this vehicle?</label>
                                    <input id="Joint_Vehicle_Loan_Second_Company_Monthly_Payment5" type="number" class="form-control 5_Joint_vehicles_inputs" name="Joint_Vehicle_Loan_Second_Company_Monthly_Payment5" value="<?php if(isset($drvehicles->Joint_Vehicle_Loan_Second_Company_Monthly_Payment5)){ echo $drvehicles->Joint_Vehicle_Loan_Second_Company_Monthly_Payment5; } ?>" min="0.00" step="0.01" max="999999.99">
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label for="Joint_Vehicle_Marital_Equity5">N/A, calculated = Joint_Vehicle_Current_Value5-Joint_Vehicle_Loan_Balance5-Joint_Vehicle_Loan_Second_Company_Balance5</label>
                                    <input id="Joint_Vehicle_Marital_Equity5" type="number" class="form-control 5_Joint_vehicles_inputs" name="Joint_Vehicle_Marital_Equity5" value="<?php if(isset($drvehicles->Joint_Vehicle_Marital_Equity5)){ echo $drvehicles->Joint_Vehicle_Marital_Equity5; } ?>" min="0.00" step="0.01" max="999999.99">
                                </div>
                                <div class="form-group col-sm-6 Joint_Vehicle_Owned5_Div">
                                    <label>Does either party claim a sole/separate interest in this vehicle?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Joint_Vehicle_SoleSeparate_Claim5_Yes" name="Joint_Vehicle_SoleSeparate_Claim5" value="Yes" data-onload="getInitialPartyClaimSoleSeparate(this, '5', 'Joint');" onchange="getPartyClaimSoleSeparate(this, '5', 'Joint');" <?php if(isset($drvehicles->Joint_Vehicle_SoleSeparate_Claim5) && $drvehicles->Joint_Vehicle_SoleSeparate_Claim5=='Yes'){ echo "checked"; } ?>> Yes</label>
                                        <label><input type="radio" id="Joint_Vehicle_SoleSeparate_Claim5_No" name="Joint_Vehicle_SoleSeparate_Claim5" value="No" data-onload="getInitialPartyClaimSoleSeparate(this, '5', 'Joint');" onchange="getPartyClaimSoleSeparate(this, '5', 'Joint');" <?php if(isset($drvehicles->Joint_Vehicle_SoleSeparate_Claim5) && $drvehicles->Joint_Vehicle_SoleSeparate_Claim5=='No'){ echo "checked"; } ?>> No</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 Joint_Vehicle_Owned5_Div" id="Joint_Vehicle_SoleSeparate_Party5_Div" style="display: none;">
                                    <label>Who claims to own this vehicle?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Joint_Vehicle_SoleSeparate_Party5_Client" name="Joint_Vehicle_SoleSeparate_Party5" value="{{$client_name}}" <?php if(isset($drvehicles->Joint_Vehicle_SoleSeparate_Party5) && $drvehicles->Joint_Vehicle_SoleSeparate_Party5==$client_name){ echo "checked"; } ?>> {{$client_name}}</label>
                                        <label><input type="radio" id="Joint_Vehicle_SoleSeparate_Party5_Op" name="Joint_Vehicle_SoleSeparate_Party5" value="{{$opponent_name}}" <?php if(isset($drvehicles->Joint_Vehicle_SoleSeparate_Party5) && $drvehicles->Joint_Vehicle_SoleSeparate_Party5==$opponent_name){ echo "checked"; } ?>> {{$opponent_name}}</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 Joint_Vehicle_Owned5_Div" id="Joint_Vehicle_SoleSeparate_Grounds5_Div" style="display: none;">
                                    <label for="Joint_Vehicle_SoleSeparate_Grounds5">Why does this person own this vehicle solely and separately?</label>
                                    <input id="Joint_Vehicle_SoleSeparate_Grounds5" type="text" class="form-control 5_Joint_vehicles_inputs" name="Joint_Vehicle_SoleSeparate_Grounds5" value="<?php if(isset($drvehicles->Joint_Vehicle_SoleSeparate_Grounds5)){ echo $drvehicles->Joint_Vehicle_SoleSeparate_Grounds5; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6 Joint_Vehicle_Owned5_Div">
                                    <label>How will this vehicle value be distributed between the parties?</label>
                                    <div class="w-100 dataInput">
                                        <label><input type="radio" id="Joint_Vehicle_Disposition_Method5_Liquidate_Split_Net_Value" name="Joint_Vehicle_Disposition_Method5" value="Liquidate/Split Net Value" data-onload="getInitialDipositionMethod(this, '5', 'Joint');" onchange="getDipositionMethod(this, '5', 'Joint');" <?php if(isset($drvehicles->Joint_Vehicle_Disposition_Method5) && $drvehicles->Joint_Vehicle_Disposition_Method5=='Liquidate/Split Net Value'){ echo "checked"; } ?>> Liquidate/Split Net Value</label>
                                        <label><input type="radio" id="Joint_Vehicle_Disposition_Method5_Fixed_Buyout" name="Joint_Vehicle_Disposition_Method5" value="Fixed Buyout" data-onload="getInitialDipositionMethod(this, '5', 'Joint');" onchange="getDipositionMethod(this, '5', 'Joint');" <?php if(isset($drvehicles->Joint_Vehicle_Disposition_Method5) && $drvehicles->Joint_Vehicle_Disposition_Method5=='Fixed Buyout'){ echo "checked"; } ?>> Fixed Buyout</label>
                                    </div>
                                </div>
                                <!-- slider tool -->
                                <div class="form-group col-sm-6 m-auto 5_Joint_Slider_Tool Joint_Vehicle_Owned5_Div">
                                    <div class="row">
                                        <div class="col">{{$client_name}}</div>
                                        <div class="col text-right">{{$opponent_name}}</div>
                                    </div>
                                    <input id="5_Joint_balance_range_selector" type="range" class="form-control slider-tool-input 5_Joint_balance_range_selector" name="" value="<?php if(isset($drvehicles->Joint_Vehicle_Percent_Marital_Equity_to_Op5)){ echo $drvehicles->Joint_Vehicle_Percent_Marital_Equity_to_Op5; } ?>" min="0.00" step="0.01" max="100" onchange="updateBalanceInput(this.value, '5', 'Joint');">
                                </div>
                                <div class="form-group col-sm-6 m-auto 5_Joint_Slider_Tool Joint_Vehicle_Owned5_Div">
                                    <div class="row justify-content-between">
                                        <div class="col selectorTool">
                                            <div class="left-col">
                                                <div class="client-info 5_Joint_clientpercentage_div clientpercentage_div">
                                                    <?php if(isset($drvehicles->Joint_Vehicle_Percent_Marital_Equity_to_Client5)){ echo $drvehicles->Joint_Vehicle_Percent_Marital_Equity_to_Client5; } else {
                                                        echo '50.00';
                                                    } ?>%
                                                </div>
                                                <div class="client-info 5_Joint_clientamount_div clientamount_div" style="clear: both;">
                                                    $<?php if(isset($drvehicles->Joint_Vehicle_Estimated_Value_to_Client5)){ echo $drvehicles->Joint_Vehicle_Estimated_Value_to_Client5; } else {
                                                        echo '50.00';
                                                    } ?>
                                                </div>
                                            </div>
                                            <label>To {{$client_name}}</label>
                                        </div>                                       
                                        <div class="col selectorTool selectorToolRight">
                                            <label>To {{$opponent_name}}</label>
                                            <div class="left-col right-col">
                                                <div class="client-info 5_Joint_opponentpercentage_div opponentpercentage_div">
                                                    <?php if(isset($drvehicles->Joint_Vehicle_Percent_Marital_Equity_to_Op5)){ echo $drvehicles->Joint_Vehicle_Percent_Marital_Equity_to_Op5; } else {
                                                        echo '50.00';
                                                    } ?>%
                                                </div>
                                                <div class="client-info 5_Joint_opponentamount_div opponentamount_div" style="clear: both;">
                                                    $<?php if(isset($drvehicles->Joint_Vehicle_Estimated_Value_to_Op5)){ echo $drvehicles->Joint_Vehicle_Estimated_Value_to_Op5; } else {
                                                        echo '50.00';
                                                    } ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 m-auto 5_Joint_Slider_Tool Joint_Vehicle_Owned5_Div">
                                    <label></label>
                                    <div class="w-100">
                                        <label><input type="radio" id="5_Joint_Vehicle_Estimated_Value_Select" name="5_Joint_Vehicle_Estimated_Value_Select_Reset" class="Vehicle_Estimated_Value_Select_Reset" value="Save"> Save this Distribution of Vehicles #5</label>
                                        <label><input type="radio" id="5_Joint_Vehicle_Estimated_Value_Reset" name="5_Joint_Vehicle_Estimated_Value_Select_Reset" class="Vehicle_Estimated_Value_Select_Reset" value="Reset" onclick="resetBalanceInput(this, '5', 'Joint');"> Reset to Default (50%)</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 Joint_Vehicle_Owned5_Div Joint_Vehicle_Paying_Party5_Inputs_Div" style="display: none;">
                                    <label>Joint Vehicles Paying Party5</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Joint_Vehicle_Paying_Party5_Client" name="Joint_Vehicle_Paying_Party5" value="{{$client_name}}" data-onload="getInitialVehiclesPayingParty(this, '5', 'Joint');" onchange="getVehiclesPayingParty(this, '5', 'Joint');" <?php if(isset($drvehicles->Joint_Vehicle_Paying_Party5) && $drvehicles->Joint_Vehicle_Paying_Party5==$client_name){ echo "checked"; } ?>> {{$client_name}}</label>
                                        <label><input type="radio" id="Joint_Vehicle_Paying_Party5_Op" name="Joint_Vehicle_Paying_Party5" value="{{$opponent_name}}" data-onload="getInitialVehiclesPayingParty(this, '5', 'Joint');" onchange="getVehiclesPayingParty(this, '5', 'Joint');" <?php if(isset($drvehicles->Joint_Vehicle_Paying_Party5) && $drvehicles->Joint_Vehicle_Paying_Party5==$opponent_name){ echo "checked"; } ?>> {{$opponent_name}}</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 Joint_Vehicle_Owned5_Div Joint_Vehicle_Paying_Party5_Inputs_Div" style="display: none;">
                                    <label>{{$client_name}} Vehicles Equity Percent</label>
                                    <input id="Joint_Vehicle_Percent_Marital_Equity_to_Client5" type="number" class="form-control 5_Joint_clientpercentage_input clientpercentage_input" name="Joint_Vehicle_Percent_Marital_Equity_to_Client5" value="<?php if(isset($drvehicles->Joint_Vehicle_Percent_Marital_Equity_to_Client5)){ echo $drvehicles->Joint_Vehicle_Percent_Marital_Equity_to_Client5; } ?>" min="0.00" step="0.01" max="100" readonly="">
                                </div>
                                <div class="form-group col-sm-6 Joint_Vehicle_Owned5_Div Joint_Vehicle_Paying_Party5_Inputs_Div" style="display: none;">
                                    <label>How much is to be paid to {{$client_name}}?</label>
                                    <input id="Joint_Vehicle_Estimated_Value_to_Client5" type="number" class="form-control 5_Joint_clientamount_input clientamount_input" name="Joint_Vehicle_Estimated_Value_to_Client5" value="<?php if(isset($drvehicles->Joint_Vehicle_Estimated_Value_to_Client5)){ echo $drvehicles->Joint_Vehicle_Estimated_Value_to_Client5; } ?>" min="0.00" step="0.01" max="999999.99" readonly="" onchange="getEstimatedValueClient(this, '5', 'Joint');" onkeyup="getEstimatedValueClient(this, '5', 'Joint');">
                                </div>
                                <div class="form-group col-sm-6 Joint_Vehicle_Owned5_Div Joint_Vehicle_Paying_Party5_Inputs_Div" style="display: none;">
                                    <label>{{$opponent_name}} Vehicles Equity Percent</label>
                                    <input id="Joint_Vehicle_Percent_Marital_Equity_to_Op5" type="number" class="form-control 5_Joint_opponentpercentage_input opponentpercentage_input" name="Joint_Vehicle_Percent_Marital_Equity_to_Op5" value="<?php if(isset($drvehicles->Joint_Vehicle_Percent_Marital_Equity_to_Op5)){ echo $drvehicles->Joint_Vehicle_Percent_Marital_Equity_to_Op5; } ?>" min="0.00" step="0.01" max="100" readonly="">
                                </div>
                                <div class="form-group col-sm-6 Joint_Vehicle_Owned5_Div Joint_Vehicle_Paying_Party5_Inputs_Div" style="display: none;">
                                    <label>How much is to be paid to {{$opponent_name}}?</label>
                                    <input id="Joint_Vehicle_Estimated_Value_to_Op5" type="number" class="form-control 5_Joint_opponentamount_input opponentamount_input" name="Joint_Vehicle_Estimated_Value_to_Op5" value="<?php if(isset($drvehicles->Joint_Vehicle_Estimated_Value_to_Op5)){ echo $drvehicles->Joint_Vehicle_Estimated_Value_to_Op5; } ?>" min="0.00" step="0.01" max="999999.99" readonly="" onchange="getEstimatedValueOp(this, '5', 'Joint');" onkeyup="getEstimatedValueOp(this, '5', 'Joint');">
                                </div>
                                <!-- end of slider tool -->
                                <div class="form-group col-sm-6 Joint_Vehicle_Paying_Party5_Leased_Div" style="display: none;">
                                    <label for="Joint_Vehicle_Lease_Company5">Name of vehicle lease company?</label>
                                    <input id="Joint_Vehicle_Lease_Company5" type="text" class="form-control 5_Joint_vehicles_inputs Joint_Vehicle_Paying_Party5_Leased_Input" name="Joint_Vehicle_Lease_Company5" value="<?php if(isset($drvehicles->Joint_Vehicle_Lease_Company5)){ echo $drvehicles->Joint_Vehicle_Lease_Company5; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6 Joint_Vehicle_Paying_Party5_Leased_Div" style="display: none;">
                                    <label>Monthly lease payment for this vehicle?</label>
                                    <input id="Joint_Vehicle_Monthly_Lease_Amount5" type="number" class="form-control 5_Joint_vehicles_inputs Joint_Vehicle_Paying_Party5_Leased_Input" name="Joint_Vehicle_Monthly_Lease_Amount5" value="<?php if(isset($drvehicles->Joint_Vehicle_Monthly_Lease_Amount5)){ echo $drvehicles->Joint_Vehicle_Monthly_Lease_Amount5; } ?>" min="0.00" step="0.01" max="999999.99">
                                </div>
                                <div class="form-group col-sm-6 Joint_Vehicle_Paying_Party5_Leased_Div" style="display: none;">
                                    <label>How will this leased vehicle be handled?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Joint_Vehicle_Lease_Disposition_Method5_Terminate_Lease" name="Joint_Vehicle_Lease_Disposition_Method5" value="Terminate Lease" <?php if(isset($drvehicles->Joint_Vehicle_Lease_Disposition_Method5) && $drvehicles->Joint_Vehicle_Lease_Disposition_Method5=='Terminate Lease'){ echo "checked"; } ?>> Terminate Lease</label>
                                        <label><input type="radio" id="Joint_Vehicle_Lease_Disposition_Method5_Transfer_Lease_Responsibility_to_ClientName" name="Joint_Vehicle_Lease_Disposition_Method5" value="Transfer Lease Responsibility to {{$client_name}}" <?php if(isset($drvehicles->Joint_Vehicle_Lease_Disposition_Method5) && $drvehicles->Joint_Vehicle_Lease_Disposition_Method5=='Transfer Lease Responsibility to '.$client_name.''){ echo "checked"; } ?>> Transfer Lease Responsibility to {{$client_name}}</label>
                                        <label><input type="radio" id="Joint_Vehicle_Lease_Disposition_Method5_Transfer_Lease_Responsibility_to_OpName" name="Joint_Vehicle_Lease_Disposition_Method5" value="Transfer Lease Responsibility to {{$opponent_name}}" <?php if(isset($drvehicles->Joint_Vehicle_Lease_Disposition_Method5) && $drvehicles->Joint_Vehicle_Lease_Disposition_Method5=='Transfer Lease Responsibility to '.$opponent_name.''){ echo "checked"; } ?>> Transfer Lease Responsibility to {{$opponent_name}}</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 mt-4 6_Joint_vehicles_section" style="display: none;"><h5 class="col-sm-12">Sixth Vehicle Info</h5>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_Vehicle_Year6">Model year of this vehicle?</label>
                                    <select id="Joint_Vehicle_Year6" name="Joint_Vehicle_Year6" class="form-control 6_Joint_vehicles_select">
                                        <?php 
                                            if(isset($drvehicles->Joint_Vehicle_Year6)){ 
                                                $already_selected_value = $drvehicles->Joint_Vehicle_Year6; 
                                            } else {
                                                $already_selected_value = '';
                                            }
                                            $earliest_year = 1900;
                                            foreach (range(date('Y'), $earliest_year) as $x) {
                                                echo '<option value="'.$x.'"'.($x == $already_selected_value ? ' selected="selected"' : '').'>'.$x.'</option>';
                                            }
                                        ?>
                                    </select>   
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_Vehicle_Make_Model6">What make and model is this vehicle?</label>
                                    <input id="Joint_Vehicle_Make_Model6" type="text" class="form-control 6_Joint_vehicles_inputs" name="Joint_Vehicle_Make_Model6" value="<?php if(isset($drvehicles->Joint_Vehicle_Make_Model6)){ echo $drvehicles->Joint_Vehicle_Make_Model6; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Is this vehicle leased or owned?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Joint_Vehicle_Owned_Leased6_Owned" name="Joint_Vehicle_Owned_Leased6" value="Owned" data-onload="getInitialVehicleOwnedLeased(this, '6', 'Joint');" onchange="getVehicleOwnedLeased(this, '6', 'Joint');" <?php if(isset($drvehicles->Joint_Vehicle_Owned_Leased6) && $drvehicles->Joint_Vehicle_Owned_Leased6=='Owned'){ echo "checked"; } ?>> Owned</label>
                                        <label><input type="radio" id="Joint_Vehicle_Owned_Leased6_Leased" name="Joint_Vehicle_Owned_Leased6" value="Leased" data-onload="getInitialVehicleOwnedLeased(this, '6', 'Joint');" onchange="getVehicleOwnedLeased(this, '6', 'Joint');" <?php if(isset($drvehicles->Joint_Vehicle_Owned_Leased6) && $drvehicles->Joint_Vehicle_Owned_Leased6=='Leased'){ echo "checked"; } ?>> Leased</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 Joint_Vehicle_Owned6_Div">
                                    <label for="Joint_Vehicle_VIN6">What is the VIN of this vehicle?</label>
                                    <input id="Joint_Vehicle_VIN6" type="text" class="form-control 6_Joint_vehicles_inputs" name="Joint_Vehicle_VIN6" value="<?php if(isset($drvehicles->Joint_Vehicle_VIN6)){ echo $drvehicles->Joint_Vehicle_VIN6; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6 Joint_Vehicle_Owned6_Div">
                                    <label for="Joint_Vehicle_Current_Value6">What is the current value of this vehicle?</label>
                                    <input id="Joint_Vehicle_Current_Value6" type="number" class="form-control 6_Joint_vehicles_inputs" name="Joint_Vehicle_Current_Value6" value="<?php if(isset($drvehicles->Joint_Vehicle_Current_Value6)){ echo $drvehicles->Joint_Vehicle_Current_Value6; } ?>" min="0.00" step="0.01" max="999999.99" onchange="getCurrentValue(this, '6', 'Joint');" onkeyup="getCurrentValue(this, '6', 'Joint');">
                                </div>
                                <div class="form-group col-sm-6 Joint_Vehicle_Owned6_Div">
                                    <label for="Joint_Vehicle_Loan_Company_Name6">Name of first car loan company?</label>
                                    <input id="Joint_Vehicle_Loan_Company_Name6" type="text" class="form-control 6_Joint_vehicles_inputs" name="Joint_Vehicle_Loan_Company_Name6" value="<?php if(isset($drvehicles->Joint_Vehicle_Loan_Company_Name6)){ echo $drvehicles->Joint_Vehicle_Loan_Company_Name6; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6 Joint_Vehicle_Owned6_Div">
                                    <label for="Joint_Vehicle_Loan_Balance6">Balance due to first car loan company for this vehicle?</label>
                                    <input id="Joint_Vehicle_Loan_Balance6" type="number" class="form-control 6_Joint_vehicles_inputs" name="Joint_Vehicle_Loan_Balance6" value="<?php if(isset($drvehicles->Joint_Vehicle_Loan_Balance6)){ echo $drvehicles->Joint_Vehicle_Loan_Balance6; } ?>" min="0.00" step="0.01" max="999999.99" onchange="getLoanBalance(this, '6', 'Joint');" onkeyup="getLoanBalance(this, '6', 'Joint');">
                                </div>
                                <div class="form-group col-sm-6 Joint_Vehicle_Owned6_Div">
                                    <label for="Joint_Vehicle_Loan_Monthly_Payment6">Monthly payment to first car loan company for this vehicle?</label>
                                    <input id="Joint_Vehicle_Loan_Monthly_Payment6" type="number" class="form-control 6_Joint_vehicles_inputs" name="Joint_Vehicle_Loan_Monthly_Payment6" value="<?php if(isset($drvehicles->Joint_Vehicle_Loan_Monthly_Payment6)){ echo $drvehicles->Joint_Vehicle_Loan_Monthly_Payment6; } ?>" min="0.00" step="0.01" max="999999.99">
                                </div>
                                <div class="form-group col-sm-6 Joint_Vehicle_Owned6_Div">
                                    <label for="Joint_Vehicle_Loan_Second_Company_Name6">Name of second car loan company?</label>
                                    <input id="Joint_Vehicle_Loan_Second_Company_Name6" type="text" class="form-control 6_Joint_vehicles_inputs" name="Joint_Vehicle_Loan_Second_Company_Name6" value="<?php if(isset($drvehicles->Joint_Vehicle_Loan_Second_Company_Name6)){ echo $drvehicles->Joint_Vehicle_Loan_Second_Company_Name6; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6 Joint_Vehicle_Owned6_Div">
                                    <label for="Joint_Vehicle_Loan_Second_Company_Balance6">Balance due to second car loan company for this vehicle?</label>
                                    <input id="Joint_Vehicle_Loan_Second_Company_Balance6" type="number" class="form-control 6_Joint_vehicles_inputs" name="Joint_Vehicle_Loan_Second_Company_Balance6" value="<?php if(isset($drvehicles->Joint_Vehicle_Loan_Second_Company_Balance6)){ echo $drvehicles->Joint_Vehicle_Loan_Second_Company_Balance6; } ?>" min="0.00" step="0.01" max="999999.99" onchange="getCompanyBalance(this, '6', 'Joint');" onkeyup="getCompanyBalance(this, '6', 'Joint');">
                                </div>
                                <div class="form-group col-sm-6 Joint_Vehicle_Owned6_Div">
                                    <label for="Joint_Vehicle_Loan_Second_Company_Monthly_Payment6">Monthly payment to second car loan company for this vehicle?</label>
                                    <input id="Joint_Vehicle_Loan_Second_Company_Monthly_Payment6" type="number" class="form-control 6_Joint_vehicles_inputs" name="Joint_Vehicle_Loan_Second_Company_Monthly_Payment6" value="<?php if(isset($drvehicles->Joint_Vehicle_Loan_Second_Company_Monthly_Payment6)){ echo $drvehicles->Joint_Vehicle_Loan_Second_Company_Monthly_Payment6; } ?>" min="0.00" step="0.01" max="999999.99">
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label for="Joint_Vehicle_Marital_Equity6">N/A, calculated = Joint_Vehicle_Current_Value6-Joint_Vehicle_Loan_Balance6-Joint_Vehicle_Loan_Second_Company_Balance6</label>
                                    <input id="Joint_Vehicle_Marital_Equity6" type="number" class="form-control 6_Joint_vehicles_inputs" name="Joint_Vehicle_Marital_Equity6" value="<?php if(isset($drvehicles->Joint_Vehicle_Marital_Equity6)){ echo $drvehicles->Joint_Vehicle_Marital_Equity6; } ?>" min="0.00" step="0.01" max="999999.99">
                                </div>
                                <div class="form-group col-sm-6 Joint_Vehicle_Owned6_Div">
                                    <label>Does either party claim a sole/separate interest in this vehicle?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Joint_Vehicle_SoleSeparate_Claim6_Yes" name="Joint_Vehicle_SoleSeparate_Claim6" value="Yes" data-onload="getInitialPartyClaimSoleSeparate(this, '6', 'Joint');" onchange="getPartyClaimSoleSeparate(this, '6', 'Joint');" <?php if(isset($drvehicles->Joint_Vehicle_SoleSeparate_Claim6) && $drvehicles->Joint_Vehicle_SoleSeparate_Claim6=='Yes'){ echo "checked"; } ?>> Yes</label>
                                        <label><input type="radio" id="Joint_Vehicle_SoleSeparate_Claim6_No" name="Joint_Vehicle_SoleSeparate_Claim6" value="No" data-onload="getInitialPartyClaimSoleSeparate(this, '6', 'Joint');" onchange="getPartyClaimSoleSeparate(this, '6', 'Joint');" <?php if(isset($drvehicles->Joint_Vehicle_SoleSeparate_Claim6) && $drvehicles->Joint_Vehicle_SoleSeparate_Claim6=='No'){ echo "checked"; } ?>> No</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 Joint_Vehicle_Owned6_Div" id="Joint_Vehicle_SoleSeparate_Party6_Div" style="display: none;">
                                    <label>Who claims to own this vehicle?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Joint_Vehicle_SoleSeparate_Party6_Client" name="Joint_Vehicle_SoleSeparate_Party6" value="{{$client_name}}" <?php if(isset($drvehicles->Joint_Vehicle_SoleSeparate_Party6) && $drvehicles->Joint_Vehicle_SoleSeparate_Party6==$client_name){ echo "checked"; } ?>> {{$client_name}}</label>
                                        <label><input type="radio" id="Joint_Vehicle_SoleSeparate_Party6_Op" name="Joint_Vehicle_SoleSeparate_Party6" value="{{$opponent_name}}" <?php if(isset($drvehicles->Joint_Vehicle_SoleSeparate_Party6) && $drvehicles->Joint_Vehicle_SoleSeparate_Party6==$opponent_name){ echo "checked"; } ?>> {{$opponent_name}}</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 Joint_Vehicle_Owned6_Div" id="Joint_Vehicle_SoleSeparate_Grounds6_Div" style="display: none;">
                                    <label for="Joint_Vehicle_SoleSeparate_Grounds6">Why does this person own this vehicle solely and separately?</label>
                                    <input id="Joint_Vehicle_SoleSeparate_Grounds6" type="text" class="form-control 6_Joint_vehicles_inputs" name="Joint_Vehicle_SoleSeparate_Grounds6" value="<?php if(isset($drvehicles->Joint_Vehicle_SoleSeparate_Grounds6)){ echo $drvehicles->Joint_Vehicle_SoleSeparate_Grounds6; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6 Joint_Vehicle_Owned6_Div">
                                    <label>How will this vehicle value be distributed between the parties?</label>
                                    <div class="w-100 dataInput">
                                        <label><input type="radio" id="Joint_Vehicle_Disposition_Method6_Liquidate_Split_Net_Value" name="Joint_Vehicle_Disposition_Method6" value="Liquidate/Split Net Value" data-onload="getInitialDipositionMethod(this, '6', 'Joint');" onchange="getDipositionMethod(this, '6', 'Joint');" <?php if(isset($drvehicles->Joint_Vehicle_Disposition_Method6) && $drvehicles->Joint_Vehicle_Disposition_Method6=='Liquidate/Split Net Value'){ echo "checked"; } ?>> Liquidate/Split Net Value</label>
                                        <label><input type="radio" id="Joint_Vehicle_Disposition_Method6_Fixed_Buyout" name="Joint_Vehicle_Disposition_Method6" value="Fixed Buyout" data-onload="getInitialDipositionMethod(this, '6', 'Joint');" onchange="getDipositionMethod(this, '6', 'Joint');" <?php if(isset($drvehicles->Joint_Vehicle_Disposition_Method6) && $drvehicles->Joint_Vehicle_Disposition_Method6=='Fixed Buyout'){ echo "checked"; } ?>> Fixed Buyout</label>
                                    </div>
                                </div>
                                <!-- slider tool -->
                                <div class="form-group col-sm-6 m-auto 6_Joint_Slider_Tool Joint_Vehicle_Owned6_Div">
                                    <div class="row">
                                        <div class="col">{{$client_name}}</div>
                                        <div class="col text-right">{{$opponent_name}}</div>
                                    </div>
                                    <input id="6_Joint_balance_range_selector" type="range" class="form-control slider-tool-input 6_Joint_balance_range_selector" name="" value="<?php if(isset($drvehicles->Joint_Vehicle_Percent_Marital_Equity_to_Op6)){ echo $drvehicles->Joint_Vehicle_Percent_Marital_Equity_to_Op6; } ?>" min="0.00" step="0.01" max="100" onchange="updateBalanceInput(this.value, '6', 'Joint');">
                                </div>
                                <div class="form-group col-sm-6 m-auto 6_Joint_Slider_Tool Joint_Vehicle_Owned6_Div">
                                    <div class="row justify-content-between">
                                        <div class="col selectorTool">
                                            <div class="left-col">
                                                <div class="client-info 6_Joint_clientpercentage_div clientpercentage_div">
                                                    <?php if(isset($drvehicles->Joint_Vehicle_Percent_Marital_Equity_to_Client6)){ echo $drvehicles->Joint_Vehicle_Percent_Marital_Equity_to_Client6; } else {
                                                        echo '50.00';
                                                    } ?>%
                                                </div>
                                                <div class="client-info 6_Joint_clientamount_div clientamount_div" style="clear: both;">
                                                    $<?php if(isset($drvehicles->Joint_Vehicle_Estimated_Value_to_Client6)){ echo $drvehicles->Joint_Vehicle_Estimated_Value_to_Client6; } else {
                                                        echo '50.00';
                                                    } ?>
                                                </div>
                                            </div>
                                            <label>To {{$client_name}}</label>
                                        </div>                                       
                                        <div class="col selectorTool selectorToolRight">
                                            <label>To {{$opponent_name}}</label>
                                            <div class="left-col right-col">
                                                <div class="client-info 6_Joint_opponentpercentage_div opponentpercentage_div">
                                                    <?php if(isset($drvehicles->Joint_Vehicle_Percent_Marital_Equity_to_Op6)){ echo $drvehicles->Joint_Vehicle_Percent_Marital_Equity_to_Op6; } else {
                                                        echo '50.00';
                                                    } ?>%
                                                </div>
                                                <div class="client-info 6_Joint_opponentamount_div opponentamount_div" style="clear: both;">
                                                    $<?php if(isset($drvehicles->Joint_Vehicle_Estimated_Value_to_Op6)){ echo $drvehicles->Joint_Vehicle_Estimated_Value_to_Op6; } else {
                                                        echo '50.00';
                                                    } ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 m-auto 6_Joint_Slider_Tool Joint_Vehicle_Owned6_Div">
                                    <label></label>
                                    <div class="w-100">
                                        <label><input type="radio" id="6_Joint_Vehicle_Estimated_Value_Select" name="6_Joint_Vehicle_Estimated_Value_Select_Reset" class="Vehicle_Estimated_Value_Select_Reset" value="Save"> Save this Distribution of Vehicles #6</label>
                                        <label><input type="radio" id="6_Joint_Vehicle_Estimated_Value_Reset" name="6_Joint_Vehicle_Estimated_Value_Select_Reset" class="Vehicle_Estimated_Value_Select_Reset" value="Reset" onclick="resetBalanceInput(this, '6', 'Joint');"> Reset to Default (50%)</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 Joint_Vehicle_Owned6_Div Joint_Vehicle_Paying_Party6_Inputs_Div" style="display: none;">
                                    <label>Joint Vehicles Paying Party6</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Joint_Vehicle_Paying_Party6_Client" name="Joint_Vehicle_Paying_Party6" value="{{$client_name}}" data-onload="getInitialVehiclesPayingParty(this, '6', 'Joint');" onchange="getVehiclesPayingParty(this, '6', 'Joint');" <?php if(isset($drvehicles->Joint_Vehicle_Paying_Party6) && $drvehicles->Joint_Vehicle_Paying_Party6==$client_name){ echo "checked"; } ?>> {{$client_name}}</label>
                                        <label><input type="radio" id="Joint_Vehicle_Paying_Party6_Op" name="Joint_Vehicle_Paying_Party6" value="{{$opponent_name}}" data-onload="getInitialVehiclesPayingParty(this, '6', 'Joint');" onchange="getVehiclesPayingParty(this, '6', 'Joint');" <?php if(isset($drvehicles->Joint_Vehicle_Paying_Party6) && $drvehicles->Joint_Vehicle_Paying_Party6==$opponent_name){ echo "checked"; } ?>> {{$opponent_name}}</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 Joint_Vehicle_Owned6_Div Joint_Vehicle_Paying_Party6_Inputs_Div" style="display: none;">
                                    <label>{{$client_name}} Vehicles Equity Percent</label>
                                    <input id="Joint_Vehicle_Percent_Marital_Equity_to_Client6" type="number" class="form-control 6_Joint_clientpercentage_input clientpercentage_input" name="Joint_Vehicle_Percent_Marital_Equity_to_Client6" value="<?php if(isset($drvehicles->Joint_Vehicle_Percent_Marital_Equity_to_Client6)){ echo $drvehicles->Joint_Vehicle_Percent_Marital_Equity_to_Client6; } ?>" min="0.00" step="0.01" max="100" readonly="">
                                </div>
                                <div class="form-group col-sm-6 Joint_Vehicle_Owned6_Div Joint_Vehicle_Paying_Party6_Inputs_Div" style="display: none;">
                                    <label>How much is to be paid to {{$client_name}}?</label>
                                    <input id="Joint_Vehicle_Estimated_Value_to_Client6" type="number" class="form-control 6_Joint_clientamount_input clientamount_input" name="Joint_Vehicle_Estimated_Value_to_Client6" value="<?php if(isset($drvehicles->Joint_Vehicle_Estimated_Value_to_Client6)){ echo $drvehicles->Joint_Vehicle_Estimated_Value_to_Client6; } ?>" min="0.00" step="0.01" max="999999.99" readonly="" onchange="getEstimatedValueClient(this, '6', 'Joint');" onkeyup="getEstimatedValueClient(this, '6', 'Joint');">
                                </div>
                                <div class="form-group col-sm-6 Joint_Vehicle_Owned6_Div Joint_Vehicle_Paying_Party6_Inputs_Div" style="display: none;">
                                    <label>{{$opponent_name}} Vehicles Equity Percent</label>
                                    <input id="Joint_Vehicle_Percent_Marital_Equity_to_Op6" type="number" class="form-control 6_Joint_opponentpercentage_input opponentpercentage_input" name="Joint_Vehicle_Percent_Marital_Equity_to_Op6" value="<?php if(isset($drvehicles->Joint_Vehicle_Percent_Marital_Equity_to_Op6)){ echo $drvehicles->Joint_Vehicle_Percent_Marital_Equity_to_Op6; } ?>" min="0.00" step="0.01" max="100" readonly="">
                                </div>
                                <div class="form-group col-sm-6 Joint_Vehicle_Owned6_Div Joint_Vehicle_Paying_Party6_Inputs_Div" style="display: none;">
                                    <label>How much is to be paid to {{$opponent_name}}?</label>
                                    <input id="Joint_Vehicle_Estimated_Value_to_Op6" type="number" class="form-control 6_Joint_opponentamount_input opponentamount_input" name="Joint_Vehicle_Estimated_Value_to_Op6" value="<?php if(isset($drvehicles->Joint_Vehicle_Estimated_Value_to_Op6)){ echo $drvehicles->Joint_Vehicle_Estimated_Value_to_Op6; } ?>" min="0.00" step="0.01" max="999999.99" readonly="" onchange="getEstimatedValueOp(this, '6', 'Joint');" onkeyup="getEstimatedValueOp(this, '6', 'Joint');">
                                </div>
                                <!-- end of slider tool -->
                                <div class="form-group col-sm-6 Joint_Vehicle_Paying_Party6_Leased_Div" style="display: none;">
                                    <label for="Joint_Vehicle_Lease_Company6">Name of vehicle lease company?</label>
                                    <input id="Joint_Vehicle_Lease_Company6" type="text" class="form-control 6_Joint_vehicles_inputs Joint_Vehicle_Paying_Party6_Leased_Input" name="Joint_Vehicle_Lease_Company6" value="<?php if(isset($drvehicles->Joint_Vehicle_Lease_Company6)){ echo $drvehicles->Joint_Vehicle_Lease_Company6; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6 Joint_Vehicle_Paying_Party6_Leased_Div" style="display: none;">
                                    <label>Monthly lease payment for this vehicle?</label>
                                    <input id="Joint_Vehicle_Monthly_Lease_Amount6" type="number" class="form-control 6_Joint_vehicles_inputs Joint_Vehicle_Paying_Party6_Leased_Input" name="Joint_Vehicle_Monthly_Lease_Amount6" value="<?php if(isset($drvehicles->Joint_Vehicle_Monthly_Lease_Amount6)){ echo $drvehicles->Joint_Vehicle_Monthly_Lease_Amount6; } ?>" min="0.00" step="0.01" max="999999.99">
                                </div>
                                <div class="form-group col-sm-6 Joint_Vehicle_Paying_Party6_Leased_Div" style="display: none;">
                                    <label>How will this leased vehicle be handled?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Joint_Vehicle_Lease_Disposition_Method6_Terminate_Lease" name="Joint_Vehicle_Lease_Disposition_Method6" value="Terminate Lease" <?php if(isset($drvehicles->Joint_Vehicle_Lease_Disposition_Method6) && $drvehicles->Joint_Vehicle_Lease_Disposition_Method6=='Terminate Lease'){ echo "checked"; } ?>> Terminate Lease</label>
                                        <label><input type="radio" id="Joint_Vehicle_Lease_Disposition_Method6_Transfer_Lease_Responsibility_to_ClientName" name="Joint_Vehicle_Lease_Disposition_Method6" value="Transfer Lease Responsibility to {{$client_name}}" <?php if(isset($drvehicles->Joint_Vehicle_Lease_Disposition_Method6) && $drvehicles->Joint_Vehicle_Lease_Disposition_Method6=='Transfer Lease Responsibility to '.$client_name.''){ echo "checked"; } ?>> Transfer Lease Responsibility to {{$client_name}}</label>
                                        <label><input type="radio" id="Joint_Vehicle_Lease_Disposition_Method6_Transfer_Lease_Responsibility_to_OpName" name="Joint_Vehicle_Lease_Disposition_Method6" value="Transfer Lease Responsibility to {{$opponent_name}}" <?php if(isset($drvehicles->Joint_Vehicle_Lease_Disposition_Method6) && $drvehicles->Joint_Vehicle_Lease_Disposition_Method6=='Transfer Lease Responsibility to '.$opponent_name.''){ echo "checked"; } ?>> Transfer Lease Responsibility to {{$opponent_name}}</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- End ofJoint Vehicles Info Section -->

                        <!-- Client Vehicles Info Section -->
                        <div class="form-row Num_Client_Vehicles mt-4" style="display: none;">
                            <h4 class="col-sm-12">{{$client_name}} Vehicles Info Section</h4>
                            <div class="col-sm-6">
                                <label for="Num_Client_Vehicles">How Many Vehicles Leased or Titled in just to {{$client_name}}?</label>
                                <input id="Num_Client_Vehicles" type="number" class="form-control" name="Num_Client_Vehicles" value="<?php if(isset($drvehicles->Num_Client_Vehicles)){ echo $drvehicles->Num_Client_Vehicles; } ?>" min="0" max="6"> 
                            </div>
                        </div>
                        <div class="form-row Client_vehicles_section">
                            <div class="col-sm-12 mt-4 1_Client_vehicles_section" style="display: none;"><h5 class="col-sm-12">First Vehicle Info</h5>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Vehicle_Year1">Model year of this vehicle?</label>
                                    <select id="Client_Vehicle_Year1" name="Client_Vehicle_Year1" class="form-control 1_Client_vehicles_select">
                                        <?php 
                                            if(isset($drvehicles->Client_Vehicle_Year1)){ 
                                                $already_selected_value = $drvehicles->Client_Vehicle_Year1; 
                                            } else {
                                                $already_selected_value = '';
                                            }
                                            $earliest_year = 1900;
                                            foreach (range(date('Y'), $earliest_year) as $x) {
                                                echo '<option value="'.$x.'"'.($x == $already_selected_value ? ' selected="selected"' : '').'>'.$x.'</option>';
                                            }
                                        ?>
                                    </select>   
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Vehicle_Make_Model1">What make and model is this vehicle?</label>
                                    <input id="Client_Vehicle_Make_Model1" type="text" class="form-control 1_Client_vehicles_inputs" name="Client_Vehicle_Make_Model1" value="<?php if(isset($drvehicles->Client_Vehicle_Make_Model1)){ echo $drvehicles->Client_Vehicle_Make_Model1; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Is this vehicle leased or owned?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Client_Vehicle_Owned_Leased1_Owned" name="Client_Vehicle_Owned_Leased1" value="Owned" data-onload="getInitialVehicleOwnedLeased(this, '1', 'Client');" onchange="getVehicleOwnedLeased(this, '1', 'Client');" <?php if(isset($drvehicles->Client_Vehicle_Owned_Leased1) && $drvehicles->Client_Vehicle_Owned_Leased1=='Owned'){ echo "checked"; } ?>> Owned</label>
                                        <label><input type="radio" id="Client_Vehicle_Owned_Leased1_Leased" name="Client_Vehicle_Owned_Leased1" value="Leased" data-onload="getInitialVehicleOwnedLeased(this, '1', 'Client');" onchange="getVehicleOwnedLeased(this, '1', 'Client');" <?php if(isset($drvehicles->Client_Vehicle_Owned_Leased1) && $drvehicles->Client_Vehicle_Owned_Leased1=='Leased'){ echo "checked"; } ?>> Leased</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 Client_Vehicle_Owned1_Div">
                                    <label for="Client_Vehicle_VIN1">What is the VIN of this vehicle?</label>
                                    <input id="Client_Vehicle_VIN1" type="text" class="form-control 1_Client_vehicles_inputs" name="Client_Vehicle_VIN1" value="<?php if(isset($drvehicles->Client_Vehicle_VIN1)){ echo $drvehicles->Client_Vehicle_VIN1; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6 Client_Vehicle_Owned1_Div">
                                    <label for="Client_Vehicle_Current_Value1">What is the current value of this vehicle?</label>
                                    <input id="Client_Vehicle_Current_Value1" type="number" class="form-control 1_Client_vehicles_inputs" name="Client_Vehicle_Current_Value1" value="<?php if(isset($drvehicles->Client_Vehicle_Current_Value1)){ echo $drvehicles->Client_Vehicle_Current_Value1; } ?>" min="0.00" step="0.01" max="999999.99" onchange="getCurrentValue(this, '1', 'Client');" onkeyup="getCurrentValue(this, '1', 'Client');">
                                </div>
                                <div class="form-group col-sm-6 Client_Vehicle_Owned1_Div">
                                    <label for="Client_Vehicle_Loan_Company_Name1">Name of first car loan company?</label>
                                    <input id="Client_Vehicle_Loan_Company_Name1" type="text" class="form-control 1_Client_vehicles_inputs" name="Client_Vehicle_Loan_Company_Name1" value="<?php if(isset($drvehicles->Client_Vehicle_Loan_Company_Name1)){ echo $drvehicles->Client_Vehicle_Loan_Company_Name1; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6 Client_Vehicle_Owned1_Div">
                                    <label for="Client_Vehicle_Loan_Balance1">Balance due to first car loan company for this vehicle?</label>
                                    <input id="Client_Vehicle_Loan_Balance1" type="number" class="form-control 1_Client_vehicles_inputs" name="Client_Vehicle_Loan_Balance1" value="<?php if(isset($drvehicles->Client_Vehicle_Loan_Balance1)){ echo $drvehicles->Client_Vehicle_Loan_Balance1; } ?>" min="0.00" step="0.01" max="999999.99" onchange="getLoanBalance(this, '1', 'Client');" onkeyup="getLoanBalance(this, '1', 'Client');">
                                </div>
                                <div class="form-group col-sm-6 Client_Vehicle_Owned1_Div">
                                    <label for="Client_Vehicle_Loan_Monthly_Payment1">Monthly payment to first car loan company for this vehicle?</label>
                                    <input id="Client_Vehicle_Loan_Monthly_Payment1" type="number" class="form-control 1_Client_vehicles_inputs" name="Client_Vehicle_Loan_Monthly_Payment1" value="<?php if(isset($drvehicles->Client_Vehicle_Loan_Monthly_Payment1)){ echo $drvehicles->Client_Vehicle_Loan_Monthly_Payment1; } ?>" min="0.00" step="0.01" max="999999.99">
                                </div>
                                <div class="form-group col-sm-6 Client_Vehicle_Owned1_Div">
                                    <label for="Client_Vehicle_Loan_Second_Company_Name1">Name of second car loan company?</label>
                                    <input id="Client_Vehicle_Loan_Second_Company_Name1" type="text" class="form-control 1_Client_vehicles_inputs" name="Client_Vehicle_Loan_Second_Company_Name1" value="<?php if(isset($drvehicles->Client_Vehicle_Loan_Second_Company_Name1)){ echo $drvehicles->Client_Vehicle_Loan_Second_Company_Name1; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6 Client_Vehicle_Owned1_Div">
                                    <label for="Client_Vehicle_Loan_Second_Company_Balance1">Balance due to second car loan company for this vehicle?</label>
                                    <input id="Client_Vehicle_Loan_Second_Company_Balance1" type="number" class="form-control 1_Client_vehicles_inputs" name="Client_Vehicle_Loan_Second_Company_Balance1" value="<?php if(isset($drvehicles->Client_Vehicle_Loan_Second_Company_Balance1)){ echo $drvehicles->Client_Vehicle_Loan_Second_Company_Balance1; } ?>" min="0.00" step="0.01" max="999999.99" onchange="getCompanyBalance(this, '1', 'Client');" onkeyup="getCompanyBalance(this, '1', 'Client');">
                                </div>
                                <div class="form-group col-sm-6 Client_Vehicle_Owned1_Div">
                                    <label for="Client_Vehicle_Loan_Second_Company_Monthly_Payment1">Monthly payment to second car loan company for this vehicle?</label>
                                    <input id="Client_Vehicle_Loan_Second_Company_Monthly_Payment1" type="number" class="form-control 1_Client_vehicles_inputs" name="Client_Vehicle_Loan_Second_Company_Monthly_Payment1" value="<?php if(isset($drvehicles->Client_Vehicle_Loan_Second_Company_Monthly_Payment1)){ echo $drvehicles->Client_Vehicle_Loan_Second_Company_Monthly_Payment1; } ?>" min="0.00" step="0.01" max="999999.99">
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label for="Client_Vehicle_Marital_Equity1">N/A, calculated = Client_Vehicle_Current_Value1-Client_Vehicle_Loan_Balance1-Client_Vehicle_Loan_Second_Company_Balance1</label>
                                    <input id="Client_Vehicle_Marital_Equity1" type="number" class="form-control 1_Client_vehicles_inputs" name="Client_Vehicle_Marital_Equity1" value="<?php if(isset($drvehicles->Client_Vehicle_Marital_Equity1)){ echo $drvehicles->Client_Vehicle_Marital_Equity1; } ?>" min="0.00" step="0.01" max="999999.99">
                                </div>
                                <div class="form-group col-sm-6 Client_Vehicle_Owned1_Div">
                                    <label>Does either party claim a sole/separate interest in this vehicle?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Client_Vehicle_SoleSeparate_Claim1_Yes" name="Client_Vehicle_SoleSeparate_Claim1" value="Yes" data-onload="getInitialPartyClaimSoleSeparate(this, '1', 'Client');" onchange="getPartyClaimSoleSeparate(this, '1', 'Client');" <?php if(isset($drvehicles->Client_Vehicle_SoleSeparate_Claim1) && $drvehicles->Client_Vehicle_SoleSeparate_Claim1=='Yes'){ echo "checked"; } ?>> Yes</label>
                                        <label><input type="radio" id="Client_Vehicle_SoleSeparate_Claim1_No" name="Client_Vehicle_SoleSeparate_Claim1" value="No" data-onload="getInitialPartyClaimSoleSeparate(this, '1', 'Client');" onchange="getPartyClaimSoleSeparate(this, '1', 'Client');" <?php if(isset($drvehicles->Client_Vehicle_SoleSeparate_Claim1) && $drvehicles->Client_Vehicle_SoleSeparate_Claim1=='No'){ echo "checked"; } ?>> No</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 Client_Vehicle_Owned1_Div" id="Client_Vehicle_SoleSeparate_Party1_Div" style="display: none;">
                                    <label>Who claims to own this vehicle?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Client_Vehicle_SoleSeparate_Party1_Client" name="Client_Vehicle_SoleSeparate_Party1" value="{{$client_name}}" <?php if(isset($drvehicles->Client_Vehicle_SoleSeparate_Party1) && $drvehicles->Client_Vehicle_SoleSeparate_Party1==$client_name){ echo "checked"; } ?>> {{$client_name}}</label>
                                        <label><input type="radio" id="Client_Vehicle_SoleSeparate_Party1_Op" name="Client_Vehicle_SoleSeparate_Party1" value="{{$opponent_name}}" <?php if(isset($drvehicles->Client_Vehicle_SoleSeparate_Party1) && $drvehicles->Client_Vehicle_SoleSeparate_Party1==$opponent_name){ echo "checked"; } ?>> {{$opponent_name}}</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 Client_Vehicle_Owned1_Div" id="Client_Vehicle_SoleSeparate_Grounds1_Div" style="display: none;">
                                    <label for="Client_Vehicle_SoleSeparate_Grounds1">Why does this person own this vehicle solely and separately?</label>
                                    <input id="Client_Vehicle_SoleSeparate_Grounds1" type="text" class="form-control 1_Client_vehicles_inputs" name="Client_Vehicle_SoleSeparate_Grounds1" value="<?php if(isset($drvehicles->Client_Vehicle_SoleSeparate_Grounds1)){ echo $drvehicles->Client_Vehicle_SoleSeparate_Grounds1; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6 Client_Vehicle_Owned1_Div">
                                    <label>How will this vehicle value be distributed between the parties?</label>
                                    <div class="w-100 dataInput">
                                        <label><input type="radio" id="Client_Vehicle_Disposition_Method1_Liquidate_Split_Net_Value" name="Client_Vehicle_Disposition_Method1" value="Liquidate/Split Net Value" data-onload="getInitialDipositionMethod(this, '1', 'Client');" onchange="getDipositionMethod(this, '1', 'Client');" <?php if(isset($drvehicles->Client_Vehicle_Disposition_Method1) && $drvehicles->Client_Vehicle_Disposition_Method1=='Liquidate/Split Net Value'){ echo "checked"; } ?>> Liquidate/Split Net Value</label>
                                        <label><input type="radio" id="Client_Vehicle_Disposition_Method1_Fixed_Buyout" name="Client_Vehicle_Disposition_Method1" value="Fixed Buyout" data-onload="getInitialDipositionMethod(this, '1', 'Client');" onchange="getDipositionMethod(this, '1', 'Client');" <?php if(isset($drvehicles->Client_Vehicle_Disposition_Method1) && $drvehicles->Client_Vehicle_Disposition_Method1=='Fixed Buyout'){ echo "checked"; } ?>> Fixed Buyout</label>
                                    </div>
                                </div>
                                <!-- slider tool -->
                                <div class="form-group col-sm-6 m-auto 1_Client_Slider_Tool Client_Vehicle_Owned1_Div">
                                    <div class="row">
                                        <div class="col">{{$client_name}}</div>
                                        <div class="col text-right">{{$opponent_name}}</div>
                                    </div>
                                    <input id="1_Client_balance_range_selector" type="range" class="form-control slider-tool-input 1_Client_balance_range_selector" name="" value="<?php if(isset($drvehicles->Client_Vehicle_Percent_Marital_Equity_to_Op1)){ echo $drvehicles->Client_Vehicle_Percent_Marital_Equity_to_Op1; } ?>" min="0.00" step="0.01" max="100" onchange="updateBalanceInput(this.value, '1', 'Client');">
                                </div>
                                <div class="form-group col-sm-6 m-auto 1_Client_Slider_Tool Client_Vehicle_Owned1_Div">
                                    <div class="row justify-content-between">
                                        <div class="col selectorTool">
                                            <div class="left-col">
                                                <div class="client-info 1_Client_clientpercentage_div clientpercentage_div">
                                                    <?php if(isset($drvehicles->Client_Vehicle_Percent_Marital_Equity_to_Client1)){ echo $drvehicles->Client_Vehicle_Percent_Marital_Equity_to_Client1; } else {
                                                        echo '50.00';
                                                    } ?>%
                                                </div>
                                                <div class="client-info 1_Client_clientamount_div clientamount_div" style="clear: both;">
                                                    $<?php if(isset($drvehicles->Client_Vehicle_Estimated_Value_to_Client1)){ echo $drvehicles->Client_Vehicle_Estimated_Value_to_Client1; } else {
                                                        echo '50.00';
                                                    } ?>
                                                </div>
                                            </div>
                                            <label>To {{$client_name}}</label>
                                        </div>                                       
                                        <div class="col selectorTool selectorToolRight">
                                            <label>To {{$opponent_name}}</label>
                                            <div class="left-col right-col">
                                                <div class="client-info 1_Client_opponentpercentage_div opponentpercentage_div">
                                                    <?php if(isset($drvehicles->Client_Vehicle_Percent_Marital_Equity_to_Op1)){ echo $drvehicles->Client_Vehicle_Percent_Marital_Equity_to_Op1; } else {
                                                        echo '50.00';
                                                    } ?>%
                                                </div>
                                                <div class="client-info 1_Client_opponentamount_div opponentamount_div" style="clear: both;">
                                                    $<?php if(isset($drvehicles->Client_Vehicle_Estimated_Value_to_Op1)){ echo $drvehicles->Client_Vehicle_Estimated_Value_to_Op1; } else {
                                                        echo '50.00';
                                                    } ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 m-auto 1_Client_Slider_Tool Client_Vehicle_Owned1_Div">
                                    <label></label>
                                    <div class="w-100">
                                        <label><input type="radio" id="1_Client_Vehicle_Estimated_Value_Select" name="1_Client_Vehicle_Estimated_Value_Select_Reset" class="Vehicle_Estimated_Value_Select_Reset" value="Save"> Save this Distribution of Vehicles #1</label>
                                        <label><input type="radio" id="1_Client_Vehicle_Estimated_Value_Reset" name="1_Client_Vehicle_Estimated_Value_Select_Reset" class="Vehicle_Estimated_Value_Select_Reset" value="Reset" onclick="resetBalanceInput(this, '1', 'Client');"> Reset to Default (50%)</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 Client_Vehicle_Owned1_Div Client_Vehicle_Paying_Party1_Inputs_Div" style="display: none;">
                                    <label>Client Vehicles Paying Party1</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Client_Vehicle_Paying_Party1_Client" name="Client_Vehicle_Paying_Party1" value="{{$client_name}}" data-onload="getInitialVehiclesPayingParty(this, '1', 'Client');" onchange="getVehiclesPayingParty(this, '1', 'Client');" <?php if(isset($drvehicles->Client_Vehicle_Paying_Party1) && $drvehicles->Client_Vehicle_Paying_Party1==$client_name){ echo "checked"; } ?>> {{$client_name}}</label>
                                        <label><input type="radio" id="Client_Vehicle_Paying_Party1_Op" name="Client_Vehicle_Paying_Party1" value="{{$opponent_name}}" data-onload="getInitialVehiclesPayingParty(this, '1', 'Client');" onchange="getVehiclesPayingParty(this, '1', 'Client');" <?php if(isset($drvehicles->Client_Vehicle_Paying_Party1) && $drvehicles->Client_Vehicle_Paying_Party1==$opponent_name){ echo "checked"; } ?>> {{$opponent_name}}</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 Client_Vehicle_Owned1_Div Client_Vehicle_Paying_Party1_Inputs_Div" style="display: none;">
                                    <label>{{$client_name}} Vehicles Equity Percent</label>
                                    <input id="Client_Vehicle_Percent_Marital_Equity_to_Client1" type="number" class="form-control 1_Client_clientpercentage_input clientpercentage_input" name="Client_Vehicle_Percent_Marital_Equity_to_Client1" value="<?php if(isset($drvehicles->Client_Vehicle_Percent_Marital_Equity_to_Client1)){ echo $drvehicles->Client_Vehicle_Percent_Marital_Equity_to_Client1; } ?>" min="0.00" step="0.01" max="100" readonly="">
                                </div>
                                <div class="form-group col-sm-6 Client_Vehicle_Owned1_Div Client_Vehicle_Paying_Party1_Inputs_Div" style="display: none;">
                                    <label>How much is to be paid to {{$client_name}}?</label>
                                    <input id="Client_Vehicle_Estimated_Value_to_Client1" type="number" class="form-control 1_Client_clientamount_input clientamount_input" name="Client_Vehicle_Estimated_Value_to_Client1" value="<?php if(isset($drvehicles->Client_Vehicle_Estimated_Value_to_Client1)){ echo $drvehicles->Client_Vehicle_Estimated_Value_to_Client1; } ?>" min="0.00" step="0.01" max="999999.99" readonly="" onchange="getEstimatedValueClient(this, '1', 'Client');" onkeyup="getEstimatedValueClient(this, '1', 'Client');">
                                </div>
                                <div class="form-group col-sm-6 Client_Vehicle_Owned1_Div Client_Vehicle_Paying_Party1_Inputs_Div" style="display: none;">
                                    <label>{{$opponent_name}} Vehicles Equity Percent</label>
                                    <input id="Client_Vehicle_Percent_Marital_Equity_to_Op1" type="number" class="form-control 1_Client_opponentpercentage_input opponentpercentage_input" name="Client_Vehicle_Percent_Marital_Equity_to_Op1" value="<?php if(isset($drvehicles->Client_Vehicle_Percent_Marital_Equity_to_Op1)){ echo $drvehicles->Client_Vehicle_Percent_Marital_Equity_to_Op1; } ?>" min="0.00" step="0.01" max="100" readonly="">
                                </div>
                                <div class="form-group col-sm-6 Client_Vehicle_Owned1_Div Client_Vehicle_Paying_Party1_Inputs_Div" style="display: none;">
                                    <label>How much is to be paid to {{$opponent_name}}?</label>
                                    <input id="Client_Vehicle_Estimated_Value_to_Op1" type="number" class="form-control 1_Client_opponentamount_input opponentamount_input" name="Client_Vehicle_Estimated_Value_to_Op1" value="<?php if(isset($drvehicles->Client_Vehicle_Estimated_Value_to_Op1)){ echo $drvehicles->Client_Vehicle_Estimated_Value_to_Op1; } ?>" min="0.00" step="0.01" max="999999.99" readonly="" onchange="getEstimatedValueOp(this, '1', 'Client');" onkeyup="getEstimatedValueOp(this, '1', 'Client');">
                                </div>
                                <!-- end of slider tool -->
                                <div class="form-group col-sm-6 Client_Vehicle_Paying_Party1_Leased_Div" style="display: none;">
                                    <label for="Client_Vehicle_Lease_Company1">Name of vehicle lease company?</label>
                                    <input id="Client_Vehicle_Lease_Company1" type="text" class="form-control 1_Client_vehicles_inputs Client_Vehicle_Paying_Party1_Leased_Input" name="Client_Vehicle_Lease_Company1" value="<?php if(isset($drvehicles->Client_Vehicle_Lease_Company1)){ echo $drvehicles->Client_Vehicle_Lease_Company1; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6 Client_Vehicle_Paying_Party1_Leased_Div" style="display: none;">
                                    <label>Monthly lease payment for this vehicle?</label>
                                    <input id="Client_Vehicle_Monthly_Lease_Amount1" type="number" class="form-control 1_Client_vehicles_inputs Client_Vehicle_Paying_Party1_Leased_Input" name="Client_Vehicle_Monthly_Lease_Amount1" value="<?php if(isset($drvehicles->Client_Vehicle_Monthly_Lease_Amount1)){ echo $drvehicles->Client_Vehicle_Monthly_Lease_Amount1; } ?>" min="0.00" step="0.01" max="999999.99">
                                </div>
                                <div class="form-group col-sm-6 Client_Vehicle_Paying_Party1_Leased_Div" style="display: none;">
                                    <label>How will this leased vehicle be handled?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Client_Vehicle_Lease_Disposition_Method1_Terminate_Lease" name="Client_Vehicle_Lease_Disposition_Method1" value="Terminate Lease" <?php if(isset($drvehicles->Client_Vehicle_Lease_Disposition_Method1) && $drvehicles->Client_Vehicle_Lease_Disposition_Method1=='Terminate Lease'){ echo "checked"; } ?>> Terminate Lease</label>
                                        <label><input type="radio" id="Client_Vehicle_Lease_Disposition_Method1_Transfer_Lease_Responsibility_to_ClientName" name="Client_Vehicle_Lease_Disposition_Method1" value="Transfer Lease Responsibility to {{$client_name}}" <?php if(isset($drvehicles->Client_Vehicle_Lease_Disposition_Method1) && $drvehicles->Client_Vehicle_Lease_Disposition_Method1=='Transfer Lease Responsibility to '.$client_name.''){ echo "checked"; } ?>> Transfer Lease Responsibility to {{$client_name}}</label>
                                        <label><input type="radio" id="Client_Vehicle_Lease_Disposition_Method1_Transfer_Lease_Responsibility_to_OpName" name="Client_Vehicle_Lease_Disposition_Method1" value="Transfer Lease Responsibility to {{$opponent_name}}" <?php if(isset($drvehicles->Client_Vehicle_Lease_Disposition_Method1) && $drvehicles->Client_Vehicle_Lease_Disposition_Method1=='Transfer Lease Responsibility to '.$opponent_name.''){ echo "checked"; } ?>> Transfer Lease Responsibility to {{$opponent_name}}</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 mt-4 2_Client_vehicles_section" style="display: none;"><h5 class="col-sm-12">Second Vehicle Info</h5>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Vehicle_Year2">Model year of this vehicle?</label>
                                    <select id="Client_Vehicle_Year2" name="Client_Vehicle_Year2" class="form-control 2_Client_vehicles_select">
                                        <?php 
                                            if(isset($drvehicles->Client_Vehicle_Year2)){ 
                                                $already_selected_value = $drvehicles->Client_Vehicle_Year2; 
                                            } else {
                                                $already_selected_value = '';
                                            }
                                            $earliest_year = 1900;
                                            foreach (range(date('Y'), $earliest_year) as $x) {
                                                echo '<option value="'.$x.'"'.($x == $already_selected_value ? ' selected="selected"' : '').'>'.$x.'</option>';
                                            }
                                        ?>
                                    </select>   
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Vehicle_Make_Model2">What make and model is this vehicle?</label>
                                    <input id="Client_Vehicle_Make_Model2" type="text" class="form-control 2_Client_vehicles_inputs" name="Client_Vehicle_Make_Model2" value="<?php if(isset($drvehicles->Client_Vehicle_Make_Model2)){ echo $drvehicles->Client_Vehicle_Make_Model2; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Is this vehicle leased or owned?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Client_Vehicle_Owned_Leased2_Owned" name="Client_Vehicle_Owned_Leased2" value="Owned" data-onload="getInitialVehicleOwnedLeased(this, '2', 'Client');" onchange="getVehicleOwnedLeased(this, '2', 'Client');" <?php if(isset($drvehicles->Client_Vehicle_Owned_Leased2) && $drvehicles->Client_Vehicle_Owned_Leased2=='Owned'){ echo "checked"; } ?>> Owned</label>
                                        <label><input type="radio" id="Client_Vehicle_Owned_Leased2_Leased" name="Client_Vehicle_Owned_Leased2" value="Leased" data-onload="getInitialVehicleOwnedLeased(this, '2', 'Client');" onchange="getVehicleOwnedLeased(this, '2', 'Client');" <?php if(isset($drvehicles->Client_Vehicle_Owned_Leased2) && $drvehicles->Client_Vehicle_Owned_Leased2=='Leased'){ echo "checked"; } ?>> Leased</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 Client_Vehicle_Owned2_Div">
                                    <label for="Client_Vehicle_VIN2">What is the VIN of this vehicle?</label>
                                    <input id="Client_Vehicle_VIN2" type="text" class="form-control 2_Client_vehicles_inputs" name="Client_Vehicle_VIN2" value="<?php if(isset($drvehicles->Client_Vehicle_VIN2)){ echo $drvehicles->Client_Vehicle_VIN2; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6 Client_Vehicle_Owned2_Div">
                                    <label for="Client_Vehicle_Current_Value2">What is the current value of this vehicle?</label>
                                    <input id="Client_Vehicle_Current_Value2" type="number" class="form-control 2_Client_vehicles_inputs" name="Client_Vehicle_Current_Value2" value="<?php if(isset($drvehicles->Client_Vehicle_Current_Value2)){ echo $drvehicles->Client_Vehicle_Current_Value2; } ?>" min="0.00" step="0.01" max="999999.99" onchange="getCurrentValue(this, '2', 'Client');" onkeyup="getCurrentValue(this, '2', 'Client');">
                                </div>
                                <div class="form-group col-sm-6 Client_Vehicle_Owned2_Div">
                                    <label for="Client_Vehicle_Loan_Company_Name2">Name of first car loan company?</label>
                                    <input id="Client_Vehicle_Loan_Company_Name2" type="text" class="form-control 2_Client_vehicles_inputs" name="Client_Vehicle_Loan_Company_Name2" value="<?php if(isset($drvehicles->Client_Vehicle_Loan_Company_Name2)){ echo $drvehicles->Client_Vehicle_Loan_Company_Name2; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6 Client_Vehicle_Owned2_Div">
                                    <label for="Client_Vehicle_Loan_Balance2">Balance due to first car loan company for this vehicle?</label>
                                    <input id="Client_Vehicle_Loan_Balance2" type="number" class="form-control 2_Client_vehicles_inputs" name="Client_Vehicle_Loan_Balance2" value="<?php if(isset($drvehicles->Client_Vehicle_Loan_Balance2)){ echo $drvehicles->Client_Vehicle_Loan_Balance2; } ?>" min="0.00" step="0.01" max="999999.99" onchange="getLoanBalance(this, '2', 'Client');" onkeyup="getLoanBalance(this, '2', 'Client');">
                                </div>
                                <div class="form-group col-sm-6 Client_Vehicle_Owned2_Div">
                                    <label for="Client_Vehicle_Loan_Monthly_Payment2">Monthly payment to first car loan company for this vehicle?</label>
                                    <input id="Client_Vehicle_Loan_Monthly_Payment2" type="number" class="form-control 2_Client_vehicles_inputs" name="Client_Vehicle_Loan_Monthly_Payment2" value="<?php if(isset($drvehicles->Client_Vehicle_Loan_Monthly_Payment2)){ echo $drvehicles->Client_Vehicle_Loan_Monthly_Payment2; } ?>" min="0.00" step="0.01" max="999999.99">
                                </div>
                                <div class="form-group col-sm-6 Client_Vehicle_Owned2_Div">
                                    <label for="Client_Vehicle_Loan_Second_Company_Name2">Name of second car loan company?</label>
                                    <input id="Client_Vehicle_Loan_Second_Company_Name2" type="text" class="form-control 2_Client_vehicles_inputs" name="Client_Vehicle_Loan_Second_Company_Name2" value="<?php if(isset($drvehicles->Client_Vehicle_Loan_Second_Company_Name2)){ echo $drvehicles->Client_Vehicle_Loan_Second_Company_Name2; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6 Client_Vehicle_Owned2_Div">
                                    <label for="Client_Vehicle_Loan_Second_Company_Balance2">Balance due to second car loan company for this vehicle?</label>
                                    <input id="Client_Vehicle_Loan_Second_Company_Balance2" type="number" class="form-control 2_Client_vehicles_inputs" name="Client_Vehicle_Loan_Second_Company_Balance2" value="<?php if(isset($drvehicles->Client_Vehicle_Loan_Second_Company_Balance2)){ echo $drvehicles->Client_Vehicle_Loan_Second_Company_Balance2; } ?>" min="0.00" step="0.01" max="999999.99" onchange="getCompanyBalance(this, '2', 'Client');" onkeyup="getCompanyBalance(this, '2', 'Client');">
                                </div>
                                <div class="form-group col-sm-6 Client_Vehicle_Owned2_Div">
                                    <label for="Client_Vehicle_Loan_Second_Company_Monthly_Payment2">Monthly payment to second car loan company for this vehicle?</label>
                                    <input id="Client_Vehicle_Loan_Second_Company_Monthly_Payment2" type="number" class="form-control 2_Client_vehicles_inputs" name="Client_Vehicle_Loan_Second_Company_Monthly_Payment2" value="<?php if(isset($drvehicles->Client_Vehicle_Loan_Second_Company_Monthly_Payment2)){ echo $drvehicles->Client_Vehicle_Loan_Second_Company_Monthly_Payment2; } ?>" min="0.00" step="0.01" max="999999.99">
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label for="Client_Vehicle_Marital_Equity2">N/A, calculated = Client_Vehicle_Current_Value2-Client_Vehicle_Loan_Balance2-Client_Vehicle_Loan_Second_Company_Balance2</label>
                                    <input id="Client_Vehicle_Marital_Equity2" type="number" class="form-control 2_Client_vehicles_inputs" name="Client_Vehicle_Marital_Equity2" value="<?php if(isset($drvehicles->Client_Vehicle_Marital_Equity2)){ echo $drvehicles->Client_Vehicle_Marital_Equity2; } ?>" min="0.00" step="0.01" max="999999.99">
                                </div>
                                <div class="form-group col-sm-6 Client_Vehicle_Owned2_Div">
                                    <label>Does either party claim a sole/separate interest in this vehicle?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Client_Vehicle_SoleSeparate_Claim2_Yes" name="Client_Vehicle_SoleSeparate_Claim2" value="Yes" data-onload="getInitialPartyClaimSoleSeparate(this, '2', 'Client');" onchange="getPartyClaimSoleSeparate(this, '2', 'Client');" <?php if(isset($drvehicles->Client_Vehicle_SoleSeparate_Claim2) && $drvehicles->Client_Vehicle_SoleSeparate_Claim2=='Yes'){ echo "checked"; } ?>> Yes</label>
                                        <label><input type="radio" id="Client_Vehicle_SoleSeparate_Claim2_No" name="Client_Vehicle_SoleSeparate_Claim2" value="No" data-onload="getInitialPartyClaimSoleSeparate(this, '2', 'Client');" onchange="getPartyClaimSoleSeparate(this, '2', 'Client');" <?php if(isset($drvehicles->Client_Vehicle_SoleSeparate_Claim2) && $drvehicles->Client_Vehicle_SoleSeparate_Claim2=='No'){ echo "checked"; } ?>> No</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 Client_Vehicle_Owned2_Div" id="Client_Vehicle_SoleSeparate_Party2_Div" style="display: none;">
                                    <label>Who claims to own this vehicle?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Client_Vehicle_SoleSeparate_Party2_Client" name="Client_Vehicle_SoleSeparate_Party2" value="{{$client_name}}" <?php if(isset($drvehicles->Client_Vehicle_SoleSeparate_Party2) && $drvehicles->Client_Vehicle_SoleSeparate_Party2==$client_name){ echo "checked"; } ?>> {{$client_name}}</label>
                                        <label><input type="radio" id="Client_Vehicle_SoleSeparate_Party2_Op" name="Client_Vehicle_SoleSeparate_Party2" value="{{$opponent_name}}" <?php if(isset($drvehicles->Client_Vehicle_SoleSeparate_Party2) && $drvehicles->Client_Vehicle_SoleSeparate_Party2==$opponent_name){ echo "checked"; } ?>> {{$opponent_name}}</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 Client_Vehicle_Owned2_Div" id="Client_Vehicle_SoleSeparate_Grounds2_Div" style="display: none;">
                                    <label for="Client_Vehicle_SoleSeparate_Grounds2">Why does this person own this vehicle solely and separately?</label>
                                    <input id="Client_Vehicle_SoleSeparate_Grounds2" type="text" class="form-control 2_Client_vehicles_inputs" name="Client_Vehicle_SoleSeparate_Grounds2" value="<?php if(isset($drvehicles->Client_Vehicle_SoleSeparate_Grounds2)){ echo $drvehicles->Client_Vehicle_SoleSeparate_Grounds2; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6 Client_Vehicle_Owned2_Div">
                                    <label>How will this vehicle value be distributed between the parties?</label>
                                    <div class="w-100 dataInput">
                                        <label><input type="radio" id="Client_Vehicle_Disposition_Method2_Liquidate_Split_Net_Value" name="Client_Vehicle_Disposition_Method2" value="Liquidate/Split Net Value" data-onload="getInitialDipositionMethod(this, '2', 'Client');" onchange="getDipositionMethod(this, '2', 'Client');" <?php if(isset($drvehicles->Client_Vehicle_Disposition_Method2) && $drvehicles->Client_Vehicle_Disposition_Method2=='Liquidate/Split Net Value'){ echo "checked"; } ?>> Liquidate/Split Net Value</label>
                                        <label><input type="radio" id="Client_Vehicle_Disposition_Method2_Fixed_Buyout" name="Client_Vehicle_Disposition_Method2" value="Fixed Buyout" data-onload="getInitialDipositionMethod(this, '2', 'Client');" onchange="getDipositionMethod(this, '2', 'Client');" <?php if(isset($drvehicles->Client_Vehicle_Disposition_Method2) && $drvehicles->Client_Vehicle_Disposition_Method2=='Fixed Buyout'){ echo "checked"; } ?>> Fixed Buyout</label>
                                    </div>
                                </div>
                                <!-- slider tool -->
                                <div class="form-group col-sm-6 m-auto 2_Client_Slider_Tool Client_Vehicle_Owned2_Div">
                                    <div class="row">
                                        <div class="col">{{$client_name}}</div>
                                        <div class="col text-right">{{$opponent_name}}</div>
                                    </div>
                                    <input id="2_Client_balance_range_selector" type="range" class="form-control slider-tool-input 2_Client_balance_range_selector" name="" value="<?php if(isset($drvehicles->Client_Vehicle_Percent_Marital_Equity_to_Op2)){ echo $drvehicles->Client_Vehicle_Percent_Marital_Equity_to_Op2; } ?>" min="0.00" step="0.01" max="100" onchange="updateBalanceInput(this.value, '2', 'Client');">
                                </div>
                                <div class="form-group col-sm-6 m-auto 2_Client_Slider_Tool Client_Vehicle_Owned2_Div">
                                    <div class="row justify-content-between">
                                        <div class="col selectorTool">
                                            <div class="left-col">
                                                <div class="client-info 2_Client_clientpercentage_div clientpercentage_div">
                                                    <?php if(isset($drvehicles->Client_Vehicle_Percent_Marital_Equity_to_Client2)){ echo $drvehicles->Client_Vehicle_Percent_Marital_Equity_to_Client2; } else {
                                                        echo '50.00';
                                                    } ?>%
                                                </div>
                                                <div class="client-info 2_Client_clientamount_div clientamount_div" style="clear: both;">
                                                    $<?php if(isset($drvehicles->Client_Vehicle_Estimated_Value_to_Client2)){ echo $drvehicles->Client_Vehicle_Estimated_Value_to_Client2; } else {
                                                        echo '50.00';
                                                    } ?>
                                                </div>
                                            </div>
                                            <label>To {{$client_name}}</label>
                                        </div>                                       
                                        <div class="col selectorTool selectorToolRight">
                                            <label>To {{$opponent_name}}</label>
                                            <div class="left-col right-col">
                                                <div class="client-info 2_Client_opponentpercentage_div opponentpercentage_div">
                                                    <?php if(isset($drvehicles->Client_Vehicle_Percent_Marital_Equity_to_Op2)){ echo $drvehicles->Client_Vehicle_Percent_Marital_Equity_to_Op2; } else {
                                                        echo '50.00';
                                                    } ?>%
                                                </div>
                                                <div class="client-info 2_Client_opponentamount_div opponentamount_div" style="clear: both;">
                                                    $<?php if(isset($drvehicles->Client_Vehicle_Estimated_Value_to_Op2)){ echo $drvehicles->Client_Vehicle_Estimated_Value_to_Op2; } else {
                                                        echo '50.00';
                                                    } ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 m-auto 2_Client_Slider_Tool Client_Vehicle_Owned2_Div">
                                    <label></label>
                                    <div class="w-100">
                                        <label><input type="radio" id="2_Client_Vehicle_Estimated_Value_Select" name="2_Client_Vehicle_Estimated_Value_Select_Reset" class="Vehicle_Estimated_Value_Select_Reset" value="Save"> Save this Distribution of Vehicles #2</label>
                                        <label><input type="radio" id="2_Client_Vehicle_Estimated_Value_Reset" name="2_Client_Vehicle_Estimated_Value_Select_Reset" class="Vehicle_Estimated_Value_Select_Reset" value="Reset" onclick="resetBalanceInput(this, '2', 'Client');"> Reset to Default (50%)</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 Client_Vehicle_Owned2_Div Client_Vehicle_Paying_Party2_Inputs_Div" style="display: none;">
                                    <label>Client Vehicles Paying Party2</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Client_Vehicle_Paying_Party2_Client" name="Client_Vehicle_Paying_Party2" value="{{$client_name}}" data-onload="getInitialVehiclesPayingParty(this, '2', 'Client');" onchange="getVehiclesPayingParty(this, '2', 'Client');" <?php if(isset($drvehicles->Client_Vehicle_Paying_Party2) && $drvehicles->Client_Vehicle_Paying_Party2==$client_name){ echo "checked"; } ?>> {{$client_name}}</label>
                                        <label><input type="radio" id="Client_Vehicle_Paying_Party2_Op" name="Client_Vehicle_Paying_Party2" value="{{$opponent_name}}" data-onload="getInitialVehiclesPayingParty(this, '2', 'Client');" onchange="getVehiclesPayingParty(this, '2', 'Client');" <?php if(isset($drvehicles->Client_Vehicle_Paying_Party2) && $drvehicles->Client_Vehicle_Paying_Party2==$opponent_name){ echo "checked"; } ?>> {{$opponent_name}}</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 Client_Vehicle_Owned2_Div Client_Vehicle_Paying_Party2_Inputs_Div" style="display: none;">
                                    <label>{{$client_name}} Vehicles Equity Percent</label>
                                    <input id="Client_Vehicle_Percent_Marital_Equity_to_Client2" type="number" class="form-control 2_Client_clientpercentage_input clientpercentage_input" name="Client_Vehicle_Percent_Marital_Equity_to_Client2" value="<?php if(isset($drvehicles->Client_Vehicle_Percent_Marital_Equity_to_Client2)){ echo $drvehicles->Client_Vehicle_Percent_Marital_Equity_to_Client2; } ?>" min="0.00" step="0.01" max="100" readonly="">
                                </div>
                                <div class="form-group col-sm-6 Client_Vehicle_Owned2_Div Client_Vehicle_Paying_Party2_Inputs_Div" style="display: none;">
                                    <label>How much is to be paid to {{$client_name}}?</label>
                                    <input id="Client_Vehicle_Estimated_Value_to_Client2" type="number" class="form-control 2_Client_clientamount_input clientamount_input" name="Client_Vehicle_Estimated_Value_to_Client2" value="<?php if(isset($drvehicles->Client_Vehicle_Estimated_Value_to_Client2)){ echo $drvehicles->Client_Vehicle_Estimated_Value_to_Client2; } ?>" min="0.00" step="0.01" max="999999.99" readonly="" onchange="getEstimatedValueClient(this, '2', 'Client');" onkeyup="getEstimatedValueClient(this, '2', 'Client');">
                                </div>
                                <div class="form-group col-sm-6 Client_Vehicle_Owned2_Div Client_Vehicle_Paying_Party2_Inputs_Div" style="display: none;">
                                    <label>{{$opponent_name}} Vehicles Equity Percent</label>
                                    <input id="Client_Vehicle_Percent_Marital_Equity_to_Op2" type="number" class="form-control 2_Client_opponentpercentage_input opponentpercentage_input" name="Client_Vehicle_Percent_Marital_Equity_to_Op2" value="<?php if(isset($drvehicles->Client_Vehicle_Percent_Marital_Equity_to_Op2)){ echo $drvehicles->Client_Vehicle_Percent_Marital_Equity_to_Op2; } ?>" min="0.00" step="0.01" max="100" readonly="">
                                </div>
                                <div class="form-group col-sm-6 Client_Vehicle_Owned2_Div Client_Vehicle_Paying_Party2_Inputs_Div" style="display: none;">
                                    <label>How much is to be paid to {{$opponent_name}}?</label>
                                    <input id="Client_Vehicle_Estimated_Value_to_Op2" type="number" class="form-control 2_Client_opponentamount_input opponentamount_input" name="Client_Vehicle_Estimated_Value_to_Op2" value="<?php if(isset($drvehicles->Client_Vehicle_Estimated_Value_to_Op2)){ echo $drvehicles->Client_Vehicle_Estimated_Value_to_Op2; } ?>" min="0.00" step="0.01" max="999999.99" readonly="" onchange="getEstimatedValueOp(this, '2', 'Client');" onkeyup="getEstimatedValueOp(this, '2', 'Client');">
                                </div>
                                <!-- end of slider tool -->
                                <div class="form-group col-sm-6 Client_Vehicle_Paying_Party2_Leased_Div" style="display: none;">
                                    <label for="Client_Vehicle_Lease_Company2">Name of vehicle lease company?</label>
                                    <input id="Client_Vehicle_Lease_Company2" type="text" class="form-control 2_Client_vehicles_inputs Client_Vehicle_Paying_Party2_Leased_Input" name="Client_Vehicle_Lease_Company2" value="<?php if(isset($drvehicles->Client_Vehicle_Lease_Company2)){ echo $drvehicles->Client_Vehicle_Lease_Company2; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6 Client_Vehicle_Paying_Party2_Leased_Div" style="display: none;">
                                    <label>Monthly lease payment for this vehicle?</label>
                                    <input id="Client_Vehicle_Monthly_Lease_Amount2" type="number" class="form-control 2_Client_vehicles_inputs Client_Vehicle_Paying_Party2_Leased_Input" name="Client_Vehicle_Monthly_Lease_Amount2" value="<?php if(isset($drvehicles->Client_Vehicle_Monthly_Lease_Amount2)){ echo $drvehicles->Client_Vehicle_Monthly_Lease_Amount2; } ?>" min="0.00" step="0.01" max="999999.99">
                                </div>
                                <div class="form-group col-sm-6 Client_Vehicle_Paying_Party2_Leased_Div" style="display: none;">
                                    <label>How will this leased vehicle be handled?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Client_Vehicle_Lease_Disposition_Method2_Terminate_Lease" name="Client_Vehicle_Lease_Disposition_Method2" value="Terminate Lease" <?php if(isset($drvehicles->Client_Vehicle_Lease_Disposition_Method2) && $drvehicles->Client_Vehicle_Lease_Disposition_Method2=='Terminate Lease'){ echo "checked"; } ?>> Terminate Lease</label>
                                        <label><input type="radio" id="Client_Vehicle_Lease_Disposition_Method2_Transfer_Lease_Responsibility_to_ClientName" name="Client_Vehicle_Lease_Disposition_Method2" value="Transfer Lease Responsibility to {{$client_name}}" <?php if(isset($drvehicles->Client_Vehicle_Lease_Disposition_Method2) && $drvehicles->Client_Vehicle_Lease_Disposition_Method2=='Transfer Lease Responsibility to '.$client_name.''){ echo "checked"; } ?>> Transfer Lease Responsibility to {{$client_name}}</label>
                                        <label><input type="radio" id="Client_Vehicle_Lease_Disposition_Method2_Transfer_Lease_Responsibility_to_OpName" name="Client_Vehicle_Lease_Disposition_Method2" value="Transfer Lease Responsibility to {{$opponent_name}}" <?php if(isset($drvehicles->Client_Vehicle_Lease_Disposition_Method2) && $drvehicles->Client_Vehicle_Lease_Disposition_Method2=='Transfer Lease Responsibility to '.$opponent_name.''){ echo "checked"; } ?>> Transfer Lease Responsibility to {{$opponent_name}}</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 mt-4 3_Client_vehicles_section" style="display: none;"><h5 class="col-sm-12">Third Vehicle Info</h5>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Vehicle_Year3">Model year of this vehicle?</label>
                                    <select id="Client_Vehicle_Year3" name="Client_Vehicle_Year3" class="form-control 3_Client_vehicles_select">
                                        <?php 
                                            if(isset($drvehicles->Client_Vehicle_Year3)){ 
                                                $already_selected_value = $drvehicles->Client_Vehicle_Year3; 
                                            } else {
                                                $already_selected_value = '';
                                            }
                                            $earliest_year = 1900;
                                            foreach (range(date('Y'), $earliest_year) as $x) {
                                                echo '<option value="'.$x.'"'.($x == $already_selected_value ? ' selected="selected"' : '').'>'.$x.'</option>';
                                            }
                                        ?>
                                    </select>   
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Vehicle_Make_Model3">What make and model is this vehicle?</label>
                                    <input id="Client_Vehicle_Make_Model3" type="text" class="form-control 3_Client_vehicles_inputs" name="Client_Vehicle_Make_Model3" value="<?php if(isset($drvehicles->Client_Vehicle_Make_Model3)){ echo $drvehicles->Client_Vehicle_Make_Model3; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Is this vehicle leased or owned?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Client_Vehicle_Owned_Leased3_Owned" name="Client_Vehicle_Owned_Leased3" value="Owned" data-onload="getInitialVehicleOwnedLeased(this, '3', 'Client');" onchange="getVehicleOwnedLeased(this, '3', 'Client');" <?php if(isset($drvehicles->Client_Vehicle_Owned_Leased3) && $drvehicles->Client_Vehicle_Owned_Leased3=='Owned'){ echo "checked"; } ?>> Owned</label>
                                        <label><input type="radio" id="Client_Vehicle_Owned_Leased3_Leased" name="Client_Vehicle_Owned_Leased3" value="Leased" data-onload="getInitialVehicleOwnedLeased(this, '3', 'Client');" onchange="getVehicleOwnedLeased(this, '3', 'Client');" <?php if(isset($drvehicles->Client_Vehicle_Owned_Leased3) && $drvehicles->Client_Vehicle_Owned_Leased3=='Leased'){ echo "checked"; } ?>> Leased</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 Client_Vehicle_Owned3_Div">
                                    <label for="Client_Vehicle_VIN3">What is the VIN of this vehicle?</label>
                                    <input id="Client_Vehicle_VIN3" type="text" class="form-control 3_Client_vehicles_inputs" name="Client_Vehicle_VIN3" value="<?php if(isset($drvehicles->Client_Vehicle_VIN3)){ echo $drvehicles->Client_Vehicle_VIN3; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6 Client_Vehicle_Owned3_Div">
                                    <label for="Client_Vehicle_Current_Value3">What is the current value of this vehicle?</label>
                                    <input id="Client_Vehicle_Current_Value3" type="number" class="form-control 3_Client_vehicles_inputs" name="Client_Vehicle_Current_Value3" value="<?php if(isset($drvehicles->Client_Vehicle_Current_Value3)){ echo $drvehicles->Client_Vehicle_Current_Value3; } ?>" min="0.00" step="0.01" max="999999.99" onchange="getCurrentValue(this, '3', 'Client');" onkeyup="getCurrentValue(this, '3', 'Client');">
                                </div>
                                <div class="form-group col-sm-6 Client_Vehicle_Owned3_Div">
                                    <label for="Client_Vehicle_Loan_Company_Name3">Name of first car loan company?</label>
                                    <input id="Client_Vehicle_Loan_Company_Name3" type="text" class="form-control 3_Client_vehicles_inputs" name="Client_Vehicle_Loan_Company_Name3" value="<?php if(isset($drvehicles->Client_Vehicle_Loan_Company_Name3)){ echo $drvehicles->Client_Vehicle_Loan_Company_Name3; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6 Client_Vehicle_Owned3_Div">
                                    <label for="Client_Vehicle_Loan_Balance3">Balance due to first car loan company for this vehicle?</label>
                                    <input id="Client_Vehicle_Loan_Balance3" type="number" class="form-control 3_Client_vehicles_inputs" name="Client_Vehicle_Loan_Balance3" value="<?php if(isset($drvehicles->Client_Vehicle_Loan_Balance3)){ echo $drvehicles->Client_Vehicle_Loan_Balance3; } ?>" min="0.00" step="0.01" max="999999.99" onchange="getLoanBalance(this, '3', 'Client');" onkeyup="getLoanBalance(this, '3', 'Client');">
                                </div>
                                <div class="form-group col-sm-6 Client_Vehicle_Owned3_Div">
                                    <label for="Client_Vehicle_Loan_Monthly_Payment3">Monthly payment to first car loan company for this vehicle?</label>
                                    <input id="Client_Vehicle_Loan_Monthly_Payment3" type="number" class="form-control 3_Client_vehicles_inputs" name="Client_Vehicle_Loan_Monthly_Payment3" value="<?php if(isset($drvehicles->Client_Vehicle_Loan_Monthly_Payment3)){ echo $drvehicles->Client_Vehicle_Loan_Monthly_Payment3; } ?>" min="0.00" step="0.01" max="999999.99">
                                </div>
                                <div class="form-group col-sm-6 Client_Vehicle_Owned3_Div">
                                    <label for="Client_Vehicle_Loan_Second_Company_Name3">Name of second car loan company?</label>
                                    <input id="Client_Vehicle_Loan_Second_Company_Name3" type="text" class="form-control 3_Client_vehicles_inputs" name="Client_Vehicle_Loan_Second_Company_Name3" value="<?php if(isset($drvehicles->Client_Vehicle_Loan_Second_Company_Name3)){ echo $drvehicles->Client_Vehicle_Loan_Second_Company_Name3; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6 Client_Vehicle_Owned3_Div">
                                    <label for="Client_Vehicle_Loan_Second_Company_Balance3">Balance due to second car loan company for this vehicle?</label>
                                    <input id="Client_Vehicle_Loan_Second_Company_Balance3" type="number" class="form-control 3_Client_vehicles_inputs" name="Client_Vehicle_Loan_Second_Company_Balance3" value="<?php if(isset($drvehicles->Client_Vehicle_Loan_Second_Company_Balance3)){ echo $drvehicles->Client_Vehicle_Loan_Second_Company_Balance3; } ?>" min="0.00" step="0.01" max="999999.99" onchange="getCompanyBalance(this, '3', 'Client');" onkeyup="getCompanyBalance(this, '3', 'Client');">
                                </div>
                                <div class="form-group col-sm-6 Client_Vehicle_Owned3_Div">
                                    <label for="Client_Vehicle_Loan_Second_Company_Monthly_Payment3">Monthly payment to second car loan company for this vehicle?</label>
                                    <input id="Client_Vehicle_Loan_Second_Company_Monthly_Payment3" type="number" class="form-control 3_Client_vehicles_inputs" name="Client_Vehicle_Loan_Second_Company_Monthly_Payment3" value="<?php if(isset($drvehicles->Client_Vehicle_Loan_Second_Company_Monthly_Payment3)){ echo $drvehicles->Client_Vehicle_Loan_Second_Company_Monthly_Payment3; } ?>" min="0.00" step="0.01" max="999999.99">
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label for="Client_Vehicle_Marital_Equity3">N/A, calculated = Client_Vehicle_Current_Value3-Client_Vehicle_Loan_Balance3-Client_Vehicle_Loan_Second_Company_Balance3</label>
                                    <input id="Client_Vehicle_Marital_Equity3" type="number" class="form-control 3_Client_vehicles_inputs" name="Client_Vehicle_Marital_Equity3" value="<?php if(isset($drvehicles->Client_Vehicle_Marital_Equity3)){ echo $drvehicles->Client_Vehicle_Marital_Equity3; } ?>" min="0.00" step="0.01" max="999999.99">
                                </div>
                                <div class="form-group col-sm-6 Client_Vehicle_Owned3_Div">
                                    <label>Does either party claim a sole/separate interest in this vehicle?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Client_Vehicle_SoleSeparate_Claim3_Yes" name="Client_Vehicle_SoleSeparate_Claim3" value="Yes" data-onload="getInitialPartyClaimSoleSeparate(this, '3', 'Client');" onchange="getPartyClaimSoleSeparate(this, '3', 'Client');" <?php if(isset($drvehicles->Client_Vehicle_SoleSeparate_Claim3) && $drvehicles->Client_Vehicle_SoleSeparate_Claim3=='Yes'){ echo "checked"; } ?>> Yes</label>
                                        <label><input type="radio" id="Client_Vehicle_SoleSeparate_Claim3_No" name="Client_Vehicle_SoleSeparate_Claim3" value="No" data-onload="getInitialPartyClaimSoleSeparate(this, '3', 'Client');" onchange="getPartyClaimSoleSeparate(this, '3', 'Client');" <?php if(isset($drvehicles->Client_Vehicle_SoleSeparate_Claim3) && $drvehicles->Client_Vehicle_SoleSeparate_Claim3=='No'){ echo "checked"; } ?>> No</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 Client_Vehicle_Owned3_Div" id="Client_Vehicle_SoleSeparate_Party3_Div" style="display: none;">
                                    <label>Who claims to own this vehicle?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Client_Vehicle_SoleSeparate_Party3_Client" name="Client_Vehicle_SoleSeparate_Party3" value="{{$client_name}}" <?php if(isset($drvehicles->Client_Vehicle_SoleSeparate_Party3) && $drvehicles->Client_Vehicle_SoleSeparate_Party3==$client_name){ echo "checked"; } ?>> {{$client_name}}</label>
                                        <label><input type="radio" id="Client_Vehicle_SoleSeparate_Party3_Op" name="Client_Vehicle_SoleSeparate_Party3" value="{{$opponent_name}}" <?php if(isset($drvehicles->Client_Vehicle_SoleSeparate_Party3) && $drvehicles->Client_Vehicle_SoleSeparate_Party3==$opponent_name){ echo "checked"; } ?>> {{$opponent_name}}</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 Client_Vehicle_Owned3_Div" id="Client_Vehicle_SoleSeparate_Grounds3_Div" style="display: none;">
                                    <label for="Client_Vehicle_SoleSeparate_Grounds3">Why does this person own this vehicle solely and separately?</label>
                                    <input id="Client_Vehicle_SoleSeparate_Grounds3" type="text" class="form-control 3_Client_vehicles_inputs" name="Client_Vehicle_SoleSeparate_Grounds3" value="<?php if(isset($drvehicles->Client_Vehicle_SoleSeparate_Grounds3)){ echo $drvehicles->Client_Vehicle_SoleSeparate_Grounds3; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6 Client_Vehicle_Owned3_Div">
                                    <label>How will this vehicle value be distributed between the parties?</label>
                                    <div class="w-100 dataInput">
                                        <label><input type="radio" id="Client_Vehicle_Disposition_Method3_Liquidate_Split_Net_Value" name="Client_Vehicle_Disposition_Method3" value="Liquidate/Split Net Value" data-onload="getInitialDipositionMethod(this, '3', 'Client');" onchange="getDipositionMethod(this, '3', 'Client');" <?php if(isset($drvehicles->Client_Vehicle_Disposition_Method3) && $drvehicles->Client_Vehicle_Disposition_Method3=='Liquidate/Split Net Value'){ echo "checked"; } ?>> Liquidate/Split Net Value</label>
                                        <label><input type="radio" id="Client_Vehicle_Disposition_Method3_Fixed_Buyout" name="Client_Vehicle_Disposition_Method3" value="Fixed Buyout" data-onload="getInitialDipositionMethod(this, '3', 'Client');" onchange="getDipositionMethod(this, '3', 'Client');" <?php if(isset($drvehicles->Client_Vehicle_Disposition_Method3) && $drvehicles->Client_Vehicle_Disposition_Method3=='Fixed Buyout'){ echo "checked"; } ?>> Fixed Buyout</label>
                                    </div>
                                </div>
                                <!-- slider tool -->
                                <div class="form-group col-sm-6 m-auto 3_Client_Slider_Tool Client_Vehicle_Owned3_Div">
                                    <div class="row">
                                        <div class="col">{{$client_name}}</div>
                                        <div class="col text-right">{{$opponent_name}}</div>
                                    </div>
                                    <input id="3_Client_balance_range_selector" type="range" class="form-control slider-tool-input 3_Client_balance_range_selector" name="" value="<?php if(isset($drvehicles->Client_Vehicle_Percent_Marital_Equity_to_Op3)){ echo $drvehicles->Client_Vehicle_Percent_Marital_Equity_to_Op3; } ?>" min="0.00" step="0.01" max="100" onchange="updateBalanceInput(this.value, '3', 'Client');">
                                </div>
                                <div class="form-group col-sm-6 m-auto 3_Client_Slider_Tool Client_Vehicle_Owned3_Div">
                                    <div class="row justify-content-between">
                                        <div class="col selectorTool">
                                            <div class="left-col">
                                                <div class="client-info 3_Client_clientpercentage_div clientpercentage_div">
                                                    <?php if(isset($drvehicles->Client_Vehicle_Percent_Marital_Equity_to_Client3)){ echo $drvehicles->Client_Vehicle_Percent_Marital_Equity_to_Client3; } else {
                                                        echo '50.00';
                                                    } ?>%
                                                </div>
                                                <div class="client-info 3_Client_clientamount_div clientamount_div" style="clear: both;">
                                                    $<?php if(isset($drvehicles->Client_Vehicle_Estimated_Value_to_Client3)){ echo $drvehicles->Client_Vehicle_Estimated_Value_to_Client3; } else {
                                                        echo '50.00';
                                                    } ?>
                                                </div>
                                            </div>
                                            <label>To {{$client_name}}</label>
                                        </div>                                       
                                        <div class="col selectorTool selectorToolRight">
                                            <label>To {{$opponent_name}}</label>
                                            <div class="left-col right-col">
                                                <div class="client-info 3_Client_opponentpercentage_div opponentpercentage_div">
                                                    <?php if(isset($drvehicles->Client_Vehicle_Percent_Marital_Equity_to_Op3)){ echo $drvehicles->Client_Vehicle_Percent_Marital_Equity_to_Op3; } else {
                                                        echo '50.00';
                                                    } ?>%
                                                </div>
                                                <div class="client-info 3_Client_opponentamount_div opponentamount_div" style="clear: both;">
                                                    $<?php if(isset($drvehicles->Client_Vehicle_Estimated_Value_to_Op3)){ echo $drvehicles->Client_Vehicle_Estimated_Value_to_Op3; } else {
                                                        echo '50.00';
                                                    } ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 m-auto 3_Client_Slider_Tool Client_Vehicle_Owned3_Div">
                                    <label></label>
                                    <div class="w-100">
                                        <label><input type="radio" id="3_Client_Vehicle_Estimated_Value_Select" name="3_Client_Vehicle_Estimated_Value_Select_Reset" class="Vehicle_Estimated_Value_Select_Reset" value="Save"> Save this Distribution of Vehicles #3</label>
                                        <label><input type="radio" id="3_Client_Vehicle_Estimated_Value_Reset" name="3_Client_Vehicle_Estimated_Value_Select_Reset" class="Vehicle_Estimated_Value_Select_Reset" value="Reset" onclick="resetBalanceInput(this, '3', 'Client');"> Reset to Default (50%)</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 Client_Vehicle_Owned3_Div Client_Vehicle_Paying_Party3_Inputs_Div" style="display: none;">
                                    <label>Client Vehicles Paying Party3</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Client_Vehicle_Paying_Party3_Client" name="Client_Vehicle_Paying_Party3" value="{{$client_name}}" data-onload="getInitialVehiclesPayingParty(this, '3', 'Client');" onchange="getVehiclesPayingParty(this, '3', 'Client');" <?php if(isset($drvehicles->Client_Vehicle_Paying_Party3) && $drvehicles->Client_Vehicle_Paying_Party3==$client_name){ echo "checked"; } ?>> {{$client_name}}</label>
                                        <label><input type="radio" id="Client_Vehicle_Paying_Party3_Op" name="Client_Vehicle_Paying_Party3" value="{{$opponent_name}}" data-onload="getInitialVehiclesPayingParty(this, '3', 'Client');" onchange="getVehiclesPayingParty(this, '3', 'Client');" <?php if(isset($drvehicles->Client_Vehicle_Paying_Party3) && $drvehicles->Client_Vehicle_Paying_Party3==$opponent_name){ echo "checked"; } ?>> {{$opponent_name}}</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 Client_Vehicle_Owned3_Div Client_Vehicle_Paying_Party3_Inputs_Div" style="display: none;">
                                    <label>{{$client_name}} Vehicles Equity Percent</label>
                                    <input id="Client_Vehicle_Percent_Marital_Equity_to_Client3" type="number" class="form-control 3_Client_clientpercentage_input clientpercentage_input" name="Client_Vehicle_Percent_Marital_Equity_to_Client3" value="<?php if(isset($drvehicles->Client_Vehicle_Percent_Marital_Equity_to_Client3)){ echo $drvehicles->Client_Vehicle_Percent_Marital_Equity_to_Client3; } ?>" min="0.00" step="0.01" max="100" readonly="">
                                </div>
                                <div class="form-group col-sm-6 Client_Vehicle_Owned3_Div Client_Vehicle_Paying_Party3_Inputs_Div" style="display: none;">
                                    <label>How much is to be paid to {{$client_name}}?</label>
                                    <input id="Client_Vehicle_Estimated_Value_to_Client3" type="number" class="form-control 3_Client_clientamount_input clientamount_input" name="Client_Vehicle_Estimated_Value_to_Client3" value="<?php if(isset($drvehicles->Client_Vehicle_Estimated_Value_to_Client3)){ echo $drvehicles->Client_Vehicle_Estimated_Value_to_Client3; } ?>" min="0.00" step="0.01" max="999999.99" readonly="" onchange="getEstimatedValueClient(this, '3', 'Client');" onkeyup="getEstimatedValueClient(this, '3', 'Client');">
                                </div>
                                <div class="form-group col-sm-6 Client_Vehicle_Owned3_Div Client_Vehicle_Paying_Party3_Inputs_Div" style="display: none;">
                                    <label>{{$opponent_name}} Vehicles Equity Percent</label>
                                    <input id="Client_Vehicle_Percent_Marital_Equity_to_Op3" type="number" class="form-control 3_Client_opponentpercentage_input opponentpercentage_input" name="Client_Vehicle_Percent_Marital_Equity_to_Op3" value="<?php if(isset($drvehicles->Client_Vehicle_Percent_Marital_Equity_to_Op3)){ echo $drvehicles->Client_Vehicle_Percent_Marital_Equity_to_Op3; } ?>" min="0.00" step="0.01" max="100" readonly="">
                                </div>
                                <div class="form-group col-sm-6 Client_Vehicle_Owned3_Div Client_Vehicle_Paying_Party3_Inputs_Div" style="display: none;">
                                    <label>How much is to be paid to {{$opponent_name}}?</label>
                                    <input id="Client_Vehicle_Estimated_Value_to_Op3" type="number" class="form-control 3_Client_opponentamount_input opponentamount_input" name="Client_Vehicle_Estimated_Value_to_Op3" value="<?php if(isset($drvehicles->Client_Vehicle_Estimated_Value_to_Op3)){ echo $drvehicles->Client_Vehicle_Estimated_Value_to_Op3; } ?>" min="0.00" step="0.01" max="999999.99" readonly="" onchange="getEstimatedValueOp(this, '3', 'Client');" onkeyup="getEstimatedValueOp(this, '3', 'Client');">
                                </div>
                                <!-- end of slider tool -->
                                <div class="form-group col-sm-6 Client_Vehicle_Paying_Party3_Leased_Div" style="display: none;">
                                    <label for="Client_Vehicle_Lease_Company3">Name of vehicle lease company?</label>
                                    <input id="Client_Vehicle_Lease_Company3" type="text" class="form-control 3_Client_vehicles_inputs Client_Vehicle_Paying_Party3_Leased_Input" name="Client_Vehicle_Lease_Company3" value="<?php if(isset($drvehicles->Client_Vehicle_Lease_Company3)){ echo $drvehicles->Client_Vehicle_Lease_Company3; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6 Client_Vehicle_Paying_Party3_Leased_Div" style="display: none;">
                                    <label>Monthly lease payment for this vehicle?</label>
                                    <input id="Client_Vehicle_Monthly_Lease_Amount3" type="number" class="form-control 3_Client_vehicles_inputs Client_Vehicle_Paying_Party3_Leased_Input" name="Client_Vehicle_Monthly_Lease_Amount3" value="<?php if(isset($drvehicles->Client_Vehicle_Monthly_Lease_Amount3)){ echo $drvehicles->Client_Vehicle_Monthly_Lease_Amount3; } ?>" min="0.00" step="0.01" max="999999.99">
                                </div>
                                <div class="form-group col-sm-6 Client_Vehicle_Paying_Party3_Leased_Div" style="display: none;">
                                    <label>How will this leased vehicle be handled?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Client_Vehicle_Lease_Disposition_Method3_Terminate_Lease" name="Client_Vehicle_Lease_Disposition_Method3" value="Terminate Lease" <?php if(isset($drvehicles->Client_Vehicle_Lease_Disposition_Method3) && $drvehicles->Client_Vehicle_Lease_Disposition_Method3=='Terminate Lease'){ echo "checked"; } ?>> Terminate Lease</label>
                                        <label><input type="radio" id="Client_Vehicle_Lease_Disposition_Method3_Transfer_Lease_Responsibility_to_ClientName" name="Client_Vehicle_Lease_Disposition_Method3" value="Transfer Lease Responsibility to {{$client_name}}" <?php if(isset($drvehicles->Client_Vehicle_Lease_Disposition_Method3) && $drvehicles->Client_Vehicle_Lease_Disposition_Method3=='Transfer Lease Responsibility to '.$client_name.''){ echo "checked"; } ?>> Transfer Lease Responsibility to {{$client_name}}</label>
                                        <label><input type="radio" id="Client_Vehicle_Lease_Disposition_Method3_Transfer_Lease_Responsibility_to_OpName" name="Client_Vehicle_Lease_Disposition_Method3" value="Transfer Lease Responsibility to {{$opponent_name}}" <?php if(isset($drvehicles->Client_Vehicle_Lease_Disposition_Method3) && $drvehicles->Client_Vehicle_Lease_Disposition_Method3=='Transfer Lease Responsibility to '.$opponent_name.''){ echo "checked"; } ?>> Transfer Lease Responsibility to {{$opponent_name}}</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 mt-4 4_Client_vehicles_section" style="display: none;"><h5 class="col-sm-12">Fourth Vehicle Info</h5>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Vehicle_Year4">Model year of this vehicle?</label>
                                    <select id="Client_Vehicle_Year4" name="Client_Vehicle_Year4" class="form-control 4_Client_vehicles_select">
                                        <?php 
                                            if(isset($drvehicles->Client_Vehicle_Year4)){ 
                                                $already_selected_value = $drvehicles->Client_Vehicle_Year4; 
                                            } else {
                                                $already_selected_value = '';
                                            }
                                            $earliest_year = 1900;
                                            foreach (range(date('Y'), $earliest_year) as $x) {
                                                echo '<option value="'.$x.'"'.($x == $already_selected_value ? ' selected="selected"' : '').'>'.$x.'</option>';
                                            }
                                        ?>
                                    </select>   
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Vehicle_Make_Model4">What make and model is this vehicle?</label>
                                    <input id="Client_Vehicle_Make_Model4" type="text" class="form-control 4_Client_vehicles_inputs" name="Client_Vehicle_Make_Model4" value="<?php if(isset($drvehicles->Client_Vehicle_Make_Model4)){ echo $drvehicles->Client_Vehicle_Make_Model4; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Is this vehicle leased or owned?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Client_Vehicle_Owned_Leased4_Owned" name="Client_Vehicle_Owned_Leased4" value="Owned" data-onload="getInitialVehicleOwnedLeased(this, '4', 'Client');" onchange="getVehicleOwnedLeased(this, '4', 'Client');" <?php if(isset($drvehicles->Client_Vehicle_Owned_Leased4) && $drvehicles->Client_Vehicle_Owned_Leased4=='Owned'){ echo "checked"; } ?>> Owned</label>
                                        <label><input type="radio" id="Client_Vehicle_Owned_Leased4_Leased" name="Client_Vehicle_Owned_Leased4" value="Leased" data-onload="getInitialVehicleOwnedLeased(this, '4', 'Client');" onchange="getVehicleOwnedLeased(this, '4', 'Client');" <?php if(isset($drvehicles->Client_Vehicle_Owned_Leased4) && $drvehicles->Client_Vehicle_Owned_Leased4=='Leased'){ echo "checked"; } ?>> Leased</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 Client_Vehicle_Owned4_Div">
                                    <label for="Client_Vehicle_VIN4">What is the VIN of this vehicle?</label>
                                    <input id="Client_Vehicle_VIN4" type="text" class="form-control 4_Client_vehicles_inputs" name="Client_Vehicle_VIN4" value="<?php if(isset($drvehicles->Client_Vehicle_VIN4)){ echo $drvehicles->Client_Vehicle_VIN4; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6 Client_Vehicle_Owned4_Div">
                                    <label for="Client_Vehicle_Current_Value4">What is the current value of this vehicle?</label>
                                    <input id="Client_Vehicle_Current_Value4" type="number" class="form-control 4_Client_vehicles_inputs" name="Client_Vehicle_Current_Value4" value="<?php if(isset($drvehicles->Client_Vehicle_Current_Value4)){ echo $drvehicles->Client_Vehicle_Current_Value4; } ?>" min="0.00" step="0.01" max="999999.99" onchange="getCurrentValue(this, '4', 'Client');" onkeyup="getCurrentValue(this, '4', 'Client');">
                                </div>
                                <div class="form-group col-sm-6 Client_Vehicle_Owned4_Div">
                                    <label for="Client_Vehicle_Loan_Company_Name4">Name of first car loan company?</label>
                                    <input id="Client_Vehicle_Loan_Company_Name4" type="text" class="form-control 4_Client_vehicles_inputs" name="Client_Vehicle_Loan_Company_Name4" value="<?php if(isset($drvehicles->Client_Vehicle_Loan_Company_Name4)){ echo $drvehicles->Client_Vehicle_Loan_Company_Name4; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6 Client_Vehicle_Owned4_Div">
                                    <label for="Client_Vehicle_Loan_Balance4">Balance due to first car loan company for this vehicle?</label>
                                    <input id="Client_Vehicle_Loan_Balance4" type="number" class="form-control 4_Client_vehicles_inputs" name="Client_Vehicle_Loan_Balance4" value="<?php if(isset($drvehicles->Client_Vehicle_Loan_Balance4)){ echo $drvehicles->Client_Vehicle_Loan_Balance4; } ?>" min="0.00" step="0.01" max="999999.99" onchange="getLoanBalance(this, '4', 'Client');" onkeyup="getLoanBalance(this, '4', 'Client');">
                                </div>
                                <div class="form-group col-sm-6 Client_Vehicle_Owned4_Div">
                                    <label for="Client_Vehicle_Loan_Monthly_Payment4">Monthly payment to first car loan company for this vehicle?</label>
                                    <input id="Client_Vehicle_Loan_Monthly_Payment4" type="number" class="form-control 4_Client_vehicles_inputs" name="Client_Vehicle_Loan_Monthly_Payment4" value="<?php if(isset($drvehicles->Client_Vehicle_Loan_Monthly_Payment4)){ echo $drvehicles->Client_Vehicle_Loan_Monthly_Payment4; } ?>" min="0.00" step="0.01" max="999999.99">
                                </div>
                                <div class="form-group col-sm-6 Client_Vehicle_Owned4_Div">
                                    <label for="Client_Vehicle_Loan_Second_Company_Name4">Name of second car loan company?</label>
                                    <input id="Client_Vehicle_Loan_Second_Company_Name4" type="text" class="form-control 4_Client_vehicles_inputs" name="Client_Vehicle_Loan_Second_Company_Name4" value="<?php if(isset($drvehicles->Client_Vehicle_Loan_Second_Company_Name4)){ echo $drvehicles->Client_Vehicle_Loan_Second_Company_Name4; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6 Client_Vehicle_Owned4_Div">
                                    <label for="Client_Vehicle_Loan_Second_Company_Balance4">Balance due to second car loan company for this vehicle?</label>
                                    <input id="Client_Vehicle_Loan_Second_Company_Balance4" type="number" class="form-control 4_Client_vehicles_inputs" name="Client_Vehicle_Loan_Second_Company_Balance4" value="<?php if(isset($drvehicles->Client_Vehicle_Loan_Second_Company_Balance4)){ echo $drvehicles->Client_Vehicle_Loan_Second_Company_Balance4; } ?>" min="0.00" step="0.01" max="999999.99" onchange="getCompanyBalance(this, '4', 'Client');" onkeyup="getCompanyBalance(this, '4', 'Client');">
                                </div>
                                <div class="form-group col-sm-6 Client_Vehicle_Owned4_Div">
                                    <label for="Client_Vehicle_Loan_Second_Company_Monthly_Payment4">Monthly payment to second car loan company for this vehicle?</label>
                                    <input id="Client_Vehicle_Loan_Second_Company_Monthly_Payment4" type="number" class="form-control 4_Client_vehicles_inputs" name="Client_Vehicle_Loan_Second_Company_Monthly_Payment4" value="<?php if(isset($drvehicles->Client_Vehicle_Loan_Second_Company_Monthly_Payment4)){ echo $drvehicles->Client_Vehicle_Loan_Second_Company_Monthly_Payment4; } ?>" min="0.00" step="0.01" max="999999.99">
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label for="Client_Vehicle_Marital_Equity4">N/A, calculated = Client_Vehicle_Current_Value4-Client_Vehicle_Loan_Balance4-Client_Vehicle_Loan_Second_Company_Balance4</label>
                                    <input id="Client_Vehicle_Marital_Equity4" type="number" class="form-control 4_Client_vehicles_inputs" name="Client_Vehicle_Marital_Equity4" value="<?php if(isset($drvehicles->Client_Vehicle_Marital_Equity4)){ echo $drvehicles->Client_Vehicle_Marital_Equity4; } ?>" min="0.00" step="0.01" max="999999.99">
                                </div>
                                <div class="form-group col-sm-6 Client_Vehicle_Owned4_Div">
                                    <label>Does either party claim a sole/separate interest in this vehicle?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Client_Vehicle_SoleSeparate_Claim4_Yes" name="Client_Vehicle_SoleSeparate_Claim4" value="Yes" data-onload="getInitialPartyClaimSoleSeparate(this, '4', 'Client');" onchange="getPartyClaimSoleSeparate(this, '4', 'Client');" <?php if(isset($drvehicles->Client_Vehicle_SoleSeparate_Claim4) && $drvehicles->Client_Vehicle_SoleSeparate_Claim4=='Yes'){ echo "checked"; } ?>> Yes</label>
                                        <label><input type="radio" id="Client_Vehicle_SoleSeparate_Claim4_No" name="Client_Vehicle_SoleSeparate_Claim4" value="No" data-onload="getInitialPartyClaimSoleSeparate(this, '4', 'Client');" onchange="getPartyClaimSoleSeparate(this, '4', 'Client');" <?php if(isset($drvehicles->Client_Vehicle_SoleSeparate_Claim4) && $drvehicles->Client_Vehicle_SoleSeparate_Claim4=='No'){ echo "checked"; } ?>> No</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 Client_Vehicle_Owned4_Div" id="Client_Vehicle_SoleSeparate_Party4_Div" style="display: none;">
                                    <label>Who claims to own this vehicle?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Client_Vehicle_SoleSeparate_Party4_Client" name="Client_Vehicle_SoleSeparate_Party4" value="{{$client_name}}" <?php if(isset($drvehicles->Client_Vehicle_SoleSeparate_Party4) && $drvehicles->Client_Vehicle_SoleSeparate_Party4==$client_name){ echo "checked"; } ?>> {{$client_name}}</label>
                                        <label><input type="radio" id="Client_Vehicle_SoleSeparate_Party4_Op" name="Client_Vehicle_SoleSeparate_Party4" value="{{$opponent_name}}" <?php if(isset($drvehicles->Client_Vehicle_SoleSeparate_Party4) && $drvehicles->Client_Vehicle_SoleSeparate_Party4==$opponent_name){ echo "checked"; } ?>> {{$opponent_name}}</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 Client_Vehicle_Owned4_Div" id="Client_Vehicle_SoleSeparate_Grounds4_Div" style="display: none;">
                                    <label for="Client_Vehicle_SoleSeparate_Grounds4">Why does this person own this vehicle solely and separately?</label>
                                    <input id="Client_Vehicle_SoleSeparate_Grounds4" type="text" class="form-control 4_Client_vehicles_inputs" name="Client_Vehicle_SoleSeparate_Grounds4" value="<?php if(isset($drvehicles->Client_Vehicle_SoleSeparate_Grounds4)){ echo $drvehicles->Client_Vehicle_SoleSeparate_Grounds4; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6 Client_Vehicle_Owned4_Div">
                                    <label>How will this vehicle value be distributed between the parties?</label>
                                    <div class="w-100 dataInput">
                                        <label><input type="radio" id="Client_Vehicle_Disposition_Method4_Liquidate_Split_Net_Value" name="Client_Vehicle_Disposition_Method4" value="Liquidate/Split Net Value" data-onload="getInitialDipositionMethod(this, '4', 'Client');" onchange="getDipositionMethod(this, '4', 'Client');" <?php if(isset($drvehicles->Client_Vehicle_Disposition_Method4) && $drvehicles->Client_Vehicle_Disposition_Method4=='Liquidate/Split Net Value'){ echo "checked"; } ?>> Liquidate/Split Net Value</label>
                                        <label><input type="radio" id="Client_Vehicle_Disposition_Method4_Fixed_Buyout" name="Client_Vehicle_Disposition_Method4" value="Fixed Buyout" data-onload="getInitialDipositionMethod(this, '4', 'Client');" onchange="getDipositionMethod(this, '4', 'Client');" <?php if(isset($drvehicles->Client_Vehicle_Disposition_Method4) && $drvehicles->Client_Vehicle_Disposition_Method4=='Fixed Buyout'){ echo "checked"; } ?>> Fixed Buyout</label>
                                    </div>
                                </div>
                                <!-- slider tool -->
                                <div class="form-group col-sm-6 m-auto 4_Client_Slider_Tool Client_Vehicle_Owned4_Div">
                                    <div class="row">
                                        <div class="col">{{$client_name}}</div>
                                        <div class="col text-right">{{$opponent_name}}</div>
                                    </div>
                                    <input id="4_Client_balance_range_selector" type="range" class="form-control slider-tool-input 4_Client_balance_range_selector" name="" value="<?php if(isset($drvehicles->Client_Vehicle_Percent_Marital_Equity_to_Op4)){ echo $drvehicles->Client_Vehicle_Percent_Marital_Equity_to_Op4; } ?>" min="0.00" step="0.01" max="100" onchange="updateBalanceInput(this.value, '4', 'Client');">
                                </div>
                                <div class="form-group col-sm-6 m-auto 4_Client_Slider_Tool Client_Vehicle_Owned4_Div">
                                    <div class="row justify-content-between">
                                        <div class="col selectorTool">
                                            <div class="left-col">
                                                <div class="client-info 4_Client_clientpercentage_div clientpercentage_div">
                                                    <?php if(isset($drvehicles->Client_Vehicle_Percent_Marital_Equity_to_Client4)){ echo $drvehicles->Client_Vehicle_Percent_Marital_Equity_to_Client4; } else {
                                                        echo '50.00';
                                                    } ?>%
                                                </div>
                                                <div class="client-info 4_Client_clientamount_div clientamount_div" style="clear: both;">
                                                    $<?php if(isset($drvehicles->Client_Vehicle_Estimated_Value_to_Client4)){ echo $drvehicles->Client_Vehicle_Estimated_Value_to_Client4; } else {
                                                        echo '50.00';
                                                    } ?>
                                                </div>
                                            </div>
                                            <label>To {{$client_name}}</label>
                                        </div>                                       
                                        <div class="col selectorTool selectorToolRight">
                                            <label>To {{$opponent_name}}</label>
                                            <div class="left-col right-col">
                                                <div class="client-info 4_Client_opponentpercentage_div opponentpercentage_div">
                                                    <?php if(isset($drvehicles->Client_Vehicle_Percent_Marital_Equity_to_Op4)){ echo $drvehicles->Client_Vehicle_Percent_Marital_Equity_to_Op4; } else {
                                                        echo '50.00';
                                                    } ?>%
                                                </div>
                                                <div class="client-info 4_Client_opponentamount_div opponentamount_div" style="clear: both;">
                                                    $<?php if(isset($drvehicles->Client_Vehicle_Estimated_Value_to_Op4)){ echo $drvehicles->Client_Vehicle_Estimated_Value_to_Op4; } else {
                                                        echo '50.00';
                                                    } ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 m-auto 4_Client_Slider_Tool Client_Vehicle_Owned4_Div">
                                    <label></label>
                                    <div class="w-100">
                                        <label><input type="radio" id="4_Client_Vehicle_Estimated_Value_Select" name="4_Client_Vehicle_Estimated_Value_Select_Reset" class="Vehicle_Estimated_Value_Select_Reset" value="Save"> Save this Distribution of Vehicles #4</label>
                                        <label><input type="radio" id="4_Client_Vehicle_Estimated_Value_Reset" name="4_Client_Vehicle_Estimated_Value_Select_Reset" class="Vehicle_Estimated_Value_Select_Reset" value="Reset" onclick="resetBalanceInput(this, '4', 'Client');"> Reset to Default (50%)</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 Client_Vehicle_Owned4_Div Client_Vehicle_Paying_Party4_Inputs_Div" style="display: none;">
                                    <label>Client Vehicles Paying Party4</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Client_Vehicle_Paying_Party4_Client" name="Client_Vehicle_Paying_Party4" value="{{$client_name}}" data-onload="getInitialVehiclesPayingParty(this, '4', 'Client');" onchange="getVehiclesPayingParty(this, '4', 'Client');" <?php if(isset($drvehicles->Client_Vehicle_Paying_Party4) && $drvehicles->Client_Vehicle_Paying_Party4==$client_name){ echo "checked"; } ?>> {{$client_name}}</label>
                                        <label><input type="radio" id="Client_Vehicle_Paying_Party4_Op" name="Client_Vehicle_Paying_Party4" value="{{$opponent_name}}" data-onload="getInitialVehiclesPayingParty(this, '4', 'Client');" onchange="getVehiclesPayingParty(this, '4', 'Client');" <?php if(isset($drvehicles->Client_Vehicle_Paying_Party4) && $drvehicles->Client_Vehicle_Paying_Party4==$opponent_name){ echo "checked"; } ?>> {{$opponent_name}}</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 Client_Vehicle_Owned4_Div Client_Vehicle_Paying_Party4_Inputs_Div" style="display: none;">
                                    <label>{{$client_name}} Vehicles Equity Percent</label>
                                    <input id="Client_Vehicle_Percent_Marital_Equity_to_Client4" type="number" class="form-control 4_Client_clientpercentage_input clientpercentage_input" name="Client_Vehicle_Percent_Marital_Equity_to_Client4" value="<?php if(isset($drvehicles->Client_Vehicle_Percent_Marital_Equity_to_Client4)){ echo $drvehicles->Client_Vehicle_Percent_Marital_Equity_to_Client4; } ?>" min="0.00" step="0.01" max="100" readonly="">
                                </div>
                                <div class="form-group col-sm-6 Client_Vehicle_Owned4_Div Client_Vehicle_Paying_Party4_Inputs_Div" style="display: none;">
                                    <label>How much is to be paid to {{$client_name}}?</label>
                                    <input id="Client_Vehicle_Estimated_Value_to_Client4" type="number" class="form-control 4_Client_clientamount_input clientamount_input" name="Client_Vehicle_Estimated_Value_to_Client4" value="<?php if(isset($drvehicles->Client_Vehicle_Estimated_Value_to_Client4)){ echo $drvehicles->Client_Vehicle_Estimated_Value_to_Client4; } ?>" min="0.00" step="0.01" max="999999.99" readonly="" onchange="getEstimatedValueClient(this, '4', 'Client');" onkeyup="getEstimatedValueClient(this, '4', 'Client');">
                                </div>
                                <div class="form-group col-sm-6 Client_Vehicle_Owned4_Div Client_Vehicle_Paying_Party4_Inputs_Div" style="display: none;">
                                    <label>{{$opponent_name}} Vehicles Equity Percent</label>
                                    <input id="Client_Vehicle_Percent_Marital_Equity_to_Op4" type="number" class="form-control 4_Client_opponentpercentage_input opponentpercentage_input" name="Client_Vehicle_Percent_Marital_Equity_to_Op4" value="<?php if(isset($drvehicles->Client_Vehicle_Percent_Marital_Equity_to_Op4)){ echo $drvehicles->Client_Vehicle_Percent_Marital_Equity_to_Op4; } ?>" min="0.00" step="0.01" max="100" readonly="">
                                </div>
                                <div class="form-group col-sm-6 Client_Vehicle_Owned4_Div Client_Vehicle_Paying_Party4_Inputs_Div" style="display: none;">
                                    <label>How much is to be paid to {{$opponent_name}}?</label>
                                    <input id="Client_Vehicle_Estimated_Value_to_Op4" type="number" class="form-control 4_Client_opponentamount_input opponentamount_input" name="Client_Vehicle_Estimated_Value_to_Op4" value="<?php if(isset($drvehicles->Client_Vehicle_Estimated_Value_to_Op4)){ echo $drvehicles->Client_Vehicle_Estimated_Value_to_Op4; } ?>" min="0.00" step="0.01" max="999999.99" readonly="" onchange="getEstimatedValueOp(this, '4', 'Client');" onkeyup="getEstimatedValueOp(this, '4', 'Client');">
                                </div>
                                <!-- end of slider tool -->
                                <div class="form-group col-sm-6 Client_Vehicle_Paying_Party4_Leased_Div" style="display: none;">
                                    <label for="Client_Vehicle_Lease_Company4">Name of vehicle lease company?</label>
                                    <input id="Client_Vehicle_Lease_Company4" type="text" class="form-control 4_Client_vehicles_inputs Client_Vehicle_Paying_Party4_Leased_Input" name="Client_Vehicle_Lease_Company4" value="<?php if(isset($drvehicles->Client_Vehicle_Lease_Company4)){ echo $drvehicles->Client_Vehicle_Lease_Company4; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6 Client_Vehicle_Paying_Party4_Leased_Div" style="display: none;">
                                    <label>Monthly lease payment for this vehicle?</label>
                                    <input id="Client_Vehicle_Monthly_Lease_Amount4" type="number" class="form-control 4_Client_vehicles_inputs Client_Vehicle_Paying_Party4_Leased_Input" name="Client_Vehicle_Monthly_Lease_Amount4" value="<?php if(isset($drvehicles->Client_Vehicle_Monthly_Lease_Amount4)){ echo $drvehicles->Client_Vehicle_Monthly_Lease_Amount4; } ?>" min="0.00" step="0.01" max="999999.99">
                                </div>
                                <div class="form-group col-sm-6 Client_Vehicle_Paying_Party4_Leased_Div" style="display: none;">
                                    <label>How will this leased vehicle be handled?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Client_Vehicle_Lease_Disposition_Method4_Terminate_Lease" name="Client_Vehicle_Lease_Disposition_Method4" value="Terminate Lease" <?php if(isset($drvehicles->Client_Vehicle_Lease_Disposition_Method4) && $drvehicles->Client_Vehicle_Lease_Disposition_Method4=='Terminate Lease'){ echo "checked"; } ?>> Terminate Lease</label>
                                        <label><input type="radio" id="Client_Vehicle_Lease_Disposition_Method4_Transfer_Lease_Responsibility_to_ClientName" name="Client_Vehicle_Lease_Disposition_Method4" value="Transfer Lease Responsibility to {{$client_name}}" <?php if(isset($drvehicles->Client_Vehicle_Lease_Disposition_Method4) && $drvehicles->Client_Vehicle_Lease_Disposition_Method4=='Transfer Lease Responsibility to '.$client_name.''){ echo "checked"; } ?>> Transfer Lease Responsibility to {{$client_name}}</label>
                                        <label><input type="radio" id="Client_Vehicle_Lease_Disposition_Method4_Transfer_Lease_Responsibility_to_OpName" name="Client_Vehicle_Lease_Disposition_Method4" value="Transfer Lease Responsibility to {{$opponent_name}}" <?php if(isset($drvehicles->Client_Vehicle_Lease_Disposition_Method4) && $drvehicles->Client_Vehicle_Lease_Disposition_Method4=='Transfer Lease Responsibility to '.$opponent_name.''){ echo "checked"; } ?>> Transfer Lease Responsibility to {{$opponent_name}}</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 mt-4 5_Client_vehicles_section" style="display: none;"><h5 class="col-sm-12">Fifth Vehicle Info</h5>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Vehicle_Year5">Model year of this vehicle?</label>
                                    <select id="Client_Vehicle_Year5" name="Client_Vehicle_Year5" class="form-control 5_Client_vehicles_select">
                                        <?php 
                                            if(isset($drvehicles->Client_Vehicle_Year5)){ 
                                                $already_selected_value = $drvehicles->Client_Vehicle_Year5; 
                                            } else {
                                                $already_selected_value = '';
                                            }
                                            $earliest_year = 1900;
                                            foreach (range(date('Y'), $earliest_year) as $x) {
                                                echo '<option value="'.$x.'"'.($x == $already_selected_value ? ' selected="selected"' : '').'>'.$x.'</option>';
                                            }
                                        ?>
                                    </select>   
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Vehicle_Make_Model5">What make and model is this vehicle?</label>
                                    <input id="Client_Vehicle_Make_Model5" type="text" class="form-control 5_Client_vehicles_inputs" name="Client_Vehicle_Make_Model5" value="<?php if(isset($drvehicles->Client_Vehicle_Make_Model5)){ echo $drvehicles->Client_Vehicle_Make_Model5; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Is this vehicle leased or owned?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Client_Vehicle_Owned_Leased5_Owned" name="Client_Vehicle_Owned_Leased5" value="Owned" data-onload="getInitialVehicleOwnedLeased(this, '5', 'Client');" onchange="getVehicleOwnedLeased(this, '5', 'Client');" <?php if(isset($drvehicles->Client_Vehicle_Owned_Leased5) && $drvehicles->Client_Vehicle_Owned_Leased5=='Owned'){ echo "checked"; } ?>> Owned</label>
                                        <label><input type="radio" id="Client_Vehicle_Owned_Leased5_Leased" name="Client_Vehicle_Owned_Leased5" value="Leased" data-onload="getInitialVehicleOwnedLeased(this, '5', 'Client');" onchange="getVehicleOwnedLeased(this, '5', 'Client');" <?php if(isset($drvehicles->Client_Vehicle_Owned_Leased5) && $drvehicles->Client_Vehicle_Owned_Leased5=='Leased'){ echo "checked"; } ?>> Leased</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 Client_Vehicle_Owned5_Div">
                                    <label for="Client_Vehicle_VIN5">What is the VIN of this vehicle?</label>
                                    <input id="Client_Vehicle_VIN5" type="text" class="form-control 5_Client_vehicles_inputs" name="Client_Vehicle_VIN5" value="<?php if(isset($drvehicles->Client_Vehicle_VIN5)){ echo $drvehicles->Client_Vehicle_VIN5; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6 Client_Vehicle_Owned5_Div">
                                    <label for="Client_Vehicle_Current_Value5">What is the current value of this vehicle?</label>
                                    <input id="Client_Vehicle_Current_Value5" type="number" class="form-control 5_Client_vehicles_inputs" name="Client_Vehicle_Current_Value5" value="<?php if(isset($drvehicles->Client_Vehicle_Current_Value5)){ echo $drvehicles->Client_Vehicle_Current_Value5; } ?>" min="0.00" step="0.01" max="999999.99" onchange="getCurrentValue(this, '5', 'Client');" onkeyup="getCurrentValue(this, '5', 'Client');">
                                </div>
                                <div class="form-group col-sm-6 Client_Vehicle_Owned5_Div">
                                    <label for="Client_Vehicle_Loan_Company_Name5">Name of first car loan company?</label>
                                    <input id="Client_Vehicle_Loan_Company_Name5" type="text" class="form-control 5_Client_vehicles_inputs" name="Client_Vehicle_Loan_Company_Name5" value="<?php if(isset($drvehicles->Client_Vehicle_Loan_Company_Name5)){ echo $drvehicles->Client_Vehicle_Loan_Company_Name5; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6 Client_Vehicle_Owned5_Div">
                                    <label for="Client_Vehicle_Loan_Balance5">Balance due to first car loan company for this vehicle?</label>
                                    <input id="Client_Vehicle_Loan_Balance5" type="number" class="form-control 5_Client_vehicles_inputs" name="Client_Vehicle_Loan_Balance5" value="<?php if(isset($drvehicles->Client_Vehicle_Loan_Balance5)){ echo $drvehicles->Client_Vehicle_Loan_Balance5; } ?>" min="0.00" step="0.01" max="999999.99" onchange="getLoanBalance(this, '5', 'Client');" onkeyup="getLoanBalance(this, '5', 'Client');">
                                </div>
                                <div class="form-group col-sm-6 Client_Vehicle_Owned5_Div">
                                    <label for="Client_Vehicle_Loan_Monthly_Payment5">Monthly payment to first car loan company for this vehicle?</label>
                                    <input id="Client_Vehicle_Loan_Monthly_Payment5" type="number" class="form-control 5_Client_vehicles_inputs" name="Client_Vehicle_Loan_Monthly_Payment5" value="<?php if(isset($drvehicles->Client_Vehicle_Loan_Monthly_Payment5)){ echo $drvehicles->Client_Vehicle_Loan_Monthly_Payment5; } ?>" min="0.00" step="0.01" max="999999.99">
                                </div>
                                <div class="form-group col-sm-6 Client_Vehicle_Owned5_Div">
                                    <label for="Client_Vehicle_Loan_Second_Company_Name5">Name of second car loan company?</label>
                                    <input id="Client_Vehicle_Loan_Second_Company_Name5" type="text" class="form-control 5_Client_vehicles_inputs" name="Client_Vehicle_Loan_Second_Company_Name5" value="<?php if(isset($drvehicles->Client_Vehicle_Loan_Second_Company_Name5)){ echo $drvehicles->Client_Vehicle_Loan_Second_Company_Name5; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6 Client_Vehicle_Owned5_Div">
                                    <label for="Client_Vehicle_Loan_Second_Company_Balance5">Balance due to second car loan company for this vehicle?</label>
                                    <input id="Client_Vehicle_Loan_Second_Company_Balance5" type="number" class="form-control 5_Client_vehicles_inputs" name="Client_Vehicle_Loan_Second_Company_Balance5" value="<?php if(isset($drvehicles->Client_Vehicle_Loan_Second_Company_Balance5)){ echo $drvehicles->Client_Vehicle_Loan_Second_Company_Balance5; } ?>" min="0.00" step="0.01" max="999999.99" onchange="getCompanyBalance(this, '5', 'Client');" onkeyup="getCompanyBalance(this, '5', 'Client');">
                                </div>
                                <div class="form-group col-sm-6 Client_Vehicle_Owned5_Div">
                                    <label for="Client_Vehicle_Loan_Second_Company_Monthly_Payment5">Monthly payment to second car loan company for this vehicle?</label>
                                    <input id="Client_Vehicle_Loan_Second_Company_Monthly_Payment5" type="number" class="form-control 5_Client_vehicles_inputs" name="Client_Vehicle_Loan_Second_Company_Monthly_Payment5" value="<?php if(isset($drvehicles->Client_Vehicle_Loan_Second_Company_Monthly_Payment5)){ echo $drvehicles->Client_Vehicle_Loan_Second_Company_Monthly_Payment5; } ?>" min="0.00" step="0.01" max="999999.99">
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label for="Client_Vehicle_Marital_Equity5">N/A, calculated = Client_Vehicle_Current_Value5-Client_Vehicle_Loan_Balance5-Client_Vehicle_Loan_Second_Company_Balance5</label>
                                    <input id="Client_Vehicle_Marital_Equity5" type="number" class="form-control 5_Client_vehicles_inputs" name="Client_Vehicle_Marital_Equity5" value="<?php if(isset($drvehicles->Client_Vehicle_Marital_Equity5)){ echo $drvehicles->Client_Vehicle_Marital_Equity5; } ?>" min="0.00" step="0.01" max="999999.99">
                                </div>
                                <div class="form-group col-sm-6 Client_Vehicle_Owned5_Div">
                                    <label>Does either party claim a sole/separate interest in this vehicle?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Client_Vehicle_SoleSeparate_Claim5_Yes" name="Client_Vehicle_SoleSeparate_Claim5" value="Yes" data-onload="getInitialPartyClaimSoleSeparate(this, '5', 'Client');" onchange="getPartyClaimSoleSeparate(this, '5', 'Client');" <?php if(isset($drvehicles->Client_Vehicle_SoleSeparate_Claim5) && $drvehicles->Client_Vehicle_SoleSeparate_Claim5=='Yes'){ echo "checked"; } ?>> Yes</label>
                                        <label><input type="radio" id="Client_Vehicle_SoleSeparate_Claim5_No" name="Client_Vehicle_SoleSeparate_Claim5" value="No" data-onload="getInitialPartyClaimSoleSeparate(this, '5', 'Client');" onchange="getPartyClaimSoleSeparate(this, '5', 'Client');" <?php if(isset($drvehicles->Client_Vehicle_SoleSeparate_Claim5) && $drvehicles->Client_Vehicle_SoleSeparate_Claim5=='No'){ echo "checked"; } ?>> No</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 Client_Vehicle_Owned5_Div" id="Client_Vehicle_SoleSeparate_Party5_Div" style="display: none;">
                                    <label>Who claims to own this vehicle?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Client_Vehicle_SoleSeparate_Party5_Client" name="Client_Vehicle_SoleSeparate_Party5" value="{{$client_name}}" <?php if(isset($drvehicles->Client_Vehicle_SoleSeparate_Party5) && $drvehicles->Client_Vehicle_SoleSeparate_Party5==$client_name){ echo "checked"; } ?>> {{$client_name}}</label>
                                        <label><input type="radio" id="Client_Vehicle_SoleSeparate_Party5_Op" name="Client_Vehicle_SoleSeparate_Party5" value="{{$opponent_name}}" <?php if(isset($drvehicles->Client_Vehicle_SoleSeparate_Party5) && $drvehicles->Client_Vehicle_SoleSeparate_Party5==$opponent_name){ echo "checked"; } ?>> {{$opponent_name}}</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 Client_Vehicle_Owned5_Div" id="Client_Vehicle_SoleSeparate_Grounds5_Div" style="display: none;">
                                    <label for="Client_Vehicle_SoleSeparate_Grounds5">Why does this person own this vehicle solely and separately?</label>
                                    <input id="Client_Vehicle_SoleSeparate_Grounds5" type="text" class="form-control 5_Client_vehicles_inputs" name="Client_Vehicle_SoleSeparate_Grounds5" value="<?php if(isset($drvehicles->Client_Vehicle_SoleSeparate_Grounds5)){ echo $drvehicles->Client_Vehicle_SoleSeparate_Grounds5; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6 Client_Vehicle_Owned5_Div">
                                    <label>How will this vehicle value be distributed between the parties?</label>
                                    <div class="w-100 dataInput">
                                        <label><input type="radio" id="Client_Vehicle_Disposition_Method5_Liquidate_Split_Net_Value" name="Client_Vehicle_Disposition_Method5" value="Liquidate/Split Net Value" data-onload="getInitialDipositionMethod(this, '5', 'Client');" onchange="getDipositionMethod(this, '5', 'Client');" <?php if(isset($drvehicles->Client_Vehicle_Disposition_Method5) && $drvehicles->Client_Vehicle_Disposition_Method5=='Liquidate/Split Net Value'){ echo "checked"; } ?>> Liquidate/Split Net Value</label>
                                        <label><input type="radio" id="Client_Vehicle_Disposition_Method5_Fixed_Buyout" name="Client_Vehicle_Disposition_Method5" value="Fixed Buyout" data-onload="getInitialDipositionMethod(this, '5', 'Client');" onchange="getDipositionMethod(this, '5', 'Client');" <?php if(isset($drvehicles->Client_Vehicle_Disposition_Method5) && $drvehicles->Client_Vehicle_Disposition_Method5=='Fixed Buyout'){ echo "checked"; } ?>> Fixed Buyout</label>
                                    </div>
                                </div>
                                <!-- slider tool -->
                                <div class="form-group col-sm-6 m-auto 5_Client_Slider_Tool Client_Vehicle_Owned5_Div">
                                    <div class="row">
                                        <div class="col">{{$client_name}}</div>
                                        <div class="col text-right">{{$opponent_name}}</div>
                                    </div>
                                    <input id="5_Client_balance_range_selector" type="range" class="form-control slider-tool-input 5_Client_balance_range_selector" name="" value="<?php if(isset($drvehicles->Client_Vehicle_Percent_Marital_Equity_to_Op5)){ echo $drvehicles->Client_Vehicle_Percent_Marital_Equity_to_Op5; } ?>" min="0.00" step="0.01" max="100" onchange="updateBalanceInput(this.value, '5', 'Client');">
                                </div>
                                <div class="form-group col-sm-6 m-auto 5_Client_Slider_Tool Client_Vehicle_Owned5_Div">
                                    <div class="row justify-content-between">
                                        <div class="col selectorTool">
                                            <div class="left-col">
                                                <div class="client-info 5_Client_clientpercentage_div clientpercentage_div">
                                                    <?php if(isset($drvehicles->Client_Vehicle_Percent_Marital_Equity_to_Client5)){ echo $drvehicles->Client_Vehicle_Percent_Marital_Equity_to_Client5; } else {
                                                        echo '50.00';
                                                    } ?>%
                                                </div>
                                                <div class="client-info 5_Client_clientamount_div clientamount_div" style="clear: both;">
                                                    $<?php if(isset($drvehicles->Client_Vehicle_Estimated_Value_to_Client5)){ echo $drvehicles->Client_Vehicle_Estimated_Value_to_Client5; } else {
                                                        echo '50.00';
                                                    } ?>
                                                </div>
                                            </div>
                                            <label>To {{$client_name}}</label>
                                        </div>                                       
                                        <div class="col selectorTool selectorToolRight">
                                            <label>To {{$opponent_name}}</label>
                                            <div class="left-col right-col">
                                                <div class="client-info 5_Client_opponentpercentage_div opponentpercentage_div">
                                                    <?php if(isset($drvehicles->Client_Vehicle_Percent_Marital_Equity_to_Op5)){ echo $drvehicles->Client_Vehicle_Percent_Marital_Equity_to_Op5; } else {
                                                        echo '50.00';
                                                    } ?>%
                                                </div>
                                                <div class="client-info 5_Client_opponentamount_div opponentamount_div" style="clear: both;">
                                                    $<?php if(isset($drvehicles->Client_Vehicle_Estimated_Value_to_Op5)){ echo $drvehicles->Client_Vehicle_Estimated_Value_to_Op5; } else {
                                                        echo '50.00';
                                                    } ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 m-auto 5_Client_Slider_Tool Client_Vehicle_Owned5_Div">
                                    <label></label>
                                    <div class="w-100">
                                        <label><input type="radio" id="5_Client_Vehicle_Estimated_Value_Select" name="5_Client_Vehicle_Estimated_Value_Select_Reset" class="Vehicle_Estimated_Value_Select_Reset" value="Save"> Save this Distribution of Vehicles #5</label>
                                        <label><input type="radio" id="5_Client_Vehicle_Estimated_Value_Reset" name="5_Client_Vehicle_Estimated_Value_Select_Reset" class="Vehicle_Estimated_Value_Select_Reset" value="Reset" onclick="resetBalanceInput(this, '5', 'Client');"> Reset to Default (50%)</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 Client_Vehicle_Owned5_Div Client_Vehicle_Paying_Party5_Inputs_Div" style="display: none;">
                                    <label>Client Vehicles Paying Party5</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Client_Vehicle_Paying_Party5_Client" name="Client_Vehicle_Paying_Party5" value="{{$client_name}}" data-onload="getInitialVehiclesPayingParty(this, '5', 'Client');" onchange="getVehiclesPayingParty(this, '5', 'Client');" <?php if(isset($drvehicles->Client_Vehicle_Paying_Party5) && $drvehicles->Client_Vehicle_Paying_Party5==$client_name){ echo "checked"; } ?>> {{$client_name}}</label>
                                        <label><input type="radio" id="Client_Vehicle_Paying_Party5_Op" name="Client_Vehicle_Paying_Party5" value="{{$opponent_name}}" data-onload="getInitialVehiclesPayingParty(this, '5', 'Client');" onchange="getVehiclesPayingParty(this, '5', 'Client');" <?php if(isset($drvehicles->Client_Vehicle_Paying_Party5) && $drvehicles->Client_Vehicle_Paying_Party5==$opponent_name){ echo "checked"; } ?>> {{$opponent_name}}</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 Client_Vehicle_Owned5_Div Client_Vehicle_Paying_Party5_Inputs_Div" style="display: none;">
                                    <label>{{$client_name}} Vehicles Equity Percent</label>
                                    <input id="Client_Vehicle_Percent_Marital_Equity_to_Client5" type="number" class="form-control 5_Client_clientpercentage_input clientpercentage_input" name="Client_Vehicle_Percent_Marital_Equity_to_Client5" value="<?php if(isset($drvehicles->Client_Vehicle_Percent_Marital_Equity_to_Client5)){ echo $drvehicles->Client_Vehicle_Percent_Marital_Equity_to_Client5; } ?>" min="0.00" step="0.01" max="100" readonly="">
                                </div>
                                <div class="form-group col-sm-6 Client_Vehicle_Owned5_Div Client_Vehicle_Paying_Party5_Inputs_Div" style="display: none;">
                                    <label>How much is to be paid to {{$client_name}}?</label>
                                    <input id="Client_Vehicle_Estimated_Value_to_Client5" type="number" class="form-control 5_Client_clientamount_input clientamount_input" name="Client_Vehicle_Estimated_Value_to_Client5" value="<?php if(isset($drvehicles->Client_Vehicle_Estimated_Value_to_Client5)){ echo $drvehicles->Client_Vehicle_Estimated_Value_to_Client5; } ?>" min="0.00" step="0.01" max="999999.99" readonly="" onchange="getEstimatedValueClient(this, '5', 'Client');" onkeyup="getEstimatedValueClient(this, '5', 'Client');">
                                </div>
                                <div class="form-group col-sm-6 Client_Vehicle_Owned5_Div Client_Vehicle_Paying_Party5_Inputs_Div" style="display: none;">
                                    <label>{{$opponent_name}} Vehicles Equity Percent</label>
                                    <input id="Client_Vehicle_Percent_Marital_Equity_to_Op5" type="number" class="form-control 5_Client_opponentpercentage_input opponentpercentage_input" name="Client_Vehicle_Percent_Marital_Equity_to_Op5" value="<?php if(isset($drvehicles->Client_Vehicle_Percent_Marital_Equity_to_Op5)){ echo $drvehicles->Client_Vehicle_Percent_Marital_Equity_to_Op5; } ?>" min="0.00" step="0.01" max="100" readonly="">
                                </div>
                                <div class="form-group col-sm-6 Client_Vehicle_Owned5_Div Client_Vehicle_Paying_Party5_Inputs_Div" style="display: none;">
                                    <label>How much is to be paid to {{$opponent_name}}?</label>
                                    <input id="Client_Vehicle_Estimated_Value_to_Op5" type="number" class="form-control 5_Client_opponentamount_input opponentamount_input" name="Client_Vehicle_Estimated_Value_to_Op5" value="<?php if(isset($drvehicles->Client_Vehicle_Estimated_Value_to_Op5)){ echo $drvehicles->Client_Vehicle_Estimated_Value_to_Op5; } ?>" min="0.00" step="0.01" max="999999.99" readonly="" onchange="getEstimatedValueOp(this, '5', 'Client');" onkeyup="getEstimatedValueOp(this, '5', 'Client');">
                                </div>
                                <!-- end of slider tool -->
                                <div class="form-group col-sm-6 Client_Vehicle_Paying_Party5_Leased_Div" style="display: none;">
                                    <label for="Client_Vehicle_Lease_Company5">Name of vehicle lease company?</label>
                                    <input id="Client_Vehicle_Lease_Company5" type="text" class="form-control 5_Client_vehicles_inputs Client_Vehicle_Paying_Party5_Leased_Input" name="Client_Vehicle_Lease_Company5" value="<?php if(isset($drvehicles->Client_Vehicle_Lease_Company5)){ echo $drvehicles->Client_Vehicle_Lease_Company5; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6 Client_Vehicle_Paying_Party5_Leased_Div" style="display: none;">
                                    <label>Monthly lease payment for this vehicle?</label>
                                    <input id="Client_Vehicle_Monthly_Lease_Amount5" type="number" class="form-control 5_Client_vehicles_inputs Client_Vehicle_Paying_Party5_Leased_Input" name="Client_Vehicle_Monthly_Lease_Amount5" value="<?php if(isset($drvehicles->Client_Vehicle_Monthly_Lease_Amount5)){ echo $drvehicles->Client_Vehicle_Monthly_Lease_Amount5; } ?>" min="0.00" step="0.01" max="999999.99">
                                </div>
                                <div class="form-group col-sm-6 Client_Vehicle_Paying_Party5_Leased_Div" style="display: none;">
                                    <label>How will this leased vehicle be handled?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Client_Vehicle_Lease_Disposition_Method5_Terminate_Lease" name="Client_Vehicle_Lease_Disposition_Method5" value="Terminate Lease" <?php if(isset($drvehicles->Client_Vehicle_Lease_Disposition_Method5) && $drvehicles->Client_Vehicle_Lease_Disposition_Method5=='Terminate Lease'){ echo "checked"; } ?>> Terminate Lease</label>
                                        <label><input type="radio" id="Client_Vehicle_Lease_Disposition_Method5_Transfer_Lease_Responsibility_to_ClientName" name="Client_Vehicle_Lease_Disposition_Method5" value="Transfer Lease Responsibility to {{$client_name}}" <?php if(isset($drvehicles->Client_Vehicle_Lease_Disposition_Method5) && $drvehicles->Client_Vehicle_Lease_Disposition_Method5=='Transfer Lease Responsibility to '.$client_name.''){ echo "checked"; } ?>> Transfer Lease Responsibility to {{$client_name}}</label>
                                        <label><input type="radio" id="Client_Vehicle_Lease_Disposition_Method5_Transfer_Lease_Responsibility_to_OpName" name="Client_Vehicle_Lease_Disposition_Method5" value="Transfer Lease Responsibility to {{$opponent_name}}" <?php if(isset($drvehicles->Client_Vehicle_Lease_Disposition_Method5) && $drvehicles->Client_Vehicle_Lease_Disposition_Method5=='Transfer Lease Responsibility to '.$opponent_name.''){ echo "checked"; } ?>> Transfer Lease Responsibility to {{$opponent_name}}</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 mt-4 6_Client_vehicles_section" style="display: none;"><h5 class="col-sm-12">Sixth Vehicle Info</h5>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Vehicle_Year6">Model year of this vehicle?</label>
                                    <select id="Client_Vehicle_Year6" name="Client_Vehicle_Year6" class="form-control 6_Client_vehicles_select">
                                        <?php 
                                            if(isset($drvehicles->Client_Vehicle_Year6)){ 
                                                $already_selected_value = $drvehicles->Client_Vehicle_Year6; 
                                            } else {
                                                $already_selected_value = '';
                                            }
                                            $earliest_year = 1900;
                                            foreach (range(date('Y'), $earliest_year) as $x) {
                                                echo '<option value="'.$x.'"'.($x == $already_selected_value ? ' selected="selected"' : '').'>'.$x.'</option>';
                                            }
                                        ?>
                                    </select>   
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Vehicle_Make_Model6">What make and model is this vehicle?</label>
                                    <input id="Client_Vehicle_Make_Model6" type="text" class="form-control 6_Client_vehicles_inputs" name="Client_Vehicle_Make_Model6" value="<?php if(isset($drvehicles->Client_Vehicle_Make_Model6)){ echo $drvehicles->Client_Vehicle_Make_Model6; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Is this vehicle leased or owned?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Client_Vehicle_Owned_Leased6_Owned" name="Client_Vehicle_Owned_Leased6" value="Owned" data-onload="getInitialVehicleOwnedLeased(this, '6', 'Client');" onchange="getVehicleOwnedLeased(this, '6', 'Client');" <?php if(isset($drvehicles->Client_Vehicle_Owned_Leased6) && $drvehicles->Client_Vehicle_Owned_Leased6=='Owned'){ echo "checked"; } ?>> Owned</label>
                                        <label><input type="radio" id="Client_Vehicle_Owned_Leased6_Leased" name="Client_Vehicle_Owned_Leased6" value="Leased" data-onload="getInitialVehicleOwnedLeased(this, '6', 'Client');" onchange="getVehicleOwnedLeased(this, '6', 'Client');" <?php if(isset($drvehicles->Client_Vehicle_Owned_Leased6) && $drvehicles->Client_Vehicle_Owned_Leased6=='Leased'){ echo "checked"; } ?>> Leased</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 Client_Vehicle_Owned6_Div">
                                    <label for="Client_Vehicle_VIN6">What is the VIN of this vehicle?</label>
                                    <input id="Client_Vehicle_VIN6" type="text" class="form-control 6_Client_vehicles_inputs" name="Client_Vehicle_VIN6" value="<?php if(isset($drvehicles->Client_Vehicle_VIN6)){ echo $drvehicles->Client_Vehicle_VIN6; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6 Client_Vehicle_Owned6_Div">
                                    <label for="Client_Vehicle_Current_Value6">What is the current value of this vehicle?</label>
                                    <input id="Client_Vehicle_Current_Value6" type="number" class="form-control 6_Client_vehicles_inputs" name="Client_Vehicle_Current_Value6" value="<?php if(isset($drvehicles->Client_Vehicle_Current_Value6)){ echo $drvehicles->Client_Vehicle_Current_Value6; } ?>" min="0.00" step="0.01" max="999999.99" onchange="getCurrentValue(this, '6', 'Client');" onkeyup="getCurrentValue(this, '6', 'Client');">
                                </div>
                                <div class="form-group col-sm-6 Client_Vehicle_Owned6_Div">
                                    <label for="Client_Vehicle_Loan_Company_Name6">Name of first car loan company?</label>
                                    <input id="Client_Vehicle_Loan_Company_Name6" type="text" class="form-control 6_Client_vehicles_inputs" name="Client_Vehicle_Loan_Company_Name6" value="<?php if(isset($drvehicles->Client_Vehicle_Loan_Company_Name6)){ echo $drvehicles->Client_Vehicle_Loan_Company_Name6; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6 Client_Vehicle_Owned6_Div">
                                    <label for="Client_Vehicle_Loan_Balance6">Balance due to first car loan company for this vehicle?</label>
                                    <input id="Client_Vehicle_Loan_Balance6" type="number" class="form-control 6_Client_vehicles_inputs" name="Client_Vehicle_Loan_Balance6" value="<?php if(isset($drvehicles->Client_Vehicle_Loan_Balance6)){ echo $drvehicles->Client_Vehicle_Loan_Balance6; } ?>" min="0.00" step="0.01" max="999999.99" onchange="getLoanBalance(this, '6', 'Client');" onkeyup="getLoanBalance(this, '6', 'Client');">
                                </div>
                                <div class="form-group col-sm-6 Client_Vehicle_Owned6_Div">
                                    <label for="Client_Vehicle_Loan_Monthly_Payment6">Monthly payment to first car loan company for this vehicle?</label>
                                    <input id="Client_Vehicle_Loan_Monthly_Payment6" type="number" class="form-control 6_Client_vehicles_inputs" name="Client_Vehicle_Loan_Monthly_Payment6" value="<?php if(isset($drvehicles->Client_Vehicle_Loan_Monthly_Payment6)){ echo $drvehicles->Client_Vehicle_Loan_Monthly_Payment6; } ?>" min="0.00" step="0.01" max="999999.99">
                                </div>
                                <div class="form-group col-sm-6 Client_Vehicle_Owned6_Div">
                                    <label for="Client_Vehicle_Loan_Second_Company_Name6">Name of second car loan company?</label>
                                    <input id="Client_Vehicle_Loan_Second_Company_Name6" type="text" class="form-control 6_Client_vehicles_inputs" name="Client_Vehicle_Loan_Second_Company_Name6" value="<?php if(isset($drvehicles->Client_Vehicle_Loan_Second_Company_Name6)){ echo $drvehicles->Client_Vehicle_Loan_Second_Company_Name6; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6 Client_Vehicle_Owned6_Div">
                                    <label for="Client_Vehicle_Loan_Second_Company_Balance6">Balance due to second car loan company for this vehicle?</label>
                                    <input id="Client_Vehicle_Loan_Second_Company_Balance6" type="number" class="form-control 6_Client_vehicles_inputs" name="Client_Vehicle_Loan_Second_Company_Balance6" value="<?php if(isset($drvehicles->Client_Vehicle_Loan_Second_Company_Balance6)){ echo $drvehicles->Client_Vehicle_Loan_Second_Company_Balance6; } ?>" min="0.00" step="0.01" max="999999.99" onchange="getCompanyBalance(this, '6', 'Client');" onkeyup="getCompanyBalance(this, '6', 'Client');">
                                </div>
                                <div class="form-group col-sm-6 Client_Vehicle_Owned6_Div">
                                    <label for="Client_Vehicle_Loan_Second_Company_Monthly_Payment6">Monthly payment to second car loan company for this vehicle?</label>
                                    <input id="Client_Vehicle_Loan_Second_Company_Monthly_Payment6" type="number" class="form-control 6_Client_vehicles_inputs" name="Client_Vehicle_Loan_Second_Company_Monthly_Payment6" value="<?php if(isset($drvehicles->Client_Vehicle_Loan_Second_Company_Monthly_Payment6)){ echo $drvehicles->Client_Vehicle_Loan_Second_Company_Monthly_Payment6; } ?>" min="0.00" step="0.01" max="999999.99">
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label for="Client_Vehicle_Marital_Equity6">N/A, calculated = Client_Vehicle_Current_Value6-Client_Vehicle_Loan_Balance6-Client_Vehicle_Loan_Second_Company_Balance6</label>
                                    <input id="Client_Vehicle_Marital_Equity6" type="number" class="form-control 6_Client_vehicles_inputs" name="Client_Vehicle_Marital_Equity6" value="<?php if(isset($drvehicles->Client_Vehicle_Marital_Equity6)){ echo $drvehicles->Client_Vehicle_Marital_Equity6; } ?>" min="0.00" step="0.01" max="999999.99">
                                </div>
                                <div class="form-group col-sm-6 Client_Vehicle_Owned6_Div">
                                    <label>Does either party claim a sole/separate interest in this vehicle?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Client_Vehicle_SoleSeparate_Claim6_Yes" name="Client_Vehicle_SoleSeparate_Claim6" value="Yes" data-onload="getInitialPartyClaimSoleSeparate(this, '6', 'Client');" onchange="getPartyClaimSoleSeparate(this, '6', 'Client');" <?php if(isset($drvehicles->Client_Vehicle_SoleSeparate_Claim6) && $drvehicles->Client_Vehicle_SoleSeparate_Claim6=='Yes'){ echo "checked"; } ?>> Yes</label>
                                        <label><input type="radio" id="Client_Vehicle_SoleSeparate_Claim6_No" name="Client_Vehicle_SoleSeparate_Claim6" value="No" data-onload="getInitialPartyClaimSoleSeparate(this, '6', 'Client');" onchange="getPartyClaimSoleSeparate(this, '6', 'Client');" <?php if(isset($drvehicles->Client_Vehicle_SoleSeparate_Claim6) && $drvehicles->Client_Vehicle_SoleSeparate_Claim6=='No'){ echo "checked"; } ?>> No</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 Client_Vehicle_Owned6_Div" id="Client_Vehicle_SoleSeparate_Party6_Div" style="display: none;">
                                    <label>Who claims to own this vehicle?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Client_Vehicle_SoleSeparate_Party6_Client" name="Client_Vehicle_SoleSeparate_Party6" value="{{$client_name}}" <?php if(isset($drvehicles->Client_Vehicle_SoleSeparate_Party6) && $drvehicles->Client_Vehicle_SoleSeparate_Party6==$client_name){ echo "checked"; } ?>> {{$client_name}}</label>
                                        <label><input type="radio" id="Client_Vehicle_SoleSeparate_Party6_Op" name="Client_Vehicle_SoleSeparate_Party6" value="{{$opponent_name}}" <?php if(isset($drvehicles->Client_Vehicle_SoleSeparate_Party6) && $drvehicles->Client_Vehicle_SoleSeparate_Party6==$opponent_name){ echo "checked"; } ?>> {{$opponent_name}}</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 Client_Vehicle_Owned6_Div" id="Client_Vehicle_SoleSeparate_Grounds6_Div" style="display: none;">
                                    <label for="Client_Vehicle_SoleSeparate_Grounds6">Why does this person own this vehicle solely and separately?</label>
                                    <input id="Client_Vehicle_SoleSeparate_Grounds6" type="text" class="form-control 6_Client_vehicles_inputs" name="Client_Vehicle_SoleSeparate_Grounds6" value="<?php if(isset($drvehicles->Client_Vehicle_SoleSeparate_Grounds6)){ echo $drvehicles->Client_Vehicle_SoleSeparate_Grounds6; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6 Client_Vehicle_Owned6_Div">
                                    <label>How will this vehicle value be distributed between the parties?</label>
                                    <div class="w-100 dataInput">
                                        <label><input type="radio" id="Client_Vehicle_Disposition_Method6_Liquidate_Split_Net_Value" name="Client_Vehicle_Disposition_Method6" value="Liquidate/Split Net Value" data-onload="getInitialDipositionMethod(this, '6', 'Client');" onchange="getDipositionMethod(this, '6', 'Client');" <?php if(isset($drvehicles->Client_Vehicle_Disposition_Method6) && $drvehicles->Client_Vehicle_Disposition_Method6=='Liquidate/Split Net Value'){ echo "checked"; } ?>> Liquidate/Split Net Value</label>
                                        <label><input type="radio" id="Client_Vehicle_Disposition_Method6_Fixed_Buyout" name="Client_Vehicle_Disposition_Method6" value="Fixed Buyout" data-onload="getInitialDipositionMethod(this, '6', 'Client');" onchange="getDipositionMethod(this, '6', 'Client');" <?php if(isset($drvehicles->Client_Vehicle_Disposition_Method6) && $drvehicles->Client_Vehicle_Disposition_Method6=='Fixed Buyout'){ echo "checked"; } ?>> Fixed Buyout</label>
                                    </div>
                                </div>
                                <!-- slider tool -->
                                <div class="form-group col-sm-6 m-auto 6_Client_Slider_Tool Client_Vehicle_Owned6_Div">
                                    <div class="row">
                                        <div class="col">{{$client_name}}</div>
                                        <div class="col text-right">{{$opponent_name}}</div>
                                    </div>
                                    <input id="6_Client_balance_range_selector" type="range" class="form-control slider-tool-input 6_Client_balance_range_selector" name="" value="<?php if(isset($drvehicles->Client_Vehicle_Percent_Marital_Equity_to_Op6)){ echo $drvehicles->Client_Vehicle_Percent_Marital_Equity_to_Op6; } ?>" min="0.00" step="0.01" max="100" onchange="updateBalanceInput(this.value, '6', 'Client');">
                                </div>
                                <div class="form-group col-sm-6 m-auto 6_Client_Slider_Tool Client_Vehicle_Owned6_Div">
                                    <div class="row justify-content-between">
                                        <div class="col selectorTool">
                                            <div class="left-col">
                                                <div class="client-info 6_Client_clientpercentage_div clientpercentage_div">
                                                    <?php if(isset($drvehicles->Client_Vehicle_Percent_Marital_Equity_to_Client6)){ echo $drvehicles->Client_Vehicle_Percent_Marital_Equity_to_Client6; } else {
                                                        echo '50.00';
                                                    } ?>%
                                                </div>
                                                <div class="client-info 6_Client_clientamount_div clientamount_div" style="clear: both;">
                                                    $<?php if(isset($drvehicles->Client_Vehicle_Estimated_Value_to_Client6)){ echo $drvehicles->Client_Vehicle_Estimated_Value_to_Client6; } else {
                                                        echo '50.00';
                                                    } ?>
                                                </div>
                                            </div>
                                            <label>To {{$client_name}}</label>
                                        </div>                                       
                                        <div class="col selectorTool selectorToolRight">
                                            <label>To {{$opponent_name}}</label>
                                            <div class="left-col right-col">
                                                <div class="client-info 6_Client_opponentpercentage_div opponentpercentage_div">
                                                    <?php if(isset($drvehicles->Client_Vehicle_Percent_Marital_Equity_to_Op6)){ echo $drvehicles->Client_Vehicle_Percent_Marital_Equity_to_Op6; } else {
                                                        echo '50.00';
                                                    } ?>%
                                                </div>
                                                <div class="client-info 6_Client_opponentamount_div opponentamount_div" style="clear: both;">
                                                    $<?php if(isset($drvehicles->Client_Vehicle_Estimated_Value_to_Op6)){ echo $drvehicles->Client_Vehicle_Estimated_Value_to_Op6; } else {
                                                        echo '50.00';
                                                    } ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 m-auto 6_Client_Slider_Tool Client_Vehicle_Owned6_Div">
                                    <label></label>
                                    <div class="w-100">
                                        <label><input type="radio" id="6_Client_Vehicle_Estimated_Value_Select" name="6_Client_Vehicle_Estimated_Value_Select_Reset" class="Vehicle_Estimated_Value_Select_Reset" value="Save"> Save this Distribution of Vehicles #6</label>
                                        <label><input type="radio" id="6_Client_Vehicle_Estimated_Value_Reset" name="6_Client_Vehicle_Estimated_Value_Select_Reset" class="Vehicle_Estimated_Value_Select_Reset" value="Reset" onclick="resetBalanceInput(this, '6', 'Client');"> Reset to Default (50%)</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 Client_Vehicle_Owned6_Div Client_Vehicle_Paying_Party6_Inputs_Div" style="display: none;">
                                    <label>Client Vehicles Paying Party6</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Client_Vehicle_Paying_Party6_Client" name="Client_Vehicle_Paying_Party6" value="{{$client_name}}" data-onload="getInitialVehiclesPayingParty(this, '6', 'Client');" onchange="getVehiclesPayingParty(this, '6', 'Client');" <?php if(isset($drvehicles->Client_Vehicle_Paying_Party6) && $drvehicles->Client_Vehicle_Paying_Party6==$client_name){ echo "checked"; } ?>> {{$client_name}}</label>
                                        <label><input type="radio" id="Client_Vehicle_Paying_Party6_Op" name="Client_Vehicle_Paying_Party6" value="{{$opponent_name}}" data-onload="getInitialVehiclesPayingParty(this, '6', 'Client');" onchange="getVehiclesPayingParty(this, '6', 'Client');" <?php if(isset($drvehicles->Client_Vehicle_Paying_Party6) && $drvehicles->Client_Vehicle_Paying_Party6==$opponent_name){ echo "checked"; } ?>> {{$opponent_name}}</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 Client_Vehicle_Owned6_Div Client_Vehicle_Paying_Party6_Inputs_Div" style="display: none;">
                                    <label>{{$client_name}} Vehicles Equity Percent</label>
                                    <input id="Client_Vehicle_Percent_Marital_Equity_to_Client6" type="number" class="form-control 6_Client_clientpercentage_input clientpercentage_input" name="Client_Vehicle_Percent_Marital_Equity_to_Client6" value="<?php if(isset($drvehicles->Client_Vehicle_Percent_Marital_Equity_to_Client6)){ echo $drvehicles->Client_Vehicle_Percent_Marital_Equity_to_Client6; } ?>" min="0.00" step="0.01" max="100" readonly="">
                                </div>
                                <div class="form-group col-sm-6 Client_Vehicle_Owned6_Div Client_Vehicle_Paying_Party6_Inputs_Div" style="display: none;">
                                    <label>How much is to be paid to {{$client_name}}?</label>
                                    <input id="Client_Vehicle_Estimated_Value_to_Client6" type="number" class="form-control 6_Client_clientamount_input clientamount_input" name="Client_Vehicle_Estimated_Value_to_Client6" value="<?php if(isset($drvehicles->Client_Vehicle_Estimated_Value_to_Client6)){ echo $drvehicles->Client_Vehicle_Estimated_Value_to_Client6; } ?>" min="0.00" step="0.01" max="999999.99" readonly="" onchange="getEstimatedValueClient(this, '6', 'Client');" onkeyup="getEstimatedValueClient(this, '6', 'Client');">
                                </div>
                                <div class="form-group col-sm-6 Client_Vehicle_Owned6_Div Client_Vehicle_Paying_Party6_Inputs_Div" style="display: none;">
                                    <label>{{$opponent_name}} Vehicles Equity Percent</label>
                                    <input id="Client_Vehicle_Percent_Marital_Equity_to_Op6" type="number" class="form-control 6_Client_opponentpercentage_input opponentpercentage_input" name="Client_Vehicle_Percent_Marital_Equity_to_Op6" value="<?php if(isset($drvehicles->Client_Vehicle_Percent_Marital_Equity_to_Op6)){ echo $drvehicles->Client_Vehicle_Percent_Marital_Equity_to_Op6; } ?>" min="0.00" step="0.01" max="100" readonly="">
                                </div>
                                <div class="form-group col-sm-6 Client_Vehicle_Owned6_Div Client_Vehicle_Paying_Party6_Inputs_Div" style="display: none;">
                                    <label>How much is to be paid to {{$opponent_name}}?</label>
                                    <input id="Client_Vehicle_Estimated_Value_to_Op6" type="number" class="form-control 6_Client_opponentamount_input opponentamount_input" name="Client_Vehicle_Estimated_Value_to_Op6" value="<?php if(isset($drvehicles->Client_Vehicle_Estimated_Value_to_Op6)){ echo $drvehicles->Client_Vehicle_Estimated_Value_to_Op6; } ?>" min="0.00" step="0.01" max="999999.99" readonly="" onchange="getEstimatedValueOp(this, '6', 'Client');" onkeyup="getEstimatedValueOp(this, '6', 'Client');">
                                </div>
                                <!-- end of slider tool -->
                                <div class="form-group col-sm-6 Client_Vehicle_Paying_Party6_Leased_Div" style="display: none;">
                                    <label for="Client_Vehicle_Lease_Company6">Name of vehicle lease company?</label>
                                    <input id="Client_Vehicle_Lease_Company6" type="text" class="form-control 6_Client_vehicles_inputs Client_Vehicle_Paying_Party6_Leased_Input" name="Client_Vehicle_Lease_Company6" value="<?php if(isset($drvehicles->Client_Vehicle_Lease_Company6)){ echo $drvehicles->Client_Vehicle_Lease_Company6; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6 Client_Vehicle_Paying_Party6_Leased_Div" style="display: none;">
                                    <label>Monthly lease payment for this vehicle?</label>
                                    <input id="Client_Vehicle_Monthly_Lease_Amount6" type="number" class="form-control 6_Client_vehicles_inputs Client_Vehicle_Paying_Party6_Leased_Input" name="Client_Vehicle_Monthly_Lease_Amount6" value="<?php if(isset($drvehicles->Client_Vehicle_Monthly_Lease_Amount6)){ echo $drvehicles->Client_Vehicle_Monthly_Lease_Amount6; } ?>" min="0.00" step="0.01" max="999999.99">
                                </div>
                                <div class="form-group col-sm-6 Client_Vehicle_Paying_Party6_Leased_Div" style="display: none;">
                                    <label>How will this leased vehicle be handled?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Client_Vehicle_Lease_Disposition_Method6_Terminate_Lease" name="Client_Vehicle_Lease_Disposition_Method6" value="Terminate Lease" <?php if(isset($drvehicles->Client_Vehicle_Lease_Disposition_Method6) && $drvehicles->Client_Vehicle_Lease_Disposition_Method6=='Terminate Lease'){ echo "checked"; } ?>> Terminate Lease</label>
                                        <label><input type="radio" id="Client_Vehicle_Lease_Disposition_Method6_Transfer_Lease_Responsibility_to_ClientName" name="Client_Vehicle_Lease_Disposition_Method6" value="Transfer Lease Responsibility to {{$client_name}}" <?php if(isset($drvehicles->Client_Vehicle_Lease_Disposition_Method6) && $drvehicles->Client_Vehicle_Lease_Disposition_Method6=='Transfer Lease Responsibility to '.$client_name.''){ echo "checked"; } ?>> Transfer Lease Responsibility to {{$client_name}}</label>
                                        <label><input type="radio" id="Client_Vehicle_Lease_Disposition_Method6_Transfer_Lease_Responsibility_to_OpName" name="Client_Vehicle_Lease_Disposition_Method6" value="Transfer Lease Responsibility to {{$opponent_name}}" <?php if(isset($drvehicles->Client_Vehicle_Lease_Disposition_Method6) && $drvehicles->Client_Vehicle_Lease_Disposition_Method6=='Transfer Lease Responsibility to '.$opponent_name.''){ echo "checked"; } ?>> Transfer Lease Responsibility to {{$opponent_name}}</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- End of Client Vehicles Info Section -->

                        <!-- Opponent Vehicles Info Section -->
                        <div class="form-row Num_Op_Vehicles mt-4" style="display: none;">
                            <h4 class="col-sm-12">{{$opponent_name}} Vehicles Info Section</h4>
                            <div class="col-sm-6">
                                <label for="Num_Op_Vehicles">How Many Vehicles Leased or Titled in just to {{$opponent_name}}?</label>
                                <input id="Num_Op_Vehicles" type="number" class="form-control" name="Num_Op_Vehicles" value="<?php if(isset($drvehicles->Num_Op_Vehicles)){ echo $drvehicles->Num_Op_Vehicles; } ?>" min="0" max="6"> 
                            </div>
                        </div>
                        <div class="form-row Opponent_vehicles_section">
                            <div class="col-sm-12 mt-4 1_Op_vehicles_section" style="display: none;"><h5 class="col-sm-12">First Vehicle Info</h5>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Vehicle_Year1">Model year of this vehicle?</label>
                                    <select id="Op_Vehicle_Year1" name="Op_Vehicle_Year1" class="form-control 1_Op_vehicles_select">
                                        <?php 
                                            if(isset($drvehicles->Op_Vehicle_Year1)){ 
                                                $already_selected_value = $drvehicles->Op_Vehicle_Year1; 
                                            } else {
                                                $already_selected_value = '';
                                            }
                                            $earliest_year = 1900;
                                            foreach (range(date('Y'), $earliest_year) as $x) {
                                                echo '<option value="'.$x.'"'.($x == $already_selected_value ? ' selected="selected"' : '').'>'.$x.'</option>';
                                            }
                                        ?>
                                    </select>   
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Vehicle_Make_Model1">What make and model is this vehicle?</label>
                                    <input id="Op_Vehicle_Make_Model1" type="text" class="form-control 1_Op_vehicles_inputs" name="Op_Vehicle_Make_Model1" value="<?php if(isset($drvehicles->Op_Vehicle_Make_Model1)){ echo $drvehicles->Op_Vehicle_Make_Model1; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Is this vehicle leased or owned?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Op_Vehicle_Owned_Leased1_Owned" name="Op_Vehicle_Owned_Leased1" value="Owned" data-onload="getInitialVehicleOwnedLeased(this, '1', 'Op');" onchange="getVehicleOwnedLeased(this, '1', 'Op');" <?php if(isset($drvehicles->Op_Vehicle_Owned_Leased1) && $drvehicles->Op_Vehicle_Owned_Leased1=='Owned'){ echo "checked"; } ?>> Owned</label>
                                        <label><input type="radio" id="Op_Vehicle_Owned_Leased1_Leased" name="Op_Vehicle_Owned_Leased1" value="Leased" data-onload="getInitialVehicleOwnedLeased(this, '1', 'Op');" onchange="getVehicleOwnedLeased(this, '1', 'Op');" <?php if(isset($drvehicles->Op_Vehicle_Owned_Leased1) && $drvehicles->Op_Vehicle_Owned_Leased1=='Leased'){ echo "checked"; } ?>> Leased</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 Op_Vehicle_Owned1_Div">
                                    <label for="Op_Vehicle_VIN1">What is the VIN of this vehicle?</label>
                                    <input id="Op_Vehicle_VIN1" type="text" class="form-control 1_Op_vehicles_inputs" name="Op_Vehicle_VIN1" value="<?php if(isset($drvehicles->Op_Vehicle_VIN1)){ echo $drvehicles->Op_Vehicle_VIN1; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6 Op_Vehicle_Owned1_Div">
                                    <label for="Op_Vehicle_Current_Value1">What is the current value of this vehicle?</label>
                                    <input id="Op_Vehicle_Current_Value1" type="number" class="form-control 1_Op_vehicles_inputs" name="Op_Vehicle_Current_Value1" value="<?php if(isset($drvehicles->Op_Vehicle_Current_Value1)){ echo $drvehicles->Op_Vehicle_Current_Value1; } ?>" min="0.00" step="0.01" max="999999.99" onchange="getCurrentValue(this, '1', 'Op');" onkeyup="getCurrentValue(this, '1', 'Op');">
                                </div>
                                <div class="form-group col-sm-6 Op_Vehicle_Owned1_Div">
                                    <label for="Op_Vehicle_Loan_Company_Name1">Name of first car loan company?</label>
                                    <input id="Op_Vehicle_Loan_Company_Name1" type="text" class="form-control 1_Op_vehicles_inputs" name="Op_Vehicle_Loan_Company_Name1" value="<?php if(isset($drvehicles->Op_Vehicle_Loan_Company_Name1)){ echo $drvehicles->Op_Vehicle_Loan_Company_Name1; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6 Op_Vehicle_Owned1_Div">
                                    <label for="Op_Vehicle_Loan_Balance1">Balance due to first car loan company for this vehicle?</label>
                                    <input id="Op_Vehicle_Loan_Balance1" type="number" class="form-control 1_Op_vehicles_inputs" name="Op_Vehicle_Loan_Balance1" value="<?php if(isset($drvehicles->Op_Vehicle_Loan_Balance1)){ echo $drvehicles->Op_Vehicle_Loan_Balance1; } ?>" min="0.00" step="0.01" max="999999.99" onchange="getLoanBalance(this, '1', 'Op');" onkeyup="getLoanBalance(this, '1', 'Op');">
                                </div>
                                <div class="form-group col-sm-6 Op_Vehicle_Owned1_Div">
                                    <label for="Op_Vehicle_Loan_Monthly_Payment1">Monthly payment to first car loan company for this vehicle?</label>
                                    <input id="Op_Vehicle_Loan_Monthly_Payment1" type="number" class="form-control 1_Op_vehicles_inputs" name="Op_Vehicle_Loan_Monthly_Payment1" value="<?php if(isset($drvehicles->Op_Vehicle_Loan_Monthly_Payment1)){ echo $drvehicles->Op_Vehicle_Loan_Monthly_Payment1; } ?>" min="0.00" step="0.01" max="999999.99">
                                </div>
                                <div class="form-group col-sm-6 Op_Vehicle_Owned1_Div">
                                    <label for="Op_Vehicle_Loan_Second_Company_Name1">Name of second car loan company?</label>
                                    <input id="Op_Vehicle_Loan_Second_Company_Name1" type="text" class="form-control 1_Op_vehicles_inputs" name="Op_Vehicle_Loan_Second_Company_Name1" value="<?php if(isset($drvehicles->Op_Vehicle_Loan_Second_Company_Name1)){ echo $drvehicles->Op_Vehicle_Loan_Second_Company_Name1; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6 Op_Vehicle_Owned1_Div">
                                    <label for="Op_Vehicle_Loan_Second_Company_Balance1">Balance due to second car loan company for this vehicle?</label>
                                    <input id="Op_Vehicle_Loan_Second_Company_Balance1" type="number" class="form-control 1_Op_vehicles_inputs" name="Op_Vehicle_Loan_Second_Company_Balance1" value="<?php if(isset($drvehicles->Op_Vehicle_Loan_Second_Company_Balance1)){ echo $drvehicles->Op_Vehicle_Loan_Second_Company_Balance1; } ?>" min="0.00" step="0.01" max="999999.99" onchange="getCompanyBalance(this, '1', 'Op');" onkeyup="getCompanyBalance(this, '1', 'Op');">
                                </div>
                                <div class="form-group col-sm-6 Op_Vehicle_Owned1_Div">
                                    <label for="Op_Vehicle_Loan_Second_Company_Monthly_Payment1">Monthly payment to second car loan company for this vehicle?</label>
                                    <input id="Op_Vehicle_Loan_Second_Company_Monthly_Payment1" type="number" class="form-control 1_Op_vehicles_inputs" name="Op_Vehicle_Loan_Second_Company_Monthly_Payment1" value="<?php if(isset($drvehicles->Op_Vehicle_Loan_Second_Company_Monthly_Payment1)){ echo $drvehicles->Op_Vehicle_Loan_Second_Company_Monthly_Payment1; } ?>" min="0.00" step="0.01" max="999999.99">
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label for="Op_Vehicle_Marital_Equity1">N/A, calculated = Op_Vehicle_Current_Value1-Op_Vehicle_Loan_Balance1-Op_Vehicle_Loan_Second_Company_Balance1</label>
                                    <input id="Op_Vehicle_Marital_Equity1" type="number" class="form-control 1_Op_vehicles_inputs" name="Op_Vehicle_Marital_Equity1" value="<?php if(isset($drvehicles->Op_Vehicle_Marital_Equity1)){ echo $drvehicles->Op_Vehicle_Marital_Equity1; } ?>" min="0.00" step="0.01" max="999999.99">
                                </div>
                                <div class="form-group col-sm-6 Op_Vehicle_Owned1_Div">
                                    <label>Does either party claim a sole/separate interest in this vehicle?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Op_Vehicle_SoleSeparate_Claim1_Yes" name="Op_Vehicle_SoleSeparate_Claim1" value="Yes" data-onload="getInitialPartyClaimSoleSeparate(this, '1', 'Op');" onchange="getPartyClaimSoleSeparate(this, '1', 'Op');" <?php if(isset($drvehicles->Op_Vehicle_SoleSeparate_Claim1) && $drvehicles->Op_Vehicle_SoleSeparate_Claim1=='Yes'){ echo "checked"; } ?>> Yes</label>
                                        <label><input type="radio" id="Op_Vehicle_SoleSeparate_Claim1_No" name="Op_Vehicle_SoleSeparate_Claim1" value="No" data-onload="getInitialPartyClaimSoleSeparate(this, '1', 'Op');" onchange="getPartyClaimSoleSeparate(this, '1', 'Op');" <?php if(isset($drvehicles->Op_Vehicle_SoleSeparate_Claim1) && $drvehicles->Op_Vehicle_SoleSeparate_Claim1=='No'){ echo "checked"; } ?>> No</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 Op_Vehicle_Owned1_Div" id="Op_Vehicle_SoleSeparate_Party1_Div" style="display: none;">
                                    <label>Who claims to own this vehicle?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Op_Vehicle_SoleSeparate_Party1_Client" name="Op_Vehicle_SoleSeparate_Party1" value="{{$client_name}}" <?php if(isset($drvehicles->Op_Vehicle_SoleSeparate_Party1) && $drvehicles->Op_Vehicle_SoleSeparate_Party1==$client_name){ echo "checked"; } ?>> {{$client_name}}</label>
                                        <label><input type="radio" id="Op_Vehicle_SoleSeparate_Party1_Op" name="Op_Vehicle_SoleSeparate_Party1" value="{{$opponent_name}}" <?php if(isset($drvehicles->Op_Vehicle_SoleSeparate_Party1) && $drvehicles->Op_Vehicle_SoleSeparate_Party1==$opponent_name){ echo "checked"; } ?>> {{$opponent_name}}</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 Op_Vehicle_Owned1_Div" id="Op_Vehicle_SoleSeparate_Grounds1_Div" style="display: none;">
                                    <label for="Op_Vehicle_SoleSeparate_Grounds1">Why does this person own this vehicle solely and separately?</label>
                                    <input id="Op_Vehicle_SoleSeparate_Grounds1" type="text" class="form-control 1_Op_vehicles_inputs" name="Op_Vehicle_SoleSeparate_Grounds1" value="<?php if(isset($drvehicles->Op_Vehicle_SoleSeparate_Grounds1)){ echo $drvehicles->Op_Vehicle_SoleSeparate_Grounds1; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6 Op_Vehicle_Owned1_Div">
                                    <label>How will this vehicle value be distributed between the parties?</label>
                                    <div class="w-100 dataInput">
                                        <label><input type="radio" id="Op_Vehicle_Disposition_Method1_Liquidate_Split_Net_Value" name="Op_Vehicle_Disposition_Method1" value="Liquidate/Split Net Value" data-onload="getInitialDipositionMethod(this, '1', 'Op');" onchange="getDipositionMethod(this, '1', 'Op');" <?php if(isset($drvehicles->Op_Vehicle_Disposition_Method1) && $drvehicles->Op_Vehicle_Disposition_Method1=='Liquidate/Split Net Value'){ echo "checked"; } ?>> Liquidate/Split Net Value</label>
                                        <label><input type="radio" id="Op_Vehicle_Disposition_Method1_Fixed_Buyout" name="Op_Vehicle_Disposition_Method1" value="Fixed Buyout" data-onload="getInitialDipositionMethod(this, '1', 'Op');" onchange="getDipositionMethod(this, '1', 'Op');" <?php if(isset($drvehicles->Op_Vehicle_Disposition_Method1) && $drvehicles->Op_Vehicle_Disposition_Method1=='Fixed Buyout'){ echo "checked"; } ?>> Fixed Buyout</label>
                                    </div>
                                </div>
                                <!-- slider tool -->
                                <div class="form-group col-sm-6 m-auto 1_Op_Slider_Tool Op_Vehicle_Owned1_Div">
                                    <div class="row">
                                        <div class="col">{{$client_name}}</div>
                                        <div class="col text-right">{{$opponent_name}}</div>
                                    </div>
                                    <input id="1_Op_balance_range_selector" type="range" class="form-control slider-tool-input 1_Op_balance_range_selector" name="" value="<?php if(isset($drvehicles->Op_Vehicle_Percent_Marital_Equity_to_Op1)){ echo $drvehicles->Op_Vehicle_Percent_Marital_Equity_to_Op1; } ?>" min="0.00" step="0.01" max="100" onchange="updateBalanceInput(this.value, '1', 'Op');">
                                </div>
                                <div class="form-group col-sm-6 m-auto 1_Op_Slider_Tool Op_Vehicle_Owned1_Div">
                                    <div class="row justify-content-between">
                                        <div class="col selectorTool">
                                            <div class="left-col">
                                                <div class="client-info 1_Op_clientpercentage_div clientpercentage_div">
                                                    <?php if(isset($drvehicles->Op_Vehicle_Percent_Marital_Equity_to_Client1)){ echo $drvehicles->Op_Vehicle_Percent_Marital_Equity_to_Client1; } else {
                                                        echo '50.00';
                                                    } ?>%
                                                </div>
                                                <div class="client-info 1_Op_clientamount_div clientamount_div" style="clear: both;">
                                                    $<?php if(isset($drvehicles->Op_Vehicle_Estimated_Value_to_Client1)){ echo $drvehicles->Op_Vehicle_Estimated_Value_to_Client1; } else {
                                                        echo '50.00';
                                                    } ?>
                                                </div>
                                            </div>
                                            <label>To {{$client_name}}</label>
                                        </div>                                       
                                        <div class="col selectorTool selectorToolRight">
                                            <label>To {{$opponent_name}}</label>
                                            <div class="left-col right-col">
                                                <div class="client-info 1_Op_opponentpercentage_div opponentpercentage_div">
                                                    <?php if(isset($drvehicles->Op_Vehicle_Percent_Marital_Equity_to_Op1)){ echo $drvehicles->Op_Vehicle_Percent_Marital_Equity_to_Op1; } else {
                                                        echo '50.00';
                                                    } ?>%
                                                </div>
                                                <div class="client-info 1_Op_opponentamount_div opponentamount_div" style="clear: both;">
                                                    $<?php if(isset($drvehicles->Op_Vehicle_Estimated_Value_to_Op1)){ echo $drvehicles->Op_Vehicle_Estimated_Value_to_Op1; } else {
                                                        echo '50.00';
                                                    } ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 m-auto 1_Op_Slider_Tool Op_Vehicle_Owned1_Div">
                                    <label></label>
                                    <div class="w-100">
                                        <label><input type="radio" id="1_Op_Vehicle_Estimated_Value_Select" name="1_Op_Vehicle_Estimated_Value_Select_Reset" class="Vehicle_Estimated_Value_Select_Reset" value="Save"> Save this Distribution of Vehicles #1</label>
                                        <label><input type="radio" id="1_Op_Vehicle_Estimated_Value_Reset" name="1_Op_Vehicle_Estimated_Value_Select_Reset" class="Vehicle_Estimated_Value_Select_Reset" value="Reset" onclick="resetBalanceInput(this, '1', 'Op');"> Reset to Default (50%)</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 Op_Vehicle_Owned1_Div Op_Vehicle_Paying_Party1_Inputs_Div" style="display: none;">
                                    <label>Op Vehicles Paying Party1</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Op_Vehicle_Paying_Party1_Client" name="Op_Vehicle_Paying_Party1" value="{{$client_name}}" data-onload="getInitialVehiclesPayingParty(this, '1', 'Op');" onchange="getVehiclesPayingParty(this, '1', 'Op');" <?php if(isset($drvehicles->Op_Vehicle_Paying_Party1) && $drvehicles->Op_Vehicle_Paying_Party1==$client_name){ echo "checked"; } ?>> {{$client_name}}</label>
                                        <label><input type="radio" id="Op_Vehicle_Paying_Party1_Op" name="Op_Vehicle_Paying_Party1" value="{{$opponent_name}}" data-onload="getInitialVehiclesPayingParty(this, '1', 'Op');" onchange="getVehiclesPayingParty(this, '1', 'Op');" <?php if(isset($drvehicles->Op_Vehicle_Paying_Party1) && $drvehicles->Op_Vehicle_Paying_Party1==$opponent_name){ echo "checked"; } ?>> {{$opponent_name}}</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 Op_Vehicle_Owned1_Div Op_Vehicle_Paying_Party1_Inputs_Div" style="display: none;">
                                    <label>{{$client_name}} Vehicles Equity Percent</label>
                                    <input id="Op_Vehicle_Percent_Marital_Equity_to_Client1" type="number" class="form-control 1_Op_clientpercentage_input clientpercentage_input" name="Op_Vehicle_Percent_Marital_Equity_to_Client1" value="<?php if(isset($drvehicles->Op_Vehicle_Percent_Marital_Equity_to_Client1)){ echo $drvehicles->Op_Vehicle_Percent_Marital_Equity_to_Client1; } ?>" min="0.00" step="0.01" max="100" readonly="">
                                </div>
                                <div class="form-group col-sm-6 Op_Vehicle_Owned1_Div Op_Vehicle_Paying_Party1_Inputs_Div" style="display: none;">
                                    <label>How much is to be paid to {{$client_name}}?</label>
                                    <input id="Op_Vehicle_Estimated_Value_to_Client1" type="number" class="form-control 1_Op_clientamount_input clientamount_input" name="Op_Vehicle_Estimated_Value_to_Client1" value="<?php if(isset($drvehicles->Op_Vehicle_Estimated_Value_to_Client1)){ echo $drvehicles->Op_Vehicle_Estimated_Value_to_Client1; } ?>" min="0.00" step="0.01" max="999999.99" readonly="" onchange="getEstimatedValueClient(this, '1', 'Op');" onkeyup="getEstimatedValueClient(this, '1', 'Op');">
                                </div>
                                <div class="form-group col-sm-6 Op_Vehicle_Owned1_Div Op_Vehicle_Paying_Party1_Inputs_Div" style="display: none;">
                                    <label>{{$opponent_name}} Vehicles Equity Percent</label>
                                    <input id="Op_Vehicle_Percent_Marital_Equity_to_Op1" type="number" class="form-control 1_Op_opponentpercentage_input opponentpercentage_input" name="Op_Vehicle_Percent_Marital_Equity_to_Op1" value="<?php if(isset($drvehicles->Op_Vehicle_Percent_Marital_Equity_to_Op1)){ echo $drvehicles->Op_Vehicle_Percent_Marital_Equity_to_Op1; } ?>" min="0.00" step="0.01" max="100" readonly="">
                                </div>
                                <div class="form-group col-sm-6 Op_Vehicle_Owned1_Div Op_Vehicle_Paying_Party1_Inputs_Div" style="display: none;">
                                    <label>How much is to be paid to {{$opponent_name}}?</label>
                                    <input id="Op_Vehicle_Estimated_Value_to_Op1" type="number" class="form-control 1_Op_opponentamount_input opponentamount_input" name="Op_Vehicle_Estimated_Value_to_Op1" value="<?php if(isset($drvehicles->Op_Vehicle_Estimated_Value_to_Op1)){ echo $drvehicles->Op_Vehicle_Estimated_Value_to_Op1; } ?>" min="0.00" step="0.01" max="999999.99" readonly="" onchange="getEstimatedValueOp(this, '1', 'Op');" onkeyup="getEstimatedValueOp(this, '1', 'Op');">
                                </div>
                                <!-- end of slider tool -->
                                <div class="form-group col-sm-6 Op_Vehicle_Paying_Party1_Leased_Div" style="display: none;">
                                    <label for="Op_Vehicle_Lease_Company1">Name of vehicle lease company?</label>
                                    <input id="Op_Vehicle_Lease_Company1" type="text" class="form-control 1_Op_vehicles_inputs Op_Vehicle_Paying_Party1_Leased_Input" name="Op_Vehicle_Lease_Company1" value="<?php if(isset($drvehicles->Op_Vehicle_Lease_Company1)){ echo $drvehicles->Op_Vehicle_Lease_Company1; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6 Op_Vehicle_Paying_Party1_Leased_Div" style="display: none;">
                                    <label>Monthly lease payment for this vehicle?</label>
                                    <input id="Op_Vehicle_Monthly_Lease_Amount1" type="number" class="form-control 1_Op_vehicles_inputs Op_Vehicle_Paying_Party1_Leased_Input" name="Op_Vehicle_Monthly_Lease_Amount1" value="<?php if(isset($drvehicles->Op_Vehicle_Monthly_Lease_Amount1)){ echo $drvehicles->Op_Vehicle_Monthly_Lease_Amount1; } ?>" min="0.00" step="0.01" max="999999.99">
                                </div>
                                <div class="form-group col-sm-6 Op_Vehicle_Paying_Party1_Leased_Div" style="display: none;">
                                    <label>How will this leased vehicle be handled?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Op_Vehicle_Lease_Disposition_Method1_Terminate_Lease" name="Op_Vehicle_Lease_Disposition_Method1" value="Terminate Lease" <?php if(isset($drvehicles->Op_Vehicle_Lease_Disposition_Method1) && $drvehicles->Op_Vehicle_Lease_Disposition_Method1=='Terminate Lease'){ echo "checked"; } ?>> Terminate Lease</label>
                                        <label><input type="radio" id="Op_Vehicle_Lease_Disposition_Method1_Transfer_Lease_Responsibility_to_ClientName" name="Op_Vehicle_Lease_Disposition_Method1" value="Transfer Lease Responsibility to {{$client_name}}" <?php if(isset($drvehicles->Op_Vehicle_Lease_Disposition_Method1) && $drvehicles->Op_Vehicle_Lease_Disposition_Method1=='Transfer Lease Responsibility to '.$client_name.''){ echo "checked"; } ?>> Transfer Lease Responsibility to {{$client_name}}</label>
                                        <label><input type="radio" id="Op_Vehicle_Lease_Disposition_Method1_Transfer_Lease_Responsibility_to_OpName" name="Op_Vehicle_Lease_Disposition_Method1" value="Transfer Lease Responsibility to {{$opponent_name}}" <?php if(isset($drvehicles->Op_Vehicle_Lease_Disposition_Method1) && $drvehicles->Op_Vehicle_Lease_Disposition_Method1=='Transfer Lease Responsibility to '.$opponent_name.''){ echo "checked"; } ?>> Transfer Lease Responsibility to {{$opponent_name}}</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 mt-4 2_Op_vehicles_section" style="display: none;"><h5 class="col-sm-12">Second Vehicle Info</h5>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Vehicle_Year2">Model year of this vehicle?</label>
                                    <select id="Op_Vehicle_Year2" name="Op_Vehicle_Year2" class="form-control 2_Op_vehicles_select">
                                        <?php 
                                            if(isset($drvehicles->Op_Vehicle_Year2)){ 
                                                $already_selected_value = $drvehicles->Op_Vehicle_Year2; 
                                            } else {
                                                $already_selected_value = '';
                                            }
                                            $earliest_year = 1900;
                                            foreach (range(date('Y'), $earliest_year) as $x) {
                                                echo '<option value="'.$x.'"'.($x == $already_selected_value ? ' selected="selected"' : '').'>'.$x.'</option>';
                                            }
                                        ?>
                                    </select>   
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Vehicle_Make_Model2">What make and model is this vehicle?</label>
                                    <input id="Op_Vehicle_Make_Model2" type="text" class="form-control 2_Op_vehicles_inputs" name="Op_Vehicle_Make_Model2" value="<?php if(isset($drvehicles->Op_Vehicle_Make_Model2)){ echo $drvehicles->Op_Vehicle_Make_Model2; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Is this vehicle leased or owned?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Op_Vehicle_Owned_Leased2_Owned" name="Op_Vehicle_Owned_Leased2" value="Owned" data-onload="getInitialVehicleOwnedLeased(this, '2', 'Op');" onchange="getVehicleOwnedLeased(this, '2', 'Op');" <?php if(isset($drvehicles->Op_Vehicle_Owned_Leased2) && $drvehicles->Op_Vehicle_Owned_Leased2=='Owned'){ echo "checked"; } ?>> Owned</label>
                                        <label><input type="radio" id="Op_Vehicle_Owned_Leased2_Leased" name="Op_Vehicle_Owned_Leased2" value="Leased" data-onload="getInitialVehicleOwnedLeased(this, '2', 'Op');" onchange="getVehicleOwnedLeased(this, '2', 'Op');" <?php if(isset($drvehicles->Op_Vehicle_Owned_Leased2) && $drvehicles->Op_Vehicle_Owned_Leased2=='Leased'){ echo "checked"; } ?>> Leased</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 Op_Vehicle_Owned2_Div">
                                    <label for="Op_Vehicle_VIN2">What is the VIN of this vehicle?</label>
                                    <input id="Op_Vehicle_VIN2" type="text" class="form-control 2_Op_vehicles_inputs" name="Op_Vehicle_VIN2" value="<?php if(isset($drvehicles->Op_Vehicle_VIN2)){ echo $drvehicles->Op_Vehicle_VIN2; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6 Op_Vehicle_Owned2_Div">
                                    <label for="Op_Vehicle_Current_Value2">What is the current value of this vehicle?</label>
                                    <input id="Op_Vehicle_Current_Value2" type="number" class="form-control 2_Op_vehicles_inputs" name="Op_Vehicle_Current_Value2" value="<?php if(isset($drvehicles->Op_Vehicle_Current_Value2)){ echo $drvehicles->Op_Vehicle_Current_Value2; } ?>" min="0.00" step="0.01" max="999999.99" onchange="getCurrentValue(this, '2', 'Op');" onkeyup="getCurrentValue(this, '2', 'Op');">
                                </div>
                                <div class="form-group col-sm-6 Op_Vehicle_Owned2_Div">
                                    <label for="Op_Vehicle_Loan_Company_Name2">Name of first car loan company?</label>
                                    <input id="Op_Vehicle_Loan_Company_Name2" type="text" class="form-control 2_Op_vehicles_inputs" name="Op_Vehicle_Loan_Company_Name2" value="<?php if(isset($drvehicles->Op_Vehicle_Loan_Company_Name2)){ echo $drvehicles->Op_Vehicle_Loan_Company_Name2; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6 Op_Vehicle_Owned2_Div">
                                    <label for="Op_Vehicle_Loan_Balance2">Balance due to first car loan company for this vehicle?</label>
                                    <input id="Op_Vehicle_Loan_Balance2" type="number" class="form-control 2_Op_vehicles_inputs" name="Op_Vehicle_Loan_Balance2" value="<?php if(isset($drvehicles->Op_Vehicle_Loan_Balance2)){ echo $drvehicles->Op_Vehicle_Loan_Balance2; } ?>" min="0.00" step="0.01" max="999999.99" onchange="getLoanBalance(this, '2', 'Op');" onkeyup="getLoanBalance(this, '2', 'Op');">
                                </div>
                                <div class="form-group col-sm-6 Op_Vehicle_Owned2_Div">
                                    <label for="Op_Vehicle_Loan_Monthly_Payment2">Monthly payment to first car loan company for this vehicle?</label>
                                    <input id="Op_Vehicle_Loan_Monthly_Payment2" type="number" class="form-control 2_Op_vehicles_inputs" name="Op_Vehicle_Loan_Monthly_Payment2" value="<?php if(isset($drvehicles->Op_Vehicle_Loan_Monthly_Payment2)){ echo $drvehicles->Op_Vehicle_Loan_Monthly_Payment2; } ?>" min="0.00" step="0.01" max="999999.99">
                                </div>
                                <div class="form-group col-sm-6 Op_Vehicle_Owned2_Div">
                                    <label for="Op_Vehicle_Loan_Second_Company_Name2">Name of second car loan company?</label>
                                    <input id="Op_Vehicle_Loan_Second_Company_Name2" type="text" class="form-control 2_Op_vehicles_inputs" name="Op_Vehicle_Loan_Second_Company_Name2" value="<?php if(isset($drvehicles->Op_Vehicle_Loan_Second_Company_Name2)){ echo $drvehicles->Op_Vehicle_Loan_Second_Company_Name2; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6 Op_Vehicle_Owned2_Div">
                                    <label for="Op_Vehicle_Loan_Second_Company_Balance2">Balance due to second car loan company for this vehicle?</label>
                                    <input id="Op_Vehicle_Loan_Second_Company_Balance2" type="number" class="form-control 2_Op_vehicles_inputs" name="Op_Vehicle_Loan_Second_Company_Balance2" value="<?php if(isset($drvehicles->Op_Vehicle_Loan_Second_Company_Balance2)){ echo $drvehicles->Op_Vehicle_Loan_Second_Company_Balance2; } ?>" min="0.00" step="0.01" max="999999.99" onchange="getCompanyBalance(this, '2', 'Op');" onkeyup="getCompanyBalance(this, '2', 'Op');">
                                </div>
                                <div class="form-group col-sm-6 Op_Vehicle_Owned2_Div">
                                    <label for="Op_Vehicle_Loan_Second_Company_Monthly_Payment2">Monthly payment to second car loan company for this vehicle?</label>
                                    <input id="Op_Vehicle_Loan_Second_Company_Monthly_Payment2" type="number" class="form-control 2_Op_vehicles_inputs" name="Op_Vehicle_Loan_Second_Company_Monthly_Payment2" value="<?php if(isset($drvehicles->Op_Vehicle_Loan_Second_Company_Monthly_Payment2)){ echo $drvehicles->Op_Vehicle_Loan_Second_Company_Monthly_Payment2; } ?>" min="0.00" step="0.01" max="999999.99">
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label for="Op_Vehicle_Marital_Equity2">N/A, calculated = Op_Vehicle_Current_Value2-Op_Vehicle_Loan_Balance2-Op_Vehicle_Loan_Second_Company_Balance2</label>
                                    <input id="Op_Vehicle_Marital_Equity2" type="number" class="form-control 2_Op_vehicles_inputs" name="Op_Vehicle_Marital_Equity2" value="<?php if(isset($drvehicles->Op_Vehicle_Marital_Equity2)){ echo $drvehicles->Op_Vehicle_Marital_Equity2; } ?>" min="0.00" step="0.01" max="999999.99">
                                </div>
                                <div class="form-group col-sm-6 Op_Vehicle_Owned2_Div">
                                    <label>Does either party claim a sole/separate interest in this vehicle?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Op_Vehicle_SoleSeparate_Claim2_Yes" name="Op_Vehicle_SoleSeparate_Claim2" value="Yes" data-onload="getInitialPartyClaimSoleSeparate(this, '2', 'Op');" onchange="getPartyClaimSoleSeparate(this, '2', 'Op');" <?php if(isset($drvehicles->Op_Vehicle_SoleSeparate_Claim2) && $drvehicles->Op_Vehicle_SoleSeparate_Claim2=='Yes'){ echo "checked"; } ?>> Yes</label>
                                        <label><input type="radio" id="Op_Vehicle_SoleSeparate_Claim2_No" name="Op_Vehicle_SoleSeparate_Claim2" value="No" data-onload="getInitialPartyClaimSoleSeparate(this, '2', 'Op');" onchange="getPartyClaimSoleSeparate(this, '2', 'Op');" <?php if(isset($drvehicles->Op_Vehicle_SoleSeparate_Claim2) && $drvehicles->Op_Vehicle_SoleSeparate_Claim2=='No'){ echo "checked"; } ?>> No</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 Op_Vehicle_Owned2_Div" id="Op_Vehicle_SoleSeparate_Party2_Div" style="display: none;">
                                    <label>Who claims to own this vehicle?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Op_Vehicle_SoleSeparate_Party2_Client" name="Op_Vehicle_SoleSeparate_Party2" value="{{$client_name}}" <?php if(isset($drvehicles->Op_Vehicle_SoleSeparate_Party2) && $drvehicles->Op_Vehicle_SoleSeparate_Party2==$client_name){ echo "checked"; } ?>> {{$client_name}}</label>
                                        <label><input type="radio" id="Op_Vehicle_SoleSeparate_Party2_Op" name="Op_Vehicle_SoleSeparate_Party2" value="{{$opponent_name}}" <?php if(isset($drvehicles->Op_Vehicle_SoleSeparate_Party2) && $drvehicles->Op_Vehicle_SoleSeparate_Party2==$opponent_name){ echo "checked"; } ?>> {{$opponent_name}}</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 Op_Vehicle_Owned2_Div" id="Op_Vehicle_SoleSeparate_Grounds2_Div" style="display: none;">
                                    <label for="Op_Vehicle_SoleSeparate_Grounds2">Why does this person own this vehicle solely and separately?</label>
                                    <input id="Op_Vehicle_SoleSeparate_Grounds2" type="text" class="form-control 2_Op_vehicles_inputs" name="Op_Vehicle_SoleSeparate_Grounds2" value="<?php if(isset($drvehicles->Op_Vehicle_SoleSeparate_Grounds2)){ echo $drvehicles->Op_Vehicle_SoleSeparate_Grounds2; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6 Op_Vehicle_Owned2_Div">
                                    <label>How will this vehicle value be distributed between the parties?</label>
                                    <div class="w-100 dataInput">
                                        <label><input type="radio" id="Op_Vehicle_Disposition_Method2_Liquidate_Split_Net_Value" name="Op_Vehicle_Disposition_Method2" value="Liquidate/Split Net Value" data-onload="getInitialDipositionMethod(this, '2', 'Op');" onchange="getDipositionMethod(this, '2', 'Op');" <?php if(isset($drvehicles->Op_Vehicle_Disposition_Method2) && $drvehicles->Op_Vehicle_Disposition_Method2=='Liquidate/Split Net Value'){ echo "checked"; } ?>> Liquidate/Split Net Value</label>
                                        <label><input type="radio" id="Op_Vehicle_Disposition_Method2_Fixed_Buyout" name="Op_Vehicle_Disposition_Method2" value="Fixed Buyout" data-onload="getInitialDipositionMethod(this, '2', 'Op');" onchange="getDipositionMethod(this, '2', 'Op');" <?php if(isset($drvehicles->Op_Vehicle_Disposition_Method2) && $drvehicles->Op_Vehicle_Disposition_Method2=='Fixed Buyout'){ echo "checked"; } ?>> Fixed Buyout</label>
                                    </div>
                                </div>
                                <!-- slider tool -->
                                <div class="form-group col-sm-6 m-auto 2_Op_Slider_Tool Op_Vehicle_Owned2_Div">
                                    <div class="row">
                                        <div class="col">{{$client_name}}</div>
                                        <div class="col text-right">{{$opponent_name}}</div>
                                    </div>
                                    <input id="2_Op_balance_range_selector" type="range" class="form-control slider-tool-input 2_Op_balance_range_selector" name="" value="<?php if(isset($drvehicles->Op_Vehicle_Percent_Marital_Equity_to_Op2)){ echo $drvehicles->Op_Vehicle_Percent_Marital_Equity_to_Op2; } ?>" min="0.00" step="0.01" max="100" onchange="updateBalanceInput(this.value, '2', 'Op');">
                                </div>
                                <div class="form-group col-sm-6 m-auto 2_Op_Slider_Tool Op_Vehicle_Owned2_Div">
                                    <div class="row justify-content-between">
                                        <div class="col selectorTool">
                                            <div class="left-col">
                                                <div class="client-info 2_Op_clientpercentage_div clientpercentage_div">
                                                    <?php if(isset($drvehicles->Op_Vehicle_Percent_Marital_Equity_to_Client2)){ echo $drvehicles->Op_Vehicle_Percent_Marital_Equity_to_Client2; } else {
                                                        echo '50.00';
                                                    } ?>%
                                                </div>
                                                <div class="client-info 2_Op_clientamount_div clientamount_div" style="clear: both;">
                                                    $<?php if(isset($drvehicles->Op_Vehicle_Estimated_Value_to_Client2)){ echo $drvehicles->Op_Vehicle_Estimated_Value_to_Client2; } else {
                                                        echo '50.00';
                                                    } ?>
                                                </div>
                                            </div>
                                            <label>To {{$client_name}}</label>
                                        </div>                                       
                                        <div class="col selectorTool selectorToolRight">
                                            <label>To {{$opponent_name}}</label>
                                            <div class="left-col right-col">
                                                <div class="client-info 2_Op_opponentpercentage_div opponentpercentage_div">
                                                    <?php if(isset($drvehicles->Op_Vehicle_Percent_Marital_Equity_to_Op2)){ echo $drvehicles->Op_Vehicle_Percent_Marital_Equity_to_Op2; } else {
                                                        echo '50.00';
                                                    } ?>%
                                                </div>
                                                <div class="client-info 2_Op_opponentamount_div opponentamount_div" style="clear: both;">
                                                    $<?php if(isset($drvehicles->Op_Vehicle_Estimated_Value_to_Op2)){ echo $drvehicles->Op_Vehicle_Estimated_Value_to_Op2; } else {
                                                        echo '50.00';
                                                    } ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 m-auto 2_Op_Slider_Tool Op_Vehicle_Owned2_Div">
                                    <label></label>
                                    <div class="w-100">
                                        <label><input type="radio" id="2_Op_Vehicle_Estimated_Value_Select" name="2_Op_Vehicle_Estimated_Value_Select_Reset" class="Vehicle_Estimated_Value_Select_Reset" value="Save"> Save this Distribution of Vehicles #2</label>
                                        <label><input type="radio" id="2_Op_Vehicle_Estimated_Value_Reset" name="2_Op_Vehicle_Estimated_Value_Select_Reset" class="Vehicle_Estimated_Value_Select_Reset" value="Reset" onclick="resetBalanceInput(this, '2', 'Op');"> Reset to Default (50%)</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 Op_Vehicle_Owned2_Div Op_Vehicle_Paying_Party2_Inputs_Div" style="display: none;">
                                    <label>Op Vehicles Paying Party2</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Op_Vehicle_Paying_Party2_Client" name="Op_Vehicle_Paying_Party2" value="{{$client_name}}" data-onload="getInitialVehiclesPayingParty(this, '2', 'Op');" onchange="getVehiclesPayingParty(this, '2', 'Op');" <?php if(isset($drvehicles->Op_Vehicle_Paying_Party2) && $drvehicles->Op_Vehicle_Paying_Party2==$client_name){ echo "checked"; } ?>> {{$client_name}}</label>
                                        <label><input type="radio" id="Op_Vehicle_Paying_Party2_Op" name="Op_Vehicle_Paying_Party2" value="{{$opponent_name}}" data-onload="getInitialVehiclesPayingParty(this, '2', 'Op');" onchange="getVehiclesPayingParty(this, '2', 'Op');" <?php if(isset($drvehicles->Op_Vehicle_Paying_Party2) && $drvehicles->Op_Vehicle_Paying_Party2==$opponent_name){ echo "checked"; } ?>> {{$opponent_name}}</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 Op_Vehicle_Owned2_Div Op_Vehicle_Paying_Party2_Inputs_Div" style="display: none;">
                                    <label>{{$client_name}} Vehicles Equity Percent</label>
                                    <input id="Op_Vehicle_Percent_Marital_Equity_to_Client2" type="number" class="form-control 2_Op_clientpercentage_input clientpercentage_input" name="Op_Vehicle_Percent_Marital_Equity_to_Client2" value="<?php if(isset($drvehicles->Op_Vehicle_Percent_Marital_Equity_to_Client2)){ echo $drvehicles->Op_Vehicle_Percent_Marital_Equity_to_Client2; } ?>" min="0.00" step="0.01" max="100" readonly="">
                                </div>
                                <div class="form-group col-sm-6 Op_Vehicle_Owned2_Div Op_Vehicle_Paying_Party2_Inputs_Div" style="display: none;">
                                    <label>How much is to be paid to {{$client_name}}?</label>
                                    <input id="Op_Vehicle_Estimated_Value_to_Client2" type="number" class="form-control 2_Op_clientamount_input clientamount_input" name="Op_Vehicle_Estimated_Value_to_Client2" value="<?php if(isset($drvehicles->Op_Vehicle_Estimated_Value_to_Client2)){ echo $drvehicles->Op_Vehicle_Estimated_Value_to_Client2; } ?>" min="0.00" step="0.01" max="999999.99" readonly="" onchange="getEstimatedValueClient(this, '2', 'Op');" onkeyup="getEstimatedValueClient(this, '2', 'Op');">
                                </div>
                                <div class="form-group col-sm-6 Op_Vehicle_Owned2_Div Op_Vehicle_Paying_Party2_Inputs_Div" style="display: none;">
                                    <label>{{$opponent_name}} Vehicles Equity Percent</label>
                                    <input id="Op_Vehicle_Percent_Marital_Equity_to_Op2" type="number" class="form-control 2_Op_opponentpercentage_input opponentpercentage_input" name="Op_Vehicle_Percent_Marital_Equity_to_Op2" value="<?php if(isset($drvehicles->Op_Vehicle_Percent_Marital_Equity_to_Op2)){ echo $drvehicles->Op_Vehicle_Percent_Marital_Equity_to_Op2; } ?>" min="0.00" step="0.01" max="100" readonly="">
                                </div>
                                <div class="form-group col-sm-6 Op_Vehicle_Owned2_Div Op_Vehicle_Paying_Party2_Inputs_Div" style="display: none;">
                                    <label>How much is to be paid to {{$opponent_name}}?</label>
                                    <input id="Op_Vehicle_Estimated_Value_to_Op2" type="number" class="form-control 2_Op_opponentamount_input opponentamount_input" name="Op_Vehicle_Estimated_Value_to_Op2" value="<?php if(isset($drvehicles->Op_Vehicle_Estimated_Value_to_Op2)){ echo $drvehicles->Op_Vehicle_Estimated_Value_to_Op2; } ?>" min="0.00" step="0.01" max="999999.99" readonly="" onchange="getEstimatedValueOp(this, '2', 'Op');" onkeyup="getEstimatedValueOp(this, '2', 'Op');">
                                </div>
                                <!-- end of slider tool -->
                                <div class="form-group col-sm-6 Op_Vehicle_Paying_Party2_Leased_Div" style="display: none;">
                                    <label for="Op_Vehicle_Lease_Company2">Name of vehicle lease company?</label>
                                    <input id="Op_Vehicle_Lease_Company2" type="text" class="form-control 2_Op_vehicles_inputs Op_Vehicle_Paying_Party2_Leased_Input" name="Op_Vehicle_Lease_Company2" value="<?php if(isset($drvehicles->Op_Vehicle_Lease_Company2)){ echo $drvehicles->Op_Vehicle_Lease_Company2; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6 Op_Vehicle_Paying_Party2_Leased_Div" style="display: none;">
                                    <label>Monthly lease payment for this vehicle?</label>
                                    <input id="Op_Vehicle_Monthly_Lease_Amount2" type="number" class="form-control 2_Op_vehicles_inputs Op_Vehicle_Paying_Party2_Leased_Input" name="Op_Vehicle_Monthly_Lease_Amount2" value="<?php if(isset($drvehicles->Op_Vehicle_Monthly_Lease_Amount2)){ echo $drvehicles->Op_Vehicle_Monthly_Lease_Amount2; } ?>" min="0.00" step="0.01" max="999999.99">
                                </div>
                                <div class="form-group col-sm-6 Op_Vehicle_Paying_Party2_Leased_Div" style="display: none;">
                                    <label>How will this leased vehicle be handled?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Op_Vehicle_Lease_Disposition_Method2_Terminate_Lease" name="Op_Vehicle_Lease_Disposition_Method2" value="Terminate Lease" <?php if(isset($drvehicles->Op_Vehicle_Lease_Disposition_Method2) && $drvehicles->Op_Vehicle_Lease_Disposition_Method2=='Terminate Lease'){ echo "checked"; } ?>> Terminate Lease</label>
                                        <label><input type="radio" id="Op_Vehicle_Lease_Disposition_Method2_Transfer_Lease_Responsibility_to_ClientName" name="Op_Vehicle_Lease_Disposition_Method2" value="Transfer Lease Responsibility to {{$client_name}}" <?php if(isset($drvehicles->Op_Vehicle_Lease_Disposition_Method2) && $drvehicles->Op_Vehicle_Lease_Disposition_Method2=='Transfer Lease Responsibility to '.$client_name.''){ echo "checked"; } ?>> Transfer Lease Responsibility to {{$client_name}}</label>
                                        <label><input type="radio" id="Op_Vehicle_Lease_Disposition_Method2_Transfer_Lease_Responsibility_to_OpName" name="Op_Vehicle_Lease_Disposition_Method2" value="Transfer Lease Responsibility to {{$opponent_name}}" <?php if(isset($drvehicles->Op_Vehicle_Lease_Disposition_Method2) && $drvehicles->Op_Vehicle_Lease_Disposition_Method2=='Transfer Lease Responsibility to '.$opponent_name.''){ echo "checked"; } ?>> Transfer Lease Responsibility to {{$opponent_name}}</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 mt-4 3_Op_vehicles_section" style="display: none;"><h5 class="col-sm-12">Third Vehicle Info</h5>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Vehicle_Year3">Model year of this vehicle?</label>
                                    <select id="Op_Vehicle_Year3" name="Op_Vehicle_Year3" class="form-control 3_Op_vehicles_select">
                                        <?php 
                                            if(isset($drvehicles->Op_Vehicle_Year3)){ 
                                                $already_selected_value = $drvehicles->Op_Vehicle_Year3; 
                                            } else {
                                                $already_selected_value = '';
                                            }
                                            $earliest_year = 1900;
                                            foreach (range(date('Y'), $earliest_year) as $x) {
                                                echo '<option value="'.$x.'"'.($x == $already_selected_value ? ' selected="selected"' : '').'>'.$x.'</option>';
                                            }
                                        ?>
                                    </select>   
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Vehicle_Make_Model3">What make and model is this vehicle?</label>
                                    <input id="Op_Vehicle_Make_Model3" type="text" class="form-control 3_Op_vehicles_inputs" name="Op_Vehicle_Make_Model3" value="<?php if(isset($drvehicles->Op_Vehicle_Make_Model3)){ echo $drvehicles->Op_Vehicle_Make_Model3; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Is this vehicle leased or owned?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Op_Vehicle_Owned_Leased3_Owned" name="Op_Vehicle_Owned_Leased3" value="Owned" data-onload="getInitialVehicleOwnedLeased(this, '3', 'Op');" onchange="getVehicleOwnedLeased(this, '3', 'Op');" <?php if(isset($drvehicles->Op_Vehicle_Owned_Leased3) && $drvehicles->Op_Vehicle_Owned_Leased3=='Owned'){ echo "checked"; } ?>> Owned</label>
                                        <label><input type="radio" id="Op_Vehicle_Owned_Leased3_Leased" name="Op_Vehicle_Owned_Leased3" value="Leased" data-onload="getInitialVehicleOwnedLeased(this, '3', 'Op');" onchange="getVehicleOwnedLeased(this, '3', 'Op');" <?php if(isset($drvehicles->Op_Vehicle_Owned_Leased3) && $drvehicles->Op_Vehicle_Owned_Leased3=='Leased'){ echo "checked"; } ?>> Leased</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 Op_Vehicle_Owned3_Div">
                                    <label for="Op_Vehicle_VIN3">What is the VIN of this vehicle?</label>
                                    <input id="Op_Vehicle_VIN3" type="text" class="form-control 3_Op_vehicles_inputs" name="Op_Vehicle_VIN3" value="<?php if(isset($drvehicles->Op_Vehicle_VIN3)){ echo $drvehicles->Op_Vehicle_VIN3; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6 Op_Vehicle_Owned3_Div">
                                    <label for="Op_Vehicle_Current_Value3">What is the current value of this vehicle?</label>
                                    <input id="Op_Vehicle_Current_Value3" type="number" class="form-control 3_Op_vehicles_inputs" name="Op_Vehicle_Current_Value3" value="<?php if(isset($drvehicles->Op_Vehicle_Current_Value3)){ echo $drvehicles->Op_Vehicle_Current_Value3; } ?>" min="0.00" step="0.01" max="999999.99" onchange="getCurrentValue(this, '3', 'Op');" onkeyup="getCurrentValue(this, '3', 'Op');">
                                </div>
                                <div class="form-group col-sm-6 Op_Vehicle_Owned3_Div">
                                    <label for="Op_Vehicle_Loan_Company_Name3">Name of first car loan company?</label>
                                    <input id="Op_Vehicle_Loan_Company_Name3" type="text" class="form-control 3_Op_vehicles_inputs" name="Op_Vehicle_Loan_Company_Name3" value="<?php if(isset($drvehicles->Op_Vehicle_Loan_Company_Name3)){ echo $drvehicles->Op_Vehicle_Loan_Company_Name3; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6 Op_Vehicle_Owned3_Div">
                                    <label for="Op_Vehicle_Loan_Balance3">Balance due to first car loan company for this vehicle?</label>
                                    <input id="Op_Vehicle_Loan_Balance3" type="number" class="form-control 3_Op_vehicles_inputs" name="Op_Vehicle_Loan_Balance3" value="<?php if(isset($drvehicles->Op_Vehicle_Loan_Balance3)){ echo $drvehicles->Op_Vehicle_Loan_Balance3; } ?>" min="0.00" step="0.01" max="999999.99" onchange="getLoanBalance(this, '3', 'Op');" onkeyup="getLoanBalance(this, '3', 'Op');">
                                </div>
                                <div class="form-group col-sm-6 Op_Vehicle_Owned3_Div">
                                    <label for="Op_Vehicle_Loan_Monthly_Payment3">Monthly payment to first car loan company for this vehicle?</label>
                                    <input id="Op_Vehicle_Loan_Monthly_Payment3" type="number" class="form-control 3_Op_vehicles_inputs" name="Op_Vehicle_Loan_Monthly_Payment3" value="<?php if(isset($drvehicles->Op_Vehicle_Loan_Monthly_Payment3)){ echo $drvehicles->Op_Vehicle_Loan_Monthly_Payment3; } ?>" min="0.00" step="0.01" max="999999.99">
                                </div>
                                <div class="form-group col-sm-6 Op_Vehicle_Owned3_Div">
                                    <label for="Op_Vehicle_Loan_Second_Company_Name3">Name of second car loan company?</label>
                                    <input id="Op_Vehicle_Loan_Second_Company_Name3" type="text" class="form-control 3_Op_vehicles_inputs" name="Op_Vehicle_Loan_Second_Company_Name3" value="<?php if(isset($drvehicles->Op_Vehicle_Loan_Second_Company_Name3)){ echo $drvehicles->Op_Vehicle_Loan_Second_Company_Name3; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6 Op_Vehicle_Owned3_Div">
                                    <label for="Op_Vehicle_Loan_Second_Company_Balance3">Balance due to second car loan company for this vehicle?</label>
                                    <input id="Op_Vehicle_Loan_Second_Company_Balance3" type="number" class="form-control 3_Op_vehicles_inputs" name="Op_Vehicle_Loan_Second_Company_Balance3" value="<?php if(isset($drvehicles->Op_Vehicle_Loan_Second_Company_Balance3)){ echo $drvehicles->Op_Vehicle_Loan_Second_Company_Balance3; } ?>" min="0.00" step="0.01" max="999999.99" onchange="getCompanyBalance(this, '3', 'Op');" onkeyup="getCompanyBalance(this, '3', 'Op');">
                                </div>
                                <div class="form-group col-sm-6 Op_Vehicle_Owned3_Div">
                                    <label for="Op_Vehicle_Loan_Second_Company_Monthly_Payment3">Monthly payment to second car loan company for this vehicle?</label>
                                    <input id="Op_Vehicle_Loan_Second_Company_Monthly_Payment3" type="number" class="form-control 3_Op_vehicles_inputs" name="Op_Vehicle_Loan_Second_Company_Monthly_Payment3" value="<?php if(isset($drvehicles->Op_Vehicle_Loan_Second_Company_Monthly_Payment3)){ echo $drvehicles->Op_Vehicle_Loan_Second_Company_Monthly_Payment3; } ?>" min="0.00" step="0.01" max="999999.99">
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label for="Op_Vehicle_Marital_Equity3">N/A, calculated = Op_Vehicle_Current_Value3-Op_Vehicle_Loan_Balance3-Op_Vehicle_Loan_Second_Company_Balance3</label>
                                    <input id="Op_Vehicle_Marital_Equity3" type="number" class="form-control 3_Op_vehicles_inputs" name="Op_Vehicle_Marital_Equity3" value="<?php if(isset($drvehicles->Op_Vehicle_Marital_Equity3)){ echo $drvehicles->Op_Vehicle_Marital_Equity3; } ?>" min="0.00" step="0.01" max="999999.99">
                                </div>
                                <div class="form-group col-sm-6 Op_Vehicle_Owned3_Div">
                                    <label>Does either party claim a sole/separate interest in this vehicle?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Op_Vehicle_SoleSeparate_Claim3_Yes" name="Op_Vehicle_SoleSeparate_Claim3" value="Yes" data-onload="getInitialPartyClaimSoleSeparate(this, '3', 'Op');" onchange="getPartyClaimSoleSeparate(this, '3', 'Op');" <?php if(isset($drvehicles->Op_Vehicle_SoleSeparate_Claim3) && $drvehicles->Op_Vehicle_SoleSeparate_Claim3=='Yes'){ echo "checked"; } ?>> Yes</label>
                                        <label><input type="radio" id="Op_Vehicle_SoleSeparate_Claim3_No" name="Op_Vehicle_SoleSeparate_Claim3" value="No" data-onload="getInitialPartyClaimSoleSeparate(this, '3', 'Op');" onchange="getPartyClaimSoleSeparate(this, '3', 'Op');" <?php if(isset($drvehicles->Op_Vehicle_SoleSeparate_Claim3) && $drvehicles->Op_Vehicle_SoleSeparate_Claim3=='No'){ echo "checked"; } ?>> No</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 Op_Vehicle_Owned3_Div" id="Op_Vehicle_SoleSeparate_Party3_Div" style="display: none;">
                                    <label>Who claims to own this vehicle?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Op_Vehicle_SoleSeparate_Party3_Client" name="Op_Vehicle_SoleSeparate_Party3" value="{{$client_name}}" <?php if(isset($drvehicles->Op_Vehicle_SoleSeparate_Party3) && $drvehicles->Op_Vehicle_SoleSeparate_Party3==$client_name){ echo "checked"; } ?>> {{$client_name}}</label>
                                        <label><input type="radio" id="Op_Vehicle_SoleSeparate_Party3_Op" name="Op_Vehicle_SoleSeparate_Party3" value="{{$opponent_name}}" <?php if(isset($drvehicles->Op_Vehicle_SoleSeparate_Party3) && $drvehicles->Op_Vehicle_SoleSeparate_Party3==$opponent_name){ echo "checked"; } ?>> {{$opponent_name}}</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 Op_Vehicle_Owned3_Div" id="Op_Vehicle_SoleSeparate_Grounds3_Div" style="display: none;">
                                    <label for="Op_Vehicle_SoleSeparate_Grounds3">Why does this person own this vehicle solely and separately?</label>
                                    <input id="Op_Vehicle_SoleSeparate_Grounds3" type="text" class="form-control 3_Op_vehicles_inputs" name="Op_Vehicle_SoleSeparate_Grounds3" value="<?php if(isset($drvehicles->Op_Vehicle_SoleSeparate_Grounds3)){ echo $drvehicles->Op_Vehicle_SoleSeparate_Grounds3; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6 Op_Vehicle_Owned3_Div">
                                    <label>How will this vehicle value be distributed between the parties?</label>
                                    <div class="w-100 dataInput">
                                        <label><input type="radio" id="Op_Vehicle_Disposition_Method3_Liquidate_Split_Net_Value" name="Op_Vehicle_Disposition_Method3" value="Liquidate/Split Net Value" data-onload="getInitialDipositionMethod(this, '3', 'Op');" onchange="getDipositionMethod(this, '3', 'Op');" <?php if(isset($drvehicles->Op_Vehicle_Disposition_Method3) && $drvehicles->Op_Vehicle_Disposition_Method3=='Liquidate/Split Net Value'){ echo "checked"; } ?>> Liquidate/Split Net Value</label>
                                        <label><input type="radio" id="Op_Vehicle_Disposition_Method3_Fixed_Buyout" name="Op_Vehicle_Disposition_Method3" value="Fixed Buyout" data-onload="getInitialDipositionMethod(this, '3', 'Op');" onchange="getDipositionMethod(this, '3', 'Op');" <?php if(isset($drvehicles->Op_Vehicle_Disposition_Method3) && $drvehicles->Op_Vehicle_Disposition_Method3=='Fixed Buyout'){ echo "checked"; } ?>> Fixed Buyout</label>
                                    </div>
                                </div>
                                <!-- slider tool -->
                                <div class="form-group col-sm-6 m-auto 3_Op_Slider_Tool Op_Vehicle_Owned3_Div">
                                    <div class="row">
                                        <div class="col">{{$client_name}}</div>
                                        <div class="col text-right">{{$opponent_name}}</div>
                                    </div>
                                    <input id="3_Op_balance_range_selector" type="range" class="form-control slider-tool-input 3_Op_balance_range_selector" name="" value="<?php if(isset($drvehicles->Op_Vehicle_Percent_Marital_Equity_to_Op3)){ echo $drvehicles->Op_Vehicle_Percent_Marital_Equity_to_Op3; } ?>" min="0.00" step="0.01" max="100" onchange="updateBalanceInput(this.value, '3', 'Op');">
                                </div>
                                <div class="form-group col-sm-6 m-auto 3_Op_Slider_Tool Op_Vehicle_Owned3_Div">
                                    <div class="row justify-content-between">
                                        <div class="col selectorTool">
                                            <div class="left-col">
                                                <div class="client-info 3_Op_clientpercentage_div clientpercentage_div">
                                                    <?php if(isset($drvehicles->Op_Vehicle_Percent_Marital_Equity_to_Client3)){ echo $drvehicles->Op_Vehicle_Percent_Marital_Equity_to_Client3; } else {
                                                        echo '50.00';
                                                    } ?>%
                                                </div>
                                                <div class="client-info 3_Op_clientamount_div clientamount_div" style="clear: both;">
                                                    $<?php if(isset($drvehicles->Op_Vehicle_Estimated_Value_to_Client3)){ echo $drvehicles->Op_Vehicle_Estimated_Value_to_Client3; } else {
                                                        echo '50.00';
                                                    } ?>
                                                </div>
                                            </div>
                                            <label>To {{$client_name}}</label>
                                        </div>                                       
                                        <div class="col selectorTool selectorToolRight">
                                            <label>To {{$opponent_name}}</label>
                                            <div class="left-col right-col">
                                                <div class="client-info 3_Op_opponentpercentage_div opponentpercentage_div">
                                                    <?php if(isset($drvehicles->Op_Vehicle_Percent_Marital_Equity_to_Op3)){ echo $drvehicles->Op_Vehicle_Percent_Marital_Equity_to_Op3; } else {
                                                        echo '50.00';
                                                    } ?>%
                                                </div>
                                                <div class="client-info 3_Op_opponentamount_div opponentamount_div" style="clear: both;">
                                                    $<?php if(isset($drvehicles->Op_Vehicle_Estimated_Value_to_Op3)){ echo $drvehicles->Op_Vehicle_Estimated_Value_to_Op3; } else {
                                                        echo '50.00';
                                                    } ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 m-auto 3_Op_Slider_Tool Op_Vehicle_Owned3_Div">
                                    <label></label>
                                    <div class="w-100">
                                        <label><input type="radio" id="3_Op_Vehicle_Estimated_Value_Select" name="3_Op_Vehicle_Estimated_Value_Select_Reset" class="Vehicle_Estimated_Value_Select_Reset" value="Save"> Save this Distribution of Vehicles #3</label>
                                        <label><input type="radio" id="3_Op_Vehicle_Estimated_Value_Reset" name="3_Op_Vehicle_Estimated_Value_Select_Reset" class="Vehicle_Estimated_Value_Select_Reset" value="Reset" onclick="resetBalanceInput(this, '3', 'Op');"> Reset to Default (50%)</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 Op_Vehicle_Owned3_Div Op_Vehicle_Paying_Party3_Inputs_Div" style="display: none;">
                                    <label>Op Vehicles Paying Party3</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Op_Vehicle_Paying_Party3_Client" name="Op_Vehicle_Paying_Party3" value="{{$client_name}}" data-onload="getInitialVehiclesPayingParty(this, '3', 'Op');" onchange="getVehiclesPayingParty(this, '3', 'Op');" <?php if(isset($drvehicles->Op_Vehicle_Paying_Party3) && $drvehicles->Op_Vehicle_Paying_Party3==$client_name){ echo "checked"; } ?>> {{$client_name}}</label>
                                        <label><input type="radio" id="Op_Vehicle_Paying_Party3_Op" name="Op_Vehicle_Paying_Party3" value="{{$opponent_name}}" data-onload="getInitialVehiclesPayingParty(this, '3', 'Op');" onchange="getVehiclesPayingParty(this, '3', 'Op');" <?php if(isset($drvehicles->Op_Vehicle_Paying_Party3) && $drvehicles->Op_Vehicle_Paying_Party3==$opponent_name){ echo "checked"; } ?>> {{$opponent_name}}</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 Op_Vehicle_Owned3_Div Op_Vehicle_Paying_Party3_Inputs_Div" style="display: none;">
                                    <label>{{$client_name}} Vehicles Equity Percent</label>
                                    <input id="Op_Vehicle_Percent_Marital_Equity_to_Client3" type="number" class="form-control 3_Op_clientpercentage_input clientpercentage_input" name="Op_Vehicle_Percent_Marital_Equity_to_Client3" value="<?php if(isset($drvehicles->Op_Vehicle_Percent_Marital_Equity_to_Client3)){ echo $drvehicles->Op_Vehicle_Percent_Marital_Equity_to_Client3; } ?>" min="0.00" step="0.01" max="100" readonly="">
                                </div>
                                <div class="form-group col-sm-6 Op_Vehicle_Owned3_Div Op_Vehicle_Paying_Party3_Inputs_Div" style="display: none;">
                                    <label>How much is to be paid to {{$client_name}}?</label>
                                    <input id="Op_Vehicle_Estimated_Value_to_Client3" type="number" class="form-control 3_Op_clientamount_input clientamount_input" name="Op_Vehicle_Estimated_Value_to_Client3" value="<?php if(isset($drvehicles->Op_Vehicle_Estimated_Value_to_Client3)){ echo $drvehicles->Op_Vehicle_Estimated_Value_to_Client3; } ?>" min="0.00" step="0.01" max="999999.99" readonly="" onchange="getEstimatedValueClient(this, '3', 'Op');" onkeyup="getEstimatedValueClient(this, '3', 'Op');">
                                </div>
                                <div class="form-group col-sm-6 Op_Vehicle_Owned3_Div Op_Vehicle_Paying_Party3_Inputs_Div" style="display: none;">
                                    <label>{{$opponent_name}} Vehicles Equity Percent</label>
                                    <input id="Op_Vehicle_Percent_Marital_Equity_to_Op3" type="number" class="form-control 3_Op_opponentpercentage_input opponentpercentage_input" name="Op_Vehicle_Percent_Marital_Equity_to_Op3" value="<?php if(isset($drvehicles->Op_Vehicle_Percent_Marital_Equity_to_Op3)){ echo $drvehicles->Op_Vehicle_Percent_Marital_Equity_to_Op3; } ?>" min="0.00" step="0.01" max="100" readonly="">
                                </div>
                                <div class="form-group col-sm-6 Op_Vehicle_Owned3_Div Op_Vehicle_Paying_Party3_Inputs_Div" style="display: none;">
                                    <label>How much is to be paid to {{$opponent_name}}?</label>
                                    <input id="Op_Vehicle_Estimated_Value_to_Op3" type="number" class="form-control 3_Op_opponentamount_input opponentamount_input" name="Op_Vehicle_Estimated_Value_to_Op3" value="<?php if(isset($drvehicles->Op_Vehicle_Estimated_Value_to_Op3)){ echo $drvehicles->Op_Vehicle_Estimated_Value_to_Op3; } ?>" min="0.00" step="0.01" max="999999.99" readonly="" onchange="getEstimatedValueOp(this, '3', 'Op');" onkeyup="getEstimatedValueOp(this, '3', 'Op');">
                                </div>
                                <!-- end of slider tool -->
                                <div class="form-group col-sm-6 Op_Vehicle_Paying_Party3_Leased_Div" style="display: none;">
                                    <label for="Op_Vehicle_Lease_Company3">Name of vehicle lease company?</label>
                                    <input id="Op_Vehicle_Lease_Company3" type="text" class="form-control 3_Op_vehicles_inputs Op_Vehicle_Paying_Party3_Leased_Input" name="Op_Vehicle_Lease_Company3" value="<?php if(isset($drvehicles->Op_Vehicle_Lease_Company3)){ echo $drvehicles->Op_Vehicle_Lease_Company3; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6 Op_Vehicle_Paying_Party3_Leased_Div" style="display: none;">
                                    <label>Monthly lease payment for this vehicle?</label>
                                    <input id="Op_Vehicle_Monthly_Lease_Amount3" type="number" class="form-control 3_Op_vehicles_inputs Op_Vehicle_Paying_Party3_Leased_Input" name="Op_Vehicle_Monthly_Lease_Amount3" value="<?php if(isset($drvehicles->Op_Vehicle_Monthly_Lease_Amount3)){ echo $drvehicles->Op_Vehicle_Monthly_Lease_Amount3; } ?>" min="0.00" step="0.01" max="999999.99">
                                </div>
                                <div class="form-group col-sm-6 Op_Vehicle_Paying_Party3_Leased_Div" style="display: none;">
                                    <label>How will this leased vehicle be handled?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Op_Vehicle_Lease_Disposition_Method3_Terminate_Lease" name="Op_Vehicle_Lease_Disposition_Method3" value="Terminate Lease" <?php if(isset($drvehicles->Op_Vehicle_Lease_Disposition_Method3) && $drvehicles->Op_Vehicle_Lease_Disposition_Method3=='Terminate Lease'){ echo "checked"; } ?>> Terminate Lease</label>
                                        <label><input type="radio" id="Op_Vehicle_Lease_Disposition_Method3_Transfer_Lease_Responsibility_to_ClientName" name="Op_Vehicle_Lease_Disposition_Method3" value="Transfer Lease Responsibility to {{$client_name}}" <?php if(isset($drvehicles->Op_Vehicle_Lease_Disposition_Method3) && $drvehicles->Op_Vehicle_Lease_Disposition_Method3=='Transfer Lease Responsibility to '.$client_name.''){ echo "checked"; } ?>> Transfer Lease Responsibility to {{$client_name}}</label>
                                        <label><input type="radio" id="Op_Vehicle_Lease_Disposition_Method3_Transfer_Lease_Responsibility_to_OpName" name="Op_Vehicle_Lease_Disposition_Method3" value="Transfer Lease Responsibility to {{$opponent_name}}" <?php if(isset($drvehicles->Op_Vehicle_Lease_Disposition_Method3) && $drvehicles->Op_Vehicle_Lease_Disposition_Method3=='Transfer Lease Responsibility to '.$opponent_name.''){ echo "checked"; } ?>> Transfer Lease Responsibility to {{$opponent_name}}</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 mt-4 4_Op_vehicles_section" style="display: none;"><h5 class="col-sm-12">Fourth Vehicle Info</h5>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Vehicle_Year4">Model year of this vehicle?</label>
                                    <select id="Op_Vehicle_Year4" name="Op_Vehicle_Year4" class="form-control 4_Op_vehicles_select">
                                        <?php 
                                            if(isset($drvehicles->Op_Vehicle_Year4)){ 
                                                $already_selected_value = $drvehicles->Op_Vehicle_Year4; 
                                            } else {
                                                $already_selected_value = '';
                                            }
                                            $earliest_year = 1900;
                                            foreach (range(date('Y'), $earliest_year) as $x) {
                                                echo '<option value="'.$x.'"'.($x == $already_selected_value ? ' selected="selected"' : '').'>'.$x.'</option>';
                                            }
                                        ?>
                                    </select>   
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Vehicle_Make_Model4">What make and model is this vehicle?</label>
                                    <input id="Op_Vehicle_Make_Model4" type="text" class="form-control 4_Op_vehicles_inputs" name="Op_Vehicle_Make_Model4" value="<?php if(isset($drvehicles->Op_Vehicle_Make_Model4)){ echo $drvehicles->Op_Vehicle_Make_Model4; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Is this vehicle leased or owned?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Op_Vehicle_Owned_Leased4_Owned" name="Op_Vehicle_Owned_Leased4" value="Owned" data-onload="getInitialVehicleOwnedLeased(this, '4', 'Op');" onchange="getVehicleOwnedLeased(this, '4', 'Op');" <?php if(isset($drvehicles->Op_Vehicle_Owned_Leased4) && $drvehicles->Op_Vehicle_Owned_Leased4=='Owned'){ echo "checked"; } ?>> Owned</label>
                                        <label><input type="radio" id="Op_Vehicle_Owned_Leased4_Leased" name="Op_Vehicle_Owned_Leased4" value="Leased" data-onload="getInitialVehicleOwnedLeased(this, '4', 'Op');" onchange="getVehicleOwnedLeased(this, '4', 'Op');" <?php if(isset($drvehicles->Op_Vehicle_Owned_Leased4) && $drvehicles->Op_Vehicle_Owned_Leased4=='Leased'){ echo "checked"; } ?>> Leased</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 Op_Vehicle_Owned4_Div">
                                    <label for="Op_Vehicle_VIN4">What is the VIN of this vehicle?</label>
                                    <input id="Op_Vehicle_VIN4" type="text" class="form-control 4_Op_vehicles_inputs" name="Op_Vehicle_VIN4" value="<?php if(isset($drvehicles->Op_Vehicle_VIN4)){ echo $drvehicles->Op_Vehicle_VIN4; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6 Op_Vehicle_Owned4_Div">
                                    <label for="Op_Vehicle_Current_Value4">What is the current value of this vehicle?</label>
                                    <input id="Op_Vehicle_Current_Value4" type="number" class="form-control 4_Op_vehicles_inputs" name="Op_Vehicle_Current_Value4" value="<?php if(isset($drvehicles->Op_Vehicle_Current_Value4)){ echo $drvehicles->Op_Vehicle_Current_Value4; } ?>" min="0.00" step="0.01" max="999999.99" onchange="getCurrentValue(this, '4', 'Op');" onkeyup="getCurrentValue(this, '4', 'Op');">
                                </div>
                                <div class="form-group col-sm-6 Op_Vehicle_Owned4_Div">
                                    <label for="Op_Vehicle_Loan_Company_Name4">Name of first car loan company?</label>
                                    <input id="Op_Vehicle_Loan_Company_Name4" type="text" class="form-control 4_Op_vehicles_inputs" name="Op_Vehicle_Loan_Company_Name4" value="<?php if(isset($drvehicles->Op_Vehicle_Loan_Company_Name4)){ echo $drvehicles->Op_Vehicle_Loan_Company_Name4; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6 Op_Vehicle_Owned4_Div">
                                    <label for="Op_Vehicle_Loan_Balance4">Balance due to first car loan company for this vehicle?</label>
                                    <input id="Op_Vehicle_Loan_Balance4" type="number" class="form-control 4_Op_vehicles_inputs" name="Op_Vehicle_Loan_Balance4" value="<?php if(isset($drvehicles->Op_Vehicle_Loan_Balance4)){ echo $drvehicles->Op_Vehicle_Loan_Balance4; } ?>" min="0.00" step="0.01" max="999999.99" onchange="getLoanBalance(this, '4', 'Op');" onkeyup="getLoanBalance(this, '4', 'Op');">
                                </div>
                                <div class="form-group col-sm-6 Op_Vehicle_Owned4_Div">
                                    <label for="Op_Vehicle_Loan_Monthly_Payment4">Monthly payment to first car loan company for this vehicle?</label>
                                    <input id="Op_Vehicle_Loan_Monthly_Payment4" type="number" class="form-control 4_Op_vehicles_inputs" name="Op_Vehicle_Loan_Monthly_Payment4" value="<?php if(isset($drvehicles->Op_Vehicle_Loan_Monthly_Payment4)){ echo $drvehicles->Op_Vehicle_Loan_Monthly_Payment4; } ?>" min="0.00" step="0.01" max="999999.99">
                                </div>
                                <div class="form-group col-sm-6 Op_Vehicle_Owned4_Div">
                                    <label for="Op_Vehicle_Loan_Second_Company_Name4">Name of second car loan company?</label>
                                    <input id="Op_Vehicle_Loan_Second_Company_Name4" type="text" class="form-control 4_Op_vehicles_inputs" name="Op_Vehicle_Loan_Second_Company_Name4" value="<?php if(isset($drvehicles->Op_Vehicle_Loan_Second_Company_Name4)){ echo $drvehicles->Op_Vehicle_Loan_Second_Company_Name4; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6 Op_Vehicle_Owned4_Div">
                                    <label for="Op_Vehicle_Loan_Second_Company_Balance4">Balance due to second car loan company for this vehicle?</label>
                                    <input id="Op_Vehicle_Loan_Second_Company_Balance4" type="number" class="form-control 4_Op_vehicles_inputs" name="Op_Vehicle_Loan_Second_Company_Balance4" value="<?php if(isset($drvehicles->Op_Vehicle_Loan_Second_Company_Balance4)){ echo $drvehicles->Op_Vehicle_Loan_Second_Company_Balance4; } ?>" min="0.00" step="0.01" max="999999.99" onchange="getCompanyBalance(this, '4', 'Op');" onkeyup="getCompanyBalance(this, '4', 'Op');">
                                </div>
                                <div class="form-group col-sm-6 Op_Vehicle_Owned4_Div">
                                    <label for="Op_Vehicle_Loan_Second_Company_Monthly_Payment4">Monthly payment to second car loan company for this vehicle?</label>
                                    <input id="Op_Vehicle_Loan_Second_Company_Monthly_Payment4" type="number" class="form-control 4_Op_vehicles_inputs" name="Op_Vehicle_Loan_Second_Company_Monthly_Payment4" value="<?php if(isset($drvehicles->Op_Vehicle_Loan_Second_Company_Monthly_Payment4)){ echo $drvehicles->Op_Vehicle_Loan_Second_Company_Monthly_Payment4; } ?>" min="0.00" step="0.01" max="999999.99">
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label for="Op_Vehicle_Marital_Equity4">N/A, calculated = Op_Vehicle_Current_Value4-Op_Vehicle_Loan_Balance4-Op_Vehicle_Loan_Second_Company_Balance4</label>
                                    <input id="Op_Vehicle_Marital_Equity4" type="number" class="form-control 4_Op_vehicles_inputs" name="Op_Vehicle_Marital_Equity4" value="<?php if(isset($drvehicles->Op_Vehicle_Marital_Equity4)){ echo $drvehicles->Op_Vehicle_Marital_Equity4; } ?>" min="0.00" step="0.01" max="999999.99">
                                </div>
                                <div class="form-group col-sm-6 Op_Vehicle_Owned4_Div">
                                    <label>Does either party claim a sole/separate interest in this vehicle?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Op_Vehicle_SoleSeparate_Claim4_Yes" name="Op_Vehicle_SoleSeparate_Claim4" value="Yes" data-onload="getInitialPartyClaimSoleSeparate(this, '4', 'Op');" onchange="getPartyClaimSoleSeparate(this, '4', 'Op');" <?php if(isset($drvehicles->Op_Vehicle_SoleSeparate_Claim4) && $drvehicles->Op_Vehicle_SoleSeparate_Claim4=='Yes'){ echo "checked"; } ?>> Yes</label>
                                        <label><input type="radio" id="Op_Vehicle_SoleSeparate_Claim4_No" name="Op_Vehicle_SoleSeparate_Claim4" value="No" data-onload="getInitialPartyClaimSoleSeparate(this, '4', 'Op');" onchange="getPartyClaimSoleSeparate(this, '4', 'Op');" <?php if(isset($drvehicles->Op_Vehicle_SoleSeparate_Claim4) && $drvehicles->Op_Vehicle_SoleSeparate_Claim4=='No'){ echo "checked"; } ?>> No</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 Op_Vehicle_Owned4_Div" id="Op_Vehicle_SoleSeparate_Party4_Div" style="display: none;">
                                    <label>Who claims to own this vehicle?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Op_Vehicle_SoleSeparate_Party4_Client" name="Op_Vehicle_SoleSeparate_Party4" value="{{$client_name}}" <?php if(isset($drvehicles->Op_Vehicle_SoleSeparate_Party4) && $drvehicles->Op_Vehicle_SoleSeparate_Party4==$client_name){ echo "checked"; } ?>> {{$client_name}}</label>
                                        <label><input type="radio" id="Op_Vehicle_SoleSeparate_Party4_Op" name="Op_Vehicle_SoleSeparate_Party4" value="{{$opponent_name}}" <?php if(isset($drvehicles->Op_Vehicle_SoleSeparate_Party4) && $drvehicles->Op_Vehicle_SoleSeparate_Party4==$opponent_name){ echo "checked"; } ?>> {{$opponent_name}}</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 Op_Vehicle_Owned4_Div" id="Op_Vehicle_SoleSeparate_Grounds4_Div" style="display: none;">
                                    <label for="Op_Vehicle_SoleSeparate_Grounds4">Why does this person own this vehicle solely and separately?</label>
                                    <input id="Op_Vehicle_SoleSeparate_Grounds4" type="text" class="form-control 4_Op_vehicles_inputs" name="Op_Vehicle_SoleSeparate_Grounds4" value="<?php if(isset($drvehicles->Op_Vehicle_SoleSeparate_Grounds4)){ echo $drvehicles->Op_Vehicle_SoleSeparate_Grounds4; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6 Op_Vehicle_Owned4_Div">
                                    <label>How will this vehicle value be distributed between the parties?</label>
                                    <div class="w-100 dataInput">
                                        <label><input type="radio" id="Op_Vehicle_Disposition_Method4_Liquidate_Split_Net_Value" name="Op_Vehicle_Disposition_Method4" value="Liquidate/Split Net Value" data-onload="getInitialDipositionMethod(this, '4', 'Op');" onchange="getDipositionMethod(this, '4', 'Op');" <?php if(isset($drvehicles->Op_Vehicle_Disposition_Method4) && $drvehicles->Op_Vehicle_Disposition_Method4=='Liquidate/Split Net Value'){ echo "checked"; } ?>> Liquidate/Split Net Value</label>
                                        <label><input type="radio" id="Op_Vehicle_Disposition_Method4_Fixed_Buyout" name="Op_Vehicle_Disposition_Method4" value="Fixed Buyout" data-onload="getInitialDipositionMethod(this, '4', 'Op');" onchange="getDipositionMethod(this, '4', 'Op');" <?php if(isset($drvehicles->Op_Vehicle_Disposition_Method4) && $drvehicles->Op_Vehicle_Disposition_Method4=='Fixed Buyout'){ echo "checked"; } ?>> Fixed Buyout</label>
                                    </div>
                                </div>
                                <!-- slider tool -->
                                <div class="form-group col-sm-6 m-auto 4_Op_Slider_Tool Op_Vehicle_Owned4_Div">
                                    <div class="row">
                                        <div class="col">{{$client_name}}</div>
                                        <div class="col text-right">{{$opponent_name}}</div>
                                    </div>
                                    <input id="4_Op_balance_range_selector" type="range" class="form-control slider-tool-input 4_Op_balance_range_selector" name="" value="<?php if(isset($drvehicles->Op_Vehicle_Percent_Marital_Equity_to_Op4)){ echo $drvehicles->Op_Vehicle_Percent_Marital_Equity_to_Op4; } ?>" min="0.00" step="0.01" max="100" onchange="updateBalanceInput(this.value, '4', 'Op');">
                                </div>
                                <div class="form-group col-sm-6 m-auto 4_Op_Slider_Tool Op_Vehicle_Owned4_Div">
                                    <div class="row justify-content-between">
                                        <div class="col selectorTool">
                                            <div class="left-col">
                                                <div class="client-info 4_Op_clientpercentage_div clientpercentage_div">
                                                    <?php if(isset($drvehicles->Op_Vehicle_Percent_Marital_Equity_to_Client4)){ echo $drvehicles->Op_Vehicle_Percent_Marital_Equity_to_Client4; } else {
                                                        echo '50.00';
                                                    } ?>%
                                                </div>
                                                <div class="client-info 4_Op_clientamount_div clientamount_div" style="clear: both;">
                                                    $<?php if(isset($drvehicles->Op_Vehicle_Estimated_Value_to_Client4)){ echo $drvehicles->Op_Vehicle_Estimated_Value_to_Client4; } else {
                                                        echo '50.00';
                                                    } ?>
                                                </div>
                                            </div>
                                            <label>To {{$client_name}}</label>
                                        </div>                                       
                                        <div class="col selectorTool selectorToolRight">
                                            <label>To {{$opponent_name}}</label>
                                            <div class="left-col right-col">
                                                <div class="client-info 4_Op_opponentpercentage_div opponentpercentage_div">
                                                    <?php if(isset($drvehicles->Op_Vehicle_Percent_Marital_Equity_to_Op4)){ echo $drvehicles->Op_Vehicle_Percent_Marital_Equity_to_Op4; } else {
                                                        echo '50.00';
                                                    } ?>%
                                                </div>
                                                <div class="client-info 4_Op_opponentamount_div opponentamount_div" style="clear: both;">
                                                    $<?php if(isset($drvehicles->Op_Vehicle_Estimated_Value_to_Op4)){ echo $drvehicles->Op_Vehicle_Estimated_Value_to_Op4; } else {
                                                        echo '50.00';
                                                    } ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 m-auto 4_Op_Slider_Tool Op_Vehicle_Owned4_Div">
                                    <label></label>
                                    <div class="w-100">
                                        <label><input type="radio" id="4_Op_Vehicle_Estimated_Value_Select" name="4_Op_Vehicle_Estimated_Value_Select_Reset" class="Vehicle_Estimated_Value_Select_Reset" value="Save"> Save this Distribution of Vehicles #4</label>
                                        <label><input type="radio" id="4_Op_Vehicle_Estimated_Value_Reset" name="4_Op_Vehicle_Estimated_Value_Select_Reset" class="Vehicle_Estimated_Value_Select_Reset" value="Reset" onclick="resetBalanceInput(this, '4', 'Op');"> Reset to Default (50%)</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 Op_Vehicle_Owned4_Div Op_Vehicle_Paying_Party4_Inputs_Div" style="display: none;">
                                    <label>Op Vehicles Paying Party4</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Op_Vehicle_Paying_Party4_Client" name="Op_Vehicle_Paying_Party4" value="{{$client_name}}" data-onload="getInitialVehiclesPayingParty(this, '4', 'Op');" onchange="getVehiclesPayingParty(this, '4', 'Op');" <?php if(isset($drvehicles->Op_Vehicle_Paying_Party4) && $drvehicles->Op_Vehicle_Paying_Party4==$client_name){ echo "checked"; } ?>> {{$client_name}}</label>
                                        <label><input type="radio" id="Op_Vehicle_Paying_Party4_Op" name="Op_Vehicle_Paying_Party4" value="{{$opponent_name}}" data-onload="getInitialVehiclesPayingParty(this, '4', 'Op');" onchange="getVehiclesPayingParty(this, '4', 'Op');" <?php if(isset($drvehicles->Op_Vehicle_Paying_Party4) && $drvehicles->Op_Vehicle_Paying_Party4==$opponent_name){ echo "checked"; } ?>> {{$opponent_name}}</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 Op_Vehicle_Owned4_Div Op_Vehicle_Paying_Party4_Inputs_Div" style="display: none;">
                                    <label>{{$client_name}} Vehicles Equity Percent</label>
                                    <input id="Op_Vehicle_Percent_Marital_Equity_to_Client4" type="number" class="form-control 4_Op_clientpercentage_input clientpercentage_input" name="Op_Vehicle_Percent_Marital_Equity_to_Client4" value="<?php if(isset($drvehicles->Op_Vehicle_Percent_Marital_Equity_to_Client4)){ echo $drvehicles->Op_Vehicle_Percent_Marital_Equity_to_Client4; } ?>" min="0.00" step="0.01" max="100" readonly="">
                                </div>
                                <div class="form-group col-sm-6 Op_Vehicle_Owned4_Div Op_Vehicle_Paying_Party4_Inputs_Div" style="display: none;">
                                    <label>How much is to be paid to {{$client_name}}?</label>
                                    <input id="Op_Vehicle_Estimated_Value_to_Client4" type="number" class="form-control 4_Op_clientamount_input clientamount_input" name="Op_Vehicle_Estimated_Value_to_Client4" value="<?php if(isset($drvehicles->Op_Vehicle_Estimated_Value_to_Client4)){ echo $drvehicles->Op_Vehicle_Estimated_Value_to_Client4; } ?>" min="0.00" step="0.01" max="999999.99" readonly="" onchange="getEstimatedValueClient(this, '4', 'Op');" onkeyup="getEstimatedValueClient(this, '4', 'Op');">
                                </div>
                                <div class="form-group col-sm-6 Op_Vehicle_Owned4_Div Op_Vehicle_Paying_Party4_Inputs_Div" style="display: none;">
                                    <label>{{$opponent_name}} Vehicles Equity Percent</label>
                                    <input id="Op_Vehicle_Percent_Marital_Equity_to_Op4" type="number" class="form-control 4_Op_opponentpercentage_input opponentpercentage_input" name="Op_Vehicle_Percent_Marital_Equity_to_Op4" value="<?php if(isset($drvehicles->Op_Vehicle_Percent_Marital_Equity_to_Op4)){ echo $drvehicles->Op_Vehicle_Percent_Marital_Equity_to_Op4; } ?>" min="0.00" step="0.01" max="100" readonly="">
                                </div>
                                <div class="form-group col-sm-6 Op_Vehicle_Owned4_Div Op_Vehicle_Paying_Party4_Inputs_Div" style="display: none;">
                                    <label>How much is to be paid to {{$opponent_name}}?</label>
                                    <input id="Op_Vehicle_Estimated_Value_to_Op4" type="number" class="form-control 4_Op_opponentamount_input opponentamount_input" name="Op_Vehicle_Estimated_Value_to_Op4" value="<?php if(isset($drvehicles->Op_Vehicle_Estimated_Value_to_Op4)){ echo $drvehicles->Op_Vehicle_Estimated_Value_to_Op4; } ?>" min="0.00" step="0.01" max="999999.99" readonly="" onchange="getEstimatedValueOp(this, '4', 'Op');" onkeyup="getEstimatedValueOp(this, '4', 'Op');">
                                </div>
                                <!-- end of slider tool -->
                                <div class="form-group col-sm-6 Op_Vehicle_Paying_Party4_Leased_Div" style="display: none;">
                                    <label for="Op_Vehicle_Lease_Company4">Name of vehicle lease company?</label>
                                    <input id="Op_Vehicle_Lease_Company4" type="text" class="form-control 4_Op_vehicles_inputs Op_Vehicle_Paying_Party4_Leased_Input" name="Op_Vehicle_Lease_Company4" value="<?php if(isset($drvehicles->Op_Vehicle_Lease_Company4)){ echo $drvehicles->Op_Vehicle_Lease_Company4; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6 Op_Vehicle_Paying_Party4_Leased_Div" style="display: none;">
                                    <label>Monthly lease payment for this vehicle?</label>
                                    <input id="Op_Vehicle_Monthly_Lease_Amount4" type="number" class="form-control 4_Op_vehicles_inputs Op_Vehicle_Paying_Party4_Leased_Input" name="Op_Vehicle_Monthly_Lease_Amount4" value="<?php if(isset($drvehicles->Op_Vehicle_Monthly_Lease_Amount4)){ echo $drvehicles->Op_Vehicle_Monthly_Lease_Amount4; } ?>" min="0.00" step="0.01" max="999999.99">
                                </div>
                                <div class="form-group col-sm-6 Op_Vehicle_Paying_Party4_Leased_Div" style="display: none;">
                                    <label>How will this leased vehicle be handled?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Op_Vehicle_Lease_Disposition_Method4_Terminate_Lease" name="Op_Vehicle_Lease_Disposition_Method4" value="Terminate Lease" <?php if(isset($drvehicles->Op_Vehicle_Lease_Disposition_Method4) && $drvehicles->Op_Vehicle_Lease_Disposition_Method4=='Terminate Lease'){ echo "checked"; } ?>> Terminate Lease</label>
                                        <label><input type="radio" id="Op_Vehicle_Lease_Disposition_Method4_Transfer_Lease_Responsibility_to_ClientName" name="Op_Vehicle_Lease_Disposition_Method4" value="Transfer Lease Responsibility to {{$client_name}}" <?php if(isset($drvehicles->Op_Vehicle_Lease_Disposition_Method4) && $drvehicles->Op_Vehicle_Lease_Disposition_Method4=='Transfer Lease Responsibility to '.$client_name.''){ echo "checked"; } ?>> Transfer Lease Responsibility to {{$client_name}}</label>
                                        <label><input type="radio" id="Op_Vehicle_Lease_Disposition_Method4_Transfer_Lease_Responsibility_to_OpName" name="Op_Vehicle_Lease_Disposition_Method4" value="Transfer Lease Responsibility to {{$opponent_name}}" <?php if(isset($drvehicles->Op_Vehicle_Lease_Disposition_Method4) && $drvehicles->Op_Vehicle_Lease_Disposition_Method4=='Transfer Lease Responsibility to '.$opponent_name.''){ echo "checked"; } ?>> Transfer Lease Responsibility to {{$opponent_name}}</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 mt-4 5_Op_vehicles_section" style="display: none;"><h5 class="col-sm-12">Fifth Vehicle Info</h5>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Vehicle_Year5">Model year of this vehicle?</label>
                                    <select id="Op_Vehicle_Year5" name="Op_Vehicle_Year5" class="form-control 5_Op_vehicles_select">
                                        <?php 
                                            if(isset($drvehicles->Op_Vehicle_Year5)){ 
                                                $already_selected_value = $drvehicles->Op_Vehicle_Year5; 
                                            } else {
                                                $already_selected_value = '';
                                            }
                                            $earliest_year = 1900;
                                            foreach (range(date('Y'), $earliest_year) as $x) {
                                                echo '<option value="'.$x.'"'.($x == $already_selected_value ? ' selected="selected"' : '').'>'.$x.'</option>';
                                            }
                                        ?>
                                    </select>   
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Vehicle_Make_Model5">What make and model is this vehicle?</label>
                                    <input id="Op_Vehicle_Make_Model5" type="text" class="form-control 5_Op_vehicles_inputs" name="Op_Vehicle_Make_Model5" value="<?php if(isset($drvehicles->Op_Vehicle_Make_Model5)){ echo $drvehicles->Op_Vehicle_Make_Model5; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Is this vehicle leased or owned?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Op_Vehicle_Owned_Leased5_Owned" name="Op_Vehicle_Owned_Leased5" value="Owned" data-onload="getInitialVehicleOwnedLeased(this, '5', 'Op');" onchange="getVehicleOwnedLeased(this, '5', 'Op');" <?php if(isset($drvehicles->Op_Vehicle_Owned_Leased5) && $drvehicles->Op_Vehicle_Owned_Leased5=='Owned'){ echo "checked"; } ?>> Owned</label>
                                        <label><input type="radio" id="Op_Vehicle_Owned_Leased5_Leased" name="Op_Vehicle_Owned_Leased5" value="Leased" data-onload="getInitialVehicleOwnedLeased(this, '5', 'Op');" onchange="getVehicleOwnedLeased(this, '5', 'Op');" <?php if(isset($drvehicles->Op_Vehicle_Owned_Leased5) && $drvehicles->Op_Vehicle_Owned_Leased5=='Leased'){ echo "checked"; } ?>> Leased</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 Op_Vehicle_Owned5_Div">
                                    <label for="Op_Vehicle_VIN5">What is the VIN of this vehicle?</label>
                                    <input id="Op_Vehicle_VIN5" type="text" class="form-control 5_Op_vehicles_inputs" name="Op_Vehicle_VIN5" value="<?php if(isset($drvehicles->Op_Vehicle_VIN5)){ echo $drvehicles->Op_Vehicle_VIN5; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6 Op_Vehicle_Owned5_Div">
                                    <label for="Op_Vehicle_Current_Value5">What is the current value of this vehicle?</label>
                                    <input id="Op_Vehicle_Current_Value5" type="number" class="form-control 5_Op_vehicles_inputs" name="Op_Vehicle_Current_Value5" value="<?php if(isset($drvehicles->Op_Vehicle_Current_Value5)){ echo $drvehicles->Op_Vehicle_Current_Value5; } ?>" min="0.00" step="0.01" max="999999.99" onchange="getCurrentValue(this, '5', 'Op');" onkeyup="getCurrentValue(this, '5', 'Op');">
                                </div>
                                <div class="form-group col-sm-6 Op_Vehicle_Owned5_Div">
                                    <label for="Op_Vehicle_Loan_Company_Name5">Name of first car loan company?</label>
                                    <input id="Op_Vehicle_Loan_Company_Name5" type="text" class="form-control 5_Op_vehicles_inputs" name="Op_Vehicle_Loan_Company_Name5" value="<?php if(isset($drvehicles->Op_Vehicle_Loan_Company_Name5)){ echo $drvehicles->Op_Vehicle_Loan_Company_Name5; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6 Op_Vehicle_Owned5_Div">
                                    <label for="Op_Vehicle_Loan_Balance5">Balance due to first car loan company for this vehicle?</label>
                                    <input id="Op_Vehicle_Loan_Balance5" type="number" class="form-control 5_Op_vehicles_inputs" name="Op_Vehicle_Loan_Balance5" value="<?php if(isset($drvehicles->Op_Vehicle_Loan_Balance5)){ echo $drvehicles->Op_Vehicle_Loan_Balance5; } ?>" min="0.00" step="0.01" max="999999.99" onchange="getLoanBalance(this, '5', 'Op');" onkeyup="getLoanBalance(this, '5', 'Op');">
                                </div>
                                <div class="form-group col-sm-6 Op_Vehicle_Owned5_Div">
                                    <label for="Op_Vehicle_Loan_Monthly_Payment5">Monthly payment to first car loan company for this vehicle?</label>
                                    <input id="Op_Vehicle_Loan_Monthly_Payment5" type="number" class="form-control 5_Op_vehicles_inputs" name="Op_Vehicle_Loan_Monthly_Payment5" value="<?php if(isset($drvehicles->Op_Vehicle_Loan_Monthly_Payment5)){ echo $drvehicles->Op_Vehicle_Loan_Monthly_Payment5; } ?>" min="0.00" step="0.01" max="999999.99">
                                </div>
                                <div class="form-group col-sm-6 Op_Vehicle_Owned5_Div">
                                    <label for="Op_Vehicle_Loan_Second_Company_Name5">Name of second car loan company?</label>
                                    <input id="Op_Vehicle_Loan_Second_Company_Name5" type="text" class="form-control 5_Op_vehicles_inputs" name="Op_Vehicle_Loan_Second_Company_Name5" value="<?php if(isset($drvehicles->Op_Vehicle_Loan_Second_Company_Name5)){ echo $drvehicles->Op_Vehicle_Loan_Second_Company_Name5; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6 Op_Vehicle_Owned5_Div">
                                    <label for="Op_Vehicle_Loan_Second_Company_Balance5">Balance due to second car loan company for this vehicle?</label>
                                    <input id="Op_Vehicle_Loan_Second_Company_Balance5" type="number" class="form-control 5_Op_vehicles_inputs" name="Op_Vehicle_Loan_Second_Company_Balance5" value="<?php if(isset($drvehicles->Op_Vehicle_Loan_Second_Company_Balance5)){ echo $drvehicles->Op_Vehicle_Loan_Second_Company_Balance5; } ?>" min="0.00" step="0.01" max="999999.99" onchange="getCompanyBalance(this, '5', 'Op');" onkeyup="getCompanyBalance(this, '5', 'Op');">
                                </div>
                                <div class="form-group col-sm-6 Op_Vehicle_Owned5_Div">
                                    <label for="Op_Vehicle_Loan_Second_Company_Monthly_Payment5">Monthly payment to second car loan company for this vehicle?</label>
                                    <input id="Op_Vehicle_Loan_Second_Company_Monthly_Payment5" type="number" class="form-control 5_Op_vehicles_inputs" name="Op_Vehicle_Loan_Second_Company_Monthly_Payment5" value="<?php if(isset($drvehicles->Op_Vehicle_Loan_Second_Company_Monthly_Payment5)){ echo $drvehicles->Op_Vehicle_Loan_Second_Company_Monthly_Payment5; } ?>" min="0.00" step="0.01" max="999999.99">
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label for="Op_Vehicle_Marital_Equity5">N/A, calculated = Op_Vehicle_Current_Value5-Op_Vehicle_Loan_Balance5-Op_Vehicle_Loan_Second_Company_Balance5</label>
                                    <input id="Op_Vehicle_Marital_Equity5" type="number" class="form-control 5_Op_vehicles_inputs" name="Op_Vehicle_Marital_Equity5" value="<?php if(isset($drvehicles->Op_Vehicle_Marital_Equity5)){ echo $drvehicles->Op_Vehicle_Marital_Equity5; } ?>" min="0.00" step="0.01" max="999999.99">
                                </div>
                                <div class="form-group col-sm-6 Op_Vehicle_Owned5_Div">
                                    <label>Does either party claim a sole/separate interest in this vehicle?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Op_Vehicle_SoleSeparate_Claim5_Yes" name="Op_Vehicle_SoleSeparate_Claim5" value="Yes" data-onload="getInitialPartyClaimSoleSeparate(this, '5', 'Op');" onchange="getPartyClaimSoleSeparate(this, '5', 'Op');" <?php if(isset($drvehicles->Op_Vehicle_SoleSeparate_Claim5) && $drvehicles->Op_Vehicle_SoleSeparate_Claim5=='Yes'){ echo "checked"; } ?>> Yes</label>
                                        <label><input type="radio" id="Op_Vehicle_SoleSeparate_Claim5_No" name="Op_Vehicle_SoleSeparate_Claim5" value="No" data-onload="getInitialPartyClaimSoleSeparate(this, '5', 'Op');" onchange="getPartyClaimSoleSeparate(this, '5', 'Op');" <?php if(isset($drvehicles->Op_Vehicle_SoleSeparate_Claim5) && $drvehicles->Op_Vehicle_SoleSeparate_Claim5=='No'){ echo "checked"; } ?>> No</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 Op_Vehicle_Owned5_Div" id="Op_Vehicle_SoleSeparate_Party5_Div" style="display: none;">
                                    <label>Who claims to own this vehicle?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Op_Vehicle_SoleSeparate_Party5_Client" name="Op_Vehicle_SoleSeparate_Party5" value="{{$client_name}}" <?php if(isset($drvehicles->Op_Vehicle_SoleSeparate_Party5) && $drvehicles->Op_Vehicle_SoleSeparate_Party5==$client_name){ echo "checked"; } ?>> {{$client_name}}</label>
                                        <label><input type="radio" id="Op_Vehicle_SoleSeparate_Party5_Op" name="Op_Vehicle_SoleSeparate_Party5" value="{{$opponent_name}}" <?php if(isset($drvehicles->Op_Vehicle_SoleSeparate_Party5) && $drvehicles->Op_Vehicle_SoleSeparate_Party5==$opponent_name){ echo "checked"; } ?>> {{$opponent_name}}</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 Op_Vehicle_Owned5_Div" id="Op_Vehicle_SoleSeparate_Grounds5_Div" style="display: none;">
                                    <label for="Op_Vehicle_SoleSeparate_Grounds5">Why does this person own this vehicle solely and separately?</label>
                                    <input id="Op_Vehicle_SoleSeparate_Grounds5" type="text" class="form-control 5_Op_vehicles_inputs" name="Op_Vehicle_SoleSeparate_Grounds5" value="<?php if(isset($drvehicles->Op_Vehicle_SoleSeparate_Grounds5)){ echo $drvehicles->Op_Vehicle_SoleSeparate_Grounds5; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6 Op_Vehicle_Owned5_Div">
                                    <label>How will this vehicle value be distributed between the parties?</label>
                                    <div class="w-100 dataInput">
                                        <label><input type="radio" id="Op_Vehicle_Disposition_Method5_Liquidate_Split_Net_Value" name="Op_Vehicle_Disposition_Method5" value="Liquidate/Split Net Value" data-onload="getInitialDipositionMethod(this, '5', 'Op');" onchange="getDipositionMethod(this, '5', 'Op');" <?php if(isset($drvehicles->Op_Vehicle_Disposition_Method5) && $drvehicles->Op_Vehicle_Disposition_Method5=='Liquidate/Split Net Value'){ echo "checked"; } ?>> Liquidate/Split Net Value</label>
                                        <label><input type="radio" id="Op_Vehicle_Disposition_Method5_Fixed_Buyout" name="Op_Vehicle_Disposition_Method5" value="Fixed Buyout" data-onload="getInitialDipositionMethod(this, '5', 'Op');" onchange="getDipositionMethod(this, '5', 'Op');" <?php if(isset($drvehicles->Op_Vehicle_Disposition_Method5) && $drvehicles->Op_Vehicle_Disposition_Method5=='Fixed Buyout'){ echo "checked"; } ?>> Fixed Buyout</label>
                                    </div>
                                </div>
                                <!-- slider tool -->
                                <div class="form-group col-sm-6 m-auto 5_Op_Slider_Tool Op_Vehicle_Owned5_Div">
                                    <div class="row">
                                        <div class="col">{{$client_name}}</div>
                                        <div class="col text-right">{{$opponent_name}}</div>
                                    </div>
                                    <input id="5_Op_balance_range_selector" type="range" class="form-control slider-tool-input 5_Op_balance_range_selector" name="" value="<?php if(isset($drvehicles->Op_Vehicle_Percent_Marital_Equity_to_Op5)){ echo $drvehicles->Op_Vehicle_Percent_Marital_Equity_to_Op5; } ?>" min="0.00" step="0.01" max="100" onchange="updateBalanceInput(this.value, '5', 'Op');">
                                </div>
                                <div class="form-group col-sm-6 m-auto 5_Op_Slider_Tool Op_Vehicle_Owned5_Div">
                                    <div class="row justify-content-between">
                                        <div class="col selectorTool">
                                            <div class="left-col">
                                                <div class="client-info 5_Op_clientpercentage_div clientpercentage_div">
                                                    <?php if(isset($drvehicles->Op_Vehicle_Percent_Marital_Equity_to_Client5)){ echo $drvehicles->Op_Vehicle_Percent_Marital_Equity_to_Client5; } else {
                                                        echo '50.00';
                                                    } ?>%
                                                </div>
                                                <div class="client-info 5_Op_clientamount_div clientamount_div" style="clear: both;">
                                                    $<?php if(isset($drvehicles->Op_Vehicle_Estimated_Value_to_Client5)){ echo $drvehicles->Op_Vehicle_Estimated_Value_to_Client5; } else {
                                                        echo '50.00';
                                                    } ?>
                                                </div>
                                            </div>
                                            <label>To {{$client_name}}</label>
                                        </div>                                       
                                        <div class="col selectorTool selectorToolRight">
                                            <label>To {{$opponent_name}}</label>
                                            <div class="left-col right-col">
                                                <div class="client-info 5_Op_opponentpercentage_div opponentpercentage_div">
                                                    <?php if(isset($drvehicles->Op_Vehicle_Percent_Marital_Equity_to_Op5)){ echo $drvehicles->Op_Vehicle_Percent_Marital_Equity_to_Op5; } else {
                                                        echo '50.00';
                                                    } ?>%
                                                </div>
                                                <div class="client-info 5_Op_opponentamount_div opponentamount_div" style="clear: both;">
                                                    $<?php if(isset($drvehicles->Op_Vehicle_Estimated_Value_to_Op5)){ echo $drvehicles->Op_Vehicle_Estimated_Value_to_Op5; } else {
                                                        echo '50.00';
                                                    } ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 m-auto 5_Op_Slider_Tool Op_Vehicle_Owned5_Div">
                                    <label></label>
                                    <div class="w-100">
                                        <label><input type="radio" id="5_Op_Vehicle_Estimated_Value_Select" name="5_Op_Vehicle_Estimated_Value_Select_Reset" class="Vehicle_Estimated_Value_Select_Reset" value="Save"> Save this Distribution of Vehicles #5</label>
                                        <label><input type="radio" id="5_Op_Vehicle_Estimated_Value_Reset" name="5_Op_Vehicle_Estimated_Value_Select_Reset" class="Vehicle_Estimated_Value_Select_Reset" value="Reset" onclick="resetBalanceInput(this, '5', 'Op');"> Reset to Default (50%)</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 Op_Vehicle_Owned5_Div Op_Vehicle_Paying_Party5_Inputs_Div" style="display: none;">
                                    <label>Op Vehicles Paying Party5</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Op_Vehicle_Paying_Party5_Client" name="Op_Vehicle_Paying_Party5" value="{{$client_name}}" data-onload="getInitialVehiclesPayingParty(this, '5', 'Op');" onchange="getVehiclesPayingParty(this, '5', 'Op');" <?php if(isset($drvehicles->Op_Vehicle_Paying_Party5) && $drvehicles->Op_Vehicle_Paying_Party5==$client_name){ echo "checked"; } ?>> {{$client_name}}</label>
                                        <label><input type="radio" id="Op_Vehicle_Paying_Party5_Op" name="Op_Vehicle_Paying_Party5" value="{{$opponent_name}}" data-onload="getInitialVehiclesPayingParty(this, '5', 'Op');" onchange="getVehiclesPayingParty(this, '5', 'Op');" <?php if(isset($drvehicles->Op_Vehicle_Paying_Party5) && $drvehicles->Op_Vehicle_Paying_Party5==$opponent_name){ echo "checked"; } ?>> {{$opponent_name}}</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 Op_Vehicle_Owned5_Div Op_Vehicle_Paying_Party5_Inputs_Div" style="display: none;">
                                    <label>{{$client_name}} Vehicles Equity Percent</label>
                                    <input id="Op_Vehicle_Percent_Marital_Equity_to_Client5" type="number" class="form-control 5_Op_clientpercentage_input clientpercentage_input" name="Op_Vehicle_Percent_Marital_Equity_to_Client5" value="<?php if(isset($drvehicles->Op_Vehicle_Percent_Marital_Equity_to_Client5)){ echo $drvehicles->Op_Vehicle_Percent_Marital_Equity_to_Client5; } ?>" min="0.00" step="0.01" max="100" readonly="">
                                </div>
                                <div class="form-group col-sm-6 Op_Vehicle_Owned5_Div Op_Vehicle_Paying_Party5_Inputs_Div" style="display: none;">
                                    <label>How much is to be paid to {{$client_name}}?</label>
                                    <input id="Op_Vehicle_Estimated_Value_to_Client5" type="number" class="form-control 5_Op_clientamount_input clientamount_input" name="Op_Vehicle_Estimated_Value_to_Client5" value="<?php if(isset($drvehicles->Op_Vehicle_Estimated_Value_to_Client5)){ echo $drvehicles->Op_Vehicle_Estimated_Value_to_Client5; } ?>" min="0.00" step="0.01" max="999999.99" readonly="" onchange="getEstimatedValueClient(this, '5', 'Op');" onkeyup="getEstimatedValueClient(this, '5', 'Op');">
                                </div>
                                <div class="form-group col-sm-6 Op_Vehicle_Owned5_Div Op_Vehicle_Paying_Party5_Inputs_Div" style="display: none;">
                                    <label>{{$opponent_name}} Vehicles Equity Percent</label>
                                    <input id="Op_Vehicle_Percent_Marital_Equity_to_Op5" type="number" class="form-control 5_Op_opponentpercentage_input opponentpercentage_input" name="Op_Vehicle_Percent_Marital_Equity_to_Op5" value="<?php if(isset($drvehicles->Op_Vehicle_Percent_Marital_Equity_to_Op5)){ echo $drvehicles->Op_Vehicle_Percent_Marital_Equity_to_Op5; } ?>" min="0.00" step="0.01" max="100" readonly="">
                                </div>
                                <div class="form-group col-sm-6 Op_Vehicle_Owned5_Div Op_Vehicle_Paying_Party5_Inputs_Div" style="display: none;">
                                    <label>How much is to be paid to {{$opponent_name}}?</label>
                                    <input id="Op_Vehicle_Estimated_Value_to_Op5" type="number" class="form-control 5_Op_opponentamount_input opponentamount_input" name="Op_Vehicle_Estimated_Value_to_Op5" value="<?php if(isset($drvehicles->Op_Vehicle_Estimated_Value_to_Op5)){ echo $drvehicles->Op_Vehicle_Estimated_Value_to_Op5; } ?>" min="0.00" step="0.01" max="999999.99" readonly="" onchange="getEstimatedValueOp(this, '5', 'Op');" onkeyup="getEstimatedValueOp(this, '5', 'Op');">
                                </div>
                                <!-- end of slider tool -->
                                <div class="form-group col-sm-6 Op_Vehicle_Paying_Party5_Leased_Div" style="display: none;">
                                    <label for="Op_Vehicle_Lease_Company5">Name of vehicle lease company?</label>
                                    <input id="Op_Vehicle_Lease_Company5" type="text" class="form-control 5_Op_vehicles_inputs Op_Vehicle_Paying_Party5_Leased_Input" name="Op_Vehicle_Lease_Company5" value="<?php if(isset($drvehicles->Op_Vehicle_Lease_Company5)){ echo $drvehicles->Op_Vehicle_Lease_Company5; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6 Op_Vehicle_Paying_Party5_Leased_Div" style="display: none;">
                                    <label>Monthly lease payment for this vehicle?</label>
                                    <input id="Op_Vehicle_Monthly_Lease_Amount5" type="number" class="form-control 5_Op_vehicles_inputs Op_Vehicle_Paying_Party5_Leased_Input" name="Op_Vehicle_Monthly_Lease_Amount5" value="<?php if(isset($drvehicles->Op_Vehicle_Monthly_Lease_Amount5)){ echo $drvehicles->Op_Vehicle_Monthly_Lease_Amount5; } ?>" min="0.00" step="0.01" max="999999.99">
                                </div>
                                <div class="form-group col-sm-6 Op_Vehicle_Paying_Party5_Leased_Div" style="display: none;">
                                    <label>How will this leased vehicle be handled?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Op_Vehicle_Lease_Disposition_Method5_Terminate_Lease" name="Op_Vehicle_Lease_Disposition_Method5" value="Terminate Lease" <?php if(isset($drvehicles->Op_Vehicle_Lease_Disposition_Method5) && $drvehicles->Op_Vehicle_Lease_Disposition_Method5=='Terminate Lease'){ echo "checked"; } ?>> Terminate Lease</label>
                                        <label><input type="radio" id="Op_Vehicle_Lease_Disposition_Method5_Transfer_Lease_Responsibility_to_ClientName" name="Op_Vehicle_Lease_Disposition_Method5" value="Transfer Lease Responsibility to {{$client_name}}" <?php if(isset($drvehicles->Op_Vehicle_Lease_Disposition_Method5) && $drvehicles->Op_Vehicle_Lease_Disposition_Method5=='Transfer Lease Responsibility to '.$client_name.''){ echo "checked"; } ?>> Transfer Lease Responsibility to {{$client_name}}</label>
                                        <label><input type="radio" id="Op_Vehicle_Lease_Disposition_Method5_Transfer_Lease_Responsibility_to_OpName" name="Op_Vehicle_Lease_Disposition_Method5" value="Transfer Lease Responsibility to {{$opponent_name}}" <?php if(isset($drvehicles->Op_Vehicle_Lease_Disposition_Method5) && $drvehicles->Op_Vehicle_Lease_Disposition_Method5=='Transfer Lease Responsibility to '.$opponent_name.''){ echo "checked"; } ?>> Transfer Lease Responsibility to {{$opponent_name}}</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 mt-4 6_Op_vehicles_section" style="display: none;"><h5 class="col-sm-12">Sixth Vehicle Info</h5>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Vehicle_Year6">Model year of this vehicle?</label>
                                    <select id="Op_Vehicle_Year6" name="Op_Vehicle_Year6" class="form-control 6_Op_vehicles_select">
                                        <?php 
                                            if(isset($drvehicles->Op_Vehicle_Year6)){ 
                                                $already_selected_value = $drvehicles->Op_Vehicle_Year6; 
                                            } else {
                                                $already_selected_value = '';
                                            }
                                            $earliest_year = 1900;
                                            foreach (range(date('Y'), $earliest_year) as $x) {
                                                echo '<option value="'.$x.'"'.($x == $already_selected_value ? ' selected="selected"' : '').'>'.$x.'</option>';
                                            }
                                        ?>
                                    </select>   
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Vehicle_Make_Model6">What make and model is this vehicle?</label>
                                    <input id="Op_Vehicle_Make_Model6" type="text" class="form-control 6_Op_vehicles_inputs" name="Op_Vehicle_Make_Model6" value="<?php if(isset($drvehicles->Op_Vehicle_Make_Model6)){ echo $drvehicles->Op_Vehicle_Make_Model6; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Is this vehicle leased or owned?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Op_Vehicle_Owned_Leased6_Owned" name="Op_Vehicle_Owned_Leased6" value="Owned" data-onload="getInitialVehicleOwnedLeased(this, '6', 'Op');" onchange="getVehicleOwnedLeased(this, '6', 'Op');" <?php if(isset($drvehicles->Op_Vehicle_Owned_Leased6) && $drvehicles->Op_Vehicle_Owned_Leased6=='Owned'){ echo "checked"; } ?>> Owned</label>
                                        <label><input type="radio" id="Op_Vehicle_Owned_Leased6_Leased" name="Op_Vehicle_Owned_Leased6" value="Leased" data-onload="getInitialVehicleOwnedLeased(this, '6', 'Op');" onchange="getVehicleOwnedLeased(this, '6', 'Op');" <?php if(isset($drvehicles->Op_Vehicle_Owned_Leased6) && $drvehicles->Op_Vehicle_Owned_Leased6=='Leased'){ echo "checked"; } ?>> Leased</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 Op_Vehicle_Owned6_Div">
                                    <label for="Op_Vehicle_VIN6">What is the VIN of this vehicle?</label>
                                    <input id="Op_Vehicle_VIN6" type="text" class="form-control 6_Op_vehicles_inputs" name="Op_Vehicle_VIN6" value="<?php if(isset($drvehicles->Op_Vehicle_VIN6)){ echo $drvehicles->Op_Vehicle_VIN6; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6 Op_Vehicle_Owned6_Div">
                                    <label for="Op_Vehicle_Current_Value6">What is the current value of this vehicle?</label>
                                    <input id="Op_Vehicle_Current_Value6" type="number" class="form-control 6_Op_vehicles_inputs" name="Op_Vehicle_Current_Value6" value="<?php if(isset($drvehicles->Op_Vehicle_Current_Value6)){ echo $drvehicles->Op_Vehicle_Current_Value6; } ?>" min="0.00" step="0.01" max="999999.99" onchange="getCurrentValue(this, '6', 'Op');" onkeyup="getCurrentValue(this, '6', 'Op');">
                                </div>
                                <div class="form-group col-sm-6 Op_Vehicle_Owned6_Div">
                                    <label for="Op_Vehicle_Loan_Company_Name6">Name of first car loan company?</label>
                                    <input id="Op_Vehicle_Loan_Company_Name6" type="text" class="form-control 6_Op_vehicles_inputs" name="Op_Vehicle_Loan_Company_Name6" value="<?php if(isset($drvehicles->Op_Vehicle_Loan_Company_Name6)){ echo $drvehicles->Op_Vehicle_Loan_Company_Name6; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6 Op_Vehicle_Owned6_Div">
                                    <label for="Op_Vehicle_Loan_Balance6">Balance due to first car loan company for this vehicle?</label>
                                    <input id="Op_Vehicle_Loan_Balance6" type="number" class="form-control 6_Op_vehicles_inputs" name="Op_Vehicle_Loan_Balance6" value="<?php if(isset($drvehicles->Op_Vehicle_Loan_Balance6)){ echo $drvehicles->Op_Vehicle_Loan_Balance6; } ?>" min="0.00" step="0.01" max="999999.99" onchange="getLoanBalance(this, '6', 'Op');" onkeyup="getLoanBalance(this, '6', 'Op');">
                                </div>
                                <div class="form-group col-sm-6 Op_Vehicle_Owned6_Div">
                                    <label for="Op_Vehicle_Loan_Monthly_Payment6">Monthly payment to first car loan company for this vehicle?</label>
                                    <input id="Op_Vehicle_Loan_Monthly_Payment6" type="number" class="form-control 6_Op_vehicles_inputs" name="Op_Vehicle_Loan_Monthly_Payment6" value="<?php if(isset($drvehicles->Op_Vehicle_Loan_Monthly_Payment6)){ echo $drvehicles->Op_Vehicle_Loan_Monthly_Payment6; } ?>" min="0.00" step="0.01" max="999999.99">
                                </div>
                                <div class="form-group col-sm-6 Op_Vehicle_Owned6_Div">
                                    <label for="Op_Vehicle_Loan_Second_Company_Name6">Name of second car loan company?</label>
                                    <input id="Op_Vehicle_Loan_Second_Company_Name6" type="text" class="form-control 6_Op_vehicles_inputs" name="Op_Vehicle_Loan_Second_Company_Name6" value="<?php if(isset($drvehicles->Op_Vehicle_Loan_Second_Company_Name6)){ echo $drvehicles->Op_Vehicle_Loan_Second_Company_Name6; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6 Op_Vehicle_Owned6_Div">
                                    <label for="Op_Vehicle_Loan_Second_Company_Balance6">Balance due to second car loan company for this vehicle?</label>
                                    <input id="Op_Vehicle_Loan_Second_Company_Balance6" type="number" class="form-control 6_Op_vehicles_inputs" name="Op_Vehicle_Loan_Second_Company_Balance6" value="<?php if(isset($drvehicles->Op_Vehicle_Loan_Second_Company_Balance6)){ echo $drvehicles->Op_Vehicle_Loan_Second_Company_Balance6; } ?>" min="0.00" step="0.01" max="999999.99" onchange="getCompanyBalance(this, '6', 'Op');" onkeyup="getCompanyBalance(this, '6', 'Op');">
                                </div>
                                <div class="form-group col-sm-6 Op_Vehicle_Owned6_Div">
                                    <label for="Op_Vehicle_Loan_Second_Company_Monthly_Payment6">Monthly payment to second car loan company for this vehicle?</label>
                                    <input id="Op_Vehicle_Loan_Second_Company_Monthly_Payment6" type="number" class="form-control 6_Op_vehicles_inputs" name="Op_Vehicle_Loan_Second_Company_Monthly_Payment6" value="<?php if(isset($drvehicles->Op_Vehicle_Loan_Second_Company_Monthly_Payment6)){ echo $drvehicles->Op_Vehicle_Loan_Second_Company_Monthly_Payment6; } ?>" min="0.00" step="0.01" max="999999.99">
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label for="Op_Vehicle_Marital_Equity6">N/A, calculated = Op_Vehicle_Current_Value6-Op_Vehicle_Loan_Balance6-Op_Vehicle_Loan_Second_Company_Balance6</label>
                                    <input id="Op_Vehicle_Marital_Equity6" type="number" class="form-control 6_Op_vehicles_inputs" name="Op_Vehicle_Marital_Equity6" value="<?php if(isset($drvehicles->Op_Vehicle_Marital_Equity6)){ echo $drvehicles->Op_Vehicle_Marital_Equity6; } ?>" min="0.00" step="0.01" max="999999.99">
                                </div>
                                <div class="form-group col-sm-6 Op_Vehicle_Owned6_Div">
                                    <label>Does either party claim a sole/separate interest in this vehicle?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Op_Vehicle_SoleSeparate_Claim6_Yes" name="Op_Vehicle_SoleSeparate_Claim6" value="Yes" data-onload="getInitialPartyClaimSoleSeparate(this, '6', 'Op');" onchange="getPartyClaimSoleSeparate(this, '6', 'Op');" <?php if(isset($drvehicles->Op_Vehicle_SoleSeparate_Claim6) && $drvehicles->Op_Vehicle_SoleSeparate_Claim6=='Yes'){ echo "checked"; } ?>> Yes</label>
                                        <label><input type="radio" id="Op_Vehicle_SoleSeparate_Claim6_No" name="Op_Vehicle_SoleSeparate_Claim6" value="No" data-onload="getInitialPartyClaimSoleSeparate(this, '6', 'Op');" onchange="getPartyClaimSoleSeparate(this, '6', 'Op');" <?php if(isset($drvehicles->Op_Vehicle_SoleSeparate_Claim6) && $drvehicles->Op_Vehicle_SoleSeparate_Claim6=='No'){ echo "checked"; } ?>> No</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 Op_Vehicle_Owned6_Div" id="Op_Vehicle_SoleSeparate_Party6_Div" style="display: none;">
                                    <label>Who claims to own this vehicle?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Op_Vehicle_SoleSeparate_Party6_Client" name="Op_Vehicle_SoleSeparate_Party6" value="{{$client_name}}" <?php if(isset($drvehicles->Op_Vehicle_SoleSeparate_Party6) && $drvehicles->Op_Vehicle_SoleSeparate_Party6==$client_name){ echo "checked"; } ?>> {{$client_name}}</label>
                                        <label><input type="radio" id="Op_Vehicle_SoleSeparate_Party6_Op" name="Op_Vehicle_SoleSeparate_Party6" value="{{$opponent_name}}" <?php if(isset($drvehicles->Op_Vehicle_SoleSeparate_Party6) && $drvehicles->Op_Vehicle_SoleSeparate_Party6==$opponent_name){ echo "checked"; } ?>> {{$opponent_name}}</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 Op_Vehicle_Owned6_Div" id="Op_Vehicle_SoleSeparate_Grounds6_Div" style="display: none;">
                                    <label for="Op_Vehicle_SoleSeparate_Grounds6">Why does this person own this vehicle solely and separately?</label>
                                    <input id="Op_Vehicle_SoleSeparate_Grounds6" type="text" class="form-control 6_Op_vehicles_inputs" name="Op_Vehicle_SoleSeparate_Grounds6" value="<?php if(isset($drvehicles->Op_Vehicle_SoleSeparate_Grounds6)){ echo $drvehicles->Op_Vehicle_SoleSeparate_Grounds6; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6 Op_Vehicle_Owned6_Div">
                                    <label>How will this vehicle value be distributed between the parties?</label>
                                    <div class="w-100 dataInput">
                                        <label><input type="radio" id="Op_Vehicle_Disposition_Method6_Liquidate_Split_Net_Value" name="Op_Vehicle_Disposition_Method6" value="Liquidate/Split Net Value" data-onload="getInitialDipositionMethod(this, '6', 'Op');" onchange="getDipositionMethod(this, '6', 'Op');" <?php if(isset($drvehicles->Op_Vehicle_Disposition_Method6) && $drvehicles->Op_Vehicle_Disposition_Method6=='Liquidate/Split Net Value'){ echo "checked"; } ?>> Liquidate/Split Net Value</label>
                                        <label><input type="radio" id="Op_Vehicle_Disposition_Method6_Fixed_Buyout" name="Op_Vehicle_Disposition_Method6" value="Fixed Buyout" data-onload="getInitialDipositionMethod(this, '6', 'Op');" onchange="getDipositionMethod(this, '6', 'Op');" <?php if(isset($drvehicles->Op_Vehicle_Disposition_Method6) && $drvehicles->Op_Vehicle_Disposition_Method6=='Fixed Buyout'){ echo "checked"; } ?>> Fixed Buyout</label>
                                    </div>
                                </div>
                                <!-- slider tool -->
                                <div class="form-group col-sm-6 m-auto 6_Op_Slider_Tool Op_Vehicle_Owned6_Div">
                                    <div class="row">
                                        <div class="col">{{$client_name}}</div>
                                        <div class="col text-right">{{$opponent_name}}</div>
                                    </div>
                                    <input id="6_Op_balance_range_selector" type="range" class="form-control slider-tool-input 6_Op_balance_range_selector" name="" value="<?php if(isset($drvehicles->Op_Vehicle_Percent_Marital_Equity_to_Op6)){ echo $drvehicles->Op_Vehicle_Percent_Marital_Equity_to_Op6; } ?>" min="0.00" step="0.01" max="100" onchange="updateBalanceInput(this.value, '6', 'Op');">
                                </div>
                                <div class="form-group col-sm-6 m-auto 6_Op_Slider_Tool Op_Vehicle_Owned6_Div">
                                    <div class="row justify-content-between">
                                        <div class="col selectorTool">
                                            <div class="left-col">
                                                <div class="client-info 6_Op_clientpercentage_div clientpercentage_div">
                                                    <?php if(isset($drvehicles->Op_Vehicle_Percent_Marital_Equity_to_Client6)){ echo $drvehicles->Op_Vehicle_Percent_Marital_Equity_to_Client6; } else {
                                                        echo '50.00';
                                                    } ?>%
                                                </div>
                                                <div class="client-info 6_Op_clientamount_div clientamount_div" style="clear: both;">
                                                    $<?php if(isset($drvehicles->Op_Vehicle_Estimated_Value_to_Client6)){ echo $drvehicles->Op_Vehicle_Estimated_Value_to_Client6; } else {
                                                        echo '50.00';
                                                    } ?>
                                                </div>
                                            </div>
                                            <label>To {{$client_name}}</label>
                                        </div>                                       
                                        <div class="col selectorTool selectorToolRight">
                                            <label>To {{$opponent_name}}</label>
                                            <div class="left-col right-col">
                                                <div class="client-info 6_Op_opponentpercentage_div opponentpercentage_div">
                                                    <?php if(isset($drvehicles->Op_Vehicle_Percent_Marital_Equity_to_Op6)){ echo $drvehicles->Op_Vehicle_Percent_Marital_Equity_to_Op6; } else {
                                                        echo '50.00';
                                                    } ?>%
                                                </div>
                                                <div class="client-info 6_Op_opponentamount_div opponentamount_div" style="clear: both;">
                                                    $<?php if(isset($drvehicles->Op_Vehicle_Estimated_Value_to_Op6)){ echo $drvehicles->Op_Vehicle_Estimated_Value_to_Op6; } else {
                                                        echo '50.00';
                                                    } ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 m-auto 6_Op_Slider_Tool Op_Vehicle_Owned6_Div">
                                    <label></label>
                                    <div class="w-100">
                                        <label><input type="radio" id="6_Op_Vehicle_Estimated_Value_Select" name="6_Op_Vehicle_Estimated_Value_Select_Reset" class="Vehicle_Estimated_Value_Select_Reset" value="Save"> Save this Distribution of Vehicles #6</label>
                                        <label><input type="radio" id="6_Op_Vehicle_Estimated_Value_Reset" name="6_Op_Vehicle_Estimated_Value_Select_Reset" class="Vehicle_Estimated_Value_Select_Reset" value="Reset" onclick="resetBalanceInput(this, '6', 'Op');"> Reset to Default (50%)</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 Op_Vehicle_Owned6_Div Op_Vehicle_Paying_Party6_Inputs_Div" style="display: none;">
                                    <label>Op Vehicles Paying Party6</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Op_Vehicle_Paying_Party6_Client" name="Op_Vehicle_Paying_Party6" value="{{$client_name}}" data-onload="getInitialVehiclesPayingParty(this, '6', 'Op');" onchange="getVehiclesPayingParty(this, '6', 'Op');" <?php if(isset($drvehicles->Op_Vehicle_Paying_Party6) && $drvehicles->Op_Vehicle_Paying_Party6==$client_name){ echo "checked"; } ?>> {{$client_name}}</label>
                                        <label><input type="radio" id="Op_Vehicle_Paying_Party6_Op" name="Op_Vehicle_Paying_Party6" value="{{$opponent_name}}" data-onload="getInitialVehiclesPayingParty(this, '6', 'Op');" onchange="getVehiclesPayingParty(this, '6', 'Op');" <?php if(isset($drvehicles->Op_Vehicle_Paying_Party6) && $drvehicles->Op_Vehicle_Paying_Party6==$opponent_name){ echo "checked"; } ?>> {{$opponent_name}}</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 Op_Vehicle_Owned6_Div Op_Vehicle_Paying_Party6_Inputs_Div" style="display: none;">
                                    <label>{{$client_name}} Vehicles Equity Percent</label>
                                    <input id="Op_Vehicle_Percent_Marital_Equity_to_Client6" type="number" class="form-control 6_Op_clientpercentage_input clientpercentage_input" name="Op_Vehicle_Percent_Marital_Equity_to_Client6" value="<?php if(isset($drvehicles->Op_Vehicle_Percent_Marital_Equity_to_Client6)){ echo $drvehicles->Op_Vehicle_Percent_Marital_Equity_to_Client6; } ?>" min="0.00" step="0.01" max="100" readonly="">
                                </div>
                                <div class="form-group col-sm-6 Op_Vehicle_Owned6_Div Op_Vehicle_Paying_Party6_Inputs_Div" style="display: none;">
                                    <label>How much is to be paid to {{$client_name}}?</label>
                                    <input id="Op_Vehicle_Estimated_Value_to_Client6" type="number" class="form-control 6_Op_clientamount_input clientamount_input" name="Op_Vehicle_Estimated_Value_to_Client6" value="<?php if(isset($drvehicles->Op_Vehicle_Estimated_Value_to_Client6)){ echo $drvehicles->Op_Vehicle_Estimated_Value_to_Client6; } ?>" min="0.00" step="0.01" max="999999.99" readonly="" onchange="getEstimatedValueClient(this, '6', 'Op');" onkeyup="getEstimatedValueClient(this, '6', 'Op');">
                                </div>
                                <div class="form-group col-sm-6 Op_Vehicle_Owned6_Div Op_Vehicle_Paying_Party6_Inputs_Div" style="display: none;">
                                    <label>{{$opponent_name}} Vehicles Equity Percent</label>
                                    <input id="Op_Vehicle_Percent_Marital_Equity_to_Op6" type="number" class="form-control 6_Op_opponentpercentage_input opponentpercentage_input" name="Op_Vehicle_Percent_Marital_Equity_to_Op6" value="<?php if(isset($drvehicles->Op_Vehicle_Percent_Marital_Equity_to_Op6)){ echo $drvehicles->Op_Vehicle_Percent_Marital_Equity_to_Op6; } ?>" min="0.00" step="0.01" max="100" readonly="">
                                </div>
                                <div class="form-group col-sm-6 Op_Vehicle_Owned6_Div Op_Vehicle_Paying_Party6_Inputs_Div" style="display: none;">
                                    <label>How much is to be paid to {{$opponent_name}}?</label>
                                    <input id="Op_Vehicle_Estimated_Value_to_Op6" type="number" class="form-control 6_Op_opponentamount_input opponentamount_input" name="Op_Vehicle_Estimated_Value_to_Op6" value="<?php if(isset($drvehicles->Op_Vehicle_Estimated_Value_to_Op6)){ echo $drvehicles->Op_Vehicle_Estimated_Value_to_Op6; } ?>" min="0.00" step="0.01" max="999999.99" readonly="" onchange="getEstimatedValueOp(this, '6', 'Op');" onkeyup="getEstimatedValueOp(this, '6', 'Op');">
                                </div>
                                <!-- end of slider tool -->
                                <div class="form-group col-sm-6 Op_Vehicle_Paying_Party6_Leased_Div" style="display: none;">
                                    <label for="Op_Vehicle_Lease_Company6">Name of vehicle lease company?</label>
                                    <input id="Op_Vehicle_Lease_Company6" type="text" class="form-control 6_Op_vehicles_inputs Op_Vehicle_Paying_Party6_Leased_Input" name="Op_Vehicle_Lease_Company6" value="<?php if(isset($drvehicles->Op_Vehicle_Lease_Company6)){ echo $drvehicles->Op_Vehicle_Lease_Company6; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6 Op_Vehicle_Paying_Party6_Leased_Div" style="display: none;">
                                    <label>Monthly lease payment for this vehicle?</label>
                                    <input id="Op_Vehicle_Monthly_Lease_Amount6" type="number" class="form-control 6_Op_vehicles_inputs Op_Vehicle_Paying_Party6_Leased_Input" name="Op_Vehicle_Monthly_Lease_Amount6" value="<?php if(isset($drvehicles->Op_Vehicle_Monthly_Lease_Amount6)){ echo $drvehicles->Op_Vehicle_Monthly_Lease_Amount6; } ?>" min="0.00" step="0.01" max="999999.99">
                                </div>
                                <div class="form-group col-sm-6 Op_Vehicle_Paying_Party6_Leased_Div" style="display: none;">
                                    <label>How will this leased vehicle be handled?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Op_Vehicle_Lease_Disposition_Method6_Terminate_Lease" name="Op_Vehicle_Lease_Disposition_Method6" value="Terminate Lease" <?php if(isset($drvehicles->Op_Vehicle_Lease_Disposition_Method6) && $drvehicles->Op_Vehicle_Lease_Disposition_Method6=='Terminate Lease'){ echo "checked"; } ?>> Terminate Lease</label>
                                        <label><input type="radio" id="Op_Vehicle_Lease_Disposition_Method6_Transfer_Lease_Responsibility_to_ClientName" name="Op_Vehicle_Lease_Disposition_Method6" value="Transfer Lease Responsibility to {{$client_name}}" <?php if(isset($drvehicles->Op_Vehicle_Lease_Disposition_Method6) && $drvehicles->Op_Vehicle_Lease_Disposition_Method6=='Transfer Lease Responsibility to '.$client_name.''){ echo "checked"; } ?>> Transfer Lease Responsibility to {{$client_name}}</label>
                                        <label><input type="radio" id="Op_Vehicle_Lease_Disposition_Method6_Transfer_Lease_Responsibility_to_OpName" name="Op_Vehicle_Lease_Disposition_Method6" value="Transfer Lease Responsibility to {{$opponent_name}}" <?php if(isset($drvehicles->Op_Vehicle_Lease_Disposition_Method6) && $drvehicles->Op_Vehicle_Lease_Disposition_Method6=='Transfer Lease Responsibility to '.$opponent_name.''){ echo "checked"; } ?>> Transfer Lease Responsibility to {{$opponent_name}}</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- End of Opponent Vehicles Info Section -->
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

    function getAnyVehicle(vehicle){
        if(vehicle.checked){
            $('#Num_Joint_Vehicles, #Num_Client_Vehicles, #Num_Op_Vehicles').val('0');
            $('.Num_Joint_Vehicles, .Num_Client_Vehicles, .Num_Op_Vehicles').show();
        } else {
            $('#Num_Joint_Vehicles, #Num_Client_Vehicles, #Num_Op_Vehicles').val('0');
            $('.Num_Joint_Vehicles, .Num_Client_Vehicles, .Num_Op_Vehicles').hide();
            $('.Joint_vehicles_section input, .Client_vehicles_section input, .Op_vehicles_section input').prop('required',false);
            $('.1_Joint_vehicles_section, .2_Joint_vehicles_section, .3_Joint_vehicles_section, .4_Joint_vehicles_section, .5_Joint_vehicles_section, .6_Joint_vehicles_section').hide();
            $('.1_Client_vehicles_section, .2_Client_vehicles_section, .3_Client_vehicles_section, .4_Client_vehicles_section, .5_Client_vehicles_section, .6_Client_vehicles_section').hide();
            $('.1_Op_vehicles_section, .2_Op_vehicles_section, .3_Op_vehicles_section, .4_Op_vehicles_section, .5_Op_vehicles_section, .6_Op_vehicles_section').hide();
        }
    }

    function getInitialVehicleOwnedLeased(vehicle, vehiclenum, vehicletype){
        if(vehicle.value=='Leased' && vehicle.checked){
            $('.'+vehicletype+'_Vehicle_Paying_Party'+vehiclenum+'_Leased_Div').show();
            $('.'+vehicletype+'_Vehicle_Owned'+vehiclenum+'_Div').hide();
        } 
        if(vehicle.value=='Owned' && vehicle.checked) {
            $('.'+vehicletype+'_Vehicle_Paying_Party'+vehiclenum+'_Leased_Div').hide();
            $('.'+vehicletype+'_Vehicle_Owned'+vehiclenum+'_Div').show();
            // $("input[name='"+vehicletype+'_Vehicle_Disposition_Method'+vehiclenum+"']").prop('checked', false);
        }
    }

    function getVehicleOwnedLeased(vehicle, vehiclenum, vehicletype){
        if(vehicle.value=='Leased' && vehicle.checked){
            $('.'+vehicletype+'_Vehicle_Paying_Party'+vehiclenum+'_Leased_Div').show();
            $('.'+vehicletype+'_Vehicle_Owned'+vehiclenum+'_Div').hide();
            $('#'+vehicletype+'_Vehicle_Monthly_Lease_Amount'+vehiclenum+'').val('0.00');
        } else {
            $('.'+vehicletype+'_Vehicle_Paying_Party'+vehiclenum+'_Leased_Div').hide();
            $('#'+vehicletype+'_Vehicle_Monthly_Lease_Amount'+vehiclenum+'').val('');
            $('.'+vehicletype+'_Vehicle_Owned'+vehiclenum+'_Div').show();
            $("input[name='"+vehicletype+'_Vehicle_Disposition_Method'+vehiclenum+"']").prop('checked', false);
            if($("input[name='"+vehicletype+'_Vehicle_SoleSeparate_Claim'+vehiclenum+"']:checked").val()=='No'){
                $('#'+vehicletype+'_Vehicle_SoleSeparate_Party'+vehiclenum+'_Div').hide();
                $('#'+vehicletype+'_Vehicle_SoleSeparate_Grounds'+vehiclenum+'_Div').hide();
                $('#'+vehicletype+'_Vehicle_SoleSeparate_Grounds'+vehiclenum+'').val('');
                $('#'+vehicletype+'_Vehicle_SoleSeparate_Party'+vehiclenum+'').prop('checked', false);
                $('.'+vehiclenum+'_'+vehicletype+'_Slider_Tool').show();
                $('.'+vehicletype+'_Vehicle_Paying_Party'+vehiclenum+'_Inputs_Div').hide();
                $('.'+vehicletype+'_Vehicle_Paying_Party'+vehiclenum+'_Inputs_Div input[type=number]').prop('readonly', true);
            } else {
                $('#'+vehicletype+'_Vehicle_SoleSeparate_Party'+vehiclenum+'_Div').show();
                $('#'+vehicletype+'_Vehicle_SoleSeparate_Grounds'+vehiclenum+'_Div').show();
                $('.'+vehiclenum+'_'+vehicletype+'_Slider_Tool').hide();
                $('.'+vehicletype+'_Vehicle_Paying_Party'+vehiclenum+'_Inputs_Div').show();
                $('.'+vehicletype+'_Vehicle_Paying_Party'+vehiclenum+'_Inputs_Div input[type=number]').prop('readonly', true);
            }
        }
    }
     
    function getCurrentValue(balance, balancenum, balancetype){
        var balanceclass=balancenum+'_'+balancetype;
        $('.'+balanceclass+'_balance_range_selector, .'+balanceclass+'_opponentpercentage_input, .'+balanceclass+'_clientpercentage_input').val('50.00');
        $('.'+balanceclass+'_opponentpercentage_div, .'+balanceclass+'_clientpercentage_div').text('50.00%');

        var current_balance=parseFloat(balance.value).toFixed(2);
        if(current_balance && current_balance > 0){
        } else {
            current_balance=0.00;
        }
        var loan_balance=$('#'+balancetype+'_Vehicle_Loan_Balance'+balancenum+'').val();
        if(loan_balance && loan_balance > 0){
            loan_balance=parseFloat(loan_balance).toFixed(2);
        } else {
            loan_balance=0.00;
        }
        var company_balance=$('#'+balancetype+'_Vehicle_Loan_Second_Company_Balance'+balancenum+'').val();
        if(company_balance && company_balance > 0){
            company_balance=parseFloat(company_balance).toFixed(2);
        } else {
            company_balance=0.00;
        }
        var total_balance=((current_balance)-(loan_balance))-(company_balance);
        total_balance=parseFloat(total_balance).toFixed(2);
        $('#'+balancetype+'_Vehicle_Marital_Equity'+balancenum+'').val(total_balance);

        var client_balance_amount=total_balance/2;
        var opponent_balance_amount=total_balance/2;
        client_balance_amount=parseFloat(client_balance_amount).toFixed(2);
        opponent_balance_amount=parseFloat(opponent_balance_amount).toFixed(2);
        $('.'+balanceclass+'_clientamount_input').val(client_balance_amount);
        $('.'+balanceclass+'_opponentamount_input').val(opponent_balance_amount);
        $('.'+balanceclass+'_clientamount_div').text(formatter.format(client_balance_amount));
        $('.'+balanceclass+'_opponentamount_div').text(formatter.format(opponent_balance_amount));
    }

    function getLoanBalance(balance, balancenum, balancetype){
        var balanceclass=balancenum+'_'+balancetype;
        $('.'+balanceclass+'_balance_range_selector, .'+balanceclass+'_opponentpercentage_input, .'+balanceclass+'_clientpercentage_input').val('50.00');
        $('.'+balanceclass+'_opponentpercentage_div, .'+balanceclass+'_clientpercentage_div').text('50.00%');

        var loan_balance=parseFloat(balance.value).toFixed(2);
        if(loan_balance && loan_balance > 0){
        } else {
            loan_balance=0.00;
        }
        var current_balance=$('#'+balancetype+'_Vehicle_Current_Value'+balancenum+'').val();
        if(current_balance && current_balance > 0){
            current_balance=parseFloat(current_balance).toFixed(2);
        } else {
            current_balance=0.00;
        }
        var company_balance=$('#'+balancetype+'_Vehicle_Loan_Second_Company_Balance'+balancenum+'').val();
        if(company_balance && company_balance > 0){
            company_balance=parseFloat(company_balance).toFixed(2);
        } else {
            company_balance=0.00;
        }
        var total_balance=((current_balance)-(loan_balance))-(company_balance);
        total_balance=parseFloat(total_balance).toFixed(2);
        $('#'+balancetype+'_Vehicle_Marital_Equity'+balancenum+'').val(total_balance);

        var client_balance_amount=total_balance/2;
        var opponent_balance_amount=total_balance/2;
        client_balance_amount=parseFloat(client_balance_amount).toFixed(2);
        opponent_balance_amount=parseFloat(opponent_balance_amount).toFixed(2);
        $('.'+balanceclass+'_clientamount_input').val(client_balance_amount);
        $('.'+balanceclass+'_opponentamount_input').val(opponent_balance_amount);
        $('.'+balanceclass+'_clientamount_div').text(formatter.format(client_balance_amount));
        $('.'+balanceclass+'_opponentamount_div').text(formatter.format(opponent_balance_amount));
    }

    function getCompanyBalance(balance, balancenum, balancetype){
        var balanceclass=balancenum+'_'+balancetype;
        $('.'+balanceclass+'_balance_range_selector, .'+balanceclass+'_opponentpercentage_input, .'+balanceclass+'_clientpercentage_input').val('50.00');
        $('.'+balanceclass+'_opponentpercentage_div, .'+balanceclass+'_clientpercentage_div').text('50.00%');

        var company_balance=parseFloat(balance.value).toFixed(2);
        if(company_balance && company_balance > 0){
        } else {
            company_balance=0.00;
        }
        var loan_balance=$('#'+balancetype+'_Vehicle_Loan_Balance'+balancenum+'').val();
        if(loan_balance && loan_balance > 0){
            loan_balance=parseFloat(loan_balance).toFixed(2);
        } else {
            loan_balance=0.00;
        }
        var current_balance=$('#'+balancetype+'_Vehicle_Current_Value'+balancenum+'').val();
        if(current_balance && current_balance > 0){
            current_balance=parseFloat(current_balance).toFixed(2);
        } else {
            current_balance=0.00;
        }
        var total_balance=((current_balance)-(loan_balance))-(company_balance);
        total_balance=parseFloat(total_balance).toFixed(2);
        $('#'+balancetype+'_Vehicle_Marital_Equity'+balancenum+'').val(total_balance);

        var client_balance_amount=total_balance/2;
        var opponent_balance_amount=total_balance/2;
        client_balance_amount=parseFloat(client_balance_amount).toFixed(2);
        opponent_balance_amount=parseFloat(opponent_balance_amount).toFixed(2);
        $('.'+balanceclass+'_clientamount_input').val(client_balance_amount);
        $('.'+balanceclass+'_opponentamount_input').val(opponent_balance_amount);
        $('.'+balanceclass+'_clientamount_div').text(formatter.format(client_balance_amount));
        $('.'+balanceclass+'_opponentamount_div').text(formatter.format(opponent_balance_amount));
    }

    function getInitialPartyClaimSoleSeparate(claim, claimnum, claimtype){
        if(claim.value=='No' && claim.checked){
            $('#'+claimtype+'_Vehicle_SoleSeparate_Party'+claimnum+'_Div').hide();
            $('#'+claimtype+'_Vehicle_SoleSeparate_Grounds'+claimnum+'_Div').hide();
            $('#'+claimtype+'_Vehicle_SoleSeparate_Grounds'+claimnum+'').val('');
            $('#'+claimtype+'_Vehicle_SoleSeparate_Party'+claimnum+'').prop('checked', false);
            $('.'+claimnum+'_'+claimtype+'_Slider_Tool').show();
            $('.'+claimtype+'_Vehicle_Paying_Party'+claimnum+'_Inputs_Div').hide();
            $('.'+claimtype+'_Vehicle_Paying_Party'+claimnum+'_Inputs_Div input[type=number]').prop('readonly', true);
        } 
        if(claim.value=='Yes' && claim.checked){
            $('#'+claimtype+'_Vehicle_SoleSeparate_Party'+claimnum+'_Div').show();
            $('#'+claimtype+'_Vehicle_SoleSeparate_Grounds'+claimnum+'_Div').show();
            $('.'+claimnum+'_'+claimtype+'_Slider_Tool').hide();
            $('.'+claimtype+'_Vehicle_Paying_Party'+claimnum+'_Inputs_Div').show();
            $('.'+claimtype+'_Vehicle_Paying_Party'+claimnum+'_Inputs_Div input[type=number]').prop('readonly', true);
        }
    }

    function getPartyClaimSoleSeparate(claim, claimnum, claimtype){
        if(claim.value=='No'){
            $('#'+claimtype+'_Vehicle_SoleSeparate_Party'+claimnum+'_Div').hide();
            $('#'+claimtype+'_Vehicle_SoleSeparate_Grounds'+claimnum+'_Div').hide();
            $('#'+claimtype+'_Vehicle_SoleSeparate_Grounds'+claimnum+'').val('');
            $('#'+claimtype+'_Vehicle_SoleSeparate_Party'+claimnum+'').prop('checked', false);
            $('.'+claimnum+'_'+claimtype+'_Slider_Tool').show();
            $('.'+claimtype+'_Vehicle_Paying_Party'+claimnum+'_Inputs_Div').hide();
            $('.'+claimtype+'_Vehicle_Paying_Party'+claimnum+'_Inputs_Div input[type=number]').prop('readonly', true);

        } else {
            $('#'+claimtype+'_Vehicle_SoleSeparate_Party'+claimnum+'_Div').show();
            $('#'+claimtype+'_Vehicle_SoleSeparate_Grounds'+claimnum+'_Div').show();
            $('.'+claimnum+'_'+claimtype+'_Slider_Tool').hide();
            $('.'+claimtype+'_Vehicle_Paying_Party'+claimnum+'_Inputs_Div').show();
            $('.'+claimtype+'_Vehicle_Paying_Party'+claimnum+'_Inputs_Div input[type=number]').prop('readonly', true);
        }
    }

    function getInitialDipositionMethod(claim, claimnum, claimtype){
        if(claim.value=='Fixed Buyout' && claim.checked){
            $('.'+claimnum+'_'+claimtype+'_Slider_Tool').hide();
            $('.'+claimtype+'_Vehicle_Paying_Party'+claimnum+'_Inputs_Div').show();
        } 
        if(claim.value=='Liquidate/Split Net Value' && claim.checked){
            $('.'+claimnum+'_'+claimtype+'_Slider_Tool').show();
            $('.'+claimtype+'_Vehicle_Paying_Party'+claimnum+'_Inputs_Div').hide();
        }
    }

    function getDipositionMethod(claim, claimnum, claimtype){
        if(claim.value=='Fixed Buyout'){
            $('.'+claimnum+'_'+claimtype+'_Slider_Tool').hide();
            $('.'+claimtype+'_Vehicle_Paying_Party'+claimnum+'_Inputs_Div').show();
            $('.'+claimtype+'_Vehicle_Paying_Party'+claimnum+'_Inputs_Div input[type=number]').prop('readonly', true);
            $('.'+claimtype+'_Vehicle_Paying_Party'+claimnum+'_Inputs_Div input[type=radio]').prop('checked', false);
            var total_balance=$('#'+claimtype+'_Vehicle_Marital_Equity'+claimnum+'').val();
            if(total_balance && total_balance > 0){
                total_balance=parseFloat(total_balance).toFixed(2);
                var op_val=(total_balance/2);
                op_val=parseFloat(op_val).toFixed(2);
                var client_val=(total_balance)-(op_val);
                client_val=parseFloat(client_val).toFixed(2);
                $('#'+claimtype+'_Vehicle_Estimated_Value_to_Client'+claimnum+'').val(client_val);
                $('#'+claimtype+'_Vehicle_Estimated_Value_to_Op'+claimnum+'').val(op_val);
                var client_percentage=(client_val/total_balance)*(100).toFixed(2);
                client_percentage=parseFloat(client_percentage).toFixed(2);
                var op_percentage=(100-client_percentage).toFixed(2);
                op_percentage=parseFloat(op_percentage).toFixed(2);
                $('#'+claimtype+'_Vehicle_Percent_Marital_Equity_to_Client'+claimnum+'').val(client_percentage);
                $('#'+claimtype+'_Vehicle_Percent_Marital_Equity_to_Op'+claimnum+'').val(op_percentage);
                $('.'+claimnum+'_'+claimtype+'_clientpercentage_div').text('50.00%');
                $('.'+claimnum+'_'+claimtype+'_opponentpercentage_div').text('50.00%');
                $('.'+claimnum+'_'+claimtype+'_clientamount_div').text(formatter.format(client_val));
                $('.'+claimnum+'_'+claimtype+'_opponentamount_div').text(formatter.format(op_val));
            }else {
                $('#'+claimtype+'_Vehicle_Estimated_Value_to_Client'+claimnum+'').val('0.00');
                $('#'+claimtype+'_Vehicle_Estimated_Value_to_Op'+claimnum+'').val('0.00');
                $('#'+claimtype+'_Vehicle_Percent_Marital_Equity_to_Client'+claimnum+'').val('0.00');
                $('#'+claimtype+'_Vehicle_Percent_Marital_Equity_to_Op'+claimnum+'').val('0.00');
                $('.'+claimnum+'_'+claimtype+'_clientpercentage_div').text('50.00%');
                $('.'+claimnum+'_'+claimtype+'_opponentpercentage_div').text('50.00%');
                $('.'+claimnum+'_'+claimtype+'_clientamount_div').text('0.00');
                $('.'+claimnum+'_'+claimtype+'_opponentamount_div').text('0.00');
            }

        } else {
            $('.'+claimnum+'_'+claimtype+'_Slider_Tool').show();
            $('.'+claimtype+'_Vehicle_Paying_Party'+claimnum+'_Inputs_Div').hide();
            $('.'+claimtype+'_Vehicle_Paying_Party'+claimnum+'_Inputs_Div input[type=number]').prop('readonly', true);
            $('.'+claimtype+'_Vehicle_Paying_Party'+claimnum+'_Inputs_Div input[type=radio]').prop('checked', false);
            var total_balance=$('#'+claimtype+'_Vehicle_Marital_Equity'+claimnum+'').val();
            if(total_balance && total_balance > 0){
                total_balance=parseFloat(total_balance).toFixed(2);
                var half_current_val=total_balance/2;
                half_current_val=parseFloat(half_current_val).toFixed(2);
                $('.'+claimnum+'_'+claimtype+'_clientamount_input').val(half_current_val);
                $('.'+claimnum+'_'+claimtype+'_opponentamount_input').val(half_current_val);
                $('.'+claimnum+'_'+claimtype+'_clientpercentage_input, .'+claimnum+'_'+claimtype+'_opponentpercentage_input, .'+claimnum+'_'+claimtype+'_balance_range_selector').val('50.00');
                $('.'+claimnum+'_'+claimtype+'_clientpercentage_div, .'+claimnum+'_'+claimtype+'_opponentpercentage_div').text('50.00%');
                $('.'+claimnum+'_'+claimtype+'_clientamount_div, .'+claimnum+'_'+claimtype+'_opponentamount_div').text(formatter.format(half_current_val));
            }
        }
    }

    function updateBalanceInput(value, balancenum, balancetype){
        var sliderclass=balancenum+'_'+balancetype;
        if(value <= 100){
            var value=parseFloat(value).toFixed(2);
            var joint_balance=$('#'+balancetype+'_Vehicle_Marital_Equity'+balancenum+'').val();
            if(joint_balance && joint_balance > 0){
                joint_balance=parseFloat(joint_balance).toFixed(2);
            } else {
                joint_balance=0;
            }
            $('.'+sliderclass+'_opponentpercentage_input').val(value);
            $('.'+sliderclass+'_opponentpercentage_div').text(value+'%');
            var client_balance_percentage_new=100-value;
            client_balance_percentage_new=parseFloat(client_balance_percentage_new).toFixed(2);
            $('.'+sliderclass+'_clientpercentage_input').val(client_balance_percentage_new);
            $('.'+sliderclass+'_clientpercentage_div').text(client_balance_percentage_new+'%');
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

    function resetBalanceInput(value, balancenum, balancetype){
        var sliderclass=balancenum+'_'+balancetype;
        $('.'+sliderclass+'_balance_range_selector, .'+sliderclass+'_opponentpercentage_input, .'+sliderclass+'_clientpercentage_input').val('50.00');
        $('.'+sliderclass+'_opponentpercentage_div, .'+sliderclass+'_clientpercentage_div').text('50.00%');
        var joint_balance=$('#'+balancetype+'_Vehicle_Marital_Equity'+balancenum+'').val();
        if(joint_balance && joint_balance > 0){
            joint_balance=parseFloat(joint_balance).toFixed(2);
        } else {
            joint_balance=0;
        }
        client_balance=joint_balance/2;
        client_balance=parseFloat(client_balance).toFixed(2);
        $('.'+sliderclass+'_clientamount_input').val(client_balance);
        $('.'+sliderclass+'_opponentamount_input').val(client_balance);
        $('.'+sliderclass+'_clientamount_div').text(formatter.format(client_balance));
        $('.'+sliderclass+'_opponentamount_div').text(formatter.format(client_balance));
    }

    function getInitialVehiclesPayingParty(party, partynum, partytype){
        if(party.id==''+partytype+'_Vehicle_Paying_Party'+partynum+'_Client' && party.checked){
            $('.'+partytype+'_Vehicle_Paying_Party'+partynum+'_Inputs_Div').show();
            $('#'+partytype+'_Vehicle_Estimated_Value_to_Op'+partynum+'').prop('readonly', false);
            $('#'+partytype+'_Vehicle_Estimated_Value_to_Client'+partynum+'').prop('readonly', true);
        } 
        if(party.id==''+partytype+'_Vehicle_Paying_Party'+partynum+'_Op' && party.checked){
            $('.'+partytype+'_Vehicle_Paying_Party'+partynum+'_Inputs_Div').show();
            $('#'+partytype+'_Vehicle_Estimated_Value_to_Client'+partynum+'').prop('readonly', false);
            $('#'+partytype+'_Vehicle_Estimated_Value_to_Op'+partynum+'').prop('readonly', true);
        }
    }

    function getVehiclesPayingParty(party, partynum, partytype){
        if(party.id==''+partytype+'_Vehicle_Paying_Party'+partynum+'_Client'){
            $('.'+partytype+'_Vehicle_Paying_Party'+partynum+'_Inputs_Div').show();
            $('#'+partytype+'_Vehicle_Estimated_Value_to_Op'+partynum+'').prop('readonly', false);
            $('#'+partytype+'_Vehicle_Estimated_Value_to_Client'+partynum+'').prop('readonly', true);
        } else {
            $('.'+partytype+'_Vehicle_Paying_Party'+partynum+'_Inputs_Div').show();
            $('#'+partytype+'_Vehicle_Estimated_Value_to_Client'+partynum+'').prop('readonly', false);
            $('#'+partytype+'_Vehicle_Estimated_Value_to_Op'+partynum+'').prop('readonly', true);
        }
    }

    function getEstimatedValueClient(party, partynum, partytype){
        var joint_balance=$('#'+partytype+'_Vehicle_Marital_Equity'+partynum+'').val();
        if(joint_balance && joint_balance > 0){
            joint_balance=parseFloat(joint_balance).toFixed(2);
            var client_val=party.value;
            client_val=parseFloat(client_val).toFixed(2);
            var op_val=(joint_balance)-(client_val);
            op_val=parseFloat(op_val).toFixed(2);
            $('#'+partytype+'_Vehicle_Estimated_Value_to_Op'+partynum+'').val(op_val);
            var client_percentage=(client_val/joint_balance)*(100).toFixed(2);
            client_percentage=parseFloat(client_percentage).toFixed(2);
            var op_percentage=(100-client_percentage).toFixed(2);
            op_percentage=parseFloat(op_percentage).toFixed(2);
            $('#'+partytype+'_Vehicle_Percent_Marital_Equity_to_Client'+partynum+'').val(client_percentage);
            $('#'+partytype+'_Vehicle_Percent_Marital_Equity_to_Op'+partynum+'').val(op_percentage);
        }
    }

    function getEstimatedValueOp(party, partynum, partytype){
        var joint_balance=$('#'+partytype+'_Vehicle_Marital_Equity'+partynum+'').val();
        if(joint_balance && joint_balance > 0){
            joint_balance=parseFloat(joint_balance).toFixed(2);
            var op_val=party.value;
            op_val=parseFloat(op_val).toFixed(2);
            var client_val=(joint_balance)-(op_val);
            client_val=parseFloat(client_val).toFixed(2);
            $('#'+partytype+'_Vehicle_Estimated_Value_to_Client'+partynum+'').val(client_val);
            var client_percentage=(client_val/joint_balance)*(100).toFixed(2);
            client_percentage=parseFloat(client_percentage).toFixed(2);
            var op_percentage=(100-client_percentage).toFixed(2);
            op_percentage=parseFloat(op_percentage).toFixed(2);
            $('#'+partytype+'_Vehicle_Percent_Marital_Equity_to_Client'+partynum+'').val(client_percentage);
            $('#'+partytype+'_Vehicle_Percent_Marital_Equity_to_Op'+partynum+'').val(op_percentage);
        }
    }

    const formatter = new Intl.NumberFormat('en-US', {
        style: 'currency',
        currency: 'USD',
        minimumFractionDigits: 2
    });

    $(document).ready(function(){

        $('#dr_Vehicles').validate();
        $(window).keydown(function(event){
            if(event.keyCode == 13) {
              event.preventDefault();
              return false;
            }
        });

        $('[data-onload]').each(function(){
            eval($(this).data('onload'));
        });

        var any_vehicle=$('#Any_Vehicles');
        if(any_vehicle.prop("checked") == true){
            $('.Num_Joint_Vehicles, .Num_Client_Vehicles, .Num_Op_Vehicles').show();
        } else {
            $('#Num_Joint_Vehicles, #Num_Client_Vehicles, #Num_Op_Vehicles').val('0');
            $('.Num_Joint_Vehicles, .Num_Client_Vehicles, .Num_Op_Vehicles').hide();
            $('.Joint_vehicles_section input, .Client_vehicles_section input, .Op_vehicles_section input').prop('required',false);
            $('.1_Joint_vehicles_section, .2_Joint_vehicles_section, .3_Joint_vehicles_section, .4_Joint_vehicles_section, .5_Joint_vehicles_section, .6_Joint_vehicles_section').hide();
            $('.1_Client_vehicles_section, .2_Client_vehicles_section, .3_Client_vehicles_section, .4_Client_vehicles_section, .5_Client_vehicles_section, .6_Client_vehicles_section').hide();
            $('.1_Op_vehicles_section, .2_Op_vehicles_section, .3_Op_vehicles_section, .4_Op_vehicles_section, .5_Op_vehicles_section, .6_Op_vehicles_section').hide();
        }

        // on number of joint vehicles input change
        $('.1_Joint_vehicles_section, .2_Joint_vehicles_section, .3_Joint_vehicles_section, .4_Joint_vehicles_section, .5_Joint_vehicles_section, .6_Joint_vehicles_section').hide();
        if($('#Num_Joint_Vehicles').val() > 0 &&  $('#Num_Joint_Vehicles').val() <= 6 ){
            for (var i = 1; i <= $('#Num_Joint_Vehicles').val(); i++) {
                $('.'+i+'_Joint_vehicles_section').show();
                $('.'+i+'_Joint_vehicles_section input').first().prop('required',true);
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
        var val=parseInt($('#Num_Joint_Vehicles').val())+1;
        for (var i = val; i <= 6; i++) {
            $('.'+i+'_Joint_vehicles_section input').prop('required',false);
            $('.'+i+'_Joint_vehicles_section select option[value=""]').prop('selected','selected');
        }

        $('#Num_Joint_Vehicles').on('change keyup', function(){
            $('.1_Joint_vehicles_section, .2_Joint_vehicles_section, .3_Joint_vehicles_section, .4_Joint_vehicles_section, .5_Joint_vehicles_section, .6_Joint_vehicles_section').hide();
            if(this.value > 0 &&  this.value <= 6 ){
                for (var i = 1; i <= this.value; i++) {
                    $('.'+i+'_Joint_vehicles_section').show();
                    $('.'+i+'_Joint_vehicles_section input').first().prop('required',true);
                }
            }
            var val=parseInt(this.value)+1;
            for (var i = val; i <= 6; i++) {
                $('.'+i+'_Joint_vehicles_section input').prop('required',false);
                $('.'+i+'_Joint_vehicles_section select option[value=""]').prop('selected','selected');
            }
        });
        // on number of client vehicles input change
        $('.1_Client_vehicles_section, .2_Client_vehicles_section, .3_Client_vehicles_section, .4_Client_vehicles_section, .5_Client_vehicles_section, .6_Client_vehicles_section').hide();
        if($('#Num_Client_Vehicles').val() > 0 &&  $('#Num_Client_Vehicles').val() <= 6 ){
            for (var i = 1; i <= $('#Num_Client_Vehicles').val(); i++) {
                $('.'+i+'_Client_vehicles_section').show();
                $('.'+i+'_Client_vehicles_section input').first().prop('required',true);
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
        var val=parseInt($('#Num_Client_Vehicles').val())+1;
        for (var i = val; i <= 6; i++) {
            $('.'+i+'_Client_vehicles_section input').prop('required',false);
            $('.'+i+'_Client_vehicles_section select option[value=""]').prop('selected','selected');
        }
        $('#Num_Client_Vehicles').on('change keyup', function(){
            $('.1_Client_vehicles_section, .2_Client_vehicles_section, .3_Client_vehicles_section, .4_Client_vehicles_section, .5_Client_vehicles_section, .6_Client_vehicles_section').hide();
            if(this.value > 0 &&  this.value <= 6 ){
                for (var i = 1; i <= this.value; i++) {
                    $('.'+i+'_Client_vehicles_section').show();
                    $('.'+i+'_Client_vehicles_section input').first().prop('required',true);
                }
            }
            var val=parseInt(this.value)+1;
            for (var i = val; i <= 6; i++) {
                $('.'+i+'_Client_vehicles_section input').prop('required',false);
                $('.'+i+'_Client_vehicles_section select option[value=""]').prop('selected','selected');
            }
        });
        // on number of opponent vehicles input change
        $('.1_Op_vehicles_section, .2_Op_vehicles_section, .3_Op_vehicles_section, .4_Op_vehicles_section, .5_Op_vehicles_section, .6_Op_vehicles_section').hide();
        if($('#Num_Op_Vehicles').val() > 0 &&  $('#Num_Op_Vehicles').val() <= 6 ){
            for (var i = 1; i <= $('#Num_Op_Vehicles').val(); i++) {
                $('.'+i+'_Op_vehicles_section').show();
                $('.'+i+'_Op_vehicles_section input').first().prop('required',true);
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
        var val=parseInt($('#Num_Op_Vehicles').val())+1;
        for (var i = val; i <= 6; i++) {
            $('.'+i+'_Op_vehicles_section input').prop('required',false);
            $('.'+i+'_Op_vehicles_section select option[value=""]').prop('selected','selected');
        }
        $('#Num_Op_Vehicles').on('change keyup', function(){
            $('.1_Op_vehicles_section, .2_Op_vehicles_section, .3_Op_vehicles_section, .4_Op_vehicles_section, .5_Op_vehicles_section, .6_Op_vehicles_section').hide();
            if(this.value > 0 &&  this.value <= 6 ){
                for (var i = 1; i <= this.value; i++) {
                    $('.'+i+'_Op_vehicles_section').show();
                    $('.'+i+'_Op_vehicles_section input').first().prop('required',true);
                }
            }
            var val=parseInt(this.value)+1;
            for (var i = val; i <= 6; i++) {
                $('.'+i+'_Op_vehicles_section input').prop('required',false);
                $('.'+i+'_Op_vehicles_section select option[value=""]').prop('selected','selected');
            }
        });
    });
</script>   
@endsection